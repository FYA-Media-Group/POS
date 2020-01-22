<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Employee Management | Nailspa";
	$strDisplayTitle = "Manage Employee Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblEmployeesRecords";
	$strMyTableID = "ERID";
	$strMyField = "EmployeeCode";
	$strMyActionPage = "ManageAttendance.php";
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
			
				
			$strEmployeeCode = Filter($_POST["EmployeeCode"]);
			$strDateOfAttendance = Filter($_POST["DateOfAttendance"]);
			$strLoginTime = Filter($_POST["LoginTime"]);	
			$strLogoutTime = Filter($_POST["LogoutTime"]);
			$strStatus= Filter($_POST["Status"]);

			$DB = Connect();
			
			$sqldate="SELECT DATE_FORMAT(DateOfAttendance, '%Y-%m-%d') DATEONLY,DATE_FORMAT(DateOfAttendance,'%H:%i:%s') TIMEONLY from tblEmployeesRecords where ERID='15'";
			$RS = $DB->query($sqldate);
			$row=$RS->fetch_assoc();
			$TodaysDate=$row["DATEONLY"];
			$TodaysTime=$row["TIMEONLY"];
					
			
			
			$sql1 = "Select $strMyTableID from $strMyTable where $strMyField='$_POST[$strMyField]' and DateOfAttendance = '$TodaysDate $TodaysTime' ";
			echo "$sql1";
			die();
			$RS = $DB->query($sql1);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-warning alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
						</button>
						<strong>The Employee Code already exists in the system.</strong>
					</div>');
				die("");
			}
			else
			{
				$filepath = 'imageupload/images';
				CreateFolder($filepath);
				
				$strValidateImage1 = trim(ValidateImageFile2($_FILES, "ImagePath", UniqueStamp()."0".$_FILES["ImagePath"]["name"], $filepath));
				if($strValidateImage1=="Saved successfully")
				{
					// for First Image
					$filename1 = $_FILES["ImagePath"]["name"];
					
					$uploadFilename1 = UniqueStamp()."0".$filename1;		
					$strImageUploadPath1 = $filepath."/".$uploadFilename1;
					// #######################
				}
				else
				{
					die($strValidateImage1);
				}

				// $sqlUpdate = "UPDATE $strMyTable SET LoginTime = now() WHERE  EmployeeCode = strEmployeeCode and DateOfAttendance = '$strDateOfAttendance'";
					
				$sqlInsert = "Insert into $strMyTable (EmployeeCode, DateOfAttendance, LoginTime, LogoutTime, Status) values
				('".$strEmployeeCode."','".$strDateOfAttendance."', '".$strLoginTime."', '".$strLogoutTime."', '".$strStatus."')";				
				// ExecuteNQ($sqlInsert);
				
				if ($DB->query($sqlInsert) === TRUE) 
				{
					$last_id = $DB->insert_id;
				}
				else
				{
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
				
				$sql1 = "Insert into tblEmployeesImages (ImagePath, EID, Status) Values ('$strImageUploadPath1','$last_id', '0')";
				
				ExecuteNQ($sql1);
				
				$sql2 = "INSERT INTO tblEmployeesRecords(EmployeeCode,DateOfAttendance,Status) VALUES ('$last_id', now(), '0')";
				ExecuteNQ($sql2);

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
			$EmployeeCode = Filter($_POST["EmployeeCode"]);
			$StoreID = Filter($_POST["StoreID"]);
			$EmployeeName = Filter($_POST["EmployeeName"]);
			$EmployeePincode = Filter($_POST["EmployeePincode"]);
			$EmployeeAddress = Filter($_POST["EmployeeAddress"]);
			$EmployeeEmailID = Filter($_POST["EmployeeEmailID"]);
			$EmployeeMobileNo = Filter($_POST["EmployeeMobileNo"]);
			$ImagePath = Filter($_POST["ImagePath"]);
			$Status = Filter($_POST["Status"]);
			
			if(isset($_FILES["ImagePath"]["error"]))
			{
				$strValidateImage1 = trim(ValidateImageFile($_FILES, "ImagePath"));
				if($strValidateImage1=="Saved successfully")
				{
				
					// As the image is valid first select the imagename for previous image
					
					$DB = Connect();
					$sql = "Select ImagePath, EID FROM tblEmployeesImages where $strMyTableID='".Decode($_POST[$strMyTableID])."' ";
					
					
					$RS = $DB->query($sql);
					if ($RS->num_rows > 0) 
					{
						while($row = $RS->fetch_assoc())
						{
							$strOldImageURL = $row["ImagePath"];	
							$strEID = $row["EID"];
						}
						
						$file = $strOldImageURL;
						unlink($file);
						
						$filepath = 'imageupload/images';
						$filename1 = $_FILES["ImagePath"]["name"];
						
						$uploadFilename1 = UniqueStamp().$filename1;		
						$strImageUploadPath1 = $filepath."/".$uploadFilename1;
						// #######################
						
							
						
						$sqlUpdate = "update tblEmployeesImages set ImagePath='".$strImageUploadPath1."' where $strMyTableID='".Decode($_POST[$strMyTableID])."' ";
						ExecuteNQ($sqlUpdate);
							
						
						echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Employee Image Updated Successfully</strong>
								</div>');						
					}
					else
					{
						$filepath = 'imageupload/images';
						// for First Image
						$filename1 = $_FILES["ImagePath"]["name"];
						
						$uploadFilename1 = UniqueStamp().$filename1;		
						$strImageUploadPath1 = $filepath."/".$uploadFilename1;
						// #######################
						
						$sql1 = "Insert into tblEmployeesImages (ImagePath, EID, Status) Values ('$strImageUploadPath1','$strEID', '0')";
						ExecuteNQ($sql1);
						
						echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
							</button>
							<strong>Employee Image Added Successfully</strong>
							</div>');
					}					
					
				}
				else
				{
					die($strValidateImage1);
				}
				foreach($_POST as $key => $val)
				{
					if($key=="step" || $key==$strMyTableID ||  $key=="ImagePath" )
					{
					
					}
					else
					{
						$sqlUpdate = "UPDATE $strMyTable SET $key='$_POST[$key]' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
						ExecuteNQ($sqlUpdate);
						//echo($sqlUpdate);
					}	
				}
				die('<div class="alert alert-close alert-success">
						<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
						<div class="alert-content">
							<h4 class="alert-title">Record Updated Successfully</h4>
						</div>
					</div>');
			}			
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
                        <p>Add, Edit, Delete Employee Details</p>
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
											<!--<li><a href="#normal-tabs-2" title="Tab 2">Add</a></li>-->
										</ul>
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Employees Attendance</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Employee Name</th>	
																<th>Date</th>	
																<th>Check In & Check Out</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Employee Name</th>
																<th>Date</th>
																<th>Check In & Check Out</th>
															</tr>
														</tfoot>
														<tbody>
													

<?php
//Retrieve And Display Values in a Table
// Create connection And Write Values
$DB = Connect();
// echo $strAdminID;

$FindStore="Select StoreID from tblAdminStore where AdminID=$strAdminID";
// echo $FindStore;
$RSf = $DB->query($FindStore);
if ($RSf->num_rows > 0) 
{
	while($rowf = $RSf->fetch_assoc())
	{
		$strStoreID = $rowf["StoreID"];
		// echo $strStoreID;
	}
}
// $sql1 = "Select * FROM tblEmployeesRecords order by $strMyTableID desc";
					
$TodaysDate = date("Y-m-d");
// echo $TodaysDate."<br>";
$pqr="00:00:00";
// echo $pqr;
// if(isset($_GET['s']))
// {
// $strStoreID = DecodeQ($_GET['s']);
// echo $strStoreID;
// $sql = "SELECT  tblEmployees.EmployeeCode, tblEmployees.EmployeeName, tblEmployeesRecords.DateOfAttendance, tblEmployeesRecords.ERID, tblEmployeesRecords.LoginTime, tblEmployeesRecords.LogoutTime,  tblEmployeesRecords.EmployeeCode  
// from tblEmployees 
// Left join tblEmployeesRecords 
// ON tblEmployees.EmployeeCode=tblEmployeesRecords.EmployeeCode 
// WHERE tblEmployeesRecords.DateOfAttendance='$TodaysDate' 
// AND tblEmployees.StoreID='".$strStoreID."'";
// echo $sql;

// }
// else
// {
// $sql = "SELECT  tblEmployees.EmployeeCode, tblEmployees.EmployeeName, tblEmployeesRecords.DateOfAttendance, tblEmployeesRecords.ERID, tblEmployeesRecords.LoginTime, tblEmployeesRecords.LogoutTime,  tblEmployeesRecords.EmployeeCode  
// from tblEmployees 
// Left join tblEmployeesRecords 
// ON tblEmployees.EmployeeCode=tblEmployeesRecords.EmployeeCode 
// WHERE tblEmployees.StoreID='$strStoreID' AND tblEmployeesRecords.DateOfAttendance='$TodaysDate'";
 // echo $sql;
// }

if($strStore!='0')
{
	$sql = "SELECT tblEmployees.EmployeeCode, tblEmployees.EmployeeName, tblEmployeesRecords.DateOfAttendance, tblEmployeesRecords.ERID, tblEmployeesRecords.LoginTime, tblEmployeesRecords.LogoutTime,  tblEmployeesRecords.EmployeeCode  
from tblEmployees 
Left join tblEmployeesRecords 
ON tblEmployees.EmployeeCode=tblEmployeesRecords.EmployeeCode 
WHERE tblEmployees.StoreID='$strStore' AND tblEmployeesRecords.DateOfAttendance='$TodaysDate'";
}
else
{
	$sql = "SELECT  tblEmployees.EmployeeCode, tblEmployees.EmployeeName, tblEmployeesRecords.DateOfAttendance, tblEmployeesRecords.ERID, tblEmployeesRecords.LoginTime, tblEmployeesRecords.LogoutTime,  tblEmployeesRecords.EmployeeCode  
from tblEmployees 
Left join tblEmployeesRecords 
ON tblEmployees.EmployeeCode=tblEmployeesRecords.EmployeeCode 
WHERE tblEmployeesRecords.DateOfAttendance='$TodaysDate'";
}

// echo $sql;
// echo $AdminRoleID."<br>";
// echo $strAdminID."<br>";

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	// echo "In if loop";
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strERID = $row["ERID"];
		$getUID = EncodeQ($strERID);
		$getUIDDelete = Encode($strERID);
		$EmployeeName = $row["EmployeeName"];
		$EmployeeCode = $row["EmployeeCode"];
		$seldataqddt=select("EID","tblEmployees","EmployeeCode='".$EmployeeCode."'");
	    $EID=$seldataqddt[0]['EID'];
		
		
		$DateOfAttendance = $row["DateOfAttendance"];
		$LoginTime = $row["LoginTime"];
		$LogoutTime = $row["LogoutTime"];
		$Status = $row["Status"];
		// echo $LoginTime;
		
		if($Status=="0")
		{
			$Status = "Live";
		}
		else
		{
			$Status = "Offline";
		}
?>	
<script>
	
	function Checkin(a1)
	{
		// alert (a1);
		var ERID = a1;
		 $.ajax({
				   type: 'POST',
				   url: 'AttendanceCheckin.php',
				   data: {
					   getERID: ERID
				   },
					
				   success: function(response) {
					   $('.result_message').html(response);    
					   location.reload();
				   }
			   });
	}
function CheckOut(a2)
{
	var ERID1 = a2;
	 $.ajax({
			   type: 'POST',
			   url: 'AttendanceCheckout.php',
			   data: {
				   getERID: ERID1
			   },
				
			   success: function(response) {
					document.getElementById("CheckOut"+ERID1).innerHTML = response;
			   }   
			   
		   });
}
</script>	
															<tr id="my_data_tr_<?=$counter?>">
																<td><b>Name:</b> <?=$EmployeeName?><br><b>EmpCode:</b> <?=$EmployeeCode?></td>
																<td><?=$DateOfAttendance?></td>
																<!--<td><a class="btn btn-xs btn-primary" href="ManageAttendance.php?action=Checkin()">Check In</a>
																</td>-->
																<td>
																<?php
															    $seldataqddtZXC=select("count(*)","tblEmployeeWeekOff","EID='".$EID."' and  Date('".$TodaysDate."') between Date(WeekOffStartDate) and Date(WeekOffEndDate)");
	                                                            $cnttt=$seldataqddtZXC[0]['count(*)'];
																
																if($cnttt>0)
																{
																	 $seldataqty=select("*","tblEmployeeWeekOff","EID='".$EID."' and  Date('".$TodaysDate."') between Date(WeekOffStartDate) and Date(WeekOffEndDate)");
																	 $WeekOffStartDate=$seldataqty[0]['WeekOffStartDate'];
																	 $WeekOffEndDate=$seldataqty[0]['WeekOffEndDate'];
																	 
																	 
																	 if($LoginTime=="00:00:00")
																		{
																			
?>
																			<div align="center" id="Checkin">
																			<button class="btn btn-xs btn-primary result_message<?=$strERID?>"  value="Checkin" id="Checkin" name="Checkin" onclick="Checkin(<?=$strERID?>);">Checkin</button>&nbsp;&nbsp;(&nbsp;&nbsp;<b>On Leave  From</b> - <?=$WeekOffStartDate?> <b>To</b> - <?=$WeekOffEndDate?>)										
																			</div>
<?php																				
																			
																		}
																		else if($LogoutTime=="00:00:00" && $LoginTime != "00:00:00")
																		{
																			
?>
																				<div align="center"  id="CheckOut<?=$strERID?>"> <a class=" btn btn-xs btn-primary  result_message1<?=$strERID?>" value="CheckOut" id="CheckOut" name="CheckOut" onclick="CheckOut(<?=$strERID?>);" >CheckOut</a>&nbsp;&nbsp;(&nbsp;&nbsp;<b>On Leave  From</b> - <?=$WeekOffStartDate?> <b>To</b> - <?=$WeekOffEndDate?>)						
																				</div>
		
																	<?
																		}
																		elseif($LogoutTime != "00:00:00")
																		{
																			
																	?>
																			<div align="center">
																	<?				
																				$timesql="Select TIMEDIFF(LogoutTime,LoginTime) as Hour1 from tblEmployeesRecords Where ERID = $strERID";
																				$RS1 = $DB->query($timesql);
																				if ($RS1->num_rows > 0) 
																				{
																					$row1 = $RS1->fetch_assoc();
																					$TotalTime = $row1['Hour1'];
																					echo "Today " .$EmployeeName. " has completed " .$TotalTime. " Hours. ( <b>On Leave  From</b> - ".$WeekOffStartDate." <b>To</b> - ".$WeekOffEndDate.")";
																				}
																				else
																				{
																					echo "Not in here! :P";
																				}
																	?>
																			</div>
																	<?
																		}
																	 
																	
																}
																else
																{
																	if($LoginTime=="00:00:00")
																		{
																			
?>
																				<div align="center" id="Checkin">
																				<button class="btn btn-xs btn-primary result_message<?=$strERID?>"  value="Checkin" id="Checkin" name="Checkin" onclick="Checkin(<?=$strERID?>);">Checkin</button>
																				</div>
<?php																				
																			
																		}
																		else if($LogoutTime=="00:00:00" && $LoginTime != "00:00:00")
																		{
																			
?>
																				<div align="center"  id="CheckOut<?=$strERID?>"> <a class=" btn btn-xs btn-primary  result_message1<?=$strERID?>" value="CheckOut" id="CheckOut" name="CheckOut" onclick="CheckOut(<?=$strERID?>);" >CheckOut</a></div>
		
																	<?
																		}
																		elseif($LogoutTime != "00:00:00")
																		{
																			
																	?>
																			<div align="center">
																	<?				
																				$timesql="Select TIMEDIFF(LogoutTime,LoginTime) as Hour1 from tblEmployeesRecords Where ERID = $strERID";
																				$RS1 = $DB->query($timesql);
																				if ($RS1->num_rows > 0) 
																				{
																					$row1 = $RS1->fetch_assoc();
																					$TotalTime = $row1['Hour1'];
																					echo "Today " .$EmployeeName. " has completed " .$TotalTime. " Hours.";
																				}
																				else
																				{
																					echo "Not in here! :P";
																				}
																	?>
																			</div>
																	<?
																		}
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
															</tr>
														
<?php
}
$DB->close();
?>
														
														</tbody>
													</table>
												</div>
											</div>
											
											
											<!--Calender Display Start-->
											
											
											
											<!--Calender Display End-->
											
											
											
										</div>
<!--End Manage Tab Start ADD Tab-->										
										
										
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
							<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email','', '.imageupload'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

								
									<h3 class="title-hero">Edit Employee Details</h3>
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
		$EmployeeName=$row["EmployeeName"];
		$StoreID=$row["StoreID"];
		$EmployeeAddress=$row["EmployeeAddress"];
		$EmployeePincode=$row["EmployeePincode"];
		$EmployeeEmailID=$row["EmployeeEmailID"];
		$EmployeeMobileNo=$row["EmployeeMobileNo"];
		$Status=$row["Status"];

		foreach($row as $key => $val)
		{
			if($key==$strMyTableID)
			{
?>
											<input type="hidden" name="<?=$key?>" value="<?=Encode($strID)?>">	

<?php
			}
			elseif($key=="EmployeeCode")
			{
?>	
										
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeCode", "Employee Code", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input class="form-control" value="<?=$row[$key]?>" readonly></div>
											</div>

<?php
			}
			elseif($key=="StoreID")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreID", "Store Name", $key)?> <span>*</span></label>
												<div class="col-sm-3">
													<select name="<?=$key?>" class="form-control required">
														<option value="0" Selected>--Select Store--</option>
												<?php		$sql2 = "SELECT StoreName, StoreID FROM tblStores";
															$Res2 = $DB->query($sql2);
															if ($Res2->num_rows > 0) 
															{
																while($row = $Res2->fetch_assoc())
																{
																	$varStoreID = $row['StoreID'];
																	$varStoreName = $row['StoreName'];
																	if($varStoreID == $StoreID)
																	{
																	?>
																		<option value="<?=$varStoreID?>" selected><?=$varStoreName?></option>
															<?		}
																	else
																	{
																	?>
																		<option value="<?=$varStoreID?>"><?=$varStoreName?></option>
															<?		}
																}
															}
													?>						
													</select>
												</div>
											</div>
<?php
			}
			elseif($key=="EmployeeName")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeName", "Full Name", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("EmployeeName", "Full Name", $key)?>" value="<?=$EmployeeName?>"></div>
											</div>
<?php
			}
			elseif($key=="EmployeeAddress")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeAddress", "Address", $key)?> <span>*</span></label>
												<div class="col-sm-3"><textarea name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("EmployeeAddress", "Address", $key)?>"><?=$EmployeeAddress?></textarea></div>
											</div>
<?php
			}
			elseif($key=="EmployeePincode")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeePincode", "Pincode", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("EmployeePincode", "Pincode", $key)?>" value="<?=$EmployeePincode?>"></div>
											</div>
<?php
			}
			elseif($key=="EmployeeEmailID")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeEmailID", "Email ID", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input type="email" name="<?=$key?>" class="form-control admin_email required" placeholder="<?=str_replace("EmployeeEmailID", "Email ID", $key)?>" value="<?=$EmployeeEmailID?>"></div>
											</div>
