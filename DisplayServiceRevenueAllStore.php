<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
?>

  <script type="text/javascript">
$(window).unload(function() {
    var html = "<img src='html/loading.gif' />";
    $('#loading').append(html);
});
</script>


<?php
		$DB = Connect(); 
        $sqlgraph=select("FromDate,ToDate","tblGraphDateParameter","RoleID='".$strAdminRoleID."'");
		$FromDate=$sqlgraph[0]['FromDate'];
		$ToDate=$sqlgraph[0]['ToDate'];
	    $First= $FromDate;
		$Last= $ToDate;
		
	    $sqlTempfrom = " and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$First."')";
		$sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$Last."')";
	    $sqlp="delete from tblCronServiceRevenueStore";
	    ExecuteNQ($sqlp);
		
	    $seldpdss=select("*","tblStores","Status='0'");
		foreach($seldpdss as $avtt)       
		{
				 $sqldata = "SELECT tblAppointmentsDetailsInvoice.ServiceID FROM tblAppointmentsDetailsInvoice left join tblInvoiceDetails on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID WHERE tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' AND tblAppointments.Status='2' $sqlTempfrom $sqlTempto and tblAppointments.StoreID='".$avtt['StoreID']."'";
					
					$RSdata = $DB->query($sqldata);
					if ($RSdata->num_rows > 0) 
					{
						while($rowdata = $RSdata->fetch_assoc())
						{
							$ServiceIDdd[] = $rowdata["ServiceID"];
					
						}
					}
					
					for($i=0;$i<count($ServiceIDdd);$i++)                   
						{
							    $sqldetailsd=ServiceRevenueAllStore($First,$Last,$ServiceIDdd[$i],$avtt['StoreID']);
								$sumaatt=$sqldetailsd[0]['sumaatt'];
							
							
							     /* $setqty=select("sum(tblAppointmentsDetailsInvoice.qty) as sumqty","tblAppointmentsDetailsInvoice left join tblInvoiceDetails on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto and tblAppointmentsDetailsInvoice.ServiceID='".$ServiceIDdd[$i]."' and tblAppointments.Status='2' and tblAppointments.StoreID='".$avtt['StoreID']."'");
								 $sumqty=$setqty[0]['sumqty'];
							  
							
						       $set=select("sum(tblAppointmentsDetailsInvoice.qty*tblAppointmentsDetailsInvoice.ServiceAmount) as sumaatt","tblAppointmentsDetailsInvoice left join tblInvoiceDetails on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' $sqlTempfrom $sqlTempto and tblAppointmentsDetailsInvoice.ServiceID='".$ServiceIDdd[$i]."' and tblAppointments.Status='2' and tblAppointments.StoreID='".$avtt['StoreID']."'"); */
								$seldpd=select("StoreName","tblStores","StoreID='".$avtt['StoreID']."'");
				               $storname=$seldpd[0]['StoreName'];
								
								
								$stppser=select("*","tblServices","ServiceCode='".$ServiceIDdd[$i]."'");
								$ServiceName=$stppser[0]['ServiceName'];
								$ServiceCode=$stppser[0]['ServiceCode'];
								
								$sqlInsert2 = "Insert into tblCronServiceRevenueStore(StoreName,StoreID, ServiceID, ServiceName,AmountPercentage,QtySold) values
										('".$storname."','".$avtt['StoreID']."','".$ServiceIDdd[$i]."','".$ServiceName."','".$sumaatt."','')";
									    ExecuteNQ($sqlInsert2); 
						
					}
					unset($ServiceIDdd);
		
		}
		
		echo 1;
	//	header( 'Location: http://pos.nailspaexperience.com/admin/Dashboard.php' );
//echo("<script>location.href=http://pos.nailspaexperience.com/admin/Dashboard.php';</script>");
   
		?>