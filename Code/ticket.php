<?php
session_start();
include "base.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['carid'])) {
    $tid = $_GET['tid'];
    $ticket = $_GET['ticket'];
    $spotno = $_GET['spotno'];
    $amount = $_GET['amount'];
    date_default_timezone_set("Asia/kolkata");
    $date = date("Y-m-d");
    $time = date("H:i");
    $tstart = $_SESSION['tstart'];
    $tend = $_SESSION['tend'];
    $dstart = $_SESSION['dstart'];
    $dend = $_SESSION['dend'];
    $userid = $_SESSION['id'];
    $carid = $_SESSION['carid'];
    $sql_user = "select * from `user` where `userid`='$userid'";
    $val_user = mysqli_fetch_assoc(mysqli_query($con, $sql_user));
    $username = $val_user['user'];
    $email = $val_user['email'];
    $gender = $val_user['gender'];
    $ph = $val_user['ph'];
    $address = $val_user['address'];
    $pid = $_SESSION['pid'];
    $sql_parking = "select * from `parking` where `pid`='$pid'";
    $val_parking = mysqli_fetch_assoc(mysqli_query($con, $sql_parking));
    $pname = $val_parking['pname'];
    $place = $val_parking['place'];
    $city = $val_parking['city'];
    $dist = $val_parking['dist'];
    $paddress = $place . ", " . $city . ", " . $dist;
    $owneruserid = $val_parking['userid'];
    $sql_car = "select * from `car` where `carid`='$carid'";
    $val_car = mysqli_fetch_assoc(mysqli_query($con, $sql_car));
    $no = $val_car['no'];
    $sql_route = "select * from `route` where `spotno`='$spotno'";
    $val_route = mysqli_fetch_assoc(mysqli_query($con, $sql_route));
    $route = $val_route['route'];
    $sql_booking = "insert into `booking` (`userid`, `pid`, `carid`,`spotno`, `ticket`, `dstart`, `dend`, `tstart`, `tend`) values ('$userid', '$pid','$carid', '$spotno', '$ticket', '$dstart', '$dend', '$tstart', '$tend')";
    $urn_booking = mysqli_query($con, $sql_booking);
    $sql_booking2 = "select * from `booking` where `pid`='$pid' and `spotno`='$spotno' and `dstart`='$dstart' and `dend`='$dend' and `tstart`='$tstart' and `tend`='$tend'";
    $val_booking2 = mysqli_fetch_assoc(mysqli_query($con, $sql_booking2));
    $bid = $val_booking2['bid'];
    $sql_payment = "insert into `payment` (`tid`, `bid`, `amount`, `date`, `time`) values ('$tid', '$bid', '$amount', '$date', '$time')";
    $run_payment = mysqli_query($con, $sql_payment);
    $sql_earning = "insert into `earning` (`userid`, `tid`) values ('$owneruserid', '$tid')";
    $run_earning = mysqli_query($con, $sql_earning);



    $email = $val_user['email'];
    $name = $val_user['user'];
    if (sendmail($email, $name, $bid)) {
        unset($_SESSION['carid']);
        $success = "Mail sent!!! Please check your email to set new password ";
    } else {
        $err = "email not found please register";
    }
}
function sendmail($email, $name, $bid)
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
        $mail->Subject = 'Ticket' . $name;
        $mail->Body = "<a href='http://localhost/project/ticketmail.php?bid=$bid'>Click here to check your ticket</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
if (isset($_POST['back'])) {
    unset($_SESSION['pid']);
    unset($_SESSION['dstart']);
    unset($_SESSION['dend']);
    unset($_SESSION['tstart']);
    unset($_SESSION['tend']);
    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/back.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/ticket.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>

<body>
    <div class="main">
        <?php
        include "navbar.php";
        ?>
        <div class="box">
            <h1>Account Details</h1>

            <div class="acc">
                <div class="accleft">
                    <label for="user">Username</label>
                    <br>
                    <span class="inp">
                        <?php echo $user; ?>
                    </span>
                    <br>
                    <label for="email">Email</label>
                    <br>
                    <span class="inp">
                        <?php echo $email; ?>
                    </span>
                    <br>
                    <label for="corno">Car Number</label>
                    <br>
                    <span class="inp">
                        <?php echo $no; ?>
                    </span>
                </div>
                <div class="accright">
                    <label for="address">Address</label>
                    <br>
                    <span class="inp">
                        <?php echo $address; ?>
                    </span>
                    <br>
                    <label for="ph">Phone Number</label>
                    <br>
                    <span class="inp">
                        <?php echo $ph; ?>
                    </span>
                </div>
            </div>
            <h1>Booking Details</h1>

            <div class="booking">
                <div class="bookleft">
                    <label for="pname">Parking Name</label>
                    <br>
                    <span class="inp">
                        <?php echo $pname; ?>
                    </span>
                    <br>
                    <label for="dstart"> Starting Date</label>
                    <br>
                    <span class="inp">
                        <?php echo $dstart; ?>
                    </span>
                    <br>
                    <label for="tstart">Starting Time</label>
                    <br>
                    <span class="inp">
                        <?php echo $tstart; ?>
                    </span>
                    <br>
                    <label for="spot">Spot Number</label>
                    <br>
                    <span class="inp">
                        <?php echo $spotno; ?>
                    </span>
                </div>
                <div class="bookright">
                    <label for="paddress">Parking Address</label>
                    <br>
                    <span class="inp">
                        <?php echo $paddress; ?>
                    </span>
                    <br>
                    <label for="dend">Ending Date</label>
                    <br>
                    <span class="inp">
                        <?php echo $dend; ?>
                    </span>
                    <br>
                    <label for="tend">Ending Time</label>
                    <br>
                    <span class="inp">
                        <?php echo $tend; ?>
                    </span>
                    <br>
                    <label for="ticket">Ticket</label>
                    <br>
                    <span class="inp">
                        <?php echo $ticket; ?>
                    </span>
                </div>

            </div>
            <div class="route">
                <label for="route">Route</label>
                <br>
                <span class="inp">
                    <?php echo $route ?>
                </span>
            </div>
            <h1>Payment Details</h1>

            <div class="pay">
                <div class="payleft">
                    <label for="tid">Transactin Id</label>
                    <br>
                    <span class="inp">
                        <?php echo $tid; ?>
                    </span>
                    <br>
                    <label for="amount">Amount</label>
                    <br>
                    <span class="inp">
                        <?php echo $amount; ?>
                    </span>
                </div>
                <div class="payright">
                    <label for="date">Date</label>
                    <br>
                    <span class="inp">
                        <?php echo $date; ?>
                    </span>
                    <br>
                    <label for="time">Time</label>
                    <br>
                    <span class="inp">
                        <?php echo $time; ?>
                    </span>
                </div>
            </div>
            <div class="btn">
                <form action="" method="post">
                    <button id="back" name="back">Back</button>
                </form>
            </div>
        </div>
        <br>
    </div>

</body>

</html>