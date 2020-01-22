<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	<?php// require_once("incChartScriptEmployeeSale-AUD.fya"); ?>
	<?php require_once("incEmpAttendanceScript-Admin.fya"); ?>
	<?php require_once("incPettyCashScript-Admin.fya"); ?>
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
										window.location = "Audit-Dashboard.php";

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
										window.location = "Audit-Dashboard.php";
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
										window.location = "Audit-Dashboard.php";
									}
									
								  })
						}
                    </script>
                   
					
					
                    <div id="page-title">
                        <h2>Dashboard <?//=$strStore?></h2>
                        <!--<p>The most complete user interface framework that can be used to create stunning admin dashboards and presentation websites.</p>-->


						<?php //require_once("incDayClosing.php"); ?>
									   
									   
									   
                    </div>
                    <div class="row">
				<span id="abc" style="display:none"></span>
				<div class="panel" style="padding:2%;">
					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-3">

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
$DB->close();
?>
								<div class="tile-box tile-box-alt mrg20B bg-green">
                                    
                                        <div class="tile-content-wrapper">
                                            <div class="tile-content"><span><b><small>Gift Voucher Sold in This Month</small></b></span><a href="ViewGiftVoucherSold.php" class="btn btn-lg" style="background: #dc1156;border-color: #dc1156;color:#fff;"><?=$TotalGiftVoucherSolds?></a>	</div><small></small>
											
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
							
							<div class="col-sm-3">
									<div class="tile-box tile-box-alt mrg20B bg-green" style="background: #fc8213;border-color: #fc8213;color:#fff;">
                                     
                                        <div class="tile-content-wrapper">
                                            <div class="tile-content"><span><b><small>Outstanding Payment in This Month</small></b></span><a class="btn btn-lg" href="DisplayOutstandingPaymentAudit.php" style="background: #fc8213;border-color: #fc8213;color:#fff;"><?=$Pending?></a>	</div><small></small>
											
											
												
										</div>
								</div>
							
							</div>
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
									
								/* 	$DisAmt="Select Sum(Amount)as DiscountAmt from tblGiftVouchers where Date(RedempedDateTime)>='$First' and Date(RedempedDateTime)<='$Last'";
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
											echo "Rs. ".$RoundTotal."/-";
										}
									}	 */
									// echo $StoreName." Total Disc is Rs. ".$TotalDisc."<br><br><br>";
									
								}
							}
							
												
?>
							<div class="col-sm-3">
								<div class="tile-box tile-box-alt mrg20B bg-orange">
                                   
                                        <div class="tile-content-wrapper">
                                            <div class="tile-content"><span><b><small></i>Discount Given in This Month</small></b> Rs. </span><a href="DisplayDiscountAudit.php" class="btn btn-lg"  style="background: #77dd77;border-color: #77dd77;color:#fff;"><?=$TotalDiscount?>/-</a></div><small></small>
										
			
						</div>
									</div>
							</div>
<?php							
						$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');
$DB=Connect();

                                       $selectcountmem=select("count(*)","tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$First."') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$Last."') and tblInvoiceDetails.Membership_Amount!='' and tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2'");
										$MembershipSold=$selectcountmem[0]['count(*)'];
										
$DB->close();
?>							
							<div class="col-sm-3">
								<div class="tile-box tile-box-alt mrg20B bg-blue-alt">
									
										<div class="tile-content-wrapper">
											<div class="tile-content"><span><b><small></i>Membership Sold in This Month</small></b></span><?=$MembershipSold?><a href="DisplayMembershipSoldAudit.php" class="btn btn-lg" style="background: #00bcd4;border-color: #00bcd4;color:#fff;"></a></div><b><small></small></i></b>
											

										</div>
								</div>
							</div>
						</div>
					
					
					</div>
				</div>
					
					
					<!-- ROW 2 Start-->
					
					
					<!--<div class="col-md-12">
						<div class="col-sm-8">
							<div class="panel mrg20T">
								<div class="panel-body">
									<h3 class="title-hero">Monthly Sales</h3>
									<div class="example-box-wrapper">
										<div id="chartdiv"></div>
									</div>
								</div>
							</div>
						</div>
					</div>-->
					
					
					
					
					
					<!-- ROW 2 End-->
					
					
					
					
					
					
					
                        
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
									<?php							
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');
$DB=Connect();
                                       $selectcountpetty=select("count(*)","tblExpenses","Date(tblExpenses.DateOfExpense)>=Date('".$First."') and Date(tblExpenses.DateOfExpense)<=Date('".$Last."') order by ExpenseID desc");
										$countpetty=$selectcountpetty[0]['count(*)'];
										
