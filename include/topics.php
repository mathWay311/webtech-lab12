<?php

    session_start();
    require_once 'connect.php';

    $topic_groups = mysqli_query($connect, "SELECT * FROM `topic_group`");
?>
