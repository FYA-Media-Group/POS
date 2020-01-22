<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Manage Appointments | NailSpa";
	$strDisplayTitle = "Manage Appointments for NailSpa";
	$strMenuID = "10";
	$strMyTable = "tblAppointments";
	$strMyTableID = "AppointmentID";
	$strMyField = "AppointmentDate";
	$strMyActionPage = "ManageAppointments.php";
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
		$strStep = Filter($_POST["step"]);
		
		if($strStep=="add")
		{
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
			$strCustomerID = Filter($_POST["CustomerID"]);
			$strStoreID = Filter($_POST["StoreID"]);
			$strAppointmentDate = Filter($_POST["AppointmentDate"]);
			// echo $strAppointmentDate."<br>";
			
			$strSuitableAppointmentTime = Filter($_POST["SuitableAppointmentTime"]);
			$strAppointmentCheckInTime = Filter($_POST["AppointmentCheckInTime"]);
			$strAppointmentCheckOutTime = Filter($_POST["AppointmentCheckOutTime"]);
			$strAppointmentOfferID = Filter($_POST["AppointmentOfferID"]);
			$strStatus = Filter($_POST["Status"]);


			$DB = Connect();
			$sql = "Select $strMyTableID from $strMyTable where $strMyField='$_POST[$strMyField]'";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						<p>Appointment Already Booked!</p>
					</div>
				</div>');
			}
			else
			{
				$Type_Service = Filter($_POST["Type_Service"]);
				
                if(!empty($Type_Service))
				{
					if($Type_Service=='0')
					{
						$sqlInsert = "INSERT INTO $strMyTable (CustomerID, StoreID, AppointmentDate, SuitableAppointmentTime, AppointmentCheckInTime, AppointmentCheckOutTime, AppointmentOfferID, Status,FreeService) VALUES 
				('".$strCustomerID."', '".$strStoreID."', '".$strAppointmentDate."', '".$strSuitableAppointmentTime."', '".$strAppointmentCheckInTime."', '".$strAppointmentCheckOutTime."', '".$strAppointmentOfferID."', '".$strStatus."','0')";
				
					}
					else
					{
                 $sqlInsert = "INSERT INTO $strMyTable (CustomerID, StoreID, AppointmentDate, SuitableAppointmentTime, AppointmentCheckInTime, AppointmentCheckOutTime, AppointmentOfferID, Status,FreeService) VALUES 
				('".$strCustomerID."', '".$strStoreID."', '".$strAppointmentDate."', '".$strSuitableAppointmentTime."', '".$strAppointmentCheckInTime."', '".$strAppointmentCheckOutTime."', '".$strAppointmentOfferID."', '".$strStatus."','1')";
				
                    }
				}
				else
				{
					$sqlInsert = "INSERT INTO $strMyTable (CustomerID, StoreID, AppointmentDate, SuitableAppointmentTime, AppointmentCheckInTime, AppointmentCheckOutTime, AppointmentOfferID, Status) VALUES 
				('".$strCustomerID."', '".$strStoreID."', '".$strAppointmentDate."', '".$strSuitableAppointmentTime."', '".$strAppointmentCheckInTime."', '".$strAppointmentCheckOutTime."', '".$strAppointmentOfferID."', '".$strStatus."')";
				}
				
				// echo $sqlInsert."<br>";				
				// die();
				ExecuteNQ($sqlInsert);
				$DB->close();
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
					</div>
				</div>');
			}
		}

		if($strStep=="book")
		{
			$strServicesused = $_POST["Services"];
			$strTechnicianSelect = $_POST["TechnicianSelect"];
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
			$strCustomerID = Decode($_POST["CustomerID"]);
			$strStoreID = Filter($_POST["StoreID"]);
			$strAppointmentDate = $_POST["AppointmentDate"];
			// echo $strAppointmentDate."<br>";
			$date = new DateTime($strAppointmentDate);
			$strAppointmentDate1 = $date->format('Y-m-d'); // 31-07-2012
			$strSuitableAppointmentTime = $_POST["SuitableAppointmentTime"];
			$date=new DateTime();
			$pqr = date("H:i:s",strtotime($strSuitableAppointmentTime));
			$strAppointmentCheckInTime = Filter($_POST["AppointmentCheckInTime"]);
			$strAppointmentCheckOutTime = Filter($_POST["AppointmentCheckOutTime"]);
			$strAppointmentOfferID = Filter($_POST["AppointmentOfferID"]);
			$strStatus = Filter($_POST["Status"]);
			$categoryselect = $_POST["categoryselect"];
			$qty = $_POST["qty"];
			$rem=$_POST["rem"];
			$appt=$_POST["appt"];
		
		/* 	foreach($qty as $vq)
					{
						
						echo $vq;
						// echo 
						//$i++;
					} */
			
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
					$Type_Service = Filter($_POST["Type_Service"]);
					$i=1;
				
				
                if(!empty($Type_Service))
				{
					
					if($Type_Service=='0')
					{
							$sqlInsert = "INSERT INTO tblAppointments (CustomerID, StoreID, AppointmentDate, SuitableAppointmentTime, AppointmentCheckInTime, AppointmentCheckOutTime, AppointmentOfferID, Status,FreeService,PackageID) VALUES 
				('".$strCustomerID."', '".$strStoreID."', '".$strAppointmentDate1."', '".$pqr."', '".$strAppointmentCheckInTime."', '".
				$strAppointmentCheckOutTime."', '".$strAppointmentOfferID."', '0','0','0')";
					}
					else
					{
							$sqlInsert = "INSERT INTO tblAppointments (CustomerID, StoreID, AppointmentDate, SuitableAppointmentTime, AppointmentCheckInTime, AppointmentCheckOutTime, AppointmentOfferID, Status,FreeService,PackageID) VALUES 
				('".$strCustomerID."', '".$strStoreID."', '".$strAppointmentDate1."', '".$pqr."', '".$strAppointmentCheckInTime."', '".
				$strAppointmentCheckOutTime."', '".$strAppointmentOfferID."', '0','1','0')";
					}
				
				}
				else
				{
					$sqlInsert = "INSERT INTO tblAppointments (CustomerID, StoreID, AppointmentDate, SuitableAppointmentTime, AppointmentCheckInTime, AppointmentCheckOutTime, AppointmentOfferID, Status,PackageID) VALUES 
				('".$strCustomerID."', '".$strStoreID."', '".$strAppointmentDate1."', '".$pqr."', '".$strAppointmentCheckInTime."', '".
				$strAppointmentCheckOutTime."', '".$strAppointmentOfferID."', '0','0')";
				}
		
						
				
				// echo $sqlInsert."<br>";
				// die();
				//ExecuteNQ($sqlInsert);
				$dateyu=Date('Y-m-d');
				$datet=date("H:i:s", time());
				if ($DB->query($sqlInsert) === TRUE) 
				{
					$last_idp = $DB->insert_id;		//last id of tblCustomers insert
					if($rem=='Y')
					{
						   $sqlInserter = "Insert into tblCustomerRemarks(AppointmentID, CustomerID, Status,Remark,UpdateDate,UpdateTime,UpdatedBy,StoreID,CommentType) values('".$last_idp."','".$strCustomerID."', '0','Book','".$dateyu."','".$datet."','".$strAdminID."','".$strStoreID."','1')";
						   ExecuteNQ($sqlInserter);
						   
						   $sqlUpdate1 = "UPDATE tblAppointments SET CustomerRemark='Appointment Book',CommentType='1',ReturnStatus='1' WHERE AppointmentID='".$appt."'";
					       ExecuteNQ($sqlUpdate1);
						   
						   $sqlUpdate2 = "UPDATE tblCustomerRemarks SET CommentType='1',Remark='Book' WHERE AppointmentID='".$appt."'";
					       ExecuteNQ($sqlUpdate2);
					}
				}
				
	
			//echo $sqlInsert;
			
			
			
			$weekday = date('l', strtotime($strAppointmentDate)); // note: first arg to date() is lower-case L
			
			$Timebefore45min = date("H:i:s", strtotime("-45 minutes", strtotime($pqr)));
			// echo "Timebefore45min ".$Timebefore45min."<br>";
			
			$dateforsms=FormatDatetime($strAppointmentDate1);
			// echo $dateforsms;
			// die();
			
			$CurrentTime = date('H:i:s');
			$SpanTime = date('H:i:s', strtotime('15 minute'));
			
			
				
			$sepptu=select("*","tblCustomerMemberShip","CustomerID='".$strCustomerID."'");
			$enddate=$sepptu[0]['EndDay'];	
			$seldatapq=select("memberid","tblCustomers","CustomerID='".$strCustomerID."'");
			$memid=$seldatapq[0]['memberid'];
			
				if($dateyu>=$enddate)
					 {
						 
					 }
					 else
					 {
						 
						 if($memid!="")
						{
							 $seldoffert=select("*","tblAppointments","AppointmentID='".$last_idp."'");
																	
												 $FreeService=$seldoffert[0]['FreeService'];
												 if($FreeService!="0")
												 {
													 
												 }
												 else
												 {
							$sqlUpdate1 = "UPDATE tblAppointments SET memberid='".$memid."' WHERE AppointmentID='".$last_idp."'";
								ExecuteNQ($sqlUpdate1);
												 }
						}
						else
						{
							
						}
					 }
		
			/* $p=0;
			foreach($qty as $ty)
			{
				$p++;
				 for($i=0;$i<count($strServicesused);$i++)
				{
						$sqlInsertpo = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID, ServiceID, MECID, Commission,Qty,QtyParam) VALUES
						('".$last_idp."', '".$strServicesused[$i]."', '0', '0','".$ty."','".$p."')";
						ExecuteNQ($sqlInsertpo);		
				}
			} */
			//Start added by asmita for new functions
   for($i=0;$i<count($strServicesused);$i++)
				{
					$selpw=select("*","tblServices","ServiceID='".$strServicesused[$i]."'");
					foreach($selpw as $vapt)
					{
						$ServiceID=$vapt['ServiceID'];
						$ServiceCost = $vapt["ServiceCost"];
						
						$sqlInsert3 = "INSERT INTO tblAppointmentsDetails (AppointmentID, ServiceID, ServiceAmount,  Status,qty,employeecategory) VALUES 
							('".$last_idp."', '".$ServiceID."', '".$ServiceCost."', '0','".$qty[$i]."','".$categoryselect[$i]."')";
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
									('".$last_idp."', '".$ServiceID."',  '".$ServiceCost."','0','".$qty[$i]."','".$categoryselect[$i]."')";
							if ($DB->query($sqlInsert3p) === TRUE) 
							{
								$last_id7 = $DB->insert_id;		//last id of tblAppointments insert
							}
							else
							{
								echo "Error: " . $sql . "<br>" . $conn->error;
							}
							  if($FreeService!="0")
									 {
						$sqlInsertpo = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID, ServiceID, MECID, Commission,Qty,FreeService) VALUES
						('".$last_idp."', '".$ServiceID."', '0', '0','".$qty[$i]."','1')";
						//echo $sqlInsertpo;
						ExecuteNQ($sqlInsertpo);
									 }
									 else
									 {
							$sqlInsertpo = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID, ServiceID, MECID, Commission,Qty) VALUES
						('".$last_idp."', '".$ServiceID."', '0', '0','".$qty[$i]."')";
						ExecuteNQ($sqlInsertpo);
						//echo $sqlInsertpo;
									 }
									 
				/* 			$selpqi=select("*","tblAppointmentAssignEmployee","AppointmentID='".$last_idp."' and ServiceID='".$ServiceID."'");
					 $qtyu=$selpqi[0]['Qty'];
					 if($qtyu=='1')
					 {
						$sqlUpdate1 = "UPDATE tblAppointmentAssignEmployee SET QtyParam='".$qtyu."' WHERE AppointmentID='".$last_idp."' and ServiceID='".$ServiceID."'";
					ExecuteNQ($sqlUpdate1);
					 }
					 elseif($qtyu=='0')
					 {
						// nothimng 
					 }
					 else
					 {
						 $sqlUpdate1 = "UPDATE tblAppointmentAssignEmployee SET QtyParam='".$qtyu."' WHERE AppointmentID='".$last_idp."' and ServiceID='".$ServiceID."'";
						// echo $sqlUpdate1;
					    ExecuteNQ($sqlUpdate1);
						 //UPDATE PARAM 
						for($i=1;$i<$qtyu;$i++)
						{
							 if($FreeService!="0")
									 {
							$sqlInsert3ptr = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID,ServiceID, Qty,QtyParam,MECID,Commission,FreeService) VALUES 
									('".$last_idp."', '".$ServiceID."','".$qtyu."','".$i."','0','0','1')";
							if ($DB->query($sqlInsert3ptr) === TRUE) 
							{
								$last_id50 = $DB->insert_id;		//last id of tblAppointments insert
							}
							else
							{
								echo "Error: " . $sqlInsert3ptr . "<br>" . $conn->error;
							}
									 }
									 else
									 {
							$sqlInsert3ptr = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID,ServiceID, Qty,QtyParam,MECID,Commission,FreeService) VALUES 
									('".$last_idp."', '".$ServiceID."','".$qtyu."','".$i."','0','0','0')";
							if ($DB->query($sqlInsert3ptr) === TRUE) 
							{
								$last_id50 = $DB->insert_id;		//last id of tblAppointments insert
							}
							else
							{
								echo "Error: " . $sqlInsert3ptr . "<br>" . $conn->error;
							}
							//echo $sqlInsert3ptr;
									 }
							
						}
					 }
					  */
					 
				
			      
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
									('".$last_id3."', '".$strSetName."', '".$totalamt."','".$last_idp."')";
									$sqlInsertcharges."<br/>";
									ExecuteNQ($sqlInsertcharges);
										$sqlInsertchargesd = "INSERT INTO tblAppointmentsChargesInvoice(AppointmentDetailsID, ChargeName, ChargeAmount,AppointmentID,TaxGVANDM) VALUES 
									('".$last_id7."', '".$strSetName."', '".$totalamt."','".$last_idp."','2')";
									$sqlInsertcharges."<br/>";
									ExecuteNQ($sqlInsertchargesd);
							}
						}
						
								
					}
					unset($strChargeSet);
					//$selpw="";
				}
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
				$sql = "SELECT ServiceID, EmployeeID FROM tblAppointmentsDetails WHERE AppointmentID ='".$last_idp."'";
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
				$selpqitq=select("*","tblAppointmentsDetailsInvoice","AppointmentID='".$last_idp."'");
				foreach($selpqitq as $SQ)
				{
					$serr[]=$SQ['ServiceID'];
				}
				$strServicesselected ='<tr>
										<th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Code</th>
										<th width="75%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:left; padding-left:2%;">Item Description</th>
										<th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Amount</th>
									</tr>';
				$counterservices = 0;
				
				for($j=0; $j<count($serr); $j++) 
				{	
					$counterservices++;
					$Servicestaken = $serr[$j];
					
					$selpqi=select("*","tblAppointmentAssignEmployee","AppointmentID='".$last_idp."' and ServiceID='".$Servicestaken."'");
					$qtyu=$selpqi[0]['Qty'];
					 if($qtyu=='1')
					 {
						$sqlUpdate1 = "UPDATE tblAppointmentAssignEmployee SET QtyParam='".$qtyu."' WHERE AppointmentID='".$last_idp."' and ServiceID='".$Servicestaken."'";
					ExecuteNQ($sqlUpdate1);
					 }
					 elseif($qtyu=='0')
					 {
						// nothimng 
					 }
					 else
					 {
						 //echo 11;
						 $sqlUpdate1 = "UPDATE tblAppointmentAssignEmployee SET QtyParam='".$qtyu."' WHERE AppointmentID='".$last_idp."' and ServiceID='".$Servicestaken."'";
						//echo $sqlUpdate1;
					    ExecuteNQ($sqlUpdate1);
						 //UPDATE PARAM 
						for($i=1;$i<$qtyu;$i++)
						{
							
							 if($FreeService!="0")
									 {
							$sqlInsert3ptr = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID,ServiceID, Qty,QtyParam,MECID,Commission,FreeService) VALUES 
									('".$last_idp."', '".$Servicestaken."','".$qtyu."','".$i."','0','0','1')";
							if ($DB->query($sqlInsert3ptr) === TRUE) 
							{
								$last_id50 = $DB->insert_id;		//last id of tblAppointments insert
							}
							else
							{
								echo "Error: " . $sqlInsert3ptr . "<br>" . $conn->error;
							}
									 }
									 else
									 {
										 //echo $i;
							$sqlInsert3ptr = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID,ServiceID, Qty,QtyParam,MECID,Commission,FreeService) VALUES 
									('".$last_idp."', '".$Servicestaken."','".$qtyu."','".$i."','0','0','0')";
									//echo $sqlInsert3ptr;
							if ($DB->query($sqlInsert3ptr) === TRUE) 
							{
								$last_id50 = $DB->insert_id;		//last id of tblAppointments insert
							}
							else
							{
								echo "Error: " . $sqlInsert3ptr . "<br>" . $conn->error;
							}
							//echo $sqlInsert3ptr;
									 }
							
						}
					 }
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
				unset($strServices);
				$strTaxations = "";
				$sqlExtraCharges = "SELECT DISTINCT (ChargeName), SUM( ChargeAmount ) AS Sumarize FROM tblAppointmentsCharges WHERE AppointmentId ='".$last_idp."' GROUP BY ChargeName";
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
				$sqlInsert = "INSERT INTO  tblInvoice (AppointmentID, EmailMessageID, DateOfCreation) VALUES ('".$last_idp."', 'Null', 'Null')";
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
			
		
		
			$seldatac=select("CustomerEmailID,CustomerFullName,CustomerMobileNo","tblCustomers","CustomerID='".$strCustomerID."'");
			$emailc=$seldatac[0]['CustomerEmailID'];
			$fullname=$seldatac[0]['CustomerFullName'];
			$CustomerMobileNo=$seldatac[0]['CustomerMobileNo'];
		
			$seldata=select("*","tblStores","StoreID='".$strStoreID."'");
			$address=$seldata[0]['StoreOfficialAddress'];
			$storename=$seldata[0]['StoreName'];
			$branche=explode(",",$storename);
			$branchname=$branche[1]; 
			$strTo = $emailc;
			$strFrom = "appnt@nailspaexperience.com";
				$strSubject = "Thank you for booking appointment at Nailspa Experience";
		
			$strBody = "";
			$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
			$Name = $fullname;
			$Email = $emailc;
			//$strAdminPassword = $strAdminPassword;
				//$strDate = date("Y-m-d h:i:s");
			$StoreAddress = $address;
			$strDate = date("Y-m-d");
			$strTime = $strSuitableAppointmentTime;
			 $path="`http://nailspaexperience.com/images/test2.png`";
		
			$message = file_get_contents('EmailFormat/appointment.html');
			$message = str_replace("[\]",'',$message);

			//setup vars to replace
			$vars = array('{Name_Detail}','{Date}','{Time}','{Address}','{Path}','{Branch}'); //Replace varaibles
			$values = array($Name,$strDate,$strTime,$StoreAddress,$path,$branchname);

			//replace vars
			$message = str_replace($vars,$values,$message);
			//echo $message;

                
			$strBody = $message;
			//echo $strBody;
			// echo $last_idp;
			$flag='APB';
			$id = $last_idp;
			if($strTo!="")
			{
			sendmail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus);
			}
		
				$SMSContent="Dear Customer Name, your appnt is scheduled for ".$weekday." ".$dateforsms." at ".$strSuitableAppointmentTime." at ".$storename.". Pls cancel or reschedule 45mins in advance to avoid cancellation charges.";
				
				$SMSContentforImmediate="Thank you for booking your appointment with Nailspa Experience for ".$weekday." ".$dateforsms." at ".$strSuitableAppointmentTime." at ".$storename.".Pls cancel or reschedule 45mins in advance to avoid cancellation charges.";
		
					// echo "In if<br>";
					$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".$last_idp	."','".$strStoreID."','".$strCustomerID."','".$strAppointmentDate6."','".$pqr."','".$Timebefore45min."',0,'".$SMSContent."', '".$CustomerMobileNo."')";
					
					ExecuteNQ($InsertSMSDetails);
					// die();
					$SendSMS = CreateSMSURL("Appointment Booked","0","0",$SMSContentforImmediate,$CustomerMobileNo);
				
			
			
			$DB->close();
		/* 	die('<div class="alert alert-close alert-success">
				<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
				<div class="alert-content">
					<h4 class="alert-title">Appointment has been Added Successfully.</h4>
				</div>
			</div>'); */
			
			
				}
			
		echo("<script>location.href='ManageAppointments.php';</script>");
			
		
		}
		
		if($strStep=="edit")
		{
			$DB = Connect();
			foreach($_POST as $key => $val)
			{
				
				if($key=="step" || $key==$strMyTableID)
				{
				
				}
				else
				{
					$sqlUpdate = "UPDATE $strMyTable SET $key='$_POST[$key]' WHERE $strMyTableID='".DecodeQ($_POST[$strMyTableID])."'";
					// echo $sqlUpdate."<br>";
					
					ExecuteNQ($sqlUpdate);
					$suitabletime=$_POST['SuitableAppointmentTime'];
					$time_in_24_hour_format  = date("H:i", strtotime($suitabletime));
					
					$sqlUpdate1 = "UPDATE $strMyTable SET SuitableAppointmentTime='".$time_in_24_hour_format."',Status='6' WHERE $strMyTableID='".DecodeQ($_POST[$strMyTableID])."'";
					// echo $sqlUpdate."<br>";
					
					ExecuteNQ($sqlUpdate1);
				}			
			}
			// die();
				$ID=DecodeQ($_POST[$strMyTableID]);
				$seldata=select("*","tblAppointments","AppointmentID='".$ID."'");
				//print_r($seldata);
				$strCustomerID=$seldata[0]['CustomerID'];
				$strStoreID=$seldata[0]['StoreID'];
				$AppointmentDate=$seldata[0]['AppointmentDate'];
				$timep=$seldata[0]['SuitableAppointmentTime'];
				$time_in_12_hour_format  = date("g:i a", strtotime($timep));
			//exit();
				$seldatac=select("CustomerEmailID,CustomerFullName","tblCustomers","CustomerID='".$strCustomerID."'");
				//print_r($seldatac);
				$emailc=$seldatac[0]['CustomerEmailID'];
				$fullname=$seldatac[0]['CustomerFullName'];
				$seldatacp=select("StoreOfficialAddress","tblStores","StoreID='".$strStoreID."'");
				$address=$seldatacp[0]['StoreOfficialAddress'];
					$storename=$seldatacp[0]['StoreName'];
			       $branche=explode(",",$storename);
				   $branchname=$branche[1]; 
				$strTo = $emailc;
				$strFrom = "appnt@nailspaexperience.com";
				$strSubject = "Reschedule booking appointment at Nailspa Experience";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$Name = $fullname;
				$Email = $emailc;
				$path="`http://nailspaexperience.com/images/test2.png`";
				//$strAdminPassword = $strAdminPassword;
				//$strDate = date("Y-m-d h:i:s");
				$StoreAddress = $address;
				//$strDate = date("Y-m-d");
				//$strTime = $strSuitableAppointmentTime;
			
				$message = file_get_contents('EmailFormat/appointment_reschedule.html');
				$message = eregi_replace("[\]",'',$message);

				//setup vars to replace
				$vars = array('{Name_Detail}','{Date}','{Time}','{Address}','{path}','{Branch}'); //Replace varaibles
				$values = array($Name,$AppointmentDate,$time_in_12_hour_format,$StoreAddress,$path,$branchname);

				//replace vars
				$message = str_replace($vars,$values,$message);
				//echo $message;
                
				$strBody = $message;
				//echo $strBody;
				// echo $last_idp;
			
				$date = new DateTime($AppointmentDate);
				$strAppointmentDate1 = $date->format('Y-m-d');
				/* $sqlInsert8 = "INSERT INTO tblAdminMail (Id,ToEmail, FromEmail, Subject, Body,flag,status) VALUES ('".$ID."', '$strTo', '$strFrom', '$strSubject', '$strBody','APR','$strStatus')";
				//	echo $sqlInsert8;
				$DB->query($sqlInsert8); */
				//ExecuteNQ($sqlInsert1);
				
				$id=$ID;
				$flag='APR';
			    if($strTo!="")
			   {
				sendmail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus);
			   }
				
				$SelectCustomerDetails="Select  CustomerMobileNo from tblCustomers where CustomerID='$strCustomerID'";
				// echo $SelectCustomerDetails."<br>";
				$RScust= $DB->query($SelectCustomerDetails);
				if ($RScust->num_rows > 0) 
				{
					while($rowcust = $RScust->fetch_assoc())
					{
						// $strCustomerName = $rowcust["CustomerName"];
						$strCustomerMobileNo = $rowcust["CustomerMobileNo"];
					}
				}
					$weekday = date('l', strtotime($AppointmentDate)); // note: first arg to date() is lower-case L
				
					$dateforsms=FormatDatetime($time_in_12_hour_format);
				
					$SMSContentforImmediate="Thank you for Reschedule your appointment with Nailspa Experience for ".$weekday." ".$dateforsms." at ".$timep." at ".$storename.".";
					
					
					// echo "In if<br>";
					$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".$last_idp	."','".$strStoreID."','".$strCustomerID."','".$strAppointmentDate6."','".$pqr."','".$Timebefore45min."',0,'".$SMSContent."', '".$strCustomerMobileNo."')";
					// echo $InsertSMSDetails."<br>";
					ExecuteNQ($InsertSMSDetails);
					// die();
					$SendSMS = CreateSMSURL("Appointment Booked","0","0",$SMSContentforImmediate,$strCustomerMobileNo);
				
				
				
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
	
