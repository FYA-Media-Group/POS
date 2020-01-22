<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "New addition of center with module & service selection | Nailspa";
	$strDisplayTitle = "New addition of center with module & service selection for Nailspa";
	$strMenuID = "3";
	$strMyTable = "tblAdmin";
	$strMyTableID = "AdminID";
	$strMyField = "Title";
	$strMyActionPage = "TransferNewCenter_detail.php";
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
		if($strStep=="edit")
		{	
	        $storename = Filter($_POST["store"]);
			$StoreOfficialAddress = Filter($_POST["StoreOfficialAddress"]);
			$StoreBillingAddress = Filter($_POST["StoreBillingAddress"]);
			$StoreOfficialEmailID = Filter($_POST["StoreOfficialEmailID"]);
			$StoreBillingEmailID = Filter($_POST["StoreBillingEmailID"]);
			$StoreOfficialNumber = Filter($_POST["StoreOfficialNumber"]);
			$StoreBillingNumber = Filter($_POST["StoreBillingNumber"]);
			
			$Categories = $_POST["Categories"];
			$ServiceIDdd = $_POST["ServiceID"];			
            $sertu=array_unique($ServiceIDdd);			
			//$Products= $_POST["Products"];
			$getfrom=date('Y-m-d');
		
			//print_r($sertu);
			$DB = Connect();
		   
			$sepstreidrecord=select("count(*)","tblStores","StoreName LIKE '".ucfirst($storename)."'");
			$contreacod=$sepstreidrecord[0]['count(*)'];
			
			
			if($contreacod>0)
			{
					$DB->close();
				die('<div class="alert alert-close alert-danger">
					<div class="bg-red alert-icon"><i class="glyph-icon icon-times"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Add Failed</h4>
						<p>This Store already exists in our system. Please try again.</p>
					</div>
				</div>');
	
			
			}
			else
			{
				$sqlInsert = "Insert into tblStores (StoreName, StoreOfficialAddress, StoreBillingAddress, StoreOfficialEmailID, StoreBillingEmailID, StoreOfficialNumber, StoreBillingNumber, Status) values
				('".ucfirst($storename)."','".$StoreOfficialAddress."', '".$StoreBillingAddress."', '".$StoreOfficialEmailID."', '".$StoreBillingEmailID."', '".$StoreOfficialNumber."', '".$StoreBillingNumber."', '0')";
				//ECHO 12345;
				
						if ($DB->query($sqlInsert) === TRUE) 
						{
							//$last_id = $DB->insert_id;
							$newstoreid = $DB->insert_id;
						}
						else
						{
							echo "Error: " . $sql . "<br>" . $conn->error;
						}
					
						
							for($j=0;$j<count($sertu);$j++)
							  {
								
									$sepASDD=select("*","tblServices","ServiceID='".$sertu[$j]."' group by ServiceCode");
								    $ServiceID=$sepASDD[0]['ServiceID'];
									$ServiceName=$sepASDD[0]['ServiceName'];
									$ServiceCode=$sepASDD[0]['ServiceCode'];
									$Time=$sepASDD[0]['Time'];
									$ServiceCost=$sepASDD[0]['ServiceCost'];
									$ServiceCommission=$sepASDD[0]['ServiceCommission'];
									$GMPercentage=$sepASDD[0]['GMPercentage'];
									$MRPLessTax=$sepASDD[0]['MRPLessTax'];
									$DirectCost=$sepASDD[0]['DirectCost'];
									$GrossMargin=$sepASDD[0]['GrossMargin'];
									$Status=$sepASDD[0]['Status'];
									$ProductPrice=$sepASDD[0]['ProductPrice'];
									
									$sqlInsert888 = "INSERT INTO tblServices (ServiceName, ServiceCode, ServiceCost, ServiceCommission, MRPLessTax, DirectCost, GMPercentage, GrossMargin,Status,StoreID,Time,ProductPrice) VALUES
									('".$ServiceName."', '".$ServiceCode."', '".$ServiceCost."', '".$ServiceCommission."','".$MRPLessTax."', '".$DirectCost."','".$GMPercentage."', '".$GrossMargin."', '".$Status."' , '".$newstoreid."' , '".$Time."', '".$ProductPrice."')";
								  // echo $sqlInsert888;
									
								if ($DB->query($sqlInsert888) === TRUE) 
									{
										
										$last_idp = $DB->insert_id;
									}
									else
									{
										echo "Error: " . $sql . "<br>" . $conn->error;
									}  
									
									
									////////////////////Add TAX for service/////////////////////////////////
									
									$pqr="Insert into tblServicesCharges (ServiceID,ChargeNameID,Status) Values ('$last_idp','1','0')";
			
				
										 if ($DB->query($pqr) === TRUE) 
										{
												// echo "Record Update successfully.";
										}
										else
										{
											//echo "Error2";
										} 
								  
								for($i=0;$i<count($Categories);$i++)
							  {
								 $sql = "SELECT ProductID FROM tblProductsServices WHERE CategoryID='$Categories[$i]' and ServiceID='$ServiceID'";
									//echo $sql."<br>";
									
									$RS = $DB->query($sql);

										if ($RS->num_rows > 0)

										{
                               	while($row = $RS->fetch_assoc())

														{
															$prod=$row['ProductID'];
															$selp=select("ProductID","tblNewProducts","ProductID='".$prod."'");
												
															$ProductID1234=$selp[0]['ProductID'];
															if($ProductID1234!="")
															{
																		
																$sqlInsert2 = "Insert into tblProductsServices(ProductID,ProductStockID,ServiceID, Status,CategoryID,StoreID,DateTimeStamp) values ('".$prod."','0', '".$last_idp."','0','".$Categories[$i]."','".$newstoreid."','".$getfrom."')";
																//echo $sqlInsert2."<br/>";
																ExecuteNQ($sqlInsert2);
															
															}
															else
															{
																$selpT=select("*","tblNewProductStocks","ProductStockID='".$prod."'");
																foreach($selpT as $val)
																{
																	$sqlInsert4 = "Insert into tblProductsServices(ProductID,ProductStockID, ServiceID, Status,CategoryID,StoreID,DateTimeStamp) values
																	('".$val['ProductID']."','".$val['ProductStockID']."','".$last_idp."','1','".$Categories[$i]."','".$newstoreid."','".$getfrom."')";
																  //  echo $sqlInsert4."<br/>";
																	ExecuteNQ($sqlInsert4);
																	
																	
																}
															}
												
													$sqlInsert3 = "Insert into tblProductServiceCategory(ProductID,ServiceID,StoredID,CategoryID) values('".$prod."','".$last_idp."','".$newstoreid."','".$Categories[$i]."')";
													//echo $sqlInsert3."<br/>";
												    ExecuteNQ($sqlInsert3);
														}
										}
							  }
							  unset($Categories);
										
						
					}
				unset($sertu);
				//die();
				// die();
			$DB->close();
			
			die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
					</div>
				</div>');
          
			}
			
			// die();

		}
		
	}	
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
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
				
					<div class="panel">
						<div class="panel-body">
							<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="<?=$strMyActionPage?>"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
						
							<div class="panel-body">
								<!--<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', '','.imageupload'); return false;" enctype="multipart/form-data">-->
							<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '','', '.imageupload'); return false;">
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

								
									<h3 class="title-hero">Transfer Data</h3>
									<div class="example-box-wrapper">
