<?php
session_start();
include "base.php";
if (isset($_POST['res'])) {
    $user = $_POST['user'];
    $email = $_POST['email'];
    $ph = $_POST['ph'];
    $gen = $_POST['gen'];
    $address = $_POST['address'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    $acc = $_POST['acc'];
    $bnk = $_POST['bnk'];
    $brunch = $_POST['brunch'];
    $ifsc = $_POST['ifsc'];
    if ($pass == $cpass) {
        $sql_user = "insert into `user` (`user`, `email`, `pass`, `ph`, `gender`, `address`) values ('$user', '$email', '$pass', '$ph', '$gen', '$address')";
        $run = mysqli_query($con, $sql_user);
        $sql_user_fetch = "select * from `user` where `user`='$user'";
        $run_user_fetch = mysqli_query($con, $sql_user_fetch);
        $val_user = mysqli_fetch_assoc($run_user_fetch);
        $id = $val_user['userid'];
        $_SESSION['id'] = $id;
        $sql_role = "insert into `connect` (`userid`, `roleid`) values ('$id', '2')";
        $run_role = mysqli_query($con, $sql_role);
        $sql_role_fetch = "select * from `connect` where `userid`='$id'";
        $run_role_fetch = mysqli_query($con, $sql_role_fetch);
        $val_role = mysqli_fetch_assoc($run_role_fetch);
        $_SESSION['role'] = $val_role['roleid'];
        $sql_acc="insert into `account` (`acc`,`userid`, `bank`, `brunch`, `ifsc`) values ('$acc', '$id', '$bnk', '$brunch', '$ifsc')";
        $run_acc=mysqli_query($con, $sql_acc);
        header("Location:dashboard.php");
    }
    else{
        $err="Registration Failed!!! Password and confirm password are not same";
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
    <link rel="stylesheet" href="css/regowner.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>

<body>
    <div class="main">
        <?php if(isset($err)){ ?>
            <div class="errmsg" id="errmsg" >
                <i class="bi bi-exclamation-circle-fill"></i>
                <p>
                    <?php echo $err; ?>
                    <i onclick="errcancel()" id="errcan" class="bi bi-x-lg"></i>
                </p>
            </div>
        <?php } ?>
        <?php
        include "navbar.php";
        ?>
        <form action="" method="post">
            <div class="box">
                <div class="accinput" id="resinp">
                    <h1>Register Here</h1>
                    <div class="leftinput">
                        <input type="email" id="email" name="email" class="inp" placeholder="Email" required>
                        <br>
                        <input type="text" id="user" name="user" class="inp" placeholder="Username" required>
                        <br>
                        <div class="gender">
                            <label for="Gender">Gender</label>
                            <br>
                            <input type="radio" id="gen" name="gen" value="male" required>
                            <label for="gen">Male</label>
                            <input type="radio" id="gen1" name="gen" value="female" required>
                            <label for="gen">Female</label>
                            <input type="radio" id="gen2" name="gen" value="other" required>
                            <label for="gen">Other</label>

                        </div>
                    </div>
                    <div class="rightinput">
                        <input type="text" id="ph" name="ph" class="inp" placeholder="Phone Number" required>
                        <br>
                        <input type="password" id="pass" name="pass" class="inp" placeholder="Password" required>
                        <br>
                        <input type="password" id="cpass" name="cpass" class="inp" placeholder="Confirm Password"
                            required>
                        <br>
                        <input type="checkbox" id="check" name="check" class="check" onclick="showpassword()">
                        <label for="check" id="chklabel">Show Password</label>
                    </div>
                    <div class="address">
                        <input type="text" name="address" id="address" placeholder="Address" class="inp" required>
                    </div>
                </div>
            </div>
            <div class="box2">
                    <div class="bankinput" id="bank">
                        <h1>Bank Details</h1>
                        <div class="inputbox">
                            <div class="leftinput">
                                <input type="text" name="acc" id="acc" placeholder="Account Number" class="inp" required>
                                <br>
                                <input type="text" name="bnk" id="bnk" placeholder="Bank" class="inp" required>
                            </div>
                            <div class="rightinput">
                                <input type="text" name="brunch" id="brunch" placeholder="Brunch" class="inp" required>
                                <br>
                                <input type="text" name="ifsc" id="ifsc" placeholder="IFSC Code" class="inp" required>
                            </div>
                        </div>
                        <div class="btnbox">
                            <button id="res" name="res">Register</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>
    <script>
        var showpass = document.getElementById("pass");
        var showcpass = document.getElementById("cpass");
        var errmsg=document.getElementById("errmsg");

        function showpassword() {
            if (showpass.type == "password") {
                showpass.type = "text";
                showcpass.type = "text";
            }
            else {
                showpass.type = "password";
                showcpass.type = "password";
            }
        }
        function errcancel(){
            errmsg.style.display="none";
        }
    </script>
</body>

</html>