<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Employee Weekoff | Nailspa";
	$strDisplayTitle = "Employee Weekoff | Nailspa";
	$strMenuID = "3";
	$strMyTable = "tblEmployeeWeekOff";
	$strMyTableID = "EmployeeWeekOffID";
    $strMyActionPage = "ManageEmployeeWeekoff.php";
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
			//print_r($_POST);
			$weekoffdate = Filter($_POST["weekoffdate"]);
			$weeddd=explode("-",$weekoffdate);
			$weekstart=$weeddd[0];
			$weekend=$weeddd[1];
			$StoreID = Filter($_POST["StoreID"]);
			$empid = Filter($_POST["empid"]);
			$weekoff = Filter($_POST["weekoff"]);
			$weekstartt=date("Y-m-d",strtotime($weekstart));
			$weekendd=date("Y-m-d",strtotime($weekend));
			
			$DB = Connect();
			$sql = "Select EmployeeWeekOffID from $strMyTable where EID='$empid' and StoreID='$StoreID' and WeekOffStartDate='$weekstart' and WeekOffEndDate='$weekend'";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						<p>This Weekoff already exists in our system. Please try again with a different Dates.</p>
					</div>
				</div>');
			}
			else
			{
				$sqlInsert = "Insert into tblEmployeeWeekOff(EID, StoreID, WeekOffStartDate, WeekOffEndDate, WeekOffReason) values
				('".$empid."','".$StoreID."', '".$weekstartt."', '".$weekendd."', '".$weekoff."')";
				//echo $sqlInsert;
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

		if($strStep=="edit")
		{
			$DB = Connect();
			$EmployeeWeekOffID = $_POST["EmployeeWeekOffID"];
			$weekoffdate = Filter($_POST["weekoffdate"]);
			$weeddd=explode("-",$weekoffdate);
			$weekstart=$weeddd[0];
			$weekend=$weeddd[1];
			
			$weekstartt=date("Y-m-d",strtotime($weekstart));
			$weekendd=date("Y-m-d",strtotime($weekend));
		//	exit;
			$sqlUpdate = "update $strMyTable set WeekOffStartDate='$weekstartt',WeekOffEndDate='$weekendd' where EmployeeWeekOffID='".$EmployeeWeekOffID."'";
					ExecuteNQ($sqlUpdate);
				
			$DB->close();
			die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Updated Successfully</h4>
					</div>
				</div>');
		}
		die();
	}	
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	<?php require_once("EmployeeWeekOff.fya"); ?>
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
                        <p>Add, Edit, Delete Employee.</p>
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
											<li><a href="#normal-tabs-1" title="Tab 1">Manage</a></li>
											<li><a href="#normal-tabs-2" title="Tab 2">Add</a></li>
											<li><a href="#normal-tabs-3" title="Tab 3">Weekoff</a></li>
										</ul>
											<div id="normal-tabs-1">
												<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Employees for POS</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Store Name</th>
																<th>Employee Name</th>
																<th>Week Off Date</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Store Name</th>
																<th>Employee Name</th>
																<th>Week Off Date</th>
																<th>Actions</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();

// $sql = "SELECT tblStores.StoreID, tblStores.StoreName,tblStores.StoreOfficialAddress, tblStores.StoreBillingAddress, tblStores.StoreOfficialEmailID, tblStores.StoreBillingEmailID, tblStores.StoreOfficialNumber, tblStores.StoreBillingNumber, tblStoreSalesTarget.StoreID, tblStoreSalesTarget.Month,
// tblStoreSalesTarget.Year, tblStoreSalesTarget.TargetAmount From tblStores LEFT JOIN tblStoreSalesTarget ON tblStores.StoreID=tblStoreSalesTarget.StoreID WHERE (tblStoreSalesTarget.StoreID IS NULL) OR (tblStoreSalesTarget.StoreID IS NOT NULL)";
if($strStore!='0')
{
	$sql = "SELECT * FROM tblEmployeeWeekOff where StoreID='".$strStore."'";
}
else
{
	$sql = "SELECT * FROM tblEmployeeWeekOff where 1";
}


$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$EID = $row["EID"];
		$EmployeeWeekOffID = $row["EmployeeWeekOffID"];
		$getUID = EncodeQ($EmployeeWeekOffID);
		$getUIDDelete = Encode($EmployeeWeekOffID);		
		$StoreID = $row["StoreID"];
		
		$WeekOffStartDate = $row["WeekOffStartDate"];
		$WeekOffEndDate = $row["WeekOffEndDate"];
		
		$seldataqt=select("StoreName","tblStores","StoreID='".$StoreID."'");
	    $StoreName=$seldataqt[0]['StoreName'];
		
		$seldataqddt=select("EmployeeName","tblEmployees","EID='".$EID."'");
	    $EmployeeName=$seldataqddt[0]['EmployeeName'];
	
