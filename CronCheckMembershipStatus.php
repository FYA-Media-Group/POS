<?php require_once("setting.fya"); ?>
<?php
				$date=date('Y-m-d');
				//$previousdate=date('Y-m-d',strtotime("-1 days"));
				$DB = Connect();
				$cust_array=array();
                $sql=select("distinct(CustomerID)","tblCustomerMemberShip","Status='0'");
				foreach($sql as $sdata)
				{
					$cust_array[]=$sdata['CustomerID'];
				}
		       for($i=0;$i<count($cust_array);$i++)
			   {
				   $seldataTY=select("distinct(AppointmentID)","tblAppointments","CustomerID='".$cust_array[$i]."' and memberid!='0' order by AppointmentID asc limit 0,1");
				   $app_id=$seldataTY[0]['AppointmentID'];
				   $seldatamem=select("memberid","tblAppointments","AppointmentID='".$app_id."'");
				   $memberid=$seldatamem[0]['memberid'];
				   $seldata=select("count(*)","tblInvoiceDetails","AppointmentId='".$app_id."' and Membership_Amount!=''");
				   $cnt=$seldata[0]['count(*)'];
				   	if($cnt>0)
					{
						 $sql11 = "Update tblCustomerMemberShip set Status='1' where CustomerID ='".$cust_array[$i]."'";	
										   //echo $sql1;
											if ($DB->query($sql11) === TRUE) 
											{
												// echo "Record Update successfully.";
											}
											else
											{
												echo "Error2";
											}
						 $seldataaq=select("memberid","tblCustomers","CustomerID='".$cust_array[$i]."'");
				         $memberidold=$seldataaq[0]['memberid'];					
						 
                         if($memberidold=='0' || $memberidold=='')	
						 {
							 		$sql11 = "Update tblCustomers set memberid='".$memberid."' where CustomerID ='".$cust_array[$i]."'";	
										   //echo $sql1;
											if ($DB->query($sql11) === TRUE) 
											{
												// echo "Record Update successfully.";
											}
											else
											{
												echo "Error2";
											}	
						 }							 
								
											
					}
			   }
	
	
		
?>