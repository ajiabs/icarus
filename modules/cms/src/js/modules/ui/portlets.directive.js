/**=========================================================
 * Module: PortletsController.js
 * Drag and drop any panel based on jQueryUI portlets
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .directive('portlet', portlet);
    /* @ngInject */
    function portlet ($timeout) {
      var storageKeyName = 'portletState';
      var $scope;

      return {
        restrict: 'A',
        link: link
      };

      /////////////

      function link(scope, element, attrs) {
          
        $scope = scope;

        // Component is not optional
        if(!$.fn.sortable) return;

        element.sortable({
          connectWith:          '[portlet]',
          items:                'div.panel',
          handle:               '.portlet-handler',
          opacity:              0.7,
          placeholder:          'portlet box-placeholder',
          cancel:               '.portlet-cancel',
          forcePlaceholderSize: true,
          iframeFix:            false,
          tolerance:            'pointer',
          helper:               'original',
          revert:               200,
          forceHelperSize:      true,
          update:               savePortletOrder,
          create:               loadPortletOrder
        });

      }


      function savePortletOrder(event, ui) {
        var self = event.target;
        var data = $scope.$storage[storageKeyName];
        
        if(!data) { data = {}; }

        data[self.id] = $(self).sortable('toArray');

        if(data) {
          $timeout(function() {
            $scope.$storage[storageKeyName] = data;
          });
        }
      }

      function loadPortletOrder(event) {
        var self = event.target;
        var data = $scope.$storage[storageKeyName];

        if(data) {
          
          var porletId = self.id,
              panels   = data[porletId];

          if(panels) {
            var portlet = $('#'+porletId);
            
            $.each(panels, function(index, value) {
               $('#'+value).appendTo(portlet);
            });
          }

        }
      }

    }
    portlet.$inject = ['$timeout'];
})();
 