?>	
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$StoreName?></td>
																<td><?=$EmployeeName?></td>
																<td><b>From : <?=$WeekOffStartDate?><br/>  To : <?=$WeekOffEndDate?></b></td>
																<td style="text-align: center">
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																		<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step35','<?=$getUIDDelete?>', 'Are you sure you want to delete this Store - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
																	<?php
																	}
																	?>
																	<br>
																	<!--<a class="btn btn-link" href="ManageStoresTarget.php?uid=<?//=$getUID?>">Veiw Target</a>-->
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
												<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Add Data</h3>
												<div class="example-box-wrapper">
												<script>
	
	function checkemployee(OptionValue)
	{                
		// alert (OptionValue);
		if(OptionValue!='0')
		{
			$.ajax({
			type: 'POST',
			url: "GetEmployeeListData.php",
			data: "store="+OptionValue,
			success: function(response) {
				$(".employeedetails").html(response);
					
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$(".employeedetails").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
				return false;
				// alert (response);
			}
		  });
		}
		else
		{
			alert('Select Atleast One Store')
		}
		

	}
	function LoadEmploywwDetails(evt)
	{
		var store=$("#StoreID").val();
		if(evt!='0')
		{
			$.ajax({
			type: 'POST',
			url: "GetEmployeeDetails.php",
			data: "emp="+evt+"&store="+store,
			success: function(response) {
				$(".employeedetailsdata").html(response);
					
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$(".employeedetails").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
				return false;
				// alert (response);
			}
		  });
		}
		else
		{
			alert('Select Atleast One Store')
		}
	}
</script>
													
<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SHOW COLUMNS FROM ".$strMyTable." ";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{
		if($row["Field"]==$strMyTableID)
		{
		}
		else if ($row["Field"]=="StoreID")
		{
			
?>
<div class="form-group"><label class="col-sm-3 control-label">Weekoff Date <span>*</span></label>
														<div class="col-sm-3">
															<!--<span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span><input type="text" name="AppointmentDate" id="AppointmentDate" class="bootstrap-datepicker form-control required" value="02/16/12" data-date-format="yyyy/dd/mm">-->
																<div class="input-prepend input-group">
																<span class="add-on input-group-addon">
																	<i class="glyph-icon icon-calendar"></i>
																</span> 
																<input type="text" name="weekoffdate" id="daterangepicker-example" class="form-control required" >
															</div>
														</div>
											</div>
<?php			
	     	$sql1 = "select * FROM tblStores where Status='0'";
			$RS2 = $DB->query($sql1);
			if ($RS2->num_rows > 0)
			{
?>											
											<div class="form-group"><label class="col-sm-3 control-label">Select Store<span>*</span></label>
												<div class="col-sm-3">
													<select class="form-control required" id="StoreID" name="StoreID" onchange="checkemployee(this.value)">
															<option value="" selected>--Select Store--</option>
<?
													while($row2 = $RS2->fetch_assoc())
													{
														$strStoreName = $row2["StoreName"];
														$strStoreID = $row2["StoreID"];
?>
														<option value="<?=$strStoreID?>" ><?=$strStoreName?></option>														
<?php
													}
?>
														</select>
<?php
			}
		
?>
												</div>
											</div>	
											 <span class="employeedetails" ></span>
											 <span class="employeedetailsdata" ></span>
											 

<?php
		}
		else if ($row["Field"]=="EID")
		{
?>
											
											 
<?php
		}
		else if ($row["Field"]=="WeekOffEndDate")
		{
		}	
		else if ($row["Field"]=="WeekOffStartDate")
		{
		}	
		else if ($row["Field"]=="WeekOffReason")
		{
?>
														  <div class="form-group"><label class="col-sm-3 control-label">Weekoff Reason<span>*</span></label>
															<div class="col-sm-3"><textarea rows="4" name="weekoff" id="weekoff" class="form-control required " placeholder="weekoff"></textarea></div>
											</div>
<?php
		}
		else
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Admin", " ", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Admin", " ", $row["Field"])?>"></div>
														</div>
<?php
		}
	
	}
?>
														<div class="form-group"><label class="col-sm-3 control-label"></label>
															<input type="submit" class="btn ra-100 btn-primary" value="Submit">
															
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
										
											<div id="normal-tabs-3">
											<div class="col-sm-12">
												<div id="calendar-example-1" class="col-md-10 center-margin"></div>
											</div>
											 
											</div>
										
									</div>
								</div>
							</div>
						</div>
                    </div>
<?php
} // End null condition










//-----------------Normal Edit

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

								
									<h3 class="title-hero">Edit Data</h3>
									<div class="example-box-wrapper">
										
<?php
//echo 1244;
$DB = Connect();
$strID = DecodeQ(Filter($_GET["uid"]));

