<?php
include "../../config/connectSQL/index.php";
include "../../config/checkCookie/index.php";
include "../../config/getTime/index.php";
include "../../extension/snack/index.php";
$userId = checkActiveCookie($db);
session_start();
if (($_SESSION['id'] != $_GET['id']) && isset($_GET['id'])) {
    $_SESSION['id'] = $_GET['id'];
    $_SESSION['type'] = "checkbox";
    $_SESSION['question'] = "";
    $_SESSION['answer'] = "";
    $_SESSION['answerCorrect'] = "";
}
$idCourse = $_SESSION['id'];
$sql = "SELECT name FROM course WHERE id = '$idCourse'";
$result = $db->query($sql);
$name = $result->fetch_all(MYSQLI_ASSOC);
$nameCourse = $name[0]['name'];

function getForm()
{
    $_SESSION['question'] = $_POST['question'];
    switch ($_SESSION['type']) {
        case 'text':
            $answer = [];
            $answerCorrect = $_POST['answer'];
            $_SESSION['type'] = 'text';
            break;
        case 'radio':
            $i = 1;
            $answer = [];
            while ($_POST["answer$i"]) {
                array_push($answer, $_POST["answer$i"]);
                $i++;
            }
            $answerCorrect = $_POST['answer'];
            $_SESSION['type'] = 'radio';
            break;
        default:
            $i = 1;
            $answer = [];
            $answerCorrect = [];
            while ($_POST["answer$i"]) {
                array_push($answer, $_POST["answer$i"]);
                if ($_POST["cbanswer$i"]) {
                    array_push($answerCorrect, $_POST["answer$i"]);
                }
                $i++;
            }
            $_SESSION['type'] = 'checkbox';
            break;
    }
    $_SESSION['question'] = $_POST['question'];
    $_SESSION['answer'] = $answer;
    $_SESSION['answerCorrect'] = $answerCorrect;
}

function hasDuplicates($array)
{
    $uniqueArray = array_unique($array); // delete item duplicates
    return count($array) !== count($uniqueArray);
}
function validation($db)
{
    getForm();
    $question = $_SESSION['question'];
    $answer = $_SESSION['answer'];
    $answerCorrect = $_SESSION['answerCorrect'];

    // check emply question and answer
    if (!$question) {
        echo showSnack("You must fill out your question completely and cannot leave it blank", false);
        return false;
    }
    if ((count($answer) < $_POST['counter']) && ($_SESSION['type'] != 'text')) {
        echo showSnack("You must fill out your answer completely and cannot leave it blank", false);
        return false;
    }

    // check question
    if (strlen($question) > 15) {
        $spaceCount = substr_count($question, ' ');
        if ($spaceCount < 2) {
            echo showSnack("Invalid question part", false);
            return false;
        }
    } else {
        echo showSnack("Invalid question part", false);
        return false;
    }

    // check answer correct min 1 right answer
    if (($_SESSION['type'] != 'text' && count($answerCorrect) < 1) || ($_SESSION['type'] == 'text' && strlen($answerCorrect) == 0)) {
        echo showSnack("Must choose at least 1 answer", false);
        return false;
    }

    // check answer duplicates
    if (hasDuplicates($answer)) {
        echo showSnack("The answers cannot overlap", false);
        return false;
    }

    // check duplicate question
    $sql = "SELECT * FROM question WHERE question = '$question'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        echo showSnack("The question has been duplicated", false);
        return false;
    }
    return true;
}
function answer($name, $namecb, $type)
{
    $checked = '';
    if (!isset($_POST['completed'])) {
        if (isset($_POST[$namecb])) {
            $checked = 'checked';
        }
    }
    $inputValue = (isset($_POST['completed'])) ? '' : $_POST[$name];
    $isChecked = (isset($_POST['answer']) && in_array($inputValue, $_POST['answer'])) ? 'checked' : '';

    $tick = ($type == "checkbox") ? (
        "<input type='$type' name='$namecb' value='$inputValue' $checked/>"
    ) : (
        "<input type='$type' name='answer[]' value='$inputValue' $isChecked>"
    );

    return "
    <div class='d-flex w-full gap-10 answer'>
        $tick
        <input type='text' name='$name' class='inptxt' placeholder='$name' value='$inputValue' />
    </div>
    ";
}

