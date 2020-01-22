<?php require_once("setting.fya"); ?>
<?php
$date=date('Y-m-d');
$previousdate=date('Y-m-d',strtotime("-1 days"));
$DB = Connect();


		
		$sql = "Select DISTINCT(ServiceID) from tblServices where StoreID='56'";
		// echo $sql;
		$RS = $DB->query($sql);
		if ($RS->num_rows > 0) 
		{
			while($row = $RS->fetch_assoc())
			{
				$counter ++;
				$ServiceID = $row["ServiceID"];
					$pqr="Insert into tblServicesCharges (ServiceID,ChargeNameID,Status) Values ('$ServiceID','1','0')";
			
				
					 if ($DB->query($pqr) === TRUE) 
					{
							// echo "Record Update successfully.";
					}
					else
					{
						//echo "Error2";
					} 
				
			}
		} 
		
		
			
				
		
?>