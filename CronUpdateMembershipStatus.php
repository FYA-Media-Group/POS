<?php require_once("setting.fya"); ?>
<?php
				$date=date('Y-m-d');
				//$previousdate=date('Y-m-d',strtotime("-1 days"));
				$DB = Connect();
				$cust_array=array();
                $sql=select("*","tblCustomerMemberShip","1");
				foreach($sql as $sdata)
				{
					$cust=$sdata['CustomerID'];
					$memberid=$sdata['MembershipID'];
					$seldataaq=select("memberid","tblCustomers","CustomerID='".$cust."'");
				    $memberidold=$seldataaq[0]['memberid'];					
						 
                         if($memberidold=='0')	
						 {
							 		$sql11 = "Update tblCustomers set memberid='".$memberid."' where CustomerID ='".$cust."'";	
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
		      
?>