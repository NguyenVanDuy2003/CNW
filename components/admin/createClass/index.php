<!DOCTYPE html>
<html>

<head>
    <title>Form Thêm Giảng Viên</title>
    <link rel="stylesheet" href="./index.css">
    <link rel="stylesheet" href="../../../extension/snack/index.css">
    <link rel="stylesheet" href="../../../style/index.css">
</head>

<body>
    <div class="container">
        <?php
        include "../../../config/connectSQL/index.php";
        include '../../../extension/snack/index.php';
        include '../../../config/getTime/index.php';
        include '../../../extension/session/index.php';

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['teacher']) || !isset($_SESSION['AllTeacher']) || !isset($_SESSION['student']) || !isset($_SESSION['AllStudent'])) {
            $_SESSION['teacher'] = [];
            $_SESSION['title'] = '';
            $_SESSION['semester'] = 'Học kì I';
            $_SESSION['session'] = 1;
            $_SESSION['AllTeacher'] = [];
            $_SESSION['student'] = [];
            $_SESSION['AllStudent'] = [];
        }
        $sql = "SELECT * FROM users";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $dataTeacher = [];
        $dataStudent = [];

        while ($item = $result->fetch_assoc()) {
            if ($item['role'] === "teacher") {

                array_push($dataTeacher, $item);
            } else if ($item['role'] === "student") {
                array_push($dataStudent, $item);
            }
        }
        if (empty($_SESSION['AllTeacher']) && empty($_SESSION['teacher']) && empty($_SESSION['AllStudent']) && empty($_SESSION['student']) ||  $_SESSION['load'] === true) {
            $_SESSION['load'] === false;
            $_SESSION['AllTeacher'] = $dataTeacher;
            $_SESSION['AllStudent'] = $dataStudent;
        }
        if (!empty($_POST['title'])) {

            $_SESSION['title'] = $_POST['title'];
        }
        if (isset($_POST['semester'])) {

            $_SESSION['semester'] = $_POST['semester'];
        }
        if (isset($_POST['session'])) {

            $_SESSION['session'] = $_POST['session'];
        }
        if (isset($_POST['add'])) {
            $_SESSION['title'] = $_POST['title'];
            $_SESSION['semester'] = $_POST['semester'];
            $_SESSION['session'] = $_POST['session'];

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
                $_SESSION['AllTeacher'] = $newAllTeacher;
                array_push($_SESSION['teacher'], $Teacher);
            } else {
                echo showSnack("You selected is't teacher ", false);
            }
        }

        if (isset($_POST['remove'])) {
            $_SESSION['title'] = $_POST['title'];
            $_SESSION['semester'] = $_POST['semester'];
            $_SESSION['session'] = $_POST['session'];

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

        // add and remove student 
        if (isset($_POST['addStudent'])) {
            $_SESSION['title'] = $_POST['title'];
            $_SESSION['semester'] = $_POST['semester'];
            $_SESSION['session'] = $_POST['session'];
            if ($_POST["HV"] != '------') {
                $newAllStudent = [];
                $student = [];
                foreach ($_SESSION['AllStudent'] as $item) {
                    if ($item['id'] == $_POST["HV"]) {
                        $student = $item['id'];
                    } else {
                        array_push($newAllStudent, $item);
                    }
                }
                $_SESSION['AllStudent'] = $newAllStudent;
                array_push($_SESSION['student'], $student);
            } else {
                echo showSnack("You selected is't student ", false);
            }
        }

        if (isset($_POST['removeStudent'])) {
            $_SESSION['title'] = $_POST['title'];
            $_SESSION['semester'] = $_POST['semester'];
            $_SESSION['session'] = $_POST['session'];

            if (!empty($_POST['selectedStudent'])) {
                $Student = [];
                $newAllStudent = [];
                foreach ($_SESSION['student'] as $item) {
                    if ($item != $_POST['selectedStudent']) {
                        array_push($Student, $item);
                    }
                }
                foreach ($dataStudent as $item) {
                    $name = $item['id'];
                    if ($item['id'] == $_POST['selectedStudent']) {
                        $newAllStudent =  $item;
                    }
                }
                $_SESSION['student'] =  $Student;
                array_push($_SESSION['AllStudent'], $newAllStudent);
            } else {
            }
        }
        //submit
        if (isset($_POST['submit'])) {
            $_SESSION['title'] = $_POST['title'];
            $_SESSION['session'] = $_POST['session'];
            $_SESSION['semester'] = $_POST['semester'];
            // $_SESSION['teacher'] = [];
            // $_SESSION['AllTeacher'] = [];
            // $_SESSION['AllStudent'] = [];


            if (!empty($_SESSION['teacher']) && !empty($_SESSION['title']) && !empty($_SESSION['student']) && !empty($_SESSION['session']) && !empty($_SESSION['semester'])) {

                $student = [1, 2, 6, 7];
                $content = [];
                $teacher = serialize($_SESSION['teacher']);
                $student = serialize($_SESSION['student']);
                $con = serialize($content);
                $time = getCurrentTimeInVietnam();

                $sql = "INSERT INTO course (name, teacher, student, semester, cover, createAt, updateAt, session, content)
            VALUES (?, ?, ?, ?, 'https://cst.hnue.edu.vn/theme/space/pix/default_course.jpg', ?, ?, ?, ?)";

                $stmt = $db->prepare($sql);
                $stmt->bind_param("ssssssss", $_SESSION['title'], $teacher, $student, $_SESSION['semester'], $time, $time, $_SESSION['session'], $con);

                if ($stmt) {
                    if ($stmt->execute()) {
                        $_SESSION['teacher'] = [];
                        $_SESSION['student'] = [];
                        $_SESSION['title'] = '';
                        $_SESSION['AllTeacher'] = [];
                        $_SESSION['AllStudent'] = [];
                        $_SESSION['semester'] = 'Học kì I';
                        $_SESSION['session'] = 1;
                        echo showSnack("Create class success. ", true);

                        header("Location: index.php");
                        exit;
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "Error: " . $db->error;
                }
            }
        }

        ?>



        <h2>Create Class</h2>
        <form action="" method="post">
            <label for="title">Title:</label>
            <input type="text" id="title" value="<?php echo $_SESSION['title']; ?>" name="title">
            <div class="form">
                <div>

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
                </div>
                <div>

                    <label for="optionsDropdown">Sinh Vien:</label>
                    <select id="optionsDropdown" name="HV">
                        <option value="------">------</option>

                        <?php
                        foreach ($_SESSION['AllStudent'] as $item) {
                            $name = $item['name'];
                            $id = $item['id'];
                        ?>
                            <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                        <?php }
                        ?>
                    </select>

                    <input type="submit" name="addStudent" value="Add">
                    <input type="submit" name="removeStudent" value="Remove" ">

                <select id=" selectedStudent" name="selectedStudent" multiple>
                    <?php
                    foreach ($_SESSION['student'] as $item) {
                        foreach ($dataStudent as $ele) {
                            $id = $ele['id'];
                            $name = $ele['name'];
                            if ($id == $item) {
                                echo '<option value="' .  $id . '" >' .  $name . '</option>';
                            }
                        }
                    }
                    ?>
                    </select>
                </div>
            </div>
            <div>
                <select name="semester">

                    <?php
                    $semester = ['Học kì I', 'Học kì II', 'Học kì III'];
                    $semesterIndex = array_search($_SESSION['semester'], $semester);

                    if ($roleIndex !== false) {
                        unset($semester[$semesterIndex]);
                        array_unshift($semester, $_SESSION['semester']);
                    }
                    foreach ($semester as $item) {
                    ?>
                        <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                    <?php
                    }

                    ?>
                </select>
                <div>
                    <label for="session">Session:</label>

                    <input type="number" min="1" value="<?php echo $_SESSION['session']; ?>" max="14" name="session">
                </div>
            </div>

            <div>

                <input type="submit" name="submit" value="Thêm">
            </div>
        </form>
    </div>
</body>

</html