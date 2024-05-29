<?php
    require_once '../include/connect.php';
    require_once './fetch_auth_role.php';

    $id_topic = $_REQUEST["idtopic"];
    $query = "
        SELECT message.ID_MESSAGE,
            message.ID_TOPIC,
            message.ID_USER,
            message.IS_IMAGE,
            message.IMAGE_PATH,
            message.PUBLISH_DATE,
            message.SEQ_NUMBER,
            message.CONTENT,
            user.PSEUDONAME,
            role.NAME,
            role.UNIQUE_COLOR
        FROM `message`
        INNER JOIN user ON message.ID_USER=user.ID_USER
        INNER JOIN role ON user.ID_ROLE=role.ID_ROLE
        WHERE ID_TOPIC = '{$id_topic}'";

    if (!$connect) {
        die('Could not connect: ' . mysqli_error($connect));
    }

    $messages = mysqli_query($connect, $query);
    $arr = mysqli_fetch_all($messages, MYSQLI_ASSOC);


    $htmlString = ''; // Переменная для хранения HTML-строки

    foreach ($arr as $msg) {
        $htmlString .= "
        <div class='message'>
            <a><img src='action/template/avatar.php?user={$msg['ID_USER']}'></a>
            <div class='message-author' style='color:{$msg['UNIQUE_COLOR']}'>
                {$msg['NAME']} {$msg['PSEUDONAME']}
            </div>
            <div class='message-date'>
                оставил сообщение в {$msg['PUBLISH_DATE']}
            </div>
            <div class='message-content'>
                {$msg['CONTENT']}
            </div>
        ";
        if (boolval($user_role['CAN_DELETE_TOPICS_OR_MESSAGES'])) {
            $htmlString .= "<div class='delete-msg-button' onclick='deleteMsg({$msg['ID_MESSAGE']})'>Удалить сообщение</div>";
        }
        $htmlString .= "</div>";
    }

    echo $htmlString;
?>

