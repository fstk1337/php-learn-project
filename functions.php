<?php

function connect()
{
    return new PDO("mysql:host=localhost;dbname=projectdb;charset=utf8", 'root', 'root');
}

function getEmails($con)
{
    $sql = "SELECT email FROM `users`";
    $statement = $con->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_COLUMN, 0);
}

function makeRecord($con, $email, $pass)
{
    $sql = "INSERT INTO `users` (email, password) VALUES (:email, :pass)";
    $statement = $con->prepare($sql);
    $statement->execute(array(':email' => $email, ':pass' => $pass));
}