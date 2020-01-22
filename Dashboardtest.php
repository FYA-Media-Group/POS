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
	<?php require_once("incChartsMetaScript.fya"); ?>
	
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
					 <script type="text/javascript" src="assets/widgets/charts/flot/flot-pie.js"></script>
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
				
                    <div class="row">
				<span id="abc" style="display:none"></span>
                        <div class="col-md-8" style="padding-top: 10px;">
                            <div class="row">
                                <div class="col-md-3">
									<a href="#" title="Example tile shortcut" class="tile-box tile-box-shortcut btn-danger"><span class="bs-badge badge-absolute">
<?php
									$DB = Connect();
									// echo $strAdminID;
									// echo "hello";
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
										$Services="Select (SELECT count(Distinct ServiceCode) FROM `tblServices` where StoreID='$strStoreID') as TotalServices";
									}
									else
									{
										$Services="Select (SELECT count(Distinct ServiceCode) FROM `tblServices`) as TotalServices";
									}
									// $Services="Select (SELECT count(0) FROM `tblServices`) as TotalServices";
									$RSf = $DB->query($Services);
									if ($RSf->num_rows > 0) 
									{
										while($rowf = $RSf->fetch_assoc())
										{
											$TotalServicess = $rowf["TotalServices"];
											echo $TotalServicess;
										}
									}
									$DB->close();
?>								
									</span><div class="tile-header">Services</div><div class="tile-content-wrapper"><i class="glyph-icon icon-file-photo-o"></i></div></a>
								</div>
                                <div class="col-md-3">
                                    <a href="#" title="Services" class="tile-box tile-box-shortcut btn-success">
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
										if($strStoreID!=0)
										{
											$Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
										}
										else
										{
											$Products="Select (SELECT count(0) FROM `tblNewProducts`) as TotalProducts";
										}
										
										$RSa = $DB->query($Products);
										if ($RSa->num_rows > 0) 
										{
											while($rowa = $RSa->fetch_assoc())
											{
												$TotalProducts = $rowa["TotalProducts"];
												echo $TotalProducts;
											}
										}
										$DB->close();
?>									
										</span>
                                        <div class="tile-header">Products</div>
                                        <div class="tile-content-wrapper"><i class="glyph-icon icon-desktop"></i></div>
                                    </a>
                                </div>
                                <div class="col-md-3">
									<a href="#" title="Example tile shortcut" class="tile-box tile-box-shortcut btn-info">
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
										if($strStoreID!=0)
										{
											$Employee="Select (SELECT count(0) FROM `tblEmployees` where StoreID='$strStoreID') as TotalEmployees";
										}
										else
										{
											$Employee="Select (SELECT count(0) FROM `tblEmployees`) as TotalEmployees";
										}
										
										$RSb = $DB->query($Employee);
										if ($RSb->num_rows > 0) 
										{
											while($rowb = $RSb->fetch_assoc())
											{
												$TotalEmployee = $rowb["TotalEmployees"];
												echo $TotalEmployee;
											}
										}
										$DB->close();
