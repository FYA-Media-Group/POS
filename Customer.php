<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Manage Customers | Nailspa";
	$strDisplayTitle = "Manage Customers for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblCustomers";
	$strMyTableID = "CustomerID";
	$strMyField = "CustomerMobileNo";
	$strMyActionPage = "ManageCustomers.php";
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
		
		$strServicesused = $_POST["Services"];
		$strStep = Filter($_POST["step"]);
		if($strStep=="assign")
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
			$strCustomerFullName = Filter($_POST["CustomerFullName"]);
			$strCustomerEmailID = Filter($_POST["CustomerEmailID"]);
			$strCustomerMobileNo = Filter($_POST["CustomerMobileNo"]);
			
			$strStoreID = Filter($_POST["StoreID"]);
			$strAppointmentDate = Filter($_POST["AppointmentDate"]);
			$strSuitableAppointmentTime = Filter($_POST["SuitableAppointmentTime"]);
			
			// $ServiceID = Filter($_POST["ServiceID"]);
			
			$strStatus = Filter($_POST["Status"]);
			

			$DB = Connect();
			$sql = "SELECT $strMyTableID FROM $strMyTable WHERE $strMyField='$_POST[$strMyField]'";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						<p>The Customer with same Mob. no. is  already exists. Please try again with a different Number.</p>
					</div>
				</div>');
			}
			else
			{
				$sqlInsert = "INSERT INTO $strMyTable (CustomerFullName, CustomerEmailID, CustomerMobileNo, Status) VALUES 
				('".$strCustomerFullName."', '".$strCustomerEmailID."', '".$strCustomerMobileNo."', '".$strStatus."')";
				if ($DB->query($sqlInsert) === TRUE) 
				{
					$last_id = $DB->insert_id;		//last id of tblCustomers insert
				}
				else
				{
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
				
				// Inserting appointment in tblAppointments
				$sqlInsert2 = "INSERT INTO tblAppointments (CustomerID, StoreID, AppointmentDate, SuitableAppointmentTime, Status) VALUES 
				('".$last_id."', '".$strStoreID."', '".$strAppointmentDate."', '".$strSuitableAppointmentTime."', '0')";
				
				if ($DB->query($sqlInsert2) === TRUE) 
				{
					$last_id2 = $DB->insert_id;		//last id of tblAppointments insert
				}
				else
				{
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
				
				
				
				
				// Inserting serviceID in tblAppointmentsDetails
				// $sqlInsert3 = "INSERT INTO tblAppointmentsDetails (AppointmentID, ServiceID, Status) VALUES 
				// ('".$last_id2."', '".$ServiceID."', '0')";
				// ExecuteNQ($sqlInsert3);
				
				// Fetch tblappointment details last insert id
				// if ($DB->query($sqlInsert3) === TRUE) 
				// {
					// $last_id3 = $DB->insert_id;		//last id of tblAppointments insert
				// }
				// else
				// {
					// echo "Error: " . $sql . "<br>" . $conn->error;
				// }
				// $sql = "SELECT ServiceID, EmployeeID FROM tblAppointmentsDetails WHERE AppointmentID ='50'";
				//echo $sql;
				// $RS = $DB->query($sql);
				// if ($RS->num_rows > 0) 
				// {
					// while($row = $RS->fetch_assoc())
					// {
						// $strServices[] = $row["ServiceID"];
						// $strEmployee[] = $row["EmployeeID"];
						
					// }
				// }
				
				
				//Insert Service Cost 
		
				foreach($strServicesused as $Service)
				{
					$sqlcost="Select ServiceCost from tblServices where ServiceID=$Service";
					 //echo $sqlcost."<br>";
					$costing = $DB->query($sqlcost);
					if ($costing->num_rows > 0) 
					{
						while($rowstores = $costing->fetch_assoc())
						{
							$ServiceCost = $rowstores["ServiceCost"];
							$ServiceID = $rowstores["ServiceID"];
							// echo $ServiceCost;
					
							$sqlInsert3 = "INSERT INTO tblAppointmentsDetails (AppointmentID, ServiceID, ServiceAmount,  Status) VALUES 
							('".$last_id2."', '".$Service."', '".$ServiceCost."', '0')";
							 //echo $sqlInsert3."<br>";
							//Last inserted id from tbl appointments
							
							if ($DB->query($sqlInsert3) === TRUE) 
							{
								$last_id3 = $DB->insert_id;		//last id of tblAppointments insert
							}
							else
							{
								echo "Error: " . $sql . "<br>" . $conn->error;
							}
						}
					}
					
					
					// Charges insert
					$sqlcharges = "Select ChargeNameId , (select GROUP_CONCAT(distinct ChargeSetID) from tblCharges where 
									ChargeNameID=tblServicesCharges.ChargeNameID) as ArrayChargeSet from tblServicesCharges where ServiceID= '".$Service."'";
						//echo $sqlcharges."<br>";
						$charges = $DB->query($sqlcharges);
						if ($charges->num_rows > 0) 
						{
							while($row = $charges->fetch_assoc())
							{
								$ServiceCost = $row["ChargeNameId"];
								$ArrayChargeSet = $row["ArrayChargeSet"];
								$strChargeSet = (explode(",",$ArrayChargeSet));
							}
						}
						
					
					for($i=0; $i<count($strChargeSet); $i++) 
					{
						$strChargeSetforwork = $strChargeSet[$i];
						$sqlchargeset = "select SetName, ChargeAmt, ChargeFPType from tblChargeSets where ChargeSetID=$strChargeSetforwork";
						//echo $sqlchargeset;
						$RS2 = $DB->query($sqlchargeset);
						if ($RS2->num_rows > 0) 
						{
							while($row2 = $RS2->fetch_assoc())
							{
								$strChargeAmt = $row2["ChargeAmt"];
								$strSetName = $row2["SetName"];
								$strChargeFPType = $row2["ChargeFPType"];
								
								// Calculation of charges
								$ServiceCost = $ServiceCost;
								if($strChargeFPType == "0")
								{
									$strChargeAmt = $strChargeAmt;
								}
								else
								{
									$percentage = $strChargeAmt;
									$outof = $ServiceCost;

									$strChargeAmt = ($percentage / 100) * $outof;
								}
								//echo $strChargeAmt;
											
								
								$sqlInsertcharges = "INSERT INTO tblAppointmentsCharges (AppointmentDetailsID, ChargeName, ChargeAmount) VALUES 
								('".$last_id3."', '".$strSetName."', '".$strChargeAmt."')";
								 //echo $sqlInsertcharges."<br>";
								 ExecuteNQ($sqlInsertcharges);
								//Last inserted id from tbl appointments

							}
						}
					}
				}
			
				
				
				
				
				
				
				
				
				// Send Email START
				$sql = "SELECT * FROM tblStores WHERE StoreID ='".$strStoreID."'";
				$RSstores = $DB->query($sql);
				if ($RSstores->num_rows > 0) 
				{
					while($rowstores = $RSstores->fetch_assoc())
					{
						$strStoreLocation = $rowstores["StoreName"];
						$strAddress = $rowstores["StoreBillingAddress"];
					}
				}
				else
				{
					
				}
				
				$sql = "SELECT ServiceID, EmployeeID FROM tblAppointmentsDetails WHERE AppointmentID ='".$last_id2."'";
				//echo $sql;
				$RS = $DB->query($sql);
				if ($RS->num_rows > 0) 
				{
					while($row = $RS->fetch_assoc())
					{
						$strServices[] = $row["ServiceID"];
						$strEmployee[] = $row["EmployeeID"];
						
					}
				}
				
				$strServicesselected ='<tr>
										<th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Code</th>
										<th width="75%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:left; padding-left:2%;">Item Description</th>
										<th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Amount</th>
									</tr>';
									
				$counterservices = 0;
				
				for($j=0; $j<count($strServices); $j++) 
				{	
					$counterservices++;
					$Servicestaken = $strServices[$j];
					
					$sql2 = "select ServiceName, ServiceCost, ServiceCode from tblServices where ServiceID=$Servicestaken";
				
						$RS2 = $DB->query($sql2);
						if ($RS2->num_rows > 0) 
						{
							while($row2 = $RS2->fetch_assoc())
							{
								$strServiceName = $row2["ServiceName"];
								$strServiceCost = $row2["ServiceCost"];
								$strServiceCode = $row2["ServiceCode"];
								
								$strServi = '<tr> 
								  <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">' . $strServiceCode. '</td>
								  <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;">' . $strServiceName. '</td>
								  <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">' . $strServiceCost. '</td>
								</tr>';
								$strServicesselected .= $strServi;
								
								$total_price_charges += $strServiceCost;
							}
						}
				}
				
				$strTaxations = "";
				$sqlExtraCharges = "SELECT DISTINCT (ChargeName), SUM( ChargeAmount ) AS Sumarize FROM tblAppointmentsCharges WHERE AppointmentId ='".$last_id2."' GROUP BY ChargeName";
				//echo $sqlExtraCharges;
				$RScharges = $DB->query($sqlExtraCharges);
				if ($RScharges->num_rows > 0) 
				{
					while($rowcharges = $RScharges->fetch_assoc())
					{
						$strChargeNameDetails = $rowcharges["ChargeName"];
						$strChargeAmountDetails = $rowcharges["Sumarize"];
						
						$strChargetotalAmount += $strChargeAmountDetails;
						
						$strTaxationsplus ='<tr>
										  <td width="50%">&nbsp;</td>
										  <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">'.$strChargeNameDetails.'</td>
										  <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;">'.$strChargeAmountDetails.'</td>
										</tr>';
						$strTaxations .= $strTaxationsplus;
						
					}
				}
				
				
				
				//Query to insert for invoice
				///////////////////////////
					$DB = Connect();
				$sqlInsert = "Insert into  tblInvoice (AppointmentID, EmailMessageID, DateOfCreation) values ('".$last_id2."', 'Null', 'Null')";
				ExecuteNQ($sqlInsert);
				//echo $sqlInsert;
				$DB->close();
								
					////////////////////////////////			
				$strTo = $strCustomerEmailID;
				$strFrom = "order@fyatest.website";
				$strSubject = "Thank you for booking appointment at NailSpa Experience";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2

				$Name = $strCustomerFullName;
				$Email = $strCustomerEmailID;
				$StoreLocation = $strStoreLocation;
				$StoreAddress = $strAddress;
				$strDate = date("Y/m/d");
				$strTime = date("h:i a");
				$strServices = $strServicesselected;
				$strPaymentsubtotal = $total_price_charges;
				$strChargetotalAmount = $strChargetotalAmount + $strPaymentsubtotal;
				$strChargetotalAmountround = round($strChargetotalAmount);
				//echo $strChargetotalAmount;
				//echo $strChargetotalAmountround;
				//$strEmployeeTechnician = $strTechnician;
				$sql_appointments = select("*","tblInvoice","AppointmentID='".$last_id2."'");
				
				$strInvoice = $sql_appointments[0]['InvoiceID'];

				//get the file:
				$message = file_get_contents('EmailFormat/EmailTemplate.html');
				$message = eregi_replace("[\]",'',$message);

				//setup vars to replace
				$vars = array('{Name_Detail}','{Email_Detail}','{Store_Location}','{Store_Address}','{Date_m}','{Time_m}','{Services_tr}','{subtotal}','{taxations}','{strChargetotalAmount}','{strChargetotalAmountround}','{Invoice}'); //Replace varaibles
				$values = array($Name,$Email,$StoreLocation,$StoreAddress,$strDate,$strTime,$strServices,$strPaymentsubtotal,$strTaxations,$strChargetotalAmount,$strChargetotalAmountround,$strInvoice);

				//replace vars
				$message = str_replace($vars,$values,$message);
				//echo $message;


				$strBody = $message;


				$DB = Connect();
				$sqlInsert = "Insert into tblEmailMessages (ToEmail, FromEmail, Subject, Body, DateTime, Status) values ('$strTo', '$strFrom', '$strSubject', '$strBody', now() ,'$strStatus')";
				ExecuteNQ($sqlInsert);
				//echo $sqlInsert;
				$DB->close();
				
				$sql_appointments = select("ID","tblEmailMessages","ToEmail='".$strTo."'");
				$emailmsgid = $sql_appointments[0]['ID'];

				 
				 $sqlUpdate = "UPDATE tblInvoice SET EmailMessageID='".$emailmsgid."' WHERE InvoiceID='".$strInvoice."'";
					ExecuteNQ($sqlUpdate);
				//die("Email inserted for queue to $strTo");
				//die();
				
				// Send Email End
				
				$DB->close();
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
					</div>
				</div>');
			}
		}
		elseif($strStep=="add")
		{
			$strCustomerFullName = Filter($_POST["CustomerFullName"]);
			$strCustomerEmailID = Filter($_POST["CustomerEmailID"]);
			$strCustomerMobileNo = Filter($_POST["CustomerMobileNo"]);
			$strStatus = Filter($_POST["Status"]);
			echo $strCustomerFullName;
			echo $strCustomerEmailID;
			echo $strCustomerMobileNo;
			die();
			
			
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
			
			$DB = Connect();
			$sql = "SELECT $strMyTableID FROM $strMyTable WHERE $strMyField='$_POST[$strMyField]'";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						<p>The Customer with same Mob. no. is  already exists. Please try again with a different Number.</p>
					</div>
				</div>');
			}
			else
			{
				$sqlInsert = "INSERT INTO $strMyTable (CustomerFullName, CustomerEmailID, CustomerMobileNo, Status) VALUES 
				('".$strCustomerFullName."', '".$strCustomerEmailID."', '".$strCustomerMobileNo."', '".$strStatus."')";
				
				$DB->close();
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
					</div>
				</div>');
			}
		}
		elseif($strStep=="edit")
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
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	<script>
	function LoadValue(OptionValue)
            {                
				// alert (OptionValue);
				$.ajax({
					type: 'POST',
					url: "GetServicesStoreWise.php",
					data: {
						id:OptionValue
					},
					success: function(response) {
						$(".load_charges").html(response);
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$(".load_charges").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						alert (response);
					}
				});

            }			
