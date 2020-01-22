<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Manage Products | Nailspa";
	$strDisplayTitle = "Manage Product Stock for Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblNewProducts";
	$strMyTableID = "ProductID";
	$strMyField = "ProductUniqueCode";
	$strMyActionPage = "ManageProductsMaster.php";
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
			$strProductUniqueCode = Filter($_POST["ProductUniqueCode"]);
			$strProductName = ucfirst(Filter($_POST["ProductName"]));
			$strBrand = $_POST["Brand"];
			$strProductDescription = ucfirst(Filter($_POST["ProductDescription"]));
			$strStatus = Filter($_POST["Status"]);
			$strCategory= Filter($_POST["Category"]);
			$strProductMRP= Filter($_POST["ProductMRP"]);
			
			$PerQtyServe = Filter($_POST["PerQtyServe"]);
			$Stock = Filter($_POST["Stock"]);
			
			$stpbrnd=implode(",",$strBrand);
			$DB = Connect();
			
			
			$sql = "SELECT $strMyTableID FROM $strMyTable WHERE $strMyField='". $strProductUniqueCode."'";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						<p>This Product already exists in our system. Please try again.</p>
					</div>
				</div>');
			}
			else
			{
				$sqlInsert = "Insert into $strMyTable (ProductUniqueCode, ProductName, Brand, ProductDescription, Status,Stock,PerQtyServe,HasVariation,ProductMRP) VALUES
				('".$strProductUniqueCode."', '".$strProductName."', '".$stpbrnd."', '".$strProductDescription."', '".$strStatus."','".$Stock."','".$PerQtyServe."','0','".$strProductMRP."')";
				
				// echo $sqlInsert;
				// die();
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
				// Insert for category plus product Start-- added by asmita
				$CatInsert= "Insert into tblNewProductCategory(ProductID, CategoryID) VALUES ('".$last_id."', '".$strCategory."')";
				ExecuteNQ($CatInsert);
				// Insert for category plus product End-- added by asmita
				
				
				
				$seldata=select("HasVariation","tblNewProducts","ProductID='".$last_id."'");
				$variation=$seldata[0]['HasVariation'];
				$getUID = EncodeQ($last_id);
				if($variation=="0")
				{
					echo("<script>location.href='ProductVariation.php?id=$getUID';</script>");
				}
				else
				{
					die('<div class="alert alert-close alert-success">
							<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
							<div class="alert-content">
								<h4 class="alert-title">Record Saved Successfully</h4>
								<p></p>
							</div>
						</div>');
				} 
				
			}

		}

		if($strStep=="edit")
		{
			$DB = Connect();
			
				
				 $strProductUniqueCode = Filter($_POST["ProductUniqueCode"]);
		      $strProductName = ucfirst(Filter($_POST["ProductName"]));
			  $strBrand = $_POST["Brand"];
			 $strProductDescription = ucfirst(Filter($_POST["ProductDescription"]));
			$strStatus = Filter($_POST["Status"]);
			$strCategory = Filter($_POST["Category"]);
			
		 $PerQtyServe = Filter($_POST["PerQtyServe"]);
		 $ProductMRP = Filter($_POST["ProductMRP"]);
			$Stock = Filter($_POST["Stock"]);
			
		 $stpbrnd=implode(",",$strBrand);
			foreach($_POST as $key => $val)
			{
				if($key=="step" || $key==$strMyTableID)
				{
					
				}
				else
				{
					$sqlUpdate = "UPDATE $strMyTable SET ProductUniqueCode='".$strProductUniqueCode."',Brand='".$stpbrnd."',ProductName='".$strProductName."',ProductDescription='".$strProductDescription."',Status='".$strStatus."',Stock='".$Stock."',PerQtyServe='".$PerQtyServe."', ProductMRP='".$ProductMRP."' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					ExecuteNQ($sqlUpdate);
					// echo $sqlUpdate;
					// die();
					//Start Update query to update productcategory in tblNewProductCategory- added by asmita
					$UpdateCategory="Update tblNewProductCategory SET CategoryID='".$strCategory."' WHERE ProductID='".Decode($_POST[$strMyTableID])."'";
					ExecuteNQ($UpdateCategory);
					//End Update query to update productcategory in tblNewProductCategory- added by asmita
					
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
function calcost()
{
	
	var mrp=$("#ProductMRP").val();
    var qty=$("#PerQtyServe").val();
	
	if(mrp!="0" && qty!="")
	{
		var perproduct=Number(mrp)/Number(qty);
		$("#productcst").val(perproduct);
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
                        <p>Add, Edit, Delete Brand/Vendor.</p>
                    </div>				
					
				<div class="panel">
				<div class="panel-body">
<?php

	if(!isset($_GET['uid']))
	{
$DB = Connect();
		$strID = $_GET['q'];
		$strStoreID = DecodeQ($strID);
		$sql_store = "SELECT StoreName FROM tblStores WHERE 1";
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
									<h3 class="title-hero">Product Details </h3>
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
													<th>Per Qty Serve</th>
													<th>Product MRP</th>
													<th>Cost Per Service</th>
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
													<th>Per Qty Serve</th>
													<th>Product MRP</th>
													<th>Cost Per Service</th>
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
			$sql = "Select * FROM $strMyTable WHERE 1 ORDER BY $strMyTableID desc";
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
					$vari =Filter($row["HasVariation"]);
					$brandd=explode(",",$Brand);
					$mrp=$row['ProductMRP'];
					$qty=$row['PerQtyServe'];
				    $percst=$mrp/$qty;
					
					$ProductDescription = HTMLDecode($row["ProductDescription"]);
					$StoreID =Filter($row["StoreID"]);
					$Status =Filter($row["Status"]);
							
					$sql1 = "SELECT StoreName FROM tblStores WHERE 1";
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
													<td>
													<?php
														foreach($brandd as $vapp)
														{
																$selpt=select("*","tblProductBrand","BrandID='".$vapp."'");
																$counterbrand ="0";
																foreach($selpt as $val)
																{
																	$counterbrand = $counterbrand + 1;
																	$brandname=$val['BrandName'];
																	echo "<b>".$counterbrand.".</b> ". $brandname."<br>";
																}
														}
													?>
													</td>
													 <td><?=$qty?></td>
													  <td><?=$mrp?></td>
											        <td><?=$percst?></td>
													<td><?=$Status?></td>
													<td>
													<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
														
														<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step29','<?=$getUIDDelete?>', 'Are you sure you want to delete this Product - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
														<?
																$ID = $row["ProductUniqueCode"];
																$ProductUCode = EncodeQ($ID);
																$EncodedStoreName = EncodeQ($StoreName);
														?>
														<br><!--<a class="btn btn-link" href="ManageStockStoreWise.php?q=<?=$ProductUCode?>&s=<?=$EncodedStoreName?>">View Variations</a>-->
														<?php
																	
																	
																	if($vari=='1')
																	{
																		?>
																		<a href="ProductVariation.php?uid=<?=$getUID?>" class="btn btn-link font-red">View Variation</a>
																		<?php
																	}
																	else
																	{
																		?>
																		<a href="#" class="btn btn-xs btn-primary" id="ModalOpenBtn" data-toggle="modal" data-target="#myModalstock">Add Initial Opening Stock</a>
																					
														<!-- Modal -->
															<div class="modal fade" id="myModalstock" role="dialog">
																<div class="modal-dialog">
																
																  <!-- Modal content-->
																  <form id="productdatap">
																	<div class="modal-content">
																		<div class="modal-header">
																		  <button type="button" class="close btn ra-100 btn-primary" data-dismiss="modal">&times;</button>
																		  <h4 class="modal-title">Add Opening Stock</h4>
																		</div>
																		<div class="modal-body">
																		<div class="form-group">
																				<label class="col-sm-6 control-label">Store<span>*</span></label>
															           <label class="col-sm-6 control-label">Stock<span>*</span></label>
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
																	
																				<div class="col-sm-6"><input autofocus type="hidden" name="StoreID[]" id="StoreID" class="form-control StoreID" value="<?=$StoreID?>"><?=$StoreName?></div>
																					
																				<div class="col-sm-6">
																				<input type="hidden" name="productid" id="productid"  value="<?= $strProductID?>"/>
																			
																							<input autofocus type="text" name="Stock[]" id="Stock" class="form-control " placeholder="Stock" class="Stock">
																							</div>
																							
																				
<?php
																	}
																}
?>
													</div>			
																			
																					
																					
																					
																					
<script>
function AddStock()
{

	$.ajax
	  ({
		type: "POST",
		data:$("#productdatap").serialize(), 
		url: "AddStock.php",
		success: function(response) {
			
		   // document.getElementById("form_result").innerHTML = response;
		//alert(response);
	 if($.trim(response)=='4')
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
																		
																		 <button type="button" class="btn ra-100 btn-primary" onclick="AddStock()" >Update</button>
																		  <button type="button" class="btn ra-100 btn-primary" data-dismiss="modal">Close</button>
																		</div>
																	</div>
																  </form>
																</div>
															</div>
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

											
												<h3 class="title-hero">Add Product </h3>
												<div class="example-box-wrapper">
								<script>
function calcost()
{
	//alert(11)
	var mrp=$("#ProductMRP").val();
    var qty=$("#PerQtyServe").val();

	if(mrp!="0" && qty!="")
	{
		var perproduct=Number(mrp)/Number(qty);
		$("#productcst").val(perproduct);
	}
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
															<div class="col-sm-3"><input type="text" style="text-transform:capitalize" name="<?=$row["Field"]?>" id="<?=str_replace("ProductName", "Product Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("ProductName", "Product Name", $row["Field"])?>"></div>
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
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="PerQtyServe" class="form-control required" placeholder="<?=str_replace("PerQtyServe", "PerQtyServe", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="ProductMRP")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductMRP", "Product MRP", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="ProductMRP" onkeyup="calcost()" class="form-control required" placeholder="<?=str_replace("ProductMRP", "Product MRP", $row["Field"])?>" ></div>
														</div>
														<div class="form-group">
															<label class="col-sm-3 control-label">Cost Per Service<span>*</span></label>
																<div class="col-sm-3" onkeyup="calcost()">
																	<input type="text" id="productcst" class="form-control required" readonly />
																</div>
														</div>
															
													
													<div class="form-group"></div>													
<?php
		}
		else if ($row["Field"]=="HasVariation")
		{
?>	
												
<?php
		}
		else if ($row["Field"]=="Brand")
		{
									$sqlBrand = "SELECT BrandID, BrandName FROM tblProductBrand WHERE Status=0 ORDER BY BrandID DESC";
									$RSBrand = $DB->query($sqlBrand);
									if ($RSBrand->num_rows > 0)
									{
									
?>
													<div class="form-group">
														<label class="col-sm-3 control-label"><?=str_replace("Brand", "Brand Name", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3">
															<select class="form-control required"  name="<?=$row["Field"]?>[]" multiple id="brand" style="height:100pt">
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
																					<input autofocus type="text" name="" id="AddBrand" class="form-control " placeholder="<?=str_replace("Brand", "Brand Name", $row["Field"])?>">
																					</div>
																					</div>
																					
																						<div class="form-group"><label class="col-sm-3 control-label">Brand Address<span>*</span></label>
																				<div class="col-sm-6">
																							<textarea autofocus type="text" name="" id="AddBrandAddress" class="form-control " placeholder="BrandAddress"></textarea>
																							</div>
																							</div>
																							<div class="form-group"><label class="col-sm-3 control-label">Mobile<span>*</span></label>
																				<div class="col-sm-6">
																								<input autofocus type="text" name="" id="mobile" class="form-control " placeholder="mobile">
																								</div>
																								</div>
																									<div class="form-group"><label class="col-sm-3 control-label">Email<span>*</span></label>
																				<div class="col-sm-6">
																								<input autofocus type="text" name="" id="email" class="form-control " placeholder="email">
																								</div>
																								</div>
																								
																					
																					<a href="#" class="btn btn-xs btn-primary" id="AddBrand" onClick="AddBrand()">Add</a>
<script>
function AddBrand()
{
	var strBrand = document.getElementById("AddBrand").value;
	var BrandAddress = document.getElementById("AddBrandAddress").value;
	var mobile = document.getElementById("mobile").value;
	var email = document.getElementById("email").value;

	$.ajax
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
	});
}


</script>
																				
																			
																		
																		
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
																					</div>
																					</div>
																					
																						<div class="form-group"><label class="col-sm-3 control-label">Brand Address<span>*</span></label>
																				<div class="col-sm-6">
																							<textarea autofocus type="text" name="" id="AddBrandAddress" class="form-control required" placeholder="BrandAddress"></textarea>
																							</div>
																							</div>
																							<div class="form-group"><label class="col-sm-3 control-label">Mobile<span>*</span></label>
																				<div class="col-sm-6">
																								<input autofocus type="text" name="" id="mobile" class="form-control required" placeholder="mobile">
																								</div>
																								</div>
																									<div class="form-group"><label class="col-sm-3 control-label">Email<span>*</span></label>
																				<div class="col-sm-6">
																								<input autofocus type="text" name="" id="email" class="form-control required" placeholder="email">
																								</div>
																								</div>
																								
																					
																					<a href="#" class="btn btn-xs btn-primary" id="AddBrand" onClick="AddBrand()">Add</a>
<script>
function AddBrand()
{
	var strBrand = document.getElementById("AddBrand").value;
	var BrandAddress = document.getElementById("AddBrandAddress").value;
	var mobile = document.getElementById("mobile").value;
	var email = document.getElementById("email").value;
	$.ajax
	({
		type: "POST",
		url: "AddBrand.php?value="+strBrand+"&BrandAddress="+BrandAddress+"&mobile="+mobile+"&email="+email,
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
										
										<!--Added by Asmita(Start Select Category)-->		
<?
												$sqlBrand = "SELECT CategoryID, CategoryName FROM tblCategories WHERE Status=0 and MainCategoryType=0 ORDER BY CategoryID DESC";
												$RSBrand = $DB->query($sqlBrand);
												if ($RSBrand->num_rows > 0)
												{
?>
													<div class="form-group">
														<label class="col-sm-3 control-label">Select Category<span>*</span></label>
														<div class="col-sm-3">
															<select class="form-control required"  name="Category" id="Category">
																<option value="" selected>--Select Category--</option>
<?
																while($rowBrand = $RSBrand->fetch_assoc())
																{
																	$strCategoryName = $rowBrand["CategoryName"];
																	$strMainCategoryType = $rowBrand["MainCategoryType"];
																	$strCategoryID = $rowBrand["CategoryID"];
?>																	
																	<option value="<?=$strCategoryID?>"><?=$strCategoryName?></option>
<?																
																}
																?>
															</select>
<?
												}				
?>													
														</div>
													</div>
<!--Added by Asmita (End Select Category)-->
										
<?										
										
										
					
								}
		else if ($row["Field"]=="ProductDescription")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductDescription", "ProductDescription", $row["Field"])?> </label>
															<div class="col-sm-6"><textarea name="<?=$row["Field"]?>" style="text-transform:capitalize" id="<?=str_replace("ProductDescription", "ProductDescription", $row["Field"])?>" class="form-control" placeholder="<?=str_replace("ProductDescription", "ProductDescription", $row["Field"])?>"></textarea></div>
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
												</div>
												</form>
											</div>
											</div>
											
											
				
<!--variation-->


<!--variation-->
		
					
					<!--Start Variation Display-->
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
		
		$sql_store = select("*","tblNewProducts","1");
		foreach($sql_store as $val)
		{
			$product_id=$val['ProductID'];
			$product_code=$val['ProductUniqueCode'];
			$product_name=$val['ProductName'];
			$Brand=$val['Brand'];
			$brandd=explode(",",$Brand);
			
			$selp=select("Stock"," tblNewProductStocks","ProductID='".$product_id."'");
			$stock=$selp[0]['Stock'];
		
		?>
		<tr>
			<td><?=$product_code ?></td>
			<td><?=$product_name ?></td>
			<td>
			<?php
			foreach($brandd as $vapp)
			{
					$selpt=select("*","tblProductBrand","BrandID='".$vapp."'");
					foreach($selpt as $val)
					{
						//print_r($val);
						$brandname=$val['BrandName'];
						echo $brandname.",";
						
					}
			}
			?>
			</td>
			<td>
<?php
				$selp=select("Stock"," tblNewProductStocks","ProductID='".$product_id."'");
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
					<!--End Variation Display-->
					
					
					<!--Start Bulk Upload-->
					<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="data-tab">
										
												<?php require_once "ExcelBulkUpload.php"; ?>
										
					</div>
					<!--End Bulk Upload-->			

				</div>
			</div>
	
		
	
					<?	
	} // End of if(isset($_GET['q']) && !isset($_GET['uid']))
		
	else if(isset($_GET['uid']))
	{
		
	
		
					$DB = Connect();
					$strstoreID = DecodeQ(Filter($_GET['q']));
					$EncodedStoreID = EncodeQ($strstoreID);
					$strproductID = DecodeQ(Filter($_GET["uid"]));
					$getUID = EncodeQ($strProductID);
					
		?>
				<div class="panel">
						<div class="panel-body">
							<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="ManageProductsMaster.php"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
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
																	<div class="col-sm-3"><input type="text" style="text-transform:capitalize"  name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("ProductName", "Product Name", $key)?>" value="<?=$row[$key]?>"></div>
																</div>
					<?php
				}
			else if($key=="Brand")
			{
					$selp=select("Brand","tblNewProducts","ProductID='".$strproductID."'");
					$brands=$selp[0]['Brand'];
					$brandd=explode(",",$brands);
									$DB_Brand = $row[$key];
									$sqlBrand = "SELECT BrandID, BrandName FROM tblProductBrand WHERE Status=0 ORDER BY BrandID DESC";
									$RSBrand = $DB->query($sqlBrand);
									$sqlBrand = "SELECT BrandID, BrandName FROM tblProductBrand WHERE Status=0 ORDER BY BrandID DESC";
									$RSBrand = $DB->query($sqlBrand);
									if ($RSBrand->num_rows > 0)
									{
									
?>
													<div class="form-group">
														<label class="col-sm-3 control-label"><?=str_replace("Brand", "Brand Name", $key)?> <span>*</span></label>
														<div class="col-sm-3">
															<select class="form-control required"  name="<?=$key?>[]" multiple id="brand">
																<option value="" selected>--Select Brand--</option>
<?
																while($rowBrand = $RSBrand->fetch_assoc())
																{
																	$strBrandName = $rowBrand["BrandName"];
																	$strBrandID = $rowBrand["BrandID"];
																	
																	if(in_array("$strBrandID",$brandd))
																	{
																		?>
																	<option selected value="<?=$strBrandID?>"><?=$strBrandName?></option>														
<?php
																	}
																	else
																	{
																		?>
																	<option value="<?=$strBrandID?>"><?=$strBrandName?></option>														
<?php
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
																					</div>
																					</div>
																					
																						<div class="form-group"><label class="col-sm-3 control-label">Brand Address<span>*</span></label>
																				<div class="col-sm-6">
																							<textarea autofocus type="text" name="" id="AddBrandAddress" class="form-control " placeholder="BrandAddress"></textarea>
																							</div>
																							</div>
																							<div class="form-group"><label class="col-sm-3 control-label">Mobile<span>*</span></label>
																				<div class="col-sm-6">
																								<input autofocus type="text" name="" id="mobile" class="form-control " placeholder="mobile">
																								</div>
																								</div>
																									<div class="form-group"><label class="col-sm-3 control-label">Email<span>*</span></label>
																				<div class="col-sm-6">
																								<input autofocus type="text" name="" id="email" class="form-control " placeholder="email">
																								</div>
																								</div>
																								
																					
																					<a href="#" class="btn btn-xs btn-primary" id="AddBrand" onClick="AddBrand()">Add</a>
<script>
function AddBrand()
{
	var strBrand = document.getElementById("AddBrand").value;
	var BrandAddress = document.getElementById("AddBrandAddress").value;
	var mobile = document.getElementById("mobile").value;
	var email = document.getElementById("email").value;

	$.ajax
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
	});
}


</script>
																				
																			
																		
																		
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
																					</div>
																					</div>
																					
																						<div class="form-group"><label class="col-sm-3 control-label">Brand Address<span>*</span></label>
																				<div class="col-sm-6">
																							<textarea autofocus type="text" name="" id="AddBrandAddress" class="form-control required" placeholder="BrandAddress"></textarea>
																							</div>
																							</div>
																							<div class="form-group"><label class="col-sm-3 control-label">Mobile<span>*</span></label>
																				<div class="col-sm-6">
																								<input autofocus type="text" name="" id="mobile" class="form-control required" placeholder="mobile">
																								</div>
																								</div>
																									<div class="form-group"><label class="col-sm-3 control-label">Email<span>*</span></label>
																				<div class="col-sm-6">
																								<input autofocus type="text" name="" id="email" class="form-control required" placeholder="email">
																								</div>
																								</div>
																								
																					
																					<a href="#" class="btn btn-xs btn-primary" id="AddBrand" onClick="AddBrand()">Add</a>
<script>
function AddBrand()
{
	var strBrand = document.getElementById("AddBrand").value;
	var BrandAddress = document.getElementById("AddBrandAddress").value;
	var mobile = document.getElementById("mobile").value;
	var email = document.getElementById("email").value;
	$.ajax
	({
		type: "POST",
		url: "AddBrand.php?value="+strBrand+"&BrandAddress="+BrandAddress+"&mobile="+mobile+"&email="+email,
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
function calcost()
{
	//alert(11)
	var mrp=$("#ProductMRP").val();
    var qty=$("#PerQtyServe").val();
	alert(mrp)
alert(qty)
	if(mrp!="0" && qty!="")
	{
		var perproduct=Number(mrp)/Number(qty);
		$("#productcst").val(perproduct);
	}
}
	

</script>
																				
																		
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
			
								
								
								//Start Category edit by Asmita 
								
?>	
					<div class="form-group">
							
<?php										
										
										$sqlcat = "SELECT CategoryID FROM tblNewProductCategory where ProductID='$row[$strMyTableID]'";
										$RScat = $DB->query($sqlcat);
										if ($RScat->num_rows > 0)
										{
											while($rowcat = $RScat->fetch_assoc())
													{
															$catCategoryID = $rowcat["CategoryID"];
															// echo $catCategoryID;
													}
										}
										// echo $sql;
										?>
							<div class="form-group"><label class="col-sm-3 control-label">Select Category<span>*</span></label>
								<div class="col-sm-4">	
									

									<?php
										// echo $DBvalue;
										$sql = "SELECT CategoryID FROM tblCategories";
									
										// echo $sql."<br>";
										$RS2 = $DB->query($sql);
										if ($RS2->num_rows > 0)
										{
									?>
											<select class="form-control required" name="Category" id="Category">
												<?
													while($row2 = $RS2->fetch_assoc())
													{
														
														$getCategoryID = $row2["CategoryID"];
														$CategorynameSelect="Select CategoryName, CategoryID from tblCategories where CategoryID='$getCategoryID' and MainCategoryType=0";
														
														$RS3 = $DB->query($CategorynameSelect);
														if ($RS3->num_rows > 0)
														{
															while($row3 = $RS3->fetch_assoc())
															{
																$CategoryName =  $row3["CategoryName"];
																$CategoryID =  $row3["CategoryID"];
																if($catCategoryID==$CategoryID)
																{
?>
																	<option value="<?=$CategoryID?>" selected><?=$CategoryName?></option>	
<?																
																}
																else
																{
?>																	
																	<option value="<?=$CategoryID?>"><?=$CategoryName?></option>
<?																	
																}
															}
												
														}
													}
												?>
											</select>
									<?php
										}
										else
										{
											echo "Admin Roles are not added. <a href='ManageAdminRoles.php' target='Admin Rol Not Added'>Click here to add</a>";
										}
								?>
								</div>
							</div>
					</div>
<?					
								//End Category edit by Asmita
								
								
								
								
								
								
							}
								elseif($key=="ProductDescription")
								{
									$HTMLDecodedDescription = HTMLDecode($row['ProductDescription']);
					?>

																<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductDescription", "Product Description", $key)?> </label>
																	<div class="col-sm-6"><textarea name="<?=$key?>" style="text-transform:capitalize" class="form-control  wysiwyg" placeholder="<?=str_replace("ProductDescription", "Product Description", $key)?>"><?=$HTMLDecodedDescription?></textarea></div>
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
								elseif($key=="ProductMRP")
								{
					?>	
																<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ProductMRP", "Product MRP", $key)?> <span>*</span></label>
																	<div class="col-sm-3">
																		<input type="" name="<?=$key?>" id="ProductMRP" class="form-control required" placeholder="<?=str_replace("ProductMRP", "Product MRP", $key)?>" value="<?=$row[$key]?>" onkeyup="calcost()">
																	</div>
																</div>
																	<?php
																	$mrp=$row['ProductMRP'];
																	$qty=$row['PerQtyServe'];
																	$percst=$mrp/$qty;
																	?>
																	<div class="form-group">
																		<label class="col-sm-3 control-label">Cost Per Service<span>*</span></label>
																		<div class="col-sm-3">
																			<input type="text" id="productcst" value="<?= $percst?>" class="form-control required" readonly />
																		</div>
																	</div>
					<?php	
								}
								else
								{
									$sepldat=select("HasVariation","tblNewProducts","ProductID='".$strproductID."'");
									$vari=$sepldat[0]['HasVariation'];
									if($vari=='1')
									{
										if($key=="Stock")
									   {
					?>

																<div class="form-group "><label class="col-sm-3 control-label"><?=str_replace("Stock ", "Stock", $key)?> <span>*</span></label>
																	<div class="col-sm-5"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Stock", "Stock", $key)?>" value="<?=$row[$key]?>"></div>
																</div>
					<?php
								   }
								if($key=="PerQtyServe")
								  {
									
					?>

																<div class="form-group "><label class="col-sm-3 control-label"><?=str_replace("PerQtyServe ", "Per Qty Serve", $key)?> <span>*</span></label>
																	<div class="col-sm-5"><input type="text" id="PerQtyServe" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Per Qty Serve", "PerQtyServe", $key)?>" value="<?=$row[$key]?>"></div>
																</div>
					<?php
								  }
								}
								else
								{
									if($key=="Stock")
								   {
					?>

																<div class="form-group "><label class="col-sm-3 control-label"><?=str_replace("Stock ", "Stock", $key)?> <span>*</span></label>
																	<div class="col-sm-5"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Stock", "Stock", $key)?>" value="<?=$row[$key]?>"></div>
																</div>
					<?php
								   }
								if($key=="PerQtyServe")
								  {
									
					?>

																<div class="form-group "><label class="col-sm-3 control-label"><?=str_replace("PerQtyServe ", "Per Qty Serve", $key)?> <span>*</span></label>
																	<div class="col-sm-5"><input type="text" name="<?=$key?>" id="PerQtyServe" class="form-control required" placeholder="<?=str_replace("Per Qty Serve", "PerQtyServe", $key)?>" value="<?=$row[$key]?>"></div>
																</div>
					<?php
								  }
								}
								
								
									
								}
							
							}
						}
					?>
																<div class="form-group"><label class="col-sm-3 control-label"></label>
																	<input type="submit" class="btn ra-100 btn-primary" value="Update">
																	
																	<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
																	<?php
																	
																	$sepldat=select("HasVariation","tblNewProducts","ProductID='".$strproductID."'");
																	$vari=$sepldat[0]['HasVariation'];
																	if($vari=='0')
																	{
																		?>
																		<a href="ProductVariation.php?id=<?= EncodeQ($strproductID)?>" class="btn btn-success">Add Variation</a>
																		<?php
																	}
																	else
																	{
																		
																	}
																	?>
																	
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