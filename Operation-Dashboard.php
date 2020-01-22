<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
// Redirection code-fork
	if($strAdminRoleID=='36')
	{

	}
	elseif($strAdminRoleID=='2')
	{
		echo("<script>location.href='Marketing-Dashboard.php';</script>");
	}
	elseif($strAdminRoleID=='38')
	{
		echo("<script>location.href='Audit-Dashboard.php';</script>");
	}
	elseif($strAdminRoleID=='6')
	{
		echo("<script>location.href='Salon-Dashboard.php';</script>");
	}
	else
	{

	}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	<?php require_once("incProductAlertBar.fya"); ?>
	<?php require_once("incpiechart.fya"); ?>
	<?php //require_once("incPettyCashScript-Admin.fya"); ?>
	<?php require_once("incEmpAttendanceInOutScript.fya"); ?>
	<?php //require_once("incEmpSalesTargetScript.fya"); ?>
	<?php //require_once("incMembershipChartScript.fya"); ?>
	<?php //require_once("incGiftVoucherSoldScript.fya"); ?>
	<?php //require_once("incReconcilliationPendingScript.fya"); ?>
	<script type="text/javascript" src="assets/widgets/charts/chart-js/chart-doughnut.js"></script>
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
							$("#viewmonthlysale").click(function()
								{
									
									window.location="ViewMonthlySaleOperation.php";
								});
							
								$("#viewemployee").click(function()
								{
									window.location="ViewEmployeeTargetAllOperation.php";
									
								});
								$("#viewproduct").click(function()
								{
									window.location="ViewProductAllOperation.php";
									
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
										window.location = "Operation-Dashboard.php";

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
										window.location = "Operation-Dashboard.php";
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
										window.location = "Operation-Dashboard.php";
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
								<h2>Dashboard</h2>
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
				<div class="panel" style="padding:2%;">
                <div class="row">
					<span id="abc" style="display:none"></span>
				
				<span id="abc" style="display:none"></span>
					<div class="tile-box col-md-3" style="background: #dc1156;border-color: #dc1156;margin-right:03%;">
					<div class="panel-content">
					<div style="font-size:14px;"><b>Outstanding Payment</b></style></div>
					<?php				

$DB=Connect();
	$First= date('Y-m-01');
	$Last= date('Y-m-t');
						$PendingAmountStores="Select SUM(tblPendingPayments.PendingAmount)as Pending,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID Left Join tblInvoiceDetails ON  tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.IsDeleted!='1' and tblAppointments.StoreID!='0'and tblPendingPayments.PendingStatus='2' and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$First."') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$Last."')";
							$RSP= $DB->query($PendingAmountStores);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$Pending = $ROP["Pending"];
									if($Pending=="")
									{
										$Pending='0';
									}
								}
							}
$DB->close();
?>				
						<a class="btn btn-lg" href="DisplayOutstandingPaymentAudit.php" style="background: #dc1156;border-color: #dc1156;color:#fff;"><?=$Pending?></a>	
						
					</div>
				</div>
				
				<span id="abc" style="display:none"></span>
					<div class="tile-box col-md-3" style="background: #77dd77;border-color: #77dd77;margin-right:03%;">
					<div class="panel-content">
					<div style="font-size:14px;"><b>Confirm Appointments</b></style></div>
<?php	
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');	
$DB = Connect();

					$sql="Select Count(0) as ConfirmedCount from tblAppointments where AppointmentDate>='$First' and AppointmentDate<='$Last' and Status='2' and IsDeleted!='1' ";
					// echo $sql."<br><br><br>";
					$RSC = $DB->query($sql);
					if ($RSC->num_rows > 0) 
					{
						while($rowC = $RSC->fetch_assoc())
						{
							$ConfirmedCount = $rowC["ConfirmedCount"];
						}
					}
						if($ConfirmedCount=="")
										{
											$ConfirmedCount=0;
										}
