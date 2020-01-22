<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Admin Management | Nailspa";
	$strDisplayTitle = "Manage Admins Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblAdmin";
	$strMyTableID = "AdminID";
	$strMyField = "AdminUserName";
	$strMyActionPage = "ManageAdmin.php";
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
						// echo $sqlColumnValues."<br>";
					}
					else
					{
						$sqlColumn = $sqlColumn.",".$key;
						$sqlColumnValues = $sqlColumnValues.", '".$_POST[$key]."'";
						// echo $sqlColumnValues."<br>";
					}
					// echo $sqlColumnValues."<br>";
				}	
			}
			
			$strAdminFullName = Filter($_POST["AdminFullName"]);
			$strAdminUserName = Filter($_POST["AdminUserName"]);
			$strAdminPassword = Filter($_POST["AdminPassword"]);				
			$strAdminEmailID = Filter($_POST["AdminEmailID"]);
			$strAdminRoleID = Filter($_POST["AdminRoleID"]);
			$strAdminType = Filter($_POST["AdminType"]);
			$strStatus = Filter($_POST["Status"]);
			$strcheckbox= Filter($_POST["count"]);
			$strStoreID= Filter($_POST["StoreID"]);
			// echo $strStoreID;
			// die();
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
						<p>The Username already exists in our system. Please try again with a different Username.</p>
					</div>
				</div>');
			}
			else
			{
				$InsertAdmin="Insert into tblAdmin(AdminFullName, AdminUserName, AdminPassword, AdminEmailID, AdminRoleID, AdminType, Status) VALUES ('".$strAdminFullName."','".$strAdminUserName."','".$strAdminPassword."','".$strAdminEmailID."','".$strAdminRoleID."','".$strAdminType."','".$strStatus."')";
				if($DB->query($InsertAdmin) === TRUE) 
				{
					$last_id3 = $DB->insert_id;		//last id of tbladmin insert
					// echo $last_id3."<br>";
				}
				else
				{
					echo "Error: " . $InsertAdmin . "<br>" . $conn->error;
				}	
				$AdminStore="Insert into tblAdminStore(AdminID, StoreID, Status) VALUES ('".$last_id3."','".$strStoreID."','".$strStatus."')";
				$DB->query($AdminStore);
				// echo $AdminStore;
				// die();
				foreach($_POST as $key => $val)
				{
					if($key=="step" || $key==AdminFullName || $key==AdminUserName || $key==AdminPassword || $key==AdminEmailID || $key==AdminRoleID || $key==Status )
					{						
						// $sqlInsert = "INSERT INTO $strMyTable ($sqlColumn) VALUES ($sqlColumnValues)";
						// echo $sqlInsert;
											
					}
					else
					{
						// echo "Hello<br>";
						$MenuR=$_POST[$key];
						// echo "$MenuR <br>";
						if(strpos($MenuR,'|') !== false)
						{
							$Value = explode("|", $MenuR); 
							// echo $Value;
							$v1=$Value[0];	
							$v2=$Value[1];
							// echo $v1."<br>";
							if($v2=="role")
							{
								$sqlInsert2 = "INSERT INTO tblAdminMenuRole (RoleID, MenuMasterID,Status) VALUES ('".$Taginsert."','".$v1."','0','0')";
								// Add by asmita
								if ($DB->query($sqlInsert2) === TRUE) 
								{
									$role_id = $DB->insert_id;		//last id of tblAdminMenuRole insert
									// echo $role_id."<br>";
								}
								else
								{
									echo "Error: " . $sqlInsert2 . "<br>" . $conn->error;
								}
								// End by asmita
								// $DB->query($sqlInsert2);
							}							
						}
						// if ($DB->query($sqlInsert) === TRUE) 
						// {
							// $last_id3 = $DB->insert_id;		//last id of tbladmin insert
							// echo $last_id3."<br>";
						// }
						// else
						// {
							// echo "Error: " . $sqlInsert . "<br>" . $conn->error;
						// }
						
				
				//echo $sqlInsert;
			
				
				$strAdminEmailID = Filter($_POST["AdminEmailID"]);
				$strTo = $strAdminEmailID;
				$strFrom = "order@fyatest.website";
				$strSubject = "Welcome To Nailspa: Login Details";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2

				$Name = $strAdminUserName;
				$Email = $strAdminEmailID;
				$strAdminPassword = $strAdminPassword;
				$strDate = date("Y-m-d h:i:s");
					
			
				$message = file_get_contents('EmailFormat/admin.html');
				$message = eregi_replace("[\]",'',$message);
                $path="`http://nailspaexperience.com/images/test2.png`";
				
				//setup vars to replace
				$vars = array('{Name_Detail}','{Email_Detail}','{Password}','{path}'); //Replace varaibles
				$values = array($Name,$Email,$strAdminPassword,$path);

				//replace vars
				$message = str_replace($vars,$values,$message);
				// echo $message;

                
				$strBody1 = $message;
				$flag='A';
				$id = $last_id3;
				// echo $id."<br>";
			 
			
			sendmail($id,$strTo,$strFrom,$strSubject,$strBody1,$strDate,$flag,$strStatus);
		
			
			
			//exit;
					}										
				}
			
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Admin Added</h4>
						<p>Record Added Successfully</p>
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
					$sqlUpdate = "update $strMyTable set $key='$_POST[$key]' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					ExecuteNQ($sqlUpdate);
					//echo "$sqlUpdate";
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
	<!-- Styles -->
	<style>
	#chartdiv {
	  width: 100%;
	  height: 500px;
	}										
	</style>

	<!-- Resources -->
	<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script src="ChartsandGraphs/js/serial.js"></script>
	<script src="ChartsandGraphs/js/export.min.js"></script>
	<link rel="stylesheet" href="ChartsandGraphs/css/export.css" type="text/css" media="all" />
	<script src="https://www.amcharts.com/lib/3/themes/patterns.js"></script>
	
	<!-- Chart code -->
	<script>
	var chart = AmCharts.makeChart("chartdiv", {
		"theme": "patterns",
		"type": "serial",
		"startDuration": 2,
		"dataProvider": [{
			"country": "Khar",
			"visits": 200000,
			"color": "#F08080"
		},{
			"country": "Oshiwara",
			"visits": 350000,
			"color": "#CD5C5C"
		},{
			"country": "Lokhandwala",
			"visits": 100000,
			"color": "#FFA07A"
		},{
			"country": "BreachCandy",
			"visits": 200000,
			"color": "#FA8072"
		},{
			"country": "Colaba",
			"visits": 50000,
			"color": "#E9967A"
		}],
		"valueAxes": [{
			"position": "left",
			"title": "Sales"
		}],
		"graphs": [{
			"balloonText": "[[category]]: <b>[[value]]</b>",
			"fillColorsField": "color",
			"fillAlphas": 1,
			"lineAlpha": 0.1,
			"type": "column",
			"valueField": "visits"
		}],
		"depth3D": 30,
		"angle": 40,
		"chartCursor": {
			"categoryBalloonEnabled": true,
			"cursorAlpha": 0,
			"zoomable": false
		},
		"categoryField": "country",
		"categoryAxis": {
			"gridPosition": "start",
			"labelRotation": 90
		},
		"export": {
			"enabled": true
		 }

	});
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
                        <p>Add, Edit, Delete Admins and give them rights accordingly.</p>
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
											<li><a href="#normal-tabs-2" title="Tab 2">Graph</a></li>
										</ul>
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of admins working for Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Name & EmailID</th>
																<th>Credentials</th>
																<th>Admin Type</th>
																<th>Last Logged in?</th>
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Name & EmailID</th>
																<th>Credentials</th>
																<th>Admin Type</th>
																<th>Last Logged in?</th>
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SELECT * FROM $strMyTable order by $strMyTableID desc";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strAdminID = $row["AdminID"];
		$getUID = EncodeQ($strAdminID);
		$getUIDDelete = Encode($strAdminID);
		$AdminFullName = $row["AdminFullName"];
		$AdminUsername = $row["AdminUserName"];
		$AdminPassword = $row["AdminPassword"];
		$AdminEmailID = $row["AdminEmailID"];
		$AdminRoleID = $row["AdminRoleID"];
		$LastLogin = $row["LastLogin"];
		$AdminType = $row["AdminType"];
		$Status = $row["Status"];
		
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
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><b>Name :</b> <?=$AdminFullName?> <br><b>Email :</b> <?=$AdminEmailID?></td>
																<td><b>Username :</b> <?=$AdminUsername?> <br><b>Password :</b> <?=$AdminPassword?></td>
																<td><?=$AdminType?></td>
																<td><?=FormatDateTime($LastLogin, "1")?></td>
																<td><?=$Status?></td>
																<td>
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																	
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step3','<?=$getUIDDelete?>', 'Are you sure you want to delete this Admin - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
																	
																
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
													<div id="chartdiv"></div>
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

								
									<h3 class="title-hero">Edit Admin Details</h3>
									<div class="example-box-wrapper">
										
