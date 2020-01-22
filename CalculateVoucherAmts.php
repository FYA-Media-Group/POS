<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>
	   <div class="form-group"><label class="col-sm-3 control-label">Validity <span>*</span></label>
					<div class="col-sm-3 ">	<select id="giftcvalidity"  class="form-control giftcvalidity required" name="giftcvalidity">
		<option value="">Select Validity</option>
<?php
	
	if(isset($_POST["id"]))
	{
		$DB = Connect();
		if(!empty($_POST["id"]))
		{
			$test = $_POST["id"];
			$store=$_POST["store"];
			$qty=$_POST["qty"];
	
			$cust_id=$_POST["cust_id"];
			$date=date('Y-m-d');
			$datetime=date('Ymd');
		    $date2 = date('Y-m-d', strtotime("+2months"));
			$selp=select("CustomerFullName","tblCustomers","CustomerID='".$cust_id."'");
			$cust_name=$selp[0]['CustomerFullName'];
            $t=time();
			$code='GV'.$datetime.$t;
			$codef=Encode($code);
		    $validty=$date2;
			$voucheramt=$qty*$test;
			if($voucheramt<=3000)
			{
				?>
				<option value="30">30 Days</option>
				<?php
			}
			elseif($voucheramt>=3000 && $voucheramt<=10000)
			{
				?>
				<option value="30">30 Days</option>
				<option value="60">60 Days</option>
				<?php
			}
			elseif($voucheramt>=10000 && $voucheramt<=20000)
			{
				?>
				<option value="30">30 Days</option>
				<option value="60">60 Days</option>
				<option value="90">90 Days</option>
				<?php
			}
			elseif($voucheramt>=30000 && $voucheramt<=50000)
			{
				?>
				<option value="30">30 Days</option>
				<option value="60">60 Days</option>
				<option value="90">90 Days</option>
				<option value="180">180 Days</option>
				<?php
			}
			else
			{
				?>
				<option value="30">30 Days</option>
				<option value="60">60 Days</option>
				<option value="90">90 Days</option>
				<option value="180">180 Days</option>
				<option value="365">365 Days</option>
				<?php
			}
		}
	
		//$test = $_POST["id"];
		
	}

$DB->close();			


?>
	</select> 
</div>
				</div>
			