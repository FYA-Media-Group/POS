<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Petty Cash | Nailspa";
	$strDisplayTitle = "Petty Cash | Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblExpenses";
	$strMyTableID = "ExpenseID";
	$strMyActionPage = "PettyCashAudit.php";
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
			





	      
			$Amount = Filter($_POST["Amount"]);
			$ExpenseType = Filter($_POST["ExpenseType"]);
			$DateOfExpense = Filter($_POST["DateOfExpense"]);
	     	$date5 = new DateTime($DateOfExpense);
			$strAppointmentDate6 = $date5->format('Y-m-d'); // 31-07-2012
			$Name = Filter($_POST["Name"]);
	


			$DB = Connect();
			$sql = "Select $strMyTableID from $strMyTable where ExpenseID='$_POST[$strMyField]'";
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
				$sqlInsert = "Insert into $strMyTable (StoreID, ExpenseType, Name, Amount, DateOfExpense, Status) values
				('".$strStore."','".$ExpenseType."', '".$Name."', '".$Amount."', '".$strAppointmentDate6."', '0')";
				// echo $sqlInsert;
				ExecuteNQ($sqlInsert);
				$DB->close();
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
					</div>
				</div>');
			}
        
	echo("<script>location.href='Petty-Cash-Spent-and-Balance.php';</script>");
		
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
		// echo 123;
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
							
				<!--Manage Tab Start-->
				                          <ul>
											<li><a href="#normal-tabs-1" title="Tab 1">Manage</a></li>
										
										</ul>
									<div id="normal-tabs-1">
										<span class="form_result">&nbsp; <br></span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Expenses | Nailspa</h3>
												<form method="get" class="form-horizontal bordered-row" role="form">
													<div class="form-group"><label for="" class="col-sm-4 control-label">Select date for filter</label>
														<div class="col-sm-4">
															<div class="input-prepend input-group">
																<span class="add-on input-group-addon">
																	<i class="glyph-icon icon-calendar"></i>
																</span> 
																<input type="text" name="toandfrom" id="daterangepicker-example" class="form-control" value="<?=$strtoandfrom?>">
															</div>
														</div>
													</div>
												
												
													
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="PettyCashAudit.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														

													</div>
												</form>
												<br>
												
												<?php
													$sql_balance = "SELECT Balance FROM tblExpensesBalance WHERE StoreID='".$strStore."'";
													$RS_balance = $DB->query($sql_balance);
													$row_balance = $RS_balance->fetch_assoc();
													$strAvailableBalance = $row_balance['Balance'];
												?>
												<center><h2>Currently Available Balance : <?=$strAvailableBalance?></h2></center>
												<br>
												<?php
													if(isset($_GET["toandfrom"]))
													{
												?>
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?></h3>
												<?php
													}
												?>
												<br>
												
												
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Expense Type</th>
																<th>Name of Payee</th>
																<th>Amount Spent</th>
																<th>Date Of Expense</th>
															    <th>Status</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Expense Type</th>
																<th>Name of Payee</th>
																<th>Amount Spent</th>
																<th>Date Of Expense</th>
															    <th>Status</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();

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






$sql = "SELECT * FROM ".$strMyTable." where StoreID!='0' $sqlTempfrom $sqlTempto order by ExpenseID desc";
//echo $sql;
$RS = $DB->query($sql);
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
		$sqp=select("*","tblEmployees","EID='".$Name."'");
		$EmployeeName=$sqp[0]['EmployeeName'];
		$ExpenseIDs = EncodeQ($ExpenseID);
		$getUIDDelete = Encode($ExpenseID);		
		$Amount = $row["Amount"];
		
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
																<td><?=$EmployeeName?></td>
																<td><?=$Amount?></td>
																<td><input type="hidden" id="id" value="<?=$ExpenseID?>" /><?=$strRegistrationDate?></td>
																<td style="text-align: center">
																<?php
																if($Status=='0')
																{
																	$abc="OK";
																	?>
																	<?=$abc?><a class="btn btn-link font-blue" href="#" onclick="updateexpensestatus(this)">Make This Expense Void</a>
																	<?php
																}
																else
																{
																	?>
																	<a class="btn btn-link font-blue" href="#" disabled>Void/Mistake</a>
																	<?php
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
														
														<tbody>
														<tr>
															<td colspan="3"><center><b>Total Expenses(s) : <?=$counter?></b><center></td>
															
															<td class="numeric"><b>Rs. <?=$TotalAmount?>/-</b></td>

															<td class="numeric"></td>
															<td class="numeric"></td>
														
														</tr>
													</tbody>

													</table>
												</div>
											</div>
                                        </div>									
<?php
			
?>					
					
				
				
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