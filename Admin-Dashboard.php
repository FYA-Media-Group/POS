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
	<?php require_once("incpiechart.fya"); ?>
	<?php //require_once("incProductUsedScript-Admin.fya"); ?>
	<?php require_once("incEmpAttendanceScript-Admin.fya"); ?>
	<?php require_once("incPettyCashScript-Admin.fya"); ?>
    <?php// require_once("incEmployeeTarget-Admin.fya"); ?>

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
                     <script type="text/javascript" src="assets/widgets/carousel/carousel.js"></script>
                    <link rel="stylesheet" type="text/css" href="assets/widgets/owlcarousel/owlcarousel.css">
                    <script type="text/javascript" src="assets/widgets/owlcarousel/owlcarousel.js"></script>
                    <script type="text/javascript" src="assets/widgets/owlcarousel/owlcarousel-demo.js"></script>
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
							
						$("#viewpetty").click(function()
						{
							window.location="ViewPettyAll.php";
							
						});
						$("#viewemployee").click(function()
						{
							window.location="ViewEmployeeTargetAll.php";
							
						});
						$("#viewproddd").click(function()
						{
							//alert(11)
						window.location="ViewProductAll.php";
							
						});
						$("#viewemployeeatten").click(function()
						{
							//alert(11)
						window.location="ViewEmployeeAttendance.php";
							
						});
						
						
							
                        });

                        /* Datatable row highlight */

                        $(document).ready(function() {
                            var table = $('#datatable-row-highlight').DataTable();

                            $('#datatable-row-highlight tbody').on('click', 'tr', function() {
                                $(this).toggleClass('tr-selected');
                            });
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
										window.location = "Admin-Dashboard.php";

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
										window.location = "Admin-Dashboard.php";
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
										window.location = "Admin-Dashboard.php";
									}
									
								  })
						}


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
				<div class="panel" style="padding:2%;">

                <div class="row">
					<span id="abc" style="display:none"></span>
					<div class="tile-box col-md-2" style="background: #fc8213;border-color: #fc8213;margin-right:03%; margin-left:1.5%;">
					<div class="panel-content">
					<div style="font-size:12px;"><b>Reconciliation Pending Invoices</b></style></div>
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
$DB->close();	
?>	
						<a href="DisplayPRI.php" class="btn btn-lg"  style="background: #fc8213;border-color: #fc8213;color:#fff;"><?=$ApprovalPendingCount?></a>	
			
					</div>
				</div>
				
				<span id="abc" style="display:none"></span>
					<div class="tile-box col-md-2" style="background: #dc1156;border-color: #dc1156;margin-right:03%;">
					<div class="panel-content">
					<div style="font-size:12px;"><b>Low Stock Products</b></style></div>
<?php				
$DB=Connect();
						$TotalProductAlert="Select (SELECT count(0) FROM `tblStoreProduct` where Stock<5) as ProductAlertCount";
						// echo $TotalProductAlert."<br><br><br>";
						
							$RSP= $DB->query($TotalProductAlert);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$ProductAlertCount = $ROP["ProductAlertCount"];
									if($ProductAlertCount=="")
									{
										$ProductAlertCount='0';
									}									
								}
							}
$DB->close();
?>				
						<a href="DisplayProductAlertAdmin.php" class="btn btn-lg"  style="background: #dc1156;border-color: #dc1156;color:#fff;"><?=$ProductAlertCount?></a>	
				
					</div>
				</div>
				
				<span id="abc" style="display:none"></span>
					<div class="tile-box col-md-2" style="background: #77dd77;border-color: #77dd77;margin-right:03%;">
					<div class="panel-content">
					<div style="font-size:12px;"><b>Membership & Sold</b></style></div>
<?php
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');
$DB=Connect();

                                       $selectcountmem=select("count(*)","tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$First."') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$Last."') and tblInvoiceDetails.Membership_Amount!='' and tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2'");
										$MembershipSold=$selectcountmem[0]['count(*)'];
										
					
$DB->close();
?>		
						<a href="DisplayMembershipSold.php" class="btn btn-lg" style="background: #77dd77;border-color: #77dd77;color:#fff;"><?=$MembershipSold?></a>	
					
					</div>
                       
				</div>
				<span id="abc" style="display:none"></span>
					<div class="tile-box col-md-2" style="background: #1296ff;border-color: #1296ff;margin-right:03%;">
					<div class="panel-content">
					<div style="font-size:12px;"><b>Pending Cash Reconciliation</b></style></div>
