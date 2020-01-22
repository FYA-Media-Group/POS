<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Invoice | Nailspa";
	$strDisplayTitle = "Invoice for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblAppointmentlog";
	$strMyTableID = "id";
	$strMyActionPage = "appointment_invoice.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
//error_reporting(E_ALL);
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
</head>
  <script type="text/javascript">
  $(document).ready(function(){
	  $("#payment").hide();
	  
	 //alert(222)
	   $("#btnPrint").click(function () {
			//alert(111)
            var divContents = $("#dvContainer").html();
            var printWindow = window.open('', '', 'height=400,width=800');
          printWindow.document.write('<html><head><title>Invoice</title>');
      printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
      printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
		$("#cash").click(function(){
			
			var test=$("#cash").val();
			//alert(test)
			if(test=='cash')
			{
				$("#displaytext").html('Cash');
				 $("#payment").show();
				
			}
			
			
		});
		$("#card").click(function(){
			
			var test=$("#card").val();
		//	alert(test)
			if(test=='card')
			{
				$("#displaytext").html('Card');
				$("#payment").show();
				
			}
			
		});
		$("#hold").click(function(){
			
			
			var test=$("#hold").val();
			//alert(test)
			if(test=='hold')
			{
				$("#displaytext").html('Hold');
				$("#payment").show();
				
			}
		});
		//alert(number);
	
	  
  });
  function test()
  {
	  //alert(111)
	 var abc = $("#paymentid").val();
	// alert(abc)
	 $("#totalpayment").html(abc);
  }
  function test1(evt)
  {
	
	  // var otherInputs = $(evt).parent().parent().find('.quantity').val();
	  var qty = $(evt).val();
//	 alert(qty)
	      
		 
		 // alert(value)
		  if(qty!="")
		  {
			  var valuef = $(evt).closest('td').next().find('input').val();
			  alert(qty)
			 alert(valuef)
			 var totalamt = parseFloat(qty) * parseFloat(valuef);
			 alert(totalamt)
			// var ttmt=toFixed(totalamt,2);
			$("#servicecst").val(totalamt);
			  // $(evt).closest('td').next().find('.servicecst').val(totalamt);
		  }
		
		 // alert(value)
  }
 function checkinsert(evt)
 {
	 var serviceid=$(evt).closest('td').prev().prev().find('input').val();
	// alert(serviceid);
	var app_id=$("#appointment_id").val();
	//alert(app_id)
	if(serviceid!="")
	{
		$.ajax({
			type:"post",
			data:"serviceid="+serviceid+"&app_id="+app_id,
			url:"insertservice.php",
			success:function(res)
			{
				//alert(res)
				if($.trim(res)=='2')
				{
				 window.location="appointment_invoice.php?uid="+app_id;
				}
			}
			
		})
	}
	 
 }
 function checkdelete(evt)
 {
	  var serviceid=$(evt).closest('td').prev().prev().prev().find('input').val();
	//alert(serviceid);
	var app_id=$("#appointment_id").val();
	//alert(app_id)
	if(serviceid!="")
	{
		$.ajax({
			type:"post",
			data:"serviceid="+serviceid+"&app_id="+app_id,
			url:"deleteservice.php",
			success:function(res)
			{
				//alert(res)
				if($.trim(res)=='2')
				{
				 window.location="appointment_invoice.php?uid="+app_id;
				}
			}
			
		})
	}
	
 }
       
    </script>
<style>
.btn-success
{
	background-color:lightgreen;
	color:black;
	
}
.btn-success:hover
{
	background-color:lightgreen;
		color:black;
}
</style>
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
					

  <?php                  
if(isset($_GET['uid']))
{
	$DB = Connect();
$counter = 0;
$strID = DecodeQ(Filter($_GET['uid']));
	?>
	             <div class="panel">
						<div class="panel-body">
							<div class="fa-hover">	
								<a href="javascript:window.location = document.referrer;" class="btn btn-primary btn-lg btn-block"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
						
						
						<div class="panel-body col-md-4">
                               
                                    <div class="example-box-wrapper">
                                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable-example">
                                            <thead>
                                                <tr>
                                                    <th>Sr</th>
                                                    <th>Service</th>
                                                    <th>Cost</th>
													<th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
											<?php 
											$seld=select("*","tblServices","1");
											foreach($seld as $val)
											{
												$counter ++;
												?>
												   <tr id="my_data_tr_<?=$counter?>">
                                                    <td style="text-align: center"><?=$counter?></td>
                                                    <td><?php echo $val['ServiceName'] ?>
													<input type="hidden" id="serviceid" value="<?php echo $val['ServiceID'] ?>" />
													</td>
                                                    <td class="center"><?php echo $val['ServiceCost'] ?></td>
													<td class="center">
													
													<a id="insertservice" href="#" onClick="checkinsert(this)">Insert</td>
                                                  </tr>
												<?php
											}
											?>
											
                                             
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
										<div class="panel-body col-md-8">
                               
                                    <div class="example-box-wrapper">
                                       <table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody>
        <tr>
            <td>
                <table border="0" cellspacing="0" cellpadding="0" width="800" align="center">
                    <tbody>
                        
                        <tr>
                            <td>
                                <table style="BORDER-BOTTOM:#d0ad53 1px solid;BORDER-LEFT:#d0ad53 1px solid;BORDER-TOP:#d0ad53 1px solid;BORDER-RIGHT:#d0ad53 1px solid;" border="0" cellspacing="0" cellpadding="0" width="800" bgcolor="#ffffff" align="center">
                                    <tbody>
									<?php
										$seldp=select("*","tblAppointments","AppointmentID='".$_GET['uid']."'");
									$seldpd=select("StoreBillingAddress","tblStores","StoreID='".$seldp[0]['StoreID']."'");
									$seldpde=select("InvoiceID","tblInvoice","AppointmentID='".$_GET['uid']."'");
									$seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
									
								
									?>
                                        <tr>
										<input type="hidden" id="appointment_id" value="<?php echo $_GET['uid'] ?>" />
                                            <td align="middle">
                                                <table border="0" cellspacing="0" cellpadding="0" width="790" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td width="290" align="left" style="padding:1%;"><img border="0" src="http://nailspaexperience.com/header/Nailspa-logo.png" width="117" height="60"></td>
                                                            <td width="290" align="right" style="LINE-HEIGHT:15px; padding:1%; FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal;">
                                                            <?php 
															echo $seldpd[0]['StoreBillingAddress'];
															?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="LINE-HEIGHT:0;BACKGROUND:#d0ad53;FONT-SIZE:0px;" height="5"></td>
                                        </tr>
                                          <tr>
                                            <td align="middle">
                                                <table border="0" cellspacing="0" cellpadding="0" width="790" align="center">
                                                    <tbody>
                                                      <tr>
														<td width="50%">To ,</td>
														<td width="25%" >Invoice No :</td>
														<td width="25%"style="float:left;"><?php echo $seldpde[0]['InvoiceID']; ?></td>
													  </tr>
													   <tr>
														<td width="50%"><b><?php echo $seldpdep[0]['CustomerFullName'] ?></b></td>
														<td width="25%">Membership No :</td>
														<td width="25%"style="float:left;"></td>
													  </tr>
													     <tr>
														<td width="50%"><?php echo $seldpdep[0]['CustomerEmailID'] ?></td>
														<td width="25%">Renewal No :</td>
														<td width="25%" style="float:left;"></td>
													  </tr>
													       <tr>
														<td width="50%"><?php echo $seldpdep[0]['CustomerMobileNo'] ?></td>
														<td width="25%">stylist(s) :</td>
														<td width="25%" style="float:left;"></td>
													  </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
										
                                        
                                        <tr>
                                            <td height="8"></td>
                                        </tr>
                                           <tr>
                                            <td style="LINE-HEIGHT:0;BACKGROUND:#d0ad53;FONT-SIZE:20px;text-align:center;" height="30"><b>Service's</b></td>
                                        </tr>
                                        <tr>
                                            <td height="8">
                                                <table border="0" cellspacing="0" cellpadding="0" width="780" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td bgcolor="#e4e4e4" height="4"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table border="0" cellspacing="0" cellpadding="0" width="780" align="center">
                                                
                                                
                                                
                                                <tbody>
                                                        <tr>
                                                          <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Code</th>
                                                          <th width="60%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:left; padding-left:2%;">Item Description</th>
														   <th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Quantity</th>
                                                          <th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Amount</th>
														  <th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Action</th>
                                                        </tr>
														<?php 
														$seldpdept=select("*","tblAppointmentsDetails","AppointmentID='".$_GET['uid']."'");
														$sub_total=0;
														foreach($seldpdept as $val)
														{
															$servicee=select("*","tblServices","ServiceID='".$val['ServiceID']."'");
															
															$total=0;
															?>
															
                                                        <tr>
                                                          <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><?php echo $servicee[0]['ServiceCode'] ?></td>
                                                          <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><?php echo $servicee[0]['ServiceName'] ?><input type="hidden" id="serviceid" value="<?php echo $val['ServiceID'] ?>" /></td>
														    <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><input type="text" class="quantity" onkeyup="test1(this)"/></td>
                                                          <td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><input id="servicecst" type="text" readonly value="<?php echo number_format($servicee[0]['ServiceCost'],2); ?>" /><?php 
														 
														  $sub_total=$sub_total+$val['ServiceAmount'];
														  $total=$total+$sub_total;
														  
														  
														  ?></td>
														  <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">
														  		<a id="deleteservice" href="#" onClick="checkdelete(this)">Delete</a></td>
                                                        </tr>
                                                       
                                             
															<?php
														}
														?>
									
														
                                                        
                                                        
                                                      </tbody>
                                                
                                                </table>
                                            </td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <td height="8">
                                                <table border="0" cellspacing="0" cellpadding="0" width="780" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td bgcolor="#e4e4e4" height="4"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table border="0" cellspacing="0" cellpadding="0" width="780" align="center">
                                                
                                                <tbody>
                                                    <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Sub Total</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><?php echo number_format($sub_total,2); 
													  $sub_total=0;
													  ?></td>
                                                    </tr>
													<?php
													$sqlExtraCharges = "SELECT DISTINCT (ChargeName), SUM( ChargeAmount ) AS Sumarize FROM tblAppointmentsCharges WHERE AppointmentId ='".$_GET['uid']."' GROUP BY ChargeName";
				//echo $sqlExtraCharges;
				$RScharges = $DB->query($sqlExtraCharges);
				if ($RScharges->num_rows > 0) 
				{
					while($rowcharges = $RScharges->fetch_assoc())
					{
						$strChargeNameDetails = $rowcharges["ChargeName"];
						$strChargeAmountDetails = $rowcharges["Sumarize"];
						
						$strChargetotalAmount += $strChargeAmountDetails;
						?>
					                      <tr>
										  <td width="50%">&nbsp;</td>
										  <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;"><?= $strChargeNameDetails ?></td>
										  <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><?= $strChargeAmountDetails ?></td>
										</tr>
										<?php
						
						
					}
				}
				?>
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><?php echo number_format($total,2);
													  
													  ?></td>
                                                    </tr>
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Round Off</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><?php  
													  echo round($total);
													  $total=0;
													  ?></td>
                                                    </tr>
                                                    
                                                  </tbody>
                                                                                                   
                                                </table>
                                            </td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <td height="8">
                                                <table border="0" cellspacing="0" cellpadding="0" width="780" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td bgcolor="#e4e4e4" height="4"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="display:none" id="payment">
                                                <table border="0" cellspacing="0" cellpadding="0" width="780" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                	<tr>
                                                    <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                    </tr>
                                                    <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;">Payment</td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Cash</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="text" id="paymentid" onkeypress="test()"/></td>
                                                    </tr>
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total Payment</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;" id="totalpayment"></td>
                                                    </tr>
                                                                                                       
                                                    
                                                  </tbody>
                                                                                                    
                                                </table>
                                            </td>
                                        </tr>
                                        
                                        
                                        
                                        
                                        
                                     <tr>
                                            <td height="8">
                                                <table border="0" cellspacing="0" cellpadding="0" width="780" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td bgcolor="#e4e4e4" height="4"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table border="0" cellspacing="0" cellpadding="0" width="780" align="center">
                                              
                                                <tbody>
                                                
                                                	
                                                    <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Change</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;">578001.00</td>
                                                    </tr>
                                                   
                                                  </tbody>   
                                        
                                     			</table>
                                            </td>
                                        </tr> 
                                        
                                        
                                        
                                        
                                        
                                        
                                        <tr>
                                            <td>
                                                <table border="0" cellspacing="0" cellpadding="0" width="780" align="center">
                                              
                                                <tbody>
                                                
                                                	
                                                    <tr>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;">Your Total Savings is: 1020.00</td>
                                                      
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;">Current Membership Balance:1500.00</td>
                                                    </tr>
                                                  </tbody>   
                                        
                                     			</table>
                                            </td>
                                        </tr> 
                                        
                                                                         
                                        
                                        
                                        <tr>
                                            <td height="8"></td>
                                        </tr>
                                        
                                         <tr>
										 <style>
												.con  {
												height:200px;
												width:800px;
												border:1px solid #d0ad53;
												}												
												</style>
												<td>
                                           <div class="con">
												<p align="center">Advertisement </p>
										   </div>
										   </td>
                                        </tr>
                                        <tr>
                                        
                                         <td  style="BACKGROUND:#d0ad53;">
                                                <table border="0" cellspacing="0" cellpadding="0" width="780" align="center">
                                              
                                                <tbody>
                                        
                                        
                                        
                                            <td width="33%" style="FONT-FAMILY:Arial,Helvetica,sans-serif;BACKGROUND:#d0ad53;COLOR:#000;FONT-SIZE:12px; padding:1%;" height="32" align="left">
                                            <span style="font-size:14px; font-weight:600;">CANDY</span><br>
                                            Sagar ville bldg,Bhulabhai desai marg, next to shree shardha restaurant, near mahalaxmi temple, Breach candy - 400026<br>
                                            
											contact- 022 65320001

                                            
                                            </td>
                                            <td width="33%" style="FONT-FAMILY:Arial,Helvetica,sans-serif;BACKGROUND:#d0ad53;COLOR:#000;FONT-SIZE:12px;" height="32" align="left">
                                            
                                            
                                            <span style="font-size:14px; font-weight:600;">KHAR</span><br>
                                            
                                            
                                            Jai Niketan bldg,grnd floor, opp Camy wafers,near Gabana, Khardanda 16th rd, Khar west - 400052<br>
											Contact- 022 65324444
                                            
                                            
                                            </td>
                                            <td width="33%" style="FONT-FAMILY:Arial,Helvetica,sans-serif;BACKGROUND:#d0ad53;COLOR:#000;FONT-SIZE:12px;" height="32" align="left">
                                            
                                            
                                            <span style="font-size:14px; font-weight:600;">ANDHERI</span><br>
                                            
                                            Park paradise bldg,opp windermere bldg, near green park, Oshiwara off link rd, Andheri west - 400053 <br>
											Contact- 022 65650099
                                            
                                            
                                            
                                            </td>
                                            
                                            <!--<td style="FONT-FAMILY:Arial,Helvetica,sans-serif;BACKGROUND:#d0ad53;COLOR:#000;FONT-SIZE:15px;FONT-WEIGHT:bold;" height="32" align="right">
                                            
                                            <img border="0" src="http://nailspaexperience.com/header/Nailspa-logo.png" width="117" height="60"></td>-->
                                            
                                            </tbody>
                                            </table>
                                            </td>
                                            
                                            
                                        	</tr>
											
                                    	</tbody>
                                	</table>
                            	</td>
                        	</tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
                                    </div>
										<button type="button" id="cash" value="cash" class="btn btn-success" data-toggle="button" ><center>Cash</center></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<button type="button" id="card" value="card" class="btn btn-info" id="btnPrint" data-toggle="button" style="float:left;">Card</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<button type="button" id="hold" value="hold"  class="btn btn-primary active" id="btnPrint" data-toggle="button" style="float:left;">Hold</button>
                                </div>
									
							</div>
							</div>
							<?php
}	
else
{
?>	
                    <div class="panel">
						<div class="panel">
							<div class="panel-body">
								<div class="example-box-wrapper">
								<span class="form_result">&nbsp; <br></span>
									<div class="panel-body">
										<h3 class="title-hero">List of Invoice | Nailspa</h3>
										<div class="example-box-wrapper">
											<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>Sr.No</th>
														<th>Appointment ID</th>
													
														<th>Invoice Name</th>
														<th>Appointment Date</th>
														<th>Store Name</th>
													    <th>Status</th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>Sr.No</th>
														<th>Appointment ID</th>
													
														<th>Invoice Name</th>
														<th>Appointment Date</th>
														<th>Store Name</th>
													    <th>Status</th>
													</tr>
												</tfoot>
												<tbody>

<?php
// Create connection And Write Values
$DB = Connect();

$sql = "SELECT * FROM ".$strMyTable;
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
$counter = 0;

while($row = $RS->fetch_assoc())
{
$counter ++;
$appointment_id = $row["appointment_id"];
$invoice_name = $row["invoice_name"];
$sada=select("CustomerFullName","tblCustomers","CustomerID='".$invoice_name."'");
$customer=$sada[0]['CustomerFullName'];

$getUID = EncodeQ($appointment_id);
$appointment_date = $row["appointment_date"];

$store = $row["store"];
$sadad=select("StoreName","tblStores","StoreID='".$store."'");
$storename=$sadad[0]['StoreName'];
 $status = $row["status"];
	

?>	
<script>
 	function checkstatus(ext)
		{
		//alert(111)
		var uid=$("#uid").val();
		//alert(ext)
		var number=$("#status").text();
		//alert(number)
		if(ext=='Hold')
		{
			//alert(1234)
			window.location="ManageAppointments.php";
		}
		else if(ext=='Completed')
		{
			
		window.location="appointment_invoice.php?uid=<?php echo $appointment_id ?>";
			
			
		}
		else
		{
			
		}
		}
</script>
													<tr id="my_data_tr_<?=$counter?>">
														<td style="text-align: center"><?=$counter?>
														<input type="hidden" id="uid" value="<?php echo $getUID  ?>" />
														</td>
														<td style="text-align: center">
														<?=$appointment_id?>
														</td>
														
														<td style="text-align: center">
													
													<?=$customer?>
														
														</td>
													<td style="text-align: center">
													
													<?=$appointment_date?>
														
														</td>
													<td style="text-align: center">
													
													<?=$storename?>
														
														</td>
															<td style="text-align: center" >
																	<?																		
																		if($status=="0")
																		{
																			$Status = "Upcoming";
																			echo $Status;
																		}
																		elseif($status=="1")
																		{
																			//echo 1111;
																			$Status = "Hold";
																			?>
																		<a id="status" href="#" onClick="checkstatus('Hold')"><?php echo $Status; ?></a>
																			<?php
																			
																		}
																		elseif($status=="2")
																		{
																			$Status = "Completed";
																			//echo $Status;
																				?>
																		<a id="status" href="#" onClick="checkstatus('Completed')"><?php echo $Status; ?></a>
																			<?php
																		}
																		elseif($status=="3")
																		{
																			$Status = "Cancelled";
																			echo $Status;
																		}
																		
																	//echo $Status;
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
											</table>
										</div>
									</div>
									
								</div>
							</div>
						</div>
                    </div> 
					<?php
					}
					?>
                      </div>
                    </div>
                  </div>
            		 
          
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>