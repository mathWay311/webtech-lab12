<?php

    session_start();
    require_once '../include/connect.php';

    $topic_gr_name = $_POST['name'];

    $query = "INSERT INTO `topic_group`
    (`ID_TOPIC_GROUP`, `TOPIC_GROUP_NAME`, `REFERENCE_NAME`)
    VALUES
    (NULL, '{$topic_gr_name}', 'DEPRECATED') ";

    mysqli_query($connect, $query);

