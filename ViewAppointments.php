<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Appointments | Nailspa";
	$strDisplayTitle = "Appointments for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblAppointments";
	$strMyTableID = "AppointmentID";
	$strMyField = "AppointmentDate";
	$strMyActionPage = "Appointments.php";
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
			foreach($_POST as $key => $val)
			{
				if($key!="step")
				{
					if(IsNull($sqlColumn))
					{
						$sqlColumn = $key;
						$sqlColumnValues = "'".$_POST[$key]."'";
					}
					else
					{
						$sqlColumn = $sqlColumn.",".$key;
						$sqlColumnValues = $sqlColumnValues.", '".$_POST[$key]."'";
					}
				}
	
			}
			$strCustomerID = Filter($_POST["CustomerID"]);
			$strStoreID = Filter($_POST["StoreID"]);
			$strAppointmentDate = Filter($_POST["AppointmentDate"]);
			$strSuitableAppointmentTime = Filter($_POST["SuitableAppointmentTime"]);
			$strAppointmentCheckInTime = Filter($_POST["AppointmentCheckInTime"]);
			$strAppointmentCheckOutTime = Filter($_POST["AppointmentCheckOutTime"]);
			$strAppointmentOfferID = Filter($_POST["AppointmentOfferID"]);
			$strStatus = Filter($_POST["Status"]);


			$DB = Connect();
			$sql = "Select $strMyTableID from $strMyTable where $strMyField='$_POST[$strMyField]'";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						<p>Appointment Already Booked!</p>
					</div>
				</div>');
			}
			else
			{
				$sqlInsert = "INSERT INTO $strMyTable (CustomerID, StoreID, AppointmentDate, SuitableAppointmentTime, AppointmentCheckInTime, AppointmentCheckOutTime, AppointmentOfferID, Status) VALUES 
				('".$strCustomerID."', '".$strStoreID."', '".$strAppointmentDate."', '".$strSuitableAppointmentTime."', '".$strAppointmentCheckInTime."', '".$strAppointmentCheckOutTime."', '".$strAppointmentOfferID."', '".$strStatus."')";
				ExecuteNQ($sqlInsert);
				$DB->close();
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
					</div>
				</div>');
			}
		}

		if($strStep=="edit")
		{
			$DB = Connect();
			foreach($_POST as $key => $val)
			{
				if($key=="step" || $key==$strMyTableID)
				{
				
				}
				else
				{
					$sqlUpdate = "UPDATE $strMyTable SET $key='$_POST[$key]' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					ExecuteNQ($sqlUpdate);
				}
			}
			$DB->close();
			die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Updated Successfully</h4>
					</div>
				</div>');
		}
		die();
	}	
	
