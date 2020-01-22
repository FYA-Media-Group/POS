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
		
		$ordid = $_POST["ordid"];
		$stock = $_POST["stock"];
		$order = $_POST["order"];
	    
			$DB = Connect();
					  
			 $sqlUpdate = "UPDATE tblFinalOrder SET OrderStock='".$stock."',Status='8' WHERE ID='".$ordid."'";
		
		
					ExecuteNQ($sqlUpdate);
					echo EncodeQ($ordid);
					//  $DB->query($sqlInsert1); 
		             
						$DB->close();
	}
			
			
			
			
			?>