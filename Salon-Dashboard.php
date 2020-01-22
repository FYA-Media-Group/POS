<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	<?php require_once("incChartScriptEmployeeSale-Salon.fya"); ?>
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
						function check_appoint()
						{
							alert('This Appointment Is Lock Please Contact To Ho')
						}
						function updatevalues(evt)
						{
							
							 var cust=$(evt).closest('td').prev().prev().prev().find('input').val();
							//alert(ordid)
								var remark=$(evt).closest('td').prev().html();
							
							
							
						if(cust!="")
							{
								$.ajax({
									type:"post",
									data:"cust="+cust+"&remark="+remark,
									url:"UpdateNonCustomerRemark.php",
									success:function(result)
									{
							//	alert(result);
									if($.trim(result)=='2')
									{
										alert('Record Updated Successfully')
									// window.location="Salon-Dashboard.php";
									}
									}
									
									
								})
							}
						}
						function updatevalues1(evt)
						{
							
							 var cust=$(evt).closest('td').prev().prev().prev().find('input').val();
							
								var remark=$(evt).closest('td').prev().html();
							
							
							
						if(cust!="")
							{
								$.ajax({
									type:"post",
									data:"cust="+cust+"&remark="+remark,
									url:"UpdateServiceReminderRemark.php",
									success:function(result)
									{
							//	alert(result);
									if($.trim(result)=='2')
									{
									 alert('Record Updated Successfully')
									}
									}
									
									
								})
							}
						}
									     function checkgraphtype(eee)
						{
							//alert(eee)
							//var grphtype = $(eee).val();
							if(eee!='0')
							{
								
								if(eee=='1')
								{
									$(".checkcustomeduration").hide();
									$.ajax({
									type:"post",
									data:"grphtype="+eee,
									url:"UpdateGraphData.php",
									success:function(result)
									{
										window.location = "Salon-Dashboard.php";

									}
									
								  })
								}
								else if(eee=='2')
								{
									$(".checkcustomeduration").hide();
									$.ajax({
									type:"post",
									data:"grphtype="+eee,
									url:"UpdateGraphData.php",
									success:function(result)
									{
										//alert(result)
										window.location = "Salon-Dashboard.php";
							           //location.reload();
									}
									
								  })
								}
								else
								{
									$(".checkcustomeduration").show();
									//var grpcu=$("#checkgraphcustom").val();
									//alert(grpcu)
								/* 	$.ajax({
									type:"post",
									data:"grphtype="+eee,
									url:"GenerateCustomGraphDuration.php",
									success:function(result)
									{
										alert(result)
							           location.reload();
									}
									
								  }) */
									//displaycustomduration
								}
							}
						}
						function checksubgraphcustom(ety)
						{
							
								$.ajax({
									type:"post",
									data:"month="+ety,
									url:"UpdateGraphData.php",
									success:function(result)
									{
										window.location = "Salon-Dashboard.php";
									}
									
								  })
						}
                    </script>
                   
					<?php
						$DB = Connect();
								// echo $strAdminID;
								// echo "hello";
								$FindRole="Select AdminRoleID from tblAdmin where AdminID=$strAdminID";
								// echo $FindStore;
								$RSabc = $DB->query($FindRole);
								if ($RSabc->num_rows > 0) 
								{
									while($rowabc = $RSabc->fetch_assoc())
									{
										// $strStoreID = $rowf["StoreID"];
										$strRoleID = $rowabc["AdminRoleID"];
										// echo $strRoleID;
									}
								}
						if($strRoleID=='36')
						{
?>							
							<div id="page-title">
								<h2>Dashboard<?//=$strRoleID?></h2>
							</div>
<?php							
						}
						elseif($strRoleID=='6')
						{
							// echo "in else if<br>";
							// echo $FindStore;
?>
							<div id="page-title">
								<?php require_once("incDayClosing.php"); ?>
							</div>
<?php							
						}
						elseif($strRoleID=='38')
						{
?>							
							<div id="page-title">
								<h2>Dashboard<?//=$strRoleID?></h2>
							</div>
<?php							
						}
						else
						{
?>							
							<div id="page-title">
								<h2>Dashboard<?//=$strRoleID?></h2>
							</div>
<?php							
						}
						
					?>
				<?php
				if(isset($_GET['confirm']))
				{
					$DB = Connect();
					$app_id=$_GET['confirm'];
					$Appointmentid=DecodeQ($app_id);
						$sqlUpdate1 = "UPDATE tblAppointments SET CheckConfirm='1' WHERE AppointmentID='".$Appointmentid."'";
					ExecuteNQ($sqlUpdate1);
					echo("<script>location.href='Salon-Dashboard.php';</script>");
				}
				?>
                    <div class="row">
				<span id="abc" style="display:none"></span>
                        <div class="col-md-8">
		
                            <div class="row">
                              	<div class="col-md-4">
                                    <a href="DisplaySalonCustomerDetails.php" title="Non-Visiting Clients" class="tile-box tile-box-shortcut btn-warning" style="
    background: #FF5733; border-color:#FF5733;" id="ModalOpenBtnn">
									<span class="bs-badge badge-absolute">
<?php					
$DB = Connect();				
									$date=date('Y-m-d');
									$First= date('Y-m-01');
									$Last= date('Y-m-t');
