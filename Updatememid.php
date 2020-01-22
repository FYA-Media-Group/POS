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
		$DB = Connect();
	  $selp=select("*","tblAppointments","AppointmentID='".$app_id."'");
	  $memberid=$selp[0]['memberid'];
	  $offerid=$selp[0]['offerid'];
	  $VoucherID=$selp[0]['VoucherID'];
	  $PackageID=$selp[0]['PackageID'];
	  $custid=$selp[0]['CustomerID'];
	  $seldatapttptqppp=select("count(*)","tblCustomerMemberShip","CustomerID='".$custid."'");
      $cntttp=$seldatapttptqppp[0]['count(*)'];
	  $sepptu=select("*","tblCustomerMemberShip","CustomerID='".$custid."'");
	  $enddate=$sepptu[0]['EndDay'];
	  $RenewStatus=$sepptu[0]['RenewStatus'];
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
	  elseif($cntttp>0)
		{
		if($date>=$enddate)
	      {
		
		 echo 6;
		 
		  }
		  else
		  {
			   $sqlUpdate2 = "UPDATE tblAppointments SET offerid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate2);
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='".$mem."' WHERE AppointmentID='".$app_id."'";
					//ExecuteNQ($sqlUpdate);
					//  $DB->query($sqlInsert1); 
		              if ($DB->query($sqlUpdate) === TRUE) 
						{
							echo 2;
						}
		  }
									   
		}
	   else
	   {
               		     
					  $sqlUpdate2 = "UPDATE tblAppointments SET offerid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate2);
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='".$mem."' WHERE AppointmentID='".$app_id."'";
					//ExecuteNQ($sqlUpdate);
					//  $DB->query($sqlInsert1); 
		              if ($DB->query($sqlUpdate) === TRUE) 
						{
							echo 2;
						}
						$DB->close();
	   }
											   }
											   else
											   {
												   if($VoucherID!="0")
													   {
														  
													    echo 3;
													   }
													 elseif($PackageID!="0")
													 {
														   echo 7;
													 }
											   }
                                         											   
					
	
	}
			
			
			
			
			?>