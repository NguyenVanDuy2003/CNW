<?php 
    $servername = $_ENV['SERVERNAME'];
    $username = $_ENV['USERNAME'];
    $password = $_ENV['PASSWORD'];
    $dbname = $_ENV['DBNAME'];
    
    $db = new mysqli($servername, $username, $password, $dbname);
    if ($db->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }
?>