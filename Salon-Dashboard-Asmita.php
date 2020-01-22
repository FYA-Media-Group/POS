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
                                  
									<a href="#" class="tile-box tile-box-shortcut btn-warning" style="
    background: #52c4f7; border-color:#52c4f7;" id="ModalOpenBtn" data-toggle="modal" data-target="#myModalstock">
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
										if($strStoreID!=0)
										{
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
											$Products="Select count(tblPendingPayments.PendingAmount)as PendingCount,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$strStoreID' and tblPendingPayments.PendingStatus=2";
										}
										else
										{
											$Products="Select SUM(tblPendingPayments.PendingAmount)as PendingCount,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblPendingPayments.PendingStatus=2";
										}
										
										$RSa = $DB->query($Products);
										if ($RSa->num_rows > 0) 
										{
											while($rowa = $RSa->fetch_assoc())
											{
												$PendingCount = $rowa["PendingCount"];
												$ProductID = $rowa["ProductID"];
												// echo $TotalProducts;
												
												$ProductsVariation="Select (SELECT count(Distinct ProductStockID) FROM `tblStoreProduct` where StoreID='$strStoreID' and ProductStockID!=0 ) as TotalVariations";
													// echo $ProductsVariation."<br>";
													// echo $SelectProductvariation;
													$RSvariation = $DB->query($ProductsVariation);
													if ($RSvariation->num_rows > 0) 
													{
														while($rowvariation = $RSvariation->fetch_assoc())
														{
															$TotalVariations = $rowvariation["TotalVariations"];
															// echo $TotalVariations;
														}
													}
												
											}
										}
										$DB->close();
?>									
										 <span class="bs-badge badge-absolute"><?=$PendingCount?></span>
                                        <div class="tile-header">Pending Payments Till Date</div>
										 
                                        <div class="tile-content-wrapper"></div>
                                    </a>
													<div class="modal fade" id="myModalstock" role="dialog">
																<div class="modal-dialog">
																
																  <!-- Modal content-->
																	<div class="modal-content">
																	
																		<div class="modal-body">
																			   <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
																			    <thead>
																				  <tr><th>Customer</th><th>Mobile</th><th>Pending</th></tr>
																				   </thead>
																				    <tbody>
																		<?php
                                                                  $DB = Connect();
											 if($strStoreID!='0')
										{
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
											$Productst="Select tblPendingPayments.PendingAmount,  tblAppointments.CustomerID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$strStoreID' and tblPendingPayments.PendingStatus=2";
										}
										else
										{
											$Productst="Select tblPendingPayments.PendingAmount,  tblAppointments.CustomerID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblPendingPayments.PendingStatus=2";
										}
										//echo $Productst;
											$RSaT = $DB->query($Productst);
										if ($RSaT->num_rows > 0) 
										{
											while($rowa = $RSaT->fetch_assoc())
											{
												$PendingAmount = $rowa["PendingAmount"];
												$CustomerID = $rowa["CustomerID"];
												$sqq=select("*","tblCustomers","CustomerID='".$CustomerID."'");
												$customerfullname=$sqq[0]['CustomerFullName'];
												$CustomerMobileNo=$sqq[0]['CustomerMobileNo'];
											   ?>
											<tr><td><?=$customerfullname?></td><td><?=$CustomerMobileNo?></td><td><?=$PendingAmount?></td></tr>
											  
											  
											   <?php
												
											}
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
                                    <a href="TodayAppointmentDetails.php" title="Today's Appointments" class="tile-box tile-box-shortcut btn-warning">
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
									    
                                        <div class="tile-header">Today's Appointments</div>
										
                                        <div class="tile-content-wrapper"></div>
                                  </a>
                                </div>
								
								<div class="col-md-4">
                                    <a href="#" title="Non-Visiting Clients" class="tile-box tile-box-shortcut btn-warning" style="
    background: #52c4f7; border-color:#52c4f7;">
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

	
		// echo $CustomerID."<br>";
		$ct=0;
		$selectApp="Select count(CustomerId) as cnt,CustomerId, AppointmentID from tblAppointments where AppointmentDate>='$First' and  AppointmentDate<='$Last' and StoreID='".$strStore."'";
	//echo $selectApp;
		$RSA = $DB->query($selectApp);
		if ($RSA->num_rows > 0) 
		{
			while($rowA = $RSA->fetch_assoc())
			{
				echo $cnt = $rowA["cnt"];
				$strCustomerId = $rowA["CustomerId"];
				$strAppointmentID = $rowA["AppointmentID"];
				// echo $CustomerID."&nbsp;&nbsp;&nbsp;&nbsp;";
				// echo $strAppointmentID."<br>";
				if(in_array("$CustomerID", $strCustomerId))
				{
					
					//echo "Visiting Customers : <br>";
					//echo $strCustomerId."<br>";
				}
				else
				{
					$ct++;
					//echo "Non Visiting Customers : <br>";
					//echo $strCustomerId."<br>";
				}
				
				
			}
		}
										}
										$DB->close();
