<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';
$TagID=array();
$TagID1=array();
 ?>
<script>
function saifusmani(COUNT)
{
	var ischeckedx = document.getElementById("inlineCheckbox110"+COUNT).checked;
	alert(ischeckedx);
}

</script>	


<?php
	$strPageTitle = "Menu Roles for Admin | Nailspa";
	$strDisplayTitle = "Manage Menu Roles for Admin Nailspa POS";
	$strMenuID = "2";
	$strMyTable = "tblAdminRoles";
	$strMyTableID = "RoleID";
	$strMyField = "RoleName";
	$strMyActionPage = "ManageAdminMenuRoles.php";
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
			$strRoleID = Filter($_POST["RoleID"]);
			$strMenuMasterID = Filter($_POST["MenuMasterID"]);
			$strStatus = Filter($_POST["Status"]);
							
			$DB = Connect();
			$sqlInsert = "Insert into $strMyTable (RoleID, MenuMasterID, Status) values
				('".$strRoleID."','".$strMenuMasterID."', '".$strStatus."')";
				
				
			ExecuteNQ($sqlInsert);
			$DB->close();
			die('<div class="alert alert-close alert-success">
				<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
				<div class="alert-content">
					<h4 class="alert-title">Admin Menu Role Added</h4>
					<p>Record Added Successfully</p>
				</div>
			</div>');
			

		}

		if($strStep=="edit")
		{
			$DB = Connect();
		
		if ($_POST['TagID']=="")
		{
		//	echo 13456;
			
			$msg = "You didn't select any check boxes";
			echo $msg;
		
			exit();
		}
		else
		{
		//echo 124455;
			$TagID=$_POST['TagID'];
				foreach($TagID as $tags)
				{
					//print_r($tags);
					//echo $tags;
				$DB = Connect();
					$sqlDelete = "DELETE FROM tblAdminMenuRole WHERE RoleID='".Decode($_POST[$strMyTableID])."' and MenuMasterID='".$tags."'";
		              ExecuteNQ($sqlDelete);
					  
					  $sqlInsert1 = "Insert into tblAdminMenuRole (RoleID, MenuMasterID, Status) values('".Decode($_POST[$strMyTableID])."','".$tags."', '0')";
					  $DB->query($sqlInsert1); 
					/* // $sqlInsert1 = "Insert into tblAdminMenuRole (RoleID, MenuMasterID, Status) values('".Decode($_POST[$strMyTableID])."','".$tags."', '0')";
					$sql_named = select("count(MenuRoleID)","tblAdminMenuRole","RoleID='".Decode($_POST[$strMyTableID])."' and MenuMasterID='".$tags."'");
					print_r($sql_named);
					
					if ($sql_named[0][count(MenuRoleID)] > 0) 
					{
					echo 1111;
						$sqlDelete = "DELETE FROM tblAdminMenuRole WHERE RoleID='".Decode($_POST[$strMyTableID])."' and MenuMasterID='".$tags."'";
		              ExecuteNQ($sqlDelete);
					// $sqlInsert1 = "Insert into tblAdminMenuRole (RoleID, MenuMasterID, Status) values('".Decode($_POST[$strMyTableID])."','".$tags."', '0')";
				           
					}
					else
					{
					echo 124455;
					// $sqlInsert1 = "Insert into tblAdminMenuRole (RoleID, MenuMasterID, Status) values('".Decode($_POST[$strMyTableID])."','".$tags."', '0')";
					// echo $sqlInsert1;
								
								$DB->query($sqlInsert1); 
					} */
							
									
				}		
		}
			
		
				
		
	
				
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
						<h4 class="alert-title">Admin Menu Role Updated</h4>
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
		<script>
		function validateChecks() 
		{
			var chks = document.getElementsByName('TagID[]');
			var checkCount = 0;
			for (var i = 0; i < chks.length; i++) {
				if (chks[i].checked) {
					checkCount++;
				}
			}
			if (checkCount < 1) {
				return false;
			}
			return true;
		}
		function validate(form) {
			if(validateChecks()==false) {
				alert('Please fill all the required fields.');
				return false;
			}
			return true;
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
                        <p>Add, Edit, Delete Admins Menu Role and give them POS control rights accordingly.</p>
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
											<li><a href="#normal-tabs-1" title="Tab 1">Connect Roles</a></li>
											
										</ul>
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Admin Roles and their assigned Menu </h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Role Name</th>
																<th>Menu Assigned</th>
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Role Name</th>
																<th>Menu Assigned</th>
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
		$strMenuRoleID = $row["RoleID"];
		$getUID = EncodeQ($strMenuRoleID);
		$getUIDDelete = Encode($strMenuRoleID);
		$RoleID = $row["RoleID"];
		$Status = $row["Status"];
		
		if($Status=="0")
		{
			$Status = "Live";
		}
		else
		{
			$Status = "Offline";
		}
		
		// Query for Roles connection Yogita
		$sql_namede = select("*","tblAdminRoles","RoleID='".$RoleID."'");
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$sql_namede[0]['RoleName']?></td>
																<td>
																<?php 
																
																$sqldp = "Select distinct(am.MenuMasterID) FROM  tblAdminMenuMasters as am left join tblAdminMenuRole amr on am.MenuMasterID=amr.MenuMasterID where amr.RoleID='".$RoleID."' group by am.MenuName";
															//	print_r($sqldp);
															     $RSWp = $DB->query($sqldp);
																 if ($RSWp->num_rows > 0) 
																 {
																	while($row3 = $RSWp->fetch_assoc())
																	{
																		
																		//echo $row3["MenuMasterID"];
																		$counterMENU++;
																		$strMenuMasterID = $row3["MenuMasterID"];
																		$getUIDDelete1 = Encode($strMenuMasterID);
														$sql_name = select("distinct(MenuName)","tblAdminMenuMasters","MenuMasterID='".$strMenuMasterID."'");
														
																		$strMenuName = $sql_name[0]['MenuName'];
																		
																?>
<script>
function saifusmani(COUNT)
{
	var ischeckedx = document.getElementById("inlineCheckbox110"+COUNT).checked;
	alert(ischeckedx);
}

</script>	
<script>
	function myFunction(a)
	{
		alert(a);
	}
</script>																<label>
																						<?=$strMenuName?>
																						</label>	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step23','<?=$getUIDDelete?>', 'Are you sure you want to delete this Admin Menu Role - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a><br/>
																			<?php
																			$sql3 = "Select distinct(am.SubmenuName) FROM  tblAdminMenuMasters as am left join tblAdminMenuRole amr on am.MenuMasterID=amr.MenuMasterID where amr.RoleID='".$RoleID."' and am.MenuName='$strMenuName'";
																		//	$sql3 = "Select MenuMasterID, SubmenuName FROM tblAdminMenuMasters where status=0 and MenuName='$strMenuName' order by MenuMasterID desc";
																			$RS3 = $DB->query($sql3);
																			if ($RS3->num_rows > 0) 
																			{
																				
																				
																				while($row3 = $RS3->fetch_assoc())
																				{
																					$countersaif++;
																					$strMenuMasterIDd = $row3["MenuMasterID"];
																					$getUIDDelete1 = Encode($strMenuMasterID);
																					$strSubMenuName = $row3["SubmenuName"];
																					
																					
																			?>	
																					<label><?=$strSubMenuName?></label>	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData1('Step22','<?=$getUIDDelete?>', 'Are you sure you want to delete this Admin Menu Role - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>','<?=$getUIDDelete1?>');">Delete</a><br/>
																			
																			<?php	
																				}
																			}
																			?>	
																<?php	
																	}
																}
															?>
																
																</td>
																<td><?=$Status?></td>
																<td>
																	<center>
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Connect</a>
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step23','<?=$getUIDDelete?>', 'Are you sure you want to delete this Admin Menu Role - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
																	</center>
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
														
														</tbody>
													</table>
												</div>
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
							<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email', '.admin_password'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

								
									<h3 class="title-hero">Connect Admin Roles here</h3>
									<div class="example-box-wrapper">
										
<?php

$strID = DecodeQ(Filter($_GET["uid"]));
//echo $strID;
$DB = Connect();
$sql = "select * FROM $strMyTable where $strMyTableID = '$strID'";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{
		foreach($row as $key => $val)
		{
			//echo $key;
			if($key==$strMyTableID)
			{
?>
											<input type="hidden" name="<?=$key?>" value="<?=Encode($strID)?>">	
<?php
			}
			elseif($key=="RoleID")
			{
					$DBvalue=$row[$key];
					
?>	
					<div class="form-group">
							<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("RoleID", "Role ID", $key)?> <span>*</span></label>
								<div class="col-sm-4">	
									

									<?php
										// echo $DBvalue;
										if(isset($_GET["uid"]))
										{
											$strID = DecodeQ(Filter($_GET["uid"]));
											$sql = "SELECT RoleID, RoleName from tblAdminRoles where RoleID='".$strID."'";
										}
										else
										{
											$sql = "SELECT RoleID, RoleName from tblAdminRoles";
										}
										
										$RS2 = $DB->query($sql);
										if ($RS2->num_rows > 0)
										{
									?>

											<select class="form-control required" name="<?=$key?>">
												<?
													while($row2 = $RS2->fetch_assoc())
													{
														$RoleID = $row2["RoleID"];
														$RoleName = $row2["RoleName"];
														if($DBvalue==$RoleID)
														{	
												?>

															<option value="<?=$RoleID?>" selected><?=$RoleName?></option>	
												<?php
														}
														else
														{
												?>

															<option value="<?=$RoleID?>"><?=$RoleName?></option>	
												<?php
														}
													}
												?>
											</select>
									<?php
										}
										else
										{
											echo "Admin Roles are not added. <a href='ManageAdminRoles.php' target='Admin Rol Not Added'>Click here to add</a>";
										}
								?>
								</div>
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

	</div>
	<div class="form-group"><label class="col-sm-3 control-label">Select Menu Master</label>
																			<div class="col-sm-6">
																<?php
																$countersaif ="";
																$counterMENU ="";
																$sqldd=select("distinct(MenuMasterID)","tblAdminMenuRole","RoleID='".$strID."'");
															//$sqldd = "Select count(*) FROM tblAdminMenuRole where RoleID='".$strID."'";
															//$RSW = $DB->query($sqldd);
															//print_r($sqldd);
															//print_r($sqldd);
															$cnt=$sqldd[0]['MenuMasterID'];
															//echo $cnt;
																if($cnt!='') 
																{
																//	echo 3456;
																		$sqldp = "Select distinct(am.MenuMasterID) FROM  tblAdminMenuMasters as am left join tblAdminMenuRole amr on am.MenuMasterID=amr.MenuMasterID where amr.RoleID='".$strID."' group by am.MenuName";
															     $RSWp = $DB->query($sqldp);
																 if ($RSWp->num_rows > 0) 
																{
																	
																//	echo 1345;
																	while($row3 = $RSWp->fetch_assoc())
																	{
																		
																		//echo $row3["MenuMasterID"];
																		$counterMENU++;
																		$strMenuMasterID = $row3["MenuMasterID"];
														$sql_name = select("distinct(MenuName)","tblAdminMenuMasters","MenuMasterID='".$strMenuMasterID."'");
														
																		$strMenuName = $sql_name[0]['MenuName'];
																		
																?>
<script>
function saifusmani(COUNT)
{
	var ischeckedx = document.getElementById("inlineCheckbox110"+COUNT).checked;
	alert(ischeckedx);
}

</script>	
<script>
	function myFunction(a)
	{
		alert(a);
	}
</script>															
																			<div class="row">
																				<div class="col-md-6">
																					<div class="checkbox checkbox-primary"><label>
																						<input type="checkbox" id="inlineCheckbox110<?=$counterMENU?>" name="TagID[]" class="custom-checkbox" checked="checked" value="<?=$strMenuMasterID?>" ><?=$strMenuName?>
																						</label></div>
																				</div>
																			</div>
																			
																			<?php
																			//$sql3 = "Select MenuMasterID, SubmenuName FROM tblAdminMenuMasters where status=0 and MenuName='$strMenuName' order by MenuMasterID desc";
																			$sql3 = "Select distinct(am.SubmenuName) FROM  tblAdminMenuMasters as am left join tblAdminMenuRole amr on am.MenuMasterID=amr.MenuMasterID where amr.RoleID='".$strID."' and am.MenuName='$strMenuName'";
																			$RS3 = $DB->query($sql3);
																			if ($RS3->num_rows > 0) 
																			{
																				
																				
																				while($row3 = $RS3->fetch_assoc())
																				{
																					$countersaif++;
																					$strMenuMasterIDd = $row3["MenuMasterID"];
																					$strSubMenuName = $row3["SubmenuName"];
																					
																					
																			?>	
																					<div class="row" style="padding-left:27px;">
																						<div class="col-md-6">
																							<div class="checkbox checkbox-primary"><label><input type="checkbox"  id="inlineCheckbox110" checked="checked" name="TagID[]" class="custom-checkbox" value="<?=$strMenuMasterIDd?>" ><?=$strSubMenuName?></label></div>
																						</div>
																					</div>
																			
																			<?php	
																				}
																			}
																			?>	
																<?php	
																	}
																}

																}
																else
																{
																	//echo 12345;
																			$sql2 = "Select distinct MenuName FROM tblAdminMenuMasters where status=0 and SubMenuName is not null order by MenuMasterID desc";
																$RS2 = $DB->query($sql2);
																if ($RS2->num_rows > 0) 
																{
																	
																	
																	while($row2 = $RS2->fetch_assoc())
																	{
																		$counterMENU++;
																		$strMenuName = $row2["MenuName"];
														$sql_name = select("MenuMasterID","tblAdminMenuMasters","MenuName='".$strMenuName."'");
														
																		$strMenuMasterID = $sql_name[0]['MenuMasterID'];
																		
																?>
<script>
function saifusmani(COUNT)
{
	var ischeckedx = document.getElementById("inlineCheckbox110"+COUNT).checked;
	alert(ischeckedx);
}

</script>	
<script>
	$(document).ready(function(){
		$('.mainmenu').click(function() {
		//alert(111)
  if ($(this).is(':checked')) {
		//alert(12345)
   $(".submenu").prop('checked', true);
    } else {
        $(".submenu").attr('checked', false);
    } 
		
	});
	
});
</script>															
																			<div class="row">
																				<div class="col-md-6">
																					<div class="checkbox checkbox-primary"><label>
																						<input type="checkbox" id="inlineCheckbox110<?=$counterMENU?>" name="TagID[]" class="custom-checkbox" value="<?=$strMenuMasterID?>" ><?=$strMenuName?>
																						</label></div>
																				</div>
																			</div>
																			
																			<?php
																			$sql3 = "Select MenuMasterID, SubmenuName FROM tblAdminMenuMasters where status=0 and MenuName='$strMenuName' order by MenuMasterID desc";
																			$RS3 = $DB->query($sql3);
																			if ($RS3->num_rows > 0) 
																			{
																				
																				
																				while($row3 = $RS3->fetch_assoc())
																				{
																					$countersaif++;
																					$strMenuMasterIDd = $row3["MenuMasterID"];
																					$strSubMenuName = $row3["SubmenuName"];
																					
																					
																			?>	
																					<div class="row" style="padding-left:27px;">
																						<div class="col-md-6">
																							<div class="checkbox checkbox-primary"><label><input type="checkbox"  id="inlineCheckbox110" name="TagID[]" class="custom-checkbox" value="<?=$strMenuMasterIDd?>" ><?=$strSubMenuName?></label></div>
																						</div>
																					</div>
																			
																			<?php	
																				}
																			}
																			?>	
																<?php	
																	}
																}
																else
																{
																	echo "No Menu Found";
																}
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