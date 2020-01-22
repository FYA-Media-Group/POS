<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Manage Customers | Nailspa";
	$strDisplayTitle = "Manage Customers for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblServices";
	$strMyTableID = "ServiceID";
	//$strMyField = "CustomerMobileNo";
	$strMyActionPage = "appointment_invoice.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
// code for not allowing the normal admin to access the super admin rights	


	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		
		$prodid = $_POST["prodid"];
		$orderstock = $_POST["orderstock"];
		$order = $_POST["order"];
		$id=$_POST["id"];
        $prodstock=$_POST["prodstock"];
		
		 $DB = Connect();
			
        
			
       $septp=select("StoreID","tblOrderLog","OrderID='".$order."'");	  
		$StoreID=$septp[0]['StoreID'];

		
		$sep=select("Stock,HasVariation","tblNewProducts","ProductID='".$prodid."'");	  
		$stockd=$sep[0]['Stock'];
		$HasVariation=$sep[0]['HasVariation'];
		 if($HasVariation!="0")
			   {
				    $sepq=select("*","tblNewProductStocks","ProductStockID='".$prodstock."'");	 
					$stock=$sepq[0]['Stock'];
					$totalstock=$stock-$orderstock;
					$sqlUpdate = "UPDATE  tblNewProductStocks SET Stock='".$totalstock."' WHERE ProductStockID='".$prodstock."'";
					//echo $sqlUpdate;
		            ExecuteNQ($sqlUpdate);
			   }
			   else
			   {
				   $totalstock=$stockd-$orderstock;
				   $sqlUpdate1 = "UPDATE  tblNewProducts SET Stock='".$totalstock."' WHERE ProductID='".$prodid."'";
		           ExecuteNQ($sqlUpdate1);
			   }
		
		
		
		
	  
					
		
				  if($HasVariation!="0")
			        {
						 $septq=select("*","tblStoreProduct","ProductStockID='".$prodstock."'");	  
						 $stockt=$septq[0]['Stock'];
						$total=$orderstock+$stockt;
					 $sqlUpdate = "UPDATE  tblStoreProduct SET Stock='".$total."',StoreID='".$StoreID."' WHERE ProductStockID='".$prodstock."'";
		
					ExecuteNQ($sqlUpdate);
					}
					else
					{
						 
						$stockt=$stockd;
					$total=$orderstock+$stockt;
					 $sqlUpdate = "UPDATE  tblStoreProduct SET Stock='".$total."',StoreID='".$StoreID."' WHERE ProductID='".$prodid."'";
		
					ExecuteNQ($sqlUpdate);
				  
					}
					
					
				
				$total="";
		
	
					
		    $sqlUpdate3 = "UPDATE  tblFinalOrder SET Status='9' WHERE id='".$id."'";
		
			ExecuteNQ($sqlUpdate3);
					
					//  $DB->query($sqlInsert1); 
		        	echo $order."&status=Complete";  
						$DB->close(); 
	}
			
			
			
			
			?>