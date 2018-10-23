/**=========================================================
 * Module: ImageCropController
 * Image crop controller
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('ImageCropController', ImageCropController);
    /* @ngInject */
    function ImageCropController($scope) {
      var vm = this;
      vm.reset = function() {
        vm.myImage        = '';
        vm.myCroppedImage = '';
        vm.imgcropType    = 'square';
      };

      vm.reset();

      var handleFileSelect=function(evt) {
        var file=evt.currentTarget.files[0];
        var reader = new FileReader();
        reader.onload = function (evt) {
          $scope.$apply(function($scope){
            vm.myImage=evt.target.result;
          });
        };
        if(file)
          reader.readAsDataURL(file);
      };
      
      angular.element(document.querySelector('#fileInput')).on('change',handleFileSelect);

    }
    ImageCropController.$inject = ['$scope'];
})();
