<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?php

//start if this week date selection
// echo date('Y-m-d',strtotime('last monday'));
// echo "<br>";
// echo date('Y-m-d',strtotime('next sunday')) ;
//end if this week date selection




// $todate= date("Y-m-d");
// echo $todate."<br>";

// $abc= date("Y-m-d", strtotime('+1 months'));
// echo $abc."<br>";

// $pqr="Select tblAppointments.StoreID, 
 // SUM(tblInvoiceDetails.TotalPayment) as TOTAL
    // from tblAppointments
// Left join tblInvoiceDetails
// ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID
// WHERE tblAppointments.StoreID='2' and  Date(AppointmentDate)>=$todate and Date(AppointmentDate)<='$abc'";
// echo $pqr."<br>";


// $asmita="SELECT AppointmentDate as MTH FROM tblAppointments WHERE MONTH(AppointmentDate) =9";
// echo $asmita;
// $RS = $DB->query($asmita);
// if ($RS->num_rows > 0) 
// {
	// while($row = $RS->fetch_assoc())
	// {
		// $AppointmentDate = $row["MTH"];
		// echo $AppointmentDate;
	// }
// }


// $PendingAmount="Select SUM(tblPendingPayments.PendingAmount)as Pending,  tblAppointments.StoreID 
// from tblPendingPayments Left Join tblAppointments 
// ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID
// WHERE tblAppointments.StoreID='2'";
// echo $PendingAmount."<br>";

// $pqr="Select tblAppointments.StoreID, 
// SUM(tblInvoiceDetails.TotalPayment) as TOTAL
   // from tblAppointments
// Left join tblInvoiceDetails
// ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID
// WHERE tblAppointments.StoreID='2' and  Date(AppointmentDate)>=$todate and Date(AppointmentDate)<='$abc'";
// echo $pqr."<br>";

// $pqr="Select tblStores.StoreID, tblStores.StoreName, 
// SUM(tblInvoiceDetails.TotalPayment) as TOTAL
   // from tblStores
// Left join tblInvoiceDetails
// ON tblStores.StoreName=tblInvoiceDetails.Billaddress
// WHERE Date(AppointmentDate)>=$todate and Date(AppointmentDate)<='$abc'";
// echo $pqr."<br>";

// $DB = Connect();
// echo $strAdminFullName;
// $SelectStore="Select * from tblStores order by StoreID";
// $RS = $DB->query($SelectStore);
// if ($RS->num_rows > 0) 
// {
	// while($row = $RS->fetch_assoc())
	// {
		// $StoreID = $row["StoreID"];
		// $StoreName = $row["StoreName"];
		// echo $StoreID."&nbsp;";
		// echo $StoreName."<br>";
		// $SelectTotalPayment="Select Sum(TotalPayment) as TOTAL from tblInvoiceDetails where Billaddress='$StoreName'";
		// echo $SelectTotalPayment."<br>";
		// $RSa = $DB->query($SelectTotalPayment);
		
		// if ($RSa->num_rows > 0) 
		// {
			// while($rowa = $RSa->fetch_assoc())
			// {
				// $StoreID = $rowa["StoreID"];
				// $TOTAL = $rowa["TOTAL"];
				// echo "$StoreID";
				// echo "Rs. $TOTAL<br><br>";
			// }
		// }
	// }
// }
// $SelectTotalPayment="Select tblStores.StoreID, tblInvoiceDetails.TotalPayment from tblStores Left join tblInvoiceDetails ON tblInvoiceDetails.Billaddress=tblStores.StoreName order by tblStores.StoreID";

// $SelectPaymentbyJoin="Select tblStores.StoreID, tblInvoiceDetails.TotalPayment, tblInvoiceDetails.Billaddress from tblStores Left join tblInvoiceDetails ON tblStores.StoreName=tblInvoiceDetails.Billaddress order by tblStores.StoreID";

// $RSb = $DB->query($SelectPaymentbyJoin);
// if ($RSb->num_rows > 0) 
// {
	// while($rowb = $RSb->fetch_assoc())
	// {
		// $StoreID = $rowb["StoreID"];
		// $Billaddress = $rowb["Billaddress"];
		// $TotalPayment = $rowb["TotalPayment"];
		// echo $StoreID."&nbsp;";
		// echo $Billaddress."&nbsp;";
		// echo $TotalPayment."&nbsp;";	
	// }
// }
//Total sales query
									
											// $DB=Connect();
											// $TDT=date("y-m-d");
											// $FindStore="Select StoreID from tblAdminStore where AdminID=$strAdminID";
											// echo $FindStore;
											// $RSf = $DB->query($FindStore);
											// if ($RSf->num_rows > 0) 
											// {
												// while($rowf = $RSf->fetch_assoc())
												// {
													// $strStoreID = $rowf["StoreID"];
													// echo $strStoreID;
													// echo "Hello";
												// }
											// }
											// if($strStoreID!=0)
											// {
												// echo "In if";
												// $Sales="Select tblAppointments.StoreID,
												// SUM(tblInvoiceDetails.TotalPayment) as TOTAL
												// from tblAppointments
											// Left join tblInvoiceDetails
											// ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID
											// WHERE tblAppointments.StoreID='$strStoreID' and tblAppointments.AppointmentDate='$TDT'";
												
											// }
											// else
											// {		
												// echo "In else";
												// $Sales="Select tblAppointments.StoreID,
												// SUM(tblInvoiceDetails.TotalPayment) as TOTAL
												// from tblAppointments
											// Left join tblInvoiceDetails
											// ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID
											// WHERE tblAppointments.AppointmentDate='$TDT'";
											// echo $Sales;
											// }
											
											// $RSd = $DB->query($Sales);
											// if ($RSd->num_rows > 0) 
											// {
												// while($rowd = $RSd->fetch_assoc())
												// {
													// $TodalSales = $rowd["TOTAL"];
													// echo "Today's Total Sales:".$TodalSales."<br>";
												// }
											// }
											
											
											// $Membership="Select (SELECT count(MembershipID) FROM `tblAppointmentMembershipDiscount` where DateTimeStamp='$TDT') as MembershipSoldToday";
											// echo $Membership."<br>";
											// $MembershipStoreWise="Select count(tblAppointmentMembershipDiscount.MembershipID) as MembershipSoldToday, tblAppointmentMembershipDiscount.AppointmentID,
// tblAppointments.AppointmentID, 	tblAppointments.StoreID from 	tblAppointmentMembershipDiscount Left Join 	tblAppointments	ON 				tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID 
// WHERE Date(tblAppointmentMembershipDiscount.DateTimeStamp)='$TDT'";
// echo $MembershipStoreWise;
											
											// $MembershipStoreWise="Select count(tblAppointmentMembershipDiscount.MembershipID) as MembershipSoldToday, 
// tblAppointments.StoreID from 	tblAppointmentMembershipDiscount Left Join 	tblAppointments	ON 				tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID 
// WHERE TimeStamp(tblAppointmentMembershipDiscount.DateTimeStamp)='$TDT' and tblAppointments.StoreID='2'";
			// echo $MembershipStoreWise."<br>";								
											
											
											
											// $RSe = $DB->query($MembershipStoreWise);
											// if ($RSe->num_rows > 0) 
											// {
												// while($rowe = $RSe->fetch_assoc())
												// {
													// $MembershipSoldToday = $rowe["MembershipSoldToday"];
													// echo "Today's Membership Sold:".$MembershipSoldToday."<br>";
												// }
											// }
											
											
											// $Offer="Select (SELECT count(OfferID) FROM `tblAppointmentMembershipDiscount` where TimeStamp(DateTimeStamp)='$TDT') as OffersSoldToday";
											// echo $Offer."<br>";
											
											// DATE(`date`)='$today'
											// echo $Offer."<br>";
											// $OffersStoreWise="Select count(tblAppointmentMembershipDiscount.OfferID) as OffersSoldToday, 
// tblAppointments.StoreID from 	tblAppointmentMembershipDiscount Left Join 	tblAppointments	ON 				tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID 
// WHERE TimeStamp(tblAppointmentMembershipDiscount.DateTimeStamp)='$TDT' and tblAppointments.StoreID='2'";
											// echo $OffersStoreWise."<br>";
											
											// $RSf = $DB->query($OffersStoreWise);
											// if ($RSf->num_rows > 0) 
											// {
												// while($rowf = $RSf->fetch_assoc())
												// {
													// $OffersSoldToday = $rowf["OffersSoldToday"];
													// echo "Today's Offers Sold:".$OffersSoldToday."<br>";
												// }
											// }
											
											
											

// $OffersStoreWise="Select count(tblAppointmentMembershipDiscount.OfferID) as OffersSoldToday, tblAppointments.StoreID from 	tblAppointmentMembershipDiscount Left Join 	tblAppointments	ON tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID 
// WHERE TimeStamp(tblAppointmentMembershipDiscount.DateTimeStamp)='$TDT' and tblAppointments.StoreID='2'";
// echo $OffersStoreWise."<br>";



//IMEI testing
// $number='9867510596';
// echo $number."<br>";
// function valid_imei($number)
// {
	// $getLastNumber = substr($number, strlen($number)-1);
	// $getRemaining = substr($number, 0, strlen($number)-1);
	// $getRemainLength = strlen($getRemaining);
	// $getEvenAndDouble = array();
	// for($i=0; $i < $getRemainLength; $i++){
		// if($i%2){
			// $getEvenAndDouble[] = substr($getRemaining, $i, 1)*2;
		// }else{
			// $getEvenAndDouble[] = substr($getRemaining, $i, 1);
		// }
	// }
	// $sumEven = array();
	// for($i = 0; $i < $getRemainLength; $i++){
		// if($i%2){
			// $splitTwoAndAdd = substr($getEvenAndDouble[$i], 0, 1) + substr($getEvenAndDouble[$i], 1); 
			// $getEvenAndDouble[$i] = $splitTwoAndAdd;
		// }
	// }
	// $lastSum = array_sum($getEvenAndDouble);
	// $findMod = $lastSum%10;
	// if($findMod != 0)
		// $checksum = 10 - $findMod;
	// else 
		// $checksum = $findMod;

	// return ($checksum == $getLastNumber) ? true : false;
// }
?>
<!--<html>
	<head>
	</head>
	<body>-->
<?php	
		// $myphone="9867510596";
?>
		<!--<form method="POST" onsubmit="valid_imei('$myphone');" class="myform">
			<input name="name" placeholder="Name" id="name"  value="" type="text" class="required" >
			<input type="submit" id="submit" value="Submit">
		</form>
		
		
	</body>
</html>-->
<?php
// $VerifyNewOrders="Select Status from tblOrder";
									// echo $VerifyNewOrders."<br>";
									// $RSf = $DB->query($VerifyNewOrders);
									// if ($RSf->num_rows > 0) 
									// {
										// while($rowf = $RSf->fetch_assoc())
										// {
											// $strStatus = $rowf["Status"];
											// echo $strStatus."<br>";
											// if($strStatus=='1')
											// {
?>
												<!--<span class="bs-label badge-yellow">NEW</span>-->
<?php																
											// }
											// else
											// {
												// echo "Hello";
											// }
										// }
									// }
// ?>
<?php
														// $VerifyNewOrders="Select Status from tblOrder";
														// echo $VerifyNewOrders."<br>";
														// $RSf = $DB->query($VerifyNewOrders);
														// if ($RSf->num_rows > 0)
														// {
															// while($rowf = $RSf->fetch_assoc())
															// {
																// echo "In While<br>";
																// $strStatus = $rowf["Status"];
																// echo $strStatus;
																// if($strStatus=='1')
																// {
// ?>
																<!-- <span class="bs-label badge-yellow">NEW</span>-->
 <?php																
																// }
															// }
														// }
?>	

<?php
// echo "*****************************************************<br>";

				// $DB = Connect();
								// $FindRole="Select AdminRoleID from tblAdmin where AdminID=$strAdminID";
								// echo $FindRole;
								// $RSsaif = $DB->query($FindRole);
								// if ($RSsaif->num_rows > 0) 
								// {
									// while($rowsaif = $RSsaif->fetch_assoc())
									// {
										// $strStoreID = $rowf["StoreID"];
										// $strRoleID = $rowsaif["AdminRoleID"];
										// echo $strRoleID;
									// }
								// }
// ?>
		
		
<?php
						// $DB = Connect();
						// echo $strAdminID;
							// $date=date('y-m-d');
							// $FindStore="Select StoreID from tblAdminStore where AdminID=$strAdminID";
							// echo $FindStore."<br>";
							// $RSf = $DB->query($FindStore);
							// if ($RSf->num_rows > 0) 
							// {
								// while($rowf = $RSf->fetch_assoc())
								// {
									// $strStoreID = $rowf["StoreID"];
									echo $strStoreID."<br>";
									echo "Hello";
								// }
							// }
										
							// $MSold="Select (SELECT count(MembershipID) FROM tblCustomerMemberShip where StoreId='$strStoreID' and StartDay='$date') as MembershipIDSold";
							
							// $OSold="Select (SELECT count(OfferAmt) FROM `OfferID` where StoreId='$strStoreID' and StartDay='$date') as MembershipIDSold";
							
							// $Msold1="Select count(tblAppointmentMembershipDiscount.OfferID) as OffersSoldToday, tblAppointments.StoreID from tblAppointmentMembershipDiscount Left Join tblAppointments	ON  tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID 
