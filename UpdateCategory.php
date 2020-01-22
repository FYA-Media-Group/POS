<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya';?>

<div class="form-group"><label class="col-sm-3 control-label">Select Category<span>*</span></label>
				
	<div class="col-sm-2 ">	
	<select name="cat" class="form-control" id="cat">
	<option value="0">All</option>

<?php 
$store=$_POST["store"];
$strtoandfrom = $_POST["date"];
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
$DB = Connect();
                                $selpt=select("distinct(tblProductsServices.CategoryID)","tblAppointmentsDetailsInvoice
								left join tblInvoiceDetails 
								on tblAppointmentsDetailsInvoice.AppointmentID=tblInvoiceDetails.AppointmentId left join tblAppointments on tblAppointmentsDetailsInvoice.AppointmentID=tblAppointments.AppointmentID left join tblProductsServices
                                on tblProductsServices.ServiceID=tblAppointmentsDetailsInvoice.ServiceID","tblAppointmentsDetailsInvoice.ServiceID!='NULL' AND tblAppointmentsDetailsInvoice.ServiceID!='' and tblAppointments.StoreID='".$store."' AND tblAppointments.IsDeleted !=  '1' AND tblAppointments.FreeService !=  '1' and tblAppointments.Status='2' $sqlTempfrom $sqlTempto");
													foreach($selpt as $valt)
													{
														
														$CategoryID = $valt["CategoryID"];
														$selpth=select("CategoryName","tblCategories","CategoryID='".$CategoryID."'");
														$catp=$selpth[0]['CategoryName'];
														$cat=$_GET["cat"];
													
															?>
														<option value="<?=$CategoryID?>" ><?=$catp?></option>														
<?php                   

													}
																	
														?>
	
</select>
</div>
</div>