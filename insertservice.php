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
		
		$serviceid = $_POST["serviceid"];
	    $app_id = $_POST["app_id"];
	    $seld=select("*","tblServices","ServiceID='".$serviceid."'");
		$servicename=$seld[0]['ServiceName'];
		$ServiceCode=$seld[0]['ServiceCode'];

			$DB = Connect();
		

  $selp=select("*","tblAppointments","AppointmentID='".$app_id."'");
  $memberid=$selp[0]['memberid'];
  $offerid=$selp[0]['offerid'];
  $VoucherID=$selp[0]['VoucherID'];
  $FreeService=$selp[0]['FreeService'];
	
		  
                  $sep=select("StoreID","tblAppointments","AppointmentID='".$app_id."'");
					  $storee=$sep[0]['StoreID'];
					  
					  $sept=select("ServiceCost","tblServices","ServiceID='".$serviceid."'");
					  $ServiceCost=$sept[0]['ServiceCost'];
					  
					   $septcnt=select("count(*)","tblAppointmentsDetailsInvoice","ServiceID='".$serviceid."' and AppointmentID='".$app_id."'");
					  $sercnt=$septcnt[0]['count(*)'];
					  if($sercnt>0)
					  {
						  echo 3;
					  }
					  else
					  {
						  $sqlInsert1 = "Insert into tblAppointmentsDetailsInvoice(AppointmentID, ServiceID, ServiceAmount,qty,Status) values('".$app_id."','".$serviceid."', '".$ServiceCost."','1','1')";
							 //$DB->query($sqlInsert1); 
							 if ($DB->query($sqlInsert1) === TRUE) 
							{
								$last_id7 = $DB->insert_id;		//last id of tblAppointments insert
							
							
									
							
								$sqlcharges = "Select ChargeNameId , (select GROUP_CONCAT(distinct ChargeSetID) from tblCharges where 
								ChargeNameID=tblServicesCharges.ChargeNameID) as ArrayChargeSet from tblServicesCharges where ServiceID= '".$serviceid."'";
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
								
									 $totalamt=$strChargeAmt*1;
									
										$sqlInsertchargesd = "INSERT INTO tblAppointmentsChargesInvoice(AppointmentDetailsID, ChargeName, ChargeAmount,AppointmentID,TaxGVANDM) VALUES 
									('".$last_id7."', '".$strSetName."', '".$totalamt."','".$app_id."','2')";
									$sqlInsertcharges."<br/>";
									ExecuteNQ($sqlInsertchargesd);
							}
						}
						
								
					}
					 if($FreeService!="0")
									 {
			 $sqlInsert2 = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID, ServiceID, MECID, Commission,Qty,QtyParam,FreeService) VALUES('".$app_id."', '".$serviceid."', '0', '0','1','1','1')";
						ExecuteNQ($sqlInsert2);
									 }
							      else
									 {
						 $sqlInsert2 = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID, ServiceID, MECID, Commission,Qty,QtyParam) VALUES('".$app_id."', '".$serviceid."', '0', '0','1','1')";
						ExecuteNQ($sqlInsert2); 
									 }
						
						unset($strChargeSet);
							echo 2;
							}
							else
							{
								echo "Error: " . $sqlInsert1 . "<br>" . $conn->error;
							}
					  }
				
					  
						  
				 
				 
				 
				 
				 
				
						
	 	  
						
						$DB->close();
	}
			
			
			
			
			?>