// WHERE TimeStamp(tblAppointmentMembershipDiscount.DateTimeStamp)='$TDT' and tblAppointments.StoreID='2'";
// echo $Msold1."<br>";
							// $Msold1="Select count(tblCustomerMemberShip.MembershipID) as MembershipIDSold, tblCustomerMemberShip.CustomerID,  tblAppointments.CustomerID, tblAppointments.StoreID, from tblCustomerMemberShip Left Join tblAppointments 
							// ON tblCustomerMemberShip.CustomerID=tblAppointments.CustomerID
							// Where Date(tblAppointments.StartDay)='$TDT' and tblAppointments.StoreID='2'";
							// echo $Msold1."<br>";
						
						
							
							// $datetime = new DateTime($to);
							// $getto = $datetime->format('Y-m-d');
							// $sqlTempfrom = " where Date(MembershipDateTime)>=Date('".$getfrom."')";
							// $sqlTempto = " and Date(MembershipDateTime)<=Date('".$getto."')";
							
							// $sql = "SELECT CustomerID, CustomerFullName, CustomerEmailID, 
		// (Select MembershipName from tblMembership where MembershipID=tblCustomers.memberid)as MembershipName, MembershipDateTime, Gender FROM tblCustomers $sqlTempfrom $sqlTempto";
		// echo $sql."<br>";
							
							
							// $RS = $DB->query($MSold);
								// if ($RS->num_rows > 0) 
								// {
									// while($row = $RS->fetch_assoc())
									// {
										// $strMembershipIDSold = $row["MembershipIDSold"];
										// echo $strMembershipIDSold."<br>";
									// }
								// }
								// echo "<br>";
								// echo date('F'); 
								// echo "<br>";
								
	// echo "*********************************************************************************************<br>";
	
	
	
								// $DB = Connect();
										// $FindStore="Select StoreID from tblAdminStore where AdminID=$strAdminID";
										// echo $FindStore;
										// $RSf = $DB->query($FindStore);
										// if ($RSf->num_rows > 0) 
										// {
											// while($rowf = $RSf->fetch_assoc())
											// {
												// $strStoreID = $rowf["StoreID"];
												// echo $strStoreID;
												// echo "Hello";
											// }
										// }
										// if($strStoreID!=0)
										// {
											// $Products="Select (SELECT count(Distinct ProductID) FROM `tblStoreProduct` where StoreID='$strStoreID') as TotalProducts";
											// echo $Products."<br><br><br>";
											
										// }
										// else
										// {
											// $Products="Select (SELECT count(0) FROM `tblNewProducts`) as TotalProducts";
										// }
										
										// $RSa = $DB->query($Products);
										// if ($RSa->num_rows > 0) 
										// {
											// while($rowa = $RSa->fetch_assoc())
											// {
												// $TotalProducts = $rowa["TotalProducts"];
												// $ProductID = $rowa["ProductID"];
												// echo $TotalProducts."<br><br><br>";
												// echo "Hello<br><br><br>";
												
												// $ProductsVariation="Select (SELECT count(Distinct ProductStockID) FROM `tblStoreProduct` where StoreID='$strStoreID' and ProductStockID!=0) as TotalVariations";
													// echo $ProductsVariation."<br><br><br>";
													// echo $SelectProductvariation;
													// $RSvariation = $DB->query($ProductsVariation);
													// if ($RSvariation->num_rows > 0) 
													// {
														// echo "In if";
														// while($rowvariation = $RSvariation->fetch_assoc())
														// {
															// echo "<br>In while";
																// $TotalVariations = $rowvariation["TotalVariations"];
																// echo $TotalVariations."<br><br><br>";
														// }
													// }
												
											// }
										// }
										
			// echo "*****************************************************************************";
										
											// $GiftSold="Select (SELECT count(Date) FROM `tblGiftVouchers` where StoreId='$strStoreID' and Date(Date)='$date') as Giftsold";
											// echo $GiftSold;
											
											
											
    // echo 'First Date    = ' . date('Y-m-01') . '<br />';
    // echo 'Last Date     = ' . date('Y-m-t')  . '<br />';
	// $First= date('Y-m-01');
											// $Last= date('Y-m-t');
	
	// $GiftSoldforMonth="Select (SELECT count(Date) FROM `tblGiftVouchers` where StoreId='$strStoreID' and Date(Date)>=Date('$First') and Date(Date)<=Date('$Last')) as GiftsoldthisMonth";
	// echo $GiftSoldforMonth;
										// $RSGiftforMonth = $DB->query($GiftSoldforMonth);
										// if ($RSGiftforMonth->num_rows > 0) 
										// {
											// echo "<br>in if";
											// while($rowGifforMontht = $RSGiftforMonth->fetch_assoc())
											// {
												// $GiftsoldthisMonth = $rowGifforMontht["GiftsoldthisMonth"];
												// echo $GiftsoldthisMonth;
											// }
										// }

										// $DB->close();
				// echo "**********************************************************************************<br>";
					$DB = Connect();
					// $SelectEMPCODE="Select EmployeeCode from tblEmployees where EID=90";
					// echo $SelectEMPCODE."<br>";
					// $RS1 = $DB->query($SelectEMPCODE);
					// if ($RS1->num_rows > 0) 
					// {
						// while($row1 = $RS1->fetch_assoc())
						// {
							// $strEmployeeCode = $row1["EmployeeCode"];
							// echo $strEmployeeCode."<br>";
						// }
					// }			
					
					
echo "**************************************************************************************************<br>";					
// $First= date('Y-m-01');
// $Last= date('Y-m-t');
// $TotalMonthSale="Select tblAppointments.StoreID,
// SUM(tblInvoiceDetails.TotalPayment) as TOTALMonthly
// from tblAppointments
// Left join tblInvoiceDetails
// ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID
// WHERE tblAppointments.StoreID='$strStoreID' and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('$First') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('$Last')";
// echo $TotalMonthSale."<br>";
// $RSMonthsale = $DB->query($SelectTarget);
// if ($RSMonthsale->num_rows > 0) 
// {
// while($rowMonthTarget = $RSMonthsale->fetch_assoc())
// {
// $TOTALMonthly = $rowMonthTarget["TOTALMonthly"];										
// }
// }
// echo "**************************************************************************************************<br>";

// $format = "YmjHi";
// date_default_timezone_set('GMT');
// echo date($format, strtotime("-5 minute")) . "\n";
	// $SelectServices="Select ServiceID from tblServices";										
	// echo $SelectEMPCODE."<br>";
		// $RS1 = $DB->query($SelectServices);
		// if ($RS1->num_rows > 0) 
		// {
			// while($row1 = $RS1->fetch_assoc())
			// {
				// $strServiceID = $row1["ServiceID"];
				// echo $strServiceID.",";
			// }
		// }		
		
		
							// $First= date('Y-m-01');
							// $Last= date('Y-m-t');
								// $membershipamount="SELECT count(memberid) as MonthlyMembership FROM `tblCustomers` where Date(MembershipDateTime)>=Date('$First') and Date(MembershipDateTime)<=Date('$Last')";
								// echo $membershipamount;
												// $DB = Connect();
												// $RSc = $DB->query($membershipamount);
												// if ($RSc->num_rows > 0) 
												// {
													// while($rowc = $RSc->fetch_assoc())
													// {
														// $MonthlyMembership = $rowc["MonthlyMembership"];
														// echo $MonthlyMembership;
													// }
												// }
								// $DB = Connect();
								// $date1=date('y-m-d');	
												
							// $Customernew="SELECT count(CustomerID) as Customercount FROM `tblCustomers` where  Date(RegDate)='$date1'";
							// echo $Customernew."<br>";
							// $RSnew = $DB->query($Customernew);
							// if ($RSnew->num_rows > 0) 
							// {
								// while($rownew = $RSnew->fetch_assoc())
								// {
									// $CustomerCount1 = $rownew["Customercount"];
									// echo $CustomerCount1;
									// if($CustomerCount1=="")
									// {
										// $CustomerCount1='0';
									// }
								// }
							// }
							// echo $CustomerCount1;
							
							
// $DB = Connect();
// $ReturningCustomers = "SELECT CustomerID FROM tblAppointments GROUP BY CustomerID HAVING COUNT(*) > 1";
// echo $ReturningCustomers."<br>";
// $RSf = $DB->query($ReturningCustomers);
// if ($RSf->num_rows > 0) 
// {
	
	// while($rowf = $RSf->fetch_assoc())
	// {
		// $CustomerID[] = $rowf["CustomerID"];
	// }
// }
	// echo count($CustomerID);

	$DB = Connect();
// $TotalDiscount = "SELECT AppointmentID, CustomerID, StoreID FROM tblAppointments where Status=2";
// echo $TotalDiscount."<br>";
// $RSf = $DB->query($TotalDiscount);
// if ($RSf->num_rows > 0) 
// {
	// echo "In up if<br>";
	// while($rowf = $RSf->fetch_assoc())
	// {
		// echo "In up while<br>";
		// $strAppointmentID = $rowf["AppointmentID"];
		// $strStoreID = $rowf["StoreID"];
		// $strCustomerID = $rowf["CustomerID"];
		// echo $strAppointmentID."&nbsp; &nbsp; &nbsp; &nbsp;";
		// echo $strCustomerID."&nbsp; &nbsp; &nbsp; &nbsp;";
		// echo $strStoreID."<br>";
		// $SelectTotal="SELECT AppointmentID, OfferAmount, MembershipAmount from tblAppointmentMembershipDiscount where AppointmentId=$strAppointmentID";
		// echo $SelectTotal."<br>";
		// $RST = $DB->query($SelectTotal);
		// if ($RST->num_rows > 0) 
		// {
			// echo "In if<br>";
			// while($rowT = $RST->fetch_assoc())
			// {
				// echo "In while<br>";
				// $AppointmentID = $rowT["AppointmentID"];
				// $OfferAmount = $rowT["OfferAmount"];
				// $MembershipAmount = $rowT["MembershipAmount"];				
				// $OPLUSM=$OfferAmount + $MembershipAmount;
				// echo $AppointmentID."&nbsp; &nbsp; &nbsp;";
				// echo $strCustomerID."&nbsp; &nbsp; &nbsp;";
				// echo $strStoreID."&nbsp; &nbsp; &nbsp;";
				// echo $OPLUSM."<br>";
				
				
				
			// }
		// }
	// }
// }
// $today = getdate();
   // print_r($today);
   // echo "<br/>";

   // $weekStartDate = $today['mday'] - $today['wday'];
   // $weekEndDate = $today['mday'] - $today['wday']+6;
   // echo "<br/>";
   // echo "<br/>";
   // echo "week start date:".$weekStartDate;
   // echo "<br/>";
   // echo "week end date:".$weekEndDate;
   
   
// echo $date = date("Y-m-01").' To '.date("Y-m-t");  







// $SelectCustID="Select CustomerID FROM tblCustomeres";
// $RST = $DB->query($SelectCustID);
// if ($RST->num_rows > 0) 
// {
	// echo "In if<br>";
	// while($rowT = $RST->fetch_assoc())
	// {
		// echo "In while<br>";
		// $strCustomerID = $rowT["CustomerID"];
		// $SelectNONV="SELECT CustomerID FROM tblAppointments GROUP BY CustomerID HAVING COUNT(*) < 1";
		// $RSN = $DB->query($SelectNONV);
		// if ($RSN->num_rows > 0) 
		// {
			// echo "In if<br>";
			// while($rowN = $RSN->fetch_assoc())
			// {
				// echo "In while<br>";
				// $CustomerID = $rowN["CustomerID"];
				// echo $CustomerID."<br>";
			// }
		// }
	// }
// }



// $list=array();
// $month = date('m');
// $year = date('y');

// for($d=1; $d<=31; $d++)
// {
    // $time=mktime(12, 0, 0, $month, $d, $year);          
    // if (date('m', $time)==$month)       
       // $list[]=date('Y-m-d', $time);
	
// }
// foreach($list as $li)
// {
	// echo $li."<br>";
	// $SelectSales="Select SUM(TotalPayment) as Sales from tblInvoiceDetails where Date(OfferDiscountDateTime)='$li'";
	// echo $SelectSales."<br>";
	// $RSN = $DB->query($SelectSales);
		// if ($RSN->num_rows > 0) 
		// {
			// while($rowN = $RSN->fetch_assoc())
			// {
				// $Sales = $rowN["Sales"];
				// echo $li."&nbsp; &nbsp; &nbsp;";
				// echo $Sales."<br>";
			// }
		// }
	
// }
// echo "<pre>";
// print_r($list);
// echo "</pre>";


// $seq=select("*","tblAppointments","AppointmentDate>=Date('2016-10-01') and  AppointmentDate<=Date('2016-10-21')");
// foreach($seq as $vap)
// {
	// $customer[]=$vap['CustomerID'];
	// $customer[]

// }
// $selp=select("CustomerID","tblCustomers","Status='0'");
// foreach($selp as $val)
// {
	// $cust=$val['CustomerID'];
   // if (in_array("$cust", $customer))
	// {
		// echo $customer."<br>";
	// }
	// else
	// {
	
	// echo $cust."<br>";
	// }
	
// }









?>
<!-- Styles -->
<!--<style>
#chartdiv {
  width: 100%;
  height: 500px;
  font-size: 11px;
}

.amcharts-pie-slice {
  transform: scale(1);
  transform-origin: 50% 50%;
  transition-duration: 0.3s;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
  -o-transition: all .3s ease-out;
  cursor: pointer;
  box-shadow: 0 0 30px 0 #000;
}

.amcharts-pie-slice:hover {
  transform: scale(1.1);
  filter: url(#shadow);
}							
</style>-->

<!-- Resources -->
<!--<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>-->

<!-- Chart code -->
<?php

// $list=array();
// $month = date('m');
// $year = date('y');

// for($d=1; $d<=31; $d++)
// {
    // $time=mktime(12, 0, 0, $month, $d, $year);          
    // if (date('m', $time)==$month)       
       // $list[]=date('Y-m-d', $time);
	
// }
// foreach($list as $li)
// {
	// echo $li."<br>";
	// $SelectSales="Select SUM(TotalPayment) as Sales from tblInvoiceDetails where Date(OfferDiscountDateTime)='$li'";
	// echo $SelectSales."<br>";
	// $RSN = $DB->query($SelectSales);
		// if ($RSN->num_rows > 0) 
		// {
			// while($rowN = $RSN->fetch_assoc())
			// {
				// $Sales = $rowN["Sales"];
				// echo $li."&nbsp; &nbsp; &nbsp;";
				// echo $Sales."<br>";
			// }
		// }
	
// }
// echo "<pre>";
// print_r($list);
// echo "</pre>";

?>


<!--<script>
var chart = AmCharts.makeChart("chartdiv", {
  "type": "pie",
  "startDuration": 0,
   "theme": "light",
  "addClassNames": true,
  "legend":{
   	"position":"right",
    "marginRight":100,
    "autoMargins":false
  },
  "innerRadius": "30%",
  "defs": {
    "filter": [{
      "id": "shadow",
      "width": "200%",
      "height": "200%",
      "feOffset": {
        "result": "offOut",
        "in": "SourceAlpha",
        "dx": 0,
        "dy": 0
      },
      "feGaussianBlur": {
        "result": "blurOut",
        "in": "offOut",
        "stdDeviation": 5
      },
      "feBlend": {
        "in": "SourceGraphic",
        "in2": "blurOut",
        "mode": "normal"
      }
    }]
  },
  "dataProvider": [-->
		<?php  
		// $list=array();
		// $pqr[]=$list;
		// $month = date('m');
		// $year = date('y');
		// for($d=1; $d<=31; $d++)
		// {
			// $time=mktime(12, 0, 0, $month, $d, $year);          
			// if (date('m', $time)==$month)       
			   // $list[]=date('Y-m-d', $time);
			
		// }
		// foreach($list as $li)
		// {
			// echo $li."<br>";
			// $SelectSales="Select SUM(TotalPayment) as Sales from tblInvoiceDetails where Date(OfferDiscountDateTime)='$li'";
			// $RSN = $DB->query($SelectSales);
			// if ($RSN->num_rows > 0) 
			// {
				// $counter = 0;
				// while($rowN = $RSN->fetch_assoc())
				// {
					// $Sales = $rowN["Sales"];
					// echo $Sales."<br>";
		?>	
			  <!--{
				"country": "<?//=$li?>",
				"litres": <?//=$list?>
			  }, -->
	<?php	
				// }
			// }
			// else
			// {
?>				
				<!--"country": "No Data Found",
				"litres": 0->
<?php				
			// }
		// }	
	?>  
  
  
  {
    "country": "The Netherlands",
    "litres": 50
  }
  
  
  
  ],
  "valueField": "litres",
  "titleField": "country",
  "export": 
  {
    "enabled": true
  }
});

chart.addListener("init", handleInit);

chart.addListener("rollOverSlice", function(e) {
  handleRollOver(e);
});

function handleInit(){
  chart.legend.addListener("rollOverItem", handleRollOver);
}

function handleRollOver(e){
  var wedge = e.dataItem.wedge.node;
  wedge.parentNode.appendChild(wedge);
}
</script>

<!-- HTML -->
<!--<div id="chartdiv"></div>	

<?php
// echo "New Charts";
?>


<style>
#chartdiv1 {
  width: 100%;
  height: 500px;
  font-size: 11px;
}

