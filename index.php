<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = escapeshellarg($_POST['query']);
    $command = "source /Applications/XAMPP/xamppfiles/htdocs/ChatBook/chbk-env/bin/activate && python3 connect.py " . $query . " 2>&1";
    $output = shell_exec($command);
    echo json_encode(['response' => nl2br(htmlspecialchars($output))]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f8f9fa;
            padding-top: 2rem;
            line-height: 1.6;
            color: #333;
        }

        .chat-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: calc(100vh - 10rem);
            width: 100%;
        }

        #response-box {
            width: 80%;
            max-width: 800px;
            min-height: 400px;
            max-height: 500px;
            overflow-y: auto;
            padding: 1rem;
            border-radius: 1rem;
            background-color: #ffffff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .input-group {
            width: 80%;
            max-width: 600px;
            margin-top: 1rem;
        }

        .message-user {
            margin-left: auto;
            width: fit-content;
            text-align: right;
            color: #333;
            background-color:rgb(150, 200, 255);
            padding: 0.5rem;
            border-radius: 1rem 0 1rem 1rem;
            margin-bottom: 0.5rem;
        }

        .message-ai {
            margin-right: auto;
            width: fit-content;
            text-align: left;
            color: #333;
            background-color: #e7f2fe;
            padding: 0.5rem;
            border-radius: 0 1rem 1rem 1rem;
            margin-bottom: 0.5rem;
        }

        .loading-dots {
            display: none;
            margin-right: auto;
            width: fit-content;
            text-align: left;
            color: #333;
            background-color: transparent;
            padding: 0.5rem;
            border-radius: 0 1rem 1rem 1rem;
            margin-bottom: 0.5rem;
        }

        .loading-dots span {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #333;
            animation: dot-blink 1s ease-in-out infinite;
        }

        .loading-dots span:nth-child(2) {
            animation-delay: 0.3s;
        }

        .loading-dots span:nth-child(3) {
            animation-delay: 0.6s;
        }

        @keyframes dot-blink {
            0%, 100% {
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
        }

        .header-badge {
            background-color: #007bff;
            color: white;
            font-size: 0.8rem;
            padding: 0.2rem 0.6rem;
            border-radius: 1rem;
            display: inline-block;
            margin-left: 0.5rem;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #e7f2fe;
            text-align: center;
            padding: 1rem 0;
            border-top: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <header>
        <div class="container mt-3">
            <h1 style="color: #007bff; font-size: 2.5rem; text-align: center;">ChatBook
                <span class="header-badge">v0.02</span>
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
            Aplikacja w fazie testowej<br>
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

                $.post("index.php", { query: query }, function (data) {
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
