<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "App Content Management | Nailspa";
	$strDisplayTitle = "Manage App Content Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblContentApproval";
	$strMyTableID = "ContentApprovalID";
	$strMyField = "";
	$strMyActionPage = "ManageAppContentApproval.php";
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
			
			
			$strHeading = Filter($_POST["Heading"]);
			$Content = Filter($_POST["Content"]);				
			$strContentReply = Filter($_POST["ContentReply"]);
	
			$DB = Connect();
			
			$InsertContent="Insert into tblContentApproval(Heading, Content, Type, Status) VALUES ('".$strHeading."','".$Content."','2','1')";
			//echo $InsertContent."<br>";
			$DB->query($InsertContent);		
			//exit;
					
			//	die();	
			die('<div class="alert alert-close alert-success">
				<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
				<div class="alert-content">
					<h4 class="alert-title">Admin Added</h4>
					<p>Record Added Successfully</p>
				</div>
			</div>');
			


		}

		if($strStep=="edit")
		{
			$DB = Connect();
					$strContentApprovalID = Decode($_POST[$ContentApprovalID]);
				
					$strHeading = Filter($_POST["Heading"]);
					$strContent = Filter($_POST["Content"]);				
					$strContentReply = Filter($_POST["ContentReply"]);
					$strStatus = Filter($_POST["Status"]);
					
					// echo $strContent."<br>";
					// echo $strHeading."<br>";
					
					// $sqlUpdate = "update $strMyTable set $key='$_POST[$key]' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					// ExecuteNQ($sqlUpdate);
					$UpdateContent = "UPDATE tblContentApproval SET Heading='$strHeading', Content='$strContent' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
				//	echo $UpdateContent."<br>";
					// die();
					// $RS = $DB->query($UpdateSMS);
					ExecuteNQ($UpdateContent);		
				
			
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
                        <p>Approval Status of SMS Content</p>
                    </div>
<?php
if((isset($_GET["sid"])))
{
	$GetUID=$_GET["sid"];
	$GetUIDDecode=DecodeQ($_GET["sid"]);
	$GetUIDEncode=EncodeQ($_GET["sid"]);
	$UpdateApprove="UPDATE tblContentApproval SET Status='2' WHERE ContentApprovalID='$GetUIDDecode'";
	// echo $UpdateApprove;
	ExecuteNQ($UpdateApprove);
	echo("<script>location.href='ManageAppContentApproval.php';</script>"); 
	
	
}
if((isset($_GET["rid"])))
{
	$GetUID=$_GET["rid"];
	$GetUIDDecode=DecodeQ($_GET["rid"]);
	$GetUIDEncode=EncodeQ($_GET["rid"]);
	$UpdateReject="UPDATE tblContentApproval SET Status='3' WHERE ContentApprovalID='$GetUIDDecode'";
	// echo $UpdateApprove;
	ExecuteNQ($UpdateReject);
	echo("<script>location.href='ManageAppContentApproval.php';</script>"); 
	
	
}

if(!isset($_GET["uid"]))
{
	$DB = Connect();
	$FindRoleID="Select AdminRoleID from tblAdmin where AdminID=$strAdminID";
		// echo $FindRoleID;
		$RSf = $DB->query($FindRoleID);
		if ($RSf->num_rows > 0) 
		{
			while($rowf = $RSf->fetch_assoc())
			{
				$strRoleID = $rowf["AdminRoleID"];
				// echo $strRoleID."<br>";
				// echo "Hello";
			}
		}

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
												<h3 class="title-hero">List of Web Content for Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Title</th>
																<th>Content</th>
																<th>Approval</th>
<?php
																if($strRoleID!='36')
																{
?>

																	<th>Actions</th>
<?php
																}
																else
																{
																	
																}
?>																	
																
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>SMS Event</th>
																<th>SMS Content</th>
																<th>Approval</th>
<?php
																if($strRoleID!='36')
																{
?>
																	<th>Actions</th>
<?php
																}
?>																																
																
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values

$sql = "SELECT * FROM $strMyTable where Type=2 order by $strMyTableID desc";

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strContentApprovalID = $row["ContentApprovalID"];
		// echo $strSMSApprovalID."<br>";
		$getUID = EncodeQ($strContentApprovalID);
		$getUIDDelete = Encode($strContentApprovalID);
		$Heading = $row["Heading"];
		$Content = $row["Content"];
		
		$Status = $row["Status"];
		
		
		
		// 1-Pending, 2-Approved, 3-Rejected, 4-Delivred
		if($Status=="1")
		{
			$Status = "Pending";
		}
		elseif($Status=="2")
		{
			$Status = "Approved";
		}
		elseif($Status=="3")
		{
			$Status = "Rejected";
		}
		elseif($Status=="4")
		{
			$Status = "Delivred";
		}
		
?>														
													<tr id="my_data_tr_<?=$counter?>">
																<td><b>Title : </b><br><?=$Heading?></td>
																<td>
<?php
																	if($strRoleID!='2')
																	{
?>																	
																		<div class="example-box-wrapper" style="align:center;"><button class="btn btn-default btn-md" data-toggle="modal" data-target="#<?=$counter?>">View Content</button>
																			<div class="modal fade" id="<?=$counter?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																				<div class="modal-dialog">
																					<div class="modal-content">
																						<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																							<h4 class="modal-title"><?=$Heading?></h4>
																						</div>
																						<div class="modal-body">
																							<p><?=$Content?></p>
																						</div>
																						<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button> </div>
																					</div>
																				</div>
																			</div>										
<?php																		
																	}
																	else
																	{
?>
																		<?=$Content?>
<?php																
																	}
?>																
																
																</td>
<?php
																if($strRoleID!='36')
																{
?>																
																	<td>
																		<b><?=$Status?></b>
																	</td>
<?php
																}
																else
																{
																	
?>																	
																		<td>
<?php																		
																			// echo $Status."TEST";
																			if($Status == "Pending")
																			{
																			 
?>																			
																				<a class="btn btn-link" href="<?=$strMyActionPage?>?sid=<?=$getUID?>">Approve</a>
																				<a class="btn btn-link" href="<?=$strMyActionPage?>?rid=<?=$getUID?>">Reject</a>
<?php		
																			}
																			elseif($Status == "Approved")
																			{
?>																				
																				<a class="btn btn-link">Approved</a>
<?php
																			}
																			elseif($Status == "Rejected")
																			{
?>
																				<a class="btn btn-link">Rejected</a>
<?php																				
																			}
?>																		
																		
																		</td>
																
<?php																	
																}
?>																																

<?php
																if($strRoleID!='36')
																{
																	// echo "In if<br>";
?>																
																	<td>
																		<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																		
																		<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step34','<?=$getUIDDelete?>', 'Are you sure you want to delete this Admin - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
																	</td>
<?php
																}
?>																
																
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
																<?php
																if($strRoleID!='36')
																{
?>

																	<td></td>
<?php
																}
?>																
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
											<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email', '.admin_password'); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Add Content</h3>
												<div class="example-box-wrapper">
													
<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SHOW COLUMNS FROM ".$strMyTable." ";
// echo $sql."<br>";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{
		if($row["Field"]==$strMyTableID)
		{
			// echo $strMyTableID;
		}
		else if ($row["Field"]=="Heading")
		{
?>			
													<div class="form-group">
														<label class="col-sm-3 control-label">
															<?=str_replace("Heading", "Heading", $row["Field"])?> <span>*</span>
														</label>
														<div class="col-sm-5">
															<input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Heading", "Heading", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Heading", "Heading", $row["Field"])?>">
														</div>
													</div>
<?php
		}
		else if ($row["Field"]=="Content")
		{
?>
													<div class="form-group">
														<label class="col-sm-3 control-label"><?=str_replace("Content", "Content", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-6">
																<textarea name="<?=$row["Field"]?>" id="<?=str_replace("Content", "Content", $row["Field"])?>" class="form-control required wysiwyg" placeholder="<?=str_replace("Content", "Content", $row["Field"])?>"></textarea>
															</div>
													</div>
																						
<?php
		}
		else if ($row["Field"]=="ContentReply")
		{
			
			if($strRoleID=='36')
			{
					// echo "In IF";
?>
													<!--<div class="form-group">
														<label class="col-sm-3 control-label">
															<?//=str_replace("SMSReplyComments", "Reply", $row["Field"])?> <span>*</span>
														</label>
														<div class="col-sm-4">
															<textarea rows="4" cols="50" name="<?//=$row["Field"]?>" id="<?//=str_replace("SMSReplyComments", "Reply", $row["Field"])?>" class="form-control required wysiwyg" placeholder="<?//=str_replace("SMSReplyComments", "Reply", $row["Field"])?>"></textarea>
														</div>
													</div>-->
<?php				
			}
			



													


		}
		else if ($row["Field"]=="Status")
		{
?>
<?php	
		}
		else if ($row["Field"]=="Type")
		{
?>
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

								
									<h3 class="title-hero">Edit Content</h3>
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
			elseif($key=="Heading")
			{
?>	
										
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Heading", "Heading", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Heading", "Heading", $key)?>" value="<?=$row[$key]?>"></div>
											</div>

<?php
			}
			elseif($key=="SMSDate")
			{
?>	
											<div class="form-group">
												<label class="col-sm-3 control-label">
													<?=str_replace("SMSDate", "SMS Date", $key)?> <span>*</span>
												</label>
												<div class="col-sm-4">
													<div class="input-prepend input-group">
														<span class="add-on input-group-addon">
															<i class="glyph-icon icon-calendar"></i>
														</span> 
															<input type="text" name="SMSDate1" id="SMSDate1"  class="form-control required" data-date-format="yy/mm/dd" value="<?=$row[$key]?>" placeholder="<?=str_replace("SMSDate", "SMS Date", $key)?>">
													</div>
													
													
													<!--<input type="text" name="<?//=$key?>" class="form-control required" placeholder="<?//=str_replace("SMSDate", " ", $key)?>" value="<?//=$row[$key]?>">-->
												</div>
											</div>
<?php
			}
			elseif($key=="Content")
			{
				
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Content", "Content", $key)?> <span>*</span></label>
												<div class="col-sm-8"><textarea name="<?=$key?>" class="form-control required wysiwyg"><?=$row[$key]?></textarea></div>
											</div>
<?php
			}
			elseif($key=="ContentReply")
			{
?>
											
<?php
			}
			elseif($key=="Status")
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