<?php
include "../../extension/snack.php";
function checkFormSignUp($name, $email, $username, $password, $cfpassword, $agree, $db)
{
    // check empty
    $empty = check_empty($agree) ? "Agree to the request" :
        (check_empty($name) ? "name" :
            (check_empty($username) ? "username" :
                (check_empty($email) ? "email" :
                    (check_empty($password) ? "password" :
                        (check_empty($cfpassword) ? "confirm password" : "")))));
    if ($empty != "") {
        return showSnack("You are missing a field {$empty}. Please fill in completely", false);
    }

    // check white letter before and after
    $white_letter = check_white_letters_baa($name) ? "name" :
        (check_white_letters_baa($username) ? "username" :
            (check_white_letters_baa($email) ? "email" :
                (check_white_letters_baa($password) ? "password" : "")));
    if ($white_letter != "") {
        return showSnack("{$white_letter} must not contain spaces before or after", false);
    }

    // check contain special characters
    $special_chars = check_special_chars(remove_vietnamese_diacritics($name), [' ']) ? "name" :
        (check_special_chars($username, ['.']) ? "username" :
            (check_special_chars($email, ['@', '.']) ? "email" :
                (check_special_chars($password, []) ? "password" : "")));
    if ($special_chars != "") {
        return showSnack("{$special_chars} cannot contain special characters", false);
    }

    // check fullname have firstname and lastname
    if (check_contain_chars($name, [' '])) {
        return showSnack("Full name must contain full first and last name", false);
    }

    // check quantity characters in username and password
    $number_char = check_number_of_char($username, 6) ? "username" :
        (check_number_of_char($password, 6) ? "password" : "");
    if ($number_char != "") {
        return showSnack("{$number_char} must contain more than 6 characters", false);
    }


    // check password and cf password must match
    if ($password != $cfpassword) {
        return showSnack("password and confirm password must match", false);
    }

    // Check for duplicate username 
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        return showSnack("Username already exists", false);
    }

    // Check for duplicate email 
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        return showSnack("Email already exists", false);
    }

    // Hash password
    $password = password_hash($password, PASSWORD_DEFAULT);

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $currentDateTime = date("d/m/Y H:i");
    $sql = "INSERT INTO users (name, username, password, email, address, createAt, updateAt, status) VALUES ('$name', '$username', '$password', '$email', '', '$currentDateTime', '$currentDateTime', 'Active')";
    $result = $db->query($sql);

    return showSnack("Successfully registered account", true);
}
?>