<?php
// include "../../extension/snack.php";
function checkFormSignIn($username, $password, $db)
{
    // check empty
    $empty = check_empty($username) ? "Username" :
        (check_empty($password) ? "password" : "");
    if ($empty != "") {
        // return showSnack("You are missing a field {$empty}. Please fill in completely", false);
        echo "You are missing a field {$empty}. Please fill in completely"; return;
    }

    // get db has username or email = $username user 
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $username);
    
    // Thực hiện truy vấn
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Sử dụng password_verify để kiểm tra mật khẩu
        if (password_verify($password, $hashed_password)) {
        echo "Correct"; return;
        // return showSnack("Correct", true);
        }
    } else {
        echo "Incorrect"; return;
        // return showSnack("Incorrect", false);
    }
}
?>