<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Manage Stores | NailSpa";
	$strDisplayTitle = "Manage Stores for NailSpa";
	$strMenuID = "3";
	$strMyTable = "tblStores";
	$strMyTableID = "StoreID";
	$strMyField = "StoreName";
	$strMyActionPage = "ManageStores.php";
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
			$strStoreOfficialAddress = Filter($_POST["StoreOfficialAddress"]);
			$strStoreBillingAddress = Filter($_POST["StoreBillingAddress"]);
			$strStoreOfficialEmailID = Filter($_POST["StoreOfficialEmailID"]);
			$strStoreBillingEmailID = Filter($_POST["StoreBillingEmailID"]);
			$strStoreOfficialNumber = Filter($_POST["StoreOfficialNumber"]);
			$strStoreBillingNumber = Filter($_POST["StoreBillingNumber"]);
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
						<p>The Store Name already exists in our system. Please try again with a different Name.</p>
					</div>
				</div>');
			}
			else
			{
				$sqlInsert = "Insert into $strMyTable (StoreName, StoreOfficialAddress, StoreBillingAddress, StoreOfficialEmailID, StoreBillingEmailID, StoreOfficialNumber, StoreBillingNumber, Status) values
				('".$strStoreName."','".$strStoreOfficialAddress."', '".$strStoreBillingAddress."', '".$strStoreOfficialEmailID."', '".$strStoreBillingEmailID."', '".$strStoreOfficialNumber."', '".$strStoreBillingNumber."', '".$strStatus."')";
				// echo $sqlInsert;
				ExecuteNQ($sqlInsert);
				$DB->close();
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
						<p>Information message box using the color scheme.</p>
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
					$sqlUpdate = "update $strMyTable set $key='$_POST[$key]' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					ExecuteNQ($sqlUpdate);
					//echo "$sqlUpdate";
				}
			}
			$DB->close();
			die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Updated Successfully</h4>
						<p>Information message box using the color scheme.</p>
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
                        <p>Add, Edit, Delete Stores.</p>
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
												<h3 class="title-hero">List of Stores for POS</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Store Name <br>Address</th>
																<th>Billing Email ID <br>Official Email ID</th>
																<th>Official Number<br>Billing Number</th>
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Store Name <br>Address</th>
																<th>Billing Email ID <br>Official Email ID</th>
																<th>Official Number<br>Billing Number</th>
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$sql = "Select * FROM $strMyTable order by $strMyTableID desc";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strStoreID = $row["StoreID"];
		$getUID = EncodeQ($strStoreID);
		$getUIDDelete = Encode($strStoreID);		
		$StoreName = $row["StoreName"];
		$StoreOfficialAddress = $row["StoreOfficialAddress"];
		$StoreBillingAddress = $row["StoreBillingAddress"];
		$StoreOfficialEmailID = $row["StoreOfficialEmailID"];
		$StoreBillingEmailID = $row["StoreBillingEmailID"];
		$StoreOfficialNumber = $row["StoreOfficialNumber"];
		$StoreBillingNumber = $row["StoreBillingNumber"];
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
																<td><b>Store Name:</b><br><?=$StoreName?></td>
																<td><b>Email ID:</b><br><?=$StoreBillingEmailID?><br><b>Billing Email ID:<br></b><?=$StoreBillingEmailID?></td>
																<td><b>Billing Number:</b><br><?=$StoreBillingNumber?><br><b>Contact No:</b><br><?=$StoreOfficialNumber?></td>
																<td><?=$Status?></td>
																<td>
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step8','<?=$getUIDDelete?>', 'Are you sure you want to delete this Store - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
																	<div class="panel">
                                <div class="panel-body">
                                    <h3 class="title-hero">jQueryUI Dialog</h3>
                                    <div class="example-box-wrapper"><a href="#" class="btn btn-primary basic-dialog">Open dialog</a>
                                        <div class="hide" id="basic-dialog" title="Basic dialog title">
                                            <div class="pad10A">Dialog content here</div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
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

											
												<h3 class="title-hero">Add Store</h3>
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
		else if ($row["Field"]=="StoreName")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreName", "Store Name", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("StoreName", "Store Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("StoreName", "Store Name", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="StoreOfficialAddress")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreOfficialAddress", "Store Official Address", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("StoreOfficialAddress", "Store Official Address", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("StoreOfficialAddress", "Store Official Address", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="StoreBillingAddress")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreBillingAddress", "Store Billing Address", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("StoreBillingAddress", "Store Billing Address", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("StoreBillingAddress", "Store Billing Address", $row["Field"])?>"></div>
													</div>	
<?php
		}
		else if ($row["Field"]=="StoreOfficialEmailID")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreOfficialEmailID", "Store Official Email ID", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("StoreOfficialEmailID", "Store Official Email ID", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("StoreOfficialEmailID", "Store Official Email ID", $row["Field"])?>"></div>
													</div>	
<?php
		}
		else if ($row["Field"]=="StoreBillingEmailID")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreBillingEmailID", "Store Billing Email ID", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("StoreBillingEmailID", "Store Billing Email ID", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("StoreBillingEmailID", "Store Billing Email ID", $row["Field"])?>"></div>
													</div>	
<?php
		}
		else if ($row["Field"]=="StoreOfficialNumber")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreOfficialNumber", "Store Official Number", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("StoreOfficialNumber", "Store Official Number", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("StoreOfficialNumber", "Store Official Number", $row["Field"])?>"></div>
													</div>	
<?php
		}
		else if ($row["Field"]=="StoreBillingNumber")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreBillingNumber", "Store Billing Number", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("StoreBillingNumber", "Store Billing Number", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("StoreBillingNumber", "Store Billing Number", $row["Field"])?>"></div>
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

								
									<h3 class="title-hero">Edit Stores</h3>
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
			elseif($key=="StoreName")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreName", "Store Name", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("StoreName", "Store Name", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="StoreOfficialAddress")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreOfficialAddress", "Store Official Address", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("StoreOfficialAddress", "Store Official Address", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="StoreBillingAddress")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreBillingAddress", "Store Billing Address", $key)?> <span>*</span></label>
												<div class="col-sm-5"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("StoreBillingAddress", "Store Billing Address", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="StoreOfficialEmailID")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreOfficialEmailID", "Store Official Email ID", $key)?> <span>*</span></label>
												<div class="col-sm-5"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("StoreOfficialEmailID", "Store Official Email ID", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="StoreBillingEmailID")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreBillingEmailID", "Store Billing Email ID", $key)?> <span>*</span></label>
												<div class="col-sm-5"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("StoreBillingEmailID", "Store Billing Email ID", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="StoreOfficialNumber")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreOfficialNumber", "Store Official Number", $key)?> <span>*</span></label>
												<div class="col-sm-5"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("StoreOfficialNumber", "Store Official Number", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="StoreBillingNumber")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreBillingNumber", "Store Billing Number", $key)?> <span>*</span></label>
												<div class="col-sm-5"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("StoreBillingNumber", "Store Billing Number", $key)?>" value="<?=$row[$key]?>"></div>
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