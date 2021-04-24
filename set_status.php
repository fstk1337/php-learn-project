<?php
    session_start();
    require 'functions.php';
    $id = $_GET["id"];
    set_status($id, $_POST["status"]);
    set_message("success", "Профиль успешно обновлен.");
    redirect("page_profile.php?id=" . $id);
