<?php 
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "Ecommerce";

    $conn = new mysqli($server, $username, $password, $database);
    if ($conn) {
        // echo "Conneted Successfuly";
    }
    else {
        die ("Failed to connect");  
    }
?>