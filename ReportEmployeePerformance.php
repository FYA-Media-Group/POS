<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Employee Performance Report | Nailspa";
	$strDisplayTitle = "Employee Performance Report of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportEmployeePerformance.php";
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
			$sqlTempfrom1 = " and Date(tblAppointments.AppointmentDate)>=Date('".$getfrom."')";
			$sqlTempfrom2 = " and Date(tblCustomers.RegDate)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$getto."')";
			$sqlTempto1 = " and Date(tblAppointments.AppointmentDate)<=Date('".$getto."')";
			$sqlTempto2 = " and Date(tblCustomers.RegDate)<=Date('".$getto."')";
		}
	}


	if(isset($_GET["store"]))
	{
		$store = $_GET["store"];
		
		if(!IsNull($store))
		{
			$sqlstore = " AND tblEmployees.StoreID='".$store."'";
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
				
                    <div class="panel">
						<div class="panel">
							<div class="panel-body" style="overflow-x: scroll;">
							
								
								<div class="example-box-wrapper">
								<div class="scroll-columns">
									<div class="tabs">
										
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">Employee Performance</h3>
												
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
													<div class="form-group"><label for="" class="col-sm-4 control-label">Select Employee</label>
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
													</div>
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportEmployeePerformance.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
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
												
												<br>
												<div id="printdata">	
												<?php
												$dtype=$_GET["discounttype"];
												$per=$_GET["per"];
												$datedrom=$_GET["toandfrom"];
													if($datedrom!="")
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
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store - <?=$emp_id?></h3>
												
											<br>
												
												
												<div class="example-box-wrapper">
													<table  class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
															    
																<th style="text-align:center">Employee Name</th>
																<th style="text-align:center">Total Sale</th>
																<th style="text-align:center">Service Category Wise</th>
																<th style="text-align:center">Service Count</th>
																<th style="text-align:center">Avg Service Time</th>
																
																<th style="text-align:center">New Customer Count</th>
																<th style="text-align:center">New Repeat Customer Count</th>
																<th style="text-align:center">Total Customer</th>
																	<?php
																	if($per!='0')
																	{
																		?>
																<th style="text-align:center">New Customer %</th>
																<?php
																	}
																?>
																
																	<?php
																	if($per!='0')
																	{
																		?>
																<th style="text-align:center">New Repeat Customer %</th>
																<?php
																	}
																?>
															  
															
																<th style="text-align:center">Attendance Present Count</th>
																<th style="text-align:center">Salary Cost as per attendance</th>
																<th style="text-align:center">Comm Cost</th>
																<th style="text-align:center">Product Cost</th>
																<th style="text-align:center">Free Service Count</th>
																<th style="text-align:center">ARPU</th>
																<th style="text-align:center">Emp Rating</th>
															</tr>
														</thead>
														
														<tbody>

<?php
$DB = Connect();
$per=$_GET["per"];
$EmployeeID=$_GET["store"];
if(!empty($EmployeeID))
{
	$sql = "select EID, EmployeeName, EmployeeEmailID, EmpPercentage, EmployeeMobileNo,EmployeeCode,StoreID from tblEmployees where Status='0' and EID='".$EmployeeID."'";
}
else
{
	$sql = "select EID, EmployeeName, EmployeeEmailID, EmpPercentage, EmployeeMobileNo,EmployeeCode,StoreID from tblEmployees where Status='0'";
}

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;
    $cntattemp = 0;
	while($row = $RS->fetch_assoc())
	{
		// echo "Hello";
		$CNTp="";
		$strEID = $row["EID"];
		$strEmployeeName = $row["EmployeeName"];
		$strEmployeeName = $row["EmployeeName"];
		$strEmployeeEmailID = $row["EmployeeEmailID"];
		$strEmpPercentage = $row["EmpPercentage"];
		$strEmployeeMobileNo = $row["EmployeeMobileNo"];
		$EmployeeCode = $row["EmployeeCode"];
		$monthNum=date("m", strtotime($getfrom));
		$monthNum1=date("m", strtotime($getto));
		
		$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
		$monthName1 = date("F", mktime(0, 0, 0, $monthNum1, 10));
        $finalmonth=$monthName.",".$monthName1;
	    $attm=explode(",",$finalmonth);
		$attancemon=array_unique($attm);
		
		for($i=0;$i<count($attancemon);$i++)
		{
			$stutrq=select("Data","tblAttendanceRecord","EmployeeCode='".$EmployeeCode."' and LeavesThisMonth='' and RecordMonth='".$attancemon[$i]."'");
			foreach($stutrq as $vt)
			{
				$CNTSER=$vt['Data'];
				$cntatt=explode(",",$CNTSER);
			    if(!empty($cntatt))
				{
					$cntattemp++;
				}
				
			}
			
		
			
		}
		unset($attancemon);
		$StoreID = $row["StoreID"];
	    $counter ++;
			
							$cntFreeService="SELECT COUNT( tblAppointmentAssignEmployee.FreeService ) AS FreeService FROM tblAppointmentAssignEmployee LEFT JOIN tblAppointments ON tblAppointments.AppointmentID = tblAppointmentAssignEmployee.AppointmentID WHERE tblAppointmentAssignEmployee.FreeService =  '1' AND tblAppointmentAssignEmployee.MECID ='$strEID' $sqlTempfrom1 $sqlTempto1 ";
									// echo $cntFreeService."<br>";
									$RSFREE = $DB->query($cntFreeService);
									if ($RSFREE->num_rows > 0) 
									{
										$cnt = 0;
										while($rowFree = $RSFREE->fetch_assoc())
										{
											
											$cnt++;
											$FreeServicecount = $rowFree["FreeService"];
											// echo $FreeServicecount;
										}
									}
						
						$NewCustomersonEachStore="Select tblCustomers.CustomerID as NewCustomersPerDay, tblAppointments.AppointmentID from tblCustomers Left Join tblAppointments ON tblCustomers.CustomerID=tblAppointments.CustomerID where tblAppointments.StoreID='$storrr' $sqlTempfrom2 $sqlTempto2 ";
						// echo $NewCustomersonEachStore."<br>";
							$RSCust= $DB->query($NewCustomersonEachStore);
							if($RSCust->num_rows>0)
							{
								// echo "In if<br>";
								while($ROCust=$RSCust->fetch_assoc())
								{
									$NewCustomersPerDay = $ROCust["NewCustomersPerDay"];
									$NewCustomersAppointmentID = $ROCust["AppointmentID"];
									if($NewCustomersPerDay=="")
									{
										$NewCustomersPerDay='0';
									}
								}
							}
							
							
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
					
					$cnttcntser=0;
					$strEIDa = $rowdetails["EID"];
				    $strAID = $rowdetails["AppointmentID"];
					$strSID = $rowdetails["ServiceID"];
					$qty = $rowdetails["Qty"];
					$strAmount = $rowdetails["ServiceAmount"];
					$strSAmount = $strAmount;
					$strCommission = $rowdetails["Commission"];
					$StoreIDd = $rowdetails["StoreID"];
					$stutrqe=select("distinct(ServiceID)","tblAppointmentAssignEmployee","AppointmentID='".$strAID."' and MECID='".$strEID."'");
					foreach($stutrqe as $sqr)
					{
						$seep[]=$sqr['ServiceID'];
					}
					$sey=array_unique($seep);
					
				
		
					//echo $cnttcntser;
					$strTotalAmount += $strSAmount;  //Total of Service sale amount
					
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
					$ComFinal += $CommssionFinal;	
					
					$sqlservicet = "SELECT distinct(ProductID) FROM tblProductsServices WHERE tblProductsServices.StoreID='".$StoreID."' and tblProductsServices.ServiceID='$strSID'";
				//	echo $sqlservicet;
						$RSdiscountt = $DB->query($sqlservicet);
					
						if ($RSdiscountt->num_rows > 0) 
						{
							while($rowdiscountt = $RSdiscountt->fetch_assoc())
							{
								
								$ProductID[]=$rowdiscountt['ProductID'];
								
						
							}
						}
						else
						{
							
						}
				
					
						$sqldata3 = "Select Avg(Time)as Timing,ServiceCost from tblServices where ServiceID='".$strSID."'";
						// echo $sqldata3."<br>";
						
                        $RSdiscounttss = $DB->query($sqldata3);
                        if ($RSdiscounttss->num_rows > 0)
                        {
                            while($rowdiscounttss = $RSdiscounttss->fetch_assoc())
                            {
                                $AVGTime = $rowdiscounttss["Timing"];
								$ServiceCost = $rowdiscounttss["ServiceCost"];
                                // $AVGTime1 = Count($rowdiscounttss["Timing"]);
								$FinalAvgTime +=$AVGTime;
								// $FinalAvgTime +=$AVGTime/$AVGTime1;
								$FinalAMount +=$ServiceCost;
                            }
                        }
                        else
                        {
                            $FinalAMount=0;
                        }
						
					//$Finally=Round($FinalAvgTime/$strSID);
				}
				//$CNTpt=$CNTpt+$CNTp;
			}
			 $sqldetailsd=newcustomercount12($getfrom,$getto,$strEID);
			  foreach($sqldetailsd as $vat)
		    {
			$app[]=$vat['AppointmentID'];
			$custcnt=count($app);
			if($custcnt=='' || $custcnt=='0')
			{
				$custcnt=0;
			}
		    }
		   unset($app);
		   
		   $stu1=newcustomerrepeat($getfrom,$getto,$strEID);
			 
			
		
					//print_r($ProductID);
				foreach($ProductID as $valt)
				{
				
						$sqldata1 = "SELECT * FROM tblNewProducts WHERE ProductID='".$valt."'";
					
						$RSdiscountt = $DB->query($sqldata1);
					
						if ($RSdiscountt->num_rows > 0) 
						{
							while($rowdiscountt = $RSdiscountt->fetch_assoc())
							{
								
								$ProductMRPs = $rowdiscountt["ProductMRP"];
								$PerQtyServes = $rowdiscountt["PerQtyServe"];
								$product_cost +=$ProductMRPs/$PerQtyServes;
								$tpcost = round($product_cost);
						
							}
						}
						else
						{
							$product_cost="0";
						}
				
					
					
				}
				
				unset($ProductID);
		        unset($strServiceID);	
				

				if($ARPU=='')
				{
					$ARPU=0;
				}
				
				if($tpcost=='')
				{
					$tpcost=0;
				}
				
			  if($strSAmount=='')
			  {
				  $strSAmount=0;
			  }
			  if($qty=="")
			  {
				  $qty=0;
			  }
			  if($strSAmount=="")
			 {
				$strSAmount=0;
				
			 }
			 else
			 {
				 $strSAmount=$strSAmount;
			 }
			 $totalstrServiceAmount=$totalstrServiceAmount+$strSAmount;
			  if($qty=="")
			 {
				$qty=0;
				
			 }
			 else
			 {
				 $qty=$qty;
			 }
			 
			 $totalstrqty=$totalstrqty+$qty;
			  if($tpcost=="")
			 {
				$tpcost=0;
				
			 }
			 else
			 {
				 $tpcost=$tpcost;
			 }
			 $totaltpcost=$totaltpcost+$tpcost;
		
			
							
			$stu=select("distinct(CustomerID)","tblCustomers","Date(RegDate)>=Date('".$getfrom."') and Date(RegDate)<=Date('".$getto."')");
				  foreach($stu as $vqr)
				 {
					 $newcustt[]=$vqr['CustomerID'];
				 }
		       
					 for($t=0;$t<count($newcustt);$t++)
					 {
						 
						 $stu=select("count(distinct(tblAppointments.AppointmentID)) as newcust","tblAppointments left join tblAppointmentAssignEmployee on tblAppointmentAssignEmployee.AppointmentID=tblAppointments.AppointmentID left join tblCustomers on tblCustomers.CustomerID=tblAppointments.CustomerID","tblAppointments.IsDeleted!='1' and tblAppointmentAssignEmployee.MECID='".$EID."' and tblAppointments.CustomerID='".$newcustt[$t]."' and tblAppointments.Status =  '2' AND tblAppointments.FreeService !=  '1' $sqlTempfrom1 $sqlTempto1 $sqlTempfrom2 $sqlTempto2");
					   $newrepeatcust=$stu[0]['newcust'];
					 
					 }
					unset($newcustt);
					
				   $seyr=array_unique($sey);
				   $seyrp=array_values($seyr);
				 	                                  for($t=0;$t<count($seyrp);$t++)
																	{
																		//$qty="";
																	 $stutrq=select("distinct(CategoryID)","tblProductsServices","ServiceID='".$seyrp[$t]."' and StoreID='".$StoreID."'");
																		foreach($stutrq as $cat)
																		{
																			$catp[]=$cat['CategoryID'];
																			//$stutrqty="select tblAppointmentAssignEmployee.Qty from tblAppointments left join tblAppointmentAssignEmployee on tblAppointmentAssignEmployee.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices on tblProductsServices.ServiceID=tblAppointmentAssignEmployee.ServiceID and tblProductsServices.StoreID=tblAppointments.StoreID where tblProductsServices.ServiceID='".$seyrp[$t]."' and tblAppointments.IsDeleted!='1' and tblAppointmentAssignEmployee.MECID='".$EID."' $sqlTempfrom1 $sqlTempto1 group by tblAppointmentAssignEmployee.ServiceID";
																			 
																		}	
																		
																	$stutrqqty="select distinct(tblAppointmentAssignEmployee.Qty) from tblAppointments left join tblAppointmentAssignEmployee on tblAppointmentAssignEmployee.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices on tblProductsServices.ServiceID=tblAppointmentAssignEmployee.ServiceID where tblAppointments.IsDeleted!='1' and tblAppointmentAssignEmployee.MECID='".$EID."' and tblAppointments.Status =  '2' AND tblAppointments.FreeService !=  '1' $sqlTempfrom1 $sqlTempto1 and tblAppointmentAssignEmployee.ServiceID='".$seyrp[$t]."' and tblProductsServices.CategoryID='".$cat['CategoryID']."' and tblProductsServices.StoreID='".$StoreID."' group by tblProductsServices.CategoryID";	
																	
																	$RSdiscounttssty = $DB->query($stutrqqty);
																	if ($RSdiscounttssty->num_rows > 0)
																	{
																		while($rowdiscounttsst = $RSdiscounttssty->fetch_assoc())
																		{
																			$qty =$rowdiscounttsst['Qty'];
																			$qty1=$qty1+$qty;
																			
																		}
																	}
																	//$qty=$stutrqqty[0]['SUMQTY'];
	                                                              }
																 
					                                     
														 
				$catq=array_unique($catp);
		        $caty=array_values($catq);
			
				$strqt=array_unique($stutrqty1);
				$strqtq=array_values($strqt);
			
			if($strprofit=="")
			 {
				$strprofit=0;
				
			 }
			 else
			 {
				 $strprofit=$strprofit;
			 }
			 $totalstrprofit=$totalstrprofit+$strprofit;
			    
		  $newclientper=($custcnt/$qty1)*100;
          
	?>
															<tr id="my_data_tr_<?=$counter?>">
																
																<td><center><?=$EmployeeName?></center></td>
																<td><center>Rs. <?=$TotalUltimateSale?>/-</center></td>
																<td><center><?php
															          // print_r($seyrp);
																		for($p=0;$p<count($caty);$p++)
																	   {
																		  $qty3=0;
																		$stutrqtpu=select("CategoryName","tblCategories","CategoryID='".$caty[$p]."'");
															            $catname=$stutrqtpu[0]['CategoryName'];
												                        	  
                                                                    for($t=0;$t<count($seyrp);$t++)
																	   {
																		   
																	   $stutrqty="select tblAppointmentAssignEmployee.Qty from tblAppointments left join tblAppointmentAssignEmployee on tblAppointmentAssignEmployee.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices on tblProductsServices.ServiceID=tblAppointmentAssignEmployee.ServiceID where tblProductsServices.ServiceID='".$seyrp[$t]."' and tblAppointments.IsDeleted!='1' and tblAppointmentAssignEmployee.MECID='".$EID."' $sqlTempfrom1 $sqlTempto1 and tblProductsServices.CategoryID='".$caty[$p]."' and tblProductsServices.StoreID='".$StoreID."' group by tblProductsServices.CategoryID";
																	  // echo $stutrqty;
																		$RSstutrqty = $DB->query($stutrqty);
																		if ($RSstutrqty->num_rows > 0)
																		{
																			
																			
																			while($rowstutrqty = $RSstutrqty->fetch_assoc())
																			{
																				
																				$qty2 = $rowstutrqty['Qty'];
																				
																				$qty3 +=$qty2;
																				
																			}
																			 
																		}
																	   }
																	  
																	    
																		 echo $catname."-".$qty3."<br/>";
																		
																	   }
																																	   
																	 unset($seyrp);
																	 unset($caty);
																	 $qty3="";												
																	
															?></center></td>
															<td><center><?php
															
															echo $qty1;
															
															?></center></td>
																<td><center>
																<?php
																if($FinalAvgTime=='')
																{
																	echo $FinalAvgTime='0'.".min";
																}
																else
																{
																	echo $FinalAvgTime.".min";
																}
																?>
																
																</center></td>
																<td><center><?php
																
																if($custcnt=='')
																{
																	echo $custcnt=0;
																}
																else
																{
																	echo $custcnt;
																}
																
																
																?></center></td>
															<td><center><?php
																$cntsncust=0;
																 foreach($stu1 as $vqt)
																 {
																	 $newc=$vqt['newcust'];
																	 $stu2=newcustomerrepeatcount($getfrom,$getto,$strEID,$newc);
																	 $newcoldqt=$stu2[0]['newcustcnt'];
																	
																	if($newcoldqt!='0')
																	 {
                                                                       																	 
																     if($newcoldqt>3)
																		 {
																			$cntsncust++;
																			$cntsncust;
																		 }
																		
																	 } 
																	
																 } 
															echo $cntsncust;
															
															$totalcustss=$cntsncust+$custcnt;
															$newclientper=($custcnt/$totalcustss)*100;
															$exclientper=($cntsncust/$totalcustss)*100;
																?></center></td>
														<td><center><?=round($totalcustss,2)?></center></td>
																 <?php
																if($per!='0')
																	{
																	?>
										<td class="numeric" id="percol2" ><center><?=round($newclientper,2)?></center></td>
																	<?php
																	}
																	?>
														
																 <?php
																if($per!='0')
																	{
																	?>
										<td class="numeric" id="percol2" ><center><?=round($exclientper,2)?></center></td>
																	<?php
																	}
																	?>
																<td><center><?=round($cntattemp)/2?> Days</center></td>
																<td><center>--</center></td>
																<td><center>Rs. <?=$ComFinal?>/-</center></td>
																<td><center><?=$tpcost?></center></td>
																<td><center><?=$FreeServicecount?></center></td>
																<td><center><?php
																
																	
																	if($strSAmount!='0' && $strSAmount!='')
																	{
																		$strprofit = ($strSAmount) - ($tpcost);
																		//$ARPU = ($strprofit) / ($qty);
																		$ARPU=$TotalUltimateSale/$qty1;
																	}
																	else
																	{
																		
																		$strSAmount=0;
																		$strprofit = 0;
																		//$ARPU = ($strprofit) / ($qty);
																		$ARPU=$TotalUltimateSale/$qty1;
																	}
															   if($ARPU=="")
																 {
																	 $ARPU=0;
																 }
																 else
																 {
																	  $ARPU=$ARPU;
																 }
																 $totalARPU=$totalARPU+$ARPU;	
																													
																
																echo round($ARPU)?></center></td>
																<td class="numeric"><center>--</center></td>
															
																
															</tr>
	<?php
			$ComFinal="";
			$SaleFinal="";
			$tpcost="";
			$tpTime="";
	       // $CNTp="";
		$qty="";
		$Sale="";
		$custcnt="";
		$FinalPPrice="";
		$FinalPPrices="";
		$newrepeatcust="";
		// $SaleFinal="";
       $qty3="";
	}
	unset($caty);
	$cnttcntser="";
	unset($seyrp);
	unset($caty);
	
}
else
{
?>															
															<tr>
															
																<td></td>
																<td></td>
																<td>No Records Found</td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
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
														}	
														else
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
                    </div>

            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>