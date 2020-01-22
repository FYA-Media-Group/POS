<?php require_once("../setting.fya"); ?>

<?php
$result = array();
$DB = Connect();
	
	$sqlselect="select * from tblCustomers order by CustomerID desc";
	$RS = $DB->query($sqlselect);
	if ($RS->num_rows > 0) 
	{
		while($row = $RS->fetch_assoc())
		{
			$strCustomerFullName = $row["CustomerFullName"];
			$strCustomerMobileNo = $row["CustomerMobileNo"];
			
			$result[] = $row;
		}
	}
	
	//echo count($result);
	//echo "<br>";
//Json Open and Write
	$filepath = "jsondata";
	if (file_exists($filepath))
	{
	} 
	else 
	{
		mkdir('jsondata', 0777, true);
	}


	$Searchfile = "jsondata/CustomersData.json";
	unlink($Searchfile);

	$file = "jsondata/CustomersData.json";
	$handle = fopen($file, 'w') or die('Cannot open file:  '.$file);
	file_put_contents($file, json_encode($result , JSON_PRETTY_PRINT));
	fclose($file);

	echo "json file for Cutomers synced successfully";
//Json Open and Write
	
$DB->close();
?>