<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Non Visiting Customers Report | Nailspa";
	$strDisplayTitle = "Non Visiting Customers Report of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportNonVisitingCustomers.php";
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
												<h3 class="title-hero">List of all Non Visiters Customers</h3>
												
												<form method="get" class="form-horizontal bordered-row" role="form">
													<div class="form-group"><label for="" class="col-sm-4 control-label">Select Month</label>
														<div class="col-sm-4">
															
 
										     	     <select class="form-control required" name="month">
													  <option value="0">-Select Month-</option>	
                                                      <?php
													  
													  for($i=1;$i<11;$i++)
													  {
														  $mnt=$_GET["month"];
														  	if($mnt==$i)
													        {
																  ?>
														  	   <option selected value="<?=$i?>"><?=$i?></option>		
														  <?php
															}
															else
															{
																  ?>
														   <option value="<?=$i?>"><?=$i?></option>	
														  <?php
															}
														
													  }
													  ?>
												  
											       </select>
		                                            	</div>
													</div>
												
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportNonVisitingCustomers.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														

													</div>
													
													
												</form>
												
												<br>
												<?php
													if(isset($_GET["month"]))
													{
														$month="-".$_GET["month"]."months";
														$currdate=date('Y-m-d');
													
														$date2 = date("Y-m-d", strtotime($month));
														
												?>
														<h3 class="title-hero">Current Date- <?=date('Y-m-d');?>&nbsp;Non Visting Month - <?=$date2;?></h3>
												<?php
													}
												?>
												<br>
												
												
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Customer Name</th>
																<th>Customer EmailID</th>
																<th>Mobile No.</th>
																<th>Gender</th>
																<th>Registration Date</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Customer Name</th>
																<th>Customer EmailID</th>
																<th>Mobile No.</th>
																<th>Gender</th>
																<th>Registration Date</th>
															</tr>
														</tfoot>
														<tbody>

<?php
$DB = Connect();
if(isset($_GET["month"]))
	{

		date_default_timezone_set('Asia/Kolkata');
		
		$month = $_GET["month"]+1;
		if(!IsNull($month))
		{
			$sel=select("CustomerID","tblCustomers","Status='0'");
			foreach($sel as $val)
			{
				$custid=$val['CustomerID'];
				$date2 = date("Y-m-d", strtotime($month));
				echo $checkdate = date($date2, strtotime("-1 month"));
				
					$sept=select("AppointmentDate,CustomerID","tblAppointments","CustomerID='".$custid."' and IsDeleted!='1' order by AppointmentID desc limit 0,1");
					$endate=$sept[0]['AppointmentDate'];
					
					
					$CustomerID=$sept[0]['CustomerID'];
					$enddt=date("n",strtotime($endate));
					$septp=select("AppointmentDate,CustomerID","tblAppointments","CustomerID='".$custid."' and IsDeleted!='1' order by AppointmentID asc limit 0,1");
					$startdate=$septp[0]['AppointmentDate'];
					$CustomerID=$septp[0]['CustomerID'];
					$startt=date("n",strtotime($startdate));
					if($enddt!=$startt)
					{
						$sqldiffmon=$startt-$enddt;
						
						if($sqldiffmon==$month)
						{
							$sql = "SELECT CustomerID, CustomerFullName, CustomerEmailID, CustomerMobileNo,RegDate, Gender FROM tblCustomers where CustomerID='".$CustomerID."'";
						}
					}
					
				
			}
		}
	}


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
		$strRegistrationDate = FormatDateTime($row["RegDate"]);
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