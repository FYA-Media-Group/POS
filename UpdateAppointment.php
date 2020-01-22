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
		
			$DB = Connect();
					  
			 $sqlUpdate = "UPDATE tblAppointments SET IsDeleted='1' WHERE AppointmentID='".$app_id."'";
			if ($DB->query($sqlUpdate) === TRUE) 
				{
					$last_id = $DB->insert_id;
					echo 2;
				}
				else
				{
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
		
					
		             
						$DB->close();
	}
			
			
			
			
			?>