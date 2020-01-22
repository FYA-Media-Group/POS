<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$DB = Connect();
	$SelectRec= "Select * from tblBackendSMS where Status=0";
	// echo $SelectRec;
	$RS = $DB->query($SelectRec);
	if ($RS->num_rows > 0) 
	{
		while($row = $RS->fetch_assoc())
		{
			$SMSBackendSMSID = $row["BackendSMSID"];
			$SMSContent = $row["Content"];
			$SMSTo1 = $row["To1"];
			$SMSTo1Name = $row["To1Name"];
			$SMSTo2 = $row["To2"];
			$SMSTo2Name = $row["To2Name"];
			$SMSTo3 = $row["To3"];
			$SMSTo3Name = $row["To3Name"];
			$SMSTo4 = $row["To4"];
			$SMSTo4Name = $row["To4Name"];
			$SMSTo5 = $row["To5"];
			$SMSTo5Name = $row["To5Name"];
			$SMSStatus = $row["Status"];
			// echo "SMS BackendSMSID is : ".$SMSBackendSMSID."<br>";
			// echo "SMS Content is " .$SMSContent."<br>";
			// echo $SMSTo1."&nbsp;&nbsp;&nbsp;&nbsp;";
			// echo $SMSTo1Name."<br>";
			// echo $SMSTo2."&nbsp;&nbsp;&nbsp;&nbsp;";
			// echo $SMSTo2Name."<br>";
			// echo $SMSTo3."&nbsp;&nbsp;&nbsp;&nbsp;";
			// echo $SMSTo3Name."<br>";
			// echo $SMSTo4."&nbsp;&nbsp;&nbsp;&nbsp;";
			// echo $SMSTo4Name."<br>";
			// echo $SMSTo4."&nbsp;&nbsp;&nbsp;&nbsp;";
			// echo $SMSTo5Name."<br>";
			// echo "SMS Status is " .$SMSStatus."<br>";
			
			
			//('want to replace','want to display','complete data')
			// $pqr=str_replace($SMSTo1Name, $SMSTo2Name, $SMSTo1Name);
			
			// echo $pqr."<br>";
			// echo $pqr;
			
			//--------------------------------------------------------------
			
			// $totalvalues=array($SMSTo1,$SMSTo2,$SMSTo3,$SMSTo4,$SMSTo5);
			$totalvalues=array($SMSTo1,$SMSTo3);
			
			foreach($totalvalues as $val)
			{
				// $abc="AsmitaSangar";
				$to = $val;    
				$replacing = str_replace($val, $to, $val);
				$SendSMS = CreateSMSURL("Nailspa Experience","0","0",$SMSContent,$replacing);
				
				// echo $replacing."<br>";
			}
			
			
			// $SendSMS = CreateSMSURL("Nailspa Experience","0","0","Welcome Saif Usmani",$SMSContent);
			
			
			
			
		}
	}
	
	
?>