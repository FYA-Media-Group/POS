<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';?>
<div class="form-group"><label class="col-sm-3 control-label">Select Service<span>*</span></label>
				
		<div class="col-sm-4 ">	
		<select class="form-control required" name="ServiceID"  id="ServiceID" onChange="checkproduct();">

		<option value="" selected>--SELECT Service--</option>

<?php 

	if(isset($_POST["type"]))
	{
		//echo $_POST["id"];
		$type=$_POST["type"];
	
	}
  $storeid=$_POST['storeid'];
$DB = Connect();
															$sql_display=select("distinct(ServiceID)","tblProductsServices","CategoryID='".$type."' and StoreID='".$storeid."'");
															//print_r($sql_display);
														
															 foreach($sql_display as $val)
															 {
																$serviceid[]=$val['ServiceID'];
																
																			
															 }
														$serviceidss=array_unique($serviceid);
													//	print_r($serviceidss);
																		
															for($a=0;$a<count($serviceidss);$a++)
															{
																if($serviceidss[$a]=="")
																 {
																	
																 }
																 else
																 {
																	  $selpt=select("DISTINCT(ServiceID)","tblServices","ServiceID='".$serviceidss[$a]."'");
																	        	$serviceidd=$selpt[0]['ServiceID'];
																			if($serviceidd==$serviceidss[$a])
																			{
																				$seti=select("*","tblServices","ServiceID='".$serviceidd."'");
																			$servicename=$seti[0]['ServiceName'];
																			$ServiceCost = $seti[0]["ServiceCost"];
																				?>
																		<option value="<?=$serviceidd?>"><?php echo $servicename?>, Rs. <?=$ServiceCost?></option>
																	<?
																			}
																			else
																			{
																				
																			}
																				
																 }			
															}																
																 
																			
										
															
																	
																	
														?>
	
</select>
</div>
</div>