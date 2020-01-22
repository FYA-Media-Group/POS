<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Customer Retention Report| Nailspa";
	$strDisplayTitle = "Customer Retention Report of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportCustomerRetention.php";
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
			$sqlTempfrom = " and Date(tblAppointments.AppointmentDate)>=Date('".$getfrom."')";
			$sqlTempfrom1 = " and Date(tblCustomers.RegDate)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblAppointments.AppointmentDate)<=Date('".$getto."')";
			$sqlTempto1 = " and Date(tblCustomers.RegDate)<=Date('".$getto."')";
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
			
			$("#store").change(function()
			{
				var store=$(this).val();
				$.ajax({
				type:"post",
                url:"changeemployee.php",
                data:"store="+store,
				success:function(res)
				{
					
					$("#emp").html("");
				
					$("#emp").html(res);
				}
				
					
					
				});
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
							<div class="panel-body">
							
								
								<div class="example-box-wrapper">
									<div class="tabs">
										
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
											
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
														<a class="btn btn-link" href="ReportCustomerRetentionAnalysis.php">Clear All Filter</a>
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
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Employee Name - <?=$emp_id?></h3>
												
														<br>
												
												
												<div class="example-box-wrapper">
													<table class="table table-bordered table-striped table-condensed cf" width="100%">
													<?php
													if($store!="0")
													{
														?>
														<thead>
															<tr>
															    <th style="text-align:center">Sr</th>
																<th style="text-align:center">Employee Name</th>
																<th style="text-align:center">New Walkin Count</th>
																<th style="text-align:center">Recurred customers count</th>
																<th style="text-align:center">Existing customers count</th>
																<th style="text-align:center">Reacquired customers count</th>
																	<?php
																	if($per!='0')
																	{
																		?>
																<th style="text-align:center">Total Count</th>
																<?php
																	}
																?>
																<?php
																	if($per!='0')
																	{
																		?>
																<th style="text-align:center">New Walkin %</th>
																<?php
																	}
																?>
																<?php
																	if($per!='0')
																	{
																		?>
																<th style="text-align:center">Recurred customers %</th>
																<?php
																	}
																?>
																	<?php
																	if($per!='0')
																	{
																		?>
																<th style="text-align:center">Existing customers %</th>
																<?php
																	}
																?>
																<?php
																	if($per!='0')
																	{
																		?>
																<th style="text-align:center">Reacquired customers %</th>
																<?php
																	}
																?>
															</tr>
														</thead>
														
														<?php
													}
													else
													{
														?>
														<thead>
															<tr>
															    <th style="text-align:center">Sr</th>
															    <th style="text-align:center">Employee Name</th>
																<th style="text-align:center">New Walkin Count</th>
																<th style="text-align:center">Recurred customers count</th>
																<th style="text-align:center">Existing customers count</th>
																<th style="text-align:center">Reacquired customers</th>
																<?php
																	if($per!='0')
																	{
																		?>
																<th style="text-align:center">Total Count</th>
																<?php
																	}
																?>
																<?php
																	if($per!='0')
																	{
																		?>
																<th style="text-align:center">New Walkin %</th>
																<?php
																	}
																?>
																<?php
																	if($per!='0')
																	{
																		?>
																<th style="text-align:center">Recurred customers %</th>
																<?php
																	}
																?>
																	<?php
																	if($per!='0')
																	{
																		?>
																<th style="text-align:center">Existing customers %</th>
																<?php
																	}
																?>
																<?php
																	if($per!='0')
																	{
																		?>
																<th style="text-align:center">Reacquired customers %</th>
																<?php
																	}
																?>
																<th style="text-align:center">Store</th>
																
															</tr>
														</thead>
														
														<?php
													}
													?>
														
														<tbody>

<?php
$DB = Connect();
$per=$_GET["per"];
$EmployeeID=$_GET["store"];
if(!empty($EmployeeID))
{
	$sql = "select * from tblEmployees where Status='0' and EID='".$EmployeeID."'";
}
else
{
	$sql = "select * from tblEmployees where Status='0'";
}


$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		
		//$StoreID = $row["StoreID"];
		$EID = $row["EID"];
		$store = $row["StoreID"];
		if($EID=="35" || $EID=="8" || $EID=="6" || $EID=="34" || $EID=="22" || $EID=="29" || $EID=="43" || $EID=="49")
		{
			// List of managers, HO and Audit whose details need not to be shown
		}
		else
		{
			$EID = $row["EID"];
			$counter ++;
		
		$DateTime = FormatDateTime($getfrom);	
		$sep=select("StoreName","tblStores","StoreID='".$store."'");
		$storename=$sep[0]['StoreName'];
		$EmployeeName = $row["EmployeeName"];
	
	//////////////////////////////new customer count////////////////////////////////
	       $sqldetailsd=newcustomercount12($getfrom,$getto,$EID);
		  
			/*  $sqldetailsd=select("DISTINCT(tblAppointments.AppointmentID)","tblCustomers LEFT JOIN tblAppointments ON tblCustomers.CustomerID = tblAppointments.CustomerID LEFT JOIN tblAppointmentAssignEmployee ON tblAppointments.AppointmentID = tblAppointmentAssignEmployee.AppointmentID","tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService != '1' AND tblAppointments.Status =  '2' AND tblAppointmentAssignEmployee.MECID = '".$EID."' $sqlTempfrom1 $sqlTempto1"); */
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
          $stu1=newcustomerrepeat($getfrom,$getto,$EID);
						
		
		/////////////////////////////////old customer count///////////////////////////////
		
		 $sqldetailsy=oldcustomercount($getfrom,$getto,$EID);
		
	/* 
			 $sqldetailsy=select("count(distinct(tblAppointments.AppointmentID)) as oldcustcnt","tblCustomers left join tblAppointments on tblCustomers.CustomerID=tblAppointments.CustomerID left join tblAppointmentAssignEmployee on tblAppointmentAssignEmployee.AppointmentID=tblAppointments.AppointmentID","tblAppointments.IsDeleted!='1' and tblAppointmentAssignEmployee.MECID='".$EID."' and tblAppointmentAssignEmployee.AppointmentID!='NULL' and Date(tblCustomers.RegDate) not between Date('".$getfrom."') and Date('".$getto."') and tblAppointments.Status =  '2'  $sqlTempfrom $sqlTempto");
	         $oldcustcnt=$sqldetailsy[0]['oldcustcnt'];
	
		///////////////////////////////////////new customer repeat count//////////////////////////////////
		
				$stu=select("distinct(CustomerID)","tblCustomers","Date(RegDate)>=Date('".$getfrom."') and Date(RegDate)<=Date('".$getto."')");
				  foreach($stu as $vqr)
				 {
					 $newcustt[]=$vqr['CustomerID'];
				 }
		       
					
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
			  
			$stu=select("distinct(CustomerID)","tblCustomers","Date(RegDate) not between Date('".$getfrom."') and Date('".$getto."')");
				  foreach($stu as $vqr)
				 {
					 $oldcustrepeatcust[]=$vqr['CustomerID'];
				 }
			//print_r($oldcustrepeatcust);
					for($t=0;$t<count($oldcustrepeatcust);$t++)
					 {
						 $sqldetailsdT=select("count(distinct(tblAppointments.AppointmentID)) as olrepeatcust","tblAppointments left join tblAppointmentAssignEmployee on tblAppointmentAssignEmployee.AppointmentID=tblAppointments.AppointmentID left join tblCustomers on tblCustomers.CustomerID=tblAppointments.CustomerID","tblAppointments.IsDeleted!='1' and tblAppointmentAssignEmployee.MECID='".$EID."' and tblAppointments.CustomerID='".$oldcustrepeatcust[$t]."' and tblAppointments.Status =  '2' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto");
						$oldcustrepeatcustt=$sqldetailsdT[0]['olrepeatcust'];
						
					 }
		  unset($oldcustrepeatcust);
			  */
		     
		
		
	?>
															<tr id="my_data_tr_<?=$counter?>">
																<td><center><?=$counter?></center></td>
																
																<td><center><?=$EmployeeName?></center></td>
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
																	 $stu2=newcustomerrepeatcount($getfrom,$getto,$EID,$newc);
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
																?></center></td>
																<td><center><?php 
																$cntsncustold=0;
																 foreach($sqldetailsy as $vqtp)
																 {
																	 $oldcustcntc=$vqtp['oldcustcnt'];
																	 $stu2q=oldcustomer($getfrom,$getto,$EID,$oldcustcntc);
																	 $newcold=$stu2q[0]['oldcustcntq'];
																	
																	if($newcold!='0')
																	 { 
           																 if($newcold>4)
																		 {
																			$cntsncustold++;
																		
																		 }
																		
																		
																	 }
                                                                    
																 } 
																	echo $cntsncustold;
																?></center></td>
																<td><center><?php
															  foreach($sqldetailsy as $vqtp)
																 {
																	 $oldcustcntc=$vqtp['oldcustcnt'];
																	 $stu2qmst=oldcustomerrepeatcnt($getfrom,$getto,$EID,$oldcustcntc);
																	
																	 $maxoldcustcntq=$stu2qmst[0]['maxoldcustcntq'];
																	 $sqldetailsdTy=select("tblAppointments.AppointmentDate","tblAppointments","tblAppointments.AppointmentID='".$maxoldcustcntq."'");
																	 $app_date=$sqldetailsdTy[0]['AppointmentDate'];
																	 $new_date = strtotime(date("Y-m-d", strtotime($app_date)) . " +12 month");
																	 $stu2qmstold=oldcustomerrepeatcnt($app_date,$new_date,$EID,$oldcustcntc);
																	 $newcoldrepeat=$stu2qmstold[0]['oldcustcntq'];
																
																  
																 } 
																
																  if($newcoldrepeat=="")
																	{
																		$newcoldrepeat=0;
																	}
																	echo $newcoldrepeat;
															
																?></center></td>
																<?php 
																$totalcustcount=$custcnt+$cntsncust+$cntsncustold+$newcoldrepeat;
																
																	if($per!='0')
																	{
																		?>
																	<td><center><?php echo $totalcustcount; ?></center></td>
																		<?php
																	}
																	$totalnew=($custcnt/$totalcustcount)*100;
																	if($per!='0')
																	{
																		?>
																	<td><center><?php echo round($totalnew,2); ?></center></td>
																		<?php
																	}
																	$Recurred=($cntsncust/$totalcustcount)*100;
																	if($per!='0')
																	{
																		?>
																	<td><center><?php echo round($Recurred,2); ?></center></td>
																		<?php
																	}
																	$Existing=($cntsncustold/$totalcustcount)*100;
																	if($per!='0')
																	{
																		?>
																	<td><center><?php echo round($Existing,2); ?></center></td>
																		<?php
																	}
																	$Reacquired=($newcoldrepeat/$totalcustcount)*100;
																	if($per!='0')
																	{
																		?>
																	<td><center><?php echo round($Reacquiredm,2); ?></center></td>
																		<?php
																	}
																?>
																
															</tr>
	<?php
		}
		$newrepeatcust="";
        $custcnt="";
		$newrepeatcust="";
		$oldcustcnt="";
		$olrepeatcust="";
		$oldcustrepeatcustt="";
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
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>