$sql = "SELECT * FROM $strMyTable WHERE EmployeeWeekOffID= '".$strID."'";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{
		foreach($row as $key => $val)
		{
			if($key=='EmployeeWeekOffID')
			{
?>
											<input type="hidden" name="<?=$key?>" value="<?=$row["EmployeeWeekOffID"]?>">	

<?php
			}
			elseif($key=="StoreID")
			{
				$sto=$row[$key];
				$eidd=$row['EID'];
				$RES=$row['WeekOffReason'];
				$seldataqt=select("StoreName","tblStores","StoreID='".$sto."'");
	            $StoreName=$seldataqt[0]['StoreName'];
				$WeekOffStartDate=date("m-d-Y",strtotime($row['WeekOffStartDate']));
				$WeekOffEndDate=date("m-d-Y",strtotime($row['WeekOffEndDate']));
				$datettt=$WeekOffStartDate." - ".$WeekOffEndDate;
				$sql = "SELECT * FROM tblEmployees WHERE StoreID='$sto' and EID='$eidd'";
                $RS = $DB->query($sql);

				if ($RS->num_rows > 0)

				{

				while($row = $RS->fetch_assoc())

								{
										$EID = $row["EID"];
							$EmployeeName = $row["EmployeeName"];
							
							//$EID = $row["EID"];
							$EmployeeCode = $row["EmployeeCode"];
							
							//$EID = $row["EID"];
							$EmployeeAddress = $row["EmployeeAddress"];
							
							$EmployeePincode = $row["EmployeePincode"];
							$EmployeeEmailID = $row["EmployeeEmailID"];
							
							$EmployeeMobileNo = $row["EmployeeMobileNo"];
							$JoinDate = $row["JoinDate"];
							
							$Target = $row["Target"];
							
								}
				}
				
?>	
                                        <div class="form-group"><label class="col-sm-3 control-label">Weekoff Date <span>*</span></label>
														<div class="col-sm-3">
															<!--<span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span><input type="text" name="AppointmentDate" id="AppointmentDate" class="bootstrap-datepicker form-control required" value="02/16/12" data-date-format="yyyy/dd/mm">-->
																<div class="input-prepend input-group">
																<span class="add-on input-group-addon">
																	<i class="glyph-icon icon-calendar"></i>
																</span> 
																<input type="text" name="weekoffdate" id="daterangepicker-example" class="form-control required" value="<?=$datettt?>">
															</div>
														</div>
											</div>
											<div class="form-group"><label class="col-sm-3 control-label">Store<span>*</span></label>
												<div class="col-sm-3"><input readonly type="text" name="<?=$key?>" class="form-control required" value="<?=$StoreName?>"></div>
											</div>
											         <div class="form-group"><label class="col-sm-3 control-label">Employee Code<span>*</span></label>
												<div class="col-sm-3"><input type="text" readonly name="EmployeeCode" class="form-control required"  id="EmployeeCode" value="<?=$EmployeeCode?>"></div>
											</div>	
                                             <div class="form-group"><label class="col-sm-3 control-label">Employee Address<span>*</span></label>
															<div class="col-sm-3"><textarea rows="4" name="EmployeeAddress" id="EmployeeAddress" class="form-control required " readonly placeholder="Employee Address"><?=$EmployeeAddress?></textarea></div>
											</div>
											  <div class="form-group"><label class="col-sm-3 control-label">Employee Pincode<span>*</span></label>
															<div class="col-sm-3"><input rows="4" name="EmployeePincode" id="EmployeePincode" class="form-control required  " value="<?=$EmployeePincode?>" readonly placeholder="Employee Pincode"></div>
											</div>
											  <div class="form-group"><label class="col-sm-3 control-label">Employee Email<span>*</span></label>
															<div class="col-sm-3"><input readonly rows="4" name="EmployeeEmailID" id="EmployeeEmailID" class="form-control required  " value="<?=$EmployeeEmailID?>" placeholder="Employee EmailID"></div>
											</div>
											  <div class="form-group"><label class="col-sm-3 control-label">Employee Mobile<span>*</span></label>
															<div class="col-sm-3"><input readonly rows="4" name="EmployeeMobileNo" id="EmployeeMobileNo" class="form-control required  " value="<?=$EmployeeMobileNo?>" placeholder="Employee MobileNo"></div>
											</div>
											  <div class="form-group"><label class="col-sm-3 control-label">Join Date<span>*</span></label>
															<div class="col-sm-3"><input readonly rows="4" name="JoinDate" id="JoinDate" class="form-control required  " placeholder="JoinDate" value="<?=date('d-m-y',strtotime($JoinDate))?>"></div>
											</div>
										
											
											<div class="form-group"><label class="col-sm-3 control-label">Target<span>*</span></label>
															<div class="col-sm-3"><input readonly type="text" name="Target" id="Target" class="form-control required" placeholder="Target" value="<?=$Target?>"></div>
													</div>	
													 <div class="form-group"><label class="col-sm-3 control-label">Weekoff Reason<span>*</span></label>
															<div class="col-sm-3"><textarea rows="4" name="weekoff" id="weekoff" class="form-control required " readonly placeholder="weekoff"><?=$RES?></textarea></div>
											            </div> 
<?php
			}
			else
			{

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