<?php
			}
			elseif($key=="EmployeeMobileNo")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeMobileNo", "Mobile No", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input type="tel" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("EmployeeMobileNo", "Mobile No", $key)?>" value="<?=$EmployeeMobileNo?>" pattern="[0-9]{10}" title="Mobile Number should be of only 10 digits."></div>
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

											<?php
												$sql = "select ImagePath , EID FROM tblEmployeesImages where EID = '$strID'";
												$RS2 = $DB->query($sql);
												if ($RS2->num_rows > 0) 
												{
													while($row2 = $RS2->fetch_assoc())
													{
														$strImagePath = $row2["ImagePath"];
														
												?>		

													<div class="form-group">
														<label class="col-sm-3 control-label">Employee Image</label>
														<div class="col-sm-4"><img src="<?=$strImagePath?>" alt="<?=$strImagePath?>" width="100px"/>
														<hr>
															<input class="imageupload" type="file" data-source="ImagePath" name="ImagePath" id="fileSelect">
															Click to change the Employee Image
														</div>
													</div>
												<?php
													}
												}
												else
												{
												?>	
													<div class="form-group">
														<label class="col-sm-3 control-label">Employee Image<span>*</span>
														</label>
														<div class="col-sm-3">
															<input class="imageupload" type="file" data-source="ImagePath" name="ImagePath" id="fileSelect">
														</div>
													</div>
												<?php
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