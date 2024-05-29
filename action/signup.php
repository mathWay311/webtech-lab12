<?php
    session_start();
    require_once '../include/connect.php';

    $login =        $_POST['login'];
    $email =        $_POST['email'];
    $password =     $_POST['password'];
    $pseudoname =   $_POST['pseudoname'];

    $target = 'uploads/' . basename($_FILES['file']['name']);

    if (!move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        echo json_encode($_FILES['file']['name']);
        return;
    }

    $password = md5($password);

    $db_ans = mysqli_query($connect, "SELECT * FROM `user` WHERE LOGIN = '{$login}'");

    if (mysqli_num_rows($db_ans) > 0)
    {
        echo json_encode("Login already exists");
        return;
    }

    $db_ans1 = mysqli_query($connect, "SELECT * FROM `user` WHERE EMAIL = '{$email}'");

    if (mysqli_num_rows($db_ans1) > 0)
    {
        echo json_encode("С этим email уже связан аккаунт");
        return;
    }


    $db_ans2 = mysqli_query($connect, "SELECT * FROM `user` WHERE PSEUDONAME = '{$pseudoname}'");

    if (mysqli_num_rows($db_ans2) > 0)
    {
        echo json_encode("Выберите другой псевдоним - этот занят");
        return;
    }


    mysqli_query($connect, "INSERT INTO `user` (`ID_USER`, `PASSWORD`, `LOGIN`, `EMAIL`, `PSEUDONAME`, `ID_ROLE`, `AVATAR_PATH`) VALUES (NULL, '{$password}', '{$login}', '{$email}', '{$pseudoname}', '2', '{$target}') ");

    echo json_encode("SUCCESS");

    return;




