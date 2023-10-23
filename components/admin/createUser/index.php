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
            $targetFile = basename($_FILES["fileToUpload"]["name"]);
            $filename = $_FILES['fileToUpload']['name'];
            if (!empty($_FILES["fileToUpload"]["name"])) {
                $fileExtension = pathinfo($targetFile, PATHINFO_EXTENSION);
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile);
                if ($fileExtension == "xlsx") {
                    if (file_exists($filename)) {
                        $zip = new ZipArchive;
                        if ($zip->open($filename) === true) {
                            $sharedStringsData = $zip->getFromName('xl/sharedStrings.xml');
                            $sharedStrings = simplexml_load_string($sharedStringsData);
                            $worksheetData = $zip->getFromName('xl/worksheets/sheet1.xml');
                            $worksheet = simplexml_load_string($worksheetData);


                            $skipFirstRow = true; // Biến để bỏ qua hàng đầu tiên

                            foreach ($worksheet->sheetData->row as $row) {
                                if ($skipFirstRow) {
                                    $skipFirstRow = false;
                                    continue; // Bỏ qua hàng đầu tiên
                                }

                                $rowData = array(); // Mảng lưu trữ dữ liệu của mỗi hàng
                                foreach ($row->c as $cell) {
                                    $attr = $cell->attributes();
                                    if ((string)$attr['t'] == 's') {
                                        $stringIndex = (int)$cell->v;
                                        $cellValue = (string)$sharedStrings->si[$stringIndex]->t;
                                    } else {
                                        $cellValue = (int)$cell->v;
                                    }
                                    $rowData[] = $cellValue; // Thêm dữ liệu ô vào mảng hàng
                                }

                                $name = $rowData[0];
                                $email = $rowData[2];
                                $username = $rowData[5];
                                $password = $rowData[6];
                                $confirm_password = $rowData[6];
                                $role = $rowData[4];
                                $address = $rowData[3];
                                checkFormSignUp($name, $email, $address, $username, $password, $confirm_password, 'on', $role, $db);
                            }

                            $zip->close();
                        } else {
                            echo "Không thể mở tệp Excel.";
                        }
                    } else {
                        echo "Tệp Excel không tồn tại.";
                    }
                } else {
                    echo "Hãy chọn file mới";
                }
            } else {
                echo "Vui lòng chọn một tệp Excel để tải lên.";
            }
        }
        ?>





    </div>
</body>

</html>