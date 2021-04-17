<?php
session_start();
require 'functions.php';
$email = $_POST["email"];
$password = $_POST["password"];

if (login($email, $password)) {
    redirect("users.php");
} else {
    set_message("danger", "Проверьте имя пользователя и пароль.");
    redirect("page_login.php");
}