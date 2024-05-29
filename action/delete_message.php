<?php
    session_start();
    require_once '../include/connect.php';
    require_once './fetch_auth_role.php';

    if (!boolval($user_role['CAN_DELETE_TOPICS_OR_MESSAGES'])){
        return;
    }

    $msg_id = $_REQUEST["idMessage"];

    $query = "DELETE FROM `message` WHERE ID_MESSAGE = '{$msg_id}'";

    mysqli_query($connect, $query);
?>
