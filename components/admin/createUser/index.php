<?php
include "../../../config/checkform/index.php";
include "../../../config/connectSQL/index.php";
include '../../../extension/snack/index.php';
include '../../../config/signup/index.php';

if (isset($_POST['create'])) {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    $address = "";

    checkFormSignUp($name, $email, $address, $username, $password, $confirm_password, 'on', $role, $db);
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./index.css">
    <link rel="stylesheet" href="../../../extension/snack/index.css">
    <link rel="stylesheet" href="../../../style/index.css">
</head>

<body>
    <div class="registration-form">
        <form action="" method="post">
            <div class="form-group">
                <div>

                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" required>
                </div>
            </div>

            <div class="form-group">
                <div>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>

            <div class="form-group">
                <div>

                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
            </div>

            <div class="form-group">
                <div>
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" required>
                </div>
            </div>

            <div class="form-group">
                <div>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>

            <div class="form-group">
                <div>

                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
            </div>

            <div class="form-group">
                <div>

                    <label for="role">Role</label>
                    <select id="role" name="role">
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            <div class="btn-submit">
                <div>
                    <input type="submit" name="create" value="Create">
                </div>
            </div>
        </form>
        <form method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload File" name="uploadFile">
        </form>
        <?php
        session_start();
        if (isset($_POST["uploadFile"])) {
            $targetFile = basename($_FILES["fileToUpload"]["name"]); // Đường dẫn tới tệp đã tải lên
            $filename = $_FILES['fileToUpload']['name'];
            if (!empty($_FILES["fileToUpload"]["name"])) {
                $fileExtension = pathinfo($targetFile, PATHINFO_EXTENSION);
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile);
                if ($fileExtension == "xlsx") {
                    if (file_exists($filename)) {
                        $zip = new ZipArchive;
                        if ($zip->open($filename) === true) {
                            // Tìm và đọc tệp "xl/sharedStrings.xml" để lấy dữ liệu chuỗi chung
                            $sharedStringsData = $zip->getFromName('xl/sharedStrings.xml');
                            $sharedStrings = simplexml_load_string($sharedStringsData);

                            // Tìm và đọc tệp "xl/worksheets/sheet1.xml" (hoặc tệp trang tính khác) để lấy dữ liệu của bảng tính
                            $worksheetData = $zip->getFromName('xl/worksheets/sheet1.xml');
                            $worksheet = simplexml_load_string($worksheetData);

                            // Lấy dữ liệu từ bảng tính
                            foreach ($worksheet->sheetData->row as $row) {
                                foreach ($row->c as $cell) {
                                    $attr = $cell->attributes();
                                    if ((string)$attr['t'] == 's') {
                                        // Nếu kiểu dữ liệu là chuỗi
                                        $stringIndex = (int)$cell->v;
                                        $cellValue = (string)$sharedStrings->si[$stringIndex]->t;
                                    } else {
                                        // Ngược lại, là kiểu dữ liệu số
                                        $cellValue = (string)$cell->v;
                                    }
                                    echo $cellValue . "\t";
                                }
                                echo "<br/>"; // Xuống dòng sau khi kết thúc một hàng
                            }

                            $zip->close();
                        } else {
                            echo "Không thể mở tệp Excel.";
                        }
                    } else {
                        echo "Tệp Excel không tồn tại.";
                    }
                } else {
                    echo "Hãy chọn file moi";
                }
            } else {
                echo "Vui lòng chọn một tệp excel để tải lên.";
            }
        }



        ?>



    </div>
</body>

</html>