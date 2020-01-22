<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Customer Report | Nailspa";
	$strDisplayTitle = "Report of all the customers of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportCustomerData.php";
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
		$strStep = Filter($_POST["step"]);
		
		if($strStep=="add")
		{
			
		}
		
		if($strStep=="edit")
		{
			
		}
	}	
?>


<?php

	if(isset($_GET["toandfrom"]))
	{
		$strtoandfrom = $_GET["toandfrom"];
		$arraytofrom = explode("-",$strtoandfrom);
		
		$from = $arraytofrom[0];
		$datetime = new DateTime($from);
		$getfrom = $datetime->format('Y-m-d');
		
		
		$to = $arraytofrom[1];
		$datetime = new DateTime($to);
		$getto = $datetime->format('Y-m-d');

		if(!IsNull($from))
		{
			$sqlTempfrom = " where Date(RegDate)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(RegDate)<=Date('".$getto."')";
		}
	}
	if(isset($_GET["toandfrom"]))
	{
		$strtoandfrom = $_GET["toandfrom"];
		$arraytofrom = explode("-",$strtoandfrom);
		
		$from = $arraytofrom[0];
		$datetime = new DateTime($from);
		$getfrom = $datetime->format('Y-m-d');
		
		
		$to = $arraytofrom[1];
		$datetime = new DateTime($to);
		$getto = $datetime->format('Y-m-d');

		if(!IsNull($from))
		{
			$sqlTempfrom = " where Date(RegDate)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(RegDate)<=Date('".$getto."')";
		}
	}
	

?>	


<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	
	<script type="text/javascript" src="assets/widgets/datepicker/datepicker.js"></script>
	<script type="text/javascript">
		/* Datepicker bootstrap */

		$(function() {
			"use strict";
			$('.bootstrap-datepicker').bsdatepicker({
				format: 'mm-dd-yyyy'
			});
		});
	</script>
	<script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker.js"></script>
	<script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker-demo.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker-demo.js"></script>
</head>

<body>
    <div id="sb-site">
        
		<?php require_once("incOpenLayout.fya"); ?>
		
		
        <?php require_once("incLoader.fya"); ?>
		
        <div id="page-wrapper">
            <div id="mobile-navigation"><button id="nav-toggle" class="collapsed" data-toggle="collapse" data-target="#page-sidebar"><span></span></button></div>
            
				<?php require_once("incLeftMenu.fya"); ?>
			
            <div id="page-content-wrapper">
                <div id="page-content">
                    
					<?php require_once("incHeader.fya"); ?>
					

                    <div id="page-title">
                        <h2><?=$strDisplayTitle?></h2>
                    </div>
<?php

