<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$DB = Connect();
	$test="";
	
	if(isset($_POST["id"]))
	{
		$test = $_POST["id"];
		
	}

	
// die();
	
	$sql = "SELECT ProductID FROM tblNewProductCategory WHERE CategoryID=$test";
	$RS = $DB->query($sql);
		if ($RS->num_rows > 0)
		{
			// echo "In If";
?>				
			<div class="form-group"><label class="col-sm-3 control-label">Products<span>*</span></label>
				<div class="col-sm-3 ">	
				<select class="form-control" name="Products[]" multiple id="Products" onChange="LoadValueproduct();" style="height:200pt; width=200pt;">
					<option value="" selected>--Select Product--</option>
<?
						while($row = $RS->fetch_assoc())
						{
							// echo "In While";
							$strProductID = $row["ProductID"];
							
							$SelectProductName="Select ProductID, ProductName, PerQtyServe, HasVariation from tblNewProducts Where ProductID='$strProductID'";
							$RS1 = $DB->query($SelectProductName);
							if ($RS1->num_rows > 0)
							{
									while($row1 = $RS1->fetch_assoc())
									{
										$ProductName = $row1["ProductName"];
										$PerQtyServe = $row1["PerQtyServe"];
										$HasVariation = $row1["HasVariation"];
										if($HasVariation=='0')
										{
?>											
											<option value="<?=$strProductID?>"><?=$ProductName?>&nbsp;&nbsp;&nbsp;<?=$PerQtyServe?></option>
<?											
										}
										else if($HasVariation!='0')
										{
											$SelectVariation="Select Size,PerQtyServe,ProductStockID from tblNewProductStocks where ProductID='$strProductID'";
											$RS3 = $DB->query($SelectVariation);
											if ($RS3->num_rows > 0)
											{
												while($row3 = $RS3->fetch_assoc())
												{
													$Size = $row3["Size"];
													$strPerQtyServe = $row3["PerQtyServe"];
													$ProductStockID = $row3["ProductStockID"];
?>										
													<option value="<?=$ProductStockID?>"><?=$ProductName?>&nbsp;&nbsp;&nbsp;<?=$Size?>&nbsp;&nbsp;&nbsp;<?=$strPerQtyServe?></option>
<?											
												}
											}
										}
									}					
							}
						}
?>						

				</select>
				</div>
			</div>
<?php
		}
		else
		{
?>
			<div class="form-group"><label class="col-sm-3 control-label">Products<span>*</span></label>
				<div class="col-sm-4">	
					<select class="form-control required" name="Products[]" multiple id="Products" onChange="LoadValueproduct();" style="height:130pt">
					<option value="" selected>--Select Product--</option>
<?
					echo "Products are not added for Selected Category. <a href='ManageProductMaster.php' target='Products'>Click here to add</a>";
?>
				</div>
			</div>
<?			
		}
?>
					</select>
<?					
					

					
