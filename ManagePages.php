<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Manage Pages | Nailspa";
	$strDisplayTitle = "Manage Pages for Nailspa";
	$strMenuID = "12";
	$strMyTable = "tblPages";
	$strMyTableID = "PageID";
	$strMyField = "PageTitle";
	$strMyActionPage = "ManagePages.php";
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
			$strMenuID = Filter($_POST["MenuID"]);
			$strSubMenuID = Filter($_POST["SubMenuID"]);
			$strPageTitle = Filter($_POST["PageTitle"]);
			$strPageContent = Filter($_POST["PageContent"]);
			$strMetaTitle = Filter($_POST["MetaTitle"]);
			$strMetaKeywords = Filter($_POST["MetaKeywords"]);
			$strMetaDescription = Filter($_POST["MetaDescription"]);
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
						<p>This Page already exists in our system. Please try again with a different name.</p>
					</div>
				</div>');
			}
			else
			{
				$filepath = 'imageupload/images';
				CreateFolder($filepath);
				$strValidateImage1 = trim(ValidateImageFile2($_FILES, "ImageURL", UniqueStamp()."0".$_FILES["ImageURL"]["name"], $filepath));
				if($strValidateImage1=="Saved successfully")
				{
					// for First Image
					$filename1 = $_FILES["ImageURL"]["name"];
					
					$uploadFilename1 = UniqueStamp()."0".$filename1;		
					$strImageURL = $filepath."/".$uploadFilename1;
					// #######################
				}
				else
				{
					die($strValidateImage1);
				}
				
				
				$sqlInsert = "INSERT INTO $strMyTable (MenuID, SubMenuID, ImageURL, PageTitle, PageContent, MetaTitle, MetaKeywords, MetaDescription, Status) VALUES
				('".$strMenuID."', '".$strSubMenuID."', '".$strImageURL."', '".$strPageTitle."', '".$strPageContent."', '".$strMetaTitle."', '".$strMetaKeywords."', '".$strMetaDescription."', '".$strStatus."')";
				ExecuteNQ($sqlInsert);
				$DB->close();
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
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
                        <p>Add, Edit, Delete Operations</p>
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
												<h3 class="title-hero">List of Pages | Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>SubMenuID</th>
																<th>Image</th>
																<th>PageTitle</th>
																<th>Status</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>SubMenuID</th>
																<th>Image</th>
																<th>PageTitle</th>
																<th>Status</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SELECT * FROM ".$strMyTable." WHERE Status='0'";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strPageID = $row["PageID"];
		$getUID = EncodeQ($strPageID);
		$getUIDDelete = Encode($strPageID);		
		$MenuID = $row["MenuID"];
		$SubMenuID = $row["SubMenuID"];
		$ImageURL = $row["ImageURL"];
		$PageTitle = $row["PageTitle"];
		$PageContent = $row["PageContent"];
		$MetaTitle = $row["MetaTitle"];
		$MetaKeywords = $row["MetaKeywords"];
		$MetaDescription = $row["MetaDescription"];
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
																<td><?=$SubMenuID?></td>
																<td style="text-align: center"><img width="260" height="120" src="<?=$ImageURL?>" alt="<?=$ImageURL?>"/></td>
																<td><?=$PageTitle?></td>
																<td><?=$Status?></td>
																<td>
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step15','<?=$getUIDDelete?>', 'Are you sure you want to delete this Page - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
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
										
										<div id="normal-tabs-2">
											<div class="panel-body">
												<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '','.admin_email', '', '.imageupload'); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Add Operations</h3>
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
		else if ($row["Field"]=="MenuID")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("MenuID", "Menu ID", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" pattern="[0-9]" name="<?=$row["Field"]?>" id="<?=str_replace("MenuID", "Menu ID", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("MenuID", "Menu ID", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="SubMenuID")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("SubMenuID", "Sub Menu ID", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" pattern="[0-9]" name="<?=$row["Field"]?>" id="<?=str_replace("SubMenuID", "Sub Menu ID", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("SubMenuID", "Sub Menu ID", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="ImageURL")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label">Image<span>*</span></label>
														<div class="col-sm-4">
															<input type="file" class="form-control imageupload required" data-source="ImageURL" accept="image/*">
														</div>
													</div>
<?php
		}
		else if ($row["Field"]=="PageTitle")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PageTitle", "Page Title", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("PageTitle", "Page Title", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("PageTitle", "Page Title", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="PageContent")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PageContent", "Page Content", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-8">
																<textarea name="<?=$row["Field"]?>" id="<?=str_replace("PageContent", "Page Content", $row["Field"])?>" class="form-control required wysiwyg" placeholder="<?=str_replace("PageContent", "Page Content", $row["Field"])?>"></textarea>
															</div>
													</div>
<?php
		}
		else if ($row["Field"]=="MetaTitle")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("MetaTitle", "Meta Title", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("MetaTitle", "Meta Title", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("MetaTitle", "Meta Title", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="MetaKeywords")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("MetaKeywords", "Meta Keywords", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("MetaKeywords", "Meta Keywords", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("MetaKeywords", "Keyword1, Keyword2,...", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="MetaDescription")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("MetaDescription", "Meta Description", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("MetaDescription", "Meta Description", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("MetaDescription", "Meta Description", $row["Field"])?>"></div>
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
							<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email', '', '.imageupload'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

								
									<h3 class="title-hero">Edit Page</h3>
									<div class="example-box-wrapper">
										
<?php
$strID = DecodeQ($_GET["uid"]);
$DB = Connect();
$sql = "SELECT * FROM ".$strMyTable." WHERE ".$strMyTableID." = '".$strID."'";
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
			elseif($key=="MenuID")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("MenuID", "Menu ID", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" pattern="[0-9]" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("MenuID", "Menu ID", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="SubMenuID")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("SubMenuID", "Sub Menu ID", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" pattern="[0-9]" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("SubMenuID", "Sub Menu ID", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="ImageURL")
			{
?>	
											<div class="form-group">
												<label class="col-sm-3 control-label">Image</label>
												<div class="col-sm-4"><img src="<?=$row[$key]?>" alt="<?=$row[$key]?>"/>
												<hr>
													<input class="imageupload" type="file" data-source="ImageURL" name="ImageURL" id="fileSelect" value="Change Image" accept="image/*">
													Click to change the Image
												</div>
											</div>
<?php
			}
			elseif($key=="PageTitle")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PageTitle", "Page Title", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("PageTitle", "Page Title", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="PageContent")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PageContent", "Page Content", $key)?> <span>*</span></label>
												<div class="col-sm-8">
													<textarea rows="10" name="<?=$row["Field"]?>" id="<?=str_replace("PageContent", "Page Content", $row["Field"])?>" class="form-control required wysiwyg" placeholder="<?=str_replace("PageContent", "Page Content", $row["Field"])?>"><?=$row[$key]?></textarea>
												</div>
											</div>
<?php
			}
			elseif($key=="MetaTitle")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("MetaTitle", "Meta Title", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("MetaTitle", "Meta Title", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="MetaKeywords")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("MetaKeywords", "Meta Keywords", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("MetaKeywords", "Meta Keywords", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="MetaDescription")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("MetaDescription", "Meta Description", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("MetaDescription", "Meta Description", $key)?>" value="<?=$row[$key]?>"></div>
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