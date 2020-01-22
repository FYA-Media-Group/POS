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
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
// code for not allowing the normal admin to access the super admin rights	
?>
		
														
<?php

	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
	
		
		$fname = $_POST["fname"];
		$mobile = $_POST["mobile"];
		$lname = $_POST["lname"];
		
		
		// echo $fname."<br>";
		// echo $mobile."<br>";
		// echo $lname."<br>";
		// die();
			$DB = Connect();
		  if(!empty($mobile) || !empty($fname) || !empty($lname))
		  {
			  if(!empty($mobile))
			  {
				    $sqp=select("count(*)","tblCustomers","CustomerMobileNo like '$mobile%'");
			
			
			  }
			  elseif(!empty($fname))
			  {
				    $sqp=select("count(*)","tblCustomers","FirstName like '$fname%'");
			 
		
			  }
			  elseif(!empty($lname))
			  {
				    $sqp=select("count(*)","tblCustomers","LastName like '$lname%'");
			 
			
			  }
			  // echo $sqp."<br>";
			  // die();
			$cnt=$sqp[0]['count(*)'];
			 if($cnt=='0')
			 {
				 // echo "In if<br>";
				 // die();
				 ?>
				
			  <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Full Name</th>
																<th>Email ID</th>
																<th>Mobile No.</th>
																<th>Gender</th>
																<th>Membership</th>
																<th>Appointments</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Full Name</th>
																<th>Email ID</th>
																<th>Mobile No.</th>
																<th>Gender</th>
																<th>Membership</th>
																<th>Appointments</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>
														<tr><td><center><b>No Records Found</b></center></td></tr>
														</tbody>
														</table>
			
				 
				 <?php
				 
			 }
			 else
			 {
				  // echo "In else<br>";
				 // die();
				 if(!empty($mobile))
				 {
					  $sep="select CustomerID,CustomerFullName,CustomerEmailID,CustomerMobileNo,Gender,memberid from tblCustomers where CustomerMobileNo like '$mobile%'";
				 }
				 elseif(!empty($fname))
				 {
					  $sep="select CustomerID,CustomerFullName,CustomerEmailID,CustomerMobileNo,Gender,memberid from tblCustomers where FirstName like '$fname%'";
				 }
				 elseif(!empty($lname))
				 {
					  $sep="select CustomerID,CustomerFullName,CustomerEmailID,CustomerMobileNo,Gender,memberid from tblCustomers where LastName like '$lname%'";
				 }
				 // echo $sep."<br>";
				 
				
					
				 $RS = $DB->query($sep);
           if ($RS->num_rows > 0) 
               {
				   // echo "In if<br>";
				  
				    ?>
				
			  <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Full Name</th>
																<th>Email ID</th>
																<th>Mobile No.</th>
																<th>Gender</th>
																<th>Membership</th>
																<th>Appointments</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Full Name</th>
																<th>Email ID</th>
																<th>Mobile No.</th>
																<th>Gender</th>
																<th>Membership</th>
																<th>Appointments</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>
														<?php
               $counter=0;
				while($row = $RS->fetch_assoc())
				{
					$counter++;
				$EncodedID = EncodeQ($row['CustomerID']);
				$checkCustomerID = $row['CustomerID'];
				$memid=$row['memberid'];
				// echo $memid."<br>";
				// die();
				
						
				
				
				
				// if($MembershipID=="0")
				// {
					// $member= "Membership Not Found";
					// $member= "---";
				// }
				// else
				// {
					// $seppt=select("MembershipName","tblMembership","MembershipID='".$MembershipID."'");
					// $member=$seppt[0]['MembershipName'];
				// }
																				// if($member=="1")
																				// {
																					// $me="Gold";
																					// $me="-";
																				// }
																				// elseif($val=="2")
																				// {
																					// $me="Silver";
																				// $me="-";
																				// }
																				// else
																				// {
																					// $me="---";
																					
																				// }
			    $gen=$row['Gender'];
				if($gen=='0')
				{
					$gender="Male";
				}
				else
				{
					$gender="Female";
				}
				
				  ?>
				  <tr>
				  <td><?=$counter?></td>
				  <td><?=$row['CustomerFullName']?> <br><?=$checkCustomerID?></td>
				  <td><?=$row['CustomerEmailID']?></td>
				  <td><?=$row['CustomerMobileNo']?></td>
				  <td><?=$gender?></td>
				  <td>
<?php				  
					 $date = date('Y-m-d');
					 // echo $date."<br>";
					$checkMembership="Select MembershipID, EndDay from tblCustomerMemberShip where CustomerID='$checkCustomerID'";
						// echo $checkMembership."<br>";
							$RSmembership = $DB->query($checkMembership);
							if ($RSmembership->num_rows > 0) 
							{
								$cnt=0;
								while($row1 = $RSmembership->fetch_assoc())
								{
									$cnt++;
									$MembershipID=$row1['MembershipID'];
									$EndDay=$row1['EndDay'];
									// echo $EndDay."<br>";
									if($EndDay>=$date)
									{
										// echo "In elseif";
										if($MembershipID==0)
										{
											// echo "In if<br>";
											echo "---";
										}
										else
										{
											// echo "In else<br>";
											$selectName="Select MembershipName from tblMembership where MembershipID='$MembershipID'";
											// echo $selectName."<br>";
											$RSname = $DB->query($selectName);
											if ($RSname->num_rows > 0) 
											{
												$mnt=0;
												while($rowname = $RSname->fetch_assoc())
												{
													$mns++;
													$MembershipName=$rowname['MembershipName'];
													echo $MembershipName;
												}
											}
										}
											
									}
									else
									{
										echo "Membership Expired";
										// echo "<br>".$MembershipID;
										
									}
								}
								
							}
							else
							{
								echo "---";
								// echo "<br>".$MembershipID;
								// echo "<br>".$checkMembership;
							}
				  
?>				  
				  </td>
				  	<td><center><a class="btn btn-link font-blue" href="ManageAppointments.php?bid=<?=$EncodedID?>">Book Appointment</a> / <a class="btn btn-link font-blue" href="PurchaseGV.php?bid=<?=$EncodedID?>">Purchase GV</a> / <a class="btn btn-link font-blue" href="PurchasePackage.php?bid=<?=$EncodedID?>">Purchase Package</a>
						/<a class="btn btn-link font-blue" href="CustomerHistory.php?uid=<?=$EncodedID?>">Customer History</a>
						
					</center></td>
																			<td><center><a class="btn btn-link font-blue" href="ManageCustomers2.php?uid=<?=$EncodedID?>">Edit Data</a></center></td>
				  </tr>
				  <?php
			  }
			 }
			  
		  }
		  ?>
		  
		  	</tbody>
		</table>
		<?php
		  }
