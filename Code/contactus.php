<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $message = $_POST['message'];
    $status = sendmail($name, $email, $number, $message);
    if ($status) {
        $error = "Yayy! Message sent!";
    } else {
        $error = "Opps! Message not sent!";
    }
}
function sendmail($name, $email, $number, $message)
{
    require "PHPMailer/PHPMailer.php";
    require "PHPMailer/Exception.php";
    require "PHPMailer/SMTP.php";
    $mail = new PHPMailer(true);

    try {
        //Server settings

        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.hostinger.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'ratul@toolify.online'; //SMTP username
        $mail->Password = 'ratul123##RR'; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('ratul@toolify.online', 'E-Park');
        $mail->addAddress('ratulpal2002@gmail.com', 'Ratul Pal'); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'You have a new message from'.":-" . $name;
        $mail->Body = "name: $name <br> email: $email <br> number: $number <br> message: $message";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/back.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="CSS/contactus.css?v=<?php echo time(); ?>">
    <title>Contact Us</title>
</head>

<body>
    <div class="main">
        <?php
        include "navbar.php";
        ?>
        <div class="container">
            <div class="box">
                <h2 id="h4">Get in touch</h2>
                <form class="contusform" method="post" action="#">
                    <input type="text" name="name" id="name" placeholder="Name" required>
                    <br>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                    <br>
                    <input type="number" name="number" id="no" placeholder="Contact Number" required min="0">
                    <br>
                    <textarea name="message" id="fillup" cols="30" rows="10" placeholder="How can we help you?"
                        required></textarea>
                    <br>
                    <button type="submit" name="send" id="btn3">Send</button>
                    <br>
                </form>
            </div>
        </div>
    </div>
    <script src="https://smtpjs.com/v3/smtp.js"></script>
    <script>
        function sendEmail() {
            Email.send({
                Host: "smtp.gmail.com",
                Username: "email",
                Password: "password",
                To: 'avijitash06@gmail.com',
                From: document.getElementById("email").value,
                Subject: "Contact Form Enquiry",
                Body: "And this is the body"
            }).then(
                message => alert(message)
            );
        }
    </script>
</body>

</html>