<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
?>
<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Manage Customers | Nailspa";
	$strDisplayTitle = "Manage Customers for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblCustomers";
	$strMyTableID = "CustomerID";
	$strMyField = "CustomerMobileNo";
	$strMyActionPage = "ManageCustomers.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
// code for not allowing the normal admin to access the super admin rights	


	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		//echo "Submit";
		//echo $_POST["step"];
		//exit();
		// foreach($strServicesused as $Service)
		// {
		// echo $Service;
		// }
		// die();
		$strStep = Filter($_POST["step"]);
		if($strStep=="assign")
		{
			$strServicesused = $_POST["Services"];
			$strTechnicianSelect = $_POST["TechnicianSelect"];
			$strFirstName = Filter($_POST["FirstName"]);
			$strLastName = Filter($_POST["LastName"]);
			$strGender = Filter($_POST["Gender"]);
			
			
			$strCustomerFullName = $strFirstName." ".$strLastName;
			foreach($_POST as $key => $val)
			{
				if($key!="step")
				{
					if(IsNull($sqlColumn))
					{
						$sqlColumn = $key;
						$sqlColumnValues = "'".$_POST[$key]."'";
					}
					else
					{
						$sqlColumn = $sqlColumn.",".$key;
						$sqlColumnValues = $sqlColumnValues.", '".$_POST[$key]."'";
					}
				}
	
			}
			
			
			
			// $strCustomerFullName = Filter($_POST["CustomerFullName"]);
			$strCustomerEmailID = Filter($_POST["CustomerEmailID"]);
			$strCustomerMobileNo = Filter($_POST["CustomerMobileNo"]);
			$strStartDay = $_POST["StartDay"];
			$date = new DateTime($strStartDay);
			$strStartDay1 = $date->format('Y-m-d'); // 31-07-2012
			// echo $strStartDay1."<br>";
			
			$strEndDay = $_POST["EndtDay"];
			$date1 = new DateTime($strEndDay);
			$strEndDay1 = $date1->format('Y-m-d'); // 31-07-2012
			// echo $strEndDay1."<br>";
			
			// echo $strStartDay;
			// echo $strEndDay;
			// die();
			$strStoreID = Filter($_POST["StoreID"]);
			$strAppointmentDate5 = Filter($_POST["AppointmentDate"]);
			$date5 = new DateTime($strEndDay);
			$strAppointmentDate6 = $date5->format('Y-m-d'); // 31-07-2012
			
			// echo $strStoreID;
			// echo $strAppointmentDate;
			$strSuitableAppointmentTime = Filter($_POST["SuitableAppointmentTime"]);
			$date=new DateTime();
			$pqr = date("H:i:s",strtotime($strSuitableAppointmentTime));
			//echo $pqr."<br>";
			
			$weekday = date('l', strtotime($strAppointmentDate5)); // note: first arg to date() is lower-case L
			
			$Timebefore45min = date("H:i:s", strtotime("-45 minutes", strtotime($pqr)));
			// echo "Timebefore45min ".$Timebefore45min."<br>";
			
			$dateforsms=FormatDatetime($strAppointmentDate6);
			// echo $dateforsms;
			// die();
			
			$CurrentTime = date('H:i:s');
			$SpanTime = date('H:i:s', strtotime('15 minute'));
			
			// $Timebefore15min = date("H:i:s", strtotime("+15 minutes", strtotime($pqr)));
			// $Timebefore10min = date("H:i:s", strtotime("-10 minutes", strtotime($pqr)));
			// echo "Timebefore15min ".$Timebefore15min."<br>";
			
	
			$categoryselect = $_POST["categoryselect"];
			$qty = $_POST["qty"];
			$memberid = Filter($_POST["memberid"]);
		
			$strStatus = Filter($_POST["Status"]);
			

			$DB = Connect();
			$sql = "SELECT $strMyTableID FROM $strMyTable WHERE $strMyField='$_POST[$strMyField]'";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						<p>The Customer with same Mob. no. is  already exists. Please try again with a different Number.</p>
					</div>
				</div>');
			}
			else
			{
			
				if($qty[0]=="0")
				{
				
					die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						<p>Quantity Cannot Be Blank.</p>
					</div>
				</div>');
				}
				elseif($categoryselect[0]=="0")
				{
					
					die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						<p>Category Cannot Be Blank.</p>
					</div>
				</div>');
				}
				elseif($qty[0]!="0" && $categoryselect[0]!="0")
				{
					$sqlInsert = "INSERT INTO $strMyTable (CustomerFullName, CustomerEmailID, CustomerMobileNo, Status, RegDate,FirstName,LastName,Gender) VALUES 
				('".$strCustomerFullName."', '".$strCustomerEmailID."', '".$strCustomerMobileNo."', '".$strStatus."', NOW(),'".$strFirstName."','".$strLastName."','".$strGender."')";
				// echo $sqlInsert;
				if ($DB->query($sqlInsert) === TRUE) 
				{
					$last_id = $DB->insert_id;		//last id of tblCustomers insert
				}
				else
				{
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			
			/* 	$abc = "SELECT memberid FROM $strMyTable WHERE CustomerID='$last_id'";
				$ghk=date("Y-m-d");
				// echo "<br>";
				$mnp=date("Y-m-d", time()+86400*364); 
				// echo $mnp;
				
				// echo $abc;
				// die();	
					$RS = $DB->query($abc);
					if ($RS->num_rows > 0) 
					{
						while($row = $RS->fetch_assoc())
						{
							$strmemberid = $row["memberid"];
							// echo $strmemberid."<br>";
							$pqr = "INSERT INTO tblCustomerMemberShip (CustomerID, MembershipID, StartDay, EndDay,  Status) VALUES 
								('".$last_id."', '".$strmemberid."', '".$ghk."', '".$mnp."', '0')";
							// echo $pqr."<br>";
							ExecuteNQ($pqr);
						}
					}		 */		
				
				
				// Inserting appointment in tblAppointments
                $selp=select("CustomerID","$strMyTable","CustomerMobileNo='".$strCustomerMobileNo."'");

                if($strAdminRoleID=='36')
				{
				$sqlInsert2 = "INSERT INTO tblAppointments (CustomerID, StoreID, AppointmentDate, SuitableAppointmentTime, Status,FreeService) VALUES 
				('".$last_id."', '".$strStoreID."', '".$strAppointmentDate6."', '".$pqr."', '0','1')";
				}
				elseif($strAdminRoleID=='2')
				{
					$sqlInsert2 = "INSERT INTO tblAppointments (CustomerID, StoreID, AppointmentDate, SuitableAppointmentTime, Status,FreeService) VALUES 
				('".$last_id."', '".$strStoreID."', '".$strAppointmentDate6."', '".$pqr."', '0','1')";
				}
				elseif($strAdminRoleID=='4')
				{
					$sqlInsert2 = "INSERT INTO tblAppointments (CustomerID, StoreID, AppointmentDate, SuitableAppointmentTime, Status,FreeService) VALUES 
				('".$last_id."', '".$strStoreID."', '".$strAppointmentDate6."', '".$pqr."', '0','1')";
				}
				else
				{
						$sqlInsert2 = "INSERT INTO tblAppointments (CustomerID, StoreID, AppointmentDate, SuitableAppointmentTime, Status) VALUES 
				('".$last_id."', '".$strStoreID."', '".$strAppointmentDate6."', '".$pqr."', '0')";
				}
			
				// echo $sqlInsert2;
				// die();
				if ($DB->query($sqlInsert2) === TRUE) 
				{
					$last_id2 = $DB->insert_id;		//last id of tblAppointments insert
				}
				else
				{
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
					
				//Insert Service Cost 
				for($i=0;$i<count($strServicesused);$i++)
				{
					$selpw=select("*","tblServices","ServiceID='".$strServicesused[$i]."'");
					foreach($selpw as $vapt)
					{
						$ServiceID=$vapt['ServiceID'];
						$ServiceCost = $vapt["ServiceCost"];
						
						$sqlInsert3 = "INSERT INTO tblAppointmentsDetails (AppointmentID, ServiceID, ServiceAmount,  Status,qty,employeecategory) VALUES 
							('".$last_id2."', '".$ServiceID."', '".$ServiceCost."', '0','".$qty[$i]."','".$categoryselect[$i]."')";
						//	echo $sqlInsert3;
							if ($DB->query($sqlInsert3) === TRUE) 
							{
								$last_id3 = $DB->insert_id;		//last id of tblAppointments insert
							}
							else
							{
								echo "Error: " . $sql . "<br>" . $conn->error;
							}
							$sqlInsert3p = "INSERT INTO tblAppointmentsDetailsInvoice (AppointmentID, ServiceID, ServiceAmount,Status,qty,employeecategory) VALUES 
									('".$last_id2."', '".$ServiceID."',  '".$ServiceCost."','0','".$qty[$i]."','".$categoryselect[$i]."')";
							if ($DB->query($sqlInsert3p) === TRUE) 
							{
								$last_id7 = $DB->insert_id;		//last id of tblAppointments insert
							}
							else
							{
								echo "Error: " . $sql . "<br>" . $conn->error;
							}
									
							
								$sqlcharges = "Select ChargeNameId , (select GROUP_CONCAT(distinct ChargeSetID) from tblCharges where 
								ChargeNameID=tblServicesCharges.ChargeNameID) as ArrayChargeSet from tblServicesCharges where ServiceID= '".$ServiceID."'";
					//echo $sqlcharges."<br>";
					$charges = $DB->query($sqlcharges);
						if ($charges->num_rows > 0) 
						{
							while($row = $charges->fetch_assoc())
							{
								$ChargeNameId = $row["ChargeNameId"];
								$ArrayChargeSet = $row["ArrayChargeSet"];
								$strChargeSet = explode(",",$ArrayChargeSet);
							}
						}
					}
				
			      
					for($j=0; $j<count($strChargeSet); $j++) 
					{
						$strChargeSetforwork = $strChargeSet[$j];
						$sqlchargeset = "select SetName, ChargeAmt, ChargeFPType from tblChargeSets where ChargeSetID=$strChargeSetforwork";
						
						$RS2 = $DB->query($sqlchargeset);
						if ($RS2->num_rows > 0) 
						{
							while($row2 = $RS2->fetch_assoc())
							{
								$strChargeAmt = $row2["ChargeAmt"];
								$strSetName = $row2["SetName"];
								$strChargeFPType = $row2["ChargeFPType"];
								// Calculation of charges
								$ServiceCost = $ServiceCost;
								if($strChargeFPType == "0")
								{
									$strChargeAmt = $strChargeAmt;
								}
								else
								{
									
									$percentage = $strChargeAmt;
									//echo "percentage=".$percentage."<br/>";
									 $outof = $ServiceCost;
									 //echo "ServiceCost=".$ServiceCost."<br/>";
									$strChargeAmt = ($percentage / 100) * $outof;
								 	 //echo "strChargeAmt=".$strChargeAmt."<br/>";
								
								}
								
									 $totalamt=$strChargeAmt*$qty[$i];
										$sqlInsertcharges = "INSERT INTO tblAppointmentsCharges(AppointmentDetailsID, ChargeName, ChargeAmount,AppointmentID) VALUES 
									('".$last_id3."', '".$strSetName."', '".$totalamt."','".$last_id2."')";
									$sqlInsertcharges."<br/>";
									ExecuteNQ($sqlInsertcharges);
										$sqlInsertchargesd = "INSERT INTO tblAppointmentsChargesInvoice(AppointmentDetailsID, ChargeName, ChargeAmount,AppointmentID,TaxGVANDM) VALUES 
									('".$last_id7."', '".$strSetName."', '".$totalamt."','".$last_id2."','2')";
									$sqlInsertcharges."<br/>";
									ExecuteNQ($sqlInsertchargesd);
							}
						}
						
								
					}
					unset($strChargeSet);
				}
								
									
									
								
								//	exit;
						
						
					
				
				unset($strServicesused);
					unset($strChargeSet);		
					unset($strServicesused);	
					
					
	
			
		
				// Send Email START
				$sql = "SELECT * FROM tblStores WHERE StoreID ='".$strStoreID."'";
				$RSstores = $DB->query($sql);
				if ($RSstores->num_rows > 0) 
				{
					while($rowstores = $RSstores->fetch_assoc())
					{
						$strStoreLocation = $rowstores["StoreName"];
						$strAddress = $rowstores["StoreBillingAddress"];
					}
				}
				else
				{
					
				}
					
				
				$sql = "SELECT ServiceID, EmployeeID FROM tblAppointmentsDetails WHERE AppointmentID ='".$last_id2."'";
				//echo $sql;
				$RS = $DB->query($sql);
				if ($RS->num_rows > 0) 
				{
					while($row = $RS->fetch_assoc())
					{
						$strServices[] = $row["ServiceID"];
						$strEmployee[] = $row["EmployeeID"];
						
					}
				}
				
				$strServicesselected ='<tr>
										<th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Code</th>
										<th width="75%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:left; padding-left:2%;">Item Description</th>
										<th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Amount</th>
									</tr>';
									
				$counterservices = 0;
				
				for($j=0; $j<count($strServices); $j++) 
				{	
					$counterservices++;
					$Servicestaken = $strServices[$j];
					
					$sql2 = "select ServiceName, ServiceCost, ServiceCode from tblServices where ServiceID=$Servicestaken";
				
						$RS2 = $DB->query($sql2);
						if ($RS2->num_rows > 0) 
						{
							while($row2 = $RS2->fetch_assoc())
							{
								$strServiceName = $row2["ServiceName"];
								$strServiceCost = $row2["ServiceCost"];
								$strServiceCode = $row2["ServiceCode"];
								
								$strServi = '<tr> 
								<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">' . $strServiceCode. '</td>
								<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;">' . $strServiceName. '</td>
								<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">' . $strServiceCost. '</td>
								</tr>';
								$strServicesselected .= $strServi;
								$total_price_charges += $strServiceCost;
							}
						}
				}
				
				$strTaxations = "";
				$sqlExtraCharges = "SELECT DISTINCT (ChargeName), SUM( ChargeAmount ) AS Sumarize FROM tblAppointmentsCharges WHERE AppointmentId ='".$last_id2."' GROUP BY ChargeName";
				//echo $sqlExtraCharges;
				$RScharges = $DB->query($sqlExtraCharges);
				if ($RScharges->num_rows > 0) 
				{
					while($rowcharges = $RScharges->fetch_assoc())
					{
						$strChargeNameDetails = $rowcharges["ChargeName"];
						$strChargeAmountDetails = $rowcharges["Sumarize"];
						
						$strChargetotalAmount += $strChargeAmountDetails;
						
						$strTaxationsplus ='<tr>
										  <td width="50%">&nbsp;</td>
										  <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">'.$strChargeNameDetails.'</td>
										  <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;">'.$strChargeAmountDetails.'</td>
										</tr>';
						$strTaxations .= $strTaxationsplus;
						
					}
				}
				
				
				//Query to insert for invoice
				///////////////////////////
				$DB = Connect();
				$sqlInsert = "INSERT INTO  tblInvoice (AppointmentID, EmailMessageID, DateOfCreation) VALUES ('".$last_id2."', 'Null', 'Null')";
				//ExecuteNQ($sqlInsert);
				//echo $sqlInsert;
				if ($DB->query($sqlInsert) === TRUE) 
				{
					$last_id5 = $DB->insert_id;		//last id of tblAppointments insert
				}
				else
				{
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
				
				
				$strTo = $strCustomerEmailID;
				$strFrom = "appnt@nailspaexperience.com";
				$strSubject = "Thank you for booking Appointment at Nailspa Experience";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$Name = $strCustomerFullName;
				//$Email = $strCustomerEmailID;
				//$strAdminPassword = $strAdminPassword;
				//$strDate = date("Y-m-d h:i:s");
				//$StoreAddress = $location;
				$strDate = date("Y-m-d");
				$strTime = $pqr;
				$time_in_12_hour_format  = date("g:i a", strtotime($strTime));
				
				//$sqlInsert = "Insert into tblEmailMessages (AppointmentID, ToEmail, FromEmail, Subject, Body, DateTime, Status) values ('".$last_id2."', '$strTo', '$strFrom', '$strSubject', '$strBody', '$strDate' ,'$strStatus')";
				//ExecuteNQ($sqlInsert);
				//echo $sqlInsert;
				
				
				//	$sql_appointments = select("ID","tblEmailMessages","ToEmail='".$strTo."' AND AppointmentID='".$last_id2."'");
				//$emailmsgid = $sql_appointments[0]['ID'];

				 
				//$sqlUpdate = "UPDATE tblInvoice SET EmailMessageID='".$emailmsgid."' WHERE InvoiceID='".$last_id5."'";
				//ExecuteNQ($sqlUpdate);
				
				$seldata=select("*","tblStores","StoreID='".$strStoreID."'");
				$address=$seldata[0]['StoreOfficialAddress'];
				$storename=$seldata[0]['StoreName'];
			    $branche=explode(",",$storename);
				$branchname=$branche[1]; 
				$path="`http://nailspaexperience.com/images/test2.png`";
				$sep=select("*","tblStores","StoreID='".$storeid."'");
				//$officeaddress=$sep[0]['StoreOfficialAddress'];
                //$servicee=implode(",",$strServicesused);
				$strDate = date("Y-m-d");	
				$message = file_get_contents('EmailFormat/appointment.html');
				$message = eregi_replace("[\]",'',$message);          
				//setup vars to replace
				$vars = array('{Address}','{Name_Detail}','{Date}','{Time}','{Path}','{Branch}'); //Replace varaibles
				$values = array($address,$Name,$strDate,$time_in_12_hour_format,$path,$branchname);
				//replace vars
				$message = str_replace($vars,$values,$message);
				//echo $message;               
				$strBody = $message;             
				$flag='AP';
				$id = $last_id2;
				sendmail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus);
			
				//Start - Insert into tblAppointmentsReminderSMS --Timebefore45min, date,storeID, CustomerId, AppointmentID, Status -asmita
				
				$FindStore="Select StoreID from tblAdminStore where AdminID=$strAdminID";
				// echo $FindStore;
				$RSf = $DB->query($FindStore);
				if ($RSf->num_rows > 0) 
				{
					while($rowf = $RSf->fetch_assoc())
					{
						$strStoreID = $rowf["StoreID"];
						$selectStoreName="Select StoreName from tblStores where StoreId='$strStoreID'";
						$RSstorename = $DB->query($selectStoreName);
							if ($RSstorename->num_rows > 0) 
							{
								while($rowname = $RSstorename->fetch_assoc())
								{
									$StoreName = $rowname["StoreName"];
								}
							}
					}
				}
				
				$SMSContent="Dear Customer Name, your appnt is scheduled for ".$weekday." ".$dateforsms." at ".$strSuitableAppointmentTime." at ".$StoreName.".To reschedule appointment feel.";
				
				$SMSContentforImmediate="Thank you for booking your appnt with Nailspa Experience for ".$weekday." ".$dateforsms." at ".$strSuitableAppointmentTime." at ".$StoreName.".To avoid cancellation charges pls reschedule or cancel appointment 1hr prior appointment";
				
				
				if($pqr>$SpanTime)
				{
					// echo "In if<br>";
					$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime,Status,ContentSMS,SendSMSTo)values('".$last_id2	."','".$strStoreID."','".$last_id."','".$strAppointmentDate6."','".$pqr."','".$Timebefore45min."',0,'".$SMSContent."', '".$strCustomerMobileNo."')";
					// echo $InsertSMSDetails."<br>";
					ExecuteNQ($InsertSMSDetails);
					
					// $InsertSMSDetails="Insert into tblAppointmentsReminderEmail 
					// (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  EmailSendTime,Status,ContentEmail,SendEmailTo, SendCC2, Subject, DateTimeStamp)
					// values
					// ('".$last_id2	."','".$strStoreID."','".$last_id."','".$strAppointmentDate6."','".$pqr."','".$Timebefore45min."',0,'".$SMSContent."', '".$strCustomerEmailID."',0)";
					
						$SendSMS = CreateSMSURL("Appointment Booked","0","0",'$SMSContentforImmediate','$strCustomerMobileNo');
					
					// die();
				}
				else
				{
				
				}
				//End - Insert into tblAppointmentsReminderSMS --Timebefore45min, date,storeID, CustomerId, AppointmentID, Status -asmita	
				//header("appointmail.php?id='".$last_id2."'");
				
				// die();
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">New Customer Added And Appointment Booked</h4>
						<p>New Record Added Successfully.</p>
					</div>
				</div>');
				}
				
			}
		}
		elseif($strStep=="add1")
		{ 
			
			$strFirstName = Filter($_POST["FirstName"]);
			$strLastName = Filter($_POST["LastName"]);
			
			$strCustomerFullName = $strFirstName." ".$strLastName;
			$strCustomerEmailID = Filter($_POST["CustomerEmailID"]);
			$strCustomerMobileNo = Filter($_POST["CustomerMobileNo"]);
			$strStatus = Filter($_POST["Status"]);
			$memberid = Filter($_POST["memberid"]);
		    $strGender = Filter($_POST["Gender"]);

			foreach($_POST as $key => $val)
			{
				if($key!="step")
				{
					if(IsNull($sqlColumn))
					{
						$sqlColumn = $key;
						$sqlColumnValues = "'".$_POST[$key]."'";
					}
					else
					{
						$sqlColumn = $sqlColumn.",".$key;
						$sqlColumnValues = $sqlColumnValues.", '".$_POST[$key]."'";
					}
				}
			}
			
			$DB = Connect();
				$sql = "SELECT $strMyTableID FROM $strMyTable WHERE $strMyField='$_POST[$strMyField]'";
				$RS = $DB->query($sql);
				if ($RS->num_rows > 0) 
				{
					$DB->close();
					die('<div class="alert alert-close alert-danger">
						<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
						<div class="alert-content">
							<h4 class="alert-title">Record Add Failed</h4>
							<p>The Customer with same Mob. no. is  already exists. Please try again with a different Number.</p>
						</div>
					</div>');
				}
				else
				{
									
					$sqlInsert = "INSERT INTO $strMyTable (FirstName, LastName, CustomerFullName, CustomerEmailID, CustomerMobileNo, Status,RegDate,Gender) VALUES 
					('".$strFirstName."', '".$strLastName."', '".$strCustomerFullName."', '".$strCustomerEmailID."', '".$strCustomerMobileNo."', '".$strStatus."',NOW(),'".$strGender."')";
					// echo $sqlInsert."<br>";
					if ($DB->query($sqlInsert) === TRUE) 
					{
						$last_id = $DB->insert_id;		//last id of tblCustomers insert
					}
					else
					{
						echo "Error: " . $sql . "<br>" . $conn->error;
					}
					/* $abc = "SELECT memberid FROM $strMyTable WHERE CustomerID='$last_id'";
					$ghk=date("Y-m-d");
					// echo "<br>";
					$mnp=date("Y-m-d", time()+86400*364); 
					// echo $mnp;
					
					// echo $abc;
					// die();	
					$RS = $DB->query($abc);
					if ($RS->num_rows > 0) 
					{
						while($row = $RS->fetch_assoc())
						{
							$strmemberid = $row["memberid"];
							// echo $strmemberid."<br>";
							$pqr = "INSERT INTO tblCustomerMemberShip (CustomerID, MembershipID, StartDay, EndDay,  Status) VALUES 
								('".$last_id."', '".$strmemberid."', '".$ghk."', '".$mnp."', '0')";
							// echo $pqr."<br>";
							ExecuteNQ($pqr);
						}
					}		 */

				
					
					die('<div class="alert alert-close alert-success">
							<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
							<div class="alert-content">
								<h4 class="alert-title">Record Saved Successfully</h4>
							</div>
						</div>');
					
					
			}
		}
		elseif($strStep=="edit")
		{
			$DB = Connect();
			
			$strstartDayaab=$_POST['StartDay1'];
		    $strEndDayabc=$_POST['EndtDay1'];
			$strmembershipIDabc = $_POST['memberid'];
			
			foreach($_POST as $key => $val)
			{
				if($key=="step" || $key==$strMyTableID)
				{
				
				}
				else
				{
					$sqlUpdate = "UPDATE $strMyTable SET $key='$_POST[$key]' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					//echo $sqlUpdate;
					ExecuteNQ($sqlUpdate);
					$KML="UPDATE tblCustomerMemberShip SET MembershipID='".$strmembershipIDabc."' WHERE CustomerID='".Decode($_POST[$strMyTableID])."'";
					ExecuteNQ($KML);
					
					
				}
			}
			$DB->close();
			die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Updated Successfully</h4>
					</div>
				</div>');
		}
		die();
	}
if(isset($_GET['cid']))
{
	$DB = Connect();

		
//	echo $strAdminType;
		
		$seldata=select("*","tblAdminRoles","RoleName='Master Administator'");
	
			if($seldata[0]['RoleID']=='36')
			{
				//echo 134;
				$custid=$_GET['cid'];
		
				//echo 678;
				$seldatap=select("AppointmentID","tblAppointments","CustomerID='".$custid."'");
				if($seldatap!="")
				{
					foreach($seldatap as $vq)
					{
						$sqlInsert = "INSERT INTO tblAppointments_backup (CustomerID, StoreID,AppointmentDate,SuitableAppointmentTime,AppointmentCheckInTime,AppointmentCheckOutTime,AppointmentOfferID,Status,memberid) VALUES 
						('".$vq['CustomerID']."', '".$vq['StoreID']."', '".$vq['AppointmentDate']."','".$vq['SuitableAppointmentTime']."','".$vq['AppointmentCheckInTime']."','".$vq['AppointmentCheckOutTime']."','".$vq['AppointmentOfferID']."','".$vq['Status']."','".$vq['memberid']."')";
						$DB->query($sqlInsert);
						//	ExecuteNQ($sqlInsert);
						/////////////////////////////////
			
						$seldatapt=select("*","tblAppointmentsDetailsInvoice","AppointmentID='".$vq['AppointmentID']."'");
						foreach($seldatapt as $vatt)
						{
							$sqlInsert2 = "INSERT INTO tblAppointmentsDetailsInvoice_backup (AppointmentID, ServiceID, MECID, ServiceByEmployee,ServiceAmount,Status,employeecategory,qty) VALUES 
							('".$vatt['AppointmentID']."', '".$vatt['ServiceID']."', '".$vatt['MECID']."', '".$vatt['ServiceByEmployee']."','".$vatt['ServiceAmount']."','".$vatt['Status']."','".$vatt['employeecategory']."','".$vatt['qty']."')";

							$DB->query($sqlInsert2);
							$sqlp="delete from tblAppointmentsDetailsInvoice where AppointmentID='".$vq['AppointmentID']."'";
							//	echo $sqlp;
			
							$DB->query($sqlp);
						}
						/////////////////////////////////////////////////
			
						$seldataptp=select("*","tblAppointmentsDetails","AppointmentID='".$vq['AppointmentID']."'");
						foreach($seldataptp as $vattp)
						{
							$sqlInsert3 = "INSERT INTO tblAppointmentsDetails_backup (AppointmentID, ServiceID, MECID, ServiceByEmployee,ServiceAmount,Status,employeecategory,qty) VALUES 
							('".$vattp['AppointmentID']."', '".$vattp['ServiceID']."', '".$vattp['MECID']."', '".$vattp['ServiceByEmployee']."','".$vattp['ServiceAmount']."','".$vattp['Status']."','".$vattp['employeecategory']."','".$vattp['qty']."')";
							// $DB->query($sqlInsert3);
							ExecuteNQ($sqlInsert3);
							// echo $sqlInsert3."<br>";
							// die();
			
							$sqlpt="delete from  tblAppointmentsDetails where AppointmentID='".$vq['AppointmentID']."'";
							//echo $sql;
							$DB->query($sqlpt);
							$sqlpq="delete from tblAppointments where AppointmentID='".$vq['AppointmentID']."'";
							//echo $sqlpq;
							$DB->query($sqlpq);
							$sqlpr="delete from tblAppointmentsCharges where AppointmentID='".$vq['AppointmentID']."'";
							// echo $sqlpq;
							$DB->query($sqlpr);
						}
						
			
						/////////////////////////////////////
				
			
						//ExecuteNQ($sqlpq);
			
						$sqt=select("*","$strMyTable","CustomerID='".$custid."'");
				
						$sqlInsert = "INSERT INTO tblCustomers_backup (CustomerFullName, CustomerEmailID, CustomerMobileNo, Status) VALUES 
						('".$sqt[0]['CustomerFullName']."', '".$sqt[0]['CustomerEmailID']."', '".$sqt[0]['CustomerMobileNo']."', '".$sqt[0]['Status']."')";
						ExecuteNQ($sqlInsert);
						$DB->query($sqlInsert);
				
						$sql11="delete from tblCustomers where CustomerID='".$custid."'";
						//echo $sql11;
						ExecuteNQ($sql11);
						$DB->query($sql11);
					}
					$msg="Deleted Customer Successfully";
				}
				else
				{
					//echo 1235;
					$sqt=select("*","$strMyTable","CustomerID='".$custid."'");
					$sqlInsert = "INSERT INTO tblCustomers_backup (CustomerFullName, CustomerEmailID, CustomerMobileNo, Status) VALUES 
					('".$sqt[0]['CustomerFullName']."', '".$sqt[0]['CustomerEmailID']."', '".$sqt[0]['CustomerMobileNo']."', '".$sqt[0]['Status']."')";
					// echo $sqlInsert;
					// ExecuteNQ($sqlInsert);
					$DB->query($sqlInsert);
				
					$sql11="delete from tblCustomers where CustomerID='".$custid."'";
					// echo $sql11;
					// ExecuteNQ($sql11);
					$DB->query($sql11);
					$msg="Deleted Customer Successfully";
					// die();
				}
			}
			else
			{
				//echo 124;
				$msg="You Dont have Right to Delete Any Customer";
			}
	
	// echo $msg;
	// exit;
		$DB->close();
		header('Location:ManageCustomers.php?msg='.$msg.'');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	<script type="text/javascript" src="assets/widgets/datepicker/datepicker.js"></script>
                    <script type="text/javascript">
                        /* Datepicker bootstrap */
                  $(function() {
                            "use strict";
                            $('.bootstrap-datepicker').bsdatepicker({
                                format: 'yyyy-mm-dd'
                            });
                        });
                    </script>
                    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker.js"></script>
                    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker-demo.js"></script>
                    <script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>
                    <script type="text/javascript" src="assets/widgets/timepicker/timepicker.js"></script>
                    <script type="text/javascript">
                        /* Timepicker */

                        $(function() {
                            "use strict";
                            $('.timepicker-example').timepicker();
                        });
                    </script>
					<script>
						$(function ()						
						{
							$("#StartDay").datepicker({ minDate: 0 });
							$("#EndtDay").datepicker({ minDate: 0 });
							$("#StartDay1").datepicker({ minDate: 0 });
							$("#EndtDay1").datepicker({ minDate: 0 });
							
						});
					</script>	
	<script>
	$(document).ready(function(){
/* 	$(".deleteq").click(function(){
	//alert(134)
	var uid=$("#uidd").val();
	//alert(uid)
	$.ajax({
	type:"post",
	data:"uid="+uid,
	url:"delete_customer.php",
	success:function(result)
	{
	//alert(result)
	if(result==1)
	{
		alert('You Cannot Delete This Customer')
	}
	else
	{
		alert(result)
	}
	}
	
	});
	
	}); */
	});
	function LoadValue(OptionValue)
            {                
				// alert (OptionValue);
				$.ajax({
					type: 'POST',
					url: "GetServicesStoreWise.php",
					data: {
						id:OptionValue
					},
					success: function(response) {
					//	alert(response)
						$("#asmita").html("");
						$("#asmita1").html("");
						$("#asmita").html(response);
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$("#asmita").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						alert (response);
					}
				});
            }
	function LoadValueasmita()
	{
		
		valuable=[];
		var valuable = $('#Services').val();
		var store = $('#StoreID').val();
		
		//alert(store)
				 $.ajax({
					type: 'POST',
					url: "servicedetail.php",
					data: {
						id:valuable,
						stored:store
					},
					success: function(response) {
						//alert(response)
						$("#asmita1").html("");
						$("#asmita1").html(response);
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$("#asmita1").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						//alert (response);
					}
				}); 
	}
</script>
<script>
		
	$(function () {
    $("#AppointmentDate").datepicker({ minDate: 0 });
	 $("#AppointmentDate").datepicker({ minDate: 0 });
	  
});
</script>


<script language=JavaScript>
    var message = "Please dont try this as we are keeping a track of who is trying this!";

    function clickIE4() {
        if (event.button == 2) {
            alert(message);
            return false;
        }
    }

    function clickNS4(e) {
        if (document.layers || document.getElementById && !document.all) {
            if (e.which == 2 || e.which == 3) {
                alert(message);
                return false;
            }
        }
    }
    if (document.layers) {
        document.captureEvents(Event.MOUSEDOWN);
        document.onmousedown = clickNS4;
    } else if (document.all && !document.getElementById) {
        document.onmousedown = clickIE4;
    }
    document.oncontextmenu = new Function("alert(message);return false")
</script>

<script>
jQuery(document).ready(function($){
    $(document).keydown(function(event) { 
        var pressedKey = String.fromCharCode(event.keyCode).toLowerCase();
        
        if (event.ctrlKey && (pressedKey == "c" || pressedKey == "u" || pressedKey == "v" || pressedKey == "a" || pressedKey == "s")) {
            alert('Sorry, This Functionality Has Been Disabled For Security Reasons!'); 
            //disable key press porcessing
            return false; 
        }
    });
});

$(document).keyup(function(e){
  if(e.keyCode == 44) return false;
});

</script>

</head>

<body  style="-webkit-touch-callout: none;
-webkit-user-select: none;
-khtml-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
user-select: none;" 
 unselectable="on"
 onselectstart="return false;" ondragstart="return false;">
 
    <div id="sb-site">
        
		<?php require_once("incOpenLayout.fya"); ?>
		
		
        <?php require_once("incLoader.fya"); ?>
		
        <div id="page-wrapper">
            <div id="mobile-navigation"><button id="nav-toggle" class="collapsed" data-toggle="collapse" data-target="#page-sidebar"><span></span></button></div>
            
				<?php require_once("incLeftMenu.fya"); ?>
			
            <div id="page-content-wrapper">
                <div id="page-content">
                    
					<?php require_once("incHeader.fya"); ?>
					

                    <div id="page-title">
                        <h2><?=$strDisplayTitle?></h2>
                        <p>Add, Edit, Delete Customers</p>
                    </div>
<?php
if(!isset($_GET["uid"]))
{
?>					
					
                    <div class="panel">
						<div class="panel">
							<div class="panel-body">
								
								<div class="example-box-wrapper">
									<div class="tabs">
										<ul>
											<li><a href="#normal-tabs-1" title="Tab 1">Manage</a></li>
											<li><a href="#normal-tabs-2" title="Tab 2">Add Customer and Assign Appointment</a></li>
											<li><a href="#normal-tabs-3" title="Tab 3">Add Customer</a></li>
											<li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">Add Bulk Data</a></li>
										</ul>
										<div id="normal-tabs-1">
												<span class="form_result">&nbsp; <br></span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Customers | Nailspa</h3>
												<div class="example-box-wrapper">
														<a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=A">
															<div class="ripple-wrapper">A
															</div>
														</a>&nbsp;
													   <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=B">
															<div class="ripple-wrapper">B
															</div>
														</a>&nbsp;
														  <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=C">
															<div class="ripple-wrapper">C
															</div>
														</a>&nbsp;
														  <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=D">
															<div class="ripple-wrapper">D
															</div>
														</a>&nbsp;
														  <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=E">
															<div class="ripple-wrapper">E
															</div>
														</a>&nbsp;
														  <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=E">
															<div class="ripple-wrapper">E
															</div>
														</a>&nbsp;
														  <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=F">
															<div class="ripple-wrapper">F
															</div>
														</a>&nbsp;
														  <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=G">
															<div class="ripple-wrapper">G
															</div>
														</a>&nbsp;
														  <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=H">
															<div class="ripple-wrapper">H
															</div>
														</a>&nbsp;
														  <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=I">
															<div class="ripple-wrapper">I
															</div>
														</a>&nbsp;
														  <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=J">
															<div class="ripple-wrapper">J
															</div>
														</a>&nbsp;
														  <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=K">
															<div class="ripple-wrapper">K
															</div>
														</a>&nbsp;
														  <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=L">
															<div class="ripple-wrapper">L
															</div>
														</a>&nbsp;
														  <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=M">
															<div class="ripple-wrapper">M
															</div>
														</a>&nbsp;
														  <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=N">
															<div class="ripple-wrapper">N
															</div>
														</a>&nbsp;
														 <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=O">
															<div class="ripple-wrapper">O
															</div>
														</a>&nbsp;
														 <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=P">
															<div class="ripple-wrapper">P
															</div>
														</a>&nbsp;
														 <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=Q">
															<div class="ripple-wrapper">Q
															</div>
														</a>&nbsp;
														 <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=R">
															<div class="ripple-wrapper">R
															</div>
														</a>&nbsp;
														 <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=S">
															<div class="ripple-wrapper">S
															</div>
														</a>&nbsp;
														 <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=T">
															<div class="ripple-wrapper">T
															</div>
														</a>&nbsp;
														 <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=U">
															<div class="ripple-wrapper">U
															</div>
														</a>&nbsp;
														 <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=V">
															<div class="ripple-wrapper">V
															</div>
														</a>&nbsp;
														 <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=W">
															<div class="ripple-wrapper">W
															</div>
														</a>&nbsp;
														 <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=X">
															<div class="ripple-wrapper">X
															</div>
														</a>&nbsp;
														 <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=Y">
															<div class="ripple-wrapper">Y
															</div>
														</a>&nbsp;
														 <a class="btn btn-round btn-default" href="TryJsonManageCustomers.php?Cust_type=Z">
															<div class="ripple-wrapper">Z
															</div>
														</a>&nbsp;
												
												<?php
													if(isset($_GET["Cust_type"]))
													{
													// Database count
													$sep = select("count(*)"," tblCustomers","Status='0'");
 
													$cnt=$sep[0]['count(*)'];
													   
													$json_string = file_get_contents(FindHostAdmin()."/jsonCustomer/jsondata/CustomersData.json");
													$parsed_json = json_decode($json_string, true);
							
													if($strStore=="" || $strStore=="0")
													{
														echo "<br><center><h4>". count($parsed_json). " Total customers on cloud</h4></center>";
														echo "<br><center><h4>". $cnt. " Total customers in Database</h4></center>";
													}
													else
													{
														
													}
													
													$array1= array_multi_search($parsed_json, 'FirstName', '/^'.$_GET["Cust_type"].'/i'); 
													$array2= array_multi_search2($parsed_json, 'LastName', '/^'.$_GET["Cust_type"].'/i');

													$finalarray = array_merge($array1, $array2);
													
													//echo "<br><center><h4>". count($finalarray). " Data Found for <b>".$_GET["Cust_type"]."</b></h4></center>";
												?>
												
												<script>
												function syncCustomerData()
													{
														$.ajax({
															type:"post",
															data:"",
															url:"jsonCustomer/syncCutomers.php",
															success:function(result)
															{

																if($.trim(result)=='json file for Cutomers synced successfully')
																{
																	$("#saifusmanidon").html("<center><font color='red'><b>Sync Successful</b></font></center>");
																	location.reload();
																}
																else
																{
																	$("#saifusmanidon").html("<center><font color='red'><b>System finding difficulties in sync! Please try again after some time</b></font></center>");
																}
															}
															
															
														})
													}
												</script>
												
												
												<?php
													if($cnt==count($parsed_json))
													{
														echo "<br><center><h4>Software is synced with cloud !</h4></center>";
													}
													else
													{
														echo "<br><center><h4><font color='red'>Sync Suggested to get customers added today !</font></h4></center>";
												?>	
														<center><span id="saifusmanidon"><a class="btn btn-link"  href="#" onclick="syncCustomerData()">Sync System with Cloud</a></span></center>
														<span id="saifffff">&nbsp;</span>
												<?php
													}
												?>	
												
												
											<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Full Name</th>
																<th>Email ID</th>
																<th>Mobile No.</th>
																<th>Gender</th>
																<th>Membership</th>
																<th>Appointments</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Full Name</th>
																<th>Email ID</th>
																<th>Mobile No.</th>
																<th>Gender</th>
																<th>Membership</th>
																<th>Appointments</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>
															
													
																<?php
																	$counter = "";
																	foreach ($finalarray as $key => $value) 
																	{
																		$counter = $counter + 1;
																		echo '<tr>';
																		echo '<td>' . $counter . '</td>';
																		if (!is_array($value)) 
																		{
																			echo $key . ' :' . $value . '</b><br/>';
																		} 
																		else 
																		{
																			foreach ($value as $key => $val) 
																			{
																				if($key=="CustomerFullName")
																				{
																					echo '<td>' . $val . '</td>';
																				}
																				elseif($key=="CustomerEmailID")
																				{
																					echo '<td>' . $val . '</td>';
																				}
																				elseif($key=="CustomerMobileNo")
																				{
																					echo '<td>' . $val . '</td>';
																				}
																				elseif($key=="Gender")
																				{
																					if($val=="1")
																					{
																						echo '<td>Female</td>';
																					}
																					else
																					{
																						echo '<td>Male</td>';
																					}
																					
																				}
																				elseif($key=="memberid")
																				{
																					if($val=="1")
																					{
																						echo '<td>Gold</td>';
																					}
																					elseif($val=="2")
																					{
																						echo '<td>Silver</td>';
																					}
																					else
																					{
																						echo '<td> - </td>';
																					}
																				}
																				elseif($key=="CustomerID")
																				{
																					$EncodedID = EncodeQ($val);
																				}
																				else
																				{

																				}
																			}
																			?>
																			<td><center><a class="btn btn-link font-blue" href="ManageAppointments.php?bid=<?=$EncodedID?>">Book Appointment</a></center></td>
																			<td><center><a class="btn btn-link font-blue" href="ManageCustomers.php?uid=<?=$EncodedID?>">Edit Data</a></center></td>
																			<?php
																		}
																		
																		echo '</tr>';
																	}
																?>
																
													
														
														</tbody>
													</table>
													
													<?php
													}
													else
													{
														echo "<br><center><h4>Please Select Alphabet Filter</h4></center>";
													}
													?>
													
												</div>
											</div>
										</div>
			
										
										<div id="normal-tabs-2">
											<div class="panel-body">
												<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" id="step" name="step" value="assign">

											
												<h3 class="title-hero">Add and Assign Appointment for Customers</h3>
												<div class="example-box-wrapper">
													
<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SHOW COLUMNS FROM ".$strMyTable." ";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{
		if($row["Field"]==$strMyTableID)
		{
		}
		else if ($row["Field"]=="CustomerFullName")
		{
?>	
													<!--<div class="form-group"><label class="col-sm-3 control-label"><?//=str_replace("CustomerFullName", "Full Name", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?//=$row["Field"]?>" id="<?//=str_replace("CustomerFullName", "Full Name", $row["Field"])?>" class="form-control required" placeholder="<?//=str_replace("CustomerFullName", "Full Name", $row["Field"])?>"></div>
													</div>-->
<?php
		}
		else if ($row["Field"]=="CustomerEmailID")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="RegDate")
		{
?>	
<?php
		}
		else if ($row["Field"]=="MembershipDateTime")
		{
?>	
																										
<?
		}
		else if($row["Field"]=="TotalVisits")
		{
			
		}
		elseif($row["Field"]=="CustomerFullName")
		{
			
		}	
		else if($row["Field"]=="LastVisit")
		{
			
		}
		else if ($row["Field"]=="CustomerMobileNo")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerMobileNo", "Mobile No.", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" pattern="[0-9]{10}" title="Enter a valid mobile number!" name="<?=$row["Field"]?>" id="<?=str_replace("CustomerMobileNo", "Mobile No.", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("CustomerMobileNo", "Mobile No.", $row["Field"])?>"></div>
													</div>
<?
		}
		else if($row["Field"]=="memberid")
		{

			
		}
		else if($row["Field"]=="memberflag")
		{

			
		}
		else if($row["Field"]=="LastLogin")
		{

			
		}
		else if($row["Field"]=="Password")
		{

			
		}
		else if($row["Field"]=="Gender")
		{
?>
              <div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Gender", "Gender", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3">
														<input type="radio" name="Gender"  value="0" id="Gender" checked /><b>Male</b>&nbsp;&nbsp;&nbsp;&nbsp;
														<input type="radio" name="Gender"  value="1" id="Gender" /><b>Female</b>&nbsp;&nbsp;&nbsp;&nbsp;
														</div>
													</div>
													<?php
			
			
			
		}
		
		else if ($row["Field"]=="Status")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", "Status", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3">
															<select name="<?=$row["Field"]?>" class="form-control required">
																<option value="0" Selected>Live</option>
																<option value="1">Offline</option>	
															</select>
														</div>
													</div>
<?php	
		}
		else
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Admin", " ", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Admin", " ", $row["Field"])?>"></div>
													</div>
