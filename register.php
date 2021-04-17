<?php
session_start();
require 'functions.php';
$email = $_POST["email"];
$password = $_POST["password"];

if (!empty(get_value("email", $email))) {
    set_message("danger", "<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.");
    redirect("page_register.php");
} else {
    create_user($email, $password);
    set_message("success", "Регистрация успешна");
    redirect("page_login.php");
}