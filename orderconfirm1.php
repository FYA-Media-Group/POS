<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';?>

<?php 
			date_default_timezone_set('Asia/Kolkata');
$date=date('Y-m-d H:i:s');

		$DB = Connect();

		 $newqty=$_POST['newqty'];
	     $oldqty=$_POST['oldqty'];
         $proid=$_POST['proid'];
	  $orderid=$_POST['orderid'];
	     $id=$_POST['id'];
	  
	    	
		  $sqlInsert1 = "Insert into tblStoreOrderDetailsLog(AdminID,ProductID,OrderID,DateTimeInsert,OrderStock) values('".$strAdminID."','".$proid."','".$orderid."','".$date."','".$oldqty."')";
					$DB->query($sqlInsert1); 
			
		 $sqlUpdate = "UPDATE  tblFinalOrder SET OrderStock='".$newqty."' WHERE ID='".$id."'";
			 //echo $sqlUpdate;
			
					ExecuteNQ($sqlUpdate);
				$order=$orderid."&status=Reissue With Store";
					
	
	echo $id;  
$DB->close();																
?>
