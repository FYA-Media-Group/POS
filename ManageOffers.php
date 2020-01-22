<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Offer Management| Nailspa";
	$strDisplayTitle = "Manage Offers for Nailspa";
	$strMenuID = "3";
	$strMyTable = "tblOffers";
	$strMyTableID = "OfferID";
	$strMyField = "OfferCode";
	$strMyActionPage = "ManageOffers.php";
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
		$TagID = $_POST["OfferID"];
		$strStep = Filter($_POST["step"]);
		if($strStep=="add")
		{	
			
			$strValidateImage1 = trim(ValidateImageFile($_FILES, "PrimaryImage"));
				//print_r($_FILES);
               
				// #######################
				
				$strOfferName = Filter($_POST["OfferName"]);
				$strOfferDescription = Filter($_POST["OfferDescription"]);
				$strImagePath= $_POST["ImagePath"];		
				// echo $strImagePath;				
				$strOfferDateFrom = $_POST["OfferDateFrom"];
				$strOfferDateTo = $_POST["OfferDateTo"];
			    
				$strOfferDateFrom1 = date("Y-m-d", strtotime($strOfferDateFrom));
				$strOfferDateTo1 = date("Y-m-d", strtotime($strOfferDateTo));
				$strStoreID = $_POST["StoreID"];
				$strServiceID = $_POST["ServiceID"];
				$BaseAmount = Filter($_POST["BaseAmount"]);
				$Type = $_POST["Type"];
				$TypeAmount = Filter($_POST["TypeAmount"]);
				$ServiceAmount = Filter($_POST["ServiceAmount"]);
				$OfferAmount = Filter($_POST["OfferAmount"]);
				$stores=implode(",",$strStoreID);
				$service=implode(",",$strServiceID);
				$strStatus = Filter($_POST["Status"]);
				$offercode = Filter($_POST["OfferCode"]);
				$category=$_POST["category"];
				$categorys=implode(",",$category);
					for($j=0;$j<count($strStoreID);$j++)
					{
						for($i=0;$i<count($strServiceID);$i++)
						{
							$serde=explode("#",$strServiceID[$i]);
							
							$servicecod=$serde[1];
							$selptr=select("DISTINCT(ServiceID)","tblServices","ServiceCode='".$servicecod."' and StoreID='".$strStoreID[$j]."'");
						
							$serviceidd[]=$selptr[0]['ServiceID'];
							
							
							
							//$sqlUpdate2 = "update $strMyTable set ServiceID='".$serviceed."' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
						 //  ExecuteNQ($sqlUpdate2);
						}
					}
					$serviceed=implode(",",$serviceidd);
					
				
	
				$DB = Connect();
						$sql = "SELECT $strMyTableID FROM $strMyTable WHERE $strMyField='$_POST[$strMyField]'";
					$RS = $DB->query($sql);
					if ($RS->num_rows > 0) 
					{
						$DB->close();
						die('<div class="alert alert-warning alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>The Offer Code already exists in the system.</strong>
							</div>');
						die("");
					}
					else
					{
						$sqlInsert = "Insert into $strMyTable (OfferName, OfferDescription, ImagePath, OfferDateFrom, OfferDateTo, StoreID, ServiceID, Status,BaseAmount,Type,TypeAmount,ServiceAmount,OfferAmount,OfferCode,OfferCategory) values
						('".$strOfferName."', '".$strOfferDescription."', '".$strImageUploadPath."', '".$strOfferDateFrom1."', '".$strOfferDateTo1."', '".$stores."' , '".$serviceed."', '".$strStatus."','".$BaseAmount."','".$Type."','".$TypeAmount."','".$ServiceAmount."','".$OfferAmount."','".$offercode."','".$categorys."')";
						// echo $sqlInsert;
						//echo $sqlInsert."<br>";
						
						$DB->query($sqlInsert);
						if($DB->query($sqlInsert) === TRUE) 
							{
								$offfid = $DB->insert_id;		//last id of tblMarktingImg insert
								// echo $last_id3."<br>";
							}
							else
							{
								echo "Error: " . $sqlInsert . "<br>" . $conn->error;
							}	
						
						if(isset($_FILES["PrimaryImage"]["error"]))
						{
							
						// echo "In if<br>";
							$strValidateImage1 = trim(ValidateImageFile($_FILES, "PrimaryImage"));
							
							if($strValidateImage1=="Saved successfully")
							{
								//echo 1245;
							
								// As the image is valid first select the imagename for previous image
								// echo "In if<br>";
								$DB = Connect();
								$sql = "Select ImagePath FROM tblOffers where OfferID='".$offfid."' and ImagePath!=''";
								
								
								$RS = $DB->query($sql);
								if ($RS->num_rows > 0) 
								{
									while($row = $RS->fetch_assoc())
									{
										$strOldImageURL = $row["ImagePath"];	
									}
									
									$file = $strOldImageURL;
									unlink($file);
									
									/* $filepath = 'imageupload/images';
									$filename1 = $_FILES["ImagePath"]["name"];
									
									$uploadFilename1 = UniqueStamp().$filename1;		
									$strImageUploadPath1 = $filepath."/".$uploadFilename1; */
									

									$target_dir = "OfferImages/";
								$target_file = $target_dir . basename($_FILES["PrimaryImage"]["name"]);
								$uploadOk = 1;
								$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
								// Check if image file is a actual image or fake image
							
									$check = getimagesize($_FILES["PrimaryImage"]["tmp_name"]);
									if($check !== false) {
										echo "File is an image - " . $check["mime"] . ".";
										$uploadOk = 1;
									} else {
										echo "File is not an image.";
										$uploadOk = 0;
									}
									
									
									if (file_exists($target_file)) {
											echo "Sorry, file already exists.";
											$uploadOk = 0;
										}
										// Check file size
										if ($_FILES["PrimaryImage"]["size"] > 500000) {
											echo "Sorry, your file is too large.";
											$uploadOk = 0;
										}
										// Allow certain file formats
										if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
										&& $imageFileType != "gif" ) {
											echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
											$uploadOk = 0;
										}
										// Check if $uploadOk is set to 0 by an error
										if ($uploadOk == 0) {
											echo "Sorry, your file was not uploaded.";
										// if everything is ok, try to upload file
										} else {
											if (move_uploaded_file($_FILES["PrimaryImage"]["tmp_name"], $target_file)) {
											 $sqlUpdate3 = "UPDATE tblOffers SET ImagePath='".$target_file."' WHERE OfferID='".$offfid."'";
									         ExecuteNQ($sqlUpdate3);
											// echo $sqlUpdate3;
											/*  $sqlUpdate3 = "UPDATE tblAdmin SET ProfilePath='".$target_file."' WHERE AdminID='".$strMyTableID."'";
											 ExecuteNQ($sqlUpdate3); */
											
											
												//echo "The file ". basename( $_FILES["PrimaryImage"]["name"]). " has been uploaded.";
											} else {
												echo "Sorry, there was an error uploading your file.";
											}
										}
									// #######################
									
									
								     //echo $sqlUpdate3;
														
								}
								else
								{
									// echo "In else<br>";
									$target_dir = "OfferImages/";
								$target_file = $target_dir . basename($_FILES["PrimaryImage"]["name"]);
								$uploadOk = 1;
								$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
								// Check if image file is a actual image or fake image
							
									$check = getimagesize($_FILES["PrimaryImage"]["tmp_name"]);
									if($check !== false) {
										echo "File is an image - " . $check["mime"] . ".";
										$uploadOk = 1;
									} else {
										echo "File is not an image.";
										$uploadOk = 0;
									}
									
									
									if (file_exists($target_file)) {
											echo "Sorry, file already exists.";
											$uploadOk = 0;
										}
										// Check file size
										if ($_FILES["PrimaryImage"]["size"] > 500000) {
											echo "Sorry, your file is too large.";
											$uploadOk = 0;
										}
										// Allow certain file formats
										if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
										&& $imageFileType != "gif" ) {
											echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
											$uploadOk = 0;
										}
										// Check if $uploadOk is set to 0 by an error
										if ($uploadOk == 0) {
											echo "Sorry, your file was not uploaded.";
										// if everything is ok, try to upload file
										} else {
											if (move_uploaded_file($_FILES["PrimaryImage"]["tmp_name"], $target_file)) {
											 $sqlUpdate3 = "UPDATE tblOffers SET ImagePath='".$target_file."' WHERE OfferID='".$offfid."'";
											 //echo $sqlUpdate3;
									         ExecuteNQ($sqlUpdate3);
											/*  $sqlUpdate3 = "UPDATE tblAdmin SET ProfilePath='".$target_file."' WHERE AdminID='".$strMyTableID."'";
											 ExecuteNQ($sqlUpdate3); */
									
											
												//echo "The file ". basename( $_FILES["PrimaryImage"]["name"]). " has been uploaded.";
											} else {
												echo "Sorry, there was an error uploading your file.";
											}
										}
								
									
									
								}	
								
								echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
										</button>
										<strong>Primary Image Added Successfully</strong>
										</div>');
							}
							else
							{
								die($strValidateImage1);
							}
						}
						// die();
						$DB->Close();
						die('<div class="alert alert-close alert-success">
								<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
								<div class="alert-content">
									<h4 class="alert-title">Record Added Successfully</h4>
									<p>Information message box using the color scheme.</p>
								</div>
							</div>');
			         }
		}
			
		if($strStep=="edit")
		{
			
			foreach ($_POST["ServiceID"] AS $key1 => $val1)
			{
				if(IsNull($sqlColumnValues1))
				{
					$sqlColumn1 = $key1;
					$sqlColumnValues1 = $val1;
				}
				else
				{
					$sqlColumn1 = $sqlColumn1.",".$key1;
					$sqlColumnValues1 = $sqlColumnValues1.", ".$val1;
				}
			}
			//$_POST["ServiceID"] = $sqlColumnValues1;
			
		           // print_r($_FILES);
			        $DB = Connect();
					$strOfferName = Filter($_POST["OfferName"]);
					$strOfferDescription = Filter($_POST["OfferDescription"]);
					$strImagePath= $_POST["ImagePath"];		
					// echo $strImagePath;				
					$strOfferDateFrom = $_POST["OfferDateFrom"];
					$strOfferDateTo = $_POST["OfferDateTo"];
					
					$strOfferDateFrom1 = date("Y-m-d", strtotime($strOfferDateFrom));
					$strOfferDateTo1 = date("Y-m-d", strtotime($strOfferDateTo));
					$strStoreID = $_POST["StoreID"];
					//$strServiceID = $_POST["ServiceID"];
					$BaseAmount = Filter($_POST["BaseAmount"]);
					$Type = $_POST["Type"];
					$TypeAmount = Filter($_POST["TypeAmount"]);
					$ServiceAmount = Filter($_POST["ServiceAmount"]);
					$OfferAmount = Filter($_POST["OfferAmount"]);
					$stores=$_POST['StoreID'];
					$storesd=implode(",",$stores);
					$servicee=$_POST['ServiceID'];
					for($j=0;$j<count($stores);$j++)
					{
						for($i=0;$i<count($servicee);$i++)
						{
							$serde=explode("#",$servicee[$i]);
							
							$servicecod=$serde[1];
							$selptr=select("DISTINCT(ServiceID)","tblServices","ServiceCode='".$servicecod."' and StoreID='".$stores[$j]."'");
						
							$serviceidd[]=$selptr[0]['ServiceID'];
							
							
							
							//$sqlUpdate2 = "update $strMyTable set ServiceID='".$serviceed."' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
						 //  ExecuteNQ($sqlUpdate2);
						}
					}
					$serviceed=implode(",",$serviceidd);
					
				
					
					$CategoryIDd=$_POST['CategoryID'];
					$strStatus = Filter($_POST["Status"]);
					$offercode = Filter($_POST["OfferCode"]);
				
					$CategoryIDdp=implode(",",$CategoryIDd);
			foreach($_POST as $key => $val)
			{
				if($key=="step" || $key==$strMyTableID || $key=="ImagePath")
				{
				
				}
				else
				{
					$sqlUpdate = "update $strMyTable set $key='$_POST[$key]' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					ExecuteNQ($sqlUpdate);
					//echo "$sqlUpdate";
					// $sqlUpdate1 = "update $strMyTable set $key='$_POST[$key]' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
					// ExecuteNQ($sqlUpdate1);
					
				}
			}
			
			$sqlUpdate1 = "update $strMyTable set ServiceID='".$serviceed."',StoreID='".$storesd."',OfferCategory='".$CategoryIDdp."',OfferDescription='".$strOfferDescription."',OfferDateFrom='".$strOfferDateFrom1."', OfferDateTo='".$strOfferDateTo1."', StoreID='".$storesd."',BaseAmount='".$BaseAmount."',Type='".$Type."',TypeAmount='".$TypeAmount."' where $strMyTableID='".Decode($_POST[$strMyTableID])."'";
			ExecuteNQ($sqlUpdate1);
			$DB->close();
			
			
			
				//$filepath = 'OfferImages/';	

						if(isset($_FILES["PrimaryImage"]["error"]))
						{
							
						// echo "In if<br>";
							$strValidateImage1 = trim(ValidateImageFile($_FILES, "PrimaryImage"));
							
							if($strValidateImage1=="Saved successfully")
							{
								//echo 1245;
							
								// As the image is valid first select the imagename for previous image
								// echo "In if<br>";
								$DB = Connect();
								$sql = "Select ImagePath FROM tblOffers where OfferID='".Decode($_POST[$strMyTableID])."' and ImagePath!=''";
								
								
								$RS = $DB->query($sql);
								if ($RS->num_rows > 0) 
								{
									while($row = $RS->fetch_assoc())
									{
										$strOldImageURL = $row["ImagePath"];	
									}
									
									$file = $strOldImageURL;
									unlink($file);
									
									/* $filepath = 'imageupload/images';
									$filename1 = $_FILES["ImagePath"]["name"];
									
									$uploadFilename1 = UniqueStamp().$filename1;		
									$strImageUploadPath1 = $filepath."/".$uploadFilename1; */
									

									$target_dir = "OfferImages/";
								$target_file = $target_dir . basename($_FILES["PrimaryImage"]["name"]);
								$uploadOk = 1;
								$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
								// Check if image file is a actual image or fake image
							
									$check = getimagesize($_FILES["PrimaryImage"]["tmp_name"]);
									if($check !== false) {
										echo "File is an image - " . $check["mime"] . ".";
										$uploadOk = 1;
									} else {
										echo "File is not an image.";
										$uploadOk = 0;
									}
									
									
									if (file_exists($target_file)) {
											echo "Sorry, file already exists.";
											$uploadOk = 0;
										}
										// Check file size
										if ($_FILES["PrimaryImage"]["size"] > 500000) {
											echo "Sorry, your file is too large.";
											$uploadOk = 0;
										}
										// Allow certain file formats
										if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
										&& $imageFileType != "gif" ) {
											echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
											$uploadOk = 0;
										}
										// Check if $uploadOk is set to 0 by an error
										if ($uploadOk == 0) {
											echo "Sorry, your file was not uploaded.";
										// if everything is ok, try to upload file
										} else {
											if (move_uploaded_file($_FILES["PrimaryImage"]["tmp_name"], $target_file)) {
											 $sqlUpdate3 = "UPDATE tblOffers SET ImagePath='".$target_file."' WHERE OfferID='".Decode($_POST[$strMyTableID])."'";
									         ExecuteNQ($sqlUpdate3);
											// echo $sqlUpdate3;
											/*  $sqlUpdate3 = "UPDATE tblAdmin SET ProfilePath='".$target_file."' WHERE AdminID='".$strMyTableID."'";
											 ExecuteNQ($sqlUpdate3); */
											
											
												//echo "The file ". basename( $_FILES["PrimaryImage"]["name"]). " has been uploaded.";
											} else {
												echo "Sorry, there was an error uploading your file.";
											}
										}
									// #######################
									
									
								     //echo $sqlUpdate3;
														
								}
								else
								{
									// echo "In else<br>";
									$target_dir = "OfferImages/";
								$target_file = $target_dir . basename($_FILES["PrimaryImage"]["name"]);
								$uploadOk = 1;
								$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
								// Check if image file is a actual image or fake image
							
									$check = getimagesize($_FILES["PrimaryImage"]["tmp_name"]);
									if($check !== false) {
										echo "File is an image - " . $check["mime"] . ".";
										$uploadOk = 1;
									} else {
										echo "File is not an image.";
										$uploadOk = 0;
									}
									
									
									if (file_exists($target_file)) {
											echo "Sorry, file already exists.";
											$uploadOk = 0;
										}
										// Check file size
										if ($_FILES["PrimaryImage"]["size"] > 500000) {
											echo "Sorry, your file is too large.";
											$uploadOk = 0;
										}
										// Allow certain file formats
										if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
										&& $imageFileType != "gif" ) {
											echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
											$uploadOk = 0;
										}
										// Check if $uploadOk is set to 0 by an error
										if ($uploadOk == 0) {
											echo "Sorry, your file was not uploaded.";
										// if everything is ok, try to upload file
										} else {
											if (move_uploaded_file($_FILES["PrimaryImage"]["tmp_name"], $target_file)) {
											 $sqlUpdate3 = "UPDATE tblOffers SET ImagePath='".$target_file."' WHERE OfferID='".Decode($_POST[$strMyTableID])."'";
											 //echo $sqlUpdate3;
									         ExecuteNQ($sqlUpdate3);
											/*  $sqlUpdate3 = "UPDATE tblAdmin SET ProfilePath='".$target_file."' WHERE AdminID='".$strMyTableID."'";
											 ExecuteNQ($sqlUpdate3); */
									
											
												//echo "The file ". basename( $_FILES["PrimaryImage"]["name"]). " has been uploaded.";
											} else {
												echo "Sorry, there was an error uploading your file.";
											}
										}
								
									
									
								}	
								
								echo('<div class="alert alert-success alert-dismissible fade in" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
										</button>
										<strong>Primary Image Added Successfully</strong>
										</div>');
							}
							else
							{
								die($strValidateImage1);
							}
						}
				
			die('<div class="alert alert-close alert-success">
					<div class="bg-green alert-icon"><i class="glyph-icon icon-check"></i></div>
					<div class="alert-content">
						<h4 class="alert-title">Record Updated Successfully</h4>
					</div>
				</div>');
		}
		die();
	}	
