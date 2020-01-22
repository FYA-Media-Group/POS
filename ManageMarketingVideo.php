<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Images| Nailspa";
	$strDisplayTitle = "Manage Image Data for Nailspa";
	$strMenuID = "3";
	$strMyTable = "tblVideos";
	$strMyTableID = "VideoID";
	$strMyField = "Title";
	$strMyActionPage = "ManageMarketingVideo.php";
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
			$DB = Connect();
			$strDescription = Filter($_POST["Description"]);
			$strTitle = Filter($_POST["Title"]);
			$strStatus = Filter($_POST["Status"]);
			$name=$_FILES['audio']['name'];
			$type=$_FILES['audio']['type'];
			//$size=$_FILES['uploadvideo']['size'];
			$cname=str_replace(" ","_",$name);
			$tmp_name=$_FILES['audio']['tmp_name'];
			$target_path="uploads/videos/";
			$target_path1=$target_path.basename($cname);
			$store = Filter($_POST["store"]);
			
			// echo $tmp_name;
			// echo $target_path."<br>";
			$uploadFilename = $target_path.UniqueStamp().$cname;
			
			// echo $uploadFilename;		
			$Email = Filter($_POST["Email"]);
			if(move_uploaded_file($_FILES['audio']['tmp_name'],$uploadFilename))
			{
					$sql = "Insert into tblVideos (Title, Description, VideoURL,Status,AdminID,Email,StoreID) values('".$strTitle."', '".$strDescription."','".$uploadFilename."', '4','".$strAdminID."','".$Email."','".$store."')";
					// echo $sql;
					ExecuteNQ($sql);
			
			}
			else
			{
				echo "Error In File.";
			}
		

		
			// if($DB->query($sql) === TRUE) 
			// {
				// $last_id3 = $DB->insert_id;		//last id of tblMarktingImg insert
				// echo $last_id3."<br>";
			// }
			// else
			// {
				// echo "Error: " . $InsertAdmin . "<br>" . $conn->error;
			// }	
			
			
			//Start Video Testing by Asmita
			// $filepath = 'imageupload/images';			
			// foreach($_FILES as $key => $val)
			// {
				// echo "In foreach<br>";
				// if (strpos($key, 'ImagePath') !== FALSE)
				// {
					// echo "In IF<br>";
					// $strValidateVideo=trim(ValidateVideoFile($_FILE, $audio));
					// echo $strValidateVideo."<br>";
					// End Video Testing by Asmita
				// }
			// }
			
		
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
			$DB = Connect();
			$strMyTableID=Decode($_POST[$strMyTableID]);
			// echo $strMyTableID;
			
			$strDescription = Filter($_POST["Description"]);
			$strTitle = Filter($_POST["Title"]);
			$strStatus = Filter($_POST["Status"]);
			$Email = Filter($_POST["Email"]);
			$store = Filter($_POST["store"]);
			
			$name=$_FILES['audio']['name'];
			if($name!="")
			{
				
				$type=$_FILES['audio']['type'];
				// $size=$_FILES['uploadvideo']['size'];
				$cname=str_replace(" ","_",$name);
				$tmp_name=$_FILES['audio']['tmp_name'];
				$target_path="uploads/videos/";
				$target_path1=$target_path.basename($cname);
				// echo $tmp_name;
				// echo $target_path."<br>";
				$DB = Connect();
				$uploadFilename = $target_path.UniqueStamp().$cname;
				
				
				if(move_uploaded_file($_FILES['audio']['tmp_name'],$uploadFilename))
				{
						$sqlUpdate2 = "UPDATE tblVideos SET Title='".$strTitle."',Description='".$strDescription."',VideoURL='".$uploadFilename."',Status='".$strStatus."',Email='".$Email."',StoreID='".$store."' WHERE VideoID='$strMyTableID'";
						
						// die();			
						ExecuteNQ($sqlUpdate2);
				}	
			}
			else if($name=="")
			{
				$selectVideoURL="Select VideoURL from tblVideos where VideoID='$strMyTableID'";
			
				
				$RS = $DB->query($selectVideoURL);
				if ($RS->num_rows > 0) 
				{
					while($row = $RS->fetch_assoc())
					{
						$VideoURL = $row["VideoURL"];
						
					}
				}
				
				
				$sqlUpdate2 = "UPDATE tblVideos SET Title='".$strTitle."',Description='".$strDescription."',Status='".$strStatus."',Email='".$Email."',StoreID='".$store."' WHERE VideoID='$strMyTableID'";
				// echo $sqlUpdate2;
				// die();			
				ExecuteNQ($sqlUpdate2);
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
																<th>VideoURL</th>
																<th>Store</th>
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No.</th>
																<th>Title</th>
																<th>Email</th>
																<th>Description</th>
																<th>VideoURL</th>
																<th>Store</th>
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
		$strVideoID = $row["VideoID"];
		$getUID = EncodeQ($strVideoID);
		$getUIDDelete = Encode($strVideoID);
		$Title = $row["Title"];
		$Description = $row["Description"];
		// $AudioURL = $row["AudioURL"];
		$VideoURL = $row["VideoURL"];
		$Status = $row["Status"];
		$Store = $row["StoreID"];
		$selp=select("StoreName","tblStores","StoreID='".$Store."'");
		$storename=$selp[0]['StoreName'];
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
												<td><?=$Title?></td>
												<td><?=$Email?></td>
												<td><?=$Description?></td>
												<td>
													<video width="200" autoplay controls><source src="<?=$VideoURL?>" type="video/mp4"> Your browser does not support video.</video>
												</td>
												<td><?=$storename?></td>
												<td><?=$Status?></td>
												
												<td>
													<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
													<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
													<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step3','<?=$getUIDDelete?>', 'Are you sure you want to delete this Data - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
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
												<td></td>
												<td>No Records Found</td>
												<td></td>
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
		else if ($row["Field"]=="Title")
		{
?>	
													
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Title", "Title", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-8"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Title", "Title", $row["Field"])?>" class="form-control required wysiwyg" placeholder="<?=str_replace("Title", "Title", $row["Field"])?>"></textarea></div>
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
		elseif($row["Field"]=="VideoURL")
		{
?>											<!--<div class="control-group">
															<label class="control-label" for="basicinput">Audio URL</label>
															<div class="controls">
																<input type="file" data-source="audio" id="file" placeholder="Audio URL..." class="span8" name="file"  >
																<!--<button type="submit" name="btn-upload">upload</button>-->
															<!--</div>
											</div>-->
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("VideoURL", "VideoURL", $row["Field"])?> <span>*</span></label>
												<div class="col-sm-4">
													<input type="file" class="form-control imageupload" data-source="audio" id="file" name="file" placeholder="Video URL...">
													<!--<input type="file" data-source="audio" id="file" placeholder="Video URL..." class="span8" name="file"  >-->
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
														</div>-->														
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
			elseif($key=="Email")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Email", "Email", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input name="<?=$key?>" value="<?=$row[$key]?>" class="form-control required wysiwyg"></div>
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
			elseif($key=="VideoURL")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("VideoURL", "VideoURL", $key)?> <span>*</span></label>
											<div class="col-sm-4">
												<video width="300" autoplay controls ><source src="<?=$row[$key]?>" type="video/mp4" > Your browser does not support video.</video>
											<hr>
												<input type="file" class="form-control imageupload" data-source="audio" id="file" name="file" placeholder="Video URL...">											
											</div>	
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
											</div>-->						
												
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



