<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Sales Report | Nailspa";
	$strDisplayTitle = "Sales Report Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportSale.php";
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
			$sqlTempfrom5 = " and Date(tblCustomers.RegDate)>='".$getfrom."'";
			$sqlTempfrom6 = " and Date(tblCustomers.RegDate)<'".$getfrom."'";
			$sqlTempfrom7 = " and Date(tblAppointments.AppointmentDate)>='".$getfrom."'";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<='".$getto."'";
			$sqlTempto1 = " and Date(tblAppointmentMembershipDiscount.DateTimeStamp)<='".$getto."'";
			$sqlTempto2 = " and Date(tblGiftVouchers.RedempedDateTime)<='".$getto."'";
			$sqlTempto3 = " and Date(tblPendingPayments.DateTimeStamp)<='".$getto."'";
			$sqlTempto4 = " and Date(tblGiftVouchers.Date)<='".$getto."'";
			$sqlTempto5 = " and Date(tblCustomers.RegDate)<='".$getto."'";
			$sqlTempto7 = " and Date(tblAppointments.AppointmentDate)<='".$getto."'";
			
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
	<script>
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
									
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
											
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
														<div class="form-group">
														<label class="col-sm-4 control-label">Select Percentage</label>
														<div class="col-sm-4">
														<?php 
														$per=$_GET["per"];
														?>
															<select name="per" class="form-control">
																<option value="0" <?php if($per=='0'){ ?> selected <?php } ?>>Without Percentage</option>
															    <option value="1" <?php if($per=='1'){ ?> selected <?php } ?>>Percentage</option>
															</select>
														</div>
													</div>
													
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportSale.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
															<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
															
														<!--<a class="btn btn-border btn-alt border-primary font-primary" href="ExcelExportData.php?from=<?=$getfrom?>&to=<?=$getto?>" title="Excel format 2016"><span>Export To Excel</span><div class="ripple-wrapper"></div></a>
														-->

													</div>
												</form>
												
												<br>
											
												<?php
													if($_GET["toandfrom"]!="")
													{
														$storr=$_GET["Store"];
													if($storr=='0')
													{
														$storrrp='All';
													}
													else{
													$stpp=select("StoreName","tblStores","StoreID='".$storr."'");
				                                   $StoreName=$stpp[0]['StoreName'];
														$storrrp=$StoreName;
													}
														
												?>
													<div id="printdata">
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store Filter selected : <?=$storrrp?> </h3>
														<?
															// echo $getfrom."<br>";
															// echo $storrrp."<br>"
														?>
														<br>
<?php
$DB = Connect();
$counter = 0;
$per=$_GET["per"];
		
?>
		<div class="panel">
			<div class="panel-body">
				
				<div class="example-box-wrapper">
					<div class="scroll-columns">
					

					
						<table class="table table-bordered table-striped table-condensed cf" width="100%">
						                                   <thead class="cf">
														 
																<tr>
																	<th><center>Sr</center></th>
																	
																	<th class="numeric"><center>Day & Date</center></th>
																	<th><center>Store</center></th>
																	<th class="numeric"><center>Service Sale</center></th>
																	<th class="numeric"><center>Product Sale</center></th>
																	<th class="numeric"><center>Discount Given</center></th>
																	<?php
																	if($per!='0')
																	{
																		?>
																<th class="numeric" id="percol" ><center>Discount %</center></th>
																		<?php
																	}
																	?>
																	<th class="numeric"><center>Total Sale</center></th>
																	
																	<th class="numeric"><center>Free Service Count</center></th>
																	
																	<th class="numeric"><center>Customer Count</center></th>
																	<th class="numeric"><center>New Client Count</center></th>
																	<?php
																	if($per!='0')
																	{
																		?>
																		
																		<th class="numeric" id="percol" ><center>New Client %</center></th>
																		<?php
																	}
																	?>
																	
																	<th class="numeric"><center>Existing Client Count</center></th>
																	<?php
																	if($per!='0')
																	{
																		?>
																		
																	<th class="numeric" id="percoll" ><center>Existing Client %</center></th>
																	<?php
																	}
																	?>
																	
																</tr>
															 
																
															</thead>
							                              
															<tbody>
							
<?php
$storr=$_GET["Store"];

if(!empty($storr))
{
	$sqlservice = "SELECT sum(tblAppointmentsDetailsInvoice.qty * tblAppointmentsDetailsInvoice.ServiceAmount) as sumservice,tblAppointments.StoreID, tblInvoiceDetails.OfferDiscountDateTime from tblAppointmentsDetailsInvoice left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='".$storr."' and tblAppointments.Status='2' and tblAppointments.IsDeleted!='1' and tblAppointments.FreeService!='1' $sqlTempfrom $sqlTempto";

		$RSservice = $DB->query($sqlservice);
		if ($RSservice->num_rows > 0) 
		{
			$counterservice = 0;

			while($rowservice = $RSservice->fetch_assoc())
			{
				$toatlseramt="";
				$counterservice ++;
				$sumservice = $rowservice["sumservice"];
				// $FreeServicescount = $rowservice["FreeService"];
			
				$OfferDiscountDateTime = $rowservice["OfferDiscountDateTime"];
			   
				$DateOfAttendanceT = FormatDateTime($OfferDiscountDateTime);
				$DateTime = FormatDateTime($getfrom);
				$DateTime1 = FormatDateTime($getto);
				
				// $date = '15-12-2016';
			$StartOfDay = date('D', strtotime($getfrom));
			// echo $nameOfDay;
			$EndOfDay = date('D', strtotime($getto));
			// echo $EndOfDay;
				
				// echo $DateTime."<br>";
				$sq=select("distinct(tblAppointments.AppointmentID)","tblAppointmentsDetailsInvoice left join tblAppointments 
 on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='".$storr."' and tblAppointments
.Status='2' $sqlTempfrom $sqlTempto");
			// echo $sq;

$SelectFreeService="Select count(FreeService) as FreeService from tblAppointments where FreeService='1' and StoreID='$storr' $sqlTempfrom7 $sqlTempto7 ";
// echo $SelectFreeService."<br>";
$RSFreeSer = $DB->query($SelectFreeService);
	if ($RSFreeSer->num_rows > 0) 
	{
		while($rowFreeSer = $RSFreeSer->fetch_assoc())
		{
			$FreeService = $rowFreeSer["FreeService"];
		}
	}
	// echo $FreeService."<br>";

                foreach($sq as $vq)
				{
					$app[]=$vq['AppointmentID'];
				}
               for($t=0;$t<count($app);$t++)
			   {
				   		$sepqtew=select("*","tblGiftVouchers","Status='1' and RedempedBy='".$app[$t]."' $sqlTempfrom2 $sqlTempto2");
				
				        $gAmount=$sepqtew[0]['Amount'];
						$sepqtp=select("sum(OfferAmount) as offamt,sum(MembershipAmount) as memamt","tblAppointmentMembershipDiscount","AppointmentID='".$app[$t]."' $sqlTempfrom1 $sqlTempto1");
						$offamt=$sepqtp[0]['offamt'];
			            $memamt=$sepqtp[0]['memamt'];
					    $discountgiven=$discountgiven+$gAmount+$memamt+$offamt;
						$sqlservicetyp=select("count(CustomerID)","tblAppointments","AppointmentID='".$app[$t]."'");
				        $cntcust=$sqlservicetyp[0]['count(CustomerID)'];
				        $totalcust=$totalcust+$cntcust;
			        	$sqlservicetyp="select count(tblAppointments.CustomerID) as newcust from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID where tblAppointments.StoreID='".$storr."' $sqlTempfrom5 $sqlTempto5";
						
						// echo $sqlservicetyp."<br>";
			            $RSservice2 = $DB->query($sqlservicetyp);
						if ($RSservice2->num_rows > 0) 
						{


						while($rowservice2 = $RSservice2->fetch_assoc())
						{
						$newcntcust = $rowservice2["newcust"];
						}
					    }
	
					    $sqlservicetypp="select count(tblAppointments.CustomerID) as extcust from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID where tblAppointments.StoreID='".$storr."' $sqlTempfrom6";
			            $RSservice3 = $DB->query($sqlservicetypp);
						if ($RSservice3->num_rows > 0) 
						{
							while($rowservice3 = $RSservice3->fetch_assoc())
							{
								 $extcust = $rowservice3["extcust"];
							}
						}
				
						// $sqlservicety=select("count(FreeService) as FreeService","tblAppointments","AppointmentID='".$app[$t]."' and FreeService='1' $sqlTempfrom7 $sqlTempto7 ");
						// $cfree=$sqlservicety[0]['FreeService'];
						// $cfree=$sqlservicety[0]['FreeService'];
						
						// $tcfree +=$cfree;
				        // $totalfree=$totalfree+$cntcust;

						// $Selectcountfreeservices="Select ";
						
	                    $sqlservice1 = "SELECT tblInvoiceDetails.RoundTotal from tblInvoiceDetails where tblInvoiceDetails.AppointmentId='".$app[$t]."' $sqlTempfrom $sqlTempto";

	                    $RSservice1 = $DB->query($sqlservice1);
						if ($RSservice1->num_rows > 0) 
						{
							

							while($rowservice1 = $RSservice1->fetch_assoc())
							{

						 $RoundTotal = $rowservice1["RoundTotal"];
							if($RoundTotal =="")
							{
								$RoundTotal ="0.00";
							}
							else
							{
							
								$RoundTotal = $RoundTotal;
								
							}
							$TotalRoundTotal += $RoundTotal;
									
						   }
					
						}
			   }
			   
			
						if($sumservice =="")
						{
							$sumservice ="0.00";
						}
						else
						{
						
							$sumservice = $sumservice;
							
						}
						$Totalsumservice += $sumservice;
						if($discountgiven =="")
						{
							$discountgiven ="0.00";
						}
						else
						{
						
							$discountgiven = $discountgiven;
							
						}
			       $Totaldiscountgiven += $discountgiven;
			 
			   
						$sep=select("*","tblStores","StoreID='".$storr."'");
						$storename=$sep[0]['StoreName'];
						if($TotalRoundTotal =="")
						{
							$TotalRoundTotal ="0.00";
						}
						else
						{
						
							$TotalRoundTotal = $TotalRoundTotal;
							
						}
						$TotalTotalRoundTotal += $TotalRoundTotal;
						// echo $totalcust."&nbsp".$newcntcust."<br>";
$existing=$totalcust-$newcntcust;
// echo $totalcust."&nbsp".$newcntcust."=".$existing."<br>";
// echo "<br>";
// echo "<br>";
                $newclientper=($newcntcust/$totalcust)*100;
               $existingclientper=($existing/$totalcust)*100;
				if($existing =="")
				{
					$existing ="0.00";
				}
				else
				{
				
					$existing = $existing;
					
				}
				$existing1 += $existing;
				
				if($totalcust =="")
				{
					$totalcust ="0.00";
				}
				else
				{
				
					$totalcust = $totalcust;
					
				}
				$totalcust1 += $totalcust;
				if($newcntcust =="")
				{
					$newcntcust ="0.00";
				}
				else
				{
				
					$newcntcust = $newcntcust;
					
				}
				$newcntcust1 += $newcntcust;
				if($newclientper =="")
				{
					$newclientper ="0.00";
				}
				else
				{
				
					$newclientper = $newclientper;
					
				}
				$newclientper1 += $newclientper;
				
				if($existingclientper =="")
				{
					$existingclientper ="0.00";
				}
				else
				{
				
					$existingclientper = $existingclientper;
					
				}
				$existingclientper1 += $existingclientper;
				if($FreeService =="")
				{
					$FreeService ="0.00";
				}
				else
				{
				
					$FreeService = $FreeService;
					
				}
				$FreeService1 += $FreeService;
      $discper=($discountgiven/$sumservice)*100;
	  if($discper =="")
				{
					$discper ="0.00";
				}
				else
				{
				
					$discper = $discper;
					
				}
				$discper1 += $discper;
	?>
		                    <tr id="my_data_tr_<?=$counterservice?>">
								<td><center><?=$counterservice?></center></td>
									
									<td class="numeric"><center><?=$StartOfDay?> <?=$DateTime?> to<br> <?=$EndOfDay?> <?=$DateTime1?></center></td>
									<td><center><?=$storename?></center></td>
									<td class="numeric"><center><?=$sumservice?></center></td>
									<td class="numeric"><center>-</center></td>
									
									<td class="numeric"><center><?=$discountgiven?></center></td>
									 <?php
																if($per!='0')
																	{
																	?>
										<td class="numeric" id="percol2" ><center><?=round($discper,2)?></center></td>
																	<?php
																	}
																	?>
									<td class="numeric"><center><?=$TotalRoundTotal?></center></td>
									<!--<td class="numeric"><center><?//=$tcfree?></center></td>-->
									<td class="numeric"><center><?=$FreeService?></center></td>
									
									<td class="numeric"><center><?=$totalcust?></center></td>
									<td class="numeric"><center><?=$newcntcust?></center></td>
									                              <?php
																if($per!='0')
																	{
																	?>
										<td class="numeric" id="percol2" ><center><?=round($newclientper,2)?></center></td>
																	<?php
																	}
																	?>
								
									
									<td class="numeric"><center><?=$existing?></center></td>
									<?php
																if($per!='0')
																	{
																	?>
										 <td class="numeric" id="percol21" ><center><?=round($existingclientper,2)?></center></td>
																	<?php
																	}
																	?>
							     
								
							</tr>
									</tbody>
								                	
	<?php



			}
			$sumservice="";
			$discountgiven="";
			$toatlseramt="";
			$cfree="";
			$tcfree="";
			$TotalRoundTotal="";
			$totalcust="";
			$newcntcust="";
			$extcust="";
			unset($app);
			unset($serviceamts);
			
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
									<td></td>
									<td></td>
									
								
								</tr>
							
							
</tbody>
<?php		
		}
	}
	else
	{
		
	$DB = Connect();
	
	// $SelectFreeService="Select count(FreeService) as FreeService from tblAppointments where FreeService='1'$sqlTempfrom7 $sqlTempto7 ";
// echo $SelectFreeService."<br>";
// $RSFreeSer = $DB->query($SelectFreeService);
	// if ($RSFreeSer->num_rows > 0) 
	// {
		// while($rowFreeSer = $RSFreeSer->fetch_assoc())
		// {
			// $FreeService = $rowFreeSer["FreeService"];
		// }
	// }
	// echo $FreeService."<br>";
	
	$count=0;
	$stpp=select("*","tblStores","StoreID!='0'");
	$counterservice = 0;
	foreach($stpp as $vapt)
	{
		$counterservice ++;
		$sqlservice = "SELECT sum(tblAppointmentsDetailsInvoice.qty * tblAppointmentsDetailsInvoice.ServiceAmount) as sumservice,Count(tblAppointments.FreeService) as FreeService,tblAppointments.StoreID,tblInvoiceDetails.OfferDiscountDateTime from tblAppointmentsDetailsInvoice left join tblAppointments 
 on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='".$vapt['StoreID']."' and tblAppointments
.Status='2' and tblAppointments.IsDeleted!='1' and tblAppointments.FreeService!='1' $sqlTempfrom $sqlTempto";
	
	$DateTime = FormatDateTime($getfrom);
				$DateTime1 = FormatDateTime($getto);
				
				$StartOfDay = date('D', strtotime($getfrom));
			// echo $nameOfDay;
			$EndOfDay = date('D', strtotime($getto));
			// echo $EndOfDay;
		$RSservice = $DB->query($sqlservice);
		if ($RSservice->num_rows > 0) 
		{
			

			while($rowservice = $RSservice->fetch_assoc())
			{
				$toatlseramt="";
			
				$sumservice = $rowservice["sumservice"];
				// $FreeService = $rowservice["FreeService"];
			// echo $FreeService."<br>";
				
			
				$OfferDiscountDateTime = $rowservice["OfferDiscountDateTime"];
			   
				$DateOfAttendanceT = FormatDateTime($OfferDiscountDateTime);
			
		
				$sq=select("distinct(tblAppointments.AppointmentID)","tblAppointmentsDetailsInvoice left join tblAppointments 
 on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='".$vapt['StoreID']."' and tblAppointments
.Status='2' $sqlTempfrom $sqlTempto"); 

			$selectFreeServices="Select count(FreeService) as FreeService from tblAppointments where FreeService='1' and StoreID='".$vapt['StoreID']."' $sqlTempfrom7 $sqlTempto7";
			// echo $selectFreeServices."<br>";
			$RSFreeSer = $DB->query($selectFreeServices);
			if ($RSFreeSer->num_rows > 0) 
			{
				while($rowFreeSer = $RSFreeSer->fetch_assoc())
				{
					 $FreeService = $rowFreeSer["FreeService"];
				}
			}

			foreach($sq as $vq)
			{
				$app[]=$vq['AppointmentID'];
			}
				for($t=0;$t<count($app);$t++)
				{
				   		$sepqtew=select("*","tblGiftVouchers","Status='1' and RedempedBy='".$app[$t]."' $sqlTempfrom2 $sqlTempto2");
				        $gAmount=$sepqtew[0]['Amount'];
						$sepqtp=select("sum(OfferAmount) as offamt,sum(MembershipAmount) as memamt","tblAppointmentMembershipDiscount","AppointmentID='".$app[$t]."' $sqlTempfrom1 $sqlTempto1");
						$offamt=$sepqtp[0]['offamt'];
						$memamt=$sepqtp[0]['memamt'];
					    $discountgiven=$discountgiven+$gAmount+$memamt+$offamt;
						$sqlservicetyp=select("count(CustomerID)","tblAppointments","AppointmentID='".$app[$t]."'");
						$cntcust=$sqlservicetyp[0]['count(CustomerID)'];
						$totalcust=$totalcust+$cntcust;
				        $sqlservicetyp="select count(tblAppointments.CustomerID) as newcust from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID where tblAppointments.StoreID='".$vapt['StoreID']."' $sqlTempfrom5 $sqlTempto5";
			
				        $RSservice2 = $DB->query($sqlservicetyp);
						if ($RSservice2->num_rows > 0) 
						{
						

							while($rowservice2 = $RSservice2->fetch_assoc())
							{
								 $newcntcust = $rowservice2["newcust"];
							}
						}
		
					$sqlservicetypp="select count(tblAppointments.CustomerID) as extcust from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID where tblAppointments.StoreID='".$vapt['StoreID']."' $sqlTempfrom6";
			
				   $RSservice3 = $DB->query($sqlservicetypp);
					if ($RSservice3->num_rows > 0) 
					{
						

						while($rowservice3 = $RSservice3->fetch_assoc())
						{
							 $extcust = $rowservice3["extcust"];
						}
					}
				
						$sqlservicety=select("count(FreeService)","tblAppointments","AppointmentID='".$app[$t]."' and FreeService='1'");
				        $cfree=$sqlservicety[0]['count(FreeService)'];
				        $tcfree +=$cfree;
				        $totalfree=$totalfree+$cntcust;
						 $sqlservice1 = "SELECT tblInvoiceDetails.RoundTotal from tblInvoiceDetails where tblInvoiceDetails.AppointmentId='".$app[$t]."' $sqlTempfrom $sqlTempto";
						 


					$RSservice1 = $DB->query($sqlservice1);
						if ($RSservice1->num_rows > 0) 
						{
							

							while($rowservice1 = $RSservice1->fetch_assoc())
							{

						 $RoundTotal = $rowservice1["RoundTotal"];
							if($RoundTotal =="")
							{
								$RoundTotal ="0.00";
							}
							else
							{
							
								$RoundTotal = $RoundTotal;
								
							}
							$TotalRoundTotal += $RoundTotal;
									
						}
					
						}
			   }
		
			if($sumservice =="")
			{
				$sumservice ="0.00";
			}
			else
			{
			
				$sumservice = $sumservice;
				
			}
			$Totalsumservice += $sumservice;
			if($discountgiven =="")
			{
				$discountgiven ="0.00";
			}
			else
			{
			
				$discountgiven = $discountgiven;
				
			}
			$Totaldiscountgiven += $discountgiven;
			 
			   
	            $sep=select("*","tblStores","StoreID='".$vapt['StoreID']."'");
		        $storename=$sep[0]['StoreName'];
			if($TotalRoundTotal =="")
			{
				$TotalRoundTotal ="0.00";
			}
			else
			{
			
				$TotalRoundTotal = $TotalRoundTotal;
				
			}
			$TotalTotalRoundTotal += $TotalRoundTotal;
	
              
             
// echo $totalcust."&nbsp".$newcntcust."<br>";
$existing=$totalcust-$newcntcust;
// echo $totalcust."&nbsp".$newcntcust."=".$existing."<br>";
// echo "<br>";
// echo "<br>";
                 $newclientper=($newcntcust/$totalcust)*100;
               $existingclientper=($existing/$totalcust)*100;
				if($existing =="")
				{
					$existing ="0.00";
				}
				else
				{
				
					$existing = $existing;
					
				}
				$existing1 += $existing;
				
				if($totalcust =="")
				{
					$totalcust ="0.00";
				}
				else
				{
				
					$totalcust = $totalcust;
					
				}
				$totalcust1 += $totalcust;
				if($newcntcust =="")
				{
					$newcntcust ="0.00";
				}
				else
				{
				
					$newcntcust = $newcntcust;
					
				}
				$newcntcust1 += $newcntcust;
				if($FreeService =="")
				{
					$FreeService ="0.00";
				}
				else
				{
				
					$FreeService = $FreeService;
					
				}
				$FreeService1 += $FreeService;

   $discper=($discountgiven/$sumservice)*100;
	  if($discper =="")
				{
					$discper ="0.00";
				}
				else
				{
				
					$discper = $discper;
					
				}
				$discper1 += $discper;
			if($newclientper =="")
				{
					$newclientper ="0.00";
				}
				else
				{
				
					$newclientper = $newclientper;
					
				}
				$newclientper1 += $newclientper;
				
				if($existingclientper =="")
				{
					$existingclientper ="0.00";
				}
				else
				{
				
					$existingclientper = $existingclientper;
					
				}
				$existingclientper1 += $existingclientper;
	?>
		<tr id="my_data_tr_<?=$counterservice?>">
									
									<td><center><?=$counterservice?></center></td>
									<td><center><?=$StartOfDay?> <?=$DateTime?> to<br> <?=$EndOfDay?> <?=$DateTime1?></center></td>
									<td><center><?=$storename?></center></td>
									<td class="numeric"><center><?=$sumservice?></center></td>
									<td class="numeric"><center>-</center></td>
									
									<td class="numeric"><center><?=$discountgiven?></center></td>
									 <?php
																if($per!='0')
																	{
																	?>
										<td class="numeric" id="percol2" ><center><?=round($discper,2)?></center></td>
																	<?php
																	}
																	?>
									<td class="numeric"><center><?=$TotalRoundTotal?></center></td>
									<td class="numeric"><center><?=$FreeService?></center></td>
									
									<td class="numeric"><center><?=$totalcust?></center></td>
									<td class="numeric"><center><?=$newcntcust?></center></td>
									   <?php
																if($per!='0')
																	{
																	?>
										<td class="numeric" id="percol2" ><center><?=round($newclientper,2)?></center></td>
																	<?php
																	}
																	?>
								
									
									<td class="numeric"><center><?=$existing?></center></td>
							<?php
																if($per!='0')
																	{
																	?>
										 <td class="numeric" id="percol21" ><center><?=round($existingclientper,2)?></center></td>
																	<?php
																	}
																	?>
							     
									
									</tbody>
								                	
	<?php



			}
			$sumservice="";
			$discountgiven="";
			$toatlseramt="";
			$cfree="";
			$tcfree="";
			$TotalRoundTotal="";
	     	$totalcust="";
			$newcntcust="";
			$extcust="";
			
			unset($app);
			
			unset($serviceamts);
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
									<td>No Data Found</td>
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
	}
	}
													

?>							
<?php
$discper1=round((($Totaldiscountgiven/$Totalsumservice)*100),2);

$newclientper1=round((($newcntcust1/$totalcust1)*100),2);
$existingclientper1=round((($existing1/$totalcust1)*100),2);
?>
					
													<tbody>
														<tr>
															
														    <td class="numeric"></td>
														    <td class="numeric" colspan="2"><b>Total Amounts(s)</b></td>
															
															<td class="numeric"><b>Rs. <?=$Totalsumservice?> /-</b></td>
															<td class="numeric"></td>
															<td class="numeric"><center><b>Rs. <?=$Totaldiscountgiven?>/-</b></center></td>
															<?php
																if($per!='0')
																	{
																	?>
															<td class="numeric" id="percol3" ><center><b><?=$discper1?></b></center></td>
															<?php
																	}
																	?>
															<td class="numeric"><center><b>Rs. <?=$TotalTotalRoundTotal?>/-</b></center></td>
															<td class="numeric"><center><b><?=$FreeService1?></b></center></td>
															
															<td class="numeric"><center><b><?=$totalcust1?></b></center></td>
															<td class="numeric"><center><b><?=$newcntcust1?></b></center></td>
															<?php
																if($per!='0')
																	{
																	?>
															<td class="numeric" id="percol3" ><center><b><?=$newclientper1?></b></center></td>
															<?php
																	}
																	?>
															<td class="numeric"><center><b><?=$existing1?></b></center></td>
															<?php
																if($per!='0')
																	{
																	?>
															<td class="numeric" id="percol31" ><center><b><?=$existingclientper1?></b></center></td>
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
$TotalRoundTotal="";
			$TotalTotalRoundTotal="";
			$existing1="";
			$totalcust1="";
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