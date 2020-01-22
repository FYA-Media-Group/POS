<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once("incMetaScript.fya"); ?>
	<?php require_once("incChartsMetaScript.fya"); ?>
	<style>

#chartdiv1 {
	width		: 100%;
	height		: 500px;
	font-size	: 11px;
}		
#chartdiv2 {
	width		: 100%;
	height		: 500px;
	font-size	: 11px;
}		
#chartdiv3 {
	width		: 100%;
	height		: 500px;
	font-size	: 11px;
}		
#chartdiv4 {
	width		: 100%;
	height		: 500px;
	font-size	: 11px;
}		
#chartdiv5 {
	width		: 100%;
	height		: 500px;
	font-size	: 11px;
}
</style>

<!-- Resources -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
        <script type="text/javascript" src="assets/widgets/carousel/carousel.js"></script>
                    <link rel="stylesheet" type="text/css" href="assets/widgets/owlcarousel/owlcarousel.css">
                    <script type="text/javascript" src="assets/widgets/owlcarousel/owlcarousel.js"></script>
                    <script type="text/javascript" src="assets/widgets/owlcarousel/owlcarousel-demo.js"></script>
<?php
$DB = Connect();
$ReturningCustomers = "SELECT CustomerID FROM tblAppointments GROUP BY CustomerID HAVING COUNT(*) > 1";

$RSf = $DB->query($ReturningCustomers);
if ($RSf->num_rows > 0) 
{
	
	while($rowf = $RSf->fetch_assoc())
	{
		$CustomerID[] = $rowf["CustomerID"];
	}
}
$pqr=count($CustomerID);

$First= date('Y-m-01');
$Last= date('Y-m-t');
// $NonReturningCustomers="SELECT CustomerID FROM tblCustomers where  GROUP BY CustomerID HAVING COUNT(*) <= 1";
$NonReturningCustomers="SELECT count(CustomerID) as NewCustomers FROM `tblCustomers` where Date(RegDate)>=Date('$First') and Date(RegDate)<=Date('$Last')";
$RSN = $DB->query($ReturningCustomers);
if ($RSN->num_rows > 0) 
{
	while($rowN = $RSN->fetch_assoc())
	{
		$NewCustomers = $rowN["NewCustomers"];
		// echo $NewCustomers;
		// echo "Hello";
	}
}


?>
<!-- Chart code -->
<script>
var chart = AmCharts.makeChart( "chartdiv1", {
  "type": "serial",
  "theme": "light",
  "marginRight": 70,
  "dataProvider": [ 
  <?php
  $DB = Connect();
$sqlgraph=select("FromDate,ToDate","tblGraphDateParameter","RoleID='".$strAdminRoleID."'");
		$FromDate=$sqlgraph[0]['FromDate'];
		$ToDate=$sqlgraph[0]['ToDate'];
	    $First= $FromDate;
		$Last= $ToDate;
$coldata=array();
$coldata=array('#FF0F00','#FF6600','#FF9E01','#FCD202','#F8FF01','#B0DE09','#04D215','#0D8ECF','#0D52D1','#2A0CD0','#8A0CCF','#CD0D74');

        $getfrom=$First;
		$getto=$Last;
        $sqldetailsd=newcustomercountallstore($getfrom,$getto,1);
		$counter=0;
		 foreach($sqldetailsd as $vat)
		    {
			    $counter++;
			    $app[]=$vat['AppointmentID'];
			    $custcnt=count($app);
				if($custcnt=='' || $custcnt=='0')
				{
					$custcnt=0;
				}
				  $color=$coldata[$counter];
				?>
			 {
			"country": "Colaba",
			"visits": <?=$custcnt?>,
			"color":"<?=$color?>"
			}, 
<?php
			}

		
  ?>
  ],
  "valueAxes": [{
    "axisAlpha": 0,
    "position": "left",
    "title": "New Walkins Acquired per day"
  }],
  "startDuration": 1,
  "graphs": [{
    "balloonText": "<b>[[category]]: [[value]]</b>",
    "fillColorsField": "color",
    "fillAlphas": 0.9,
    "lineAlpha": 0.2,
    "type": "column",
    "valueField": "visits"
  }],
  "chartCursor": {
    "categoryBalloonEnabled": false,
    "cursorAlpha": 0,
    "zoomable": false
  },
  "categoryField": "country",
  "categoryAxis": {
    "gridPosition": "start",
    "labelRotation": 45
  },
  "export": {
    "enabled": true
  }

} );

