<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';?>
<script type="text/javascript" src="assets/widgets/chosen/chosen.js"></script>
                    <script type="text/javascript" src="assets/widgets/chosen/chosen-demo.js"></script>
<div class="form-group"><label class="col-sm-3 control-label">Select Service<span>*</span></label>
				
		<div class="col-sm-3 ">	
		<select class="form-control required chosen-select" name="ServiceID[]" multiple  id="ServiceID" onChange="LoadValueasmita();">
		<option value="" align="center"><b>--Select Services--</b></option>

<?php 


		$type=$_POST["type"];
  $storeid=$_POST['storeid'];
  //print_r($storeid);
$DB = Connect();
                                                  foreach($type as $vap)
												  {
													  foreach($storeid as $vapp)
													  {
														   $sql_display=select("distinct(ServiceID)","tblProductsServices","CategoryID='$vap' and StoreID='$vapp'");
														   foreach($sql_display as $val)
															         {
																		$servicessr[]=$val['ServiceID'];
																		 
																	 }
													  }
												  }
                                                       
													  $servicess=array_unique($servicessr);
																		
														for($t=0;$t<count($servicess);$t++)
															 {
																
																if($servicess[$t]=="")
																 {
																	
																 }
																 else
																 {
																	  $selpt=select("DISTINCT(ServiceID)","tblServices","ServiceID='".$servicess[$t]."'");
																	        	$serviceidd=$selpt[0]['ServiceID'];
																			if($serviceidd==$servicess[$t])
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