<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
					

<?php
	$strPageTitle = "Manage Stores | Nailspa";
	$strDisplayTitle = "Manage Store Target for Nailspa";
	$strMenuID = "3";
	$strMyTable = "tblStoreSalesTarget";
	$strMyTableID = "STID";
	$strMyField = "Month";
	$strMyActionPage = "ManageStoresTarget.php";
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
			foreach($_POST as $key => $val)
			{
				if($key!="step")
				{
					if(IsNull($sqlColumn))
					{
						$sqlColumn = $key;
						$sqlColumnValues = "'".$_POST[$key]."'";
					}
					else
					{
						$sqlColumn = $sqlColumn.",".$key;
						$sqlColumnValues = $sqlColumnValues.", '".$_POST[$key]."'";
					}
				}	
			}
			
			$strStoreName = Filter($_POST["StoreName"]);
			$strMonth = Filter($_POST["Month"]);
			$strYear = Filter($_POST["Year"]);
			$strTargetAmount = Filter($_POST["TargetAmount"]);
			$strStoreID = Filter($_POST["StoreID"]);
			$strStatus = Filter($_POST["Status"]);
			$Year = Filter($POST["currentYear"]);
			
			
			$DB = Connect();
			$sql = "Select * from $strMyTable where StoreID='$strStoreID' and Month = '$strMonth' and Year = '$strYear'";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						<p>The Target for This month is already set in the system.</p>
					</div>
				</div>');
			}
			else
			{
				 
				$sqlInsert = "Insert into $strMyTable ( Month, Year, TargetAmount, StoreID) Values
				('".$strMonth."', '".$strYear."','".$strTargetAmount."','".$strStoreID."')";
				// echo $sqlInsert;
				// die();
				ExecuteNQ($sqlInsert);
				
				$DB->close();
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
					</div>
				</div>');
			}

		}
		die();
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
                    <script type="text/javascript" src="assets/widgets/timepicker/timepicker.js"></script>
                    <script type="text/javascript">
                        /* Timepicker */

                        $(function() {
                            "use strict";
                            $('.timepicker-example').timepicker();
                        });
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
                        <p>Add and Delete Monthly Target for each Store.</p>
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
											<li><a href="#normal-tabs-1" title="Tab 1">Targets of this Month</a></li>
											<li><a href="#normal-tabs-2" title="Tab 2">All Targets</a></li>
										</ul>
										<div id="normal-tabs-1">
											<div class="alert alert-close alert-success" id="form_result" style="display:none">
												<div class="bg-green alert-icon">
													<i class="glyph-icon icon-check"></i>
												</div>
												<div class="alert-content">
													<h4 class="alert-title">Hurrah!</h4>
													<p>Target Updated Successfully</p>
												</div>
											</div>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Monthly Targets for Nailspa Stores</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Month and Year</th>
																<th>Target</th>
																<th>Store</th>
																		<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
																<th>Action</th>
																<?php 
																	}
																?>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Month and Year</th>
																<th>Target</th>
																<th>Store</th>
															<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
																<th>Action</th>
																<?php 
																	}
																?>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();

$day = date('d');
$Month = date('m');			//$row["Month"];
$MonthSpell = getMonthSpelling($Month);
$Year = 2000 + date('y');			//$row["Year"];
// $MonthYear = $MonthSpell.", ".$Year;

$sql = "SELECT STID, Month, Year, TargetAmount, (SELECT StoreName FROM tblStores WHERE StoreID=tblStoreSalesTarget.StoreID) AS StoreName FROM tblStoreSalesTarget WHERE Month LIKE '$MonthSpell' AND Year='$Year'";
// echo $sql;



// die();
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strSTID = $row["STID"];
		$getUID = EncodeQ($strSTID);
		$getUIDDelete = Encode($strSTID);
		$TargetAmount = $row["TargetAmount"];
		$StoreName = $row["StoreName"];
		
