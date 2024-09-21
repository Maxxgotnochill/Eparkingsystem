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
    $sql_email = "select * from `user` where `email`='$email'";
    $run_email = mysqli_query($con, $sql_email);
    $check_email = mysqli_num_rows($run_email);
    if ($check_email > 0) {
        $err = "Registration Failed!!! This email is already been registered";
    } else {
        if ($pass === $cpass) {
            $query = "insert into `user`(`email`, `user`, `pass`, `ph`, `gender`, `address`) values ('$email','$user','$pass', '$ph', '$gen', '$address')";
            $run = mysqli_query($con, $query);
            $query2 = "select *  from `user` where `user`='$user'";
            $run2 = mysqli_query($con, $query2);
            $val = mysqli_fetch_assoc($run2);
            $id = $val['userid'];
            $_SESSION['id'] = $id;
            $_SESSION['role'] = 1;
            $sql = "insert into `connect` (`userid`, `roleid`) values ('$id', '1') ";
            $run3 = mysqli_query($con, $sql);
            $_SESSION['msg'] = "Registration Successful! Welcome sir.";
            header("Location:adminpanel.php");
        } else {
            $err = "Registration Failed!!! Password and confirm password does not match";
        }
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
    <link rel="stylesheet" href="css/adminres.css?v=<?php echo time(); ?>">
    <title>Admin Registratin</title>
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
                <div class="res">
                    <button id="res" name="res" >Register</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        var showpass = document.getElementById("pass");
        var showcpass = document.getElementById("cpass");
        var errmsg = document.getElementById("errmsg");

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
        function errcancel() {
            errmsg.style.display = "none";
        }
    </script>
</body>

</html>