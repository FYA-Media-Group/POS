<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?php
		session_start();
		// $strAdminID = $_SESSION["AdminID"];
		// $CurrentAdminName= $_SESSION["AdminFullName"];
		// echo $strAdminID."<br>";
		// echo $CurrentAdminName;
?>
<script>
	function LoadValue(OptionValue)
            {                
				$.ajax({
					type: 'POST',
					url: "GetChargeSet.php",
					data: {
						id:OptionValue
					},
					success: function(response) {
						$(".load_charges").html(response);
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$(".load_charges").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
					}
				});

            }			
</script>

<?php
	$strPageTitle = "Manage Charges | Nailspa";
	$strDisplayTitle = "Manage Charges for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblCharges";
	$strMyTableID = "ChargesID";
	$strMyField = "";
	$strMyActionPage = "ManageCharges.php";
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
			$strChargeNamesID = Filter($_POST["ChargeNamesID"]);
			$strChargeSetID = Filter($_POST["ChargeSetID"]);
			$strStatus = Filter($_POST["Status"]);
			echo $strChargeNamesID;
			echo $strChargeSetID;
			echo $strStatus;


			$DB = Connect();
			$sql = "Select $strMyTableID from $strMyTable where $strMyField='$_POST[$strMyField]'";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				// die();
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
					// echo "In else<br>";
				// $sqlInsert = "INSERT INTO $strMyTable (ChargeNamesID, ChargeSetID, Status) VALUES 
				// ('".$strCategoryName."', '".$strCategoryType."', '".$strStatus."')";
				// ExecuteNQ($sqlInsert);
				// $sqlInsert1 = "Insert into tblChargeNames (ChargeNameID, ChargeName, Status) Values ((Select ChargeNameID from tblChargeNames where ChargeName='$ChargeName'), '$ChargeName', '$strImageUploadPath1', '0', '1', '0')";
				
				$sqlInsert = "INSERT INTO tblCharges (ChargeNamesID, ChargeSetID, Status) VALUES 
				('".$strChargeNamesID."', '".$strChargeSetID."', '".$strStatus."')";
				// echo $sqlInsert."<br>";
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
					// ExecuteNQ($sqlUpdate);
					echo $sqlUpdate."<br>";
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
                        <p>Add, Edit, Delete Total Charges</p>
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
												<h3 class="title-hero">List of Total Charges | Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>ChargeNames</th>
																<th>Charge Set</th>
																<th>Status</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>ChargeNames</th>
																<th>Charge Set</th>
																<th>Status</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SELECT * FROM ".$strMyTable." WHERE Status='0'";



$sql = "SELECT tblCharges.ChargesID,tblCharges.Status, tblChargeNames.ChargeName, tblChargeSets.SetName FROM tblCharges 
	left join tblChargeNames on tblCharges.ChargeNamesID=tblChargeNames.ChargeNameID
	left join tblChargeSets on tblCharges.ChargeSetID=tblChargeSets.ChargeSetID WHERE tblChargeNames.Status='0'" ;
	
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strChargesID = $row["ChargesID"];
		$getUID = EncodeQ($strChargesID);
		$getUIDDelete = Encode($strChargesID);		
		$ChargeNamesID = $row["ChargeNamesID"];
		$ChargeName = $row["ChargeName"];
		$ChargeSetID = $row["ChargeSetID"];
		$Status = $row["Status"];
		$SetName = $row["SetName"];		
		// echo $SetName;
		// echo $Status;
		
		
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
																<td><?=$ChargeName?></td>
																<td><?=$SetName?></td>
																<td><?=$Status?></td>
																<td style="text-align: center">
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																		<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step18','<?=$getUIDDelete?>', 'Are you sure you want to delete this Category - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
																	<?php
																	}
																	?>
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

											
												<h3 class="title-hero">Add Total Charges</h3>
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
		else if ($row["Field"]=="ChargeNamesID")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ChargeNamesID", "Charge Name", $row["Field"])?> <span>*</span></label>
													<div class="col-md-6 col-sm-6 col-xs-12 ">
															
