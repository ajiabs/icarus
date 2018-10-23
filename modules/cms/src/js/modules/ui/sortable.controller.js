/**=========================================================
 * Module: SortableController
 * Sortable controller
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('SortableController', SortableController);
    /* @ngInject */
    function SortableController($scope) {

      // Single List
      $scope.sortadata = [
        { id: 1, name: 'Deann Henderson' },
        { id: 2, name: 'Jackson Martinez' },
        { id: 3, name: 'Toni Kennedy' },
        { id: 4, name: 'Lorraine Martin' },
        { id: 5, name: 'Krin Stone' },
        { id: 6, name: 'Alvin Lynch' },
        { id: 7, name: 'Tiffany Hunter' }
      ];

      $scope.add = function () {
        $scope.sortadata.push({id: $scope.sortadata.length + 1, name: 'Ronnie Nelson'});
      };

      $scope.sortableCallback = function (sourceModel, destModel, start, end) {
        console.log(start + ' -> ' + end);
      };
      
      $scope.sortableOptions = {
          placeholder: '<div class="box-placeholder p0 m0"><div></div></div>',
          forcePlaceholderSize: true
      };

    }
    SortableController.$inject = ['$scope'];
})();
