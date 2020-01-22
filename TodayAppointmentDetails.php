<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Manage Appointments | NailSpa";
	$strDisplayTitle = "Manage Appointments for NailSpa";
	$strMenuID = "10";
	$strMyTable = "tblAppointments";
	$strMyTableID = "AppointmentID";
	$strMyField = "AppointmentDate";
	$strMyActionPage = "ManageAppointments.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
	?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	<?php require_once("incChart-SalonDashboard.fya"); ?>
	<style>
		.btn-danger:hover
		{
			border-color: #fc8213;
			background: #fc8213;
		}
									
</style>
<!-- Styles -->


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
				
                    <script type="text/javascript" src="assets/widgets/skycons/skycons.js"></script>
                    <script type="text/javascript" src="assets/widgets/datatable/datatable.js"></script>
                    <script type="text/javascript" src="assets/widgets/datatable/datatable-bootstrap.js"></script>
                    <script type="text/javascript" src="assets/widgets/datatable/datatable-tabletools.js"></script>
                    <script type="text/javascript">
                        /* Datatables basic */

                        // $(document).ready(function() {
                            // $('#datatable-example').dataTable();
							// var abc=$("#abc").val();
							// $.ajax({
								// type:"POST",
								// data:"abc="+abc,
								// url:"chartdata.php",
								// success:function(res)
								// {
									// alert(res)
								// }
								
								
							// })
                        // });

                        /* Datatables hide columns */

                        $(document).ready(function() {
                            var table = $('#datatable-hide-columns').DataTable({
                                "scrollY": "300px",
                                "paging": false
                            });

                            $('#datatable-hide-columns_filter').hide();

                            $('a.toggle-vis').on('click', function(e) {
                                e.preventDefault();

                                // Get the column API object
                                var column = table.column($(this).attr('data-column'));

                                // Toggle the visibility
                                column.visible(!column.visible());
                            });
                        });

                        /* Datatable row highlight */

                        $(document).ready(function() {
                            var table = $('#datatable-row-highlight').DataTable();

                            $('#datatable-row-highlight tbody').on('click', 'tr', function() {
                                $(this).toggleClass('tr-selected');
                            });
                        });



                        $(document).ready(function() {
                            $('.dataTables_filter input').attr("placeholder", "Search...");
                        });
                    </script>

				<div class="panel">
						<div class="panel">
							<div class="panel-body">
								
								<div class="example-box-wrapper">
									
							
											
											<div id="normal-tabs-1">
												<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h4 class="title-hero"><center>List of Today's Appointments | NailSpa</center></h4>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Customer Name<br>Mobile No.</th>
																<th>Store Name</th>
																<th>Appointment Date & Time</th>
																<th>Services</th>
																<th>Employee</th>
															    <th>Check In<br>Check Out</th>
																<th>Status</th>
															
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Customer Name<br>Mobile No.</th>
																<th>Store Name</th>
																<th>Appointment Date & Time</th>
																<th>Services</th>
																<th>Employee</th>
																<th>Check In<br>Check Out</th>
																<th>Status</th>
																
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();

//echo 1112;
//Only today's appointments will be listed.
$date=date('Y-m-d');

if($strStoreID!=0)
{
	$sql = "SELECT * FROM tblAppointments WHERE StoreID='$strStoreID' and IsDeleted!='1' AND AppointmentDate = '$date' order by AppointmentID desc";
	// echo "In if";
}
else
{
	$sql = "SELECT * FROM tblAppointments WHERE  AppointmentDate = '$date' and IsDeleted!='1' order by AppointmentID desc";
	// echo "In Else";
}



