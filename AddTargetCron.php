<?php require_once 'setting.fya'; ?>
<?php
$strMyTable = "tblStoreSalesTarget";
$strMyTableID = "STID";

$DB = Connect();

$day = 1;	// date('d');
$Month = date('m');			//$row["Month"];
$MonthSpell = getMonthSpelling($Month);
$Year = 2000 + date('y');			//$row["Year"];
// $MonthYear = $MonthSpell.", ".$Year;



if($day == 1)
{
	// echo "Hello";
	$sqlStores = "SELECT * FROM tblStores WHERE Status='0'";
	$RSStores = $DB->query($sqlStores);
	if ($RSStores->num_rows > 0) 
	{
		while($rowStores = $RSStores->fetch_assoc())
		{
			$StoreID = $rowStores['StoreID'];
			$sqlInsertForNewMonth = "INSERT INTO $strMyTable (Month, Year, TargetAmount, StoreID) VALUES ('$MonthSpell','$Year','0','$StoreID')";
			ExecuteNQ($sqlInsertForNewMonth);
		}
	}
}
elseif($day >= 5)
{
	$OldMonthSpell = getMonthSpelling($Month - 1);
	////////////////////////////////////////
	$sqlCheckTarget = "SELECT * FROM tblStoreSalesTarget WHERE Month LIKE '$MonthSpell' AND Year='$Year' AND TargetAmount='0'";
	// echo $sqlCheckTarget;
	// die();
	$RSCheckTarget = $DB->query($sqlCheckTarget);
	if ($RSCheckTarget->num_rows > 0) 
	{
		while($rowCheckTarget = $RSCheckTarget->fetch_assoc())
		{
			$StoreID = $rowCheckTarget['StoreID'];
			$sqlInsertOldTarget = "SELECT TargetAmount FROM tblStoreSalesTarget WHERE Month LIKE '$OldMonthSpell' AND Year='$Year' AND StoreID='$StoreID'";
			// echo $sqlInsertOldTarget."<br>";
			// die();
			$RSInsertOldTarget = $DB->query($sqlInsertOldTarget);
			$rowInsertOldTarget = $RSInsertOldTarget->fetch_assoc();
			$OldTargetAmount = $rowInsertOldTarget['TargetAmount'];
			// echo $rowInsertOldTarget['TargetAmount'];
			// die();
			$sqlUpdateTarget = "UPDATE tblStoreSalesTarget SET TargetAmount='$OldTargetAmount' WHERE Month LIKE '$MonthSpell' AND Year='$Year' AND StoreID='$StoreID'";
			ExecuteNQ($sqlUpdateTarget);
		}
	}
	
	
	
	
 // && ($rowCheckTarget['TargetAmount'] === NULL)	
	
	
	
}

	// $sql = "SELECT * FROM tblEmailMessages WHERE Status='0'";
	// $RS = $DB->query($sql);
	// if ($RS->num_rows > 0) 
	// {
		// $counter = 0;

		// while($row = $RS->fetch_assoc())
		// {