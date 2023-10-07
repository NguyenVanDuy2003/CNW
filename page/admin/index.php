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
                [
                    "icon" => "../../images/admin/dashboard.png",
                    "text" => "Dashboard",
                    "id" => "dashboard",
                    "utilitys" => []
                ],

                [
                    "icon" => "../../images/admin/setting.png",
                    "text" => "Components",
                    "id" => "components",

                    "utilitys" => [
                        "Page1", "Page2"
                    ]
                ],
                [
                    "icon" => "../../images/admin/utilities.png",
                    "text" => "Utilities",
                    "id" => "utilities",
                    "utilitys" => []
                ],
                [
                    "icon" => "../../images/admin/table.png",
                    "text" => "Table",
                    "id" => "table",
                    "utilitys" => []
                ],
            );

            foreach ($sideBarLeft as $item) {
                $icon = $item["icon"];
                $text = $item["text"];
                $utilities = $item["utilitys"];
                $id = $item['id'];
            ?>
                <form class="item">
                    <div name="<?php echo  $id; ?>">
                        <img src="<?php echo $icon; ?>" class="icon" alt="error">
                        <span class="text_icon"><?php echo $text; ?></span>
                        <?php if (!empty($utilities)) { ?>
                            <img src="../../images/admin/chevron_right.png" class="icon" name="icon_show_down" alt="error">
                        <?php } ?>
                    </div>
                    <?php if (!empty($utilities)) { ?>
                        <ul type="none" class="show_down">
                            <?php foreach ($utilities as $text_element) { ?>
                                <li><?php echo $text_element; ?></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </form>
            <?php } ?>
        </div>
        <div id="layout">
            <div id="dashboard">
                <iframe src="../../components/admin/dashboard/index.php"></iframe>
            </div>
            <div id="table" style="display:none">
                <iframe src="../../components/admin/tableUser/index.php"></iframe>
            </div>
            <div id="utilities" style="display:none">Utility</div>
            <div id="page1" style="display:none">page1</div>
            <div id="page2" style="display:none">page2</div>
        </div>
    </main>
</body>
<script src="./index.js"></script>

</html>