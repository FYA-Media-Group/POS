<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
 <style>
												.con  {
												height:200px;
												width:100%;
												border:1px solid #d0ad53;
												}												
												</style>
 <style>
												.con  {
												height:200px;
												width:100%;
												border:1px solid #d0ad53;
												}												
												</style>
<?php 
		 $DB = Connect();
$app_id=$_POST['app_id'];
// $datap=$_POST['datap'];


			
								$message ='<table id="printinvoice" style="display:none" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody>
        <tr>
            <td>
                <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
                    <tbody>
                        
                        <tr>
                            <td>
                                <table style="BORDER-BOTTOM:#d0ad53 1px solid;BORDER-LEFT:#d0ad53 1px solid;BORDER-TOP:#d0ad53 1px solid;BORDER-RIGHT:#d0ad53 1px solid;background:url("http://nailspaexperience.com/images/test3.png") no-repeat; background-position:50% 20%;" border="0" cellspacing="0" cellpadding="0" width="98%" bgcolor="#ffffff" align="center"><tbody>';
								
										$seldp=select("*","tblAppointments","AppointmentID='".$app_id."'");
									$seldpd=select("StoreBillingAddress","tblStores","StoreID='".$seldp[0]['StoreID']."'");
									$seldpde=select("InvoiceID","tblInvoice","AppointmentID='".$app_id."'");
									$seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
									
								
									
                                   $message .='<tr>
										
                                            <td align="middle">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td width="50%" align="left" style="padding:1%;"><img border="0" src="http://nailspaexperience.com/header/Nailspa-logo.png" width="117" height="60"></td>
                                                            <td width="50%" align="right" style="LINE-HEIGHT:15px; padding:1%; FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal;" id="address">';
                                                          
															echo $seldpd[0]['StoreBillingAddress'];
															
                                                          $message .='  </td>
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
                                                      <tr>
														<td width="50%">To ,</td>
														<td width="25%" >Invoice No :</td>
														<td width="25%"style="float:left;" id="invoiceid">'; echo $seldpde[0]['InvoiceID']; 
													$message .='</td> </tr>
													   <tr>
														<td width="50%" id="to"><b>';
                                         echo $seldpdep[0]['CustomerFullName'] ;

                                                        $message .='</b></td>
														<td width="25%">Membership No :</td>
														<td width="25%"style="float:left;"></td>
													  </tr>
													     <tr>
														<td width="50%" id="email">';

echo $seldpdep[0]['CustomerEmailID'] ;

$message .='</td>
														<td width="25%">Renewal No :</td>
														<td width="25%" style="float:left;"></td>
													  </tr>
													       <tr>
														<td width="50%" id="mobile">';
