<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?php	$DB = Connect();	// echo "Hello<br>";
	$TotalAmountforsms="Select PaidAmount, PendingAmount,AppointmentID from tblPendingPayments where AppointmentID='".DecodeQ($_GET['uid'])."'";
	// echo $TotalAmountforsms."<br>";
	$RStotalpayment = $DB->query($TotalAmountforsms);
	if ($RStotalpayment->num_rows > 0) 
	{
		while($rowtotalpayment = $RStotalpayment->fetch_assoc())
		{
			$strPaidAmount = $rowtotalpayment["PaidAmount"];
			$strPendingAmount = $rowtotalpayment["PendingAmount"];
			$strAppointmentID = $rowtotalpayment["AppointmentID"];
			// echo "AppointmentID is = ".$strAppointmentID."<br>";
			// echo "Pending Amount is = ".$strPendingAmount."<br>";			
			// echo "Paid Amount is = ".$strPaidAmount."<br>";
		}
	}	
	
	if($strAppointmentID!="")	
	{		
		$SMSAmount=$strPaidAmount;		
		// echo $SMSAmount."In if";	
		$strCustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];			
		$SMSContentforBilling="Dear ".$seldpdep[0]['CustomerFullName'].", Received Amount of Rs. ".$SMSAmount.". Thank You. Rate your visit
and help us to make your experience flawless. http://nailspaexperience.com/";
		$SendSMS = CreateSMSURL("Nailspa Experience","0","0",$SMSContentforBilling,$strCustomerMobileNo);	
		// echo $CustomerFullName."<br>";
		// echo $SMSAmount."<br>";
	}	
	else	
	{		
		// echo "In else<br>";
		$SelectPayment="Select TotalPayment from tblInvoiceDetails where AppointmentID='".DecodeQ($_GET['uid'])."'";	
// echo $SelectPayment;		
		$RStotal = $DB->query($SelectPayment);		
		if ($RStotal->num_rows > 0) 		
		{		
			// echo "In if<br>";
			while($rowtotal = $RStotal->fetch_assoc())			
			{			
				// echo "In while<br>";
				$SMSAmount = $rowtotal["TotalPayment"];				
				// echo "In else";	
				$strCustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];				
				$SMSContentforBilling="Dear ".$seldpdep[0]['CustomerFullName'].", Received Amount of Rs. ".$SMSAmount.". Thank You. Rate your visit
and help us to make your experience flawless. http://nailspaexperience.com/";
				
				// echo $SMSContentforBilling."<br>";
				
				$SendSMS = CreateSMSURL("Nailspa Experience","0","0",$SMSContentforBilling,$strCustomerMobileNo);	

				
				// echo $strCustomerMobileNo."<br>";
				// echo $seldpdep[0]['CustomerFullName']."<br>";
				// echo "Amount is ".$SMSAmount."<br>";
			}		
		}	
	}
?>
