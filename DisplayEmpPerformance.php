<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
		$DB = Connect(); 
	
		$sqlp="delete from tblCronEmployeePerformance where StoreID!='0'";
		//echo $sqlp;
		ExecuteNQ($sqlp);
	   	$sqlgraph=select("FromDate,ToDate","tblGraphDateParameter","RoleID='".$strAdminRoleID."'");
		$FromDate=$sqlgraph[0]['FromDate'];
		$ToDate=$sqlgraph[0]['ToDate'];
	    $First= $FromDate;
		$Last= $ToDate;
		$date=date('Y-m-d');
		$coldata=array();
		$coldata=array('#FF0F00','#FF6600','#FF9E01','#FCD202','#F8FF01','#B0DE09','#04D215','#0D8ECF','#0D52D1','#2A0CD0','#8A0CCF','#CD0D74');

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
											
											 $sqldetailsd=EmpPerFunction($First,$Last,$strEID);
											// print_r($sqldetailsd);
											  foreach($sqldetailsd as $vauo)
											  {
												  $counter ++;
																	$strEIDa = $vauo["EID"];
																	$strAID = $vauo["AppointmentID"];
																	$strSID = $vauo["ServiceID"];
																	$qty = $vauo["Qty"];
																	$strAmount = $vauo["ServiceAmount"];
																	$strSAmount = $strAmount;
																	$strCommission = $vauo["Commission"];
																	$StoreIDd = $vauo["StoreID"];
																	
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
											  unset($sqldetailsd);
											  $saleper=($TotalUltimateSale/$FandFSalest)*100;
														   
															$FandFSales += $TotalUltimateSale;
															$FandFComm += $ComFinal;
															$totalsa +=$saleper;
										$sqlInsert2 = "Insert into tblCronEmployeePerformance(StoreID, EmployeeID, TotalSales) values
										('".$StoreIDd."','".$strEID."','".$TotalUltimateSale."')";
									    ExecuteNQ($sqlInsert2);			
															 
																	
										}
									}
									
									//echo 1;
								}
								else
									{
								
									}
									
	    echo 1;
				
		$DB->close();
	
	
// echo("<script>location.href=http://pos.nailspaexperience.com/admin/Dashboard.php';</script>");
   
		?>