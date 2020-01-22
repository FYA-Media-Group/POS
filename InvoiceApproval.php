<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Invoice | Nailspa";
	$strDisplayTitle = "Invoice for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblAppointmentsDetailsInvoice";
	$strMyTableID = "AppointmentDetailsID";
	$strMyActionPage = "InvoiceApproval.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
// code for not allowing the normal admin to access the super admin rights	


?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
</head>
    <script>
			function UpdateApproved()
            {                
				var id=$("#appointment_id").val();
			//	alert(id)
			if(id!="")
				{
						$.ajax({
					type: 'POST',
					url: "AuditUpdateInvoiceStatus.php",
					data:"id="+id,
					success:function(res)
					{
						
						if($.trim(res)=='2')
						{
							var msg="Invoice Approve Successfully";
							$(".load_charges1").html(msg);
						}
						
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$(".load_charges1").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						// alert (response);
					}
				});
				} 
			

            }
	</script>
    <style>
        .btn-success {
            background-color: lightgreen;
            color: black;
        }
        
        .btn-success:hover {
            background-color: lightgreen;
            color: black;
        }
        
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
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
                        <p>Approval Invoices</p>
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
											<li><a href="#normal-tabs-2" title="Tab 2">Approve Invoices</a></li>
										</ul>
											<div id="normal-tabs-1">
												<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Invoice for POS</h3>
												<div class="example-box-wrapper">
													                                <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sr.No</th>
                                                               
                                                                    <th>Invoice Name</th>
                                                                    <th>Appointment Date</th>
                                                                    <th>Store Name</th>
                                                                    <th>Invoice Amount</th>
                                                                    <th>Approval</th>
                                                                </tr>
                                                            </thead>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>Sr.No</th>
                                                                   
                                                                    <th>Invoice Name</th>
                                                                    <th>Appointment Date</th>
                                                                    <th>Store Name</th>
                                                                    <th>Invoice Amount</th>
                                                                    <th>Approval</th>
                                                                </tr>
                                                            </tfoot>
                                                            <tbody>

                                                                <?php

$DB = Connect();														
																


//working appointment log table																
// Create connection And Write Values



	$sql = "SELECT * FROM tblAppointments where status='2' and IsDeleted!='1' and ApproveStatus!='1' order by AppointmentID desc";
	// echo $sql;
	


// $sql = "SELECT * FROM tblAppointmentlog order by id desc";
// echo $sql."<br>";

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
$counter = 0;