function question()
{
    if (!isset($_POST['completed'])) {
        if (isset($_POST['question'])) {
            $question = $_POST['question'];
        }
    }
    ;
    return "
    <div class='question column gap-10'>
            <p>Enter Question</p>
            <textarea type='text' rows='4' name='question' class='inptxt' placeholder='Fill in the question content'>$question</textarea>
    </div>
    ";
}

function chooseAnswer($type)
{
    $counter = isset($_POST['counter']) ? $_POST['counter'] : 1;
    if (isset($_POST['incrementAnswer'])) {
        if ($counter < 6) {
            $counter++;
        } elseif (!($counter < 6)) {
            echo showSnack("Can't create too many answers", false);
        }
    }
    if (isset($_POST['decrementAnswer'])) {
        if ($counter > 1) {
            $counter--;
        } else {
            echo showSnack("Cannot delete all answers", false);
        }
    }

    $question = question();
    $html = "
    <div class='column gap-20 manyAnswers'>
        $question
        <div class='answers column gap-10'>
            <div class='w-full d-flex jc-spacebetween ai-center'>
                <p>Enter Answer and choose</p>
                <input type='hidden' name='counter' value='$counter'>
                <div class='d-flex pd-10 gap-20'>
                    <button type='submit' name='incrementAnswer' class='d-flex pointer gap-10 ai-center add-answer " . ($counter < 6 ? 'active' : '') . "'>
                        <img class='icon-add' src='https://cdn-icons-png.flaticon.com/128/11781/11781693.png'/>
                    </button>
                    <button type='submit' name='decrementAnswer' class='d-flex pointer gap-10 ai-center add-answer " . ($counter > 1 ? 'active' : '') . "'>
                        <img class='icon-add' src='https://cdn-icons-png.flaticon.com/128/1214/1214428.png'/>
                    </button>
                </div>
            </div>
    ";

    for ($i = 1; $i <= $counter; $i++) {
        $html .= answer("answer$i", ($type == "radio" ? "answer" : "cbanswer$i"), $type);
    }

    $html .= "
        </div>
    </div>
    ";

    echo $html;
}

function textAnswer()
{
    if (!isset($_POST['completed'])) {
        if (isset($_POST['answer'])) {
            $answer = $_POST['answer'];
        }
    }
    ;
    $question = question();
    echo "
        $question
        <p>Fill to Answer</p>
        <input type='text' name='answer' class='inptxt' placeholder='Fill in the answers' value='$answer'/>
    ";
}

function resetDataForm()
{
    $_SESSION['question'] = "";
    $_SESSION['answer'] = "";
    $_SESSION['answerCorrect'] = "";
}

if (isset($_POST['preview'])) {
    echo validation($db) ? showSnack("Questions are ready to be added", true) : '';
}

