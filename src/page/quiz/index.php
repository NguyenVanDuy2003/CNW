<?php
include "../../config/connectSQL/index.php";
include "../../config/checkCookie/index.php";
include "../../extension/session/index.php";

function countdownTimer($minutes, $seconds)
{
    $totalSeconds = $minutes * 60 + $seconds;
    return $totalSeconds;
}
$minutes = 0;
$seconds = 200000;
$totalSeconds = countdownTimer($minutes, $seconds);
if (!isset($_SESSION['allQuestion'])) {
    $_SESSION['allQuestion'] = [];
}


$_SESSION['score'] = 0;
if (isset($_POST['submit'])) {
    $count = 0;
    $check = [];
    foreach ($_SESSION['allQuestion'] as $item) {
        $count++;
        if ($item['type'] == "text") {
            if (isset($_POST["answer$count"])) {
                array_push($check, ['STT' => $count, 'type' => $item['type'], 'answers' => $_POST["answer$count"]]);
            }
        } elseif ($item['type'] == "checkbox") {
            $answers = [];
            foreach ($item['answer'] as $index => $answer) {

                $answerAll = $count . '_' . $index;
                $checkBoolean = empty(isset($_POST["answer$answerAll"])) ? 0 : $_POST["answer$answerAll"];
                $answers += array($index + 1 => $checkBoolean);
            }
            array_push($check, ['STT' => $count, 'type' => $item['type'], 'answers' => $answers]);
        } else {
            $answers = [];
            foreach ($item['answer'] as $index => $answer) {
                $answerAll = $count . '_' . $index;
                $checkBoolean = empty(isset($_POST["answer$answerAll"])) ? 0 : $_POST["answer$answerAll"];
                $answers += array($index => $checkBoolean);
            }
            array_push($check, ['STT' => $count, 'type' => $item['type'], 'answers' => $answers]);
        }
    }

    foreach ($check as $index => $item) {

        if ($item['type'] == 'text') {
            if (is_array($_SESSION['allQuestion'][$index]['answerCorrect'])) {
                foreach ($_SESSION['allQuestion'][$index]['answerCorrect'] as $value) {
                    if ($value == $item['answers']) {
                        $_SESSION['score']++;
                        continue;
                    }
                }
            } else {
                if ($_SESSION['allQuestion'][$index]['answerCorrect'] == $item['answers'] && !empty($item['answers'])) {
                    $_SESSION['score']++;
                }
            }
        } else if ($item['type'] == 'checkbox') {
            $count = 0;
            $correct = 0;
            foreach ($item['answers'] as $i => $value) {
                if ($value != 0) {
                    $count++;
                    foreach ($_SESSION['allQuestion'][$index]['answerCorrect'] as $answer) {
                        if ($answer == $value) {
                            $correct++;
                        }
                    }
                }
                if ($i == count($item['answers']) && $correct != 0) {
                    if ($correct == $count) {
                        $_SESSION['score']++;
                    }
                }
            }
        } else {
            foreach ($item['answers'] as $i => $value) {
                if (is_array($_SESSION['allQuestion'][$index]['answerCorrect'])) {

                    foreach ($_SESSION['allQuestion'][$index]['answerCorrect'] as $ele) {
                        if ($ele == $value) {
                            $_SESSION['score']++;
                            continue;
                        }
                    }
                } else {
                    if ($_SESSION['allQuestion'][$index]['answerCorrect'] == $value) {
                        $_SESSION['score']++;
                        continue;
                    }
                }
            }
        }
    }
    header("Location: result?id=$_GET[id]");
}
echo $_SESSION['score'];
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
    <link rel="stylesheet" href="../../../style/index.css">
    <title>Quiz</title>
</head>

<body>
    <?php
    include "../../components/header/index.php";
    ?>
    <div id="countdown">
        <div id='tiles'></div>
        <div class="labels">
            <li>Mins</li>
            <li>Secs</li>
        </div>
    </div>
    <main class="quiz d-flex jc-center">
        <div class="column gap-20 form">
            <div class="txt" id="txt">
                <b>L-</b><b>T</b><b>E</b><b>S</b><b>T</b>
            </div>
            <form method='post' action='' id='form' class='column gap-30'>
                <?php
                $id = $_GET['id'];
                $sql = "SELECT question, answer,answerCorrect, type, image FROM question WHERE courseId=$id ORDER BY RAND() LIMIT 10";
                $result = $db->query($sql);
                $allQuestion = [];
                if ($result->num_rows > 0) {
                    $i = 0;
                    while ($row = $result->fetch_assoc()) {
                        $i++;
                        $question = $row['question'];
                        $image = $row['image'];
                        $answers = unserialize($row['answer']);
                        $answerCorrect = unserialize($row['answerCorrect']);
                        array_push($allQuestion, ['type' => $row['type'], 'answer' => $answers, 'answerCorrect' => $answerCorrect]);
                        $result_answer = "";
                        if ($row['type'] == "text") {
                            $result_answer = "<input type='text' name='answer$i' placeholder='Fill to answer' class='answer'/>";
                        } elseif ($row['type'] == "checkbox") {
                            foreach ($answers as $index => $answer) {
                                $answerAll = $i . '_' . $index;
                                $result_answer .= "
                                <div class='d-flex gap-10 answer'>
                                    <input type='checkbox' name='answer$answerAll' value='$answer'/>
                                    $answer
                                </div>
                                ";
                            }
                        } else {
                            foreach ($answers as $index => $answer) {
                                $answerAll = $i . '_' . $index;
                                $result_answer .= "
                                <div class='d-flex gap-10 answer'>
                                    <input type='radio' name='answer$answerAll' value='$answer'>
                                    $answer
                                </div>
                                ";
                            }
                        }

                        echo "
                        <div class='column gap-10 question'>
                            <div class='d-flex gap-20 ai-center'>
                                <div class='btn-question-number'><p>Question $i</p></div>
                                <input class='content-question' value='$question' name='question$i' readonly/>
                            </div>
                            $result_answer
                            <img class='" . (($row['image'] != "") ? 'imgQuestion' : 'd-none') . "' src='" . (isset($image) ? ('../../../images/upload/' . $image) : '') . "' />
                        </div>                    
                    ";
                    }
                    $_SESSION['allQuestion'] = $allQuestion;
                }

                ?>
                <div class="d-flex jc-center">
                    <button class="btn submit" type='submit' name='submit'>Submit</button>
                </div>
            </form>
        </div>
        <script>
            var target_date = new Date().getTime() + (1000 * 3600 * 48); // set the countdown date
            var days, hours, minutes, seconds; // variables for time units

            var countdown = document.getElementById("tiles"); // get tag element

            getCountdown();

            setInterval(function () { getCountdown(); }, 1000);

            function getCountdown() {
                // find the amount of "seconds" between now and target
                var current_date = new Date().getTime();
                var seconds_left = (target_date - current_date) / 1000;

                days = pad(parseInt(seconds_left / 86400));
                seconds_left = seconds_left % 86400;

                hours = pad(parseInt(seconds_left / 3600));
                seconds_left = seconds_left % 3600;

                minutes = pad(parseInt(seconds_left / 60));
                seconds = pad(parseInt(seconds_left % 60));

                // format countdown string + set tag value
                countdown.innerHTML = "<span>" + minutes + "</span><span>" + seconds + "</span>";
            }

            function pad(n) {
                return (n < 10 ? '0' : '') + n;
            }
        </script>
    </main>

    <?php
    include "../../components/footer/index.php";
    ?>
</body>

</html>