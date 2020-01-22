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
													
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportServiceSalesCategoryBase.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														<!--<a class="btn btn-border btn-alt border-primary font-primary" href="ExcelExportData.php?from=<?=$getfrom?>&to=<?=$getto?>" title="Excel format 2016"><span>Export To Excel</span><div class="ripple-wrapper"></div></a>
														-->

													</div>
												</form>
												
												<br>
												<?php
													if(isset($_GET["toandfrom"]) || !IsNull($_GET["Store"]))
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
														
												?>
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store Filter selected : <?=$storrrp?> </h3>
												
												<br>
				

				
<?php
$DB = Connect();
$storr=$_GET["Store"];
if(!empty($storr))
{

$sql = "SELECT * from tblCategories where Status='0'";

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;
?>
           <div class="panel">
			  <div class="panel-body">
			     <div class="example-box-wrapper">
					<div class="scroll-columns">
					  <table class="table table-bordered table-striped table-condensed cf">
							<thead class="cf">
								<tr>
								<th>Sr</th>
									<th>Service Category</th>
								    <th class="numeric">Amt</th>
									<th class="numeric">Service Count</th>
									<th class="numeric">Product Cost</th>
									<th class="numeric">Profitibility</th>
									<th class="numeric">ARPU</th>
									
								</tr>
							</thead>
								<tbody>
<?php


	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strCategoryID = $row["CategoryID"];
		$strCategoryName = $row["CategoryName"];
		$sqlservice=select("distinct(tblProductsServices.ServiceID)","tblProductsServices left join tblServices 
					on tblProductsServices.ServiceID=tblServices.ServiceID","tblProductsServices.CategoryID='$strCategoryID' and tblServices.ServiceID!='' and tblServices.ServiceID!='null' and tblServices.ServiceID!='NULL' and tblProductsServices.StoreID='".$storr."' and tblServices.ServiceCode not in('yogitest1','yogitatest001','yogitatestfinal001','testservioceep','servicetestunfg124','servictet123','testvgvv')");

		
		foreach($sqlservice as $vaq)
		{
			
				$strServiceID[] = $vaq["ServiceID"];
		       
			   
		}	
		
	if($_SERVER['REMOTE_ADDR']=="111.119.219.70")
   {
      print_r($strServiceID);
   }
   else
   {
       
   }
		 for($p=0;$p<count($strServiceID);$p++)
		 {
			 $sqldata = "SELECT tblAppointmentsDetailsInvoice.qty, tblAppointmentsDetailsInvoice.ServiceAmount, tblInvoiceDetails.OfferDiscountDateTime
								FROM tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID
								WHERE tblAppointmentsDetailsInvoice.ServiceID ='$strServiceID[$p]' and tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto";
					
					$RSdata = $DB->query($sqldata);
					if ($RSdata->num_rows > 0) 
					{
						while($rowdata = $RSdata->fetch_assoc())
						{
							
							$strAppointmentID = $rowdata["AppointmentID"];
							$strqty += $rowdata["qty"];
							$strServiceAmount += $rowdata["ServiceAmount"];
						}
					}
					else
					{
						$strqty = "0";
						$strServiceAmount = "0";
					}
					
						$sqlservicet = "SELECT distinct(ProductID) FROM tblProductsServices WHERE tblProductsServices.StoreID='".$storr."' and tblProductsServices.CategoryID='".$strCategoryID."'";
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
									?>
									
								<tr>
									<td><?=$counter?></td>
									<td><?=$strCategoryName?></td>
									<td>Rs. <?=$strServiceAmount?> /-</td>
									<td><?=$strqty?></td>
									<td class="numeric">Rs. <?=$tpcost?></td>
									<td class="numeric"><?=$strprofit?></td>
									<td class="numeric">Rs. <?=round($ARPU)?></td>
		
								</tr>
			<?php
				$strqty = "";
				$strServiceAmount = "";	
		
	}
	}
	else
	{
		?>
			                    <tr>
									<td></td>
									<td>NO DATA FOUND</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<?php

			
									?>
								</tr>
		<?php
	}
}
else
{
	?>
	<div class="panel">
			<div class="panel-body">
			
				<div class="example-box-wrapper">
					<div class="scroll-columns">
					

					
						<table class="table table-bordered table-striped table-condensed cf">
							<thead class="cf">
								<tr>
								    <th>Sr</th>
									<th>Service Category</th>
								    <th class="numeric">Amt</th>
									<th class="numeric">Service Count</th>
									<th class="numeric">Product Cost</th>
									<th class="numeric">Profitibility</th>
									<th class="numeric">ARPU</th>
									<!--<th>Store</th>-->
								</tr>
							</thead>
							
	<?php
	// $counter = 0;
$sqlstore=select("StoreID,StoreName","tblStores","Status='0'");	
// foreach($sqlstore as $storet)
// {
	
	$sql = "SELECT * from tblCategories where Status='0'";

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;
	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strCategoryID = $row["CategoryID"];
		$strCategoryName = $row["CategoryName"];
		// $sqlservice=select("distinct(tblProductsServices.ServiceID)","tblProductsServices left join tblServices 
					// on tblProductsServices.ServiceID=tblServices.ServiceID","tblProductsServices.CategoryID='$strCategoryID' and tblServices.ServiceID!='' and tblServices.ServiceID!='null' and tblServices.ServiceID!='NULL' and tblProductsServices.StoreID='".$storet['StoreID']."' and tblServices.ServiceCode not in('yogitest1','yogitatest001','yogitatestfinal001','testservioceep','servicetestunfg124','servictet123','testvgvv')");
					
		$sqlservice=select("distinct(tblProductsServices.ServiceID)","tblProductsServices left join tblServices 
					on tblProductsServices.ServiceID=tblServices.ServiceID","tblProductsServices.CategoryID='$strCategoryID' and tblServices.ServiceID!='' and tblServices.ServiceID!='null' and tblServices.ServiceID!='NULL'  and tblServices.ServiceCode not in('yogitest1','yogitatest001','yogitatestfinal001','testservioceep','servicetestunfg124','servictet123','testvgvv')");
		
		foreach($sqlservice as $vaq)
		{
			$strServiceID[] = $vaq["ServiceID"];
		       
		}		 
		 for($p=0;$p<count($strServiceID);$p++)
		 {
			 // $sqldata = "SELECT tblAppointmentsDetailsInvoice.qty, tblAppointmentsDetailsInvoice.ServiceAmount, tblInvoiceDetails.OfferDiscountDateTime
								// FROM tblAppointmentsDetailsInvoice
								// left join tblInvoiceDetails 
								// on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID
								// WHERE tblAppointmentsDetailsInvoice.ServiceID ='$strServiceID[$p]' and tblAppointments.StoreID='".$storet['StoreID']."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto";
								 $sqldata = "SELECT tblAppointmentsDetailsInvoice.qty, tblAppointmentsDetailsInvoice.ServiceAmount, tblInvoiceDetails.OfferDiscountDateTime
								FROM tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID
								WHERE tblAppointmentsDetailsInvoice.ServiceID ='$strServiceID[$p]'  AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto";
								
					if($_SERVER['REMOTE_ADDR']=="111.119.219.70")
					   {
						   echo $sqldata."<br><br>";
					   }
					   else
					   {
						   
					   }
										
					$RSdata = $DB->query($sqldata);
					if ($RSdata->num_rows > 0) 
					{
						while($rowdata = $RSdata->fetch_assoc())
						{
							
							$strAppointmentID = $rowdata["AppointmentID"];
							$strqty += $rowdata["qty"];
							$strServiceAmount += $rowdata["ServiceAmount"];
						}
					}
					else
					{
						$strqty = "0";
						$strServiceAmount = "0";
					}
					
							// echo $strqty."<br>";
						// $sqlservicet = "SELECT distinct(ProductID) FROM tblProductsServices WHERE tblProductsServices.StoreID='".$storet['StoreID']."' and tblProductsServices.CategoryID='".$strCategoryID."'";
						$sqlservicet = "SELECT distinct(ProductID) FROM tblProductsServices WHERE tblProductsServices.CategoryID='".$strCategoryID."'";
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
									?>
									<tbody>
									
								<tr>
									<td><?=$counter?></td>
									<td><?=$strCategoryName?></td>
									<td>Rs. <?=$strServiceAmount?> /-</td>
									<td><?=$strqty?></td>
									<td class="numeric">Rs. <?=$tpcost?></td>
									<td class="numeric"><?=$strprofit?></td>
									<td class="numeric">Rs. <?=round($ARPU)?></td>
		                          <!--<td><?//=$StoreName?></td>-->
								</tr>
			<?php
				$strqty = "";
				$strServiceAmount = "";	
		
	}
	}
	else
	{
		?>
			                       <tr>
									<td></td>
									<td>NO DATA FOUND</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<!--<td></td>-->
									<?php

			
									?>
								</tr>
		<?php
	}
// }	

}
	            $summ="";
			    $cntt="";
				$totalamount="";
				$arpu="";
	
	?>
		                 </tbody>
						                             <tbody>
						
														<tr>
															<td colspan="2"><center><b>Total Amount and Count in selected periods(s) : <?=$counter?></b><center></td>
															
															<td class="numeric"><b>Rs. <?=$totalstrServiceAmount?>/-</b></td>
                                                            <td class="numeric"><b><?=$totalstrqty?></b></td>
														     <td class="numeric"><b>Rs. <?=$totaltpcost?>/-</b></td>
															  <td class="numeric"><b><?=$totalstrprofit?></b></td>
															   <td class="numeric"><b><?=round($totalARPU)?></b></td>
														
														
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