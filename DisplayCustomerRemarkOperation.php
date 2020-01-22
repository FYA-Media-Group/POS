<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Non Visiting Customers Conversion on calls";
	$strDisplayTitle = "Non Visiting Customers Conversion on calls  | Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblExpenses";
	$strMyTableID = "ExpenseID";
	$strMyActionPage = "DisplayCustomerRemarkOperation.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
	
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
	// if($strStore=="0")
	// {
		// die("Sorry you are trying to enter Unauthorized access");
	// }
// code for not allowing the normal admin to access the super admin rights	

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		 $DB = Connect();
		$strStep = Filter($_POST["step"]);
		if($strStep=="add")
		{
		}
		

		if($strStep=="edit")
		{
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
			$sqlTempfrom = " and  Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$getto."')";
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
			$sqlTempfrom = " and Date(tblInvoiceDetails.OfferDiscountDateTime)>=Date('".$getfrom."')";
		}

		if(!IsNull($to))
		{
			$sqlTempto = " and Date(tblInvoiceDetails.OfferDiscountDateTime)<=Date('".$getto."')";
		}
	}
	

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker.js"></script>
	<script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker-demo.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker-demo.js"></script>
</head>
<script>
$(document).ready(function(){
var store=$("#storeid").val();
				
		
				   $.ajax({
		type:"post",
		data:"storeid="+store,
		url:"storecategoryorder.php",
		success:function(res)
		{
		//alert(res)
		var rep = $.trim(res);
		$("#catid").show();
			$("#catid").html("");
						$("#catid").html("");
						$("#catid").html(rep);
		}
		
		})

				
		
		
})
	function printDiv(divName) 
		{
		$("#heading").show();
	    var divToPrint = document.getElementById("printdata");
    var htmlToPrint = '' +
        '<style type="text/css">' +
        'table th, table td {' +
        'border:1px solid #000;' +
        'padding;0.5em;' +
        '}' +
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
			// var printContents = document.getElementById(divName);
			// var originalContents = document.body.innerHTML;

			// document.body.innerHTML = printContents;

			// window.print();

			// document.body.innerHTML = originalContents; 
		}
function updateexpensestatus(evt)
{
	 var id=$(evt).closest('td').prev().find('input').val();
		//alert(id)
 	if(id!="")
		{
			$.ajax({
				type:"post",
				data:"id="+id,
				url:"UpdateExpensesStatus.php",
				success:function(result)
				{
			//alert(result);
				if($.trim(result)=='2')
				{
				location.reload();
				}
				}
				
				
			})
		} 
}

</script>
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
					
				<div class="panel">
				<div class="panel-body">
<style type="text/css">
@media print {
  body * {
    visibility: hidden;
  }
  #printarea * {
    visibility: visible;
  }
  #printarea{
    position: absolute;
    left: 0;
    top: 0;
  }
}
#di table
{
	border:none;
}
</style>

					<div class="example-box-wrapper">
						<div class="tabs">

											
											
										<span class="form_result">&nbsp; <br></span>
											
											<div class="panel-body">
												<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="javascript:window.location = document.referrer;"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							                   </div>
											   <br/>
												
											 <?php
											 $DB = Connect();
											 $strAvailableBalance = $row_balance['Balance'];
											 $First= date('Y-m-01');
											 $Last= date('Y-m-t');
											 $counter = 0;
																	
																	
												?>
											
												<br>
												<div class="example-box-wrapper">
												<table class="table table-bordered table-striped table-condensed cf" width="100%">
														<thead>
														
															<tr>
																<th><center>Customer</center></th>
																<th><center>Remark</center></th>
																<th><center>Comment</center></th>
																<th><center>Details</center></th>
																<th><center>Membership</center></th>
														        <th><center>Last Visit At</center></th>
																<th><center>Called By</center></th>
																<th><center>Called At</center></th>
																<th><center>Service Details</center></th>
															</tr>
													
														</thead>
													
														<tbody>

<?php
	$DB = Connect();
	$First= date('Y-m-01');
	$Last= date('Y-m-t');
$Productst="SELECT * FROM tblCustomerRemarks WHERE StoreID!='0' and NonCommentType!='0' order by Date(UpdateDate) desc";
$selpqtyPq=select("count(AppointmentID) as cntapp","tblCustomerRemarks","StoreID!='0' and NonCommentType!='0'");
$noncount=$selpqtyPq[0]['cntapp'];
	// echo "In else<br>";