if (isset($_POST['save'])) {
    if (validation($db)) {
        $type = $_SESSION['type'];
        $time = getCurrentTimeInVietnam();
        $question = $_POST['question'];
        $answer = serialize($_SESSION['answer']);
        $answerCorrect = serialize($_SESSION['answerCorrect']);
        $courseId = $_SESSION['id'];
        $sql = "INSERT INTO question (creator, approved, lesson, courseId, question, answer, answerCorrect, type, createAt, updateAt) 
        VALUES ('$userId', 0, 1, $courseId, '$question', '$answer', '$answerCorrect', '$type', '$time', '$time')";
        echo $sql;
        $result = $db->query($sql);
        echo showSnack("Question added successfully", true);
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
    <link rel="stylesheet" href="../../extension/pagination/index.css">
    <link rel="stylesheet" href="../../extension/snack/index.css">
    <link rel="stylesheet" href="../../style/index.css">
    <title>Contribute</title>
</head>

<body>
    <?php
    include "../../components/header/index.php";
    ?>
    <main class="contribute column gap-20">
        <h1 class="title">Contribute Question</h1>
        <p>Đóng góp câu hỏi cho môn học <b><?php echo $nameCourse; ?></b></p>
        <div class="d-flex gap-30 jc-spacebetween">
            <form method="post" action="" class="formAddQuestion column gap-20">
                <div class="d-flex gap-20 ai-center">
                    <label>Choose Type Question</label>
                    <a href="?manyAnswer"
                        class="btn pd-10 <?php echo (!isset($_GET['anAnswer']) && !isset($_GET['fillInTheAnswer'])) ? 'btn-focus' : ''; ?>">Many
                        Answer</a>
                    <a href="?anAnswer"
                        class="btn pd-10 <?php echo (isset($_GET['anAnswer'])) ? 'btn-focus' : ''; ?>">An Answer</a>
                    <a href="?fillInTheAnswer"
                        class="btn pd-10 <?php echo (isset($_GET['fillInTheAnswer'])) ? 'btn-focus' : ''; ?>">Fill In
                        The Answer</a>
                </div>

                <?php
                if (isset($_GET['anAnswer'])) {
                    chooseAnswer("radio");
                    $_SESSION['type'] = "radio";
                    // resetDataForm();
                } elseif (isset($_GET['fillInTheAnswer'])) {
                    textAnswer();
                    $_SESSION['type'] = "text";
                    // resetDataForm();
                } else {
                    chooseAnswer("checkbox");
                    $_SESSION['type'] = "checkbox";
                    // resetDataForm();
                }
                ?>

                <div class="d-flex w-full jc-center gap-20">
                    <button name="preview" class="btn pd-10 btn-focus">Preview</button>
                    <button name="save" class="btn pd-10 btn-focus">Save</button>
                </div>
            </form>

            <div class="formPreview column gap-20">
                <div class="d-flex gap-10 ai-center question-preview">
                    <h3>Question number 1:</h3>
                    <p>
                        <?php echo $_SESSION['question'] ?>
                    </p>
                </div>
                <?php
                switch ($_SESSION['type']) {
                    case 'text':
                        $result = $_SESSION['answerCorrect'][0];
                        echo "
                        <input type='text' name='answer_preview' placeholder='Fill in the answer' class='inptxt' readonly/>
                        <p class='answer-text-preview'>Answer Correct: <b>$result</b></p>
                        ";
                        break;
                    default:
                        $answers = $_SESSION['answer'];
                        $answerCorrect = $_SESSION['answerCorrect'];
                        $type = $_SESSION['type'];
                        foreach ($answers as $index => $answer) {
                            $i = $index++;
                            $checked = (in_array($answer, $answerCorrect)) ? 'checked' : '';
                            echo "
                            <div class='d-flex gap-10'>
                                <input type=$type name='cb_answer_preview$i' $checked/>
                                <input type='text' name='answer_preview$i' class='inptxt w-full' value='$answer' readonly/>
                            </div>
                            ";
                        }
                        break;
                }
                ?>
            </div>
        </div>

        <h3>Questions you contributed</h3>

        <table>
            <thead>
                <tr>
                    <th class="w-4percent">STT</th>
                    <th>Question</th>
                    <th class='w-10percent'>Type</th>
                    <th>Lesson</th>
                    <th class='w-15percent'>CreateAt</th>
                    <th class='w-15percent'>UpdateAt</th>
                    <th class='w-10percent'>Status</th>
                    <th class="w-2percent"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $courseId = $_SESSION['id'];
                $sql = "SELECT question, type, lesson, createAt, updateAt, approved FROM question WHERE creator = $userId and courseId = $courseId ORDER BY STR_TO_DATE(createAt, '%d/%m/%Y %H:%i:%s') DESC";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $i = 0;
                    while ($row = $result->fetch_assoc()) {
                        $i++;
                        $question = $row['question'];
                        $type = ($row['type'] == "radio") ? "An answer" : (($row['type'] == "checkbox") ? "Many answer" : ("Fill in the answer"));
                        $lesson = $row['lesson'];
                        $createAt = $row['createAt'];
                        $updateAt = $row['updateAt'];
                        $status = ($row['approved'] != 0) ? "Approved" : "Not approved";
                        echo "
                        <tr>
                            <td class='txt-center w-4percent'>$i</td>
                            <td>$question</td>
                            <td class='w-10percent'>$type</td>
                            <td class='w-10percent'>Lesson $lesson</td>
                            <td class='w-15percent'>$createAt</td>
                            <td class='w-15percent'>$updateAt</td>
                            <td class='w-10percent'>$status</td>
                            <td class='txt-center pointer w-4percent'><img class='icon-add' src='https://cdn-icons-png.flaticon.com/128/2311/2311523.png'/></td>
                        </tr>
                        ";
                    }
                }
                ?>
            </tbody>
        </table>
        <p class="note">Please contact your class instructor or admin to make the approval process faster. Thank you!</p>

    </main>
    <?php
    include "../../components/footer/index.php";
    ?>
</body>

</html>