<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Petty Cash | Nailspa";
	$strDisplayTitle = "Petty Cash | Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblExpenses";
	$strMyTableID = "ExpenseID";
	$strMyActionPage = "Petty-Cash-Spent-and-Balance.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
	
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
			$PayeeID = Filter($_POST["PayeeID"]);
			$Store = Filter($_POST["StoreID"]);
			$Remark = Filter($_POST["Remark"]);
			// echo $Remark."<br>";
	
			// die();

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
				if($Amount=='0' || $Amount=='')
				{
						die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Amount Cannot Blank</h4>
					</div>
				</div>');
				}
				else
				{
					// $sqlInsert = "Insert into $strMyTable (StoreID, ExpenseType, Name, Amount, DateOfExpense, Status) values
				// ('".$strStore."','".$ExpenseType."', '".$Name."', '".$Amount."', '".$strAppointmentDate6."', '0')";
				// $sqlInsert = "Insert into $strMyTable (StoreID, ExpenseType, Name,PayeeID, Amount, DateOfExpense, Status) values
				// ('".$strStore."','".$ExpenseType."', '".$Name."', '".$PayeeID."', '".$Amount."', '".$strAppointmentDate6."', '0')";
				// echo $sqlInsert;
				if($strAdminRoleID=='39' || $strAdminRoleID=='38')
				{
					$sqlInsert = "Insert into $strMyTable (StoreID, ExpenseType, Name,PayeeID, Amount, DateOfExpense, Remark, Status) values
					('".$Store."','".$ExpenseType."', '".$Name."', '".$PayeeID."', '".$Amount."', '".$strAppointmentDate6."', '".$Remark."', '0')";
					// echo $sqlInsert;
				}
				else
				{
					$sqlInsert = "Insert into $strMyTable (StoreID, ExpenseType, Name,PayeeID, Amount, DateOfExpense, Remark, Status) values
					('".$strStore."','".$ExpenseType."', '".$Name."', '".$PayeeID."', '".$Amount."', '".$strAppointmentDate6."','".$Remark."', '0')";
					//echo $sqlInsert;
				}
				ExecuteNQ($sqlInsert);
				// echo $sqlInsert;
				// die();
				$DB->close();
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
					</div>
				</div>');
				}
				
				
			}
        
			echo("<script>location.href='Petty-Cash-Spent-and-Balance.php';</script>");
		
		}
		if($strStep=="addPayee")
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
			
			$PayeeName = Filter($_POST["PayeeName"]);
			// echo $PayeeName."<br>";
			$Status = Filter($_POST["Status"]);
			// echo $Status."<br>";
			// $DateOfExpense = Filter($_POST["DateOfExpense"]);
	     	// $date5 = new DateTime($DateOfExpense);
			// $strAppointmentDate6 = $date5->format('Y-m-d'); // 31-07-2012
			// $Name = Filter($_POST["Name"]);
	


			$DB = Connect();
			$sql = "Select PayeeName from tblPayeee where PayeeID='$_POST[$PayeeID]'";
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
				$sqlInsert = "Insert into tblPayeee (PayeeName, Status) values
				('".$PayeeName."','".$Status."')";
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
        
			// echo("<script>location.href='Petty-Cash-Spent-and-Balance.php';</script>");
		
		}
		if($strStep=="addbalance")
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
			
	        $ExpenseBalanceID=$_POST['ExpenseBalanceID'];
	     


	 	$DB = Connect();
			$sql = "Select ExpenseBalanceID from tblExpensesBalance where ExpenseBalanceID='".$ExpenseBalanceID."'";
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
				$sqlInsert = "Insert into tblExpensesBalance (StoreID, Balance, DateTime) values
				('".$StoreID."','".$Balance."', now())";
				
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
			if($strAdminRoleID=='39' || $strAdminRoleID=='38')
			{
				$sqlTempfrom = " Date(DateOfExpense)>=Date('".$getfrom."')";
			}
			else
			{
				$sqlTempfrom = " and Date(DateOfExpense)>=Date('".$getfrom."')";
			}
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
			if($strAdminRoleID=='39' || $strAdminRoleID=='38')
			{
				$sqlTempfrom = "Date(DateOfExpense)>=Date('".$getfrom."')";
			}
			else
			{
				$sqlTempfrom = " and Date(DateOfExpense)>=Date('".$getfrom."')";
			}
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
	<?//=$strAdminRoleID?>

					<div class="example-box-wrapper">
						<div class="tabs">
							
				<!--Manage Tab Start-->
				                        <ul>
											<li><a href="#normal-tabs-1" title="Tab 1">Manage</a></li>
											<li><a href="#normal-tabs-2" title="Tab 2">Add</a></li>
                                            <li><a href="#normal-tabs-3" title="Tab 3">Add Amount</a></li>
											<li><a href="#normal-tabs-4" title="Tab 4">Balance Amount</a></li>
											<li><a href="#normal-tabs-5" title="Tab 4">Add Payee</a></li>
											
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
														<a class="btn btn-link" href="Petty-Cash-Spent-and-Balance.php">Clear All Filter</a>
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
																<th>Remark</th>
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
																<th>Remark</th>
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



