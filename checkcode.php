<?php require_once("setting.fya"); ?>
<?php
$date=date('Y-m-d');
$previousdate=date('Y-m-d',strtotime("-1 days"));
$DB = Connect();


		
		$sql = "Select EmployeeCode from tblEmployees where Status='0'";
		// echo $sql;
		$RS = $DB->query($sql);
		if ($RS->num_rows > 0) 
		{
			while($row = $RS->fetch_assoc())
			{
				$counter ++;
				$strEmployeeCode = $row["EmployeeCode"];
				$seldata=select("count(*)","tblEmployeesRecords","EmployeeCode='".$strEmployeeCode."' and DateOfAttendance='".$date."'");
				
				$cnt=$seldata[0]['count(*)'];
				if($cnt>0)
				{
					$sqlDelete = "DELETE FROM tblEmployeesRecords WHERE EmployeeCode='".$strEmployeeCode."' and DateOfAttendance='".$date."'";
		            ExecuteNQ($sqlDelete);
				}
				else
				{
					$pqr="Insert into tblEmployeesRecords (EmployeeCode, DateOfAttendance, Status) Values ('$strEmployeeCode', now(), 0)";
			
				
					 if ($DB->query($pqr) === TRUE) 
					{
							// echo "Record Update successfully.";
					}
					else
					{
						//echo "Error2";
					} 
				}
				// echo $strEmployeeCode;
				
			}
		} 
		
		
			
					$sql1 = "Select * from tblEmployeesRecords where DateOfAttendance='".$previousdate."'";
					$RS1 = $DB->query($sql1);
					if ($RS1->num_rows > 0) 
					{
						while($row1 = $RS1->fetch_assoc())
						{
							$Status = $row1['Status'];
							//echo "status=".$Status."<br/>";
							$empcode = $row1['EmployeeCode'];
							$seldatap=select("count(*)","tblEmployeeAttendance","EmployeeCode='".$empcode."'");
				
				           $cnt1=$seldatap[0]['count(*)'];
						  // echo "cnt=".$cnt1."<br/>";
						   
						   if($cnt1>0)
						   {
							   
							    //echo 12312312312;
							
							    
								//echo "Data=".$datata."<br/>";
								$seldatapptq=select("StartDate,RecordMonth","tblEmployeeAttendance","EmployeeCode='".$empcode."'");
								$StartDate=$seldatapptq[0]['StartDate'];
								$RecordMonth=$seldatapptq[0]['RecordMonth'];
							     
								$datetime1 = new DateTime($StartDate);
								$datetime2 = new DateTime($date);
								$interval = $datetime1->diff($datetime2);
								$dated=$interval->format('%a');
								$datay=$dated+1;
								
							
									
							    $year=date('Y', strtotime($previousdate));
								$mon=date('m', strtotime($previousdate));
								$month = date("F", mktime(0, 0, 0, $mon, 10));
						
								$cnt=0;
								$ctp=0;
							
							   if($Status=='0')
							   {
								   	$seldatapptqcountdata=select("count(*)","tblEmployeeAttendance","EmployeeCode='".$empcode."' and RecordMonth='".$month."' and RecordYear='".$year."'");
								$countdata=$seldatapptqcountdata[0]['count(*)'];
								//echo "in if status";
								   if($countdata>0)
								   {
									  //echo "count greater";
									   $seldatapp=select("Data","tblEmployeeAttendance","EmployeeCode='".$empcode."' and RecordMonth='".$month."' and RecordYear='".$year."'");
								       $datata=$seldatapp[0]['Data'];
									   $ctp++;
									   $statt=$datata.",".$Status;
										//echo "sttt=".$statt."<br/>";
										$cntst=explode(",",$statt);
										//print_r($cntst);
										$ctt=count($cntst);
										
										//echo "cnt=".$ctt."<br/>";
										$counts = array_count_values($cntst);
										$ct=$counts['0'];
										
										//echo $datay."=datay".$ctt."";


										//echo "date equal";
										 
									   $sql11 = "Update tblEmployeeAttendance set Data='$statt',LeavesThisMonth='$ct' where EmployeeCode ='$empcode' and RecordMonth='".$month."' and RecordYear='".$year."'";	
									   //echo $sql1;
										 if ($DB->query($sql11) === TRUE) 
										{
											// echo "Record Update successfully.";
										}
										else
										{
											//echo "Error2";
										} 
									  
									 
								   }
								   else
								   {
									   $cnt++;
									// echo "count less";
										 
									   
									     $pqrt="Insert into tblEmployeeAttendance(EmployeeCode, RecordYear,RecordMonth,StartDate,Data,LeavesThisMonth) Values ('$empcode', '$year','$month','$previousdate','$Status','$cnt')";
										 //echo $pqrt;
									  if ($DB->query($pqrt) === TRUE) 
										{
												// echo "Record Update successfully.";
										}
										else
										{
											//echo "Error2";
										}  
								   }
								    
								  
								
							
							   }
							   else
							   {
								  //echo "in else status";
								   $seldatapptqcountdata=select("count(*)","tblEmployeeAttendance","EmployeeCode='".$empcode."' and RecordMonth='".$month."' and RecordYear='".$year."'");
								    $countdata=$seldatapptqcountdata[0]['count(*)'];
								 // echo "in if status";
								   if($countdata>0)
								   {
									   // echo "in else counter greatrr";
									   $seldatapp=select("Data","tblEmployeeAttendance","EmployeeCode='".$empcode."' and RecordMonth='".$month."' and RecordYear='".$year."'");
								       $datata=$seldatapp[0]['Data'];
									    $ctp++;
									    $statt=$datata.",".$Status;
										$cntst=explode(",",$statt);
										$ctt=count($cntst);
										$counts = array_count_values($cntst);
										 $ct=$counts['0'];
									  
										//   echo "else date equal";
									    $statt=$datata.",".$Status;
									   $sql12 = "Update tblEmployeeAttendance set Data='$statt' where EmployeeCode ='$empcode' and RecordMonth='".$month."' and RecordYear='".$year."'";	
			// echo $sql1;
									 	if ($DB->query($sql12) === TRUE) 
										{
											// echo "Record Update successfully.";
										}
										else
										{
											//echo "Error2";
										}  
									   
								
								   }
								   else
								   {
									    $pqrtt="Insert into tblEmployeeAttendance(EmployeeCode, RecordYear,RecordMonth,StartDate,Data) Values ('$empcode', '$year','$month','$previousdate','$Status')";
										
										// echo "else count less";
									if ($DB->query($pqrtt) === TRUE) 
										{
												// echo "Record Update successfully.";
										}
										else
										{
											//echo "Error2";
										} 
										 
								   }
								
								
							   }
						   }
						   else
						   {
							   $year=date('Y', strtotime($previousdate));
							 
							   $mon=date('m', strtotime($previousdate));
							   $month = date("F", mktime(0, 0, 0, $mon, 10));
							  
							   $cnt=0;
							   if($Status=='0')
							   {
								   $cnt++;
								      $pqrt="Insert into tblEmployeeAttendance(EmployeeCode, RecordYear,RecordMonth,StartDate,Data,LeavesThisMonth) Values ('$empcode', '$year','$month','$previousdate','$Status','$cnt')";
									//  echo $pqrt;
									    if ($DB->query($pqrt) === TRUE) 
										{
												// echo "Record Update successfully.";
										}
										else
										{
											//echo "Error2";
										}
							   }
							   else
							   {
								   $pqrtt="Insert into tblEmployeeAttendance(EmployeeCode, RecordYear,RecordMonth,StartDate,Data) Values ('$empcode', '$year','$month','$previousdate','$Status')";
								   //echo $pqrtt;
									  if ($DB->query($pqrtt) === TRUE) 
										{
												// echo "Record Update successfully.";
										}
										else
										{
											//echo "Error2";
										} 
							   }
							
							
								
						   }
							
						}
					}
					
					
				
		
	
	
		
?>