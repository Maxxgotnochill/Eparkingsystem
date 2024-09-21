<?php
session_start();
include "base.php";
$key=$_GET['key'];
if(isset($_POST['skip'])){
    header("Location:index.php");
}
if(isset($_POST['cancel'])){
    if($key=='2'){
        header("Location:cardetails.php");
    }
    else{
        header("Location:index.php");
    }
}
if(isset($_POST['done'])){
    $brand=$_POST['brand'];
    $model=$_POST['model'];
    $color=$_POST['color'];
    $no=$_POST['no'];
    $id=$_SESSION['id'];
    $sql_car="insert into `car` (`userid`, `brand`, `model`, `color`, `no`) values ('$id','$brand', '$model', '$color', '$no')";
    $run_car=mysqli_query($con, $sql_car);
    if($key=='1'){
        header("Location:bookingpage.php");
    }
    elseif($key=='2'){
        header("Location:cardetails.php");
    }
    else{
        header("Location:index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/back.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/car.css?v=<?php echo time(); ?>">
    <title>Car</title>
</head>

<body>
    <div class="main">
        <?php
        include "navbar.php";
        ?>
        <div class="box">
            <h1 id="ch" >Enter Car Details</h1>
            <div class="input">
                <form action="" method="post">
                    <input type="text" class="inp" id="brand" name="brand" placeholder="Brand name" required>
                    <br>
                    <input type="text" class="inp" id="model" name="model" placeholder="Model name" required>
                    <br>
                    <input type="text" class="inp" id="color" name="color" placeholder="Color" required>
                    <br>
                    <input type="text" class="inp" id="no" name="no" placeholder="Registration Number" required>
                    <div class="carbtn">
                        <button id="done" name="done" >Done</button>
                    </div>
                </form>
            </div>
            <div class="skip">
                <form action="" method="post">
                    <?php
                        if($key==0){
                            ?>
                                <!-- <button id="skip" name="skip" >Skip</button> -->
                            <?php
                        }
                        else{
                            ?>
                                <button id="skip" name="cancel" >Cancel</button>
                            <?php
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>

</html>