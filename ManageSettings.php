<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Manage Website | Nailspa";
	$strDisplayTitle = "Manage Website Settings for Nailspa";
	$strMenuID = "3";
	$strMyTable = "tblSettings";
	$strMyTableID = "SettingID";
	$strMyField = "Home_Page_Title";
	$strMyActionPage = "ManageSettings.php";
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
			
			$strValidateImage1 = trim(ValidateImageFile($_FILES, "ImageURL"));
			if($strValidateImage1=="Saved successfully")
			{				
				$filepath = 'imageupload/images';
				// for First Image
				$filename = $_FILES["ImageURL"]["name"];
				
				$uploadFilename = UniqueStamp().$filename;	
				$strImageUploadPath = $filepath."/".$uploadFilename;
				// #######################
				
			$Home_Page_Title = Filter($_POST["Home_Page_Title"]);
			$ImageURL	 = Filter($_POST["ImageURL	"]);
			$FaviconImgURL = Filter($_POST["FaviconImgURL"]);
			$Meta_Title = Filter($_POST["Meta_Title"]);
			$Meta_Description = Filter($_POST["Meta_Description"]);
			$Meta_Keywords = Filter($_POST["Meta_Keywords"]);
			$Google_Analytics_UAID = Filter($_POST["Google_Analytics_UAID"]);
			$Facebook_Pixel_Code = Filter($_POST["Facebook_Pixel_Code"]);
			$Footer_Content1 = Filter($_POST["Footer_Content1"]);
			$Footer_Content2 = Filter($_POST["Footer_Content2"]);
			echo $Home_Page_Title."<br>";
			echo $ImageURL."<br>";
			echo $FaviconImgURL."<br>";
			echo $Meta_Title."<br>";
			echo $Meta_Description."<br>";
			echo $Meta_Keywords."<br>";
			echo $Google_Analytics_UAID."<br>";
			echo $Facebook_Pixel_Code."<br>";
			echo $Footer_Content1."<br>";
			echo $Footer_Content2."<br>";
			die();
						
				$DB = Connect();
			
				$sqlInsert = "Insert into $strMyTable (AuthorName, DateofPost, Title, PostContent, MetaTitles, PostExcerpt, ImageURL, MetaKeyWords, Status) values
				('".$strAuthorName."', now(), '".$strTitle."', '".$strPostContent."', '".$strMetaTitles."', '".$strPostExcerpt."' , '".$strImageUploadPath."' ,'".$strMetaKeyWords."', '".$strStatus."')";
				
				$DB->query($sqlInsert);
				
								
				foreach($_POST as $key => $val)
				{
					if($key=="step" || $key==AuthorName || $key==Title || $key==PostContent || $key==PostExcerpt || $key==MetaTitles || $key==MetaKeyWords || $key==Status || $key==TagID)
					{						
						
					}
					else
					{
						
						$Cat=$_POST[$key];
						// echo "$Cat <br>";
						if(strpos($Cat,'|') !== false)
						{
							$Value = explode("|", $Cat); 
							$v1=$Value[0];	
							$v2=$Value[1];
							// echo $v1."<br>";
							if($v2=="Menu")
							{
								$sqlInsert2 = "Insert into tblPostMenu (PostID, PostCategoryID, PostSubCategoryID, Status) values
								('".$Taginsert."','".$v1."','0','0')";
								// echo "$sqlInsert2 <br>";
								
								$DB->query($sqlInsert2);
								// echo "1<br>";
							}
							else
							{
								$sqlInsert3 = "Insert into tblPostMenu (PostID, PostCategoryID, PostSubCategoryID, Status) values
								('".$Taginsert."','".$v1."','".$v2."','0')";
								// echo "$sqlInsert3 <br>";
								
								$DB->query($sqlInsert3);
								// echo "2<br>";
							}
							
						}
					}										
				}
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
			
			// $Home_Page_Title = Filter($_POST["Home_Page_Title"]);
			// $ImageURL	 = Filter($_POST["ImageURL	"]);
			// $FaviconImgURL = Filter($_POST["FaviconImgURL"]);
			// $Meta_Title = Filter($_POST["Meta_Title"]);
			// $Meta_Description = Filter($_POST["Meta_Description"]);
			// $Meta_Keywords = Filter($_POST["Meta_Keywords"]);
			// $Google_Analytics_UAID = Filter($_POST["Google_Analytics_UAID"]);
			// $Facebook_Pixel_Code = Filter($_POST["Facebook_Pixel_Code"]);
			// $Footer_Content1 = Filter($_POST["Footer_Content1"]);
			// $Footer_Content2 = Filter($_POST["Footer_Content2"]);
			echo $Home_Page_Title;
			echo $ImageURL;
			echo $FaviconImgURL;
			echo $Meta_Title;
			echo $Meta_Description;
			echo $Meta_Keywords;
			echo $Home_Page_Title;
			echo $Home_Page_Title;
			echo $Home_Page_Title;
			echo $Home_Page_Title;
			die();
			
			if($strType=="4")
			{
				//die($strType);
				if(isset($_FILES["ImageURL"]["error"]))
				{
					$strValidateImage1 = trim(ValidateVideoFile($_FILES, "ImageURL"));
					if($strValidateImage1=="Saved successfully")
					{
					
						// As the image is valid first select the imagename for previous image
						
						$DB = Connect();
						$sql = "Select ImageURL FROM tblSettings where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
						$RS = $DB->query($sql);
						if ($RS->num_rows > 0) 
						{
							while($row = $RS->fetch_assoc())
							{
							$strOldImageURL = $row["ImageURL"];	
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
								$filename1 = $_FILES["ImageURL"]["name"];
								
								$uploadFilename1 = UniqueStamp().$filename1;		
								$strImageUploadPath1 = $filepath."/".$uploadFilename1;
								// #######################
								
									
								
									$sqlUpdate = "update tblSettings set ImageURL='".$strImageUploadPath1."' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
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
				if(isset($_FILES["ImageURL"]["error"]))
				{
					$strValidateImage1 = trim(ValidateImageFile($_FILES, "ImageURL"));
					if($strValidateImage1=="Saved successfully")
					{
					
						// As the image is valid first select the imagename for previous image
						
						$DB = Connect();
						$sql = "Select ImageURL FROM tblSettings where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
						$RS = $DB->query($sql);
						if ($RS->num_rows > 0) 
						{
							while($row = $RS->fetch_assoc())
							{
							$strOldImageURL = $row["ImageURL"];	
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
								$filename1 = $_FILES["ImageURL"]["name"];
								
								$uploadFilename1 = UniqueStamp().$filename1;		
								$strImageUploadPath1 = $filepath."/".$uploadFilename1;
								// #######################
								
									
								
									$sqlUpdate = "update tblSettings set ImageURL='".$strImageUploadPath1."' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
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
				if($key=="step" || $key==$strMyTableID || $key=="ImageURL")
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
												<h3 class="title-hero">List of Posts | MP Story</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Home Page Title</th>
																<th>Logo & Favicon</th>
																<th>SEO</th>
																<th>Footer Content</th>
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Home Page Title</th>
																<th>Logo & Favicon</th>
																<th>SEO</th>
																<th>Footer Content</th>
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
		$strSettingID = $row["SettingID"];
		$getUID = EncodeQ($strSettingID);
		$getUIDDelete = Encode($strSettingID);
		$Home_Page_Title = $row["Home_Page_Title"];
		$ImageURL = $row["ImageURL"];
		$FaviconImgURL = $row["FaviconImgURL"];
		$Meta_Title = $row["Meta_Title"];
		$Meta_Description = $row["Meta_Description"];
		$Meta_Keywords = $row["Meta_Keywords"];
		$Google_Analytics_UAID = $row["Google_Analytics_UAID"];
		$Facebook_Pixel_Code = $row["Facebook_Pixel_Code"];
		$Footer_Content1 = $row["Footer_Content1"];
		$Footer_Content2 = $row["Footer_Content2"];
		
		if($Status=="0")
		{
			$Status = "Live";
		}
		else
		{
			$Status = "Offline";
		}
		
		
		
		if($AdminType=="0")
		{
			$AdminType = "<font color='Purple'><b>Super Admin</b></font>";
		}
		else
		{
			$AdminType = "<font color='Red'><b>Admin</b></font>";
		}
		
		if($Meta_Title!="NULL" && Meta_Description!="NULL" && Meta_Keywords!="NULL")
		{
			$Meta_Title = "<font color='Green'><b>Yes</b></font>";
			$Meta_Description = "<font color='Green'><b>Yes</b></font>";
			$Meta_Keywords = "<font color='Green'><b>Yes</b></font>";
		}
		else
		{
			$Meta_Title = "<font color='Red'><b>No</b></font>";
			$Meta_Description = "<font color='Red'><b>No</b></font>";
			$Meta_Keywords = "<font color='Red'><b>No</b></font>";
		} 
?>	
											<tr id="my_data_tr_<?=$counter?>">
												<td><b>Home Page Title :</b> <?=$AuthorName?></td>
												<td><b>Logo	 :</b> <?=$DateofPost?> <br><b>Favicon :</b> <?=$TimeofPost?></td>
												<td>SEO:</td>
												<td>Footer Content<?=$MetaKeyWords?></td>
												<td><?=$Status?></td>
												<td>
													<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
													
													<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step3','<?=$getUIDDelete?>', 'Are you sure you want to delete this POST - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
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

													<h3 class="title-hero">New Post</h3>
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
		else if ($row["Field"]=="Meta_Description")
		{
?>	
													
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PostContent", "Content", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-8"><textarea name="<?=$row["Field"]?>" id="<?=str_replace("PostContent", "Content", $row["Field"])?>" class="form-control required wysiwyg" placeholder="<?=str_replace("PostContent", "Content", $row["Field"])?>"></textarea></div>
														</div>
													

<?php
		}
		else if ($row["Field"]=="Google_Analytics_UAID")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PostExcerpt", "Analytics UAID", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-5"><textarea name="<?=$row["Field"]?>" id="<?=str_replace("PostExcerpt", "Analytics UAID", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("PostExcerpt", "Analytics UAID", $row["Field"])?>"></textarea></div>
														</div>
<?php
		}
		else if ($row["Field"]=="Facebook_Pixel_Code")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Facebook_Pixel_Code", "FB Code", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-5"><textarea name="<?=$row["Field"]?>" id="<?=str_replace("Facebook_Pixel_Code", "FB Code", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Facebook_Pixel_Code", "FB Code", $row["Field"])?>"></textarea></div>
														</div>														
<?php
		}
		elseif($row["Field"]=="ImageURL")
		{
?>											
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ImageURL", "Logo", $row["Field"])?> <span>*</span></label>
												<div class="col-sm-4">
													<input type="file" class="form-control imageupload required" data-source="ImageURL">
												</div>
											</div>
											
<?php
		}
		elseif($row["Field"]=="FaviconImgURL")
		{
?>											
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("FaviconImgURL", "Favicon", $row["Field"])?> </label>
												<div class="col-sm-4">
													<input type="file" class="form-control imageupload " data-source="ImageURL">
												</div>
											</div>											
											
<?php
		}
		else if ($row["Field"]=="Home_Page_Title")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Home_Page_Title", "Title", $row["Field"])?> </label>
															<div class="col-sm-6"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("MetaTitles", "Meta Title", $row["Field"])?>" class="form-control " placeholder="<?=str_replace("MetaTitles", "Meta Title", $row["Field"])?>"></div>
														</div>
<?php
		}
		else if ($row["Field"]=="MetaKeyWords")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("MetaKeyWords", "Key Words", $row["Field"])?> </label>
															<div class="col-sm-6"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("MetaKeyWords", "Key Words", $row["Field"])?>" class="form-control " placeholder="<?=str_replace("MetaKeyWords", "Key Words (Not more than 6)", $row["Field"])?>"></div>
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
			elseif($key=="ImageURL")
			{
?>											
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ImageURL", "Freatured Image", $key)?> <span>*</span></label>
												<div class="col-sm-4">										
													<img src="<?=$row[$key]?>" width="400"></label><br>
													<hr>
													choose file to change image<br><input type="file" class="imageupload" data-source="ImageURL">
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