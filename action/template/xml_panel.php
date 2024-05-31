<?php
    session_start();
    require_once '../../include/connect.php';
    require_once '../fetch_auth_role.php';


    if (!boolval($user_role['CAN_UPLOAD_XML'])){
        echo "Вас здесь быть не должно!)";
        return;
    }

    $htmlString = "<label class='auth-labels' for='xmlfile'>Загрузите файл:</label> <input type='file' name='xmlfile' id='xmlfile'/>";
    $htmlString .= "<button onclick='upload_xml()'>Отправить</button>";

    echo $htmlString;


?>

