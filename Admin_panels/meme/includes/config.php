<?php

    
    $host       = "localhost";
    $user       = "kumuduho_android";
    $pass       = "Kalani21467";
    $database   = "kumuduho_android01";

    $connect = new mysqli($host, $user, $pass, $database);

    if (!$connect) {
        die ("connection failed: " . mysqli_connect_error());
    } else {
        $connect->set_charset('utf8');
    }

    $ENABLE_RTL_MODE = 'false';

?>