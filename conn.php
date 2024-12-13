<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "mvch";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error){
        die("Invalid Connection:" . $conn->connect_error);
    }

?>