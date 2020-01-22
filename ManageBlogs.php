<?php require_once "setting.fya"; ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Blog Management | Nailspa";
	$strDisplayTitle = "Manage Blogs Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblBlogs";
	$strMyTableID = "BlogID";
	$strMyField = "Title";
	$strMyActionPage = "ManageBlogs.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized");
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
				
				$strImagePath = Filter($_POST["SliderImgURL"]);
				$strTitle = Filter($_POST["Title"]);
				$strContent = Filter($_POST["Content"]);
				$strExcerpt = Filter($_POST["Excerpt"]);
				$strStatus = Filter($_POST["Status"]);
								
				$DB = Connect();
			
				$sqlInsert = "INSERT INTO $strMyTable (Title, Excerpt, Content, ImagePath, Status) VALUES
				('".$strTitle."', '".$strExcerpt."', '".$strContent."', '".$strImageUploadPath."','".$strStatus."')";
				$DB->query($sqlInsert);
				
				$DB->Close();

				die('<div class="alert alert-close alert-success">
						<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
						<div class="alert-content">
							<h4 class="alert-title">Yayy...</h4>
							<p>Blog Added</p>
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
				// echo "No-- in else";
				if(isset($_FILES["SliderImgURL"]["error"]))
				{
					$strValidateImage1 = trim(ValidateImageFile($_FILES, "SliderImgURL"));
					if($strValidateImage1=="Saved successfully")
					{
					
						// As the image is valid first select the imagename for previous image
						
						$DB = Connect();
						$sql = "SELECT ImagePath FROM tblBlogs WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
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
								$filename1 = $_FILES["SliderImgURL"]["name"];
								
								$uploadFilename1 = UniqueStamp().$filename1;		
								$strImageUploadPath1 = $filepath."/".$uploadFilename1;
								// #######################
								
									
								
									$sqlUpdate = "UPDATE tblBlogs SET ImagePath='".$strImageUploadPath1."' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
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
			$DB = Connect();
			foreach($_POST as $key => $val)
			{
				if($key=="step" || $key==$strMyTableID || $key=="SliderImgURL")
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
						<h4 class="alert-title">Aha... You Improvised! </h4>
						<p>Blog Details Updated Successfully</p>
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
                        <p>Add, Edit, Delete Blogs</p>
                    </div>
<?php

if((!isset($_GET["uid"])) && (!isset($_GET["rid"])) && (!isset($_GET["tid"])))
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
												<h3 class="title-hero">List of Blogs</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Title</th>
																<th>Image</th>
																<th>Excerpt</th>
																<th>Content</th>
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Title</th>
																<th>Image</th>
																<th>Excerpt</th>
																<th>Content</th>
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</tfoot>
														<tbody>
<?php
//Retrieve And Display Values in a Table
// Create connection And Write Values
$DB = Connect();
$sql = "SELECT * FROM ".$strMyTable." WHERE Status='0' ORDER BY ".$strMyTableID." DESC";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strBlogID = $row["BlogID"];
		$getUID = EncodeQ($strBlogID);
		$getUIDDelete = Encode($strBlogID);
		$Title = $row["Title"];
		$Image = $row["ImagePath"];
		$Excerpt = $row["Excerpt"];
		$Content = $row["Content"];
		$Status = $row["Status"];
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$Title?></td>
																<td><img src="<?=$Image?>" alt="<?=$Title?>" width="95" height="60"></td>
																<td><?=$Excerpt?></td>
																<td><?=$Content?></td>
																<td>
<?
																	if($Status=="0")
																	{
																		echo "Live";
																	}
																	else
																	{
																		echo "Offline";
																	}
?>
																</td>
																<td>
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step31','<?=$getUIDDelete?>', 'Are you sure you want to delete this Blog - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a><br>
																		
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
														
														</tbody>
													</table>
												</div>
											</div>
										</div>
<!--End Manage Tab Start ADD Tab-->										
										<div id="normal-tabs-2">
											<div class="panel-body">
											<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '','', '.imageupload'); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Add A Blog</h3>
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
			
		else if ($row["Field"]=="Title")
		{
?>
														<div class="form-group">
															<label class="col-sm-3 control-label"><?=str_replace("Title", "Title", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-5">
																<input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Title", "Title", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Title", "Title", $row["Field"])?>">
															</div>
														</div>	
<?			
		}
		else if ($row["Field"]=="ImagePath")
		{
				// echo "test";
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ImagePath", "Image", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-5">
																<input type="file" class="form-control imageupload required" data-source="SliderImgURL">
															</div>
														</div>															
<?php
		}
		else if ($row["Field"]=="Excerpt")
		{
?>
														<div class="form-group">
															<label class="col-sm-3 control-label"><?=str_replace("Excerpt", "Excerpt", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-5" >
																<textarea  class="form-control required wysiwyg" rows="05" name="<?=$row["Field"]?>" id="<?=str_replace("Excerpt", "Excerpt", $row["Field"])?>" placeholder="<?=str_replace("Excerpt", "Excerpt", $row["Field"])?>"></textarea>
															</div>
														</div>														
<?php
		}
		else if ($row["Field"]=="Content")
		{
?>
														<div class="form-group">
															<label class="col-sm-3 control-label"><?=str_replace("Content", "Content", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-5" >
																<textarea class="form-control required wysiwyg" rows="05" name="<?=$row["Field"]?>" id="<?=str_replace("Content", "Content", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Content", "Content", $row["Field"])?>"></textarea>
															</div>
														</div>														
<?php
		}
		else if ($row["Field"]=="Status")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Status", "Status", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-5">
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
                    </div>
<?php
} // End null condition
elseif(isset($_GET["uid"]))
{
?>						
					
					<div class="panel">
						<div class="panel-body">
							<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="<?=$strMyActionPage?>"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
						
							<div class="panel-body">
							<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email','', '.imageupload'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

								
									<h3 class="title-hero">Edit Blog</h3>
									<div class="example-box-wrapper">
										
<?php

$strID = DecodeQ(Filter($_GET["uid"]));
// echo $strID;
$DB = Connect();
$sql = "SELECT * FROM $strMyTable WHERE $strMyTableID = '$strID'";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	while($row = $RS->fetch_assoc())
	{	
		$Title=$row["Title"];
		$Image=$row["ImagePath"];
		$Excerpt=$row["Excerpt"];
		$Content=$row["Content"];
		$Status=$row["Status"];

		foreach($row as $key => $val)
		{
			if($key==$strMyTableID)
			{
?>
											<input type="hidden" name="<?=$key?>" value="<?=Encode($strID)?>">	

<?php
			}
			elseif($key=="Title")
			{
?>	
										
											<div class="form-group">
												<label class="col-sm-3 control-label"><?=str_replace("Title", "Title", $key)?> <span>*</span></label>
												<div class="col-sm-5">
													<input class="form-control" value="<?=$row[$key]?>" readonly>
												</div>
											</div>
<?php
			}
			elseif($key=="ImagePath")
			{
					
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ImagePath", "Image", $key)?> <span>*</span></label>
												<div class="col-sm-5">										
													<img src="<?=$row[$key]?>" width="400"></label><br>
													<hr>
													Change Image? Click Here!<br><input type="file" class="imageupload" data-source="SliderImgURL">
												</div>
											</div>
<?php
			}
			elseif($key=="Excerpt")
			{
?>
											<div class="form-group">
												<label class="col-sm-3 control-label"><?=str_replace("Excerpt", "Excerpt", $key)?> <span>*</span></label>
												<div class="col-sm-5">
													<textarea rows="05" name="<?=$key?>" class="form-control required wysiwyg" placeholder="<?=str_replace("Excerpt", "Excerpt", $key)?>"><?=$row[$key]?></textarea>
												</div>
											</div>
<?php
			}
			elseif($key=="Content")
			{
?>
											<div class="form-group">
												<label class="col-sm-3 control-label"><?=str_replace("Content", "Content", $key)?> <span>*</span></label>
												<div class="col-sm-5">
													<textarea rows="05" name="<?=$key?>" class="form-control required wysiwyg" placeholder="<?=str_replace("Content", "Content", $key)?>"><?=$row[$key]?></textarea>
												</div>
											</div>
<?php
			}
			elseif($key=="Status")
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $key)?> <span>*</span></label>
												<div class="col-sm-5">
													<select name="<?=$key?>" class="form-control required">
														<?php
															if ($Status=="0")
															{
														?>
																<option value="0" selected>Live</option>
																<option value="1">Offline</option>
														<?php
															}
															elseif ($Status=="1")
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
}
?>	                   
                </div>
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>