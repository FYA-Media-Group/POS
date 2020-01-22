<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "List Invoices | Nailspa";
	$strDisplayTitle = "List Invoices of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "DeleteInvocies.php";
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
	<script>
	function updatevalues(evt)
	{
		var app_id=$(evt).closest('td').find('input').val();
		if(app_id!='0')
		{
				$.ajax({
				type:"post",
				data:"app_id="+app_id,
				url:"UpdateAppointment.php",
				success:function(result)
				{
			//alert(result);
				if($.trim(result)=='2')
				{
					alert('Invoice Deleted Successfully')
				 window.location="DeleteInvocies.php";
				}
				}
				
				
			})
		}
	}
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
												<h3 class="title-hero">List of All Invoices</h3>
												
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
															   <th>Sr</th>
																<th>Customer Name</th>
																<th>Bill Amount</th>
																<th>Store Name</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
															   <th>Sr</th>
																<th>Customer Name</th>
																<th>Bill Amount</th>
																<th>Store Name</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>

<?php
$DB = Connect();
	
			  	$sql1="select tblAppointments.AppointmentID,tblAppointments.CustomerID, tblInvoiceDetails.RoundTotal, tblAppointments.StoreID, tblInvoiceDetails.ChargeAmount,tblAppointments.IsDeleted
from tblAppointments 
left join tblInvoiceDetails on
tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentId
where tblInvoiceDetails.AppointmentId!='NULL'";



$RS = $DB->query($sql1);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$AppointmentID = $row["AppointmentID"];
	    $CustomerID = $row["CustomerID"];
		
		$RoundTotal = $row["RoundTotal"];
		if($RoundTotal =="")
			{
				$RoundTotal ="0.00";
			}
			else
			{
			
				$RoundTotal = $RoundTotal;
				
			}
			$TotalRound += $RoundTotal;
		
		$StoreID = $row["StoreID"];
		$IsDeleted = $row["IsDeleted"];
		
		$selpt=select("StoreName","tblStores","StoreID='".$StoreID."'");
		$StoreName=$selpt[0]['StoreName'];
    	$selpty=select("CustomerFullName","tblCustomers","CustomerID='".$CustomerID."'");
		$CustomerFullName=$selpty[0]['CustomerFullName'];
		$ChargeAmount = $row["ChargeAmount"];
		$charge=explode(",",$ChargeAmount);
		for($i=0;$i<count($charge);$i++)
		{
			//echo $charge[$i];
			$charamt=str_replace("+","",$charge[$i]);
			
			if($charamt=="")
			{
				$charamt ="0.00";
			}
			else
			{
			
				$charamt = $charamt;
				
			}
		$Totalcharge += $charamt;
		$Remaintotal=$RoundTotal-$Totalcharge;
		}
		$Totalcharged += $Totalcharge;
		$Remaintotalt += $Remaintotal;
		
		
			
		
		                                              if($IsDeleted!='1')
													  {
	
		
?>														
		  
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$CustomerFullName?></td>
																<td><?=$RoundTotal?></td>
																<td><?=$StoreName?></td>
															
																<td><input type="hidden" id="app_id" value="<?= $AppointmentID?>" /><a class="btn btn-link font-red" href="#" onclick="updatevalues(this)">Delete Invoice</a></td>
																
															</tr>		
															
															
<?php
													  }
$Totalcharge="";
$Remaintotal="";

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
														
														<tbody>
														<tr>
															<td colspan="2"><center><b>Sum Of Amount(s) : <?=$counter?></b><center></td>
															 <td class="numeric"><b>Rs. <?=$TotalRound?>/-</b></td>
															 <td class="numeric"></td>
															
														     
														</tr>
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