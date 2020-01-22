<?php

require 'PHPMailerAutoload.php';
function SendPHPMail($to, $toName, $from, $fromName, $replyto, $replytoName, $subject, $body, $attachments)
{
	$mail = new PHPMailer;

	
	$mail->isSMTP();
	$mail->SMTPSecure = 'tls';
	$mail->Host = 'smtp.live.com';
	$mail->SMTPAuth = true;
	$mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
	$mail->Port = 587;
	$mail->Username = 'saiffya@hotmail.com';
	$mail->Password = 'Ayf@15fya';
	$mail->setFrom($from, $fromName);
	$mail->addReplyTo($replyto, $replytoName);

	$mail->Subject = $subject;
	$mail->msgHTML($body);

	if($attachments=="" || $attachments==null)
	{
	}
	else
	{
		$attachmentsarray = explode(",", $attachments);
		foreach($attachmentsarray as $key => $val)
		{
			$mail->AddAttachment($attachmentsarray[$key]);
		}
		
	}
	
	$mail->addAddress($to, $toName);
	// $mail->addStringAttachment($row['photo'], 'YourPhoto.jpg'); //Assumes the image data is stored in the DB
	if (!$mail->send()) 
	{
		return false;
	} 
	else
	{
		return true;
	}
	
	// Function Parameters Format. SendPHPMail($to, $toName, $from, $fromName, $replyto, $replytoName, $subject, $body, $attachments)
	// Leave attachments blank if none. Add with comma separated values if multiple. 
	
}


?>