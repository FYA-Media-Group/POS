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
	
	$date=Date('Y-m-d');
	$datet=date("H:i:s", time());
	
	$selptrt=select("*","tblAppointments","AppointmentID='".$app."'");
	$StoreID=$selptrt[0]['StoreID'];
	 $sqlInsert1 = "Insert into tblCustomerRemarks(AppointmentID, CustomerID, Status,Remark,UpdateDate,UpdateTime,UpdatedBy,StoreID,NonCommentType) values('".$app."','".$customer."', '0','".$comment."','".$date."','".$datet."','".$strAdminID."','".$StoreID."','".$typecomment."')";
							 //$DB->query($sqlInsert1); 
							 if ($DB->query($sqlInsert1) === TRUE) 
							{
								$last_id7 = $DB->insert_id;
								
								
		    $sqlUpdate2 = "UPDATE tblAppointments SET NonCustomerRemark='".$comment."',NonCustomerCommentType='".$typecomment."',ReturnNonStatus='0' WHERE AppointmentID='".$app."'";
			ExecuteNQ($sqlUpdate2);
			
			echo 2;
							}
			
	?>