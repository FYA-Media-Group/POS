<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Images| Nailspa";
	$strDisplayTitle = "Manage Image Data for Nailspa";
	$strMenuID = "3";
	$strMyTable = "tblMarktingImg";
	$strMyTableID = "MarketingImgID";
	$strMyField = "Title";
	$strMyActionPage = "ManageMarketingImg.php";
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
			// echo "Hello<br>";
			$strTitle = Filter($_POST["Title"]);
			// echo $strTitle."<br>";
			$strDescription = Filter($_POST["Description"]);
			$Email = Filter($_POST["Email"]);
			$store = Filter($_POST["store"]);
			
			// echo $strDescription."<br>";
			
			// $strStatus = Filter($_POST["Status"]);
			// echo $strStatus."<br>";
			$DB = Connect();
			$sql = "Insert into tblMarktingImg (Title, Description, Status, AdminID,Email,StoreID) values('".$strTitle."', '".$strDescription."', '4', '".$strAdminID."','".$Email."','".$store."')";
			
			
			if($DB->query($sql) === TRUE) 
			{
				$last_id3 = $DB->insert_id;		//last id of tblMarktingImg insert
				// echo $last_id3."<br>";
			}
			else
			{
				echo "Error: " . $InsertAdmin . "<br>" . $conn->error;
			}	
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
						$sqlInsert = "Insert into tblImages (MarketingImgID, ImagePath, PrimaryImage) values
						('".$last_id3."', '".$strImageUploadPath."', 2)";
						// echo $sqlInsert."<br>";
						ExecuteNQ($sqlInsert);
					}
				}
			}
			// die();
			$DB->Close();
			die('<div class="alert alert-close alert-success">
				<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
				<div class="alert-content">
				<h4 class="alert-title">Record Added Successfully</h4>
				<p>Information message box using the color scheme.</p>
			</div>
			</div>');
			
		}
		if($strStep=="edit")
		{
			$strMyTableID=Decode($_POST[$strMyTableID]);
			// echo $strMyTableID;
			
			$strDescription = Filter($_POST["Description"]);
			$strTitle = Filter($_POST["Title"]);
			$strStatus = Filter($_POST["Status"]);
			$Email = Filter($_POST["Email"]);
			
			$DB = Connect();
			
			$sqlUpdate2 = "UPDATE tblMarktingImg SET Title='".$strTitle."',Description='".$strDescription."',Status='".$strStatus."',Email='".$Email."' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
			
			
			
			
			ExecuteNQ($sqlUpdate2);
			
					// $filepath = 'imageupload/images';	
					// echo $filepath;
					// foreach($_FILES as $key => $val)
					// {
						// if (strpos($key, 'SecondaryImage') !== FALSE)
						// {
							// $strValidateImage = trim(ValidateImageFile2($_FILES, $key, UniqueStamp()."1".$_FILES[$key]["name"], $filepath));
							// if($strValidateImage=="Saved successfully")
							// {
								// for Other Images
								// $filename = $_FILES[$key]["name"];
								
								// $uploadFilename = UniqueStamp()."1".$filename;		
								// $strImageUploadPath = $filepath."/".$uploadFilename;
								#######################
								// $sqlInsert = "Insert into tblImages (MarketingImgID, ImagePath, PrimaryImage) values
								// ('".$strMarketingImgID."', '".$strImageUploadPath."', 2)";
								// echo $sqlInsert."<br>";
								// ExecuteNQ($sqlInsert);
							// }
						// }
					// }
					foreach($_FILES as $key => $val)
					{
						if (strpos($key, 'SecondaryImage') !== FALSE)
						{
							$strValidateImage = trim(ValidateImageFile($_FILES, $key));
							if($strValidateImage=="Saved successfully")
							{
								$filepath = 'imageupload/images';
								// for Other Images
								$filename = $_FILES[$key]["name"];
								
								$uploadFilename = UniqueStamp().$filename;		
								$strImageUploadPath = $filepath."/".$uploadFilename;
								// #######################
								
								
								$sqlInsert = "Insert into tblImages (MarketingImgID, ImagePath, PrimaryImage) values
								('".$strMyTableID."', '".$strImageUploadPath."', 2)";
								// echo $sqlInsert."<br>";
								ExecuteNQ($sqlInsert);
								
								echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
									</button>
									<strong>Image uploaded Successfully</strong>
									</div>');
							}
						}	
					}					
					
					
			$DB->close();
			die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Admin Details Updated</h4>
						<p>Record Updated Successfully</p>
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
                        <p>Add, edit, delete</p>
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
																<th>Title</th>
																<th>Email</th>
																<th>Description</th>
																<th>Status</th>
																<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
																<th>Actions</th>
																<?php 
																	}
																?>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No.</th>
																<th>Title</th>
																<th>Email</th>
																<th>Description</th>
																<th>Status</th>
																	<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
																<th>Actions</th>
																<?php 
																	}
																?>
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
		$strMarketingImgID = $row["MarketingImgID"];
		$sqp=select("ImagePath","tblImages","MarketingImgID='".$strMarketingImgID."'");
		$ImagePath=$sqp[0]['ImagePath'];
		$getUID = EncodeQ($strMarketingImgID);
		$getUIDDelete = Encode($strMarketingImgID);
		$Title = $row["Title"];
		$Description = $row["Description"];
		$AudioURL = $row["AudioURL"];
		
		$Status = $row["Status"];
		$Email = $row["Email"];
		if($Status=="0")
		{
			$Status = "Approved";
		}
		elseif($Status='4')
		{
			$Status = "Pending";
		}
		elseif($Status='3')
		{
			$Status = "Rejected";
		}
		elseif($Status='2')
		{
			$Status = "Non Approved";
		}
