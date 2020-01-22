<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Assign Employee| Nailspa";
	$strDisplayTitle = "Assign Employee| Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblOrder";
	$strMyTableID = "OrderID";
	$strMyActionPage = "updateemployee.php";
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
		
			// yogita code for getting free service data
			$seldoffertqy=select("*","tblAppointments","AppointmentID='".$strAppointmentID."'");
			$FreeService=$seldoffertqy[0]['FreeService'];
			
			$sql = "Select * from tblAppointmentAssignEmployee where AppointmentId='$strAppointmentID' and MECID='0' and Commission='0'";
				$RS = $DB->query($sql);
				if ($RS->num_rows > 0) 
				{
					$strStatus = "";
					$strFreeService = "";
					$counter = 0;
					while($row = $RS->fetch_assoc())
					{
						$counter++;
						$strServiceID = $row["ServiceID"];
						$QtyParam = $row["QtyParam"];
						$Qty = $row["Qty"];
					    $strEmployee2 = $_POST["Employee2".$strServiceID.$counter];
					    //$stremployee22=$strEmployee2.$counter;
						$strSecondEmployee = explode("#TU#",$strEmployee2);
						//PRINT_R($strSecondEmployee);
						 $strSecondEmployees = $strSecondEmployee[1];
						 $QtyParam2 = $strSecondEmployee[2];
						 $Qty2 = $strSecondEmployee[3];
						 $strEmployee1 = $_POST["Employee1".$strServiceID.$counter];
						 $strFirstEmployee = explode("#SU#",$strEmployee1);
						 $strFirstEmployees = $strFirstEmployee[1];
						 $QtyParam1 = $strFirstEmployee[2];
						 $Qty1 = $strFirstEmployee[3];
						
						if($strSecondEmployees=="")
						{
							$strStatus = '1'; // Alone
						}
						else
						{
							$strStatus = '2'; // Split
						}
						
						if($FreeService!="0")
						{
							$strFreeService = "1";// insert 1 (Service free hai)
						}
						else
						{
							$strFreeService = "0"; // insert 0(Service free nahi hai)
						}
						
						// echo "Free :". $strFreeService."<br>";
						// echo "Commission type :". $strStatus."<br>";
						// echo "Appointment id :". $strAppointmentID."<br>";
						// echo "ServiceID id :". $strServiceID."<br>";
						
						if($strStatus=='1')
						{
							//echo $QtyParam1;
							//echo $Qty1;
							$sqlupdateemployee = "UPDATE tblAppointmentAssignEmployee SET MECID ='$strFirstEmployees', Commission ='$strStatus', FreeService ='$strFreeService' WHERE `AppointmentID` ='$strAppointmentID' and ServiceID ='$strServiceID' and QtyParam='".$QtyParam1."' AND Qty='".$Qty1."'";
							$DB->query($sqlupdateemployee);
							//echo $sqlupdateemployee.'<br>';						
						}
						elseif($strStatus=='2')
						{
							// echo "Employee id 1: ". $strFirstEmployees. "<br>";
							 //echo "Employee id 2: ". $strSecondEmployees. "<br>";
							
							$sqlupdateemployee = "UPDATE tblAppointmentAssignEmployee SET MECID ='$strFirstEmployees', Commission ='$strStatus', FreeService ='$strFreeService' WHERE `AppointmentID` ='$strAppointmentID' and ServiceID ='$strServiceID' AND Qty='".$Qty1."' and QtyParam='".$QtyParam1."'";
							$DB->query($sqlupdateemployee);
							//echo $sqlupdateemployee.'<br>';
							
							$sqlInsert = "INSERT INTO tblAppointmentAssignEmployee(AppointmentID, ServiceID, MECID, Commission, FreeService,Qty,QtyParam) VALUES('".$strAppointmentID."', '".$strServiceID."', '".$strSecondEmployees."', '".$strStatus."', '".$strFreeService."','".$Qty2."','".$QtyParam2."')";
							$DB->query($sqlInsert);	
							//echo $sqlInsert.'<br>';
						}
				
						echo "<script>location.href='updateemployee.php?uid=$strEncodedAppointmentID';</script>";
					}
					
					$strSecondEmployees="";
					$strFirstEmployees="";
					$DB->close();
					//die();
				}
				else
				{
					echo "No Services Found for this Appointment";
					echo "<script>location.href='appointment_invoice.php';</script>";
					die();
				}	
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
  

	function fiftyfifty(serID,setid)
	{
		
		document.getElementById("saif1"+serID+setid).style.display = "block";
		$('#select'+serID+setid).addClass('required');
	}
	
	
	
	function Alone(serID,set)
	{
		document.getElementById("saif1"+serID+set).style.display = "none";
		$('#select'+serID+set).removeClass("required");	
		$('#select'+serID+set).prop('selectedIndex', 0);
	}
	
	
	function updatevalues(evt)
	{
		
	 var empid=$(evt).closest('td').prev().find('input').val();
	 var service=$(evt).closest('td').prev().find('input').val();
	 var app=$("#app").val();
     var qtyparam=$(evt).closest('td').find('input').val();
	
 	 if(service!="")
		{
			$.ajax({
				type:"post",
				data:"empid="+empid+"&service="+service+"&app="+app+"&qtyparam="+qtyparam,
				url:"UpdateRepairEmployee.php",
				success:function(result)
				{
			//alert(result);
					 if($.trim(result)=='2')
					{
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
	
$testfp = select("StoreID","tblAppointments","AppointmentID='".$app_id."'");
$appstore=$testfp[0]['StoreID'];
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
						
<?php
// Create connection And Write Values
$DB = Connect();

$strqualitycontrol = select("count(*)","tblAppointmentAssignEmployee","AppointmentID='".$app_id."' and MECID='0' and Commission='0'");
$strQC = $strqualitycontrol[0]['count(*)'];
//echo $strQC;

if($strQC == "0")
{
	// No Assign table
}
else
{
?>						
							<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Service</th>
										<th>Assignment Type</th>
										<th>Employee Name</th>
										</tr>
								</thead>
								<tfoot>
									<tr>
										<th>Service</th>
										<th>No of Persons</th>
										<th>Employee Name</th>
									</tr>
								</tfoot>
								<tbody>
<?php

$sqpcntQ=select("ServiceID","tblAppointmentAssignEmployee","AppointmentID='".$app_id."' and MECID='0'");
foreach($sqpcntQ as $ap)
{
   $serp[]=$ap['ServiceID'];
}	
	$sql = "Select (select GROUP_CONCAT(DISTINCT EID SEPARATOR '#SU#') from tblEmployeesServices) as ArrayEID, (select ServiceName from tblServices where ServiceID=tblAppointmentAssignEmployee.ServiceID) as NameOfService, ServiceID,QtyParam ,Qty FROM tblAppointmentAssignEmployee where AppointmentID='".$app_id."' and MECID='0'";

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
			$QtyParam = $row["QtyParam"];
			$Qty = $row["Qty"];
			if(in_array("$strServiceID",$serp))
			{
			
			
	?>	
				
				<tr id="my_data_tr_<?=$counter?>">
				
					<td><?=$strServiceName?></td>
					<input type="hidden" name="serviceid" id="serviceid" value="<?=$strServiceID?>" />
					<td>
						<input type="button" class="btn btn-azure" value="Split" onclick='fiftyfifty(<?=$strServiceID?>,<?=$counter?>);' /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="button" class="btn btn-primary" value="Alone" onclick='Alone(<?=$strServiceID?>,<?=$counter?>);' />
					</td>
					
					<td>
						<span>
					
						<select name="Employee1<?=$strServiceID?><?=$counter?>" class="form-control required">
						<option value="">Please Select</option>
						<?php
							foreach($strFinalArray as $EID)
							{
											
							$sqlEmployee = "select EmployeeName from tblEmployees where EID='$EID' and Status='0' and StoreID='".$appstore."'";
											//echo $sqlEmployee;
							$RSEmpsaif = $DB->query($sqlEmployee);
							if ($RSEmpsaif->num_rows > 0) 
								{
									while($rowEmpl = $RSEmpsaif->fetch_assoc())
									{
									$strEM = $rowEmpl["EmployeeName"];
									
							?>
									<option value="<?=$strServiceID?>#SU#<?=$EID?>#SU#<?=$QtyParam?>#SU#<?=$Qty?>#SU#<?=$counter?>"><?=$strEM?></option>
							<?php
									}
								}
							}	
						?>
						</select>
						</span>
						
						<br>
						
						<span id="saif1<?=$strServiceID?><?=$counter?>" style="display:none;">
						<br>
						<select id="select<?=$strServiceID?><?=$counter?>" name="Employee2<?=$strServiceID?><?=$counter?>" class="form-control">
						<option value="">Please Select second employee</option>
						<?php
							foreach($strFinalArray as $EID)
							{
								$sqlEmployee = "select EmployeeName from tblEmployees where EID='$EID' and Status='0' and StoreID='".$appstore."'";
								$RSEmpsaif = $DB->query($sqlEmployee);
								if ($RSEmpsaif->num_rows > 0) 
								{
									while($rowEmpl = $RSEmpsaif->fetch_assoc())
									{
									$strEM = $rowEmpl["EmployeeName"];
							?>
								<option value="<?=$strServiceID?>#TU#<?=$EID?>#TU#<?=$QtyParam?>#TU#<?=$Qty?>#TU#<?=$counter?>"><?=$strEM?></option>
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
											
											
<?php
}
?>										
										
										<br>
										<?php
										$DB = Connect();
										$sqpcnt=select("count(*)","tblAppointmentAssignEmployee","AppointmentID='".$app_id."' and MECID!='0'");
								       $cntser=$sqpcnt[0]['count(*)'];
									   if($cntser>0)
									   {
										   ?>
										   
										   
										   
							<table id="printdata" class="table table-bordered table-striped  cf">
						       <thead class="cf">
									<tr>
										<th>Name of Service</th>
										
										<th>Employee Name</th>
										<th>Assignment Type</th>
										<th>Action</th>
										
									</tr>
								</thead>
								<tbody>
<?php
$counter = 0;
$sqpcntqt=select("distinct(ServiceID)","tblAppointmentAssignEmployee","AppointmentID='".$app_id."' and MECID!='0'");
foreach($sqpcntqt as $vqty)
{
	$servt[]=$vqty['ServiceID'];
}
?>
<input type="hidden" name="app" id="app" value="<?=$app_id?>" />
<?php
for($u=0;$u<count($servt);$u++)
{
    
		$counter ++;
		$sqpcntp=select("ServiceName","tblServices","ServiceID='".$servt[$u]."'");
		$ServiceName=$sqpcntp[0]['ServiceName'];
		$sqpcntpty=select("distinct(Qty)","tblAppointmentAssignEmployee","AppointmentID='".$app_id."' and ServiceID='".$servt[$u]."'");
		$Qty=$sqpcntpty[0]['Qty'];
		?>
	<tr id="my_data_tr_<?=$counter?>">
    <td><?=$ServiceName?></td>
	<td><table>
	<?php
	$sqpcntq=select("MECID","tblAppointmentAssignEmployee","AppointmentID='".$app_id."' and ServiceID='".$servt[$u]."'");
	foreach($sqpcntq as $vqqq)
	{
		
		$MECID=$vqqq['MECID'];
		$sqpcntpt=select("EmployeeName","tblEmployees","EID='".$MECID."'");
		$employeenameP=$sqpcntpt[0]['EmployeeName'];
		?>
		<tr><td><?=$employeenameP?></td></tr>	
		<?php
	}
		unset($sqpcntq);
$sqpcntq="";
$vqqq="";

	?>
	</table></td>
	<td><table>
	<?php
	//$sqpcntqttq=select("*","tblAppointmentAssignEmployee","AppointmentID='".$app_id."' and ServiceID='".$servt[$u]."'");
	$sqpcntqttq=select("*","tblAppointmentAssignEmployee","AppointmentID='".$app_id."' and ServiceID='".$servt[$u]."'");

	foreach($sqpcntqttq as $vqqq)
	{
		
		$strCommission=$vqqq['Commission'];
		$Qty=$vqqq['Qty'];
		$QtyParam=$vqqq['QtyParam'];
		if($strCommission!="0")
		{
			if($strCommission=="1")
						{
							
							$strCommissionType = '<span class="bs-label label-success">Alone</span>';
						
						}
						elseif($strCommission=="2")
						{
							$strCommissionType = '<span class="bs-label label-blue-alt">Split</span>';
							
							
						//echo $emp=implode(",",$empp);
						}
						
						$sqpcntqttqu=select("distinct(QtyParam)","tblAppointmentAssignEmployee","AppointmentID='".$app_id."' and ServiceID='".$servt[$u]."' and Commission='".$strCommission."' and Qty='".$Qty."'");	
		//print_r($sqpcntqttqu);
		//echo $QtyParam=$sqpcntqttqu[0]['QtyParam'];
		
		?>
		<tr><td><font color="red"><?=$strCommissionType?></td></tr>	
		<?php
			
		}
        
	}
	unset($sqpcntqttq);
$sqpcntqttq="";
$vqqq="";
	?>
	</table></td>
  <td><table>
	<?php
	//$sqpcntqttq=select("*","tblAppointmentAssignEmployee","AppointmentID='".$app_id."' and ServiceID='".$servt[$u]."'");
	$sqpcnt=select("*","tblAppointmentAssignEmployee","AppointmentID='".$app_id."' and ServiceID='".$servt[$u]."' group by QtyParam");

	foreach($sqpcnt as $vqqq)
	{
		
		$strCommission=$vqqq['Commission'];
		$Qty=$vqqq['Qty'];
		$QtyParam=$vqqq['QtyParam'];
		if($strCommission!="0")
		{
			
						$sqpcntqttqu=select("distinct(QtyParam)","tblAppointmentAssignEmployee","AppointmentID='".$app_id."' and ServiceID='".$servt[$u]."' and Commission='".$strCommission."' and Qty='".$Qty."'");	
		//print_r($sqpcntqttqu);
		//echo $QtyParam=$sqpcntqttqu[0]['QtyParam'];
		
		?>
		<tr><td style="dispaly:none"><input type="hidden" name="serid" id="serid" value="<?=$servt[$u]?>#SU#<?=$Qty?>" /></td><td><input type="hidden" name="QtyParam" id="QtyParam" value="<?=$QtyParam?>" /><a class="btn btn-link" href="#" onclick="updatevalues(this)">Repair / Delete</a></td></tr>	
		<?php
			
		}
        
	}
	unset($sqpcnt);
$sqpcnt="";
$vqqq="";
	?>
	</table></td>
    </tr>
	
	
	<?php
}	

unset($servt);
unset($sqpcntqttq);
$sqpcntqttq="";
$DB->close();


?>
										
								</tbody>
										</table>   
										   <?php
										   
									   }
									   else
									   {
										   
									   }
										?>
										
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