<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?
	
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{	
		
		$DB = Connect();
		
		$StoreID=$_POST['StoreID'];
		$productid=$_POST['productid'];
		$Stock=$_POST['Stock'];
	  // print_r($_POST);
		for($i=0;$i<count($StoreID);$i++)
		{
			if($Stock[$i]!="")
			{
				$data=4;
			
				$selp=select("count(*)","tblStoreProduct","ProductID='".$productid."' and StoreID='".$StoreID[$i]."'");
			$cnt=$selp[0]['count(*)'];
			if($cnt>0)
			{
				$sqlUpdate = "UPDATE tblStoreProduct SET Stock='".$Stock[$i]."',ProductStockID='".$productstockid."' WHERE ProductID='".$productid."' and StoreID='".$StoreID[$i]."'";
				if ($DB->query($sqlUpdate) === TRUE) 
				{
					$data=3;
				} 
				else 
				{
					$data="Error: " . $sqlUpdate . "<br>" . $DB->error;
				}
					
			}
			else
			{
				$sql1="INSERT INTO  tblStoreProduct(ProductID,StoreID,Stock,ProductStockID,UpdatePerQtyServe) VALUES ('".$productid."','".$StoreID[$i]."','".$Stock[$i]."','".$productstockid."','1')";	
		
				if ($DB->query($sql1) === TRUE) 
				{
					$data=3;
				} 
				else 
				{
					$data="Error: " . $sql1 . "<br>" . $DB->error;
				}
			}
			}
			
		}
		echo $data; 
	
	}