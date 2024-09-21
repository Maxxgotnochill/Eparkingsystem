<?php
session_start();
include "base.php";
$key=$_GET['key'];
$id = $_SESSION['id'];
$sql_user = "select * from `user` where `userid`='$id' ";
$val_user = mysqli_fetch_assoc(mysqli_query($con, $sql_user));
$user = $val_user['user'];
$email = $val_user['email'];
$address = $val_user['address'];
$ph = $val_user['ph'];
$bid = $_GET['value'];
$sql_booking = "select * from `booking` where `bid`='$bid'";
$val_booking = mysqli_fetch_assoc(mysqli_query($con, $sql_booking));
$pid = $val_booking['pid'];
$dstart = $val_booking['dstart'];
$dend = $val_booking['dend'];
$tstart = $val_booking['tstart'];
$tend = $val_booking['tend'];
$spot = $val_booking['spotno'];
$ticket = $val_booking['ticket'];
$carid=$val_booking['carid'];
$sql_parking = "select * from `parking` where `pid`='$pid'";
$val_parking = mysqli_fetch_assoc(mysqli_query($con, $sql_parking));
$pname = $val_parking['pname'];
$paddress = $val_parking['place'] . ", " . $val_parking['city'] . ", " . $val_parking['dist'];
$sql_pay = "select * from `payment` where `bid`='$bid'";
$val_pay = mysqli_fetch_assoc(mysqli_query($con, $sql_pay));
$tid = $val_pay['tid'];
$amount = $val_pay['amount'];
$date = $val_pay['date'];
$time = $val_pay['time'];
$sql_car="select * from `car` where `carid`='$carid'";
$val_car=mysqli_fetch_assoc(mysqli_query($con, $sql_car));
$no=$val_car['no'];
$sql_route = "select * from `route` where `spotno`='$spot'";
$val_route = mysqli_fetch_assoc(mysqli_query($con, $sql_route));
$route = $val_route['route'];
if(isset($_POST['back'])){
    header("Location:history.php");
}
if(isset($_POST['delete'])){
    $sql_earning="delete from `earning` where `tid`='$tid'";
    $run_earning=mysqli_query($con, $sql_earning);
    $sql_payment="delete from `payment` where `bid`='$bid'";
    $run_parking=mysqli_query($con, $sql_payment);
    $sql_booking="delete from `booking` where `bid`='$bid'";
    $run_booking=mysqli_query($con, $sql_booking);
    header("Location:history.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/back.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/view.css?v=<?php echo time(); ?>">
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
                    <span class="inp" >
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
                        <?php echo $spot; ?>
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
                <?php if ($key == 0) {
                    ?>
                        <form action="" method="post">
                            <button id="delete" name="delete" >Cancel</button>
                        </form>
                    <?php
                }
                ?>
            </div>
        </div>
        <br>
    </div>

</body>

</html>