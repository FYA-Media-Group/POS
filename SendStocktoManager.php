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
		$orderstock = $_POST["orderstock"];
		$order = $_POST["order"];
		$id=$_POST["id"];
        $prodstock=$_POST["prodstock"];
		
		 $DB = Connect();
		$getDate=date('Y-m-d H:i:s');
			
       $septp=select("StoreID","tblOrderLog","OrderID='".$order."'");	  
	   $StoreID=$septp[0]['StoreID'];
       $total="";
				
		  $sqlUpdate3 = "UPDATE  tblFinalOrder SET Status='12', OrderCompleteDate='".$getDate."' WHERE id='".$id."'";
		// echo $sqlUpdate3."<br>";
		// die();
			ExecuteNQ($sqlUpdate3);
					
					//  $DB->query($sqlInsert1); 
		        	echo $id."&status=Complete";  
		        	// echo $sqlUpdate3;  
						$DB->close(); 
	}
			
			
			
			
			?>