<?php

$strID = $strAdminID;
// echo $strID."<br>";
$DB = Connect();
?>
<script>
		function checktypewqfge()
		{
	     typef=[];
		 var typef = $('#Categories').val();
		// alert(typef)
	 	$.ajax({
		type:"post",	
		data: 
		   {
			typef:typef
			},
		url: "servicecatnewstore.php",
		success:function(res)
				{
			//alert(res)
				var rep= $.trim(res);
					$("#serviceid").show();
					$("#serviceid").html("");
					$("#serviceid").html("");
					$("#serviceid").html(rep);
				}
			})
		}
	function checkproduct()
	{                
	
	     valuable=[];
		 var valuable = $('#ServiceID').val();
		
		 var catt=$("#Categories").val();
		
		$.ajax({
			type: 'POST',
			url: "GetProductTransfer.php",
			data: {
				id:valuable,
				catt:catt
			},
			success: function(response) {
				//alert(response)
				$(".ProductCatWise").html(response);
					
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$(".ProductCatWise").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
				return false;
				// alert (response);
			}
		});

	}
</script>
											<div class="form-group"><label class="col-sm-3 control-label">Store Name<span>*</span></label>
												<div class="col-sm-3"><input type="text" name="store" class="form-control required"  id="store"></div>
											</div>	
                                             <div class="form-group"><label class="col-sm-3 control-label">Store Official Address<span>*</span></label>
															<div class="col-sm-3"><textarea rows="4" name="StoreOfficialAddress" id="StoreOfficialAddress" class="form-control required  " placeholder="Store Official Address"></textarea></div>
											</div>
											  <div class="form-group"><label class="col-sm-3 control-label">Store Billing Address<span>*</span></label>
															<div class="col-sm-3"><textarea rows="4" name="StoreBillingAddress" id="StoreBillingAddress" class="form-control required  " placeholder="Store Billing Address"></textarea></div>
											</div>
											  <div class="form-group"><label class="col-sm-3 control-label">Store Official Email<span>*</span></label>
															<div class="col-sm-3"><input rows="4" name="StoreOfficialEmailID" id="StoreOfficialEmailID" class="form-control required  " placeholder="Store Official Email"></div>
											</div>
											  <div class="form-group"><label class="col-sm-3 control-label">Store Billing Email<span>*</span></label>
															<div class="col-sm-3"><input rows="4" name="StoreBillingEmailID" id="StoreBillingEmailID" class="form-control required  " placeholder="Store Billing Email"></div>
											</div>
											  <div class="form-group"><label class="col-sm-3 control-label">Store Official Number<span>*</span></label>
															<div class="col-sm-3"><input rows="4" name="StoreOfficialNumber" id="StoreOfficialNumber" class="form-control required  " placeholder="Store Official Number"></div>
											</div>
										
											
											<div class="form-group"><label class="col-sm-3 control-label">Store Billing Number<span>*</span></label>
															<div class="col-sm-3"><input type="text" name="StoreBillingNumber" id="StoreBillingNumber" class="form-control required" placeholder="Store Billing Number"></div>
													</div>	
                                             <div class="form-group"><label class="col-sm-3 control-label">Category<span>*</span></label>				

												<div class="col-sm-3">	
                                                 <select class="form-control required" id="Categories" name="Categories[]" onChange="checktypewqfge();" style="height:200pt; width=200pt;" multiple>
												
												<option value="" selected>--SELECT Category--</option>

												<?php 



												$DB = Connect();

												$selectCategories=select("distinct(CategoryID)","tblProductsServices","StoreID!='0'");

													foreach($selectCategories as $valp)
                                                       {

														   $Category[]=$valp['CategoryID'];

														   $sep=select("*","tblCategories","CategoryID='".$valp['CategoryID']."'");

														$catname=$sep[0]['CategoryName'];

														?>
														  <option value="<?php echo $valp['CategoryID']?>"><?php echo $catname?></option>
														<?php
													   }

												$DB->close();																

												?>

												</select>

												</div>

												</div>
											<span id="serviceid"></span>
											 <span class="ProductCatWise" ></span>
											
											
											<div class="form-group"><label class="col-sm-3 control-label"></label>
												<input type="submit" class="btn ra-100 btn-primary" value="Update">
												
												<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
											</div>
<?php
$DB->close();
?>										
				</div>
								</form>
							</div>
						</div>
					</div>			
                  
                </div>
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>									