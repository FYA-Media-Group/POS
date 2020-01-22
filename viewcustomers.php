		<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Manage Customers | Nailspa";
	$strDisplayTitle = "View Details Of Customers for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblCustomers";
	$strMyTableID = "CustomerID";
	$strMyField = "CustomerMobileNo";
	$strMyActionPage = "ManageCustomers.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
	if(isset($_GET['renew']))
	{
		$DB = Connect();
		$ID=$_GET['renew'];
		$date=date('Y-m-d');
		$new_date = strtotime(date("Y-m-d", strtotime($date)) . " +12 month");
		$new_dated = date("Y-m-d",$new_date);
        $sell=select("*","tblMembership","MembershipID='".$ID."'");
		$endate=$sell[0]['TimeForDiscountEnd'];
		$sql = "SELECT * FROM tblCustomers WHERE memberid='".$ID."'";
		$RS = $DB->query($sql);
		if ($RS->num_rows > 0) 
		{
			$counter = 0;

			while($row = $RS->fetch_assoc())
			{
				
				$CustomerEmailID=$row['CustomerEmailID'];
				$CustomerFullName=$row['CustomerFullName'];
				$CustomerMobileNo=$row['CustomerMobileNo'];
						
						
				$strTo = $CustomerEmailID;
				$strFrom = "order@fyatest.website";
				$strSubject = "Your Membership Renew Successfully of Nailspa services";
				$strBody = "";
				$strStatus = "0"; // Pending = 0 / Sent = 1 / Error = 2
				$Name = $CustomerFullName;
				$strDate = $endate;
					
				$seldata=select("*","tblMembership","MembershipID='".$ID."'");
				$MembershipName=$seldata[0]['MembershipName'];
				$Type=$seldata[0]['Type'];
				if($Type=='0')
				{
					$type='Elite Membership';
				}
				else
				{
					$type='Normal Membership';
				}
				$DiscountType=$seldata[0]['DiscountType'];
				$Discount=$seldata[0]['Discount'];
				$TimeForDiscountEnd=$seldata[0]['TimeForDiscountEnd'];
				$storeid=$seldata[0]['storeid'];
				$sep=select("*","tblStores","StoreID='".$storeid."'");
				$officeaddress=$sep[0]['StoreOfficialAddress'];
				$storename=$sep[0]['StoreName'];
			    $branche=explode(",",$storename);
				$branchname=$branche[1]; 
		
				$message = file_get_contents('EmailFormat/membership_Renew.html');
				$message = eregi_replace("[\]",'',$message);
				//setup vars to replace
				$vars = array('{membership_name}','{member_name}','{Discount}','{TimeForDiscountEnd}','{Address}','{Branch}','{Renewdate}'); //Replace varaibles
				$values = array($MembershipName,$Name,$Discount,$TimeForDiscountEnd,$officeaddress,$branchname,$new_dated);

				//replace vars
				$message = str_replace($vars,$values,$message);

				$strBody1 = $message;
				
				// exit();
				 
				$flag='CM';
				$id = $last_id2;
				
				sendmail($id,$strTo,$strFrom,$strSubject,$strBody1,$strDate,$flag,$strStatus);
			}
		}
	
					
		$sqlUpdate = "UPDATE $strMyTable SET TimeForDiscountEnd='".$new_dated."' WHERE $strMyTableID='".$ID."'";
		ExecuteNQ($sqlUpdate);
					
		$msg="Membership Renew Successfully";
		$DB->close();
		header('Location:viewcustomers.php?msg='.$msg.'');
	}
