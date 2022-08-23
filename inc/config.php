<?php
    Error_Reporting(E_ALL & ~ E_NOTICE);

    session_start();

    // connect to db
    $host   = "localhost";
    $user   = "root";
    $pass   = "mysql";
    $db     = "user";

    try {
        $connect = new PDO("mysql:host=".$host.";dbname=".$db, $user, $pass);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }

?>