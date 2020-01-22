<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>
	
<?php
 $DB = Connect();
	if(isset($_POST["id"]))
	{
		if(!empty($_POST["id"]))
		{
			$test = $_POST["id"];
			$store=$_POST["store"];
			$giftcvalidity="+".$_POST["giftcvalidity"]."Days";
		
			$app_id=$_POST["app_id"];
			$cust_id=$_POST["cust_id"];
			$date=date('Y-m-d');
			$datetime=date('Ymd');
		    $date2 = date('Y-m-d', strtotime($giftcvalidity));
		
			$selp=select("CustomerFullName","tblCustomers","CustomerID='".$cust_id."'");
			$cust_name=$selp[0]['CustomerFullName'];
            $t=time();
			$code='GV'.$datetime.$t;
			$codef=Encode($code);
		    $validty=$date2;
	


			 $total=$test;
	
				    
					
  $sqlInsert1 = "Insert into tblGiftVouchers(Date,CustomerID,StoreID,AppointmentID,Amount,RedemptionECode,Status,ValidityDate,RedemptionCode) values('".$date."','".$cust_id."','".$store."','".$app_id."','".$total."','".$codef."','0','".$validty."','".$code."')";
  
  
   	if ($DB->query($sqlInsert1) === TRUE) 
				{
					$last_idp = $DB->insert_id;		//last id of tblCustomers insert
				}
				
				
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
							
							 $sqlInsert3 = "Insert into tblAppointmentsChargesInvoice(AppointmentID,AppointmentDetailsID,ChargeName,ChargeAmount,TaxGVANDM) values('".$app_id."','0','".$strSetName."','0','1')";
                   // echo $sqlInsert3;
  
   	if ($DB->query($sqlInsert3) === TRUE) 
				{
					$last_idpt = $DB->insert_id;		//last id of tblCustomers insert
				}
						
							
							}
						}
					}
			unset($strChargeSet);
			
			
				
				
				 $sqlUpdate = "UPDATE tblAppointments SET VoucherID='".$last_idp."' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
$DB->close();			
		}
	}
	
?>


			