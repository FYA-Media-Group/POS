<?php require_once("../admin/setting.fya"); ?>


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
		
		$puc = $_POST["puc"];
		$stockid = $_POST["stockid"];
		 $prodid = $_POST["prodid"];
		$qty = $_POST["qty"];
		$stock = $_POST["stock"];
		$PMRP = $_POST["PMRP"];
		echo $PMRP;
		$price = Filter($_POST["price"]);
	

		
			$DB = Connect();
					  
			 $sqlUpdate = "UPDATE  tblProductStocks SET Price='".$price."',Stock='".$stock."',PerQtyServe='".$qty."' WHERE ProductID='".$prodid."' and ProductStockID='".$stockid."'";
			 //echo $sqlUpdate;
					ExecuteNQ($sqlUpdate);
					//  $DB->query($sqlInsert1); 
		              if ($DB->query($sqlUpdate) === TRUE) 
						{
							echo 2;
						}
						$DB->close();
	}
			
			
			
			
			?>