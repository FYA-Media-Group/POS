<?php require_once("setting.fya"); ?>
<?php
		                                  $DB = Connect();
										  
														$DateInsertUpdate=date("Y-m-d H:i:s");
														$app=$_POST["app"];
														$customer = $_POST["customer"];
													  
														$selpqtyPty=select("*","tblAppointments","AppointmentID='".$app."'");
														$StoreID=$selpqtyPty[0]['StoreID'];
														$AppointmentDate=$selpqtyPty[0]['AppointmentDate'];
														
														$seldpd=select("*","tblStores","StoreID='".$StoreID."'");
				                                        $storname=$seldpd[0]['StoreName'];
														$StoreOfficialNumber=$seldpd[0]['StoreOfficialNumber'];
														$selpqtyP=select("*","tblCustomers","CustomerID='".$customer."'");
														$FirstName=$selpqtyP[0]['FirstName'];
														$customerfullname=$selpqtyP[0]['CustomerFullName'];
														$CustomerMobileNo=$selpqtyP[0]['CustomerMobileNo'];
														$NonCustomerRemark=$selpqtyP[0]['NonCustomerRemark'];
														$CustomerEmailID=$selpqtyP[0]['CustomerEmailID'];
														
														$memberid=$selpqtyP[0]['memberid'];
														$selptrtqistore=select("*","tblStores","StoreID!='0'");
														$StoreName=$selptrtqistore[0]['StoreName'];
														$selptrtqi=select("*","tblMembership","MembershipID='".$memberid."'");
														$MembershipName=$selptrtqi[0]['MembershipName'];
														
														
														$SMSContentforImmediate="Dear ".$FirstName." , this is a reminder for your services that is due for servicing at ".$storname." On ".$AppointmentDate." . To book an appointment call ".$StoreOfficialNumber.".";
		                                                $SendSMS = CreateSMSURL("Service Reminder","0","0",$SMSContentforImmediate,$CustomerMobileNo);
				                                       
													    $InsertSMSDetails="Insert into tblServiceReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo,DateTimeStamp)values('".$app."','".$StoreID."','".$customer."','".$AppointmentDate."','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."', '".$DateInsertUpdate."')";
					                                     if ($DB->query($InsertSMSDetails) === TRUE) 
							                              {
												      echo 2;
														  }
												
													
										
		      
?>