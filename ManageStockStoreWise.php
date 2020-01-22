<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?php
	$strPageTitle = "Manage Product Stock | Nailspa";
	$strDisplayTitle = "Manage Product Stock for Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblProductStocks";
	$strMyTableID = "ProductStockID";
	$strMyField1 = "Color";
	$strMyField2 = "Size";
	$strMyField3 = "ProductID";
	$strMyActionPage = "ManageStockStoreWise.php";
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
			$strColor = Filter($_POST["Color"]);
			$strSize = Filter($_POST["Size"]);
			$strPrice = Filter($_POST["Price"]);
			$strStock = Filter($_POST["Stock"]);
			$strPerQtyServe = Filter($_POST["PerQtyServe"]);
			$strProductMRP = Filter($_POST["ProductMRP"]);
			$strProductUID = Filter($_POST["ProductID"]);
			$strStatus = Filter($_POST["Status"]);
			$DB = Connect();
			$sql = "Select $strMyTableID FROM $strMyTable where $strMyField1='$_POST[$strMyField1]' AND ($strMyField2='$_POST[$strMyField2]' AND $strMyField3 LIKE '$_POST[$strMyField3]')";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						<p>The Store Name already exists in our system. Please try again with a different Name.</p>
					</div>
				</div>');
			}
			else
			{
				$sql_ProductID = "SELECT ProductID FROM tblProducts WHERE ProductUniqueCode LIKE '$strProductUID'";
				// echo $sql_ProductID."<br>";
				$RS_ProductID = $DB->query($sql_ProductID);
				$row_ProductID = $RS_ProductID->fetch_assoc();
				$strProductID = $row_ProductID['ProductID'];

				$sqlInsert = "Insert into $strMyTable (Color, Size, Price, Stock, ProductID, PerQtyServe,ProductMRP, Status) values
				('".$strColor."','".$strSize."', '".$strPrice."', '".$strStock."', '".$strProductID."', '".$strPerQtyServe."','".$strProductMRP."', '".$strStatus."')";
				// echo $sqlInsert;
				// die();
				ExecuteNQ($sqlInsert);
				$DB->close();
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
					</div>
				</div>');
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
				else if($key == "ProductID")
				{
				}
				else
				{
					$sqlUpdate = "UPDATE $strMyTable SET $key='$_POST[$key]' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					echo $sqlUpdate."<br>";
					// ExecuteNQ($sqlUpdate);
				}
			}
			die();
			$DB->close();
			die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Updated Successfully</h4>
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
</head>
<script>

	function updatevalues(evt)
	{
		 var puc=$(evt).closest('td').prev().prev().prev().prev().find('input').val();
		//alert(puc)
		var stockid=$(evt).closest('td').prev().prev().prev().prev().prev().find('input').val();
		//alert(stockid)
		var prodid=$(evt).closest('td').prev().prev().prev().prev().prev().prev().find('input').val();
		//alert(prodid)
		var qty=$(evt).closest('td').prev().html();
		//alert(qty)
		var stock=$(evt).closest('td').prev().prev().html();
		//alert(stock)
		var price=$(evt).closest('td').prev().prev().prev().html();
		//alert(price)
		
		if(prodid!="")
		{
			$.ajax({
				type:"post",
				data:"puc="+puc+"&stockid="+stockid+"&prodid="+prodid+"&qty="+qty+"&stock="+stock+"&price="+price,
				url:"updatedata.php",
				success:function(result)
				{
				//alert(result);
				if($.trim(result)=='2')
				{
				 window.location="ManageStockStoreWise.php?q="+puc;
				}
				}
				
				
			})
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
					

                    <div id="page-title">
                        <h2><?=$strDisplayTitle?></h2>
                        <p>Add, Edit, Delete Stock.</p>
                    </div>
<?php

if(!isset($_GET["uid"]))
{

?>					
					
                    <div class="panel">
						<div class="panel">
							<div class="panel-body">
								<?
									$StoreName = Decode($_GET['s']);
									$ProductName = Decode($_GET['q']);
									$DB = Connect();
									$abc="Select ProductName from tblProducts WHERE ProductUniqueCode='$ProductName'";
									// echo "$abc<br>";
									$RS = $DB->query($abc);
									// echo "Hello";
									if ($RS->num_rows > 0) 
									{
										while($row = $RS->fetch_assoc())
										{
											$counter ++;
											$strProductName = $row["ProductName"];
											// echo $strProductName;
										}
									}
								?>
								<div class="example-box-wrapper">
									<div class="tabs">
										<ul>
											<li><a href="#normal-tabs-1" title="Tab 1">Manage</a></li>
											<li><a href="#normal-tabs-2" title="Tab 2">Add</a></li>
											<a href="ManageProductsStock.php" class="btn btn-primary btn-sm" style="float: right;">Go Back</a>
										</ul>
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											<div class="panel-body">
												<h3 class="title-hero">List of Stock for <span style="color: #E91E63"><?=$strProductName?></span></h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Color</th>
																<th>Size</th>
																<th>Price</th>
																<th>Stock</th>
																<th>Per Qty Serve</th>
																<th>Product MRP</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Color</th>
																<th>Size</th>
																<th>Price</th>
																<th>Stock</th>
																<th>Per Qty Serve</th>
																<th>Product MRP</th>
																<th>Actions</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$strProduct=$_GET['q'];
$strP=Decode($strProduct);

// $sq = "SELECT ProductStockID, Color, Size, Price, Stock, ProductID, Status, PerQtyServe from tblProductStocks where Status='0' and ProductID ='$strP'";


$sql1 ="Select 
tblProducts.ProductID ,
tblProducts.ProductUniqueCode,
tblProducts.ProductName,
tblProducts.ProductDescription,
tblProducts.Status,
tblProducts.StoreID,
tblProductStocks.ProductStockID, 
tblProductStocks.Color, 
tblProductStocks.Size, 
tblProductStocks.Price, 
tblProductStocks.Stock, 
tblProductStocks.ProductID, 
tblProductStocks.PerQtyServe, 
tblProductStocks.ProductMRP, 
tblProductStocks.Status 
From tblProducts
Inner Join tblProductStocks 
ON tblProducts.ProductID = tblProductStocks.ProductID where tblProducts.ProductUniqueCode='$strP'";
// echo $sql1;



$RS = $DB->query($sql1);
// echo "Hello";
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strProductStockID = $row["ProductStockID"];
		$getUID = EncodeQ($strProductStockID);
		$getUIDDelete = Encode($strProductStockID);
		$Color = $row["Color"];
		$Size = $row["Size"];
		$Price = $row["Price"];
		$Stock = $row["Stock"];
		$ProductID = $row["ProductID"];
		$strPerQtyServe = $row["PerQtyServe"];
		$strProductMRP = $row["ProductMRP"];
		$Status = $row["Status"];	
		$strProductID = $row["ProductID"];
		$PUC = $row["ProductUniqueCode"];
		$EncodedPUC = EncodeQ($PUC);
		$ProductName = $row["ProductName"];
		$ProductDescription = $row["ProductDescription"];
		$StoreID = $row["StoreID"];
		$Status = $row["Status"];
		
		$sql1 = "SELECT StoreName, StoreID FROM tblStores WHERE StoreID=$StoreID";
		$RS2 = $DB->query($sql1);
		$row2 = $RS2->fetch_assoc();
		$StoreName = $row2["StoreName"];
		$EncodedStoreName = Encode($StoreName);
		$strStoreID = $row2["StoreID"];
?>
					
		
			<tr id="my_data_tr_<?=$counter?>">
				<td><input type="hidden" id="prodid" value="<?=$ProductID?>"/><?=$counter?></td>
				<td><input type="hidden" id="stockid" value="<?=$strProductStockID?>"/><?=$Color?></td>
				<td><input type="hidden" id="puc" value="<?=$EncodedPUC?>"/><?=$Size?></td>
				<td contenteditable='true' id="price"><?=$Price?></td>
				<td contenteditable='true' id="stock"><?=$Stock?></td>
				<td contenteditable='true' id="qty"><?=$strPerQtyServe?></td>
				<td><input type="hidden" id="PMRP" value="<?=$strProductStockID?>"/><?=$strProductMRP?></td>
				<td style="text-align: center">
					<a class="btn btn-link" href="#" onclick="updatevalues(this)">Edit</a>
					<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step6','<?=$getUIDDelete?>', 'Are you sure you want to delete this Store - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
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
				<td></td>
				<td>No Records Found</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		
<?php
}
$DB->close();
?>
														
														</tbody>
													</table>
												</div>
											</div>
										</div>
										
										<div id="normal-tabs-2">
											<div class="panel-body">
												<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Add Stock for <span style="color: #E91E63"><?=$strProductName?></span> at <span style="color: #E91E63"><?echo Decode($_GET['s']);?></span></h3>
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
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Color", "Color", $row["Field"])?></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Color", "Color", $row["Field"])?>" class="form-control" placeholder="<?=str_replace("Color", "Color", $row["Field"])?>"></div>
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
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Price", "Price Per Qty Serve", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Price", "Price Per Qty Serve", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Price Per Qty Serve", "Price", $row["Field"])?> "></div>
													</div>	
<?php
		}
		else if ($row["Field"]=="Stock")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Stock", "Stock", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Stock", "Stock", $row["Field"])?>" class="form-control required admin_email" placeholder="<?=str_replace("Stock", "Stock", $row["Field"])?>"></div>
													</div>	