<?php
			$sql = "SELECT ChargeNameID, ChargeName from tblChargeNames where Status=0";
			$RS2 = $DB->query($sql);
			if ($RS2->num_rows > 0)
			{
?>
														<select class="form-control required" onchange="LoadValue(this.value);" name="<?=$row["Field"]?>">
															<option value="" selected>--SELECT NAME--</option>
<?
				while($row2 = $RS2->fetch_assoc())
				{
					
					$ChargeNameID = $row2["ChargeNameID"];
					$ChargeName = $row2["ChargeName"];	
					
?>

															<option value="<?=$ChargeNameID?>"><?=$ChargeName?></option>
												
												
<?php
				}
?>
														</select>

<?php
			}
			else
			{
				echo "Charge Names are not added. <a href='ManageChargeNames.php' target='chargenames'>Click here to add</a>";
			}
?>
													</div>
												</div>
<?php			
		}
		
		else if ($row["Field"]=="ChargeSetID")
		{
?>
																							
												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12"><?=str_replace("ID", " ", $row["Field"])?><span>*</span></label>
													<div class="col-md-6 col-sm-6 col-xs-12 load_charges">

<?php
			$sql = "SELECT ChargeSetID, SetName from tblChargeSets where Status=0 $tempAdminquery";
			$RS2 = $DB->query($sql);
			if ($RS2->num_rows > 0)
			{
?>

														<select class="form-control required" name="<?=$row["Field"]?>">
															<option value="" selected>--SELECT SET--</option>
<?
				while($row2 = $RS2->fetch_assoc())
				{
					
					$ChargeSetID = $row2["ChargeSetID"];
					$SetName = $row2["SetName"];	
					
?>

															<option value="<?=$ChargeSetID?>"><?=$SetName?></option>
												
												
<?php
				}
?>
														</select>

<?php
			}
			else
			{
				echo "Charge Names are not added. <a href='ManageChargeSets.php' target='chargenames'>Click here to add</a>";
			}
?>
													</div>
												</div>			
												
											

<?
		}
		else if ($row["Field"]=="Status")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", "Status", $row["Field"])?> <span>*</span></label>
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
								<a class="btn btn-primary btn-lg btn-block" href="<?=$strMyActionPage?>"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
						
							<div class="panel-body">
							<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email', '.admin_password'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

								
									<h3 class="title-hero">Edit Categories</h3>
									<div class="example-box-wrapper">
										
<?php
$strID = DecodeQ(Filter($_GET["uid"]));
$DB = Connect();
$sql = "SELECT * FROM ".$strMyTable." WHERE $strMyTableID = '$strID'";
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
			elseif($key=="ChargeNamesID")
			{
				$previousvalue=$row[$key];
				// echo $previousvalue."<br>";
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ChargeNamesID", "Charge Names", $key)?> <span>*</span></label>
												<div class="col-sm-3">
													<select name="<?=$key?>" class="form-control required">
														<option value="0" Selected>--Select Charge Name--</option>
<?php		
														$sql2 = "SELECT ChargeNameID, ChargeName FROM tblChargeNames where status=0";
															$Res2 = $DB->query($sql2);
															if ($Res2->num_rows > 0) 
															{
																while($row = $Res2->fetch_assoc())
																{
																	$ChargeNameID = $row['ChargeNameID'];
																	
																	$ChargeName = $row['ChargeName'];
																	
																	if($ChargeNameID == $previousvalue)
																	{
																	?>
																		<option value="<?=$ChargeNameID?>" selected><?=$ChargeName?> </option>
<?																	}
																	else
																	{
?>
																		<option value="<?=$ChargeNameID?>"><?=$ChargeName?></option>
															<?		}
																}
															}
													?>						
													</select>
												</div>
											</div>
<?php
			}
			elseif($key=="ChargeSetID")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ChargeSetID", "Charge Set", $key)?> <span>*</span></label>
												<div class="col-sm-3">
													<select name="<?=$key?>" class="form-control required">
														<option value="0" Selected>--Select Store--</option>
												<?php		$sql2 = "SELECT ChargeSetID, SetName FROM tblChargeSets where status=0";
															$Res2 = $DB->query($sql2);
															if ($Res2->num_rows > 0) 
															{
																while($row = $Res2->fetch_assoc())
																{
																	$ChargeSetID = $row['ChargeSetID'];
																	$SetName = $row['SetName'];
																	if($ChargeSetID == $row[$key])
																	{
																	?>
																		<option value="<?=$ChargeSetID?>" selected><?=$SetName?></option>
															<?		}
																	else
																	{
																	?>
																		<option value="<?=$ChargeSetID?>"><?=$SetName?></option>
															<?		}
																}
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
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Status", "Status", $key)?> <span>*</span></label>
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