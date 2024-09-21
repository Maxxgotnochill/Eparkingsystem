<?php
    session_start();
    include "base.php";
    if(isset($_POST['btn2'])){
        $search=$_POST['search'];
        $_SESSION['search']=$search;
        header("Location:search.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/bookingpage.css?v=<?php echo time(); ?>">
    <title>Booking</title>
</head>

<body>
    <div class="main">
        <?php
        include "navbar.php";
        ?>
    </div>
    <div class="box1">
        <div id="box1">
            <br>
            <br>
            <br>
            <br>
            <img src="Image/parking2.png" alt="image">
            <br>
            <form action="" class="searchbar" method="post">
                <input type="search" placeholder="Search places" name="search" id="search" required >
                <button id="btn2" name="btn2" ><img src="Image/searchbtn.png" alt="image"></button>
            </form>
        </div>
        <div id="box2">
            <img src="Image/parking.png" alt="image">
        </div>
    </div>
    <div class="box2">
    <h1 id="h">Available Spaces</h1>
        <div class="images">
            
            <div id="b1">
                <img src="Image/annapurna.jpg" alt="image">
                <h1 id="h1">Bishnupur Annapurna Hotel</h1>
                <p id="p1"></p>
            </div>
            <div id="b2">
                <img src="Image/kg.jpeg" alt="image">
                <h1 id="h1">Bishnupur K.G. Engineering Institute</h1>
                <p id="p1"></p>
            </div>
            <div id="b3">
                <img src="Image/poramatirhat.jpg" alt="image">
                <h1 id="h1">Bishnupur Poramatirhat</h1>
                <p id="p1"></p>
            </div>
        </div>
    </div>
</body>

</html>