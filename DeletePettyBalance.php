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
		
		$bal = $_POST["bal"];
	    $id = $_POST["id"];
	  
        $DB = Connect();
		$sql11="delete from tblExpensesBalance where ExpenseBalanceID='".$id."'";
			
	    if ($DB->query($sql11) === TRUE) 
				{
						echo 2;	
				}
				else
				{
					
				}
			 
		
						$DB->close();
	}
			
			
			
			
			?>