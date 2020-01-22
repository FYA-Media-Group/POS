<?php
//get data
//-------------- Functions used on this page starts ------------------//

function Filter($data) 
{
	// Every thing from form or query string must come through this function
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function IsNull($Value)
{
	if($Value=="" || $Value==null)
	{
		return true;
	}
	else
	{
		return false;
	}

}
	function select($col,$table,$cond)
	{
		//echo 1234;
		$servername = ServerName();
		$username = Username();
		$password = Password();
		$dbname = DBName();

		$conn = new mysqli($servername, $username, $password, $dbname);
		if (mysqli_connect_error()) 
		{
			die('Connect Error (' . mysqli_connect_errno() . ') '
					. mysqli_connect_error());
		}
		$sql="select $col from $table where $cond";
		// echo $sql;
		$ans=$conn->query($sql) or die($conn->error);
		//print_r($ans);
		
		if($ans->num_rows>0)
		{
			while($result = $ans->fetch_assoc())
	         {
			//	print_r($result);
				$data[]=$result;
				//print_r($data);
				
			}
			return $data;
		}
		else
		{
			return 0;
		}
		$conn->close();
	}
function FormatDateTime($param_date, $paramname)
{
	$date=date_create($param_date);
	if($paramname=="1")
	{
		return date_format($date,"jS M Y H:i:s");
	}
	else
	{
		return date_format($date,"jS M Y");
	}
}


function ServerName()
{
	return "43.225.52.142";
}
function Username()
{
	return "nailspae_saiffya";
}
function Password()
{
	return "saif@123";
}
function DBName()
{
	return "nailspae_dbpos";
}


function Connect()
{
	$servername = ServerName();
	$username = Username();
	$password = Password();
	$dbname = DBName();

	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if (mysqli_connect_error()) 
	{
	    die('Connect Error (' . mysqli_connect_errno() . ') '
	            . mysqli_connect_error());
	}
	return $conn;
}


//-------------- Functions used on this page ends ------------------//




//-------------- Setting the conditions for report starts ------------------//

$DB = Connect();
$strFromDate = Filter($_GET["from"]);
$strToDate = Filter($_GET["to"]);
$storr=$_GET["Store"];

//Date Conditions
	if(!IsNull($strFromDate))
		{
			$sqlTempfrom = " and Date(tblInvoiceDetails.OfferDiscountDateTime)>='".$strFromDate."'";
			$sqlTempfrom1 = " and Date(tblAppointmentMembershipDiscount.DateTimeStamp)>='".$strFromDate."'";
			$sqlTempfrom2 = " and Date(tblGiftVouchers.RedempedDateTime)>='".$strFromDate."'";
			$sqlTempfrom3 = " and Date(tblPendingPayments.DateTimeStamp)>='".$strFromDate."'";
			$sqlTempfrom4 = " and Date(tblGiftVouchers.Date)>='".$strFromDate."'";
		}
		else
		{
			$sqlTempfrom = "";
		}

		if(!IsNull($strToDate))
		{
			$sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<='".$strToDate."'";
			$sqlTempto1 = " and Date(tblAppointmentMembershipDiscount.DateTimeStamp)<='".$strToDate."'";
			$sqlTempto2 = " and Date(tblGiftVouchers.RedempedDateTime)>='".$strToDate."'";
			$sqlTempto3 = " and Date(tblPendingPayments.DateTimeStamp)>='".$strToDate."'";
			$sqlTempto4 = " and Date(tblGiftVouchers.Date)>='".$strToDate."'";
		}
		else
		{
			$sqlTempto="";
		}

	$filenamestamp = "Daily Audit Sale";

//-------------- Setting the conditions for report ends ------------------//




// Data control parameter
$Orientation = "L";
$Downloadfilename = 'DailySales'.date('Y-m-d').$filenamestamp.date('h:i:sa').'.pdf';
$logoimagefile = "tcpdf_logo.jpg";
$documentheading = "Daily Sales Reports";
$documentdescription = "This is the report of Sales with date filter from - ".$strFromDate." to - ".$strToDate;
$logowidth = "50";


$HTMLContent = "";

				
						$HTMLContent .= '<table id="printdata" class="table table-bordered table-striped table-condensed cf">
						                                   <thead class="cf">
																<tr>';
																
																if($storrr=='0')
													            {
															
																	$HTMLContent .= '<th>Sr</th>
																	<th>Customer Name</th>
																	<th>Customer Email</th>
																	<th class="numeric">Service Sale</th>
																	<th class="numeric">Product Sale</th>
																	<th class="numeric">GV Sale</th>
																	<th class="numeric">GV Discount</th>
																	<th class="numeric">Package Sale</th>
																	<th class="numeric">Membership Sale</th>
																	<th class="numeric">Membership Discount</th>
																	<th class="numeric">Offer Discount</th>
																	<th class="numeric">Service Tax</th>
																	<th class="numeric">Invoice Amount</th>
																	<th class="numeric">Total Sale</th>
																	<th class="numeric">Current Pending</th>
																	<th class="numeric">Card Amount</th>
																	<th class="numeric">Cash Amount</th>
																	<th>Check In Time</th>
																	<th>Check Out Time</th>
																	<th>Store</th>';
																
																}
																else
																{
																
																	$HTMLContent .= '<th>Sr</th>
																	<th>Customer Name</th>
																	<th>Customer Email</th>
																	<th class="numeric">Service Sale</th>
																	<th class="numeric">Product Sale</th>
																	<th class="numeric">GV Sale</th>
																	<th class="numeric">GV Discount</th>
																	<th class="numeric">Package Sale</th>
																	<th class="numeric">Membership Sale</th>
																	<th class="numeric">Membership Discount</th>
																	<th class="numeric">Offer Discount</th>
															  		<th class="numeric">Service Tax</th>
																	<th class="numeric">Invoice Amount</th>
																	<th class="numeric">Total Sale</th>
																	<th class="numeric">Current Pending</th>
																	<th class="numeric">Card Amount</th>
																	<th class="numeric">Cash Amount</th>
																	<th>Check In Time</th>
																	<th>Check Out Time</th>';
																	
																	
																}
																	
																$HTMLContent .= '</tr>
															</thead>
							                              
															<tbody>';
							

$storr=$_GET["Store"];

if(!empty($storr))
{
	
	$sqlservice = "SELECT tblInvoiceDetails.CustomerFullName,tblInvoiceDetails.CustomerID,tblInvoiceDetails.ServiceAmt,tblInvoiceDetails.ServiceName,tblInvoiceDetails.RoundTotal,tblInvoiceDetails.CashAmount,tblInvoiceDetails.CardAmount,tblInvoiceDetails.Membership_Amount,tblAppointments.StoreID,tblInvoiceDetails.AppointmentId,tblAppointments.AppointmentCheckInTime,tblAppointments.AppointmentCheckOutTime,tblInvoiceDetails.GVPurchasedID from tblInvoiceDetails left join tblAppointments 
 on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='".$storr."' and tblAppointments
.Status='2' $sqlTempfrom $sqlTempto";
}
else
{
$sqlservice = "SELECT tblInvoiceDetails.CustomerFullName,tblInvoiceDetails.CustomerID,tblInvoiceDetails.ServiceAmt,tblInvoiceDetails.ServiceName,tblInvoiceDetails.RoundTotal,tblInvoiceDetails.CashAmount,tblInvoiceDetails.CardAmount,tblInvoiceDetails.Membership_Amount,tblAppointments.StoreID,tblInvoiceDetails.AppointmentId,tblAppointments.AppointmentCheckInTime,tblAppointments.AppointmentCheckOutTime,tblInvoiceDetails.GVPurchasedID from tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID left join tblPendingPayments on tblInvoiceDetails.AppointmentId=tblPendingPayments.AppointmentID  where tblAppointments.StoreID!='0' and tblAppointments
.Status='2' $sqlTempfrom $sqlTempto";
}

		

		
		$RSservice = $DB->query($sqlservice);
		if ($RSservice->num_rows > 0) 
		{
			$counterservice = 0;

			while($rowservice = $RSservice->fetch_assoc())
			{
				$toatlseramt="";
				$counterservice ++;
				$CustomerFullName = $rowservice["CustomerFullName"];
				$RoundTotal = $rowservice["RoundTotal"];
			  
			
				$ServiceAmt = $rowservice["ServiceAmt"];
				$ServiceName = $rowservice["ServiceName"];
				$CustomerID = $rowservice["CustomerID"];
				$sepqts=select("*","tblCustomers","CustomerID='".$CustomerID."'");
				$CustomerEmailID=$sepqts[0]['CustomerEmailID'];
				$StoreID = $rowservice["StoreID"];
				$AppointmentId = $rowservice["AppointmentId"];
				$sepqt=select("*","tblPendingPayments","Status='1' and PendingStatus='2' and AppointmentID='".$AppointmentId."' $sqlTempfrom3 $sqlTempto3");
				$PendingAmount=$sepqt[0]['PendingAmount'];
				$sepqtQW=select("count(*)","tblPendingPayments","Status='1' and PendingStatus='2' and AppointmentID='".$AppointmentId."' $sqlTempfrom3 $sqlTempto3");
				$cnttt=$sepqtQW[0]['count(*)'];
				 if($cnttt>0)
				{
				$CashAmount = $rowservice["CashAmount"];
				$CardAmount = $rowservice["CardAmount"];	
			    if($CashAmount!="0.00")
				{
					$CashAmount=$RoundTotal-$PendingAmount;
				}
				elseif($CardAmount!="0.00")
				{
						$CardAmount =$RoundTotal-$PendingAmount;
				}
				
				
			
				}
				else
				{
					$CashAmount = $rowservice["CashAmount"];
				$CardAmount = $rowservice["CardAmount"];
				}
				
			
				
				
				$Membership_Amount = $rowservice["Membership_Amount"];
				$memamtfirst = explode(",", $Membership_Amount);

				$memamtfirst=str_replace(",", "", $Membership_Amount);
				$Totalmemamtfirst += $memamtfirst;
						
						if($memamtfirst=='')
						{
							$memamtfirst="0.00";
						}
			    $sepqtpt=select("sum(ChargeAmount) as sumcharge","tblAppointmentsChargesInvoice","AppointmentID='".$AppointmentId."'");
				
				$tax=$sepqtpt[0]['sumcharge'];
				
			
				
				$OpenTime=$rowservice['AppointmentCheckInTime'];
			    $CloseTime=$rowservice['AppointmentCheckOutTime'];
				$sepqtp=select("sum(OfferAmount) as offamt,sum(MembershipAmount) as memamt","tblAppointmentMembershipDiscount","AppointmentID='".$AppointmentId."' $sqlTempfrom1 $sqlTempto1");
				$offamt=$sepqtp[0]['offamt'];
				$memamt=$sepqtp[0]['memamt'];
				
			$GVPurchasedID = $rowservice["GVPurchasedID"];
					$sepqteww=select("*","tblGiftVouchers","GiftVoucherID='".$GVPurchasedID."' and AppointmentID='".$AppointmentId."' $sqlTempfrom4 $sqlTempto4");
				
				$gPurchaseAmountt=$sepqteww[0]['Amount'];
				
				$sepqtew=select("*","tblGiftVouchers","Status='1' and RedempedBy='".$AppointmentId."' $sqlTempfrom2 $sqlTempto2");
				
				
				$gAmount=$sepqtew[0]['Amount'];
			if($gAmount =="")
			{
				$gAmount ="0.00";
			}
			else
			{
			
				$gAmount = $gAmount;
				
			}
			
			
			$TotalgAmount += $gAmount;
				$saleamount=$RoundTotal-$gAmount;
			if($saleamount =="")
			{
				$saleamount ="0.00";
			}
			else
			{
			
				$saleamount = $saleamount;
				
			}
			$Totalsaleamount += $saleamount;
	if($gPurchaseAmountt =="")
			{
				$gPurchaseAmountt ="0.00";
			}
			else
			{
			
				$gPurchaseAmountt = $gPurchaseAmountt;
				
			}
			$TotalgPurchaseAmountt += $gPurchaseAmountt;
				if($OpenTime!='0000-00-00 00:00:00')
				 {
					 	 $LoginTimet=date('h:i:s', strtotime($OpenTime));
				 }
				 else
				 {
					 	 $LoginTimet="00:00:00";
				 }
			
			  if($CloseTime!='0000-00-00 00:00:00')
				 {
					 	 $LogoutTimet=date('h:i:s', strtotime($CloseTime));
				 }
				 else
				 {
					 	 $LogoutTimet="00:00:00";
				 }
				
			    $serviceamts = explode(",",$ServiceAmt);
				$ServiceNames = explode(",",$ServiceName);
				$sep=select("*","tblStores","StoreID='".$StoreID."'");
		        $storename=$sep[0]['StoreName'];
			  if($CashAmount=='')
			  {
				  $CashAmount="0.00";
			  }
			    if($CardAmount=='')
			  {
				  $CardAmount="0.00";
			  }
			  
				for($i=0;$i<count($serviceamts);$i++)
				{
					$toatlseramt +=$serviceamts[$i];
				}
				unset($serviceamts);
			    $serviceamts="";
				
		if($toatlseramt =="")
			{
				$toatlseramt ="0.00";
			}
			else
			{
			
				$toatlseramt = $toatlseramt;
				
			}
			$Totaltoatlseramt += $toatlseramt;
			
		if($offamt =="")
			{
				$offamt ="0.00";
			}
			else
			{
			
				$offamt = $offamt;
				
			}
			$Totaloffamt += $offamt;
			if($tax =="")
			{
				$tax ="0.00";
			}
			else
			{
			
				$tax = $tax;
				
			}
			$Totaltax += $tax;
		if($memamt =="")
			{
				$memamt ="0.00";
			}
			else
			{
			
				$memamt = $memamt;
				
			}
			$Totalmemamt += $memamt;
			if($PendingAmount =="")
			{
				$PendingAmount ="0.00";
			}
			else
			{
			
				$PendingAmount = $PendingAmount;
				
			}
			$TotalPendingAmount += $PendingAmount;
			if($CashAmount =="")
			{
				$CashAmount ="0.00";
			}
			else
			{
			
				$CashAmount = $CashAmount;
				
			}
			$TotalCashAmount += $CashAmount;
			
			if($CardAmount =="")
			{
				$CardAmount ="0.00";
			}
			else
			{
			
				$CardAmount = $CardAmount;
				
			}
			$TotalCardAmount += $CardAmount;
			
			if($RoundTotal =="")
			{
				$RoundTotal ="0.00";
			}
			else
			{
			
				$RoundTotal = $RoundTotal;
				
			}
			$TotalRoundTotal += $RoundTotal;
			

							$HTMLContent .= '<tr id="my_data_tr_<?=$counterservice?>">';
									
						                              
																if($storrr=='0')
													            {
																
							
								$HTMLContent .= '<td><center><?=$counterservice?></center></td>
									<td><center><?=$CustomerFullName?></center></td>
									<td><center><?=$CustomerEmailID?></center></td>
									<td class="numeric"><center><?=$toatlseramt?></center></td>
									<td class="numeric"><center>-</center></td>
									
									<td class="numeric"><center><?=$gPurchaseAmountt?></center></td>
									<td class="numeric"><center><?=$gAmount?></center></td>
									<td class="numeric"><center>-</center></td>
									
									<td class="numeric"><center><?=str_replace("+", "", $memamtfirst)?></center></td>
									<td class="numeric"><center><?=$memamt?></center></td>
									<td class="numeric"><center><?=$offamt?></center></td>
								  	<td class="numeric"><center><?=$tax?></center></td>
									<td class="numeric"><center><?=$RoundTotal?></center></td>
									<td class="numeric"><center><?=$saleamount?></center></td>
							
									
								
									<td class="numeric"><center><?=$PendingAmount?></center></td>
									<td class="numeric"><center><?=$CardAmount?></center></td>
									<td class="numeric"><center><?=$CashAmount?></center></td>
									<td><center><?=$LoginTimet?></center></td>
									<td><center><?=$LogoutTimet?></b></center></td>
									<td><center><?=$storename?></center></td>';
								
																}
																else
																{
																							
							
								$HTMLContent .= '<td><center><?=$counterservice?></center></td>
									<td><center><?=$CustomerFullName?></center></td>
									<td><center><?=$CustomerEmailID?></center></td>
									<td class="numeric"><center><?=$toatlseramt?></center></td>
									<td class="numeric"><center>-</center></td>
									
									<td class="numeric"><center><?=$gPurchaseAmountt?></center></td>
									<td class="numeric"><center><?=$gAmount?></center></td>
									<td class="numeric"><center>-</center></td>
									
									<td class="numeric"><center><?=str_replace("+", "", $memamtfirst)?></center></td>
									<td class="numeric"><center><?=$memamt?></center></td>
									<td class="numeric"><center><?=$offamt?></center></td>
								  	<td class="numeric"><center><?=$tax?></center></td>
									<td class="numeric"><center><?=$RoundTotal?></center></td>
										<td class="numeric"><center><?=$saleamount?></center></td>
							
								
									<td class="numeric"><center><?=$PendingAmount?></center></td>
									<td class="numeric"><center><?=$CardAmount?></center></td>
									<td class="numeric"><center><?=$CashAmount?></center></td>
									<td><center><?=$LoginTimet?></center></td>
									<td><center><?=$LogoutTimet?></b></center></td>';
									
								
																}
								
								$HTMLContent .= '</tr>';
							

			}
			unset($serviceamts);
			$toatlseramt="";
			
			
		}
		else
		{

							
							$HTMLContent .= '<tr>';
								                      
																if($storrr=='0')
													            {
															
									$HTMLContent .= '<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>No Data Found</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>';
							
																}
																else
																{
																								
									$HTMLContent .= '<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>No Data Found</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								<td></td>';
								
																}

								$HTMLContent .= '</tr>';
							

	
		}	
	
						
					$HTMLContent .= '</tbody>
											<tbody>
														<tr>';
													
																if($storrr=='0')
													            {
															
															$HTMLContent .= '<td colspan="2">Total Amounts(s)</td>
															 <td class="numeric"></td>
															 <td class="numeric"><center><b>Rs. <?=$Totaltoatlseramt?>/-</b></center></td>
															 <td class="numeric"></td>
															 
															 
															   <td class="numeric"><center><b>Rs. <?=$TotalgPurchaseAmountt?>/-</b></center></td>
															  <td class="numeric"><center><b>Rs. <?=$TotalgAmount?>/-</b></center></td>
															 <td class="numeric"></td>
															 
															  <td class="numeric"><center><b>Rs. <?=$Totalmemamtfirst?>/-</b></center></td>
															 <td class="numeric"><center><b>Rs. <?=$Totalmemamt?>/-</b></center></td>
														      <td class="numeric"><center><b>Rs. <?=$Totaloffamt?>/-</b></center></td>
															    <td class="numeric"><center><b>Rs. <?=$Totaltax?>/-</b></center></td>
															  <td class="numeric"><center><b>Rs. <?=$TotalRoundTotal?>/-</b></center></td>
															   <td class="numeric"><center><b>Rs. <?=$Totalsaleamount?>/-</b></center></td>
															  
															  <td class="numeric"><center><b>Rs. <?=$TotalPendingAmount?>/-</b></center></td>
															  <td class="numeric"><center><b>Rs. <?=$TotalCardAmount?>/-</b></center></td>
															  <td class="numeric"><center><b>Rs. <?=$TotalCashAmount?>/-</b></center></td>
															  <td></td>
															  <td></td>
															  <td></td>';
														
																}
																else
																{
																	
															$HTMLContent .= '<td colspan="2">Total Amounts(s)</td>
															 <td class="numeric"></td>
															 <td class="numeric"><center><b>Rs. $Totaltoatlseramt?>/-</b></center></td>
															 <td class="numeric"></td>
															 
															 
															   <td class="numeric"><center><b>Rs. <?=$TotalgPurchaseAmountt?>/-</b></center></td>
															  <td class="numeric"><center><b>Rs. <?=$TotalgAmount?>/-</b></center></td>
															 <td class="numeric"></td>
															 
															  <td class="numeric"><center><b>Rs. <?=$Totalmemamtfirst?>/-</b></center></td>
															 <td class="numeric"><center><b>Rs. <?=$Totalmemamt?>/-</b></center></td>
														      <td class="numeric"><center><b>Rs. <?=$Totaloffamt?>/-</b></center></td>
															    <td class="numeric"><center><b>Rs. <?=$Totaltax?>/-</b></center></td>
															  <td class="numeric"><center><b>Rs. <?=$TotalRoundTotal?>/-</b></center></td>
															   <td class="numeric"><center><b>Rs. <?=$Totalsaleamount?>/-</b></center></td>
															  
															  <td class="numeric"><center><b>Rs. <?=$TotalPendingAmount?>/-</b></center></td>
															  <td class="numeric"><center><b>Rs. <?=$TotalCardAmount?>/-</b></center></td>
															  <td class="numeric"><center><b>Rs. <?=$TotalCashAmount?>/-</b></center></td>
															  <td></td>
															  <td></td>';
															
															 
																}
															
														$HTMLContent .= '</tr>
													</tbody>
						</table>';
$DB->close();


				

require_once('tcpdf_include.php');
require_once('incdatacontent.php');

$pdf->SetFont('times', '', 15);

$pdf->AddPage();

$html = <<<EOD
$HTMLContent
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '6', '', $html, 0, 1, 0, true, '', true);

// use D instead if I to save as output
$pdf->Output($Downloadfilename, 'D');

?>