<?php require_once("setting.fya"); ?>
<?php
				$date=date('Y-m-d');
				//$previousdate=date('Y-m-d',strtotime("-1 days"));
				$DB = Connect();
				$cust_array=array();
				
				
				
                $sql=select("distinct(AppointmentId)","tblInvoiceDetails","AppointmentId!='NULL' LIMIT 10000,11000");
				foreach($sql as $sdata)
				{
					$app[]=$sdata['AppointmentId'];
				}
				
				for($i=0;$i<count($app);$i++)
				{
					$sqlty=select("CustomerID","tblAppointments","AppointmentID='".$app[$i]."'");
					$cust=$sqlty[0]['CustomerID'];
					
					$sqltypy=select("CustomerID","tblInvoiceDetails","AppointmentId='".$app[$i]."'");
					$custin=$sqltypy[0]['CustomerID'];
					
					if($custin==$cust)
					{
						
					}
					else
					{
							$sql11 = "Update tblInvoiceDetails set CustomerID='".$cust."' where AppointmentId ='".$app[$i]."'";	
										   //echo $sql11;
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
		      
?>