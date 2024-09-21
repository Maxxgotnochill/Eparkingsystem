<?php
session_start();
include "base.php";
$number = $_GET['number'];
echo $number;
if (isset($_POST['confirm'])) {
    $pname = $_GET['pname'];
    $place = $_GET['place'];
    $city = $_GET['city'];
    $dist = $_GET['dist'];
    $fare = $_GET['fare'];
    $id = $_SESSION['id'];
    $sql_parking = "insert into `parking` (`userid`, `pname`, `place`, `city`, `dist`, `fare`, `number`) values ('$id', '$pname', '$place', '$city', '$dist', '$fare', '$number')";
    $run_parking = mysqli_query($con, $sql_parking);
    $sql_parking2 = "select * from `parking` where `userid`='$id' and `pname`='$pname' and `place`='$place'";
    $val_parking = mysqli_fetch_assoc(mysqli_query($con, $sql_parking2));
    $pid = $val_parking['pid'];
    for ($i = 1; $i <= $number; $i++) {
        $sql_spot = "insert into `parking spot` (`pid`, `spotno`) values ('$pid', '$i')";
        $run_spot = mysqli_query($con, $sql_spot);
    }
    $sql_route = "select * from `route` where 1";
    $check_route = mysqli_num_rows(mysqli_query($con, $sql_route));
    if ($check_route < $number) {
        $i = $check_route + 1;

        for (; $i <= $number; $i++) {
            $col = $i % 10;
            if ($col == 0) {
                echo "start" . "<br>" . "<br>";
                $row = intval($i / 10);
                if ($row == 1) {
                    $note = "st";
                } elseif ($row == 2) {
                    $note = "nd";
                } elseif ($row == 3) {
                    $note = "rd";
                } else {
                    $note = "th";
                }
                $str = "From entrance take left then " . $row . $note . " row, 5th spot";

            } else {
                $row = intval($i / 10) + 1;
                if ($row == 1) {
                    $note = "st";
                } elseif ($row == 2) {
                    $note = "nd";
                } elseif ($row == 3) {
                    $note = "rd";
                } else {
                    $note = "th";
                }
                if ($col <= 5) {
                    if ($col == 1) {
                        $str = "From entrance take right then " . $row . $note . " row, 5th spot";
                    } elseif ($col == 2) {
                        $str = "From entrance take right then " . $row . $note . " row, 4th spot";
                    } elseif ($col == 3) {
                        $str = "From entrance take right then " . $row . $note . " row, 3rd spot";
                    } elseif ($col == 4) {
                        $str = "From entrance take right then " . $row . $note . " row, 2nd spot";
                    } else {
                        $str = "From entrance take right then " . $row . $note . " row, 1st spot";
                    }
                } else {
                    $colleft = $col % 5;
                    if ($colleft == 1) {
                        $str = "From entrance take left then " . $row . $note . " row, 1st spot";
                    } elseif ($colleft == 2) {
                        $str = "From entrance take left then " . $row . $note . " row, 2nd spot";
                    } elseif ($colleft == 3) {
                        $str = "From entrance take left then " . $row . $note . " row, 3rd spot";
                    } else {
                        $str = "From entrance take left then " . $row . $note . " row, 4th spot";
                    }
                }
            }
            $sql_route = "insert into `route` (`spotno`, `route`) values('$i', '$str')";
            $run_route = mysqli_query($con, $sql_route);
        }



    }
    $_SESSION['msg'] = "Parking lot listed";
    header("Location:dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/back.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/listparking.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>

<body>
    <div class="main">
        <?php
        if (isset($number)) {
            // echo $datestart;
            ?>
            <div class="box">
                <h1>Parking</h1>
                <div class="spotbox">

                    <?php
                    for ($i = 1; $i <= $number; ) {
                        ?>
                        <div class="spot">
                            <div class="leftspot">
                                <?php for ($j = 0; $j < 5; $j++) {
                                    if ($i > $number) {
                                        break;
                                    }
                                    ?>
                                    <button name="empty" id="empty" value="<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </button>
                                    <?php

                                    $i++;
                                } ?>
                            </div>
                            <div class="rightspot">
                                <?php for ($j = 0; $j < 5; $j++) {
                                    if ($i > $number) {
                                        break;
                                    }
                                    ?>
                                    <button name="empty" id="empty" value="<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </button>
                                    <?php

                                    $i++;
                                } ?>
                            </div>
                        </div>
                        <?php
                    }

                    ?>

                </div>

                <div class="btn">
                    <form action="" method="post">
                        <button name="confirm" id="confirm">Confirm</button>
                    </form>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</body>

</html>