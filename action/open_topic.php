<?php
    require_once '../include/connect.php';
    $id_topic = $_REQUEST["idtopic"];
    $query = "
        SELECT message.ID_MESSAGE,
            message.ID_TOPIC,
            message.ID_USER,
            message.IS_IMAGE,
            message.IMAGE_PATH,
            message.PUBLISH_DATE,
            message.SEQ_NUMBER,
            message.CONTENT,
            user.PSEUDONAME,
            role.NAME,
            role.UNIQUE_COLOR,
            role.CAN_POST_MESSAGES
        FROM `message`
        INNER JOIN user ON message.ID_USER=user.ID_USER
        INNER JOIN role ON user.ID_ROLE=role.ID_ROLE
        WHERE ID_TOPIC = '{$id_topic}'";

    if (!$connect) {
        die('Could not connect: ' . mysqli_error($connect));
    }

    $messages = mysqli_query($connect, $query);
    $arr = mysqli_fetch_all($messages, MYSQLI_ASSOC);
    echo json_encode($arr);
?>

