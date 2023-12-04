<?php
function getCurrentTimeInVietnam()
{
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $currentDateTime = date('d/m/Y H:i');
    return $currentDateTime;
}
?>