?>														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$MonthSpell?>,&nbsp; <?=$Year?></td>
																<td id="abc">Rs. 
																	<input type="text" id="TargetAmount<?=$strSTID?>" style="border: 0px" value="<?=$TargetAmount?>">
																	<button class="btn btn-link" onClick="UpdateTargetAmount(<?=$strSTID?>);">Update</button>
																	<script>
																		function UpdateTargetAmount(value)
																		{
																			var STID = value;
																			// alert(STID);
																			var TargetAmount = "TargetAmount";
																			var targetID = TargetAmount.concat(STID);
																			var UpdatedTarget = document.getElementById(targetID).value;
																			// alert(UpdatedTarget);
																			
																			$.ajax
																			({
																				type: "POST",
																				url: "UpdateTarget.php?stid="+STID+"&NewTarget="+UpdatedTarget,
																				data: {
																						TargetAmountSend: UpdatedTarget
																				},
																				success: function(response) {
																				   // document.getElementById("form_result").innerHTML = response;
																				   document.getElementById("form_result").style.display = "block";
																			   }
																			});
																			
																		}
																	
															</script>
																</td>
																<td><?=$StoreName?></td>
																
																	<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
																		<td style="text-align: center">
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step10','<?=$getUIDDelete?>', 'Are you sure you want to delete this Store Stock Record - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
																	</td>
																	<?php
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
																<td>No Records Found</td>
																<td></td>
																<td></td>
															</tr>
														
<?php
}
$DB->close();
?>
														
														</tbody>
													</table>
												</div>
											</div>
										</div>
										
										<div id="normal-tabs-2">
											<div class="panel-body">
												<h3 class="title-hero">List of All Targets for Nailspa Stores</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Month and Year</th>
																<th>Target</th>
																<th>Store</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Month and Year</th>
																<th>Target</th>
																<th>Store</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();

$day = date('d');
$Month = date('m');			//$row["Month"];
$MonthSpell = getMonthSpelling($Month);
$Year = 2000 + date('y');			//$row["Year"];
// $MonthYear = $MonthSpell.", ".$Year;

$sql = "SELECT STID, Month, Year, TargetAmount, (SELECT StoreName FROM tblStores WHERE StoreID=tblStoreSalesTarget.StoreID) AS StoreName FROM tblStoreSalesTarget ORDER BY STID DESC";
// echo $sql;
// die();
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strSTID = $row["STID"];
		$getUID = EncodeQ($strSTID);
		$getUIDDelete = Encode($strSTID);
		$TargetAmount = $row["TargetAmount"];
		$Month = $row["Month"];
		$StoreName = $row["StoreName"];
		
?>														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$Month?>,&nbsp; <?=$Year?></td>
																<td id="abc">Rs. <?=$TargetAmount?></td>
																<td><?=$StoreName?></td>
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
																<td>No Records Found</td>
																<td></td>
																<td></td>
															</tr>
														
<?php
}
$DB->close();
?>
														
														</tbody>
													</table>
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
?>						
					
					<div class="panel">
						<div class="panel-body">
							<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="<?=$strMyActionPage?>"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
						
							<div class="panel-body">
							<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email', '.admin_password'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

								
									<h3 class="title-hero">Edit Admin Details</h3>
									<div class="example-box-wrapper">
										
<?php

$strID = DecodeQ(Filter($_GET["uid"]));
$DB = Connect();
$sql = "select * FROM $strMyTable where $strMyTableID = '$strID'";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{
		foreach($row as $key => $val)
		{
			if($key==$strMyTableID)
			{
?>
											<input type="hidden" name="<?=$key?>" value="<?=Encode($strID)?>">	


<?php
			}
			elseif($key=="StoreID")
			{
					$DBvalue=$row[$key];

										
						$sql = "SELECT StoreID, StoreName from tblStores where StoreID='$DBvalue' Limit 0,1";
						//echo $sql;
						$RS2 = $DB->query($sql);
						if ($RS2->num_rows > 0)
						{
							while($row2 = $RS2->fetch_assoc())
							{
								$StoreID = $row2["StoreID"];
								$StoreName = $row2["StoreName"];
							}
						}
?>
								
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input class="form-control required" readonly value="<?=$StoreName?>"></div>
											</div>					
					
					
<?php
			}
			elseif($key=="Month")
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input class="form-control required" readonly value="<?=$row[$key]?>"></div>
											</div>

<?php
			}
			elseif($key=="Year")
			{

?>																
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input class="form-control required" readonly value="<?=$row[$key]?>"></div>
											</div>			
											
<?php	
			}
			else
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Admin", " ", $key)?>" value="<?=$row[$key]?>"></div>
											</div>


<?php
			}
		}
	}
?>

											<div class="form-group"><label class="col-sm-3 control-label"></label>
												<input type="submit" class="btn ra-100 btn-primary" value="Update">
												
												<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
											</div>
<?php
}
$DB->close();
?>													
										
									</div>
							</form>
							</div>
						</div>
                   </div>			
<?php
}
?>	                   
                </div>
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>