<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$TodaysDate = date("Y-m-d");
	$strERID1 = Filter($_POST["getERID"]);
	// echo $strERID1;
	// $strERID2= Decode($strERID1);
	// echo $strERID2;
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{	
		// echo $strERID1;
		$DB = Connect();
		 $seldataqty=select("EmployeeCode","tblEmployeesRecords","ERID ='$strERID1'");
		 $EmployeeCode=$seldataqty[0]['EmployeeCode'];
		 $seldataqddt=select("EID","tblEmployees","EmployeeCode='".$EmployeeCode."'");
	     $EID=$seldataqddt[0]['EID'];
		
		 $seldataqddtZXC=select("count(*)","tblEmployeeWeekOff","EID='".$EID."' and  Date('".$TodaysDate."') between Date(WeekOffStartDate) and Date(WeekOffEndDate)");
		 $cnttt=$seldataqddtZXC[0]['count(*)'];
		 
		 if($cnttt>0)
		 {
			 	$sql1 = "Update tblEmployeesRecords set LogoutTime=now(),Status='2',OnLeaveStatus='1' where ERID ='$strERID1'";
		 }
		 else
		 {
			 	$sql1 = "Update tblEmployeesRecords set LogoutTime=now(),Status='2' where ERID ='$strERID1'";
		 }
		
		
	
		if ($DB->query($sql1) === TRUE) 
		{
			$timesql="Select TIMEDIFF(LogoutTime,LoginTime) as Hour1 from tblEmployeesRecords Where ERID = $strERID1";
			$RS = $DB->query($timesql);
			if ($RS->num_rows > 0) 
			{
				$row = $RS->fetch_assoc();
				$x = $row['Hour1'];
				echo "Completed ".$x." Hours.";
			}
		} 
		else 
		{
			echo "Error: " . $sql1 . "<br>" . $DB->error;
		}
	}
?>