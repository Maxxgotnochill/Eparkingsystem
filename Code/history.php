<?php
session_start();
include "base.php";
$id = $_SESSION['id'];
date_default_timezone_set("Asia/Kolkata");
$date = date("Y-m-d");
$time = date("H:i:s");
$sql_booking = "select * from `booking` where `userid`='$id' and `dend`>='$date'";
$run_booking = mysqli_query($con, $sql_booking);
$check_booking = mysqli_num_rows($run_booking);
$sql_history = "select * from `booking` where `userid`='$id' and `dend`<='$date'";
$run_history = mysqli_query($con, $sql_history);
$check_history = mysqli_num_rows($run_history);
if (isset($_POST['booking'])) {
    $val=$_POST['booking'];
    header("Location:view.php?value=$val&key=0");
}
if(isset($_POST['history'])){
    $val=$_POST['history'];
    header("Location:view.php?value=$val&key=1");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/history.css?v=<?php echo time(); ?>">
    <title>History</title>
</head>

<body>
    <div class="main">
        <?php
        include "navbar.php";
        ?>
        <?php
        if (($check_booking > 0) || ($check_history > 0)) {
            ?>
            <div class="box">
                <?php if ($check_booking > 0) {
                    ?>
                    <div class="box1" id="box1">
                        <h1 id="uh">Upcomming Bookings</h1>
                        <?php for ($i = 0; $i < $check_booking; $i++) {
                            $val_booking = mysqli_fetch_assoc($run_booking);
                            $dend = $val_booking['dend'];
                            if ($date == $dend) {
                                $tend = $val_booking['tend'];
                                if ($time < $tend) {
                                    $pid = $val_booking['pid'];
                                    $sql_par_book = "select * from `parking` where `pid`='$pid'";
                                    $val_par_book = mysqli_fetch_assoc(mysqli_query($con, $sql_par_book));
                                    ?>
                                    <div class="booking">
                                        <div class="datetime">
                                            <div class="date">
                                                <span id="start">Starting Date:
                                                    <?php echo $val_booking['dstart'] ?>
                                                </span>
                                                <br>
                                                <span id="start">Starting Time:
                                                    <?php echo $val_booking['tstart'] ?>
                                                </span>

                                            </div>

                                            <div class="time">

                                                <span>Endeing Date:
                                                    <?php echo $val_booking['dend'] ?>
                                                </span>
                                                <br>
                                                <span>Endeing Time:
                                                    <?php echo $val_booking['tend'] ?>
                                                </span>
                                            </div>

                                        </div>
                                        <div class="pname">
                                            <span>Parking Name:
                                                <?php echo $val_par_book['pname']; ?>
                                            </span>
                                        </div>
                                        <div class="ticket">
                                            <span>Ticket:
                                                <?php echo $val_booking['ticket']; ?>
                                            </span>
                                        </div>
                                        <div class="btn">
                                            <form action="" method="post">
                                                <button id="hisbtn" name="booking" value="<?php echo $val_booking['bid']; ?>">View</button>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                $pid = $val_booking['pid'];
                                $sql_par_book = "select * from `parking` where `pid`='$pid'";
                                $val_par_book = mysqli_fetch_assoc(mysqli_query($con, $sql_par_book));
                                ?>
                        <div class="booking">
                            <div class="datetime">
                                <div class="date">
                                    <span id="start">Starting Date:
                                        <?php echo $val_booking['dstart'] ?>
                                    </span>
                                    <br>
                                    <span id="start">Starting Time:
                                        <?php echo $val_booking['tstart'] ?>
                                    </span>

                                </div>

                                <div class="time">

                                    <span>Endeing Date:
                                        <?php echo $val_booking['dend'] ?>
                                    </span>
                                    <br>
                                    <span>Endeing Time:
                                        <?php echo $val_booking['tend'] ?>
                                    </span>
                                </div>

                            </div>
                            <div class="pname">
                                <span>Parking Name:
                                    <?php echo $val_par_book['pname']; ?>
                                </span>
                            </div>
                            <div class="ticket">
                                <span>Ticket:
                                    <?php echo $val_booking['ticket']; ?>
                                </span>
                            </div>
                            <div class="btn">
                                <form action="" method="post">
                                    <button id="hisbtn" name="booking" value="<?php echo $val_booking['bid']; ?>">View</button>

                                </form>
                            </div>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="novalbox1">
                    <h1 id="uh">Upcomming Bookings</h1>
                        <p>you does not have any upcoming bookings</p>
                    </div>
                    <?php
                }
                ?>
<!----------------------end of upcoming booking---------------------------------------------------------------------------------------------->



<!----------------------start of Previous booking---------------------------------------------------------------------------------------------->

                <?php if ($check_history > 0) {
                    ?>
                    <div class="box2" id="box2">
                        <h1 id="ph">Previous Bookings</h1>
                        <?php for ($i = 0; $i < $check_history; $i++) {
                            $val_history = mysqli_fetch_assoc($run_history);
                            $dend = $val_history['dend'];
                            if ($date == $dend) {
                                $tend = $val_history['tend'];
                                if ($time >= $tend) {
                                    $pid = $val_history['pid'];
                                    $sql_par_his = "select * from  `parking` where `pid`='$pid'";
                                    $val_par_his = mysqli_fetch_assoc(mysqli_query($con, $sql_par_his));
                                    ?>
                                    <div class="history">
                                        <div class="datetime">
                                            <div class="date">
                                                <span id="start">Starting Date:
                                                    <?php echo $val_history['dstart'] ?>
                                                </span>
                                                <br>
                                                <span id="start">Starting Time:
                                                    <?php echo $val_history['tstart'] ?>
                                                </span>
                                            </div>
                                            <div class="time">
                                                <span>Endeing Date:
                                                    <?php echo $val_history['dend'] ?>
                                                </span>
                                                <br>
                                                <span>Endeing Time:
                                                    <?php echo $val_history['tend'] ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="pname">
                                            <span>Parking Name:
                                                <?php echo $val_par_his['pname']; ?>
                                            </span>
                                        </div>
                                        <div class="ticket">
                                            <span>Ticket:
                                                <?php echo $val_history['ticket']; ?>
                                            </span>
                                        </div>
                                        <div class="btn">
                                            <form action="" method="post">
                                                <button id="hisbtn" name="history" value="<?php echo $val_history['bid']; ?>">View</button>

                                            </form>
                                        </div>

                                    </div>


                                    <?php
                                }

                            } else {
                                $pid = $val_history['pid'];
                                $sql_par_his = "select * from  `parking` where `pid`='$pid'";
                                $val_par_his = mysqli_fetch_assoc(mysqli_query($con, $sql_par_his));
                                ?>
                        <div class="history">
                            <div class="datetime">
                                <div class="date">
                                    <span id="start">Starting Date:
                                        <?php echo $val_history['dstart'] ?>
                                    </span>
                                    <br>
                                    <span id="start">Starting Time:
                                        <?php echo $val_history['tstart'] ?>
                                    </span>

                                </div>

                                <div class="time">

                                    <span>Endeing Date:
                                        <?php echo $val_history['dend'] ?>
                                    </span>
                                    <br>
                                    <span>Endeing Time:
                                        <?php echo $val_history['tend'] ?>
                                    </span>
                                </div>

                            </div>
                            <div class="pname">
                                <span>Parking Name:
                                    <?php echo $val_par_his['pname']; ?>
                                </span>
                            </div>
                            <div class="ticket">
                                <span>Ticket:
                                    <?php echo $val_history['ticket']; ?>
                                </span>
                            </div>
                            <div class="btn">
                                <form action="" method="post">
                                    <button id="hisbtn" name="history" value="<?php echo $val_history['bid']; ?>">View</button>

                                </form>
                            </div>

                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="novalbox2">
                    <h1 id="ph">Previous Bookings</h1>
                        <p>you does not have any Previous booking</p>
                    </div>
                    <?php

                }
                ?>

                <br>
                <br>
                <br>
                <br>
                <br>
            </div>
            <?php
        } else {
            ?>
            <div class="nobook">
                <p>no history</p>
            </div>
            <?php
        }
        ?>
    </div>
</body>

</html>