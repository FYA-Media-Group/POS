<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Manage Appointments | NailSpa";
	$strDisplayTitle = "Manage Appointments for NailSpa";
	$strMenuID = "10";
	$strMyTable = "tblAppointments";
	$strMyTableID = "AppointmentID";
	$strMyField = "AppointmentDate";
	$strMyActionPage = "45AppointmentConfirm.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
// code for not allowing the normal admin to access the super admin rights	

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
                                format: 'yyyy-mm-dd'
                            });
                        });
                    </script>
                    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker.js"></script>
                    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker-demo.js"></script>
                    <script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>
                    <script type="text/javascript" src="assets/widgets/timepicker/timepicker.js"></script>
                    <script type="text/javascript">
                        /* Timepicker */

                        $(function() {
                            "use strict";
                            $('.timepicker-example').timepicker();
                        });
                    </script>
					<script>
						$(function ()						
						{
							$("#AppointmentDate").datepicker({ minDate: 0 });
							$("#AppointmentDate").datepicker({ minDate: 0 });
						});
					</script>
				<script>
					function LoadValue(OptionValue)
					{                
						// alert (OptionValue);
						$.ajax({
							type: 'POST',
							url: "GetServicesStoreWise.php",
							data: {
								id:OptionValue
							},
							success: function(response) {
							//	alert(response)
								$("#asmita").html("");
								$("#asmita1").html("");
								$("#asmita").html(response);
									
							},
							error: function(XMLHttpRequest, textStatus, errorThrown) {
								$("#asmita").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
								return false;
								alert (response);
							}
						});
					}
					function LoadValueasmita()
					{
						
						valuable=[];
						var valuable = $('#Services').val();
						var store = $('#StoreID').val();
						
						//alert(store)
								 $.ajax({
									type: 'POST',
									url: "servicedetail.php",
									data: {
										id:valuable,
										stored:store
									},
									success: function(response) {
										//alert(response)
										$("#asmita1").html("");
										$("#asmita1").html(response);
											
									},
									error: function(XMLHttpRequest, textStatus, errorThrown) {
										$("#asmita1").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
										return false;
										//alert (response);
									}
								}); 
					}
					function LoadValueon()
					{                
						// alert (OptionValue);
						var OptionValue=document.getElementById("StoreID")
						alert(OptionValue);
						$.ajax({
							type: 'POST',
							url: "GetServicesStoreWise.php",
							data: {
								id:OptionValue
							},
							success: function(response) {
							//	alert(response)
								$("#asmita").html("");
								$("#asmita1").html("");
								$("#asmita").html(response);
									
							},
							error: function(XMLHttpRequest, textStatus, errorThrown) {
								$("#asmita").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
								return false;
								alert (response);
							}
						});
					}
					function UpdateConfirm(evt)
					{
							var app = $(evt).closest('td').find('input').val();
							// alert(app)
							if(app!='')
							{
									$.ajax({
										type: 'POST',
										url: "Update45minstatus.php",
										data:"app="+app,
										success: function(response) {
											//alert(response)
											if(response=='2')
											{
												location.reload();
											}
											
										//	alert(response)
										/* 	$("#asmita").html("");
											$("#asmita1").html("");
											$("#asmita").html(response); */
												
										}
									});
							}
					}
				</script>
	
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
                        <p>Confirm Appointments</p>
                    </div>
              
						  <div class="panel">
						<div class="panel">
							<div class="panel-body">
								
								<div class="example-box-wrapper">
									<div class="tabs">
									<ul>
											<li><a href="#normal-tabs-1" title="Tab 1">Need To Confirm</a></li>
											<li><a href="#normal-tabs-2" title="Tab 2">Confirmed Appointments</a></li>
										
											
										</ul>
											<div id="normal-tabs-1">
												<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Today's Appointments | NailSpa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Customer Name<br>Mobile No.</th>
																<th>Store Name</th>
																<th>Appointment <br>Date & Time</th>
																<th>Status</th>
                                                                <th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Customer Name<br>Mobile No.</th>
																<th>Store Name</th>
																<th>Appointment <br>Date & Time</th>
															    <th>Status</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
//echo 1112;
//Only today's appointments will be listed.
$date=date('Y-m-d');
// $sql = "SELECT * FROM ".$strMyTable." WHERE  AppointmentDate = '$date' and AppointmentCheckInTime='00:00:00' and 45minstatus='0' and Status IN('0','5','6') and Status!='3' order by $strMyTableID desc";
$hourCurrent = date('H:i:s');
$sql = "SELECT * FROM ".$strMyTable." WHERE  AppointmentDate = '$date' and AppointmentCheckInTime='00:00:00' and 45minstatus='0' and SuitableAppointmentTime<='$hourCurrent' and Status IN('0','5','6') and Status!='3' order by $strMyTableID desc";