if(isset($_GET['cin']) || isset($_GET['cout']) || isset($_GET['cid']))
{
	$DB = Connect();
	
	if(isset($_GET['cin']))
	{

		date_default_timezone_set('Asia/Kolkata');
$timestamp =  date("H:i:s", time());

		$septq=select("SuitableAppointmentTime","tblAppointments","AppointmentID='".DecodeQ($_GET['cin'])."'");
		$SuitableAppointmentTimer=$septq[0]['SuitableAppointmentTime'];
		$diff = $SuitableAppointmentTimer - $timestamp;
		if($diff=='0')
		{
			$sqlUpdate1 = "UPDATE $strMyTable SET AppointmentCheckInTime ='".$timestamp."', Status = '1' WHERE $strMyTableID='".DecodeQ($_GET['cin'])."'";
		ExecuteNQ($sqlUpdate1);
		}
		else
		{
			$sqlUpdate1 = "UPDATE $strMyTable SET AppointmentCheckInTime ='".$timestamp."', Status = '5' WHERE $strMyTableID='".DecodeQ($_GET['cin'])."'";
		ExecuteNQ($sqlUpdate1);
		}
		
		
		
		$seldata = select("CustomerID,StoreID,AppointmentDate","$strMyTable","$strMyTableID='".DecodeQ($_GET['cin'])."'");
		$customer=$seldata[0]['CustomerID'];
		$stores=$seldata[0]['StoreID'];
		$appoint_date=$seldata[0]['AppointmentDate'];
		$sqlDelete = "DELETE FROM tblAppointmentlog WHERE appointment_id='".DecodeQ($_GET['cin'])."'";
		ExecuteNQ($sqlDelete);
	  
		$sqlInsert1 = "Insert into tblAppointmentlog (appointment_id, invoice_name, appointment_date,store,status) values('".DecodeQ($_GET['cin'])."','".$customer."', '".$appoint_date."','".$stores."','1')";
		$DB->query($sqlInsert1); 
		
		$sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '1' WHERE AppointmentID='".DecodeQ($_GET['cin'])."'";
		
		ExecuteNQ($sqlUpdate2);
		
	header('Location: ManageAppointments.php');
	}
	elseif(isset($_GET['cout']))
	{
		 $passingID1 = $_GET['cout'];
		$str = "Hello";
		date_default_timezone_set('Asia/Kolkata');
		$timestamp =  date("H:i:s", time());
		$sqlUpdate1 = "UPDATE $strMyTable SET AppointmentCheckOutTime = '".$timestamp."', Status = '2' WHERE $strMyTableID='".DecodeQ($_GET['cout'])."'";
		$passingID = EncodeQ(DecodeQ($passingID1));
		ExecuteNQ($sqlUpdate1);
		
		$seldata = select("CustomerID,StoreID,AppointmentDate","$strMyTable","$strMyTableID='".DecodeQ($_GET['cout'])."'");
		$customer=$seldata[0]['CustomerID'];
		$stores=$seldata[0]['StoreID'];
		$appoint_date=$seldata[0]['AppointmentDate']; 
		
		$sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '2' WHERE AppointmentID='".DecodeQ($_GET['cout'])."'";
		
		ExecuteNQ($sqlUpdate2);
		
		$seldatat = select("*","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['cout'])."'");
        foreach($seldatat as $valp)
		{
			//print_r($valp);
			$servicee=$valp['ServiceID'];
			$qty=$valp['qty'];
				$seldataty = select("distinct(ProductID)","tblProductsServices","ServiceID='".$servicee."'");
			//	print_r($seldataty);
				foreach($seldataty as $valw)
				{
					$seldatatqq = select("count(ProductID)","tblNewProducts","ProductID='".$valw['ProductID']."'");
					$cnt=$seldatatqq[0]['count(ProductID)'];
					
					if($cnt=='0')
					{
						
						$seldatatqt = select("*","tblNewProductStocks","ProductStockID='".$valw['ProductID']."'");
						
						$PerQtyServe=$seldatatqt[0]['PerQtyServe'];
							
							$septq=select("*","tblStoreProduct","ProductStockID='".$valw['ProductID']."'");
							$UpdatePerQtyServe=$septq[0]['UpdatePerQtyServe'];
							$stock=$septq[0]['Stock'];
							if($UpdatePerQtyServe==$PerQtyServe)
							{
								 $newstock=$stock-1;
								 $sqlUpdate = "UPDATE  tblStoreProduct SET UpdatePerQtyServe='0',Stock='".$newstock."' WHERE ProductStockID='".$valw['ProductID']."'";
								 	ExecuteNQ($sqlUpdate);
									$UpdatePerQtyServe1=0;
									$newupdate=$UpdatePerQtyServe1+1;
								 $sqlUpdate1 = "UPDATE  tblStoreProduct SET UpdatePerQtyServe='".$newupdate."' WHERE ProductStockID='".$valw['ProductID']."'";
								 ExecuteNQ($sqlUpdate1);
								 //echo ExecuteNQ($sqlUpdate1);
							}
							else
							{
								$newupdate=$UpdatePerQtyServe+1;
								 $sqlUpdate = "UPDATE  tblStoreProduct SET UpdatePerQtyServe='".$newupdate."' WHERE ProductStockID='".$valw['ProductID']."'";
								 ExecuteNQ($sqlUpdate);
							}
								 
		
							
						
					}
					else
					{
							$seldatatq = select("*","tblNewProducts","ProductID='".$valw['ProductID']."'");
					
					$variation=$seldatatq[0]['HasVariation'];
					if($variation!="0")
					{
						
						$seldatatqt = select("*","tblNewProductStocks","ProductID='".$valw['ProductID']."'");
						foreach($seldatatqt as $vqq)
						{
							$PerQtyServe=$vqq['PerQtyServe'];
							
							$septq=select("*","tblStoreProduct","ProductStockID='".$vqq['ProductStockID']."'");
							$UpdatePerQtyServe=$septq[0]['UpdatePerQtyServe'];
							$stock=$septq[0]['Stock'];
							if($UpdatePerQtyServe==$PerQtyServe)
							{
								 $newstock=$stock-1;
								 $sqlUpdate = "UPDATE  tblStoreProduct SET UpdatePerQtyServe='0',Stock='".$newstock."' WHERE ProductStockID='".$vqq['ProductStockID']."'";
								 	ExecuteNQ($sqlUpdate);
							}
							else
							{
								$newupdate=$UpdatePerQtyServe+1;
								 $sqlUpdate = "UPDATE  tblStoreProduct SET UpdatePerQtyServe='".$newupdate."' WHERE ProductStockID='".$vqq['ProductStockID']."'";
								 ExecuteNQ($sqlUpdate);
							}
								 
		
							
						}
					}
					else
					{
						$PerQtyServe=$seldatatq[0]['PerQtyServe'];
						
						$seldatatqu = select("*","tblStoreProduct","ProductID='".$valw['ProductID']."'");
						
						foreach($seldatatqu as $sq)
						{
							$stock=$sq['Stock'];
							$UpdatePerQtyServe=$sq['UpdatePerQtyServe'];
						if($UpdatePerQtyServe==$PerQtyServe)
							{
								 $newstock=$stock-1;
								 $sqlUpdate = "UPDATE  tblStoreProduct SET UpdatePerQtyServe='0',Stock='".$newstock."' WHERE ProductID='".$sq['ProductID']."'";
								 	ExecuteNQ($sqlUpdate);
									$UpdatePerQtyServe1=0;
									$newupdate=$UpdatePerQtyServe1+1;
								 $sqlUpdate1 = "UPDATE  tblStoreProduct SET UpdatePerQtyServe='".$newupdate."' WHERE ProductID='".$sq['ProductID']."'";
								 ExecuteNQ($sqlUpdate1);
									
							}
							else
							{
								$newupdate=$UpdatePerQtyServe+1;
								 $sqlUpdate = "UPDATE  tblStoreProduct SET UpdatePerQtyServe='".$newupdate."' WHERE ProductID='".$sq['ProductID']."'";
								 ExecuteNQ($sqlUpdate);
								// echo $sqlUpdate;
							}
						}
						
					}
					}
				
				}
		}

		
		
 	$sqlDelete = "DELETE FROM tblAppointmentlog WHERE appointment_id='".DecodeQ($_GET['cout'])."'";
		ExecuteNQ($sqlDelete);
	  
		$sqlInsert1 = "Insert into tblAppointmentlog (appointment_id, invoice_name, appointment_date,store,status) values('".DecodeQ($_GET['cout'])."','".$customer."', '".$appoint_date."','".$stores."','2')";
		$DB->query($sqlInsert1); 
				header('Location: ManageAppointments.php'); 
		//header('Location: appointment_invoice.php?uid='.DecodeQ($_GET['cout']));
		//header('Location: AppointmentDetails.php?aid='.$passingID);
	}
	elseif(isset($_GET['cid']))
	{
		$sqlUpdate1 = "UPDATE $strMyTable SET Status = '3' WHERE $strMyTableID='".DecodeQ($_GET['cid'])."'";
		ExecuteNQ($sqlUpdate1);
		
		$sqlUpdate2 = "UPDATE $strMyTable SET CheckConfirm = '3' WHERE $strMyTableID='".DecodeQ($_GET['cid'])."'";
		ExecuteNQ($sqlUpdate2);
		
		$seldata = select("CustomerID,StoreID,AppointmentDate","$strMyTable","$strMyTableID='".DecodeQ($_GET['cid'])."'");
		$customer=$seldata[0]['CustomerID'];
		$stores=$seldata[0]['StoreID'];
		$appoint_date=$seldata[0]['AppointmentDate'];
		
		$ID=DecodeQ($_GET['cid']);
		$seldatap=select("*","tblAppointments","AppointmentID='".$ID."'");
		$strCustomerID=$seldatap[0]['CustomerID'];
		$strStoreID=$seldatap[0]['StoreID'];
		//$time=$seldatap[0]['suitableAppointmentTime'];
		$seldatac=select("CustomerEmailID,CustomerFullName","tblCustomers","CustomerID='".$strCustomerID."'");
		//print_r($seldatac);
		$emailc=$seldatac[0]['CustomerEmailID'];
		$fullname=$seldatac[0]['CustomerFullName'];
		$seldatacp=select("StoreOfficialAddress","tblStores","StoreID='".$strStoreID."'");
		$address=$seldatacp[0]['StoreOfficialAddress'];
		$storename=$seldatacp[0]['StoreName'];
			     $branche=explode(",",$storename);
				   $branchname=$branche[1]; 
		$strTo = $emailc;
		$strFrom = "appnt@nailspaexperience.com";
		$strSubject = "Successfully Cancelled appointment at Nailspa Experience";
		$strBody = "";
		$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
		$Name = $fullname;
		$Email = $emailc;
		$path="`http://nailspaexperience.com/images/test2.png`";
		//$strAdminPassword = $strAdminPassword;
		//$strDate = date("Y-m-d h:i:s");
		$StoreAddress = $address;
		$strDate = date("Y-m-d");
		//$strTime = $strSuitableAppointmentTime;
				//$time_in_24_hour_format  = now();
		
		$message = file_get_contents('EmailFormat/appointment_cancel.html');
		$message = eregi_replace("[\]",'',$message);

		//setup vars to replace
		$vars = array('{Name_Detail}','{Date}','{Address}','{path}','{Branch}'); //Replace varaibles
		$values = array($Name,$strDate,$StoreAddress,$path,$branchname);

		//replace vars
		$message = str_replace($vars,$values,$message);
		//echo $message;

                
		$strBody = $message;
		//echo $strBody;
        // echo $last_idp;
		$flag='APC';
		$id=$ID;
		if($strTo!="")
		{
				sendmail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus);
		}
	
			
			
				$sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '3' WHERE AppointmentID='".DecodeQ($_GET['cid'])."'";
		
		ExecuteNQ($sqlUpdate2);
		
		$sqlDelete = "DELETE FROM tblAppointmentlog WHERE appointment_id='".DecodeQ($_GET['cid'])."'";
		ExecuteNQ($sqlDelete);
					  
		$sqlInsert1 = "Insert into tblAppointmentlog (appointment_id, invoice_name, appointment_date,store,status) values('".DecodeQ($_GET['cid'])."','".$customer."', '".$appoint_date."','".$stores."','3')";
		
		$DB->query($sqlInsert1); 
					  
		header('Location: ManageAppointments.php');
	}
	else
	{
		header('Location: ManageAppointments.php');
	}
	$DB->close();
	
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
		<meta http-equiv="refresh" content="120" />
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
							$("#AppointmentDate").datepicker({ minDate: 0 });
							$("#AppointmentDate").datepicker({ minDate: 0 });
						});
					</script>
				<script>
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
					function LoadValueon()
					{                
						// alert (OptionValue);
						var OptionValue=document.getElementById("StoreID")
						alert(OptionValue);
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
				</script>
				
				
<script>
		function myFunction() 
		{
			alert(123);
			document.getElementById("seleccolor").setAttribute("style", "background-color:#ffffba;");
			alert(234);
		}
		function UpdateConfirm(evt)
		{
				var app = $(evt).closest('td').find('input').val();
				// alert(app)
				if(app!='')
				{
						$.ajax({
							type: 'POST',
							url: "Update45minstatus.php",
							data:"app="+app,
							success: function(response) {
								//alert(response)
								if(response=='2')
								{
									location.reload();
								}
							}
						});
				}
		}
		</script>
	<style>
		<!--.setcolor
		{
			background:#ffffba;
			border:10px solid #ffffba;
		}-->
</style>
	<style>
	#City, #State, #Country
	{
		text-transform: uppercase;
	}
	.uppertransform
	{
		text-transform: uppercase;
	}
	</style>
</head>
<body>
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
                        <p>Re-schedule, Cancel Appointments</p>
                    </div>
<?php

if(!isset($_GET['uid']) && !isset($_GET['bid']) && !isset($_GET['vid']))
{
?>					
						<div class="panel">
						<div class="panel">
							<div class="panel-body">
								
								<div class="example-box-wrapper">
									<div class="tabs">
										<ul>
											<li><a href="#normal-tabs-1" title="Tab 1">Manage</a></li>
										</ul>
											<div id="normal-tabs-1">
												<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Today's Appointments | NailSpa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Customer Name<br>Mobile No.</th>
																<th>Store Name</th>
																<th>Appointment <br>Date & Time</th>
																<th>Check In<br>Check Out</th>
																<th>Offer ID</th>
																<th>Payment Mode</th>
																<th>Status</th>

																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Customer Name<br>Mobile No.</th>
																<th>Store Name</th>
																<th>Appointment <br>Date & Time</th>
																<th>Check In<br>Check Out</th>
																<th>Offer ID</th>
																<th>Payment Mode</th>
																<th>Status</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
//echo 1112;
//Only today's appointments will be listed.
$date=date('Y-m-d');
//echo $date."<br>";
//echo "Database values are in the format of year-month-date<br>";


$FindStore="Select StoreID from tblAdminStore where AdminID=$strAdminID";
// echo $FindStore;
$RSf = $DB->query($FindStore);
if ($RSf->num_rows > 0) 
{
	while($rowf = $RSf->fetch_assoc())
	{
		$strStoreID = $rowf["StoreID"];
		// echo $strStoreID;
	}
}
if($strStoreID!=0)
{
	$sql = "SELECT * FROM ".$strMyTable." WHERE StoreID='$strStoreID' and IsDeleted!='1' AND AppointmentDate = '$date' order by $strMyTableID desc";
	// echo "In if";
}
else
{
	$sql = "SELECT * FROM ".$strMyTable." WHERE  AppointmentDate = '$date' and IsDeleted!='1' order by $strMyTableID desc";
	// echo "In Else";
	// echo $sql."<br>";
}



//echo $sql;
// echo $sql;
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		// echo "In while";
		$counter ++;
		$strAppointmentID = $row["AppointmentID"];
		$getUID = EncodeQ($strAppointmentID);
		$getUIDDelete = Encode($strAppointmentID);	
		$strCustomerID = $row["CustomerID"];
		$strStoreID = $row["StoreID"];	
		$AppointmentDate = $row["AppointmentDate"];
			date_default_timezone_set('Asia/Kolkata');
		$SuitableAppointmentTime = $row["SuitableAppointmentTime"];
		$dateObject = new DateTime($SuitableAppointmentTime);
		// echo $dateObject->format('h:i A');
		// $abc=date("H:i",strtotime($SuitableAppointmentTime));
		$abc=date_format("H:i:s",strtotime($SuitableAppointmentTime));
	
		// $SuitableAppointmentTime=date('y/m/d H:i:s');
		// $newDateTime = date('h:i A', strtotime($SuitableAppointmentTime));
		// echo $newDateTime."<br>"; 
		
		$AppointmentCheckInTime = $row["AppointmentCheckInTime"];
		$AppointmentCheckOutTime = $row["AppointmentCheckOutTime"];
		$AppointmentOfferID = $row["AppointmentOfferID"];
		$Status = $row["Status"];
		$minstatus = $row["45minstatus"];
		$seldataqt=select("Flag","tblInvoiceDetails","AppointmentId='".$strAppointmentID."'");
	    $Flag=$seldataqt[0]['Flag'];
		  // echo $minstatus."<br>";
		// $seldataqtcountcheck=select("count(*)","tblAppointments","AppointmentID='".$strAppointmentID."' and AppointmentDate = '$date' and Status='0' and AppointmentCheckInTime='00:00:00' and 45minstatus='0'");
	    // $cntremdata=$seldataqtcountcheck[0]['count(*)'];	
		
		$seldataqtcountcheck=select("count(*)","tblAppointments","AppointmentDate = '$date' and Status='0' and AppointmentCheckInTime='00:00:00' and 45minstatus='0'");
	    $cntremdata=$seldataqtcountcheck[0]['count(*)'];
		   // select count())
		   // echo $AppointmentCheckInTime."<br>";
		  // AppointmentDate = '$date' and Status='0' and AppointmentCheckInTime='00:00:00' and 45minstatus='0'
				// if($Status=='0' || $Status=='6')
				// {
					// echo "In First if<br>";
					// if($AppointmentCheckInTime=='00:00:00')
					// {
						// echo "In second if<br>";
						// echo $strAppointmentID."<br>";
					// }
					// else
					// {
						// echo "In second else<br>";
					// }
				// }
				// else
				// {
					// echo "In First else<br>";
				// }
				
					
		
			 	if($AppointmentCheckInTime=='00:00:00')
				{
					// echo "In first if<br>";
					// echo $AppointmentCheckInTime."<br>";
					$timestamp =  date("h:i:s", time());
					$date1cc=$timestamp;
					$date2cc=$SuitableAppointmentTime;
					$dateyu=Date('Y-m-d H:i:s');
				
					$datetime_fromss = date("h:i:s", strtotime("-45 minutes", strtotime($date2cc)));
					// echo $SuitableAppointmentTime."<br>";
					// echo $datetime_fromss."<br>";
					// echo $date2cc."<br>";
				    // if($datetime_fromss<=$timestamp && $date2cc<=$datetime_fromss)
						
					$hourCurrentfirst = date('H:i:s');
					// echo $hourCurrentfirst."<br>";
					// echo $datetime_fromss."<br>";
					// echo $date2cc."<br>";
				    // if($hourCurrentfirst>=$datetime_fromss || $hourCurrentfirst<=$date2cc || $hourCurrentfirst>=$date2cc)
				    if($hourCurrentfirst>=$datetime_fromss)
					{ 
?>	
															<tr id="my_data_tr_<?=$counter ?>">
																<td>
																<?php 
																	// echo "In if<br>";
																	// echo "Sutable Time".$SuitableAppointmentTime."<br>";
																	// echo "before 45 min check".$datetime_fromss."<br>";
																	// echo "Sutable Time".$date2cc."<br>";
																	// echo "Current Time".$timestamp."<br>";
																?><br><?php //echo "in second if"; ?><br><?=$counter;?><br><?//=$Status?></td>
																<td>
																	<?
																	$sql_cust = "SELECT * FROM tblCustomers WHERE CustomerID = '".$strCustomerID."'";
																	$RS_cust = $DB->query($sql_cust);
																	$row_cust = $RS_cust->fetch_assoc();
																	$CustomerFullName = $row_cust['CustomerFullName'];
																	$CustomerMobileNo = $row_cust['CustomerMobileNo'];
																	echo "<b>Name : </b>".$CustomerFullName."<br> <b>Mobile No : </b>".$CustomerMobileNo;
																	?>
																</td>
																<td>
																	<?
																	$sql_store = "SELECT * FROM tblStores WHERE StoreID = '".$strStoreID."'";
																	$RS_store = $DB->query($sql_store);
																	$row_store = $RS_store->fetch_assoc();
																	$StoreName = $row_store['StoreName'];
																	echo $StoreName;
																	?>
																</td>
																
																<td><b>Date : </b><?=$AppointmentDate?><br><b>Time : </b><?		//=$SuitableAppointmentTime."<br>"?>
																	<?=$dateObject->format('h:i A')?>
																	<?//=$abc?>
																</td>
<?php																
																if($minstatus=='0')
																{ 
?>
																	<td style="text-align:center; background-color:#00f7f7">
<?php																	
																}
																elseif($minstatus=='1')
																{ 
?>
																	<td style="text-align:center;">
<?php																	
																}
?>
																
																<?php
																	if($AppointmentCheckInTime == "00:00:00" && $Status!= '3')
																	{ //echo "1";
																			// echo $timestamp."<br>";
																			// echo $SuitableAppointmentTime."<br>";
																			
																			// echo $hourCurrent."<br>";
																		// if (time() >= strtotime($item['date']) + 86400)
																		$hourCurrent = date('H:i:s');
																		if($hourCurrent>=$SuitableAppointmentTime && $minstatus!='1')
																		{	
																	//echo 3900;
																
																	
																			echo "Please contact admin to reopen this appointment";
																		
																		}
																		else
																		{
																			   //echo "In First<br>";
																				if($row['45minstatus']=='0')
																				{  
																			//echo 12123;
?>
																					<a class="btn btn-link" href="<?=$strMyActionPage?>?cin=<?=$getUID?>" disabled >Check-In</a>
<?php																					
																				}
																				elseif($row['45minstatus']=='1')
																				{  
?>																				
																					<a class="btn btn-link" href="<?=$strMyActionPage?>?cin=<?=$getUID?>">Check-In</a>(Appointment Confirmed)
<?php																					
																				}
																				?>
																				<!--<a class="btn btn-link" href="<?//=$strMyActionPage?>?cin=<?//=$getUID?>">Check-In</a>-->
<?php
																		}
																	}
																	elseif($AppointmentCheckInTime != "00:00:00" && $Status != '3')
																	{
																		$time_in_12_hour_format  = date("g:i a", strtotime($AppointmentCheckInTime));
																		echo "<b>In: </b>".$time_in_12_hour_format;
																	}
																	elseif($Status == '3')
																	{
																		?>
																			<a class="btn btn-link disabled" href="<?=$strMyActionPage?>?cin=<?=$getUID?>">Check-In</a>
																		<?
																	}
																	
																?>
																<br>
																<?
																	// if($AppointmentCheckInTime != "00:00:00" )
																	// {
																		// if($AppointmentCheckOutTime == "00:00:00")
																		// {
																			// ?>
																				<!--<a class="btn btn-link" href="<?=$strMyActionPage?>?cout=<?=$getUID?>">Check-Out</a>-->

																			<?
																		// }
																		// else
																		// {
																			// $time_in_12_hour_formatd  = date("g:i a", strtotime($AppointmentCheckOutTime));
																			// echo "<b>Out: </b>".$time_in_12_hour_formatd;
																		// }
																	// }
																	// elseif($AppointmentCheckInTime == "00:00:00" || $Status == "Cancelled" || $Status == '3')
																	// {
																		// ?>
																			<!--<a class="btn btn-link disabled" href="<?=$strMyActionPage?>?cout=<?=$getUID?>">Check-Out</a>-->
																		 <?
																		//echo $getUID;
																	// }
																	// else
																	// {
																		
																	// }
																	// if($AppointmentCheckInTime != "00:00:00" )
																	// {
																		// if($AppointmentCheckInTime == "00:00:00" )
																		// {
																			//echo $getUID;
	// ?>																		
																			<!-- <a class="btn btn-link" href="appointment_invoice.php?uid=<?//=$strAppointmentID?>">View Invoice</a>-->
	<?																//	}
																		
																	// }
																	if($AppointmentCheckOutTime != "00:00:00" )
																	{
																		?>
																		
																				<a class="btn btn-link" href="invoice_print.php?uid=<?=$getUID;?>">ViewInvoice</a>
	                                                   <?php
																	}
																	elseif($AppointmentCheckInTime != "00:00:00" )
																	{
																			$seldata=select("Flag","tblInvoiceDetails","AppointmentId='".$strAppointmentID."'");
																			$flag=$seldata[0]['Flag'];
                                                                         if($flag=='')
																		 {
																			 ?>
																		
																		<a class="btn btn-link" href="appointment_invoice.php?uid=<?=$getUID;?>">Edit Invoice</a>
																		<?php
																		 }
																		 elseif($flag=='H'){
																			 ?>
																			 
																			 <a class="btn btn-link" href="appointment_invoice.php?uid=<?=$getUID;?>">Edit Invoice</a>
																			 <?php
																		 }else{
																		 }	
																	}
                                       ?>
																</td>
																<td><?=$AppointmentOfferID?></td>
																		<td>
														<?php
														if($Flag=='C')
														{
															echo "Card";
														}
														elseif($Flag=='CS')
														{
															echo "Cash";
														}
														elseif($Flag=='Both')
														{
															echo "Both";
														}
														elseif($Flag=='Hold')
														{
															echo "Pending Amount";
														}
														?>
														</td>
																<td>
																	<?																		
																		if($Status=="0")
																		{
																			$time=date('H:i:s',strtotime($SuitableAppointmentTime));
																				if($time <= date('H:i:s')){ 
																				 $Status = 'Late';
																				}
																				else
																				{
																					 $Status = "Upcoming";
																					
																				}
																		}
																		elseif($Status=="1")
																		{
																			$Status = "In Progress";
																		}
																		elseif($Status=="2")
																		{
																			$Status = "Done";
																		}
																		elseif($Status=="3")
																		{
																			$Status = "Cancelled";
																		}
																		elseif($Status=="5")
																		{
																			$Status = "Late";
																		}
																		elseif($Status=="6")
																		{
																			$Status = "Rescheduled";
																		}
																	echo $Status;
																	?>
																</td>
																<td style="text-align: center">
																	<?
																	if($Status == "Upcoming" || $Status == "Late" || $Status == "Rescheduled")
																	{
																		
																	?>
<?php
																		$hourCurrent1 = date('H:i:s');
																		if($date2cc>$hourCurrent1)
																		{ 
																	     //echo 666;
																			
?>																	
																		<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Re-schedule</a><br>
<?php
																			// echo $minstatus."<br>";
																			if($row["45minstatus"]=='0')
																			{ 
?>
																				<input type="hidden" value="<?=$strAppointmentID?>" /><a class="btn btn-link" onclick="UpdateConfirm(this)">Confirm</a><br>
<?php
																			}
																			elseif($row["45minstatus"]=='1')
																			{
																				
																				
																				// echo "In else<br>";
																			}
																			else
																			{
																				echo "Something Wrong Please contact developer<br>";
																			}
?>																			
<?php																			
																		}
																		else
																		{ 	
																	?>
																				  <a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Re-schedule</a><br>
																				<?php
																		}
?>																		
                                                                    
																		<a class="btn btn-link" href="<?=$strMyActionPage?>?cid=<?=$getUID?>">Cancel</a>
																		
																	<?
																	}
																	else
																	{
																	?>
																		<a class="btn btn-link disabled" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Re-schedule</a><br>
																		<a class="btn btn-link disabled" href="<?=$strMyActionPage?>?cid=<?=$getUID?>">Cancel</a>
																	<?	
																	}
																	?>
																</td>
															</tr>
<?php
					}
					else
					{
						 
						 ?>	
															<tr id="my_data_tr_<?=$counter?>" >
																<td><?php //echo "In else<br>";
																	// echo $SuitableAppointmentTime."<br>";
																	// echo $datetime_fromss."<br>";
																	// echo $date2cc."<br>";
																	// echo $timestamp."<br>";
																?><br><?php //echo "In second else "; ?><?=$counter;
																?>
																	</td>
																<td>
																<?
																$sql_cust = "SELECT * FROM tblCustomers WHERE CustomerID = '".$strCustomerID."'";
																$RS_cust = $DB->query($sql_cust);
																$row_cust = $RS_cust->fetch_assoc();
																$CustomerFullName = $row_cust['CustomerFullName'];
																$CustomerMobileNo = $row_cust['CustomerMobileNo'];
																echo "<b>Name : </b>".$CustomerFullName."<br> <b>Mobile No : </b>".$CustomerMobileNo;
																?>
																</td>
																<td>
																<?
																$sql_store = "SELECT * FROM tblStores WHERE StoreID = '".$strStoreID."'";
																$RS_store = $DB->query($sql_store);
																$row_store = $RS_store->fetch_assoc();
																$StoreName = $row_store['StoreName'];
																echo $StoreName;
																?>
																</td>
																<td><b>Date : </b><?=$AppointmentDate?><br><b>Time : </b><?//=$SuitableAppointmentTime."<br>"?>
																<?=$dateObject->format('h:i A')?>
																<?//=$abc?>
																</td>
																<td style="text-align:center">
																<?
																	if($AppointmentCheckInTime == "00:00:00" && $Status != '3')
																	{ 
																		$hourCurrent = date('H:i:s');
																		if($hourCurrent>=$SuitableAppointmentTime && $minstatus!='1')
																		{				
																			echo "Please contact admin to reopen this appointment";
																		
																		}
																		else
																		{
																				
																				if($row['45minstatus']=='0')
																				{  
																			
																			//echo "In iff<br>";
?>
																					<a class="btn btn-link" href="<?=$strMyActionPage?>?cin=<?=$getUID?>" disabled>Check-In</a>
<?php																					
																				}
																				elseif($row['45minstatus']=='1')
																				{  //echo "In elsess<br>";
?>
																					<a class="btn btn-link" href="<?=$strMyActionPage?>?cin=<?=$getUID?>">Check-In</a>(Appointment Confirmed)
<?php																					
																				}
?>
																				<!--<a class="btn btn-link" href="<?//=$strMyActionPage?>?cin=<?//=$getUID?>">Check-In</a>-->
<?php
																		}
																		?>
																			<!--<a class="btn btn-link" href="<?//=$strMyActionPage?>?cin=<?//=$getUID?>">Check-In</a>-->
																		<?
																	}
																	elseif($AppointmentCheckInTime != "00:00:00" && $Status != '3')
																	{
																		$time_in_12_hour_format  = date("g:i a", strtotime($AppointmentCheckInTime));
																		echo "<b>In: </b>".$time_in_12_hour_format;
																	}
																	elseif($Status == '3')
																	{
																		?>
																			<a class="btn btn-link disabled" href="<?=$strMyActionPage?>?cin=<?=$getUID?>">Check-In</a>
																		<?
																	}
																	else
																	{
																		
																	}
																?>
																<br>
																<?
																	// if($AppointmentCheckInTime != "00:00:00" )
																	// {
																		// if($AppointmentCheckOutTime == "00:00:00")
																		// {
																			// ?>
																				<!--<a class="btn btn-link" href="<?=$strMyActionPage?>?cout=<?=$getUID?>">Check-Out</a>-->

																			<?
																		// }
																		// else
																		// {
																			// $time_in_12_hour_formatd  = date("g:i a", strtotime($AppointmentCheckOutTime));
																			// echo "<b>Out: </b>".$time_in_12_hour_formatd;
																		// }
																	// }
																	// elseif($AppointmentCheckInTime == "00:00:00" || $Status == "Cancelled" || $Status == '3')
																	// {
																		// ?>
																			<!--<a class="btn btn-link disabled" href="<?=$strMyActionPage?>?cout=<?=$getUID?>">Check-Out</a>-->
																		 <?
																		//echo $getUID;
																	// }
																	// else
																	// {
																		
																	// }
																	// if($AppointmentCheckInTime != "00:00:00" )
																	// {
																		// if($AppointmentCheckInTime == "00:00:00" )
																		// {
																			//echo $getUID;
	// ?>																		
																			<!-- <a class="btn btn-link" href="appointment_invoice.php?uid=<?//=$strAppointmentID?>">View Invoice</a>-->
	<?																//	}
																		
																	// }
																	if($AppointmentCheckOutTime != "00:00:00" )
																	{
																		?>
																				<a class="btn btn-link" href="invoice_print.php?uid=<?=$getUID;?>">ViewInvoice</a>
	                                                   <?php
																	}
																	elseif($AppointmentCheckInTime != "00:00:00" )
																	{
																			$seldata=select("Flag","tblInvoiceDetails","AppointmentId='".$strAppointmentID."'");
																			$flag=$seldata[0]['Flag'];
                                                                         if($flag=='')
																		 {
																			 ?>
																		
																		<a class="btn btn-link" href="appointment_invoice.php?uid=<?=$getUID;?>">Edit Invoice</a>
																		<?php
																		 }
																		 elseif($flag=='H'){
																			 ?>
																			 
																			 <a class="btn btn-link" href="appointment_invoice.php?uid=<?=$getUID;?>">Edit Invoice</a>
																			 <?php
																		 }else{
																			 
																		 }	
																	}
                                       ?>
																</td>
																<td><?=$AppointmentOfferID?></td>
																		<td>
														<?php
														if($Flag=='C')
														{
															echo "Card";
														}
														elseif($Flag=='CS')
														{
															echo "Cash";
														}
														elseif($Flag=='Both')
														{
															echo "Both";
														}
														elseif($Flag=='Hold')
														{
															echo "Pending Amount";
														}
														
														?>
														</td>
																<td>
																	<?	
																		if($Status=="0")
																		{
																			$time=date('H:i:s',strtotime($SuitableAppointmentTime));
																				if($time <= date('H:i:s')){ 
																				 $Status = 'Late';
																				}
																				else
																				{
																					 $Status = "Upcoming";
																					
																				}
																		}
																		elseif($Status=="1")
																		{
																			$Status = "In Progress";
																		}
																		elseif($Status=="2")
																		{
																			$Status = "Done";
																		}
																		elseif($Status=="3")
																		{
																			$Status = "Cancelled";
																		}
																		elseif($Status=="5")
																		{
																			$Status = "Late";
																		}
																		elseif($Status=="6")
																		{
																			$Status = "Rescheduled";
																		}
																	echo $Status;
																	?>
																</td>
																<td style="text-align: center">
																	<?
																	if($Status == "Upcoming" || $Status == "Late" || $Status == "Rescheduled")
																	{
																		
																		$hourCurrent1 = date('H:i:s');
																		if($date2cc>$hourCurrent1)
																		{ 
																			
?>																	
																		<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Re-schedule</a><br>
<?php
																			// echo $minstatus."<br>";
																			if($row["45minstatus"]=='0')
																			{ 
?>
																				<input type="hidden" value="<?=$strAppointmentID?>" /><a class="btn btn-link" onclick="UpdateConfirm(this)">Confirm</a><br>
<?php
																			}
																			elseif($row["45minstatus"]=='1')
																			{
																				?>
																				  <a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Re-schedule</a><br>
																				<?php
																			}
																			else
																			{
																				echo "Something Wrong Please contact developer<br>";
																			}
?>																			
<?php																			
																		}
																		else
																		{ 	
																		}
																	?>
																		<!--<a class="btn btn-link" href="<?//=$strMyActionPage?>?uid=<?//=$getUID?>">Re-schedule</a><br>-->
																		<a class="btn btn-link" href="<?=$strMyActionPage?>?cid=<?=$getUID?>">Cancel</a>
																		
																		
																	<?
																	}
																	else
																	{
																	?>
																		<a class="btn btn-link disabled" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Re-schedule</a><br>
																		<a class="btn btn-link disabled" href="<?=$strMyActionPage?>?cid=<?=$getUID?>">Cancel</a>
																	<?	
																	}
																	?>
																</td>
															</tr>
															
<?php
					}
					
					
				}
				else
				{
					// echo "In first else<br>";
					?>	
															<tr id="my_data_tr_<?=$counter?>">
																<td><?php //echo "In else"; ?><?=$counter?></td>
																<td>
																<?
																$sql_cust = "SELECT * FROM tblCustomers WHERE CustomerID = '".$strCustomerID."'";
																$RS_cust = $DB->query($sql_cust);
																$row_cust = $RS_cust->fetch_assoc();
																$CustomerFullName = $row_cust['CustomerFullName'];
																$CustomerMobileNo = $row_cust['CustomerMobileNo'];
																echo "<b>Name : </b>".$CustomerFullName."<br> <b>Mobile No : </b>".$CustomerMobileNo;
																?>
																</td>
																<td>
																<?
																$sql_store = "SELECT * FROM tblStores WHERE StoreID = '".$strStoreID."'";
																$RS_store = $DB->query($sql_store);
																$row_store = $RS_store->fetch_assoc();
																$StoreName = $row_store['StoreName'];
																echo $StoreName;
																?>
																</td>
																
																<td><b>Date : </b><?=$AppointmentDate?><br><b>Time : </b><?//=$SuitableAppointmentTime."<br>"?>
																<?=$dateObject->format('h:i A')?>
																<?//=$abc?>
																</td>
																<td style="text-align:center">
																<?
																	if($AppointmentCheckInTime == "00:00:00" && $Status != '3')
																	{ 
																		$hourCurrent = date('H:i:s');
																		if($hourCurrent>=$SuitableAppointmentTime && $minstatus!='1')
																		{				
																			echo "Please contact admin to reopen this appointment";
																		
																		}
																		else
																		{
																				// echo "In else<br>";
																				if($row['45minstatus']=='0')
																				{  //echo "In iff<br>";
?>
																					<a class="btn btn-link" href="<?=$strMyActionPage?>?cin=<?=$getUID?>" disabled>Check-In</a>
<?php																					
																				}
																				elseif($row['45minstatus']=='1')
																				{  //echo "In elsess<br>";
?>
																					<a class="btn btn-link" href="<?=$strMyActionPage?>?cin=<?=$getUID?>" >Check-In</a>(Appointment Confirmed)
<?php																					
																				}
?>
																				<!--<a class="btn btn-link" href="<?//=$strMyActionPage?>?cin=<?//=$getUID?>">Check-In</a>-->
<?php
																		}
																	}
																	elseif($AppointmentCheckInTime != "00:00:00" && $Status != '3')
																	{
																		$time_in_12_hour_format  = date("g:i a", strtotime($AppointmentCheckInTime));
																		echo "<b>In: </b>".$time_in_12_hour_format;
																	}
																	elseif($Status == '3')
																	{
																		?>
																			<a class="btn btn-link disabled" href="<?=$strMyActionPage?>?cin=<?=$getUID?>">Check-In</a>
																		<?
																	}
																	else
																	{
																		
																	}
																?>
																<br>
																<?
																	// if($AppointmentCheckInTime != "00:00:00" )
																	// {
																		// if($AppointmentCheckOutTime == "00:00:00")
																		// {
																			// ?>
																				<!--<a class="btn btn-link" href="<?=$strMyActionPage?>?cout=<?=$getUID?>">Check-Out</a>-->

																			<?
																		// }
																		// else
																		// {
																			// $time_in_12_hour_formatd  = date("g:i a", strtotime($AppointmentCheckOutTime));
																			// echo "<b>Out: </b>".$time_in_12_hour_formatd;
																		// }
																	// }
																	// elseif($AppointmentCheckInTime == "00:00:00" || $Status == "Cancelled" || $Status == '3')
																	// {
																		// ?>
																			<!--<a class="btn btn-link disabled" href="<?=$strMyActionPage?>?cout=<?=$getUID?>">Check-Out</a>-->
																		 <?
																		//echo $getUID;
																	// }
																	// else
																	// {
																		
																	// }
																	// if($AppointmentCheckInTime != "00:00:00" )
																	// {
																		// if($AppointmentCheckInTime == "00:00:00" )
																		// {
																			//echo $getUID;
	// ?>																		
																			<!-- <a class="btn btn-link" href="appointment_invoice.php?uid=<?//=$strAppointmentID?>">View Invoice</a>-->
	<?																//	}
																		
																	// }
																	if($AppointmentCheckOutTime != "00:00:00" )
																	{
																		?>
																		
																		
																				<a class="btn btn-link" href="invoice_print.php?uid=<?=$getUID;?>">ViewInvoice</a>
	                                                   <?php																			
																		 
																	}
																	elseif($AppointmentCheckInTime != "00:00:00" )
																	{
																			$seldata=select("Flag","tblInvoiceDetails","AppointmentId='".$strAppointmentID."'");
																			$flag=$seldata[0]['Flag'];
                                                                         if($flag=='')
																		 {
																			 ?>
																		
																		<a class="btn btn-link" href="appointment_invoice.php?uid=<?=$getUID;?>">Edit Invoice</a>
																		<?php
																		 }
																		 elseif($flag=='H'){
																			 ?>
																			 
																			 <a class="btn btn-link" href="appointment_invoice.php?uid=<?=$getUID;?>">Edit Invoice</a>
																			 <?php
																		 }else{
																			 
																		 }	
																					 
																		
																	}
																	
                                       ?>
																
																</td>
																<td><?=$AppointmentOfferID?></td>
																		<td>
														<?php
														if($Flag=='C')
														{
															echo "Card";
														}
														elseif($Flag=='CS')
														{
															echo "Cash";
														}
														elseif($Flag=='Both')
														{
															echo "Both";
														}
														elseif($Flag=='Hold')
														{
															echo "Pending Amount";
														}
														
														?>
														</td>
																
																<td>
																	<?	
																		if($Status=="0")
																		{
																			$time=date('H:i:s',strtotime($SuitableAppointmentTime));
																				if($time <= date('H:i:s')){ 
																				 $Status = 'Late';
																				}
																				else
																				{
																					 $Status = "Upcoming";
																					
																				}
																		}
																		elseif($Status=="1")
																		{
																			$Status = "In Progress";
																		}
																		elseif($Status=="2")
																		{
																			$Status = "Done";
																		}
																		elseif($Status=="3")
																		{
																			$Status = "Cancelled";
																		}
																		elseif($Status=="5")
																		{
																			$Status = "Late";
																		}
																		elseif($Status=="6")
																		{
																			$Status = "Rescheduled";
																		}
																	echo $Status;
																	?>
																</td>
																<td style="text-align: center">
																	<?
																	if($Status == "Upcoming" || $Status == "Late" || $Status == "Rescheduled")
																	{
																	?>
<?php																	
																		$hourCurrent1 = date('H:i:s');
																		if($date2cc>$hourCurrent1)
																		{ 
																			
?>																	
																		<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Re-schedule</a><br>
<?php
																			// echo $minstatus."<br>";
																			if($row["45minstatus"]=='0')
																			{ 
?>
																				<input type="hidden" value="<?=$strAppointmentID?>" /><a class="btn btn-link" onclick="UpdateConfirm(this)">Confirm</a><br>
<?php
																			}
																			elseif($row["45minstatus"]=='1')
																			{
																				?>
																				  <a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Re-schedule</a><br>
																				<?php
																			}
																			else
																			{
																				echo "Something Wrong Please contact developer<br>";
																			}
?>																			
<?php																			
																		}
																		else
																		{ 	
																		}
?>																		
																		<!--<a class="btn btn-link" href="<?=$strMyActionPage?>?cid=<?=$getUID?>">Cancel</a>
																		<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Re-schedule</a><br>-->
																		<a class="btn btn-link" href="<?=$strMyActionPage?>?cid=<?=$getUID?>">Cancel</a>
																	<?
																	}
																	else
																	{
																	?>
																		<a class="btn btn-link disabled" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Re-schedule</a><br>
																		<a class="btn btn-link disabled" href="<?=$strMyActionPage?>?cid=<?=$getUID?>">Cancel</a>
																	<?	
																	}
																	?>
																</td>
															</tr>
															
<?php
				} 

	}
}
else
{
?>															
															<tr>
																<td></td>
																<td></td>
																<td></td>
																<td>No Records Found</td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
														
<?php
}
$DB->close();
?>
														
														</tbody>
													</table>
												</div>
											</div>
											<div class="fa-hover col-sm-3" style="float: right">	
												<a class="btn btn-primary btn-lg btn-block" href="ViewAppointments.php"><i class="fa fa-backward"></i> &nbsp; View all Appointments</a>
											</div>
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
								<a class="btn btn-primary btn-lg btn-block" href="javascript:window.location = document.referrer;"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
						
							<div class="panel-body">
							<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email', '.admin_password'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