<?php		
								$DB = Connect();
								$First= date('Y-m-01');
							     $Last= date('Y-m-t');
							      $sep=select("DISTINCT(tblInvoiceDetails.InvoiceId)","tblInvoiceDetails left join tblAppointments ON  tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.IsDeleted!='1' and tblAppointments.StoreID!='0' and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$First."') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$Last."') and tblInvoiceDetails.Flag='CS'");
								 foreach($sep as $tyss)
								 {
									 $invv[]=$tyss['InvoiceId'];
								 }
								
								 for($i=0;$i<count($invv);$i++)
								 {
										$PendingAmountStoresVV="Select SUM(tblPendingPayments.PendingAmount)as Pending from tblPendingPayments WHERE tblPendingPayments.PendingStatus='2'  AND InvoiceID='".$invv[$i]."'";
									//	echo $PendingAmountStoresVV;
											$RSP= $DB->query($PendingAmountStoresVV);
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
								 }



               
			
$DB->close();
?>	

						<a href="DisplayPendingCashReconciliationadmin.php" class="btn btn-lg"  style="background: #1296ff;border-color: #1296ff;color:#fff;"><?=$Pendingcash?></a>	
					
					</div>
                       
				</div>
				
				<span id="abc" style="display:none"></span>
					<div class="tile-box col-md-2" style="background: #a7c3d1;border-color: #a7c3d1; margin-right:03%;">
					<div class="panel-content">
					<div style="font-size:12px;"><b>Outstanding Payment</b></style></div>
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
						<a href="DisplayOutstandingPaymentAdmin.php" class="btn btn-lg"  style="background: #a7c3d1;border-color: #a7c3d1;color:#fff;">Rs. <?=$Pending?>/-</a>	
						
					</div>
                       
				</div>
				
				
				
            </div>
            </div>
			
				
													<?php 
													            $DB = Connect();
																$sepqtdata=select("count(*)","tblOffers","ImagePath!=''");
																$countimage=$sepqtdata[0]['count(*)'];
																if($countimage>0)
																{
																	
																
													?>
													<div class="row">
				                          <div class="panel">
                                                    <div class="panel-body">
                                                        <h3 class="title-hero">Offer carousel</h3>
                                                        <div class="example-box-wrapper">
                                                            <div class="owl-carousel-4 slider-wrapper inverse arrows-outside carousel-wrapper">
                                                               
																<?php 
																
																 $sepqt=select("*","tblOffers","ImagePath!=''");
																 foreach($sepqt as $vp)
																 {
																?>
																 <div>
                                                                    <div class="thumbnail-box-wrapper mrg5A">
                                                                        <div class="thumbnail-box"> <a class="thumb-link" href="#" title=""></a>
                                                                            <div class="thumb-content">
                                                                                <div class="center-vertical">
                                                                                    <div class="center-content"><i class="icon-helper icon-center animated zoomInUp font-white glyph-icon icon-linecons-camera"></i></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="thumb-overlay bg-black"></div><img src="<?=$vp['ImagePath']?>" alt=""></div>
                                                                        
                                                                    </div>
                                                                </div>
																	<?php 
																	
																 }
																	?>
                                                              
                                                            </div>
                                                        </div>
														</div>
                                                </div>
				</div>
				
														<?php 
																}
														?>
                                                    
			
			
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
													<th  style="text-align:center">Total Appointments</th>
													<th  style="text-align:center">Done Appointments</th>
												    <th  style="text-align:center">Pending Appointments</th>
													<th  style="text-align:center">Upcoming Appointments</th>
													<th  style="text-align:center">Cancel Appointments</th>
													<th  style="text-align:center">Delayed Appointments</th>
													<th  style="text-align:center">Rescheduled Appointments</th>
												

													
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
												$strStoreIDd = $rowf["StoreID"];
												$selp=select("StoreName","tblStores","StoreID='".$strStoreIDd."'");
												$StoreName=$selp[0]['StoreName'];
												$OpenTime = $rowf["OpenTime"];
												$CloseTime = $rowf["CloseTime"];
												
												$OpenTimet = date("H:i:s",strtotime($OpenTime));
												$OpenTimett = get12hour($OpenTimet);
												$CloseTimet = date("H:i:s",strtotime($CloseTime));
												$CloseTimett = get12hour($CloseTimet);
												$sepq=select("SUM(tblInvoiceDetails.TotalPayment) as TOTAL","tblAppointments Left join tblInvoiceDetails
											ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID","tblAppointments.AppointmentDate='".$date."' and tblAppointments.StoreID='$strStoreIDd'");
										 $TOTAL=$sepq[0]['TOTAL'];
										 if($TOTAL=='' || $TOTAL=='')
										 {
											 $TOTAL=0;
										 }
										 $sepqt=select("count(tblAppointments.AppointmentID) as cntp","tblAppointments","tblAppointments.AppointmentDate='".$date."' and tblAppointments.StoreID='$strStoreIDd'");
										 $cntp=$sepqt[0]['cntp'];
										 $sepqtpending=select("count(tblAppointments.AppointmentID) as cntpen","tblAppointments","tblAppointments.AppointmentDate='".$date."' and tblAppointments.StoreID='$strStoreIDd' and Status='1'");
										 $cntpen=$sepqtpending[0]['cntpen'];
										 $sepqtdone=select("count(tblAppointments.AppointmentID) as cntdone","tblAppointments","tblAppointments.AppointmentDate='".$date."' and tblAppointments.StoreID='$strStoreIDd' and Status='2'");
										 $cntdone=$sepqtdone[0]['cntdone'];
										 
										  $sepqtcancel=select("count(tblAppointments.AppointmentID) as cntcancel","tblAppointments","tblAppointments.AppointmentDate='".$date."' and tblAppointments.StoreID='$strStoreIDd' and Status='3'");
										 $cntcancel=$sepqtcancel[0]['cntcancel'];
										 
										 $sepqtupcome=select("count(tblAppointments.AppointmentID) as cntupcome","tblAppointments","tblAppointments.AppointmentDate='".$date."' and tblAppointments.StoreID='$strStoreIDd' and Status='0'");
										 $cntupcome=$sepqtupcome[0]['cntupcome'];
										 
										 $sepqtdelayed=select("count(tblAppointments.AppointmentID) as cntdealyed","tblAppointments","tblAppointments.AppointmentDate='".$date."' and tblAppointments.StoreID='$strStoreIDd' and Status='5'");
										 $cntdealyed=$sepqtdelayed[0]['cntdealyed'];
										 
										 
										$sepqtresche=select("count(tblAppointments.AppointmentID) as cntresh","tblAppointments","tblAppointments.AppointmentDate='".$date."' and tblAppointments.StoreID='$strStoreIDd' and Status='6'");
										 $cntres=$sepqtresche[0]['cntresh'];
											$size=$TOTAL/$cntp;
												?>
												<tr><td><center><b><?=$StoreName?></b></center></td><td><center><b><?=$OpenTimett?></b></center></td><td><center><b><?=$CloseTimett?></b></center></td><td><b><center><?='Rs.'.$TOTAL?></center></b></td><td><b><center><?=$cntp?></center></b></td><td><b><center><?=$cntdone?></center></b></td><td><b><center><?=$cntpen?></center></b></td><td><b><center><?=$cntupcome?></center></b></td><td><b><center><?=$cntcancel?></center></b></td><td><b><center><?=$cntdealyed?></center></b></td>
												<td><b><center><?=$cntres?></center></b></td>
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
										<h3 class="title-hero">Petty Cash <?="( ".$FromDatee." To ".$ToDatee." )"?></h3>&nbsp;&nbsp;
										<div class="example-box-wrapper">
											<div id="chartdivPetty"></div>
										</div>
									</div>
									
								</div>
							</div>
                        </div>
						<div class="col-md-6" style="padding-top: 10px;">
						<div class="panel mrg20T">
							<div class="panel-body">
								<div class="col-md-12">
									<h3 class="title-hero">Employee Attendance <?="( ".$FromDatee." To ".$ToDatee." )"?></h3>&nbsp;&nbsp;<input type="button" id="viewemployeeatten" class="btn ra-100 btn-primary" value="View All">
									<div class="example-box-wrapper">
										<div id="chartdivEmpAttendance"></div>
									
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