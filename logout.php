<?php
session_start();
require 'connect.php';

if (isset($_SESSION['id_activity'])) {
    $stmt = $connect->prepare("SELECT logout_user(:id)");
    $stmt->execute(['id' => $_SESSION['id_activity']]);
}

session_unset();
session_destroy();

header('Location: index.php');
exit();