<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];

            $insert = "INSERT INTO activity (id_user) VALUES (?)";
            $insert_stmt = mysqli_prepare($connect, $insert);
            mysqli_stmt_bind_param($insert_stmt, 'i', $user['id_user']);
            mysqli_stmt_execute($insert_stmt);

            $_SESSION['id_activity'] = mysqli_insert_id($connect);

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

    mysqli_stmt_close($stmt);
}
?>