<?php require_once 'setting.fya'; ?>

<?php require_once 'incFirewall.fya'; ?>


<?php

	$DB = Connect();
	$emp = $_POST["emp"];
	$store = $_POST["store"];
		
	$sql = "SELECT * FROM tblEmployees WHERE StoreID='$store' and EID='$emp'";

	$RS = $DB->query($sql);

		if ($RS->num_rows > 0)

		{

		while($row = $RS->fetch_assoc())

						{

						
							$EID = $row["EID"];
							$EmployeeName = $row["EmployeeName"];
							
							//$EID = $row["EID"];
							$EmployeeCode = $row["EmployeeCode"];
							
							//$EID = $row["EID"];
							$EmployeeAddress = $row["EmployeeAddress"];
							
							$EmployeePincode = $row["EmployeePincode"];
							$EmployeeEmailID = $row["EmployeeEmailID"];
							
							$EmployeeMobileNo = $row["EmployeeMobileNo"];
							$JoinDate = $row["JoinDate"];
							
							$Target = $row["Target"];
							
?>											

	                                         <div class="form-group"><label class="col-sm-3 control-label">Employee Code<span>*</span></label>
												<div class="col-sm-3"><input type="text" readonly name="EmployeeCode" class="form-control required"  id="EmployeeCode" value="<?=$EmployeeCode?>"></div>
											</div>	
                                             <div class="form-group"><label class="col-sm-3 control-label">Employee Address<span>*</span></label>
															<div class="col-sm-3"><textarea rows="4" name="EmployeeAddress" id="EmployeeAddress" class="form-control required " readonly placeholder="Employee Address"><?=$EmployeeAddress?></textarea></div>
											</div>
											  <div class="form-group"><label class="col-sm-3 control-label">Employee Pincode<span>*</span></label>
															<div class="col-sm-3"><input rows="4" name="EmployeePincode" id="EmployeePincode" class="form-control required  " value="<?=$EmployeePincode?>" readonly placeholder="Employee Pincode"></div>
											</div>
											  <div class="form-group"><label class="col-sm-3 control-label">Employee Email<span>*</span></label>
															<div class="col-sm-3"><input readonly rows="4" name="EmployeeEmailID" id="EmployeeEmailID" class="form-control required  " value="<?=$EmployeeEmailID?>" placeholder="Employee EmailID"></div>
											</div>
											  <div class="form-group"><label class="col-sm-3 control-label">Employee Mobile<span>*</span></label>
															<div class="col-sm-3"><input readonly rows="4" name="EmployeeMobileNo" id="EmployeeMobileNo" class="form-control required  " value="<?=$EmployeeMobileNo?>" placeholder="Employee MobileNo"></div>
											</div>
											  <div class="form-group"><label class="col-sm-3 control-label">Join Date<span>*</span></label>
															<div class="col-sm-3"><input readonly rows="4" name="JoinDate" id="JoinDate" class="form-control required  " placeholder="JoinDate" value="<?=date('d-m-y',strtotime($JoinDate))?>"></div>
											</div>
										
											
											<div class="form-group"><label class="col-sm-3 control-label">Target<span>*</span></label>
															<div class="col-sm-3"><input readonly type="text" name="Target" id="Target" class="form-control required" placeholder="Target" value="<?=$Target?>"></div>
													</div>	
<?php
									
							
						}

		}

		?>
					</select>

<?					

					



					

