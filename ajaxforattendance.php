<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
	<?php require_once("incMetaScript.fya"); ?>
<head>
<script>
	function Checkin(a1)
	{
		alert (a1);
		var ERID = a1;
		 $.ajax({
				   type: 'POST',
				   url: 'ajaxforattendance.php',
				   data: {
					   getERID: ERID
				   },
					
				   success: function(response) {
					   $('.result_message').html(response);
				   }
			   });
	}
</script>	
<head>
<?php
$DB = Connect();
$sql = "SELECT  tblEmployees.EmployeeCode, tblEmployees.EmployeeName, tblEmployeesRecords.DateOfAttendance, tblEmployeesRecords.ERID, tblEmployeesRecords.EmployeeCode  
from tblEmployees 
Left join tblEmployeesRecords 
ON tblEmployees.EmployeeCode=tblEmployeesRecords.EmployeeCode ";
// echo $sql;


$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strERID = $row["ERID"];
		
?>
<?
	}
}
	// echo $strERID;
?>
<div class="result_message" align="center"> </div>
<a class="btn btn-xs btn-primary" value="Checkin" id="Checkin" name="Checkin" onclick="Checkin(<?=$strERID?>);" >Checkin</a>




<?php
	
	$strERID1 = Filter($_GET["getERID"]);
	
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{	
		$DB = Connect();
		$sql1="Update tblEmployeesRecords set LoginTime=now() where ERID='$strERID1'";	
		
		if ($DB->query($sql1) === TRUE) 
		{
			echo "Record Update successfully.";
			echo "<br>";
		} 
		else 
		{
			echo "Error: " . $sql1 . "<br>" . $DB->error;
		}
	}
?>