$DB->close();
?>							
						
								<div class="tile-box tile-box-alt mrg20B bg-blue-alt" style="background: #FCD202;border-color: #FCD202; ">
									
										<div class="tile-content-wrapper">
											<div class="tile-content"><span><b><small></i>Petty Cash in This Month</small></b></span><?=$countpetty?></div><b><small></small></i></b>
											<a href="DisplayPettyCashCountAudit.php" class="btn btn-lg" style="background: #FCD202;border-color: #FCD202; ">All Stores</a>	

										</div>
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
				
				
				
					<div class="row">
				<span id="abc" style="display:none"></span>
				<div class="panel" style="padding:2%;">
					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-3" >
							<?php
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');

$DB=Connect();
$ApprovePending="Select (SELECT count(0) FROM `tblAppointments` where Status=2 and IsDeleted!='1' AND ApproveStatus!='1' and AppointmentDate>='$First' and AppointmentDate<='$Last') as ApprovalPendingCount";
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
								
								//echo $ApprovalPendingCount;
							}
$DB->close();	

?>
								<div class="tile-box tile-box-alt mrg20B bg-green" style="background: #A5E6DC;border-color: #A5E6DC;">
                                      
                                        <div class="tile-content-wrapper">
                                            <div class="tile-content"><span><b><small>Reconcilliation Pending in This Month</small></b></span><a class="btn btn-lg" href="PendingBillReconciliationAudit.php" style="background: #A5E6DC;border-color: #A5E6DC;color:#fff;"><?=$ApprovalPendingCount?></a></div><small></small>
											
										</div>
								</div>
							
							
							</div>
<?php
							
$DB=Connect();
	$DB = Connect();
$First= date('Y-m-01');
$Last= date('Y-m-t');
$getfrom=$First;
$getto=$Last;
$sql=selectproduct($getfrom,$getto);
$counter=0;
		foreach($sql as $row)
		{
		$prodcnt=$counter ++;
		}
$DB->close();

?>							
							<div class="col-sm-3">
								<div class="tile-box tile-box-alt mrg20B bg-red" style="background: #8B668B;border-color: #8B668B;">
                                       
                                        <div class="tile-content-wrapper">
                                            <div class="tile-content"><span></span><b><small>Products Used in This Month</small></b><a class="btn btn-lg" href="DisplayProductConsumption.php" style="background: #8B668B;border-color: #8B668B;color:#fff;"><?=$prodcnt?></a>	</div><small></small>
													
										</div>
								</div>
							</div>
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
									// echo "Store " .$StoreName." need Total Products are. ".$ProductAlertCount."<br><br><br>" ;
									
								}
							}
$DB->close();

												
?>
							<div class="col-sm-3">
								<div class="tile-box tile-box-alt mrg20B bg-orange" style="background: #E32E30;border-color: #E32E30;">
                                   
                                        <div class="tile-content-wrapper">
                                            <div class="tile-content"><span><b><small></i>Low stock products in This Month</small></b></span><a class="btn btn-lg" href="DisplayProductAlertAdmin.php" style="background: #E32E30;border-color: #E32E30;color:#fff;"><?=$ProductAlertCount?></a></div><small></small>
										
										
					
						</div>
									</div>
							</div>
<?php							
							
							$DB=Connect();
							
							$First= date('Y-m-01');
							$Last= date('Y-m-t');
							      $sep=select("DISTINCT(tblInvoiceDetails.InvoiceId)","tblInvoiceDetails left join tblAppointments ON  tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","tblAppointments.IsDeleted!='1' and tblAppointments.StoreID!='0' and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$First."') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$Last."') and tblInvoiceDetails.Flag='C'");
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
													$Pendingcard = $ROP["Pending"];
													if($Pendingcard=="")
													{
														$Pendingcard='0';
													}
												}
											}
								 }
							
?>							
							<div class="col-sm-3">
								<div class="tile-box tile-box-alt mrg20B bg-blue-alt" style="background: #3B4990;border-color: #3B4990;">
										
										<div class="tile-content-wrapper">
											<div class="tile-content"><span><b><small></i>Reconciliation Pending C/C in This Month</small></b></span><a class="btn btn-lg" href="DisplayPendingCardReconciliationaudit.php" style="background: #3B4990;border-color: #3B4990;color:#fff;"><?=$Pendingcard?></a></div><b><small></small></i></b>
											
										</div>
								</div>
							</div>
						</div>
					
					
					</div>
				</div>
					
					
					<!-- ROW 2 Start-->
					
					
					<!--<div class="col-md-12">
						<div class="col-sm-8">
							<div class="panel mrg20T">
								<div class="panel-body">
									<h3 class="title-hero">Monthly Sales</h3>
									<div class="example-box-wrapper">
										<div id="chartdiv"></div>
									</div>
								</div>
							</div>
						</div>
					</div>-->
					
					
					
					
					
					<!-- ROW 2 End-->
					
					
					
					
					
					
					
                        
                    </div>
                </div>
            </div>
        </div>
		
		<?php require_once 'incFooter.fya'; ?>
 
    </div>
</body>

</html>