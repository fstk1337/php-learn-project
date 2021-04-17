<?php

function connect()
{
    return new PDO("mysql:host=localhost;dbname=project_db;charset=utf8", 'root', 'root');
}

function get_value($field, $value)
{
    $connection = connect();
    $sql = "SELECT * FROM users WHERE " . $field . " = :value";
    $statement = $connection->prepare($sql);
    $statement->execute(array("value" => $value));
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function create_user($email, $password)
{
    $connection = connect();
    $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
    $statement = $connection->prepare($sql);
    $statement->execute(array("email" => $email, "password" => password_hash($password, PASSWORD_DEFAULT)));
}

function set_message($name, $text) {
    $_SESSION[$name] = $text;
}

function send_message($name) {
    echo $_SESSION[$name];
    unset($_SESSION[$name]);
}

function redirect($path) {
    header("Location:" . $path);
}