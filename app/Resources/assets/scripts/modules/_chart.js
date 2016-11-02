/**
 * Structure par défaut de tout nouveau module
 */

module.exports = function(context){

	"use strict";

	require('chart');

	function doughtChart(){
        var ctx = document.getElementById("myChart");
        var data = {
            labels: [
                "Red",
                "Blue",
                "Yellow"
            ],
            datasets: [
                {
                    data: [300, 50, 100],
                    backgroundColor: [
                        "#FF6384",
                        "#36A2EB",
                        "#FFCE56"
                    ],
                    hoverBackgroundColor: [
                        "#FF6384",
                        "#36A2EB",
                        "#FFCE56"
                    ]
                }]
        };
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
		

	}
	

	function init(){
		doughtChart();
	}

	return {
		ready : init
	}

};