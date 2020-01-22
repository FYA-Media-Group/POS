<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Employee Commission Report | Nailspa";
	$strDisplayTitle = "Employee Commission of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "";
	$strMyTableID = "";
	$strMyField = "";
	$strMyActionPage = "EmployeeCommission2.php";
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
										
													<div class="form-group"><label for="" class="col-sm-4 control-label">Select Store</label>
														<div class="col-sm-4">
															<select class="form-control required"  name="EID">
																<option value="0" selected>All</option>
																<?php
																 $selp=select("*","tblEmployees","Status='0'");
																	foreach($selp as $val)
																	{
																		$EIDD = $val["EID"];
																		$EMPNAME = $val["EmployeeName"];
																		$EID=$_GET["EID"];
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
																			?>
																		<option value="<?=$EIDD?>"><?=$EMPNAME?></option>														
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
														<a class="btn btn-link" href="EmployeeCommission2.php">Clear All Filter</a> &nbsp;&nbsp;&nbsp;
												<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
													</div>
												
												</form>
												
												
												<div class="example-box-wrapper">
												<?php
												$EID=$_GET["EID"];
											
												if(isset($_GET["toandfrom"]) )
												{
													$EID=$_GET["EID"];
													if($EID=='0')
													{
														$emp_id='All';
													}
													else{
													$selpT=select("*","tblEmployees","EID='".$emp_id."'");
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
$EmployeeID=$_GET["EID"];
if(!empty($EmployeeID))
{
	$sql = "select EID, EmployeeName, EmployeeEmailID, EmpPercentage, EmployeeMobileNo from tblEmployees where Status='0' and EID='".$EmployeeID."'";



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

		?>
		<div id="printdata">			
		<?php
		echo "<b>EmployeeID is :</b> " . $strEID . "<br>";
		echo "<b>Name :</b> " . $strEmployeeName . "<br>";
		echo "<b>Email :</b> " . $strEmployeeEmailID . "<br>";
		echo "<b>Commission Percentage :</b> " . $strEmpPercentage . "<br>";
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
						where tblEmployees.EID='".$strEID."' 
						and tblAppointmentAssignEmployee.AppointmentID!='NULL' 
						and tblInvoiceDetails.OfferDiscountDateTime!='NULL' 
						$sqlTempfrom 
						$sqlTempto 
						group by tblAppointmentAssignEmployee.AppointmentID,ServiceID,QtyParam";
	
	
			
			$RSdetails = $DB->query($sqldetails);
			if($RSdetails->num_rows > 0) 
			{
				$counter = 0;
				$ComFinal = "";
				$SaleFinal = "";
				$strSID = "";
				$qty = "";
				$strSAmount = "";
				$strAmount = "";
				$strCommission = "";
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
					
					
					if($strCommission=="1")
					{
						$AfterDivideSale = $strSAmount;
					}
					elseif($strCommission=="2")
					{
						
						$AfterDivideSale = ($strSAmount / 2);
					}
					$FinalAfter += $AfterDivideSale;
					
					
					$sql_customer = select("CustomerID,AppointmentDate","tblAppointments","AppointmentID='".$strAID."'");
						
						$CustomerID=$sql_customer[0]['CustomerID'];
						$AppointmentDate=$sql_customer[0]['AppointmentDate'];
						
					    $sql_customers = select("CustomerFullName","tblCustomers","CustomerID='".$CustomerID."'");
						$CustomerFullName=$sql_customers[0]['CustomerFullName'];
					
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
					
						$Sale = $AfterDivideSale - ($FinalDAmount / $qty);
						
						if($FinalDAmount =="")
						{
							$FinalDAmount ="0.00";
						}
						else
						{
						
							$FinalDAmount = $FinalDAmount;
							
						}
						$TotalFinalDAmount += $FinalDAmount;
						
						
						//Calculation
						$CommssionFinal = "";
						
						if($strCommission=="1")
						{
							$CommssionFinal = ($Sale / 100) * 13;
							$strCommissionType = '<span class="bs-label label-success">Alone</span>';
							$DisplaySale = $Sale;
						}
						elseif($strCommission=="2")
						{
							
							$CommssionFinal = ($Sale / 200) * 13;
							$strCommissionType = '<span class="bs-label label-blue-alt">Split</span>';
							$DisplaySale = $Sale/2;
						}
						$ComFinal += $CommssionFinal;
						$SaleFinal += $DisplaySale;
	                   
			            if($strSAmount =="")
						{
							$strSAmount ="0.00";
						}
						else
						{
						
							$strSAmount = $strSAmount;
							
						}
						$TotalstrSAmount += $strSAmount;
						
					 
						
						
						
						// Service Name Yogita query
						$sep=select("ServiceName","tblServices","ServiceID='".$strSID."'");
						$servicename=$sep[0]['ServiceName'];	
						
						// Store Name Yogita query						
						$stpp=select("StoreName","tblStores","StoreID='".$StoreIDd."'");
						$StoreName=$stpp[0]['StoreName'];
						
						$sql_invoice_number = select("InvoiceID","tblInvoice","AppointmentID='".$strAID."'");
						$Invoice_Number=$sql_invoice_number[0]['InvoiceID'];
					
?>
							<tr id="my_data_tr_<?=$counter?>">
							
								<td>#<?=$Invoice_Number?></td>
								<td><?=$StoreName?></td>
								<td><?=$CustomerFullName?></td>
								<td><?=date("d/m/Y", strtotime($AppointmentDate));?></td>
								<td><?=$servicename?></td>
								<td>Rs.<?=$strAmount?>/-</td>
								<td>Rs.<?=$AfterDivideSale?>/-</td>
								<td>Rs.<?=$FinalDAmount?>/-</td>
								<td>Rs.<?=$DisplaySale?>/-</td>
								<td>Rs.<?=$CommssionFinal?>/-</td>	
								<td><font color="red"><?=$strCommissionType?></font></td>	
							</tr>
<?php				
				
				}
					?>
					        
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
			echo "</tbody>";
			?>
			                     <tbody>
	                                <tr>
								<td colspan="5"><b><center>Total commission for selected period : </center></b></td>
							    <td><b>Rs.<?=$TotalstrSAmount?>/-</b></td>
								<td><b>Rs.<?=$FinalAfter?>/-</b></td>
								<td><b>Rs.<?=$TotalFinalDAmount?>/-</b></td>
								<td><b>Rs.<?=$SaleFinal?>/-</b></td>
								<td><b>Rs.<?=$ComFinal?>/-</b></td>
								<td></td>
							        </tr>
									</tbody>
			<?php
	}
		
}
}
else
{
	$sept=select("*","tblEmployees","Status='0'");
	foreach($sept as $tty)
	{
		$strEID=$tty['EID'];
        $strEmployeeEmailID = $tty["EmployeeEmailID"];
		$strEmpPercentage = $tty["EmpPercentage"];
		$strEmployeeMobileNo = $tty["EmployeeMobileNo"];
        $strEmployeeName = $tty["EmployeeEmailID"];
	
		?>
		<div id="printdata">			
		<?php
		echo "<b>EmployeeID is :</b> " . $strEID . "<br>";
		echo "<b>Name :</b> " . $strEmployeeName . "<br>";
		echo "<b>Email :</b> " . $strEmployeeEmailID . "<br>";
		echo "<b>Commission Percentage :</b> " . $strEmpPercentage . "<br>";
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
						where tblEmployees.EID='".$strEID."' 
						and tblAppointmentAssignEmployee.AppointmentID!='NULL' 
						and tblInvoiceDetails.OfferDiscountDateTime!='NULL' 
						$sqlTempfrom 
						$sqlTempto 
						group by tblAppointmentAssignEmployee.AppointmentID,ServiceID,QtyParam";
	
	
			
			$RSdetails = $DB->query($sqldetails);
			if($RSdetails->num_rows > 0) 
			{
				$counter = 0;
				$ComFinal = "";
				$SaleFinal = "";
				$strSID = "";
				$qty = "";
				$strSAmount = "";
				$strAmount = "";
				$strCommission = "";
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
					
					
					if($strCommission=="1")
					{
						$AfterDivideSale = $strSAmount;
					}
					elseif($strCommission=="2")
					{
						
						$AfterDivideSale = ($strSAmount / 2);
					}
					$FinalAfter += $AfterDivideSale;
					
					
					$sql_customer = select("CustomerID,AppointmentDate","tblAppointments","AppointmentID='".$strAID."'");
						
						$CustomerID=$sql_customer[0]['CustomerID'];
						$AppointmentDate=$sql_customer[0]['AppointmentDate'];
						
					    $sql_customers = select("CustomerFullName","tblCustomers","CustomerID='".$CustomerID."'");
						$CustomerFullName=$sql_customers[0]['CustomerFullName'];
					
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
					
						$Sale = $AfterDivideSale - ($FinalDAmount / $qty);
						
						if($FinalDAmount =="")
						{
							$FinalDAmount ="0.00";
						}
						else
						{
						
							$FinalDAmount = $FinalDAmount;
							
						}
						$TotalFinalDAmount += $FinalDAmount;
						
						
						//Calculation
						$CommssionFinal = "";
						
						if($strCommission=="1")
						{
							$CommssionFinal = ($Sale / 100) * 13;
							$strCommissionType = '<span class="bs-label label-success">Alone</span>';
							$DisplaySale = $Sale;
						}
						elseif($strCommission=="2")
						{
							
							$CommssionFinal = ($Sale / 200) * 13;
							$strCommissionType = '<span class="bs-label label-blue-alt">Split</span>';
							$DisplaySale = $Sale/2;
						}
						$ComFinal += $CommssionFinal;
						$SaleFinal += $DisplaySale;
	                   
			            if($strSAmount =="")
						{
							$strSAmount ="0.00";
						}
						else
						{
						
							$strSAmount = $strSAmount;
							
						}
						$TotalstrSAmount += $strSAmount;
						
					 
						
						
						
						// Service Name Yogita query
						$sep=select("ServiceName","tblServices","ServiceID='".$strSID."'");
						$servicename=$sep[0]['ServiceName'];	
						
						// Store Name Yogita query						
						$stpp=select("StoreName","tblStores","StoreID='".$StoreIDd."'");
						$StoreName=$stpp[0]['StoreName'];
						
						$sql_invoice_number = select("InvoiceID","tblInvoice","AppointmentID='".$strAID."'");
						$Invoice_Number=$sql_invoice_number[0]['InvoiceID'];
					
?>
							<tr id="my_data_tr_<?=$counter?>">
							
								<td>#<?=$Invoice_Number?></td>
								<td><?=$StoreName?></td>
								<td><?=$CustomerFullName?></td>
								<td><?=date("d/m/Y", strtotime($AppointmentDate));?></td>
								<td><?=$servicename?></td>
								<td>Rs.<?=$strAmount?>/-</td>
								<td>Rs.<?=$AfterDivideSale?>/-</td>
								<td>Rs.<?=$FinalDAmount?>/-</td>
								<td>Rs.<?=$DisplaySale?>/-</td>
								<td>Rs.<?=$CommssionFinal?>/-</td>	
								<td><font color="red"><?=$strCommissionType?></font></td>	
							</tr>
							           
<?php				
				
				}
				?>
	                                <tr>
								<td colspan="5"><b><center>Total commission for selected period : </center></b></td>
							    <td><b>Rs.<?=$TotalstrSAmount?>/-</b></td>
								<td><b>Rs.<?=$FinalAfter?>/-</b></td>
								<td><b>Rs.<?=$TotalFinalDAmount?>/-</b></td>
								<td><b>Rs.<?=$SaleFinal?>/-</b></td>
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
			echo "</tbody>";

		?>
			                     <tbody>
	                                <tr>
								<td colspan="5"><b><center>Total commission for selected period : </center></b></td>
							    <td><b>Rs.<?=$TotalstrSAmount?>/-</b></td>
								<td><b>Rs.<?=$FinalAfter?>/-</b></td>
								<td><b>Rs.<?=$TotalFinalDAmount?>/-</b></td>
								<td><b>Rs.<?=$SaleFinal?>/-</b></td>
								<td><b>Rs.<?=$ComFinal?>/-</b></td>
								<td></td>
							        </tr>
									</tbody>
			<?php

	}
	

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