$DB->close();
?>		
						<a class="btn btn-lg" href="DisplayConfirmAppointments.php" style="background: #77dd77;border-color: #77dd77;color:#fff;"><?=$ConfirmedCount?></a>	
					
					</div>
                       
				</div>
				<span id="abc" style="display:none"></span>
					<div class="tile-box col-md-3" style="background: #1296ff;border-color: #1296ff;margin-right:03%;">
					<div class="panel-content">
					<div style="font-size:14px;"><b>Cancelled Appointments</b></style></div>
<?php		
$DB = Connect();
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');

					$sql="Select (SELECT count(0) FROM `tblAppointments` where Status=3 and IsDeleted!='1' and AppointmentDate>='$First' and AppointmentDate<='$Last') as CancelledCount ";
					// echo $sql."<br><br><br>";
					$RSC = $DB->query($sql);
					if ($RSC->num_rows > 0) 
					{
						while($rowC = $RSC->fetch_assoc())
						{
							$CancelledCount = $rowC["CancelledCount"];
							// echo "Total Cancelled Appointments in Current month - ".$CancelledCount;// echo $TodaysMembership;
							// echo "Total Cancelled Appointments in Current Month on ".$StoreName." are " .$CancelledCount."<br><br>";
						}
					}
						if($CancelledCount=="")
										{
											$CancelledCount=0;
										}
$DB->close();
?>	
						<a class="btn btn-lg" href="DisplayCancelledAppointments.php" style="background: #1296ff;border-color: #1296ff;color:#fff;"><?=$CancelledCount?></a>	
						
					</div>
                       
				</div>
			
            </div>
            </div>
			
			
			
			
            <div class="row">
				<span id="abc" style="display:none"></span>
					<div class="col-md-12" style="padding-top: 10px;">
						<div class="panel mrg20T">
							<div class="panel-body">
								<div class="col-md-12">
									<h3 class="title-hero">Product Alert</h3>&nbsp;&nbsp;<input type="button" id="viewproduct" class="btn ra-100 btn-primary" value="View All">
									<div class="example-box-wrapper">
										<div id="chartdiv2"></div>
									</div>
									
								</div>
								
							</div>
						</div>
					</div>
				
			</div>
			
			<div class="row">
             		<div class="col-md-4" style="padding-top: 10px;">
						<div class="panel mrg20T">
							<div class="panel-body">
								<div class="col-md-12">
									<div class="col-md-12">
									<?php							
										$First= date('Y-m-01');
										$Last= date('Y-m-t');
										$date=date('Y-m-d');
										
										$DB=Connect();

										$selpqtyPq=select("count(AppointmentID) as cntapp","tblCustomerRemarks","StoreID!='0' and NonCommentType!='0'");
										$noncount=$selpqtyPq[0]['cntapp'];
										
										if($noncount=="")
										{
											$noncount=0;
										}
										$DB->close();
                                      
?>							
						
										<div class="tile-box tile-box-alt mrg20B bg-blue-alt" style="background: #FF6600;border-color: #FF6600;color:#fff;">
												<div class="tile-header"><b>Non Visiting Customers Conversion on calls</b></div>
												<div class="tile-content-wrapper">
													<div class="tile-content"><span><b><small></i>Non Visiting Customers</small></b></span><a href="DisplayCustomerRemarkOperation.php" style="color:#fff;"><?=$noncount?></a></div><b><small></small></i></b>
													

												</div>
										</div>
						
									</div>
									
								</div>
								
							</div>
						</div>
					</div>
					
				<div class="col-md-4" style="padding-top: 10px;">
						<div class="panel mrg20T">
							<div class="panel-body">
								<div class="col-md-12">
									<div class="col-md-12">
									<?php							
										$First= date('Y-m-01');
										$Last= date('Y-m-t');
										$date=date('Y-m-d');
										$DB=Connect();

                                       $selectcountpetty=select("count(*)","tblExpenses","Date(tblExpenses.DateOfExpense)>=Date('".$First."') and Date(tblExpenses.DateOfExpense)<=Date('".$Last."') order by ExpenseID desc");
										$countpetty=$selectcountpetty[0]['count(*)'];
										
										if($countpetty=="")
										{
											$countpetty=0;
										}
                                       $DB->close();
                                      
