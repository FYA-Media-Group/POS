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
	   
		$DB = Connect();
					  
	 	if($status=='3')
			{
				
				$selp=select("BrandID","tblFinalOrder","ID='".$id."'");
				$brd=$selp[0]['BrandID'];
				 
				$sqlUpdate1 = "UPDATE  tblFinalOrder SET OldBrandID='".$brd."' WHERE ID='".$id."'";
			    ExecuteNQ($sqlUpdate1);
				
				$sqlUpdate4 = "UPDATE  tblFinalOrder SET Status='".$status."',BrandID='".$brand."' WHERE ID='".$id."'";
			
				 ExecuteNQ($sqlUpdate4);
				 
				  	 $seldata=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='4'");
			   $hoemail=$seldata[0]['AdminEmailID'];
			   $ho=$seldata[0]['AdminFullName'];
			   
			     $seldata1=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='36'");
			   $superadminemail=$seldata1[0]['AdminEmailID'];
			   $amyn=$seldata1[0]['AdminFullName'];
			   
			      $seldata2=select("AdminID","tblAdminStore","StoreID='".$store."'");
			   $adminid=$seldata2[0]['AdminID'];
			 
			     $seldata3=select("AdminEmailID,AdminFullName","tblAdmin","AdminID='".$adminid."' and AdminRoleID='6'");
			      $storeemail=$seldata3[0]['AdminEmailID']; 
				 
				 $selpu=select("*","tblFinalOrder","ID='".$id."'");
				  
			foreach($selpu as $vq)		
			{	
            			
			$BrandIDr=$vq['BrandID'];
			$type=$vq['DeliveryState'];
		    $selpq=select("EmailID","tblProductBrand","BrandID='".$BrandIDr."'");
			$email=$selpq[0]['EmailID'];
			if($type=='HO')
			{
					$sqp=select("HeadOfficeAddress","tblSettings","1");
					$address=$sqp[0]['HeadOfficeAddress'];
			}
			else
			{
				$sqp=select("StoreOfficialAddress","tblStores","StoreID='".$type."'");
	        $address=$sqp[0]['StoreOfficialAddress'];
			}
		

			
			    $strTo = $email;
				$strFrom = "VenderIssue@nailspaexperience.com";
				$strSubject = "No Stock Order Details";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
			    $strcc1=$superadminemail;
				$strcc2=$storeemail;
				$strcc3=$hoemail;
			
				
				$table='<table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
            <tbody>
            <tr>
            <th width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Product Name</th>
            <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Color</th>
            <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Size</th>
            <th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:left; padding-left:2%;">Available Stock</th>
            <th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Order Stock</th>


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
        </tr>';
  
					
			
				 $table .='</tbody></table>';
				 $strDate = date("Y-m-d");
			
				$path="`http://nailspaexperience.com/images/test2.png`";
			    
				$strDate = date("Y-m-d");	
				$message = file_get_contents('EmailFormat/OrderNoStock.html');
				$message = eregi_replace("[\]",'',$message);              
				//setup vars to replace
				$vars = array('{OrderID}','{Path}','{Order_No}','{Address}','{table_data}'); //Replace varaibles
				$values = array($order,$path,$order,$address,$table);
				//replace vars
				$message = str_replace($vars,$values,$message);
			 //   echo $message;               
				 $strBody = $message;             
				$flag='OI';
				$id = $order;
					sendordermailvendor($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus,$strcc1,$strcc2,$strcc3);
				
			}
			
		        //echo $sqlUpdate4;
		    }
		
	
		
					
	

$DB->close();																
?>