?>	
									</span>
									<div class="tile-header">Employees</div><div class="tile-content-wrapper"><i class="glyph-icon icon-download"></i></div>
									</a>
								</div>
                                <div class="col-md-3">
                                    <a href="#" title="Example tile shortcut" class="tile-box tile-box-shortcut btn-warning">
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
                                        <div class="tile-header">Appointments</div>
                                        <div class="tile-content-wrapper"><i class="glyph-icon icon-code-fork"></i></div>
                                    </a>
                                </div>
                            </div>
								<div class="panel mrg20T">
									<div class="panel-body">
										<h3 class="title-hero">Monthly Sales</h3>
										<div class="example-box-wrapper">
											<div id="chartdiv"></div>
										</div>
									</div>
								</div>
                           
                           
                            <!--<div class="panel">
                                <div class="panel-body">
                                    <h3 class="title-hero">Alternate carousel</h3>
                                    <div class="example-box-wrapper">
                                        <div class="owl-carousel-4 slider-wrapper inverse arrows-outside carousel-wrapper">
                                            <div>
                                                <div class="thumbnail-box-wrapper mrg5A">
                                                    <div class="thumbnail-box">
                                                        <a class="thumb-link" href="#" title=""></a>
                                                        <div class="thumb-content">
                                                            <div class="center-vertical">
                                                                <div class="center-content"><i class="icon-helper icon-center animated zoomInUp font-white glyph-icon icon-linecons-camera"></i></div>
                                                            </div>
                                                        </div>
                                                        <div class="thumb-overlay bg-black"></div><img src="assets/image-resources/stock-images/img-17.jpg" alt=""></div>
                                                    <div class="thumb-pane">
                                                        <h3 class="thumb-heading animated rollIn"><a href="#" title="">Working in the morning</a> <small>12 March 2015</small></h3></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="thumbnail-box-wrapper mrg5A">
                                                    <div class="thumbnail-box">
                                                        <a class="thumb-link" href="#" title=""></a>
                                                        <div class="thumb-content">
                                                            <div class="center-vertical">
                                                                <div class="center-content"><i class="icon-helper icon-center animated zoomInUp font-white glyph-icon icon-linecons-camera"></i></div>
                                                            </div>
                                                        </div>
                                                        <div class="thumb-overlay bg-black"></div><img src="assets/image-resources/stock-images/img-18.jpg" alt=""></div>
                                                    <div class="thumb-pane">
                                                        <h3 class="thumb-heading animated rollIn"><a href="#" title="">Working in the morning</a> <small>12 March 2015</small></h3></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="thumbnail-box-wrapper mrg5A">
                                                    <div class="thumbnail-box">
                                                        <a class="thumb-link" href="#" title=""></a>
                                                        <div class="thumb-content">
                                                            <div class="center-vertical">
                                                                <div class="center-content"><i class="icon-helper icon-center animated zoomInUp font-white glyph-icon icon-linecons-camera"></i></div>
                                                            </div>
                                                        </div>
                                                        <div class="thumb-overlay bg-black"></div><img src="assets/image-resources/stock-images/img-19.jpg" alt=""></div>
                                                    <div class="thumb-pane">
                                                        <h3 class="thumb-heading animated rollIn"><a href="#" title="">Working in the morning</a> <small>12 March 2015</small></h3></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="thumbnail-box-wrapper mrg5A">
                                                    <div class="thumbnail-box">
                                                        <a class="thumb-link" href="#" title=""></a>
                                                        <div class="thumb-content">
                                                            <div class="center-vertical">
                                                                <div class="center-content"><i class="icon-helper icon-center animated zoomInUp font-white glyph-icon icon-linecons-camera"></i></div>
                                                            </div>
                                                        </div>
                                                        <div class="thumb-overlay bg-black"></div><img src="assets/image-resources/stock-images/img-20.jpg" alt=""></div>
                                                    <div class="thumb-pane">
                                                        <h3 class="thumb-heading animated rollIn"><a href="#" title="">Working in the morning</a> <small>12 March 2015</small></h3></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="thumbnail-box-wrapper mrg5A">
                                                    <div class="thumbnail-box">
                                                        <a class="thumb-link" href="#" title=""></a>
                                                        <div class="thumb-content">
                                                            <div class="center-vertical">
                                                                <div class="center-content"><i class="icon-helper icon-center animated zoomInUp font-white glyph-icon icon-linecons-camera"></i></div>
                                                            </div>
                                                        </div>
                                                        <div class="thumb-overlay bg-black"></div><img src="assets/image-resources/stock-images/img-23.jpg" alt=""></div>
                                                    <div class="thumb-pane">
                                                        <h3 class="thumb-heading animated rollIn"><a href="#" title="">Working in the morning</a> <small>12 March 2015</small></h3></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="thumbnail-box-wrapper mrg5A">
                                                    <div class="thumbnail-box">
                                                        <a class="thumb-link" href="#" title=""></a>
                                                        <div class="thumb-content">
                                                            <div class="center-vertical">
                                                                <div class="center-content"><i class="icon-helper icon-center animated zoomInUp font-white glyph-icon icon-linecons-camera"></i></div>
                                                            </div>
                                                        </div>
                                                        <div class="thumb-overlay bg-black"></div><img src="assets/image-resources/stock-images/img-24.jpg" alt=""></div>
                                                    <div class="thumb-pane">
                                                        <h3 class="thumb-heading animated rollIn"><a href="#" title="">Working in the morning</a> <small>12 March 2015</small></h3></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                        <div class="col-md-4" style="padding-top: 10px;">
						<div class="dashboard-box dashboard-box-chart bg-white content-box">
                                <div class="content-wrapper">
                                    <div class="header">
									