</script>
<script>

	function SelectTechnician()
	{        
		// var abc = document.getElementById("TechnicianSelect");
		// oSelectOne = enquiry_form.elements["SelectTechnician"];
		// alert(oSelectOne);
		// var result = [];SelectTechnician   enquiry_form
		// var options = abc && abc.options;
		// var opt;
		alert(options);
		$.ajax({
			type: 'POST',
			url: "GetEmployeeServiceWise.php",
			data: {
				id:OptionValue
			},
			success: function(response) {
				$(".load_chargesq").html(response);
					
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$(".load_chargesq").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
				return false;
				alert (response);
			}
		});

	}			

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
                        <p>Add, Edit, Delete Customers</p>
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
											<li><a href="#normal-tabs-2" title="Tab 2">Add Customer and Assign Appointment</a></li>
											<li><a href="#normal-tabs-3" title="Tab 3">Add Customer</a></li>
										</ul>
										<div id="normal-tabs-1">
												<span class="form_result">&nbsp; <br></span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Customers | Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Full Name</th>
																<th>Email ID</th>
																<th>Mobile No.</th>
																<th>Appointments</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Full Name</th>
																<th>Email ID</th>
																<th>Mobile No.</th>
																<th>Appointments</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SELECT * FROM ".$strMyTable." WHERE Status='0' order by CustomerID desc";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strCustomerID = $row["CustomerID"];
		$getUID = EncodeQ($strCustomerID);
		$getUIDDelete = Encode($strCustomerID);		
		$CustomerFullName = $row["CustomerFullName"];
		$CustomerEmailID = $row["CustomerEmailID"];
		$CustomerMobileNo = $row["CustomerMobileNo"];
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
																<td><?=$counter?></td>
																<td><?=$CustomerFullName?></td>
																<td><?=$CustomerEmailID?></td>
																<td><?=$CustomerMobileNo?></td>
																<td style="text-align: center">
																	<a class="btn btn-link font-blue" href="ManageAppointments.php?bid=<?=$getUID?>">Book</a>
																	<a class="btn btn-link font-blue" href="ManageAppointments.php?vid=<?=$getUID?>">View</a>
																</td>
																<td style="text-align: center">
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a><br>
																	<a class="btn btn-link" href="AssignMembership.php?aid=<?=$getUID?>">Assign Membership</a>
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
			
										
										<div id="normal-tabs-2">
											<div class="panel-body">
												<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="assign">

											
												<h3 class="title-hero">Add Customers</h3>
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
		else if ($row["Field"]=="CustomerFullName")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerFullName", "Full Name", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("CustomerFullName", "Full Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("CustomerFullName", "Full Name", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="CustomerEmailID")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?>"></div>
													</div>
