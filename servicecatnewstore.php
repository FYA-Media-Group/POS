<?php require_once("setting.fya"); ?>

<?php require_once 'incFirewall.fya';?>

<div class="form-group"><label class="col-sm-3 control-label">Select Service<span>*</span></label>

		<div class="col-sm-3 ">	

		<select class="form-control required" name="ServiceID[]" multiple  id="ServiceID"  style="height:200pt; width=200pt;">

		<option value="" selected>--SELECT Service--</option>



<?php 
$type=$_POST["typef"];
$DB = Connect();
                                                  /* $setistore=select("StoreID","tblStores","StoreID!='0'");
	                                               foreach($setistore as $vapp)
													  { */
														  for($i=0;$i<count($type);$i++)
														  {
															   $sql_display=select("distinct(ServiceID)","tblProductsServices","CategoryID='$type[$i]' and StoreID='3'");

														   foreach($sql_display as $val)

															         {

																		$servicessr[]=$val['ServiceID'];

																		 

																	 }

														  }
														  unset($type);

														
													/*   } */

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
                                                                            $ServiceCode=$seti[0]['ServiceCode'];
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