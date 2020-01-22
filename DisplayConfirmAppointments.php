<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Confirmed Appointments";
	$strDisplayTitle = "Confirmed Appointments";
	$strMenuID = "6";
	$strMyTable = "tblExpensesBalance";
	$strMyTableID = "ExpenseBalanceID";
	$strMyActionPage = "DisplayConfirmAppointments.php";
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
										
												<div id="printdata">	
												<br>
											 
												<div class="example-box-wrapper">
														<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																 <th>Sr</th>
																<th>Customer Name</th>
																<th>Store</th>
																<th>Appointment Date</th>
																<th>Appointment Status</th>
															
															</tr>
														</thead>
													
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$First= date('Y-m-01');
$Last= date('Y-m-t');
// echo $strAdminID;
// $FindStore="Select StoreID from tblAdminStore where AdminID=$strAdminID";
// echo $FindStore;
// $RSf = $DB->query($FindStore);
// if ($RSf->num_rows > 0) 
// {
	// while($rowf = $RSf->fetch_assoc())
	// {
		// $strStoreID = $rowf["StoreID"];
		// echo $strStoreID."<br>";
	// }
// }

$sql="Select * from tblAppointments where IsDeleted!='1' and Status='2' and Date(AppointmentDate)>=Date('".$First."') and Date(AppointmentDate)<=Date('".$Last."')";	
		$sty=select("count(AppointmentID)","tblAppointments","IsDeleted!='1' and Status='2' and Status!='0' and Date(AppointmentDate)>=Date('".$First."') and Date(AppointmentDate)<=Date('".$Last."')");
	    $totalapp=$sty[0]['count(AppointmentID)'];


//	$sql = "SELECT * FROM  tblExpenses where Date(tblExpenses.DateOfExpense)>=Date('".$First."') and Date(tblExpenses.DateOfExpense)<=Date('".$Last."') order by ExpenseID desc";


// $sql = "SELECT * FROM ".$strMyTable." where StoreID='".$strStore."' $sqlTempfrom $sqlTempto order by ExpenseID desc";
// echo $sql;
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	// echo "In if <br>";
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		// echo "In while<br>";
		$CustomerID = $row["CustomerID"];
		$StoreID = $row["StoreID"];
		$AppointmentDate = $row["AppointmentDate"];
		$AppointmentDatet = FormatDateTime($AppointmentDate);
		$Staus = $row["Status"];
	    if($Staus=='2')
		{
			$Staus="Done";
			$stydone=select("count(AppointmentID)","tblAppointments","IsDeleted!='1' and Status='2' and StoreID='".$StoreID."' $sqlTempfrom $sqlTempto");
			//print_r($totalapp);
	        $totaldone=$stydone[0]['count(AppointmentID)'];
			
			$todoneappper=($totaldone/$totalapp)*100;
		}
		elseif($Staus=='6')
		{
			$Staus="Re-scheduled";
			$stydone1=select("count(AppointmentID)","tblAppointments","IsDeleted!='1' and Status='6' and StoreID='".$StoreID."' $sqlTempfrom $sqlTempto");
	        $totaldonere=$stydone1[0]['count(AppointmentID)'];
			$todoneapppreer=($totaldonere/$totalapp)*100;
		}
		elseif($Staus=='3')
		{
			$Staus="Cancelled";
			$stydone2=select("count(AppointmentID)","tblAppointments","IsDeleted!='1' and Status='3' and StoreID='".$StoreID."' $sqlTempfrom $sqlTempto");
	        $totaldonerecan=$stydone2[0]['count(AppointmentID)'];
			$todoneapppreercan=($totaldonerecan/$totalapp)*100;
		}
		
		$CustData="Select * from tblCustomers where CustomerID=$CustomerID";
		$RScust = $DB->query($CustData);
		if ($RScust->num_rows > 0) 
		{

			while($rowcust = $RScust->fetch_assoc())
			{
				$CustomerFullName = $rowcust["CustomerFullName"];
				$CustomerEmailID = $rowcust["CustomerEmailID"];
				$CustomerMobileNo = $rowcust["CustomerMobileNo"];
			}
		}
		
		$dateObject = new DateTime($AppointmentDate);
		
	    $selp=select("StoreName","tblStores","StoreID='".$StoreID."'");
		$StoreName=$selp[0]['StoreName'];
	
	
		
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$CustomerFullName?></td>
																<td><?=$StoreName?></td>
																<td><?=$AppointmentDatet?></td>
																<td><?=$Staus?></td>
																
																
																
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