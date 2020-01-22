<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Create and Verify Sales | Nailspa";
	$strDisplayTitle = "Create and Verify Sales Store Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "EnvelopeCreateandVerify.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
// code for not allowing the normal admin to access the super admin rights	


	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$strStep = Filter($_POST["step"]);
		
		if($strStep=="add")
		{
			
		}
		
		if($strStep=="edit")
		{
			
		}
	}	
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	
</head>

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
					

                    <div id="page-title">
                        <h2><?=$strDisplayTitle?></h2>
                    </div>
					<script type="text/javascript" src="assets/widgets/datepicker/datepicker.js"></script>
                    <script type="text/javascript">
                        /* Datepicker bootstrap */
                  $(function() {
                            "use strict";
                            $('.bootstrap-datepicker').bsdatepicker({
                                format: 'yyyy-mm-dd'
                            });
                        });
                    </script>
                    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker.js"></script>
                    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker-demo.js"></script>
                    <script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>
                    <script type="text/javascript" src="assets/widgets/timepicker/timepicker.js"></script>
                    <script type="text/javascript">
                        /* Timepicker */

                        $(function() {
                            "use strict";
                            $('.timepicker-example').timepicker();
                        });
                    </script>
					<script>
						$(function ()						
						{
							$("#reportdate").datepicker();
							
							
							
						});
					</script>	
<?php

