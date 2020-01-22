<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
$DB = Connect();
$SelectStore=select("*","tblStores","1 order by StoreID");
foreach($SelectStore as $val)
{
	$StoreID = $val["StoreID"];
		$StoreName = $val["StoreName"];
		// echo $StoreID."&nbsp;";
		// echo $StoreName."<br>";
		$SelectTotalPayment=select("Sum(TotalPayment) as TOTAL,Billaddress","tblInvoiceDetails","Billaddress='".$StoreName."'");
		
		echo $total=$SelectTotalPayment[0]['TOTAL'];
		echo $billaddress=$SelectTotalPayment[0]['Billaddress'];
		
}
?>