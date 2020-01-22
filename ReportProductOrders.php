<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Product Orders| Nailspa";
	$strDisplayTitle = "Product Orders Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportProductOrders.php";
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
			$sqlTempfrom = " and Date(tblFinalOrder.OrderStartDate)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblFinalOrder.OrderCompleteDate)<=Date('".$getto."')";
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
		$("#heading").show();
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
												<h3 class="title-hero">List of Product Orders</h3>
												
												<form method="get" class="form-horizontal bordered-row" role="form">
													<div class="form-group"><label for="" class="col-sm-4 control-label">Select date</label>
														<div class="col-sm-4">
															<div class="input-prepend input-group">
																<span class="add-on input-group-addon">
																	<i class="glyph-icon icon-calendar"></i>
																</span> 
																<input type="text" name="toandfrom" id="daterangepicker-example" class="form-control" value="<?=$strtoandfrom?>">
															</div>
														</div>
													</div>
													<div class="form-group"><label for="" class="col-sm-4 control-label">Select Store</label>
													<div class="col-sm-4">
														<select name="store" class="form-control">
															<option value="0">All</option>
<?
																$selp=select("*","tblStores","Status='0'");
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
														<a class="btn btn-link" href="ReportProductOrders.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														   <button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
														<?//=$sqlTempfrom?>
													</div>
												
												</form>
												
												<br>
<?php
											
													if(isset($_GET["toandfrom"]))
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
                                           <div id="printdata">
												<h2 class="title-hero" id="heading" style="display:none"><center>Report Product Orders</center></h2>
												<br>
												<h3 class="title-hero">Store - <?=$storrrp?></h3>
												
												
												
												
												
												<div class="example-box-wrapper">
													<table id="printdata" class="table table-bordered table-striped table-condensed cf" width="100%">
														<thead>
														<?													

																if($storrr=='0')
																{
																	?>
																	<tr>
																		<th style="text-align:center">Sr</th>
																		<th style="text-align:center">Store</th>
																		<th style="text-align:center">Product Ordered</th>
																		<th style="text-align:center">Qty</th>
																		<th style="text-align:center">Product Received</th>
																		<th style="text-align:center">Amount</th>
																		<th style="text-align:center">Pending Orders</th>
																		<th style="text-align:center">Issue With Orders</th>
																		<th style="text-align:center">Cancelled Orders</th>
																		<th style="text-align:center">Transferred Orders</th>
																	</tr>
																	<?
																}
																else
																{
?>
																	<tr>
																		<th style="text-align:center">Sr</th>
																		<th style="text-align:center">Product Ordered</th>
																		<th style="text-align:center">Qty</th>
																		<th style="text-align:center">Product Received</th>
																		<th style="text-align:center">Amount</th>
																		<th style="text-align:center">Pending Orders</th>
																		<th style="text-align:center">Issue With Orders</th>
																		<th style="text-align:center">Cancelled Orders</th>
																		<th style="text-align:center">Transferred Orders</th>
																		<?
																		if($storrr=='0')
																		{
																			
																		}
																		else
																		{
?>
																			<th style="text-align:center">Store</th>
<?																	
																		}
																		?>
																	</tr>
<?																	
																}
?>
															
														</thead>
														
														<tbody>

