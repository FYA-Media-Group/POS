<?php
			$DB = Connect();
			// echo $strAdminID;
			// echo "hello";
			$FindStore="Select StoreID from tblAdminStore where AdminID=$strAdminID";
			// echo $FindStore;
			$RSf = $DB->query($FindStore);
			if ($RSf->num_rows > 0) 
			{
				while($rowf = $RSf->fetch_assoc())
				{
					$strStoreID = $rowf["StoreID"];
					// echo $strStoreID;
					// echo "Hello";
				}
			}
?>

<?php			

if(isset($_GET['opening']))
{
	
	$date=date('Y-m-d H:i:s');
	$onlydate=date('y-m-d');
	$timestamp =  date("H:i:s", time());
	$GetUID=$_GET["opening"];
	$DB = Connect();
		// $selp=select("count(*)","tblOpenNClose","StoreID='$strStoreID' and Status='1' and DateNTime='".$date."'");
		// $selp=select("count(*)","tblOpenNClose","StoreID='$strStoreID' and DateNTime='".$date."'");
			// $cnt=$selp[0]['count(*)'];
			// if($cnt>0)
			// {
				
			// }
			$insertopen="SELECT * FROM `tblOpenNClose` WHERE `DateNTime`='$onlydate' and StoreID='$strStoreID'";
			// echo $insertopen."<br>";
			$RSf = $DB->query($insertopen);
			if ($RSf->num_rows > 0) 
			{
				// echo "In if No Execution<br>";
			}
			else
			{
					$UpdateOpenTime="Insert into tblOpenNClose(DateNTime,OpenTime,AdminID,StoreID,Status)VALUES('".$date."','".$date."','".$strAdminID."','".$strStoreID."',1)";
						//echo $UpdateOpenTime;
					 //echo $UpdateOpenTime."<br>";
					ExecuteNQ($UpdateOpenTime);
					
					  $seldpdep=select("*","tblStores","StoreID='".$StoreID."'");
				    $StoreName=$seldpdep[0]['StoreName'];
					$seldpdepaa=select("*","tblAdmin","AdminID='".$strAdminID."'");
				    $AdminFullName=$seldpdepaa[0]['AdminFullName'];
					$Content="Nailspa Day Opening ".date('d-m-Y h:i A', strtotime($date))." at ".$StoreName." by ".$AdminFullName."";
					$my='9870975726';
					//$my='8097910447';
					$SendSMS = CreateSMSURL("Nailspa","0","0",$Content,$my);	
					$strTo="operations@nailspaexperience.com,noor@nailspaexperience.com";
					//$strTo="yogitafya@hotmail.com,vinayfya@hotmail.com";
					if($strTo=="")
					{
						echo "Email Id Cannot Blank";
					}
					else
					{
							
							$strFrom = "DayOpening@nailspaexperience.com";
							//$strFrom = "DayOpening@spotlightindia.in";
							
							$strSubject = "Day Opening";
							
							$strbody1="<html><head><title>Day Open</title></head><body>Nailspa Day Opening ".date('d-m-Y h:i A', strtotime($date))." at ".$StoreName." by ".$AdminFullName."</body></html>";
							$headers = "From: $strFrom\r\n";
							$headers .= "Content-type: text/html\r\n";
							$strBodysa = $strbody1;
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
			}

	// die();
	// echo("<script>$('#OpenDay').hide();</script>"); 
echo("<script>location.href='Salon-Dashboard.php';</script>"); 
	
}
?>				
	<script>
	// function select()
	// {
		// alert(42);
			// $('#OpenDay').hide();
	// }
	
	</script>
	
	
	<!-- Added by Saif on 11-04-2017 due to adding of multiple day opening entry fix -->
	<script>
	function disablelink()
	{
		document.getElementById("OpenDay").className += " disabled";
	}

	</script>	

<?php
		
		// $DB = Connect();
		// $Thisdate=date("y-m-d");
		$insertclose="SELECT OpenTime FROM `tblOpenNClose` WHERE `DateNTime`='$Thisdate' and StoreID='$strStoreID'";
		// echo $insertopen."<br>";
			$RSf = $DB->query($insertclose);
			if ($RSf->num_rows > 0) 
			{
				while($rowf = $RSf->fetch_assoc())
				{
					$OpenTime = $rowf["OpenTime"];
					// echo $OpenTime."<br>";
				}
			}
?>
			<?php 
			$date=date('y-m-d');
			// $selp=select("count(*)","tblOpenNClose","StoreID='$strStoreID' and Status='2' and DateNTime='".$date."'");
			// $cnt=$selp[0]['count(*)'];
			// if($cnt>0)
			// {
				
			// }
			$DB = Connect();
			$onlydate=date('y-m-d');
		$insertopen="SELECT * FROM `tblOpenNClose` WHERE `DateNTime`='$onlydate' and StoreID='$strStoreID'";
		// echo $insertopen."<br>";
			$RSf = $DB->query($insertopen);
			if ($RSf->num_rows > 0) 
			{
				// echo "In if<br>";
			}
			else
			{
				
				?>
				<a href="Dashboard.php?opening=1" class="btn btn-lg btn-primary" id="OpenDay" onClick="disablelink();" >Day Opening</a>
				<?php
			}
			?>

			
	


	
					
<?php
	$Thisdate=date("y-m-d");
	// echo $Thisdate."<br>";
	 $DB = Connect();
	$insertopen="SELECT CloseTime, OpenTime FROM `tblOpenNClose` WHERE `DateNTime`='$Thisdate' and StoreID='$strStoreID'";
	// echo $insertopen."<br>";
		$RSf = $DB->query($insertopen);
		if ($RSf->num_rows > 0) 
		{
			while($rowf = $RSf->fetch_assoc())
			{
				$strCloseTime = $rowf["CloseTime"];
				$strOpenTime = $rowf["OpenTime"];
				// echo $strCloseTime."<br>";
			}
		}
		if($strCloseTime=='0000-00-00 00:00:00' && $strOpenTime!='0000-00-00 00:00:00')
		{
			// echo "In if<br>";
			  $selpt=select("count(*)","tblAppointments","StoreID='$strStoreID' and Status='0' and AppointmentDate='".$Thisdate."'");
			$cnter=$selpt[0]['count(*)'];
			if($cnter>0)
			{
			
			}
			else
			{
					?>
						<button class="btn btn-lg btn-primary" data-toggle="modal" data-target="#myModal">Day Closing</button>	
						
				<?php
				
			}
?>			
	

					
					   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						   <div class="modal-dialog">
							   <div class="modal-content">
								   <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									   <h4 class="modal-title">Day Closing Details for <?=$strStoreNamedisplay?></h4></div>
								   <div class="modal-body">
									   <p>
<?php
											echo("<script>$('#OpenDay').hide();</script>"); 
											$getTodaysDate = date("Y-m-d");
											
											$sqltotal="select Sum(tblInvoiceDetails.TotalPayment) as Total, tblAppointments.StoreID
														from tblInvoiceDetails 
														left join tblAppointments 
														on tblInvoiceDetails.AppointmentID=tblAppointments.AppointmentID
														where Date(tblInvoiceDetails.OfferDiscountDateTime)=Date('$getTodaysDate') and tblAppointments.StoreID ='$strStore'";
											
											$RSTotal = $DB->query($sqltotal);
											if ($RSTotal->num_rows > 0) 
											{
												while($rowstotal = $RSTotal->fetch_assoc())
												{
													$strtotal = $rowstotal["Total"];
												}
											}
											else
											{
												$strtotal = "0";
											}
												echo "<b>Total Sales Today : Rs. $strtotal/ - </b> <br>";
												
												
											$sqlc="select Sum(tblInvoiceDetails.CardAmount) as CardAmount
														from tblInvoiceDetails 
														left join tblAppointments 
														on tblInvoiceDetails.AppointmentID=tblAppointments.AppointmentID
														where Date(tblInvoiceDetails.OfferDiscountDateTime)=Date('$getTodaysDate') and tblAppointments.StoreID ='$strStore'";
														
														// SELECT tblInvoiceDetails.`CardAmount` AS CardAmount
														// FROM tblInvoiceDetails
														// LEFT JOIN tblAppointments ON tblInvoiceDetails.AppointmentID = tblAppointments.AppointmentID
														// WHERE DATE( tblInvoiceDetails.OfferDiscountDateTime ) = DATE(  '2016-12-20' ) 
														// AND tblAppointments.StoreID =  '4'
														// LIMIT 0 , 30
														
											// if($_SERVER['REMOTE_ADDR']=="111.119.219.70")
											// {
												// echo $sqltotal;
											// }
											// else
											// {
												
											// }
														
											$SelectTotalTax="SELECT SUM( tblAppointmentsChargesInvoice.ChargeAmount ) AS ChargeAmount
														FROM  `tblAppointmentsChargesInvoice` 
														LEFT JOIN tblAppointments ON tblAppointmentsChargesInvoice.AppointmentID = tblAppointments.AppointmentID
														WHERE tblAppointments.AppointmentDate = '$getTodaysDate'
														AND tblAppointments.StoreID =  '$strStoreID'";
											// echo $SelectTax."<br>";
											$RSSTAX1 = $DB->query($SelectTotalTax);
											if ($RSSTAX1->num_rows > 0) 
											{
												while($rowTX1 = $RSSTAX1->fetch_assoc())
												{
													$ChargeAmount = $rowTX1["ChargeAmount"];
													// echo $ChargeAmount."<br>";
												}
											}
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
											
											// $RSc = $DB->query($sqlc);
											// if ($RSc->num_rows > 0) 
											// {
												// while($rowsc = $RSc->fetch_assoc())
												// {
													// $strAmount = $rowsc["Total"];
													// $strFlag = $rowsc["Flag"];
													// if($strFlag =="C")
													// {
														// echo "<b>Card : Rs. $strAmount/ - </b> <br> ";
													// }
													// elseif($strFlag =="CS")	
													// {
														// if($strAmount>$ChargeAmount)
														// {
															// $strAmount=$strAmount-$ChargeAmount;
															// echo "<b>Cash : Rs. $strAmount/ - </b> <br>";
														// }
													// }
													// elseif($strFlag =="B")
													// {
														// echo "<b>Both : Rs. $strAmount/ - </b> <br>";
													// }
													// elseif($strFlag =="H")
													// {
														// echo "<b>Balance Today : Rs. $strAmount/ - </b> <br>";
													// }
													// else
													// {
														
													// }
													
												// }
											// }
											
											$RSc = $DB->query($sqlc);
											if ($RSc->num_rows > 0) 
											{
												while($rowsc = $RSc->fetch_assoc())
												{
													$CardAmount = $rowsc["CardAmount"];
													// $strFlag = $rowsc["Flag"];
													// $strFlag = $rowsc["C"];
													// $strFlag = $rowsc["CS"];
													echo "<b>Card : Rs. $CardAmount/ - </b> <br> ";
													
												}
											}
											$sqlcs="select Sum(tblInvoiceDetails.CashAmount) as CashAmount
														from tblInvoiceDetails 
														left join tblAppointments 
														on tblInvoiceDetails.AppointmentID=tblAppointments.AppointmentID
														where Date(tblInvoiceDetails.OfferDiscountDateTime)=Date('$getTodaysDate') and tblAppointments.StoreID ='$strStore'";
											$RScs = $DB->query($sqlcs);
											if ($RScs->num_rows > 0) 
											{
												while($rowscs = $RScs->fetch_assoc())
												{
													$CashAmount = $rowscs["CashAmount"];
													// $strFlag = $rowsc["Flag"];
													// $strFlag = $rowsc["C"];
													// $strFlag = $rowsc["CS"];
													echo "<b>Cash : Rs. $CashAmount/ - </b> <br> ";
												}
											}
											
											
											// echo "<b>Total Tax : Rs. $ChargeAmount/ - </b> <br>";
										
											$DB->close();
											
?>
									   </p>
									   <p><font color='red'>Please note you wont be able to book or work on any appointment after Day Closing</font></p>
								   </div>
								   <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button> <a href="EnvelopeCreateandVerify.php?sid=<?=$strStore?>" class="btn btn-primary">Close & Create Envelope</a></div>
							   </div>
						   </div>
					   </div>
<?php						
				// echo("<script>location.href='Dashboard.php';</script>"); 
		}
?>		
<a class="btn btn-border btn-lg btn-alt border-primary font-primary" href="Petty-Cash-Spent-and-Balance.php" title=""><span>
<?php
$DB = Connect();
$thisDate=date("Y-m-d");
$First= date('Y-m-01');
$Last= date('Y-m-t');
$sql = "SELECT StoreID,Amount,ExpenseType,DateOfExpense,Remark,DateOfExpense,
		(Select Balance from tblExpensesBalance where StoreID=tblExpenses.StoreID and tblExpenses.Status!='1' and tblExpenses.Amount!='NULL' and tblExpenses.StoreID='$strStore') as Bal FROM tblExpenses where Amount!='NULL' and StoreID='$strStore' and Status!='1' and Date(DateOfExpense)>=Date('$First') and Date(DateOfExpense)<=Date('$Last')";
$RS = $DB->query($sql);

if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$Amount = $row["Amount"];
		
		if($Amount =="")
		{
			$Amount ="0.00";
		}
		else
		{
		
			$Amount = $Amount;
			
		}
		$TotalSPENTAmount += $Amount;
	}
	
}
		
		
		
		$SelectPettyCashBalance="Select Balance from tblExpensesBalance where StoreId='$strStore'";
