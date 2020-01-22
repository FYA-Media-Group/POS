<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Non Visiting Customers for 2 months Report | Nailspa";
	$strDisplayTitle = "Non Visiting Customers for 2 months Report of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportNonVisiters.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
// code for not allowing the normal admin to access the super admin rights	


	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$strStep = Filter($_POST["step"]);
		
		if($strStep=="add")
		{
			
		}
		
		if($strStep=="edit")
		{
			
		}
		
	}	
?>
<?php

	if(isset($_GET["toandfrom"]))
	{
		
		echo $strtoandfrom = $_GET["toandfrom"];
	
		$datetime = date('Y-m-d',strtotime($strtoandfrom));
		$getfrom = $datetime;
        $sqlTempfrom = " and Date(tblAppointments.AppointmentDate)>=Date('".$getfrom."') and Date(tblAppointments.AppointmentDate)<=Date('".$getfrom."')";
		

		
	}
	
	if(!IsNull($_GET["Store"]))
	{
		$strStoreID = $_GET["Store"];
		
			$sqlTempStore = " StoreID='$strStoreID'";
		
	}
	

?>	


<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	
		<script type="text/javascript" src="assets/widgets/datepicker/datepicker.js"></script>
                    <script type="text/javascript">
                        /* Datepicker bootstrap */

                        $(function() {
                            "use strict";
                            $('.bootstrap-datepicker').bsdatepicker({
                                format: 'yyyy-mm-dd'
                            });
                        });
                    </script>
                    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker.js"></script>
                    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker-demo.js"></script>
                    <script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>
                    <script type="text/javascript" src="assets/widgets/timepicker/timepicker.js"></script>
                    <script type="text/javascript">
                        /* Timepicker */

                        $(function() {
                            "use strict";
                            $('.timepicker-example').timepicker();
                        });
                    </script>
					<script>
						$(function ()						
						{
							$("#AppointmentDate").datepicker({ minDate: 0 });
							$("#AppointmentDate").datepicker({ minDate: 0 });
						});
					</script>
					<script>
		function printDiv(divName) 
		{
	
	    var divToPrint = document.getElementById("kakkabiryani");
        var htmlToPrint = '' +
        '<style type="text/css">' +
        'table th, table td {' +
        'border:1px solid #000;' +
        'padding;0.5em;' +
        '}' +
        '</style>';
		htmlToPrint += divToPrint.outerHTML;
		newWin = window.open("");
		newWin.document.write(htmlToPrint);
		newWin.print();
		newWin.close();
			// var printContents = document.getElementById(divName);
			// var originalContents = document.body.innerHTML;

			// document.body.innerHTML = printContents;

			// window.print();

			// document.body.innerHTML = originalContents; 
		}

</script>
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
					

                    <div id="page-title">
                        <h2><?=$strDisplayTitle?></h2>
                    </div>
<style type="text/css">
@media print {
  body * {
    visibility: hidden;
  }
  #printarea * {
    visibility: visible;
  }
  #printarea{
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>
<?php

