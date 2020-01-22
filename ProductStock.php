<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';?>

<?php 
		
		$DB = Connect();

		$prodid=$_POST['prodid'];
	   $prevstock=$_POST['prevstock'];
	   $productstockid=$_POST['productstockid'];
       $order=$_POST['order'];
		$id=$_POST['id'];
	
		$status = $_POST["status"];
	 //  print_r($_POST);
			$DB = Connect();
					  
		if($status=='7')
			{
				if($prevstock=="" || $prevstock=="0" || $prevstock<0)
				{
					echo 1;
				}
				else
				{
					$sep=select("HasVariation,Stock","tblNewProducts","ProductID='".$prodid."'");	  
				   
				   $HasVariation=$sep[0]['HasVariation'];
				   $stocked=$sep[0]['Stock'];
				   if($HasVariation!="0")
				   {
					 
						$sepq=select("*","tblNewProductStocks","ProductStockID='".$productstockid."'");	 
						$stock=$sepq[0]['Stock'];
					   $total=$prevstock+$stock;
						$sqlUpdate = "UPDATE  tblNewProductStocks SET Stock='".$total."' WHERE ProductStockID='".$productstockid."'";
						ExecuteNQ($sqlUpdate);
					
				   }
				   else
				   {
						 $total=$prevstock+$stocked;
						 $sqlUpdate = "UPDATE  tblNewProducts SET Stock='".$total."' WHERE ProductID='".$prodid."'";
				 //echo $sqlUpdate;
						ExecuteNQ($sqlUpdate);
				   }
	    	
			
		
				  $sqlUpdate4 = "UPDATE  tblFinalOrder SET Status='6' WHERE ID='".$id."'";
			
				  ExecuteNQ($sqlUpdate4);
				  echo 2;
				}
			
		        //echo $sqlUpdate4;
		    }
			elseif($status=='11')
			{
				
			}
			else
			{
				 $sqlUpdate4 = "UPDATE  tblFinalOrder SET Status='".$status."' WHERE ID='".$id."'";
			
				ExecuteNQ($sqlUpdate4);
				echo 2;
				
			} 
	
	
		
			
					
	

$DB->close();																
?>
