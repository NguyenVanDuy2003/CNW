<?php
include "../../config/connectSQL/index.php";
include "../../config/checkCookie/index.php";
$userId = checkActiveCookie($db);
if (isset($_POST["save"])) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'checkbox') === 0 && $value == 'on') {
            $id = substr($key, 8);
            $sql = "UPDATE question SET approved = '$userId' WHERE id = '$id'";
            $result = $db->query($sql);
        }
    }
}
if (isset($_POST["delete"])) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'checkbox') === 0 && $value == 'on') {
            $id = substr($key, 8);
            $sql = "DELETE FROM question WHERE id = '$id'";
            $result = $db->query($sql);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../components/header/index.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="../../components/footer/index.css">
    <link rel="stylesheet" href="../../extension/snack/index.css">
    <link rel="stylesheet" href="../../../style/index.css">
    <title>Approval questions</title>
</head>

<body>
    <?php
    include '../../components/header/index.php';
    ?>

    <main class="approval column gap-20">
    <div style="margin-top:10px">
            <a href='../course/index.php?id=<?php echo $_GET['id']; ?>' style="padding: 5px 10px;
    background: beige;
    border-radius: 5px;">
                Quay lại
            </a>
        </div>
        <h1>Approval questions</h1>
        <form method="post">
            <table>
                <thead>
                    <tr>
                        <th class="w-4percent">STT</th>
                        <th class='w-15percent'>Request Creator</th>
                        <th>Question</th>
                        <th class='w-10percent'>Image</th>
                        <th class='w-10percent'>Type</th>
                        <th class='w-10percent'>Lesson</th>
                        <th class='w-10percent'>CreateAt</th>
                        <th class='w-10percent'>UpdateAt</th>
                        <th class="w-4percent">Choose</th>
                        <th class="w-2percent"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $courseId = $_GET['id'];
                    $sql = "SELECT id, creator, type, lesson, createAt, updateAt, question, image FROM question WHERE approved = 0 and courseId = $courseId ORDER BY STR_TO_DATE(createAt, '%d/%m/%Y %H:%i:%s') DESC";
                    $result = $db->query($sql);
                    if ($result->num_rows > 0) {
                        $i = 0;
                        while ($row = $result->fetch_assoc()) {
                            $i++;
                            $idQuestion = $row["id"];
                            $question = $row['question'];
                            $creator = $row['creator'];
                            $type = ($row['type'] == "radio") ? "An answer" : (($row['type'] == "checkbox") ? "Many answer" : ("Fill in the answer"));
                            $lesson = $row['lesson'];
                            $createAt = $row['createAt'];
                            $image = $row['image'];
                            $updateAt = $row['updateAt'];
                            $status = (isset($row ['approved']) != 0) ? "Approved" : "Not approved";
                            $sql = "SELECT name FROM users WHERE id = '$creator'";
                            $result2 = $db->query($sql);
                            $name = $result2->fetch_assoc()["name"];
                            echo "
                        <tr>
                            <td class='txt-center w-4percent'>$i</td>
                            <td class='w-15percent'>$name</td>
                            <td>$question</td>
                            <td><img class='" . ($image ? 'image' : 'd-none') . "' src='../../../images/upload/$image'/></td>
                            <td class='w-10percent'>$type</td>
                            <td class='w-10percent'>Lesson $lesson</td>
                            <td class='w-10percent'>$createAt</td>
                            <td class='w-10percent'>$updateAt</td>
                            <td class='w-4percent'>
                                <div class='d-flex jc-center w-full'><input type='checkbox' name='checkbox$idQuestion'/></div>
                            </td>
                            <td class='txt-center pointer w-2percent pst-relative'>
                                <img class='icon-add' src='https://cdn-icons-png.flaticon.com/128/2311/2311523.png'/>
                            </td>
                        </tr>
                        ";
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class='d-flex jc-end w-full pdUD-10 gap-10'>
                <button name='delete' class='btn-1 btn-focus'>Delete</button>
                <button name='save' class='btn-1 btn-focus'>Save</button>
            </div>

        </form>

    </main>

    <?php
    include "../../components/footer/index.php";
    ?>
</body>

</html>