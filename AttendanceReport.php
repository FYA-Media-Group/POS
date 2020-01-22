<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Attendance Report | Nailspa";
	$strDisplayTitle = "Attendance Report Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "AttendanceReport.php";
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
		// strtoandfromgetfrom
		
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
												<h3 class="title-hero">List of Employees</h3>
												
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
													
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="AttendanceReport.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
															<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
														<!--<a class="btn btn-border btn-alt border-primary font-primary" href="ExcelExportData.php?from=<?=$getfrom?>&to=<?=$getto?>" title="Excel format 2016"><span>Export To Excel</span><div class="ripple-wrapper"></div></a>
														-->

													</div>
												</form>
												
												<br>
												<div id="printdata">	
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
														// $getfrom=date('Y-m-d');
														// $getto=date('Y-m-d');
												?>
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store Filter selected : <?=$storrrp?> </h3>
												
												<br>
				

				
<?php
$DB = Connect();

	$counter = 0;

		
?>
		<div class="panel">
			<div class="panel-body">
				<!--<h3 class="title-hero"><font color="Red"><?=$strCategoryName?></font></h3>-->
				<div class="example-box-wrapper">
					
						<!--<table class="table table-bordered table-striped table-condensed cf">-->
						<table class="table table-bordered table-striped table-condensed cf" width="100%">
							<thead class="cf">
								<tr>
									<!--<th>Code</th>-->
									<th>Employee Name</th>
									<th>Day & Date</th>
									<th>Check In</th>
									<th>Check Out</th>
									<!--<th>Store</th>-->
									
								
									
								</tr>
							</thead>
							
							
<?php
$storr=$_GET["Store"];
// $getfrom=date('Y-m-d');
// $getto=date('Y-m-d');
if(!empty($storr))
{
	
	$sqlservice = "SELECT DISTINCT(tblEmployeesRecords.EmployeeCode), tblEmployees.EmployeeName,tblEmployees.StoreID, tblEmployeesRecords.DateOfAttendance, tblEmployeesRecords.LoginTime,tblEmployeesRecords.LogoutTime
					FROM `tblEmployees` left join tblEmployeesRecords 
					on tblEmployees.EmployeeCode=tblEmployeesRecords.EmployeeCode
					where tblEmployees.StoreID='".$storr."' and tblEmployeesRecords.DateOfAttendance!='null' and tblEmployeesRecords.DateOfAttendance!='NULL' and tblEmployeesRecords.EmployeeCode!='NULL' and Date(tblEmployeesRecords.DateOfAttendance)>=Date('".$getfrom."') and Date(tblEmployeesRecords.DateOfAttendance)<=Date('".$getto."') ORDER BY tblEmployeesRecords.DateOfAttendance DESC";
}
else
{

	$sqlservice = "SELECT DISTINCT(tblEmployeesRecords.EmployeeCode), tblEmployees.EmployeeName,tblEmployees.StoreID, tblEmployeesRecords.DateOfAttendance, tblEmployeesRecords.LoginTime,tblEmployeesRecords.LogoutTime
					FROM `tblEmployees` left join tblEmployeesRecords 
					on tblEmployees.EmployeeCode=tblEmployeesRecords.EmployeeCode
					where tblEmployeesRecords.DateOfAttendance!='null' and tblEmployeesRecords.DateOfAttendance!='NULL' and tblEmployeesRecords.EmployeeCode!='NULL' and Date(tblEmployeesRecords.DateOfAttendance)>=Date('".$getfrom."') and Date(tblEmployeesRecords.DateOfAttendance)<=Date('".$getto."') ORDER BY tblEmployeesRecords.DateOfAttendance DESC";
}

		
		// echo $sqlservice."<br>";
		
		$RSservice = $DB->query($sqlservice);
		if ($RSservice->num_rows > 0) 
		{
			$counterservice = 0;

			while($rowservice = $RSservice->fetch_assoc())
			{
				$strqty = "";
				$strServiceAmount = "";	
				$strOfferAmount = "";
				$strMembershipAmount = "";
				$strServiceNet2 = "";
				$strServiceNet = "";
				$tpcostt = "";
				$product_cost ="";
				$counterservice ++;
				$EmployeeCode = $rowservice["EmployeeCode"];
				$EmployeeName = $rowservice["EmployeeName"];
			
				$DateOfAttendance = $rowservice["DateOfAttendance"];
				$DateOfAttendanceT = FormatDateTime($DateOfAttendance);
				$weekday = date('l', strtotime($DateOfAttendanceT));
				
				$LoginTime = $rowservice["LoginTime"];
				$LogoutTime = $rowservice["LogoutTime"];
				
				$StoreID = $rowservice["StoreID"];
				$stpp=select("StoreName","tblStores","StoreID='".$StoreID."'");
				$StoreName=$stpp[0]['StoreName'];
			
			     if($LoginTime!='00:00:00')
				 {
					 	 $LoginTimet=date('h:i:s A', strtotime($LoginTime));
				 }
				 else
				 {
					 	 $LoginTimet="00:00:00";
				 }
			
				if($LogoutTime!='00:00:00')
				 {
					 	 $LogoutTimet=date('h:i:s A', strtotime($LogoutTime));
				 }
				 else
				 {
					 	 $LogoutTimet="00:00:00";
				 }
				

?>							
									
							
								<tr>
									<!--<td><?=$EmployeeCode?></td>-->
									<td><?=$EmployeeName?></td>
									<td><?=$weekday?>&nbsp; &nbsp;<?=$DateOfAttendanceT?></td>
									<td><?=$LoginTimet?></td>
									<td><?=$LogoutTimet?></td>
									<!--<td><?=$StoreName?></td>-->
									
								</tr>
							
<?php
			}
			
		}
		else
		{
?>
							<tbody>
								<tr>
									<!--<td></td>-->
									<td></td>
									<td></td>
									<td></td>
									<!--<td></td>-->
									<td>No Data Found</td>
								</tr>
							</tbody>

<?php		
		}	
	
?>							
				
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