var chart = AmCharts.makeChart( "chartdiv2", {
  "type": "serial",
  "theme": "light",
  "marginRight": 70,
  "dataProvider": [ 
  <?php
  $DB = Connect();
$sqlgraph=select("FromDate,ToDate","tblGraphDateParameter","RoleID='".$strAdminRoleID."'");
		$FromDate=$sqlgraph[0]['FromDate'];
		$ToDate=$sqlgraph[0]['ToDate'];
	    $First= $FromDate;
		$Last= $ToDate;
$coldata=array();
$coldata=array('#FF0F00','#FF6600','#FF9E01','#FCD202','#F8FF01','#B0DE09','#04D215','#0D8ECF','#0D52D1','#2A0CD0','#8A0CCF','#CD0D74');

        $getfrom=$First;
		$getto=$Last;
        $sqldetailsd=newcustomercountallstore($getfrom,$getto,2);
		$counter=0;
		 foreach($sqldetailsd as $vat)
		    {
			    $counter++;
			    $app[]=$vat['AppointmentID'];
			    $custcnt=count($app);
				if($custcnt=='' || $custcnt=='0')
				{
					$custcnt=0;
				}
				  $color=$coldata[$counter];
				?>
			 {
			"country": "Khar",
			"visits": <?=$custcnt?>,
			"color":"<?=$color?>"
			}, 
<?php
			}

		
  ?>
  ],
  "valueAxes": [{
    "axisAlpha": 0,
    "position": "left",
    "title": "New Walkins Acquired per day"
  }],
  "startDuration": 1,
  "graphs": [{
    "balloonText": "<b>[[category]]: [[value]]</b>",
    "fillColorsField": "color",
    "fillAlphas": 0.9,
    "lineAlpha": 0.2,
    "type": "column",
    "valueField": "visits"
  }],
  "chartCursor": {
    "categoryBalloonEnabled": false,
    "cursorAlpha": 0,
    "zoomable": false
  },
  "categoryField": "country",
  "categoryAxis": {
    "gridPosition": "start",
    "labelRotation": 45
  },
  "export": {
    "enabled": true
  }

} );
var chart = AmCharts.makeChart( "chartdiv3", {
  "type": "serial",
  "theme": "light",
  "marginRight": 70,
  "dataProvider": [ 
  <?php
  $DB = Connect();
$sqlgraph=select("FromDate,ToDate","tblGraphDateParameter","RoleID='".$strAdminRoleID."'");
		$FromDate=$sqlgraph[0]['FromDate'];
		$ToDate=$sqlgraph[0]['ToDate'];
	    $First= $FromDate;
		$Last= $ToDate;
$coldata=array();
$coldata=array('#FF0F00','#FF6600','#FF9E01','#FCD202','#F8FF01','#B0DE09','#04D215','#0D8ECF','#0D52D1','#2A0CD0','#8A0CCF','#CD0D74');

        $getfrom=$First;
		$getto=$Last;
        $sqldetailsd=newcustomercountallstore($getfrom,$getto,3);
		$counter=0;
		 foreach($sqldetailsd as $vat)
		    {
			    $counter++;
			    $app[]=$vat['AppointmentID'];
			    $custcnt=count($app);
				if($custcnt=='' || $custcnt=='0')
				{
					$custcnt=0;
				}
				 $color=$coldata[$counter];
				?>
			 {
			"country": "Breach Candy",
			"visits": <?=$custcnt?>,
			"color":"<?=$color?>"
			}, 
<?php
			}

		
  ?>
  ],
  "valueAxes": [{
    "axisAlpha": 0,
    "position": "left",
    "title": "New Walkins Acquired per day"
  }],
  "startDuration": 1,
  "graphs": [{
    "balloonText": "<b>[[category]]: [[value]]</b>",
    "fillColorsField": "color",
    "fillAlphas": 0.9,
    "lineAlpha": 0.2,
    "type": "column",
    "valueField": "visits"
  }],
  "chartCursor": {
    "categoryBalloonEnabled": false,
    "cursorAlpha": 0,
    "zoomable": false
  },
  "categoryField": "country",
  "categoryAxis": {
    "gridPosition": "start",
    "labelRotation": 45
  },
  "export": {
    "enabled": true
  }

} );
var chart = AmCharts.makeChart( "chartdiv4", {
  "type": "serial",
  "theme": "light",
  "marginRight": 70,
  "dataProvider": [ 
  <?php
  $DB = Connect();
$sqlgraph=select("FromDate,ToDate","tblGraphDateParameter","RoleID='".$strAdminRoleID."'");
		$FromDate=$sqlgraph[0]['FromDate'];
		$ToDate=$sqlgraph[0]['ToDate'];
	    $First= $FromDate;
		$Last= $ToDate;
$coldata=array();
$coldata=array('#FF0F00','#FF6600','#FF9E01','#FCD202','#F8FF01','#B0DE09','#04D215','#0D8ECF','#0D52D1','#2A0CD0','#8A0CCF','#CD0D74');

        $getfrom=$First;
		$getto=$Last;
        $sqldetailsd=newcustomercountallstore($getfrom,$getto,4);
		$counter=0;
		 foreach($sqldetailsd as $vat)
		    {
			   $counter++;
			    $app[]=$vat['AppointmentID'];
			    $custcnt=count($app);
				if($custcnt=='' || $custcnt=='0')
				{
					$custcnt=0;
				}
				 $color=$coldata[$counter];
				?>
			 {
			"country": "Oshiwara",
			"visits": <?=$custcnt?>,
			"color":"<?=$color?>"
			}, 
<?php
			}

		
  ?>
  ],
  "valueAxes": [{
    "axisAlpha": 0,
    "position": "left",
    "title": "New Walkins Acquired per day"
  }],
  "startDuration": 1,
  "graphs": [{
    "balloonText": "<b>[[category]]: [[value]]</b>",
    "fillColorsField": "color",
    "fillAlphas": 0.9,
    "lineAlpha": 0.2,
    "type": "column",
    "valueField": "visits"
  }],
  "chartCursor": {
    "categoryBalloonEnabled": false,
    "cursorAlpha": 0,
    "zoomable": false
  },
  "categoryField": "country",
  "categoryAxis": {
    "gridPosition": "start",
    "labelRotation": 45
  },
  "export": {
    "enabled": true
  }

} );
var chart = AmCharts.makeChart( "chartdiv5", {
  "type": "serial",
  "theme": "light",
  "marginRight": 70,
  "dataProvider": [ 
  <?php
  $DB = Connect();
$sqlgraph=select("FromDate,ToDate","tblGraphDateParameter","RoleID='".$strAdminRoleID."'");
		$FromDate=$sqlgraph[0]['FromDate'];
		$ToDate=$sqlgraph[0]['ToDate'];
	    $First= $FromDate;
		$Last= $ToDate;
$coldata=array();
$coldata=array('#FF0F00','#FF6600','#FF9E01','#FCD202','#F8FF01','#B0DE09','#04D215','#0D8ECF','#0D52D1','#2A0CD0','#8A0CCF','#CD0D74');

        $getfrom=$First;
		$getto=$Last;
        $sqldetailsd=newcustomercountallstore($getfrom,$getto,5);
		$counter=0;
		 foreach($sqldetailsd as $vat)
		    {
			   $counter++;
			    $app[]=$vat['AppointmentID'];
			    $custcnt=count($app);
				if($custcnt=='' || $custcnt=='0')
				{
					$custcnt=0;
				}
				$color=$coldata[$counter];
				?>
			 {
			"country": "Lokhandwala",
			"visits": <?=$custcnt?>,
			"color":"<?=$color?>"
			}, 
<?php
			}

		
  ?>
  ],
  "valueAxes": [{
    "axisAlpha": 0,
    "position": "left",
    "title": "New Walkins Acquired per day"
  }],
  "startDuration": 1,
  "graphs": [{
    "balloonText": "<b>[[category]]: [[value]]</b>",
    "fillColorsField": "color",
    "fillAlphas": 0.9,
    "lineAlpha": 0.2,
    "type": "column",
    "valueField": "visits"
  }],
  "chartCursor": {
    "categoryBalloonEnabled": false,
    "cursorAlpha": 0,
    "zoomable": false
  },
  "categoryField": "country",
  "categoryAxis": {
    "gridPosition": "start",
    "labelRotation": 45
  },
  "export": {
    "enabled": true
  }

} );
</script>

