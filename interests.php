<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

$id_user = $_SESSION['id_user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delete_query = "DELETE FROM user_interests WHERE id_user = ?";
    $stmt_delete = mysqli_prepare($connect, $delete_query);
    mysqli_stmt_bind_param($stmt_delete, 'i', $id_user);
    mysqli_stmt_execute($stmt_delete);

    if (!empty($_POST['interests'])) {
        $insert_query = "INSERT INTO user_interests (id_user, id_interest) VALUES (?, ?)";
        $stmt_insert = mysqli_prepare($connect, $insert_query);
        foreach ($_POST['interests'] as $id_interest) {
            mysqli_stmt_bind_param($stmt_insert, 'ii', $id_user, $id_interest);
            mysqli_stmt_execute($stmt_insert);
        }
    }

    header('Location: chat.php');
    exit();
}

$all_interests_result = mysqli_query($connect, "SELECT id_interest, name FROM interests ORDER BY name");

$user_interests = [];
$res_user = mysqli_prepare($connect, "SELECT id_interest FROM user_interests WHERE id_user = ?");
mysqli_stmt_bind_param($res_user, 'i', $id_user);
mysqli_stmt_execute($res_user);
$result = mysqli_stmt_get_result($res_user);
while ($row = mysqli_fetch_assoc($result)) {
    $user_interests[] = $row['id_interest'];
}
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
                    <?php while ($row = mysqli_fetch_assoc($all_interests_result)): ?>
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