else if($mobile!="" && $fname!="" && $lname!="")
		  {
			 // echo "In elseif<br>";
				   // die();
			// ECHO 123454;
			   $sqp=select("count(*)","tblCustomers","FirstName like '$fname%' and LastName like '$lname%' and CustomerMobileNo like '$mobile%'");
			   print_r($sqp);
			
			$cnt=$sqp[0]['count(*)'];
			 if($cnt=='0')
			 {
				 ?>
			
			  <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Full Name</th>
																<th>Email ID</th>
																<th>Mobile No.</th>
																<th>Gender</th>
																<th>Membership</th>
																<th>Appointments</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Full Name</th>
																<th>Email ID</th>
																<th>Mobile No.</th>
																<th>Gender</th>
																<th>Membership</th>
																<th>Appointments</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>
														<tr><td><center><b>No Records Found</b></center></td></tr>
														</tbody>
														</table>
				 <?php
				 
			 }
			 else
			 {
				  ?>
			
			  <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Full Name</th>
																<th>Email ID</th>
																<th>Mobile No.</th>
																<th>Gender</th>
																<th>Membership</th>
																<th>Appointments</th>
																<th>Action</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Full Name</th>
																<th>Email ID</th>
																<th>Mobile No.</th>
																<th>Gender</th>
																<th>Membership</th>
																<th>Appointments</th>
																<th>Action</th>
															</tr>
														</tfoot>
														<tbody>
														<?php
				
				  $sep="select CustomerID,CustomerFullName,CustomerEmailID,CustomerMobileNo,Gender,memberid from tblCustomers where FirstName like '$fname%' and LastName like '$lname%' and CustomerMobileNo like '$mobile%'";
				// echo $sep;
			  $RS = $DB->query($sep);
           if ($RS->num_rows > 0) 
               {
             $counter=0;
				while($row = $RS->fetch_assoc())
				{
					  
					$counter++;
						$counter++;
				$EncodedID = EncodeQ($row['CustomerID']);
				$memid=$row['memberid'];
				$CustID=$row['CustomerID'];
				$selectMember="Select MembershipID, ExpireDate from tblCustomerMemberShip where CustomerID='$CustID'";
				echo $selectMember."<br>";
				 $RSm = $DB->query($sep);
					if ($RSm->num_rows > 0) 
					{
						$counterm=0;
						while($rowm = $RS->fetch_assoc())
						{
							$counterm++;
							$MembershipID=$rowm['MembershipID'];
							$ExpireDate=$rowm['ExpireDate'];
						}
					}
				
				// if($memid=="0")
				// {
					// $member= "Membership Not Found";
					// $member= "---";
				// }
				// else
				// {
					// $seppt=select("MembershipName","tblMembership","MembershipID='".$memid."'");
					// $member=$seppt[0]['MembershipName'];
				// }
			                                                                   // if($member=="1")
																					// {
																						// $me="Gold";
																						
																					// }
																					// elseif($val=="2")
																					// {
																						// $me="Silver";
																					
																					// }
																					// else
																					// {
																						// $me="-";
																						
																					// }
			    $gen=$row['Gender'];
				if($gen=='0')
				{
					$gender="Male";
				}
				else
				{
					$gender="Female";
				}
				
				  ?>
				  <tr>
				  <td><?=$counter?></td>
				  <td><?=$row['CustomerFullName']?></td>
				  <td><?=$row['CustomerEmailID']?></td>
				  <td><?=$row['CustomerMobileNo']?></td>
				  <td><?=$gender?></td>
				  <td><?=$member?></td>
				  </tr>
				  <?php
			 
			   }
			  
		   }
			 }
			 ?>
			
		  
		  	</tbody>
		</table>
			 <?php
		  }
		
			$DB->close();
	}
			
			
			
			
			?>
		