</head>

<body>
 
    <div id="sb-site">
	
	<link rel="stylesheet" type="text/css" href="assets/frontend-elements/pricing-table.css">
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
                    <script type="text/javascript">
                        /* Datatables basic */

                        // $(document).ready(function() {
                            // $('#datatable-example').dataTable();
							// var abc=$("#abc").val();
							// $.ajax({
								// type:"POST",
								// data:"abc="+abc,
								// url:"chartdata.php",
								// success:function(res)
								// {
									// alert(res)
									
									
								// }
								
								
							// })
                        // });

                        /* Datatables hide columns */

                        $(document).ready(function() {
                            var table = $('#datatable-hide-columns').DataTable({
                                "scrollY": "300px",
                                "paging": false
                            });

                            $('#datatable-hide-columns_filter').hide();

                            $('a.toggle-vis').on('click', function(e) {
                                e.preventDefault();

                                // Get the column API object
                                var column = table.column($(this).attr('data-column'));

                                // Toggle the visibility
                                column.visible(!column.visible());
                            });
                        });

                        /* Datatable row highlight */

                        $(document).ready(function() {
                            var table = $('#datatable-row-highlight').DataTable();

                            $('#datatable-row-highlight tbody').on('click', 'tr', function() {
                                $(this).toggleClass('tr-selected');
                            });
                        });



                        $(document).ready(function() {
                            $('.dataTables_filter input').attr("placeholder", "Search...");
                        });
						
									function checkgraphtype(eee)
						{
							//alert(eee)
							//var grphtype = $(eee).val();
							if(eee!='0')
							{
								
								if(eee=='1')
								{
									$(".checkcustomeduration").hide();
									$.ajax({
									type:"post",
									data:"grphtype="+eee,
									url:"UpdateGraphData.php",
									success:function(result)
									{
										window.location = "Marketing-Dashboard.php";

									}
									
								  })
								}
								else if(eee=='2')
								{
									$(".checkcustomeduration").hide();
									$.ajax({
									type:"post",
									data:"grphtype="+eee,
									url:"UpdateGraphData.php",
									success:function(result)
									{
										//alert(result)
										window.location = "Marketing-Dashboard.php";
							           //location.reload();
									}
									
								  })
								}
								else
								{
									$(".checkcustomeduration").show();
									//var grpcu=$("#checkgraphcustom").val();
									//alert(grpcu)
								/* 	$.ajax({
									type:"post",
									data:"grphtype="+eee,
									url:"GenerateCustomGraphDuration.php",
									success:function(result)
									{
										alert(result)
							           location.reload();
									}
									
								  }) */
									//displaycustomduration
								}
							}
						}
						function checksubgraphcustom(ety)
						{
							
								$.ajax({
									type:"post",
									data:"month="+ety,
									url:"UpdateGraphData.php",
									success:function(result)
									{
										window.location = "Marketing-Dashboard.php";
									}
									
								  })
						}
                    </script>
                   
					
					
                    <div id="page-title">
                        <h2>Dashboard <?//=$strStore?></h2>
                        <!--<p>The most complete user interface framework that can be used to create stunning admin dashboards and presentation websites.</p>-->


						<?php //require_once("incDayClosing.php"); ?>
									   
									   
									   
                    </div>
				
			<?php 
				$DB = Connect();
				$sqlgraph=select("FromDate,ToDate,Type","tblGraphDateParameter","RoleID='".$strAdminRoleID."'");
				$FromDate=$sqlgraph[0]['FromDate'];
				$ToDate=$sqlgraph[0]['ToDate'];
				$FromDatee=date("d-m-Y",strtotime($FromDate));
				$ToDatee=date('d-m-Y',strtotime($ToDate));
				$Type=$sqlgraph[0]['Type'];
				?>
				   
						
			
                    <div class="row">
				<span id="abc" style="display:none"></span>
                        <div class="col-md-12">
						
                        	<div class="row">
                            	<div class="col-md-3">
                                    <div class="pricing-box content-box">
									<?php
								$DB = Connect();
								$First= date('Y-m-01');
								$Last= date('Y-m-t');
								$Month=date('M');
							
										$sept=select("count(CustomerID)","tblCustomers","Acquisition='Leaflet' and Date(RegDate)>=Date('$First') and Date(RegDate)<=Date('$Last')");
		                                $cntacccl=$sept[0]['count(CustomerID)'];
								        $septs=select("count(CustomerID)","tblCustomers","Acquisition='Sms' and Date(RegDate)>=Date('$First') and Date(RegDate)<=Date('$Last')");
		                                $cntacccams=$septs[0]['count(CustomerID)'];
										$septsy=select("count(CustomerID)","tblCustomers","Acquisition='Vouchers' and Date(RegDate)>=Date('$First') and Date(RegDate)<=Date('$Last')");
		                                $cntacccamss=$septsy[0]['count(CustomerID)'];
										$totalcnnnt=$cntacccl+$cntacccams+$cntacccamss;
										if($totalcnnnt=="")
										{
											$totalcnnnt=0;
										}
								$DB->close();