if($strStore!='0')
{
$NONVISITING=select("CustomerID","tblCustomers","Status='0'");
foreach($NONVISITING as $va)
{
	$CustomerID = $va["CustomerID"];
}									
		$ct=0;
	$n5_daysAgo = date('Y-m-d', strtotime('-25 days', time()));
	$todaydate=date('Y-m-d');
										  $stqy=select("distinct(CustomerID)","tblAppointments","StoreID='$strStore' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgo."'");
											
											foreach($stqy as $vatq)
											{
												$CU[]=$vatq['CustomerID'];
											}
										if($strStore!='0')
										{
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
											$Productst="Select distinct(tblCustomers.CustomerID) from tblCustomers Left Join tblAppointments ON tblCustomers.CustomerID=tblAppointments.CustomerID WHERE tblAppointments.StoreID='$strStore' and tblAppointments.AppointmentDate<='".$n5_daysAgo."' and tblAppointments.AppointmentDate>='2017-02-01'";
										}
										if($strStore!='0')
										{
											$stqytq=select("distinct(CustomerID)","tblAppointments","StoreID='$strStore' and AppointmentDate<='".$n5_daysAgo."' and AppointmentDate>='2017-02-01' and CommentType!='0' and CustomerRemark!=''");
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
										
										}
										
										foreach($stqytq as $vatqq)
											{
												$CUP[]=$vatqq['CustomerID'];
											}
										
										//echo $Productst;
											$RSaT = $DB->query($Productst);
										if ($RSaT->num_rows > 0) 
										{
											while($rowa = $RSaT->fetch_assoc())
											{
									           $Customer=$rowa['CustomerID'];
									
											if(in_array("$Customer",$CU))
											{
												
											}
											else
											{
												if(in_array("$Customer",$CUP))
												{
													
												}
												else
												{
												$ct++;
												}
												
											}
											
											}
										echo $ct;
							
								
										}
										else
										{
											echo $ct=0;
										}
	
	
										
										}
$DB->close();
?>	
										
									</span>
                                        <div class="tile-header">Service Reminder</div>
                                        <div class="tile-content-wrapper"></div>
                                    </a>
											<div class="modal fade" id="myModalcust" role="dialog">
																<div class="modal-dialog">
																
																  <!-- Modal content-->
																	<div class="modal-content">
																	
																		<div class="modal-body">
																			   <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
																			    <thead>
																				  <tr><th>Customer</th><th>Mobile</th><th>Non Visting Remark</th><th>Action</th></tr>
																				   </thead>
																				    <tbody>
																		<?php
                                                                  $DB = Connect();
											$n5_daysAgot = date('Y-m-d', strtotime('-25 days', time()));
										  $todaydate=date('Y-m-d');
										  $stqy=select("distinct(CustomerID)","tblAppointments","StoreID='$strStore' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgot."'");
											
											foreach($stqy as $vatq)
											{
												$CU[]=$vatq['CustomerID'];
											}
										if($strStore!='0')
										{
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
											$Productst="Select distinct(tblAppointments.AppointmentID) from tblCustomers Left Join tblAppointments ON tblCustomers.CustomerID=tblAppointments.CustomerID WHERE tblAppointments.StoreID='$strStore' and tblAppointments.AppointmentDate<='".$n5_daysAgot."' and tblAppointments.AppointmentDate>='2017-02-01'";
										}
									
										//echo $Productst;
											$RSaT = $DB->query($Productst);
										if ($RSaT->num_rows > 0) 
										{
											while($rowa = $RSaT->fetch_assoc())
											{
												$AppointmentID=$rowa['AppointmentID'];
												$selpqtyP=select("*","tblAppointments","AppointmentID='".$AppointmentID."'");
												$Customer=$selpqtyP[0]['CustomerID'];
												
												$EncodedCustomerID = EncodeQ($Customer);
											
										
											
											
											if(in_array("$Customer",$CU))
											{
												
											}
											else
											{
												
												$selpqtyP=select("*","tblCustomers","CustomerID='".$Customer."'");
												$customerfullname=$selpqtyP[0]['CustomerFullName'];
												    $CustomerMobileNo=$selpqtyP[0]['CustomerMobileNo'];
												    $NonCustomerRemark=$selpqtyP[0]['NonCustomerRemark'];
													 ?>
											<tr>
												<td>
													<input type="hidden" id="cust_id"  value="<?=$Customer?>"/>
													<?=$Customer?><?=$customerfullname?>
												</td>
												<td>
													<?=$CustomerMobileNo?>
												</td>
												<td> <!--contenteditable='true' id="remark" -->
													<input type="hidden" id="AppointmentBookingURL<?=$Customer?>" value="ManageAppointments.php?bid=<?=EncodeQ($Customer)?>">
													<input type="hidden" id="PassEncodedID<?=$Customer?>" value="<?=EncodeQ($Customer)?>">
													<input type="hidden" id="app_id" value="<?=$AppointmentID?>">
													<?// =$NonCustomerRemark?>
													<select id="SelectOptions<?=$Customer?>" onChange="ChangeDisp(<?=$Customer?>)" class="form-control">
														<option value="">-- Select --</option>
														<option value="1"><?// =$EncodedCustomerID?>Book Now</option>
														<option value="2">Call Later</option>
														<option value="3">Client Unavailable</option>
														<option value="4">Client Travelling</option>
														<option value="5">Unhappy with Service/Staff</option>
														<option value="6">Service is Expensive</option>
														<option value="7">Unhappy with Products</option>
														<option value="8">Occassional Visitor</option>
														<option value="9">Not Interested</option>
													</select>
												</td>
		<script>
			function ChangeDisp(PassCustomerID)
			{
				var option = document.getElementById("SelectOptions"+PassCustomerID).value;
				if(option=="1")
				{
					var MakeID = "AppointmentBookingURL"+PassCustomerID;
					// alert (MakeID);
					var UrlString = document.getElementById(MakeID).value;
					//alert(UrlString);
					window.open(UrlString);
				}
				else
				{
					OpenInput(PassCustomerID);
				}
				
			}
			function OpenInput(PassCustomerID)
			{
				var MakeID = "PassEncodedID"+PassCustomerID;
				// alert (MakeID);
				var EncodedString = document.getElementById(MakeID).value;
				// alert(UrlString);
				
				var myWindow = window.open("", EncodedString, "width=600,height=300");
				myWindow.document.write('<form target="_blank" action="test.php?" method="POST"><input type="hidden" name="CustomerID" id="CustID" value="'+myWindow.name+'"><textarea name="Message"></textarea><br><a target="_blank"><input type="Submit" value="Click me!"></a></form>');
			}
		
		</script>
												<td>
													<a class="btn btn-link" href="#" onclick="updatevalues(this)">Update</a>
												</td>
											</tr>
													<?php
											}
											
											}
										}
										else
										{
											?>
											<tr><td>No Records</td><td></td><td></td><td></td></tr>
											<?php
										}
											  ?>
												 </tbody>
																		 </table>
																		</div>
																		<div class="modal-footer">
																		
																		  <button type="button" class="btn ra-100 btn-primary" data-dismiss="modal">Close</button>
																		</div>
																	</div>
																  
																</div>
															</div>
                                </div>
                                
                                <div class="col-md-4">
								<a href="#" class="tile-box tile-box-shortcut btn-warning" style="background: #8e668c; border-color:#8e668c;" id="ModalOpenBtn" data-toggle="modal" data-target="#myModalsAppointment">
                                  
									<span class="bs-badge badge-absolute">
<?php									
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
												// echo "Hello";
											}
										}
										$date=date('y-m-d');
										if($strStoreID!=0)
										{
											// echo "In if";
											$App="Select (SELECT count(0) FROM `tblAppointments` where StoreID='$strStoreID' and AppointmentDate='$date') as TodaysAppointment";
											// echo $App."<br>";
											$RSc = $DB->query($App);
											if ($RSc->num_rows > 0) 
											{
												while($rowc = $RSc->fetch_assoc())
												{
													$TodayApp = $rowc["TodaysAppointment"];
													echo $TodayApp;
												}
											}
										}
										else
										{
											// echo "In else";
											$App="Select (SELECT count(0) FROM `tblAppointments` where AppointmentDate='$date') as TodaysAppointment";
											// echo $App."<br>";
											$RSc = $DB->query($App);
											if ($RSc->num_rows > 0) 
											{
												while($rowc = $RSc->fetch_assoc())
												{
													$TodayApp = $rowc["TodaysAppointment"];
													echo $TodayApp;
												}
											}
										}
										
										$DB->close();
