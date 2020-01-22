<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?php

    date_default_timezone_set('Asia/Kolkata');
    $strPageTitle = "Manage Customers | Nailspa";
	$strDisplayTitle = "Manage Customers for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblServices";
	$strMyTableID = "ServiceID";
	//$strMyField = "CustomerMobileNo";
	$strMyActionPage = "appointment_invoice.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
			
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
	
	
if ($_SERVER["REQUEST_METHOD"] == "POST")
{		
$DB = Connect();
$type=$_POST['type'];
$date=date('Y-m-d h:i:s');
$appointment_id=$_POST['appointment_idd'];
$billaddress=$_POST['billaddress'];
$invoiceid=$_POST['invoiceid'];
$CustomerFullName=$_POST['CustomerFullName'];
$email=$_POST['email'];
$mobile=$_POST['mobile'];
$servicecode=$_POST['servicecode'];
$serviceid=$_POST['serviceid'];
$qty=$_POST['qty'];
$serviceamt=$_POST['serviceamt'];
$membershipname=$_POST['membershipname'];
$Discount=$_POST['Discount'];
$disamt=$_POST['disamt'];
$sub_total=$_POST['sub_total'];
$offeramt=$_POST['offeramt'];
$chargename=$_POST['chargename'];
$chargeamount=$_POST['chargeamount'];
$total=$_POST['total'];
$roundtotal=$_POST['roundtotal'];
$cashamt=$_POST['cashamt'];
$totalpayment=$_POST['totalpayment'];
$servicecode1=implode(",",$servicecode);
$serviceid1=implode(",",$serviceid);
$qty1=implode(",",$qty);
$serviceamt1=implode(",",$serviceamt);
$membershipname1=implode(",",$membershipname);
$Discount1=implode(",",$Discount);
$chargename1=implode(",",$chargename);
$chargeamount1=implode(",",$chargeamount);
$disamt1=implode(",",$disamt);
$cardboth=$_POST['cardboth'];
$cashboth=$_POST['cashboth'];
$pendamt=$_POST['pendamt'];
$paidamt=$_POST['completeamt'];
$membercost=$_POST['membercost'];
$serviceidm=$_POST['serviceidm'];
$discountm=$_POST['discountm'];
$memid=$_POST['memid'];
$serviceido=$_POST['serviceido'];
$offeramt=$_POST['offeramttt'];
$offerid=$_POST['offerid'];
$offeramtt=$_POST['offeramt'];
$totalpend=$_POST['totalpend'];
$purchaseid=$_POST['purchaseid'];
$Redemptid=$_POST['Redemptid'];
$date=date('Y-m-d H:i:s');
$PackageID=$_POST['PackageID'];
$packagee=implode(",",$PackageID);
$totalredamt=$_POST['totalredamt'];
$timestamp =  date("H:i:s", time());
$seldata=select("count(*)","tblInvoiceDetails","AppointmentId='".$appointment_id."'");
$app_id=$seldata[0]['count(*)'];
$seldatap=select("*","tblInvoiceDetails","AppointmentId='".$appointment_id."'");
$flagtype=$seldatap[0]['Flag'];
$PackageIDFlag=$seldatap[0]['PackageIDFlag'];
$seldatapamt=select("*","tblGiftVouchers","GiftVoucherID='".$Redemptid."'");
$gftamt=$seldatapamt[0]['Amount'];

////////////////////////////////////////////////////////////////////////
                $seldata = select("CustomerID,StoreID,AppointmentDate","tblAppointments","AppointmentID='".$appointment_id."'");
				$customer=$seldata[0]['CustomerID'];
			 if($type!='')
			 {
				
				
				 if($membercost!='0')
					{
					$sqlUpdate3 = "UPDATE tblCustomerMemberShip SET Status='1' WHERE CustomerID='".$customer."'";
					//ExecuteNQ($sqlUpdate3);
						if ($DB->query($sqlUpdate3) === TRUE) 
										{
											// echo "Record Update successfully.";
										}
										else
										{
											echo "Error2";
										}
					}
				/* $seldata = select("CustomerID,StoreID,AppointmentDate","tblAppointments","AppointmentID='".$appointment_id."'");
				$customer=$seldata[0]['CustomerID'];
				$stores=$seldata[0]['StoreID'];
					if($stores=='4')
					{
						echo $membercost;
						 if($membercost!='0')
					    {
						$sqlUpdate3 = "UPDATE tblCustomerMemberShip SET Status='1' WHERE CustomerID='".$cust."'";
					   // ExecuteNQ($sqlUpdate3);
						echo $sqlUpdate3;
						if ($DB->query($sqlUpdate3) === TRUE) 
										{
											// echo "Record Update successfully.";
										}
										else
										{
											echo "Error2";
										}
						}
						
					}
	 *//////////////////////////////////////////////////////UpdateStock/////////////////////////////////////////////////////////////////////				
				$passingID1 = $appointment_id;
				$str = "Hello";
			
				$sqlUpdate1 = "UPDATE tblAppointments SET AppointmentCheckOutTime = '".$timestamp."', Status = '2' WHERE AppointmentID='".$appointment_id."'";
				$passingID = EncodeQ(DecodeQ($passingID1));
				ExecuteNQ($sqlUpdate1);
				
				$seldata = select("CustomerID,StoreID,AppointmentDate","tblAppointments","AppointmentID='".$appointment_id."'");
				$customer=$seldata[0]['CustomerID'];
				$stores=$seldata[0]['StoreID'];
				$appoint_date=$seldata[0]['AppointmentDate']; 
				
				$sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
				
				ExecuteNQ($sqlUpdate2);
				
				$seldatat = select("*","tblAppointmentsDetailsInvoice","AppointmentID='".$appointment_id."'");
				foreach($seldatat as $valp)
				{
					//print_r($valp);
					$servicee=$valp['ServiceID'];
					$qty=$valp['qty'];
						$seldataty = select("distinct(ProductID)","tblProductsServices","ServiceID='".$servicee."'");
					//	print_r($seldataty);
						foreach($seldataty as $valw)
						{
							$seldatatqq = select("count(ProductID)","tblNewProducts","ProductID='".$valw['ProductID']."'");
							$cnt=$seldatatqq[0]['count(ProductID)'];
							
							if($cnt=='0')
							{
								
								$seldatatqt = select("*","tblNewProductStocks","ProductStockID='".$valw['ProductID']."'");
								
								$PerQtyServe=$seldatatqt[0]['PerQtyServe'];
									
									$septq=select("*","tblStoreProduct","ProductStockID='".$valw['ProductID']."' and StoreID='".$stores."'");
									$UpdatePerQtyServe=$septq[0]['UpdatePerQtyServe'];
									$stock=$septq[0]['Stock'];
									if($UpdatePerQtyServe==$PerQtyServe)
									{
										 $newstock=$stock-1;
										 $sqlUpdate = "UPDATE  tblStoreProduct SET UpdatePerQtyServe='0',Stock='".$newstock."' WHERE ProductStockID='".$valw['ProductID']."' and StoreID='".$stores."'";
											ExecuteNQ($sqlUpdate);
											$UpdatePerQtyServe1=1;
											$newupdate=$UpdatePerQtyServe1;
										 $sqlUpdate1 = "UPDATE  tblStoreProduct SET UpdatePerQtyServe='".$newupdate."' WHERE ProductStockID='".$valw['ProductID']."'  and StoreID='".$stores."'";
										 ExecuteNQ($sqlUpdate1);
										 //echo ExecuteNQ($sqlUpdate1);
									}
									else
									{
										$newupdate=$UpdatePerQtyServe+1;
										 $sqlUpdate = "UPDATE  tblStoreProduct SET UpdatePerQtyServe='".$newupdate."' WHERE ProductStockID='".$valw['ProductID']."'  and StoreID='".$stores."'";
										 ExecuteNQ($sqlUpdate);
									}
										 
				
									
								
							}
							else
							{
									$seldatatq = select("*","tblNewProducts","ProductID='".$valw['ProductID']."'");
							
							$variation=$seldatatq[0]['HasVariation'];
							if($variation!="0")
							{
								
								$seldatatqt = select("*","tblNewProductStocks","ProductID='".$valw['ProductID']."'");
								foreach($seldatatqt as $vqq)
								{
									$PerQtyServe=$vqq['PerQtyServe'];
									
									$septq=select("*","tblStoreProduct","ProductStockID='".$vqq['ProductStockID']."' and StoreID='".$stores."'");
									$UpdatePerQtyServe=$septq[0]['UpdatePerQtyServe'];
									$stock=$septq[0]['Stock'];
									if($UpdatePerQtyServe==$PerQtyServe)
									{
										 $newstock=$stock-1;
										 $sqlUpdate = "UPDATE  tblStoreProduct SET UpdatePerQtyServe='0',Stock='".$newstock."' WHERE ProductStockID='".$vqq['ProductStockID']."' and StoreID='".$stores."'";
											ExecuteNQ($sqlUpdate);
									}
									else
									{
										$newupdate=$UpdatePerQtyServe+1;
										 $sqlUpdate = "UPDATE  tblStoreProduct SET UpdatePerQtyServe='".$newupdate."' WHERE ProductStockID='".$vqq['ProductStockID']."' and StoreID='".$stores."'";
										 ExecuteNQ($sqlUpdate);
									}
										 
				
									
								}
							}
							else
							{
								$PerQtyServe=$seldatatq[0]['PerQtyServe'];
								
								$seldatatqu = select("*","tblStoreProduct","ProductID='".$valw['ProductID']."' and StoreID='".$stores."'");
								
								foreach($seldatatqu as $sq)
								{
									$stock=$sq['Stock'];
									$UpdatePerQtyServe=$sq['UpdatePerQtyServe'];
								if($UpdatePerQtyServe==$PerQtyServe)
									{
										 $newstock=$stock-1;
										 $sqlUpdate = "UPDATE  tblStoreProduct SET UpdatePerQtyServe='0',Stock='".$newstock."' WHERE ProductID='".$sq['ProductID']."' and StoreID='".$stores."'";
											ExecuteNQ($sqlUpdate);
											$UpdatePerQtyServe1=1;
										$newupdate=$UpdatePerQtyServe1;
										 $sqlUpdate1 = "UPDATE  tblStoreProduct SET UpdatePerQtyServe='".$newupdate."' WHERE ProductID='".$sq['ProductID']."' and StoreID='".$stores."'";
										 ExecuteNQ($sqlUpdate1);
											
									}
									else
									{
										$newupdate=$UpdatePerQtyServe+1;
										 $sqlUpdate = "UPDATE  tblStoreProduct SET UpdatePerQtyServe='".$newupdate."' WHERE ProductID='".$sq['ProductID']."' and StoreID='".$stores."'";
										 ExecuteNQ($sqlUpdate);
										// echo $sqlUpdate;
									}
								}
								
							}
							}
						
						}
				}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 }
				 
		


////////////////////////////////////////////////////////////////////////

  if($app_id!="0")
	{
	  if($flagtype=='H')
	  {
		 if($type=='BOTH')
		 {
			  $sqp=select("CustomerID","tblCustomers","CustomerFullName='".$CustomerFullName."'");
			  $cust=$sqp[0]['CustomerID'];
			 if($packagee!="")
			{
				$sqlUpdate = "UPDATE tblInvoiceDetails SET Billaddress='".$billaddress."',InvoiceId='".$invoiceid."',CustomerID='".$customer."',CustomerFullName='".$CustomerFullName."',Email='".$email."',Mobile='".$mobile."',SubTotal='".$sub_total."',OfferAmt='".$offeramtt."',Total='".$total."',RoundTotal='".$roundtotal."',CashAmount='".$cashboth."',CardAmount='".$cardboth."',TotalPayment='".$totalpayment."',ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."',Flag='".$type."',PendingAmount='".$totalpend."',Membership_Amount='".$membercost."',PackageID='".$packagee."',PackageIDFlag='P' WHERE AppointmentId='".$appointment_id."'";
			}
			else
			{
				$sqlUpdate = "UPDATE tblInvoiceDetails SET Billaddress='".$billaddress."',InvoiceId='".$invoiceid."',CustomerID='".$customer."',CustomerFullName='".$CustomerFullName."',Email='".$email."',Mobile='".$mobile."',SubTotal='".$sub_total."',OfferAmt='".$offeramtt."',Total='".$total."',RoundTotal='".$roundtotal."',CashAmount='".$cashboth."',CardAmount='".$cardboth."',TotalPayment='".$totalpayment."',ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."',Flag='".$type."',PendingAmount='".$totalpend."',Membership_Amount='".$membercost."' WHERE AppointmentId='".$appointment_id."'";
			}
		
			  if ($DB->query($sqlUpdate) === TRUE) 
			{
				$data=2;//last id of tblCustomers insert
			}
		//////////////////////gift vouch change////////////// 
	 if($purchaseid!="")
		{
			$sqlUpdate2 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."' WHERE AppointmentId='".$appointment_id."'";
			 ExecuteNQ($sqlUpdate2);
		}
		elseif($purchaseid!="" && $Redemptid!="")
		{
			$remainamt=$gftamt-$totalredamt;
			$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."',GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
			 ExecuteNQ($sqlUpdate3);
				$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
					 ExecuteNQ($sqlUpdate4);
		}
		else
		{
			$remainamt=$gftamt-$totalredamt;
			$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
			 ExecuteNQ($sqlUpdate3);
				$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
					 ExecuteNQ($sqlUpdate4);
		}
		////////////////////////////////////////////////////////////////////////////			
		if($pendamt!="0" && $pendamt!="")
			{
			$sqlDelete = "DELETE FROM tblPendingPayments WHERE CustomerID='".$CustomerFullName."'";
			ExecuteNQ($sqlDelete);
				
			$sqlInsert2 = "Insert into tblPendingPayments(PendingAmount, AppointmentID, InvoiceID,DateTimeStamp,PaidAmount,Status,CustomerID,PendingStatus) values('".$pendamt."','".$appointment_id."', '".$invoiceid."','".$date."','".$paidamt."','1','".$CustomerFullName."','2')";
			$DB->query($sqlInsert2);
					
			}
			else
			{
			 $sqlUpdate3 = "UPDATE tblPendingPayments SET Status = '0',PendingStatus='1' WHERE CustomerID='".$CustomerFullName."'";
			ExecuteNQ($sqlUpdate3);
			
			}
			
			$sqlInsert2 = "UPDATE tblInvoiceDetails SET OfferDiscountDateTime='".$date."' WHERE AppointmentId='".$appointment_id."'";
			$DB->query($sqlInsert2); 
	   
			$sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
			ExecuteNQ($sqlUpdate2);
			 
			$sqlUpdate3 = "UPDATE tblAppointments SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
			ExecuteNQ($sqlUpdate3);
			 
			$sqlDelete = "DELETE FROM tblAppointmentlog WHERE appointment_id='".$appointment_id."'";
			ExecuteNQ($sqlDelete);
				  
			$sqlInsert1 = "Insert into tblAppointmentlog (appointment_id, invoice_name, appointment_date,store,status) values('".$appointment_id."','".$customer."', '".$appoint_date."','".$stores."','2')";
			$DB->query($sqlInsert1);

	
		 }
		 elseif($type=='H')
		 {
			   $sqp=select("CustomerID","tblCustomers","CustomerFullName='".$CustomerFullName."'");
			   $cust=$sqp[0]['CustomerID'];
			
			 if($packagee!="")
			{
				$sqlUpdate = "UPDATE tblInvoiceDetails SET Billaddress='".$billaddress."',InvoiceId='".$invoiceid."',CustomerID='".$customer."',CustomerFullName='".$CustomerFullName."',Email='".$email."',Mobile='".$mobile."',SubTotal='".$sub_total."',OfferAmt='".$offeramtt."',Total='".$total."',RoundTotal='".$roundtotal."',CashAmount='".$roundtotal."',TotalPayment='".$totalpayment."',ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."',Flag='".$type."',CardAmount='".$cardboth."',Membership_Amount='".$membercost."',PendingAmount='".$totalpend."',PackageID='".$packagee."',PackageIDFlag='P' WHERE AppointmentId='".$appointment_id."'";
			}
			else
			{
				$sqlUpdate = "UPDATE tblInvoiceDetails SET Billaddress='".$billaddress."',InvoiceId='".$invoiceid."',CustomerID='".$customer."',CustomerFullName='".$CustomerFullName."',Email='".$email."',Mobile='".$mobile."',SubTotal='".$sub_total."',OfferAmt='".$offeramtt."',Total='".$total."',RoundTotal='".$roundtotal."',CashAmount='".$roundtotal."',TotalPayment='".$totalpayment."',ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."',Flag='".$type."',CardAmount='".$cardboth."',Membership_Amount='".$membercost."',PendingAmount='".$totalpend."' WHERE AppointmentId='".$appointment_id."'";
			}
			//	ExecuteNQ($sqlUpdate);
			  if ($DB->query($sqlUpdate) === TRUE) 
			{
				$data=2;//last id of tblCustomers insert
			}
///////////////////////////////////gift vouch////////////////
			if($purchaseid!="")
				{
					$sqlUpdate2 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."' WHERE AppointmentId='".$appointment_id."'";
					 ExecuteNQ($sqlUpdate2);
				}
				elseif($purchaseid!="" && $Redemptid!="")
				{
					$remainamt=$gftamt-$totalredamt;
					$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."',GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
					 ExecuteNQ($sqlUpdate3);
					 
						$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
						ExecuteNQ($sqlUpdate4);
				}
				else
				{
					$remainamt=$gftamt-$totalredamt;
					$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
					 ExecuteNQ($sqlUpdate3);
					 
						$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
						ExecuteNQ($sqlUpdate4);
				}
		////////////////////////////////////
				if($pendamt!="")
				{
					$sep=select("PendingAmount","tblPendingPayments","CustomerID='".$CustomerFullName."' and Status='1' and PendingStatus='2'");
				foreach($sep as $avp)
				{
				$pendamtt=$avp['PendingAmount'];
				$totalpend=$totalpend+$pendamtt;
				 
					
				}
				$pend=$totalpend+$pendamt;
				$sqlInsert2 = "UPDATE tblPendingPayments SET PendingAmount='".$pendamt."',DateTimeStamp='".$date."',PaidAmount='".$paidamt."',CustomerID='".$CustomerFullName."' where AppointmentId='".$appointment_id."'";
				ExecuteNQ($sqlInsert2);	
				}
				else
				{

				$sep=select("PendingAmount","tblPendingPayments","CustomerID='".$CustomerFullName."' and Status='1' and PendingStatus='2'");
				foreach($sep as $avp)
				{
				$pendamtt=$avp['PendingAmount'];
				$totalpend=$totalpend+$pendamtt;
					
				}
				$pend=$totalpend+$paidamt;

				$sqlInsert2 = "UPDATE tblPendingPayments SET PendingAmount='".$roundtotal."',DateTimeStamp='".$date."',PaidAmount='0' where CustomerID='".$CustomerFullName."' and Status='1' and PendingStatus='2'";
				// echo $sqlInsert2;
				ExecuteNQ($sqlInsert2);	

				}

				 $sqlInsert2 = "UPDATE tblInvoiceDetails SET OfferDiscountDateTime='".$date."' WHERE AppointmentId='".$appointment_id."'";
			 //$DB->query($sqlInsert1); 
				$DB->query($sqlInsert2); 

				$sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
				ExecuteNQ($sqlUpdate2);
				
				
				$sqlUpdate3 = "UPDATE tblAppointments SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
				ExecuteNQ($sqlUpdate3);

				$sqlDelete = "DELETE FROM tblAppointmentlog WHERE appointment_id='".$appointment_id."'";
				ExecuteNQ($sqlDelete);
						  
				$sqlInsert1 = "Insert into tblAppointmentlog (appointment_id, invoice_name, appointment_date,store,status) values('".$appointment_id."','".$customer."', '".$appoint_date."','".$stores."','2')";
				$DB->query($sqlInsert1);
///////////////////////////////////////////////////////////////////////////////////

		 }
		 else if($type=='CS')
		 {
			   $sqp=select("CustomerID","tblCustomers","CustomerFullName='".$CustomerFullName."'");
			   $cust=$sqp[0]['CustomerID'];
			if($packagee!="")
			{
			   
				$sqlUpdate = "UPDATE tblInvoiceDetails SET Billaddress='".$billaddress."',InvoiceId='".$invoiceid."',CustomerID='".$customer."',CustomerFullName='".$CustomerFullName."',Email='".$email."',Mobile='".$mobile."',SubTotal='".$sub_total."',OfferAmt='".$offeramtt."',Total='".$total."',RoundTotal='".$roundtotal."',CashAmount='".$roundtotal."',TotalPayment='".$totalpayment."',ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."',Flag='".$type."',Membership_Amount='".$membercost."',PendingAmount='".$totalpend."',PackageID='".$packagee."',PackageIDFlag='P' WHERE AppointmentId='".$appointment_id."'";
			}
			else
			{
				$sqlUpdate = "UPDATE tblInvoiceDetails SET Billaddress='".$billaddress."',InvoiceId='".$invoiceid."',CustomerID='".$customer."',CustomerFullName='".$CustomerFullName."',Email='".$email."',Mobile='".$mobile."',SubTotal='".$sub_total."',OfferAmt='".$offeramtt."',Total='".$total."',RoundTotal='".$roundtotal."',CashAmount='".$roundtotal."',TotalPayment='".$totalpayment."',ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."',Flag='".$type."',Membership_Amount='".$membercost."',PendingAmount='".$totalpend."' WHERE AppointmentId='".$appointment_id."'";
			}
			//	ExecuteNQ($sqlUpdate);
			  if ($DB->query($sqlUpdate) === TRUE) 
			{
				$data=2;//last id of tblCustomers insert
			}
/////////////////////////////////////////gift vouch//////////////////
			if($purchaseid!="")
				{
					$sqlUpdate2 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."' WHERE AppointmentId='".$appointment_id."'";
					ExecuteNQ($sqlUpdate2);
				}
				elseif($purchaseid!="" && $Redemptid!="")
				{
					$remainamt=$gftamt-$totalredamt;
					$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."',GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
					 ExecuteNQ($sqlUpdate3);
					 
					$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
					ExecuteNQ($sqlUpdate4);
				}
				else
				{
					$remainamt=$gftamt-$totalredamt;
					$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
					ExecuteNQ($sqlUpdate3);
					 
					$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
					ExecuteNQ($sqlUpdate4);
				}
				///////////////////////////////////////
				if($pendamt!="0" && $pendamt!="")
					{
						$sqlDelete = "DELETE FROM tblPendingPayments WHERE CustomerID='".$CustomerFullName."'";
						ExecuteNQ($sqlDelete);
						
						$sqlInsert2 = "Insert into tblPendingPayments(PendingAmount, AppointmentID, InvoiceID,DateTimeStamp,PaidAmount,Status,CustomerID,PendingStatus) values('".$pendamt."','".$appointment_id."', '".$invoiceid."','".$date."','".$paidamt."','1','".$CustomerFullName."','2')";
						$DB->query($sqlInsert2);
							
					}
					else
					{
						$sqlUpdate3 = "UPDATE tblPendingPayments SET Status = '0',PendingStatus='1' WHERE CustomerID='".$CustomerFullName."'";
						ExecuteNQ($sqlUpdate3);
					
					}

					  $sqlInsert2 = "UPDATE tblInvoiceDetails SET OfferDiscountDateTime='".$date."' WHERE AppointmentId='".$appointment_id."'";
					   //$DB->query($sqlInsert1); 
					  $DB->query($sqlInsert2); 
					   
					  $sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
					  ExecuteNQ($sqlUpdate2);
					  
					  $sqlUpdate3 = "UPDATE tblAppointments SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
					  ExecuteNQ($sqlUpdate3);
					  
					  $sqlDelete = "DELETE FROM tblAppointmentlog WHERE appointment_id='".$appointment_id."'";
					  ExecuteNQ($sqlDelete);
					
					  $sqlInsert1 = "Insert into tblAppointmentlog (appointment_id, invoice_name, appointment_date,store,status) values('".$appointment_id."','".$customer."', '".$appoint_date."','".$stores."','2')";
					  $DB->query($sqlInsert1);
///////////////////////////////////////////////////////////////////////////////////
		 }
		 else if($type=='C')
		 {
				   $sqp=select("CustomerID","tblCustomers","CustomerFullName='".$CustomerFullName."'");
					$cust=$sqp[0]['CustomerID'];
					
				 if($packagee!="")
				 {	
					$sqlUpdate = "UPDATE tblInvoiceDetails SET Billaddress='".$billaddress."',InvoiceId='".$invoiceid."',CustomerID='".$customer."',CustomerFullName='".$CustomerFullName."',Email='".$email."',Mobile='".$mobile."',SubTotal='".$sub_total."',OfferAmt='".$offeramtt."',Total='".$total."',RoundTotal='".$roundtotal."',CardAmount='".$roundtotal."',TotalPayment='".$totalpayment."',ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."',Flag='".$type."',Membership_Amount='".$membercost."',PendingAmount='".$totalpend."',PackageID='".$packagee."',PackageIDFlag='P' WHERE AppointmentId='".$appointment_id."'";
				 }
				 else
				 {
					 $sqlUpdate = "UPDATE tblInvoiceDetails SET Billaddress='".$billaddress."',InvoiceId='".$invoiceid."',CustomerID='".$customer."',CustomerFullName='".$CustomerFullName."',Email='".$email."',Mobile='".$mobile."',SubTotal='".$sub_total."',OfferAmt='".$offeramtt."',Total='".$total."',RoundTotal='".$roundtotal."',CardAmount='".$roundtotal."',TotalPayment='".$totalpayment."',ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."',Flag='".$type."',Membership_Amount='".$membercost."',PendingAmount='".$totalpend."' WHERE AppointmentId='".$appointment_id."'";
				 }
//	ExecuteNQ($sqlUpdate);
				  if ($DB->query($sqlUpdate) === TRUE) 
				{
					$data=2;//last id of tblCustomers insert
				}
///////////////////////////gift vouch//////////////////////////////////
				if($purchaseid!="")
					{
						$sqlUpdate2 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."' WHERE AppointmentId='".$appointment_id."'";
						ExecuteNQ($sqlUpdate2);
						$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
						ExecuteNQ($sqlUpdate4);
					}
					elseif($purchaseid!="" && $Redemptid!="")
					{
						$remainamt=$gftamt-$totalredamt;
						$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."',GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
					    ExecuteNQ($sqlUpdate3);
						
						$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
						ExecuteNQ($sqlUpdate4);
					}
					else
					{
						$remainamt=$gftamt-$totalredamt;
						$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
						ExecuteNQ($sqlUpdate3);
						
					    $sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
						ExecuteNQ($sqlUpdate4);
					}
					/////////////////////////////////////////////////
					if($pendamt!="0" && $pendamt!="")
						{
							$sqlDelete = "DELETE FROM tblPendingPayments WHERE CustomerID='".$CustomerFullName."'";
							ExecuteNQ($sqlDelete);
							
							$sqlInsert2 = "Insert into tblPendingPayments(PendingAmount, AppointmentID, InvoiceID,DateTimeStamp,PaidAmount,Status,CustomerID,PendingStatus) values('".$pendamt."','".$appointment_id."', '".$invoiceid."','".$date."','".$paidamt."','1','".$CustomerFullName."','2')";
							$DB->query($sqlInsert2);
								
						}
						else
						{
					      $sqlUpdate3 = "UPDATE tblPendingPayments SET Status = '0',PendingStatus='1' WHERE CustomerID='".$CustomerFullName."'";
                          ExecuteNQ($sqlUpdate3);
						
						}

						 $sqlInsert2 = "UPDATE tblInvoiceDetails SET OfferDiscountDateTime='".$date."' WHERE AppointmentId='".$appointment_id."'";
					 //$DB->query($sqlInsert1); 
						 $DB->query($sqlInsert2); 
						 
                         $sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
                         ExecuteNQ($sqlUpdate2);
						 
	                     $sqlUpdate3 = "UPDATE tblAppointments SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
                         ExecuteNQ($sqlUpdate3);
						 
	                     $sqlDelete = "DELETE FROM tblAppointmentlog WHERE appointment_id='".$appointment_id."'";
						 ExecuteNQ($sqlDelete);
						
						 $sqlInsert1 = "Insert into tblAppointmentlog (appointment_id, invoice_name, appointment_date,store,status) values('".$appointment_id."','".$customer."', '".$appoint_date."','".$stores."','2')";
						 $DB->query($sqlInsert1);
///////////////////////////////////////////////////////////////////////////////////
	
		 }
		 else
		 {
			 
		 }
		 


	  }
	  else
	  {
		  if($PackageIDFlag=='P')
		  {
		    if($type=='BOTH')
				  {
					  $sqp=select("CustomerID","tblCustomers","CustomerFullName='".$CustomerFullName."'");
					  $cust=$sqp[0]['CustomerID'];
						  if($packagee!="")
						{
							$sqlUpdate = "UPDATE tblInvoiceDetails SET Billaddress='".$billaddress."',InvoiceId='".$invoiceid."',CustomerID='".$customer."',CustomerFullName='".$CustomerFullName."',Email='".$email."',Mobile='".$mobile."',SubTotal='".$sub_total."',OfferAmt='".$offeramtt."',Total='".$total."',RoundTotal='".$roundtotal."',CashAmount='".$cashboth."',CardAmount='".$cardboth."',TotalPayment='".$totalpayment."',ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."',Flag='".$type."',PendingAmount='".$totalpend."',Membership_Amount='".$membercost."',PackageID='".$packagee."',PackageIDFlag='P' WHERE AppointmentId='".$appointment_id."'";
						}
						else
						{
							$sqlUpdate = "UPDATE tblInvoiceDetails SET Billaddress='".$billaddress."',InvoiceId='".$invoiceid."',CustomerID='".$customer."',CustomerFullName='".$CustomerFullName."',Email='".$email."',Mobile='".$mobile."',SubTotal='".$sub_total."',OfferAmt='".$offeramtt."',Total='".$total."',RoundTotal='".$roundtotal."',CashAmount='".$cashboth."',CardAmount='".$cardboth."',TotalPayment='".$totalpayment."',ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."',Flag='".$type."',PendingAmount='".$totalpend."',Membership_Amount='".$membercost."' WHERE AppointmentId='".$appointment_id."'";
						}
					   
						
					//	ExecuteNQ($sqlUpdate);
						  if ($DB->query($sqlUpdate) === TRUE) 
						{
							$data=2;//last id of tblCustomers insert
						}
		////////////////////////////gift vouch////////////////////////////////////
						if($purchaseid!="")
								{
									$sqlUpdate2 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."' WHERE AppointmentId='".$appointment_id."'";
									ExecuteNQ($sqlUpdate2);
								}
								elseif($purchaseid!="" && $Redemptid!="")
								{
									$remainamt=$gftamt-$totalredamt;
									$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."',GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
									ExecuteNQ($sqlUpdate3);
									 
									$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
									ExecuteNQ($sqlUpdate4);
								}
								else
								{
									$remainamt=$gftamt-$totalredamt;
									
									$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
									ExecuteNQ($sqlUpdate3);
									
									$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
									ExecuteNQ($sqlUpdate4);
									 
								}
								//////////////////////////////////////////////////
							if($pendamt!="0" && $pendamt!="")
								{
									$sqlDelete = "DELETE FROM tblPendingPayments WHERE CustomerID='".$CustomerFullName."'";
									ExecuteNQ($sqlDelete);
									
									$sqlInsert2 = "Insert into tblPendingPayments(PendingAmount, AppointmentID, InvoiceID,DateTimeStamp,PaidAmount,Status,CustomerID,PendingStatus) values('".$pendamt."','".$appointment_id."', '".$invoiceid."','".$date."','".$paidamt."','1','".$CustomerFullName."','2')";
									$DB->query($sqlInsert2);
										
								}
								else
								{
									$sqlUpdate3 = "UPDATE tblPendingPayments SET Status = '0',PendingStatus='1' WHERE CustomerID='".$CustomerFullName."'";
									ExecuteNQ($sqlUpdate3);
								
								}
		
	
								$sqlInsert2 = "UPDATE tblInvoiceDetails SET OfferDiscountDateTime='".$date."' WHERE AppointmentId='".$appointment_id."'";
								 //$DB->query($sqlInsert1); 
								$DB->query($sqlInsert2); 
								 
								$sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
								ExecuteNQ($sqlUpdate2);
			
			
								$sqlUpdate3 = "UPDATE tblAppointments SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
								ExecuteNQ($sqlUpdate3);
			
				                $sqlDelete = "DELETE FROM tblAppointmentlog WHERE appointment_id='".$appointment_id."'";
					            ExecuteNQ($sqlDelete);
				  
								$sqlInsert1 = "Insert into tblAppointmentlog (appointment_id, invoice_name, appointment_date,store,status) values('".$appointment_id."','".$customer."', '".$appoint_date."','".$stores."','2')";
								$DB->query($sqlInsert1);
///////////////////////////////////////////////////////////////////////////////////
				 }
				 elseif($type=='H')
				 {
					   $sqp=select("CustomerID","tblCustomers","CustomerFullName='".$CustomerFullName."'");
					   $cust=$sqp[0]['CustomerID'];
					
							 if($packagee!="")
							{
								$sqlUpdate = "UPDATE tblInvoiceDetails SET Billaddress='".$billaddress."',InvoiceId='".$invoiceid."',CustomerID='".$customer."',CustomerFullName='".$CustomerFullName."',Email='".$email."',Mobile='".$mobile."',SubTotal='".$sub_total."',OfferAmt='".$offeramtt."',Total='".$total."',RoundTotal='".$roundtotal."',CashAmount='".$roundtotal."',TotalPayment='".$totalpayment."',ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."',Flag='".$type."',CardAmount='".$cardboth."',Membership_Amount='".$membercost."',PendingAmount='".$totalpend."',PackageID='".$packagee."',PackageIDFlag='P' WHERE AppointmentId='".$appointment_id."'";
							}
							else
							{
								$sqlUpdate = "UPDATE tblInvoiceDetails SET Billaddress='".$billaddress."',InvoiceId='".$invoiceid."',CustomerID='".$customer."',CustomerFullName='".$CustomerFullName."',Email='".$email."',Mobile='".$mobile."',SubTotal='".$sub_total."',OfferAmt='".$offeramtt."',Total='".$total."',RoundTotal='".$roundtotal."',CashAmount='".$roundtotal."',TotalPayment='".$totalpayment."',ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."',Flag='".$type."',CardAmount='".$cardboth."',Membership_Amount='".$membercost."',PendingAmount='".$totalpend."' WHERE AppointmentId='".$appointment_id."'";
							}
						//	ExecuteNQ($sqlUpdate);
							  if ($DB->query($sqlUpdate) === TRUE) 
							{
								$data=2;//last id of tblCustomers insert
							}
		///////////////////gift vouch//////////////////////////////
	
						if($purchaseid!="")
							{
								$sqlUpdate2 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."' WHERE AppointmentId='".$appointment_id."'";
								ExecuteNQ($sqlUpdate2);
							}
							elseif($purchaseid!="" && $Redemptid!="")
							{
								$remainamt=$gftamt-$totalredamt;
								$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."',GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
								ExecuteNQ($sqlUpdate3);
								 
								$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
								ExecuteNQ($sqlUpdate4);
							}
							else
							{
								$remainamt=$gftamt-$totalredamt;
								$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
								ExecuteNQ($sqlUpdate3);
								 
								$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
								ExecuteNQ($sqlUpdate4);
							}
							////////////////////////////////////////////
							if($pendamt!="")
							{
								$sep=select("PendingAmount","tblPendingPayments","CustomerID='".$CustomerFullName."' and Status='1' and PendingStatus='2'");
								foreach($sep as $avp)
								{
									$pendamtt=$avp['PendingAmount'];
									$totalpend=$totalpend+$pendamtt;
										
								}
							 
							 $pend=$totalpend+$pendamt;
							 $sqlInsert2 = "UPDATE tblPendingPayments SET PendingAmount='".$pendamt."',DateTimeStamp='".$date."',PaidAmount='".$paidamt."',CustomerID='".$CustomerFullName."' where AppointmentId='".$appointment_id."'";
							ExecuteNQ($sqlInsert2);	
							}
							else
							{
								
								$sep=select("PendingAmount","tblPendingPayments","CustomerID='".$CustomerFullName."' and Status='1' and PendingStatus='2'");
								foreach($sep as $avp)
								{
								 $pendamtt=$avp['PendingAmount'];
								 $totalpend=$totalpend+$pendamtt;
										
								}
							   $pend=$totalpend+$paidamt;
							   $sqlInsert2 = "UPDATE tblPendingPayments SET PendingAmount='".$roundtotal."',DateTimeStamp='".$date."',PaidAmount='0' where CustomerID='".$CustomerFullName."' and Status='1' and PendingStatus='2'";
							// echo $sqlInsert2;
							   ExecuteNQ($sqlInsert2);	
								
							}
		
								 $sqlInsert2 = "UPDATE tblInvoiceDetails SET OfferDiscountDateTime='".$date."' WHERE AppointmentId='".$appointment_id."'";
							 //$DB->query($sqlInsert1); 
								$DB->query($sqlInsert2); 
		  
								$sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
								ExecuteNQ($sqlUpdate2);
				
								$sqlUpdate3 = "UPDATE tblAppointments SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
								ExecuteNQ($sqlUpdate3);
								
								$sqlDelete = "DELETE FROM tblAppointmentlog WHERE appointment_id='".$appointment_id."'";
								ExecuteNQ($sqlDelete);
							  
								$sqlInsert1 = "Insert into tblAppointmentlog (appointment_id, invoice_name, appointment_date,store,status) values('".$appointment_id."','".$customer."', '".$appoint_date."','".$stores."','2')";
								$DB->query($sqlInsert1);
///////////////////////////////////////////////////////////////////////////////////

				 }
				 else if($type=='CS')
				 {
					
					   $sqp=select("CustomerID","tblCustomers","CustomerFullName='".$CustomerFullName."'");
					   $cust=$sqp[0]['CustomerID'];
						if($packagee!="")
						{
						   
							$sqlUpdate = "UPDATE tblInvoiceDetails SET Billaddress='".$billaddress."',InvoiceId='".$invoiceid."',CustomerID='".$customer."',CustomerFullName='".$CustomerFullName."',Email='".$email."',Mobile='".$mobile."',SubTotal='".$sub_total."',OfferAmt='".$offeramtt."',Total='".$total."',RoundTotal='".$roundtotal."',CashAmount='".$roundtotal."',TotalPayment='".$totalpayment."',ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."',Flag='".$type."',Membership_Amount='".$membercost."',PendingAmount='".$totalpend."',PackageID='".$packagee."',PackageIDFlag='P' WHERE AppointmentId='".$appointment_id."'";
						}
						else
						{
							$sqlUpdate = "UPDATE tblInvoiceDetails SET Billaddress='".$billaddress."',InvoiceId='".$invoiceid."',CustomerID='".$customer."',CustomerFullName='".$CustomerFullName."',Email='".$email."',Mobile='".$mobile."',SubTotal='".$sub_total."',OfferAmt='".$offeramtt."',Total='".$total."',RoundTotal='".$roundtotal."',CashAmount='".$roundtotal."',TotalPayment='".$totalpayment."',ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."',Flag='".$type."',Membership_Amount='".$membercost."',PendingAmount='".$totalpend."' WHERE AppointmentId='".$appointment_id."'";
						}
			
		//ExecuteNQ($sqlUpdate);
						  if ($DB->query($sqlUpdate) === TRUE) 
						{
							
							$data=2;//last id of tblCustomers insert
						}
		
		//////////////////////////gift vouch///////////////////////////////////////////
						if($purchaseid!="")
							{
								$sqlUpdate2 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."' WHERE AppointmentId='".$appointment_id."'";
								ExecuteNQ($sqlUpdate2);
							}
							elseif($purchaseid!="" && $Redemptid!="")
							{
								$remainamt=$gftamt-$totalredamt;
								$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."',GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
								ExecuteNQ($sqlUpdate3);
								$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
								ExecuteNQ($sqlUpdate4);
							}
							else
							{
								$remainamt=$gftamt-$totalredamt;
								$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
								ExecuteNQ($sqlUpdate3);
								$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
								ExecuteNQ($sqlUpdate4);
							}
							
				///////////////////////////////////////////////////
						if($pendamt!="0" && $pendamt!="")
							{
								$sqlDelete = "DELETE FROM tblPendingPayments WHERE CustomerID='".$CustomerFullName."'";
								ExecuteNQ($sqlDelete);
								
							    $sqlInsert2 = "Insert into tblPendingPayments(PendingAmount, AppointmentID, InvoiceID,DateTimeStamp,PaidAmount,Status,CustomerID,PendingStatus) values('".$pendamt."','".$appointment_id."', '".$invoiceid."','".$date."','".$paidamt."','1','".$CustomerFullName."','2')";
								$DB->query($sqlInsert2);
									
							}
							else
							{
						
						        $sqlUpdate3 = "UPDATE tblPendingPayments SET Status = '0',PendingStatus='1' WHERE CustomerID='".$CustomerFullName."'";
                                ExecuteNQ($sqlUpdate3);
							
							}

							 $sqlInsert2 = "UPDATE tblInvoiceDetails SET OfferDiscountDateTime='".$date."' WHERE AppointmentId='".$appointment_id."'";
							 //$DB->query($sqlInsert1); 
							 $DB->query($sqlInsert2); 
							 
	                         $sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
                             ExecuteNQ($sqlUpdate2);
							 
			                 $sqlUpdate3 = "UPDATE tblAppointments SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
                             ExecuteNQ($sqlUpdate3);
							 
			                $sqlDelete = "DELETE FROM tblAppointmentlog WHERE appointment_id='".$appointment_id."'";
							ExecuteNQ($sqlDelete);
						  
							$sqlInsert1 = "Insert into tblAppointmentlog (appointment_id, invoice_name, appointment_date,store,status) values('".$appointment_id."','".$customer."', '".$appoint_date."','".$stores."','2')";
							$DB->query($sqlInsert1);
///////////////////////////////////////////////////////////////////////////////////
				 }
				 else if($type=='C')
				 {
					   $sqp=select("CustomerID","tblCustomers","CustomerFullName='".$CustomerFullName."'");
						$cust=$sqp[0]['CustomerID'];
						
						 if($packagee!="")
						 {	
							$sqlUpdate = "UPDATE tblInvoiceDetails SET Billaddress='".$billaddress."',InvoiceId='".$invoiceid."',CustomerID='".$customer."',CustomerFullName='".$CustomerFullName."',Email='".$email."',Mobile='".$mobile."',SubTotal='".$sub_total."',OfferAmt='".$offeramtt."',Total='".$total."',RoundTotal='".$roundtotal."',CardAmount='".$roundtotal."',TotalPayment='".$totalpayment."',ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."',Flag='".$type."',Membership_Amount='".$membercost."',PendingAmount='".$totalpend."',PackageID='".$packagee."',PackageIDFlag='P' WHERE AppointmentId='".$appointment_id."'";
						 }
						 else
						 {
							 $sqlUpdate = "UPDATE tblInvoiceDetails SET Billaddress='".$billaddress."',InvoiceId='".$invoiceid."',CustomerID='".$customer."',CustomerFullName='".$CustomerFullName."',Email='".$email."',Mobile='".$mobile."',SubTotal='".$sub_total."',OfferAmt='".$offeramtt."',Total='".$total."',RoundTotal='".$roundtotal."',CardAmount='".$roundtotal."',TotalPayment='".$totalpayment."',ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."',Flag='".$type."',Membership_Amount='".$membercost."',PendingAmount='".$totalpend."' WHERE AppointmentId='".$appointment_id."'";
						 }
					//	ExecuteNQ($sqlUpdate);
						  if ($DB->query($sqlUpdate) === TRUE) 
						{
							$data=2;//last id of tblCustomers insert
						}
		//////////////////////////////gift vouch/////////////
						if($purchaseid!="")
							{
								$sqlUpdate2 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."' WHERE AppointmentId='".$appointment_id."'";
								ExecuteNQ($sqlUpdate2);
							}
							elseif($purchaseid!="" && $Redemptid!="")
							{
								$remainamt=$gftamt-$totalredamt;
								$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."',GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
								ExecuteNQ($sqlUpdate3);
								 
								$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
								ExecuteNQ($sqlUpdate4);
							}
							else
							{
								$remainamt=$gftamt-$totalredamt;
								$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
								ExecuteNQ($sqlUpdate3);
								 
								$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
								ExecuteNQ($sqlUpdate4);
							}
							//////////////////////////////
							if($pendamt!="0" && $pendamt!="")
								{
									$sqlDelete = "DELETE FROM tblPendingPayments WHERE CustomerID='".$CustomerFullName."'";
									ExecuteNQ($sqlDelete);
						
									$sqlInsert2 = "Insert into tblPendingPayments(PendingAmount, AppointmentID, InvoiceID,DateTimeStamp,PaidAmount,Status,CustomerID,PendingStatus) values('".$pendamt."','".$appointment_id."', '".$invoiceid."','".$date."','".$paidamt."','1','".$CustomerFullName."','2')";
									$DB->query($sqlInsert2);
										
								}
								else
								{
									$sqlUpdate3 = "UPDATE tblPendingPayments SET Status = '0',PendingStatus='1' WHERE CustomerID='".$CustomerFullName."'";
                                    ExecuteNQ($sqlUpdate3);
								
								}

								 $sqlInsert2 = "UPDATE tblInvoiceDetails SET OfferDiscountDateTime='".$date."' WHERE AppointmentId='".$appointment_id."'";
							 //$DB->query($sqlInsert1); 
							     $DB->query($sqlInsert2); 
	  
	                             $sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
                                 ExecuteNQ($sqlUpdate2);
			
			
								$sqlUpdate3 = "UPDATE tblAppointments SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
								ExecuteNQ($sqlUpdate3);
			
			
	
								$sqlDelete = "DELETE FROM tblAppointmentlog WHERE appointment_id='".$appointment_id."'";
								ExecuteNQ($sqlDelete);

								$sqlInsert1 = "Insert into tblAppointmentlog (appointment_id, invoice_name, appointment_date,store,status) values('".$appointment_id."','".$customer."', '".$appoint_date."','".$stores."','2')";
								$DB->query($sqlInsert1);
///////////////////////////////////////////////////////////////////////////////////
				 }
				 else
				 {
					 
				 } 
		  }
		  else
		  {
			   $data="This Invoice Details Already Saved";
		  }
		  
	  }
						  
						  
    }
	else
	{
						
	  if($type=='CS')
	  {
		
								   $sqp=select("CustomerID","tblCustomers","CustomerFullName='".$CustomerFullName."'");
								   $cust=$sqp[0]['CustomerID'];
									
									
											if($packagee!="")
											{
												$sqlInsert1 = "Insert into tblInvoiceDetails(AppointmentId, Billaddress, InvoiceId,CustomerID,CustomerFullName,Email,Mobile,SubTotal,OfferAmt,Total,RoundTotal,CashAmount,TotalPayment,Flag,Membership_Amount,OfferDiscountDateTime,PendingAmount,PackageID,PackageIDFlag) values('".$appointment_id."','".$billaddress."', '".$invoiceid."','".$customer."','".$CustomerFullName."','".$email."','".$mobile."','".$sub_total."','".$offeramtt."','".$total."','".$roundtotal."','".$roundtotal."','".$totalpayment."','CS','".$membercost."','".$date."','".$totalpend."','".$packagee."','P')";
											}
											else
											{
												$sqlInsert1 = "Insert into tblInvoiceDetails(AppointmentId, Billaddress, InvoiceId,CustomerID,CustomerFullName,Email,Mobile,SubTotal,OfferAmt,Total,RoundTotal,CashAmount,TotalPayment,Flag,Membership_Amount,OfferDiscountDateTime,PendingAmount) values('".$appointment_id."','".$billaddress."', '".$invoiceid."','".$customer."','".$CustomerFullName."','".$email."','".$mobile."','".$sub_total."','".$offeramtt."','".$total."','".$roundtotal."','".$roundtotal."','".$totalpayment."','CS','".$membercost."','".$date."','".$totalpend."')";
											}
										
											if ($DB->query($sqlInsert1) === TRUE) 
											{
												$last_id = $DB->insert_id;		//last id of tblCustomers insert
											}
											else
											{
												echo "Error: " . $sqlInsert1 . "<br>" . $conn->error;
											}
											
									 
											$sqlUpdatepp = "UPDATE tblCustomers SET memberflag='1' WHERE CustomerMobileNo='".$mobile."'";
											ExecuteNQ($sqlUpdatepp);

											$sqlUpdate = "UPDATE tblInvoiceDetails SET ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."' WHERE AppointmentId='".$appointment_id."'";

											 if ($DB->query($sqlUpdate) === TRUE) 
											{
												$data=2;//last id of tblCustomers insert
											}
									//////////////////////////////////////gift vouch///////////////
										if($purchaseid!="")
										{
											$sqlUpdate2 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."' WHERE AppointmentId='".$appointment_id."'";
											ExecuteNQ($sqlUpdate2);
										}
										elseif($purchaseid!="" && $Redemptid!="")
										{
											$remainamt=$gftamt-$totalredamt;
											$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."',GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
											ExecuteNQ($sqlUpdate3);
											$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
											ExecuteNQ($sqlUpdate4);
										}
										else
										{
											$remainamt=$gftamt-$totalredamt;
											$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
											ExecuteNQ($sqlUpdate3);
											$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
											ExecuteNQ($sqlUpdate4);
										}
								//////////////////////////////////////////////
										if($pendamt!="0" && $pendamt!="")
										{
											$sqlDelete = "DELETE FROM tblPendingPayments WHERE CustomerID='".$CustomerFullName."'";
											ExecuteNQ($sqlDelete);
											
												$sqlInsert2 = "Insert into tblPendingPayments(PendingAmount, AppointmentID, InvoiceID,DateTimeStamp,PaidAmount,Status,CustomerID,PendingStatus) values('".$pendamt."','".$appointment_id."', '".$invoiceid."','".$date."','".$paidamt."','1','".$CustomerFullName."','2')";
												$DB->query($sqlInsert2);
												
										}
										else
										{
									
											
												$sqlUpdate3 = "UPDATE tblPendingPayments SET Status = '0',PendingStatus='1' WHERE CustomerID='".$CustomerFullName."'";

											ExecuteNQ($sqlUpdate3);
										
										}
									

									for($i=0;$i<count($serviceido);$i++)
									{
										if($serviceido[$i]!="")
										{
												$sqlDelete = "DELETE FROM tblAppointmentMembershipDiscount WHERE AppointmentID='".$appointment_id."' and MembershipID!='0'";
										ExecuteNQ($sqlDelete);
											 $sqlInsert4 = "Insert into tblAppointmentMembershipDiscount(AppointmentID, Id, ServiceID,OfferID,OfferAmount,DateTimeStamp,MembershipAmount) values('".$appointment_id."','".$last_id."', '".$serviceido[$i]."','".$offerid[$i]."','".$offeramt[$i]."','".$date."','0')";
									
												if ($DB->query($sqlInsert4) === TRUE) 
												{
													$last_idd = $DB->insert_id;		//last id of tblCustomers insert
												}
												else
												{
													echo "Error: " . $sqlInsert4 . "<br>" . $conn->error;
												}
										}
										else
										{
											
										}
											
									}
									for($i=0;$i<count($serviceidm);$i++)
									{
										if($serviceidm[$i]!="")
										{
											$sqlDelete = "DELETE FROM tblAppointmentMembershipDiscount WHERE AppointmentID='".$appointment_id."' and OfferID!='0'";
										ExecuteNQ($sqlDelete);
											
											$sqlInsert4 = "Insert into tblAppointmentMembershipDiscount(AppointmentID, Id, ServiceID,MembershipID,MembershipAmount,DateTimeStamp,OfferAmount) values('".$appointment_id."','".$last_id."', '".$serviceidm[$i]."','".$memid[$i]."','".$discountm[$i]."','".$date."','0')";
									
											if ($DB->query($sqlInsert4) === TRUE) 
											{
												$last_idd = $DB->insert_id;		//last id of tblCustomers insert
											}
											else
											{
												echo "Error: " . $sqlInsert4 . "<br>" . $conn->error;
											}
										}
											 
									}
									
										$sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
                                        ExecuteNQ($sqlUpdate2);
							
							            $sqlUpdate3 = "UPDATE tblAppointments SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
                                        ExecuteNQ($sqlUpdate3);

							            $sqlDelete = "DELETE FROM tblAppointmentlog WHERE appointment_id='".$appointment_id."'";
								        ExecuteNQ($sqlDelete);
							  
										$sqlInsert1 = "Insert into tblAppointmentlog (appointment_id, invoice_name, appointment_date,store,status) values('".$appointment_id."','".$customer."', '".$appoint_date."','".$stores."','2')";
										$DB->query($sqlInsert1);
///////////////////////////////////////////////////////////////////////////////////

	  }
	  elseif($type=='H')
	  {
									   $sqp=select("CustomerID","tblCustomers","CustomerFullName='".$CustomerFullName."'");
									   $cust=$sqp[0]['CustomerID'];
										if($packagee!="")
										{
													 $sqlInsert1 = "Insert into tblInvoiceDetails(AppointmentId, Billaddress, InvoiceId,CustomerID,CustomerFullName,Email,Mobile,SubTotal,OfferAmt,Total,RoundTotal,CashAmount,TotalPayment,Flag,Membership_Amount,OfferDiscountDateTime,PendingAmount,PackageID,PackageIDFlag) values('".$appointment_id."','".$billaddress."', '".$invoiceid."','".$customer."','".$CustomerFullName."','".$email."','".$mobile."','".$sub_total."','".$offeramtt."','".$total."','".$roundtotal."','".$roundtotal."','".$totalpayment."','H','".$membercost."','".$date."','".$totalpend."','".$packagee."','P')";
										}
										else
										{
													 $sqlInsert1 = "Insert into tblInvoiceDetails(AppointmentId, Billaddress, InvoiceId,CustomerID,CustomerFullName,Email,Mobile,SubTotal,OfferAmt,Total,RoundTotal,CashAmount,TotalPayment,Flag,Membership_Amount,OfferDiscountDateTime,PendingAmount) values('".$appointment_id."','".$billaddress."', '".$invoiceid."','".$customer."','".$CustomerFullName."','".$email."','".$mobile."','".$sub_total."','".$offeramtt."','".$total."','".$roundtotal."','".$roundtotal."','".$totalpayment."','H','".$membercost."','".$date."','".$totalpend."')";
										}
										   if ($DB->query($sqlInsert1) === TRUE) 
													{
														$last_id = $DB->insert_id;		//last id of tblCustomers insert
													}
													else
													{
														echo "Error: " . $sql . "<br>" . $conn->error;
													}
													
			 
													$idp='3'.",".$appointment_id;
													$sqlUpdate2 = "UPDATE tblCustomers SET memberflag='".$idp."' WHERE CustomerMobileNo='".$mobile."'";
													ExecuteNQ($sqlUpdate2);
		
													$sqlUpdate = "UPDATE tblInvoiceDetails SET ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."' WHERE AppointmentId='".$appointment_id."'";
											//	ExecuteNQ($sqlUpdate);
													  if ($DB->query($sqlUpdate) === TRUE) 
													{
														$data=2;//last id of tblCustomers insert
													}
////////////////////////////////////gift vouch///////////////////////////
											if($purchaseid!="")
												{
													$sqlUpdate2 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."' WHERE AppointmentId='".$appointment_id."'";
													ExecuteNQ($sqlUpdate2);
												}
												elseif($purchaseid!="" && $Redemptid!="")
												{
													$remainamt=$gftamt-$totalredamt;
													$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."',GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
													ExecuteNQ($sqlUpdate3);
													$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
													ExecuteNQ($sqlUpdate4);
												}
												else
												{
												    $remainamt=$gftamt-$totalredamt;
													$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
													ExecuteNQ($sqlUpdate3);
													$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
													ExecuteNQ($sqlUpdate4);
												}
/////////////////////////////////////////////////////////////////////

													if($pendamt!="")
													{
														$sqlDelete = "DELETE FROM tblPendingPayments WHERE CustomerID='".$CustomerFullName."'";
													    ExecuteNQ($sqlDelete);
														
														$sep=select("PendingAmount","tblPendingPayments","CustomerID='".$CustomerFullName."'");
														foreach($sep as $avp)
														{
															$pendamtt=$avp['PendingAmount'];
															$totalpend=$totalpend+$pendamtt;
														}
													    $pend=$totalpend+$pendamt;
														$sqlInsert2 = "Insert into tblPendingPayments(PendingAmount, AppointmentID, InvoiceID,DateTimeStamp,PaidAmount,Status,CustomerID,PendingStatus) values('".$pendamt."','".$appointment_id."', '".$invoiceid."','".$date."','".$paidamt."','0','".$CustomerFullName."','2')";
													    $DB->query($sqlInsert2);
													}
													else
													{
														$sqlDelete = "DELETE FROM tblPendingPayments WHERE CustomerID='".$CustomerFullName."'";
													    ExecuteNQ($sqlDelete);
														$sep=select("PendingAmount","tblPendingPayments","CustomerID='".$CustomerFullName."'");
														foreach($sep as $avp)
														{
															$pendamtt=$avp['PendingAmount'];
															$totalpend=$totalpend+$pendamtt;
														}
											          $pend=$totalpend+$totalpayment;
													  $sqlInsert2 = "Insert into tblPendingPayments(PendingAmount, AppointmentID, InvoiceID,DateTimeStamp,PaidAmount,Status,CustomerID,PendingStatus) values('".$totalpayment."','".$appointment_id."', '".$invoiceid."','".$date."','0','1','".$CustomerFullName."','2')";
												//	echo $sqlInsert2;
											         $DB->query($sqlInsert2);
			                                         }
													for($i=0;$i<count($serviceido);$i++)
															{
																if($serviceido[$i]!="")
																{
																  $sqlDelete = "DELETE FROM tblAppointmentMembershipDiscount WHERE AppointmentID='".$appointment_id."' and MembershipID!='0'";
																  ExecuteNQ($sqlDelete);
																  $sqlInsert4 = "Insert into tblAppointmentMembershipDiscount(AppointmentID, Id, ServiceID,OfferID,OfferAmount,DateTimeStamp,MembershipAmount) values('".$appointment_id."','".$last_id."', '".$serviceido[$i]."','".$offerid[$i]."','".$offeramt[$i]."','".$date."','0')";
															
																		if ($DB->query($sqlInsert4) === TRUE) 
																		{
																			$last_idd = $DB->insert_id;		//last id of tblCustomers insert
																		}
																		else
																		{
																			echo "Error: " . $sqlInsert4 . "<br>" . $conn->error;
																		}
																}
																else
																{
																	
																}
																	
															}
															for($i=0;$i<count($serviceidm);$i++)
															{
																if($serviceidm[$i]!="")
																{
																	$sqlDelete = "DELETE FROM tblAppointmentMembershipDiscount WHERE AppointmentID='".$appointment_id."' and OfferID!='0'";
																    ExecuteNQ($sqlDelete);
																	
																	$sqlInsert4 = "Insert into tblAppointmentMembershipDiscount(AppointmentID, Id, ServiceID,MembershipID,MembershipAmount,DateTimeStamp,OfferAmount) values('".$appointment_id."','".$last_id."', '".$serviceidm[$i]."','".$memid[$i]."','".$discountm[$i]."','".$date."','0')";
															
																	if ($DB->query($sqlInsert4) === TRUE) 
																	{
																		$last_idd = $DB->insert_id;		//last id of tblCustomers insert
																	}
																	else
																	{
																		echo "Error: " . $sqlInsert4 . "<br>" . $conn->error;
																	}
																}
																	 
															}
			                                              $sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
                                                          ExecuteNQ($sqlUpdate2);
	                                                      $sqlUpdate3 = "UPDATE tblAppointments SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
														  ExecuteNQ($sqlUpdate3);


														$sqlDelete = "DELETE FROM tblAppointmentlog WHERE appointment_id='".$appointment_id."'";
														ExecuteNQ($sqlDelete);
													  
														$sqlInsert1 = "Insert into tblAppointmentlog (appointment_id, invoice_name, appointment_date,store,status) values('".$appointment_id."','".$customer."', '".$appoint_date."','".$stores."','2')";
														$DB->query($sqlInsert1);
///////////////////////////////////////////////////////////////////////////////////

	  }
	   elseif($type=='C')
	  {
													   $sqp=select("CustomerID","tblCustomers","CustomerFullName='".$CustomerFullName."'");
													   $cust=$sqp[0]['CustomerID'];
													  if($packagee!="")
														{
															$sqlInsert1 = "Insert into tblInvoiceDetails(AppointmentId, Billaddress, InvoiceId,CustomerID,CustomerFullName,Email,Mobile,SubTotal,OfferAmt,Total,RoundTotal,CardAmount,TotalPayment,Flag,Membership_Amount,OfferDiscountDateTime,PendingAmount,PackageID,PackageIDFlag) values('".$appointment_id."','".$billaddress."', '".$invoiceid."','".$customer."','".$CustomerFullName."','".$email."','".$mobile."','".$sub_total."','".$offeramtt."','".$total."','".$roundtotal."','".$roundtotal."','".$totalpayment."','C','".$membercost."','".$date."','".$totalpend."','".$packagee."','P')";
														}
														else
														{
															$sqlInsert1 = "Insert into tblInvoiceDetails(AppointmentId, Billaddress, InvoiceId,CustomerID,CustomerFullName,Email,Mobile,SubTotal,OfferAmt,Total,RoundTotal,CardAmount,TotalPayment,Flag,Membership_Amount,OfferDiscountDateTime,PendingAmount) values('".$appointment_id."','".$billaddress."', '".$invoiceid."','".$customer."','".$CustomerFullName."','".$email."','".$mobile."','".$sub_total."','".$offeramtt."','".$total."','".$roundtotal."','".$roundtotal."','".$totalpayment."','C','".$membercost."','".$date."','".$totalpend."')";
														}
															
														 
												  
													 
		 //$DB->query($sqlInsert1); 
														if ($DB->query($sqlInsert1) === TRUE) 
														{
															$last_id = $DB->insert_id;		//last id of tblCustomers insert
														}
														else
														{
															echo "Error: " . $sql . "<br>" . $conn->error;
														}
		
		
														$sqlUpdate = "UPDATE tblInvoiceDetails SET ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."' WHERE AppointmentId='".$appointment_id."'";
													//	ExecuteNQ($sqlUpdate);
														 if ($DB->query($sqlUpdate) === TRUE) 
														{
															$data=2;//last id of tblCustomers insert
														}
														/////////////////gift vouch////////////
														if($purchaseid!="")
															{
															  $sqlUpdate2 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."' WHERE AppointmentId='".$appointment_id."'";
															  ExecuteNQ($sqlUpdate2);
															}
															elseif($purchaseid!="" && $Redemptid!="")
															{
																$remainamt=$gftamt-$totalredamt;
																$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."',GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
																ExecuteNQ($sqlUpdate3);
																$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
																ExecuteNQ($sqlUpdate4);
															}
															else
															{
															    $remainamt=$gftamt-$totalredamt;
																$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
																ExecuteNQ($sqlUpdate3);
																$sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
																ExecuteNQ($sqlUpdate4);
															}
//////////////////////////////
														$sqlUpdate2 = "UPDATE tblCustomers SET memberflag='2' WHERE CustomerMobileNo='".$mobile."'";
														ExecuteNQ($sqlUpdate2);


														$sep=select("PendingAmount","tblPendingPayments","CustomerID='".$CustomerFullName."'");
														foreach($sep as $avp)
														{
															$pendamtt=$avp['PendingAmount'];
															$totalpend=$totalpend+$pendamtt;
														}
														
														$pend=$totalpend+$pendamt;
														if($pendamt!="0" && $pendamt!="")
															   {
																	$sqlDelete = "DELETE FROM tblPendingPayments WHERE CustomerID='".$CustomerFullName."'";
																	ExecuteNQ($sqlDelete);
																	$sqlInsert2 = "Insert into tblPendingPayments(PendingAmount, AppointmentID, InvoiceID,DateTimeStamp,PaidAmount,Status,CustomerID,PendingStatus) values('".$pendamt."','".$appointment_id."', '".$invoiceid."','".$date."','".$paidamt."','1','".$CustomerFullName."','2')";
																	$DB->query($sqlInsert2);
																}
																else
																{
																	
																	$sqlUpdate3 = "UPDATE tblPendingPayments SET Status = '0',PendingStatus='1' WHERE CustomerID='".$CustomerFullName."'";
																	ExecuteNQ($sqlUpdate3);
																
																}
															

														for($i=0;$i<count($serviceido);$i++)
																	{
																		if($serviceido[$i]!="")
																		{
																				$sqlDelete = "DELETE FROM tblAppointmentMembershipDiscount WHERE AppointmentID='".$appointment_id."' and MembershipID!='0'";
																		        ExecuteNQ($sqlDelete);
																			    $sqlInsert4 = "Insert into tblAppointmentMembershipDiscount(AppointmentID, Id, ServiceID,OfferID,OfferAmount,DateTimeStamp,MembershipAmount) values('".$appointment_id."','".$last_id."', '".$serviceido[$i]."','".$offerid[$i]."','".$offeramt[$i]."','".$date."','0')";
																	
																				if ($DB->query($sqlInsert4) === TRUE) 
																				{
																					$last_idd = $DB->insert_id;		//last id of tblCustomers insert
																				}
																				else
																				{
																					echo "Error: " . $sqlInsert4 . "<br>" . $conn->error;
																				}
																		}
																		else
																		{
																			
																		}
																			
																	}
																	for($i=0;$i<count($serviceidm);$i++)
																	{
																		if($serviceidm[$i]!="")
																		{
																			$sqlDelete = "DELETE FROM tblAppointmentMembershipDiscount WHERE AppointmentID='".$appointment_id."' and OfferID!='0'";
																		    ExecuteNQ($sqlDelete);
																			
																			$sqlInsert4 = "Insert into tblAppointmentMembershipDiscount(AppointmentID, Id, ServiceID,MembershipID,MembershipAmount,DateTimeStamp,OfferAmount) values('".$appointment_id."','".$last_id."', '".$serviceidm[$i]."','".$memid[$i]."','".$discountm[$i]."','".$date."','0')";
																	
																			if ($DB->query($sqlInsert4) === TRUE) 
																			{
																				$last_idd = $DB->insert_id;		//last id of tblCustomers insert
																			}
																			else
																			{
																				echo "Error: " . $sqlInsert4 . "<br>" . $conn->error;
																			}
																		}
																			 
																	}
																	$sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
																	ExecuteNQ($sqlUpdate2);
																	
	                                                                $sqlUpdate3 = "UPDATE tblAppointments SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
																	ExecuteNQ($sqlUpdate3);
																	
																	$sqlDelete = "DELETE FROM tblAppointmentlog WHERE appointment_id='".$appointment_id."'";
																	ExecuteNQ($sqlDelete);
			  
																	$sqlInsert1 = "Insert into tblAppointmentlog (appointment_id, invoice_name, appointment_date,store,status) values('".$appointment_id."','".$customer."', '".$appoint_date."','".$stores."','2')";
																	$DB->query($sqlInsert1);
///////////////////////////////////////////////////////////////////////////////////
	  }
	  elseif($type=='BOTH')
	  {
													   $sqp=select("CustomerID","tblCustomers","CustomerFullName='".$CustomerFullName."'");
													   $cust=$sqp[0]['CustomerID'];
													   if($packagee!="")
														{
															   $sqlInsert1 = "Insert into tblInvoiceDetails(AppointmentId, Billaddress, InvoiceId,CustomerID,CustomerFullName,Email,Mobile,SubTotal,OfferAmt,Total,RoundTotal,CashAmount,TotalPayment,Flag,CardAmount,Membership_Amount,OfferDiscountDateTime,PendingAmount,PackageID,PackageIDFlag) values('".$appointment_id."','".$billaddress."', '".$invoiceid."','".$customer."','".$CustomerFullName."','".$email."','".$mobile."','".$sub_total."','".$offeramtt."','".$total."','".$roundtotal."','".$cashboth."','".$totalpayment."','BOTH','".$cardboth."','".$membercost."','".$date."','".$totalpend."','".$packagee."','P')";
															
														}
														else
														{
															   $sqlInsert1 = "Insert into tblInvoiceDetails(AppointmentId, Billaddress, InvoiceId,CustomerID,CustomerFullName,Email,Mobile,SubTotal,OfferAmt,Total,RoundTotal,CashAmount,TotalPayment,Flag,CardAmount,Membership_Amount,OfferDiscountDateTime,PendingAmount) values('".$appointment_id."','".$billaddress."', '".$invoiceid."','".$customer."','".$CustomerFullName."','".$email."','".$mobile."','".$sub_total."','".$offeramtt."','".$total."','".$roundtotal."','".$cashboth."','".$totalpayment."','BOTH','".$cardboth."','".$membercost."','".$date."','".$totalpend."')";
														}
													  if ($DB->query($sqlInsert1) === TRUE) 
														{
															$last_id = $DB->insert_id;		//last id of tblCustomers insert
														}
														else
														{
															echo "Error: " . $sql . "<br>" . $conn->error;
														}
							
														$sqlUpdate = "UPDATE tblInvoiceDetails SET ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."' WHERE AppointmentId='".$appointment_id."'";
												//	ExecuteNQ($sqlUpdate);
														  if ($DB->query($sqlUpdate) === TRUE) 
														{
															$data=2;//last id of tblCustomers insert
														}
														////////////gift vouch/////////////////
														if($purchaseid!="")
														{
															$sqlUpdate2 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."' WHERE AppointmentId='".$appointment_id."'";
															 ExecuteNQ($sqlUpdate2);
														}
														elseif($purchaseid!="" && $Redemptid!="")
														{
															$remainamt=$gftamt-$totalredamt;
															$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVPurchasedID='".$purchaseid."',GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
															ExecuteNQ($sqlUpdate3);
															 
															 $sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
															 ExecuteNQ($sqlUpdate4);
														}
														else
														{
															$remainamt=$gftamt-$totalredamt;
															$sqlUpdate3 = "UPDATE tblInvoiceDetails SET GVRedeemedID='".$Redemptid."' WHERE AppointmentId='".$appointment_id."'";
															ExecuteNQ($sqlUpdate3);
															 
															 $sqlUpdate4 = "UPDATE tblGiftVouchers SET RemainingGiftVoucherAmount='".$remainamt."' WHERE RedempedBy='".$appointment_id."'";
															 ExecuteNQ($sqlUpdate4);
														}
	///////////////////////////////////////////////
														$sqlUpdate2 = "UPDATE tblCustomers SET memberflag='4' WHERE CustomerMobileNo='".$mobile."'";
														ExecuteNQ($sqlUpdate2);
																
														$sep=select("PendingAmount","tblPendingPayments","CustomerID='".$CustomerFullName."'");
														foreach($sep as $avp)
														{
															$pendamtt=$avp['PendingAmount'];
															$totalpend=$totalpend+$pendamtt;
														}
														$pend=$totalpend+$pendamt;
		
													if($pendamt!="0" && $pendamt!="")
													{
														
														$sqlDelete = "DELETE FROM tblPendingPayments WHERE CustomerID='".$CustomerFullName."'";
														ExecuteNQ($sqlDelete);
														$sqlInsert2 = "Insert into tblPendingPayments(PendingAmount, AppointmentID, InvoiceID,DateTimeStamp,PaidAmount,Status,CustomerID,PendingStatus) values('".$pendamt."','".$appointment_id."', '".$invoiceid."','".$date."','".$paidamt."','1','".$CustomerFullName."','2')";
														$DB->query($sqlInsert2);
													}
													else
													{
														
														$sqlUpdate3 = "UPDATE tblPendingPayments SET Status = '0',PendingStatus='1' WHERE CustomerID='".$CustomerFullName."'";
                                                        ExecuteNQ($sqlUpdate3);
													
													}

										     for($i=0;$i<count($serviceido);$i++)
													{
														if($serviceido[$i]!="")
														{
														  $sqlDelete = "DELETE FROM tblAppointmentMembershipDiscount WHERE AppointmentID='".$appointment_id."' and MembershipID!='0'";
														  ExecuteNQ($sqlDelete);
														  
														  $sqlInsert4 = "Insert into tblAppointmentMembershipDiscount(AppointmentID, Id, ServiceID,OfferID,OfferAmount,DateTimeStamp,MembershipAmount) values('".$appointment_id."','".$last_id."', '".$serviceido[$i]."','".$offerid[$i]."','".$offeramt[$i]."','".$date."','0')";
													
															if ($DB->query($sqlInsert4) === TRUE) 
															{
																$last_idd = $DB->insert_id;		//last id of tblCustomers insert
															}
															else
															{
																echo "Error: " . $sqlInsert4 . "<br>" . $conn->error;
															}
														}
														else
														{
															
														}
															
													}
													for($i=0;$i<count($serviceidm);$i++)
													{
														if($serviceidm[$i]!="")
														{
															$sqlDelete = "DELETE FROM tblAppointmentMembershipDiscount WHERE AppointmentID='".$appointment_id."' and OfferID!='0'";
														ExecuteNQ($sqlDelete);
															
															$sqlInsert4 = "Insert into tblAppointmentMembershipDiscount(AppointmentID, Id, ServiceID,MembershipID,MembershipAmount,DateTimeStamp,OfferAmount) values('".$appointment_id."','".$last_id."', '".$serviceidm[$i]."','".$memid[$i]."','".$discountm[$i]."','".$date."','0')";
													
															if ($DB->query($sqlInsert4) === TRUE) 
															{
																$last_idd = $DB->insert_id;		//last id of tblCustomers insert
															}
															else
															{
																echo "Error: " . $sqlInsert4 . "<br>" . $conn->error;
															}
														}
															 
													}
			
														$sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
														ExecuteNQ($sqlUpdate2);
	
	
														$sqlUpdate3 = "UPDATE tblAppointments SET Status = '2' WHERE AppointmentID='".$appointment_id."'";
														ExecuteNQ($sqlUpdate3);
														
	
					
													
													$sqlDelete = "DELETE FROM tblAppointmentlog WHERE appointment_id='".$appointment_id."'";
													ExecuteNQ($sqlDelete);
												  
													$sqlInsert1 = "Insert into tblAppointmentlog (appointment_id, invoice_name, appointment_date,store,status) values('".$appointment_id."','".$customer."', '".$appoint_date."','".$stores."','2')";
													$DB->query($sqlInsert1);
///////////////////////////////////////////////////////////////////////////////////
	  }
  elseif($type=='CompleteAmt')
	  {
												
												   $sqp=select("CustomerID","tblCustomers","CustomerFullName='".$CustomerFullName."'");
		                                           $cust=$sqp[0]['CustomerID'];
			
													$sqlInsert1 = "Insert into tblFreeServices(AppointmentId, Billaddress, InvoiceId,CustomerID,CustomerFullName,Email,Mobile,SubTotal,OfferAmt,Total,RoundTotal,CashAmount,TotalPayment,Flag,Membership_Amount,OfferDiscountDateTime,PendingAmount,AdminID) values('".$appointment_id."','".$billaddress."', '".$invoiceid."','".$customer."','".$CustomerFullName."','".$email."','".$mobile."','".$sub_total."','".$offeramtt."','".$total."','".$roundtotal."','".$roundtotal."','".$totalpayment."','Complete','".$membercost."','".$date."','".$totalpend."','".$strAdminID."')";

															if ($DB->query($sqlInsert1) === TRUE) 
															{
																$last_id = $DB->insert_id;		//last id of tblCustomers insert
															}
															else
															{
																echo "Error: " . $sql . "<br>" . $conn->error;
															}
			
  


														$sqlUpdate = "UPDATE tblFreeServices SET ServiceCode='".$servicecode1."',ServiceName='".$serviceid1."',Qty='".$qty1."',ServiceAmt='".$serviceamt1."',MembershipName='".$membershipname1."',Discount='".$Discount1."',DisAmt='".$disamt1."',ChargeName='".$chargename1."',ChargeAmount='".$chargeamount1."' WHERE AppointmentId='".$appointment_id."'";

															  if ($DB->query($sqlUpdate) === TRUE) 
															{
																$data=2;//last id of tblCustomers insert
															}
	
														$sqlUpdate2 = "UPDATE tblAppointmentsDetailsInvoice SET Status = '2' WHERE AppointmentID='".$appointment_id."'";

														ExecuteNQ($sqlUpdate2);
														
														
														$sqlUpdate3 = "UPDATE tblAppointments SET Status = '2' WHERE AppointmentID='".$appointment_id."'";

														ExecuteNQ($sqlUpdate3);
	
														$sqlDelete = "DELETE FROM tblAppointmentlog WHERE appointment_id='".$appointment_id."'";
														ExecuteNQ($sqlDelete);
														  
														$sqlInsert1 = "Insert into tblAppointmentlog (appointment_id, invoice_name, appointment_date,store,status) values('".$appointment_id."','".$customer."', '".$appoint_date."','".$stores."','2')";
														$DB->query($sqlInsert1);
///////////////////////////////////////////////////////////////////////////////////

							  
	}
						  
				
			
	}
				 
					
					
$DB->close();
echo $data;
	}
				
?>
 