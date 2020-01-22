<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Customer Details | NailSpa";
	$strDisplayTitle = "Customer Details for NailSpa";
	$strMenuID = "10";
	$strMyTable = "tblAppointments";
	$strMyTableID = "AppointmentID";
	$strMyField = "AppointmentDate";
	$strMyActionPage = "ViewUsers.php";
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
             

<?php

if(isset($_GET['type']))
{
	$typeremark=$_GET['type'];
?>					

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
							var app=$(evt).closest('td').prev().find('input').val();
							var checkcommenttype=$(evt).val();
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
										//$(evt).closest('td').find('a').attr("href","ManageAppointments.php?bid="+customer+"&Rem=Y");
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
												url:"UpdateCustomerCallRemark1.php",
												success:function(result1)
												{
												if($.trim(result1)=='2')
												{
													window.location = "Salon-Dashboard.php";
													

												}
												
												}
											});
									}
									else if(typecomment=='3')
									{
										$.ajax({
												type:"post",
												data:"customer="+customer+"&comment="+comment+"&app="+app+"&typecomment="+typecomment,
												url:"UpdateCustomerCallRemark1.php",
												success:function(result1)
												{
												if($.trim(result1)=='2')
												{
													window.location = "Salon-Dashboard.php";

												}
												
												}
											});
									}
									else if(typecomment=='4')
									{
										$.ajax({
												type:"post",
												data:"customer="+customer+"&comment="+comment+"&app="+app+"&typecomment="+typecomment,
												url:"UpdateCustomerCallRemark1.php",
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
												url:"UpdateCustomerCallRemark1.php",
												success:function(result1)
												{
											    if($.trim(result1)=='2')
												{
													window.location = "Salon-Dashboard.php";

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
												window.location = "Salon-Dashboard.php";
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
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Customer</th>
																<th>Mobile</th>
																<th>Remark Type</th>
																<th id="displaycomment">Comment</th>
																<th>Action</th>
														
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Customer</th>
																<th>Mobile</th>
																<th>Remark Type</th>
																<th id="displaycomment">Comment</th>
													            <th>Action</th>
															
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
  $DB = Connect();
										if($strStore!='0')
										{
										$Productst="Select * from tblCustomerRemarks WHERE StoreID='$strStore' and CommentType='".$typeremark."'";
										}
								
										$RSaT = $DB->query($Productst);
					                    if($RSaT->num_rows > 0) 
										{
											$counter=0;
											while($rowa = $RSaT->fetch_assoc())
											{
												$counter++;
												
												$Customer=$rowa['CustomerID'];
												$selptrtqistoret=select("max(CustomerRemarkID)","tblCustomerRemarks","StoreID='".$strStore."' and CustomerID='".$Customer."'");
	                                            $maxid=$selptrtqistoret[0]['max(CustomerRemarkID)'];
												
												$selptrtqistorettui=select("*","tblCustomerRemarks","CustomerRemarkID='".$maxid."'");
	                                           
												$AppointmentID=$selptrtqistorettui[0]['AppointmentID'];
												$Remark=$selptrtqistorettui[0]['Remark'];
												$CommentType=$selptrtqistorettui[0]['CommentType'];
												$cust=EncodeQ($Customer);
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
														$selptrtty=select("*","tblAppointmentsDetailsInvoice","AppointmentID='".$AppointmentID."'");
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
													<input type="hidden" id="app_id" value="<?=$AppointmentID?>">
												</td>
											    <td>
												<select id="SelectOptions" class="form-control" onchange="checkstatus(this,<?=$counter?>)">
														<option value="">-- Select --</option>
														<?php
															if ($CommentType=="1")
															{
														?>
														<option value="1" selected><?// =$EncodedCustomerID?>Book Now</option>
														<option value="2">Call Later</option>
														<option value="3">Client Unavailable</option>
														<option value="4">Client Travelling</option>
														<option value="5">Unhappy with Service/Staff</option>
														<option value="6">Service is Expensive</option>
														<option value="7">Unhappy with Products</option>
														<option value="8">Occassional Visitor</option>
														<option value="9">Not Interested</option>
														<?php
															}
															elseif ($CommentType=="2")
															{
													?>
														<option value="1"><?// =$EncodedCustomerID?>Book Now</option>
														<option value="2" selected>Call Later</option>
														<option value="3">Client Unavailable</option>
														<option value="4">Client Travelling</option>
														<option value="5">Unhappy with Service/Staff</option>
														<option value="6">Service is Expensive</option>
														<option value="7">Unhappy with Products</option>
														<option value="8">Occassional Visitor</option>
														<option value="9">Not Interested</option>
														<?php
															}
															elseif ($CommentType=="3")
															{
													?>
														<option value="1"><?// =$EncodedCustomerID?>Book Now</option>
														<option value="2">Call Later</option>
														<option value="3" selected>Client Unavailable</option>
														<option value="4">Client Travelling</option>
														<option value="5">Unhappy with Service/Staff</option>
														<option value="6">Service is Expensive</option>
														<option value="7">Unhappy with Products</option>
														<option value="8">Occassional Visitor</option>
														<option value="9">Not Interested</option>
														<?php
															}
															elseif ($CommentType=="4")
															{
													?>
														<option value="1"><?// =$EncodedCustomerID?>Book Now</option>
														<option value="2">Call Later</option>
														<option value="3">Client Unavailable</option>
														<option value="4" selected>Client Travelling</option>
														<option value="5">Unhappy with Service/Staff</option>
														<option value="6">Service is Expensive</option>
														<option value="7">Unhappy with Products</option>
														<option value="8">Occassional Visitor</option>
														<option value="9">Not Interested</option>
														<?php
															}
															elseif ($CommentType=="5")
															{
													?>
														<option value="1"><?// =$EncodedCustomerID?>Book Now</option>
														<option value="2">Call Later</option>
														<option value="3">Client Unavailable</option>
														<option value="4">Client Travelling</option>
														<option value="5" selected>Unhappy with Service/Staff</option>
														<option value="6">Service is Expensive</option>
														<option value="7">Unhappy with Products</option>
														<option value="8">Occassional Visitor</option>
														<option value="9">Not Interested</option>
														<?php
															}
															elseif ($CommentType=="6")
															{
													?>
														<option value="1"><?// =$EncodedCustomerID?>Book Now</option>
														<option value="2">Call Later</option>
														<option value="3">Client Unavailable</option>
														<option value="4">Client Travelling</option>
														<option value="5">Unhappy with Service/Staff</option>
														<option value="6" selected>Service is Expensive</option>
														<option value="7">Unhappy with Products</option>
														<option value="8">Occassional Visitor</option>
														<option value="9">Not Interested</option>
														<?php
															}
															elseif ($CommentType=="7")
															{
													?>
														<option value="1"><?// =$EncodedCustomerID?>Book Now</option>
														<option value="2">Call Later</option>
														<option value="3">Client Unavailable</option>
														<option value="4">Client Travelling</option>
														<option value="5">Unhappy with Service/Staff</option>
														<option value="6">Service is Expensive</option>
														<option value="7" selected>Unhappy with Products</option>
														<option value="8">Occassional Visitor</option>
														<option value="9">Not Interested</option>
														<?php
															}
															elseif ($CommentType=="8")
															{
													?>
														<option value="1"><?// =$EncodedCustomerID?>Book Now</option>
														<option value="2">Call Later</option>
														<option value="3">Client Unavailable</option>
														<option value="4">Client Travelling</option>
														<option value="5">Unhappy with Service/Staff</option>
														<option value="6">Service is Expensive</option>
														<option value="7">Unhappy with Products</option>
														<option value="8" selected>Occassional Visitor</option>
														<option value="9">Not Interested</option>
														<?php
															}
															elseif ($CommentType=="9")
															{
													?>
														<option value="1"><?// =$EncodedCustomerID?>Book Now</option>
														<option value="2">Call Later</option>
														<option value="3">Client Unavailable</option>
														<option value="4">Client Travelling</option>
														<option value="5">Unhappy with Service/Staff</option>
														<option value="6">Service is Expensive</option>
														<option value="7">Unhappy with Products</option>
														<option value="8">Occassional Visitor</option>
														<option value="9" selected>Not Interested</option>
														<?php
															}
															
														?>	
														
													</select>
													
												</td>
												<td>
												<textarea class="form-control" id="comment" Rows="2" cols="30"><?=$Remark?></textarea>
												</td>
												<td>
												<input type="hidden" id="AppointmentBookingURL<?=$Customer?>" value="ManageAppointments.php?bid=<?=EncodeQ($Customer)?>">
												<a class="btn btn-link updateid" id="updateid" onclick="updatevalues(this)">Update</a>
												<!--<a class="btn btn-link bookid" style="display:none" id="bookid"  href="ManageAppointments.php?bid=<?=$cust?>&Rem=Y">Book</a>-->
												</td>
												
											</tr>
													<?php
												
												
												
												
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
							
							
							<?php
							}
							?>
						</div>
				<?php require_once 'incFooter.fya'; ?>
 
    </div>
</body>

</html>		