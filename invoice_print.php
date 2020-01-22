<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Invoice Print | Nailspa";
	$strDisplayTitle = "Invoice Print";

	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
?>


<?php require_once("incMetaScript.fya"); ?>

<html>
<head>
	<script>
	//$("#displays").one( "onload", function() { alert("You'll only see this once!"); } );
		function saifusmaniisgreat() {
			//	alert(111);
    var divContents = encodeURIComponent($("#printarea").html());
			var email =$("#email").val();
			var app=$("#app_id").val();
			//alert(divContents)
			//document.write(divContents);
			if(email!='')
			{
				$.ajax({
					type:"post",
					data:"divContents="+divContents+"&email="+email+"&app="+app,
					url:"sendinvoice.php",
					success:function(result1)
					{
						alert(result1)
						
						
					}
				});
			}
			else
			{
				alert('Email Id is blank')
			}
			
		};
		function printDiv(divName) 
		{
			var divContents = $("#printarea").html();
			var abc = $("#printarea1").html();
			// alert(abc);
			// alert(divContents)
            var printWindow = window.open('', '', 'height=600,width=800');
			printWindow.document.write('<html><head><title>Invoice</title>');
			printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
			printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
			
			// var printContents = document.getElementById(divName).innerHTML;
			// var originalContents = document.body.innerHTML;

			// document.body.innerHTML = printContents;

			// window.print();

			// document.body.innerHTML = originalContents; 
		}
		function sendmail()
		{
			var divContents = encodeURIComponent($("#printarea").html());
			var email =$("#email").val();
			var app=$("#app_id").val();
			//alert(divContents)
			//document.write(divContents);
			if(email!='')
			{
				$.ajax({
					type:"post",
					data:"divContents="+divContents+"&email="+email+"&app="+app,
					url:"sendinvoice.php",
					success:function(result1)
					{
						alert(result1)
						
						
					}
				});
			}
			else
			{
				alert('Email Id is blank')
			}
					
		}

</script>

<!--@media print
{
    #printarea { display: block; }
}
#printarea1 {
	background:url('http://nailspaexperience.com/images/test3.png') no-repeat; 
	background-position:50% -5px;
	visibility: visible;
}-->
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
</style>
</head>
 <?php 
		  $img='http://nailspaexperience.com/images/test3.png'  ?>
  <body onload="saifusmaniisgreat();" id="displays">                


<div class="alert-content">
	<h4 class="alert-title"><center><b><?php echo $_GET['msg'] ?></b></center></h4>
</div><br/>
  <div class="alert-content" id="displaymsg" style="display:none">
	
