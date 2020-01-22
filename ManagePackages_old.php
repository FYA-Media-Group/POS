<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Manage Packages | Nailspa";
	$strDisplayTitle = "Manage Packages for Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblPackages";
	$strMyTableID = "PackageID";
	$strMyField = "PackageID";
	$strMyActionPage = "ManagePackages.php";
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
		// echo $strStoreID;
		
		if($strStep=="add")
		{	
			$Code = $_POST["Code"];
			$Name = Filter($_POST["Name"]);
			$StoreID = $_POST["StoreID"];
			$strstore=implode(",",$StoreID);
			$CategoryID = $_POST["category"];			
			$strcat=implode(",",$CategoryID);
			$ServiceID= $_POST["ServiceID"];
			$strser=implode(",",$ServiceID);
			$PackagePrice = Filter($_POST["PackagePrice"]);
			$PackageNewPrice = Filter($_POST["PackageNewPrice"]);
			$Validity = Filter($_POST["Validity"]);
			$Status= Filter($_POST["Status"]);
			$PackageID= Filter($_POST["PackageID"]);
			$Charges = $_POST["Charges"];	
			$Chargest=implode(",",$Charges);
		    $qty = $_POST["qty"];
			$Qtyy=implode(",",$qty);
			
			$DB = Connect();
			$sql = "SELECT $strMyTableID FROM $strMyTable WHERE Code='".$Code."'";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-warning alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
						</button>
						<strong>The Package Code already exists in the system.</strong>
					</div>');
			}
			else
			{
				foreach($StoreID as $se)
				{
					
						$sqlInsert = "INSERT INTO $strMyTable (Code, Name, StoreID, CategoryID, ServiceID, PackagePrice, PackageNewPrice, Validity,Status,Tax,Qty) VALUES
						('".$Code."','".$Name."', '".$se."', '".$strcat."', '".$strser."', '".$PackagePrice."', '".$PackageNewPrice."', '".$Validity."' , '".$Status."','".$Chargest."','".$Qtyy."')";
			
						
						if ($DB->query($sqlInsert) === TRUE) 
						{
							$last_id = $DB->insert_id;
						}
						else
						{
							echo "Error: " . $sql . "<br>" . $conn->error;
						}
					

				
			
				}
						/* 	$sql1 = "INSERT INTO tblServicesImages (ImagePath, ServiceID, Priority, IsPrimary, Status) VALUES ('$strImageUploadPath1','$last_id', '1', '1', '0')";
						//echo $sql1."<br>";
						ExecuteNQ($sql1); */
						// die();
				$DB->close();
				die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Added Successfully.</h4>
					</div>
				</div>');
			}
			
		}

		if($strStep=="edit")
		{
			$DB = Connect();
	     
			$PackageID = Filter($_POST["PackageID"]);
			$Code = Filter($_POST["Code"]);
			$Name = Filter($_POST["Name"]);
			$StoreID = $_POST["StoreID"];
			$CategoryID = $_POST["category"];
			$ServiceID = $_POST["ServiceID"];
			$PackagePrice = Filter($_POST["PackagePrice"]);
			$PackageNewPrice = Filter($_POST["PackageNewPrice"]);
			$Validity = Filter($_POST["Validity"]);
		
			$Status = Filter($_POST["Status"]);
		    $strstore=implode(",",$StoreID);
			$strcat=implode(",",$CategoryID);
			$strser=implode(",",$ServiceID);	
			$Charges = $_POST["Charges"];	
			$Chargest=implode(",",$Charges);
		    $qty = $_POST["qty"];
			$Qtyy=implode(",",$qty);
					
	
							$sqlUpdate = "UPDATE $strMyTable SET PackageNewPrice='".$PackageNewPrice."',Validity='".$Validity."',Tax='".$Chargest."' WHERE Code='".$Code."'";
				
						// $sqlUpdate = "UPDATE $strMyTable SET $key='$_POST[$key]' WHERE ServiceCode='$ServiceCode'";
						// echo $sqlUpdate;
						// die();
						ExecuteNQ($sqlUpdate);
			
				
				die('<div class="alert alert-close alert-success">
						<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
						<div class="alert-content">
							<h4 class="alert-title">Record Updated Successfully</h4>
						</div>
					</div>');
		
		}
		
	}	
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>

	<script>

	$(document).ready(function()
	{
		//alert(24);
		    $("#catid").hide();
			$("#prodid").hide(); 
	$('#select_all').click(function() 
		{
			//alert(24);
			$('#EMP').prop('selected', true);
		});	
	$("#calpackcost").click(function(){
		    serviceid=[];
			qty1=[];
			var serviceid = $("#ServiceID").val();
			var listValO = new Array();
           
		    $('.qty').each(function () { 
			   qty1.push($(this).val())
             });
	
		$.ajax({
		type:"post",
		data:"serviceid="+serviceid+"&qty="+qty1,		
		url:"CalculateServiceAmount.php",
		success:function(res)
		{
     //	alert(res)
		                 var rep= $.trim(res);
			
			            $("#PackagePrice").val("");
						$("#PackagePrice").val("");
						$("#PackagePrice").val(rep);
					    $("#PackageNewPrice").val("");
						$("#PackageNewPrice").val("");
						$("#PackageNewPrice").val(rep);
						
	
	
	
		}
		
		})
		
	});
		
	});
	function select()
	{
		//alert(24);
			$('#EMP').prop('selected', true);
	}
		function LoadValueproduct()
		{
				valuable=[];
				var valuable = $('#Products').val();
		
				 $.ajax({
					type: 'POST',
					url: "calculatemargin.php",
					data: {
						id:valuable
						
					},
					success: function(response) 
					{
						//alert(response)
						if($.trim(response)=="")
						{
							
						}
						else
						{
						//alert(response)
							$("#asmita1").show();
							$("#cost").val(response);
							var servicecost=$(".ServiceCost").val();
						//alert(servicecost)
							var productvalue = $.trim(response);
						//alert(productvalue)
							var total = parseFloat(servicecost) - parseFloat(productvalue);
						//	alert(total)
							$(".GrossMargin").val(total);
						}
						//asmita1
						/* $("#asmita1").show();
						$("#asmita1").html("");
						$("#asmita1").html(response); */
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) 
					{
						$("#asmita1").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						//alert (response);
					}
				}); 
		}
		
	/* function LoadValue(OptionValue)
            {                
				// alert (OptionValue);
				$.ajax({
					type: 'POST',
					url: "GetEmployeeListforStore.php",
					data: {
						id:OptionValue
					},
					success: function(response) {
						$(".load_charges").html(response);
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$(".load_charges").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						alert (response);
					}
				});

            }		 */	
	
			
