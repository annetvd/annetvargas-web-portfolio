<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "vendor/autoload.php";
include "variables.php";

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->CharSet = "UTF-8";
    $mail->Port = 587;

    $mail->Username = $correoApeajal;
    $mail->Password = $ContrasenaCorreo;

    $mail->setFrom($correoApeajal, $_POST["name"]);
    $mail->addAddress($correoApeajal, "Annet");

    $mail->isHTML(true);
    $mail->Subject = "Web portfolio";
    $mail->Body = <<<EOD
    Name: {$_POST["name"]}
    E-mail: {$_POST["email"]}
    Phone: {$_POST["phone"]}
    I'm: {$_POST["iAm"]}

    Message: {$_POST["message"]}
    EOD;

    $mail->send();
    echo "1";
} catch (Exception $e) {
    echo "2";
}
?>
