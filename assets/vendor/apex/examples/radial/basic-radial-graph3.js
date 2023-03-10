var options = {
	chart: {
		height: 305,
		type: 'radialBar',
	},
	plotOptions: {
		radialBar: {
			dataLabels: {
				name: {
					fontSize: '22px',
				},
				value: {
					fontSize: '16px',
				},
				total: {
					show: true,
					label: 'Source',
					formatter: function (w) {
						// By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
						return '2500'
					}
				}
			}
		}
	},
	series: [90, 80, 70, 60, 50],
	labels: ['Direct', 'Email', 'Referral', 'Google', 'Others'],
	colors: ['#aa0000', '#cc0000', '#ee0000', '#ff3333', '#ff7777'],
}

var chart = new ApexCharts(
	document.querySelector("#basic-radial-graph3"),
	options
);
chart.render();