<?php
session_start();
if (isset($_SESSION['id_user'])) {
    header('Location: chat.php');
    exit();
}

$login_error = '';
$register_error = '';
$show_register_form = false;

if (isset($_SESSION['login_error'])) {
    $login_error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

if (isset($_SESSION['register_error'])) {
    $register_error = $_SESSION['register_error'];
    $show_register_form = true;
    unset($_SESSION['register_error']);
}
?>

<!doctype html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChatBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
    </style>
</head>

<body class="bg-light">
    <header>
        <div class="container mt-3 position-relative">
            <div class="d-flex justify-content-between align-items-center mb-4 position-relative">
                <div class="position-absolute top-50 start-50 translate-middle-x"
                    style="transform: translate(-50%, -50%);">
                    <div class="d-flex align-items-center">
                        <img src="chbk_logo.svg" alt="ChatBook Logo"
                            style="width: 3rem; height: 3rem; margin-right: 0.5rem;">
                        <h1 class="mb-0 fs-3" style="color: #007bff;">ChatBook
                            <span class="header-badge">v0.07</span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="col-md-6 col-lg-5">
            <div id="loginForm" class="auth-box" style="display: <?= $show_register_form ? 'none' : 'block' ?>;">
                <h3 class="mb-4 text-center">Logowanie</h3>

                <?php if (!empty($login_error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($login_error) ?>
                    </div>
                <?php endif; ?>

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

            <div id="registrationForm" class="auth-box" style="display: <?= $show_register_form ? 'block' : 'none' ?>;">
                <h3 class="mb-4 text-center">Rejestracja</h3>
                <?php if (!empty($register_error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($register_error) ?>
                    </div>
                <?php endif; ?>
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
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Zarejestruj się</button>
                        <button id="loginBtn" type="button" class="btn btn-secondary">Wróć do logowania</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

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
