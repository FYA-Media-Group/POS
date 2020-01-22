<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Store Stock Management | Nailspa";
	$strDisplayTitle = "View inventory for Store Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ViewStoreStock.php";
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
			
		}
		
		if($strStep=="edit")
		{
			
		}
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
									
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of all products available in <?=$strStoreNamedisplay?> Store</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr. no</th>
																<th>Product Name</th>
																<th>Available Stock</th>
																<th>Available Per Qty Serve</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr. no</th>
																<th>Product Name</th>
																<th>Available Stock</th>
																<th>Available Per Qty Serve</th>
																<th>Actions</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
if($strStore=="" || $strStore=="0")
{
	$strStore = DecodeQ(Filter($_GET["q"]));
	$SelectStore = "YES";
}
else
{
	$strStore = $strStore;
	$SelectStore = "NO";
}



$DB = Connect();
$sql = "SELECT tblStoreProduct.StoreProductID, tblStoreProduct.ProductID, tblStoreProduct.Stock, tblStoreProduct.StoreID, tblNewProducts.HasVariation, tblNewProducts.ProductName,tblStoreProduct.UpdatePerQtyServe
		FROM tblNewProducts
		LEFT JOIN tblStoreProduct
		ON tblNewProducts.ProductID=tblStoreProduct.ProductID
		where tblStoreProduct.StoreID='$strStore'
		Group by tblStoreProduct.ProductID";

		
		
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strStoreProductID = $row["StoreProductID"];
		$getUID = EncodeQ($strStoreProductID);
		$strProductID = $row["ProductID"];
		$UpdatePerQtyServe = $row["UpdatePerQtyServe"];
		
		$getUIDPro = EncodeQ($strProductID);
		$getUIDDelete = Encode($strStoreProductID);
		$ProductName = $row["ProductName"];
		$Status = $row["HasVariation"];
		if($Status=="0")
		{
			$Stock = $row["Stock"];
		}
		else
		{
			$Stock = "-";
		}
		
		
		
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$ProductName?></td>
																<td><?=$Stock?></td>
																<td><?=$UpdatePerQtyServe?></td>
																<td>
																<?php
																	if($Status=="1")
																	{
																?>
																		<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUIDPro?>&q=<?=$strStore?>">View Variations</a>
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
																<td></td>
																<td>No Records Found</td>
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
										
										<?php
										if($SelectStore=="YES")
										{
										?>
											<a class="btn btn-primary btn-lg btn-block" href="ManageProductStoreWise.php"><i class="fa fa-backward"></i> &nbsp; Select Store to view inventory</a>
										<?php
										}
										?>
										
									</div>
								</div>
							</div>
						</div>
                    </div>
<?php
} // End null condition
else
{
	
	if($strStore=="" || $strStore=="0")
	{
		$strStore = $_GET["q"];
	}
	else
	{
		$strStore = $strStore;
	}
	
	$strStoreID = EncodeQ($strStore);
?>						
					
					<div class="panel">
						<div class="panel">
							<div class="panel-body">
							<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="<?=$strMyActionPage?>?q=<?=$strStoreID?>"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
								
								<div class="example-box-wrapper">
									<div class="tabs">
										<ul>
											
										</ul>
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of all variations available in <?=$strStoreNamedisplay?> Store</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr. no</th>
																<th>Product Color</th>
																<th>Size</th>
																<th>Available Stock</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr. no</th>
																<th>Product Color</th>
																<th>Size</th>
																<th>Available Stock</th>
															</tr>
														</tfoot>
														<tbody>

<?php



$strID = DecodeQ(Filter($_GET["uid"]));

$DB = Connect();
$sql = "SELECT tblNewProductStocks.ProductStockID, tblNewProductStocks.Color, tblNewProductStocks.Size, tblStoreProduct.Stock
		FROM tblNewProductStocks 
		left join tblStoreProduct
		on tblNewProductStocks.ProductStockID=tblStoreProduct.ProductStockID 
		where tblStoreProduct.ProductID='$strID' and tblStoreProduct.StoreID='$strStore'";
		
		
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strStoreProductStockID = $row["ProductStockID"];
		$getUID = EncodeQ($strStoreProductStockID);
		$getUIDDelete = Encode($strStoreProductStockID);
		$ProductColor = $row["Color"];
		$ProductSize = $row["Size"];
		$ProductStock = $row["Stock"];
		
		
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$ProductColor?></td>
																<td><?=$ProductSize?></td>
																<td><?=$ProductStock?></td>
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
														
														</tbody>
													</table>
												</div>
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
                   </div>
<?php
}
?>
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>