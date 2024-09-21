<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "epark";
$con = mysqli_connect($server, $user, $pass, $db);
if ($con) {

} else {
    die("connection failed");
}
?>