?>	
											<tr id="my_data_tr_<?=$counter?>">
												<td><?=$counter?></td>
												<td><img src="<?= $ImagePath?>" width="25%" height="20%"/></td>
												<td><?=$Email?></td>
												<td><?=$Description?></td>
												<td><?=$Status?></td>
												
												
														<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
																		<td>
													<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step3','<?=$getUIDDelete?>', 'Are you sure you want to delete this Data - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
													</td>
													<?php 
																	}
													?>
												
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
		else if ($row["Field"]=="PostContent")
		{
?>	
													
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PostContent", "Content", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-8"><textarea name="<?=$row["Field"]?>" id="<?=str_replace("PostContent", "Content", $row["Field"])?>" class="form-control required wysiwyg" placeholder="<?=str_replace("PostContent", "Content", $row["Field"])?>"></textarea></div>
														</div>
													

<?php
		}
		else if ($row["Field"]=="Description")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Description", "Description", $row["Field"])?></label>
															<div class="col-sm-6"><textarea name="<?=$row["Field"]?>" id="<?=str_replace("Description", "Description", $row["Field"])?>" class="form-control" placeholder="<?=str_replace("Description", "Description", $row["Field"])?>"></textarea></div>
														</div>

<?php
		}
	  else if($row["Field"]=="StoreID")
		{
			?>
				<div class="form-group"><label for="" class="col-sm-3 control-label">Select Store</label>
														<div class="col-sm-6">
														
													<select class="form-control required"  name="store">
															<option value="" selected>--Select Store--</option>
<?
                                                    $selp=select("*","tblStores","Status='0'");
													foreach($selp as $val)
													{
														$strStoreName = $val["StoreName"];
														$strStoreID = $val["StoreID"];
														$store=$_GET["store"];
														if($store==$strStoreID)
														{
															?>
														<option  selected value="<?=$strStoreID?>" ><?=$strStoreName?></option>														
<?php                   
														}
														else
														{
															?>
														<option value="<?=$strStoreID?>" ><?=$strStoreName?></option>														
<?php                   
														}

													}
?>
														</select>

		
												</div>
															
														</div>
			<?php
		}
	else if ($row["Field"]=="Email")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Email", "Email", $row["Field"])?></label>
															<div class="col-sm-6"><input name="<?=$row["Field"]?>" id="<?=str_replace("Email", "Email", $row["Field"])?>" class="form-control" placeholder="<?=str_replace("Email", "Email", $row["Field"])?>" /></div>
														</div>

<?php
		}
		elseif($row["Field"]=="ImagePath")
		{
?>											
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ImagePath", "Image", $row["Field"])?> <span>*</span></label>
												<div class="col-sm-4">
													<input type="file" class="form-control imageupload " data-source="ImagePath" id="file1" name="file1">
												</div>
											</div>
											
<?php
		}
		else if ($row["Field"]=="Title")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Title", "Title", $row["Field"])?><span>*</span></label>
															<div class="col-sm-6"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Title", "Title", $row["Field"])?>" class="form-control required " placeholder="<?=str_replace("Title", "Title", $row["Field"])?>"></div>
														</div>
