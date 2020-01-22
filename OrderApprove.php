<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';?>
<?php

//print_r($_POST);
       $state=$_POST['deliverystate'];
	    $store=$_POST['store'];
		$brandd=$_POST['brand'];
		$productstock=$_POST['productstock'];
		$productqty=$_POST['productqty'];
	    $prodid=$_POST['prodid'];
  		$remarkstate=$_POST['remarkstate'];
	    $orderid=$_POST['orderid'];
        $order=$_POST['order'];
		$ProductStockID=$_POST['ProductStockID'];
		$storeemail=$_POST['storeemail'];
		$idd=$_POST['idd'];
		$getDate=date('Y-m-d H:i:s');
			// echo $getDate."<br>";
	
		   $DB = Connect();
		   $id=array();
			  for($i=0;$i<count($idd);$i++)
			{
			 	$sql = "SELECT ID FROM tblFinalOrder WHERE ID='".$idd[$i]."' and Status='2'";
			}
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				$msg="Order No Already Exit";
			}
			else
			{
		 for($i=0;$i<count($idd);$i++)
			{
			
					if($brandd[$i]!="0")
					{
						$sqlUpdate2 = "UPDATE  tblFinalOrder SET OrderID='".$order."',OrderApproveDate='".$getDate."', Status='2',DeliveryState='".$state."',Remark='".$remarkstate."',BrandID='".$brandd[$i]."',ProductStock='".$productstock[$i]."',OrderStock='".$productqty[$i]."',ProductID='".$prodid[$i]."',ProductStockID='".$ProductStockID[$i]."' WHERE ID='".$idd[$i]."'";
			              ExecuteNQ($sqlUpdate2);	
						//  echo  $sqlUpdate2;
						
					
					}
					else
					{
						$sqlUpdate2 = "UPDATE  tblFinalOrder SET OrderID='".$order."',OrderApproveDate='".$getDate."', Status='4',DeliveryState='".$state."',Remark='".$remarkstate."',BrandID='".$brandd[$i]."',ProductStock='".$productstock[$i]."',OrderStock='".$productqty[$i]."',ProductID='".$prodid[$i]."',ProductStockID='".$ProductStockID[$i]."' WHERE ID='".$idd[$i]."'";
			              ExecuteNQ($sqlUpdate2);	
					}
					
				
			}
			
			
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
				  
				    for($i=0;$i<count($idd);$i++)
			      {
				  $selpu=select("*","tblFinalOrder","ID='".$idd[$i]."'");
				  }
			foreach($selpu as $vq)		
			{	
            			
			$BrandIDr=$vq['BrandID'];
			$type=$vq['DeliveryState'];
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
		
			$selpq=select("EmailID","tblProductBrand","BrandID='".$BrandIDr."'");
			$email=$selpq[0]['EmailID'];
			
			    $strTo = $storeemail;
				//$strFrom = $hoemail; 
				//$strTo = "asmitafya@hotmail.com";
				$strFrom = "OrderIssue@nailspaexperience.com";

				/* $strTo = "asmitafya@hotmail.com";
				$strFrom = "yogitafya@hotmail.com"; */
				$strSubject = "Order Issue Details";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$strcc1=$superadminemail;
				$strcc2=$hoemail;
			
				
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
					  for($i=0;$i<count($idd);$i++)
			         {
					 $sqlUpdate5 = "UPDATE  tblFinalOrder SET Status='4' WHERE ID='".$idd[$i]."'";
			         ExecuteNQ($sqlUpdate5);	
				     }
					
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
				$message = file_get_contents('EmailFormat/OrderIssue.html');
				$message = eregi_replace("[\]",'',$message);              
				//setup vars to replace
				$vars = array('{OrderID}','{Path}','{table_data}','{Order_No}','{Address}'); //Replace varaibles
				$values = array($order,$path,$table,$order,$address);
				//replace vars
				$message = str_replace($vars,$values,$message);
			 //   echo $message;               
				 $strBody = $message;             
				$flag='OI';
				$id = $order;
				sendordermail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus,$strcc1,$strcc2);
				
				
			}
			  for($i=0;$i<count($idd);$i++)
			{
			 $selpu=select("*","tblFinalOrder","ID='".$idd[$i]."'");
			}  
			foreach($selpu as $vq)		
			{	
            			
			$BrandIDr=$vq['BrandID'];
			$type=$vq['DeliveryState'];
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
		
			$selpq=select("EmailID","tblProductBrand","BrandID='".$BrandIDr."'");
			$email=$selpq[0]['EmailID'];
			
			    /* $strTo = $email;
				$strFrom = $hoemail; */
			    $strTo = $email;
				$strFrom = "OrderApprove@nailspaexperience.com";
			   
				$strSubject = "Order Approve Details";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$strcc1=$superadminemail;
				$strcc2=$hoemail;
			
				
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
				           for($i=0;$i<count($idd);$i++)
			              {
						  $sqlUpdate5 = "UPDATE  tblFinalOrder SET Status='2' WHERE ID='".$idd[$i]."'";
			              ExecuteNQ($sqlUpdate5);
						  }						  
					
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
				$message = file_get_contents('EmailFormat/OrderApprove.html');
				$message = eregi_replace("[\]",'',$message);              
				//setup vars to replace
				$vars = array('{OrderID}','{Path}','{table_data}','{Order_No}','{Address}'); //Replace varaibles
				$values = array($order,$path,$table,$order,$address);
				//replace vars
				$message = str_replace($vars,$values,$message);
			 //   echo $message;               
				 $strBody = $message;             
				$flag='OA';
				$id = $order;
				sendordermail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus,$strcc1,$strcc2);
				
				
				
			}
			
			$msg="2";
			}
			echo $msg;

	   
	
					
			
		   
		
		
?>             