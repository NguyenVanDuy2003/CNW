<?php
include "../../extension/snack/index.php";
session_start();
if (!isset($_SESSION['typeQuestion'])) {
    $_SESSION['typeQuestion'] = "checkbox";
    $_SESSION['question'] = "";
    $_SESSION['answer'] = "";
    $_SESSION['answerCorrect'] = "";
    $_SESSION['type'] = "";
}
function answer($name, $namecb, $type)
{
    $checked = '';
    if (!isset($_POST['save'])) {
        if (isset($_POST[$namecb])) {
            $checked = 'checked';
        }
    }
    $inputValue = (isset($_POST['save'])) ? '' : $_POST[$name];
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
    if (!isset($_POST['save'])) {
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
    if (!isset($_POST['save'])) {
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

function preview($question, $answer, $answerCorrect)
{
    $_SESSION['question'] = $question;
    $_SESSION['answer'] = $answer;
    $_SESSION['answerCorrect'] = $answerCorrect;
}

if (isset($_POST['preview'])) {
    switch ($_SESSION['typeQuestion']) {
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
    preview($_POST['question'], $answer, $answerCorrect);
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
        <p>Đóng góp câu hỏi cho môn học <b>COMP 254 - Phân tích thiết kế thuật toán</b></p>
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
                    $_SESSION['typeQuestion'] = "radio";
                } elseif (isset($_GET['fillInTheAnswer'])) {
                    textAnswer();
                    $_SESSION['typeQuestion'] = "text";
                } else {
                    chooseAnswer("checkbox");
                    $_SESSION['typeQuestion'] = "checkbox";
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
                        $result = $_SESSION['answerCorrect'];
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
                                <input type='text' name='answer_preview$i' class='inptxt w-full' value='$answer'/>
                            </div>
                            ";
                        }
                        break;
                }
                ?>
            </div>
        </div>

    </main>
    <?php
    include "../../components/footer/index.php";
    ?>
</body>

</html>