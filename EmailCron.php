<?php require_once 'setting.fya'; ?>
<?php
$strMyTable = "tblEmailMessages";
$strMyTableID = "ID";

$DB = Connect();
	$sql = "SELECT * FROM tblEmailMessages WHERE Status='0'";
	$RS = $DB->query($sql);
	if ($RS->num_rows > 0) 
	{
		$counter = 0;

		while($row = $RS->fetch_assoc())
		{
			$strEmailID = $row["ID"];
			$strTo = $row["ToEmail"];
			$strFrom = $row["FromEmail"];
			$strSubject = $row["Subject"];
			$strBody = $row["Body"];
			
			$headers = "From: $strFrom\r\n";
			$headers .= "Content-type: text/html\r\n";

			// Mail sending 
			$retval = mail($strTo,$strSubject,$strBody,$headers);

			if( $retval == true )
			{
				$sqlUpdate = "UPDATE $strMyTable SET DateOfSending=now() , Status='1' WHERE $strMyTableID='".$strEmailID."'";
				//echo $sqlUpdate;
				ExecuteNQ($sqlUpdate);
				echo "Email sent to " . $strTo . "<br>";
			}
			else
			{
				$sqlUpdate = "UPDATE $strMyTable SET DateOfSending=now() , Status='2' WHERE $strMyTableID='".$strEmailID."'";
				ExecuteNQ($sqlUpdate);
				echo "<font color='red'>Email sending failed to " . $strTo . "<br></font>";
			}	
		}
		die();
	}
	else
	{
		echo"Yayy!! No more emails in the queue.";
		die();
	}
$DB->close();




?>