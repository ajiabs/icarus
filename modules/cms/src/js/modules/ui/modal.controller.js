/**=========================================================
 * Module: ModalController
 * Provides a simple way to implement bootstrap modals from templates
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('ModalController', ModalController);
    /* @ngInject */
    function ModalController($uibModal, $log) {
      var vm = this;
      vm.open = function (size) {

        var modalInstance = $uibModal.open({
          templateUrl: '/myModalContent.html',
          controller: ModalInstanceCtrl,
          size: size
        });

        var state = $('#modal-state');
        modalInstance.result.then(function () {
          state.text('Modal dismissed with OK status');
        }, function () {
          state.text('Modal dismissed with Cancel status');
        });
      };

      // Please note that $uibModalInstance represents a modal window (instance) dependency.
      // It is not the same as the $uibModal service used above.

      var ModalInstanceCtrl = function ($scope, $uibModalInstance) {

        $scope.ok = function () {
          $uibModalInstance.close('closed');
        };

        $scope.cancel = function () {
          $uibModalInstance.dismiss('cancel');
        };
      };
      ModalInstanceCtrl.$inject = ['$scope', '$uibModalInstance'];

    }
    ModalController.$inject = ['$uibModal', '$log'];
})();
