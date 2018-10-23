/**=========================================================
 * Module: RippleDirective.js
 * Adapted to support bootstrap components
 * Based on: https://github.com/nelsoncash/angular-ripple
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .directive('ripple', ripple);
    /* @ngInject */
    function ripple($timeout) {

      return {
        restrict: 'A',
        link: link
      };

      function link (scope, element, attrs) {
        var x, y, size, offsets;

        element.append('<span class="ripple"></span>');

        element.on('click touchstart', function(e) {
          var eventType = e.type;
          
          var rippleContainer = this.querySelector('.ripple');
          var ripple = rippleContainer.querySelector('.angular-ripple');

          // Ripple
          if (ripple === null) {
            // Create ripple
            ripple = document.createElement('span');
            ripple.className = 'angular-ripple';

            // Prepend ripple to element
            rippleContainer.insertBefore(ripple, rippleContainer.firstChild);

            // Set ripple size
            if (!ripple.offsetHeight && !ripple.offsetWidth) {
              size = Math.max(rippleContainer.offsetWidth, rippleContainer.offsetHeight);
              ripple.style.width = size + 'px';
              ripple.style.height = size + 'px';
            }
          }

          // create jqlite reference
          var $ripple = angular.element(ripple);
          // Remove animation effect
          $ripple.removeClass('animate');

          // get click coordinates by event type
          if (eventType === 'click') {
            x = e.pageX;
            y = e.pageY;
          } else if(eventType === 'touchstart') {
            x = e.changedTouches[0].pageX;
            y = e.changedTouches[0].pageY;
          }

          // set new ripple position by click or touch position
          function getPos(el) {
            for (var lx=0, ly=0; el !== null; lx += el.offsetLeft, ly += el.offsetTop, el = el.offsetParent);
            return {left: lx, top: ly};
          }

          offsets = offset( $ripple.parent()[0] );

          ripple.style.left = (x - offsets.left - size / 2) + 'px';
          ripple.style.top = (y - offsets.top - size / 2) + 'px';

          // Add animation effect
          $ripple.addClass('animate');
          
          $timeout(function(){
            $ripple.removeClass('animate');
          }, 500);

        });
      }

      // helpers
      function offset(el) {
        var rect = el.getBoundingClientRect();
        return {
          top: rect.top + document.body.scrollTop,
          left: rect.left + document.body.scrollLeft
        };
      }      
    }
    ripple.$inject = ['$timeout'];

})();
