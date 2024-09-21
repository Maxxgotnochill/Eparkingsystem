<?php
include "base.php";
session_start();
$pid = $_GET['value'];
$query = "select *  from `parking` where `pid`='$pid'";
$run = mysqli_query($con, $query);
$val = mysqli_fetch_assoc($run);
$pname = $val['pname'];
$fare = $val['fare'];
$number = $val['number'];
$number2 = $number;
$place = $val['place'];
$city = $val['city'];
$dist = $val['dist'];
if (isset($_POST['usave'])) {
    $pname = $_POST['user'];
    $query = "update `parking` set `pname`='$pname' where `pid`='$pid'";
    $run1 = mysqli_query($con, $query);
}
if (isset($_POST['esave'])) {
    $fare = $_POST['email'];
    $query = "update `parking` set `fare`='$fare' where `pid`='$pid'";
    $run1 = mysqli_query($con, $query);
}
if (isset($_POST['numsave'])) {
    $spotno = $_POST['number'];
    $query = "update `parking` set `number`='$spotno' where `pid`='$pid'";
    $run1 = mysqli_query($con, $query);
    if ($spotno > $number2) {
        $i = $number2 + 1;
        for (; $i <= $spotno; $i++) {
            $sql_spot = "insert into `parking spot` (`pid`, `spotno`) values ('$pid', '$i') ";
            $run_spot = mysqli_query($con, $sql_spot);

        }
    } else if ($spotno < $number2) {
        $i = $number2;
        for (; $i > $spotno; $i--) {
            $sql_spot2 = "delete from `parking spot` where `pid`='$pid' and `spotno`='$i' ";
            $run_spot2 = mysqli_query($con, $sql_spot2);
        }

    }
    $number=$spotno;
    $sql_route = "select * from `route` where 1";
    $check_route = mysqli_num_rows(mysqli_query($con, $sql_route));
    if ($check_route < $number) {
        $i = $check_route + 1;

        for (; $i <= $number; $i++) {
            $col = $i % 10;
            if ($col == 0) {
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
}
if(isset($_POST['mainback'])){
    $role=$_SESSION['role'];
    if($role==2){
        header("Location:dashboard.php");
    }
    else{
        header("Location:adminpanel.php");

    }
}
// if (isset($_POST['gsave'])) {
//     $gen = $_POST['gen'];
//     $query = "update `user` set `gender`='$gen' where `userid`='$id'";
//     $run1 = mysqli_query($con, $query);
// }
// if (isset($_POST['asave'])) {
//     $add = $_POST['add'];
//     $query = "update `user` set `address`='$add' where `userid`='$id'";
//     $run1 = mysqli_query($con, $query);
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/navbar.css?v=<?php echo time() ?>">
    <link rel="stylesheet" href="css/ownermanage.css?v=<?php echo time() ?>">
    <link rel="stylesheet" href="css/back.css?v=<?php echo time() ?>">
    <title>Manage</title>
</head>

<body>
    <div class="main">
        <?php
        include "navbar.php";
        ?>
        <div class="box">
            <h1>Manage Parking</h1>
            <div class="inputfield">
                <div class="user">
                    <form action="" method="post">
                        <label for="user">Parking Name</label>

                        <br>
                        <input type="text" id="user" name="user" value="<?php echo $pname; ?>" disabled>
                        <span onclick="uch()" id="uedit">Edit</span>
                        <br>
                        <div class="btn" id="ubtn">
                            <button id="usave" name="usave">Save</button>
                            <button id="ucan" onclick="ucancel()">Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="email">
                    <form action="" method="post">
                        <label for="email">Fare</label>

                        <br>
                        <input type="number" id="email" name="email" value="<?php echo $fare; ?>" disabled>
                        <span onclick="ech()" id="eedit">Edit</span>
                        <br>
                        <div class="btn" id="ebtn">
                            <button id="esave" name="esave">Save</button>
                            <button id="ecan" onclick="ecancel()">Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="ph">
                    <form action="" method="post">
                        <label for="ph">Number of Spots</label>

                        <br>
                        <input type="text" id="ph" name="number" value="<?php echo $number; ?>" disabled>
                        <span onclick="pch()" id="pedit">Edit</span>
                        <br>
                        <div class="btn" id="pbtn">
                            <button id="psave" name="numsave">Save</button>
                            <button id="pcan" onclick="pcancel()">Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="gen">
                    <form action="" method="post">
                        <label for="gen">Place</label>

                        <br>
                        <input type="text" id="gen" name="gen" value="<?php echo $place; ?>" disabled>
                        <!-- <span onclick="gch()" id="gedit">Edit</span> -->
                        <br>
                        <div class="btn" id="gbtn">
                            <button id="gsave" name="gsave">Save</button>
                            <button id="gcan" onclick="gcancel()">Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="city">
                    <form action="" method="post">
                        <label for="gen">City</label>

                        <br>
                        <input type="text" id="gen" name="gen" value="<?php echo $city; ?>" disabled>
                        <!-- <span onclick="gch()" id="gedit">Edit</span> -->
                        <br>
                        <div class="btn" id="gbtn">
                            <button id="gsave" name="gsave">Save</button>
                            <button id="gcan" onclick="gcancel()">Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="dist">
                    <form action="" method="post">
                        <label for="gen">District</label>

                        <br>
                        <input type="text" id="gen" name="gen" value="<?php echo $dist; ?>" disabled>
                        <!-- <span onclick="gch()" id="gedit">Edit</span> -->
                        <br>
                        <div class="btn" id="gbtn">
                            <button id="gsave" name="gsave">Save</button>
                            <button id="gcan" onclick="gcancel()">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
            <div class="backbtn">
                <form action="" method="post">
                    <button id="mainback" name="mainback">Back</button>
                </form>
            </div>

        </div>


    </div>
    <script>
        var ubtn = document.getElementById("ubtn");
        var ebtn = document.getElementById("ebtn");
        var pbtn = document.getElementById("pbtn");
        var user = document.getElementById("user");
        var email = document.getElementById("email");
        var ph = document.getElementById("ph");
        // var gen = document.getElementById("gen");
        // var gbtn = document.getElementById("gbtn");
        var uedit = document.getElementById("uedit");
        var eedit = document.getElementById("eedit");
        var pedit = document.getElementById("pedit");
        // var gedit = document.getElementById("gedit");
        var delpass = document.getElementById("deletpass");

        function uch() {
            ubtn.style.display = "block";
            user.disabled = false;
            user.style.backgroundColor = "#ececec";
            user.style.textAlign = "left";
            user.style.paddingLeft = "10px";
        }
        function ucancel() {
            ubtn.style.display = "none";
            user.disabled = true;
            user.style.backgroundColor = "#dafefb";
            user.style.textAlign = "center";
            user.style.borderBottom = "none"
            user.style.paddingLeft = "0px";

        }

        function ech() {
            ebtn.style.display = "block";
            email.disabled = false;
            email.style.backgroundColor = "#ececec";
            email.style.textAlign = "left";
            email.style.paddingLeft = "10px";
        }
        function ecancel() {
            ebtn.style.display = "none";
            email.disabled = true;
            email.style.backgroundColor = "#dafefb";
            email.style.textAlign = "center";
            email.style.paddingLeft = "0px";
        }

        function pch() {
            pbtn.style.display = "block";
            ph.disabled = false;
            ph.style.backgroundColor = "#ececec";
            ph.style.textAlign = "left"
            ph.style.paddingLeft = "10px";
        }
        function pcancel() {
            pbtn.style.display = "none";
            ph.disabled = true;
            ph.style.backgroundColor = "#dafefb";
            ph.style.textAlign = "center";
            ph.style.paddingLeft = "0px";
        }

        function gch() {
            gbtn.style.display = "block";
            gen.disabled = false;
            gen.style.backgroundColor = "#ececec";
            gen.style.textAlign = "left";
            gen.style.paddingLeft = "10px";
        }
        function gcancel() {
            gbtn.style.display = "none";
            gen.disabled = true;
            gen.style.backgroundColor = "#dafefb";
            gen.style.textAlign = "center";
            gen.style.paddingLeft = "0px";
        }

        function ach() {
            abtn.style.display = "block";
            add.disabled = false;
            add.style.backgroundColor = "#ececec";
            add.style.textAlign = "left";
            add.style.paddingLeft = "10px";
        }
        function acancel() {
            abtn.style.display = "none";
            add.disabled = true
            add.style.backgroundColor = "#dafefb";
            add.style.textAlign = "center";
            add.style.paddingLeft = "0px";
        }


    </script>
</body>

</html>