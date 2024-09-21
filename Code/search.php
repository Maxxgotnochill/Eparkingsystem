<?php
session_start();
include "base.php";
$check = 0;
function search()
{
    global $check;
    include "base.php";
    $seaval = $_SESSION['search'];
    $sql = "select * from `parking` where `pname`= '$seaval' and `visibility`='0' ";
    $run = mysqli_query($con, $sql);
    $check = mysqli_num_rows($run);
    if ($check > 0) {
        return $run;
    } else {
        $sql = "select * from `parking` where `place`= '$seaval' and `visibility`='0'";
        $run = mysqli_query($con, $sql);
        $check = mysqli_num_rows($run);
        if ($check > 0) {
            return $run;
        } else {
            $sql = "select * from `parking` where `city`= '$seaval' and `visibility`='0'";
            $run = mysqli_query($con, $sql);
            $check = mysqli_num_rows($run);
            if ($check > 0) {
                return $run;
            } else {
                $sql = "select * from `parking` where `dist`= '$seaval' and `visibility`='0'";
                $run = mysqli_query($con, $sql);
                $check = mysqli_num_rows($run);
                if ($check > 0) {
                    return $run;
                } else {
                    return 0;
                }
            }
        }
    }
}
if (isset($_SESSION['search'])) {
    $msg = "There are no result for this search.";
    $valsql = search();
    $num = $check;
    if (isset($_POST['back'])) {
        unset($_SESSION['search']);
        header("Location:bookingpage.php");
    }

    if (isset($_POST['booking'])) {
        if (isset($_SESSION['id'])) {
            $keyval = $_POST['booking'];
            $_SESSION['pid'] = $keyval;
            header("Location:booking.php");
        } else {
            $err = "You are not loged in please login first.";
        }
    }
} else {
    header("Location:bookingpage.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/search.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/back.css?v=<?php echo time(); ?>">
    <title>Document</title>
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

        <div class="box">
            <div class="heading">
                <p>
                    Showing Results For:
                    <?php echo "\t" . $_SESSION['search']; ?>
                </p>
                <form action="" method="post">
                    <button name="back" id="back">Back</button>
                </form>
            </div>
            <?php
            if ($num > 0) {
                for ($i = 0; $i < $num; $i++) {
                    $val = mysqli_fetch_assoc($valsql);
                    ?>
                    <div class="box1">
                        <div class="name">
                            <span id="pname">Name :
                                <?php echo " " . $val['pname'] ?>
                            </span>
                            <span id="fare">Fare:
                                <?php echo " " . $val['fare']."/Hr."; ?>
                            </span>
                        </div>
                        <span id="place">Address :
                            <?php echo " " . $val['place'] . ","; ?>
                        </span>
                        <span id="city">
                            <?php echo $val['city'] . ","; ?>
                        </span>
                        <span id="dist">
                            <?php echo $val['dist']; ?>
                        </span>
                        <br>
                        <?php
                        $id = $val['userid'];
                        $sql2 = "select ph from `user` where `userid`='$id'";
                        $run2 = mysqli_query($con, $sql2);
                        $val2 = mysqli_fetch_assoc($run2);
                        ?>

                        <div class="btn">
                            <span id="ph">Contact Number :
                                <?php echo " " . $val2['ph']; ?>
                            </span>
                            <form action="" method="post">
                                <button id="booking" name="booking" value="<?php echo $val['pid']; ?>">Book</button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
            <div class="msg">
                <p>
                    <?php echo $msg; ?>
                </p>
            </div>
            <?php
            }
            ?>

        </div>
    </div>
    <script>
        var errmsg = document.getElementById("errmsg");

        function errcancel() {
            errmsg.style.display = "none";
        }
    </script>
</body>

</html>