?>				
                                        <h3 class="bg-black pricing-title">Client Aquisition Analysis</a></h3>
                                        <div class="bg-blue pricing-specs" ><span><sup></sup><a href="DisplayClientAqusitionMarketing.php" style="color:#fff;"><?=$totalcnnnt?></a></span></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="pricing-box content-box">
<?php									
										$DB = Connect();
										
										    $First= date('Y-m-01');
											$Last= date('Y-m-t');
											$Month=date('M');
										
											$Products="SELECT count(CustomerID) as TotalProducts FROM `tblCustomers` where Date(RegDate)>=Date('$First') and Date(RegDate)<=Date('$Last')";
											
										// echo $Products;
										$RSa = $DB->query($Products);
										if ($RSa->num_rows > 0) 
										{
											while($rowa = $RSa->fetch_assoc())
											{
												$TotalProducts = $rowa["TotalProducts"];
												// echo $TotalProducts;
											}
										}
										$DB->close();
?>									
                                        <h3 class="bg-black pricing-title">Leaflet Offer Redemption</h3>
                                        <div class="bg-lighred pricing-specs" style="background: #d9b557; border-color: #bb9638;"><span style="color:#fff;"><sup></sup>10</span></div>
                                    </div>
                                </div>
                               
                                <div class="col-md-3">
                                    <div class="pricing-box content-box">