?>	
										
									</span>
									    
                                        <div class="tile-header">Today's Appointments </div>
										
                                        <div class="tile-content-wrapper"></div>
                                  </a>
								  <div class="modal fade" id="myModalsAppointment" role="dialog">
																<div class="modal-dialog modal-dialog modal-lg">
																
																  <!-- Modal content-->
																	<div class="modal-content">
																	
																		<div class="modal-body">
																			   <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
																			    <thead>
																					<tr><th>Sr.No</th>
																					<th>Customer Name<br>Mobile No.</th>
																					<th>Store Name</th>
																					<th>Appointment Date & Time</th>
																					<th>Services</th>
																					<th>Employee</th>
																					<th>Check In<br>Check Out</th>
																					<th>Status</th></tr>
																				   </thead>
																				    <tbody>
																				<?php
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
																		</div>
																		<div class="modal-footer">
																		  <button type="button" class="btn ra-100 btn-primary" data-dismiss="modal">Close</button>
																		</div>
																	</div>
																  
																</div>
															</div>
                                </div>
								
								<div class="col-md-4">
							<?php 
							//DisplaySalonNonCustomerDetails.php
							?>
                                    <a href="DisplaySalonNonCustomerDetails.php" title="Non-Visiting Clients" class="tile-box tile-box-shortcut btn-warning" style="
    background: #FA8072 ; border-color:#FA8072  ;" id="ModalOpenBtnn" >
									<span class="bs-badge badge-absolute">
<?php					
$DB = Connect();				
									$date=date('Y-m-d');
									$First= date('Y-m-01');
									$Last= date('Y-m-t');
