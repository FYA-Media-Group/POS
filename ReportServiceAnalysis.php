<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Report Service Analysis | Nailspa";
	$strDisplayTitle = "Report Service Analysis for Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportServiceAnalysis.php";
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
												<h3 class="title-hero">List of all Services</h3>
												
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
													
													<div class="form-group">
														<label class="col-sm-4 control-label">Select Store</label>
														<div class="col-sm-4">
															<select name="Store" class="form-control">
																<option value="0">All</option>
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
														<div class="form-group">
														<label class="col-sm-4 control-label">Select Percentage</label>
														<div class="col-sm-4">
														<?php 
														$per=$_GET["per"];
														?>
															<select name="per" class="form-control">
																<option value="0" <?php if($per=='0'){ ?> selected <?php } ?>>Without Percentage</option>
															    <option value="1" <?php if($per=='1'){ ?> selected <?php } ?>>Percentage</option>
															</select>
														</div>
													</div>
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportServiceAnalysis.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														<?php
														$datedrom=$_GET["toandfrom"];
														if($datedrom!="")
													   {
														   ?>
															<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
														<!--<a class="btn btn-border btn-alt border-primary font-primary" href="ExcelExportData.php?from=<?=$getfrom?>&to=<?=$getto?>" title="Excel format 2016"><span>Export To Excel</span><div class="ripple-wrapper"></div></a>
														-->
                                                    <?php
													   }
														?>
														
													</div>
												</form>
												
												<br>
												<div id="printdata">
												<?php
												$datedrom=$_GET["toandfrom"];
													if($datedrom!="" || !IsNull($_GET["Store"]))
													{
														$store=$_GET["Store"];
														$sep=select("StoreName","tblStores","StoreID='".$store."'");
														$storename=$sep[0]['StoreName'];
														
												?>
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store Filter selected : <?=$storename?> </h3>
												
												<br>
				

				
<?php
$DB = Connect();
$per=$_GET["per"];


		
?>
		<div class="panel">
			<div class="panel-body">
			
				<div class="example-box-wrapper">
					<div class="scroll-columns">
					

					
						<table class="table table-bordered table-striped table-condensed cf" width="100%">
							<thead class="cf">
								<tr>
									<th>Code</th>
									<th>Service Name</th>
									<th>Store</th>
									<th class="numeric">Cost</th>
									<?php
																	if($per!='0')
																	{
																		?>
																<th >Amt %</th>
																<?php
																	}
																?>
									<th class="numeric"># Count</th>
									<?php
																	if($per!='0')
																	{
																		?>
																<th >Service Count %</th>
																<?php
																	}
																?>
									<th class="numeric">Product Cost</th>
									<th class="numeric">Profitibility</th>
									<th class="numeric">ARPU</th>
								
								</tr>
							</thead>
							
<?php
$storr=$_GET["Store"];
if(!empty($storr))
{
	
				$stpp=select("StoreName","tblStores","StoreID='".$storr."'");
				$StoreName=$stpp[0]['StoreName'];
			
				$set=select("sum(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as sumaatt","tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto order by tblAppointmentsDetailsInvoice.ServiceAmount+0 desc");
								$summt=$set[0]['sumaatt'];
						$setty=select("sum(tblAppointmentsDetailsInvoice.qty) as sumqty","tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto order by tblAppointmentsDetailsInvoice.ServiceAmount+0 desc");
								$sumqty=$setty[0]['sumqty'];
					 $sqldata = "SELECT tblAppointmentsDetailsInvoice.qty, tblAppointmentsDetailsInvoice.ServiceAmount,tblAppointmentsDetailsInvoice.ServiceID, tblInvoiceDetails.OfferDiscountDateTime
								FROM tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID
								WHERE tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto order by tblAppointmentsDetailsInvoice.ServiceAmount+0 desc";
					
					$RSdata = $DB->query($sqldata);
					if ($RSdata->num_rows > 0) 
					{
						while($rowdata = $RSdata->fetch_assoc())
						{
							$strAppointmentID = $rowdata["AppointmentID"];
							$strqty = $rowdata["qty"];
							$strServiceAmountt = $rowdata["ServiceAmount"];
							$strServiceAmount=$strServiceAmountt*$strqty;
							$ServiceID = $rowdata["ServiceID"];
							
								$stppser=select("*","tblServices","ServiceID='".$ServiceID."'");
								$ServiceName=$stppser[0]['ServiceName'];
								$ServiceCode=$stppser[0]['ServiceCode'];
								
						$sqlservicet = "SELECT distinct(ProductID) FROM tblProductsServices WHERE tblProductsServices.StoreID='".$storr."' and tblProductsServices.ServiceID='".$ServiceID."'";
						//echo $sqlservicet;
						$RSdiscountt = $DB->query($sqlservicet);
					
						if ($RSdiscountt->num_rows > 0) 
						{
							while($rowdiscountt = $RSdiscountt->fetch_assoc())
							{
								
								$ProductID[]=$rowdiscountt['ProductID'];
								
						
							}
						}
						else
						{
							
						}
				
						
					
					
						
				foreach($ProductID as $valt)
				{
				
						$sqldata1 = "SELECT * FROM tblNewProducts WHERE ProductID='".$valt."'";
					
						$RSdiscountt = $DB->query($sqldata1);
					
						if ($RSdiscountt->num_rows > 0) 
						{
							while($rowdiscountt = $RSdiscountt->fetch_assoc())
							{
								
								$ProductMRPs = $rowdiscountt["ProductMRP"];
								$PerQtyServes = $rowdiscountt["PerQtyServe"];
								$product_cost +=$ProductMRPs/$PerQtyServes;
								$tpcost = round($product_cost);
						
							}
						}
						else
						{
							$product_cost="0";
						}
				
					
					
				}
				
				unset($ProductID);
		        unset($strServiceID);	
				

				if($ARPU=='')
				{
					$ARPU=0;
				}
				
				if($tpcost=='')
				{
					$tpcost=0;
				}
				if($strServiceAmount!='0' && $strServiceAmount!='')
				{
					$strprofit = ($strServiceAmount) - ($tpcost);
					$ARPU = ($strprofit) / ($strqty);
				}
				else
				{
					
					$strServiceAmount=0;
					$strprofit = 0;
					$ARPU = ($strprofit) / ($strqty);
				}
					
			  if($strServiceAmount=='')
			  {
				  $strServiceAmount=0;
			  }
			  if($strqty=="")
			  {
				  $strqty=0;
			  }
			  if($strServiceAmount=="")
			 {
				$strServiceAmount=0;
				
			 }
			 else
			 {
				 $strServiceAmount=$strServiceAmount;
			 }
			 $totalstrServiceAmount=$totalstrServiceAmount+$strServiceAmount;
			  if($strqty=="")
			 {
				$strqty=0;
				
			 }
			 else
			 {
				 $strqty=$strqty;
			 }
			 
			 $totalstrqty=$totalstrqty+$strqty;
			  if($tpcost=="")
			 {
				$tpcost=0;
				
			 }
			 else
			 {
				 $tpcost=$tpcost;
			 }
			 $totaltpcost=$totaltpcost+$tpcost;
			  if($strprofit=="")
			 {
				$strprofit=0;
				
			 }
			 else
			 {
				 $strprofit=$strprofit;
			 }
			 $totalstrprofit=$totalstrprofit+$strprofit;
			 if($ARPU=="")
			 {
				 $ARPU=0;
			 }
			 else
			 {
				  $ARPU=$ARPU;
			 }
			 $totalARPU=$totalARPU+$ARPU;
			$amtper=($strServiceAmount/$summt)*100;
			$qtyper=($strqty/$sumqty)*100;
			$totalamtper +=$amtper;
			$totalqtyper +=$qtyper;
?>							
									
							<tbody>
								<tr>
									<td><?=$ServiceCode?></td>
									<td><?=$ServiceName?></td>
									<td><?=$StoreName?></td>
								    <td class="numeric">Rs. <?=$strServiceAmount?></td>
										<?php
																	if($per!='0')
																	{
																		?>
																		<td class="numeric" ><?php 
																		
																		echo round($amtper,2)
																		
																		
																		?></td>
																		<?php
																	}
																		?>
									<td class="numeric"><?=$strqty?></td>
									<?php
																	if($per!='0')
																	{
																		?>
																		<td class="numeric" ><?=round($qtyper,2)?></td>
																		<?php
																	}
																		?>
									<td class="numeric">Rs. <?=$tpcost?></td>
									<td class="numeric"><?=$strprofit?></td>
									<td class="numeric">Rs. <?=round($ARPU)?></td>
								</tr>
							</tbody>
							<?php
						}
						?>
						                            <tbody>
						
														<tr>
															<td colspan="3"><center><b>Total Amount and Count in selected periods(s) : <?=$counter?></b><center></td>
															
															<td class="numeric"><b>Rs. <?=$totalstrServiceAmount?>/-</b></td>
																<?php
																	if($per!='0')
																	{
																		?>
																		<td class="numeric"></td>
																		<?php
																	}
																		?>
                                                            <td class="numeric"><b><?=$totalstrqty?></b></td>
																<?php
																	if($per!='0')
																	{
																		?>
																		<td class="numeric"></td>
																		<?php
																	}
																		?>
														     <td class="numeric"><b>Rs. <?=$totaltpcost?>/-</b></td>
															  <td class="numeric"><b><?=$totalstrprofit?></b></td>
															   <td class="numeric"><b>Rs. <?=round($totalARPU)?></b></td>
														
														
														</tr>
													 
						                            </tbody>
						<?php
						
                       }
					else
					{
					
						?>
						
							<tbody>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>No Data Found</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						<?php
					}

		
	}
    else
	{
		$sqlstore=select("StoreID,StoreName","tblStores","Status='0'");	
foreach($sqlstore as $storet)
{	

$set=select("sum(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as sumaatt","tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storet['StoreID']."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto order by tblAppointmentsDetailsInvoice.ServiceAmount desc");
								$summt=$set[0]['sumaatt'];
						$setty=select("sum(tblAppointmentsDetailsInvoice.qty) as sumqty","tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storet['StoreID']."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto order by tblAppointmentsDetailsInvoice.ServiceAmount desc");
								$sumqty=$setty[0]['sumqty'];
		
					 $sqldata = "SELECT tblAppointmentsDetailsInvoice.qty, tblAppointmentsDetailsInvoice.ServiceAmount,tblAppointmentsDetailsInvoice.ServiceID, tblInvoiceDetails.OfferDiscountDateTime
								FROM tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID
								WHERE tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storet['StoreID']."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto order by tblAppointmentsDetailsInvoice.ServiceAmount desc";
					//echo $sqldata."<br>";
					$RSdata = $DB->query($sqldata);
					if ($RSdata->num_rows > 0) 
					{
						while($rowdata = $RSdata->fetch_assoc())
						{
							$strAppointmentID = $rowdata["AppointmentID"];
							$strqty = $rowdata["qty"];
							$strServiceAmountt = $rowdata["ServiceAmount"];
							$strServiceAmount=$strServiceAmountt*$strqty;
							$ServiceID = $rowdata["ServiceID"];
							
								$stppser=select("*","tblServices","ServiceID='".$ServiceID."'");
								$ServiceName=$stppser[0]['ServiceName'];
								$ServiceCode=$stppser[0]['ServiceCode'];
								
						$sqlservicet = "SELECT distinct(ProductID) FROM tblProductsServices WHERE tblProductsServices.StoreID='".$storet['StoreID']."' and tblProductsServices.ServiceID='".$ServiceID."'";
						//echo $sqlservicet;
						$RSdiscountt = $DB->query($sqlservicet);
					
						if ($RSdiscountt->num_rows > 0) 
						{
							while($rowdiscountt = $RSdiscountt->fetch_assoc())
							{
								
								$ProductID[]=$rowdiscountt['ProductID'];
								
						
							}
						}
						else
						{
							
						}
				
						
					
					
						
				foreach($ProductID as $valt)
				{
				
						$sqldata1 = "SELECT * FROM tblNewProducts WHERE ProductID='".$valt."'";
					
						$RSdiscountt = $DB->query($sqldata1);
					
						if ($RSdiscountt->num_rows > 0) 
						{
							while($rowdiscountt = $RSdiscountt->fetch_assoc())
							{
								
								$ProductMRPs = $rowdiscountt["ProductMRP"];
								$PerQtyServes = $rowdiscountt["PerQtyServe"];
								$product_cost +=$ProductMRPs/$PerQtyServes;
								$tpcost = round($product_cost);
						
							}
						}
						else
						{
							$product_cost="0";
						}
				
					
					
				}
				
				unset($ProductID);
		        unset($strServiceID);	
				

				if($ARPU=='')
				{
					$ARPU=0;
				}
				
				if($tpcost=='')
				{
					$tpcost=0;
				}
				if($strServiceAmount!='0' && $strServiceAmount!='')
				{
					$strprofit = ($strServiceAmount) - ($tpcost);
					$ARPU = ($strprofit) / ($strqty);
				}
				else
				{
					
					$strServiceAmount=0;
					$strprofit = 0;
					$ARPU = ($strprofit) / ($strqty);
				}
					
			  if($strServiceAmount=='')
			  {
				  $strServiceAmount=0;
			  }
			  if($strqty=="")
			  {
				  $strqty=0;
			  }
			  if($strServiceAmount=="")
			 {
				$strServiceAmount=0;
				
			 }
			 else
			 {
				 $strServiceAmount=$strServiceAmount;
			 }
			 $totalstrServiceAmount=$totalstrServiceAmount+$strServiceAmount;
			  if($strqty=="")
			 {
				$strqty=0;
				
			 }
			 else
			 {
				 $strqty=$strqty;
			 }
			 
			 $totalstrqty=$totalstrqty+$strqty;
			  if($tpcost=="")
			 {
				$tpcost=0;
				
			 }
			 else
			 {
				 $tpcost=$tpcost;
			 }
			 $totaltpcost=$totaltpcost+$tpcost;
			  if($strprofit=="")
			 {
				$strprofit=0;
				
			 }
			 else
			 {
				 $strprofit=$strprofit;
			 }
			 $totalstrprofit=$totalstrprofit+$strprofit;
			 if($ARPU=="")
			 {
				 $ARPU=0;
			 }
			 else
			 {
				  $ARPU=$ARPU;
			 }
			 $totalARPU=$totalARPU+$ARPU;
			$amtper=($strServiceAmount/$summt)*100;
			$qtyper=($strqty/$sumqty)*100;
			$totalamtper +=$amtper;
			$totalqtyper +=$qtyper;
			
?>							
									
							<tbody>
								<tr>
									<td><?=$ServiceCode?></td>
									<td><?=$ServiceName?></td>
									<td><?=$storet['StoreName']?></td>
								    <td class="numeric">Rs. <?=$strServiceAmount?></td>
									<?php
																	if($per!='0')
																	{
																		
																		
																		?>
																		<td class="numeric" ><?php 
																		
																		echo round($amtper,2)?></td>
																		<?php
																	}
																		?>
									<td class="numeric"><?=$strqty?></td>
									<?php
																	if($per!='0')
																	{
																		?>
																		<td class="numeric" ><?=round($qtyper,2)?></td>
																		<?php
																	}
																		?>
									<td class="numeric">Rs. <?=$tpcost?></td>
									<td class="numeric"><?=$strprofit?></td>
									<td class="numeric">Rs. <?=round($ARPU)?></td>
								</tr>
							</tbody>
							<?php
						}
					
                       }
					else
					{
					
						?>
						
							<tbody>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>No Data Found</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						<?php
					}

					$amtper="";
					$qtyper="";
	}
	?>
	
						                            <tbody>
						
														<tr>
															<td colspan="3"><center><b>Total Amount and Count in selected periods(s) : <?=$counter?></b><center></td>
															
															<td class="numeric"><b>Rs. <?=$totalstrServiceAmount?>/-</b></td>
                                                           <?php
																	if($per!='0')
																	{
																		?>
																		<td class="numeric"><b></b></td>
																		<?php
																	}
																		?>
                                                            <td class="numeric"><b><?=$totalstrqty?></b></td>
																<?php
																	if($per!='0')
																	{
																		?>
																		<td class="numeric"><b></b></td>
																		<?php
																	}
																		?>
														     <td class="numeric"><b>Rs. <?=$totaltpcost?>/-</b></td>
															  <td class="numeric"><b><?=$totalstrprofit?></b></td>
															   <td class="numeric"><b>Rs. <?=round($totalARPU)?></b></td>
														
														
														</tr>
													 
						                            </tbody>
	<?php
	}		
	
?>							
				
						</table>
						
					</div>
				</div>
			</div>
		</div>
		</div>
		
<?php	

$DB->close();

?>
												
												
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