<?php									
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
												// echo "Hello";
											}
										}
										$date=date('y-m-d');
										if($strStoreID!=0)
										{
											$GiftSoldforMonth="Select (SELECT count(Date) FROM `tblGiftVouchers` where StoreId='$strStoreID' and Date(Date)>=Date('$First') and Date(Date)<=Date('$Last')) as GiftsoldthisMonth";
											$RSGiftforMonth = $DB->query($GiftSoldforMonth);
											if ($RSGiftforMonth->num_rows > 0) 
											{
												while($rowGifforMonth = $RSGiftforMonth->fetch_assoc())
												{
													$GiftsoldthisMonth = $rowGifforMonth["GiftsoldthisMonth"];
													echo $GiftsoldthisMonth;
												}
											}
										}
										else
										{
											// echo "In else";
											// $App="Select (SELECT count(0) FROM `tblAppointments` where AppointmentDate='$date') as TodaysAppointment";
											// $OfferSold="SELECT count(OfferID) FROM `tblOffers`  where status=0";
											// echo $OfferSold."<br>";
											
											// $RSc = $DB->query($OfferSold);
											// if ($RSc->num_rows > 0) 
											// {
												// while($rowc = $RSc->fetch_assoc())
												// {
													// $Offers = $rowc["Offers"];
													// echo $Offers;
												// }
											// }
											$First= date('Y-m-01');
											$Last= date('Y-m-t');
											
											$GiftSoldforMonth="Select (SELECT count(Date) FROM `tblGiftVouchers` where Date(Date)>=Date('$First') and Date(Date)<=Date('$Last')) as GiftsoldthisMonth";
											// echo $GiftSoldforMonth;
											$RSGiftforMonth = $DB->query($GiftSoldforMonth);
											if ($RSGiftforMonth->num_rows > 0) 
											{
												while($rowGifforMonth = $RSGiftforMonth->fetch_assoc())
												{
													$GiftsoldthisMonth = $rowGifforMonth["GiftsoldthisMonth"];
													// echo $GiftsoldthisMonth;
												}
											}
										}
										$DB->close();
