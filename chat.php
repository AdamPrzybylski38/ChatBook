<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

require_once "connect.php";

if (!isset($_SESSION['id_chat']) || isset($_GET['new_chat'])) {
    $stmt = $connect->prepare("INSERT INTO chats (id_user) VALUES (:id_user) RETURNING id_chat");
    $stmt->execute(['id_user' => $_SESSION['id_user']]);
    $_SESSION['id_chat'] = $stmt->fetchColumn();

    if (isset($_GET['new_chat'])) {
        header("Location: chat.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_query = $_POST['query'];

    $stmt = $connect->prepare("SELECT prompt, completion FROM chat_history WHERE id_chat = :id_chat ORDER BY created_at ASC");
    $stmt->execute(['id_chat' => $_SESSION['id_chat']]);
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $history_json = escapeshellarg(json_encode($history, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    $escaped_query = escapeshellarg($user_query);

    //MacOS
    $command = "source chbk-env/bin/activate && python3 connect.py $escaped_query $history_json 2>&1";

    //Windows
    //$command = "python connect.py $escaped_query $history_json 2>&1";

    $output = shell_exec($command);

    if ($output === null) {
        die("Błąd wykonania skryptu Python.");
    }

    $response = nl2br(htmlspecialchars($output));

    $stmt = $connect->prepare("INSERT INTO chat_history (id_chat, prompt, completion) VALUES (:id_chat, :prompt, :completion)");
    $stmt->execute([
        'id_chat' => $_SESSION['id_chat'],
        'prompt' => $user_query,
        'completion' => $response
    ]);

    echo json_encode(['response' => $response]);
    exit();
}
?>


<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChatBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<header>
  <div class="container mt-3 position-relative">
    <div class="d-flex justify-content-between align-items-center mb-4 position-relative">

      <div class="flex-shrink-0">
        <a href="chat.php?new_chat=1" class="btn btn-outline-primary">Nowy chat</a>
      </div>

      <div class="position-absolute top-50 start-50 translate-middle-x" style="transform: translate(-50%, -50%);">
        <div class="d-flex align-items-center">
          <img src="chbk_logo.svg" alt="ChatBook Logo"
            style="width: 3rem; height: 3rem; margin-right: 0.5rem;">
          <h1 class="mb-0 fs-3" style="color: #007bff;">ChatBook
            <span class="header-badge">v0.07</span>
          </h1>
        </div>
      </div>

      <div class="d-flex align-items-center flex-shrink-0">
        <h2 class="mb-0 fs-5 me-3">Witaj, <?= htmlspecialchars($_SESSION["username"]) ?>!</h2>
        <a href="logout.php" class="btn btn-danger">Wyloguj się</a>
        <a href="interests.php" class="btn btn-outline-primary ms-3">Zainteresowania</a>
      </div>
    </div>
  </div>
</header>

<br>

<main>
   <div class="chat-container">
        <div id="response-box" class="mb-3"></div>
        <div id="suggestions" class="mb-3 d-flex flex-wrap gap-2"></div>
        <div class="input-group">
            <input type="text" name="query" id="query" class="form-control" placeholder="Wpisz zapytanie..." required>
            <button id="send-btn" class="btn btn-primary">Wyślij</button>
        </div>
    </div>
</main>

<br>

<footer>
    <div class="footer">
        Model: llama-3.2-3b-instruct
    </div>
</footer>

<script>
    $(document).ready(function () {
        function scrollToBottom() {
            const box = $('#response-box');
            box.scrollTop(box[0].scrollHeight);
        }

        function sendQuery() {
            var query = $("#query").val();
            if (!query) return;
            $("#query").val("");

            var userMessage = $('<div>', {
                class: 'message-user',
                text: query
            });
            $("#response-box").append(userMessage);

            var loadingDots = $('<div class="loading-dots"><span></span><span></span><span></span></div>');
            $("#response-box").append(loadingDots);
            loadingDots.show();
            scrollToBottom();

            $.post("chat.php", { query: query }, function (data) {
                try {
                    var response = JSON.parse(data).response;
                    loadingDots.remove();

                    var aiMessage = $('<div>', {
                        class: 'message-ai',
                        html: response
                    });
                    $("#response-box").append(aiMessage);

                    scrollToBottom();
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

        scrollToBottom();
    });
    
    $.getJSON("suggestions.php", function (suggestions) {
    if (suggestions.length > 0) {
        suggestions.forEach(function (prompt) {
            var btn = $('<button>', {
                class: 'btn btn-outline-secondary btn-sm',
                text: prompt,
                click: function () {
                    $("#query").val(prompt);
                    $("#send-btn").click();
                }
            });
            $("#suggestions").append(btn);
        });
    }
});

</script>
</body>

</html>