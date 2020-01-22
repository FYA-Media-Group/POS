<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Manage Gift Voucher Amount| Nailspa";
	$strDisplayTitle = "Manage Gift Voucher Amount| Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblOrder";
	$strMyTableID = "OrderID";
	$strMyActionPage = "ManageGiftVoucherAmount.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
	
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
// code for not allowing the normal admin to access the super admin rights	

	?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	
</head>
<script>
$(document).ready(function(){
var store=$("#storeid").val();
				
			   if(store!="")
			   {
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
			   }
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
function updatevalues(evt)
	{
		
			var stock=$(evt).closest('td').prev().html();
		
		if(stock!="0" && stock!="")
		{
			$.ajax({
				type:"post",
				data:"stock="+stock,
				url:"AddGVAmount.php",
				success:function(result)
				{
			
				if($.trim(result)=='3')
				{
					alert('Amount Added Successfully')
				 window.location="ManageGiftVoucherAmount.php";
				}
				else if($.trim(result)=='2')
				{
					alert('Invalid Amount')
				window.location="ManageGiftVoucherAmount.php";
				}
				else if($.trim(result)=='4')
				{
					alert('Amount Already Added')
				window.location="ManageGiftVoucherAmount.php";
				}
				}
				
				
			})
		}
		else
		{
			alert('Amount Cannot Be Empty')
		}
	}
	function deletevalues(evt)
	{
			var id=$(evt).closest('td').prev().prev().find('input').val();
	if(id!="0")
		{
			$.ajax({
				type:"post",
				data:"id="+id,
				url:"DeleteGvAmount.php",
				success:function(result)
				{
		 if($.trim(result)=='2')
				{
					alert('Deleted Successfully')
				window.location="ManageGiftVoucherAmount.php";
				}
				
				}
				
				
			})
		}
	}
	
	function sendorderrequest()
	{
			if (confirm('Are you sure you want to place this order?')) {
				idd=[];
				var idd=$(".orderstockid").val();
			alert(idd)
			
				$.ajax({
				url: "orderconfirm.php",
				type: 'post',
				data: {
						id:idd
						
					},
				success:function(msg)
				{
			
				if($.trim(msg)=='4')
						{
						  $msg = "Order Request Place Successfully";		     
						window.location="manageorders.php"; 
						} 
						
						
				}
			
				
			   
			   });
			
	 
			
		}
			 else {
				// Do nothing!
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
		$order = $_GET['order'];

		$strIDs = DecodeQ($strID);
		$sql_store = "SELECT StoreName FROM tblStores WHERE 1";
		$RS_store = $DB->query($sql_store);
		$row_store = $RS_store->fetch_assoc();
		$strStoreName = $row_store['StoreName'];
		
	?>

					<div class="example-box-wrapper">
						<div class="tabs">
							
				<!--Manage Tab Start-->
				
				
				
				<div id="normal-tabs-2">
					<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="pendingorders.php"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
					
					
					
											<div class="panel-body ">
											
											
												<form role="form" id="printcontent" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', ''); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
										
											
												<div class="panel-body">
												
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
															
																<th>Gift Voucher Amount</th>
															     <th>Action</th>
																
															</tr>
														</thead>
													
											<tbody>
                                            <tr id="my_data_tr_<?=$counter?>">
												<td contenteditable='true' id="orderstock"></td>
													<td><a class="btn btn-link" href="#" onclick="updatevalues(this)">Add Amount</a></td>
													

												
												</tr>
<!--TAB 2 START-->											
											</tbody>
													</table>
												</div>
													
											</div>
											<div class="panel-body">
												
												<div class="example-box-wrapper">
												<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
															
																<th>Gift Voucher Amount</th>
															    <th>Gift Voucher Date</th>
																		<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
																<th>Action</th>
																<?php
																	}
																?>
															</tr>
														</thead>
													
											<tbody>
										
											<?php
														$selpk=select("*","tblGiftVoucherAmount","1");
														
														foreach($selpk as $vapq)
														{
															if($vapq['GiftVoucherAmount']!="")
															{
																$DateOfAttendanceT = $vapq['DateTimeStamp'];
																?>
															  <tr id="my_data_tr_<?=$counter?>">
												             <td><input type="hidden" id="id" value="<?=$vapq['GiftVoucherAmountID']?>" ><?=$vapq['GiftVoucherAmount']?></td>
															 <td><?=$DateOfAttendanceT?></td>
															 		<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
															<td><a class="btn btn-link" href="#" onclick="deletevalues(this)">Delete</a></td>
															<?php 
																	}
															?>
												             </tr>
															<?php
															}
															
														}
														?>
											
                                          
<!--TAB 2 START-->											
											</tbody>
													</table>
													</div>
																	<div class="example-box-wrapper">
									<b><center>Gift Voucher Validity :</center></b><br/>
									<table id="printdata" class="table table-bordered table-striped table-condensed cf">
									<thead class="cf">
									<tr>
									<th>Sr</th>
									<th>Amount</th>
									<th>Validity</th>
									</tr>
									</thead>
									<tbody>
									<tr><td>1</td><td>Upto 3k</td><td>1 month</td></tr>
									<tr><td>2</td><td>3k to 10k</td><td>2 months</td></tr>
									<tr><td>3</td><td>10k to 20k</td><td>3 month</td></tr>
									<tr><td>4</td><td>30k to 50k</td><td>6 month</td></tr>
									<tr><td>5</td><td>50k & above</td><td>1 year</td></tr>
									</tbody>
									</table>
								
									</div>
											</div>
											 
											</form>
											
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