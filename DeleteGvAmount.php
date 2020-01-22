<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';
//require_once('accountverify.php') ;


	$strPageTitle = "Manage Customers | Nailspa";
	$strDisplayTitle = "Manage Customers for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblCustomers";
	$strMyTableID = "CustomerID";
	$strMyField = "CustomerMobileNo";
	$strMyActionPage = "ManageCustomers.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	//echo $strAdminType;
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
// code for not allowing the normal admin to access the super admin rights	

$id=$_POST['id'];
	$sql="delete from tblGiftVoucherAmount where GiftVoucherAmountID='".$id."'";
	//echo $sql;
	ExecuteNQ($sql);
	echo 2;
	
	
	//header("ManageCustomers.php?msg='$msg'");
	?>