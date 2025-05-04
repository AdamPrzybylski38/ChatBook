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
    <style>
        .auth-box {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
        }
        main {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .footer {
            text-align: center;
            padding: 1rem;
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>

<body class="bg-light">
<header>
  <div class="container mt-3 position-relative">
    <div class="d-flex justify-content-between align-items-center mb-4 position-relative">
      <div class="position-absolute top-50 start-50 translate-middle-x" style="transform: translate(-50%, -50%);">
        <div class="d-flex align-items-center">
          <img src="chbk_logo.svg" alt="ChatBook Logo"
            style="width: 3rem; height: 3rem; margin-right: 0.5rem;">
          <h1 class="mb-0 fs-3" style="color: #007bff;">ChatBook
            <span class="header-badge">v0.05</span>
          </h1>
        </div>
      </div>
    </div>
  </div>
</header>

<main class="container">
    <div class="col-md-6 col-lg-5">
        <div id="loginForm" class="auth-box" style="display: block;">
            <h3 class="mb-4 text-center">Logowanie</h3>
            <form action="login.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Hasło</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Zaloguj</button>
                    <button id="registerBtn" type="button" class="btn btn-success">Zarejestruj się</button>
                </div>
            </form>
        </div>

        <div id="registrationForm" class="auth-box" style="display: none;">
            <h3 class="mb-4 text-center">Rejestracja</h3>
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
                    <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Zarejestruj się</button>
                    <button id="loginBtn" type="button" class="btn btn-primary">Wróć do logowania</button>
                </div>
            </form>
        </div>
    </div>
</main>

<footer>
    <div class="footer">Model: meta-llama-3.1-8b-instruct</div>
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