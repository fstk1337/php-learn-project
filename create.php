<?php
    session_start();
    require 'functions.php';
    if (!is_free($_POST["email"])) {
        set_message("danger", "Введенный email уже занят. Пожалуйста, введите другой.");
        redirect("create_user.php");
        die;
    }
    $id = create_user($_POST["email"], $_POST["password"]);
    edit_user_info($id, $_POST["name"], $_POST["workplace"], $_POST["phone"], $_POST["address"], $_POST["status"], $_FILES["avatar"], $_POST["vklink"], $_POST["tglink"], $_POST["instalink"]);
    set_message("success", "Пользователь успешно добавлен.");
    redirect("users.php");