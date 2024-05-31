<?php
    session_start();
    unset($_SESSION['user']);

    include './fetch_auth_role.php';
    include './template/auth_window.php';
