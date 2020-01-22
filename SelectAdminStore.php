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
	if($test=="6")
	{
		$sql = "SELECT StoreID, StoreName FROM tblStores where Status=0";
		// echo $sql;
		$RS = $DB->query($sql);
			if ($RS->num_rows > 0)
			{
?>
				<div class="form-group"><label class="col-sm-3 control-label">Select Store<span>*</span></label>
					<div class="col-sm-3 ">
						<select class="form-control required" name="StoreID" id="StoreID">
							<option value="" selected>--Select Store--</option>
<?
								while($row = $RS->fetch_assoc())
								{
									$strStoreID = $row["StoreID"];
									$strStoreName = $row["StoreName"];	
?>
									<option value="<?=$strStoreID?>"><?=$strStoreName?></option>
<?php
								}
?>
						</select>
					</div>
				</div>
<?php
			}
	}
?>			