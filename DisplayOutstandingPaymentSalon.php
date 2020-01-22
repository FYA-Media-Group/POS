<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Outstanding Payment | Nailspa";
	$strDisplayTitle = "Outstanding Payment  | Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblExpenses";
	$strMyTableID = "ExpenseID";
	$strMyActionPage = "DisplayOutstandingPaymentSalon.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
	
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
	// if($strStore=="0")
	// {
		// die("Sorry you are trying to enter Unauthorized access");
	// }
// code for not allowing the normal admin to access the super admin rights	

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		 $DB = Connect();
		$strStep = Filter($_POST["step"]);
		if($strStep=="add")
		{
		}
		

		if($strStep=="edit")
		{
		}
		
	}	
	
	if(isset($_GET["toandfrom"]))
	{
		
		$strtoandfrom = $_GET["toandfrom"];
		$arraytofrom = explode("-",$strtoandfrom);
		
		$from = $arraytofrom[0];
		$datetime = new DateTime($from);
		$getfrom = $datetime->format('Y-m-d');
		
		
		$to = $arraytofrom[1];
		$datetime = new DateTime($to);
		$getto = $datetime->format('Y-m-d');

		if(!IsNull($from))
		{
			$sqlTempfrom = " and  Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$getto."')";
		}
	}
	if(isset($_GET["toandfrom"]))
	{
		$strtoandfrom = $_GET["toandfrom"];
		$arraytofrom = explode("-",$strtoandfrom);
		
		$from = $arraytofrom[0];
		$datetime = new DateTime($from);
		$getfrom = $datetime->format('Y-m-d');
		
		
		$to = $arraytofrom[1];
		$datetime = new DateTime($to);
		$getto = $datetime->format('Y-m-d');

		if(!IsNull($from))
		{
			$sqlTempfrom = " and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$getto."')";
		}
	}
	

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker.js"></script>
	<script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker-demo.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker-demo.js"></script>
</head>
<script>
$(document).ready(function(){
var store=$("#storeid").val();
				
		
				   $.ajax({
		type:"post",
		data:"storeid="+store,
		url:"storecategoryorder.php",
		success:function(res)
		{
		//alert(res)
		var rep = $.trim(res);
		$("#catid").show();
			$("#catid").html("");
						$("#catid").html("");
						$("#catid").html(rep);
		}
		
		})

				
		
		
})
	function printDiv(divName) 
		{
		$("#heading").show();
	    var divToPrint = document.getElementById("printdata");
    var htmlToPrint = '' +
        '<style type="text/css">' +
        'table th, table td {' +
        'border:1px solid #000;' +
        'padding;0.5em;' +
        '}' +
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
			// var printContents = document.getElementById(divName);
			// var originalContents = document.body.innerHTML;

			// document.body.innerHTML = printContents;

			// window.print();

			// document.body.innerHTML = originalContents; 
		}
