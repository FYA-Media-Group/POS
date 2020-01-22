<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>

<div class="form-group"><label class="col-sm-3 control-label">Services<span>*</span></label>
				
		<div class="col-sm-3 ">			
<?php
	$test="";
	$testd=array();
	$cnts=array();
	if(isset($_POST["id"]))
	{
		// $test = $_POST["id"];
		// $stored=$_POST["stored"];
		if(!empty($_POST["id"]))
		{
			$test = $_POST["id"];
			$stored=$_POST["stored"];
			//$testd=explode(",",$_POST["id"]);
		}
	
		//$test = $_POST["id"];
		// echo $test;
		
	}
	//echo $test;
// print_r($test);
	for($a=0;$a<count($test);$a++)
	{
     
		$seld=select("distinct(ServiceID)","tblProductsServices","CategoryID='".$test[$a]."'");
		// print_r($seld);
		$seldw=select("distinct(MECID)","tblEmployees","StoreID='".$stored."'");
		foreach($seldw as $vay)
		{
			$cnts[]=$vay['MECID'];
		}
			//$id=$seldw[0]['MECID'];
			$ServiceID=$seld[0]['ServiceID'];
	
			if($ServiceID!="")
			{
?>   
			<b><?php echo $seld[0]['ServiceID']?></b><br/>
			<select class="form-control required" name="categoryselect[]" multiple>
			<option value="" selected>--Select Employee Category--</option>
			<?php 
			for($i=0;$i<count($cnts);$i++)
			{
				$seldp=select("*","tblMasterEmployeeCategory","MECID='".$cnts[$i]."'");
?>
				<option value="<?= $seldp[0]['MECID']?>"><?= $seldp[0]['ServiceID']?></option>
<?php
			}
			
?>
			 </select>
			<label class="col-sm-3 control-label">Qty<span>*</span></label>
			<select class="form-control required" id="qty" name="qty[]">
			<option value="0">Select Here</option>
<?php 
			$count=1;
			while($count<11)
			{
?>
				<option value="<?= $count ?>"><?= $count ?></option>
<?php
				$count++;
			}
?>
			</select>
<?php
			 unset($cnts);
			}
			else
			{
				echo "Please select Services for Category.";
			}
	}
?>


			
			</div>