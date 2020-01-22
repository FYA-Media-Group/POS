<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Manage Products | Nailspa";
	$strDisplayTitle = "Manage Product Stock for Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblNewProductStocks";
	$strMyTableID = "ProductStockID";
	$strMyField = "ProductID";
	$strMyActionPage = "ProductVariation.php";
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
			 $Colord = Filter($_POST["Color"]);
		     $Size = Filter($_POST["Size"]);
			$Price = Filter($_POST["Price"]);
			 $ProductMRP = Filter($_POST["ProductMRP"]);
			$strStatus = Filter($_POST["Status"]);
			
            $PerQtyServe = Filter($_POST["PerQtyServe"]);
			$Stock = Filter($_POST["Stock"]);
			$productid = Filter($_POST["productid"]);
			$getUID = EncodeQ($productid);
		
			$DB = Connect();
			$sql = "SELECT $strMyTableID FROM $strMyTable WHERE $strMyField='$_POST[$strMyField]'";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						<p>Thi Product already exists in our system. Please try again.</p>
					</div>
				</div>');
			}
			else
			{
				$sqlInsert = "Insert into $strMyTable (Color, Size, Price, Stock, ProductID,Status,PerQtyServe,ProductMRP) VALUES
				('".$Colord."', '".$Size."', '".$Price."', '".$Stock."', '".$productid."','".$strStatus."','".$PerQtyServe."','".$ProductMRP."')";
				//ExecuteNQ($sqlInsert);
				//$DB->close();
				if ($DB->query($sqlInsert) === TRUE) 
				{
					$last_id = $DB->insert_id;
				}
				else
				{
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
				
				$sqlUpdate = "update tblNewProducts set HasVariation='1' where ProductID='".$productid."'";
					ExecuteNQ($sqlUpdate);
			
						echo("<script>location.href='ProductVariation.php?id=$getUID';</script>");
				
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
		if(isset($_GET['id']))
		{
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
					<div class="panel-body">
              			   
                                    <div class="example-box-wrapper">
                                        	<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="90%">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Color</th>
                                                    <th>Size</th>
													<th>Price</th>
													 <th>Stock</th>
													  <th>PerQtyServe</th>
													   <th>ProductMRP</th>
													
													<th class="no-print">Action</th>
                                                </tr>
                                            </thead>
												<tfoot>
													 <th>Product</th>
                                                    <th>Color</th>
                                                    <th>Size</th>
													<th>Price</th>
													 <th>Stock</th>
													  <th>PerQtyServe</th>
													   <th>ProductMRP</th>
													
													<th class="no-print">Action</th>
                                                </tr>
														</tfoot>
                                            <tbody>
											<?php 
											$seld=select("*","tblNewProductStocks","ProductID='".$val['ProductID']."'");
											foreach($seld as $val)
											{
												$sep=select("ProductName","tblNewProducts","ProductID='".$val['ProductID']."'");
												$ProductName=$sep[0]['ProductName'];
												$counter ++;
													$getUIDDelete = Encode($val['ProductStockID']);
												?>
												   <tr id="my_data_tr_<?=$counter?>">
                                                    <td><?php echo $ProductName ?>
                                                    <td><?php echo $val['Color'] ?>
													<input type="hidden" id="prodid" value="<?php echo $val['ProductStockID'] ?>" />
													</td>
                                                    <td class="center"><?php echo $val['Size'] ?></td>
													 <td class="center"><?php echo $val['Price'] ?></td>
													  <td class="center"><?php echo $val['Stock'] ?></td>
													   <td class="center"><?php echo $val['PerQtyServe'] ?></td>
													    <td class="center"><?php echo $val['ProductMRP'] ?></td>
														
													<td class="center">
													
													<a class="btn btn-link font-red" href="javascript:;" onclick="DeleteData('Step30','<?=$getUIDDelete?>', 'Are you sure you want to delete this Product ?','my_data_tr_<?=$counter?>');">Delete</a></td>
                                                  </tr>
												<?php
											}
											?>
											
                                             
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
					
					
											<div class="panel-body ">
											
											
												<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Add Product Variation</h3>
												<div class="example-box-wrapper">
													
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
		else if ($row["Field"]=="Color")
		{
?>	                       
                                                   <input type="hidden" id="productid" name="productid" value="<?php echo $strIDs  ?>" />
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Color", "Color", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Color", "Color", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Color", "Color", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="Size")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Size", "Size", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Size", "Size", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Size", "Size", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="Price")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Price", "Price", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Price", "Price", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Price", "Price", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="ProductMRP")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductMRP", "Product MRP", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("ProductMRP", "Product MRP", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("ProductMRP", "ProductMRP", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="Stock")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Stock", "Stock", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Stock", "Stock", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Stock", "Stock", $row["Field"])?>"></div>
													</div>
<?php
		}
			else if ($row["Field"]=="PerQtyServe")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PerQtyServe", "Per Qty Serve", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("PerQtyServe", "Per Qty Serve", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("PerQtyServe", "PerQtyServe", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="Status")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3">
															<select name="<?=$row["Field"]?>" class="form-control required">
																<option value="0" Selected>Live</option>
																<option value="1">Offline</option>	
															</select>
														</div>
													</div>
<?php	
		}
		
	}
?>
														<div class="form-group"><label class="col-sm-3 control-label"></label>
															<input type="submit" class="btn ra-100 btn-primary" value="Submit">
															
															<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
															
																
<?php
}
$DB->close();
?>													
												</div>
												</form>
												<!----------------Display--->
		
											</div>
											
											
											
					</div>