?>
<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
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
                        <p>Add, edit, delete POST</p>
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
												<h3 class="title-hero">List of Offers | Nailspa</h3>
												<div class="example-box-wrapper">
													<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
														<thead>
															<tr>
															
																<th>Offer Name</th>
																<th>Date & Time</th>
															    <th>Status</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																
																<th>Offer Name</th>
																<th>Date & Time</th>
															    <th>Status</th>
																<th>Actions</th>
															</tr>
														</tfoot>
											<tbody>
<?php
// Create connection And Write Values
$DB = Connect();
$sql = "Select * FROM $strMyTable order by OfferID desc";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$strOfferID = $row["OfferID"];
		$getUID = EncodeQ($strOfferID);
		$getUIDDelete = Encode($strOfferID);
		$OfferName = $row["OfferName"];
		$OfferDateFrom = $row["OfferDateFrom"];
		$OfferDateTo = $row["OfferDateTo"];
		$Status = $row["Status"];
		
		if($Status=="0")
		{
			$Status = "Live";
		}
		else
		{
			$Status = "Offline";
		}
		
		
		if($AdminType=="0")
		{
			$AdminType = "<font color='Purple'><b>Super Admin</b></font>";
		}
		else
		{
			$AdminType = "<font color='Red'><b>Admin</b></font>";
		}
