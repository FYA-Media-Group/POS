<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>


<?php

	$offervalue = $_POST["offervalue"];
		$app_id = $_POST["app_id"];
		$DB = Connect();
			 $sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."'");
											   $cntserp=$sepcont[0]['count(*)'];
											   if($cntserp>0)
											   {
												   		if($offervalue=="")
		{
			$data=6;
		}
		else
		{
			
	$seldata=select("*","tblOffers","OfferCode='$offervalue'");
   $off_id=$seldata[0]['OfferID'];
	$BaseAmount=$seldata[0]['BaseAmount'];
	$seldoffer=select("*","tblAppointments","AppointmentID='".$app_id."'");
	$offerid=$seldoffer[0]['offerid'];
	if($offerid==$off_id)
	{
		$data=5;
	}
	else
	{
		                                      $StoreIDd=$seldoffer[0]['StoreID'];
															
													$seldofferp=select("*","tblOffers","OfferID='".$off_id."'");
															$services=$seldofferp[0]['ServiceID'];
															$baseamt=$seldofferp[0]['BaseAmount'];
															$Type=$seldofferp[0]['Type'];
															$TypeAmount=$seldofferp[0]['TypeAmount'];
															$StoreID=$seldofferp[0]['StoreID'];
															$stores=explode(",",$StoreID);
															$seldpdept=select("*"," tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."'");
															$servicessf=explode(",",$services);
														//	print_r($servicessf);
																	if(in_array("$StoreIDd",$stores))
																	{
																		foreach($seldpdept as $val)
																		    {
																				$serviceid=$val['ServiceID'];
																			
																				if(in_array("$serviceid",$servicessf))
																		       {
																				if($baseamt!="")
																				{
							
																		 $sqlUpdate = "UPDATE tblAppointments SET offerid='".$off_id."' WHERE AppointmentID='".$app_id."'";
																		ExecuteNQ($sqlUpdate);
																		//  $DB->query($sqlInsert1); 
																		  if ($DB->query($sqlUpdate) === TRUE) 
																			{
																				//echo 3;
																			}
																		$data=1;
																				}
																				else
																				{
																				$sqlUpdate = "UPDATE tblAppointments SET offerid='".$off_id."' WHERE AppointmentID='".$app_id."'";
																		ExecuteNQ($sqlUpdate);
																		//  $DB->query($sqlInsert1); 
																		  if ($DB->query($sqlUpdate) === TRUE) 
																			{
																				//echo 3;
																			}
																		   $data=1;
																		}
																		}
																		else
																		{
																			$data=3;
																				//$data="Offer Not Applicable For Any Of This Services";
																		}
																			}	  
																		
																		
																		
																		
																	}
																	else
																	{
																		$data=4;
																	}
	}
	
	
	$DB->close();
		}
											   }
											   else
											   {
												   
											   }

	
	echo $data;
?>

					
