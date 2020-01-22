<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Report Membership | Nailspa";
	$strDisplayTitle = "Report Membership Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportMembership.php";
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
			$sqlTempfrom1 = " and Date(tblCustomerMemberShip.ExpireDate)>=Date('".$getfrom."')";
			$sqlTempfrom2 = " and tblAppointments.AppointmentDate>=Date('".$getfrom."')";
			$sqlTempfrom3 = " and tblCustomerMemberShip.StartDay>=Date('".$getfrom."')";
			$sqlTempfrom4 = " and Date(tblCustomers.RegDate)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$getto."')";
			$sqlTempto1 = " and Date(tblCustomerMemberShip.ExpireDate)<=Date('".$getto."')";
			$sqlTempto2 = " and tblAppointments.AppointmentDate<=Date('".$getto."')";
			$sqlTempto3 = " and tblCustomerMemberShip.StartDay<=Date('".$getto."')";
			$sqlTempto4 = " and Date(tblCustomers.RegDate)<=Date('".$getto."')";
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
												<h3 class="title-hero">Membership Details</h3>
												
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
														<a class="btn btn-link" href="ReportMembership.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
																	<?php
													$datedrom=$_GET["toandfrom"];
													if($datedrom!="")
													{
														   ?>
														 <button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
														<!--<a class="btn btn-border btn-alt border-primary font-primary" href="ExcelExportData.php?from=<?=$getfrom?>&to=<?=$getto?>" title="Excel format 2016"><span>Export To Excel</span><div class="ripple-wrapper"></div></a>
														-->
  <?php
													   }
														?>
													</div>
												</form>
											  <div id="printdata">	
												<h2 class="title-hero" id="heading" style="display:none"><center>Report Membership</center></h2>
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
$per=$_GET["per"];
	$counter = 0;
$storr=$_GET["Store"];
		
