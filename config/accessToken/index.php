<?php
function generateAccessToken($length = 64)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    $accessToken = 'liorion' . $randomString;
    return $accessToken;
}

function saveCookie($accessToken) {
    setcookie('liorion', $accessToken, time() + (86400 * 30), "/"); 
}

function deleteCookie() {
    setcookie('liorion', $_COOKIE['liorion'], time() - (86400 * 30), "/");
}


function checkAccountAccessToken($username, $db)
{
    $accessToken = generateAccessToken();
    $createAt = getCurrentTimeInVietnam();
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $userId = $row['id'];
        $query = "SELECT * FROM accessToken WHERE userId = '$userId'";
        $result = $db->query($query);

        if ($result->num_rows > 0) {
            $sql = "UPDATE accessToken SET accessToken = '$accessToken', createAt = '$createAt', expiry = '30' WHERE userId = '$userId'";
            $db->query($sql);
        } else {
            $sql = "INSERT INTO accessToken (userId, accessToken, createAt, expiry) VALUES ('$userId', '$accessToken', '$createAt', '30')";
            $db->query($sql);
        }
        break;
    }
    saveCookie($accessToken);
}

?>