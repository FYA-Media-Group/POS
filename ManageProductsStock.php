<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Manage Product Stock | Nailspa";
	$strDisplayTitle = "Manage Product Stock for Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblProducts";
	$strMyTableID = "ProductID";
	$strMyField = "Color";
	$strMyActionPage = "ManageProductsStock.php";
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
			// echo $strProductUniqueCode."<br>";
			$strProductName = Filter($_POST["ProductName"]);
			$strProductDescription = Filter($_POST["ProductDescription"]);
			$strStatus = Filter($_POST["Status"]);
			$strBrand = Filter($_POST["Brand"]);
			$strStoreID = $_POST["StoreID"];
		
			$strServiceCategory = $_POST["ServiceCategory"];
			
			$asmita=implode(',',$strServiceCategory);
			// echo $strServiceCategory."<br>";
			$DB = Connect();
			$sql = "Select $strMyTableID from $strMyTable where $strMyField='$_POST[$strMyField]'";
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
				$strServiceCategory = $_POST["ServiceCategory"];
				foreach($strStoreID as $store)
				{
					$sqlInsert = "Insert into $strMyTable (ProductUniqueCode,Brand, ProductName, ProductDescription,  Status, StoreID) VALUES
					('".$strProductUniqueCode."','".$strBrand."','".$strProductName."', '".$strProductDescription."','".$strStatus."', '".$store."')";
					// echo $sqlInsert."<br>";
					ExecuteNQ($sqlInsert);
					$selp=select("ProductID","tblProducts","StoreID='".$store."' and ProductUniqueCode='$strProductUniqueCode'");
					foreach($selp as $val)
					{
						$prod[]=$val['ProductID'];
						// echo $prod[]."<br>";
					  	$sqlInsert1 = "Insert into tblProductCategory(ProductID,StoredID,CategoryID) VALUES('".$val['ProductID']."','".$store."','".$strServiceCategory."')";
						// echo $sqlInsert1."<br>";
						ExecuteNQ($sqlInsert1);
					}
				}
				// die();
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
			// $strServiceCategory = $_POST["ServiceCategory"];

		    $strProductUniqueCode = $_POST["ProductUniqueCode"];
			// echo $strProductUniqueCode."<br>";
			$strProductName = $_POST["ProductName"];
			$strProductDescription = $_POST["ProductDescription"];
			$strStatus = $_POST["Status"];
			$strBrand = $_POST["Brand"];
			$strStoreID = $_POST["StoreID"];
			$CategoryID = $_POST["CategoryID"];
			
			// echo $storesd;
			
		
				if($key=="step" || $key==$strMyTableID)
				{
					
				}
				else
				{
					//echo Decode($_POST[$strMyTableID]);
					$sqlUpdate = "UPDATE $strMyTable SET ProductName='".$strProductName."',ProductDescription='".$strProductDescription."',Brand='".$strBrand."',StoreID='".$strStoreID."' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
				
					ExecuteNQ($sqlUpdate);
				$sqlUpdate123 = "UPDATE tblProductCategory SET StoredID='".$strStoreID."',CategoryID='".$CategoryID."' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
						ExecuteNQ($sqlUpdate123);
				      //  echo $sqlUpdate123;
					// echo $sqlUpdate."<br>";
					//exit;
				}
			
				
				// echo $sqlUpdate1."<br>";
					
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
	
</head>

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
                        <p>Add, edit, delete Product Stock</p>
                    </div>
					
<?php