// echo $sql;
$RSaT = $DB->query($Productst);
					                if ($RSaT->num_rows > 0) 
										{
											$counter=0;
											while($rowa = $RSaT->fetch_assoc())
											{
												$counter++;
												$AppointmentID=$rowa['AppointmentID'];
												$CustomerID=$rowa['CustomerID'];
												$Remark=$rowa['Remark'];
												$CommentType=$rowa['NonCommentType'];
												$UpdateDate=$rowa['UpdateDate'];
												$UpdateTime=$rowa['UpdateTime'];
												
												$UpdatedBy=$rowa['UpdatedBy'];
												$Remark=$rowa['Remark'];
													
													$selpqtyP=select("*","tblCustomers","CustomerID='".$CustomerID."'");
												    $customerfullname=$selpqtyP[0]['CustomerFullName'];
												    $CustomerMobileNo=$selpqtyP[0]['CustomerMobileNo'];
												    $NonCustomerRemark=$selpqtyP[0]['NonCustomerRemark'];
													$CustomerEmailID=$selpqtyP[0]['CustomerEmailID'];
													
													$memberid=$selpqtyP[0]['memberid'];
													
													$selptrt=select("*","tblAppointments","AppointmentID='".$AppointmentID."'");
	                                                $StoreID=$selptrt[0]['StoreID'];
													$offerid=$selptrt[0]['offerid'];
													$VoucherID=$selptrt[0]['VoucherID'];
													$PackageID=$selptrt[0]['PackageID'];
													$packages=explode(",",$PackageID);
	                                                
													$selptrtqistore=select("*","tblStores","StoreID='".$StoreID."'");
	                                                $StoreName=$selptrtqistore[0]['StoreName'];
													
													$selptrtqiemp=select("*","tblAdmin","AdminID='".$UpdatedBy."'");
	                                                $AdminFullName=$selptrtqiemp[0]['AdminFullName'];
													
													
													$selptrtqi=select("*","tblMembership","MembershipID='".$memberid."'");
	                                                $MembershipName=$selptrtqi[0]['MembershipName'];
													if($MembershipName=="")
													{
														$MembershipName='-';
													}
													
													$selptrtqiq=select("*","tblOffers","OfferID='".$offerid."'");
	                                                $OfferName=$selptrtqiq[0]['OfferName'];
													
													$selptrtqiqt=select("*","tblGiftVouchers","GiftVoucherID='".$VoucherID."'");
	                                                $Amount=$selptrtqiqt[0]['Amount'];
													for($p=0;$p<count($packages);$p++)
													{
													   $selptrtqiqtp=select("*","tblPackages","PackageID='".$packages[$p]."'");
	                                                   $name=$selptrtqiqtp[0]['Name'];
													   $pname=$name.",";
													
													}
													
												 if($CommentType=='1')
													{
														$CommentTypes="<span style='color:darkgreen'>Appointment Booked</span>";
													}
													elseif($CommentType=='2')
													{
														$CommentTypes="<span style='color:blue'>Call Later</span>";
													}
													elseif($CommentType=='3')
													{
														$CommentTypes="<span style='color:blue'>Client Unavailable</span>";
													} 
												   elseif($CommentType=='4')
													{
														$CommentTypes="<span style='color:blue'>Client Travelling</span>";
													}
													elseif($CommentType=='5')
													{
														$CommentTypes="<span style='color:red'>Unhappy with Service/Staff</span>";
													}
													elseif($CommentType=='6')
													{
														$CommentTypes="<span style='color:red'>Service is Expensive</span>";
													}
													elseif($CommentType=='7')
													{
														$CommentTypes="<span style='color:red'>Unhappy with Products</span>";
													}
													elseif($CommentType=='8')
													{
														$CommentTypes="<span style='color:pink'>Occassional Visitor</span>";
													}
													elseif($CommentType=='9')
													{
														$CommentTypes="<span style='color:red'>Not Interested</span>";
													} 
													
	
													 ?>
											   <tr>
												<td>
												
													<?=$customerfullname?>
											
												</td>
								                <td><?=$CommentTypes?></td><td><?=$Remark?></td><td><p>
														<b>Email</b> :-<?=$CustomerEmailID?><br/>
														<b>Mobile</b> :-<?=$CustomerMobileNo?><br/></p>
												</td>
												<td><p><center><b><?=$MembershipName?></b></center><br/>
													</p>
												</td>
												<td><center><b><?=$StoreName?></b></center></td>
												<td><center><b><?=$AdminFullName?></center></b></td>
												<td><b>Date:-<?=date("d-m-Y",strtotime($UpdateDate))?></b><br/>
												<b>Time:-<?=$UpdateTime?></b><br/></td>
												<td><center><a data-toggle="modal" class="btn btn-link font-red" data-target="#myModalsAppointment<?=$counter?>">View Details</center></a>
														<div class="modal fade bs-example-modal-lg" id="myModalsAppointment<?=$counter?>" role="dialog" >
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Service Details</h4></div>
                                                    <div class="modal-body">
                                                      
														<?php 
														$selptrtty=select("*","tblAppointmentsDetailsInvoice","AppointmentID='".$AppointmentID."'");
															foreach($selptrtty as $vat)
															{
																$service=$vat['ServiceID'];
																$serviceamount=$vat['ServiceAmount'];
																$set=select("*","tblServices","ServiceID='".$service."'");
																$ServiceName=$set[0]['ServiceName'];
																?>
																<b>Service</b> :- <?=$ServiceName?><br/>
																<b>Service Amount</b> :- <?=$serviceamount?><br/>
																<?php
															}
														
														?>
														
														</p>
                                                    </div>
                                                    <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                                                </div>
                                            </div>
                                        </div>	
												
												</td>
											  </tr>
													<?php
												
												
												
											}
										}
										else
										{
											?>
											<tr><td>No Records</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
											<?php
										}
											  
$DB->close();
?>
														
														</tbody>
														
													
													
													</table>
												    <?php
													$FinalPayment="";
													?>
												</div>
										</div>
											</div>

																		
					
					
			</div>
	
		
	
				</div>	
				
			
				</div>
			</div>
		</div>
		</div>
			
			<?php require_once 'incFooter.fya'; ?>
        </div>
        
    </div>
</body>
</html>