if($strAdminRoleID=='39' || $strAdminRoleID=='38')
{
	$sql = "SELECT * FROM ".$strMyTable." where $sqlTempfrom $sqlTempto order by ExpenseID desc";
}
else
{
	$sql = "SELECT * FROM ".$strMyTable." where StoreID='".$strStore."' $sqlTempfrom $sqlTempto order by ExpenseID desc";
}


// $sql = "SELECT * FROM ".$strMyTable." where StoreID='".$strStore."' $sqlTempfrom $sqlTempto order by ExpenseID desc";
// echo $sql;
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
															<td class="numeric"></td>
														
														</tr>
													</tbody>

													</table>
												</div>
											</div>
                                        </div>									
<?php
			
?>					
					
					<div id="normal-tabs-2">
					<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="Petty-Cash-Spent-and-Balance.php"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
					
					          
					
											<div class="panel-body ">
											
											
												<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Petty Cash</h3>
												<div class="example-box-wrapper">
												<script>
		
		function checktype()
		{
		var type=$("#type").val();
		//alert(type)
	
	 if(type!="0")
		{
		$.ajax({
		type:"post",
		data:"type="+type,
		url:"servicecategory.php",
		success:function(res)
		{
	//alert(res)
		var rep= $.trim(res);
			$("#serviceid").show();
			$("#serviceid").html("");
						$("#serviceid").html("");
						$("#serviceid").html(rep);
	
	
	
		}
		
		})
		}
		
		
		}
		
