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
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$getto."')";
			$sqlTempto1 = " and Date(tblCustomerMemberShip.ExpireDate)<=Date('".$getto."')";
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
			$sqlTempfrom1 = " and Date(tblCustomerMemberShip.ExpireDate)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$getto."')";
			$sqlTempto1 = " and Date(tblCustomerMemberShip.ExpireDate)<=Date('".$getto."')";
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
														<div class="col-sm-2">
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
														<a class="btn btn-link" href="ReportMembership.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														 <button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
														<!--<a class="btn btn-border btn-alt border-primary font-primary" href="ExcelExportData.php?from=<?=$getfrom?>&to=<?=$getto?>" title="Excel format 2016"><span>Export To Excel</span><div class="ripple-wrapper"></div></a>
														-->

													</div>
												</form>
												
												<br>
												<?php
													if(isset($_GET["toandfrom"]) || !IsNull($_GET["Store"]))
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
														$getfrom=date('Y-m-d');
														$getto=date('Y-m-d');
												?>
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store Filter selected : <?=$storrrp?> </h3>
												
												<br>
				

				
<?php
$DB = Connect();

	$counter = 0;
$storr=$_GET["Store"];
		
?>
		<div class="panel">
			<div class="panel-body">
				
				<div class="example-box-wrapper">
					<div class="scroll-columns">
					
						<table id="printdata" class="table table-bordered table-striped table-condensed cf">
						                                 
														   <?php 
														   if($storr!='0')
                                                          {
															  ?>
															    <thead>
															  	<tr>
																	<th><center>Sr</center></th>
																	<th><center>New Members Count</center></th>
																	<th><center>New Members Amount</center></th>
																	<th><center>Renewal Count</center></th>
																	<th><center>Renewal Amountv</th>
																	<th><center>Expired Members</center></th>
																	<th><center>Store</center></th>
																	
																</tr>
																</thead>
															  <?php
														  }
														  else
														  {
															  ?>
															  	  <thead>
															  	<tr>
																	<th><center>Sr</center></th>
																	<th><center>New Members Count</center></th>
																	<th><center>New Members Amount</center></th>
																	<th><center>Renewal Count</center></th>
																	<th><center>Renewal Amount</center></th>
																	<th><center>Expired Members</center></th>
																	
																	
																</tr>
																</thead>
															  <?php
														  }
														   ?>
															
														
														
															<tbody>
							
<?php
$storr=$_GET["Store"];

