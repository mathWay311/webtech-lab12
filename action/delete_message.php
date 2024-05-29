<?php
    session_start();
    require_once '../include/connect.php';

    $msg_id = $_REQUEST["idMessage"];

    $query = "DELETE FROM `message` WHERE ID_MESSAGE = '{$msg_id}'";

    mysqli_query($connect, $query);
?>