?>	
												<tr id="my_data_tr_<?=$counter?>">
													<td><?=$OfferName?></td>
													<td><b>From :</b> <?=$OfferDateFrom?> <br><b>To :</b> <?=$OfferDateTo?></td>
													<td><?=$Status?></td>
													<td>
														<a class="btn btn-link" href="<?=$strMyActionPage?>?uid=<?=$getUID?>">Edit</a>
														<?php
																	if($strAdminRoleID=="36")
                                                                    {
																		
																		?>
														<a class="btn btn-link font-red" font-redhref="javascript:;" onclick="DeleteData('Step24','<?=$getUIDDelete?>', 'Are you sure you want to delete this Membership - <?=$AdminFullName?>?','my_data_tr_<?=$counter?>');">Delete</a>
														<?php 
																	}
														?>
														
														<br>
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
												</tr>
<?php
}
$DB->close();
?>
<!--TAB 2 START-->											
	                                                           
											</tbody>
													</table>
												</div>
											</div>
										</div>
										
										<div id="normal-tabs-2">
										
											<div class="panel-body">
											
												<form role="form" enctype="multipart/form-data" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '','','', '.file_upload'); return false;">
											
												<span class="result_message">&nbsp; <br>
												</span>
											
												<input type="hidden" name="step" value="add">

													<h3 class="title-hero">New Offer</h3>
													<div class="example-box-wrapper">