</div><br/>       
<div id="printarea">
<table border="0" cellspacing="0" cellpadding="0" width="100%" >
    <tbody style="border:1px" >
        <tr style="background-image: url(<?php echo $img;?>);background-repeat: no-repeat; background-position:50% 20%; media:print; -webkit-print-color-adjust: exact;">
            <td>
                <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center" >
                    <tbody>
                        
                        <tr >
                            <td>
                                <table id="printarea" style="BORDER-BOTTOM:#d0ac52 1px solid;BORDER-LEFT:#d0ac52 1px solid;BORDER-TOP:#d0ac52 1px solid;BORDER-RIGHT:#d0ac52 1px solid;" cellspacing="0" cellpadding="0" width="98%" align="center" media="print">
                                    <tbody >
										
									<?php
										$seldp=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
										$seldpd=select("StoreName","tblStores","StoreID='".$seldp[0]['StoreID']."'");
										$seldpde=select("InvoiceID","tblInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
										$seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
										date_default_timezone_set('Asia/Kolkata');
												$timestamp =  date("H:i:s", time());
												$sqlUpdate1 = "UPDATE tblAppointments SET AppointmentCheckOutTime = '".$timestamp."', Status = '2' WHERE AppointmentID='".DecodeQ($_GET['uid'])."'";
												//$passingID = EncodeQ(DecodeQ($passingID1));
												ExecuteNQ($sqlUpdate1);
		
										$seldpdeptp=select("*"," tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
										foreach($seldpdeptp as $ty)
										{
											$totalservices=$ty['ServiceID'];
											$seldpdepp=select("MECID","tblAppointmentAssignEmployee","ServiceID='".$totalservices."' and AppointmentID='".DecodeQ($_GET['uid'])."'");
											//print_r($seldpdepp);
										}
										$appp_id=DecodeQ($_GET['uid']);
								
									?>
                                        <tr>
									
                                            <td align="middle">
												<input type="hidden" name="appointment_id" id="appointment_id" value="<?php echo DecodeQ($_GET['uid']) ?>" />
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                    <tbody>
                                                        <tr>
														
                                                            <td width="50%" align="left" style="padding:1%;"><img border="0" src="http://nailspaexperience.com/header/Nailspa-logo.png" width="117" height="60"><input type="hidden" name="app_id" id="app_id" value="<?=$appp_id?>" /></td>
                                                            <td width="50%" align="right" style="LINE-HEIGHT:15px; padding:1%; FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal;"><b>
															<?php echo $seldpd[0]['StoreName']; ?></b>
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
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                    <tbody>
                                                      <tr style="padding-left:10%;">
														<td width="76.5%">To ,</td>
														<td width="10%">Invoice No :</td>
														<td width="10%" style="float:center; padding-right:05%"><?php echo $seldpde[0]['InvoiceID']; ?></td>
													  </tr>
													   <tr>
														<td width="50%"><b><?php echo $seldpdep[0]['CustomerFullName']; ?></b></td>
														<td width="25%">Membership No :</td>
														<td width="25%" style="float:center; padding-right:05%">
														
														<?php
                                                         if($seldp[0]['memberid']!='0')
														 {
															 echo $seldp[0]['memberid'];

														 }
														 else
														 {
															  echo "-";
														 }
														
														?>
														</td>
													  </tr>
													     <tr>
														
														<td width="50%"><?php echo $seldpdep[0]['CustomerEmailID'] ?>
														 <input type="hidden" id="email" value="<?php echo $seldpdep[0]['CustomerEmailID'] ?>" />
														</td>
														
													  </tr>
													       <tr>
														<td width="50%"><?php echo $seldpdep[0]['CustomerMobileNo'] ?></td>
														<td width="25%">stylist(s) :</td>
														<td width="25%" style="float:center; padding-right:05%">
															<?php
													 $seldpdeppt=select("MECID"," tblAppointmentAssignEmployee","AppointmentID='".DecodeQ($_GET['uid'])."'");
														foreach($seldpdeppt as $vap)
														{
															$empname=$vap['MECID'];
															if($empname!="0")
															{
																$emppp=$emppp.','.$empname;
															}
														
														
														
														}
														
														
														
															//$empnamep=implode(",",$empname);
													
														if($emppp=="")
														{
															echo "-";
														}
														elseif($emppp=="0")
														{
															
														}
														else
														{
															?>
															<?php echo trim($emppp,","); ?>
															<?php
														}
														?>
														</td>
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
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
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
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                              
                                                
                                                <tbody>
                                                        <tr>
                                                          <th width="5%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Sr</th>
                                                          <th width="60%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:left; padding-left:2%;">Item Description</th>
														   <th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Quantity</th>
                                                          <th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Amount</th>
														
														
                                                        </tr>
														<?php 
														$seldpdept=select("*"," tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."' and PackageService='0'");
														$sub_total=0;
														$countsf = "0";
														$countersaif = "";
														$counterusmani = "1";
														foreach($seldpdept as $val)
														{
															$countersaif ++;
															$countsf++;
															$counterusmani = $counterusmani + 1;
															$totalammt=0;
															$AppointmentDetailsID=$val['AppointmentDetailsID'];
															$servicee=select("*","tblServices","ServiceID='".$val['ServiceID']."'");
															$qtyyy=$val['qty'];
															$amtt=$val['ServiceAmount'];
															$quantity=$val['qty'];
															$totalammt=$qtyyy*$amtt;
															$total=0;
															?>
															
															<tr>
																<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><?=$countsf?></td>
																  <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><?php  echo $servicee[0]['ServiceName']; ?></td>
																	<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:right; padding-right:05%;"><?php  echo $quantity;   ?>
																	
																 </td>
																  <td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:right; padding-right:05%;"><?php echo $totalammt.".00"; ?>
																  <?php 
																 
																 $sub_total=$sub_total+$totalammt;
														  $total=$total+$sub_total;
														  
																  
																  ?>
																</td>
															 
															</tr>
											<tr>
														<?php 
															$seldember=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
															$memid=$seldember[0]['memberid'];
															
														if($memid!="0")
														{
															
															 
			$DB = Connect();
			
		
				$seldatap=select("DiscountType","tblMembership","MembershipID='".$memid."'");	
				$type=$seldatap[0]['DiscountType'];
          if($type=='0')
		  {
			  $seldata=select("distinct(NotValidOnServices),MembershipName,Discount","tblMembership","MembershipID='".$memid."'");	  
		      //print_r($seldata);
			  $services=$seldata[0]['NotValidOnServices'];
			   $membershipname=$seldata[0]['MembershipName'];
			   $Discount=$seldata[0]['Discount'];
			  $sericesd=explode(",",$services);
		
					if(in_array($val['ServiceID'],$sericesd))
							{
					
							}
							else
							{
								$serviceid=$val['ServiceID'];
					$serviceamount=$val['ServiceAmount'];
					$qty=$val['qty'];
					$amount=$qty*$serviceamount;
					$totalamount=$amount*$Discount/100;
					
						?>
						
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><?php echo $membershipname; ?>
						<input type="hidden" name="serviceidm[]" id="serviceidm" value="<?= $serviceid ?>" />
						<input type="hidden" name="discountm[]" id="discountm" value="<?= $totalamount ?>" />
							<input type="hidden" name="memid[]" id="memid" value="<?= $memid ?>" />
						
						</td><td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><?php echo $Discount; ?>% Membership Discount </td><td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"></td><td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:right; padding-right:05%;">
						<?=$totalamount.".00" ?>
					
														  <?php 
														  $offdisp=$offdisp+$Discount;
														 	  $memberdis=$memberdis+$totalamount;
														  
														
														  ?></td><td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"></td>
						<?php
					
							}
		       
			  
					
			  
			  
			  
			  
			  
			  
			  
			
		  }
			else
			{
			    $seldata=select("distinct(NotValidOnServices),MembershipName,Discount","tblMembership","MembershipID='".$memid."'");	  
		      //print_r($seldata);
			  $services=$seldata[0]['NotValidOnServices'];
			   $membershipname=$seldata[0]['MembershipName'];
			   $Discount=$seldata[0]['Discount'];
			  $sericesd=explode(",",$services);
			  //print_r($sericesd);
			 
					if(in_array($val['ServiceID'],$sericesd))
							{
							
							}
							else
							{
									?>
				
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><?php echo $membershipname; ?>
							<input type="hidden" name="serviceidm[]" id="serviceidm" value="<?= $serviceid ?>" />
						<input type="hidden" name="discountm[]" id="discountm" value="<?= $Discount ?>" />
							<input type="hidden" name="memid[]" id="memid" value="<?= $memid ?>" />
						</td>
						
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><?php echo $Discount; ?>Amount Membership Discount </td>
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"></td>
						<td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:right; padding-right:05%;">
						<?=$Discount.".00" ?>
														  <?php 
														  	  $offdisp=$offdisp+$Discount;
													$memberdis=$memberdis+$Discount;
														
													
			
			
														//  $sub_total=$sub_total-$Discount;
													// $total=$total+$sub_total;
														  
														  
														  ?></td> 
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"></td>
						
						<?php
							}
						
					
											
						//echo "<br/>";
					
					
			}
						$DB->close();
														   
															
														}
														else
														{
															
														}
														
														?>
														  </tr>
														 
												<?php
														
														
														}
														
													 	$seldoffertpp=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
													    $Package=$seldoffertpp[0]['PackageID'];
														$packagess=explode(",",$Package);
														$AppointmentDate=$seldoffertpp[0]['AppointmentDate'];
														for($i=0;$i<count($packagess);$i++)
														{
														if($packagess[$i]!=0)
														{
															
															   $seldpack=select("*","tblPackages","PackageID='".$packagess[$i]."'");
															   $packname=$seldpack[0]['Name'];
															   $PackageNewPrice=$seldpack[0]['PackageNewPrice'];
															   $Validityp=$seldpack[0]['Validity'];
															   $valid="+".$Validityp."Months";
															   $validpack = date('Y-m-d', strtotime($valid));
															   $sub_total=$sub_total+$PackageNewPrice;
															   
															   $seldpackq=select("count(*)","tblBillingPackage","PackageID='".$packagess[$i]."' and AppointmentID='".DecodeQ($_GET['uid'])."'");
															    $countpack=$seldpackq[0]['count(*)'];
															?>
												<tr>
												<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"></td>
						                       <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:right; padding-right:05%;">&nbsp;&nbsp;<?=$packname?></td>
						                       <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:right; padding-right:05%;"><b>Valid Till</b><br/><input type="hidden" id="app_date" value="<?=$AppointmentDate?>" /><?=$validpack?></td>
						                       <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:right; padding-right:05%;"><?=$PackageNewPrice?>	</td>
							                   <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;" class="no-print"> <input type="hidden" id="PackageID" name="PackageID[]" value="<?=$packagess[$i]?>" />
											   <?php
											   if($countpack>0)
											   {
												   
											   }
											   else
											   {
												   
											   }
											   ?>
											
													
														</tr>
															<?php
														if($packagess[$i]!="0" || $packagess[$i]!="")
														{
														
												       $seldpdeptwp=select("*","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."' and PackageService='".$packagess[$i]."'");
													 
														foreach($seldpdeptwp as $vatq)
														{
															$servicee=select("*","tblServices","ServiceID='".$vatq['ServiceID']."'");
															$ServiceName=$servicee[0]['ServiceName'];
															$qtyyy=$val['qty'];
															$amtt=$val['ServiceAmount'];
															
															$seldpdepte=select("*","tblBillingPackage","AppointmentID='".DecodeQ($_GET['uid'])."' and PackageID='".$packagess[$i]."' and ServiceID='".$vatq['ServiceID']."'");
															$sstatus=$seldpdepte[0]['Status'];
															?>
						<tr>
						
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"></td>
					
						<?php 
						if($sstatus=='1')
						{
							?>
								 <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:right; padding-right:05%;"><?=$ServiceName?></td>
							<?php
						}
						else
						{
							?>
								 <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:right; padding-right:05%;"><?=$ServiceName?></td>
							<?php
						}
						
						?>
						
					 <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:right; padding-right:05%;">
						<?php
						if($sstatus=='1')
						{
							echo "Done";
						}
						else
						{
								$seldata=select("ValidTill","tblAppointmentPackageValidity","AppointmentID='".DecodeQ($_GET['uid'])."'");
												$ValidTill=$seldata[0]['ValidTill'];
												 if($date>$ValidTill)
												 {
							                       echo "Service Expired";
												 }
												 else
												 {
							echo "Package Service Remaining";
												 }
						}
						?>
						</td>
						<td style="display:none"><input type="hidden" name="packid" id="packid" value="<?=$packagess[$i]?>" /></td>
					
						
													
														</tr>
															<?php
														}
														}
														}
														
														}	
														
														
												
										$seldoffert=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
														$VoucherID=$seldoffert[0]['VoucherID'];
															if($VoucherID!='0')
															{
																$selp=select("*","tblGiftVouchers","Status='0' and AppointmentID='".DecodeQ($_GET['uid'])."'");
															$GiftVoucherID=$selp[0]['GiftVoucherID'];
															$RedemptionCode=$selp[0]['RedemptionCode'];
															$Amount=$selp[0]['Amount'];
                                                            $Status=$selp[0]['Status'];
													if($RedemptionCode!="0")
													{
														if($Status=='0')
														{
															$sub_total=$sub_total+$Amount;
														//echo $RedemptionCode;
														?>
														<tr>
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"></td>
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"><?= $RedemptionCode?>&nbsp;&nbsp;Gift Voucher Code</td>
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"></td>
						<td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"><?=$Amount?>
						
													
														</tr>
														<?php
														}
													}
															}
															
														
														?>
													
												

														
									
														
                                                        
                                                        
                                                      </tbody>
                                              
                                                </table>
                                            </td>
											
											 
                                        </tr>
                                        
														
												
														
                                        <tr>
                                            <td height="8">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
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
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                <tbody>
												
											
	
                                                    <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Sub Total</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;"><?php echo number_format($sub_total,2);?>
													</td>
                                                    </tr>
													<?php
													 	$seldember=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
													$VoucherID=$seldember[0]['VoucherID'];  
															
															
																	$seldembert=select("Status","tblGiftVouchers","AppointmentID='".DecodeQ($_GET['uid'])."'");
																	//print_r($seldembert);
														        	$Status=$seldembert[0]['Status'];  
																
																if($Status=='0')
																{
                                                                    
                                                               
																	
                                                                    
																	$selpt=select("*","tblGiftVouchers","AppointmentID='".DecodeQ($_GET['uid'])."' and Status='0'");
																    //print_r($selpt);
 
																	$amtt=$selpt[0]['Amount'];
                                                                     $id=$selpt[0]['GiftVoucherID'];
																
                                                                            
                                                                                 $selptp=select("*","tblGiftVouchers","RedempedBy='".DecodeQ($_GET['uid'])."' and Status='1'");
                                                                     if($selptp!='0')
                                                                      {

                                                                   $amttp=$selptp[0]['Amount'];
																   $id=$selptp[0]['GiftVoucherID'];
                                                                                
                                                                   if($amttp!="0")
                                                                           {
                                                                      if($amtt > $sub_total)
																				{
																		  $sub_total=0;
																				
																				}
																				else{
																					$totalamt=$amtt-$amttp;
                                                                          $sub_total=$sub_total+$totalamt;
																					
																				}
                                                                      
                                                                            
 ?>
																	 				 <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Redemption Gift Voucher Discount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;"><?php echo "-".number_format($amttp,2);?>
													</td>
                                                    </tr>
																	 <?php
                                                                            }
																		else
																		{
                                                           
																		}
                                                                       } 
																	      $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
											   $cntserp=$sepcont[0]['count(*)'];
											   if($cntserp>0)
											   {
												   
												     $sub_total=$sub_total+$amtt;
                                                         ?>
																	 				 <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Gift Voucher Cost</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;"><?php echo "+".number_format($amtt,2);?>
													</td>
                                                    </tr>
																	 <?php
                                                                                          
											   }
											   else
											   {
												   
											   }
                                                                               
    
																		    
																		 
																	
																	
                                                                 
																	
																	
																}
																else
																{

                                                      
																	$selpt=select("*","tblGiftVouchers","RedempedBy='".DecodeQ($_GET['uid'])."' and Status='1'");
                                                                   
																	 $amtt=$selpt[0]['Amount'];
																      $RedempedBy=$selpt[0]['RedempedBy'];
																	    $id=$selpt[0]['GiftVoucherID'];
																	 
																	 if($amtt!='0')
																	 {
                                                                       if($RedempedBy==DecodeQ($_GET['uid']))
                                                                            {
                                                                                 
                                                                               if($amtt > $sub_total)
																				{
																					$sub_total=0;
																				
																				}
																				else{
																						$sub_total=$sub_total-$amtt;
																				}
                                                                  
?>
																	 				 <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Redemption Gift Voucher Discount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><input type="hidden" name="Redemptid"  Value="<?=$id?>"/><input type="text" name="vouchercost" readonly value="<?php echo "-".number_format($amtt,2);?>" />
													</td>
                                                    </tr>
																	 <?php
                                                                            }
                                                                         } 
                                                           
                                                $selpt=select("*","tblGiftVouchers","AppointmentID='".DecodeQ($_GET['uid'])."' and Status='0'");
                                                         if($selpt!='0')
                                                         {
															   $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".DecodeQ($_GET['uid'])."'");
											   $cntserp=$sepcont[0]['count(*)'];
											   if($cntserp>0)
											   {
												      $amttp=$selpt[0]['Amount'];
																	   $id=$selpt[0]['GiftVoucherID'];
                                                                                $sub_total=$sub_total+$amttp;
                                                                         ?>
																	 				 <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Gift Voucher Cost</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;"><?php echo "+".number_format($amttp,2);?>
													</td>
                                                    </tr>
																	 <?php
                                                                        
											   }
											   else
											   {
												   
											   }

                                                                    

																		  
																	 
                                                          }
                                                         else
                                                         {

                                                         }
      
																	 
                                                                
																	
																}
																
														
																
														
											 	$seldember=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
															$memid=$seldember[0]['memberid'];  
															$custid=$seldember[0]['CustomerID'];  
														$seldemberg=select("*","tblMembership","MembershipID='".$memid."'");
															$Cost=$seldemberg[0]['Cost'];  		
															
														$selcust=select("*","tblCustomers","CustomerID='".$custid."'");	
															$memberflag=$selcust[0]['memberflag'];  		
															  $cust_name=$selcust[0]['CustomerFullName'];
														$selcustd=select("Membership_Amount","tblInvoiceDetails","CustomerFullName='".$cust_name."' and AppointmentId='".DecodeQ($_GET['uid'])."'");	
														$Membership_Amount=$selcustd[0]['Membership_Amount'];
														if($Membership_Amount!="")
														{
															 $sub_total=$sub_total+$Cost;
																		?>
																		 <tr>
																  <td width="50%">&nbsp;</td>
																  <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;"><?=$membershipname?> Amount</td>
																  <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;"><?php echo "+".number_format($Cost,2);?>
																</td>
																</tr>
																<?php
														}
																
																		
												
															
															/////////////////////////////////////////////////////
																$seldoffer=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
															$offerid=$seldoffer[0]['offerid'];
															if($offerid!="0")
															{
																
													?>
													
													 <tr>
													 <td width="50%">&nbsp;</td>
										 
			
                                                     <?php 
													$seldoffer=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
															$offerid=$seldoffer[0]['offerid'];
															$StoreIDd=$seldoffer[0]['StoreID'];
																$memid=$seldoffer[0]['memberid'];  
													
													$seldofferp=select("*","tblOffers","OfferID='".$offerid."'");
															$services=$seldofferp[0]['ServiceID'];
															$offernamee=$seldofferp[0]['OfferName'];
															$baseamt=$seldofferp[0]['BaseAmount'];
															$Type=$seldofferp[0]['Type'];
															$TypeAmount=$seldofferp[0]['TypeAmount'];
															$StoreID=$seldofferp[0]['StoreID'];
															$stores=explode(",",$StoreID);
															
															$servicessf=explode(",",$services);
																if(in_array("$StoreIDd",$stores))
															    {
																	$statuscheck="No";
																	foreach($seldpdept as $val)
																		    {
																				
																			$totalammt=0;
																			$serviceid=$val['ServiceID'];
																			$AppointmentDetailsID=$val['AppointmentDetailsID'];
																	     	$AppointmentID=$val['AppointmentID'];
																			 
																					 if(in_array("$serviceid",$servicessf))
																				   {
																					
																					
																					$sqp=select("*","tblAppointmentsDetailsInvoice","ServiceID='".$serviceid."' and AppointmentID='".$AppointmentID."'");
																					
																					$amtt=$sqp[0]['ServiceAmount'];
																					
																					
																					 $qtyyy=$sqp[0]['qty'];
																					$totals=$qtyyy*$amtt;
																				  $totalpp=$totalpp+$totals;
																					if($baseamt!="")
																		            {
																					
																							if($totalpp>=$baseamt)
																							{
																						//echo 1;
																							if($Type=='1')
																							{
																								     if($statuscheck=="No")
                                                                                                   {
																									   $servicefinal=$serviceid;
																								//$offeramtt=$totalpp-$TypeAmount;
																								$offeramtt=$TypeAmount;
																								$statuscheck="Yes";
																								   }
																								   else{
																									   
																								   }
																							}
																							else
																							{
																								$amt=$totals*$TypeAmount/100;
																								
																								$offeramtt=$amt;
																			
																                  	$offeramount=$offeramount+$offeramtt;
																					
																					
																								
																							}
																							
																							
																			
																						
																								}
																								else
																								{
																									$data="Offer Not Applicable Offer Amount is Less Than Billing Amount";
																								}
																								
																																			                
													
																								
																					}
																					else
																					{
																						if($Type=='1')
																						{
																							 if($statuscheck=="No")
                                                                                                   {
																									   $servicefinal=$serviceid;
																							//$offeramtt=$totalpp-$TypeAmount;
																							$offeramtt=$TypeAmount;
																							$statuscheck="Yes";
																								   }
																						}
																						else
																						{
																							$amt=$totals*$TypeAmount/100;
																							
																							$offeramtt=$amt;
																
                                                                                   $offeramount=$offeramount+$offeramtt;
																						}
																						
																						
																						
													
														 	                  
																						
																					}
																					
																					?>
																<input type="hidden" name="serviceido[]" id="serviceido" value="<?= $serviceid ?>" />
						<input type="hidden" name="offeramttt[]" id="offeramttt" value="<?= $offeramtt ?>" />
							<input type="hidden" name="offerid[]" id="offerid" value="<?= $offerid ?>" />
																					<?php
																						
																				}
																				else
																				{
																					$data="Offer Not Applicable For Some Of These Services";
																				}
																			
																				
																			}
													     
																		
																}
																else
																{
																	$data="This Offer Is Not Valid For This Store";
																			
																}
																		
																			
																
											
										    
															//print_r($servicessf);
												
														 if($offeramtt!="")
													 {
														 if($Type=="1")
														 {
															$offeramtt=$offeramtt;
														 }
														 else
														 {
															$offeramtt=$offeramount;
														 }
														 
														
														 ?>
														  <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">
																							<?=$offernamee?></td>
																							 <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;">
																							<?="-".$offeramtt ?></td>
														 <?php
													 }
													 ?>
													 
													
                                                    </tr>
													<?php
															}
													
															
													///////////////////////////////////////////////////////////////
                                                        ////////////////Member Discount///////////////////////
  
												 	$seldember=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
															$memid=$seldember[0]['memberid'];  
															 $offerid=$seldember[0]['offerid'];
															$custid=$seldember[0]['CustomerID'];  
														$seldemberg=select("*","tblMembership","MembershipID='".$memid."'");
															$Cost=$seldemberg[0]['Cost'];  		
															
														$selcust=select("*","tblCustomers","CustomerID='".$custid."'");	
															$memberflag=$selcust[0]['memberflag'];  

                                                         $seldofferp=select("*","tblOffers","OfferID='".$offerid."'");
															$services=$seldofferp[0]['ServiceID'];
															$baseamt=$seldofferp[0]['BaseAmount'];
															$Type=$seldofferp[0]['Type'];
															$TypeAmount=$seldofferp[0]['TypeAmount'];
															$StoreID=$seldofferp[0]['StoreID'];
															$stores=explode(",",$StoreID);
															
											
															if($memid!="0")
														        {
															?>
															 <tr>
                                                      <td width="50%">&nbsp;</td>
                                                      <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;"><?=$membershipname?>&nbsp;Discount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;"><?php echo "-".number_format($memberdis,2);?>
													</td>
                                                    </tr>
															<?php
																}
													
																	


///////////////////////////////////////////////////////////////// 
                                           $seldoffert=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
														
								                         $FreeService=$seldoffert[0]['FreeService'];
															 if($FreeService!="0")
															 {
																 
															 }
															 else
															 {
                                                                 		$sqlExtraCharges=select("DISTINCT (ChargeName), SUM( ChargeAmount ) AS Sumarize","tblAppointmentsChargesInvoice","AppointmentID ='".DecodeQ($_GET['uid'])."' GROUP BY ChargeName");
													//print_r($sqlExtraCharges);
													
													foreach($sqlExtraCharges as $vaqq)
													{
															$strChargeNameDetails = $vaqq["ChargeName"];
						                              $strChargeAmountDetails = $vaqq["Sumarize"];
														?>
														  <tr>
										  <td width="50%">&nbsp;</td>
										  <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;"><?=$strChargeNameDetails ?></td>
										  <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold;text-align:right; padding-right:05%;"><?="+".$strChargeAmountDetails ?></td>
										</tr>
										<?php
										$amountdetail=$amountdetail+$strChargeAmountDetails;
													}
															 }														 
					
	
												
														//print_r($value);
														//echo $value['AppointmentDetailsID'];
														
													$total=0;
										//echo 
								                                        if($amtt > $sub_total)
																				{
																					$total=$total+$sub_total;
																				}
																				else
																				{
																				
																					$total=$total+$sub_total+$amountdetail-$offeramtt-$memberdis;
																				}
														
								
								
										
									
									
												?>
				</tr>
				<?php
					$sept=select("PendingAmount","tblInvoiceDetails","AppointmentId='".DecodeQ($_GET['uid'])."'");
						$pendamt=$sept[0]['PendingAmount'];		
                          if($pendamt!="0" && $pendamt!="")			
						  {
							  $total=$total+$pendamt;
							  ?>
							      <tr id="pendingpayment"> 
				                                       <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%" ><?=$pendamt ?></td>
				                                  
				                                      </tr>
							  <?php
						  }
				?>
				                                   
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%" id="totalvalue"><?= number_format($total,2) ?></td>
                                                    </tr>
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Round Off</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;"><?php  
													  echo round($total);
													//  $total=0;
													  ?></td>
                                                    </tr>
                                                    
                                                  </tbody>
                                                                                                   
                                                </table>
                                            </td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <td height="8">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td bgcolor="#e4e4e4" height="4"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                   <?php 
										
										$seldppay=select("*","tblInvoiceDetails","AppointmentId='".DecodeQ($_GET['uid'])."'");
										$flag=$seldppay[0]['Flag'];
										
										
										
									$seldppayP=select("*","tblInvoiceDetails","AppointmentId='".DecodeQ($_GET['uid'])."' AND Flag='".$flag."'");
															 $amount=$seldppayP[0]['CashAmount'];
									
									
									
									$seldppayPt=select("*","tblPendingPayments","AppointmentID='".DecodeQ($_GET['uid'])."'");
										 $id=$seldppayPt[0]['PendingPaymentID'];
										 $pendingamt=$seldppayPt[0]['PendingAmount'];
										 $paidamt=$seldppayPt[0]['PaidAmount'];
										if($flag=='CS')
										{
												$seldppayP=select("*","tblInvoiceDetails","AppointmentId='".DecodeQ($_GET['uid'])."' AND Flag='".$flag."'");
															 $amount=$seldppayP[0]['CashAmount'];
												//print_r($seldppayP);
										
							
										
										 if($id!="")
										 {
											 	?>
											<tr>
											<td id="payment">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                	
                                                  			<?php
											
											 if($paidamt!="" && $pendingamt!="" && $paidamt!="0" && $pendingamt!="0" )
											 {
												
												 ?>
												 <tr>
                                                    <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                    </tr>
												  <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Paid Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($paidamt,2)?></td>
                                                    </tr>
													  <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($pendingamt,2)?></td>
                                                    </tr>
													
												 <?php
												 if($paidamt!="0")
												 {
												 $seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
												 $FirstName=$seldpdep[0]['FirstName'];
												 $CustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												 
												
				
												$SMSContentforImmediate="Dear ".$FirstName.", recd amt Rs ".$paidamt." /-. Thank You. Pls share feedback & help us to make your experience flawless.";
		
					// echo "In if<br>";
												$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".DecodeQ($_GET['uid'])	."','".$seldp[0]['StoreID']."','".$seldp[0]['CustomerID']."','','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."')";
					
												ExecuteNQ($InsertSMSDetails);
					// die();
					                            $SendSMS = CreateSMSURL("Amount Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
				
												 }
												 
											 }
											 else
											 {
												
												  if($pendingamt!="" && $pendingamt!="0")
											      {
													 
												 ?>
												 <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($pendingamt,2)?></td>
                                                    </tr>
												 <?php
												if($pendingamt!="0")
												 {
												$seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
												 $FirstName=$seldpdep[0]['FirstName'];
												 $CustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												 
												
				
												$SMSContentforImmediate="Dear ".$FirstName.", recd amt Rs ".$pendingamt." /-. Thank You. Pls share feedback & help us to make your experience flawless.";
		
					// echo "In if<br>";
												$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".DecodeQ($_GET['uid'])	."','".$seldp[0]['StoreID']."','".$seldp[0]['CustomerID']."','','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."')";
					
												ExecuteNQ($InsertSMSDetails);
					// die();
					                            $SendSMS = CreateSMSURL("Amount Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
				
												 }
											 }
											 elseif($paidamt!="" && $paidamt!="0")
											 {
												 ?>
												 <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Paid Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($paidamt,2)?></td>
                                                    </tr>
												 <?php
											 }
											 if($paidamt!="0")
												 {
												$seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
												 $FirstName=$seldpdep[0]['FirstName'];
												 $CustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												 
												
				
												$SMSContentforImmediate="Dear ".$FirstName.", recd amt Rs ".$paidamt." /-. Thank You. Pls share feedback & help us to make your experience flawless.";
		
					// echo "In if<br>";
												$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".DecodeQ($_GET['uid'])	."','".$seldp[0]['StoreID']."','".$seldp[0]['CustomerID']."','','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."')";
					
												ExecuteNQ($InsertSMSDetails);
					// die();
					                            $SendSMS = CreateSMSURL("Amount Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
				
												 }
											 }
												 
											 ?>
											    </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											 <?php 
											 
										 }
										 else
										 {
											
											 ?>
											 <tr>
											<td id="payment">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
											    <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Cash</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($amount,2)?></td>
                                                    </tr>
												  </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											 <?php
											 if($amount!="0")
												 {
											 $seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
												 $FirstName=$seldpdep[0]['FirstName'];
												 $CustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												 
												
				
												$SMSContentforImmediate="Dear ".$FirstName.", recd amt Rs ".$amount." /-. Thank You. Pls share feedback & help us to make your experience flawless.";
		
					// echo "In if<br>";
												$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".DecodeQ($_GET['uid'])	."','".$seldp[0]['StoreID']."','".$seldp[0]['CustomerID']."','','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."')";
					
												ExecuteNQ($InsertSMSDetails);
					// die();
					                            $SendSMS = CreateSMSURL("Amount Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
				
												 }
										 }
										?>
                                                 
                                                  
                                                                                                       
                                                    
                                                                                                       
                                                    
                                                
											<?php
										}
										elseif($flag=='H')
										{
												$seldppayP=select("*","tblInvoiceDetails","AppointmentId='".DecodeQ($_GET['uid'])."' AND Flag='".$flag."'");
										$amount=$seldppayP[0]['CashAmount'];
									
													?>
													<tr>
											<td id="payment">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                	
													<?php
													
										if($id!="")
										 {
											 	?>
											<tr>
											<td id="payment">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                	
                                                  			<?php
											
											 if($paidamt!="" && $pendingamt!="" && $paidamt!="0" && $pendingamt!="0" )
											 {
												 ?>
												 <tr>
                                                    <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                    </tr>
												  <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Paid Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($paidamt,2)?></td>
                                                    </tr>
													  <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($pendingamt,2)?></td>
                                                    </tr>
													
												 <?php
												 
												 if($paidamt!="0")
												 {
													  $seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
												 $FirstName=$seldpdep[0]['FirstName'];
												 $CustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												 
												
				
												$SMSContentforImmediate="Dear ".$FirstName.", recd amt Rs ".$paidamt." /-. Thank You. Pls share feedback & help us to make your experience flawless.";
		
					// echo "In if<br>";
												$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".DecodeQ($_GET['uid'])	."','".$seldp[0]['StoreID']."','".$seldp[0]['CustomerID']."','','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."')";
					
												ExecuteNQ($InsertSMSDetails);
					// die();
					                            $SendSMS = CreateSMSURL("Amount Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
												 }
												 
				
											 }
											 else
											 {
												
												  if($pendingamt!="" && $pendingamt!="0")
											      {
												 ?>
												 <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($pendingamt,2)?></td>
                                                    </tr>
												 <?php
											 }
											 elseif($paidamt!="" && $paidamt!="0")
											 {
												 ?>
												 <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Paid Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($paidamt,2)?></td>
                                                    </tr>
												 <?php
											 }
												if($paidamt!="0")
												 {
													  $seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
												 $FirstName=$seldpdep[0]['FirstName'];
												 $CustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												 
												
				
												$SMSContentforImmediate="Dear ".$FirstName.", recd amt Rs ".$paidamt." /-. Thank You. Pls share feedback & help us to make your experience flawless.";
		
					// echo "In if<br>";
												$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".DecodeQ($_GET['uid'])	."','".$seldp[0]['StoreID']."','".$seldp[0]['CustomerID']."','','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."')";
					
												ExecuteNQ($InsertSMSDetails);
					// die();
					                            $SendSMS = CreateSMSURL("Amount Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
												 }
											 }
												 
											 ?>
											    </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											 <?php 
											 
										 }else
										 {
											 ?>
											   <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><?php echo number_format($amount,2)?></td>
                                                    </tr>
                                                  
											 <?php
											 
											  if($amount!="0")
												 {
													  $seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
												 $FirstName=$seldpdep[0]['FirstName'];
												 $CustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												 
												
				
												$SMSContentforImmediate="Dear ".$FirstName.", recd amt Rs ".$amount." /-. Thank You. Pls share feedback & help us to make your experience flawless.";
		
					// echo "In if<br>";
												$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".DecodeQ($_GET['uid'])	."','".$seldp[0]['StoreID']."','".$seldp[0]['CustomerID']."','','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."')";
					
												ExecuteNQ($InsertSMSDetails);
					// die();
					                            $SendSMS = CreateSMSURL("Amount Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
												 }
										 }
										 ?>
                                                  
                                                                                                       
                                                    
                                                  </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											<?php
										}
										elseif($flag=='C')
										{
												$seldppayP=select("*","tblInvoiceDetails","AppointmentId='".DecodeQ($_GET['uid'])."' and Flag='".$flag."'");
										$amount=$seldppayP[0]['CardAmount'];
										
							
													?>
													<tr>
											<td id="payment">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                
                                                  <?php
										 if($id!="")
										 {
											
											 if($paidamt!="" && $pendingamt!="" && $paidamt!="0" && $pendingamt!="0" )
											 {
												 ?>
												 	<tr>
                                                    <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                    </tr>
												  <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Paid Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($paidamt,2)?></td>
                                                    </tr>
													  <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($pendingamt,2)?></td>
                                                    </tr>
													
												 <?php
												  if($paidamt!="0")
												 {
												   $seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
												 $FirstName=$seldpdep[0]['FirstName'];
												 $CustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												 
												
				
												$SMSContentforImmediate="Dear ".$FirstName.", recd amt Rs ".$paidamt." /-. Thank You. Pls share feedback & help us to make your experience flawless.";
		
					// echo "In if<br>";
												$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".DecodeQ($_GET['uid'])	."','".$seldp[0]['StoreID']."','".$seldp[0]['CustomerID']."','','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."')";
					
												ExecuteNQ($InsertSMSDetails);
					// die();
					                            $SendSMS = CreateSMSURL("Amount Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
												 }
											 }
											 else
											 {
												
												  if($pendingamt!="" && $pendingamt!="0")
											      {
												 ?>
												 <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($pendingamt,2)?></td>
                                                    </tr>
												 <?php
												 if($pendingamt!="0")
												 {
												$seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
												 $FirstName=$seldpdep[0]['FirstName'];
												 $CustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												 
												
				
												$SMSContentforImmediate="Dear ".$FirstName.", recd amt Rs ".$pendingamt." /-. Thank You. Pls share feedback & help us to make your experience flawless.";
		
					// echo "In if<br>";
												$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".DecodeQ($_GET['uid'])	."','".$seldp[0]['StoreID']."','".$seldp[0]['CustomerID']."','','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."')";
					
												ExecuteNQ($InsertSMSDetails);
					// die();
					                            $SendSMS = CreateSMSURL("Amount Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
				
												 }
											 }
											 elseif($paidamt!="" && $paidamt!="0")
											 {
												 ?>
												 <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Paid Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($paidamt,2)?></td>
                                                    </tr>
												 <?php
											 }
											 if($paidamt!="0")
												 {
												   $seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
												 $FirstName=$seldpdep[0]['FirstName'];
												 $CustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												 
												
				
												$SMSContentforImmediate="Dear ".$FirstName.", recd amt Rs ".$paidamt." /-. Thank You. Pls share feedback & help us to make your experience flawless.";
		
					// echo "In if<br>";
												$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".DecodeQ($_GET['uid'])	."','".$seldp[0]['StoreID']."','".$seldp[0]['CustomerID']."','','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."')";
					
												ExecuteNQ($InsertSMSDetails);
					// die();
					                            $SendSMS = CreateSMSURL("Amount Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
												 }
											 }
												 
											 ?>
											  
											 <?php 
											 
										 }
										 else
										 {
											 ?>
											     <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Card</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;"><?php echo number_format($amount,2)?></td>
                                                    </tr>
											 <?php
											 if($amount!="0")
												 {
											    $seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
												 $FirstName=$seldpdep[0]['FirstName'];
												 $CustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												 
												
				
												$SMSContentforImmediate="Dear ".$FirstName.", recd amt Rs ".$amount." /-. Thank You. Pls share feedback & help us to make your experience flawless.";
		
					// echo "In if<br>";
												$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".DecodeQ($_GET['uid'])	."','".$seldp[0]['StoreID']."','".$seldp[0]['CustomerID']."','','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."')";
					
												ExecuteNQ($InsertSMSDetails);
					// die();
					                            $SendSMS = CreateSMSURL("Amount Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
												 }
										 }
										?>
                                                                                          
                                                    
                                                  </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											<?php
										}
										elseif($flag=='BOTH')
										{
										
												$seldppayP=select("*","tblInvoiceDetails","AppointmentId='".DecodeQ($_GET['uid'])."' and Flag='".$flag."'");
												//print_r($seldppayP);
									    $cashamount=$seldppayP[0]['CashAmount'];
										$cardamount=$seldppayP[0]['CardAmount'];
											?>
											<tr>
											<td id="payment">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                	<tr>
                                                    <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                    </tr>
													         			<?php
										 if($id!="")
										 {
											
											 if($paidamt!="" && $pendingamt!="" && $paidamt!="0" && $pendingamt!="0")
											 {
												 ?>
												  <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Paid Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($paidamt,2)?></td>
                                                    </tr>
													  <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($pendingamt,2)?></td>
                                                    </tr>
													
											 
                                                    <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Cash Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($cashamount,2)?></td>
                                                    </tr>
                                                      <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Card Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($cardamount,2)?></td>
                                                    </tr>
                                                  <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total Payment</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right;padding-right:05%" ><?php echo number_format($total,2);?></td>
                                                    </tr>
											 
												 <?php
												  if($total!="0")
												 {
												    $seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
												 $FirstName=$seldpdep[0]['FirstName'];
												 $CustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												 
												
				
												$SMSContentforImmediate="Dear ".$FirstName.", recd amt Rs ".$total." /-. Thank You. Pls share feedback & help us to make your experience flawless.";
		
					// echo "In if<br>";
												$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".DecodeQ($_GET['uid'])	."','".$seldp[0]['StoreID']."','".$seldp[0]['CustomerID']."','','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."')";
					
												ExecuteNQ($InsertSMSDetails);
					// die();
					                            $SendSMS = CreateSMSURL("Amount Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
												 }
											 }
											 else
											 {
												
												  if($pendingamt!="" && $pendingamt!="0")
											      {
												 ?>
												 <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Pending Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($pendingamt,2)?></td>
                                                    </tr>
												 <?php
											 }
											 elseif($paidamt!="" && $paidamt!="0")
											 {
												 ?>
												 <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Paid Amount</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($paidamt,2)?></td>
                                                    </tr>
												 <?php
											 }
											 ?>
											 
                                                    <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Cash</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($cashamount,2)?></td>
                                                    </tr>
                                                      <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Card</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($cardamount,2)?></td>
                                                    </tr>
                                                  <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total Payment</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right;padding-right:05%" ><?php echo number_format($total,2);?></td>
                                                    </tr>
											 <?php
												if($total!="0")
												 {
												  $seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
												 $FirstName=$seldpdep[0]['FirstName'];
												 $CustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												 
												
				
												$SMSContentforImmediate="Dear ".$FirstName.", recd amt Rs ".$total." /-. Thank You. Pls share feedback & help us to make your experience flawless.";
		
					// echo "In if<br>";
												$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".DecodeQ($_GET['uid'])	."','".$seldp[0]['StoreID']."','".$seldp[0]['CustomerID']."','','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."')";
					
												ExecuteNQ($InsertSMSDetails);
					// die();
					                            $SendSMS = CreateSMSURL("Amount Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
												 }
											 }
												 
											
											 
										 }
										 else
										 {
											
											 ?>
											 
                                                    <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Cash</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($cashamount,2)?></td>
                                                    </tr>
                                                      <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Card</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%"><?php echo number_format($cardamount,2)?></td>
                                                    </tr>
                                                  <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total Payment</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right;padding-right:05%" ><?php echo number_format($total,2);?></td>
                                                    </tr>
											 <?php
											 if($total!="0")
												 {
											   $seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
												 $FirstName=$seldpdep[0]['FirstName'];
												 $CustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												 
												
				
												$SMSContentforImmediate="Dear ".$FirstName.", recd amt Rs ".$total." /-. Thank You. Pls share feedback & help us to make your experience flawless.";
		
					// echo "In if<br>";
												$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".DecodeQ($_GET['uid'])	."','".$seldp[0]['StoreID']."','".$seldp[0]['CustomerID']."','','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."')";
					
												ExecuteNQ($InsertSMSDetails);
					// die();
					                            $SendSMS = CreateSMSURL("Amount Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
												 }
										 }
										 ?>
													
													
													
													
													
                                                            
                                                
                                                                                                       
                                                    
                                                  </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											
											<?php
										}
										else
										{
										 
											?>
											<tr>
											<td style="display:none" id="payment">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                	<tr>
                                                    <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                    </tr>
                                                    <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;"></td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Cash</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:right; padding-right:05%;"><input type="number" id="paymentid" name="cashamt" value="<?php echo $total; ?>" onkeyup="test()"/></td>
                                                    </tr>
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total Payment</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;" ><input id="totalpayment" name="totalpayment"/></td>
                                                    </tr>
                                                                                                       
                                                    
                                                  </tbody>
                                                                                                    
                                                </table>
                                            </td>
											</tr>
											<?php
											if($total!="0")
												 {
											  $seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
												 $FirstName=$seldpdep[0]['FirstName'];
												 $CustomerMobileNo=$seldpdep[0]['CustomerMobileNo'];
												 $DateInsertUpdate=date("Y-m-d H:i:s");
												 
												
				
												$SMSContentforImmediate="Dear ".$FirstName.", recd amt Rs ".$total." /-. Thank You. Pls share feedback & help us to make your experience flawless.";
		
					// echo "In if<br>";
												$InsertSMSDetails="Insert into tblAppointmentsReminderSMS (AppointmentID, StoreID, CustomerID, AppointmentDate, SuitableAppointmentTime,  SMSSendTime, Status, ContentSMS,SendSMSTo)values('".DecodeQ($_GET['uid'])	."','".$seldp[0]['StoreID']."','".$seldp[0]['CustomerID']."','','','".$DateInsertUpdate."',0,'".$SMSContentforImmediate."', '".$CustomerMobileNo."')";
					
												ExecuteNQ($InsertSMSDetails);
					// die();
					                            $SendSMS = CreateSMSURL("Amount Received","0","0",$SMSContentforImmediate,$CustomerMobileNo);
												 }
											
										}
										?>
                                   
                                        <tr>
                                        
                                         <td  style="BACKGROUND:#d0ad53;">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                              
                                                <tbody>
                                        
                                        
                                        
                                            <td width="33%" style="FONT-FAMILY:Arial,Helvetica,sans-serif;BACKGROUND:#d0ad53;COLOR:#000;FONT-SIZE:12px; padding:1%;" height="32" align="center">
                                            <span style="font-size:14px; font-weight:600;" >KHAR | BREACH CANDY | ANDHERI | COLABA | LOKHANDWALA</span><br>
                                            </td>
											<tr>
                                            	<td style="BACKGROUND:#d0ad53;font-size:18px;font-weight:bold;" align="center"> Go Green, Go Paperless !</td>
                                            </tr>
                                            
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
</body>

</html>
			

<table align="right">
	<tr align="right">
	
			<!--<a href="appointment_invoice.php" class="btn btn-primary btn-sm " style="float: right;">Print</a>-->
		<?php
		$seldp=select("*","tblAppointments","AppointmentID='".DecodeQ($_GET['uid'])."'");
		$STORED=$seldp[0]['StoreID'];
	?>
			<td align="right"><button onclick="sendmail()" class="btn btn-success">Send Email to Client<div class="ripple-wrapper"></div></button></td>
		
		<td align="right">
			<!--<a href="appointment_invoice.php" class="btn btn-primary btn-sm " style="float: right;">Print</a>-->
			<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
		</td>
		
		<td align="right">
			<a href="appointment_invoice.php" class="btn btn-primary btn-sm" style="float: right;">Go Back</a>
		</td>
		<td align="right">
		<?php// require_once("incBillingSMS.php"); ?>
		</td>
		
	</tr>
</table>