?>	
										
									</span>
                                        <div class="tile-header">Non-Visiting Clients</div>
                                        <div class="tile-content-wrapper"></div>
                                    </a>
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
                                    <h3 class="title-hero">Today's Appointments</h3>
                                    <div class="example-box-wrapper">
									
                                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                                            <thead>
                                                <tr>
                                                    <th>Customer</th>
                                                    <th>Appointment Time</th>
                                                   
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
                            </div>
						</div>
<?php
						
		

		}
		
?>		
						
                       
				
					</div>
					<div class="">  
                           <div class="panel mrg20T">
								<div class="panel-body">
									<h3 class="title-hero">Employee Sales Achieved</h3>
									<div class="example-box-wrapper">
										<div id="chartdiv"></div>
									</div>
								</div>
							</div>
							
<?php
						// $DB = Connect();
						// $Month=date('m');
						// $MonthSpell = getMonthSpelling($Month);
						// $Year=date('Y');
						// $d=cal_days_in_month(CAL_GREGORIAN,$Month,$Year); //Total days in Current Month
						// $sqlemp = "Select tblEmployees.EmployeeName, tblEmployees.EID , tblEmployeeTarget.BaseTarget from tblEmployees Left Join tblEmployeeTarget ON tblEmployees.EmployeeCode=tblEmployeeTarget.EmployeeCode where tblEmployees.StoreID='$strStoreID' and tblEmployeeTarget.TargetForMonth='$MonthSpell' and Year='$Year'";
						// echo $sqlemp."<br>";
						// $RSst = $DB->query($sqlemp);
						// if ($RSst->num_rows > 0) 
						// {
							// $counter = 0;

							// while($rowst = $RSst->fetch_assoc())
							// {
								// $counter ++;
								// $EmployeeName = $rowst["EmployeeName"];
								// $EID = $rowst["EID"];
								// $BaseTarget = $rowst["BaseTarget"];
								// $TodaysTarget=$BaseTarget/$d;
								// $FinalTarget=round($TodaysTarget);
								// echo $FinalTarget."<br>";
								// echo $EmployeeName."<br>";
								// echo $EID."<br>";
							// }
						// }
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
											

?>										
									<div class="tile-content-wrapper">
										<div class="tile-content"><span></span><small>Today's Sales </small>Rs.<?=$TodalSales?></div><small><b>Sales Remaining This Month Rs.<?=$Remainingsales?><br>Target for the month is Rs.<?=$Target?></b></small></div>
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
										$membershipamount="SELECT count(memberid) as TodaysMembership FROM `tblCustomers` where Date(MembershipDateTime)='$date'";
												$DB = Connect();
												$RSc = $DB->query($membershipamount);
												if ($RSc->num_rows > 0) 
												{
													while($rowc = $RSc->fetch_assoc())
													{
														$TodaysMembership = $rowc["TodaysMembership"];
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
												<small>Membership Sold Today</small> <?=$TodaysMembership?>
												<small>
<?php											
?>												<b>Total Membership sold for this month is <?=$TodayApp?></b>
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
										}
										else
										{
											$PendingAmount="Select SUM(tblPendingPayments.PendingAmount)as Pending,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblPendingPayments.PendingStatus=2";
											// echo $PendingAmount."<br>";
										}
										
										$PendingAmountMonth="Select SUM(tblPendingPayments.PendingAmount)as MonthPending,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$strStoreID' and tblPendingPayments.PendingStatus=2 and Date(tblPendingPayments.DateTimeStamp)>=Date('$First') and Date(tblPendingPayments.DateTimeStamp)<=Date('$Last')";
											// echo $PendingAmount."<br>";
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
											$TodaysPendingAmount="Select SUM(tblPendingPayments.PendingAmount)as PendingTotalforDay,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$strStoreID' and tblPendingPayments.PendingStatus=2 and Date(tblPendingPayments.DateTimeStamp)='$date' and tblAppointments.StoreID='$strStoreID'";
										}
										else
										{
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
										
										
										
										$DB->close();	
?>
										<div class="tile-box tile-box-alt mrg20B bg-green">
											<div class="tile-header"><b>Pending Amount</b></div>
											<div class="tile-content-wrapper">
												<div class="tile-content">
													<span></span><small>Today's Pending Amount is Rs. </small> <?=$PendingTotalforDay?>
												</div>
												<small>
													Total Amount Pending for this month Rs.<?=$MonthPending?>
												</small>
											</div>
										</div>
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
											$OfferAmt="Select (SELECT count(OfferAmt) FROM `tblInvoiceDetails` where StoreId='$strStoreID') as TodaysOffer";
											// echo $OfferAmt;
										}
										else
										{
											$OfferAmt="Select (SELECT count(OfferAmt) FROM `tblAppointments`) as TodaysOffer";
										}
										
										$RSc = $DB->query($OfferAmt);
										if ($RSc->num_rows > 0) 
										{
											while($rowc = $RSc->fetch_assoc())
											{
												$TodaysOffer = $rowc["TodaysOffer"];
												
											}
										}
										$offeramount="SELECT count(OfferAmt) as TodaysOffers FROM `tblInvoiceDetails` where Date(OfferDiscountDateTime)='$date'";
										
										
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
										<div class="tile-box tile-box-alt mrg20B bg-blue-alt">
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