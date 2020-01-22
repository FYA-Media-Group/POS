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
		
			$DB = Connect();
		$comm = $_POST["comm"];
		$eid = $_POST["eid"];
		$serviceid = $_POST["serviceid"];
		$app_id = $_POST["app_id"];
	
		
		$sep=select("count(AppointmentAssignEmployeeID)","tblAppointmentAssignEmployee","AppointmentID='".$app_id."' and ServiceID='".$serviceid."' and MECID='".$eid."'");
		$cnt=$sep[0]['count(AppointmentAssignEmployeeID)'];
		if($cnt>0)
		{
				//echo 123;
					 $sqlUpdate = "UPDATE  tblAppointmentAssignEmployee SET Commission='".$comm."' WHERE ServiceID='".$serviceid."' and AppointmentID='".$app_id."' and MECID='".$eid."'";
		//	echo $sqlUpdate;
			
					ExecuteNQ($sqlUpdate);
					  if ($DB->query($sqlUpdate) === TRUE) 
						{
							echo 2;
						}
		}
		else
		{
			  $sqlInsert1 = "Insert into tblAppointmentAssignEmployee(AppointmentID,ServiceID,MECID,Commission) values('".$app_id."','".$serviceid."','".$eid."','".$comm."')";
					
					//  $DB->query($sqlInsert1); 
		              if ($DB->query($sqlInsert1) === TRUE) 
						{
							echo 2;
						}
		}
		
		
	
			
	}
			$DB->close();	
			
			
			
			?>