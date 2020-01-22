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
												 $CustomerEmailID=$seldpdep[0]['CustomerEmailID'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												
												$sqlgraph=select("count(*)","tblAppointmentsReminderEmail","AppointmentDate='".$date."' and CustomerID='".$CustomerID."' AND SuitableAppointmentTime='".$SuitableAppointmentTime."'");
												$cntdata=$sqlgraph[0]['count(*)'];												
												
												if($cntdata>0)
												{
													
												}
												else
												{
													
												$strTo=$CustomerEmailID;
												//$strTo="yogitafya@hotmail.com,vinayfya@hotmail.com";
												if($strTo=="")
												{
													echo "Email Id Cannot Blank";
												}
												else
												{
													//echo 1324;
													
													$emailclosecontent="Dear : ".$FirstName." <br/> We wish to remind you that your appnt is scheduled for : ".$AppointmentDate." <br/>Time : ".$SuitableAppointmentTime.
														"<br/> Location : ".$storname.
														"<br/> To avoid cancellation charges, pls reschedule";
												
														//$SMSContentforImmediate="hello";
														$strFrom = "45MinServiceReminder@nailspaexperience.com";
													//	$strFrom = "45MinServiceReminder@spotlightindia.in";
														
													    $strSubject = "45 Minute Service Reminder";
														
												
                                                            $strbody1="<html><head><title>45 Minute Service Reminder</title></head><body>$emailclosecontent</body></html>";
															$headers = "From: $strFrom\r\n";
															$headers .= 'Cc: operations@nailspaexperience.com,noor@nailspaexperience.com' . "\r\n";
															$headers .= "Content-type: text/html\r\n";
															$strBodysa = $strbody1;	
													
															
														

														   $SendCC1="operations@nailspaexperience.com";
														   $SendCC2="noor@nailspaexperience.com";
															//$SendCC1="asmitafya@hotmail.com";
															//$SendCC2="vinayfya@hotmail.com";
														//$strBodysa = $strbody1;
														// Mail sending 
														$retval = mail($strTo,$strSubject,$strBodysa,$headers);

														if( $retval == true )
														{
															echo 33333;
															echo "Email sent to " . $strTo;
															
															$InsertSMSDetails="Insert into tblAppointmentsReminderEmail (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  EmailSendTime,SendEmailTo,SendCC1,SendCC2,Subject,ContentEmail,DateTimeStamp)values('".$AppointmentID."','".$StoreID."','".$CustomerID."','".$AppointmentDate."','".$SuitableAppointmentTime."','".$timestamp."','".$strTo."','".$SendCC1."', '".$SendCC2."','".$strSubject."','".$strBody1."','".$dateyu."')";
								
															ExecuteNQ($InsertSMSDetails);
														}
														else
														{
															
															echo "<font color='red'>Email sending failed to " . $strTo . "</font>";
														}
												} 
													
												}
				
				}
				
						                     
			}
		}
	?>