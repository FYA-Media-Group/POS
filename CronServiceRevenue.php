<?php require_once("setting.fya"); ?>

	
<?php
		$DB = Connect(); 

	  $First= date('Y-m-01');
       $Last= date('Y-m-t');
	
	    $sqlTempfrom = " and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$First."')";
		$sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$Last."')";
		
	$sqlp="delete from tblCronServiceRevenue";
	 ExecuteNQ($sqlp);
	    
		 $sqldata = "SELECT Distinct(tblServices.ServiceCode)
								FROM tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblServices on tblAppointmentsDetailsInvoice.ServiceID=tblServices.ServiceID
								WHERE tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' AND tblAppointments.Status='2' $sqlTempfrom $sqlTempto";
					
					$RSdata = $DB->query($sqldata);
					if ($RSdata->num_rows > 0) 
					{
						while($rowdata = $RSdata->fetch_assoc())
						{
							$ServiceIDdd[] = $rowdata["ServiceCode"];
							/* $strAppointmentID = $rowdata["AppointmentID"];
							$strqty = $rowdata["qty"];
							$strServiceAmountt = $rowdata["ServiceAmount"];
							$strServiceAmount=$strServiceAmountt*$strqty;
							$ServiceID = $rowdata["ServiceID"];
							
								$stppser=select("*","tblServices","ServiceID='".$ServiceID."'");
								$ServiceName=$stppser[0]['ServiceName'];
								$ServiceCode=$stppser[0]['ServiceCode'];
							
                                $StoreID=$rowdata['StoreID'];
								$stppastore=select("*","tblStores","StoreID='".$StoreID."'");
								$StoreName=$stppastore[0]['StoreName'];							
								 $sqlInsert2 = "Insert into tblCronServiceRevenue(StoreName,StoreID, ServiceID, ServiceName,AmountPercentage) values
										('".$StoreName."','".$StoreID."','".$ServiceID."','".$ServiceName."','".$strServiceAmount."')";
									    ExecuteNQ($sqlInsert2); */
						}
					}
					
					for($i=0;$i<count($ServiceIDdd);$i++)
					{
						         $setqty=select("sum(tblAppointmentsDetailsInvoice.qty) as sumqty","tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblServices on tblAppointmentsDetailsInvoice.ServiceID=tblServices.ServiceID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto and tblServices.ServiceCode='".$ServiceIDdd[$i]."' and tblAppointments.Status='2'");
								$sumqty=$setqty[0]['sumqty'];
						
						       $set=select("sum(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as sumaatt","tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblServices on tblAppointmentsDetailsInvoice.ServiceID=tblServices.ServiceID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID!='0' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto and tblServices.ServiceCode='".$ServiceIDdd[$i]."' and tblAppointments.Status='2'");
								
								
								$sumaatt=$set[0]['sumaatt'];
								$stppser=select("*","tblServices","ServiceCode='".$ServiceIDdd[$i]."'");
								$ServiceName=$stppser[0]['ServiceName'];
								$ServiceCode=$stppser[0]['ServiceCode'];
								
								$sqlInsert2 = "Insert into tblCronServiceRevenue(StoreName,StoreID, ServiceCode, ServiceName,AmountPercentage,QtySold) values
										('','','".$ServiceIDdd[$i]."','".$ServiceName."','".$sumaatt."','".$sumqty."')";
									    ExecuteNQ($sqlInsert2); 
						
					}
					unset($ServiceIDdd);
		
		
		//header( 'Location: http://pos.nailspaexperience.com/admin/Dashboard.php' );
  echo("<script>location.href=http://pos.nailspaexperience.com/admin/Dashboard.php';</script>");
   
		?>