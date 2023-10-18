<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./index.css">
</head>

<body>
    <div class="item">
        <div>
            Dashboard
        </div>
        <div>
            <a>Generate reqort</a>
        </div>
    </div>
    <div class="item">
        <?php
        include "../../../config/connectSQL/index.php";

        $sql = "SELECT * FROM users";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $student = [];
        $teacher = [];

        for ($i = 0; $row = $result->fetch_assoc(); $i++) {;
            if (!$row) {
                break;
            }
            if ($row['role'] == 'student') {
                array_push($student, $row);
            }
            if ($row['role'] == 'teacher') {
                array_push($teacher, $row);
            }
        }



        // $_SESSION['teacher'] = [];
        // $_SESSION['AllTeacher'] = [];
        $data = [
            [
                "title" => "User",
                "value" => sizeof($student),
                "icon" => "../../../images/admin/user.png"
            ], [
                "title" => "Teacher",
                "value" => sizeof($teacher),
                "icon" => "../../../images/admin/class.png"
            ],
            [
                "title" => "Class",
                "value" => sizeof($student),
                "icon" => "../../../images/admin/user.png"
            ], [
                "title" => "Quizz",
                "value" => sizeof($teacher),
                "icon" => "../../../images/admin/class.png"
            ],
        ];
        foreach ($data as $item) {
            $title = $item['title'];
            $value = $item['value'];
            $icon = $item['icon'];

        ?>
            <div>
                <div>
                    <div>
                        <p><?php echo $title; ?></p>
                        <span><?php echo  $value; ?></span>
                    </div>
                    <div>
                        <img src="<?php echo $icon; ?>" class="icon" alt="error">
                    </div>
                </div>
            </div>
        <?php
        }

        ?>

    </div>
    <div class="item"></div>
</body>

</html>