?>
		<div class="panel">
			<div class="panel-body">
				
				<div class="example-box-wrapper">
					<div class="scroll-columns">
					
						<table id="printdata" class="table table-bordered table-striped table-condensed cf" width="100%">
						                                 
															    <thead>
															  	<tr>
																	<th><center>Sr</center></th>
																	<th><center>New Members Count</center></th>
																	<th><center>New Members Amount</center></th>
																	<th><center>Renewal Count</center></th>
																	<th><center>Renewal Amount</th>
																	<th><center>Expired Members</center></th>
																	<th><center>Store</center></th>
																	<?php
																	if($per!='0')
																	{
																		?>
																<th style="text-align:center">Total Member </th>
																<?php
																	}
																	if($per!='0')
																	{
																		?>
																<th style="text-align:center">New Member %</th>
																<?php
																	}
																	if($per!='0')
																	{
																		?>
																<th style="text-align:center">Expired Member %</th>
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
	$sqlservice = "SELECT COUNT( tblCustomers.`CustomerID` ) as newcust FROM  tblCustomers LEFT JOIN tblAppointments ON tblCustomers.`CustomerID` = tblAppointments.CustomerID WHERE  tblAppointments.StoreID =  '".$storr."' AND tblAppointments.memberid !=  '0' $sqlTempfrom4 $sqlTempto4";

	
		$RSservice = $DB->query($sqlservice);
		if ($RSservice->num_rows > 0) 
		{
			$counterservice = 0;

			while($rowservice = $RSservice->fetch_assoc())
			{
				$toatlseramt="";
				$counterservice ++;
				$newcust = $rowservice["newcust"];
				
				$setmemamount123 = "SELECT tblInvoiceDetails.Membership_Amount FROM tblCustomerMemberShip LEFT JOIN tblAppointments ON tblCustomerMemberShip.CustomerID = tblAppointments.CustomerID and tblCustomerMemberShip.MembershipID=tblAppointments.memberid left join tblInvoiceDetails on tblInvoiceDetails.CustomerID=tblCustomerMemberShip.CustomerID WHERE tblCustomerMemberShip.Status =  '1' AND tblCustomerMemberShip.RenewStatus =  '0' AND tblAppointments.StoreID =  '".$storr."' AND tblAppointments.memberid !=  '0' $sqlTempfrom3 $sqlTempto3";
				//$setmemamount123 = "SELECT tblInvoiceDetails.Membership_Amount FROM tblCustomers LEFT JOIN tblAppointments ON tblCustomers.CustomerID = tblAppointments.CustomerID left join tblInvoiceDetails on tblInvoiceDetails.CustomerID=tblCustomers.CustomerID WHERE tblAppointments.StoreID =  '".$storr."' AND tblAppointments.memberid !=  '0' $sqlTempfrom4 $sqlTempto4 $sqlTempfrom $sqlTempto";
				$setmemamount = $DB->query($setmemamount123);
			
				if ($setmemamount->num_rows > 0) 
				{
					
					while($rowsetmemamount = $setmemamount->fetch_assoc())
					{
						//$Totalmemamtfirst="";
						
						 $Membership_Amount = $rowsetmemamount["Membership_Amount"];
						 $memamtfirst = explode(",", $Membership_Amount);
						
                         $memamtfirst=str_replace("+", "", $Membership_Amount);
					     $memamtfirst2=str_replace(".00", "", $memamtfirst);
						 $memamtfirst3=str_replace("+", "", $memamtfirst2);
						 $memamtfirst4=str_replace(",", "", $memamtfirst3);
						 $memamtfirst5=str_replace(".00", "", $memamtfirst4);
				
					 // $memamtfirst=str_replace(",", "", $Membership_Amount);
				     if($memamtfirst5=='')
						{
							$memamtfirst5="0.00";
						}
		
				
				$Totalmemamtfirst = $Totalmemamtfirst + $memamtfirst5;
					}
				}
					$setrenewmemcount = "SELECT count(tblCustomerMemberShip.RenewCount) as renewcnt FROM tblCustomerMemberShip LEFT JOIN tblAppointments ON tblCustomerMemberShip.CustomerID = tblAppointments.CustomerID and tblCustomerMemberShip.MembershipID=tblAppointments.memberid WHERE tblCustomerMemberShip.Status =  '1' AND tblAppointments.StoreID =  '".$storr."' AND tblAppointments.memberid !=  '0' and tblCustomerMemberShip.RenewStatus='1' $sqlTempfrom3 $sqlTempto3";
				
				
				$RSsetrenewmemcount = $DB->query($setrenewmemcount);
			   // echo $setrenewmemcount;
				if ($RSsetrenewmemcount->num_rows > 0) 
				{
					
					while($rowRSsetrenewmemcount = $RSsetrenewmemcount->fetch_assoc())
					{
						$toatlseramt="";
						
						$renewcnt = $rowRSsetrenewmemcount["renewcnt"];
					}
				}
				
				/* $setrenewmemcount=select("count(tblCustomerMemberShip.RenewCount) as renewcnt","tblCustomerMemberShip LEFT JOIN tblAppointments ON tblCustomerMemberShip.CustomerID = tblAppointments.CustomerID left join tblInvoiceDetails on tblInvoiceDetails.CustomerID=tblCustomerMemberShip.CustomerID","tblCustomerMemberShip.Status =  '1' AND tblAppointments.StoreID =  '".$storr."' AND tblAppointments.memberid !=  '0' and tblCustomerMemberShip.RenewStatus='1' $sqlTempfrom3 $sqlTempto3");
				
				$renewcnt=$setrenewmemcount[0]['renewcnt']; */
				$setrenewmemamount=select("sum(tblCustomerMemberShip.RenewAmount) as renewamt","tblCustomerMemberShip LEFT JOIN tblAppointments ON tblCustomerMemberShip.CustomerID = tblAppointments.CustomerID and tblCustomerMemberShip.MembershipID=tblAppointments.memberid","tblCustomerMemberShip.Status =  '1' AND tblAppointments.StoreID =  '".$storr."' AND tblAppointments.memberid !=  '0' and tblCustomerMemberShip.RenewStatus='1' $sqlTempfrom3 $sqlTempto3");
			
				$renewamount=$setrenewmemamount[0]['renewamt'];
				
				if($renewamount=='')
				{
					$renewamount=0;
				}
				$setreexpirememcnt = "SELECT count(tblCustomerMemberShip.ExpiryCount) as excnt FROM tblCustomerMemberShip LEFT JOIN tblAppointments ON tblCustomerMemberShip.CustomerID = tblAppointments.CustomerID and tblCustomerMemberShip.MembershipID=tblAppointments.memberid WHERE tblCustomerMemberShip.Status =  '1' AND tblAppointments.StoreID =  '".$storr."' AND tblAppointments.memberid !=  '0' and ExpiryCount not IN ('',  '0') $sqlTempfrom1 $sqlTempto1";
				
			
				$RSsetreexpirememcnt = $DB->query($setreexpirememcnt);
			
				if ($RSsetreexpirememcnt->num_rows > 0) 
				{
					
					while($rowRSsetreexpirememcnt = $RSsetreexpirememcnt->fetch_assoc())
					{
						$toatlseramt="";
						
						$excnt = $rowRSsetreexpirememcnt["excnt"];
					}
				}
				
				
				/* $setreexpirememcnt=select("count(tblCustomerMemberShip.ExpiryCount) as excnt","tblCustomerMemberShip LEFT JOIN tblAppointments ON tblCustomerMemberShip.CustomerID = tblAppointments.CustomerID","tblCustomerMemberShip.Status =  '1' AND tblAppointments.StoreID =  '".$storr."' AND tblAppointments.memberid !=  '0' and tblCustomerMemberShip.ExpiryCount!='0' or tblCustomerMemberShip.ExpiryCount!='' $sqlTempfrom1 $sqlTempto1");
				
				$expcnt=$setreexpirememcnt[0]['excnt']; */
				
				$sep=select("*","tblStores","StoreID='".$storr."'");
		        $storename=$sep[0]['StoreName'];
	
	               if($newcust =="")
			{
				$newcust ="0.00";
			}
			else
			{
			
				$newcust = $newcust;
				
			}
			$Totalnewcust += $newcust;
			   if($Totalmemamtfirst =="")
			{
				$Totalmemamtfirst ="0.00";
			}
			else
			{
			
				$Totalmemamtfirst = $Totalmemamtfirst;
				
			}
			$TotalTotalmemamtfirstt += $Totalmemamtfirst;
			if($renewamount =="")
			{
				$renewamount ="0.00";
			}
			else
			{
			
				$renewamount = $renewamount;
				
			}
			$Totalrenewamount += $renewamount;
			   if($renewcnt =="")
			{
				$renewcnt ="0.00";
			}
			else
			{
			
				$renewcnt = $renewcnt;
				
			}
			$Totalrenewcnt += $renewcnt;
			   if($excnt =="")
			{
				$excnt ="0.00";
			}
			else
			{
			
				$excnt = $excnt;
				
			}
			$Totalexcnt += $excnt;
		
			$totalcountt=$newcust+$renewcnt+$excnt;
			$newmemper=($newcust/$totalcountt)*100;
			$expper=($excnt/$totalcountt)*100;

?>							
									
						                             
							<tr id="my_data_tr_<?=$counterservice?>">
								<td><center><?=$counterservice?></center></td>
									<td><center><?=$newcust?></center></td>
									<td><center><?=$Totalmemamtfirst?></center></td>
									<td><center><?=$renewcnt?></center></td>
									<td><center><?=$renewamount?></center></td>
									<td><center><?=$excnt?></center></td>
							        <td><center><b><?=$storename?></b></center></td>
										                         <?php
																	if($per!='0')
																	{
																		?>
																	<td><center><b><?=round($totalcountt,2)?></b></center></td>	
																		<?php
																	}
																	
																	?>
																	<?php
																	if($per!='0')
																	{
																		?>
																	<td><center><b><?=round($newmemper,2)?></b></center></td>	
																		<?php
																	}
																	
																	?>
																		<?php
																	if($per!='0')
																	{
																		?>
																	<td><center><b><?=round($expper,2)?></b></center></td>	
																		<?php
																	}
																	
																	?>
								</tr>
															 
							
<?php
			}
			$sumrenew="";
			$Totalmemamtfirst="";
			
			
		}
		else
		{
?>
							
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
								</tr>
								
<?php		
		}
}
else
{
	$counterservice = 0;
	 $selp=select("*","tblStores","Status='0'");
	foreach($selp as $vat)
	{
			
		
			$sqlservice = "SELECT COUNT( tblCustomers.`CustomerID` ) as newcust FROM  tblCustomers LEFT JOIN tblAppointments ON tblCustomers.`CustomerID` = tblAppointments.CustomerID WHERE  tblAppointments.StoreID =  '".$vat['StoreID']."' AND tblAppointments.memberid !=  '0' $sqlTempfrom4 $sqlTempto4";

		
		$RSservice = $DB->query($sqlservice);
		if ($RSservice->num_rows > 0) 
		{
			

			while($rowservice = $RSservice->fetch_assoc())
			{
				$counterservice ++;
				$toatlseramt="";
			
				$newcust = $rowservice["newcust"];
				
					$setmemamount123 = "SELECT tblInvoiceDetails.Membership_Amount FROM tblCustomerMemberShip LEFT JOIN tblAppointments ON tblCustomerMemberShip.CustomerID = tblAppointments.CustomerID and tblCustomerMemberShip.MembershipID=tblAppointments.memberid left join tblInvoiceDetails on tblInvoiceDetails.CustomerID=tblCustomerMemberShip.CustomerID WHERE tblCustomerMemberShip.Status =  '1' AND tblCustomerMemberShip.RenewStatus =  '0' AND tblAppointments.StoreID =  '".$vat['StoreID']."' AND tblAppointments.memberid !=  '0' $sqlTempfrom3 $sqlTempto3";
			
				$setmemamount = $DB->query($setmemamount123);
			
				if ($setmemamount->num_rows > 0) 
				{
					
					while($rowsetmemamount = $setmemamount->fetch_assoc())
					{
						
						
						 $Membership_Amount = $rowsetmemamount["Membership_Amount"];
						 $memamtfirst = explode(",", $Membership_Amount);
						
                         $memamtfirst=str_replace("+", "", $Membership_Amount);
					     $memamtfirst2=str_replace(".00", "", $memamtfirst);
						 $memamtfirst3=str_replace("+", "", $memamtfirst2);
						 $memamtfirst4=str_replace(",", "", $memamtfirst3);
						 $memamtfirst5=str_replace(".00", "", $memamtfirst4);
				
					 // $memamtfirst=str_replace(",", "", $Membership_Amount);
				     if($memamtfirst5=='')
						{
							$memamtfirst5="0.00";
						}
		
				
				$Totalmemamtfirst = $Totalmemamtfirst + $memamtfirst5;
					}
				}
				
				$setrenewmemcount = "SELECT count(tblCustomerMemberShip.RenewCount) as renewcnt FROM tblCustomerMemberShip LEFT JOIN tblAppointments ON tblCustomerMemberShip.CustomerID = tblAppointments.CustomerID and tblCustomerMemberShip.MembershipID=tblAppointments.memberid WHERE tblCustomerMemberShip.Status =  '1' AND tblAppointments.StoreID =  '".$vat['StoreID']."' AND tblAppointments.memberid !=  '0' and tblCustomerMemberShip.RenewStatus='1' $sqlTempfrom3 $sqlTempto3";
				$RSsetrenewmemcount = $DB->query($setrenewmemcount);
			
				if ($RSsetrenewmemcount->num_rows > 0) 
				{
					
					while($rowRSsetrenewmemcount = $RSsetrenewmemcount->fetch_assoc())
					{
						$toatlseramt="";
						
						$renewcnt = $rowRSsetrenewmemcount["renewcnt"];
					}
				}
				
				/* $setrenewmemcount=select("count(tblCustomerMemberShip.RenewCount) as renewcnt","tblCustomerMemberShip LEFT JOIN tblAppointments ON tblCustomerMemberShip.CustomerID = tblAppointments.CustomerID left join tblInvoiceDetails on tblInvoiceDetails.CustomerID=tblCustomerMemberShip.CustomerID","tblCustomerMemberShip.Status =  '1' AND tblAppointments.StoreID =  '".$storr."' AND tblAppointments.memberid !=  '0' and tblCustomerMemberShip.RenewStatus='1' $sqlTempfrom3 $sqlTempto3");
				
				$renewcnt=$setrenewmemcount[0]['renewcnt']; */
				
				$setrenewmemamount=select("sum(tblCustomerMemberShip.RenewAmount) as renewamt","tblCustomerMemberShip LEFT JOIN tblAppointments ON tblCustomerMemberShip.CustomerID = tblAppointments.CustomerID and tblCustomerMemberShip.MembershipID=tblAppointments.memberid","tblCustomerMemberShip.Status =  '1' AND tblAppointments.StoreID =  '".$vat['StoreID']."' AND tblAppointments.memberid !=  '0' and tblCustomerMemberShip.RenewStatus='1' $sqlTempfrom3 $sqlTempto3");
				
				$renewamount=$setrenewmemamount[0]['renewamt'];
				
				if($renewamount=='')
				{
					$renewamount=0;
				}
				
				$setreexpirememcnt = "SELECT count(tblCustomerMemberShip.ExpiryCount) as excnt FROM tblCustomerMemberShip LEFT JOIN tblAppointments ON tblCustomerMemberShip.CustomerID = tblAppointments.CustomerID and tblCustomerMemberShip.MembershipID=tblAppointments.memberid WHERE tblCustomerMemberShip.Status =  '1' AND tblAppointments.StoreID =  '".$vat['StoreID']."' AND tblAppointments.memberid !=  '0' and ExpiryCount not IN ('',  '0') $sqlTempfrom1 $sqlTempto1";
			
				$RSsetreexpirememcnt = $DB->query($setreexpirememcnt);
			
				if ($RSsetreexpirememcnt->num_rows > 0) 
				{
					
					while($rowRSsetreexpirememcnt = $RSsetreexpirememcnt->fetch_assoc())
					{
						$toatlseramt="";
						
						$excnt = $rowRSsetreexpirememcnt["excnt"];
					}
				}
				
			
				
				$sep=select("*","tblStores","StoreID='".$vat['StoreID']."'");
		        $storename=$sep[0]['StoreName'];
	
	         if($newcust =="")
			{
				$newcust ="0.00";
			}
			else
			{
			
				$newcust = $newcust;
				
			}
			$Totalnewcust += $newcust;
			   if($Totalmemamtfirst =="")
			{
				$Totalmemamtfirst ="0.00";
			}
			else
			{
			
				$Totalmemamtfirst = $Totalmemamtfirst;
				
			}
			$TotalTotalmemamtfirstt += $Totalmemamtfirst;
			if($renewamount =="")
			{
				$renewamount ="0.00";
			}
			else
			{
			
				$renewamount = $renewamount;
				
			}
			$Totalrenewamount += $renewamount;
			   if($renewcnt =="")
			{
				$renewcnt ="0.00";
			}
			else
			{
			
				$renewcnt = $renewcnt;
				
			}
			$Totalrenewcnt += $renewcnt;
			   if($excnt =="")
			{
				$excnt ="0.00";
			}
			else
			{
			
				$excnt = $excnt;
				
			}
			$Totalexcnt += $excnt;
		
			$totalcountt=$newcust+$renewcnt+$excnt;
			$newmemper=($newcust/$totalcountt)*100;
              $expper=($excnt/$totalcountt)*100;
			

?>							
									
						                             
							<tr id="my_data_tr_<?=$counterservice?>">
								<td><center><?=$counterservice?></center></td>
									<td><center><?=$newcust?></center></td>
									<td><center><?=$Totalmemamtfirst?></center></td>
									<td><center><?=$renewcnt?></center></td>
									<td><center><?=$renewamount?></center></td>
									<td><center><?=$excnt?></center></td>
							        <td><center><b><?=$storename?></b></center></td>
									 <?php
																	if($per!='0')
																	{
																		?>
																	<td><center><b><?=round($totalcountt,2)?></b></center></td>	
																		<?php
																	}
																	
																	?>
																	<?php
																	if($per!='0')
																	{
																		?>
																	<td><center><b><?=round($newmemper,2)?></b></center></td>	
																		<?php
																	}
																	
																	?>
																	<?php
																	if($per!='0')
																	{
																		?>
																	<td><center><b><?=round($expper,2)?></b></center></td>	
																		<?php
																	}
																	
																	?>
								</tr>
															 
							
<?php
			}
			$sumrenew="";
			// $Totalmemamtfirst="";
			$Totalmemamtfirst="";
			
			
		}
		else
		{
?>
							
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
								
<?php		
		}
	}

}
			$totaltcust=$Totalnewcust+$Totalrenewcnt+$Totalexcnt;
			$tnewcust=($Totalnewcust/$totaltcust)*100;
	        $texpcust=($Totalexcnt/$totaltcust)*100;
?>							
					</tbody>
							<tbody>
														<tr>
										
															<td colspan="1"><b>Total Counts(s)</b></td>
															 <td class="numeric"><center><b><?=$Totalnewcust?></b></center></td>
															 <td class="numeric"><center><b>Rs. <?=$TotalTotalmemamtfirstt?>/-</b></center></td>
															 <td class="numeric"><center><b><?=$Totalrenewcnt?></b></center></td>
															 <td class="numeric"><center><b>Rs. <?=$Totalrenewamount?>/-</b></center></td>
															 <td class="numeric"><center><b><?=$Totalexcnt?></b></center></td>
															 <td class="numeric"><center></center></td>
															 <?php
																	if($per!='0')
																	{
																		?>
																	<td><center><b><?=$totaltcust?></b></center></td>	
																		<?php
																	}
																	
																	?>
																	<?php
																	if($per!='0')
																	{
																		?>
																	<td><center><b><?=round($tnewcust,2)?></b></center></td>	
																		<?php
																	}
																	
																	?>
																		<?php
																	if($per!='0')
																	{
																		?>
																	<td><center><b><?=round($texpcust,2)?></b></center></td>	
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