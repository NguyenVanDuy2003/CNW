<?php
$userId = checkActiveCookie($db);
$sql = "SELECT name FROM users WHERE id = $userId";
$result = $db->query($sql);
$row = $result->fetch_assoc();
$name = $row['name'];
if (isset($_POST['logout'])) {
    if (isset($_COOKIE['liorion'])) {
        setcookie('liorion', '', time() - (86400 * 30), "/");
    }
    header("location: index.php");
}

?>
<header class="d-flex ai-center pd-10 jc-spacebetween header w-full">
    <div class="d-flex ai-center gap-30">
        <img class="icon-list" src="https://cdn-icons-png.flaticon.com/512/10613/10613684.png" alt="list" />
        <div class="logo">
            <a href='../home'>
                <h3>Liorion</h3>
            </a>
        </div>
    </div>
    <div class="d-flex  ai-center gap-10">
        <hr class="hr-list-icon">
        <div class="d-flex ai-center">
            <img class="icon" src="https://cdn-icons-png.flaticon.com/512/54/54481.png" alt="search" />
            <img class="icon" src="https://cdn-icons-png.flaticon.com/512/1370/1370907.png" alt="message" />
            <img class="icon" src="https://cdn-icons-png.flaticon.com/512/2529/2529521.png" alt="notification" />
        </div>
        <hr class="hr-list-icon">
        <div class="contact">
            <div class="d-flex ai-center gap-10 pointer" id="contact-menu">
                <p class="name">
                    <?php echo $name; ?>
                </p>
                <div class="d-flex ai-center gap-5">
                    <img class="icon-profile" src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                        alt="profile" />
                    <img class="icon-arrow" src="https://cdn-icons-png.flaticon.com/512/10728/10728744.png"
                        alt="arrow" />
                </div>
            </div>
            <?php
            include "../../extension/popover/index.php";
            $ref = $_SERVER["PHP_SELF"] . '?logout=true';
            Popover('contact-menu', '
                    <ul class="list-menu-extension column gap-5">
                        <li class="d-flex gap-5 ai-center">
                            <img class="icon" src="https://cdn-icons-png.flaticon.com/512/10613/10613742.png" alt="profile" />
                            <p>Profile</p>
                        </li>
                        <li class="d-flex gap-5 ai-center">
                            <img class="icon" src="https://cdn-icons-png.flaticon.com/512/1739/1739438.png" alt="Score" />
                            <p>Score Board</p>
                        </li>
                        <li class="d-flex gap-5 ai-center">
                            <img class="icon" src="https://cdn-icons-png.flaticon.com/512/2143/2143131.png" alt="Setting" />
                            <p>Setting</p>
                        </li>
                        <hr class="hr-list-menu">
                        <form method="post">
                            <input type="hidden" name="logout" value="true">
                            <li class="d-flex gap-5 ai-center logout">
                                <img class="icon" src="https://cdn-icons-png.flaticon.com/512/9121/9121688.png" alt="Logout" />
                                <button type="submit" style="background: none; border: none; cursor: pointer;">
                                    <p>Logout</p>
                                </button>
                            </li>
                        </form>

                    </ul>
                ');
            ?>

        </div>
    </div>
</header>