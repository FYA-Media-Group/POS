<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Content Received | Nailspa";
	$strDisplayTitle = "Content Received of Nailspa Experience";
	$strMenuID = "2";
	$strMyTable = "tblStoreStock";
	$strMyTableID = "StoreStockID";
	$strMyField = "";
	$strMyActionPage = "ReportContentReceived.php";
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
									
										<div id="normal-tabs-1">
										
											<span class="form_result">&nbsp; <br>
											</span>
											
											<div class="panel-body">
												<h3 class="title-hero">List of Content Received </h3>
												
												<form method="get" class="form-horizontal bordered-row" role="form">
													<div class="form-group"><label for="" class="col-sm-4 control-label">Content Type</label>
														<div class="col-sm-4">
															
														
														<select class="form-control required"  name="contenttype">
															<option value="0" selected>--Content Type--</option>
															<?php
															$content=$_GET["contenttype"];
															$arrrry=['1','2'];
															//print_r($arrrry);
														if($content=='1')
														{
															?>
															<option value="1" selected >Video</option>
															<option value="2">Images</option>				
<?php                   
														}
														elseif($content=='2')
														{
?>
														  <option value="1">Video</option>
														   <option value="2" selected>Images</option>
														 
<?php                   
												
														}
														else
														{
															?>
													      <option value="1">Video</option>
														  <option value="2">Images</option>
														
														  <?php
														}
														?>
												          </select>
															
														
														</div>
													</div>
													<div class="form-group"><label class="col-sm-3 control-label"></label>
														<button type="submit" class="btn btn-alt btn-hover btn-success"><span>Apply Filter</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button>
														&nbsp;&nbsp;&nbsp;
														<a class="btn btn-link" href="ReportContentReceivedPerSalon.php">Clear All Filter</a>
														&nbsp;&nbsp;&nbsp;
														<button onclick="printDiv('printarea')" class="btn btn-blue-alt">Print<div class="ripple-wrapper"></div></button>
													</div>
												</form>
												<br/>
	<?php
$DB = Connect();
if(isset($_GET["contenttype"]))
{
?>	
												<div id="printdata">
												<h2 class="title-hero" id="heading" style="display:none"><center>Report Content Received Per Salon</center></h2>
												<br>
												<div class="example-box-wrapper">
													<table class="table table-bordered table-striped table-condensed cf" width="100%">
														<thead class="cf">
															<tr>
															   <th>Sr</th>
																<th>Description</th>
																<th>Count</th>
																<th>Received From</th>
																<th>Uploaded To</th>
																
															</tr>
														</thead>
													
														<tbody>
<?

		$content=$_GET["contenttype"];
		if($content=='1')
		{
			$sql = "SELECT Description,VideoURL,AdminID,StoreID,count(VideoID) as countvideo from tblVideos where VideoURL!=''";
		}
		elseif($content=='2')
		{
			// $sql = "SELECT tblMarktingImg.Description,tblMarktingImg.AdminID,tblMarktingImg.StoreID,tblImages.ImagePath,count(tblImages.ImageID) as countvideo from tblMarktingImg left join tblImages on tblMarktingImg.MarketingImgID=tblImages.MarketingImgID where tblImages.ImagePath!=''";
			$sql="Select * from tblMarktingImg";
		}
		elseif($content==0)
		{
			echo("<script>location.href='ReportContentReceivedPerSalon.php';</script>");
		}
// }
// echo $selectCount."<br>";
$RS = $DB->query($sql);
if ($RS->num_rows > 0) 
{
	$counter = 0;

	while($row = $RS->fetch_assoc())
	{
		$counter ++;
		$Description = $row["Description"];
		if($content==1)
		{
			$url = $row["VideoURL"];
		}
		else
		{
			$url = $row["ImagePath"];
		}
		$AdminID = $row["AdminID"];
		$MarketingImgID = $row["MarketingImgID"];
		$Description = $row["Description"];
		$Title = $row["Title"];
		$Email = $row["Email"];
		$StoreID  = $row["StoreID"];
		$seppt=select("StoreName","tblStores","StoreID='".$StoreID."'");
		$storename=$seppt[0]['StoreName'];
		$countvideo  = $row["countvideo"];
	    $sepp=select("AdminFullName","tblAdmin","AdminID='".$AdminID."'");
		$AdminFullName=$sepp[0]['AdminFullName'];
?>														
															<tr id="my_data_tr_<?=$counter?>">
																<td><?=$counter?></td>
																<td>
																<?php
																if($content==1)
		                                                        {
																	  ?>
																	 <!-- <video width="200" autoplay controls><source src="<?//=$row["VideoURL"]?>" type="video/mp4"> Your browser does not support video.</video>-->
																	 <?
																	 if($Description=="")
																	 {
																		echo "---";
																	 }
																	 else
																	 {
																		echo $Description;
																	 }
																	 ?>
																	 
																	  <?//=$Description?>
																	  <?php
																}
																else
																{
																	?>
																	<!--<img src="<?//=$row["ImagePath"]?>" width="15%" height="20%"/>-->
																	<?
																	 if($Description=="")
																	 {
																		echo "---";
																	 }
																	 else
																	 {
																		echo $Description;
																	 }
																	 ?>
																	<?=$Description?>
                                                                    <?php	
																}
																?>
																</td>
																<td>
																<?php
																if($content==1)
		                                                        {
																	  
																	  echo "1";
																}
																else
																{
																	$SelectImageCount="Select Count(ImagePath) as ImagePaths from tblImages where MarketingImgID='$MarketingImgID'";
																	// echo $SelectImageCount."<br>";
																	$RS1 = $DB->query($SelectImageCount);
																	if ($RS->num_rows > 0) 
																	{
																		while($row1 = $RS1->fetch_assoc())
																		{
																			$ImagePath = $row1["ImagePaths"];
																			echo $ImagePath;
																		}
																	}
																}
																?>
																</td>
																<td><?=$storename?></td>
																<td><?=$AdminFullName?></td>
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
									<?php
}
else
{
	echo "<br><center><h3>Please Select Content Type</h3></center>";
}
?>									
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