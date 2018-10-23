/**=========================================================
 * Module: demo-alerts.js
 * Provides a simple demo for pagination
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('AlertsController', AlertsController);
    /* @ngInject */
    function AlertsController() {
      var vm = this;
      vm.alerts = [
        { type: 'danger', msg: 'Oh snap! Change a few things up and try submitting again.' },
        { type: 'warning', msg: 'Well done! You successfully read this important alert message.' }
      ];

      vm.addAlert = function() {
        vm.alerts.push({msg: 'Another alert!'});
      };

      vm.closeAlert = function(index) {
        vm.alerts.splice(index, 1);
      };

    }

})();
