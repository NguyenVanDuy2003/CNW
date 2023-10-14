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
        // $_SESSION['teacher'] = [];
        // $_SESSION['AllTeacher'] = [];
        $data = [
            [
                "title" => "User",
                "value" => "22222",
                "icon" => "../../../images/admin/user.png"
            ], [
                "title" => "Class",
                "value" => "22222",
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