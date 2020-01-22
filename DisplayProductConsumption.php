<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Product Consumption | Nailspa";
	$strDisplayTitle = "Product Consumption  | Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblExpenses";
	$strMyTableID = "ExpenseID";
	$strMyActionPage = "DisplayProductConsumption.php";
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
						                <table class="table table-bordered table-striped table-condensed cf">

													<thead>
															<tr>
															    <th style="text-align:center">Product Name</th>
																<th style="text-align:center">Product Qty Used<br/>(Consumption Target/Service Done)</th>
																<th style="text-align:center">Services Done<br/>(Total No Of Service Count)</th>
																<th style="text-align:center">Consumption Target<br/>(Per Qty Serve)</th>
																<th style="text-align:center">Consumption Performance<br/>(Per Qty Serve minus Total No Of Service Count)</th>
																<th style="text-align:center">Revenue Generated<br/>(Total Service Sale Amount)</th>
																
																<th style="text-align:center">Cost of Product<br/>(Product MRP divide Total No Of Service Count)</th>
																<th style="text-align:center">Profitability<br/>(Cost of Product minus Revenue Generated)</th>
															    
															</tr>
														</thead>
												
														
														<tbody>

<?php
$DB = Connect();
$First= date('Y-m-01');
$Last= date('Y-m-t');
$getfrom=$First;
$getto=$Last;
$sql=selectproduct($getfrom,$getto);
		
		

	
		foreach($sql as $row)
		{
		$counter ++;
	
		$ProductID = $row["ProductID"];
	    $sep=select("count(*)","tblNewProducts","ProductID='".$ProductID."'");
		$cntserr=$sep[0]['count(*)'];
		if($cntserr>0)
		{
			 $sept=select("*","tblNewProducts","ProductID='".$ProductID."'");
			 $ProductIDT=$sept[0]['ProductID'];
		     $productname=$sept[0]['ProductName'];
			 $PerQtyServe=$sept[0]['PerQtyServe'];
			 $ProductMRP=$sept[0]['ProductMRP'];
			 //$productcost=$ProductMRP*$PerQtyServe;
			 $sepa=select("*","tblStores","StoreID='".$storrr."'");
		     $storename=$sepa[0]['StoreName'];
			 
			 $sqlt=selectproductservice($getfrom,$getto,$ProductIDT);
			 
				foreach($sqlt as $vat)
				{
					$servicedtt = $vat["ServiceID"];
					$stppsertyptup=selectproductservicedetail($getfrom,$getto,$servicedtt);
					foreach($stppsertyptup as $tr)
										{
											$qty=$tr['qty'];
											$ServiceAmount=$tr['ServiceAmount'];
											$qttyt +=$qty;
											$strServiceAmount = $ServiceAmount*$qty;
											$totalstrServiceAmount=$totalstrServiceAmount+$strServiceAmount;
										}
				}
			
				$ProductQtyUsed=$PerQtyServe/$qttyt;
				if($qttyt=="")
				{
					$qttyt=0;
				}
				$consumperformance=$PerQtyServe-$qttyt;
			    $profit=$productcost-$totalstrServiceAmount;
				$productcost=$ProductMRP*$qttyt;
		   if($ProductQtyUsed =="")
			{
				$ProductQtyUsed ="0.00";
			}
			else
			{
			
				$ProductQtyUsed = $ProductQtyUsed;
				
			}
			$TotalProductQtyUsed += $ProductQtyUsed;
			if($qttyt =="")
			{
				$qttyt ="0.00";
			}
			else
			{
			
				$qttyt = $qttyt;
				
			}
			$Totalqttyt += $qttyt;
			if($PerQtyServe =="")
			{
				$PerQtyServe ="0.00";
			}
			else
			{
			
				$PerQtyServe = $PerQtyServe;
				
			}
			$TotalPerQtyServe += $PerQtyServe;
			if($consumperformance =="")
			{
				$consumperformance ="0.00";
			}
			else
			{
			
				$consumperformance = $consumperformance;
				
			}
			$Totalconsumperformance += $consumperformance;
				if($totalstrServiceAmount =="")
			{
				$totalstrServiceAmount ="0.00";
			}
			else
			{
			
				$totalstrServiceAmount = $totalstrServiceAmount;
				
			}
			$TotaltotalstrServiceAmount += $totalstrServiceAmount;
				if($productcost =="")
			{
				$productcost ="0.00";
			}
			else
			{
			
				$productcost = $productcost;
				
			}
			$Totalproductcost += $productcost;
			if($profit =="")
			{
				$profit ="0.00";
			}
			else
			{
			
				$profit = $profit;
				
			}
			$Totalprofit += $profit;
			 ?>														
														
															<tr id="my_data_tr_<?=$counter?>">
															   <td><center><?=$productname?></center></td>
																<td><center><?=ceil($ProductQtyUsed)?></center></td>
																<td><center><?=$qttyt?></center></td>
																
																<td><center><?=$PerQtyServe?></center></td>
																<td><center><?=$consumperformance?></center></td>
																<td><center><?=$totalstrServiceAmount?></center></td>
															    <td><center><?=$productcost?></center></td>
																<td><center><?=$profit?></center></td>
															</tr>
<?php
		}
		$qttyt="";
		$PerQtyServe="";
		$ProductQtyUsed="";
		$consumperformance="";
		$totalstrServiceAmount="";
		$profit="";

	}
	?>
														</tbody>
														<tbody>
															 <tr>
															<td colspan="1"><center><b>Total</b></center></td>
															 <td class="numeric"><center><?=round($TotalProductQtyUsed,2)?></center></td>
															 <td class="numeric"><center><?=$Totalqttyt?></center></td>
															 <td class="numeric"><center><?=$TotalPerQtyServe?></center></td>
															 <td class="numeric"><center><?=$Totalconsumperformance?></center></td>
															 <td class="numeric"><center><?=$TotaltotalstrServiceAmount?></center></td>
															 <td class="numeric"><center><?=$Totalproductcost?></center></td>
															 <td class="numeric"><center><?=$Totalprofit?></center></td>
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