<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Issue Order Request| Nailspa";
	$strDisplayTitle = "Issue Order Request| Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblOrder";
	$strMyTableID = "OrderID";
	$strMyActionPage = "IssueOrders.php";
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
			
			$orderidd=$_POST['OrderID'];
			$id=$_POST['id'];

				
					//echo $sqlUpdate;
		       
			  $seldata=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='4'");
			   $email=$seldata[0]['AdminEmailID'];
			   $cname=$seldata[0]['AdminFullName'];
			   
			   
			   
			     $seldata1=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='36'");
			   $superadminemail=$seldata1[0]['AdminEmailID'];
			   $amyn=$seldata1[0]['AdminFullName'];
			   
			      $seldata2=select("AdminID","tblAdminStore","StoreID='".$strStore."'");
			   $adminid=$seldata2[0]['AdminID'];
			 
			     $seldata3=select("AdminEmailID,AdminFullName","tblAdmin","AdminID='".$adminid."'");
			      $storeemail=$seldata3[0]['AdminEmailID']; 
				  
				  
				  
			    $strTo = $email;
				$strFrom = "order@nailspaexperience.com";
			    $cc = $storeemail;
				$cc1 = "";
				$strSubject = "Reissue Order Request Details";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$Name = $cname;
				$table='<table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
            <tbody>
            <tr>
            <th width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Product Name</th>
            <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Color</th>
            <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Size</th>
            <th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:left; padding-left:2%;">Available Stock</th>
            <th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Order Stock</th>


        </tr>';
	
		 $seldatap=select("*","tblFinalOrder","OrderID='".$orderidd."' and Status='8' and StoredID='".$strStore."'");
				
				foreach($seldatap as $data)
				{
					
					$prodid=$data['ProductID'];
					$ProductStockID=$data['ProductStockID'];
					$AvailableStock=$data['ProductStock'];
					$OrderStock=$data['OrderStock'];
					
					
					$selp=select("ProductName","tblNewProducts","ProductID='".$prodid."'");
					$prodname=$selp[0]['ProductName'];
					$selpt=select("*","tblNewProductStocks","ProductStockID='".$ProductStockID."'");
					$Color=$selpt[0]['Color'];
					$Size=$selpt[0]['Size'];
					
				
					$table .='<tr>
            <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$prodname.'</td>
            <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$Color.'</td>
            <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$Size.'</td>
            <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$AvailableStock.'</td>
            <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">'.$OrderStock.'</td>
        </tr>';
  
					
					
				}
		
        $table .='</tbody></table>';
												
												
				$strDate = date("Y-m-d");
			
				$path="`http://nailspaexperience.com/images/test2.png`";
			    
				$strDate = date("Y-m-d");	
				$message = file_get_contents('EmailFormat/OrderReissueRequest.html');
				$message = eregi_replace("[\]",'',$message);              
				//setup vars to replace
				$vars = array('{OrderID}','{Path}','{table_data}','{Order_No}'); //Replace varaibles
				$values = array($orderidd,$path,$table,$orderidd);
				//replace vars
				$message = str_replace($vars,$values,$message);
			 //   echo $message;               
				 $strBody = $message;             
				$flag='OR';
				$id = $orderidd;
				sendordermail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus,$cc,$cc1);
				
					echo("<script>location.href='IssueOrders.php';</script>");
	
	

		

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
$(document).ready(function(){
var store=$("#storeid").val();
				
			   if(store!="")
			   {
				   $.ajax({
		type:"post",
		data:"storeid="+store,
		url:"storecategoryorder.php",
		success:function(res)
		{
		//alert(res)
		var rep = $.trim(res);
		$("#catid").show();
			$("#catid").html("");
						$("#catid").html("");
						$("#catid").html(rep);
		}
		
		})
			   }
$("#btnPrint").click(function () {
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
        });
		
		
	
				
		
		
})
function updatevalues(evt)
	{
		
		 var ordid=$(evt).closest('td').prev().prev().prev().prev().find('input').val();
	//alert(ordid)
			var stock=$(evt).closest('td').prev().html();
		 var order=$(evt).closest('td').prev().prev().find('input').val();

		
		//alert(price)
		
		if(ordid!="")
		{
			$.ajax({
				type:"post",
				data:"ordid="+ordid+"&stock="+stock+"&order="+order,
				url:"updatedataorder1.php",
				success:function(result)
				{
		//alert(result);
				window.location="IssueOrders.php?uid="+result;
				
				}
				
				
			})
		}
	}
	function sendorderrequest()
	{
			if (confirm('Are you sure you want to place this order?')) {
				idd=[];
				var idd=$(".orderstockid").val();
			alert(idd)
			
				$.ajax({
				url: "orderconfirm.php",
				type: 'post',
				data: {
						id:idd
						
					},
				success:function(msg)
				{
				//alert(msg)
				if($.trim(msg)=='4')
						{
						  $msg = "Order Request Place Successfully";		     
						window.location="manageorders.php"; 
						} 
						
						
				}
			
				
			   
			   });
			
	 
			
		}
			 else {
				// Do nothing!
			}
		
	}

</script>
<body>
    <div id="sb-site">   
		<?php require_once("incOpenLayout.fya"); ?>	
		
        <?php require_once("incLoader.fya"); ?>
       
        <div id="page-wrapper">
            <div id="mobile-navigation"><button id="nav-toggle" class="collapsed" data-toggle="collapse" data-target="#page-sidebar"><span></span></button></div>
			<?php require_once("incLeftMenu.fya"); ?>
			
            
		<div id="page-content-wrapper">
			<div id="page-content">
				<?php require_once("incHeader.fya"); ?>									
					
				<div class="panel">
				<div class="panel-body">