<?php
		}
		else if ($row["Field"]=="AdminID")
		{
?>													
<?php
		}
		else if ($row["Field"]=="Status")
		{
?>
														<!--<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3">
																<select name="<?=$row["Field"]?>" class="form-control required">
																	<option value="0" Selected>Live</option>
																	<option value="1">Offline</option>	
																</select>
															</div>
														</div>	-->													
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
														
														<div class="form-group"><label class="col-sm-3 control-label">Select Images<span>*</span></label>
															<div class="col-sm-3">
																<input class="file_upload imageupload" type="file" data-source="SecondaryImage" name="SecondaryImage" id="fileSelect" multiple>
															</div>														
														</div>
														
														
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

								
									<h3 class="title-hero">Edit</h3>
									<div class="example-box-wrapper">
<?php

$strID = DecodeQ(Filter($_GET["uid"]));
// echo $strID."<br>";
$DB = Connect();
$sql = "select * FROM $strMyTable where $strMyTableID = '$strID'";
// echo $sql;
// die();
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
			elseif($key=="Description")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Description", "Description", $key)?> <span>*</span></label>
												<div class="col-sm-4"><textarea name="<?=$key?>" class="form-control required wysiwyg"><?=$row[$key]?></textarea></div>
											</div>

<?php
			}
			elseif($key=="Title")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Title", "Title", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Title", "Title", $key)?>" value="<?=$row[$key]?>"></div>
											</div>	

<?php
			}
				else if($key=="StoreID")
		{
			
			?>
				<div class="form-group"><label for="" class="col-sm-3 control-label">Select Store</label>
														<div class="col-sm-6">
														
													<select class="form-control required"  name="store">
															<option value="" selected>--Select Store--</option>
<?
                                                    $selp=select("*","tblStores","Status='0'");
													foreach($selp as $val)
													{
														$strStoreName = $val["StoreName"];
														$strStoreID = $val["StoreID"];
														
														$store=$row[$key];
														if($store==$strStoreID)
														{
															?>
														<option  selected value="<?=$store?>" ><?=$strStoreName?></option>														
<?php                   
														}
														else
														{
															?>
														<option value="<?=$strStoreID?>" ><?=$strStoreName?></option>														
<?php                   
														}

													}
?>
														</select>

		
												</div>
															
														</div>
			<?php
		}
			elseif($key=="Email")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Email", "Email", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Email", "Email", $key)?>" value="<?=$row[$key]?>"></div>
											</div>	

<?php
			}
			elseif($key=="DateofPost")
			{
?>		
<?php
			}
			elseif($key=="AdminID")
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
											<!--<div class="form-group"><label class="col-sm-3 control-label"><?//=str_replace("Status", "Status", $key)?> <span>*</span></label>
												<div class="col-sm-4">
													<select name="<?//=$key?>" class="form-control required">
														<?php
															// if ($row[$key]=="0")
															// {
														?>
																<option value="0" selected>Live</option>
																<option value="1">Offline</option>
														<?php
															// }
															// elseif ($row[$key]=="1")
															// {
														?>
																<option value="0">Live</option>
																<option value="1" selected>Offline</option>
														<?php
															// }
															// else
															// {
														?>
																<option value="" selected>--Choose option--</option>
																<option value="0">Live</option>
																<option value="1">Offline</option>
														<?php
															// }
														?>	
													</select>
												</div>
											</div>	-->					
												
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

													$sql = "select ImageID, MarketingImgID, ImagePath FROM tblImages where MarketingImgID = '$strID' and PrimaryImage='2'";
													// echo $sql;
													$RS2 = $DB->query($sql);
													if ($RS2->num_rows > 0) 
													{
?>
														<div class="form-group">
														<label class="col-sm-3 control-label">All Images</label>
<?php					
														$counter = 0;
														while($row2 = $RS2->fetch_assoc())
														{
															$counter ++;
															$MarketingImgID = $row2["MarketingImgID"];
															$strImageID = $row2["ImageID"];
															$getUIDDelete = Encode($strImageID);
															$strImagePath = $row2["ImagePath"];
?>															
																<span id="my_data_tr_<?=$counter?>">
																	<img src="<?= $strImagePath?>" alt="<?= $strImagePath?>" width="100px"/>
																	<a href="javascript:;" class="btn btn-round btn-danger btn-xs" onclick="DeleteData('Step28','<?=$getUIDDelete?>', 'Are you sure you want to delete this Image ?','my_data_tr_<?=$counter?>');">X</a>
																</span>
																&nbsp;	
<?php
														}
												?>	
															</div>
												<?php					
														
													}
													
												?>		
												
											

											<div class="form-group"><label class="col-sm-3 control-label">Select Images<span>*</span></label>
															<div class="col-sm-3">
																<input class="file_upload imageupload" type="file" data-source="SecondaryImage" name="SecondaryImage" id="fileSelect" multiple>
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