<?php									
											$DB=Connect();
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
?>
									<b>Rs.<?=$TodalSales?></b><span>Today's Total Sales</span></div>
                                    
                                </div>
                                <!--<div class="button-pane">
                                    <div class="size-md float-left"><a href="#" title="">View more details</a></div><a href="#" class="btn btn-primary float-right tooltip-button" data-placement="top" title="View details"><i class="glyph-icon icon-caret-right"></i></a></div>-->
                            </div>
                            <div class="dashboard-box dashboard-box-chart bg-white content-box">
                                <div class="content-wrapper">
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
										$DB->close();
?>								
                                    <div class="header"><b><?=$TodayApp;?></b><span>Total Appointments <b> From </b> Sep 2016</span></div>
                                    
                                </div>
                                <!--<div class="button-pane">
                                    <div class="size-md float-left"><a href="http://nailspa.fyatest.website/pos/admin/ViewAppointments.php" title="">View more details</a></div><a href="#" class="btn btn-primary float-right tooltip-button" data-placement="top" title="View details"><i class="glyph-icon icon-caret-right"></i></a></div>-->
                            </div>
							
							<div class="dashboard-box dashboard-box-chart bg-white content-box">
                                <div class="content-wrapper">
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
										$DB->close();	
?>
                                    <div class="header"><b>Rs.<?=$PendingTotal?></b><span>Total Amount Pending</span></div>
                                    
                                </div>
                                <!--<div class="button-pane">
                                    <div class="size-md float-left"><a href="#" title="">View more details</a></div><a href="#" class="btn btn-primary float-right tooltip-button" data-placement="top" title="View details"><i class="glyph-icon icon-caret-right"></i></a></div>-->
                            </div>
							   	<div class="dashboard-box dashboard-box-chart bg-white content-box">
                                <div class="content-wrapper">
<?php									
										$DB = Connect();
										
										    $First= date('Y-m-01');
											$Last= date('Y-m-t');
											$Month=date('M');
										
											$Products="SELECT count(CustomerID) as TotalProducts FROM `tblCustomers` where Date(RegDate)>=Date('$First') and Date(RegDate)<=Date('$Last')";
											
										// echo $Products;
										$RSa = $DB->query($Products);
										if ($RSa->num_rows > 0) 
										{
											while($rowa = $RSa->fetch_assoc())
											{
												$TotalProducts = $rowa["TotalProducts"];
												// echo $TotalProducts;
											}
										}
										$DB->close();
?>						
                                        <div class="header"><b><?=$TotalProducts?></b><span>Customers New in <?=$Month?></div>
                                       
                                    </div>
                                </div>
								<div class="dashboard-box dashboard-box-chart bg-white content-box">
                                <div class="content-wrapper">
 <div class="panel">
                                <div class="panel-body">
                                    <h3 class="title-hero">Donut hole</h3>
                                    <div class="example-box-wrapper clearfix">
                                        <div id="data-donut-1" style="width: 100%; height: 200px"></div>
                                    </div>
                                </div>
                            </div>
                                    </div>
                                </div>	
							<div class="dashboard-box dashboard-box-chart bg-white content-box">
                                <div class="content-wrapper">
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
											$MSold="Select (SELECT count(MembershipID) FROM `MembershipID` where StoreId='$strStoreID' and StartDay='$date') as MembershipIDSold";
											$OSold="Select (SELECT count(OfferAmt) FROM `OfferID` where StoreId='$strStoreID' and StartDay='$date') as MembershipIDSold";
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
									
										$First= date('Y-m-01');
										$Last= date('Y-m-t');
										$membershipamount="SELECT count(memberid) as TodaysMembership FROM `tblCustomers` where Date(MembershipDateTime)>=Date('$First') and Date(MembershipDateTime)<=Date('$Last') ";
											// echo $membershipamount;
												$DB = Connect();
												$RSc = $DB->query($membershipamount);
												if ($RSc->num_rows > 0) 
												{
													while($rowc = $RSc->fetch_assoc())
													{
														$TodaysMembership = $rowc["TodaysMembership"];
														// echo $TodaysMembership;
													}
												}
												$Services="SELECT count(OfferID) as TotalOffers FROM `tblAppointmentMembershipDiscount` where Date(DateTimeStamp)>=Date('$First') and Date(DateTimeStamp)<=Date('$Last') and OfferID > '0'";
								
												// $Services="Select (SELECT count(0) FROM `tblServices`) as TotalServices";
												// echo $Services;
												$RSf = $DB->query($Services);
												if ($RSf->num_rows > 0) 
												{
													while($rowf = $RSf->fetch_assoc())
													{
														$TotalOffers = $rowf["TotalOffers"];
														// echo $TotalOffers;
													}
												}
												$totalM=$TodaysMembership+$TotalOffers;
													$DB->close();
