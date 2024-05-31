<?php
    session_start();
    require_once '../include/connect.php';
    include './fetch_auth_role.php';


    if (!boolval($user_role['CAN_UPLOAD_XML'])){
        echo "NO_AUTH";
        return;
    }


    $xml = simplexml_load_file($_FILES['file']['tmp_name']);

    $flag_some_errors = false;

    foreach ($xml->children() as $row) {
        $password = md5($row->password);
        $login = $row->login;
        $email = $row->email;
        $pseudoname = $row->pseudoname;
        $role = $row->role;
        $avatar_path = $row->avatar;

        $db_ans = mysqli_query($connect, "SELECT * FROM `user` WHERE LOGIN = '{$login}'");

        if (mysqli_num_rows($db_ans) > 0)
        {
            $flag_some_errors = true;
            continue;
        }

        $db_ans1 = mysqli_query($connect, "SELECT * FROM `user` WHERE EMAIL = '{$email}'");

        if (mysqli_num_rows($db_ans1) > 0)
        {
            $flag_some_errors = true;
            continue;
        }


        $db_ans2 = mysqli_query($connect, "SELECT * FROM `user` WHERE PSEUDONAME = '{$pseudoname}'");

        if (mysqli_num_rows($db_ans2) > 0)
        {
            $flag_some_errors = true;
            continue;
        }

        mysqli_query($connect, "INSERT INTO `user` (`ID_USER`, `PASSWORD`, `LOGIN`, `EMAIL`, `PSEUDONAME`, `ID_ROLE`, `AVATAR_PATH`) VALUES (NULL, '{$password}', '{$login}', '{$email}', '{$pseudoname}', '{$role}', '{$avatar_path}') ");
    }

    if ($flag_some_errors) {
        echo "ERRORS";
    }
    else {
        echo "SUCCESS";
    }
?>