// code for not allowing the normal admin to access the super admin rights	
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
                                format: 'yyyy-mm-dd'
                            });
                        });
                    </script>
                    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker.js"></script>
                    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker-demo.js"></script>
                    <script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>
                    <script type="text/javascript" src="assets/widgets/timepicker/timepicker.js"></script>
                    <script type="text/javascript">
                        /* Timepicker */

                        $(function() {
                            "use strict";
                            $('.timepicker-example').timepicker();
                        });
                    </script>
					<script>
						$(function ()						
						{
							$("#StartDay").datepicker({ minDate: 0 });
							$("#EndtDay").datepicker({ minDate: 0 });
							$("#StartDay1").datepicker({ minDate: 0 });
							$("#EndtDay1").datepicker({ minDate: 0 });
							
						});
					</script>	
	<script>
	$(document).ready(function(){
/* 	$(".deleteq").click(function(){
	//alert(134)
	var uid=$("#uidd").val();
	//alert(uid)
	$.ajax({
	type:"post",
	data:"uid="+uid,
	url:"delete_customer.php",
	success:function(result)
	{
	//alert(result)
	if(result==1)
	{
		alert('You Cannot Delete This Customer')
	}
	else
	{
		alert(result)
	}
	}
	
	});
	
	}); */
	});
	function LoadValue(OptionValue)
            {                
				// alert (OptionValue);
				$.ajax({
					type: 'POST',
					url: "GetServicesStoreWise.php",
					data: {
						id:OptionValue
					},
					success: function(response) {
					//	alert(response)
						$("#asmita").html("");
						$("#asmita1").html("");
						$("#asmita").html(response);
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$("#asmita").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						alert (response);
					}
				});

            }
			
			
	function LoadValueasmita()
	{
		
		valuable=[];
		var valuable = $('#Services').val();
		var store = $('#StoreID').val();
		
		//alert(store)
				 $.ajax({
					type: 'POST',
					url: "servicedetail.php",
					data: {
						id:valuable,
						stored:store
					},
					success: function(response) {
						//alert(response)
						$("#asmita1").html("");
						$("#asmita1").html(response);
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$("#asmita1").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						//alert (response);
					}
				}); 
	}
</script>
<script>
		
	$(function () {
    $("#AppointmentDate").datepicker({ minDate: 0 });
	 $("#AppointmentDate").datepicker({ minDate: 0 });
	  
});
</script>

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
                        <p>Add, Edit, Delete Customers</p>
                    </div>	
		<div class="panel-body">
												<h3 class="title-hero">List of Customers | Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Full Name</th>
																<th>Email ID</th>
																<th>Mobile No.</th>
																<th>Membership</th>
																
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Sr.No</th>
																<th>Full Name</th>
																<th>Email ID</th>
																<th>Mobile No.</th>
																<th>Membership</th>
														
															</tr>
														</tfoot>
														<tbody>

<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SELECT * FROM ".$strMyTable." WHERE Status='0' order by CustomerID desc";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strCustomerID = $row["CustomerID"];
		$getUID = EncodeQ($strCustomerID);
		$getUIDDelete = Encode($strCustomerID);		
		$CustomerFullName = $row["CustomerFullName"];
		$CustomerEmailID = $row["CustomerEmailID"];
		$CustomerMobileNo = $row["CustomerMobileNo"];
		$memid = $row["memberid"];
		// echo $memid;
		$Status = $row["Status"];
		
		
		
		if($Status=="0")
		{
			$Status = "Live";
		}
		else
		{
			$Status = "Offline";
		}
?>	
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td><?=$CustomerFullName?></td>
																<td><?=$CustomerEmailID?></td>
																<td><?=$CustomerMobileNo?></td>
																<td style="text-align: center">
																<?php  
																		// echo $memid;
																		if($memid==0)
																		{
																			echo "None";
																		}
																		else
																		{
																			$selectMembershipName="Select MembershipName from tblMembership where MembershipId='$memid'";
																			$RS3 = $DB->query($selectMembershipName);
																			if ($RS3->num_rows > 0) 
																			{
																				while($row3 = $RS3->fetch_assoc())
																				{
																					$MembershipName = $row3["MembershipName"];
																					echo $MembershipName;
																				}
																			}
																		}
																	
																	// $seldata=select("*","tblMembership","MembershipID='".$memid."'");
																	// $discountend=$seldata[0]['TimeForDiscountEnd'];
																	// echo $strMembershipID;
																	// $edate=date('Y-m-d', strtotime($discountend));
																	// echo $edate;
																	// $todate=date('Y-m-d');
																	
																	 // if($edate==$todate)
																	// {
																		// ?>
																		<!--<a class="btn btn-link" href="<?=$strMyActionPage?>?renew=<?=$memid?>">Renew</a>-->
																		<?php
																	// } 
																	// ?>
																</td>
																
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
	  </div>
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>													
														</tbody>
													</table>
												</div>
											</div>