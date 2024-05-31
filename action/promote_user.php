<?php

    session_start();
    require_once '../include/connect.php';
    require_once './fetch_auth_role.php';

    if (!boolval($user_role['CAN_PROMOTE_USERS'])){
        echo "NO_AUTH";
        return;
    }

    $id_role = $_POST['role_id'];
    $pseudoname = $_POST['pseudoname'];

    $check_user = mysqli_query($connect, "SELECT * FROM `user` WHERE PSEUDONAME = '$pseudoname'");
    $user = mysqli_fetch_assoc($check_user);

    if (mysqli_num_rows($check_user) > 0) {
        $query = "UPDATE `user`
        SET ID_ROLE = '{$id_role}'
        WHERE PSEUDONAME = '{$pseudoname}'";

        mysqli_query($connect, $query);
        echo "SUCCESS";
    }
    else {
        echo "NO_USER";
    }

