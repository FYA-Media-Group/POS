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
	
	$strPageTitle = "";
	$strDisplayTitle = "";
	$strMenuID = "2";
	$strMyTable = "";
	$strMyTableID = "";
	$strMyField = "";
	$strMyActionPage = "Dashboard.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
	$Type_pie = $_POST["Type_pie"];	
	$Type_bar = $_POST["Type_bar"];	
	
    if($Type_pie=='3')
	{
		require_once("incpiechartcustomerretention.fya"); 
	
	}
	elseif($Type_pie=='2')
	{
		require_once("incpiechart.fya"); 
	}
	elseif($Type_pie=='1')
	{
		
	}
	
	if($Type_bar=='11')
	{
		require_once("incChartsMetaScript.fya"); 
	}
	
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?php //require_once("incMetaScript.fya"); ?>
	<?php //require_once("incChartsMetaScript.fya"); ?>
    <?php //require_once("incpiechart.fya"); ?>
	<?php //require_once("incpiechartcustomerretention.fya"); ?>
	<?php //require_once("incmetabarservicechart.fya"); ?>
	<?php //require_once("IncBestEmployee.fya"); ?>

	<script type="text/javascript" src="assets/widgets/charts/chart-js/chart-doughnut.js"></script>
	<script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
	<script type="text/javascript" src="https://www.amcharts.com/lib/3/themes/patterns.js"></script>
    <style>
    	.btn-danger:hover{
			border-color: #FC8213;
			background: #Fc8213;
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
							
						$("#viewmonthly").click(function()
						{
							window.location="ViewTargetBarChart.php";
							
						});
						$("#viewsercat").click(function()
						{
							window.location="ViewServiceCatRevenue.php";
							
						});
						$("#viewcust").click(function()
						{
							window.location="ViewCustomerReten.php";
							
						});
						$("#viewserall").click(function()
						{
							window.location="ViewServiceAllRevenue.php";
							
						});
						$("#viewempper").click(function()
						{
							window.location="ViewEmployeePerformanceAll.php";
							
						});
						$("#refreshser").click(function()
						{
							
							window.location="CronServiceRevenue.php";
							//window.location="CronServiceRevenueStore.php";
							//window.location="CronServiceRevenueStore.php";
							
							
						});
						$("#refreshsercat").click(function()
						{
							
							window.location="CronServiceCatPie.php";
							//window.location="CronServiceRevenueStore.php";
							//window.location="CronServiceRevenueStore.php";
							
							
						});
							$("#refreshemp").click(function()
						{
							
							window.location="CronBestPerformanceEmployee.php";
							//window.location="CronServiceRevenueStore.php";
							//window.location="CronServiceRevenueStore.php";
							
							
						});
						
						$("#refreshserstore").click(function()
						{
							
							window.location="CronServiceRevenueStore.php";
							//window.location="CronServiceRevenueStore.php";
							//window.location="CronServiceRevenueStore.php";
							
							
						});
						/* 	
							$("#checkgraphduration").onChange(function(){
								var grpdur=$(this).val();
								alert(grpdur)
						     }); */
							
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
						
						function checktypeofpie(evt)
						{
							var typeie=$(evt).val();
							if(typeie=='3')
							{
								$.ajax({
									type:"post",
									data:"typepie="+typeie,
									url:"incpiechartcustomerretention.fya",
									success:function(resultdata)
									{
									
										$("#chartdiv1").html(resultdata)
										
							//	alert(result);
									
									}
									
									
								});
							}
						}
						function checktypeofbar(evt)
						{
							var typeie=$(evt).val();
							if(typeie!='0')
							{
								$.ajax({
									type:"post",
									data:"typepie="+typeie,
									url:"checktypeofbar.php",
									success:function(resultdata)
									{

									//alert(resultdata)
									$("#chartdiv").val(resultdata)
										
							//	alert(result);
									
									}
									
									
								});
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
										window.location = "Dashboard.php";

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
										window.location = "Dashboard.php";
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
										window.location = "Dashboard.php";
									}
									
								  })
						}
						function updatevalues(evt)
						{
							
							 var cust=$(evt).closest('td').prev().prev().prev().prev().find('input').val();
							//alert(ordid)
								var remark=$(evt).closest('td').prev().prev().html();
							
							
							
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
					<!--1st Block-->
					<div class="col-md-3">
						<a href="DisplayNonCustomerCount.php" title="" class="tile-box tile-box-shortcut btn-danger" style="background: #50b7b6; border-color: #50b7b6;"><span class="bs-badge badge-absolute">
<?php									
//DisplayNonCustomerRemarks.php
	$DB = Connect();
///////////////////////////////////////////////////khar///////////////////////////////////////////////////////////////////
										$ct2=0;
	$n5_daysAgoyu = date('Y-m-d', strtotime('-60 days', time()));
	$todaydate=date('Y-m-d');
										  $stqy=select("distinct(CustomerID)","tblAppointments","StoreID='2' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgoyu."'");
											
											foreach($stqy as $vatq)
											{
												$CU2[]=$vatq['CustomerID'];
											}
									
											$selpqtyPq=select("count(AppointmentID) as cntremark","tblCustomerRemarks","StoreID='2' and NonCommentType!='0'");
										    $cntremark2=$selpqtyPq[0]['cntremark'];
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
											$Productst="Select distinct(CustomerID) from tblAppointments WHERE StoreID='2' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01'";
										
											$stqytq=select("distinct(CustomerID)","tblAppointments","StoreID='2' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01' and NonCustomerCommentType!='0' and NonCustomerRemark!=''");
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
										
										
										
										foreach($stqytq as $vatqq)
											{
												$CUP2[]=$vatqq['CustomerID'];
											}
									
										//echo $Productst;
											$RSaT = $DB->query($Productst);
										if ($RSaT->num_rows > 0) 
										{
											while($rowa = $RSaT->fetch_assoc())
											{
									           $Customer=$rowa['CustomerID'];
									
											if(in_array("$Customer",$CU2))
											{
												
											}
											else
											{
												if(in_array("$Customer",$CUP2))
												{
													
												}
												else
												{
												$ct2++;
												}
												
											}
											
											}
									
							
								
										}
										else
										{
											$ct2=0;
										}
	///////////////////////////////////////////////////////colaba//////////////////////////////////////////////
											$ct1=0;
	$n5_daysAgoyu = date('Y-m-d', strtotime('-60 days', time()));
	$todaydate=date('Y-m-d');
										  $stqy=select("distinct(CustomerID)","tblAppointments","StoreID='1' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgoyu."'");
											
											foreach($stqy as $vatq)
											{
												$CU1[]=$vatq['CustomerID'];
											}
											
											  $selpqtyPq=select("count(AppointmentID) as cntremark","tblCustomerRemarks","StoreID='1' and NonCommentType!='0'");
										    $cntremark1=$selpqtyPq[0]['cntremark'];
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
												$Productst="Select distinct(CustomerID) from tblAppointments WHERE StoreID='1' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01'";
										
											$stqytq=select("distinct(CustomerID)","tblAppointments","StoreID='1' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01' and NonCustomerCommentType!='0' and NonCustomerRemark!=''");
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
										
										
										foreach($stqytq as $vatqq)
											{
												$CUP1[]=$vatqq['CustomerID'];
											}
										
										//echo $Productst;
											$RSaT = $DB->query($Productst);
										if ($RSaT->num_rows > 0) 
										{
											while($rowa = $RSaT->fetch_assoc())
											{
									           $Customer=$rowa['CustomerID'];
									
											if(in_array("$Customer",$CU1))
											{
												
											}
											else
											{
												if(in_array("$Customer",$CUP1))
												{
													
												}
												else
												{
												$ct1++;
												}
												
											}
											
											}
										
							
								
										}
										else
										{
											$ct1=0;
										}
								
	////////////////////////////////////////////////////////////////breachcandy////////////////////////////////////////////////////////////////////
			$ct3=0;
	$n5_daysAgoyu = date('Y-m-d', strtotime('-60 days', time()));
	$todaydate=date('Y-m-d');
										  $stqy=select("distinct(CustomerID)","tblAppointments","StoreID='3' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgoyu."'");
											
											foreach($stqy as $vatq)
											{
												$CU3[]=$vatq['CustomerID'];
											}
										
												
											  
											   $selpqtyPq=select("count(AppointmentID) as cntremark","tblCustomerRemarks","StoreID='3' and NonCommentType!='0'");
										    $cntremark3=$selpqtyPq[0]['cntremark'];
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
												$Productst="Select distinct(CustomerID) from tblAppointments WHERE StoreID='3' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01'";
										
											$stqytq=select("distinct(CustomerID)","tblAppointments","StoreID='3' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01' and NonCustomerCommentType!='0' and NonCustomerRemark!=''");
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
										
										
										
										foreach($stqytq as $vatqq)
											{
												$CUP3[]=$vatqq['CustomerID'];
											}
										
										//echo $Productst;
											$RSaT = $DB->query($Productst);
										if ($RSaT->num_rows > 0) 
										{
											while($rowa = $RSaT->fetch_assoc())
											{
									           $Customer=$rowa['CustomerID'];
									
											if(in_array("$Customer",$CU3))
											{
												
											}
											else
											{
												if(in_array("$Customer",$CUP3))
												{
													
												}
												else
												{
												$ct3++;
												}
												
											}
											
											}
										
							
								
										}
										else
										{
											$ct3=0;
										}
/////////////////////////////////////////////////////////////lokhandwala//////////////////////////////////////////////
	$ct5=0;
	$n5_daysAgoyu = date('Y-m-d', strtotime('-60 days', time()));
	$todaydate=date('Y-m-d');
										  $stqy=select("distinct(CustomerID)","tblAppointments","StoreID='5' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgoyu."'");
											
											foreach($stqy as $vatq)
											{
												$CU5[]=$vatq['CustomerID'];
											}
									
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
												$Productst="Select distinct(CustomerID) from tblAppointments WHERE StoreID='5' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01'";
											$stqytqcnt=select("count(CustomerID) as cntremark","tblAppointments","StoreID='5' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01' and NonCustomerCommentType!='0'");
										      $cntremark5=$stqytqcnt[0]['cntremark'];
									
											$stqytq=select("distinct(CustomerID)","tblAppointments","StoreID='5' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01' and NonCustomerCommentType!='0' and NonCustomerRemark!=''");
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
										
										
										
										foreach($stqytq as $vatqq)
											{
												$CUP5[]=$vatqq['CustomerID'];
											}
										
										//echo $Productst;
											$RSaT = $DB->query($Productst);
										if ($RSaT->num_rows > 0) 
										{
											while($rowa = $RSaT->fetch_assoc())
											{
									           $Customer=$rowa['CustomerID'];
									
											if(in_array("$Customer",$CU5))
											{
												
											}
											else
											{
												if(in_array("$Customer",$CUP5))
												{
													
												}
												else
												{
												$ct5++;
												}
												
											}
											
											}
									
							
								
										}
										else
										{
											$ct5=0;
										}
										//////////////////////////////oshiwara/////////////////////////////////////////
											$ct4=0;
	$n5_daysAgoyu = date('Y-m-d', strtotime('-60 days', time()));
	$todaydate=date('Y-m-d');
										  $stqy=select("distinct(CustomerID)","tblAppointments","StoreID='4' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgoyu."'");
											
											foreach($stqy as $vatq)
											{
												$CU4[]=$vatq['CustomerID'];
											}
									
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
												$Productst="Select distinct(CustomerID) from tblAppointments WHERE StoreID='4' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01'";
										
									
											$stqytq=select("distinct(CustomerID)","tblAppointments","StoreID='4' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01' and NonCustomerCommentType!='0' and NonCustomerRemark!=''");
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
										
										$stqytqcnt=select("count(CustomerID) as cntremark","tblAppointments","StoreID='4' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01' and NonCustomerCommentType!='0'");
										$cntremark4=$stqytqcnt[0]['cntremark'];
										
										
										foreach($stqytq as $vatqq)
											{
												$CUP4[]=$vatqq['CustomerID'];
											}
										
										//echo $Productst;
											$RSaT = $DB->query($Productst);
										if ($RSaT->num_rows > 0) 
										{
											while($rowa = $RSaT->fetch_assoc())
											{
									           $Customer=$rowa['CustomerID'];
									
											if(in_array("$Customer",$CU4))
											{
												
											}
											else
											{
												if(in_array("$Customer",$CUP4))
												{
													
												}
												else
												{
													
										
												$ct4++;
												}
												
											}
											
											}
									
							
								
										}
										else
										{
											$ct4=0;
										}
										///////////////////////////////////////////////////////////////////////
									
										$ctt=$ct5+$ct1+$ct2+$ct3+$ct4; 
										$cntremark=$cntremark4+$cntremark5+$cntremark3+$cntremark2+$cntremark1; 
										echo $ctt."/".$cntremark;
										$DB->close();
										$ctt="";
										$cntremark="";
?>	
										</span><div class="tile-header">NON Visiting Customers</div><div class="tile-content-wrapper"><i class=""></i></div></a>
					</div>
				<!--End 1st Block-->
				
				
				<!--2nd Block-->
					<div class="col-md-3">
						<a href="" title="" class="tile-box tile-box-shortcut btn-danger" style="background: #dc1156; border-color: #dc1156;"><span class="bs-badge badge-absolute">
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
												// echo "In else";
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
													if($TodalSales=="")
													{
														$TodalSales=0;
													}
													echo "Rs. ".$TodalSales;
												}
											}
?>
										</span><div class="tile-header">Today's Total Sales</div><div class="tile-content-wrapper"><i class=""></i></div></a>
					</div>
				<!--End 2nd Block-->
				<!--3rd Block-->
					<div class="col-md-3">
						<a href="" title="" class="tile-box tile-box-shortcut btn-danger" style="background: #808080; border-color: #808080;" id="ModalOpenBtn" data-toggle="modal" data-target="#myModalstock"><span class="bs-badge badge-absolute">
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
											$PendingAmount="Select SUM(tblPendingPayments.PendingAmount)as Pending,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblPendingPayments.PendingStatus=2 and tblAppointments.StoreID!='0'";
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
										echo "Rs. ".$PendingTotal;
										$DB->close();	
?>
										</span><div class="tile-header">Total Amount Pending</div><div class="tile-content-wrapper"><i class=""></i></div></a>
										
											<div class="modal fade" id="myModalstock" role="dialog">
																<div class="modal-dialog modal-dialog modal-lg">
																
																  <!-- Modal content-->
																	<div class="modal-content">
																	
																		<div class="modal-body">
																			   <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example" width="80%">
																			    <thead>
																				  <tr><th>Customer Name</th><th>Mobile</th><th>AppointmentDate</th><th>Invoice</th><th>Pending Amount</th></tr>
																				   </thead>
																				    <tbody>
																		<?php
                                                       $DB = Connect();
								              
												$Productst="Select tblPendingPayments.PendingAmount as Pending,tblPendingPayments.CustomerID,tblPendingPayments.InvoiceID,tblPendingPayments.AppointmentID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID Left Join tblInvoiceDetails ON  tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.IsDeleted!='1' and tblAppointments.StoreID!='0' and tblPendingPayments.PendingStatus='2'";
								
										
										//echo $Productst;
											$RSaT = $DB->query($Productst);
										if ($RSaT->num_rows > 0) 
										{
											while($rowa = $RSaT->fetch_assoc())
											{
												
												$CustomerID = $rowa["CustomerID"];
												$AppointmentID = $rowa["AppointmentID"];
												$InvoiceID = $rowa["InvoiceID"];
											    
												$PendingAmount = $rowa["Pending"];
												$TotalgAmount += $PendingAmount;
												$sqqtm=select("*","tblCustomers","CustomerFullName='".$CustomerID."'");
												$customerfullname=$sqqtm[0]['CustomerFullName'];
												$CustomerMobileNo=$sqqtm[0]['CustomerMobileNo'];
												$sqqtmp=select("*","tblAppointments","AppointmentID='".$AppointmentID."'");
												$AppointmentDate=$sqqtmp[0]['AppointmentDate'];
												
												
												
											
											   ?>
											<tr><td><?=$CustomerID?></td><td><?=$CustomerMobileNo?></td><td><?=$AppointmentDate?></td><td><?=$InvoiceID?></td><td><?="Rs. ".$PendingAmount?></td></tr>
											  
											  
											   <?php
												
											}
										}
                                                                        ?>																		
																				
																				
																		
																				
												 </tbody>
												 <tbody><td></td><td></td><td></td><td></td><td><?=$TotalgAmount?></td></tbody>
																		 </table>
																		</div>
																		<div class="modal-footer">
																		  <button type="button" class="btn ra-100 btn-primary" data-dismiss="modal">Close</button>
																		</div>
																	</div>
																  
																</div>
															</div>
					</div>
				<!--End 3rd Block-->
				
				
				<!--4th Block-->
					<div class="col-md-3">
						<a href="DisplayServiceReminderCount.php" title="" class="tile-box tile-box-shortcut btn-danger" style="background: #2e689a; border-color: #2e689a;" ><span class="bs-badge badge-absolute">
 <?php								
										/*$date=date('y-m-d');
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
										$membershipamount="SELECT count(memberid) as TodaysMembership FROM `tblCustomers` where    Date(MembershipDateTime)>=Date('$First') and Date(MembershipDateTime)<=Date('$Last') ";
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
												echo $totalM;
													$DB->close();
													*/
													
						///////////////////////////////////////////////////khar///////////////////////////////////////////////////////////////////
										$ct6=0;
	$n5_daysAgoyu = date('Y-m-d', strtotime('-25 days', time()));
	$todaydate=date('Y-m-d');
										  $stqy=select("distinct(CustomerID)","tblAppointments","StoreID='2' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgoyu."'");
											
											foreach($stqy as $vatq)
											{
												$CU6[]=$vatq['CustomerID'];
											}
								
										
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
											$Productst="Select distinct(CustomerID) from tblAppointments WHERE StoreID='2' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01'";
										
											$stqytq=select("distinct(CustomerID)","tblAppointments","StoreID='2' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01' and CommentType!='0' and CustomerRemark!=''");
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
										
											
										$selpqtyPq=select("count(AppointmentID) as cntremark","tblCustomerRemarks","StoreID='2' and CommentType!='0'");
										$cntremark6=$selpqtyPq[0]['cntremark'];
										foreach($stqytq as $vatqq)
											{
												$CUP6[]=$vatqq['CustomerID'];
											}
								
										//echo $Productst;
											$RSaT = $DB->query($Productst);
										if ($RSaT->num_rows > 0) 
										{
											while($rowa = $RSaT->fetch_assoc())
											{
									           $Customer=$rowa['CustomerID'];
									
											if(in_array("$Customer",$CU6))
											{
												
											}
											else
											{
												if(in_array("$Customer",$CUP6))
												{
													
												}
												else
												{
												$ct6++;
												}
												
											}
											
											}
									
							
								
										}
										else
										{
											$ct6=0;
										}
	///////////////////////////////////////////////////////colaba//////////////////////////////////////////////
											$ct7=0;
	$n5_daysAgoyu = date('Y-m-d', strtotime('-25 days', time()));
	$todaydate=date('Y-m-d');
										  $stqy=select("distinct(CustomerID)","tblAppointments","StoreID='1' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgoyu."'");
											
											foreach($stqy as $vatq)
											{
												$CU7[]=$vatq['CustomerID'];
											}
									
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
												$Productst="Select distinct(CustomerID) from tblAppointments WHERE StoreID='1' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01'";
										
											$stqytq=select("distinct(CustomerID)","tblAppointments","StoreID='1' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01' and CommentType!='0' and CustomerRemark!=''");
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
									
										$selpqtyPq=select("count(AppointmentID) as cntremark","tblCustomerRemarks","StoreID='1' and CommentType!='0'");
										$cntremark7=$selpqtyPq[0]['cntremark'];
										foreach($stqytq as $vatqq)
											{
												$CUP7[]=$vatqq['CustomerID'];
											}
										
										//echo $Productst;
											$RSaT = $DB->query($Productst);
										if ($RSaT->num_rows > 0) 
										{
											while($rowa = $RSaT->fetch_assoc())
											{
									           $Customer=$rowa['CustomerID'];
									
											if(in_array("$Customer",$CU7))
											{
												
											}
											else
											{
												if(in_array("$Customer",$CUP7))
												{
													
												}
												else
												{
												$ct7++;
												}
												
											}
											
											}
										
							
								
										}
										else
										{
											$ct7=0;
										}
	////////////////////////////////////////////////////////////////breachcandy////////////////////////////////////////////////////////////////////
			$ct8=0;
	$n5_daysAgoyu = date('Y-m-d', strtotime('-25 days', time()));
	$todaydate=date('Y-m-d');
										  $stqy=select("distinct(CustomerID)","tblAppointments","StoreID='3' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgoyu."'");
											
											foreach($stqy as $vatq)
											{
												$CU8[]=$vatq['CustomerID'];
											}
										
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
												$Productst="Select distinct(CustomerID) from tblAppointments WHERE StoreID='3' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01'";
										
											$stqytq=select("distinct(CustomerID)","tblAppointments","StoreID='3' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01' and CommentType!='0' and CustomerRemark!=''");
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
											$selpqtyPq=select("count(AppointmentID) as cntremark","tblCustomerRemarks","StoreID='3' and CommentType!='0'");
										$cntremark8=$selpqtyPq[0]['cntremark'];
										
										
										
										foreach($stqytq as $vatqq)
											{
												$CUP8[]=$vatqq['CustomerID'];
											}
										
										//echo $Productst;
											$RSaT = $DB->query($Productst);
										if ($RSaT->num_rows > 0) 
										{
											while($rowa = $RSaT->fetch_assoc())
											{
									           $Customer=$rowa['CustomerID'];
									
											if(in_array("$Customer",$CU8))
											{
												
											}
											else
											{
												if(in_array("$Customer",$CUP8))
												{
													
												}
												else
												{
												$ct8++;
												}
												
											}
											
											}
										
							
								
										}
										else
										{
											$ct8=0;
										}
/////////////////////////////////////////////////////////////lokhandwala//////////////////////////////////////////////
	$ct9=0;
	$n5_daysAgoyu = date('Y-m-d', strtotime('-25 days', time()));
	$todaydate=date('Y-m-d');
										  $stqy=select("distinct(CustomerID)","tblAppointments","StoreID='5' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgoyu."'");
											
											foreach($stqy as $vatq)
											{
												$CU9[]=$vatq['CustomerID'];
											}
									
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
												$Productst="Select distinct(CustomerID) from tblAppointments WHERE StoreID='5' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01'";
										
									
											$stqytq=select("distinct(CustomerID)","tblAppointments","StoreID='5' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01' and CommentType!='0' and CustomerRemark!=''");
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
									
											$selpqtyPq=select("count(AppointmentID) as cntremark","tblCustomerRemarks","StoreID='5' and CommentType!='0'");
										$cntremark9=$selpqtyPq[0]['cntremark'];
										
										foreach($stqytq as $vatqq)
											{
												$CUP9[]=$vatqq['CustomerID'];
											}
										
										//echo $Productst;
											$RSaT = $DB->query($Productst);
										if ($RSaT->num_rows > 0) 
										{
											while($rowa = $RSaT->fetch_assoc())
											{
									           $Customer=$rowa['CustomerID'];
									
											if(in_array("$Customer",$CU9))
											{
												
											}
											else
											{
												if(in_array("$Customer",$CUP9))
												{
													
												}
												else
												{
												$ct9++;
												}
												
											}
											
											}
									
							
								
										}
										else
										{
											$ct9=0;
										}
										//////////////////////////////oshiwara/////////////////////////////////////////
											$ct10=0;
	$n5_daysAgoyu = date('Y-m-d', strtotime('-25 days', time()));
	$todaydate=date('Y-m-d');
										  $stqy=select("distinct(CustomerID)","tblAppointments","StoreID='4' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgoyu."'");
											
											foreach($stqy as $vatq)
											{
												$CU10[]=$vatq['CustomerID'];
											}
									
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
												$Productst="Select distinct(CustomerID) from tblAppointments WHERE StoreID='4' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01'";
										
									
											$stqytq=select("distinct(CustomerID)","tblAppointments","StoreID='4' and AppointmentDate<='".$n5_daysAgoyu."' and AppointmentDate>='2017-02-01' and CommentType!='0' and CustomerRemark!=''");
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
										
										
										$selpqtyPq=select("count(AppointmentID) as cntremark","tblCustomerRemarks","StoreID='4' and CommentType!='0'");
										$cntremark10=$selpqtyPq[0]['cntremark'];
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
										
										
										foreach($stqytq as $vatqq)
											{
												$CUP10[]=$vatqq['CustomerID'];
											}
										
										//echo $Productst;
											$RSaT = $DB->query($Productst);
										if ($RSaT->num_rows > 0) 
										{
											while($rowa = $RSaT->fetch_assoc())
											{
									           $Customer=$rowa['CustomerID'];
									
											if(in_array("$Customer",$CU10))
											{
												
											}
											else
											{
												if(in_array("$Customer",$CUP10))
												{
													
												}
												else
												{
													
										
												$ct10++;
												}
												
											}
											
											}
									
							
								
										}
										else
										{
											$ct10=0;
										}
										///////////////////////////////////////////////////////////////////////
									
										$cttP=$ct6+$ct7+$ct8+$ct9+$ct10; 
										$cntremarks=$cntremark6+$cntremark7+$cntremark8+$cntremark9+$cntremark10; 
										echo $cttP."/".$cntremarks;
										$DB->close();
										$cttP="";
										$cntremarks="";
	
										
										
$DB->close();
?>

										</span>
										<div class="tile-header">Service Reminder</div><div class="tile-content-wrapper"><i class=""></i></div></a>
										 	<div class="modal fade" id="myModalcust" role="dialog">
																<div class="modal-dialog">
																
																  <!-- Modal content-->
																	<div class="modal-content">
																	
																		<div class="modal-body">
																			   <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
																			    <thead>
																				  <tr><th>Customer</th><th>Mobile</th><th>Non Visting Remark</th><th>Store</th></tr>
																				   </thead>
																				    <tbody>
																		<?php
                                                                  $DB = Connect();
											$n5_daysAgot = date('Y-m-d', strtotime('-25 days', time()));
										  $todaydate=date('Y-m-d');
										  $stqy=select("distinct(CustomerID)","tblAppointments","StoreID!='0' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgot."'");
											
											foreach($stqy as $vatq)
											{
												$CU[]=$vatq['CustomerID'];
											}
									
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
											$Productst="Select distinct(tblCustomers.CustomerID),tblAppointments.StoreID from tblCustomers Left Join tblAppointments ON tblCustomers.CustomerID=tblAppointments.CustomerID WHERE tblAppointments.StoreID!='0' and tblAppointments.AppointmentDate<='".$n5_daysAgot."' and tblAppointments.AppointmentDate>='2017-02-01'";
										
									
										//echo $Productst;
											$RSaT = $DB->query($Productst);
										if ($RSaT->num_rows > 0) 
										{
											while($rowa = $RSaT->fetch_assoc())
											{
									           $Customer=$rowa['CustomerID'];
									           $StoreID=$rowa['StoreID'];
											
											if(in_array("$Customer",$CU))
											{
												
											}
											else
											{
												
												$selpqtyP=select("*","tblCustomers","CustomerID='".$Customer."'");
												$customerfullname=$selpqtyP[0]['CustomerFullName'];
												    $CustomerMobileNo=$selpqtyP[0]['CustomerMobileNo'];
												    $NonCustomerRemark=$selpqtyP[0]['NonCustomerRemark'];
													
											$selpqtyPTY=select("*","tblStores","StoreID='".$StoreID."'");
											$storenaem=$selpqtyPTY[0]['StoreName'];
													 ?>
											<tr><td><input type="hidden" id="cust_id"  value="<?=$Customer?>" /><?=$customerfullname?></td><td><?=$CustomerMobileNo?></td><td contenteditable='true' id="remark" ><?=$NonCustomerRemark?></td><td><?=$storenaem?></td></tr>
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
				<!--End 4th Block-->
				
				<!--5th Block-->
	
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
                                       <h3 class="title-hero">Target Wise Monthly Sale <?="( ".$FromDatee." To ".$ToDatee." )"?></h3>&nbsp;&nbsp;<input type="button" id="viewmonthly" class="btn ra-100 btn-primary" value="View All">	<div class="example-box-wrapper">
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
									<h3 class="title-hero">Monthly Service Wise Revenue <?="( ".$FromDatee." To ".$ToDatee." )"?></h3>&nbsp;&nbsp;<input type="button" id="viewserall" class="btn ra-100 btn-primary" value="View All">
									<div class="example-box-wrapper">
								
										<div id="chartdiv2"></div>
									
									</div>
								</div>
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
									<h3 class="title-hero">Best Performing Employee <?="( ".$FromDatee." To ".$ToDatee." )"?></h3>&nbsp;&nbsp;<input type="button" id="viewempper" class="btn ra-100 btn-primary" value="View All">
									<div class="example-box-wrapper">
									
										<div id="chartdivbestemp"></div>
									</div>
								</div>
							
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
									<h3 class="title-hero">Monthly Service Category Wise Revenue <?="( ".$FromDatee." To ".$ToDatee." )"?> </h3>&nbsp;&nbsp;<input type="button" id="viewsercat" class="btn ra-100 btn-primary" value="View All">
									<div class="example-box-wrapper">
									
										<div id="chartdiv1"></div>
									</div>
								</div>
								<div class="col-md-12">
									<h3 class="title-hero">Monthly Customer Retention Analysis <?="( ".$FromDatee." To ".$ToDatee." )"?></h3>&nbsp;&nbsp;<input type="button" id="viewcust" class="btn ra-100 btn-primary" value="View All">
									<div class="example-box-wrapper">
									
										<div id="chartdiv3"></div>
									</div>
								</div>
							
							</div>
						</div>
					</div>
				</div>
			<div class="panel" style="padding:2%;">
                <div class="row">
					<span id="abc" style="display:none"></span>
					<div class="col-md-2">
						<a href="DisplayNewClients.php" title="" class="tile-box tile-box-shortcut btn-danger" ><span class="bs-badge badge-absolute">
<?php
	$First= date('Y-m-01');
	$Last= date('Y-m-t');
	$date=date('Y-m-d');
	$getfrom=$First;
	$getto=$Last;
	$DB=Connect();
	
	
	
	   		  $sqldetailsd=newcustomercountallstore($getfrom,$getto,1);
			/*  $sqldetailsd=select("DISTINCT(tblAppointments.AppointmentID)","tblCustomers LEFT JOIN tblAppointments ON tblCustomers.CustomerID = tblAppointments.CustomerID LEFT JOIN tblAppointmentAssignEmployee ON tblAppointments.AppointmentID = tblAppointmentAssignEmployee.AppointmentID","tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService != '1' AND tblAppointments.Status =  '2' AND tblAppointmentAssignEmployee.MECID = '".$EID."' $sqlTempfrom1 $sqlTempto1"); */
			 foreach($sqldetailsd as $vat)
		    {
			$app[]=$vat['AppointmentID'];
			$custcnt=count($app);
			if($custcnt=='' || $custcnt=='0')
			{
				$custcnt=0;
			}
		    }
		   unset($app);
		   
		    $sqldetailsd=newcustomercountallstore($getfrom,$getto,2);
			/*  $sqldetailsd=select("DISTINCT(tblAppointments.AppointmentID)","tblCustomers LEFT JOIN tblAppointments ON tblCustomers.CustomerID = tblAppointments.CustomerID LEFT JOIN tblAppointmentAssignEmployee ON tblAppointments.AppointmentID = tblAppointmentAssignEmployee.AppointmentID","tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService != '1' AND tblAppointments.Status =  '2' AND tblAppointmentAssignEmployee.MECID = '".$EID."' $sqlTempfrom1 $sqlTempto1"); */
			 foreach($sqldetailsd as $vat)
		    {
			$app[]=$vat['AppointmentID'];
			$custcnt2=count($app);
			if($custcnt2=='' || $custcnt2=='0')
			{
				$custcnt2=0;
			}
		    }
		   unset($app);
		   
		     $sqldetailsd=newcustomercountallstore($getfrom,$getto,3);
			/*  $sqldetailsd=select("DISTINCT(tblAppointments.AppointmentID)","tblCustomers LEFT JOIN tblAppointments ON tblCustomers.CustomerID = tblAppointments.CustomerID LEFT JOIN tblAppointmentAssignEmployee ON tblAppointments.AppointmentID = tblAppointmentAssignEmployee.AppointmentID","tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService != '1' AND tblAppointments.Status =  '2' AND tblAppointmentAssignEmployee.MECID = '".$EID."' $sqlTempfrom1 $sqlTempto1"); */
			 foreach($sqldetailsd as $vat)
		    {
			$app[]=$vat['AppointmentID'];
			$custcnt3=count($app);
			if($custcnt3=='' || $custcnt3=='0')
			{
				$custcnt3=0;
			}
		    }
		   unset($app);
		     $sqldetailsd=newcustomercountallstore($getfrom,$getto,4);
			/*  $sqldetailsd=select("DISTINCT(tblAppointments.AppointmentID)","tblCustomers LEFT JOIN tblAppointments ON tblCustomers.CustomerID = tblAppointments.CustomerID LEFT JOIN tblAppointmentAssignEmployee ON tblAppointments.AppointmentID = tblAppointmentAssignEmployee.AppointmentID","tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService != '1' AND tblAppointments.Status =  '2' AND tblAppointmentAssignEmployee.MECID = '".$EID."' $sqlTempfrom1 $sqlTempto1"); */
			 foreach($sqldetailsd as $vat)
		    {
			$app[]=$vat['AppointmentID'];
			$custcnt4=count($app);
			if($custcnt4=='' || $custcnt4=='0')
			{
				$custcnt4=0;
			}
		    }
		   unset($app);
		     $sqldetailsd=newcustomercountallstore($getfrom,$getto,5);
			/*  $sqldetailsd=select("DISTINCT(tblAppointments.AppointmentID)","tblCustomers LEFT JOIN tblAppointments ON tblCustomers.CustomerID = tblAppointments.CustomerID LEFT JOIN tblAppointmentAssignEmployee ON tblAppointments.AppointmentID = tblAppointmentAssignEmployee.AppointmentID","tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService != '1' AND tblAppointments.Status =  '2' AND tblAppointmentAssignEmployee.MECID = '".$EID."' $sqlTempfrom1 $sqlTempto1"); */
			 foreach($sqldetailsd as $vat)
		    {
			$app[]=$vat['AppointmentID'];
			$custcnt5=count($app);
			if($custcnt5=='' || $custcnt5=='0')
			{
				$custcnt5=0;
			}
		    }
		   unset($app);
		   $totalneww=$custcnt+$custcnt2+$custcnt3+$custcnt4+$custcnt5;
	
								echo $totalneww;
								$DB->close();
	?>			
										</span><div class="tile-header">New Clients</div><div class="tile-content-wrapper"><i class=""></i></div></a>
										
											
					</div>
					
					
				<div class="col-md-2">
						<a href="DisplayAvgRevenew.php" title="" class="tile-box tile-box-shortcut btn-danger" style="background: #77dd77; border-color: #77dd77;"><span class="bs-badge badge-absolute">
<?php					
					
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');
$DB=Connect();

	                                                           $sqp=select("distinct(StoreID)","tblAppointments","Status='2'");
																	foreach($sqp as $val)
																	{
																		$counter ++;
																		$storrr=$val['StoreID'];
																		$sql="SELECT SUM(tblInvoiceDetails.TotalPayment) as TotalPay, count(tblInvoiceDetails.CustomerID) as TotalCustomers FROM tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='".$storrr."' and Date(OfferDiscountDateTime)>=Date('".$First."') and Date(OfferDiscountDateTime)<=Date('".$Last."')";
																		//echo $sql."<hr>";

																	$RS = $DB->query($sql);
																	if ($RS->num_rows > 0) 
																	{


																		while($row = $RS->fetch_assoc())
																		{
																			
																			    $TotalCustomers = $row["TotalCustomers"];
																				$TotalPayment = $row["TotalPay"];
																				$AverageValue=$TotalPayment/$TotalCustomers;
																				$FibalAverage=Round($AverageValue , 2);
																				$CustomerMobileNo = $row["CustomerMobileNo"];
																				$RegDate = $row["RegDate"];
																				$RegDatet = FormatDateTime($RegDate);
																					
																				$sept=select("StoreName","tblStores","StoreID='".$storrr."'");
																				$StoreName=$sept[0]['StoreName'];
																					if($FibalAverage =="")
																				{
																					$FibalAverage ="0.00";
																				}
																				else
																				{
																					$FibalAverage = $FibalAverage;
																				}

																				$totalFibalAverageyu += $FibalAverage;
																				$FinalCustomers += $TotalCustomers;
																				$TotalFibalAverage = $FinalPayment / $FinalCustomers;
																		}
																	}
																	}
																	if($totalFibalAverageyu=="")
																	{
																		$totalFibalAverageyu=0;
																	}
																	echo Round($totalFibalAverageyu, 2);

$DB->close();
?>
										</span><div class="tile-header">Avg Revenue</div><div class="tile-content-wrapper"><i class=""></i></div></a>
						
					</div>
				<!--3rd Block-->
					<div class="col-md-2">
						<a href="DisplayPRI.php" title="" class="tile-box tile-box-shortcut btn-danger" style="background: #fccc80; border-color: #fccc80;"><span class="bs-badge badge-absolute">
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
						  if($ApprovalPendingCount=="")
							{
								$ApprovalPendingCount=0;
							}
							echo $ApprovalPendingCount;
$DB->close();	
?>
										</span><div class="tile-header">PRI</div><div class="tile-content-wrapper"><i class=""></i></div></a>
	
										
					</div>
				<!--End 3rd Block-->
				
				
				<!--4th Block-->
					<div class="col-md-2">
						<a href="DisplayDiscount.php" title="" class="tile-box tile-box-shortcut btn-danger" style="background: #1296ff; border-color: #1296ff;" ><span class="bs-badge badge-absolute" >
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
									if($TotalDiscount=="")
									{
										$TotalDiscount=0;
									}
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
							
							echo $TotalDiscount;

?>	
										</span><div class="tile-header">Discounts</div><div class="tile-content-wrapper"><i class=""></i></div></a>
										
					
					</div>
				<!--End 4th Block-->
				
				<!--5th Block-->
					<div class="col-md-2">
						<a href="DisplayDiscountOffer.php" title="" class="tile-box tile-box-shortcut btn-danger" style="background: #a7c3d1; border-color: #a7c3d1;"><span class="bs-badge badge-absolute">
<?php		
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');

$DB=Connect();

  $Select="Select distinct(tblAppointments.offerid) from tblAppointments right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$First."') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$Last."')";
		
               
				$RSservice = $DB->query($Select);
				if ($RSservice->num_rows > 0) 
				{
					$counterservice = 0;
				   while($rowservice = $RSservice->fetch_assoc())
					{
					
						$offerid[]=$rowservice['offerid'];		
					    
					}
				}
				for($i=0;$i<count($offerid);$i++)
					{
					$Selectrpt="select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer from tblAppointmentMembershipDiscount right join tblAppointments on tblAppointments.AppointmentID = tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.offerid=tblAppointmentMembershipDiscount.OfferID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$First."') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$Last."')";
					
				    $RSservicetq = $DB->query($Selectrpt);
								if ($RSservicetq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetq = $RSservicetq->fetch_assoc())
									{
									$sumoffer=$rowservicetq['sumoffer'];
									$totalseramtseramt +=$sumoffer;	
									}
								}
					}
				                if($totalseramtseramt=="")
									{
										$totalseramtseramt=0;
									}
	   /*  $Select="Select distinct(tblAppointments.offerid) from tblAppointments right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$First."') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$Last."')";
		$RSservice = $DB->query($Select);
				if ($RSservice->num_rows > 0) 
				{
					$counterservice = 0;
				   while($rowservice = $RSservice->fetch_assoc())
					{
					
						$offerid[]=$rowservice['offerid'];		
					    
					}
				}				
				 */
					/* for($i=0;$i<count($offerid);$i++)
					{
						$Selectrptp="select sum(tblAppointmentMembershipDiscount.OfferAmount) as sumoffer from tblAppointments left join  tblAppointmentMembershipDiscount on tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID AND tblAppointments.offerid=tblAppointmentMembershipDiscount.OfferID right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' and tblAppointments.offerid!='0' and tblAppointmentMembershipDiscount.OfferID='".$offerid[$i]."' and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$First."') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$Last."')";
					
				        $RSservicetqq = $DB->query($Selectrptp);
								if ($RSservicetqq->num_rows > 0) 
								{
									$ty=0;
									while($rowservicetqq = $RSservicetqq->fetch_assoc())
									{
									$seramtseramtt=$rowservicetqq['sumoffer'];
									$totalseramtseramtold=$seramtseramtt;	
									}
								}
					         if($totalseramtseramtold=="")
							 {
								 $totalseramtseramtold=0;
							 }
							 else
							 {
								 $totalseramtseramtold=$totalseramtseramtold;
							 }	
                            $taltotalseramtseramtold += $totalseramtseramtold;	
					} */
						echo round($totalseramtseramt,2);
$DB->close();
?>	
										</span><div class="tile-header">Offer Redempt</div><div class="tile-content-wrapper"><i class=""></i></div></a>
										
					</div>
				<!--End 5th Block-->
				<!--6th Block-->
					<div class="col-md-2">
						<a href="DisplayMembershipOfferSold.php" title="" class="tile-box tile-box-shortcut btn-danger" style="background: #273162; border-color: #273162;"><span class="bs-badge badge-absolute">
<?php									
										$date=date('y-m-d');
										$DB = Connect();
										$selectcountmem=select("count(*)","tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$First."') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$Last."') and tblInvoiceDetails.Membership_Amount!='' and tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2'");
										$cntmem=$selectcountmem[0]['count(*)'];
										
										
										$selectcountoffer=select("count(*)","tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID","Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$First."') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$Last."') and tblInvoiceDetails.OfferAmt!='' and tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2'");
										$cntoffer=$selectcountoffer[0]['count(*)'];
										
									    $totalcnt=$cntmem+$cntoffer;
										if($totalcnt=="")
										{
											$totalcnt=0;
										}
										echo $totalcnt;
										/* $FindStore="Select StoreID from tblAdminStore where AdminID=$strAdminID";
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
										$membershipamount="SELECT count(memberid) as TodaysMembership FROM `tblCustomers` where    Date(MembershipDateTime)>=Date('$First') and Date(MembershipDateTime)<=Date('$Last') ";
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
												echo $totalM; */
												$DB->close();
												
										 $DB->close();
													
?>	
										</span>
										<div class="tile-header">Member + Offer</div>
											<div class="tile-content-wrapper">
												<i class=""></i>
											</div></a>
						</div>
				<!--End 6th Block-->
				
				
		
				
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
			</div>			
			
            
				
				
				
				
				
				
				
				
            </div>
            </div>
        </div>
		
		<?php require_once 'incFooter.fya'; ?>
 
    </div>
</body>

</html>