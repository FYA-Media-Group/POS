<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Content Received | Nailspa";
	$strDisplayTitle = "Content Received of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportContentReceived.php";
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
			
		}
		
		if($strStep=="edit")
		{
			
		}
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
	<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker-demo.js"></script>
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
										</ul>
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Content Received </h3>
												
												<form method="get" class="form-horizontal bordered-row" role="form">
													<div class="form-group"><label for="" class="col-sm-4 control-label">Content Type</label>
														<div class="col-sm-4">
															
														
																<select class="form-control required"  name="contenttype">
															<option value="" selected>--Content Type--</option>
													      <option value="1">Web</option>
														  <option value="2">App</option>
												          </select>
															
														
														</div>
													</div>
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportContentReceived.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														

													</div>
												
												</form>
												
												
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
															   <th>Sr</th>
																<th>Heading</th>
																<th>Content</th>
																<th>Type</th>
																<th>Status</th>
																
															</tr>
														</thead>
														<tfoot>
															<tr>
															   <th>Sr</th>
																<th>Heading</th>
																<th>Content</th>
																<th>Type</th>
																<th>Status</th>
															</tr>
														</tfoot>
														<tbody>

<?php
$DB = Connect();
if(isset($_GET["contenttype"]))
	{
		$content=$_GET["contenttype"];

		$sql = "SELECT * from tblContentApproval where Type='$content'";
	}
	


$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$Heading = $row["Heading"];
		
		$Content = $row["Content"];
		$Type  = $row["Type"];
		if($Type=='1')
		{
			$Type="Web Content";
			
		}
		else
		{
			$Type="App Content";
		}
		
		$Status = $row["Status"];
		if($Status=='1')
		{
			$Status="Pending";
		}
		elseif($Status=='2')
		{
			$Status="Approved";
		}
		elseif($Status=='3')
		{
			$Status="Rejected";
		}
		elseif($Status=='4')
		{
			$Status="Deliverd";
		}
		
		
		
	
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$Heading?></td>
																<td><?=$Content?></td>
																<td><?=$Type?></td>
																<td><?=$Status?></td>
																
																
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
										
									</div>
								</div>
							</div>
						</div>
                    </div>
<?php
} // End null condition
else
{
	
}
?>
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>