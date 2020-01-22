<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>
	   	<select id="giftcvalidity" style="width:45%;" class="form-control giftcvalidity required" name="giftcvalidity">
		<option value="0">Select Validity</option>
<?php
	
	if(isset($_POST["id"]))
	{
		if(!empty($_POST["id"]))
		{
			$test = $_POST["id"];
			$store=$_POST["store"];
			$qty=$_POST["qty"];
		
			$app_id=$_POST["app_id"];
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

			