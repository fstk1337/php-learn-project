<?php
session_start();
require 'connect_db.php';
$email = $_POST["email"];
$sql = "SELECT email FROM `users`";
$statement = $con->prepare($sql);
$statement->execute();
$emails = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
if (in_array($email, $emails)) {
    $_SESSION["error"] = true;
    header("Location:../page_register.php");
}