<?php require_once("setting.fya"); ?>
<?php

$DB = Connect();
$date=date('Y-m-d');
$Year=date('Y');
$Month = date('m');		
$First= date('Y-m-01');	
$MonthSpell = getMonthSpelling($Month);

// echo $date."<br>";
// echo $Year."<br>";
// echo $MonthSpell."<br>";
// echo $First."<br>";

if($date==$First)
{
			$sql = "Select EmployeeCode, StoreID from tblEmployees where Status='0'";
		
					$RS = $DB->query($sql);
					if ($RS->num_rows > 0) 
					{
						while($row = $RS->fetch_assoc())
						{
							$counter ++;
							$strEmployeeCode = $row["EmployeeCode"];
							$strStoreID = $row["StoreID"];
							// echo $strEmployeeCode."<br>";
							$pqr="Insert into tblEmployeeTarget(EmployeeCode, TargetForMonth, Year, BaseTarget) Values ('$strEmployeeCode', '$MonthSpell', '$Year', '10000')";
							
							ExecuteNQ($pqr);
							echo $pqr."<br>";
						}
					}
}
else
{
		
}
		$DB->Close;
?>