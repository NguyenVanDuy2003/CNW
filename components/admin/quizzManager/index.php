<?php
include "../../../config/connectSQL/index.php";
include "../../../extension/session/index.php";

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
                <th>Answer</th>
                <th>Answer Correct</th>
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
                        <td>
                            <?php $answer = unserialize($item["answer"]);
                            $str = '';
                            foreach ($answer as $ele) {
                                $str .= $ele . '<br/>';
                            }
                            echo  $str;

                            ?>
                        </td>
                        <td>

                            <?php $answerCorrect = unserialize($item["answerCorrect"]);
                            $str = '';
                            foreach ($answerCorrect as $ele) {
                                $str .= $ele . '<br/>';
                            }
                            echo  $str;

                            ?></td>
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
                $user = [];
                foreach ($dataForPage as $item) {
                    if ($item['id'] ==  $_SESSION['id']) {
                        $user  = $item;
                    }
                }
                $role = ['student', 'teacher', 'admin'];
                $roleIndex = array_search($user['role'], $role);

                if ($roleIndex !== false) {
                    unset($role[$roleIndex]);
                    array_unshift($role, $user['role']);
                }
                $status = ['Active', 'InActive',];
                $statusIndex = array_search($user['status'], $status);

                if ($statusIndex !== false) {
                    unset($status[$statusIndex]);
                    array_unshift($status, $user['status']);
                }




                $edit = [
                    ['label' => 'Name', 'type' => 'text', 'value' => $user['name'], 'name' => 'name'],
                    ['label' => 'Email', 'type' => 'email', 'value' => $user['email'], 'name' => 'email'],
                    ['label' => 'Address', 'type' => 'text', 'value' => $user['address'], 'name' => 'address'],
                    ['label' => 'Status', 'type' => 'select', 'value' => $user['status'], 'option' => $status, 'name' => 'status'],
                    ['label' => 'Role', 'type' => 'select', 'value' => $user['role'], 'option' =>  $role, 'name' => 'role']
                ];


                foreach ($edit as $item) {

                    if ($item['type'] !== 'select') {


                ?>
                        <div class="form-group">
                            <div>
                                <label for="<?php echo $item['name']; ?>"><?php echo $item['label']; ?></label>
                                <input type="<?php echo $item['type']; ?>" id="<?php echo $item['name']; ?>" name="<?php echo $item['name']; ?>" value="<?php echo $item['value']; ?>">
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="form-group">
                            <div>

                                <label for="<?php echo $item['name']; ?>"><?php echo $item['label']; ?></label>
                                <select id="<?php echo $item['name']; ?>" name="<?php echo $item['name']; ?>">
                                    <?php
                                    foreach ($item['option'] as $ele) {
                                    ?>
                                        <option value="<?php echo $ele; ?>"><?php echo $ele; ?></option>
                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>

                <?php
                    }
                }
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

                echo "sss";
                $query = "DELETE FROM users WHERE id = '$_SESSION[id]'";
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

</body>

</html>