<?php
$DB = Connect();
$storrr=$_GET["store"];
if(!empty($storrr))
{
	$sql = "Select count(tblFinalOrder.ProductID) as cntprd,count(tblFinalOrder.ProductStock) as productstock ,count(tblFinalOrder.OrderStock) as orderstock,tblFinalOrder.StoredID,tblNewProducts.Stock from tblFinalOrder left join tblNewProducts on tblFinalOrder.ProductID=tblNewProducts.ProductID  WHERE tblFinalOrder.StoredID='".$storrr."'  $sqlTempfrom $sqlTempto";
		$sept=select("count(*)","tblFinalOrder","Status='1' and StoredID='".$storrr."' $sqlTempfrom $sqlTempto");
		$pendingoreders=$sept[0]['count(*)'];
		//earlier Status was 0 , now changed to 1 for pending order
			$sepq=select("count(*)","tblFinalOrder","(Status='10' or Status='11' or Status='3' or Status='4' or Status='2') and StoredID='".$storrr."' $sqlTempfrom $sqlTempto ");
			// $Selects="Select Count(*) from tblFinalOrder where (Status='10' or Status='11' or Status='3' or Status='4' or Status='2' ) and StoredID='".$storrr."' $sqlTempfrom $sqlTempto ";
			// echo $Selects."<br>";
			// print_r($sepq);
			// echo "<br>";
		$issueorder=$sepq[0]['count(*)'];
		//Added extra status 2 
		$sepp=select("count(*)","tblFinalOrder","Status='5' and StoredID='".$storrr."' $sqlTempfrom $sqlTempto");
		$cancelorders=$sepp[0]['count(*)'];
		$seppp=select("count(*)","tblFinalOrder","Status='12' or Status='9' and StoredID='".$storrr."' $sqlTempfrom $sqlTempto");
		$transferorder=$seppp[0]['count(*)'];
		$sepppR=select("SUM(OrderStock)","tblFinalOrder","(Status='9' OR Status='12') and StoredID='".$storrr."' $sqlTempfrom $sqlTempto");
		$ReceiedProductss="Select SUM(OrderStock) as sumofproducts from tblFinalOrder where StoredID='".$storrr."' AND (Status='9' OR Status='12') $sqlTempfrom $sqlTempto";
		// echo $ReceiedProductss."<br>";
		$selectProductReceived=$sepppR[0]['count(*)'];
		// echo $sql."<br>";
		$pID="Select count(ProductID) as ProductCount from tblFinalOrder where Status!=0 AND StoredID='".$storrr."' $sqlTempfrom $sqlTempto";
		
		$pqty="Select SUM(OrderStock) as ProductStock from tblFinalOrder where (Status='1' OR Status='2' OR Status='9' OR Status='12'OR Status='5' OR Status='6') AND StoredID='".$storrr."' $sqlTempfrom $sqlTempto";
		
		// $pID="Select ProductID from tblFinalOrder where Status!=0 AND StoredID='".$storrr."' $sqlTempfrom $sqlTempto";
		$productstotal="Select ProductID, OrderStock from tblFinalOrder where (Status=9 OR Status='12') AND StoredID='".$storrr."' $sqlTempfrom $sqlTempto";
		
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
		$stocksm += $row["Stock"];
		$StoredID = $row["StoredID"];
	
		$sep=select("*","tblStores","StoreID='".$storrr."'");
		$storename=$sep[0]['StoreName'];
		
		$seps=select("*","tblStores","Status=0");
		$storenames=$seps[0]['StoreName'];
		
		$RStotal = $DB->query($productstotal);
		if ($RStotal->num_rows > 0) 
		{
			$counter = 0;

			while($rowtotal = $RStotal->fetch_assoc())
			{
				$counter ++;
				$stocksm="";
				$ProductID = $rowtotal["ProductID"];
				$OrderStock = $rowtotal["OrderStock"];
				// echo $productstotal."<br>";
				$selectproductprice="Select ProductMRP from tblNewProducts where ProductID='$ProductID'";
				// echo $ProductID."&nbsp &nbsp".$OrderStock."<br>";
				// echo $selectproductprice."<br>";
				$RSprice = $DB->query($selectproductprice);
				if ($RSprice->num_rows > 0) 
				{
					$cnt = 0;

					while($rowprice = $RSprice->fetch_assoc())
					{
						$cnt ++;
						$stocksm="";
						$ProductMRP = $rowprice["ProductMRP"];
						// echo $ProductMRP."<br>";
						$TotalPrice =$ProductMRP *$OrderStock;
						$FinalPrice +=$TotalPrice;
						
						if($FinalPrice=="")
						{
							$FinalPrice='0';
						}
						else
						{
							$FinalPrice=$FinalPrice;
						}
						// echo $FinalPrice."<br>";
					}
				}
			}
		}
		
        
       
	
?>
<?													

																if($storrr=='0')
																{
?>
																	
																	<tr id="my_data_tr_<?=$counter?>">
																		<td><center><?=$counter?></center></td>
																		<td><center><?=$storenames?></center></td>
																		<td><center><?=$orderstock?></center></td>
																		<td><center><?=$stocksm?></center></td>
																		<td><center>
																		<?
																		if($selectProductReceived=="")
																		{
																			$ProductReceived='0';
																		}
																		else
																		{
																			$ProductReceived=$selectProductReceived;
																		}
																		?>
																		<?=$ProductReceived?>
																		</center></td>
																		<td><center><?=$FinalPrice?></center></td>
																		<td><center><?=$pendingoreders?></center></td>
																		<td><center><?=$issueorder?></center></td>
																		<td><center><?=$cancelorders?></center></td>
																		<td><center><?=$transferorder?></center></td>
																		
																	</tr>
<?																	
																}
																else
																{
?>
																	<tr id="my_data_tr_<?=$counter?>">
																		<td><center><?=$counter?></center></td>
																		<td><center>
																		<?php
																		$RSP = $DB->query($pID);
																		if ($RSP->num_rows > 0) 
																		{
																			$counter = 0;

																			while($rowP = $RSP->fetch_assoc())
																			{
																				$counter ++;
																				// $stocksm="";
																				$ProductCount = $rowP["ProductCount"];
																			}
																		}
																		if($ProductCount=="")
																		{
																			$ProductCount1='0';
																		}
																		else
																		{
																			$ProductCount1=$ProductCount;
																		}
																		?>
																		<?=$ProductCount1?>
																		</center></td>
																		<!--<td><center><?//=$stocksm?></center></td>-->
																		<td><center>
																		<?php
																		$RSPQ = $DB->query($pqty);
																		if ($RSPQ->num_rows > 0) 
																		{
																			$counter = 0;

																			while($rowPQ = $RSPQ->fetch_assoc())
																			{
																				$counter ++;
																				// $stocksm="";
																				$ProductStock = $rowPQ["ProductStock"];
																			}
																		}
																		if($ProductStock=="")
																		{
																			$ProductCount2='0';
																		}
																		else
																		{
																			$ProductCount2=$ProductStock;
																		}
																		?>
																		<?=$ProductCount2?>
																		</center></td>
																		<td><center>
																		
																		<?php
																		$RSPQP = $DB->query($ReceiedProductss);
																		if ($RSPQP->num_rows > 0) 
																		{
																			$counter = 0;

																			while($rowPQP = $RSPQP->fetch_assoc())
																			{
																				$counter ++;
																				// $stocksm="";
																				$sumofproducts = $rowPQP["sumofproducts"];
																			}
																		}
																		if($sumofproducts=="")
																		{
																			$sumofproducts1='0';
																		}
																		else
																		{
																			$sumofproducts1=$sumofproducts;
																		}
																		?>
																		<?=$sumofproducts1?>
																		</center></td>
																		<td><center>
																		<?php
																		if($FinalPrice=="")
																		{
																			$FinalPrice1='0';
																		}
																		else
																		{
																			$FinalPrice1=$FinalPrice;
																		}
																		?><?=$FinalPrice1?></center></td>
																		<td><center><?=$pendingoreders?></center></td>
																		<td><center><?=$issueorder?></center></td>
																		<td><center><?=$cancelorders?></center></td>
																		<td><center><?=$transferorder?></center></td>
																		<?
																		if($storrr=='0')
																		{
																			
																		}
																		else
																		{
?>
																			<td><center><?=$storename?></center></td>
<?																	
																		}
																		?>
																	</tr>
<?																	
																}
?>																	
															
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
																<td></td>
																<td>No Records Found</td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<?
																if($storrr=='0')
																{
																	
																}
																else
																{
?>
																	<td></td>
<?																	
																}
																?>
															</tr>
													
														
<?php
}
		
		
		
		
		
}
else
{
		
	$SelectStoreName="Select StoreID, StoreName from tblStores where Status='0'";
		
$RS = $DB->query($SelectStoreName);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$stocksm="";
		$StoreIDs = $row["StoreID"];
		$StoreName = $row["StoreName"];
		
		$sql = "Select count(tblFinalOrder.ProductID) as cntprd,count(tblFinalOrder.ProductStock) as productstock ,count(tblFinalOrder.OrderStock) as orderstocks, tblFinalOrder.StoredID,tblNewProducts.Stock from tblFinalOrder left join tblNewProducts on tblFinalOrder.ProductID=tblNewProducts.ProductID  WHERE tblFinalOrder.StoredID='$StoreIDs' $sqlTempfrom $sqlTempto";
		// echo $sql."<br>";
		
		$sept=select("count(*)","tblFinalOrder","Status='1' and StoredID='$StoreIDs' $sqlTempfrom $sqlTempto");
		
		//$rest="select count(*) from tblFinalOrder where Status='1' StoredID='$StoreIDs' $sqlTempfrom $sqlTempto";
		// echo $rest."<br>";
		$pendingoreders=$sept[0]['count(*)'];
		//earlier Status was 0 , now changed to 1 for pending order
		$sepq=select("count(*)","tblFinalOrder","(Status='10' or Status='11' or Status='3' or Status='4' or Status='2')and StoredID='$StoreIDs' $sqlTempfrom $sqlTempto");
		$issueorder=$sepq[0]['count(*)'];
		//Added extra status 2 
		$sepp=select("count(*)","tblFinalOrder","Status='5' and StoredID='$StoreIDs' $sqlTempfrom $sqlTempto");
		$cancelorders=$sepp[0]['count(*)'];
		$seppp=select("count(*)","tblFinalOrder","Status='12' or Status='9' and StoredID='$StoreIDs' $sqlTempfrom $sqlTempto");
		$transferorder=$seppp[0]['count(*)'];
		$sepppR=select("SUM(OrderStock)","tblFinalOrder","Status='9' and StoredID='$StoreIDs' $sqlTempfrom $sqlTempto");
		$selectProductReceived=$sepppR[0]['count(*)'];
		
		$SelectOrderedStock="Select SUM(OrderStock)as OrderStock from tblFinalOrder where StoredID='$StoreIDs' and Status='9' $sqlTempfrom $sqlTempto";
		$SelectOrderedStockcnt="Select SUM(OrderStock)as OrderStockss from tblFinalOrder where StoredID='$StoreIDs' and (Status='4' OR Status='9' OR Status='12' OR Status='6' OR Status='1') $sqlTempfrom $sqlTempto";
		$sepq=select("count(*)","tblFinalOrder","(Status='10' or Status='11' or Status='3' or Status='4') and StoredID='".$StoreIDs."' $sqlTempfrom $sqlTempto ");
			$Selects="Select Count(*) as orderinissues from tblFinalOrder where (Status='10' or Status='11' or Status='3' or Status='4' or Status='2' ) and StoredID='".$StoreIDs."' $sqlTempfrom $sqlTempto ";
			
			
		$issueorder=$sepq[0]['count(*)'];	
		
		
		$pID="Select count(ProductID) as ProductCount from tblFinalOrder where Status!=0 AND StoredID='".$StoreIDs."' $sqlTempfrom $sqlTempto";
		//Each and every product except draft by store
		$pqty="Select SUM(OrderStock) as ProductStock from tblFinalOrder where (Status='1' OR Status='2' OR Status='9' OR Status='12'OR Status='5' OR Status='6') AND StoredID='".$StoreIDs."' $sqlTempfrom $sqlTempto";
		//Each and every quantity except draft by store

		// $productstock = $row["productstock"];
		$orderstock = $row["orderstock"];
		$orderstocks = $row["orderstocks"];
		$stocksm += $row["orderstocks"];
		$StoredID = $row["StoredID"];
		$cntprd = $row["cntprd"];
		// echo $productstock."<br>";
		// echo $orderstock."<br>";
		// echo $StoredID."<br>";
		// echo $cntprd."<br>";
		// echo $stocksm."<br>";
		$productstotal="Select ProductID, OrderStock from tblFinalOrder where (Status=9 OR Status='12') AND StoredID='".$StoreIDs."' $sqlTempfrom $sqlTempto";
		 // foreach($productstotal as $vat)
        // {
            // $ProductID[]=$vat['ProductID'];
            // $OrderStock[]=$vat['OrderStock'];
            // $selectproductprice="Select ProductMRP from tblNewProducts where ProductID='$ProductID'";
			// $RSprice = $DB->query($selectproductprice);
				// if ($RSprice->num_rows > 0) 
				// {
					// $cnt = 0;

					// while($rowprice = $RSprice->fetch_assoc())
					// {
						// $cnt ++;
						// $stocksm="";
						// $ProductMRP = $rowprice["ProductMRP"];
						// echo $ProductMRP."<br>";
						// $TotalPrice =$ProductMRP *$OrderStock;
						// $FinalPrice +=$TotalPrice;
						
						// if($FinalPrice=="")
						// {
							// $FinalPrice='0';
						// }
						// else
						// {
							// $FinalPrice=$FinalPrice;
						// }
						// echo $FinalPrice."<br>";
					// }
				// }
				// if($FinalPrice=='' || $FinalPrice=='0')
				// {
					// $FinalPrice=0;
				// }
        // }
		// echo $FinalPrice."<br>";
        // unset($ProductID);
        // unset($OrderStock);
		$RStotal = $DB->query($productstotal);
		if ($RStotal->num_rows > 0) 
		{
			$cntn = 0;

			while($rowtotal = $RStotal->fetch_assoc())
			{
				$cntn ++;
				$stocksm="";
				$ProductID = $rowtotal["ProductID"];
				$OrderStock = $rowtotal["OrderStock"];
				// echo $productstotal."<br>";
				$selectproductprice="Select ProductMRP from tblNewProducts where ProductID='$ProductID'";
				// echo $ProductID."&nbsp &nbsp".$OrderStock."<br>";
				// echo $selectproductprice."<br>";
				$RSprice = $DB->query($selectproductprice);
				if ($RSprice->num_rows > 0) 
				{
					$cnt = 0;

					while($rowprice = $RSprice->fetch_assoc())
					{
						$cnt ++;
						$stocksm="";
						$ProductMRP = $rowprice["ProductMRP"];
						// echo $ProductMRP."<br>";
						$TotalPrice =$ProductMRP *$OrderStock;
						$FinalPrice +=$TotalPrice;
						
						if($FinalPrice=="")
						{
							$FinalPrices='0';
						}
						else
						{
							$FinalPrices=$FinalPrice;
						}
						// echo $FinalPrice."<br>";
					}
				}
			}
		}
		$ReceiedProductss="Select SUM(OrderStock) as sumofproducts from tblFinalOrder where StoredID='".$StoreIDs."' AND (Status='9' OR Status='12') $sqlTempfrom $sqlTempto";
		
?>
<?													
																// if($storrr=='0')
																// {
?>
																	
																	<tr id="my_data_tr_<?=$counter?>">
																		<td><center><?=$counter?></center></td>
																		<td><center><?=$StoreName?></center></td>
																		
																		<td><center>
																		<?php
																		$RSP = $DB->query($pID);
																		if ($RSP->num_rows > 0) 
																		{
																			$PQ = 0;

																			while($rowP = $RSP->fetch_assoc())
																			{
																				$PQ ++;
																				// $stocksm="";
																				$ProductCount = $rowP["ProductCount"];
																			}
																		}
																		if($ProductCount=="")
																		{
																			$ProductCount1='0';
																		}
																		else
																		{
																			$ProductCount1=$ProductCount;
																		}
																		?>
																		<?=$ProductCount1?>
																		</center></td>
																		<td><center>
																		<?php
																		$RSPQ = $DB->query($pqty);
																		if ($RSPQ->num_rows > 0) 
																		{
																			$PQP = 0;

																			while($rowPQ = $RSPQ->fetch_assoc())
																			{
																				$PQP ++;
																				// $stocksm="";
																				$ProductStock = $rowPQ["ProductStock"];
																			}
																		}
																		if($ProductStock=="")
																		{
																			$ProductCount2='0';
																		}
																		else
																		{
																			$ProductCount2=$ProductStock;
																		}
																		?>
																		<?=$ProductCount2?>
																		</center></td>
																		<td><center>
																		<?php
																		$RSPQP = $DB->query($ReceiedProductss);
																		if ($RSPQP->num_rows > 0) 
																		{
																			$PQPR = 0;

																			while($rowPQP = $RSPQP->fetch_assoc())
																			{
																				$PQPR ++;
																				// $stocksm="";
																				$sumofproducts = $rowPQP["sumofproducts"];
																			}
																		}
																		if($sumofproducts=="")
																		{
																			$sumofproducts1='0';
																		}
																		else
																		{
																			$sumofproducts1=$sumofproducts;
																		}
																		?>
																		<?=$sumofproducts1?>
																		</center></td>
																		<td><center>
																		<?php
																		if($FinalPrices=="")
																		{
																			$FinalPrices1='0';
																		}
																		else
																		{
																			$FinalPrices1=$FinalPrices;
																		}
																		?>
																		<?=$FinalPrices1?></center></td>
																		<td><center><?=$pendingoreders?></center></td>
																		<td><center>
																		<?php
																		$RSIssue = $DB->query($Selects);
																		if ($RSIssue->num_rows > 0) 
																		{
																			$PQI = 0;

																			while($rowIssue = $RSIssue->fetch_assoc())
																			{
																				$PQI ++;
																				// $stocksm="";
																				$orderinissues = $rowIssue["orderinissues"];
																			}
																		}
																		if($orderinissues=="")
																		{
																			$orderinissues1='0';
																		}
																		else
																		{
																			$orderinissues1=$orderinissues;
																		}
																		?>
																		<?=$orderinissues1?>
																		</center></td>
																		
																		<td><center><?=$cancelorders?></center></td>
																		<td><center><?=$transferorder?></center></td>
																		
																	</tr>
<?																	
																// }
																// else
																// {
?>
																	<!--<tr id="my_data_tr_<?//=$counter?>">
																		<td><center><?//=$counter?></center></td>
																		<td><center><?//=$orderstock?></center></td>
																		<td><center><?//=$stocksm?></center></td>
																		<td><center>
																		<?
																		// if($selectProductReceived=="")
																		// {
																			// $ProductReceived='0';
																		// }
																		// else
																		// {
																			// $ProductReceived=$selectProductReceived;
																		// }
																		?>
																		<?//=$ProductReceived?>
																		</center></td>
																		<td><center><?//=$pendingoreders?></center></td>
																		<td><center><?//=$issueorder?></center></td>
																		<td><center><?//=$cancelorders?></center></td>
																		<td><center><?//=$transferorder?></center></td>
																		<?
																		// if($storrr=='0')
																		// {
																			
																		// }
																		// else
																		// {
?>
																			<td><center><?//=$storename?></center></td>
<?																	
																		// }
																		?>
																	</tr>-->
<?																	
																// }
?>																	
															
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
																<td></td>
																<td>No Records Found</td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<?
																if($storrr=='0')
																{
																	
																}
																else
																{
?>
																	<td></td>
<?																	
																}
																?>
															</tr>
													
														
<?php
}
}

$DB->close();
?>
														
														</tbody>
														
													
													</table>
													<?php
														}	
														else
														{
															echo "<br><center><h3>Please Select Month And Year!</h3></center>";
														}															
														?>
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