<?
		}
		else if ($row["Field"]=="CustomerMobileNo")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerMobileNo", "Mobile No.", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" pattern="[0-9]{10}" title="Enter a valid mobile number!" name="<?=$row["Field"]?>" id="<?=str_replace("CustomerMobileNo", "Mobile No.", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("CustomerMobileNo", "Mobile No.", $row["Field"])?>"></div>
													</div>
<?
		}
		else if ($row["Field"]=="Status")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", "Status", $row["Field"])?> <span>*</span></label>
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
	// Fields from tblAppointments Table
			
			$sql1 = "SELECT StoreID, StoreName FROM tblStores WHERE Status = 0";
			$RS2 = $DB->query($sql1);
			if ($RS2->num_rows > 0)
			{
?>
														<div class="form-group"><label class="col-sm-3 control-label">Appointment at <span>*</span></label>
															<div class="col-sm-3">
															<select class="form-control required"  id="StoreID" onChange="LoadValue(this.value);" name="StoreID" >
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
			$sql2 = "SELECT ServiceID, ServiceName, ServiceCost FROM tblServices WHERE Status = 0 ORDER BY StoreID";
			$RS3 = $DB->query($sql2);
			if($RS3->num_rows > 0)
			{
?>
														<div class="form-group"><label class="col-sm-3 control-label">Appointment for <span>*</span></label>
															<div class="col-sm-3 load_charges">
															<select class="form-control required employee"    name="<?=$row["Field"]?>[]" multiple>
																<option value="" selected>-- Select Service --</option>
<?
																	while($row3 = $RS3->fetch_assoc())
																	{
																		$ServiceID = $row3["ServiceID"];
																		$ServiceName = $row3["ServiceName"];
																		$ServiceCost = $row3["ServiceCost"];
?>
																		<option value="<?=$ServiceID?>"><?=$ServiceName?>, Rs. <?=$ServiceCost?></option>
<?php
																	}
?>
															</select>
															</div>
														</div>
														
<?php
			}
?>




<?php														
														
												
?>
													


														<div class="form-group"><label class="col-sm-3 control-label">Appointment Date <span>*</span></label>
															<div class="col-sm-3">
																<input type="date" name="AppointmentDate" id="AppointmentDate" class="form-control required" placeholder="dd/mm/yyyy">
															</div>
														</div>	

														
														
														
														
														
														
														<div class="form-group"><label class="col-sm-3 control-label">Suitable Time <span>*</span></label>
															<div class="col-sm-3">
																<input type="time" name="SuitableAppointmentTime" id="SuitableAppointmentTime" class="form-control required" placeholder="hh:mm AM/PM">
															</div>
														</div>															
	
	
	
	

														<div class="form-group">
															<label class="col-sm-3 control-label"></label>
															<input type="submit" class="btn ra-100 btn-primary" value="Submit">
															<div class="col-sm-1">
																<a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a>
															</div>
														</div>
<?php
}
$DB->close();
?>													
												</div>
												</form>
											</div>
											
											
											
										</div>
	<!--Tab 3 started-->									
										<div id="normal-tabs-3">
											<div class="panel-body">
												<form role="form" class="form-horizontal bordered-row enquiry_form1" onSubmit="proceed_formsubmit('.enquiry_form1', '<?=$strMyActionPage?>', '.result_message1', '', '', ''); return false;">
											
											<span class="result_message1">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Add Customers</h3>
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
		else if ($row["Field"]=="CustomerFullName")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerFullName", "Full Name", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("CustomerFullName", "Full Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("CustomerFullName", "Full Name", $row["Field"])?>"></div>
													</div>
