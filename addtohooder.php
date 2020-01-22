<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';?>

<?php 

	$DB = Connect();

		 $qty=$_POST['qty'];
	     $stock=$_POST['stock'];
         $prodid=$_POST['prodid'];
	     $valuservice=$_POST['valuservice'];
	     $catid=$_POST['catid'];
         $prodidstock=$_POST['prodidstock'];
		 $store=$_POST['store'];
		 
		  $sqlInsert1 = "Insert into tblOrder(CategoryID,ProductID,ServiceID,AvailableStock,OrderStock,Status,ProductStockID,StoredID,AdminID) values('".$catid."','".$prodid."','".$valuservice."','".$stock."','".$qty."','0','".$prodidstock."','".$store."','".$strAdminID."')";
					$DB->query($sqlInsert1); 
					$data=4;
	
	echo $data;
$DB->close();																
?>
