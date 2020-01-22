<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Assign Memberships | Nailspa";
	$strDisplayTitle = "Assign Memberships to Customers at Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblCustomerMemberShip";
	$strMyTableID = "CustomerMembershipID";
	$strMyField = "";
	$strMyActionPage = "AssignMembership.php";
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
			$strCustomerMembershipID = Filter($_POST["CustomerMembershipID"]);
			$strCustomerID = Filter($_POST["CustomerID"]);
			$strMembershipID = Filter($_POST["MembershipID"]);
			$strStartDay = Filter($_POST["StartDay"]);
			$strEndDay = Filter($_POST["EndDay"]);
			$strComment = Filter($_POST["Comment"]);
			$strStatus = Filter($_POST["Status"]);

			$DB = Connect();
			$sql = "SELECT $strMyTableID FROM $strMyTable WHERE $strMyField='$_POST[$strMyField]'";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						<p>A Membership is already assigned to this Customer. A Customer cannot be assigned two Memberships.</p>
					</div>
				</div>');
			}
			else
			{
				$sqlInsert = "INSERT INTO $strMyTable (CustomerID, MembershipID, StartDay, EndDay, Comment, Status) VALUES 
				('".$strCustomerID."', '".$strMembershipID."', '".$strStartDay."', '".$strEndDay."', '".$strComment."', '".$strStatus."')";
				ExecuteNQ($sqlInsert);
				// echo $sqlInsert;
				// die();
				
				$DB->close();
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
						<p>Membership Successfully Assigned</p>
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
                        <p>Assign Membership</p>
                    </div>
<?php

if(isset($_GET['aid']))//assign id
{
?>					
					
                    <div class="panel">
						<div class="panel">
							<div class="panel-body">
								
								<div class="example-box-wrapper">
									<div class="tabs">
										<ul>
											<li><a href="#normal-tabs-2" title="Tab 2">Add</a></li>
										</ul>
										<div id="normal-tabs-2">
											<div class="panel-body">
												<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">
												<h3 class="title-hero">Add Memberships</h3>
												<div class="example-box-wrapper">
													
<?php
// Create connection And Write Values
$strID = DecodeQ(Filter($_GET['aid']));
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
		else if ($row["Field"]=="CustomerID")
		{
			$sql_custName = "SELECT CustomerFullName, CustomerID FROM tblCustomers WHERE CustomerID = $strID";
			$RS_custName = $DB->query($sql_custName);
			$row_custName = $RS_custName->fetch_assoc();
			$CustomerFullName = $row_custName['CustomerFullName'];
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerID", "Customer Name", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3">
																<input readonly type="text" name="<?=$row["Field"]?>" id="<?=str_replace("CustomerID", "Customer Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("CustomerID", "Customer Name", $row["Field"])?>" value="<?=$CustomerFullName?>">
															</div>
													</div>
<?php
		}
		else if ($row["Field"]=="MembershipID")
		{
			$sql_membershipName = "SELECT MembershipID, MembershipName FROM tblMembership";
			$RS_membershipName = $DB->query($sql_membershipName);
			
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Membership", "MembershipID", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3">
															<select name="<?=$row["Field"]?>" class="form-control required">
															<?
																while($row_membershipName = $RS_membershipName->fetch_assoc())
																{
																	$MembershipID = $row_membershipName['MembershipID'];
																	$MembershipName = $row_membershipName['MembershipName'];
															?>
																<option value="<?=$MembershipID?>" Selected><?=$MembershipName?></option>
															<?
																}
															?>																
															</select>
														</div>
													</div>
<?
		}
		else if ($row["Field"]=="StartDay")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StartDay", "Starts On", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3">
																<input type="date" name="<?=$row["Field"]?>[]" id="<?=str_replace("StartDay", "Starts On", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("StartDay", "Starts On", $row["Field"])?>">
															</div>
													</div>
<?
		}
		else if ($row["Field"]=="EndDay")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EndDay", "Ends On", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3">
																<input type="date" name="<?=$row["Field"]?>[]" id="<?=str_replace("EndDay", "Ends On", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("EndDay", "Ends On", $row["Field"])?>">
															</div>
													</div>
<?
		}
		else if ($row["Field"]=="Comment")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerID", "Customer Name", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3">
																<textarea name="<?=$row["Field"]?>" id="<?=str_replace("CustomerID", "Customer Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("CustomerID", "Customer Name", $row["Field"])?>"></textarea>
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
														<div class="form-group">
															<label class="col-sm-3 control-label"></label>
															<input type="submit" class="btn ra-100 btn-primary" value="Submit">
															<div class="col-sm-1">
																<a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a>
															</div>
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

								
									<h3 class="title-hero">Edit Customers</h3>
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
			elseif($key=="MembershipName")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("MembershipName", "Membership Name", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("MembershipName", "Membership Name", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="Type")
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Type", "Type", $key)?> <span>*</span></label>
												<div class="col-sm-3">
													<select name="<?=$key?>" class="form-control required">
														<?php
															if ($row[$key]=="0")
															{
														?>
																<option value="0" selected>Elite</option>
																<option value="1">Normal</option>
														<?php
															}
															elseif ($row[$key]=="1")
															{
														?>
																<option value="0">Elite</option>
																<option value="1" selected>Normal</option>
														<?php
															}
															else
															{
														?>
																<option value="" selected>--Choose option--</option>
																<option value="0">Elite</option>
																<option value="1">Normal</option>
														<?php
															}
														?>	
													</select>
												</div>
											</div>
<?php	
			}
			elseif($key=="DiscountType")
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("DiscountType", "Discount Type", $key)?> <span>*</span></label>
												<div class="col-sm-3">
													<select name="<?=$key?>" class="form-control required">
														<?php
															if ($row[$key]=="0")
															{
														?>
																<option value="0" selected>Percent</option>
																<option value="1">Amount</option>
														<?php
															}
															elseif ($row[$key]=="1")
															{
														?>
																<option value="0">Percent</option>
																<option value="1" selected>Amount</option>
														<?php
															}
															else
															{
														?>
																<option value="" selected>--Choose option--</option>
																<option value="0">Percent</option>
																<option value="1">Amount</option>
														<?php
															}
														?>	
													</select>
												</div>
											</div>
