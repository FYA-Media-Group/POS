<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>

<script type="text/javascript" src="assets/widgets/chosen/chosen.js"></script>
                    <script type="text/javascript" src="assets/widgets/chosen/chosen-demo.js"></script>
<?php
	$test="";
	if(isset($_POST["id"]))
	{
		$test = $_POST["id"];
		
	}
	// echo $test;
	$DB = Connect();
	
	$sql = "SELECT ServiceID, ServiceName, ServiceCost FROM tblServices WHERE StoreID=$test";
	$RS = $DB->query($sql);
		if ($RS->num_rows > 0)
		{
?>
				<div class="form-group"><label class="col-sm-3 control-label">Appointment for <span>*</span></label>
					<div class="col-sm-3 ">
						<select class="form-control required chosen-select" onChange="LoadValueasmita();" name="Services[]"  id="Services" style="width:161%" multiple>
							<option value="" align="center"><b>--Select Services--</b></option>
<?
								while($row = $RS->fetch_assoc())
								{
									$ServiceID = $row["ServiceID"];
									$ServiceName = $row["ServiceName"];	
									$ServiceCost = $row["ServiceCost"];	
?>
									<option value="<?=$ServiceID?>"><?=$ServiceName?>, Rs. <?=$ServiceCost?></option>
<?php
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
			<div class="form-group"><label class="col-sm-3 control-label">Appointment for <span>*</span></label>
				<div class="col-sm-3 ">
					<select class="form-control required" onChange="LoadValueasmita();" name="Services[]" style="height:100pt" id="Services" multiple>
							<option value="" ></option>
<?
							
?>
						
					</select>
<?					
					// echo "Services are not added for Selected Store. Add Services Here";?>
					Services are not added for Selected Store. Add Services <a href="http://nailspa.fyatest.website/pos/admin/ManageServices.php">Here</a>
				</div>
			</div>
<?				
		}
?>