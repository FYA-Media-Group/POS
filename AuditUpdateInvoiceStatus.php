<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$test="";
	if(isset($_POST["id"]))
	{
		$test = $_POST["id"];
		
	}
	// echo $test;
	// die();
			$DB = Connect();
	
				$ChangeStatust="Update tblAppointments SET ApproveStatus='1' where AppointmentID='$test'";
			// echo $ChangeStatus;
				// ExecuteNQ($ChangeStatus);
				if ($DB->query($ChangeStatust) === TRUE) 
				{
						echo 2;
						
				}
				else
				{
					echo "Error: " . $ChangeStatust . "<br>" . $conn->error;
				}
?>				
							
				
			

					
