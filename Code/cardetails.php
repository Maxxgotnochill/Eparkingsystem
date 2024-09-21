<?php
session_start();
include "base.php";
$userid = $_SESSION['id'];
$sql_car = "select *  from `car` where `userid`='$userid'";
$run_car = mysqli_query($con, $sql_car);
$check_car = mysqli_num_rows($run_car);
if (isset($_POST['car'])) {
    header("Location:car.php?key=2");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/back.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/cardetails.css?v=<?php echo time(); ?>">
    <title>Car Details</title>
</head>

<body>
    <div class="main">
        <?php
        include "navbar.php";
        ?>
        <div class="box1">
            <h1>Car Details</h1>
            <form action="" method="post">
                <button id="car" name="car">Add Car</button>
            </form>
        </div>
        <div class="box2">
            <?php
            if ($check_car > 0) {
                for ($i = 1; $i <= $check_car; $i++) {
                    $val_car = mysqli_fetch_assoc($run_car);
                    ?>

                    <div class="car">
                        <span id="carspan" >Car No.
                            <?php echo " " . $i; ?>
                        </span>
                        <div class="input">
                            <div class="carleft">
                                <label for="brand">Brand</label>
                                <br>
                                <input type="text" class="inp" name="brand" id="brand" value="<?php echo $val_car['brand']; ?>"
                                    disabled>
                                <br>
                                <label for="color">Color</label>
                                <br>
                                <input type="text" class="inp" id="color" name="color" value="<?php echo $val_car['color']; ?>"
                                    disabled>
                            </div>
                            <div class="carright">
                                <label for="model">Model</label>
                                <br>
                                <input type="text" class="inp" id="model" name="model" value="<?php echo $val_car['model']; ?>"
                                    disabled>
                                <br>
                                <label for="number">registration No.</label>
                                <br>
                                <input type="text" class="inp" name="no" id="no" value="<?php echo $val_car['no']; ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
            <div class="box3">
                <p>There are no car.</p>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>