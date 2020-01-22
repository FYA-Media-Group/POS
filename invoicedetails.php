<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Invoice | Nailspa";
	$strDisplayTitle = "Invoice for Nailspa";
	$strMenuID = "10";
	$strMyTable = "tblInvoice";
	$strMyTableID = "InvoiceID";
	$strMyActionPage = "invoicedetails.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
//error_reporting(E_ALL);
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
// code for not allowing the normal admin to access the super admin rights	

	
	
	
	
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
</head>
  <script type="text/javascript">
  $(document).ready(function(){
	//  alert(222)
	   $("#btnPrint").click(function () {
			//alert(111)
            var divContents = $("#dvContainer").html();
            var printWindow = window.open('', '', 'height=400,width=800');
          printWindow.document.write('<html><head><title>Invoice</title>');
      printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
      printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
	  
  });
       
    </script>
<style>
.btn-success
{
	background-color:lightgreen;
	color:black;
	
}
.btn-success:hover
{
	background-color:lightgreen;
		color:black;
}
</style>
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
					

  <?php                  
if(isset($_GET['uid']))
{
	//$DB = Connect();

$strID = DecodeQ(Filter($_GET['uid']));
	?>
	             <div class="panel">
						<div class="panel-body">
							<div class="fa-hover">	
								<a href="javascript:window.location = document.referrer;" class="btn btn-primary btn-lg btn-block"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
						
							<div class="panel-body">
							
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

									<h3 class="title-hero" style="text-align:center">Invoice Details</h3>
									<button type="button" class="btn btn-success" data-toggle="button" style="float:right">Send Reminder Mail</button>
									<button type="button" class="btn btn-info" id="btnPrint" data-toggle="button" style="float:left">Print</button>
									
									
									
							</div>
							<div id="dvContainer" class="panel-body">
								<?php
				$DB = Connect();

$strID = DecodeQ(Filter($_GET['uid']));
//echo $strID;
					$sql_appointments = select("*","tblEmailMessages","ID='".$strID."'");
					//print_r($sql_appointments);
					echo $sql_appointments[0]['Body'];
								?>
								</div>
							</div>
							</div>
							<?php
}	
else
{
?>	
                    <div class="panel">
						<div class="panel">
							<div class="panel-body">
								<div class="example-box-wrapper">
								<span class="form_result">&nbsp; <br></span>
									<div class="panel-body">
										<h3 class="title-hero">List of Invoice | Nailspa</h3>
										<div class="example-box-wrapper">
											<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>Sr.No</th>
														<th>Appointment ID</th>
													
														<th>Email Message ID</th>
														<th>Date Of Creation</th>
													    <th>Action</th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>Sr.No</th>
														<th>Appointment ID</th>
													
														<th>Email Message ID</th>
														<th>Date Of Creation</th>
														<th>Action</th>
													</tr>
												</tfoot>
												<tbody>

<?php
// Create connection And Write Values
$DB = Connect();

$sql = "SELECT * FROM ".$strMyTable;
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
$counter = 0;

while($row = $RS->fetch_assoc())
{
$counter ++;
$InvoiceID = $row["InvoiceID"];
$EmailMessageID = $row["EmailMessageID"];
$getUID = EncodeQ($EmailMessageID);
$AppointmentID = $row["AppointmentID"];

$DateOfCreation = $row["DateOfCreation"];
	

?>	
													<tr id="my_data_tr_<?=$counter?>">
														<td style="text-align: center"><?=$counter?></td>
														<td style="text-align: center">
														<?=$AppointmentID?>
														</td>
														
														<td style="text-align: center">
													
													<?=$EmailMessageID?>
														
														</td>
													<td style="text-align: center">
													
													<?=$DateOfCreation?>
														
														</td>
														<td style="text-align: center">
															
																	<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">View Details</a><br>
																	
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
					<?php
					}
					?>
                      </div>
                    </div>
                  </div>
            		 
          
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>