<?php
		}
	}
	// Fields from tblAppointments Table
			
			$sql1 = "SELECT StoreID, StoreName FROM tblStores WHERE Status = 0";
			$RS2 = $DB->query($sql1);
			if ($RS2->num_rows > 0)
			{
?>
														<div class="form-group"><label class="col-sm-3 control-label">Appointment at<span>*</span></label>
															<div class="col-sm-3">
															<select class="form-control required"  id="StoreID" onChange="LoadValue(this.value);" name="StoreID" >
																<option value="" selected>-- Select Store --</option>
<?
																	while($row2 = $RS2->fetch_assoc())
																	{
																		$StoreID = $row2["StoreID"];
																		$StoreName = $row2["StoreName"];	
?>	
																		<option value="<?=$StoreID?>"><?=$StoreName?></option>
<?php
																	}
?>
															</select>
															</div>
														</div>	
<?php
			}
?>
															
																<span id="asmita">
				
																</span>
															
														<span id="asmita1">
		
														</span>
														<div class="form-group"><label class="col-sm-3 control-label">Appointment Date <span>*</span></label>
															<div class="col-sm-3">
																<!--<span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span> <input type="text" name="AppointmentDate" id="AppointmentDate" class="bootstrap-datepicker form-control required" value="02/16/12" data-date-format="yy/mm/dd">-->
																
																 <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span> <input type="text" name="AppointmentDate" id="AppointmentDate"  class="form-control" data-date-format="dd/mm/yy" value="<?php echo date('d-m-y');?>"></div>
															</div>
														</div>	

														<div class="form-group"><label class="col-sm-3 control-label">Suitable Time <span>*</span></label>
															<div class="col-sm-3">
																<input type="text" name="SuitableAppointmentTime" id="SuitableAppointmentTime" class="form-control required timepicker-example" data-time-format="h:i %p">
															</div>
														</div>		

														<div class="form-group">
															<label class="col-sm-3 control-label"></label>
															<input type="submit" class="btn ra-100 btn-primary" value="Submit">
															<div class="col-sm-1">
																<a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a>
															</div>
														</div>
