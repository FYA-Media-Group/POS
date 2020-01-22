<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$test="";
	if(isset($_POST["id"]))
	{
		$test = $_POST["id"];
		
	}
	
	$DB = Connect();
	
	$sql = "SELECT EID, EmployeeName FROM tblEmployees WHERE StoreID=$test";
	$RS = $DB->query($sql);
		if ($RS->num_rows > 0)
		{
?>
				<select class="form-control required" name="Technician[]" multiple>
					<option value="" selected>--Select Technician--</option>
<?
				while($row = $RS->fetch_assoc())
				{
					$EID = $row["EID"];
					$EmployeeName = $row["EmployeeName"];	
?>
					<option value="<?=$EID?>"><?=$EmployeeName?></option>
<?php
				}
?>
				</select>
				</div>
            <?php
			}
			else
			{
				echo "Technicians are not added. <a href='ManageEmployees.php' target='Employees'>Click here to add</a>";
			}
?>

					