//echo $sql;
// echo $sql;
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
		// echo $dateObject->format('h:i A');
		// $abc=date("H:i",strtotime($SuitableAppointmentTime));
		$abc=date_format("H:i:s",strtotime($SuitableAppointmentTime));
	
		// $SuitableAppointmentTime=date('y/m/d H:i:s');
		// $newDateTime = date('h:i A', strtotime($SuitableAppointmentTime));
		// echo $newDateTime."<br>"; 
		
		$AppointmentCheckInTime = $row["AppointmentCheckInTime"];
		$AppointmentCheckOutTime = $row["AppointmentCheckOutTime"];
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
																
																<td><b>Date : </b><?=$AppointmentDate?><br><b>Time : </b><?//=$SuitableAppointmentTime."<br>"?>
																<?=$dateObject->format('h:i A')?>
																<?//=$abc?>
																</td>
														
																<td>
																<?php
																$sepp=select("ServiceID","tblAppointmentsDetailsInvoice","AppointmentID='".$strAppointmentID."'");
																foreach($sepp as $tee)
																{
																	$serr=$tee['ServiceID'];
																	$sq=select("*","tblServices","ServiceID='$serr'");
																	
																	?>
																	<table><tr><td><?= $sq[0]['ServiceName'] ." & ".$sq[0]['ServiceCost']?></td></tr></table>
																	<?php
																}
																?>
																
																</td>
																	<td>
																	
																<?php
																if($Status=='2')
																{
																	
																		$seppp=select("distinct(MECID)","tblAppointmentAssignEmployee","AppointmentID='".$strAppointmentID."'");
																foreach($seppp as $teep)
																{
																	$employeecategory=$teep['MECID'];
																	$sq=select("*","tblEmployees","EID='$employeecategory'");
																	
																	?>
																	<table><tr><td><?= $sq[0]['EmployeeName']?></td></tr></table>
																	<?php
																}
																	
																
																}
																else
																{
																
																$seppp=select("distinct(employeecategory)","tblAppointmentsDetailsInvoice","AppointmentID='".$strAppointmentID."'");
																foreach($seppp as $teep)
																{
																	$employeecategory=$teep['employeecategory'];
																	$sq=select("*","tblEmployees","EID='$employeecategory'");
																	
																	?>
																	<table><tr><td><?= $sq[0]['EmployeeName']?></td></tr></table>
																	<?php
																}
																}
																?>
																
																</td>
																	<td style="text-align:center">
																<?
																	if($AppointmentCheckInTime == "00:00:00" && $Status != '3')
																	{
																		?>
																			<a class="btn btn-link" href="<?=$strMyActionPage?>?cin=<?=$getUID?>">Check-In</a>
																		<?
																	}
																	elseif($AppointmentCheckInTime != "00:00:00" && $Status != '3')
																	{
																		$time_in_12_hour_format  = date("g:i a", strtotime($AppointmentCheckInTime));
																		echo "<b>In: </b>".$time_in_12_hour_format;
																	}
																	elseif($Status == '3')
																	{
																		?>
																			<a class="btn btn-link disabled" href="<?=$strMyActionPage?>?cin=<?=$getUID?>">Check-In</a>
																		<?
																	}
																	else
																	{
																		
																	}
																?>
																<br>
																<?
																	// if($AppointmentCheckInTime != "00:00:00" )
																	// {
																		// if($AppointmentCheckOutTime == "00:00:00")
																		// {
																			// ?>
																				<!--<a class="btn btn-link" href="<?=$strMyActionPage?>?cout=<?=$getUID?>">Check-Out</a>-->

																			<?
																		// }
																		// else
																		// {
																			// $time_in_12_hour_formatd  = date("g:i a", strtotime($AppointmentCheckOutTime));
																			// echo "<b>Out: </b>".$time_in_12_hour_formatd;
																		// }
																	// }
																	// elseif($AppointmentCheckInTime == "00:00:00" || $Status == "Cancelled" || $Status == '3')
																	// {
																		// ?>
																			<!--<a class="btn btn-link disabled" href="<?=$strMyActionPage?>?cout=<?=$getUID?>">Check-Out</a>-->
																		 <?
																		//echo $getUID;
																	// }
																	// else
																	// {
																		
																	// }
																	// if($AppointmentCheckInTime != "00:00:00" )
																	// {
																		// if($AppointmentCheckInTime == "00:00:00" )
																		// {
																			//echo $getUID;
	// ?>																		
																			<!-- <a class="btn btn-link" href="appointment_invoice.php?uid=<?//=$strAppointmentID?>">View Invoice</a>-->
	<?																//	}
																		
																	// }
																	if($AppointmentCheckOutTime != "00:00:00" )
																	{
																	
																	}
																	elseif($AppointmentCheckInTime != "00:00:00" )
																	{
																			?>
																		 <a class="btn btn-link" href="<?=$strMyActionPage?>?cout=<?=$getUID?>">Check-Out</a>													<?php				 
																		
																	}
																	
                                       ?>
																
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
																<td></td><td></td>
															</tr>
														
<?php
}
$DB->close();
?>
														
														</tbody>
													</table>
															<div class="fa-hover col-sm-3" style="float: right">	
										<a class="btn ra-100 btn-black-opacity" href="Salon-Dashboard.php" ><span>Go Back</span></a>
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