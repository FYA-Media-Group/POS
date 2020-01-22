<?php require_once("setting.fya"); ?>
<?php
$date=date('Y-m-d');

$DB = Connect();
		
	
		
		
		$sql = "Select CustomerID from tblCustomers where Status='0'";
		// echo $sql;
		$RS = $DB->query($sql);
		if ($RS->num_rows > 0) 
		{
			while($row = $RS->fetch_assoc())
			{
				$counter ++;
				
				  $custid = $row["CustomerID"];
					$seldatapttptqppp=select("count(*)","tblCustomerMemberShip","CustomerID='".$custid."'");
							 $cntttp=$seldatapttptqppp[0]['count(*)'];
							 
					$sepptu=select("*","tblCustomerMemberShip","CustomerID='".$custid."'");
				    $enddate=$sepptu[0]['EndDay'];
					$ExpiryCount=$sepptu[0]['ExpiryCount'];
					if($cntttp>0)
	             	{
					if($date>=$enddate)
					 {
						 $totalexpirt=$ExpiryCount+1;
						    $sql11 = "Update tblCustomerMemberShip set ExpiryCount='$totalexpirt',ExpireDate='".$enddate."' where CustomerID='".$custid."'";	
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
		}		
					
		
				
		
		
			
		
?>