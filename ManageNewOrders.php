<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
$strPageTitle = "Orders Details | Nailspa";
$strDisplayTitle = "Orders Details | Nailspa";
$strMenuID = "6";
$strMyTable = "tblOrder";
$strMyTableID = "OrderID";
$strMyActionPage = "ManageNewOrders.php";
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
$strStep = Filter($_POST["step"]);
if($strStep=="add")
{
$DB = Connect();
foreach($_POST as $key => $val)
{
if($key!="step")
{
if(IsNull($sqlColumn))
{
$sqlColumn = $key;
$sqlColumnValues = "'".$_POST[$key]."'";
}
else
{
$sqlColumn = $sqlColumn.",".$key;
$sqlColumnValues = $sqlColumnValues.", '".$_POST[$key]."'";
}
}
}
$state=$_POST['deliverystate'];
$approve_status=$_POST['approve_status'];
$brandd=$_POST['brand'];
$productstock=$_POST['productstock'];
$productqty=$_POST['productqty'];
$orderid=$_POST['orderid'];
$prodid=$_POST['prodid'];
$remarkstate=$_POST['remarkstate'];
$order=$_POST['order'];
$ProductStockID=$_POST['ProductStockID'];
$DB = Connect();
$sql = "SELECT ID FROM tblFinalOrder WHERE OrderID='".$order."'";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
$DB->close();
die('<div class="alert alert-close alert-danger">
<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
<div class="alert-content">
<h4 class="alert-title">Record Add Failed</h4>
<p>Order No Already Exit</p>
</div>
</div>');
}
else
{
$id=array();
if($approve_status=="2")
{
foreach($orderid as $val)
{
$sqlInsert1 = "Insert into tblFinalOrder(OrderID,Status,DeliveryState) values('".$val['orderid']."','".$approve_status."','".$state."')";
$DB->query($sqlInsert1); 
$selp=select("*","tblFinalOrder","OrderID='".$val['orderid']."'");	
foreach($selp as $vq)
{
$id[]=$vq['ID'];
}
}
$iddp=array_unique($id);
for($u=0;$u<count($iddp);$u++)
{
$sqlUpdate1 = "UPDATE  tblFinalOrder SET BrandID='".$brandd[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate1);
$sqlUpdate2 = "UPDATE  tblFinalOrder SET ProductStock='".$productstock[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate2);	
$sqlUpdate3 = "UPDATE  tblFinalOrder SET OrderStock='".$productqty[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate3);	
$sqlUpdate4 = "UPDATE  tblFinalOrder SET ProductID='".$prodid[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate4);	
$sqlUpdate5 = "UPDATE  tblFinalOrder SET ProductStockID='".$ProductStockID[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate5);	
} 
$seldata=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='4'");
$hoemail=$seldata[0]['AdminEmailID'];
$ho=$seldata[0]['AdminFullName'];
$seldata1=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='36'");
$superadminemail=$seldata1[0]['AdminEmailID'];
$amyn=$seldata1[0]['AdminFullName'];
$seldata2=select("AdminID","tblAdminStore","StoreID='".$strStore."'");
$adminid=$seldata2[0]['AdminID'];
$seldata3=select("AdminEmailID,AdminFullName","tblAdmin","AdminID='".$adminid."' and AdminRoleID='6'");
$storeemail=$seldata3[0]['AdminEmailID'];
$sqlUpdate5 = "UPDATE  tblOrder SET Status='2' WHERE OrderID='".$order."'";
ExecuteNQ($sqlUpdate5);	
$selpu=select("*","tblFinalOrder","OrderID='".$order."' and Status='2'");
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
$strTo = $email;
$strFrom = "order@nailspaexperience.com";
$strSubject = "Order Approve Details";
$strBody = "";
$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
$strcc=$hoemail;
$strcc1=$superadminemail;
$strcc2=$storeemail;
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
$selp=select("*","tblOrder","OrderID='".$order."' and Status='2'");
foreach($selp as $vali)		
{
$ProductStockID=$vali['ProductStockID'];
$selpt=select("*","tblNewProductStocks","ProductStockID='".$ProductStockID."'");
$Color=$selpt[0]['Color'];
$Size=$selpt[0]['Size'];
}
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
sendordermail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus);
}
die('<div class="alert alert-close alert-success">
<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
<div class="alert-content">
<p>Order Details Added Successfully.</p>
</div>
</div>');
header('Location:ManageNewOrders.php');
}
elseif($approve_status=='5')
{
$id=array();
foreach($orderid as $val)
{
$sqlInsert1 = "Insert into tblFinalOrder(OrderID,Status,DeliveryState,Remark) values('".$val['orderid']."','".$approve_status."','".$state."','".$remarkstate."')";
$DB->query($sqlInsert1); 
$selp=select("*","tblFinalOrder","OrderID='".$val['orderid']."'");	
foreach($selp as $vq)
{
$id[]=$vq['ID'];
}
}
$iddp=array_unique($id);
/* print_r($iddp);
print_r($brandd);
print_r($productstock);
print_r($productqty);
print_r($prodid); */
for($u=0;$u<count($iddp);$u++)
{
$sqlUpdate1 = "UPDATE  tblFinalOrder SET BrandID='".$brandd[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate1);
//  echo  $sqlUpdate1;
$sqlUpdate2 = "UPDATE  tblFinalOrder SET ProductStock='".$productstock[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate2);	
//  echo  $sqlUpdate2;
$sqlUpdate3 = "UPDATE  tblFinalOrder SET OrderStock='".$productqty[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate3);	
//  echo  $sqlUpdate3;
$sqlUpdate4 = "UPDATE  tblFinalOrder SET ProductID='".$prodid[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate4);	
//  echo  $sqlUpdate4;
$sqlUpdate5 = "UPDATE  tblFinalOrder SET ProductStockID='".$ProductStockID[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate5);	
} 
$seldata=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='4'");
$hoemail=$seldata[0]['AdminEmailID'];
$ho=$seldata[0]['AdminFullName'];
$seldata1=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='36'");
$superadminemail=$seldata1[0]['AdminEmailID'];
$amyn=$seldata1[0]['AdminFullName'];
$seldata2=select("AdminID","tblAdminStore","StoreID='".$strStore."'");
$adminid=$seldata2[0]['AdminID'];
$seldata3=select("AdminEmailID,AdminFullName","tblAdmin","AdminID='".$adminid."' and AdminRoleID='6'");
$storeemail=$seldata3[0]['AdminEmailID'];
$sqlUpdate5 = "UPDATE  tblOrder SET Status='5' WHERE OrderID='".$order."'";
ExecuteNQ($sqlUpdate5);	
$selpu=select("*","tblFinalOrder","OrderID='".$order."' and Status='5'");
foreach($selpu as $vq)		
{	
$BrandIDr=$vq['BrandID'];
$type=$vq['DeliveryState'];
if($type=='HO')
{
$sqp=select("HeadOfficeAddress","tblSettings","1");
echo $address=$sqp[0]['HeadOfficeAddress'];
}
else
{
$sqp=select("StoreOfficialAddress","tblStores","StoreID='".$type."'");
$address=$sqp[0]['StoreOfficialAddress'];
}
$selpq=select("EmailID","tblProductBrand","BrandID='".$BrandIDr."'");
$email=$selpq[0]['EmailID'];
$strTo = $storeemail;
$strFrom = "order@nailspaexperience.com";
$strSubject = "Cancel Order Details";
$strBody = "";
$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
$strcc=$hoemail;
$strcc1=$superadminemail;
$strcc2=$storeemail;
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
$selp=select("*","tblOrder","OrderID='".$order."' and Status='5'");
foreach($selp as $vali)		
{
$ProductStockID=$vali['ProductStockID'];
$selpt=select("*","tblNewProductStocks","ProductStockID='".$ProductStockID."'");
$Color=$selpt[0]['Color'];
$Size=$selpt[0]['Size'];
}
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
$message = file_get_contents('EmailFormat/OrderCancel.html');
$message = eregi_replace("[\]",'',$message);              
//setup vars to replace
$vars = array('{OrderID}','{Path}','{table_data}','{Order_No}','{Address}'); //Replace varaibles
$values = array($order,$path,$table,$order,$address);
//replace vars
$message = str_replace($vars,$values,$message);
//   echo $message;               
$strBody = $message;             
$flag='OC';
$id = $order;
sendordermail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus);
}
die('<div class="alert alert-close alert-success">
<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
<div class="alert-content">
<p>Order Approve Details Added Successfully.</p>
</div>
</div>');
header('Location:ManageNewOrders.php');
}
elseif($approve_status=='3')
{
$id=array();
foreach($orderid as $val)
{
$sqlInsert1 = "Insert into tblFinalOrder(OrderID,Status,DeliveryState,Remark) values('".$val['orderid']."','".$approve_status."','".$state."','".$remarkstate."')";
$DB->query($sqlInsert1); 
$selp=select("*","tblFinalOrder","OrderID='".$val['orderid']."'");	
foreach($selp as $vq)
{
$id[]=$vq['ID'];
}
}
$iddp=array_unique($id);
/* print_r($iddp);
print_r($brandd);
print_r($productstock);
print_r($productqty);
print_r($prodid); */
for($u=0;$u<count($iddp);$u++)
{
$sqlUpdate1 = "UPDATE  tblFinalOrder SET BrandID='".$brandd[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate1);
//  echo  $sqlUpdate1;
$sqlUpdate2 = "UPDATE  tblFinalOrder SET ProductStock='".$productstock[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate2);	
//  echo  $sqlUpdate2;
$sqlUpdate3 = "UPDATE  tblFinalOrder SET OrderStock='".$productqty[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate3);	
//  echo  $sqlUpdate3;
$sqlUpdate4 = "UPDATE  tblFinalOrder SET ProductID='".$prodid[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate4);	
//  echo  $sqlUpdate4;
$sqlUpdate5 = "UPDATE  tblFinalOrder SET ProductStockID='".$ProductStockID[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate5);	
} 
$seldata=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='4'");
$hoemail=$seldata[0]['AdminEmailID'];
$ho=$seldata[0]['AdminFullName'];
$seldata1=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='36'");
$superadminemail=$seldata1[0]['AdminEmailID'];
$amyn=$seldata1[0]['AdminFullName'];
$seldata2=select("AdminID","tblAdminStore","StoreID='".$strStore."'");
$adminid=$seldata2[0]['AdminID'];
$seldata3=select("AdminEmailID,AdminFullName","tblAdmin","AdminID='".$adminid."' and AdminRoleID='6'");
$storeemail=$seldata3[0]['AdminEmailID'];
$sqlUpdate5 = "UPDATE  tblOrder SET Status='3' WHERE OrderID='".$order."'";
ExecuteNQ($sqlUpdate5);	
$selpu=select("*","tblFinalOrder","OrderID='".$order."' and Status='3'");
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
$strTo = $email;
$strFrom = "order@nailspaexperience.com";
$strSubject = "Issue With Order";
$strBody = "";
$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
$strcc=$hoemail;
$strcc1=$superadminemail;
$strcc2=$storeemail;
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
$selp=select("*","tblOrder","OrderID='".$order."' and Status='3'");
foreach($selp as $vali)		
{
$ProductStockID=$vali['ProductStockID'];
$selpt=select("*","tblNewProductStocks","ProductStockID='".$ProductStockID."'");
$Color=$selpt[0]['Color'];
$Size=$selpt[0]['Size'];
}
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
$flag='OIV';
$id = $order;
sendordermail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus);
}
die('<div class="alert alert-close alert-success">
<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
<div class="alert-content">
<p>Issue With Order Details Added Successfully.</p>
</div>
</div>');
header('Location:ManageNewOrders.php');
}
elseif($approve_status=='4')
{
$id=array();
foreach($orderid as $val)
{
$sqlInsert1 = "Insert into tblFinalOrder(OrderID,Status,DeliveryState,Remark) values('".$val['orderid']."','".$approve_status."','".$state."','".$remarkstate."')";
$DB->query($sqlInsert1); 
$selp=select("*","tblFinalOrder","OrderID='".$val['orderid']."'");	
foreach($selp as $vq)
{
$id[]=$vq['ID'];
}
}
$iddp=array_unique($id);
/* print_r($iddp);
print_r($brandd);
print_r($productstock);
print_r($productqty);
print_r($prodid); */
for($u=0;$u<count($iddp);$u++)
{
$sqlUpdate1 = "UPDATE  tblFinalOrder SET BrandID='".$brandd[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate1);
$sqlUpdate2 = "UPDATE  tblFinalOrder SET ProductStock='".$productstock[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate2);	
$sqlUpdate3 = "UPDATE  tblFinalOrder SET OrderStock='".$productqty[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate3);	
$sqlUpdate4 = "UPDATE  tblFinalOrder SET ProductID='".$prodid[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate4);	
$sqlUpdate5 = "UPDATE  tblFinalOrder SET ProductStockID='".$ProductStockID[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate5);	
} 
$seldata=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='4'");
$hoemail=$seldata[0]['AdminEmailID'];
$ho=$seldata[0]['AdminFullName'];
$seldata1=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='36'");
$superadminemail=$seldata1[0]['AdminEmailID'];
$amyn=$seldata1[0]['AdminFullName'];
$seldata2=select("AdminID","tblAdminStore","StoreID='".$strStore."'");
$adminid=$seldata2[0]['AdminID'];
$seldata3=select("AdminEmailID,AdminFullName","tblAdmin","AdminID='".$adminid."' and AdminRoleID='6'");
$storeemail=$seldata3[0]['AdminEmailID'];
$sqlUpdate5 = "UPDATE  tblOrder SET Status='4' WHERE OrderID='".$order."'";
ExecuteNQ($sqlUpdate5);	
$selpu=select("*","tblFinalOrder","OrderID='".$order."' and Status='4'");
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
$strFrom = "order@fyatest.website";
$strSubject = "Issue With Order";
$strBody = "";
$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
$strcc=$hoemail;
$strcc1=$superadminemail;
$strcc2=$storeemail;
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
$selp=select("*","tblOrder","OrderID='".$order."' and Status='4'");
foreach($selp as $vali)		
{
$ProductStockID=$vali['ProductStockID'];
$selpt=select("*","tblNewProductStocks","ProductStockID='".$ProductStockID."'");
$Color=$selpt[0]['Color'];
$Size=$selpt[0]['Size'];
}
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
$flag='OIS';
$id = $order;
sendordermail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus);
}
die('<div class="alert alert-close alert-success">
<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
<div class="alert-content">
<p>Issue With Order Details Added Successfully.</p>
</div>
</div>');
header('Location:ManageNewOrders.php');
}
}
}
if($strStep=='reissue')
{
$DB = Connect();
foreach($_POST as $key => $val)
{
if($key!="step")
{
if(IsNull($sqlColumn))
{
$sqlColumn = $key;
$sqlColumnValues = "'".$_POST[$key]."'";
}
else
{
$sqlColumn = $sqlColumn.",".$key;
$sqlColumnValues = $sqlColumnValues.", '".$_POST[$key]."'";
}
}
}
//print_r($_POST);
$state=$_POST['deliverystate'];
$approve_status=$_POST['approve_status'];
$brandd=$_POST['brand'];
$productstock=$_POST['productstock'];
$productqty=$_POST['productqty'];
$orderid=$_POST['orderid'];
$prodid=$_POST['prodid'];
$remarkstate=$_POST['remarkstate'];
//print_r($brandd);
$order=$_POST['order'];
$ProductStockID=$_POST['ProductStockID'];
$DB = Connect();
$sql = "SELECT ID FROM tblFinalOrder WHERE OrderID='".$order."' and Status='8'";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
$DB->close();
die('<div class="alert alert-close alert-danger">
<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
<div class="alert-content">
<h4 class="alert-title">Record Add Failed</h4>
<p>Order No Already Exit</p>
</div>
</div>');
}
else
{
if($approve_status=="2")
{
$id=array();
foreach($orderid as $val)
{
$sqlDelete = "delete from tblFinalOrder where OrderID='".$val['orderid']."'";
ExecuteNQ($sqlDelete);
$sqlInsert1 = "Insert into tblFinalOrder(OrderID,Status,DeliveryState) values('".$val['orderid']."','".$approve_status."','".$state."')";
$DB->query($sqlInsert1); 
$selp=select("*","tblFinalOrder","OrderID='".$val['orderid']."'");	
foreach($selp as $vq)
{
$id[]=$vq['ID'];
}
}
$iddp=array_unique($id);
/* print_r($iddp);
print_r($brandd);
print_r($productstock);
print_r($productqty);
print_r($prodid); */
for($u=0;$u<count($iddp);$u++)
{
$sqlUpdate1 = "UPDATE  tblFinalOrder SET BrandID='".$brandd[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate1);
$sqlUpdate2 = "UPDATE  tblFinalOrder SET ProductStock='".$productstock[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate2);	
$sqlUpdate3 = "UPDATE  tblFinalOrder SET OrderStock='".$productqty[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate3);	
$sqlUpdate4 = "UPDATE  tblFinalOrder SET ProductID='".$prodid[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate4);	
//  echo  $sqlUpdate4;
$sqlUpdate5 = "UPDATE  tblFinalOrder SET ProductStockID='".$ProductStockID[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate5);	
echo $sqlUpdate5;
} 
$seldata=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='4'");
$hoemail=$seldata[0]['AdminEmailID'];
$ho=$seldata[0]['AdminFullName'];
$seldata1=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='36'");
$superadminemail=$seldata1[0]['AdminEmailID'];
$amyn=$seldata1[0]['AdminFullName'];
$seldata2=select("AdminID","tblAdminStore","StoreID='".$strStore."'");
$adminid=$seldata2[0]['AdminID'];
$seldata3=select("AdminEmailID,AdminFullName","tblAdmin","AdminID='".$adminid."' and AdminRoleID='6'");
$storeemail=$seldata3[0]['AdminEmailID'];
$sqlUpdate5 = "UPDATE  tblOrder SET Status='2' WHERE OrderID='".$order."'";
ExecuteNQ($sqlUpdate5);	
$selpu=select("*","tblFinalOrder","OrderID='".$order."' and Status='2'");
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
$strTo = $email;
$strFrom = "order@fyatest.website";
$strSubject = "Order Approve Details";
$strBody = "";
$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
$strcc=$hoemail;
$strcc1=$superadminemail;
$strcc2=$storeemail;
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
$selp=select("*","tblOrder","OrderID='".$order."' and Status='2'");
foreach($selp as $vali)		
{
$ProductStockID=$vali['ProductStockID'];
$selpt=select("*","tblNewProductStocks","ProductStockID='".$ProductStockID."'");
$Color=$selpt[0]['Color'];
$Size=$selpt[0]['Size'];
}
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
sendordermail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus);
}
die('<div class="alert alert-close alert-success">
<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
<div class="alert-content">
<p>Order Approve Details Added Successfully.</p>
</div>
</div>');
header('Location:ManageNewOrders.php');
}
elseif($approve_status=='5')
{
$id=array();
foreach($orderid as $val)
{
$sqlDelete = "delete from tblFinalOrder where OrderID='".$val['orderid']."'";
ExecuteNQ($sqlDelete);
$sqlInsert1 = "Insert into tblFinalOrder(OrderID,Status,DeliveryState,Remark) values('".$val['orderid']."','".$approve_status."','".$state."','".$remarkstate."')";
$DB->query($sqlInsert1); 
$selp=select("*","tblFinalOrder","OrderID='".$val['orderid']."'");	
foreach($selp as $vq)
{
$id[]=$vq['ID'];
}
}
$iddp=array_unique($id);
/* print_r($iddp);
print_r($brandd);
print_r($productstock);
print_r($productqty);
print_r($prodid); */
for($u=0;$u<count($iddp);$u++)
{
$sqlUpdate1 = "UPDATE  tblFinalOrder SET BrandID='".$brandd[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate1);
$sqlUpdate2 = "UPDATE  tblFinalOrder SET ProductStock='".$productstock[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate2);	
//  echo  $sqlUpdate2;
$sqlUpdate3 = "UPDATE  tblFinalOrder SET OrderStock='".$productqty[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate3);	
$sqlUpdate4 = "UPDATE  tblFinalOrder SET ProductID='".$prodid[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate4);	
//  echo  $sqlUpdate4;
$sqlUpdate5 = "UPDATE  tblFinalOrder SET ProductStockID='".$ProductStockID[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate5);	
} 
$seldata=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='4'");
$hoemail=$seldata[0]['AdminEmailID'];
$ho=$seldata[0]['AdminFullName'];
$seldata1=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='36'");
$superadminemail=$seldata1[0]['AdminEmailID'];
$amyn=$seldata1[0]['AdminFullName'];
$seldata2=select("AdminID","tblAdminStore","StoreID='".$strStore."'");
$adminid=$seldata2[0]['AdminID'];
$seldata3=select("AdminEmailID,AdminFullName","tblAdmin","AdminID='".$adminid."' and AdminRoleID='6'");
$storeemail=$seldata3[0]['AdminEmailID'];
$sqlUpdate5 = "UPDATE  tblOrder SET Status='5' WHERE OrderID='".$order."'";
ExecuteNQ($sqlUpdate5);	
$selpu=select("*","tblFinalOrder","OrderID='".$order."' and Status='5'");
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
$strFrom = "order@fyatest.website";
$strSubject = "Cancel Order Details";
$strBody = "";
$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
$strcc=$hoemail;
$strcc1=$superadminemail;
$strcc2=$storeemail;
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
$selp=select("*","tblOrder","OrderID='".$order."' and Status='5'");
foreach($selp as $vali)		
{
$ProductStockID=$vali['ProductStockID'];
$selpt=select("*","tblNewProductStocks","ProductStockID='".$ProductStockID."'");
$Color=$selpt[0]['Color'];
$Size=$selpt[0]['Size'];
}
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
$message = file_get_contents('EmailFormat/OrderCancel.html');
$message = eregi_replace("[\]",'',$message);              
//setup vars to replace
$vars = array('{OrderID}','{Path}','{table_data}','{Order_No}','{Address}'); //Replace varaibles
$values = array($order,$path,$table,$order,$address);
//replace vars
$message = str_replace($vars,$values,$message);
//   echo $message;               
$strBody = $message;             
$flag='OC';
$id = $order;
sendordermail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus);
}
die('<div class="alert alert-close alert-success">
<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
<div class="alert-content">
<p>Order Approve Details Added Successfully.</p>
</div>
</div>');
header('Location:ManageNewOrders.php');
}
elseif($approve_status=='3')
{
$id=array();
foreach($orderid as $val)
{
$sqlDelete = "delete from tblFinalOrder where OrderID='".$val['orderid']."'";
ExecuteNQ($sqlDelete);
$sqlInsert1 = "Insert into tblFinalOrder(OrderID,Status,DeliveryState,Remark) values('".$val['orderid']."','".$approve_status."','".$state."','".$remarkstate."')";
$DB->query($sqlInsert1); 
$selp=select("*","tblFinalOrder","OrderID='".$val['orderid']."'");	
foreach($selp as $vq)
{
$id[]=$vq['ID'];
}
}
$iddp=array_unique($id);
/* print_r($iddp);
print_r($brandd);
print_r($productstock);
print_r($productqty);
print_r($prodid); */
for($u=0;$u<count($iddp);$u++)
{
$sqlUpdate1 = "UPDATE  tblFinalOrder SET BrandID='".$brandd[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate1);
//  echo  $sqlUpdate1;
$sqlUpdate2 = "UPDATE  tblFinalOrder SET ProductStock='".$productstock[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate2);	
//  echo  $sqlUpdate2;
$sqlUpdate3 = "UPDATE  tblFinalOrder SET OrderStock='".$productqty[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate3);	
//  echo  $sqlUpdate3;
$sqlUpdate4 = "UPDATE  tblFinalOrder SET ProductID='".$prodid[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate4);	
//  echo  $sqlUpdate4;
$sqlUpdate5 = "UPDATE  tblFinalOrder SET ProductStockID='".$ProductStockID[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate5);	
} 
$seldata=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='4'");
$hoemail=$seldata[0]['AdminEmailID'];
$ho=$seldata[0]['AdminFullName'];
$seldata1=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='36'");
$superadminemail=$seldata1[0]['AdminEmailID'];
$amyn=$seldata1[0]['AdminFullName'];
$seldata2=select("AdminID","tblAdminStore","StoreID='".$strStore."'");
$adminid=$seldata2[0]['AdminID'];
$seldata3=select("AdminEmailID,AdminFullName","tblAdmin","AdminID='".$adminid."' and AdminRoleID='6'");
$storeemail=$seldata3[0]['AdminEmailID'];
$sqlUpdate5 = "UPDATE  tblOrder SET Status='3' WHERE OrderID='".$order."'";
ExecuteNQ($sqlUpdate5);	
$selpu=select("*","tblFinalOrder","OrderID='".$order."' and Status='3'");
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
$strTo = $email;
$strFrom = "order@fyatest.website";
$strSubject = "Issue With Order";
$strBody = "";
$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
$strcc=$hoemail;
$strcc1=$superadminemail;
$strcc2=$storeemail;
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
$selp=select("*","tblOrder","OrderID='".$order."' and Status='3'");
foreach($selp as $vali)		
{
$ProductStockID=$vali['ProductStockID'];
$selpt=select("*","tblNewProductStocks","ProductStockID='".$ProductStockID."'");
$Color=$selpt[0]['Color'];
$Size=$selpt[0]['Size'];
}
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
$flag='OIV';
$id = $order;
sendordermail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus);
}
die('<div class="alert alert-close alert-success">
<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
<div class="alert-content">
<p>Issue With Order Details Added Successfully.</p>
</div>
</div>');
header('Location:ManageNewOrders.php');
}
elseif($approve_status=='4')
{
$id=array();
foreach($orderid as $val)
{
$sqlDelete = "delete from tblFinalOrder where OrderID='".$val['orderid']."'";
ExecuteNQ($sqlDelete);
$sqlInsert1 = "Insert into tblFinalOrder(OrderID,Status,DeliveryState,Remark) values('".$val['orderid']."','".$approve_status."','".$state."','".$remarkstate."')";
$DB->query($sqlInsert1); 
$selp=select("*","tblFinalOrder","OrderID='".$val['orderid']."'");	
foreach($selp as $vq)
{
$id[]=$vq['ID'];
}
}
$iddp=array_unique($id);
/* print_r($iddp);
print_r($brandd);
print_r($productstock);
print_r($productqty);
print_r($prodid); */
for($u=0;$u<count($iddp);$u++)
{
$sqlUpdate1 = "UPDATE  tblFinalOrder SET BrandID='".$brandd[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate1);
//  echo  $sqlUpdate1;
$sqlUpdate2 = "UPDATE  tblFinalOrder SET ProductStock='".$productstock[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate2);	
//  echo  $sqlUpdate2;
$sqlUpdate3 = "UPDATE  tblFinalOrder SET OrderStock='".$productqty[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate3);	
//  echo  $sqlUpdate3;
$sqlUpdate4 = "UPDATE  tblFinalOrder SET ProductID='".$prodid[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate4);	
//  echo  $sqlUpdate4;
$sqlUpdate5 = "UPDATE  tblFinalOrder SET ProductStockID='".$ProductStockID[$u]."' WHERE ID='".$iddp[$u]."'";
ExecuteNQ($sqlUpdate5);	
} 
$seldata=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='4'");
$hoemail=$seldata[0]['AdminEmailID'];
$ho=$seldata[0]['AdminFullName'];
$seldata1=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='36'");
$superadminemail=$seldata1[0]['AdminEmailID'];
$amyn=$seldata1[0]['AdminFullName'];
$seldata2=select("AdminID","tblAdminStore","StoreID='".$strStore."'");
$adminid=$seldata2[0]['AdminID'];
$seldata3=select("AdminEmailID,AdminFullName","tblAdmin","AdminID='".$adminid."' and AdminRoleID='6'");
$storeemail=$seldata3[0]['AdminEmailID'];
$sqlUpdate5 = "UPDATE  tblOrder SET Status='4' WHERE OrderID='".$order."'";
ExecuteNQ($sqlUpdate5);	
$selpu=select("*","tblFinalOrder","OrderID='".$order."' and Status='4'");
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
$strFrom = "order@fyatest.website";
$strSubject = "Issue With Order";
$strBody = "";
$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
$strcc=$hoemail;
$strcc1=$superadminemail;
$strcc2=$storeemail;
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
$selp=select("*","tblOrder","OrderID='".$order."' and Status='4'");
foreach($selp as $vali)		
{
$ProductStockID=$vali['ProductStockID'];
$selpt=select("*","tblNewProductStocks","ProductStockID='".$ProductStockID."'");
$Color=$selpt[0]['Color'];
$Size=$selpt[0]['Size'];
}
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
$flag='OIS';
$id = $order;
sendordermail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus);
}
die('<div class="alert alert-close alert-success">
<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
<div class="alert-content">
<p>Issue With Order Details Added Successfully.</p>
</div>
</div>');
header('Location:ManageNewOrders.php');
}
}
}
elseif($strStep=='update_stock')
{
$order=$_POST['order'];
$sqlUpdate5 = "UPDATE  tblFinalOrder SET Status='6' WHERE OrderID='".$order."'";
ExecuteNQ($sqlUpdate5);	
//header('Location:ManageNewOrders.php');
echo("<script>location.href='ManageNewOrders.php';</script>");
}
elseif($strStep=='reissue_stock')
{
$order=$_POST['order'];
$sqlUpdate5 = "UPDATE  tblFinalOrder SET Status='6' WHERE OrderID='".$order."'";
ExecuteNQ($sqlUpdate5);	
//header('Location:ManageNewOrders.php');
echo("<script>location.href='ManageNewOrders.php';</script>");
}
elseif($strStep=='transfer_stock')
{
$checktranfer=$_POST['checktranfer'];
if($checktranfer=='transfer_stock_store')
{
$order=$_POST['order'];
$sqlUpdate5 = "UPDATE  tblFinalOrder SET Status='12' WHERE OrderID='".$order."'";
ExecuteNQ($sqlUpdate5);	
die('<div class="alert alert-close alert-success">
<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
<div class="alert-content">
<p>Order Details Added Successfully.</p>
</div>
</div>');
echo("<script>location.href='ManageNewOrders.php';</script>");
}
else
{
$order=$_POST['order'];
$sqlUpdate5 = "UPDATE  tblFinalOrder SET Status='9' WHERE OrderID='".$order."'";
ExecuteNQ($sqlUpdate5);	
die('<div class="alert alert-close alert-success">
<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
<div class="alert-content">
<p>Order Details Added Successfully.</p>
</div>
</div>');
echo("<script>location.href='ManageNewOrders.php';</script>");
} 
}
if($strStep=="edit")
{
$DB = Connect();
foreach($_POST as $key => $val)
{
if($key=="step" || $key==$strMyTableID)
{
}
else
{
$sqlUpdate = "UPDATE $strMyTable SET $key='$_POST[$key]' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
ExecuteNQ($sqlUpdate);
}
}
$DB->close();
die('<div class="alert alert-close alert-success">
<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
<div class="alert-content">
<h4 class="alert-title">Record Updated Successfully</h4>
<p></p>
</div>
</div>');
}
die();
}	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require_once("incMetaScript.fya"); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <script>
    $(document).ready(function() {
      var store = $("#storeid").val();
      if (store != "") {
        $.ajax({
          type: "post",
          data: "storeid=" + store,
          url: "storecategoryorder.php",
          success: function(res) {
            //alert(res)
            var rep = $.trim(res);
            $("#catid").show();
            $("#catid").html("");
            $("#catid").html("");
            $("#catid").html(rep);
          }
        }
              )
      }
      $("#btnPrint").click(function() {
        //alert(111)
        var divContents = $("#printdata").html();
        //alert(divContents)
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.write('<html><head><title>Product Stock</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
      }
                          );
      $("#cancel").click(function() {
        if (confirm('Are you sure you want to Cancel this order?')) {
          //alert(idd)
          $.ajax({
            url: "ordercancel.php",
            type: 'post',
            data: $("#neworder").serialize(),
            success: function(msg) {
              if ($.trim(msg) == '2') {
                alert('Order Cancel Successfully')
                window.location = "ManageNewOrders.php";
              }
              else {
                alert(msg)
                window.location = "ManageNewOrders.php";
              }
            }
          }
                );
        }
        else {
          // Do nothing!
        }
      }
                        );
      $("#approve").click(function() {
        if (confirm('Are you sure you want to Approve this order?')) {
          //alert(idd)
          $.ajax({
            url: "OrderApprove.php",
            type: 'post',
            data: $("#neworder").serialize(),
            success: function(msg) {
              if ($.trim(msg) == '2') {
                alert('Order Approve Successfully')
                window.location = "ManageNewOrders.php";
              }
              else {
                alert(msg)
                window.location = "ManageNewOrders.php";
              }
            }
          }
                );
        }
        else {
          // Do nothing!
        }
      }
                         );
    }
                     )
    function updatevalues(evt) {
      var ordid = $(evt).closest('td').prev().prev().prev().prev().find('input').val();
      //alert(ordid)
      var stock = $(evt).closest('td').prev().html();
      //alert(stock)
      //alert(price)
      if (ordid != "") {
        $.ajax({
          type: "post",
          data: "ordid=" + ordid + "&stock=" + stock,
          url: "updatedataorder.php",
          success: function(result) {
            //alert(result);
            if ($.trim(result) == '2') {
              window.location = "pendingorders.php";
            }
          }
        }
              )
      }
    }
    function isNumberKey(evt) {
      var charCode = (evt.which) ? evt.which : evt.keyCode
      return !(charCode > 31 && (charCode < 48 || charCode > 57));
    }
    function updateqty(evt) {
		
	var newqty=$("#productqty").val();
   //alert(oldqty)
	var oldqty=$(evt).closest('td').next().find('input').val();

	  var stock = $("#productstock").val();
	 //alert(stock)
      var proid = $(evt).closest('td').prev().find('input').val();
      var id = $(evt).closest('td').prev().prev().find('input').val();
      // alert(id)
      var orderid = $("#orderid").val();
	  //alert(orderid)
      //alert(orderid)
   if(newqty!="" && newqty!="0")
	   {
		             if(newqty<0)
						{
							alert('Quantity cannot be negative')
						}
						else
						{
							if(Number(stock) < Number(newqty))
							{
								alert('Order Stock cannot be greater than Available Stock')
							}
							else
							{
								 if (orderid != "") 
								   {
										$.ajax({
										  url: "orderconfirm.php",
										  type: 'post',
										  data: "oldqty=" + oldqty + "&newqty=" + newqty + "&proid=" + proid + "&orderid=" + orderid + "&id=" + id,
										  success: function(msg) {
											//alert(msg)
											var exp = $.trim(msg);
											if ($.trim(msg) != '') {
											  window.location = "ManageNewOrders.php?Order=" + exp;
											}
										  }
										});
									} 
							}
							
						}
	   }
	   else
	   {
		   alert("Order Stock Cannot Be Empty Or Zero")
	   }  

    }
    function updateqty1(evt) {
      var newqty = $(evt).closest('td').find('input').val();
      var oldqty = $(evt).closest('td').next().find('input').val();
      var proid = $(evt).closest('td').prev().find('input').val();
      var id = $(evt).closest('td').prev().prev().find('input').val();
      var orderid = $(evt).closest('td').next().next().find('input').val();
      if (newqty != '' && newqty != '0') {
        if (orderid != "") {
          $.ajax({
            url: "orderconfirm1.php",
            type: 'post',
            data: "oldqty=" + oldqty + "&newqty=" + newqty + "&proid=" + proid + "&orderid=" + orderid + "&id=" + id,
            success: function(msg) {
              //alert(msg)
              var exp = $.trim(msg);
              if ($.trim(msg) != '') {
                window.location = "ManageNewOrders.php?Order=" + exp;
              }
            }
          }
                );
        }
      }
      else {
        alert('Quantity Cannot Blank')
      }
    }
    function sendorderrequest() {
      if (confirm('Are you sure you want to place this order?')) {
        idd = [];
        var idd = $(".orderstockid").val();
        //alert(idd)
        $.ajax({
          url: "orderconfirm.php",
          type: 'post',
          data: {
            id: idd
          }
          ,
          success: function(msg) {
            //alert(msg)
            if ($.trim(msg) == '4') {
              $msg = "Order Request Place Successfully";
              window.location = "manageorders.php";
            }
          }
        }
              );
      }
      else {
        // Do nothing!
      }
    }
    function deliveryproduct(evt) {
      var prodid = $(evt).closest('td').prev().prev().prev().prev().find('input').val();
      //alert(prodid)
      var id = $(evt).closest('td').prev().prev().prev().prev().prev().find('input').val();
      //alert(id)
      var status = $(evt).closest('td').prev().find('select').val();
      //alert(status)
      var prevstock = $(evt).closest('td').prev().prev().find('input').val();
      var currstock = $(evt).closest('td').prev().prev().prev().find('input').val();
     // alert(prevstock)
      var productstockid = $(evt).closest('td').next().find('input').val();
      //	alert(productstockid)
      var order = $(evt).closest('td').next().next().find('input').val();
      //  alert(order)
      var brand = $(evt).closest('td').next().next().next().find('select').val();
      //alert(brand)
      if (status == '3') {
        //alert(1)
        $("#brand").show();
        //$("#brands").hide();
        $("#orderplace").show();
        $("#Delivery").hide();
        if (brand != "0") {
          if (prodid != "0") {
            $.ajax({
              url: "ProductStockd.php",
              type: 'post',
              data: "prodid=" + prodid + "&prevstock=" + prevstock + "&productstockid=" + productstockid + "&order=" + order + "&id=" + id + "&status=" + status + "&brand=" + brand,
              success: function(msg) {
                //alert(msg)
				window.location = "ManageNewOrders.php";
               /*  var p = evt.parentNode.parentNode;
                p.parentNode.removeChild(p);
                location.reload(); */
              }
            }
                  );
          }
        }
		else
		{
			alert('Select Atleast One Brand')
		}
      }
      else if (status == '11') {
		  
		  $("#chckbtn").show();
		   $("#orderplace").hide();
        document.getElementById("productqty").readOnly = false;
		var prdqty=$("#productqty").val();
		if (prdqty != "0" && prdqty != "") {
			if(prdqty<0)
			{
				alert('Less Quantity Cannot Be Negative')
			}
			else
			{
				if(Number(prevstock)<Number(prdqty))
			   {
				   alert('Less Quantity Cannot Be Greater Than Avaiable Stock')
			   }
			   else
			   {
				 // $("#orderplace").show();
				  $("#Delivery").hide();
			   }
			}
	
		}
		else
		{
			alert('Less Quantity Cannot be zero or empty')
		}
		
      
      
     
      }
      else if (status == '10') {
        $("#damage").show();
        $("#Delivery").hide();
        $("#orderplace").show();
		//alert(prevstock)
        var damageqty = $("#damageqty").val();
        //alert(damageqty)
        if (damageqty != "0" && damageqty != "") {
		   if(Number(prevstock)<Number(damageqty))
		   {
			   alert('Damage Quantity Cannot Be Greater Than Avaiable Stock')
		   }
		   else
		   {
						 if (prodid != "0") {
					$.ajax({
					  url: "DamageProduct.php",
					  type: 'post',
					  data: "prodid=" + prodid + "&prevstock=" + prevstock + "&productstockid=" + productstockid + "&order=" + order + "&id=" + id + "&status=" + status + "&damageqty=" + damageqty,
					  success: function(msg) {
						 // alert(msg)
						 window.location = "ManageNewOrders.php";
						//alert(msg)
				   
					  }
					}
						  );
				  }
		   }
        
        }
        else
        {
			alert('Damage Quantity Cannot be zero or empty')
		}			
      }
	  else if (status == '7') 
	  {
		  if (prodid != "0") {
          $.ajax({
            url: "ProductStock.php",
            type: 'post',
            data: "prodid=" + prodid + "&prevstock=" + prevstock + "&productstockid=" + productstockid + "&order=" + order + "&id=" + id + "&status=" + status,
            success: function(msg) {
				//alert(msg)
				if($.trim(msg)=='2')
				{
					window.location = "ManageNewOrders.php";
				}
				else
				{
					alert('Product Stock Cannot be zero or empty')
				}
				
             
            }
          }
                );
        } 
	  }
      else {
        alert('Select Atleast One Action')
      }
      /*     if(prodid!="0")
			  {
				  	$.ajax({
				url: "ProductStock.php",
				type: 'post',
				data: "prodid="+prodid+"&prevstock="+prevstock+"&productstockid="+productstockid+"&order="+order+"&id="+id+"&status="+status,
				success:function(msg)
				{
					//alert(msg)
			      window.location="ManageNewOrders.php?Order="+msg;
				var p = evt.parentNode.parentNode;
                        p.parentNode.removeChild(p); 
							 location.reload();
				}
			   });
			  }  */
    }
    function calcultestock(evt) {
      //alert(111)
      var prevstock = $(evt).closest('td').prev().prev().prev().prev().prev().prev().find('input').val();
      //alert(prevstock)
      var prodid = $(evt).closest('td').prev().prev().prev().prev().prev().prev().prev().find('input').val();
      // alert(prodid)
      var id = $(evt).closest('td').prev().prev().prev().prev().prev().prev().prev().prev().find('input').val();
      // alert(id)
      var productstockid = $(evt).closest('td').prev().find('input').val();
      var order = $("#order").val();
      // alert(order)
      //  alert(productstockid)
      if (prodid != "0") {
        $.ajax({
          url: "ProductStock.php",
          type: 'post',
          data: "prodid=" + prodid + "&prevstock=" + prevstock + "&productstockid=" + productstockid + "&order=" + order + "&id=" + id,
          success: function(msg) {
            window.location = "ManageNewOrders.php?Order=" + msg;
            var p = evt.parentNode.parentNode;
            p.parentNode.removeChild(p);
          }
        }
              );
      }
    }
    function calcultestock1(evt) {
      var prevstock = $(evt).closest('td').prev().prev().find('input').val();
      var prodid = $(evt).closest('td').prev().prev().prev().find('input').val();
      var id = $(evt).closest('td').prev().prev().prev().prev().find('input').val();
      var productstockid = $(evt).closest('td').prev().find('input').val();
      //  alert(productstockid)
      var order = $("#order").val();
      //  alert(productstockid)
      if (prodid != "0") {
        $.ajax({
          url: "ProductStock.php",
          type: 'post',
          data: "prodid=" + prodid + "&prevstock=" + prevstock + "&productstockid=" + productstockid + "&order=" + order + "&id=" + id,
          success: function(msg) {
            window.location = "ManageNewOrders.php?Order=" + msg;
            var p = evt.parentNode.parentNode;
            p.parentNode.removeChild(p);
          }
        }
              );
      }
    }
    function confirmchange(evt) {
      var id = $(evt).closest('td').prev().prev().prev().prev().prev().find('input').val();
      if (id != "0") {
        $.ajax({
          url: "updateproductstatus.php",
          type: 'post',
          data: "id=" + id,
          success: function(msg) {
            var exp = $.trim(msg);
            if ($.trim(msg) != '') {
              window.location = "ManageNewOrders.php";
            }
          }
        }
              );
      }
    }
    function changebrand(evt) {
      var brd = $(evt).val();
      //	alert(brd)
      var id = $(evt).closest('td').prev().prev().prev().find('input').val();
      //alert(id)
      if (id != "0") {
        $.ajax({
          url: "updatebrands.php",
          type: 'post',
          data: "id=" + id + "&brd=" + brd,
          success: function(msg) {
            if ($.trim(msg) == '2') {
              location.reload();
            }
          }
        }
              );
      }
    }
    function updatestock(evt) {
	
      var availablestock = $("#productstock").val();
      //alert(availablestock)	
	//alert('updatestock')
      var orderstock = $(evt).closest('td').prev().prev().find('input').val();
     // alert(orderstock)
      var prodid = $(evt).closest('td').prev().prev().prev().find('input').val();
      // alert(prodid)
      var order = $(evt).closest('td').prev().prev().prev().prev().find('input').val();
      //alert(order)
      var id = $(evt).closest('td').prev().find('input').val();
     //alert(id)
      var prodstock = $(evt).closest('td').next().find('input').val();
       //alert(prodstock)
	   if(Number(orderstock)<0)
	   {
		   alert('Order Stock Cannot Be Negative')
	   }
	   else
	   {
			if(Number(availablestock) < Number(orderstock))
		   {
			   alert('Order Stock Cannot Be Greater Than Available Stock')
		   }
		   else
		   {
				if (order != "0") {
					$.ajax({
					  url: "updateproductstock.php",
					  type: 'post',
					  data: "prodid=" + prodid + "&orderstock=" + orderstock + "&order=" + order + "&id=" + id + "&prodstock=" + prodstock,
					  success: function(msg) {
						window.location = "ManageNewOrders.php";
					  }
					}
						  );
				  }
		   }
	   }

/*       if (order != "0") {
        $.ajax({
          url: "updateproductstock.php",
          type: 'post',
          data: "prodid=" + prodid + "&orderstock=" + orderstock + "&order=" + order + "&id=" + id + "&prodstock=" + prodstock,
          success: function(msg) {
            window.location = "ManageNewOrders.php?Order=" + msg;
            var p = evt.parentNode.parentNode;
            p.parentNode.removeChild(p);
          }
        }
              );
      } */
    }
    function sendstock(evt) {
		
	  var availablestock = $("#productstock").val();
	 // alert(availablestock)
      var orderstock = $(evt).closest('td').prev().prev().find('input').val();
      //alert(orderstock)
      var prodid = $(evt).closest('td').prev().prev().prev().find('input').val();
      //alert(prodid)
      var order = $(evt).closest('td').prev().prev().prev().prev().find('input').val();
      //alert(order)
      var id = $(evt).closest('td').prev().find('input').val();
      //alert(id)
      var prodstock = $(evt).closest('td').next().find('input').val();
	    if(Number(orderstock)<0)
	   {
		   alert('Order Stock Cannot Be Negative')
	   }
	   else
	   {
			if(Number(availablestock) < Number(orderstock))
		   {
			   alert('Order Stock Cannot Be Greater Than Available Stock')
		   }
		   else
		   {
							 if (order != "0") {
					$.ajax({
					  url: "SendStocktoManager.php",
					  type: 'post',
					  data: "prodid=" + prodid + "&orderstock=" + orderstock + "&order=" + order + "&id=" + id + "&prodstock=" + prodstock,
					  success: function(msg) {
						window.location = "ManageNewOrders.php";
						
					  }
					}
						  );
				  }
		   }
	   }
     // alert(prodstock)

    }
    function updatestock1(evt) {
		
		
      var orderstock = $(evt).closest('td').prev().prev().find('input').val();
      //alert(orderstock)
      var prodid = $(evt).closest('td').prev().prev().prev().find('input').val();
      //  alert(prodid)
      var order = $(evt).closest('td').prev().prev().prev().prev().find('input').val();
      // alert(order)
      var id = $(evt).closest('td').prev().find('input').val();
      // alert(id)
      var prodstock = $(evt).closest('td').next().find('input').val();
      //  alert(prodstock)
      if (order != "0") {
        $.ajax({
          url: "updateproductstock.php",
          type: 'post',
          data: "prodid=" + prodid + "&orderstock=" + orderstock + "&order=" + order + "&id=" + id + "&prodstock=" + prodstock,
          success: function(msg) {
            window.location = "ManageNewOrders.php?Order=" + msg;
            var p = evt.parentNode.parentNode;
            p.parentNode.removeChild(p);
          }
        }
              );
      }
    }
	

    function updatelessqty(evt) {
		
		 $("#orderplace").hide();
	  var currstock=$("#productqty").val();
     // alert(currstock)
	  var prevstock=$(evt).closest('td').next().find('input').val();
	  //alert(prevstock)
      var prodid = $(evt).closest('td').prev().find('input').val();
      //alert(prodid)
      var id = $(evt).closest('td').prev().prev().find('input').val();
      //alert(id)
      var status = $(evt).closest('td').next().next().find('select').val();
      //alert(status)
 
      var productstockid = $(evt).closest('td').next().next().next().next().find('input').val();
      //alert(productstockid)
      var order = $(evt).closest('td').next().next().next().next().next().find('input').val();
      //alert(order)
	//  alert(111)
     if (status == '11' && currstock != '0' && currstock != "") {
		  if(currstock<0  || currstock=='0')
			{
				alert('Less Quantity Cannot Be Negative')
			}
			else
			{
				if(Number(prevstock) < Number(currstock))
				{
					alert('Less Qty Cannot Be Greater Than Original')
				}
				else
				{
					//alert('else')
					//alert('else')
			$.ajax({
					  url: "UpdatelessQty.php",
					  type: 'post',
					  data: "prodid=" + prodid + "&prevstock=" + prevstock + "&productstockid=" + productstockid + "&order=" + order + "&id=" + id + "&status=" + status + "&currstock=" + currstock,
					  success: function(msg) {
						if($.trim(msg)!="")
						  {
							  //alert(msg)
							 window.location = "ManageNewOrders.php";

						  }
					  }
					}
						  ); 
				}
					
			}
    
      } 
    }
    function updatelessqtty(evt) {
      var prodid = $(evt).closest('td').prev().find('input').val();
      //alert(prodid)
      var order = $(evt).closest('td').prev().prev().find('input').val();
      //alert(order)
      var prevstock = $(evt).closest('td').next().find('input').val();
      //alert(prevstock)
      var status = $(evt).closest('td').next().next().find('input').val();
      //alert(status)
      var currstock = $(evt).val();
      //alert(currstock)
      var productstockid = $(evt).closest('td').next().next().next().find('input').val();
      //alert(productstockid)
      var id = $(evt).closest('td').next().next().next().next().find('input').val();
      // alert(id)
      if (status == '11' && currstock != '0') {
        $.ajax({
          url: "UpdatelessQty1.php",
          type: 'post',
          data: "prodid=" + prodid + "&prevstock=" + prevstock + "&productstockid=" + productstockid + "&order=" + order + "&id=" + id + "&status=" + status + "&currstock=" + currstock,
          success: function(msg) {
			  if($.trim(msg)!="")
			  {
				  window.location = "ManageNewOrders.php";

			  }
          }
        }
              );
      }
    }
  </script>
  <body>
    <div id="sb-site">
      <?php require_once("incOpenLayout.fya"); ?>
      <?php require_once("incLoader.fya"); ?>
      <div id="page-wrapper">
        <div id="mobile-navigation">
          <button id="nav-toggle" class="collapsed" data-toggle="collapse" data-target="#page-sidebar">
            <span>
            </span>
          </button>
        </div>
        <?php require_once("incLeftMenu.fya"); ?>
        <div id="page-content-wrapper">
          <div id="page-content">
            <?php require_once("incHeader.fya"); ?>
            <div class="panel">
              <div class="panel-body">
                <div class="example-box-wrapper">
                  <div class="tabs">
                    <!--Manage Tab Start-->
                    <?php 
if(isset($_GET['Order']))
{
if(isset($_GET['status']))
{
$status=$_GET['status'];
if($status=='New')
{
$DB = Connect();
$Order=$_GET['Order'];
$seldatag=select("*","tblFinalOrder","ID='".$Order."'");	
$Orderf=$seldatag[0]['OrderID'];
$sel=select("*","tblOrderLog","OrderID='".$Orderf."'");	
$StoreID=$sel[0]['StoreID'];
$sqp=select("StoreName","tblStores","StoreID='".$StoreID."'");
$storename=$sqp[0]['StoreName'];
$seldata=select("*","tblAdminStore","StoreID='".$StoreID."'");
$id=$seldata[0]['AdminID'];
$seldatat=select("*","tblAdmin","AdminID='".$id."'");
$AdminEmailID=$seldatat[0]['AdminEmailID'];
?>
                    <div class="fa-hover">
                      <a class="btn btn-primary btn-lg btn-block" href="ManageNewOrders.php">
                        <i class="fa fa-backward">
                        </i> &nbsp; Go back to 
                        <?=$strPageTitle?>
                      </a>
                    </div>
                    <div class="panel-body ">
                      <form role="form" id="neworder" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
                        <span class="result_message">&nbsp; 
                          <br>
                        </span>
                        <input type="hidden" name="step" value="add">
                        <input type="hidden" name="order" value="<?=$Orderf?>">
                        <input type="hidden" name="store" id="store" value="<?= $StoreID?>" />
                        <input type="hidden" name="storeemail" id="storeemail" value="<?= $AdminEmailID?>" />
                        <h3 class="title-hero">
                          <b>Order No - 
                            <?=$Orderf?>
                          </b>
                        </h3>
                        <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Product
                              </th>
                              <th>Available Stock
                              </th>
                              <th>Order Stock
                              </th>
                              <th>Brand
                              </th>
                              <th>
                              </th>
                            </tr>
                          </thead>
                          <tfoot>
						  
                              </th>
                              <th>
                              </th>
                            </tr>
                          </tfoot>
                          <tbody>
                            <?php 
$seldata=select("*","tblFinalOrder","ID='".$Order."'");	
foreach($seldata as $val)
{
$ProductID = $val["ProductID"];
$ID = $val["ID"];
$OrderID = $val["OrderID"];
$selp=select("ProductName,Brand","tblNewProducts","ProductID='".$ProductID."'");
$prodname=$selp[0]['ProductName'];
$brnds=$selp[0]['Brand'];
$brandd=explode(",",$brnds);
$brad=array_unique($brandd);
$AvailableStock = $val["ProductStock"];
$OrderStock = $val["OrderStock"];
$ProductStockID = $val["ProductStockID"];
$selpt=select("*","tblNewProductStocks","ProductStockID='".$ProductStockID."'");
$color=$selpt[0]['Color'];
if($color!="")
{
$prod=$prodname."(".$color.")";
}
else
{
$prod=$prodname;
}
?>
                            <tr>
                              <td>
                                <input type="hidden" name="idd[]" id="idd" class="idd" value="<?= $ID?>" readonly />
                                <input type="text" name="productname" id="productname" class="productname" width="25%" value="<?= $prod?>" readonly />
                              </td>
                              <td>
                                <input type="hidden" name="prodid[]" id="prodid" class="prodid" value="<?= $ProductID ?>" />
                                <input type="text" name="productstock[]" id="productstock" class="productstock" value="<?= $AvailableStock ?>" readonly />
                              </td>
                              <td>
							  
                                <input type="text" name="productqty[]" id="productqty" class="productqty" value="<?= $OrderStock ?>"  />&nbsp;&nbsp;<a href="#" onclick="updateqty(this);" class="btn btn-xs btn-primary">Check</a>
                              </td>
                              <td>
                                <input type="hidden" name="qty" id="qty" class="qty" value="<?= $OrderStock ?>" /> 
                                <input type="hidden" name="orderid[]" id="orderid" value="<?=$OrderID?>" />
                                <select name="brand[]" class="form-control required">
                                  <option value="0" >Select Brands 
                                  </option>
                                  <?php 
								// print_r($brad);
for($i=0;$i<count($brad);$i++)
{
	//echo $brad[$i];
	if($brad[$i]!="")
	{
	$selpo=select("*","tblProductBrand","BrandID='".$brad[$i]."' and EmailID!=''");
	$brndname=$selpo[0]['BrandName'];
	$brandid=$selpo[0]['BrandID'];
	$EmailID=$selpo[0]['EmailID'];
    if($EmailID!='')
	{
			?>
									  <option value="<?=$brad[$i] ?>">
										<?=$brndname ?>
									  </option>
									  <?php
	}

	}
}
unset($brad);
?>
                                </select>
                              </td>
                              <td>
                                <input type="hidden" name="ProductStockID[]" value="<?=$ProductStockID?>" />
                              </td>
                            </tr>
                            <?php
}
?>
                          </tbody>
                        </table>
                        <div class="form-group" id="delivery_State">
                          <label class="col-sm-3 control-label">Delivery Location
                            <span>*
                            </span>
                          </label>
                          <div class="col-sm-3">
                            <input type="radio" name="deliverystate" checked value="HO" />
                            <b>HO
                            </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
if($StoreID!="0")
{
?>
                            <input type="radio" name="deliverystate" value="<?= $StoreID ?>" />
                            <b>
                              <?=$storename;?>
                            </b>
                            <br/>
                            <?php
}
else
{
$sqp=select("*","tblStores","1");
foreach($sqp as $val)
{
?>
                            <input type="radio" name="deliverystate" value="<?= $val['StoreID'] ?>" />
                            <b>
                              <?=$val['StoreName'];?>
                            </b>
                            <br/>
                            <?php
}
}
?>
                          </div>
                        </div>
                        <div class="form-group" id="remark">
                          <label class="col-sm-3 control-label">Remark
                            <span>*
                            </span>
                          </label>
                          <div class="col-sm-3">
                            <textarea cols="50" rows="4" id="remarkstate" name="remarkstate">
                            </textarea>
                          </div>
                        </div>
                        <div class="form-group">
                          <input type="button" name="Cancel Order" value="Cancel Complete Order" id="cancel" class="btn ra-100 btn-primary" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="button" id="approve" value="Approve Order" class="btn btn-success" />
                        </div>
                      </form>
                    </div>
                    <?php
}
elseif($status=='Approved')
{
$DB = Connect();
$Order=$_GET['Order'];
$seldatag=select("*","tblFinalOrder","ID='".$Order."'");	
$Orderf=$seldatag[0]['OrderID'];
$sel=select("*","tblOrderLog","OrderID='".$Orderf."'");	
$StoreID=$sel[0]['StoreID'];
$sqp=select("StoreName","tblStores","StoreID='".$StoreID."'");
$storename=$sqp[0]['StoreName'];
$seldata=select("*","tblAdminStore","StoreID='".$StoreID."'");
$id=$seldata[0]['AdminID'];
$seldatat=select("*","tblAdmin","AdminID='".$id."'");
$AdminEmailID=$seldatat[0]['AdminEmailID'];
?>
                    <input type="hidden" name="order" id="order" value="<?=$Order?>" />
                    <div class="fa-hover">
                      <a class="btn btn-primary btn-lg btn-block" href="ManageNewOrders.php">
                        <i class="fa fa-backward">
                        </i> &nbsp; Go back to 
                        <?=$strPageTitle?>
                      </a>
                    </div>
                    <div class="panel-body ">
                      <form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
                        <span class="result_message">&nbsp; 
                          <br>
                        </span>
                        <input type="hidden" name="step" value="update_stock">
						  <input type="hidden" name="order" value="<?=$Orderf?>">                        
						  <h3 class="title-hero">
                          <b>Order No - 
                            <?=$Orderf?>
                          </b>
                        </h3>
                        <span style="float:right">Order Store Name - 
                          <b>
                            <?=$storename?>
                          </b>
                        </span>
                        <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Product
                              </th>
                              <th>Available
                              </th>
                              <th>Order
                              </th>
                              <th>Brand
                              </th>
                              <th>Action
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>Product
                              </th>
                              <th>Available
                              </th>
                              <th>Order
                              </th>
                              <th>Brand
                              </th>
                              <th>Action
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                            </tr>
                          </tfoot>
                          <tbody>
                            <?php 
$seldata=select("*","tblFinalOrder","ID='".$Order."' and Status='2'");	
foreach($seldata as $val)
{
$ProductID = $val["ProductID"];
$ID = $val["ID"];
$OrderID = $val["OrderID"];
$BrandID = $val["BrandID"];
$Status = $val["Status"];
$selp=select("ProductName,Brand","tblNewProducts","ProductID='".$ProductID."'");
$prodname=$selp[0]['ProductName'];
$brnds=$selp[0]['Brand'];
$brandd=explode(",",$brnds);
$brad=array_unique($brandd);
$selpr=select("EmailID","tblProductBrand","BrandID='".$BrandID."'");
$email=$selpr[0]['EmailID'];
$ProductStock = $val["ProductStock"];
$OrderStock = $val["OrderStock"];
$selpo=select("*","tblNewProductStocks","ProductID='".$ProductID."'");
$ProductStockID = $val["ProductStockID"];
// print_r($brnd);
?>
                            <input type="hidden" name="orderid[]" id="orderid" value="<?=$OrderID?>" />
                            <tr>
                              <td width="10%">
                                <input type="hidden" name="idd[]" id="idd" class="idd" value="<?= $ID?>" readonly />
                                <input type="text" name="productname" id="productname" class="productname" value="<?= $prodname?>" readonly />
                              </td>
                              <td width="10%">
                                <input type="hidden" name="prodid[]" id="prodid" class="prodid" value="<?= $ProductID ?>" />
                                <input type="text" name="productstock[]" id="productstock" class="productstock" value="<?= $ProductStock ?>" readonly />
                              </td>
                              <td width="10%">
                                <input type="number" name="productqty[]" id="productqty" class="productqty" value="<?=$OrderStock ?>" readonly style="display:inline;width:50%"  />
								<a href="#" onclick="updatelessqty(this)" class="btn btn-xs btn-primary" id="chckbtn" style="display:none" >Check</a>
                              </td>
                              <td width="10%">
                                 <input type="hidden" name="qty" id="qty" class="qty" value="<?= $OrderStock ?>" /> 
                                <input type="text" name="brand[]" id="brands" value="<?=$email?>" readonly />
                              </td>
                              <?php 
if($Status=='2')
{
?>
                              <td width="20%">
                                <select name="approve_status" id="approve_status" class="form-control required" style=>
                                  <option value="0" >Select Status 
                                  </option>
                                  <option value="3">Issue With Vendor(No stock)
                                  </option>
                                  <option value="10">Damage Stock/Stock Return
                                  </option>
                                  <option value="11">Less Quantity Incorrect
                                  </option>
                                  <option value="7">Deliverd
                                  </option>
                                  <?php
?>
                                </select>
                              </td>
                              <td width="10%">
                                <input type="button" value="Update" id="Delivery" class="btn ra-100 btn-primary" onclick="deliveryproduct(this)" />
                                <input type="button" value="Order Place" id="orderplace" class="btn ra-100 btn-primary" style="display:none" onclick="deliveryproduct(this)" />
                              </td>
                              <td>
                                <input type="hidden" id="productstockid" value="<?=$ProductStockID?>" />
                              </td>
                              <td>
                                <input type="hidden" name="orderid[]" id="orderid" value="<?=$OrderID?>" />
                              </td>
                              <td width="20%">
                                <select name="brand[]" class="form-control required" id="brand" style="display:none">
                                  <option value="0" >Select Brands 
                                  </option>
                                  <?php 
for($i=0;$i<count($brad);$i++)
{
if($brad[$i]!='')
	{
$selpo=select("*","tblProductBrand","BrandID='".$brad[$i]."' and EmailID!=''");
$brndname=$selpo[0]['BrandName'];
$brandid=$selpo[0]['BrandID'];
$EmailID=$selpo[0]['EmailID'];
    if($EmailID!='')
	{
?>
                                  <option value="<?=$brandid ?>">
                                    <?=$brndname ?>
                                  </option>
                                  <?php
	}
	}
}
?>
                                </select>
                              </td>
                              <?php
}
else
{
if($Status=='3')
{
?>
                              <td>
                                <select name="approve_status" id="approve_status" class="form-control required">
                                  <option value="0" >Select Status 
                                  </option>
                                  <option value="3">Issue With Vendor(stock)
                                  </option>
                                  <option value="10">Damage Stock/Stock Return
                                  </option>
                                  <option value="11">Less Quantity Incorrect
                                  </option>
                                  <option value="7">Deliverd
                                  </option>
                                </select>
                              </td>
                              <td>
                                <input type="button" value="Update" id="Delivery" onclick="deliveryproduct(this)" class="btn ra-100 btn-primary" />
                                <input type="button" value="Order Place" id="orderplace" class="btn ra-100 btn-primary" style="display:none" onclick="deliveryproduct(this)" />
                              </td>
                              <td>
                                <input type="hidden" id="productstockid" value="<?=$ProductStockID?>" />
                              </td>
                              <td>
                                <input type="hidden" name="orderid[]" id="orderid" value="<?=$OrderID?>" />
                              </td>
                              <td width="20%">
                                <select name="brand[]" class="form-control required" id="brand" style="display:none">
                                  <option value="0" >Select Brands 
                                  </option>
                                  <?php 
for($i=0;$i<count($brad);$i++)
{
	if($brad[$i]!='')
	{
$selpo=select("*","tblProductBrand","BrandID='".$brad[$i]."' and EmailID!=''");
$brndname=$selpo[0]['BrandName'];
$brandid=$selpo[0]['BrandID'];
$EmailID=$selpo[0]['EmailID'];
    if($EmailID!='')
	{
?>
                                  <option value="<?=$brandid ?>">
                                    <?=$brndname ?>
                                  </option>
                                  <?php
	}
	}
}
?>
                                </select>
                              </td>
                              <?php
}
elseif($Status=='7')
{
?>
                              <td>
                                <input type="button" id="update_stock" value="Update Stock" onclick="calcultestock1(this)" class="btn ra-100 btn-primary" />
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <?php
}
elseif($Status=='6')
{
?>
                              <td>Complete
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <?php
}
elseif($Status=='11')
{
?>
                              <td>Less Quantity Incorrect
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <?php
}
}
?>
                            </tr>
                            <?php
}
?>
                          </tbody>
                        </table>
                        <span id="damage" style="display:none">
                          <b>Damage Quantity
                          </b>
                          <input type="number" name="damageqty" id="damageqty"/>
                        </span>
                      </form>
                    </div>
                    <?php
}
elseif($status=='Issue With Vendor')
{
$DB = Connect();
$Order=$_GET['Order'];
$seldatag=select("*","tblFinalOrder","ID='".$Order."'");	
$Orderf=$seldatag[0]['OrderID'];
$sel=select("*","tblOrderLog","OrderID='".$Orderf."'");	
$StoreID=$sel[0]['StoreID'];
$sqp=select("StoreName","tblStores","StoreID='".$StoreID."'");
$storename=$sqp[0]['StoreName'];
$seldata=select("*","tblAdminStore","StoreID='".$StoreID."'");
$id=$seldata[0]['AdminID'];
$seldatat=select("*","tblAdmin","AdminID='".$id."'");
$AdminEmailID=$seldatat[0]['AdminEmailID'];
?>
                    <input type="hidden" name="order" id="order" value="<?=$Order?>" />
                    <div class="fa-hover">
                      <a class="btn btn-primary btn-lg btn-block" href="ManageNewOrders.php">
                        <i class="fa fa-backward">
                        </i> &nbsp; Go back to 
                        <?=$strPageTitle?>
                      </a>
                    </div>
                    <div class="panel-body ">
                      <form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
                        <span class="result_message">&nbsp; 
                          <br>
                        </span>
                        <input type="hidden" name="step" value="update_stock">
                        <input type="hidden" name="order" value="<?=$Orderf?>">
                        <h3 class="title-hero">
                          <b>Order No - 
                            <?=$Orderf?>
                          </b>
                        </h3>
                        <span style="float:right">Order Store Name - 
                          <b>
                            <?=$storename?>
                          </b>
                        </span>
                        <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Product
                              </th>
                              <th>Available
                              </th>
                              <th>Order
                              </th>
                              <th>Brand
                              </th>
                              <th>Action
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>Product
                              </th>
                              <th>Available
                              </th>
                              <th>Order
                              </th>
                              <th>Brand
                              </th>
                              <th>Action
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                            </tr>
                          </tfoot>
                          <tbody>
                            <?php 
$seldata=select("*","tblFinalOrder","ID='".$Order."'");	
foreach($seldata as $val)
{
$ProductID = $val["ProductID"];
$ID = $val["ID"];
$OrderID = $val["OrderID"];
$BrandID = $val["BrandID"];
$Status = $val["Status"];
$selp=select("ProductName,Brand","tblNewProducts","ProductID='".$ProductID."'");
$prodname=$selp[0]['ProductName'];
$brnds=$selp[0]['Brand'];
$brandd=explode(",",$brnds);
$brad=array_unique($brandd);
$selpr=select("EmailID","tblProductBrand","BrandID='".$BrandID."'");
$email=$selpr[0]['EmailID'];
$ProductStock = $val["ProductStock"];
$OrderStock = $val["OrderStock"];
$selpo=select("*","tblNewProductStocks","ProductID='".$ProductID."'");
$ProductStockID = $val["ProductStockID"];
// print_r($brnd);
?>
                            <input type="hidden" name="orderid[]" id="orderid" value="<?=$OrderID?>" />
                            <tr>
                              <td width="10%">
                                <input type="hidden" name="idd[]" id="idd" class="idd" value="<?= $ID?>" readonly />
                                <input type="text" name="productname" id="productname" class="productname" value="<?= $prodname?>" readonly />
                              </td>
                              <td width="10%">
                                <input type="hidden" name="prodid[]" id="prodid" class="prodid" value="<?= $ProductID ?>" />
                                <input type="text" name="productstock[]" id="productstock" class="productstock" value="<?= $ProductStock ?>" readonly />
                              </td>
                              <td width="10%">
							   <input type="number" name="productqty[]" id="productqty" class="productqty" value="<?=$OrderStock ?>" readonly style="display:inline;width:50%"  />
								<a href="#" onclick="updatelessqty(this)" class="btn btn-xs btn-primary" id="chckbtn" style="display:none" >Check</a>
                              
                              </td>
                              <td width="10%">
                                 <input type="hidden" name="qty" id="qty" class="qty" value="<?= $OrderStock ?>" /> 
                                <input type="text" name="brand[]" id="brands" value="<?=$email?>" readonly />
                              </td>
                              <td width="20%">
                                <select name="approve_status" id="approve_status" class="form-control required" style=>
                                  <option value="0" >Select Status 
                                  </option>
                                  <option value="3" selected>Issue With Vendor(No stock)
                                  </option>
                                  <option value="10">Damage Stock/Stock Return
                                  </option>
                                  <option value="11">Less Quantity Incorrect
                                  </option>
                                  <option value="7">Deliverd
                                  </option>
                                  <?php
?>
                                </select>
                              </td>
                              <td width="10%">
                                <input type="button" value="Update" id="Delivery" class="btn ra-100 btn-primary" onclick="deliveryproduct(this)" />
                                <input type="button" value="Order Place" id="orderplace" class="btn ra-100 btn-primary" style="display:none" onclick="deliveryproduct(this)" />
                              </td>
                              <td>
                                <input type="hidden" id="productstockid" value="<?=$ProductStockID?>" />
                              </td>
                              <td>
                                <input type="hidden" name="orderid[]" id="orderid" value="<?=$OrderID?>" />
                              </td>
                              <td width="20%">
                                <select name="brand[]" class="form-control required" id="brand" style="display:none">
                                  <option value="0" >Select Brands 
                                  </option>
                                  <?php 
for($i=0;$i<count($brad);$i++)
{
	if($brad[$i]!='')
	{
$selpo=select("*","tblProductBrand","BrandID='".$brad[$i]."' and EmailID!=''");
$brndname=$selpo[0]['BrandName'];
$brandid=$selpo[0]['BrandID'];
$EmailID=$selpo[0]['EmailID'];
		if($EmailID!='')
		{

	?>
									  <option value="<?=$brandid ?>">
										<?=$brndname ?>
									  </option>
									  <?php
		}
	}
}
?>
                                </select>
                              </td>
                            </tr>
                            <?php
}
?>
                          </tbody>
                        </table>
                        <span id="damage" style="display:none">
                          <b>Damage Quantity
                          </b>
                          <input type="text" name="damageqty" id="damageqty"/>
                        </span>
                      </form>
                    </div>
                    <?php
}
elseif($status=='Reissue With Store')
{
$DB = Connect();
$Order=$_GET['Order'];
$seldatag=select("*","tblFinalOrder","ID='".$Order."'");	
$Orderf=$seldatag[0]['OrderID'];
$sel=select("*","tblOrderLog","OrderID='".$Orderf."'");	
$StoreID=$sel[0]['StoreID'];
$sqp=select("StoreName","tblStores","StoreID='".$StoreID."'");
$storename=$sqp[0]['StoreName'];
$seldata=select("*","tblAdminStore","StoreID='".$StoreID."'");
$id=$seldata[0]['AdminID'];
$seldatat=select("*","tblAdmin","AdminID='".$id."'");
$AdminEmailID=$seldatat[0]['AdminEmailID'];
?>
                    <div class="fa-hover">
                      <a class="btn btn-primary btn-lg btn-block" href="ManageNewOrders.php">
                        <i class="fa fa-backward">
                        </i> &nbsp; Go back to 
                        <?=$strPageTitle?>
                      </a>
                    </div>
                    <div class="panel-body ">
                      <form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
                        <span class="result_message">&nbsp; 
                          <br>
                        </span>
                        <input type="hidden" name="step" value="reissue_stock">
                        <input type="hidden" name="order" value="<?=$Orderf?>">
                        <h3 class="title-hero">
                          <b>Order No - 
                            <?=$Orderf?>
                          </b>
                        </h3>
                        <span style="float:right">Order Store Name - 
                          <b>
                            <?=$storename?>
                          </b>
                        </span>
                        <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Product
                              </th>
                              <th>Available Stock
                              </th>
                              <th>Order Stock
                              </th>
                              <th>Brand
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>Product
                              </th>
                              <th>Available Stock
                              </th>
                              <th>Order Stock
                              </th>
                              <th>Brand
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                            </tr>
                          </tfoot>
                          <tbody>
                            <?php 
$seldata=select("*","tblFinalOrder","ID='".$Order."'");	
foreach($seldata as $val)
{
$ProductID = $val["ProductID"];
$ID = $val["ID"];
$OrderID = $val["OrderID"];
$Status = $val["Status"];
$selp=select("ProductName,Brand","tblNewProducts","ProductID='".$ProductID."'");
$prodname=$selp[0]['ProductName'];
$brnds=$selp[0]['Brand'];
$brandd=explode(",",$brnds);
$brad=array_unique($brandd);
$brnds=$val['BrandID'];
$selpr=select("EmailID","tblProductBrand","BrandID='".$brnds."'");
$email=$selpr[0]['EmailID'];
$ProductStock = $val["ProductStock"];
$ProductStockID = $val["ProductStockID"];
$OrderStock = $val["OrderStock"];
$selpo=select("*","tblNewProductStocks","ProductID='".$ProductID."'");
// print_r($brnd);
?>
                            <tr>
                              <td>
                                <input type="hidden" name="idd[]" id="idd" class="idd" value="<?= $ID?>" readonly />
                                <input type="text" name="productname" id="productname" class="productname" value="<?= $prodname?>" readonly />
                              </td>
                              <td>
                                <input type="hidden" name="prodid[]" id="prodid" class="prodid" value="<?= $ProductID ?>" />
                                <input type="text" name="productstock[]" id="productstock" class="productstock" value="<?= $ProductStock ?>" readonly />
                              </td>
                              <td>
                                <?php
if($Status=='4')
{
?>
                                <input type="text" name="productqty[]" id="productqty" class="productqty" value="<?= $OrderStock ?>" onkeyup="updateqty1(this);" />
                                <?php
}
else
{
?>
                                <input type="text" name="productqty[]" id="productqty" class="productqty" value="<?= $OrderStock ?>" readonly />
                                <?php
}
?>
                              </td>
                              <td>
                                <input type="hidden" value="<?=$OrderStock?>" />
                                <?php
if($brnds=="0")
{
?>
                                <select name="brand[]" class="form-control required" onchange="changebrand(this)">
                                  <option value="0" >Select Brands 
                                  </option>
                                  <?php 
for($i=0;$i<count($brad);$i++)
{
	if($brad[$i]!='')
	{
$selpo=select("*","tblProductBrand","BrandID='".$brad[$i]."' and EmailID!=''");
$brndname=$selpo[0]['BrandName'];
$brandid=$selpo[0]['BrandID'];
$EmailID=$selpo[0]['EmailID'];
		if($EmailID!='')
		{
?>
                                  <option value="<?=$brandid ?>">
                                    <?=$brndname ?>
                                  </option>
                                  <?php
		}
	}
}
?>
                                </select>
                                <?php
}
else
{
?>
                                <input type="text" name="brand[]" id="brand" value="<?=$email?>" readonly />
                                <?php
}
?>
                              </td>
                              <?php 
if($Status=='2')
{
?>
                              <td>
                                <select name="approve_status" id="approve_status" class="form-control required">
                                  <option value="0" >Select Status 
                                  </option>
                                  <option value="7">Deliverd
                                  </option>
                                  <?php
?>
                                </select>
                              </td>
                              <td>
                                <input type="button" value="Update" id="Delivery" class="btn ra-100 btn-primary" onclick="deliveryproduct(this)" />
                              </td>
                              <td>
                                <input type="hidden" id="productstockid" value="<?=$ProductStockID?>" />
                              </td>
                              <td>
                                <input type="hidden" name="orderid[]" id="orderid" value="<?=$OrderID?>" />
                              </td>
                              <td>
                              </td>
                              <?php
}
else
{
if($Status=='3')
{
?>
                              <td>
                                <select name="approve_status" id="approve_status" class="form-control required">
                                  <option value="0" >Select Status 
                                  </option>
                                  <option value="7">Deliverd
                                  </option>
                                </select>
                              </td>
                              <td>
                                <input type="button" value="Update" id="Delivery" onclick="deliveryproduct(this)" />
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <?php
}
elseif($Status=='7')
{
?>
                              <td>
                                <input type="button" id="update_stock" value="Update Stock" onclick="calcultestock1(this)" class="btn ra-100 btn-primary" />
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <?php
}
elseif($Status=='6')
{
?>
                              <td>Complete
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <?php
}
elseif($Status=='8')
{
?>
                              <td>Issue With Store Manager
                                <input type="hidden" name="orderid[]" id="orderid" value="<?=$OrderID?>" />
                              </td>
                              <td>
                                <input type="button" id="confirm" value="Confirm" onclick="confirmchange(this)" class="btn ra-100 btn-primary" />
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                              <?php
}
}
?>
                            </tr>
                            <?php
}
?>
                          </tbody>
                        </table>
                      </form>
                    </div>
                    <?php
}
elseif($status=='Complete')
{
$Order=$_GET['Order'];
$seldatag=select("*","tblFinalOrder","ID='".$Order."'");	
$Orderf=$seldatag[0]['OrderID'];
$sel=select("*","tblOrderLog","OrderID='".$Orderf."'");	
$StoreID=$sel[0]['StoreID'];
$sqp=select("StoreName","tblStores","StoreID='".$StoreID."'");
$storename=$sqp[0]['StoreName'];
$seldata=select("*","tblAdminStore","StoreID='".$StoreID."'");
$id=$seldata[0]['AdminID'];
$seldatat=select("*","tblAdmin","AdminID='".$id."'");
$AdminEmailID=$seldatat[0]['AdminEmailID'];
?>
                    <div class="fa-hover">
                      <a class="btn btn-primary btn-lg btn-block" href="ManageNewOrders.php">
                        <i class="fa fa-backward">
                        </i> &nbsp; Go back to 
                        <?=$strPageTitle?>
                      </a>
                    </div>
                    <div class="panel-body ">
                      <form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
                        <span class="result_message">&nbsp; 
                          <br>
                        </span>
                        <input type="hidden" name="step" value="transfer_stock">
                        <input type="hidden" name="order" value="<?=$Order?>">
                        <h3 class="title-hero">
                          <b>Order No - 
                            <?=$Orderf?>
                          </b>
                        </h3>
                        <span style="float:right">Order Store Name - 
                          <b>
                            <?=$storename?>
                          </b>
                        </span>
                        <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Product
                              </th>
                              <th>Available Stock
                              </th>
                              <th>Order Stock
                              </th>
                              <th>Brand
                              </th>
                              <th>Transfer
                              </th>
                              <th>
                              </th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>Product
                              </th>
                              <th>Available Stock
                              </th>
                              <th>Order Stock
                              </th>
                              <th>Brand
                              </th>
                              <th>Transfer
                              </th>
                              <th>
                              </th>
                            </tr>
                          </tfoot>
                          <tbody>
                            <?php 
$seldata=select("*","tblFinalOrder","ID='".$Order."'");	
foreach($seldata as $val)
{
$ProductID = $val["ProductID"];
$ID = $val["ID"];
$OrderID = $val["OrderID"];
$Status = $val["Status"];
$selp=select("ProductName,Brand","tblNewProducts","ProductID='".$ProductID."'");
$prodname=$selp[0]['ProductName'];
$brnds=$val['BrandID'];
$selpr=select("EmailID","tblProductBrand","BrandID='".$brnds."'");
$email=$selpr[0]['EmailID'];
$ProductStock = $val["ProductStock"];
$OrderStock = $val["OrderStock"];
$ProductStockID = $val["ProductStockID"];
$DeliveryState = $val["DeliveryState"];
// print_r($brnd);
?>
                            <tr>
                              <td>
                                <input type="hidden" name="orderid" id="orderid" value="<?=$OrderID?>" />
                                <input type="text" name="productname" id="productname" class="productname" value="<?= $prodname?>" readonly />
                              </td>
                              <td>
                                <input type="hidden" name="prodid" id="prodid" class="prodid" value="<?= $ProductID ?>" />
                                <input type="text" name="productstock" id="productstock" class="productstock" value="<?= $ProductStock ?>" readonly />
                              </td>
                              <td>
                                <input type="text" name="productqty" id="productqty" class="productqty" value="<?= $OrderStock ?>" readonly />
                              </td>
                              <td>
                                <input type="hidden" name="ID" id="ID" value="<?=$ID?>" />
                                <input type="text" name="brand" id="brand" value="<?=$email?>" readonly /> 
                              </td>
                              <?php 
if($Status=='9')
{
?>
                              <td>Transferd
                              </td>
                              <td>
                              </td>
                              <?php
}
elseif($Status=='12')
{
?>
                              <td>Transferd
                              </td>
                              <td>
                              </td>
                              <?php
}
else
{
if($DeliveryState=='HO')
{
?>
                              <td>
                                <input type="button" value="Transfer" id="transfer" class="btn ra-100 btn-primary" onclick="updatestock(this)" />
                              </td>
                              <td>
                                <input type="hidden" id="productstockid" value="<?=$val['ProductStockID']?>" />
                              </td>
                              <?php
}
else
{
?>
                              <td>
                                <input type="button" value="Transfer Store" id="transfer_store" class="btn ra-100 btn-primary" onclick="sendstock(this)" />
                              </td>
                              <td>
                                <input type="hidden" id="productstockid" value="<?=$val['ProductStockID']?>" />
                              </td>
                              <?php
}
}
?>
                            </tr>
                            <?php
}
?>
                          </tbody>
                        </table>
                      </form>
                    </div>
                    <?php
}
elseif($status=='Damage Order')
{
$DB = Connect();
$Order=$_GET['Order'];
$seldatag=select("*","tblFinalOrder","ID='".$Order."'");	
$Orderf=$seldatag[0]['OrderID'];
$sel=select("*","tblOrderLog","OrderID='".$Orderf."'");	
$StoreID=$sel[0]['StoreID'];
$sqp=select("StoreName","tblStores","StoreID='".$StoreID."'");
$storename=$sqp[0]['StoreName'];
$seldata=select("*","tblAdminStore","StoreID='".$StoreID."'");
$id=$seldata[0]['AdminID'];
$seldatat=select("*","tblAdmin","AdminID='".$id."'");
$AdminEmailID=$seldatat[0]['AdminEmailID'];
?>
                    <div class="fa-hover">
                      <a class="btn btn-primary btn-lg btn-block" href="ManageNewOrders.php">
                        <i class="fa fa-backward">
                        </i> &nbsp; Go back to 
                        <?=$strPageTitle?>
                      </a>
                    </div>
                    <div class="panel-body ">
                      <form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
                        <span class="result_message">&nbsp; 
                          <br>
                        </span>
                        <input type="hidden" name="step" value="transfer_stock">
                        <input type="hidden" name="order" value="<?=$Orderf?>">
                        <h3 class="title-hero">
                          <b>Order No - 
                            <?=$Orderf?>
                          </b>
                        </h3>
                        <span style="float:right">Order Store Name - 
                          <b>
                            <?=$storename?>
                          </b>
                        </span>
                        <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Product
                              </th>
                              <th>Available Stock
                              </th>
                              <th>Order Stock
                              </th>
                              <th>Brand
                              </th>
                              <th>Damage Stock
                              </th>
                              <th>
                              </th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>Product
                              </th>
                              <th>Available Stock
                              </th>
                              <th>Order Stock
                              </th>
                              <th>Brand
                              </th>
                              <th>Damage Stock
                              </th>
                              <th>
                              </th>
                            </tr>
                          </tfoot>
                          <tbody>
                            <?php 
$seldata=select("*","tblFinalOrder","ID='".$Order."'");	
foreach($seldata as $val)
{
$ProductID = $val["ProductID"];
$ID = $val["ID"];
$OrderID = $val["OrderID"];
$Status = $val["Status"];
$selp=select("ProductName,Brand","tblNewProducts","ProductID='".$ProductID."'");
$prodname=$selp[0]['ProductName'];
$brnds=$val['BrandID'];
$selpr=select("EmailID","tblProductBrand","BrandID='".$brnds."'");
$email=$selpr[0]['EmailID'];
$ProductStock = $val["ProductStock"];
$OrderStock = $val["OrderStock"];
$ProductStockID = $val["ProductStockID"];
$DeliveryState = $val["DeliveryState"];
$DamageStock = $val["DamageStock"];
// print_r($brnd);
?>
                            <tr>
                              <td>
                                <input type="hidden" name="orderid" id="orderid" value="<?=$OrderID?>" />
                                <input type="text" name="productname" id="productname" class="productname" value="<?= $prodname?>" readonly />
                              </td>
                              <td>
                                <input type="hidden" name="prodid" id="prodid" class="prodid" value="<?= $ProductID ?>" />
                                <input type="text" name="productstock" id="productstock" class="productstock" value="<?= $ProductStock ?>" readonly />
                              </td>
                              <td>
                                <input type="text" name="productqty" id="productqty" class="productqty" value="<?= $OrderStock ?>" readonly />
                              </td>
                              <td>
                                <input type="hidden" name="ID" id="ID" value="<?=$ID?>" />
                                <input type="text" name="brand" id="brand" value="<?=$email?>" readonly /> 
                              </td>
                              <td>
                                <?= $DamageStock?>
                              </td>
                              <td>
                              </td>
                            </tr>
                            <?php
}
?>
                          </tbody>
                        </table>
                      </form>
                    </div>
                    <?php
}
elseif($status="Less Quantity Incorrect Order")
{
$DB = Connect();
$Order=$_GET['Order'];
$seldatag=select("*","tblFinalOrder","ID='".$Order."'");	
$Orderf=$seldatag[0]['OrderID'];
$sel=select("*","tblOrderLog","OrderID='".$Orderf."'");	
$StoreID=$sel[0]['StoreID'];
$sqp=select("StoreName","tblStores","StoreID='".$StoreID."'");
$storename=$sqp[0]['StoreName'];
$seldata=select("*","tblAdminStore","StoreID='".$StoreID."'");
$id=$seldata[0]['AdminID'];
$seldatat=select("*","tblAdmin","AdminID='".$id."'");
$AdminEmailID=$seldatat[0]['AdminEmailID'];
?>
                    <input type="hidden" name="order" id="order" value="<?=$Order?>" />
                    <div class="fa-hover">
                      <a class="btn btn-primary btn-lg btn-block" href="ManageNewOrders.php">
                        <i class="fa fa-backward">
                        </i> &nbsp; Go back to 
                        <?=$strPageTitle?>
                      </a>
                    </div>
                    <div class="panel-body ">
                      <form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
                        <span class="result_message">&nbsp; 
                          <br>
                        </span>
                        <input type="hidden" name="step" value="update_stock">
                        <input type="hidden" name="order" value="<?=$Orderf?>">
                        <h3 class="title-hero">
                          <b>Order No - 
                            <?=$Orderf?>
                          </b>
                        </h3>
                        <span style="float:right">Order Store Name - 
                          <b>
                            <?=$storename?>
                          </b>
                        </span>
                        <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Product
                              </th>
                              <th>Available
                              </th>
                              <th>Order
                              </th>
                              <th>Brand
                              </th>
                              <th>Action
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>Product
                              </th>
                              <th>Available
                              </th>
                              <th>Order
                              </th>
                              <th>Brand
                              </th>
                              <th>Action
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                              <th>
                              </th>
                            </tr>
                          </tfoot>
                          <tbody>
                            <?php 
$seldata=select("*","tblFinalOrder","ID='".$Order."'");	
foreach($seldata as $val)
{
$ProductID = $val["ProductID"];
$ID = $val["ID"];
$OrderID = $val["OrderID"];
$BrandID = $val["BrandID"];
$Status = $val["Status"];
$selp=select("ProductName,Brand","tblNewProducts","ProductID='".$ProductID."'");
$prodname=$selp[0]['ProductName'];
$brnds=$selp[0]['Brand'];
$brandd=explode(",",$brnds);
$brad=array_unique($brandd);
$selpr=select("EmailID","tblProductBrand","BrandID='".$BrandID."'");
$email=$selpr[0]['EmailID'];
$ProductStock = $val["ProductStock"];
$OrderStock = $val["OrderStock"];
$selpo=select("*","tblNewProductStocks","ProductID='".$ProductID."'");
$ProductStockID = $val["ProductStockID"];
// print_r($brnd);
?>
                            <input type="hidden" name="orderid[]" id="orderid" value="<?=$OrderID?>" />
                            <tr>
                              <td width="10%">
                                <input type="hidden" name="idd[]" id="idd" class="idd" value="<?= $ID?>" readonly />
                                <input type="text" name="productname" id="productname" class="productname" value="<?= $prodname?>" readonly />
                              </td>
                              <td width="10%">
                                <input type="hidden" name="prodid[]" id="prodid" class="prodid" value="<?= $ProductID ?>" />
                                <input type="text" name="productstock[]" id="productstock" class="productstock" value="<?= $ProductStock ?>" readonly />
                              </td>
                              <td width="10%">
							    <input type="number" name="productqty[]" id="productqty" class="productqty" value="<?=$OrderStock ?>" readonly style="display:inline;width:50%" onkeyup="assignqty(this)" />
								<a href="#" onclick="updatelessqty(this)" class="btn btn-xs btn-primary" id="chckbtn" style="display:none" >Check</a>

                              </td>
                              <td width="10%">
                                <input type="hidden" name="qty" id="qty" class="qty" value="<?= $OrderStock ?>" /> 
                                <input type="text" name="brand[]" id="brands" value="<?=$email?>" readonly />
                              </td>
                              <td width="20%">
                                <select name="approve_status" id="approve_status" class="form-control required" style=>
                                  <option value="0" >Select Status 
                                  </option>
                                  <option value="3">Issue With Vendor(No stock)
                                  </option>
                                  <option value="10">Damage Stock/Stock Return
                                  </option>
                                  <option value="11" selected>Less Quantity Incorrect
                                  </option>
                                  <option value="7">Deliverd
                                  </option>
                                  <?php
?>
                                </select>
                              </td>
                              <td width="10%">
                                <input type="button" value="Update" id="Delivery" class="btn ra-100 btn-primary" onclick="deliveryproduct(this)" />
                                <input type="button" value="Order Place" id="orderplace" class="btn ra-100 btn-primary" style="display:none" onclick="deliveryproduct(this)" />
                              </td>
                              <td>
                                <input type="hidden" id="productstockid" value="<?=$ProductStockID?>" />
                              </td>
                              <td>
                                <input type="hidden" name="orderid[]" id="orderid" value="<?=$OrderID?>" />
                              </td>
                              <td width="20%">
                                <select name="brand[]" class="form-control required" id="brand" style="display:none">
                                  <option value="0" >Select Brands 
                                  </option>
                                  <?php 
for($i=0;$i<count($brad);$i++)
{
	if($brad[$i]!='')
	{
		$selpo=select("*","tblProductBrand","BrandID='".$brad[$i]."' and EmailID!=''");
$brndname=$selpo[0]['BrandName'];
$brandid=$selpo[0]['BrandID'];
$EmailID=$selpo[0]['EmailID'];
		if($EmailID!='')
		{
?>
                                  <option value="<?=$brandid ?>">
                                    <?=$brndname ?>
                                  </option>
                                  <?php
		}
	}

}
?>
                                </select>
                              </td>
                            </tr>
                            <?php
}

?>
                          </tbody>
                        </table>
                        <span id="damage" style="display:none">
                          <b>Damage Quantity
                          </b>
                          <input type="text" name="damageqty" id="damageqty"/>
                        </span>
                      </form>
                    </div>
                    <?php
}
}
}
else
{
?>
                    <div id="normal-tabs-2">
                      <div class="fa-hover">
                        <a class="btn btn-primary btn-lg btn-block" href="ManageNewOrders.php">
                          <i class="fa fa-backward">
                          </i> &nbsp; Go back to 
                          <?=$strPageTitle?>
                        </a>
                      </div>
                      <div class="panel-body ">
                        <form role="form" id="printcontent" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
                          <span class="result_message">&nbsp; 
                            <br>
                          </span>
                          <input type="hidden" name="step" value="add">
                          <h3 class="title-hero">Order Details
                          </h3>
                          <div class="panel-body">
                            <h3 class="title-hero">List of Orders | Nailspa
                            </h3>
                            <div class="example-box-wrapper">
                              <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th>
                                      <center>Sr
                                      </center>
                                    </th>
                                    <th>
                                      <center>Order No
                                      </center>
                                    </th>
                                    <th>
                                      <center>Store Name
                                      </center>
                                    </th>
                                    <th>
                                      <center>Store Manager
                                      </center>
                                    </th>
                                    <th>
                                      <center>Action
                                      </center>
                                    </th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <tr>
                                    <th>
                                      <center>Sr
                                      </center>
                                    </th>
                                    <th>
                                      <center>Order No
                                      </center>
                                    </th>
                                    <th>
                                      <center>Store Name
                                      </center>
                                    </th>
                                    <th>
                                      <center>Store Manager
                                      </center>
                                    </th>
                                    <th>
                                      <center>Action
                                      </center>
                                    </th>
                                  </tr>
                                </tfoot>
                                <tbody>
                                  <?php
// Create connection And Write Values
$DB = Connect();
$sql = "Select * FROM tblFinalOrder where 1 order by OrderID desc ";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
$counter = 0;
while($row = $RS->fetch_assoc())
{
$counter ++;
$ProductID = $row["ProductID"];
$ID = $row["ID"];
$OrderID = $row["OrderID"];
$getUID = EncodeQ($OrderID);
$selp=select("ProductName","tblNewProducts","ProductID='".$ProductID."'");
$prodname=$selp[0]['ProductName'];
$AvailableStock = $row["ProductStock"];
$StoredIDt = $row["StoredID"];
$AdminID = $row["AdminID"];
$sq=select("*","tblStores","StoreID='".$StoredIDt."'");
$storename=$sq[0]['StoreName'];
$seldata=select("*","tblAdminStore","StoreID='".$StoredIDt."'");
$id=$seldata[0]['AdminID'];
if($AdminID=="0" || $AdminID=="")
{
$seldatat=select("*","tblAdmin","AdminID='".$id."'");
$AdminFullName=$seldatat[0]['AdminFullName'];
}
else
{
$seldatat=select("*","tblAdmin","AdminID='".$AdminID."'");
$AdminFullName=$seldatat[0]['AdminFullName'];
}
$OrderStock = $row["OrderStock"];
$orderstockid[]=$ID;
$Status = $row["Status"];
if($Status=='0')
{
$status='Pending';
}
elseif($Status=='1')
{
$status='New';
}
else if($Status=='2')
{
$status='Approved';
}
else if($Status=='3')
{
$status='Issue With Vendor';
}
else if($Status=='4')
{
$status='Issue With Store Manager';
}
else if($Status=='5')
{
$status='Cancel';
}
else if($Status=='6')
{
$status='Complete';
}
else if($Status=='7')
{
$status='Deliverd';
}
else if($Status=='8')
{
$status='Reissue With Store';
}
else if($Status=='9')
{
$status='Transfered';
}
else if($Status=='10')
{
$status='Damage Order';
}
else if($Status=='11')
{
$status='Less Quantity Incorrect Order';
}
else if($Status=='12')
{
$status='Transferd To Store';
}
?>
                                  <tr id="my_data_tr_<?=$counter?>">
                                    <td>
                                      <center>
                                        <?=$counter?>
                                      </center>
                                    </td>
                                    <td>
                                      <center>
                                        <?= $OrderID?>
                                      </center>
                                    </td>

                                    <td>
                                      <center>
                                        <?=$storename?>
                                      </center>
                                    </td>
                                   
                                    <td>
                                      <center>
                                        <?=$AdminFullName?>
                                      </center>
                                    </td>
                                    <td style="text-align: center">
                                      <?php
if($Status=='4')
{
?>
                                      <a class="btn btn-link" disabled href="<?=$strMyActionPage?>?Order=<?=$OrderID?>&status=<?=$status?>">
                                        <?=$status?>
                                      </a>
                                      <?php
}
elseif($Status=='9')
{
?>
                                      <a class="btn btn-link" disabled href="<?=$strMyActionPage?>?Order=<?=$OrderID?>&status=<?=$status?>">
                                        <?=$status?>
                                      </a>
                                      <?php
}
elseif($Status=='3')
{
?>
                                      <a class="btn btn-link" href="<?=$strMyActionPage?>?Order=<?=$ID?>&status=<?=$status?>">
                                        <?=$status?>
                                      </a>
                                      <?php
}
elseif($Status=='5')
{
?>
                                      <a class="btn btn-link" disabled href="<?=$strMyActionPage?>?Order=<?=$OrderID?>&status=<?=$status?>">
                                        <?=$status?>
                                      </a>
                                      <?php
}
elseif($Status=='7')
{
?>
                                      <a class="btn btn-link" disabled href="<?=$strMyActionPage?>?Order=<?=$OrderID?>&status=<?=$status?>">
                                        <?=$status?>
                                      </a>
                                      <?php
}
elseif($Status=='12')
{
?>
                                      <a class="btn btn-link" disabled href="<?=$strMyActionPage?>?Order=<?=$OrderID?>&status=<?=$status?>">
                                        <?=$status?>
                                      </a>
                                      <?php
}
else
{
?>
                                      <a class="btn btn-link" href="<?=$strMyActionPage?>?Order=<?=$ID?>&status=<?=$status?>">
                                        <?=$status?>
                                      </a>
                                      <?php
}	
?>
                                      <!--<a class="btn btn-link" href="ManageStoresTarget.php?uid=<?//=$getUID?>">Veiw Target</a>-->
                                    </td>
                                  </tr>
                                  <?php
}
}
else
{
?>
                                  <tr>
                                    <td>
                                    </td>
                                    <td>No Records Found
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                  </tr>
                                  <?php
}
$DB->close();
?>
                                  <!--TAB 2 START-->
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </form>
                      </div>
                      <!--variation-->
                      <!--variation-->
                    </div>
                    <?php
}
?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php require_once 'incFooter.fya'; ?>
      </div>
    </div>
  </body>
</html>
