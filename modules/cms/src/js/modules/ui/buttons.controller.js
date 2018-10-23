/**=========================================================
 * Module: DemoButtonsController.js
 * Provides a simple demo for buttons actions
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('ButtonActionsController', ButtonActionsController);
    /* @ngInject */
    function ButtonActionsController($scope) {

      $scope.singleModel = 1;

      $scope.radioModel = 'Middle';

      $scope.checkModel = {
        left: false,
        middle: true,
        right: false
      };

    }
    ButtonActionsController.$inject = ['$scope'];
})();
