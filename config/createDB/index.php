<?php
    include "../connectSQL/index.php";
    $query = "SHOW TABLES LIKE 'users'";
    $result = $db->query($query);

    if ($result->num_rows == 0){
        $sql = 'CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            username VARCHAR(255),
            password VARCHAR(255),
            address VARCHAR(255),
            createAt VARCHAR(255),
            updateAt VARCHAR(255),
            email VARCHAR(255)
        )';
        if ($db->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
        $db->close();
    }
?>