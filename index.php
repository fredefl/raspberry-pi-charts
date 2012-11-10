<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Admin Panel</title>
		<style type="text/css">
			#page {
				width:auto;
				margin-left:auto;
				margin-right:auto;
				width:600px
			}
		</style>
	</head>

	<body>
		<div id="page">
			<div id="cpu-container" style="width: 600px; height: 300px;"></div>
			<div id="temp-container" style="width: 600px; height: 300px; margin-top:10px"></div>
		</div>

		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/highcharts.js"></script>
		<script type="text/javascript" src="js/gray.js"></script>
		<script type="text/javascript" src="js/cpu-chart.js"></script>
		<script type="text/javascript" src="js/temperature-chart.js"></script>

		<script type="text/javascript">	
			var obj = JSON.parse('<?php include("api.php") ?>');
			var x = 0;
			function plotCpu () {
				$.get("api.php", function(data){
					var obj = JSON.parse(data);
					x++;
					var seriesCpu = cpuChart.series[0];
					seriesCpu.addPoint([x, parseFloat(obj.cpu*100)], true, true);
					var seriesTemp = temperatureChart.series[0];
					seriesTemp.addPoint([x, parseFloat(obj.temp)], true, true);
					console.log(1, obj);
				});
			}	
		</script>
	</body>
</html>