<?php
function getCookie()
{
    if (isset($_COOKIE['liorion'])) {
        $liorionValue = $_COOKIE['liorion'];
        return $liorionValue;
    } else {
        return "Error";
    }
}
function checkActiveCookie($db)
{
    $cookie = getCookie();
    if ($cookie == "Error") {
        return 0;
    }
    $sql = "SELECT * FROM accessToken WHERE accessToken = '$cookie'";
    $result = $db->query($sql);
    if ($result->num_rows == 0) {
        return 0;
    } else {
        $row = $result->fetch_assoc();
        return $row['userId'];
    }
}

if (checkActiveCookie($db) != 0 && strpos($_SERVER['REQUEST_URI'], "login")) {
    $id = checkActiveCookie($db);
    $sql="SELECT * FROM users WHERE id = $id";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    if ($row['role'] == 'teacher') {
        header('location: ../home');
    }
    else header('location: ../admin');
} elseif (checkActiveCookie($db) == 0 && !strpos($_SERVER['REQUEST_URI'], "login")) {
    header('location: ../login');
}
