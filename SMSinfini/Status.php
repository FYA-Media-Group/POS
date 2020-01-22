<?php


function CheckSMSStatus($smsid, $info)
{
	$api_url ='http://api-alerts.solutionsinfini.com/v3/?method=sms.status&api_key=Aebe2e79fd5ce8a3ffb0720d4bef17fe9&format=json&id='.$smsid.'&numberinfo='.$info.'';		
	$response = file_get_contents($api_url);
	$response = json_decode($response, true);
	$strCheckingStatus = $response['status'];
	
	if ($strCheckingStatus == 'OK')
	{
		return $response;
	}
	else
	{
		return "Not valid";
	}
}
	
	
	
//-----------------------------------------------------------------------------------------------------
	//3535387642-1

	//3535396223-1
	// Checking SMS status code to be executed
	$CheckStatus = CheckSMSStatus("3544834550-1","1");
	
	if ($CheckStatus == "Not valid")
	{
		echo "Id not valid";
		die();
	}
	else
	{
		$strSMSID = $CheckStatus['data']['0']['id'];
		$strSMSMobile = $CheckStatus['data']['0']['mobile'];
		$strSMSStatus = $CheckStatus['data']['0']['status'];
		
		echo "$strSMSID <br>";
		echo "$strSMSMobile <br>";
		echo "$strSMSStatus <br>";
		//update tbl with for particular id
		die();
	}	

?>