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
	$sericesd=array();
	//$services=array();
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
// code for not allowing the normal admin to access the super admin rights	


	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		

	$app_idd = $_POST["app_idd"];
	$gift = $_POST["gift"];
   
		
			$DB = Connect();
			
				 $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."'");
											   $cntserp=$sepcont[0]['count(*)'];
											
												   		if($gift!="0")
			{
				 $sqlUpdate = "UPDATE tblAppointments SET VoucherID='0' WHERE AppointmentID='".$app_idd."'";
					ExecuteNQ($sqlUpdate);
				//	echo $sqlUpdate;
					  $sqlDelete = "DELETE FROM tblGiftVouchers WHERE GiftVoucherID='".$gift."'";
					//  echo $sqlDelete;
		              ExecuteNQ($sqlDelete);
					  
					  
					 
		       $sqlDelete1 = "DELETE FROM tblAppointmentsChargesInvoice WHERE AppointmentID='".$app_idd."' and TaxGVANDM='1'";
					//  echo $sqlDelete;
		              ExecuteNQ($sqlDelete1);
					$data=3;
			}
			else
			{
				$data=1;
			}
											  
		echo $data;
				
						$DB->close();
	}
			
			
			
			//echo $data;
			?>
		