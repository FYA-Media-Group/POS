<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?
	$STID = $_GET['stid'];
	$target = $_GET['NewTarget'];
	// echo $target."<br>";
	// echo $STID."<br>";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{	
		
		$DB = Connect();
		$sql1="UPDATE tblEmployeeTarget SET BaseTarget=$target where ETID='$STID'";	
		// echo $sql1;
		if ($DB->query($sql1) === TRUE) 
		{
			if($target=="")
			{			
			}
			else
			{
				$weektarget=$target/5;
				// echo $weektarget."<br>";
				$Insertweektarget="Update tblEmployeeTarget set Week1='$weektarget', Week2='$weektarget', Week3='$weektarget', Week4='$weektarget', Week5='$weektarget' where ETID='$STID'";
				// echo $Insertweektarget;
				ExecuteNQ($Insertweektarget);
			}
			echo "Record Updated successfully.";
			//echo $sql1;
		} 
		else 
		{
			echo "Error: " . $sql1 . "<br>" . $DB->error;
		}
		
	}