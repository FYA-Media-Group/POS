<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Bill Reconciliation Report| Nailspa";
	$strDisplayTitle = "Bill Reconciliation Report| Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblExpensesBalance";
	$strMyTableID = "ExpenseBalanceID";
	$strMyActionPage = "ReportBillReconciliation.php";
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
												<h3 class="title-hero">List of Bills | Nailspa</h3>
												<form method="get" class="form-horizontal bordered-row" role="form">
													<div class="form-group"><label for="" class="col-sm-4 control-label">Select Bill date</label>
														<div class="col-sm-4">
															<div class="input-prepend input-group">
																<span class="add-on input-group-addon">
																	<i class="glyph-icon icon-calendar"></i>
																</span> 
																<input type="text" name="toandfrom" id="daterangepicker-example" class="form-control" value="<?=$strtoandfrom?>">
															</div>
														</div>
													</div>
												    	<div class="form-group"><label for="" class="col-sm-4 control-label">Select Store</label>
														<div class="col-sm-4">
														
							               <select name="store" class="form-control">
																<option value="0">All</option>
																<?
                                                    $selp=select("*","tblStores","Status='0'");
													foreach($selp as $val)
													{
														$strStoreName = $val["StoreName"];
														$strStoreID = $val["StoreID"];
														$store=$_GET["store"];
														if($store==$strStoreID)
														{
															?>
														<option  selected value="<?=$strStoreID?>" ><?=$strStoreName?></option>														
<?php                   
														}
														else
														{
															?>
														<option value="<?=$strStoreID?>" ><?=$strStoreName?></option>														
<?php                   
														}

													}
?>
															</select>
		
												</div>
															
														</div>
												
												
													
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportBillReconciliation.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														<?php
													$datedrom=$_GET["toandfrom"];
													if($datedrom!="")
													{
														   ?>
														<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
														<?php
													   }
														?>

													</div>
												</form>
												<div id="printdata">	
												<h2 class="title-hero" id="heading" style="display:none"><center>Report Bill Reconciliation</center></h2>
												<br>
													
												<?php
													$datedrom=$_GET["toandfrom"];
													if($datedrom!="" && !IsNull($_GET["store"]))
													{
														$storrr=$_GET["store"];
													if($storrr=='0')
													{
														$storrrp='All';
													}
													else{
													$stpp=select("StoreName","tblStores","StoreID='".$storrr."'");
				                                   $StoreName=$stpp[0]['StoreName'];
														$storrrp=$StoreName;
													}
												?>
												
														<h3 >Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?> / Store - <?=$storrrp?></h3>
												
												<br>
												
												
												<div class="example-box-wrapper">
													<table  class="table table-striped table-bordered responsive no-wrap printdata" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
											                    <th>Store Name</th>
																<th>Customer Name</th>
																<th>Bill Date</th>
																<th>Bill Amount</th>
															    <th>Employee Name</th>
																
															</tr>
														</thead>
													
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$storrr=$_GET["store"];
if(!empty($storrr))
{
$sql="select tblAppointments.AppointmentID,tblInvoiceDetails.CustomerFullName, tblInvoiceDetails.RoundTotal, tblAppointments.StoreID,tblInvoiceDetails.OfferDiscountDateTime
from tblAppointments 
left join tblInvoiceDetails on
tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentId
where tblAppointments.IsDeleted!='1' and tblAppointments.StoreID='".$storrr."' and tblInvoiceDetails.OfferDiscountDateTime!='NULL' and tblInvoiceDetails.AppointmentId!='NULL' and Status='2' $sqlTempfrom $sqlTempto";
}
else
{
$sql="select tblAppointments.AppointmentID,tblInvoiceDetails.CustomerFullName, tblInvoiceDetails.RoundTotal, tblAppointments.StoreID,tblInvoiceDetails.OfferDiscountDateTime
from tblAppointments 
left join tblInvoiceDetails on
tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentId
where tblAppointments.IsDeleted!='1' and tblInvoiceDetails.OfferDiscountDateTime!='NULL' and tblInvoiceDetails.AppointmentId!='NULL' and Status='2' $sqlTempfrom $sqlTempto";
}

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$CustomerFullName = $row["CustomerFullName"];
		$AppointmentID = $row["AppointmentID"];
		
		$RoundTotal = $row["RoundTotal"];
		$OfferDiscountDateTime = $row["OfferDiscountDateTime"];
		$MECID = $row["MECID"];
		
		$StoreID = $row["StoreID"];
			
		$sep=select("*","tblStores","StoreID='".$StoreID."'");
		$storename=$sep[0]['StoreName'];
		
	
		
		$sepu=select("distinct(MECID)","tblAppointmentAssignEmployee","AppointmentID='".$AppointmentID."'");
		foreach($sepu as $vat)
		{
			if($vat!="")
			{
				$empid[]=$vat['MECID'];
			}
			else
			{
				$empid[]=null;
			}
			// $empid[]=$vat['MECID'];
			// echo $AppointmentID."&nbsp &nbsp";
			// print_r($empid);
			// echo "<br>";
			// echo "<br>";
			
		}
		
		// if($empid!="")
		// {
			$etp=array_unique($empid);
		// }
		// else
		// {
			// $etp="---";
		// }
		
		
		unset($empid);
		// echo $AppointmentID."&nbsp &nbsp";
		// print_r($etp);
		// echo "<br>";
		// echo "<br>";
		
		if($RoundTotal =="")
		{
			$RoundTotal ="0.00";
		}
		else
		{
		
			$RoundTotal = $RoundTotal;
			
		}
		$TotalRoundTotal += $RoundTotal;
	
		
		$strdate = FormatDateTime($OfferDiscountDateTime);
	
		
		
?>	
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$storename?></td>
																<td><?=$CustomerFullName?><br><?=$AppointmentID?></td>
																<td><?=$strdate?></td>
																<td><?="Rs. ".$RoundTotal?></td>
																<td>
<?																
																		
																			for($t=0;$t<count($etp);$t++)
																			{
																				$sepup=select("*","tblEmployees","EID='".$etp[$t]."'");
																				$EmployeeName=$sepup[0]['EmployeeName'];
																				$emp=$EmployeeName.",";
																				$emps=trim($emp,",");
																			?>
																			<table id="di"><tr><td><?=$emps?></td></tr></table>
																			<?
																			}
																		
?>
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
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td class="numeric"><b>Rs. <?=$TotalRoundTotal?>/-</b></td>
															<td></td>
														</tr>
													</tbody>
														<?php 
													}
													else
													{
														echo "<br><center><h3>Please Select Month sAnd Year!</h3></center>";
													}
														?>

													</table>
												    <?php
													$TotalRoundTotal="";
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