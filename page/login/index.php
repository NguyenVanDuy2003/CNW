<?php
include "../../config/connectSQL/index.php";
include "../../config/getTime/index.php";
include "../../config/signup/index.php";
include "../../config/signin/index.php";
include "../../config/checkform/index.php";
include "../../config/accessToken/index.php";

if (isset($_GET['btnLogin'])) {
    echo checkFormSignIn($_GET['username_login'], $_GET['password_login'], $db);
}

if (isset($_POST['btnRegister'])) {
    echo checkFormSignUp($_POST['name'], $_POST['email'], $_POST['username'], $_POST['password'], $_POST['cfpassword'], $_POST['agree'], $db);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="../../style/index.css">
    <link rel="stylesheet" href="../../extension/snack/index.css">
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
            <div class="w-full">
                <form method="get" actions="" class="w-full gap-20 d-flex">
                    <button class="btn w-haft pd-15 <?php if (!isset($_GET['Register'])) {
                        echo 'btn-focus';
                    } ?>" name="Login">login</button>
                    <button class="btn w-haft pd-15 <?php if (isset($_GET['Register'])) {
                        echo 'btn-focus';
                    } ?>" name="Register">register</button>
                </form>
            </div>
            <div class="pst-relative w-full">
                <hr class="w-full hr mgUD-10">
                <img src="../../images/login/loading-animation.gif" class="pst-absolute title-hr pd-30 pdUD-5" />
            </div>
            <?php
            if (!isset($_GET['Register'])) {
                echo '<form class="column w-full gap-10 ai-center" method="get" action="">
                        <input name="username_login" id="username_input" type="text" placeholder="Email or username" class="input-basic w-full"/>
                        <input name="password_login" id="password_input" type="password" placeholder="Password" class="input-basic w-full"/>
                        
                        <script>
                            document.getElementById("username_input").addEventListener("blur", function() {
                                var username = this.value;
                                
                                if(localStorage.getItem("rememberAccount")) {
                                    var existingData = JSON.parse(localStorage.getItem("rememberAccount"));
                                    
                                    var account = existingData.find(function(item) {
                                        return item.username === username;
                                    });
                                    
                                    if (account) {
                                        document.getElementById("password_input").value = account.password;
                                    }
                                }
                            });
                        </script>
                            <div class="d-flex jc-spacebetween pd-10 w-full">
                                <div class="d-flex ai-center gap-5">
                                    <input type="checkbox" name="remember"/>
                                    <span>Remember me</span>
                                </div>
                                <p class="link">Forgot password?</p>
                            </div>
                            <input type="submit" name="btnLogin" value="Login" class="w-haft btn btn-success pd-10"/> 
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
                            <input type="submit" name="btnRegister" value="Create Account" class="w-haft btn btn-success pd-10"/> 
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