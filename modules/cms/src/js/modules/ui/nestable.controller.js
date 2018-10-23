/**=========================================================
 * Module: nestable.js
 * Nestable controller
 =========================================================*/
(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('NestableController', NestableController);
    /* @ngInject */
    function NestableController() {
      var vm = this;
      vm.myNestable = {};
      vm.myNestable2 = {};

      vm.myNestable.onchange = function() {
        console.log('Nestable changed..');
      };


      vm.myNestable2.onchange = function() {
        vm.serialized = vm.myNestable2.serialize();
      };

    }

})();
