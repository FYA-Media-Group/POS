<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Sales Reconcilation | Nailspa";
	$strDisplayTitle = "Sales Reconcilation for Nailspa Store";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "Reconciliation.php";
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


<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	
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
					
<?php
								if($strStore=="" || $strStore=="0")
								{
									echo "<b>OOPS...<br>You are on the wrong page</b><br><br>";	
									if($strAdminRoleID=="36")
									{
?>									
										<a class="btn btn-primary btn-" href="Dashboard.php"><i class="fa fa-backward"></i>Go Back</a>
<?									
									}
									elseif($strAdminRoleID=="39")
									{
?>									
										<a class="btn btn-primary btn-" href="Admin-Dashboard.php"><i class="fa fa-backward"></i>Go Back</a>
<?									
									}
									elseif($strAdminRoleID=="38")
									{
?>									
										<a class="btn btn-primary btn-" href="Audit-Dashboard.php"><i class="fa fa-backward"></i>Go Back</a>
<?									
									}
									elseif($strAdminRoleID=="2")
									{
?>									
										<a class="btn btn-primary btn-" href="Marketing-Dashboard.php"><i class="fa fa-backward"></i>Go Back</a>
<?									
									}
								}
								else
								{
?>
									<div id="page-title">
										<h2><?=$strDisplayTitle?></h2>
									</div>
<?php									
								}
?>
                    
					<script type="text/javascript" src="assets/widgets/datepicker/datepicker.js"></script>
                    <script type="text/javascript">
                        /* Datepicker bootstrap */
                  $(function() {
                            "use strict";
                            $('.bootstrap-datepicker').bsdatepicker({
                                format: 'yyyy-mm-dd'
                            });
                        });
                    </script>
                    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker.js"></script>
                    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker-demo.js"></script>
                    <script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>
                    <script type="text/javascript" src="assets/widgets/timepicker/timepicker.js"></script>
                    <script type="text/javascript">
                        /* Timepicker */

                        $(function() {
                            "use strict";
                            $('.timepicker-example').timepicker();
                        });
                    </script>
					<script>
						$(function ()						
						{
							$("#reportdate").datepicker();
							
							
							
						});
					</script>	