.amcharts-pie-slice {
  transform: scale(1);
  transform-origin: 50% 50%;
  transition-duration: 0.3s;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
  -o-transition: all .3s ease-out;
  cursor: pointer;
  box-shadow: 0 0 30px 0 #000;
}

.amcharts-pie-slice:hover {
  transform: scale(1.1);
  filter: url(#shadow);
}							
</style>

<!-- Resources -->
<!--<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>-->

<!-- Chart code -->
<?php

// $list=array();
// $month = date('m');
// $year = date('y');

// for($d=1; $d<=31; $d++)
// {
    // $time=mktime(12, 0, 0, $month, $d, $year);          
    // if (date('m', $time)==$month)       
       // $list[]=date('Y-m-d', $time);
	
// }
// foreach($list as $li)
// {
	// echo $li."<br>";
	// $SelectSales="Select SUM(TotalPayment) as Sales from tblInvoiceDetails where Date(OfferDiscountDateTime)='$li'";
	// echo $SelectSales."<br>";
	// $RSN = $DB->query($SelectSales);
		// if ($RSN->num_rows > 0) 
		// {
			// while($rowN = $RSN->fetch_assoc())
			// {
				// $Sales = $rowN["Sales"];
				// echo $li."&nbsp; &nbsp; &nbsp;";
				// echo $Sales."<br>";
			// }
		// }
	
// }
// echo "<pre>";
// print_r($list);
// echo "</pre>";

?>
<!--<head>
    <meta charset="utf-8" />
    <link id="themecss" rel="stylesheet" type="text/css" href="//www.shieldui.com/shared/components/latest/css/light/all.min.css" />
    <script type="text/javascript" src="//www.shieldui.com/shared/components/latest/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="//www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
</head>-->






<!--<script>
var chart = AmCharts.makeChart("chartdiv1", {
  "type": "pie",
  "startDuration": 0,
   "theme": "light",
  "addClassNames": true,
  "legend":{
   	"position":"right",
    "marginRight":100,
    "autoMargins":false
  },
  "innerRadius": "30%",
  "defs": {
    "filter": [{
      "id": "shadow",
      "width": "200%",
      "height": "200%",
      "feOffset": {
        "result": "offOut",
        "in": "SourceAlpha",
        "dx": 0,
        "dy": 0
      },
      "feGaussianBlur": {
        "result": "blurOut",
        "in": "offOut",
        "stdDeviation": 5
      },
      "feBlend": {
        "in": "SourceGraphic",
        "in2": "blurOut",
        "mode": "normal"
      }
    }]
  },
  "dataProvider": [-->
		<?php  
		// $list=array();
		// $pqr[]=$list;
		// $month = date('m');
		// $year = date('y');
		// for($d=1; $d<=31; $d++)
		// {
			// $time=mktime(12, 0, 0, $month, $d, $year);          
			// if (date('m', $time)==$month)       
			   // $list[]=date('Y-m-d', $time);
			
		// }
		// foreach($list as $li)
		// {
			// echo $li."<br>";
			// $SelectSales="Select SUM(TotalPayment) as Sales from tblInvoiceDetails where Date(OfferDiscountDateTime)='$li'";
			// $RSN = $DB->query($SelectSales);
			
			// if ($RSN->num_rows > 0) 
			// {
				// $counter = 0;
				// while($rowN = $RSN->fetch_assoc())
				// {
					// $Sales[] = $rowN["Sales"];
					// $SelectSales=select("SUM(TotalPayment) as Sales","tblInvoiceDetails","Date(OfferDiscountDateTime)='$li'");
					// $SelectSales[0]['Sales']
					// echo $Sales."<br>";

		?>	
			<!--  {
				"country": "<?//=$li?>",
				"litres": <?//=$Sales?>
			  }, -->
	<?php	
				// }
			// }
			// else
			// {
?>				
				<!--"country": "No Data Found",
				"litres": 0-->
<?php				
			// }
		// }	
	?>  
  
 <!-- 
  {
    "country": "The Netherlands",
    "litres": 50
  }
  
  
  
  ],
  "valueField": "litres",
  "titleField": "country",
  "export": 
  {
    "enabled": true
  }
});

chart.addListener("init", handleInit);

chart.addListener("rollOverSlice", function(e) {
  handleRollOver(e);
});

function handleInit(){
  chart.legend.addListener("rollOverItem", handleRollOver);
}

function handleRollOver(e){
  var wedge = e.dataItem.wedge.node;
  wedge.parentNode.appendChild(wedge);
}
</script>
<script type="text/javascript">
    $(function () {
        $("#chart").shieldChart({
            theme: "light",
            primaryHeader: {
                text: "Internet usage statistics"
            },
            axisX: {
                categoricalValues: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"]
            },
            axisY: {
                title: {
                    text: "Visitor statistics"
                }
            },
            exportOptions: {
                image: false,
                print: false
            },
            dataSeries: [
            {
                seriesType: 'bar',
                collectionAlias: "Total Visits",
                data: [
                    565000, 630400, 743000, 910200, 1170200, 1383000
                ],
                divideSeries: false
            },
            {
                seriesType: 'bar',
                barOffset: 0.2,
                collectionAlias: "Unique Visits",
                data: [
                    152000, 234000, 123000, 348000, 167000, 283000
                ]
            }
            ]
        });
    });
</script>
<!--<div id="chart"></div>-->
<!-- HTML -->
<!--<div id="chartdiv1"></div>	-->



<?php





// $NONVISITING = "Select CustomerID from tblCustomers";
// $RSN = $DB->query($NONVISITING);
// if ($RSN->num_rows > 0) 
// {
	// while($rowN = $RSN->fetch_assoc())
	// {
		// $CustomerID[] = $rowN["CustomerID"];
		// echo $CustomerID."<br>";
		// $selectApp="Select CustomerId, AppointmentID from tblAppointments where Date(AppointmentDate)>='2016-10-01' and  Date(AppointmentDate)<=Date('2016-10-21')";
		// echo $selectApp."<br>";
		// $RSA = $DB->query($selectApp);
		// if ($RSA->num_rows > 0) 
		// {
			// while($rowA = $RSA->fetch_assoc())
			// {
				// $strCustomerId = $rowA["CustomerId"];
				// $strAppointmentID = $rowA["AppointmentID"];
				// echo $CustomerID."&nbsp;&nbsp;&nbsp;&nbsp;";
				// echo $strAppointmentID."<br>";
				// if(in_array("$CustomerID", $strCustomerId))
				// {
					// echo "Visiting Customers : <br>";
					// echo $strCustomerId."<br>";
				// }
				// else
				// {
					// echo "Non Visiting Customers : <br>";
					// echo $strCustomerId."<br>";
				// }
				
				
			// }
		// }
		
	// }
// }
echo "--------------------------------------------------------------------------------------------------<br>";

// Create connection And Write Values
// $DB = Connect();
// echo $strStoreID."<br>";
// echo "Hello";
// $day = date('d');
// $Month = date('m');			//$row["Month"];
// $MonthSpell = getMonthSpelling($Month);
// $Year = 2000 + date('y');			//$row["Year"];
// $MonthYear = $MonthSpell.", ".$Year;

// $sql = "SELECT ETID, EmployeeCode, TargetForMonth, Year,BaseTarget, Week1, Week2, Week3, Week4, Week5, (SELECT EmployeeName FROM tblEmployees WHERE EmployeeCode=tblEmployeeTarget.EmployeeCode) as EmployeeName FROM tblEmployeeTarget WHERE TargetForMonth LIKE '$MonthSpell' AND Year='$Year'";
// echo $sql;
// echo $sql;

// $RS = $DB->query($sql);
// if ($RS->num_rows > 0) 
// {
	// echo "In if<br>";
	// $counter = 0;
	// while($row = $RS->fetch_assoc())
	// {
		// echo "In while<br>";
		// $counter ++;
		// $strETID = $row["ETID"];
		// $getUID = EncodeQ($strETID);
		// $getUIDDelete = Encode($strETID);
		// $EmployeeCode = $row["EmployeeCode"];
		// $TargetForMonth = $row["TargetForMonth"];
		// $Year = $row["Year"];
		// $BaseTarget = $row["BaseTarget"];
		// $Week1 = $row["Week1"];
		// $Week2 = $row["Week2"];
		// $Week3 = $row["Week3"];
		// $Week4 = $row["Week4"];
		// $Week5 = $row["Week5"];
		// $EmployeeName = $row["EmployeeName"];

	// }
// }


?>
<?php
echo "---------------------------------------------------------------------------------------------------------------<br><br><br><br><br><br>";

$DB = Connect();
echo "Cancelled appointment store wise<br><br><br>";
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');

$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSS = $DB->query($SelectStore);
			if ($RSS->num_rows > 0) 
			{
				while($rowS = $RSS->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
					$sql="Select (SELECT count(0) FROM `tblAppointments` where Status=3 and IsDeleted!='1' and AppointmentDate>='$First' and AppointmentDate<='$Last' and StoreID='$StoreID') as CancelledCount ";
					// echo $sql."<br><br><br>";
					$RSC = $DB->query($sql);
					if ($RSC->num_rows > 0) 
					{
						while($rowC = $RSC->fetch_assoc())
						{
							$CancelledCount = $rowC["CancelledCount"];
							// echo "Total Cancelled Appointments in Current month - ".$CancelledCount;// echo $TodaysMembership;
							echo "Total Cancelled Appointments in Current Month on ".$StoreName." are " .$CancelledCount."<br><br>";
						}
					}
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
echo "Appointment Confirm Count store wise<br><br><br><br><br>";
$DB = Connect();
$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
					$sql="Select (SELECT count(0) FROM `tblAppointments` where Status=2 and IsDeleted!='1' and AppointmentDate>='$First' and AppointmentDate<='$Last' and StoreID='$StoreID') as ConfirmedCount ";
					// echo $sql."<br><br><br>";
					$RSC = $DB->query($sql);
					if ($RSC->num_rows > 0) 
					{
						while($rowC = $RSC->fetch_assoc())
						{
							$ConfirmedCount = $rowC["ConfirmedCount"];
							// echo "Total Cancelled Appointments in Current month - ".$CancelledCount;// echo $TodaysMembership;
							echo "Total Done Appointments in Current Month on ".$StoreName." are " .$ConfirmedCount."<br><br>";
						}
					}
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();

$DB=Connect();
echo "This should be Total Invoices on Khar -- from that pending and done in bar chart<br>";



// ApproveInvoices="SELECT * FROM tblAppointments where status='2' and IsDeleted!='1' and ApproveStatus='1' order by AppointmentID desc";
$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
						$ApproveInvoices="Select (SELECT count(0) FROM `tblAppointments` where Status=2 and IsDeleted!='1' and ApproveStatus='1' and AppointmentDate>='$First' and AppointmentDate<='$Last' and StoreID='$StoreID') as ApprovedInvoicesCount";
						// echo $ApproveInvoices."<br><br><br>";

							$RSAI= $DB->query($ApproveInvoices);
							if($RSAI->num_rows>0)
							{
								while($ROS=$RSAI->fetch_assoc())
								{
									$ApprovedInvoicesCount = $ROS["ApprovedInvoicesCount"];
									echo "Total Approved Invoices for " .$StoreName." are ".$ApprovedInvoicesCount."<br><br><br>" ;
								}
							}
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();	
echo "Reconciliation Approval Pending Store Wise<br><br><br><br>";		
$DB=Connect();
// ApproveInvoices="SELECT * FROM tblAppointments where status='2' and IsDeleted!='1' and ApproveStatus='1' order by AppointmentID desc";
$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
						$ApprovePending="Select (SELECT count(0) FROM `tblAppointments` where Status=2 and IsDeleted!='1' and ApproveStatus!='1' and AppointmentDate>='$First' and AppointmentDate<='$Last' and StoreID='$StoreID') as ApprovalPendingCount";
						echo $ApproveInvoices."<br><br><br>";

							$RSAI= $DB->query($ApprovePending);
							if($RSAI->num_rows>0)
							{
								while($ROS=$RSAI->fetch_assoc())
								{
									$strStoreID = $ROS["StoreID"];
									$ApprovalPendingCount = $ROS["ApprovalPendingCount"];
									echo "Invoice Approval Pending on " .$StoreName." are ".$ApprovalPendingCount."<br><br><br>" ;
									
								}
							}
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();	
echo "Pending Payment Store Wise.<br><br><br><br><br>";		
$DB=Connect();
// ApproveInvoices="SELECT * FROM tblAppointments where status='2' and IsDeleted!='1' and ApproveStatus='1' order by AppointmentID desc";
$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
						$PendingAmountStores="Select SUM(tblPendingPayments.PendingAmount)as Pending,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$StoreID' and tblPendingPayments.PendingStatus=2";
						// echo $PendingAmountStores."<br><br><br>";

							$RSP= $DB->query($PendingAmountStores);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$Pending = $ROP["Pending"];
									if($Pending=="")
									{
										$Pending='0';
									}
									echo "Pending Amount from  " .$StoreName." is Rs. ".$Pending."<br><br><br>" ;
									
								}
							}
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
echo "New Customers Per Day store Wise.<br><br><br>";
$DB=Connect();
// ApproveInvoices="SELECT * FROM tblAppointments where status='2' and IsDeleted!='1' and ApproveStatus='1' order by AppointmentID desc";
$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
						$NewCustomersonEachStore="Select count(tblCustomers.CustomerID)as NewCustomersPerDay from tblCustomers Left Join tblAppointments ON tblCustomers.CustomerID=tblAppointments.CustomerID where Date(tblCustomers.RegDate)='$date' and tblAppointments.StoreID='$StoreID'";
						// echo $NewCustomersonEachStore."<br><br><br>";

							$RSP= $DB->query($NewCustomersonEachStore);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$NewCustomersPerDay = $ROP["NewCustomersPerDay"];
									if($NewCustomersPerDay=="")
									{
										$NewCustomersPerDay='0';
									}
									echo "New Customers on " .$StoreName." is Rs. ".$NewCustomersPerDay."<br><br><br>" ;
									
								}
							}
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
// $DB=Connect();
// $SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		// $RSCF = $DB->query($SelectStore);
			// if ($RSCF->num_rows > 0) 
			// {
				// while($rowS = $RSCF->fetch_assoc())
				// {
					// $StoreID = $rowS["StoreID"];
					// $StoreName = $rowS["StoreName"];
						// $TotalProductAlert="Select (SELECT count(0) FROM `tblStoreProduct` where Stock<5 and StoreID='$StoreID') as ProductAlertCount";
						echo $TotalProductAlert."<br><br><br>";
						
							// $RSP= $DB->query($TotalProductAlert);
							// if($RSP->num_rows>0)
							// {
								// while($ROP=$RSP->fetch_assoc())
								// {
									// $ProductAlertCount = $ROP["ProductAlertCount"];
									// if($ProductAlertCount=="")
									// {
										// $ProductAlertCount='0';
									// }
									// echo "Store " .$StoreName." need Total Products are. ".$ProductAlertCount."<br><br><br>" ;
									
								// }
							// }
				// }
			// }
// echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
echo "Low stockNotification Count Store Wise. <br><br><br><br><br>";
$DB=Connect();
$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
						$TotalProductAlert="Select (SELECT count(0) FROM `tblStoreProduct` where Stock<5 and StoreID='$StoreID') as ProductAlertCount";
						// echo $TotalProductAlert."<br><br><br>";
						
							$RSP= $DB->query($TotalProductAlert);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$ProductAlertCount = $ROP["ProductAlertCount"];
									if($ProductAlertCount=="")
									{
										$ProductAlertCount='0';
									}
									echo "Store " .$StoreName." need Total Products are. ".$ProductAlertCount."<br><br><br>" ;
									
								}
							}
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();

echo "Attendance with checkin & check out.<br><br><br><br>";

$DB=Connect();
$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
						// $TotalProductAlert="Select (SELECT count(0) FROM `tblStoreProduct` where Stock<5 and StoreID='$StoreID') as ProductAlertCount";
						// echo $TotalProductAlert."<br><br><br>";
						
						$SelectEmpAttendance="Select count(tblEmployeesRecords.EmployeeCode)as EmployeeAttendant from tblEmployeesRecords Left Join tblEmployees ON tblEmployeesRecords.EmployeeCode=tblEmployees.EmployeeCode where tblEmployees.StoreID='$StoreID' and tblEmployeesRecords.DateOfAttendance='$date' and tblEmployeesRecords.LoginTime!='00:00:00' and tblEmployeesRecords.Status='1' ";
						// echo $SelectEmpAttendance."<br><br><br>";
						
							$RSP= $DB->query($SelectEmpAttendance);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$EmployeeAttendant = $ROP["EmployeeAttendant"];
									if($EmployeeAttendant=="")
									{
										$EmployeeAttendant='0';
									}
									// echo "".$StoreName."  ".$EmployeeAttendant." Employees <br><br><br>" ;
									echo $EmployeeAttendant." are present in " . $StoreName."<br><br><br>";
									
								}
							}
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();


echo "Petty Cash Spent and Balance.1<br><br><br><br>";

$DB=Connect();
$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
						// $TotalProductAlert="Select (SELECT count(0) FROM `tblStoreProduct` where Stock<5 and StoreID='$StoreID') as ProductAlertCount";
						// echo $TotalProductAlert."<br><br><br>";
					
						
						
						$SelectExpenseBalance="Select tblExpensesBalance.Balance, SUM(tblExpenses.Amount) as Expenses from tblExpensesBalance left Join tblExpenses ON tblExpensesBalance.StoreID=tblExpenses.StoreID where tblExpensesBalance.StoreID='$StoreID' and tblExpenses.Status='0'";
						// echo $SelectExpenseBalance."<br><br><br><br>";
						
							$RSP= $DB->query($SelectExpenseBalance);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$Expenses = $ROP["Expenses"];
									$Balance = $ROP["Balance"];
									if($Expenses=="")
									{
										$Expenses='0';
									}if($Balance=="")
									{
										$Balance='0';
									}
									// echo "".$StoreName."  ".$EmployeeAttendant." Employees <br><br><br>" ;
									// echo $EmployeeAttendant." are present in " . $StoreName."<br><br><br>";
									echo $StoreName." Balance is Rs. ".$Balance. " And Expense is Rs.".$Expenses."<br><br><br>";
								}
							}
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();

echo "Petty Cash Spent and Balance.2<br><br><br><br>";
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');

$DB=Connect();
$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
						// $TotalProductAlert="Select (SELECT count(0) FROM `tblStoreProduct` where Stock<5 and StoreID='$StoreID') as ProductAlertCount";
						// echo $TotalProductAlert."<br><br><br>";
					
						
						
						$SelectExpenseBalance="Select tblExpensesBalance.Balance, SUM(tblExpenses.Amount) as Expenses from tblExpensesBalance left Join tblExpenses ON tblExpensesBalance.StoreID=tblExpenses.StoreID where tblExpensesBalance.StoreID='$StoreID' and Date(tblExpensesBalance.DateTime)>='$First' and Date(tblExpensesBalance.DateTime)<='$Last' and Date(tblExpenses.DateOfExpense)>='$First' and Date(tblExpenses.DateOfExpense)<='$Last'";
						// echo $SelectExpenseBalance."<br><br><br><br>";
						
							$RSP= $DB->query($SelectExpenseBalance);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$Expenses = $ROP["Expenses"];
									$Balance = $ROP["Balance"];
									if($Expenses=="")
									{
										$Expenses='0';
									}if($Balance=="")
									{
										$Balance='0';
									}
									// echo "".$StoreName."  ".$EmployeeAttendant." Employees <br><br><br>" ;
									// echo $EmployeeAttendant." are present in " . $StoreName."<br><br><br>";
									echo $StoreName." Balance is Rs. ".$Balance. " And Expense is Rs.".$Expenses."<br><br><br>";
								}
							}
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();

echo "Target Wise Monthly Gift Voucher Sold Per Day<br><br><br><br>";
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');

$DB=Connect();
$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
						// $TotalProductAlert="Select (SELECT count(0) FROM `tblStoreProduct` where Stock<5 and StoreID='$StoreID') as ProductAlertCount";
						// echo $TotalProductAlert."<br><br><br>";
					
						$TotalGiftVouchersSold="Select (SELECT count(0) FROM `tblGiftVouchers` where Date(RedempedDateTime)>='$First' and Date(RedempedDateTime)<='$Last' and StoreID='$StoreID') as TotalGiftVoucherSolds";
							// echo $TotalGiftVouchersSold."<br><br><br>";
					
						
							$RSP= $DB->query($TotalGiftVouchersSold);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$TotalGiftVoucherSolds = $ROP["TotalGiftVoucherSolds"];
									if($TotalGiftVoucherSolds=="")
									{
										$TotalGiftVoucherSolds='0';
									}
									// echo "".$StoreName."  ".$EmployeeAttendant." Employees <br><br><br>" ;
									// echo $EmployeeAttendant." are present in " . $StoreName."<br><br><br>";
									echo $StoreName." Gift voucher sale is . ".$TotalGiftVoucherSolds."<br><br><br>";
								}
							}
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();

echo "Target Wise Monthly Membership Sold Per Month<br><br><br><br>";
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');

$DB=Connect();
$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
						// $TotalProductAlert="Select (SELECT count(0) FROM `tblStoreProduct` where Stock<5 and StoreID='$StoreID') as ProductAlertCount";
						// echo $TotalProductAlert."<br><br><br>";
					
						$TotalGiftVouchersSold="Select (SELECT count(MembershipID) FROM `tblAppointmentMembershipDiscount` where tblAppointmentMembershipDiscount.MembershipID>0 Date(RedempedDateTime)>='$First' and Date(RedempedDateTime)<='$Last' and StoreID='$StoreID') as TotalGiftVoucherSolds";
						
						
						$TotalMembershipSold="Select count(tblAppointmentMembershipDiscount.MembershipID) as MembershipSold FROM `tblAppointmentMembershipDiscount` Left Join tblAppointments ON tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID where tblAppointmentMembershipDiscount.MembershipID>'0' and Date(tblAppointmentMembershipDiscount.DateTimeStamp)>='$First' and Date(tblAppointmentMembershipDiscount.DateTimeStamp)<='$Last' and tblAppointments.StoreID='$StoreID'";
						
							// echo $TotalMembershipSold."<br><br><br>";
					
						
						
							$RSP= $DB->query($TotalMembershipSold);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$MembershipSold = $ROP["MembershipSold"];
									if($MembershipSold=="")
									{
										$MembershipSold='0';
									}
									// echo "".$StoreName."  ".$EmployeeAttendant." Employees <br><br><br>" ;
									// echo $EmployeeAttendant." are present in " . $StoreName."<br><br><br>";
									echo $StoreName." Membership Sold. ".$MembershipSold."<br><br><br>";
								}
							}
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();

echo "Offer Amount Store Wise<br><br><br><br>";
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');

$DB=Connect();
$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
						// $TotalProductAlert="Select (SELECT count(0) FROM `tblStoreProduct` where Stock<5 and StoreID='$StoreID') as ProductAlertCount";
						// echo $TotalProductAlert."<br><br><br>";
					
						$OfferAmount="Select SUM(tblAppointmentMembershipDiscount.OfferAmount)as OfferAmt from tblAppointmentMembershipDiscount Left Join tblAppointments ON tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$StoreID' and Date(tblAppointmentMembershipDiscount.DateTimeStamp)>='$First' and Date(tblAppointmentMembershipDiscount.DateTimeStamp)<='$Last'";
						// echo $OfferAmount."<br><br><br>";
					
						
						
							$RSP= $DB->query($OfferAmount);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$OfferAmt = $ROP["OfferAmt"];
									if($OfferAmt=="")
									{
										$OfferAmt='0';
									}
									
									echo $StoreName." Offer Sold for Rs. ".$OfferAmt."<br><br><br>";
								}
							}
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
echo "Membership Amount Store Wise<br><br><br><br>";
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');

$DB=Connect();
$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
						// $TotalProductAlert="Select (SELECT count(0) FROM `tblStoreProduct` where Stock<5 and StoreID='$StoreID') as ProductAlertCount";
						// echo $TotalProductAlert."<br><br><br>";
					
						// $MembershipAmount="Select SUM(tblAppointmentMembershipDiscount.MembershipAmount)as MembershipAmt from tblAppointmentMembershipDiscount Left Join tblAppointments ON tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$StoreID' and Date(tblAppointmentMembershipDiscount.DateTimeStamp)>='$First' and Date(tblAppointmentMembershipDiscount.DateTimeStamp)<='$Last'";
						// echo $MembershipAmount."<br><br><br>";
						
							$MembershipAmount="Select SUM(tblAppointmentMembershipDiscount.MembershipAmount)as MembershipAmt from tblAppointmentMembershipDiscount Left Join tblAppointments ON tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$StoreID' and Date(tblAppointmentMembershipDiscount.DateTimeStamp)='$date'";
						// echo $MembershipAmount."<br><br><br>";
					
					
						
						
							$RSP= $DB->query($MembershipAmount);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$MembershipAmt = $ROP["MembershipAmt"];
									if($MembershipAmt=="")
									{
										$MembershipAmt='0';
									}
									
									echo $StoreName." Sold Membership for Rs. ".$MembershipAmt."<br><br><br>";
								}
							}
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
echo "Total Discounts Given Amount Store Wise - include Membership + Offers + Vouchers <br><br><br><br>";
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');

$DB=Connect();
$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
						// $TotalProductAlert="Select (SELECT count(0) FROM `tblStoreProduct` where Stock<5 and StoreID='$StoreID') as ProductAlertCount";
						// echo $TotalProductAlert."<br><br><br>";
					
						$MembershipAmount="Select SUM(tblAppointmentMembershipDiscount.MembershipAmount)as MembershipAmt, SUM(tblAppointmentMembershipDiscount.OfferAmount)as Offeramount from tblAppointmentMembershipDiscount Left Join tblAppointments ON tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$StoreID' and Date(tblAppointmentMembershipDiscount.DateTimeStamp)>='$First' and Date(tblAppointmentMembershipDiscount.DateTimeStamp)<='$Last'";
						// echo $MembershipAmount."<br><br><br>";
						
							$RSP= $DB->query($MembershipAmount);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$MembershipAmt = $ROP["MembershipAmt"];
									$Offeramount = $ROP["Offeramount"];
									if($MembershipAmt=="")
									{
										$MembershipAmt='0';
									}if($Offeramount=="")
									{
										$Offeramount='0';
									}
									$TotalDiscount=$Offeramount+$MembershipAmt;
									
									
									
									$DisAmt="Select Sum(Amount)as DiscountAmt from tblGiftVouchers where Date(RedempedDateTime)>='$First' and Date(RedempedDateTime)<='$Last' and StoreID='$StoreID'";
									// echo $DisAmt."<br><br><br><br>";
									$RSD= $DB->query($DisAmt);
									if($RSD->num_rows>0)
									{
										while($ROD=$RSD->fetch_assoc())
										{
											$DiscountAmt = $ROD["DiscountAmt"];
											// $DiscountAmt;
											$TotalDisc=$TotalDiscount+$DiscountAmt;
											// echo $TotalDisc."<br>";
										}
									}	
									echo $StoreName." Total Disc is Rs. ".$TotalDisc."<br><br><br>";
									
								}
							}
				}
			}
			
			
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();

echo "Average Revenue per client Store Wise <br><br><br><br>";
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');



$DB=Connect();
$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
						// $TotalProductAlert="Select (SELECT count(0) FROM `tblStoreProduct` where Stock<5 and StoreID='$StoreID') as ProductAlertCount";
						// echo $TotalProductAlert."<br><br><br>";
					
						$AverageRevinueperclient="SELECT SUM(tblInvoiceDetails.TotalPayment) as TotalPay, count(tblAppointments.CustomerID) as TotalCustomers FROM tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='$StoreID' and tblInvoiceDetails.Flag='C' OR tblInvoiceDetails.Flag='CS' OR tblInvoiceDetails.Flag='BOTH' and tblAppointments.AppointmentDate<='$First' and tblAppointments.AppointmentDate>='$Last'";
						// echo $AverageRevinueperclient."<br><br><br>";
						
							$RSAR= $DB->query($AverageRevinueperclient);
							if($RSAR->num_rows>0)
							{
								while($ROAR=$RSAR->fetch_assoc())
								{
									$TotalPay = $ROAR["TotalPay"];
									$TotalCustomers = $ROAR["TotalCustomers"];
									
									// $SelectCustomer="SELECT Distinct(CustomerID) as CustomerCount FROM `tblAppointments` where StoreID='$StoreID'";
									// echo $SelectCustomer."<br>";
									// $RSCust= $DB->query($SelectCustomer);
										// if($RSCust->num_rows>0)
										// {
											// while($ROCust=$RSCust->fetch_assoc())
											// {
												// $CustomerCount[] = $ROCust["CustomerCount"];
												// echo count($CustomerCount)."<br>";
												
											// }
													
										// }
										
										$Average=$TotalPay/$TotalCustomers;
												
												echo $StoreName." Per Client Rs. ".$Average."<br><br><br>";
									// echo $TotalPay." for ".StoreName." and Total Customers are ".$TotalCustomers."<br>";
								
									
								}
							}
				}
			}
			
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();

