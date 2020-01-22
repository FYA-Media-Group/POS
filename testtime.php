<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$DB = Connect();
	$First= date('Y-m-01');
	$Last= date('Y-m-t');
	$date=date('Y-m-d');
	$sqldetailsd=selectapp($First,$Last); //function name selectapp in setting file and pass startdate and enddate in function write call storeprocdure name with pass paramter
    foreach($sqldetailsd as $val) 
	{
		$CUST=$val['CustomerID'];
		$seldataqt=select("CustomerFullName","tblCustomers","CustomerID='".$CUST."'");
	    $CustomerFullName=$seldataqt[0]['CustomerFullName'];
		echo "Customer Name : -" .$CustomerFullName."<br/>";
	}
	

?>