<!--variation-->


<!--variation-->
		
					
			
										

				</div>
			</div>
	
		
	
				</div>	
				<?php
				}
				else if(isset($_GET['uid']))
				{
					?>
						<div class="example-box-wrapper">
						<div class="tabs">
							
				<!--Manage Tab Start-->
					
					<div id="normal-tabs-2">
					<?php 
					$strIDs = DecodeQ($_GET['uid']);
					?>
					<div class="panel-body">
              			   
						   	<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="ManageProductsMaster.php"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
                                    <div class="example-box-wrapper">
                                        	<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="90%">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Color</th>
                                                    <th>Size</th>
													<th>Price</th>
													 <th>Stock</th>
													  <th>PerQtyServe</th>
													   <th>ProductMRP</th>
													
													<th class="no-print">Action</th>
                                                </tr>
                                            </thead>
												<tfoot>
													 <th>Product</th>
                                                    <th>Color</th>
                                                    <th>Size</th>
													<th>Price</th>
													 <th>Stock</th>
													  <th>PerQtyServe</th>
													   <th>ProductMRP</th>
													
													<th class="no-print">Action</th>
                                                </tr>
														</tfoot>
                                            <tbody>
											<?php 
											$seld=select("*","tblNewProductStocks","ProductID='".$strIDs."'");
											foreach($seld as $val)
											{
												$sep=select("ProductName","tblNewProducts","ProductID='".$val['ProductID']."'");
												$ProductName=$sep[0]['ProductName'];
												$counter ++;
													$getUIDDelete = EncodeQ($val['ProductStockID']);
												?>
												   <tr id="my_data_tr_<?=$counter?>">
                                                    <td><?php echo $ProductName ?>
                                                    <td><?php echo $val['Color'] ?>
													<input type="hidden" id="prodid" value="<?php echo $val['ProductStockID'] ?>" />
													</td>
                                                    <td class="center"><?php echo $val['Size'] ?></td>
													 <td class="center"><?php echo $val['Price'] ?></td>
													  <td class="center"><?php echo $val['Stock'] ?></td>
													   <td class="center"><?php echo $val['PerQtyServe'] ?></td>
													    <td class="center"><?php echo $val['ProductMRP'] ?></td>
														
													<td class="center">
													
														<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUIDDelete?>">Edit</a>
														<a href="#" class="btn btn-xs btn-primary" id="ModalOpenBtn" data-toggle="modal" data-target="#myModalstock">Add Initial Opening Stock</a></td>
														<div class="modal fade" id="myModalstock" role="dialog">
																<div class="modal-dialog">
																
																  <!-- Modal content-->
																	<div class="modal-content">
																		<div class="modal-header">
																		  <button type="button" class="close btn ra-100 btn-primary" data-dismiss="modal">&times;</button>
																		  <h4 class="modal-title">Add Opening Stock</h4>
																		</div>
																		<div class="modal-body">
																			<div class="form-group"><label class="col-sm-3 control-label">Store<span>*</span></label>
																				<div class="col-sm-9">
																				<select class="form-control required"  id="StoreID" onChange="LoadValue(this.value);" name="StoreID" >
																<option value="" selected>-- Select Store --</option>
<? 
                                                                   $sql1 = "SELECT StoreID, StoreName FROM tblStores WHERE Status = 0";
																$RS2 = $DB->query($sql1);
																if ($RS2->num_rows > 0)
																{
																	while($row2 = $RS2->fetch_assoc())
																	{
																		$StoreID = $row2["StoreID"];
																		$StoreName = $row2["StoreName"];	
?>	
																		<option value="<?=$StoreID?>"><?=$StoreName?></option>
<?php
																	}
																}
?>
															</select>
																					</div>
																					</div>
																					
																						<div class="form-group"><label class="col-sm-3 control-label">Stock<span>*</span></label>
																				<div class="col-sm-6">
																				<input type="hidden" name="productid" id="productid"  value="<?= $val['ProductID']?>"/>
																				<input type="hidden" name="productstockid" id="productstockid"  value="<?=$val['ProductStockID']?>"/>
																			
																							<input autofocus type="text" name="" id="Stock" class="form-control " placeholder="Stock">
																							</div>
																							</div>
																				
																					
																					<a href="#" class="btn btn-xs btn-primary" id="AddStock" onClick="AddStock()">Add Stock</a>
<script>
function AddStock()
{
    var Stock = document.getElementById("Stock").value;
	var StoreID = document.getElementById("StoreID").value;
	var productid = document.getElementById("productid").value;
	var productstockid = document.getElementById("productstockid").value;
	
 	if(StoreID!='0')
	{
		$.ajax
	  ({
		type: "POST",
		url: "AddStock.php?Stock="+Stock+"&StoreID="+StoreID+"&productid="+productid+"&productstockid="+productstockid,
		success: function(response) {
		   // document.getElementById("form_result").innerHTML = response;
	//alert(response);
		if($.trim(response)=='2')
		{
			alert('Store Cannot Blank')
		}
		else if($.trim(response)=='4')
		{
			alert('Stock Cannot Blank')
		}
		else if($.trim(response)=='3')
		{
			alert('Record Updated Successfully')
		
			location.reload();
		}
		  // location.reload();
			
		}
	  });
	} 

/* 	$.ajax
	({
		type: "POST",
		url: "AddBrand.php?value="+strBrand+"&BrandAddress="+BrandAddress+"&mobile="+mobile+"&email="+email,
		success: function(response) {
		   // document.getElementById("form_result").innerHTML = response;
		//alert(response);
		if($.trim(response)=='2')
		{
			alert('Brand Name Cannot  Blank')
		}
		else if($.trim(response)=='3')
		{
			alert('Record Updated Successfully')
			var url = window.location.href;    
			url = url+"#normal-tabs-2";
			window.location.href = url;
			location.reload();
		}
		  // location.reload();
			
		}
	}); */
}


</script>
																				
																			
																		
																		
																		</div>
																		<div class="modal-footer">
																		  <button type="button" class="btn ra-100 btn-primary" data-dismiss="modal">Close</button>
																		</div>
																	</div>
																  
																</div>
															</div>
                                                  </tr>
												<?php
											}
											?>
											
                                             
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
					
					
					
											<div class="panel-body">
											
										
													<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email', '.admin_password'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

								
									<h3 class="title-hero">Edit Product</h3>
									<div class="example-box-wrapper">
											
													
<?php
// Create connection And Write Values
$DB = Connect();
	$strIDs = DecodeQ($_GET['uid']);
	$sql = "SELECT * FROM $strMyTable WHERE ProductStockID = '".$strIDs."'";
	
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{
		foreach($row as $key => $val)
		{
		if($key=='ProductStockID')
								{
					?>
																<input type="hidden" name="<?=$key?>" value="<?=Encode($row[$key])?>">	

					<?
								}
		else if ($key=="Color")
		{
?>	                       


                                                 
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Color", "Color", $key)?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$key?>" id="<?=str_replace("Color", "Color", $key)?>" class="form-control required" placeholder="<?=str_replace("Color", "Color", $key)?>" value="<?= $row[$key] ?>"></div>
													</div>
<?php
		}
		else if ($key=="Size")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Size", "Size", $key)?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$key?>" id="<?=str_replace("Size", "Size", $key)?>" class="form-control required" placeholder="<?=str_replace("Size", "Size", $key)?>" value="<?= $row[$key]?>"></div>
													</div>
<?php
		}
		else if ($key=="Price")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Price", "Price", $key)?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$key?>" id="<?=str_replace("Price", "Price", $key)?>" class="form-control required" placeholder="<?=str_replace("Price", "Price", $key)?>" value="<?= $row[$key]?>"></div>
													</div>
<?php
		}
		else if ($key=="ProductMRP")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductMRP", "Product MRP", $key)?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$key?>" id="<?=str_replace("ProductMRP", "Product MRP", $key)?>" class="form-control required" placeholder="<?=str_replace("ProductMRP", "ProductMRP", $key)?>" value="<?= $row[$key]?>"></div>
													</div>
<?php
		}
		else if ($key=="Stock")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Stock", "Stock", $key)?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$key?>" id="<?=str_replace("Stock", "Stock", $key)?>" class="form-control required" placeholder="<?=str_replace("Stock", "Stock", $key)?>"value="<?= $row[$key]?>"></div>
													</div>
