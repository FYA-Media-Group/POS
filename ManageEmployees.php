<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Employee Management | Nailspa";
	$strDisplayTitle = "Manage Employee Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblEmployees";
	$strMyTableID = "EID";
	$strMyField = "EmployeeCode";
	$strMyActionPage = "ManageEmployees.php";
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
		$strCategories = $_POST["CatID"];
			
			for($p=0;$p<count($strCategories);$p++)
			{
				$seldata=select("ServiceID","tblProductsServices","CategoryID='".$strCategories[$p]."'");
				foreach($seldata as $val)
				{
					$service[]=$val['ServiceID'];
				}
			}
			$ses=array_unique($service);
			//print_r($ses);
			for($i=0;$i<count($ses);$i++)
			{
				//echo $ses[$i];
				$seldata=select("*","tblServices","ServiceID='".$ses[$i]."'");
				//print_r($seldata);
				foreach($seldata as $vay)
				{
					$cost=$vay['ServiceCost'];
					$totalcostt=$totalcostt+$cost;
				}
			}
			//	exit;
	
		$strStep = Filter($_POST["step"]);
		if($strStep=="add")
		{	
	
			$strEmployeeCode = Filter($_POST["EmployeeCode"]);
			$strEmployeeCode = strtoupper($strEmployeeCode);
			$strStoreID = Filter($_POST["StoreID"]);
			$strEmployeeName = Filter($_POST["EmployeeName"]);				
			$strEmployeeAddress = Filter($_POST["EmployeeAddress"]);
			$strEmployeePincode = Filter($_POST["EmployeePincode"]);
			$strEmployeeEmailID = Filter($_POST["EmployeeEmailID"]);
			$strEmployeeMobileNo = Filter($_POST["EmployeeMobileNo"]);
			$strJoinDate = Filter($_POST["JoinDate"]);
			$strEMP_Commission = Filter($_POST["EMP_Commission"]);
			
			$strJoinDate = Filter($_POST["JoinDate"]);
			$date5 = new DateTime($strJoinDate);
			$JoiningDate = $date5->format('Y-m-d'); // 31-07-2012
			// echo $JoiningDate."<br>";
			// die();
			$EmpPercentage = Filter($_POST["EmpPercentage"]);
			$EmployeeTarget = Filter($_POST["EmployeeTarget"]);
			$strStatus= Filter($_POST["Status"]);
			$strMECID = $_POST["MECID"];
			// echo $EmployeeTarget."<br>";
			// die();
			//exit;
			$DB = Connect();
			$sql = "SELECT $strMyTableID FROM $strMyTable WHERE $strMyField='$_POST[$strMyField]' AND Status=0";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				
				$DB->close();
				die('<div class="alert alert-warning alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
						</button>
						<strong>The Employee Code already exists in the system.</strong>
					</div>');
				
			
				
			}
			else
			{
			
				$totalcommission=$totalcostt*$EmpPercentage/100;
				$sqlInsert = "Insert into $strMyTable (EmployeeCode, StoreID, EmployeeName, EmployeeAddress, EmployeePincode, EmployeeEmailID, EmployeeMobileNo,EMP_Commission, MECID, Status,JoinDate,EmpPercentage,Target) values
				('".$strEmployeeCode."','".$strStoreID."', '".$strEmployeeName."', '".$strEmployeeAddress."', '".$strEmployeePincode."', '".$strEmployeeEmailID."', '".$strEmployeeMobileNo."',  '".$totalcommission."','".$strMECID."','".$strStatus."','".$JoiningDate."','".$EmpPercentage."','".$EmployeeTarget."')";
			
				$date=date('y-m-d');
				$sqlInsertEmployeeRecord = "Insert into tblEmployeesRecords (EmployeeCode, DateOfAttendance, Status) values
				('".$strEmployeeCode."','".$date."', '0')";
				ExecuteNQ($sqlInsertEmployeeRecord);
				
				
				if ($DB->query($sqlInsert) === TRUE) 
				{
					$last_id = $DB->insert_id;
				}
				else
				{
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
				foreach($strCategories as $categ)
				{
					$InsertCategory="Insert into tblEmployeesServices (EID,CategoryID,MECID) values ('".$last_id."', '".$categ."', '".$strMECID."')";
					// echo $InsertCategory;
					ExecuteNQ($InsertCategory);
					// $getServices=explode(',','$categ');
					// echo $getServices;
				}
				
				$month = date("F",strtotime($JoiningDate));
				$Year = date("Y",strtotime($JoiningDate));
				// echo $month."<br>";
				
				
				$Month1 = date('m');			//$row["Month"];
				$MonthSpell = getMonthSpelling($Month1);
				$InsertforTarget="Insert into tblEmployeeTarget(EmployeeCode,TargetForMonth,BaseTarget,Year) values('".$strEmployeeCode."','".$MonthSpell."','".$EmployeeTarget."','".$Year."')";
				// echo $InsertforTarget."<br>";
				
				
				// $weeks=ceil( date( 'j', strtotime( $month ) ) / 7 ); 
				// echo $weeks."<br>";
				ExecuteNQ($InsertforTarget);
				// die();
				
				$sql1 = "INSERT INTO tblEmployeesImages (ImagePath, EID, Status) VALUES ('$strImageUploadPath1','$last_id', '0')";
				
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
			$EID=Decode($_POST[$strMyTableID]);
			
			// $strCategories=$_POST["CatID"];
			$EmployeeCode1 = Filter($_POST["EmployeeCode"]);
			// echo $EmployeeCode1."<br>";
			$EmployeeCode = strtoupper($EmployeeCode1);
			// echo $EmployeeCode."<br>";
			$StoreID = Filter($_POST["StoreID"]);
			$EmployeeName = Filter($_POST["EmployeeName"]);
			// echo $EmployeeName."<br>";
			$EmployeePincode = Filter($_POST["EmployeePincode"]);
			$EmployeeAddress = Filter($_POST["EmployeeAddress"]);
			$EmployeeEmailID = Filter($_POST["EmployeeEmailID"]);
			$EmployeeMobileNo = Filter($_POST["EmployeeMobileNo"]);
			$EMP_Commission = Filter($_POST["EMP_Commission"]);
			$EmpPercentage = Filter($_POST["EmpPercentage"]);
			$ImagePath = Filter($_POST["ImagePath"]);
			$Target = Filter($_POST["Target"]);
			// echo $EmployeeTarget;
			$MECID = $_POST["MECID"];
			//added by asmita
			// echo $MECID1."<br>";
			// die();
			//added by asmita
			
			
			// echo $EID."<br>";
			
			// echo $MECID."<br>";
			$Status = Filter($_POST["Status"]);
			// $totalcost=0;
			// foreach($MECID1 as $type)
			// {
				
				// $MECID=implode(',',$MECID1);
				// $seldata=select("*","tblServices","ServiceID='".$type."'");
				// $cost=$seldata[0]['ServiceCost'];
				// $totalcost=$totalcost+$cost;
			// }
			
			
			$DeleteCat="Delete from tblEmployeesServices where EID=$EID";
			ExecuteNQ($DeleteCat);
			// echo $DeleteCat."<br>";
			foreach($strCategories as $categ)
			{
				$InsertCategory="Insert into tblEmployeesServices (EID,CategoryID,MECID) values ('".$EID."', '".$categ."', '".$MECID."')";
				// echo $InsertCategory;
				ExecuteNQ($InsertCategory);
				// $getServices=explode(',','$categ');
				// echo $getServices;
			}
			// die();
			
			
			// die();
			
			// if(isset($_FILES["ImagePath"]["error"]))
			// {
				// $strValidateImage1 = trim(ValidateImageFile($_FILES, "ImagePath"));
				// if($strValidateImage1=="Saved successfully")
				// {
				
					// As the image is valid first select the imagename for previous image
					
					// $DB = Connect();
					// $sql = "SELECT ImagePath, EID FROM tblEmployeesImages WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."' ";
					
					// $RS = $DB->query($sql);
					// if ($RS->num_rows > 0) 
					// {
						// while($row = $RS->fetch_assoc())
						// {
							// $strOldImageURL = $row["ImagePath"];	
							// $strEID = $row["EID"];
						// }
						
						// $file = $strOldImageURL;
						// unlink($file);
						
						// $filepath = 'imageupload/images';
						// $filename1 = $_FILES["ImagePath"]["name"];
						
						// $uploadFilename1 = UniqueStamp().$filename1;		
						// $strImageUploadPath1 = $filepath."/".$uploadFilename1;
						#######################
						
							
						
						// $sqlUpdate = "UPDATE tblEmployeesImages SET ImagePath='".$strImageUploadPath1."' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."' ";
						// ExecuteNQ($sqlUpdate);
							
						
						// echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
								// <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								// </button>
								// <strong>Employee Image Updated Successfully</strong>
								// </div>');						
					// }
					// else
					// {
						// $filepath = 'imageupload/images';
						// for First Image
						// $filename1 = $_FILES["ImagePath"]["name"];
						
						// $uploadFilename1 = UniqueStamp().$filename1;		
						// $strImageUploadPath1 = $filepath."/".$uploadFilename1;
						#######################
						
						// $sql1 = "Insert into tblEmployeesImages (ImagePath, EID, Status) Values ('$strImageUploadPath1','$strEID', '0')";
						// ExecuteNQ($sql1);
						
						// echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
							// <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
							// </button>
							// <strong>Employee Image Added Successfully</strong>
							// <p>Image saved!</p>
							// </div>');
					// }					
					
				// }
				// else
				// {
					// die($strValidateImage1);
				
				
				 $totalcommission=$totalcost*$EmpPercentage/100;
				
				foreach($_POST as $key => $val)
				{
					if($key=="step" || $key==$strMyTableID ||  $key=="ImagePath" )
					{
					
					}
					else
					{
						$sqlUpdate = "UPDATE $strMyTable SET $key='$_POST[$key]' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
						ExecuteNQ($sqlUpdate);
						// echo $sqlUpdate."<br>";
					}	
				}
						$sqlUpdate2 = "UPDATE tblEmployeeTarget SET BaseTarget='$Target' WHERE EmployeeCode='$EmployeeCode'";
						// echo $sqlUpdate1."<br>";
						ExecuteNQ($sqlUpdate2);
				
				$sqlUpdate1 = "update $strMyTable SET MECID='".$MECID."',EmpPercentage='".$EmpPercentage."',EMP_Commission='".$totalcommission."' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
				ExecuteNQ($sqlUpdate1);
				// echo $sqlUpdate1."<br>";
				
				die('<div class="alert alert-close alert-success">
						<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
						<div class="alert-content">
							<h4 class="alert-title">Details Updated</h4>
							<p>Record Successfully Updated</p>
						</div>
					</div>');
			// }			
		}
		
		if($strStep=="transfer")
		{
			$strEID = Decode($_POST[$strMyTableID]);
			$strEmployeeCode = Filter($_POST["EmployeeCode"]);
			$strEmployeeCode = strtoupper($strEmployeeCode);
			$strStoreID = Filter($_POST["StoreID"]);
			$strEmployeeName = Filter($_POST["EmployeeName"]);				
			$strEmployeeAddress = Filter($_POST["EmployeeAddress"]);
			$strEmployeePincode = Filter($_POST["EmployeePincode"]);
			$strEmployeeEmailID = Filter($_POST["EmployeeEmailID"]);
			$strEmployeeMobileNo = Filter($_POST["EmployeeMobileNo"]);
			$strEMP_Commission = Filter($_POST["EMP_Commission"]);
			
			$strJoinDate = Filter($_POST["JoinDate"]);
			$strTransferDate = Filter($_POST["TransferDate"]);
			$strTransferedTo = Filter($_POST["TransferedTo"]);
			
			$strMECID = Filter($_POST["MECID"]);
			// echo $strMECID;
			// die();
			$Status = Filter($_POST["Status"]);
			
			$DB = Connect();
			
			$sql = "SELECT $strMyTableID FROM $strMyTable WHERE $strMyField='$_POST[$strMyField]' AND Status=0";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 1) 
			{
				$DB->close();
				die('<div class="alert alert-warning alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
						</button>
						<strong>The Employee Code already exists in the system.</strong>
					</div>');
			}
			else
			{
				$sqlTransfer1 = "UPDATE tblEmployees SET TransferDate=CURDATE(), TransferedFrom=$strStoreID,StoreID=$strTransferedTo WHERE EID=$strEID";
				ExecuteNQ($sqlTransfer1);		// Old Record Updated for transfer date and transfered store name
			
			$sqlTransferInsert = "INSERT INTO tblEmployeeTransferLog(EID, TransferDate,TransferStoreID) values
				('".$strEID."', CURDATE(), '".$strTransferedTo."')";
				if ($DB->query($sqlTransferInsert) === TRUE) 
				{
					
				}
				else
				{
					echo "Error: " . $sqlTransferInsert . "<br>" . $conn->error;
				}
				/* $sqlTransfer1 = "UPDATE tblEmployees SET Status='1', TransferDate=CURDATE(), TransferedTo=$strTransferedTo WHERE EID=$strEID";
				ExecuteNQ($sqlTransfer1);		// Old Record Updated for transfer date and transfered store name
			
				$sqlImg = "SELECT * FROM tblEmployeesImages WHERE EID = $strEID";
				$ResultSet = $DB->query($sqlImg);
				$rowImg = $ResultSet->fetch_assoc();
				$ImgPath = $rowImg['ImagePath'];
				

				$sqlTransferInsert = "INSERT INTO $strMyTable (EmployeeCode, StoreID, EmployeeName, EmployeeAddress, EmployeePincode, EmployeeEmailID, EmployeeMobileNo, MECID,  Status) values
				('".$strEmployeeCode."', '".$strTransferedTo."', '".$strEmployeeName."', '".$strEmployeeAddress."', '".$strEmployeePincode."', '".$strEmployeeEmailID."', '".$strEmployeeMobileNo."', '".$strMECID."', '".$strStatus."')";
				// echo $sqlInsert;
				// die();				
				// ExecuteNQ($sqlInsert);
				
				if ($DB->query($sqlTransferInsert) === TRUE) 
				{
					$last_id = $DB->insert_id;
					$sqlTransferUpdate = "UPDATE tblEmployees SET JoinDate=CURDATE() WHERE EID = $last_id";
					ExecuteNQ($sqlTransferUpdate);
				}
				else
				{
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
				
				$sql1 = "INSERT INTO tblEmployeesImages (ImagePath, EID, Status) VALUES ('$ImgPath','$last_id', '0')";
				ExecuteNQ($sql1);
				
				$sql2 = "INSERT INTO tblEmployeesRecords(EmployeeCode, DateOfAttendance, Status) VALUES ('$strEmployeeCode', now(), '0')";
				ExecuteNQ($sql2); */

				$DB->close();
				
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
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
	
					<script>
						$(function ()						
						{
							$("#JoinDate1").datepicker();
							$("#JoinDate").datepicker();
							
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
                        <p>Add, Edit, Delete Employee Details</p>
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
												<h3 class="title-hero">List of Employees Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Name <br> Employee Code </th>
																<th>Store ID</th>
																<th>Address <br> Pincode</th>
																<th>Email ID <br>Mobile No</th>
																<th>Transfer Employee</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Name <br> Employee Code </th>
																<th>Store ID</th>
																<th>Address <br> Pincode</th>
																<th>Email ID <br>Mobile No</th>
																<th>Transfer Employee</th>
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
		$strEID = $row["EID"];
		$getUID = EncodeQ($strEID);
		$getUIDDelete = Encode($strEID);
		$EmployeeCode = $row["EmployeeCode"];
		$StoreID = $row["StoreID"];
		$EmployeeName = $row["EmployeeName"];
		$EmployeeAddress = $row["EmployeeAddress"];
		$EmployeePincode = $row["EmployeePincode"];
		$EmployeeEmailID = $row["EmployeeEmailID"];
		$EmployeeMobileNo = $row["EmployeeMobileNo"];
		$EMP_Commission = $row["EMP_Commission"];
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
																<td><b>Name:</b> <?=$EmployeeName?> <br><b>Code:</b> <?=$EmployeeCode?></td>
																<?php
																$sql_store = "SELECT * FROM tblStores WHERE StoreID = '".$StoreID."'";
																$RS_store = $DB->query($sql_store);
																$row_store = $RS_store->fetch_assoc();
																$StoreName = $row_store['StoreName'];
																?>
																<td><b>Store:</b> <?=$StoreName?></td>
																<td><b>Address: </b><?=$EmployeeAddress?> <br><b>Pincode: </b><?=$EmployeePincode?> </td>
																<td><b>Email ID:</b> <?=$EmployeeEmailID?><br><b>Mobile No:</b> <?=$EmployeeMobileNo?> </td>
																<td><!--<b>Status : </b>--><?//=$Status?>
																	<a class="btn btn-link" href="ManageEmployees.php?tid=<?=$getUID?>">Transfer</a>
																	<a class="btn btn-link" href="ManageEmployees.php?rid=<?=$getUID?>">Resign</a>
																</td>
																<td>
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																			<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step9','<?=$getUIDDelete?>', 'Are you sure you want to delete this Employee - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
																	<?php
																	}
																	?>
																	
																	<br>
																		
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

											
												<h3 class="title-hero">Add Employees</h3>
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
			
		else if ($row["Field"]=="EmployeeCode")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeCode", "Employee Code", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("EmployeeCode", "Employee Code", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("EmployeeCode", "Employee Code", $row["Field"])?>"></div>
														</div>	
<?			
		}
		else if ($row["Field"]=="EmpPercentage")
		{
				// echo "test";
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmpPercentage", "Employee Commission", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("EmpPercentage", "Employee Commission", $row["Field"])?>" class="form-control" placeholder="<?=str_replace("EmpPercentage", "Employee Commission", $row["Field"])?>"></div>
														</div>	
														<div class="form-group">
															<label class="col-sm-3 control-label">Employee Target<span>*</span></label>
																<div class="col-sm-4">
																	<input type="text" name="EmployeeTarget" id="EmployeeTarget" class="form-control" placeholder="Employee Target">
																</div>
														</div>														
<?php
		}
		else if ($row["Field"]=="EMP_Commission")
		{
				// echo "test";
?>
																										
<?php
		}
		else if ($row["Field"]=="StoreID")
		{
			$sql1 = "select * FROM tblStores";
			$RS2 = $DB->query($sql1);
			if ($RS2->num_rows > 0)
			{
?>											
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreID", "Store Name", $row["Field"])?> <span>*</span></label>
												<div class="col-sm-3">
													<select class="form-control required"  name="<?=$row["Field"]?>">
															<option value="" selected>--Select Store--</option>
<?
													while($row2 = $RS2->fetch_assoc())
													{
														$strStoreName = $row2["StoreName"];
														$strStoreID = $row2["StoreID"];
?>
														<option value="<?=$strStoreID?>" ><?=$strStoreName?></option>														
<?php
													}
?>
														</select>
<?php
			}
			else
			{
				echo "Admin Roles are not added. <a href='ManageAdminRoles.php' class='btn btn-link' target='Admin Role'>Click here to Add Admin Roles</a>";
			}
?>
												</div>
											</div>	
<?php
		}
		else if ($row["Field"]=="MECID")
		{
			$sql1 = "select * FROM tblMasterEmployeeCategory where Status='0'";
			$RS2 = $DB->query($sql1);
			if ($RS2->num_rows > 0)
			{
?>											
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("MECID", "Employee Category", $row["Field"])?> <span>*</span></label>
												<div class="col-sm-3">
													<select class="form-control required"  name="<?=$row["Field"]?>" >
														<option value="" selected>--Select Employee Category--</option>
<?
															while($row2 = $RS2->fetch_assoc())
															{
																$strMECID = $row2["MECID"];
																$strCategoryName= $row2["CategoryName"];
?>
																<option value="<?=$strMECID?>" ><?=$strCategoryName?></option>
<?php
															}
?>
													</select>
<?php
			}
			else
			{
				echo "Employee Categories are not added.<a href='ManageMasterEmployeeCategory.php' class='btn btn-link' target='Employee Categories'>Click here to Add </a>";
			}
?>
												</div>
											</div>	
<?php
		}
		else if ($row["Field"]=="EmployeeName")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeName", "Full Name", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="text" style="text-transform:capitalize" name="<?=$row["Field"]?>" id="<?=str_replace("EmployeeName", "Full Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("EmployeeName", "Full Name", $row["Field"])?>"></div>
														</div>	
<?php
		}
		else if ($row["Field"]=="EmployeeAddress")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeAddress", "Address", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-5" ><textarea rows="05" style="text-transform:capitalize" name="<?=$row["Field"]?>" id="<?=str_replace("EmployeeAddress", "Address", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("EmployeeAddress", "Address", $row["Field"])?>"></textarea></div>
														</div>														
<?php
		}
		else if ($row["Field"]=="EmployeePincode")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeePincode", "Pincode", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="text" name="<?=$row["Field"]?>"  id="<?=str_replace("EmployeePincode", "Pincode", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("EmployeePincode", "Pincode", $row["Field"])?>"></div>
														</div>														
<?php
		}
		else if ($row["Field"]=="EmployeeEmailID")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeEmailID", "Email ID", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="email" name="<?=$row["Field"]?>" id="<?=str_replace("EmployeeEmailID", "Email ID", $row["Field"])?>" class="form-control admin_email required" placeholder="<?=str_replace("EmployeeEmailID", "Email ID", $row["Field"])?>"></div>
														</div>														
<?php
		}
		else if ($row["Field"]=="EmployeeMobileNo")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeMobileNo", "Mobile No", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="tel" name="<?=$row["Field"]?>" id="<?=str_replace("EmployeeMobileNo", "Mobile No", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("EmployeeMobileNo", "Mobile No", $row["Field"])?>" pattern="[0-9]{10}" title="Mobile Number should be of only 10 digits."></div>
														</div>														
<?php
		}
		else if ($row["Field"]=="Status")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Status", "Status", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3">
																<select name="<?=$row["Field"]?>" class="form-control required">
																	<option value="0" Selected>Live</option>
																	<option value="1">Offline</option>	
																</select>
															</div>
														</div>
<?php	
		}
		else if ($row["Field"]=="JoinDate")
		{
?>
														<div class="form-group">
															<label class="col-sm-3 control-label"><?=str_replace("JoinDate", "Join Date", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4">
																 <!--<div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span> <input type="text" name="JoinDate" id="JoinDate"  class="form-control" data-date-format="yy/mm/dd" value="<?php //echo date('y-m-d');?>"></div>-->
															<div class="input-prepend input-group">
															<input type="text" name="JoinDate" id="JoinDate"  class="form-control" data-date-format="dd/mm/yy"  value="<?php echo date('y-m-d');?>">
															</div>
															</div>
														</div>														
<?php
		}
		elseif(($row["Field"]!="LeaveDate") || ($row["Field"]!="TransferDate") || ($row["Field"]!="TransferedTo"))
		{
			
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
														
														<!--<div class="form-group"><label class="col-sm-3 control-label">Image Path<span>*</span></label>
															<div class="col-sm-4">
																<input type="file" class="form-control imageupload required" data-source="ImagePath">
															</div>
														</div>-->
														
<!--//Service category addtion start by asmita-->
<?
														$sql3 = "select * FROM tblCategories where Status='0' and MainCategoryType='0'";
														$RS3 = $DB->query($sql3);
														if ($RS3->num_rows > 0)
														{
?>											
															<div class="form-group"><label class="col-sm-3 control-label">Service Categories<span>*</span></label>
																<div class="col-sm-3">
																	<select class="form-control"  name="CatID[]" id="CatID[]" multiple style="height:100pt">
																		<option value="" selected>--Select Service Category--</option>
<?
																			while($row3 = $RS3->fetch_assoc())
																			{
																				$strCategoryID = $row3["CategoryID"];
																				$strCategoryName= $row3["CategoryName"];
?>
																				<option value="<?=$strCategoryID?>" ><?=$strCategoryName?></option>
<?php
																			}
?>
																	</select>
<?php
														}
														else
														{
															echo "Service Categories are not added.<a href='ManageCategories.php' class='btn btn-link' target='Service Categories'>Click here to Add </a>";
														}
?>
																</div>
															</div>	
<!--//Service category addition end by asmita-->												
														
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

								
									<h3 class="title-hero">Edit Employee Details</h3>
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
		// echo $strID;
		$EmployeeName=$row["EmployeeName"];
		$StoreID=$row["StoreID"];
		$EmployeeAddress=$row["EmployeeAddress"];
		$EmployeeCode=$row["EmployeeCode"];
		$EmployeePincode=$row["EmployeePincode"];
		$EmployeeEmailID=$row["EmployeeEmailID"];
		$EmployeeMobileNo=$row["EmployeeMobileNo"];
		$EMP_Commission=$row["EmpPercentage"];
		$Target=$row["Target"];
		// echo $StoreID;
		$JoinDate=$row["JoinDate"];
		$MECID=$row["MECID"];
		
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
												<div class="col-sm-4"><input name="EmployeeCode" class="form-control" value="<?=$EmployeeCode?>" readonly></div>
											</div>
<?php
			}
			elseif($key=="EmpPercentage")
			{
					
?>	
										
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmpPercentage", "Employee Commission", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("EmpPercentage", "Employee Commission", $key)?>" value="<?=$EMP_Commission?>"></div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label">Employee Target<span>*</span></label>
													<div class="col-sm-3">
														<input type="text" name="Target" class="form-control required" placeholder="EmployeeTarget" value="<?=$Target?>">
													</div>
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
			elseif($key=="MECID")
			{
					$DBvalue=$MECID;
					// echo $DBvalue;
?>	
					<div class="form-group">
							<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("MECID", "Employee Category", $key)?> <span>*</span></label>
								<div class="col-sm-4">	
									

									<?php
										// echo $DBvalue;
										$sql = "SELECT 	MECID, CategoryName FROM tblMasterEmployeeCategory";
										$RS2 = $DB->query($sql);
										if ($RS2->num_rows > 0)
										{
									?>

											<select class="form-control required" name="<?=$key?>">
												<?
													while($row2 = $RS2->fetch_assoc())
													{
														$MECID = $row2["MECID"];
														$CategoryName = $row2["CategoryName"];
														if($MECID==$DBvalue)
														{	
												?>

															<option selected value="<?=$MECID?>" ><?=$CategoryName?></option>	
												<?php
														}
														else
														{
												?>

															<option value="<?=$MECID?>"><?=$CategoryName?></option>	
												<?php
														}
													}
												?>
											</select>
									<?php
										}
										else
										{
											echo "Employee Categories are not added <a href='ManageMasterEmployeeCategory.php' target='Add Categories'>Click here to add</a>";
										}
								?>
								</div>
					</div>
	

<?
																	
														
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
												<div class="col-sm-3">
													<input type="text" name="<?=$key?>" style="text-transform:capitalize" class="form-control required" placeholder="<?=str_replace("EmployeeName", "Full Name", $key)?>" value="<?=$EmployeeName?>">
												</div>
											</div>
<?php
			}
			elseif($key=="EmployeeAddress")
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeAddress", "Address", $key)?> <span>*</span></label>
												<div class="col-sm-3"><textarea name="<?=$key?>" style="text-transform:capitalize" class="form-control required" placeholder="<?=str_replace("EmployeeAddress", "Address", $key)?>"><?=$EmployeeAddress?></textarea></div>
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
			elseif($key=="JoinDate")
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("JoinDate", "Join Date", $key)?> <span>*</span></label>
												<div class="col-sm-4">
													<!--<input type="date" readonly name="<?//=$key?>" class="form-control required" placeholder="<?//=str_replace("JoinDate", "Join Date", $key)?>" value="<?//=$JoinDate?>">-->
													<div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span> <input type="text"  readonly name="JoinDate1" id=""  class="form-control" data-date-format="yy/mm/dd" value="<?=$JoinDate?>" ></div>
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
			elseif(($key!="LeaveDate") || ($key!="TransferDate") || ($key!="TransferedTo"))
			{
				
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




											<div class="form-group"><label class="col-sm-3 control-label">Service Categories<span>*</span></label>
												<div class="col-sm-4">
<?												
												// $SelectedCat="Select CategoryID, EID from tblEmployeesServices where EID='$strID'";
												// echo $SelectedCat."<br>";
																// $RS5=$DB->query($SelectedCat);
																// if ($RS5->num_rows > 0)
																// {
																	// while($row5 = $RS5->fetch_assoc())
																	// {
																		// $strrCategoryID = $row5["CategoryID"];
																		// $selected=implode(",",$strrCategoryID);
																		// echo $selected;
																		// echo $strrCategoryID."<br>";
																	// }
																// }
																
															$selp=select("distinct(CategoryID),EID","tblEmployeesServices","EID='$strID'");
																													
																foreach($selp as $valp)
																{
																	$cat=array_unique($valp);
																	$catid[]=$cat['CategoryID'];
																}	
?>																
													<select name="CatID[]" class="form-control" multiple style="height:80pt"  id="StoreID">
														<option ><b>Select Categories</b></option>
														<?php 
															
															$sql_display = "SELECT * FROM tblCategories where MainCategoryType='0'";
															$RS_display = $DB->query($sql_display);
															if ($RS_display->num_rows > 0) 
															{
																while($row_display = $RS_display->fetch_assoc())
																{
																	$CategoryID = $row_display["CategoryID"];
																	$CategoryName = $row_display["CategoryName"];
																	if (in_array("$CategoryID", $catid))
																	{
																	?>
																		<option selected value="<?=$CategoryID?>"><?=$CategoryName?><?=$CategoryID?></option>
																	<?
																	}
																	else
																	{
																	?>
																		<option value="<?=$CategoryID?>"><?=$CategoryName?><?=$CategoryID?></option>
																	<?
																	}
																}
															}
														?>
													</select>
												</div>
											</div>




															
														
														
														

																	
<!--//Service category addition end by asmita-->	
	
											
											<div class="form-group"><label class="col-sm-3 control-label"></label>
												<input type="submit" class="btn ra-100 btn-primary" value="Update">
												
												<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
											</div>
<?php
}
}
elseif(isset($_GET['tid']))
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
								<input type="hidden" name="step" value="transfer">

								
									<h3 class="title-hero">Transfer Employee</h3>
									<div class="example-box-wrapper">
										
<?php
$strID = DecodeQ(Filter($_GET["tid"]));
$DB = Connect();
$sqlColumns = "SHOW COLUMNS FROM ".$strMyTable." ";
$RSColumns = $DB->query($sqlColumns);
$rowColumns = $RSColumns->fetch_assoc();



$sql = "SELECT * FROM $strMyTable WHERE $strMyTableID = '$strID'";
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
		$JoinDate=$row["JoinDate"];
		$TransferedTo = $row["TransferedTo"];
		$abcMECID=$row["MECID"];
		
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
												<div class="col-sm-4"><input readonly name="<?=$key?>" class="form-control" value="<?=$row[$key]?>"></div>
											</div>

<?php
			}
			elseif($key=="MECID")
			{
				// echo $abcMECID."<br>";
				$i=explode(",",$abcMECID);
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("MECID", "MECID", $key)?> <span>*</span></label>
												<div class="col-sm-3">
													<input type="hidden" name="<?=$key?>" value="<?=$abcMECID?>">
<?														
															$asmita ="";
															for($x=0; $x<count($i); $x++) 
															{
																$asmita .= " and MECID !='".$i[$x]."'";
																$sql2 = "SELECT * FROM tblMasterEmployeeCategory WHERE MECID='".$i[$x]."' ORDER BY MECID DESC ";
																$Res3 = $DB->query($sql2);
																if ($Res3->num_rows > 0) 
																{
																	while($rowset1 = $Res3->fetch_assoc())
																	{
																		 $strNameofCategory = $rowset1['CategoryName'];
																		  $strMECID = $rowset1['MECID'];
?>
													<input type="" readonly name="" class="form-control required" placeholder="<?=str_replace("EmployeeName", "Full Name", $key)?>" value="<?=$strNameofCategory?>">
<?																	
																	}
																}
															}														
?>
												</div>
											</div>											
<?php
			}
			elseif($key=="EmployeeName")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeName", "Full Name", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input readonly name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("EmployeeName", "Full Name", $key)?>" value="<?=$EmployeeName?>"></div>
											</div>
<?php
			}
			elseif($key=="EmployeeEmailID")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeEmailID", "Email ID", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input readonly name="<?=$key?>" class="form-control admin_email required" placeholder="<?=str_replace("EmployeeEmailID", "Email ID", $key)?>" value="<?=$EmployeeEmailID?>"></div>
											</div>
<?php
			}
			elseif($key=="EmployeeMobileNo")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeMobileNo", "Mobile No", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input readonly name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("EmployeeMobileNo", "Mobile No", $key)?>" value="<?=$EmployeeMobileNo?>" pattern="[0-9]{10}" title="Mobile Number should be of only 10 digits."></div>
											</div>
