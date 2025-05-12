<?php
session_start();
require_once "connect.php";

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

$id_user = $_SESSION['id_user'];

$stmt = $connect->prepare("
    SELECT ps.prompt
    FROM user_interests ui
    JOIN prompt_suggestions ps ON ps.id_interest = ui.id_interest
    WHERE ui.id_user = :id_user
    ORDER BY RANDOM()
    LIMIT 3
");
$stmt->execute(['id_user' => $id_user]);
$suggestions = $stmt->fetchAll(PDO::FETCH_COLUMN);

header('Content-Type: application/json');
echo json_encode($suggestions);
?>