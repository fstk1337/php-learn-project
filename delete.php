<?php
    session_start();
    require 'functions.php';
    $id = $_GET["id"];
    if (is_not_logged_in()) {
        set_message("danger","Вы не вошли в систему. Пожалуйста, авторизуйтесь.");
        redirect("page_login.php");
        die;
    }
    if (!is_admin(get_user_id()) && get_user_id() != $id) {
        set_message("danger", "Вы можете редактировать только свой профиль.");
        redirect("users.php");
        die;
    }

    if (delete($id)) {
        set_message("success", "Пользователь успешно удален.");
    } else {
        set_message("danger", "Ошибка удаления пользователя.");
    }

    if (get_user_id() == $id) {
        logout();
        redirect("page_register.php");
    } else {
        redirect("users.php");
    }