function checkproduct()
			{
				//alert(111)
				//alert(12233)
				valuable=[];
		var valuable = $('#ServiceID').val();
		
		
	//	alert(valuable)
				 $.ajax({
					type: 'POST',
					url: "serviceproduct.php",
					data: {
						id:valuable
						
					},
					success: function(response) {
			//alert(response)
						
						var rep= $.trim(response);
			$("#prodid").show();
			$("#prodid").html("");
						$("#prodid").html("");
						$("#prodid").html(response);
						//asmita1
						/* $("#asmita1").show();
						$("#asmita1").html("");
						$("#asmita1").html(response); */
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$("#prodid").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						//alert (response);
					}
				}); 
			}
			
			function ProdDetails()
			{
				valuable=[];
		var valuable = $('#prodidd').val();
		
		
	//	alert(valuable)
				 $.ajax({
					type: 'POST',
					url: "producthodetails.php",
					data: {
						id:valuable
						
					},
					success: function(response) {
			//	alert(response)
						
						var rep= $.trim(response);
			$("#productdetails").show();
			$("#productdetails").html("");
						$("#productdetails").html("");
						$("#productdetails").html(response);
						//asmita1
						/* $("#asmita1").show();
						$("#asmita1").html("");
						$("#asmita1").html(response); */
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$("#productdetails").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						//alert (response);
					}
				}); 
			}
			</script>
								<script>
		
	$(function () {
    $("#expencedate").datepicker({ minDate: 0 });
	 $("#expencedate").datepicker({ minDate: 0 });
	  
});
</script>									
<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SHOW COLUMNS FROM ".$strMyTable." ";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{
		if($row["Field"]==$strMyTableID)
		{
		}
		else if($row["Field"]=="StoredID")
		{
			
			
		}
		else if($row["Field"]=="StoreID")
		{
			if($strAdminRoleID=='39' || $strAdminRoleID=='38')
			{
				$sql1 = "SELECT * FROM  tblStores WHERE Status='0'";
				$RS2 = $DB->query($sql1);
					if ($RS2->num_rows > 0)
					{
?>											
											<div class="form-group"><label class="col-sm-3 control-label">Store<span>*</span></label>
												<div class="col-sm-3">
													<select class="form-control required"  name="<?=$row["Field"]?>" >
															<option value="" selected>--SELECT Store--</option>
<?
																while($row2 = $RS2->fetch_assoc())
																{
																	$StoreName = $row2["StoreName"];
																	$StoreID = $row2["StoreID"];
?>
																	<option value="<?=$StoreID?>" ><?=$StoreName?></option>														
<?php
																}
?>
													</select>
												</div>
											</div>
<?php
					}
					else
					{
?>				
					<div class="form-group"><label class="col-sm-3 control-label">Store<span>*</span></label>
						<div class="col-sm-3">
<?php					
							echo "Store Not added";
?>					
						</div>
					</div>
<?php					
					}
			}
		}
		else if ($row["Field"]=="PayeeID")
		{
			$sql1 = "SELECT * FROM tblPayeee WHERE Status='0'";
			// echo $sql1;
			$RS2 = $DB->query($sql1);
			if ($RS2->num_rows > 0)
			{
?>					
				<div class="form-group"><label class="col-sm-3 control-label">Pay To<span>*</span></label>
												<div class="col-sm-3">
													<select class="form-control required"  name="<?=$row["Field"]?>" >
															<option value="" selected>--SELECT Payee--</option>
<?
													while($row2 = $RS2->fetch_assoc())
													{
														$PayeeID = $row2["PayeeID"];
														$PayeeName = $row2["PayeeName"];
?>
														<option value="<?=$PayeeID?>" ><?=$PayeeName?></option>														
<?php
													}
?>
														</select>
															</div>
											</div>
<?php
			}
			else
			{
?>				
								<div class="form-group"><label class="col-sm-3 control-label">Pay To<span>*</span></label>
											<div class="col-sm-3">
												
<?
												echo "No Payee Added.<br>Please Add Payee First.";
?>	
											</div>
								</div>
<?php		
			}
		}
		else if ($row["Field"]=="Remark")
		{
?>	                                       <div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Amount", "Amount", $row["Field"])?> <span>*</span></label>
												<div class="col-sm-4"><textarea name="<?=$row["Field"]?>" id="<?=str_replace("Amount", "Amount", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Amount", "Amount", $row["Field"])?>"></textarea>
												</div>
											</div>	
<?php		
			
		}
		else if ($row["Field"]=="Amount")
		{
?>	                                       <div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Amount", "Amount", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="number" name="<?=$row["Field"]?>" id="<?=str_replace("Amount", "Amount", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Amount", "Amount", $row["Field"])?>"></div>
														</div>														
											
<?php

		}
		else if($row["Field"]=="ExpenseType")
		{
		
?>											
											<div class="form-group"><label class="col-sm-3 control-label">For<span>*</span></label>
												<div class="col-sm-3">
													<select class="form-control required"  name="<?=$row["Field"]?>" >
															<option value="" selected>--SELECT Type--</option>

													<option value="0">Product Expense</option>
													<option value="1">Service Expense</option>
													<option value="2">Customer Expense(Birthday cake) </option>
													<option value="3">EmployeeExpense(Employee cake, gift etc)</option>
													<option value="4">General/Others</option>
														</select>
														</div>
														</div>
<?php 
			
		}
	else if($row["Field"]=="DateOfExpense")
		{
			?>
					<div class="form-group"><label class="col-sm-3 control-label">Date <span>*</span></label>
															<div class="col-sm-3">
																<!--<span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span> <input type="text" name="AppointmentDate" id="AppointmentDate" class="bootstrap-datepicker form-control required" value="02/16/12" data-date-format="yy/mm/dd">-->
																
																 <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span> <input type="text" name="expencedate" id="expencedate"  class="form-control" data-date-format="dd/mm/yy" value="<?php echo date('d-m-y');?>"></div>
															</div>
														</div>
			<?php
		}
	
		
	}
