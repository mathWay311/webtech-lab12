<?php
    session_start();
    require_once '/home/mathway/Documents/GitHub/webtech-lab12/include/connect.php';

    $id_role = $_SESSION['user']['ROLE'];

    $fetched_role = mysqli_query($connect, "SELECT * FROM `role` WHERE ID_ROLE = '$id_role' ");
    $user_role = mysqli_fetch_assoc($fetched_role);
?>
