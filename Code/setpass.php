<?php

session_start();


$true = false;

include 'base.php';


if (isset($_GET['email']) && isset($_GET['token'])) {

    $email = $_GET['email'];
    $token = $_GET['token'];

    date_default_timezone_get();
    $date = date("Y-m-d");

    $query = "select * from user where email='$email' and resettoken='$token' and tokenexpire='$date'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        if (mysqli_num_rows($query_run) == 1) {
            $true = true;
        }
    } else {
        $set_password_status = "Link Expired!";
    }
}

if (isset($_POST['set_password'])) {

    $password = $_POST['new_password'];
    $cpassword = $_POST['new_cpassword'];
    $email = $_POST['email'];

    //Password Encripting

    if ($password === $cpassword) {

        $update_password = "update `user` set `pass`='$password', `resettoken`='NULL',`tokenexpire`='NULL' WHERE `email`= '$email'";
        $update_password_run = mysqli_query($con, $update_password);
        if ($update_password_run) {
            $_SESSION['success'] = "Password changed!! Please login ";
            header("Location:login.php");
            ;
        }
    } else {
        $set_password_status = "Passwords not matched!";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/back.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/setpass.css?v=<?php echo time(); ?>">
    <title>Reset Password</title>
</head>

<body>
    <div class="main">
        <?php
        if (isset($set_password_status)) {
            ?>
            <div class="errmsg" id="errmsg">
                <i class="bi bi-exclamation-circle-fill"></i>
                <p>
                    <?php echo $set_password_status; ?>
                    <i onclick="errcancel()" id="errcan" class="bi bi-x-lg"></i>
                </p>

            </div>
            <?php
        }
        ?>
        <?php
        if ($true) {
            ?>
            <div class="box">
                <h1>Reset Password</h1>
                <div class="input">
                    <form action="#" method="post">
                        <input type="hidden" name="email" id="email" value="<?php echo $email; ?>">
                        <br>
                        <input type="password" name="new_password" id="pass" placeholder="Password" required>
                        <br>
                        <input type="password" name="new_cpassword" id="cpass" placeholder="Confirm Password" required>
                        <br>
                        <input type="checkbox" name="show" id="show" onclick="regisshow()">
                        <label for="show">Show password</label>
                        <br>
                        <button name="set_password" id="setpass">Set Password</button>
                    </form>
                </div>
            </div>
            <?php
        }
        ?>
        <script>
            var show2 = document.getElementById("pass");
            var show3 = document.getElementById("cpass");
            var errmsg=document.getElementById("errmsg");
            function regisshow() {       //for showing the password in regis field and 
                if (show2.type == "password") {
                    show2.type = "text";
                    show3.type = "text";
                }
                else {       //for hiding that
                    show2.type = "password";
                    show3.type = "password";
                }
            }
            function errcancel() {
                errmsg.style.display = "none";
            }
        </script>
    </div>
</body>

</html>