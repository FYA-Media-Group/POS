<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Monthly Sale Achieved Report | Nailspa";
	$strDisplayTitle = "Monthly Sale Achieved Report of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportMonthlySaleAchieved.php";
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
		
		$timef=strtotime($getfrom);
           $frommonth=date("F",$timef);
		//$frommonth=date("m", strtotime($getfrom));
		
		$to = $arraytofrom[1];
		$datetime = new DateTime($to);
		$getto = $datetime->format('Y-m-d');
		$timet=strtotime($getto);
           $tomonth=date("F",$timet);
	//	$tomonth=date("m", strtotime($getto));

		if(!IsNull($from))
		{
			$sqlTempfrom = " and tblStoreSalesTarget.Month >='".$frommonth."'";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and tblStoreSalesTarget.Month >='".$tomonth."'";
		}
		if(!IsNull($from))
		{
			$sqlTempfrom1 = " and MONTHNAME(tblInvoiceDetails.OfferDiscountDateTime)>='".$frommonth."'";
		}

		if(!IsNull($to))
		{
			$sqlTempto1 = " and MONTHNAME(tblInvoiceDetails.OfferDiscountDateTime)>='".$tomonth."'";
		}
	}
	if(isset($_GET["toandfrom"]))
	{
		$strtoandfrom = $_GET["toandfrom"];
		$arraytofrom = explode("-",$strtoandfrom);
		
		$from = $arraytofrom[0];
		$datetime = new DateTime($from);
		$getfrom = $datetime->format('Y-m-d');
			$timef=strtotime($getfrom);
           $frommonth=date("F",$timef);
	  //  $frommonth=date("m", strtotime($getfrom));
		$to = $arraytofrom[1];
		$datetime = new DateTime($to);
		$getto = $datetime->format('Y-m-d');
		//$tomonth=date("m", strtotime($getto));
			$timet=strtotime($getto);
           $tomonth=date("F",$timet);

		if(!IsNull($from))
		{
			$sqlTempfrom = " and tblStoreSalesTarget.Month >='".$frommonth."'";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and tblStoreSalesTarget.Month >='".$tomonth."'";
		}
		if(!IsNull($from))
		{
			$sqlTempfrom1 = " and MONTHNAME(tblInvoiceDetails.OfferDiscountDateTime)>='".$frommonth."'";
		}

		if(!IsNull($to))
		{
			$sqlTempto1 = " and MONTHNAME(tblInvoiceDetails.OfferDiscountDateTime)>='".$tomonth."'";
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
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportMonthlySaleAchieved.php">Clear All Filter</a>
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
																<th>Customer</th>
																<th>Sale Amount</th>
																<th>Store</th>
																<th>Charge Amount</th>
																<th>Balance Amount</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
															   <th>Sr</th>
																<th>Customer</th>
															    <th>Sale Amount</th>
																<th>Store</th>
																<th>Charge Amount</th>
																<th>Balance Amount</th>
															</tr>
														</tfoot>
														<tbody>

<?php
$DB = Connect();
if($strStore!='')
{

	$sql = "Select tblStoreSalesTarget.TargetAmount as Target from tblStoreSalesTarget WHERE tblStoreSalesTarget.StoreID='".$strStore."' $sqlTempfrom $sqlTempto";
}
else
{
	$sql = "Select tblStoreSalesTarget.TargetAmount as Target from tblStoreSalesTarget WHERE 1 $sqlTempfrom $sqlTempto";
}

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$Target = $row["Target"];
		
		
		if($Target =="")
		{
			$Target ="0.00";
		}
		else
		{
		
			$Target = $Target;
			
		}
		$TotalTarget += $Target;
	
	
		
?>														
														
														
<?php
	}
}
if($strStore!='')
{
	$sql1="select tblAppointments.AppointmentID,tblAppointments.CustomerID, tblInvoiceDetails.RoundTotal, tblAppointments.StoreID, tblInvoiceDetails.ChargeAmount
from tblAppointments 
left join tblInvoiceDetails on
tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentId
where tblAppointments.IsDeleted!='1' and tblAppointments.StoreID='".$strStore."' and tblInvoiceDetails.AppointmentId!='NULL' $sqlTempfrom1 $sqlTempto1";
}
else
{
	$sql1="select tblAppointments.AppointmentID,tblAppointments.CustomerID,tblInvoiceDetails.RoundTotal, tblAppointments.StoreID, tblInvoiceDetails.ChargeAmount
from tblAppointments 
left join tblInvoiceDetails on
tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentId
where tblAppointments.IsDeleted!='1' and tblInvoiceDetails.AppointmentId!='NULL' $sqlTempfrom1 $sqlTempto1";
}
//echo $sql1;

$RS = $DB->query($sql1);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$AppointmentID = $row["AppointmentID"];
	    $CustomerID = $row["CustomerID"];
		
		$RoundTotal = $row["RoundTotal"];
		if($RoundTotal =="")
			{
				$RoundTotal ="0.00";
			}
			else
			{
			
				$RoundTotal = $RoundTotal;
				
			}
			$TotalRound += $RoundTotal;
		
		$StoreID = $row["StoreID"];
		$selpt=select("StoreName","tblStores","StoreID='".$StoreID."'");
		$StoreName=$selpt[0]['StoreName'];
    	$selpty=select("CustomerFullName","tblCustomers","CustomerID='".$CustomerID."'");
		$CustomerFullName=$selpty[0]['CustomerFullName'];
		$ChargeAmount = $row["ChargeAmount"];
		$charge=explode(",",$ChargeAmount);
		for($i=0;$i<count($charge);$i++)
		{
			//echo $charge[$i];
			$charamt=str_replace("+","",$charge[$i]);
			
			if($charamt=="")
			{
				$charamt ="0.00";
			}
			else
			{
			
				$charamt = $charamt;
				
			}
		$Totalcharge += $charamt;
		$Remaintotal=$RoundTotal-$Totalcharge;
		}
		$Totalcharged += $Totalcharge;
		$Remaintotalt += $Remaintotal;
		
		
			
		
		
	
		
?>														
		
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$CustomerFullName?></td>
																<td><?=$RoundTotal?></td>
																<td><?=$StoreName?></td>
																<td><?=$Totalcharge?></td>
																<td><?=$Remaintotal?></td>
																
															</tr>												
															
<?php
$Totalcharge="";
$Remaintotal="";

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
																
															</tr>
													
														
<?php
}
$DB->close();
?>
														
														</tbody>
														
														<tbody>
														<tr>
															<td colspan="2"><center><b>Sum Of Amount(s) : <?=$counter?></b><center></td>
															 <td class="numeric"><b>Rs. <?=$TotalRound?>/-</b></td>
															 <td class="numeric"></td>
															 <td class="numeric"><b>Rs. <?=$Totalcharged?>/-</b></td>
														      <td class="numeric"><b>Rs. <?=$Remaintotalt?>/-</b></td>
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