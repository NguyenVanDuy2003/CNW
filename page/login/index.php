<?php
include "../../config/connectSQL/index.php";
include "../../config/createDB/index.php";
include "../../config/signup/index.php";
include "../../config/checkform/index.php";

if (isset($_POST['Register'])) {
    echo checkForm($_POST['name'], $_POST['email'], $_POST['username'], $_POST['password'], $_POST['cfpassword'], $_POST['agree']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="page/login/index.css">
    <link rel="stylesheet" href="bootstrap/index.css">
    <title>Login</title>
</head>
<body>
<main class="column ai-center jc-center h-full">
    <div class="box-shadow pd-20 w-30 gap-20 column ai-center pdUD-30 box-login bd-radius-10">
        <div class="w-full d-flex jc-center pdUD-10">
            <div class="txt-center logo">
                <h3>Liorion</h3>
                <p>Academy Liorion</p>
                </a>
            </div>
        </div>
        <p>
            <?php echo $hello ?>
        </p>
        <div class="w-full">
            <form method="get" actions="" class="w-full gap-20 d-flex">
                <button class="btn w-haft pd-15 <?php if (!isset($_GET['btnRegister'])) {
                    echo 'btn-focus';
                } ?>"
                    name="btnLogin">login</button>
                <button class="btn w-haft pd-15 <?php if (isset($_GET['btnRegister'])) {
                    echo 'btn-focus';
                } ?>"
                    name="btnRegister">register</button>
            </form>
        </div>
        <div class="pst-relative w-full">
            <hr class="w-full hr mgUD-10">
            <img src="images/login/loading-animation.gif" class="pst-absolute title-hr pd-30 pdUD-5" />
        </div>
        <?php
        if (!isset($_GET['btnRegister'])) {
            echo '<form class="column w-full gap-10 ai-center" method="get" action="">
                            <input type="text" placeholder="Email or username" class="input-basic w-full"/>
                            <input type="password" placeholder="Password" class="input-basic w-full"/>
                            <div class="d-flex jc-spacebetween pd-10 w-full">
                                <div class="d-flex ai-center gap-5">
                                    <input type="checkbox"/>
                                    <span>Remember me</span>
                                </div>
                                <p class="link">Forgot password?</p>
                            </div>
                            <input type="submit" name="Login" value="Login" class="w-haft btn btn-success pd-10"/> 
                        </form>';
        } else {
            echo '<form class="column w-full gap-10 ai-center" method="post">
                            <input name="name" type="text" placeholder="Full name" class="input-basic w-full" value="' . (isset($_POST['name']) ? $_POST['name'] : '') . '"/>
                            <input name="email" type="email" placeholder="Email" class="input-basic w-full" value="' . (isset($_POST['email']) ? $_POST['email'] : '') . '"/>
                            <input name="username" type="text" placeholder="Username" class="input-basic w-full" value="' . (isset($_POST['username']) ? $_POST['username'] : '') . '"/>
                            <input name="password" type="password" placeholder="Password" class="input-basic w-full" value="' . (isset($_POST['password']) ? $_POST['password'] : '') . '"/>
                            <input name="cfpassword" type="password" placeholder="Confirm Password" class="input-basic w-full" value="' . (isset($_POST['cfpassword']) ? $_POST['cfpassword'] : '') . '"/>
                            <div class="d-flex jc-center pd-10 w-full">
                                <div class="d-flex ai-center gap-5">
                                    <input type="checkbox" name="agree"/>
                                    <p>I have read and agree to the <span class="link"> terms</span></p>
                                </div>
                            </div>
                            <input type="submit" name="Register" value="Create Account" class="w-haft btn btn-success pd-10"/> 
                        </form>';
        }
        ?>
        <div>
            <p>Need support from admin? <span class="link">Liorion</span></p>
        </div>
    </div>
</main>
</body>
</html>
