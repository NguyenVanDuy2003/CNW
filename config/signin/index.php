<?php
function checkFormSignIn($username, $password, $db)
{
    // check empty
    $empty = check_empty($username) ? "Username" :
        (check_empty($password) ? "password" : "");
    if ($empty != "") {
        return showSnack("You are missing a field {$empty}. Please fill in completely", false);
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
            if ($_GET['remember']) {
                rememberAccount($username, $password);
            }
            return showSnack("Logged in successfully", true);
        }
    } else {
        return showSnack("Account or password is incorrect", false);
    }
}

function rememberAccount($username, $password) {
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


?>