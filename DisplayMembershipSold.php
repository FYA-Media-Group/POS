<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Membership | Nailspa";
	$strDisplayTitle = "Membership | Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblExpensesBalance";
	$strMyTableID = "ExpenseBalanceID";
	$strMyActionPage = "DisplayMembershipSold.php";
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
				('".$StoreID."','".$Balance."', now())";
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
	function cleanData($a) {

     if(is_numeric($a)) {

     $a = preg_replace('/[^0-9,]/s', '', $a);
     }

     return $a;

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
						<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="DisplayMembershipSold.php"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
							</br>
						<div class="tabs">
							
				<!--Manage Tab Start-->
				                       
										

									
								
										<span class="form_result">&nbsp; <br></span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Membership Sold | Nailspa</h3>
									
												
												
												<div class="example-box-wrapper">
													<table id="datatable-responsiveb" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Store Name</th>
																<th>Customer</th>
																<th>Membership</th>
																<th>Amount</th>
																
															</tr>
														</thead>
													
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$First= date('Y-m-01');
$Last= date('Y-m-t');
$sql="Select * from tblInvoiceDetails WHERE  Date(OfferDiscountDateTime)>='$First' and Date(OfferDiscountDateTime)<='$Last' and Membership_Amount!=''";
//echo $sql;
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		
		$Billaddress = $row["Billaddress"];
		$CustomerFullName=$row['CustomerFullName'];
		$MembershipName=$row['MembershipName'];
		$emm=explode(",",$MembershipName);
		$emmmmm=array_unique($emm);
		$Membership_Amount=$row['Membership_Amount'];
        $memamtfirst = explode(",", $Membership_Amount);

		
		$memamtfirst=str_replace("+", "", $Membership_Amount);
		$memamtfirst=str_replace(".00", "", $memamtfirst);
	    $memamtfirst=str_replace(".", "", $memamtfirst);

		$memamtfirst=str_replace(",", "", $memamtfirst);
	
		 if($memamtfirst=='')
				{
					$memamtfirst="0.00";
				}
		//echo $memamtfirst."<br/>";
		$Totalmemamtfirst += $memamtfirst;
						
		
		
?>	
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$Billaddress?></td>
																<td><?=$CustomerFullName?></td>
																<td><?=$MembershipName?></td>
																<td class="numeric"><center><?=$memamtfirst?></center></td>
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
															<td></td>
															<td></td>
															
															<td class="numeric"><center><b>Rs. <?=$Totalmemamtfirst?>/-</center></b></td>
														
														</tr></tbody>
														
														

													</table>
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