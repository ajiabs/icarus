/**=========================================================
 * Module: FormValidationController.js
 * Controller for input validation using AngularUI Validate
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('FormValidationController', FormValidationController);
    /* @ngInject */
    function FormValidationController($scope) {
      
      this.notBlackListed = function(value) {
        var blacklist = ['bad@domain.com','verybad@domain.com'];
        return blacklist.indexOf(value) === -1;
      };

      this.words = function(value) {
        return value && value.split(' ').length;
      };
    }
    FormValidationController.$inject = ['$scope'];
})();
