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
		

	$app_id = $_POST["app_id"];

		
			$DB = Connect();
			
		
				$seldatap=select("GiftVoucherID","tblGiftVouchers","AppointmentID='".$app_id."'");	
				echo $GiftVoucherID=$seldatap[0]['GiftVoucherID'];
                
						
						
						$DB->close();
	}
			
			
			
			//echo $data;
			?>
		