if($strStore!='0')
{
					
   $ctt=0;
											  $n5_daysAgoty = date('Y-m-d', strtotime('-60 days', time()));	
											  $todaydate=date('Y-m-d');
								              $stqy=select("distinct(CustomerID)","tblAppointments","StoreID='$strStore' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgoty."'");
											
											foreach($stqy as $vatq)
											{
												$CUt[]=$vatq['CustomerID'];
											}
											
										if($strStore!='0')
										{
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
											//$Productst="Select distinct(tblAppointments.AppointmentID) from tblCustomers Left Join tblAppointments ON tblCustomers.CustomerID=tblAppointments.CustomerID WHERE tblAppointments.StoreID='$strStore' and tblAppointments.AppointmentDate<='".$n5_daysAgot."' and tblAppointments.AppointmentDate>='2016-11-15' group by tblAppointments.CustomerID order by tblAppointments.AppointmentID desc";
											
										$Productst="Select distinct(CustomerID) from tblAppointments WHERE StoreID='$strStore' and AppointmentDate<='".$n5_daysAgoty."' and AppointmentDate>='2017-02-01'";
										}
									
									if($strStore!='0')
										{
											$stqytq=select("distinct(CustomerID)","tblAppointments","StoreID='$strStore' and AppointmentDate<='".$n5_daysAgoty."' and AppointmentDate>='2017-02-01' and NonCustomerCommentType!='0' and NonCustomerRemark!=''");
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
										
										}
										
										foreach($stqytq as $vatqq)
											{
												$CUPt[]=$vatqq['CustomerID'];
											}
										
											$RSaT = $DB->query($Productst);
					                  if ($RSaT->num_rows > 0) 
										{
											$counter=0;
											while($rowa = $RSaT->fetch_assoc())
											{
												$counter++;
												
												$Customer=$rowa['CustomerID'];
												
												$EncodedCustomerID = EncodeQ($Customer);
											
											if(in_array("$Customer",$CUt))
											{
												
											}
											else
											{
												
												if(in_array("$Customer",$CUPt))
												{
													
												}
												else
												{
													
													$ctt++;
												
												}
											
													
	
													
												
											}
											
											}
											echo $ctt;
										}
										else
										{
											 $ctt=0;
										}
	
										}
										if($ctt=="")
										{
											$ctt=0;
										}

?>	
										
									</span>
									
                                        <div class="tile-header">Non-Visiting Clients</div>
                                        <div class="tile-content-wrapper"></div>
                                    </a>
											
											<div class="modal fade" id="myModalcusttt" role="dialog">
																<div class="modal-dialog">
																
																  <!-- Modal content-->
																	<div class="modal-content">
																	
																		<div class="modal-body">
																			   <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
																			    <thead>
																				  <tr><th>Customer</th><th>Mobile</th><th>Non Visting Remark</th><th>Action</th></tr>
																				   </thead>
																				    <tbody>
																		<?php
                                                                  $DB = Connect();
											$n5_daysAgot = date('Y-m-d', strtotime('-60 days', time()));
										  $todaydate=date('Y-m-d');
										  $stqy=select("distinct(CustomerID)","tblAppointments","StoreID='$strStore' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgot."'");
											
											foreach($stqy as $vatq)
											{
												$CU[]=$vatq['CustomerID'];
											}
										if($strStore!='0')
										{
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
											$Productst="Select distinct(tblCustomers.CustomerID) from tblCustomers Left Join tblAppointments ON tblCustomers.CustomerID=tblAppointments.CustomerID WHERE tblAppointments.StoreID='$strStore' and tblAppointments.AppointmentDate<='".$n5_daysAgot."' and tblAppointments.AppointmentDate>='2017-02-01'";
										}
									
										//echo $Productst;
											$RSaT = $DB->query($Productst);
										if ($RSaT->num_rows > 0) 
										{
											while($rowa = $RSaT->fetch_assoc())
											{
									           $Customer=$rowa['CustomerID'];
									
											
										
											
											
											if(in_array("$Customer",$CU))
											{
												
											}
											else
											{
												
												$selpqtyP=select("*","tblCustomers","CustomerID='".$Customer."'");
												$customerfullname=$selpqtyP[0]['CustomerFullName'];
												    $CustomerMobileNo=$selpqtyP[0]['CustomerMobileNo'];
												    $NonCustomerRemark=$selpqtyP[0]['NonCustomerRemark'];
													 ?>
											<tr><td><input type="hidden" id="cust_id"  value="<?=$Customer?>" /><?=$customerfullname?></td><td><?=$CustomerMobileNo?></td><td contenteditable='true' id="remark" ><?=$NonCustomerRemark?></td><td>
													<a class="btn btn-link" href="#" onclick="updatevalues(this)">Update</a>

													</td></tr>
													<?php
											}
											
											}
										
							
								
										}
										else
										{
											?>
											<tr><td>No Records</td><td></td><td></td><td></td></tr>
											<?php
										}
											  ?>
												 </tbody>
																		 </table>
																		</div>
																		<div class="modal-footer">
																		
																		  <button type="button" class="btn ra-100 btn-primary" data-dismiss="modal">Close</button>
																		</div>
																	</div>
																  
																</div>
															</div>
                                </div>
								
                            </div>
							<br>
							<div class="row">
								<!--display reconsilation pending invices-->
								
								
								
								
								
								<div class="col-md-4">
								<a href="StorePendingBillReconciliation.php" class="tile-box tile-box-shortcut btn-warning" style="border-color: #fc8213; border-color:#52c4f7;" id="ModalOpenBtn" >
                                  
									<span class="bs-badge badge-absolute">
<?php									
										$DB = Connect();
										$ApprovePending="Select (SELECT count(0) FROM `tblAppointments` where Status=2 and IsDeleted!='1' and StoreID='$strStore' AND ApproveStatus!='1' and AppointmentDate>='$First' and AppointmentDate<='$Last') as ApprovalPendingCount";
/* 					
if($_SERVER['REMOTE_ADDR']=="111.119.219.70")
			{
				echo $ApprovePending;
			}
			else
			{
				
			}	 */				
		
						// echo $ApproveInvoices."<br><br><br>";
							$RSAI= $DB->query($ApprovePending);
							if($RSAI->num_rows>0)
							{
								while($ROS=$RSAI->fetch_assoc())
								{
									$strStoreID = $ROS["StoreID"];
									$ApprovalPendingCount = $ROS["ApprovalPendingCount"];
									// echo "Invoice Approval Pending on " .$StoreName." are ".$ApprovalPendingCount."<br><br><br>" ;
								}
								
								
							}
								if($ApprovalPendingCount=='')
											{
												$ApprovalPendingCount=0;
											}
							echo $ApprovalPendingCount;
										$DB->close();
?>	
										
									</span>
									    
                                        <div class="tile-header">Monthly Reconcilliation Pending Invoices</div>
										
                                        <div class="tile-content-wrapper"></div>
                                  </a>
								
                                </div>
									<div class="col-md-4">
								<a href="DisplayOutstandingPaymentSalon.php" class="tile-box tile-box-shortcut btn-warning" style="background: #a7c3d1;border-color: #a7c3d1; " id="ModalOpenBtn" >
                                  
									<span class="bs-badge badge-absolute">
<?php									
										$DB = Connect();
										$First= date('Y-m-01');
										$Last= date('Y-m-t');
										$date=date('Y-m-d');
								
													$sql = "Select count(tblPendingPayments.PendingAmount) as Pending from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID Left Join tblInvoiceDetails ON  tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.IsDeleted!='1' and tblAppointments.StoreID='$strStore'and tblPendingPayments.PendingStatus='2' and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$First."') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$Last."')";
													$RSP= $DB->query($sql);
													if($RSP->num_rows>0)
													{
														while($ROP=$RSP->fetch_assoc())
														{
															$Pendingcash = $ROP["Pending"];
															if($Pendingcash=="")
															{
																$Pendingcash='0';
															}
														}
													}
										 
										$DB->close();
										echo $Pendingcash;
?>	 
										
									</span>
									    
                                        <div class="tile-header">Monthly Outstanding Payments</div>
										
                                        <div class="tile-content-wrapper"></div>
                                  </a>
								
                                </div>
								<div class="col-md-4">
								<a href="TargetEmployee.php" class="tile-box tile-box-shortcut btn-warning" style="background: #FFA533; border-color: #FFA533;" id="ModalOpenBtn" >
                                 
									    
                                        <div class="tile-header">Employee Sale Target</div>
										
                                        <div class="tile-content-wrapper"></div>
                                  </a>
								
                                </div>
							</div>
						
							
	<div class="row">
			<?php 
				$DB = Connect();
				$sqlgraph=select("FromDate,ToDate,Type","tblGraphDateParameter","RoleID='".$strAdminRoleID."'");
				$FromDate=$sqlgraph[0]['FromDate'];
				$ToDate=$sqlgraph[0]['ToDate'];
				$FromDatee=date("d-m-Y",strtotime($FromDate));
				$ToDatee=date('d-m-Y',strtotime($ToDate));
				$Type=$sqlgraph[0]['Type'];
				?>
				    <span id="abc" style="display:none"></span>
						 <div class="col-md-12" style="padding-top: 10px;">
						 	<div class="panel mrg20T">
								<div class="panel-body" style="height:60px;">
								
								         <label class="col-sm-3 control-label">Select Duration For Graph<span>*</span></label>
												<div class="col-sm-3">
												<select name="checkgraphduration" id="checkgraphduration" class="form-control required" onchange="checkgraphtype(this.value)">
													 <option value="0" Selected>Select Month & Year</option>
													<option value="1" <?php if($Type=='1'){ ?> selected="selected" <?php }?> >Current Month Of 2017</option>
														
										     </select>
												</div>
								
								            <label class="col-sm-3 control-label checkcustomeduration" style="display:none">Select Custom Duration For Graph<span>*</span></label>
											<div class="col-sm-3">
												<select name="checkgraphcustom" id="checkgraphcustom" class="form-control required checkcustomeduration" onchange="checksubgraphcustom(this.value)" style="display:none">
												<option value="0" Selected>Select Month & Year</option>
												<?php 
	                                              $array = array("January", "February","March","April","May","June","July","August","September","October","November","December");
												
												for ($m=0; $m<=12; $m++)
												 {
											
												 ?>
												 <option value="<?=$m?>"><?=$array[$m]?></option>
												 <?php
												 }
												
												?>
												
											</select>
								   </div>
								
							
						     </div>
					
				          </div>
				        </div>
						
				</div>
				
									<div class="">
<?php
$DB=Connect();
	$Thisdate=date("y-m-d");
	// echo $Thisdate."<br>";
	// $DB = Connect();
	$insertopen="SELECT CloseTime, OpenTime FROM `tblOpenNClose` WHERE `DateNTime`='$Thisdate' and StoreID='$strStoreID'";
	// echo $insertopen."<br>";
		$RSf = $DB->query($insertopen);
		if ($RSf->num_rows > 0) 
		{
			while($rowf = $RSf->fetch_assoc())
			{
				$strCloseTime = $rowf["CloseTime"];
				$strOpenTime = $rowf["OpenTime"];
				// echo $strCloseTime."<br>";
			}
		}
		if($strCloseTime=='0000-00-00 00:00:00' && $strOpenTime!='0000-00-00 00:00:00')
		{
					$Dt=date('y-m-d');
			$sepp=select("SuitableAppointmentTime","tblAppointments","StoreID='$strStore' and AppointmentDate = '$Dt' order by AppointmentID desc");
			$SuitableAppointmentTimet=$sepp[0]['SuitableAppointmentTime'];
									   ?>
                           <div class="panel mrg20T">
                            <div class="panel">
                                <div class="panel-body">
                                    <h3 class="title-hero"><a href="http://pos.nailspaexperience.com/admin/ManageCustomers2.php" class="btn btn-info" role="button" style="background: #fc8213;border-color: #fc8213;color:#fff;">Appointments & History</a></h3>
									
                                    <div class="example-box-wrapper">
									
                                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                                            <thead>
                                                <tr>
                                                    <th>Customer</th>
                                                    <th>Appointment Time</th>
													 <th>Service Type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php										
									
											
											$FindStore="Select StoreID from tblAdminStore where AdminID=$strAdminID";
											// echo $FindStore;
											$RSf = $DB->query($FindStore);
											if ($RSf->num_rows > 0) 
											{
												while($rowf = $RSf->fetch_assoc())
												{
													$strStoreID = $rowf["StoreID"];
													// echo $strStoreID;
													// echo "Hello";
												}
											}
											if($strStoreID!=0)
											{
												$sql = "SELECT * FROM tblAppointments WHERE  StoreID='$strStoreID' and AppointmentDate = '$Dt' order by AppointmentID desc";
												
											}
											else
											{
												$sql = "SELECT * FROM tblAppointments WHERE  AppointmentDate = '$Dt' order by AppointmentID desc";
											}
//echo $sql;
// echo $sql;
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	while($row = $RS->fetch_assoc())
	{
		$strAppointmentID = $row["AppointmentID"];
		$getUID = EncodeQ($strAppointmentID);
		$CustomerID = $row["CustomerID"];
		$SuitableAppointmentTime = $row["SuitableAppointmentTime"];
		$AppointmentCheckInTime = $row["AppointmentCheckInTime"];
		$AppointmentCheckOutTime = $row["AppointmentCheckOutTime"];
		$StoreID = $row["StoreID"];
		
		$dateObject = new DateTime($SuitableAppointmentTime);
		$StoreID = $row["StoreID"];
		$CheckConfirm=$row["CheckConfirm"];
		$Status=$row["Status"];
		$FreeService=$row["FreeService"];
		if($FreeService=='0')
		{
			$FreeService="Paid Service";
		}
		else
		{
			$FreeService="Free Service";
		}
// echo $strAppointmentID."<br>";
		// echo $SuitableAppointmentTime."<br>";
		// echo $StoreID."<br>";
?>
                                                <tr class="odd gradeX">
                                                   <!-- <td>
 <?php												//$Selectstore="Select StoreID, StoreName from tblStores where StoreID='$StoreID'";
													// $RSa = $DB->query($Selectstore);
													// if ($RSa->num_rows > 0) 
													// {
														// while($rowa = $RSa->fetch_assoc())
														// {
															// $strStoreName = $rowa["StoreName"];
														// }
													// }
?>													
													<?//=$strStoreName?>
													</td>-->
                                                    <td>
													
<?php											
													$SelectCustomerName="Select CustomerFullName from tblCustomers where CustomerID='$CustomerID'";
													$RSb = $DB->query($SelectCustomerName);
													if ($RSb->num_rows > 0) 
													{
														while($rowb = $RSb->fetch_assoc())
														{
															$strCustomerFullName = $rowb["CustomerFullName"];
														}
													}
?>													
													<?=$strCustomerFullName?></td>
                                                    <td><?echo $dateObject->format('h:i A');?></td>
												 <td><?=$FreeService?></td>
                                                  
                                                </tr>
<?php
	}
	
	
}
else
{
?>
												<tr>
													<td colspan="3"><center><b>Appointment not found for the day</b><center></td>
												</tr>
<?php												
}
$DB->close();
?>                                              
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
								
								<!--<div class="col-md-12">
									<div class="col-sm-12">
										<div class="panel mrg20T">
											<div class="panel-body">
												<h3 class="title-hero">Employee Sale Target Wise achieved per day</h3>
												<div class="example-box-wrapper">
													<div id="chartdivEmpDailysale"></div>
												</div>
											</div>
										</div>
									</div>
								</div>-->
								
							
                            </div>
						</div>
<?php
						
		

		}
		
