<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Vendor Orders| Nailspa";
	$strDisplayTitle = "Vendor Orders of Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportVendorOrder.php";
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


<?php

	if(isset($_GET["toandfrom"]))
	{
		$strtoandfrom = $_GET["toandfrom"];
		$arraytofrom = explode("-",$strtoandfrom);
		
		$from = $arraytofrom[0];
		$datetime = new DateTime($from);
		$getfrom = $datetime->format('Y-m-d');
		
		
		$to = $arraytofrom[1];
		$datetime = new DateTime($to);
		$getto = $datetime->format('Y-m-d');

		if(!IsNull($from))
		{
			$sqlTempfrom = " and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$getto."')";
		}
	}
	
	if(!IsNull($_GET["Store"]))
	{
		$strStoreID = $_GET["Store"];
		
			$sqlTempStore = " StoreID='$strStoreID'";
		
	}
	

?>	


<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	
	<script type="text/javascript" src="assets/widgets/datepicker/datepicker.js"></script>
	<script type="text/javascript">
		/* Datepicker bootstrap */

		$(function() {
			"use strict";
			$('.bootstrap-datepicker').bsdatepicker({
				format: 'mm-dd-yyyy'
			});
		});
		
		function printDiv(divName) 
		{
	
	    var divToPrint = document.getElementById("printdata");
    var htmlToPrint = '' +
        '<style type="text/css">' +
        'table th, table td {' +
        'border:1px solid #000;' +
        'padding;0.5em;' +
        '}' +
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
			// var printContents = document.getElementById(divName);
			// var originalContents = document.body.innerHTML;

			// document.body.innerHTML = printContents;

			// window.print();

			// document.body.innerHTML = originalContents; 
		}

	</script>
	<script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker.js"></script>
	<script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker-demo.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker-demo.js"></script>
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
												<h3 class="title-hero">List of Vendor Product Orders</h3>
												
												<form method="get" class="form-horizontal bordered-row" role="form">
													
														    	<div class="form-group"><label for="" class="col-sm-4 control-label">Select Vendor</label>
														<div class="col-sm-4">
														
							<select name="Brand" class="form-control">
																<option value="0">All</option>
																<?
                                                       $selp=select("*","tblProductBrand","Status='0'");
													foreach($selp as $val)
													{
														$BrandName = $val["BrandName"];
														$BrandID = $val["BrandID"];
														$brand=$_GET["Brand"];
														if($brand==$BrandID)
														{
															?>
														<option  selected value="<?=$BrandID?>" ><?=$BrandName?></option>														
<?php                   
														}
														else
														{
															?>
														<option value="<?=$BrandID?>" ><?=$BrandName?></option>														
<?php                   
														}

													}
?>
															</select>
		
												</div>
															
														</div>
												      	<div class="form-group"><label for="" class="col-sm-4 control-label">Select Store</label>
														<div class="col-sm-4">
														
							<select name="store" class="form-control">
																
																<?php
																
																if($strStore=='0')
																{
																	$strStatement="";
																}
																else
																{
																	$strStatement=" and StoreID='$strStore'";
																}
                                                    $selp=select("*","tblStores","Status='0' $strStatement");
													foreach($selp as $val)
													{
														$strStoreName = $val["StoreName"];
														$strStoreID = $val["StoreID"];
														$store=$_GET["store"];
														if($store==$strStoreID)
														{
															?>
														<option  selected value="<?=$strStoreID?>" ><?=$strStoreName?></option>														
<?php                   
														}
														else
														{
															?>
														<option value="<?=$strStoreID?>" ><?=$strStoreName?></option>														
<?php                   
														}

													}
?>
															</select>
		
												</div>
															
														</div>
												
												
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportVendorOrder.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
															<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
													</div>
												
												</form>
												
												<br>
												<div id="printdata">
												<?php
												$brand=$_GET["Brand"];
											   if(isset($_GET["Brand"]) )
												{
											
														$storrr=$_GET["store"];
													if($storrr=='0')
													{
														$storrrp='All';
													}
													else{
													$stpp=select("StoreName","tblStores","StoreID='".$storrr."'");
				                                   $StoreName=$stpp[0]['StoreName'];
														$storrrp=$StoreName;
													}
												?>
														<h3 class="title-hero">Store - <?=$storrrp?></h3>
												
												<br>
												
												
												
												<div class="example-box-wrapper">
												
<?php
	$DB = Connect();
$storrr=$_GET["store"];
$Brand=$_GET["Brand"];

$sepq=select("*","tblProductBrand","BrandID='".$Brand."'");
		$BrandName=$sepq[0]['BrandName'];
	echo "<b>Vendor Name  :</b><b>	" . $BrandName . "</b><br>";
?>
	<table  class="table table-bordered table-striped table-condensed cf" width="100%">
														<thead>
															<tr>
															   <th style="text-align:center">Sr</th>
																<th style="text-align:center">Product Ordered</th>
																<th style="text-align:center">Qty</th>
															
																<th style="text-align:center">Balance</th>
																<th style="text-align:center">Previous Pending</th>
															
															    <th style="text-align:center">Store</th>
															   
															</tr>
														</thead>
													
														<tbody>

<?php
if(!empty($storrr))
{
	if(!empty($Brand))
	{
			$sql = "Select count(tblFinalOrder.ProductStock) as productstock ,count(tblFinalOrder.OrderStock) as orderstock,count(tblFinalOrder.RemainStock) as remainstock,tblFinalOrder.StoredID,tblNewProducts.Stock from tblFinalOrder left join tblNewProducts on tblFinalOrder.ProductID=tblNewProducts.ProductID  WHERE tblFinalOrder.StoredID='".$storrr."' and tblFinalOrder.BrandID='".$Brand."'";
	}
	else
	{
		$sql = "Select count(tblFinalOrder.ProductStock) as productstock ,count(tblFinalOrder.OrderStock) as orderstock,count(tblFinalOrder.RemainStock) as remainstock,tblFinalOrder.StoredID,tblNewProducts.Stock from tblFinalOrder left join tblNewProducts on tblFinalOrder.ProductID=tblNewProducts.ProductID  WHERE tblFinalOrder.StoredID='".$storrr."' and tblFinalOrder.BrandID!='0'";
	}

	
}


$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$stocksm="";
		$cntprd = $row["cntprd"];
		
		$productstock = $row["productstock"];
		$orderstock = $row["orderstock"];
		$remainstock = $row["remainstock"];
		
		$stocksm += $row["Stock"];
		$balancestock=$stocksm-$orderstock;
		$StoredID = $row["StoredID"];
	
		$sep=select("*","tblStores","StoreID='".$storrr."'");
		$storename=$sep[0]['StoreName'];
		
		
		
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><center><?=$counter?></center></td>
															    <td><center><?=$orderstock?></center></td>
																<td><center><?=$stocksm?></center></td>
																
														
																<td><center><?=$balancestock?></center></td>
																<td><center><?=$remainstock?></center></td>
															
															   <td><center><?=$storename?></center></td>
																
															</tr>
<?php
	}
	$stocksm="";
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
														
																
															
															</tr>
													
														
<?php
}
$DB->close();
													}	
													else
														{
															echo "<br><center><h3>Please Select Brand Name!</h3></center>";
														}	
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
                    </div>
<?php
} // End null condition
else
{
	
}
?>
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>