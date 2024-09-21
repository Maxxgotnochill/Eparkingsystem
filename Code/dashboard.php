<?php
session_start();
include "base.php";
$id = $_SESSION['id'];
if (isset($_POST['btn01'])) {
    $pname = $_POST['name'];
    $fare = $_POST['fare'];
    $place = $_POST['place'];
    $city = $_POST['city'];
    $dist = $_POST['dist'];
    $number = $_POST['number'];
    header("Location:listparking.php?pname=$pname&fare=$fare&place=$place&city=$city&dist=$dist&number=$number");
}
if (isset($_POST['more'])) {
    $pid = $_POST['more'];

    header("Location:ownermanage.php?value=$pid");
}
if (isset($_POST['del'])) {
    $_SESSION['delpid'] = $_POST['del'];
}
if (isset($_POST['delete'])) {
    $delete = $_POST['delete'];
    $pass = $_POST['pass'];
    unset($_SESSION['delpid']);
    $sql_parking = "select * from `parking` where `pid`='$delete'";
    $val_parking = mysqli_fetch_assoc(mysqli_query($con, $sql_parking));
    $userid = $val_parking['userid'];
    $sql_user = "select * from `user` where `userid`='$userid'";
    $val_user = mysqli_fetch_assoc(mysqli_query($con, $sql_user));
    $dpass = $val_user['pass'];
    if ($pass === $dpass) {
        $sql_delete = "update `parking` set `visibility`='1' where `pid`='$delete'";
        $run_delete = mysqli_query($con, $sql_delete);
        $_SESSION['msg'] = "Parking Place deleted successfully";
    }
}
if (isset($_POST['cancel'])) {
    unset($_SESSION['delpid']);
}
if (isset($_POST['booking'])) {
    $sql_car = "select * from `car` where `userid`='$id'";
    $check_car = mysqli_num_rows(mysqli_query($con, $sql_car));
    echo $check_car; 
    if ($check_car > 0) {
        header("Location:bookingpage.php");
    } else {
        header("Location:car.php?key=1");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="CSS/dashboard.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="CSS/chart.css?v=<?php echo time(); ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <title>Dashboard</title>
</head>

<body>
    <div class="main">
        <?php
        include "navbar.php";
        ?>
        <?php
        if (isset($_SESSION['delpid'])) {
            ?>
            <div class="delparking">
                <h1>Enter Password</h1>
                <form action="" method="post">
                    <input type="password" name="pass" id="delpass" placeholder="Password" required>
                    <br>
                    <input type="checkbox" id="show" name="show" onclick="showpass()">
                    <label for="showpass">Show Password</label>
                    <br>
                    <button id="delete" name="delete" value="<?php echo $_SESSION['delpid']; ?>">Delete</button>
                </form>
                <form action="" method="post">
                    <button id="cancel" name="cancel">Cancel</button>
                </form>
            </div>
            <?php
        }
        ?>
        <?php if (isset($_SESSION['msg'])) { ?>
            <div class="errmsg" id="errmsg">
                <i class="bi bi-exclamation-circle-fill"></i>
                <p>
                    <?php echo $_SESSION['msg']; ?>
                    <i onclick="errcancel()" id="errcan" class="bi bi-x-lg"></i>
                </p>
            </div>
            <?php
            unset($_SESSION['msg']);
        } ?>
        <div class="side-menu">
            <div class="controls">
                <h1 class="h1">Menu</h1>
            </div>
            <ul>
                <li>
                    <button id="db" onclick="db()"><img src="Image/dashboard.png" alt="Icon">&nbsp; Dashboard</button>
                </li>
                <li>
                    <button id="list" onclick="list()"><img src="Image/add.png" alt="Icon">&nbsp; List Parking
                        Lot</button>
                </li>
                <li><button id="manage" onclick="manage()"> <img src="Image/manage.png" alt="Icon">&nbsp; Manage
                        Parking</button></li>
                <li> <button id="earning" onclick="earning()"><img src="Image/income.png" alt="Icon">&nbsp;
                        Earning</button></li>
                <form action="" method="post">
                    <li>
                        <button id="booking" name="booking">Booking</button>
                    </li>
                </form>
            </ul>
        </div>
        <div class="box0" id="box0">
            <br>
            <h1 id="lh">Dashboard</h1>

            <?php
            $userid = $_SESSION['id'];
            $sql_parking_dash = "select * from `parking` where `userid`='$userid' and `visibility`='0'";
            $run_parking_dash = mysqli_query($con, $sql_parking_dash);
            $check_dash_par = mysqli_num_rows($run_parking_dash);
            date_default_timezone_set("Asia/Kolkata");
            $date = date("Y-m-d");
            $time = date("H:i:s");
            ?>
            <div class="parking">
                <span>Number of parking lot(s):
                    <?php echo $check_dash_par; ?>
                </span>
            </div>
            <div class="booking">
                <?php
                $cnt = 0;
                $curcnt = 0;
                for ($i = 0; $i < $check_dash_par; $i++) {
                    $val_par_dash = mysqli_fetch_assoc($run_parking_dash);

                    $pid = $val_par_dash['pid'];

                    $sql_booking = "select * from `booking` where `pid`='$pid'";
                    $check_booking_dash = mysqli_num_rows(mysqli_query($con, $sql_booking));

                    $cnt = $cnt + $check_booking_dash;
                    $sql_booking_dash2 = "select * from `booking` where `pid`='$pid' and `dend`>='$date'";
                    $run_booking_dash2 = mysqli_query($con, $sql_booking_dash2);
                    $check_booking_dash2 = mysqli_num_rows($run_booking_dash2);

                    for ($j = 0; $j < $check_booking_dash2; $j++) {
                        $val_booking_dash2 = mysqli_fetch_assoc($run_booking_dash2);
                        $dend = $val_booking_dash2['dend'];
                        if ($date == $dend) {
                            $tend = $val_booking_dash2['tend'];
                            if ($time < $tend) {
                                $curcnt++;

                            }
                        } else {
                            $curcnt++;

                        }

                    }


                }
                ?>
                <div class="current">
                    <span>Total Booking:
                        <?php echo $cnt; ?>
                    </span>
                </div>
                <div class="previous">
                    <span>Current Parking:
                        <?php echo $curcnt; ?>
                    </span>
                </div>
            </div>

        </div>
        <div class="box1" id="box1">
            <br>
            <h1 id="lh">Add Your Parking Lot</h1>
            <form action="" id="lpf" method="post">
                <div class="box01">
                    <div class="nea">
                        <input type="text" name="name" id="name" placeholder="Name" required>
                        <br>
                        <input type="number" name="fare" id="fare" placeholder="Fare" required min="0">
                        <br>
                        <input type="text" name="place" id="address" placeholder="Place" requierd>
                        <br>
                    </div>
                    <div class="cdt">
                        <input type="text" name="city" id="city" placeholder="City" requierd>
                        <br>
                        <input type="text" name="dist" id="district" placeholder="District" requierd>
                        <br>
                        <input type="number" name="number" id="totalspotno" placeholder="Total Parking Spot number"
                            requierd min="0">
                        <br>
                    </div>
                </div>
                <button name="btn01" id="btn01">Submit</button>
                <br>
            </form>
        </div>
        <div class="box2" id="box2">

            <h1 id="mh">Manage Parking</h1>
            <?php
            $id = $_SESSION['id'];
            $sql_parking = "select * from `parking` where `userid`='$id' and `visibility`='0'";
            $run_parking = mysqli_query($con, $sql_parking);
            $check_parking = mysqli_num_rows($run_parking);
            if ($check_parking > 0) {
                ?>
                <div class="table">

                    <table>
                        <div class="heading">
                            <tr>
                                <th id="pname">Parking name</th>
                                <th>Number of spots</th>
                                <th id="tmanage">Manage</th>
                            </tr>
                        </div>
                        <?php
                        for ($i = 0; $i < $check_parking; $i++) {
                            $val_parking2 = mysqli_fetch_assoc($run_parking);
                            ?>
                            <div class="data">
                                <tr>
                                    <td id="dname">
                                        <?php echo $val_parking2['pname']; ?>
                                    </td>
                                    <td id="num">
                                        <?php echo $val_parking2['number']; ?>
                                    </td>
                                    <td id="mbtn">
                                        <div class="managebtn">
                                            <form action="" method="post">
                                                <button id="del" name="del"
                                                    value="<?php echo $val_parking2['pid']; ?>">Delete</button>
                                            </form>
                                            <form action="" method="post">
                                                <button id="more" name="more"
                                                    value="<?php echo $val_parking2['pid']; ?>">More</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </div>
                            <?php
                        }
                        ?>
                    </table>

                </div>
                <?php
            } else {
                ?>
                <div class="err">
                    <p>There are no parking spot on your name please list your parking lot first</p>
                </div>
                <?php
            }
            ?>

        </div>

        <div class="box3" id="box3">
            <h1 id="eh">Earning</h1>
            <?php
            $userid = $_SESSION['id'];
            date_default_timezone_set("Asia/kolkata");
            $today = date("Y-m-d");
            $amount = array();
            for ($i = 0; $i < 4; $i++) {
                $date = date_create($today);
                $inter = date_interval_create_from_date_string("7 days");
                $strtoday = $date->format('Y-m-d');
                $weekdate = date_sub($date, $inter);
                $strweekdate = $weekdate->format('Y-m-d');
                // echo "date1  " . $strtoday . "<br>";
            
                $sql_amount = "select * from `payment` natural join `earning` where `userid`='$userid' and `date`>'$strweekdate'";
                $run = mysqli_query($con, $sql_amount);
                $caheck = mysqli_num_rows($run);
                ;
                $money = 0;

                for ($j = 0; $j < $caheck; $j++) {
                    $val = mysqli_fetch_assoc($run);
                    // var_dump($val);
            
                    $hello = $val['date'];

                    $tid = $val['tid'];

                    $sql_amount2 = "select * from `payment` natural join `earning` where `userid`='$userid' and `tid`='$tid' and `date`='$hello'";
                    $run2 = mysqli_query($con, $sql_amount2);
                    $val2 = mysqli_fetch_assoc($run2);
                    $break = $val2['date'];

                    if ($break <= $strtoday) {
                        $money = $money + $val2['amount'];
                    }



                }
                $amount[] = $money;
                // echo "amount = " . $money . "<br>";
                // echo $strweekdate . "<br>";
                // echo "<br>";
                $today = $strweekdate;
            }
            // var_dump($amount);
            
            include "base.php";
            $parking = array();

            $name = null;


            $sql_parking = "select * from `parking` where `userid`='$userid'";
            $run_parking = mysqli_query($con, $sql_parking);
            $caheck_parking = mysqli_num_rows($run_parking);


            for ($j = 0; $j < $caheck_parking; $j++) {
                $val_parking = mysqli_fetch_assoc($run_parking);
                // var_dump($val);
                $pid = $val_parking['pid'];
                $pname = $val_parking['pname'];
                if ($j == 0) {
                    $name = "'" . $pname . "'";
                } else {
                    $name = $name . ",'" . $pname . "'";
                }
                $sql_parking2 = "select sum(`amount`) as amount from `booking` natural join `payment` where `pid`='$pid'";
                $run_parking2 = mysqli_query($con, $sql_parking2);
                $val_parking2 = mysqli_fetch_assoc($run_parking2);
                // var_dump()
                $money2 = $val_parking2['amount'];
                if ($money2 == null) {
                    $money2 = '0';
                }
                $parking[] = $money2;





            }
            $cnt = count($parking);

                // var_dump($parking);
            ?>
            <div class="box000">
                <style>
                    * {
                        margin: 0;
                        padding: 0;
                        font-family: sans-serif;
                    }

                    .chartMenu {
                        width: 100vw;
                        height: 40px;
                        background: #1A1A1A;
                        color: rgba(54, 162, 235, 1);
                    }

                    .chartMenu p {
                        padding: 10px;
                        font-size: 20px;
                    }

                    .chartCard {
                        width: 100vw;
                        height: calc(100vh - 40px);
                        background: rgba(54, 162, 235, 0.2);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .chart,
                    .chartBox {
                        width: 700px;
                        padding: 20px;
                        border-radius: 20px;
                        border: solid 3px rgba(54, 162, 235, 1);
                        background: white;
                    }

                    .chart {
                        margin-top: 35px;
                    }
                </style>

                <div class="chartBox">
                    <canvas id="myChart"></canvas>
                </div>
                <div class="chart">
                    <canvas id="lineChart"></canvas>
                </div>


                <script type="text/javascript"
                    src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
                <script>
                    // setup 
                    const data = {
                        labels: ['Week-1', 'Week-2', 'Week-3', 'Week-4'],
                        datasets: [{
                            label: 'Weekly Earnings',
                            data: [<?php echo $amount[0]; ?>, <?php echo $amount[1]; ?>, <?php echo $amount[2]; ?>, <?php echo $amount[3]; ?>],
                            backgroundColor: [
                                'rgba(255, 26, 104, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(0, 0, 0, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 26, 104, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(0, 0, 0, 1)'
                            ],
                            borderWidth: 1
                        }]
                    };

                    // config 
                    const config = {
                        type: 'bar',
                        data,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grace: 5
                                }
                            }
                        }
                    };
                    var parking = [];
                    <?php
                    for ($i = 0; $i < $cnt; $i++) {
                        ?>
                        parking.push(<?php echo $parking[$i]; ?>)
                        <?php
                    }
                    ?>
                    const data2 = {
                        labels: [<?php echo $name; ?>],
                        datasets: [{
                            label: 'Parking Earnings',
                            data: parking,
                            backgroundColor: [
                                'rgba(255, 26, 104, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(0, 0, 0, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 26, 104, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(0, 0, 0, 1)'
                            ],
                            borderWidth: 1
                        }]
                    };

                    // config 
                    const config2 = {
                        type: 'bar',
                        data: data2,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grace: 5
                                }
                            }
                        }
                    };

                    // render init block
                    const myChart = new Chart(
                        document.getElementById('myChart'),
                        config
                    );

                    // Instantly assign Chart.js version
                    const chartVersion = document.getElementById('chartVersion');
                    // chartVersion.innerText = Chart.version;
                    // render init block
                    const lineChart = new Chart(
                        document.getElementById('lineChart'),
                        config2
                    );

                    // Instantly assign Chart.js version
                    const chartVersion2 = document.getElementById('chartVersion');
    // chartVersion.innerText = Chart.version;
                </script>


            </div>
            <!-------------!------------------js for transition of pages-------------------------------------------------------------------------------------------------------->
        </div>
    </div>
    <script>
        var box0 = document.getElementById("box0");
        var box1 = document.getElementById("box1");
        var box2 = document.getElementById("box2");
        var box3 = document.getElementById("box3");
        var delpass = document.getElementById("delpass");
        var errmsg = document.getElementById("errmsg");


        function db() {
            box0.style.display = "block";
            box1.style.display = "none";
            box2.style.display = "none";
            box3.style.display = "none";
        }
        function list() {
            box0.style.display = "none";
            box1.style.display = "block";
            box2.style.display = "none";
            box3.style.display = "none";
        }
        function manage() {

            box0.style.display = "none";
            box1.style.display = "none";
            box2.style.display = "block";
            box3.style.display = "none";
        }
        function earning() {
            box0.style.display = "none";
            box1.style.display = "none";
            box2.style.display = "none";
            box3.style.display = "block";
        }

        function showpass() {
            if (delpass.type = "password") {
                delpass.type = "text";
            }
            else {
                delpass.type = "password";
            }
        }

        function errcancel() {
            errmsg.style.display = "none";
        }
    </script>
</body>

</html>