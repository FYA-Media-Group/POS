<?php
	$strTo = "saiffya@hotmail.com";
	$strFrom = "appnt@nailspaexperience.com";
	$strSubject = "Testing";
	$strBody = "Testing";
	
	$headers = "From: $strFrom\r\n";
	$headers .= "Content-type: text/html\r\n";

	// Mail sending 
	$retval = mail($strTo,$strSubject,$strBody,$headers);

	if( $retval == true )
	{
		echo "Sent";
		die();
	}
	else
	{
		echo "Not Sent";
		die();
	}	
	
?>