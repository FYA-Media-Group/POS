<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Manage Employee Target | NailSpa";
	$strDisplayTitle = "Manage Employee Target for NailSpa";
	$strMenuID = "10";
	$strMyTable = "tblEmployeeTarget";
	$strMyTableID = "ETID";
	$strMyField = "";
	$strMyActionPage = "ManageEmployeeTarget.php";
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
			$strEmployeeCode = Filter($_POST["EmployeeCode"]);
			$strTargetForMonth = Filter($_POST["TargetForMonth"]);
			$strBaseTarget = Filter($_POST["BaseTarget"]);
			$strWeek1 = Filter($_POST["Week1"]);
			$strWeek2 = Filter($_POST["Week2"]);
			$strWeek3 = Filter($_POST["Week3"]);
			$strWeek4 = Filter($_POST["Week4"]);
			$strWeek4 = Filter($_POST["Week4"]);
			$strWeek5 = Filter($_POST["Week5"]);


			$DB = Connect();
			$sql = "Select $strMyTableID from $strMyTable where $strMyField='$_POST[$strMyField]'";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						<p>Appointment Already Booked!</p>
					</div>
				</div>');
			}
			else
			{
				$sqlInsert = "INSERT INTO $strMyTable (EmployeeCode, TargetForMonth, BaseTarget, Week1, Week2, Week3, Week4, Week5) VALUES 
				('".$strEmployeeCode."', '".$strTargetForMonth."', '".$strBaseTarget."', '".$strWeek1."', '".$strWeek2."', '".$strWeek3."', '".$strWeek4."', '".$strWeek5."')";
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
			foreach($_POST as $key => $val)
			{
				if($key=="step" || $key==$strMyTableID)
				{
				
				}
				else
				{
					$sqlUpdate = "UPDATE $strMyTable SET $key='$_POST[$key]' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					ExecuteNQ($sqlUpdate);
				}
			}
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
                        <p>Re-schedule, Cancel Appointments</p>
                    </div>
<?php

if(!isset($_GET['uid']))
{
?>					
                   
						  <div class="panel">
						<div class="panel">
							<div class="panel-body">
								
								<div class="example-box-wrapper">
									<div class="tabs">
										<ul>
											<li><a href="#normal-tabs-1" title="Tab 1">Manage</a></li>
											<li><a href="#normal-tabs-2" title="Tab 1">Add</a></li>
										</ul>
										<div id="normal-tabs-1">
												<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Today's Appointments | NailSpa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>EmployeeCode</th>
																<th>Store Name</th>
																<th>TargetForMonth</th>
																<th>BaseTarget</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>EmployeeCode</th>
																<th>Store Name</th>
																<th>TargetForMonth</th>
																<th>BaseTarget</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
//echo 1112;
//Only today's appointments will be listed.
$sql = "SELECT * FROM ".$strMyTable." order by ETID desc";
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
		$strEmployeeCode = $row["EmployeeCode"];
		$strTargetForMonth = $row["TargetForMonth"];
// echo $strTargetForMonth;		
		$BaseTarget = $row["BaseTarget"];
		$Week1 = $row["Week1"];
		$Week2 = $row["Week2"];
		$Week3 = $row["Week3"];
		$Week4 = $row["Week4"];
		$Week5 = $row["Week5"];
		
?>	
															<tr id="my_data_tr_<?=$counter?>">
																
																<td><?=$counter?></td>
																<?
																	$SelectEmployeeName="Select EID , EmployeeName from tblEmployees where EmployeeCode='$strEmployeeCode'";
																	// echo $SelectEmployeeName;
																	$RS1 = $DB->query($SelectEmployeeName);
																	if ($RS1->num_rows > 0) 
																	{
																		while($row1 = $RS1->fetch_assoc())
																		{
																			$EmployeeName = $row1["EmployeeName"];
																			$EID = $row1["EID"];
																			$StoreID = $row1["StoreID"];
																		}
																	}
																?>
																<td><?=$EmployeeName?></td>
																<td><?
																	$SelectEMPStore="Select StoreID , EmployeeName from tblEmployees where EmployeeCode='$strEmployeeCode'";
																	// echo $SelectEmployeeName;
																	$RS2 = $DB->query($SelectEMPStore);
																	if ($RS2->num_rows > 0) 
																	{
																		while($row2 = $RS2->fetch_assoc())
																		{
																			$EmployeeName = $row2["EmployeeName"];
																			$EID = $row2["EID"];
																			$strStoreID = $row2["StoreID"];
																			
																			$selectStore="Select StoreName from tblStores where StoreID='$strStoreID'";
																			$RS3 = $DB->query($selectStore);
																			if ($RS3->num_rows > 0) 
																			{
																				while($row3 = $RS3->fetch_assoc())
																				{
																					$StoreName = $row3["StoreName"];
																				}
																			}
																			
																			
																			
																		}
																	}
																?>
																<?=$StoreName?></td>
																<td><?=$strTargetForMonth?></td>
																<td><?=$BaseTarget?></td>
																<td>
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																	
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step3','<?=$getUIDDelete?>', 'Are you sure you want to delete this Admin - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
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
																<td>No Records Found</td>
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
											<div class="fa-hover col-sm-3" style="float: right">	
												<a class="btn btn-primary btn-lg btn-block" href="ViewAppointments.php"><i class="fa fa-backward"></i> &nbsp; View all Appointments</a>
											</div>
										</div>
										<div id="normal-tabs-2">
											<div class="panel-body">
											<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email', '.admin_password'); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Add Admin</h3>
												<div class="example-box-wrapper">
													
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
		else if ($row["Field"]=="LastLogin")
		{
		}
		else if ($row["Field"]=="AdminPassword")
		{
?>	
													
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="password" name="<?=$row["Field"]?>" id="<?=str_replace("Admin", " ", $row["Field"])?>" class="form-control admin_password required" placeholder="<?=str_replace("Admin", " ", $row["Field"])?>"></div>
														</div>

<?php
		}
		else if ($row["Field"]=="AdminType")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3">
																<select name="<?=$row["Field"]?>" class="form-control required">
																	<option value="">--Choose option--</option>
																	<option value="0">Super Admin</option>
																	<option value="1">Admin</option>
																</select>
															</div>
														</div>
<?php
		}
		else if ($row["Field"]=="EmployeeCode")
		{
			$sql1 = "SELECT * FROM tblEmployees WHERE Status = 0";
			$RS2 = $DB->query($sql1);
			if ($RS2->num_rows > 0)
			{
?>											
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeCode", "Employee", $row["Field"])?> <span>*</span></label>
												<div class="col-sm-3">
													<select class="form-control required"  name="<?=$row["Field"]?>" onChange="LoadStore(this.value);">
															<option value="" selected>--SELECT Employee--</option>
<?
													while($row2 = $RS2->fetch_assoc())
													{
														$strEID = $row2["EID"];
														$EmployeeName = $row2["EmployeeName"];
														$EmployeeCode = $row2["EmployeeCode"];
?>
														<option value="<?=$EmployeeCode?>" ><?=$EmployeeName?></option>														
<?php
													}
?>
														</select>
<?php
			}
			else
			{
				echo "Admin Roles are not added. <a href='ManageAdminRoles.php' class='btn btn-link' target='Admin Role'>Click here to Add Admin Roles</a>";
			}
?>
												</div>
											</div>	
											<div class="Load_Store">
											</div>
<?php
		}
		else if ($row["Field"]=="AdminFullName")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminFullName", "Full Name", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("AdminFullName", "Full Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("AdminFullName", "Full Name", $row["Field"])?>"></div>
														</div>	
<?php
		}
		else if ($row["Field"]=="AdminEmailID")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminEmailID", "Email Id", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("AdminEmailID", "Email Id", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("AdminEmailID", "Email Id", $row["Field"])?>"></div>
														</div>	
