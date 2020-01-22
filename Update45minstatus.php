<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?php
	$DB = Connect();
	$app = $_POST["app"];
	$sqlUpdate2 = "UPDATE tblAppointments SET 45minstatus='1' WHERE AppointmentID='".$app."'";
	// echo $sqlUpdate2."<br>";
	if ($DB->query($sqlUpdate2) === TRUE) 
	{
		echo 2;
	}
?>