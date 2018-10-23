/**=========================================================
 * Module: DemoResponsiveTableController.js
 * Controller for responsive tables components
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('ResponsiveTableController', ResponsiveTableController);
    /* @ngInject */    
    function ResponsiveTableController(colors) {
      var vm = this;
      vm.sparkOps1 = {
        barColor: colors.byName('primary')
      };
      vm.sparkOps2 = {
        barColor: colors.byName('info')
      };
      vm.sparkOps3 = {
        barColor: colors.byName('amber')
      };

      vm.sparkData1 = [1,2,3,4,5,6,7,8,9];
      vm.sparkData2 = [1,2,3,4,5,6,7,8,9];
      vm.sparkData3 = [1,2,3,4,5,6,7,8,9];
    }
    ResponsiveTableController.$inject = ['colors'];

})();
