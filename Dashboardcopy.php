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
	elseif($strAdminRoleID=='4')
	{
		echo("<script>location.href='Operation-Dashboard.php';</script>");
	}elseif($strAdminRoleID=='39')
	{
		echo("<script>location.href='Admin-Dashboard.php';</script>");
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
	<script type="text/javascript" src="assets/widgets/charts/chart-js/chart-doughnut.js"></script>
    
    <script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
	<script type="text/javascript" src="https://www.amcharts.com/lib/3/themes/patterns.js"></script>
    <script type="text/javascript">
			AmCharts.makeChart("chartdiv2",
				{
					"type": "serial",
					"categoryField": "category",
					"plotAreaBorderColor": "#77dd77",
					"startDuration": 1,
					"borderColor": "#77dd77",
					"theme": "patterns",
					"categoryAxis": {
						"gridPosition": "start"
					},
					"trendLines": [],
					"graphs": [
						{
							"colorField": "#77dd77",
							"cornerRadiusTop": 1,
							"fillAlphas": 1,
							"fillColors": "#77dd77",
							"fixedColumnWidth": 80,
							"id": "AmGraph-1",
							"lineColorField": "#77dd77",
							"negativeFillColors": "#77dd77",
							"title": "graph 1",
							"type": "column",
							"valueField": "column-1"
						}
					],
					"guides": [],
					"valueAxes": [
						{
							"id": "ValueAxis-1",
							"title": "Axis title"
						}
					],
					"allLabels": [],
					"balloon": {},
					"titles": [
						{
							"id": "Title-1",
							"size": 15,
							"text": "Chart Title"
						}
					],
					"dataProvider": [
						{
							"category": "category 1",
							"column-1": 8,
						},
						{
							"category": "category 2",
							"column-1": 16
						},
						{
							"category": "category 3",
							"column-1": 2
						},
						{
							"category": "category 4",
							"column-1": 7
						},
						{
							"category": "category 5",
							"column-1": 5
						}
					]
				}
			);
		</script>
        
        <style>
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;

    /* Position the tooltip */
    position: absolute;
    z-index: 1090;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
}
</style>

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
					<div style="font-size:14px;"><b>New Clients Monthly</b></style></div>
					<?php
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');
$DB=Connect();
// ApproveInvoices="SELECT * FROM tblAppointments where status='2' and IsDeleted!='1' and ApproveStatus='1' order by AppointmentID desc";

						$NewCustomersonEachStore="Select count(tblCustomers.CustomerID)as NewCustomersPerDay from tblCustomers Left Join tblAppointments ON tblCustomers.CustomerID=tblAppointments.CustomerID where Date(tblCustomers.RegDate)>='$First' and Date(tblCustomers.RegDate)<='$Last'";
						// echo $NewCustomersonEachStore."<br><br><br>";

							$RSP= $DB->query($NewCustomersonEachStore);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$NewCustomersPerDay = $ROP["NewCustomersPerDay"];
									if($NewCustomersPerDay=="")
									{
										$NewCustomersPerDay='0';
									}
									// echo $NewCustomersPerDay;
									// echo "New Customers on " .$StoreName." is Rs. ".$NewCustomersPerDay."<br><br><br>" ;
								}
							}
			
									$DB->close();
?>
						<div class="tooltip"><button class="btn btn-lg" style="background: #fc8213;border-color: #fc8213;color:#fff;"><?=$NewCustomersPerDay?><span class="tooltiptext">Tooltip text</span></button></div>	
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							   <div class="modal-dialog">
								   <div class="modal-content">
									   <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										   
									   <div class="modal-body">
										   <p>

										   </p>
										   
									   </div>
									   <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close Modal</button> </div>
								   </div>
							   </div>
							</div>
						</div>
					</div>
				</div>
				
				<span id="abc" style="display:none"></span>
					<div class="tile-box col-md-2" style="background: #dc1156;border-color: #dc1156;margin-right:03%;">
					<div class="panel-content">
					<div style="font-size:14px;"><b>Average<br>Revenue</b></style></div>
