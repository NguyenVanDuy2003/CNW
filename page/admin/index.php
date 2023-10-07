<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="./style.css" />
    <link rel="stylesheet" href="../../style/index.css">

</head>

<body>
    <main id="container">
        <div id="nawBar">
            <div id="item_left">
                <div>
                    <input type="text" placeholder="Search for...">
                    <div>
                        <img src="../../images/admin/chevron_right.png" class="icon" alt="error">
                    </div>
                </div>
            </div>
            <div id="item_right">
                <?php
                $icon = [
                    "../../images/admin/notification.png",
                    "../../images/admin/email.png",
                ];

                foreach ($icon as $item) {
                ?>
                    <div>
                        <img src="<?php echo $item ?>" class="icon" alt="error">
                    </div>
                <?php
                }

                ?>

                <div>
                    <label for="avata">Name</label>
                    <img src="../../images/admin/avatar.png" class="icon" name="avatar" alt="error">
                </div>
            </div>
        </div>
        <div id="logo">
            <div class="txt-center logo">
                <h3>Liorion</h3>
                <p>Academy Liorion</p>
                </a>
            </div>
        </div>
        <div id="sideBarLeft">

            <?php
            $sideBarLeft = array(
                "dashboard" => [
                    [
                        "icon" => "../../images/admin/dashboard.png",
                        "text" => "Dashboard",
                        "utilitys" => []
                    ],
                ],
                "interface" => [

                    [
                        "icon" => "../../images/admin/setting.png",
                        "text" => "Components",
                        "utilitys" => [
                            "duy", "duy", "duy", "duy",
                        ]
                    ],
                    [
                        "icon" => "../../images/admin/utilities.png",
                        "text" => "Utilities",
                        "utilitys" => []
                    ],
                ],

            );

            foreach ($sideBarLeft as $key => $value) {
            ?>
                <hr />
                <?php
                if ($key !== "dashboard") {
                ?>
                    <p class="text_intro"><?php echo $key; ?></p>
                <?php
                }

                ?>

                <?php
                if (is_array($value)) {
                    foreach ($value as $item) {
                        $icon = $item["icon"];
                        $text = $item["text"];
                        $utility = $item["utilitys"];
                ?>

                        <form class="item" action="" method="post">
                            <div name="<?php echo $key; ?>">
                                <img src="<?php echo $icon; ?>" class="icon" alt="error">
                                <a class="text_icon" href="#<?php echo $key; ?>"><?php echo $text; ?></a>
                                <?php
                                if ($utility !== []) {
                                ?>

                                    <img src=" ../../images/admin/chevron_right.png" class="icon" name="icon_show_down" alt="error">
                                <?php } ?>
                            </div>
                            <?php
                            if ($utility !== []) {
                            ?>

                                <ul type="none" class="show_down">
                                    <?php
                                    foreach ($utility as $element) {
                                        $text_element = $element;
                                    ?>
                                        <li><?php echo $text_element; ?></li>
                                    <?php
                                    }

                                    ?>
                                </ul>
                            <?php
                            }

                            ?>

                        </form>
                <?php
                    }
                }
                ?>
            <?php
            }
            ?>



        </div>

        <div id="dashboard">
            <div class="item">
                <div>
                    Dashboard
                </div>
                <div>
                    <a>Generate reqort</a>
                </div>
            </div>
            <div class="item">
                <div>
                    <div>
                        <p>Sum User</p>
                        <span>2222222</span>
                    </div>
                    <div>
                        <img src="../../images/admin/dashboard.png" class="icon" alt="error">
                    </div>
                </div>
                <div>
                    <div>
                        <p>Sum GV</p>
                        <span>2222222</span>
                    </div>
                    <div>
                        <img src="../../images/admin/dashboard.png" class="icon" alt="error">
                    </div>
                </div>
            </div>
            <div class="item"></div>
        </div>
    </main>
</body>
<script src="./index.js"></script>

</html>