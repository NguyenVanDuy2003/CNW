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
                        <img src="../../images/admin/search.png" class="icon" alt="error">
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
            session_start();
            $_SESSION['page'] = 'dashboard';
            $sideBarLeft = array(
                [
                    "icon" => "../../images/admin/dashboard.png",
                    "text" => "Dashboard",
                    "id" => "dashboard",
                ],

                [
                    "icon" => "../../images/admin/components.png",
                    "text" => "Create class",
                    "id" => "create class",


                ],
                [
                    "icon" => "../../images/admin/components.png",
                    "text" => "Add User To Class",
                    "id" => "Add User To Class",


                ],
                [
                    "icon" => "../../images/admin/utilities.png",
                    "text" => "Utilities",
                    "id" => "utilities",
                ],
                [
                    "icon" => "../../images/admin/management.png",
                    "text" => "User Manager",
                    "id" => "user_manager",
                ],
            );



            foreach ($sideBarLeft as $item) {
                $icon = $item["icon"];
                $text = $item["text"];
                $id = $item['id'];
            ?>
                <form class="item" action="" method="get">
                    <a href="index.php?name=<?php echo  $id; ?>">
                        <img src="<?php echo $icon; ?>" class="icon" alt="error">
                        <span class="text_icon"><?php echo $text; ?></span>

                    </a>

                </form>
            <?php } ?>
        </div>
        <div id="layout">
            <?php if ($_GET['name'] == "dashboard") {

                echo ' <div id="dashboard">
                <iframe src="../../components/admin/dashboard/index.php"></iframe>
            </div>';
            } ?>
            <?php if ($_GET['name'] === 'user_manager') {
                echo ' <div id="user manager" >
                <iframe src="../../components/admin/tableUser/index.php"></iframe>
            </div>';
            } ?>
            <?php if ($_GET['name'] === 'utilities') {
                echo '<div id="utilities">
                utility
            </div>';
            } ?>
            <?php if ($_GET['name'] === 'Add User To Class') {
                echo '<div id="add user to class" > <iframe src="../../components/admin/addUserToClass/index.php"></iframe>
                </div>';
            } ?>
            <?php if ($_GET['name'] === 'create class') {
                echo '<div id="create class"> <iframe src="../../components/admin/createClass/index.php"></iframe>
                </div>';
            } ?>

        </div>
        </div>
    </main>
</body>

</html>