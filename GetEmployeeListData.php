<?php require_once 'setting.fya'; ?>

<?php require_once 'incFirewall.fya'; ?>





<?php

	$DB = Connect();

	$test="";

	
		$store = $_POST["store"];
		
	$sql = "SELECT * FROM tblEmployees WHERE StoreID='$store'";

	$RS = $DB->query($sql);

		if ($RS->num_rows > 0)

		{

			// echo "In If";

?>				

			<div class="form-group"><label class="col-sm-3 control-label">Employee<span>*</span></label>

				<div class="col-sm-3 ">	

				<select class="form-control required" name="empid" id="empid" onChange="LoadEmploywwDetails(this.value);">

					<option value="" selected>--Select Employee--</option>

<?

						while($row = $RS->fetch_assoc())

						{

						
							$EID = $row["EID"];
							$EmployeeName = $row["EmployeeName"];


									

?>											

											<option value="<?=$EID?>"><?=$EmployeeName?></option>

<?php
									
							
						}

?>						



				</select>

				</div>

			</div>

<?php

		}

		?>
					</select>

<?					

					



					

