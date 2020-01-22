<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$DB = Connect();
	$sql = "Select EmployeeCode from tblEmployees where Status='0'";
	$RS = $DB->query($sql);
	if ($RS->num_rows > 0) 
	{
		$counter = 0;
		while($row = $RS->fetch_assoc())
		{
			$counter ++;
		
			$EmployeeCode = $row["EmployeeCode"];
			// echo $EmployeeCode."<br>";
			
			$sql2 = "INSERT INTO tblEmployeesRecords(EmployeeCode,DateOfAttendance,Status) VALUES ('$EmployeeCode', now(), '0')";
			ExecuteNQ($sql2);
		}
	}
?>