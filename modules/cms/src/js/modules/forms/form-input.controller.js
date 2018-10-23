/**=========================================================
 * Module: FormInputController.js
 * Controller for input components
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('FormInputController', FormInputController);
    /* @ngInject */
    function FormInputController($scope) {

      var vm = this;

      // Datepicker
      // -----------------------------------

      vm.today = function() {
        vm.dt = new Date();
      };
      vm.today();

      vm.clear = function () {
        vm.dt = null;
      };

      // Disable weekend selection
      vm.disabled = function(date, mode) {
        return false; //( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
      };

      vm.toggleMin = function() {
        vm.minDate = vm.minDate ? null : new Date();
      };
      vm.toggleMin();

      vm.open = function($event) {
        $event.preventDefault();
        $event.stopPropagation();

        vm.opened = true;
      };

      vm.dateOptions = {
        formatYear: 'yy',
        startingDay: 1
      };

      vm.initDate = new Date('2016-15-20');
      vm.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
      vm.format = vm.formats[0];

      // Timepicker
      // -----------------------------------
      vm.mytime = new Date();

      vm.hstep = 1;
      vm.mstep = 15;

      vm.options = {
        hstep: [1, 2, 3],
        mstep: [1, 5, 10, 15, 25, 30]
      };

      vm.ismeridian = true;
      vm.toggleMode = function() {
        vm.ismeridian = ! vm.ismeridian;
      };

      vm.update = function() {
        var d = new Date();
        d.setHours( 14 );
        d.setMinutes( 0 );
        vm.mytime = d;
      };

      vm.changed = function () {
        console.log('Time changed to: ' + vm.mytime);
      };

      vm.clear = function() {
        vm.mytime = null;
      };

      // Summernote (wysiwyg)
      // -----------------------------------

      vm.htmlContent = '<h2>Try me!</h2><p>Summernote is a super cool WYSIWYG Text Editor directive for AngularJS</p>';

    }
    FormInputController.$inject = ['$scope'];

})();