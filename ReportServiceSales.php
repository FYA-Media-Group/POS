<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Store Stock Management | Nailspa";
	$strDisplayTitle = "View inventory for Store Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportServiceSales.php";
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
													if(isset($_GET["toandfrom"]) || !IsNull($_GET["Store"]))
													{
														$store=$_GET["Store"];
														$sep=select("StoreName","tblStores","StoreID='".$store."'");
														$storename=$sep[0]['StoreName'];
														
												?>
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store Filter selected : <?=$storename?> </h3>
												
												<br>
				

				
<?php
$DB = Connect();
$sql = "SELECT * from tblCategories where Status='0'";
// echo $sql."<br>";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strCategoryID = $row["CategoryID"];
		$strCategoryName = $row["CategoryName"];
		
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
									<th>Service Name</th>
									<th>Store</th>
									<th class="numeric">Cost</th>
									<th class="numeric"># Sold</th>
									<th class="numeric">Gross Rs</th>
									<th class="numeric"># Discount</th>
									<th class="numeric">O Dis Rs</th>
									<th class="numeric">M Dis Rs</th>
									<th class="numeric">Net Rs</th>
								</tr>
							</thead>
							
<?php
$storr=$_GET["Store"];
if(!empty($storr))
{
	
	$sqlservice = "SELECT tblProductsServices.CategoryID, tblProductsServices.ServiceID , tblServices.ServiceName, tblServices.ServiceCost, tblServices.ServiceCode,tblProductsServices.StoreID
					FROM `tblProductsServices` left join tblServices 
					on tblProductsServices.ServiceID=tblServices.ServiceID
					where tblProductsServices.CategoryID='$strCategoryID' and tblServices.ServiceID!='' and tblServices.ServiceID!='null' and tblServices.ServiceID!='NULL' and tblProductsServices.StoreID='".$storr."'
					group by tblProductsServices.ServiceID order by tblProductsServices.ProductServiceID desc ";
}
else
{

	$sqlservice = "SELECT tblProductsServices.CategoryID, tblProductsServices.ServiceID , tblServices.ServiceName, tblServices.ServiceCost, tblServices.ServiceCode,tblProductsServices.StoreID
					FROM `tblProductsServices` left join tblServices 
					on tblProductsServices.ServiceID=tblServices.ServiceID
					where tblProductsServices.CategoryID='$strCategoryID' and tblServices.ServiceID!='' and tblServices.ServiceID!='null' and tblServices.ServiceID!='NULL'
					group by tblProductsServices.ServiceID order by tblProductsServices.ProductServiceID desc ";
}

		
		// echo $sqlservice."<br>";
		
		$RSservice = $DB->query($sqlservice);
		if ($RSservice->num_rows > 0) 
		{
			$counterservice = 0;

			while($rowservice = $RSservice->fetch_assoc())
			{
				$strqty = "";
				$strServiceAmount = "";	
				$strOfferAmount = "";
				$strMembershipAmount = "";
				$strServiceNet2 = "";
				$strServiceNet = "";
				
				$counterservice ++;
				$strCategoryID = $rowservice["CategoryID"];
				$strServiceID = $rowservice["ServiceID"];
				$strServiceName = $rowservice["ServiceName"];
				$strServiceCost = $rowservice["ServiceCost"];
				$strServiceCode = $rowservice["ServiceCode"];
				$StoreID = $rowservice["StoreID"];
				$stpp=select("StoreName","tblStores","StoreID='".$StoreID."'");
				$StoreName=$stpp[0]['StoreName'];
				
					$sqldata = "SELECT tblAppointmentsDetailsInvoice.qty, tblAppointmentsDetailsInvoice.ServiceAmount, tblInvoiceDetails.OfferDiscountDateTime
								FROM tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentID left join tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID
								WHERE tblAppointmentsDetailsInvoice.ServiceID ='$strServiceID' and tblAppointments.IsDeleted!='1' $sqlTempfrom $sqlTempto";
					// echo $sqldata."<br>";
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
					
					$sqldiscount = "SELECT tblAppointmentMembershipDiscount.OfferAmount, tblAppointmentMembershipDiscount.MembershipAmount 
									FROM tblAppointmentMembershipDiscount
									left join tblInvoiceDetails 
									on tblAppointmentMembershipDiscount.AppointmentID=tblInvoiceDetails.AppointmentID
									left join tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID	WHERE tblAppointmentMembershipDiscount.ServiceID ='$strServiceID' and tblAppointments.IsDeleted!='1' $sqlTempfrom $sqlTempto";
					// echo $sqldiscount."<br>";
					$RSdiscount = $DB->query($sqldiscount);
					$counterDiscountUsage = "0";
					if ($RSdiscount->num_rows > 0) 
					{
						while($rowdiscount = $RSdiscount->fetch_assoc())
						{
							$counterDiscountUsage = $counterDiscountUsage + 1;
							$strOfferAmount += $rowdiscount["OfferAmount"];
							$strMembershipAmount += $rowdiscount["MembershipAmount"];
						}
					}
					else
					{
						$strOfferAmount = "0";
						$strMembershipAmount = "0";
					}
					
					$strServiceNet = ($strServiceAmount) - ($strMembershipAmount);
					$strServiceNet2 = ($strServiceNet) - ($strOfferAmount);

?>							
									
							<tbody>
								<tr>
									<td><?=$strServiceCode?></td>
									<td><?=$strServiceName?></td>
									<td><?=$StoreName?></td>
									<td class="numeric">Rs. <?=$strServiceCost?></td>
									<td class="numeric"><?=$strqty?></td>
									<td class="numeric">Rs. <?=$strServiceAmount?></td>
									<td class="numeric"><?=$counterDiscountUsage?></td>
									<td class="numeric">Rs. <?=$strOfferAmount?></td>
									<td class="numeric">Rs. <?=$strMembershipAmount?></td>
									<td class="numeric">Rs. <?=$strServiceNet2?></td>
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
	
?>							
				
						</table>
						
					</div>
				</div>
			</div>
		</div>
		
<?php	
	}
}
else
{
	echo "Opps! No category found according to selected search parameter...";
}
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