<?php


function CreateSMSURL($campaign, $unicode, $flash, $message, $sms)
{
	
	$xmldata =  '<?xml version="1.0" encoding="UTF-8"?>
                <api>
                    <campaign>'.$campaign.'</campaign>
					
                    <unicode>'.$unicode.'</unicode>
                    <flash>'.$flash.'</flash>
                    <sender>NAILSP</sender>
                    <message><![CDATA['.$message.']]></message>
                        <sms>
                            <to>'.$sms.'</to>
                        </sms>
                </api>';
				
	$api_url ='http://api-alerts.solutionsinfini.com/v3/?method=sms.xml&api_key=Aa57c990c039d562d2661720de511f103&format=json&xml='.urlencode($xmldata);
	$response = file_get_contents($api_url);
	echo $response;
	$response = json_decode($response, true);
	$strSendingStatus = $response['status'];
	
	if ($strSendingStatus == 'OK')
	{
		return $response;
	}
	else
	{
		return $response;
	}
		
}



//-----------------------------------------------------------------------------------------------------

	// Send SMS code to be executed
	$SendSMS = CreateSMSURL("Nailspa Experience","0","0","Welcome Saif Usmani","123");
	
	
	if ($SendSMS == "Not Sent")
	{
		echo "Message not sent";
		//update tbl with status not sent to resend sms later
		die();
	}
	else
	{
		$strSMSID = $SendSMS['data']['0']['id'];
		$strSMSMobile = $SendSMS['data']['0']['mobile'];
		$strSMSStatus = $SendSMS['data']['0']['status'];
		
		echo "$strSMSID <br>";
		echo "$strSMSMobile <br>";
		echo "$strSMSStatus <br>";
		//update tbl with specific status that SMS has been sent
		//save id and delivery statsu as well.
		die();
	}
	
?>