<?php
    session_start();
    require 'functions.php';
    $id = $_GET["id"];
    edit_general_info($id, $_POST["name"], $_POST["workplace"], $_POST["phone"], $_POST["address"]);
    set_message("success", "Профиль успешно обновлен.");
    redirect("page_profile.php?id=" . $id);