?>
														<div class="form-group"><label class="col-sm-3 control-label"></label>
															<input type="submit" class="btn ra-100 btn-primary" value="Submit">
															
															<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
															
																
<?php
}
$DB->close();
?>													
												</div>
												</form>
												<!----------------Display--->
		<script>
		function orderconfirm(evt)
			{
			//alert(1111)
			 var qty=$(evt).closest('td').prev().find('input').val();
			// alert(qty)
			  var stock=$(evt).closest('td').prev().prev().find('input').val();
			  //alert(stock)
			   var prodid=$(evt).closest('td').prev().prev().prev().prev().find('input').val();
			     var prodidstock=$(evt).closest('td').prev().prev().prev().find('input').val();
		//	alert(prodidstock)
		 $valuprod=[];
		$valuservice=[];
		var valuprod = $('#prodidd').val();
		var valuservice = $('#ServiceID').val();
		var store = $('#StoreID').val();
		var catid=$("#type").val();
	//alert(store)

			 if(store!="0" && store!="")
			   {
				      if(prodid!="0")
			      {
				   $.ajax({
					   type:"post",
					   data:"qty="+qty+"&stock="+stock+"&prodid="+prodid+"&catid="+catid+"&valuservice="+valuservice+"&prodidstock="+prodidstock+"&store="+store,
					   url:"addtohoorder.php",
					   success:function(response)
					   {
						  // alert(response)
						   if($.trim(response)=='4')
						   {
							    var p = evt.parentNode.parentNode;
                        p.parentNode.removeChild(p);
						   }
						   else if($.trim(response)=='2')
						   {
							   alert('This Product is already order for this service')
						   }
						   
					   }
					   
				   })
			     }
			   }
			   else
			   {
				   alert('Store Cannot Blank')
			   } 
			
		
			}
		</script>
											</div>
											
											
											
					</div>
<!--variation-->


<!--variation-->
		
					
			
										

				</div>
					<div id="normal-tabs-3">
							<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="Petty-Cash-Spent-and-Balance.php"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
					
					          
					
											<div class="panel-body ">
											
											
												<form role="form" class="form-horizontal bordered-row enquiry_form2" onSubmit="proceed_formsubmit('.enquiry_form2', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="addbalance">

											
												<h3 class="title-hero">Add Balance</h3>
												<div class="example-box-wrapper">
												<script>
		
		function checktype()
		{
		var type=$("#type").val();
		//alert(type)
	
	 if(type!="0")
		{
		$.ajax({
		type:"post",
		data:"type="+type,
		url:"servicecategory.php",
		success:function(res)
		{
	//alert(res)
		var rep= $.trim(res);
			$("#serviceid").show();
			$("#serviceid").html("");
						$("#serviceid").html("");
						$("#serviceid").html(rep);
	
	
	
		}
		
		})
		}
		
		
		}
		