<script>
$(function () {
    $("#OfferDateTo").datepicker({ minDate: 0 });
	 $("#OfferDateFrom").datepicker({ minDate: 0 });
});
	function LoadValue()
            {                
				//alert (OptionValue);
				var OptionValue=$("#CategoryID").val();
				
				$.ajax({
					type: 'POST',
					url: "GetServicesStoreWise1.php",
					data: {
						id:OptionValue
						
					},
					// alert (id);
					success: function(response) {
						$(".load_charges").html(response);
						// alert (response);
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$(".load_charges").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						//alert (response);
					}
				});

            }
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
		url:"servicecat.php",
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
		
		
		}
		/* function LoadValueasmita()
	{
		//alert(1324)
		valuable=[];
		var valuable = $('#Services').val();
		//alert(valuable)
		var store = $('#StoreID').val();
		//alert(store)
		var baseamount = $('#BaseAmount').val();
		//alert(baseamount)
		var type = $('#Type').val();
		//alert(type)
		var typeamt = $('#TypeAmount').val();
		
		//alert(typeamt)
		//alert(store)
			  $.ajax({
					type: 'POST',
					url: "calculateofferamount.php",
					data: {
						id:valuable,
						stored:store,
						baseamount:baseamount,
						type:type,
						typeamt:typeamt
						
					},
					success: function(response) {
						result=[];
						//alert($.trim(response))
						var res=$.trim(response);
						var result = res.split("#");
						//alert(result[0])
						$("#asmita1").show();
					$(".cost").val(result[0]);
					$("#asmita2").show();
					$(".offercost").val(result[1]);
							
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						//$("#asmita1").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						//alert (response);
					}
				});  
	} */
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
	
		elseif($row["Field"]=="ImagePath")
		{
?>											
											<!--<div class="form-group"><label class="col-sm-3 control-label"><?//=str_replace("ImagePath", "Image", $row["Field"])?></label>
												<div class="col-sm-4">
													<input type="file" class="form-control imageupload" data-source="ImagePath">
												</div>
											</div>-->
<?php
		}
		elseif($row["Field"]=="OfferCategory")
		{
?>											
											
<?php
		}
		else if ($row["Field"]=="OfferName")
		{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("OfferName", "Offer Name", $row["Field"])?> </label>
												<div class="col-sm-4"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("MetaTitles", "Meta Title", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("MetaTitles", "Meta Title", $row["Field"])?>"></div>
											</div>

<?php
		}
		else if ($row["Field"]=="BaseAmount")
		{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("BaseAmount", "Base Amount", $row["Field"])?><span>*</span></label>
													<div class="col-sm-4"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("BaseAmount", "Base Amount", $row["Field"])?>" class="form-control" placeholder="<?=str_replace("BaseAmount", "Base Amount", $row["Field"])?>"></div>
											</div>
<?php
		}
			else if ($row["Field"]=="Type")
		{
?>
												<div class="form-group"><label class="col-sm-3 control-label">Type<span>*</span></label>
													<div class="col-sm-4">
														<select class="form-control"  name="Type" id="Type"  >
															<option value="0" selected>--Select--</option>
															<option value="1">Amount</option>
															<option value="2">%</option>
														</select>
													</div>
												</div>
										
<?php
		}
		else if ($row["Field"]=="TypeAmount")
		{
?>
												<div class="form-group"><label class="col-sm-3 control-label">Type(Amount or %)<span>*</span></label>
													<div class="col-sm-4">
														<input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Type(Amount or %)", "TypeAmount", $row["Field"])?>" class="form-control" placeholder="<?=str_replace("Type(Amount or %)", "TypeAmount", $row["Field"])?>" />
												   </div>
												</div>
										
			
<?php
		}
		else if ($row["Field"]=="Title")
		{
?>
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Title", "Title", $row["Field"])?><span>*</span></label>
													<div class="col-sm-4"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("Title", "Title", $row["Field"])?>" class="form-control" placeholder="<?=str_replace("Title", "Title", $row["Field"])?>"></div>
												</div>
													
<?php
		}
			else if ($row["Field"]=="StoreID")
		{
													
			$sql1 = "SELECT StoreID, StoreName from tblStores where Status=0";
			
											$RS2 = $DB->query($sql1);
											if ($RS2->num_rows > 0)
											{
?>											
												<div class="form-group"><label class="col-sm-3 control-label">Store Name<span>*</span></label>
													<div class="col-sm-4">
														<select class="form-control "  name="StoreID[]" id="StoreID" multiple style="height:100pt" onChange="LoadValue1();">
															<option value="" selected>--SELECT NAME--</option>
<?
																while($row2 = $RS2->fetch_assoc())
																{
																	$StoreID = $row2["StoreID"];
																	$StoreName = $row2["StoreName"];	
?>
																	<option value="<?=$StoreID?>" ><?=$StoreName?></option>
<?php
																}
?>
														</select>
<?php
											}
											else
											{
?>
														<div class="col-sm-10">
<?php
														echo "Master Offers are not added. <a href='ManageStores.php' target='Stores'>Click here to add</a>";
											}
?>
														</div>
													</div>
													<span id="catid"></span>
													<span id="serviceid"></span>
<?php
		}
		else if ($row["Field"]=="ServiceAmount")
		{
?>
									
											
												<div class="form-group" id="asmita1" style="display:none"><label class="col-sm-3 control-label"><?=str_replace("ServiceAmount", "Service Amount", $row["Field"])?><span>*</span></label>
													<div class="col-sm-4">
														<input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("ServiceAmount", "Service Amount", $row["Field"])?>" class="form-control cost" placeholder="<?=str_replace("ServiceAmount", "Service Amount", $row["Field"])?>">
													</div>
												</div>
<?php
		}
		else if ($row["Field"]=="ServiceID")
		{
			
		}
		else if ($row["Field"]=="OfferDescription")
		{
?>
														<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("OfferDescription", "Description", $row["Field"])?> <span>*</span></label>
															<div class="col-sm-3"><textarea  rows="4" cols="150" name="<?=$row["Field"]?>" id="<?=str_replace("OfferDescription", "Description", $row["Field"])?>" class="form-control  wysiwyg" placeholder="<?=str_replace("OfferDescription", "Description", $row["Field"])?>"></textarea></div>
														</div>			
                                                        	<div class="form-group">
													<label class="col-sm-3 control-label">Image
													</label>
													<div class="col-sm-4">
														
														
														<input class="file_upload" type="file" data-source="PrimaryImage" name="PrimaryImage" id="fileSelect">
													</div>
													
												</div>														
													
			
<?php
		}
		else if ($row["Field"]=="OfferAmount")
		{
?>
									
											
												
												<div class="form-group" id="asmita2" style="display:none"><label class="col-sm-3 control-label"><?=str_replace("OfferAmount", "Offer Amount", $row["Field"])?><span>*</span></label>
													<div class="col-sm-4">
														<input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("OfferAmount", "Offer Amount", $row["Field"])?>" class="form-control offercost" placeholder="<?=str_replace("OfferAmount", "Offer Amount", $row["Field"])?>">
													</div>
												</div>
										
			
<?php
		}
	else if ($row["Field"]=="OfferDateFrom")
		{
			//$datef=date('m-d-y')
?>
									
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("OfferDateFrom", "Offer Date From", $row["Field"])?><span>*</span></label>
													<div class="col-md-4">
														<div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span> <input type="text" name="OfferDateFrom" id="OfferDateFrom" class="form-control" value="<?php echo date('Y-m-d');?>"></div>
													</div>
												</div>
										
			
<?php
		}
			else if ($row["Field"]=="OfferCode")
		{
?>
									
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("OfferCode", "Offer Code", $row["Field"])?><span>*</span></label>
													<div class="col-sm-4"><input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("OfferCode", "Offer Code", $row["Field"])?>" class="form-control required" placeholder="<?=str_replace("OfferCode", "Offer Code", $row["Field"])?>"  ></div>
											</div>
										
			
<?php
		}
	  else if ($row["Field"]=="OfferDateTo")
		{
?>
									
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("OfferDateTo", "Offer Date To", $row["Field"])?><span>*</span></label>
													<div class="col-md-4">
														<div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span> <input type="text" name="OfferDateTo" id="OfferDateTo" class="form-control" value="<?php echo date('Y-m-d');?>"></div>
													</div>
												</div>
										
			
<?php
		}
	else if ($row["Field"]=="Status")
		{
?>
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("POST", " ", $row["Field"])?> <span>*</span></label>
													<div class="col-sm-2">
														<select name="<?=$row["Field"]?>" class="form-control">
															<option value="0" Selected>Live</option>
															<option value="1">Offline</option>	
														</select>
													</div>
												</div>
<?php	
		}
		else
		{
?>																	
												<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("POST", " ", $row["Field"])?> <span>*</span></label>
													<div class="col-sm-3">
														<input type="text" name="<?=$row["Field"]?>" id="<?=str_replace("POST", " ", $row["Field"])?>" class="form-control" placeholder="<?=str_replace("POST", " ", $row["Field"])?>">
													</div>
												</div>
<?php
		}
	}