while($row = $RS->fetch_assoc())
{
$counter ++;
$appointment_id = $row["AppointmentID"];

$selda=select("*","tblAppointments","IsDeleted!='1' and AppointmentID='$appointment_id'");
$invoice_name = $selda[0]["CustomerID"];
$sada=select("CustomerFullName","tblCustomers","CustomerID='".$invoice_name."'");
$customer=$sada[0]['CustomerFullName'];

$getUID = EncodeQ($appointment_id);
$appointment_date = $selda[0]["AppointmentDate"];

$store = $selda[0]["StoreID"];
$sadad=select("StoreName","tblStores","StoreID='".$store."'");
$storename=$sadad[0]['StoreName'];
$status = $selda[0]["Status"];
$seldapp=select("*","tblInvoiceDetails","AppointmentId='$appointment_id'");	

$invoiceamt=$seldapp[0]['RoundTotal'];
$amt=number_format($invoiceamt,2);
$flag=$seldapp[0]['Flag'];
?>
                                                                    <script>
                                                                        function checkstatus(ext, ep) {
                                                                            // alert(111)
                                                                            var uid = $("#uid").val();
                                                                            // alert(uid)
                                                                          //alert(ep)
                                                                            var number = $("#status").text();
                                                                            //alert(number)
                                                                            if (ext == 'Hold') {
                                                                                //alert(1234)
                                                                                // window.location="ManageAppointments.php";
                                                                                window.location = "appointment_invoice.php?uid=" + ep;
                                                                            } else if (ext == 'Processing') {
                                                                                window.location = "appointment_invoice.php?uid=" + ep;
                                                                            } else if (ext == 'Completed') {
                                                                                window.location = "InvoiceApproval.php?uid=" + ep;
                                                                            } else {

                                                                            }
                                                                        }
                                                                    </script>
                                                                    <?												
												if($flag!=='H')
												{
?>
                                                                        <tr id="my_data_tr_<?=$counter?>">
                                                                            <td style="text-align: center">
                                                                                <?=$counter?>
                                                                                    <input type="hidden" id="uid" value="<?php echo $appointment_id?>" />
                                                                            </td>
                                                                            
                                                                            <td style="text-align: center">

                                                                                <?=$customer?>

                                                                            </td>
                                                                            <td style="text-align: center">

                                                                                <?=$appointment_date?>

                                                                            </td>
                                                                            <td style="text-align: center">

                                                                                <?=$storename?>

                                                                            </td>
                                                                            <td style="text-align: center">

                                                                                <?=$amt?>

                                                                            </td>
                                                                            <td style="text-align: center" id="statusp">
																			
																				<?php $Status = "Approval Pending";
																				//echo $Status;
?>
																				<a id="status" class="btn btn-link" href="#" onClick="checkstatus('Completed','<?=$getUID?>')">
																					<?php echo $Status; ?>
																				</a>
																				
								
																						
                                                                            </td>


                                                                        </tr>
                                                                        <?
												}
											
?>

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
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Approved Invoices</h3>
												<div class="example-box-wrapper">
					                                                         <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="text-align:center">Sr.No</th>
                                                               
                                                                    <th style="text-align:center">Invoice Name</th>
                                                                    <th style="text-align:center">Appointment Date</th>
                                                                    <th style="text-align:center">Store Name</th>
                                                                    <th style="text-align:center">Invoice Amount</th>
                                                                    <th style="text-align:center">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tfoot>
                                                                <tr>
                                                                    <th style="text-align:center">Sr.No</th>
                                                                   
                                                                    <th style="text-align:center">Invoice Name</th>
                                                                    <th style="text-align:center">Appointment Date</th>
                                                                    <th style="text-align:center">Store Name</th>
                                                                    <th style="text-align:center">Invoice Amount</th>
                                                                    <th style="text-align:center">Status</th>
                                                                </tr>
                                                            </tfoot>
                                                            <tbody>

                                                                <?php

$DB = Connect();														
																


//working appointment log table																
// Create connection And Write Values



	$sql = "SELECT * FROM tblAppointments where status='2' and IsDeleted!='1' and ApproveStatus='1' order by AppointmentID desc";
	// echo $sql;
	


// $sql = "SELECT * FROM tblAppointmentlog order by id desc";
// echo $sql."<br>";

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
$counter = 0;

while($row = $RS->fetch_assoc())
{
$counter ++;
$appointment_id = $row["AppointmentID"];

$selda=select("*","tblAppointments","IsDeleted!='1' and AppointmentID='$appointment_id'");
$invoice_name = $selda[0]["CustomerID"];
$ApproveStatus = $selda[0]["ApproveStatus"];
$sada=select("CustomerFullName","tblCustomers","CustomerID='".$invoice_name."'");
$customer=$sada[0]['CustomerFullName'];

$getUID = EncodeQ($appointment_id);
$appointment_date = $selda[0]["AppointmentDate"];

$store = $selda[0]["StoreID"];
$sadad=select("StoreName","tblStores","StoreID='".$store."'");
$storename=$sadad[0]['StoreName'];
$status = $selda[0]["Status"];
$seldapp=select("*","tblInvoiceDetails","AppointmentId='$appointment_id'");	

$invoiceamt=$seldapp[0]['RoundTotal'];
$amt=number_format($invoiceamt,2);
$flag=$seldapp[0]['Flag'];
?>
                                                                    <script>
                                                                        function checkstatus(ext, ep) {
                                                                            // alert(111)
                                                                            var uid = $("#uid").val();
                                                                            // alert(uid)
                                                                          alert(ep)
                                                                            var number = $("#status").text();
                                                                            //alert(number)
                                                                            if (ext == 'Hold') {
                                                                                //alert(1234)
                                                                                // window.location="ManageAppointments.php";
                                                                                window.location = "appointment_invoice.php?uid=" + ep;
                                                                            } else if (ext == 'Processing') {
                                                                                window.location = "appointment_invoice.php?uid=" + ep;
                                                                            } else if (ext == 'Completed') {
                                                                                window.location = "InvoiceApproval.php?uid=" + ep;
                                                                            } else {

                                                                            }
                                                                        }
                                                                    </script>
                                                                    <?												
												if($flag!=='H')
												{
?>
                                                                        <tr id="my_data_tr_<?=$counter?>">
                                                                            <td style="text-align: center">
                                                                                <?=$counter?>
                                                                                    <input type="hidden" id="uid" value="<?php echo $appointment_id?>" />
                                                                            </td>
                                                                            
                                                                            <td style="text-align: center">

                                                                                <?=$customer?>

                                                                            </td>
                                                                            <td style="text-align: center">

                                                                                <?=$appointment_date?>

                                                                            </td>
                                                                            <td style="text-align: center">

                                                                                <?=$storename?>

                                                                            </td>
                                                                            <td style="text-align: center">

                                                                                <?=$amt?>

                                                                            </td>
                                                                            <td style="text-align: center" id="statusp">
																			Approved
                                                                            </td>


                                                                        </tr>
                                                                        <?
												}
											
?>

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
						<center><span class="load_charges1" style="FONT-SIZE:25px;text-align:center;"></span></center>
							<div class="panel-body">
							<button type="button" id="app_inc" value="app_inc" class="btn btn-success" data-toggle="button" onclick="UpdateApproved()" ><center>Approve Invoice</center></button>
							<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email', '.admin_password'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

								
								
									<div class="example-box-wrapper">
									 <table border="0" cellspacing="0" cellpadding="0" width="100%" >
										    <tbody style="border:1px" >
        <tr style="background-image: url(<?php echo $img;?>);background-repeat: no-repeat; background-position:50% 20%; media:print; -webkit-print-color-adjust: exact;">
            <td>
                <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center" >
                    <tbody>
                        
                        <tr >
                            <td>
                                <table id="printarea" style="BORDER-BOTTOM:#d0ad53 1px solid;BORDER-LEFT:#d0ad53 1px solid;BORDER-TOP:#d0ad53 1px solid;BORDER-RIGHT:#d0ad53 1px solid; border:0;" cellspacing="0" cellpadding="0" width="98%" align="center" media="print">
                                    <tbody >
										
									<?php
										$seldp=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
										$seldpd=select("StoreName","tblStores","StoreID='".$seldp[0]['StoreID']."'");
										$seldpde=select("InvoiceID","tblInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
										$seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
date_default_timezone_set('Asia/Kolkata');
		$timestamp =  date("H:i:s", time());
		$sqlUpdate1 = "UPDATE tblAppointments SET AppointmentCheckOutTime = '".$timestamp."', Status = '2' WHERE AppointmentID='".DecodeQ($_GET['uid'])."'";
		//$passingID = EncodeQ(DecodeQ($passingID1));
		ExecuteNQ($sqlUpdate1);
		
										$seldpdeptp=select("*"," tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
										foreach($seldpdeptp as $ty)
										{
											$totalservices=$ty['ServiceID'];
											$seldpdepp=select("MECID","tblAppointmentAssignEmployee","ServiceID='".$totalservices."' and AppointmentID='".DecodeQ($_GET['uid'])."'");
											//print_r($seldpdepp);
										}
								
									?>
                                        <tr>
										<input type="hidden" name="appointment_id" id="appointment_id" value="<?php echo DecodeQ($_GET['uid']) ?>" />
                                            <td align="middle">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td width="50%" align="left" style="padding:1%;"><img border="0" src="http://nailspaexperience.com/header/Nailspa-logo.png" width="117" height="60"></td>
                                                            <td width="50%" align="right" style="LINE-HEIGHT:15px; padding:1%; FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal;"><b>
															<?php echo $seldpd[0]['StoreName']; ?></b>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="LINE-HEIGHT:0;BACKGROUND:#d0ad53;FONT-SIZE:0px;" height="5"></td>
                                        </tr>
                                          <tr>
                                            <td align="middle">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                    <tbody>
                                                      <tr style="padding-left:10%;">
														<td width="76.5%">To ,</td>
														<td width="10%">Invoice No :</td>
														<td width="10%" style="float:center; padding-right:05%"><?php echo $seldpde[0]['InvoiceID']; ?></td>
													  </tr>
													   <tr>
														<td width="50%"><b><?php echo $seldpdep[0]['CustomerFullName']; ?></b></td>
														<td width="25%">Membership No :</td>
														<td width="25%" style="float:left;">
														
														<?php
                                                         if($seldp[0]['memberid']!='0')
														 {
															 echo $seldp[0]['memberid'];

														 }
														 else
														 {
															  echo "-";
														 }
														
														?>
														</td>
													  </tr>
													     <tr>
														 <input type="hidden" id="email" value="<?php echo $seldpdep[0]['CustomerEmailID'] ?>" />
														<td width="50%"><?php echo $seldpdep[0]['CustomerEmailID'] ?></td>
														
													  </tr>
													       <tr>
														<td width="50%"><?php echo $seldpdep[0]['CustomerMobileNo'] ?></td>
														<td width="25%">stylist(s) :</td>
														<td width="25%" style="float:left;">
															<?php
													 $seldpdeppt=select("MECID"," tblAppointmentAssignEmployee","AppointmentID='".DecodeQ($_GET['uid'])."'");
														foreach($seldpdeppt as $vap)
														{
															$empname=$vap['MECID'];
														$emppp=$emppp.','.$empname;
														
														
														}
														
														
														
															//$empnamep=implode(",",$empname);
													
														if($emppp=="")
														{
															echo "-";
														}
														else
														{
															?>
															<?php echo trim($emppp,","); ?>
															<?php
														}
														?>
														</td>
													  </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
										
                                        
                                        <tr>
                                            <td height="8"></td>
                                        </tr>
                                           <tr>
                                            <td style="LINE-HEIGHT:0;BACKGROUND:#d0ad53;FONT-SIZE:20px;text-align:center;" height="30"><b>Service's</b></td>
                                        </tr>
                                        <tr>
                                            <td height="8">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td bgcolor="#e4e4e4" height="4"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                              
                                                
                                                <tbody>
                                                        <tr>
                                                          <th width="5%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Sr</th>
                                                          <th width="60%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:left; padding-left:2%;">Item Description</th>
														   <th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Quantity</th>
                                                          <th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Amount</th>
														
														
                                                        </tr>
														<?php 
														$seldpdept=select("*"," tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
														$sub_total=0;
														$countsf = "0";
														$countersaif = "";
														$counterusmani = "1";
														foreach($seldpdept as $val)
														{
															$countersaif ++;
															$countsf++;
															$counterusmani = $counterusmani + 1;
															$totalammt=0;
															$AppointmentDetailsID=$val['AppointmentDetailsID'];
															$servicee=select("*","tblServices","ServiceID='".$val['ServiceID']."'");
															$qtyyy=$val['qty'];
															$amtt=$val['ServiceAmount'];
															$quantity=$val['qty'];
															$totalammt=$qtyyy*$amtt;
															$total=0;
															?>
															
															<tr>
																<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><?=$countsf?></td>
																  <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><?php  echo $servicee[0]['ServiceName']; ?></td>
																	<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:right; padding-right:05%;"><?php  echo $quantity;   ?>
																	
																 </td>
																  <td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:right; padding-right:05%;"><?php echo $totalammt.".00"; ?>
																  <?php 
																 
																 $sub_total=$sub_total+$totalammt;
														  $total=$total+$sub_total;
														  
																  
																  ?>
																</td>
															 
															</tr>
											<tr>
														<?php 
															$seldember=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
															$memid=$seldember[0]['memberid'];
															
														if($memid!="0")
														{
															
															 
			$DB = Connect();
			
		
				$seldatap=select("DiscountType","tblMembership","MembershipID='".$memid."'");	
				$type=$seldatap[0]['DiscountType'];
          if($type=='0')
		  {
			  $seldata=select("distinct(NotValidOnServices),MembershipName,Discount","tblMembership","MembershipID='".$memid."'");	  
		      //print_r($seldata);
			  $services=$seldata[0]['NotValidOnServices'];
			   $membershipname=$seldata[0]['MembershipName'];
			   $Discount=$seldata[0]['Discount'];
			  $sericesd=explode(",",$services);
		
					if(in_array($val['ServiceID'],$sericesd))
							{
					
							}
							else
							{
								$serviceid=$val['ServiceID'];
					$serviceamount=$val['ServiceAmount'];
					$qty=$val['qty'];
					$amount=$qty*$serviceamount;
					$totalamount=$amount*$Discount/100;
					
						?>
						<input type="hidden" name="serviceidm[]" id="serviceidm" value="<?= $serviceid ?>" />
						<input type="hidden" name="discountm[]" id="discountm" value="<?= $totalamount ?>" />
							<input type="hidden" name="memid[]" id="memid" value="<?= $memid ?>" />
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><?php echo $membershipname; ?></td><td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><?php echo $Discount; ?>% Membership Discount </td><td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"></td><td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:right; padding-right:05%;">
						
					<?=$totalamount.".00" ?>
														  <?php 
														  $offdisp=$offdisp+$Discount;
														 	  $memberdis=$memberdis+$totalamount;
														  
														
														  ?></td><td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"></td>
						<?php
					
							}
		       
			  
					
			  
			  
			  
			  
			  
			  
			  
			
		  }
			else
			{
			    $seldata=select("distinct(NotValidOnServices),MembershipName,Discount","tblMembership","MembershipID='".$memid."'");	  
		      //print_r($seldata);
			  $services=$seldata[0]['NotValidOnServices'];
			   $membershipname=$seldata[0]['MembershipName'];
			   $Discount=$seldata[0]['Discount'];
			  $sericesd=explode(",",$services);
			  //print_r($sericesd);
			 
					if(in_array($val['ServiceID'],$sericesd))
							{
							
							}
							else
							{
									?>
					<input type="hidden" name="serviceidm[]" id="serviceidm" value="<?= $serviceid ?>" />
						<input type="hidden" name="discountm[]" id="discountm" value="<?= $Discount ?>" />
							<input type="hidden" name="memid[]" id="memid" value="<?= $memid ?>" />
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><?php echo $membershipname; ?></td>
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><?php echo $Discount; ?>Amount Membership Discount </td>
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"></td>
						<td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:right; padding-right:05%;">
						<?=$Discount.".00" ?>
														  <?php 
														  	  $offdisp=$offdisp+$Discount;
													$memberdis=$memberdis+$Discount;
														
													
			
			
														//  $sub_total=$sub_total-$Discount;
													// $total=$total+$sub_total;
														  
														  
														  ?></td> 
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"></td>
						
						<?php
							}
						
					
											
						//echo "<br/>";
					
					
			}
						$DB->close();
														   
															
														}
														else
														{
															
														}
														
														?>
														  </tr>
														 
												<?php
														
														
														}
												
										$seldoffert=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
														$VoucherID=$seldoffert[0]['VoucherID'];
															if($VoucherID!='0')
															{
																$selp=select("*","tblGiftVouchers","Status='0' and AppointmentID='".DecodeQ($_GET['uid'])."'");
															$GiftVoucherID=$selp[0]['GiftVoucherID'];
															$RedemptionCode=$selp[0]['RedemptionCode'];
                                                            $Status=$selp[0]['Status'];
													if($RedemptionCode!="0")
													{
														if($Status=='0')
														{
														//echo $RedemptionCode;
														?>
														<tr>
														<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"></td>
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><?= $RedemptionCode?>&nbsp;&nbsp;Gift Voucher Code</td>
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"></td>
						<td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">
						
													
														</tr>
														<?php
														}
													}
															}
															
														
														?>
													
												

														
									
														
                                                        
                                                        
                                                      </tbody>
                                              
                                                </table>
                                            </td>
											
											 
                                        </tr>
                                        
														
												
														
                                        <tr>
                                            <td height="8">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td bgcolor="#e4e4e4" height="4"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                <tbody>
												
											
	
                                                    <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Sub Total</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;"><?php echo number_format($sub_total,2);?>
													</td>
                                                    </tr>
													<?php
													 	$seldember=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
													$VoucherID=$seldember[0]['VoucherID'];  
															
															
																	$seldembert=select("Status","tblGiftVouchers","AppointmentID='".DecodeQ($_GET['uid'])."'");
																	//print_r($seldembert);
														        	$Status=$seldembert[0]['Status'];  
																
																if($Status=='0')
																{
                                                                    
                                                               
																	
                                                                    
																	$selpt=select("*","tblGiftVouchers","AppointmentID='".DecodeQ($_GET['uid'])."' and Status='0'");
																    //print_r($selpt);
 
																	$amtt=$selpt[0]['Amount'];
                                                                     $id=$selpt[0]['GiftVoucherID'];
																
                                                                            
                                                                                 $selptp=select("*","tblGiftVouchers","RedempedBy='".DecodeQ($_GET['uid'])."' and Status='1'");
                                                                     if($selptp!='0')
                                                                      {

                                                                   $amttp=$selptp[0]['Amount'];
																   $id=$selptp[0]['GiftVoucherID'];
                                                                                
                                                                   if($amttp!="0")
                                                                           {
                                                                      
                                                                              $totalamt=$amtt-$amttp;
                                                                          $sub_total=$sub_total+$totalamt;
 ?>
																	 				 <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Redemption Gift Voucher Discount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;"><?php echo "-".number_format($amttp,2);?>
													</td>
                                                    </tr>
																	 <?php
                                                                            }
																		else
																		{
                                                           
																		}
                                                                       } 
                                                                            $sub_total=$sub_total+$amtt;
                                                                               
 ?>
																	 				 <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Gift Voucher Cost</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;"><?php echo "+".number_format($amtt,2);?>
													</td>
                                                    </tr>
																	 <?php
                                                                           
																		    
																		 
																	
																	
                                                                 
																	
																	
																}
																else
																{

                                                      
																	$selpt=select("*","tblGiftVouchers","RedempedBy='".DecodeQ($_GET['uid'])."' and Status='1'");
                                                                   
																	 $amtt=$selpt[0]['Amount'];
																      $RedempedBy=$selpt[0]['RedempedBy'];
																	    $id=$selpt[0]['GiftVoucherID'];
																	 
																	 if($amtt!='0')
																	 {
                                                                       if($RedempedBy==DecodeQ($_GET['uid']))
                                                                            {
                                                                                 
                                                                                
                                                                          $sub_total=$sub_total-$amtt;
?>
																	 				 <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Redemption Gift Voucher Discount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="hidden" name="Redemptid"  Value="<?=$id?>"/><input type="text" name="vouchercost" readonly value="<?php echo "-".number_format($amtt,2);?>" />
													</td>
                                                    </tr>
																	 <?php
                                                                            }
                                                                         } 
                                                           
                                                $selpt=select("*","tblGiftVouchers","AppointmentID='".DecodeQ($_GET['uid'])."' and Status='0'");
                                                         if($selpt!='0')
                                                         {

                                                                       $amttp=$selpt[0]['Amount'];
																	   $id=$selpt[0]['GiftVoucherID'];
                                                                                $sub_total=$sub_total+$amttp;
                                                                         ?>
																	 				 <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Gift Voucher Cost</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;"><?php echo "+".number_format($amttp,2);?>
													</td>
                                                    </tr>
																	 <?php
                                                                        

																		  
																	 
                                                          }
                                                         else
                                                         {

                                                         }
      
																	 
                                                                
																	
																}
																
														
																
														
											 	$seldember=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
															$memid=$seldember[0]['memberid'];  
															$custid=$seldember[0]['CustomerID'];  
														$seldemberg=select("*","tblMembership","MembershipID='".$memid."'");
															$Cost=$seldemberg[0]['Cost'];  		
															
														$selcust=select("*","tblCustomers","CustomerID='".$custid."'");	
															$memberflag=$selcust[0]['memberflag'];  		
															  $cust_name=$selcust[0]['CustomerFullName'];
														$selcustd=select("Membership_Amount","tblInvoiceDetails","CustomerFullName='".$cust_name."' and AppointmentId='".DecodeQ($_GET['uid'])."'");	
														$Membership_Amount=$selcustd[0]['Membership_Amount'];
														if($Membership_Amount!="")
														{
															 $sub_total=$sub_total+$Cost;
																		?>
																		 <tr>
																  <td width="50%">&nbsp;</td>
																  <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Membership Amount</td>
																  <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;"><?php echo "+".number_format($Cost,2);?>
																</td>
																</tr>
																<?php
														}
																
																		
												
															
															/////////////////////////////////////////////////////
																$seldoffer=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
															$offerid=$seldoffer[0]['offerid'];
															if($offerid!="0")
															{
																
													?>
													
													 <tr>
													 <td width="50%">&nbsp;</td>
										 
			
                                                     <?php 
													$seldoffer=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
															$offerid=$seldoffer[0]['offerid'];
															$StoreIDd=$seldoffer[0]['StoreID'];
																$memid=$seldoffer[0]['memberid'];  
													
													$seldofferp=select("*","tblOffers","OfferID='".$offerid."'");
															$services=$seldofferp[0]['ServiceID'];
															$baseamt=$seldofferp[0]['BaseAmount'];
															$Type=$seldofferp[0]['Type'];
															$TypeAmount=$seldofferp[0]['TypeAmount'];
															$StoreID=$seldofferp[0]['StoreID'];
															$stores=explode(",",$StoreID);
															
															$servicessf=explode(",",$services);
																if(in_array("$StoreIDd",$stores))
															    {
																	$statuscheck="No";
																	foreach($seldpdept as $val)
																		    {
																				
																			$totalammt=0;
																			$serviceid=$val['ServiceID'];
																			$AppointmentDetailsID=$val['AppointmentDetailsID'];
																	     	$AppointmentID=$val['AppointmentID'];
																			 
																					 if(in_array("$serviceid",$servicessf))
																				   {
																					
																					
																					$sqp=select("*","tblAppointmentsDetailsInvoice","ServiceID='".$serviceid."' and AppointmentID='".$AppointmentID."'");
																					
																					$amtt=$sqp[0]['ServiceAmount'];
																					
																					
																					 $qtyyy=$sqp[0]['qty'];
																					$totals=$qtyyy*$amtt;
																				  $totalpp=$totalpp+$totals;
																					if($baseamt!="")
																		            {
																					
																							if($totalpp>=$baseamt)
																							{
																						//echo 1;
																							if($Type=='1')
																							{
																								     if($statuscheck=="No")
                                                                                                   {
																									   $servicefinal=$serviceid;
																								//$offeramtt=$totalpp-$TypeAmount;
																								$offeramtt=$TypeAmount;
																								$statuscheck="Yes";
																								   }
																								   else{
																									   
																								   }
																							}
																							else
																							{
																								$amt=$totals*$TypeAmount/100;
																								
																								$offeramtt=$amt;
																			
																                  	$offeramount=$offeramount+$offeramtt;
																					
																					
																								
																							}
																							
																							
																			
																						
																								}
																								else
																								{
																									$data="Offer Not Applicable Offer Amount is Less Than Billing Amount";
																								}
																								
																																			                
													
																								
																					}
																					else
																					{
																						if($Type=='1')
																						{
																							 if($statuscheck=="No")
                                                                                                   {
																									   $servicefinal=$serviceid;
																							//$offeramtt=$totalpp-$TypeAmount;
																							$offeramtt=$TypeAmount;
																							$statuscheck="Yes";
																								   }
																						}
																						else
																						{
																							$amt=$totals*$TypeAmount/100;
																							
																							$offeramtt=$amt;
																
                                                                                   $offeramount=$offeramount+$offeramtt;
																						}
																						
																						
																						
													
														 	                  
																						
																					}
																					
																					?>
																<input type="hidden" name="serviceido[]" id="serviceido" value="<?= $serviceid ?>" />
						<input type="hidden" name="offeramttt[]" id="offeramttt" value="<?= $offeramtt ?>" />
							<input type="hidden" name="offerid[]" id="offerid" value="<?= $offerid ?>" />
																					<?php
																						
																				}
																				else
																				{
																					$data="Offer Not Applicable For Some Of These Services";
																				}
																			
																				
																			}
													     
																		
																}
																else
																{
																	$data="This Offer Is Not Valid For This Store";
																			
																}
																		
																			
																
											
										    
															//print_r($servicessf);
												
														 if($offeramtt!="")
													 {
														 if($Type=="1")
														 {
															$offeramtt=$offeramtt;
														 }
														 else
														 {
															$offeramtt=$offeramount;
														 }
														 
														
														 ?>
														  <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">
																							Offer Discount</td>
																							 <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;">
																							<?="-".$offeramtt ?></td>
														 <?php
													 }
													 ?>
													 
													
                                                    </tr>
													<?php
															}
													
															
													///////////////////////////////////////////////////////////////
                                                        ////////////////Member Discount///////////////////////
  
												 	$seldember=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
															$memid=$seldember[0]['memberid'];  
															 $offerid=$seldember[0]['offerid'];
															$custid=$seldember[0]['CustomerID'];  
														$seldemberg=select("*","tblMembership","MembershipID='".$memid."'");
															$Cost=$seldemberg[0]['Cost'];  		
															
														$selcust=select("*","tblCustomers","CustomerID='".$custid."'");	
															$memberflag=$selcust[0]['memberflag'];  

                                                         $seldofferp=select("*","tblOffers","OfferID='".$offerid."'");
															$services=$seldofferp[0]['ServiceID'];
															$baseamt=$seldofferp[0]['BaseAmount'];
															$Type=$seldofferp[0]['Type'];
															$TypeAmount=$seldofferp[0]['TypeAmount'];
															$StoreID=$seldofferp[0]['StoreID'];
															$stores=explode(",",$StoreID);
															
											
															if($memid!="0")
														        {
															?>
															 <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Membership Discount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;"><?php echo "-".number_format($memberdis,2);?>
													</td>
                                                    </tr>
															<?php
																}
													
																	


//////////////////////////////////////////////////////////////////////////////////////////////////													
					
	
												
														//print_r($value);
														//echo $value['AppointmentDetailsID'];
																$sqlExtraCharges=select("DISTINCT (ChargeName), SUM( ChargeAmount ) AS Sumarize","tblAppointmentsChargesInvoice","AppointmentID ='".DecodeQ($_GET['uid'])."' GROUP BY ChargeName");
													//print_r($sqlExtraCharges);
													
													foreach($sqlExtraCharges as $vaqq)
													{
															$strChargeNameDetails = $vaqq["ChargeName"];
						                              $strChargeAmountDetails = $vaqq["Sumarize"];
														?>
														  <tr>
										  <td width="50%">&nbsp;</td>
										  <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;"><?=$strChargeNameDetails ?></td>
										  <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold;text-align:right; padding-right:05%"><?="+".$strChargeAmountDetails ?></td>
										</tr>
										<?php
										$amountdetail=$amountdetail+$strChargeAmountDetails;
													}
													$total=0;
										//echo 
								 
								
												$total=$total+$sub_total+$amountdetail-$offeramtt-$memberdis;
										
									
									
													?>
													
										<?php
													
													
			/* 	//echo $sqlExtraCharges;
				$RScharges = $DB->query($sqlExtraCharges);
				if ($RScharges->num_rows > 0) 
				{
					while($rowcharges = $RScharges->fetch_assoc())
					{
						echo $strChargeNameDetails = $rowcharges["ChargeName"];
						$strChargeAmountDetails = $rowcharges["Sumarize"];
						
						$strChargetotalAmount += $strChargeAmountDetails;
						?>
					                      <tr>
										  <td width="50%">&nbsp;</td>
										  <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;"><?= $strChargeNameDetails ?></td>
										  <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><?= $strChargeAmountDetails ?></td>
										</tr>
										<?php
						
						
					}
				} */
                
				?>
				</tr>
				<?php
					$sept=select("PendingAmount","tblInvoiceDetails","AppointmentId='".DecodeQ($_GET['uid'])."'");
						$pendamt=$sept[0]['PendingAmount'];		
                          if($pendamt!="0" && $pendamt!="")			
						  {
							  $total=$total+$pendamt;
							  ?>
							      <tr id="pendingpayment"> 
				                                       <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%" ><?=$pendamt ?></td>
				                                  
				                                      </tr>
							  <?php
						  }
				?>
				                                   
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%" id="totalvalue"><?= number_format($total,2) ?></td>
                                                    </tr>
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Round Off</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;"><?php  
													  echo round($total);
													//  $total=0;
													  ?></td>
                                                    </tr>
                                                    
                                                  </tbody>
                                                                                                   
                                                </table>
                                            </td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <td height="8">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td bgcolor="#e4e4e4" height="4"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                   <?php 
										
										$seldppay=select("*","tblInvoiceDetails","AppointmentId='".DecodeQ($_GET['uid'])."'");
										
									$flag=$seldppay[0]['Flag'];
									
									$seldppayPt=select("*","tblPendingPayments","AppointmentID='".DecodeQ($_GET['uid'])."'");
										 $id=$seldppayPt[0]['PendingPaymentID'];
										 $pendingamt=$seldppayPt[0]['PendingAmount'];
										 $paidamt=$seldppayPt[0]['PaidAmount'];
										if($flag=='CS')
										{
												$seldppayP=select("*","tblInvoiceDetails","AppointmentId='".DecodeQ($_GET['uid'])."' AND Flag='".$flag."'");
															 $amount=$seldppayP[0]['CashAmount'];
												//print_r($seldppayP);
										
							
										
										 if($id!="")
										 {
											 	?>
											<tr>
											<td id="payment">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                	
                                                  			<?php
											
											 if($paidamt!="" && $pendingamt!="" && $paidamt!="0" && $pendingamt!="0" )
											 {
												
												 ?>
												 <tr>
                                                    <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                    </tr>
												  <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Paid Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($paidamt,2)?></td>
                                                    </tr>
													  <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($pendingamt,2)?></td>
                                                    </tr>
													
												 <?php
											 }
											 else
											 {
												
												  if($pendingamt!="" && $pendingamt!="0")
											      {
													 
												 ?>
												 <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($pendingamt,2)?></td>
                                                    </tr>
												 <?php
											 }
											 elseif($paidamt!="" && $paidamt!="0")
											 {
												 ?>
												 <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Paid Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($paidamt,2)?></td>
                                                    </tr>
												 <?php
											 }
												
											 }
												 
											 ?>
											    </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											 <?php 
											 
										 }
										 else
										 {
											
											 ?>
											 <tr>
											<td id="payment">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
											    <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Cash</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($amount,2)?></td>
                                                    </tr>
												  </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											 <?php
										 }
										?>
                                                 
                                                  
                                                                                                       
                                                    
                                                                                                       
                                                    
                                                
											<?php
										}
										elseif($flag=='H')
										{
												$seldppayP=select("*","tblInvoiceDetails","AppointmentId='".DecodeQ($_GET['uid'])."' AND Flag='".$flag."'");
										$amount=$seldppayP[0]['CashAmount'];
									
													?>
													<tr>
											<td id="payment">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                	
													<?php
													
										if($id!="")
										 {
											 	?>
											<tr>
											<td id="payment">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                	
                                                  			<?php
											
											 if($paidamt!="" && $pendingamt!="" && $paidamt!="0" && $pendingamt!="0" )
											 {
												 ?>
												 <tr>
                                                    <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                    </tr>
												  <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Paid Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($paidamt,2)?></td>
                                                    </tr>
													  <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($pendingamt,2)?></td>
                                                    </tr>
													
												 <?php
											 }
											 else
											 {
												
												  if($pendingamt!="" && $pendingamt!="0")
											      {
												 ?>
												 <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($pendingamt,2)?></td>
                                                    </tr>
												 <?php
											 }
											 elseif($paidamt!="" && $paidamt!="0")
											 {
												 ?>
												 <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Paid Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($paidamt,2)?></td>
                                                    </tr>
												 <?php
											 }
												
											 }
												 
											 ?>
											    </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											 <?php 
											 
										 }else
										 {
											 ?>
											   <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><?php echo number_format($amount,2)?></td>
                                                    </tr>
                                                  
											 <?php
										 }
										 ?>
                                                  
                                                                                                       
                                                    
                                                  </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											<?php
										}
										elseif($flag=='C')
										{
												$seldppayP=select("*","tblInvoiceDetails","AppointmentId='".DecodeQ($_GET['uid'])."' and Flag='".$flag."'");
										$amount=$seldppayP[0]['CardAmount'];
										
							
													?>
													<tr>
											<td id="payment">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                
                                                  <?php
										 if($id!="")
										 {
											
											 if($paidamt!="" && $pendingamt!="" && $paidamt!="0" && $pendingamt!="0" )
											 {
												 ?>
												 	<tr>
                                                    <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                    </tr>
												  <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Paid Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($paidamt,2)?></td>
                                                    </tr>
													  <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($pendingamt,2)?></td>
                                                    </tr>
													
												 <?php
											 }
											 else
											 {
												
												  if($pendingamt!="" && $pendingamt!="0")
											      {
												 ?>
												 <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($pendingamt,2)?></td>
                                                    </tr>
												 <?php
											 }
											 elseif($paidamt!="" && $paidamt!="0")
											 {
												 ?>
												 <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Paid Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($paidamt,2)?></td>
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
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Card</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><?php echo number_format($amount,2)?></td>
                                                    </tr>
											 <?php
										 }
										?>
                                                                                          
                                                    
                                                  </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											<?php
										}
										elseif($flag=='BOTH')
										{
										
												$seldppayP=select("*","tblInvoiceDetails","AppointmentId='".DecodeQ($_GET['uid'])."' and Flag='".$flag."'");
												//print_r($seldppayP);
									    $cashamount=$seldppayP[0]['CashAmount'];
										$cardamount=$seldppayP[0]['CardAmount'];
											?>
											<tr>
											<td id="payment">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                	<tr>
                                                    <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                    </tr>
													         			<?php
										 if($id!="")
										 {
											
											 if($paidamt!="" && $pendingamt!="" && $paidamt!="0" && $pendingamt!="0")
											 {
												 ?>
												  <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Paid Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($paidamt,2)?></td>
                                                    </tr>
													  <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($pendingamt,2)?></td>
                                                    </tr>
													
											 
                                                    <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Cash Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($cashamount,2)?></td>
                                                    </tr>
                                                      <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Card Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($cardamount,2)?></td>
                                                    </tr>
                                                  <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total Payment</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right;padding-right:05%" ><?php echo number_format($total,2);?></td>
                                                    </tr>
											 
												 <?php
											 }
											 else
											 {
												
												  if($pendingamt!="" && $pendingamt!="0")
											      {
												 ?>
												 <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($pendingamt,2)?></td>
                                                    </tr>
												 <?php
											 }
											 elseif($paidamt!="" && $paidamt!="0")
											 {
												 ?>
												 <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Paid Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($paidamt,2)?></td>
                                                    </tr>
												 <?php
											 }
											 ?>
											 
                                                    <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Cash</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($cashamount,2)?></td>
                                                    </tr>
                                                      <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Card</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($cardamount,2)?></td>
                                                    </tr>
                                                  <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total Payment</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right;padding-right:05%" ><?php echo number_format($total,2);?></td>
                                                    </tr>
											 <?php
												
											 }
												 
											
											 
										 }
										 else
										 {
											
											 ?>
											 
                                                    <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Cash</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($cashamount,2)?></td>
                                                    </tr>
                                                      <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Card</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($cardamount,2)?></td>
                                                    </tr>
                                                  <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total Payment</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right;padding-right:05%" ><?php echo number_format($total,2);?></td>
                                                    </tr>
											 <?php
										 }
										 ?>
													
													
													
													
													
                                                            
                                                
                                                                                                       
                                                    
                                                  </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											
											<?php
										}
										else
										{
										 
											?>
											<tr>
											<td style="display:none" id="payment">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                	<tr>
                                                    <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                    </tr>
                                                    <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Cash</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;"><input type="number" id="paymentid" name="cashamt" value="<?php echo $total; ?>" onkeyup="test()"/></td>
                                                    </tr>
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total Payment</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;" ><input id="totalpayment" name="totalpayment"/></td>
                                                    </tr>
                                                                                                       
                                                    
                                                  </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											<?php
											
										}
										?>
                                            
                                     
                                        
                                        
                                        
                                        
                                        
                                     <tr>
                                            <td height="8">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td bgcolor="#e4e4e4" height="4"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                      
                                        
                                                                         
                                        
                                        
                                        <tr>
                                            <td height="8"></td>
                                        </tr>
                                        
                                        <!--<tr>
										 <style>
												.con  {
												height:200px;
												width:100%;
												border:1px solid #d0ad53;
												}												
												</style>
												<td>
                                           <div class="con">
												<p align="center">Advertisement </p>
										   </div>
										   </td>
                                        </tr>-->
                                        <tr>
                                        
                                         <td  style="BACKGROUND:#d0ad53;">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                              
                                                <tbody>
                                        
                                        
                                        
                                            <td width="33%" style="FONT-FAMILY:Arial,Helvetica,sans-serif;BACKGROUND:#d0ad53;COLOR:#000;FONT-SIZE:12px; padding:1%;" height="32" align="center">
                                            <span style="font-size:14px; font-weight:600;" >KHAR | BREACH CANDY | ANDHERI | COLABA | LOKHANDWALA</span><br>
                                            </td>
											<tr>
                                            	<td style="BACKGROUND:#d0ad53;font-size:18px;font-weight:bold;" align="center"> Go Green, Go Paperless !</td>
                                            </tr>
                                            <!--<td width="33%" style="FONT-FAMILY:Arial,Helvetica,sans-serif;BACKGROUND:#d0ad53;COLOR:#000;FONT-SIZE:12px;" height="32" align="left">
                                            
                                            
                                            <span style="font-size:14px; font-weight:600;">KHAR</span><br>
                                            </td>
                                            <td width="33%" style="FONT-FAMILY:Arial,Helvetica,sans-serif;BACKGROUND:#d0ad53;COLOR:#000;FONT-SIZE:12px;" height="32" align="left">
                                            
                                            
                                            <span style="font-size:14px; font-weight:600;">ANDHERI</span><br>
                                            
                                            
                                            
                                            </td>
											 <td width="33%" style="FONT-FAMILY:Arial,Helvetica,sans-serif;BACKGROUND:#d0ad53;COLOR:#000;FONT-SIZE:12px;" height="32" align="left">
                                            
                                            
                                            <span style="font-size:14px; font-weight:600;">COLABA</span><br>
                                            
                                            
                                            
                                            </td>-->
                                            
                                            <!--<td style="FONT-FAMILY:Arial,Helvetica,sans-serif;BACKGROUND:#d0ad53;COLOR:#000;FONT-SIZE:15px;FONT-WEIGHT:bold;" height="32" align="right">
                                            
                                            <img border="0" src="http://nailspaexperience.com/header/Nailspa-logo.png" width="117" height="60"></td>-->
                                            
                                            </tbody>
                                            </table>
                                            </td>
                                            
                                            
                                        	</tr>
											
                                    	</tbody>
                                	</table>
                            	</td>
                        	</tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>			
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