// echo $SelectPettyCashBalance;
$RSpetty = $DB->query($SelectPettyCashBalance);
		if ($RSpetty->num_rows > 0) 
		{
			while($rowPetty = $RSpetty->fetch_assoc())
			{
				$strBalance = $rowPetty["Balance"];
				if($strBalance=="")
				{
					$strBalance='0';
					$TotalSPENTAmount='0';
					echo "Petty Balance Rs.&nbsp".$strBalance."&nbsp Spent Rs.&nbsp".$TotalSPENTAmount;
				}
				else
				{
					echo "Petty Balance Rs.&nbsp".$strBalance."&nbsp Spent Rs.&nbsp".$TotalSPENTAmount;
				}
				
			}
		}
		else
		{
			echo "Petty Cash Spent Rs. 0";
		}
?>
</span><div class="ripple-wrapper"></div></a>	
<?php
/* if($_SERVER['REMOTE_ADDR']=="111.119.219.70")
			{
				echo $sql;
			}
			else
			{
				
			} */					
			?>
<a class="btn btn-border btn-lg btn-alt border-primary font-primary" href="#" title=""><span>
<?php
$DB = Connect();
$thisDate=date("y-m-d");
$CurrentMonth=date('F'); 
$CurrentYear=date('Y'); 
$asmita=date("n",strtotime($CurrentMonth));
									$d=cal_days_in_month(CAL_GREGORIAN,$asmita,$CurrentYear);
									
								
									$SelectTarget="Select TargetAmount from tblStoreSalesTarget where Month='$CurrentMonth' and Year='$CurrentYear' and StoreID='$strStore'";
								
									$RSTarget = $DB->query($SelectTarget);
	
									if ($RSTarget->num_rows > 0) 
									{
										while($rowTarget = $RSTarget->fetch_assoc())
										{
											$Target = $rowTarget["TargetAmount"];										
										}
									}
									$averatesalesperday=$Target/$d;
									$averatesalesperdayt=round($averatesalesperday);
									
									if($averatesalesperdayt=="")
									{
										echo "Average Daily Sales <b>Rs.0</b>";
									}
									else
									{
										echo "Average Daily Sales <b>Rs.$averatesalesperdayt</b>";
									}
									

