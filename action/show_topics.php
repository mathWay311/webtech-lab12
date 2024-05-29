<?php
    require_once '../include/connect.php';
    $id_topic_gr = $_REQUEST["idtopicgroup"];
    $query = "SELECT * FROM `topic` WHERE ID_TOPIC_GROUP = '{$id_topic_gr}'";
    //mysqli_select_db($connect,"lab12");
    if (!$connect) {
        die('Could not connect: ' . mysqli_error($connect));
    }
    $topics = mysqli_query($connect, $query);
    $arr = mysqli_fetch_all($topics, MYSQLI_ASSOC);


    echo json_encode($arr);
?>

