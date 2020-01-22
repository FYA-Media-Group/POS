<!-- Styles -->
<style>
#chartdiv4 {
  width: 100%;
  height: 300px;
}
</style>

<!-- Resources -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

<!-- Chart code -->
<script>
var chart = AmCharts.makeChart( "chartdiv4", {
  "type": "pie",
  "theme": "light",
  "dataProvider": [
  <?php
		$DB = Connect();
		$First= date('Y-m-01');
		$Last= date('Y-m-t');
		$date=date('Y-m-d');
		$sqlst = "SELECT SUM(AmountPercentage) AS amtper,ServiceName,StoreName
				FROM tblCronServiceRevenue
				where StoreID!='0' and ServiceID!='0' group by ServiceID";
			
				
		$RSst = $DB->query($sqlst);
		if ($RSst->num_rows > 0) 
		{
			$counter = 0;

			while($rowst = $RSst->fetch_assoc())
			{
				$counter ++;
				$amtper = $rowst["amtper"];
				$ServiceName = $rowst["ServiceName"];
				
	?>
	                 {
					"country": "<?=$ServiceName?>",
					"litres": <?=$amtper?>
					}, 
			<?php
			}
			
		}
		else
		{
	?>
					{
					"country": "No sales found for any store for this month",
					"litres": 0
					}, 
	<?php
		}
		$DB->close();
	?>	
	],
  "valueField": "litres",
  "titleField": "country",
   "balloon":{
   "fixedPosition":true
  },
  "export": {
    "enabled": true
  }
} );

function setDataSet(dataset_url) {
  AmCharts.loadFile(dataset_url, {}, function(data) {
    chart.dataProvider = AmCharts.parseJSON(data);
    chart.validateData();
  });
}
</script>