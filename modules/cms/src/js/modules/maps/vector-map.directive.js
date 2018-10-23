/**=========================================================
 * Module: VectorMapDirective
 * Init jQuery Vector Map plugin
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .directive('vectorMap', vectorMap);

    function vectorMap(){

      return {
        restrict: 'EA',
        scope: {
          mapOptions: '='
        },
        compile: compile
      };

      function compile(tElement, tAttrs, transclude) {
        return {
          post: function(scope, element) {
            var options     = scope.mapOptions,
                mapHeight   = options.height || '300';
            
            element.css('height', mapHeight);
            
            element.vectorMap(options);
          }
        };
      }

    }

})();
