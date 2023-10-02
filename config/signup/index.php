<?php
include "../../extension/snack.php";
function checkForm($name, $email, $username, $password, $cfpassword, $agree)
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


}
?>