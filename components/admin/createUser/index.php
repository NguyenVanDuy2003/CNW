<?php
include "../../../config/checkform/index.php";
include "../../../config/connectSQL/index.php";
include '../../../extension/snack/index.php';
include '../../../config/signup/index.php';

if (isset($_POST['create'])) {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    checkFormSignUp($name, $email, $username, $password, $confirm_password, 'on', $role, $db);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./index.css">
    <link rel="stylesheet" href="../../../extension/snack/index.css">
    <link rel="stylesheet" href="../../../style/index.css">
</head>

<body>
    <div class="registration-form">
        <form action="" method="post">
            <div class="form-group">
                <div>

                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" required>
                </div>
            </div>

            <div class="form-group">
                <div>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>

            <div class="form-group">
                <div>

                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
            </div>

            <div class="form-group">
                <div>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>

            <div class="form-group">
                <div>

                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
            </div>

            <div class="form-group">
                <div>

                    <label for="role">Role</label>
                    <select id="role" name="role">
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>


            <input type="submit" class="btn-submit" name="create" value="Create">
        </form>

    </div>
</body>

</html>