<!DOCTYPE html>
<html>

<head>
    <title>Form Thêm Giảng Viên và Học Sinh</title>
    <link rel="stylesheet" href="./index.css">
</head>

<body>
    <div class="container">
        <?php
        include "../../../config/connectSQL/index.php";
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['teacher']) || !isset($_SESSION['AllTeacher'])) {
            $_SESSION['teacher'] = [];
            $_SESSION['AllTeacher'] = [];
            $_SESSION['title'] = '';
        }
        $sql = "SELECT * FROM users WHERE role = 'teacher'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $dataTeacher = [];
        while ($item = $result->fetch_assoc()) {
            array_push($dataTeacher, $item);
        }
        if (empty($_SESSION['AllTeacher']) && empty($_SESSION['teacher'])) {
            $_SESSION['AllTeacher'] = $dataTeacher;
        }
        if (isset($_POST['add'])) {
            $_SESSION['title'] = $_POST['title'];

            if ($_POST["maGV"] != '------') {
                $newAllTeacher = [];
                $Teacher = [];
                foreach ($_SESSION['AllTeacher'] as $item) {
                    if ($item['id'] == $_POST["maGV"]) {
                        $Teacher = $item['id'];
                    } else {
                        array_push($newAllTeacher, $item);
                    }
                }
                print_r($_SESSION['teacher']);
                $_SESSION['AllTeacher'] = $newAllTeacher;
                array_push($_SESSION['teacher'], $Teacher);
            } else {
            }
        }
        if (!empty($_POST['title'])) {

            $_SESSION['title'] = $_POST['title'];
        }
        if (isset($_POST['remove'])) {
            $_SESSION['title'] = $_POST['title'];

            if (!empty($_POST['selectedUsers'])) {
                $Teacher = [];
                $newAllTeacher = [];
                foreach ($_SESSION['teacher'] as $item) {
                    if ($item != $_POST['selectedUsers']) {
                        array_push($Teacher, $item);
                    }
                }
                foreach ($dataTeacher as $item) {
                    $name = $item['id'];
                    if ($item['id'] == $_POST['selectedUsers']) {
                        $newAllTeacher =  $item;
                    }
                }
                $_SESSION['teacher'] =  $Teacher;
                array_push($_SESSION['AllTeacher'], $newAllTeacher);
            } else {
            }
        }
        if (isset($_POST['submit'])) {
            $_SESSION['title'] = $_POST['title'];

            if (!empty($_SESSION['teacher']) && !empty($_SESSION['title'])) {

                $teacher = [];
                foreach ($_SESSION['teacher'] as $item) {
                    echo $item;
                    array_push($teacher, $item);
                }
                $teacherString = implode(',', $teacher);
                $teacherString = rtrim($teacherString, ',');
                $title = mysqli_real_escape_string($db, $_SESSION['title']);

                $query = "INSERT INTO course (teacher, title) VALUES (?, ?)";
                $stmt = $db->prepare($query);
                if ($stmt) {
                    $stmt->bind_param('ss', $teacherString, $title);
                    if ($stmt->execute()) {
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "Error: " . $db->error;
                }
                $_SESSION['teacher'] = [];
                $_SESSION['title'] = '';
                $_SESSION['AllTeacher'] = $dataTeacher;
            }
        }

        ?>



        <h2>Create Class</h2>
        <form action="" method="post">
            <label for="title">Title:</label>
            <input type="text" id="title" value="<?php echo $_SESSION['title']; ?>" name="title">

            <label for="optionsDropdown">Giảng Viên:</label>
            <select id="optionsDropdown" name="maGV">
                <option value="------">------</option>

                <?php
                foreach ($_SESSION['AllTeacher'] as $item) {
                    $name = $item['name'];
                    $id = $item['id'];
                ?>
                    <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                <?php }
                ?>
            </select>

            <input type="submit" name="add" value="Add">
            <input type="submit" name="remove" value="Remove" ">

            <select id=" selectedUsers" name="selectedUsers" multiple>
            <?php
            foreach ($_SESSION['teacher'] as $item) {
                echo $item;
                foreach ($dataTeacher as $ele) {
                    $id = $ele['id'];
                    $name = $ele['name'];
                    if ($id == $item) {
                        echo '<option value="' .  $id . '" >' .  $name . '</option>';
                    }
                }
            }
            ?>
            </select>

            <input type="submit" name="submit" value="Thêm">
        </form>
    </div>
</body>

</html