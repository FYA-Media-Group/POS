<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Delayed Appointments | Nailspa";
	$strDisplayTitle = "Appointments Delayed Report of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportAppointmentDelayed.php";
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
										
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Appointments Delayed</h3>
												
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
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportAppointmentDelayed.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>

													</div>
														
														
												</form>
												
												<br>
												<div id="printdata">
												<?php
													if(isset($_GET["toandfrom"])&& isset($_GET["store"]))
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
													<table id="printdata" class="table table-striped table-bordered responsive no-wrap printdata" cellspacing="0" width="100%">
														<thead>
															<tr>
															  <th>Sr</th>
																<th><center>Customer Name</center></th>
																<th><center>Delayed Mins (Last)</center></th>
																<th><center>No.Of Delayed Visits</center></th>
														        <th><center>Store</center></th>               
															</tr>
														</thead>
													
														<tbody>

<?php
$DB = Connect();
$storrr=$_GET["store"];

if(!empty($storrr))
{
	$sql="Select AppointmentID,CustomerID,StoreID,AppointmentDate,timediff(AppointmentCheckInTime,SuitableAppointmentTime) as spenttime from tblAppointments where Status=2 and IsDeleted!='1' and StoreID='$storrr' $sqlTempto $sqlTempfrom ";	
}
else
{
  $sql="Select AppointmentID,CustomerID,StoreID,AppointmentDate,timediff(AppointmentCheckInTime,SuitableAppointmentTime) as spenttime from tblAppointments where Status=2 and IsDeleted!='1' $sqlTempto $sqlTempfrom ";
}
// echo $sql;
if($_SERVER['REMOTE_ADDR']=="111.119.219.70")
{
   // echo $sql;
}
else
{
   
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
		
		$spenttime = $row["spenttime"];
		
		$check=strlen($spenttime);
		
		if($check=='9')
		{
			
			$spe=select("count(*)","tblAppointments","Status=2 and IsDeleted!='1' and CustomerID='$CustomerID' $sqlTempfrom $sqlTempto");
			$Selectdelay="Select Count(*) from tblAppointments where Status='2' and IsDeleted!='1' and CustomerID='$CustomerID' $sqlTempfrom $sqlTempto";
			
			// echo $Selectdelay."<br>";
			$cnt=$spe[0]['count(*)'];
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
			$dateObjects = new DateTime($AppointmentCheckInTime);
			$selp=select("StoreName","tblStores","StoreID='".$StoreID."'");
			$StoreName=$selp[0]['StoreName'];
			$newstring=str_replace("-","",$spenttime);
			$totaltpcost=$totaltpcost+$cnt;
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><center><?=$counter?></center></td>
																<td><center><?=$CustomerFullName?></center></td>
																<td><center><?=$newstring?> .min<br><?//=$AppointmentID?></center></td>
																<td><center><?=$cnt?></center></td>
																
																<td><center><?=$StoreName?></center></td>
																
															</tr>
<?php
		}
		else
		{
			
		}
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
																<td colspan="4"><center><b>Total Appointments Delayed in selected periods(s) : <?=$totaltpcost?></b><center></td>
															
																
															</tr>
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