?>


<!--Add Tags-->

<!--End Tags-->			
<!--Add Category like phoenix-->
											
<!--End Category like phoenix-->						
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
								<form role="form" enctype="multipart/form-data" class="form-horizontal bordered-row enquiry_form" onSubmit="proceed_formsubmit('.enquiry_form', '<?=$strMyActionPage?>', '.result_message', '', '', '','.file_upload'); return false;">
											
								<span class="result_message">&nbsp; <br>
								</span>
									<br>
									<input type="hidden" name="step" value="edit">

								
									<h3 class="title-hero">Edit POST</h3>
									<div class="example-box-wrapper">
									<script>
$(function () {
    $("#OfferDateTo").datepicker({ minDate: 0 });
	 $("#OfferDateFrom").datepicker({ minDate: 0 });
});
	function LoadValue()
            {                
				//alert (OptionValue);
				var OptionValue=$("#CategoryID").val();
				
				$.ajax({
					type: 'POST',
					url: "GetServicesStoreWise1.php",
					data: {
						id:OptionValue
						
					},
				
					success: function(response) {
							alert (response);
						$(".load_charges").html(response);
						// alert (response);
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$(".load_charges").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						//alert (response);
					}
				});

            }
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
			storeid=[];
			type=[];
		var type=$("#catid").val();
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
		url:"servicecat.php",
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
		
		
		}
			
		/* function LoadValueasmita()
	{
		//alert(1324)
		valuable=[];
		var valuable = $('#Services').val();
		//alert(valuable)
		var store = $('#StoreID').val();
		//alert(store)
		var baseamount = $('#BaseAmount').val();
		//alert(baseamount)
		var type = $('#Type').val();
		//alert(type)
		var typeamt = $('#TypeAmount').val();
		
		//alert(typeamt)
		//alert(store)
			  $.ajax({
					type: 'POST',
					url: "calculateofferamount.php",
					data: {
						id:valuable,
						stored:store,
						baseamount:baseamount,
						type:type,
						typeamt:typeamt
						
					},
					success: function(response) {
						result=[];
						//alert($.trim(response))
						var res=$.trim(response);
						var result = res.split("#");
						//alert(result[0])
						$("#asmita1").show();
					$(".cost").val(result[0]);
					$("#asmita2").show();
					$(".offercost").val(result[1]);
							
							
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						//$("#asmita1").html("<center><font color='red'><b>Please try again after some time</b></font></center>");
						return false;
						//alert (response);
					}
				});  
	} */
