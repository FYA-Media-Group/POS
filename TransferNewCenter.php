<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "New addition of center with module & service selection | Nailspa";
	$strDisplayTitle = "New addition of center with module & service selection for Nailspa";
	$strMenuID = "3";
	$strMyTable = "tblAdmin";
	$strMyTableID = "AdminID";
	$strMyField = "Title";
	$strMyActionPage = "TransferNewCenter.php";
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
			
			$Categories = Filter($_POST["Categories"]);
			$ServiceID = $_POST["ServiceID"];				
			$Products= $_POST["Products"];
			$getfrom=date('Y-m-d');
			//print_r($_POST);
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
				('".ucfirst($storename)."','".StoreOfficialAddress."', '".$StoreBillingAddress."', '".$StoreOfficialEmailID."', '".$StoreBillingEmailID."', '".$StoreOfficialNumber."', '".$StoreBillingNumber."', '0')";
				//ECHO 12345;
				
						if ($DB->query($sqlInsert) === TRUE) 
						{
							$last_id = $DB->insert_id;
						}
						else
						{
							echo "Error: " . $sql . "<br>" . $conn->error;
						}
					
			
				/* for($j=0;$j<count($ServiceID);$j++)
				{
					
					$sepASDD=select("*","tblServices","ServiceID='".$ServiceID[$j]."'");
					
                    foreach($sepASDD as $vatu)
					{
						$sqlInsert888 = "INSERT INTO tblServices (ServiceName, ServiceCode, ServiceCost, ServiceCommission, MRPLessTax, DirectCost, GMPercentage, GrossMargin,Status,StoreID,Time,ProductPrice) VALUES
						('".$vatu['ServiceName']."','".$vatu['ServiceCode']."', '".$vatu['ServiceCost']."', '".$vatu['ServiceCommission']."', '".$vatu['MRPLessTax']."','".$vatu['DirectCost']."', '".$vatu['GMPercentage']."', '".$vatu['GrossMargin']."', '".$vatu['Status']."' , '".$last_id."' , '".$vatu['Time']."', '".$vatu['ProductPrice']."')";
				       
						
						if ($DB->query($sqlInsert888) === TRUE) 
						{
							$last_idhgvjh = $DB->insert_id;
						}
						else
						{
							echo "Error: " . $sql . "<br>" . $conn->error;
						} 
					
						// foreach($strPr
					}
					
			   for($i=0;$i<count($Products);$i++)
				{
					//print_r($Products);
					
					$selp=select("ProductID","tblNewProducts","ProductID='".$Products[$i]."'");
					// print_r($selp)."<br>";
					$ProductID1234=$selp[0]['ProductID'];
					if($ProductID1234!="")
					{
								
						$sqlInsert2 = "Insert into tblProductsServices(ProductID,ProductStockID,ServiceID, Status,CategoryID,StoreID,DateTimeStamp) values ('".$Products[$i]."','0', '".$ServiceID[$j]."','0','".$Categories."','".$last_id."','".$getfrom."')";
						ExecuteNQ($sqlInsert2)."<br>";
					// echo $sqlInsert2."<br>";
					}
					else
					{
						$selpT=select("*","tblNewProductStocks","ProductStockID='".$Products[$i]."'");
						foreach($selpT as $val)
						{
							$sqlInsert2 = "Insert into tblProductsServices(ProductID,ProductStockID, ServiceID, Status,CategoryID,StoreID,DateTimeStamp) values
							('".$val['ProductID']."','".$val['ProductStockID']."','".$ServiceID[$j]."','1','".$Categories."','".$last_id."','".$getfrom."')";
							// echo $sqlInsert2."<br>";
							// echo "Hello";
							ExecuteNQ($sqlInsert2);
							//echo $sqlInsert2."<br>";
							
						}
					}
					
						$sqlInsert2 = "Insert into tblProductServiceCategory(ProductID,ServiceID,StoredID,CategoryID) values('".$Products[$i]."','".$ServiceID[$j]."','".$last_id."','".$Categories."')";
					
					// echo $sqlInsert2."<br>";
					 // echo "Hello";
					
					 ExecuteNQ($sqlInsert2);
				
				} 
				UNSET($Products);
				}
				UNSET($ServiceID); */
			$DB->close();
			
			die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
					</div>
				</div>');
          
			}
			
			

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
		function checktypewqfge(evt)
		{
	
	 	$.ajax({
		type:"post",	
		data:"typef="+evt,
		url: "servicecatnewstore.php",
		success:function(res)
				{
			// alert(res)
				var rep= $.trim(res);
					$("#serviceid").show();
					$("#serviceid").html("");
					$("#serviceid").html("");
					$("#serviceid").html(rep);
				}
			})
		}
	function checkproduct(OptionValue)
	{                
		// alert (OptionValue);
		var catt=$("#Categories").val();
		
		$.ajax({
			type: 'POST',
			url: "GetProductTransfer.php",
			data: {
				id:OptionValue,
				catt:catt
			},
			success: function(response) {
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