echo "Service Wise Revinue<br><br><br><br>";
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');



$DB=Connect();
$SelectCat="SELECT * from tblCategories where Status='0'";
// echo $SelectStore."<br><br>";
		$RSCAT = $DB->query($SelectCat);
			if ($RSCAT->num_rows > 0) 
			{
				$counter = 0;
				
				while($rowCAT = $RSCAT->fetch_assoc())
				{
					$counter ++;
					$strCategoryID = $rowCAT["CategoryID"];
					$strCategoryName = $rowCAT["CategoryName"];
					
						$sqlservice = "SELECT tblProductsServices.CategoryID, tblProductsServices.ServiceID , tblServices.ServiceName, tblServices.ServiceCost, tblServices.ServiceCode,tblProductsServices.StoreID
								FROM `tblProductsServices` left join tblServices 
								on tblProductsServices.ServiceID=tblServices.ServiceID
								where tblProductsServices.CategoryID='$strCategoryID' and tblServices.ServiceID!='' and tblServices.ServiceID!='null' and tblServices.ServiceID!='NULL'
								group by tblProductsServices.ServiceID order by tblProductsServices.ProductServiceID desc ";
						// echo $sqlservice."<br><br><br>";
						
							$RSSER= $DB->query($sqlservice);
							if($RSSER->num_rows>0)
							{
								while($ROSER=$RSSER->fetch_assoc())
								{
									$CategoryID = $ROSER["CategoryID"];
									$ServiceID = $ROSER["ServiceID"];
									$ServiceName = $ROSER["ServiceName"];
									$ServiceCost = $ROSER["ServiceCost"];
									$ServiceCode = $ROSER["ServiceCode"];
									$StoreID = $ROSER["StoreID"];
									
									// echo $CategoryID."<br>";
									// echo $ServiceID."<br>";
									// echo $ServiceName."<br>";
									// echo $ServiceCost."<br>";
									// echo $ServiceCode."<br>";
									// echo $StoreID."<br>";
									
									$sqldata = "SELECT tblAppointmentsDetailsInvoice.qty, tblAppointmentsDetailsInvoice.ServiceAmount, tblInvoiceDetails.OfferDiscountDateTime
								FROM tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentID left join tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID
								WHERE tblAppointmentsDetailsInvoice.ServiceID ='$ServiceID' and tblAppointments.IsDeleted!='1' $sqlTempfrom $sqlTempto";
								// echo $sqldata."<br><br><br>";
									$RSdata = $DB->query($sqldata);
									if ($RSdata->num_rows > 0) 
									{
										while($rowdata = $RSdata->fetch_assoc())
										{
											$strAppointmentID = $rowdata["AppointmentID"];
											$strqty += $rowdata["qty"];
											// echo $strqty."<br><br><br><br>";
											$strServiceAmount += $rowdata["ServiceAmount"];
										}
									}
									else
									{
										$strqty = "0";
										$strServiceAmount = "0";
									}
									
									$sqldiscount = "SELECT tblAppointmentMembershipDiscount.OfferAmount, tblAppointmentMembershipDiscount.MembershipAmount 
													FROM tblAppointmentMembershipDiscount
													left join tblInvoiceDetails 
													on tblAppointmentMembershipDiscount.AppointmentID=tblInvoiceDetails.AppointmentID
													left join tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID	WHERE tblAppointmentMembershipDiscount.ServiceID ='$strServiceID' and tblAppointments.IsDeleted!='1' $sqlTempfrom $sqlTempto";
									//echo $sqldiscount;
									$RSdiscount = $DB->query($sqldiscount);
									$counterDiscountUsage = "0";
									if ($RSdiscount->num_rows > 0) 
									{
										while($rowdiscount = $RSdiscount->fetch_assoc())
										{
											$counterDiscountUsage = $counterDiscountUsage + 1;
											$strOfferAmount += $rowdiscount["OfferAmount"];
											$strMembershipAmount += $rowdiscount["MembershipAmount"];
										}
									}
									else
									{
										$strOfferAmount = "0";
										$strMembershipAmount = "0";
									}
									
									$strServiceNet = ($strServiceAmount) - ($strMembershipAmount);
									$strServiceNet2 = ($strServiceNet) - ($strOfferAmount);
												
													
								}
							}
				}
			}
			
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();

echo "Average Revenue per client Store Wise <br><br><br><br>";
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');



$DB=Connect();				
					$sqlProductused = "select tblInvoiceDetails.AppointmentId, tblInvoiceDetails.InvoiceId, tblInvoiceDetails.CustomerID, tblInvoiceDetails.CustomerFullName, tblInvoiceDetails.ServiceName, tblInvoiceDetails.Qty, tblInvoiceDetails.OfferDiscountDateTime from tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.IsDeleted!='1' $sqlTempfrom $sqlTempto";
						// echo $AverageRevinueperclient."<br><br><br>";
						
							$RSAR= $DB->query($sqlProductused);
							if($RSAR->num_rows>0)
							{
								while($ROAR=$RSAR->fetch_assoc())
								{
									$TotalPay = $ROAR["TotalPay"];
									$TotalCustomers = $ROAR["TotalCustomers"];
									
									$Average=$TotalPay/$TotalCustomers;
												
									// echo $StoreName." Per Client Rs. ".$Average."<br><br><br>";
								}
							}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
echo "Total Discounts Given Amount include Membership + Offers + Vouchers <br><br><br><br>";
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');

$DB=Connect();
					
						$MembershipAmount="Select SUM(tblAppointmentMembershipDiscount.MembershipAmount)as MembershipAmt, SUM(tblAppointmentMembershipDiscount.OfferAmount)as Offeramount from tblAppointmentMembershipDiscount Left Join tblAppointments ON tblAppointmentMembershipDiscount.AppointmentID=tblAppointments.AppointmentID WHERE  Date(tblAppointmentMembershipDiscount.DateTimeStamp)>='$First' and Date(tblAppointmentMembershipDiscount.DateTimeStamp)<='$Last'";
						// echo $MembershipAmount."<br><br><br>";
						
							$RSP= $DB->query($MembershipAmount);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$MembershipAmt = $ROP["MembershipAmt"];
									$Offeramount = $ROP["Offeramount"];
									if($MembershipAmt=="")
									{
										$MembershipAmt='0';
									}if($Offeramount=="")
									{
										$Offeramount='0';
									}
									$TotalDiscount=$Offeramount+$MembershipAmt;
									
									$DisAmt="Select Sum(Amount)as DiscountAmt from tblGiftVouchers where Date(RedempedDateTime)>='$First' and Date(RedempedDateTime)<='$Last'";
									echo $DisAmt."<br><br><br><br>";
									$RSD= $DB->query($DisAmt);
									if($RSD->num_rows>0)
									{
										while($ROD=$RSD->fetch_assoc())
										{
											$DiscountAmt = $ROD["DiscountAmt"];
											// $DiscountAmt;
											$TotalDisc=$TotalDiscount+$DiscountAmt;
											echo $TotalDisc."<br>";
										}
									}	
									// echo $StoreName." Total Disc is Rs. ".$TotalDisc."<br><br><br>";
									
								}
							}
			
			
			
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
$DB=Connect();
					
						$Services="Select * from tblServices";
						// echo $MembershipAmount."<br><br><br>";
						
							$RSP= $DB->query($Services);
							if($RSP->num_rows>0)
							{
								while($ROP=$RSP->fetch_assoc())
								{
									$ServiceID = $ROP["ServiceID"];
									// echo $ServiceID.",";
								}
							}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";							
$DB->close();
// $DB=Connect();
// $getTodaysDate = date("Y-m-d");
											// $sqltotal="select Sum(tblInvoiceDetails.TotalPayment) as Total, SUM(tblInvoiceDetails.CashAmount)as CashTotal,SUM(tblInvoiceDetails.CardAmount)as CardTotal, tblAppointments.StoreID
														// from tblInvoiceDetails 
														// left join tblAppointments 
														// on tblInvoiceDetails.AppointmentID=tblAppointments.AppointmentID
														// where Date(tblInvoiceDetails.OfferDiscountDateTime)=Date('$getTodaysDate') and tblAppointments.StoreID ='4'";
														
											
											// $RSTotal = $DB->query($sqltotal);
											// if ($RSTotal->num_rows > 0) 
											// {
												// while($rowstotal = $RSTotal->fetch_assoc())
												// {
													// $strtotal = $rowstotal["Total"];
													// $strCashTotal = $rowstotal["CashTotal"];
													// $strCardTotal = $rowstotal["CardTotal"];
													
												// }
											// }
											// else
											// {
												// $strtotal = '0';
											// }
											// $Pamt="Select SUM(tblPendingPayments.PendingAmount)as Pending from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='2' and tblPendingPayments.PendingStatus=2 and tblAppointments.AppointmentDate='$getTodaysDate'";
											// echo $Pamt."<br>";
											// $RSpamt = $DB->query($Pamt);
											// if ($RSpamt->num_rows > 0) 
											// {
												// while($rowa = $RSpamt->fetch_assoc())
												// {
													// $PendingAmt = $rowa["PendingAmt"];
													// if($PendingAmt=="")
													// {
														// $PendingAmt='0';
													// }
												// }
											// }
											// $yr= date('Y');
											// $CurrentMonth = date('m');			//$row["Month"];
											// $Month = getMonthSpelling($CurrentMonth);
											// $CurrMonth=date('m');
											// $number = cal_days_in_month(CAL_GREGORIAN, $CurrMonth, $yr);
											// echo $number."<br>";
											// $MT="Select TargetAmount from tblStoreSalesTarget where Year='$yr' and Month= '$Month' and StoreID='4' ";
											// echo $MT."<br>";
											// $RSMT = $DB->query($MT);
											// if ($RSMT->num_rows > 0) 
											// {
												// while($rowMT = $RSMT->fetch_assoc())
												// {
													// $TargetAmount = $rowMT["TargetAmount"];
													// $TodaysTarget= $TargetAmount/$number;
												// }
											// }
											// if($TodaysTarget>$strtotal)
											// {
												// $TargetShort=$TodaysTarget-$strtotal;
												// $FinalTarget=round($TargetShort);
											// }
											// else
											// {
												// $TargetShort="Target Achieved.";
											// }
											// $MAC="SELECT Count(tblAppointmentMembershipDiscount.MembershipID) as MCount, SUM(tblAppointmentMembershipDiscount.MembershipAmount) as MAmount from tblAppointmentMembershipDiscount Left Join tblAppointments ON tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID where tblAppointments.AppointmentDate='2016-10-25' and tblAppointments.StoreID='4'";
											
											// echo $MAC."<br>";
											// $RSMT = $DB->query($MT);
											// if ($RSMT->num_rows > 0) 
											// {
												// while($rowMT = $RSMT->fetch_assoc())
												// {
													// $MCount = $rowMT["MCount"];
													// $MAmount = $rowMT["MAmount"];
													// if($MCount=="")
													// {
														// $MCount='0';
													// }
													// if($MAmount=="")
													// {
														// $MAmount='0';
													// }
												// }
											// }
											
											
											// $PendingRec="Select (SELECT count(0) FROM tblAppointments where Status=2 and IsDeleted!='1' and ApproveStatus!='1' and AppointmentDate='$getTodaysDate' and StoreID='4') as ApprovalPendingCount";
											// echo $PendingRec."<br>";
											// $RSPR = $DB->query($PendingRec);
											// if ($RSPR->num_rows > 0) 
											// {
												// while($rowPC = $RSPR->fetch_assoc())
												// {
													// $ApprovalPendingCount = $rowPC["ApprovalPendingCount"];
												// }
											// }
											
											
											// echo "<b>Total Sales Today : Rs. $strtotal/ - </b> <br>";
											// $Content= "Nailspa " .$strNameofTheStore." is Closed with Total Amount Rs ".$strtotal. 
											// ", PA : Rs.".$PendingAmt.
											// ", MT : Rs.".$TargetAmount.
											// ", Cash : Rs.".$strCashTotal.
											// ", CC : Rs.".$strCardTotal.
											// ", MSC :".$MCount.
											// ", MA : Rs.".$MAmount.
											// ", TS : Rs.".$FinalTarget.
											// ", PRI :".$ApprovalPendingCount;
											
											
											
											// echo $Content."<br>";
											
											// $my='9867510596';
											// $SendSMS = CreateSMSURL("Nailspa Day Closing","0","0",$Content,$my);													
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";							
// $DB->close();
$First= date('Y-m-01');
$Last= date('Y-m-t');
$DB=Connect();
			// $SelectTotalPaymentSum="Select SUM(tblInvoiceDetails.TotalPayment) as TotalSale from tblInvoiceDetails  Left Join tblAppointments ON tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.AppointmentDate>='$First' and tblAppointments.AppointmentDate<='$Last'";
			// echo $SelectTotalPaymentSum."<br>";
			
		$SelectServiceID="Select tblInvoiceDetails.ServiceName as ServicesDone from tblInvoiceDetails Left join tblAppointments On tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.AppointmentDate<='$First' and tblAppointments.AppointmentDate>='$Last'";
		echo $SelectServiceID."<br>";
		 $RSSS = $DB->query($SelectServiceID);
		if ($RSSS->num_rows > 0) 
		{
			echo "In if<br>";
			while($rowSS = $RSSS->fetch_assoc())
			{
				$ServiceName = $rowSS["ServiceName"];
				// echo $ServiceName."<br>";
				$string=implode("," , $ServiceName);
				echo $string;
			}
		}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";							
$DB->close();
echo "Employee Attendance Record Store Wise<br><br><br><br>";
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');



$DB=Connect();
$SelectStore="Select StoreID, StoreName from tblStores";
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
					
						$SelectEmployee="Select Count(tblEmployeesRecords.EmployeeCode) as EMPPRESENT from tblEmployeesRecords Left Join tblEmployees ON tblEmployeesRecords.EmployeeCode=tblEmployees.EmployeeCode where tblEmployeesRecords.DateOfAttendance>='$First' and tblEmployeesRecords.DateOfAttendance<='$Last' and tblEmployees.StoreID='$StoreID' and tblEmployeesRecords.LoginTime!='00:00:00'";
						
							$RSEM= $DB->query($SelectEmployee);
							if($RSEM->num_rows>0)
							{
								while($ROEM=$RSEM->fetch_assoc())
								{
									$EMPPRESENT = $ROEM["EMPPRESENT"];
									echo $StoreName." Total Present Employees are . ".$EMPPRESENT."<br><br><br>";
									// echo $TotalPay." for ".StoreName." and Total Customers are ".$TotalCustomers."<br>";
								}
							}
				}
			}
			
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();



