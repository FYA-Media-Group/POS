<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Admin Role Management | Nailspa";
	$strDisplayTitle = "Manage Admin Roles for Nailspa";
	$strMenuID = "4";
	$strMyTable = "tblAdminRoles";
	$strMyTableID = "RoleID";
	$strMyField = "RoleName";
	$strMyActionPage = "AdminRoles.php";
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
			$strRoleName = Filter($_POST["RoleName"]);
			$strStatus = Filter($_POST["Status"]);
		
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
						<p>The Charge Name already exists in our system. Please try again with a different name.</p>
					</div>
				</div>');
			}
			else
			{
				$sqlInsert = "INSERT INTO $strMyTable (RoleName, Status) VALUES ('".$strRoleName."', '".$strStatus."')";
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
                        <p>Add, Edit, Delete Admin Roles</p>
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
										</ul>
											<div id="normal-tabs-1">
												<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Admin Roles | Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>RoleName</th>
																<th>URL Access</th>
																<th>Status</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>RoleName</th>
																<th>URL Access</th>
																<th>Status</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SELECT RoleID, RoleName, Status FROM tblAdminRoles WHERE Status='0'";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strRoleID = $row["RoleID"];
		$getUID = EncodeQ($strRoleID);
		$getUIDDelete = Encode($strRoleID);		
		$RoleName = $row["RoleName"];
		$Status = $row["Status"];
		
		if($Status=="0")
		{
			$Status = "Live";
		}
		else
		{
			$Status = "Offline";
		}
?>	
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$RoleName?></td>
																<td><?=$RoleName?></td>
																<td><?=$Status?></td>
																<td style="text-align: center">
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?cid=<?=$getUID?>">Connect </a>
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step4','<?=$getUIDDelete?>', 'Are you sure you want to delete this Charge - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
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

											
												<h3 class="title-hero">Add Roles</h3>
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
		else if ($row["Field"]=="RoleName")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("RoleName", "Role Name", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("RoleName", "Role Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("RoleName", "Role Name", $row["Field"])?>"></div>
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


//cid

//cid end







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

								
									<h3 class="title-hero">Edit Charges</h3>
									<div class="example-box-wrapper">
										
<?php
$strID = DecodeQ(Filter($_GET["uid"]));
$DB = Connect();
$sql = "SELECT * FROM tblChargeNames WHERE $strMyTableID = '$strID'";
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
			elseif($key=="RoleName")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("RoleName", "Role Name", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("RoleName", "Role Name", $key)?>" value="<?=$row[$key]?>"></div>
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