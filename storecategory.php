 <?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';?>
<div class="form-group"><label class="col-sm-3 control-label">Category<span>*</span></label>
				
		<div class="col-sm-4">	
		<select class="form-control required" name="category[]" multiple style="height:100pt" id="type" onChange="checktype();">
																<option value="" selected>--SELECT Category--</option>
<?php 

$DB = Connect();
if(isset($_POST["storeid"]))
	{
		
		$storeid=$_POST['storeid'];
		
	}
	// echo $storeid;
	for($a=0;$a<count($storeid);$a++)
	{
		$selectCategories=select("distinct(CategoryID)","tblProductsServices","StoreID='".$storeid[$a]."'");
		
		
	}
	foreach($selectCategories as $valp)
	   {
		   $Category[]=$valp['CategoryID'];
		   $sep=select("*","tblCategories","CategoryID='".$valp['CategoryID']."'");
	    $catname=$sep[0]['CategoryName'];
		?>
		  <option value="<?php echo $valp['CategoryID']?>"><?php echo $catname?></option>
		<?php
		  
	   }

															
		 													
$DB->close();																
?>
</select>
</div>
</div>

 