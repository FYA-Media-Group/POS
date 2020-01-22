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

$typepie=$_POST['typepie'];
if($typepie=='3')
{
require_once("incpiechartcustomerretention.fya"); 

}
 ?>


<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	<?php //require_once("incChartsMetaScript.fya"); ?>
	

	<script type="text/javascript" src="assets/widgets/charts/chart-js/chart-doughnut.js"></script>
	<script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
	<script type="text/javascript" src="https://www.amcharts.com/lib/3/themes/patterns.js"></script>
    <style>
    	.btn-danger:hover{
			border-color: #FC8213;
			background: #Fc8213;
		}
    </style>
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
				
                    <script type="text/javascript" src="assets/widgets/skycons/skycons.js"></script>
                    <script type="text/javascript" src="assets/widgets/datatable/datatable.js"></script>
                    <script type="text/javascript" src="assets/widgets/datatable/datatable-bootstrap.js"></script>
                    <script type="text/javascript" src="assets/widgets/datatable/datatable-tabletools.js"></script>
						<div class="row">
				<span id="abc" style="display:none"></span>
				
					<div class="col-md-6" style="padding-top: 10px;">
						<div class="panel mrg20T">
							<div class="panel-body">
								<div class="col-md-12">
									
									<div class="example-box-wrapper">
										<div class="form-group">
										<div id="chartdiv1"></div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
			</div>	

		</div>
						</div>
					</div>
			</div>	