function checkproduct()
			{
				//alert(111)
				//alert(12233)
				valuable=[];
		var valuable = $('#ServiceID').val();
		
		
	//	alert(valuable)
				 $.ajax({
					type: 'POST',
					url: "serviceproduct.php",
					data: {
						id:valuable
						
					},
					success: function(response) {
			//alert(response)
						
						var rep= $.trim(response);
			$("#prodid").show();
			$("#prodid").html("");
						$("#prodid").html("");
						$("#prodid").html(response);
						//asmita1
						/* $("#asmita1").show();
						$("#asmita1").html("");
						$("#asmita1").html(response); */
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$("#prodid").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						//alert (response);
					}
				}); 
			}
			
			function ProdDetails()
			{
				valuable=[];
		var valuable = $('#prodidd').val();
		
		
	//	alert(valuable)
				 $.ajax({
					type: 'POST',
					url: "producthodetails.php",
					data: {
						id:valuable
						
					},
					success: function(response) {
			//	alert(response)
						
						var rep= $.trim(response);
			$("#productdetails").show();
			$("#productdetails").html("");
						$("#productdetails").html("");
						$("#productdetails").html(response);
						//asmita1
						/* $("#asmita1").show();
						$("#asmita1").html("");
						$("#asmita1").html(response); */
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$("#productdetails").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						//alert (response);
					}
				}); 
			}
			</script>
								<script>
		
	$(function () {
    $("#DateTimes").datepicker({ minDate: 0 });
	 $("#DateTimes").datepicker({ minDate: 0 });
	  
});
</script>									
<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SHOW COLUMNS FROM tblExpensesBalance";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{
		
		if($row["Field"]=="ExpenseBalanceID")
		{
		}
		else if($row["Field"]=="StoreID")
		{
			?>
				<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreID", "Store", StoreID)?> <span>*</span></label>
												<div class="col-sm-4">
													<select name="StoreID" class="form-control required"  id="StoreID">
														<option value="">Select Here</option>
														<?php  
													
															$sql_display = "SELECT * FROM tblStores";
															$RS_display = $DB->query($sql_display);
															if ($RS_display->num_rows > 0) 
															{
																while($row_display = $RS_display->fetch_assoc())
																{
																	$StoreName = $row_display["StoreName"];
																	$StoreID = $row_display["StoreID"];
																	
																	?>
																		<option value="<?=$StoreID?>"><?=$StoreName?></option>
																	<?
																	
																}
															}
														?>
													</select>
												</div>
											</div>				
				
<?php
		}
		else if ($row["Field"]=="Balance")
		{
?>	                                       <div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Balance", "Balance", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-4"><input type="number" name="<?=$row["Field"]?>" id="<?=str_replace("Balance", "Balance", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Balance", "Balance", $row["Field"])?>"></div>
														</div>	
											
<?php

		}
		else if($row["Field"]=="DateTime")
		{
			
		}
		else if($row["Field"]=="ExpenseType")
		{
			
		}
	    else if($row["Field"]=="Remark")
		{
			
		}
		else if($row["Field"]=="BrandID")
		{
			
		}
	
		
	}
?>
														<div class="form-group"><label class="col-sm-3 control-label"></label>
															<input type="submit" class="btn ra-100 btn-primary" value="Submit">
															
															<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
															
																
