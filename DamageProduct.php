<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';?>

<?php 
		
		$DB = Connect();

		$prodid=$_POST['prodid'];
	    $prevstock=$_POST['prevstock'];
	    $productstockid=$_POST['productstockid'];
        $order=$_POST['order'];
		$id=$_POST['id'];
	    $brand=$_POST['brand']; 
		$status = $_POST["status"];
	    $damageqty = $_POST["damageqty"];
			$DB = Connect();
					  
			if($status=='10')
			{
				
				 $sqlUpdate4 = "UPDATE  tblFinalOrder SET Status='".$status."',DamageStock='".$damageqty."' WHERE ID='".$id."'";
			   
				 ExecuteNQ($sqlUpdate4);
				 	 $seldata=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='4'");
			   $hoemail=$seldata[0]['AdminEmailID'];
			   $ho=$seldata[0]['AdminFullName'];
			   
			     $seldata1=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='36'");
			   $superadminemail=$seldata1[0]['AdminEmailID'];
			   $amyn=$seldata1[0]['AdminFullName'];
			   
			
				 
				 $selpu=select("*","tblFinalOrder","OrderID='".$order."' and Status='10' and ID='".$id."'");
				  
			foreach($selpu as $vq)		
			{	
            			
			$BrandIDr=$vq['BrandID'];
			$type=$vq['DeliveryState'];
			$DamageStcok=$vq['DamageStock'];
			$selpq=select("EmailID","tblProductBrand","BrandID='".$BrandIDr."'");
			$email=$selpq[0]['EmailID'];
			if($type=='HO')
			{
				$sqp=select("HeadOfficeAddress","tblSettings","1");
				$address=$sqp[0]['HeadOfficeAddress'];
			    $from=$hoemail;
				$strFrom = "DamageQuantity@nailspaexperience.com";
				$strTo = "yogitafya@hotmail.com";
				//$strTo = $email;
				//$strFrom = $from;
				$strSubject = "Damage Product Order Details";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$strcc1=$superadminemail;
				$strcc2=$from;
				$strcc3="";
			}
			else
			{
				$seldata2=select("AdminID","tblAdminStore","StoreID='".$type."'");
			   $adminid=$seldata2[0]['AdminID'];
			 
			    $seldata3=select("AdminEmailID,AdminFullName","tblAdmin","AdminID='".$adminid."' and AdminRoleID='6'");
			    $storeemail=$seldata3[0]['AdminEmailID']; 
				$sqp=select("StoreOfficialAddress","tblStores","StoreID='".$type."'");
	            $address=$sqp[0]['StoreOfficialAddress'];
		
		        $strTo = "yogitafya@hotmail.com";
			    //$strTo = $email;
				$strFrom = "DamageQuantity@nailspaexperience.com";
				$strSubject = "Damage Product Order Details";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$strcc1=$superadminemail;
				$strcc2=$storeemail;
				$strcc3=$hoemail;
			
			}
		
			
			
			   
			
				
				$table='<table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
            <tbody>
            <tr>
            <th width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Product Name</th>
            <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Color</th>
            <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Size</th>
            <th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:left; padding-left:2%;">Available Stock</th>
            <th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Order Stock</th>
			<th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Damage Stock</th>


        </tr>';
		            $ProductID=$vq['ProductID'];
					$ProductStock=$vq['ProductStock'];
					$OrderStock=$vq['OrderStock'];
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
			 <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$DamageStcok.'</td>
        </tr>';
  
					
			
				 $table .='</tbody></table>';
				 $strDate = date("Y-m-d");
			
				$path="`http://nailspaexperience.com/images/test2.png`";
			    
				$strDate = date("Y-m-d");	
				$message = file_get_contents('EmailFormat/DamageOrder.html');
				$message = eregi_replace("[\]",'',$message);              
				//setup vars to replace
				$vars = array('{OrderID}','{Path}','{table_data}','{Order_No}','{Address}'); //Replace varaibles
				$values = array($order,$path,$table,$order,$address);
				//replace vars
				$message = str_replace($vars,$values,$message);
			//echo $message;               
				 $strBody = $message;             
				$flag='OA';
				$id = $order;
					sendordermailvendor($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus,$strcc1,$strcc2,$strcc3);
				
				
			}
			
		        //echo $sqlUpdate4;
		    }
		
	
		
			
					
	

$DB->close();																
?>
