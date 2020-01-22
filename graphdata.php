<html>
<body>

<!-- Styles -->

<style>

#chartdiv1 {

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

var chart = AmCharts.makeChart( "chartdiv1", {

  "type": "pie",

  "theme": "light",

  "dataProvider": [

  	                 {

					"country": "New Walkin %",

					"litres": 96.2536023055					}, 

					   {

					"country": "Recurred customers %",

					"litres": 1.15273775216					}, 

					   {

					"country": "Existing customers %",

					"litres": 2.59365994236					}, 

					   {

					"country": "Reacquired customers %",

					"litres": 0					}, 

			

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

</script>	
</body>
</htm>