$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');
$DB=Connect();
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
					
						$SelectEmployee="Select Count(tblEmployeesRecords.EmployeeCode) as EMPPRESENT from tblEmployeesRecords Left Join tblEmployees ON tblEmployeesRecords.EmployeeCode=tblEmployees.EmployeeCode where tblEmployeesRecords.DateOfAttendance>='$First' and tblEmployeesRecords.DateOfAttendance<='$Last' and tblEmployees.StoreID='$StoreID' and tblEmployeesRecords.LoginTime!='00:00:00'";
						
							$RSEM= $DB->query($SelectEmployee);
							if($RSEM->num_rows>0)
							{
								while($ROEM=$RSEM->fetch_assoc())
								{
									$EMPPRESENT = $ROEM["EMPPRESENT"];
									// echo $StoreName." Total Present Employees are . ".$EMPPRESENT."<br><br><br>";
									// echo $TotalPay." for ".StoreName." and Total Customers are ".$TotalCustomers."<br>";
									$TotalEmp="Select Count(EmployeeCode)as TotalEmp from tblEmployees where StoreID='$StoreID'";
									$RSE = $DB->query($TotalEmp);
									if ($RSE->num_rows > 0) 
									{
										while($rowE = $RSE->fetch_assoc())
										{
											$TotalEmp = $rowE["TotalEmp"];
											
											
											echo $StoreName."<br>";
											echo $TotalEmp."<br>";
											echo $EMPPRESENT."<br><br><br>";
																		
										}
									}
								}
							}
				}
			}
			else
			{
					echo "No Records Found";
			}

echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');
$DB=Connect();
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
					
					$sqlst ="SELECT Sum(tblInvoiceDetails.TotalPayment) as Sales, (select StoreName from tblStores where StoreID=tblAppointments.StoreID) as StoreName
					FROM tblInvoiceDetails
					left join tblAppointments 
					on tblInvoiceDetails.AppointmentId = tblAppointments.AppointmentID
					where tblAppointments.StoreID!='NULL' group by tblAppointments.StoreID";
					
					$RSst = $DB->query($sqlst);
					if ($RSst->num_rows > 0) 
					{
						$counter = 0;

						while($rowst = $RSst->fetch_assoc())
						{
							$counter ++;
							$abc = $rowst["StoreName"];
							$strStoreName = substr($abc, 0, 6);
							$strSales = $rowst["Sales"];
						}
					}
					
					
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');
$DB=Connect();
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
						$TotalSales="SELECT Sum(tblInvoiceDetails.TotalPayment) as Sales FROM tblInvoiceDetails left join tblAppointments  on tblInvoiceDetails.AppointmentId = tblAppointments.AppointmentID where tblAppointments.StoreID='$StoreID' and tblAppointments.AppointmentDate>='16-10-01' and tblAppointments.AppointmentDate<='16-10-31' and tblAppointments.Status='2'";
						// echo $TotalSales."<br>";
						$RSst = $DB->query($TotalSales);
						if ($RSst->num_rows > 0) 
						{
							$counter = 0;

							while($rowst = $RSst->fetch_assoc())
							{
								$counter ++;
								$strStoreName = substr($StoreName, 0, 6);
								$strSales = $rowst["Sales"];
								echo "Store ".$strStoreName. " monthly sales is ".$strSales.".<br>";
							}
						}
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');
$DB=Connect();
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
						$EmpSales="SELECT tblServices.ServiceCost, tblServices.ServiceID,tblAppointments.StoreID, tblAppointmentAssignEmployee.MECID, tblAppointmentAssignEmployee.Commission from tblServices left Join tblAppointmentAssignEmployee on tblServices.ServiceID=tblAppointmentAssignEmployee.ServiceID Left Join tblAppointments On tblAppointments.AppointmentID=tblAppointmentAssignEmployee.AppointmentID 
Left Join tblEmployees ON tblAppointmentAssignEmployee.MECID=tblEmployees.EID
where tblAppointments.AppointmentDate='$date' and tblAppointments.StoreID='$StoreID' and tblAppointmentAssignEmployee.MECID!='0'";
						// echo $EmpSales."<br>";
						$RSst = $DB->query($EmpSales);
						if ($RSst->num_rows > 0) 
						{
							$counter = 0;

							while($rowst = $RSst->fetch_assoc())
							{
								$counter ++;
								$ServiceCost1 = $rowst["ServiceCost"];
								$ServiceID = $rowst["ServiceID"];
								$MECID = $rowst["MECID"];
								$NewStore = $rowst["StoreID"];
								$Commission = $rowst["Commission"];
								if($Commission==2)
								{
									$ServiceCost=$ServiceCost1/2;
									// echo $ServiceCost."<br>";
								}
								else
								{
									$ServiceCost=$ServiceCost1;
								}
								// echo $MECID." has done Service(".$ServiceID.") of Rs.".$ServiceCost." on Store ".$NewStore."<br>";
							}
						}
				}
			}	
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');
$DB=Connect();
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
					
						$EmpSales="SELECT tblServices.ServiceCost, tblServices.ServiceID,tblAppointments.StoreID, tblAppointmentAssignEmployee.MECID, tblAppointmentAssignEmployee.Commission from tblServices left Join tblAppointmentAssignEmployee on tblServices.ServiceID=tblAppointmentAssignEmployee.ServiceID Left Join tblAppointments On tblAppointments.AppointmentID=tblAppointmentAssignEmployee.AppointmentID 
Left Join tblEmployees ON tblAppointmentAssignEmployee.MECID=tblEmployees.EID
where tblAppointments.AppointmentDate='$date' and tblAppointments.StoreID='$StoreID' and tblAppointmentAssignEmployee.MECID!='0'";
						// echo $EmpSales."<br>";
						$RSst = $DB->query($EmpSales);
						if ($RSst->num_rows > 0) 
						{
							$counter = 0;

							while($rowst = $RSst->fetch_assoc())
							{
								$counter ++;
								$ServiceCost1 = $rowst["ServiceCost"];
								$ServiceID = $rowst["ServiceID"];
								$MECID = $rowst["MECID"];
								$NewStore = $rowst["StoreID"];
								$Commission = $rowst["Commission"];
								if($Commission==2)
								{
									$ServiceCost=$ServiceCost1/2;
									echo $ServiceCost."<br>";
								}
								else
								{
									$ServiceCost=$ServiceCost1;
								}
								// echo $MECID." has done Service(".$ServiceID.") of Rs.".$ServiceCost." on Store ".$NewStore."<br>";
							}
						}
				}
			}	
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');
$DB=Connect();
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$strStoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
					
					$SelectEMP="Select tblEmployees.EID, tblEmployeeTarget.BaseTarget from tblEmployees Left join tblEmployeeTarget ON tblEmployees.EmployeeCode=tblEmployeeTarget.EmployeeCode where tblEmployees.StoreID='$StoreID'";
					$RSEMP = $DB->query($SelectEMP);
						if ($RSEMP->num_rows > 0) 
						{
							$counter = 0;

							while($rowEM = $RSEMP->fetch_assoc())
							{
								$counter ++;
								$EID = $rowEM["EID"];
								$BaseTarget = $rowEM["BaseTarget"];
								// echo $EID."'s Target is ".$BaseTarget."<br>";
								
								$EmpSales="SELECT tblServices.ServiceCost, tblServices.ServiceID,tblAppointments.StoreID, tblAppointmentAssignEmployee.MECID, tblAppointmentAssignEmployee.Commission from tblServices left Join tblAppointmentAssignEmployee on tblServices.ServiceID=tblAppointmentAssignEmployee.ServiceID Left Join tblAppointments On tblAppointments.AppointmentID=tblAppointmentAssignEmployee.AppointmentID 
Left Join tblEmployees ON tblAppointmentAssignEmployee.MECID=tblEmployees.EID
where tblAppointments.AppointmentDate='$date' and tblAppointments.StoreID='$strStoreID' and tblAppointmentAssignEmployee.MECID!='0' and tblAppointmentAssignEmployee.MECID='$EID'";
// echo $EmpSales."<br>";
								$RSst = $DB->query($EmpSales);
								if ($RSst->num_rows > 0) 
								{
									$counter = 0;

									while($rowst = $RSst->fetch_assoc())
									{
										$counter ++;
										$ServiceCost1 = $rowst["ServiceCost"];
										$ServiceID = $rowst["ServiceID"];
										$MECID = $rowst["MECID"];
										$NewStore = $rowst["StoreID"];
										$Commission = $rowst["Commission"];
										if($Commission==2)
										{
											$ServiceCost=$ServiceCost1/2;
											echo $ServiceCost."<br>";
										}
										else
										{
											$ServiceCost=$ServiceCost1;
										}
										// echo $MECID." has done Service(".$ServiceID.") of Rs.".$ServiceCost." on Store ".$NewStore."<br>";
										
									}
								}
					
							}
						}	
				}
			}
echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();

$DB = Connect();
$date=date('Y-m-d');
$Year=date('Y');
$Month = date('m');		
$First= date('Y-m-01');	
$MonthSpell = getMonthSpelling($Month);
$d=cal_days_in_month(CAL_GREGORIAN,$Month,$Year);

// $sql = "select EID, EmployeeName, EmployeeEmailID, EmpPercentage, EmployeeMobileNo from tblEmployees where Status='0' and StoreID='2'";
$sql = "select tblEmployees.EID, tblEmployees.EmployeeName, tblEmployees.EmployeeEmailID, tblEmployees.EmpPercentage, tblEmployees.EmployeeMobileNo , tblEmployeeTarget.BaseTarget from tblEmployees
left Join tblEmployeeTarget on tblEmployeeTarget.EmployeeCode=tblEmployees.EmployeeCode  
where tblEmployees.Status='0' and tblEmployees.StoreID='4' and tblEmployeeTarget.TargetForMonth='$MonthSpell' and tblEmployeeTarget.Year='$Year'";
// echo $sql."<br>";

$RS = $DB->query($sql);
if($RS->num_rows > 0) 
{
	while($row = $RS->fetch_assoc())
	{
		$strEID = $row["EID"];
		$strEmployeeName = $row["EmployeeName"];
		// $strEmployeeEmailID = $row["EmployeeEmailID"];
		$strEmpPercentage = $row["EmpPercentage"];
		$strEmpBaseTarget = $row["BaseTarget"];
		// $strEmployeeMobileNo = $row["EmployeeMobileNo"];
		// echo $strEmployeeName."<br>";
		
		$PerDayTarget=$strEmpBaseTarget/$d;
			// die()
			$sqldetails = "SELECT tblAppointmentAssignEmployee.AppointmentID,
			tblAppointmentAssignEmployee.ServiceID, 
			SUM(tblAppointmentsDetailsInvoice.ServiceAmount)as ServiceAmount, 
			tblAppointmentAssignEmployee.Commission, 
			tblInvoiceDetails.OfferDiscountDateTime,tblEmployees.StoreID 
			FROM tblEmployees 
			left join tblAppointmentAssignEmployee 
			on tblEmployees.EID = tblAppointmentAssignEmployee.MECID 
			left join tblAppointmentsDetailsInvoice 
			on tblAppointmentsDetailsInvoice.AppointmentId= tblAppointmentAssignEmployee.AppointmentID
			left join tblInvoiceDetails 
			on tblAppointmentAssignEmployee.AppointmentID=tblInvoiceDetails.AppointmentId
			where tblEmployees.StoreID = '2' and tblEmployees.EID='$strEID' and tblAppointmentAssignEmployee.AppointmentID!='NULL' and tblInvoiceDetails.OfferDiscountDateTime!='NULL' and Date(tblInvoiceDetails.OfferDiscountDateTime)='16-11-02'";
						// echo $sqldetails."<br><br>";
						$RSdetails = $DB->query($sqldetails);
						
			if($RSdetails->num_rows > 0) 
			{
				$counter = 0;
				$ComFinal = "";
				$strSID = "";
				$strSAmount = "";
				$strCommission = "";
				while($rowdetails = $RSdetails->fetch_assoc())
				{
					$counter ++;
					$strEIDa = $rowdetails["EID"];
					$strAID = $rowdetails["AppointmentID"];
					$strSID = $rowdetails["ServiceID"];
					$sep=select("ServiceName","tblServices","ServiceID='".$strSID."'");
					$servicename=$sep[0]['ServiceName'];
					$strSAmount = $rowdetails["ServiceAmount"];
					$strCommission = $rowdetails["Commission"];
					$StoreIDd = $rowdetails["StoreID"];
					$stpp=select("StoreName","tblStores","StoreID='".$StoreIDd."'");
					$StoreName=$stpp[0]['StoreName'];
						$sqldiscount ="select OfferAmount, MemberShipAmount from tblAppointmentMembershipDiscount where AppointmentID='$strAID' and ServiceID='$strSID'";
						//echo $sqldiscount;
					
						$RSdiscount = $DB->query($sqldiscount);
						if($RSdiscount->num_rows > 0) 
						{
							while($rowdiscount = $RSdiscount->fetch_assoc())
							{
								$strOfferAmount = $rowdiscount["OfferAmount"];
								$strDiscountAmount = $rowdiscount["MemberShipAmount"];
		
								
								if($strOfferAmount=="0")
								{
									$FinalDAmount = $strDiscountAmount;
								}
								elseif($strDiscountAmount=="0")
								{
									$FinalDAmount = $strOfferAmount;
								}
							}
						}
						else
						{
							$FinalDAmount = "0";
						}
						
						$Sale1 = $strSAmount - $FinalDAmount;
						$Sale+=$Sale1;
						//Calculation
						$CommssionFinal = "";
						
						if($strCommission=="1")
						{
							$CommssionFinal = ($Sale / 100) * $strEmpPercentage;
						}
						elseif($strCommission=="2")
						{
							
							$CommssionFinal = ($Sale / 200) * $strEmpPercentage;
						}
						$ComFinal += $CommssionFinal;
					
						// $Sale=$Sale+$Sale;
						// echo $strEmployeeName."<br>" ;
						// echo $Sale1."<br>";
						// echo $PerDayTarget."<br>";
					
					
					
				}
			}
	}
}
// echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
$DB = Connect();
$date=date('Y-m-d');
$Year=date('Y');
$Month = date('m');		
$First= date('Y-m-01');	
$MonthSpell = getMonthSpelling($Month);
$d=cal_days_in_month(CAL_GREGORIAN,$Month,$Year);

// $sql = "select EID, EmployeeName, EmployeeEmailID, EmpPercentage, EmployeeMobileNo from tblEmployees where Status='0' and StoreID='2'";
$sql = "Select * from tblCategories where Status=0 and MainCategoryType=0";

