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
		
		$prodid = $_POST["prodid"];
		$id = $_POST["id"];
		
	
			$DB = Connect();
			$sep=select("OrderID","tblFinalOrder","ID='".$id."'");
			$order=$sep[0]['OrderID'];	  
			 $sqlUpdate = "UPDATE  tblFinalOrder SET Status='2' WHERE ID='".$id."'";
			 //echo $sqlUpdate;
					ExecuteNQ($sqlUpdate);
						
					//  $DB->query($sqlInsert1); 
		              if ($DB->query($sqlUpdate) === TRUE) 
						{
							$order=$id."&status=Reissue With Store";
						}
					
						$DB->close();
	}
	echo $order;
			
			
			
			
			?>