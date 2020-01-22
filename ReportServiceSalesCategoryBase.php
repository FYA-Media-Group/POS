<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "ReportServiceSalesCategoryBase | Nailspa";
	$strDisplayTitle = "Report Service Sales Category Base for Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportServiceSalesCategoryBase.php";
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
			$("#catt").hide();
			$("#applyfilter").hide();
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
	<script>
		function printDiv(divName) 
		{
	
	    var divToPrint = document.getElementById("kakkabiryani");
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
					<style type="text/css">
@media print {
  body * {
    visibility: hidden;

  }
  #printarea * {
    visibility: visible;
  }
  #printarea{
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>
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
												<?php
												if(!isset($_GET["toandfrom"]) && IsNull($_GET["Store"]))
													{
												?>
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
														<?php
														$storr=$_GET["Store"];
														?>
															<select name="Store" class="form-control" >
															 <option value="cu" <?php if($storr=="cu"){?> selected <?php }?>>Cumulative</option>
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
													<?php
                                                     }
													?>
													
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit"  class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportServiceSalesCategoryBase.php">Clear All Filter</a>
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
												<?php
												$datedrom=$_GET["toandfrom"];
													if($datedrom!="" && !IsNull($_GET["Store"]))
													{
														$storrr=$_GET["Store"];
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
												<div id="kakkabiryani">
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store Filter selected : <?=$storrrp?></h3>
												
												<br>
												
											   <div class="panel">
										  <div class="panel-body">
											 <div class="example-box-wrapper">
												<div class="scroll-columns">
<?php
$DB = Connect();
$storr=$_GET["Store"];
$per=$_GET["per"];
if($per=="1")
{
if(!empty($storr))
{
	if($storr=="cu")
	 {
			$storrd=1;
			$sumqttytc=0;
			$sumServiceAmountac=0;
			$set=selectcategory($storrd,$getfrom,$getto);
			foreach($set as $tes)
			{
				$CATTUp[]=$tes['CategoryID'];
			}
			for($q=0;$q<count($CATTUp);$q++)
		   {
			   $stppsertyptop=selectservice($storrd,$getfrom,$getto,$CATTUp[$q]);
			   foreach($stppsertyptop as $catq)
								{
									//$serrtp[]=$catq['ServiceID'];
									$ServiceIDtq=$catq['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptupqw=selectservicedetail($storrd,$getfrom,$getto,$ServiceIDtq);
								
										foreach($stppsertyptupqw as $trty)
										{
											$qty=$trty['qty'];
											$ServiceAmount=$trty['ServiceAmount'];
											$sumqttytc +=$qty;
											$strServiceAmountr = $ServiceAmount*$qty;
											$sumServiceAmountac=$sumServiceAmountac+$strServiceAmountr;
										}
								}
								
			   
		   }
		  
		   /////////////////////////////////////////////////////////////////////////////
		   $storrd=2;
		   $sumServiceAmountak=0;
		   $sumqttytk=0;
			$setq=selectcategory($storrd,$getfrom,$getto);
			foreach($setq as $tesq)
			{
				$CATTUpy[]=$tesq['CategoryID'];
			}
			for($q=0;$q<count($CATTUpy);$q++)
		   {
			   $stppsertyptopt=selectservice($storrd,$getfrom,$getto,$CATTUpy[$q]);
			   foreach($stppsertyptopt as $catqt)
								{
									
									$ServiceIDtqp=$catqt['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptupqwp=selectservicedetail($storrd,$getfrom,$getto,$ServiceIDtqp);
								
										foreach($stppsertyptupqwp as $trtyp)
										{
											$qtyy=$trtyp['qty'];
											$ServiceAmounty=$trtyp['ServiceAmount'];
											$sumqttytk +=$qtyy;
											$strServiceAmountry = $ServiceAmounty*$qtyy;
											$sumServiceAmountak=$sumServiceAmountak+$strServiceAmountry;
										}
								}
								
			   
		   }
		
		 
		   /////////////////////////////////////////////////////////////////////////////////
		   $sumServiceAmountab=0;
		   $sumqttytb=0;
		   $storrd=3;
			$set=selectcategory($storrd,$getfrom,$getto);
			foreach($set as $tes)
			{
				$CATTUpu[]=$tes['CategoryID'];
			}
			for($q=0;$q<count($CATTUpu);$q++)
		   {
			   $stppsertyptop=selectservice($storrd,$getfrom,$getto,$CATTUpu[$q]);
			   foreach($stppsertyptop as $catq)
								{
									
									$ServiceIDtq=$catq['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptupqw=selectservicedetail($storrd,$getfrom,$getto,$ServiceIDtq);
								
										foreach($stppsertyptupqw as $trty)
										{
											$qtyb=$trty['qty'];
											$ServiceAmountb=$trty['ServiceAmount'];
											$sumqttytb +=$qtyb;
											$strServiceAmountrb = $ServiceAmountb*$qtyb;
											$sumServiceAmountab=$sumServiceAmountab+$strServiceAmountrb;
										}
								}
								
			   
		   }
		   //////////////////////////////////////////////////////////////////////////////////
		   $sumServiceAmountao=0;
		   $sumqttyto=0;
		   $storrd=4;
			$set=selectcategory($storrd,$getfrom,$getto);
			foreach($set as $tes)
			{
				$CATTUps[]=$tes['CategoryID'];
			}
			for($q=0;$q<count($CATTUps);$q++)
		   {
			   $stppsertyptop=selectservice($storrd,$getfrom,$getto,$CATTUps[$q]);
			   foreach($stppsertyptop as $catq)
								{
									
									$ServiceIDtq=$catq['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptupqw=selectservicedetail($storrd,$getfrom,$getto,$ServiceIDtq);
								
										foreach($stppsertyptupqw as $trty)
										{
											$qtyo=$trty['qty'];
											$ServiceAmounto=$trty['ServiceAmount'];
											$sumqttyto +=$qtyo;
											$strServiceAmountro = $ServiceAmounto*$qtyo;
											$sumServiceAmountao=$sumServiceAmountao+$strServiceAmountro;
										}
								}
								
			   
		   }
		   /////////////////////////////////////////////////////////////////////////////////////
		   $sumServiceAmountal=0;
		   $sumqttytl=0;
		    $storrd=5;
			$set=selectcategory($storrd,$getfrom,$getto);
			foreach($set as $tes)
			{
				$CATTUpi[]=$tes['CategoryID'];
			}
			for($q=0;$q<count($CATTUpi);$q++)
		   {
			   $stppsertyptop=selectservice($storrd,$getfrom,$getto,$CATTUpi[$q]);
			   foreach($stppsertyptop as $catq)
								{
									
									$ServiceIDtq=$catq['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptupqw=selectservicedetail($storrd,$getfrom,$getto,$ServiceIDtq);
								
										foreach($stppsertyptupqw as $trty)
										{
											$qtyl=$trty['qty'];
											$ServiceAmountl=$trty['ServiceAmount'];
											$sumqttytl +=$qtyl;
											$strServiceAmountrl = $ServiceAmountl*$qtyl;
											$sumServiceAmountal=$sumServiceAmountal+$strServiceAmountrl;
										}
								}
								
			   
		   }
		   
		   ///////////////////////////////////////////////////////////////////////
	 }
	 else
	 {
		 
			$set=selectcategory($storr,$getfrom,$getto);
			foreach($set as $tes)
			{
				$CATTUpl[]=$tes['CategoryID'];
			}
			for($q=0;$q<count($CATTUpl);$q++)
		   {
			   $stppsertyptop=selectservice($storr,$getfrom,$getto,$CATTUpl[$q]);
			   foreach($stppsertyptop as $catq)
								{
									$serrtp[]=$catq['ServiceID'];
									$ServiceIDtq=$catq['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptupqw=selectservicedetail($storr,$getfrom,$getto,$ServiceIDtq);
								
										foreach($stppsertyptupqw as $trty)
										{
											$qty=$trty['qty'];
											$ServiceAmount=$trty['ServiceAmount'];
											$sumqttytstore +=$qty;
											$strServiceAmountr = $ServiceAmount*$qty;
											$sumServiceAmountastore=$sumServiceAmountastore+$strServiceAmountr;
										}
								}
								
			   
		   }
	 }
	
}
else
{
		$setq=selectcategoryall($getfrom,$getto);
		foreach($setq as $tes)
		{
			$CATTUsall[]=$tes['CategoryID'];
		}
		
		for($q=0;$q<count($CATTUsall);$q++)
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
								
							
								$stppsertyptf=selectserviceall($getfrom,$getto,$CATTUsall[$q]);
						
								foreach($stppsertyptf as $catf)
								{
									$serrtf[]=$catf['ServiceID'];
								}
				
								//$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
					
								
								 foreach($stppsertyptf as $catf)
								{
									
									$ServiceIDtf=$catf['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptupff=selectservicedetailall($getfrom,$getto,$ServiceIDtf);
								
										foreach($stppsertyptupff as $trf)
										{
											$qtyf=$trf['qty'];
											$ServiceAmountf=$trf['ServiceAmount'];
											$sumqttytall +=$qtyf;
											$strServiceAmountsw = $ServiceAmountf*$qtyf;
											$sumServiceAmountaall=$sumServiceAmountaall+$strServiceAmountsw;
										}
								$sqlservicet=select("distinct(ProductID)","tblProductsServices","StoreID!='0' and ServiceID='".$ServiceIDtf."' and CategoryID!=''");
								foreach($sqlservicet as $trp)
										{
											$ProductIDtP[]=$trp['ProductID'];
										}
									
								}  
		}
}
}
?>							  
				
<?php
$DB = Connect();
$storr=$_GET["Store"];
$per=$_GET["per"];
if(!empty($storr))
{

     if($storr=="cu")
	 {
		 ?>
		
		     <span style="float:left;font-size:14px"><b>Store : Colaba</b></span>
			 <table class="table table-bordered table-striped table-condensed cf" width="100%">
														<thead class="cf">
														
															<tr>
															 <th class="numeric">Category</th>
																<th class="numeric">Amt</th>
																<?php
																	if($per!='0')
																	{
																		?>
																<th >Amt %</th>
																<?php
																	}
																?>
																<th class="numeric">Service Count</th>
																<?php
																	if($per!='0')
																	{
																		?>
																<th >Service %</th>
																<?php
																	}
																?>
																<th class="numeric">Product Cost</th>
																<th class="numeric">Profitibility</th>
																<th class="numeric">ARPU</th>
																
															</tr>
															
														</thead>
				<?php
				$storrd=1;
		$set=selectcategory($storrd,$getfrom,$getto);
		foreach($set as $tes)
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
								
								$stppq=select("CategoryName","tblCategories","CategoryID='".$CATTU[$q]."'");
								$CategoryName=$stppq[0]['CategoryName'];
								
								$stppsertypt=selectservice($storrd,$getfrom,$getto,$CATTU[$q]);
							/*  $stppsertyp=select("distinct(tblProductsServices.ServiceID)","tblAppointmentsDetailsInvoice
								left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices
                                on tblProductsServices.ServiceID=tblAppointmentsDetailsInvoice.ServiceID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storr."' AND tblProductsServices.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' $sqlTempfrom $sqlTempto AND tblProductsServices.CategoryID='".$CATTU[$q]."'");  */
								//$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
								foreach($stppsertypt as $cat)
								{
									$serrt[]=$cat['ServiceID'];
								}
				
								//$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
					            /* foreach($stppsertypt as $cat)
								{
									$ServiceIDt=$cat['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptupamt=servicedetailssumamt($storrd,$getfrom,$getto,$ServiceIDt);
									$sumamt=$stppsertyptupamt[0]['sumamt'];
									 $stppsertyptupqty=servicedetailssumqty($storrd,$getfrom,$getto,$ServiceIDt);
									$sumqty =$stppsertyptupqty[0]['sumqty '];
								}
								 */
								 foreach($stppsertypt as $cat)
								{
									
									$ServiceIDt=$cat['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptup=selectservicedetail($storrd,$getfrom,$getto,$ServiceIDt);
								
										foreach($stppsertyptup as $tr)
										{
											$qty=$tr['qty'];
											$ServiceAmount=$tr['ServiceAmount'];
											$qttyt +=$qty;
											$strServiceAmount = $ServiceAmount*$qty;
											$totalstrServiceAmount=$totalstrServiceAmount+$strServiceAmount;
										}
								$sqlservicet=select("distinct(ProductID)","tblProductsServices","StoreID='".$storrd."' and ServiceID='".$ServiceIDt."' and CategoryID!=''");
								foreach($sqlservicet as $trp)
										{
											$ProductIDtP[]=$trp['ProductID'];
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
													$product_costt =$ProductMRPst/$PerQtyServest;
												    
													
													$tpcostT = round($product_costt);
													
												    $totaltpcostT=$totaltpcostT+$tpcostT;
													
													
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
										
									
										if($totalstrServiceAmount!='0' && $totalstrServiceAmount!='')
										{
											$strprofit = ($totalstrServiceAmount) - ($totaltpcostT);
											//$ARPU = ($strprofit) / ($qttyt);
											$ARPU = ($totalstrServiceAmount) - ($qttyt);
										}
										else
										{
											
											$totalstrServiceAmount=0;
											$strprofit = 0;
											//$ARPU = ($strprofit) / ($qttyt);
											$ARPU = ($totalstrServiceAmount) - ($qttyt);
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
									  
									  $seramtper=($totalstrServiceAmount/$sumServiceAmountac)*100;
									  $qtyper=($qttyt/$sumqttytc)*100;
									  $totalsamt +=$seramtper;
									  $totalsqty +=$qtyper;
									  
				?>
	
	                      
			               <tbody>
						 
								<tr>
									
									<td><?=$CategoryName?></td>
									<td>Rs. <?=$totalstrServiceAmount?> /-</td>
									<?php
																	if($per!='0')
																	{
																		?>
																		<td><?php 
																		
																		echo round($seramtper,2)?></td>
																		<?php
																	}
																		?>
									<td><?=$qttyt?></td>
									<?php
																	if($per!='0')
																	{
																		?>
																		<td><?=round($qtyper,2)?></td>
																		<?php
																	}
																		?>
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
						$seramtper="";
						$qtyper="";
				?>
				
													   <tbody>
						
														<tr>
															<td colspan="1"><center><b>Total Amount and Count in selected periods(s)</b><center></td>
															
															<td class="numeric"><b>Rs. <?=$totalstrServiceAmountT?>/-</b></td>
															<?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><b><?=round($totalsamt,2)?></b></td>
																		<?php
																	}
																		?>
                                                            <td class="numeric"><b><?=$totalstrqty?></b></td>
															<?php
																	if($per!='0')
																	{
																		?>
																		<td class="numeric"><b><?=round($totalsqty,2)?></b></td>
																		<?php
																	}
																		?>
														     <td class="numeric"><b>Rs. <?=$totalstrqty?>/-</b></td>
															  <td class="numeric"><b><?=$totalstrprofittM?></b></td>
															   <td class="numeric"><b>Rs. <?=round($totalARPUt)?>/-</b></td>
														 
														
														</tr>
													 
						                            </tbody>
													</table>
													<br/>
													<br/>
				<?php
				$totalstrServiceAmountT="";
				$totalsqty=0;
				$totalstrqty="";
				$totalsamt=0;
				$totalstrprofittM="";
				$totalARPUt="";
                   ?>				
			<span style="float:left;font-size:14px"><b>Store : Khar</b></span>
			 <table class="table table-bordered table-striped table-condensed cf" width="100%">
														<thead class="cf">
														
															<tr>
															  <th class="numeric">Category</th>
																<th class="numeric">Amt</th>
																<?php
																	if($per!='0')
																	{
																		?>
																<th >Amt %</th>
																<?php
																	}
																?>
																<th class="numeric">Service Count</th>
																<?php
																	if($per!='0')
																	{
																		?>
																<th >Service %</th>
																<?php
																	}
																?>
																<th class="numeric">Product Cost</th>
																<th class="numeric">Profitibility</th>
																<th class="numeric">ARPU</th>
																
															</tr>
															
														</thead>
				<?php
				$storrd=2;
		$set=selectcategory($storrd,$getfrom,$getto);
		foreach($set as $tes)
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
								
								$stppq=select("CategoryName","tblCategories","CategoryID='".$CATTU[$q]."'");
								$CategoryName=$stppq[0]['CategoryName'];
								
								$stppsertypt=selectservice($storrd,$getfrom,$getto,$CATTU[$q]);
							/*  $stppsertyp=select("distinct(tblProductsServices.ServiceID)","tblAppointmentsDetailsInvoice
								left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices
                                on tblProductsServices.ServiceID=tblAppointmentsDetailsInvoice.ServiceID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storr."' AND tblProductsServices.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' $sqlTempfrom $sqlTempto AND tblProductsServices.CategoryID='".$CATTU[$q]."'");  */
								//$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
								foreach($stppsertypt as $cat)
								{
									$serrt[]=$cat['ServiceID'];
								}
				
								//$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
					
								
								 foreach($stppsertypt as $cat)
								{
									
									$ServiceIDt=$cat['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptup=selectservicedetail($storrd,$getfrom,$getto,$ServiceIDt);
								
										foreach($stppsertyptup as $tr)
										{
											$qty=$tr['qty'];
											$ServiceAmount=$tr['ServiceAmount'];
											$qttyt +=$qty;
											$strServiceAmount = $ServiceAmount*$qty;
											$totalstrServiceAmount=$totalstrServiceAmount+$strServiceAmount;
										}
								$sqlservicet=select("distinct(ProductID)","tblProductsServices","StoreID='".$storrd."' and ServiceID='".$ServiceIDt."' and CategoryID!=''");
								foreach($sqlservicet as $trp)
										{
											$ProductIDtP[]=$trp['ProductID'];
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
													$product_costt =$ProductMRPst/$PerQtyServest;
												    
													
													$tpcostT = round($product_costt);
													
												    $totaltpcostT=$totaltpcostT+$tpcostT;
													
													
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
										
									
										if($totalstrServiceAmount!='0' && $totalstrServiceAmount!='')
										{
											$strprofit = ($totalstrServiceAmount) - ($totaltpcostT);
											//$ARPU = ($strprofit) / ($qttyt);
											$ARPU = ($totalstrServiceAmount) - ($qttyt);
										}
										else
										{
											
											$totalstrServiceAmount=0;
											$strprofit = 0;
											//$ARPU = ($strprofit) / ($qttyt);
											$ARPU = ($totalstrServiceAmount) - ($qttyt);
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
									  
								      $seramtperk=($totalstrServiceAmount/$sumServiceAmountak)*100;
									  $qtyperk=($qttyt/$sumqttytk)*100;
									  $totalsamt +=$seramtperk;
									  $totalsqty +=$qtyperk;
									  
				?>
	
	                      
			               <tbody>
						 
								<tr>
									
									<td><?=$CategoryName?></td>
									<td>Rs. <?=$totalstrServiceAmount?> /-</td>
										<?php
																	if($per!='0')
																	{
																		?>
																		<td><?php 
																		
																		echo round($seramtperk,2)
																		
																		?></td>
																		<?php
																	}
																		?>
									<td><?=$qttyt?></td>
									<?php
																	if($per!='0')
																	{
																		?>
																		<td><?=round($qtyperk,2)?></td>
																		<?php
																	}
																		?>
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
						$seramtperk="";
						$qtyperk="";
				?>		
								 <tbody>
						
														<tr>
															<td colspan="1"><center><b>Total Amount and Count in selected periods(s)</b><center></td>
															
															<td class="numeric"><b>Rs. <?=$totalstrServiceAmountT?>/-</b></td>
                                                          <?php
																	if($per!='0')
																	{
																		?>
																		 <td class="numeric"><b><?=round($totalsamt,2)?></b></td>
																		<?php
																	}
																		?>
                                                            <td class="numeric"><b><?=$totalstrqty?></b></td>
															<?php
																	if($per!='0')
																	{
																		?>
																	 <td class="numeric"><b><?=round($totalsqty,2)?></b></td>
																		<?php
																	}
																		?>
														     <td class="numeric"><b>Rs. <?=$totalstrqty?>/-</b></td>
															  <td class="numeric"><b><?=$totalstrprofittM?></b></td>
															   <td class="numeric"><b>Rs. <?=round($totalARPUt)?>/-</b></td>
														 
														
														</tr>
													 
						                            </tbody>
													</table>
													<br/>
													<br/>
				<?php
				$totalstrServiceAmountT="";
				$totalstrqty="";
				$totalstrqty="";
				$totalstrprofittM="";
				$totalARPUt="";
				$totalsamt=0;
				$totalsqty=0;
			
                   ?>									
        <span style="float:left;font-size:14px"><b>Store : Breach Candy</b></span>
			 <table class="table table-bordered table-striped table-condensed cf" width="100%">
														<thead class="cf">
														
															<tr>
															 <th class="numeric">Category</th>
																<th class="numeric">Amt</th>
																<?php
																	if($per!='0')
																	{
																		?>
																<th >Amt %</th>
																<?php
																	}
																?>
																<th class="numeric">Service Count</th>
																<?php
																	if($per!='0')
																	{
																		?>
																<th >Service %</th>
																<?php
																	}
																?>
																<th class="numeric">Product Cost</th>
																<th class="numeric">Profitibility</th>
																<th class="numeric">ARPU</th>
																
															</tr>
															
														</thead>
				<?php
				$storrd=3;
		$set=selectcategory($storrd,$getfrom,$getto);
		foreach($set as $tes)
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
								
								$stppq=select("CategoryName","tblCategories","CategoryID='".$CATTU[$q]."'");
								$CategoryName=$stppq[0]['CategoryName'];
								
								$stppsertypt=selectservice($storrd,$getfrom,$getto,$CATTU[$q]);
							/*  $stppsertyp=select("distinct(tblProductsServices.ServiceID)","tblAppointmentsDetailsInvoice
								left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices
                                on tblProductsServices.ServiceID=tblAppointmentsDetailsInvoice.ServiceID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storr."' AND tblProductsServices.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' $sqlTempfrom $sqlTempto AND tblProductsServices.CategoryID='".$CATTU[$q]."'");  */
								//$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
								foreach($stppsertypt as $cat)
								{
									$serrt[]=$cat['ServiceID'];
								}
				
								//$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
					
								
								 foreach($stppsertypt as $cat)
								{
									
									$ServiceIDt=$cat['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptup=selectservicedetail($storrd,$getfrom,$getto,$ServiceIDt);
								
										foreach($stppsertyptup as $tr)
										{
											$qty=$tr['qty'];
											$ServiceAmount=$tr['ServiceAmount'];
											$qttyt +=$qty;
											$strServiceAmount = $ServiceAmount*$qty;
											$totalstrServiceAmount=$totalstrServiceAmount+$strServiceAmount;
										}
								$sqlservicet=select("distinct(ProductID)","tblProductsServices","StoreID='".$storrd."' and ServiceID='".$ServiceIDt."' and CategoryID!=''");
								foreach($sqlservicet as $trp)
										{
											$ProductIDtP[]=$trp['ProductID'];
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
													$product_costt =$ProductMRPst/$PerQtyServest;
												    
													
													$tpcostT = round($product_costt);
													
												    $totaltpcostT=$totaltpcostT+$tpcostT;
													
													
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
										
									
										if($totalstrServiceAmount!='0' && $totalstrServiceAmount!='')
										{
											$strprofit = ($totalstrServiceAmount) - ($totaltpcostT);
											//$ARPU = ($strprofit) / ($qttyt);
											$ARPU = ($totalstrServiceAmount) - ($qttyt);
										}
										else
										{
											
											$totalstrServiceAmount=0;
											$strprofit = 0;
											//$ARPU = ($strprofit) / ($qttyt);
											$ARPU = ($totalstrServiceAmount) - ($qttyt);
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
									  
									   $seramtperb=($totalstrServiceAmount/$sumServiceAmountab)*100;
									  $qtyperb=($qttyt/$sumqttytb)*100;
									  $totalsamt +=$seramtperb;
									  $totalsqty +=$qtyperb;
				?>
	
	                      
			               <tbody>
						 
								<tr>
									
									<td><?=$CategoryName?></td>
									<td>Rs. <?=$totalstrServiceAmount?> /-</td>
										<?php
																	if($per!='0')
																	{
																		?>
																		<td><?php
																	
																		echo round($seramtperb,2)?></td>
																		<?php
																	}
																		?>
									<td><?=$qttyt?></td>
									<?php
																	if($per!='0')
																	{
																		?>
																		<td><?=round($qtyperb,2)?></td>
																		<?php
																	}
																		?>
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
						$seramtperb="";
						$qtyperb="";
				?>
						 <tbody>
						
														<tr>
															<td colspan="1"><center><b>Total Amount and Count in selected periods(s)</b><center></td>
															
															<td class="numeric"><b>Rs. <?=$totalstrServiceAmountT?>/-</b></td>
                                                          <?php
																	if($per!='0')
																	{
																		?>
																 <td class="numeric"><b><?=round($totalsamt,2)?></b></td>
																		<?php
																	}
																		?>
                                                            <td class="numeric"><b><?=$totalstrqty?></b></td>
															<?php
																	if($per!='0')
																	{
																		?>
																		 <td class="numeric"><b><?=round($totalsqty,2)?></b></td>
																		<?php
																	}
																		?>
														     <td class="numeric"><b>Rs. <?=$totalstrqty?>/-</b></td>
															  <td class="numeric"><b><?=$totalstrprofittM?></b></td>
															   <td class="numeric"><b>Rs. <?=round($totalARPUt)?>/-</b></td>
														 
														
														</tr>
													 
						                            </tbody>
													</table>
													<br/>
													<br/>
				<?php
				$totalstrServiceAmountT="";
				$totalstrqty="";
				$totalstrqty="";
				$totalstrprofittM="";
				$totalARPUt="";
				$totalsamt=0;
				$totalsqty=0;
                   ?>	
				   <span style="float:left;font-size:14px"><b>Store : Oshiwara</b></span>
			 <table class="table table-bordered table-striped table-condensed cf" width="100%">
														<thead class="cf">
														
															<tr>
														 <th class="numeric">Category</th>
																<th class="numeric">Amt</th>
																<?php
																	if($per!='0')
																	{
																		?>
																<th >Amt %</th>
																<?php
																	}
																?>
																<th class="numeric">Service Count</th>
																<?php
																	if($per!='0')
																	{
																		?>
																<th >Service %</th>
																<?php
																	}
																?>
																<th class="numeric">Product Cost</th>
																<th class="numeric">Profitibility</th>
																<th class="numeric">ARPU</th>
																
															</tr>
															
														</thead>
				<?php
				$storrd=4;
		$set=selectcategory($storrd,$getfrom,$getto);
		foreach($set as $tes)
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
								
								$stppq=select("CategoryName","tblCategories","CategoryID='".$CATTU[$q]."'");
								$CategoryName=$stppq[0]['CategoryName'];
								
								$stppsertypt=selectservice($storrd,$getfrom,$getto,$CATTU[$q]);
							/*  $stppsertyp=select("distinct(tblProductsServices.ServiceID)","tblAppointmentsDetailsInvoice
								left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices
                                on tblProductsServices.ServiceID=tblAppointmentsDetailsInvoice.ServiceID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storr."' AND tblProductsServices.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' $sqlTempfrom $sqlTempto AND tblProductsServices.CategoryID='".$CATTU[$q]."'");  */
								//$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
								foreach($stppsertypt as $cat)
								{
									$serrt[]=$cat['ServiceID'];
								}
				
								//$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
					
								
								 foreach($stppsertypt as $cat)
								{
									
									$ServiceIDt=$cat['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptup=selectservicedetail($storrd,$getfrom,$getto,$ServiceIDt);
								
										foreach($stppsertyptup as $tr)
										{
											$qty=$tr['qty'];
											$ServiceAmount=$tr['ServiceAmount'];
											$qttyt +=$qty;
											$strServiceAmount = $ServiceAmount*$qty;
											$totalstrServiceAmount=$totalstrServiceAmount+$strServiceAmount;
										}
								$sqlservicet=select("distinct(ProductID)","tblProductsServices","StoreID='".$storrd."' and ServiceID='".$ServiceIDt."' and CategoryID!=''");
								foreach($sqlservicet as $trp)
										{
											$ProductIDtP[]=$trp['ProductID'];
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
													$product_costt =$ProductMRPst/$PerQtyServest;
												    
													
													$tpcostT = round($product_costt);
													
												    $totaltpcostT=$totaltpcostT+$tpcostT;
													
													
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
										
									
										if($totalstrServiceAmount!='0' && $totalstrServiceAmount!='')
										{
											$strprofit = ($totalstrServiceAmount) - ($totaltpcostT);
											//$ARPU = ($strprofit) / ($qttyt);
											$ARPU = ($totalstrServiceAmount) - ($qttyt);
										}
										else
										{
											
											$totalstrServiceAmount=0;
											$strprofit = 0;
											//$ARPU = ($strprofit) / ($qttyt);
											$ARPU = ($totalstrServiceAmount) - ($qttyt);
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
									  
								      $seramtpero=($totalstrServiceAmount/$sumServiceAmountao)*100;
									  $qtypero=($qttyt/$sumqttyto)*100;
									  $totalsamt +=$seramtpero;
									  $totalsqty +=$qtypero;
				?>
	
	                      
			               <tbody>
						 
								<tr>
									
									<td><?=$CategoryName?></td>
									<td>Rs. <?=$totalstrServiceAmount?> /-</td>
										<?php
																	if($per!='0')
																	{
																		?>
																		<td><?php
																	   
																		echo round($seramtpero,2)?></td>
																		<?php
																	}
																		?>
									<td><?=$qttyt?></td>
									<?php
																	if($per!='0')
																	{
																		?>
																		<td><?=round($qtypero,2)?></td>
																		<?php
																	}
																		?>
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
						$seramtpero="";
						$qtypero="";
				?>		
 <tbody>
						
														<tr>
															<td colspan="1"><center><b>Total Amount and Count in selected periods(s)</b><center></td>
															
															<td class="numeric"><b>Rs. <?=$totalstrServiceAmountT?>/-</b></td>
                                                           <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><b><?=round($totalsamt,2)?></b></td>
																		<?php
																	}
																		?>
                                                            <td class="numeric"><b><?=$totalstrqty?></b></td>
															<?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><b><?=round($totalsqty,2)?></b></td>
																		<?php
																	}
																		?>
														     <td class="numeric"><b>Rs. <?=$totalstrqty?>/-</b></td>
															  <td class="numeric"><b><?=$totalstrprofittM?></b></td>
															   <td class="numeric"><b>Rs. <?=round($totalARPUt)?>/-</b></td>
														 
														
														</tr>
													 
						                            </tbody>
													</table>
													<br/>
													<br/>
				<?php
				$totalstrServiceAmountT="";
				$totalstrqty="";
				$totalstrqty="";
				$totalstrprofittM="";
				$totalARPUt="";
				$totalsamt=0;
				$totalsqty=0;
                   ?>	
<span style="float:left;font-size:14px"><b>Store : Lokhandwala</b></span>
			 <table class="table table-bordered table-striped table-condensed cf" width="100%">
														<thead class="cf">
														
															<tr>
															  <th class="numeric">Category</th>
																<th class="numeric">Amt</th>
																<?php
																	if($per!='0')
																	{
																		?>
																<th >Amt %</th>
																<?php
																	}
																?>
																<th class="numeric">Service Count</th>
																<?php
																	if($per!='0')
																	{
																		?>
																<th >Service %</th>
																<?php
																	}
																?>
																<th class="numeric">Product Cost</th>
																<th class="numeric">Profitibility</th>
																<th class="numeric">ARPU</th>
																
															</tr>
															
														</thead>
				<?php
				$storrd=5;
		$set=selectcategory($storrd,$getfrom,$getto);
		foreach($set as $tes)
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
								
								$stppq=select("CategoryName","tblCategories","CategoryID='".$CATTU[$q]."'");
								$CategoryName=$stppq[0]['CategoryName'];
								
								$stppsertypt=selectservice($storrd,$getfrom,$getto,$CATTU[$q]);
							/*  $stppsertyp=select("distinct(tblProductsServices.ServiceID)","tblAppointmentsDetailsInvoice
								left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices
                                on tblProductsServices.ServiceID=tblAppointmentsDetailsInvoice.ServiceID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storr."' AND tblProductsServices.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' $sqlTempfrom $sqlTempto AND tblProductsServices.CategoryID='".$CATTU[$q]."'");  */
								//$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
								foreach($stppsertypt as $cat)
								{
									$serrt[]=$cat['ServiceID'];
								}
				
								//$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
					
								
								 foreach($stppsertypt as $cat)
								{
									
									$ServiceIDt=$cat['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptup=selectservicedetail($storrd,$getfrom,$getto,$ServiceIDt);
								
										foreach($stppsertyptup as $tr)
										{
											$qty=$tr['qty'];
											$ServiceAmount=$tr['ServiceAmount'];
											$qttyt +=$qty;
											$strServiceAmount = $ServiceAmount*$qty;
											$totalstrServiceAmount=$totalstrServiceAmount+$strServiceAmount;
										}
								$sqlservicet=select("distinct(ProductID)","tblProductsServices","StoreID='".$storrd."' and ServiceID='".$ServiceIDt."' and CategoryID!=''");
								foreach($sqlservicet as $trp)
										{
											$ProductIDtP[]=$trp['ProductID'];
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
													$product_costt =$ProductMRPst/$PerQtyServest;
												    
													
													$tpcostT = round($product_costt);
													
												    $totaltpcostT=$totaltpcostT+$tpcostT;
													
													
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
										
									
										if($totalstrServiceAmount!='0' && $totalstrServiceAmount!='')
										{
											$strprofit = ($totalstrServiceAmount) - ($totaltpcostT);
											//$ARPU = ($strprofit) / ($qttyt);
											$ARPU = ($totalstrServiceAmount) - ($qttyt);
										}
										else
										{
											
											$totalstrServiceAmount=0;
											$strprofit = 0;
											//$ARPU = ($strprofit) / ($qttyt);
											$ARPU = ($totalstrServiceAmount) - ($qttyt);
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
									  
									  $seramtperl=($totalstrServiceAmount/$sumServiceAmountal)*100;
									  $qtyperl=($qttyt/$sumqttytl)*100;
									  $totalsamt +=$seramtperl;
									  $totalsqty +=$qtyperl;
				?>
	
	                      
			               <tbody>
						 
								<tr>
									
									<td><?=$CategoryName?></td>
									<td>Rs. <?=$totalstrServiceAmount?> /-</td>
										<?php
																	if($per!='0')
																	{
																		?>
																		<td><?php
																	
																		
																		echo round($seramtperl,2)?></td>
																		<?php
																	}
																		?>
									<td><?=$qttyt?></td>
									<?php
																	if($per!='0')
																	{
																		?>
																		<td><?=round($qtyperl,2)?></td>
																		<?php
																	}
																		?>
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
						$seramtper="";
						$qtyper="";
				?>		
<tbody>
						
														<tr>
															<td colspan="1"><center><b>Total Amount and Count in selected periods(s)</b><center></td>
															
															<td class="numeric"><b>Rs. <?=$totalstrServiceAmountT?>/-</b></td>
                                                          <?php
																	if($per!='0')
																	{
																		?>
																	  <td class="numeric"><b><?=round($totalsamt,2)?></b></td>
																		<?php
																	}
																		?>
                                                            <td class="numeric"><b><?=$totalstrqty?></b></td>
															<?php
																	if($per!='0')
																	{
																		?>
																	  <td class="numeric"><b><?=round($totalsqty,2)?></b></td>
																		<?php
																	}
																		?>
														     <td class="numeric"><b>Rs. <?=$totalstrqty?>/-</b></td>
															  <td class="numeric"><b><?=$totalstrprofittM?></b></td>
															   <td class="numeric"><b>Rs. <?=round($totalARPUt)?>/-</b></td>
														 
														
														</tr>
													 
						                            </tbody>
													</table>
													<br/>
													<br/>
				<?php
				$totalstrServiceAmountT="";
				$totalstrqty="";
				$totalstrqty="";
				$totalstrprofittM="";
				$totalARPUt="";
				$totalsamt=0;
				$totalsqty=0;
                   ?>					
		 <?php
	 }
	 else
	 {
		 ?>
		  <table class="table table-bordered table-striped table-condensed cf" width="100%">
														<thead class="cf">
														
															<tr>
															 <th class="numeric">Category</th>
																<th class="numeric">Amt</th>
																<?php
																	if($per!='0')
																	{
																		?>
																<th >Amt %</th>
																<?php
																	}
																?>
																<th class="numeric">Service Count</th>
																<?php
																	if($per!='0')
																	{
																		?>
																<th >Service %</th>
																<?php
																	}
																?>
																<th class="numeric">Product Cost</th>
																<th class="numeric">Profitibility</th>
																<th class="numeric">ARPU</th>
																
															</tr>
															
														</thead>
		 <?php
		 
		$set=selectcategory($storr,$getfrom,$getto);
		foreach($set as $tes)
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
								
								$stppq=select("CategoryName","tblCategories","CategoryID='".$CATTU[$q]."'");
								$CategoryName=$stppq[0]['CategoryName'];
								
								$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
							/*  $stppsertyp=select("distinct(tblProductsServices.ServiceID)","tblAppointmentsDetailsInvoice
								left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices
                                on tblProductsServices.ServiceID=tblAppointmentsDetailsInvoice.ServiceID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$storr."' AND tblProductsServices.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' $sqlTempfrom $sqlTempto AND tblProductsServices.CategoryID='".$CATTU[$q]."'");  */
								//$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
								foreach($stppsertypt as $cat)
								{
									$serrt[]=$cat['ServiceID'];
								}
				
								//$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
					
								
								 foreach($stppsertypt as $cat)
								{
									
									$ServiceIDt=$cat['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptup=selectservicedetail($storr,$getfrom,$getto,$ServiceIDt);
								
										foreach($stppsertyptup as $tr)
										{
											$qty=$tr['qty'];
											$ServiceAmount=$tr['ServiceAmount'];
											$qttyt +=$qty;
											$strServiceAmount = $ServiceAmount*$qty;
											$totalstrServiceAmount=$totalstrServiceAmount+$strServiceAmount;
										}
								$sqlservicet=select("distinct(ProductID)","tblProductsServices","StoreID='".$storr."' and ServiceID='".$ServiceIDt."' and CategoryID!=''");
								foreach($sqlservicet as $trp)
										{
											$ProductIDtP[]=$trp['ProductID'];
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
													$product_costt =$ProductMRPst/$PerQtyServest;
												    
													
													$tpcostT = round($product_costt);
													
												    $totaltpcostT=$totaltpcostT+$tpcostT;
													
													
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
										
									
										if($totalstrServiceAmount!='0' && $totalstrServiceAmount!='')
										{
											$strprofit = ($totalstrServiceAmount) - ($totaltpcostT);
											//$ARPU = ($strprofit) / ($qttyt);
											$ARPU = ($totalstrServiceAmount) - ($qttyt);
										}
										else
										{
											
											$totalstrServiceAmount=0;
											$strprofit = 0;
											//$ARPU = ($strprofit) / ($qttyt);
											$ARPU = ($totalstrServiceAmount) - ($qttyt);
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
									  
									  $seramtper=($totalstrServiceAmount/$sumServiceAmountastore)*100;
									  $qtyper=($qttyt/$sumqttytstore)*100;
									  $totalsamt +=$seramtper;
									  $totalsqty +=$qtyper;
				?>
	
	                      
			               <tbody>
						 
								<tr>
									
									<td><?=$CategoryName?></td>
									<td>Rs. <?=$totalstrServiceAmount?> /-</td>
										<?php
																	if($per!='0')
																	{
																		?>
																		<td><?php
																		
																		echo round($seramtper,2);
																		
																		?></td>
																		<?php
																	}
																		?>
									<td><?=$qttyt?></td>
									<?php
																	if($per!='0')
																	{
																		?>
																		<td><?=round($qtyper,2)?></td>
																		<?php
																	}
																		?>
									<td class="numeric">Rs. <?=$totaltpcostT?></td>
									<td class="numeric"><?=$totalstrprofitT?></td>
									<td class="numeric">Rs. <?=round($totalARPU)?></td>
								
								</tr>
							</tbody>
							<?php
							$ARPU="";
							$strprofit="";
							$qttyt="";
					        $seramtper="";
						    $qtyper="";
						
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
						$seramtper="";
						$qtyper="";
						?>
						   <tbody>
						
														<tr>
															<td colspan="1"><center><b>Total Amount and Count in selected periods(s)</b><center></td>
															
															<td class="numeric"><b>Rs. <?=$totalstrServiceAmountT?>/-</b></td>
                                                              <?php
																	if($per!='0')
																	{
																		?>
																		 <td class="numeric"><b><?=round($totalsamt,2)?></b></td>
																		<?php
																	}
																		?>
                                                            <td class="numeric"><b><?=$totalstrqty?></b></td>
															<?php
																	if($per!='0')
																	{
																		?>
																		 <td class="numeric"><b><?=round($totalsqty,2)?></b></td>
																		<?php
																	}
																		?>
														     <td class="numeric"><b>Rs. <?=$totaltpcosttM?>/-</b></td>
															  <td class="numeric"><b><?=$totalstrprofittM?></b></td>
															   <td class="numeric"><b>Rs. <?=round($totalARPUt)?>/-</b></td>
														 
														
														</tr>
													 
						                            </tbody>
						
						<?php
		
		                
	 }
    
	
		             
	
	
}
else
{
	?>
	 <table class="table table-bordered table-striped table-condensed cf" width="100%">
														<thead class="cf">
														
															<tr>
															 <th class="numeric">Category</th>
																<th class="numeric">Amt</th>
																<?php
																	if($per!='0')
																	{
																		?>
																<th >Amt %</th>
																<?php
																	}
																?>
																<th class="numeric">Service Count</th>
																<?php
																	if($per!='0')
																	{
																		?>
																<th >Service %</th>
																<?php
																	}
																?>
																<th class="numeric">Product Cost</th>
																<th class="numeric">Profitibility</th>
																<th class="numeric">ARPU</th>
																
															</tr>
															
														</thead>
	<?php
		$set=selectcategoryall($getfrom,$getto);
		foreach($set as $tes)
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
								
								$stppq=select("CategoryName","tblCategories","CategoryID='".$CATTU[$q]."'");
								$CategoryName=$stppq[0]['CategoryName'];
								
								$stppsertypt=selectserviceall($getfrom,$getto,$CATTU[$q]);
						
								foreach($stppsertypt as $cat)
								{
									$serrt[]=$cat['ServiceID'];
								}
				
								//$stppsertypt=selectservice($storr,$getfrom,$getto,$CATTU[$q]);
					
								
								 foreach($stppsertypt as $cat)
								{
									
									$ServiceIDt=$cat['ServiceID'];
									//echo $ServiceIDt."<br>";
								    $stppsertyptup=selectservicedetailall($getfrom,$getto,$ServiceIDt);
								
										foreach($stppsertyptup as $tr)
										{
											$qty=$tr['qty'];
											$ServiceAmount=$tr['ServiceAmount'];
											$qttyt +=$qty;
											$strServiceAmount = $ServiceAmount*$qty;
											$totalstrServiceAmount=$totalstrServiceAmount+$strServiceAmount;
										}
								$sqlservicet=select("distinct(ProductID)","tblProductsServices","StoreID!='0' and ServiceID='".$ServiceIDt."' and CategoryID!=''");
								foreach($sqlservicet as $trp)
										{
											$ProductIDtP[]=$trp['ProductID'];
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
													$product_costt =$ProductMRPst/$PerQtyServest;
												    
													
													$tpcostT = round($product_costt);
													
												    $totaltpcostT=$totaltpcostT+$tpcostT;
													
													
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
										
									
										if($totalstrServiceAmount!='0' && $totalstrServiceAmount!='')
										{
											$strprofit = ($totalstrServiceAmount) - ($totaltpcostT);
											//$ARPU = ($strprofit) / ($qttyt);
											$ARPU = ($totalstrServiceAmount) - ($qttyt);
										}
										else
										{
											
											$totalstrServiceAmount=0;
											$strprofit = 0;
											//$ARPU = ($strprofit) / ($qttyt);
											$ARPU = ($totalstrServiceAmount) - ($qttyt);
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
								      $seramtper=($totalstrServiceAmount/$sumServiceAmountaall)*100;
									  $qtyper=($qttyt/$sumqttytall)*100;
									  $totalsamt +=$seramtper;
									  $totalsqty +=$qtyper;
				?>
	
	                      
			               <tbody>
						 
								<tr>
									
									<td><?=$CategoryName?></td>
									<td>Rs. <?=$totalstrServiceAmount?> /-</td>
												<?php
																	if($per!='0')
																	{
																		?>
																		<td><?=round($seramtper,2)?></td>
																		<?php
																	}
																		?>
									<td><?=$qttyt?></td>
									<?php
																	if($per!='0')
																	{
																		?>
																		<td><?=round($qtyper,2)?></td>
																		<?php
																	}
																		?>
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
						$seramtper="";
						$qtyper="";
		?>
						   <tbody>
						
														<tr>
															<td colspan="1"><center><b>Total Amount and Count in selected periods(s)</b><center></td>
															
															<td class="numeric"><b>Rs. <?=$totalstrServiceAmountT?>/-</b></td>
                                                                 <?php
																	if($per!='0')
																	{
																		?>
																		  <td class="numeric"><b><?=$totalsamt?></b></td>
																		<?php
																	}
																		?>
                                                            <td class="numeric"><b><?=$totalstrqty?></b></td>
															<?php
																	if($per!='0')
																	{
																		?>
																		  <td class="numeric"><b><?=$totalsqty?></b></td>
																		<?php
																	}
																		?>
														     <td class="numeric"><b>Rs. <?=$totaltpcosttM?>/-</b></td>
															  <td class="numeric"><b><?=$totalstrprofittM?></b></td>
															   <td class="numeric"><b>Rs. <?=round($totalARPUt)?>/-</b></td>
														 
														
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