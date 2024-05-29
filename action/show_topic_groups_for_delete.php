<?php
    require_once '../include/connect.php';
    require_once './fetch_auth_role.php';

    $query = "
    SELECT topic_group.ID_TOPIC_GROUP,
            topic_group.TOPIC_GROUP_NAME
    FROM `topic_group`";
    //mysqli_select_db($connect,"lab12");
    if (!$connect) {
        die('Could not connect: ' . mysqli_error($connect));
    }
    $topic_grs = mysqli_query($connect, $query);
    $arr = mysqli_fetch_all($topic_grs, MYSQLI_ASSOC);

    $htmlString = ''; // Переменная для хранения HTML-строки

    foreach ($arr as $topic_gr) {
        $htmlString .= "
        <div class='topic'>
            <div class='topic-head'>
                {$topic_gr['TOPIC_GROUP_NAME']}
            </div>
            <div class='delete-topic-button' onclick='deleteTopicGroup({$topic_gr['ID_TOPIC_GROUP']})'>
                Удалить форум
            </div>
        </div>";
    }

    echo $htmlString;

?>


