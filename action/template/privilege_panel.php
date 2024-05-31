<?php
    include '../action/fetch_auth_role.php';
    require_once '../../include/connect.php';

    session_start();
    $roles_query = "SELECT * FROM `role`";
    $roles = mysqli_query($connect, $roles_query);
    $arr = mysqli_fetch_all($roles, MYSQLI_ASSOC);
    $htmlString = "Псевдоним пользователя: <input type='text' id='user_pseudo'></input>";
    $htmlString .= "<select name='role-select' id='role-select' class='input-topic-date-find'>";

    foreach ($arr as $role) {
        $htmlString .= "<option value='{$role['ID_ROLE']}'>{$role['NAME']}</option>";
    }

    $htmlString .= "</select>";
    $htmlString .= "<button onclick='promoteUser()'>Выдать привилегии</button>";
    echo $htmlString;


?>