?>										
                                    <div class="header"><b><?=$totalM?></b><span>Total Offer and Membership Sold in this month</span></div>
                                    
                                </div>
                                <!--<div class="button-pane">
                                    <div class="size-md float-left"><a href="#" title="">View more details</a></div><a href="#" class="btn btn-primary float-right tooltip-button" data-placement="top" title="View details"><i class="glyph-icon icon-caret-right"></i></a></div>-->
                            </div>
                            	<!--<div class="dashboard-box dashboard-box-chart bg-white content-box">-->
                                
                            <!--<div class="row">
                                <div class="col-md-6">
                                    <div class="panel-layout">
                                        <div class="panel-box">
                                            <div class="panel-content bg-facebook"><i class="glyph-icon font-size-35 icon-facebook"></i></div>
                                            <div class="panel-content pad15A bg-white">
                                                <div class="center-vertical">
                                                    <ul class="center-content list-group list-group-separator row mrg0A">
                                                        <li class="col-md-6"><b>1,456</b>
                                                            <p class="font-gray">Friends</p>
                                                        </li>
                                                        <li class="col-md-6"><b>593</b>
                                                            <p class="font-gray">Likes</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel-layout">
                                        <div class="panel-box">
                                            <div class="panel-content bg-twitter"><i class="glyph-icon font-size-35 icon-twitter"></i></div>
                                            <div class="panel-content pad15A bg-white">
                                                <div class="center-vertical">
                                                    <ul class="center-content list-group list-group-separator row mrg0A">
                                                        <li class="col-md-6"><b>356</b>
                                                            <p class="font-gray">Followers</p>
                                                        </li>
                                                        <li class="col-md-6"><b>981</b>
                                                            <p class="font-gray">Tweets</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            <!--<div class="panel">
                                <div class="panel-body">
                                    <h3 class="title-hero">Users activity</h3>
                                    <div class="example-box-wrapper">
                                        <div class="timeline-box timeline-box-left">
                                            <div class="tl-row">
                                                <div class="tl-item float-right">
                                                    <div class="tl-icon bg-red"><i class="glyph-icon icon-toggle-on"></i></div>
                                                    <div class="popover right">
                                                        <div class="arrow"></div>
                                                        <div class="popover-content">
                                                            <div class="tl-label bs-label label-info">Appointment</div>
                                                            <p class="tl-content">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio.</p>
                                                            <div class="tl-time"><i class="glyph-icon icon-clock-o"></i> a few seconds ago</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tl-row">
                                                <div class="tl-item float-right">
                                                    <div class="tl-icon bg-primary"><i class="glyph-icon icon-wifi"></i></div>
                                                    <div class="popover right">
                                                        <div class="arrow"></div>
                                                        <div class="popover-content">
                                                            <div class="tl-label bs-label bg-yellow">Teleconference</div>
                                                            <p class="tl-content">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio.</p>
                                                            <div class="tl-time"><i class="glyph-icon icon-clock-o"></i> a few seconds ago</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tl-row">
                                                <div class="tl-item float-right">
                                                    <div class="tl-icon bg-black"><i class="glyph-icon icon-headphones"></i></div>
                                                    <div class="popover right">
                                                        <div class="arrow"></div>
                                                        <div class="popover-content">
                                                            <div class="tl-label bs-label label-danger">Meeting</div>
                                                            <p class="tl-content">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio.</p>
                                                            <div class="tl-time"><i class="glyph-icon icon-clock-o"></i> a few seconds ago</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                        <!--</div>-->
                    </div>
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
													<!--<th  style="text-align:center">Average Ticket Size</th>-->
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
												<!--<td><b><center><?//=round($size)?></center></b></td>-->
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
                </div>
            </div>
        </div>
		
		<?php require_once 'incFooter.fya'; ?>
 
    </div>
</body>

</html>