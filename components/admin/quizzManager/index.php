<?php
include "../../../config/connectSQL/index.php";
include "../../../extension/session/index.php";
include "../../../config/getTime/index.php";

$sql = "SELECT * FROM question";
$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$totalDataPoints = $result->num_rows;
$dataPerPage = 10;
$totalPages = ceil($totalDataPoints / $dataPerPage);
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($currentPage - 1) * $dataPerPage;

$dataQuizz = [];

for ($i = 0; $i < $totalDataPoints; $i++) {
    $row = $result->fetch_assoc();
    if (!$row) {
        break;
    }
    array_push($dataQuizz, $row);
}
$dataForPage = array_slice($dataQuizz, $offset, $dataPerPage);
$_SESSION['popup'] = 'close';
$_SESSION['popupDelete'] = 'close-';


if (isset($_GET['id'])) {
    $_SESSION['popup'] = 'open';
    $_SESSION['id'] = $_GET['id'];
}

if (isset($_GET['popup']) || isset($_POST['popupsave'])) {
    $_SESSION['popup'] = "close";
}

if (isset($_POST['edit'])) {
    $_SESSION['id'] = $_POST['id'];
    $_SESSION['popup'] = 'open';
}

if (isset($_POST['save'])) {
    $query = "UPDATE users SET 
      name = ?,
      address = ?,
      email = ?,
      status = ?,
      role = ?
      WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sssssi", $_POST['name'], $_POST['address'], $_POST['email'], $_POST['status'], $_POST['role'], $_SESSION['id']);
    if ($stmt->execute()) {

        $_SESSION['load'] = true;

        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}

if (isset($_POST['delete'])) {
    $_SESSION['popupDelete'] = "open";
}

if (isset($_POST['popupsave'])) {
    $_SESSION['popupDelete'] = "close";

    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $_SESSION['id']);
    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
if (isset($_POST['popupCancel'])) {
    $_SESSION['popupDelete'] = "close";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table</title>
    <link rel="stylesheet" href="./index.css">
</head>

<body>
    <h1>Danh sách người dùng</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Creator</th>
                <th>Approved</th>
                <th>Lesson</th>
                <th>Question</th>
                <!-- <th>Answer</th>
                <th>Answer Correct</th> -->
                <th>Type</th>
                <th>courseId</th>
                <th>Created At</th>
                <th>Update At</th>
                <th> </th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataForPage as $item) { ?>
                <tr>
                    <form action="" method="post">

                        <td>
                            <input value="<?php echo $item["id"]; ?>" name='id' type='number' readonly />
                        </td>
                        <td><?php echo $item["creator"]; ?></td>
                        <td><?php echo $item["approved"]; ?></td>
                        <td><?php echo $item["lesson"]; ?></td>
                        <td><?php echo $item["question"]; ?></td>
                        <!-- <td>
                            <?php $answer = unserialize($item["answer"]);
                            $str = '';
                            foreach ($answer as $ele) {
                                $str .= $ele . '<br/>';
                            }
                            echo  $str;

                            ?>
                        </td> -->
                        <!-- <td>

                            <?php $answerCorrect = unserialize($item["answerCorrect"]);
                            $str = '';
                            foreach ($answerCorrect as $ele) {
                                $str .= $ele . '<br/>';
                            }
                            echo  $str;

                            ?></td> -->
                        <td><?php echo $item["type"]; ?></td>
                        <td><?php echo $item["courseId"]; ?></td>
                        <td><?php echo $item["createAt"]; ?></td>
                        <td><?php echo $item["updateAt"]; ?></td>
                        <td>
                            <button type="submit" name="edit">Edit</button>
                        </td>

                    </form>

                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php if ($currentPage > 1) { ?>
            <a href='index.php?page=<?php echo $currentPage - 1; ?>' class='number'>Previous</a>
        <?php } ?>
        <?php for ($page = 1; $page <= $totalPages; $page++) {
            if ($totalPages != 1) {

        ?>

                <a href='index.php?page=<?php echo $page; ?>' class='number <?php echo ($currentPage == $page) ? 'current' : ''; ?>'><?php echo $page; ?></a>
        <?php  }
        } ?>
        <?php if ($currentPage < $totalPages) { ?>
            <a href='index.php?page=<?php echo $currentPage + 1; ?>' class='number'>Next</a>
        <?php } ?>
    </div>

    <div class="popup-container <?php echo $_SESSION['popup']; ?>">
        <div class="popup-content">
            <a href="./?popup=close" class="close-popup">&times;</a>

            <form action="" method="POST">

                <?php
                $question = [];
                foreach ($dataForPage as $item) {
                    if ($item['id'] ==  $_SESSION['id']) {
                        $question  = $item;
                    }
                }
                $create = $question['creator'];
                $approved = $question['approved'];
                $lesson = $question['lesson'];
                $question = $question['question'];

                ?>

                <input type="submit" class="btn-submit" name="save" value="Save">
                <input type="submit" class="btn-submit" name="delete" value="Delete">

            </form>

            <?php

            if (isset($_POST['save'])) {
                $query = "UPDATE users SET 
                  name = '$_POST[name]',
                  address = '$_POST[address]',
                  email = '$_POST[email]',
                  status = '$_POST[status]',
                  role = '$_POST[role]'
                  WHERE id = '$_SESSION[id]'";
                $stmt = $db->prepare($query);
                if ($stmt->execute()) {

                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
            }
            if (isset($_POST['delete'])) {
                $_SESSION['popupDelete'] = "open";
            }

            if (isset($_POST['popupsave'])) {
                $_SESSION['popupDelete'] = "close";

                $query = "DELETE FROM question WHERE id = '$_SESSION[id]'";
                $stmt = $db->prepare($query);
                if ($stmt->execute()) {
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
            }
            if (isset($_POST['popupCancel'])) {
                $_SESSION['popupDelete'] = "close";
            }
            ?>
        </div>
    </div>
    <div class="popupDelete-container <?php echo $_SESSION['popupDelete']; ?>">
        <div class="popupDelete-content ">
            <form action="" method="post">
                <input type="submit" name='popupsave' value="save">
                <input type="submit" name='popupCancel' value="cancel">
            </form>
        </div>
    </div>

    <form method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload File" name="uploadFile">
    </form>
    <?php
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
                            $creator = $rowData[0];
                            $lesson = $rowData[1];
                            $question = $rowData[2];
                            $answer = serialize(explode("|", $rowData[3]));
                            $answerCorrect = serialize(explode("|", $rowData[5]));
                            echo $answerCorrect;
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
                                    echo $th;
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

</body>

</html>