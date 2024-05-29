<?php
    session_start();
    require_once '../include/connect.php';
    require_once './fetch_auth_role.php';

    if (!boolval($user_role['CAN_POST_TOPIC_GROUPS'])){
        return;
    }

    $topic_gr_id = $_REQUEST["idTopicGroup"];

    $query = "SELECT * FROM `topic` WHERE ID_TOPIC_GROUP='{$topic_gr_id}'";

    $topics = mysqli_query($connect, $query);

    $arr = mysqli_fetch_all($topics, MYSQLI_ASSOC);


    foreach ($arr as $topic) {
        $query_delete_msg = "DELETE FROM `message` WHERE ID_TOPIC = '{$topic['ID_TOPIC']}'";
        mysqli_query($connect, $query_delete_msg);

        $query_delete_topic = "DELETE FROM `topic` WHERE ID_TOPIC = '{$topic['ID_TOPIC']}'";
        mysqli_query($connect, $query_delete_topic);
    }

    $query_delete_topic_gr = "DELETE FROM `topic_group` WHERE ID_TOPIC_GROUP = '{$topic_gr_id}'";
    mysqli_query($connect, $query_delete_topic_gr);

?>
