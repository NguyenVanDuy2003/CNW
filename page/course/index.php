<?php
if (isset($_POST['updateCourse'])) {
    $targetDirectory = "../../images/manager"; // Thư mục đích
    $tmp_file = $_FILES['uploadCover']['tmp_name']; // Đường dẫn tạm thời của tệp tải lên

    // Xác định đường dẫn đầy đủ cho tệp đích
    $targetPath = $targetDirectory . '/' . basename($_FILES['uploadCover']['name']);

    // Di chuyển tệp tải lên từ đường dẫn tạm thời đến thư mục đích
    if (move_uploaded_file($tmp_file, $targetPath)) {
        echo "Tệp đã được lưu vào thư mục images.";
    } else {
        echo "Lỗi khi di chuyển tệp tải lên.";
    }
}
?>

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
        <?php echo isset($courses['nameCourse']); ?>
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
            <div class='column gap-10 mgUD-10'>
                <form method="get" action="../approval/index.php">
                    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                    <button class="d-flex ai-center btn-tick pointer gap-10 btn-donation approval"
                        data-count="<?php $id=$_GET['id']; $sql = "SELECT * FROM question WHERE approved = 0 and courseId = $id";
                        $result = $db->query($sql);
                        echo $result->num_rows ?>">
                        <img class="icon-donation" src="https://cdn-icons-png.flaticon.com/128/5442/5442020.png" />
                        Approval questions
                    </button>
                </form>
                <form method="get" action="../contribute/index.php">
                    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                    <button class="d-flex ai-center btn-tick pointer gap-10 btn-donation">
                        <img class="icon-donation" src="https://cdn-icons-png.flaticon.com/128/5432/5432915.png" />
                        Contribute questions
                    </button>
                </form>
            </div>
        </div>
        <div class="d-flex gap-20 ai-center">
            <button id="btn-createCourse" class="gap-10 ai-center btn-tick pointer w-fit <?php echo ($isTeacher ? 'd-flex' : 'd-none') ?>">
                <img class="icon-donation" src="https://cdn-icons-png.flaticon.com/128/4074/4074958.png" />
                Create Lesson</button>
            <button id="btn-detailCourse" class="gap-10 ai-center btn-tick pointer w-fit <?php echo ($isTeacher ? 'd-flex' : 'd-none') ?>">
                <img class="icon-donation" src="https://cdn-icons-png.flaticon.com/128/1150/1150592.png" />
                Detail Course</button>
            <?php
            include "../../extension/modal/index.php";
            Modal('btn-createCourse', '
                <h2>Create new lesson</h2>
                <hr>
                <h3>Lesson information</h3>
                <form>
                    <div>
                        <label>Title</label>
                        <input name="title" type="text"/>
                    </div>
                    <div>
                        <label>Title</label>
                        <input name="title" type="text"/>
                    </div>
                    <div>
                        <label>Title</label>
                        <input name="title" type="text"/>
                    </div>
                    <div>
                        <label>Title</label>
                        <input name="title" type="text"/>
                    </div>
                </form>
            ');
            $name_course = $courses['name'];
            $teacher_ids = implode(",", $teachers);
            $student_ids = implode(",", $students);
            $query = "SELECT id, name FROM users WHERE id IN ($teacher_ids)";
            $result = $db->query($query);
            $teacherElement = "";
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                $i++;
                $nameTeacher = $row['name'];
                $teacherElement .= "
                <li class='d-flex jc-spacebetween ai-center pd-10'>
                    <div class='d-flex gap-10 ai-center'>
                        <img class='w-icon-15' src='https://cdn-icons-png.flaticon.com/512/847/847969.png'/>
                        <input type='text' name='teacher$i' value='$nameTeacher' readonly/>
                    </div>
                    <img class='w-icon-15 pointer' src='https://cdn-icons-png.flaticon.com/128/1632/1632708.png'/>
                </li>
                ";
            }
            $query = "SELECT id, name FROM users WHERE id IN ($student_ids)";
            $result = $db->query($query);
            $studentElement = "";

            $i = 0;
            while ($row = $result->fetch_assoc()) {
                $i++;
                $nameStudent = $row['name'];
                $studentElement .= "
                <li class='d-flex jc-spacebetween ai-center pd-10'>
                    <div class='d-flex gap-10 ai-center'>
                        <img class='w-icon-15' src='https://cdn-icons-png.flaticon.com/512/847/847969.png'/>
                        <input type='text' name='student$i' value='$nameStudent' readonly/>
                    </div>
                    <img class='w-icon-15 pointer' src='https://cdn-icons-png.flaticon.com/128/1632/1632708.png'/>
                </li>
                ";
            }
            $session = $courses['session'];
            $semester = $courses['semester'];
            Modal('btn-detailCourse', "
                <div class='column gap-20'>
                    <h1>$name_course</h1>
                    <hr>
                    <h3>Course information</h3>
                    <form class='column gap-20' method='post' enctype='multipart/form-data'>
                        <div class='d-flex ai-center gap-20'>
                            <label>Title</label>
                            <input class='input w-full' name='title' type='text' placeholder='Course title' value='$name_course'/>
                        </div>
                        <div class='d-flex gap-30 ai-center jc-spacebetween'>
                            <div class='d-flex ai-center gap-20'>
                                <label>Sessions</label>
                                <input class='session input' name='session' type='number' placeholder='Number of sessions' value='$session'/>
                            </div class='d-flex ai-center gap-20'>
                            <div>
                                <label>Semester</label>
                                <input class='input' name='semester' type='text' placeholder='Semester' value='$semester'/>
                            </div>
                        </div>
                        <div class='d-flex jc-spacebetween ele-list'>
                            <div class='column gap-10'>
                                <div class='d-flex gap-10 ai-center'>
                                    <label>Teacher</label>
                                    <img class='create-peo w-icon-15 pointer' src='https://cdn-icons-png.flaticon.com/128/4074/4074958.png'/>
                                </div>
                                <input class='input' type='search'  placeholder='Look for information'/>
                                <ul class='column'>
                                $teacherElement
                                </ul>
                            </div>
                            <div class='column gap-10'>
                                <div class='d-flex gap-10 ai-center'>
                                    <label>Student</label>
                                    <img class='create-peo w-icon-15 pointer' src='https://cdn-icons-png.flaticon.com/128/4074/4074958.png'/>
                                </div>
                                <input class='input' type='search' placeholder='Look for information'/>
                                <ul class='column'>
                                $studentElement
                                </ul>
                            </div>
                        </div>
                        <div class='cover'>
                            <label>Cover</label>
                            <div class='d-flex gap-20 pointer'>
                                <img id='cover' src='https://cst.hnue.edu.vn/theme/space/pix/default_course.jpg' alt='Cover Image'>
                                <div class='d-flex ai-center jc-center pointer' id='upload-trigger'>
                                    <img class='w-icon-25' src='https://cdn-icons-png.flaticon.com/128/5817/5817702.png'/>
                                    <input type='file' name='uploadCover' id='file-upload-input' class='d-none' accept='image/*'>
                                </div>
                            </div>

                            <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var uploadTrigger = document.getElementById('upload-trigger');
                                var fileInput = document.getElementById('file-upload-input');
                                var coverImage = document.getElementById('cover');

                                uploadTrigger.addEventListener('click', function () {
                                    fileInput.click();
                                });

                                fileInput.addEventListener('change', function () {
                                    var selectedFile = fileInput.files[0];
                                    if (selectedFile) {
                                        var objectURL = URL.createObjectURL(selectedFile);
                                        coverImage.src = objectURL;
                                    }
                                });
                            });
                            </script>

                        </div>
                        <hr class='w-full mgUD-20'>
                        <div class='d-flex jc-center w-full'>
                            <button class='btn btn-submit pd-15 w-fit' name='updateCourse'>Save</button>
                        </div>
                    </form>
                </div>
            ");
            ?>
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