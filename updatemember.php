<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Manage Customers | Nailspa";
	$strDisplayTitle = "Manage Customers for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblServices";
	$strMyTableID = "ServiceID";
	//$strMyField = "CustomerMobileNo";
	$strMyActionPage = "appointment_invoice.php";
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
		
		
		
		$app_id = $_POST["app_id"];
		$member = $_POST["member"];
		$date=date('Y-m-d');
		$new_date = strtotime(date("Y-m-d", strtotime($date)) . " +12 month");
		$new_dated = date("Y-m-d",$new_date);
		
			$DB = Connect();
					  
					  
					$seldatap=select("CustomerID,offerid,VoucherID","tblAppointments","AppointmentID='".$app_id."'");	
			    	$custid=$seldatap[0]['CustomerID'];
					$offerid=$seldatap[0]['offerid'];
				    $VoucherID=$seldatap[0]['VoucherID'];
					$PackageID=$seldatap[0]['PackageID'];
				    $packages=explode(",",$PackageID);
					$sepptu=select("*","tblCustomerMemberShip","CustomerID='".$custid."'");
				    $enddate=$sepptu[0]['EndDay'];
					$RenewStatus=$sepptu[0]['RenewStatus'];
					$sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."' and PackageService='0'");
											   $cntserp=$sepcont[0]['count(*)'];
											   if($cntserp>0)
											   {
												      if($VoucherID!='0')
													   {
															  $seldofferpt=select("*","tblGiftVouchers","GiftVoucherID='".$VoucherID."'");
															$status=$seldofferpt[0]['Status'];
													   }
				
				  if($VoucherID!="0")
                     {
						
									if($offerid!="0")
								   {
								   echo 4;
								   }
								   elseif($VoucherID!="0")
								   {
									  
								   echo 8;
								   }
								  elseif($cntttp>0)
								   {
								       if($date>=$enddate)
									  {
										 
											  echo 6;
										  
									  }
									  else
									  {
										  	$sqlUpdate2 = "UPDATE tblCustomers SET memberid='".$member."',memberflag='0',MembershipDateTime='".$date."' WHERE CustomerID='".$custid."'";
							           ExecuteNQ($sqlUpdate2);
									  
									  
									   
								   	$sqlInsertchargesd = "INSERT INTO tblCustomerMemberShip(CustomerID, MembershipID, StartDay,EndDay,Status) VALUES 
									('".$custid."', '".$member."', '".$date."','".$new_dated."','0')";
									
									ExecuteNQ($sqlInsertchargesd);
								 $selp=select("Cost","tblMembership","MembershipID='".$member."'");
								 $total=$selp[0]['Cost'];
								   $sqlcharges = "Select ChargeNamesID , GROUP_CONCAT(distinct ChargeSetID) as ArrayChargeSet from tblCharges where 1";
					//echo $sqlcharges."<br>";
					$charges = $DB->query($sqlcharges);
						if ($charges->num_rows > 0) 
						{
							while($row = $charges->fetch_assoc())
							{
								$ChargeNameId = $row["ChargeNamesID"];
								$ArrayChargeSet = $row["ArrayChargeSet"];
								$strChargeSet = explode(",",$ArrayChargeSet);
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
								$totalst = $total;
								if($strChargeFPType == "0")
								{
									$strChargeAmt = $strChargeAmt;
								}
								else
								{
									
									$percentage = $strChargeAmt;
									//echo "percentage=".$percentage."<br/>";
									 $outof = $totalst;
									 //echo "ServiceCost=".$ServiceCost."<br/>";
								 $strChargeAmt = ($percentage / 100) * $outof;
								 	 //echo "strChargeAmt=".$strChargeAmt."<br/>";
								
								
								
								}
							$totalamt=$strChargeAmt;
							
										 $sqlInsert3 = "Insert into tblAppointmentsChargesInvoice(AppointmentID,AppointmentDetailsID,ChargeName,ChargeAmount,TaxGVANDM) values('".$app_id."','0','".$strSetName."','".$totalamt."','0')";
								
				if ($DB->query($sqlInsert3) === TRUE) 
							{
								$last_idpt = $DB->insert_id;		//last id of tblCustomers insert
							}
									
										
										}
									}
								}
						unset($strChargeSet);
						          $seldoffert=select("*","tblAppointments","AppointmentID='".$app_id."'");
														
								     $FreeService=$seldoffert[0]['FreeService'];
						             if($FreeService!="0")
									 {
										 
									 }
									 else
									 {
										 $sqlUpdate1 = "UPDATE tblAppointments SET memberid='".$member."' WHERE AppointmentID='".$app_id."'";
									ExecuteNQ($sqlUpdate1);
									 }
								
									
						
									
									//  $DB->query($sqlInsert1); 
									  if ($DB->query($sqlUpdate1) === TRUE) 
										{
											echo 2;
										}
									  }
									   
								   }
								   else
								   {
									  
										$sqlUpdate2 = "UPDATE tblCustomers SET memberid='".$member."',memberflag='0',MembershipDateTime='".$date."' WHERE CustomerID='".$custid."'";
							           ExecuteNQ($sqlUpdate2);
									  
									  
									   
								   	$sqlInsertchargesd = "INSERT INTO tblCustomerMemberShip(CustomerID, MembershipID, StartDay,EndDay,Status) VALUES 
									('".$custid."', '".$member."', '".$date."','".$new_dated."','0')";
									$sqlInsertcharges."<br/>";
									ExecuteNQ($sqlInsertchargesd);
								 $selp=select("Cost","tblMembership","MembershipID='".$member."'");
								 $total=$selp[0]['Cost'];
								   $sqlcharges = "Select ChargeNamesID , GROUP_CONCAT(distinct ChargeSetID) as ArrayChargeSet from tblCharges where 1";
					//echo $sqlcharges."<br>";
					$charges = $DB->query($sqlcharges);
						if ($charges->num_rows > 0) 
						{
							while($row = $charges->fetch_assoc())
							{
								$ChargeNameId = $row["ChargeNamesID"];
								$ArrayChargeSet = $row["ArrayChargeSet"];
								$strChargeSet = explode(",",$ArrayChargeSet);
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
								$totalst = $total;
								if($strChargeFPType == "0")
								{
									$strChargeAmt = $strChargeAmt;
								}
								else
								{
									
									$percentage = $strChargeAmt;
									//echo "percentage=".$percentage."<br/>";
									 $outof = $totalst;
									 //echo "ServiceCost=".$ServiceCost."<br/>";
								 $strChargeAmt = ($percentage / 100) * $outof;
								 	 //echo "strChargeAmt=".$strChargeAmt."<br/>";
								
								
								
								}
							$totalamt=$strChargeAmt;
							
										 $sqlInsert3 = "Insert into tblAppointmentsChargesInvoice(AppointmentID,AppointmentDetailsID,ChargeName,ChargeAmount,TaxGVANDM) values('".$app_id."','0','".$strSetName."','".$totalamt."','0')";
								
				if ($DB->query($sqlInsert3) === TRUE) 
							{
								$last_idpt = $DB->insert_id;		//last id of tblCustomers insert
							}
									
										
										}
									}
								}
						unset($strChargeSet);
						          $seldoffert=select("*","tblAppointments","AppointmentID='".$app_id."'");
														
								     $FreeService=$seldoffert[0]['FreeService'];
						             if($FreeService!="0")
									 {
										 
									 }
									 else
									 {
										 $sqlUpdate1 = "UPDATE tblAppointments SET memberid='".$member."' WHERE AppointmentID='".$app_id."'";
									ExecuteNQ($sqlUpdate1);
									 }
								
									
						
									
									//  $DB->query($sqlInsert1); 
									  if ($DB->query($sqlUpdate1) === TRUE) 
										{
											echo 2;
										}
								   }	
					
						 
                    
                     } 
					else
					{
						
									 if($offerid!="0")
									{
										 echo 4;
									}
							     elseif($cntttp>0)
								   {
								       if($date>=$enddate)
									  {
										 
											  echo 6;
										  
									  }
									  else
									  {
										  	 $sqlUpdate2 = "UPDATE tblCustomers SET memberid='".$member."',memberflag='0',MembershipDateTime='".$date."' WHERE CustomerID='".$custid."'";
							ExecuteNQ($sqlUpdate2);
							 $seldoffert=select("*","tblAppointments","AppointmentID='".$app_id."'");
														
								     $FreeService=$seldoffert[0]['FreeService'];
						             if($FreeService!="0")
									 {
										 
									 }
									 else
									 {
										 $sqlUpdate1 = "UPDATE tblAppointments SET memberid='".$member."' WHERE AppointmentID='".$app_id."'";
							ExecuteNQ($sqlUpdate1);
									 }
								
							
							 $selp=select("Cost","tblMembership","MembershipID='".$member."'");
								 $total=$selp[0]['Cost'];
							   $sqlcharges = "Select ChargeNamesID , GROUP_CONCAT(distinct ChargeSetID) as ArrayChargeSet from tblCharges where 1";
					//echo $sqlcharges."<br>";
					$charges = $DB->query($sqlcharges);
						if ($charges->num_rows > 0) 
						{
							while($row = $charges->fetch_assoc())
							{
								$ChargeNameId = $row["ChargeNamesID"];
								$ArrayChargeSet = $row["ArrayChargeSet"];
								$strChargeSet = explode(",",$ArrayChargeSet);
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
								$totalst = $total;
								if($strChargeFPType == "0")
								{
									$strChargeAmt = $strChargeAmt;
								}
								else
								{
									
									$percentage = $strChargeAmt;
									//echo "percentage=".$percentage."<br/>";
									 $outof = $totalst;
									 //echo "ServiceCost=".$ServiceCost."<br/>";
								 $strChargeAmt = ($percentage / 100) * $outof;
								 	 //echo "strChargeAmt=".$strChargeAmt."<br/>";
								
								
								
								}
							$totalamt=$strChargeAmt;
							
										 $sqlInsert3 = "Insert into tblAppointmentsChargesInvoice(AppointmentID,AppointmentDetailsID,ChargeName,ChargeAmount,TaxGVANDM) values('".$app_id."','0','".$strSetName."','".$totalamt."','0')";
								
				if ($DB->query($sqlInsert3) === TRUE) 
							{
								$last_idpt = $DB->insert_id;		//last id of tblCustomers insert
							}
									
										
										}
									}
								}
						unset($strChargeSet);
						
				      			   	$sqlInsertchargesd = "INSERT INTO tblCustomerMemberShip(CustomerID, MembershipID, StartDay,EndDay,Status) VALUES 
									('".$custid."', '".$member."', '".$date."','".$new_dated."','0')";
									$sqlInsertcharges."<br/>";
									ExecuteNQ($sqlInsertchargesd);
							
							//  $DB->query($sqlInsert1); 
							  if ($DB->query($sqlUpdate1) === TRUE) 
								{
									echo 2;
								}
									  }
									   
								   }
							else
							{
								
						 $sqlUpdate2 = "UPDATE tblCustomers SET memberid='".$member."',memberflag='0',MembershipDateTime='".$date."' WHERE CustomerID='".$custid."'";
							ExecuteNQ($sqlUpdate2);
							 $seldoffert=select("*","tblAppointments","AppointmentID='".$app_id."'");
														
								     $FreeService=$seldoffert[0]['FreeService'];
						             if($FreeService!="0")
									 {
										 
									 }
									 else
									 {
										 $sqlUpdate1 = "UPDATE tblAppointments SET memberid='".$member."' WHERE AppointmentID='".$app_id."'";
							ExecuteNQ($sqlUpdate1);
									 }
								
							
							 $selp=select("Cost","tblMembership","MembershipID='".$member."'");
								 $total=$selp[0]['Cost'];
							   $sqlcharges = "Select ChargeNamesID , GROUP_CONCAT(distinct ChargeSetID) as ArrayChargeSet from tblCharges where 1";
					//echo $sqlcharges."<br>";
					$charges = $DB->query($sqlcharges);
						if ($charges->num_rows > 0) 
						{
							while($row = $charges->fetch_assoc())
							{
								$ChargeNameId = $row["ChargeNamesID"];
								$ArrayChargeSet = $row["ArrayChargeSet"];
								$strChargeSet = explode(",",$ArrayChargeSet);
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
								$totalst = $total;
								if($strChargeFPType == "0")
								{
									$strChargeAmt = $strChargeAmt;
								}
								else
								{
									
									$percentage = $strChargeAmt;
									//echo "percentage=".$percentage."<br/>";
									 $outof = $totalst;
									 //echo "ServiceCost=".$ServiceCost."<br/>";
								 $strChargeAmt = ($percentage / 100) * $outof;
								 	 //echo "strChargeAmt=".$strChargeAmt."<br/>";
								
								
								
								}
							$totalamt=$strChargeAmt;
							
										 $sqlInsert3 = "Insert into tblAppointmentsChargesInvoice(AppointmentID,AppointmentDetailsID,ChargeName,ChargeAmount,TaxGVANDM) values('".$app_id."','0','".$strSetName."','".$totalamt."','0')";
								
				if ($DB->query($sqlInsert3) === TRUE) 
							{
								$last_idpt = $DB->insert_id;		//last id of tblCustomers insert
							}
									
										
										}
									}
								}
						unset($strChargeSet);
						
				      			   	$sqlInsertchargesd = "INSERT INTO tblCustomerMemberShip(CustomerID, MembershipID, StartDay,EndDay,Status) VALUES 
									('".$custid."', '".$member."', '".$date."','".$new_dated."','0')";
									$sqlInsertcharges."<br/>";
									ExecuteNQ($sqlInsertchargesd);
							
							//  $DB->query($sqlInsert1); 
							  if ($DB->query($sqlUpdate1) === TRUE) 
								{
									echo 2;
								}
							}
						 
							
					}

											   }
											   else
											   {
												    if($VoucherID!="0")
													   {
														  
													    echo 8;
													   }
													 elseif($PackageID!="0")
													 {
														   echo 7;
													 }
											   }
				
					
				   
					
						$DB->close();
	}
			
			
			
			
			?>