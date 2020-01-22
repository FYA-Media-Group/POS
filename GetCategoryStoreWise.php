<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$test="";
	if(isset($_POST["id"]))
	{
		$test = $_POST["id"];
	}
	// echo $test;
	$DB = Connect();
	$sql= "SELECT distinct CategoryID from tblProductCategory where StoredID=$test";
	// echo $sql;
	// $sql_disp = "SELECT * FROM tblCategories";
	
	// $sql = "SELECT ServiceID, ServiceName, ServiceCost FROM tblServices WHERE StoreID=$test";
	$RS = $DB->query($sql);
		if ($RS->num_rows > 0)
		{
?>
				<div class="form-group"><label class="col-sm-3 control-label">Select Category<span>*</span></label>
					<div class="col-sm-3 ">
						<select class="form-control required" onChange="LoadValueasmita();" name="Services[]" style="height:100pt" id="Services" multiple>
							<option value="" selected>--Select Category--</option>
<?
								while($row = $RS->fetch_assoc())
								{
									$strCategoryID = $row["CategoryID"];
									$ServiceName = $row["ServiceName"];	
									$ServiceCost = $row["ServiceCost"];	
															$sql_disp = "SELECT distinct CategoryName FROM tblCategories";
															$RS_disp = $DB->query($sql_disp);
															if ($RS_disp->num_rows > 0) 
															{
																while($row_disp = $RS_disp->fetch_assoc())
																{
																	$CategoryName = $row_disp["CategoryName"];
																	$CategoryID = $row_disp["CategoryID"];
																	if (in_array("$CategoryID", $strCategoryID))
																	{
?>																		
																		<!--<option value="<?//=$strCategoryID?>"><?//=$CategoryName?></option>-->
<?																		
																	}
																}
															}
?>
									<option value="<?=$strCategoryID?>"><?=$CategoryName?></option>
<?php
								}
?>
						</select>
<?						
						// $CatName=select('*','tblcategories','strCategoryID');
									// print_r($CatName);
?>									
					</div>
				</div>
<?php
			}
			else
			{
?>
				<div class="col-sm-3 load_charges">
<?
				echo "Select Store to select services.";
?>
				</div>
<?				
			}
?>