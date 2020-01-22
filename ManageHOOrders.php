<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Place Order Request| Nailspa";
	$strDisplayTitle = "Place Order Request| Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblOrder";
	$strMyTableID = "OrderID";
	$strMyActionPage = "ManageHOOrders.php";
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
		 $DB = Connect();
		$strStep = Filter($_POST["step"]);
		if($strStep=="add")
		{
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
			
        $StoreID = Filter($_POST["StoreID"]);
		$DB = Connect();
		//print_r($_POST);
		$category = Filter($_POST["category"]);
	    $cntcat=count($category);
		 $ServiceID = Filter($_POST["ServiceID"]);
		$productstock = $_POST["Products"];
		 $cntprod=count($productstock);
		$productqty = Filter($_POST["productqty"]);
	
		for($i=0;$i<count($productstock);$i++)
		{
			
			$sqldata1 = "SELECT count(*) FROM tblFinalOrder WHERE ProductID='".$productstock[$i]."' or ProductStock='".$productstock[$i]."' and ServiceID='".$ServiceID."' and AdminID='".$strAdminID."' and StoredID='".$StoreID."'";
					
						$RSdiscountt = $DB->query($sqldata1);
					
						if ($RSdiscountt->num_rows > 0) 
						{
							while($rowdiscountt = $RSdiscountt->fetch_assoc())
							{
								
								$cnt = $rowdiscountt["count(*)"];
							
								
						
							}
						}
						else
						{
							
						}
				
		/* 	$sepp=select("count(*)","tblFinalOrder","ProductID='".$productstock[$i]."' or ProductStock='".$productstock[$i]."' and ServiceID='".$ServiceID."'");
			echo $cnt=$sepp[0]['count(*)']; */
		}
	
			if($cntcat<=0 || $ServiceID=='' || $ServiceID=='0' || $cntprod<=0)
			{
			
					die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Please Fill Required Fields</h4>
						<p></p>
					</div>
				</div>');
			}
			elseif($cnt<=0)
			{
				ECHO 123;
					die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Please Fill Required Fields</h4>
						<p></p>
					</div>
				</div>');
			}
			else
			{
				 $selp=select("ID","tblFinalOrder","AdminID='".$strAdminID."' and OrderID='0' and StoredID='".$StoreID."'");	
		 foreach($selp as $vap)
		 {
			 $orderidd[]=$vap['ID'];
		 }
		//print_r($orderidd);
	      $selp=select("count(OrderID)","tblOrderLog","1");
    	 $cntt=$selp[0]['count(OrderID)'];
		
	if($cntt>0)
		{
			$selpt=select("OrderID","tblOrderLog","1 order by ID desc");
		$ord=$selpt[0]['OrderID'];
			
			   $ordidd=$ord+1;
				$sqlInsert = "Insert into tblOrderLog (OrderID) VALUES('".$ordidd."')";
				
				//echo $sqlInsert;
					if ($DB->query($sqlInsert) === TRUE) 
				{
					$last_id = $DB->insert_id;
				}
				else
				{
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
				for($i=0;$i<count($orderidd);$i++)
				{
						$sqlUpdate = "UPDATE tblFinalOrder SET OrderID='".$ordidd."',Status='1' where ID='".$orderidd[$i]."'";
					ExecuteNQ($sqlUpdate);
					//echo $sqlUpdate;
		        }
				
				 $seldata=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='4'");
			   $email=$seldata[0]['AdminEmailID'];
			   $cname=$seldata[0]['AdminFullName'];
			   
			   
			      $seldata1=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='36'");
			   $superadminemail=$seldata1[0]['AdminEmailID'];
			   $amyn=$seldata1[0]['AdminFullName'];
			   
			
			      $seldata2=select("AdminID","tblAdminStore","StoreID='".$StoreID
				  ."'");
			   $adminid=$seldata2[0]['AdminID'];
			 
			     $seldata3=select("AdminEmailID,AdminFullName","tblAdmin","AdminID='".$adminid."'");
			      $storeemail=$seldata3[0]['AdminEmailID']; 
				
				  
			    $strTo = $storeemail;
				$strFrom = "order@nailspaexperience.com";
			    $cc = $email;
				$cc1="";
				$strSubject = "Order Request Details";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$Name = $cname;
				$strcc1=$storeemail;
				$strcc2="";
				$table='<table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
            <tbody>
            <tr>
            <th width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Product Name</th>
            <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Color</th>
            <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Size</th>
            <th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:left; padding-left:2%;">Available Stock</th>
            <th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Order Stock</th>


        </tr>';
	
		 $seldatap=select("*","tblFinalOrder","OrderID='".$ordidd."' and Status='1' and AdminID='".$strAdminID."'");
				
				foreach($seldatap as $data)
				{
					
					$prodid=$data['ProductID'];
					$ProductStockID=$data['ProductStockID'];
					$AvailableStock=$data['AvailableStock'];
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
				$message = file_get_contents('EmailFormat/OrderRequest.html');
				$message = eregi_replace("[\]",'',$message);              
				//setup vars to replace
				$vars = array('{OrderID}','{Path}','{table_data}','{Order_No}'); //Replace varaibles
				$values = array($ordidd,$path,$table,$ordidd);
				//replace vars
				$message = str_replace($vars,$values,$message);
			 //   echo $message;               
				 $strBody = $message;             
				$flag='OR';
				$id = $ordidd;
				sendordermail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus,$cc,$cc1);
				
					echo("<script>location.href='ManageNewOrders.php';</script>");
		}
		else
		{
			$ordidd=1;
			$sqlInsert = "Insert into tblOrderLog (OrderID) VALUES('".$ordidd."')";
		
		//	echo $sqlInsert;
				if ($DB->query($sqlInsert) === TRUE) 
				{
					$last_id = $DB->insert_id;
				}
				else
				{
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
				for($i=0;$i<count($orderidd);$i++)
				{
						$sqlUpdate = "UPDATE tblFinalOrder SET OrderID='".$ordidd."',Status='1' where ID='".$orderidd[$i]."'";
					ExecuteNQ($sqlUpdate);
					//echo $sqlUpdate;
		        }
				
			   $seldata=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='4'");
			   $email=$seldata[0]['AdminEmailID'];
			   $cname=$seldata[0]['AdminFullName'];
			   
			   
			      $seldata1=select("AdminEmailID,AdminFullName","tblAdmin","AdminType='0' and AdminRoleID='36'");
			   $superadminemail=$seldata1[0]['AdminEmailID'];
			   $amyn=$seldata1[0]['AdminFullName'];
			   
			
			      $seldata2=select("AdminID","tblAdminStore","StoreID='".$StoreID
				  ."'");
			   $adminid=$seldata2[0]['AdminID'];
			 
			     $seldata3=select("AdminEmailID,AdminFullName","tblAdmin","AdminID='".$adminid."'");
			      $storeemail=$seldata3[0]['AdminEmailID']; 
				
			    $strTo = $storeemail;
				$strFrom = "order@nailspaexperience.com";
			    $cc = $email;
				$cc1="";
				$strSubject = "Order Request Details";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$Name = $cname;
				$strcc1=$storeemail;
				$strcc2="";
				$table='<table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
            <tbody>
            <tr>
            <th width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Product Name</th>
            <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Color</th>
            <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Size</th>
            <th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:left; padding-left:2%;">Available Stock</th>
            <th width="25%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Order Stock</th>


        </tr>';
	
		 $seldatap=select("*","tblFinalOrder","OrderID='".$ordidd."' and Status='1' and AdminID='".$strAdminID."'");
				
				foreach($seldatap as $data)
				{
					
					$prodid=$data['ProductID'];
					$ProductStockID=$data['ProductStockID'];
					$AvailableStock=$data['AvailableStock'];
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
				$message = file_get_contents('EmailFormat/OrderRequest.html');
				$message = eregi_replace("[\]",'',$message);              
				//setup vars to replace
				$vars = array('{OrderID}','{Path}','{table_data}','{Order_No}'); //Replace varaibles
				$values = array($ordidd,$path,$table,$ordidd);
				//replace vars
				$message = str_replace($vars,$values,$message);
			 //   echo $message;               
				 $strBody = $message;             
				$flag='OR';
				$id = $ordidd;
				sendordermail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus,$cc,$cc1);
	echo("<script>location.href='ManageNewOrders.php';</script>");
			
		}

			
	
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
$(document).ready(function(){
$("#submit").hide();			
			   
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
function LoadValue1()
{
		var store=$("#StoreID").val();
		//alert(store)
		if(store!="0")
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
		else
		{
			alert('Select Store')
		}
/* 	$.ajax({
		type:"post",
		data:"storeid="+store,
		url:"storecategoryorder.php",
		success:function(res)
		{
	alert(res)
		var rep = $.trim(res);
		$("#catid").show();
			$("#catid").html("");
						$("#catid").html("");
						$("#catid").html(rep);
		}
		
		}) */
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
		$strID = $_GET['id'];

		$strIDs = DecodeQ($strID);
		$sql_store = "SELECT StoreName FROM tblStores WHERE 1";
		$RS_store = $DB->query($sql_store);
		$row_store = $RS_store->fetch_assoc();
		$strStoreName = $row_store['StoreName'];
		
	?>

					<div class="example-box-wrapper">
						<div class="tabs">
							
				<!--Manage Tab Start-->
					
					<div id="normal-tabs-2">
					<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="ManageProductsMaster.php"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
					
					
					
											<div class="panel-body ">
											
											
												<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Order Request</h3>
												<div class="example-box-wrapper">
												<?php
												$sql1 = "SELECT StoreID, StoreName from tblStores where Status=0";
			
											$RS2 = $DB->query($sql1);
											if ($RS2->num_rows > 0)
											{
?>											
												<div class="form-group"><label class="col-sm-3 control-label">Store Name<span>*</span></label>
													<div class="col-sm-4">
														<select class="form-control "  name="StoreID" id="StoreID"  onChange="LoadValue1();">
															<option value="" selected>--SELECT NAME--</option>
<?
																while($row2 = $RS2->fetch_assoc())
																{
																	$StoreID = $row2["StoreID"];
																	$StoreName = $row2["StoreName"];	
?>
																	<option value="<?=$StoreID?>" ><?=$StoreName?></option>
<?php
																}
?>
														</select>
<?php
											}
										?>
														</div>
														</div>
												<script>
		
		function checktype()
		{
		var type=$("#type").val();
		//aler
		var store=$("#StoreID").val();
	
	 if(type!="0")
		{
		$.ajax({
		type:"post",
		data:"type="+type+"&store="+store,
		url:"servicecategoryho.php",
		success:function(res)
		{
//alert(res)
	    
			var rep= $.trim(res);
			$("#serviceid").show();
			$("#serviceid").html("");
			$("#serviceid").html("");
			$("#serviceid").html(rep);
	
		
	
	
	
		}
		
		})
		}
		
		
		}
		
function checkproduct()
			{
				//alert(111)
				//alert(12233)
		valuable=[];
		var valuable = $('#ServiceID').val();
		$.ajax({
					type: 'POST',
					url: "serviceproduct.php",
					data: {
						id:valuable
						
					},
					success: function(response) {
			
						var rep= $.trim(response);
						$("#prodid").show();
						$("#prodid").html("");
						$("#prodid").html("");
						$("#prodid").html(response);
						//asmita1
						/* $("#asmita1").show();
						$("#asmita1").html("");
						$("#asmita1").html(response); */
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$("#prodid").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						//alert (response);
					}
				}); 
			}
			
			function ProdDetails()
			{
				valuable=[];
				var valuable = $('#prodidd').val();
				var servicee=$('#ServiceID').val();
				var store=$("#StoreID").val();
	//alert(valuable)
	//alert(servicee)
				 $.ajax({
					type: 'POST',
					url: "producthodetails.php",
					data: {
						id:valuable,
						service:servicee,
						store:store
						
					},
					success: function(response) {
				//alert(response)
						
						var rep= $.trim(response);
						$("#productdetails").show();
						$("#productdetails").html("");
						$("#productdetails").html("");
						$("#productdetails").html(response);
						//asmita1
						/* $("#asmita1").show();
						$("#asmita1").html("");
						$("#asmita1").html(response); */
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$("#productdetails").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						//alert (response);
					}
				}); 
			}
			</script>
													
<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SHOW COLUMNS FROM ".$strMyTable." ";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{
		
		if($row["Field"]==$strMyTableID)
		{
		}
		else if($row["Field"]=="StoredID")
		{
			
		}
		else if ($row["Field"]=="CategoryID")
		{
?>	                                         <input type="hidden" id="storeid" value="<?= $strStore ?>" />
                                               <span id="catid"></span>
													
											
											
<?php

		}
		else if($row["Field"]=="ServiceID")
		{
			?>
			<span id="serviceid"></span>
			<?php
		}

	else if($row["Field"]=="ProductID")
		{
			?>
			<span id="prodid"></span>
			<div id="productdetails"></div>
			<?php
		}
	
		
	}
	
	?>
														<div class="form-group"><label class="col-sm-3 control-label"></label>
															<input type="submit" id="submit" class="btn ra-100 btn-primary" value="Submit">
															
															<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
															
																
<?php
}
$DB->close();
?>													
												</div>
												</form>
												<!----------------Display--->
		<script>
		function orderconfirm(evt)
			{
			//alert(1111)
			 var qty=$(evt).closest('td').prev().find('input').val();
			// alert(qty)
			  var stock=$(evt).closest('td').prev().prev().find('input').val();
			  //alert(stock)
			   var prodid=$(evt).closest('td').prev().prev().prev().prev().find('input').val();
			     var prodidstock=$(evt).closest('td').prev().prev().prev().find('input').val();
		//	alert(prodidstock)
		 $valuprod=[];
			 $valuservice=[];
		var valuprod = $('#prodidd').val();
		var valuservice = $('#ServiceID').val();
		var store = $('#StoreID').val();
		var catid=$("#type").val();
	//alert(store)

			 if(store!="0" && store!="")
			   {
				    if(qty!="" && qty!="0")
					{
						if(qty<0)
						{
							alert('Quantity cannot be negative')
						}
						else
						{
							if(Number(stock) < Number(qty))
							{
								alert('Quantity cannot be greater than stock')
							}
							else
							{
								 if(prodid!="0")
								  {
								   $.ajax({
									   type:"post",
									   data:"qty="+qty+"&stock="+stock+"&prodid="+prodid+"&catid="+catid+"&valuservice="+valuservice+"&prodidstock="+prodidstock+"&store="+store,
									   url:"addtohoorder.php",
									   success:function(response)
									   {
										  // alert(response)
										   if($.trim(response)=='4')
										   {
												var p = evt.parentNode.parentNode;
												p.parentNode.removeChild(p);
												$("#submit").show();
										   }
										   else if($.trim(response)=='2')
										   {
											   alert('This Product is already order for this service')
										   }
										   
									   }
									   
								   })
								 }
							}
								
						}
						
					}
					else
					{
						alert('Quantity cannot be blank')
					}
				
			   }
			   else
			   {
				   alert('Store Cannot Blank')
			   } 
			
		
			}
		</script>
											</div>
											
											
											
					</div>
<!--variation-->


<!--variation-->
		
					
			
										

				</div>
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