<?php
session_start();
include "base.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['regis'])) {
    $email = $_POST['email'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    $ph = $_POST['ph'];
    $gender = $_POST['gen'];
    $address = $_POST['add'];
    $sql_email = "select * from `user` where `email`='$email'";
    $run_email = mysqli_query($con, $sql_email);
    $check_email = mysqli_num_rows($run_email);
    if ($check_email > 0) {
        $err = "Registration Failed!!! This email is already been registered";
    } else {
        if ($pass === $cpass) {
            $query = "insert into `user`(`email`, `user`, `pass`, `ph`, `gender`, `address`) values ('$email','$user','$pass', '$ph', '$gender', '$address')";
            $run = mysqli_query($con, $query);
            $query2 = "select *  from `user` where `user`='$user'";
            $run2 = mysqli_query($con, $query2);
            $val = mysqli_fetch_assoc($run2);
            $id = $val['userid'];
            $_SESSION['id'] = $id;
            $_SESSION['role'] = 3;
            $sql = "insert into `connect` (`userid`, `roleid`) values ('$id', '3') ";
            $run3 = mysqli_query($con, $sql);
            $_SESSION['msg'] = "Registration Successful! Welcome";
            header("Location:car.php?key=0");
        } else {
            $err = "Registration Failed!!! Password and confirm password does not match";
        }
    }
}
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $query = "select *  from `user` where `email`='$email' and `pass`='$pass'";
    $run = mysqli_query($con, $query);
    $check = mysqli_num_rows($run);
    if ($check > 0) {
        $val = mysqli_fetch_assoc($run);
        $id = $val['userid'];
        $_SESSION['id'] = $id;
        $sql = "select * from `connect` where `userid`='$id'";
        $run3 = mysqli_query($con, $sql);
        $val2 = mysqli_fetch_assoc($run3);
        $role = $val2['roleid'];
        $_SESSION['role'] = $role;
        if ($role == 2) {
            $_SESSION['msg'] = "Login Successful! Welcome";
            header("Location:dashboard.php");
        } else if ($role == 3) {
            $_SESSION['msg'] = "Login Successful! Welcome";
            header("Location:index.php");
        } else if ($role == 1) {
            $_SESSION['msg'] = "Login Successful! Welcome";
            header("Location:adminpanel.php");
        }
    } else {
        $err = "Login Failed!!! Incorrect login details please enter corrtct details";
    }
}
if (isset($_POST['forgot'])) {
    $email = $_POST['foremail'];
    $sql_user = "select * from `user` where `email`='$email'";
    $val = mysqli_fetch_assoc(mysqli_query($con, $sql_user));
    $name = $val['user'];
    $check = mysqli_num_rows(mysqli_query($con, $sql_user));
    if ($check == 1) {
        $resettoken = bin2hex(random_bytes(16));
        date_default_timezone_get();
        $date = date("Y-m-d");
        $update_run = mysqli_query($con, "update `user` set `resettoken`='$resettoken', `tokenexpire`='$date' where `email`='$email'");
        if (($update_run) && (sendmail($email, $name, $resettoken))) {
            $success = "Mail sent!!! Please check your email to set new password ";
        }
    } else {
        $err = "email not found please register";
    }
}
function sendmail($email, $name, $resettoken)
{
    require "PHPMailer/PHPMailer.php";
    require "PHPMailer/Exception.php";
    require "PHPMailer/SMTP.php";
    $mail = new PHPMailer(true);

    try {
        //Server settings

        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.hostinger.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'ratul@toolify.online'; //SMTP username
        $mail->Password = 'ratul123##RR'; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('ratul@toolify.online', 'E-Park');
        $mail->addAddress($email, $name); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'this is the mail for changing your password' . $name;
        $mail->Body = "<a href='http://localhost/project/setpass.php?email=$email&token=$resettoken'>click here to change password</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/back.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>">

    <title>Login</title>
</head>

<body>
    <div class="main">
        <?php if (isset($err)) { ?>
            <div class="errmsg" id="errmsg">
                <i class="bi bi-exclamation-circle-fill"></i>
                <p>
                    <?php echo $err; ?>
                    <i onclick="errcancel()" id="errcan" class="bi bi-x-lg"></i>
                </p>
            </div>
        <?php } ?>
        <?php
        if (isset($_SESSION['success'])) { ?>
            <div class="smsg" id="smsg">
                <i class="bi bi-exclamation-circle-fill"></i>
                <p>
                    <?php echo $_SESSION['success']; ?>


                    <i onclick="scancel()" id="errcan" class="bi bi-x-lg"></i>
                </p>
            </div>
        <?php }
        unset($_SESSION['success']);
        ?>
        <?php
        if (isset($success)) { ?>
            <div class="smsg" id="successmsg">
                <i class="bi bi-exclamation-circle-fill"></i>
                <p>
                    <?php echo $success; ?>
                    <i onclick="successcancel()" id="errcan" class="bi bi-x-lg"></i>
                </p>
            </div>
        <?php }
        unset($_SESSION['$success']);
        ?>
        <?php
        include "navbar.php";
        ?>
        <div class="box">
            <div class="inp-fields" id="login">
                <h1>Login Here</h1>
                <div class="linput">
                    <form action="" method="post">
                        <input type="email" class="inp" id="lemail" name="email" placeholder="Email" required>
                        <br>
                        <input type="password" class="inp" name="pass" id="lpass" placeholder="Password" required>
                        <br>
                        <input type="checkbox" name="lccheck" id="lcheck" class="inpcheck" onclick="loginshow()">
                        <label for="lcheck" id="check">Show Password</label>
                        <br>
                        <button name="login" id="login-btn">Login</button>
                        <br>
                        <span onclick="forgshow()">Forgot Password?</span>
                    </form>
                </div>
            </div>
            <div class="inp-fields" id="register">
                <h1>Register</h1>
                <div class="rinput">
                    <form action="" method="post">
                        <div class="rlinp">
                            <input type="email" name="email" id="email" class="inp" placeholder="Email" required>
                            <br>
                            <input type="text" name="user" id="user" class="inp" placeholder="Full Name" required>
                            <br>

                            <div class="gender">
                                <label for="gen" id="genleb">Gender</label>
                                <br>
                                <input type="radio" name="gen" id="gen" value="male">
                                <label for="gen">Male</label>
                                <input type="radio" name="gen" id="gen" value="female">
                                <label for="gen">Female</label>
                                <input type="radio" name="gen" id="gen" value="other">
                                <label for="gen">Other</label>
                            </div>
                        </div>
                        <div class="rrinp">
                            <input type="text" name="ph" id="ph" class="inp" placeholder="Phone Number">
                            <br>
                            <input type="password" name="pass" id="rpass" class="inp" placeholder="Password" requierd>
                            <br>
                            <input type="password" name="cpass" id="cpass" class="inp" placeholder="Confirm Password"
                                required>
                            <br>
                            <input type="checkbox" name="rcheck" id="rcheck" class="inpcheck" onclick="regisshow()">
                            <label for="rcheck" id="check">Show Password</label>
                        </div>
                        <div class="add">
                            <input type="text" name="add" id="add" class="inp" placeholder="Address">
                        </div>
                        <button name="regis" id="regis-btn">Register</button>
                    </form>
                </div>
                <div class="redirect">
                    <div class="owner">
                        <a href="regowner.php">Owner Signin</a>
                    </div>
                    <div class="admin">
                        <!-- <a href="adminres.php">Admin Signin</a> -->
                    </div>
                </div>
            </div>
            <div class="toggle">
                <div id="btn1"></div>
                <form action="" method="post">
                    <button name="tlogin" id="tlogin" class="btn" onclick="loginform()">Login</button>
                    <button name="tregis" id="tregis" class="btn" onclick="registerform()">Register</button>
                </form>
            </div>
            <div class="forgot" id="forg">
                <i onclick="cancel()" id="forgotpass" class="bi bi-x-lg"></i>
                <form action="#" method="post">
                    <input type="email" id="foremail" name="foremail" placeholder="Email" required>
                    <br>
                    <button id="forbtn" name="forgot">Request Reset Link via Email</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        var login = document.getElementById("login");     //loging box
        var register = document.getElementById("register");      //registeration box
        var btn1 = document.getElementById("btn1");      //sliding part
        var tlogin = document.getElementById("tlogin");        //button for opeing the login form  
        var tregis = document.getElementById("tregis");        // button for opening the registration form
        var show = document.getElementById("lpass");      //password field on login 
        var show2 = document.getElementById("rpass");     //password field on registeation 
        var show3 = document.getElementById("cpass");     //confirm password field for the same
        var luser = document.getElementById("luser");     //username field on login form
        var forg = document.getElementById("forg");      //forgot password box
        var loginbtn = document.getElementById("login-btn");     //login button
        var lcheck = document.getElementById("lcheck");        //check box in login form
        var errmsg = document.getElementById("errmsg");
        var smsg = document.getElementById("smsg");
        var successmsg = document.getElementById("successmsg");


        function registerform() {     //for slide open the registeation page
            login.style.left = "-690px";
            register.style.left = "65px";
            btn1.style.left = "150px";
            tlogin.style.color = "black";
            tregis.style.color = "white";
            event.preventDefault();
        }
        function loginform() {       //for returning to the login page
            login.style.left = "65px";
            register.style.left = "690px";
            btn1.style.left = "0px";
            tlogin.style.color = "white";
            tregis.style.color = "black";;
            event.preventDefault();
        }
        function loginshow() {       //for showing the password in login field and 
            if (show.type == "password") {
                show.type = "text";
            }
            else {                //this is for hiding that
                show.type = "password";
            }
        }
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
        function forgshow() {        //this disables the login form and disclose the forgot password box
            forg.style.display = "block";
            luser.setAttribute("disabled", "true");
            tlogin.setAttribute("disabled", "true");
            tregis.setAttribute("disabled", "true");
            show.setAttribute("disabled", "true");
            loginbtn.setAttribute("disabled", "true");
            lcheck.setAttribute("disabled", "true");
        }
        function cancel() {      //this enables the login form and hides tha forgot password field
            forg.style.display = "none";
            luser.removeAttribute("disabled");
            tlogin.removeAttribute("disabled");
            tregis.removeAttribute("disabled");
            show.removeAttribute("disabled");
            loginbtn.removeAttribute("disabled");
            lcheck.removeAttribute("disabled");
        }

        function errcancel() {
            errmsg.style.display = "none";
        }
        function scancel() {
            smsg.style.display = "none";
        }
        function successcancel() {
            successmsg.style.display = "none";
        }
    </script>
</body>

</html>