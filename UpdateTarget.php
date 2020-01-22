<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?
	$STID = $_GET['stid'];
	$target = $_GET['NewTarget'];
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{	
		
		$DB = Connect();
		$sql1="UPDATE tblStoreSalesTarget SET TargetAmount=$target where STID='$STID'";	
		
		if ($DB->query($sql1) === TRUE) 
		{
			echo "Record Updated successfully.";
		} 
		else 
		{
			echo "Error: " . $sql1 . "<br>" . $DB->error;
		}
	}