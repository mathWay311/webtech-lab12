<?php

    session_start();
    require_once '../include/connect.php';
    include './fetch_auth_role.php';

    if (!boolval($user_role['CAN_POST_MESSAGES'])){
        echo "BANNED";
        return;
    }


    $id_topic_gr = $_POST['id_topic_group'];
    $name = $_POST['name'];

    $id_user = $_SESSION['user']['ID_USER'];

    $query = "
    INSERT INTO `topic`
    (`ID_TOPIC`, `ID_TOPIC_GROUP`, `TOPIC_NAME`, `CREATION_DATE`, `AUTHOR_ID`)
        VALUES
    (NULL, '{$id_topic_gr}', '{$name}', NOW(), '{$id_user}' )";

    mysqli_query($connect, $query);
    echo "SUCCESS";
