<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$DB = Connect();
	$sql = "Select ServiceID from tblServices where Status='0'";
	$RS = $DB->query($sql);
	if ($RS->num_rows > 0) 
	{
		$counter = 0;
		while($row = $RS->fetch_assoc())
		{
			$counter ++;
		
			$ServiceID = $row["ServiceID"];
			echo $ServiceID.'\n';
			
		}
	}
	$sql2 = "Select ServiceID from tblServices where Status='0'";
	$RS2 = $DB->query($sql2);
	if ($RS2->num_rows > 0) 
	{
		$counter = 0;
		while($row2 = $RS2->fetch_assoc())
		{
			$counter ++;
		    echo $counter."<br/>";
			
			
		}
	}
	
	
?>