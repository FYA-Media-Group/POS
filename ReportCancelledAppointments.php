<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Cancelled Appointments | Nailspa";
	$strDisplayTitle = "Appointments Cancelled Report of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportCancelledAppointments.php";
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
			$sqlTempfrom = " and Date(AppointmentDate)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(AppointmentDate)<=Date('".$getto."')";
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
			$sqlTempfrom = " and Date(AppointmentDate)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(AppointmentDate)<=Date('".$getto."')";
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
												<h3 class="title-hero">List of Appointments Cancelled</h3>
												
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
														<a class="btn btn-link" href="ReportCancelledAppointments.php">Clear All Filter</a>
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
																<th>Customer Name</th>
																<th>Suitable Time was</th>
																<th>Email Id</th>
																<th>Contact</th>
																<th>Store</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
															   <th>Sr</th>
																<th>Customer Name</th>
																<th>Suitable Time was</th>
																<th>Email Id</th>
																<th>Contact</th>
																<th>Store</th>
															</tr>
														</tfoot>
														<tbody>

<?php
$DB = Connect();
if($strStore!='0')
{
	$sql="Select * from tblAppointments where Status=3 and IsDeleted!='1' and StoreID='$strStore' $sqlTempfrom $sqlTempto";	
}
else
{
	$sql="Select * from tblAppointments where Status=3 and IsDeleted!='1' $sqlTempfrom $sqlTempto";	
	// $sql = "Select CustomerID,StoreID,RedemptionCode,Amount,RedempedDateTime from  tblGiftVouchers where 1 $sqlTempfrom $sqlTempto";
	
}

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	// echo "In if <br>";
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		// echo "In while<br>";
		$CustomerID = $row["CustomerID"];
		$StoreID = $row["StoreID"];
		$AppointmentDate = $row["AppointmentDate"];
		$SuitableAppointmentTime = $row["SuitableAppointmentTime"];
		
		$CustomerFullName = $row["CustomerFullName"];
		$CustomerEmailID = $row["CustomerEmailID"];
		$CustomerMobileNo = $row["CustomerMobileNo"];
	
		
		$CustData="Select * from tblCustomers where CustomerID=$CustomerID";
		$RScust = $DB->query($CustData);
		if ($RScust->num_rows > 0) 
		{

			while($rowcust = $RScust->fetch_assoc())
			{
				$CustomerFullName = $rowcust["CustomerFullName"];
				$CustomerEmailID = $rowcust["CustomerEmailID"];
				$CustomerMobileNo = $rowcust["CustomerMobileNo"];
			}
		}
		
		$dateObject = new DateTime($SuitableAppointmentTime);
		// echo $dateObject->format('h:i A');
		
	
	    $selp=select("StoreName","tblStores","StoreID='".$StoreID."'");
		$StoreName=$selp[0]['StoreName'];
		
		
		$SuitableAppointmentTime=$selpy[0]['SuitableAppointmentTime'];
		
		$dateObject = new DateTime($SuitableAppointmentTime);
		// echo $dateObject->format('h:i A');
		
		
		$Amount = $row["Amount"];
		
		if($Amount =="")
		{
			$Amount ="0.00";
		}
		else
		{
		
			$Amount = $Amount;
			
		}
		$TotalAmount += $Amount;
		
		
		
		
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$CustomerFullName?></td>
																<td><?=$dateObject->format('h:i A')?></td>
																<td><?=$CustomerEmailID?></td>
																<td><?=$CustomerMobileNo?></td>
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
																<td></td>
																<td>No Records Found</td>
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
															<td></td>
															<td></td>
															<td colspan="4"><center><b>Total Appointments done in selected periods(s) : <?=$counter?></b><center></td>
														
															
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