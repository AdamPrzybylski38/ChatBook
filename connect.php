<?php
$connect = mysqli_connect("localhost", "root", "", "ChatBook");
if (!$connect) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}
?>