<?php

$strID = DecodeQ(Filter($_GET["uid"]));
$DB = Connect();
$sql = "SELECT * FROM $strMyTable WHERE $strMyTableID = '$strID'";
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
			elseif($key=="AdminUserName")
			{
?>	
										
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminUserName", "User Name", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input class="form-control" value="<?=$row[$key]?>" readonly></div>
											</div>

<?php
			}
			elseif($key=="AdminEmailID")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminEmailID", "Email Id", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input type="text" name="<?=$key?>" class="form-control admin_email required" placeholder="<?=str_replace("Admin", " ", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="AdminPassword")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminPassword", "Password", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control admin_password required" placeholder="<?=str_replace("Admin", " ", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="AdminFullName")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminFullName", "Full Name", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input type="text" name="<?=$key?>" class="form-control admin_password required" placeholder="<?=str_replace("AdminFullName", "Full Name", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="AdminRoleID")
			{
					$DBvalue=$row[$key];
					
?>	
					<div class="form-group">
							<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminRoleID", "Role ID", $key)?> <span>*</span></label>
								<div class="col-sm-4">	
									

									<?php
										// echo $DBvalue;
										$sql = "SELECT RoleID, RoleName FROM tblAdminRoles";
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
			elseif($key=="LastLogin")
			{
?>
<?php
			}
			elseif($key=="AdminType")
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("AdminType", "Admin Type", $key)?> <span>*</span></label>
												<div class="col-sm-2">
													<select name="<?=$key?>" class="form-control required">
														<?php
															if ($row[$key]=="0")
															{
														?>
																<option value="0" selected>Super Admin</option>
																<option value="1">Admin</option>
														<?php
															}
															elseif ($row[$key]=="1")
															{
														?>
																<option value="0">Super Admin</option>
																<option value="1" selected>Admin</option>
														<?php
															}
															else
															{
														?>
																<option value="" selected>--Choose option--</option>
																<option value="0">Super Admin</option>
																<option value="1">Admin</option>
														<?php
															}
														?>	
													</select>
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