if(isset($_GET['cid']))
{
	$DB = Connect();
	if(isset($_GET['cid']))
	{
		$sqlUpdate1 = "UPDATE $strMyTable SET Status = '3' WHERE $strMyTableID='".Decode($_GET['cid'])."'";
		ExecuteNQ($sqlUpdate1);
		header('Location: ManageAppointments.php');
	}
	else
	{
		header('Location: ViewAppointments.php');
	}
	$DB->close();
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
			$sqlTempfrom = " AND Date(AppointmentDate)>=Date('".$getfrom."')";
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
			$sqlTempfrom = " AND Date(AppointmentDate)>=Date('".$getfrom."')";
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
                        <p>View, Re-Schedule Appointments</p>
                    </div>
				
					
                    <div class="panel">
						<div class="panel">
							<div class="panel-body">
								<div class="example-box-wrapper">
								<span class="form_result">&nbsp; <br></span>
									<div class="panel-body">
										<h3 class="title-hero">List of Appointments | Nailspa</h3>
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
														<a class="btn btn-link" href="ViewAppointments.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														

													</div>
												
												</form>
												<?php
													if(isset($_GET["toandfrom"]))
													{
												?>
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?></h3>
												
												<br>
												
												
										<div class="example-box-wrapper">
											<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>Sr.No</th>
														<th>Customer Name <br>Mobile No</th>
														<th>Store Name</th>
														<th>Appointment <br>Date & Time</th>
														<th>Offers</th>
														<th>Status</th>
														<th>Action</th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>Sr.No</th>
														<th>Customer Name <br>Mobile No</th>
														<th>Store Name</th>
														<th>Appointment <br>Date & Time</th>
														<th>Offers</th>
														<th>Status</th>
														<th>Action</th>
													</tr>
												</tfoot>
												<tbody>

<?php
// Create connection And Write Values
$DB = Connect();


$FindStore="Select StoreID from tblAdminStore where AdminID=$strAdminID";
// echo $FindStore;
$RSf = $DB->query($FindStore);
if ($RSf->num_rows > 0) 
{
	while($rowf = $RSf->fetch_assoc())
	{
		$strStoreID = $rowf["StoreID"];
		// echo $strStoreID;
	}
}

if($strStoreID!='0')
{
	$sql = "SELECT * FROM tblAppointments WHERE StoreID='$strStoreID' and IsDeleted!='1' $sqlTempfrom $sqlTempto";
	
}
else
{
	$sql = "SELECT * FROM tblAppointments where IsDeleted!='1' $sqlTempfrom $sqlTempto";
	
}

// $sql = "SELECT * FROM tblAppointments WHERE StoreID='$strStoreID'";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
$counter = 0;

while($row = $RS->fetch_assoc())
{
$counter ++;
$strAppointmentID = $row["AppointmentID"];
$getUID = EncodeQ($strAppointmentID);
$getUIDDelete = Encode($strAppointmentID);	
$strCustomerID = $row["CustomerID"];
$strStoreID = $row["StoreID"];	
$AppointmentDate = $row["AppointmentDate"];
$SuitableAppointmentTime = $row["SuitableAppointmentTime"];
$dateObject = new DateTime($SuitableAppointmentTime);
$AppointmentOfferID = $row["AppointmentOfferID"];
$Status = $row["Status"];

?>	
													<tr id="my_data_tr_<?=$counter?>">
														<td><?=$counter?></td>
														<td>
														<?
															$sql_cust = "SELECT * FROM tblCustomers WHERE CustomerID = '".$strCustomerID."'";
															$RS_cust = $DB->query($sql_cust);
															$row_cust = $RS_cust->fetch_assoc();
															$CustomerFullName = $row_cust['CustomerFullName'];
															$CustomerMobileNo = $row_cust['CustomerMobileNo'];
															echo "<b>Name : </b>".$CustomerFullName."<br> <b>Mobile No : </b>".$CustomerMobileNo;
														?>
														</td>
														
														<td>
														<?
														$sql_store = "SELECT * FROM tblStores WHERE StoreID = '".$strStoreID."'";
														$RS_store = $DB->query($sql_store);
														$row_store = $RS_store->fetch_assoc();
														$StoreName = $row_store['StoreName'];
														echo $StoreName;
														?>
														</td>
														
														<td><b>Date : </b><?=$AppointmentDate?><br><b>Time : </b><?//=$SuitableAppointmentTime?>
														<?=$dateObject->format('h:i A')?></td>
														<td><?=$AppointmentOfferID?></td>
														<td>
															<?																		
																if($Status=="0")
																{
																	$Status = "Upcoming";
																}
																elseif($Status=="1")
																{
																	$Status = "In Progress";
																}
																elseif($Status=="2")
																{
																	$Status = "Done";
																}
																elseif($Status=="3")
																{
																	$Status = "Cancelled";
																}
																elseif($Status=="5")
																{
																	$Status = "Delayed";
																}
																elseif($Status=="6")
																{
																	$Status = "Rescheduled";
																}
															echo $Status;
															?>
														</td>
														<td style="text-align: center">
														<?
															if($Status == '0' || $Status == 'Upcoming' || $Status == 'Rescheduled')
															{
																?>
																	<a class="btn btn-link" href="ManageAppointments.php?uid=<?=$getUID?>">Re-Schedule</a><br>
																	<a class="btn btn-link" href="ViewAppointments.php?cid=<?=$getUID?>">Cancel</a>
																<?
															}
															else
															{
																?>
																	<a class="btn btn-link disabled" href="ManageAppointments.php?uid=<?=$getUID?>">Re-Schedule</a><br>
																	<a class="btn btn-link disabled" href="ViewAppointments.php?cid=<?=$getUID?>">Cancel</a>
																<?
															}
														?>
													</td>
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
														<td></td>
													</tr>
<?php
}
$DB->close();
?>
												</tbody>
											</table>
												<div class="fa-hover col-sm-3" style="float: right">	
										<a class="btn btn-primary btn-lg btn-block" href="ManageAppointments.php"><i class="fa fa-backward"></i> &nbsp; View Today's Appointments</a>
									</div>
											<?php
														}	
														else
														{
															echo "<br><center><h3>Please select dates!</h3></center>";
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
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>