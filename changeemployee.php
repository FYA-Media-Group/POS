<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
 	<select class="form-control required" id="emp" name="emp">
	<option value="0" selected>All</option>
<?php
	$strPageTitle = "Manage Customers | Nailspa";
	$strDisplayTitle = "Manage Customers for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblServices";
	$strMyTableID = "ServiceID";
	//$strMyField = "CustomerMobileNo";
	$strMyActionPage = "appointment_invoice.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
// code for not allowing the normal admin to access the super admin rights	


	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		
		$store = $_POST["store"];
	  
			$DB = Connect();
		
  if($store=='0')
  {
	   $selp=select("*","tblEmployees","StoreID!='0' AND Status!='1'");
  foreach($selp as $vq)
  {
	  ?>
	  <option value="<?=$vq['EID']?>"><?=$vq['EmployeeName']?></option>
	  <?php
  }
  }
  else
  {
	   $selp=select("*","tblEmployees","StoreID='".$store."' AND Status!='1'");
  foreach($selp as $vq)
  {
	  ?>
	  <option value="<?=$vq['EID']?>"><?=$vq['EmployeeName']?></option>
	  <?php
  }
  }
 
						
						$DB->close();
	}
			
			
			
			
			?>
			</select>