function updateexpensestatus(evt)
{
	 var id=$(evt).closest('td').prev().find('input').val();
		//alert(id)
 	if(id!="")
		{
			$.ajax({
				type:"post",
				data:"id="+id,
				url:"UpdateExpensesStatus.php",
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
<style type="text/css">
@media print {
  body * {
    visibility: hidden;
  }
  #printarea * {
    visibility: visible;
  }
  #printarea{
    position: absolute;
    left: 0;
    top: 0;
  }
}
#di table
{
	border:none;
}
</style>

					<div class="example-box-wrapper">
						<div class="tabs">

											
											
										<span class="form_result">&nbsp; <br></span>
											
											<div class="panel-body">
												<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="javascript:window.location = document.referrer;"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							                   </div>
											   <br/>
												
											 <?php
											 $DB = Connect();
											 $strAvailableBalance = $row_balance['Balance'];
											 $First= date('Y-m-01');
											 $Last= date('Y-m-t');
											 $counter = 0;
																	
																	
												?>
											
												<br>
												<div class="example-box-wrapper">
												<table class="table table-bordered table-striped table-condensed cf" width="100%">
														<thead>
															<tr>
															   <th>Sr</th>
																<th>Customer Name</th>
																<!--<th>Offer</th>
																<th>Membership</th>-->
																<th>Invoice No.</th>
																<th>Pending Amount</th>
																<!--<th>Total Amount</th>-->
																<th>Pending Date</th>
																<th>Store</th>
															</tr>
														</thead>
													
														<tbody>

<?php
	$DB = Connect();
	$First= date('Y-m-01');
	$Last= date('Y-m-t');
	// echo "In else<br>";
	$sql = "Select tblPendingPayments.PendingAmount as Pending,tblAppointments.offerid,tblAppointments.memberid,tblInvoiceDetails.CustomerFullName,tblInvoiceDetails.InvoiceId,
	tblAppointments.AppointmentID, tblAppointments.StoreID,
	tblInvoiceDetails.RoundTotal,tblPendingPayments.DateTimeStamp from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID Left Join tblInvoiceDetails ON  tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID WHERE tblAppointments.IsDeleted!='1' and tblAppointments.StoreID='$strStore'and tblPendingPayments.PendingStatus='2' and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$First."') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$Last."')";


// echo $sql;
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$Pending = $row["Pending"];
		
		$offerid = $row["offerid"];
		$InvoiceId = $row["InvoiceId"];
		$memberid = $row["memberid"];
		$StoreID = $row["StoreID"];
		$appointment_id = $row["AppointmentID"];
		$CustomerFullName = $row["CustomerFullName"];
		$RoundTotal = $row["RoundTotal"];
		$DateTimeStampt = $row["DateTimeStamp"];
		$DateTime = FormatDateTime($DateTimeStampt);
	
		$getUID = EncodeQ($appointment_id);
	
		$selp=select("OfferName","tblOffers","OfferID='".$offerid."'");
		$OfferName=$selp[0]['OfferName'];
		$selpy=select("MembershipName","tblMembership","MembershipID='".$memberid."'");
		$MembershipName=$selpy[0]['MembershipName'];
		
		
		$selpS=select("StoreName","tblStores","StoreID='".$StoreID."'");
		$StoreName=$selpS[0]['StoreName'];
		
		
		$Pending = $row["Pending"];
		
		if($Pending =="")
		{
			$Pending ="0.00";
		}
		else
		{
		
			$Pending = $Pending;
			
		}
		$TotalPending += $Pending;
		
		if($RoundTotal =="")
		{
			$RoundTotal ="0.00";
		}
		else
		{
		
			$RoundTotal = $RoundTotal;
			
		}
		$TotalRoundTotal += $RoundTotal;
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$CustomerFullName?></td>
																<!--<td><?//=$OfferName?></td>
																<td><?//=$MembershipName?></td>-->
																<td>
																<a id="status" class="btn btn-link" href="PendingInvoicesForDisplay.php?uid=<?=$getUID;?>">
																<?=$InvoiceId?></a>
																</td>
																<td><?=$Pending?></td>
																<!--<td><?//=$RoundTotal?></td>-->
																<td><?=$DateTime?></td>
																<td><?=$StoreName?></td>
																
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
																<!--<td></td>-->
																<td></td>
																<td></td>
															</tr>
													
														
<?php
}
$DB->close();
?>
														
														</tbody>
														
														<tbody>
														<tr>
															<td colspan="3"><center><b>Total Pending Amount in selected periods(s) : <?=$counter?></b><center></td>
															
															<td class="numeric"><b>Rs. <?=$TotalPending?>/-</b></td>
                                                            <td class="numeric"><b><?//=$TotalRoundTotal?></b></td>
                                                            <td class="numeric"><b><?//=$TotalRoundTotal?></b></td>
														
														
														</tr>
													</tbody>
													
													</table>
												    <?php
													$FinalPayment="";
													?>
												</div>
										</div>
											</div>

																		
					
					
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