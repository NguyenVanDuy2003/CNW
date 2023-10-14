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
        session_start();
        if (!isset($_SESSION['teacher']) || !isset($_SESSION['AllTeacher'])) {
            $_SESSION['teacher'] = [];
            $_SESSION['AllTeacher'] = [];
        }
        $sql = "SELECT * FROM users WHERE role = 'teacher'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $dataTeacher = [];
        while ($item = $result->fetch_assoc()) {
            $dataTeacher[] = $item;
        }
        if (sizeof($_SESSION['AllTeacher']) === 0 && sizeof($_SESSION['teacher']) === 0) {
            $_SESSION['AllTeacher'] = $dataTeacher;
        }

        if (isset($_POST['add'])) {
            $newAllTeacher = [];
            $Teacher = [];
            foreach ($_SESSION['AllTeacher'] as $item) {
                if ($item['id'] == $_POST["maGV"]) {
                    array_push($Teacher, $item['id']);
                } else {
                    array_push($newAllTeacher, $item);
                }
            }
            $_SESSION['AllTeacher'] = $newAllTeacher;
            array_push($_SESSION['teacher'], $Teacher);
            print_r($_SESSION['teacher']);
        }

        if (isset($_POST['remove'])) {
            $Teacher = [];
            foreach ($_SESSION['teacher'] as $item) {
                foreach ($item as $value) {
                    if ($value != $_POST['selectedUsers']) {
                        array_push($Teacher, $value);
                    }
                }
            }
            $_SESSION['teacher'] =  [];
            array_push($_SESSION['teacher'], $Teacher);
            foreach ($dataTeacher as $item) {
                $name = $item['id'];
                if ($item['id'] == $_POST['selectedUsers']) {
                    array_push($_SESSION['AllTeacher'], $item);
                }
            }
        }
        if (isset($_POST['submit'])) {
            // print_r($_SESSION['teacher']);
            $teacher = [];
            foreach ($_SESSION['teacher'] as $item) {
                foreach ($item as $value) {
                    array_push($teacher, $value);
                }
            }
            $teacherString = implode(',', $teacher);
            $teacherString = rtrim($teacherString, ',');
            $title = mysqli_real_escape_string($db, $_POST['title']);

            $query = "INSERT INTO course (teacher, title) VALUES (?, ?)";

            $stmt = $db->prepare($query);

            if ($stmt) {
                $stmt->bind_param('ss', $teacherString, $title);

                if ($stmt->execute()) {
                    // The data has been successfully inserted into the database
                    header("Location: index.php");
                    exit;
                } else {
                    // Handle the error if the query fails
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                // Handle the error if the prepared statement fails
                echo "Error: " . $db->error;
            }

            $_SESSION['teacher'] = [];
            $_SESSION['AllTeacher'] = $dataTeacher;
        }


        ?>



        <h2>Thêm Giảng Viên và Học Sinh</h2>
        <form action="" method="post">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title">

            <label for="optionsDropdown">Giảng Viên:</label>
            <select id="optionsDropdown" name="maGV">
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
                foreach ($item as $value) {
                    foreach ($dataTeacher as $ele) {
                        $id = $ele['id'];
                        $name = $ele['name'];
                        if ($id == $value) {
                            echo '<option value="' .  $id . '" >' .  $name . '</option>';
                        }
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