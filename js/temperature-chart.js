var temperatureChart;
$(document).ready(function() {
	temperatureChart = new Highcharts.Chart({
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