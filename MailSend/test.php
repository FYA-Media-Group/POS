<?php
require 'mail/MailSend.php';

// SendPHPMail($to, $toName, $from, $fromName, $replyto, $replytoName, $subject, $body, $attachments)


SendPHPMail('saiffya@hotmail.com', 'Saif Usmani', "fyagroup@hotmail.com", "FYA Group", "fyagroup@hotmail.com", "FYA Group", "This is a test message", "this is a test body", "");


?>
