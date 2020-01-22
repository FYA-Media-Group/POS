<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Upload Profile | Nailspa";
	$strDisplayTitle = "Upload Profile for Nailspa";
	$strMenuID = "3";
	$strMyTable = "tblAdmin";
	$strMyTableID = "AdminID";
	$strMyField = "Title";
	$strMyActionPage = "UploadProfile.php";
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
	   
			$strMyTableID=$_POST['AdminID'];
			$AdminEmailID = Filter($_POST["AdminEmailID"]);
			$fileToUpload = $_POST["fileToUpload"];
			
			$DB = Connect();
		
		    $sqlUpdate2 = "UPDATE tblAdmin SET AdminEmailID='".$AdminEmailID."' WHERE AdminID='".$strMyTableID."'";
			 ExecuteNQ($sqlUpdate2);
		//echo $sqlUpdate2."<br>";
		   // $imgg=$_FILES['ImagePath']['name'];
			$filepath = 'imageupload/images';	

			if(isset($_FILES["PrimaryImage"]["error"]))
			{
				
				// echo "In if<br>";
				$strValidateImage1 = trim(ValidateImageFile($_FILES, "PrimaryImage"));
				
				if($strValidateImage1=="Saved successfully")
				{
				
					// As the image is valid first select the imagename for previous image
					// echo "In if<br>";
					$DB = Connect();
					$sql = "Select ProfilePath FROM tblAdmin where AdminID='".$strMyTableID."'";
					
					
					$RS = $DB->query($sql);
					if ($RS->num_rows > 0) 
					{
						
						while($row = $RS->fetch_assoc())
									{
										$strOldImageURL = $row["ProfilePath"];	
									}
									
									$file = $strOldImageURL;
									unlink($file);
									
								
						$target_dir = "ProfileImages/";
						$target_file = $target_dir . basename($_FILES["PrimaryImage"]["name"]);
						$uploadOk = 1;
						$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
						// Check if image file is a actual image or fake image
					
							$check = getimagesize($_FILES["PrimaryImage"]["tmp_name"]);
							if($check !== false) {
								echo "File is an image - " . $check["mime"] . ".";
								$uploadOk = 1;
							} else {
								echo "File is not an image.";
								$uploadOk = 0;
							}
							
							
							if (file_exists($target_file)) {
									echo "Sorry, file already exists.";
									$uploadOk = 0;
								}
								// Check file size
								if ($_FILES["PrimaryImage"]["size"] > 500000) {
									echo "Sorry, your file is too large.";
									$uploadOk = 0;
								}
								// Allow certain file formats
								if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
								&& $imageFileType != "gif" ) {
									echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
									$uploadOk = 0;
								}
								// Check if $uploadOk is set to 0 by an error
								if ($uploadOk == 0) {
									echo "Sorry, your file was not uploaded.";
								// if everything is ok, try to upload file
								} else {
									if (move_uploaded_file($_FILES["PrimaryImage"]["tmp_name"], $target_file)) {
									
									 $sqlUpdate3 = "UPDATE tblAdmin SET ProfilePath='".$target_file."' WHERE AdminID='".$strMyTableID."'";
			                         ExecuteNQ($sqlUpdate3);
									 echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
										</button>
										<strong>Image Added Successfully</strong>
										</div>');
									
										//echo "The file ". basename( $_FILES["PrimaryImage"]["name"]). " has been uploaded.";
									} else {
										echo "Sorry, there was an error uploading your file.";
									}
								}
									// #######################
						
						 /* $sqlUpdate3 = "UPDATE tblAdmin SET ProfilePath='".$strImageUploadPath1."' WHERE AdminID='".$strMyTableID."'";
			             ExecuteNQ($sqlUpdate3);
					    echo $sqlUpdate3; */
											
					}
					else
					{
						
						$target_dir = "ProfileImages/";
						$target_file = $target_dir . basename($_FILES["PrimaryImage"]["name"]);
						$uploadOk = 1;
						$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
						// Check if image file is a actual image or fake image
					
							$check = getimagesize($_FILES["PrimaryImage"]["tmp_name"]);
							if($check !== false) {
								echo "File is an image - " . $check["mime"] . ".";
								$uploadOk = 1;
							} else {
								echo "File is not an image.";
								$uploadOk = 0;
							}
							
							
							if (file_exists($target_file)) {
									echo "Sorry, file already exists.";
									$uploadOk = 0;
								}
								// Check file size
								if ($_FILES["PrimaryImage"]["size"] > 500000) {
									echo "Sorry, your file is too large.";
									$uploadOk = 0;
								}
								// Allow certain file formats
								if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
								&& $imageFileType != "gif" ) {
									echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
									$uploadOk = 0;
								}
								// Check if $uploadOk is set to 0 by an error
								if ($uploadOk == 0) {
									echo "Sorry, your file was not uploaded.";
								// if everything is ok, try to upload file
								} else {
									if (move_uploaded_file($_FILES["PrimaryImage"]["tmp_name"], $target_file)) {
										//echo 13123;
										
													 $sqlUpdate3 = "UPDATE tblAdmin SET ProfilePath='".$target_file."' WHERE AdminID='".$strMyTableID."'";
			                                         ExecuteNQ($sqlUpdate3);
													 //echo $sqlUpdate3;
											 echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
										</button>
										<strong>Image Added Successfully</strong>
										</div>');
									} else {
										echo "Sorry, there was an error uploading your file.";
									}
								}
							
							
					
					
						
						
					}	
					
			 		echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <strong>Primary Image Added Successfully</strong>
                            </div>'); 
				}
				else
				{
					die($strValidateImage1);
				}
			}


        // $strValidateImage1 = trim(ValidateImageFile2($_FILES, "PrimaryImage", UniqueStamp()."0".$_FILES["ImagePath"]["name"], $filepath));
        // if($strValidateImage1=="Saved successfully")
        // {
            // for First Image
            // $filename1 = $_FILES["ImagePath"]["name"];
            
            // $uploadFilename1 = UniqueStamp()."0".$filename1;        
            // $strImageUploadPath1 = $filepath."/".$uploadFilename1;
			 // $sqlUpdate3 = "UPDATE tblAdmin SET ProfilePath='".$strImageUploadPath1."' WHERE AdminID='".$strMyTableID."'";
			 // ExecuteNQ($sqlUpdate3);
            // echo $strImageUploadPath1."<br>";
        // }                    
        // else
        // {
            // die($strValidateImage1);
        // }			
           
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
				
					<div class="panel">
						<div class="panel-body">
							<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="<?=$strMyActionPage?>"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
						
							<div class="panel-body">
								<!--<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', '','.imageupload'); return false;" enctype="multipart/form-data">-->
								<form role="form" enctype="multipart/form-data" name="multi" class="enquiry_form form-horizontal form-label-left" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '','', '.file_upload'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

								
									<h3 class="title-hero">Edit Profile</h3>
									<div class="example-box-wrapper">
