<?php

    session_start();
    require_once '../include/connect.php';
    include './fetch_auth_role.php';

    if (!boolval($user_role['CAN_POST_MESSAGES'])){
        echo "BANNED";
        return;
    }


    $id_topic = $_POST['id_topic'];
    $msg = $_POST['message'];

    $id_user = $_SESSION['user']['ID_USER'];

    $query_for_maximum_seq_number = "SELECT MAX(SEQ_NUMBER) FROM `message` WHERE ID_TOPIC = '{$id_topic}'";
    $max_id = mysqli_query($connect, $query_for_maximum_seq_number);

    $max_id = mysqli_fetch_assoc($max_id)["MAX(SEQ_NUMBER)"] + 1;

    mysqli_query($connect, "INSERT INTO `message`
    (`ID_MESSAGE`, `ID_TOPIC`, `ID_USER`, `SEQ_NUMBER`, `PUBLISH_DATE`, `CONTENT`, `IS_IMAGE`, `IMAGE_PATH`)
    VALUES
    (NULL, '{$id_topic}', '{$id_user}', '{$max_id}', NOW(), '{$msg}', '0', '0') ");
    echo "SUCCESS";
