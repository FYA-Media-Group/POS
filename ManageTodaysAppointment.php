<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php


$DB = Connect();
$sql1 = "Select * FROM tblEmployeesRecords order by $strMyTableID desc";	
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strERID = $row["ERID"];
		$getUID = EncodeQ($strERID);
		$getUIDDelete = Encode($strERID);
		$EmployeeName = $row["EmployeeName"];
		$EmployeeCode = $row["EmployeeCode"];
		$DateOfAttendance = $row["DateOfAttendance"];
		$LoginTime = $row["LoginTime"];
		$LogoutTime = $row["LogoutTime"];
		$Status = $row["Status"];
		echo $LoginTime;
		
		
	}
}
echo "Hello";
?>
