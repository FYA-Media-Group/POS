<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$DB = Connect();
	$offervalue = $_POST["offervalue"];
    $app_id = $_POST["app_id"];
	$seldoffertt=select("*","tblAppointments","AppointmentID='".$app_id."'");
	
	$StoreIDd=$seldoffertt[0]['StoreID'];
	$memberid=$seldoffertt[0]['memberid'];
	$PackageID=$seldoffertt[0]['PackageID'];
	$VoucherID=$seldoffertt[0]['VoucherID'];
	$sepcont=select("count(*)","tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."' and PackageService='0'");
											   $cntserp=$sepcont[0]['count(*)'];
											   if($cntserp>0)
											   {
												   
												   
	if($memberid!="0")
	{
		$data=14;
	}
	else
	{
		if($offervalue=="")
		{
			$data=6;
		}
		else
		{
			$DB = Connect();
	$seldata=select("*","tblOffers","OfferID='$offervalue'");
    $off_id=$seldata[0]['OfferID'];
    $offerdateto=$seldata[0]['OfferDateTo'];
	$date=date('Y-m-d');
	$BaseAmount=$seldata[0]['BaseAmount'];
	if($off_id!="")
	{
		                              if($date==$offerdateto)
										{
											$data=8;
										}
										else
										{
                                             
		                                     	$seldoffer=select("*","tblAppointments","AppointmentID='".$app_id."'");
															
														    $StoreIDd=$seldoffer[0]['StoreID'];
															$memberid=$seldoffer[0]['memberid'];
															$CustomerID=$seldoffer[0]['CustomerID'];
                                                            $VoucherID=$seldoffer[0]['VoucherID'];
															$seldofferpt=select("*","tblGiftVouchers","GiftVoucherID='".$VoucherID."'");
															$status=$seldofferpt[0]['Status'];
															
	                                                    
														   $seldataptt=select("Status","tblCustomerMemberShip"," CustomerID='".$CustomerID."' and Status='1'");	
				                                              $statustf=$seldataptt[0]['Status']; 	
																			   
														/* 	$selpr=select("count(memberid)","tblCustomers","CustomerID='".$CustomerID."'");

															$cntm=$selpr[0]['count(memberid)']; */
													       $seldofferp=select("*","tblOffers","OfferID='".$off_id."'");
															$services=$seldofferp[0]['ServiceID'];
															$baseamt=$seldofferp[0]['BaseAmount'];
															$Type=$seldofferp[0]['Type'];
															$TypeAmount=$seldofferp[0]['TypeAmount'];
															$StoreID=$seldofferp[0]['StoreID'];
															$stores=explode(",",$StoreID);
														//	print_r($stores);
															$seldpdept=select("*","tblAppointmentsDetailsInvoice","AppointmentID='".$app_id."'");
															$servicessf=explode(",",$services);
															//print_r($servicessf);
															
																	if(in_array("$StoreIDd",$stores))
																	{
																		foreach($seldpdept as $val)
																		    {
																				$serviceid=$val['ServiceID'];
																				$amtt=$val['ServiceAmount'];
																					
																						 // print_r($serviceqty);
																					 $qtyyy=$val['qty'];
																					$totals=$qtyyy*$amtt;
																		if(in_array("$serviceid",$servicessf))
																		{
																		
																			if($baseamt!="")
																		   {
                                                                                 if($VoucherID!="0")
                                                                                   {
																					   if($status!='0')
																					   {
                                                                                          $data=10;
																					   }
																					   else
																					   {
																						   
                                                                                        if($totals>=$baseamt)
																							{
																								
																							if($memberid!="0")
																							{
																								
																							
																								
																								if($statustf=='1')
																								{
																									
					
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
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
																		$sqlUpdate2 = "UPDATE tblCustomers SET memberid='0',memberflag='0' WHERE CustomerID='".$CustomerID."'";
					ExecuteNQ($sqlUpdate2);
					  $sqlDelete1 = "DELETE FROM tblAppointmentsChargesInvoice WHERE AppointmentID='".$app_id."' and TaxGVANDM='0'";
					//  echo $sqlDelete;
		              ExecuteNQ($sqlDelete1);
					
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
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
																								
																								if($statustf=='1')
																								{
																											$sqlUpdate = "UPDATE tblAppointments SET offerid='".$off_id."' WHERE AppointmentID='".$app_id."'";
																		ExecuteNQ($sqlUpdate);
																		//  $DB->query($sqlInsert1); 
																		  if ($DB->query($sqlUpdate) === TRUE) 
																			{
																				//echo 3;
																			}
																
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
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
																			$sqlUpdate2 = "UPDATE tblCustomers SET memberid='0',memberflag='0' WHERE CustomerID='".$CustomerID."'";
					                                            ExecuteNQ($sqlUpdate2);
						  $sqlDelete1 = "DELETE FROM tblAppointmentsChargesInvoice WHERE AppointmentID='".$app_id."' and TaxGVANDM='0'";
					//  echo $sqlDelete;
		              ExecuteNQ($sqlDelete1);
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
					
					
										
																		$data=1;
																								}
																					
																							}
																									
																							}
																							else
																							{
																								$data=9;
																							}
																					   }
                                                                                    } 
                                                                                    else
                                                                                      {
                                                                                        if($totals>=$baseamt)
																							{
																								
																							if($memberid!="0")
																							{
																								
																								if($statustf=='1')
																								{
																										
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
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
																									$sqlUpdate2 = "UPDATE tblCustomers SET memberid='0',memberflag='0' WHERE CustomerID='".$CustomerID."'";
					ExecuteNQ($sqlUpdate2);
						  $sqlDelete1 = "DELETE FROM tblAppointmentsChargesInvoice WHERE AppointmentID='".$app_id."' and TaxGVANDM='0'";
					//  echo $sqlDelete;
		              ExecuteNQ($sqlDelete1);
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
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
																								
																								if($statustf=='1')
																								{
																													$sqlUpdate = "UPDATE tblAppointments SET offerid='".$off_id."' WHERE AppointmentID='".$app_id."'";
																		ExecuteNQ($sqlUpdate);
																		//  $DB->query($sqlInsert1); 
																		  if ($DB->query($sqlUpdate) === TRUE) 
																			{
																				//echo 3;
																			}
																		
					
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
						
										
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
																			$sqlUpdate2 = "UPDATE tblCustomers SET memberid='0',memberflag='0' WHERE CustomerID='".$CustomerID."'";
					                                            ExecuteNQ($sqlUpdate2);
					
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
						  $sqlDelete1 = "DELETE FROM tblAppointmentsChargesInvoice WHERE AppointmentID='".$app_id."' and TaxGVANDM='0'";
					//  echo $sqlDelete;
		              ExecuteNQ($sqlDelete1);
					
					  
																		$data=1;
																								}
																							
																							}
																									
																							}
																							else
																							{
																								$data=9;
																							}
                                                                                      }
                       

                                                                        
																			
							
																	
																		}
																		else
																		{
                                                                           if($VoucherID!="0")
                                                                                   {
                                                                                       if($status!='0')
																					   {
                                                                                          $data=10;
																					   }
																					   else
																					   {
																				if($memberid!="0")
																			   {
																				           if($statustf=='1')
																								{
																										
					
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
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
																															$sqlUpdate2 = "UPDATE tblCustomers SET memberid='0',memberflag='0' WHERE CustomerID='".$CustomerID."'";
					ExecuteNQ($sqlUpdate2);
					
						  $sqlDelete1 = "DELETE FROM tblAppointmentsChargesInvoice WHERE AppointmentID='".$app_id."' and TaxGVANDM='0'";
					//  echo $sqlDelete;
		              ExecuteNQ($sqlDelete1);
					
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
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
																			     	       if($statustf=='1')
																								{
																												$sqlUpdate = "UPDATE tblAppointments SET offerid='".$off_id."' WHERE AppointmentID='".$app_id."'";
																		ExecuteNQ($sqlUpdate);
																		//  $DB->query($sqlInsert1); 
																		  if ($DB->query($sqlUpdate) === TRUE) 
																			{
																				//echo 3;
																			}
																		
					
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
					
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
																			$sqlUpdate2 = "UPDATE tblCustomers SET memberid='0',memberflag='0' WHERE CustomerID='".$CustomerID."'";
					                                            ExecuteNQ($sqlUpdate2);
					
					  $sqlDelete1 = "DELETE FROM tblAppointmentsChargesInvoice WHERE AppointmentID='".$app_id."' and TaxGVANDM='0'";
					//  echo $sqlDelete;
		              ExecuteNQ($sqlDelete1);
					
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
					
					
																		$data=1;
																								}
																									
																			
																			}
																			
																					   }
                                                                                    } 
                                                                                  else
                                                                                    {
                                                                            if($memberid!="0")
																			{
																				           if($statustf=='1')
																								{
																									
					
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
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
																									$sqlUpdate2 = "UPDATE tblCustomers SET memberid='0',memberflag='0' WHERE CustomerID='".$CustomerID."'";
					ExecuteNQ($sqlUpdate2);
					
					  $sqlDelete1 = "DELETE FROM tblAppointmentsChargesInvoice WHERE AppointmentID='".$app_id."' and TaxGVANDM='0'";
					//  echo $sqlDelete;
		              ExecuteNQ($sqlDelete1);
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
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
																				        if($statustf=='1')
																								{
																												
																						$sqlUpdate = "UPDATE tblAppointments SET offerid='".$off_id."' WHERE AppointmentID='".$app_id."'";
																		ExecuteNQ($sqlUpdate);
																		//  $DB->query($sqlInsert1); 
																		  if ($DB->query($sqlUpdate) === TRUE) 
																			{
																				//echo 3;
																			}
																		
					
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
					
					
										
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
																			$sqlUpdate2 = "UPDATE tblCustomers SET memberid='0',memberflag='0' WHERE CustomerID='".$CustomerID."'";
					                                            ExecuteNQ($sqlUpdate2);
					
					  $sqlDelete1 = "DELETE FROM tblAppointmentsChargesInvoice WHERE AppointmentID='".$app_id."' and TaxGVANDM='0'";
					//  echo $sqlDelete;
		              ExecuteNQ($sqlDelete1);
			    $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
					
												
																		$data=1;
																								}
																			
																			}
																			
                                                                                    }
																			
																
																		
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
																		
	}
	else
	{
		$data=2;
	}
	
	$DB->close();
		}
	}
											   }
                                              else
											  {
												 	      if($VoucherID!="0")
																	{
																		$data=15;
																	}
																elseif($PackageID!='0')
																   {
																	   $data=20;
																   }
											  }												  

		

	
	echo $data;
?>

					