<?php					
					
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');
$DB=Connect();

						$AverageRevinueperclient="SELECT SUM(tblInvoiceDetails.TotalPayment) as TotalPay, count(tblAppointments.CustomerID) as TotalCustomers FROM tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where  tblInvoiceDetails.Flag='C' OR tblInvoiceDetails.Flag='CS' OR tblInvoiceDetails.Flag='BOTH' and tblAppointments.AppointmentDate<='$First' and tblAppointments.AppointmentDate>='$Last'";
						
							$RSAR= $DB->query($AverageRevinueperclient);
							if($RSAR->num_rows>0)
							{
								while($ROAR=$RSAR->fetch_assoc())
								{
									$TotalPay = $ROAR["TotalPay"];
									$TotalCustomers = $ROAR["TotalCustomers"];
									
										
										$Average=$TotalPay/$TotalCustomers;
										$finalAvg=round($Average)	;
												// echo $StoreName." Per Client Rs. ".$Average."<br><br><br>";
								
									
								}
							}
$DB->close();
?>
						<button class="btn btn-lg" data-toggle="modal" data-target="#myModal" style="background: #dc1156;border-color: #dc1156;color:#fff;">Rs. <?=$finalAvg?>/-</button>	
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							   <div class="modal-dialog">
								   <div class="modal-content">
									   <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										   
									   <div class="modal-body">
										   <p>

										   </p>
										  
									   </div>
									   <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close Modal</button> </div>
								   </div>
							   </div>
							</div>
						</div>
					</div>
				</div>
				
				<span id="abc" style="display:none"></span>
					<div class="tile-box col-md-2" style="background: #77dd77;border-color: #77dd77;margin-right:03%;">
					<div class="panel-content">
					<div style="font-size:14px;"><b>Reconciliation Pending Invoices</b></style></div>
<?php
$DB=Connect();

						$ApprovePending="Select (SELECT count(0) FROM `tblAppointments` where Status=2 and IsDeleted!='1' and ApproveStatus!='1' and AppointmentDate>='$First' and AppointmentDate<='$Last') as ApprovalPendingCount";
						// echo $ApproveInvoices."<br><br><br>";

							$RSAI= $DB->query($ApprovePending);
							if($RSAI->num_rows>0)
							{
								while($ROS=$RSAI->fetch_assoc())
								{
									$ApprovalPendingCount = $ROS["ApprovalPendingCount"];
									// echo "Invoice Approval Pending on " .$StoreName." are ".$ApprovalPendingCount."<br><br><br>" ;
									
								}
							}
$DB->close();	
?>

	
						<button class="btn btn-lg" data-toggle="modal" data-target="#myModal" style="background: #77dd77;border-color: #77dd77;color:#fff;"><?=$ApprovalPendingCount?></button>	
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							   <div class="modal-dialog">
								   <div class="modal-content">
									   <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										   
									   <div class="modal-body">
										   <p>

										   </p>
										 
									   </div>
									   <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close Modal</button> </div>
								   </div>
							   </div>
							</div>
						</div>
					</div>
                       
				</div>
				<span id="abc" style="display:none"></span>
					<div class="tile-box col-md-2" style="background: #1296ff;border-color: #1296ff;margin-right:03%;">
					<div class="panel-content">
					<div style="font-size:14px;"><b>Discount<br>Given</b></style></div>
<?php		
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');

$DB=Connect();
					
						$MembershipAmount="Select SUM(tblAppointmentMembershipDiscount.MembershipAmount)as MembershipAmt, SUM(tblAppointmentMembershipDiscount.OfferAmount)as Offeramount from tblAppointmentMembershipDiscount Left Join tblAppointments ON tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID WHERE  Date(tblAppointmentMembershipDiscount.DateTimeStamp)>='$First' and Date(tblAppointmentMembershipDiscount.DateTimeStamp)<='$Last'";
						// echo $MembershipAmount."<br><br><br>";
						
							$RSP= $DB->query($MembershipAmount);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$MembershipAmt = $ROP["MembershipAmt"];
									$Offeramount = $ROP["Offeramount"];
									if($MembershipAmt=="")
									{
										$MembershipAmt='0';
									}if($Offeramount=="")
									{
										$Offeramount='0';
									}
									$TotalDiscount=$Offeramount+$MembershipAmt;
									
									$DisAmt="Select Sum(Amount)as DiscountAmt from tblGiftVouchers where Date(RedempedDateTime)>='$First' and Date(RedempedDateTime)<='$Last'";
									// echo $DisAmt."<br><br><br><br>";
									$RSD= $DB->query($DisAmt);
									if($RSD->num_rows>0)
									{
										while($ROD=$RSD->fetch_assoc())
										{
											$DiscountAmt = $ROD["DiscountAmt"];
											// $DiscountAmt;
											$TotalDisc=$TotalDiscount+$DiscountAmt;
											// echo $TotalDisc."<br>";
											$RoundTotal=round($TotalDisc);
										}
									}	
									// echo $StoreName." Total Disc is Rs. ".$TotalDisc."<br><br><br>";
									
								}
							}

