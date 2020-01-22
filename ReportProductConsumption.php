<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Product Consumption| Nailspa";
	$strDisplayTitle = "Product Consumption Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportProductConsumption.php";
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
											
												
												<form method="get" class="form-horizontal bordered-row" role="form">
										     <div class="form-group"><label for="" class="col-sm-4 control-label">Select Date Range</label>
														<div class="col-sm-4">
															<div class="input-prepend input-group">
																<span class="add-on input-group-addon">
																	<i class="glyph-icon icon-calendar"></i>
																</span> 
																<input type="text" name="toandfrom" id="daterangepicker-example" class="form-control" value="<?=$strtoandfrom?>">
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-4 control-label">Select Store</label>
														<div class="col-sm-4">
															<select name="Store" class="form-control">
															<option value="0" >All</option>	
																<?
                                                    $selp=select("*","tblStores","Status='0'");
													foreach($selp as $val)
													{
														$strStoreName = $val["StoreName"];
														$strStoreID = $val["StoreID"];
														$store=$_GET["Store"];
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
														<a class="btn btn-link" href="ReportProductConsumption.php">Clear All Filter</a>
														<?php
													$datedrom=$_GET["toandfrom"];
													if($datedrom!="")
													{
														   ?>
														<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
														<?php
													   }
														?>

														&nbsp;&nbsp;&nbsp;
											
													
														<!--<a class="btn btn-border btn-alt border-primary font-primary" href="ExcelExportData.php?from=<?=$getfrom?>&to=<?=$getto?>" title="Excel format 2016"><span>Export To Excel</span><div class="ripple-wrapper"></div></a>
														-->

													</div>
												</form>
												<div id="printdata">	
												<h2 class="title-hero" id="heading" style="display:none"><center>Report Product Consumption</center></h2>
												<br>
												<?php
												$datedrom=$_GET["toandfrom"];
													if($datedrom!="" && !IsNull($_GET["Store"]))
													{
														$storrr=$_GET["Store"];
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
														<h3 >Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store Filter selected : <?=$storrrp?> </h3>
												
												<br>
				
												
												<div class="example-box-wrapper">
													<table class="table table-bordered table-striped table-condensed cf">
														<thead>
															<tr>
															    <th style="text-align:center">Product Name</th>
																<th style="text-align:center">Product Qty Used<br/>(Consumption Target/Service Done)</th>
																<th style="text-align:center">Services Done<br/>(Total No Of Service Count)</th>
																<th style="text-align:center">Consumption Target<br/>(Per Qty Serve)</th>
																<th style="text-align:center">Consumption Performance<br/>(Per Qty Serve minus Total No Of Service Count)</th>
																<th style="text-align:center">Revenue Generated<br/>(Total Service Sale Amount)</th>
																
																<th style="text-align:center">Cost of Product<br/>(Product MRP divide Total No Of Service Count)</th>
																<th style="text-align:center">Profitability<br/>(Cost of Product minus Revenue Generated)</th>
															    
															</tr>
														</thead>
												
														<tbody>

<?php
$DB = Connect();
$storrr=$_GET["Store"];
if(!empty($storrr))
{
	//$sql=selectproduct($storrr,$getfrom,$getto);
$sql = "select distinct(tblProductsServices.ProductID) from tblProductsServices left join tblAppointments on tblProductsServices.StoreID=tblAppointments.StoreID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblNewProducts on tblNewProducts.ProductID=tblProductsServices.ProductID WHERE tblAppointments.StoreID='".$storrr."' AND tblProductsServices.StoreID='".$storrr."'  AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' $sqlTempfrom $sqlTempto  AND tblProductsServices.StoreID='".$storrr."'";

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
	
		$ProductID = $row["ProductID"];
	    $sep=select("count(*)","tblNewProducts","ProductID='".$ProductID."'");
		$cntserr=$sep[0]['count(*)'];
		if($cntserr>0)
		{
			 $sept=select("*","tblNewProducts","ProductID='".$ProductID."'");
			 $ProductIDT=$sept[0]['ProductID'];
		     $productname=$sept[0]['ProductName'];
			 $PerQtyServe=$sept[0]['PerQtyServe'];
			 $ProductMRP=$sept[0]['ProductMRP'];
			
			 $sepa=select("*","tblStores","StoreID='".$storrr."'");
		     $storename=$sepa[0]['StoreName'];
			 
			// $sqlt=selectproductservice($storrr,$getfrom,$getto,$ProductIDT);
				$sqlt = "select distinct(tblProductsServices.ServiceID) from tblProductsServices left join tblAppointments on tblProductsServices.StoreID=tblAppointments.StoreID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblNewProducts on tblNewProducts.ProductID=tblProductsServices.ProductID WHERE tblAppointments.StoreID='".$storrr."' AND tblProductsServices.StoreID='".$storrr."'  AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' $sqlTempfrom $sqlTempto  AND tblProductsServices.StoreID='".$storrr."' and tblProductsServices.ProductID='".$ProductIDT."'";
				
				$RSt = $DB->query($sqlt);
				if ($RSt->num_rows > 0) 
				{
					$counter = 0;

					while($row1 = $RSt->fetch_assoc())
					{
						$servicedt = $row1["ServiceID"];
						// $stppsertyptup=selectproductservicedetail($storrr,$getfrom,$getto,$servicedt);
						 $stppsertyptup=select("tblAppointmentsDetailsInvoice.qty,tblAppointmentsDetailsInvoice.ServiceAmount","tblAppointmentsDetailsInvoice left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storrr."' and tblAppointmentsDetailsInvoice.ServiceID='".$servicedt."' AND tblAppointments.IsDeleted !=  '1' and tblAppointments.Status='2' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto ");
										foreach($stppsertyptup as $tr)
										{
											$qty=$tr['qty'];
											$ServiceAmount=$tr['ServiceAmount'];
											$qttyt +=$qty;
											$strServiceAmount = $ServiceAmount*$qty;
											$totalstrServiceAmount=$totalstrServiceAmount+$strServiceAmount;
										}
					}
				}
				$productcost=$ProductMRP*$qttyt;
				$ProductQtyUsed=$PerQtyServe/$qttyt;
				if($qttyt=="")
				{
					$qttyt=0;
				}
				$consumperformance=$PerQtyServe-$qttyt;
			    $profit=$productcost-$totalstrServiceAmount;
				 
		   if($ProductQtyUsed =="")
			{
				$ProductQtyUsed ="0.00";
			}
			else
			{
			
				$ProductQtyUsed = $ProductQtyUsed;
				
			}
			$TotalProductQtyUsed += $ProductQtyUsed;
			if($qttyt =="")
			{
				$qttyt ="0.00";
			}
			else
			{
			
				$qttyt = $qttyt;
				
			}
			$Totalqttyt += $qttyt;
			if($PerQtyServe =="")
			{
				$PerQtyServe ="0.00";
			}
			else
			{
			
				$PerQtyServe = $PerQtyServe;
				
			}
			$TotalPerQtyServe += $PerQtyServe;
			if($consumperformance =="")
			{
				$consumperformance ="0.00";
			}
			else
			{
			
				$consumperformance = $consumperformance;
				
			}
			$Totalconsumperformance += $consumperformance;
				if($totalstrServiceAmount =="")
			{
				$totalstrServiceAmount ="0.00";
			}
			else
			{
			
				$totalstrServiceAmount = $totalstrServiceAmount;
				
			}
			$TotaltotalstrServiceAmount += $totalstrServiceAmount;
				if($productcost =="")
			{
				$productcost ="0.00";
			}
			else
			{
			
				$productcost = $productcost;
				
			}
			$Totalproductcost += $productcost;
			if($profit =="")
			{
				$profit ="0.00";
			}
			else
			{
			
				$profit = $profit;
				
			}
			$Totalprofit += $profit;
			 ?>														
														
															<tr id="my_data_tr_<?=$counter?>">
															   <td><center><?=$productname?></center></td>
																<td><center><?=ceil($ProductQtyUsed)?></center></td>
																<td><center><?=$qttyt?></center></td>
																
																<td><center><?=$PerQtyServe?></center></td>
																<td><center><?=$consumperformance?></center></td>
																<td><center><?=$totalstrServiceAmount?></center></td>
															    <td><center><?=$productcost?></center></td>
																<td><center><?=$profit?></center></td>
															</tr>
<?php
		}
		$qttyt="";
		$PerQtyServe="";
		$ProductQtyUsed="";
		$consumperformance="";
		$totalstrServiceAmount="";
		$profit="";
		$productcost="";

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
																<td></td>
																<td></td>
																
															</tr>
													
														
<?php
}
}
else
{
	   $sql=selectproduct($getfrom,$getto);
		
		

	
		foreach($sql as $row)
		{
		$counter ++;
	
		$ProductID = $row["ProductID"];
	    $sep=select("count(*)","tblNewProducts","ProductID='".$ProductID."'");
		$cntserr=$sep[0]['count(*)'];
		if($cntserr>0)
		{
			 $sept=select("*","tblNewProducts","ProductID='".$ProductID."'");
			 $ProductIDT=$sept[0]['ProductID'];
		     $productname=$sept[0]['ProductName'];
			 $PerQtyServe=$sept[0]['PerQtyServe'];
			 $ProductMRP=$sept[0]['ProductMRP'];
			 //$productcost=$ProductMRP*$PerQtyServe;
			 $sepa=select("*","tblStores","StoreID='".$storrr."'");
		     $storename=$sepa[0]['StoreName'];
			 
			 $sqlt=selectproductservice($getfrom,$getto,$ProductIDT);
			 
				foreach($sqlt as $vat)
				{
					$servicedtt = $vat["ServiceID"];
					$stppsertyptup=selectproductservicedetail($getfrom,$getto,$servicedtt);
					foreach($stppsertyptup as $tr)
										{
											$qty=$tr['qty'];
											$ServiceAmount=$tr['ServiceAmount'];
											$qttyt +=$qty;
											$strServiceAmount = $ServiceAmount*$qty;
											$totalstrServiceAmount=$totalstrServiceAmount+$strServiceAmount;
										}
				}
			
				$ProductQtyUsed=$PerQtyServe/$qttyt;
				if($qttyt=="")
				{
					$qttyt=0;
				}
				$consumperformance=$PerQtyServe-$qttyt;
			    $profit=$productcost-$totalstrServiceAmount;
				$productcost=$ProductMRP*$qttyt;
		   if($ProductQtyUsed =="")
			{
				$ProductQtyUsed ="0.00";
			}
			else
			{
			
				$ProductQtyUsed = $ProductQtyUsed;
				
			}
			$TotalProductQtyUsed += $ProductQtyUsed;
			if($qttyt =="")
			{
				$qttyt ="0.00";
			}
			else
			{
			
				$qttyt = $qttyt;
				
			}
			$Totalqttyt += $qttyt;
			if($PerQtyServe =="")
			{
				$PerQtyServe ="0.00";
			}
			else
			{
			
				$PerQtyServe = $PerQtyServe;
				
			}
			$TotalPerQtyServe += $PerQtyServe;
			if($consumperformance =="")
			{
				$consumperformance ="0.00";
			}
			else
			{
			
				$consumperformance = $consumperformance;
				
			}
			$Totalconsumperformance += $consumperformance;
				if($totalstrServiceAmount =="")
			{
				$totalstrServiceAmount ="0.00";
			}
			else
			{
			
				$totalstrServiceAmount = $totalstrServiceAmount;
				
			}
			$TotaltotalstrServiceAmount += $totalstrServiceAmount;
				if($productcost =="")
			{
				$productcost ="0.00";
			}
			else
			{
			
				$productcost = $productcost;
				
			}
			$Totalproductcost += $productcost;
			if($profit =="")
			{
				$profit ="0.00";
			}
			else
			{
			
				$profit = $profit;
				
			}
			$Totalprofit += $profit;
			 ?>														
														
															<tr id="my_data_tr_<?=$counter?>">
															   <td><center><?=$productname?></center></td>
																<td><center><?=ceil($ProductQtyUsed)?></center></td>
																<td><center><?=$qttyt?></center></td>
																
																<td><center><?=$PerQtyServe?></center></td>
																<td><center><?=$consumperformance?></center></td>
																<td><center><?=$totalstrServiceAmount?></center></td>
															    <td><center><?=$productcost?></center></td>
																<td><center><?=$profit?></center></td>
															</tr>
<?php
		}
		$qttyt="";
		$PerQtyServe="";
		$ProductQtyUsed="";
		$consumperformance="";
		$totalstrServiceAmount="";
		$profit="";

	}
	$stocksm="";

	
}
$DB->close();
?>
														
														</tbody>
														
															<tbody>
														 <tr>
															<td colspan="1"><center><b>Total</b></center></td>
															 <td class="numeric"><center><?=round($TotalProductQtyUsed,2)?></center></td>
															 <td class="numeric"><center><?=$Totalqttyt?></center></td>
															 <td class="numeric"><center><?=$TotalPerQtyServe?></center></td>
															 <td class="numeric"><center><?=$Totalconsumperformance?></center></td>
															 <td class="numeric"><center><?=$TotaltotalstrServiceAmount?></center></td>
															 <td class="numeric"><center><?=$Totalproductcost?></center></td>
															 <td class="numeric"><center><?=$Totalprofit?></center></td>
														</tr>
													</tbody>
													</table>
													
												</div>
												</div>
											</div>
										</div>
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