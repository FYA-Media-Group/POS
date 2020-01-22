<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
				$date=date('Y-m-d');
				//$previousdate=date('Y-m-d',strtotime("-1 days"));
				$DB = Connect();
				$cust_array=array();
				$grphtype=$_POST['grphtype'];
				
				if($grphtype=='1')
				{
						$First= date('Y-m-01');
		                $Last= date('Y-m-t');
						$DateInsertUpdate=date("Y-m-d H:i:s");
						$sql=select("count(*)","tblGraphDateParameter","RoleID='".$strAdminRoleID."'");
						$cntdata=$sql[0]['count(*)'];
					    if($cntdata>0)
						{
							    $sql11 = "Update tblGraphDateParameter set FromDate='".$First."',ToDate='".$Last."',Type='1',DateInsertUpdate='".$DateInsertUpdate."' where RoleID ='".$strAdminRoleID."'";	
										   //echo $sql11;
											if ($DB->query($sql11) === TRUE) 
											{
												echo "success";
											}
											else
											{
												echo  23;
											}	
						
						}
						else
						{
							$sqlInsert3ptr = "INSERT INTO tblGraphDateParameter(FromDate,ToDate, Type,RoleID,DateInsertUpdate) VALUES('".$First."', '".$Last."','1','".$strAdminRoleID."','".$DateInsertUpdate."')";
							if ($DB->query($sqlInsert3ptr) === TRUE) 
							{
									echo "success";		//last id of tblAppointments insert
							}
							else
							{
								echo "Error: " . $sqlInsert3ptr . "<br>" . $conn->error;
							}
						}
						
				}
				elseif($grphtype=='2')
				{
					    $First=date('Y-m-d',strtotime('first day of last month'));
						$Last=date('Y-m-d',strtotime('last day of last month'));
						$DateInsertUpdate=date("Y-m-d H:i:s");
						$sql=select("count(*)","tblGraphDateParameter","RoleID='".$strAdminRoleID."'");
						$cntdata=$sql[0]['count(*)'];
					    if($cntdata>0)
						{
							    $sql11 = "Update tblGraphDateParameter set FromDate='".$First."',ToDate='".$Last."',Type='2',DateInsertUpdate='".$DateInsertUpdate."' where RoleID ='".$strAdminRoleID."'";	
										   //echo $sql11;
											if ($DB->query($sql11) === TRUE) 
											{
												echo "success";
											}
											else
											{
												echo  23;
											}	
						
						}
						else
						{
							$sqlInsert3ptr = "INSERT INTO tblGraphDateParameter(FromDate,ToDate, Type,RoleID) VALUES('".$First."', '".$Last."','2','".$strAdminRoleID."','".$strAdminRoleID."','".$DateInsertUpdate."')";
							if ($DB->query($sqlInsert3ptr) === TRUE) 
							{
									echo "success";		//last id of tblAppointments insert
							}
							else
							{
								echo "Error: " . $sqlInsert3ptr . "<br>" . $conn->error;
							}
						}
				}
				else
				{ 
			    
			            $month=$_POST['month'];
						$month=$month+1;
						
			            $First=date('Y-'.$month.'-01');
						$Last=date("Y-m-d", mktime(0, 0, 0, $month+1,0,date("Y")));
                            
						$DateInsertUpdate=date("Y-m-d H:i:s");
						$sql=select("count(*)","tblGraphDateParameter","RoleID='".$strAdminRoleID."'");
						$cntdata=$sql[0]['count(*)'];
					    if($cntdata>0)
						{
							    $sql11 = "Update tblGraphDateParameter set FromDate='".$First."',ToDate='".$Last."',Type='3',DateInsertUpdate='".$DateInsertUpdate."' where RoleID ='".$strAdminRoleID."'";	
										   //echo $sql11;
											if ($DB->query($sql11) === TRUE) 
											{
												echo "success";
											}
											else
											{
												echo  23;
											}	
						
						}
						else
						{
							$sqlInsert3ptr = "INSERT INTO tblGraphDateParameter(FromDate,ToDate, Type,RoleID) VALUES('".$First."', '".$Last."','3','".$strAdminRoleID."','".$strAdminRoleID."','".$DateInsertUpdate."')";
							if ($DB->query($sqlInsert3ptr) === TRUE) 
							{
									echo "success";		//last id of tblAppointments insert
							}
							else
							{
								echo "Error: " . $sqlInsert3ptr . "<br>" . $conn->error;
							}
						}
					
				}
				
				
              /*   $sql=select("distinct(AppointmentId)","tblInvoiceDetails","AppointmentId!='NULL' LIMIT 10000,11000");
				foreach($sql as $sdata)
				{
					$app[]=$sdata['AppointmentId'];
				}
				
				for($i=0;$i<count($app);$i++)
				{
					$sqlty=select("CustomerID","tblAppointments","AppointmentID='".$app[$i]."'");
					$cust=$sqlty[0]['CustomerID'];
					
					$sqltypy=select("CustomerID","tblInvoiceDetails","AppointmentId='".$app[$i]."'");
					$custin=$sqltypy[0]['CustomerID'];
					
					if($custin==$cust)
					{
						
					}
					else
					{
							$sql11 = "Update tblInvoiceDetails set CustomerID='".$cust."' where AppointmentId ='".$app[$i]."'";	
										   //echo $sql11;
											if ($DB->query($sql11) === TRUE) 
											{
												// echo "Record Update successfully.";
											}
											else
											{
												echo "Error2";
											}	
						
					}
					
				} */
		      
?>