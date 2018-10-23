/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

icarusApp.service('commonService',function($http){
  //General function for Ajax call
    this.callAjax = function(request){
        //var type  = request.type?request.type:true;
        request.type = (request.type == undefined)?true:request.type;
       // console.log( request.data);
        var promise = $http({
                method  : request.method,
                url     : request.url,
                params    : request.data,
                async   : request.type?request.type:false
                /*contentType : "application/json",
                cache   : request.cache?request.cache:false  */       
             }).then(function (response) {
                // The then function here is an opportunity to modify the response
               // console.log(response);
                // The return value gets picked up by the then in the controller.
                return response;
            });
        return promise;
    }


    

    //General function for loader
    this.initLoader = function($scope){
        $scope.loading = true;
        $scope.responseShow = false;
        $scope.responseMessage = ''
    }
     //General function for loader
    this.hideLoader = function($scope){
        $scope.loading = false;
        $scope.responseMessage = '';
    }

    //General function for success message
    this.showResponse = function($scope,message,status){
        $scope.loading = false;
        //$scope.responseShow = true;
        //$scope.responseMessage = message;
        if(message && message != 'undefined')
            showToastMessage(message, status);

    }

     //General function for loader
    this.initCenterLoader = function($scope){
        $scope.loading = true;
        $scope.responseShow = false;
        $scope.responseMessage = ''
        
    }

    //General function for success message
    this.resetForm = function(form){
        angular.forEach(form, function(value,key){
           
        });
    }

        
});



icarusApp.constant('MEDIA_QUERY', {
      'desktopLG': 1200,
      'desktop':   992,
      'tablet':    768,
      'mobile':    480
});

