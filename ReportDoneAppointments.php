<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Appointments Done Report | Nailspa";
	$strDisplayTitle = "Appointments Done Report of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportDoneAppointments.php";
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
												<h3 class="title-hero">List of Appointments Done</h3>
												
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
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportDoneAppointments.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														

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
												?>
												<br>
												
												
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
															   <th>Sr</th>
																<th>Customer Name</th>
																<th>Store</th>
																<th>Check in & Check out</th>
																<th>TotalPayment</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
															   <th>Sr</th>
																<th>Customer Name</th>
																<th>Store</th>
																<th>Check in & Check out</th>
																<th>TotalPayment</th>
															</tr>
														</tfoot>
														<tbody>

<?php
$DB = Connect();

echo $storeid;
if($strStore!='0')
{
	// $sql = "Select CustomerID,StoreID,RedemptionCode,Amount,Date from tblGiftVouchers where StoreID='".$strStore."' $sqlTempfrom $sqlTempto";
	// echo "In if<br>";
		$sql = "SELECT tblAppointments.*, tblInvoiceDetails.* FROM tblAppointments left join tblInvoiceDetails on tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID where tblAppointments.IsDeleted!='1' and tblAppointments.Status='2' $sqlTempfrom $sqlTempto";
	// echo $sql;
}
else
{
	// echo "In else<br>";
	// $sql = "Select CustomerID,StoreID,RedemptionCode,Amount,RedempedDateTime from  tblGiftVouchers where 1 $sqlTempfrom $sqlTempto";
	$sql = "SELECT tblAppointments.*, tblInvoiceDetails.* FROM tblAppointments left join tblInvoiceDetails on tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID where tblAppointments.IsDeleted!='1' and tblAppointments.Status='2'  $sqlTempfrom $sqlTempto";
	
}
// echo $sql;
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		
		$CustomerID = $row["CustomerID"];
		$StoreID = $row["StoreID"];
		$AppointmentDate = $row["AppointmentDate"];
		$OfferDiscountDateTime = $row["OfferDiscountDateTime"];
		$TotalPayment = $row["TotalPayment"];
		$AppointmentCheckInTime = $row["AppointmentCheckInTime"];
		
		$dateObject = new DateTime($AppointmentCheckInTime);
		// echo $dateObject->format('h:i A');
		
		
		$AppointmentCheckOutTime = $row["AppointmentCheckOutTime"];
		$dateObject1 = new DateTime($AppointmentCheckOutTime);
		
		
		$memberid = $row["memberid"];
		$offerid = $row["offerid"];
		$VoucherID = $row["VoucherID"];
		
		$RedempedDateTime = $row["Date"];
		
		$RedempedDateTimet = FormatDateTime($RedempedDateTime);
	
	    $selp=select("StoreName","tblStores","StoreID='".$StoreID."'");
		$StoreName=$selp[0]['StoreName'];
		$selpy=select("CustomerFullName","tblCustomers","CustomerID='".$CustomerID."'");
		$CustomerFullName=$selpy[0]['CustomerFullName'];
		
		$selm=select("MembershipName","tblMembership","MembershipID='".$memberid."'");
		$MembershipName=$selm[0]['MembershipName'];
		
		$self=select("OfferName","tblOffers","OfferID='".$offerid."'");
		$OfferName=$self[0]['OfferName'];
		
		$selv=select("RedemptionCode","tblGiftVouchers","GiftVoucherID='".$VoucherID."'");
		$RedemptionCode=$selv[0]['RedemptionCode'];
		
		$Amount = $row["Amount"];
		
		if($Amount =="")
		{
			$Amount ="0.00";
		}
		else
		{
		
			$Amount = $Amount;
			
		}
		$TotalAmount += $Amount;
		
		
		
		
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$CustomerFullName?></td>
																<td><?=$StoreName?></td>
																<td><?=$dateObject->format('h:i A')?><br>To<br><?=$dateObject1->format('h:i A')?></td>
																<td>Rs. <?=$TotalPayment?></td>
																
															</tr>
<?php
	}
}
else
{
?>															
															<tr>
																<th></th>
																<th></th>
																<th></th>
																<td>No Records Found</td>
																<th></th>
															
															</tr>
													
														
<?php
}
$DB->close();
?>
														
														</tbody>
														
														<tbody>
														<tr>
															<td></td>
															<td colspan="4"><center><b>Total Appointments done in selected periods(s) : <?=$counter?></b><center></td>
														
															
														</tr>
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