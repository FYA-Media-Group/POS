<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Manage Vendor/Brand | Nailspa";
	$strDisplayTitle = "Manage Vendor/Brand | Nailspa";
	$strMenuID = "3";
	$strMyTable = "tblProductBrand";
	$strMyTableID = "BrandID";
	$strMyField = "BrandName";
	$strMyActionPage = "ManageBrandMaster.php";
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
			$BrandName = ucfirst(Filter($_POST["BrandName"]));
			$Address = ucfirst(Filter($_POST["Address"]));
			$Mobile = Filter($_POST["Mobile"]);
			$EmailID = Filter($_POST["EmailID"]);
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
				$sqlInsert = "Insert into $strMyTable (BrandName, Address, Mobile, EmailID, Status) values
				('".$BrandName."','".$Address."', '".$Mobile."', '".$EmailID."', '".$strStatus."')";
			//	echo $sqlInsert;
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
					$sqlUpdate = "update $strMyTable set $key='$_POST[$key]' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
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
                        <p>Add, Edit, Delete Brand/Vendor.</p>
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
												<h3 class="title-hero">List of Brands for POS</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Brand Name <br>Address</th>
																<th>Brand Email ID </th>
																<th>Brand Number</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Brand Name <br>Address</th>
																<th>Brand Email ID </th>
																<th>Brand Number</th>
																<th>Actions</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();

// $sql = "SELECT tblStores.StoreID, tblStores.StoreName,tblStores.StoreOfficialAddress, tblStores.StoreBillingAddress, tblStores.StoreOfficialEmailID, tblStores.StoreBillingEmailID, tblStores.StoreOfficialNumber, tblStores.StoreBillingNumber, tblStoreSalesTarget.StoreID, tblStoreSalesTarget.Month,
// tblStoreSalesTarget.Year, tblStoreSalesTarget.TargetAmount From tblStores LEFT JOIN tblStoreSalesTarget ON tblStores.StoreID=tblStoreSalesTarget.StoreID WHERE (tblStoreSalesTarget.StoreID IS NULL) OR (tblStoreSalesTarget.StoreID IS NOT NULL)";

$sql = "SELECT * FROM tblProductBrand order by 	BrandID desc";

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$BrandID = $row["BrandID"];
		$getUID = EncodeQ($BrandID);
		$getUIDDelete = Encode($BrandID);		
		$BrandName = $row["BrandName"];
		$Address = $row["Address"];
		$Mobile = $row["Mobile"];
		$EmailID = $row["EmailID"];
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
																<td><b>Brand Name:</b><br><?=$BrandName?></td>
																<td><b>Email ID:</b><br><?=$EmailID?></td>
																<td><b>Brand Number:</b><br><?=$Mobile?></td>
																
																<td style="text-align: center">
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																	<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step27','<?=$getUIDDelete?>', 'Are you sure you want to delete this Brand ?','my_data_tr_<?=$counter?>');">Delete</a>
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

											
												<h3 class="title-hero">Add Brand/Vendor</h3>
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
		else if ($row["Field"]=="BrandName")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("BrandName", "Brand/Vendor Name", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" style="text-transform:capitalize" name="<?=$row["Field"]?>" id="<?=str_replace("BrandName", "Brand Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("BrandName", "Brand Name", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="Address")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Address", "Address", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-5"><textarea rows="4" style="text-transform:capitalize" name="<?=$row["Field"]?>" id="<?=str_replace("Address", "Address", $row["Field"])?>" class="form-control required  " placeholder="<?=str_replace("Address", "Address", $row["Field"])?>"></textarea></div>
													</div>
<?php
		}
		else if ($row["Field"]=="Mobile")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Mobile", "Mobile", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text"  pattern="[0-9]{10}" title="Enter a valid mobile number!" name="<?=$row["Field"]?>" id="<?=str_replace("Mobile", "Mobile", $row["Field"])?>" class="form-control required admin_email" placeholder="<?=str_replace("Mobile", "Mobile", $row["Field"])?>"></div>
													</div>	
<?php
		}
		else if ($row["Field"]=="EmailID")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmailID", "Email", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("EmailID", "Email", $row["Field"])?>" class="form-control required admin_email" placeholder="<?=str_replace("EmailID", "Email", $row["Field"])?>"></div>
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

								
									<h3 class="title-hero">Edit Brand/Vendor</h3>
									<div class="example-box-wrapper">
										
<?php
//echo 1244;
$DB = Connect();
$strID = DecodeQ(Filter($_GET["uid"]));

$sql = "SELECT * FROM $strMyTable WHERE $strMyTableID = '".$strID."'";
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
			elseif($key=="BrandName")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("BrandName", "Brand Name", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" style="text-transform:capitalize" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("BrandName", "Brand Name", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="Address")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Address", "Address", $key)?> <span>*</span></label>
												<div class="col-sm-5"><textarea rows="4" style="text-transform:capitalize" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Address", "Address", $key)?>"><?=$row[$key]?></textarea></div>
											</div>
<?php
			}
			elseif($key=="Mobile")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Mobile", "Mobile", $key)?> <span>*</span></label>
												<div class="col-sm-5"><input type="text"  pattern="[0-9]{10}" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Mobile", "Mobile", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="EmailID")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmailID", "EmailID", $key)?> <span>*</span></label>
												<div class="col-sm-5"><input type="text" name="<?=$key?>" class="form-control admin_email required" placeholder="<?=str_replace("EmailID", "EmailID", $key)?>" value="<?=$row[$key]?>"></div>
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