<?php
			}
			elseif($key=="EmployeeAddress")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeAddress", "Address", $key)?> <span>*</span></label>
												<div class="col-sm-3"><textarea readonly name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("EmployeeAddress", "Address", $key)?>"><?=$EmployeeAddress?></textarea></div>
											</div>
<?php
			}
			elseif($key=="EmployeePincode")
			{
?>

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeePincode", "Pincode", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input readonly name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("EmployeePincode", "Pincode", $key)?>" value="<?=$EmployeePincode?>"></div>
											</div>
<?php
			}
			elseif($key=="StoreID")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreID", "Currently At", $key)?> <span>*</span></label>
												<div class="col-sm-3">
													<select readonly name="<?=$key?>" class="form-control required">
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
			elseif($key=="JoinDate")
			{
				
			}
			elseif($key=="TransferedTo")
			{	
				$DBvalue = $StoreID;
	?>	
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("TransferedTo", "Transfering to", $key)?> <span>*</span></label>
												<div class="col-sm-4">
<?php
													$sql = "SELECT StoreID, StoreName FROM tblStores WHERE Status=0";
													$RS2 = $DB->query($sql);
													if ($RS2->num_rows > 0)
													{
?>
														<select class="form-control required" name="<?=$key?>">
<?
															while($row2 = $RS2->fetch_assoc())
															{
																$StoreID2 = $row2["StoreID"];
																$StoreName = $row2["StoreName"];
																if($DBvalue == $StoreID2)
																{
																	
																}
																else
																{
?>
																	<option value="<?=$StoreID2?>"><?=$StoreName?></option>	
<?php
																}
															}
?>
														</select>
<?php
													}
													else
													{
														echo "Stores Not Added <a href='ManageStores.php' target='Manage Stores'>Click here to add</a>";
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
													<select readonly name="<?=$key?>" class="form-control required">
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
			elseif(($key!="LeaveDate") || ($key!="TransferDate"))
			{
				
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
												<input type="submit" class="btn ra-100 btn-primary" value="Transfer">
												
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
elseif(isset($_GET["rid"]))		// When an Employee resigns or leaves, the status will be set to 1 i.e. Offline.
{
	$DB = Connect();
	$strEID = Decode($_GET['rid']);
	// echo $strEID;
	// die();
	
	$sqlResign = "UPDATE tblEmployees SET LeaveDate = CURDATE(), Status = '1' WHERE EID = $strEID";
	if($DB->query($sqlResign) === TRUE)
	{
		?>
			<br>
			<div class="alert alert-close alert-success">
				<div class="bg-green alert-icon">
					<i class="glyph-icon icon-check"></i>
				</div>
				<div class="alert-content">
					<h4 class="alert-title">Employee has been resigned</h4>
					<p>Nailspa wishes you goodluck!</p>
				</div>
			</div>
			<br><br><br><br><br>
			<div class="fa-hover">	
				<center><a class="btn btn-primary btn-lg" href="ManageEmployees.php"><i class="fa fa-backward"></i> &nbsp; Go back to Employee Management</a></center>
			</div>
		<?
	}
	else
	{
		?>
			<br>
			<div class="alert alert-close alert-success">
				<div class="bg-green alert-icon">
					<i class="glyph-icon icon-check"></i>
				</div>
				<div class="alert-content">
					<h4 class="alert-title">Oh Crap! There is some problem</h4>
					<p>Please try again after sometime</p>
				</div>
			</div>
			<br><br><br><br><br>
			<div class="fa-hover">	
				<center><a class="btn btn-primary btn-lg" href="ManageEmployees.php"><i class="fa fa-backward"></i> &nbsp; Go back to Employee Management</a></center>
			</div>
		<?
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