echo $seldpdep[0]['CustomerMobileNo'];
$message .='</td>
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
                                            <td style="LINE-HEIGHT:0;BACKGROUND:#d0ad53;FONT-SIZE:20px;text-align:center;" height="30"><b>Services</b></td>
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
                                                          <th width="10%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Code</th>
                                                          <th width="60%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:left; padding-left:2%;">Item Description</th>
														   <th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Quantity</th>
                                                          <th width="15%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold;">Amount</th>
														
                                                        </tr>';
													
														$seldpdept=select("*"," tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."'");
														$sub_total=0;
														
														$countersaif = "";
														$counterusmani = "1";
														foreach($seldpdept as $val)
														{
															$countersaif ++;
															$counterusmani = $counterusmani + 1;
															$totalammt=0;
															$servicee=select("*","tblServices","ServiceID='".$val['ServiceID']."'");
															$qtyyy=$val['qty'];
															$amtt=$val['ServiceAmount'];
															$totalammt=$qtyyy*$amtt;
															$total=0;
															
															
                                                      $message .='  <tr>
                                                          <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;" id="servicecode">';
echo $servicee[0]['ServiceCode'];
$message .='</td>
                                                          <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;" id="servicename">';
 echo $servicee[0]['ServiceName'];
$message .='</td>
														    <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;" id="qty">';
															echo $val['qty'];
															
														$message .=' </td>
                                                          <td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;" id="totalammt">';    
                                            echo $totalammt.".00"; 
														
														 
														  $sub_total=$sub_total+$totalammt;
														  $total=$total+$sub_total;
														  
														  
														
                                                       $message .='</td>
														  
                                                        </tr>
														<tr>';
														
															$seldember=select("*","tblAppointments","AppointmentID='".$app_id."'");
															$memid=$seldember[0]['memberid'];
														if($memid!="0")
														{
															
															 
			$DB = Connect();
			
		
				$seldatap=select("DiscountType","tblMembership","MembershipID='".$memid."'");	
				$type=$seldatap[0]['DiscountType'];
          if($type=='1')
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
						//echo $membershipname.",".$Discount.",".$serviceid.",";
						

						$message .='<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">';
echo $membershipname;
$message .='</td>
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;">';

echo $Discount;
$message .='Amount Membership Discount </td>
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"></td>
						<td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">';
						echo $Discount.".00" ;
				
														 
														 
														  $sub_total=$sub_total-$Discount;
														  $total=$total+$sub_total;
														  
														  
														  
$message .='</td> 
						<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"></td>';
						
						
						//echo "<br/>";
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
			  
					$serviceid=$val['ServiceID'];
					$serviceamount=$val['ServiceAmount'];
					$qty=$val['qty'];
					$amount=$qty*$serviceamount;
					$totalamount=$amount*$Discount/100;
					if(in_array($val['ServiceID'],$sericesd))
					{
						
					}
					else
					{
						//echo $membershipname.",".$Discount.",".$totalamount.",".$serviceid.",";
						
						$message .='<td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">';
echo $membershipname;
$message .='</td><td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;">';
echo $Discount;
$message .='% Membership Discount </td><td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; padding-left:2%;"></td><td id="cost" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;">';
						
					echo $totalamount.".00";
														 
														 
														  $sub_total=$sub_total-$totalamount;
														  //$total=$total+$sub_total;
														  
														  
														
$message .='</td><td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:normal; text-align:center;"></td>';
						
						
					}
						
		  }
					
						
						$DB->close();
														   
															
														}
														else
														{
															
														}
														
													
														$message .='  </tr>';
														 
													
															
														
														}
													
													
												

														
									
														
                                                        
                                                        
                                                   $message .='   </tbody>
                                              
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
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;">';
echo number_format($sub_total,2); 
													 // $sub_total=0;
													
$message .='</td>
                                                    </tr>
													<tr>';
													
												
														//print_r($value);
														//echo $value['AppointmentDetailsID'];
														$sqlExtraCharges=select("DISTINCT (ChargeName), SUM( ChargeAmount ) AS Sumarize","tblAppointmentsCharges","AppointmentID ='".$app_id."' GROUP BY ChargeName");
													//print_r($sqlExtraCharges);
													
													foreach($sqlExtraCharges as $vaqq)
													{
															$strChargeNameDetails = $vaqq["ChargeName"];
						                              $strChargeAmountDetails = $vaqq["Sumarize"];
													
														  $message .='<tr>
										  <td width="50%">&nbsp;</td>
										  <td width="30%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">';
echo $strChargeNameDetails;
$message .='</td>
										  <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;">';
echo $strChargeAmountDetails ;
$message .='</td>
										</tr>';
									
										$amountdetail=$amountdetail+$strChargeAmountDetails;
													}
													$total=0;
										//echo 
										$total=$total+$sub_total+$amountdetail;
												
													
										
													
			/* 	//echo $sqlExtraCharges;
				$RScharges = $DB->query($sqlExtraCharges);
				if ($RScharges->num_rows > 0) 
				{
					while($rowcharges = $RScharges->fetch_assoc())
					{
						echo $strChargeNameDetails = $rowcharges["ChargeName"];
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
				} */
                
				
			$message .='	</tr>
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;" id="totalvalue">';
 echo $total;
													  
													 
$message .='</td>
                                                    </tr>
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Round Off</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;">'; 
													  echo round($total);
													//  $total=0;
													 
