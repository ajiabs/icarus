/**=========================================================
 * Module: CardsController.js
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('CardsController', CardsController);
    
    CardsController.$inject = ['$scope', 'colors', 'flotOptions'];
    function CardsController($scope, colors, flotOptions) {
      var vm = this;
      // KNOB Charts
      // ----------------------------------- 

      vm.knobLoaderData1 = 75;
      vm.knobLoaderOptions1 = {
          width: '60%', // responsive
          displayInput: true,
          readOnly : true,
          thickness : 0.4,
          angleArc: 250,
          angleOffset: -125,
          inputColor : colors.byName('gray-dark'),
          fgColor: colors.byName('info'),
          bgColor: colors.byName('gray-light')
        };

      vm.knobLoaderData2 = 50;
      vm.knobLoaderOptions2 = {
          width: '60%', // responsive
          displayInput: true,
          readOnly : true,
          thickness : 0.4,
          angleArc: 250,
          angleOffset: -125,
          inputColor : colors.byName('gray-dark'),
          fgColor: colors.byName('purple'),
          bgColor: colors.byName('gray-light')
        };

      // Small line chart
      // ----------------------------------- 

      vm.smallChartOpts = angular.extend({}, flotOptions['default'], {
        points: {
          show: true,
          radius: 1
        },
        series: {
          lines: {
            show: true,
            fill: 1,
            lineWidth: 1,
            fillColor: { colors: [ { opacity: 0.4 }, { opacity: 0.4 } ] }
          }
        },
        grid: {
            show: false
        },
        legend: {
            show: false
        },
        xaxis: {
            tickDecimals: 0
        }
      });

      vm.smallChartData1 = [{
        'label': '',
        'color': colors.byName('success'),
        'data': [
          ['1', 8],['2', 10],['3', 12],['4', 13],['5', 13],['6', 12],['7', 11],['8', 10],['9', 9],['10', 8],['11', 8],['12', 9],['13', 10],['14', 9],['15', 8]
        ]
      }];
      vm.smallChartData2 = [{
        'label': '',
        'color': colors.byName('warning'),
        'data': [
          ['1', 9],['2', 10],['3', 9],['4', 11],['5', 12],['6', 11],['7', 10],['8', 9],['9', 8],['10', 8],['11', 8],['12', 10],['13', 12],['14', 13],['15', 13]
        ]
      }];

      // Spline chart
      vm.areaSplineSeries = [true, true];
      vm.splineChartOpts = angular.extend({}, flotOptions['default'], {
        legend: {
          show: false
        },
        grid: {
           borderWidth: 0,
           minBorderMargin: 0,
           aboveData: true,
           color: colors.byName('info'),
           margin: {
              top: 10,
              right: 0,
              bottom: 0,
              left: 0
            }
        },
        series: {
          lines: {
            show: false
          },
          splines: {
            show: true,
            tension: 0.4,
            lineWidth: 2,
            fill: 0.5
          },
        },
        yaxis: {max: 120, show: false},
        xaxis: {
          tickColor: 'transparent',
          mode: 'categories',
          reserveSpace: false
        }
      });

      // Using a function to regenerate chart based on selected theme
      vm.splineData = getSplineData();

      function getSplineData() {
        return [{
          'label': 'Sales',
          'color': '#fff',
          'data': [
            ['Mar', 50],['Apr', 81],['May', 61],['Jun', 91],['Jul', 66],['Aug', 97],['Sep', 51]
          ]
        }];
      }
      // when theme change we run the function again
      $scope.$watch('app.theme.name', function(val) {
        vm.splineData = getSplineData();
      });


      // Large Flot spline chart
      vm.splineOptions2 =  {
        grid: {
          hoverable: true,
          clickable: true,
          borderWidth: 0,
          color: '#fff'
        },
        tooltip: true,
        tooltipOpts: {
          content: function (label, x, y) { return x + ' : ' + y; }
        },
        xaxis: {
          tickColor: 'transparent',
          mode: 'categories'
        },
        yaxis: {
          tickColor: 'transparent',
          max: 70,
          show: false
        },
        legend: {
          show: false
        },
        shadowSize: 0,
        series: {
          splines: {
            show: true,
            tension: 0.4,
            lineWidth: 2,
            fill: 0.4
          },
          points: {
            show: true
          }
        }
      };

      // Sparkline
      // ----------------------------------- 
      
      vm.sparkValues = [1,3,4,7,5,9,4,4,7,5,9,6,4];
      vm.sparkOptions = {
        chartRangeMin: 0,
        type:               'line',
        height:             '70',
        width:              '100%',
        lineWidth:          '2',
        lineColor:          colors.byName('white'),
        spotColor:          '#888',
        minSpotColor:       colors.byName('white'),
        maxSpotColor:       colors.byName('white'),
        fillColor:          '',
        highlightLineColor: '#fff',
        spotRadius:         '3',
        resize:             'true'
      };


    }
})();
