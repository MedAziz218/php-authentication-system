<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function generateRandomString($length = 8) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charLength = strlen($characters);
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charLength - 1)];
    }
    
    return $randomString;
}

// Require the PHPMailer library

use PHPMailer\PHPMailer\PHPMailer;
require_once("PHPMailer-master/src/PHPMailer.php");
require_once("PHPMailer-master/src/SMTP.php");
$mail = new PHPMailer(true);

// Configure SMTP settings

$mail->isSMTP();

$mail->Host = 'smtp.gmail.com';

$mail->SMTPAuth = true;

$mail->Username = 'tmailtest081@gmail.com';

$mail->Password = 'iqujrvaptbghmjto';

$mail->SMTPSecure = 'ssl'; // You can use 'ssl' if required by your server

$mail->Port = 465; // Use the appropriate port for your server



// Set the sender and recipient

$mail->setFrom('tmailtest081@gmail.com', 'PROJECT_design');

$mail->addAddress('safouaneregaieg6@gmail.com', 'Recipient Name');

$randomString = generateRandomString(8);


// Set email subject and body

$mail->Subject = 'Verification Code';

$mail->Body = 'This is your verification code : '.$randomString;
//$mail->SMTPDebug = 2;
//$mail->Debugoutput = 'html';

// Send the email

if ($mail->send()) {

    echo 'Email sent successfully!';

} else {

    echo 'Error sending email: ';

}

?>

