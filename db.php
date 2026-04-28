<?php    
    $host = getenv('DB_HOST') ?: "localhost";
    $user = getenv('DB_USER') ?: "BoBnuri";
    $pass = getenv('DB_PASSWORD') ?: "nuriBoB1234!";
    $name = getenv('DB_NAME') ?: "sample";

    $con = mysqli_connect($host, $user, $pass, $name);

    if (mysqli_connect_errno()) {
        die("MySQL ?░ъ▓░ ?дэМи: " . mysqli_connect_error());
    }

    mysqli_set_charset($con, "utf8");
?>