<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?php 
$app_id=$_GET['id'];
$selp=select("*","tblAppointments","AppointmentID='".$app_id."'");
$cust_id=$selp[0]['CustomerID'];
$store=$selp[0]['StoreID'];

$selpd=select("*","tblCustomers","CustomerID='".$cust_id."'");
$CustomerEmailID=$selpd[0]['CustomerEmailID'];
$CustomerFullName=$selp[0]['CustomerFullName'];
$selpde=select("StoreName","tblStores","StoreID='".$store."'");

$strTo = $CustomerEmailID;
				$strFrom = "order@fyatest.website";
				$strSubject = "Thank you for booking appointment at Nailspa Experience";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$Name = $CustomerFullName;
				//$Email = $strCustomerEmailID;
				//$strAdminPassword = $strAdminPassword;
					//$strDate = date("Y-m-d h:i:s");
					$StoreAddress = $selpde[0]['StoreOfficialAddress'];
				$strDate = date("Y/m/d");
				$strTime = $strSuitableAppointmentTime;
			
					$message = file_get_contents('EmailFormat/appointment.html');
				$message = eregi_replace("[\]",'',$message);

				//setup vars to replace
				$vars = array('{Name_Detail}','{Date}','{Time}','{Address}'); //Replace varaibles
				$values = array($Name,$strDate,$strTime,$StoreAddress);

				//replace vars
				$message = str_replace($vars,$values,$message);
				//echo $message;

                
				$strBody = $message;
echo $strBody;
               //echo $strBody;
          /*   // echo $last_id2;
			echo $strTo;
           echo $last_id2;
           echo $strFrom;
           echo $strSubject;
            echo $strBody;
		    echo $strStatus; */

				$sqlInsertdata = "INSERT INTO tblAdminMail (Id,ToEmail, FromEmail, Subject, Body,flag,status) VALUES ('".$app_id."', '$strTo', '$strFrom', '$strSubject', '$strBody','AP','$strStatus')";
				echo $sqlInsertdata;
				$DB->query($sqlInsertdata);
			//	ExecuteNQ($sqlInsertdata);
				$DB->close();
		
		
				
				
$DB = Connect();
$strMyTables = "tblAdminMail";
$strMyTableIDs = "MailId";
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
				$sqlUpdate = "update $strMyTables set DateOfSending=now() , status='1' where $strMyTableIDs='".$strid."'";
				//echo $sqlUpdate;
				ExecuteNQ($sqlUpdate);
				$msg="Email sent to " . $strTo . "<br>";
			}
			else
			{
				$sqlUpdate = "update $strMyTables set DateOfSending=now() , status='2' where $strMyTableIDs='".$strid."'";
				ExecuteNQ($sqlUpdate);
				$msg="<font color='red'>Email sending failed to " . $strTo . "<br></font>";
			}	
		}
		//die();
	}
	else
	{
		$msg="No Emails in database to send";
		//die();
	}
$DB->close();
header("ManageCustomers.php?msg='".$msg."'";
	?>			
				