<?php require_once("setting.fya"); ?>
<?php
$date=date('Y-m-d');
$previousdate=date('Y-m-d',strtotime("-1 days"));
$mon=date('m', strtotime($previousdate));
$month = date("F", mktime(0, 0, 0, $mon, 10));
$preyear=date('Y', strtotime($previousdate));
$First= date('Y-m-01');
$firstmon=date('m', strtotime($First));
$firstmonth = date("F", mktime(0, 0, 0, $firstmon, 10));
$year=date('Y', strtotime($First));
$DB = Connect();
		
if($date==$First)
{
   	$sql = "Select * from tblStoreSalesTarget where Month='".ucfirst($month)."' and Year='".$preyear."'";
		// echo $sql;
		$RS = $DB->query($sql);
		if ($RS->num_rows > 0) 
		{
			while($row = $RS->fetch_assoc())
			{
			     $storeidd=$row['StoreID'];
				 $TargetAmount=$row['TargetAmount'];
				 
				 $seldata=select("count(*)","tblStoreSalesTarget","Month='".ucfirst($firstmonth)."' and Year='".$year."' and StoreID='".$storeidd."'");
				
				$cnt=$seldata[0]['count(*)'];
				if($cnt>0)
				{
					
				}
				else
				{
					$pqr="Insert into tblStoreSalesTarget (Month, Year, TargetAmount,StoreID) Values ('".ucfirst($firstmonth)."', '".$year."', '".$TargetAmount."','".$storeidd."')";
			
				
				if ($DB->query($pqr) === TRUE) 
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