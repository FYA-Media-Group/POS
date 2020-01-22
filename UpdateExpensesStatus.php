<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';?>

<?php 

	$DB = Connect();

		 $id=$_POST['id'];
	    
			 $sqlUpdate = "UPDATE tblExpenses SET Status='1' WHERE ExpenseID='".$id."'";
			 //echo $sqlUpdate;
					ExecuteNQ($sqlUpdate);
					//  $DB->query($sqlInsert1); 
		              if ($DB->query($sqlUpdate) === TRUE) 
						{
							echo 2;
						}
						$DB->close();
															
?>
