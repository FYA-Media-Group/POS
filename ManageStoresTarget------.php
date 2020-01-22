<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Manage Stores | NailSpa";
	$strDisplayTitle = "Manage Store Target for NailSpa";
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
			$strTargetAmount = Filter($_POST["TargetAmount"]);
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
						<p>The Target for this Month is already exists in system. Please Insert Target for different Month.</p>
					</div>
				</div>');
			}
			else
			{
				$currentYear = date('Y'); 
				$sqlInsert = "Insert into $strMyTable (StoreID, Month, Year, TargetAmount) Values
				('".$strStoreName."','".$strMonth."', '".$currentYear."','".$strTargetAmount."')";
				echo $sqlInsert;
				die();
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
					//echo "$sqlUpdate";
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
                        <p>Add, Edit, Delete Targets.</p>
                    </div>
<?php

if(isset($_GET["uid"]))
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
											
											<?
											$DB = Connect();
											$ID_StoreID = DecodeQ(Filter($_GET["uid"]));
											$sql_StoreName = "Select StoreName FROM tblStores WHERE StoreID = $ID_StoreID";
											$RS_StoreName = $DB->query($sql_StoreName);
											$row_StoreName = $RS_StoreName->fetch_assoc()
											
											?>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Targets at <?=$row_StoreName['StoreName']?></h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Month and Year</th>
																<th>Target</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Month and Year</th>
																<th>Target</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$ID = DecodeQ(Filter($_GET["uid"]));
$sql = "Select * FROM $strMyTable WHERE StoreID = $ID";
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
		$Month = $row["Month"];
		$TargetAmount = $row["TargetAmount"];
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$Month?></td>
																<td>Rs. <?=$TargetAmount?></td>
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
												<h3 class="title-hero">Add Target for </h3>
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
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("StoreName", "Store Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("StoreName", "Store Name", $row["Field"])?>" value="hieeeee<?=$row_StoreName['StoreName']?>" readonly ></div>
													</div>
<?php
		}
		else if ($row["Field"]=="Month")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Month", "Month", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Month", "Month", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Month", "Month", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="Year")
		{
?>
																									
												
<?php
		}
		else if ($row["Field"]=="TargetAmount")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("TargetAmount", "Target Amount", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("TargetAmount", "Target Amount", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("TargetAmount", "Target Amount", $row["Field"])?>"></div>
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