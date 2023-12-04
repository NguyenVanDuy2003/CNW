<?php
include "../../config/connectSQL/index.php";
include "../../config/checkCookie/index.php";

$userId = checkActiveCookie($db);
$sql = "SELECT * FROM users WHERE id = '$userId'";
$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if ($user['role'] === 'admin') {
    header('location: ../admin');
}
$sql = "SELECT id, name, teacher, student, semester, cover FROM course";
$result = $db->query($sql);
$courses = $result->fetch_all(MYSQLI_ASSOC);
foreach ($courses as $index => $course) {
    $students = unserialize($course['student']);
    $teachers = unserialize($course['teacher']);
    if (!(in_array($userId, $students) || in_array($userId, $teachers))) {
        unset($courses[$index]);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="../../components/header/index.css">
    <link rel="stylesheet" href="../../components/footer/index.css">
    <link rel="stylesheet" href="../../extension/pagination/index.css">
    <link rel="stylesheet" href="../../../style/index.css">
    <title>Online learning management system</title>
</head>

<body>
    <?php
    include "../../components/header/index.php";
    ?>

    <main class="d-flex">
        <div class="d-flex jc-spacebetween w-full">
            <div class="courses-detail">
                <h3 class="title-main">My courses</h3>
                <ul class="list-courses-main d-flex gap-20">
                    <?php
                    foreach ($courses as $index => $courseM) {
                        if ($index > 9) {
                            echo '<li style="box-shadow: none"><buton class="btn btn-seemore">All Courses</buton></li>';
                            break;
                        } else {
                            $students = unserialize($courseM['student']);

                            $teachers = unserialize($courseM['teacher']);
                            $teacher_ids = implode(",", $teachers);

                            $query = "SELECT * FROM users WHERE id IN ($teacher_ids)";
                            $res = $db->query($query);

                            if (in_array($userId, $students) || in_array($userId, $teachers)) {
                                echo '<li class="column jc-spacebetween">
                            <div class="subtitle-course d-flex jc-spacebetween" style="background-image: url(' . $courseM['cover'] . ');">
                                <div class="d-flex">';
                                while ($teacher = $res->fetch_assoc()) {
                                    echo '<div>
                                        <img class="pointer" src="' . (isset($teacher["avt"]) ? $teacher["avt"] : "https://cst.hnue.edu.vn/theme/image.php/space/core/1664163203/u/f3") . '" alt="' . $teacher["name"] . '"/>
                                        <p>' . $teacher["name"] . '</p>
                                    </div>';
                                }

                                echo '</div>
                                <button class="pointer">' . $courseM['semester'] . '</button>
                            </div>
                            <div class="contact-course column gap-20 flex-1 jc-spacebetween">
                                <h3>' . $courseM['name'] . '</h3>
                                <form method="get" action="../course/index.php">
                                    <input type="hidden" name="id" value="' . $courseM["id"] . '">
                                    <button class="go-to-course d-flex gap-10 jc-center ai-center">
                                        <img src="https://cdn-icons-png.flaticon.com/512/2436/2436805.png" alt="Go to Course" />
                                        <p>Into Course</p>
                                    </button>
                                </form> 
                            </div>
                        </li>';
                            }
                        }
                        $index++;
                    }
                    ?>
                </ul>
                <?php
                include "../../extension/pagination/index.php";
                ?>
            </div>

            <div class="courses-summed column gap-10">
                <h4 class="txt-center">My courses</h4>
                <ul class="column gap-10 list-courses">
                    <?php
                    foreach ($courses as $index => $course) {
                        if ($index > 10) {
                            echo '<buton class="btn btn-seemore">See More</buton>';
                            break;
                        } else {
                            echo '<li class="d-flex gap-10 ai-start pointer">
                            <img class="icon-class" src="https://cdn-icons-png.flaticon.com/512/9316/9316744.png" alt="class"/>
                            <p>' . $course['name'] . '</p>
                        </li>
                    ';
                            if ($index == count($courses)) {
                                echo '<span>Your entire education</span>';
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </main>

    <?php
    include "../../components/footer/index.php";
    ?>
</body>

</html>