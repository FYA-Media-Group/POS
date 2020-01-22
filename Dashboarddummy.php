<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
			$DB = Connect();
			// echo $strAdminID;
			// echo "hello";
			$FindStore="Select StoreID from tblAdminStore where AdminID=$strAdminID";
			echo $FindStore."<br>";
			$RSf = $DB->query($FindStore);
			if ($RSf->num_rows > 0) 
			{
				while($rowf = $RSf->fetch_assoc())
				{
					$strStoreID = $rowf["StoreID"];
					// echo $strStoreID."<br>";
					// echo "Hello";
				}
			}
?>







<a href="Dashboarddummy.php?opening=1" class="btn btn-primary">Day Opening</a>

<?php			

if(isset($_GET['opening']))
{
	$GetUID=$_GET["opening"];
	$UpdateOpenTime="Insert into tblOpenNClose(DateNTime,OpenTime,AdminID,StoreID,Status)VALUES(Now(),now(),'".$strAdminID."',2,1)";
	// echo $UpdateOpenTime."<br>";
	// ExecuteNQ($UpdateOpenTime);
	// echo("<script>location.href='SMSApproval.php';</script>"); 
	
?>				
				
					
<?php
	$Thisdate=date("y-m-d");
	// echo $Thisdate."<br>";
	$DB = Connect();
	$insertopen="SELECT CloseTime FROM `tblOpenNClose` WHERE `DateNTime`='$Thisdate'";
	echo $insertopen."<br>";
		$RSf = $DB->query($insertopen);
		if ($RSf->num_rows > 0) 
		{
			while($rowf = $RSf->fetch_assoc())
			{
				$strCloseTime = $rowf["CloseTime"];
				echo $strCloseTime."<br>";
			}
		}
		if($strCloseTime=='0000-00-00 00:00:00')
		{
?>
			<button class="btn btn-default btn-md" data-toggle="modal" data-target="#myModal">Day Closing</button>			
					   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						   <div class="modal-dialog">
							   <div class="modal-content">
								   <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									   <h4 class="modal-title">Day Closing Details for <?=$strStoreNamedisplay?></h4></div>
								   <div class="modal-body">
									   <p>
											<?php
											
											$getTodaysDate = date("Y-m-d");
											
											$DB = Connect();
											
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
												
												
											$sqlc="select Sum(tblInvoiceDetails.TotalPayment) as Total, tblAppointments.StoreID, tblInvoiceDetails.Flag
														from tblInvoiceDetails 
														left join tblAppointments 
														on tblInvoiceDetails.AppointmentID=tblAppointments.AppointmentID
														where Date(tblInvoiceDetails.OfferDiscountDateTime)=Date('$getTodaysDate') and tblAppointments.StoreID ='$strStore' group by tblInvoiceDetails.Flag";

											$RSc = $DB->query($sqlc);
											if ($RSc->num_rows > 0) 
											{
												while($rowsc = $RSc->fetch_assoc())
												{
													$strAmount = $rowsc["Total"];
													$strFlag = $rowsc["Flag"];
													if($strFlag =="C")
													{
														echo "<b>Total paid in Card : Rs. $strAmount/ - </b> <br> ";
													}
													elseif($strFlag =="CS")	
													{
														echo "<b>Total paid in Cash : Rs. $strAmount/ - </b> <br>";
													}
													elseif($strFlag =="B")
													{
														echo "<b>Total paid using Both : Rs. $strAmount/ - </b> <br>";
													}
													elseif($strFlag =="H")
													{
														echo "<b>Total Hold/Balance Today : Rs. $strAmount/ - </b> <br>";
													}
													else
													{
														
													}
													
												}
											}	
										
											$DB->close();
											
											?>
									   </p>
								   </div>
								   <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button> <a href="#" class="btn btn-primary">Send Employee reconcilation</a> <a href="EnvelopeCreateandVerify.php?sid=<?=$strStore?>" class="btn btn-primary">Close & Create Envelope</a></div>
							   </div>
						   </div>
					   </div>
<?php						
		}
?>							
		
<?php 
}				
?>						   