if(!empty($storr))
{
	$sqlservice = "SELECT count(tblCustomerMemberShip.CustomerID) as newcust,sum(tblAppointmentMembershipDiscount.MembershipAmount) as memsum,tblAppointments.StoreID from  tblCustomerMemberShip left join tblAppointments on tblAppointments.CustomerID=tblCustomerMemberShip.CustomerID left join tblAppointmentMembershipDiscount
on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID left join tblInvoiceDetails
 on tblAppointmentMembershipDiscount.AppointmentID=tblInvoiceDetails
.AppointmentId where tblAppointments.StoreID='".$storr."' and tblAppointments.IsDeleted!='1' and tblAppointmentMembershipDiscount.MembershipID!='0' and tblAppointments.FreeService!='1' and tblCustomerMemberShip.Status='1' $sqlTempfrom $sqlTempto";
}
else
{
$sqlservice = "SELECT count(tblCustomerMemberShip.CustomerID) as newcust,sum(tblAppointmentMembershipDiscount.MembershipAmount) as memsum,tblAppointments.StoreID from tblCustomerMemberShip left join tblAppointments on tblCustomerMemberShip.CustomerID=tblAppointments.CustomerID left join tblAppointmentMembershipDiscount
on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID left join tblInvoiceDetails
 on tblAppointmentMembershipDiscount.AppointmentID=tblInvoiceDetails
.AppointmentId where tblAppointments.StoreID!='0' and tblAppointments.IsDeleted!='1' and tblAppointmentMembershipDiscount.MembershipID!='0' and tblAppointments.FreeService!='1' and tblCustomerMemberShip.Status='1' $sqlTempfrom $sqlTempto";
}
												// if($_SERVER['REMOTE_ADDR']=="111.119.219.70")
												// {
													// echo $sqlservice;
												// }
												// else
												// {
													   
												// }
		

		$RSservice = $DB->query($sqlservice);
		if ($RSservice->num_rows > 0) 
		{
			$counterservice = 0;

			while($rowservice = $RSservice->fetch_assoc())
			{
				$toatlseramt="";
				$counterservice ++;
				$newcust = $rowservice["newcust"];
				$memsum = $rowservice["memsum"];
				
				$StoreID = $rowservice["StoreID"];
		
if(!empty($storr))
  {
	   $sepqtp=select("sum(tblCustomerMemberShip.RenewAmount) as sumrenew,count(tblCustomerMemberShip.RenewCount) as recnt","tblCustomerMemberShip left join tblAppointments on tblCustomerMemberShip.CustomerID=tblAppointments.CustomerID left join tblAppointmentMembershipDiscount
on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID left join tblInvoiceDetails
 on tblAppointmentMembershipDiscount.AppointmentID=tblInvoiceDetails
.AppointmentId","tblAppointments.StoreID='".$storr."' and tblAppointments.IsDeleted!='1' and tblAppointmentMembershipDiscount.MembershipID!='0' and tblAppointments.FreeService!='1' and tblCustomerMemberShip.RenewStatus='1' $sqlTempfrom $sqlTempto");
				$sumrenew=$sepqtp[0]['sumrenew'];
				$recnt=$sepqtp[0]['recnt'];
	
  }
  else
  {
	   $sepqtp=select("sum(tblCustomerMemberShip.RenewAmount) as sumrenew,count(tblCustomerMemberShip.RenewCount) as recnt","tblCustomerMemberShip left join tblAppointments on tblCustomerMemberShip.CustomerID=tblAppointments.CustomerID left join tblAppointmentMembershipDiscount
on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID left join tblInvoiceDetails
 on tblAppointmentMembershipDiscount.AppointmentID=tblInvoiceDetails
.AppointmentId","tblAppointments.StoreID!='0' and tblAppointments.IsDeleted!='1' and tblAppointmentMembershipDiscount.MembershipID!='0' and tblAppointments.FreeService!='1' and tblCustomerMemberShip.RenewStatus='1' $sqlTempfrom $sqlTempto");
				$sumrenew=$sepqtp[0]['sumrenew'];
				$recnt=$sepqtp[0]['recnt'];
	
  }
			 
		 
if(!empty($storr))
  {
			 $sqlservicet="select count(tblCustomerMemberShip.ExpiryCount) as expcnt from tblCustomerMemberShip  left join tblAppointments on tblCustomerMemberShip.CustomerID=tblAppointments.CustomerID left join tblAppointmentMembershipDiscount
on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID left join tblInvoiceDetails
 on tblAppointmentMembershipDiscount.AppointmentID=tblInvoiceDetails
.AppointmentId where tblAppointments.StoreID='".$storr."' and tblAppointments.IsDeleted!='1' and tblAppointmentMembershipDiscount.MembershipID!='0' and tblCustomerMemberShip.ExpireDate!='0000-00-00' and tblAppointments.FreeService!='1' and tblCustomerMemberShip.Status='1' $sqlTempfrom1 $sqlTempto1";
		 
  }
else
{
	 $sqlservicet="select count(tblCustomerMemberShip.ExpiryCount) as expcnt from tblCustomerMemberShip  left join tblAppointments on tblCustomerMemberShip.CustomerID=tblAppointments.CustomerID left join tblAppointmentMembershipDiscount
on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID left join tblInvoiceDetails
 on tblAppointmentMembershipDiscount.AppointmentID=tblInvoiceDetails
.AppointmentId where tblAppointments.StoreID!='0' and tblAppointments.IsDeleted!='1' and tblAppointmentMembershipDiscount.MembershipID!='0' and tblCustomerMemberShip.ExpireDate!='0000-00-00' and tblAppointments.FreeService!='1' and tblCustomerMemberShip.Status='1' $sqlTempfrom1 $sqlTempto1";
}	
				

$RSservicet = $DB->query($sqlservicet);
		if ($RSservicet->num_rows > 0) 
		{
		

			while($rowservice1 = $RSservicet->fetch_assoc())
			{
				$expcnt=$rowservice1['expcnt'];
			}
		}
				
			if($sumrenew=="")
			{
				$sumrenew="0";
			}
			if($memsum=="")
			{
				$memsum="0";
			}
				$sep=select("*","tblStores","StoreID='".$storr."'");
		        $storename=$sep[0]['StoreName'];
	
			

?>							
									
						                             <?php 
														   if(!empty($storr))
                                                          {
															  ?>
															  <tr id="my_data_tr_<?=$counterservice?>">
								<td><center><b><?=$counterservice?></b></center></td>
									<td><center><b><?=$newcust?></b></center></td>
									<td><center><b><?=$memsum?></b></center></td>
									<td><center><b><?=$recnt?></b></center></td>
									<td><center><b><?=$sumrenew?></b></center></td>
									<td><center><b><?=$expcnt?></b></center></td>
							
									<td><center><b><?=$storename?></b></center></td>
								</tr>
															  <?php
															  
														  }
														  else
														  {
															 ?>
															 <tr id="my_data_tr_<?=$counterservice?>">
								<td><center><b><?=$counterservice?></b></center></td>
									<td><center><b><?=$newcust?></b></center></td>
									<td><center><b><?=$memsum?></b></center></td>
									<td><center><b><?=$recnt?></b></center></td>
									<td><center><b><?=$sumrenew?></b></center></td>
									<td><center><b><?=$expcnt?></b></center></td>
							
									
								</tr>
                                                                 <?php															 
														  }
															  ?>
								
							
<?php
			}
			$sumrenew="";
			
			
		}
		else
		{
?>
							  <?php 
														   if(!empty($storr))
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
									
									
								</tr>
								 <?php
															  
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
									
									
									
								</tr> 
															 <?php
														  }
															 ?>
							

<?php		
		}	
	
?>							
					</tbody>
													
						</table>
						
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