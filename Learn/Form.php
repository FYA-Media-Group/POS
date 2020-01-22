<?php require_once("../setting.fya"); ?>
<?php require_once '../incFirewall.fya'; ?>
<?php
		
	$DB = Connect();
	$sql = "SELECT  tblEmployees.EmployeeCode, tblEmployees.EmployeeName, tblEmployeesRecords.DateOfAttendance, tblEmployeesRecords.ERID, tblEmployeesRecords.LoginTime, tblEmployeesRecords.LogoutTime,  tblEmployeesRecords.EmployeeCode  
	from tblEmployees 
	Left join tblEmployeesRecords 
	ON tblEmployees.EmployeeCode=tblEmployeesRecords.EmployeeCode where tblEmployeesRecords.DateOfAttendance='2016-07-03'";
	echo $sql1;
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
			// echo $LoginTime;
		}
	}		
?>	
<html>
<head>
<body>
	<form>
		<label style="color:blue; margin-left:20px; ">Name : </label><input type="text" name="Name" id="Name"><br>
		<label style="color:red; margin-left:20px; ">Gender : </label><br><div style="margin-left:50px;">Female:<input type="radio" name="female" id="female"></input><br>
		Male : <input type="radio" name="male" id="male" ></input></div>
	</form>
</body>
</head>
</html>

	
