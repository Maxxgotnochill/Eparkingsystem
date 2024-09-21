<?php
session_start();
include "base.php";
$spotno = $_GET['spotno'];
$dstart = $_SESSION['dstart'];
$dend = $_SESSION['dend'];
$tstart = $_SESSION['tstart'];
$tend = $_SESSION['tend'];
$pid = $_SESSION['pid'];
$id = $_SESSION['id'];
$carid=$_SESSION['carid'];
$sql_car="select * from `car` where `carid`='$carid'";
$val_car=mysqli_fetch_assoc(mysqli_query($con, $sql_car));
$no=$val_car['no'];
$ticket = rand(100000, 999999);
$tid = rand(10000000, 99999999);
$sql_parking = "select * from `parking` where `pid`='$pid'";
$val_parking = mysqli_fetch_assoc(mysqli_query($con, $sql_parking));
$place = $val_parking['pname'];
$fare = $val_parking['fare'];
$t1 = strtotime($dstart . " " . $tstart);
$t2 = strtotime($dend . " " . $tend);
$hour = ($t2 - $t1) / 3600;
$money = intval($hour * $fare);
$amount = $money * 100;
$sql_user = "select * from `user` where `userid`='$id'";
$val_user = mysqli_fetch_assoc(mysqli_query($con, $sql_user));
$email = $val_user['email'];
$name = $val_user['user'];
$ph = $val_user['ph'];
$API = "rzp_test_oYYcLIYXhg4w4g";


if (isset($_POST['back'])) {
    unset($_SESSION['dstart']);
    unset($_SESSION['tstart']);
    unset($_SESSION['dend']);
    unset($_SESSION['tend']);
    header("Location:booking.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Page</title>
    <link rel="stylesheet" href="css/back.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="CSS/paymentc.css?v=<?php echo time(); ?>">
</head>

<body>
    <?php
    include "navbar.php";
    ?>
    <div class="container">
        <div class="box">
            <h2 id="pch">Confirm Your Information</h2>
            <hr>
            <form class="pconf" method="post" action="#">
                <div class="left">
                    <label for="">Name:</label>
                    <input type="text" name="name" id="name" placeholder="Name" value="<?php echo $name; ?>" required
                        disabled>
                    <br>
                    <label for="">Email:</label>
                    <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>"
                        required disabled>
                    <br>
                    <label for="">Number:</label>
                    <input type="number" name="number" id="no" placeholder="Contact Number" value="<?php echo $ph; ?>"
                        required min="0" disabled>
                    <br>
                    <label for="car">Car No.:</label>
                    <input type="text" name="car" id="car" value="<?php echo $no; ?>" disabled >
                    <br>
                    <label for="">Place:</label>
                    <input type="text" name="place" id="place" placeholder="Place" value="<?php echo $place; ?>"
                        required disabled>
                    <br>
                    <label id="fl" for="">Fare:</label>
                    <input type="number" name="fare" id="fare" value="<?php echo $money;
                    ; ?>" required disabled>
                    <br>
                </div>
                <div class="right">
                    <label for="">Starting Date:</label>
                    <input type="date" name="dstart" id="date" value="<?php echo $dstart; ?>" required disabled>
                    <br>
                    <label for="">Ending Date:</label>
                    <input type="date" name="dend" id="date" value="<?php echo $dend; ?>" required disabled>
                    <br>
                    <label for="">Starting Time:</label>
                    <input type="time" name="tstart" id="time" value="<?php echo $tstart; ?>" required disabled>
                    <br>
                    <label for="">Ending Time:</label>
                    <input type="time" name="tend" id="time" value="<?php echo $tend; ?>" required disabled>
                    <br>
                    <label id="fl" for="">Spot Number:</label>
                    <input type="number" name="slot" id="slot" value="<?php echo $spotno; ?>" required disabled>
                </div>
            </form>
            <div class="pcb">
                <form action="" id="bf" method="post">
                    <button id="back" name="back">Back</button>
                </form>
                <form id="cf"
                    action="http://localhost/Code/ticket.php?spotno=<?php echo $spotno; ?>&tid=<?php echo $tid; ?>&ticket=<?php echo $ticket; ?>&amount=<?php echo $money; ?>"
                    method="POST">
                    <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="<?php echo $API; ?>" /*Enter
                        the Test API Key ID generated from Dashboard → Settings → API Keys*/
                        data-amount="<?php echo $amount; ?>" // Amount is in currency subunits. Hence, 29935 refers to
                        29935 paise or ₹299.35. data-currency="INR" // You can accept international payments by changing
                        the currency code. Contact our Support Team to enable International for your account
                        data-id="<?php echo $tid; ?>" // Replace with the order_id generated by you in the backend.
                        data-buttontext="Pay Now" data-description="Yearly Play" data-image="assets/images/logo.png"
                        data-name="<?php echo "Payment"; //$name; ?>" data-prefill.name="<?php echo $name; ?>"
                        data-prefill.email="<?php echo $email; ?>" data-theme.color="#9cfcf8"></script>
                    <input type="hidden" custom="Hidden Element" name="hidden" />
                </form>
            </div>
        </div>
    </div>
</body>

</html>