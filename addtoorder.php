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
			
			$getDate=date('Y-m-d H:i:s');
			// echo $getDate."<br>";
			
		
		  $sqlInsert1 = "Insert into tblFinalOrder(CategoryID,ProductID,ServiceID,OrderStartDate,ProductStock,OrderStock,Status,ProductStockID,StoredID,AdminID) values('".$catid."','".$prodid."','".$valuservice."','".$getDate."','".$stock."','".$qty."','0','".$prodidstock."','".$strStore."','".$strAdminID."')";
		  // echo $sqlInsert1."<br>";
		  // die();
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
					//$DB->query($sqlInsert1); 
					
					
						 
					
	
	echo $data;
$DB->close();																
?>
