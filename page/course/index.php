<?php
include "../../config/connectSQL/index.php";
include "../../config/checkCookie/index.php";

$userId = checkActiveCookie($db);
$id = $_GET['id'];
$sql = "SELECT * FROM course WHERE id = '$id'";
$result = $db->query($sql);
$courses = $result->fetch_all(MYSQLI_ASSOC);
$courses = $courses[0];
$students = unserialize($courses['student']);
$teachers = unserialize($courses['teacher']);
$isTeacher = false;
if (!(in_array($userId, $students) || in_array($userId, $teachers))) {
    header("Location: ../error");
} elseif (in_array($userId, $teachers)) {
    $isTeacher = true;
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
    <link rel="stylesheet" href="../../extension/pagination/index.css">
    <link rel="stylesheet" href="../../style/index.css">
    <title>
        <?php echo $courses['nameCourse']; ?>
    </title>
</head>

<body>
    <?php
    include "../../components/header/index.php";
    ?>

    <main class="column gap-30 course">
        <div class="d-flex jc-spacebetween ai-center">
            <h1>
                <?php echo $courses['name']; ?>
            </h1>
            <form method="get" action="../contribute/index.php">
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <button class="d-flex ai-center btn-tick pointer gap-10 btn-donation">
                    <img class="icon-donation" src="https://cdn-icons-png.flaticon.com/128/5432/5432915.png" />
                    Contribute questions
                </button>
            </form>
        </div>
        <div class="d-flex gap-20 ai-center">
            <button class="gap-10 ai-center btn-tick pointer w-fit <?php echo ($isTeacher ? 'd-flex' : 'd-none') ?>">
                <img class="icon-donation" src="https://cdn-icons-png.flaticon.com/128/4074/4074958.png" />
                Create Lesson</button>
            <button class="gap-10 ai-center btn-tick pointer w-fit <?php echo ($isTeacher ? 'd-flex' : 'd-none') ?>">
                <img class="icon-donation" src="https://cdn-icons-png.flaticon.com/128/1150/1150592.png" />
                Detail Course</button>
        </div>
        <?php
        $data = unserialize($courses['content']);
        foreach ($data as $index => $detailCourse) {
            $i = $index + 1;
            echo '
                <div class="lesson pd-20 column gap-20">
                <h3>' . "Lesson $i: " . $detailCourse['title'] . '</h3>
            ';
            foreach ($detailCourse['detailLesson'] as $article) {
                echo '
                    <div class="d-flex gap-10 jc-spacebetween ai-center">
                        <div class="d-flex gap-10 ai-center">
                            <img class="icon-of-lesson" src="https://cdn-icons-png.flaticon.com/512/9800/9800294.png" />
                            <a href=' . $article['href'] . '><p class="title-of-lesson pointer">' . $article['title'] . '</p></a>
                        </div>
                        <button class="btn-tick pointer ' . ($article["status"] ? "complete" : "") . '">' . ($article["status"] ? "Hoàn thành" : "Đánh dấu hoàn thành") . '</button>
                    </div>
                    <hr>
                ';
            }
            echo '  
                </div>
            ';
        }
        ?>

    </main>

    <?php
    include "../../components/footer/index.php";
    ?>
</body>

</html>