<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
					

<?php
	$strPageTitle = "Manage Stores | Nailspa";
	$strDisplayTitle = "Manage Store Target for Nailspa";
	$strMenuID = "3";
	$strMyTable = "tblStoreSalesTarget";
	$strMyTableID = "STID";
	$strMyField = "Month";
	$strMyActionPage = "ManageTarget.php";
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
			
			$strStoreName = Filter($_POST["StoreName"]);
			$strMonth = Filter($_POST["Month"]);
			$strYear = Filter($_POST["Year"]);
			$strTargetAmount = Filter($_POST["TargetAmount"]);
			$strStoreID = Filter($_POST["StoreID"]);
			$strStatus = Filter($_POST["Status"]);
			$Year = Filter($POST["currentYear"]);
			
			
			$DB = Connect();
			$sql = "Select * from $strMyTable where StoreID='$strStoreID' and Month = '$strMonth' and Year = '$strYear'";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						<p>The Target for This month and selected Year is already set in the system.</p>
					</div>
				</div>');
			}
			else
			{
				 
				$sqlInsert = "Insert into $strMyTable ( Month, Year, TargetAmount, StoreID) Values
				('".$strMonth."', '".$strYear."','".$strTargetAmount."','".$strStoreID."')";
				// echo $sqlInsert;
				// die();
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
					$sqlUpdate = "update $strMyTable set $key='$_POST[$key]' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					ExecuteNQ($sqlUpdate);
					 //echo "$sqlUpdate";
					// die();
				}
			}
			$DB->close();
			die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Updated Successfully</h4>
						<p>Information message box using the color scheme.</p>
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
	
					<script type="text/javascript" src="assets/widgets/datepicker/datepicker.js"></script>
                    <script type="text/javascript">
                        /* Datepicker bootstrap */

                        $(function() {
                            "use strict";
                            $('.bootstrap-datepicker').bsdatepicker({
                                format: 'mm-dd-yyyy'
                            });
                        });
                    </script>
                    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker.js"></script>
                    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker-demo.js"></script>
                    <script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>
                    <script type="text/javascript" src="assets/widgets/timepicker/timepicker.js"></script>
                    <script type="text/javascript">
                        /* Timepicker */

                        $(function() {
                            "use strict";
                            $('.timepicker-example').timepicker();
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
                        <p>Add, Edit, Delete Monthly Target for each Store.</p>
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
												<h3 class="title-hero">List of Monthly Targets for Nailspa Stores</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Month and Year</th>
																<th>Target</th>
																<th>Store</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Month and Year</th>
																<th>Target</th>
																<th>Store</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
//$sql = "Select * FROM $strMyTable order by $strMyTableID desc";
$sql = "Select STID, Month, Year, TargetAmount, (select StoreName from tblStores where StoreID=tblStoreSalesTarget.StoreID) as StoreName FROM tblStoreSalesTarget order by STID desc";
//echo $sql;
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strSTID = $row["STID"];
		$getUID = EncodeQ($strSTID);
		$getUIDDelete = Encode($strSTID);
		$Month = $row["Month"];
		$Year = $row["Year"];
		$TargetAmount = $row["TargetAmount"];
		$StoreName = $row["StoreName"];
		
		
		
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
																<td><?=$Month?>&nbsp; - <?=$Year?></td>
																<td>Rs. <?=$TargetAmount?></td>
																<td><?=$StoreName?></td>
																<td style="text-align: center">
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
																	
																	<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step10','<?=$getUIDDelete?>', 'Are you sure you want to delete this Store Stock Record - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
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
										
										<div id="normal-tabs-2">
											<div class="panel-body">
											<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email', '.admin_password'); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Add Target For Store</h3>
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
		else if ($row["Field"]=="saif")
		{
?>
												<div class="form-group"><label for="" class="col-sm-3 control-label">Basic</label>
													<div class="col-sm-5">
														<div class="bootstrap-timepicker dropdown"><input class="timepicker-example form-control" type="text"></div>
													</div>
												</div>
												
												<div class="form-group"><label for="" class="col-sm-3 control-label">Basic</label>
													<div class="col-sm-3">
														<div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span> <input type="text" class="bootstrap-datepicker form-control" value="02/16/12" data-date-format="mm/dd/yy"></div>
													</div>
												</div>

<?php
		}
		else if ($row["Field"]=="Month")
		{
?>	
													
														
														
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Month", "Month", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-2">
															
																
																<select class="form-control required"  name="<?=$row["Field"]?>">
																		<option value="" selected>--Select--</option>
<?
																for($m=1; $m<=12; ++$m)
																{										
?>		
																	<option value="<?php echo date('F', mktime(0, 0, 0, $m, 1)) ?>" ><?php echo date('F', mktime(0, 0, 0, $m, 1)) ?></option>														
<?php
																}
?>
																	</select>
															</div>
														</div>	
<?php	
		}
		else if ($row["Field"]=="TargetAmount")
		{	
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("TargetAmount", "Target Amount", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("TargetAmount", "Target Amount", $row["Field"])?>" class="form-control  required" placeholder="<?=str_replace("TargetAmount", "Target Amount", $row["Field"])?>"></div>
														</div>


<?php
		}
		else if ($row["Field"]=="Year")
		{
			$startdate = 2010;
			//year to end with - this is set to current year. You can change to specific year
			$enddate = date("Y");
			$years = range ($startdate,$enddate);
			
			
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Year", "Year", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-2">
															
																
																<select class="form-control required"  name="<?=$row["Field"]?>">
																		<option value="" selected>--Select--</option>
<?
																foreach($years as $year)
																{
?>		
																	<option value="<?=$year?>" ><?=$year?></option>														
<?php
																}
?>
																	</select>
															</div>
														</div>	
<?php
		}
		else if ($row["Field"]=="StoreID")
		{
			$sql1 = "select StoreID, StoreName FROM tblStores";
			$RS2 = $DB->query($sql1);
			if ($RS2->num_rows > 0)
			{
?>											
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreID", "Store", $row["Field"])?> <span>*</span></label>
												<div class="col-sm-3">
													<select class="form-control required"  name="<?=$row["Field"]?>">
															<option value="" selected>--Select Store--</option>
<?
													while($row2 = $RS2->fetch_assoc())
													{
														$strStoreID = $row2["StoreID"];
														$strStoreName = $row2["StoreName"];
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
				echo "Stores are not added. <a href='ManageStores.php' class='btn btn-link' target='Stores'>Click here to Add Stores</a>";
			}
?>
												</div>
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
$sql = "select * FROM $strMyTable where $strMyTableID = '$strID'";
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
			elseif($key=="StoreID")
			{
					$DBvalue=$row[$key];

										
						$sql = "SELECT StoreID, StoreName from tblStores where StoreID='$DBvalue' Limit 0,1";
						//echo $sql;
						$RS2 = $DB->query($sql);
						if ($RS2->num_rows > 0)
						{
							while($row2 = $RS2->fetch_assoc())
							{
								$StoreID = $row2["StoreID"];
								$StoreName = $row2["StoreName"];
							}
						}
?>
								
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input class="form-control required" readonly value="<?=$StoreName?>"></div>
											</div>					
					
					
<?php
			}
			elseif($key=="Month")
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input class="form-control required" readonly value="<?=$row[$key]?>"></div>
											</div>

<?php
			}
			elseif($key=="Year")
			{

?>																
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input class="form-control required" readonly value="<?=$row[$key]?>"></div>
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