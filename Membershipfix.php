<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?php
$DB = Connect();
$sql = "SELECT CustomerID FROM `tblCustomerMemberShip` where Status='0'";

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	while($row = $RS->fetch_assoc())
	{
		$CustomerID=$row["CustomerID"];
		echo $CustomerID."<br>";
	}
}
else
{
	echo "In else";
}
?>