<?php	
			}
			elseif($key=="Discount")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Discount", "Discount", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Discount", "Discount", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="TimeForDiscountEnd")
			{
				$strDateTime = $row[$key];
				$arrDateTime = array();
				$arrDateTime = explode(" ",$strDateTime);
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("TimeForDiscountEnd", "Discount Ends On", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="date" name="<?=$key?>[]" class="form-control required" placeholder="<?=str_replace("TimeForDiscountEnd", "Discount Ends On", $key)?>" value="<?=$arrDateTime['0']?>"></div>
											</div>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("TimeForDiscountEnd", "Discount Ends At", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="time" name="<?=$key?>[]" class="form-control required" placeholder="<?=str_replace("TimeForDiscountEnd", "Discount Ends At", $key)?>" value="<?=$arrDateTime['1']?>"></div>
											</div>
<?php
			}
			elseif($key=="NotValidOnServices")
			{
				$ServiceIDs = $row[$key];
				$strNotValidOnServices = array();
				$strNotValidOnServices = explode(",",$ServiceIDs);
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("NotValidOnServices", "Not Valid On Services", $key)?> <span>*</span></label>
												<div class="col-sm-4">
													<select name="<?=$key?>[]" class="form-control required" multiple>
														<?php
															$sql_display = "SELECT * FROM tblServices";
															$RS_display = $DB->query($sql_display);
															if ($RS_display->num_rows > 0) 
															{
																while($row_display = $RS_display->fetch_assoc())
																{
																	$ServiceName = $row_display["ServiceName"];
																	$ServiceID = $row_display["ServiceID"];
																	if (in_array("$ServiceID", $strNotValidOnServices))
																	{
																	?>
																		<option selected value="<?=$ServiceID?>"><mark><?=$ServiceName?></mark></option>
																	<?
																	}
																	else
																	{
																	?>
																		<option value="<?=$ServiceID?>"><?=$ServiceName?></option>
																	<?
																	}
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