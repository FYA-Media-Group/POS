<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Customer Details | NailSpa";
	$strDisplayTitle = "Customer Details for NailSpa";
	$strMenuID = "10";
	$strMyTable = "tblAppointments";
	$strMyTableID = "AppointmentID";
	$strMyField = "AppointmentDate";
	$strMyActionPage = "DisplayNonCustomerCount.php";
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
												<h4 class="title-hero"><center>List of 	Non Visting Customers | NailSpa</center></h4>
												
												
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
																	<th><center>Total Non Customers</center></th>
																<th><center>Total Non Customer Contact</center></th>
															
																
																
															</tr>
														</thead>
													
														<tbody>

<?php
// Create connection And Write Values
  $DB = Connect();
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
										?>
												<tr>
												<td>Khar</td>
								                <td><?=$cntremark2?></td><td><?=$ct2?></td>
												</tr>
													<?php
													
												   
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
										?>
										<tr>
												<td>Colaba</td>
								                <td><?=$cntremark1?></td><td><?=$ct1?></td>
												</tr>
										<?php
										  
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
										?>
										<tr>
												<td>Breach Candy</td>
								                <td><?=$cntremark3?></td><td><?=$ct3?></td>
												</tr>
										<?php
										  
										  
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
										?>
										
									        	<tr>
												<td>Lokhandwala</td>
								                <td><?=$cntremark5?></td><td><?=$ct5?></td>
												</tr>
												<?php
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
													?>
										
									        	<tr>
												<td>Oshiwara</td>
								                <td><?=$cntremark4?></td><td><?=$ct4?></td>
												</tr>
											   <?php 
											   $ctt=$ct5+$ct1+$ct2+$ct3+$ct4; 
										       $cntremark=$cntremark4+$cntremark5+$cntremark3+$cntremark2+$cntremark1; 
											   ?>
												 </tbody>
													<tbody>
														<tr>
															<td></td>
															<td class="numeric"><b><?=$cntremark?></b></td>
															<td class="numeric"><b><?=$ctt?></b></td>
															
															
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