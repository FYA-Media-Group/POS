<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>

<div class="form-group"><label class="col-sm-3 control-label">Select Employee<span>*</span></label>
				<div class="col-sm-3 ">
					<select class="form-control required" name="TechnicianSelect[]" multiple>
						<option value="" selected>--Select Employees--</option>
<?php
	$test="";
	$testd=array();
	if(isset($_POST["id"]))
	{
		if(!empty($_POST["id"]))
		{
			$test = $_POST["id"];
			//$testd=explode(",",$_POST["id"]);
		}
	
		//$test = $_POST["id"];
		
	}
	//echo $test;
//print_r($test);
for($a=0;$a<count($test);$a++)
	{
     
		  $seld=select("*","tblEmployeesServices","ServiceID='".$test[$a]."'");
	
	  	$EmployeeID=$seld[0]['EID'];
	
	$seldp=select("*","tblEmployees","EID='".$EmployeeID."'");
	$empname=$seldp[0]['EmployeeName'];
						if($EmployeeID!="")
						{
	?>

							<option value="<?=$EmployeeID?>"><?=$empname?></option>

					
<?php
			}
			else
			{
				echo "Please select Services for Employee.";
			}
	}
?>

</select>
				</div>
			</div>