<?php
		}
			else if ($key=="PerQtyServe")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PerQtyServe", "Per Qty Serve", $key)?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$key?>" id="<?=str_replace("PerQtyServe", "Per Qty Serve", $key)?>" class="form-control required" placeholder="<?=str_replace("PerQtyServe", "PerQtyServe", $key)?>" value="<?= $row[$key]?>"></div>
													</div>
<?php
		}
	elseif($key=="Status")
								{
					?>
																<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $key)?> <span>*</span></label>
																	<div class="col-sm-2">
																		<select name="<?=$key?>" class="form-control required">
																			<?php
																				if ($row[$key]=="0")
																				{
																			?>
																					<option value="0" selected>Live</option>
																					<option value="1">Offline</option>
																			<?php
																				}
																				elseif ($row[$key]=="1")
																				{
																			?>
																					<option value="0">Live</option>
																					<option value="1" selected>Offline</option>
																			<?php
																				}
																				else
																				{
																			?>
																					<option value="" selected>--Choose option--</option>
																					<option value="0">Live</option>
																					<option value="1">Offline</option>
																			<?php
																				}
																			?>	
																		</select>
																	</div>
																</div>
					<?php	
								}
		
	}
		
	}
?>
														<div class="form-group"><label class="col-sm-3 control-label"></label>
															<input type="submit" class="btn ra-100 btn-primary" value="Update">
																	
																	<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
																
<?php
}
$DB->close();
?>													
												</div>
												</form>
											</div>
											
											
											
					</div>
<!--variation-->


<!--variation-->
		
					
			
										

				</div>
			</div>
	
		
	
				</div>	
				<?php
				}
				else
				{
					
				}
				?>
				</div>
			</div>
		</div>
		</div>
			
			<?php require_once 'incFooter.fya'; ?>
        </div>
        
    </div>
</body>
</html>