<?php
}
$DB->close();
?>													
												</div>
												</form>
											</div>
										</div>
	<!--Tab 3 started-->									
										<div id="normal-tabs-3">
											<div class="panel-body">
												<form role="form" class="form-horizontal bordered-row enquiry_form2" onSubmit="proceed_formsubmit('.enquiry_form2', '<?=$strMyActionPage?>', '.result_message1', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											
											<input type="hidden" id="step" name="step" value="add1">
	
											
												<h3 class="title-hero">Add Customers</h3>
												<div class="example-box-wrapper">
												<script>
						$(function() {
                            "use strict";
                            $('.bootstrap-datepicker').bsdatepicker({
                                format: 'yyyy-mm-dd'
                            });
                        });
						$(function ()						
						{
							$("#OfferDateFrom").datepicker({ minDate: 0 });
							$("#OfferDateTo").datepicker({ minDate: 0 });
							$("#StartDay1").datepicker({ minDate: 0 });
							$("#EndtDay1").datepicker({ minDate: 0 });
							
						});
					</script>	
													
<?php
//echo "this is my piece of code";
//echo 124556;
// Create connection And Write Values
$DB = Connect();
$sql = "SHOW COLUMNS FROM tblCustomers";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{
		if($row["Field"]==$strMyTableID)
		{
		}
		else if ($row["Field"]=="CustomerFullName")
		{
?>	
										

<?php
		}
		else if ($row["Field"]=="FirstName")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?>"></div>
													</div>	
<?php
		}
		else if ($row["Field"]=="LastName")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?>"></div>
													</div>														
													