<?php
		}
		else if ($row["Field"]=="ProductID")
		{
			$str_Product_UCode=$_GET['q'];
			$ProductUCode=Decode($str_Product_UCode);
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductID", "Product Unique ID", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input class="form-control" value="<?=$ProductUCode?>" name="<?=$row["Field"]?>" readonly></div></div>
													</div>	
<?php
		}
		else if ($row["Field"]=="PerQtyServe")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PerQtyServe", "Per Qty Serve", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("PerQtyServe", "Per Qty Serve", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("PerQtyServe", "Per Qty Serve", $row["Field"])?>"></div>
													</div>	
<?php
		}
		else if ($row["Field"]=="ProductMRP")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductMRP", "Product MRP", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("ProductMRP", "Product MRP", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("ProductMRP", "Product MRP", $row["Field"])?>"></div>
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
		else
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Admin", " ", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Admin", " ", $row["Field"])?>"></div>
														</div>
<?php
		}
	}
?>
														<div class="form-group"><label class="col-sm-3 control-label"></label>
															<input type="submit" class="btn ra-100 btn-primary" value="Submit">
															
															<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
														</div>
<?php
}
$DB->close();
?>													
												</div>
												</form>
											</div>
											
											
											
										</div>
										
									</div>
								</div>
							</div>
						</div>
                    </div>
