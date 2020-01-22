<?php require_once("setting.fya"); ?>
<?php
		                                  $DB = Connect();
										  $n5_daysAgot = date('Y-m-d', strtotime('-25 days', time()));
										  $todaydate=date('Y-m-d');
										  $stqy=select("distinct(CustomerID)","tblAppointments","StoreID!='0' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgot."'");
											
											foreach($stqy as $vatq)
											{
												$CU[]=$vatq['CustomerID'];
											}
											
											$Productst="Select distinct(CustomerID) from tblAppointments WHERE StoreID!='0' and AppointmentDate<='".$n5_daysAgot."' and AppointmentDate>='2017-02-01'";
											
											$stqytq=select("distinct(CustomerID)","tblAppointments","StoreID!='0' and AppointmentDate<='".$n5_daysAgot."' and AppointmentDate>='2017-02-01' and CommentType!='0' and CustomerRemark!=''");
												foreach($stqytq as $vatqq)
											{
												$CUP[]=$vatqq['CustomerID'];
											}
										
											$RSaT = $DB->query($Productst);
					                  if ($RSaT->num_rows > 0) 
										{
											$counter=0;
											while($rowa = $RSaT->fetch_assoc())
											{
												$counter++;
												
												$Customer=$rowa['CustomerID'];
												
												$EncodedCustomerID = EncodeQ($Customer);
											
												if(in_array("$Customer",$CU))
												{
													
												}
												else
												{
													
													if(in_array("$Customer",$CUP))
													{
														
													}
													else
													{
														 $DateInsertUpdate=date("Y-m-d H:i:s");
													    $cust=EncodeQ($Customer);
														$selptrtapp=select("max(AppointmentID)","tblAppointments","CustomerID='".$Customer."' and StoreID!='0' and AppointmentDate<='".$n5_daysAgot."' and AppointmentDate>='2017-02-01'");
														$app_id=$selptrtapp[0]['max(AppointmentID)'];
														
														$selpqtyPty=select("*","tblAppointments","AppointmentID='".$app_id."'");
														$StoreID=$selpqtyPty[0]['StoreID'];
														$AppointmentDate=$selpqtyPty[0]['AppointmentDate'];
														
														$seldpd=select("StoreName","tblStores","StoreID='".$StoreID."'");
				                                        $storname=$seldpd[0]['StoreName'];
														$StoreOfficialNumber=$seldpd[0]['StoreOfficialNumber'];
														$selpqtyP=select("*","tblCustomers","CustomerID='".$Customer."'");
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
		                                                  $SendSMS = CreateSMSURL("Amount_Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
				                                       
													    $InsertSMSDetails="Insert into tblServiceReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".$app_id."','".$StoreID."','".$Customer."','".$AppointmentDate."','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."')";
					
												       ExecuteNQ($InsertSMSDetails);
												
													}
												}
											}
										}
										else
										{
										}
										
		      
?>