<?php require_once 'setting.fya'; ?>
<?php
$strMyTable = "tblAppointmentsReminderSMS";
$strMyTableID = "AppointmentReminderSMSID";
$TodaysDate = date('Y-m-d');
$CurrentTime = date('H:i:s');
$SpanTime = date('H:i:s', strtotime('20 minute'));

$DB = Connect();
	$sql = "SELECT * FROM $strMyTable WHERE status='1' and AppointmentDate='$TodaysDate' and
			SMSSendTime>='$CurrentTime' and SMSSendTime<='$SpanTime'";
	$RS = $DB->query($sql);
	if ($RS->num_rows > 0) 
	{
		$counter = 0;
		while($row = $RS->fetch_assoc())
		{
			$counter = $counter + 1;
			$strID = $row["AppointmentReminderSMSID"];
			$strSMSTo = $row["SendSMSTo"];
			$strContent = $row["ContentSMS"];
			
			
			$SendSMS = CreateSMSURL("Nailspa Experience","0","0",$strContent,$strSMSTo);

			if ($SendSMS == "Not Sent")
			{
				$strStatus = '2';
				//echo $strStatus;
				
					$sqlUpdate = "UPDATE $strMyTable SET Status='".$strStatus."' WHERE $strMyTableID='".$strID."'";
					ExecuteNQ($sqlUpdate);
					echo "Reminder SMS <font color='red'>not</font> sent to " . $strSMSTo . "<br>";
				die();
			}
			else
			{
				$strStatus = '0';
				//$strSMSID = $SendSMS['data']['0']['id'];
				//$strSMSMobile = $SendSMS['data']['0']['mobile'];
				//$strSMSStatus = $SendSMS['data']['0']['status'];
				
				// echo $strStatus."<br>";
				// echo "$strSMSID <br>";
				// echo "$strSMSMobile <br>";
				// echo "$strSMSStatus <br>";
			
					$sqlUpdate = "UPDATE $strMyTable SET DateTimeStamp=now() , Status='".$strStatus."' WHERE $strMyTableID='".$strID."'";
					ExecuteNQ($sqlUpdate);
					echo "Reminder SMS sent to " . $strSMSTo . "<br>";
				die();
			}	
		}
	}
	else
	{
		echo"No SMS to send";
		die();
	}
$DB->close();

?>