?>
</span><div class="ripple-wrapper"></div></a>		

<a class="btn btn-border btn-lg btn-alt border-primary font-primary" href="#" title=""><span style="color:#e80c0c; font-size: 14px">
<?php
$DB = Connect();
$CurrentMonth=date('F'); 
	$CurrentYear=date('Y'); 
$asmita=date("n",strtotime($CurrentMonth));
									$d=cal_days_in_month(CAL_GREGORIAN,$asmita,$CurrentYear);
	                           $previousdate=date('Y-m-d',strtotime("-1 days"));
									$Last= date('Y-m-t');
									
									$TotalMonthSale="Select tblAppointments.StoreID,
												SUM(tblInvoiceDetails.TotalPayment) as TOTALMonthly
												from tblAppointments
											Left join tblInvoiceDetails
											ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID
											WHERE tblAppointments.StoreID='$strStore' and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('$First') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('$previousdate')";
											// echo $TotalMonthSale."<br>";
											
									$RSMonthsale = $DB->query($TotalMonthSale);
									if ($RSMonthsale->num_rows > 0) 
									{
										while($rowMonthTarget = $RSMonthsale->fetch_assoc())
										{
											$TOTALMonthly = $rowMonthTarget["TOTALMonthly"];										
										}
									}
							
									$Remainingsales=$Target-$TOTALMonthly;	
										$today = new DateTime();

								$lastDayOfThisMonth = new DateTime('last day of this month');
                                $nbOfDaysRemainingThisMonth =  $lastDayOfThisMonth->diff($today)->format('%a');
							
                                 if($nbOfDaysRemainingThisMonth=='0')
								 {
									 $nbOfDaysRemainingThisMonth=1;
								 }
								
							$Remainingsalest=$Remainingsales/$nbOfDaysRemainingThisMonth;
									$Remainingsalestmt=round($Remainingsalest);
									if($Remainingsalestmt=="")
									{
										$Remainingsalestmt='0';
					echo "Today's Target<b>&nbspRs.&nbsp&nbsp0</b>";
									}
									elseif($Remainingsalestmt<0)
									{
										$Remainingsalestmt='0';
					echo "Today's Target<b>&nbspRs.&nbsp&nbsp0</b>";
									}
									else
									{
										echo "Today's Target<b>&nbspRs.&nbsp".$Remainingsalestmt."</b>";
									}

