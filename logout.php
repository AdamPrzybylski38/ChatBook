<?php
session_start();
require 'connect.php';

if (isset($_SESSION['id_activity'])) {
    $id_activity = $_SESSION['id_activity'];

    $update = "UPDATE activity SET logout = NOW() WHERE id_activity = ?";
    $stmt = mysqli_prepare($connect, $update);
    mysqli_stmt_bind_param($stmt, 'i', $id_activity);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

session_unset();
session_destroy();

header('Location: index.php');
exit();
?>