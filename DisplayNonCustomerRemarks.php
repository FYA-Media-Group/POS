<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Customer Details | NailSpa";
	$strDisplayTitle = "Customer Details for NailSpa";
	$strMenuID = "10";
	$strMyTable = "tblAppointments";
	$strMyTableID = "AppointmentID";
	$strMyField = "AppointmentDate";
	$strMyActionPage = "DisplayNonCustomerRemarks.php";
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
												
													<form method="get" class="form-horizontal bordered-row" role="form">
												
														   <div class="form-group"><label for="" class="col-sm-4 control-label">Select Store</label>
														<div class="col-sm-4">
														
							                          <select name="store" class="form-control">
																<option value="0">All</option>
																<?
                                                    $selp=select("*","tblStores","Status='0'");
													foreach($selp as $val)
													{
														$strStoreName = $val["StoreName"];
														$strStoreID = $val["StoreID"];
														$store=$_GET["store"];
														if($store==$strStoreID)
														{
															?>
														<option  selected value="<?=$strStoreID?>" ><?=$strStoreName?></option>														
<?php                   
														}
														else
														{
															?>
														<option value="<?=$strStoreID?>" ><?=$strStoreName?></option>														
<?php                   
														}

													}
?>
															</select>
		
												</div>
															
														</div>
												
												
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="DisplayNonCustomerRemarks.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
													

													</div>
												
												</form>
												
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
													if(isset($_GET["store"]))
													{
											
														$storrr=$_GET["store"];
													if($storrr=='0')
													{
														$storrrp='All';
													}
													else{
													$stpp=select("StoreName","tblStores","StoreID='".$storrr."'");
				                                   $StoreName=$stpp[0]['StoreName'];
														$storrrp=$StoreName;
													}
												?>
														
												<h3 class="title-hero">Store - <?=$storrrp?></h3>
												
												<br>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th><center>Customer</center></th>
																<th><center>Remark</center></th>
																<th><center>Comment</center></th>
																<th><center>Details</center></th>
																<th><center>Membership</center></th>
														        <th><center>Last Visit At</center></th>
																<th><center>Called By</center></th>
																<th><center>Called At</center></th>
																<th><center>Service Details</center></th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th><center>Customer</center></th>
																<th><center>Remark</center></th>
																<th><center>Comment</center></th>
																<th><center>Details</center></th>
																<th><center>Membership</center></th>
														        <th><center>Last Visit At</center></th>
																<th><center>Called By</center></th>
																<th><center>Called At</center></th>
																<th><center>Service Details</center></th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
  $DB = Connect();
                                            $store=$_GET["store"];
										
										if($store!='0')
										{
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
										
									    $Productst="SELECT * FROM tblCustomerRemarks WHERE  StoreID='".$store."' and NonCommentType!='0' order by Date(UpdateDate) desc";
										$selpqtyPq=select("count(AppointmentID) as cntapp","tblCustomerRemarks","StoreID='".$store."' and NonCommentType!='0'");
										$noncount=$selpqtyPq[0]['cntapp'];
										}
										else
										{
											$Productst="SELECT * FROM tblCustomerRemarks WHERE StoreID!='0' and NonCommentType!='0' order by Date(UpdateDate) desc";
											$selpqtyPq=select("count(AppointmentID) as cntapp","tblCustomerRemarks","StoreID!='0' and NonCommentType!='0'");
										$noncount=$selpqtyPq[0]['cntapp'];
										}
						/* If($_SERVER['REMOTE_ADDR']=="111.119.219.70")
						   {
							   echo $Productst;
						   }
						   else
						   {
							   
						   } */
											$RSaT = $DB->query($Productst);
					                if ($RSaT->num_rows > 0) 
										{
											$counter=0;
											while($rowa = $RSaT->fetch_assoc())
											{
												$counter++;
												$AppointmentID=$rowa['AppointmentID'];
												$CustomerID=$rowa['CustomerID'];
												$Remark=$rowa['Remark'];
												$CommentType=$rowa['NonCommentType'];
												$UpdateDate=$rowa['UpdateDate'];
												$UpdateTime=$rowa['UpdateTime'];
												
												$UpdatedBy=$rowa['UpdatedBy'];
												$Remark=$rowa['Remark'];
													
													$selpqtyP=select("*","tblCustomers","CustomerID='".$CustomerID."'");
												    $customerfullname=$selpqtyP[0]['CustomerFullName'];
												    $CustomerMobileNo=$selpqtyP[0]['CustomerMobileNo'];
												    $NonCustomerRemark=$selpqtyP[0]['NonCustomerRemark'];
													$CustomerEmailID=$selpqtyP[0]['CustomerEmailID'];
													
													$memberid=$selpqtyP[0]['memberid'];
													
													$selptrt=select("*","tblAppointments","AppointmentID='".$AppointmentID."'");
	                                                $StoreID=$selptrt[0]['StoreID'];
													$offerid=$selptrt[0]['offerid'];
													$VoucherID=$selptrt[0]['VoucherID'];
													$PackageID=$selptrt[0]['PackageID'];
													$packages=explode(",",$PackageID);
	                                                
													$selptrtqistore=select("*","tblStores","StoreID='".$StoreID."'");
	                                                $StoreName=$selptrtqistore[0]['StoreName'];
													
													$selptrtqiemp=select("*","tblAdmin","AdminID='".$UpdatedBy."'");
	                                                $AdminFullName=$selptrtqiemp[0]['AdminFullName'];
													
													
													$selptrtqi=select("*","tblMembership","MembershipID='".$memberid."'");
	                                                $MembershipName=$selptrtqi[0]['MembershipName'];
													if($MembershipName=="")
													{
														$MembershipName='-';
													}
													
													$selptrtqiq=select("*","tblOffers","OfferID='".$offerid."'");
	                                                $OfferName=$selptrtqiq[0]['OfferName'];
													
													$selptrtqiqt=select("*","tblGiftVouchers","GiftVoucherID='".$VoucherID."'");
	                                                $Amount=$selptrtqiqt[0]['Amount'];
													for($p=0;$p<count($packages);$p++)
													{
													   $selptrtqiqtp=select("*","tblPackages","PackageID='".$packages[$p]."'");
	                                                   $name=$selptrtqiqtp[0]['Name'];
													   $pname=$name.",";
													
													}
													
												 if($CommentType=='1')
													{
														$CommentTypes="<span style='color:darkgreen'>Appointment Booked</span>";
													}
													elseif($CommentType=='2')
													{
														$CommentTypes="<span style='color:blue'>Call Later</span>";
													}
													elseif($CommentType=='3')
													{
														$CommentTypes="<span style='color:blue'>Client Unavailable</span>";
													} 
												   elseif($CommentType=='4')
													{
														$CommentTypes="<span style='color:blue'>Client Travelling</span>";
													}
													elseif($CommentType=='5')
													{
														$CommentTypes="<span style='color:red'>Unhappy with Service/Staff</span>";
													}
													elseif($CommentType=='6')
													{
														$CommentTypes="<span style='color:red'>Service is Expensive</span>";
													}
													elseif($CommentType=='7')
													{
														$CommentTypes="<span style='color:red'>Unhappy with Products</span>";
													}
													elseif($CommentType=='8')
													{
														$CommentTypes="<span style='color:pink'>Occassional Visitor</span>";
													}
													elseif($CommentType=='9')
													{
														$CommentTypes="<span style='color:red'>Not Interested</span>";
													} 
													
	
													 ?>
											   <tr>
												<td>
												
													<?=$customerfullname?>
											
												</td>
								                <td><?=$CommentTypes?></td><td><?=$Remark?></td><td><p>
														<b>Email</b> :-<?=$CustomerEmailID?><br/>
														<b>Mobile</b> :-<?=$CustomerMobileNo?><br/></p>
												</td>
												<td><p><center><b><?=$MembershipName?></b></center><br/>
													</p>
												</td>
												<td><center><b><?=$StoreName?></b></center></td>
												<td><center><b><?=$AdminFullName?></center></b></td>
												<td><b>Date:-<?=date("d-m-Y",strtotime($UpdateDate))?></b><br/>
												<b>Time:-<?=$UpdateTime?></b><br/></td>
												<td><center><a data-toggle="modal" class="btn btn-link font-red" data-target="#myModalsAppointment<?=$counter?>">View Details</center></a>
														<div class="modal fade bs-example-modal-lg" id="myModalsAppointment<?=$counter?>" role="dialog" >
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Service Details</h4></div>
                                                    <div class="modal-body">
                                                      
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
											  </tr>
													<?php
												
												
												
											}
										}
										else
										{
											?>
											<tr><td>No Records</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
											<?php
										}
											  ?>
												 </tbody>
															
				<?php											
$DB->close();
?>
														
													
													</table>
											<?php
													}
													else
													{
														echo "<br><center><h3>Please Select Store</h3></center>";
													}
													?>
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