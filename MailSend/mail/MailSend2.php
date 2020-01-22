<?php

require 'PHPMailerAutoload.php';
function SendPHPMail($to, $toName, $from, $fromName, $replyto, $replytoName, $subject, $body, $attachments)
{
$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
// $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = "plus.smtp.mail.yahoo.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = "thewanderplan@yahoo.com";
$mail->Password = "India@123";
$mail->SetFrom("thewanderplan@yahoo.com", "The Wander Plan");
$mail->Subject = "Test";
$mail->Body = "hello";
$mail->AddAddress("dalla.aftab@gmail.com");

 if(!$mail->Send())
 {
    echo "Message sending failed";
 }
 else
 {
    echo "Message has been sent";
 }
	
}


?>