<?php
$DB = Connect();
		$order = $_GET['order'];

		$strIDs = DecodeQ($strID);
		$sql_store = "SELECT StoreName FROM tblStores WHERE 1";
		$RS_store = $DB->query($sql_store);
		$row_store = $RS_store->fetch_assoc();
		$strStoreName = $row_store['StoreName'];
		
	?>

					<div class="example-box-wrapper">
						<div class="tabs">
							
				<!--Manage Tab Start-->
					<?php 
					if(isset($_GET['uid']))
					{
					
						$orderid=DecodeQ($_GET['uid']);
					
	                      $orders=EncodeQ($orderid);
	
						
						?>
								
				
				
				<div id="normal-tabs-2">
					<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="IssueOrders.php"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
					
					
					
											<div class="panel-body ">
											
											
												<form role="form" id="printcontent" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Issue Order Details</h3>  
											
																	<div class="panel-body">
												<h3 class="title-hero">List of Orders | Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
															    <th>Sr</th>
																<th>Product Name</th>
																<th>AvailableStock</th>
															    <th>OrderStock</th>
																<th></th>
																
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr</th>
																<th>Product Name</th>
																<th>AvailableStock</th>
															    <th>OrderStock</th>
																<th></th>
															</tr>
														</tfoot>
											<tbody>
<?php
// Create connection And Write Values
$DB = Connect();
$sql = "Select * FROM tblFinalOrder where ID='".$orderid."' and StoredID='".$strStore."'";
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
		$selp=select("ProductName","tblNewProducts","ProductID='".$ProductID."'");
	    $prodname=$selp[0]['ProductName'];
		$AvailableStock = $row["ProductStock"];
		$OrderStock = $row["OrderStock"];
		$BrandID = $row["BrandID"];
		$orderstockid[]=$ID;
		
		
		
?>	
                                              
												<tr id="my_data_tr_<?=$counter?>">
												<td><input type="hidden" id="id" name="id[]" value="<?=$ID?>"/><?=$counter?></td>
													<td><?=$prodname?></td>
													<td><input type="hidden" id="OrderID" name="OrderID" value="<?=$OrderID?>"/><?= $AvailableStock?></td>
											  
												<?php 
												if($BrandID!="0")
												{
													?>
														<td  id="orderstock"><?=$OrderStock?></td>
												    <td style="text-align: center">
													
													<a class="btn btn-link" href="#" >Approve</a>
													</td>
													<?php
												}
												else
												{
													?>
														<td contenteditable='true' id="orderstock"><?=$OrderStock?></td>
													<td style="text-align: center">
													<a class="btn btn-link" href="#" onclick="updatevalues(this)">Update Order Stock</a>
													</td>
													<?php
												}
												?>
												
												</tr>
												<input type="hidden" name="orderstockid[]" id="orderstockid" class="orderstockid" value="<?=$orderstockid?>" />
<?php
	}
}
else
{
?>	
												<tr>
													<td></td>
													<td></td>
													<td>No Records Found</td>
													<td></td>
												</tr>
<?php
}
$DB->close();
?>
<!--TAB 2 START-->											
											</tbody>
													</table>
												</div>
														<input type="submit" value="Update Order" class="btn ra-100 btn-primary" />
											</div>
											 
											</form>
											
					</div>
<!--variation-->


<!--variation-->
		
					
			
										

				</div>
						<?php
					}
					else
					{
						
						?>
						<div id="normal-tabs-2">
					<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="IssueOrders.php"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
					
					
					
											<div class="panel-body ">
											
											
												<form role="form" id="printcontent" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Issue Orders </h3>  
											
																	<div class="panel-body">
												<h3 class="title-hero">List of Orders | Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
															   <th>Sr</th>
																<th>Order No</th>
																<th>Status</th>
															   
																<th>Action</th>
																
															</tr>
														</thead>
														<tfoot>
															<tr>
															 <th>Sr</th>
																<th>Order No</th>
																<th>Status</th>
															   
																<th>Action</th>
															</tr>
														</tfoot>
											<tbody>
<?php
// Create connection And Write Values
$DB = Connect(); 
$sql = "Select * FROM tblFinalOrder where Status='4' and StoredID='".$strStore."'";
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
		$Status = $row["Status"];
		$getUID=EncodeQ($ID);
		
		$selp=select("ProductName","tblNewProducts","ProductID='".$ProductID."'");
	    $prodname=$selp[0]['ProductName'];
		$ProductStock = $row["ProductStock"];
		$OrderStock = $row["OrderStock"];
		$orderstockid[]=$ID;
		
		if($Status=='4')
		{
			$status='Issue With Store';
		}
		elseif($Status=='2')
		{
			$status='Approved';
		}
		
		
		
?>	
                                              
												<tr id="my_data_tr_<?=$counter?>">
												<td><?=$counter?></td>
													<td><?=$OrderID?></td>
													<td><?=$status?></td>
													<td style="text-align: center">
													<?php 
														if($Status=='4')
		                                                {
															?>
															<a class="btn btn-link"  href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Update</a>
															<?php
														}
														elseif($Status=='2')
														{
															?>
															<a class="btn btn-link"  disabled href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Update</a>
															<?php
														}
													?>
													
													</td>
												</tr>
											
<?php
	}
}
else
{
?>	
												<tr>
													<td></td>
													<td></td>
													<td>No Records Found</td>
													<td></td>
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