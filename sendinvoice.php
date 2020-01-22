<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?php
	$DB = Connect();
	$strTo = $_POST["email"];
    $app=$_POST["app"];
	$selp=select("*","tblAppointments","AppointmentID='".$app."'");
	$customer=$selp[0]['CustomerID'];
	$StoreID=$selp[0]['StoreID'];
	
/* 	$sq=select("*","tblCustomers","CustomerID='".$customer."'");
	$CustomerFullName=$sq[0]['CustomerFullName'];
				$strFrom = "appnt@nailspaexperience.com";
				$strSubject = "Thank you for booking Appointment at Nailspa Experience";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$Name = $CustomerFullName;
				//$Email = $strCustomerEmailID;
				//$strAdminPassword = $strAdminPassword;
				//$strDate = date("Y-m-d h:i:s");
				//$StoreAddress = $location;
				$strDate = date("Y-m-d");
				$strTime = $pqr;
				$time_in_12_hour_format  = date("g:i a", strtotime($strTime));
				
				//$sqlInsert = "Insert into tblEmailMessages (AppointmentID, ToEmail, FromEmail, Subject, Body, DateTime, Status) values ('".$last_id2."', '$strTo', '$strFrom', '$strSubject', '$strBody', '$strDate' ,'$strStatus')";
				//ExecuteNQ($sqlInsert);
				//echo $sqlInsert;
				
				
				//	$sql_appointments = select("ID","tblEmailMessages","ToEmail='".$strTo."' AND AppointmentID='".$last_id2."'");
				//$emailmsgid = $sql_appointments[0]['ID'];

				 
				//$sqlUpdate = "UPDATE tblInvoice SET EmailMessageID='".$emailmsgid."' WHERE InvoiceID='".$last_id5."'";
				//ExecuteNQ($sqlUpdate);
				
				$seldata=select("*","tblStores","StoreID='".$StoreID."'");
				$address=$seldata[0]['StoreOfficialAddress'];
				$storename=$seldata[0]['StoreName'];
			    $branche=explode(",",$storename);
				$branchname=$branche[1]; 
				$path="`http://nailspaexperience.com/images/test2.png`";
			
				//$officeaddress=$sep[0]['StoreOfficialAddress'];
                //$servicee=implode(",",$strServicesused);
				$strDate = date("Y-m-d");	
				$message = file_get_contents('EmailFormat/appointment.html');
				$message = eregi_replace("[\]",'',$message);          
				//setup vars to replace
				$vars = array('{Address}','{Name_Detail}','{Date}','{Time}','{Path}','{Branch}'); //Replace varaibles
				$values = array($address,$Name,$strDate,$time_in_12_hour_format,$path,$branchname);
				//replace vars
				$message = str_replace($vars,$values,$message);
				//echo $message;               
				$strBody = $message;             
				$flag='AP';
				$id = $app;
				sendmail($id,$strTo,$strFrom,$strSubject,$strBody,$strDate,$flag,$strStatus); */


    if($strTo=="")
	{
		echo "Email Id Cannot Blank";
	}
	else
	{
		    $strTo = $_POST["email"];
			$strFrom = "appnt@nailspaexperience.com";
			$strSubject = "Invoice Details";
			$strBody = $_POST["divContents"];
		    $strbody1="<html><head><title>Invoice</title></head><body> $strBody </body></html>";
			$headers = "From: $strFrom\r\n";
			$headers .= "Content-type: text/html\r\n";
            $strBodysa = AntiFilter1($strbody1);
			// Mail sending 
			$retval = mail($strTo,$strSubject,$strBodysa,$headers);

			if( $retval == true )
			{
				
				echo "Email sent to " . $strTo;
			}
			else
			{
				
				echo "<font color='red'>Email sending failed to " . $strTo . "</font>";
			}
	}
			
				
		
	




?>