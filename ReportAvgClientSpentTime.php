<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Average Client Spent Time Report| Nailspa";
	$strDisplayTitle = "Average Client Spent Time Report of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportAvgClientSpentTime.php";
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
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblAppointments.AppointmentDate)<=Date('".$getto."')";
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
			$sqlTempfrom = " and Date(tblAppointments.AppointmentDate)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblAppointments.AppointmentDate)<=Date('".$getto."')";
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
function TimetoInt($val)
{
	$time_array = explode(':', $val);
	$hours = (int)$time_array[0];
	$minutes = (int)$time_array[1];
	$seconds = (int)$time_array[2];
	$total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
	return $total_seconds;
}

if(!isset($_GET["uid"]))
{

?>					
					
                    <div class="panel">
						<div class="panel">
							<div class="panel-body">
							
								
								<div class="example-box-wrapper">
									<div class="tabs">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Clients</h3>
												
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
														<a class="btn btn-link" href="ReportAvgClientSpentTime.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														

													</div>
												
												</form>
												
												<br>
												<?php
													if($_GET["toandfrom"]!="")
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
													<table id="printdata" class="table table-bordered table-striped table-condensed cf">
														<thead>
															<tr>
															   <th style="text-align:center">Sr</th>
															   <th style="text-align:center">Customer Visited</th>
															    <th style="text-align:center">Service Category</th>
																<th style="text-align:center">Time Spent</th>
																<!--<th style="text-align:center">Store</th>-->
																
															</tr>
														</thead>
														
														<tbody>

<?php
$DB = Connect();
$storrr=$_GET["store"];
if(!empty($storrr))
{
$sql="select distinct(tblAppointments.CustomerID), timediff(tblAppointments.AppointmentCheckInTime,tblAppointments.AppointmentCheckOutTime) as spenttime,tblAppointments.AppointmentID
from tblAppointments where tblAppointments.IsDeleted!='1' and tblAppointments.StoreID='".$storrr."' and tblAppointments.AppointmentDate!='NULL' and tblAppointments.Status='2' $sqlTempfrom $sqlTempto";

//echo $sql."<br>";

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	$count=0;
	$FinalTimeOutput = '00:00:00';
	while($row = $RS->fetch_assoc())
	{
			$count++;
			$emppp="";
			$CustomerID = $row["CustomerID"];
			$spenttime = $row["spenttime"];
		    $AppointmentID=$row["AppointmentID"];
		
			$sepmp=select("distinct(ServiceID)","tblAppointmentsDetailsInvoice","AppointmentID='".$AppointmentID."'");
			foreach($sepmp as $vaq)
			{
				$serrvice[]=$vaq['ServiceID'];
			}
		
			$sepmt=select("*","tblCustomers","CustomerID='".$CustomerID."'");
		    $CustomerFullName=$sepmt[0]['CustomerFullName'];
	    
            $spenttimet=str_replace("-", "", $spenttime);
	 
			$secs = strtotime($FinalTimeOutput)-strtotime("00:00:00");
			$FinalTimeOutput = date("H:i:s",strtotime($spenttimet)+$secs);
				
			
	
		?>
		                                                        <tr id="my_data_tr_<?=$count?>">
																<td><center><?=$count?></center></td>
																<td ><center><?=$CustomerFullName?></center></td>
															    <td><center><?php
																for($t=0;$t<count($serrvice);$t++)
																{
																	$sqpq=select("distinct(CategoryID)","tblProductsServices","StoreID='".$storrr."' and ServiceID='".$serrvice[$t]."'");
																	foreach($sqpq as $ca)
																	{
																		$sepmq=select("ServiceName","tblServices","ServiceID='".$serrvice[$t]."'");
																		$sername=$sepmq[0]['ServiceName'];
																		$cit=$ca['CategoryID'];
																		$sepm=select("distinct(CategoryName)","tblCategories","CategoryID='".$cit."'");
																		$catq=$sepm[0]['CategoryName'];
																	
																		echo "<b>Service</b> - ".$sername." <b>Category</b> - " .$catq."<br/>";
																	}
																}
																unset($serrvice);
																
															
																//trim($cats,",")?></center></td>
															<td><center><?=$spenttimet?></center></td>
															</tr>
	
		<?php
		unset($cit);
	}
}
else
{
?>															
															<tr>

																<td></td>
																
																<td></td>
																<td>No Records Found</td>
																<td></td>
																
																<!--<td></td>-->
															</tr>
													
														
<?php
}

}
else
{
	
	$DB = Connect();
   // $count=0;
   $count=0;
	$stpp=select("*","tblStores","Status='0'");
	foreach($stpp as $vapt)
	{
		$sql="select distinct(tblAppointments.CustomerID), timediff(tblAppointments.AppointmentCheckInTime,tblAppointments.AppointmentCheckOutTime) as spenttime,tblAppointments.AppointmentID from tblAppointments where tblAppointments.IsDeleted!='1' and tblAppointments.StoreID='".$vapt['StoreID']."' and tblAppointments.AppointmentDate!='NULL' and tblAppointments.Status='2' $sqlTempfrom $sqlTempto";

//echo $sql."<br>";

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	$FinalTimeOutput = '00:00:00';
	while($row = $RS->fetch_assoc())
	{
			$count++;
			$emppp="";
			$CustomerID = $row["CustomerID"];
			$spenttime = $row["spenttime"];
		    $AppointmentID=$row["AppointmentID"];
		
			$sepmp=select("distinct(ServiceID)","tblAppointmentsDetailsInvoice","AppointmentID='".$AppointmentID."'");
			foreach($sepmp as $vaq)
			{
				$serrvice[]=$vaq['ServiceID'];
				
			}
        	if($spenttime =="")
			{
				$spenttime ="0.00";
			}
			else
			{
			
				$spenttime = $spenttime;
				
			}
			$Totalspenttime += $spenttime;
			
			
			$sepmt=select("*","tblCustomers","CustomerID='".$CustomerID."'");
			$CustomerFullName=$sepmt[0]['CustomerFullName'];
	
			$spenttimet=str_replace("-", "", $spenttime);
 
			$sep=select("*","tblStores","StoreID='".$vapt['StoreID']."'");
			$storename=$sep[0]['StoreName'];
			
			$secs = strtotime($FinalTimeOutput)-strtotime("00:00:00");
			$FinalTimeOutput = date("H:i:s",strtotime($spenttimet)+$secs);
						
	
		?>
		                                                        <tr id="my_data_tr_<?=$count?>">
																<td><center><?=$count?></center></td>
																<td ><center><?=$CustomerFullName?></center></td>
															    <td><center><?php
																
																for($t=0;$t<count($serrvice);$t++)
																{
																	$sqpq=select("distinct(CategoryID)","tblProductsServices","StoreID='".$vapt['StoreID']."' and ServiceID='".$serrvice[$t]."'");
																	foreach($sqpq as $ca)
																	{
																		$sepmq=select("ServiceName","tblServices","ServiceID='".$serrvice[$t]."'");
																		$sername=$sepmq[0]['ServiceName'];
																		$cit=$ca['CategoryID'];
																		$sepm=select("distinct(CategoryName)","tblCategories","CategoryID='".$cit."'");
																		$catq=$sepm[0]['CategoryName'];
																	
																		echo "<b>Service</b> - ".$sername." <b>Category</b> - " .$catq."<br/>";
																	}
																}
																unset($serrvice);
															
																//trim($cats,",")?></center></td>
															<td><center><?=$spenttimet?></center></td>
															    <!--<td><center><?=$storename?></center></td>-->
															</tr>
															</tbody>
															
	
		<?php
		unset($cit);
	}
	$cats="";
}

	}
		unset($stpp);
$cats="";
}


$DB->close();
?>
														
													
														
														
													<tbody>
															<tr>
															<td colspan="1"><center><b><?=$count?></b></center></td>
															<td></td>
															<td>
																<?php
																	$AverageTime = TimetoInt($FinalTimeOutput) / $count;
																	echo '<center><b><font color="green">Average Time Spent : '.gmdate("H:i:s", $AverageTime).'</font></b></center>';
																?>
															</td>
															<td class="numeric"><center><b><?=$FinalTimeOutput;?></b></center></td>
															
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