<?php
} // End null condition










//-----------------Normal Edit

else
{
?>						
					
					<div class="panel">
						<div class="panel-body">
							<div class="fa-hover">	
								<a href="javascript:window.location = document.referrer;" class="btn btn-primary btn-lg btn-block"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
						
							<div class="panel-body">
							<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email', '.admin_password'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

									<h3 class="title-hero">Edit Stock</h3>
									<div class="example-box-wrapper">
										
<?php

$strID = DecodeQ($_GET["uid"]);
$strProductUniqueCode = DecodeQ($_GET['n']);
$DB = Connect();
$sql = "select * FROM $strMyTable where $strMyTableID = '$strID'";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{
		foreach($row as $key => $val)
		{
			if($key==$strMyTableID)
			{
?>
											<input type="hidden" name="<?=$key?>" value="<?=Encode($strID)?>">
											

<?php
			}
			elseif($key=="Color")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Color", "Color", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Color", "Color", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="Size")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Size", "Size", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Size", "Size", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="Price")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Price", "Price", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Price", "Price", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="ProductID")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductID", "Product ID", $key)?> <span>*</span></label>
												<div class="col-sm-5"><input readonly type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("ProductID", "Product ID", $key)?>" value="<?=$strProductUniqueCode?>"></div>
											</div>
<?php
			}
			elseif($key=="Stock")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Stock", "Stock", $key)?> <span>*</span></label>
												<div class="col-sm-5"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Stock", "Stock", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="PerQtyServe")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PerQtyServe", "Per Qty Serve", $key)?> <span>*</span></label>
												<div class="col-sm-5"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("PerQtyServe", "Per Qty Serve", $key)?>" value="<?=$row[$key]?>"></div>
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
			else
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Admin", " ", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
		}
	}
?>
											<div class="form-group"><label class="col-sm-3 control-label"></label>
												<input type="submit" class="btn ra-100 btn-primary" value="Update">
												
												<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
											</div>
<?php
}
$DB->close();
?>													
										
									</div>
							</form>
							</div>
						</div>
                   </div>			
<?php
}
?>	                   
                </div>
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>