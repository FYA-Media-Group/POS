<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Appointment Details | Nailspa";
	$strDisplayTitle = "Enter Appointment Details for Nailspa";
	$strMenuID = "3";
	$strMyTable = "tblAppointmentsDetails";
	$strMyTableID = "AppointmentDetailsID";
	$strMyField = "";
	$strMyActionPage = "AppointmentDetails.php";
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
                        <p>Add appointment Details.</p>
                    </div>
<?php

if(isset($_GET["aid"]))
{

?>					
					
                    <div class="panel">
						<div class="panel">
							<div class="panel-body">
								
								<div class="example-box-wrapper">
									<div id="normal-tabs-2">
										<div class="panel-body">
											<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
										
										<span class="result_message">&nbsp; <br>
										</span>
										<input type="hidden" name="step" value="add">

										
											<h3 class="title-hero">Add Details</h3>
											<div class="example-box-wrapper">
												
<?php
// Create connection And Write Values
$DB = Connect();

$strAppointmentDetailsID = $_GET['aid'];
$sql1 = "SELECT * FROM tblAppointmentsDetails WHERE AppointmentDetailsID = $strAppointmentDetailsID";
$RS1 = $DB->query($sql1);
$row1 = $RS1->fetch_assoc();
$strAppointmentID = $row1['AppointmentID'];
$strServiceID = $row1['ServiceID'];
$strServiceAmount = $row1['ServiceAmount'];








$sql = "SHOW COLUMNS FROM ".$strMyTable." ";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

while($row = $RS->fetch_assoc())
{
	if($row["Field"]=="AppointmentDetailsID")
	{
?>	
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AppointmentDetailsID", "Appointment Details ID", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3"><input readonly value="<?=$strAppointmentDetailsID?>" type="text" name="<?=$row["Field"]?>" id="<?=str_replace("AppointmentDetailsID", "Appointment Details ID", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("AppointmentDetailsID", "Appointment Details ID", $row["Field"])?>"></div>
												</div>
<?php
	}
	else if ($row["Field"]=="AppointmentID")
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
														<div class="col-sm-5"><textarea rows="4" name="<?=$row["Field"]?>" id="<?=str_replace("StoreOfficialAddress", "Store Official Address", $row["Field"])?>" class="form-control required  " placeholder="<?=str_replace("StoreOfficialAddress", "Store Official Address", $row["Field"])?>"></textarea></div>
												</div>
<?php
	}
	else if ($row["Field"]=="StoreBillingAddress")
	{
?>
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreBillingAddress", "Store Billing Address", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-5"><textarea rows="4" name="<?=$row["Field"]?>" id="<?=str_replace("StoreBillingAddress", "Store Billing Address", $row["Field"])?>" class="form-control required " placeholder="<?=str_replace("StoreBillingAddress", "Store Billing Address", $row["Field"])?>"></textarea></div>
												</div>	
<?php
	}
	else if ($row["Field"]=="StoreOfficialEmailID")
	{
?>
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreOfficialEmailID", "Store Official Email ID", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("StoreOfficialEmailID", "Store Official Email ID", $row["Field"])?>" class="form-control required admin_email" placeholder="<?=str_replace("StoreOfficialEmailID", "Store Official Email ID", $row["Field"])?>"></div>
												</div>	
<?php
	}
	else if ($row["Field"]=="StoreBillingEmailID")
	{
?>
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreBillingEmailID", "Store Billing Email ID", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("StoreBillingEmailID", "Store Billing Email ID", $row["Field"])?>" class="form-control required admin_email" placeholder="<?=str_replace("StoreBillingEmailID", "Store Billing Email ID", $row["Field"])?>"></div>
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
<?php
} // End null condition

?>	                   
                </div>
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>