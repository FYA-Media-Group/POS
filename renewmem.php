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
		
		$app_id = $_POST["app_id"];
        $mem = $_POST["mem"];
$date=date('Y-m-d');
				$new_date = strtotime(date("Y-m-d", strtotime($date)) . " +12 month");
		$new_dated = date("Y-m-d",$new_date);
			$DB = Connect();
	$selp=select("*","tblAppointments","AppointmentID='".$app_id."'");
	  $memberid=$selp[0]['memberid'];
	  $offerid=$selp[0]['offerid'];
	  $VoucherID=$selp[0]['VoucherID'];
	  $packid=$selp[0]['PackageID'];
	  	$custid=$selp[0]['CustomerID'];
		$sepptu=select("*","tblCustomerMemberShip","CustomerID='".$custid."'");
				    $enddate=$sepptu[0]['EndDay'];
					$RenewCount=$sepptu[0]['RenewCount'];
					$ExpireDate=$sepptu[0]['ExpireDate'];
					$RenewAmount=$sepptu[0]['RenewAmount'];
					  $FreeService=$selp[0]['FreeService'];
					  			 $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."' and PackageService='0'");
											   $cntserp=$sepcont[0]['count(*)'];
											   if($cntserp>0)
											   {
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
		
						             if($FreeService!="0")
									 {
										 
									 }
									 else
									 {
										$totalrenew=$RenewCount+1;
										 	$sqlUpdate2 = "UPDATE tblCustomers SET memberid='".$mem."',memberflag='0',MembershipDateTime='".$date."' WHERE CustomerID='".$custid."'";
							           ExecuteNQ($sqlUpdate2);
									  
									  $sqlUpdate3 = "UPDATE tblCustomerMemberShip SET MembershipID='".$mem."',StartDay='".$date."',EndDay='".$new_dated."',Status='1',RenewStatus='1',RenewCount='".$totalrenew."' WHERE CustomerID='".$custid."'";
							           ExecuteNQ($sqlUpdate3);
									   
									   if($ExpireDate!='0000-00-00')
									   {
										   $sepptue=select("*","tblMembership","MembershipID='".$mem."'");
				                         $Cost=$sepptue[0]['Cost'];
										 $totanew=$RenewAmount+$Cost;
										   $sqlUpdate4 = "UPDATE tblCustomerMemberShip SET RenewAmount='".$totanew."' WHERE CustomerID='".$custid."' and MembershipID='".$mem."'";
							           ExecuteNQ($sqlUpdate4);
									   }
								
										 $sqlUpdate1 = "UPDATE tblAppointments SET memberid='".$mem."' WHERE AppointmentID='".$app_id."'";
									//ExecuteNQ($sqlUpdate1);
									  if ($DB->query($sqlUpdate1) === TRUE) 
									{
										echo 2;
									}
									
									
									 }
	   }
											   }
											   else
											   {
												     if($packid!='0')
													   {
														   echo 4;
													   }
											   }
					 

								

	}
			
			
			
			
			?>