?>		
						
                       
				
					</div>
					
							
						</div>
                           
						
					
						
                        <div class="col-md-4">
						<div class="panel mrg20T" style="margin-top: 0px !important; background-color: transparent;">
							
							<div class="tile-box tile-box-alt mrg20B bg-green">
<?php
							$DB = Connect();
							$Storename1="select StoreName from tblStores where STOREID='$strStoreID'";
							// echo $Storename;
							$RS = $DB->query($Storename1);
							if ($RS->num_rows > 0) 
							{
								while($row = $RS->fetch_assoc())
								{
									$StoreName = $row["StoreName"];
									// echo $strStoreID;
									// echo "Hello";
								}
							}
?>							
									<div class="tile-header"><b><?=$StoreName?></b></div>
<?php									
									$date=date('y-m-d');
											// echo $strStoreID;
											$TDT=date('y-m-d');
											$FindStore="Select StoreID from tblAdminStore where AdminID=$strAdminID";
											// echo $FindStore;
											$RSf = $DB->query($FindStore);
											if ($RSf->num_rows > 0) 
											{
												while($rowf = $RSf->fetch_assoc())
												{
													$strStoreID = $rowf["StoreID"];
													// echo $strStoreID;
													// echo "Hello";
												}
											}
											if($strStoreID!=0)
											{
												// echo "In if";
												$Sales="Select tblAppointments.StoreID,
												SUM(tblInvoiceDetails.TotalPayment) as TOTAL
												from tblAppointments
											Left join tblInvoiceDetails
											ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID
											WHERE tblAppointments.StoreID='$strStoreID' and tblAppointments.AppointmentDate='$TDT'";
											// echo $Sales."<br>";
											// echo $Sales;
												
											}
											else
											{		
												// echo "In if";
												$Sales="Select tblAppointments.StoreID,
												SUM(tblInvoiceDetails.TotalPayment) as TOTAL
												from tblAppointments
											Left join tblInvoiceDetails
											ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID
											WHERE tblAppointments.AppointmentDate='$TDT'";
											}
											
											$RSd = $DB->query($Sales);
											if ($RSd->num_rows > 0) 
											{
												while($rowd = $RSd->fetch_assoc())
												{
													$TodalSales = $rowd["TOTAL"];
												}
											}
									$FindStore="Select StoreID from tblAdminStore where AdminID=$strAdminID";
									// echo $FindStore;
									$RSf = $DB->query($FindStore);
									if ($RSf->num_rows > 0) 
									{
										while($rowf = $RSf->fetch_assoc())
										{
											$strStoreID = $rowf["StoreID"];
											// echo $strStoreID;
											// echo "Hello";
										}
									}
									
									$CurrentMonth=date('F'); 
									$CurrentYear=date('Y'); 
									$SelectTarget="Select TargetAmount from tblStoreSalesTarget where Month='$CurrentMonth' and Year='$CurrentYear' and StoreID='$strStoreID'";
									// echo $SelectTarget."<br>";
									$RSTarget = $DB->query($SelectTarget);
									if ($RSTarget->num_rows > 0) 
									{
										while($rowTarget = $RSTarget->fetch_assoc())
										{
											$Target = $rowTarget["TargetAmount"];										
										}
									}
									$First= date('Y-m-01');
									$Last= date('Y-m-t');
									$TotalMonthSale="Select tblAppointments.StoreID,
												SUM(tblInvoiceDetails.TotalPayment) as TOTALMonthly
												from tblAppointments
											Left join tblInvoiceDetails
											ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID
											WHERE tblAppointments.StoreID='$strStoreID' and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('$First') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('$Last')";
											// echo $TotalMonthSale."<br>";
									$RSMonthsale = $DB->query($TotalMonthSale);
									if ($RSMonthsale->num_rows > 0) 
									{
										while($rowMonthTarget = $RSMonthsale->fetch_assoc())
										{
											$TOTALMonthly = $rowMonthTarget["TOTALMonthly"];										
										}
									}
											
											
									$averatesalesperday=$Target/$d;								
									$asmita=date("n",strtotime($CurrentMonth));
									$d=cal_days_in_month(CAL_GREGORIAN,$asmita,2016);
									$averatesalesperday=$Target/$d;									
									$Roun=round($averatesalesperday);
									$Remainingsales=$Target-$TOTALMonthly;									
												if($TodalSales=="")	
												{
												$TodalSales="0";
												}													
								if($Remainingsales<0)
									{
										$Remainingsales='0';
				
									}