</script>	
<?php

$strID = DecodeQ(Filter($_GET["uid"]));
$DB = Connect();
$sql = "select * FROM $strMyTable where $strMyTableID = '$strID'";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{

	while($row = $RS->fetch_assoc())
	{
		foreach($row as $key => $val)
		{
			if($key==$strMyTableID)
			{
										
?>
											<input type="hidden" name="<?=$key?>" value="<?=Encode($strID)?>">
																					

<?php
			}
			elseif($key=="ImagePath")
			{
					// echo $row[$key];

			}
			elseif($key=="ServiceID")
			{
				// echo $row[$key];
				$ServiceIDs = $row[$key];
				$offercats = $row['OfferCategory'];
				$offercatstd = explode(",",$offercats);
				$strServices = explode(",",$ServiceIDs);
				$storep=$row['StoreID'];
				$stores=explode(",",$storep);
			
				// print_r($arrCategories);
				// die();
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ServiceID", "Category", $key)?> <span>*</span></label>
												<div class="col-sm-4">
													<select class="form-control" multiple style="height:100pt" id="catid"  name="CategoryID[]" onChange="checktype();">
														<option value="0">--Select--</option>
														<?php
															for($a=0;$a<count($stores);$a++)
															{
																$selectCategories=select("distinct(CategoryID)","tblProductsServices","StoreID='".$stores[$a]."'");
																
																
															}
															foreach($selectCategories as $cat)
															{
																$CategoryID=$cat['CategoryID'];
																$sep=select("*","tblCategories","CategoryID='".$CategoryID."'");
																		$CategoryName=$sep[0]['CategoryName'];
																if (in_array("$CategoryID", $offercatstd))
																	{
																		$sep=select("*","tblCategories","CategoryID='".$CategoryID."'");
																		$CategoryName=$sep[0]['CategoryName'];
																		$cat=$sep[0]['CategoryID'];
																	?>
																		<option selected value="<?=$cat?>"><?=$CategoryName?></option>
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
				

											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("ServiceID", "Service", $key)?> <span>*</span></label>
												<div class="col-sm-4">
													<select name="<?=$key?>[]" class="form-control col-sm-4 load_charges" multiple style="height:150pt" id="serviceid">
														<option value="0">--Select--</option>
														<?php
														


		$type=$offercatstd;
//print_r($type);
  $storeid=$stores;

                                                           for($i=0;$i<count($type);$i++)
														   {
															  
																    $sql_display=select("distinct(ServiceID)","tblProductsServices","CategoryID IN('".$type[$i]."') and StoreID IN('".$storeid[$i]."')");
																	foreach($sql_display as $val)
															         {
																		 $servicessr[]=$val['ServiceID'];
																	
																	 }
																	
															  
														
														
															 
														   }
													
														
													  $servicess=array_unique($servicessr);
																		
														for($t=0;$t<count($servicess);$t++)
															 {
																
																if(in_array("$servicess[$t]",$strServices))
																{
																	
																$seti=select("*","tblServices","ServiceID='".$servicess[$t]."'");
																			$servicename=$seti[0]['ServiceName'];
																			$ServiceCost = $seti[0]["ServiceCost"];
																			$ServiceCode = $seti[0]["ServiceCode"];
																	?>
																		<option selected value="<?=$servicess[$t]."#".$ServiceCode?>"><?php echo $servicename?>, Rs. <?=$ServiceCost?></option>
																	<?
																}
																else
																{
																	$setip=select("*","tblServices","ServiceID='".$servicess[$t]."'");
																			$servicename=$setip[0]['ServiceName'];
																			$ServiceCost = $setip[0]["ServiceCost"];
																			$ServiceCode = $setip[0]["ServiceCode"];
																			if($servicename!="")
																			{
																	?>
																		<option value="<?=$servicess[$t]."#".$ServiceCode?>"><?php echo $servicename?>, Rs. <?=$ServiceCost?></option>
																	<?
																			}
																}
																
																
																														
															 }
														
										
															
													?>
													</select>
													
												</div>
											</div>											
										
<?php
			}
			elseif($key=="OfferDescription")
			{
?>	
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("OfferDescription", "Description", $key)?><span>*</span></label>
												<div class="col-sm-4"><textarea name="<?=$key?>" class="form-control wysiwyg"><?=$row[$key]?></textarea></div>
											</div>			
                                                									
<?php
			}
			elseif($key=="OfferCategory")
			{
				
			}
			else if ($key=="OfferDateFrom")
		{
			//$datef=date('m-d-y')
?>
									
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Offer Date From", "OfferDateFrom", $key)?><span>*</span></label>
														<div class="col-md-4">
															<div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span> <input type="text" name="OfferDateFrom" id="OfferDateFrom" class="form-control" value="<?=$row[$key]?>">
															</div>
														</div>
													</div>
													<div class="form-group">
													<label class="col-sm-3 control-label">Image
													</label>
													<div class="col-sm-4">
														
														<img src="<?=$row['ImagePath']?>"  width="150px" height="150px" /><br><br>
														<input class="file_upload" type="file" data-source="PrimaryImage" name="PrimaryImage" id="fileSelect">
													</div>
													
												</div>		
										
			
<?php
		}
		else if ($key=="OfferDateTo")
		{
			//$datef=date('m-d-y')
?>
									
													<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Offer Date To", "OfferDateTo", $key)?><span>*</span></label>
														<div class="col-md-4">
															<div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span> <input type="text" name="OfferDateTo" id="OfferDateTo" class="form-control" value="<?=$row[$key]?>">
															</div>
														</div>
													</div>
										
			
<?php
		}
		else if ($key=="OfferCode")
		{
?>
									
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("OfferCode", "OfferCode", $key)?><span>*</span></label>
													<div class="col-sm-4"><input type="text" name="<?=$key?>" id="<?=str_replace("Offer Code", "OfferCode", $key)?>" value="<?= $row[$key]?>" class="form-control" placeholder="<?=str_replace("Offer Code", "OfferCode", $key)?>" readonly ></div>
											</div>
<?php
		}
		else if ($key=="BaseAmount")
		{
?>
									
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Base Amount", "BaseAmount", $key)?><span>*</span></label>
													<div class="col-sm-4"><input type="text" name="<?=$key?>" id="<?=str_replace("Base Amount", "BaseAmount", $key)?>" value="<?= $row[$key]?>"  class="form-control" placeholder="<?=str_replace("Base Amount", "BaseAmount", $key)?>"></div>
											</div>
<?php
		}
		elseif($key=="Type")
		{
			?>
				<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Type", "Type", $key)?> <span>*</span></label>
												<div class="col-sm-2">
													<select name="<?=$key?>" class="form-control ">
													<option value="0">--Select--</option>
													<?php
															if ($row[$key]=="2")
															{
?>
															<option value="1" >Amount</option>
															<option value="2" selected>%</option>
<?php
															}
															elseif ($row[$key]=="1")
															{
?>
																<option value="1" selected>Amount</option>
															<option value="2" >%</option>
<?php
															}
															else
															{
?>
																<option value="1">Amount</option>
															<option value="2" >%</option>
															<?php
															}
															?>
													</select>
											    </div>
				</div>
<?php
			}
			elseif($key=="StoreID")
			{
				?>
					<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("StoreID", "Store", $key)?> <span>*</span></label>
												<div class="col-sm-4">
													<select name="<?=$key?>[]" class="form-control" multiple style="height:80pt" onChange="LoadValue1();" id="StoreID">
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
																	if (in_array("$StoreID", $stores))
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
				
<?php
		}
		elseif($key=="ServiceAmount")
		{
			
		}
		elseif($key=="OfferAmount")
		{
			
		}
		elseif($key=="Status")
		{
?>
											<div class="form-group"><label class="col-sm-3 control-label"><?=str_replace("Status", "Status", $key)?> <span>*</span></label>
												<div class="col-sm-2">
													<select name="<?=$key?>" class="form-control">
<?php
															if ($row[$key]=="0")
															{
?>
																<option value="0" selected>Live</option>
																<option value="1">Offline</option>
<?php
															}
															elseif ($row[$key]=="1")
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
												<div class="col-sm-3"><input type="text" name="<?=$key?>" class="form-control " placeholder="<?=str_replace("Admin", " ", $key)?>" value="<?=$row[$key]?>">
												</div>
											</div>
<?php
		}
			
		}
	}
?>
<?php
			
				// $DBvalue=$row[$key];
				
?>	
				<div class="form-group">
						
						
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