<?php
}
$DB->close();
?>													
												</div>
												</form>
												<!----------------Display--->
		<script>
		function orderconfirm(evt)
			{
			//alert(1111)
			 var qty=$(evt).closest('td').prev().find('input').val();
			// alert(qty)
			  var stock=$(evt).closest('td').prev().prev().find('input').val();
			  //alert(stock)
			   var prodid=$(evt).closest('td').prev().prev().prev().prev().find('input').val();
			     var prodidstock=$(evt).closest('td').prev().prev().prev().find('input').val();
		//	alert(prodidstock)
		 $valuprod=[];
			 $valuservice=[];
		var valuprod = $('#prodidd').val();
		var valuservice = $('#ServiceID').val();
		var store = $('#StoreID').val();
		var catid=$("#type").val();
	//alert(store)

			 if(store!="0" && store!="")
			   {
				   if(prodid!="0")
			      {
				   $.ajax({
					   type:"post",
					   data:"qty="+qty+"&stock="+stock+"&prodid="+prodid+"&catid="+catid+"&valuservice="+valuservice+"&prodidstock="+prodidstock+"&store="+store,
					   url:"addtohoorder.php",
					   success:function(response)
					   {
						  // alert(response)
						   if($.trim(response)=='4')
						   {
							    var p = evt.parentNode.parentNode;
                        p.parentNode.removeChild(p);
						   }
						   else if($.trim(response)=='2')
						   {
							   alert('This Product is already order for this service')
						   }
						   
					   }
					   
				   })
			     }
			   }
			   else
			   {
				   alert('Store Cannot Blank')
			   } 
			
		
			}
			
			function changeamount(evt)
			{
			var id=$(evt).closest('td').prev().prev().prev().find('input').val();
			var bal=$(evt).closest('td').prev().html();
			
			if(bal!="" && bal!="0")
			{
				   $.ajax({
					   type:"post",
					   data:"bal="+bal+"&id="+id,
					   url:"UpdatePettyBalance.php",
					   success:function(response)
					   {
						  
						   if($.trim(response)=='2')
						   {
							   alert('Updated Successfully')
							   location.reload();
						   }
					
						   
					   }
					   
				   })
			}
			else
			{
				alert('Balance Cannot Be Blank')
			} 
		}
		
		function deleteamount(evt)
			{
			var id=$(evt).closest('td').prev().prev().prev().find('input').val();
			var bal=$(evt).closest('td').prev().html();
		
			 if(bal!="" && bal!="0")
			{
				   $.ajax({
					   type:"post",
					   data:"bal="+bal+"&id="+id,
					   url:"DeletePettyBalance.php",
					   success:function(response)
					   {
						   if($.trim(response)=='2')
						   {
							   alert('Deleted Successfully')
							   location.reload();
						   }
					   }
					   
				   })
			}
			else
			{
				alert('Balance Cannot Be Blank')
			}  
		}
		</script>
		</div>
	</div>
<!--variation-->


<!--variation-->
		
					
			
										

				</div>
				<div id="normal-tabs-4">
										<span class="form_result">&nbsp; <br></span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Expenses | Nailspa</h3>
									
												
												
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Store Name</th>
																<th>Balance</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Store Name</th>
																<th>Balance</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();

$sql = "SELECT * FROM tblExpensesBalance where 1 order by ExpenseBalanceID desc";
//echo $sql;
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$StoreID = $row["StoreID"];
		$ExpenseBalanceID = $row["ExpenseBalanceID"];
		$sep=select("*","tblStores","StoreID='".$StoreID."'");
		$storename=$sep[0]['StoreName'];
		$Balance = $row["Balance"];
	
		
		
		
?>	
															<tr id="my_data_tr_<?=$counter?>">
																<td><input type="hidden" id="ExpenseBalanceID" value="<?=$ExpenseBalanceID?>" /><?=$counter?></td>
																<td><?=$storename?></td>
																<td contenteditable="true"><?=$Balance?></td>
																<td><a href="#" id="updateamount" onclick="changeamount(this)">Update</a> <!--/ <a href="#" id="deleteamount" onclick="deleteamount(this)">Delete</a>--></td>
															</tr>
