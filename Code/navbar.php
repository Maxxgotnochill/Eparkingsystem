<?php
include "base.php";
$pagehome = "index.php";
$pagepro = "profile.php";
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 2) {
        $pagehome = "dashboard.php";
        $pagepro = "ownerpro.php";
    }
    if ($_SESSION['role'] == 1) {
        $pagehome = "adminpanel.php";
        $pagepro = "profile.php";
    }
}
$check = 0;
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $query = "select *  from `user` where `userid`='$id'";
    $run = mysqli_query($con, $query);
    $val = mysqli_fetch_assoc($run);
    $user = $val['user'];
    $check = 1;
}
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/navbar.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="navbar">
        <h2>E-<span>Park</span></h2>
        <ul>
            <li><button id="how" onclick="openpopup()"> How it Work</button></li>
            <li><a href="<?php echo $pagehome; ?>">Home</a></li>
            <li>
                <?php
                if ($check == 0) {
                    ?>
                    <a href="login.php">Login</a>
                    <?php
                } else {
                    ?>
                    <button id="btn">
                        <?php echo $user; ?>

                    </button>
                    <div class="drop">
                        <ul>
                            <li><a href="<?php echo $pagepro; ?>">Profile</a></li>
                            <?php
                            if ($_SESSION['role'] != 1) {
                                ?>
                                <li><a href="history.php">History</a></li>
                                <li><a href="cardetails.php">Car</a></li>

                                <?php
                            }
                            ?>
                            <li>
                                <form action="" method="post">
                                    <button id="logout" name="logout">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <?php
                }
                ?>
            </li>
            <li><a href="contactus.php">Contact Us</a></li>
        </ul>
    </div>
    <div class="popup" id="popup">
        <h2>How it works?</h2>
        <h5>1.Find the best parking</h5>
        <p>near your destination.</p>
        <h5>2.Book your spot at a good price</h5>
        <p>and you will also save going around in circles.</p>
        <h5>3.Show your reservation when you arrive at the parking lot.</h5>
        <p>It will be easy.</p>
        <button type="button" onclick="closepopup()">OK</button>
    </div>
    <script>
        let popup = document.getElementById("popup");
        function openpopup() {
            popup.classList.add("open-popup");
        }
        function closepopup() {
            popup.classList.remove("open-popup");
        }
    </script>
</body>

</html>