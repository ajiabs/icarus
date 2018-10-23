/**=========================================================
 * Module: LayerMorphService.js
 =========================================================*/


(function() {
    'use strict';

    angular
        .module('icarusApp')
        .service('LayerMorph', LayerMorph);
    /* @ngInject */
    function LayerMorph($window, support) {
        var $win  = angular.element($window),
            $body = angular.element( document.querySelector('body') ),
            self  = this;
        
        /* jshint -W004*/
        self.init         = init;
        self.ready        = ready;
        self.open         = open;
        self.close        = close;
        self.isActive     = isActive;
        self.isReady      = isReady;
        self.placeLayer   = placeLayer;
        self.attachResize = attachResize;

        ////////////////
        
        function init(){
          // find main elements
          self.container = angular.element( document.querySelector('.layer-morph-container') );
          self.inner     = angular.element( document.querySelector('.layer-morph-inner') );
          // attach event to re-position when screen resolution changes
          self.attachResize();
        }

        function ready(callback) {
          if ( support.transition.end ) {
            self.inner.on(support.transition.end, runEndTransition);
          }
          else {
            runEndTransition();
          }

          function runEndTransition() {
            // activate layers container
            self.container.addClass('active');
            // detach event
            self.inner.off(support.transition.end);
            // run user callback
            if(callback) callback();
          }

        }

        function open(element, target) {

          self.currentElement = element;
          // activate current element
          self.currentElement.addClass('active');

          if ( ! self.isActive() ) {
            // place layer coordinate
            self.placeLayer();

            self.ready(function(){
              // activate target
              target.addClass('active');
              self.isReady(true);
            });

            self.isActive(true);
          }
        }

        function close() {
          angular.element(document.querySelector('.layer-morph.active')).removeClass('active');
          self.container.removeClass('active');
          self.currentElement.removeClass('active');
          self.isReady(false);
          self.isActive(false);
        }

        function isActive(newState){
          // if no param return current state, else set new state
          $body[ (typeof newState === 'undefined') ? 'hasClass' :
            newState ? 'addClass' : 'removeClass']('layer-morph-active');
          $body[0].offsetWidth;
        }

        function isReady(newState){
          // if no param return current state, else set new state
          $body[ (typeof newState === 'undefined') ? 'hasClass' :
            newState ? 'addClass' : 'removeClass']('layer-morph-ready');
          $body[0].offsetWidth;
        }

        function placeLayer(){

          var element = self.currentElement;
          if(!element) return;
          
          // element offset
          var elOffset = offset(element[0]);
          // screen dimension
          var $winHeight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0),
              $winWidth  = Math.max(document.documentElement.clientWidth, window.innerWidth || 0),
              diameter   = (Math.sqrt( Math.pow($winHeight, 2) + Math.pow($winWidth, 2) ) * 2);

          self.inner
              .css('height', diameter+'px')
              .css('width', diameter+'px');

          elOffset.top = elOffset.top + ( outerHeight(element[0]) /2 ) - $window.pageYOffset;
          elOffset.left = elOffset.left + ( outerWidth(element[0]) /2 ) ;

          self.inner
              .css('top', (elOffset.top - self.inner[0].offsetHeight/2) +'px')
              .css('left', (elOffset.left - self.inner[0].offsetWidth/2) +'px');
        }

        function attachResize(){

          $win.on('resize', function(){
            self.placeLayer();
          });
        }
        // helpers
        function outerHeight(el) {
          var style = getComputedStyle(el);
          return el.offsetHeight + parseInt(style.paddingTop) + parseInt(style.paddingBottom);
        }
        function outerWidth(el) {
          var style = getComputedStyle(el);
          return el.offsetWidth + parseInt(style.paddingLeft) + parseInt(style.paddingRight);
        }
        function offset(el) {
          var rect = el.getBoundingClientRect();
          return {
            top: rect.top + document.body.scrollTop,
            left: rect.left + document.body.scrollLeft
          };
        }
    }
    LayerMorph.$inject = ['$window', 'support'];

})();