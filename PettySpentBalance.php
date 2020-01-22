<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Petty Spent And Balance";
	$strDisplayTitle = "Petty Spent And Balance";
	$strMenuID = "6";
	$strMyTable = "tblExpenses";
	$strMyTableID = "ExpenseID";
	$strMyActionPage = "PettySpentBalance.php";
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
												<h3 class="title-hero">List of Expenses | Nailspa</h3>
										
												<br>
											 <?php
											 $DB = Connect();
													$sql_balance = "SELECT Balance FROM tblExpensesBalance WHERE StoreID='".$strStore."'";
													$RS_balance = $DB->query($sql_balance);
													$row_balance = $RS_balance->fetch_assoc();
													$strAvailableBalance = $row_balance['Balance'];
												?>
												<center><h2>Currently Available Balance : <?=$strAvailableBalance?></h2></center>
												<br>
												<div class="example-box-wrapper">
													<table  class="table table-striped table-bordered responsive no-wrap printdata" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Expense Type</th>
																<th>Name of Payee</th>
																<th>Amount Spent</th>
																<th>Date Of Expense</th>
																<th>Remark</th>
															</tr>
														</thead>
													     <tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Expense Type</th>
																<th>Name of Payee</th>
																<th>Amount Spent</th>
																<th>Date Of Expense</th>
																<th>Remark</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values

$First= date('Y-m-01');
$Last= date('Y-m-t');

$sql = "SELECT * FROM ".$strMyTable." where StoreID='".$strStore."' and Date(DateOfExpense)>=Date('$First') and Date(DateOfExpense)<=Date('$Last') order by ExpenseID desc";


// $sql = "SELECT * FROM ".$strMyTable." where StoreID='".$strStore."' $sqlTempfrom $sqlTempto order by ExpenseID desc";
// echo $sql;
$RS = $DB->query($sql);
/*  if($_SERVER['REMOTE_ADDR']=="111.119.219.70")
			{
				echo $sql;
			}
			else
			{
				
			}  */
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		
		$ExpenseID = $row["ExpenseID"];
		
		$ExpenseType = $row["ExpenseType"];
	
		if($ExpenseType=='0')
		{
			$ExpenseTypeS="Product Expense";
		}
		elseif($ExpenseType=='1')
		{
			$ExpenseTypeS="Service Expense";
		}
		elseif($ExpenseType=='2')
		{
			$ExpenseTypeS="Customer Expense(Birthday cake)";
		}
		elseif($ExpenseType=='3')
		{
			$ExpenseTypeS="EmployeeExpense(Employee cake, gift etc)";
		}
	   elseif($ExpenseType=='4')
		{
			$ExpenseTypeS="General/Others";
		}
		$Name = $row["Name"];
		$PayeeID = $row["PayeeID"];
		$sqp=select("*","tblPayeee","PayeeID='".$PayeeID."'");
		$PayeeName=$sqp[0]['PayeeName'];
		$ExpenseIDs = EncodeQ($ExpenseID);
		$getUIDDelete = Encode($ExpenseID);		
		$Amount = $row["Amount"];
		$Remark = $row["Remark"];
		// echo $Remark;
		
		if($Amount =="")
		{
			$Amount ="0.00";
		}
		else
		{
		
			$Amount = $Amount;
			
		}
		$TotalAmount += $Amount;
		$DateOfExpense = $row["DateOfExpense"];
		$strRegistrationDate = FormatDateTime($row["DateOfExpense"]);
		$Status = $row["Status"];
		
		
?>	
															<tr id="my_data_tr_<?=$counter?>">
																<td><center><?=$counter?></center></td>
																<td><?=$ExpenseTypeS?></td>
																<td><?=$PayeeName?></td>
																<td><?=$Amount?></td>
																<td><?=$strRegistrationDate?></td>
																<td><input type="hidden" id="id" value="<?=$ExpenseID?>" /><?=$Remark?></td>
															
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
															<td ></td>
															<td class="numeric"><b>Rs. <?=$TotalAmount?>/-</b></td>
															<td></td>
															<td></td>
															
														</tr>
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