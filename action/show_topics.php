<?php
    require_once '../include/connect.php';
    $id_topic_gr = $_REQUEST["idtopicgroup"];
    $query = "
    SELECT topic.ID_TOPIC,
            topic.ID_TOPIC_GROUP,
            topic.TOPIC_NAME,
            topic.AUTHOR_ID,
            topic.CREATION_DATE,
            user.PSEUDONAME
    FROM `topic`
            INNER JOIN user ON topic.AUTHOR_ID=user.ID_USER
            WHERE ID_TOPIC_GROUP = '{$id_topic_gr}'";
    //mysqli_select_db($connect,"lab12");
    if (!$connect) {
        die('Could not connect: ' . mysqli_error($connect));
    }
    $topics = mysqli_query($connect, $query);
    $arr = mysqli_fetch_all($topics, MYSQLI_ASSOC);


    echo json_encode($arr);
?>