?>	
						<button class="btn btn-lg" data-toggle="modal" data-target="#myModal" style="background: #1296ff;border-color: #1296ff;color:#fff;">Rs. <?=$RoundTotal?>/-</button>	
						
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							   <div class="modal-dialog">
								   <div class="modal-content">
									   <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										   
									   <div class="modal-body">
										   <p>

										   </p>
										 
									   </div>
									   <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close Modal</button> </div>
								   </div>
							   </div>
							</div>
						</div>
					</div>
                       
				</div>
				
				<span id="abc" style="display:none"></span>
					<div class="tile-box col-md-2" style="background: #a7c3d1;border-color: #a7c3d1; margin-right:03%;">
					<div class="panel-content">
					<div style="font-size:14px;"><b>Offer Wise Redemptions</b></style></div>
<?php		
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');

$DB=Connect();
					
						$MembershipAmount="Select SUM(tblAppointmentMembershipDiscount.MembershipAmount)as MembershipAmt, SUM(tblAppointmentMembershipDiscount.OfferAmount)as Offeramount from tblAppointmentMembershipDiscount Left Join tblAppointments ON tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID WHERE  Date(tblAppointmentMembershipDiscount.DateTimeStamp)>='$First' and Date(tblAppointmentMembershipDiscount.DateTimeStamp)<='$Last'";
						// echo $MembershipAmount."<br><br><br>";
						
							$RSP= $DB->query($MembershipAmount);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$Offeramount = $ROP["Offeramount"];
									if($Offeramount=="")
									{
										$Offeramount='0';
									}
									$TotalDiscount=$Offeramount+$MembershipAmt;
									$DisAmt="Select Sum(Amount)as DiscountAmt from tblGiftVouchers where Date(RedempedDateTime)>='$First' and Date(RedempedDateTime)<='$Last'";
									// echo $DisAmt."<br><br><br><br>";									
								}
							}
$DB->close();
?>	
						<button class="btn btn-lg" data-toggle="modal" data-target="#myModal" style="background: #a7c3d1;border-color: #a7c3d1;color:#fff;">Rs. <?=$Offeramount?>/-</button>	
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							   <div class="modal-dialog">
								   <div class="modal-content">
									   <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										   
									   <div class="modal-body">
										   <p>

										   </p>
										 
									   </div>
									   <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close Modal</button> </div>
								   </div>
							   </div>
							</div>
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
									<h3 class="title-hero">Monthly Sales</h3>
									<div class="example-box-wrapper">
										<div id="chartdiv"></div>
									</div>
									
								</div>
								
							</div>
						</div>
					</div>
                    
					<div class="col-md-6" style="padding-top: 10px;">
						<div class="panel mrg20T">
							<div class="panel-body">
								<div class="col-md-12">
									<h3 class="title-hero">Test</h3>
									<div class="example-box-wrapper">
										<div id="chartdiv2" style="width: 100%; height: 300px; background-color: #FFFFFF;" ></div>
									</div>
									
								</div>
								
							</div>
						</div>
					</div>
                    <div class="col-md-6" style="padding-top: 10px;">
						<div class="panel mrg20T">
							<div class="panel-body">
								<div class="col-md-12">
									<h3 class="title-hero">Service Category Wise Revenue </h3>
									<div class="example-box-wrapper">
										<div id="chartdiv1"></div>
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
			</div>			
			<div class="panel" style="padding:2%;">
                <div class="row">
					<span id="abc" style="display:none"></span>
					<div class="tile-box col-md-2" style="background: #fc8213;border-color: #fc8213;margin-right:03%; margin-left:1.5%;">
					<div class="panel-content">
					<div style="font-size:14px;"><b>Non Visiting Customers</b></style></div>
					
						<button class="btn btn-lg" data-toggle="modal" data-target="#myModal" style="background: #fc8213;border-color: #fc8213;color:#fff;">144</button>	
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							   <div class="modal-dialog">
								   <div class="modal-content">
									   <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										   
									   <div class="modal-body">
										   <p>

										   </p>
										   
									   </div>
									   <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close Modal</button> </div>
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