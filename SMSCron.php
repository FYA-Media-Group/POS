<?php require_once 'setting.fya'; ?>
<?php
$strMyTable = "tblSMSMessages";
$strMyTableID = "SMSID";

$DB = Connect();
	$sql = "SELECT * FROM $strMyTable WHERE Status='0'";
	$RS = $DB->query($sql);
	if ($RS->num_rows > 0) 
	{
		$counter = 0;

		while($row = $RS->fetch_assoc())
		{
			$strSMSID = $row["SMSID"];
			$strTo = $row["SMSTo"];
			$strFrom = "NAILSP";
			$strAPIKey = "Aebe2e79fd5ce8a3ffb0720d4bef17fe9";
			$strMessage = $row["Message"];
			$strMethod = "sms";
			
			// SMS sending 
			
			
			
?>

<?php	

ini_set("allow_url_fopen", 1);
$url = "http://api-alerts.solutionsinfini.com/v3/?method=$strMethod&api_key=$strAPIKey&to=$strTo&sender=$strFrom&message=$strMessage";
echo $url;

			$opts = array(
			  'http' => array('ignore_errors' => true)
			);

			//Create the stream context
			$context = stream_context_create($opts);

			//Open the file using the defined context
			$file = file_get_contents($url, false, $context);
			echo $file;

			$json = json_decode($file, true); // decode the JSON into an associative array
			echo '<pre>' . print_r($json, true) . '</pre>';
			
			// if( $retval == true )
			// {
				// $sqlUpdate = "UPDATE $strMyTable SET DateOfSending=now() , Status='1' WHERE $strMyTableID='".$strEmailID."'";
				//echo $sqlUpdate;
				// ExecuteNQ($sqlUpdate);
				// echo "Email sent to " . $strTo . "<br>";
			// }
			// else
			// {
				// $sqlUpdate = "UPDATE $strMyTable SET DateOfSending=now() , Status='2' WHERE $strMyTableID='".$strEmailID."'";
				// ExecuteNQ($sqlUpdate);
				// echo "<font color='red'>Email sending failed to " . $strTo . "<br></font>";
			// }	

		}
		die();
	}
	else
	{
		echo"Yayy!! No more SMS in the queue.";
		die();
	}
$DB->close();




?>