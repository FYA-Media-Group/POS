<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?php
	$DB = Connect();
	
	$customer = DecodeQ($_POST["customer"]);
	$comment = $_POST["comment"];
	$typecomment= $_POST["typecomment"];
	if($comment!="")
	{
		$comment=$comment;
	}
	else
	{
		$comment="Customer Complaints";
	}
	$app=$_POST["app"];
	
	$selp=select("*","tblAdmin","AdminRoleID='39'");
	$adminemail="noor@nailspaexperience.com";
	//$adminemail="yogitafya@hotmail.com";+

	$selpt=select("*","tblAdmin","AdminRoleID='4'");
	$operationemail="operations@nailspaexperience.com";
	//$operationemail="yogitafya@hotmail.com";
	
	$selptrt=select("*","tblAppointments","AppointmentID='".$app."'");
	$StoreID=$selptrt[0]['StoreID'];
	
	$selptrty=select("*","tblCustomers","CustomerID='".$customer."'");
	$CustomerFullName=$selptrty[0]['CustomerFullName'];
	$CustomerEmailID=$selptrty[0]['CustomerEmailID'];
	$CustomerMobileNo=$selptrty[0]['CustomerMobileNo'];
	$memberid=$selptrty[0]['memberid'];
	
	
	$selptrtqi=select("*","tblMembership","MembershipID='".$memberid."'");
	$MembershipName=$selptrtqi[0]['MembershipName'];
	
	
	$selptrtqistore=select("*","tblStores","StoreID='".$StoreID."'");
	$StoreName=$selptrtqistore[0]['StoreName'];
	
	
	$msg ="Customer Name :-".$CustomerFullName."<br/>";
	$msg .="Email :-".$CustomerEmailID."<br/>";
	$msg .="Mobile :-".$CustomerMobileNo."<br/>";
	$msg .="Membership :-".$MembershipName."<br/>";
	$msg .="Store :-".$StoreName."<br/>";
	$selptrtty=select("*","tblAppointmentsDetailsInvoice","AppointmentID='".$app."'");
	foreach($selptrtty as $vat)
	{
		$service=$vat['ServiceID'];
		$serviceamount=$vat['ServiceAmount'];
		$set=select("*","tblServices","ServiceID='".$service."'");
	    $ServiceName=$set[0]['ServiceName'];
		$msg .="Service :- $ServiceName<br/>";
		$msg .="Service Amount :- $serviceamount<br/>";
	}
	
	
	$date=Date('Y-m-d');
	$datet=date("H:i:s", time());
	$strTo=$adminemail.",".$operationemail;
    


    if($strTo=="")
	{
		echo "Email Id Cannot Blank";
	}
	else
	{
		   
		     $sqlInsert1 = "Insert into tblCustomerRemarks(AppointmentID, CustomerID, Status,Remark,UpdateDate,UpdateTime,UpdatedBy,StoreID,CommentType) values('".$app."','".$customer."', '0','".$comment."','".$date."','".$datet."','".$strAdminID."','".$StoreID."','".$typecomment."')";
							 //$DB->query($sqlInsert1); 
							 if ($DB->query($sqlInsert1) === TRUE) 
							{
								$last_id7 = $DB->insert_id;
								
								
		    $sqlUpdate2 = "UPDATE tblAppointments SET CustomerRemark='".$comment."',CommentType='".$typecomment."' WHERE AppointmentID='".$app."'";
			ExecuteNQ($sqlUpdate2);
			
			                                      if($typecomment=='1')
													{
														$CommentTypes="Appointment Booked";
													}
													elseif($typecomment=='2')
													{
														$CommentTypes="Call Later";
													}
													elseif($typecomment=='3')
													{
														$CommentTypes="Client Unavailable";
													} 
												   elseif($typecomment=='4')
													{
														$CommentTypes="Client Travelling";
													}
													elseif($typecomment=='5')
													{
														$CommentTypes="Unhappy with Service/Staff";
													}
													elseif($typecomment=='6')
													{
														$CommentTypes="Service is Expensive";
													}
													elseif($typecomment=='7')
													{
														$CommentTypes="Unhappy with Products";
													}
													elseif($typecomment=='8')
													{
														$CommentTypes="Occassional Visitor";
													}
													elseif($typecomment=='9')
													{
														$CommentTypes="Not Interested";
													} 
													
	
			
			$strFrom = "appnt@nailspaexperience.com";
			$strSubject = $CommentTypes;
			$strBody = $msg;
		    $strbody1="<html><head><title>Invoice</title></head><body> $strBody </body></html>";
			$headers = "From: $strFrom\r\n";
			$headers .= "Content-type: text/html\r\n";
            $strBodysa = $strbody1;
			// Mail sending 
			$retval = mail($strTo,$strSubject,$strBodysa,$headers);

			if( $retval == true )
			{
				
				echo "Email sent to " . $strTo;
			}
			else
			{
				
				echo "<font color='red'>Email sending failed to " . $strTo . "</font>";
			}
							}
	}
	

?>