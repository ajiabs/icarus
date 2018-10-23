/**=========================================================
 * Module: DemoPopoverController.js
 * Provides a simple demo for popovers
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('PopoverController', PopoverController);
    /* @ngInject */
    function PopoverController() {
        var vm = this;
        vm.dynamicPopover = 'Hello, World!';
        vm.dynamicPopoverTitle = 'Title';

    }
})();
