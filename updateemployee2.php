<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Assign Employee| Nailspa";
	$strDisplayTitle = "Assign Employee| Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblOrder";
	$strMyTableID = "OrderID";
	$strMyActionPage = "updateemployee2.php";
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
			
			
			$DB = Connect();
			
			$strAppointmentID = Filter($_POST["app_id"]);
			$strEncodedAppointmentID = EncodeQ($strAppointmentID);
			
			$sql = "Select ServiceID from tblAppointmentsDetailsInvoice where AppointmentId='$strAppointmentID'";
				$RS = $DB->query($sql);
				if ($RS->num_rows > 0) 
				{
					$strStatus = "";
					while($row = $RS->fetch_assoc())
					{
						$strServiceID = $row["ServiceID"];
						
					     $strEmployee2 = $_POST["Employee2".$strServiceID];
						//$strSecondEmployee = $_POST[$strEmployee2];
						$strSecondEmployee = explode("#SU#",$strEmployee2);
						//print_r($strSecondEmployee);
						$strSecondEmployees = $strSecondEmployee[1];
						
						
						if($strSecondEmployees=="")
						{
							$strStatus = '1';
						}
						else
						{
							$strStatus = '2';
							
							//Insert if second employee exist
							$sqlInsert = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID, ServiceID, MECID, Commission) VALUES
							('".$strAppointmentID."', '".$strServiceID."', '".$strSecondEmployees."', '".$strStatus."')";
							$DB->query($sqlInsert);
							//echo $sqlInsert;
						}
						
						
						$strEmployee1 = $_POST["Employee1".$strServiceID];
						/* $strEmployee1 = $_POST["Employee1".$strServiceID];
						$strFirstEmployee = Filter($_POST[$strEmployee1]); */
						$strFirstEmployee = explode("#SU#",$strEmployee1);
						$strFirstEmployees = $strFirstEmployee[1];
							
						// Insert first employee
						$sqlInsert2 = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID, ServiceID, MECID, Commission) VALUES
						('".$strAppointmentID."', '".$strServiceID."', '".$strFirstEmployees."', '".$strStatus."')";
						$DB->query($sqlInsert2);
						//echo $sqlInsert2;
					echo "<script>location.href='appointment_invoice.php?uid=$strEncodedAppointmentID';</script>";
						
					}
					$strSecondEmployees="";
					$strFirstEmployees="";
				}
				else
				{
					echo "No Services Found for this Appointment";
					echo "<script>location.href='appointment_invoice.php';</script>";
					die();
				}
			
			
			$DB->close();	
		}
		die();
	}	
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>


