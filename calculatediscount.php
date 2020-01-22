<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

		  
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
	$sericesd=array();
	//$services=array();
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
// code for not allowing the normal admin to access the super admin rights	


	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		
		$member = Filter($_POST["member"]);
		$app_id = Filter($_POST["app_id"]);

		
			$DB = Connect();
			
		
				$seldatap=select("DiscountType","tblMembership","MembershipID='".$member."'");	
				$type=$seldatap[0]['DiscountType'];
          if($type=='1')
		  {
			  $seldata=select("distinct(NotValidOnServices),MembershipName,Discount","tblMembership","MembershipID='".$member."'");	  
		      //print_r($seldata);
			  $services=$seldata[0]['NotValidOnServices'];
			   $membershipname=$seldata[0]['MembershipName'];
			   $Discount=$seldata[0]['Discount'];
			  $sericesd=explode(",",$services);
			  //print_r($sericesd);
			  	$seldatad=select("distinct(ServiceID)"," tblAppointmentsDetails","AppointmentID='".$app_id."'");	
                foreach($seldatad as $val)	
				{
					$serviceid=$val['ServiceID'];
					if(in_array($serviceid,$sericesd))
					{
						
					}
					else
					{
						echo $membershipname.",".$Discount.",".$serviceid.",";
						
						//echo "<br/>";
					}
					
				}		
		  }
		  else
		  {
			  $seldata=select("distinct(NotValidOnServices),MembershipName,Discount","tblMembership","MembershipID='".$member."'");	  
		      //print_r($seldata);
			  $services=$seldata[0]['NotValidOnServices'];
			   $membershipname=$seldata[0]['MembershipName'];
			   $Discount=$seldata[0]['Discount'];
			  $sericesd=explode(",",$services);
			  //print_r($sericesd);
			  	$seldatad=select("distinct(ServiceID),ServiceAmount,qty"," tblAppointmentsDetails","AppointmentID='".$app_id."'");	
                foreach($seldatad as $val)	
				{
					$serviceid=$val['ServiceID'];
					$serviceamount=$val['ServiceAmount'];
					$qty=$val['qty'];
					$amount=$qty*$serviceamount;
					$totalamount=$amount*$Discount/100;
					if(in_array($serviceid,$sericesd))
					{
						
					}
					else
					{
						echo $membershipname.",".$Discount.",".$totalamount.",".$serviceid.",";
						
					}
				}		
		  }
					
						
						$DB->close();
	}
			
			
			
			//echo $data;
			?>
		