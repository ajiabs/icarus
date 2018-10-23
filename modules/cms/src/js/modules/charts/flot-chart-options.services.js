/**=========================================================
 * Module: FlotChartOptionsServices.js
 * Define here the common options for all types of charts
 * and access theme from any controller
 =========================================================*/
/*jshint -W069*/
(function() {
    'use strict';

    angular
        .module('icarusApp')
        .service('flotOptions', flotOptions);

    function flotOptions() {

      /* jshint validthis: true */
      var options = this;


      // Default
      // ----------------------------------- 
      options['default'] = {
        grid: {
          hoverable: true,
          clickable: true,
          borderWidth: 0,
          color: '#8394a9'
        },
        tooltip: true,
        tooltipOpts: {
          content: '%x : %y'
        },
        xaxis: {
          tickColor: '#f1f2f3',
          mode: 'categories'
        },
        yaxis: {
          tickColor: '#f1f2f3'
        },
        legend: {
          backgroundColor: 'rgba(0,0,0,0)'
        },
        shadowSize: 0
      };

      // Bar
      // ----------------------------------- 
      options['bar'] = angular.extend({}, options['default'], {
        series: {
          bars: {
            align: 'center',
            lineWidth: 0,
            show: true,
            barWidth: 0.6,
            fill: 1
          }
        }
      });

      // Bar Stacked
      // ----------------------------------- 
      options['bar-stacked'] = angular.extend({}, options['default'], {
        series: {
          bars: {
            align: 'center',
            lineWidth: 0,
            show: true,
            barWidth: 0.6,
            fill: 1,
            stacked: true
          }
        }
      });

      // Line
      // ----------------------------------- 
      options['line'] = angular.extend({}, options['default'], {
        series: {
          lines: {
            show: true,
            fill: 0.01
          },
          points: {
            show: true,
            radius: 4
          }
        }
      });

      // Spline
      // ----------------------------------- 
      options['spline'] = angular.extend({}, options['default'], {
        series: {
          lines: {
            show: false
          },
          splines: {
            show: true,
            tension: 0.4,
            lineWidth: 1,
            fill: 1
          },
        }
      });

      // Area
      // ----------------------------------- 
      options['area'] = angular.extend({}, options['default'], {      
        series: {
          lines: {
            show: true,
            fill: 1
          }
        }
      });

      // Pie
      // ----------------------------------- 
      options['pie'] = {
        series: {
          pie: {
            show: true,
            innerRadius: 0,
            label: {
              show: true,
              radius: 0.8,
              formatter: function (label, series) {
                return '<div class="flot-pie-label">' +
                //label + ' : ' +
                Math.round(series.percent) +
                '%</div>';
              },
              background: {
                opacity: 0.8,
                color: '#222'
              }
            }
          }
        }
      };

      // Donut
      // ----------------------------------- 
      options['donut'] = {
        series: {
          pie: {
            show: true,
            innerRadius: 0.5 // donut shape
          }
        }
      };

    }

})();
