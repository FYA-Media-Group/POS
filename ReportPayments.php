<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Outstanding Payment Report | Nailspa";
	$strDisplayTitle = "Outstanding Payment Report of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportPayments.php";
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
			$sqlTempfrom = " and Date(DateTimeStamp)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(DateTimeStamp)<=Date('".$getto."')";
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
			$sqlTempfrom = " and Date(DateTimeStamp)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(DateTimeStamp)<=Date('".$getto."')";
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
													<?php 
													if($strAdminRoleID=='36')
													{
														?>
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
														<?php
													}
													else
													{
														$storr=$strStoreID;
													}
													
													?>
													
													
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportPayments.php">Clear All Filter</a>
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
												<h2 class="title-hero" id="heading" style="display:none"><center>Report Outstanding Payment</center></h2>
												<?php
												$datedrom=$_GET["toandfrom"];
													if($datedrom!="")
													{
														if($strAdminRoleID=='36')
														{
															$storr=$_GET["Store"];
															if($storr=='0')
															{
																$storrrp='All';
															}
															else
															{
																$stpp=select("StoreName","tblStores","StoreID='".$storr."'");
																$StoreName=$stpp[0]['StoreName'];
																$storrrp=$StoreName;
															}
														}
														else
														{
															$storr=$strStoreID;
														}
												?>
														<h3 >Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store Filter selected : <?=$storrrp?> </h3>
												
												
											
												<div class="example-box-wrapper">
													<table class="table table-bordered table-striped table-condensed cf" width="100%">
														<thead>
															<tr>
															   <th>Sr</th>
																<th>Customer Name</th>
																<!--<th>Offer</th>
																<th>Membership</th>-->
																<th>Invoice No.</th>
																<th>Pending Amount</th>
																<!--<th>Total Amount</th>-->
																<th>Pending Date</th>
																<th>Store</th>
															</tr>
														</thead>
													
														<tbody>

<?php
	$DB = Connect();
if(!empty($storr))
{
	// echo "In if<br>";
	$sql = "Select tblPendingPayments.PendingAmount as Pending,tblAppointments.offerid,tblAppointments.memberid,tblInvoiceDetails.CustomerFullName,tblInvoiceDetails.InvoiceId,tblInvoiceDetails.RoundTotal, tblAppointments.AppointmentID, tblAppointments.StoreID,
	tblPendingPayments.DateTimeStamp from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID Left Join tblInvoiceDetails ON  tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.IsDeleted!='1' and tblAppointments.StoreID='".$storr."' and tblPendingPayments.PendingStatus='2' $sqlTempfrom $sqlTempto";
}
else
{
	// echo "In else<br>";
	$sql = "Select tblPendingPayments.PendingAmount as Pending,tblAppointments.offerid,tblAppointments.memberid,tblInvoiceDetails.CustomerFullName,tblInvoiceDetails.InvoiceId,
	tblAppointments.AppointmentID, tblAppointments.StoreID,
	tblInvoiceDetails.RoundTotal,tblPendingPayments.DateTimeStamp from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID Left Join tblInvoiceDetails ON  tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.IsDeleted!='1' and tblAppointments.StoreID!='0'and tblPendingPayments.PendingStatus='2' $sqlTempfrom $sqlTempto";
}

// echo $sql;
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$Pending = $row["Pending"];
		
		$offerid = $row["offerid"];
		$InvoiceId = $row["InvoiceId"];
		$memberid = $row["memberid"];
		$StoreID = $row["StoreID"];
		$appointment_id = $row["AppointmentID"];
		$CustomerFullName = $row["CustomerFullName"];
		$RoundTotal = $row["RoundTotal"];
		$DateTimeStampt = $row["DateTimeStamp"];
		$DateTime = FormatDateTime($DateTimeStampt);
	
		$getUID = EncodeQ($appointment_id);
	
		$selp=select("OfferName","tblOffers","OfferID='".$offerid."'");
		$OfferName=$selp[0]['OfferName'];
		$selpy=select("MembershipName","tblMembership","MembershipID='".$memberid."'");
		$MembershipName=$selpy[0]['MembershipName'];
		
		
		$selpS=select("StoreName","tblStores","StoreID='".$StoreID."'");
		$StoreName=$selpS[0]['StoreName'];
		
		
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
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$CustomerFullName?></td>
																<!--<td><?//=$OfferName?></td>
																<td><?//=$MembershipName?></td>-->
																<td>
																<a id="status" class="btn btn-link" href="PendingInvoicesForDisplay.php?uid=<?=$getUID;?>">
																<?=$InvoiceId?></a>
																</td>
																<td><?=$Pending?></td>
																<!--<td><?//=$RoundTotal?></td>-->
																<td><?=$DateTime?></td>
																<td><?=$StoreName?></td>
																
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
																<!--<td></td>-->
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
                                                            <td class="numeric"><b><?//=$TotalRoundTotal?></b></td>
                                                            <td class="numeric"><b><?//=$TotalRoundTotal?></b></td>
														
														
														</tr>
													</tbody>
													
													</table>
												</div>
												</div>
												<?php
													}
													else
													{
														echo "<br><center><h3>Please Select Month And Year!</h3></center>";
													}
												?>
												<br>
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