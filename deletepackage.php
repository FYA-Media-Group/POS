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
	    $idd = $_POST["idd"];
	
	        $DB = Connect();
			$seldpdeptwp=select("*","tblPackages","PackageID='".$idd."'");
			$seer=$seldpdeptwp[0]['ServiceID'];
			$services=explode(",",$seer);
		
			for($i=0;$i<count($services);$i++)
			{
				$sql12="delete from tblAppointmentAssignEmployee where AppointmentID='".$app_id."' and ServiceID='".$services[$i]."'";
			   ExecuteNQ($sql12);
			   
			}  
	
			$sql11="delete from tblAppointmentsDetailsInvoice where AppointmentID='".$app_id."' and PackageService='".$idd."'";
			ExecuteNQ($sql11);
		    $sql12="delete from tblAppointmentsChargesInvoice where AppointmentID='".$app_id."' and PackageID='".$idd."'";
			ExecuteNQ($sql12);
			$sql14="delete from tblAppointmentPackageValidity where AppointmentID='".$app_id."' and PackageID='".$idd."'";
			ExecuteNQ($sql14);
			
			
		     $sql13="delete from tblBillingPackage where AppointmentID='".$app_id."' and PackageID='".$idd."' ";
			ExecuteNQ($sql13);
			$seldpdeptwpq=select("*","tblAppointments","AppointmentID='".$app_id."'");
			$packid=$seldpdeptwpq[0]['PackageID'];
			$packop=explode(",",$packid);
            $cntp=count($packop);
			if($cntp>1)
			{
				for($u=0;$u<count($packop);$u++)
				{
					if($idd==$packop[$u])
					{
						//$up=$packop[$u].",".'0';
					}
					else
					{
						$up=$packop[$u];
					}
				}
			
			//echo $up;
		     $sqlUpdate1 = "UPDATE tblAppointments SET PackageID='".$up."' WHERE AppointmentID='".$app_id."'";
		     ExecuteNQ($sqlUpdate1);	
			
			}
			else
			{
			$sqlUpdate1 = "UPDATE tblAppointments SET PackageID='0' WHERE AppointmentID='".$app_id."'";
		    ExecuteNQ($sqlUpdate1);	
			}
			
			
		echo 2;
		$DB->close();
	   
	}
			
			
			
			
			?>