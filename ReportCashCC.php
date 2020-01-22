<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Cash/CC Report | Nailspa";
	$strDisplayTitle = "Cash/CC Report of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "";
	$strMyTableID = "";
	$strMyField = "";
	$strMyActionPage = "ReportCashCC.php";
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

										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">Cash/CC Report</h3>
												
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
													
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportCashCC.php">Clear All Filter</a>
											
													</div>
												</form>
												
												
												<div class="example-box-wrapper">
												<?php
												if(isset($_GET["toandfrom"]))
												{
												?>
												<br><br>
												<span>
												<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?></h3>
												</span>
													
												
												
												
												
																	
				<table class="table table-bordered table-striped table-condensed cf"  cellspacing="0" width="100%">
				
					<thead>
						<tr>
							<th>Invoice No.</th>
							<th>Customer Name</th>
							<th>Total Invoice Amount</th>
							<th>Paid in Cash</th>
							<th>Paid using Card</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Invoice No.</th>
							<th>Customer Name</th>
							<th>Total Invoice Amount</th>
							<th>Paid in Cash</th>
							<th>Paid using Card</th>

						</tr>
					</tfoot>
					<tbody>

<?php

$DB = Connect();
$sql = "select tblInvoiceDetails.AppointmentId,tblInvoiceDetails.InvoiceId, tblInvoiceDetails.CustomerID, tblInvoiceDetails.CustomerFullName, tblInvoiceDetails.RoundTotal, tblInvoiceDetails.CashAmount, tblInvoiceDetails.CardAmount,tblInvoiceDetails.Flag,tblInvoiceDetails.PendingAmount from tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.IsDeleted!='1' $sqlTempfrom $sqlTempto";

$RS = $DB->query($sql);
if($RS->num_rows > 0) 
{
	while($row = $RS->fetch_assoc())
	{
		$strEID = $row["AppointmentID"];
		$strInvoiceNumber = $row["InvoiceId"];
		$strCustomerID = $row["CustomerID"];
		$strName = $row["CustomerFullName"];
		$strRoundTotal = $row["RoundTotal"];
		$strCashAmount = $row["CashAmount"];
		$strCardAmount = $row["CardAmount"];
		$strFlag = $row["Flag"];
		
		if($strCashAmount=="" || $strCashAmount=="NULL" || $strCashAmount=="null")
		{
			$strCashAmount="0.00";
		}
		else
		{
			$strCashAmount = $strCashAmount;
		}
		
		if($strCardAmount=="" || $strCardAmount=="NULL" || $strCardAmount=="null")
		{
			$strCardAmount="0.00";
		}
		else
		{
			$strCardAmount = $strCardAmount;
		}
	
		
		$TotalCard += $strCardAmount;
		$TotalCash += $strCashAmount;
		$TotalRound += $strRoundTotal;
?>		
							<tr>
								<td># <?=$strInvoiceNumber?></td>
								<td>Rs.<?=$strName?>/-</td>
								<td>Rs.<?=$strRoundTotal?>/-</td>
								<td>Rs.<?=$strCashAmount?>/-</td>	
								<td>Rs.<?=$strCardAmount?>/-</td>	
							</tr>
<?php				
				
	}
?>
							<tr>
								<td colspan="2"><b><center>Total : </center></b></td>
								<td><b>Rs.<?=$TotalRound?>/-</b></td>	
								<td><b>Rs.<?=$TotalCash?>/-</b></td>	
								<td><b>Rs.<?=$TotalCard?>/-</b></td>	
							</tr>
	<?php
}
else
{
?>				
							<tr>
								<td></td>
								<td></td>
								<td>No Invoices found in selected date period</td>
								<td></td>
								<td></td>
							</tr>
<?php															
}
echo "</tbody></table><br><br>";

$DB->close();
?>
														<?php
														}	
														else
														{
															echo "<br><center><h3>Please select dates!</h3></center>";
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