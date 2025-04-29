<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = escapeshellarg($_POST['query']);
    
    $command = "source /Applications/XAMPP/xamppfiles/htdocs/ChatBook/chbk-env/bin/activate && python3 connect.py " . $query . " 2>&1";
    $output = shell_exec($command);

    $response = nl2br(htmlspecialchars($output));

    $connect = mysqli_connect("localhost", "root", "", "ChatBook");
    if (!$connect) {
        die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
    }

    $stmt = mysqli_prepare($connect, "INSERT INTO chat_history (id_user, prompt, completion) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Błąd przygotowania zapytania: " . mysqli_error($connect));
    }

    mysqli_stmt_bind_param($stmt, "iss", $_SESSION['id_user'], $query, $response);
    if (!mysqli_stmt_execute($stmt)) {
        die("Błąd wykonania zapytania: " . mysqli_stmt_error($stmt));
    }

    echo json_encode(['response' => $response]);

    mysqli_stmt_close($stmt);

    mysqli_close($connect);

    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChatBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-light">
<header>
    <div class="container mt-3 position-relative">
        <div class="d-flex justify-content-end align-items-center mb-2" style="position: absolute; right: 0; top: 0;">
            <h2 class="me-3 mb-0 fs-4">Witaj, <?= htmlspecialchars($_SESSION["username"]) ?>!</h2>
            <a href="logout.php" class="btn btn-danger">Wyloguj się</a>
        </div>

        <h1 class="text-center" style="color: #007bff; font-size: 2.5rem;">
            <img src="chbk_logo.svg" alt="ChatBook Logo"
                style="width: 5rem; height: 5rem; margin-right: 0.5rem; vertical-align: middle;">
            ChatBook
            <span class="header-badge">v0.03</span>
        </h1>
    </div>
</header>

    <main>
        <div class="chat-container">
            <div id="response-box" class="mb-3"></div>
            <div class="input-group">
                <input type="text" name="query" id="query" class="form-control" placeholder="Wpisz zapytanie..."
                    required>
                <button id="send-btn" class="btn btn-primary">Wyślij</button>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer">
            Model: meta-llama-3.1-8b-instruct
        </div>
    </footer>

    <script>
        $(document).ready(function () {
            function sendQuery() {
                var query = $("#query").val();
                if (!query) return;
                $("#query").val("");

                $("#response-box")
                    .append('<div class="message-user">' + query + '</div>');

                var loadingDots = $('<div class="loading-dots"><span></span><span></span><span></span></div>');
                $("#response-box").append(loadingDots);
                loadingDots.show();

                $.post("chat.php", { query: query }, function (data) {
                    try {
                        var response = JSON.parse(data).response;
                        loadingDots.remove();
                        $("#response-box")
                            .append('<div class="message-ai">' + response + '</div>');
                    } catch (e) {
                        loadingDots.remove();
                        $("#response-box").html("Błąd w przetwarzaniu odpowiedzi");
                    }
                });
            }

            $("#send-btn").click(sendQuery);
            $("#query").keypress(function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    sendQuery();
                }
            });

            $(window).on('load', function () {
                var responseBox = $('#response-box');
                responseBox.scrollTop(responseBox[0].scrollHeight);
            });
        });
    </script>

</body>

</html>