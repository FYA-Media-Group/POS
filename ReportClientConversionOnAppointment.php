<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Client Conversion On Appointment | Nailspa";
	$strDisplayTitle = "Client Conversion On Appointment of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportClientConversionOnAppointment.php";
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
		$strtoandfrom = $_GET["toandfrom"];
		$arraytofrom = explode("-",$strtoandfrom);
		
		$from = $arraytofrom[0];
		$datetime = new DateTime($from);
		$getfrom = $datetime->format('Y-m-d');
		
		
		$to = $arraytofrom[1];
		$datetime = new DateTime($to);
		$getto = $datetime->format('Y-m-d');

		if(!IsNull($from))
		{
			$sqlTempfrom = " and Date(AppointmentDate)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(AppointmentDate)<=Date('".$getto."')";
		}
	}
	if(isset($_GET["toandfrom"]))
	{
		$strtoandfrom = $_GET["toandfrom"];
		$arraytofrom = explode("-",$strtoandfrom);
		
		$from = $arraytofrom[0];
		$datetime = new DateTime($from);
		$getfrom = $datetime->format('Y-m-d');
		
		
		$to = $arraytofrom[1];
		$datetime = new DateTime($to);
		$getto = $datetime->format('Y-m-d');

		if(!IsNull($from))
		{
			$sqlTempfrom = " and Date(AppointmentDate)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(AppointmentDate)<=Date('".$getto."')";
		}
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
				format: 'mm-dd-yyyy'
			});
		});
	</script>
	<script>
		function printDiv(divName) 
		{
	
	    var divToPrint = document.getElementById("printdata");
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
	<script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker.js"></script>
	<script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker-demo.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker-demo.js"></script>
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
<?php

if(!isset($_GET["uid"]))
{

?>					
					
                    <div class="panel">
						<div class="panel">
							<div class="panel-body">
							
								
								<div class="example-box-wrapper">
									<div class="tabs">
										<ul>
											<li><a href="#normal-tabs-1" title="Tab 1">Manage</a></li>
										</ul>
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Customers</h3>
												
												<form method="get" class="form-horizontal bordered-row" role="form">
													<div class="form-group"><label for="" class="col-sm-4 control-label">Select date</label>
														<div class="col-sm-4">
															<div class="input-prepend input-group">
																<span class="add-on input-group-addon">
																	<i class="glyph-icon icon-calendar"></i>
																</span> 
																<input type="text" name="toandfrom" id="daterangepicker-example" class="form-control" value="<?=$strtoandfrom?>">
															</div>
														</div>
													</div>
													<div class="form-group"><label for="" class="col-sm-4 control-label">Select Store</label>
														<div class="col-sm-4">
														
													<select class="form-control required"  name="store">
															<option value="0" selected>All</option>
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
															<div class="form-group"><label for="" class="col-sm-4 control-label">Select Status</label>
														<div class="col-sm-4">
														<?php $status=$_GET["status"];  ?>
													<select class="form-control required"  name="status">
															<option value="0" <?php if($status=='0'){ ?> selected <?php } ?>>All</option>
                                                         <option value="3" <?php if($status=='3'){ ?> selected <?php } ?>>Cancelled</option>
														 <option value="2" <?php if($status=='2'){ ?> selected <?php } ?>>Done</option>
														 <option value="6" <?php if($status=='6'){ ?> selected <?php } ?>>Re-scheduled</option>
														</select>

		
												</div>
															
														</div>
															<div class="form-group">
														<label class="col-sm-4 control-label">Select Percentage</label>
														<div class="col-sm-4">
														<?php 
														$per=$_GET["per"];
														?>
															<select name="per" class="form-control">
																<option value="0" <?php if($per=='0'){ ?> selected <?php } ?>>Without Percentage</option>
															    <option value="1" <?php if($per=='1'){ ?> selected <?php } ?>>Percentage</option>
															</select>
														</div>
													</div>
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportClientConversionOnAppointment.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>

													</div>
														
														
												</form>
												
												<br>
												<div id="printdata">
												<?php
													if(isset($_GET["toandfrom"]) || isset($_GET["store"]))
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
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store - <?=$storrrp?></h3>
												
												<br>
												
												
												<div class="example-box-wrapper">
													<table class="table table-bordered table-striped table-condensed cf" width="100%">
														<thead>
															<tr>
															  <th>Sr</th>
																<th>Customer Name</th>
																<th>Store</th>
																<th>Appointment Date</th>
																<th>Appointment Status</th>
																
																<?php
																	if($per!='0')
																	{
																		$status=$_GET["status"];
																		if($status=='3')
																		{
																				?>
																<th >Appointment Cancelled %</th>
																<?php
																		}
																		elseif($status=='2')
																		{
																			?>
																<th >Appointment Confirmed %</th>
																<?php
																		}
																		elseif($status=='6')
																		{
																			?>
																<th >Appointment Rescheduled %</th>
																<?php
																		}
																		else
																		{
																			?>
																<th >Appointment %</th>
																<?php
																		}
																	
																	}
																?>
															</tr>
														</thead>
													
														<tbody>

<?php
$DB = Connect();
$storrr=$_GET["store"];
$status=$_GET["status"];
$per=$_GET["per"];
if(!empty($storrr))
{
	if(!empty($status))
	{
		$sql="Select * from tblAppointments where IsDeleted!='1' and Status='$status' and StoreID='$storrr' $sqlTempfrom $sqlTempto";
		$sty=select("count(AppointmentID)","tblAppointments","IsDeleted!='1' and Status='$status' and Status!='0' and StoreID='$storrr' $sqlTempfrom $sqlTempto");
	    $totalapp=$sty[0]['count(AppointmentID)'];
	}
	else
	{
		$sql="Select * from tblAppointments where IsDeleted!='1' and StoreID='$storrr' and Status In('2','6','3') $sqlTempfrom $sqlTempto";
		$sty=select("count(AppointmentID)","tblAppointments","IsDeleted!='1' and Status!='0' and StoreID='$storrr' $sqlTempfrom $sqlTempto");
	    $totalapp=$sty[0]['count(AppointmentID)'];
		
		

	}
	
		
}
else
{
	if(!empty($status))
	{
		$sql="Select * from tblAppointments where IsDeleted!='1' and Status='$status' $sqlTempfrom $sqlTempto";	
		$sty=select("count(AppointmentID)","tblAppointments","IsDeleted!='1' and Status='$status' and Status!='0' $sqlTempfrom $sqlTempto");
	    $totalapp=$sty[0]['count(AppointmentID)'];
	}
	else{
		$sql="Select * from tblAppointments where IsDeleted!='1' and Status In('2','6','3') $sqlTempfrom $sqlTempto";	
		$sty=select("count(AppointmentID)","tblAppointments","IsDeleted!='1' and Status!='0'  $sqlTempfrom $sqlTempto");
	    $totalapp=$sty[0]['count(AppointmentID)'];
	}
	
}
?>
<span style="float:left;font-size:14px"><b>Total Appointment : </b><?=$totalapp?></span><br/>
<?php
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	// echo "In if <br>";
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		// echo "In while<br>";
		$CustomerID = $row["CustomerID"];
		$StoreID = $row["StoreID"];
		$AppointmentDate = $row["AppointmentDate"];
		$AppointmentDatet = FormatDateTime($AppointmentDate);
		$Staus = $row["Status"];
	    if($Staus=='2')
		{
			$Staus="Done";
			$stydone=select("count(AppointmentID)","tblAppointments","IsDeleted!='1' and Status='2' and StoreID='".$StoreID."' $sqlTempfrom $sqlTempto");
			//print_r($totalapp);
	        $totaldone=$stydone[0]['count(AppointmentID)'];
			
			$todoneappper=($totaldone/$totalapp)*100;
		}
		elseif($Staus=='6')
		{
			$Staus="Re-scheduled";
			$stydone1=select("count(AppointmentID)","tblAppointments","IsDeleted!='1' and Status='6' and StoreID='".$StoreID."' $sqlTempfrom $sqlTempto");
	        $totaldonere=$stydone1[0]['count(AppointmentID)'];
			$todoneapppreer=($totaldonere/$totalapp)*100;
		}
		elseif($Staus=='3')
		{
			$Staus="Cancelled";
			$stydone2=select("count(AppointmentID)","tblAppointments","IsDeleted!='1' and Status='3' and StoreID='".$StoreID."' $sqlTempfrom $sqlTempto");
	        $totaldonerecan=$stydone2[0]['count(AppointmentID)'];
			$todoneapppreercan=($totaldonerecan/$totalapp)*100;
		}
		
		$CustData="Select * from tblCustomers where CustomerID=$CustomerID";
		$RScust = $DB->query($CustData);
		if ($RScust->num_rows > 0) 
		{

			while($rowcust = $RScust->fetch_assoc())
			{
				$CustomerFullName = $rowcust["CustomerFullName"];
				$CustomerEmailID = $rowcust["CustomerEmailID"];
				$CustomerMobileNo = $rowcust["CustomerMobileNo"];
			}
		}
		
		$dateObject = new DateTime($AppointmentDate);
		
	    $selp=select("StoreName","tblStores","StoreID='".$StoreID."'");
		$StoreName=$selp[0]['StoreName'];
	
	
		
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$CustomerFullName?></td>
																<td><?=$StoreName?></td>
																<td><?=$AppointmentDatet?></td>
																<td><?=$Staus?></td>
																
																<?php
																	if($per!='0')
																	{
																		
																		 if($Staus=='Done')
		                                                                {
																			
																			?>
																<td><?php 
																
																echo round($todoneappper,2);
																?></td>
																<?php
																		}
																		elseif($Staus=='Re-scheduled')
		                                                                {
																			?>
																<td><?php 
															
																echo round($todoneapppreer,2)?></td>
																<?php
																		}
																		elseif($Staus=='Cancelled')
		                                                                {
																			?>
																<td><?php
																
																echo round($todoneapppreercan,2)?></td>
																<?php
																		}
																		
																		
																	}
																?>
																
																
															</tr>
<?php
	}
}
else
{
?>															
															<tr>
																<td></td>
																<td></td>
																<td></td>
															
																<td>No Records Found</td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																
															</tr>
													
														
<?php
}
$DB->close();
?>
														
														</tbody>
														
												
													</table>
													<?php
													}else
														{
															echo "<br><center><h3>Please Select Month And Year!</h3></center>";
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