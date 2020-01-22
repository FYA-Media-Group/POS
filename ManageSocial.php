<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Social Management | Nailspa";
	$strDisplayTitle = "Social Management for Nailspa";
	$strMenuID = "7";
	$strMyTable = "tblSocial";
	$strMyTableID = "SocialID";
	$strMyField = "SocialName";
	$strMyActionPage = "ManageSocial.php";
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
			$strValidateImage1 = trim(ValidateImageFile($_FILES, "SocialImgURL"));
			if($strValidateImage1=="Saved successfully")
			{
				$filepath = 'imageupload/images';
				// for First Image
				$filename = $_FILES["SocialImgURL"]["name"];
				
				$uploadFilename = UniqueStamp().$filename;	
				$strImageUploadPath = $filepath."/".$uploadFilename;
				// #######################
				
				$strSocialName = Filter($_POST["SocialName"]);
				$strSocialURL = Filter($_POST["SocialURL"]);
				$strStatus = Filter($_POST["Status"]);
								
				$DB = Connect();
			
				$sqlInsert = "Insert into $strMyTable (SocialName, SocialURL, SocialImgURL, Status) values
				('".$strSocialName."','".$strSocialURL."', '".$strImageUploadPath."', '".$strStatus."')";
				
				$DB->query($sqlInsert);
				
				$DB->Close();

				die('<div class="alert alert-close alert-success">
						<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
						<div class="alert-content">
							<h4 class="alert-title">Record Added Successfully</h4>
							<p></p>
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
				//die($strType);
				if(isset($_FILES["SocialImgURL"]["error"]))
				{
					$strValidateImage1 = trim(ValidateVideoFile($_FILES, "SocialImgURL"));
					if($strValidateImage1=="Saved successfully")
					{
					
						// As the image is valid first select the imagename for previous image
						
						$DB = Connect();
						$sql = "Select SocialImgURL FROM tblSocial where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
						$RS = $DB->query($sql);
						if ($RS->num_rows > 0) 
						{
							while($row = $RS->fetch_assoc())
							{
							$strOldImageURL = $row["SocialImgURL"];	
							}

							// As we got the old image we will delete this image from server
							
							$file = $strOldImageURL;
							if (!unlink($file))
							{
							}
							else
							{
								// As we the old image file is deleted from the server we will add the new file in database
								
								$filepath = 'imageupload/images';
								// for First Image
								$filename1 = $_FILES["SocialImgURL"]["name"];
								
								$uploadFilename1 = UniqueStamp().$filename1;		
								$strImageUploadPath1 = $filepath."/".$uploadFilename1;
								// #######################
								
									
								
									$sqlUpdate = "update tblSocial set SocialImgURL='".$strImageUploadPath1."' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
									ExecuteNQ($sqlUpdate);
								
								
								echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
										</button>
										<strong>Image Updated Successfully</strong>
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
			else
			{
				if(isset($_FILES["SocialImgURL"]["error"]))
				{
					$strValidateImage1 = trim(ValidateImageFile($_FILES, "SocialImgURL"));
					if($strValidateImage1=="Saved successfully")
					{
					
						// As the image is valid first select the imagename for previous image
						
						$DB = Connect();
						$sql = "Select SocialImgURL FROM tblSocial where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
						$RS = $DB->query($sql);
						if ($RS->num_rows > 0) 
						{
							while($row = $RS->fetch_assoc())
							{
							$strOldImageURL = $row["SocialImgURL"];	
							}

							// As we got the old image we will delete this image from server
							
							$file = $strOldImageURL;
							if (!unlink($file))
							{
							}
							else
							{
								// As we the old image file is deleted from the server we will add the new file in database
								
								$filepath = 'imageupload/images';
								// for First Image
								$filename1 = $_FILES["SocialImgURL"]["name"];
								
								$uploadFilename1 = UniqueStamp().$filename1;		
								$strImageUploadPath1 = $filepath."/".$uploadFilename1;
								// #######################
								
									
								
									$sqlUpdate = "update tblSocial set SocialImgURL='".$strImageUploadPath1."' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
									ExecuteNQ($sqlUpdate);
								
								
								echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
										</button>
										<strong>Image Updated Successfully</strong>
										</div>');
							}	

							
						}
						else
						{
							die('<div class="alert alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Image not Found</strong>
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
				if($key=="step" || $key==$strMyTableID || $key=="SocialImgURL")
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
						<p></p>
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
                        <p>Add, edit, delete Post</p>
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
												<h3 class="title-hero">List of Posts | Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr. No</th>
																<th>Social Media Name</th>
																<th>Social Media URL</th>
																<th>Image</th>
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr. No</th>
																<th>Social Media Name</th>
																<th>Social Media URL</th>
																<th>Image</th>
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
		$strSocialID = $row["SocialID"];
		$getUID = EncodeQ($strSocialID);
		$getUIDDelete = Encode($strSocialID);
		$SocialName = $row["SocialName"];
		$SocialURL = $row["SocialURL"];
		$SocialImgURL = $row["SocialImgURL"];
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
												<td><?=$SocialName?></td>
												<td><?=$SocialURL?></td>
												<td align="center" ><img src="<?=$SocialImgURL?>" alt="<?=$SocialImgURL?>" width="100" height="60" /></td>
												<td><?=$Status?></td>
												<td>
													<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
													<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
													<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step17','<?=$getUIDDelete?>', 'Are you sure you want to delete this Post - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
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

													<h3 class="title-hero">Add New Post</h3>
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
	
		
		elseif($row["Field"]=="SocialImgURL")
		{
?>											
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("SocialImgURL", "Image Upload", $row["Field"])?> <span>*</span></label>
												<div class="col-sm-6">
													<input type="file" class="form-control imageupload required" data-source="SocialImgURL" accept="image/*">
												</div>
											</div>
<?php
		}
		else if ($row["Field"]=="SocialName")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("SocialName", "Social Name", $row["Field"])?> </label>
															<div class="col-sm-6"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("SocialName", "Social Name", $row["Field"])?>" class="form-control " placeholder="<?=str_replace("SocialName", "Social Name", $row["Field"])?>"></div>
														</div>
<?php
		}
		else if ($row["Field"]=="SocialURL")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("SocialURL", "Social URL", $row["Field"])?> </label>
															<div class="col-sm-6"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("SocialURL", "Social URL", $row["Field"])?>" class="form-control " placeholder="<?=str_replace("SocialURL", "Social URL", $row["Field"])?>"></div>
														</div>

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

								
									<h3 class="title-hero">Edit Post</h3>
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
			elseif($key=="SocialName")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("SocialName", "Social Name", $key)?></label>
												<div class="col-sm-6"><input type="text" name="<?=$key?>" class="form-control " placeholder="<?=str_replace("SocialName", "Social Name", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
											<?php
			}
			elseif($key=="SocialURL")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("SocialURL", "Social URL", $key)?></label>
												<div class="col-sm-6"><input type="text" name="<?=$key?>" class="form-control " placeholder="<?=str_replace("SocialURL", "Social URL", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
											
<?php
			}
			elseif($key=="SocialImgURL")
			{
?>											
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("SocialImgURL", "Post Image", $key)?> <span>*</span></label>
												<div class="col-sm-4">										
													<img src="<?=$row[$key]?>" width="400"></label><br>
													<hr>
													choose file to change image<br><input type="file" class="imageupload" data-source="SocialImgURL">
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