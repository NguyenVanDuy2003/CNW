<?php

function checkFormSignIn($username, $password, $db)
{
    // check empty
    $empty = check_empty($username) ? "Username" : (check_empty($password) ? "password" : "");
    if ($empty != "") {
        echo showSnack("You are missing a field {$empty}. Please fill in completely", false);
        return false;
    }

    // get db has username or email = $username user 
    $stmt = $db->prepare("SELECT * FROM users WHERE username = '$username' OR email = '$username'");

    // Thực hiện truy vấn
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        $role = $row['role'];


        // Sử dụng password_verify để kiểm tra mật khẩu
        if (password_verify($password, $hashed_password)) {
            if (isset($_GET['remember'])) {
                rememberAccount($username, $password);
            }
            checkAccountAccessToken($username, $db);
            echo showSnack("Logged in successfully", true);
            if ($role === 'admin') {
                header('Location: ../../page/admin');
            }
            return true;
        }
    } else {
        echo showSnack("Account or password is incorrect", false);
        return false;
    }
}

function rememberAccount($username, $password)
{
    echo "
    <script>
        let existingData;
        if(localStorage.getItem('rememberAccount')) {
            existingData = JSON.parse(localStorage.getItem('rememberAccount'));
        } else {
            existingData = [];
        }
        
        let existingAccountIndex = existingData.findIndex(function(item) {
            return item.username === '$username';
        });
        
        if (existingAccountIndex !== -1) {
            if (existingData[existingAccountIndex].password !== '$password') {
                existingData[existingAccountIndex].password = '$password';
                localStorage.setItem('rememberAccount', JSON.stringify(existingData));
            }
        } else {
            existingData.push({
                username: '$username',
                password: '$password'
            });
            localStorage.setItem('rememberAccount', JSON.stringify(existingData));
        }
    </script>
    ";
}
