<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Customer Details | NailSpa";
	$strDisplayTitle = "Customer Details for NailSpa";
	$strMenuID = "10";
	$strMyTable = "tblAppointments";
	$strMyTableID = "AppointmentID";
	$strMyField = "AppointmentDate";
	$strMyActionPage = "DisplaySalonCustomerDetails.php";
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
												<h4 class="title-hero"><center>List of Service Reminder Customers | NailSpa</center></h4>
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
							var app=$(evt).closest('td').prev().find('input').val();
							//alert(checkcommenttype)
							if(checkcommenttype=='5' || checkcommenttype=='6' || checkcommenttype=='7' || checkcommenttype=='9' || checkcommenttype=='2' || checkcommenttype=='3' || checkcommenttype=='4' || checkcommenttype=='8')
							{
								$(evt).closest('td').next().find('textarea').attr("ReadOnly",false);
								$(evt).closest('td').next().next().find('a').text("Update");
								$(evt).closest('td').next().next().find('a').attr("href","#");
							}
							else if(checkcommenttype=='1')
							{
								//alert(1234)
								//alert(customer)
								$(evt).closest('td').next().find('textarea').attr("ReadOnly",false);
								$(evt).closest('td').next().next().find('a').attr("href","ManageAppointments.php?bid="+customer+"&App="+app+"&Rem=Y");
								$(evt).closest('td').next().next().find('a').text("Book Appoinment");
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
									$(evt).closest('td').find('a').attr("href","ManageAppointments.php?bid="+customer+"&App="+app+"&Rem=Y");
									}
									else if(typecomment=='2')
									{
										
											/* $.ajax({
												type:"post",
												data:"customer="+customer+"&comment="+comment+"&app="+app+"&typecomment="+typecomment,
												url:"sendreminder.php",
												success:function(result1)
												{
												alert(result1)
												location.reload();
												}
											}); */
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
												url:"sendcomplaint.php",
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
							function sendsms(evt)
							{
								var customer=$(evt).closest('td').find('input').val();
								var app=$(evt).closest('td').prev().prev().prev().prev().find('input').val();
									$.ajax({
												type:"post",
												data:"customer="+customer+"&app="+app,
												url:"ServiceReminderSms.php",
												success:function(result1)
												{
											    if($.trim(result1)=='2')
												{
													location.reload();

												}
												}
											});
							}
                    </script>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Customer</th>
																<th>Mobile</th>
																<th>Remark Type</th>
																<th id="displaycomment">Comment</th>
																<th>Action</th>
														        <th></th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Customer</th>
																<th>Mobile</th>
																<th>Remark Type</th>
																<th id="displaycomment">Comment</th>
													            <th>Action</th>
															    <th></th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
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
											//$Productst="Select distinct(tblAppointments.AppointmentID) from tblCustomers Left Join tblAppointments ON tblCustomers.CustomerID=tblAppointments.CustomerID WHERE tblAppointments.StoreID='$strStore' and tblAppointments.AppointmentDate<='".$n5_daysAgot."' and tblAppointments.AppointmentDate>='2016-11-15' group by tblAppointments.CustomerID order by tblAppointments.AppointmentID desc";
											
										$Productst="Select distinct(CustomerID) from tblAppointments WHERE StoreID='$strStore' and AppointmentDate<='".$n5_daysAgot."' and AppointmentDate>='2017-02-01'";
										}
									
									if($strStore!='0')
										{
											$stqytq=select("distinct(CustomerID)","tblAppointments","StoreID='$strStore' and AppointmentDate<='".$n5_daysAgot."' and AppointmentDate>='2017-02-01' and CommentType!='0' and CustomerRemark!=''");
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
										
										}
										
										foreach($stqytq as $vatqq)
											{
												$CUP[]=$vatqq['CustomerID'];
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
													$cust=EncodeQ($Customer);
													$selptrtapp=select("max(AppointmentID)","tblAppointments","CustomerID='".$Customer."' and StoreID='".$strStore."' and AppointmentDate<='".$n5_daysAgot."' and AppointmentDate>='2017-02-01'");
	                                                $app_id=$selptrtapp[0]['max(AppointmentID)'];
	                                                
													$selpqtyP=select("*","tblCustomers","CustomerID='".$Customer."'");
												    $customerfullname=$selpqtyP[0]['CustomerFullName'];
												    $CustomerMobileNo=$selpqtyP[0]['CustomerMobileNo'];
												    $NonCustomerRemark=$selpqtyP[0]['NonCustomerRemark'];
													$CustomerEmailID=$selpqtyP[0]['CustomerEmailID'];
													
													$memberid=$selpqtyP[0]['memberid'];
													$selptrtqistore=select("*","tblStores","StoreID='".$strStore."'");
	                                                $StoreName=$selptrtqistore[0]['StoreName'];
													$selptrtqi=select("*","tblMembership","MembershipID='".$memberid."'");
	                                                $MembershipName=$selptrtqi[0]['MembershipName'];
													
													
													 ?>
											   <tr>
												<td>
													<input type="hidden" id="cust_id"  value="<?=EncodeQ($Customer)?>"/>
													<a data-toggle="modal" data-target="#myModalsAppointment<?=$counter?>"><?=$customerfullname?></a>
													<div class="modal fade" id="myModalsAppointment<?=$counter?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" >
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Customer Appoinment Details</h4></div>
                                                    <div class="modal-body">
                                                        <p><b>Customer Name</b> :-<?=$customerfullname?><br/>
														<b>Email</b> :-<?=$CustomerEmailID?><br/>
														<b>Mobile</b> :-<?=$CustomerMobileNo?><br/>
														<b>Membership</b> :-<?=$MembershipName?><br/>
														<b>Store</b> :-<?=$StoreName?><br/>
														<?php 
														$selptrtty=select("*","tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."'");
															foreach($selptrtty as $vat)
															{
																$service=$vat['ServiceID'];
																$serviceamount=$vat['ServiceAmount'];
																$set=select("*","tblServices","ServiceID='".$service."'");
																$ServiceName=$set[0]['ServiceName'];
																?>
																<b>Service</b> :- <?=$ServiceName?><br/>
																<b>Service Amount</b> :- <?=$serviceamount?><br/>
																<?php
															}
														
														?>
														
														</p>
                                                    </div>
                                                    <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                                                </div>
                                            </div>
                                        </div>													  
												</td>
												<td>
													<?=$CustomerMobileNo?>
													<input type="hidden" id="app_id" value="<?=$app_id?>">
												</td>
											    <td>
												<select id="SelectOptions" class="form-control" onchange="checkstatus(this,<?=$counter?>)">
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
												<td>
												<textarea readonly id="comment" class="form-control" Rows="2" cols="30"></textarea>
												</td>
												<td>
												<input type="hidden" id="AppointmentBookingURL<?=$Customer?>" value="ManageAppointments.php?bid=<?=EncodeQ($Customer)?>">
												<a class="btn btn-link updateid" id="updateid" onclick="updatevalues(this)">Update</a>
												<!--<a class="btn btn-link bookid" style="display:none" id="bookid"  href="ManageAppointments.php?bid=<?=$cust?>&Rem=Y">Book</a>-->
												</td>
												<td>
												<input type="hidden" id="cust_idx"  value="<?=$Customer?>"/>
												<a class="btn btn-link updateid" id="sendremindrsms" onclick="sendsms(this)">Send Sms</a>
												</td>
												
											</tr>
													<?php
												
												
												}
											
													
	
													
												
											}
											
											}
										}
										else
										{
											?>
											<tr><td>No Records</td><td></td><td></td></tr>
											<?php
										}
											  ?>
												 </tbody>
															
				<?php											
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
						</div>
				<?php require_once 'incFooter.fya'; ?>
 
    </div>
</body>

</html>		