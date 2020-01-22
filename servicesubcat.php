<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';?>
<div class="form-group"><label class="col-sm-3 control-label">Select Products<span>*</span></label>
				
		<div class="col-sm-4">	
		<select class="form-control required" name="Products[]" multiple style="height:200pt" id="prodidd" onChange="LoadValueproduct();">

		<option value="" selected>--SELECT Products--</option>

<?php
	if(isset($_POST["type"]))
	{
		//echo $_POST["id"];
		$type=$_POST["type"];
	    $types=explode(",",$type);
		$tyepp=array_unique($types);
	}
													$DB = Connect();
													for($i=0;$i<count($tyepp);$i++)
													{
														$sql_display=select("distinct(ProductID)","tblNewProductCategory","CategoryID='".$tyepp[$i]."'");
														//print_r($sql_display);
														
														foreach($sql_display as $val)
														{
															$prodid=$val['ProductID'];
															$selpt=select("*","tblNewProducts","ProductID='$prodid'");
															$prodname=$selpt[0]['ProductName'];
															$proddid=$selpt[0]['ProductID'];
															if($proddid==$prodid)
															{
?>
																<option value="<?=$prodid?>"><?php echo $prodname?></option>
<?
															}			
														}		
													}			
?>
</select>
</div>
</div>