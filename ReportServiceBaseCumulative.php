<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "ReportServiceSalesCategoryBase | Nailspa";
	$strDisplayTitle = "Report Service Sales Category Base for Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportServiceCategoryBase2.php";
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
			$sqlTempfrom = " and Date(tblAppointments.AppointmentDate)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblAppointments.AppointmentDate)<=Date('".$getto."')";
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
			//$("#catt").hide();
			//$("#applyfilter").hide();
			"use strict";
			$('.bootstrap-datepicker').bsdatepicker({
				format: 'mm-dd-yyyy'
			});
			
		});
		function changecategory(evt)
		{
			$("#catt").show();
			var store=$(evt).val();
			var date=$("#daterangepicker-example").val();
			//alert(date)
			 if(store!='0' || store!='')
			{
				$.ajax({
					type:'post',
					data:'store='+store+"&date="+date,
					url:'UpdateCategory.php',
					success:function(res)
					{
						$("#applyfilter").show();
						$("#cat").html(res);
					}
					
				})
			} 
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
										<ul>
											<li><a href="#normal-tabs-1" title="Tab 1">Manage</a></li>
										</ul>
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
														<div class="col-sm-2">
															<select name="Store" class="form-control" >
															<option value="0">All</option>
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
														<button type="submit" id="applyfilter" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportServiceBaseCumulative.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														<!--<a class="btn btn-border btn-alt border-primary font-primary" href="ExcelExportData.php?from=<?=$getfrom?>&to=<?=$getto?>" title="Excel format 2016"><span>Export To Excel</span><div class="ripple-wrapper"></div></a>
														-->

													</div>
												</form>
												
												<br>
												<?php
													if(isset($_GET["toandfrom"]) && !IsNull($_GET["Store"]))
													{
														$storrr=$_GET["store"];
													if($storrr=='0')
													{
														$storrrp='All';
													}
													else
													{
													$stpp=select("StoreName","tblStores","StoreID='".$storrr."'");
				                                    $StoreName=$stpp[0]['StoreName'];
													$storrrp=$StoreName;
													}
													$cat=$_GET["cat"];
												    $selpth=select("CategoryName","tblCategories","CategoryID='".$cat."'");
												    $catp=$selpth[0]['CategoryName'];	
												?>
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store Filter selected : <?=$storrrp?> Category : <?=$catp?> </h3>
												
												<br>
											   <div class="panel">
										  <div class="panel-body">
											 <div class="example-box-wrapper">
												<div class="scroll-columns">
												  <table class="table table-bordered table-striped table-condensed cf">
														<thead class="cf">
														<?php 
														if(!empty($storr))
                                                        {
															?>
															
															<tr>
															 <th class="numeric">Category</th>
																<th class="numeric">Amt</th>
																<th class="numeric">Service Count</th>
																<th class="numeric">Product Cost</th>
																<th class="numeric">Profitibility</th>
																<th class="numeric">ARPU</th>
																
															</tr>
															<?php
														}
														else
														{
															?>
															<tr>
															 <th class="numeric">Category</th>
																<th class="numeric">Amt</th>
																<th class="numeric">Service Count</th>
																<th class="numeric">Product Cost</th>
																<th class="numeric">Profitibility</th>
																<th class="numeric">ARPU</th>
																<th class="numeric">Store</th>
															</tr>
															<?php
															
														}
														?>
														</thead>

				
<?php
$DB = Connect();
$storr=$_GET["Store"];
if(!empty($storr))
{
                                $stppqu=select("distinct(tblProductsServices.CategoryID)","tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices
                                on tblProductsServices.ServiceID=tblAppointmentsDetailsInvoice.ServiceID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto");
	
		foreach($stppqu as $tes)
		{
			$CATTU[]=$tes['CategoryID'];
		}
		for($q=0;$q<count($CATTU);$q++)
		{
			
		
							
							$counter = 0;
							$totaltpcostT=0;
							$qttyt=0;
							$qttyt="";
							$totalstrServiceAmount="";
							$totaltpcostT="";
							$totalstrprofitT="";
							$totalARPU=0;
							$totalstrServiceAmount=0;
							$totaltpcost=0;
							$totalstrprofit=0;
							
?>
        
								<tbody>
<?php
								$stppserty=select("distinct(tblProductsServices.CategoryID)","tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices
                                on tblProductsServices.ServiceID=tblAppointmentsDetailsInvoice.ServiceID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto and tblProductsServices.CategoryID='".$CATTU[$q]."'");
								
								$stppq=select("CategoryName","tblCategories","CategoryID='".$CATTU[$q]."'");
								$CategoryName=$stppq[0]['CategoryName'];
								$stppsertyp=select("distinct(tblProductsServices.ServiceID)","tblAppointmentsDetailsInvoice
								left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices
                                on tblProductsServices.ServiceID=tblAppointmentsDetailsInvoice.ServiceID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storr."' AND tblProductsServices.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto AND tblProductsServices.CategoryID='".$CATTU[$q]."'");
								foreach($stppsertyp as $cat)
								{
									$serrt[]=$cat['ServiceID'];
								}
								
					
							    $stppsertypt=select("distinct(tblAppointmentsDetailsInvoice.ServiceID)","tblAppointmentsDetailsInvoice
								left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices
                                on tblProductsServices.ServiceID=tblAppointmentsDetailsInvoice.ServiceID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storr."' AND tblProductsServices.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto AND tblProductsServices.CategoryID='".$CATTU[$q]."'");
								
								foreach($stppsertypt as $tre)
								{
									
									$ServiceIDt=$tre['ServiceID'];
									if(in_array("$ServiceIDt",$serrt))
									{
										 $stppsertyptup=select("tblAppointmentsDetailsInvoice.qty,tblAppointmentsDetailsInvoice.ServiceAmount","tblAppointmentsDetailsInvoice left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storr."' and tblAppointmentsDetailsInvoice.ServiceID='".$ServiceIDt."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto ");
										foreach($stppsertyptup as $tr)
										{
											$qty=$tr['qty'];
											$ServiceAmount=$tr['ServiceAmount'];
											$qttyt +=$qty;
											$strServiceAmount = $ServiceAmount*$qty;
											$totalstrServiceAmount=$totalstrServiceAmount+$strServiceAmount;
										}
								$sqlservicet=select("distinct(ProductID)","tblProductsServices","StoreID='".$storr."' and ServiceID='".$ServiceIDt."'");
								foreach($sqlservicet as $trp)
										{
											$ProductIDtP[]=$trp['ProductID'];
										}
										
										
							
			
				
									}
								
									
								}
							//	print_r($ProductID);
								foreach($ProductIDtP as $valtP)
									{
										
											$sqldata3 = "SELECT * FROM tblNewProducts WHERE ProductID='".$valtP."'";
										
											$RSdiscountt = $DB->query($sqldata3);
										
											if ($RSdiscountt->num_rows > 0) 
											{
												while($rowdiscounttt = $RSdiscountt->fetch_assoc())
												{
													
													$ProductMRPst = $rowdiscounttt["ProductMRP"];
													$PerQtyServest = $rowdiscounttt["PerQtyServe"];
													$product_costt +=$ProductMRPst/$PerQtyServest;
													/* echo "product_id=".$valt."<br/>";
													echo "ProductMRPs=".$ProductMRPs."<br/>";
													echo "PerQtyServes=".$PerQtyServes."<br/>";
													echo "product_cost=".$product_cost."<br/>"; */
													$tpcostT = round($product_costt);
											
												}
											}
											else
											{
												$product_costt="0";
											}
									
										
										
									}
									
									unset($ProductIDtP);
									unset($ServiceIDt);	
									$product_costt="";
									
									if($ARPU=='')
										{
											$ARPU=0;
										}
										
										if($tpcostT=='')
										{
											$tpcostT=0;
										}
										if($totalstrServiceAmount!='0' && $totalstrServiceAmount!='')
										{
											$strprofit = ($totalstrServiceAmount) - ($tpcostT);
											$ARPU = ($strprofit) / ($qttyt);
										}
										else
										{
											
											$totalstrServiceAmount=0;
											$strprofit = 0;
											$ARPU = ($strprofit) / ($qttyt);
										}
											
									  if($totalstrServiceAmount=='')
									  {
										  $totalstrServiceAmount=0;
									  }
									  if($qttyt=="")
									  {
										  $qttyt=0;
									  }
									  if($totalstrServiceAmount=="")
									 {
										$totalstrServiceAmount=0;
										
									 }
									 else
									 {
										 $totalstrServiceAmount=$totalstrServiceAmount;
									 }
									 $totalstrServiceAmountT=$totalstrServiceAmountT+$totalstrServiceAmount;
									  if($qttyt=="")
									 {
										$qttyt=0;
										
									 }
									 else
									 {
										 $qttyt=$qttyt;
									 }
									 
									 $totalstrqty=$totalstrqty+$qttyt;
									 
									  if($tpcostT=="")
									 {
										$tpcostT=0;
										
									 }
									 else
									 {
										 $tpcostT=$tpcostT;
									 }
									 $totaltpcostT=$totaltpcostT+$tpcostT;
									 $totaltpcosttM=$totaltpcosttM+$totaltpcostT;
									  if($strprofit=="")
									 {
										$strprofit=0;
										
									 }
									 else
									 {
										 $strprofit=$strprofit;
									 }
									 $totalstrprofitT=$totalstrprofitT+$strprofit;
									 $totalstrprofittM=$totalstrprofittM+$totalstrprofitT;
									 if($ARPU=="")
									 {
										 $ARPU=0;
									 }
									 else
									 {
										  $ARPU=$ARPU;
									 }
									 $totalARPU=$totalARPU+$ARPU;
									  $totalARPUt=$totalARPUt+$totalARPU;
				?>
	
	                      
			               <tbody>
						 
								<tr>
									
									<td><?=$CategoryName?></td>
									<td>Rs. <?=$totalstrServiceAmount?> /-</td>
									<td><?=$qttyt?></td>
									<td class="numeric">Rs. <?=$totaltpcostT?></td>
									<td class="numeric"><?=$totalstrprofitT?></td>
									<td class="numeric">Rs. <?=round($totalARPU)?></td>
								
								</tr>
							</tbody>
							<?php
							$ARPU="";
							$strprofit="";
							$qttyt="";
					
						
		}
		unset($CATTU);
				        
		?>
		</tbody>
		<?php
	
			            $qttyt="";
						$totalstrServiceAmount="";
						$totaltpcost="";
						$totalstrprofit="";
						$totalARPU="";
	
	
}
else
{
	$stpp=select("*","tblStores","Status='0'");
	foreach($stpp as $vapt)
	{
		$sql = "SELECT * from tblCategories where Status='0'";
        $RS = $DB->query($sql);
		if ($RS->num_rows > 0) 
		{
				while($row = $RS->fetch_assoc())
	           {
				$counter ++;
				$strCategoryID = $row["CategoryID"];
				$strCategoryName = $row["CategoryName"];
			
			
		
							
							$counter = 0;
							$totaltpcostT=0;
							$qttyt=0;
							$qttyt="";
							$totalstrServiceAmount="";
							$totaltpcostT="";
							$totalstrprofitT="";
							$totalARPU=0;
							$totalstrServiceAmount=0;
							$totaltpcost=0;
							$totalstrprofit=0;
							
?>
        
								<tbody>
<?php
								$stppserty=select("distinct(tblProductsServices.CategoryID)","tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices
                                on tblProductsServices.ServiceID=tblAppointmentsDetailsInvoice.ServiceID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$vapt['StoreID']."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto and tblProductsServices.CategoryID='".$strCategoryID."'");
								
								$stppq=select("CategoryName","tblCategories","CategoryID='".$CATTU[$q]."'");
								$CategoryName=$stppq[0]['CategoryName'];
								$stppsertyp=select("distinct(tblProductsServices.ServiceID)","tblAppointmentsDetailsInvoice
								left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices
                                on tblProductsServices.ServiceID=tblAppointmentsDetailsInvoice.ServiceID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$vapt['StoreID']."' AND tblProductsServices.StoreID='".$vapt['StoreID']."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto AND tblProductsServices.CategoryID='".$strCategoryID."'");
								foreach($stppsertyp as $cat)
								{
									$serrt[]=$cat['ServiceID'];
								}
								
					
							    $stppsertypt=select("distinct(tblAppointmentsDetailsInvoice.ServiceID)","tblAppointmentsDetailsInvoice
								left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices
                                on tblProductsServices.ServiceID=tblAppointmentsDetailsInvoice.ServiceID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$vapt['StoreID']."' AND tblProductsServices.StoreID='".$vapt['StoreID']."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto AND tblProductsServices.CategoryID='".$strCategoryID."'");
								
								foreach($stppsertypt as $tre)
								{
									
									$ServiceIDt=$tre['ServiceID'];
									if(in_array("$ServiceIDt",$serrt))
									{
										 $stppsertyptup=select("tblAppointmentsDetailsInvoice.qty,tblAppointmentsDetailsInvoice.ServiceAmount","tblAppointmentsDetailsInvoice left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$vapt['StoreID']."' and tblAppointmentsDetailsInvoice.ServiceID='".$ServiceIDt."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto ");
										foreach($stppsertyptup as $tr)
										{
											$qty=$tr['qty'];
											$ServiceAmount=$tr['ServiceAmount'];
											$qttyt +=$qty;
											$strServiceAmount = $ServiceAmount*$qty;
											$totalstrServiceAmount=$totalstrServiceAmount+$strServiceAmount;
										}
								$sqlservicet=select("distinct(ProductID)","tblProductsServices","StoreID='".$vapt['StoreID']."' and ServiceID='".$ServiceIDt."'");
								foreach($sqlservicet as $trp)
										{
											$ProductIDtP[]=$trp['ProductID'];
										}
										
										
							
			
				
									}
								
									
								}
							//	print_r($ProductID);
								foreach($ProductIDtP as $valtP)
									{
										
											$sqldata3 = "SELECT * FROM tblNewProducts WHERE ProductID='".$valtP."'";
										
											$RSdiscountt = $DB->query($sqldata3);
										
											if ($RSdiscountt->num_rows > 0) 
											{
												while($rowdiscounttt = $RSdiscountt->fetch_assoc())
												{
													
													$ProductMRPst = $rowdiscounttt["ProductMRP"];
													$PerQtyServest = $rowdiscounttt["PerQtyServe"];
													$product_costt +=$ProductMRPst/$PerQtyServest;
													/* echo "product_id=".$valt."<br/>";
													echo "ProductMRPs=".$ProductMRPs."<br/>";
													echo "PerQtyServes=".$PerQtyServes."<br/>";
													echo "product_cost=".$product_cost."<br/>"; */
													$tpcostT = round($product_costt);
											
												}
											}
											else
											{
												$product_costt="0";
											}
									
										
										
									}
									
									unset($ProductIDtP);
									unset($ServiceIDt);	
									$product_costt="";
									
									if($ARPU=='')
										{
											$ARPU=0;
										}
										
										if($tpcostT=='')
										{
											$tpcostT=0;
										}
										if($totalstrServiceAmount!='0' && $totalstrServiceAmount!='')
										{
											$strprofit = ($totalstrServiceAmount) - ($tpcostT);
											$ARPU = ($strprofit) / ($qttyt);
										}
										else
										{
											
											$totalstrServiceAmount=0;
											$strprofit = 0;
											$ARPU = ($strprofit) / ($qttyt);
										}
											
									  if($totalstrServiceAmount=='')
									  {
										  $totalstrServiceAmount=0;
									  }
									  if($qttyt=="")
									  {
										  $qttyt=0;
									  }
									  if($totalstrServiceAmount=="")
									 {
										$totalstrServiceAmount=0;
										
									 }
									 else
									 {
										 $totalstrServiceAmount=$totalstrServiceAmount;
									 }
									 $totalstrServiceAmountT=$totalstrServiceAmountT+$totalstrServiceAmount;
									  if($qttyt=="")
									 {
										$qttyt=0;
										
									 }
									 else
									 {
										 $qttyt=$qttyt;
									 }
									 
									 $totalstrqty=$totalstrqty+$qttyt;
									 
									  if($tpcostT=="")
									 {
										$tpcostT=0;
										
									 }
									 else
									 {
										 $tpcostT=$tpcostT;
									 }
									 $totaltpcostT=$totaltpcostT+$tpcostT;
									 $totaltpcosttM=$totaltpcosttM+$totaltpcostT;
									  if($strprofit=="")
									 {
										$strprofit=0;
										
									 }
									 else
									 {
										 $strprofit=$strprofit;
									 }
									 $totalstrprofitT=$totalstrprofitT+$strprofit;
									 $totalstrprofittM=$totalstrprofittM+$totalstrprofitT;
									 if($ARPU=="")
									 {
										 $ARPU=0;
									 }
									 else
									 {
										  $ARPU=$ARPU;
									 }
									 $totalARPU=$totalARPU+$ARPU;
									  $totalARPUt=$totalARPUt+$totalARPU;
				?>
	
	                      
			               <tbody>
						 
								<tr>
									
									<td><?=$CategoryName?></td>
									<td>Rs. <?=$totalstrServiceAmount?> /-</td>
									<td><?=$qttyt?></td>
									<td class="numeric">Rs. <?=$totaltpcostT?></td>
									<td class="numeric"><?=$totalstrprofitT?></td>
									<td class="numeric">Rs. <?=round($totalARPU)?></td>
								
								</tr>
							</tbody>
							<?php
							$ARPU="";
							$strprofit="";
							$qttyt="";
					
						
		
				        
		?>
		</tbody>
		<?php
	
			            $qttyt="";
						$totalstrServiceAmount="";
						$totaltpcost="";
						$totalstrprofit="";
						$totalARPU="";
				
				
			   }
		}
	             
						
	}
}
                                  if(!empty($storr))
                                                  {
													  ?>
													   <tbody>
						
														<tr>
															<td colspan="1"><center><b>Total Amount and Count in selected periods(s)</b><center></td>
															
															<td class="numeric"><b>Rs. <?=$totalstrServiceAmountT?>/-</b></td>
                                                            <td class="numeric"><b><?=$totalstrqty?></b></td>
														     <td class="numeric"><b>Rs. <?=$totaltpcosttM?>/-</b></td>
															  <td class="numeric"><b><?=$totalstrprofittM?></b></td>
															   <td class="numeric"><b>Rs. <?=round($totalARPUt)?>/-</b></td>
														 
														
														</tr>
													 
						                            </tbody>
													  <?php
													  
												  }
												  else
												  {
													   ?>
													   <tbody>
						
														<tr>
															<td colspan="1"><center><b>Total Amount and Count in selected periods(s)</b><center></td>
															
															<td class="numeric"><b>Rs. <?=$totalstrServiceAmountT?>/-</b></td>
                                                            <td class="numeric"><b><?=$totalstrqty?></b></td>
														     <td class="numeric"><b>Rs. <?=$totaltpcosttM?>/-</b></td>
															  <td class="numeric"><b><?=$totalstrprofittM?></b></td>
															   <td class="numeric"><b>Rs. <?=round($totalARPUt)?>/-</b></td>
														 <td class="numeric"></td>
														
														</tr>
													 
						                            </tbody>
													  <?php
													  
												  }
	          $totalARPUt="";
	?>
		                                   
						 
						                            
						
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