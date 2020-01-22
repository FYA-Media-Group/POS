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
		
	$DB = Connect();
	$app_id = $_POST["app_id"];
	$giftname = $_POST["giftname"];
   	 $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."'");
											   $cntserp=$sepcont[0]['count(*)'];
											
												 
			if($giftname!="0")
			{
				
				
			 $sqlUpdate1 = "UPDATE tblGiftVouchers SET Status='0',RedempedBy='0',RedempedDateTime='0000-00-00' WHERE RedemptionCode='".$giftname."'";
					ExecuteNQ($sqlUpdate1);
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
		