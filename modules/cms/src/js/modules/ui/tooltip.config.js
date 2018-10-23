/**=========================================================
 * Module: TooltipConfig.js
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .config(tooltipConfig);
    /* @ngInject */
    function tooltipConfig($tooltipProvider) {

      $tooltipProvider.options({
        appendToBody: true
      });

    }
    tooltipConfig.$inject = ['$tooltipProvider'];

})();
