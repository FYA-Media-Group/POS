<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?
	$test="";
	if(isset($_POST["data"]))
	{
		// $test = $_POST["data"];
		$data = $_POST['data'];
		$data1 = json_decode($data);
		echo $data1;
		
	}
	echo $data1;
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// $data = $_POST['data'];
		// $data1 = json_decode($data);
		
		$name = $data1['name'];
		$value = $data1[0]->value;
		
		$DB = Connect();
		$sql = "INSERT INTO tbltest ($name) VALUE ($value)";
		if(ExecuteNQ($sql) === true)
		{
			echo "Record Inserted";			
		}
		else
		{
			echo $sql."<br>";
			echo $_POST['name']."<br>";
			echo $_POST['value']."<br>";
			echo $_POST['data']."---<br>---";
			echo var_dump($_POST['data'])."---<br>---";
			echo $name;
		}
		$DB->close();
	}
	else
	{
		echo "Wrong"; 	
	}
?>