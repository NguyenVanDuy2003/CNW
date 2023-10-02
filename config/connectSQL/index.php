<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "FinalProduct";

    $db = new mysqli($servername, $username, $password, $dbname);
    
    if ($db->connect_error) {
        die("Kết nối thất bại: " . $db->connect_error);
    } 
?>