if(!isset($_GET["uid"]))
{

?>					
					
                    <div class="panel">
						<div class="panel">
							<div class="panel-body">
								<a class="btn btn-primary btn-lg btn-" href="Dashboard.php"><i class="fa fa-backward"></i> &nbsp; Home/ Dashboard</a>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
							<?php
								//added by asmita ---Start
											$DB = Connect();
											$closef="SELECT DayOpenNCloseID FROM `tblOpenNClose` WHERE `DateNTime`='$Thisdate' and StoreID='$strStoreID'";
											
											// echo $closef."<br>";
											$RSf = $DB->query($closef);
											if ($RSf->num_rows > 0) 
											{
												while($rowf = $RSf->fetch_assoc())
												{
													$strDayOpenNCloseID = $rowf["DayOpenNCloseID"];
													// echo $strDayOpenNCloseID."<br>";
												}
											}
											
											// $abc=NOW();
											// $ClosDay="Update tblOpenNClose SET Status=2 and CloseTime=NOW() WHERE `DateNTime`='$Thisdate' and DayOpenNCloseID='$DayOpenNCloseID'";
											$date=date('y-m-d H:i:s');
											$ClosDay="UPDATE tblOpenNClose SET STATUS =  '2', CloseTime ='$date' ,CAdminID='$strAdminID' WHERE DateNTime = '$Thisdate'  AND DayOpenNCloseID ='$strDayOpenNCloseID' AND STATUS =  '1'";
											// echo $ClosDay."<br>";
											ExecuteNQ($ClosDay);
											
											
											// $DB=Connect();
											$First= date('Y-m-01');
											$Last= date('Y-m-t');
											$getTodaysDate = date("Y-m-d");
											// $getTodaysDate ="16-11-06";
											// $sqltotal="select Sum(tblInvoiceDetails.TotalPayment) as Total, SUM(tblInvoiceDetails.CashAmount)as CashTotal,SUM(tblInvoiceDetails.CardAmount)as CardTotal, tblAppointments.StoreID
														// from tblInvoiceDetails 
														// left join tblAppointments 
														// on tblInvoiceDetails.AppointmentID=tblAppointments.AppointmentID
														// where Date(tblInvoiceDetails.OfferDiscountDateTime)=Date('$getTodaysDate') and tblAppointments.StoreID ='$strStoreID'";
											// echo $sqltotal."<br>";
												$sqltotal="SELECT SUM(tblInvoiceDetails.RoundTotal)as Total,
SUM(tblInvoiceDetails.CashAmount) as CashTotal,SUM(tblInvoiceDetails.CardAmount) as CardTotal,SUM(tblInvoiceDetails.Membership_Amount) as Membership_Amount,Count(tblInvoiceDetails.GVPurchasedID) as GVPurchasedID from tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='$strStoreID' and tblAppointments.Status='2' and Date(tblInvoiceDetails.OfferDiscountDateTime)=Date('$getTodaysDate') ";
											// echo $sqltotal."<br>";
											$RSTotal = $DB->query($sqltotal);
											if ($RSTotal->num_rows > 0) 
											{
												while($rowstotal = $RSTotal->fetch_assoc())
												{
													$strtotal = $rowstotal["Total"];
													$strCashTotal = $rowstotal["CashTotal"];
													$strCardTotal = $rowstotal["CardTotal"];
													$strGVPurchased = $rowstotal["GVPurchasedID"];
													$strMembershipAmount = $rowstotal["Membership_Amount"];
													// echo $strtotal."<br>";
												}
											}
											else
											{
												$strtotal = "0";
											}
											$Pamt="Select SUM(tblPendingPayments.PendingAmount)as PendingAmt,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$strStoreID' and tblPendingPayments.PendingStatus=2 and tblAppointments.AppointmentDate='$getTodaysDate'";
											// echo $Pamt."<br>";
											$RSpamt = $DB->query($Pamt);
											if ($RSpamt->num_rows > 0) 
											{
												while($rowa = $RSpamt->fetch_assoc())
												{
													$PendingAmt = $rowa["PendingAmt"];
													if($PendingAmt=="")
													{
														$PendingAmt='0';
													}
													// echo $PendingAmt."<br>";
												}
											}
											$yr= date('Y');
											$CurrentMonth = date('m');			//$row["Month"];
											$Month = getMonthSpelling($CurrentMonth);
											$CurrMonth=date('m');
											$number = cal_days_in_month(CAL_GREGORIAN, $CurrMonth, $yr);
											// echo $number."<br>";
											$MT="Select TargetAmount from tblStoreSalesTarget where Year='$yr' and Month= '$Month' and StoreID='$strStoreID' ";
											// echo $MT."<br>";
											$RSMT = $DB->query($MT);
											if ($RSMT->num_rows > 0) 
											{
												while($rowMT = $RSMT->fetch_assoc())
												{
													$TargetAmount = $rowMT["TargetAmount"];
													$TodaysTarget= $TargetAmount/$number;
												}
											}
											if($TodaysTarget>$strtotal)
											{
												$TargetShort=$TodaysTarget-$strtotal;
												$FinalTarget=round($TargetShort);
											}
											else
											{
												$TargetShort="Target Achieved.";
											}
										
											$MAC1="SELECT tblInvoiceDetails.Membership_Amount  from tblInvoiceDetails Left Join tblAppointments ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID where tblAppointments.AppointmentDate='$getTodaysDate' and tblAppointments.StoreID='$strStoreID' and tblAppointments.Status='2'";
											// echo $strtotal."<br>";
											// echo $MAC1."<br>";
											$RSMT = $DB->query($MAC1);
											if ($RSMT->num_rows > 0) 
											{
												while($rowMT = $RSMT->fetch_assoc())
												{
													
													$Membership_Amount = $rowMT["Membership_Amount"];
													$memamtfirst = explode(",", $Membership_Amount);

													$memamtfirst=str_replace(",", "", $Membership_Amount);
													$Totalmemamtfirst += $memamtfirst;
														
														if($memamtfirst=='')
														{
															$memamtfirst="0.00";
														}
														
												}
											}
											$MAC2="SELECT Count(tblInvoiceDetails.Membership_Amount) as MemberCount from tblInvoiceDetails Left Join tblAppointments ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID where tblAppointments.AppointmentDate='$getTodaysDate' and tblAppointments.StoreID='$strStoreID' and tblAppointments.Status='2' AND tblInvoiceDetails.Membership_Amount!=''";
											
											
											$RSMTC = $DB->query($MAC2);
											if ($RSMTC->num_rows > 0) 
											{
												while($rowMTC = $RSMTC->fetch_assoc())
												{
													
													$Membership_Count = $rowMTC["MemberCount"];
													
												}
											}
											
											$PendingRec="Select (SELECT count(0) FROM tblAppointments where Status=2 and IsDeleted!='1' and ApproveStatus!='1' and AppointmentDate='$getTodaysDate' and StoreID='$strStoreID') as ApprovalPendingCount";
											// echo $PendingRec."<br>";
											$RSPR = $DB->query($PendingRec);
											if ($RSPR->num_rows > 0) 
											{
												while($rowPC = $RSPR->fetch_assoc())
												{
													$ApprovalPendingCount = $rowPC["ApprovalPendingCount"];
												}
											}
											$StoreName="Select StoreName from tblStores where StoreID='$strStoreID'";
											$RSSN = $DB->query($StoreName);
											if ($RSSN->num_rows > 0) 
											{
												while($rowSN = $RSSN->fetch_assoc())
												{
													$StoreName = $rowSN["StoreName"];
												}
											}
											$SelectTax="SELECT SUM( tblAppointmentsChargesInvoice.ChargeAmount ) AS ChargeAmount
														FROM  `tblAppointmentsChargesInvoice` 
														LEFT JOIN tblAppointments ON tblAppointmentsChargesInvoice.AppointmentID = tblAppointments.AppointmentID
														WHERE tblAppointments.AppointmentDate = '$getTodaysDate'
														AND tblAppointments.Status ='2'
														AND tblAppointments.StoreID =  '$strStoreID'
														And tblAppointments.FreeService!='1'
														AND tblAppointments.IsDeleted!='1'";
											 // echo $SelectTax."<br>";
											$RSSTAX = $DB->query($SelectTax);
											if ($RSSTAX->num_rows > 0) 
											{
												while($rowTX = $RSSTAX->fetch_assoc())
												{
													$ChargeAmount = $rowTX["ChargeAmount"];
													// echo $ChargeAmount."<br>";
												}
											}		
											$SelectServicesDone="Select tblInvoiceDetails.ServiceName from tblInvoiceDetails left Join tblAppointments ON  tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.AppointmentDate='$getTodaysDate' and tblAppointments.StoreID='$strStoreID'";
											// echo "<br>";
											// echo $SelectServicesDone."<br>";
											
												$RSDS = $DB->query($SelectServicesDone);
												
												if($RSDS->num_rows > 0) 
												{
													while($rowSSDS = $RSDS->fetch_assoc())
													{
														
														$ServiceName[] = $rowSSDS['ServiceName'];
														$cnt=0;
														foreach ($ServiceName as $Services)
														{
															$cnt++;
															$data_elements = implode(',',$Services); // extract all the comma seperated value in array
															// print_r($data_elements);
															// echo count($cnt)+$cnt."<br>";
															$final= count($cnt)+$cnt;
														}
													}	
																											
												}	

												$SelectServicesDonepackage="Select tblInvoiceDetails.PackageID from tblInvoiceDetails left Join tblAppointments ON  tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.AppointmentDate='$getTodaysDate' and tblAppointments.StoreID='$strStoreID' and tblInvoiceDetails.PackageIDFlag='P'";
											// echo "<br>";
											// echo $SelectServicesDone."<br>";
											
												$RSDSPAC = $DB->query($SelectServicesDonepackage);
												
												if($RSDSPAC->num_rows > 0) 
												{
													while($rowSSDSPACK = $RSDSPAC->fetch_assoc())
													{
														
														$PackageID[] = $rowSSDSPACK['PackageID'];
														
													}	
																											
												}
												$packagesale=COUNT($PackageID);
												
												$SelectServiceseCUST="Select distinct(tblAppointments.CustomerID) from tblAppointments where Date(tblAppointments.AppointmentDate)>=Date('".$getTodaysDate."') and Date(tblAppointments.AppointmentDate)<=Date('".$getTodaysDate."') and tblAppointments.Status='2' and tblAppointments.StoreID='$strStoreID'";
											// echo "<br>";
											// echo $SelectServicesDone."<br>";
											
												$RSDSPACCUST = $DB->query($SelectServiceseCUST);
												
												if($RSDSPACCUST->num_rows > 0) 
												{
													while($rowSSDSPACKCUST = $RSDSPACCUST->fetch_assoc())
													{
														
														$TOTALCUSTstore[] = $rowSSDSPACKCUST['CustomerID'];
														
													}	
																											
												}
												$totalstorecust=COUNT($TOTALCUSTstore);
												
												
												
												$SelectServiceseCUSToffer="Select count(distinct(AppointmentID)) as cntaaoff from tblAppointmentMembershipDiscount where DateTimeStamp='$getTodaysDate' and OfferID!='0'";
											// echo "<br>";
											// echo $SelectServicesDone."<br>";
											
												$RSDSPACCUSToffer = $DB->query($SelectServiceseCUSToffer);
												
												if($RSDSPACCUSToffer->num_rows > 0) 
												{
													while($rowSSDSPACKCUSTOffer = $RSDSPACCUSToffer->fetch_assoc())
													{
														
														$TOTALCUSTstoreoffer[] = $rowSSDSPACKCUSTOffer['cntaaoff'];
														
													}	
																											
												}
												$TOTALCUSTstoreoffercnt=COUNT($TOTALCUSTstoreoffer);
												
												
												$stu=select("distinct(tblAppointments.CustomerID)","tblCustomers LEFT JOIN tblAppointments ON tblCustomers.CustomerID = tblAppointments.CustomerID","tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService != '1' AND tblAppointments.Status =  '2' and tblAppointments.StoreID='$strStoreID' and Date(tblCustomers.RegDate)>=Date('".$getTodaysDate."') and Date(tblCustomers.RegDate)<=Date('".$getTodaysDate."')");
												  foreach($stu as $vqr)
												 {
													 $newcustt[]=$vqr['CustomerID'];
												 }
											    $newcntscut=count($newcustt);
												
												
												// echo $final."<br>";
											$sqltotalMonth="select Sum(tblInvoiceDetails.TotalPayment) as Total, SUM(tblInvoiceDetails.CashAmount)as CashTotal,SUM(tblInvoiceDetails.CardAmount)as CardTotal, tblAppointments.StoreID
														from tblInvoiceDetails 
														left join tblAppointments 
														on tblInvoiceDetails.AppointmentID=tblAppointments.AppointmentID
														where Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('$First') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('$Last') and tblAppointments.StoreID ='$strStoreID'";
											// echo $sqltotalMonth."<br>";
											
											$RSTotalMonth = $DB->query($sqltotalMonth);
											if ($RSTotalMonth->num_rows > 0) 
											{
												while($rowstotalMonth = $RSTotalMonth->fetch_assoc())
												{
													$strtotalMonth = $rowstotalMonth["Total"];
													$strCashTotalMonth = $rowstotalMonth["CashTotal"];
													$strCardTotalMonth = $rowstotalMonth["CardTotal"];
													// echo $strtotal."<br>";
												}
											}
											else
											{
												$strtotalMonth = "0";
											}
											$dtt=date('d/m/y');
											if($strCashTotal>$ChargeAmount)
											{
												$CashFinal=$strCashTotal-$ChargeAmount;
												// echo "In if<br>";
												// echo $CashFinal."<br>";
											}
											else
											{
												$CashFinal=$strCardTotal-$ChargeAmount;
												// echo "In else<br>";
												// echo $CashFinal."<br>";
											}
										
											
											
											
											$strStoreName1 = substr($StoreName, 0, 3);
											$myStoreName=strtoupper($strStoreName1);
											$Content= $myStoreName." dt ".$dtt." (SS)".$final.
											", (GV)".$strGVPurchased.
											", (PS)".$packagesale.
											", (MISC)".$ChargeAmount.
											", (TS)".$strtotal.
											", (MT)".$strtotalMonth.
											", (PA)".$PendingAmt.
											", CC".$strCardTotal.
											", Cash".$strCashTotal.
											", (MSC)".$Membership_Count.
											", (MA)".$Totalmemamtfirst.
											", (PRI)".$ApprovalPendingCount."";
											// echo $Content."<br>";
										   
										   $emailclosecontent="Store : ".$myStoreName." <br/> Date : ".$dtt." <br/>Service Sale : ".$final.
											"<br/> Gift Voucher : ".$strGVPurchased.
											"<br/> Package Sale : ".$packagesale.
											"<br/> Service Tax ".$ChargeAmount.
											"<br/> Total Sale : ".$strtotal.
											"<br/> Total Sale till Date : ".$strtotalMonth.
											"<br/> Pending Amount : ".$PendingAmt.
											"<br/> Card : ".$strCardTotal.
											"<br/> Cash : ".$strCashTotal.
											"<br/> Membership Sold Count : ".$Membership_Count.
											"<br/> Membership Amt : ".$Totalmemamtfirst.
											"<br/> Pending Reconcile Invoices : ".$ApprovalPendingCount."";
										   
										   
										   	$Content1= $myStoreName." dt ".$dtt." (SS)".$final.
											", (GV)".$strGVPurchased.
											", (PS)".$packagesale.
											", (MISC)".$ChargeAmount.
											", (TS)".$strtotal.
											", (MT)".$strtotalMonth.
											", (PA)".$PendingAmt.
											", (MSC)".$Membership_Count.
											", (MA)".$Totalmemamtfirst.
											", (PRI)".$ApprovalPendingCount."";
											
											 $emailclosecontent1="Store : ".$myStoreName." <br/> Date : ".$dtt." <br/>Service Sale : ".$final.
											"<br/> Gift Voucher : ".$strGVPurchased.
											"<br/> Package Sale : ".$packagesale.
											"<br/> Service Tax ".$ChargeAmount.
											"<br/> Total Sale : ".$strtotal.
											"<br/> Total Sale till Date : ".$strtotalMonth.
											"<br/> Pending Amount : ".$PendingAmt.
											"<br/> Membership Sold Count : ".$Membership_Count.
											"<br/> Membership Amt : ".$Totalmemamtfirst.
											"<br/> Pending Reconcile Invoices : ".$ApprovalPendingCount.""; 
											
											
											
											$Content2= $myStoreName." dt ".$dtt." (SS)".$final.
											", (GV)".$strGVPurchased.
											", (PS)".$packagesale.
											", (MISC)".$ChargeAmount.
											", (TS)".$strtotal.
											", (MT)".$strtotalMonth.
											", (TW)".$totalstorecust.
											", (NW)".$newcntscut.
											", (OR)".$TOTALCUSTstoreoffercnt.
											", (PA)".$PendingAmt.
											", (MSC)".$Membership_Count.
											", (MA)".$Totalmemamtfirst.
											", (PRI)".$ApprovalPendingCount."";
											
											$emailclosecontent2="Store : ".$myStoreName." <br/> Date : ".$dtt." <br/>Service Sale : ".$final.
											"<br/> Gift Voucher : ".$strGVPurchased.
											"<br/> Package Sale : ".$packagesale.
											"<br/> Service Tax ".$ChargeAmount.
											"<br/> Total Sale : ".$strtotal.
											"<br/> Total Sale till Date : ".$strtotalMonth.
											"<br/> Total Walkins : ".$totalstorecust.
											"<br/> New Walkins : ".$newcntscut.
											"<br/> Offer Redemption : ".$TOTALCUSTstoreoffercnt.
											"<br/> Pending Amount : ".$PendingAmt.
											"<br/> Membership Sold Count : ".$Membership_Count.
											"<br/> Membership Amt : ".$Totalmemamtfirst.
											"<br/> Pending Reconcile Invoices : ".$ApprovalPendingCount.""; 
											// $my='9867510596';
											// $SendSMS = CreateSMSURL("Nailspa","0","0",$Content,$my);	
											// $my1='9967716324';	
											// $SendSMS = CreateSMSURL("Nailspa Day Closing","0","0",$Content,$my1);	
											// $my3='9870975726';												
											// $SendSMS = CreateSMSURL("Nailspa Day Closing","0","0",$Content,$my3);	
											// $my4='9867678628';												
											// $SendSMS = CreateSMSURL("Nailspa Day Closing","0","0",$Content,$my4);	
											
											$SMSCheck="SELECT * FROM `tblOpenNClose` WHERE `DateNTime`='$Thisdate' and StoreID='$strStoreID'";
											
											// echo $SMSCheck."<br>";
											$RSSMS = $DB->query($SMSCheck);
											if ($RSSMS->num_rows > 0) 
											{
												while($rowSMS = $RSSMS->fetch_assoc())
												{
													$OpenTime = $rowSMS["OpenTime"];
													$CloseTime = $rowSMS["CloseTime"];
													$CloseStatus = $rowSMS["Status"];
													// echo $strDayOpenNCloseID."<br>";
													// echo $OpenTime."<br>";
													// echo $CloseTime."<br>";
													// echo $CloseStatus."<br>";
												}
											}
											if($CloseTime!='0000-00-00 00:00:00' && $OpenTime!='0000-00-00 00:00:00' && $CloseStatus=='2' )
											{
												// echo "In if<br>";
												$my='9867510596';
												$SendSMS = CreateSMSURL("Nailspa","0","0",$Content1,$my);	
												$myyo='8097910447';
												$SendSMS = CreateSMSURL("Nailspa","0","0",$Content1,$myyo);
												
												$myyoam='8097910447';
												$SendSMS = CreateSMSURL("Nailspa","0","0",$Content,$myyoam);
												
												$myyoammar='8097910447';
												$SendSMS = CreateSMSURL("Nailspa","0","0",$Content2,$myyoammar);
												//$my1='9967716324';	
												//$SendSMS = CreateSMSURL("Nailspa Day Closing","0","0",$Content,$my1);	
												$my3='9870975726';//noor												
												$SendSMS = CreateSMSURL("Nailspa Day Closing","0","0",$Content1,$my3);	
												$my4='9867678628';		//amyn										
												$SendSMS = CreateSMSURL("Nailspa Day Closing","0","0",$Content,$my4);
												$my5='9773237867';												
												$SendSMS = CreateSMSURL("Nailspa Day Closing","0","0",$Content1,$my5);
												$my6='9769014888';												
												$SendSMS = CreateSMSURL("Nailspa Day Closing","0","0",$Content1,$my6);
												$my7='9833395413';	
												$SendSMS = CreateSMSURL("Nailspa Day Closing","0","0",$Content2,$my7); 
												if($strStoreID=='3')
												{
													$my7='9821153667';												
													$SendSMS = CreateSMSURL("Nailspa Day Closing","0","0",$Content1,$my7);
												}
												
													$datexx=date('Y-m-d');
												    $seldpdep=select("*","tblStores","StoreID='".$strStoreID."'");
													$StoreName=$seldpdep[0]['StoreName'];
													$seldpdepaa=select("*","tblExpenses","StoreID='".$StoreID."' and Date(DateOfExpense)>=Date('$datexx') and Date(DateOfExpense)<=Date('$datexx')");
													$Contentmail = $StoreName."<br/>";
													foreach($seldpdepaa as $val)
													{
														$Contentmail .= "Remark : ".$val['Remark']."<br/> Amount :".$val['Amount']."";
													}
												////////////////////////////petty cash email///////////////////////////////		
													$strTo="operations@nailspaexperience.com,noor@nailspaexperience.com";
													//$strTo="yogitafya@hotmail.com,vinayfya@hotmail.com";
													if($strTo=="")
													{
														echo "Email Id Cannot Blank";
													}
													else
													{
															
															//$strFrom = "DayOpening@nailspaexperience.com";
															$strFrom = "PettyCashSpend@nailspaexperience.com";
															
															$strSubject = "Petty Cash Spend Detail";
															
															$path="`http://nailspaexperience.com/images/test2.png`";
		
															$message = file_get_contents('EmailFormat/PettyCashSpend.html');
															$message = str_replace("[\]",'',$message);

															//setup vars to replace
															$vars = array('{Path}','{Content}'); //Replace varaibles
															$values = array($path,$Contentmail);

															//replace vars
															$message = str_replace($vars,$values,$message);
															//echo $message;

																
															$strBodycnt = $message;
															
															
															//$strbody1="<html><head><title>Day Open</title></head><body>$Contentmail</body></html>";
															$headers = "From: $strFrom\r\n";
															$headers .= "Content-type: text/html\r\n";
															$strBodysa = $strBodycnt;
															// Mail sending 
															$retval = mail($strTo,$strSubject,$strBodysa,$headers);

															if( $retval == true )
															{
																
																echo "Email sent to " . $strTo;
															}
															else
															{
																
																echo "<font color='red'>Email sending failed to " . $strTo . "</font>";
															}
													}
												/////////////////////////closing email amyn////////////////////////////
												$strTo1="amyn@spearheadtelecom.com";
													//$strTo="yogitafya@hotmail.com,vinayfya@hotmail.com";
													if($strTo1=="")
													{
														echo "Email Id Cannot Blank";
													}
													else
													{
															
															//$strFrom = "DayOpening@nailspaexperience.com";
															$strFrom = "ClosingEmail@nailspaexperience.com";
															
															$strSubject = "Closing Email Detail";
															
															$path="`http://nailspaexperience.com/images/test2.png`";
		
															$message = file_get_contents('EmailFormat/ClosingEmail.html');
															$message = str_replace("[\]",'',$message);

															//setup vars to replace
															$vars = array('{Path}','{Content}'); //Replace varaibles
															$values = array($path,$emailclosecontent);

															//replace vars
															$message = str_replace($vars,$values,$message);
															//echo $message;

																
															$strBody1 = $message;
															//$strbody1="<html><head><title>Day Open</title></head><body>$Content</body></html>";
															$headers = "From: $strFrom\r\n";
															$headers .= "Content-type: text/html\r\n";
															$strBodysa = $strBody1;
															// Mail sending 
															$retval = mail($strTo1,$strSubject,$strBodysa,$headers);

															if( $retval == true )
															{
																
																echo "Email sent to " . $strTo1;
															}
															else
															{
																
																echo "<font color='red'>Email sending failed to " . $strTo1 . "</font>";
															}
													}
												///////////////////////////////////////closing email//////////////////////////////////
													$strTo2="operations@nailspaexperience.com,noor@nailspaexperience.com";
													//$strTo="yogitafya@hotmail.com,vinayfya@hotmail.com";
													if($strTo2=="")
													{
														echo "Email Id Cannot Blank";
													}
													else
													{
															
															//$strFrom = "DayOpening@nailspaexperience.com";
															$strFrom = "ClosingEmail@nailspaexperience.com";
															
															$strSubject = "Closing Email Detail";
															
															$path="`http://nailspaexperience.com/images/test2.png`";
		
															$message = file_get_contents('EmailFormat/ClosingEmail.html');
															$message = str_replace("[\]",'',$message);

															//setup vars to replace
															$vars = array('{Path}','{Content}'); //Replace varaibles
															$values = array($path,$emailclosecontent1);

															//replace vars
															$message = str_replace($vars,$values,$message);
															//echo $message;

																
															$strBody2 = $message;
														
															$headers = "From: $strFrom\r\n";
															$headers .= "Content-type: text/html\r\n";
															$strBodysa = $strBody2;
															// Mail sending 
															$retval = mail($strTo2,$strSubject,$strBodysa,$headers);

															if( $retval == true )
															{
																
																echo "Email sent to " . $strTo2;
															}
															else
															{
																
																echo "<font color='red'>Email sending failed to " . $strTo2 . "</font>";
															}
													}
												
												
												//////////////////////////////////////////////////////////////////////////////////////
												
												$strTo3="marketing@nailspaexperience.com";
													//$strTo="yogitafya@hotmail.com,vinayfya@hotmail.com";
													if($strTo3=="")
													{
														echo "Email Id Cannot Blank";
													}
													else
													{
															
															//$strFrom = "DayOpening@nailspaexperience.com";
															$strFrom = "ClosingEmail@nailspaexperience.com";
															
															$strSubject = "Closing Email Detail";
															$path="`http://nailspaexperience.com/images/test2.png`";
		
															$message = file_get_contents('EmailFormat/ClosingEmail.html');
															$message = str_replace("[\]",'',$message);

															//setup vars to replace
															$vars = array('{Path}','{Content}'); //Replace varaibles
															$values = array($path,$emailclosecontent2);

															//replace vars
															$message = str_replace($vars,$values,$message);
															//echo $message;

																
															$strBody3 = $message;
															//$strbody1="<html><head><title>Day Open</title></head><body>$Content2</body></html>";
															$headers = "From: $strFrom\r\n";
															$headers .= "Content-type: text/html\r\n";
															$strBodysa = $strBody3;
															// Mail sending 
															$retval = mail($strTo3,$strSubject,$strBodysa,$headers);

															if( $retval == true )
															{
																
																echo "Email sent to " . $strTo3;
															}
															else
															{
																
																echo "<font color='red'>Email sending failed to " . $strTo3 . "</font>";
															}
													}
												/////////////////////////////////////////////////////////////////////
												
												$date=date('y-m-d H:i:s');
												$ClosDay1="UPDATE tblOpenNClose SET STATUS =  '3' WHERE DateNTime = '$Thisdate'  AND DayOpenNCloseID ='$strDayOpenNCloseID' AND STATUS =  '2'";
												// echo $ClosDay1."<br>";
												ExecuteNQ($ClosDay1);												
											}
											else
											{
												// echo "In else<br>";
											}
											
											
											
											
											
											
								//added by asmita-End
								
								if($strStore=="" || $strStore=="0")
								{
									
								}
								else
								{
							?>
									<a class="btn btn-primary btn-lg btn-" href="<?=$strMyActionPage?>"><i class="fa fa-backward"></i> &nbsp; Send for Reconcilation</a>
							<?php
								}
							?>
								<br><br>
								<div class="example-box-wrapper">
									<div class="tabs">
										
										<div id="normal-tabs-1">

											<div class="example-box-wrapper">
											<?php
											if($strStore=="" || $strStore=="0")
											{
												$strStoreID = Filter($_GET["Store"]);
												
												// Store Name
													if($strStoreID=="1")
													{
														$strNameofTheStore = "Colaba";
													}
													elseif($strStoreID=="2")
													{
														$strNameofTheStore = "Khar";
													}
													elseif($strStoreID=="3")
													{
														$strNameofTheStore = "Breach Candy";
													}
													elseif($strStoreID=="4")
													{
														$strNameofTheStore = "Oshiwara";
													}
													elseif($strStoreID=="5")
													{
														$strNameofTheStore = "Lokhandwala";
													}
													else
													{
														$strNameofTheStore = "--";
													}
												//Store Name
												
												$getTodaysDatedisplay = $_GET["reportdate"];
												$date15 = new DateTime($getTodaysDatedisplay);
												$getTodaysDate = $date15->format('Y-m-d'); // 31-07-2012
											?>
											
											
												<form method="get" class="form-horizontal bordered-row" role="form">
													<div class="form-group"><label for="" class="col-sm-4 control-label">Basic</label>
														<div class="col-sm-4">
														 <div class="input-prepend input-group">
															 <span class="add-on input-group-addon">
																<i class="glyph-icon icon-calendar"></i>
															 </span> 
															<input type="text" name="reportdate" id="reportdate"  class="form-control" data-date-format="dd/mm/yy" value="<?=$getTodaysDatedisplay?>">
														 </div>
														
																
														</div>
													</div>
													
													<div class="form-group">
														<label class="col-sm-4 control-label">Select Store</label>
														<div class="col-sm-2">
															<select name="Store" class="form-control">	
																<option value="">Select Store</option>
																<option value="2">Khar</option>
																<option value="4">Oshiwara</option>
																<option value="3">Breach Candy</option>
																<option value="1">Colaba</option>
																<option value="5">Lokhandwala</option>
															</select>
														</div>
													</div>
													
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="EnvelopeCreateandVerify.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														<!--<a class="btn btn-border btn-alt border-primary font-primary" href="ExcelExportData.php?from=<?=$getfrom?>&to=<?=$getto?>" title="Excel format 2016"><span>Export To Excel</span><div class="ripple-wrapper"></div></a>
														<a class="btn btn-border btn-alt border-primary font-success" href="pdfcreator/Main/SalesReport.php?from=<?=$getfrom?>&to=<?=$getto?>" title="PDF Report"><span>Export To PDF</span><div class="ripple-wrapper"></div></a>
														-->
													</div>
												</form>
												
											
												
											<?php
											}		
											else
											{
												$strStoreID = $strStore;
												$getTodaysDate = date('Y-m-d');
												$strNameofTheStore = $strStoreNamedisplay;
											}
											?>
											
											<?php
											
											?>
											
											<span>
												<h3>
													<b>Date : <?=$getTodaysDate ?> </b><br>
													<b>Store : <?=$strNameofTheStore?> </b>
												</h3>
											</span>	
											
												<table class="table table-bordered table-striped table-condensed cf">
												
													<thead class="cf">
															<tr>
																<th>Date</th>
																<th>Invoice No.</th>
																<th>Customer Name</th>
																<th>Services</th>
																<th class="numeric">Price Rs</th>
																<th class="numeric">Subtotal Rs</th>
																<th class="numeric">O Dis Rs</th>
																<th class="numeric">M Dis Rs</th>
																<th class="numeric">Gift V Sold Rs</th>
																<th class="numeric">GV Redeemed Rs</th>

																<th class="numeric">Tax Rs</th>
																<th class="numeric">Total Rs</th>
																<th class="numeric">Cash</th>
																<th class="numeric">Card</th>
																<th class="numeric">Pending Amount</th>
																
															</tr>
														</thead>
												
<?php
$DB = Connect();

$sqlPC = "select Amount from tblExpenses where DateOfExpense=Date('$getTodaysDate') and StoreID ='$strStoreID' and Status='0'";

//echo $sqlinvoice;
$RSPC = $DB->query($sqlPC);
if ($RSPC->num_rows > 0) 
{
	$strTotalPCAmount = "";
	while($rowPC = $RSPC->fetch_assoc())
	{
		$strPCAmount = $rowPC["Amount"];
		$strTotalPCAmount += $strPCAmount;
	}
}
else
{
	$strTotalPCAmount = "0.00";
}
?>
		<hr><h4>Petty Cash Spent : Rs.<?=$strTotalPCAmount;?> / -</h4>
		<br>
		
<?php
$strTotalSubTotal = "";
$strTotalPTotal = "";


$sqlinvoice = "select tblInvoiceDetails.AppointmentID, (select Amount from tblGiftVouchers where GiftVoucherID=tblInvoiceDetails.GVPurchasedID and AppointmentID=tblInvoiceDetails.AppointmentID) as GVPurchased , (select Amount from tblGiftVouchers where GiftVoucherID=tblInvoiceDetails.GVRedeemedID and RedempedBy=tblInvoiceDetails.AppointmentID) as GVRedeemed, (tblInvoiceDetails.OfferDiscountDatetime) as Date, tblInvoiceDetails.InvoiceId ,tblInvoiceDetails.CustomerFullName, tblInvoiceDetails.ServiceName , 
		tblInvoiceDetails.Qty, tblInvoiceDetails.ServiceAmt, tblInvoiceDetails.DisAmt, tblInvoiceDetails.OfferAmt, tblAppointments.StoreID,
		tblInvoiceDetails.SubTotal, tblInvoiceDetails.Total, tblInvoiceDetails.CardAmount, tblInvoiceDetails.CashAmount, tblInvoiceDetails.TotalPayment, tblInvoiceDetails.PendingAmount, tblInvoiceDetails.ChargeName, tblInvoiceDetails.ChargeAmount
		from tblInvoiceDetails 
		left join tblAppointments 
		on tblInvoiceDetails.AppointmentID=tblAppointments.AppointmentID
		where Date(tblInvoiceDetails.OfferDiscountDateTime)=Date('$getTodaysDate') and tblAppointments.StoreID ='$strStoreID'";

//echo $sqlinvoice;
$RSinvoice = $DB->query($sqlinvoice);
if ($RSinvoice->num_rows > 0) 
{
	$counter ="";
	$strTotalSubTotalaaa = "";
	while($rowinvoice = $RSinvoice->fetch_assoc())
	{
		$counter = $counter + 1;
		
		$strAppointID = $rowinvoice["AppointmentID"];
		
		// Gift Voucher Redemtion and Purchase
		$strGVPurchaseID = $rowinvoice["GVPurchased"];
		if($strGVPurchaseID=="NULL" || $strGVPurchaseID=="null" || $strGVPurchaseID=="")
		{
			$strGVPurchaseID="0.00";
		}
		else
		{
			$strGVPurchaseID=$strGVPurchaseID;
		}
		$TotalGVPurchased += $strGVPurchaseID;
		
		
		$strGVRedeemID = $rowinvoice["GVRedeemed"];
		if($strGVRedeemID=="NULL" || $strGVRedeemID=="null" || $strGVRedeemID=="")
		{
			$strGVRedeemID="0.00";
		}
		else
		{
			$strGVRedeemID=$strGVRedeemID;
		}
		
		
		$TotalGVRedeemed += $strGVRedeemID;
		
		
		$strDate = FormatDatetime($rowinvoice["Date"],'0');
		$strCustomerFullName = $rowinvoice["CustomerFullName"];
		$strInvoiceID = $rowinvoice["InvoiceId"];
		
		// Services
		$strServices = $rowinvoice["ServiceName"];
		$strServices = explode(",", $strServices);
		
		// Service Amount
		$strServicesAmount = $rowinvoice["ServiceAmt"];
		$strServicesAmount = explode(",", $strServicesAmount);
		
		// Membership Discount
		$strMDiscount = $rowinvoice["DisAmt"];
		if($strMDiscount =="")
		{
			$TotalMAmount ="0.00";
		}
		else
		{
			$strMDiscount = explode(",", $strMDiscount);
			$TotalMAmount = "";
			foreach($strMDiscount as $MAmount)
			{
				$TotalMAmount += $MAmount;
			}
		}
		$strFinalTotalDiscount += $TotalMAmount;
			
			
		// Offer Discount
		$strODiscount = $rowinvoice["OfferAmt"];
		if($strODiscount =="")
		{
			$TotalOAmount ="0.00";
		}
		else
		{
			$strODiscount = explode(",", $strODiscount);
			$TotalOAmount = "";
			foreach($strODiscount as $OAmount)
			{
				$TotalOAmount += $OAmount;
			}
		}
		$strFinalTotalOffer += $TotalOAmount;
		
		// Taxation
		$strChargeName = $rowinvoice["ChargeName"];
		$strChargeAmount = $rowinvoice["ChargeAmount"];
		$strChargeName = explode(",", $strChargeName);
		$strChargeAmount = explode(",", $strChargeAmount);
	
	
		// Total and Subtotal
		$strTotal = $rowinvoice["Total"];
		$strTotalofTotal += $strTotal;

		$strTotalPayment = $rowinvoice["TotalPayment"];
		$strTotalPTotal += $strTotalPayment;
	
		
		// Pending Amount
		$strPendingAmount = $rowinvoice["PendingAmount"];
		if($strPendingAmount=="")
		{
			$strPendingAmount ="0.00";
		}
		else
		{
			$strPendingAmount = $strPendingAmount;
		}
		$strPendingAmountTotal += $strPendingAmount;
		
		
		// Card Paid

		$strCash = $rowinvoice["CashAmount"];
		if($strCash=="")
		{
			$strCash ="0.00";
		}
		else
		{
			$strCash = $strCash;
		}
		$strTotalCash += $strCash;
		
		
		
		// Cash paid

		$strCard = $rowinvoice["CardAmount"];
		if($strCard=="")
		{
			$strCard ="0.00";
		}
		else
		{
			$strCard = $strCard;
		}
		$strTotalCard += $strCard;
		
?>
													<tbody>
														<tr>
															<td><?=$strDate?></td>
															<td><?=$strInvoiceID?></td>
															<td><?=$strCustomerFullName?></td>
															<td>
																<?php
																	foreach($strServices as $Services)
																	{
																		$sqlServiceName = "select ServiceName from tblServices where ServiceID ='$Services'";
																		$RSSN = $DB->query($sqlServiceName);
																		if ($RSSN->num_rows > 0) 
																		{
																			while($rowSN = $RSSN->fetch_assoc())
																			{
																				$ServiceName = $rowSN["ServiceName"];
																				echo "$ServiceName <br>";
																			}
																		}
																		else
																		{
																			
																		}		
																	}
																?>
															</td>
															<td class="numeric">
																<?php
																	$ServiceAmountBasicTotal = "";
																	foreach($strServicesAmount as $Amount)
																	{
																		echo "Rs. $Amount <br>";
																		$ServiceAmountBasicTotal += $Amount;
																	}
																	$TotalBasics += $ServiceAmountBasicTotal;
																?>
															</td>
															<td class="numeric">Rs <?=$ServiceAmountBasicTotal?></td>
															<td class="numeric">Rs. <?=str_replace("-", " ", $TotalOAmount)?></td>
															<td class="numeric">Rs. <?=$TotalMAmount?></td>
															<td class="numeric">Rs. <?=$strGVPurchaseID?></td>
															<td class="numeric">Rs. <?=$strGVRedeemID?></td>
															<td class="numeric">
																<?php
																	foreach($strChargeName as $ChargeName)
																	{
																		echo "$ChargeName  &nbsp;&nbsp;&nbsp; | ";
																	}
																	
																	echo "<br>";
																	
																	$tC = "";
																	foreach($strChargeAmount as $ChargeAmount)
																	{
																		echo str_replace("+", " ", $ChargeAmount)." &nbsp;&nbsp;&nbsp; | ";
																		$tC += $ChargeAmount;
																	}
																	$TotalChargeAmount += $tC;

																?>
															</td>
															<td class="numeric">Rs. <?=$strTotal?></td>
															<td class="numeric">Rs. <?=$strCash?></td>
															<td class="numeric">Rs. <?=$strCard?></td>
															<td class="numeric">Rs. <?=$strPendingAmount?></td>
															
														</tr>
													</tbody>
<?php	
	}
?>	
													<tbody>
														<tr>
															<td colspan="5"><center><b>Total No of invoice(s) : <?=$counter?></b><center></td>
															<td class="numeric"><b>Rs. <?=$TotalBasics?>/-</b></td>
															<td class="numeric"><b>Rs. <?=str_replace("-", " ", $strFinalTotalOffer)?>/-</b></td>
															<td class="numeric"><b>Rs. <?=$strFinalTotalDiscount?>/-</b></td>
															<td class="numeric"><b>Rs. <?=$TotalGVPurchased?>/-</b></td>
															<td class="numeric"><b>Rs. <?=$TotalGVRedeemed?>/-</b></td>

															<td class="numeric"><b>Rs. <?=$TotalChargeAmount?>/-</b></td>
															<td class="numeric"><b>Rs. <?=$strTotalofTotal?>/-</b></td>
															<td class="numeric"><b>Rs. <?=$strTotalCash?>/-</b></td>
															<td class="numeric"><b>Rs. <?=$strTotalCard?>/-</b></td>
															<td class="numeric"><b>Rs. <?=$strPendingAmountTotal?>/-</b></td>
														</tr>
													</tbody>

<?php	
}
else
{
?>	
													<tbody>
														<tr>
															<td></td>
															<td></td>
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
														</tr>
													</tbody>

<?php
}
$DB->close();
?>												

												</table>
											</div>
											

										</div>
										
										
									</div>
								</div>
							</div>
						</div>
                    </div>
<?php
} // End null condition
else
{

}
?>
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>