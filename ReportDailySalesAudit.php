<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Report Daily Audit Sales | Nailspa";
	$strDisplayTitle = "Report Daily Audit Sales Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportDailySalesAudit.php";
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
			$sqlTempfrom = " and Date(tblInvoiceDetails.OfferDiscountDateTime)>='".$getfrom."'";
			$sqlTempfrom1 = " and Date(tblAppointmentMembershipDiscount.DateTimeStamp)>='".$getfrom."'";
			$sqlTempfrom2 = " and Date(tblGiftVouchers.RedempedDateTime)>='".$getfrom."'";
			$sqlTempfrom3 = " and Date(tblPendingPayments.DateTimeStamp)>='".$getfrom."'";
			$sqlTempfrom4 = " and Date(tblGiftVouchers.Date)>='".$getfrom."'";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<='".$getto."'";
			$sqlTempto1 = " and Date(tblAppointmentMembershipDiscount.DateTimeStamp)<='".$getto."'";
			$sqlTempto2 = " and Date(tblGiftVouchers.RedempedDateTime)>='".$getto."'";
			$sqlTempto3 = " and Date(tblPendingPayments.DateTimeStamp)>='".$getto."'";
			$sqlTempto4 = " and Date(tblGiftVouchers.Date)>='".$getto."'";
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
<script>

		function printDiv(divName) 
		{
	$("#heading").show();
	    var divToPrint = document.getElementById("printdata");
		$("#main").removeAttr("style")
		
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
#di table
{
	border:none;
}
.maindata
{
	overflow-x: scroll;
}
</style>

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
												<h3 class="title-hero">List of Daily Sales</h3>
												
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
														<a class="btn btn-link" href="ReportDailySalesAudit.php">Clear All Filter</a>
															<?php
													$datedrom=$_GET["toandfrom"];
													if($datedrom!="")
													{
														   ?>
														<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
											
													
														<!--<a class="btn btn-border btn-alt border-primary font-primary" href="ExcelExportData.php?from=<?=$getfrom?>&to=<?=$getto?>" title="Excel format 2016"><span>Export To Excel</span><div class="ripple-wrapper"></div></a>
														-->
 <?php
													   }
														?>
													</div>
												</form>
												
												<div id="printdata">	
												<h2 class="title-hero" id="heading" style="display:none"><center>Report Daily Sales Audit</center></h2>
												<br>
												<?php
												$datedrom=$_GET["toandfrom"];
													if($datedrom!="" && !IsNull($_GET["Store"]))
													{
														$storrr=$_GET["Store"];
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
												
														<h3 >Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store Filter selected : <?=$storrrp?> </h3>
												
												<br>
				

				
<?php
$DB = Connect();

	$counter = 0;

		
?>
		<div class="panel">
		
			<div class="panel-body" id="main" class="maindata" style="overflow-x: scroll;">
				
				<div class="example-box-wrapper">
					<div class="scroll-columns">
					

					
						<table  class="table table-bordered table-striped table-condensed cf datadisplay">
						                                   <thead class="cf">
																<tr>
																<?php
																if($storrr=='0')
													            {
																?>
																	<th>Sr</th>
																	<th>Customer Name</th>
																	<th>Customer Email</th>
																	<th>Invoice No</th>
																	<th class="numeric">Service Sale</th>
																	<th class="numeric">Product Sale</th>
																	<th class="numeric">GV Sale</th>
																	<th class="numeric">GV Discount</th>
																	<th class="numeric">Package Sale</th>
																	<th class="numeric">Membership Sale</th>
																	<th class="numeric">Membership Discount</th>
																	<th class="numeric">Offer Discount</th>
																	<th class="numeric">Service Tax</th>
																	<th class="numeric">Invoice Amount</th>
																	<th class="numeric">Total Sale</th>
																	<th class="numeric">Current Pending</th>
																	<th class="numeric">Pending Received In Cash</th>
																	<th class="numeric">Pending Received In Card</th>
																	<th class="numeric">Card Amount</th>
																	<th class="numeric">Cash Amount</th>
																	<th>Check In Time</th>
																	<th>Check Out Time</th>
																	<th>Store</th>
																	<?php
																}
																else
																{
																	?>
																	<th>Sr</th>
																	<th>Customer Name</th>
																	<th>Customer Email</th>
																	<th>Invoice No</th>
																	<th class="numeric">Service Sale</th>
																	<th class="numeric">Product Sale</th>
																	<th class="numeric">GV Sale</th>
																	<th class="numeric">GV Discount</th>
																	<th class="numeric">Package Sale</th>
																	<th class="numeric">Membership Sale</th>
																	<th class="numeric">Membership Discount</th>
																	<th class="numeric">Offer Discount</th>
															  		<th class="numeric">Service Tax</th>
																	<th class="numeric">Invoice Amount</th>
																	<th class="numeric">Total Sale</th>
																	<th class="numeric">Current Pending</th>
																	<th class="numeric">Pending Received In Cash</th>
																	<th class="numeric">Pending Received In Card</th>
																	<th class="numeric">Card Amount</th>
																	<th class="numeric">Cash Amount</th>
																	<th>Check In Time</th>
																	<th>Check Out Time</th>
																	
																	<?php
																}
																	?>
																</tr>
															</thead>
							                              
															<tbody class="datadisplay">
							
<?php
$storr=$_GET["Store"];
$sepqtsTYU=select("*","tblAppointments","IsDeleted!='0'");
foreach($sepqtsTYU as $vaqp)
{
	$appp[]=$vaqp['AppointmentID'];
}
				$CustomerEmailID=$sepqts[0]['CustomerEmailID'];
if(!empty($storr))
{
	
	$sqlservice = "SELECT tblInvoiceDetails.CustomerFullName,tblInvoiceDetails.CustomerID,tblInvoiceDetails.ServiceAmt,tblInvoiceDetails.ServiceName,tblInvoiceDetails.RoundTotal,tblInvoiceDetails.CashAmount,tblInvoiceDetails.CardAmount,tblInvoiceDetails.Membership_Amount,tblAppointments.StoreID,tblInvoiceDetails.AppointmentId,tblAppointments.AppointmentCheckInTime,tblAppointments.AppointmentCheckOutTime,tblInvoiceDetails.GVPurchasedID,tblInvoiceDetails.PendingAmount,tblInvoiceDetails.Flag from tblInvoiceDetails left join tblAppointments 
 on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='".$storr."' and tblAppointments
.Status='2' $sqlTempfrom $sqlTempto";
// echo $sqlservice;
}
else
{
$sqlservice = "SELECT tblInvoiceDetails.AppointmentId, tblInvoiceDetails.CustomerFullName,tblInvoiceDetails.CustomerID,tblInvoiceDetails.ServiceAmt,tblInvoiceDetails.ServiceName,tblInvoiceDetails.RoundTotal,tblInvoiceDetails.CashAmount,tblInvoiceDetails.CardAmount,tblInvoiceDetails.Membership_Amount,tblAppointments.StoreID,tblInvoiceDetails.AppointmentId,tblAppointments.AppointmentCheckInTime,tblAppointments.AppointmentCheckOutTime,tblInvoiceDetails.GVPurchasedID,tblInvoiceDetails.PendingAmount,tblInvoiceDetails.Flag from tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblPendingPayments on tblInvoiceDetails.AppointmentId=tblPendingPayments.AppointmentID  where tblAppointments.StoreID!='0' and tblAppointments
.Status='2'  $sqlTempfrom $sqlTempto";
}

		

		
		$RSservice = $DB->query($sqlservice);
		if ($RSservice->num_rows > 0) 
		{
			$counterservice = 0;

			while($rowservice = $RSservice->fetch_assoc())
			{
				$toatlseramt="";
				
				$SaifAppointmentID = $rowservice["AppointmentId"];
				$getUID = EncodeQ($SaifAppointmentID);
				$CustomerFullName = $rowservice["CustomerFullName"];
				$RoundTotal = $rowservice["RoundTotal"];
			    $AppointmentId = $rowservice["AppointmentId"];
			    if(in_array("$AppointmentId",$appp))
				{
					
				}
				else
				{
				$counterservice ++;
				$ServiceAmt = $rowservice["ServiceAmt"];
				$ServiceName = $rowservice["ServiceName"];
				$CustomerID = $rowservice["CustomerID"];
				
				$Flag = $rowservice["Flag"];
				
				if($Flag=='CS')
				{
					$PendingAmountycs = $rowservice["PendingAmount"];
					$PendingAmountyc=0;
				}
				else
				{
					$PendingAmountyc = $rowservice["PendingAmount"];
					$PendingAmountycs=0;
				}
				
				$sepqts=select("*","tblCustomers","CustomerID='".$CustomerID."'");
				$CustomerEmailID=$sepqts[0]['CustomerEmailID'];
				$StoreID = $rowservice["StoreID"];
				
				$sepqto=select("*","tblInvoice","AppointmentID='".$AppointmentId."'");
				$invoice=$sepqto[0]['InvoiceID'];
				
				$sepqtpack=select("PackageID","tblInvoiceDetails","AppointmentId='".$AppointmentId."' and PackageIDFlag='P'");
				$PACKID=$sepqtpack[0]['PackageID'];
				
				$package=explode(",",$PACKID);
				
				$sepqt=select("*","tblPendingPayments","PendingStatus='2' and AppointmentID='".$AppointmentId."' $sqlTempfrom3 $sqlTempto3");
				$PendingAmount=$sepqt[0]['PendingAmount'];
			
				$sepqtQW=select("count(*)","tblPendingPayments","Status='1' and PendingStatus='2' and AppointmentID='".$AppointmentId."' $sqlTempfrom3 $sqlTempto3");
				$cnttt=$sepqtQW[0]['count(*)'];
				 if($cnttt>0)
				{
				$CashAmount = $rowservice["CashAmount"];
				$CardAmount = $rowservice["CardAmount"];	
			    if($CashAmount!="0.00")
				{
					$CashAmount=$RoundTotal-$PendingAmount;
				}
				elseif($CardAmount!="0.00")
				{
						$CardAmount =$RoundTotal-$PendingAmount;
				}
				
				}
				else
				{
					$CashAmount = $rowservice["CashAmount"];
					$CardAmount = $rowservice["CardAmount"];
				}
				
			        
				
	
				$Membership_Amount = $rowservice["Membership_Amount"];
				$memamtfirst = explode(",", $Membership_Amount);
                 	
					$memamtfirst=str_replace("+", "", $Membership_Amount);
					$memamtfirst=str_replace(".00", "", $memamtfirst);
					$memamtfirst=str_replace(".", "", $memamtfirst);

					$memamtfirst=str_replace(",", "", $memamtfirst);
			//	$memamtfirst=str_replace("+", "", $Membership_Amount);
				 if($memamtfirst=='')
						{
							$memamtfirst="0.00";
						}
				
				$Totalmemamtfirst += $memamtfirst;
						
						
			    $sepqtpt=select("sum(ChargeAmount) as sumcharge","tblAppointmentsChargesInvoice","AppointmentID='".$AppointmentId."'");
				// echo $sepqtpt;
				$tax=$sepqtpt[0]['sumcharge'];
				
			
				
				$OpenTime=$rowservice['AppointmentCheckInTime'];
			    $CloseTime=$rowservice['AppointmentCheckOutTime'];
				$sepqtp=select("sum(OfferAmount) as offamt,sum(MembershipAmount) as memamt","tblAppointmentMembershipDiscount","AppointmentID='".$AppointmentId."' $sqlTempfrom1 $sqlTempto1");
				$offamt=$sepqtp[0]['offamt'];
				$memamt=$sepqtp[0]['memamt'];
				
			        $GVPurchasedID = $rowservice["GVPurchasedID"];
					$sepqteww=select("*","tblGiftVouchers","GiftVoucherID='".$GVPurchasedID."' and AppointmentID='".$AppointmentId."' $sqlTempfrom4 $sqlTempto4");
				
				$gPurchaseAmountt=$sepqteww[0]['Amount'];
				
				$sepqtew=select("*","tblGiftVouchers","Status='1' and RedempedBy='".$AppointmentId."' $sqlTempfrom2 $sqlTempto2");
				
				
			$gAmount=$sepqtew[0]['Amount'];
			if($gAmount =="")
			{
				$gAmount ="0.00";
			}
			else
			{
			
				$gAmount = $gAmount;
				
			}
		
			$TotalgAmount += $gAmount;
				$saleamount=$RoundTotal-$gAmount;
				$saleamount=$saleamount+$PendingAmountyc;
				$saleamount=$saleamount+$PendingAmountycs;
			if($saleamount =="")
			{
				$saleamount ="0.00";
			}
			else
			{
			
				$saleamount = $saleamount;
				
			}
			$Totalsaleamount += $saleamount;
	if($gPurchaseAmountt =="")
			{
				$gPurchaseAmountt ="0.00";
			}
			else
			{
			
				$gPurchaseAmountt = $gPurchaseAmountt;
				
			}
			$TotalgPurchaseAmountt += $gPurchaseAmountt;
				if($OpenTime!='0000-00-00 00:00:00')
				 {
					 	 $LoginTimet=date('h:i:s', strtotime($OpenTime));
				 }
				 else
				 {
					 	 $LoginTimet="00:00:00";
				 }
			
			  if($CloseTime!='0000-00-00 00:00:00')
				 {
					 	 $LogoutTimet=date('h:i:s', strtotime($CloseTime));
				 }
				 else
				 {
					 	 $LogoutTimet="00:00:00";
				 }
				
			    $serviceamts = explode(",",$ServiceAmt);
				$ServiceNames = explode(",",$ServiceName);
				$sep=select("*","tblStores","StoreID='".$StoreID."'");
		        $storename=$sep[0]['StoreName'];
			  if($CashAmount=='')
			  {
				  $CashAmount="0.00";
			  }
			    if($CardAmount=='')
			  {
				  $CardAmount="0.00";
			  }
			  
				for($i=0;$i<count($serviceamts);$i++)
				{
					$toatlseramt +=$serviceamts[$i];
				}
				unset($serviceamts);
			    $serviceamts="";
				
					if($_SERVER['REMOTE_ADDR']=="111.119.219.70")
   {
       for($i=0;$i<count($ServiceNames);$i++)
				{
					//echo $ServiceNames[$i]."<br/>";
				}
				unset($ServiceNames);
			    $ServiceNames="";
   }
   else
   {
       
   }
				for($q=0;$q<count($package);$q++)
				{
					if($package[$q]!='')
					{
						$sepqtewpack=select("*","tblPackages","PackageID='".$package[$q]."'");
						$packprice=$sepqtewpack[0]['PackageNewPrice'];
				        $PackageNewPrice +=$packprice;
				
					
					}
				
				}
				unset($package);
			
				
				
			if($PackageNewPrice =="")
			{
				$PackageNewPrice ="0.00";
			}
			else
			{
			
				$PackageNewPrice = $PackageNewPrice;
				
			}
			$TotalPackageNewPrice += $PackageNewPrice;	
           
		   
		   
		  if($toatlseramt =="")
			{
				$toatlseramt ="0.00";
			}
			else
			{
			
				$toatlseramt = $toatlseramt;
				
			}
			$Totaltoatlseramt += $toatlseramt;
			
		if($offamt =="")
			{
				$offamt ="0.00";
			}
			else
			{
			
				$offamt = $offamt;
				
			}
			$Totaloffamt += $offamt;
			if($tax =="")
			{
				$tax ="0.00";
			}
			else
			{
			
				$tax = $tax;
				
			}
			$Totaltax += $tax;
		if($memamt =="")
			{
				$memamt ="0.00";
			}
			else
			{
			
				$memamt = $memamt;
				
			}
			$Totalmemamt += $memamt;
			if($PendingAmount =="")
			{
				$PendingAmount ="0.00";
			}
			else
			{
			
				$PendingAmount = $PendingAmount;
				
			}
			$TotalPendingAmount += $PendingAmount;
			
			
			if($PendingAmountyc =="")
			{
				$PendingAmountyc ="0.00";
			}
			else
			{
			
				$PendingAmountyc = $PendingAmountyc;
				
			}
			$TotalPendingAmountyc += $PendingAmountyc;
			if($PendingAmountycs =="")
			{
				$PendingAmountycs ="0.00";
			}
			else
			{
			
				$PendingAmountycs = $PendingAmountycs;
				
			}
			$TotalPendingAmountycs += $PendingAmountycs;
			if($CashAmount =="")
			{
				$CashAmount ="0.00";
			}
			else
			{
			
				$CashAmount = $CashAmount;
				
			}
			$TotalCashAmount += $CashAmount;
			
			if($CardAmount =="")
			{
				$CardAmount ="0.00";
			}
			else
			{
			
				$CardAmount = $CardAmount;
				
			}
			$TotalCardAmount += $CardAmount;
			
			if($RoundTotal =="")
			{
				$RoundTotal ="0.00";
			}
			else
			{
			
				$RoundTotal = $RoundTotal;
				
			}
			$TotalRoundTotal += $RoundTotal;
			

?>								<tr id="my_data_tr_<?=$counterservice?>">
									
						                                 <?php
																if($storrr=='0')
													            {
																?>
							
								<td><center><?=$counterservice?></center></td>
									<td><center><?=$CustomerFullName?></center></td>
									<td><center><?=$CustomerEmailID?></center></td>
									<td><center># <?=$invoice?></center></td>
									<td class="numeric"><center><?=$toatlseramt?></center></td>
									<td class="numeric"><center>-</center></td>
									
									<td class="numeric"><center><?=$gPurchaseAmountt?></center></td>
									<td class="numeric"><center><?=$gAmount?></center></td>
									<td class="numeric"><center><?=$PackageNewPrice?></center></td>
									
									<td class="numeric"><center><?=str_replace("+", "", $memamtfirst)?></center></td>
									<td class="numeric"><center><?=$memamt?></center></td>
									<td class="numeric"><center><?=$offamt?></center></td>
								  	<td class="numeric"><center><?=$tax?></center></td>
									<td class="numeric"><center><?=$RoundTotal?></center></td>
									<td class="numeric"><center><?=$saleamount?></center></td>
							
									
								
									<td class="numeric"><center><?=$PendingAmount?></center></td>
									<td class="numeric"><center><?=$PendingAmountycs?></center></td>
									<td class="numeric"><center><?=$PendingAmountyc?></center></td>
									<td class="numeric"><center><?=$CardAmount?></center></td>
									<td class="numeric"><center><?=$CashAmount?></center></td>
									<td><center><?=$LoginTimet?></center></td>
									<td><center><?=$LogoutTimet?></b></center></td>
									<td><center><?=$storename?></center></td>
									<?php
																}
																else
																{
																							?>
							
								<td><center><?=$counterservice?></center></td>
									<td><center><?=$CustomerFullName?></center></td>
									<td><center><?=$CustomerEmailID?></center></td>
									<td>
										<center>
											<?php
											if($_SERVER['REMOTE_ADDR']=="111.119.219.70")
											{
											?>
												<a id="status" class="btn btn-link" target='blank' href="PendingInvoicesForDisplay.php?uid=<?=$getUID;?>"># <?=$invoice?></a>
											<?php
											}
											else
											{
											?>
												# <?=$invoice?>
											<?php
											}
											?>
										</center>
									</td>
									<td class="numeric"><center><?=$toatlseramt?></center></td>
									<td class="numeric"><center>-</center></td>
									
									<td class="numeric"><center><?=$gPurchaseAmountt?></center></td>
									<td class="numeric"><center><?=$gAmount?></center></td>
									<td class="numeric"><center><?=$PackageNewPrice?></center></td>
									
									<td class="numeric"><center><?=str_replace("+", "", $memamtfirst)?></center></td>
									<td class="numeric"><center><?=$memamt?></center></td>
									<td class="numeric"><center><?=$offamt?></center></td>
								  	<td class="numeric"><center><?=$tax?></center></td>
									<td class="numeric"><center><?=$RoundTotal?></center></td>
										<td class="numeric"><center><?=$saleamount?></center></td>
							
								
									<td class="numeric"><center><?=$PendingAmount?></center></td>
									<td class="numeric"><center><?=$PendingAmountycs?></center></td>
									<td class="numeric"><center><?=$PendingAmountyc?></center></td>
									<td class="numeric"><center><?=$CardAmount?></center></td>
									<td class="numeric"><center><?=$CashAmount?></center></td>
									<td><center><?=$LoginTimet?></center></td>
									<td><center><?=$LogoutTimet?></b></center></td>
									
									<?php
																}
									?>
								</tr>
							
<?php
				}
		          $PackageNewPrice="";
			}
			unset($serviceamts);
			$toatlseramt="";
			 $PackageNewPrice="";
			
		}
		else
		{
?>
							
								<tr>
								                       <?php
																if($storrr=='0')
													            {
																?>
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
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<?php
																}
																else
																{
																								?>
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
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								    <td></td>
									<td></td>
									<td></td>
									<td></td>
									<?php
																}
									?>
								</tr>
							

<?php		
		}	
	
?>							
					</tbody>
											<tbody>
														<tr>
														 <?php
																if($storrr=='0')
													            {
																?>
															<td colspan="3"><b>Total Amounts(s)</b></td>
															 <td class="numeric"></td>
															
															 <td class="numeric"><center><b>Rs. <?=$Totaltoatlseramt?>/-</b></center></td>
															 <td class="numeric"></td>
															 
															 
															   <td class="numeric"><center><b>Rs. <?=$TotalgPurchaseAmountt?>/-</b></center></td>
															  <td class="numeric"><center><b>Rs. <?=$TotalgAmount?>/-</b></center></td>
															<td class="numeric"><center><b>Rs. <?=$TotalPackageNewPrice?></b></center></td>
															 
														    <td class="numeric"><center><b>Rs. <?=$Totalmemamtfirst?>/-</b></center></td>
														    <td class="numeric"><center><b>Rs. <?=$Totalmemamt?>/-</b></center></td>
														    <td class="numeric"><center><b>Rs. <?=$Totaloffamt?>/-</b></center></td>
														    <td class="numeric"><center><b>Rs. <?=$Totaltax?>/-</b></center></td>
															<td class="numeric"><center><b>Rs. <?=$TotalRoundTotal?>/-</b></center></td>
														    <td class="numeric"><center><b>Rs. <?=$Totalsaleamount?>/-</b></center></td>
															  
															<td class="numeric"><center><b>Rs. <?=$TotalPendingAmount?>/-</b></center></td>
															 <td class="numeric"><center><b>Rs. <?=$TotalPendingAmountycs?>/-</b></center></td>
															<td class="numeric"><center><b>Rs. <?=$TotalPendingAmountyc?>/-</b></center></td>
															  <td class="numeric"><center><b>Rs. <?=$TotalCardAmount?>/-</b></center></td>
															  <td class="numeric"><center><b>Rs. <?=$TotalCashAmount?>/-</b></center></td>
															  <td></td>
															  <td></td>
															  <td></td>
															  <td></td>
															 <?php
																}
																else
																{
																	?>
															<td colspan="2"><b>Total Amounts(s)</b></td>
															 <td class="numeric"></td>
															 <td class="numeric"></td>
															 <td class="numeric"><center><b>Rs. <?=$Totaltoatlseramt?>/-</b></center></td>
															 <td class="numeric"></td>
															 <td class="numeric"><center><b>Rs. <?=$TotalgPurchaseAmountt?>/-</b></center></td>
															  <td class="numeric"><center><b>Rs. <?=$TotalgAmount?>/-</b></center></td>
															 	<td class="numeric"><center><b>Rs. <?=$TotalPackageNewPrice?></b></center></td>
															 
															  <td class="numeric"><center><b>Rs. <?=$Totalmemamtfirst?>/-</b></center></td>
															 <td class="numeric"><center><b>Rs. <?=$Totalmemamt?>/-</b></center></td>
														      <td class="numeric"><center><b>Rs. <?=$Totaloffamt?>/-</b></center></td>
															    <td class="numeric"><center><b>Rs. <?=$Totaltax?>/-</b></center></td>
															  <td class="numeric"><center><b>Rs. <?=$TotalRoundTotal?>/-</b></center></td>
															   <td class="numeric"><center><b>Rs. <?=$Totalsaleamount?>/-</b></center></td>
															  
															  <td class="numeric"><center><b>Rs. <?=$TotalPendingAmount?>/-</b></center></td>
															  <td class="numeric"><center><b>Rs. <?=$TotalPendingAmountycs?>/-</b></center></td>
															<td class="numeric"><center><b>Rs. <?=$TotalPendingAmountyc?>/-</b></center></td>
															  <td class="numeric"><center><b>Rs. <?=$TotalCardAmount?>/-</b></center></td>
															  <td class="numeric"><center><b>Rs. <?=$TotalCashAmount?>/-</b></center></td>
															  <td></td>
															  <td></td>
															  <td></td>
															 <?php
																}
															 ?>
														</tr>
													</tbody>
						</table>
						
					</div>
				</div>
			</div>
		</div>
		</div>
		
<?php	
	

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