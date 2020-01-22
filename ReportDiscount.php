<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Report Discount | Nailspa";
	$strDisplayTitle = "Report Discount Nailspa";
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

		/* if(!IsNull($from))
		{
			$sqlTempfrom = " and Date(tblAppointments.AppointmentDate)>=Date('".$getfrom."')";
			$sqlTempfrom1 = " and Date(tblAppointmentMembershipDiscount.DateTimeStamp)>='".$getfrom."'";
			$sqlTempfrom2 = " and Date(tblGiftVouchers.RedempedDateTime)>='".$getfrom."'";
			$sqlTempfrom3 = " and Date(tblBillingPackage.ValidityStart)>='".$getfrom."'";
		
			$sqlTempfrom4 = " and Date(tblCustomers.RegDate)>='".$getfrom."'";
		
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblAppointments.AppointmentDate)<=Date('".$getto."')";
			$sqlTempto1 = " and Date(tblAppointmentMembershipDiscount.DateTimeStamp)<='".$getto."'";
			$sqlTempto2 = " and Date(tblGiftVouchers.RedempedDateTime)<='".$getto."'";
		    $sqlTempto3 = " and Date(tblBillingPackage.ValidityEnd)<='".$getto."'";
			$sqlTempto4 = " and Date(tblCustomers.RegDate)<='".$getto."'";
			
		} */
		
		if(!IsNull($from))
		{
			$sqlTempfrom = " and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$getfrom."')";
			//$sqlTempfrom = " and Date(tblAppointments.AppointmentDate)>=Date('".$getfrom."')";
			$sqlTempfrom1 = " and Date(tblCustomers.RegDate)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$getto."')";
			$sqlTempto1 = " and Date(tblCustomers.RegDate)<=Date('".$getto."')";
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
														<?php
														$storr=$_GET["Store"];
														?>
															<select name="Store" class="form-control">
															    <option value="cu" <?php if($storr=="cu"){?> selected <?php }?>>Cumulative</option>
																<option value="0" <?php if($storr=="0"){?> selected <?php }?>>All</option>
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
														<label class="col-sm-4 control-label">Select Type</label>
														<div class="col-sm-4">
														<?php 
														$discounttype=$_GET['discounttype'];
														?>
															<select name="discounttype" class="form-control">
																<option value="0"></option>
											                    <option value="1" <?php if($discounttype=='1'){?> selected <?php }?>><?="Offer"?></option> 
																<option value="2" <?php if($discounttype=='2'){?> selected <?php }?> ><?="Membership"?></option>	
															</select>
														</div>
                                                     </div>														
													<div class="form-group">
														<label class="col-sm-4 control-label">Select Percentage</label>
														<div class="col-sm-2">
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
														<a class="btn btn-link" href="ReportDiscount.php">Clear All Filter</a>
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
												
												<br>
												<div id="printdata">	
												<?php
												$store=$_GET["Store"];
												$dtype=$_GET["discounttype"];
													$datedrom=$_GET["toandfrom"];
													
													if($datedrom!="" && $dtype!="0")
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
														
												?>
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store Filter selected : <?=$storrrp?>  / Discount Type : 
														<?php 
														if($discounttype=='1')
														{
															echo "Offer";
														}
														else
														{
															echo "Membership";
														}
														?>
														
														
														</h3>
												
												<br>
				

				
<?php
$DB = Connect();

	$counter = 0;

		
?>

		<div class="panel">
			<div class="panel-body">
				
				<div class="example-box-wrapper">
					<div class="scroll-columns">
				
							                              
						
							
<?php
$storr=$_GET["Store"];
$per=$_GET["per"];
if(!empty($storr))
{
	if($storr=="cu")
	{
		?>
		     <span style="float:left;font-size:14px"><b>Store : Colaba</b></span><br/>
	         <table class="table table-bordered table-striped table-condensed cf">
						        <thead class="cf">
														 
															   <tr>
																<th><center>Discount Type</center></th>
																<th><center>Service Count</center></th>
																<th><center>Service Amount</center></th>
																<th><center>New Client Count</center></th>
																 <?php
																	if($per!='0')
																	{
																		?>
																		<th><center>New Client %</center></th>
																		<?php
																	}
																	?>
																<th><center>New Client Offer/Membership Amount</center></th>
																
																<th><center>Existing Client Count</center></th>
															 <?php
																	if($per!='0')
																	{
																		?>
																		<th><center>Existing Client %</center></th>
																		<?php
																	}
																	?>
																<th><center>Existing Client Offer/Membership Amount</center></th>
																</tr>
															 
																
							</thead>
						  <?php
	$discounttype=$_GET["discounttype"];
	if($discounttype=='1')
	{
		    $Select="Select distinct(tblAppointments.offerid) from tblAppointments right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='1' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom $sqlTempto";
		
               
				$RSservice = $DB->query($Select);
				if ($RSservice->num_rows > 0) 
				{
					$counterservice = 0;
				   while($rowservice = $RSservice->fetch_assoc())
					{
					
						$offerid[]=$rowservice['offerid'];		
					    
					}
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
								   </tr>
							</tbody>
							

<?php		
				}
				
				for($i=0;$i<count($offerid);$i++)
					{
						$SelectrM="SELECT COUNT(tblCustomers.CustomerID) FROM tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='1' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.offerid='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$RSservicetM = $DB->query($SelectrM);
								if ($RSservicetM->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetM = $RSservicetM->fetch_assoc())
									{
										$newcustsum +=$rowservicetM ['COUNT(tblCustomers.CustomerID)'];
									}
								}
								
							$sqldetailsdt="select COUNT(tblCustomers.CustomerID) from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='1' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointments.offerid='".$offerid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto";
                          $RSservicetqdt = $DB->query($sqldetailsdt);

								if ($RSservicetqdt->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqt = $RSservicetqdt->fetch_assoc())
									{
									$oldcustcntsum +=$rowservicetqt['COUNT(tblCustomers.CustomerID)'];
									
									}
								}
					   
					}
					for($i=0;$i<count($offerid);$i++)
					{
						$Selectr="Select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer,count(tblAppointmentMembershipDiscount.ServiceID) as contoffer,SUM(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as serviceamt from tblAppointmentMembershipDiscount left join  tblAppointments on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointmentsDetailsInvoice.ServiceID=tblAppointmentMembershipDiscount.ServiceID where tblAppointments.StoreID='1' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$selp=select("*","tblOffers","OfferID='".$offerid[$i]."'");
						$Name=$selp[0]['OfferName'];
								$RSservicet = $DB->query($Selectr);
								if ($RSservicet->num_rows > 0) 
								{
									$ty=0;
									while($rowservicet = $RSservicet->fetch_assoc())
									{
										
										$ty++;
										$sercnt=$rowservicet['contoffer'];
										//$seramtseramt=$rowservicet['sumoffer'];
										$serviceamt=$rowservicet['serviceamt'];
										//$totalseramtseramt=$seramtseramt;
										
										
									}
								}
					$SelectrM="SELECT COUNT(tblCustomers.CustomerID) FROM tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='1' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.offerid='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$RSservicetM = $DB->query($SelectrM);
								if ($RSservicetM->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetM = $RSservicetM->fetch_assoc())
									{
										$custcnt=$rowservicetM ['COUNT(tblCustomers.CustomerID)'];
									}
								}
					   
					   if($custcnt=='' || $custcnt=='0')
						{
							$custcnt=0;
						}
					if($sercnt=="")
					{
						$sercnt=0;
					}
					else
					{
						$sercnt=$sercnt;
					}
					$totalsercnt +=$sercnt;
					if($custcnt=="")
					{
						$custcnt=0;
					}
					else
					{
						$custcnt=$custcnt;
					}
					$totalcustcnt +=$custcnt;
					if($serviceamt=="")
					{
						$serviceamt=0;
						
					}
					else
					{
						$serviceamt=$serviceamt;
					}
					$toserviceamt +=$serviceamt;
					$Selectrpt="select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.offerid=tblAppointmentMembershipDiscount.OfferID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='1' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
				    $RSservicetq = $DB->query($Selectrpt);
								if ($RSservicetq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetq = $RSservicetq->fetch_assoc())
									{
									$sumoffer=$rowservicetq['sumoffer'];
									$totalseramtseramt=$sumoffer;	
									}
								}
					if($totalseramtseramt=="")
					{
						$totalseramtseramt=0;
						
					}
					else
					{
						$totalseramtseramt=$totalseramtseramt;
					}
					$tototalseramtseramt +=$totalseramtseramt;
					
					$sqldetailsdt="select COUNT(tblCustomers.CustomerID) from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='1' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointments.offerid='".$offerid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto";
                   $RSservicetqdt = $DB->query($sqldetailsdt);

								if ($RSservicetqdt->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqt = $RSservicetqdt->fetch_assoc())
									{
									$oldcustcnt=$rowservicetqt['COUNT(tblCustomers.CustomerID)'];
									
									}
								}
					   
					   if($oldcustcnt=='' || $oldcustcnt=='0')
						{
							$oldcustcnt=0;
						}
						 if($oldcustcnt=="")
							 {
								 $oldcustcnt=0;
							 }
							 else
							 {
								 $oldcustcnt=$oldcustcnt;
							 }	
                            $totaloldcustcnt += $oldcustcnt;	
							if($totaloldcustcnt=="")
							{
								$totaloldcustcnt=0;
							}
							else
							{
								$totaloldcustcnt=$totaloldcustcnt;
							}
							$totaltotaloldcustcnt +=$totaloldcustcnt;
						$Selectrptp="select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.offerid=tblAppointmentMembershipDiscount.OfferID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='1' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."'";
					
				        $RSservicetqq = $DB->query($Selectrptp);
								if ($RSservicetqq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqq = $RSservicetqq->fetch_assoc())
									{
									$seramtseramtt=$rowservicetqq['sumoffer'];
									$totalseramtseramtold=$seramtseramtt;	
									}
								}
					         if($totalseramtseramtold=="")
							 {
								 $totalseramtseramtold=0;
							 }
							 else
							 {
								 $totalseramtseramtold=$totalseramtseramtold;
							 }	
                            $taltotalseramtseramtold += $totalseramtseramtold;	
                            $newper=($custcnt/$newcustsum)*100;
							$expper=($oldcustcnt/$oldcustcntsum)*100;
                            	$totacu +=$newper;
	                        $totacuex +=$expper;								
								?>
								  <tbody>
								  <tr id="my_data_tr_<?=$counterservice?>">
		                        <td class="numeric"><center><?=$Name?></center></td>
								<td class="numeric"><center><?=$sercnt?></center></td>
								<td class="numeric"><center><?=$serviceamt?></center></td>
								<td class="numeric"><center><?php 
								                          if($custcnt=='')
																{
																	echo $custcnt=0;
																}
																else
																{
																	echo $custcnt;
																}
																
																
								
								                       ?></center></td>
													   <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php
                                                                    

																	echo round($newper,2)?></center></td>
																		<?php
																	}
																		?>
									                     <td><center><?php
														  if($totalseramtseramt=='')
																{
																	echo $totalseramtseramt=0;
																}
																else
																{
																	echo $totalseramtseramt;
																}
																
																
														
																?></center></td>
														<td class="numeric"><center><?php 
								                          if($oldcustcnt=='')
																{
																	echo $oldcustcnt=0;
																}
																else
																{
																	echo $oldcustcnt;
																}
																
																
								
								                       ?></center></td>
													      <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php
                                                                    

																	echo round($expper,2)?></center></td>
																		<?php
																	}
																		?>
																<td><center><?php
															  if($totalseramtseramtold=="")
																{
																	echo $totalseramtseramtold=0;
																}
																else
																{
																	echo round($totalseramtseramtold);
																}  
																
																?></center></td>
								</tr>
								  </tbody>
								<?php
						
					}
					unset($offerid);
							
				      
					
					$totalseramtseramt=0;
					$sercnt=0;
					$newcustsum=0;
					$oldcustcntsum=0;		
					
				
	}
	else
	{
		
		 $Selectt="Select distinct(tblAppointments.memberid) from tblAppointments right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='1' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom $sqlTempto";
		
               
				$RSservicet = $DB->query($Selectt);
				if ($RSservicet->num_rows > 0) 
				{
					$counterservice = 0;
				   while($rowservicet = $RSservicet->fetch_assoc())
					{
					
						$memberid[]=$rowservicet['memberid'];		
					    
					}
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
								   </tr>
							      </tbody>
							

<?php		
				}
				for($i=0;$i<count($memberid);$i++)
					{
							$sqldetailsd=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='1' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.memberid='".$memberid[$i]."' $sqlTempfrom $sqlTempto");
					        $sumcustcnt +=$sqldetailsd[0]['COUNT(tblCustomers.CustomerID)'];
						
						$sqldetailsdt=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='1' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointments.memberid='".$memberid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto");
					   $oldcustcntsum +=$sqldetailsdt[0]['COUNT(tblCustomers.CustomerID)'];
					}
				
				
					for($i=0;$i<count($memberid);$i++)
					{
						$Selectr="Select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer,count(tblAppointmentMembershipDiscount.ServiceID) as contoffer,SUM(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as serviceamt from tblAppointmentMembershipDiscount left join  tblAppointments on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointmentsDetailsInvoice.ServiceID=tblAppointmentMembershipDiscount.ServiceID where tblAppointments.StoreID='1' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
					    $selp=select("*","tblMembership","MembershipID='".$memberid[$i]."'");
					    $Name=$selp[0]['MembershipName'];
					
								$RSservicet = $DB->query($Selectr);
								if ($RSservicet->num_rows > 0) 
								{
									$ty=0;
									while($rowservicet = $RSservicet->fetch_assoc())
									{
										
										$ty++;
										$sercnt=$rowservicet['contoffer'];
										//$seramtseramt=$rowservicet['sumoffer'];
										$serviceamt=$rowservicet['serviceamt'];
										//$totalseramtseramt=$seramtseramt;
										
										
									}
								}
					
					$sqldetailsd=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='1' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.memberid='".$memberid[$i]."' $sqlTempfrom $sqlTempto");
					   $custcnt=$sqldetailsd[0]['COUNT(tblCustomers.CustomerID)'];
					   if($custcnt=='' || $custcnt=='0')
						{
							$custcnt=0;
						}
					if($sercnt=="")
					{
						$sercnt=0;
					}
					else
					{
						$sercnt=$sercnt;
					}
					$totalsercnt +=$sercnt;
					if($custcnt=="")
					{
						$custcnt=0;
					}
					else
					{
						$custcnt=$custcnt;
					}
					$totalcustcnt +=$custcnt;
					if($serviceamt=="")
					{
						$serviceamt=0;
						
					}
					else
					{
						$serviceamt=$serviceamt;
					}
					$toserviceamt +=$serviceamt;
					$Selectrpt="select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID  AND tblAppointments.memberid=tblAppointmentMembershipDiscount.MembershipID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='1' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
				    $RSservicetq = $DB->query($Selectrpt);
								if ($RSservicetq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetq = $RSservicetq->fetch_assoc())
									{
									$sumoffer=$rowservicetq['sumoffer'];
									$totalseramtseramt=$sumoffer;	
									}
								}
					if($totalseramtseramt=="")
					{
						$totalseramtseramt=0;
						
					}
					else
					{
						$totalseramtseramt=$totalseramtseramt;
					}
					$tototalseramtseramt +=$totalseramtseramt;
					
						$sqldetailsdt=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='1' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointments.memberid='".$memberid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto");
					   $oldcustcnt=$sqldetailsdt[0]['COUNT(tblCustomers.CustomerID)'];
					   if($oldcustcnt=='' || $oldcustcnt=='0')
						{
							$oldcustcnt=0;
						}
						 if($oldcustcnt=="")
							 {
								 $oldcustcnt=0;
							 }
							 else
							 {
								 $oldcustcnt=$oldcustcnt;
							 }	
                            $totaloldcustcnt += $oldcustcnt;	
							if($totaloldcustcnt=="")
							{
								$totaloldcustcnt=0;
							}
							else
							{
								$totaloldcustcnt=$totaloldcustcnt;
							}
							$totaltotaloldcustcnt +=$totaloldcustcnt;
						$Selectrptp="select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.memberid=tblAppointmentMembershipDiscount.MembershipID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='1' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
				        $RSservicetqq = $DB->query($Selectrptp);
								if ($RSservicetqq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqq = $RSservicetqq->fetch_assoc())
									{
									$seramtseramtt=$rowservicetqq['sumoffer'];
									$totalseramtseramtold=$seramtseramtt;	
									}
								}
					         if($totalseramtseramtold=="")
							 {
								 $totalseramtseramtold=0;
							 }
							 else
							 {
								 $totalseramtseramtold=$totalseramtseramtold;
							 }	
                            $taltotalseramtseramtold += $totalseramtseramtold;	
                            $newper=($custcnt/$sumcustcnt)*100;
							$expper=($oldcustcnt/$oldcustcntsum)*100;
							$totacu +=$newper;
	                        $totacuex +=$expper;		
                            							
								?>
								<tbody>
								  <tr id="my_data_tr_<?=$counterservice?>">
		                        <td class="numeric"><center><?=$Name?></center></td>
								<td class="numeric"><center><?=$sercnt?></center></td>
								<td class="numeric"><center><?=$serviceamt?></center></td>
								<td class="numeric"><center><?php 
								                          if($custcnt=='')
																{
																	echo $custcnt=0;
																}
																else
																{
																	echo $custcnt;
																}
																
																
								
								                       ?></center></td>
													    <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($newper,2)?></center></td>
																		<?php
																	}
																		?>
													  
									                     <td><center><?php
														  if($totalseramtseramt=='')
																{
																	echo $totalseramtseramt=0;
																}
																else
																{
																	echo $totalseramtseramt;
																}
																
																
														
																?></center></td>
														<td class="numeric"><center><?php 
								                          if($oldcustcnt=='')
																{
																	echo $oldcustcnt=0;
																}
																else
																{
																	echo $oldcustcnt;
																}
																
																
								
								                       ?></center></td>
													    <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($expper,2)?></center></td>
																		<?php
																	}
																		?>
													  
																<td><center><?php
															  if($totalseramtseramtold=="")
																{
																	echo $totalseramtseramtold=0;
																}
																else
																{
																	echo round($totalseramtseramtold);
																}  
																
																?></center></td>
								</tr>
								</tbody>
								<?php
						
					}
					unset($memberid);
						$newcustsum=0;
					$oldcustcntsum=0;			
				      
	
	}