$RS = $DB->query($sql);
if($RS->num_rows > 0) 
{
	while($row = $RS->fetch_assoc())
	{
		$CategoryID = $row["CategoryID"];
		$CategoryName = $row["CategoryName"];	
		// echo $CategoryName."<br>";
		
		$SelectServiceCatWise="Select Distinct(ServiceID) from tblProductsServices where CategoryID='$CategoryID' and Status='0'";
		// echo $SelectServiceCatWise."<br>";
		$RSSSCW = $DB->query($SelectServiceCatWise);
		if($RSSSCW->num_rows > 0) 
		{
			while($rowSSSCW = $RSSSCW->fetch_assoc())
			{
				$ServiceID = $rowSSSCW["ServiceID"];
				$cats = explode(",", $rowSSSD['ServiceID']);
				// echo $ServiceID."<br>";
				
				
			}
		}
	}
}	
$SelectServicesDone="Select ServiceName, ServiceAmt from tblInvoiceDetails";
				$RSSSD = $DB->query($SelectServicesDone);
				
				if($RSSSD->num_rows > 0) 
				{
					while($rowSSSD = $RSSSD->fetch_assoc())
					{
						// $ServiceName[]=$rowSSSD["ServiceName"];
						$cats = explode(",", $rowSSSD['ServiceName']);
							
						foreach($cats as $Serv)
						{
							// echo $Serv."<br>";
							$SelectCat="Select CategoryID from tblProductsServices where ServiceID='$Serv' and Status='0'";
							// echo $SelectCat."<br>";
							
						}
						// echo "<br>";
						// $Amt = explode(",", $rowSSSD['ServiceAmt']);
						// print_r($cats);	
						// foreach($Amt as $Amount)
						// {
							// echo $Serv."<br>";
						// }
						// $merge=array_merge($cats,$Amt);
						// print_r($merge);
						// foreach($merge as $final)
						// {
							// echo $final."<br>";
						// }
						
						
						
						
						
					}
				}
				echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
$DB = Connect();
$sql = "SELECT * from tblCategories where Status='0'";
// echo $sql."<br>";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strCategoryID = $row["CategoryID"];
		$strCategoryName = $row["CategoryName"];
		
		// echo $strCategoryName."<br>";
			$sqlservice = "SELECT tblProductsServices.CategoryID, tblProductsServices.ServiceID , tblServices.ServiceName, tblServices.ServiceCost, tblServices.ServiceCode,tblProductsServices.StoreID,tblAppointmentsDetailsInvoice.qty, tblAppointmentsDetailsInvoice.ServiceAmount, tblInvoiceDetails.OfferDiscountDateTime
					FROM `tblProductsServices` left join tblServices 
					on tblProductsServices.ServiceID=tblServices.ServiceID  left join tblAppointmentsDetailsInvoice
					on tblAppointmentsDetailsInvoice.ServiceID=tblProductsServices.ServiceID left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblInvoiceDetails 
					on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId
					where tblProductsServices.CategoryID='$strCategoryID' and tblServices.ServiceID!='' and tblServices.ServiceID!='null' and tblServices.ServiceID!='NULL' and tblAppointments.IsDeleted!='1' and tblAppointments.AppointmentDate>='2016-11-01' and tblAppointments.AppointmentDate<='2016-11-04'  group by tblProductsServices.ServiceID order by tblServices.ServiceCost desc";
					
					// echo $sqlservice."<br>";
					
					
					
					$RSservice = $DB->query($sqlservice);
						if ($RSservice->num_rows > 0) 
						{
							$counterservice = 0;

							while($rowservice = $RSservice->fetch_assoc())
							{		
								$strqty = "";
								$strServiceAmount = "";	
								$strOfferAmount = "";
								$strMembershipAmount = "";
								$strServiceNet2 = "";
								$strServiceNet = "";
								
								$product_cost ="";
								$counterservice ++;
								$strCategoryID = $rowservice["CategoryID"];
								$strServiceIDt = $rowservice["ServiceID"];
							
								$strServiceName = $rowservice["ServiceName"];
								$strServiceCost = $rowservice["ServiceCost"];
								$strServiceCode = $rowservice["ServiceCode"];
								
							
								$StoreID = $rowservice["StoreID"];
								$stpp=select("StoreName","tblStores","StoreID='".$StoreID."'");
								$StoreName=$stpp[0]['StoreName'];
								$strqty += $rowservice["qty"];
								
								// echo $strServiceIDt."<br>";
								// echo $strServiceCost."<br>";
							
							}
						}
	}
}

// echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();

$DB=Connect();
$First= date('Y-m-01');
$Last= date('Y-m-t');
											// $getTodaysDate = date("Y-m-d");
											// $strSTID=1;
											// $getTodaysDate ="16-11-07";
											// $sqltotal="SELECT  SUM(tblInvoiceDetails.TotalPayment)as Sales , SUM(tblInvoiceDetails.CashAmount)as CashTotal, SUM(tblInvoiceDetails.CardAmount)as CardTotal, tblAppointments.StoreID
														// from tblInvoiceDetails 
														// left join tblAppointments 
														// on tblInvoiceDetails.AppointmentID=tblAppointments.AppointmentID
														// where Date(tblInvoiceDetails.OfferDiscountDateTime)=Date('$getTodaysDate') and tblAppointments.StoreID ='$strSTID'";
											// echo $sqltotal."<br>";											
											$RSTotal = $DB->query($sqltotal);
											if ($RSTotal->num_rows > 0) 
											{
												while($rowstotal = $RSTotal->fetch_assoc())
												{
													$strtotal = $rowstotal["Sales"];
													$strCashTotal = $rowstotal["CashTotal"];
													$strCardTotal = $rowstotal["CardTotal"];
												
													$tax1=$strtotal*15/100;
													
													$Cashtax1=$strCashTotal*15/100;
													
													$Cardtax1=$strCardTotal*15/100;
													
													
													echo $Totaltax1=$strtotal-$tax;
													echo "<br>";
													echo $TotalCash1=$strCashTotal-$tax1;
													echo "<br>";
													echo $TotalCard1=$strCardTotal-$Cardtax1;
													echo $strCardTotal."<br>";
													echo "<br>";
													$tax=round($tax1);
													$Totaltax=round($Totaltax1);
													
													$Cashtax=round($Cashtax1);
													$TotalCash=round($TotalCash1);
													
													$Cardtax=round($Cardtax1);
													$TotalCard=round($TotalCard1);
												}
											}
											else
											{
												$strtotal = "0";
											}
											// $Pamt="Select SUM(tblPendingPayments.PendingAmount)as PendingAmt,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$strSTID' and tblPendingPayments.PendingStatus=2 and tblAppointments.AppointmentDate='$getTodaysDate'";
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
											// $MT="Select TargetAmount from tblStoreSalesTarget where Year='$yr' and Month= '$Month' and StoreID='$strSTID' ";
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
											// $MAC="SELECT Count(tblAppointmentMembershipDiscount.MembershipID) as MCount, SUM(tblAppointmentMembershipDiscount.MembershipAmount) as MAmount from tblAppointmentMembershipDiscount Left Join tblAppointments ON tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID where tblAppointments.AppointmentDate='$getTodaysDate' and tblAppointments.StoreID='$strSTID'";
											// echo $MAC."<br>";
											$RSMT = $DB->query($MAC);
											if ($RSMT->num_rows > 0) 
											{
												while($rowMT = $RSMT->fetch_assoc())
												{
													$MCount = $rowMT["MCount"];
													$MAmount = $rowMT["MAmount"];
													if($MCount=="")
													{
														$MCount='0';
													}
													// echo $MCount."<br>";
													if($MAmount=="")
													{
														$MAmount='0';
													}
													
													// echo $MAmount."<br>";
												}
											}
											// $PendingRec="Select (SELECT count(0) FROM tblAppointments where Status=2 and IsDeleted!='1' and ApproveStatus!='1' and AppointmentDate='$getTodaysDate' and StoreID='$strSTID') as ApprovalPendingCount";
											// echo $PendingRec."<br>";
											$RSPR = $DB->query($PendingRec);
											if ($RSPR->num_rows > 0) 
											{
												while($rowPC = $RSPR->fetch_assoc())
												{
													$ApprovalPendingCount = $rowPC["ApprovalPendingCount"];
												}
											}
											// $StoreName="Select StoreName from tblStores where StoreID='$strSTID'";
											$RSSN = $DB->query($StoreName);
											if ($RSSN->num_rows > 0) 
											{
												while($rowSN = $RSSN->fetch_assoc())
												{
													$StoreName = $rowSN["StoreName"];
												}
											}
											// $SelectTax="SELECT SUM( tblAppointmentsChargesInvoice.ChargeAmount ) AS ChargeAmount
														// FROM  `tblAppointmentsChargesInvoice` 
														// LEFT JOIN tblAppointments ON tblAppointmentsChargesInvoice.AppointmentID = tblAppointments.AppointmentID
														// WHERE tblAppointments.AppointmentDate = '$getTodaysDate'
														// AND tblAppointments.StoreID =  '$strSTID'";
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
											// $SelectServicesDone="Select tblInvoiceDetails.ServiceName from tblInvoiceDetails left Join tblAppointments ON  tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.AppointmentDate='$getTodaysDate' and tblAppointments.StoreID='$strSTID'";
											// echo "<br>";
											// echo $SelectServicesDone."<br>";
											
												// $RSDS = $DB->query($SelectServicesDone);
												
												// if($RSDS->num_rows > 0) 
												// {
													// while($rowSSDS = $RSDS->fetch_assoc())
													// {
														
														// $ServiceName[] = $rowSSDS['ServiceName'];
														// $cnt=0;
														// foreach ($ServiceName as $Services)
														// {
															// $cnt++;
															// $data_elements = implode(',',$Services); // extract all the comma seperated value in array
															// print_r($data_elements);
															// echo count($cnt)+$cnt."<br>";
															// $final= count($cnt)+$cnt;
														// }
													// }	
																											
												// }		
										// echo $final;
											// $sqlst="SELECT  tblInvoiceDetails.SubTotal
											// from tblInvoiceDetails 
											// left join tblAppointments 
											// on tblInvoiceDetails.AppointmentID=tblAppointments.AppointmentID
											// where Date(tblInvoiceDetails.OfferDiscountDateTime)=Date('$getTodaysDate') and tblAppointments.StoreID ='$strSTID'";
											// echo $sqlst."<br>";
											
											$RSst = $DB->query($sqlst);
											if ($RSst->num_rows > 0) 
											{
												$counter = 0;

												while($rowst = $RSst->fetch_assoc())
												{
													$counter ++;
													$SubTotal = $rowst["SubTotal"];
													$FinalSubAmt=substr($SubTotal, 0, -3);
													$str = str_replace(',','',$FinalSubAmt);
													$pqr +=$str;
													
												}
											}
											// echo $pqr;
											$dtt=date('d/m/y');
											// echo $dtt."<br>";
											$strStoreName1 = substr($StoreName, 0, 3);
											$myStoreName=strtoupper($strStoreName1);
											$Content= $myStoreName." Day closing dt ".$dtt." with (SS)".$final.
											", (ST)".$ChargeAmount.
											", (D)".$strtotal.
											", (MT)".$strtotalMonth.
											", (PA)".$PendingAmt.
											", CC".$TotalCard.
											", Cash".$TotalCash.
											", (MSC)".$MCount.
											", (MA)".$MAmount.
											", (PRI)".$ApprovalPendingCount."";
											// echo $Content."<br>";
										// echo $i."<br>";
											// $my='9867510596';
											// $SendSMS = CreateSMSURL("Nailspa Day Closing","0","0",$Content,$my);	
											// $my1='9967716324';	
											// $SendSMS = CreateSMSURL("Nailspa Day Closing","0","0",$Content,$my1);// 
											// $my1='9867678628';	
											// $SendSMS = CreateSMSURL("Nailspa Day Closing","0","0",$Content,$my1);				

// echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');
$DB=Connect();
// echo $SelectStore."<br><br>";
		$RSCF = $DB->query($SelectStore);
			if ($RSCF->num_rows > 0) 
			{
				while($rowS = $RSCF->fetch_assoc())
				{
					$StoreID = $rowS["StoreID"];
					$StoreName = $rowS["StoreName"];
					
					// $sqlst ="SELECT Sum(tblInvoiceDetails.SubTotal) as Sales, (select StoreName from tblStores where StoreID=tblAppointments.StoreID) as StoreName
					// FROM tblInvoiceDetails
					// left join tblAppointments 
					// on tblInvoiceDetails.AppointmentId = tblAppointments.AppointmentID
					// where tblAppointments.StoreID!='NULL' group by tblAppointments.StoreID";
					
					$RSst = $DB->query($sqlst);
					if ($RSst->num_rows > 0) 
					{
						$counter = 0;

						while($rowst = $RSst->fetch_assoc())
						{
							$counter ++;
							$abc = $rowst["StoreName"];
							$strStoreName = substr($abc, 0, 6);
							$strSales = $rowst["Sales"];
							// echo $strSales."<br>";
						}
					}
				}
			}
// echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
$First= date('Y-m-01');
$Last= date('Y-m-t');
$date=date('Y-m-d');
$DB=Connect();
// echo $SelectStore."<br><br>";
	
						// $getTodaysDate ="16-11-07";
						// $sqlst="SELECT  tblInvoiceDetails.SubTotal
									// from tblInvoiceDetails 
									// left join tblAppointments 
									// on tblInvoiceDetails.AppointmentID=tblAppointments.AppointmentID
									// where Date(tblInvoiceDetails.OfferDiscountDateTime)=Date('$getTodaysDate') and tblAppointments.StoreID ='2'";
					// echo $sqlst."<br>";
					
					$RSst = $DB->query($sqlst);
					if ($RSst->num_rows > 0) 
					{
						$counter = 0;

						while($rowst = $RSst->fetch_assoc())
						{
							$counter ++;
							$SubTotal = $rowst["SubTotal"];
							$FinalSubAmt=substr($SubTotal, 0, -3);
							$str = str_replace(',','',$FinalSubAmt);
							$pqr +=$str;
						}
					}
	// echo $pqr."<br>";
// echo "---------------------------------------------------------------------------------------------------------------<br><br><br>";
$DB->close();
?>
<?php
$DB=Connect();
											// $First= date('Y-m-01');
											// $Last= date('Y-m-t');
											// $getTodaysDate = date("Y-m-d");
											// $getTodaysDate ="16-11-06";
											// $strStoreID='2';
											// $sqltotal="Select Sum(tblInvoiceDetails.TotalPayment) as Total, SUM(tblInvoiceDetails.CashAmount)as CashTotal,SUM(tblInvoiceDetails.CardAmount)as CardTotal, tblAppointments.StoreID
														// from tblInvoiceDetails 
														// left join tblAppointments 
														// on tblInvoiceDetails.AppointmentID=tblAppointments.AppointmentID
														// where Date(tblInvoiceDetails.OfferDiscountDateTime)=Date('$getTodaysDate') and tblAppointments.StoreID ='$strStoreID'";
											// echo $sqltotal."<br>";
											
											// $sqltotal="SELECT SUM(tblInvoiceDetails.RoundTotal)as Total,