?>							
						
										<div class="tile-box tile-box-alt mrg20B bg-blue-alt" style="background: #0D52D1;border-color: #0D52D1;color:#fff;">
												<div class="tile-header"><b>Petty Cash Spent & Balance</b></div>
												<div class="tile-content-wrapper">
													<div class="tile-content"><span><b><small></i>Petty Cash Spent & Balance</small></b></span><a href="DisplayPettyCashCountOperation.php" style="color:#fff;"><?=$countpetty?></a></div><b><small></small></i></b>
													

												</div>
										</div>
						
									</div>
									
								</div>
								
							</div>
						</div>
					</div>
					
					<div class="col-md-4" style="padding-top: 10px;">
						<div class="panel mrg20T">
							<div class="panel-body">
								<div class="col-md-12">
									<div class="col-md-12">
								<?php							
										$First= date('Y-m-01');
										$Last= date('Y-m-t');
										$date=date('Y-m-d');
										$DB=Connect();

                                       $selectcountpetty=select("count(DISTINCT(tblEmployeesRecords.EmployeeCode)) as empp","`tblEmployees` left join tblEmployeesRecords 
					on tblEmployees.EmployeeCode=tblEmployeesRecords.EmployeeCode","tblEmployeesRecords.DateOfAttendance!='null' and tblEmployeesRecords.DateOfAttendance!='NULL' and tblEmployeesRecords.EmployeeCode!='NULL' and Date(tblEmployeesRecords.DateOfAttendance)>=Date('".$First."') and Date(tblEmployeesRecords.DateOfAttendance)<=Date('".$Last."') and tblEmployeesRecords.LoginTime!='00:00:00' ORDER BY tblEmployeesRecords.DateOfAttendance DESC");
										$countattendance=$selectcountpetty[0]['empp'];
										if($countattendance=="")
										{
											$countattendance=0;
										}
                                       $DB->close();
                                      
?>							
						
										<div class="tile-box tile-box-alt mrg20B bg-blue-alt" style="background: #CD0D74;border-color: #CD0D74;color:#fff;">
												<div class="tile-header"><b>Attendance with checkin & check out</b></div>
												<div class="tile-content-wrapper">
													<div class="tile-content"><span><b><small></i>Attendance with checkin & check out</small></b></span><a href="AttendanceOperation.php" style="color:#fff;"><?=$countattendance?></a></div><b><small></small></i></b>
													

												</div>
										</div>
									</div>
									
								</div>
								
							</div>
						</div>
					</div>
					</div>
		
                         <div class="row">
					 <div class="panel">
                                <div class="panel-body">
                                   
                                    <div class="example-box-wrapper">
                                          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center">Store</th>
                                                    <th style="text-align:center">Open Time</th>
													<th style="text-align:center">Close Time</th>
													<th  style="text-align:center">Total Today's Sales</th>
													<th  style="text-align:center">No.Of Appointments</th>
													
<?php													
													if($strAdminRoleID!='36')
													{	
?>
<?php														
													}
													else{
?>														
														<th  style="text-align:center">Average Ticket Size</th>
<?php														
													}
?>
                                            </thead>
											
												
                                            <tbody>
<?php								
									 	$date=date('y-m-d');
										$DB = Connect();
										$FindStore="Select * from tblOpenNClose where DateNTime='".$date."'";
										// echo $FindStore;
										$RSf = $DB->query($FindStore);
										if ($RSf->num_rows > 0) 
										{
											while($rowf = $RSf->fetch_assoc())
											{
												$strStoreID = $rowf["StoreID"];
												$selp=select("StoreName","tblStores","StoreID='".$strStoreID."'");
												$StoreName=$selp[0]['StoreName'];
												$OpenTime = $rowf["OpenTime"];
												$CloseTime = $rowf["CloseTime"];
												
												$OpenTimet = date("H:i:s",strtotime($OpenTime));
												$OpenTimett = get12hour($OpenTimet);
												$CloseTimet = date("H:i:s",strtotime($CloseTime));
												$CloseTimett = get12hour($CloseTimet);
												$sepq=select("SUM(tblInvoiceDetails.TotalPayment) as TOTAL","tblAppointments Left join tblInvoiceDetails
											ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID","tblAppointments.AppointmentDate='$date' and tblAppointments.StoreID='$strStoreID'");
										 $TOTAL=$sepq[0]['TOTAL'];
										 if($TOTAL=='' || $TOTAL=='')
										 {
											 $TOTAL=0;
										 }
										 $sepqt=select("count(tblAppointments.AppointmentID) as cntp","tblAppointments","tblAppointments.AppointmentDate='$date' and tblAppointments.StoreID='$strStoreID'");
										 $cntp=$sepqt[0]['cntp'];
											$size=$TOTAL/$cntp;
												?>
												<tr><td><center><b><?=$StoreName?></b></center></td><td><center><b><?=$OpenTimett?></b></center></td><td><center><b><?=$CloseTimett?></b></center></td><td><b><center><?='Rs.'.$TOTAL?></center></b></td><td><b><center><?=$cntp?></center></b></td>
<?php													
													if($strAdminRoleID!='36')
													{
?>												
														
<?php		
													}
													else{
?>
															<td><b><center><?=round($size)?></center></b></td>
<?php														
													}
													
?>
												
												</tr>
												<?php
												// echo $strStoreID;
												// echo "Hello";
											}
										}
									
										$DB->close(); 
?>										
                                
											</tbody>
											</table>
                                    
                                </div>
                              
                                </div>
                            </div>
						<div class="col-md-12">
							
						</div>
                </div>
					<?php 
				$DB = Connect();
				$sqlgraph=select("FromDate,ToDate,Type","tblGraphDateParameter","RoleID='".$strAdminRoleID."'");
				$FromDate=$sqlgraph[0]['FromDate'];
				$ToDate=$sqlgraph[0]['ToDate'];
				$FromDatee=date("d-m-Y",strtotime($FromDate));
				$ToDatee=date('d-m-Y',strtotime($ToDate));
				$Type=$sqlgraph[0]['Type'];
				?>
				<div class="row">
				    <span id="abc" style="display:none"></span>
						 <div class="col-md-12" style="padding-top: 10px;">
						 	<div class="panel mrg20T">
								<div class="panel-body" style="height:60px;">
								
								         <label class="col-sm-3 control-label">Select Duration For Graph<span>*</span></label>
												<div class="col-sm-3">
												<select name="checkgraphduration" id="checkgraphduration" class="form-control required" onchange="checkgraphtype(this.value)">
													 <option value="0" Selected>Select Month & Year</option>
												    <option value="1" <?php if($Type=='1'){ ?> selected="selected" <?php }?> >Current Month Of 2017</option>
													<option value="2" <?php if($Type=='2'){ ?> selected="selected" <?php }?>>Previous Month Of 2017</option>	
													<option value="3" <?php if($Type=='3'){ ?> selected="selected" <?php }?>>Custom Month & Year</option>	
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
				
			<div class="row">
				<span id="abc" style="display:none"></span>
					<div class="col-md-6" style="padding-top: 10px;">
						<div class="panel mrg20T">
							<div class="panel-body">
								<div class="col-md-12">
									<h3 class="title-hero">Target Wise Monthly Sale achieved per day <?="( ".$FromDatee." To ".$ToDatee." )"?></h3>&nbsp;&nbsp;<input type="button" id="viewmonthlysale" class="btn ra-100 btn-primary" value="View All" />
								
								</div>
								
							</div>
						</div>
					</div>
					<div class="col-md-6" style="padding-top: 10px;">
						<div class="panel mrg20T">
							<div class="panel-body">
								<div class="col-md-12">
									<h3 class="title-hero">Monthly Employee Sale achieved Per Day <?="( ".$FromDatee." To ".$ToDatee." )"?></h3>&nbsp;&nbsp;<input type="button" id="viewemployee" class="btn ra-100 btn-primary viewemployee" value="View All" />
								
								</div>
								
							</div>
						</div>
					</div>
			</div>
			
				<div class="row">
				<span id="abc" style="display:none"></span>
					<div class="col-md-4" style="padding-top: 10px;">
						<div class="panel mrg20T">
							<div class="panel-body">
								<div class="col-md-12">
									<div class="col-md-12">
									<?php							
										$First= date('Y-m-01');
										$Last= date('Y-m-t');
										$date=date('Y-m-d');
										$DB=Connect();

                                          $selectcountmem=select("count(*)","tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$First."') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$Last."') and tblInvoiceDetails.Membership_Amount!='' and tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2'");
										$MembershipSold=$selectcountmem[0]['count(*)'];
										if($MembershipSold=="")
										{
											$MembershipSold=0;
										}
                                       $DB->close();
?>							
						
										<div class="tile-box tile-box-alt mrg20B bg-blue-alt" style="background: #a7c3d1;border-color: #a7c3d1; ">
												<div class="tile-header"><b>Monthly Target wise Membership</b></div>
												<div class="tile-content-wrapper">
													<div class="tile-content"><span><b><small></i>Monthly Target wise Membership Sold per day</small></b></span><?=$MembershipSold?></div><b><small></small></i></b>
													

												</div>
										</div>
						
									</div>
									
								</div>
								
							</div>
						</div>
					</div>
			  	<div class="col-md-4" style="padding-top: 10px;">
						<div class="panel mrg20T">
							<div class="panel-body">
								<div class="col-md-12">
									<div class="col-md-12">
									<?php							
										$First= date('Y-m-01');
										$Last= date('Y-m-t');
										$date=date('Y-m-d');
										

                                         
$DB=Connect();

					
						$TotalGiftVouchersSold="Select (SELECT count(0) FROM `tblGiftVouchers` where Date(Date)>='$First' and Date(Date)<='$Last') as TotalGiftVoucherSolds";
						
							$RSP= $DB->query($TotalGiftVouchersSold);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$TotalGiftVoucherSolds = $ROP["TotalGiftVoucherSolds"];
									if($TotalGiftVoucherSolds=="")
									{
										$TotalGiftVoucherSolds='0';
									}
									// echo "".$StoreName."  ".$EmployeeAttendant." Employees <br><br><br>" ;
									// echo $EmployeeAttendant." are present in " . $StoreName."<br><br><br>";
									// echo $StoreName." Gift voucher sale is . ".$TotalGiftVoucherSolds."<br><br><br>";
								}
							}
							if($TotalGiftVoucherSolds=="")
										{
											$TotalGiftVoucherSolds=0;
										}
