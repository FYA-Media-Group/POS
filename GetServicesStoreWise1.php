<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$test="";
	$ID=array();
	if(isset($_POST["id"]))
	{
		//echo $_POST["id"];
		$ID=$_POST["id"];
	
		
	}
//print_r($ID);
	?>
	<div class="form-group"><label class="col-sm-3 control-label">Choose Services<span>*</span></label>
					<div class="col-sm-4">
						<select class="form-control" onChange="LoadValueasmita();" name="ServiceID[]"  style="height:100pt" id="Services" multiple>
							<option value="" selected>--Select--</option>
							<?php
	$DB = Connect();
	for($i=0;$i<count($ID);$i++)
	{
		$sql = "SELECT distinct(ServiceID) FROM tblProductServices WHERE CategoryID=$ID[$i] and StoreID='$strStore'";
		echo $sql;
		$RS = $DB->query($sql);
			if ($RS->num_rows > 0)
			{
?>
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
						
<?php
			}
				
	}
?>
</select>
					</div>
				</div>