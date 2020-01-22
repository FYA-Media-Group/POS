<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$test="";
	if(isset($_POST["id"]))
	{
		$test = $_POST["id"];
		
		
	}
	// echo $test;
	
	
	$DB = Connect();
	
	$sql = "SELECT ServiceID, ServiceName FROM tblServices WHERE StoreID=$test";
	// echo $sql;
	$RS = $DB->query($sql);
		if ($RS->num_rows > 0)
		{
?>
			<div>
				<div class="form-group"><label class="col-sm-3 control-label" >Service Name<span>*</span></label>
				<div class="col-sm-4 ">
				<select class="form-control required" name="Technician[]" multiple>
					<option value="" selected>--Select Services--</option>
<?
				while($row = $RS->fetch_assoc())
				{
					$ServiceID = $row["ServiceID"];
					$ServiceName = $row["ServiceName"];	
?>
					<option value="<?=$ServiceID?>"><?=$ServiceName?></option>
<?php
				}
?>
				</select>
				</div>
			<div>
		</div>
            <?php
			}
			else
			{
				echo "Technicians are not added. <a href='ManageServices.php' target='Services'>Click here to add</a>";
			}
?>

					
