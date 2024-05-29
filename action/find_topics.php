<?php
    require_once '../include/connect.php';
    $id_topic_gr = $_REQUEST["idtopicgroup"];
    $topic_name = $_REQUEST["topicName"];
    $topic_author = $_REQUEST["topicAuthor"];
    $topic_order_query = $_REQUEST["topicOrder"];
    $topic_limit = $_REQUEST["topicLimit"];

    $query = "
    SELECT topic.ID_TOPIC,
            topic.ID_TOPIC_GROUP,
            topic.TOPIC_NAME,
            topic.AUTHOR_ID,
            topic.CREATION_DATE,
            user.PSEUDONAME
    FROM `topic`
            INNER JOIN user ON topic.AUTHOR_ID=user.ID_USER
            WHERE ID_TOPIC_GROUP = '{$id_topic_gr}'
            AND topic.TOPIC_NAME LIKE '%{$topic_name}%'
            AND user.PSEUDONAME LIKE '%{$topic_author}%'
            {$topic_order_query}
            LIMIT {$topic_limit}";
    //mysqli_select_db($connect,"lab12");
    if (!$connect) {
        die('Could not connect: ' . mysqli_error($connect));
    }
    $topics = mysqli_query($connect, $query);
    $arr = mysqli_fetch_all($topics, MYSQLI_ASSOC);


    echo json_encode($arr);
?>

