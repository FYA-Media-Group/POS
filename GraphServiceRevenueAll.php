<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; 
	$strPageTitle = "Monthly Service Revenue | Nailspa";
	$strDisplayTitle = "Monthly Service Revenue | Nailspa";
	$strMenuID = "6";
	$strMyTable = "tblExpenses";
	$strMyTableID = "ExpenseID";
	$strMyActionPage = "GraphEmployeePerformanceAll.php";
	$strMessage = "";
	$sqlColumn = "";
	$sqlColumnValues = "";
	
	
	
// code for not allowing the normal admin to access the super admin rights	
	if($strAdminType!="0")
	{
		die("Sorry you are trying to enter Unauthorized access");
	}
	// if($strStore=="0")
	// {
		// die("Sorry you are trying to enter Unauthorized access");
	// }
// code for not allowing the normal admin to access the super admin rights	


	
	

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once("incMetaScript.fya"); ?>
    <?php require_once("incmetabarservicechart.fya"); ?>

    <script type="text/javascript" src="assets/widgets/charts/chart-js/chart-doughnut.js"></script>
    <script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script type="text/javascript" src="https://www.amcharts.com/lib/3/themes/patterns.js"></script>
    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker.js"></script>
    <script type="text/javascript" src="assets/widgets/datepicker-ui/datepicker-demo.js"></script>
    <script type="text/javascript" src="assets/widgets/daterangepicker/moment.js"></script>
    <script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="assets/widgets/daterangepicker/daterangepicker-demo.js"></script>
    <script type="text/javascript" src="assets/widgets/datepicker/datepicker.js"></script>
    <style>
        .btn-danger:hover {
            border-color: #FC8213;
            background: #Fc8213;
        }
    </style>
</head>
<script>
    $(document).ready(function() {
        var store = $("#storeid").val();


        $.ajax({
            type: "post",
            data: "storeid=" + store,
            url: "storecategoryorder.php",
            success: function(res) {
                //alert(res)
                var rep = $.trim(res);
                $("#catid").show();
                $("#catid").html("");
                $("#catid").html("");
                $("#catid").html(rep);
            }

        })

        $("#viewserall").click(function() {
            window.location = "ViewServiceAllRevenue.php";

        });
		
					$("#referemper").click(function()
						{
						//alert(666)
								$.ajax({
								 type:"POST",
								 data:"abc="+abc,
								 url:"DisplayServiceRevenueAll.php",
								 success:function(res)
								{
								//alert(res)
								  if(res=='1')
								  {
									  location.reload();
								  }
									
								}
								
								
							 })
							//window.location="DisplayEmpPerformance.php";
							//window.location="CronServiceRevenueStore.php";
							//window.location="CronServiceRevenueStore.php";
							
							
						});
						
					$("#referemperall").click(function()
						{
						//alert(666)
								$.ajax({
								 type:"POST",
								 data:"abc="+abc,
								 url:"DisplayServiceRevenueAllStore.php",
								 success:function(res)
								{
								alert(res)
								  if(res=='1')
								  {
									  location.reload();
								  }
									
								}
								
								
							 })
							//window.location="DisplayEmpPerformance.php";
							//window.location="CronServiceRevenueStore.php";
							//window.location="CronServiceRevenueStore.php";
							
							
						});

    })

    function checkstore(evt) {
        var store = $(evt).val();
        $.ajax({
            type: "post",
            data: "storeid=" + store,
            url: "IncMetaBarChartStore.php",
            success: function(res) {
                //alert(res)
                var rep = $.trim(res);
                $("#catid").show();
                $("#catid").html("");
                $("#catid").html("");
                $("#catid").html(rep);
            }

        })
    }

    function printDiv(divName) {
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

    function updateexpensestatus(evt) {
        var id = $(evt).closest('td').prev().find('input').val();
        //alert(id)
        if (id != "") {
            $.ajax({
                type: "post",
                data: "id=" + id,
                url: "UpdateExpensesStatus.php",
                success: function(result) {
                    //alert(result);
                    if ($.trim(result) == '2') {
                        location.reload();
                    }
                }


            })
        }
    }
</script>

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

                    <div class="panel">
                        <div class="panel-body">
                            <style type="text/css">
                                @media print {
                                    body * {
                                        visibility: hidden;
                                    }
                                    #printarea * {
                                        visibility: visible;
                                    }
                                    #printarea {
                                        position: absolute;
                                        left: 0;
                                        top: 0;
                                    }
                                }

                                #di table {
                                    border: none;
                                }
                            </style>

                            <div class="example-box-wrapper">
                                <div class="tabs">



                                    <span class="form_result">&nbsp; <br></span>

                                    <div class="panel-body">
                                        <div class="fa-hover">
                                            <a class="btn btn-primary btn-lg btn-block" href="javascript:window.location = document.referrer;"><i class="fa fa-backward"></i> &nbsp; Go back to <?=$strPageTitle?></a>
                                        </div>
                                        </br/>
                                        <br/>
                                        <div class="example-box-wrapper">
                                            <div class="form-group">
                                                <div class="row">
                                                    <span id="abc" style="display:none"></span>


                                                    <div class="col-md-12" style="padding-top: 10px;">
                                                        <div class="panel mrg20T">
                                                            <div class="panel-body">
                                                                <div class="col-md-12">
                                                                    <h3 class="title-hero">Monthly Service Wise Revenue
                                                                 
                                                                    </h3>&nbsp;&nbsp;<input type="button" id="viewserall" class="btn ra-100 btn-primary" value="View All">&nbsp;&nbsp;<input type="button" id="referemper" class="btn ra-100 btn-primary" value="Refresh">&nbsp;&nbsp;<input type="button" id="referemperall" class="btn ra-100 btn-primary" value="Refresh All">
                                                                    <div class="example-box-wrapper">

                                                                        <div id="chartdiv2"></div>

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



                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <?php require_once 'incFooter.fya'; ?>
        </div>

    </div>
</body>

</html>