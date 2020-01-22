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
$date=date('Y-m-d');
		
			$DB = Connect();
			
		
				$seldatap=select("CustomerID","tblAppointments","AppointmentID='".$app_id."'");	
				$custid=$seldatap[0]['CustomerID'];
				
				
				$seldatapp=select("memberid","tblCustomers","CustomerID='".$custid."'");	
				$memid=$seldatapp[0]['memberid'];
					$seldatapttpt=select("*","tblCustomerMemberShip","CustomerID='".$custid."'");	
					//print_r($seldataptt);
					
					 $enddate=$seldatapttpt[0]['EndDay'];
				 $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."'");
											   $cntserp=$sepcont[0]['count(*)'];
											   if($cntserp>0)
											   {
												   if($memid!="0")
				{
					$seldataptt=select("*","tblCustomerMemberShip","CustomerID='".$custid."'");	
					//print_r($seldataptt);
					$status=$seldataptt[0]['Status'];
					 $enddate=$seldataptt[0]['EndDay'];
					 
					if($status=='1')
					{
						$seldatapttp=select("memberid","tblAppointments","AppointmentID='".$app_id."'");
					$memberidd=$seldatapttp[0]['memberid'];
						if($memberidd!='' && $memberidd!='0')
						{
							echo "Absent";
							
						
							
						}
				     else
						{
							
							echo "Present";
						
							
						}
					}
					else
					{
						$seldatapttp=select("memberid","tblAppointments","AppointmentID='".$app_id."'");
						$memberidd=$seldatapttp[0]['memberid'];
						if($memberidd!='' || $memberidd!='0')
						{
							echo "Absent";
							
							
						}
					else
						{
							echo "Present";
							
						}
					
					}
				
				}
				else
				{
				
					echo "Already";
				}
											   }
											   else
											   {
												   	echo "Already";
											   }
				
					
				
				
				
				
				
						
						$DB->close();
	}
			
			
			
			//echo $data;
			?>
		