// echo $sql."<br>";

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
		date_default_timezone_set('Asia/Kolkata');
		$SuitableAppointmentTime = $row["SuitableAppointmentTime"];
		$dateObject = new DateTime($SuitableAppointmentTime);
		$abc=date_format("H:i:s",strtotime($SuitableAppointmentTime));
		$AppointmentCheckInTime = $row["AppointmentCheckInTime"];
		$AppointmentCheckOutTime = $row["AppointmentCheckOutTime"];
		$AppointmentOfferID = $row["AppointmentOfferID"];
		$Status = $row["Status"];
		$seldataqt=select("Flag","tblInvoiceDetails","AppointmentId='".$strAppointmentID."'");
	    $Flag=$seldataqt[0]['Flag'];
		$timestamp =  date("H:i:s", time());
		$date1=$timestamp;
		$date2=$SuitableAppointmentTime;
		$dateyu=Date('Y-m-d H:i:s');
				
       
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
																
																<td><b>Date : </b><?=$AppointmentDate?><br><b>Time : </b><?//=$SuitableAppointmentTime."<br>"?>
																<?=$dateObject->format('h:i A')?>
																<?//=$abc?>
																</td>
														
																<td>
																	<?																		
																		if($Status=="0")
																		{
																			$time=date('H:i:s',strtotime($SuitableAppointmentTime));
																				if($time <= date('H:i:s')){ 
																				 $Status = 'Late';
																				}
																				else
																				{
																					 $Status = "Upcoming";
																					
																				}
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
																			$Status = "Late";
																		}
																		elseif($Status=="6")
																		{
																			$Status = "Rescheduled";
																		}
																	echo $Status;
																	?>
																</td>
																
																<td style="text-align: center">
																	
																		<input type="hidden" value="<?=$strAppointmentID?>" /><a class="btn btn-link" onclick="UpdateConfirm(this)">Open Appointment</a>
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
															</tr>
														
<?php
}
$DB->close();
?>
														
														</tbody>
													</table>
												</div>
											</div>
										
										</div>
										<div id="normal-tabs-2">
												<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Today's Appointments | NailSpa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Customer Name<br>Mobile No.</th>
																<th>Store Name</th>
																<th>Appointment <br>Date & Time</th>
																<th>Status</th>
                                                                <th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Customer Name<br>Mobile No.</th>
																<th>Store Name</th>
																<th>Appointment <br>Date & Time</th>
															    <th>Status</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
//echo 1112;
//Only today's appointments will be listed.
$date=date('Y-m-d');
// $sql = "SELECT * FROM ".$strMyTable." WHERE  AppointmentDate = '$date' and AppointmentCheckInTime='00:00:00' and 45minstatus='0' and Status IN('0','5','6') and Status!='3' order by $strMyTableID desc";
$hourCurrent = date('H:i:s');
$sql = "SELECT * FROM ".$strMyTable." WHERE  AppointmentDate = '$date' and AppointmentCheckInTime='00:00:00' and 45minstatus='1' and SuitableAppointmentTime<='$hourCurrent' and Status IN('0','5','6') and Status!='3' order by $strMyTableID desc";

// echo $sql."<br>";

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
		date_default_timezone_set('Asia/Kolkata');
		$SuitableAppointmentTime = $row["SuitableAppointmentTime"];
		$dateObject = new DateTime($SuitableAppointmentTime);
		$abc=date_format("H:i:s",strtotime($SuitableAppointmentTime));
		$AppointmentCheckInTime = $row["AppointmentCheckInTime"];
		$AppointmentCheckOutTime = $row["AppointmentCheckOutTime"];
		$AppointmentOfferID = $row["AppointmentOfferID"];
		$Status = $row["Status"];
		$seldataqt=select("Flag","tblInvoiceDetails","AppointmentId='".$strAppointmentID."'");
	    $Flag=$seldataqt[0]['Flag'];
		$timestamp =  date("H:i:s", time());
		$date1=$timestamp;
		$date2=$SuitableAppointmentTime;
		$dateyu=Date('Y-m-d H:i:s');
				
       
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
																
																<td><b>Date : </b><?=$AppointmentDate?><br><b>Time : </b><?//=$SuitableAppointmentTime."<br>"?>
																<?=$dateObject->format('h:i A')?>
																<?//=$abc?>
																</td>
														
																<td>
																	<?																		
																		if($Status=="0")
																		{
																			$time=date('H:i:s',strtotime($SuitableAppointmentTime));
																				if($time <= date('H:i:s')){ 
																				 $Status = 'Late';
																				}
																				else
																				{
																					 $Status = "Upcoming";
																					
																				}
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
																			$Status = "Late";
																		}
																		elseif($Status=="6")
																		{
																			$Status = "Rescheduled";
																		}
																	echo $Status;
																	?>
																</td>
																
																<td style="text-align: center">
																	
																Appointment Confirmed
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
															</tr>
														
<?php
}
$DB->close();
?>
														
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
						
          
                   </div>		    
                  </div>	
                 </div>
            </div>	
        
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>