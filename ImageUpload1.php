<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Images | Nailspa";
	$strDisplayTitle = "Manage Images for Nailspa";
	$strMenuID = "3";
	$strMyTable = "tblImages";
	$strMyTableID = "tblImages";
	$strMyField = "ImageID";
	$strMyActionPage = "ImageUpload.php";
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
			$filepath = 'imageupload/images';			
			foreach($_FILES as $key => $val)
			{
				if (strpos($key, 'SecondaryImage') !== FALSE)
				{
					$strValidateImage = trim(ValidateImageFile2($_FILES, $key, UniqueStamp()."1".$_FILES[$key]["name"], $filepath));
					if($strValidateImage=="Saved successfully")
					{
						// for Other Images
						$filename = $_FILES[$key]["name"];
						
						$uploadFilename = UniqueStamp()."1".$filename;		
						$strImageUploadPath = $filepath."/".$uploadFilename;
						// #######################
						$sqlInsert = "Insert into $strMyTable (MarketingImgID, ImagePath, PrimaryImage) values
						(2, '".$strImageUploadPath."', 2)";
						echo $sqlInsert."<br>";
						$DB->Close();
						die('<div class="alert alert-close alert-success">
							<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
							<div class="alert-content">
							<h4 class="alert-title">Record Added Successfully</h4>
							<p>Information message box using the color scheme.</p>
						</div>
					</div>');
					}
				}
				
			}				
			
			
			
			
		}
		if($strStep=="edit")
		{
			
			// $Description = Filter($_POST["EventUpcomingDescription"]);
			// $EventStartDate = Filter($_POST["EventStartDate"]);
			// $EventEndDate = Filter($_POST["EventEndDate"]);
			// $strType = Filter($_POST["EventType"]);
			
			//die($strType);
				if(isset($_FILES["ImagePath"]["error"]))
				{
					$strValidateImage1 = trim(ValidateVideoFile($_FILES, "ImagePath"));
					if($strValidateImage1=="Saved successfully")
					{
					
						// As the image is valid first select the imagename for previous image
						
						$DB = Connect();
						$sql = "Select ImagePath FROM tblImagesnVideos where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
						$RS = $DB->query($sql);
						if ($RS->num_rows > 0) 
						{
							while($row = $RS->fetch_assoc())
							{
							$strOldImageURL = $row["ImagePath"];	
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
								$filename1 = $_FILES["ImagePath"]["name"];
								
								$uploadFilename1 = UniqueStamp().$filename1;		
								$strImageUploadPath1 = $filepath."/".$uploadFilename1;
								// #######################
								
									
								
									$sqlUpdate = "update tblImagesnVideos set ImagePath='".$strImageUploadPath1."' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
									//echo $sqlUpdate;
									ExecuteNQ($sqlUpdate);
								
								
								echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span>
										</button>
										<strong>Video Updated Successfully</strong>
										</div>');
							}	

							
						}
						else
						{
							die('<div class="alert alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span>
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
			
			else
			{
				if(isset($_FILES["ImagePath"]["error"]))
				{
					$strValidateImage1 = trim(ValidateImageFile($_FILES, "ImagePath"));
					if($strValidateImage1=="Saved successfully")
					{
					
						// As the image is valid first select the imagename for previous image
						
						$DB = Connect();
						$sql = "Select ImagePath FROM tblImagesnVideos where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
						$RS = $DB->query($sql);
						if ($RS->num_rows > 0) 
						{
							while($row = $RS->fetch_assoc())
							{
							$strOldImageURL = $row["ImagePath"];	
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
								$filename1 = $_FILES["ImagePath"]["name"];
								
								$uploadFilename1 = UniqueStamp().$filename1;		
								$strImageUploadPath1 = $filepath."/".$uploadFilename1;
								// #######################
								
									
								
									$sqlUpdate = "update tblImagesnVideos set ImagePath='".$strImageUploadPath1."' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
									//echo $sqlUpdate;
									ExecuteNQ($sqlUpdate);
								
								
								echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span>
										</button>
										<strong>Old Image Updated Successfully</strong>
										</div>');
							}	

							
						}
						else
						{
							die('<div class="alert alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span>
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
				if($key=="step" || $key==$strMyTableID || $key=="ImagePath")
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
		// die();
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
												<h3 class="title-hero">List of Media | Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No.</th>
																<th>Media</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No.</th>
																<th>Media</th>
																<th>Actions</th>
															</tr>
														</tfoot>
														<tbody>
<?php
// Create connection And Write Values
$DB = Connect();
$sql = "Select * FROM $strMyTable order by $strMyField desc";
echo $sql;
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strDataID = $row["ImageID"];
		$getUID = EncodeQ($strDataID);
		$getUIDDelete = Encode($strDataID);
		// $Title = $row["Title"];
		// $Description = $row["Description"];
		// $AudioURL = $row["AudioURL"];
		$ImagePath = $row["ImagePath"];
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
												<td><img src="<?=$ImagePath?>" width="150" height="100"></td>
												<td>
													<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
													
													<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step3','<?=$getUIDDelete?>', 'Are you sure you want to delete this Data - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
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

													<h3 class="title-hero">Add Data</h3>
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
		else if ($row["Field"]=="MarketingImgID")
		{
?>	
													
													
													

<?php
		}
		else if ($row["Field"]=="PrimaryImage")
		{
?>
		
<?php
		}
		else if ($row["Field"]=="ImageID")
		{
?>
				

<?php
		}
		elseif($row["Field"]=="ImagePath")
		{
?>											
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("SecondaryImage", "SecondaryImage", $row["Field"])?> <span>*</span></label>
												<div class="col-sm-4">
													<input type="file" class="form-control imageupload " data-source="SecondaryImage" id="fileSelect" name="SecondaryImage" multiple>
												</div>
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

								
									<h3 class="title-hero">Edit POST</h3>
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
			elseif($key=="PostContent")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PostContent", "Content", $key)?> <span>*</span></label>
												<div class="col-sm-8"><textarea name="<?=$key?>" class="form-control required wysiwyg"><?=$row[$key]?></textarea></div>
											</div>
<?php
			}
			elseif($key=="PostExcerpt")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PostExcerpt", "Excerpt", $key)?> <span>*</span></label>
												<div class="col-sm-8"><textarea name="<?=$key?>" class="form-control required"><?=$row[$key]?>"</textarea></div>
											</div>
<?php
			}
			elseif($key=="Title")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Title", "Title", $key)?> <span>*</span></label>
												<div class="col-sm-6"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Title", "Title", $key)?>" value="<?=$row[$key]?>"></div>
											</div>	
<?php
			}
			elseif($key=="AuthorName")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AuthorName", "Author Name", $key)?></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("AuthorName", "Author Name", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="MetaTitles")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("MetaTitles", "Meta Title", $key)?></label>
												<div class="col-sm-6"><input type="text" name="<?=$key?>" class="form-control " placeholder="<?=str_replace("MetaTitle", "Meta Title", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
											<?php
			}
			elseif($key=="MetaKeyWords")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("MetaKeyWords", "Key Words", $key)?></label>
												<div class="col-sm-6"><input type="text" name="<?=$key?>" class="form-control " placeholder="<?=str_replace("MetaKeyWords", "Key Words", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
											
<?php
			}
			elseif($key=="ImagePath")
			{
?>											
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ImagePath", "Freatured Image", $key)?> <span>*</span></label>
												<div class="col-sm-4">										
													<img src="<?=$row[$key]?>" width="400"></label><br>
													<hr>
													choose file to change image<br><input type="file" class="imageupload" data-source="ImagePath">
												</div>
											</div>
														
																						
<?php
			}
			elseif($key=="DateofPost")
			{
?>											
<?php
			}
			elseif($key=="TimeofPost")
			{
?>	
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
<?php
			
				// $DBvalue=$row[$key];
				
?>	
				<div class="form-group">
						<div class="form-group"><label class="col-sm-3 control-label">Tag Name<span>*</span></label>
							<div class="col-sm-4">	

							<?php
									$sql23="SELECT MasterTagName FROM `tblMasterTags` WHERE Status='0' and MasterTagName in (select TagName from tblTags where Status ='0' and PostID='$strID')";
									//echo $sql23;
									$RS23 = $DB->query($sql23);
									
									if ($RS23->num_rows > 0)
									{
										while($row23 = $RS23->fetch_assoc())
										{
											$strMasterTagName23[] = $row23["MasterTagName"];
											
										}
									}
									$arrlength = count($strMasterTagName23);
								
								?>
							


								<?php
									// $sql = "SELECT MasterTagID, MasterTagName from tblMasterTags where Status=0";
									$sql="SELECT MasterTagName FROM `tblMasterTags` WHERE Status='0' and MasterTagName not in (select TagName from tblTags where Status ='0' and PostID='$strID')";
									
									$RS2 = $DB->query($sql);
									if ($RS2->num_rows > 0)
									{
								?>

							<select class="form-control required" name="TagID[]" multiple>
									
									
								<?
									
									for($x = 0; $x < $arrlength; $x++) 
									{
									?>
										<option value="<?=$strMasterTagName23[$x]?>" selected><?=$strMasterTagName23[$x]?></option>
									<?php
									}
									
									while($row2 = $RS2->fetch_assoc())
									{
									
										$strMasterTagName = $row2["MasterTagName"];
									?>
										<option value="<?=$strMasterTagName?>"><?=$strMasterTagName?></option>
									<?php
											
										
									}
								?>
									
							
							</select>
							<?php
									}
									else
									{
										echo "Master Post Tags are not added. <a href='ManageMasterPostCategory.php' target='Master Post Categorys'>Click here to add</a>";
									}
							?>
							</div>							
						</div>
						
							<div class="form-group "><label class="col-sm-3 control-label">Category</label>
									<div class="col-sm-6">
											<?php
												$sqlNew = "select PostCategoryID, CategoryName from tblPostCategory where Status=0";
												$RS2 = $DB->query($sqlNew);
												if ($RS2->num_rows > 0) 
												{
													$count="";
													while($row2 = $RS2->fetch_assoc())
													{
														$count++;
														$strcatID= $row2["PostCategoryID"];
														$strcatID2 = $strcatID."|Menu";
														$strcatname = $row2["CategoryName"];

											?>			
														<div class="checkbox"><label><input type="checkbox" name="category<?=$count?>" value="<?=$strcatID2?>"><?=$strcatname?></label></div>
														
														
														<?php
															$sqlNew1 = "select PostSubCategoryID, PostSubCategoryID, PostCategoryID from tblPostSubCategory where Status=0 AND PostCategoryID='$strcatID'";
															$RS3 = $DB->query($sqlNew1);
															
																
															if ($RS3->num_rows > 0) 
															{
																$cnt="";
																while($row3 = $RS3->fetch_assoc())
																{
																	$cnt++;																			
																	$strSubCat=$row3["PostSubCategoryID"];
																	$strSubCatName=$row3["SubCategoryName"];
																	$strMainPostCat=$strSubCat."|".$row3["PostCategoryID"];
														?>
																	<div class="checkbox" style="padding-left:20px;"><label><input type="checkbox" name="subcategory<?=$cnt?>" value="<?=$strMainPostCat?>"><?=$strSubCatName?></label></div>
																	
										<?php
																}
															}
										?>
														
										<?php
													}
												}
												else
												{
													echo "Categories are not Inserted in Master Table";
												}
										?>													
									</div>
							</div>
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