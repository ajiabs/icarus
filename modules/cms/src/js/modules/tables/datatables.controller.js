/**=========================================================
 * Module: DataTablesController.js
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('DataTablesController', DataTablesController);
    DataTablesController.$inject = ['SweetAlert','$resource'];
    function DataTablesController(SweetAlert,$resource) {

      var vm = this;
      $resource('server/datatables.json').query().$promise.then(function(persons) {
          vm.persons = persons;
      });


       activate();

        ////////////////

        function activate() {
            vm.demo4 = function() {
            SweetAlert.swal({   
              title: "Are you sure?",   
              text: "Your will not be able to recover this imaginary file!",   
              type: "warning",   
              showCancelButton: true,   
              confirmButtonColor: "#DD6B55",   
              confirmButtonText: "Yes, delete it!",
              closeOnConfirm: false
            },  function(){  
              SweetAlert.swal("Booyah!");
            });
          }
        }


    }

   

})();
