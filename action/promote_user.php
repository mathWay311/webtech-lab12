<?php

    session_start();
    require_once '../include/connect.php';

    $id_role = $_POST['role_id'];
    $pseudoname = $_POST['pseudoname'];

    $query = "UPDATE `user`
    SET ID_ROLE = '{$id_role}'
    WHERE PSEUDONAME = '{$pseudoname}'";

    mysqli_query($connect, $query);

