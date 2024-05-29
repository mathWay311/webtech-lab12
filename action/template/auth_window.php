<?php
    include './action/fetch_auth_role.php';

    session_start();
    if (!$_SESSION['user']) {
        echo '
        <div class="auth-mini-window">
            <div class="no-auth">
                <a>Вы не авторизованы</a>
            </div>
            <label class="auth-labels" for="login">Логин:</label>
            <input class="auth-field" type="text" id="login" name="login" />
            <label class="auth-labels" for="password">Пароль:</label>
            <input class="auth-field" type="password" id="password" name="password" />
            <button onclick="signin()">Войти</button>
            <button onclick="signup_open()">Регистрация</button>
            <button onclick="recover_password_open()">Забыли пароль?</button>
        </div>';
    }
    else {
        $htmlString = "<div class='auth-mini-window'>
        <a href=''><img src='action/template/avatar.php?user={$_SESSION['user']['ID_USER']}'></a>
        <a>Добро пожаловать, {$_SESSION['user']['PSEUDONAME']} </a>
        <a>Ваша роль: {$user_role['NAME']} </a>";



        if (boolval($user_role['CAN_POST_TOPIC_GROUPS'])) {
            $htmlString .= "<button onclick='openTopicGroupEditPanel()'>Редактировать форумы</button>";
        }

        if (boolval($user_role['CAN_PROMOTE_USERS'])) {
            $htmlString .= "<button onclick='openPrivilegePanel()'>Выдать привилегии</button>";
        }

        $htmlString .= "<button onclick='logout()'>Выйти</button></div>";
        echo $htmlString;
    }
?>
