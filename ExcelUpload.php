<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	foreach($_POST as $key => $val)
	{
		if($key!="Excel")
		{
			echo($key ." : ". $_POST[$key]);
		}
	}
	$now = time(); 
	$date = date("Ymd");
	
	$filepath = "uploads/";
	
	if (!is_dir($filepath))
	{
		mkdir($filepath);         
	}
	
	$filename = $date.$now.$_FILES["Excel"]["name"];
	$target_file = $filepath . basename($filename);
	
	$extension = pathinfo($target_file,PATHINFO_EXTENSION);
	$size = $_FILES["Excel"]["size"];
	
	if($extension != "xls" && $extension != "xlsx") 
	{
		die("Sorry, only Valid Excel files are allowed.");
	}
	
	if ($size > 500000)
	{
		die("Sorry, your file is too large.");
    }
	if (move_uploaded_file($_FILES["Excel"]["tmp_name"], $target_file))
	{
        echo "file-uploaded".$filename;
    }
	else
	{
        echo "Sorry, there was an error uploading your file.";
    }
	
	

}
?>