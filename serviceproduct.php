<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';?>
<div class="form-group"><label class="col-sm-3 control-label">Select Products<span>*</span></label>
				
		<div class="col-sm-4 ">	
		<select class="form-control required" name="Products[]" multiple style="height:100pt" id="prodidd" onChange="ProdDetails()">

		<option value="" selected>--SELECT Products--</option>

<?php 

	if(isset($_POST["id"]))
	{
		//print_r($_POST);
		//echo $_POST["id"];
		$id=$_POST["id"];
	      
		 
	}
//print_r($iddd);
$DB = Connect();
                                                       
															$sql_display=select("distinct(ProductID)","tblProductsServices","ServiceID='".$id."'");
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
														
																		
																		
																			
																			
																		
														
															
																	
																	
														?>
	
</select>
</div>
</div>