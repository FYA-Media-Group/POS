<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Offer Redemption Report | Nailspa";
	$strDisplayTitle = "Offer Redemption Report of Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportOfferWiseRedemptions.php";
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
			$sqlTempfrom = " and Date(OfferDateFrom)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(OfferDateFrom)<=Date('".$getto."')";
		}
	}
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
			$sqlTempfrom = " and Date(OfferDateTo)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(OfferDateTo)<=Date('".$getto."')";
		}
	}
	
	if(!IsNull($_GET["Store"]))
	{
		$strStoreID = $_GET["Store"];
		
			$sqlTempStore = "StoreID='$strStoreID'";
		
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
												<h3 class="title-hero">List of all Offers</h3>
												
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
														<select class="form-control required"  name="store">
																		<option value="" selected>--Select Store--</option>
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
														<a class="btn btn-link" href="ReportServiceSales.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														<!--<a class="btn btn-border btn-alt border-primary font-primary" href="ExcelExportData.php?from=<?=$getfrom?>&to=<?=$getto?>" title="Excel format 2016"><span>Export To Excel</span><div class="ripple-wrapper"></div></a>
														--><a class="btn btn-border btn-alt border-primary font-success" href="pdfcreator/Main/SalesReport.php?from=<?=$getfrom?>&to=<?=$getto?>" title="PDF Report"><span>Export To PDF</span><div class="ripple-wrapper"></div></a>

													</div>
												</form>
												
												<br>
												<?php
													if(isset($_GET["toandfrom"]))
													{
												?>
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?></h3>
												<?php
													}
													else
													{
														
													}
													
													if(!IsNull($_GET["Store"]))
													{
												?>
														<h3 class="title-hero">Store Filter selected : <?=$strStoreID?> </h3>
												<?php
													}
													else
													{
														
													}
												?>
												<br>
				

				
<?php
$DB = Connect();
$store=$_GET["store"];


?>
		<div class="panel">
			<div class="panel-body">
				<h3 class="title-hero"><font color="Red"><?=$strCategoryName?></font></h3>
				<div class="example-box-wrapper">
					<div class="scroll-columns">
					

					
						<table class="table table-bordered table-striped table-condensed cf">
							<thead class="cf">
								<tr>
									<th>Code</th>
									<th>Offer Name</th>
									<th class="numeric">Store</th>
									<th class="numeric">Cost</th>
						
									<th class="numeric">Date</th>
									
								</tr>
							</thead>
							
<?php

$DB = Connect();

if($store!='0')
{
	$sql = "SELECT count(tblAppointmentMembershipDiscount.OfferID) as cnt from tblInvoiceDetails Left Join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID Left Join tblAppointmentMembershipDiscount
 on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID left join tblOffers
 on tblAppointments.offerid=tblOffers.OfferID where tblAppointments.IsDeleted!='1' and tblAppointments.offerid!='0' and tblAppointmentMembershipDiscount.OfferID!='0' and tblAppointments.StoreID='".$store."' $sqlTempfrom $sqlTempto";
}
else
{
	$sql = "SELECT count(tblAppointmentMembershipDiscount.OfferID) as cnt from tblInvoiceDetails Left Join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID Left Join tblAppointmentMembershipDiscount
 on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID left join tblOffers
 on tblAppointments.offerid=tblOffers.OfferID where tblAppointments.IsDeleted!='1' and tblAppointments.offerid!='0' and tblAppointmentMembershipDiscount.OfferID!='0' $sqlTempfrom $sqlTempto";
}
echo $sql;
$RSPC = $DB->query($sql);
if ($RSPC->num_rows > 0) 
{
	$strTotalPCAmount = "";
	while($rowPC = $RSPC->fetch_assoc())
	{
		$count = $rowPC["cnt"];
	
	}
}
else
{
	
}
?>
<hr><h4>Total Offers(s) redeemed in selected time period : <?=$count;?></h4>
		<br>
<?php
if($store!='0')
{

	$sql1 = "SELECT tblOffers.OfferName,tblOffers.OfferCode, tblAppointmentMembershipDiscount.OfferAmount,tblInvoiceDetails.OfferDiscountDateTime,tblAppointments.StoreID from tblInvoiceDetails Left Join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID Left Join tblAppointmentMembershipDiscount
 on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID left join tblOffers
 on tblAppointments.offerid=tblOffers.OfferID where tblAppointments.IsDeleted!='1' and tblAppointments.offerid!='0' and tblAppointmentMembershipDiscount.OfferID!='0' and tblAppointments.StoreID='".$store."' $sqlTempfrom $sqlTempto";
}
else
{
	$sql1 = "SELECT tblOffers.OfferName,tblOffers.OfferCode ,tblAppointmentMembershipDiscount.OfferAmount,tblInvoiceDetails.OfferDiscountDateTime,tblAppointments.StoreID from tblInvoiceDetails Left Join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID Left Join tblAppointmentMembershipDiscount
 on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID left join tblOffers
 on tblAppointments.offerid=tblOffers.OfferID where tblAppointments.IsDeleted!='1' and tblAppointments.offerid!='0' and tblAppointmentMembershipDiscount.OfferID!='0' $sqlTempfrom $sqlTempto";
}

$RS = $DB->query($sql1);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$OfferName = $row["OfferName"];
		
		$OfferCode = $row["OfferCode"];
		$OfferAmount = $row["OfferAmount"];
		$OfferDiscountDateTime = $row["OfferDiscountDateTime"];
		$StoreID = $row["StoreID"];
	     
		$OfferDiscountDateTimet = FormatDateTime($OfferDiscountDateTime);
	
	    $selp=select("StoreName","tblStores","StoreID='".$StoreID."'");
		$StoreName=$selp[0]['StoreName'];
		
		$OfferAmount = $row["OfferAmount"];
		
		if($OfferAmount =="")
		{
			$OfferAmount ="0.00";
		}
		else
		{
		
			$OfferAmount = $OfferAmount;
			
		}
		$TotalOfferAmount += $OfferAmount;
		
		
		
		
?>		
												
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$OfferCode?></td>
																<td><?=$OfferName?></td>
																
																<td><?=$StoreName?></td>
															
																<td><?=$OfferAmount?></td>
																<td><?=$OfferDiscountDateTimet?></td>
																
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
															
															</tr>
													
														
<?php
}
$DB->close();
?>
														
														</tbody>
														
														<tbody>
														<tr>
															<td colspan="4"><center><b>Total Offer Amount in selected periods(s) : <?=$counter?></b><center></td>
															
															<td class="numeric"><b>Rs. <?=$TotalAmount?>/-</b></td>
                                                            <td class="numeric"></td>
												
														
														
														</tr>
													</tbody>
													
				
						</table>
					</div>
				</div>
			</div>
		</div>
		
<?php	



$DB->close();

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