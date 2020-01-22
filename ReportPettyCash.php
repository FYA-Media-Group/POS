<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Balance Expenses| Nailspa";
	$strDisplayTitle = "Balance Expenses| Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblExpensesBalance";
	$strMyTableID = "ExpenseBalanceID";
	$strMyActionPage = "ReportPettyCash.php";
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
			
			$Balance = Filter($_POST["Balance"]);
			$StoreID = Filter($_POST["StoreID"]);
			$DateTimett = $_POST["DateTimes"];
	     
	     


			$DB = Connect();
			$sql = "Select $strMyTableID from $strMyTable where ExpenseBalanceID='$_POST[$strMyField]'";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						
					</div>
				</div>');
			}
			else
			{
				$sep=select("count(ExpenseBalanceID)","tblExpensesBalance","StoreID='".$StoreID."'");
				$cnt=$sep[0]['count(ExpenseBalanceID)'];
				if($cnt>0)
				{
					$sept=select("*","tblExpensesBalance","StoreID='".$StoreID."'");
					foreach($sept as $val)
					{
						$oldbal=$val['Balance'];
						$totalbal=$Balance+$oldbal;
						$sqlUpdate = "UPDATE tblExpensesBalance SET Balance='".$totalbal."' WHERE StoreID='".$StoreID."'";
					ExecuteNQ($sqlUpdate);
						$sqlInsert1 = "Insert into tblExpensesBalanceLog (StoreID, Balance, DateTime) values
				('".$StoreID."','".$Balance."',now())";
				// echo $sqlInsert;
				ExecuteNQ($sqlInsert1);
					}
					
				}
				else
				{
					$sqlInsert = "Insert into $strMyTable (StoreID, Balance, DateTime) values
				('".$StoreID."','".$Balance."', '".$strAppointmentDate6."')";
				// echo $sqlInsert;
				ExecuteNQ($sqlInsert);
				$sqlInsert1 = "Insert into tblExpensesBalanceLog (StoreID, Balance, DateTime) values
				('".$StoreID."','".$Balance."', now())";
				// echo $sqlInsert;
				ExecuteNQ($sqlInsert1);
				}
				$DB->close();
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
					</div>
				</div>');
			}
			echo("<script>location.href='ManageExpensesBalance.php';</script>");
		}
		

		if($strStep=="edit")
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
						<p></p>
					</div>
				</div>');
		}
		die();
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
			$sqlTempfrom = " and  Date(DateOfExpense)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(DateOfExpense)<=Date('".$getto."')";
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
			$sqlTempfrom = " and Date(DateOfExpense)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(DateOfExpense)<=Date('".$getto."')";
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
			   
