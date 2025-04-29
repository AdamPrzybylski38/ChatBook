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

    $query_check_email = "SELECT * FROM users WHERE email = ?";
    $stmt_check_email = mysqli_prepare($connect, $query_check_email);
    mysqli_stmt_bind_param($stmt_check_email, 's', $email);
    mysqli_stmt_execute($stmt_check_email);
    $result_check_email = mysqli_stmt_get_result($stmt_check_email);

    if (mysqli_num_rows($result_check_email) > 0) {
        echo "Email już jest używany.";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query_insert_user = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
    $stmt_insert_user = mysqli_prepare($connect, $query_insert_user);
    mysqli_stmt_bind_param($stmt_insert_user, 'sss', $email, $username, $hashed_password);

    if (mysqli_stmt_execute($stmt_insert_user)) {
        $_SESSION['id_user'] = mysqli_insert_id($connect);
        $_SESSION['username'] = $username;
        header('Location: chat.php');
        exit();
    } else {
        echo "Błąd podczas rejestracji.";
    }

    mysqli_stmt_close($stmt_check_email);
    mysqli_stmt_close($stmt_insert_user);
}
?>