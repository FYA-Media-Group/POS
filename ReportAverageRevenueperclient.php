<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Average Revenue Per Client | Nailspa";
	$strDisplayTitle = "Average Client Revenue Report of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportAverageRevenueperclient.php";
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
			$sqlTempfrom = " and Date(OfferDiscountDateTime)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(OfferDiscountDateTime)<=Date('".$getto."')";
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
			$sqlTempfrom = " and Date(OfferDiscountDateTime)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(OfferDiscountDateTime)<=Date('".$getto."')";
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
												<h3 class="title-hero">List of New Clients</h3>
												
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
														<a class="btn btn-link" href="ReportAverageRevenueperclient.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
															<?php
													$datedrom=$_GET["toandfrom"];
													if($datedrom!="")
													{
														   ?>
														<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
                                                        <?php
													   }
														?>
													</div>
												
												</form>
												
												<br>
												
													<div id="printdata">	
													<h2 class="title-hero" id="heading" style="display:none"><center>Report Average Revenue Per Client</center></h2>
												<?php
													$datedrom=$_GET["toandfrom"];
													if($datedrom!="")
													{
												?>
														<h3>Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?></h2>
												
												<br>
												
												
											
												<div class="example-box-wrapper">
													<table class="table table-bordered table-striped table-condensed cf" width="100%">
														<thead>
															<tr>
															   <th style="text-align:center">Sr</th>
															    <th style="text-align:center">Store</th>
															   <th style="text-align:center">Total Payment</th>
															   <th style="text-align:center">Total Customers</th>
																<th style="text-align:center">Average Revenue</th>
															</tr>
														</thead>
														
														<tbody>

<?php
$DB = Connect();
	$counter = 0;
$sqp=select("distinct(StoreID)","tblAppointments","Status='2'");
foreach($sqp as $val)
{
	$counter ++;
	$storrr=$val['StoreID'];
	$sql="SELECT SUM(tblInvoiceDetails.TotalPayment) as TotalPay, count(tblInvoiceDetails.CustomerID) as TotalCustomers FROM tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='".$storrr."' $sqlTempfrom $sqlTempto";
	//echo $sql."<hr>";

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{


	while($row = $RS->fetch_assoc())
	{
		
		$TotalCustomers = $row["TotalCustomers"];
		$TotalPayment = $row["TotalPay"];
		$AverageValue=$TotalPayment/$TotalCustomers;
		$FibalAverage=Round($AverageValue , 2);
		$CustomerMobileNo = $row["CustomerMobileNo"];
		$RegDate = $row["RegDate"];
		$RegDatet = FormatDateTime($RegDate);
			
		$sept=select("StoreName","tblStores","StoreID='".$storrr."'");
        $StoreName=$sept[0]['StoreName'];
			if($FibalAverage =="")
		{
			$FibalAverage ="0.00";
		}
		else
		{
			$FibalAverage = $FibalAverage;
		}
		
		$FinalPayment += $TotalPayment;
		$FinalCustomers += $TotalCustomers;
		$TotalFibalAverage = $FinalPayment / $FinalCustomers;
		?>
															<tr id="my_data_tr_<?=$counter?>">
																<td><center><?=$counter?></center></td>
																<td><center><?=$StoreName?></center></td>
																<td class="numeric"><center><?=$TotalPayment?></center></td>
																
																<td><center><?=$TotalCustomers?></center></td>
																<td><center><?=$FibalAverage?></center></td>
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
																<td>No Records Found</td>
																<td></td>
																<td></td>
															</tr>
													
														
<?php
}
}
$DB->close();
?>
														
														</tbody>
														
														<tbody>
														<tr>

															<td colspan='2'><center><b>Total : <b><center></td>
															<td><center><b><?=$FinalPayment?></b><center></td>
															<td><center><b><?=$FinalCustomers?></b><center></td>
															<td><center><b><?=Round($TotalFibalAverage, 2)?></b><center></td>
															
														</tr>
													</tbody>
													
													</table>
												</div>
												<?PHP
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