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
			 $sql1 = "Update tblEmployeesRecords set LoginTime=now(),Status='1',OnLeaveStatus='1' where ERID ='$strERID1'";	
		 }
		 else
		 {
			 $sql1 = "Update tblEmployeesRecords set LoginTime=now(),Status='1' where ERID ='$strERID1'";	
		 }
		 
		
		// echo $sql1;
		if ($DB->query($sql1) === TRUE) 
		{
			// echo "Record Update successfully.";
			$sqlcheckout = "Select LoginTime, LogoutTime from tblEmployeesRecords where ERID ='$strERID1'";
			$RS1 = $DB->query($sqlcheckout);
			if ($RS1->num_rows > 0) 
			{
				$row1 = $RS1->fetch_assoc();
				$strLoginTime = $row1['LoginTime'];
				$strLogoutTime = $row1['LogoutTime'];
				if($LogoutTime=="00:00:00" && $LoginTime != "00:00:00")
				{
			
						echo '<div align="center"  id="CheckOut<?=$strERID?>">
							<a class=" btn btn-xs btn-primary  result_message1<?=$strERID?>" value="CheckOut" id="CheckOut" name="CheckOut" onclick="CheckOut(<?=$strERID?>);" >CheckOut</a>
						</div>';
			
				}
			}
			
		} 
		else 
		{
			echo "Error: " . $sql1 . "<br>" . $DB->error;
		}
	}
?>