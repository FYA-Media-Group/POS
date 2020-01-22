<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Employee Commission Report | Nailspa";
	$strDisplayTitle = "Employee Commission of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "";
	$strMyTableID = "";
	$strMyField = "";
	$strMyActionPage = "CommissionAnalysisUpdateCumulative.php";
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
<script>
		function printDiv(divName) 
		{
	
		$("#heading").show();
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
												<h3 class="title-hero">Employee Commission Cumulative</h3>
												
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
										
													
                                                   <div class="form-group">
                                                        <label class="col-sm-4 control-label">Select Store</label>
                                                        <div class="col-sm-4">
                                                            <select name="Store" class="form-control" >

<?php
																if($strStore=='0')
																{
																	$strStatement="";
																}
																else
																{
																	$strStatement=" and StoreID='$strStore'";
																}
																   $selp=select("*","tblStores","Status='0' $strStatement");
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
														<a class="btn btn-link" href="CommissionAnalysisUpdateCumulative.php">Clear All Filter</a> &nbsp;&nbsp;&nbsp;
															<?php
														$datedrom=$_GET["toandfrom"];
														if($datedrom!="")
													   {
														   ?>	
														<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
														  <?php
													   }
														?>
													</div>
												
												</form>
												
												<div id="printdata">	
												<h2 class="title-hero" id="heading" style="display:none"><center>Report Employee Commission Cumulative</center></h2>
												<div class="example-box-wrapper">
											<?php
												$EID=$_GET["Store"];
												$datedrom=$_GET["toandfrom"];
												if($datedrom!="")
												{
													$EID=$_GET["Store"];
													if($EID=='0')
													{
														$emp_id='All';
													}
													else
													{
														$selpT=select("*","tblStores","StoreID='".$EID."'");
														$StoreName=$selpT[0]['StoreName'];
														$emp_id=$StoreName;
													}
											?>
												<br>
												
												<span>
												<h3 >Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store - <?=$emp_id?></h3>
												
												</span>		

				<table id="printdata" class="table table-striped table-bordered responsive no-wrap printdata" cellspacing="0" width="100%">
				<?php 
				$per=$_GET["per"];
				?>
					<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Mobile</th>
							<th>Commission Percentage</th>
							<th>Total Sales</th>
							<?php
																	if($per!='0')
																	{
																		?>
																			<th>Sales %</th>
																		<?php
																	}
																		?>
																		
							<th>Commission</th>
						</tr>
					</thead>
					
					<tbody>
												
<?php
$FandFSales = '';
$FandFComm = '';
$per=$_GET["per"];
$DB = Connect();
$EmployeeID=$_GET["Store"];
if($per=="1")
{
$sty = select("EID, EmployeeName, EmployeeEmailID, EmpPercentage, EmployeeMobileNo","tblEmployees","StoreID='".$EmployeeID."'");
foreach($sty as $sq)
{
	
	$sqldetailsqw = "SELECT tblAppointmentAssignEmployee.AppointmentID,
							tblAppointmentAssignEmployee.Qty,
							tblAppointmentAssignEmployee.ServiceID,
							tblAppointmentAssignEmployee.Commission, 
							tblAppointmentAssignEmployee.QtyParam,
							tblInvoiceDetails.OfferDiscountDateTime,tblEmployees.StoreID, 
							(select ServiceAmount from tblAppointmentsDetailsInvoice where AppointmentID=tblAppointmentAssignEmployee.AppointmentID and ServiceID=tblAppointmentAssignEmployee.ServiceID Limit 0,1) as ServiceAmount 
							FROM tblEmployees left join tblAppointmentAssignEmployee on tblEmployees.EID = tblAppointmentAssignEmployee.MECID 
							left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentId= tblAppointmentAssignEmployee.AppointmentID 
							left join tblInvoiceDetails on tblAppointmentAssignEmployee.AppointmentID=tblInvoiceDetails.AppointmentId 
							where tblEmployees.EID='".$sq['EID']."' 
							and tblAppointmentAssignEmployee.AppointmentID!='NULL' 
							and tblInvoiceDetails.OfferDiscountDateTime!='NULL' 
							$sqlTempfrom 
							$sqlTempto 
							group by tblAppointmentAssignEmployee.AppointmentID,ServiceID,QtyParam";
				
				$RSdetailsq = $DB->query($sqldetailsqw);
				if($RSdetailsq->num_rows > 0) 
				{
					while($rowdetailsty = $RSdetailsq->fetch_assoc())
					{
						$FandFSalest="";
						$strEIDa = $rowdetailsty["EID"];
						$strAID = $rowdetailsty["AppointmentID"];
						$strSID = $rowdetailsty["ServiceID"];
						$qty1 = $rowdetailsty["Qty"];
						$strAmount = $rowdetailsty["ServiceAmount"];
						$strSAmountt = $strAmount;
						$strCommissiont = $rowdetailsty["Commission"];
						$StoreIDd = $rowdetailsty["StoreID"];
						
						$strTotalAmount += $strSAmountt;  //Total of Service sale amount
						
						// Service Name Yogita query
						$per=$_GET["per"];
						
						// Store Name Yogita query						
						$stpp=select("StoreName","tblStores","StoreID='".$StoreIDd."'");
						$StoreName=$stpp[0]['StoreName'];
						
						// Invoice no Yogita query
						$sql_invoice_number = select("InvoiceID","tblInvoice","AppointmentID='".$strAID."'");
						$Invoice_Number=$sql_invoice_number[0]['InvoiceID'];
						
						// Customer ID Yogita query
						$sql_customer = select("CustomerID,AppointmentDate","tblAppointments","AppointmentID='".$strAID."'");
						$CustomerID=$sql_customer[0]['CustomerID'];
						$AppointmentDate=$sql_customer[0]['AppointmentDate'];
						
						
						// Customer name Yogita query
						$sql_customers = select("CustomerFullName","tblCustomers","CustomerID='".$CustomerID."'");
						$CustomerFullName=$sql_customers[0]['CustomerFullName'];
						
						
						if($strCommissiont=="1")
						{
							$AfterDivideSalet = $strSAmountt;
							$strCommissionType = '<span class="bs-label label-success">Alone</span>';
						}
						elseif($strCommissiont=="2")
						{
							$AfterDivideSalet = ($strSAmountt / 2);
							$strCommissionType = '<span class="bs-label label-blue-alt">Split</span>';
						}
						$TotalAfterDivideSalet += $AfterDivideSalet;  //Total of Final payment
						
						// discount code
						$sqldiscount ="select OfferAmount, MemberShipAmount from tblAppointmentMembershipDiscount where AppointmentID='$strAID' and ServiceID='$strSID'";
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
						
						$FinalDiscount = $FinalDAmount / $qty1;
						$TotalFinalDiscount += $FinalDiscount;	//Total of discounted amount
					
						  
						$UltimateSale = $AfterDivideSalet - $FinalDiscount;
						$TotalUltimateSale += $UltimateSale;	//Total of discounted amount
						
					
						
						//Calculation for commission
						if($strCommission == "1")
						{
							$CommssionFinal = ($UltimateSale / 100) * $strEmpPercentage;
						}
						elseif($strCommission == "2")
						{
							$CommssionFinal = ($UltimateSale / 200) * $strEmpPercentage;
						}
						
						$ComFinal += $CommssionFinal;	//Total of Commission
						$FandFSalest += $TotalUltimateSale;
				        $FandFComm += $ComFinal;
						
					}
				}
}
}


$sql = "select EID, EmployeeName, EmployeeEmailID, EmpPercentage, EmployeeMobileNo from tblEmployees where StoreID='".$EmployeeID."'";
//echo $sql;


$RS = $DB->query($sql);
if($RS->num_rows > 0) 
{
	while($row = $RS->fetch_assoc())
	{
		$strEID = $row["EID"];
		
		if($strEID=="0")
		{
			// List of managers, HO and Audit whose details need not to be shown
		}
		else
		{
			
			$strEmployeeName = $row["EmployeeName"];
			$strEmployeeEmailID = $row["EmployeeEmailID"];
			$strEmpPercentage = $row["EmpPercentage"];
			$strEmployeeMobileNo = $row["EmployeeMobileNo"];
			
			$TotalAfterDivideSale = '';
			$strTotalAmount = '';
			$TotalFinalDiscount ='';
			$TotalUltimateSale ='';
			$ComFinal ='';
			
			
			$sqldetails = "SELECT tblAppointmentAssignEmployee.AppointmentID,
							tblAppointmentAssignEmployee.Qty,
							tblAppointmentAssignEmployee.ServiceID,
							tblAppointmentAssignEmployee.Commission, 
							tblAppointmentAssignEmployee.QtyParam,
							tblInvoiceDetails.OfferDiscountDateTime,tblEmployees.StoreID, 
							(select ServiceAmount from tblAppointmentsDetailsInvoice where AppointmentID=tblAppointmentAssignEmployee.AppointmentID and ServiceID=tblAppointmentAssignEmployee.ServiceID Limit 0,1) as ServiceAmount 
							FROM tblEmployees left join tblAppointmentAssignEmployee on tblEmployees.EID = tblAppointmentAssignEmployee.MECID 
							left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentId= tblAppointmentAssignEmployee.AppointmentID 
							left join tblInvoiceDetails on tblAppointmentAssignEmployee.AppointmentID=tblInvoiceDetails.AppointmentId 
							where tblEmployees.EID='$strEID' 
							and tblAppointmentAssignEmployee.AppointmentID!='NULL' 
							and tblInvoiceDetails.OfferDiscountDateTime!='NULL' 
							$sqlTempfrom 
							$sqlTempto 
							group by tblAppointmentAssignEmployee.AppointmentID,ServiceID,QtyParam";
				
				$RSdetails = $DB->query($sqldetails);
				if($RSdetails->num_rows > 0) 
				{
					$counter = 0;
					$strSID = "";
					$qty = "";
					$strSAmount = "";
					$strAmount = "";
					$strCommission = "";
					$FinalDAmount = '';
					$FinalDiscount = '';
					$UltimateSale = '';
					$AfterDivideSale = '';
					$CommssionFinal = "";
					
					while($rowdetails = $RSdetails->fetch_assoc())
					{
						$counter ++;
						$strEIDa = $rowdetails["EID"];
						$strAID = $rowdetails["AppointmentID"];
						$strSID = $rowdetails["ServiceID"];
						$qty = $rowdetails["Qty"];
						$strAmount = $rowdetails["ServiceAmount"];
						$strSAmount = $strAmount;
						$strCommission = $rowdetails["Commission"];
						$StoreIDd = $rowdetails["StoreID"];
						
						$strTotalAmount += $strSAmount;  //Total of Service sale amount
						
						// Service Name Yogita query
						$per=$_GET["per"];
						
						// Store Name Yogita query						
						$stpp=select("StoreName","tblStores","StoreID='".$StoreIDd."'");
						$StoreName=$stpp[0]['StoreName'];
						
						// Invoice no Yogita query
						$sql_invoice_number = select("InvoiceID","tblInvoice","AppointmentID='".$strAID."'");
						$Invoice_Number=$sql_invoice_number[0]['InvoiceID'];
						
						// Customer ID Yogita query
						$sql_customer = select("CustomerID,AppointmentDate","tblAppointments","AppointmentID='".$strAID."'");
						$CustomerID=$sql_customer[0]['CustomerID'];
						$AppointmentDate=$sql_customer[0]['AppointmentDate'];
						
						
						// Customer name Yogita query
						$sql_customers = select("CustomerFullName","tblCustomers","CustomerID='".$CustomerID."'");
						$CustomerFullName=$sql_customers[0]['CustomerFullName'];
						
						
						if($strCommission=="1")
						{
							$AfterDivideSale = $strSAmount;
							$strCommissionType = '<span class="bs-label label-success">Alone</span>';
						}
						elseif($strCommission=="2")
						{
							$AfterDivideSale = ($strSAmount / 2);
							$strCommissionType = '<span class="bs-label label-blue-alt">Split</span>';
						}
						$TotalAfterDivideSale += $AfterDivideSale;  //Total of Final payment
						
						// discount code
						$sqldiscount ="select OfferAmount, MemberShipAmount from tblAppointmentMembershipDiscount where AppointmentID='$strAID' and ServiceID='$strSID'";
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
						
						$FinalDiscount = $FinalDAmount / $qty;
						$TotalFinalDiscount += $FinalDiscount;	//Total of discounted amount
						
						  
						$UltimateSale = $AfterDivideSale - $FinalDiscount;
						$TotalUltimateSale += $UltimateSale;	//Total of discounted amount
						
					
						
						//Calculation for commission
						if($strCommission == "1")
						{
							$CommssionFinal = ($UltimateSale / 100) * $strEmpPercentage;
						}
						elseif($strCommission == "2")
						{
							$CommssionFinal = ($UltimateSale / 200) * $strEmpPercentage;
						}
						$ComFinal += $CommssionFinal;	//Total of Commission
						
						
			
					}
				}
				
				else
				{
					$TotalUltimateSale = '0';
					$ComFinal = '0';
				}
				$saleper=($TotalUltimateSale/$FandFSalest)*100;
			   
				$FandFSales += $TotalUltimateSale;
				$FandFComm += $ComFinal;
				$totalsa +=$saleper;
		       

?>																
				
				
					<tr id="my_data_tr_<?=$counter?>">
							
						<td><?=$strEmployeeName?>  <?=$strEID?></td>
						<td><?=$strEmployeeEmailID?></td>
						<td><?=$strEmployeeMobileNo?></td>
						<td><?=$strEmpPercentage?></td>
						<td>Rs. <?=$TotalUltimateSale?> /-</td>
						<?php
																	if($per!='0')
																	{
																		?>
																		<td><?=round($saleper,2)?></td>
																		<?php
																	}
																		?>
						<td>Rs. <?=$ComFinal?> /-</td>
					</tr>
					
					
					
<?php
		}
	}
	$FandFSalest="";
?>
					<tr>
						<td colspan='4'><b><center>Total commission for selected period : </center></b></td>
						<td><b>Rs. <?=$FandFSales?> /-</b></td>
							<?php
																	if($per!='0')
																	{
																		?>
						<td><b><?=$totalsa?></b></td>
							<?php
																	}
																		?>
						
						<td><b>Rs. <?=$FandFComm?> /-</b></td>
					</tr>
<?php	
}
else
{
	echo "No Employees found for this store";
}
$DB->close();
?>
					</tbody>
				</table>
												
										
											<?php
												}
												else
												{
													
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