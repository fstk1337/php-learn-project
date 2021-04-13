<?php
session_start();
require 'functions.php';
$con = connect();
$email = $_POST["email"];
$emails = getEmails($con);

if (in_array($email, $emails)) {
    $_SESSION["danger"] = "<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.";
    header("Location:../page_register.php");
} else {
    $pass = $_POST["password"];
    makeRecord($con, $email, $pass);
    $_SESSION["success"] = "Регистрация успешна";
    header("Location:../page_login.php");
}