<?php
	}
}
else
{
?>															
															<tr>
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
												</div>
											</div>
                                        </div>
										
										
				<div id="normal-tabs-5">
							<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="Petty-Cash-Spent-and-Balance.php"><i class="fa fa-backward"></i> &nbsp; Go back to <?//=$strPageTitle?></a>
							</div>
					
					          
					
											<div class="panel-body ">
											
											
												<form role="form" class="form-horizontal bordered-row asmita enquiry_form3" onSubmit="proceed_formsubmit('.enquiry_form3', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="addPayee">

											
												<h3 class="title-hero">Add Payee</h3>
												<div class="example-box-wrapper">
												
											
<?php
// Create connection And Write Values
$DB = Connect();
$sqlPayee = "SHOW COLUMNS FROM tblPayeee";
$RSP = $DB->query($sqlPayee);
if ($RSP->num_rows > 0) 
{

	while($row = $RSP->fetch_assoc())
	{
		
		if($row["Field"]=="PayeeID")
		{
		}
		else if($row["Field"]=="PayeeName")
		{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PayeeName", "Payee Name", $row["Field"])?> <span>*</span></label>
												<div class="col-sm-4"><input type="text" style="text-transform:capitalize" style="text-transform:capitalize" name="<?=$row["Field"]?>" id="<?=str_replace("Payee Name", "Payee Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Payee Name", "Payee Name", $row["Field"])?>"></div>
											</div>				
				
<?php
		}
		else if ($row["Field"]=="Status")
		{
?>	                                     				 <div class="form-group"><label class="col-sm-3 control-label"><?=str_replace(																"Status", "Status", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3">
																<select name="<?=$row["Field"]?>" class="form-control required">
																	<option value="0" Selected>Live</option>
																	<option value="1">Offline</option>	
																</select>
															</div>
														</div>	
											
<?php
		}
	
		
	}
?>
														<div class="form-group"><label class="col-sm-3 control-label"></label>
															<input type="submit" class="btn ra-100 btn-primary" value="Submit">
															
															<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity asmita" href="javascript:;" onclick="ClearInfo('enquiry_form3');" title="Clear"><span>Clear</span></a></div>
															
																
<?php
}
$DB->close();
?>													
												</div>
												</form>
												<!----------------Display-->
		<script>
		function orderconfirm(evt)
			{
			//alert(1111)
			 var qty=$(evt).closest('td').prev().find('input').val();
			// alert(qty)
			  var stock=$(evt).closest('td').prev().prev().find('input').val();
			  //alert(stock)
			   var prodid=$(evt).closest('td').prev().prev().prev().prev().find('input').val();
			     var prodidstock=$(evt).closest('td').prev().prev().prev().find('input').val();
		//	alert(prodidstock)
		 $valuprod=[];
			 $valuservice=[];
		var valuprod = $('#prodidd').val();
		var valuservice = $('#ServiceID').val();
		var store = $('#StoreID').val();
		var catid=$("#type").val();
	//alert(store)

			 if(store!="0" && store!="")
			   {
				   if(prodid!="0")
			      {
				   $.ajax({
					   type:"post",
					   data:"qty="+qty+"&stock="+stock+"&prodid="+prodid+"&catid="+catid+"&valuservice="+valuservice+"&prodidstock="+prodidstock+"&store="+store,
					   url:"addtohoorder.php",
					   success:function(response)
					   {
						  // alert(response)
						   if($.trim(response)=='4')
						   {
							    var p = evt.parentNode.parentNode;
                        p.parentNode.removeChild(p);
						   }
						   else if($.trim(response)=='2')
						   {
							   alert('This Product is already order for this service')
						   }
						   
					   }
					   
				   })
			     }
			   }
			   else
			   {
				   alert('Store Cannot Blank')
			   } 
			
		
			}
			
			function changeamount(evt)
			{
			var id=$(evt).closest('td').prev().prev().prev().find('input').val();
			var bal=$(evt).closest('td').prev().html();
			
			if(bal!="" && bal!="0")
			{
				   $.ajax({
					   type:"post",
					   data:"bal="+bal+"&id="+id,
					   url:"UpdatePettyBalance.php",
					   success:function(response)
					   {
						  
						   if($.trim(response)=='2')
						   {
							   alert('Updated Successfully')
							   location.reload();
						   }
					
						   
					   }
					   
				   })
			}
			else
			{
				alert('Balance Cannot Be Blank')
			} 
		}
		
		function deleteamount(evt)
			{
			var id=$(evt).closest('td').prev().prev().prev().find('input').val();
			var bal=$(evt).closest('td').prev().html();
		
			 if(bal!="" && bal!="0")
			{
				   $.ajax({
					   type:"post",
					   data:"bal="+bal+"&id="+id,
					   url:"DeletePettyBalance.php",
					   success:function(response)
					   {
						   if($.trim(response)=='2')
						   {
							   alert('Deleted Successfully')
							   location.reload();
						   }
					   }
					   
				   })
			}
			else
			{
				alert('Balance Cannot Be Blank')
			}  
		}
		</script>
		</div>
	</div>
<!--variation-->


<!--variation-->
		
					
			
										

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