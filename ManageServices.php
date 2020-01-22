<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<?php
	$strPageTitle = "Manage Services | Nailspa";
	$strDisplayTitle = "Manage Services for Nailspa";
	$strMenuID = "2";
	$strMyTable = "tblServices";
	$strMyTableID = "ServiceID";
	$strMyField = "ServiceCode";
	$strMyActionPage = "ManageServices.php";
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
		$strCharges = $_POST["Charges"];	
		$strTechnician = $_POST["Technician"];	
		$strStoreID=$_POST["StoreID"];
		$strProducts = $_POST["Products"];		
		$strStep = Filter($_POST["step"]);
		// echo $strStoreID;
		
		if($strStep=="add")
		{	
			$strCategories = $_POST["Categories"];
			
		//echo $strCategories."<br>";
			// $strProducts = $_POST["Products"];
			// echo $strProducts."<br>";
			$strServiceName = Filter($_POST["ServiceName"]);
			$strServiceCode = Filter($_POST["ServiceCode"]);
			$strServiceCost = Filter($_POST["ServiceCost"]);				
			$strServiceCommission= Filter($_POST["ServiceCommission"]);
			$strMRPLessTax = Filter($_POST["MRPLessTax"]);
			$strDirectCost = Filter($_POST["DirectCost"]);
			$strGMPercentage = Filter($_POST["GMPercentage"]);
			$strGrossMargin= Filter($_POST["GrossMargin"]);
			$strStatus= Filter($_POST["Status"]);
			$strTime= Filter($_POST["Time"]);
			$cost= Filter($_POST["cost"]);
		   $getfrom=date('Y-m-d');
			// $strStoreID= Filter($_POST["StoreID"]);
			// echo $strStoreID."<br>";
			// die();
			$Category= $_POST["category"];
			// echo $strServiceName;
	
			
			$DB = Connect();
			$sql = "SELECT $strMyTableID FROM $strMyTable WHERE $strMyField='".$strServiceCode."'";
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$DB->close();
				die('<div class="alert alert-warning alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
						</button>
						<strong>The Service Code already exists in the system.</strong>
					</div>');
			}
			else
			{
				foreach($strStoreID as $stor)
				{
						
						$sqlInsert = "INSERT INTO $strMyTable (ServiceName, ServiceCode, ServiceCost, ServiceCommission, MRPLessTax, DirectCost, GMPercentage, GrossMargin,Status,StoreID,Time,ProductPrice) VALUES
						('".$strServiceName."','".$strServiceCode."', '".$strServiceCost."', '".$strServiceCommission."', '".$strMRPLessTax."', '".$strDirectCost."', '".$strGMPercentage."', '".$strGrossMargin."' , '".$strStatus."' , '".$stor."', '".$strTime."','".$cost."')";
				
						
						if ($DB->query($sqlInsert) === TRUE) 
						{
							$last_id = $DB->insert_id;
						}
						else
						{
							echo "Error: " . $sql . "<br>" . $conn->error;
						}
					
						// foreach($strProducts as $pr)
						// {
							// echo "pr is".$pr."<br>";
							// $Insertstoreid="Insert into tblEmployeesServices (EID, ServiceID, Status) values
							// ('".$emp."', '".$last_id."','0')";
						// }
						foreach($strCharges as $Charges)
						{
							$sqlInsert1 = "Insert into tblServicesCharges (ServiceID, ChargeNameID, Status) values
							('".$last_id."', '".$Charges."','0')";
							//echo $sqlInsert1."<br>";
							$DB->query($sqlInsert1);
						}
						
						
						foreach($strTechnician as $emp)
						{
							$sqlInsert1 = "Insert into tblEmployeesServices (EID, ServiceID,CategoryID,Status) values
							('".$emp."', '".$last_id."','".$strCategories."','0')";
							//echo $sqlInsert1."<br>";
							$DB->query($sqlInsert1);
						}
						// die();
				
						//print_r($strProducts);
				
			
				 		foreach($strProducts as $Products1)
						{
							
							$selp=select("ProductID","tblNewProducts","ProductID='".$Products1."'");
								
							$ProductIDs=$selp[0]['ProductID'];
							//echo "Cnt is ".$cnt."<br>";
							if($ProductIDs!="0")
							{
							
							
								$sqlInsert2 = "Insert into tblProductsServices(ProductID,ProductStockID,ServiceID, Status,CategoryID,StoreID,DateTimeStamp) values
								('".$Products1."','0', '".$last_id."','0','".$strCategories."','".$stor."','".$getfrom."')";
								//echo $sqlInsert2;
								ExecuteNQ($sqlInsert2);
								
							}
							else
							{
							
								$selpT=select("*","tblNewProductStocks","ProductStockID='".$Products1."'");
								// echo $selpT."<br>";
								foreach($selpT as $val)
								{
									// echo $val."<br>";
									$sqlInsert2 = "Insert into tblProductsServices(ProductID,ProductStockID, ServiceID, Status,CategoryID,StoreID,DateTimeStamp) values
									('".$val['ProductID']."','".$val['ProductStockID']."','".$last_id."','1','".$strCategories."','".$stor."','".$getfrom."')";
								
									// echo "Hello";
									ExecuteNQ($sqlInsert2);
								}
							}
						} 
						
						foreach($strProducts as $Products1)
						{
							//echo $strStoreID;
							$sqlInsert2 = "Insert into tblProductServiceCategory(ProductID,ServiceID,StoredID,CategoryID) values('".$Products1."','".$last_id."','".$stor."','".$strCategories."')";
							//   echo $sqlInsert2."<br>";
							 // echo "Hello";
							$DB->query($sqlInsert2);
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
	     
			$ServiceName = Filter($_POST["ServiceName"]);
			$ServiceCode = Filter($_POST["ServiceCode"]);
			$Time = Filter($_POST["Time"]);
			$ServiceCost = Filter($_POST["ServiceCost"]);
			$ServiceCommission = Filter($_POST["ServiceCommission"]);
			$MRPLessTax = Filter($_POST["MRPLessTax"]);
			$DirectCost = Filter($_POST["DirectCost"]);
			$GMPercentage = Filter($_POST["GMPercentage"]);
			$GrossMargin = Filter($_POST["GrossMargin"]);
			$Status = Filter($_POST["Status"]);
		
			//$StoreID = Filter($_POST["StoreID"]);
			$Category= $_POST["category"];
			$strProducts= $_POST["Products"];
		    $cost= Filter($_POST["cost"]);
			$costt= Filter($_POST["costt"]);
			 $getfrom=date('Y-m-d');
			$sept=select("StoreID,ServiceID","tblServices","ServiceCode='".$ServiceCode."'");
			foreach($sept as $ttt)
			{
				$StoreID[]=$ttt['StoreID'];
				$ServiceID[]=$ttt['ServiceID'];
			}
			
			
			
			// echo $Category;
			// die();
			
			/////////////////////////////////////////
			foreach ($_POST['EID'] AS $key1 => $val1)
			{
				if(IsNull($sqlColumnValues1))
				{
					$sqlColumn1 = $key1;
					$sqlColumnValues1 = $val1;
				}
				else
				{
					$sqlColumn1 = $sqlColumn1.",".$key1;
					$sqlColumnValues1 = $sqlColumnValues1.",".$val1;
				}
			}
			$_POST['EID'] = $sqlColumnValues1;
			
			$selectrecord="Select ServiceCode from tblServices where ServiceName='$ServiceName'";
			// echo $selectrecord."<br>";
			$RSf = $DB->query($selectrecord);
			if ($RSf->num_rows > 0) 
			{
				while($rowf = $RSf->fetch_assoc())
				{
					$ServiceCode = $rowf["ServiceCode"];
					// echo $ServiceCode."<br>";
				}
			}
			// echo $ServiceCode."<br>";
			// die();
			
			
			for($i=0;$i<count($strCharges);$i++)
			{
				$sqlp="delete from tblServicesCharges where ServiceID='".$ServiceID[$i]."'";
				// echo $sqlp."<br>";
				ExecuteNQ($sqlp);
			 
				$sqlInsert1 = "Insert into tblServicesCharges (ServiceID, ChargeNameID, Status) values
				('".$ServiceID[$i]."', '".$strCharges[$i]."','0')";
				// echo $sqlInsert1."<br>";
				 ExecuteNQ($sqlInsert1);
			}
			
		
		
				// echo $emp."<br>";
				for($i=0;$i<count($ServiceID);$i++)
				{
					$sqlp="delete from tblEmployeesServices where ServiceID='".$ServiceID[$i]."'";
					// echo $sqlp."<br>";
					ExecuteNQ($sqlp);
				}
				for($i=0;$i<count($strTechnician);$i++)
				{
					 $sqlInsert1 = "Insert into tblEmployeesServices (EID, ServiceID,CategoryID, Status) values
					('".$strTechnician[$i]."', '".$ServiceID[$i]."','".$Category."','0')";
					ExecuteNQ($sqlInsert1);
					//echo $sqlInsert1;
				}
				for($i=0;$i<count($ServiceID);$i++)
				{
					$sqlp="delete from tblProductsServices where ServiceID='".$ServiceID[$i]."'";
				// echo $sqlp;
	  
				ExecuteNQ($sqlp);
					$sqlpt="delete from tblProductServiceCategory where ServiceID='".$ServiceID[$i]."'";
				// echo $sqlp."<br>";
				ExecuteNQ($sqlpt);
				}
				for($j=0;$j<count($ServiceID);$j++)
				{
			    for($i=0;$i<count($strProducts);$i++)
				{
					$selp=select("ProductID","tblNewProducts","ProductID='".$strProducts[$i]."'");
					// print_r($selp)."<br>";
					$ProductID1234=$selp[0]['ProductID'];
					if($ProductID1234!="")
					{
					
							
									
						$sqlInsert2 = "Insert into tblProductsServices(ProductID,ProductStockID,ServiceID, Status,CategoryID,StoreID,DateTimeStamp) values ('".$strProducts[$i]."','0', '".$ServiceID[$j]."','0','".$Category."','".$StoreID[$j]."','".$getfrom."')";
						ExecuteNQ($sqlInsert2)."<br>";
					// echo $sqlInsert2."<br>";
					}
					else
					{
						$selpT=select("*","tblNewProductStocks","ProductStockID='".$strProducts[$i]."'");
						foreach($selpT as $val)
						{
							$sqlInsert2 = "Insert into tblProductsServices(ProductID,ProductStockID, ServiceID, Status,CategoryID,StoreID,DateTimeStamp) values
							('".$val['ProductID']."','".$val['ProductStockID']."','".$ServiceID[$j]."','1','".$Category."','".$StoreID[$j]."','".$getfrom."')";
							// echo $sqlInsert2."<br>";
							// echo "Hello";
							ExecuteNQ($sqlInsert2);
							
						}
					}
					
						$sqlInsert2 = "Insert into tblProductServiceCategory(ProductID,ServiceID,StoredID,CategoryID) values('".$strProducts[$i]."','".$ServiceID[$j]."','".$StoreID[$j]."','".$Category."')";
					
					// echo $sqlInsert2."<br>";
					 // echo "Hello";
					
					   ExecuteNQ($sqlInsert2);
				
				}
				}
			
		
				////////////////////////////////////////
				foreach($_POST as $key => $val)
				{
					if($key=="step" || $key==$strMyTableID ||  $key=="ImagePath" )
					{
					
					}
					else
					{
						
						$sqlUpdate = "UPDATE $strMyTable SET ServiceName='".$ServiceName."',ServiceCost='".$ServiceCost."',Status='".$Status."' WHERE ServiceCode='$ServiceCode'";
						// $sqlUpdate = "UPDATE $strMyTable SET $key='$_POST[$key]' WHERE ServiceCode='$ServiceCode'";
						// echo $sqlUpdate;
						// die();
						ExecuteNQ($sqlUpdate);
						//echo($sqlUpdate);
					}	
				}
				if($cost!="")
				{
								$sqlUpdateTime = "UPDATE $strMyTable SET Time='$Time',ProductPrice='".$cost."',Status='".$Status."' WHERE ServiceCode='$ServiceCode'";
						
						ExecuteNQ($sqlUpdateTime);
				}
				else
				{
					$sqlUpdateTime = "UPDATE $strMyTable SET Time='$Time',ProductPrice='".$cost."',Status='".$Status."' WHERE ServiceCode='$ServiceCode'";
						
						ExecuteNQ($sqlUpdateTime);
				}
	
			
						
				die('<div class="alert alert-close alert-success">
						<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
						<div class="alert-content">
							<h4 class="alert-title">Record Updated Successfully</h4>
						</div>
					</div>');
		
                
		
				// echo "Hello";
				// die();
				/* 	$sedata="update tblServicesImages set ImagePath='".$strValidateImage1."',Priority='1',IsPrimary='1',Status=
					'0' where ServiceID='".Decode($_POST[$strMyTableID])."'";
					ExecuteNQ($sedata); */
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
                        <p>Add, Edit, Delete Employee Details</p>
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
												<li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">Add Bulk Data</a>
										</ul>
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Services Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Service Name / Service Code</th>
																<th><center>Service MRP</center></th>
															    <th>Product Price</th>
															
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Service Name / Service Code</th>
																<th><center>Service MRP</center></th>
															   <th>Product Price</th>
																<th>Status</th>
																<th>Actions</th>
															</tr>
														</tfoot>
														<tbody>

<?php
//Retrieve And Display Values in a Table
// Create connection And Write Values
$DB = Connect();

$FindStore="Select StoreID from tblAdminStore where AdminID=$strAdminID";
// echo $FindStore;
$RSf = $DB->query($FindStore);
if ($RSf->num_rows > 0) 
{
	while($rowf = $RSf->fetch_assoc())
	{
		$strStoreID = $rowf["StoreID"];
		// echo $strStoreID;
	}
}

if($strStoreID!=0)
{
	$sql = "Select * FROM $strMyTable where StoreID='$strStoreID' order by $strMyTableID desc";
	// echo "In if";
}
else
{
			
			$sql = "Select ServiceName, ServiceID, ServiceCost, Status, ServiceCode,ProductPrice FROM $strMyTable group by ServiceCode";
			// echo $sql;
			// echo "In while<br>";
			// echo $sql;

			// $sql = "Select * FROM $strMyTable order by $strMyTableID desc";
			// echo $sql."<br>";
			// $sql = "Select * FROM $strMyTable where StoreID='$strStoreID' order by $strMyTableID desc";
			// echo $sql."<br>";
			// echo $sql;
			
			
			$RS = $DB->query($sql);
			if ($RS->num_rows > 0) 
			{
				$counter = 0;

				while($row = $RS->fetch_assoc())
				{
					$counter ++;
					$strServiceID = $row["ServiceID"];
					$getUID = EncodeQ($strServiceID);
					$getUIDDelete = Encode($strServiceID);
					
					$ServiceName = $row["ServiceName"];
					$ServiceCode = $row["ServiceCode"];
					$getUIDD = EncodeQ($ServiceCode);
					$ServiceCost = $row["ServiceCost"];
					$ServiceCommission = $row["ServiceCommission"];
					$MRPLessTax = $row["MRPLessTax"];
					$DirectCost = $row["DirectCost"];
					$GMPercentage = $row["GMPercentage"];
					$GrossMargin = $row["GrossMargin"];
					$ProductPrice = $row["ProductPrice"];
					$Status = $row["Status"];
					$StoreID = $row["StoreID"];
	 
		$sep=select("*","tblServices","ServiceCode='".$ServiceCode."'");
		foreach($sep as $vap)
		{
			 $ServiceIDD[]=$vap["ServiceID"];
		}

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
										<td><b>Name:</b> <?=$ServiceName?> <br><b>Code:</b> <?=$ServiceCode?>
										<br/>  <?=$strServiceID?>
										<?php 
										if($_SERVER['REMOTE_ADDR']=="111.119.219.70")
									   {
										   $stppserty=select("distinct(CategoryID)","tblProductsServices","ServiceID='".$strServiceID."'");
										   $catid=$stppserty[0]['CategoryID'];
										   $stppq=select("CategoryName","tblCategories","CategoryID='".$catid."'");
								          echo $CategoryName=$stppq[0]['CategoryName'];
									   }
									   else
									   {
										   
									   }
										?>
										</td>
										<td><center><?=$ServiceCost?></center></td>
									 <td><?=round($ProductPrice)?></td>
										
										<td> 
<?php
												$SelectStore="Select StoreName from tblStores where StoreID='$StoreID'";
												$RSa = $DB->query($SelectStore);
												if ($RSa->num_rows > 0) 
												{
													while($rowa = $RSa->fetch_assoc())
													{
														$StoreName = $rowa["StoreName"];
													}
												}
								
								
?><?//=$StoreName?><br>Status : <?=$Status?></td>
								<td>
									<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
									<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
									<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step11','<?=$ServiceCode?>', 'Are you sure you want to delete this Service - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
									<?php 
																	}
									?>
									<a class="btn btn-link" href="UpdateServiceCost.php?uid=<?=$getUIDD?>">Edit MRP</a>
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
															</tr>
<?php
		
	
	
	// $sql = "Select * FROM $strMyTable order by $strMyTableID desc";
	// $sql = "Select Distinct(ServiceName,ServiceID,ServiceCode,ServiceCost, ServiceCommission, MRPLessTax, DirectCost,GMPercentage, GrossMargin, Status, StoreID) FROM tblServices order by ServiceID desc";
	// echo $sql;
}
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

											
												<h3 class="title-hero">Add services</h3>
												<div class="example-box-wrapper">
<script>

		function LoadValueproduct()
			{
				//alert(12233)
				valuable=[];
		var valuable = $('#Products').val();
		
		
		
	//alert(valuable)
				 $.ajax({
					type: 'POST',
					url: "calculatemargin.php",
					data: {
						id:valuable
						
					},
					success: function(response) {
						//alert(response)
						
						if($.trim(response)==1)
						{
							
						}
						else
						{
				//alert(response)
							$("#asmita1").show();
							$("#cost").val(response);
							document.getElementById("cost").required = false;
							var servicecost=$(".ServiceCost").val();
					//	alert(servicecost)
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
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$("#asmita1").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						//alert (response);
					}
				}); 
			}
				function checktype()
		{
		var type=$("#type").val();
		//alert(type)
	
	 if(type!="0")
		{
		$.ajax({
		type:"post",
		data:"type="+type,
		url:"servicesubcat.php",
		success:function(res)
		{
		//alert(res)
		var rep= $.trim(res);
			$("#prodid").show();
			$("#prodid").html("");
						$("#prodid").html("");
						$("#prodid").html(rep);
		}
		})
		}
		
		
		}
			function LoadValue()
			{
				var storeid=$("#StoreID").val();
				if(storeid!="")
				{
					$.ajax(
					{
						type:"post",
						data:"storeid="+storeid,
						url:"storecategory.php",
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
				}
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
		else if ($row["Field"]=="ServiceName")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ServiceName", "Service Name", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("ServiceName", "Service Name", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("POST", "Pedicure Normal, Menicure Normal ", $row["Field"])?>"></div>
													</div>													
<?php	
		}
		else if ($row["Field"]=="ServiceCost")
		{
?>	
												<div class="form-group" id="asmita1" style="display:none"><label class="col-sm-3 control-label">Product Price <span>*</span></label>
														<div class="col-sm-3"><input type="text" name="cost" id="cost" class="form-control " readonly/>
														</div>
												</div>		
												
<?php	
		}
		else if ($row["Field"]=="ServiceCode")
		{
?>	
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ServiceCode", "Service Code", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-3"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("ServiceCode", "Service Code", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("ServiceCode", "Pedicure001, menicure001", $row["Field"])?>"></div>
												</div>	
												<div class="form-group"><label class="col-sm-3 control-label">Service MRP<span>*</span></label>
													<div class="col-sm-3"><input type="text" name="ServiceCost" id="<?=str_replace("ServiceCost", "Cost", $row["Field"])?>" class="form-control required ServiceCost" placeholder="<?=str_replace("ServiceCost", "1000,2000", "Service MRP")?>">
													</div>
											    </div>
<?php	
		}
		
		else if ($row["Field"]=="ServiceCommission")
		{
?>	
													
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
															<select class="form-control required" id="StoreID" name="StoreID[]" multiple>
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

														
<?php	
		}
		else if ($row["Field"]=="MRPLessTax")
		{
?>	
														
<?php	
		}
		else if ($row["Field"]=="DirectCost")
		{
?>	
														
<?php	
		}
		else if ($row["Field"]=="GMPercentage")
		{
?>	
<?php	
		}
		else if ($row["Field"]=="Time")
		{
?>	
										<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Time", "Time", $row["Field"])?> <span>*</span></label>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" name="<?=$row["Field"]?>"  class="form-control required" placeholder="<?=str_replace("Time", "Time", $row["Field"])?>"/>
													<span class="input-group-addon">In (Min.) only</span>
												</div>
											</div>
										</div>	
<?php	
		}
		else if ($row["Field"]=="GrossMargin")
		{
?>	
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("GrossMargin", "Our Profit", $row["Field"])?></label>
														<div class="col-sm-3"><input name="<?=$row["Field"]?>" id="cost" class="form-control GrossMargin" placeholder="<?=str_replace("GrossMargin", "Our Profit", $row["Field"])?>" readonly /></div>
													</div>
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
			elseif($row["Field"]=="CategoryType")
			{
?>

													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("CategoryType", "Main Category Type", $row["Field"])?> <span>*</span></label>
														<div class="col-sm-4">
															<select name="<?=$row["Field"]?>" class="form-control required" onChange="checktype()" id="type">
																<option value="" Selected>-- Choose Type --</option>
																<?php  
																$seldata=select("*","tblCategories","CategoryType='1'");
																foreach($seldata as $val)
																{
?>

																<option value="<?php echo $val['CategoryID'] ?>"><?php echo $val['CategoryName'] ?></option>	
<?
}
																?>
															</select>
												
												
														</div>
													</div>
											
											
<?php
			}
			elseif($row["Field"]=="MainCategoryType")
			{
				//echo $row["Field"];
?>
												
											
<?php
			}
			elseif($row["Field"]=="ProductPrice")
			{
				
			}
		else if ($row["Field"]=="EID")
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
<!--Start Select Employee-->					




											<?											
	//Start Category Select for Product Category- added by asmita
											$sql1 = "SELECT CategoryID, CategoryName FROM tblCategories WHERE Status=0 and MainCategoryType=0";
											$RS2 = $DB->query($sql1);
											if ($RS2->num_rows > 0)
											{
?>											
													<div class="form-group"><label class="col-sm-3 control-label">Category Name<span>*</span></label>
														<div class="col-sm-4">
															<select class="form-control required" id="Categories" name="Categories" onChange="SelectProduct(this.value);">
																	<option value="" selected>--Select Category--</option>
<?
																		while($row2 = $RS2->fetch_assoc())
																		{
																			$strCategoryID = $row2["CategoryID"];
																			$strCategoryName = $row2["CategoryName"];	
?>
																			<option value="<?=$strCategoryID?>"><?=$strCategoryName?></option>
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
											  <span class="ProductCatWise" ></span>
<?php
				//End Category Select for Product Category- added by asmita
				
				
?>				
												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12">Select Technicians<span>*</span><br><span style="font-weight:light">Press Ctrl and Select for multiple Selection</span></label>
													<div class="col-sm-4">
												<!--	<input type="button" id="select_all" name="select_all" value="Select All" OnClick="select();">-->
<?php
														$sql = "SELECT EID, EmployeeName FROM tblEmployees WHERE Status='0'";
														$RS2 = $DB->query($sql);
														if ($RS2->num_rows > 0)
														{
?>
															<select class="form-control required" name="Technician[]" id="EMP" multiple style="height:200pt;">
																<option value="" selected>--SELECT SET--</option>
	<?
																	while($row2 = $RS2->fetch_assoc())
																	{
																		$EID = $row2["EID"];
																		$EmployeeName = $row2["EmployeeName"];	
	?>
																		<option value="<?=$EID?>"><?=$EmployeeName?></option>
	<?php
																	}
	?>
															</select>
<?php
														}
														else
														{
															echo "Technicians are not added. <a href='ManageEmployee.php' target='chargenames'>Click here to add</a>";
														}
?>
													</div>
												</div>
<!--End Select Employee-->	
<!--Start Select Products-->	


<!--End Select Products-->	
<!--Start Select Charges-->	
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


<!--End Select Charges-->
														<!--<div class="form-group">

																<label class="control-label col-md-3 col-sm-3 col-xs-12">Secondary Image<br><small>(multiple can be selected)</small>

																</label>

																<div class="col-md-6 col-sm-6 col-xs-12">

																	<input class="file_upload" type="file" data-source="SecondaryImage" name="SecondaryImage" id="fileSelect" multiple>

																</div>

															</div>-->
														
														
													
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
											<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="data-tab">
										
												<?php require_once "ExcelBulkUpload1.php"; ?>
										
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

								
									<h3 class="title-hero">Edit Service Details</h3>
									<div class="example-box-wrapper">
						
		
										
<?php

 $strID = DecodeQ(Filter($_GET["uid"]));
$DB = Connect();
$sql = "select * FROM $strMyTable where $strMyTableID = '$strID'";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{	
		$ServiceID=$row["ServiceID"];
		$ServiceName=$row["ServiceName"];
		$Time=$row["Time"];
      
		$TimeConversion = date('s', strtotime($Time));
		// echo $start_date;

		$ServiceCode=$row["ServiceCode"];
		$ServiceCost=$row["ServiceCost"];
		$ServiceCommission=$row["ServiceCommission"];
		$MRPLessTax=$row["MRPLessTax"];
		$DirectCost=$row["DirectCost"];
		$GMPercentage=$row["GMPercentage"];
		$GrossMargin=$row["GrossMargin"];
		$Status=$row["Status"];
		$StoreID=$row["StoreID"];
		$EID=$row["EID"];
		$CategoryType=$row["CategoryType"];
		$MainCategoryType=$row["MainCategoryType"];
		$seldata=select("CategoryType","tblCategories","CategoryID='".$CategoryType."'");
		$cattype=$seldata[0]['CategoryType'];
		$seldatap=select("CategoryType","tblCategories","CategoryID='".$MainCategoryType."'");
		$subcattype=$seldatap[0]['CategoryType'];
		// echo $EID;
		 
		$sep=select("*","tblServices","ServiceCode='".$ServiceCode."'");
		foreach($sep as $vap)
		{
			 $ServiceIDD[]=$vap["ServiceID"];
		}
		?>
	<script type="text/javascript">
	
	
	
		$(document).ready(function()
		{
				$("#catid").show();
				$("#prodid").show();
				$("#prodidd").show();
				
		});
		function LoadValueproduct()
		{
			valuable=[];
			var valuable = $('#prodidd').val();
	      // alert(valuable)
				$.ajax(
				{
					type: 'POST',
					url: "calculatemargin1.php",
					data: {
						id:valuable
						
					},
					success: function(response) 
					{
						//alert(response)
						
						if($.trim(response)==1)
						{
							
						}
						else
						{
						//alert(response)
							$("#asmita2").show();
							$("#asmita1").hide();
							$(".GrossMargin").val(response);
					
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
		function checktype()
		{
			var type=$("#type").val();
			// alert(type)
	
			if(type!="0")
			{
				$.ajax({
					type:"post",
					data:"type="+type,
					url:"servicesubcat.php",
					success:function(res)
					{
						// alert(res)
						var rep= $.trim(res);
						//$("#catid").show();
						$("#prodid").html("");
						$("#prodid").html("");
						$("#prodid").html(rep);
			
					}
			
				})
			}
		}
		function LoadValue()
		{
			var storeid=$("#StoreID").val();
			if(storeid!="")
			{
			   $.ajax({
					type:"post",
					data:"storeid="+storeid,
					url:"storecategory.php",
					success:function(res)
					{
						//alert(res)
						var rep = $.trim(res);
						$("#prodid").show();
						$("#prodid").html("");
						$("#prodid").html("");
						$("#prodid").html(rep);
	
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
											<input type="hidden" name="<?=$key?>" value="<?=Encode($strID)?>">	

<?php
			}
			elseif($key=="ServiceCode")
			{
?>	
										
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("EmployeeCode", "Employee Code", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input class="form-control" value="<?=$row[$key]?>" name="ServiceCode" readonly></div>
											</div>
											<div class="form-group"><label class="col-sm-3 control-label">MRP<span>*</span></label>
												<div class="col-sm-4"><input type="text" name="ServiceCost" class="form-control required ServiceCost" placeholder="<?//=str_replace("ServiceCost", "ServiceCost", $key)?>" value="<?=$ServiceCost?>"></div>
											</div>
											
											<span id="catid">
											<div class="form-group">
												<label class="col-sm-3 control-label">Select Category<span>*</span></label>
													<div class="col-sm-4">	
															
														<select class="form-control required" name="category"  id="type" onChange="checktype()">
															<option value="" >--SELECT Category--</option>
<?php 
																$DB = Connect();

																$selp=select("distinct(CategoryID)","tblProductsServices","ServiceID='$ServiceID'");
																													
																foreach($selp as $valp)
																{
																	$cat=array_unique($valp);
																	$catid[]=$cat['CategoryID'];
																}
																// print_r($catid);
																												
																$sep=select("*","tblCategories","CategoryType='1'");
																foreach($sep as $valpp)
																{
																	$catidd=$valpp['CategoryID'];
																	$catnamed=$valpp['CategoryName'];
																	
																	if(in_array("$catidd", $catid))
																	{
?>																			
																		<option selected value="<?=$catidd?>"><?=$catnamed?></option>;
<?php																			
																	}
																	else
																	{
?>																		
																		<option  value="<?=$catidd?>"><?=$catnamed?></option>
<?php																		
																	}
																}														
															$DB->close();																
?>
														</select>
													</div>
											</div>
											</span>
											<span id="prodid">
											<div class="form-group">
												<label class="col-sm-3 control-label">Select Products<span>*</span></label>
													<div class="col-sm-4">	
													
<?php	
$DB = Connect();
//print_r($ServiceIDD);
for($j=0;$j<count($ServiceIDD);$j++)
{
	//echo 124;
$SelectCateforProd="select * from tblProductsServices where ServiceID='".$ServiceIDD[$j]."'";
//echo $SelectCateforProd;
// echo $SelectCateforProd."<br>";
															$RScat = $DB->query($SelectCateforProd);
															if ($RScat->num_rows > 0)
															{
																while($rowcat = $RScat->fetch_assoc())
																{
																	$catCategoryID = $rowcat["CategoryID"];
																	$prodid[]=$rowcat['ProductID'];
																	// echo $catCategoryID;
																}
															}
}
													
?>
														<select class="form-control " name="Products[]" multiple style="height:200pt" id="prodidd"  onChange="LoadValueproduct();" >
														<option value="" >--SELECT Products--</option>
<?php 
																$SelectPName="Select * from tblNewProducts where Status='0'";
															
																$RSPname = $DB->query($SelectPName);
																if ($RSPname->num_rows > 0) 
																{
																	while($rowPName = $RSPname->fetch_assoc())
																	{
																		$PnameProductName = $rowPName["ProductName"];
																		$prodidd=$rowPName['ProductID'];
																		if (in_array("$prodidd", $prodid))
																		{
																			$selppt=select("*","tblNewProducts","ProductID='".$prodidd."'");
																			$ProductName=$selppt[0]['ProductName'];
																			$prr=$selppt[0]['ProductID'];
																			
																			
																			?>
																				<option selected value="<?=$prr?>"><?=$ProductName?></option>
																			<?  
																		}
																		else
																		{
																			?>
																				<option  value="<?=$prodidd?>"><?=$PnameProductName?></option>
																			<? 
																		}
																	}
																}
															
														
?>
														</select>
													</div>
											</div>
											 
                                          </span>
<?php
			}
			elseif($key=="ServiceName")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ServiceName", "Service Name", $key)?> <span>*</span></label>
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("ServiceName", "Service Name", $key)?>" value="<?=$ServiceName?>"></div>
											</div>
<?php
			}
		elseif($key=="ProductPrice")
			{
				
			}
			elseif($key=="ServiceCost")
			{
				
			for($j=0;$j<count($ServiceIDD);$j++)
{
	//echo 124;
$SelectCateforProd="select * from tblProductServiceCategory where ServiceID='".$ServiceIDD[$j]."'";
//echo $SelectCateforProd;
// echo $SelectCateforProd."<br>";
															$RScat = $DB->query($SelectCateforProd);
															if ($RScat->num_rows > 0)
															{
																while($rowcat = $RScat->fetch_assoc())
																{
																	$catCategoryID = $rowcat["CategoryID"];
																	$prodid[]=$rowcat['ProductID'];
																	// echo $catCategoryID;
																}
															}
}
		
																// $prodname=$valpp['ProductName'];
																$SelectPName="Select * from tblNewProducts where Status='0'";
																$RSPname = $DB->query($SelectPName);
																if ($RSPname->num_rows > 0) 
																{
																	while($rowPName = $RSPname->fetch_assoc())
																	{
																		$PnameProductName = $rowPName["ProductName"];
																		$prodidd = $rowPName["ProductID"];
																		if (in_array("$prodidd", $prodid))
																		{
																			$test[]=$prodidd;
																		}
																	}
																}
																		for($i=0;$i<count($test);$i++)
                                                                              {
																					$sqlp = select("count(*),HasVariation","tblNewProducts","ProductID='".$test[$i]."'");
	//print_r($sqlp);
	$count=$sqlp[0]['count(*)'];
    $variation=$sqlp[0]['HasVariation'];
	if($count>0)
	{
				$sql = select("ProductMRP,PerQtyServe","tblNewProducts","ProductID='".$test[$i]."'");
			 $amounts=$sql[0]['ProductMRP'];
			  $qty=$sql[0]['PerQtyServe'];
			$amount=$amounts/$qty;
			
		
	
	}
	$totalamount=$totalamount+$amount;
$total=$totalamount;
					
								//$total=$total+$totalt;												 
					}
			
				?>
								 <div class="form-group" id="asmita1" ><label class="col-sm-3 control-label">Product Price <span>*</span></label>
														<div class="col-sm-3"><input type="text" name="cost" id="cost" class="form-control " value="<?=round($total)?>" readonly/>
														</div>
												</div>
										
								<?php
							
																
							
										
													
?>
 
													<div class="form-group" id="asmita2" style="display:none"><label class="col-sm-3 control-label">Product Price <span>*</span></label>
														<div class="col-sm-3"><input type="text"  name="costt" id="costt" class="form-control GrossMargin"  readonly />
														</div>
												</div>
<?php
			}
			elseif($key=="Time")
			{
				
?>
										<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Time", "Time", $key)?> <span>*</span></label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" name="<?=$key?>" class="form-control required" placeholder="<?=str_replace("GrossMargin", "Time", $key)?>" value="<?=$row[$key]?>">
													<span class="input-group-addon">In (Min.) only</span>
												</div>
											</div>
										</div>	
<?php
			}
			elseif($key=="ServiceCommission")
			{
?>

											
<?php
			}
			elseif($key=="MRPLessTax")
			{
?>

											
<?php
			}
			elseif($key=="DirectCost")
			{
?>

											
<?php
			}
			elseif($key=="GMPercentage")
			{
?>

											
<?php
			}
			elseif($key=="StoreID")
			{
			
								
			}
			elseif($key=="CategoryType")
			{
?>
<?php
			}
			elseif($key=="MainCategoryType")
			{
?>
<?php
			}
			elseif($key=="GrossMargin")
			{
?>

											<!--<div class="form-group"><label class="col-sm-3 control-label"><?//=str_replace("GrossMargin", "Previous Product Cost", $key)?> <span>*</span></label>
												<div class="col-sm-4"><input type="text" name="<?//=$key?>" id="cost" class="form-control " placeholder="<?//=str_replace("GrossMargin", "Product Cost", $key)?>" value="<?//=$GrossMargin?>" Readonly ></div>
											</div>	-->										


<?php
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
												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12">Select Technicians<span>*</span><br><span style="font-weight:light">Press Ctrl and Select for multiple Selection</span></label>
													<div class="col-md-3 col-sm-3 col-xs-6">
<?php
														
?>
															<select class="form-control required" name="Technician[]" multiple          style="height:200pt;">
																<option value="" >--SELECT EMP--</option>
<?
for($j=0;$j<count($ServiceIDD);$j++)
{
																	$selp=select("EID","tblEmployeesServices","ServiceID='$ServiceIDD[$j]'");
																	foreach($selp as $empd)
																	{
																		$empEID[]=$empd['EID'];
																		/* $empdata=array_unique($empd);
																		$empEID[]=$empdata['EID']; */
																	}
}													
																	
																
																	$seldata=select("*"," tblEmployees","Status=0");
																	foreach($seldata as $selEMP)
																	{
																		$strEID=$selEMP['EID'];
																		$strEmployeeName=$selEMP['EmployeeName'];
																		if(in_array("$strEID", $empEID))
																		{
?>
																			<option selected value="<?=$strEID?>"><?=$strEmployeeName?><?=$strEID?></option>
<?  
																		}
																		else
																		{
?>
																			<option  value="<?=$strEID?>"><?=$strEmployeeName?></option><?=$strEID?>
<?  
																		}
																	}
?>
<?php
?>
															</select>
<?php
?>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3 col-sm-3 col-xs-12">Select Charges<span>*</span><br><span style="font-weight:light">Press Ctrl and Select for multiple Charges</span></label>
													<div class="col-md-3 col-sm-3 col-xs-6 load_charges">
<?php

?>
															<select class="form-control required" name="Charges[]" multiple  style="height:100pt;">
																<option value="" >--SELECT Charges--</option>
<?
																	$selpcharges=select("ChargeNameID","tblServicesCharges","ServiceID='$ServiceID '");
																																
																	foreach($selpcharges as $selectedcharges)
																	{
																		$chargedata=array_unique($selectedcharges);
																		$chargeselect[]=$chargedata['ChargeNameID'];
																	}
																	// print_r($chargeselect);
																	
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
																				if(in_array("$strcharge", $chargeselect))
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
<?php
?>
															</select>
<?php
?>
													</div>
												</div>
<?php												
												
				
			
?>
											


<!--End Select Charges-->



														
												

										
<!--End Product Edit-->
											
											
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