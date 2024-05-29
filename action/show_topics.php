<?php
    require_once '../include/connect.php';
    require_once './fetch_auth_role.php';

    $id_topic_gr = $_REQUEST["idtopicgroup"];
    $query = "
    SELECT topic.ID_TOPIC,
            topic.ID_TOPIC_GROUP,
            topic.TOPIC_NAME,
            topic.AUTHOR_ID,
            topic.CREATION_DATE,
            user.PSEUDONAME
    FROM `topic`
            INNER JOIN user ON topic.AUTHOR_ID=user.ID_USER
            WHERE ID_TOPIC_GROUP = '{$id_topic_gr}'";
    //mysqli_select_db($connect,"lab12");
    if (!$connect) {
        die('Could not connect: ' . mysqli_error($connect));
    }
    $topics = mysqli_query($connect, $query);
    $arr = mysqli_fetch_all($topics, MYSQLI_ASSOC);

    $htmlString = ''; // Переменная для хранения HTML-строки

    foreach ($arr as $topic) {
        $htmlString .= "
        <div class='topic' onclick=openTopic('{$topic['ID_TOPIC']}')>
            <div class='topic-head'>
                {$topic['TOPIC_NAME']}
            </div>
            <div class='topic-author'>
                Автор: {$topic['PSEUDONAME']}
                <img width=50 height=50 src='action/template/avatar.php?user={$topic['AUTHOR_ID']}'>
            </div>
            <div class='topic-date-of-creation'>
                Создана: {$topic['CREATION_DATE']}
            </div>

        ";
        if (boolval($user_role['CAN_DELETE_TOPICS_OR_MESSAGES'])) {
            $htmlString .= "<div class='delete-topic-button' onclick='deleteTopic({$topic['ID_TOPIC']})'>Удалить тему</div>";
        }
        $htmlString .= "</div>";
    }

    echo $htmlString;

?>

