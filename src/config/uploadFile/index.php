<?php
function uploadFileSystem($file)
{
    $uniqueId = uniqid(); // Tạo một ID ngẫu nhiên
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION); // Lấy đuôi file

    $newFileName = $uniqueId . '.' . $extension;

    $path = "../../../images/upload/" . $newFileName;
    if (move_uploaded_file($file['tmp_name'], $path)) {
        return $newFileName;
    } else {
        echo showSnack("File upload error", false);
        return;
    }
}

function deleteFileSystem($path)
{
    if (unlink($path)) {
        return true;
    } else {
        return false;
    }
}
?>