<?php 
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "ecommerce";

    $conn = new mysqli($server, $username, $password, $database);
    if ($conn) {
        // echo "Conneted Successfuly";
    }
    else {
        die ("Failed to connect");  
    }
?>