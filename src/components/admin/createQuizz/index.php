<?php
include "../../../config/getTime/index.php";
include "../../../config/connectSQL/index.php";
include "../../../extension/snack/index.php";
session_start();
$_SESSION['popupFileUpload'] = 'close';
if (!isset($_SESSION['filename'])) {
    $_SESSION['filename'] = '';
}
if (isset($_POST['checkFile'])) {

    if (basename($_FILES["fileToUpload"]["name"]) === "") {
        echo showSnack("Please import file", false);
    } else {
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], basename($_FILES["fileToUpload"]["name"]));
        $_SESSION['filename'] = $_FILES["fileToUpload"]["name"];
        $_SESSION['popupFileUpload'] = "open";
    }
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
    <link rel="stylesheet" href="../../../../style/index.css">
</head>

<body>
    <div class="registration-form">
        <form method="post" enctype="multipart/form-data" id="form-upload">
            <div>
                Create Quizz
            </div>
            <div>
                <input type="file" id="upload" name="fileToUpload" hidden>
                <label for="upload">Choose file</label>
                <input type="submit" id="checkFile" value="Check File" name="checkFile">
            </div>
        </form>
        <?php
        if (isset($_POST["apply"])) {
            $targetFile = basename($_SESSION['filename']);
            $filename = $_SESSION['filename'];
            if (!empty($filename)) {
                $fileExtension = pathinfo($targetFile, PATHINFO_EXTENSION);
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
                                $creator = $rowData[0];
                                $lesson = $rowData[1];
                                $question = $rowData[2];
                                $answer = serialize(explode("|", $rowData[3]));
                                $answerCorrect = serialize(explode("|", $rowData[5]));
                                $approved = $rowData[4];
                                $type = $rowData[6];
                                $courseId = $rowData[7];
                                $time = getCurrentTimeInVietnam();
                                if ($db) {
                                    $sql = "INSERT INTO question (creator, approved, lesson, courseId, question, answer, answerCorrect, type, createAt, updateAt) 
                                VALUES ('$creator', '$approved', '$lesson', $courseId, '$question', '$answer', '$answerCorrect', '$type', '$time', '$time')";
                                    try {
                                        $result = $db->query($sql);
                                        echo showSnack("Question added successfully", true);
                                    } catch (Throwable $th) {
                                        throw $th;
                                    }
                                }
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
    <div class="popupFileUpload-container <?php echo $_SESSION['popupFileUpload']; ?>">
        <div class="popupFileUpload-content ">
            <label>Filename: <?php echo basename($_FILES["fileToUpload"]["name"]); ?></label>
            <form action="" method="post">
                <input type="submit" name='apply' value="Apply">
                <input type="submit" name='cancel' value="Cancel">
            </form>
        </div>
    </div>
</body>

</html>