$message .='</td>
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
                                        <tr>
                                            <td  id="payment">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                                
                                                
                                                <tbody>
                                                
                                                	<tr>
                                                    <td colspan="3" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:16px;FONT-WEIGHT:bold; text-align:center;">Payments</td>
                                                    </tr>
                                                    <tr>
                                                      <td width="50%" style="LINE-HEIGHT:25px;PADDING-LEFT:5px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;">Payment</td>
                                                      <td width="30%" id="displaytext" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Cash</td>
                                                      <td width="20%" style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;">'; echo $total; 
$message .='</td>
                                                    </tr>
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:14px;FONT-WEIGHT:bold; text-align:right;">Total Payment</td>
                                                      <td style="LINE-HEIGHT:25px;FONT-FAMILY:Verdana,Geneva,sans-serif;COLOR:#000;FONT-SIZE:12px;FONT-WEIGHT:bold; text-align:center;" id="totalpayment">'; echo $total; 
$message .='</td>
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
                                      
                                        
                                                                         
                                        
                                        
                                        <tr>
                                            <td height="8"></td>
                                        </tr>
                                        
                                         <tr>
										
												<td>
                                           <div class="con">
												<p align="center">Advertisement </p>
										   </div>
										   </td>
                                        </tr>
                                        <tr>
                                        
                                         <td  style="BACKGROUND:#d0ad53;">
                                                <table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
                                              
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
</table>';


//echo $message;

										$seldp=select("*","tblAppointments","AppointmentID='".$app_id."'");
										
									$seldpd=select("StoreBillingAddress","tblStores","StoreID='".$seldp[0]['StoreID']."'");
									$seldpde=select("InvoiceID","tblInvoice","AppointmentID='".$app_id."'");
									$seldpdep=select("*","tblCustomers","CustomerID='".$seldp[0]['CustomerID']."'");
						
$strTo = $seldpdep[0]['CustomerEmailID'];
				$strFrom = "order@fyatest.website";
				$strSubject = "Invoice Details";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2 */

				 $Name = $seldpdep[0]['CustomerFullName'];
				$Email = $seldpdep[0]['CustomerEmailID'];
			
				$strBody=$message;
$sqlInsert8 = "INSERT INTO tblAdminMail (Id,ToEmail, FromEmail, Subject, Body,flag,status) VALUES ('".$app_id."', '$strTo', '$strFrom', '$strSubject', '$strBody','I','0')";
				//echo $sqlInsert8;
				$DB->query($sqlInsert8);
				//ExecuteNQ($sqlInsert8);
				
				$DB->close();
	
				
				$strMyTables = "tblAdminMail";
$strMyTableIDs = "MailId";


$DB = Connect();
	$sql = "Select * FROM tblAdminMail where status='0'";
	$RS = $DB->query($sql);
	if ($RS->num_rows > 0) 
	{
		$counter = 0;

		while($row = $RS->fetch_assoc())
		{
			$strid = $row["MailId"];
			$strTo = $row["ToEmail"];
			$strFrom = $row["FromEmail"];
			$strSubject = $row["Subject"];
			$strBody = $row["Body"];
			
			$headers = "From: $strFrom\r\n";
			$headers .= "Content-type: text/html\r\n";

			// Mail sending 
			$retval = mail($strTo,$strSubject,$strBody,$headers);

			if( $retval == true )
			{
				$sqlUpdate = "update $strMyTables set DateOfSending=now() , status='1' where $strMyTableIDs='".$strid."'";
				//echo $sqlUpdate;
				ExecuteNQ($sqlUpdate);
				echo "Email sent to " . $strTo . "<br>";
			}
			else
			{
				$sqlUpdate = "update $strMyTables set DateOfSending=now() , status='2' where $strMyTableIDs='".$strid."'";
				ExecuteNQ($sqlUpdate);
				echo "<font color='red'>Email sending failed to " . $strTo . "<br></font>";
			}	
		}
		//die();
	}
	else
	{
		echo"No Emails in database to send";
		//die();
	}
$DB->close();
				

				
?>
 