// SUM(tblInvoiceDetails.CashAmount) as CashTotal,SUM(tblInvoiceDetails.CardAmount) as CardTotal,SUM(tblInvoiceDetails.Membership_Amount) as Membership_Amount,Count(tblInvoiceDetails.GVPurchasedID) as GVPurchasedID from tblInvoiceDetails left join tblAppointments on tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.StoreID='$strStoreID' and tblAppointments.Status='2' and Date(tblInvoiceDetails.OfferDiscountDateTime)=Date('$getTodaysDate') ";
											// echo $sqltotal;
											
											// $RSTotal = $DB->query($sqltotal);
											// if ($RSTotal->num_rows > 0) 
											// {
												// echo "In if<br>";
												// while($rowstotal = $RSTotal->fetch_assoc())
												// {
													// echo "In while<br>";
													// $strtotal = $rowstotal["Total"];
													// $strCashTotal = $rowstotal["CashTotal"];
													// $strCardTotal = $rowstotal["CardTotal"];
													// $strGVPurchased = $rowstotal["GVPurchasedID"];
													// $strMembershipAmount = $rowstotal["Membership_Amount"];
													// echo $strtotal."<br>";
												// }
											// }
											// else
											// {
												// $strtotal = "0";
											// }
											// $Pamt="Select SUM(tblPendingPayments.PendingAmount)as PendingAmt,  tblAppointments.StoreID from tblPendingPayments Left Join tblAppointments ON tblPendingPayments.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointments.StoreID='$strStoreID' and tblPendingPayments.PendingStatus=2 and tblAppointments.AppointmentDate='$getTodaysDate'";
											// echo $Pamt."<br>";
											// $RSpamt = $DB->query($Pamt);
											// if ($RSpamt->num_rows > 0) 
											// {
												// while($rowa = $RSpamt->fetch_assoc())
												// {
													// $PendingAmt = $rowa["PendingAmt"];
													// if($PendingAmt=="")
													// {
														// $PendingAmt='0';
													// }
													// echo $PendingAmt."<br>";
												// }
											// }
											// $yr= date('Y');
											// $CurrentMonth = date('m');			//$row["Month"];
											// $Month = getMonthSpelling($CurrentMonth);
											// $CurrMonth=date('m');
											// $number = cal_days_in_month(CAL_GREGORIAN, $CurrMonth, $yr);
											// echo $number."<br>";
											// $MT="Select TargetAmount from tblStoreSalesTarget where Year='$yr' and Month= '$Month' and StoreID='$strStoreID' ";
											// echo $MT."<br>";
											// $RSMT = $DB->query($MT);
											// if ($RSMT->num_rows > 0) 
											// {
												// while($rowMT = $RSMT->fetch_assoc())
												// {
													// $TargetAmount = $rowMT["TargetAmount"];
													// $TodaysTarget= $TargetAmount/$number;
												// }
											// }
											// if($TodaysTarget>$strtotal)
											// {
												// $TargetShort=$TodaysTarget-$strtotal;
												// $FinalTarget=round($TargetShort);
											// }
											// else
											// {
												// $TargetShort="Target Achieved.";
											// }
											// $MAC="SELECT Count(tblAppointmentMembershipDiscount.MembershipID) as MCount, SUM(tblAppointmentMembershipDiscount.MembershipAmount) as MAmount from tblAppointmentMembershipDiscount Left Join tblAppointments ON tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID where tblAppointments.AppointmentDate='$getTodaysDate' and tblAppointments.StoreID='$strStoreID'";
											
											// echo $MAC."<br>";
											// $RSMT = $DB->query($MAC);
											// if ($RSMT->num_rows > 0) 
											// {
												// while($rowMT = $RSMT->fetch_assoc())
												// {
													// $MCount = $rowMT["MCount"];
													// $MAmount = $rowMT["MAmount"];
													// if($MCount=="")
													// {
														// $MCount='0';
													// }
													// echo $MCount."<br>";
													// if($MAmount=="")
													// {
														// $MAmount='0';
													// }
												// }
											// }
											
											
											// $PendingRec="Select (SELECT count(0) FROM tblAppointments where Status=2 and IsDeleted!='1' and ApproveStatus!='1' and AppointmentDate='$getTodaysDate' and StoreID='$strStoreID') as ApprovalPendingCount";
											// echo $PendingRec."<br>";
											// $RSPR = $DB->query($PendingRec);
											// if ($RSPR->num_rows > 0) 
											// {
												// while($rowPC = $RSPR->fetch_assoc())
												// {
													// $ApprovalPendingCount = $rowPC["ApprovalPendingCount"];
												// }
											// }
											// $StoreName="Select StoreName from tblStores where StoreID='$strStoreID'";
											// $RSSN = $DB->query($StoreName);
											// if ($RSSN->num_rows > 0) 
											// {
												// while($rowSN = $RSSN->fetch_assoc())
												// {
													// $StoreName = $rowSN["StoreName"];
												// }
											// }
											// $SelectTax="SELECT SUM( tblAppointmentsChargesInvoice.ChargeAmount ) AS ChargeAmount
														// FROM  `tblAppointmentsChargesInvoice` 
														// LEFT JOIN tblAppointments ON tblAppointmentsChargesInvoice.AppointmentID = tblAppointments.AppointmentID
														// WHERE tblAppointments.AppointmentDate = '$getTodaysDate'
														// AND tblAppointments.StoreID =  '$strStoreID'";
											// echo $SelectTax."<br>";
											// $RSSTAX = $DB->query($SelectTax);
											// if ($RSSTAX->num_rows > 0) 
											// {
												// while($rowTX = $RSSTAX->fetch_assoc())
												// {
													// $ChargeAmount = $rowTX["ChargeAmount"];
													// echo $ChargeAmount."<br>";
												// }
											// }			
											// $SelectServicesDone="Select tblInvoiceDetails.ServiceName from tblInvoiceDetails left Join tblAppointments ON  tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.AppointmentDate='$getTodaysDate' and tblAppointments.StoreID='$strStoreID'";
											// echo "<br>";
											// echo $SelectServicesDone."<br>";
											
												// $RSDS = $DB->query($SelectServicesDone);
												
												// if($RSDS->num_rows > 0) 
												// {
													// echo "In if <br>";
													// while($rowSSDS = $RSDS->fetch_assoc())
													// {
														// echo "In while <br>";
														// $ServiceName[] = $rowSSDS['ServiceName'];
														// $cnt=0;
														// foreach ($ServiceName as $Services)
														// {
															// $cnt++;
															// $data_elements = implode(',',$Services); // extract all the comma seperated value in array
															// print_r($data_elements);
															// echo count($cnt)+$cnt."<br>";
															// $final= count($cnt)+$cnt;
														// }
													// }	
																											
												// }	

											// echo $final."<br>";
											// $sqltotalMonth="select Sum(tblInvoiceDetails.TotalPayment) as Total, SUM(tblInvoiceDetails.CashAmount)as CashTotal,SUM(tblInvoiceDetails.CardAmount)as CardTotal, tblAppointments.StoreID
														// from tblInvoiceDetails 
														// left join tblAppointments 
														// on tblInvoiceDetails.AppointmentID=tblAppointments.AppointmentID
														// where Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('$First') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('$Last') and tblAppointments.StoreID ='$strStoreID'";
											// echo $sqltotalMonth."<br>";
											
											// $RSTotalMonth = $DB->query($sqltotalMonth);
											// if ($RSTotalMonth->num_rows > 0) 
											// {
												// while($rowstotalMonth = $RSTotalMonth->fetch_assoc())
												// {
													// $strtotalMonth = $rowstotalMonth["Total"];
													// $strCashTotalMonth = $rowstotalMonth["CashTotal"];
													// $strCardTotalMonth = $rowstotalMonth["CardTotal"];
													// echo $strtotal."<br>";
												// }
											// }
											// else
											// {
												// $strtotalMonth = "0";
											// }
											// $dtt=date('d/m/y');
											// echo $strCashTotal;
											// if($strCashTotal>$ChargeAmount)
											// {
												// $CashFinal=$strCashTotal-$ChargeAmount;
												// echo "In if<br>";
												// echo $strCashTotal."<br>";
												// echo $CashFinal."<br>";
													// echo $ChargeAmount."<br>";
												// echo $CashFinal."<br>";
											// }
											// else
											// {
												// $CashFinal=$strCardTotal-$ChargeAmount;
												// echo "In else<br>";
												// echo $strCashTotal."<br>";
												// echo $CashFinal."<br>";
													// echo $ChargeAmount."<br>";
											// }
											
										
											// echo "<br>";
											// $strStoreName1 = substr($StoreName, 0, 3);
											// $myStoreName=strtoupper($strStoreName1);
											// $Content= $myStoreName." dt ".$dtt." with (SS)".$final.
											// ", (GV)".$strGVPurchased.
											// ", (ST)".$ChargeAmount.
											// ", (D)".$strtotal.
											// ", (MT)".$strtotalMonth.
											// ", (PA)".$PendingAmt.
											// ", CC".$strCardTotal.
											// ", Cash".$CashFinal.
											// ", (MSC)".$MCount.
											// ", (MA)".$MAmount.
											// ", (PRI)".$ApprovalPendingCount."";
											// echo $Content."<br>";
echo "-------------------------------------------------------------------------------------------------------------------------------------------<br>";
$DB->Close();

$DB=Connect();
											$First= date('Y-m-01');
											$Last= date('Y-m-t');
											// $getTodaysDate = date("Y-m-d");
											$getTodaysDate ="16-11-24";
											$strStoreID='3';
											// echo $strStoreID."<br>";
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
											// echo $strtotal."<br>";
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
											// $MAC="SELECT Count(tblAppointmentMembershipDiscount.MembershipID) as MCount, SUM(tblAppointmentMembershipDiscount.MembershipAmount) as MAmount from tblAppointmentMembershipDiscount Left Join tblAppointments ON tblAppointments.AppointmentID=tblAppointmentMembershipDiscount.AppointmentID where tblAppointments.AppointmentDate='$getTodaysDate' and tblAppointments.StoreID='$strStoreID' and tblAppointmentMembershipDiscount.MembershipAmount!='0' and tblAppointments.Status='2'";
											
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
											// echo $Totalmemamtfirst."<br>";
											
											// $MAC2="SELECT Count(tblInvoiceDetails.Membership_Amount)as MemberCount  from tblInvoiceDetails Left Join tblAppointments ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID where tblAppointments.AppointmentDate='$getTodaysDate' and tblAppointments.StoreID='$strStoreID' and tblAppointments.Status='2' AND tblInvoiceDetails.Membership_Amount!='0'";
											// echo $strtotal."<br>";
											// echo $MAC2."<br>";
											
											$MAC2="SELECT Count(tblInvoiceDetails.Membership_Amount) as MemberCount from tblInvoiceDetails Left Join tblAppointments ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID where tblAppointments.AppointmentDate='$getTodaysDate' and tblAppointments.StoreID='$strStoreID' and tblAppointments.Status='2' AND tblInvoiceDetails.Membership_Amount!=''";
											
											
											$RSMTC = $DB->query($MAC2);
											if ($RSMTC->num_rows > 0) 
											{
												while($rowMTC = $RSMTC->fetch_assoc())
												{
													
													$Membership_Count = $rowMTC["MemberCount"];
													
												}
											}
												// echo "Membership Count is".$Membership_Count."<br>";
											// echo $Totalmemamtfirst."<br>";
											// tblInvoiceDetails.Membership_Amount
											// $RSMT = $DB->query($MAC);
											// if ($RSMT->num_rows > 0) 
											// {
												// while($rowMT = $RSMT->fetch_assoc())
												// {
													// $MCount = $rowMT["MCount"];
													// $MAmount = $rowMT["MAmount"];
													// if($MCount=="")
													// {
														// $MCount='0';
													// }
													// echo $MCount."<br>";
													// if($MAmount=="")
													// {
														// $MAmount='0';
													// }
												// }
											// }
											// echo $MCount."<br>";
											
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
// echo $strtotal."<br>";											
											// $SelectServicesDone="Select tblInvoiceDetails.ServiceName from tblInvoiceDetails left Join tblAppointments ON  tblInvoiceDetails.AppointmentId=tblAppointments.AppointmentID where tblAppointments.AppointmentDate='$getTodaysDate' and tblAppointments.StoreID='$strStoreID'";
											// echo "<br>";
											// echo $SelectServicesDone."<br>";
											
												// $RSDS = $DB->query($SelectServicesDone);
												
												// if($RSDS->num_rows > 0) 
												// {
													// while($rowSSDS = $RSDS->fetch_assoc())
													// {
														
														// $ServiceName[] = $rowSSDS['ServiceName'];
														// $cnt=0;
														// foreach ($ServiceName as $Services)
														// {
															// $cnt++;
															// $data_elements = implode(',',$Services); // extract all the comma seperated value in array
															// print_r($data_elements);
															// echo count($cnt)+$cnt."<br>";
															// $final= count($cnt)+$cnt;
														// }
													// }	
																											
												// }	

												// echo $strtotal."<br>";
												// echo $final."<br>";
											$sqltotalMonth="select Sum(tblInvoiceDetails.TotalPayment) as Total, SUM(tblInvoiceDetails.CashAmount)as CashTotal,SUM(tblInvoiceDetails.CardAmount)as CardTotal, tblAppointments.StoreID
														from tblInvoiceDetails 
														left join tblAppointments 
														on tblInvoiceDetails.AppointmentID=tblAppointments.AppointmentID
														where Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('$First') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('$Last') and tblAppointments.StoreID ='$strStoreID'";
											// echo $sqltotalMonth."<br>";
											// echo $strtotal."<br>";
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
										
											// $CashFinal=$strCardTotal-$ChargeAmount;
												// echo "In else<br>";
												// echo $CashFinal."<br>";
											
											// echo $strtotal."<br>";
											
											$strStoreName1 = substr($StoreName, 0, 3);
											$myStoreName=strtoupper($strStoreName1);
											$Content= $myStoreName." dt ".$dtt." (SS)".$final.
											",<br> (GV)".$strGVPurchased.
											",<br> (MISC)".$ChargeAmount.
											",<br> (TS)".$strtotal.
											",<br> (MT)".$strtotalMonth.
											",<br> (PA)".$PendingAmt.
											",<br> CC".$strCardTotal.
											",<br> Cash".$strCashTotal.
											",<br> (MSC)".$Membership_Count.
											",<br> (MA)".$Totalmemamtfirst.
											",<br> (PRI)".$ApprovalPendingCount."";
											echo $Content."<br>";
											
											
											// $my='9867510596';
											// $SendSMS = CreateSMSURL("Nailspa","0","0",$Content,$my);	
											// $my1='9967716324';	
											// $SendSMS = CreateSMSURL("Nailspa Day Closing","0","0",$Content,$my1);	
											// $my3='9867678628';												
											// $SendSMS = CreateSMSURL("Nailspa Day Closing","0","0",$Content,$my3);

											

?>