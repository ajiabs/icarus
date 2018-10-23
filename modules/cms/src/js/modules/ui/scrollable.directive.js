/**=========================================================
 * Module: ScrollableDirective.js
 * Make a content box scrollable
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .directive('scrollable', scrollable);
    /* @ngInject */
    function scrollable() {
      return {
        restrict: 'EA',
        link: function(scope, elem, attrs) {
          var defaultHeight = 285;

          attrs.height = attrs.height || defaultHeight;

          elem.slimScroll(attrs);

        }
      };
    }

})();
