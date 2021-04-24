<?php
    session_start();
    require 'functions.php';
    $user = get_user_by_id($_GET["id"]);
    if (!is_free($_POST["email"]) && $user["email"] != $_POST["email"]) {
        set_message("danger", "Введенный email уже занят. Пожалуйста, введите другой email.");
        redirect("security.php?id=" . $_GET["id"]);
        die;
    }
    set_credentials($_GET["id"], $_POST["email"], $_POST["password"]);
    set_message("success", "Профиль успешно обновлен.");
    redirect("page_profile.php?id=" . $_GET["id"]);