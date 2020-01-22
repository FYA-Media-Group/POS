<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
$DB = Connect();
	$offervalue = $_POST["offervalue"];
		$app_id = $_POST["app_id"];
			 $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."'");
											   $cntserp=$sepcont[0]['count(*)'];
											   if($cntserp>0)
											   {
if($offervalue=="")
		 {
			$data=6;
		}
		else
		{
			
	$seldata=select("*","tblOffers","OfferCode='$offervalue'");
    $off_id=$seldata[0]['OfferID'];
	$BaseAmount=$seldata[0]['BaseAmount'];
	if($off_id!="")
	{
		$sqlUpdate = "UPDATE tblAppointments SET offerid='0' WHERE AppointmentID='".$app_id."'";
	    ExecuteNQ($sqlUpdate);   
       		$seldatap=select("*"," tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."'");	
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
						
							 $sqlUpdate1 = "UPDATE  tblAppointmentsChargesInvoice SET ChargeAmount='".$totalamt."' WHERE AppointmentDetailsID='".$AppointmentDetailsID."'";

					      ExecuteNQ($sqlUpdate1);
							}
						}
					}
			unset($strChargeSet);
					
				}
					
		
        $data="update";		
	}
	else
	{
		$data="";
	}
	
	
	
	$DB->close();
		}
											   }
											   else
											   {
												   
											   }
		
	
	echo $data;
?>

					