?>										
									<div class="tile-content-wrapper">
										<span style="float:left; padding-left:10px; padding-top:10px;">
											<?php
												if($TodalSales==$todaytarget || $TodalSales=="0")
												{
											?>
												<img src="<?=FindHostAdmin();?>/images/confused.png" height="40"/>
											<?php
												}
												elseif($TodalSales>$todaytarget)
												{
											?>
												<img src="<?=FindHostAdmin();?>/images/in-love.png" height="40"/>
											<?php
												}
												elseif($TodalSales<$todaytarget)
												{
											?>
												<img src="<?=FindHostAdmin();?>/images/unhappy.png" height="40"/>
											<?php
												}
											?>
										</span>
										<span style="float:left;"><!--<img src="http://pos.nailspaexperience.com/admin/images/unhappy.png" height="40">--></span><div class="tile-content"><span></span><small>Today's Sales </small>Rs.<?=$TodalSales?></div><small><b>Sales Remaining This Month Rs.<?=$Remainingsales?><br>Target for the month is Rs.<?=$Target?></b></small></div>
									</div>
							<?php
									$DB->close();
?>									
									
<?php										
										$date=date('y-m-d');
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
												// echo "Hello";
											}
										}
										if($strStoreID!=0)
										{
											$App="Select (SELECT count(0) FROM `tblAppointments` where StoreId='$strStoreID') as TodaysAppointment";
										}
										else
										{
											$App="Select (SELECT count(0) FROM `tblAppointments`) as TodaysAppointment";
										}
										
										$RSc = $DB->query($App);
										if ($RSc->num_rows > 0) 
										{
											while($rowc = $RSc->fetch_assoc())
											{
												$TodayApp = $rowc["TodaysAppointment"];
												
											}
										}
										// $membershipamount="SELECT count(memberid) as TodaysMembership FROM `tblCustomers` where Date(MembershipDateTime)='$date'";
										// $membershipamount="SELECT count(tblCustomers.memberid) as TodaysMembership FROM `tblCustomers`
										// Left join tblAppointments 
										// ON tblAppointments.CustomerID=tblCustomers.CustomerID 
										// where Date(tblCustomers.MembershipDateTime)='$date'
										// AND tblAppointments.StoreID='$strStoreID'";
										// echo $membershipamount."<br>";
												// $DB = Connect();
												// $RSc = $DB->query($membershipamount);
												// if ($RSc->num_rows > 0) 
												// {
													// while($rowc = $RSc->fetch_assoc())
													// {
														// $TodaysMembership = $rowc["TodaysMembership"];
													// }
												// }
												// $MAC3="SELECT Count(tblInvoiceDetails.Membership_Amount) as MemberCount from tblInvoiceDetails Left Join tblAppointments ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID where tblAppointments.AppointmentDate>='$First' and tblAppointments.AppointmentDate<='$Last' and tblAppointments.StoreID='$strStoreID' and tblAppointments.Status='2' AND tblInvoiceDetails.Membership_Amount!=''";
												// echo $MAC3."<br>";
												$MAC3="SELECT COUNT( tblAppointments.`CustomerID` ) as MemberCount FROM `tblCustomerMemberShip` LEFT JOIN tblAppointments ON tblCustomerMemberShip.`CustomerID` = tblAppointments.CustomerID WHERE tblCustomerMemberShip.Status = '1' AND tblCustomerMemberShip.RenewStatus = '0' AND tblAppointments.StoreID = '$strStoreID' AND tblAppointments.memberid != '0' and tblCustomerMemberShip.StartDay>='$First' and tblCustomerMemberShip.StartDay<='$Last'";
												
												
												
												
												if($_SERVER['REMOTE_ADDR']=="111.119.219.70")
												{
													// echo $MAC3;
												}
												else
												{
													   
												}
											$RSMTCM = $DB->query($MAC3);
											if ($RSMTCM->num_rows > 0) 
											{
												while($rowMTCM = $RSMTCM->fetch_assoc())
												{
													
													$Membership_CountM = $rowMTCM["MemberCount"];
													
												}
											}
											
											
										
											$MAC2="SELECT Count(tblInvoiceDetails.Membership_Amount) as MemberCount from tblInvoiceDetails Left Join tblAppointments ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID where tblAppointments.AppointmentDate='$date' and tblAppointments.StoreID='$strStoreID' and tblAppointments.Status='2' AND tblInvoiceDetails.Membership_Amount!=''";
												// echo $MAC2."<br>";
											$RSMTC = $DB->query($MAC2);
											if ($RSMTC->num_rows > 0) 
											{
												while($rowMTC = $RSMTC->fetch_assoc())
												{
													
													$Membership_Count = $rowMTC["MemberCount"];
													
												}
											}
											
										$GiftSold="Select (SELECT count(Date) FROM `tblGiftVouchers` where StoreId='$strStoreID' and Date(Date)='$date') as Giftsold";
										$RSGift = $DB->query($GiftSold);
										if ($RSGift->num_rows > 0) 
										{
											while($rowGift = $RSGift->fetch_assoc())
											{
												$Giftsold = $rowGift["Giftsold"];
											}
										}
										$First= date('Y-m-01');
										$Last= date('Y-m-t');
											
											// Date(AppointmentDate)>=Date('2016-09-01') and Date(AppointmentDate)<=Date('2016-09-30')
										$GiftSoldforMonth="Select (SELECT count(Date) FROM `tblGiftVouchers` where StoreId='$strStoreID' and Date(Date)>=Date('$First') and Date(Date)<=Date('$Last')) as GiftsoldthisMonth";
										$RSGiftforMonth = $DB->query($GiftSoldforMonth);
										if ($RSGiftforMonth->num_rows > 0) 
										{
											while($rowGifforMonth = $RSGiftforMonth->fetch_assoc())
											{
												$GiftsoldthisMonth = $rowGifforMonth["GiftsoldthisMonth"];
											}
										}
										
												
										$DB->close();