<?php
		}
		else if ($row["Field"]=="CustomerEmailID")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?>"></div>
													</div>
<?
		}
		else if ($row["Field"]=="CustomerMobileNo")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerMobileNo", "Mobile No.", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" pattern="[0-9]{10}" title="Enter a valid mobile number!" name="<?=$row["Field"]?>" id="<?=str_replace("CustomerMobileNo", "Mobile No.", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("CustomerMobileNo", "Mobile No.", $row["Field"])?>"></div>
													</div>
<?
		}
		else if($row["Field"]=="memberid")
		{
			
		}
		else if($row["Field"]=="memberflag")
		{
			
		}
		else if($row["Field"]=="LastLogin")
		{

			
		}
		else if($row["Field"]=="Password")
		{

			
		}
		else if($row["Field"]=="TotalVisits")
		{

			
		}
		else if($row["Field"]=="LastVisit")
		{

			
		}
		else if($row["Field"]=="Gender")
		{
?>
              <div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Gender", "Gender", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3">
														<input type="radio" name="Gender"  value="0" id="Gender" checked /><b>Male</b>&nbsp;&nbsp;&nbsp;&nbsp;
														<input type="radio" name="Gender"  value="1" id="Gender" /><b>Female</b>&nbsp;&nbsp;&nbsp;&nbsp;
														</div>
													</div>
													<?php
			
		}
		else if($row["Field"]=="MembershipDateTime")
		{

			
		}
		else if($row["Field"]=="RegDate")
		{

			
		}
		else if ($row["Field"]=="Status")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", "Status", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3">
															<select name="<?=$row["Field"]?>" class="form-control required">
																<option value="0" Selected>Live</option>
																<option value="1">Offline</option>	
															</select>
														</div>
													</div>