<?php
		}
		else if ($row["Field"]=="AdminUserName")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminUserName", "User Name", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("AdminUserName", "User Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("AdminUserName", "User Name", $row["Field"])?>"></div>
														</div>	
<?php
		}
		else if ($row["Field"]=="AdminPassword")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminPassword", "Password", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("AdminPassword", "Password", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("AdminPassword", "Password", $row["Field"])?>"></div>
														</div>														
<?php
		}
		else if ($row["Field"]=="Status")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3">
																<select name="<?=$row["Field"]?>" class="form-control required">
																	<option value="0" Selected>Live</option>
																	<option value="1">Offline</option>	
																</select>
															</div>
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
								<a class="btn btn-primary btn-lg btn-block" href="javascript:window.location = document.referrer;"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
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
$sql = "SELECT * FROM $strMyTable WHERE $strMyTableID = '$strID'";
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
			elseif($key=="AdminUserName")
			{
?>	
										
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminUserName", "User Name", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input class="form-control" value="<?=$row[$key]?>" readonly></div>
											</div>

<?php
			}
			elseif($key=="AdminEmailID")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminEmailID", "Email Id", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input type="text" name="<?=$key?>" class="form-control admin_email required" placeholder="<?=str_replace("Admin", " ", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="AdminPassword")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminPassword", "Password", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control admin_password required" placeholder="<?=str_replace("Admin", " ", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="AdminFullName")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminFullName", "Full Name", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input type="text" name="<?=$key?>" class="form-control admin_password required" placeholder="<?=str_replace("AdminFullName", "Full Name", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="EmployeeCode")
			{
					$DBvalue=$row[$key];
					
?>	
					<div class="form-group">
							<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeCode", "Employee Name", $key)?> <span>*</span></label>
								<div class="col-sm-4">	
									

									<?php
										// echo $DBvalue;
										$sql = "SELECT EmployeeName, EID, EmployeeCode FROM tblEmployees where EmployeeCode='$row[$key]'";
										// echo $sql;
										$RS2 = $DB->query($sql);
										if ($RS2->num_rows > 0)
										{
									?>

											<select readonly class="form-control required" name="<?=$key?>">
												<?
													while($row2 = $RS2->fetch_assoc())
													{
														$EID = $row2["EID"];
														$EmployeeName = $row2["EmployeeName"];
														$EmployeeCode = $row2["EmployeeCode"];
														if($DBvalue==$EmployeeCode)
														{	
												?>

															<option value="<?=$EmployeeCode?>" selected><?=$EmployeeName?></option>	
												<?php
														}
														else
														{
												?>

															<option value="<?=$EmployeeCode?>"><?=$EmployeeName?></option>	
												<?php
														}
													}
												?>
											</select>
									<?php
										}
										else
										{
											echo "Add Employees</a>";
										}
								?>
								</div>
					</div>
<?php
			}
			elseif($key=="LastLogin")
			{
?>
<?php
			}
			elseif($key=="AdminType")
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminType", "Admin Type", $key)?> <span>*</span></label>
												<div class="col-sm-2">
													<select name="<?=$key?>" class="form-control required">
														<?php
															if ($row[$key]=="0")
															{
														?>
																<option value="0" selected>Super Admin</option>
																<option value="1">Admin</option>
														<?php
															}
															elseif ($row[$key]=="1")
															{
														?>
																<option value="0">Super Admin</option>
																<option value="1" selected>Admin</option>
														<?php
															}
															else
															{
														?>
																<option value="" selected>--Choose option--</option>
																<option value="0">Super Admin</option>
																<option value="1">Admin</option>
														<?php
															}
														?>	
													</select>
												</div>
											</div>



<?php
			}
			elseif($key=="Status")
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $key)?> <span>*</span></label>
												<div class="col-sm-2">
													<select name="<?=$key?>" class="form-control required">
														<?php
															if ($row[$key]=="0")
															{
														?>
																<option value="0" selected>Live</option>
																<option value="1">Offline</option>
														<?php
															}
															elseif ($row[$key]=="1")
															{
														?>
																<option value="0">Live</option>
																<option value="1" selected>Offline</option>
														<?php
															}
															else
															{
														?>
																<option value="" selected>--Choose option--</option>
																<option value="0">Live</option>
																<option value="1">Offline</option>
														<?php
															}
														?>	
													</select>
												</div>
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
              	
            			   
<?php
}
?>	               
                   </div>		    
                  </div>	
                 </div>
            </div>	
        
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>