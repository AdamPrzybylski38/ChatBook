<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $stmt = $connect->prepare("SELECT * FROM login_user(:email, :password)");
        $stmt->execute(['email' => $email, 'password' => $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['id_activity'] = $user['id_activity'];

            header('Location: chat.php');
            exit();
        }

    } catch (PDOException $e) {
        $error = $e->getMessage();
        if (str_contains($error, 'EMAIL_NOT_FOUND')) {
            $_SESSION['login_error'] = 'Użytkownik o podanym adresie email nie istnieje.';
        } elseif (str_contains($error, 'INVALID_PASSWORD')) {
            $_SESSION['login_error'] = 'Nieprawidłowe hasło.';
        } else {
            $_SESSION['login_error'] = 'Błąd logowania.';
        }

        header('Location: index.php');
        exit();
    }
}