?>									<div class="tile-box tile-box-alt mrg20B bg-blue-alt">
                                        <div class="tile-header"><b>Your Incentives</b></div>
                                        <div class="tile-content-wrapper"></i>
                                            <div class="tile-content">
												<small>Membership Sold Today</small> <?=$Membership_Count?>
												<small>
<?php											
?>												<b>Total Membership sold for this month is <?=$Membership_CountM?></b>
											</small>
												<small>Gift Vouchers Sold Today</small> <?=$Giftsold?>
											</div>
											<small>
<?php											
?>												<b>Total Gift Vouchers sold for this month is <?=$GiftsoldthisMonth?></b>
											</small>
											
										</div>
									</div>
<!--Pending Amount-->									
<?php										
										$date=date('y-m-d');
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
												// echo "Hello";
											}
										}
										if($strStoreID!=0)
										{
											$PendingAmount="Select SUM(tblPendingPayments.PendingAmount)as Pending,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$strStoreID' and tblPendingPayments.PendingStatus=2";
											// echo $PendingAmount."<br>";
											$PendingAmountMonth="Select SUM(tblPendingPayments.PendingAmount)as MonthPending,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$strStoreID' and tblPendingPayments.PendingStatus=2 and Date(tblPendingPayments.DateTimeStamp)>=Date('$First') and Date(tblPendingPayments.DateTimeStamp)<=Date('$Last')";
											// echo $PendingAmountMonth;
											$TodaysPendingAmountCount="Select Count(tblPendingPayments.PendingAmount)as PendingTotalCount,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$strStoreID' and tblPendingPayments.PendingStatus=2 and Date(tblPendingPayments.DateTimeStamp)>='$First' and tblAppointments.StoreID='$strStoreID' and Date(tblPendingPayments.DateTimeStamp)<='$Last'";
										// echo $TodaysPendingAmountCount;
										}
										else
										{
											$PendingAmount="Select SUM(tblPendingPayments.PendingAmount)as Pending,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblPendingPayments.PendingStatus=2";
											// echo $PendingAmount."<br>";
											$PendingAmountMonth="Select SUM(tblPendingPayments.PendingAmount)as MonthPending,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE  tblPendingPayments.PendingStatus=2 and Date(tblPendingPayments.DateTimeStamp)>=Date('$First') and Date(tblPendingPayments.DateTimeStamp)<=Date('$Last')";
											$TodaysPendingAmountCount="Select Count(tblPendingPayments.PendingAmount)as PendingTotalCount,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$strStoreID' and tblPendingPayments.PendingStatus=2 and Date(tblPendingPayments.DateTimeStamp)>='$First' and tblAppointments.StoreID='$strStoreID' and Date(tblPendingPayments.DateTimeStamp)<='$Last'";
										// echo $TodaysPendingAmountCount;
										}
										
										
											// echo $PendingAmountMonth."<br>";
										$RSPending = $DB->query($PendingAmountMonth);
										if ($RSPending->num_rows > 0) 
										{
											while($rowPending = $RSPending->fetch_assoc())
											{
												$MonthPending = $rowPending["MonthPending"];
												// echo $strStoreID;
												// echo "Hello";
											}
										}
											
										
										
										$RSc = $DB->query($PendingAmount);
										if ($RSc->num_rows > 0) 
										{
											while($rowc = $RSc->fetch_assoc())
											{
												$PendingTotal = $rowc["Pending"];
												
												
											}
										}
										if($PendingTotal=="")
										{
											$PendingTotal=0;
										}
										if($strStoreID!=0)
										{
											// echo "In if<br>";
											$TodaysPendingAmount="Select SUM(tblPendingPayments.PendingAmount)as PendingTotalforDay,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$strStoreID' and tblPendingPayments.PendingStatus=2 and Date(tblPendingPayments.DateTimeStamp)='$date' and tblAppointments.StoreID='$strStoreID'";
											// echo $TodaysPendingAmount;
										}
										else
										{
											// echo "In else<br>";
											$TodaysPendingAmount="Select SUM(tblPendingPayments.PendingAmount)as PendingTotalforDay,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$strStoreID' and tblPendingPayments.PendingStatus=2 and Date(tblPendingPayments.DateTimeStamp)='$date'";
										}
										
										// echo $TodaysPendingAmount."<br>";
										$RSP = $DB->query($TodaysPendingAmount);
										if ($RSP->num_rows > 0) 
										{
											while($rowP = $RSP->fetch_assoc())
											{
												$PendingTotalforDay = $rowP["PendingTotalforDay"];												
											}
										}
										if($PendingTotalforDay=="")
										{
											$PendingTotalforDay=0;
										}
										
										
										
										$RSAC = $DB->query($TodaysPendingAmountCount);
										if ($RSAC->num_rows > 0) 
										{
											while($rowAC = $RSAC->fetch_assoc())
											{
												$PendingTotalCount = $rowAC["PendingTotalCount"];												
											}
										}
										if($PendingTotalCount=="")
										{
											$PendingTotalCount=0;
										}
										
										
										
										
										$DB->close();	
									
										$date=date('y-m-d');
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
												// echo "Hello";
											}
										}
										if($strStoreID!=0)
										{
											$OfferAmt="Select (SELECT count(OfferAmt) FROM `tblInvoiceDetails` where StoreID='$strStoreID') as TodaysOffer";
											// echo $OfferAmt;
										}
										else
										{
											$OfferAmt="Select (SELECT count(OfferAmt) FROM `tblAppointments`) as TodaysOffer";
										}
										// echo $strStoreID."<br>";
										$RSc = $DB->query($OfferAmt);
										if ($RSc->num_rows > 0) 
										{
											while($rowc = $RSc->fetch_assoc())
											{
												$TodaysOffer = $rowc["TodaysOffer"];
												
											}
										}
										$offeramount="Select count(tblInvoiceDetails.OfferAmt) as TodaysOffers from tblInvoiceDetails Left Join tblAppointments ON tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$strStoreID'and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('$date') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('$date')and tblAppointments.StoreID='$strStoreID'";	
										//$offeramount="SELECT count(OfferAmt) as TodaysOffers FROM `tblInvoiceDetails` where Date(OfferDiscountDateTime)='$date'";
										
										
										// echo $offeramount;
												$DB = Connect();
												$RSc = $DB->query($offeramount);
												if ($RSc->num_rows > 0) 
												{
													while($rowc = $RSc->fetch_assoc())
													{
														$TodaysOffers = $rowc["TodaysOffers"];
													}
												}
												

										// $offeramountMonth="Select (SELECT count(OfferAmt) FROM `tblInvoiceDetails` where StoreId='$strStoreID') and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('$First') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('$Last') as MonthOffer";
										
										
											$TodaysMonthOffer="Select count(tblInvoiceDetails.OfferAmt)as TotalOfferforMonth from tblInvoiceDetails Left Join tblAppointments ON tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$strStoreID'and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('$First') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('$Last')and tblAppointments.StoreID='$strStoreID'";	
											$RSOfferMonth = $DB->query($TodaysMonthOffer);
												if ($RSOfferMonth->num_rows > 0) 
												{
													while($rowMonthOffer = $RSOfferMonth->fetch_assoc())
													{
														$MonthOffers = $rowMonthOffer["TotalOfferforMonth"];
													}
												}
											// echo $TodaysPendingAmount;
										
										
												
										
										$DB->close();
?>										
										
                                        
                                        <div class="tile-box tile-box-alt mrg20B bg-green">
											<div class="tile-header"><b>Offers Sold</b></div>
											<div class="tile-content-wrapper"></i>
												<div class="tile-content">
													<small>Offers Sold Today</small> <?=$TodaysOffers?>
												</div>
												<small>
	<?php											
	?>												<b>Total Offers sold for this month is <?=$MonthOffers?></b>
												</small>
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