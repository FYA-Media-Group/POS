<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Slider Management | Nailspa";
	$strDisplayTitle = "Slider Management for Nailspa";
	$strMenuID = "7";
	$strMyTable = "tblSlider";
	$strMyTableID = "SliderID";
	$strMyField = "SliderImgURL";
	$strMyActionPage = "ManageSlider.php";
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
			$strValidateImage1 = trim(ValidateImageFile($_FILES, "SliderImgURL"));
			if($strValidateImage1=="Saved successfully")
			{
				$filepath = 'imageupload/images';
				// for First Image
				$filename = $_FILES["SliderImgURL"]["name"];
				
				$uploadFilename = UniqueStamp().$filename;	
				$strImageUploadPath = $filepath."/".$uploadFilename;
				// #######################
				
				$strSocialURL = Filter($_POST["SliderImgURL"]);
				$strStatus = Filter($_POST["Status"]);
				$strPriority = Filter($_POST["Priority"]);
								
				$DB = Connect();
			
				$sqlInsert = "Insert into $strMyTable (SliderImgURL,Priority, Status) values
				('".$strImageUploadPath."', '".$strPriority."','".$strStatus."')";
				
				$DB->query($sqlInsert);
				
				$DB->Close();

				die('<div class="alert alert-close alert-success">
						<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
						<div class="alert-content">
							<h4 class="alert-title">Record Added Successfully</h4>
							<p>Information message box using the color scheme.</p>
						</div>
					</div>');
			}
			else
			{
				die($strValidateImage1);
			}
		}
			
			

	
		if($strStep=="edit")
		{
			
			// $Description = Filter($_POST["EventUpcomingDescription"]);
			// $EventStartDate = Filter($_POST["EventStartDate"]);
			// $EventEndDate = Filter($_POST["EventEndDate"]);
			// $strType = Filter($_POST["EventType"]);
			
			if($strType=="4")
			{
				// echo "Yes--type4";
				//die($strType);
				if(isset($_FILES["SliderImgURL"]["error"]))
				{
					$strValidateImage1 = trim(ValidateVideoFile($_FILES, "SliderImgURL"));
					if($strValidateImage1=="Saved successfully")
					{
					
						// As the image is valid first select the imagename for previous image
						
						$DB = Connect();
						$sql = "Select SliderImgURL FROM tblSlider where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
						$RS = $DB->query($sql);
						if ($RS->num_rows > 0) 
						{
							while($row = $RS->fetch_assoc())
							{
							$strOldImageURL = $row["SliderImgURL"];	
							}

							// As we got the old image we will delete this image from server
							
							$file = $strOldImageURL;
							if (!unlink($file))
							{
								//die("Error deleting Old Image File");
							}
							else
							{
								// As we the old image file is deleted from the server we will add the new file in database
								
								$filepath = 'imageupload/images';
								// for First Image
								$filename1 = $_FILES["SliderImgURL"]["name"];
								
								$uploadFilename1 = UniqueStamp().$filename1;		
								$strImageUploadPath1 = $filepath."/".$uploadFilename1;
								// #######################
								
									
								
									$sqlUpdate = "update tblSlider set SliderImgURL='".$strImageUploadPath1."' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
									//echo $sqlUpdate;
									ExecuteNQ($sqlUpdate);
								
								
								echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
										</button>
										<strong>Video Updated Successfully</strong>
										</div>');
							}	

							
						}
						else
						{
							die('<div class="alert alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Old Video not Found</strong>
								</div>');
						}					
						
					}
					else
					{
						die($strValidateImage1);
					}
				}	
			}
			else
			{
				// echo "No-- in else";
				if(isset($_FILES["SliderImgURL"]["error"]))
				{
					$strValidateImage1 = trim(ValidateImageFile($_FILES, "SliderImgURL"));
					if($strValidateImage1=="Saved successfully")
					{
					
						// As the image is valid first select the imagename for previous image
						
						$DB = Connect();
						$sql = "Select SliderImgURL FROM tblSlider where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
						$RS = $DB->query($sql);
						if ($RS->num_rows > 0) 
						{
							while($row = $RS->fetch_assoc())
							{
							$strOldImageURL = $row["SliderImgURL"];	
							}

							// As we got the old image we will delete this image from server
							
							$file = $strOldImageURL;
							if (!unlink($file))
							{
								//die("Error deleting Old Image File");
							}
							else
							{
								// As we the old image file is deleted from the server we will add the new file in database
								
								$filepath = 'imageupload/images';
								// for First Image
								$filename1 = $_FILES["SliderImgURL"]["name"];
								
								$uploadFilename1 = UniqueStamp().$filename1;		
								$strImageUploadPath1 = $filepath."/".$uploadFilename1;
								// #######################
								
									
								
									$sqlUpdate = "update tblSlider set SliderImgURL='".$strImageUploadPath1."' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
									//echo $sqlUpdate;
									ExecuteNQ($sqlUpdate);
								
								
								echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
										</button>
										<strong>Old Image Updated Successfully</strong>
										</div>');
							}	

							
						}
						else
						{
							die('<div class="alert alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Old Image not Found</strong>
								</div>');
						}					
						
					}
					else
					{
						die($strValidateImage1);
					}
				}	
			}
			$DB = Connect();
			foreach($_POST as $key => $val)
			{
				if($key=="step" || $key==$strMyTableID || $key=="SliderImgURL")
				{
				
				}
				else
				{
					$sqlUpdate = "update $strMyTable set $key='$_POST[$key]' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					ExecuteNQ($sqlUpdate);
					//echo "$sqlUpdate";
					// $sqlUpdate1 = "update $strMyTable set $key='$_POST[$key]' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					// ExecuteNQ($sqlUpdate1);
					
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
                        <p>Add, edit, delete POST</p>
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
												<h3 class="title-hero">List of Slides | Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr. No</th>
																<th>Image</th>
																<th>Priority</th>
																<th>Status</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr. No</th>
																<th>Image</th>
																<th>Status</th>
																<th>Priority</th>
																<th>Action</th>
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
		$strSliderID = $row["SliderID"];
		$getUID = EncodeQ($strSliderID);
		$getUIDDelete = Encode($strSliderID);
		$SliderImgURL = $row["SliderImgURL"];
		$Priority = $row["Priority"];
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
												<td align="center" ><img src="<?=$SliderImgURL?>" width="200" height="150" /></td>
												<td><?=$Priority?></td>
												<td><?=$Status?></td>
												<td>
													<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
													
													<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step25','<?=$getUIDDelete?>', 'Are you sure you want to delete this Slide - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
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
<!--TAB 2 START-->											
											</tbody>
													</table>
												</div>
											</div>
										</div>
										
										<div id="normal-tabs-2">
										
											<div class="panel-body">
											
												<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '','','', '.imageupload'); return false;">
											
												<span class="result_message">&nbsp; <br>
												</span>
											
												<input type="hidden" name="step" value="add">

													<h3 class="title-hero">Add New</h3>
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
	
		
		elseif($row["Field"]=="SliderImgURL")
		{
?>											
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("SliderImgURL", "Slider Image", $row["Field"])?> <span>*</span></label>
												<div class="col-sm-6">
													<input type="file" class="form-control imageupload required" data-source="SliderImgURL">
												</div>
											</div>

<?php
		}
		else if ($row["Field"]=="Priority")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("POST", " ", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-2">
																<select name="<?=$row["Field"]?>" class="form-control required">
																	<option value="">--Select--</option>
																	<?php
																	for($i=1; $i<=7; $i++)
																	{
																		echo "<option value='$i'>$i</option>";
																	}
																	?>
																</select>
															</div>
														</div>
<?php
		}
		else if ($row["Field"]=="Type")
		{
?>
																											
<?php
		}
		else if ($row["Field"]=="Status")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("POST", " ", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-2">
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
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("POST", " ", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("POST", " ", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("POST", " ", $row["Field"])?>"></div>
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
								<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', '','.imageupload'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

								
									<h3 class="title-hero">Edit Slide</h3>
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
			elseif($key=="SliderImgURL")
			{
?>											
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("SliderImgURL", "Social Img URL", $key)?> <span>*</span></label>
												<div class="col-sm-4">										
													<img src="<?=$row[$key]?>" width="400"></label><br>
													<hr>
													choose file to change image<br><input type="file" class="imageupload" data-source="SliderImgURL">
												</div>
											</div>
<?php
			}
			elseif($key=="Priority")
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Status", "Status", $key)?> <span>*</span></label>
												<div class="col-sm-2">
													<select name="<?=$key?>" class="form-control required">
														<option value="">--Select--</option>
														<?php
														for($i=1; $i<=7; $i++)
														{
															if(trim($row[$key])==$i)
															{
																echo "<option value='$i' selected='selected'>$i</option>";
															}
															else
															{
																echo "<option value='$i'>$i</option>";
															}
														}
														?>
													</select>
												</div>
											</div>	
											<?php
			}
			elseif($key=="Type")
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Status", "Status", $key)?> <span>*</span></label>
												<div class="col-sm-2">
													<select name="<?=$key?>" class="form-control required">
														<option value="">--Select--</option>
														<?php
														for($i=1; $i<=7; $i++)
														{
															if(trim($row[$key])==$i)
															{
																echo "<option value='$i' selected='selected'>$i</option>";
															}
															else
															{
																echo "<option value='$i'>$i</option>";
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