<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $stmt = $connect->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];

            $insert = $connect->prepare("INSERT INTO activity (id_user) VALUES (:id_user) RETURNING id_activity");
            $insert->execute(['id_user' => $user['id_user']]);
            $_SESSION['id_activity'] = $insert->fetchColumn();

            header('Location: chat.php');
            exit();
        } else {
            $_SESSION['login_error'] = 'Nieprawidłowe hasło.';
            header('Location: index.php');
            exit();
        }
    } else {
        $_SESSION['login_error'] = 'Użytkownik o podanym adresie email nie istnieje.';
        header('Location: index.php');
        exit();
    }
}
?>
