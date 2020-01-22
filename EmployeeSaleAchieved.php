<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Employee Sales Achieved Report | Nailspa";
	$strDisplayTitle = "Employee Sales Achieved Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "";
	$strMyTableID = "";
	$strMyField = "";
	$strMyActionPage = "EmployeeSaleAchieved.php";
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
			$sqlTempfrom = " and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$getto."')";
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

										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">Employee Commission</h3>
												
												<form method="get" class="form-horizontal bordered-row" role="form">
													<div class="form-group"><label for="" class="col-sm-4 control-label">Select Date Range</label>
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
															<option value="" selected>--Select Store--</option>
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
														<a class="btn btn-link" href="EmployeeSaleAchieved.php">Clear All Filter</a>
											
													</div>
												</form>
												
												
												<div class="example-box-wrapper">
												<?php
												if(isset($_GET["toandfrom"]))
												{
												?>
												<br><br>
												<span>
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?></h3>
												</span>
													
					<table class="table table-bordered table-striped table-condensed cf"  cellspacing="0" width="100%">
				
					<thead>
						<tr>
							<th>Employee ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Mobile</th>
							<th>Store</th>
							<th>Percentage</th>
							<th>Total Sales</th>
							<th>Target</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Employee ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Mobile</th>
							<th>Store</th>
							<th>Percentage</th>
							<th>Total Sales</th>
							<th>Target</th>

						</tr>
					</tfoot>
					<tbody>												
																						
												
<?php

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
										$storrr=$_GET["store"];
										if(!empty($storrr))
										{
										
											// echo "in if<br>";
											$sql = "select tblEmployees.*, tblEmployeeTarget.TargetForMonth, tblEmployeeTarget.BaseTarget 
											from tblEmployees 
											left join tblEmployeeTarget
											on tblEmployees.EmployeeCode = tblEmployeeTarget.EmployeeCode
											where tblEmployees.Status='0' and tblEmployees.StoreID='$storrr'";

											
											$RS = $DB->query($sql);
if($RS->num_rows > 0) 
{
	
	while($row = $RS->fetch_assoc())
	{
		$strEID = $row["EID"];
		$strEmployeeName = $row["EmployeeName"];
		$strEmployeeEmailID = $row["EmployeeEmailID"];
		$strEmpPercentage = $row["EmpPercentage"];
		$strEmployeeMobileNo = $row["EmployeeMobileNo"];
		$strTOM = $row["TargetForMonth"];
		$strBaseTarget = $row["BaseTarget"];
		$epp=select("StoreName","tblStores","StoreID='".$storrr."'");
				
						$storename=$epp[0]['StoreName'];		
		
		
					
			//echo $sqldetails;
			$RSdetails = $DB->query($sqldetails);
			if($RSdetails->num_rows > 0) 
			{
				$ComFinal = "";
				$strSID = "";
				$strSAmount = "";
				$strCommission = "";
				$Sale = "";
				$TotalSale = "";
				while($rowdetails = $RSdetails->fetch_assoc())
				{
					$strAID = $rowdetails["AppointmentID"];
					$strSID = $rowdetails["ServiceID"];
					$strSAmount = $rowdetails["ServiceAmount"];
					$strCommission = $rowdetails["Commission"];
					
					$sqldiscount ="select OfferAmount, MemberShipAmount from tblAppointmentMembershipDiscount where AppointmentID='$strAID' and ServiceID='$strSID'";
					
					$sqldetails = "SELECT tblAppointmentAssignEmployee.AppointmentID, tblAppointmentAssignEmployee.ServiceID, tblAppointmentsDetailsInvoice.ServiceAmount, tblAppointmentAssignEmployee.Commission, tblInvoiceDetails.OfferDiscountDateTime 
											FROM tblEmployees 
											left join tblAppointmentAssignEmployee 
											on tblEmployees.EID = tblAppointmentAssignEmployee.MECID 
											left join tblAppointmentsDetailsInvoice 
											on tblAppointmentsDetailsInvoice.AppointmentId= tblAppointmentAssignEmployee.AppointmentID
											left join tblInvoiceDetails 
											on tblAppointmentAssignEmployee.AppointmentID=tblInvoiceDetails.AppointmentId
											where tblEmployees.StoreID = '$storrr' and tblEmployees.EID='$strEID' and tblAppointmentAssignEmployee.AppointmentID!='NULL' and tblInvoiceDetails.OfferDiscountDateTime!='NULL' $sqlTempfrom $sqlTempto group by tblAppointmentAssignEmployee.AppointmentID";
					// echo $sqldetails."<br>";
					
					
					$RSdiscount = $DB->query($sqldiscount);
					if($RSdiscount->num_rows > 0) 
					{
						while($rowdiscount = $RSdiscount->fetch_assoc())
						{
							$strOfferAmount = $rowdiscount["OfferAmount"];
							$strDiscountAmount = $rowdiscount["MemberShipAmount"];
	
							
							if($strOfferAmount=="0")
							{
								$FinalDAmount = $strDiscountAmount;
							}
							elseif($strDiscountAmount=="0")
							{
								$FinalDAmount = $strOfferAmount;
							}
						}
					}
					else
					{
						$FinalDAmount = "0";
					}
					
					$Sale = $strSAmount - $FinalDAmount;
					//echo $Sale."<br>";
					$TotalSale += $Sale;
				
						
				}
			}
			else
			{
				$TotalSale = "0.00";
			}
		//echo "<hr>";

?>																			
							<tr id="my_data_tr_<?=$counter?>">
								<td><?=$strEID?></td>
								<td><?=$strEmployeeName?></td>
								<td><?=$strEmployeeEmailID?></td>
								<td><?=$strEmployeeMobileNo?></td>
								<td><?=$storename?></td>
								<td><?=$strEmpPercentage?> %</td>	
								<td>Rs.<?=$TotalSale?>/-</td>	
								<td>Rs<?=$strBaseTarget?>/-</td>	
							</tr>
<?
	}
}
else
{
?>				
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td>No Employees</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
<?php															
}
			echo "</tbody></table><br><br>";


										}
										
										else
										{
											// echo "in else<br>";
											$sql = "select tblEmployees.*, tblEmployeeTarget.TargetForMonth, tblEmployeeTarget.BaseTarget 
											from tblEmployees 
											left join tblEmployeeTarget
											on tblEmployees.EmployeeCode = tblEmployeeTarget.EmployeeCode
											where tblEmployees.Status='0' ";
											// echo $sql;
											
											
											$RS = $DB->query($sql);
if($RS->num_rows > 0) 
{
	
	while($row = $RS->fetch_assoc())
	{
		$strEID = $row["EID"];
		$strEmployeeName = $row["EmployeeName"];
		$strEmployeeEmailID = $row["EmployeeEmailID"];
		$strEmpPercentage = $row["EmpPercentage"];
		$strEmployeeMobileNo = $row["EmployeeMobileNo"];
		$strTOM = $row["TargetForMonth"];
		$strBaseTarget = $row["BaseTarget"];
		$StoreID = $row["StoreID"];
		
		$epp=select("StoreName","tblStores","StoreID='".$StoreID."'");
						$storename=$epp[0]['StoreName'];			
		$sqldetails = "SELECT tblAppointmentAssignEmployee.AppointmentID, tblAppointmentAssignEmployee.ServiceID, tblAppointmentsDetailsInvoice.ServiceAmount, tblAppointmentAssignEmployee.Commission, tblInvoiceDetails.OfferDiscountDateTime 
											FROM tblEmployees 
											left join tblAppointmentAssignEmployee 
											on tblEmployees.EID = tblAppointmentAssignEmployee.MECID 
											left join tblAppointmentsDetailsInvoice 
											on tblAppointmentsDetailsInvoice.AppointmentId= tblAppointmentAssignEmployee.AppointmentID
											left join tblInvoiceDetails 
											on tblAppointmentAssignEmployee.AppointmentID=tblInvoiceDetails.AppointmentId
											where  tblEmployees.EID='$strEID' and tblAppointmentAssignEmployee.AppointmentID!='NULL' and tblInvoiceDetails.OfferDiscountDateTime!='NULL' $sqlTempfrom $sqlTempto group by tblAppointmentAssignEmployee.AppointmentID";
											// echo $sqldetails."<br>";
					
			// echo $sqldetails."<br>";
			$RSdetails = $DB->query($sqldetails);
			if($RSdetails->num_rows > 0) 
			{
				$ComFinal = "";
				$strSID = "";
				$strSAmount = "";
				$strCommission = "";
				$Sale = "";
				$TotalSale = "";
				while($rowdetails = $RSdetails->fetch_assoc())
				{
					$strAID = $rowdetails["AppointmentID"];
					$strSID = $rowdetails["ServiceID"];
					$strSAmount = $rowdetails["ServiceAmount"];
					$strCommission = $rowdetails["Commission"];
					
					$sqldiscount ="select OfferAmount, MemberShipAmount from tblAppointmentMembershipDiscount where AppointmentID='$strAID' and ServiceID='$strSID'";
					//echo $sqldiscount;
					$RSdiscount = $DB->query($sqldiscount);
					if($RSdiscount->num_rows > 0) 
					{
						while($rowdiscount = $RSdiscount->fetch_assoc())
						{
							$strOfferAmount = $rowdiscount["OfferAmount"];
							$strDiscountAmount = $rowdiscount["MemberShipAmount"];
	
							
							if($strOfferAmount=="0")
							{
								$FinalDAmount = $strDiscountAmount;
							}
							elseif($strDiscountAmount=="0")
							{
								$FinalDAmount = $strOfferAmount;
							}
						}
					}
					else
					{
						$FinalDAmount = "0";
					}
					
					$Sale = $strSAmount - $FinalDAmount;
					//echo $Sale."<br>";
					$TotalSale += $Sale;
										
				}
			}
			else
			{
				$TotalSale = "0.00";
			}
		//echo "<hr>";

?>																			
							<tr id="my_data_tr_<?=$counter?>">
								<td><?=$strEID?></td>
								<td><?=$strEmployeeName?></td>
								<td><?=$strEmployeeEmailID?></td>
								<td><?=$strEmployeeMobileNo?></td>
								<td><?=$storename?></td>	
								<td><?=$strEmpPercentage?> %</td>	
								<td>Rs.<?=$TotalSale?>/-</td>	
								<td>Rs<?=$strBaseTarget?>/-</td>	
							</tr>
<?
	}
}
else
{
?>				
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td>No Employees</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
<?php															
}
			echo "</tbody></table><br><br>";

?>
<?php
										}
										
?>										
										




														<?php
														}	
														else
														{
															echo "<br><center><h3>Please select dates!</h3></center>";
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