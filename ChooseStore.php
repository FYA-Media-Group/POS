<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
	$strPageTitle = "Employee Management | NailSpa";
	$strDisplayTitle = "Choose Store for Employee Attendance";
	$strMenuID = "3";
	$strMyTable = "tblStores";
	$strMyTableID = "StoreID";
	$strMyField = "StoreName";
	$strMyActionPage = "ManageAttendance.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
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
                        <p></p>
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
										<div class="example-box-wrapper">
										<?
										$sql1 = "SELECT StoreID, StoreName FROM tblStores where Status=0";
										$RS2 = $DB->query($sql1);
										while($row2 = $RS2->fetch_assoc())
										{
										?>
											<center>
												<div class="item col-lg-4 masonry-2" data-filter-value="masonry-2" style="margin: 20px 50px">
													<?
														$StoreID = $row2['StoreID'];
														$strStoreID = EncodeQ($StoreID);
													?>
													<a href="ManageAttendance.php?s=<?=$strStoreID?>" title="">
														<div class="thumbnail-box-wrapper">
															<div class="thumbnail-box">
																<img src="images/logo.png" alt="<?=$row2['StoreName']?>">
															</div>
															<div class="thumb-pane">
																<h3 class="thumb-heading animated rollIn"><?=$row2['StoreName']?></h3>
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