<script>
 
        
	function fiftyfifty(serID)
	{
		
		document.getElementById("saif1"+serID).style.display = "block";
		$('#select'+serID).addClass('required');
		//alert(split);
	}
	
	
	
	function Alone(serID)
	{
		document.getElementById("saif1"+serID).style.display = "none";
		$('#select'+serID).removeClass("required");	
		$('#select'+serID).prop('selectedIndex', 0);
		//alert(split);
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
					
				<div class="panel">
					<div class="panel-body">
<?php
$DB = Connect();
$order = $_GET['order'];
$strIDs = DecodeQ($strID);
$sql_store = "SELECT StoreName FROM tblStores WHERE 1";
	$RS_store = $DB->query($sql_store);
	$row_store = $RS_store->fetch_assoc();
	$strStoreName = $row_store['StoreName'];
?>

					<div class="example-box-wrapper">
						<div class="tabs">
							
				<!--Manage Tab Start-->
<?php 
if(isset($_GET['uid']))
{				
	$app_id = DecodeQ($_GET['uid']);
	$app_idd = $_GET['uid'];	                     
	$app_iddd = EncodeQ($app_id);						
?>
							
	<div id="normal-tabs-2">
		<div class="fa-hover">	
			<a class="btn btn-primary btn-lg btn-block" href="appointment_invoice.php?uid=<?=$app_iddd?>"><i class="fa fa-backward"></i> &nbsp; Go back to Invoice <?//=$strPageTitle?></a>
		</div>
		
			<div class="panel-body ">
				<form role="form" id="printcontent" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
								
				<span class="result_message">&nbsp; <br></span>
								
				<input type="hidden" name="step" value="add">
				<input type="hidden" name="app_id" value="<?=$app_id?>">
				
				<input type="hidden" name="app_idd" value="<?=$app_idd?>">
								
				<h3 class="title-hero">Appointment Employee Details</h3>  
								
					<div class="panel-body">
						<div class="example-box-wrapper">
							<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
								<thead>
									<tr>
									 
										<th>Service</th>
										<th>No of Persons</th>
										<th>Employee</th>
										
										
									</tr>
								</thead>
								<tfoot>
									<tr>
										
										<th>Service</th>
										<th>No of Persons</th>
										<th>Employee</th>
										
									</tr>
								</tfoot>
								<tbody>
<?php
// Create connection And Write Values
$DB = Connect();
$sql = "Select (select GROUP_CONCAT(DISTINCT EID SEPARATOR '#SU#') from tblEmployeesServices) as ArrayEID, (select ServiceName from tblServices where ServiceID=tblAppointmentsDetailsInvoice.ServiceID) as NameOfService , ServiceID
		FROM tblAppointmentsDetailsInvoice
		where AppointmentID='".$app_id."'";
//echo $sql;
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;
	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strServiceID = $row["ServiceID"];
		$strServiceName = $row["NameOfService"];
		$strEIDArray = $row["ArrayEID"];
		$strFinalArray = explode("#SU#", $strEIDArray);													
?>	
			
			
			<tr id="my_data_tr_<?=$counter?>">
			
				<td><?=$strServiceName?> <?=$strServiceID?></td>
	
				<td>
					<input type="button" class="btn btn-azure" value="Split" onclick='fiftyfifty(<?=$strServiceID?>);' /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="button" class="btn btn-primary" value="Alone" onclick='Alone(<?=$strServiceID?>);' />
				</td>
				
				<td>
					<span>
						<select name="Employee1<?=$strServiceID?>" class="form-control required">
							<option value="">Please Select</option>
							<?php
								foreach($strFinalArray as $EID)
								{
									
									$sqlEmployee = "select EmployeeName from tblEmployees where EID='$EID'";
									//echo $sqlEmployee;
									$RSEmpsaif = $DB->query($sqlEmployee);
									if ($RSEmpsaif->num_rows > 0) 
									{
										while($rowEmpl = $RSEmpsaif->fetch_assoc())
										{
											$strEM = $rowEmpl["EmployeeName"];
											?>
												<option value="<?=$strServiceID?>#SU#<?=$EID?>"><?=$strEM?></option>
											<?php
										}
									}
								}
							
							?>
						</select>
					</span>
					
					<br>
					
					<span id="saif1<?=$strServiceID?>" style="display:none;">
					<br>
						<select id="select<?=$strServiceID?>" name="Employee2<?=$strServiceID?>" class="form-control">
							<option value="">Please Select second employee</option>
							<?php
								foreach($strFinalArray as $EID)
								{
									
									$sqlEmployee = "select EmployeeName from tblEmployees where EID='$EID'";
									//echo $sqlEmployee;
									$RSEmpsaif = $DB->query($sqlEmployee);
									if ($RSEmpsaif->num_rows > 0) 
									{
										while($rowEmpl = $RSEmpsaif->fetch_assoc())
										{
											$strEM = $rowEmpl["EmployeeName"];
											?>
												<option value="<?=$strServiceID?>#SU#<?=$EID?>"><?=$strEM?></option>
											<?php
										}
									}
								}
							
							?>
						</select>
					</span>
				</td>
			</tr>
								
<?php											
	}
?>



<?php
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
<!--TAB 2 START-->											
								</tbody>
										</table>
										<center><input type="Submit" class="btn btn-danger" value="Update Employees fo these Services"/></center>
										
									</div>
										
								</div>
								 
								</form>
								
		</div>						

	</div>
<?php
}
else
{

}
?>			
						</div>
					</div>	
				
			
					</div>
				</div>
			</div>
		</div>
			
			<?php require_once 'incFooter.fya'; ?>
        </div>
        
    </div>
</body>
</html>