<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';
//require_once('accountverify.php') ;
error_reporting(E_ALL);

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


	
	
	
	
	//echo $adminid=$_SESSION["AdminID"];
	$seldata=select("AdminRoleID","tblAdmin","AdminType='".$strAdminType."'");
	//print_r($seldata);
	foreach($seldata as $valp)
	{
	if($valp['AdminRoleID']=='36')
	{
		//echo 134;
	$custid=$_GET['uid'];
	//echo 1;
	//echo $custid;
	
	$seldatap=select("AppointmentID","tblAppointments","CustomerID='".$custid."'");
	if($seldatap!="")
	{
		$sql="delete from tblAppointmentDetails where AppointmentID='".$seldatap[0]['AppointmentID']."'";
	//echo $sql;
	ExecuteNQ($sql);
		$sqlp="delete from tblAppointmentDetailsInvoice where AppointmentID='".$seldatap[0]['AppointmentID']."'";
	//	echo $sqlp;
	ExecuteNQ($sqlp);
	$sqlpq="delete from tblAppointments where AppointmentID='".$seldatap[0]['AppointmentID']."'";
	//echo $sqlpq;
	ExecuteNQ($sqlpq);
	$sql11="delete from tblCustomers where CustomerID='".$custid."'";
	ExecuteNQ($sql11);
	$msg="Deleted Customer Successfully";
	}
	else
	{
	//	echo 1235;
		$sql11="delete from tblCustomers where CustomerID='".$custid."'";
		//echo $sql11;
	ExecuteNQ($sql11);
	$msg="Deleted Customer Successfully";
	}

	
	}
	else
	{
		
		$msg="You Cannot Delete This Customer";
	
	}
	}
	//header("ManageCustomers.php?msg='$msg'");
	?>