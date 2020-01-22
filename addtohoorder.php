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
		 if($store!="0")
		 {
			   $sqlInsert1 = "Insert into tblFinalOrder(CategoryID,ProductID,ServiceID,ProductStock,OrderStock,Status,ProductStockID,StoredID,AdminID) values('".$catid."','".$prodid."','".$valuservice."','".$stock."','".$qty."','0','".$prodidstock."','".$store."','".$strAdminID."')";
					  	if ($DB->query($sqlInsert1) === TRUE) 
							{
								$data=4;
								//$last_id3 = $DB->insert_id;		//last id of tblAppointments insert
							}
							else
							{
								$data=0;
								//echo "Error: " . $sql . "<br>" . $conn->error;
							}
						echo $data;
$DB->close();	
		 }
		
	
															
?>
