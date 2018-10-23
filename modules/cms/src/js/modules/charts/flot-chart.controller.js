/**=========================================================
 * Module: FlotChartController.js
 * Initializes the flot chart plugin and attaches the 
 * plugin to elements according to its type
 =========================================================*/
/*jshint -W069*/
(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('FlotChartController', FlotChartController);
    
    FlotChartController.$inject = ['$scope', '$http', '$timeout', 'flotOptions', 'colors'];
    function FlotChartController($scope, $http, $timeout, flotOptions, colors) {
      var vm = this;
      // An array of boolean to tell the directive which series we want to show
      vm.areaSeries = [true, true, true];
      vm.chartAreaFlotChart       = flotOptions['area'];
      // The array should contain the same number of element as series
      vm.areaSplineSeries = [true, true];
      vm.chartSplineFlotChart     = flotOptions['spline'];
      // Create more array to target the sate of different series (lines, point, splines, etc)
      vm.lineSeriesPoints = [true, true, true];
      vm.lineSeriesLines  = [true, true, true];
      vm.MSLine       = angular.extend({}, flotOptions['line'], { yaxis: { max: 60 }});

      // Set directly our global configuration
      vm.MSColumn3D        = flotOptions['bar'];
      vm.MSCombiDY2D       = flotOptions['bar-stacked'];
      vm.MSPie        = flotOptions['pie'];
      vm.chartDonutFlotChart      = flotOptions['donut'];

      $scope.$on('plotReady', function(e, plot){
        // You can do here:
        //  plot                           Flot chart object
        //  plot.getData()                 REturns the dataset processed by the plugin
        //  plot.getPlaceholder()          The inner div where the chart is placed
        //  plot.getPlaceholder().parent() The <flot> element
      
      });

      // Setup realtime update
      // ----------------------------------- 

      vm.realTimeChartOpts = angular.extend({}, flotOptions['default'], {
        series: {
          lines: { show: true, fill: true, fillColor:  { colors: ['#00b4ff', '#1d93d9'] } },
          shadowSize: 0 // Drawing is faster without shadows
        },
        yaxis: {
          min: 0,
          max: 130
        },
        xaxis: {
          show: false
        },
        colors: ['#1d93d9']
      });

      vm.realTimeChartUpdateInterval = 30;

      var data = [],
          totalPoints = 300;
        
      update();

      function getRandomData() {
        if (data.length > 0)
          data = data.slice(1);
        // Do a random walk
        while (data.length < totalPoints) {
          var prev = data.length > 0 ? data[data.length - 1] : 50,
            y = prev + Math.random() * 10 - 5;
          if (y < 0) {
            y = 0;
          } else if (y > 100) {
            y = 100;
          }
          data.push(y);
        }
        // Zip the generated y values with the x values
        var res = [];
        for (var i = 0; i < data.length; ++i) {
          res.push([i, data[i]]);
        }
        return [res];
      }
      function update() {
        vm.realTimeChartData = getRandomData();
        $timeout(update, vm.realTimeChartUpdateInterval);
      }
    }

})();
