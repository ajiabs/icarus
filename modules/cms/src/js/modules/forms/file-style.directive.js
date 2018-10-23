/**=========================================================
 * Module: filestyle.js
 * Initializes the fielstyle plugin
 =========================================================*/
(function() {
    'use strict';

    angular
        .module('icarusApp')
        .directive('filestyle', filestyle);
    
    function filestyle() {

      controller.$inject = ['$scope', '$element'];
      return {
        restrict: 'A',
        controller: controller
      };

      function controller($scope, $element) {
        var options = $element.data();
        
        // old usage support
          options.classInput = $element.data('classinput') || options.classInput;
        
        $element.filestyle(options);
      }
    }
})();
