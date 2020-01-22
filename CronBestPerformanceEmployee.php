<?php require_once("setting.fya"); ?>

<?php
		$DB = Connect(); 
	
		$sqlp="delete from tblCronEmployeePerformance where StoreID!='0'";
		ExecuteNQ($sqlp);
	   
	   $First= date('Y-m-01');
       $Last= date('Y-m-t');
		$date=date('Y-m-d');
		$coldata=array();
		$coldata=array('#FF0F00','#FF6600','#FF9E01','#FCD202','#F8FF01','#B0DE09','#04D215','#0D8ECF','#0D52D1','#2A0CD0','#8A0CCF','#CD0D74');
	        $sty = select("EID, EmployeeName, EmployeeEmailID, EmpPercentage, EmployeeMobileNo","tblEmployees","StoreID!=''");
								foreach($sty as $sq)
								{
									
									$sqldetailsqw = "SELECT tblAppointmentAssignEmployee.AppointmentID,
															tblAppointmentAssignEmployee.Qty,
															tblAppointmentAssignEmployee.ServiceID,
															tblAppointmentAssignEmployee.Commission, 
															tblAppointmentAssignEmployee.QtyParam,
															tblInvoiceDetails.OfferDiscountDateTime,tblEmployees.StoreID, 
															(select ServiceAmount from tblAppointmentsDetailsInvoice where AppointmentID=tblAppointmentAssignEmployee.AppointmentID and ServiceID=tblAppointmentAssignEmployee.ServiceID Limit 0,1) as ServiceAmount 
															FROM tblEmployees left join tblAppointmentAssignEmployee on tblEmployees.EID = tblAppointmentAssignEmployee.MECID 
															left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentId= tblAppointmentAssignEmployee.AppointmentID 
															left join tblInvoiceDetails on tblAppointmentAssignEmployee.AppointmentID=tblInvoiceDetails.AppointmentId 
															where tblEmployees.EID='".$sq['EID']."' 
															and tblAppointmentAssignEmployee.AppointmentID!='NULL' 
															and tblInvoiceDetails.OfferDiscountDateTime!='NULL' 
															and Date(tblInvoiceDetails.OfferDiscountDateTime)>='$First' and Date(tblInvoiceDetails.OfferDiscountDateTime)<='$Last'
															and tblEmployees.EID not In('43',49) group by tblAppointmentAssignEmployee.AppointmentID,ServiceID,QtyParam";
												
												$RSdetailsq = $DB->query($sqldetailsqw);
												if($RSdetailsq->num_rows > 0) 
												{
													while($rowdetailsty = $RSdetailsq->fetch_assoc())
													{
														$FandFSalest="";
														$strEIDa = $rowdetailsty["EID"];
														$strAID = $rowdetailsty["AppointmentID"];
														$strSID = $rowdetailsty["ServiceID"];
														$qty1 = $rowdetailsty["Qty"];
														$strAmount = $rowdetailsty["ServiceAmount"];
														$strSAmountt = $strAmount;
														$strCommissiont = $rowdetailsty["Commission"];
														$StoreIDd = $rowdetailsty["StoreID"];
														
														$strTotalAmount += $strSAmountt;  //Total of Service sale amount
														
														// Service Name Yogita query
														$per=$_GET["per"];
														
														// Store Name Yogita query						
														$stpp=select("StoreName","tblStores","StoreID='".$StoreIDd."'");
														$StoreName=$stpp[0]['StoreName'];
														
														// Invoice no Yogita query
														$sql_invoice_number = select("InvoiceID","tblInvoice","AppointmentID='".$strAID."'");
														$Invoice_Number=$sql_invoice_number[0]['InvoiceID'];
														
														// Customer ID Yogita query
														$sql_customer = select("CustomerID,AppointmentDate","tblAppointments","AppointmentID='".$strAID."'");
														$CustomerID=$sql_customer[0]['CustomerID'];
														$AppointmentDate=$sql_customer[0]['AppointmentDate'];
														
														
														// Customer name Yogita query
														$sql_customers = select("CustomerFullName","tblCustomers","CustomerID='".$CustomerID."'");
														$CustomerFullName=$sql_customers[0]['CustomerFullName'];
														
														
														if($strCommissiont=="1")
														{
															$AfterDivideSalet = $strSAmountt;
															$strCommissionType = '<span class="bs-label label-success">Alone</span>';
														}
														elseif($strCommissiont=="2")
														{
															$AfterDivideSalet = ($strSAmountt / 2);
															$strCommissionType = '<span class="bs-label label-blue-alt">Split</span>';
														}
														$TotalAfterDivideSalet += $AfterDivideSalet;  //Total of Final payment
														
														// discount code
														$sqldiscount ="select OfferAmount, MemberShipAmount from tblAppointmentMembershipDiscount where AppointmentID='$strAID' and ServiceID='$strSID'";
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
														
														$FinalDiscount = $FinalDAmount / $qty1;
														$TotalFinalDiscount += $FinalDiscount;	//Total of discounted amount
													
														  
														$UltimateSale = $AfterDivideSalet - $FinalDiscount;
														$TotalUltimateSale += $UltimateSale;	//Total of discounted amount
														
													
														
														//Calculation for commission
														if($strCommission == "1")
														{
															$CommssionFinal = ($UltimateSale / 100) * $strEmpPercentage;
														}
														elseif($strCommission == "2")
														{
															$CommssionFinal = ($UltimateSale / 200) * $strEmpPercentage;
														}
														
														$ComFinal += $CommssionFinal;	//Total of Commission
														$FandFSalest += $TotalUltimateSale;
														$FandFComm += $ComFinal;
														
													}
												}
								}
								$sql = "select EID, EmployeeName, EmployeeEmailID, EmpPercentage, EmployeeMobileNo from tblEmployees where StoreID!='0'";
				//echo $sql;


								$RS = $DB->query($sql);
								if($RS->num_rows > 0) 
								{
									while($row = $RS->fetch_assoc())
									{
										$strEID = $row["EID"];
										
										if($strEID=="0")
										{
											// List of managers, HO and Audit whose details need not to be shown
										}
										else
										{
											$strEmployeeName = $row["EmployeeName"];
											$strEmployeeEmailID = $row["EmployeeEmailID"];
											$strEmpPercentage = $row["EmpPercentage"];
											$strEmployeeMobileNo = $row["EmployeeMobileNo"];
											
											$TotalAfterDivideSale = '';
											$strTotalAmount = '';
											$TotalFinalDiscount ='';
											$TotalUltimateSale ='';
											$ComFinal ='';
											
											
											$sqldetails = "SELECT tblAppointmentAssignEmployee.AppointmentID,
															tblAppointmentAssignEmployee.Qty,
															tblAppointmentAssignEmployee.ServiceID,
															tblAppointmentAssignEmployee.Commission, 
															tblAppointmentAssignEmployee.QtyParam,
															tblInvoiceDetails.OfferDiscountDateTime,tblEmployees.StoreID, 
															(select ServiceAmount from tblAppointmentsDetailsInvoice where AppointmentID=tblAppointmentAssignEmployee.AppointmentID and ServiceID=tblAppointmentAssignEmployee.ServiceID Limit 0,1) as ServiceAmount 
															FROM tblEmployees left join tblAppointmentAssignEmployee on tblEmployees.EID = tblAppointmentAssignEmployee.MECID 
															left join tblAppointmentsDetailsInvoice on tblAppointmentsDetailsInvoice.AppointmentId= tblAppointmentAssignEmployee.AppointmentID 
															left join tblInvoiceDetails on tblAppointmentAssignEmployee.AppointmentID=tblInvoiceDetails.AppointmentId 
															where tblEmployees.EID='$strEID' 
															and tblAppointmentAssignEmployee.AppointmentID!='NULL' 
															and tblInvoiceDetails.OfferDiscountDateTime!='NULL' 
															and Date(tblInvoiceDetails.OfferDiscountDateTime)>='$First' and Date(tblInvoiceDetails.OfferDiscountDateTime)<='$Last'
															and tblEmployees.EID not In('43',49)  group by tblAppointmentAssignEmployee.AppointmentID,ServiceID,QtyParam";
											         	$RSdetails = $DB->query($sqldetails);
															if($RSdetails->num_rows > 0) 
															{
																$counter = 0;
																$strSID = "";
																$qty = "";
																$strSAmount = "";
																$strAmount = "";
																$strCommission = "";
																$FinalDAmount = '';
																$FinalDiscount = '';
																$UltimateSale = '';
																$AfterDivideSale = '';
																$CommssionFinal = "";
																
																while($rowdetails = $RSdetails->fetch_assoc())
																{
																	$counter ++;
																	$strEIDa = $rowdetails["EID"];
																	$strAID = $rowdetails["AppointmentID"];
																	$strSID = $rowdetails["ServiceID"];
																	$qty = $rowdetails["Qty"];
																	$strAmount = $rowdetails["ServiceAmount"];
																	$strSAmount = $strAmount;
																	$strCommission = $rowdetails["Commission"];
																	$StoreIDd = $rowdetails["StoreID"];
																	
																	$strTotalAmount += $strSAmount;  //Total of Service sale amount
																	
																	// Service Name Yogita query
																	$per=$_GET["per"];
																	
																	// Store Name Yogita query						
																	$stpp=select("StoreName","tblStores","StoreID='".$StoreIDd."'");
																	$StoreName=$stpp[0]['StoreName'];
																	
																	// Invoice no Yogita query
																	$sql_invoice_number = select("InvoiceID","tblInvoice","AppointmentID='".$strAID."'");
																	$Invoice_Number=$sql_invoice_number[0]['InvoiceID'];
																	
																	// Customer ID Yogita query
																	$sql_customer = select("CustomerID,AppointmentDate","tblAppointments","AppointmentID='".$strAID."'");
																	$CustomerID=$sql_customer[0]['CustomerID'];
																	$AppointmentDate=$sql_customer[0]['AppointmentDate'];
																	
																	
																	// Customer name Yogita query
																	$sql_customers = select("CustomerFullName","tblCustomers","CustomerID='".$CustomerID."'");
																	$CustomerFullName=$sql_customers[0]['CustomerFullName'];
																	
																	
																	if($strCommission=="1")
																	{
																		$AfterDivideSale = $strSAmount;
																		$strCommissionType = '<span class="bs-label label-success">Alone</span>';
																	}
																	elseif($strCommission=="2")
																	{
																		$AfterDivideSale = ($strSAmount / 2);
																		$strCommissionType = '<span class="bs-label label-blue-alt">Split</span>';
																	}
																	$TotalAfterDivideSale += $AfterDivideSale;  //Total of Final payment
																	
																	// discount code
																	$sqldiscount ="select OfferAmount, MemberShipAmount from tblAppointmentMembershipDiscount where AppointmentID='$strAID' and ServiceID='$strSID'";
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
																	
																	$FinalDiscount = $FinalDAmount / $qty;
																	$TotalFinalDiscount += $FinalDiscount;	//Total of discounted amount
																	
																	  
																	$UltimateSale = $AfterDivideSale - $FinalDiscount;
																	$TotalUltimateSale += $UltimateSale;	//Total of discounted amount
																	
																
																	
																	//Calculation for commission
																	if($strCommission == "1")
																	{
																		$CommssionFinal = ($UltimateSale / 100) * $strEmpPercentage;
																	}
																	elseif($strCommission == "2")
																	{
																		$CommssionFinal = ($UltimateSale / 200) * $strEmpPercentage;
																	}
																	$ComFinal += $CommssionFinal;	//Total of Commission
																	
																	
														
																}
															}
															else
															{
																$TotalUltimateSale = '0';
																$ComFinal = '0';
															}
															$saleper=($TotalUltimateSale/$FandFSalest)*100;
														   
															$FandFSales += $TotalUltimateSale;
															$FandFComm += $ComFinal;
															$totalsa +=$saleper;
										$sqlInsert2 = "Insert into tblCronEmployeePerformance(StoreID, EmployeeID, TotalSales) values
										('".$StoreIDd."','".$strEID."','".$TotalUltimateSale."')";
									    ExecuteNQ($sqlInsert2);			
															 
																	
										}
									}
								}
								else
									{
								
									}

				
		$DB->close();
	
		
		header( 'Location: http://pos.nailspaexperience.com/admin/Dashboard.php' );
  //  echo("<script>location.href=http://pos.nailspaexperience.com/admin/Dashboard.php';</script>");
   
		?>