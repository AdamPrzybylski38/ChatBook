<?php
session_start();
require 'connect.php';

if (isset($_SESSION['id_activity'])) {
    $stmt = $connect->prepare("UPDATE activity SET logout = NOW() WHERE id_activity = :id");
    $stmt->execute(['id' => $_SESSION['id_activity']]);
}

session_unset();
session_destroy();

header('Location: index.php');
exit();
?>
