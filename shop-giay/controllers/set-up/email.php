<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

function send_mail($send_to_mail, $send_to_fullname, $subject, $content, $option = array()){
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'leducduytan2003@gmail.com';                     //SMTP username
        $mail->Password   = 'sysryujyjsjzsjfz';                               //SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->CharSet = 'utf-8';



        //Recipients
        $mail->setFrom('leducduytan2003@gmail.com', 'Thanh Hùng Fulsal');
        $mail->addAddress($send_to_mail, $send_to_fullname);     //Add a recipient
        $mail->addReplyTo('leducduytan2003@gmail.com', 'Thanh Hùng Fulsal');
       

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;
        $mail->send();
    } catch (Exception $e) {
        echo "Gửi thất bại. Chi tiết lỗi: {$mail->ErrorInfo}";
    }
}

