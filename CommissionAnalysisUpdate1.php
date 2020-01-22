<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Employee Commission Report | Nailspa";
	$strDisplayTitle = "Employee Commission of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "";
	$strMyTableID = "";
	$strMyField = "";
	$strMyActionPage = "CommissionAnalysisUpdate1.php";
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
										
													<div class="form-group"><label for="" class="col-sm-4 control-label">Select Employee to get commission</label>
														<div class="col-sm-4">
															<select class="form-control required"  name="store">
																<?php
																if($strStore=='0')
																{
																	$strStatement="";
																}
																else
																{
																	$strStatement=" and StoreID='$strStore'";
																}
																
																 $selp=select("*","tblEmployees","Status='0' $strStatement");
																	foreach($selp as $val)
																	{
																		$EIDD = $val["EID"];
																		$EMPNAME = $val["EmployeeName"];
																		$EID=$_GET["store"];
																		if($EID==$EIDD)
																		{
																			$selpT=select("*","tblEmployees","EID='".$EID."'");
																			$EmployeeName=$selpT[0]['EmployeeName'];
																			
																			?>
																		  <option  selected value="<?=$EID?>" ><?=$EmployeeName?></option>														
																<?php                   
																		}
																		else
																		{
																			if($EIDD=="35" || $EIDD=="8" || $EIDD=="6" || $EIDD=="34" || $EIDD=="22" || $EIDD=="49" || $EIDD=="43")
																			{
																				// List of managers, HO and Audit whose details need not to be shown
																			}
																			else
																			{
																?>
																				<option value="<?=$EIDD?>"><?=$EMPNAME?></option>
																<?php	
																			}
																	?>
																																
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
														<a class="btn btn-link" href="CommissionAnalysisUpdate1.php">Clear All Filter</a> &nbsp;&nbsp;&nbsp;
												<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
													</div>
												
												</form>
												
												
												<div class="example-box-wrapper">
												<?php
												$EID=$_GET["store"];
											
												if(isset($_GET["toandfrom"]) )
												{
													$EID=$_GET["store"];
													if($EID=='0')
													{
														$emp_id='All';
													}
													else{
													$selpT=select("*","tblEmployees","EID='".$EID."'");
													$EmployeeName=$selpT[0]['EmployeeName'];
														$emp_id=$EmployeeName;
													}
												?>
												<br><br>
<saif id="kakkabiryani">												
												<span>
												<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Employee Name - <?=$emp_id?></h3>
												
												</span>										
										
<?php

$DB = Connect();
$EmployeeID=$_GET["store"];
if(!empty($EmployeeID))
{
	$sql = "select EID, EmployeeName, EmployeeEmailID, EmpPercentage, EmployeeMobileNo from tblEmployees where Status='0' and EID='".$EmployeeID."'";
}
else
{
	$sql = "select EID, EmployeeName, EmployeeEmailID, EmpPercentage, EmployeeMobileNo from tblEmployees where Status='0'";
}


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
		
		$TotalAfterDivideSale = '';
		$strTotalAmount = '';
		$TotalFinalDiscount ='';
		$TotalUltimateSale ='';
		$ComFinal ='';
		
		?>
		<div id="printdata">			
		<?php
		
		echo "<saif style='float:right'><b>Name :</b> " . $strEmployeeName . "</saif>";
		echo "<b>Email :</b> " . $strEmployeeEmailID . "<br>";
		echo "<saif style='float:right'><b>Commission Percentage :</b> " . $strEmpPercentage . "</saif>";
		echo "<b>Mobile no :</b> " . $strEmployeeMobileNo . "<br>";
		echo "<hr>";

?>																
				<table id="printdata" class="table table-striped table-bordered responsive no-wrap printdata" cellspacing="0" width="100%">
				
					<thead>
						<tr>
							<th># Invoice No</th>
							<th>Store</th>
							<th>Client Name</th>
							<th>Commission Date</th>
							<th>Service(s) Done</th>
							<th>Service Amount</th>
							<th>Final Amount</th>
							<th>Discount</th>
							<th>Total Sales</th>
							<th>Commission Amount</th>
							<th>Commission Type</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th># Invoice No</th>
							<th>Store</th>
							<th>Client Name</th>
							<th>Commission Date</th>
							<th>Service(s) Done</th>
							<th>Service Amount</th>
							<th>Final Amount</th>
							<th>Discount</th>
							<th>Total Sales</th>
							<th>Commission Amount</th>
							<th>Commission Type</th>
						</tr>
					</tfoot>
					<tbody>

<?php	

           $sqldetails ="SELECT tblAppointmentAssignEmployee.AppointmentID,
						tblAppointmentAssignEmployee.Qty,
						tblAppointmentAssignEmployee.ServiceID,
						tblAppointmentAssignEmployee.Commission, 
						tblAppointmentAssignEmployee.QtyParam,
						tblInvoiceDetails.OfferDiscountDateTime,tblEmployees.StoreID,
						tblAppointmentsDetailsInvoice.ServiceAmount
						FROM tblEmployees left join tblAppointmentAssignEmployee on tblEmployees.EID = tblAppointmentAssignEmployee.MECID
						left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.ServiceID=tblAppointmentAssignEmployee.ServiceID
						left join tblInvoiceDetails on tblAppointmentAssignEmployee.AppointmentID=tblInvoiceDetails.AppointmentId 
						where tblEmployees.EID='$strEID' 
						and tblAppointmentsDetailsInvoice.PackageService='0' and tblAppointmentAssignEmployee.AppointmentID!='NULL' 
						and tblInvoiceDetails.OfferDiscountDateTime!='NULL' 
						$sqlTempfrom 
						$sqlTempto group by tblAppointmentAssignEmployee.AppointmentID,ServiceID,QtyParam";
			/* $sqldetails = "SELECT tblAppointmentAssignEmployee.AppointmentID,
						tblAppointmentAssignEmployee.Qty,
						tblAppointmentAssignEmployee.ServiceID,
						tblAppointmentAssignEmployee.Commission, 
						tblAppointmentAssignEmployee.QtyParam,
						tblInvoiceDetails.OfferDiscountDateTime,tblEmployees.StoreID,
						(select ServiceAmount from tblAppointmentsDetailsInvoice where AppointmentID=tblAppointmentAssignEmployee.AppointmentID and ServiceID=tblAppointmentAssignEmployee.ServiceID Limit 0,1) as ServiceAmount 
						FROM tblEmployees left join tblAppointmentAssignEmployee on tblEmployees.EID = tblAppointmentAssignEmployee.MECID 
						left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentID= tblAppointmentAssignEmployee.AppointmentID 
						right join tblInvoiceDetails on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID 
						where tblEmployees.EID='$strEID' 
						and tblAppointmentAssignEmployee.AppointmentID!='NULL' 
						and tblInvoiceDetails.OfferDiscountDateTime!='NULL' 
						$sqlTempfrom 
						$sqlTempto 
						group by tblAppointmentAssignEmployee.AppointmentID,ServiceID,QtyParam";
	 */
	echo $sqldetails;
			if($_SERVER['REMOTE_ADDR']=="111.119.219.70")
			{
				//echo $sqldetails;
			}
			else
			{
				
			}
			
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
					$sep=select("ServiceName","tblServices","ServiceID='".$strSID."'");
					$servicename=$sep[0]['ServiceName'];	
					
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
					
?>
							<tr id="my_data_tr_<?=$counter?>">
							
								<td>#<?=$Invoice_Number?></td>
								<td><?=$StoreName?></td>
								<td><?=$CustomerFullName?></td>
								<td><?=date("d/m/Y", strtotime($AppointmentDate));?></td>
								<td><?=$servicename?></td>
								<td>Rs.<?=$strAmount?>/-</td>
								<td>Rs.<?=$AfterDivideSale?>/-</td>
								<td>Rs.<?=$FinalDiscount?>/-</td>
								<td>Rs.<?=$UltimateSale?>/-</td>
								<td>Rs.<?=$CommssionFinal?>/-</td>	
								<td><font color="red"><?=$strCommissionType?></font></td>	
							</tr>
<?php				
				
				}
	?>
							<tr>
								<td colspan="5"><b><center>Total commission for selected period : </center></b></td>
							
								<td><b>Rs.<?=$strTotalAmount?>/-</b></td>
								<td><b>Rs.<?=$TotalAfterDivideSale?>/-</b></td>
								<td><b>Rs.<?=$TotalFinalDiscount?></b></td>
								<td><b>Rs.<?=$TotalUltimateSale?>/-</b></td>
								<td><b>Rs.<?=$ComFinal?>/-</b></td>
								<td></td>
							</tr>
	<?php
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
								<td></td>
								<td>No Services Done by this Employee in selected time period</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
<?php															
			}
			echo "</tbody></table></div><br><br>";
	}
		
}
else
{
	echo "No Employees found for this store";
}
$DB->close();
?>
														<?php
														}	
													else
														{
															echo "<br><center><h3>Please Select Month And Year!</h3></center>";
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