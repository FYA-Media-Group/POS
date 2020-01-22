<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Event Management | Nailspa";
	$strDisplayTitle = "Manage Events Nailspa";
	$strMenuID = "2";
	$strMyTable = "events";
	$strMyTableID = "id";
	$strMyField = "";
	$strMyActionPage = "ManageEvents.php";
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
					
			$title = Filter($_POST["title"]);
			// echo $title."<br>";
			$mydate = $_POST["mydate"];			
			$date = new DateTime($mydate);
			// echo $date."<br>";
			$strAppointmentDate1 = $date->format('Y-m-d'); // 31-07-2012
			// echo $strAppointmentDate1."<br>";
			$created = Filter($_POST["created"]);	
			// echo $created."<br>";			
			$modified = Filter($_POST["modified"]);
			// echo $modified."<br>";
			
			$status = Filter($_POST["status"]);
			// echo $status."<br>";
			
			$DB = Connect();
			// die();
				$sqlInsert = "INSERT INTO $strMyTable (title, date, created, modified,status) VALUES ('".$title."','".$strAppointmentDate1."', now(), now(), '".$status."')";
				
				// echo $sqlInsert."<br>";
				// die();
				ExecuteNQ($sqlInsert);
				
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Admin Added</h4>
						<p>Record Added Successfully</p>
					</div>
				</div>');
			
			
			//exit;
		}										
	
		if($strStep=="edit")
		{
			$title = Filter($_POST["title"]);
			$status = Filter($_POST["status"]);
			$mydate2 = $_POST["date"];
							// $mydate1 = $_POST["mydate"];
							// echo $strAppointmentDate."<br>";
			// echo $mydate2."<br>";
			$date = new DateTime($mydate2);
			// echo $date."<br>";
			$strAppointmentDate2 = $date->format('Y-m-d'); // 31-07-2012
			// echo $strAppointmentDate2."<br>";
   			// die();
			$DB = Connect();
			foreach($_POST as $key => $val)
			{
				if($key=="step" || $key==$strMyTableID)
				{
				
				}
				else
				{
					// $sqlUpdate = "update $strMyTable set $key='$_POST[$key]' WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					// ExecuteNQ($sqlUpdate);
					// echo $sqlUpdate."<br>";
					$sqlUpdate1="UPDATE $strMyTable SET title='".$title."', date='".$strAppointmentDate2."', status='".$status."',modified=now() WHERE $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					// echo $sqlUpdate1;
					ExecuteNQ($sqlUpdate1);
					// die();
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
	<?php require_once("Event.fya"); ?>
	<script type="text/javascript" src="assets/widgets/datepicker/datepicker.js"></script>
                    <script type="text/javascript">
                        /* Datepicker bootstrap */

                        $(function() {
                            "use strict";
                            $('.bootstrap-datepicker').bsdatepicker({
                                format: 'yyyy-mm-dd'
                            });
                        });
                    </script>
                    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker.js"></script>
                    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker-demo.js"></script>
                    <script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>
						<script>
						$(function ()						
						{
							$("#mydate").datepicker({ minDate: 0 });
							$("#mydate").datepicker({ minDate: 0 });
						});
					</script>
	
	<link type="text/css" rel="stylesheet" href="events/style.css"/>

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
                        <p>Add, Edit, Delete Events</p>
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
											
											<li><a href="#normal-tabs-3" title="Tab 3">View Calendar</a></li>
											<li><a href="#normal-tabs-1" title="Tab 1">Manage</a></li>
											<li><a href="#normal-tabs-2" title="Tab 2">Add</a></li>
										</ul>
										<div id="normal-tabs-3">
											<div class="col-sm-12">
												<div id="calendar-example-1" class="col-md-10 center-margin"></div>
											</div>
										</div>
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Events for Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Title</th>
																<th>Event Date</th>
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Title</th>
																<th>Event Date</th>
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SELECT * FROM $strMyTable order by id desc";
// echo $sql."<br>";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;
	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strid = $row["id"];
		$getUID = EncodeQ($strid);
		$getUIDDelete = Encode($strid);
		$strtitle = $row["title"];
		$strdate = $row["date"];
		$strcreated = $row["created"];
		$strmodified = $row["modified"];
		$strStatus = $row["status"];
		
		if($strStatus=="1")
		{
			$strStatus = "Live";
		}
		else
		{
			$strStatus = "Offline";
		}
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><b>Title:<br><?=$strtitle?></td>
																<td><b>Event Date:<br><?=$strdate?></td>
																<td><?=$strStatus?></td>
																<td>
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																		<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step26','<?=$getUIDDelete?>', 'Are you sure you want to delete this Event - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
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
										</div>
										
										<div id="normal-tabs-2">
											<div class="panel-body">
											<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email', '.admin_password'); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Add Events</h3>
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
		else if ($row["Field"]=="LastLogin")
		{

?>
<?php
		}
		else if ($row["Field"]=="created")
		{
?>
														
<?php
		}
		else if ($row["Field"]=="modified")
		{
?>
														
<?php
		}
		else if ($row["Field"]=="title")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("title", "Event Title", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("title", "Title", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("title", "Title", $row["Field"])?>"></div>
														</div>	
<?php
		}
		else if ($row["Field"]=="date")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("date", "Date", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><!--<input type="text" name="<?//=$row["Field"]?>" id="<?//=str_replace("date", "Date", $row["Field"])?>" class="form-control required" placeholder="<?//=str_replace("date", "Date", $row["Field"])?>"></div>-->
																 <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span> <input type="text" name="mydate" id="mydate"  class="form-control" data-date-format="YY-MM-DD" value="<?php echo date('Y-m-d');?>"></div>
															 </div>
														</div>	
													
<?php
		}
		else if ($row["Field"]=="status")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3">
																<select name="<?=$row["Field"]?>" class="form-control required">
																	<option value="1" Selected>Live</option>
																	<option value="0">Offline</option>	
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

								
									<h3 class="title-hero">Edit Events</h3>
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
			elseif($key=="date")
			{
				// echo $row[$key];
?>	
										<div class="form-group"><label class="col-sm-3 control-label">Date<span>*</span></label>
											<div class="col-sm-3">
												<div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span> <input type="text" name="<?=$key?>" value="<?=$row[$key]?>" id="mydate"  class="form-control" data-date-format="yy/mm/dd" value="<?php echo date('Y-m-d');?>"></div>
							
												</div>
										</div>	
											
<?php
			}
			elseif($key=="title")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("title", "Event Title", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("title", "Event Title", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="created")
			{
?>		
<?php
			}
			elseif($key=="modified")
			{
?>	
<?php
			}
			elseif($key=="status")
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("status", "Status", $key)?> <span>*</span></label>
												<div class="col-sm-2">
													<select name="<?=$key?>" class="form-control required">
														<?php
															if ($row[$key]=="1")
															{
														?>
																<option value="1" selected>Live</option>
																<option value="0">Offline</option>
														<?php
															}
															elseif ($row[$key]=="0")
															{
														?>
																<option value="1">Live</option>
																<option value="0" selected>Offline</option>
														<?php
															}
															else
															{
														?>
																<option value="" selected>--Choose option--</option>
																<option value="1">Live</option>
																<option value="0">Offline</option>
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