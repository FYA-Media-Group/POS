<?php// require_once("setting.fya"); ?>
<?php //require_once 'incFirewall.fya'; ?>

<?php
	
	// $strStoreID = $_POST["StoreID"];
	// if ($_SERVER["REQUEST_METHOD"] == "POST")
	// {	
		// echo $strStoreID;
	// }
?>

<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$test="";
	if(isset($_POST["StoreID"]))
	{
		$test = $_POST["StoreID"];
		
	}
	// echo $test;
	$DB = Connect();
	
	$sql = "SELECT ServiceID, ServiceName, ServiceCost FROM tblServices WHERE StoreID=$test";
	echo $sql;
	$RS = $DB->query($sql);
		if ($RS->num_rows > 0)
		{
?>
				<select class="form-control required" name="ServiceID[]" id="ServiceID" multiple>
					<option value="" selected>--Select Services--</option>
<?
					while($row = $RS->fetch_assoc())
					{
						$ServiceID = $row["ServiceID"];
						$ServiceName = $row["ServiceName"];	
						$ServiceCost = $row["ServiceCost"];	
?>
						<option value="<?=$ServiceID?>"><?=$ServiceName?>, Rs. <?=$ServiceCost?></option>
<?php
					}
?>
				</select>
				</div>
            <?php
			}
			else
			{
				echo "Services are not added. <a href='ManageServices.php' target='Employees'>Click here to add</a>";
			}
?>

					
