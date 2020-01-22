<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Customer Details | NailSpa";
	$strDisplayTitle = "Customer Details for NailSpa";
	$strMenuID = "10";
	$strMyTable = "tblAppointments";
	$strMyTableID = "AppointmentID";
	$strMyField = "AppointmentDate";
	$strMyActionPage = "DisplayServiceReminderCount.php";
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
             

				<div class="panel">
						<div class="panel">
							<div class="panel-body">
								
								<div class="example-box-wrapper">
									
							
											
											<div id="normal-tabs-1">
												<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h4 class="title-hero"><center>List of Service Reminder | NailSpa</center></h4>
												
												
												       <script type="text/javascript">
					    $(document).ready(function() {
							
						});
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
						function checkstatus(evt,setid)
						{
							var customer=$(evt).closest('td').prev().prev().find('input').val();
							var checkcommenttype=$(evt).val();
							//alert(checkcommenttype)
							if(checkcommenttype=='5' || checkcommenttype=='6' || checkcommenttype=='7' || checkcommenttype=='9' || checkcommenttype=='2' || checkcommenttype=='3' || checkcommenttype=='4' || checkcommenttype=='8')
							{
								$(evt).closest('td').next().find('textarea').attr("ReadOnly",false);
							}
							else if(checkcommenttype=='1')
							{
								//alert(1234)
								//alert(customer)
								$(evt).closest('td').next().find('textarea').attr("ReadOnly",false);
								$(evt).closest('td').next().next().find('a').attr("href","ManageAppointments.php?bid="+customer+"&Rem=Y");
								//document.getElementById("updateid").href="ManageAppointments.php?bid="+customer+"&Rem=Y"; 
								/* $(evt).closest('td').next().next().find('a .updateid').hide();
								$(evt).closest('td').next().next().find('a .bookid').show(); */
								
							}
							
						}
						function updatevalues(evt)
							{
								
								var typecomment=$(evt).closest('td').prev().prev().find('select').val();
								var customer=$(evt).closest('td').prev().prev().prev().prev().find('input').val();
								var app=$(evt).closest('td').prev().prev().prev().find('input').val();
							    var comment=$(evt).closest('td').prev().find('textarea').val();
								
							 	if(typecomment!="")
								{
									if(typecomment=='1')
									{
										$(evt).closest('td').find('a').attr("href","ManageAppointments.php?bid="+customer+"&Rem=Y");
									}
									else if(typecomment=='2')
									{
										
											$.ajax({
												type:"post",
												data:"customer="+customer+"&comment="+comment+"&app="+app+"&typecomment="+typecomment,
												url:"sendreminder.php",
												success:function(result1)
												{
												alert(result1)
												location.reload();
												}
											});
										
									}
									else if(typecomment=='3')
									{
										$.ajax({
												type:"post",
												data:"customer="+customer+"&comment="+comment+"&app="+app+"&typecomment="+typecomment,
												url:"UpdateCustomerCallRemark.php",
												success:function(result1)
												{
												if($.trim(result1)=='2')
												{
													location.reload();

												}
												
												}
											});
									}
									else if(typecomment=='4')
									{
										$.ajax({
												type:"post",
												data:"customer="+customer+"&comment="+comment+"&app="+app+"&typecomment="+typecomment,
												url:"UpdateCustomerCallRemark.php",
												success:function(result1)
												{
											    if($.trim(result1)=='2')
												{
													location.reload();

												}
												}
											});
									}
									else if(typecomment=='8')
									{
										$.ajax({
												type:"post",
												data:"customer="+customer+"&comment="+comment+"&app="+app+"&typecomment="+typecomment,
												url:"UpdateCustomerCallRemark.php",
												success:function(result1)
												{
											    if($.trim(result1)=='2')
												{
													location.reload();

												}
												}
											});
									}
									else if(typecomment=='9' || typecomment=='7' || typecomment=='6' || typecomment=='5')
									{
										
										if(comment!="")
										{
											$.ajax({
												type:"post",
												data:"customer="+customer+"&comment="+comment+"&app="+app+"&typecomment="+typecomment,
												url:"sendNoncomplaint.php",
												success:function(result1)
												{
												alert(result1)
												location.reload();
												}
											});
										}
										else{
											alert('Comment Cannot Blank')
										}
									}
									else
									{
										
									}
									
								}
								else
								{
									alert('Please select atleast one comment option')
								} 
								/*  var cust=$(evt).closest('td').prev().prev().prev().find('input').val();
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
								} */
							}
                    </script>
						<?php
												
												?>
											
												
												<br>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th><center>Store Name</center></th>
																	<th><center>Total Service Reminder</center></th>
																<th><center>Total Service Reminder Contact</center></th>
															
																
																
															</tr>
														</thead>
													
														<tbody>

<?php
// Create connection And Write Values
  $DB = Connect();
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
										?>
												<tr>
												<td>Khar</td>
								                <td><?=$cntremark6?></td><td><?=$ct6?></td>
												</tr>
													<?php
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
										?>
										<tr>
												<td>Colaba</td>
								                <td><?=$cntremark7?></td><td><?=$ct7?></td>
												</tr>
										<?php
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
										?>
										<tr>
												<td>Breach Candy</td>
								                <td><?=$cntremark8?></td><td><?=$ct8?></td>
												</tr>
										<?php
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
										?>
										
									        	<tr>
												<td>Lokhandwala</td>
								                <td><?=$cntremark9?></td><td><?=$ct9?></td>
												</tr>
												<?php
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
													?>
										
									        	<tr>
												<td>Oshiwara</td>
								                <td><?=$cntremark10?></td><td><?=$ct10?></td>
												</tr>
											   <?php 
											   $cttP=$ct6+$ct7+$ct8+$ct9+$ct10; 
										       $cntremarks=$cntremark6+$cntremark7+$cntremark8+$cntremark9+$cntremark10; 
											   ?>
												 </tbody>
													<tbody>
														<tr>
															<td></td>
															<td class="numeric"><b><?=$cntremarks?></b></td>
															<td class="numeric"><b><?=$cttP?></b></td>
															
															
														</tr>
													</tbody>		
				<?php											
$DB->close();
?>
														
													
													</table>
											
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