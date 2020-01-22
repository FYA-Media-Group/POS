<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';?>

<?php 
			date_default_timezone_set('Asia/Kolkata');
$date=date('Y-m-d H:i:s');

		$DB = Connect();

		$newqty=$_POST['currstock'];
	$oldqty=$_POST['prevstock'];
         $prodid=$_POST['prodid'];
	     $orderid=$_POST['order'];
	     $id=$_POST['id'];
		 $status=$_POST['status'];
		 
		   
	  if($status=='11')
	  {
		  $remainqty=$oldqty-$newqty;
		  
		   $sqlInsert1 = "Insert into tblStoreOrderDetailsLog(AdminID,ProductID,OrderID,DateTimeInsert,OrderStock) values('".$strAdminID."','".$prodid."','".$orderid."','".$date."','".$oldqty."')";
			$DB->query($sqlInsert1); 
			$sqlInsert1 = "Insert into tblStoreOrderDetailsLog(AdminID,ProductID,OrderID,DateTimeInsert,OrderStock) values('".$strAdminID."','".$prodid."','".$orderid."','".$date."','".$newqty."')";
			$DB->query($sqlInsert1); 
					
			$sqlUpdate = "UPDATE  tblFinalOrder SET OrderStock='".$newqty."',RemainStock='".$remainqty."',OldStock='".$oldqty."',Status='".$status."' WHERE ID='".$id."'";
			 //echo $sqlUpdate;
			ExecuteNQ($sqlUpdate);
					
					
			$seldata=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='4'");
			$hoemail=$seldata[0]['AdminEmailID'];
			$ho=$seldata[0]['AdminFullName'];
			   
			$seldata1=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='36'");
			$superadminemail=$seldata1[0]['AdminEmailID'];
			$amyn=$seldata1[0]['AdminFullName'];
			   
			     
					
			$selpu=select("*","tblFinalOrder","ID='".$id."'");
			$selpq=select("EmailID","tblProductBrand","BrandID='".$BrandIDr."'");
			$email=$selpq[0]['EmailID']; 
			foreach($selpu as $vq)		
			{				
			$BrandIDr=$vq['BrandID'];
			$type=$vq['DeliveryState'];
			if($type=='HO')
			{
				$sqp=select("HeadOfficeAddress","tblSettings","1");
				$address=$sqp[0]['HeadOfficeAddress'];
				$from=$hoemail;
			    $strTo = $email;
				$strFrom = "OrderLeassQty@nailspaexperience.com";
				$strSubject = "Less Quantity Incorrect Details";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$strcc1=$superadminemail;
				$strcc2=$hoemail;
				$strcc3="";
			}
			else
			{
			   $seldata2=select("AdminID","tblAdminStore","StoreID='".$type."'");
			   $adminid=$seldata2[0]['AdminID'];
			 
			   $seldata3=select("AdminEmailID,AdminFullName","tblAdmin","AdminID='".$adminid."' and AdminRoleID='6'");
			   $storeemail=$seldata3[0]['AdminEmailID']; 
				 
				
			   $seldatat=select("Stock","tblStoreProduct","ProductID='".$prodid."'");
				foreach($seldatat as $valp)
				{
					$oldstock=$valp['Stock'];
					$newstock=$oldstock-$newqty;
					$sqlUpdate = "UPDATE  tblStoreProduct SET Stock='".$newstock."' WHERE ProductID='".$prodid."'";
		 //echo $sqlUpdate;
		
				ExecuteNQ($sqlUpdate);
				}
				$sqp=select("StoreOfficialAddress","tblStores","StoreID='".$type."'");
				$address=$sqp[0]['StoreOfficialAddress'];
				$from=$storeemail;
			    $strTo = $email;
				$strFrom = "OrderLeassQty@nailspaexperience.com";
				$strSubject = "Less Quantity Incorrect Details";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$strcc1=$superadminemail;
				$strcc2=$hoemail;
				$strcc3=$storeemail;
			}
		
		
			
			 
				
				$table='<table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
            <tbody>
            <tr>
            <th width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Product Name</th>
            <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Color</th>
            <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Size</th>
            <th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:left; padding-left:2%;">Available Stock</th>
            <th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Order Stock</th>
            <th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Remain Stock</th>

        </tr>';
		            $ProductID=$vq['ProductID'];
					$ProductStock=$vq['ProductStock'];
					$OrderStock=$vq['OrderStock'];
					$RemainStock=$vq['RemainStock'];
					$selp=select("ProductName","tblNewProducts","ProductID='".$ProductID."'");
					$prodname=$selp[0]['ProductName'];
				
						
					$ProductStockID=$vq['ProductStockID'];
				
					
					$selpt=select("*","tblNewProductStocks","ProductStockID='".$ProductStockID."'");
					$Color=$selpt[0]['Color'];
					$Size=$selpt[0]['Size'];
				
					
				$table .='<tr>
            <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$prodname.'</td>
            <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$Color.'</td>
            <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$Size.'</td>
            <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$ProductStock.'</td>
            <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$OrderStock.'</td>
			 <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$RemainStock.'</td>
        </tr>';
  
					
			
				 $table .='</tbody></table>';
				 $strDate = date("Y-m-d");
			
				$path="`http://nailspaexperience.com/images/test2.png`";
			    
				$strDate = date("Y-m-d");	
				$message = file_get_contents('EmailFormat/OrderLessQuantity.html');
				$message = eregi_replace("[\]",'',$message);              
				//setup vars to replace
				$vars = array('{OrderID}','{Path}','{table_data}','{Order_No}','{Address}'); //Replace varaibles
				$values = array($orderid,$path,$table,$orderid,$address);
				//replace vars
				$message = str_replace($vars,$values,$message);
			 //   echo $message;               
				 $strBody = $message;             
				$flag='OI';
				$id = $orderid;
				sendordermailvendor($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus,$strcc1,$strcc2,$strcc3);

				
				
				
				
				
			}
			$selpu=select("*","tblFinalOrder","ID='".$id."'");
				 	$selpq=select("EmailID","tblProductBrand","BrandID='".$BrandIDr."'");
			$email=$selpq[0]['EmailID']; 
			foreach($selpu as $vq)		
			{	
            			
			$BrandIDr=$vq['BrandID'];
			$type=$vq['DeliveryState'];
			if($type=='HO')
			{
					$sqp=select("HeadOfficeAddress","tblSettings","1");
					$address=$sqp[0]['HeadOfficeAddress'];
					 $strTo = $email;
				$strFrom = "OrderLeassQty@nailspaexperience.com";
				$strSubject = "Less Quantity Incorrect Details";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$strcc1=$superadminemail;
				$strcc2=$hoemail;
				$strcc3="";
			}
			else
			{
				 $seldata2=select("AdminID","tblAdminStore","StoreID='".$type."'");
			   $adminid=$seldata2[0]['AdminID'];
			 
			     $seldata3=select("AdminEmailID,AdminFullName","tblAdmin","AdminID='".$adminid."' and AdminRoleID='6'");
			      $storeemail=$seldata3[0]['AdminEmailID']; 
				 
				
				$seldatat=select("Stock","tblStoreProduct","ProductID='".$prodid."'");
					foreach($seldatat as $valp)
					{
					$oldstock=$valp['Stock'];
					$newstock=$oldstock-$newqty;
							 $sqlUpdate = "UPDATE  tblStoreProduct SET Stock='".$newstock."' WHERE ProductID='".$prodid."'";
			 //echo $sqlUpdate;
			
					ExecuteNQ($sqlUpdate);
					}
			$sqp=select("StoreOfficialAddress","tblStores","StoreID='".$type."'");
	        $address=$sqp[0]['StoreOfficialAddress'];
		
			 $strTo = $email;
				$strFrom = "OrderLeassQty@nailspaexperience.com";
				$strSubject = "Less Quantity Incorrect Details";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$strcc1=$superadminemail;
				$strcc2=$hoemail;
				$strcc3=$storeemail;
			}
		
		
			
			 
				
				$table='<table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
            <tbody>
            <tr>
            <th width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Product Name</th>
            <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Color</th>
            <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Size</th>
            <th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:left; padding-left:2%;">Available Stock</th>
            <th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Order Stock</th>
            <th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Remain Stock</th>

        </tr>';
		            $ProductID=$vq['ProductID'];
					$ProductStock=$vq['ProductStock'];
					$OrderStock=$vq['OrderStock'];
					$RemainStock=$vq['RemainStock'];
					$selp=select("ProductName","tblNewProducts","ProductID='".$ProductID."'");
					$prodname=$selp[0]['ProductName'];
				
					$ProductStockID=$vq['ProductStockID'];
				
					
					$selpt=select("*","tblNewProductStocks","ProductStockID='".$ProductStockID."'");
					$Color=$selpt[0]['Color'];
					$Size=$selpt[0]['Size'];
				
					
				$table .='<tr>
            <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$prodname.'</td>
            <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$Color.'</td>
            <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$Size.'</td>
            <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$ProductStock.'</td>
            <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$OrderStock.'</td>
			 <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$RemainStock.'</td>
        </tr>';
  
					
			
				 $table .='</tbody></table>';
				 $strDate = date("Y-m-d");
			
				$path="`http://nailspaexperience.com/images/test2.png`";
			    
				$strDate = date("Y-m-d");	
				$message = file_get_contents('EmailFormat/OrderLessQuantity.html');
				$message = eregi_replace("[\]",'',$message);              
				//setup vars to replace
				$vars = array('{OrderID}','{Path}','{table_data}','{Order_No}','{Address}'); //Replace varaibles
				$values = array($orderid,$path,$table,$orderid,$address);
				//replace vars
				$message = str_replace($vars,$values,$message);
			 //   echo $message;               
				 $strBody = $message;             
				$flag='OI';
				$id = $orderid;
				sendordermailvendor($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus,$strcc1,$strcc2,$strcc3);
				
				
				
				
				
			}
	  }
	    	
		 
			
		
				
	
	echo EncodeQ($orderid);  
$DB->close();																
?>
