<?php require_once 'setting.fya'; ?>
<?php
$strMyTable = "tblAdminMail";
$strMyTableID = "MailId";

$DB = Connect();
	$sql = "Select * FROM tblAdminMail where status='0'";
	$RS = $DB->query($sql);
	if ($RS->num_rows > 0) 
	{
		$counter = 0;

		while($row = $RS->fetch_assoc())
		{
			$strid = $row["MailId"];
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
				$sqlUpdate = "update $strMyTable set DateOfSending=now() , status='1' where $strMyTableID='".$strid."'";
				//echo $sqlUpdate;
				ExecuteNQ($sqlUpdate);
				echo "Email sent to " . $strTo . "<br>";
			}
			else
			{
				$sqlUpdate = "update $strMyTable set DateOfSending=now() , status='2' where $strMyTableID='".$strid."'";
				ExecuteNQ($sqlUpdate);
				echo "<font color='red'>Email sending failed to " . $strTo . "<br></font>";
			}	
		}
		die();
	}
	else
	{
		echo"No Emails in database to send";
		die();
	}
$DB->close();




?>