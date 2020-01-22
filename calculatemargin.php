<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
$test=array();
	if(isset($_POST["id"]))
	{
		
		$test = $_POST["id"];
		
	}

	$DB = Connect();
for($i=0;$i<count($test);$i++)
{
	$sqlp = select("count(*),HasVariation","tblNewProducts","ProductID='".$test[$i]."'");
	//print_r($sqlp);
	$count=$sqlp[0]['count(*)'];
    $variation=$sqlp[0]['HasVariation'];
	if($count>0)
	{
	

		
				$sql = select("sum(ProductMRP),PerQtyServe","tblNewProducts","ProductID='".$test[$i]."'");
			 $amounts=$sql[0]['sum(ProductMRP)'];
			  $qty=$sql[0]['PerQtyServe'];
			$amount=$amounts/$qty;
		
	
	
	}
	else
	{
		$sql = select("sum(ProductMRP),PerQtyServe","tblNewProductStocks","ProductStockID='".$test[$i]."'");
			$amounts=$sql[0]['sum(ProductMRP)'];
			$qty=$sql[0]['PerQtyServe'];
			$amount=$amounts/$qty;
	}
	
		
	
$amountd=$amountd+$amount;
	
//	if()
	//print_r($sql);
}
echo $amountd;
$amountd="";
	

	//print_r($test);
	//$sql = select("","","");
	
	
$DB->close();
?>