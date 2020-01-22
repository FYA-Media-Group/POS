<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Employee Commission Report | Nailspa";
	$strDisplayTitle = "Employee Commission of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "";
	$strMyTableID = "";
	$strMyField = "";
	$strMyActionPage = "EmployeeCommissionCumulative.php";
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
<script>
		function printDiv(divName) 
		{
	
	    var divToPrint = document.getElementById("kakkabiryani");
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
					

                    <div id="page-title">
                        <h2><?=$strDisplayTitle?></h2>
                    </div>
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
												<h3 class="title-hero">Employee Commission</h3>
												
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
											<?php
															if($strAdminRoleID=="36")
                                                               {  
														?>
															<div class="form-group"><label for="" class="col-sm-4 control-label">Select Store</label>
														<div class="col-sm-4">
													<select class="form-control required"  name="store">
															<option value="0" selected>All</option>
<?
                                                    $selp=select("*","tblStores","Status='0'");
													foreach($selp as $val)
													{
														$strStoreName = $val["StoreName"];
														$strStoreID = $val["StoreID"];
														$store=$_GET["store"];
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
																   $_GET["store"]=$strStore;
															   }
															   ?>
		
												
													
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="EmployeeCommissionCumulative.php">Clear All Filter</a> &nbsp;&nbsp;&nbsp;
												<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
													</div>
												
												</form>
												
												
												<div class="example-box-wrapper">
												<?php
												$storrr=$_GET["store"];
											
												if(isset($_GET["toandfrom"]) )
												{
													$storrr=$_GET["store"];
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
												<br><br>
<saif id="kakkabiryani">												
												<span>
												<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store - <?=$storrrp?></h3>
												
												</span>										

												
												<table id="printdata" class="table table-striped table-bordered responsive no-wrap printdata" cellspacing="0" width="100%">
													<thead>
														<tr>
															<th>Employee ID</th>
															<th>Name</th>
															<th>Email</th>
															<th>Mobile no.</th>
															<th>Commission percentage</th>
															<th>Service Sales</th>
															<th>After Discount Sales</th>
															<th>Commission</th>
														</tr>
													</thead>
													
													
													<tbody>
														
													

												
<?php

$DB = Connect();
$strEmpPercentage="";
if(!empty($storrr))
{
	$sql = "select EID, EmployeeName, EmployeeEmailID, EmpPercentage, EmployeeMobileNo from tblEmployees where StoreID='$storrr'";
}
else
{
	$sql = "select EID, EmployeeName, EmployeeEmailID, EmpPercentage, EmployeeMobileNo from tblEmployees";
}


$RS = $DB->query($sql);
if($RS->num_rows > 0) 
{
	$TotalServiceSale = 0;
	
	while($row = $RS->fetch_assoc())
	{
		$strEID = $row["EID"];	
		$strEmployeeName = $row["EmployeeName"];
		$strEmployeeEmailID = $row["EmployeeEmailID"];
		$strEmpPercentage = $row["EmpPercentage"];
		$strEmployeeMobileNo = $row["EmployeeMobileNo"];
		
	$storrr=$_GET["store"];
	if(!empty($storrr))
	{
			$sqldetails = "SELECT tblAppointmentAssignEmployee.AppointmentID,
						tblAppointmentAssignEmployee.ServiceID,
						tblAppointmentAssignEmployee.Commission,
						tblInvoiceDetails.OfferDiscountDateTime,tblEmployees.StoreID,
						tblAppointmentAssignEmployee.Qty,
						tblAppointmentAssignEmployee.QtyParam,
						(select ServiceAmount from tblAppointmentsDetailsInvoice where AppointmentID=tblAppointmentAssignEmployee.AppointmentID and ServiceID=tblAppointmentAssignEmployee.ServiceID Limit 0,1) as ServiceAmount
						FROM tblEmployees left join tblAppointmentAssignEmployee on tblEmployees.EID = tblAppointmentAssignEmployee.MECID
						left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentId= tblAppointmentAssignEmployee.AppointmentID
						left join tblInvoiceDetails on tblAppointmentAssignEmployee.AppointmentID=tblInvoiceDetails.AppointmentId
						where tblEmployees.StoreID = '$storrr' and
						tblEmployees.EID='$strEID'
						and tblAppointmentAssignEmployee.AppointmentID!='NULL'
						and tblInvoiceDetails.OfferDiscountDateTime!='NULL'
						$sqlTempfrom 
						$sqlTempto
						group by tblAppointmentAssignEmployee.AppointmentID,ServiceID,QtyParam";
	}
	else
	{
			$sqldetails ="SELECT tblAppointmentAssignEmployee.AppointmentID,
						tblAppointmentAssignEmployee.ServiceID,
						tblAppointmentAssignEmployee.Commission,
						tblInvoiceDetails.OfferDiscountDateTime,tblEmployees.StoreID,
						tblAppointmentAssignEmployee.Qty,
						tblAppointmentAssignEmployee.QtyParam,
						(select ServiceAmount from tblAppointmentsDetailsInvoice where AppointmentID=tblAppointmentAssignEmployee.AppointmentID and ServiceID=tblAppointmentAssignEmployee.ServiceID Limit 0,1) as ServiceAmount
						FROM tblEmployees left join tblAppointmentAssignEmployee on tblEmployees.EID = tblAppointmentAssignEmployee.MECID
						left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentId= tblAppointmentAssignEmployee.AppointmentID
						left join tblInvoiceDetails on tblAppointmentAssignEmployee.AppointmentID=tblInvoiceDetails.AppointmentId
						where tblEmployees.EID='$strEID'
						and tblAppointmentAssignEmployee.AppointmentID!='NULL'
						and tblInvoiceDetails.OfferDiscountDateTime!='NULL'
						$sqlTempfrom 
						$sqlTempto
						group by tblAppointmentAssignEmployee.AppointmentID,ServiceID,QtyParam";
	}	
	
	//echo $sqldetails.'<hr>';
		$RSdetails = $DB->query($sqldetails);
		if($RSdetails->num_rows > 0) 
		{
			$ServiceSale = 0;
			$strCommissionDivisionParam = '';
			$strQuantity = '';
			
			while($rowdetails = $RSdetails->fetch_assoc())
			{
				$strAppointmentID = $rowdetails["AppointmentID"];
				$strServiceID = $rowdetails["ServiceID"];
				$strQuantity = $rowdetails["Qty"];
				$strServiceAmount = $rowdetails["ServiceAmount"];
				$strCommissionDivisionParam = $rowdetails["Commission"];
				$StoreIDDetail = $rowdetails["StoreID"];
				
				//Service Sale
				$ServiceSale += $strServiceAmount;
				
				//echo $ServiceSale.'<br>';
				//echo '<hr>';
				
			}
		}
		else
		{
			$ServiceSale = '0';
		}
	
		$TotalServiceSale += $ServiceSale;
		
?>
						<tr>
							<td><?=$strEID?></td>
							<td><?=$strEmployeeName?></td>
							<td><?=$strEmployeeEmailID?></td>
							<td><?=$strEmployeeMobileNo?></td>
							<td><?=$strEmpPercentage?></td>
							<td><?=$ServiceSale?></td>
							<td><?=$SaleFinal?></td>
							<td><?=$ComFinal?></td>
						</tr>
<?php
	}
?>
						<tr>
							<td colspan='5' style='background: #9ed070;'><center><b>Total</b></center></td>
							<td style='background: #9ed070;'><?=$TotalServiceSale?></td>
							<td style='background: #9ed070;'><?=$TotalSale?></td>
							<td style='background: #9ed070;'><?=$TotalCommission?></td>
						</tr>
<?php
}
else
{
	echo "No Employees found for this store and date range!";
}
$DB->close();
?>
														<?php
														}	
													else
														{
															echo "<br><center><h3>Please Select Month And Year!</h3></center>";
														}	
			
?>
</saif>									
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