if(!isset($_GET["uid"]))
{

?>					
					
                    <div class="panel">
						<div class="panel">
							<div class="panel-body">
							
								
								<div class="example-box-wrapper">
									<div class="tabs">
										<ul>
											<li><a href="#normal-tabs-1" title="Tab 1">Manage</a></li>
										</ul>
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of all Registered customers</h3>
												
												<form method="get" class="form-horizontal bordered-row" role="form">
													<div class="form-group"><label for="" class="col-sm-4 control-label">Select Registration date</label>
														<div class="col-sm-4">
															<div class="input-prepend input-group">
																<span class="add-on input-group-addon">
																	<i class="glyph-icon icon-calendar"></i>
																</span> 
																<input type="text" name="toandfrom" id="daterangepicker-example" class="form-control" value="<?=$strtoandfrom?>">
															</div>
														</div>
													</div>
												
												
													
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportCustomerData.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-border btn-alt border-primary font-primary" href="ExcelExportData.php?from=<?=$getfrom?>&to=<?=$getto?>" title="Excel format 2016"><span>Export To Excel</span><div class="ripple-wrapper"></div></a>
														<a class="btn btn-border btn-alt border-primary font-success" href="pdfcreator/Main/CustomerReport.php?from=<?=$getfrom?>&to=<?=$getto?>" title="PDF Report"><span>Export To PDF</span><div class="ripple-wrapper"></div></a>

													</div>
												</form>
												
												<br>
												<?php
													if(isset($_GET["toandfrom"]))
													{
												?>
														<h3 class="title-hero">Date Range selected : FROM - <?=$getfrom?> / TO - <?=$getto?></h3>
												<?php
													}
												?>
												<br>
												
												
												<div class="example-box-wrapper">
												<?php
													$sep = select("count(*)"," tblCustomers","Status='0'");
 
													$cnt=$sep[0]['count(*)'];
													   
													$json_string = file_get_contents(FindHostAdmin()."/jsonCustomer/jsondata/CustomersData.json");
													$parsed_json = json_decode($json_string, true);
							
													if($strStore=="" || $strStore=="0")
													{
														echo "<br><center><h4>". count($parsed_json). " Total customers on cloud</h4></center>";
														echo "<br><center><h4>". $cnt. " Total customers in Database</h4></center>";
													}
													else
													{
														
													}
													
													$array1= array_multi_search($parsed_json, 'FirstName', '/^','A','/i'); 
													$array2= array_multi_search2($parsed_json, 'LastName', '/^','A','/i');

													$finalarray = array_merge($array1, $array2);
													
												
													//echo "<br><center><h4>". count($finalarray). " Data Found for <b>".$_GET["Cust_type"]."</b></h4></center>";
													?>
													<script>
												function syncCustomerData()
													{
														$.ajax({
															type:"post",
															data:"",
															url:"jsonCustomer/syncCutomers.php",
															success:function(result)
															{

																if($.trim(result)=='json file for Cutomers synced successfully')
																{
																	$("#saifusmanidon").html("<center><font color='red'><b>Sync Successful</b></font></center>");
																	location.reload();
																}
																else
																{
																	$("#saifusmanidon").html("<center><font color='red'><b>System finding difficulties in sync! Please try again after some time</b></font></center>");
																}
															}
															
															
														})
													}
												</script>
												
												
												<?php
													if($cnt==count($parsed_json))
													{
														echo "<br><center><h4>Software is synced with cloud !</h4></center>";
													}
													else
													{
														echo "<br><center><h4><font color='red'>Sync Suggested to get customers added today !</font></h4></center>";
												?>	
														<center><span id="saifusmanidon"><a class="btn btn-link"  href="#" onclick="syncCustomerData()">Sync System with Cloud</a></span></center>
														<span id="saifffff">&nbsp;</span>
												<?php
													}
												?>	
												
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Customer Name</th>
																<th>Customer EmailID</th>
																<th>Mobile No.</th>
																<th>Membership Assigned</th>
																<th>Gender</th>
																<th>Registration Date</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Customer Name</th>
																<th>Customer EmailID</th>
																<th>Mobile No.</th>
																<th>Membership Assigned</th>
																<th>Gender</th>
																<th>Registration Date</th>
															</tr>
														</tfoot>
														<tbody>
														
														
													
																<?php
																	$counter = "";
																	foreach ($finalarray as $key => $value) 
																	{
																		$counter = $counter + 1;
																		echo '<tr>';
																		echo '<td>' . $counter . '</td>';
																		if (!is_array($value)) 
																		{
																			echo $key . ' :' . $value . '</b><br/>';
																		} 
																		else 
																		{
																			foreach ($value as $key => $val) 
																			{
																				if($key=="CustomerFullName")
																				{
																					echo '<td>' . $val . '</td>';
																				}
																				elseif($key=="CustomerEmailID")
																				{
																					echo '<td>' . $val . '</td>';
																				}
																				elseif($key=="CustomerMobileNo")
																				{
																					echo '<td>' . $val . '</td>';
																				}
																				elseif($key=="Gender")
																				{
																					if($val=="1")
																					{
																						echo '<td>Female</td>';
																					}
																					else
																					{
																						echo '<td>Male</td>';
																					}
																					
																				}
																				elseif($key=="memberid")
																				{
																					if($val=="1")
																					{
																						echo '<td>Gold</td>';
																					}
																					elseif($val=="2")
																					{
																						echo '<td>Silver</td>';
																					}
																					else
																					{
																						echo '<td> - </td>';
																					}
																				}
																				elseif($key=="CustomerID")
																				{
																					$EncodedID = EncodeQ($val);
																				}
																				else
																				{

																				}
																			}
																			
																		}
																		
																		echo '</tr>';
																	}
																?>
																

<?php



$DB = Connect();
$sql = "SELECT CustomerID, CustomerFullName, CustomerEmailID, CustomerMobileNo, 
		(Select MembershipName from tblMembership where MembershipID=tblCustomers.memberid)as MembershipName, RegDate, Gender FROM tblCustomers $sqlTempfrom $sqlTempto";
//echo $sql;

$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strCustomerID = $row["CustomerID"];
		$getUID = EncodeQ($strCustomerID);
		$strCustomerFullName = $row["CustomerFullName"];
		$strCustomerEmailID = $row["CustomerEmailID"];
		$strCustomerMobileNo = $row["CustomerMobileNo"];
		$strMembershipName = $row["MembershipName"];
		$ddate=$row["RegDate"];
		$strRegistrationDate = FormatDateTime($ddate);
		$strGender = $row["Gender"];
		
		if($strMembershipName =="NULL" || $strMembershipName =="null" || $strMembershipName =="")
		{
			$strMembershipName = "-";
		}
		else
		{
			$strMembershipName = $strMembershipName;
		}
		
		if($strGender =="0")
		{
			$strGender = "Male";
		}
		elseif($strGender =="1")
		{
			$strGender="Female";
		}
		
		
		
		
		
		
?>														
														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$strCustomerFullName?></td>
																<td><?=$strCustomerEmailID?></td>
																<td><?=$strCustomerMobileNo?></td>
																<td><?=$strMembershipName?></td>
																<td><?=$strGender?></td>
																<td><?=$strRegistrationDate?></td>
															</tr>
<?php
	}
}
else
{
?>															
															<tr>
																<td></td>
																<td></td>
																<td>No Records Found</td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
														
<?php
}
$DB->close();
?>
														
														</tbody>
													</table>
												</div>
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
                    </div>
<?php
} // End null condition
else
{
	
}
?>
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>