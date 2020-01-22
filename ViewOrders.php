<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Orders | Nailspa";
	$strDisplayTitle = "Orders for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblAppointments";
	$strMyTableID = "AppointmentID";
	$strMyField = "AppointmentDate";
	$strMyActionPage = "vieworders.php";
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
		header('Location: Vieworders.php');
	}
	$DB->close();
}

	
	
	
	
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
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
					

                    
		
<?
if(isset($_GET['uid']))
{
?>
				<div class="panel">
						<div class="panel-body">
							<div class="fa-hover">	
								<a href="javascript:window.location = document.referrer;" class="btn btn-primary btn-lg btn-block"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
						
							<div class="panel-body">
						
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

									<h3 class="title-hero">Order Details</h3>
									<div class="example-box-wrapper">
					<ul class="list-group row list-group-icons"><li class="col-md-3 active"><a href="#tab-example-4" data-toggle="tab" class="list-group-item">Appointments Details</a></li><li class="col-md-3"><a href="#tab-example-1" data-toggle="tab" class="list-group-item"> Appointments Service Details</a></li><li class="col-md-3"><a href="#tab-example-2" data-toggle="tab" class="list-group-item"> Store Details</a></li><li class="col-md-3"><a href="#tab-example-3" data-toggle="tab" class="list-group-item">Service Details</a></li></ul><div class="tab-content"><div class="tab-pane fade" id="tab-example-1"><div class="alert alert-close alert-success"><a href="#" title="Close" class="glyph-icon alert-close-btn icon-remove"></a><div class="alert-content">
					<?php
				//	$DB = Connect();

$strID = DecodeQ(Filter($_GET['uid']));

?>	
<h4 class="alert-title">Appointment ID <?=$strID?></h4>
					<?php 
					$strID = DecodeQ(Filter($_GET['uid']));
					
					$sql_appointments = select("*","tblAppointmentsDetails","AppointmentID='".$strID."'");
					$sql_appointment = select("*","tblAppointments","AppointmentID='".$strID."'");
					//print_r($sql_appointments);
				//	echo $sql_appointments;
					$sql_name = select("*","tblEmployees
","EID='".$sql_appointments[0]['EmployeeID']."'");
					//$DB->close();
				$sql_store = select("*","tblStores","StoreID='".$sql_appointment[0]['StoreID']."'");
				$sql_cname = select("*","tblCustomers
","CustomerID='".$sql_appointment[0]['CustomerID']."'");
					?>
					
					</div></div>
	
	<div class="row">
    <div class="col-md-6">
        <div class="content-box">
            <form class="form-horizontal clearfix pad15L pad15R pad20B bordered-row">
                <div class="form-group remove-border"><label class="col-sm-7 control-label">Service ID</label>
                    <div class="col-sm-3 control-label"><b><?php echo $sql_appointments[0]['ServiceID']; ?></b></div>
					<label class="col-sm-7 control-label">Service Amount</label>
                    <div class="col-sm-3 control-label"><b><?php echo $sql_appointments[0]['ServiceAmount']; ?></b></div>
					<label class="col-sm-7 control-label">Employee Name</label>
					  <div class="col-sm-3 control-label"><b><?php echo $sql_name[0]['EmployeeName']; ?></b></div>
					  <label class="col-sm-7 control-label">Employee Code</label>
					  <div class="col-sm-3 control-label"><b><?php echo $sql_name[0]['EmployeeCode']; ?></b></div>
					  <label class="col-sm-7 control-label">Employee Address</label>
					  <div class="col-sm-3 control-label"><b><?php echo $sql_name[0]['EmployeeAddress']; ?></b></div>
					  <label class="col-sm-7 control-label">Employee Email</label>
					  <div class="col-sm-3 control-label"><b><?php echo $sql_name[0]['EmployeeEmailID']; ?></b></div>
					  	  <label class="col-sm-7 control-label">Employee Pincode</label>
					  <div class="col-sm-3 control-label"><b><?php echo $sql_name[0]['EmployeePincode']; ?></b></div>
					  	  <label class="col-sm-7 control-label">Employee Mobile</label>
					  <div class="col-sm-3 control-label"><b><?php echo $sql_name[0]['EmployeeMobileNo']; ?></b></div>
					    <label class="col-sm-7 control-label">Store Name</label>
					  <div class="col-sm-3 control-label"><b><?php echo $sql_store[0]['StoreName']; ?></b></div>
					  	
                </div>
           
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="content-box mrg15B">
        
            <div class="content-box-wrapper pad0T clearfix">
                <form class="form-horizontal pad15L pad15R bordered-row">
                    <div class="form-group"><label class="col-sm-6 control-label">Customer Name:</label>
                        <div class="col-sm-6 control-label"><b><?php echo $sql_cname[0]['CustomerFullName']; ?></b></div>
                    </div>
                    <div class="form-group"><label class="col-sm-6 control-label">Customer Email:</label>
                        <div class="col-sm-6 control-label"><b><?php echo $sql_cname[0]['CustomerEmailID']; ?></b></div>
                    </div>
                    <div class="form-group"><label class="col-sm-6 control-label">Customer Mobile:</label>
                        <div class="col-sm-6 control-label"><b><?php echo $sql_cname[0]['CustomerMobileNo']; ?></b></div>
                    </div>
                </form>
            </div>
          
        </div>
    </div>
</div>
	
	
	
	
	
					
					
					
					
					
					
					
					</div>
					
				
				<div class="tab-pane fade" id="tab-example-2">
    <div class="content-box pad25A">
        <ul class="chat-box">
            
           
            <li class="float-left">
                <div class="popover right no-shadow">
                    <div class="arrow"></div>
                    <div class="popover-content"><p>
					<b>Store Name : <?=$sql_store[0]['StoreName']?></b><br/>
					<b>Store Official Address : <?=$sql_store[0]['StoreOfficialAddress']?></b><br/>
					<b>Store Billing Address : <?=$sql_store[0]['StoreBillingAddress']?></b><br/>
					<b>Store Official Email ID : <?=$sql_store[0]['StoreOfficialEmailID']?></b><br/>
					<b>Store Official Number : <?=$sql_store[0]['StoreOfficialNumber']?></b><br/>
					<b>Store Billing Number : <?=$sql_store[0]['StoreBillingNumber']?></b>
					</p>   
                    </div>
                </div>
            </li>
        </ul>
        </div>
    </div>
				
				
				
					
						<?php 
					$strID = DecodeQ(Filter($_GET['uid']));
					
					$sql_appointments = select("*","tblAppointmentsDetails","AppointmentID='".$strID."'");
					$sql_appointment = select("*","tblAppointments","AppointmentID='".$strID."'");
					//print_r($sql_appointments);
				//	echo $sql_appointments;
					$sql_name = select("*","tblEmployees
","EID='".$sql_appointments[0]['EmployeeID']."'");
					//$DB->close();
		
				$sql_cname = select("*","tblCustomers
","CustomerID='".$sql_appointment[0]['CustomerID']."'");
	$sql_services = select("*","tblServices
","ServiceID='".$sql_appointments[0]['ServiceID']."'");
		$sql_store = select("*","tblStores","StoreID='".$sql_appointment[0]['StoreID']."'");
					?>
					
					<div class="tab-pane fade" id="tab-example-3">
    <div class="row">
        <div class="col-md-3">
            <ul class="list-group">
                <li class="mrg10B"><a href="#faq-tab-1" data-toggle="tab" class="list-group-item"><?=$sql_services[0]['ServiceName']?><i class="glyph-icon icon-angle-right mrg0A"></i></a></li>
              
            </ul>
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <div class="tab-pane fade active in pad0A" id="faq-tab-1">
                    <div class="panel-group" id="accordion5">
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion5" href="#collapseOne"><?php echo $sql_store[0]['StoreName']; ?></a></h4></div>
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body"><p><b>Service Code : <?=$sql_services[0]['ServiceCode']?></b><br/>
								<b>Service Cost : <?=$sql_services[0]['ServiceCost']?></b><br/>
								<b>Service Commission : <?=$sql_services[0]['ServiceCommission']?></b><br/>
								<b>MRP Less Tax : <?=$sql_services[0]['MRPLessTax']?></b><br/>
								<b>Direct Cost : <?=$sql_services[0]['DirectCost']?></b><br/>
								<b>GM Percentage : <?=$sql_services[0]['GMPercentage']?></b><br/>
								<b>Gross Margin : <?=$sql_services[0]['GrossMargin']?></b>
								
								<p></div>
                            </div>
                        </div>
                       
                      
                    </div>
                </div>

             
  
            </div>
        </div>
    </div>
</div>
					
					
					
					
					
					
					
					<div class="tab-pane pad0A fade active in" id="tab-example-4"><div class="content-box">
					<?php
					$DB = Connect();

$strID = DecodeQ(Filter($_GET['uid']));
//$sql_appointments = "SELECT * FROM tblAppointments WHERE AppointmentID='".$strID."'";
$sql_appointments = select("*","tblAppointments","AppointmentID='".$strID."'");
$sql_name = select("CustomerFullName","tblCustomers
","CustomerID='".$sql_appointments[0]['CustomerID']."'");
$sql_store = select("StoreName","tblStores","StoreID='".$sql_appointments[0]['StoreID']."'");

?>	
					
					
											<form class="form-horizontal pad15L pad15R bordered-row">
													<div class="form-group remove-border"><label class="col-sm-3 control-label">Customer Name</label>
														<div class="col-sm-6"><label class="col-sm-3 control-label"><?php echo $sql_name[0]['CustomerFullName']; ?></label></div>
													</div>
													<div class="form-group"><label class="col-sm-3 control-label">Store Name:</label>
														<div class="col-sm-6">
															<label class="col-sm-3 control-label"><?php echo $sql_store[0]['StoreName']; ?>
															</label></div>
													</div>
													<div class="form-group"><label class="col-sm-3 control-label">Appointment Date:</label>
														<div class="col-sm-6"><label class="col-sm-3 control-label"><?php echo $sql_appointments[0]['AppointmentDate']; ?>	</label></div>
													</div>
													<div class="form-group"><label class="col-sm-3 control-label">Appointment Offer ID:</label>
														<div class="col-sm-6"><label class="col-sm-3 control-label"><?php echo $sql_appointments[0]['AppointmentOfferID']; ?>	</label></div>
													</div>
													<div class="form-group"><label class="col-sm-3 control-label">Appointment Check In Time:</label>
														<div class="col-sm-6"><label class="col-sm-3 control-label"><?php echo $sql_appointments[0]['AppointmentCheckInTime']; ?></label></div>
													</div>
													<div class="form-group"><label class="col-sm-3 control-label">Appointment Check Out Time:</label>
														<div class="col-sm-6">
															<label class="col-sm-3 control-label"><?php echo $sql_appointments[0]['AppointmentCheckOutTime']; ?>
															</label>
														</div>
													</div>
												</form>
											
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
	?>
			
					
                    <div class="panel">
						<div class="panel">
							<div class="panel-body">
								<div class="example-box-wrapper">
								<span class="form_result">&nbsp; <br></span>
									<div class="panel-body">
										<h3 class="title-hero">List of Orders | Nailspa</h3>
										<div class="example-box-wrapper">
											<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>Sr.No</th>
														<th>Customer Name <br>Mobile No</th>
														<th>Store Name</th>
														<th>Order <br>Date & Time</th>
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
														<th>Order <br>Date & Time</th>
														<th>Offers</th>
														<th>Status</th>
														<th>Action</th>
													</tr>
												</tfoot>
												<tbody>

<?php
// Create connection And Write Values
$DB = Connect();

$sql = "SELECT * FROM ".$strMyTable;
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
														
														<td><b>Date : </b><?=$AppointmentDate?><br><b>Time : </b><?=$SuitableAppointmentTime?></td>
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
															echo $Status;
															?>
														</td>
														<td style="text-align: center">
															<?
															if($Status == '0' || $Status == 'Upcoming')
															{
																?>
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">View Details</a><br>
																	<a class="btn btn-link" href="ViewAppointments.php?cid=<?=$getUID?>">Cancel</a>
																<?
															}
															else
															{
																?>
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">View Details</a><br>
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
										</div>
									</div>
									<div class="fa-hover col-sm-3" style="float: right">	
										<a class="btn btn-primary btn-lg btn-block" href="ManageAppointments.php"><i class="fa fa-backward"></i> &nbsp; View Today's Appointments</a>
									</div>
								</div>
							</div>
						</div>
                    </div> 
	
	<?php
}
?>
						
                      </div>
                    </div>
                  </div>
            		 
          
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>