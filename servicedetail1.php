<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>

<div class="form-group">
					<label class="col-sm-3 control-label">Qty<span>*</span></label>
		<div class="col-sm-3 ">			
<?php
	$test="";
	$testd=array();
	$cnts=array();
	if(isset($_POST["id"]))
	{
		if(!empty($_POST["id"]))
		{
			$test = $_POST["id"];
			
			//$testd=explode(",",$_POST["id"]);
		}
	
		//$test = $_POST["id"];
		
	
	//echo $test;
//print_r($test);
for($a=0;$a<count($test);$a++)
	{
     
		  $seld=select("*","tblServices","ServiceID='".$test[$a]."'");

	     $seldw=select("*","tblEmployees","StoreID='".$stored."'");

			$servicename=$seld[0]['ServiceName'];

			if($servicename!="")
			{
			?>   
                 
			
			<b><?php echo $seld[0]['ServiceName']  ?></b><br/>
			
		    <input type="hidden" name="ser" id="ser" value="<?=$test[$a]?>" />
			<select class="form-control required" id="qty" name="qty[]" class="qty">
			<option value="">Select Here</option>
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
			
			}
			else
			{
				echo "Please select Services for Category.";
			}
	}
	}
?>


			
			</div>
			</div>