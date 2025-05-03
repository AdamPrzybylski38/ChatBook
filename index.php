<?php
session_start();
if (isset($_SESSION['id_user'])) {
    header('Location: chat.php');
    exit();
}
?>

<!doctype html>
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
        <div class="container mt-3">
            <h1 style="color: #007bff; font-size: 2.5rem; text-align: center;">
                <img src="chbk_logo.svg" alt="ChatBook Logo"
                    style="width: 5rem; height: 5rem; margin-right: 0.5rem; vertical-align: middle;">
                ChatBook
                <span class="header-badge">v0.04</span>
            </h1>
        </div>
    </header>

    <main class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div id="loginForm" style="display: block;">
                    <h3>Logowanie</h3>
                    <form action="login.php" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Hasło</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Zaloguj</button>

                        <button id="registerBtn" class="btn btn-success">Zarejestruj się</button>
                    </form>

                    <hr>

                </div>

                <div id="registrationForm" style="display: none;">
                    <h3>Rejestracja</h3>
                    <form action="register.php" method="post">
                        <div class="mb-3">
                            <label for="email-reg" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email-reg" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Nazwa użytkownika</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password-reg" class="form-label">Hasło</label>
                            <input type="password" class="form-control" id="password-reg" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Powtórz hasło</label>
                            <input type="password" class="form-control" id="confirm-password" name="confirm_password"
                                required>
                        </div>
                        <button type="submit" class="btn btn-success">Zarejestruj się</button>

                        <hr>

                        <button id="loginBtn" class="btn btn-primary">Wróć do logowania</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer></footer>
    <div class="footer">
        Model: meta-llama-3.1-8b-instruct  
    </div>
    </footer>

    <script>
        $(document).ready(function () {
            $('#registerBtn').click(function () {
                $('#loginForm').hide();
                $('#registrationForm').show();
            });

            $('#loginBtn').click(function () {
                $('#registrationForm').hide();
                $('#loginForm').show();
            });
        });
    </script>
</body>

</html>