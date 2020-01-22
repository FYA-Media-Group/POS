<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Manage Campaign Analysis | Nailspa";
	$strDisplayTitle = "Manage Campaign Analysis for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblMembership";
	$strMyTableID = "MembershipID";
	$strMyField = "MembershipName";
	$strMyActionPage = "ManageCampaignAnalysis.php";
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
			
			// foreach($_POST as $key => $val)
			// {
				// echo $key ." = ".$_POST[$key];
			// }
			// die();
			
			$strMembershipID = Filter($_POST["MembershipID"]);
			$strCostOfMembership = Filter($_POST["Cost"]);
			$strMembershipName = Filter($_POST["MembershipName"]);
			$strType = Filter($_POST["Type"]);
			$strDiscountType = Filter($_POST["DiscountType"]);
			$strDiscount = Filter($_POST["Discount"]);
			$storeidp = $_POST["storeid"];
			//$storeidp = $_POST["storeid"];
			
			
			$strEndDay = $_POST["TimeForDiscountEnd"];
			$date1 = new DateTime($strEndDay);
			$strEndDay1 = $date1->format('Y-m-d'); // 31-07-2012
			
			
			
			$storename=implode(",",$storeidp);
	
			// foreach ($_POST["TimeForDiscountEnd"] AS $key2 => $val2)
			// {
				// if(IsNull($sqlColumnValues2))
				// {
					// $sqlColumn2 = $key2;
					// $sqlColumnValues2 = $val2;
				// }
				// else
				// {
					// $sqlColumn2 = $sqlColumn2." ".$key2;
					// $sqlColumnValues2 = $sqlColumnValues2." ".$val2;
				// }
			// }
			// $strTimeForDiscountEnd = $sqlColumnValues2;
			
			foreach ($_POST["NotValidOnServices"] AS $key1 => $val1)
			{
				if(IsNull($sqlColumnValues1))
				{
					$sqlColumn1 = $key1;
					$sqlColumnValues1 = $val1;
				}
				else
				{
					$sqlColumn1 = $sqlColumn1.",".$key1;
					$sqlColumnValues1 = $sqlColumnValues1.", ".$val1;
				}
			}
		
			$strNotValidOnServices = $sqlColumnValues1;
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
						<p>A Membership with the same Name already exists. Please try again with a different Name.</p>
					</div>
				</div>');
			}
			else
			{
				$sqlInsert = "INSERT INTO $strMyTable (MembershipName, Type, DiscountType, Discount, TimeForDiscountEnd, NotValidOnServices, Status, storeid, Cost) VALUES 
				('".$strMembershipName."', '".$strType."', '".$strDiscountType."', '".$strDiscount."', '".$strEndDay1."', '".$strNotValidOnServices."', '".$strStatus."', '".$storename."', '".$strCostOfMembership."')";
				ExecuteNQ($sqlInsert);
				//echo $sqlInsert;
				// die();
				
				$DB->close();
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
						<p>New Membership Added</p>
					</div>
				</div>');
			}
		}

		if($strStep=="edit")
		{
			$DB = Connect();
			/////////////For a string with comma separated IDs to be updated. //////////////
			foreach ($_POST["NotValidOnServices"] AS $key1 => $val1)
			{
				if(IsNull($sqlColumnValues1))
				{
					$sqlColumn1 = $key1;
					$sqlColumnValues1 = $val1;
				}
				else
				{
					$sqlColumn1 = $sqlColumn1.",".$key1;
					$sqlColumnValues1 = $sqlColumnValues1.", ".$val1;
				}
			}
			$_POST["NotValidOnServices"] = $sqlColumnValues1;
				$storeidp = $_POST["storeid"];
					$storename=implode(",",$storeidp);
			//////For datetime
			foreach ($_POST["TimeForDiscountEnd"] AS $key2 => $val2)
			{
				if(IsNull($sqlColumnValues2))
				{
					$sqlColumn2 = $key2;
					$sqlColumnValues2 = $val2;
				}
				else
				{
					$sqlColumn2 = $sqlColumn2." ".$key2;
					$sqlColumnValues2 = $sqlColumnValues2." ".$val2;
				}
			}
			$_POST["TimeForDiscountEnd"] = $sqlColumnValues2;
			////////////////////////////////////////////////////////////////////////////////
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
			$sqlUpdate1 = "UPDATE $strMyTable SET storeid='".$storename."' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					ExecuteNQ($sqlUpdate1);
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
	
	if(isset($_GET['renew']))
	{
			$DB = Connect();
		$ID=$_GET['renew'];
		$date=date('Y-m-d');
		$new_date = strtotime(date("Y-m-d", strtotime($date)) . " +12 month");
		$new_dated = date("Y-m-d",$new_date);
        $sell=select("*","tblMembership","MembershipID='".$ID."'");
		$endate=$sell[0]['TimeForDiscountEnd'];
		$sql = "SELECT * FROM tblCustomers WHERE memberid='".$ID."'";
		$RS = $DB->query($sql);
		if ($RS->num_rows > 0) 
		{
			$counter = 0;

			while($row = $RS->fetch_assoc())
			{
				
				$CustomerEmailID=$row['CustomerEmailID'];
						$CustomerFullName=$row['CustomerFullName'];
						$CustomerMobileNo=$row['CustomerMobileNo'];
						
						
						$strTo = $CustomerEmailID;
				$strFrom = "order@fyatest.website";
				$strSubject = "Your Membership Renew Successfully of Nailspa services";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$Name = $CustomerFullName;
				$strDate = $endate;
					
				$seldata=select("*","tblMembership","MembershipID='".$ID."'");
				$MembershipName=$seldata[0]['MembershipName'];
				$Type=$seldata[0]['Type'];
				if($Type=='0')
				{
					$type='Elite Membership';
				}
				else
				{
					$type='Normal Membership';
				}
				$DiscountType=$seldata[0]['DiscountType'];
				$Discount=$seldata[0]['Discount'];
				$TimeForDiscountEnd=$seldata[0]['TimeForDiscountEnd'];
				$storeid=$seldata[0]['storeid'];
				$sep=select("*","tblStores","StoreID='".$storeid."'");
				$officeaddress=$sep[0]['StoreOfficialAddress'];
				$storename=$sep[0]['StoreName'];
			    $branche=explode(",",$storename);
				$branchname=$branche[1]; 
		
				$message = file_get_contents('EmailFormat/membership_Renew.html');
				$message = eregi_replace("[\]",'',$message);
				//setup vars to replace
				$vars = array('{membership_name}','{member_name}','{Discount}','{TimeForDiscountEnd}','{Address}','{Branch}','{Renewdate}'); //Replace varaibles
				$values = array($MembershipName,$Name,$Discount,$TimeForDiscountEnd,$officeaddress,$branchname,$new_dated);

				//replace vars
				$message = str_replace($vars,$values,$message);

				$strBody1 = $message;
				
				// exit();
				 
				$flag='CM';
				$id = $last_id2;
				
				sendmail($id,$strTo,$strFrom,$strSubject,$strBody1,$strDate,$flag,$strStatus);
			}
		}
	
					
		$sqlUpdate = "UPDATE $strMyTable SET TimeForDiscountEnd='".$new_dated."' WHERE $strMyTableID='".$ID."'";
					ExecuteNQ($sqlUpdate);
					
					$msg="Membership Renew Successfully";
					$DB->close();
					header('Location:ManageMemberships.php?msg='.$msg.'');
	}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	<script>
						$(function ()						
						{
							$("#StartDay").datepicker({ minDate: 0 });
							$("#EndDay").datepicker({ minDate: 0 });
							$("#StartDay1").datepicker({ minDate: 0 });
							$("#EndtDay1").datepicker({ minDate: 0 });
							
						});
					</script>
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
                        <p>Add, Edit, Delete Memberships</p>
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
												<h3 class="title-hero">List of Campaign | Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Campaign Analysis</th>
																<th>Description</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Campaign Analysis</th>
																<th>Description</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SELECT * FROM tblCampaignAnalysis WHERE Status='0'";
// echo $sql."<br>";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$CampaignAnalysisID = $row["CampaignAnalysisID"];
		$getUID = EncodeQ($CampaignAnalysisID);
		$getUIDDelete = Encode($CampaignAnalysisID);		
		$Name = $row["Name"];
	
		$Descriprtion = $row["Descriprtion"];
		
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
																<td><?=$Name?></td>
																
																<td>
																<?=$Descriprtion?>
																</td>
															
																<td>
																<?
																	$count_services = count($arrNotValidOnServices);
																	$sql_display = "SELECT * FROM tblServices";
																	$RS_display = $DB->query($sql_display);
																	if ($RS_display->num_rows > 0) 
																	{
																		while($row_display = $RS_display->fetch_assoc())
																		{
																			$ServiceName = $row_display["ServiceName"];
																			$ServiceID = $row_display["ServiceID"];
																			if (in_array("$ServiceID", $arrNotValidOnServices))
																			{
																				if($count_services > '1')
																				{
																					echo $ServiceName.",<br>";
																					$count_services = $count_services - '1';
																				}
																				elseif($count_services == '1')
																				{
																					echo $ServiceName;
																					$count_services = $count_services - '1';
																				}
																				elseif($count_services == '0')
																				{
																					break;
																				}
																			}
																			else
																			{
																				
																			}
																		}
																	}																	
																	foreach ($arrNotValidOnServices AS $key => $val)
																	{
																		
																	}
																?>
																</td>
																<td style="text-align: center">
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																		<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step21','<?=$getUIDDelete?>', 'Are you sure you want to delete this Membership - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
																	<?php 
																	}
																	?>
																	
																	<br>
																	<?php  
																	$seldata=select("*","tblMembership","MembershipID='".$strMembershipID."'");
																	$discountend=$seldata[0]['TimeForDiscountEnd'];
																	//echo $discountend;
																	$edate=date('Y-m-d', strtotime($discountend));
																	$todate=date('Y-m-d');
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

											
												<h3 class="title-hero">Add Memberships</h3>
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
		else if ($row["Field"]=="MembershipName")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("MembershipName", "Membership Name", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("MembershipName", "Membership Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("MembershipName", "Membership Name", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="Type")
		{
?>	
													<!--<div class="form-group"><label class="col-sm-3 control-label"><?//=str_replace("Type", "Type", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3">
															<select name="<?//=$row["Field"]?>" class="form-control required">
																<option value="0" Selected>Elite</option>
																<option value="1">Normal</option>	
															</select>
														</div>
													</div>-->
<?
		}
		else if ($row["Field"]=="DiscountType")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("DiscountType", "Discount is", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-4">
															<select name="<?=$row["Field"]?>" class="form-control required">
																<option value="0" Selected>In Percent</option>
																<option value="1">In Amount</option>	
															</select>
														</div>
													</div>
<?
		}
		else if ($row["Field"]=="Discount")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Discount", "Discount", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Discount", "Discount", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Discount", "Discount", $row["Field"])?>"></div>
													</div>
<?
		}
 	else if ($row["Field"]=="TimeForDiscountEnd")
		{

		} 
		else if ($row["Field"]=="NotValidOnServices")
		{
											
?>											
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("NotValidOnServices", "Not Valid On Services", $row["Field"])?> <span>*</span></label><p>Press control and select</p>
														<div class="col-sm-4">
														
									<?php
											$sql1 = "SELECT ServiceID, ServiceName FROM tblServices WHERE Status=0";
											$RS2 = $DB->query($sql1);
											if ($RS2->num_rows > 0)
											{
									?>
															<select name="<?=$row["Field"]?>[]" class="form-control" multiple style="height:100pt">
																	<option value="" selected>--Select Services--</option>
<?
																		while($row2 = $RS2->fetch_assoc())
																		{
																			$selectServiceID = $row2["ServiceID"];
																			$ServiceName = $row2["ServiceName"];	
?>
																			<option value="<?=$selectServiceID?>"><?=$ServiceName?></option>
<?php
																		}
?>
															</select>
<?php
											}
											else
											{
												echo "<font color='red'>Feed Services in the system to select on which services this membership is not valid!</font>";
											}
?>
														</div>
													</div>
<?
		}
		else if ($row["Field"]=="storeid")
		{
											
?>											
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("storeid", "Store", $row["Field"])?> <span>*</span></label><p>Press control and select</p>
														<div class="col-sm-4">
														
										<?php
											$sql1 = "SELECT * FROM tblStores WHERE Status=0";
											$RS2 = $DB->query($sql1);
											if ($RS2->num_rows > 0)
											{
										?>
															<select name="<?=$row["Field"]?>[]" class="form-control" multiple style="height:80pt">
																	<option value="">--Select Stores--</option>
<?
																		while($row2 = $RS2->fetch_assoc())
																		{
																			$storeid = $row2["StoreID"];
																			$storename = $row2["StoreName"];	
?>
																			<option value="<?=$storeid?>" selected><?=$storename?></option>
<?php
																		}
?>
															</select>
<?php
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
														<div class="col-sm-4">
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
															<div class="col-sm-4"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Admin", " ", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Admin", " ", $row["Field"])?>"></div>
														</div>
<?php
		}
	}
