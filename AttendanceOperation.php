<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Attendance Of Employee";
	$strDisplayTitle = "Petty Cash";
	$strMenuID = "6";
	$strMyTable = "tblExpensesBalance";
	$strMyTableID = "ExpenseBalanceID";
	$strMyActionPage = "Attendance Of Employee";
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
													<table class="table table-bordered table-striped table-condensed cf" width="100%">
													<thead class="cf">
														<tr>
															<!--<th>Code</th>-->
															<th>Employee Name</th>
															<th>Day & Date</th>
															<th>Check In</th>
															<th>Check Out</th>
															<!--<th>Store</th>-->
															
														
															
														</tr>
													</thead>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$First= date('Y-m-01');
$Last= date('Y-m-t');

$sqlservice = "SELECT DISTINCT(tblEmployeesRecords.EmployeeCode), tblEmployees.EmployeeName,tblEmployees.StoreID, tblEmployeesRecords.DateOfAttendance, tblEmployeesRecords.LoginTime,tblEmployeesRecords.LogoutTime
					FROM `tblEmployees` left join tblEmployeesRecords 
					on tblEmployees.EmployeeCode=tblEmployeesRecords.EmployeeCode
					where tblEmployeesRecords.DateOfAttendance!='null' and tblEmployeesRecords.DateOfAttendance!='NULL' and tblEmployeesRecords.EmployeeCode!='NULL' and Date(tblEmployeesRecords.DateOfAttendance)>=Date('".$First."') and Date(tblEmployeesRecords.DateOfAttendance)<=Date('".$Last."') and tblEmployeesRecords.LoginTime!='00:00:00' ORDER BY tblEmployeesRecords.DateOfAttendance DESC";
// $sql = "SELECT * FROM ".$strMyTable." where StoreID='".$strStore."' $sqlTempfrom $sqlTempto order by ExpenseID desc";

$RS = $DB->query($sqlservice);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($rowservice = $RS->fetch_assoc())
	{
		        $strqty = "";
				$strServiceAmount = "";	
				$strOfferAmount = "";
				$strMembershipAmount = "";
				$strServiceNet2 = "";
				$strServiceNet = "";
				$tpcostt = "";
				$product_cost ="";
				$counterservice ++;
				$EmployeeCode = $rowservice["EmployeeCode"];
				$EmployeeName = $rowservice["EmployeeName"];
			
				$DateOfAttendance = $rowservice["DateOfAttendance"];
				$DateOfAttendanceT = FormatDateTime($DateOfAttendance);
				$weekday = date('l', strtotime($DateOfAttendanceT));
				
				$LoginTime = $rowservice["LoginTime"];
				$LogoutTime = $rowservice["LogoutTime"];
				
				$StoreID = $rowservice["StoreID"];
				$stpp=select("StoreName","tblStores","StoreID='".$StoreID."'");
				$StoreName=$stpp[0]['StoreName'];
			
			     if($LoginTime!='00:00:00')
				 {
					 	 $LoginTimet=date('h:i:s A', strtotime($LoginTime));
				 }
				 else
				 {
					 	 $LoginTimet="00:00:00";
				 }
			
				if($LogoutTime!='00:00:00')
				 {
					 	 $LogoutTimet=date('h:i:s A', strtotime($LogoutTime));
				 }
				 else
				 {
					 	 $LogoutTimet="00:00:00";
				 }
				

?>							
									
							
								<tr>
									<!--<td><?=$EmployeeCode?></td>-->
									<td><?=$EmployeeName?></td>
									<td><?=$weekday?>&nbsp; &nbsp;<?=$DateOfAttendanceT?></td>
									<td><?=$LoginTimet?></td>
									<td><?=$LogoutTimet?></td>
									<!--<td><?=$StoreName?></td>-->
									
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