/* 	$totacu=($totalcustcnt/$totalsercnt)*100;
	$totacuex=($totaloldcustcnt/$totalsercnt)*100; */
	?>
	
						   <tbody>
								<tr>
									<td><center><b>Total Amounts(s)</b></center></td>
									
									<td class="numeric"><center><b><?=$totalsercnt?></b></center></td>
									<td class="numeric"><center><b>Rs. <?=$toserviceamt?>/-</b></center></td>
									<td class="numeric"><center><b><?=$totalcustcnt?></b></center></td>
									 <?php
																	if($per!='0')
																	{
																		?>
																		<td class="numeric"><center><b><?=round($totacu,2)?></b></center></td>
																		<?php
																	}
																		?>
									<td class="numeric"><center><b>Rs. <?=$tototalseramtseramt?>/-</b></center></td>
									<td class="numeric"><center><b><?=$totaloldcustcnt?></b></center></td>
									 <?php
																	if($per!='0')
																	{
																		?>
																		<td class="numeric"><center><b></b></center></td>
																		<?php
																	}
																		?>
									<td class="numeric"><center><b>Rs. <?=round($taltotalseramtseramtold)?>/-</b></center></td>
									
								</tr>
							</tbody> 
							 </table>													
                             <br/>
							 <br/>

	<?php
	$totalsercnt="";
	$toserviceamt="";
	$totalcustcnt="";
	$tototalseramtseramt="";
	$totaloldcustcnt="";
	$taltotalseramtseramtold="";
	$totacu="";
	$totacuex="";
	$newcustsum=0;
	$oldcustcntsum=0;		
	/////////////////////////////////////////Khar////////////////
	
	?>
	     <span style="float:left;font-size:14px"><b>Store : Khar</b></span><br/>
	                           <table class="table table-bordered table-striped table-condensed cf">
						        <thead class="cf">
														 
															   <tr>
																<th><center>Discount Type</center></th>
																<th><center>Service Count</center></th>
																<th><center>Service Amount</center></th>
																<th><center>New Client Count</center></th>
																 <?php
																	if($per!='0')
																	{
																		?>
																		<th><center>New Client %</center></th>
																		<?php
																	}
																	?>
																<th><center>New Client Offer/Membership Amount</center></th>
																<th><center>Existing Client Count</center></th>
																 <?php
																	if($per!='0')
																	{
																		?>
																		<th><center>Existing Client %</center></th>
																		<?php
																	}
																	?>
																<th><center>Existing Client Offer/Membership Amount</center></th>
																</tr>
															 
																
							</thead>
						  <?php
	$discounttype=$_GET["discounttype"];
	if($discounttype=='1')
	{
		    $Select="Select distinct(tblAppointments.offerid) from tblAppointments right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='2' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom $sqlTempto";
		
               
				$RSservice = $DB->query($Select);
				if ($RSservice->num_rows > 0) 
				{
					$counterservice = 0;
				   while($rowservice = $RSservice->fetch_assoc())
					{
					
						$offerid[]=$rowservice['offerid'];		
					    
					}
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
								   </tr>
							</tbody>
							

<?php		
				}
				for($i=0;$i<count($offerid);$i++)
					{
						$SelectrM="SELECT COUNT(tblCustomers.CustomerID) FROM tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='2' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.offerid='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$RSservicetM = $DB->query($SelectrM);
								if ($RSservicetM->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetM = $RSservicetM->fetch_assoc())
									{
										$newcustsum +=$rowservicetM ['COUNT(tblCustomers.CustomerID)'];
									}
								}
								
							$sqldetailsdt="select COUNT(tblCustomers.CustomerID) from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='2' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointments.offerid='".$offerid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto";
                          $RSservicetqdt = $DB->query($sqldetailsdt);

								if ($RSservicetqdt->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqt = $RSservicetqdt->fetch_assoc())
									{
									$oldcustcntsum +=$rowservicetqt['COUNT(tblCustomers.CustomerID)'];
									
									}
								}
					   
						
					}
				
					for($i=0;$i<count($offerid);$i++)
					{
						$Selectr="Select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer,count(tblAppointmentMembershipDiscount.ServiceID) as contoffer,SUM(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as serviceamt from tblAppointmentMembershipDiscount left join  tblAppointments on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointmentsDetailsInvoice.ServiceID=tblAppointmentMembershipDiscount.ServiceID where tblAppointments.StoreID='2' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$selp=select("*","tblOffers","OfferID='".$offerid[$i]."'");
						$Name=$selp[0]['OfferName'];
								$RSservicet = $DB->query($Selectr);
								if ($RSservicet->num_rows > 0) 
								{
									$ty=0;
									while($rowservicet = $RSservicet->fetch_assoc())
									{
										
										$ty++;
										$sercnt=$rowservicet['contoffer'];
										//$seramtseramt=$rowservicet['sumoffer'];
										$serviceamt=$rowservicet['serviceamt'];
										//$totalseramtseramt=$seramtseramt;
										
										
									}
								}
					$SelectrM="SELECT COUNT(tblCustomers.CustomerID) FROM tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='2' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.offerid='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$RSservicetM = $DB->query($SelectrM);
								if ($RSservicetM->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetM = $RSservicetM->fetch_assoc())
									{
										$custcnt=$rowservicetM ['COUNT(tblCustomers.CustomerID)'];
									}
								}
					   
					   if($custcnt=='' || $custcnt=='0')
						{
							$custcnt=0;
						}
					if($sercnt=="")
					{
						$sercnt=0;
					}
					else
					{
						$sercnt=$sercnt;
					}
					$totalsercnt +=$sercnt;
					if($custcnt=="")
					{
						$custcnt=0;
					}
					else
					{
						$custcnt=$custcnt;
					}
					$totalcustcnt +=$custcnt;
					if($serviceamt=="")
					{
						$serviceamt=0;
						
					}
					else
					{
						$serviceamt=$serviceamt;
					}
					$toserviceamt +=$serviceamt;
					$Selectrpt="select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.offerid=tblAppointmentMembershipDiscount.OfferID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='2' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
				    $RSservicetq = $DB->query($Selectrpt);
								if ($RSservicetq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetq = $RSservicetq->fetch_assoc())
									{
									$sumoffer=$rowservicetq['sumoffer'];
									$totalseramtseramt=$sumoffer;	
									}
								}
					if($totalseramtseramt=="")
					{
						$totalseramtseramt=0;
						
					}
					else
					{
						$totalseramtseramt=$totalseramtseramt;
					}
					$tototalseramtseramt +=$totalseramtseramt;
					
					$sqldetailsdt="select COUNT(tblCustomers.CustomerID) from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='2' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointments.offerid='".$offerid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto";
                   $RSservicetqdt = $DB->query($sqldetailsdt);

								if ($RSservicetqdt->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqt = $RSservicetqdt->fetch_assoc())
									{
									$oldcustcnt=$rowservicetqt['COUNT(tblCustomers.CustomerID)'];
									
									}
								}
					   
					   if($oldcustcnt=='' || $oldcustcnt=='0')
						{
							$oldcustcnt=0;
						}
						 if($oldcustcnt=="")
							 {
								 $oldcustcnt=0;
							 }
							 else
							 {
								 $oldcustcnt=$oldcustcnt;
							 }	
                            $totaloldcustcnt += $oldcustcnt;	
							if($totaloldcustcnt=="")
							{
								$totaloldcustcnt=0;
							}
							else
							{
								$totaloldcustcnt=$totaloldcustcnt;
							}
							$totaltotaloldcustcnt +=$totaloldcustcnt;
						$Selectrptp="select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.offerid=tblAppointmentMembershipDiscount.OfferID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='2' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."'";
					
				        $RSservicetqq = $DB->query($Selectrptp);
								if ($RSservicetqq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqq = $RSservicetqq->fetch_assoc())
									{
									$seramtseramtt=$rowservicetqq['sumoffer'];
									$totalseramtseramtold=$seramtseramtt;	
									}
								}
					         if($totalseramtseramtold=="")
							 {
								 $totalseramtseramtold=0;
							 }
							 else
							 {
								 $totalseramtseramtold=$totalseramtseramtold;
							 }	
                            $taltotalseramtseramtold += $totalseramtseramtold;	
                            $newper=($custcnt/$newcustsum)*100;
							$expper=($oldcustcnt/$oldcustcntsum)*100;
                            $totacu +=$newper;
	                        $totacuex +=$expper;									
								?>
								  <tbody>
								  <tr id="my_data_tr_<?=$counterservice?>">
		                        <td class="numeric"><center><?=$Name?></center></td>
								<td class="numeric"><center><?=$sercnt?></center></td>
								<td class="numeric"><center><?=$serviceamt?></center></td>
								<td class="numeric"><center><?php 
								                          if($custcnt=='')
																{
																	echo $custcnt=0;
																}
																else
																{
																	echo $custcnt;
																}
																
																
								
								                       ?></center></td>
													     <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php
                                                                 
																	echo round($newper,2)?></center></td>
																		<?php
																	}
																		?>
									                     <td><center><?php
														  if($totalseramtseramt=='')
																{
																	echo $totalseramtseramt=0;
																}
																else
																{
																	echo $totalseramtseramt;
																}
																
																
														
																?></center></td>
														<td class="numeric"><center><?php 
								                          if($oldcustcnt=='')
																{
																	echo $oldcustcnt=0;
																}
																else
																{
																	echo $oldcustcnt;
																}
																
																
								
								                       ?></center></td>
													        <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php
                                                                 
																	echo round($expper,2)?></center></td>
																		<?php
																	}
																		?>
																<td><center><?php
															  if($totalseramtseramtold=="")
																{
																	echo $totalseramtseramtold=0;
																}
																else
																{
																	echo round($totalseramtseramtold);
																}  
																
																?></center></td>
								</tr>
								  </tbody>
								<?php
						
					}
					unset($offerid);
							
				      
					
					$totalseramtseramt=0;
					$sercnt=0;
					$newcustsum=0;
					$oldcustcntsum=0;		
							
					
				
	}
	else
	{
		
		 $Selectt="Select distinct(tblAppointments.memberid) from tblAppointments right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='2' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom $sqlTempto";
		
               
				$RSservicet = $DB->query($Selectt);
				if ($RSservicet->num_rows > 0) 
				{
					$counterservice = 0;
				   while($rowservicet = $RSservicet->fetch_assoc())
					{
					
						$memberid[]=$rowservicet['memberid'];		
					    
					}
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
								   </tr>
							      </tbody>
							

<?php		
				}
				
						for($i=0;$i<count($memberid);$i++)
					{
							$sqldetailsd=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='2' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.memberid='".$memberid[$i]."' $sqlTempfrom $sqlTempto");
					        $sumcustcnt +=$sqldetailsd[0]['COUNT(tblCustomers.CustomerID)'];
						
						$sqldetailsdt=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='2' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointments.memberid='".$memberid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto");
					   $oldcustcntsum +=$sqldetailsdt[0]['COUNT(tblCustomers.CustomerID)'];
					}
				
				
					for($i=0;$i<count($memberid);$i++)
					{
						$Selectr="Select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer,count(tblAppointmentMembershipDiscount.ServiceID) as contoffer,SUM(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as serviceamt from tblAppointmentMembershipDiscount left join  tblAppointments on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointmentsDetailsInvoice.ServiceID=tblAppointmentMembershipDiscount.ServiceID where tblAppointments.StoreID='2' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
					    $selp=select("*","tblMembership","MembershipID='".$memberid[$i]."'");
					    $Name=$selp[0]['MembershipName'];
					
								$RSservicet = $DB->query($Selectr);
								if ($RSservicet->num_rows > 0) 
								{
									$ty=0;
									while($rowservicet = $RSservicet->fetch_assoc())
									{
										
										$ty++;
										$sercnt=$rowservicet['contoffer'];
										//$seramtseramt=$rowservicet['sumoffer'];
										$serviceamt=$rowservicet['serviceamt'];
										//$totalseramtseramt=$seramtseramt;
										
										
									}
								}
					
					$sqldetailsd=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='2' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.memberid='".$memberid[$i]."' $sqlTempfrom $sqlTempto");
					   $custcnt=$sqldetailsd[0]['COUNT(tblCustomers.CustomerID)'];
					   if($custcnt=='' || $custcnt=='0')
						{
							$custcnt=0;
						}
					if($sercnt=="")
					{
						$sercnt=0;
					}
					else
					{
						$sercnt=$sercnt;
					}
					$totalsercnt +=$sercnt;
					if($custcnt=="")
					{
						$custcnt=0;
					}
					else
					{
						$custcnt=$custcnt;
					}
					$totalcustcnt +=$custcnt;
					if($serviceamt=="")
					{
						$serviceamt=0;
						
					}
					else
					{
						$serviceamt=$serviceamt;
					}
					$toserviceamt +=$serviceamt;
					$Selectrpt="select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID  AND tblAppointments.memberid=tblAppointmentMembershipDiscount.MembershipID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='2' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
				    $RSservicetq = $DB->query($Selectrpt);
								if ($RSservicetq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetq = $RSservicetq->fetch_assoc())
									{
									$sumoffer=$rowservicetq['sumoffer'];
									$totalseramtseramt=$sumoffer;	
									}
								}
					if($totalseramtseramt=="")
					{
						$totalseramtseramt=0;
						
					}
					else
					{
						$totalseramtseramt=$totalseramtseramt;
					}
					$tototalseramtseramt +=$totalseramtseramt;
					
						$sqldetailsdt=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='2' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointments.memberid='".$memberid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto");
					   $oldcustcnt=$sqldetailsdt[0]['COUNT(tblCustomers.CustomerID)'];
					   if($oldcustcnt=='' || $oldcustcnt=='0')
						{
							$oldcustcnt=0;
						}
						 if($oldcustcnt=="")
							 {
								 $oldcustcnt=0;
							 }
							 else
							 {
								 $oldcustcnt=$oldcustcnt;
							 }	
                            $totaloldcustcnt += $oldcustcnt;	
							if($totaloldcustcnt=="")
							{
								$totaloldcustcnt=0;
							}
							else
							{
								$totaloldcustcnt=$totaloldcustcnt;
							}
							$totaltotaloldcustcnt +=$totaloldcustcnt;
						$Selectrptp="select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.memberid=tblAppointmentMembershipDiscount.MembershipID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='2' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
				        $RSservicetqq = $DB->query($Selectrptp);
								if ($RSservicetqq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqq = $RSservicetqq->fetch_assoc())
									{
									$seramtseramtt=$rowservicetqq['sumoffer'];
									$totalseramtseramtold=$seramtseramtt;	
									}
								}
					         if($totalseramtseramtold=="")
							 {
								 $totalseramtseramtold=0;
							 }
							 else
							 {
								 $totalseramtseramtold=$totalseramtseramtold;
							 }	
                            $taltotalseramtseramtold += $totalseramtseramtold;	
                            
							$newper=($custcnt/$sumcustcnt)*100;
                            $expper=($oldcustcnt/$oldcustcntsum)*100;	
                            $totacu +=$newper;
	                        $totacuex +=$expper;									
								?>
								<tbody>
								  <tr id="my_data_tr_<?=$counterservice?>">
		                        <td class="numeric"><center><?=$Name?></center></td>
								<td class="numeric"><center><?=$sercnt?></center></td>
								<td class="numeric"><center><?=$serviceamt?></center></td>
								<td class="numeric"><center><?php 
								                          if($custcnt=='')
																{
																	echo $custcnt=0;
																}
																else
																{
																	echo $custcnt;
																}
																
																
								
								                       ?></center></td>
													    <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($newper,2)?></center></td>
																		<?php
																	}
																		?>
									                     <td><center><?php
														  if($totalseramtseramt=='')
																{
																	echo $totalseramtseramt=0;
																}
																else
																{
																	echo $totalseramtseramt;
																}
																
																
														
																?></center></td>
														<td class="numeric"><center><?php 
								                          if($oldcustcnt=='')
																{
																	echo $oldcustcnt=0;
																}
																else
																{
																	echo $oldcustcnt;
																}
																
																
								
								                       ?></center></td>
													       <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($expper,2)?></center></td>
																		<?php
																	}
																		?>
																<td><center><?php
															  if($totalseramtseramtold=="")
																{
																	echo $totalseramtseramtold=0;
																}
																else
																{
																	echo round($totalseramtseramtold);
																}  
																
																?></center></td>
								</tr>
								</tbody>
								<?php
						
					}
					unset($memberid);
						$newcustsum=0;
					$oldcustcntsum=0;			
				      
	
	}
	/* $totacu=($totalcustcnt/$totalsercnt)*100;
	$totacuex=($totaloldcustcnt/$totalsercnt)*100; */
	?>
	
						   <tbody>
								<tr>
									<td><center><b>Total Amounts(s)</b></center></td>
									
									<td class="numeric"><center><b><?=$totalsercnt?></b></center></td>
									<td class="numeric"><center><b>Rs. <?=$toserviceamt?>/-</b></center></td>
									<td class="numeric"><center><b><?=$totalcustcnt?></b></center></td>
													 <?php
																	if($per!='0')
																	{
																		?>
																		<td class="numeric"><center><b><?=round($totacu,2)?></b></center></td>
																		<?php
																	}
																		?>
									<td class="numeric"><center><b>Rs. <?=$tototalseramtseramt?>/-</b></center></td>
									<td class="numeric"><center><b><?=$totaloldcustcnt?></b></center></td>
									 <?php
																	if($per!='0')
																	{
																		?>
																		<td class="numeric"><center><b></b></center></td>
																		<?php
																	}
																		?>
									<td class="numeric"><center><b>Rs. <?=round($taltotalseramtseramtold)?>/-</b></center></td>
									
								</tr>
							</tbody> 
							 </table>			
							  <br/>
							 <br/>
	<?php
	$totalsercnt="";
	$toserviceamt="";
	$totalcustcnt="";
	$tototalseramtseramt="";
	$totaloldcustcnt="";
	$taltotalseramtseramtold="";
	$totacu="";
	$totacuex="";
	$newcustsum=0;
	$oldcustcntsum=0;		
	/////////////////////////////////////////Breach Candy////////////////
	
	?>
	     <span style="float:left;font-size:14px"><b>Store : Breach Candy</b></span><br/>
	                           <table class="table table-bordered table-striped table-condensed cf">
						        <thead class="cf">
														 
															   <tr>
																<th><center>Discount Type</center></th>
																<th><center>Service Count</center></th>
																<th><center>Service Amount</center></th>
																<th><center>New Client Count</center></th>
																 <?php
																	if($per!='0')
																	{
																		?>
																	<th><center>New Client %</center></th>
																		<?php
																	}
																		?>
																<th><center>New Client Offer/Membership Amount</center></th>
																<th><center>Existing Client Count</center></th>
																	 <?php
																	if($per!='0')
																	{
																		?>
																		<th><center>Existing Client %</center></th>
																		<?php
																	}
																	?>
																<th><center>Existing Client Offer/Membership Amount</center></th>
																</tr>
															 
																
							</thead>
						  <?php
	$discounttype=$_GET["discounttype"];
	if($discounttype=='1')
	{
		    $Select="Select distinct(tblAppointments.offerid) from tblAppointments right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='3' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom $sqlTempto";
		
               
				$RSservice = $DB->query($Select);
				if ($RSservice->num_rows > 0) 
				{
					$counterservice = 0;
				   while($rowservice = $RSservice->fetch_assoc())
					{
					
						$offerid[]=$rowservice['offerid'];		
					    
					}
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
								   </tr>
							</tbody>
							

<?php		
				}
						for($i=0;$i<count($offerid);$i++)
					{
						$SelectrM="SELECT COUNT(tblCustomers.CustomerID) FROM tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='3' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.offerid='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$RSservicetM = $DB->query($SelectrM);
								if ($RSservicetM->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetM = $RSservicetM->fetch_assoc())
									{
										$newcustsum +=$rowservicetM ['COUNT(tblCustomers.CustomerID)'];
									}
								}
								
							$sqldetailsdt="select COUNT(tblCustomers.CustomerID) from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='3' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointments.offerid='".$offerid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto";
                          $RSservicetqdt = $DB->query($sqldetailsdt);

								if ($RSservicetqdt->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqt = $RSservicetqdt->fetch_assoc())
									{
									$oldcustcntsum +=$rowservicetqt['COUNT(tblCustomers.CustomerID)'];
									
									}
								}
					   
						
					}
					for($i=0;$i<count($offerid);$i++)
					{
						$Selectr="Select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer,count(tblAppointmentMembershipDiscount.ServiceID) as contoffer,SUM(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as serviceamt from tblAppointmentMembershipDiscount left join  tblAppointments on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointmentsDetailsInvoice.ServiceID=tblAppointmentMembershipDiscount.ServiceID where tblAppointments.StoreID='3' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$selp=select("*","tblOffers","OfferID='".$offerid[$i]."'");
						$Name=$selp[0]['OfferName'];
								$RSservicet = $DB->query($Selectr);
								if ($RSservicet->num_rows > 0) 
								{
									$ty=0;
									while($rowservicet = $RSservicet->fetch_assoc())
									{
										
										$ty++;
										$sercnt=$rowservicet['contoffer'];
										//$seramtseramt=$rowservicet['sumoffer'];
										$serviceamt=$rowservicet['serviceamt'];
										//$totalseramtseramt=$seramtseramt;
										
										
									}
								}
					$SelectrM="SELECT COUNT(tblCustomers.CustomerID) FROM tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='3' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.offerid='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$RSservicetM = $DB->query($SelectrM);
								if ($RSservicetM->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetM = $RSservicetM->fetch_assoc())
									{
										$custcnt=$rowservicetM ['COUNT(tblCustomers.CustomerID)'];
									}
								}
					   
					   if($custcnt=='' || $custcnt=='0')
						{
							$custcnt=0;
						}
					if($sercnt=="")
					{
						$sercnt=0;
					}
					else
					{
						$sercnt=$sercnt;
					}
					$totalsercnt +=$sercnt;
					if($custcnt=="")
					{
						$custcnt=0;
					}
					else
					{
						$custcnt=$custcnt;
					}
					$totalcustcnt +=$custcnt;
					if($serviceamt=="")
					{
						$serviceamt=0;
						
					}
					else
					{
						$serviceamt=$serviceamt;
					}
					$toserviceamt +=$serviceamt;
					$Selectrpt="select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.offerid=tblAppointmentMembershipDiscount.OfferID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='3' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
				    $RSservicetq = $DB->query($Selectrpt);
								if ($RSservicetq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetq = $RSservicetq->fetch_assoc())
									{
									$sumoffer=$rowservicetq['sumoffer'];
									$totalseramtseramt=$sumoffer;	
									}
								}
					if($totalseramtseramt=="")
					{
						$totalseramtseramt=0;
						
					}
					else
					{
						$totalseramtseramt=$totalseramtseramt;
					}
					$tototalseramtseramt +=$totalseramtseramt;
					
					$sqldetailsdt="select COUNT(tblCustomers.CustomerID) from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='3' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointments.offerid='".$offerid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto";
                   $RSservicetqdt = $DB->query($sqldetailsdt);

								if ($RSservicetqdt->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqt = $RSservicetqdt->fetch_assoc())
									{
									$oldcustcnt=$rowservicetqt['COUNT(tblCustomers.CustomerID)'];
									
									}
								}
					   
					   if($oldcustcnt=='' || $oldcustcnt=='0')
						{
							$oldcustcnt=0;
						}
						 if($oldcustcnt=="")
							 {
								 $oldcustcnt=0;
							 }
							 else
							 {
								 $oldcustcnt=$oldcustcnt;
							 }	
                            $totaloldcustcnt += $oldcustcnt;	
							if($totaloldcustcnt=="")
							{
								$totaloldcustcnt=0;
							}
							else
							{
								$totaloldcustcnt=$totaloldcustcnt;
							}
							$totaltotaloldcustcnt +=$totaloldcustcnt;
						$Selectrptp="select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.offerid=tblAppointmentMembershipDiscount.OfferID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='3' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."'";
					
				        $RSservicetqq = $DB->query($Selectrptp);
								if ($RSservicetqq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqq = $RSservicetqq->fetch_assoc())
									{
									$seramtseramtt=$rowservicetqq['sumoffer'];
									$totalseramtseramtold=$seramtseramtt;	
									}
								}
					         if($totalseramtseramtold=="")
							 {
								 $totalseramtseramtold=0;
							 }
							 else
							 {
								 $totalseramtseramtold=$totalseramtseramtold;
							 }	
                            $taltotalseramtseramtold += $totalseramtseramtold;	
                            $newper=($custcnt/$newcustsum)*100;
							$expper=($oldcustcnt/$oldcustcntsum)*100;
                            $totacu +=$newper;
	                        $totacuex +=$expper;									
								?>
								  <tbody>
								  <tr id="my_data_tr_<?=$counterservice?>">
		                        <td class="numeric"><center><?=$Name?></center></td>
								<td class="numeric"><center><?=$sercnt?></center></td>
								<td class="numeric"><center><?=$serviceamt?></center></td>
								<td class="numeric"><center><?php 
								                          if($custcnt=='')
																{
																	echo $custcnt=0;
																}
																else
																{
																	echo $custcnt;
																}
																
																
								
								                       ?></center></td>
													   <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($newper,2)?></center></td>
																		<?php
																	}
																		?>
									                     <td><center><?php
														  if($totalseramtseramt=='')
																{
																	echo $totalseramtseramt=0;
																}
																else
																{
																	echo $totalseramtseramt;
																}
																
																
														
																?></center></td>
														<td class="numeric"><center><?php 
								                          if($oldcustcnt=='')
																{
																	echo $oldcustcnt=0;
																}
																else
																{
																	echo $oldcustcnt;
																}
																
																
								
								                       ?></center></td>
													      <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($expper,2)?></center></td>
																		<?php
																	}
																		?>
																<td><center><?php
															  if($totalseramtseramtold=="")
																{
																	echo $totalseramtseramtold=0;
																}
																else
																{
																	echo round($totalseramtseramtold);
																}  
																
																?></center></td>
								</tr>
								  </tbody>
								<?php
						
					}
					unset($offerid);
							
				      
					
					$totalseramtseramt=0;
					$sercnt=0;
					$newcustsum=0;
					$oldcustcntsum=0;		
							
					
				
	}
	else
	{
		
		 $Selectt="Select distinct(tblAppointments.memberid) from tblAppointments right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='3' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom $sqlTempto";
		
               
				$RSservicet = $DB->query($Selectt);
				if ($RSservicet->num_rows > 0) 
				{
					$counterservice = 0;
				   while($rowservicet = $RSservicet->fetch_assoc())
					{
					
						$memberid[]=$rowservicet['memberid'];		
					    
					}
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
								
								   </tr>
							      </tbody>
							

<?php		
				}
				
				for($i=0;$i<count($memberid);$i++)
					{
							$sqldetailsd=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='3' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.memberid='".$memberid[$i]."' $sqlTempfrom $sqlTempto");
					        $sumcustcnt +=$sqldetailsd[0]['COUNT(tblCustomers.CustomerID)'];
						
						$sqldetailsdt=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='3' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointments.memberid='".$memberid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto");
					   $oldcustcntsum +=$sqldetailsdt[0]['COUNT(tblCustomers.CustomerID)'];
					}
				
				
			
					for($i=0;$i<count($memberid);$i++)
					{
						$Selectr="Select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer,count(tblAppointmentMembershipDiscount.ServiceID) as contoffer,SUM(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as serviceamt from tblAppointmentMembershipDiscount left join  tblAppointments on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointmentsDetailsInvoice.ServiceID=tblAppointmentMembershipDiscount.ServiceID where tblAppointments.StoreID='3' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
					    $selp=select("*","tblMembership","MembershipID='".$memberid[$i]."'");
					    $Name=$selp[0]['MembershipName'];
					
								$RSservicet = $DB->query($Selectr);
								if ($RSservicet->num_rows > 0) 
								{
									$ty=0;
									while($rowservicet = $RSservicet->fetch_assoc())
									{
										
										$ty++;
										$sercnt=$rowservicet['contoffer'];
										//$seramtseramt=$rowservicet['sumoffer'];
										$serviceamt=$rowservicet['serviceamt'];
										//$totalseramtseramt=$seramtseramt;
										
										
									}
								}
					
					$sqldetailsd=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='3' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.memberid='".$memberid[$i]."' $sqlTempfrom $sqlTempto");
					   $custcnt=$sqldetailsd[0]['COUNT(tblCustomers.CustomerID)'];
					   if($custcnt=='' || $custcnt=='0')
						{
							$custcnt=0;
						}
					if($sercnt=="")
					{
						$sercnt=0;
					}
					else
					{
						$sercnt=$sercnt;
					}
					$totalsercnt +=$sercnt;
					if($custcnt=="")
					{
						$custcnt=0;
					}
					else
					{
						$custcnt=$custcnt;
					}
					$totalcustcnt +=$custcnt;
					if($serviceamt=="")
					{
						$serviceamt=0;
						
					}
					else
					{
						$serviceamt=$serviceamt;
					}
					$toserviceamt +=$serviceamt;
					$Selectrpt="select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID  AND tblAppointments.memberid=tblAppointmentMembershipDiscount.MembershipID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='3' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
				    $RSservicetq = $DB->query($Selectrpt);
								if ($RSservicetq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetq = $RSservicetq->fetch_assoc())
									{
									$sumoffer=$rowservicetq['sumoffer'];
									$totalseramtseramt=$sumoffer;	
									}
								}
					if($totalseramtseramt=="")
					{
						$totalseramtseramt=0;
						
					}
					else
					{
						$totalseramtseramt=$totalseramtseramt;
					}
					$tototalseramtseramt +=$totalseramtseramt;
					
						$sqldetailsdt=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='3' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointments.memberid='".$memberid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto");
					   $oldcustcnt=$sqldetailsdt[0]['COUNT(tblCustomers.CustomerID)'];
					   if($oldcustcnt=='' || $oldcustcnt=='0')
						{
							$oldcustcnt=0;
						}
						 if($oldcustcnt=="")
							 {
								 $oldcustcnt=0;
							 }
							 else
							 {
								 $oldcustcnt=$oldcustcnt;
							 }	
                            $totaloldcustcnt += $oldcustcnt;	
							if($totaloldcustcnt=="")
							{
								$totaloldcustcnt=0;
							}
							else
							{
								$totaloldcustcnt=$totaloldcustcnt;
							}
							$totaltotaloldcustcnt +=$totaloldcustcnt;
						$Selectrptp="select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.memberid=tblAppointmentMembershipDiscount.MembershipID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='3' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
				        $RSservicetqq = $DB->query($Selectrptp);
								if ($RSservicetqq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqq = $RSservicetqq->fetch_assoc())
									{
									$seramtseramtt=$rowservicetqq['sumoffer'];
									$totalseramtseramtold=$seramtseramtt;	
									}
								}
					         if($totalseramtseramtold=="")
							 {
								 $totalseramtseramtold=0;
							 }
							 else
							 {
								 $totalseramtseramtold=$totalseramtseramtold;
							 }	
                            $taltotalseramtseramtold += $totalseramtseramtold;	
                            $newper=($custcnt/$sumcustcnt)*100;
							$expper=($oldcustcnt/$oldcustcntsum)*100;
                            $totacu +=$newper;
	                        $totacuex +=$expper;									
								?>
								<tbody>
								  <tr id="my_data_tr_<?=$counterservice?>">
		                        <td class="numeric"><center><?=$Name?></center></td>
								<td class="numeric"><center><?=$sercnt?></center></td>
								<td class="numeric"><center><?=$serviceamt?></center></td>
								<td class="numeric"><center><?php 
								                          if($custcnt=='')
																{
																	echo $custcnt=0;
																}
																else
																{
																	echo $custcnt;
																}
																
																
								
								                       ?></center></td>
													      <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($newper,2)?></center></td>
																		<?php
																	}
																		?>
									                     <td><center><?php
														  if($totalseramtseramt=='')
																{
																	echo $totalseramtseramt=0;
																}
																else
																{
																	echo $totalseramtseramt;
																}
																
																
														
																?></center></td>
														<td class="numeric"><center><?php 
								                          if($oldcustcnt=='')
																{
																	echo $oldcustcnt=0;
																}
																else
																{
																	echo $oldcustcnt;
																}
																
																
								
								                       ?></center></td>
													     <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($expper,2)?></center></td>
																		<?php
																	}
																		?>
																<td><center><?php
															  if($totalseramtseramtold=="")
																{
																	echo $totalseramtseramtold=0;
																}
																else
																{
																	echo round($totalseramtseramtold);
																}  
																
																?></center></td>
								</tr>
								</tbody>
								<?php
						
					}
					unset($memberid);
					$newcustsum=0;
					$oldcustcntsum=0;				
				      
	
	}
	/* 	$totacu=($totalcustcnt/$totalsercnt)*100;
		$totacuex=($totaloldcustcnt/$totalsercnt)*100; */
	?>
	
						   <tbody>
								<tr>
									<td><center><b>Total Amounts(s)</b></center></td>
									
									<td class="numeric"><center><b><?=$totalsercnt?></b></center></td>
									<td class="numeric"><center><b>Rs. <?=$toserviceamt?>/-</b></center></td>
									<td class="numeric"><center><b><?=$totalcustcnt?></b></center></td>
									   <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($totacu,2)?></center></td>
																		<?php
																	}
																		?>
									<td class="numeric"><center><b>Rs. <?=$tototalseramtseramt?>/-</b></center></td>
									<td class="numeric"><center><b><?=$totaloldcustcnt?></b></center></td>
									  <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center></center></td>
																		<?php
																	}
																		?>
									<td class="numeric"><center><b>Rs. <?=round($taltotalseramtseramtold)?>/-</b></center></td>
									
								</tr>
							</tbody> 
							 </table>
							  <br/>
							 <br/>
							 	<?php
	$totalsercnt="";
	$toserviceamt="";
	$totalcustcnt="";
	$tototalseramtseramt="";
	$totaloldcustcnt="";
	$taltotalseramtseramtold="";
	$totacu="";
	$totacuex="";
	$newcustsum=0;
	$oldcustcntsum=0;		
	/////////////////////////////////////////Oshiwara////////////////
	
	?>
	     <span style="float:left;font-size:14px"><b>Store : Oshiwara</b></span><br/>
	                           <table class="table table-bordered table-striped table-condensed cf">
						        <thead class="cf">
														 
															   <tr>
																<th><center>Discount Type</center></th>
																<th><center>Service Count</center></th>
																<th><center>Service Amount</center></th>
																<th><center>New Client Count</center></th>
																 <?php
																	if($per!='0')
																	{
																		?>
																		<th><center>New Client %</center></th>
																		<?php
																	}
																		?>
																<th><center>New Client Offer/Membership Amount</center></th>
																<th><center>Existing Client Count</center></th>
																 <?php
																	if($per!='0')
																	{
																		?>
																		<th><center>Existing Client %</center></th>
																		<?php
																	}
																		?>
																<th><center>Existing Client Offer/Membership Amount</center></th>
																  
																</tr>
															 
																
							</thead>
						  <?php
	$discounttype=$_GET["discounttype"];
	if($discounttype=='1')
	{
		    $Select="Select distinct(tblAppointments.offerid) from tblAppointments right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='4' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom $sqlTempto";
		
               
				$RSservice = $DB->query($Select);
				if ($RSservice->num_rows > 0) 
				{
					$counterservice = 0;
				   while($rowservice = $RSservice->fetch_assoc())
					{
					
						$offerid[]=$rowservice['offerid'];		
					    
					}
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
								   </tr>
							</tbody>
							

<?php		
				}
				
				for($i=0;$i<count($offerid);$i++)
					{
						$SelectrM="SELECT COUNT(tblCustomers.CustomerID) FROM tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='4' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.offerid='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$RSservicetM = $DB->query($SelectrM);
								if ($RSservicetM->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetM = $RSservicetM->fetch_assoc())
									{
										$newcustsum +=$rowservicetM ['COUNT(tblCustomers.CustomerID)'];
									}
								}
								
							$sqldetailsdt="select COUNT(tblCustomers.CustomerID) from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='4' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointments.offerid='".$offerid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto";
                          $RSservicetqdt = $DB->query($sqldetailsdt);

								if ($RSservicetqdt->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqt = $RSservicetqdt->fetch_assoc())
									{
									$oldcustcntsum +=$rowservicetqt['COUNT(tblCustomers.CustomerID)'];
									
									}
								}
					   
						
					}
					for($i=0;$i<count($offerid);$i++)
					{
						$Selectr="Select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer,count(tblAppointmentMembershipDiscount.ServiceID) as contoffer,SUM(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as serviceamt from tblAppointmentMembershipDiscount left join  tblAppointments on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointmentsDetailsInvoice.ServiceID=tblAppointmentMembershipDiscount.ServiceID where tblAppointments.StoreID='4' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$selp=select("*","tblOffers","OfferID='".$offerid[$i]."'");
						$Name=$selp[0]['OfferName'];
								$RSservicet = $DB->query($Selectr);
								if ($RSservicet->num_rows > 0) 
								{
									$ty=0;
									while($rowservicet = $RSservicet->fetch_assoc())
									{
										
										$ty++;
										$sercnt=$rowservicet['contoffer'];
										//$seramtseramt=$rowservicet['sumoffer'];
										$serviceamt=$rowservicet['serviceamt'];
										//$totalseramtseramt=$seramtseramt;
										
										
									}
								}
					$SelectrM="SELECT COUNT(tblCustomers.CustomerID) FROM tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='4' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.offerid='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$RSservicetM = $DB->query($SelectrM);
								if ($RSservicetM->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetM = $RSservicetM->fetch_assoc())
									{
										$custcnt=$rowservicetM ['COUNT(tblCustomers.CustomerID)'];
									}
								}
					   
					   if($custcnt=='' || $custcnt=='0')
						{
							$custcnt=0;
						}
					if($sercnt=="")
					{
						$sercnt=0;
					}
					else
					{
						$sercnt=$sercnt;
					}
					$totalsercnt +=$sercnt;
					if($custcnt=="")
					{
						$custcnt=0;
					}
					else
					{
						$custcnt=$custcnt;
					}
					$totalcustcnt +=$custcnt;
					if($serviceamt=="")
					{
						$serviceamt=0;
						
					}
					else
					{
						$serviceamt=$serviceamt;
					}
					$toserviceamt +=$serviceamt;
					$Selectrpt="select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.offerid=tblAppointmentMembershipDiscount.OfferID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='4' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
				    $RSservicetq = $DB->query($Selectrpt);
								if ($RSservicetq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetq = $RSservicetq->fetch_assoc())
									{
									$sumoffer=$rowservicetq['sumoffer'];
									$totalseramtseramt=$sumoffer;	
									}
								}
					if($totalseramtseramt=="")
					{
						$totalseramtseramt=0;
						
					}
					else
					{
						$totalseramtseramt=$totalseramtseramt;
					}
					$tototalseramtseramt +=$totalseramtseramt;
					
					$sqldetailsdt="select COUNT(tblCustomers.CustomerID) from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='4' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointments.offerid='".$offerid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto";
                   $RSservicetqdt = $DB->query($sqldetailsdt);

								if ($RSservicetqdt->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqt = $RSservicetqdt->fetch_assoc())
									{
									$oldcustcnt=$rowservicetqt['COUNT(tblCustomers.CustomerID)'];
									
									}
								}
					   
					   if($oldcustcnt=='' || $oldcustcnt=='0')
						{
							$oldcustcnt=0;
						}
						 if($oldcustcnt=="")
							 {
								 $oldcustcnt=0;
							 }
							 else
							 {
								 $oldcustcnt=$oldcustcnt;
							 }	
                            $totaloldcustcnt += $oldcustcnt;	
							if($totaloldcustcnt=="")
							{
								$totaloldcustcnt=0;
							}
							else
							{
								$totaloldcustcnt=$totaloldcustcnt;
							}
							$totaltotaloldcustcnt +=$totaloldcustcnt;
						$Selectrptp="select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.offerid=tblAppointmentMembershipDiscount.OfferID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='4' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."'";
					
				        $RSservicetqq = $DB->query($Selectrptp);
								if ($RSservicetqq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqq = $RSservicetqq->fetch_assoc())
									{
									$seramtseramtt=$rowservicetqq['sumoffer'];
									$totalseramtseramtold=$seramtseramtt;	
									}
								}
					         if($totalseramtseramtold=="")
							 {
								 $totalseramtseramtold=0;
							 }
							 else
							 {
								 $totalseramtseramtold=$totalseramtseramtold;
							 }	
                            $taltotalseramtseramtold += $totalseramtseramtold;	
                            
							 $newper=($custcnt/$newcustsum)*100;
                             $expper=($oldcustcnt/$oldcustcntsum)*100;	
                             $totacu +=$newper;
	                        $totacuex +=$expper;									 
								?>
								  <tbody>
								  <tr id="my_data_tr_<?=$counterservice?>">
		                        <td class="numeric"><center><?=$Name?></center></td>
								<td class="numeric"><center><?=$sercnt?></center></td>
								<td class="numeric"><center><?=$serviceamt?></center></td>
								<td class="numeric"><center><?php 
								                          if($custcnt=='')
																{
																	echo $custcnt=0;
																}
																else
																{
																	echo $custcnt;
																}
																
																
								
								                       ?></center></td>
													     <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($newper,2)?></center></td>
																		<?php
																	}
																		?>
									                     <td><center><?php
														  if($totalseramtseramt=='')
																{
																	echo $totalseramtseramt=0;
																}
																else
																{
																	echo $totalseramtseramt;
																}
																
																
														
																?></center></td>
														<td class="numeric"><center><?php 
								                          if($oldcustcnt=='')
																{
																	echo $oldcustcnt=0;
																}
																else
																{
																	echo $oldcustcnt;
																}
																
																
								
								                       ?></center></td>
													    <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($expper,2)?></center></td>
																		<?php
																	}
																		?>
																<td><center><?php
															  if($totalseramtseramtold=="")
																{
																	echo $totalseramtseramtold=0;
																}
																else
																{
																	echo round($totalseramtseramtold);
																}  
																
																?></center></td>
								</tr>
								  </tbody>
								<?php
						
					}
					unset($offerid);
							
				      
					
					$totalseramtseramt=0;
					$sercnt=0;
					$newcustsum=0;
					$oldcustcntsum=0;		
							
					
				
	}
	else
	{
		
		 $Selectt="Select distinct(tblAppointments.memberid) from tblAppointments right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='4' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom $sqlTempto";
		
               
				$RSservicet = $DB->query($Selectt);
				if ($RSservicet->num_rows > 0) 
				{
					$counterservice = 0;
				   while($rowservicet = $RSservicet->fetch_assoc())
					{
					
						$memberid[]=$rowservicet['memberid'];		
					    
					}
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
								   </tr>
							      </tbody>
							

<?php		
				}
				
				
					for($i=0;$i<count($memberid);$i++)
					{
							$sqldetailsd=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='4' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.memberid='".$memberid[$i]."' $sqlTempfrom $sqlTempto");
					        $sumcustcnt +=$sqldetailsd[0]['COUNT(tblCustomers.CustomerID)'];
						
						$sqldetailsdt=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='4' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointments.memberid='".$memberid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto");
					   $oldcustcntsum +=$sqldetailsdt[0]['COUNT(tblCustomers.CustomerID)'];
					}
					for($i=0;$i<count($memberid);$i++)
					{
						$Selectr="Select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer,count(tblAppointmentMembershipDiscount.ServiceID) as contoffer,SUM(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as serviceamt from tblAppointmentMembershipDiscount left join  tblAppointments on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointmentsDetailsInvoice.ServiceID=tblAppointmentMembershipDiscount.ServiceID where tblAppointments.StoreID='4' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
					    $selp=select("*","tblMembership","MembershipID='".$memberid[$i]."'");
					    $Name=$selp[0]['MembershipName'];
					
								$RSservicet = $DB->query($Selectr);
								if ($RSservicet->num_rows > 0) 
								{
									$ty=0;
									while($rowservicet = $RSservicet->fetch_assoc())
									{
										
										$ty++;
										$sercnt=$rowservicet['contoffer'];
										//$seramtseramt=$rowservicet['sumoffer'];
										$serviceamt=$rowservicet['serviceamt'];
										//$totalseramtseramt=$seramtseramt;
										
										
									}
								}
					
					$sqldetailsd=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='4' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.memberid='".$memberid[$i]."' $sqlTempfrom $sqlTempto");
					   $custcnt=$sqldetailsd[0]['COUNT(tblCustomers.CustomerID)'];
					   if($custcnt=='' || $custcnt=='0')
						{
							$custcnt=0;
						}
					if($sercnt=="")
					{
						$sercnt=0;
					}
					else
					{
						$sercnt=$sercnt;
					}
					$totalsercnt +=$sercnt;
					if($custcnt=="")
					{
						$custcnt=0;
					}
					else
					{
						$custcnt=$custcnt;
					}
					$totalcustcnt +=$custcnt;
					if($serviceamt=="")
					{
						$serviceamt=0;
						
					}
					else
					{
						$serviceamt=$serviceamt;
					}
					$toserviceamt +=$serviceamt;
					$Selectrpt="select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID  AND tblAppointments.memberid=tblAppointmentMembershipDiscount.MembershipID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='4' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
				    $RSservicetq = $DB->query($Selectrpt);
								if ($RSservicetq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetq = $RSservicetq->fetch_assoc())
									{
									$sumoffer=$rowservicetq['sumoffer'];
									$totalseramtseramt=$sumoffer;	
									}
								}
					if($totalseramtseramt=="")
					{
						$totalseramtseramt=0;
						
					}
					else
					{
						$totalseramtseramt=$totalseramtseramt;
					}
					$tototalseramtseramt +=$totalseramtseramt;
					
						$sqldetailsdt=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='4' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointments.memberid='".$memberid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto");
					   $oldcustcnt=$sqldetailsdt[0]['COUNT(tblCustomers.CustomerID)'];
					   if($oldcustcnt=='' || $oldcustcnt=='0')
						{
							$oldcustcnt=0;
						}
						 if($oldcustcnt=="")
							 {
								 $oldcustcnt=0;
							 }
							 else
							 {
								 $oldcustcnt=$oldcustcnt;
							 }	
                            $totaloldcustcnt += $oldcustcnt;	
							if($totaloldcustcnt=="")
							{
								$totaloldcustcnt=0;
							}
							else
							{
								$totaloldcustcnt=$totaloldcustcnt;
							}
							$totaltotaloldcustcnt +=$totaloldcustcnt;
						$Selectrptp="select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.memberid=tblAppointmentMembershipDiscount.MembershipID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='4' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
				        $RSservicetqq = $DB->query($Selectrptp);
								if ($RSservicetqq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqq = $RSservicetqq->fetch_assoc())
									{
									$seramtseramtt=$rowservicetqq['sumoffer'];
									$totalseramtseramtold=$seramtseramtt;	
									}
								}
					         if($totalseramtseramtold=="")
							 {
								 $totalseramtseramtold=0;
							 }
							 else
							 {
								 $totalseramtseramtold=$totalseramtseramtold;
							 }	
                            $taltotalseramtseramtold += $totalseramtseramtold;	
                            
							 $newper=($custcnt/$sumcustcnt)*100;
                             $expper=($oldcustcnt/$oldcustcntsum)*100;		
                            $totacu +=$newper;
	                        $totacuex +=$expper;									 
								?>
								<tbody>
								  <tr id="my_data_tr_<?=$counterservice?>">
		                        <td class="numeric"><center><?=$Name?></center></td>
								<td class="numeric"><center><?=$sercnt?></center></td>
								<td class="numeric"><center><?=$serviceamt?></center></td>
								<td class="numeric"><center><?php 
								                          if($custcnt=='')
																{
																	echo $custcnt=0;
																}
																else
																{
																	echo $custcnt;
																}
																
																
								
								                       ?></center></td>
													     <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($newper,2)?></center></td>
																		<?php
																	}
																		?>
									                     <td><center><?php
														  if($totalseramtseramt=='')
																{
																	echo $totalseramtseramt=0;
																}
																else
																{
																	echo $totalseramtseramt;
																}
																
																
														
																?></center></td>
														<td class="numeric"><center><?php 
								                          if($oldcustcnt=='')
																{
																	echo $oldcustcnt=0;
																}
																else
																{
																	echo $oldcustcnt;
																}
																
																
								
								                       ?></center></td>
													   <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($expper,2)?></center></td>
																		<?php
																	}
																		?>
																<td><center><?php
															  if($totalseramtseramtold=="")
																{
																	echo $totalseramtseramtold=0;
																}
																else
																{
																	echo round($totalseramtseramtold);
																}  
																
																?></center></td>
								</tr>
								</tbody>
								<?php
						
					}
					unset($memberid);
					$newcustsum=0;
					$oldcustcntsum=0;				
				      
	
	}
	/* $totacu=($totalcustcnt/$totalsercnt)*100;
	$totacuexp=($totaloldcustcnt/$totalsercnt)*100; */
	?>
	
						   <tbody>
								<tr>
									<td><center><b>Total Amounts(s)</b></center></td>
									
									<td class="numeric"><center><b><?=$totalsercnt?></b></center></td>
									<td class="numeric"><center><b>Rs. <?=$toserviceamt?>/-</b></center></td>
									<td class="numeric"><center><b><?=$totalcustcnt?></b></center></td>
									<?php
																	if($per!='0')
																	{
																		?>
															<td class="numeric"><center><b><?=round($totacu,2)?></b></center></td>
																		<?php
																	}
																		?>
									<td class="numeric"><center><b>Rs. <?=$tototalseramtseramt?>/-</b></center></td>
									<td class="numeric"><center><b><?=$totaloldcustcnt?></b></center></td>
									<?php
																	if($per!='0')
																	{
																		?>
															<td class="numeric"><center><b></b></center></td>
																		<?php
																	}
																		?>
									<td class="numeric"><center><b>Rs. <?=round($taltotalseramtseramtold)?>/-</b></center></td>
									
								</tr>
							</tbody> 
							 </table>
							 <br/>
							 <br/>
		<?php
	$totalsercnt="";
	$toserviceamt="";
	$totalcustcnt="";
	$tototalseramtseramt="";
	$totaloldcustcnt="";
	$taltotalseramtseramtold="";		
    $totacu="";
	$totacuexp="";
	$newcustsum=0;
    $oldcustcntsum=0;		
	/////////////////////////////////////////Lokhandwala////////////////
	
	?>
	     <span style="float:left;font-size:14px"><b>Store : Lokhandwala</b></span><br/>
	                           <table class="table table-bordered table-striped table-condensed cf">
						        <thead class="cf">
														 
															   <tr>
																<th><center>Discount Type</center></th>
																<th><center>Service Count</center></th>
																<th><center>Service Amount</center></th>
																<th><center>New Client Count</center></th>
																<?php
																	if($per!='0')
																	{
																		?>
																		<th><center>New Client %</center></th>
																		<?php
																	}
																		?>
																<th><center>New Client Offer/Membership Amount</center></th>
																<th><center>Existing Client Count</center></th>
																	<?php
																	if($per!='0')
																	{
																		?>
																		<th><center>Existing Client %</center></th>
																		<?php
																	}
																		?>
																<th><center>Existing Client Offer/Membership Amount</center></th>
																</tr>
															 
																
							</thead>
						  <?php
	$discounttype=$_GET["discounttype"];
	if($discounttype=='1')
	{
		    $Select="Select distinct(tblAppointments.offerid) from tblAppointments right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='5' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom $sqlTempto";
		
               
				$RSservice = $DB->query($Select);
				if ($RSservice->num_rows > 0) 
				{
					$counterservice = 0;
				   while($rowservice = $RSservice->fetch_assoc())
					{
					
						$offerid[]=$rowservice['offerid'];		
					    
					}
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
								   </tr>
							</tbody>
							

<?php		
				}
					for($i=0;$i<count($offerid);$i++)
					{
						$SelectrM="SELECT COUNT(tblCustomers.CustomerID) FROM tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='5' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.offerid='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$RSservicetM = $DB->query($SelectrM);
								if ($RSservicetM->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetM = $RSservicetM->fetch_assoc())
									{
										$newcustsum +=$rowservicetM ['COUNT(tblCustomers.CustomerID)'];
									}
								}
								
							$sqldetailsdt="select COUNT(tblCustomers.CustomerID) from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='5' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointments.offerid='".$offerid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto";
                          $RSservicetqdt = $DB->query($sqldetailsdt);

								if ($RSservicetqdt->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqt = $RSservicetqdt->fetch_assoc())
									{
									$oldcustcntsum +=$rowservicetqt['COUNT(tblCustomers.CustomerID)'];
									
									}
								}
					   
						
					}
					for($i=0;$i<count($offerid);$i++)
					{
						$Selectr="Select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer,count(tblAppointmentMembershipDiscount.ServiceID) as contoffer,SUM(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as serviceamt from tblAppointmentMembershipDiscount left join  tblAppointments on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointmentsDetailsInvoice.ServiceID=tblAppointmentMembershipDiscount.ServiceID where tblAppointments.StoreID='5' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$selp=select("*","tblOffers","OfferID='".$offerid[$i]."'");
						$Name=$selp[0]['OfferName'];
								$RSservicet = $DB->query($Selectr);
								if ($RSservicet->num_rows > 0) 
								{
									$ty=0;
									while($rowservicet = $RSservicet->fetch_assoc())
									{
										
										$ty++;
										$sercnt=$rowservicet['contoffer'];
										//$seramtseramt=$rowservicet['sumoffer'];
										$serviceamt=$rowservicet['serviceamt'];
										//$totalseramtseramt=$seramtseramt;
										
										
									}
								}
					$SelectrM="SELECT COUNT(tblCustomers.CustomerID) FROM tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='5' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.offerid='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$RSservicetM = $DB->query($SelectrM);
								if ($RSservicetM->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetM = $RSservicetM->fetch_assoc())
									{
										$custcnt=$rowservicetM ['COUNT(tblCustomers.CustomerID)'];
									}
								}
					   
					   if($custcnt=='' || $custcnt=='0')
						{
							$custcnt=0;
						}
					if($sercnt=="")
					{
						$sercnt=0;
					}
					else
					{
						$sercnt=$sercnt;
					}
					$totalsercnt +=$sercnt;
					if($custcnt=="")
					{
						$custcnt=0;
					}
					else
					{
						$custcnt=$custcnt;
					}
					$totalcustcnt +=$custcnt;
					if($serviceamt=="")
					{
						$serviceamt=0;
						
					}
					else
					{
						$serviceamt=$serviceamt;
					}
					$toserviceamt +=$serviceamt;
					$Selectrpt="select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.offerid=tblAppointmentMembershipDiscount.OfferID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='5' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
				    $RSservicetq = $DB->query($Selectrpt);
								if ($RSservicetq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetq = $RSservicetq->fetch_assoc())
									{
									$sumoffer=$rowservicetq['sumoffer'];
									$totalseramtseramt=$sumoffer;	
									}
								}
					if($totalseramtseramt=="")
					{
						$totalseramtseramt=0;
						
					}
					else
					{
						$totalseramtseramt=$totalseramtseramt;
					}
					$tototalseramtseramt +=$totalseramtseramt;
					
					$sqldetailsdt="select COUNT(tblCustomers.CustomerID) from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='5' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointments.offerid='".$offerid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto";
                   $RSservicetqdt = $DB->query($sqldetailsdt);

								if ($RSservicetqdt->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqt = $RSservicetqdt->fetch_assoc())
									{
									$oldcustcnt=$rowservicetqt['COUNT(tblCustomers.CustomerID)'];
									
									}
								}
					   
					   if($oldcustcnt=='' || $oldcustcnt=='0')
						{
							$oldcustcnt=0;
						}
						 if($oldcustcnt=="")
							 {
								 $oldcustcnt=0;
							 }
							 else
							 {
								 $oldcustcnt=$oldcustcnt;
							 }	
                            $totaloldcustcnt += $oldcustcnt;	
							if($totaloldcustcnt=="")
							{
								$totaloldcustcnt=0;
							}
							else
							{
								$totaloldcustcnt=$totaloldcustcnt;
							}
							$totaltotaloldcustcnt +=$totaloldcustcnt;
						$Selectrptp="select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.offerid=tblAppointmentMembershipDiscount.OfferID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='5' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."'";
					
				        $RSservicetqq = $DB->query($Selectrptp);
								if ($RSservicetqq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqq = $RSservicetqq->fetch_assoc())
									{
									$seramtseramtt=$rowservicetqq['sumoffer'];
									$totalseramtseramtold=$seramtseramtt;	
									}
								}
					         if($totalseramtseramtold=="")
							 {
								 $totalseramtseramtold=0;
							 }
							 else
							 {
								 $totalseramtseramtold=$totalseramtseramtold;
							 }	
                            $taltotalseramtseramtold += $totalseramtseramtold;	
                            $newper=($custcnt/$newcustsum)*100;
							$expperyo=($oldcustcnt/$oldcustcntsum)*100;
                            $totacu +=$newper;
	                        $totacuex +=$expperyo;									
								?>
								  <tbody>
								  <tr id="my_data_tr_<?=$counterservice?>">
		                        <td class="numeric"><center><?=$Name?></center></td>
								<td class="numeric"><center><?=$sercnt?></center></td>
								<td class="numeric"><center><?=$serviceamt?></center></td>
								<td class="numeric"><center><?php 
								                          if($custcnt=='')
																{
																	echo $custcnt=0;
																}
																else
																{
																	echo $custcnt;
																}
																
																
								
								                       ?></center></td>
													        <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($newper,2)?></center></td>
																		<?php
																	}
																		?>
									                     <td><center><?php
														  if($totalseramtseramt=='')
																{
																	echo $totalseramtseramt=0;
																}
																else
																{
																	echo $totalseramtseramt;
																}
																
																
														
																?></center></td>
														<td class="numeric"><center><?php 
								                          if($oldcustcnt=='')
																{
																	echo $oldcustcnt=0;
																}
																else
																{
																	echo $oldcustcnt;
																}
																
																
								
								                       ?></center></td>
													    <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($expperyo,2)?></center></td>
																		<?php
																	}
																		?>
																<td><center><?php
															  if($totalseramtseramtold=="")
																{
																	echo $totalseramtseramtold=0;
																}
																else
																{
																	echo round($totalseramtseramtold);
																}  
																
																?></center></td>
								</tr>
								  </tbody>
								<?php
						
					}
					unset($offerid);
							
				      
					
					$totalseramtseramt=0;
					$sercnt=0;
					$newcustsum=0;
					$oldcustcntsum=0;		
							
					
				
	}
	else
	{
		
		 $Selectt="Select distinct(tblAppointments.memberid) from tblAppointments right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='5' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom $sqlTempto";
		
               
				$RSservicet = $DB->query($Selectt);
				if ($RSservicet->num_rows > 0) 
				{
					$counterservice = 0;
				   while($rowservicet = $RSservicet->fetch_assoc())
					{
					
						$memberid[]=$rowservicet['memberid'];		
					    
					}
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
								   </tr>
							      </tbody>
							

<?php		
				}
				for($i=0;$i<count($memberid);$i++)
					{
							$sqldetailsd=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='5' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.memberid='".$memberid[$i]."' $sqlTempfrom $sqlTempto");
					        $sumcustcnt +=$sqldetailsd[0]['COUNT(tblCustomers.CustomerID)'];
						
						$sqldetailsdt=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='5' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointments.memberid='".$memberid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto");
					   $oldcustcntsum +=$sqldetailsdt[0]['COUNT(tblCustomers.CustomerID)'];
					}
				
					for($i=0;$i<count($memberid);$i++)
					{
						$Selectr="Select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer,count(tblAppointmentMembershipDiscount.ServiceID) as contoffer,SUM(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as serviceamt from tblAppointmentMembershipDiscount left join  tblAppointments on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointmentsDetailsInvoice.ServiceID=tblAppointmentMembershipDiscount.ServiceID where tblAppointments.StoreID='5' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
					    $selp=select("*","tblMembership","MembershipID='".$memberid[$i]."'");
					    $Name=$selp[0]['MembershipName'];
					
								$RSservicet = $DB->query($Selectr);
								if ($RSservicet->num_rows > 0) 
								{
									$ty=0;
									while($rowservicet = $RSservicet->fetch_assoc())
									{
										
										$ty++;
										$sercnt=$rowservicet['contoffer'];
										//$seramtseramt=$rowservicet['sumoffer'];
										$serviceamt=$rowservicet['serviceamt'];
										//$totalseramtseramt=$seramtseramt;
										
										
									}
								}
					
					$sqldetailsd=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='5' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.memberid='".$memberid[$i]."' $sqlTempfrom $sqlTempto");
					   $custcnt=$sqldetailsd[0]['COUNT(tblCustomers.CustomerID)'];
					   if($custcnt=='' || $custcnt=='0')
						{
							$custcnt=0;
						}
					if($sercnt=="")
					{
						$sercnt=0;
					}
					else
					{
						$sercnt=$sercnt;
					}
					$totalsercnt +=$sercnt;
					if($custcnt=="")
					{
						$custcnt=0;
					}
					else
					{
						$custcnt=$custcnt;
					}
					$totalcustcnt +=$custcnt;
					if($serviceamt=="")
					{
						$serviceamt=0;
						
					}
					else
					{
						$serviceamt=$serviceamt;
					}
					$toserviceamt +=$serviceamt;
					$Selectrpt="select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID  AND tblAppointments.memberid=tblAppointmentMembershipDiscount.MembershipID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='5' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
				    $RSservicetq = $DB->query($Selectrpt);
								if ($RSservicetq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetq = $RSservicetq->fetch_assoc())
									{
									$sumoffer=$rowservicetq['sumoffer'];
									$totalseramtseramt=$sumoffer;	
									}
								}
					if($totalseramtseramt=="")
					{
						$totalseramtseramt=0;
						
					}
					else
					{
						$totalseramtseramt=$totalseramtseramt;
					}
					$tototalseramtseramt +=$totalseramtseramt;
					
						$sqldetailsdt=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='5' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointments.memberid='".$memberid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto");
					   $oldcustcnt=$sqldetailsdt[0]['COUNT(tblCustomers.CustomerID)'];
					   if($oldcustcnt=='' || $oldcustcnt=='0')
						{
							$oldcustcnt=0;
						}
						 if($oldcustcnt=="")
							 {
								 $oldcustcnt=0;
							 }
							 else
							 {
								 $oldcustcnt=$oldcustcnt;
							 }	
                            $totaloldcustcnt += $oldcustcnt;	
							if($totaloldcustcnt=="")
							{
								$totaloldcustcnt=0;
							}
							else
							{
								$totaloldcustcnt=$totaloldcustcnt;
							}
							$totaltotaloldcustcnt +=$totaloldcustcnt;
						$Selectrptp="select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.memberid=tblAppointmentMembershipDiscount.MembershipID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='5' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
				        $RSservicetqq = $DB->query($Selectrptp);
								if ($RSservicetqq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqq = $RSservicetqq->fetch_assoc())
									{
									$seramtseramtt=$rowservicetqq['sumoffer'];
									$totalseramtseramtold=$seramtseramtt;	
									}
								}
					         if($totalseramtseramtold=="")
							 {
								 $totalseramtseramtold=0;
							 }
							 else
							 {
								 $totalseramtseramtold=$totalseramtseramtold;
							 }	
                            $taltotalseramtseramtold += $totalseramtseramtold;	
                            $newper=($custcnt/$sumcustcnt)*100;
							$exppertu=($oldcustcnt/$oldcustcntsum)*100;
                            $totacu +=$newper;
	                        $totacuex +=$exppertu;							
								?>
								<tbody>
								  <tr id="my_data_tr_<?=$counterservice?>">
		                        <td class="numeric"><center><?=$Name?></center></td>
								<td class="numeric"><center><?=$sercnt?></center></td>
								<td class="numeric"><center><?=$serviceamt?></center></td>
								<td class="numeric"><center><?php 
								                          if($custcnt=='')
																{
																	echo $custcnt=0;
																}
																else
																{
																	echo $custcnt;
																}
																
																
								
								                       ?></center></td>
													    <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($newper,2)?></center></td>
																		<?php
																	}
																		?>
									                     <td><center><?php
														  if($totalseramtseramt=='')
																{
																	echo $totalseramtseramt=0;
																}
																else
																{
																	echo $totalseramtseramt;
																}
																
																
														
																?></center></td>
														<td class="numeric"><center><?php 
								                          if($oldcustcnt=='')
																{
																	echo $oldcustcnt=0;
																}
																else
																{
																	echo $oldcustcnt;
																}
																
																
								
								                       ?></center></td>
													     <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($exppertu,2)?></center></td>
																		<?php
																	}
																		?>
																<td><center><?php
															  if($totalseramtseramtold=="")
																{
																	echo $totalseramtseramtold=0;
																}
																else
																{
																	echo round($totalseramtseramtold);
																}  
																
																?></center></td>
								</tr>
								</tbody>
								<?php
						
					}
					unset($memberid);
					$newcustsum=0;
					$oldcustcntsum=0;				
				      
	
	}
	
	?>
	
						   <tbody>
								<tr>
									<td><center><b>Total Amounts(s)</b></center></td>
									
									<td class="numeric"><center><b><?=$totalsercnt?></b></center></td>
									<td class="numeric"><center><b>Rs. <?=$toserviceamt?>/-</b></center></td>
									<td class="numeric"><center><b><?=$totalcustcnt?></b></center></td>
									   <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center><?php echo round($totacu,2)?></center></td>
																		<?php
																	}
																		?>
									<td class="numeric"><center><b>Rs. <?=$tototalseramtseramt?>/-</b></center></td>
									<td class="numeric"><center><b><?=$totaloldcustcnt?></b></center></td>
									   <?php
																	if($per!='0')
																	{
																		?>
																	<td class="numeric"><center></center></td>
																		<?php
																	}
																		?>
									<td class="numeric"><center><b>Rs. <?=round($taltotalseramtseramtold)?>/-</b></center></td>
									
								</tr>
							</tbody> 
							 </table>
	<?php
	$totalsercnt="";
	$toserviceamt="";
	$totalcustcnt="";
	$tototalseramtseramt="";
	$totaloldcustcnt="";
	$taltotalseramtseramtold="";
	$totacu="";
	$totacuex="";
	$newcustsum=0;
	$oldcustcntsum=0;		
	}
	else
	{
		?>
		 <table class="table table-bordered table-striped table-condensed cf">
						                                   <thead class="cf">
														 
															   <tr>
																<th><center>Discount Type</center></th>
																<th><center>Service Count</center></th>
																<th><center>Service Amount</center></th>
																<th><center>New Client Count</center></th>	
																<?php
																	if($per!='0')
																	{
																		?>
																<th><center>New Client %</center></th>
																<?php
																	}
																?>
																<th><center>New Client Offer/Membership Amount</center></th>
																<th><center>Existing Client Count</center></th>
																	<?php
																	if($per!='0')
																	{
																		?>
																	<th><center>Existing Client %</center></th>	
																		<?php
																	}
																?>
																<th><center>Existing Client Offer/Membership Amount</center></th>
																</tr>
															 
																
															</thead>
	<?php
	$discounttype=$_GET["discounttype"];
	if($discounttype=='1')
	{
		    $Select="Select distinct(tblAppointments.offerid) from tblAppointments right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom $sqlTempto";
		
               
				$RSservice = $DB->query($Select);
				if ($RSservice->num_rows > 0) 
				{
					$counterservice = 0;
				   while($rowservice = $RSservice->fetch_assoc())
					{
					
						$offerid[]=$rowservice['offerid'];		
					    
					}
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
					for($i=0;$i<count($offerid);$i++)
					{
						$SelectrM="SELECT COUNT(tblCustomers.CustomerID) FROM tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.offerid='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$RSservicetM = $DB->query($SelectrM);
								if ($RSservicetM->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetM = $RSservicetM->fetch_assoc())
									{
										$custcntsum +=$rowservicetM ['COUNT(tblCustomers.CustomerID)'];
									}
								}
						
							$sqldetailsdt="select COUNT(tblCustomers.CustomerID) from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointments.offerid='".$offerid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto";
                          $RSservicetqdt = $DB->query($sqldetailsdt);

								if ($RSservicetqdt->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqt = $RSservicetqdt->fetch_assoc())
									{
									$oldcustcntsum +=$rowservicetqt['COUNT(tblCustomers.CustomerID)'];
									
									}
								}
					}
				
					for($i=0;$i<count($offerid);$i++)
					{
						$Selectr="Select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer,count(tblAppointmentMembershipDiscount.ServiceID) as contoffer,SUM(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as serviceamt from tblAppointmentMembershipDiscount left join  tblAppointments on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointmentsDetailsInvoice.ServiceID=tblAppointmentMembershipDiscount.ServiceID where tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$selp=select("*","tblOffers","OfferID='".$offerid[$i]."'");
						$Name=$selp[0]['OfferName'];
								$RSservicet = $DB->query($Selectr);
								if ($RSservicet->num_rows > 0) 
								{
									$ty=0;
									while($rowservicet = $RSservicet->fetch_assoc())
									{
										
										$ty++;
										$sercnt=$rowservicet['contoffer'];
										//$seramtseramt=$rowservicet['sumoffer'];
										$serviceamt=$rowservicet['serviceamt'];
										//$totalseramtseramt=$seramtseramt;
										
										
									}
								}
					$SelectrM="SELECT COUNT(tblCustomers.CustomerID) FROM tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.offerid='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$RSservicetM = $DB->query($SelectrM);
								if ($RSservicetM->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetM = $RSservicetM->fetch_assoc())
									{
										$custcnt=$rowservicetM ['COUNT(tblCustomers.CustomerID)'];
									}
								}
					   
					   if($custcnt=='' || $custcnt=='0')
						{
							$custcnt=0;
						}
					if($sercnt=="")
					{
						$sercnt=0;
					}
					else
					{
						$sercnt=$sercnt;
					}
					$totalsercnt +=$sercnt;
					if($custcnt=="")
					{
						$custcnt=0;
					}
					else
					{
						$custcnt=$custcnt;
					}
					$totalcustcnt +=$custcnt;
					if($serviceamt=="")
					{
						$serviceamt=0;
						
					}
					else
					{
						$serviceamt=$serviceamt;
					}
					$toserviceamt +=$serviceamt;
					$Selectrpt="select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.offerid=tblAppointmentMembershipDiscount.OfferID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
				    $RSservicetq = $DB->query($Selectrpt);
								if ($RSservicetq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetq = $RSservicetq->fetch_assoc())
									{
									$sumoffer=$rowservicetq['sumoffer'];
									$totalseramtseramt=$sumoffer;	
									}
								}
					if($totalseramtseramt=="")
					{
						$totalseramtseramt=0;
						
					}
					else
					{
						$totalseramtseramt=$totalseramtseramt;
					}
					$tototalseramtseramt +=$totalseramtseramt;
					
					$sqldetailsdt="select COUNT(tblCustomers.CustomerID) from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointments.offerid='".$offerid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto";
                   $RSservicetqdt = $DB->query($sqldetailsdt);

								if ($RSservicetqdt->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqt = $RSservicetqdt->fetch_assoc())
									{
									$oldcustcnt=$rowservicetqt['COUNT(tblCustomers.CustomerID)'];
									
									}
								}
					   
					   if($oldcustcnt=='' || $oldcustcnt=='0')
						{
							$oldcustcnt=0;
						}
						 if($oldcustcnt=="")
							 {
								 $oldcustcnt=0;
							 }
							 else
							 {
								 $oldcustcnt=$oldcustcnt;
							 }	
                            $totaloldcustcnt += $oldcustcnt;	
							if($totaloldcustcnt=="")
							{
								$totaloldcustcnt=0;
							}
							else
							{
								$totaloldcustcnt=$totaloldcustcnt;
							}
							$totaltotaloldcustcnt +=$totaloldcustcnt;
						$Selectrptp="select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.offerid=tblAppointmentMembershipDiscount.OfferID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."'";
					
				        $RSservicetqq = $DB->query($Selectrptp);
								if ($RSservicetqq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqq = $RSservicetqq->fetch_assoc())
									{
									$seramtseramtt=$rowservicetqq['sumoffer'];
									$totalseramtseramtold=$seramtseramtt;	
									}
								}
					         if($totalseramtseramtold=="")
							 {
								 $totalseramtseramtold=0;
							 }
							 else
							 {
								 $totalseramtseramtold=$totalseramtseramtold;
							 }	
                            $taltotalseramtseramtold += $totalseramtseramtold;	
                            $newper=($custcnt/$custcntsum)*100;
							$exper=($oldcustcnt/$oldcustcntsum)*100;
                            		$totaltnewcnt +=$newper;
	                                 $totaltoldcnt +=$exper;					
								?>
								  <tbody>
								  <tr id="my_data_tr_<?=$counterservice?>">
		                        <td class="numeric"><center><?=$Name?></center></td>
								<td class="numeric"><center><?=$sercnt?></center></td>
								<td class="numeric"><center><?=$serviceamt?></center></td>
								<td class="numeric"><center><?php 
								                          if($custcnt=='')
																{
																	echo $custcnt=0;
																}
																else
																{
																	echo $custcnt;
																}
																
																
								
								                       ?></center></td>
													   <?php
																	if($per!='0')
																	{
																		?>
																		<td class="numeric"><center><?php echo round($newper,2);?>
																		</td>
																		<?php
																	}
																	?>
									                     <td><center><?php
														  if($totalseramtseramt=='')
																{
																	echo $totalseramtseramt=0;
																}
																else
																{
																	echo $totalseramtseramt;
																}
																
																
														
																?></center></td>
														<td class="numeric"><center><?php 
								                          if($oldcustcnt=='')
																{
																	echo $oldcustcnt=0;
																}
																else
																{
																	echo $oldcustcnt;
																}
																
																
								
								                       ?></center></td>
													     <?php
																	if($per!='0')
																	{
																		?>
																		<td class="numeric"><center><?php echo round($exper,2);?>
																		</td>
																		<?php
																	}
																	?>
																<td><center><?php
															  if($totalseramtseramtold=="")
																{
																	echo $totalseramtseramtold=0;
																}
																else
																{
																	echo round($totalseramtseramtold);
																}  
																
																?></center></td>
								</tr>
								  </tbody>
								<?php
						
					}
					unset($offerid);
							
				      
					
					$totalseramtseramt=0;
					$sercnt=0;
					
							
					
				
	}
	else
	{
		
		 $Selectt="Select distinct(tblAppointments.memberid) from tblAppointments right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom $sqlTempto";
		
               
				$RSservicet = $DB->query($Selectt);
				if ($RSservicet->num_rows > 0) 
				{
					$counterservice = 0;
				   while($rowservicet = $RSservicet->fetch_assoc())
					{
					
						$memberid[]=$rowservicet['memberid'];		
					    
					}
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
				
				
					for($i=0;$i<count($memberid);$i++)
					{
						$sqldetailsd=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.memberid='".$memberid[$i]."' $sqlTempfrom $sqlTempto");
					    $custcntsum +=$sqldetailsd[0]['COUNT(tblCustomers.CustomerID)'];
						
						$sqldetailsdt=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointments.memberid='".$memberid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto");
					    $oldcustcntsum +=$sqldetailsdt[0]['COUNT(tblCustomers.CustomerID)'];
					}
				
				
					for($i=0;$i<count($memberid);$i++)
					{
						$Selectr="Select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer,count(tblAppointmentMembershipDiscount.ServiceID) as contoffer,SUM(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as serviceamt from tblAppointmentMembershipDiscount left join  tblAppointments on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointmentsDetailsInvoice.ServiceID=tblAppointmentMembershipDiscount.ServiceID where tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
					    $selp=select("*","tblMembership","MembershipID='".$memberid[$i]."'");
					    $Name=$selp[0]['MembershipName'];
					
								$RSservicet = $DB->query($Selectr);
								if ($RSservicet->num_rows > 0) 
								{
									$ty=0;
									while($rowservicet = $RSservicet->fetch_assoc())
									{
										
										$ty++;
										$sercnt=$rowservicet['contoffer'];
										//$seramtseramt=$rowservicet['sumoffer'];
										$serviceamt=$rowservicet['serviceamt'];
										//$totalseramtseramt=$seramtseramt;
										
										
									}
								}
					
					$sqldetailsd=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.memberid='".$memberid[$i]."' $sqlTempfrom $sqlTempto");
					   $custcnt=$sqldetailsd[0]['COUNT(tblCustomers.CustomerID)'];
					   if($custcnt=='' || $custcnt=='0')
						{
							$custcnt=0;
						}
					if($sercnt=="")
					{
						$sercnt=0;
					}
					else
					{
						$sercnt=$sercnt;
					}
					$totalsercnt +=$sercnt;
					if($custcnt=="")
					{
						$custcnt=0;
					}
					else
					{
						$custcnt=$custcnt;
					}
					$totalcustcnt +=$custcnt;
					if($serviceamt=="")
					{
						$serviceamt=0;
						
					}
					else
					{
						$serviceamt=$serviceamt;
					}
					$toserviceamt +=$serviceamt;
					$Selectrpt="select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID  AND tblAppointments.memberid=tblAppointmentMembershipDiscount.MembershipID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
				    $RSservicetq = $DB->query($Selectrpt);
								if ($RSservicetq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetq = $RSservicetq->fetch_assoc())
									{
									$sumoffer=$rowservicetq['sumoffer'];
									$totalseramtseramt=$sumoffer;	
									}
								}
					if($totalseramtseramt=="")
					{
						$totalseramtseramt=0;
						
					}
					else
					{
						$totalseramtseramt=$totalseramtseramt;
					}
					$tototalseramtseramt +=$totalseramtseramt;
					
						$sqldetailsdt=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointments.memberid='".$memberid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto");
					   $oldcustcnt=$sqldetailsdt[0]['COUNT(tblCustomers.CustomerID)'];
					   if($oldcustcnt=='' || $oldcustcnt=='0')
						{
							$oldcustcnt=0;
						}
						 if($oldcustcnt=="")
							 {
								 $oldcustcnt=0;
							 }
							 else
							 {
								 $oldcustcnt=$oldcustcnt;
							 }	
                            $totaloldcustcnt += $oldcustcnt;	
							if($totaloldcustcnt=="")
							{
								$totaloldcustcnt=0;
							}
							else
							{
								$totaloldcustcnt=$totaloldcustcnt;
							}
							$totaltotaloldcustcnt +=$totaloldcustcnt;
						$Selectrptp="select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.memberid=tblAppointmentMembershipDiscount.MembershipID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
				        $RSservicetqq = $DB->query($Selectrptp);
								if ($RSservicetqq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqq = $RSservicetqq->fetch_assoc())
									{
									$seramtseramtt=$rowservicetqq['sumoffer'];
									$totalseramtseramtold=$seramtseramtt;	
									}
								}
					         if($totalseramtseramtold=="")
							 {
								 $totalseramtseramtold=0;
							 }
							 else
							 {
								 $totalseramtseramtold=$totalseramtseramtold;
							 }	
                            $taltotalseramtseramtold += $totalseramtseramtold;	
                             $newper=($custcnt/$custcntsum)*100;
							$exper=($oldcustcnt/$oldcustcntsum)*100;
							$totaltnewcnt +=$newper;
	                        $totaltoldcnt +=$exper;
                            							
								?>
								<tbody>
								  <tr id="my_data_tr_<?=$counterservice?>">
		                        <td class="numeric"><center><?=$Name?></center></td>
								<td class="numeric"><center><?=$sercnt?></center></td>
								<td class="numeric"><center><?=$serviceamt?></center></td>
								<td class="numeric"><center><?php 
								                          if($custcnt=='')
																{
																	echo $custcnt=0;
																}
																else
																{
																	echo $custcnt;
																}
																
																
								
								                       ?></center></td>
													    <?php
																	if($per!='0')
																	{
																		?>
																		<td class="numeric"><center><?php echo round($newper,2);?>
																		</td>
																		<?php
																	}
																	?>
									                     <td><center><?php
														  if($totalseramtseramt=='')
																{
																	echo $totalseramtseramt=0;
																}
																else
																{
																	echo $totalseramtseramt;
																}
																
																
														
																?></center></td>
														<td class="numeric"><center><?php 
								                          if($oldcustcnt=='')
																{
																	echo $oldcustcnt=0;
																}
																else
																{
																	echo $oldcustcnt;
																}
																
																
								
								                       ?></center></td>
													    <?php
																	if($per!='0')
																	{
																		?>
																		<td class="numeric"><center><?php echo round($exper,2);?>
																		</td>
																		<?php
																	}
																	?>
																<td><center><?php
															  if($totalseramtseramtold=="")
																{
																	echo $totalseramtseramtold=0;
																}
																else
																{
																	echo round($totalseramtseramtold);
																}  
																
																?></center></td>
								</tr>
								</tbody>
								<?php
						
					}
					unset($memberid);
							
				     
	}
	 
	?>
	
                                                   <tbody>
														<tr>
														    <td><center><b>Total Amounts(s)</b></center></td>
															
															<td class="numeric"><center><b><?=$totalsercnt?></b></center></td>
															<td class="numeric"><center><b>Rs. <?=$toserviceamt?>/-</b></center></td>
															<td class="numeric"><center><b><?=$totalcustcnt?></b></center></td>
																<?php
																	if($per!='0')
																	{
																		?>
																<td class="numeric"><center><b><?=round($totaltnewcnt,2)?></b></center></td>
																		<?php
																	}
																		?>
															<td class="numeric"><center><b>Rs. <?=$tototalseramtseramt?>/-</b></center></td>
															<td class="numeric"><center><b><?=$totaloldcustcnt?></b></center></td>
															<?php
																	if($per!='0')
																	{
																		?>
																<td class="numeric"><center><b><?=round($totaltoldcnt,2)?></b></center></td>
																		<?php
																	}
																		?>
															<td class="numeric"><center><b>Rs. <?=round($taltotalseramtseramtold)?>/-</b></center></td>
															
														</tr>
													</tbody> 
                                                     </table>													

	<?php
	}
	
	                                   

				
				
			
	}
	else
	{
		?>
		  <table class="table table-bordered table-striped table-condensed cf">
						                                   <thead class="cf">
														 
															   <tr>
																<th><center>Discount Type</center></th>
																<th><center>Service Count</center></th>
																<th><center>Service Amount</center></th>
																<th><center>New Client Count</center></th>
																	<?php
																	if($per!='0')
																	{
																		?>
																	<th><center>New Client Count %</center></th>	
																		<?php
																	}
																		?>
																<th><center>New Client Offer/Membership Amount</center></th>
																<th><center>Existing Client Count</center></th>
																		<?php
																	if($per!='0')
																	{
																		?>
																	<th><center>Existing Client Count %</center></th>	
																		<?php
																	}
																		?>
																<th><center>Existing Client Offer/Membership Amount</center></th>
																</tr>
															 
																
															</thead>
		<?php
			
			$discounttype=$_GET["discounttype"];
	if($discounttype=='1')
	{
		    $Select="Select distinct(tblAppointments.offerid) from tblAppointments right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom $sqlTempto";
		
               
				$RSservice = $DB->query($Select);
				if ($RSservice->num_rows > 0) 
				{
					$counterservice = 0;
				   while($rowservice = $RSservice->fetch_assoc())
					{
					
						$offerid[]=$rowservice['offerid'];		
					    
					}
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
				for($i=0;$i<count($offerid);$i++)
					{
						$SelectrM="SELECT COUNT(tblCustomers.CustomerID) FROM tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.offerid='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$RSservicetM = $DB->query($SelectrM);
								if ($RSservicetM->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetM = $RSservicetM->fetch_assoc())
									{
										$custcntsum +=$rowservicetM ['COUNT(tblCustomers.CustomerID)'];
									}
								}
								
								$sqldetailsdt="select COUNT(tblCustomers.CustomerID) from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointments.offerid='".$offerid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto";
                               $RSservicetqdt = $DB->query($sqldetailsdt);

								if ($RSservicetqdt->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqt = $RSservicetqdt->fetch_assoc())
									{
									$oldcustcntsum +=$rowservicetqt['COUNT(tblCustomers.CustomerID)'];
									
									}
								}
						
					}
				
					for($i=0;$i<count($offerid);$i++)
					{
						
						$Selectr="Select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer,count(tblAppointmentMembershipDiscount.ServiceID) as contoffer,SUM(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as serviceamt from tblAppointmentMembershipDiscount left join  tblAppointments on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointmentsDetailsInvoice.ServiceID=tblAppointmentMembershipDiscount.ServiceID where tblAppointments.StoreID!='' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						//$Selectr="Select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer,count(tblAppointmentMembershipDiscount.ServiceID) as contoffer,SUM(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as serviceamt from tblAppointmentMembershipDiscount left join  tblAppointments on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointmentsDetailsInvoice.ServiceID=tblAppointmentMembershipDiscount.ServiceID where tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$selp=select("*","tblOffers","OfferID='".$offerid[$i]."'");
						$Name=$selp[0]['OfferName'];
								$RSservicet = $DB->query($Selectr);
								if ($RSservicet->num_rows > 0) 
								{
									$ty=0;
									while($rowservicet = $RSservicet->fetch_assoc())
									{
										
										$ty++;
										$sercnt=$rowservicet['contoffer'];
										//$seramtseramt=$rowservicet['sumoffer'];
										$serviceamt=$rowservicet['serviceamt'];
										//$totalseramtseramt=$seramtseramt;
										
										
									}
								}
					$SelectrM="SELECT COUNT(tblCustomers.CustomerID) FROM tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.offerid='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
						$RSservicetM = $DB->query($SelectrM);
								if ($RSservicetM->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetM = $RSservicetM->fetch_assoc())
									{
										$custcnt=$rowservicetM ['COUNT(tblCustomers.CustomerID)'];
									}
								}
					   
					   if($custcnt=='' || $custcnt=='0')
						{
							$custcnt=0;
						}
					if($sercnt=="")
					{
						$sercnt=0;
					}
					else
					{
						$sercnt=$sercnt;
					}
					$totalsercnt +=$sercnt;
					if($custcnt=="")
					{
						$custcnt=0;
					}
					else
					{
						$custcnt=$custcnt;
					}
					$totalcustcnt +=$custcnt;
					if($serviceamt=="")
					{
						$serviceamt=0;
						
					}
					else
					{
						$serviceamt=$serviceamt;
					}
					$toserviceamt +=$serviceamt;
					$Selectrpt="select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.offerid=tblAppointmentMembershipDiscount.OfferID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' $sqlTempfrom $sqlTempto";
					
				    $RSservicetq = $DB->query($Selectrpt);
								if ($RSservicetq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetq = $RSservicetq->fetch_assoc())
									{
									$sumoffer=$rowservicetq['sumoffer'];
									$totalseramtseramt=$sumoffer;	
									}
								}
					if($totalseramtseramt=="")
					{
						$totalseramtseramt=0;
						
					}
					else
					{
						$totalseramtseramt=$totalseramtseramt;
					}
					$tototalseramtseramt +=$totalseramtseramt;
					/* 	$sqldetailsdt="select COUNT(tblCustomers.CustomerID) from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='".$storr."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointments.offerid='".$offerid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto"; */
					$sqldetailsdt="select COUNT(tblCustomers.CustomerID) from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointments.offerid='".$offerid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto";
                   $RSservicetqdt = $DB->query($sqldetailsdt);

								if ($RSservicetqdt->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqt = $RSservicetqdt->fetch_assoc())
									{
									$oldcustcnt=$rowservicetqt['COUNT(tblCustomers.CustomerID)'];
									
									}
								}
					   
					   if($oldcustcnt=='' || $oldcustcnt=='0')
						{
							$oldcustcnt=0;
						}
						 if($oldcustcnt=="")
							 {
								 $oldcustcnt=0;
							 }
							 else
							 {
								 $oldcustcnt=$oldcustcnt;
							 }	
                            $totaloldcustcnt += $oldcustcnt;	
							if($totaloldcustcnt=="")
							{
								$totaloldcustcnt=0;
							}
							else
							{
								$totaloldcustcnt=$totaloldcustcnt;
							}
							$totaltotaloldcustcnt +=$totaloldcustcnt;
						$Selectrptp="select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.offerid=tblAppointmentMembershipDiscount.OfferID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."'";
					
				        $RSservicetqq = $DB->query($Selectrptp);
								if ($RSservicetqq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqq = $RSservicetqq->fetch_assoc())
									{
									$seramtseramtt=$rowservicetqq['sumoffer'];
									$totalseramtseramtold=$seramtseramtt;	
									}
								}
					         if($totalseramtseramtold=="")
							 {
								 $totalseramtseramtold=0;
							 }
							 else
							 {
								 $totalseramtseramtold=$totalseramtseramtold;
							 }	
                            $taltotalseramtseramtold += $totalseramtseramtold;	
                            $newper=($custcnt/$custcntsum)*100;
							$exper=($oldcustcnt/$oldcustcntsum)*100;
                             $totaltnewcnt +=$newper;
	                         $totaltoldcnt +=$exper;							
								?>
								  <tbody>
								  <tr id="my_data_tr_<?=$counterservice?>">
		                        <td class="numeric"><center><?=$Name?></center></td>
								<td class="numeric"><center><?=$sercnt?></center></td>
								<td class="numeric"><center><?=$serviceamt?></center></td>
								<td class="numeric"><center><?php 
								                          if($custcnt=='')
																{
																	echo $custcnt=0;
																}
																else
																{
																	echo $custcnt;
																}
																
																
								
								                       ?></center></td>
													   <?php
													   if($per!='0')
													   {
														   ?>
														   <td><center>
														   <?php
														   echo round($newper,2);
															
																?></center></td>
														  
														   <?php
													   }
													   ?>
									                     <td><center><?php
														  if($totalseramtseramt=='')
																{
																	echo $totalseramtseramt=0;
																}
																else
																{
																	echo $totalseramtseramt;
																}
																
																
														
																?></center></td>
																
														<td class="numeric"><center><?php 
								                          if($oldcustcnt=='')
																{
																	echo $oldcustcnt=0;
																}
																else
																{
																	echo $oldcustcnt;
																}
																
																
								
								                       ?></center></td>
													    <?php
													   if($per!='0')
													   {
														   ?>
														   <td><center><?php
														
																	echo round($exper,2);
																
																
																
														
																?></center></td>
														  
														   <?php
													   }
													   ?>
																<td><center><?php
															  if($totalseramtseramtold=="")
																{
																	echo $totalseramtseramtold=0;
																}
																else
																{
																	echo round($totalseramtseramtold);
																}  
																
																?></center></td>
								</tr>
								  </tbody>
								<?php
						
					}
					unset($offerid);
							
				      
					
					$totalseramtseramt=0;
					$sercnt=0;
					
							
					
				
	}
	else
	{
		
		 $Selectt="Select distinct(tblAppointments.memberid) from tblAppointments right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom $sqlTempto";
		
               
				$RSservicet = $DB->query($Selectt);
				if ($RSservicet->num_rows > 0) 
				{
					$counterservice = 0;
				   while($rowservicet = $RSservicet->fetch_assoc())
					{
					
						$memberid[]=$rowservicet['memberid'];		
					    
					}
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
								
								   </tr>
							      </tbody>
							

<?php		
				}
				for($i=0;$i<count($memberid);$i++)
					{
						$sqldetailsd=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.memberid='".$memberid[$i]."' $sqlTempfrom $sqlTempto");
					    $custcntsum +=$sqldetailsd[0]['COUNT(tblCustomers.CustomerID)'];
						$sqldetailsdt=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointments.memberid='".$memberid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto");
					    $oldcustcntsum=$sqldetailsdt[0]['COUNT(tblCustomers.CustomerID)'];
						
						
					}
				
				
					for($i=0;$i<count($memberid);$i++)
					{
						$Selectr="Select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer,count(tblAppointmentMembershipDiscount.ServiceID) as contoffer,SUM(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as serviceamt from tblAppointmentMembershipDiscount left join  tblAppointments on tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointmentsDetailsInvoice.ServiceID=tblAppointmentMembershipDiscount.ServiceID where tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
					    $selp=select("*","tblMembership","MembershipID='".$memberid[$i]."'");
					    $Name=$selp[0]['MembershipName'];
					
								$RSservicet = $DB->query($Selectr);
								if ($RSservicet->num_rows > 0) 
								{
									$ty=0;
									while($rowservicet = $RSservicet->fetch_assoc())
									{
										
										$ty++;
										$sercnt=$rowservicet['contoffer'];
										//$seramtseramt=$rowservicet['sumoffer'];
										$serviceamt=$rowservicet['serviceamt'];
										//$totalseramtseramt=$seramtseramt;
										
										
									}
								}
					
					$sqldetailsd=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointments.memberid='".$memberid[$i]."' $sqlTempfrom $sqlTempto");
					   $custcnt=$sqldetailsd[0]['COUNT(tblCustomers.CustomerID)'];
					   if($custcnt=='' || $custcnt=='0')
						{
							$custcnt=0;
						}
					if($sercnt=="")
					{
						$sercnt=0;
					}
					else
					{
						$sercnt=$sercnt;
					}
					$totalsercnt +=$sercnt;
					if($custcnt=="")
					{
						$custcnt=0;
					}
					else
					{
						$custcnt=$custcnt;
					}
					$totalcustcnt +=$custcnt;
					if($serviceamt=="")
					{
						$serviceamt=0;
						
					}
					else
					{
						$serviceamt=$serviceamt;
					}
					$toserviceamt +=$serviceamt;
					$Selectrpt="select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID  AND tblAppointments.memberid=tblAppointmentMembershipDiscount.MembershipID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' $sqlTempfrom1 $sqlTempto1 and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
				    $RSservicetq = $DB->query($Selectrpt);
								if ($RSservicetq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetq = $RSservicetq->fetch_assoc())
									{
									$sumoffer=$rowservicetq['sumoffer'];
									$totalseramtseramt=$sumoffer;	
									}
								}
					if($totalseramtseramt=="")
					{
						$totalseramtseramt=0;
						
					}
					else
					{
						$totalseramtseramt=$totalseramtseramt;
					}
					$tototalseramtseramt +=$totalseramtseramt;
					
						$sqldetailsdt=select("COUNT(tblCustomers.CustomerID)","tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and tblAppointments.memberid='".$memberid[$i]."' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') $sqlTempfrom $sqlTempto");
					   $oldcustcnt=$sqldetailsdt[0]['COUNT(tblCustomers.CustomerID)'];
					   if($oldcustcnt=='' || $oldcustcnt=='0')
						{
							$oldcustcnt=0;
						}
						 if($oldcustcnt=="")
							 {
								 $oldcustcnt=0;
							 }
							 else
							 {
								 $oldcustcnt=$oldcustcnt;
							 }	
                            $totaloldcustcnt += $oldcustcnt;	
							if($totaloldcustcnt=="")
							{
								$totaloldcustcnt=0;
							}
							else
							{
								$totaloldcustcnt=$totaloldcustcnt;
							}
							$totaltotaloldcustcnt +=$totaloldcustcnt;
						$Selectrptp="select sum(tblAppointmentMembershipDiscount.MembershipAmount) as sumoffer from tblCustomers left join tblAppointments on tblAppointments.CustomerID=tblCustomers.CustomerID left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.memberid=tblAppointmentMembershipDiscount.MembershipID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.memberid!='0' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') and tblAppointmentMembershipDiscount.MembershipID='".$memberid[$i]."' $sqlTempfrom $sqlTempto";
					
				        $RSservicetqq = $DB->query($Selectrptp);
								if ($RSservicetqq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqq = $RSservicetqq->fetch_assoc())
									{
									$seramtseramtt=$rowservicetqq['sumoffer'];
									$totalseramtseramtold=$seramtseramtt;	
									}
								}
					         if($totalseramtseramtold=="")
							 {
								 $totalseramtseramtold=0;
							 }
							 else
							 {
								 $totalseramtseramtold=$totalseramtseramtold;
							 }	
                            $taltotalseramtseramtold += $totalseramtseramtold;	
                             $newper=($custcnt/$custcntsum)*100;
							 $exper=($oldcustcnt/$oldcustcntsum)*100;
							 $totaltnewcnt +=$newper;
	                         $totaltoldcnt +=$exper;
                            							
								?>
								<tbody>
								  <tr id="my_data_tr_<?=$counterservice?>">
		                        <td class="numeric"><center><?=$Name?></center></td>
								<td class="numeric"><center><?=$sercnt?></center></td>
								<td class="numeric"><center><?=$serviceamt?></center></td>
								<td class="numeric"><center><?php 
								                          if($custcnt=='')
																{
																	echo $custcnt=0;
																}
																else
																{
																	echo $custcnt;
																}
																
																
								
								                       ?></center></td>
													     <?php
													   if($per!='0')
													   {
														   ?>
														   <td><center><?php
														 
																	echo round($newper,2);
																
																
																
														
																?></center></td>
														  
														   <?php
													   }
													   ?>
									                     <td><center><?php
														  if($totalseramtseramt=='')
																{
																	echo $totalseramtseramt=0;
																}
																else
																{
																	echo $totalseramtseramt;
																}
																
																
														
																?></center></td>
														<td class="numeric"><center><?php 
								                          if($oldcustcnt=='')
																{
																	echo $oldcustcnt=0;
																}
																else
																{
																	echo $oldcustcnt;
																}
																
																
								
								                       ?></center></td>
													    <?php
													   if($per!='0')
													   {
														   ?>
														   <td><center><?php
														
																	echo round($exper,2);
																
																?></center></td>
														  
														   <?php
													   }
													   ?>
																<td><center><?php
															  if($totalseramtseramtold=="")
																{
																	echo $totalseramtseramtold=0;
																}
																else
																{
																	echo round($totalseramtseramtold);
																}  
																
																?></center></td>
								</tr>
								</tbody>
								<?php
						
					}
					unset($memberid);
							
				      
	
	}
	
	?>
                                                   <tbody>
														<tr>
														    <td><center><b>Total Amounts(s)</b></center></td>
															
															<td class="numeric"><center><b><?=$totalsercnt?></b></center></td>
															
															<td class="numeric"><center><b>Rs. <?=$toserviceamt?>/-</b></center></td>
																<td class="numeric"><center><b><?=$totalcustcnt?></b></center></td>
																<?php
																	if($per!='0')
																	{
																		?>
																<td class="numeric"><center><b><?=round($totaltnewcnt,2)?></b></center></td>
																		<?php
																	}
																		?>
															
														
															<td class="numeric"><center><b>Rs. <?=$tototalseramtseramt?>/-</b></center></td>
															<td class="numeric"><center><b><?=$totaloldcustcnt?></b></center></td>
																<?php
																	if($per!='0')
																	{
																		?>
																<td class="numeric"><center><b><?=round($totaltoldcnt,2)?></b></center></td>
																		<?php
																	}
																		?>
															
															<td class="numeric"><center><b>Rs. <?=round($taltotalseramtseramtold)?>/-</b></center></td>
															
														</tr>
													</tbody>	
													</table>
						
	<?php
	}
?>						
													
						
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