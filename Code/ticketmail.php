<?php
session_start();
include "base.php";
$bid = $_GET['bid'];
$sql_booking = "select * from `booking` where `bid`='$bid'";
$val_booking = mysqli_fetch_assoc(mysqli_query($con, $sql_booking));
// var_dump($val_booking);
$dstart = $val_booking['dstart'];
$dend = $val_booking['dend'];
$tstart = $val_booking['tstart'];
$tend = $val_booking['tend'];
$pid = $val_booking['pid'];
$userid = $val_booking['userid'];
$carid = $val_booking['carid'];
$spotno = $val_booking['spotno'];
$ticket = $val_booking['ticket'];
$sql_user = "select * from `user` where `userid`='$userid'";
$val_user = mysqli_fetch_assoc(mysqli_query($con, $sql_user));
;
$user = $val_user['user'];
$email = $val_user['email'];
$gender = $val_user['gender'];
$ph = $val_user['ph'];
$sql_car = "select * from `car` where `carid`='$carid'";
$val_car = mysqli_fetch_assoc(mysqli_query($con, $sql_car));
$no = $val_car['no'];
$sql_parking = "select * from `parking` where `pid`='$pid'";
$val_parking = mysqli_fetch_assoc(mysqli_query($con, $sql_parking));
$pname = $val_parking['pname'];
$place = $val_parking['place'];
$city = $val_parking['city'];
$dist = $val_parking['dist'];
$sql_payment = "select * from `payment` where `bid`='$bid'";
;
$val_pay = mysqli_fetch_assoc(mysqli_query($con, $sql_payment));
$tid = $val_pay['tid'];
$amount = $val_pay['amount'];
$date = $val_pay['date'];
$time = $val_pay['time'];
$sql_route="select * from `route` where `spotno`='$spotno'";
$val_route=mysqli_fetch_assoc(mysqli_query($con, $sql_route));
$route=$val_route['route'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/ticketmailfront.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="CSS/ticketmailback.css?v=<?php echo time(); ?>">

    <title>TICKET</title>
</head>

<body>
    <div class="ticket">
        <div class="left">
            <div class="image">
                <p class="E-PARK">
                    <span>E-PARK</span>
                    <span>E-PARK</span>
                    <span>E-PARK</span>
                    <!-- <span>E-PARK</span> -->
                </p>
                <div class="ticket-number">
                    <p>#000015</p> <!-- changeable -->
                </div>
            </div>
            <!-- starting-time -->
            <div class="ticket-info">
                <p class="date">
                    <span>
                        <?php echo $tstart; ?>
                    </span> <!-- starting-time --> <!-- changeable -->
                    <span class="to">To</span>
                    <span>
                        <?php echo $tend; ?>
                    </span> <!-- ending-time --> <!-- changeable -->
                </p>
                <div class="user-details">
                    <h3>
                        <?php echo $user; ?>
                    </h3>
                    <h4>WB-H-8848</h4>
                    <!-- <h4>ratulpal2002@gmail.com</h4>
                    <h4>Male</h4> -->
                </div>
                <div class="time">
                    <p>
                        <?php echo $dstart; ?><span> To </span>
                        <?php echo $dend; ?>
                    </p>
                    <span>
                        <?php echo $ticket; ?>
                    </span> 
                    <p>
                        <label for="spotno">Spot No:</label>
                        <?php echo $spotno; ?>
                    </p> <!-- spot no -->
                    <p>
                        <?php echo $pname; ?>
                    </p>
                </div>
                <p class="location">
                    <span>
                        <?php echo $place; ?> |
                    </span>
                    <span>
                        <?php echo $city; ?> |
                    </span>
                    <span>
                        <?php echo $dist; ?>
                    </span>
                </p>
            </div>
        </div>
        <div class="right">
            <p class="E-PARK">
                <span>E-PARK</span>
                <span>E-PARK</span>
                <span>E-PARK</span>
            </p>
            <div class="right-info-container">
                <div class="show-name">
                    <h1>
                        <?php echo $route; ?>
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <div class="ticket">
        <div class="left">
            <div class="back-user-details">
                <h2 id="udh">User Details</h2>
                <br>
                <h3 id="h3">
                    <?php echo $user; ?>
                </h3>
                <br>
                <h3>
                    <?php echo $email; ?>
                </h3>
                <br>
                <h3>
                    <?php echo $gender; ?>
                </h3>
                <br>
                <h3>
                    <?php echo $ph; ?>
                </h3>
                <br>
                <h3>WB-H-8848</h3>
                <!-- <div class="ticket-number">
                    <p>#000015</p> 
                </div> -->
            </div>
            <div class="back-booking-details">
                <p class="date">
                <h3 id="bdh">Booking Details</h3>
                </p>
                <div class="booking-details">
                    <br>
                    <p>
                        <?php echo $dstart; ?><span> TO </span>
                        <?php echo $dend; ?>
                    </p>
                    <br>
                    <p>
                        <?php echo $tstart; ?><span> TO </span>
                        <?php echo $tend; ?>
                    </p>
                    <!-- <h4>ratulpal2002@gmail.com</h4>
                    <h4>Male</h4> -->
                </div>
                <div class="time">
                    <p>
                        <?php echo $pname; ?>
                    </p>
                    <p>
                        <?php echo $place . ", " . $city . ", "; ?>
                    </p>
                    <p>
                        <?php echo $dist;
                        ; ?>
                    </p>
                    <span>
                        <?php echo $ticket; ?>
                    </span> 
                    <span>
                        <?php echo $spotno; ?>
                    </span>

                </div>
                <!-- <p class="location">
                    <span>Bishnupur High School</span>
                    <span>East Lake city</span>
                </p> -->
            </div>
        </div>
        <div class="back-right">
            <p class="E-PARK">
                <span>E-PARK</span>
                <span>E-PARK</span>
                <span>E-PARK</span>
            </p>
            <div class="back-transaction-details">
                <div class="show-name">
                    <h1>Transaction Details</h1>
                </div>
                <div class="time">
                    <p>
                        <?php echo $tid; ?>
                    </p>
                    <br>
                    <p id="f">
                        <?php echo $amount . "/-"; ?>
                    </p>
                    <br>
                    <p>
                        <?php echo $date; ?>
                    </p>
                    <p>
                        <?php echo $time ?>
                    </p>

                </div>
                <!-- <p class="ticket-number">
                    #000015
                </p> -->
            </div>
        </div>
    </div>
</body>

</html>