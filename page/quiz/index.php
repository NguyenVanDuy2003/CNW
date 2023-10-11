<?php
include "../../config/connectSQL/index.php";
include "../../config/checkCookie/index.php";
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
    <title>Quiz</title>
</head>

<body>
    <?php
    include "../../components/header/index.php";
    ?>

    <main class="quiz d-flex jc-center">
        <div class="column gap-20 form">
            <div class="txt" id="txt">
                <b>L-</b><b>T</b><b>E</b><b>S</b><b>T</b>
            </div>
            <form method='post' class='column gap-30'>
                <?php
                $sql = "SELECT question, answer, type FROM question ORDER BY RAND() LIMIT 10";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $i = 0;
                    while ($row = $result->fetch_assoc()) {
                        $i++;
                        $question = $row['question'];
                        $answers = unserialize($row['answer']);
                        $result_answer = "";
                        if ($row['type'] == "text") {
                            $result_answer = "<input type='text' name='answer$i' placeholder='Fill to answer' class='answer'/>";
                        } elseif ($row['type'] == "checkbox") {
                            foreach ($answers as $index => $answer) {
                                $result_answer .= "
                                <div class='d-flex gap-10 answer'>
                                    <input type='checkbox' name='answer$i_$index' value='$answer'/>
                                    $answer
                                </div>
                                ";
                            }
                        } else {
                            foreach ($answers as $index => $answer) {
                                $result_answer .= "
                                <div class='d-flex gap-10 answer'>
                                    <input type='radio' name='answer$i' value='$answer'>
                                    $answer
                                </div>
                                ";
                            }
                        }


                        echo "
                        <div class='column gap-10 question'>
                            <div class='d-flex gap-20 ai-center'>
                                <div class='btn-question-number'><p>Question $i</p></div>
                                <p>$question</p>
                            </div>
                            $result_answer
                        </div>
                    ";
                    }
                }

                ?>
                <div class="d-flex jc-center"><button class="btn submit">Submit</button></div>
            </form>
        </div>
    </main>

    <?php
    include "../../components/footer/index.php";
    ?>
</body>

</html>