<?php
					
					if($strStore=="" || $strStore=="0")
								{
									
								}
								else
								{
							?>
									<!--<a class="btn btn-primary btn-lg btn-" href="<?//=$strMyActionPage?>"><i class="fa fa-backward"></i> &nbsp; Send for Reconcilation</a>-->
							
							<br></br>
							<div class="example-box-wrapper">
									<div class="tabs">
										
										<div id="normal-tabs-1">

											<div class="example-box-wrapper">
											<?php
											if($strStore=="" || $strStore=="0")
											{
												$strStoreID = Filter($_GET["Store"]);
												
												// Store Name
													if($strStoreID=="1")
													{
														$strNameofTheStore = "Colaba";
													}
													elseif($strStoreID=="2")
													{
														$strNameofTheStore = "Khar";
													}
													elseif($strStoreID=="3")
													{
														$strNameofTheStore = "Breach Candy";
													}
													elseif($strStoreID=="4")
													{
														$strNameofTheStore = "Oshiwara";
													}
													elseif($strStoreID=="5")
													{
														$strNameofTheStore = "Lokhandwala";
													}
													else
													{
														$strNameofTheStore = "--";
													}
												//Store Name
												
												$getTodaysDatedisplay = $_GET["reportdate"];
												$date15 = new DateTime($getTodaysDatedisplay);
												$getTodaysDate = $date15->format('Y-m-d'); // 31-07-2012
											?>
											
											
												
												
											
												
											<?php
											}		
											else
											{
												$strStoreID = $strStore;
												$getTodaysDate = date('Y-m-d');
												$strNameofTheStore = $strStoreNamedisplay;
											}
											?>
											
											<?php
											
											?>
											
											<span>
												<h3>
													<!--<b>Date : <?//=$getTodaysDate ?> </b><br>-->
													<!--<b>Store : <?//=$strNameofTheStore?> </b>-->
													<a class="btn btn-primary btn-" style="cursor:default" ><i class="fa fa-backward"></i><b>Date : <?=$getTodaysDate ?> </b><br>
													</b></a>
													<a class="btn btn-primary btn-" style="cursor:default" ><i class="fa fa-backward"></i>
													<b>Store : <?=$strNameofTheStore?> </b></a>
												</h3>
											</span>	
											
												<table class="table table-bordered table-striped table-condensed cf">
												
													<thead class="cf">
															<tr>
																<th>Date</th>
																<th>Invoice No.</th>
																<th>Customer Name</th>
																<th>Services</th>
																<th class="numeric">Price Rs</th>
																<th class="numeric">Subtotal Rs</th>
																<th class="numeric">O Dis Rs</th>
																<th class="numeric">M Dis Rs</th>
																<th class="numeric">Gift V Sold Rs</th>
																<th class="numeric">GV Redeemed Rs</th>

																<th class="numeric">Tax Rs</th>
																<th class="numeric">Total Rs</th>
																<th class="numeric">Cash</th>
																<th class="numeric">Card</th>
																<th class="numeric">Pending Amount</th>
																
															</tr>
														</thead>
												
<?php
$DB = Connect();

$sqlPC = "select Amount from tblExpenses where DateOfExpense=Date('$getTodaysDate') and StoreID ='$strStoreID' and Status='0'";

//echo $sqlinvoice;
$RSPC = $DB->query($sqlPC);
if ($RSPC->num_rows > 0) 
{
	$strTotalPCAmount = "";
	while($rowPC = $RSPC->fetch_assoc())
	{
		$strPCAmount = $rowPC["Amount"];
		$strTotalPCAmount += $strPCAmount;
	}
}
else
{
	$strTotalPCAmount = "0.00";
}
?>
		<hr><h4>Petty Cash Spent : Rs.<?=$strTotalPCAmount;?> / -</h4>
		<br>
		
<?php
$strTotalSubTotal = "";
$strTotalPTotal = "";


$sqlinvoice = "select tblInvoiceDetails.AppointmentID, (select Amount from tblGiftVouchers where GiftVoucherID=tblInvoiceDetails.GVPurchasedID and AppointmentID=tblInvoiceDetails.AppointmentID) as GVPurchased , (select Amount from tblGiftVouchers where GiftVoucherID=tblInvoiceDetails.GVRedeemedID and RedempedBy=tblInvoiceDetails.AppointmentID) as GVRedeemed, (tblInvoiceDetails.OfferDiscountDatetime) as Date, tblInvoiceDetails.InvoiceId ,tblInvoiceDetails.CustomerFullName, tblInvoiceDetails.ServiceName , 
		tblInvoiceDetails.Qty, tblInvoiceDetails.ServiceAmt, tblInvoiceDetails.DisAmt, tblInvoiceDetails.OfferAmt, tblAppointments.StoreID,
		tblInvoiceDetails.SubTotal, tblInvoiceDetails.Total, tblInvoiceDetails.CardAmount, tblInvoiceDetails.CashAmount, tblInvoiceDetails.TotalPayment, tblInvoiceDetails.PendingAmount, tblInvoiceDetails.ChargeName, tblInvoiceDetails.ChargeAmount
		from tblInvoiceDetails 
		left join tblAppointments 
		on tblInvoiceDetails.AppointmentID=tblAppointments.AppointmentID
		where Date(tblInvoiceDetails.OfferDiscountDateTime)=Date('$getTodaysDate') and tblAppointments.StoreID ='$strStoreID'";

//echo $sqlinvoice;
$RSinvoice = $DB->query($sqlinvoice);
if ($RSinvoice->num_rows > 0) 
{
	$counter ="";
	$strTotalSubTotalaaa = "";
	while($rowinvoice = $RSinvoice->fetch_assoc())
	{
		$counter = $counter + 1;
		
		$strAppointID = $rowinvoice["AppointmentID"];
		
		// Gift Voucher Redemtion and Purchase
		$strGVPurchaseID = $rowinvoice["GVPurchased"];
		if($strGVPurchaseID=="NULL" || $strGVPurchaseID=="null" || $strGVPurchaseID=="")
		{
			$strGVPurchaseID="0.00";
		}
		else
		{
			$strGVPurchaseID=$strGVPurchaseID;
		}
		$TotalGVPurchased += $strGVPurchaseID;
		
		
		$strGVRedeemID = $rowinvoice["GVRedeemed"];
		if($strGVRedeemID=="NULL" || $strGVRedeemID=="null" || $strGVRedeemID=="")
		{
			$strGVRedeemID="0.00";
		}
		else
		{
			$strGVRedeemID=$strGVRedeemID;
		}
		
		
		$TotalGVRedeemed += $strGVRedeemID;
		
		
		$strDate = FormatDatetime($rowinvoice["Date"],'0');
		$strCustomerFullName = $rowinvoice["CustomerFullName"];
		$strInvoiceID = $rowinvoice["InvoiceId"];
		
		// Services
		$strServices = $rowinvoice["ServiceName"];
		$strServices = explode(",", $strServices);
		
		// Service Amount
		$strServicesAmount = $rowinvoice["ServiceAmt"];
		$strServicesAmount = explode(",", $strServicesAmount);
		
		// Membership Discount
		$strMDiscount = $rowinvoice["DisAmt"];
		if($strMDiscount =="")
		{
			$TotalMAmount ="0.00";
		}
		else
		{
			$strMDiscount = explode(",", $strMDiscount);
			$TotalMAmount = "";
			foreach($strMDiscount as $MAmount)
			{
				$TotalMAmount += $MAmount;
			}
		}
		$strFinalTotalDiscount += $TotalMAmount;
			
			
		// Offer Discount
		$strODiscount = $rowinvoice["OfferAmt"];
		if($strODiscount =="")
		{
			$TotalOAmount ="0.00";
		}
		else
		{
			$strODiscount = explode(",", $strODiscount);
			$TotalOAmount = "";
			foreach($strODiscount as $OAmount)
			{
				$TotalOAmount += $OAmount;
			}
		}
		$strFinalTotalOffer += $TotalOAmount;
		
		// Taxation
		$strChargeName = $rowinvoice["ChargeName"];
		$strChargeAmount = $rowinvoice["ChargeAmount"];
		$strChargeName = explode(",", $strChargeName);
		$strChargeAmount = explode(",", $strChargeAmount);
	
	
		// Total and Subtotal
		$strTotal = $rowinvoice["Total"];
		$strTotalofTotal += $strTotal;

		$strTotalPayment = $rowinvoice["TotalPayment"];
		$strTotalPTotal += $strTotalPayment;
	
		
		// Pending Amount
		$strPendingAmount = $rowinvoice["PendingAmount"];
		if($strPendingAmount=="")
		{
			$strPendingAmount ="0.00";
		}
		else
		{
			$strPendingAmount = $strPendingAmount;
		}
		$strPendingAmountTotal += $strPendingAmount;
		
		
		// Card Paid

		$strCash = $rowinvoice["CashAmount"];
		if($strCash=="")
		{
			$strCash ="0.00";
		}
		else
		{
			$strCash = $strCash;
		}
		$strTotalCash += $strCash;
		
		
		
		// Cash paid

		$strCard = $rowinvoice["CardAmount"];
		if($strCard=="")
		{
			$strCard ="0.00";
		}
		else
		{
			$strCard = $strCard;
		}
		$strTotalCard += $strCard;
		
?>
													<tbody>
														<tr>
															<td><?=$strDate?></td>
															<td><?=$strInvoiceID?></td>
															<td><?=$strCustomerFullName?></td>
															<td>
																<?php
																	foreach($strServices as $Services)
																	{
																		$sqlServiceName = "select ServiceName from tblServices where ServiceID ='$Services'";
																		$RSSN = $DB->query($sqlServiceName);
																		if ($RSSN->num_rows > 0) 
																		{
																			while($rowSN = $RSSN->fetch_assoc())
																			{
																				$ServiceName = $rowSN["ServiceName"];
																				echo "$ServiceName <br>";
																			}
																		}
																		else
																		{
																			
																		}		
																	}
																?>
															</td>
															<td class="numeric">
																<?php
																	$ServiceAmountBasicTotal = "";
																	foreach($strServicesAmount as $Amount)
																	{
																		echo "Rs. $Amount <br>";
																		$ServiceAmountBasicTotal += $Amount;
																	}
																	$TotalBasics += $ServiceAmountBasicTotal;
																?>
															</td>
															<td class="numeric">Rs <?=$ServiceAmountBasicTotal?></td>
															<td class="numeric">Rs. <?=str_replace("-", " ", $TotalOAmount)?></td>
															<td class="numeric">Rs. <?=$TotalMAmount?></td>
															<td class="numeric">Rs. <?=$strGVPurchaseID?></td>
															<td class="numeric">Rs. <?=$strGVRedeemID?></td>
															<td class="numeric">
																<?php
																	foreach($strChargeName as $ChargeName)
																	{
																		echo "$ChargeName  &nbsp;&nbsp;&nbsp; | ";
																	}
																	
																	echo "<br>";
																	
																	$tC = "";
																	foreach($strChargeAmount as $ChargeAmount)
																	{
																		echo str_replace("+", " ", $ChargeAmount)." &nbsp;&nbsp;&nbsp; | ";
																		$tC += $ChargeAmount;
																	}
																	$TotalChargeAmount += $tC;

																?>
															</td>
															<td class="numeric">Rs. <?=$strTotal?></td>
															<td class="numeric">Rs. <?=$strCash?></td>
															<td class="numeric">Rs. <?=$strCard?></td>
															<td class="numeric">Rs. <?=$strPendingAmount?></td>
															
														</tr>
													</tbody>
<?php	
	}
?>	
													<tbody>
														<tr>
															<td colspan="5"><center><b>Total No of invoice(s) : <?=$counter?></b><center></td>
															<td class="numeric"><b>Rs. <?=$TotalBasics?>/-</b></td>
															<td class="numeric"><b>Rs. <?=str_replace("-", " ", $strFinalTotalOffer)?>/-</b></td>
															<td class="numeric"><b>Rs. <?=$strFinalTotalDiscount?>/-</b></td>
															<td class="numeric"><b>Rs. <?=$TotalGVPurchased?>/-</b></td>
															<td class="numeric"><b>Rs. <?=$TotalGVRedeemed?>/-</b></td>

															<td class="numeric"><b>Rs. <?=$TotalChargeAmount?>/-</b></td>
															<td class="numeric"><b>Rs. <?=$strTotalofTotal?>/-</b></td>
															<td class="numeric"><b>Rs. <?=$strTotalCash?>/-</b></td>
															<td class="numeric"><b>Rs. <?=$strTotalCard?>/-</b></td>
															<td class="numeric"><b>Rs. <?=$strPendingAmountTotal?>/-</b></td>
														</tr>
													</tbody>

<?php	
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
															<td></td>
															<td></td>
															<td>No Data Found</td>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
														</tr>
													</tbody>

<?php
}
$DB->close();
?>												

												</table>
											</div>
											

										</div>
										
										
									</div>
								</div>
<?php
								}
							?>								
								</div>
						</div>
                    </div>

            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>