<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Average Revenue | Nailspa";
	$strDisplayTitle = "Average Revenue | Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblExpenses";
	$strMyTableID = "ExpenseID";
	$strMyActionPage = "DisplayAvgRevenew.php";
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
												
												<div class="example-box-wrapper">
												   <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example" width="80%">
																			    <thead>
																				  <tr>	
																						<tr>
																						   <th style="text-align:center">Sr</th>
																							<th style="text-align:center">Store</th>
																						   <th style="text-align:center">Total Payment</th>
																						   <th style="text-align:center">Total Customers</th>
																							<th style="text-align:center">Average Revenue</th>
															
															                         </tr>
																				   </thead>
																				    <tbody>
																		<?php
																	$DB = Connect();
																	$First= date('Y-m-01');
																	$Last= date('Y-m-t');
																	$counter = 0;
																	$sqp=select("distinct(StoreID)","tblAppointments","Status='2'");
																	foreach($sqp as $val)
																	{
																		$counter ++;
																		$storrr=$val['StoreID'];
																		$sql="SELECT SUM(tblInvoiceDetails.TotalPayment) as TotalPay, count(tblInvoiceDetails.CustomerID) as TotalCustomers FROM tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='".$storrr."' and Date(OfferDiscountDateTime)>=Date('".$First."') and Date(OfferDiscountDateTime)<=Date('".$Last."')";
																		//echo $sql."<hr>";

																	$RS = $DB->query($sql);
																	if ($RS->num_rows > 0) 
																	{


																		while($row = $RS->fetch_assoc())
																		{
																			
																			$TotalCustomers = $row["TotalCustomers"];
																			$TotalPayment = $row["TotalPay"];
																			$AverageValue=$TotalPayment/$TotalCustomers;
																			$FibalAverage=Round($AverageValue , 2);
																			$CustomerMobileNo = $row["CustomerMobileNo"];
																			$RegDate = $row["RegDate"];
																			$RegDatet = FormatDateTime($RegDate);
																				
																			$sept=select("StoreName","tblStores","StoreID='".$storrr."'");
																			$StoreName=$sept[0]['StoreName'];
																				if($FibalAverage =="")
																			{
																				$FibalAverage ="0.00";
																			}
																			else
																			{
																				$FibalAverage = $FibalAverage;
																			}
																			
																			$FinalPayment += $TotalPayment;
																			$FinalCustomers += $TotalCustomers;
																			$TotalFibalAverage = $FinalPayment / $FinalCustomers;
																			?>
																																<tr id="my_data_tr_<?=$counter?>">
																																	<td><center><?=$counter?></center></td>
																																	<td><center><?=$StoreName?></center></td>
																																	<td class="numeric"><center><?=$TotalPayment?></center></td>
																																	
																																	<td><center><?=$TotalCustomers?></center></td>
																																	<td><center><?=$FibalAverage?></center></td>
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
																	}
?>				
												     </tbody>
												   
																		 </table>
												    <?php
													$TotalAmount="";
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