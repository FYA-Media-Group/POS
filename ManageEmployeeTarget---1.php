<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
					

<?php
	$strPageTitle = "Manage Employee | Nailspa";
	$strDisplayTitle = "Manage Employee Target for Nailspa";
	$strMenuID = "3";
	$strMyTable = "tblEmployeeTarget";
	$strMyTableID = "ETID";
	$strMyField = "Month";
	$strMyActionPage = "ManageEmployeeTarget-2.php";
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
			$strStatus = Filter($_POST["Status"]);
			$Year = Filter($POST["currentYear"]);
			$EmployeeCode = Filter($POST["EID"]);
			
			
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
				 
				$sqlInsert = "Insert into $strMyTable ( EmployeeCode, TargetForMonth, Year, BaseTarget, Week1, Week2, Week3, Week4, Week5) Values
				('".$EmployeeCode."','".$strMonth."', '".$strYear."','".$strTargetAmount."','".$Week1."' ,'".$Week2."' ,'".$Week3."' ,'".$Week4."','".$Week5."')";
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
                        <p>Add and Delete Monthly Target for each Employee.</p>
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
												<h3 class="title-hero">List of Monthly Targets for Nailspa Employees</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Employee</th>
																<th>Month<br>Year</th>
																<th>BaseTarget</th>
																<th>Week1</th>
																<th>Week2</th>
																<th>Week3</th>
																<th>Week4</th>
																<th>Week5</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Employee</th>
																<th>Month<br>Year</th>
																<th>BaseTarget</th>
																<th>Week1</th>
																<th>Week2</th>
																<th>Week3</th>
																<th>Week4</th>
																<th>Week5</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
// echo $strStoreID."<br>";
// echo "Hello";
$day = date('d');
$Month = date('m');			//$row["Month"];
$MonthSpell = getMonthSpelling($Month);
$Year = 2000 + date('y');			//$row["Year"];
// $MonthYear = $MonthSpell.", ".$Year;

$sql = "SELECT ETID, EmployeeCode, TargetForMonth, Year,BaseTarget, Week1, Week2, Week3, Week4, Week5, (SELECT EmployeeName FROM tblEmployees WHERE EmployeeCode=tblEmployeeTarget.EmployeeCode) as EmployeeName FROM tblEmployeeTarget WHERE TargetForMonth LIKE '$MonthSpell' AND Year='$Year'";
// echo $sql;
// echo $sql;
// die();
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;
	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strETID = $row["ETID"];
		$getUID = EncodeQ($strETID);
		$getUIDDelete = Encode($strETID);
		$EmployeeCode = $row["EmployeeCode"];
		$TargetForMonth = $row["TargetForMonth"];
		$Year = $row["Year"];
		$BaseTarget = $row["BaseTarget"];
		$Week1 = $row["Week1"];
		$Week2 = $row["Week2"];
		$Week3 = $row["Week3"];
		$Week4 = $row["Week4"];
		$Week5 = $row["Week5"];
		$EmployeeName = $row["EmployeeName"];
		
?>												
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$EmployeeCode?><br><?=$EmployeeName?></td>
																<td><?=$MonthSpell?>,&nbsp; <?=$Year?></td>
																<td id="abc">Rs.																	<input type="text" id="TargetAmount<?=$strETID?>" style="border: 0px" value="<?=$BaseTarget?>"><br>
																	<button class="btn btn-link" onClick="UpdateTargetAmount(<?=$strETID?>);">Update</button>
																	<script>
																		function UpdateTargetAmount(value)
																		{
																			var STID = value;
																			// alert(STID);
																			var TargetAmount = "TargetAmount";
																			// alert(TargetAmount);
																			var targetID = TargetAmount.concat(STID);
																			var UpdatedTarget = document.getElementById(targetID).value;
																			alert(UpdatedTarget);
																			
																			$.ajax
																			({
																				type: "POST",
																				url: "UpdateEmployeeTarget.php?stid="+STID+"&NewTarget="+UpdatedTarget,
																				data: {
																						TargetAmountSend: UpdatedTarget
																				},
																				success: function(response) 
																				{
																				   document.getElementById("form_result").innerHTML = response;
																				   document.getElementById("form_result").style.display = "block";
																				}
																			});
																		}
																	
																	</script>
																</td>
																
																<td><?=$Week1?></td>
																<td><?=$Week2?></td>
																<td><?=$Week3?></td>
																<td><?=$Week4?></td>
																<td><?=$Week5?></td>
																<td style="text-align: center">
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step10','<?=$getUIDDelete?>', 'Are you sure you want to delete this Store Stock Record - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
																</td>
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
																<th>Employee</th>
																<th>Month<br>Year</th>
																<th>BaseTarget</th>
																<th>Week1</th>
																<th>Week2</th>
																<th>Week3</th>
																<th>Week4</th>
																<th>Week5</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Employee</th>
																<th>Month<br>Year</th>
																<th>BaseTarget</th>
																<th>Week1</th>
																<th>Week2</th>
																<th>Week3</th>
																<th>Week4</th>
																<th>Week5</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();

//start by asmita
// echo $strAdminID;
// echo $strAdminFullName."<br>";
$FindStore="Select StoreID from tblAdminStore where AdminID=$strAdminID";
// echo $FindStore."<br>";
								$RSf = $DB->query($FindStore);
								if ($RSf->num_rows > 0) 
								{
									while($rowf = $RSf->fetch_assoc())
									{
										$strStoreID = $rowf["StoreID"];
										echo $strStoreID;
									}
								}


$day = date('d');
$Month = date('m');			//$row["Month"];
$MonthSpell = getMonthSpelling($Month);
$Year = 2000 + date('y');			//$row["Year"];
// $MonthYear = $MonthSpell.", ".$Year;

// $sql = "SELECT STID, Month, Year, TargetAmount, (SELECT StoreName FROM tblStores WHERE StoreID=tblStoreSalesTarget.StoreID) AS StoreName FROM tblStoreSalesTarget ORDER BY STID DESC";

$sql = "SELECT ETID, EmployeeCode, TargetForMonth, Year,BaseTarget, Week1, Week2, Week3, Week4, Week5, (SELECT EmployeeName FROM tblEmployees WHERE EmployeeCode=tblEmployeeTarget.EmployeeCode) as EmployeeName FROM tblEmployeeTarget Order BY ETID DESC";
// echo $sql;
// die();
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strETID = $row["ETID"];
		$getUID = EncodeQ($strETID);
		$getUIDDelete = Encode($strETID);
		$EmployeeCode = $row["EmployeeCode"];
		$TargetForMonth = $row["TargetForMonth"];
		$Year = $row["Year"];
		$BaseTarget = $row["BaseTarget"];
		$Week1 = $row["Week1"];
		$Week2 = $row["Week2"];
		$Week3 = $row["Week3"];
		$Week4 = $row["Week4"];
		$Week5 = $row["Week5"];
		
?>														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$EmployeeCode?><br><?=$EmployeeName?></td>
																<td><?=$Month?>,&nbsp; <?=$Year?></td>
																<td id="abc">Rs. <?=$BaseTarget?></td>
																<td><?=$Week1?></td>
																<td><?=$Week2?></td>
																<td><?=$Week3?></td>
																<td><?=$Week4?></td>
																<td><?=$Week5?></td>
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