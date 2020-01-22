<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Manage Categories | Nailspa";
	$strDisplayTitle = "Manage Categories for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblCategories";
	$strMyTableID = "CategoryID";
	$strMyField = "CategoryName";
	$strMyActionPage = "ManageCategories.php";
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
			// $strValidateImage1 = trim(ValidateImageFile($_FILES, "ImagePath"));
			// if($strValidateImage1=="Saved successfully" )
			// {			
				// $filepath = 'imageupload/images';
				// for First Image
				// $filename = $_FILES["ImagePath"]["name"];
				// $uploadFilename = UniqueStamp().$filename;	
				// $strImageUploadPath = $filepath."/".$uploadFilename;
				// echo $strImageUploadPath."<br>";
				// #######################
				
				
				$strCategoryName = ucfirst(Filter($_POST["CategoryName"]));
				$strCategoryType = Filter($_POST["CategoryType"]);
				$strMainCategoryType = Filter($_POST["MainCategoryType"]);
			
				// die();
				// $ImagePath = $_POST["ImagePath"];
				// echo $ImagePath."<br>";
				$strStatus = Filter($_POST["Status"]);
				// echo $ImagePath;
				// echo $strStatus;
				// echo $strMainCategoryType;
				// echo $strCategoryName;
				// die();
         
				$DB = Connect();
				$sql = "Select $strMyTableID from $strMyTable where $strMyField='$_POST[$strMyField]'";
				$RS = $DB->query($sql);
				if ($RS->num_rows > 0) 
				{
					$DB->close();
					die('<div class="alert alert-close alert-danger">
						<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
						<div class="alert-content">
							<h4 class="alert-title">Record Add Failed</h4>
							<p>The Charge Name already exists in our system. Please try again with a different name.</p>
						</div>
					</div>');
				}
				else
				{
					//echo $strMainCategoryType;
					// if($strCategoryType=='1')
					// {
						// echo "In if";
						// $strValidateImage1 = trim(ValidateImageFile($_FILES, "ImagePath"));
						// echo $strValidateImage1;
						// if($strValidateImage1=="Saved successfully")
						// {		
							// $filepath = 'imageupload/images';
							// for First Image
							// $filename = $_FILES["ImagePath"]["name"];
							// $uploadFilename = UniqueStamp().$filename;	
							// $strImageUploadPath = $filepath."/".$uploadFilename;
							// #######################
							// echo $strImageUploadPath;
							// die();
						// }
						// else
						// {
							// die($strValidateImage1);
						// }
						
						$sqlInsert = "INSERT INTO $strMyTable (CategoryName, CategoryType, Status, MainCategoryType) VALUES 
						('".$strCategoryName."', '".$strCategoryType."', '".$strStatus."','0')";
						// echo $sqlInsert;
						ExecuteNQ($sqlInsert);
						// die();
						$DB->close();
						die('<div class="alert alert-close alert-success">
							<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
							<div class="alert-content">
								<h4 class="alert-title">Record Added Successfully.</h4>
							</div>
						</div>');
					// }
					// else
					// {
						// $sqlInsert = "INSERT INTO $strMyTable (CategoryName, CategoryType, Status,MainCategoryType) VALUES 
						// ('".$strCategoryName."', '".$strCategoryType."', '".$strStatus."','0')";
						// ExecuteNQ($sqlInsert);
						// $DB->close();
						// die('<div class="alert alert-close alert-success">
						// <div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
						// <div class="alert-content">
							// <h4 class="alert-title">Record Added Successfully.</h4>
						// </div>
						// </div>');
					// }
					
				}
			// }
			// else
			// {
				// die($strValidateImage1);
			// }
			
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
	
		<script>
			function checktype()
			{
				var type=$("#type").val();
				//alert(type)
				if(type=='2')
				{
					if(type!="0")
					{$.ajax({
						type:"post",
						data:"type="+type,
						url:"type.php",
							success:function(res)
							{
								$("#cat").show();
								$("#subtype").html(res);
							}
						})
					}
				}
			}
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
                        <p>Add, Edit, Delete Categories</p>
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
												<h3 class="title-hero">List of Categories | Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Category / Type</th>
																<th>Status</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Category / Type</th>
																<th>Status</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SELECT * FROM ".$strMyTable." order by ".$strMyTableID." desc";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strCategoryID = $row["CategoryID"];
		$getUID = EncodeQ($strCategoryID);
		$getUIDDelete = Encode($strCategoryID);		
		$CategoryName = $row["CategoryName"];
		$CategoryType = $row["CategoryType"];
		$Status = $row["Status"];
		
		if($Status=="0")
		{
			$Status = "Live";
		}
		else
		{
			$Status = "Offline";
		}
		
		
		if($CategoryType=="1")
		{
			$CategoryTypetoDisplay = "<font color='red'>Category</font>";
		}
		elseif($CategoryType=="2")
		{
			$CategoryTypetoDisplay = "<font color='purple'>Sub - Category</font>";
		}
		else
		{
			$CategoryTypetoDisplay = " 3 - 4";
		}
		
?>	
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$CategoryName?> <br> <?=$CategoryTypetoDisplay?></td>
																
																<td><?=$Status?></td>
																<td style="text-align: center">
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																			<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step18','<?=$getUIDDelete?>', 'Are you sure you want to delete this Category - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
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
																<td>No Records Found</td>
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
												<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Add Categories</h3>
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
		else if ($row["Field"]=="CategoryName")
		{
?>	
													<div class="form-group"><label class="col-sm-4 control-label"><?=str_replace("CategoryName", "Name", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="text" style="text-transform:capitalize" name="<?=$row["Field"]?>" id="<?=str_replace("CategoryName", "Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("CategoryName", "Name", $row["Field"])?>"></div>
													</div>
<?php
		}
		elseif($row["Field"]=="ImagePath")
		{
?>											
											<!--<div class="form-group"><label class="col-sm-3 control-label"><?//=str_replace("ImagePath", "Image", $row["Field"])?> </label>
												<div class="col-sm-4">
													<input type="file" class="form-control imageupload " data-source="ImagePath" id="file1" name="file1">
												</div>
											</div>	-->												
<?php
		}
		else if ($row["Field"]=="CategoryType")
		{
?>	
													<div class="form-group"><label class="col-sm-4 control-label"><?=str_replace("CategoryType", "Type", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-4">
															<select name="<?=$row["Field"]?>" class="form-control required" onChange="checktype()" id="type">
																<option value="" Selected>-- Choose Type --</option>
																<option value="1">Category</option>	
																<!--<option value="2">Sub Category</option>-->
																
															</select>
														</div>
													</div>
													<div class="form-group" id="cat" style="display:none"><label class="col-sm-4 control-label"><?=str_replace("MainCategoryType", "Main Type", $row["Field"])?> <span>*</span></label>
<div class="col-sm-4">
<select name="MainCategoryType" class="form-control" id="subtype">
																<option value="" Selected>-- Choose Type --</option>
																</select>
</div>
</div>
														
														
										
													
										
<?
		}
			else if ($row["Field"]=="MainCategoryType")
		{
		}
		else if ($row["Field"]=="Status")
		{
?>
													<div class="form-group"><label class="col-sm-4 control-label"><?=str_replace("Admin", "Status", $row["Field"])?> <span>*</span></label>
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
														<div class="form-group"><label class="col-sm-4 control-label"><?=str_replace("Admin", " ", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Admin", " ", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Admin", " ", $row["Field"])?>"></div>
														</div>
<?php
		}
	}
?>
														<div class="form-group"><label class="col-sm-4 control-label"></label>
															<input type="submit" class="btn ra-100 btn-primary" value="Submit">
															
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

								
									<h3 class="title-hero">Edit Categories</h3>
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
			elseif($key=="CategoryName")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CategoryName", "Charge Name", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" style="text-transform:capitalize" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("CategoryName", "Charge Name", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="ImagePath")
			{
?>											
											<!--<div class="form-group"><label class="col-sm-3 control-label"><?//=str_replace("ImagePath", "Freatured Image", $key)?> </label>
												<div class="col-sm-4">										
													<img src="<?//=$row[$key]?>" width="400"></label><br>
													<hr>
													choose file to change image<br><input type="file" class="imageupload" data-source="ImagePath">
												</div>
											</div>	-->										
<?php
			}
			elseif($key=="CategoryType")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $key)?> <span>*</span></label>
												<div class="col-sm-2">
													<select name="<?=$key?>" class="form-control required">
														<?php
															if ($row[$key]=="1")
															{
														?>
																<option value="1" selected>Category</option>
																<!--<option value="2">Sub Category</option>-->
																
														<?php
															}
															elseif ($row[$key]=="2")
															{
														?>
																<option value="1">Category</option>
																<!--<option value="2" selected>Sub Category</option>-->
																
														<?php
															}
															else
															{
														?>
																<option value="" selected>--Choose Type--</option>
																<option value="1">Category</option>
																<!--<option value="2">Sub Category</option>-->
																
														<?php
															}
														?>	
													</select>
												</div>
											</div>
<?php
			}
			else if ($key=="MainCategoryType")
			{
			   $seldatap=select("MainCategoryType","tblCategories","CategoryID='".$strID ."'");
				$cat_type=$seldatap[0]['MainCategoryType'];
				
				if($cat_type!='0')
				{
?>
											<div class="form-group" id="cat" ><label class="col-sm-3 control-label"><?=str_replace("MainCategoryType", "Main Type", $key)?> <span>*</span></label>
												<div class="col-sm-3">
													<select name="<?=$key?>" class="form-control" >
																	<option value="" Selected>-- Choose Type --</option>
																		<?php
																				$seldata=select("*","tblCategories","CategoryType='1'");
																				foreach($seldata as $val)
																				{
																					$seldatap=select("MainCategoryType","tblCategories","CategoryID='".$strID ."'");
																					foreach($seldatap as $valp)
																					{
																						$cat_type=$valp['MainCategoryType'];
?>

																						<option value="<?php echo $val['CategoryID'] ?>"<?php if($cat_type==$val['CategoryID']){ ?> selected='selected' <?php } ?>><?php echo $val['CategoryName'] ?></option>	
<?
																					}
																				}
																?>
													</select>
												</div>
											</div>
<?php
				}
				else
				{
				}
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