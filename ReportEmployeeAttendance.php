<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Employee Attendance Report | Nailspa";
	$strDisplayTitle = "Employee Attendance Report of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportEmployeeAttendance.php";
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

	if(isset($_GET["month"]))
	{
		$month = $_GET["month"];
		
		if(!IsNull($month))
		{
			$sqlmonth = " AND tblAttendanceRecord.RecordMonth='".$month."'";
		}

		
	}
	if(isset($_GET["year"]))
	{
		$year = $_GET["year"];
		
		if(!IsNull($year))
		{
			$sqlyear = " AND tblAttendanceRecord.RecordYear='".$year."'";
		}

		
	}
	if(isset($_GET["store"]))
	{
		$store = $_GET["store"];
		
		if(!IsNull($store))
		{
			$sqlstore = " AND tblEmployees.StoreID='".$store."'";
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

if(!isset($_GET['ECODE']))
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
												<h3 class="title-hero">Employee Attendance</h3>
												
												<form method="get" class="form-horizontal bordered-row" role="form">
													<div class="form-group"><label for="" class="col-sm-4 control-label">Select Month & Year</label>
														<div class="col-sm-2">
														
																<select class="form-control required"  name="month">
															<option value="" selected>--Select Month--</option>
													     <?php
                                                         for($m = 1;$m <= 12; $m++){ 
														 
															$month =  date("F", mktime(0, 0, 0, $m)); 
															$mnt=$_GET["month"];
															if($mnt==$month)
															{
																echo "<option selected value='$month'>$month</option>"; 
															}
															else
															{
																echo "<option value='$month'>$month</option>"; 
															}
															
														} 
                                                         ?>														 
												          </select>
															
														</div>
														<div class="col-sm-2">
														
													    <select class="form-control required"  name="year">
															<option value="" selected>--Select Year--</option>
													     <?php
                                                         for($m = 2016;$m <= 2024; $m++){ 
															$year=$_GET["year"];
															if($year==$m)
															{
																echo "<option selected value='$m'>$m</option>"; 
															}
															else
															{
																echo "<option value='$m'>$m</option>"; 
															}
															
														} 
                                                         ?>														 
												          </select>
															
														</div>
													</div>
													<div class="form-group"><label for="" class="col-sm-4 control-label">Select Store</label>
														<div class="col-sm-4">
														
													<select class="form-control required"  name="store">
															<option value="" selected>All</option>
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
														
													</div>
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportEmployeeAttendance.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														

													</div>
												
												</form>
												
												<br>
												<?php
													if(isset($_GET["month"]) && isset($_GET["year"]) || isset($_GET["store"]))
													{
														$mon=$_GET["month"];
														$year=$_GET["year"];
														$store=$_GET["store"];
														$sep=select("StoreName","tblStores","StoreID='".$store."'");
	                                                	$storename=$sep[0]['StoreName'];
												?>
														<h3 class="title-hero">Month - <?=$mon?> / Year - <?=$year?> / Store - <?=$storename?></h3>
												
												<br>
												
												
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
															   <th>Sr</th>
																<th style="text-align:center">Store Name</th>
																<th style="text-align:center">Employee Name</th>
																<th style="text-align:center">LeavesThisMonth<?="(".$mon.")"?></th>
																<th style="text-align:center">View Details</th>
																
															</tr>
														</thead>
														<tfoot>
															<tr>
															   <th>Sr</th>
																<th>Store Name</th>
																<th>Employee Name</th>
																<th>Leaves This Month</th>
																<th>View Details</th>
															</tr>
														</tfoot>
														<tbody>

<?php
$DB = Connect();
$sql = "SELECT tblEmployees.StoreID,tblEmployees.EmployeeName,tblAttendanceRecord.LeavesThisMonth,tblEmployees.EmployeeCode from tblEmployees left join tblAttendanceRecord on tblEmployees.EmployeeCode=tblAttendanceRecord.EmployeeCode where tblEmployees.EmployeeCode!='NULL' $sqlstore $sqlmonth $sqlyear";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$StoreID = $row["StoreID"];
		$sep=select("StoreName","tblStores","StoreID='".$StoreID."'");
		$storename=$sep[0]['StoreName'];
		$EmployeeName = $row["EmployeeName"];
		$LeavesThisMonth = $row["LeavesThisMonth"];
		if($LeavesThisMonth =="")
		{
			$LeavesThisMonth ="0.00";
		}
		else
		{
		
			$LeavesThisMonth = $LeavesThisMonth;
			
		}
		$TotalLeavesThisMontht += $LeavesThisMonth;
		$EmployeeCode = $row["EmployeeCode"];
		$ECODE=EncodeQ($EmployeeCode);
		$getUID = EncodeQ($EmployeeCode);
		
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><center><?=$counter?></center></td>
																<td><center><?=$storename?></center></td>
																<td><center><?=$EmployeeName?></center></td>
																
																<td><center><?=$LeavesThisMonth?></center></td>
															
																<td><center><a class="btn btn-link font-red" href="ReportEmployeeAttendance.php?ECODE=<?=$ECODE?>" >View Details</a></center></td>
																
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
															</tr>
													
														
<?php
}
$DB->close();
?>
														
														</tbody>
													
													</table>
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
                    </div>
<?php
}
elseif(isset($_GET['ECODE']))
{
	$ECODE=$_GET['ECODE'];
	$ecodee=DecodeQ($ECODE);
?>
      <div class="panel">
						<div class="panel">
							<div class="panel-body">
							
								
								<div class="example-box-wrapper">
									<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="ReportEmployeeAttendance.php"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
								
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
											
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
																<thead>
															<tr>
															   <th>Sr</th>
																<th style="text-align:center">Store Name</th>
																<th style="text-align:center">Employee Name</th>
																<th style="text-align:center">Month</th>
																<th style="text-align:center">Year</th>
																<th style="text-align:center">LeavesThisMonth</th>
																
															</tr>
														</thead>
														<tfoot>
															<tr>
															   <th>Sr</th>
																<th>Store Name</th>
																<th>Employee Name</th>
																<th>Month</th>
																<th>Year</th>
																<th>LeavesThisMonth</th>
															</tr>
														</tfoot>
														<tbody>

<?php
$DB = Connect();
	
		$sql = "SELECT tblEmployees.StoreID,tblEmployees.EmployeeName,tblAttendanceRecord.LeavesThisMonth,tblEmployees.EmployeeCode,tblAttendanceRecord.RecordMonth,tblAttendanceRecord.RecordYear from tblEmployees left join tblAttendanceRecord on tblEmployees.EmployeeCode=tblAttendanceRecord.EmployeeCode where tblEmployees.EmployeeCode!='NULL' and tblAttendanceRecord.EmployeeCode='".$ecodee."' $sqlstore $sqlyear";

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$StoreID = $row["StoreID"];
		$sep=select("StoreName","tblStores","StoreID='".$StoreID."'");
		$storename=$sep[0]['StoreName'];
		$EmployeeName = $row["EmployeeName"];
		$RecordMonth = $row["RecordMonth"];
		$RecordYear = $row["RecordYear"];
		$LeavesThisMonth = $row["LeavesThisMonth"];
		if($LeavesThisMonth =="")
		{
			$LeavesThisMonth ="0.00";
		}
		else
		{
		
			$LeavesThisMonth = $LeavesThisMonth;
			
		}
		$TotalLeavesThisMontht += $LeavesThisMonth;
		$EmployeeCode = $row["EmployeeCode"];
		$ECODE=EncodeQ($EmployeeCode);
		$getUID = EncodeQ($EmployeeCode);
		
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><center><?=$counter?></center></td>
																<td><center><?=$storename?></center></td>
																<td><center><?=$EmployeeName?></center></td>	
																<td><center><?=$RecordMonth?></center></td>
															    <td><center><?=$RecordYear?></center></td>
																<td><center><?=$LeavesThisMonth?></center></td>
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
															</tr>
													
														
<?php
}
$DB->close();
?>
														
														</tbody>
													<tbody>
														<tr>
															<td colspan="6"><center><b>Total Leaves(count) : <?=$TotalLeavesThisMontht?></b><center></td>
															
															
														
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
<?php
}
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