<?
								if(isset($_GET['uid']))
								{
?>
									<input type="hidden" name="step" value="edit">
									<h3 class="title-hero">Re-Schedule Appointments</h3>
									<div class="example-box-wrapper">
										
<?php
$DB = Connect();
$strID = DecodeQ(Filter($_GET['uid']));

$sql_appointments = "SELECT * FROM tblAppointments WHERE AppointmentID='".$strID."' and IsDeleted!='1'";
$seldata=select("*","tblAppointments","AppointmentID='".$strID."' and IsDeleted!='1'");
//echo $sql_appointments."<br>";
//echo $strID."<br>";

$RS_appointments = $DB->query($sql_appointments);


if ($RS_appointments->num_rows > 0) 
{
	while($row_appointments = $RS_appointments->fetch_assoc())
	{
		foreach($row_appointments as $key => $val)
		{
			if($key=="AppointmentID")
			{
				//echo $strID."<br>";
				// $abc=$strID;
				
?>
									<input type="hidden" name="<?=$key?>" value="<?=Encode($strID)?>">
<?php
			}
			else if($key=="CustomerProfilePath")
			{
				
			}
			elseif($key=="StoreID")
			{	$DBvalue=$row_appointments[$key];
					
	?>	
								
									<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreID", "Store Name", $key)?> <span>*</span></label>
									<div class="col-sm-4">	



<?php
										$sql = "SELECT StoreID, StoreName FROM tblStores WHERE Status=0";
										$RS2 = $DB->query($sql);
										if ($RS2->num_rows > 0)
										{
?>
											<select class="form-control required" name="<?=$key?>">
<?
												while($row2 = $RS2->fetch_assoc())
												{
													$StoreID = $row2["StoreID"];
													$StoreName = $row2["StoreName"];
													if($DBvalue==$StoreID)
													{	
?>

														<option value="<?=$StoreID?>" selected><?=$StoreName?></option>	
<?php
													}
													else
													{
?>

														<option value="<?=$StoreID?>"><?=$StoreName?></option>	
<?php
													}
												}
?>
											</select>
<?php
										}
										else
										{
											echo "Stores Not Added <a href='ManageStores.php' target='Manage Stores'>Click here to add</a>";
										}
?>	
									</div>
									</div>	
<?php
			}
			elseif($key=="AppointmentDate")
			{
										// echo $row_appointments[$key]."<br>";
?>	
										<div class="form-group"><label class="col-sm-3 control-label">Appointment Date <span>*</span></label>
											<!--<div class="col-sm-3">
												<span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span><input type="text" name="<?//=$key?>" value="<?//=$row_appointments[$key]?>" class="form-control required bootstrap-datepicker" data-date-format="yyyy/mm/dd">
											</div>-->
												<div class="col-sm-3">
											<div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span> <input type="text" name="<?=$key?>" value="<?=$row_appointments[$key]?>" id="AppointmentDate"  class="form-control" data-date-format="yy/mm/dd" value="<?php echo date('Y-m-d');?>"></div>
												</div>
										</div>	
<?php
			}
			elseif($key=="CustomerID")
			{
											$Cust_ID = $row_appointments[$key];
											//echo $row_appointments[$key]."<br>";
				
			}
			elseif($key=="SuitableAppointmentTime")
			{
				$time_in_12_hour_format  = date("g:i a", strtotime($row_appointments[$key]));
											// echo $row_appointments[$key]."<br>";
?>	
											<div class="form-group"><label class="col-sm-3 control-label">Suitable Time <span>*</span></label>
												<div class="col-sm-3">
													<input type="text" name="<?=$key?>"  value="<?=$time_in_12_hour_format?>"  id="SuitableAppointmentTime" class="form-control required timepicker-example">
												</div>
											</div>	
											
											
<?php
			}
		}
		// echo $row_appointments['CustomerID'];
		$sql = "SELECT * FROM tblCustomers WHERE CustomerID = '".$Cust_ID."'";
		//echo $sql;
		$RS = $DB->query($sql);
		if ($RS->num_rows > 0) 
		{
			while($row = $RS->fetch_assoc())
			{
				foreach($row as $key1 => $val1)
				{
					if($key1=="CustomerID")
					{
							// echo $row[$key1]."<br>";
							
		?>
													<input type="hidden" name="<?=$key1?>" value="<?=$Cust_ID?>">	

		<?php
					}
					elseif($key1=="CustomerFullName")
					{
							// echo $row[$key1]."<br>";
		?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerFullName", "Full Name", $key1)?> <span>*</span></label>
														<div class="col-sm-3"><input type="text" readonly name="<?=$key1?>" class="form-control required" placeholder="<?=str_replace("CustomerFullName", "Full Name", $key1)?>" value="<?=$row[$key1]?>"></div>
													</div>
		<?php
					}
					elseif($key1=="CustomerMobileNo")
					{
							// echo $row[$key1]."<br>";
		?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerMobileNo", "Mobile No.", $key1)?> <span>*</span></label>
														<div class="col-sm-3"><input type="text" readonly name="<?=$key1?>" pattern="[0-9]{10}" title="Enter a valid mobile number!" class="form-control required" placeholder="<?=str_replace("CustomerMobileNo", "Mobile No.", $key1)?>" value="<?=$row[$key1]?>"></div>
													</div>
													
		<?php
					}
				}
			}
		}
	}
		                                   if($strAdminRoleID=='36')
				                                         {
															 ?>
															 	<div class="form-group"><label class="col-sm-3 control-label">Type Service<span>*</span></label>
															<div class="col-sm-3">
															<select name="Type_Service" class="form-control required">
																<option value="0" Selected>Paid Service</option>
																<option value="1">Free Service</option>	
															</select>
															</div>
														</div>	
															 <?php
															 
														 }
														 elseif($strAdminRoleID=='2')
				                                         {
															 ?>
															 	<div class="form-group"><label class="col-sm-3 control-label">Type Service<span>*</span></label>
															<div class="col-sm-3">
															<select name="Type_Service" class="form-control required">
																<option value="0" Selected>Paid Service</option>
																<option value="1">Free Service</option>	
															</select>
															</div>
														</div>	
															 <?php
														 }
														 elseif($strAdminRoleID=='39')
				                                         {
															 ?>
															 	<div class="form-group"><label class="col-sm-3 control-label">Type Service<span>*</span></label>
															<div class="col-sm-3">
															<select name="Type_Service" class="form-control required">
																<option value="0" Selected>Paid Service</option>
																<option value="1">Free Service</option>	
															</select>
															</div>
														</div>	
															 <?php
														 }
}
?>
											<div class="form-group"><label class="col-sm-3 control-label"></label>
												<input type="submit" class="btn ra-100 btn-primary" value="Update">
												
												<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
											</div>
										
											</div>
											
											
											
<?php
}
elseif(isset($_GET['bid']))
{
	if(isset($_GET['Rem']))
	{
		$appt=$_GET['App'];
		?>
		<input type="hidden" name="rem" value="Y">
		<input type="hidden" name="appt" value="<?=$appt?>">
		<?php
	}
?>
								<input type="hidden" name="step" value="book">
								<h3 class="title-hero">Appointments</h3>
								<div class="example-box-wrapper">
										
<?php
$DB = Connect();
$strID = DecodeQ(Filter($_GET['bid']));//Booking for customer with id=bid

$sql_appointments = "SELECT * FROM tblCustomers WHERE CustomerID='".$strID."'";
$RS_appointments = $DB->query($sql_appointments);
if ($RS_appointments->num_rows > 0) 
{
	while($row_appointments = $RS_appointments->fetch_assoc())
	{
		foreach($row_appointments as $key1 => $val1)
		{
			if($key1=="CustomerID")
			{
?>
											<input type="hidden" name="<?=$key1?>" value="<?=Encode($strID)?>">

<?php
			}
			else if($key1=="CustomerProfilePath")
			{
				
			}
			elseif($key1=="CustomerFullName")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerFullName", "Full Name", $key1)?> <span>*</span></label>
												<div class="col-sm-3"><input readonly type="text" name="<?=$key1?>" class="form-control required" placeholder="<?=str_replace("CustomerFullName", "Full Name", $key1)?>" value="<?=$row_appointments[$key1]?>"></div>
											</div>
<?php
			}
			elseif($key1=="CustomerMobileNo")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerMobileNo", "Mobile No.", $key1)?> <span>*</span></label>
												<div class="col-sm-3"><input readonly type="text" name="<?=$key1?>" pattern="[0-9]{10}" title="Enter a valid mobile number!" class="form-control required" placeholder="<?=str_replace("CustomerMobileNo", "Mobile No.", $key1)?>" value="<?=$row_appointments[$key1]?>"></div>
											</div>
<?php
			}
		}
	}
								 if($strAdminRoleID=='36')
				                                         {
															 ?>
															 	<div class="form-group"><label class="col-sm-3 control-label">Type Service<span>*</span></label>
															<div class="col-sm-3">
															<select name="Type_Service" class="form-control required">
																<option value="0" Selected>Paid Service</option>
																<option value="1">Free Service</option>	
															</select>
															</div>
														</div>	
															 <?php
															 
														 }
														 elseif($strAdminRoleID=='2')
				                                         {
															 ?>
															 	<div class="form-group"><label class="col-sm-3 control-label">Type Service<span>*</span></label>
															<div class="col-sm-3">
															<select name="Type_Service" class="form-control required">
																<option value="0" Selected>Paid Service</option>
																<option value="1">Free Service</option>	
															</select>
															</div>
														</div>	
															 <?php
														 }
														 elseif($strAdminRoleID=='39')
				                                         {
															 ?>
															 	<div class="form-group"><label class="col-sm-3 control-label">Type Service<span>*</span></label>
															<div class="col-sm-3">
															<select name="Type_Service" class="form-control required">
																<option value="0" Selected>Paid Service</option>
																<option value="1">Free Service</option>	
															</select>
															</div>
														</div>	
															 <?php
														 }
			if($strAdminRoleID!='6')											
			{
				// echo "In if<br>";
				$sql1 = "SELECT StoreID, StoreName FROM tblStores WHERE Status = 0";
				$RS2 = $DB->query($sql1);
					if ($RS2->num_rows > 0)
					{
?>
													<div class="form-group"><label class="col-sm-3 control-label">Appointment at <span>*</span></label>
															<div class="col-sm-3">
																<select class="form-control required"  name="StoreID" id="StoreID" onChange="LoadValue(this.value);">
																	<option value="" selected>--Select Store--</option>
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
													
													<span id="asmita">
		
													</span>
													<span id="asmita1">
		
													</span>
<?php
					}
			

			}
			else
			{
				// echo "In else<br>";
				$sql1 = "SELECT StoreID, StoreName FROM tblStores WHERE Status = 0";
				$RS2 = $DB->query($sql1);
					if ($RS2->num_rows > 0)
					{
?>
													<div class="form-group"><label class="col-sm-3 control-label">Appointment at <span>*</span></label>
															<div class="col-sm-3">
																<select class="form-control required"  name="StoreID" id="StoreID"  onChange="LoadValue(this.value);">
																<option value="" selected>--Select Store--</option>
<?php																
																	while($row2 = $RS2->fetch_assoc())
																	{
																		$StoreID = $row2["StoreID"];
																		$StoreName = $row2["StoreName"];
																		if($StoreID==$strStoreID)
																		{
?>
																			<option value="<?=$StoreID?>" selected><?=$StoreName?></option>
<?																			
																		}
																		else
																		{
?>																		
																			<option value="<?=$StoreID?>"><?=$StoreName?></option>
<?php																		
																		}

																	}
?>
																</select>
															</div>
													</div>	
													
													<span id="asmita">
		
													</span>
													<span id="asmita1">
		
													</span>
<?php
					}
			

			}
	?>		
													<div class="form-group"><label class="col-sm-3 control-label">Appointment Date <span>*</span></label>
														<div class="col-sm-3">
															<!--<span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span><input type="text" name="AppointmentDate" id="AppointmentDate" class="bootstrap-datepicker form-control required" value="02/16/12" data-date-format="yyyy/dd/mm">-->
															 <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span> <input type="text" name="AppointmentDate" id="AppointmentDate"  class="form-control" data-date-format="YY-MM-DD" value="<?php echo date('Y-m-d');?>"></div>
														</div>
													</div>	
														
														
													<div class="form-group"><label class="col-sm-3 control-label">Suitable Time <span>*</span></label>
														<div class="col-sm-3">
															<input type="text" name="SuitableAppointmentTime" id="SuitableAppointmentTime" class="form-control required timepicker-example" data-time-format="h:i %p">
														</div>
													</div>															
	
