<?php
    session_start();
    if(isset($_SESSION['role'])){
        if($_SESSION['role']==2){
            header("Location:dashboard.php");
        }
        if($_SESSION['role']==1){
            header("Location:adminpanel.php");

        }
    }
    if(isset($_POST['book'])){
        header("Location:bookingpage.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>">
    <title>Home</title>
</head>

<body>
    <div class="main">
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
        <?php
        include "navbar.php";
        ?>

        <div class="box1">
            <section>
                <h1>Park Smart with E-Park!</h1>
                <br>
                <br>
                <h3>Book your car parking spot hastle-free with E-Park and avoid the stress of finding a space.</h3>
                <br>
                <br>
                <form action="" method="post" >
                    <button id="book" name="book" >Book Now</button>
                </form>
            </section>
        </div>

        <div class="box2">
            <section>
                <p>E-Park is a lifesaver for car owners in Asansol. Their booking process is seamless and hassle-free. I
                    never have to worry about finding a parking spot again. Thank you, E-Park!</p>
                <p class="n">- Samantha</p>
            </section>
        </div>
        <div class="box3">
            <h1 id="h">Our Services</h1>
            <div class="images">
                <div id="b1">
                    <img src="image/car2.jpeg" alt="My Image">
                    <h1 id="h1">24/7 online booking</h1>
                    <p id="p1">Our user-friendly booking process makes it easy to reserve parking spaces with just a few
                        clicks.</p>
                </div>
                <div id="b2">
                    <img src="image/car3.jpeg" alt="image">
                    <h1 id="h1">Flexible pricing options</h1>
                    <p id="p1">Our flexible pricing options allows you to customize your parking rate according to your
                        demands, maximizing your profits.</p>
                </div>
                <div id="b3">
                    <img src="image/car4.jpeg" alt="image">
                    <h1 id="h1">Easy payment system</h1>
                    <p id="p1">Our easy payment system makes your payment hassle-free and secure.</p>
                </div>
            </div>
        </div>

        <div class="box4">
            <section id="s1">
                <div id="b4">
                    <h1>About E-park</h1>
                </div>
                <div id="b5">
                    <p id="p2">E-Park is an online parking booking platform. Our goal is to provide a hassle free
                        parking experience to our customers.</p>
                    <p id="p2">With E-Park you can easily book a parking spot in advance and avoid stress of finding a
                        spot on the go. Our platform is user-friendly and secure, ensuring a seamless booking process.
                        Try E-Park today and enjoy a stress-free parking experience.</p>
                </div>
            </section>
        </div>
    </div>
    <script>
        var errmsg=document.getElementById("errmsg");

        function errcancel() {
            errmsg.style.display = "none";
        }
    </script>
</body>

</html>