$("#btnPrint").click(function () {
			//alert(111)
            var divContents = $("#printdata").html();
			//alert(divContents)
            var printWindow = window.open('', '', 'height=400,width=800');
          printWindow.document.write('<html><head><title>Product Stock</title>');
      printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
      printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
		
	
	
				
		
		
})
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
<?php
		$DB = Connect();
		$strID = $_GET['id'];

		$strIDs = DecodeQ($strID);
		$sql_store = "SELECT StoreName FROM tblStores WHERE 1";
		$RS_store = $DB->query($sql_store);
		$row_store = $RS_store->fetch_assoc();
		$strStoreName = $row_store['StoreName'];
	?>

					<div class="example-box-wrapper">
						<div class="tabs">

											
											
										<span class="form_result">&nbsp; <br></span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Expenses | Nailspa</h3>
												<form method="get" class="form-horizontal bordered-row" role="form">
													<div class="form-group"><label for="" class="col-sm-4 control-label">Select Expense date</label>
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
														
													<select class="form-control required"  name="store">
															<option value="0" selected>All</option>
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
														<a class="btn btn-link" href="ReportPettyCash.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														<?php
													$datedrom=$_GET["toandfrom"];
													if($datedrom!="")
													{
												?>
														<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
														<?PHP
													}
													?>

													</div>
												</form>
												<br>
													<?php
													$DB = Connect();
													$store=$_GET["store"];
												    if($store!="0")
													{
														
														$sql_balance = "SELECT Balance FROM tblExpensesBalance WHERE StoreID='".$store."'";
													$RS_balance = $DB->query($sql_balance);
													$row_balance = $RS_balance->fetch_assoc();
													$strAvailableBalance = $row_balance['Balance'];
													if($strAvailableBalance =="")
													{
														$strAvailableBalance ="0.00";
													}
													else
													{
													
														$strAvailableBalance = $strAvailableBalance;
														
													}
													$TotalBalance += $strAvailableBalance;
													}
													else
													{
													
													  $selp=select("sum(Balance) as total","tblExpensesBalance","StoreID!='0'");
													
													$TotalBalance=$selp[0]['total'];
														
													}
												
												?>
												<div id="printdata">
												
												<h2 class="title-hero" id="heading" style="display:none"><center>Report Petty Cash</center></h2>
												<br/>
												<center><h2>Currently Available Balance : <?=$TotalBalance?></h2></center>
												<br>
												<?php
													$datedrom=$_GET["toandfrom"];
													if($datedrom!="")
													{
												?>
														<center><h3>Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?></h3></center>
											
												<br>
												
												
												<div class="example-box-wrapper">
													<table class="table table-bordered table-striped table-condensed cf" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
											                    <th>Store Name</th>
																<th>Description</th>
																<!--<th>Expense Type</th>
																<th>Date Of Expense</th>
																<th>Total Balance</th>-->
															    <th>Spent Amount</th>
																<!--<th>Remaining Balance</th>-->
																<th>Date</th>
															</tr>
														</thead>
														
													<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$storrr=$_GET["store"];
if(!empty($storrr))
{

$sql = "SELECT StoreID,Amount,ExpenseType,DateOfExpense, Remark,DateOfExpense,
		(Select Balance from tblExpensesBalance where StoreID=tblExpenses.StoreID and tblExpenses.Status!='1' and tblExpenses.Amount!='NULL' and tblExpenses.StoreID='".$storrr."') as Bal FROM tblExpenses where Amount!='NULL' and StoreID='".$storrr."' and Status!='1' $sqlTempfrom $sqlTempto";
}
else
{
	
$sql = "SELECT StoreID,Amount,ExpenseType,DateOfExpense,Remark,DateOfExpense,
		(Select Balance from tblExpensesBalance where StoreID=tblExpenses.StoreID and tblExpenses.Status!='1' and tblExpenses.Amount!='NULL' and tblExpenses.StoreID!='0') as Bal FROM tblExpenses where Amount!='NULL' and StoreID!='0' and Status!='1' $sqlTempfrom $sqlTempto";
}
// echo $sql."<br>";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		
		$StoreID = $row["StoreID"];
			
		$sep=select("*","tblStores","StoreID='".$StoreID."'");
		$storename=$sep[0]['StoreName'];
		
		
		$Amount = $row["Amount"];
		$DateOfExpenses = Date($row["DateOfExpense"]);
		// $DateOfExpensesTime = Time($row["DateOfExpense"]);
		$Bal = $row["Bal"];
		  if($Bal =="")
		{
			$Bal ="0.00";
		}
		else
		{
		
			$Bal = $Bal;
			
		}
		$TotalBalances += $Bal;
		$remain=$Bal-$Amount;
		if($Amount =="")
		{
			$Amount ="0.00";
		}
		else
		{
		
			$Amount = $Amount;
			
		}
		$TotalAmount += $Amount;
	  
		 if($remain =="")
		{
			$remain ="0.00";
		}
		else
		{
		
			$remain = $remain;
			
		}
		$TotalRemain += $remain;
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
		$DateOfExpense = $row["DateOfExpense"];
		$Remark = $row["Remark"];
		// $strRegistrationDate = FormatDateTime($DateOfExpense);
		
		$DateTime = FormatDateTime($DateOfExpenses);
		// $DateTime1 = FormatDateTime($getto);
				$Timed=Time(DateOfExpenses);
		$Day = date('D', strtotime($DateOfExpenses));
		$Timenew=date("H:i:s",strtotime($DateOfExpenses)); // output 11:45:45
		// echo $nameOfDay;
			
?>	
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$storename?></td>
																<td><?=$Remark?></td>
																<!--<td><?=$ExpenseTypeS?></td>
																<td><?=$strRegistrationDate?></td>
																<td><?=$Bal?></td>-->
																<td>Rs. <?=$Amount?>/-</td>
																<td><?=$Day?>, <?=$DateTime?></td>
																<!--<td><?=$remain?></td>-->
															
																		
																
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
$DB->close();
?>
														
													</tbody>
													<tbody>
														<tr>
															<td colspan="2"><center><b>Total No of Expenses(s) : <?=$counter?></b><center></td>
															<td></td>
															<td class="numeric"><b>Rs. <?=$TotalAmount?>/-</b></td>
															<td></td>
														</tr>
													</tbody>
														

													</table>
													<?php 
													$TotalBalances="";
													?>
												</div>
												</div>
													<?PHP
												}	
													else
														{
															echo "<br><center><h3>Please Select Month And Year!</h3></center>";
														}	
														?>
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