<?	
}
?>


													<div class="form-group">
														<label class="col-sm-3 control-label"></label>
														<input type="submit" class="btn ra-100 btn-primary" value="Book">
														<div class="col-sm-1">
															<a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a>
														</div>
													</div>
													</div>
<script>
	function storeservices(a1){
		// alert (a1);
		var abc = a1;
		
		// alert (abc);
		$.ajax({
                url: "SelectServiceStoreWise.php",
                type: "POST",
                data: {
					StoreID: abc
				},
                success: function(response) {
						// alert(response)
						$("#ServiceID").html("");
						$("#ServiceID").html(response);
							
					},
            });
	}
	</script>												
<?php
}
elseif(isset($_GET['vid']))
{
	//echo "In VID";
	$DB = Connect();
	$strID = DecodeQ(Filter($_GET['vid']));
?>
							<div class="panel-body">
								<h3 class="title-hero">List of Appointments | NailSpa</h3>
								<div class="example-box-wrapper">
									<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>Sr.No</th>
												<th>Customer Name<br>Mobile No.</th>
												<th>Store Name</th>
												<th>Appointment <br>Date & Time</th>
												<th>Service</th>
												<th>Offer ID</th>
												<th>Payment Mode</th>
												<th>Status</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Sr.No</th>
												<th>Customer Name<br>Mobile No.</th>
												<th>Store Name</th>
												<th>Appointment <br>Date & Time</th>
												<th>Service</th>
												<th>Offer ID</th>
												<th>Payment Mode</th>
												<th>Status</th>
											</tr>
										</tfoot>
										<tbody>

<?php
											// Create connection And Write Values
											$DB = Connect();
											//Only today's appointments will be listed.
											$sql = "SELECT * FROM ".$strMyTable." WHERE CustomerID = '".$strID."' and IsDeleted!='1'";
											$RS = $DB->query($sql);
											if ($RS->num_rows > 0) 
											{
												$counter = 0;

												while($row = $RS->fetch_assoc())
												{
													$counter ++;
													$strAppointmentID = $row["AppointmentID"];
													$getUID = EncodeQ($strAppointmentID);
													$getUIDDelete = Encode($strAppointmentID);	
													$strCustomerID = $row["CustomerID"];
													$strStoreID = $row["StoreID"];	
													$AppointmentDate = $row["AppointmentDate"];
													$DBSuitableAppointmentTime = $row["SuitableAppointmentTime"];
                                                    $SuitableAppointmentTime = get12hour($DBSuitableAppointmentTime);
													$AppointmentOfferID = $row["AppointmentOfferID"];
													$Status = $row["Status"];
													$timestamp =  date("H:i:s", time());
                                    				
                                    				$date1=$timestamp;
                                    				$date2=$DBSuitableAppointmentTime;
                                    				$dateyu=Date('Y-m-d H:i:s');
                                    				
                                                    $datetime_from = date($date1, strtotime("-45 minutes", strtotime($date2)));
                                    				
                                    				if($datetime_from==$timestamp)
                                    				{
                                    				    ?>
                                    				   
													<tr id="my_data_tr_<?=$counter?>" style="background-color:red">
														<td><?=$counter?></td>
														<td>
															<?
															$sql_cust = "SELECT * FROM tblCustomers WHERE CustomerID = '".$strCustomerID."'";
															$RS_cust = $DB->query($sql_cust);
															$row_cust = $RS_cust->fetch_assoc();
															$CustomerFullName = $row_cust['CustomerFullName'];
															$CustomerMobileNo = $row_cust['CustomerMobileNo'];
															echo "<b>Name : </b>".$CustomerFullName."<br> <b>Mobile No : </b>".$CustomerMobileNo;
															?>
														</td>
														
														<td>
															<?
															$sql_store = "SELECT * FROM tblStores WHERE StoreID = '".$strStoreID."'";
															$RS_store = $DB->query($sql_store);
															$row_store = $RS_store->fetch_assoc();
															$StoreName = $row_store['StoreName'];
															echo $StoreName;
															?>
														</td>
														
														<td>
															<b>Date : </b><?=$AppointmentDate?><br><b>Time : </b><?=$SuitableAppointmentTime?></td>
														<td>
															<?
																$sql_Service = "SELECT * FROM tblAppointmentsDetails WHERE AppointmentID = '".$strAppointmentID."'";
																$RS_Service = $DB->query($sql_Service);
																$row_Service = $RS_Service->fetch_assoc();
																$ServiceID = $row_Service['ServiceID'];
																
																$sqlService = "SELECT * FROM tblServices WHERE ServiceID = '".$ServiceID."'";
																$RSService = $DB->query($sqlService);
																$rowService = $RSService->fetch_assoc();
																$ServiceName = $rowService['ServiceName'];
																
																echo $ServiceName;
															?>
														</td>
														<td>	
															<?=$AppointmentOfferID?>
														</td>
													   <td>
														<?php
														if($Flag=='C')
														{
															echo "Card";
														}
														elseif($Flag=='CS')
														{
															echo "Cash";
														}
														elseif($Flag=='Both')
														{
															echo "Both";
														}
														elseif($Flag=='Hold')
														{
															echo "Pending Amount";
														}
														
														?>
														</td>
														<td>
											             Please Confirm Appointment With Operation/Admin Manager
														</td>
													</tr>
<?php
                                    				   
                                    				}
                                    				else
                                    				{
                                    				    ?>
                                    				    
													<tr id="my_data_tr_<?=$counter?>">
														<td><?=$counter?></td>
														<td>
															<?
															$sql_cust = "SELECT * FROM tblCustomers WHERE CustomerID = '".$strCustomerID."'";
															$RS_cust = $DB->query($sql_cust);
															$row_cust = $RS_cust->fetch_assoc();
															$CustomerFullName = $row_cust['CustomerFullName'];
															$CustomerMobileNo = $row_cust['CustomerMobileNo'];
															echo "<b>Name : </b>".$CustomerFullName."<br> <b>Mobile No : </b>".$CustomerMobileNo;
															?>
														</td>
														
														<td>
															<?
															$sql_store = "SELECT * FROM tblStores WHERE StoreID = '".$strStoreID."'";
															$RS_store = $DB->query($sql_store);
															$row_store = $RS_store->fetch_assoc();
															$StoreName = $row_store['StoreName'];
															echo $StoreName;
															?>
														</td>
														
														<td>
															<b>Date : </b><?=$AppointmentDate?><br><b>Time : </b><?=$SuitableAppointmentTime?></td>
														<td>
															<?
																$sql_Service = "SELECT * FROM tblAppointmentsDetails WHERE AppointmentID = '".$strAppointmentID."'";
																$RS_Service = $DB->query($sql_Service);
																$row_Service = $RS_Service->fetch_assoc();
																$ServiceID = $row_Service['ServiceID'];
																
																$sqlService = "SELECT * FROM tblServices WHERE ServiceID = '".$ServiceID."'";
																$RSService = $DB->query($sqlService);
																$rowService = $RSService->fetch_assoc();
																$ServiceName = $rowService['ServiceName'];
																
																echo $ServiceName;
															?>
														</td>
														<td>	
															<?=$AppointmentOfferID?>
														</td>
													   <td>
														<?php
														if($Flag=='C')
														{
															echo "Card";
														}
														elseif($Flag=='CS')
														{
															echo "Cash";
														}
														elseif($Flag=='Both')
														{
															echo "Both";
														}
														elseif($Flag=='Hold')
														{
															echo "Pending Amount";
														}
														
														?>
														</td>
														<td>
															<?																		
																if($Status=="0")
																{
																	$Status = "Upcoming";
																}
																elseif($Status=="1")
																{
																	$Status = "In Progress";
																}
																elseif($Status=="2")
																{
																	$Status = "Done";
																}
																elseif($Status=="3")
																{
																	$Status = "Cancelled";
																}
																elseif($Status=="5")
																{
																	$Status = "Reschedule";
																}
																echo $Status;
															?>
														</td>
													</tr>
<?php
                                    				  
                                    				    
                                    				}
													


												}
											}
else
	{
?>															
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td>No Records Found</td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
<?php
	}
							$DB->close();
?>
										</tbody>
									</table>
								</div>
							</div>
<?
}
else
{
	
}
?>										
							</div>
							</form>
							</div>
						</div>
              	
            			   
<?php
}
?>	               
                   </div>		    
                  </div>	
                 </div>
            </div>	
        
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>