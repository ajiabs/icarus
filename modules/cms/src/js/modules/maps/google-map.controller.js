/**=========================================================
 * Module: GoogleMapController.js
 * Google Map plugin controller
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('GoogleMapController', GoogleMapController);
    /* @ngInject */
    function GoogleMapController($timeout) {
      var vm = this;
      vm.myMarkers = [];
     
      vm.mapOptions = {
        center: new google.maps.LatLng(35.784, -78.670),
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };
       
      vm.addMarker = function($event, $params) {
        vm.myMarkers.push(new google.maps.Marker({
          map: vm.myMap,
          position: $params[0].latLng
        }));
      };
       
      vm.setZoomMessage = function(zoom) {
        vm.zoomMessage = 'You just zoomed to '+zoom+'!';
        console.log(zoom,'zoomed');
      };
       
      vm.openMarkerInfo = function(marker) {
        vm.currentMarker = marker;
        vm.currentMarkerLat = marker.getPosition().lat();
        vm.currentMarkerLng = marker.getPosition().lng();
        vm.myInfoWindow.open(vm.myMap, marker);
      };
       
      vm.setMarkerPosition = function(marker, lat, lng) {
        marker.setPosition(new google.maps.LatLng(lat, lng));
      };

      vm.refreshMap = function() {
        
        $timeout(function(){
          google.maps.event.trigger(vm.myMap, 'resize');
        }, 100);

      };

    }
    GoogleMapController.$inject = ['$timeout'];
})();
