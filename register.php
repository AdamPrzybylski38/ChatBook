<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);

    if ($password !== $confirm_password) {
        echo "Hasła nie są identyczne.";
        exit();
    }

    $stmt = $connect->prepare("SELECT 1 FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    if ($stmt->fetch()) {
        echo "Email już jest używany.";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $connect->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password) RETURNING id_user");
    $stmt->execute([
        'email' => $email,
        'username' => $username,
        'password' => $hashed_password
    ]);

    $_SESSION['id_user'] = $stmt->fetchColumn();
    $_SESSION['username'] = $username;

    $insert = $connect->prepare("INSERT INTO activity (id_user) VALUES (:id_user) RETURNING id_activity");
    $insert->execute(['id_user' => $_SESSION['id_user']]);
    $_SESSION['id_activity'] = $insert->fetchColumn();

    header('Location: interests.php');
    exit();
}
?>
