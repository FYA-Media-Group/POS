<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Manage Products | Nailspa";
	$strDisplayTitle = "Manage Product Stock for Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblProducts";
	$strMyTableID = "ProductID";
	$strMyField = "Color";
	$strMyActionPage = "ManageProductDetailsStoreWise.php";
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
			$strProductUniqueCode = Filter($_POST["ProductUniqueCode"]);
			$strProductName = Filter($_POST["ProductName"]);
			$strBrand = Filter($_POST["Brand"]);
			$strProductDescription = Filter($_POST["ProductDescription"]);
			$strStatus = Filter($_POST["Status"]);
			$strStoreID = Filter($_POST["StoreID"]);
			

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
				$sqlInsert = "Insert into $strMyTable (ProductUniqueCode, ProductName, Brand, ProductDescription, Status, StoreID) VALUES
				('".$strProductUniqueCode."', '".$strProductName."', '".$strBrand."', '".$strProductDescription."', '".$strStatus."', '".$strStoreID."')";
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
				
	<?
	if(isset($_GET['q']) && !isset($_GET['uid']))
	{	
$DB = Connect();
		$strID = $_GET['q'];
		$strStoreID = DecodeQ($strID);
		$sql_store = "SELECT StoreName FROM tblStores WHERE StoreID=$strStoreID";
		$RS_store = $DB->query($sql_store);
		$row_store = $RS_store->fetch_assoc();
		$strStoreName = $row_store['StoreName'];
	?>
					<div class="example-box-wrapper">
						<div class="tabs">
							<ul>
								<li><a href="#normal-tabs-1" title="Tab 1">Manage</a></li>
								<li><a href="#normal-tabs-2" title="Tab 2">Add</a></li>
								<li><a href="#normal-tabs-3" title="Tab 3">View Variations</a></li>
										<li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">Add Bulk Data</a>
							</ul>
				<!--Manage Tab Start-->
							<div id="normal-tabs-1">
							
								<span class="form_result">&nbsp; <br></span>
								
								<div class="panel-body">
									<div class="fa-hover">	
										<a href="ManageProductStoreWise.php" class="btn btn-primary btn-lg btn-block btn-sm"><i class="fa fa-backward"></i> &nbsp; Go back to Stores | Nailspa</a>
									</div>
								</div>
								<div class="panel-body">
									<h3 class="title-hero">Product Details at <?=$strStoreName?></h3>
									<div class="example-box-wrapper">
										<div class="row">
				<!--Start Products section-->			
									<div class="example-box-wrapper">
										<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0">
											<thead>
												<tr>
													<th>Sr.No</th>
													<th>ProductUniqueCode</th>
													<th>ProductName</th>
													<th>Brand</th>
													<th>Status</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Sr.No</th>
													<th>ProductUniqueCode</th>
													<th>ProductName</th>
													<th>Brand</th>
													<th>Status</th>
													<th>Actions</th>
												</tr>
											</tfoot>
											<tbody>
			<?php
			// Create connection And Write Values
			$DB = Connect();
			$strID = DecodeQ(Filter($_GET['q']));
			$EncodedStoreID = EncodeQ($strID);
			$sql = "Select * FROM $strMyTable WHERE StoreID=$strID ORDER BY $strMyTableID desc";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$counter = 0;

				while($row = $RS->fetch_assoc())
				{
					$counter ++;
					$strProductID = $row["ProductID"];
					$getUID = EncodeQ($strProductID);
					$getUIDDelete = Encode($strProductID);
					$ProductUniqueCode = HTMLDecode($row["ProductUniqueCode"]);
					$ProductName =Filter($row["ProductName"]);
					$Brand =Filter($row["Brand"]);
					$ProductDescription = HTMLDecode($row["ProductDescription"]);
					$StoreID =Filter($row["StoreID"]);
					$Status =Filter($row["Status"]);
							
					$sql1 = "SELECT StoreName FROM tblStores WHERE StoreID=$StoreID";
					$RS2 = $DB->query($sql1);
					$row2 = $RS2->fetch_assoc();
					$StoreName = $row2["StoreName"];
					
					if($Status=="0")
					{
						$Status = "Live";
					}
					else
					{
						$Status = "Offline";
					}
			?>	
												<tr id="my_data_tr_<?=$counter?>">
													<td><?=$counter?><br></td>
													<td><?=$ProductUniqueCode?></td>
													<td><?=$ProductName?></td>
													<td><?=$Brand?></td>
											
													<td><?=$Status?></td>
													<td>
													<a class="btn btn-link" href="<?=$strMyActionPage?>?q=<?=$EncodedStoreID?>&uid=<?=$getUID?>">Edit</a>
														
														<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step7','<?=$getUIDDelete?>', 'Are you sure you want to delete this Product - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
														<?
																$ID = $row["ProductUniqueCode"];
																$ProductUCode = EncodeQ($ID);
																$EncodedStoreName = EncodeQ($StoreName);
														?>
														<br><!--<a class="btn btn-link" href="ManageStockStoreWise.php?q=<?=$ProductUCode?>&s=<?=$EncodedStoreName?>">View Variations</a>-->
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
													<td></td>
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
				<!--End Products section-->
									</div>
								</div>
								
							</div>
				<!--End Manage Tab-->
				
				<!--Start Add Tab-->
					<div id="normal-tabs-2">
											<div class="panel-body">
												<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Add Product at <?=$strStoreName?></h3>
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
		else if ($row["Field"]=="ProductUniqueCode")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductUniqueCode", "Product Unique Code", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("ProductUniqueCode", "Product Unique Code", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("ProductUniqueCode", "Product Unique Code", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="ProductName")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductName", "Product Name", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("ProductName", "Product Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("ProductName", "Product Name", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="Brand")
		{
									$sqlBrand = "SELECT BrandID, BrandName FROM tblProductBrand WHERE Status=0 ORDER BY BrandID DESC";
									$RSBrand = $DB->query($sqlBrand);
									if ($RSBrand->num_rows > 0)
									{
										// echo "Heyyyy";
?>
													<div class="form-group">
														<label class="col-sm-3 control-label"><?=str_replace("Brand", "Brand Name", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3">
															<select class="form-control required"  name="<?=$row["Field"]?>">
																<option value="" selected>--Select Brand--</option>
<?
																while($rowBrand = $RSBrand->fetch_assoc())
																{
																	$strBrandName = $rowBrand["BrandName"];
																	$strBrandID = $rowBrand["BrandID"];
?>
																	<option value="<?=$strBrandID?>"><?=$strBrandName?></option>														
<?php
																}
?>
															</select>
														</div>
														<a href="#" class="btn btn-xs btn-primary" id="ModalOpenBtn" data-toggle="modal" data-target="#myModal">Add New Brand</a>
														<!-- Modal -->
															<div class="modal fade" id="myModal" role="dialog">
																<div class="modal-dialog">
																
																  <!-- Modal content-->
																	<div class="modal-content">
																		<div class="modal-header">
																		  <button type="button" class="close btn ra-100 btn-primary" data-dismiss="modal">&times;</button>
																		  <h4 class="modal-title">Add Brand</h4>
																		</div>
																		<div class="modal-body">
																			<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Brand", "Brand Name", $row["Field"])?> <span>*</span></label>
																				<div class="col-sm-6">
																					<input autofocus type="text" name="" id="AddBrand" class="form-control required" placeholder="<?=str_replace("Brand", "Brand Name", $row["Field"])?>">
																					<a href="#" class="btn btn-xs btn-primary" id="AddBrand" onClick="AddBrand()">Add</a>
<script>
function AddBrand()
{
	var strBrand = document.getElementById("AddBrand").value;
	$.ajax
	({
		type: "POST",
		url: "AddBrand.php?value="+strBrand,
		success: function(response) {
		   // document.getElementById("form_result").innerHTML = response;
		  // alert(response);
		  // location.reload();
			var url = window.location.href;    
			url = url+"#normal-tabs-2";
			window.location.href = url;
			location.reload();
		}
	});
}


</script>
																				</div>
																			</div>
																		
																		
																		</div>
																		<div class="modal-footer">
																		  <button type="button" class="btn ra-100 btn-primary" data-dismiss="modal">Close</button>
																		</div>
																	</div>
																  
																</div>
															</div>
															  <!--Modal Ends Here-->
													</div>
<?
									}
									else 
										{
?>
													<div class="form-group">
														<label class="col-sm-3 control-label"><?=str_replace("Brand", "Brand Name", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3">
															<label class="col-sm-8 control-label">No Brands Added!</label><br>
															<a href="#" class="btn btn-xs btn-primary" id="ModalOpenBtn" data-toggle="modal" data-target="#myModal">Add Brand</a>
															<!-- Modal -->
															<div class="modal fade" id="myModal" role="dialog">
																<div class="modal-dialog">
																
																  <!-- Modal content-->
																	<div class="modal-content">
																		<div class="modal-header">
																		  <button type="button" class="close btn ra-100 btn-primary" data-dismiss="modal">&times;</button>
																		  <h4 class="modal-title">Add Brand</h4>
																		</div>
																		<div class="modal-body">
																			<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Brand", "Brand Name", $row["Field"])?> </label>
																				<div class="col-sm-6">
																					<input autofocus type="text" name="" id="AddBrand" class="form-control" placeholder="<?=str_replace("Brand", "Brand Name", $row["Field"])?>">
																					<a href="#" class="btn btn-xs btn-primary" id="AddBrand" onClick="AddBrand()">Add</a>
<script>
function AddBrand()
{
	var strBrand = document.getElementById("AddBrand").value;
	$.ajax
	({
		type: "POST",
		url: "AddBrand.php?value="+strBrand,
		success: function(response) {
		   // document.getElementById("form_result").innerHTML = response;
		  // alert(response);
		  // location.reload();
			var url = window.location.href;    
			url = url+"#normal-tabs-2";
			window.location.href = url;
			location.reload();
		}
	});
}


</script>
																				</div>
																			</div>
																		
																		
																		</div>
																		<div class="modal-footer">
																		  <button type="button" class="btn ra-100 btn-primary" data-dismiss="modal">Close</button>
																		</div>
																	</div>
																  
																</div>
															</div>
															  <!--Modal Ends Here-->
														</div>
													</div>



													
<?
										}
					?>
					<?php
								}
		else if ($row["Field"]=="ProductDescription")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductDescription", "ProductDescription", $row["Field"])?> </label>
															<div class="col-sm-6"><textarea name="<?=$row["Field"]?>" id="<?=str_replace("ProductDescription", "ProductDescription", $row["Field"])?>" class="form-control wysiwyg" placeholder="<?=str_replace("ProductDescription", "ProductDescription", $row["Field"])?>"></textarea></div>
													</div>
<?php
		}
		else if ($row["Field"]=="StoreID")
		{
			
?>
													<div class="form-group hidden"><label class="col-sm-3 control-label"><?=str_replace("StoreID", "Store Name", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" value="<?=$strStoreID?>" readonly name="<?=$row["Field"]?>" id="<?=str_replace("StoreID", "Store Name", $row["Field"])?>" class="form-control" placeholder="<?=str_replace("StoreID", "Store Name", $row["Field"])?>"></div>
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
					<div id="normal-tabs-3">
						<button type="button" class="btn btn-info" id="btnPrint" data-toggle="button" ><center>Print</center></button>
						<div id="printdata"><center>
					<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" border="1px">
											<thead>
												<tr>
													
													<th>Product Unique Code</th>
													<th>Product Name</th>
													<th>Brand</th>
													<th>Stock</th>
													
													
												</tr>
											</thead>
											<tfoot>
												<tr>
													
													<th>Product Unique Code</th>
													<th>Product Name</th>
													<th>Brand</th>
													<th>Stock</th>
													
												</tr>
											</tfoot>
											<tbody>
											<?php 
											$DB = Connect();
		$strID = $_GET['q'];
		$strStoreID = DecodeQ($strID);
		$sql_store = select("*","tblProducts","StoreID='".$strStoreID."'");
		foreach($sql_store as $val)
		{
		$product_id=$val['ProductID'];
		$product_code=$val['ProductUniqueCode'];
		$product_name=$val['ProductName'];
		$Brand=$val['Brand'];
		$selp=select("Stock","tblProductStocks","ProductID='".$product_id."'");
		$stock=$selp[0]['Stock'];
		
		?>
		<tr>
			<td><?=$product_code ?></td>
			<td><?=$product_name ?></td>
			<td><?=$Brand ?></td>
			<td>
				<?php
				$selp=select("Stock","tblProductStocks","ProductID='".$product_id."'");
				echo $stock=$selp[0]['Stock'];
				
				?>
			</td>
		</tr>
		<?php
		}
		
											?>
											</tbody>
											</table>
											</center>
											</div>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="data-tab">
										
												<?php require_once "ExcelBulkUpload.php"; ?>
										
										</div>
										

				</div>
			</div>
					
		<?	
	} // End of if(isset($_GET['q']) && !isset($_GET['uid']))
		
	else if(isset($_GET['q']) && isset($_GET['uid']))
	{
		
					$DB = Connect();
					$strstoreID = DecodeQ(Filter($_GET['q']));
					$EncodedStoreID = EncodeQ($strstoreID);
					$strproductID = DecodeQ(Filter($_GET["uid"]));
		?>
				<div class="panel">
						<div class="panel-body">
							<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="ManageProductDetailsStoreWise.php?q=<?=$EncodedStoreID?>"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
						
							<div class="panel-body">
							<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email', '.admin_password'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

								
									<h3 class="title-hero">Edit Product</h3>
									<div class="example-box-wrapper">
											
			
					
					
		<?			
					

					$sql = "SELECT * FROM $strMyTable WHERE $strMyTableID = '$strproductID'";
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
																<input type="hidden" name="<?=$key?>" value="<?=Encode($strproductID)?>">	

					<?php
								}
								elseif($key=="ProductUniqueCode")
								{
					?>	
																<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductUniqueCode", "Product Unique Code", $key)?> <span>*</span></label>
																	<div class="col-sm-3"><input readonly type="" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("ProductUniqueCode", "Product Unique Code", $key)?>" value="<?=$row[$key]?>"></div>
																</div>
					<?php
								}
								elseif($key=="ProductName")
								{
					?>

																<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductName", "Product Name", $key)?> <span>*</span></label>
																	<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("ProductName", "Product Name", $key)?>" value="<?=$row[$key]?>"></div>
																</div>
					<?php
				}
			else if($key=="Brand")
			{
										$DB_Brand = $row[$key];
										$sqlBrand = "SELECT BrandID, BrandName FROM tblProductBrand WHERE Status=0 ORDER BY BrandID DESC";
										$RSBrand = $DB->query($sqlBrand);
										if ($RSBrand->num_rows > 0)
										{
											// echo "Heyyyy";
	?>
														<div class="form-group">
															<label class="col-sm-3 control-label"><?=str_replace("Brand", "Brand Name", $key)?> <span>*</span></label>
															<div class="col-sm-3">
																<select class="form-control required"  name="<?=$key?>">
																	<option value="" selected>--Select Brand--</option>
	<?
																	while($rowBrand = $RSBrand->fetch_assoc())
																	{
																		$strBrandName = $rowBrand["BrandName"];
																		$strBrandID = $rowBrand["BrandID"];
																		if($strBrandID == $DB_Brand)
																		{
																			?><option value="<?=$strBrandID?>" selected><?=$strBrandName?></option> <?
																		}
																		else
																		{
																			?><option value="<?=$strBrandID?>"><?=$strBrandName?></option><?
																		}
																	}
	?>
																</select>
															</div>
															<a href="#" class="btn btn-xs btn-primary" id="ModalOpenBtn" data-toggle="modal" data-target="#myModal">Add New Brand</a>
															<!-- Modal -->
																<div class="modal fade" id="myModal" role="dialog">
																	<div class="modal-dialog">
																	
																	  <!-- Modal content-->
																		<div class="modal-content">
																			<div class="modal-header">
																			  <button type="button" class="close btn ra-100 btn-primary" data-dismiss="modal">&times;</button>
																			  <h4 class="modal-title">Add Brand</h4>
																			</div>
																			<div class="modal-body">
																				<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Brand", "Brand Name", $row["Field"])?> <span>*</span></label>
																					<div class="col-sm-6">
																						<input autofocus type="text" name="" id="AddBrand" class="form-control " placeholder="<?=str_replace("Brand", "Brand Name", $row["Field"])?>">
																						<a href="#" class="btn btn-xs btn-primary" id="AddBrand" onClick="AddBrand()">Add</a>
	<script>
	function AddBrand()
	{
		var strBrand = document.getElementById("AddBrand").value;
		$.ajax
		({
			type: "POST",
			url: "AddBrand.php?value="+strBrand,
			success: function(response) {
			   // document.getElementById("form_result").innerHTML = response;
			  // alert(response);
			  // location.reload();
				var url = window.location.href;    
				url = url+"#normal-tabs-2";
				window.location.href = url;
				location.reload();
			}
		});
	}


	</script>
																					</div>
																				</div>
																			
																			
																			</div>
																			<div class="modal-footer">
																			  <button type="button" class="btn ra-100 btn-primary" data-dismiss="modal">Close</button>
																			</div>
																		</div>
																	  
																	</div>
																</div>
																  <!--Modal Ends Here-->
														</div>
										
<?										
										}
								}
								elseif($key=="ProductDescription")
								{
									$HTMLDecodedDescription = HTMLDecode($row['ProductDescription']);
					?>

																<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductDescription", "Product Description", $key)?> </label>
																	<div class="col-sm-6"><textarea name="<?=$key?>" class="form-control  wysiwyg" placeholder="<?=str_replace("ProductDescription", "Product Description", $key)?>"><?=$HTMLDecodedDescription?></textarea></div>
																</div>
					<?php
								}
								elseif($key=="StoreID")
								{
					?>

																<div class="form-group hidden"><label class="col-sm-3 control-label"><?=str_replace("StoreID", "Store ID", $key)?> <span>*</span></label>
																	<div class="col-sm-5"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("StoreID", "Store ID", $key)?>" value="<?=$row[$key]?>"></div>
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
	}
		?>		
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