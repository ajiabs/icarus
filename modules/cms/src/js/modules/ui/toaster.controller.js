/**=========================================================
 * Module: DemoToasterController.js
 * Demos for toaster notifications
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('ToasterController', ToasterController);
    /* @ngInject */
    function ToasterController(toaster) {
      var vm = this;
      vm.toaster = {
          type:  'success',
          title: 'Title',
          text:  'Message'
      };

      vm.pop = function() {
        toaster.pop(vm.toaster.type, vm.toaster.title, vm.toaster.text);
      };

    }
    ToasterController.$inject = ['toaster'];
})();