?>
</span><div class="ripple-wrapper"></div></a>
&nbsp;

<a class="" href="#" title=""><span>
<?php
$DB = Connect();

$CurrentMonth=date('F'); 
$CurrentYear=date('Y'); 
$asmita=date("n",strtotime($CurrentMonth));
									$d=cal_days_in_month(CAL_GREGORIAN,$asmita,$CurrentYear);
	                                $First= date('Y-m-01');
									$Last= date('Y-m-t');
 
									
									           $TotalMonthSale="Select tblAppointments.StoreID,
												SUM(tblInvoiceDetails.TotalPayment) as TOTALMonthly
												from tblAppointments
											Left join tblInvoiceDetails
											ON tblAppointments.AppointmentID=tblInvoiceDetails.AppointmentID
											WHERE tblAppointments.StoreID='$strStore' and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('$First') and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('$Last')";
											// echo $TotalMonthSale."<br>";
									$RSMonthsale = $DB->query($TotalMonthSale);
									if ($RSMonthsale->num_rows > 0) 
									{
										while($rowMonthTarget = $RSMonthsale->fetch_assoc())
										{
											$TOTALMonthly = $rowMonthTarget["TOTALMonthly"];										
										}
									}
							
									$Remainingsales=$Target-$TOTALMonthly;	
										$today = new DateTime();

								$lastDayOfThisMonth = new DateTime('last day of this month');

								$nbOfDaysRemainingThisMonth =  $lastDayOfThisMonth->diff($today)->format('%a');
                                	 if($nbOfDaysRemainingThisMonth=='0')
								 {
									 $nbOfDaysRemainingThisMonth=1;
								 }
 									$Remainingsalest=$Remainingsales/$d;
									$AvgDaily=round($Remainingsalest);
						
 									$Remainingsalest=$Remainingsales/$nbOfDaysRemainingThisMonth;
									$todaytarget=round($Remainingsalest);
									if($todaytarget==$averatesalesperdayt)
									{
									?>
										<span><img src="<?=FindHostAdmin();?>/images/happy.png" style="margin-bottom: -15px;" height="47"/> <b>Good keep going!</b></span>
									<?php
									}
									elseif($todaytarget>$averatesalesperdayt)
									{
									?>
										<img src="<?=FindHostAdmin();?>/images/sad.png" style="margin-bottom: -15px;" height="47"/> <span style="color:red;"><b>Work hard on monthly target!</b></span>
									<?php
									}
									elseif($todaytarget<$averatesalesperdayt)
									{
									?>
										<img src="<?=FindHostAdmin();?>/images/rich.png" style="margin-bottom: -15px;" height="47"/> <span style="color:green;"><b>Hurray! Going good..</b></span>
									<?php
									}
?>
</span><div class="ripple-wrapper"></div></a>	
