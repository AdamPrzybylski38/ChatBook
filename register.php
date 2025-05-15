<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $email = $_POST['email'];
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $confirm_password = htmlspecialchars($_POST['confirm_password']);

        if ($password !== $confirm_password) {
            throw new Exception('Hasła nie są identyczne.');
        }

        $stmt = $connect->prepare("SELECT register_user(:email, :username, :password) AS id_user");
        $stmt->execute([
            'email' => $email,
            'username' => $username,
            'password' => $password
        ]);

        $_SESSION['id_user'] = $stmt->fetchColumn();
        $_SESSION['username'] = $username;

        $stmt = $connect->prepare("SELECT id_activity FROM activity WHERE id_user = :id_user ORDER BY id_activity DESC LIMIT 1");
        $stmt->execute(['id_user' => $_SESSION['id_user']]);
        $_SESSION['id_activity'] = $stmt->fetchColumn();

        header('Location: interests.php');
        exit();
    } catch (PDOException $e) {
        if ($e->getCode() === 'P0001' && str_contains($e->getMessage(), 'EMAIL_TAKEN')) {
            $_SESSION['register_error'] = 'Email już jest używany.';
        } else {
            $_SESSION['register_error'] = 'Błąd rejestracji.';
        }
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['register_error'] = $e->getMessage();
        header('Location: index.php');
        exit();
    }
}