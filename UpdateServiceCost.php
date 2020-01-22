<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Update Service Cost| Nailspa";
	$strDisplayTitle = "Update Service Cost for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblServices";
	$strMyTableID = "ServiceID";
	$strMyField = "ServiceID";
	$strMyActionPage = "UpdateServiceCost.php";
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
			$strCustomerID = Filter($_POST["CustomerID"]);
			$strStoreID = Filter($_POST["StoreID"]);
			$strAppointmentDate = Filter($_POST["AppointmentDate"]);
			$strSuitableAppointmentTime = Filter($_POST["SuitableAppointmentTime"]);
			$strAppointmentCheckInTime = Filter($_POST["AppointmentCheckInTime"]);
			$strAppointmentCheckOutTime = Filter($_POST["AppointmentCheckOutTime"]);
			$strAppointmentOfferID = Filter($_POST["AppointmentOfferID"]);
			$strStatus = Filter($_POST["Status"]);


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
						<p>Appointment Already Booked!</p>
					</div>
				</div>');
			}
			else
			{
				$sqlInsert = "INSERT INTO $strMyTable (CustomerID, StoreID, AppointmentDate, SuitableAppointmentTime, AppointmentCheckInTime, AppointmentCheckOutTime, AppointmentOfferID, Status) VALUES 
				('".$strCustomerID."', '".$strStoreID."', '".$strAppointmentDate."', '".$strSuitableAppointmentTime."', '".$strAppointmentCheckInTime."', '".$strAppointmentCheckOutTime."', '".$strAppointmentOfferID."', '".$strStatus."')";
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
	
if(isset($_GET['cid']))
{
	$DB = Connect();
	if(isset($_GET['cid']))
	{
		$sqlUpdate1 = "UPDATE $strMyTable SET Status = '3' WHERE $strMyTableID='".Decode($_GET['cid'])."'";
		ExecuteNQ($sqlUpdate1);
		header('Location: ManageAppointments.php');
	}
	else
	{
		header('Location: Vieworders.php');
	}
	$DB->close();
}

	
	
	
	
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
</head>
<script>
function updatevalues(evt)
	{
		
		 var serviceid=$(evt).closest('td').prev().prev().find('input').val();
		//alert(serviceid)
			var stock=$(evt).closest('td').prev().html();
		
		//alert(stock)
		
		//alert(price)
		
 	if(serviceid!="")
		{
			$.ajax({
				type:"post",
				data:"serviceid="+serviceid+"&stock="+stock,
				url:"updatedateservicecost.php",
				success:function(result)
				{
			//alert(result);
				if($.trim(result)=='2')
				{
					var p = evt.parentNode.parentNode;
                        p.parentNode.removeChild(p); 
							location.reload();
				}
				}
				
				
			})
		} 
	}
</script>
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
                        <p>View Service Cost</p>
                    </div>
	<?php 
if(isset($_GET['uid']))
{
	
	$ServiceCode=DecodeQ($_GET['uid']);

	?>
			<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="ManageServices.php"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
                    <div class="panel">
						<div class="panel">
							<div class="panel-body">
								<div class="example-box-wrapper">
								<span class="form_result">&nbsp; <br></span>
									<div class="panel-body">
										<h3 class="title-hero">Update Cost For Service | Nailspa</h3>
										<div class="example-box-wrapper">
											<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>Sr.No</th>
														<th>Store Name</th>
														<th>Service Name</th>
														<th>Service Cost</th>
														<th>Action</th>
														
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>Sr.No</th>
														<th>Store Name</th>
														<th>Service Name</th>
														<th>Service Cost</th>
														<th>Action</th>
													</tr>
												</tfoot>
												<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$selp=select("*","tblServices","ServiceCode='".$ServiceCode."'");
foreach($selp as $val)
{
	$counter ++;
	$ServiceID	=$val['ServiceID'];
	$StoreID=$val['StoreID'];
	$ServiceName=$val['ServiceName'];
	$ServiceCost=$val['ServiceCost'];
	$ServiceCodet=$val['ServiceCode'];
	$seq=select("*","tblStores","StoreID='".$StoreID."'");
	$StoreName=$seq[0]['StoreName'];
	
	?>
			<tr id="my_data_tr_<?=$counter?>">
														<td><?=$counter?></td>
														<td><?=$StoreName?></td>
														<td><input type="hidden" id="serviceid" name="serviceid" value="<?=$ServiceID?>"/><?=$ServiceName?></td>
														<td contenteditable='true' id="servicecost"><?=$ServiceCost?></td>
														<td><a class="btn btn-link" href="#" onclick="updatevalues(this)">Update Cost</a></td>
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