if(!isset($_GET["uid"]))
{	
?>				
				<div class="panel">
					<div class="panel">
							<div class="panel-body">
								
								<div class="example-box-wrapper">
									<div class="tabs">
										<ul>
											<li><a href="#normal-tabs-1" title="Tab 1">Manage</a></li>
											<li><a href="#normal-tabs-2" title="Tab 2">Add</a></li>
										</ul>
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Product Stock | Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr. No</th>				
																<th>Store Name</th>	
																<th>Brand</th>	
																<th>Product Unique Code</th>	
																<th>Product Name</th>
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr. No</th>		
																<th>Store Name</th>	
																<th>Brand</th>	
																<th>Product Unique Code</th>		
																<th>Product Name</th>		
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</tfoot>
														<tbody>
<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SELECT * FROM tblProducts WHERE Status='0' order by $strMyTableID desc";
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
					$Brand = Filter($row["Brand"]);
					$ProductUniqueCode = HTMLDecode($row["ProductUniqueCode"]);
					$ProductName =Filter($row["ProductName"]);
					$StoreID = Filter($row["StoreID"]);
					$Status = Filter($row["Status"]);
					
					$sql1 = "SELECT StoreName, StoreID FROM tblStores WHERE StoreID=$StoreID";
					$RS2 = $DB->query($sql1);
					$row2 = $RS2->fetch_assoc();
					$StoreName = $row2["StoreName"];
					$EncodedStoreID = EncodeQ($StoreID);
					
					
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
													<td><?=$StoreName?></td>
													<td>
													<?
														// $sqlBrand = "SELECT BrandName, BrandID FROM tblProductBrand WHERE BrandID=$Brand";
														// $RSBrand = $DB->query($sqlBrand);
														// $rowBrand = $RSBrand->fetch_assoc();
														// $BrandName = $rowBrand["BrandName"];
														// $EncodedBrandID = EncodeQ($BrandID);
														echo $Brand;
													?>
													</td>
													<td><?=$ProductUniqueCode?></td>
													<td><?=$ProductName?></td>
													<td><?=$Status?></td>
													<td>
													<a class="btn btn-link" href="<?=$strMyActionPage?>?s=<?=$EncodedStoreID?>&uid=<?=$getUID?>">Edit</a>
														
														<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step7','<?=$getUIDDelete?>', 'Are you sure you want to delete this Product - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
														<?
																$ID = $row["ProductUniqueCode"];
																$ProductUCode = EncodeQ($ID);
																$EncodedStoreName = EncodeQ($StoreName);
														?>
														<br><a class="btn btn-link" href="ManageStockStoreWise.php?q=<?=$ProductUCode?>&s=<?=$EncodedStoreName?>">View Variations</a>
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
										</div>
										
										<div id="normal-tabs-2">
											<div class="panel-body">
												<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Add New Product</h3>
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
													$sql3 = "select CategoryID, CategoryName FROM tblCategories where Status = 0 and CategoryType='1'";
													$RS3 = $DB->query($sql3);
													if ($RS3->num_rows > 0)
													{
?>
														<div class="form-group"><label class="col-sm-3 control-label">Select Service Category</label>
															<div class="col-sm-3">
																<select class="form-control required"  name="ServiceCategory" >
																	<option value="" selected>-- Select Service Category --</option>
<?
																	while($row3 = $RS3->fetch_assoc())
																	{
																		$CategoryID = $row3["CategoryID"];
																		$CategoryName = $row3["CategoryName"];	
?>
																		<option value="<?=$CategoryID?>"><?=$CategoryName?></option>
<?php
																	}
?>
																</select>
															</div>
														</div>	
<?
													}
													
?>
													
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
																			<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Brand", "Brand Name", $row["Field"])?> </label>
																				<div class="col-sm-6">
																					<input autofocus type="text" name="" id="AddBrand" class="form-control" placeholder="<?=str_replace("Brand", "Brand Name", $row["Field"])?>">
																					<a href="#" class="btn btn-xs btn-primary" id="AddBrand" onClick="AddBrand()">Add</a>
<script>
function AddBrand()
{
	var strBrand = document.getElementById("AddBrand").value;
	if (strBrand==="")
	{
		alert("Brand Name can not be blank");
		return false;						
	}
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
																			<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Brand", "Brand Name", $row["Field"])?></label>
																				<div class="col-sm-6">
																					<input autofocus type="text" name="" id="AddBrand" class="form-control" placeholder="<?=str_replace("Brand", "Brand Name", $row["Field"])?>">
																					<a href="#" class="btn btn-xs btn-primary" id="AddBrand" onClick="AddBrand()">Add</a>
<script>
function AddBrand()
{
	var strBrand = document.getElementById("AddBrand").value;
	if (strBrand==="")
	{
		alert("Brand Name can not be blank");
		return false;						
	}
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
															<div class="col-sm-4"><textarea name="<?=$row["Field"]?>" id="<?=str_replace("ProductDescription", "ProductDescription", $row["Field"])?>" class="form-control wysiwyg" placeholder="<?=str_replace("ProductDescription", "ProductDescription", $row["Field"])?>"></textarea></div>
													</div>
<?php
		}
		else if ($row["Field"]=="StoreID")
		{
			$sql1 = "select StoreID, StoreName FROM tblStores where Status = 0";
			$RS2 = $DB->query($sql1);
			if ($RS2->num_rows > 0)
			{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreID", "Store Name", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3">
															<select class="form-control required"  name="<?=$row["Field"]?>[]" multiple style="height:80pt">
															<option value="" selected>-- Select Store --</option>
<?
														while($row2 = $RS2->fetch_assoc())
														{
															$StoreID = $row2["StoreID"];
															$StoreName = $row2["StoreName"];	
?>
															<option value="<?=$StoreID?>"><?=$StoreName?></option>
<?php
														}
?>
														</select>
															</div>
													</div>	
<?php
			}
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
	

	//Main Category - - Edit Start
	else
	{
	?>				
						<div class="panel">
							<div class="panel-body">
								<div class="fa-hover">	
									<a class="btn btn-primary btn-lg btn-block" href="<?=$strMyActionPage?>"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
								</div>
							
								<div class="panel-body">
									<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', '','.imageupload'); return false;">
												
									<span class="result_message">&nbsp; <br> </span>
									<br>
									<input type="hidden" name="step" value="edit">

									
										<h3 class="title-hero">Edit Product Stock</h3>
										<div class="example-box-wrapper">
	<?php

	$strID = DecodeQ(Filter($_GET["uid"]));
	// echo $strID;
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
				elseif($key=="ProductUniqueCode")
				{
						$Productcd=$row[$key];
						// echo $Productcd."<br>";
	?>	
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductUniqueCode", "Product Unique Code", $key)?> <span>*</span></label>
													<div class="col-sm-3"><input readonly type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("ProductUniqueCode", "Product Unique Code", $key)?>" value="<?=$row[$key]?>"></div>
												</div>
	<?php
				}
				elseif($key=="ProductName")
				{
	?>				
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductName", "Product Name", $key)?> <span>*</span></label>
													<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("ProductName", "Product Name", $key)?>" value="<?=$row[$key]?>"></div>
												</div>
											<div class="form-group"><label class="col-sm-3 control-label">Category<span>*</span></label>
												<div class="col-sm-4">
													<select name="CategoryID" class="form-control" >
														<option value="0">Select Here</option>
														<?php  
												         $sepp=select("CategoryID","tblProductCategory","ProductID='".$strID."'");
														 $catid=$sepp[0]['CategoryID'];
															$sql_display = "SELECT * FROM tblCategories where CategoryType='1'";
															$RS_display = $DB->query($sql_display);
															if ($RS_display->num_rows > 0) 
															{
																while($row_display = $RS_display->fetch_assoc())
																{
																	$StoreName = $row_display["CategoryName"];
																	$StoreID = $row_display["CategoryID"];
																	if($catid==$StoreID)
																	{
																		?>
																		<option selected value="<?=$StoreID?>"><?=$StoreName?></option>
																		<?php
																	}
																	else
																	{
																		?>
																		<option value="<?=$StoreID?>"><?=$StoreName?></option>
																	<?
																	}
																	
																	
																}
															}
														?>
													</select>
												</div>
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
		if (strBrand==="")
	{
		alert("Brand Name can not be blank");
		return false;						
	}
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
																				<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Brand", "Brand Name", $row["Field"])?> <span>*</span></label>
																					<div class="col-sm-6">
																						<input autofocus type="text" name="" id="AddBrand" class="form-control required" placeholder="<?=str_replace("Brand", "Brand Name", $row["Field"])?>">
																						<a href="#" class="btn btn-xs btn-primary" id="AddBrand" onClick="AddBrand()">Add</a>
	<script>
	function AddBrand()
	{
		var strBrand = document.getElementById("AddBrand").value;
		if (strBrand==="")
	{
		alert("Brand Name can not be blank");
		return false;						
	}
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
			elseif($key=="ProductDescription")
			{
					$HTMLDecodedDescription = HTMLDecode($row['ProductDescription']);
	?>

												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductDescription", "Product Description", $key)?></label>
													<div class="col-sm-4"><textarea name="<?=$key?>" class="form-control wysiwyg" placeholder="<?=str_replace("ProductDescription", "Product Description", $key)?>"><?=$HTMLDecodedDescription?></textarea></div>
												</div>
<?php
			}
			elseif($key=="StoreID")
			{
				$Store=$row[$key];
				// echo $Store."<br>";
				// echo $row[$key]."<br>";
			
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreID", "Store Name", $key)?> <span>*</span></label>
												<div class="col-sm-3">
													<select name="<?=$key?>" class="form-control required" >
														<option value="0" >--Select Store--</option>
													<?php  
													
														
															$sql_display = "SELECT * FROM tblStores";
															$RS_display = $DB->query($sql_display);
															if ($RS_display->num_rows > 0) 
															{
																while($row_display = $RS_display->fetch_assoc())
																{
																	$StoreName = $row_display["StoreName"];
																	$StoreID = $row_display["StoreID"];

																	if ($StoreID==$Store)
																	{
																	?>
																		<option selected value="<?=$StoreID?>"><?=$StoreName?></option>
																	<?
																	}
																	else
																	{
																	?>
																		<option value="<?=$StoreID?>"><?=$StoreName?></option>
																	<?
																	}
																}
															}
														?>
													</select>
												</div>
											</div>
<?php
			}
			elseif($key=="Brand")
			{
				$Brand=$row["Brand"];
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Brand", "Brand", $key)?> <span>*</span></label>
												<div class="col-sm-3">
													<select name="<?=$key?>" class="form-control required">
														<option value="0" >--Select Brand--</option>
												<?php		$sql3 = "SELECT BrandID, BrandName FROM tblProductBrand";
														
															$Res3 = $DB->query($sql3);
															if ($Res3->num_rows > 0) 
															{
																while($row_store = $Res3->fetch_assoc())
																{
																	$varBrandID = $row_store['BrandID'];
																	echo $varBrandID;
																	$varBrandName = $row_store['BrandName'];
																	if($varBrandID == $Brand)
																	{
																	?>
																		<option value="<?=$varBrandID?>" selected><?=$varBrandName?></option>
															<?		}
																	else
																	{
																	?>
																		<option value="<?=$varBrandID?>"><?=$varBrandName?></option>
															<?		}
																}
															}
													?>						
													</select>
												</div>
											</div>											
	<?php
				}
				elseif($key=="Status")
				{
	?>
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Status", "Status", $key)?> <span>*</span></label>
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
    </div>
</body>

</html>									