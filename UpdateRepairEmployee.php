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
		
		$empid = $_POST["empid"];
	    $service = $_POST["service"];
	    $app = $_POST["app"];
		$test=explode("#",$service);
		$servicee=$test[0];
		$qty=$test[2];
		$qtyparam=$_POST["qtyparam"];
		
		
		    $DB = Connect();
			$sql11="delete from tblAppointmentAssignEmployee where AppointmentID='".$app."' and ServiceID='".$servicee."' and Qty='".$qty."' and QtyParam='".$qtyparam."'";
			 ExecuteNQ($sql11);
			   if($FreeService!="0")
			 {
				   $sqlInsert2 = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID, ServiceID, MECID, Commission,FreeService,Qty,QtyParam) VALUES('".$app."', '".$servicee."', '0', '0','1','".$qty."','".$qtyparam."')";
				   ExecuteNQ($sqlInsert2);
			 	echo 2;
			 }
			 else
			 {
				   $sqlInsert2 = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID, ServiceID, MECID, Commission,Qty,QtyParam) VALUES
						('".$app."', '".$servicee."', '0', '0','".$qty."','".$qtyparam."')";
						ExecuteNQ($sqlInsert2);
			 	echo 2;
			 }
			

						$DB->close();
	}
			
			
			
			
			?>