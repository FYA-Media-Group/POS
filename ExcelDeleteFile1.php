<?php
	require_once 'setting.fya';
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$strFileName = Filter($_POST["fn"]);
		unlink("uploads/".$strFileName);
	}
	
?>