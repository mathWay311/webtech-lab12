<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8"/>
        <link href="home.css" rel="stylesheet">
        <title>Кодрум - IT-форум</title>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

    </head>

    <body>
        <div class="left-panel">
            <div class="auth-status" id="auth-status">
                <?php
                    include 'action/template/auth_window.php'
                ?>
            </div>
            <div class="topic-group-container">
                <?php
                    include 'include/topics.php';
                    $count = ((int)mysqli_num_rows($topic_groups)) / 5;
                    while ( $res = mysqli_fetch_assoc( $topic_groups ) )
                    {
                        $topic_name = $res['TOPIC_GROUP_NAME'];
                        $id_topic_group = $res['ID_TOPIC_GROUP'];

                        echo "<div onclick='jumpTo(\"{$id_topic_group}\")' class='topic-group'><a>{$topic_name}</a></div>";

                    }
                ?>
            </div>

        </div>
        <div class="right-panel" id="right-panel">
            <div class="searchbar" id="searchbar"> </div>
            <div class="topics-container" id="topics-container"> </div>
        </div>
    </body>
    <script src="script.js"></script>
</html>