<?php	
		}
		else
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Admin", " ", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Admin", " ", $row["Field"])?>"></div>
														</div>
<?php
		}
	}
	
			
?>
														<div class="form-group">
															<label class="col-sm-3 control-label"></label>
																<input type="submit" class="btn ra-100 btn-primary" value="Submit">
															<div class="col-sm-1">
																<a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form1');" title="Clear"><span>Clear</span></a>
															</div>
														</div>
<?php
}
$DB->close();
?>													
												</div>
												</form>
											</div>
										</div>
	<!--Tab 3 end-->									
										<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="data-tab">
									
											<?php require_once "ExcelBulkUpload2.php"; ?>
									
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
<?php
} // End null condition


//-----------------Normal Edit

else
{
?>						
					<div class="panel">
						<div class="panel-body">
							<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="<?=$strMyActionPage?>"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
						
							<div class="panel-body">
							<form role="form" class="form-horizontal bordered-row enquiry_form1" onSubmit="proceed_formsubmit('.enquiry_form1', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email', '.admin_password'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" id="step" name="step" value="edit">

								
									<h3 class="title-hero">Edit Customers</h3>
									<div class="example-box-wrapper">
<?php
$strID = DecodeQ(Filter($_GET["uid"]));
// echo $strID."<br>";
$DB = Connect();
$sql = "SELECT * FROM ".$strMyTable." WHERE $strMyTableID = '$strID'";

$sepd=select("*","tblCustomerMemberShip","CustomerID='".$strID."'");
$memstart=$sepd[0]['StartDay'];
$memend=$sepd[0]['EndDay'];
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	while($row = $RS->fetch_assoc())
	{
		foreach($row as $key => $val)
		{
			if($key==$strMyTableID)
			{
?>
											<input type="hidden" name="<?=$key?>" value="<?=Encode($strID)?>">	

<?php
			}
			elseif($key=="CustomerFullName")
			{
	}
			elseif($key=="CustomerEmailID")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerEmailID", "Email ID", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("CustomerEmailID", "Email ID", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="CustomerMobileNo")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerMobileNo", "Mobile No.", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" pattern="[0-9]{10}" title="Enter a valid mobile number!" class="form-control required" placeholder="<?=str_replace("CustomerMobileNo", "Mobile No.", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="memberid")
			{

			}
			elseif($key=="LastLogin")
			{

			}
			elseif($key=="Password")
			{

			}
			elseif($key=="LastVisit")
			{

			}
			elseif($key=="CustomerFullName")
			{

			}

			elseif($key=="Gender")
			{
?>
              <div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Gender", "Gender", $key)?> <span>*</span></label>
														<div class="col-sm-3">
														<?php
														if($row[$key]=='0')
														{
															?>
															
																<input type="radio" name="<?= $key?>"  value="0" id="<?= $key?>" checked /><b>Male</b>&nbsp;&nbsp;&nbsp;&nbsp;
																<input type="radio" name="<?= $key?>"  value="1" id="<?= $key?>" /><b>Female</b>&nbsp;&nbsp;&nbsp;&nbsp;
																<?php
														}
														else
														{
															?>
															<input type="radio" name="<?= $key?>"  value="0" id="<?= $key?>"  /><b>Male</b>&nbsp;&nbsp;&nbsp;&nbsp;
															<input type="radio" name="<?= $key?>"  value="1" id="<?= $key?>" checked /><b>Female</b>&nbsp;&nbsp;&nbsp;&nbsp;
															<?php
														}
														?>
													
														
														</div>
													</div>
													<?php
			}
			else if($key=="TotalVisits")
			{
				
			}
			else if($key=="LastVisit")
			{
				
			}
		    else if($key=="MembershipDateTime")
			{
				
			}
			 else if($key=="RegDate")
			{
				
			}
			 else if($key=="memberflag")
			{
				
			}
			elseif($key=="Status")
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $key)?> <span>*</span></label>
												<div class="col-sm-2">
													<select name="<?=$key?>" class="form-control required">
														<?php
															if ($row[$key]=="0")
															{
														?>
																<option value="0" selected>Live</option>
																<option value="1">Offline</option>
														<?php
															}
															elseif ($row[$key]=="1")
															{
														?>
																<option value="0">Live</option>
																<option value="1" selected>Offline</option>
														<?php
															}
															else
															{
														?>
																<option value="" selected>--Choose option--</option>
																<option value="0">Live</option>
																<option value="1">Offline</option>
														<?php
															}
														?>	
													</select>
												</div>
											</div>
<?php	
			}
			else
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Admin", " ", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
		}
	}
?>
											<div class="form-group"><label class="col-sm-3 control-label"></label>
												<input type="submit" class="btn ra-100 btn-primary" value="Update">
												
												<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form1');" title="Clear"><span>Clear</span></a></div>
											</div>
<?php
}
$DB->close();
?>													
										
									</div>
							</form>
							</div>
						</div>
                   </div>			
<?php
}
?>	
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Page generated in '.$total_time.' seconds.';
?>                   
                </div>
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>

