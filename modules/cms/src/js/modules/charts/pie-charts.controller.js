/**=========================================================
 * Module: PieChartController.js
 =========================================================*/
/*jshint -W069*/
(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('PieChartController', PieChartController);
    
    PieChartController.$inject = ['colors'];
    function PieChartController(colors) {
      var vm = this;
      // Easy Pie Charts
      // ----------------------------------- 


      vm.piePercent1 = 75;
      vm.piePercent2 = 50;
      vm.piePercent3 = 10;
      vm.piePercent4 = 95;

      vm.pieOptions = {
          animate:{
              duration: 700,
              enabled: true
          },
          barColor: colors.byName('info'),
          // trackColor: colors.byName('inverse'),
          scaleColor: false,
          lineWidth: 10,
          lineCap: 'circle'
      };

      vm.pieOptions1 = {
          animate:{
              duration: 700,
              enabled: true
          },
          barColor: colors.byName('info'),
          // trackColor: colors.byName('inverse'),
          scaleColor: false,
          lineWidth: 4,
          lineCap: 'circle'
      };

      vm.pieOptions2 = {
          animate:{
              duration: 700,
              enabled: true
          },
          barColor: colors.byName('purple'),
          trackColor: false,
          scaleColor: colors.byName('gray'),
          lineWidth: 15,
          lineCap: 'circle'
      };

      vm.randomize = function(type) {
        if ( type === 'easy') {
          vm.piePercent1 = random();
          vm.piePercent2 = random();
          vm.piePercent3 = random();
          vm.piePercent4 = random();
        }
        if ( type === 'knob') {
          vm.knobLoaderData1 = random();
          vm.knobLoaderData2 = random();
          vm.knobLoaderData3 = random();
          vm.knobLoaderData4 = random();
        }
      }

      function random() { return Math.floor((Math.random() * 100) + 1); }

      // KNOB Charts
      // ----------------------------------- 

      vm.knobLoaderData1 = 100;
      vm.knobLoaderOptions1 = {
          width: '50%', // responsive
          displayInput: true,
          fgColor: colors.byName('primary')
        };

      vm.knobLoaderData2 = 50;
      vm.knobLoaderOptions2 = {
          width: '50%', // responsive
          displayInput: true,
          fgColor: colors.byName('success'),
          readOnly : true,
          lineCap : 'round'
        };

      vm.knobLoaderData3 = 37;
      vm.knobLoaderOptions3 = {
          width: '50%', // responsive
          displayInput: true,
          fgColor: colors.byName('purple'),
          displayPrevious : true,
          thickness : 0.1
        };

      vm.knobLoaderData4 = 60;
      vm.knobLoaderOptions4 = {
          width: '50%', // responsive
          displayInput: true,
          fgColor: colors.byName('danger'),
          bgColor: colors.byName('warning'),
          angleOffset: -125,
          angleArc: 250
        };

    }

})();
