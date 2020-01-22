<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strID="";
	if(isset($_POST["id"]))
	{
		$strID = $_POST["id"];
		
	}
	// echo $strID;
	$DB = Connect();
	$sql1 = "SELECT ChargeSetID, SetName from tblChargeSets where Status=0 and ChargeSetID not in (Select ChargeSetID from tblCharges where ChargeNameID='$strID')";
	$sql = "SELECT ChargeSetID, SetName from tblChargeSets where Status=0";
	$RS = $DB->query($sql);
		if ($RS->num_rows > 0)
		{
?>
			
				
				<select class="form-control required" name="ChargeSetID" >
					<option value="" selected>--SELECT SET--</option>
<?
				while($row = $RS->fetch_assoc())
				{
					
					$ChargeSetID = $row["ChargeSetID"];
					$SetName = $row["SetName"];	
?>
				<option value="<?=$ChargeSetID?>"><?=$SetName?></option>
<?php
				}
?>
				</select>
				</div>
            <?php
			}
			else
			{
				echo "Charge Names are not added. <a href='ManageChargeSet.php' target='chargenames'>Click here to add</a>";
			}
?>

					