<?php

$strID = $strAdminID;
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
			if($key=="AdminID")
			{
							
                							
?>
											<input type="hidden" name="<?=$key?>" value="<?=$strID?>">
																					

<?php
			}
			elseif($key=="AdminFullName")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminFullName", "FullName", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input type="text" name="<?=$key?>" readonly class="form-control required" placeholder="<?=str_replace("AdminFullName", "AdminFullName", $key)?>" value="<?=$row[$key]?>"></div>
											</div>	

<?php
			}
			elseif($key=="AdminUserName")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminUserName", "User Name", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input readonly type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("AdminUserName", "AdminUserName", $key)?>" value="<?=$row[$key]?>"></div>
											</div>	

<?php
			}
			elseif($key=="AdminPassword")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminPassword", "Password", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input readonly type="password" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("AdminPassword", "AdminPassword", $key)?>" value="<?=$row[$key]?>"></div>
											</div>	

<?
			}
			elseif($key=="AdminEmailID")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminEmailID", "EmailID", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("AdminEmailID", "AdminEmailID", $key)?>" value="<?=$row[$key]?>"></div>
											</div>	

<?
			}
			elseif($key=="ProfilePath")
			{
?>	
<?php
																					
											if ($key!="") 
											{		
										
?>		
												<div class="form-group">
													<label class="col-sm-3 control-label">Image <span>*</span>
													</label>
													<div class="col-sm-4">
														<img src="<?=$row[$key]?>" alt="<?=$row[$key]?>" width="150px" height="150px" /><br><br>
														<input class="file_upload" type="file" data-source="PrimaryImage" name="PrimaryImage" id="fileSelect">
														Click to change the Offer image
														<hr width="100%" align="left">
													</div>
												</div>
												
<?php
											}
											else
											{
																				
?>	
												<div class="form-group">
													<label class="col-sm-3 control-label">Image
													</label>
													<div class="col-sm-4">
														<input class="file_upload required" type="file" data-source="PrimaryImage" name="PrimaryImage" id="fileSelect">
														<hr width="100%" align="left">
													</div>
													
												</div>

												
<?php

											}
												//Primary Image Edit END
?>												
											

<?php
			}
		   else{
			   
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
                  
                </div>
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>									