</script>
<script>
	 function Loadme(OptionValue)
            {                
				// alert (OptionValue);
				$.ajax({
					type: 'POST',
					url: "GetEmployeeListforStoreSelected.php",
					data: {
						id:OptionValue
					},
					success: function(response) {
						$(".load_charges1").html(response);
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$(".load_charges1").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						// alert (response);
					}
				});

            }	 	
</script>

<script>
	function SelectProduct(OptionValue)
	{                
		// alert (OptionValue);
		$.ajax({
			type: 'POST',
			url: "GetProductCategorywise.php",
			data: {
				id:OptionValue
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
                        <p>Add, Edit, Delete Package Details</p>
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
											<li><a href="#normal-tabs-2" title="Tab 2">Add</a></li>
											
										</ul>
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Packages Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Package Name / Package Code </th>
																<th><center>Package Price</center></th>
															    <th>Validity</th>
															   
															   
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
															<th>Package Name / Package Code </th>
																<th><center>Package Price</center></th>
															    <th>Validity</th>
															   
															   
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</tfoot>
														<tbody>

<?php
//Retrieve And Display Values in a Table
// Create connection And Write Values
$DB = Connect();


			
			$sql = "Select * FROM $strMyTable group by Code";
			
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$counter = 0;

				while($row = $RS->fetch_assoc())
				{
					$counter ++;
					$strPackageID = $row["PackageID"];
				    $Code = $row["Code"];
					$getUID = EncodeQ($Code);
					$getUIDDelete = Encode($Code);
					
					$Name = $row["Name"];
				
				    $store = $row["StoreID"];
					$sql = select("StoreName","tblStores","StoreID='".$store."'");
			        $StoreName=$sql[0]['StoreName'];
					$PackageNewPrice = $row["PackageNewPrice"];
					$Validity = $row["Validity"];
				
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
										<td><b>Name:</b> <?=$Name?> <br><b>Code:</b> <?=$Code?></td>
										<td><center><?=$PackageNewPrice?></center></td>
									 <td><?=$Validity?></td>
									
									
										<td> 
<?php
								
?><?//=$StoreName?><br>Status : <?=$Status?></td>
								<td>
								    <a class="btn btn-link font-blue" href="ManagePackages.php?uid=<?=$getUID?>">Edit</a>
									<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step34','<?=$getUIDDelete?>', 'Are you sure you want to delete this Service - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a><a class="btn btn-link" href="UpdatePackageCost.php?uid=<?=$getUID?>">Edit MRP</a>
									
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
																<td>No Records Found</td>
																<td></td>
																<td></td>
																<td></td>
																
															</tr>
<?php
		
	
	
	// $sql = "Select * FROM $strMyTable order by $strMyTableID desc";
	// $sql = "Select Distinct(ServiceName,ServiceID,ServiceCode,ServiceCost, ServiceCommission, MRPLessTax, DirectCost,GMPercentage, GrossMargin, Status, StoreID) FROM tblServices order by ServiceID desc";
	// echo $sql;
}
$amount="";
								$total="";
								$totalamount="";
$DB->close();
?>

														</tbody>
														

													</table>
												</div>
											</div>
										</div>
<!--End Manage Tab Start ADD Tab-->										
										<div id="normal-tabs-2">
											<div class="panel-body">
											<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '','', '.imageupload'); return false;">
											
											<span class="result_message">&nbsp; <br>
											</span>
											<input type="hidden" name="step" value="add">

											
												<h3 class="title-hero">Add Packages</h3>
												<div class="example-box-wrapper">
<script>
			function LoadValue1()
			{
				storeid=[];
				var storeid=$("#StoreID").val();
				
			   if(storeid!="")
			   {
				   $.ajax({
					type:"post",
					data: {
					storeid:storeid
								
						  },
				url:"storecategory.php",
				success:function(res)
				{
			//alert(res)
				var rep = $.trim(res);
				 $("#PackagePrice").val("");
				 $("#PackageNewPrice").val("");
				   $("#catid").show();
					$("#catid").html("");
								$("#catid").html("");
								$("#catid").html(rep);
				}
				
				        })
			   }
			}
		function checktype()
		{
			type=[];
			storeid=[];
		    var type=$("#type").val();
		//alert(type)
		    var storeid=$("#StoreID").val();
				
			 if(type!="0")
				{
				$.ajax({
				type:"post",
				data: {
					type:type,
					storeid:storeid
								
					},
				url:"servicecat1.php",
				success:function(res)
				{
			 //alert(res)
				var rep= $.trim(res);
				 $("#PackagePrice").val("");
				 $("#PackageNewPrice").val("");
					$("#serviceid").show();
					$("#serviceid").html("");
								$("#serviceid").html("");
								$("#serviceid").html(rep);
			
			
			
				}
				
				})
				}
		

		}
function LoadValueasmita()
	{
		
		valuable=[];
		var valuable = $('#ServiceID').val();
		
				 $.ajax({
					type: 'POST',
					url: "servicedetail2.php",
					data: {
						id:valuable
						
					},
					success: function(response) {
						//alert(response)
						 $("#PackagePrice").val("");
				 $("#PackageNewPrice").val("");
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
													
<?php
// Create connection And Write Values
$DB = Connect();
$sql = "SHOW COLUMNS FROM ".$strMyTable." ";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{
		if($row["Field"]==$strMyTableID)
		{
		}	
		else if ($row["Field"]=="Name")
		{
?>	
                                                   <input type="hidden" name="PackageID" value="<?=$strMyTableID?>" />
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Name", "Package Name", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3"><input type="text" style="text-transform:capitalize" name="<?=$row["Field"]?>" id="<?=str_replace("Name", "Service Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("POST", "Winter Package", $row["Field"])?>"></div>
													</div>													
<?php	
		}
		else if ($row["Field"]=="Code")
		{
?>	
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Code", "Package Code", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Code", "Service Code", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Code", "Pedicure001, menicure001", $row["Field"])?>"></div>
												</div>	
											
<?php	
		}
		else if ($row["Field"]=="StoreID")
		{
											$sql1 = "SELECT StoreID, StoreName FROM tblStores WHERE Status=0";
											$RS2 = $DB->query($sql1);
											if ($RS2->num_rows > 0)
											{
?>											
													<div class="form-group"><label class="col-sm-3 control-label">Store Name<span>*</span></label>
														<div class="col-sm-4">
															<select class="form-control required" id="StoreID" name="StoreID[]" onChange="LoadValue1();" style="height:80pt" multiple >
																	<option value="" selected>--Select Store--</option>
<?
																		while($row2 = $RS2->fetch_assoc())
																		{
																			$selectStoreID = $row2["StoreID"];
																			$StoreName = $row2["StoreName"];	
?>
																			<option value="<?=$selectStoreID?>"><?=$StoreName?></option>
<?php
																		}
?>
															</select>
<?php
											}
											else
											{
												echo "Stores Not Found <a href='ManageStores.php' target='ManageStores'>Click here to add</a>";
											}
?>
														</div>
													</div>	

													<span id="catid"></span>
													<span id="serviceid"></span>
													<span id="asmita1"></span>
                                                    <div class="form-group"><div class="col-sm-3 "><span><input type="button" id="calpackcost" class="btn ra-100 btn-primary" value="Calculate Package Cost"></span></div></div>													
<?php	
		}
		else if ($row["Field"]=="Status")
		{
?>
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Status", "Status", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3">
															<select name="<?=$row["Field"]?>" class="form-control required">
																<option value="0" Selected>Live</option>
																<option value="1">Offline</option>	
															</select>
														</div>
													</div>	
<?php
		}
	elseif($row["Field"]=="CategoryID")
	   {
?>

													
											
<?php
	   }
	   	elseif($row["Field"]=="Qty")
	   {
?>

													
											
<?php
	   }
	   	elseif($row["Field"]=="PackagePrice")
	   {
?>	
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PackagePrice", "Total Package Cost", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("PackagePrice", "PackagePrice", $row["Field"])?>" class="form-control required" readonly ></div>
												</div>	
											
<?php	
	   }
	   	elseif($row["Field"]=="PackageNewPrice")
	   {
?>
<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PackageNewPrice", "Selling Price", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("PackageNewPrice", "PackageNewPrice", $row["Field"])?>" class="form-control required" ></div>
												</div>	
													
											
<?php
	   }
	   	elseif($row["Field"]=="Validity")
	   {
?>
        <div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Validity", "Validity", $row["Field"])?> <span>*</span></label><div class="col-sm-3">
										<select id="Validity" class="form-control required"  name="Validity" >
																<option value="">Month</option>
															<?php
													     	$count=1;
																while($count<13)
																{
																	
																		?>
																	
																
															<option value="<?= $count ?>"><?= $count ?></option>
																	<?php
																	
																	
																	$count++;
																}
															?>
																
															</select>				
											</div></div>
<?php
	   }
	   elseif($row["Field"]=="Tax")
	   {
?>
	<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12">Select Charges<span>*</span><br><span style="font-weight:light">Press Ctrl and Select for multiple Selection</span></label>
													<div class="col-sm-4">
<?php
														$sql = "SELECT 	ChargeNameID ,ChargeName FROM tblChargeNames WHERE Status='0'"; 
														$RS2 = $DB->query($sql);
														if ($RS2->num_rows > 0)
														{
?>
															<select class="form-control required" name="Charges[]" multiple style="height:80pt">
																<option value="" selected>--SELECT Products--</option>
	<?
																	while($row2 = $RS2->fetch_assoc())
																	{
																		$ChargeNameID = $row2["ChargeNameID"];
																		// echo $ProductID;
																		$ChargeName = $row2["ChargeName"];	
	?>
																		<option value="<?=$ChargeNameID?>"><?=$ChargeName?></option>
	<?php
																	}
	?>
															</select>
<?php
														}
														else
														{
															echo "Charges are not added. <a href='ManageChargeNames.php' target='Charges'>Click here to add</a>";
														}
?>
													</div>
												</div>
													
											
<?php
	   }
	   	elseif($row["Field"]=="ServiceID")
	   {
?>

													
											
<?php
	   }
     else
		{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $row["Field"])?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Admin", " ", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("Admin", " ", $row["Field"])?>">
												</div>
											</div>
<?
		}
	}
?>
	                                              
														
													
														<div class="form-group"><label class="col-sm-3 control-label"></label>
															<input type="submit" class="btn ra-100 btn-primary" value="Submit">
															
															<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
														</div>
<?php
}
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
                    </div>
<?php
} // End null condition
else
{
?>						
					
					<div class="panel">
						<div class="panel-body">
							<div class="fa-hover">	
								<a class="btn btn-primary btn-lg btn-block" href="<?=$strMyActionPage?>"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
							</div>
						
							<div class="panel-body">
							<form role="form" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '.admin_email','', '.imageupload'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
								<br>
								<input type="hidden" name="step" value="edit">

								
									<h3 class="title-hero">Edit Package Details</h3>
									<div class="example-box-wrapper">
						
		
										
<?php

 $strID = DecodeQ(Filter($_GET["uid"]));
$DB = Connect();
$sql = "select * FROM $strMyTable where Code = '$strID' group by Code";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{	

	$sep=select("*","tblPackages","Code='".$strID."'");
		foreach($sep as $vap)
		{
			 $PackageID[]=$vap["PackageID"];
			 $storesp[]=$vap["StoreID"];
			 $ServiceID=$vap["ServiceID"];
			 $cattp=$vap["CategoryID"];
			 $qty=$vap["Qty"];
			 $PackagePrice +=$vap["PackagePrice"];
			 $PackageNewPrice +=$vap["PackageNewPrice"];
			 
			 $toPackageNewPrice=$toPackageNewPrice+$PackageNewPrice;
			 $cattpt=explode(",",$cattp);
			 $ser=explode(",",$ServiceID);
			 $qtypp=explode(",",$qty);
		}

		$Name=$row["Name"];
		$Code=$row["Code"];
		$Validity=$row["Validity"];
		$Status=$row["Status"];
		$Tax=$row["Tax"];
		$strtax=explode(",",$Tax);											
		?>
	<script type="text/javascript">
	
	
	
		$(document).ready(function()
		{
				$("#catid").show();
				$("#serviceid").show();
			
		$("#calpackcost").click(function(){
		    serviceid=[];
			qty1=[];
			var serviceid = $("#ServiceID").val();
			var PackagePrice=$("#PackagePrice").val();
			var listValO = new Array();
            alert(serviceid)
		    $('.qty').each(function () { 
			   qty1.push($(this).val())
             });
	    alert(qty1)
		$.ajax({
		type:"post",
		data:"serviceid="+serviceid+"&qty="+qty1,		
		url:"CalculateServiceAmount.php",
		success:function(res)
		{
             //alert(res)
		               var rep = $.trim(res);
			
			            $("#PackagePrice").val("");
						$("#PackagePrice").val("");
						
					    $("#PackageNewPrice").val("");
						$("#PackageNewPrice").val("");
						$("#PackagePrice").val(rep);
						$("#PackageNewPrice").val(rep);
						
	
	
	
		}
		
		})
		
	});
		});
	
		
			function LoadValue1()
			{
				storeid=[];
				var storeid=$("#StoreID").val();
					
			   if(storeid!="")
			   {
				   $.ajax({
		type:"post",
		data: {
			storeid:storeid
						
					},
		url:"storecategory.php",
		success:function(res)
		{
	//alert(res)
		var rep = $.trim(res);
        $("#PackagePrice").val("");
		
		$("#catid").show();
		$("#catid").html("");
		$("#catid").html("");
	    $("#catid").html(rep);
		}
		
		})
			   }
			}
		function checktype()
		{
			type=[];
			storeid=[];
		var type=$("#type").val();
		//alert(type)
		var storeid=$("#StoreID").val();
				
	 if(type!="0")
		{
		$.ajax({
		type:"post",
		data: {
			type:type,
			storeid:storeid
						
			},
		url:"servicecat1.php",
		success:function(res)
		{
	 //alert(res)
			 $("#PackagePrice").val("");
			 $("#PackageNewPrice").val("");
		    var rep= $.trim(res);
			$("#serviceid").show();
			$("#serviceid").html("");
						$("#serviceid").html("");
						$("#serviceid").html(rep);
	
	
	
		}
		
		})
		}
		
		
		}
		
		
	</script>
		<?php
		foreach($row as $key => $val)
		{
			if($key==$strMyTableID)
			{
?>
											<input type="hidden" name="<?=$key?>" value="<?=$strID?>">	

<?php
			}
			elseif($key=="Code")
			{
?>	
										
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Code", "Package Code", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input class="form-control" value="<?=$row[$key]?>" name="Code" readonly></div>
											</div>
										
											
<?php
			}
			elseif($key=="Name")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Name", "Package Name", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Name", "Name", $key)?>" value="<?=$Name?>"></div>
											</div>
<?php
			}
			elseif($key=="PackagePrice")
			{
?>	
                                             <input type="hidden" id="PackagePrice" value="<?=$PackagePrice?>" />
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PackagePrice", "Total Package Cost", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("PackagePrice", "PackagePrice", $key)?>" value="<?=$PackagePrice?>" readonly id="PackagePrice"></div>
											</div>
<?php
			}
			elseif($key=="PackageNewPrice")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("PackageNewPrice", "Selling Price", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" id="PackageNewPrice" placeholder="<?=str_replace("PackageNewPrice", "PackageNewPrice", $key)?>" value="<?=$PackageNewPrice?>"></div>
											</div>
<?php
			}
			elseif($key=="CategoryID")
			{
			}
			elseif($key=="ServiceID")
			{
			}
		  elseif($key=="Validity")
			{
?>
        <div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Validity", "Validity", $key)?> <span>*</span></label><div class="col-sm-3">
										<select id="Validity" class="form-control required"  name="Validity" >
																<option value="">Month</option>
															<?php
													     	$count=1;
																while($count<13)
																{
																	if($Validity==$count)
																	{
																		//echo 2324;
																		?>
																<option value=" <?php  echo $count;   ?>" selected='selected'  ><?php  echo $count;   ?></option>
																<?php
																		
																	}
																	else
																	{
																		?>
																		
																	
																
															<option value="<?= $count ?>"><?= $count ?></option>
																	<?php
																	}
																	
																	$count++;
																}
															?>
																
															</select>				
											</div></div>
											<?php
			}
			elseif($key=="StoreID")
			{
				?>
					<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreID", "Store", $key)?> <span>*</span></label>
												<div class="col-sm-4">
													<select name="<?=$key?>[]" class="form-control  required"  onChange="LoadValue1();" id="StoreID" readonly style="height:80pt" multiple>
														<option value="0">Select Here</option>
														<?php  
														$storep=$row[$key];
														$stores=explode(",",$storep);
													
															$sql_display = "SELECT * FROM tblStores";
															$RS_display = $DB->query($sql_display);
															if ($RS_display->num_rows > 0) 
															{
																while($row_display = $RS_display->fetch_assoc())
																{
																	$StoreName = $row_display["StoreName"];
																	$StoreID = $row_display["StoreID"];
																	if (in_array("$StoreID", $storesp))
																	{
																	?>
																		<option selected value="<?=$StoreID?>"><?=$StoreName?></option>
																	<?
																	}
																	else
																	{
																	?>
																		<option value="<?=$StoreID?>"><?=$StoreName?></option>
																	<?
																	}
																}
															}
														?>
													</select>
												</div>
											</div>
											<span id="catid">
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Category", "Category", "Category")?> <span>*</span></label>
												<div class="col-sm-4">
													<select class="form-control required" multiple style="height:100pt" id="type"  name="category[]" onChange="checktype();" readonly >
														<option value="0">--Select--</option>
														<?php
													
															for($a=0;$a<count($storesp);$a++)
															{
																$selectCategories=select("distinct(CategoryID)","tblProductsServices","StoreID='".$storesp[$a]."'");
																
																
															}
															
															foreach($selectCategories as $cat)
															{
																$CategoryID=$cat['CategoryID'];
																$sep=select("*","tblCategories","CategoryID='".$CategoryID."'");
																		$CategoryName=$sep[0]['CategoryName'];
																if (in_array("$CategoryID", $cattpt))
																	{
																		$sep=select("*","tblCategories","CategoryID='".$CategoryID."'");
																		$CategoryName=$sep[0]['CategoryName'];
																		$catt=$sep[0]['CategoryID'];
																	?>
																		<option selected="selected" value="<?=$catt?>"><?=$CategoryName?></option>
																	<?
																	}
																	else
																	{
																	?>
																		<option value="<?=$CategoryID?>"><?=$CategoryName?></option>
																	<?
																	}
															}
															
															
														?>
													</select>
													
												</div>
											</div>	
				
											</span>
				                            <span id="serviceid">
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ServiceID", "Service", "Service")?> <span>*</span></label>
												<div class="col-sm-4">
													<select name="ServiceID[]" class="form-control col-sm-4 load_charges required" multiple style="height:150pt" id="ServiceID" onChange="LoadValueasmita();" readonly >
														<option value="0">--Select--</option>
														<?php
														
											      $type=$cattpt;
										       for($i=0;$i<count($type);$i++)
														   {
															  
																    $sql_display=select("distinct(ServiceID)","tblProductsServices","CategoryID IN('".$type[$i]."') and StoreID IN('".$storesp[$i]."')");
																	foreach($sql_display as $val)
															         {
																		 $servicessr[]=$val['ServiceID'];
																	
																	 }
																	
															  
														
														
															 
														   }
												
													
													  $servicess=array_unique($servicessr);
													
														for($t=0;$t<count($servicess);$t++)
															 {
																
																if($servicess[$t]=="")
																 {
																	
																 }
																 else
																 {
																	 if(in_array("$servicess[$t]",$ser))
																	 {
																		
																		 $selpt=select("DISTINCT(ServiceID)","tblServices","ServiceID='".$servicess[$t]."'");
																	        	$serviceidd=$selpt[0]['ServiceID'];
																			if($serviceidd==$servicess[$t])
																			{
																				$seti=select("*","tblServices","ServiceID='".$serviceidd."'");
																			$servicename=$seti[0]['ServiceName'];
																			$ServiceCost = $seti[0]["ServiceCost"];
																				?>
																		<option selected="selected" value="<?=$serviceidd?>"><?php echo $servicename?>, Rs. <?=$ServiceCost?></option>
																	<?
																			}
																			else
																			{
																				
																			}
																	 }
																	 else
																	 {
																		  $selpt=select("DISTINCT(ServiceID)","tblServices","ServiceID='".$servicess[$t]."'");
																	        	$serviceidd=$selpt[0]['ServiceID'];
																			if($serviceidd==$servicess[$t])
																			{
																				$seti=select("*","tblServices","ServiceID='".$serviceidd."'");
																			$servicename=$seti[0]['ServiceName'];
																			$ServiceCost = $seti[0]["ServiceCost"];
																				?>
																		<option value="<?=$serviceidd?>"><?php echo $servicename?>, Rs. <?=$ServiceCost?></option>
																	<?
																			}
																			else
																			{
																				
																			}
																	 }
																	 
																				
																 }			
																														
															 }
															
													
													
														
										
															
													?>
													</select>
													
												</div>
											</div>	
											</span>
											
											<div class="form-group">
											<label class="col-sm-3 control-label">Qty<span>*</span></label>
											<div class="col-sm-3">		
										    <?php
											for($u=0;$u<count($ser);$u++)
											{
												  $seld=select("*","tblServices","ServiceID='".$ser[$u]."'");
												  $servicename=$seld[0]['ServiceName'];
												  for($i=0;$i<count($qtypp);$i++)
												  {
													  ?>
												<b><?php echo $seld[0]['ServiceName']  ?></b><br/>
												<input type="number" name="qty[]" id="qty" class="form-control qty"  min="1" max="10" value="<?=$qtypp[$i]?>" readonly />
												<?php
												  }
												  unset($qtypp);
												
											}
											
											?>
											</div>
											</div>
											<span id="asmita1">
												</span>
											
												 
<?php
			}
		    elseif($key=="Qty")
			{
			}
			elseif($key=="Status")
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $key)?> <span>*</span></label>
												<div class="col-sm-4">
													<select name="<?=$key?>" class="form-control required">
														<?php
															if ($Status=="0")
															{
														?>
																<option value="0" selected>Live</option>
																<option value="1">Offline</option>
														<?php
															}
															elseif ($Status=="1")
															{
														?>
																<option value="0">Live</option>
																<option value="1" selected>Offline</option>
														<?php
															}
															else
															{
														?>
																<option value="" selected>--Choose option--</option>
																<option value="0">Live</option>
																<option value="1">Offline</option>
														<?php
															}
														?>	
													</select>
												</div>
											</div>
											
<?php	
			}
			elseif($key=='Tax')
			{
?>				
				                                 <div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12">Select Charges<span>*</span><br><span style="font-weight:light">Press Ctrl and Select for multiple Charges</span></label>
													<div class="col-md-3 col-sm-3 col-xs-6 load_charges">
														<select class="form-control required" name="Charges[]" multiple  style="height:100pt;">
																<option value="" >--SELECT Charges--</option>
<?
																	
																	$chargezdata=select("*"," tblCharges","Status=0");
																	foreach($chargezdata as $selcharge)
																	{
																		$strcharge=$selcharge['ChargeNamesID'];
																		$chargenameforid="select ChargeName from tblChargeNames where ChargeNameID=$strcharge";
																		$RS2 = $DB->query($chargenameforid);
																		if ($RS2->num_rows > 0)
																		{
																			while($row2 = $RS2->fetch_assoc())
																			{
																				$ChargeName = $row2["ChargeName"];
																				if(in_array("$strcharge", $strtax))
																				{
		?>
																					<option selected value="<?=$strcharge?>"><?=$ChargeName?><?=$strcharge?></option>
		<?  
																				}
																				else
																				{
		?>
																					<option  value="<?=$strcharge?>"><?=$ChargeName?></option><?=$strcharge?>
		<?  
																				}
																			}
																		}
																	}
?>

															</select>

													</div>
												</div>
												<?php
			}
			else
			{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Admin", " ", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("Admin", " ", $key)?>" value="<?=$row[$key]?>"></div>
											</div>
<?php
			}
		}
	}
?>
									
											
											
											<div class="form-group"><label class="col-sm-3 control-label"></label>
												<input type="submit" class="btn ra-100 btn-primary" value="Update">
												
												<div class="col-sm-1"><a class="btn ra-100 btn-black-opacity" href="javascript:;" onclick="ClearInfo('enquiry_form');" title="Clear"><span>Clear</span></a></div>
											</div>
<?php
}
$DB->close();
?>													
										
									</div>
							</form>
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