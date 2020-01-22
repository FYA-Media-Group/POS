<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Outstanding Payment Report | Nailspa";
	$strDisplayTitle = "Outstanding Payment Report of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportOutStandingPayments.php";
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
										<ul>
											<li><a href="#normal-tabs-1" title="Tab 1">Manage</a></li>
										</ul>
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of all Outstanding Payments</h3>
												
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
														<a class="btn btn-link" href="ReportOutstandingPayments.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
													

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
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store - <?=$storrrp?></h3>
												
												<br>
												
												
												
												<div class="example-box-wrapper">
													<table id="printdata" class="table table-bordered table-striped table-condensed cf">
														<thead>
															<tr>
															   <th>Sr</th>
																<th>Customer Name</th>
																<th>Invoice Date</th>
																<th>Pending Amount</th>
																<th>Invoice Amount</th>
																<th>Store</th>
															</tr>
														</thead>
														
														<tbody>

<?php
	$DB = Connect();
$storrr=$_GET["store"];
if(!empty($storrr))
{
	$sql = "Select tblPendingPayments.PendingAmount as Pending,tblInvoiceDetails.CustomerFullName,tblInvoiceDetails.RoundTotal,tblInvoiceDetails.OfferDiscountDateTime,tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID Left Join tblInvoiceDetails ON  tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.IsDeleted!='1' and  tblAppointments.StoreID='".$storrr."' and tblPendingPayments.Status='1' $sqlTempfrom $sqlTempto";
}
else
{
	$sql = "Select  tblPendingPayments.PendingAmount as Pending,tblInvoiceDetails.CustomerFullName,tblInvoiceDetails.RoundTotal,tblInvoiceDetails.OfferDiscountDateTime,tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID Left Join tblInvoiceDetails ON  tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.IsDeleted!='1' and tblPendingPayments.Status='1' $sqlTempfrom $sqlTempto";
}

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$Pending = $row["Pending"];
		
		$offerid = $row["offerid"];
		$memberid = $row["memberid"];
		$CustomerFullName = $row["CustomerFullName"];
		$RoundTotal = $row["RoundTotal"];
		$StoreID = $row["StoreID"];
		
		$DateTimeStampt = $row["OfferDiscountDateTime"];
		
		$DateTime = FormatDateTime($DateTimeStampt);
	
	  $selp=select("OfferName","tblOffers","OfferID='".$offerid."'");
		$OfferName=$selp[0]['OfferName'];
		$selpy=select("MembershipName","tblMembership","MembershipID='".$memberid."'");
		$MembershipName=$selpy[0]['MembershipName'];
		
		$Pending = $row["Pending"];
		
		if($Pending =="")
		{
			$Pending ="0.00";
		}
		else
		{
		
			$Pending = $Pending;
			
		}
		$TotalPending += $Pending;
		
		if($RoundTotal =="")
		{
			$RoundTotal ="0.00";
		}
		else
		{
		
			$RoundTotal = $RoundTotal;
			
		}
		$TotalRoundTotal += $RoundTotal;
		$sep=select("*","tblStores","StoreID='".$StoreID."'");
		$storename=$sep[0]['StoreName'];
		
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$CustomerFullName?></td>
																<td><?=$DateTime?></td>
																
																<td><?=$Pending?></td>
															
																<td><?=$RoundTotal?></td>
															    <td><?=$storename?></td>
																
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
															<td colspan="3"><center><b>Total Pending Amount in selected periods(s) : <?=$counter?></b><center></td>
															
															<td class="numeric"><b>Rs. <?=$TotalPending?>/-</b></td>
                                                            <td class="numeric"><b>Rs. <?=$TotalRoundTotal?>/-</b></td>
														<td></td>
														
														
														</tr>
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