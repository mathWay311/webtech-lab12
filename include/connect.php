<?php

    $connect = mysqli_connect('localhost', 'mathway', 'overlord', 'lab12');

    if (!$connect) {
        die('ERR DB CONNECTION FAIL!');
    }
?>
