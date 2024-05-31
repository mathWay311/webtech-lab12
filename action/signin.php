 <?php
    session_start();
    require_once '../include/connect.php';


    $login = $_POST['login'];
    $password = md5($_POST['pass']);

    $check_user = mysqli_query($connect, "SELECT * FROM `user` WHERE LOGIN = '$login' AND PASSWORD = '$password'");

    if (mysqli_num_rows($check_user) > 0) {

        $user = mysqli_fetch_assoc($check_user);

        $_SESSION['user'] = [
            "ID_USER" => $user['ID_USER'],
            "LOGIN" => $user['LOGIN'],
            "PSEUDONAME" => $user['PSEUDONAME'],
            "AVATAR_PATH" => $user['AVATAR_PATH'],
            "EMAIL" => $user['EMAIL'],
            "ROLE" => $user['ID_ROLE']
        ];

        $answer = [
            "AUTH_STATUS" => true,
            "MESSAGE" => "",
            "PSEUDONAME" => $user['PSEUDONAME'],
            "ID_USER" => $user['ID_USER']
        ];
        //echo json_encode($answer);
    }
    else {
        $_SESSION['MESSAGE'] = "Неверный логин или пароль";
    }

    include './fetch_auth_role.php';
    include './template/auth_window.php';

?>
