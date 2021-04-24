<?php
    session_start();
    require 'functions.php';
    $id = $_GET["id"];
    load_avatar($id, $_FILES["avatar"]);
    set_message("success", "Профиль успешно обновлен.");
    redirect("page_profile.php?id=" . $id);
