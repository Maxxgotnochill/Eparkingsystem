<?php
session_start();
include "base.php";
$pid = $_SESSION['pid'];
$userid = $_SESSION['id'];
$sql_spot = "update `parking spot` set `state`='0' where `pid`='$pid' ";
$run_spot = mysqli_query($con, $sql_spot);
$sql_car="select * from `car` where `userid`='$userid'";
$run_car=mysqli_query($con, $sql_car);
$check_car=mysqli_num_rows($run_car);
// echo $check_car;
// $state=1;
if (isset($_POST['next'])) {
    $tstart = $_POST['tstart'];
    $tend = $_POST['tend'];
    $dstart = $_POST['dstart'];
    $dend = $_POST['dend'];
    $carid=$_POST['car'];
    // echo "this is carid : ".$carid;
    $_SESSION['dend'] = $dend;
    $_SESSION['dstart'] = $dstart;
    $_SESSION['tend'] = $tend;
    $_SESSION['tstart'] = $tstart;
    $_SESSION['carid']=$carid;
    $sql_parking = "select * from `parking` where `pid`='$pid'";
    $run_parking = mysqli_query($con, $sql_parking);
    $val_parking = mysqli_fetch_assoc($run_parking);
    $number = $val_parking['number'];
    $sql_booking = "select * from `booking` where `pid` ='$pid'";
    $run_booking = mysqli_query($con, $sql_booking);
    $check_booking = mysqli_num_rows($run_booking);
    if ($check_booking == 0) {

    } else {

        for ($i = 1; $i <= $check_booking; $i++) {
            $val_booking = mysqli_fetch_assoc($run_booking);
            $bdstart = $val_booking['dstart'];
            $bdend = $val_booking['dend'];
            $btstart = $val_booking['tstart'];
            $btend = $val_booking['tend'];
            $spotno = $val_booking['spotno'];
            if (($dstart == $bdstart) || ($dend == $bdend) || (($dstart > $bdstart) && ($dstart < $bdend)) || (($dend > $bdstart) && ($dend < $bdend)) || (($dstart < $bdstart) && ($dend > $bdend))) {
                if (($tstart == $btstart) || ($tend == $btend) || (($tstart > $btstart) && ($tstart < $btend)) || (($tend > $btstart) && ($tend < $btend)) || (($tstart < $btstart) && ($tend > $btend))) {
                    $sql_spot = "update `parking spot` set `state`='1' where `pid`='$pid' and `spotno`='$spotno'";
                    $run_spot = mysqli_query($con, $sql_spot);
                }
            }
        }
    }
}
if (isset($_POST['empty'])) {
    $spot=$_POST['empty'];
    header("Location:paymentc.php?spotno=$spot");
}


if (isset($_POST['back'])) {
    unset($_SESSION['pid']);
    unset($_SESSION['dstart']);
    unset($_SESSION['dend']);
    unset($_SESSION['tstart']);
    unset($_SESSION['tend']);
    unset($_SESSION['carid']);
    header("Location:search.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/back.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/booking.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>

<body>
    <div class="main">
        <?php
        include "navbar.php";
        ?>
        <div class="box1">
            <h1>Select Date and Time</h1>
            <form action="" method="post">
                <div class="datetime">
                    <div class="date">
                        <div class="startdate">
                            <label for="date">Starting Date</label>
                            <br>
                            <input type="date" name="dstart" id="dstart" min="<?php echo date("Y-m-d"); ?>"
                                value="<?php echo $dstart; ?>" required>
                        </div>
                        <div class="startdate">
                            <label for="date">Ending Date</label>
                            <br>
                            <input type="date" name="dend" id="dend" min="<?php echo date("Y-m-d"); ?>"
                                value="<?php echo $dend; ?>" required>
                        </div>
                    </div>
                    <div class="time">
                        <div class="starttime">
                            <label for="stime">Starting Time</label>
                            <br>
                            <input type="time" name="tstart" id="tstart" value="<?php echo $tstart; ?>" required>
                        </div>
                        <div class="endtime">
                            <label for="etime">Ending Time</label>
                            <br>
                            <input type="time" name="tend" id="tend" value="<?php echo $tend; ?>" required>
                        </div>
                    </div>
                    <div class="carselect">
                        <select name="car" id="car">
                            <?php 
                            if(isset($_SESSION['carid'])){
                                $caridses=$_SESSION['carid'];
                                $sql_car2="select * from `car` where `carid`='$caridses'";
                                $val_car2=mysqli_fetch_assoc(mysqli_query($con, $sql_car2));
                                ?>
                                <option id="caropt" value="<?php echo $val_car2['carid']; ?>"><?php echo $val_car2['no']; ?></option>
                                <?php
                            }
                            ?>
                            <?php 
                                for($i=0;$i<$check_car; $i++){
                                    $val_car=mysqli_fetch_assoc($run_car);
                                    ?>
                                    <option id="caropt" value="<?php echo $val_car['carid']; ?>"><?php echo $val_car['no']; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="btn">
                        <button id="next" name="next">Next</button>

                    </div>
                </div>
            </form>
            <div class="back">
                <form action="" method="post">
                    <button id="back" name="back">Back</button>
                </form>
            </div>
        </div>
        <?php
        if (isset($number)) {
            // echo $datestart;
            ?>
            <div class="box2">
                <h1>Select Parking Spot</h1>
                <div class="spotbox">
                    <form action="" method="post">
                        <?php
                        for ($i = 1; $i <= $number; ) {
                            ?>
                            <div class="spot">
                                <div class="leftspot">
                                    <?php for ($j = 0; $j < 5; $j++) {
                                        if ($i > $number) {
                                            break;
                                        }
                                        $sql_spot2 = "select * from `parking spot` where `pid`='$pid' and `spotno`='$i'";
                                        $run_spot2 = mysqli_query($con, $sql_spot2);
                                        $val_spot2 = mysqli_fetch_assoc($run_spot2);
                                        $state = $val_spot2['state'];
                                        if ($state == 1) {
                                            ?>
                                            <input type="submit" id="booked" name="spotno" value="<?php echo $i; ?>" disabled>
                                            <?php
                                        } else {

                                            ?>
                                            <button name="empty" id="empty" value="<?php echo $i; ?>">
                                                <?php echo $i; ?>
                                            </button>
                                            <?php
                                        }
                                        $i++;
                                    } ?>
                                </div>
                                <div class="rightspot">
                                    <?php for ($j = 0; $j < 5; $j++) {
                                        if ($i > $number) {
                                            break;
                                        }
                                        $sql_spot2 = "select * from `parking spot` where `pid`='$pid' and `spotno`='$i'";
                                        $run_spot2 = mysqli_query($con, $sql_spot2);
                                        $val_spot2 = mysqli_fetch_assoc($run_spot2);
                                        $state = $val_spot2['state'];
                                        if ($state == 1) {

                                            ?>
                                            <input type="submit" id="booked" name="spotno" value="<?php echo $i; ?>" disabled>
                                            <?php
                                        } else {

                                            ?>
                                            <button name="empty" id="empty" value="<?php echo $i; ?>">
                                                <?php echo $i; ?>
                                            </button>
                                            <?php
                                        }
                                        $i++;
                                    } ?>
                                </div>
                            </div>
                            <?php
                        }

                        ?>
                    </form>
                </div>
                <?php
        }
        ?>
        </div>
    </div>

    <script>
        var btn = document.getElementsByClassName("booked");
        btn.setAttribute("disabled", "true");
    </script>
</body>

</html>