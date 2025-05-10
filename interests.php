<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

$id_user = $_SESSION['id_user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connect->prepare("DELETE FROM user_interests WHERE id_user = :id_user")
            ->execute(['id_user' => $id_user]);

    if (!empty($_POST['interests'])) {
        $stmt_insert = $connect->prepare("INSERT INTO user_interests (id_user, id_interest) VALUES (:id_user, :id_interest)");
        foreach ($_POST['interests'] as $id_interest) {
            $stmt_insert->execute([
                'id_user' => $id_user,
                'id_interest' => $id_interest
            ]);
        }
    }

    header('Location: chat.php');
    exit();
}

$all_interests_result = $connect->query("SELECT id_interest, name FROM interests ORDER BY name");
$user_interests_stmt = $connect->prepare("SELECT id_interest FROM user_interests WHERE id_user = :id_user");
$user_interests_stmt->execute(['id_user' => $id_user]);
$user_interests = $user_interests_stmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wybierz zainteresowania</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .auth-box {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        main {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body class="bg-light">

<main class="container">
    <div class="col-md-6 col-lg-5">
        <div class="auth-box">
            <h4 class="mb-4 text-center">Wybierz swoje zainteresowania <?= htmlspecialchars($_SESSION["username"]) ?></h4>
            <form method="post" action="">
                <div class="mb-3">
                    <?php while ($row = $all_interests_result->fetch(PDO::FETCH_ASSOC)): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="interests[]"
                                   value="<?= $row['id_interest'] ?>"
                                   id="int<?= $row['id_interest'] ?>"
                                   <?= in_array($row['id_interest'], $user_interests) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="int<?= $row['id_interest'] ?>">
                                <?= htmlspecialchars($row['name']) ?>
                            </label>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="chat.php" class="btn btn-secondary">Pomiń</a>
                    <button type="submit" class="btn btn-primary">Zapisz zainteresowania</button>
                </div>
            </form>
        </div>
    </div>
</main>

</body>
</html>
