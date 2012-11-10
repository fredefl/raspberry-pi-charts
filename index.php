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
		<script type="text/javascript">	
			var x = 0;
			var cpuLabel = $("#cpu");
			function plotCpu () {
				$.get("api.php", function(data){
					var obj = JSON.parse(data);
					obj.cpu *= 100;
					x++;
					cpuLabel.html(Math.round(obj.cpu)+"%");

					var seriesCpu = cpuChart.series[0];
					seriesCpu.addPoint([x, parseFloat(obj.cpu)], true, true);
					var seriesTemp = tempChart.series[0];
					seriesTemp.addPoint([x, parseFloat(obj.temp)], true, true);
					console.log("Cpu", obj, x);
				});
			}

			var cpuChart;
			var tempChart;
			$(document).ready(function() {
				var obj = JSON.parse('<?php include("api.php") ?>');
				cpuChart = new Highcharts.Chart({
					chart: {
						renderTo: 'cpu-container',
						defaultSeriesType: 'spline',
						marginRight: 1,
						type: 'spline'
					}, 
					title: {
						text: 'CPU Usage'
					},
					xAxis: {
						type: 'value',
						tickPixelInterval: 0
					},
					yAxis: {
						title: {
							text: 'Value'
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#F00'
						}]
					},
					tooltip: {
						formatter: function() {
				                return Math.round(this.y);
						}
					},
					plotOptions: {
						spline: {
							lineWidth: 3,
							states: {
								hover: {
									lineWidth: 5
								}
							},
							marker: {
								enabled: true,
								states: {
									hover: {
										enabled: true,
										symbol: 'circle',
										radius: 5,
										lineWidth: 1
									}
								}
							},
						}
					},
					legend: {
						enabled: false
					},
					exporting: {
						enabled: false
					}, 
					series: [{
						name: 'Cpu Utilization',
						color: "#33FF33",
						data: (function() {
							// generate an array of random data
							var data = [];
							for (i = -19; i <= 0; i++) {
							data.push({
								x: i,
								y: parseFloat(obj.cpu*100)
							});
							}

							return data;
						})()
					}]
				});				
				tempChart = new Highcharts.Chart({
					chart: {
						renderTo: 'temp-container',
						defaultSeriesType: 'spline',
						marginRight: 1,
						type: 'spline',
						events: {
							load: function() {
								plotCpu();
								setInterval(plotCpu, 3000);
							}
						}
					}, 
					title: {
						text: 'Temperature'
					},
					xAxis: {
						type: 'value',
						tickPixelInterval: 0
					},
					yAxis: {
						title: {
							text: 'Value'
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#F00'
						}]
					},
					tooltip: {
						formatter: function() {
				                return Math.round(this.y);
						}
					},
					plotOptions: {
						spline: {
							lineWidth: 3,
							states: {
								hover: {
									lineWidth: 5
								}
							},
							marker: {
								enabled: true,
								states: {
									hover: {
										enabled: true,
										symbol: 'circle',
										radius: 5,
										lineWidth: 1
									}
								}
							},
						}
					},
					legend: {
						enabled: false
					},
					exporting: {
						enabled: false
					}, 
					series: [{
						name: 'Temperature',
						color: '#FF3333',
						data: (function() {
							// generate an array of random data
							var data = [];
							for (i = -19; i <= 0; i++) {
							data.push({
								x: i,
								y: parseFloat(obj.temp)
							});
							}
							return data;
						})()
					}]
				});			
			});	
		</script>
	</body>
</html>