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
		$DB = Connect();
		$PackageID = $_POST["packageid"];
	    $app_id = $_POST["app_id"];
	    $seld=select("*","tblPackages","PackageID='".$PackageID."'");
	    $ServiceID=$seld[0]['ServiceID'];
		$PackageNewPrice=$seld[0]['PackageNewPrice'];
		$Validityp=$seld[0]['Validity'];
				$valid="+".$Validityp."Months";
		        $validpack = date('Y-m-d', strtotime($valid));
				
	    $ServiceIDd=explode(",",$ServiceID);
		$selp=select("*","tblAppointments","AppointmentID='".$app_id."'");
		$memberid=$selp[0]['memberid'];
		$offerid=$selp[0]['offerid'];
		$VoucherID=$selp[0]['VoucherID'];
	    $sep=select("*","tblAppointments","AppointmentID='".$app_id."'");
	    $storee=$sep[0]['StoreID'];
		$oldpackage=$sep[0]['PackageID'];
		$packages=$oldpackage.",".$PackageID;
	
					 
					for($u=0;$u<count($ServiceIDd);$u++)
					{
					  $sept=select("ServiceCost","tblServices","ServiceID='".$ServiceIDd[$u]."'");
					  $ServiceCost=$sept[0]['ServiceCost'];
					  $sqlInsert1 = "Insert into tblAppointmentsDetailsInvoice(AppointmentID, ServiceID, ServiceAmount,qty,Status,PackageService) values('".$app_id."','".$ServiceIDd[$u]."', '".$ServiceCost."','1','1','".$PackageID."')";
						 if ($DB->query($sqlInsert1) === TRUE) 
							{
								$last_id7 = $DB->insert_id;	
							}
							else
							{
								echo "Error: " . $sqlInsert1 . "<br>" . $conn->error;
							}
				 
							
					}
					
					 $sqlInsertpq = "Insert into tblAppointmentPackageValidity(AppointmentID,PackageID,ValidTill) values('".$app_id."','".$PackageID."', '".$validpack."')";
						 if ($DB->query($sqlInsertpq) === TRUE) 
							{
								$last_id90 = $DB->insert_id;	
							}
							else
							{
								echo "Error: " . $sqlInsertpq . "<br>" . $conn->error;
							}	
								
							
								$sqlcharges = "Select ChargeNameId , (select GROUP_CONCAT(distinct ChargeSetID) from tblCharges where 
								ChargeNameID=tblServicesCharges.ChargeNameID) as ArrayChargeSet from tblServicesCharges";
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
											$PackageNewPrice = $PackageNewPrice;
											if($strChargeFPType == "0")
											{
												$strChargeAmt = $strChargeAmt;
											}
											else
											{
												
												$percentage = $strChargeAmt;
												//echo "percentage=".$percentage."<br/>";
												 $outof = $PackageNewPrice;
												 //echo "ServiceCost=".$ServiceCost."<br/>";
											 $strChargeAmt = ($percentage / 100) * $outof;
												 //echo "strChargeAmt=".$strChargeAmt."<br/>";
											
											}
											
												 $totalamt=$strChargeAmt*1;
												
												$sqlInsertchargesd = "INSERT INTO tblAppointmentsChargesInvoice(AppointmentDetailsID, ChargeName, ChargeAmount,AppointmentID,TaxGVANDM,PackageID) VALUES 
												('".$last_id7."', '".$strSetName."', '".$totalamt."','".$app_id."','3','".$PackageID."')";
												
												ExecuteNQ($sqlInsertchargesd);
										}
									}
									
											
								}
					unset($strChargeSet);
					
					
									 
						              
										$sqlUpdate = "UPDATE tblAppointments SET PackageID='".$packages."' WHERE AppointmentID='".$app_id."'";
									  ExecuteNQ($sqlUpdate);
						//	echo $sqlInsert2;
						
							
					
					echo 2;
					unset($ServiceIDd);
					
				$DB->close();
	}
			
			
			
			
			?>