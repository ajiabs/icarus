/**=========================================================
 * Module: AngularTableController.js
 * Controller for ngTables
 =========================================================*/
/*jshint -W055*/
(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('AngularTableController', AngularTableController);
    /* @ngInject */
    function AngularTableController($scope, $filter, ngTableParams) {

      var vm = this;

      // SORTING
      // ----------------------------------- 

      var data = [
          {name: 'Moroni',  age: 50, money: -10   },
          {name: 'Tiancum', age: 43, money: 120   },
          {name: 'Jacob',   age: 27, money: 5.5   },
          {name: 'Nephi',   age: 29, money: -54   },
          {name: 'Enos',    age: 34, money: 110   },
          {name: 'Tiancum', age: 43, money: 1000  },
          {name: 'Jacob',   age: 27, money: -201  },
          {name: 'Nephi',   age: 29, money: 100   },
          {name: 'Enos',    age: 34, money: -52.5 },
          {name: 'Tiancum', age: 43, money: 52.1  },
          {name: 'Jacob',   age: 27, money: 110   },
          {name: 'Nephi',   age: 29, money: -55   },
          {name: 'Enos',    age: 34, money: 551   },
          {name: 'Tiancum', age: 43, money: -1410 },
          {name: 'Jacob',   age: 27, money: 410   },
          {name: 'Nephi',   age: 29, money: 100   },
          {name: 'Enos',    age: 34, money: -100  }
      ];

      vm.tableParams = new ngTableParams({
          page: 1,            // show first page
          count: 10,          // count per page
          sorting: {
              name: 'asc'     // initial sorting
          }
      }, {
          total: data.length, // length of data
          getData: function($defer, params) {
              // use build-in angular filter
              var orderedData = params.sorting() ?
                      $filter('orderBy')(data, params.orderBy()) :
                      data;
      
              $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
          }
      });

      // FILTERS
      // ----------------------------------- 

      vm.tableParams2 = new ngTableParams({
          page: 1,            // show first page
          count: 10,          // count per page
          filter: {
              name: '',
              age: ''
              // name: 'M'       // initial filter
          }
      }, {
          total: data.length, // length of data
          getData: function($defer, params) {
              // use build-in angular filter
              var orderedData = params.filter() ?
                     $filter('filter')(data, params.filter()) :
                     data;

              vm.users = orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());

              params.total(orderedData.length); // set total for recalc pagination
              $defer.resolve(vm.users);
          }
      });

      // SELECT ROWS
      // ----------------------------------- 

      vm.data = data;

      vm.tableParams3 = new ngTableParams({
          page: 1,            // show first page
          count: 10          // count per page
      }, {
          total: data.length, // length of data
          getData: function ($defer, params) {
              // use build-in angular filter
              var filteredData = params.filter() ?
                      $filter('filter')(data, params.filter()) :
                      data;
              var orderedData = params.sorting() ?
                      $filter('orderBy')(filteredData, params.orderBy()) :
                      data;

              params.total(orderedData.length); // set total for recalc pagination
              $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
          }
      });

      vm.changeSelection = function(user) {
          // console.info(user);
      };

      // EXPORT CSV
      // -----------------------------------  

      var data4 = [{name: 'Moroni', age: 50},
          {name: 'Tiancum', age: 43},
          {name: 'Jacob', age: 27},
          {name: 'Nephi', age: 29},
          {name: 'Enos', age: 34},
          {name: 'Tiancum', age: 43},
          {name: 'Jacob', age: 27},
          {name: 'Nephi', age: 29},
          {name: 'Enos', age: 34},
          {name: 'Tiancum', age: 43},
          {name: 'Jacob', age: 27},
          {name: 'Nephi', age: 29},
          {name: 'Enos', age: 34},
          {name: 'Tiancum', age: 43},
          {name: 'Jacob', age: 27},
          {name: 'Nephi', age: 29},
          {name: 'Enos', age: 34}];

      vm.tableParams4 = new ngTableParams({
          page: 1,            // show first page
          count: 10           // count per page
      }, {
          total: data4.length, // length of data4
          getData: function($defer, params) {
              $defer.resolve(data4.slice((params.page() - 1) * params.count(), params.page() * params.count()));
          }
      });

    }
    AngularTableController.$inject = ['$scope', '$filter', 'ngTableParams'];

})();

