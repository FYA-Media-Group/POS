<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Manage Charges | Nailspa";
	$strDisplayTitle = "Manage Charges for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblChargeSets";
	$strMyTableID = "ChargeSetID";
	$strMyField = "";
	$strMyActionPage = "ManageChargeSets.php";
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
			$strChargeAmt = Filter($_POST["ChargeAmt"]);
			$strSetName = Filter($_POST["SetName"]);
			$strChargeFPType = Filter($_POST["ChargeFPType"]);
			$strChargeDFType = Filter($_POST["ChargeDFType"]);
			$strChargeTypeValue = Filter($_POST["ChargeTypeValue"]);
			$strStatus = Filter($_POST["Status"]);


			$DB = Connect();
			// $sqlInsert = "INSERT INTO $strMyTable (ChargeAmt, ChargeFPType, ChargeDFType, ChargeTypeValue, Status) VALUES
			// ('".$strChargeAmt."', '".$strChargeFPType."', '".$strChargeDFType."', '".$strChargeTypeValue."', '".$strStatus."')";
			
			$sqlInsert = "INSERT INTO $strMyTable (SetName,ChargeAmt, ChargeFPType,   Status) VALUES
			('".$strSetName."','".$strChargeAmt."', '".$strChargeFPType."', '".$strStatus."')";
			
			ExecuteNQ($sqlInsert);
			// echo $sqlInsert."<br>";
			// die();
			$DB->close();
			die('<div class="alert alert-close alert-success">
				<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
				<div class="alert-content">
					<h4 class="alert-title">Record Added Successfully.</h4>
				</div>
			</div>');
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
                        <p>Add, Edit, Delete Charges.</p>
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
												<h3 class="title-hero">List of Charges | Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Charge Amount</th>
																<th>Charge FP Type</th>
																<th>Status</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Charge Amount</th>
																<th>Charge FP Type</th>
																<th>Status</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();

$sql = "SELECT * FROM $strMyTable WHERE Status='0'";


$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strChargeSetID = $row["ChargeSetID"];
		$getUID = EncodeQ($strChargeSetID);
		$getUIDDelete = Encode($strChargeSetID);		
		$ChargeAmt = $row["ChargeAmt"];
		$ChargeFPType = $row["ChargeFPType"];
		$ChargeDFType = $row["ChargeDFType"];
		$ChargeTypeValue = $row["ChargeTypeValue"];
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
																<td><?=$ChargeAmt?></td>
																<td><?if($ChargeFPType == '0')
																	{
																		echo "Fixed";
																	}
																	elseif($ChargeFPType =='1')
																	{
																		echo "Percentage";
																	}
																	?>
																</td>
																<td><?=$Status?></td>
																<td style="text-align: center">
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																	<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step13','<?=$getUIDDelete?>', 'Are you sure you want to delete this Charge Set - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
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
																<td></td>
																<td>No Records Found</td>
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
												<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Add Charge Set</h3>
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
		else if ($row["Field"]=="ChargeAmt")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ChargeAmt", "Charge Amount", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("ChargeAmt", "Charge Amount", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("ChargeAmt", "Charge Amount", $row["Field"])?>"></div>
													</div>
													
<?php
		}
		else if ($row["Field"]=="ChargeFPType")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ChargeFPType", "Charge FP Type", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3">
															<select name="<?=$row["Field"]?>" class="form-control required">
																<option value="">-- Choose Option --</option>
																<option value="0">Fixed</option>
																<option value="1">Percentage</option>	
															</select>
														</div>
													</div>
													<?php
		}
		else if ($row["Field"]=="SetName")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("SetName", "Set Name", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("SetName", "SetName", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("SetName", "SetName", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="ChargeDFType")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ChargeDFType", "Charge DF Type", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("ChargeDFType", "Charge DF Type", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("ChargeDFType", "Charge DF Type", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="ChargeTypeValue")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ChargeTypeValue", "Charge Type Value", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("ChargeTypeValue", "Charge Type Value", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("ChargeTypeValue", "Charge Type Value", $row["Field"])?>"></div>
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
								<a class="btn btn-primary btn-lg btn-block" href="<?=$strMyActionPage?>"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
						
							<div class="panel-body">
							<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email', '.admin_password'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

								
									<h3 class="title-hero">Edit Charge Set</h3>
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
			elseif($key=="ChargeAmt")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ChargeAmt", "Charge Amount", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("ChargeAmt", "Charge Amount", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="ChargeFPType")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ChargeFPType", "Charge FP Type", $key)?> <span>*</span></label>
												<div class="col-sm-2">
													<select name="<?=$key?>" class="form-control required">
														<?php
															if ($row[$key]=="0")
															{
														?>
																<option value="0" selected>Fixed</option>
																<option value="1">Percentage</option>
														<?php
															}
															elseif ($row[$key]=="1")
															{
														?>
																<option value="0">Fixed</option>
																<option value="1" selected>Percentage</option>
														<?php
															}
															else
															{
														?>
																<option value="" selected>-- Choose Option --</option>
																<option value="0">Fixed</option>
																<option value="1">Percentage</option>
														<?php
															}
														?>	
													</select>
												</div>
											</div>
<?php
			}
			elseif($key=="ChargeDFType")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ChargeDFType", "Charge DF Type", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("ChargeDFType", "Charge DF Type", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="ChargeTypeValue")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ChargeTypeValue", "Charge Type Value", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("ChargeTypeValue", "Charge Type Value", $key)?>" value="<?=$row[$key]?>"></div>
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