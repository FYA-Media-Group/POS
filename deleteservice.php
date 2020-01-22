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
		$idd = $_POST["idd"];
		
	    $seld=select("*","tblServices","ServiceID='".$serviceid."'");
		$servicename=$seld[0]['ServiceName'];
		
		$ServiceCode=$seld[0]['ServiceCode'];
		$ServiceCost=$seld[0]['ServiceCost'];
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
			        $sep=select("ServiceID","tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."'");
					$sqlDelete1 = "DELETE FROM tblAppointmentsChargesInvoice WHERE AppointmentDetailsID='".$idd."' and TaxGVANDM='2' and AppointmentID='".$app_id."'";
				    ExecuteNQ($sqlDelete1);
					$sqlDelete4 = "DELETE FROM tblAppointmentsChargesInvoice WHERE AppointmentDetailsID='".$idd."' and AppointmentID='".$app_id."'";
				    ExecuteNQ($sqlDelete4);
					$sqlDelete2 = "DELETE FROM tblAppointmentAssignEmployee WHERE AppointmentID='".$app_id."' and ServiceID='".$serviceid."'";
					ExecuteNQ($sqlDelete2);
					
					$sqlDelete = "DELETE FROM tblAppointmentsDetailsInvoice WHERE AppointmentDetailsID='".$idd."'";
			        ExecuteNQ($sqlDelete);
					  	echo 2;
					
					 
					  
					  
					
					  
					 
						
						
						$DB->close();
	   }
	}
			
			
			
			
			?>