?>									
                                        <h3 class="bg-black pricing-title"><a href="ReportGiftVoucherSold.php">SMS Offer Redemption</a></h3>
                                        <div class="bg-green pricing-specs"><span>30</span></i></div>
                                    </div>
                                </div>
								 <div class="col-md-3">
                                    <div class="pricing-box content-box" style="background: #FF0F00;border-color: #FF0F00; ">
<?php									
										$DB = Connect();
										$sql = "SELECT count(*) FROM tblContentApproval where Type=2 and Status=2";
										// echo $FindStore;
										$RSf = $DB->query($sql);
										if ($RSf->num_rows > 0) 
										{
											while($rowf = $RSf->fetch_assoc())
											{
												$cnttt = $rowf["count(*)"];
												// echo $strStoreID;
												// echo "Hello";
											}
										}
										$sql1 = "SELECT count(*) FROM tblContentApproval where Type=1 and Status=2";
										// echo $FindStore;
										$RSf = $DB->query($sql1);
										if ($RSf->num_rows > 0) 
										{
											while($rowf = $RSf->fetch_assoc())
											{
												$cnttt1 = $rowf["count(*)"];
												// echo $strStoreID;
												// echo "Hello";
											}
										}
										$totcnt=$cnttt1+$cnttt;
										if($totcnt=="")
										{
											$totcnt=0;
										}
										$DB->close();
