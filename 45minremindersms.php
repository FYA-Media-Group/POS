<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?php
		$DB = Connect(); 
		date_default_timezone_set('Asia/Kolkata');
		$date=date('Y-m-d');
			$sqlservice = "SELECT * from tblAppointments where tblAppointments.StoreID!='0' and tblAppointments.Status='0' and Date(tblAppointments.AppointmentDate)>='".$date."' and Date(tblAppointments.AppointmentDate)<='".$date."' AND AppointmentCheckInTime='00:00:00'";
		
		$RSservice = $DB->query($sqlservice);
		if ($RSservice->num_rows > 0) 
		{
			$counterservice = 0;

			while($rowservice = $RSservice->fetch_assoc())
			{
				$toatlseramt="";
				
				$StoreID = $rowservice["StoreID"];
				$seldpd=select("StoreName","tblStores","StoreID='".$StoreID."'");
				$storname=$seldpd[0]['StoreName'];
			
				$CustomerID = $rowservice["CustomerID"];
				$AppointmentDate = $rowservice["AppointmentDate"];
				
				
			    $AppointmentID = $rowservice["AppointmentID"];
				$SuitableAppointmentTime = $rowservice["SuitableAppointmentTime"];
				$timestamp =  date("H:i:s", time());
				
				$date1=$timestamp;
				$date2=$SuitableAppointmentTime;
				$dateyu=Date('Y-m-d H:i:s');
				
                $datetime_from = date($date1, strtotime("-45 minutes", strtotime($date2)));
				
				if($datetime_from==$timestamp)
				{
					
					    $seldpdep=select("*","tblCustomers","CustomerID='".$CustomerID."'");
												 $FirstName=$seldpdep[0]['FirstName'];
												 $CustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												
												$sqlgraph=select("count(*)","tblAppointmentsReminderSMS","AppointmentID='".$AppointmentID."' and CustomerID='".$CustomerID."' and 45minstatus='1'");
												$cntdata=$sqlgraph[0]['count(*)'];												
												
												if($cntdata>0)
												{
													
												}
												else
												{
													
												$SMSContentforImmediate="Dear ".$FirstName." we wish to remind you that your appnt is scheduled for ".$AppointmentDate." ,".$SuitableAppointmentTime."  at ".$storname.". To avoid cancellation charges, pls reschedule.";
		
					// echo "In if<br>";
												$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo,45minstatus,DateTimeStamp)values('".$AppointmentID."','".$StoreID."','".$CustomerID."','".$AppointmentDate."','".$SuitableAppointmentTime."','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."','1','".$dateyu."')";
					
												ExecuteNQ($InsertSMSDetails);
					// die();
					                            $SendSMS = CreateSMSURL("Amount_Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
												}
				
				}
				
						                     
			}
		}
	?>