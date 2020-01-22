<?php require_once 'setting.fya'; ?>

<?php
$strTo = "saiffya@hotmail.com";
$strFrom = "order@fyatest.website";
$strSubject = "Thank you for booking appointment at NailSpa Experience";
$strBody = "";
$strStatus = ""; // Pending = 0 / Sent = 1 / Erroe = 2

$Name = "Handsome Usmani";
$Email = "saiffya@hotmail.com";


//get the file:
$message = file_get_contents('EmailFormat/EmailTemplate.html');
$message = eregi_replace("[\]",'',$message);

//setup vars to replace
$vars = array('{Name_Detail}','{Email_Detail}'); //Replace varaibles
$values = array($Name,$Email);

//replace vars
$message = str_replace($vars,$values,$message);
//echo $message;


$strBody = $message;


$DB = Connect();
$sqlInsert = "Insert into tblEmailMessages (ToEmail, FromEmail, Subject, Body, DateTime, Status) values ('$strTo', '$strFrom', '$strSubject', '$strBody', now() ,'$strStatus')";
ExecuteNQ($sqlInsert);
//echo $sqlInsert;
$DB->close();
die("Email inserted for queue to $strTo");

?>