<?php
		}
		else if ($row["Field"]=="CustomerEmailID")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("CustomerEmailID", "Email ID", $row["Field"])?>"></div>
													</div>
<?
		}
		else if ($row["Field"]=="CustomerMobileNo")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerMobileNo", "Mobile No.", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><input type="text" pattern="[0-9]{10}" title="Enter a valid mobile number!" name="<?=$row["Field"]?>" id="<?=str_replace("CustomerMobileNo", "Mobile No.", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("CustomerMobileNo", "Mobile No.", $row["Field"])?>"></div>
													</div>
<?
		}
		else if ($row["Field"]=="Status")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", "Status", $row["Field"])?> <span>*</span></label>
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
														<div class="form-group">
															<label class="col-sm-3 control-label"></label>
															<input type="submit" class="btn ra-100 btn-primary" value="Submit">
															<div class="col-sm-1">
																<a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form1');" title="Clear"><span>Clear</span></a>
															</div>
														</div>
<?php
}
$DB->close();
?>													
												</div>
												</form>
											</div>
										
										</div>
	<!--Tab 3 end-->									
										
										
										
										
										
										
										
										
										
										
									</div>
								</div>
							</div>
						</div>
                    </div>
<?php
} // End null condition


//-----------------Normal Edit

else
{
?>						
					
					<div class="panel">
						<div class="panel-body">
							<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="<?=$strMyActionPage?>"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
						
							<div class="panel-body">
							<form role="form" class="form-horizontal bordered-row enquiry_form1" onSubmit="proceed_formsubmit('.enquiry_form1', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email', '.admin_password'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

								
									<h3 class="title-hero">Edit Customers</h3>
									<div class="example-box-wrapper">
										
<?php
$strID = DecodeQ(Filter($_GET["uid"]));
$DB = Connect();
$sql = "SELECT * FROM ".$strMyTable." WHERE $strMyTableID = '$strID'";
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
			elseif($key=="CustomerFullName")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerFullName", "Full Name", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("CustomerFullName", "Full Name", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="CustomerEmailID")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerEmailID", "Email ID", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("CustomerEmailID", "Email ID", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
			elseif($key=="CustomerMobileNo")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CustomerMobileNo", "Mobile No.", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" pattern="[0-9]{10}" title="Enter a valid mobile number!" class="form-control required" placeholder="<?=str_replace("CustomerMobileNo", "Mobile No.", $key)?>" value="<?=$row[$key]?>"></div>
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
												
												<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form1');" title="Clear"><span>Clear</span></a></div>
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