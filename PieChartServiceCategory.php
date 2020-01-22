<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>


<?php
// Redirection code-fork
	if($strAdminRoleID=='36')
	{

	}
	elseif($strAdminRoleID=='2')
	{
		echo("<script>location.href='Marketing-Dashboard.php';</script>");
	}
	elseif($strAdminRoleID=='38')
	{
		echo("<script>location.href='Audit-Dashboard.php';</script>");
	}
	elseif($strAdminRoleID=='6')
	{
		echo("<script>location.href='Salon-Dashboard.php';</script>");
	}
	elseif($strAdminRoleID=='4')
	{
		echo("<script>location.href='Operation-Dashboard.php';</script>");
	}elseif($strAdminRoleID=='39')
	{
		echo("<script>location.href='Admin-Dashboard.php';</script>");
	}
	else
	{

	}
?>


<!DOCTYPE html>
<html lang="en">

<head>


	<?php require_once("incpiechart.fya"); ?>

	
</head>

<body>
</body>
<div class="row">
				<span id="abc" style="display:none"></span>
					
					<div class="col-md-6" style="padding-top: 10px;">
						<div class="panel mrg20T">
							<div class="panel-body">
								<div class="col-md-12">
									<h3 class="title-hero">Service Category Wise Revenue </h3>
									<div class="example-box-wrapper">
							
										<div id="chartdiv1"></div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
			</div>	
</html>