if(!isset($_GET["uid"]))
{

?>					
					
                    <div class="panel">
						<div class="panel">
							<div class="panel-body">
							
								
								<div class="example-box-wrapper">
									<div class="tabs">
										
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of all Non Visiters Customers</h3>
												
												<form method="get" class="form-horizontal bordered-row" role="form">
												
														<div class="form-group">
														<label class="col-sm-4 control-label">Select Store</label>
														<div class="col-sm-4">
															<select name="Store" class="form-control">
																<option value="0">All</option>
																<?
                                                    $selp=select("*","tblStores","Status='0'");
													foreach($selp as $val)
													{
														$strStoreName = $val["StoreName"];
														$strStoreID = $val["StoreID"];
														$store=$_GET["Store"];
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
														<a class="btn btn-link" href="ReportNonVisiters.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														<?php
														$storrr=$_GET["Store"];
														if($storrr!="")
													   {
														   ?>
												<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
														 <?php
													   }
														?>
														

													</div>
													
													
												</form>
												
												<br>
																	<?php
													if(!IsNull($_GET["Store"]))
													{
														
														$storrr=$_GET["Store"];
													if($storrr=='0')
													{
														$storrrp='All';
													}
													else{
													$stpp=select("StoreName","tblStores","StoreID='".$storrr."'");
				                                    $StoreName=$stpp[0]['StoreName'];
														$storrrp=$StoreName;
													}
													$n5_daysAgot = date('Y-m-d', strtotime('-60 days', time()));

												?>
												<br><br>
<saif id="kakkabiryani">										
														<h3 class="title-hero">For Date : <?=$n5_daysAgot?> / Store Filter selected : <?=$storrrp?> </h3>
												
												<br>
				

				
<?php
$DB = Connect();

	$counter = 0;

		$storrr=$_GET["Store"];
?>
		<div class="panel">
			<div class="panel-body" style="overflow-x: scroll;">
				
				<div class="example-box-wrapper">
					<div class="scroll-columns">
					

					
						<table id="printdata" class="table table-bordered table-striped table-condensed cf">
						                                   <thead class="cf">
																<tr>
																<?php
																if(empty($storrr))
                                                                {
																?>
																	
																	<th>Customer Name</th>
																	<th>No of Visits</th>
																	<th>Last visited date</th>
																	<th class="numeric">Employee Name</th>
																	<th class="numeric">Last Service Done</th>
																	<th class="numeric">Customer Acquisition</th>
																	<th class="numeric">Customer Acquisition Date</th>
																	<th>Store</th>
																	<?php
																}
																else
																{
																	?>
																    <th>Customer Name</th>
																	<th>No of Visits</th>
																	<th>Last visited date</th>
																	<th class="numeric">Employee Name</th>
																	<th class="numeric">Last Service Done</th>
																	<th class="numeric">Customer Acquisition</th>
																	<th class="numeric">Customer Acquisition Date</th>
																	<?php
																}
																	?>
																</tr>
															</thead>
							                              
															<tbody>
							
<?php
  $DB = Connect();
$storr=$_GET["Store"];
if(!empty($storr))
{
	                                         $ct=0;
	                                         $n5_daysAgot = date('Y-m-d', strtotime('-60 days', time()));
	//echo $getfrom;
											  $todaydate=date('Y-m-d');
								              $stqy=select("distinct(CustomerID)","tblAppointments","StoreID='$storr' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgot."'");
											
												foreach($stqy as $vatq)
												{
													$CU[]=$vatq['CustomerID'];
													
												}
												
											$Productst="Select distinct(CustomerID) from tblAppointments WHERE StoreID='$storr' and AppointmentDate<='".$n5_daysAgot."' and AppointmentDate>='2016-11-15'";
											$stqytq=select("distinct(CustomerID)","tblAppointments","StoreID='$storr' and AppointmentDate<='".$n5_daysAgot."' and AppointmentDate>='2016-11-15' and NonCustomerCommentType='0' and NonCustomerRemark=''");
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
														        $ct++;
																$cust=EncodeQ($Customer);
																$selptrtappty=select("min(AppointmentID)","tblAppointments","CustomerID='".$Customer."' and StoreID='".$storr."' and AppointmentDate<='".$n5_daysAgot."' and AppointmentDate>='2016-11-15'");
																$app_idop=$selptrtappty[0]['min(AppointmentID)'];
																
																
																$selpDATEtyu=select("AppointmentDate","tblAppointments","AppointmentID='".$app_idop."'");
																//print_r($selpDATE);
																$appdatepy=$selpDATEtyu[0]['AppointmentDate'];
																$acquiredate = FormatDateTime($appdatepy);
																
																
																$selptrtapp=select("max(AppointmentID)","tblAppointments","CustomerID='".$Customer."' and StoreID='".$storr."' and AppointmentDate<='".$n5_daysAgot."' and AppointmentDate>='2016-11-15'");
																$app_id=$selptrtapp[0]['max(AppointmentID)'];
																
																$selpDATE=select("AppointmentDate","tblAppointments","AppointmentID='".$app_id."'");
																//print_r($selpDATE);
																$appdate=$selpDATE[0]['AppointmentDate'];
																$strAppointmentDate6 = FormatDateTime($appdate);
																
																$selpDATETY=select("DISTINCT(MECID)","tblAppointmentAssignEmployee","AppointmentID='".$app_id."'");
																
																//$strAppointmentDate6 = $appdate->format('Y-m-d');
																
																$selptrtappt="Select distinct(CustomerID) from tblAppointments WHERE StoreID='$storr' and CustomerID='".$Customer."'";
																//echo $selptrtappt;
																
																$selptrtapper=select("count(AppointmentID)","tblAppointments","CustomerID='".$Customer."' and StoreID='".$storr."' and AppointmentDate<='".$n5_daysAgot."' and AppointmentDate>='2016-11-15'");
																$cntapp=$selptrtapper[0]['count(AppointmentID)'];
																
																$selpqtyP=select("*","tblCustomers","CustomerID='".$Customer."' order by CustomerFullName ASC");
																$customerfullname=$selpqtyP[0]['CustomerFullName'];
																$CustomerMobileNo=$selpqtyP[0]['CustomerMobileNo'];
																$NonCustomerRemark=$selpqtyP[0]['NonCustomerRemark'];
																$CustomerEmailID=$selpqtyP[0]['CustomerEmailID'];
																$Acquisition=$selpqtyP[0]['Acquisition'];
																if($Acquisition=="0")
																{
																	$Acquisition='-';
																}
																
																$memberid=$selpqtyP[0]['memberid'];
																$selptrtqistore=select("*","tblStores","StoreID='".$storr."'");
																$StoreName=$selptrtqistore[0]['StoreName'];
																$selptrtqi=select("*","tblMembership","MembershipID='".$memberid."'");
																$MembershipName=$selptrtqi[0]['MembershipName'];
																
																?>
																 <tr>
												                  <td><?=$customerfullname?></td>
																  <td><?=$cntapp?></td>
																  <td><?=$strAppointmentDate6?></td>
																  <td><?php 
																  foreach($selpDATETY as $vat)
																{
																	$MECID=$vat['MECID'];
																	$selpempt=select("EmployeeName","tblEmployees","EID='".$MECID."'");
																	$EmployeeName=$selpempt[0]['EmployeeName'];
																	echo $EmployeeName."<br/>";
																}
																  
																 ?></td>
																  <td><?php	
																 
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
																
																</td>
																  <td><?=$Acquisition?></td>
																  <td><?=$acquiredate?></td>
																 </tr>
																<?php
															
													}
												}
											 }
											 else
											 {
												 ?>
															
															  <td></td>
															  <td></td>
															  <td></td>
															  <td></td>
															  <td></td>
															  <td></td>
															  <td></td>
															 
															 <?php
											 }
}
else
{
	$ct=0;
	$stpp=select("*","tblStores","Status='0'");
	foreach($stpp as $vapt)
	{
		  
		                                     $n5_daysAgot = date('Y-m-d', strtotime('-60 days', time()));
	//echo $getfrom;
											  $todaydate=date('Y-m-d');
								              $stqy=select("distinct(CustomerID)","tblAppointments","StoreID='".$vapt['StoreID']."' and AppointmentDate<='".$todaydate."' and AppointmentDate>='".$n5_daysAgot."'");
											
												foreach($stqy as $vatq)
												{
													$CU[]=$vatq['CustomerID'];
													
												}
												
											$Productst="Select distinct(CustomerID) from tblAppointments WHERE StoreID='".$vapt['StoreID']."' and AppointmentDate<='".$n5_daysAgot."' and AppointmentDate>='2016-11-15'";
											$stqytq=select("distinct(CustomerID)","tblAppointments","StoreID='".$vapt['StoreID']."' and AppointmentDate<='".$n5_daysAgot."' and AppointmentDate>='2016-11-15' and NonCustomerCommentType='0' and NonCustomerRemark=''");
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
														        $ct++;
																$cust=EncodeQ($Customer);
																
																$selptrtappty=select("min(AppointmentID)","tblAppointments","CustomerID='".$Customer."' and StoreID='".$storr."' and AppointmentDate<='".$n5_daysAgot."' and AppointmentDate>='2016-11-15'");
																$app_idop=$selptrtappty[0]['min(AppointmentID)'];
																$selpDATEtyu=select("AppointmentDate","tblAppointments","AppointmentID='".$app_idop."'");
																//print_r($selpDATE);
																$appdatepy=$selpDATEtyu[0]['AppointmentDate'];
																$acquiredate = FormatDateTime($appdatepy);
																$selptrtapp=select("max(AppointmentID)","tblAppointments","CustomerID='".$Customer."' and StoreID='".$vapt['StoreID']."' and AppointmentDate<='".$n5_daysAgot."' and AppointmentDate>='2016-11-15'");
																$app_id=$selptrtapp[0]['max(AppointmentID)'];
																
																$selpDATE=select("AppointmentDate","tblAppointments","AppointmentID='".$app_id."'");
																//print_r($selpDATE);
																$appdate=$selpDATE[0]['AppointmentDate'];
																$strAppointmentDate6 = FormatDateTime($appdate);
																
																$selpDATETY=select("DISTINCT(MECID)","tblAppointmentAssignEmployee","AppointmentID='".$app_id."'");
																
																//$strAppointmentDate6 = $appdate->format('Y-m-d');
																
																$selptrtappt="Select distinct(CustomerID) from tblAppointments WHERE StoreID='".$vapt['StoreID']."' and CustomerID='".$Customer."'";
																//echo $selptrtappt;
																
																$selptrtapper=select("count(AppointmentID)","tblAppointments","CustomerID='".$Customer."' and StoreID='".$vapt['StoreID']."' and AppointmentDate<='".$n5_daysAgot."' and AppointmentDate>='2016-11-15'");
																$cntapp=$selptrtapper[0]['count(AppointmentID)'];
																
																$selpqtyP=select("*","tblCustomers","CustomerID='".$Customer."' order by CustomerFullName ASC");
																$customerfullname=$selpqtyP[0]['CustomerFullName'];
																$CustomerMobileNo=$selpqtyP[0]['CustomerMobileNo'];
																$NonCustomerRemark=$selpqtyP[0]['NonCustomerRemark'];
																$CustomerEmailID=$selpqtyP[0]['CustomerEmailID'];
																$Acquisition=$selpqtyP[0]['Acquisition'];
																if($Acquisition=="0")
																{
																	$Acquisition='-';
																}
																
																$memberid=$selpqtyP[0]['memberid'];
																$selptrtqistore=select("*","tblStores","StoreID='".$vapt['StoreID']."'");
																$StoreName=$selptrtqistore[0]['StoreName'];
																$selptrtqi=select("*","tblMembership","MembershipID='".$memberid."'");
																$MembershipName=$selptrtqi[0]['MembershipName'];
																
																?>
																 <tr>
												                  <td><?=$customerfullname?></td>
																  <td><?=$cntapp?></td>
																  <td><?=$strAppointmentDate6?></td>
																  <td><?php 
																  foreach($selpDATETY as $vat)
																{
																	$MECID=$vat['MECID'];
																	$selpempt=select("EmployeeName","tblEmployees","EID='".$MECID."'");
																	$EmployeeName=$selpempt[0]['EmployeeName'];
																	echo $EmployeeName."<br/>";
																}
																  
																 ?></td>
																  <td><?php	
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
																}?></td>
																  <td><?=$Acquisition?></td>
																  <td><?=$acquiredate?></td>
																  <td><?=$vapt['StoreName']?></td>
																 </tr>
																<?php
															
													}
												}
											 }
											 else
											 {
												 ?>
															  <td></td>
															  <td></td>
															  <td></td>
															  <td></td>
															  <td></td>
															  <td></td>
															  <td></td>
															  <td></td>
															 <?php
											 }
	}
}


?>							
					</tbody>
											
													 <tbody>
						                                <?php
																if($storrr=='0')
													            {
																	?>
																	<tr>
															<td colspan="8"><center><b>Total Count Of Non Visitors in selected periods(s) : <?=$ct?></b><center></td>
															
															
														    </tr>
																	<?php
																}
																else
																{
																	?>
																		<tr>
															<td colspan="7"><center><b>Total Count Of Non Visitors in selected store : <?=$ct?></b><center></td>
															
														    
														    </tr>
																	<?php
																	
																}
																?>
														
													 
						                            </tbody>
						</table>
						
					</div>
				</div>
			</div>
		</div>
		
<?php	
	

$DB->close();

?>
												
												
						<?php
						 }
					   else
					   {
						   echo "<br><center><h3>Please select the store for which you want to see Non visiting clients from current date!</h3></center>";
					   }
?>
														
							</saif>						
												</div>
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
                    </div>
<?php
} // End null condition
else
{
	
}
?>
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>