$DB->close();
                                       $DB->close();
?>							
						
										<div class="tile-box tile-box-alt mrg20B bg-blue-alt" style="background: #33F6FF  ; border-color: #33F6FF;">
												<div class="tile-header"><b>Monthly Target wise gift voucher</b></div>
												<div class="tile-content-wrapper">
													<div class="tile-content"><span><b><small></i>Monthly Target wise gift voucher sold per day</small></b></span><?=$TotalGiftVoucherSolds?></div><b><small></small></i></b>
													

												</div>
										</div>
						
									</div>
									
								</div>
								
							</div>
						</div>
					</div>
					<div class="col-md-4" style="padding-top: 10px;">
						<div class="panel mrg20T">
							<div class="panel-body">
								<div class="col-md-12">
									<div class="col-md-12">
									<?php							
										$First= date('Y-m-01');
										$Last= date('Y-m-t');
										$date=date('Y-m-d');
										

                                         
$DB=Connect();

						$ApprovePending="Select (SELECT count(0) FROM `tblAppointments` where Status=2 and IsDeleted!='1' and ApproveStatus!='1' and AppointmentDate>='$First' and AppointmentDate<='$Last') as ApprovalPendingCount";
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
							if($ApprovalPendingCount=="")
										{
											$ApprovalPendingCount=0;
										}
							
$DB->close();
                                      
?>							
						
										<div class="tile-box tile-box-alt mrg20B bg-blue-alt" style="background: #fc8213;border-color: #fc8213;color:#fff;">
												<div class="tile-header"><b>Montly Reconciliation Pending Invoices</b></div>
												<div class="tile-content-wrapper">
													<div class="tile-content"><span><b><small></i>Montly Reconciliation Pending Invoices</small></b></span><a href="DisplayPRI.php" style="color:#fff;"><?=$ApprovalPendingCount?></a></div><b><small></small></i></b>
													

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