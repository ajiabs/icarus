/**=========================================================
 * Module: TasksController
 * Controller for the Tasks APP
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('TasksController', TasksController);
    /* @ngInject */
    function TasksController($scope, $filter, $uibModal) {
      var vm = this;

      vm.taskEdition = false;

      vm.tasksList = [
        {
          task: {title: 'Solve issue #5487', description: 'Praesent ultrices purus eget velit aliquet dictum. '},
          complete: true
        },
        {
          task: {title: 'Commit changes to branch future-dev.', description: ''},
          complete: false
        }
        ];


      vm.addTask = function(theTask) {

        if( theTask.title === '' ) return;
        if( !theTask.description ) theTask.description = '';

        if( vm.taskEdition ) {
          vm.taskEdition = false;
        }
        else {
          vm.tasksList.push({task: theTask, complete: false});
        }
      };

      vm.editTask = function(index, $event) {

        $event.stopPropagation();
        $event.preventDefault();
        vm.modalOpen(vm.tasksList[index].task);
        vm.taskEdition = true;
      };

      vm.removeTask = function(index, $event) {
        vm.tasksList.splice(index, 1);
      };

      vm.clearAllTasks = function() {
        vm.tasksList = [];
      };

      vm.totalTasksCompleted = function() {
        return $filter('filter')(vm.tasksList, function(item){
          return item.complete;
        }).length;
      };

      vm.totalTasksPending = function() {
        return $filter('filter')(vm.tasksList, function(item){
          return !item.complete;
        }).length;
      };


      // modal Controller
      // -----------------------------------

      vm.modalOpen = function (editTask) {
        var modalInstance = $uibModal.open({
          templateUrl: '/myModalContent.html',
          controller: ModalInstanceCtrl,
          scope: $scope,
          resolve: {
            editTask: function() {
              return editTask;
            }
          }
        });

        modalInstance.result.then(function () {
          // Modal dismissed with OK status
        }, function () {
          // Modal dismissed with Cancel status'
        });

      };

      // Please note that $uibModalInstance represents a modal window (instance) dependency.
      // It is not the same as the $uibModal service used above.

      var ModalInstanceCtrl = function ($scope, $uibModalInstance, editTask) {

        $scope.theTask = editTask || {};

        $scope.modalAddTask = function (task) {
          vm.addTask(task);
          $uibModalInstance.close('closed');
        };

        $scope.modalCancel = function () {
          vm.taskEdition = false;
          $uibModalInstance.dismiss('cancel');
        };

        $scope.actionText = function() {
          return vm.taskEdition ? 'Edit Task' : 'Add Task';
        };
      };
      ModalInstanceCtrl.$inject = ['$scope', '$uibModalInstance', 'editTask'];

    }
    TasksController.$inject = ['$scope', '$filter', '$uibModal'];

})();
