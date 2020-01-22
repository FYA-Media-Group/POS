<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Admin Management | Nailspa";
	$strDisplayTitle = "Manage SMS Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblSMSApproval";
	$strMyTableID = "SMSApprovalID";
	$strMyField = "";
	$strMyActionPage = "SMSApproval.php";
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
			
			
			$strSMSEvent = Filter($_POST["SMSEvent"]);
			$SMSDate = Filter($_POST["SMSDate"]);
			$strSMSContent = Filter($_POST["message"]);				
			$strSMSReplyComments = Filter($_POST["SMSReplyComments"]);
	
			
			$strSMSDate = Filter($_POST["SMSDate"]);
			$date5 = new DateTime($strSMSDate);
			$strstrSMSDate = $date5->format('Y-m-d'); // 31-0
				// echo $strAppointmentDate;
				$StoreID = Filter($_POST["StoreID"]);
			$strSuitableAppointmentTime = Filter($_POST["SuitableAppointmentTime"]);
			$date=new DateTime();
			$pqr = date("H:i:s",strtotime($strSuitableAppointmentTime));
			//Status for : 1-Pending, 2-Approved, 3-Rejected, 4-Delivred
			// echo $strSMSEvent;
			// echo $strSMSDate;
			// echo $strSMSContent;
			// echo $strSMSReplyComments;
			// die();
			$DB = Connect();
			
			$InsertAdmin="Insert into tblSMSApproval(SMSEvent, SMSDate, SMSContent, Status,StoreID,Time) VALUES ('".$strSMSEvent."','".$strstrSMSDate."','".$strSMSContent."','1','".$StoreID."','".$pqr."')";
			$DB->query($InsertAdmin);		
			//exit;
					
					
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
					$strSMSApprovalID = Decode($_POST[$strMyTableID]);
					// $SMSApprovalID = Filter($_POST["SMSApprovalID"]);
					$strSMSEvent = Filter($_POST["SMSEvent"]);
					// echo $strSMSEvent."<br>";
					
					$strSMSDate = Filter($_POST["SMSDate"]);
					$strSMSContent = Filter($_POST["message"]);				
					$strSMSReplyComments = Filter($_POST["SMSReplyComments"]);
					$StoreID = Filter($_POST["StoreID"]);
					$Time = Filter($_POST["Time"]);
					// $strStatus = Filter($_POST["Status"]);
					$date=new DateTime();
			    $pqr = date("H:i:s",strtotime($Time));
		  			$date5 = new DateTime($strSMSDate);
					$strstrSMSDate = $date5->format('Y-m-d'); // 31-0
					
					
					// $sqlUpdate = "update $strMyTable set $key='$_POST[$key]' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					// ExecuteNQ($sqlUpdate);
					$UpdateSMS = "UPDATE tblSMSApproval SET SMSEvent='$strSMSEvent', SMSDate='$strstrSMSDate', SMSContent='$strSMSContent',StoreID='".$StoreID."',Time='".$pqr."' WHERE SMSApprovalID=$strSMSApprovalID";
					// echo $UpdateSMS."<br>";
					// die();
					// $RS = $DB->query($UpdateSMS);
					ExecuteNQ($UpdateSMS);		
				
			
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
	<script>
						$(function ()						
						{
							$("#SMSDate").datepicker({ minDate: 0 });
							$("#SMSDate1").datepicker({ minDate: 0 });
						});
					</script>
					

		<script>
		<!--
		$(document).ready(function(){
    var $remaining = $('#remaining'),
        $messages = $remaining.next();

    $('#message').keyup(function(){
        var chars = this.value.length,
            messages = Math.ceil(chars / 160),
            remaining = messages * 160 - (chars % (messages * 160) || messages * 160);

        $remaining.text(remaining + ' characters remaining');
        $messages.text(messages + ' message(s)');
    });
});
		//-->
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
                        <p>Approval Status of SMS Content</p>
                    </div>
