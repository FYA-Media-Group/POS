<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?
	$Brand = $_GET['value'];
		$BrandAddress = $_GET['BrandAddress'];
			$mobile = $_GET['mobile'];
				$email = $_GET['email'];
	
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{	
		
		$DB = Connect();
		if($Brand=="")
		{
			$data=2;
		}
		else
		{
		$sql1="INSERT INTO tblProductBrand(BrandName,Address,Mobile,EmailID,Status) VALUES ('".$Brand."','".$BrandAddress."','".$mobile."','".$email."', '0')";	
		
		if ($DB->query($sql1) === TRUE) 
		{
			$data=3;
		} 
		else 
		{
			$data="Error: " . $sql1 . "<br>" . $DB->error;
		}
		}
		echo $data;
	}