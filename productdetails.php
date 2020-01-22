<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';?>
                  <div class="form-group">
			
			<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
			<thead><tr><th></th><th>Product Name</th><th>Available Stock</th><th>Order Stock</th><th>Action</th></tr></thead>
			<tfoot><tr><th></th><th>Product Name</th><th>Available Stock</th><th>Order Stock</th><th>Action</th></tr></tfoot>
			<tbody>
			
				<?php 

	if(isset($_POST["id"]))
	{
		//print_r($_POST);
		//echo $_POST["id"];
		$id=$_POST["id"];
	     
		 $iddd=array_unique($id);
	}
$service=$_POST["service"];
$DB = Connect();
                                                        for($i=0;$i<count($iddd);$i++)
														{
															
																			$selpt=select("*","tblProductsServices","ProductID='".$iddd[$i]."' and StoreID='".$strStore."' and ServiceID='".$service."'");
																			foreach($selpt as $val)
																			{
																			
																			$Status=$val['Status'];
																			
																			$proddid=$val['ProductID'];
																			$ProductStockID=$val['ProductStockID'];
																				
																		
																			if($Status=='1')
																			{
																				$selppp=select("*","tblNewProductStocks","ProductStockID='".$ProductStockID."'");
																				$selppptt=select("*","tblNewProducts","ProductID='".$proddid."'");
																				$ProductName=$selppptt[0]['ProductName'];
																			
																				$Color=$selppp[0]['Color'];
																			
																					
																						$sep=select("*","tblStoreProduct","ProductStockID='".$ProductStockID."' and StoreID='".$strStore."'");
																						$Stock=$sep[0]['Stock'];
																						if($Stock!='0')
																						{
																							?>
																					<tr><td></td><td><b><?=$ProductName?></b></td><td></td><td ></td>
																					</tr>
																					<tr><td><input type="hidden" name="productid[]" id="productid" value="<?=$proddid?>" ></td><td style="color:red"><b><input type="hidden" name="prodstockid" id="prodstockid" value="<?= $ProductStockID; ?>" /><?=$Color?></b></td><td><input type="text" name="productstock" id="productstock" class="productstock" value="<?= $Stock ?>" readonly /></td><td><input type="text" name="productqty" id="productqty" class="productqty"/></td><td><input type="button" value="Add To Order" class="btn ra-100 btn-primary" onClick="orderconfirm(this)"/></td></tr>
																					<?php
																						}
																						else
																						{
																							?>
																							<tr><td></td><td></td><td></td><td><b>Stock is Null</b></td><td></td></tr>
																							<?php
																						}
																					
																					
																						
																				
																				
																			}
																			else
																			{
																				$sep=select("*","tblStoreProduct","ProductID='".$proddid."' and StoreID='".$strStore."'");
																				$selppptt=select("*","tblNewProducts","ProductID='".$proddid."'");
																				$ProductName=$selppptt[0]['ProductName'];
																			
																				foreach($sep as $valp)
																				{
																					$Stock=$valp['Stock'];
																					if($Stock!='0')
																						{
																							?>
																			
																					<tr><td><input type="hidden" name="productid[]" id="productid" value="<?=$proddid?>" ></td><td><b><input type="hidden" name="prodstockid" id="prodstockid" value="0" /><?=$ProductName?></b></td><td><input type="text" name="productstock" id="productstock" class="productstock" value="<?= $valp['Stock'] ?>" readonly /></td><td><input type="text" name="productqty" id="productqty" class="productqty"/></td><td><input type="button" value="Add To Order" class="btn ra-100 btn-primary" onClick="orderconfirm(this)"/></td></tr>
																					<?php
																						}
																						else
																						{
																							?>
                                                                                          <tr><td></td><td></td><td></td><td><b>Stock is Null</b></td><td></td></tr>						
																						  <?php
																						}
																				}
																			} 
																	
																			
																			?>
																		
																			
																			<?php
															
																			}
																		
																		
																			
																			
																		
														
															
																	
														}		
														?>
														</tbody>
														</table>

</div>