<?php
if((isset($_GET["sid"])))
{
	$GetUID=$_GET["sid"];
	$GetUIDDecode=DecodeQ($_GET["sid"]);
	$GetUIDEncode=EncodeQ($_GET["sid"]);
	$UpdateApprove="UPDATE tblSMSApproval SET Status='2' WHERE SMSApprovalID='$GetUIDDecode'";
	// echo $UpdateApprove;
	ExecuteNQ($UpdateApprove);
	echo("<script>location.href='SMSApproval.php';</script>"); 
	
	
}
if((isset($_GET["rid"])))
{
	$GetUID=$_GET["rid"];
	$GetUIDDecode=DecodeQ($_GET["rid"]);
	$GetUIDEncode=EncodeQ($_GET["rid"]);
	$UpdateReject="UPDATE tblSMSApproval SET Status='3' WHERE SMSApprovalID='$GetUIDDecode'";
	// echo $UpdateApprove;
	ExecuteNQ($UpdateReject);
	echo("<script>location.href='SMSApproval.php';</script>"); 
	
	
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
												<h3 class="title-hero">List of SMS for Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
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

$sql = "SELECT * FROM $strMyTable order by $strMyTableID desc";

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strSMSApprovalID = $row["SMSApprovalID"];
		// echo $strSMSApprovalID."<br>";
		$getUID = EncodeQ($strSMSApprovalID);
		$getUIDDelete = Encode($strSMSApprovalID);
		$SMSEvent = $row["SMSEvent"];
		$SMSContent = $row["SMSContent"];
		
		$Status = $row["Status"];
		$SMSDate = $row["SMSDate"];
		
		$dateObject = new DateTime($SMSDate);
		// echo $dateObject->format('h:i A');
		// $abc=date("H:i",strtotime($SuitableAppointmentTime));
		// $abc=date_format("H:i:s",strtotime($SMSDate));
		
		// SMSEvent, SMSDate, SMSContent, Status
		
		
		
		
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
																<td width="10%"><b>Event : </b><br><?=$SMSEvent?><br><br><b>Date : </b><br><?=$SMSDate?> </td>
																<td width="65%" ><?=$SMSContent?></td>
																
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
																	<td width="10%">
																		<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																		
																		<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step32','<?=$getUIDDelete?>', 'Are you sure you want to delete this Admin - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
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

											
												<h3 class="title-hero">Add Admin</h3>
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
		else if ($row["Field"]=="SMSEvent")
		{
?>			
													<div class="form-group">
														<label class="col-sm-3 control-label">
															<?=str_replace("SMSEvent", "SMS Event", $row["Field"])?> <span>*</span>
														</label>
														<div class="col-sm-4">
															<input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("SMSEvent", "SMS Event", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("SMSEvent", "SMS Event", $row["Field"])?>">
														</div>
													</div>
<?php														
		}
		else if ($row["Field"]=="SMSDate")
		{
?>	
													<div class="form-group">
															<label class="col-sm-3 control-label">
																<?=str_replace("SMSDate", "SMS Date", $row["Field"])?> <span>*</span>
															</label>
															<div class="col-sm-4">
																 <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span> <input type="text" name="SMSDate" id="SMSDate"  class="form-control" data-date-format="yy/mm/dd" value="<?php echo date('y-m-d');?>"></div>
															</div>
													</div>

<?php
		}
	
		else if ($row["Field"]=="SMSContent")
		{
?>
													<div class="form-group">
														<label class="col-sm-3 control-label">
															<?=str_replace("SMSContent", "SMS Content", $row["Field"])?> <span>*</span>
														</label>
														<div class="col-sm-4">
															<textarea  rows="4" cols="50"   name="message" id="<?=str_replace("SMSContent", "message", $row["Field"])?>" class="form-control required wysiwyg" placeholder="<?=str_replace("SMSContent", "SMS Content", $row["Field"])?>"></textarea>
															<p>
																<span id="remaining">160 characters remaining</span>
																<b><span id="messages">| 1 message(s)</span></b>
															</p>
														</div>
													</div>
																						
<?php
		}
		else if ($row["Field"]=="SMSReplyComments")
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
		else if ($row["Field"]=="StoreID")
		{
			
			$sql1 = "SELECT StoreID, StoreName FROM tblStores WHERE Status = 0";
			$RS2 = $DB->query($sql1);
			if ($RS2->num_rows > 0)
			{
?>
														<div class="form-group"><label class="col-sm-3 control-label">Store<span>*</span></label>
															<div class="col-sm-3">
															<select class="form-control required"  id="StoreID"  name="StoreID" >
																<option value="" selected>-- Select Store --</option>
<?
																	while($row2 = $RS2->fetch_assoc())
																	{
																		$StoreID = $row2["StoreID"];
																		$StoreName = $row2["StoreName"];	
?>	
																		<option value="<?=$StoreID?>"><?=$StoreName?></option>
<?php
																	}
?>
															</select>
															</div>
														</div>	
<?php
			}

			
													
		}
		elseif($row["Field"]=="Time")
		{
						?>
						<div class="form-group"><label class="col-sm-3 control-label">Suitable Time <span>*</span></label>
															<div class="col-sm-3">
																<input type="text" name="SuitableAppointmentTime" id="SuitableAppointmentTime" class="form-control required timepicker-example" data-time-format="h:i %p">
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
			elseif($key=="SMSEvent")
			{
?>	
										
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("SMSEvent", "SMS Event", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("SMSEvent", "SMS Event", $key)?>" value="<?=$row[$key]?>"></div>
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
			elseif($key=="SMSContent")
			{
					// echo $row[$key];
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PostContent", "Content", $key)?> <span>*</span></label>
												<div class="col-sm-4">
													<textarea rows="4" cols="50"  name="message" id="message" class="form-control required wysiwyg"><?=$row[$key]?></textarea>
													<p>
														<span id="remaining">160 characters remaining</span>
														<span id="messages">1 message(s)</span>
													</p>
												</div>
											</div>
											
<?php
			}
			elseif($key=="SMSReplyComments")
			{
?>
											
<?php
			}
			elseif($key=="Status")
			{
					

			}
			elseif($key=="StoreID")
			{
				?>
				<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreID", "Store", $key)?> <span>*</span></label>
												<div class="col-sm-4">
													<select name="<?=$key?>" class="form-control"  id="StoreID">
														<option value="0">Select Here</option>
														<?php  
														$storep=$row[$key];
														$stores=explode(",",$storep);
													
															$sql_display = "SELECT * FROM tblStores";
															$RS_display = $DB->query($sql_display);
															if ($RS_display->num_rows > 0) 
															{
																while($row_display = $RS_display->fetch_assoc())
																{
																	$StoreName = $row_display["StoreName"];
																	$StoreID = $row_display["StoreID"];
																	if (in_array("$StoreID", $stores))
																	{
																	?>
																		<option selected value="<?=$StoreID?>"><?=$StoreName?></option>
																	<?
																	}
																	else
																	{
																	?>
																		<option value="<?=$StoreID?>"><?=$StoreName?></option>
																	<?
																	}
																}
															}
														?>
													</select>
												</div>
											</div>	
				<?php
				
			}
			else if($key=="Time")
			{
				//echo $row[$key];
				$SuitableAppointmentTime=$row[$key];
				//$pqr = date("H:i:s",strtotime($SuitableAppointmentTime));
				$dateObject = new DateTime($SuitableAppointmentTime);
				?>
					<div class="form-group"><label class="col-sm-3 control-label">Suitable Time <span>*</span></label>
															<div class="col-sm-3">
																<input type="text" name="Time" id="SuitableAppointmentTime" class="form-control required timepicker-example" value="<?= $SuitableAppointmentTime?>">
															</div>
														</div>	
														<?php
				
			}
			else if($key=="LastLogin")
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