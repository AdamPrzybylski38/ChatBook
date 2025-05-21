<?php
session_start();
require 'connect.php';

//sprawdzenie czy użytkownik jest zalogowany
if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

$id_user = $_SESSION['id_user'];

//obsługa zapisu zainteresowań
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //zapisanie zainteresowań w formie tablicy
    $interests = isset($_POST['interests']) ? array_map('intval', $_POST['interests']) : [];

    //wywołanie procedury update_user_interests
    $stmt = $connect->prepare("CALL update_user_interests(:id_user, :interests)");
    $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->bindValue(':interests', '{' . implode(',', $interests) . '}', PDO::PARAM_STR);
    $stmt->execute();

    //powrót do strony chatu
    header('Location: chat.php');
    exit();
}

//pobieranie wszystkich zainteresowań
$all_interests_result = $connect->query("SELECT id_interest, name FROM interests ORDER BY name");

//pobieranie zainteresowań użytkownika
$user_interests_stmt = $connect->prepare("SELECT id_interest FROM user_interests WHERE id_user = :id_user");
$user_interests_stmt->execute(['id_user' => $id_user]);
$user_interests = $user_interests_stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!doctype html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wybierz zainteresowania</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-light">
    <header>
        <div class="container mt-3">
            <div class="text-center mb-3">
                <div class="d-inline-flex align-items-center">
                    <img src="chbk_logo.svg" alt="ChatBook Logo"
                        style="width: 3rem; height: 3rem; margin-right: 0.5rem;">
                    <h1 class="mb-0 fs-2 text-primary">
                        ChatBook <span class="header-badge">v0.08</span>
                    </h1>
                </div>
            </div>
    </header>

    <main class="container">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5 mx-auto">
            <div class="auth-box">
                <h3 class="mb-4 text-center">Wybierz swoje zainteresowania
                    <?= htmlspecialchars($_SESSION["username"]) ?></h3>
                <form method="post" action="">
                    <div class="mb-3">
                        <!-- wyświetlanie wszystkich zainteresowań -->
                        <?php while ($row = $all_interests_result->fetch(PDO::FETCH_ASSOC)): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="interests[]"
                                    value="<?= $row['id_interest'] ?>" id="int<?= $row['id_interest'] ?>"
                                    <?= in_array($row['id_interest'], $user_interests) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="int<?= $row['id_interest'] ?>">
                                    <?= htmlspecialchars($row['name']) ?>
                                </label>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="chat.php" class="btn btn-secondary">Pomiń</a>
                        <button type="submit" class="btn btn-primary">Zapisz zainteresowania</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>