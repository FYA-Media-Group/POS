<?php require_once 'setting.fya'; ?>
<?php require_once 'incFirewall.fya'; ?>
	
<?php
	$test="";
	$testd=array();
	$cnts=array();
$datetimes=date('Y-m-d H:i:s');
		
	$giftname = $_POST["giftname"];
	$cust_id = $_POST["cust_id"];
	
	$giftq=Decode($giftname);
	$giftnamet=Encode($giftq);
     $DB = Connect();
     $selp=select("count(GiftVoucherID),ValidityDate,GiftVoucherID,Status","tblGiftVouchers","RedemptionCode='".$giftname."'");
	// print_r($selp);
	 $cnt=$selp[0]['count(GiftVoucherID)'];
	$ValidityDate=$selp[0]['ValidityDate'];
	 $GiftVoucherID=$selp[0]['GiftVoucherID'];
	 $Status=$selp[0]['Status'];
	 $app_id=$_POST['app_id'];
	 $datetime = new DateTime($ValidityDate);
     $getfrom = $datetime->format('Y-m-d');
	 $date=date('Y-m-d');
	 if($cnt>0)
	 {
		 if($getfrom==$date)
		 {
			 $data=8;
		 }
		 else
		 {
			 if($Status=='0')
			 {
				 
				    $selp=select("*","tblAppointments","AppointmentID='".$app_id."'");
	  $memberid=$selp[0]['memberid'];
	  $offerid=$selp[0]['offerid'];
	  $VoucherID=$selp[0]['VoucherID'];
	   if($memberid!='0')
	   {
		   echo 3;
	   }
	   elseif($offerid!='0')
	   {
		    echo 3;
	   }
	   else
	   {
				 
				 $selpr=select("count(memberid)","tblCustomers","CustomerID='".$cust_id."'");

			    $cntm=$selpr[0]['count(memberid)'];
				  $sqlUpdate = "UPDATE tblAppointments SET memberid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
					$sqlUpdate1 = "UPDATE tblAppointments SET offerid='0' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate1);
			
			       $sqlUpdate = "UPDATE tblAppointments SET VoucherID='".$GiftVoucherID."' WHERE AppointmentID='".$app_id."'";
					ExecuteNQ($sqlUpdate);
					
					$sqlUpdate1 = "UPDATE tblGiftVouchers SET Status='1',RedempedBy='".$app_id."',RedempedDateTime='".$datetimes."' WHERE GiftVoucherID='".$GiftVoucherID."'";
					ExecuteNQ($sqlUpdate1);
					$data=5;
	   }
			 }
			 elseif($Status=='1')
			 {
				 $data=4;
			 }
			 else
			 {
				 
			 }
			
			 
		 }
	 }
	 else
	 {
		  $data=2;
	 }
	 echo $data;
$DB->close();			

	$total="";
?>


			