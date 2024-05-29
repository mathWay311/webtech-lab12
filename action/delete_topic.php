<?php
    session_start();
    require_once '../include/connect.php';
    require_once './fetch_auth_role.php';

    if (!boolval($user_role['CAN_DELETE_TOPICS_OR_MESSAGES'])){
        return;
    }

    $topic_id = $_REQUEST["idTopic"];

    $query_messages = "DELETE FROM `message` WHERE ID_TOPIC = '{$topic_id}'";
    mysqli_query($connect, $query_messages);

    $query_topic = "DELETE FROM `topic` WHERE ID_TOPIC = '{$topic_id}'";
    mysqli_query($connect, $query_topic);
?>
