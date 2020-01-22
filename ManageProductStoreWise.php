<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Product Management | Nailspa";
	$strDisplayTitle = "View Product for all Nailspa Stores";
	$strMenuID = "3";
	$strMyTable = "tblProducts";
	$strMyTableID = "ProductID";
	$strMyField = "";
	$strMyActionPage = "ManageProductStoreWise.php";
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
								
									<span class="form_result">&nbsp; <br>
									</span>
									
									<div class="panel-body">
										<h3 class="title-hero">Choose Store to View Products | Nailspa</h3>
										<div class="example-box-wrapper">
										<?
										$DB = Connect();
										$sql1 = "SELECT StoreID, StoreName FROM tblStores where Status='0'";
										$RS2 = $DB->query($sql1);
											while($row2 = $RS2->fetch_assoc())
											{
												//echo 1234;
											?>
												<center>
													<div class="item col-lg-4 masonry-2" data-filter-value="masonry-2" style="margin: 20px 50px">
														<?
															$StoreID = $row2['StoreID'];
															$strStoreID = EncodeQ($StoreID);
															$strStoreName =$row2['StoreName']
														
														?>
														<a href="ViewStoreStock.php?q=<?=$strStoreID?>" title="<?=$strStoreName?>">
															<div class="thumbnail-box-wrapper">
																<!--<div class="thumbnail-box">
																	<img src="images/logo.png" alt="<?=$strStoreName?>">
																</div>-->
																<div class="thumb-pane">
																	<h3 class="thumb-heading animated rollIn"><?=$strStoreName?></h3>
																</div>
															</div>
														</a>
													</div>
												</center>
											<?
											}
											?>
										
										</div>
										<!-- End Table -->							
											
											
										<!--</div>-->
									</div>
								</div>
							</div>
						</div>
                    </div>
<?php
} // End null condition
?>	                   
                </div>
            </div>
        </div>
		
        <?php require_once 'incFooter.fya'; ?>
		
    </div>
</body>

</html>									