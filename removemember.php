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

        $date=date('Y-m-d');
		
			$DB = Connect();
					$seldatap=select("*","tblAppointments","AppointmentID='".$app_id."'");	
				$custid=$seldatap[0]['CustomerID'];
				$memberid=$seldatap[0]['memberid'];
				$packid=$seldatap[0]['PackageID']; 
			 $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."'");
											   $cntserp=$sepcont[0]['count(*)'];
											   if($cntserp>0)
											   {
			
				  $sqlUpdate2 = "UPDATE tblAppointments SET offerid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate2);
					
					
					$seldataptt=select("Status","tblCustomerMemberShip","CustomerID='".$custid."' and Status='1'");	
				
					
						$status=$seldataptt[0]['Status'];
						if($status=='1')
						{
							
					  
					 $sqlDelete1 = "DELETE FROM tblAppointmentsChargesInvoice WHERE AppointmentID='".$app_id."' and TaxGVANDM='0'";
					//  echo $sqlDelete;
		          ExecuteNQ($sqlDelete1);
					  
					  $seldatap=select("*","tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."' and PackageService='0'");	
				foreach($seldatap as $val)	
				{
					$AppointmentDetailsID=$val['AppointmentDetailsID'];
					$ServiceID=$val['ServiceID'];
					$ServiceAmount=$val['ServiceAmount'];
					$qty=$val['qty'];
				
														
						
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
								$ServiceCost = $ServiceAmount;
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
							$totalamt=$strChargeAmt*$qty;
						
							 $sqlUpdate1 = "UPDATE  tblAppointmentsChargesInvoice SET ChargeAmount='".$totalamt."' WHERE AppointmentDetailsID='".$AppointmentDetailsID."' and PackageID='0'";

					      ExecuteNQ($sqlUpdate1);
							}
						}
					}
			unset($strChargeSet);
					
				}
					$sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
						//	ExecuteNQ($sqlUpdate);
							//  $DB->query($sqlInsert1); 
							  if ($DB->query($sqlUpdate) === TRUE) 
								{
									echo 2;
								}
				
						}
						else
						{
							
						  $sqlUpdate2 = "UPDATE tblCustomers SET memberid='0',memberflag='0',MembershipDateTime='0000-00-00' WHERE CustomerID='".$custid."'";
						//$sqlUpdate2 = "UPDATE tblCustomers SET memberflag='0',MembershipDateTime='0000-00-00' WHERE CustomerID='".$custid."'";
					ExecuteNQ($sqlUpdate2);
				  $sqlDelete4 = "DELETE FROM tblCustomerMemberShip WHERE CustomerID='".$custid."' and Status='0'";
				 //echo $sqlDelete4;
		              ExecuteNQ($sqlDelete4);
				
					  
					$sqlDelete1 = "DELETE FROM tblAppointmentsChargesInvoice WHERE AppointmentID='".$app_id."' and TaxGVANDM='0'";
				  //echo $sqlDelete1;
		             ExecuteNQ($sqlDelete1);
					  
					  $seldatap=select("*","tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."' and PackageService='0'");	
				foreach($seldatap as $val)	
				{
					$AppointmentDetailsID=$val['AppointmentDetailsID'];
					$ServiceID=$val['ServiceID'];
					$ServiceAmount=$val['ServiceAmount'];
					$qty=$val['qty'];
				
														
						
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
								$ServiceCost = $ServiceAmount;
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
							$totalamt=$strChargeAmt*$qty;
						
							 $sqlUpdate1 = "UPDATE  tblAppointmentsChargesInvoice SET ChargeAmount='".$totalamt."' WHERE AppointmentDetailsID='".$AppointmentDetailsID."' and PackageID='0'";

					      ExecuteNQ($sqlUpdate1);
							}
						}
					}
			unset($strChargeSet);
					
				}
					
			
			
			$sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
						//	ExecuteNQ($sqlUpdate);
							//  $DB->query($sqlInsert1); 
							  if ($DB->query($sqlUpdate) === TRUE) 
								{
									echo 2;
								}
					
					
					
						}
											   }
                                               else
											   {
												
											   }												   
					
						
				
			   
	}
			
			
			
			
			?>