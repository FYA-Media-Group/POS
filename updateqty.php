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
		
       $qty = $_POST["qty"];
		$amt = $_POST["amt"];
		$serviceid = $_POST["serviceid"];
	   $app_id = $_POST["app_id"];
	    $idd = $_POST["idd"];
	   
	 	$DB = Connect();
       $selp=select("*","tblAppointments","AppointmentID='".$app_id."'");
	  $memberid=$selp[0]['memberid'];
	  $offerid=$selp[0]['offerid'];
	  $VoucherID=$selp[0]['VoucherID'];
	  $FreeService=$selp[0]['FreeService'];
	   if($memberid!='0')
	   {
		   echo 3;
	   }
	   elseif($offerid!='0')
	   {
		    echo 3;
	   }
	   elseif($VoucherID!='0')
	   {
		   echo 3;
	   }
	   else
	   {
		   $selpw=select("*","tblServices","ServiceID='".$serviceid."'");
$ServiceCost = $selpw[0]["ServiceCost"];
  
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
							$totalamt=$strChargeAmt*$qty;
						
							 $sqlUpdate1 = "UPDATE  tblAppointmentsChargesInvoice SET ChargeAmount='".$totalamt."' WHERE AppointmentDetailsID='".$idd."'";

					      ExecuteNQ($sqlUpdate1);
							}
						}
					}
			unset($strChargeSet);
			
			
			
					  
	 $sqlUpdate = "UPDATE tblAppointmentsDetailsInvoice SET qty='".$qty."' WHERE AppointmentDetailsID='".$idd."'";
 //echo $sqlUpdate;
				ExecuteNQ($sqlUpdate);
					//  $DB->query($sqlInsert1); 
		          
						
			$sqlDelete = "DELETE FROM tblAppointmentAssignEmployee WHERE AppointmentID='".$app_id."' and ServiceID='".$serviceid."'";
		    ExecuteNQ($sqlDelete);	
                         if($FreeService!="0")
									 {			
		    $sqlInsert2 = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID, ServiceID, MECID, Commission,Qty,FreeService) VALUES('".$app_id."', '".$serviceid."', '0', '0','".$qty."','1')";
			ExecuteNQ($sqlInsert2);	
									 }
									 else
									 {
	        $sqlInsert2 = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID, ServiceID, MECID, Commission,Qty) VALUES('".$app_id."', '".$serviceid."', '0', '0','".$qty."')";
			ExecuteNQ($sqlInsert2);	 
									 }
									 
			$selpqi=select("*","tblAppointmentAssignEmployee","AppointmentID='".$app_id."' and ServiceID='".$serviceid."'");
					$qtyu=$selpqi[0]['Qty'];
					 if($qtyu=='1')
					 {
						$sqlUpdate1 = "UPDATE tblAppointmentAssignEmployee SET QtyParam='".$qtyu."' WHERE AppointmentID='".$app_id."' and ServiceID='".$serviceid."'";
					ExecuteNQ($sqlUpdate1);
					 }
					 elseif($qtyu=='0')
					 {
						// nothimng 
					 }
					 else
					 {
						 //echo 11;
						 $sqlUpdate1 = "UPDATE tblAppointmentAssignEmployee SET QtyParam='".$qtyu."' WHERE AppointmentID='".$app_id."' and ServiceID='".$serviceid."'";
						//echo $sqlUpdate1;
					    ExecuteNQ($sqlUpdate1);
						 //UPDATE PARAM 
						for($i=1;$i<$qtyu;$i++)
						{
							
							 if($FreeService!="0")
									 {
							$sqlInsert3ptr = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID,ServiceID, Qty,QtyParam,MECID,Commission,FreeService) VALUES 
									('".$app_id."', '".$serviceid."','".$qtyu."','".$i."','0','0','1')";
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
									('".$app_id."', '".$serviceid."','".$qtyu."','".$i."','0','0','0')";
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
						
					    if ($DB->query($sqlUpdate) === TRUE) 
						{
							echo 2;
						} 
						$DB->close();	
	   }
		
		
		

	}
			
			
			
			
			?>