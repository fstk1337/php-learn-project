<?php

function connect()
{
    return new PDO("mysql:host=localhost;dbname=project_db;charset=utf8", 'root', 'root');
}

function set_value($id, $field, $value) {
    $connection = connect();
    $sql = "UPDATE users SET " . $field . " = :value WHERE id = " . $id;
    $statement = $connection->prepare($sql);
    $statement->execute(array("value" => $value));
}

function get_value($field, $value)
{
    $connection = connect();
    $sql = "SELECT * FROM users WHERE " . $field . " = :value";
    $statement = $connection->prepare($sql);
    $statement->execute(array("value" => $value));
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function get_user_by_id($id) {
    return get_value("id", $id);
}

function create_user($email, $password) {
    $connection = connect();
    $sql = "INSERT INTO users (email, password, role) VALUES (:email, :password, :role)";
    $statement = $connection->prepare($sql);
    $statement->execute(array("email" => $email, "password" => password_hash($password, PASSWORD_DEFAULT), "role" => "user"));
    return get_value("email", $email)["id"];
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

function login($email, $password) {
    $connection = connect();
    $sql = "SELECT id, password FROM users WHERE email = :email";
    $statement = $connection->prepare($sql);
    $statement->execute(array("email" => $email));
    $data = $statement->fetchAll(PDO::FETCH_ASSOC)[0];
    $id = $data["id"];
    $hash = $data["password"];
    if (password_verify($password, $hash)) {
        $_SESSION["id"] = $id;
        $_SESSION["email"] = $email;
    }
    return password_verify($password, $hash);
}

function is_not_logged_in() {
    return(!isset($_SESSION["id"]));
}

function get_user_id() {
    if(isset($_SESSION["id"])) {
        return $_SESSION["id"];
    }
    return 0;
}

function is_admin($id) {
    $connection = connect();
    $sql = "SELECT role FROM users WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->execute(array("id" => $id));
    $role = $statement->fetchAll(PDO::FETCH_COLUMN, 0)[0];
    return ($role == "admin");
}

function get_all_users() {
    $connection = connect();
    $sql = "SELECT * FROM users";
    $statement = $connection->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function is_free($email) {
    $find = get_value("email", $email);
    return empty($find);
}

function edit_user_info($id, $name, $workplace, $phone, $address, $status, $avatar, $vklink, $tglink, $instalink) {
    edit_general_info($id, $name, $workplace, $phone, $address);
    set_status($id, $status);
    load_avatar($id, $avatar);
    add_social_links($id, $vklink, $tglink, $instalink);
}

function edit_general_info($id, $name, $workplace, $phone, $address) {
    set_value($id, "name", $name);
    set_value($id, "workplace", $workplace);
    set_value($id, "phone", $phone);
    set_value($id, "address", $address);
}

function set_status($id, $status) {
    $value = "";
    switch ($status) {
        case "Онлайн":
            $value = "success";
            break;
        case "Отошел":
            $value = "warning";
            break;
        case "Не беспокоить":
            $value = "danger";
            break;
    }
    set_value($id, "status", $value);
}

function load_avatar($id, $avatar) {
    $dir = 'img/demo/avatars/';
    $filepath = $dir . uniqid() . $avatar["name"];
    if (move_uploaded_file($avatar['tmp_name'], $filepath)) {
        set_value($id, "avatar", $filepath);
    }
}

function add_social_links($id, $vklink, $tglink, $instalink) {
    set_value($id, "vklink", $vklink);
    set_value($id, "tglink", $tglink);
    set_value($id, "instalink", $instalink);
}

function print_phone($phone) {
    echo sprintf("%s %s-%s-%s", substr($phone, 0, 2), substr($phone, 2, 3), substr($phone, 5, 3), substr($phone, 8, strlen($phone) - 8));
}

function set_credentials($id, $email, $password) {
    set_value($id, "email", $email);
    set_value($id, "password", password_hash($password, PASSWORD_DEFAULT));
}

function status_is_active($id, $status) {
    $user = get_user_by_id($id);
    $value = "";
    switch ($status) {
        case "Онлайн":
            $value = "success";
            break;
        case "Отошел":
            $value = "warning";
            break;
        case "Не беспокоить":
            $value = "danger";
            break;
    }
    return $user["status"] == $value;
}

function has_image($id) {
    $user = get_user_by_id($id);
    if ($user["avatar"] == null) {
        return false;
    }
    return file_exists($user["avatar"]);
}