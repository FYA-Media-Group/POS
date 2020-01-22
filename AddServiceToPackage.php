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
		$PackageID = $_POST["packageid"];
	    $app_id = $_POST["app_id"];
		$validdate = $_POST["validdate"];
		$service = $_POST["service"];
		$store = $_POST["store"];
		$app_date = $_POST["app_date"];
		$date=date("Y-m-d");
		$selp=select("*","tblAppointments","AppointmentID='".$app_id."'");
	  $FreeService=$selp[0]['FreeService'];
		$seldata=select("ValidTill","tblAppointmentPackageValidity","AppointmentID='".$app_id."'");
	    $ValidTill=$seldata[0]['ValidTill'];
		 if($date>$ValidTill)
		 {
			 echo 3;
		 }
		 else
		 {
			
			 		  $sqlInsert1 = "Insert into tblBillingPackage(PackageID, AppointmentID, ServiceID,Status,StoreID,ValidityStart,ValidityEnd) values('".$PackageID."','".$app_id."', '".$service."','1','".$store."','".$app_date."','".$validdate."')";
						 if ($DB->query($sqlInsert1) === TRUE) 
							{
								$last_id7 = $DB->insert_id;	
									echo 2;
							}
							else
							{
								echo "Error: " . $sqlInsert1 . "<br>" . $conn->error;
							}
	             $sqlDelete = "DELETE FROM tblAppointmentAssignEmployee WHERE AppointmentID='".$app_id."' and ServiceID='".$service."'";
		    ExecuteNQ($sqlDelete);	
                         if($FreeService!="0")
									 {			
		    $sqlInsert2 = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID, ServiceID, MECID, Commission,Qty,FreeService) VALUES('".$app_id."', '".$service."', '0', '0','1','1')";
			ExecuteNQ($sqlInsert2);	
									 }
									 else
									 {
	        $sqlInsert2 = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID, ServiceID, MECID, Commission,Qty) VALUES('".$app_id."', '".$service."', '0', '0','1')";
			ExecuteNQ($sqlInsert2);	 
									 }
									 
			$selpqi=select("*","tblAppointmentAssignEmployee","AppointmentID='".$app_id."' and ServiceID='".$service."'");
					$qtyu=$selpqi[0]['Qty'];
					 if($qtyu=='1')
					 {
						$sqlUpdate1 = "UPDATE tblAppointmentAssignEmployee SET QtyParam='".$qtyu."' WHERE AppointmentID='".$app_id."' and ServiceID='".$service."'";
					ExecuteNQ($sqlUpdate1);
					 }
					 elseif($qtyu=='0')
					 {
						// nothimng 
					 }
					 else
					 {
						 //echo 11;
						 $sqlUpdate1 = "UPDATE tblAppointmentAssignEmployee SET QtyParam='".$qtyu."' WHERE AppointmentID='".$app_id."' and ServiceID='".$service."'";
						//echo $sqlUpdate1;
					    ExecuteNQ($sqlUpdate1);
						 //UPDATE PARAM 
						for($i=1;$i<$qtyu;$i++)
						{
							
							 if($FreeService!="0")
									 {
							$sqlInsert3ptr = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID,ServiceID, Qty,QtyParam,MECID,Commission,FreeService) VALUES 
									('".$app_id."', '".$service."','".$qtyu."','".$i."','0','0','1')";
							if ($DB->query($sqlInsert3ptr) === TRUE) 
							{
								$last_id50 = $DB->insert_id;		//last id of tblAppointments insert
							}
							else
							{
								echo "Error: " . $sqlInsert3ptr . "<br>" . $conn->error;
							}
									 }
									 else
									 {
										 //echo $i;
							$sqlInsert3ptr = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID,ServiceID, Qty,QtyParam,MECID,Commission,FreeService) VALUES 
									('".$app_id."', '".$service."','".$qtyu."','".$i."','0','0','0')";
									//echo $sqlInsert3ptr;
							if ($DB->query($sqlInsert3ptr) === TRUE) 
							{
								$last_id50 = $DB->insert_id;		//last id of tblAppointments insert
							}
							else
							{
								echo "Error: " . $sqlInsert3ptr . "<br>" . $conn->error;
							}
							//echo $sqlInsert3ptr;
									 }
							
						}
					 }			
		 }

				
				$DB->close();
	}
			
			
			
			
			?>