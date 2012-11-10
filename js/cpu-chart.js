var cpuChart;
$(document).ready(function() {
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
					y: parseFloat(obj.cpu)
				});
				}

				return data;
			})()
		}]
	});			
});