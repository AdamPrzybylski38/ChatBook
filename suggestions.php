<?php
session_start();
require_once "connect.php";

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

$id_user = $_SESSION['id_user'];

// wywołanie funkcji get_prompt_suggestions z bazy danych
$stmt = $connect->prepare("SELECT * FROM get_prompt_suggestions(:id_user)");
$stmt->execute(['id_user' => $id_user]);
$suggestions = $stmt->fetchAll(PDO::FETCH_COLUMN);

header('Content-Type: application/json');
echo json_encode($suggestions, JSON_UNESCAPED_UNICODE);
?>