?>
														<div class="form-group">
															<label class="col-sm-3 control-label"></label>
															<input type="submit" class="btn ra-100 btn-primary" value="Submit">
															<div class="col-sm-2">
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
												<div class="col-sm-4"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("MembershipName", "Membership Name", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="Type")
			{
?>
											<!--<div class="form-group"><label class="col-sm-3 control-label"><?//=str_replace("Type", "Type", $key)?> <span>*</span></label>
												<div class="col-sm-3">
													<select name="<?//=$key?>" class="form-control required">
														<?php
															// if ($row[$key]=="0")
															// {
														?>
																<option value="0" selected>Elite</option>
																<option value="1">Normal</option>
														<?php
															// }
															// elseif ($row[$key]=="1")
															// {
														?>
																<option value="0">Elite</option>
																<option value="1" selected>Normal</option>
														<?php
															// }
															// else
															// {
														?>
																<option value="" selected>--Choose option--</option>
																<option value="0">Elite</option>
																<option value="1">Normal</option>
														<?php
															// }
														?>	
													</select>
												</div>
											</div>-->
<?php	
			}
			elseif($key=="DiscountType")
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("DiscountType", "Discount Type", $key)?> <span>*</span></label>
												<div class="col-sm-4">
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
												<div class="col-sm-4"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Discount", "Discount", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
		 elseif($key=="TimeForDiscountEnd")
			{

			} 
			elseif($key=="NotValidOnServices")
			{
				$ServiceIDs = $row[$key];
				$strNotValidOnServices = array();
				$strNotValidOnServices = explode(",",$ServiceIDs);
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("NotValidOnServices", "Not Valid On Services", $key)?> <span>*</span></label>
												<div class="col-sm-4">
													<select name="<?=$key?>[]" class="form-control" multiple style="height:100pt">
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
																		<option selected value="<?=$ServiceID?>"><?=$ServiceName?></option>
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
			elseif($key=="storeid")
			{
				?>
					<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("storeid", "Store", $key)?> <span>*</span></label>
												<div class="col-sm-4">
													<select name="<?=$key?>[]" class="form-control required" multiple style="height:80pt">
														<option value="0">Select Here</option>
														<?php  
														$storep=$row[$key];
														$stores=explode(",",$storep);
														for($i=0;$i<count($stores);$i++)
														{
															$seldata=select("*","tblStores","StoreID='".$stores[$i]."'");
															foreach($seldata as $value)
															{
														?>
															<option value="<?php echo $value['StoreID'] ?>"<?php if($stores[$i]==$value['StoreID']){ ?> selected='selected' <?php } ?>><?php echo $value['StoreName'] ?></option>	
														<?php
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
												<div class="col-sm-4">
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
												<div class="col-sm-4"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Admin", " ", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
		}
	}
?>
											<div class="form-group"><label class="col-sm-3 control-label"></label>
												<input type="submit" class="btn ra-100 btn-primary" value="Update">
												
												<div class="col-sm-2"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
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