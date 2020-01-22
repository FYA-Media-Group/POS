<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Customer Feedback | Nailspa";
	$strDisplayTitle = "Customer Feedback of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "CustomerFeedBack.php";
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
	<script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker.js"></script>
	<script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker-demo.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker-demo.js"></script>
	<script>
function updatevalues(evt)
	{
		//alert(111)
		var app_id=$(evt).closest('td').prev().prev().find('input').val();
	//	alert(app_id)
		var remark=$(evt).closest('td').prev().html();
		//alert(remark)
	
		if(app_id!="0")
		{
			$.ajax({
				type:"post",
				data:"app_id="+app_id+"&remark="+remark,
				url:"updateremark.php",
				success:function(result)
				{
		//	alert(result);
				if($.trim(result)=='2')
				{
				location.reload();
				}
				}
				
				
			})
		} 
	}

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
												<h3 class="title-hero">List of Customer Appointments</h3>
												
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
													
														<?php
															if($strAdminRoleID=="36")
                                                               {  
														?>
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
                                                        <?php
															   }
															   elseif($strAdminRoleID=="39")
															   {
																   ?>
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
                                                        <?php
															   }
															    elseif($strAdminRoleID=="4")
															   {
																   ?>
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
                                                        <?php
															   }
															   else
															   {
																   $_GET["store"]=$strStore;
															   }
															   ?>
		
											
												
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="CustomerFeedBack.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														
														<?php 
														if($strAdminRoleID=="4")
															   {
															   }
															   else
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
												
												<div id="printdata">				
												<div class="example-box-wrapper">
													<table class="table table-bordered table-striped table-condensed cf">
														<thead>
															<tr>
															  <th>Sr</th>
																<th>Customer Name</th>
																<th>Date Of Visit</th>
															
																<th>Contact</th>
																<th>Service</th>
																<th>Employee</th>
																<th>Invoice Amount</th>
																<th>Store</th>
																<th>FeedBack</th>
																<th>Action</th>
															</tr>
														</thead>
														
														<tbody>

<?php
$DB = Connect();
$storrr=$_GET["store"];
if(!empty($storrr))
{
	$sql="Select * from tblAppointments where Status=2 and IsDeleted!='1' and StoreID='$storrr' $sqlTempfrom $sqlTempto";	
}
else
{
	$sql="Select * from tblAppointments where Status=2 and IsDeleted!='1' $sqlTempfrom $sqlTempto";	
	// $sql = "Select CustomerID,StoreID,RedemptionCode,Amount,RedempedDateTime from  tblGiftVouchers where 1 $sqlTempfrom $sqlTempto";
	
}

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
		$AppointmentID = $row["AppointmentID"];
		
		$StoreID = $row["StoreID"];
		$AppointmentDate = $row["AppointmentDate"];
		$SuitableAppointmentTime = $row["SuitableAppointmentTime"];
		$CustomerRemark = $row["CustomerRemark"];
		$CustomerFullName = $row["CustomerFullName"];
		$CustomerEmailID = $row["CustomerEmailID"];
		$CustomerMobileNo = $row["CustomerMobileNo"];
	
		
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
		
		$dateObject = new DateTime($SuitableAppointmentTime);
		// echo $dateObject->format('h:i A');
		
	
	    $selp=select("StoreName","tblStores","StoreID='".$StoreID."'");
		$StoreName=$selp[0]['StoreName'];
		
		 $selpu=select("RoundTotal","tblInvoiceDetails","AppointmentId='".$AppointmentID."' and OfferDiscountDateTime!='NULL' and CustomerID='".$CustomerID."'");
		$RoundTotal=$selpu[0]['RoundTotal'];
		
		
		
		$SuitableAppointmentTime=$selpy[0]['SuitableAppointmentTime'];
		
		$dateObject = new DateTime($SuitableAppointmentTime);
		// echo $dateObject->format('h:i A');
		$AppointmentDatet = FormatDateTime($AppointmentDate);

		
		if($RoundTotal =="")
		{
			$RoundTotal ="0.00";
		}
		else
		{
		
			$RoundTotal = $RoundTotal;
			
		}
		$TotalAmount += $RoundTotal;
		
		
		
		
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$CustomerFullName?></td>
																<td><?=$AppointmentDatet?></td>
																
																<td><?=$CustomerMobileNo?></td>
																<td>
																<?php
																$sett=select("ServiceID","tblAppointmentsDetailsInvoice","AppointmentID='".$AppointmentID."'");
																foreach($sett as $vap)
																{
																	$servicee=$vap['ServiceID'];
																	$settp=select("*","tblServices","ServiceID='".$servicee."'");
																	$servicename=$settp[0]['ServiceName'];
																	$ServiceCost=$settp[0]['ServiceCost'];
																	
																?>
																<table><tr><td><?=$servicename." Rs.".$ServiceCost?></td></tr></table>	
																	<?php
																}
																?>
																</td>
																<td>
																	<?php
																$sett=select("distinct(MECID)","tblAppointmentAssignEmployee","AppointmentID='".$AppointmentID."'");
																foreach($sett as $vap)
																{
																	$MECID=$vap['MECID'];
																	$settp=select("*","tblEmployees","EID='".$MECID."'");
																	$EmployeeName=$settp[0]['EmployeeName'];
																	
																	
																?>
																<table><tr><td><?=$EmployeeName?></td></tr></table>	
																	<?php
																}
																?>
																</td>
																<td><?="Rs. ".$RoundTotal?></td>
																<td><input type="hidden" id="AppointmentID" value="<?=$AppointmentID?>"/><?=$StoreName?></td>
																
																<td contenteditable='true'><?=$CustomerRemark?></td>
																<td><a class="btn btn-link" href="#" onclick="updatevalues(this)">Update FeedBack</a></td>
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
														
														<tbody>
														<tr>
															<td></td>
															<td></td>
															<td colspan="5"><center><b>Total Invoice Amount which Appointments done in selected periods(s) : <?=$TotalAmount?></b><center></td>
														  <td></td>
														  <td></td>
														  <td></td>
															
														</tr>
													</tbody>
													
													
													<?php
													
													}
													else
													{
															echo "<br><center><h3>Please Select Month And Year!</h3></center>";
													}
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