?>									
                                        <h3 class="bg-black pricing-title"><a href="ReportGiftVoucherSold.php">Content recieved Web & App</a></h3>
                                        <div class="bg-lightred pricing-specs"><span><a href="DisplayContent.php" style="color:#fff;"><?=$totcnt?></a></span></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        	<div class="row">
				       <div class="panel">
                                                    <div class="panel-body">
                                                        <h3 class="title-hero">Offer carousel</h3>
                                                        <div class="example-box-wrapper">
                                                            <div class="owl-carousel-4 slider-wrapper inverse arrows-outside carousel-wrapper">
                                                               
																<?php 
																$DB = Connect();
																 $sepqt=select("*","tblOffers","ImagePath!='' and ImagePath!='NULL'");
																 foreach($sepqt as $vp)
																 {
																?>
																 <div>
                                                                    <div class="thumbnail-box-wrapper mrg5A">
                                                                        <div class="thumbnail-box"> <a class="thumb-link" href="#" title=""></a>
                                                                            <div class="thumb-content">
                                                                                <div class="center-vertical">
                                                                                    <div class="center-content"><i class="icon-helper icon-center animated zoomInUp font-white glyph-icon icon-linecons-camera"></i></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="thumb-overlay bg-black"></div><img src="<?=$vp['ImagePath']?>" alt=""></div>
                                                                        
                                                                    </div>
                                                                </div>
																	<?php 
																	
																 }
																	?>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
				</div>
								<?php 
				$DB = Connect();
				$sqlgraph=select("FromDate,ToDate,Type","tblGraphDateParameter","RoleID='".$strAdminRoleID."'");
				$FromDate=$sqlgraph[0]['FromDate'];
				$ToDate=$sqlgraph[0]['ToDate'];
				$FromDatee=date("d-m-Y",strtotime($FromDate));
				$ToDatee=date('d-m-Y',strtotime($ToDate));
				$Type=$sqlgraph[0]['Type'];
				?>
					    <span id="abc" style="display:none"></span>
						 <div class="col-md-12" style="padding-top: 10px;">
						 	<div class="panel mrg20T">
								<div class="panel-body" style="height:60px;">
								
								         <label class="col-sm-3 control-label">Select Duration For Graph<span>*</span></label>
												<div class="col-sm-3">
												<select name="checkgraphduration" id="checkgraphduration" class="form-control required" onchange="checkgraphtype(this.value)">
													 <option value="0" Selected>Select Month & Year</option>
													<option value="1" <?php if($Type=='1'){ ?> selected="selected" <?php }?> >Current Month Of 2017</option>
													<option value="2" <?php if($Type=='2'){ ?> selected="selected" <?php }?>>Previous Month Of 2017</option>	
													<option value="3" <?php if($Type=='3'){ ?> selected="selected" <?php }?>>Custom Month & Year</option>	
										     </select>
												</div>
								
								            <label class="col-sm-3 control-label checkcustomeduration" style="display:none">Select Custom Duration For Graph<span>*</span></label>
											<div class="col-sm-3">
												<select name="checkgraphcustom" id="checkgraphcustom" class="form-control required checkcustomeduration" onchange="checksubgraphcustom(this.value)" style="display:none">
												<option value="0" Selected>Select Month & Year</option>
												<?php 
	                                              $array = array("January", "February","March","April","May","June","July","August","September","October","November","December");
												
												for ($m=0; $m<=12; $m++)
												 {
											
												 ?>
												 <option value="<?=$m?>"><?=$array[$m]?></option>
												 <?php
												 }
												
												?>
												
											</select>
								   </div>
								
							
						     </div>
					
				          </div>
				        </div>
                        <div class="col-md-6">
                        	
							
							<div class="panel mrg20T">
									<div class="panel-body">
										<h3 class="title-hero">Target wise New Walkins Acquired per day <?="( ".$FromDatee." To ".$ToDatee." )"?></h3>
										<div class="example-box-wrapper">
											<div id="chartdiv1"></div>
										</div>
									</div>
								</div>
                            
                        </div>
						  <div class="col-md-6">
                        	
							
							<div class="panel mrg20T">
									<div class="panel-body">
										<h3 class="title-hero">Target wise New Walkins Acquired per day <?="( ".$FromDatee." To ".$ToDatee." )"?></h3>
										<div class="example-box-wrapper">
											<div id="chartdiv2"></div>
										</div>
									</div>
								</div>
                            
                        </div>
                    </div>
					<div class="row">
					  <div class="col-md-6">
                        	
							
							<div class="panel mrg20T">
									<div class="panel-body">
										<h3 class="title-hero">Target wise New Walkins Acquired per day <?="( ".$FromDatee." To ".$ToDatee." )"?></h3>
										<div class="example-box-wrapper">
											<div id="chartdiv3"></div>
										</div>
									</div>
								</div>
                            
                        </div>
					    <div class="col-md-6">
                        	
							
							<div class="panel mrg20T">
									<div class="panel-body">
										<h3 class="title-hero">Target wise New Walkins Acquired per day <?="( ".$FromDatee." To ".$ToDatee." )"?></h3>
										<div class="example-box-wrapper">
											<div id="chartdiv4"></div>
										</div>
									</div>
								</div>
                            
                        </div>
					</div>
					<div class="row">
					  <div class="col-md-6">
                        	
							
							<div class="panel mrg20T">
									<div class="panel-body">
										<h3 class="title-hero">Target wise New Walkins Acquired per day <?="( ".$FromDatee." To ".$ToDatee." )"?></h3>
										<div class="example-box-wrapper">
											<div id="chartdiv5"></div>
										</div>
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