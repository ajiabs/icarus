/*==========================================================
    Author      : Remya M R
    Date Created: 23 Aug 2016
    Description : Controller to handle List page
    Change Log
    s.no      date    author     description
 ===========================================================*/
var icarusApp = angular.module('icarusApp', ['datatables','ngIdle','ngMaterial','ngRoute','ngAnimate','ngSanitize','summernote','ui.bootstrap','ui.router','ui.select','angularUtils.directives.dirPagination']);
icarusApp.config(function($routeProvider,IdleProvider, KeepaliveProvider) {

  IdleProvider.idle(5000); // 15 min
  IdleProvider.timeout(5);
  KeepaliveProvider.interval(5000); // heartbeat every 10 min
  //KeepaliveProvider.http('/../cms'); // URL that makes sure session is alive

    $routeProvider
			// route for the home page
			.when('/', {
				templateUrl : '/dashboard.html',
				controller  : 'sectionlistController'
			})

			.when('/dashboard', {
				templateUrl : '/dashboard.html',
				controller  : 'sectionlistController'
			})

  		.when('/:name*', {
            templateUrl: function(urlattr){
                return  MAIN_URL+'modules/cms/view/script/cms/detail.php?section=' + urlattr.name;
                //return  MAIN_URL+'modules/cms/'+VIEW+'/script/cms/detail.php?section=' + urlattr.name;
            },
            controller  : 'sectionlistController'
			});

  			//.otherwise({ redirectTo: '/' });
});



icarusApp.run(function($rootScope, Idle) {
  Idle.watch();
  $rootScope.$on('IdleStart', function() { /* Display modal warning or sth */ });
  $rootScope.$on('IdleTimeout', function() {
    var logouturl = MAIN_URL+'cms/cms/logout';
    window.location.href = logouturl;/* Logout user */
  });


});
icarusApp.directive('onFinishRender', function ($timeout) {
   return {
       restrict: 'A',
       link: function (scope, element, attr) {

           if (scope.$last === true) {

               //$timeout(function () {
                   scope.$emit(attr.onFinishRender);
               //},10);
           }
       }
   }
});
icarusApp.directive("fileread", ['$rootScope',function ($rootScope) {
    return {
        scope: {
            fileread: "="
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
                var reader = new FileReader();
                reader.onload = function (loadEvent) {
                    scope.$apply(function () {
                    $rootScope.fileread = changeEvent.target.files[0];
                    });
                }
                reader.readAsDataURL(changeEvent.target.files[0]);
            });
        }
    }
}]);

icarusApp.directive('validFile',function(){
  return {
    require:'ngModel',
    link:function(scope,el,attrs,ngModel){
      //change event is fired when file is selected
      el.bind('change',function(){
        scope.$apply(function(){
          ngModel.$setViewValue(el.val());
          ngModel.$render();
        })
      })
    }
  }
});

/*
icarusApp.directive('fileValid', function () {
    return {
        require: 'ngModel',
        link: function (scope, el, attrs, ngModel) {
            ngModel.$render = function () {
                ngModel.$setViewValue(el.val());
            };

            el.bind('change', function () {
                scope.$apply(function () {
                    ngModel.$render();
                });
            });
        }
    };
});  */

icarusApp.directive('file', function() {
    return {
        restrict: 'E',
        template: '<input type="file" />',
        replace: true,
        require: 'ngModel',
        link: function(scope, element, attr, ctrl) {
            var listener = function() {
                scope.$apply(function() {
                    attr.multiple ? ctrl.$setViewValue(element[0].files) : ctrl.$setViewValue(element[0].files[0]);
                });
            }
            element.bind('change', listener);
        }
    }
});

icarusApp.directive('stringToNumber', function() {
  return {
    require: 'ngModel',
    link: function(scope, element, attrs, ngModel) {
      ngModel.$parsers.push(function(value) {
        return '' + value;
      });
      ngModel.$formatters.push(function(value) {
        return parseFloat(value);
      });
    }
  };
});




icarusApp.directive('navMenu', function($location) {
   return function(scope, element, attrs) {


    };
});

 icarusApp.directive('fileModel', ['$parse','$rootScope', function ($parse,$rootScope) {
    var validFormats = ["gif","jpg", "jpeg", "png","bmp"];
     $rootScope.myFile = [];
        return {
           restrict: 'A',
            //require: 'ngModel',
           link: function(scope, element, attrs, ngModel) {
             //console.log(attrs);
           /*  ngModel.$render = function () {
                ngModel.$setViewValue(element.val());
            };
*/
              var model = $parse(attrs.fileModel);
              var modelSetter = model.assign;
              element.bind('change', function(changeEvent){

              	 var value = element.val();
                  ext = value.substring(value.lastIndexOf('.') + 1).toLowerCase();
                  //console.log(validFormats.indexOf(ext));
                  //  return validFormats.indexOf(ext) !== -1;
                  //alert("Format"+validFormats.indexOf(ext));
                  //alert("Size = "+element[0].files[0].size);
                  if (validFormats.indexOf(ext) === -1) {
                  $('#fileerror').html("Please upload files having extensions: <b>" + validFormats.join(', ') + "</b> only.");
                  return false;
                } else if(element[0].files[0].size > 1000000){ //307200
                     $('#fileerror').html("Please upload files having size less than 1 MB.");
                  return false;
                  }

                  else{

                    $('#fileerror').html("");
                    //$(".removedv").hide();
                    var imgDiv = $(this).parent().find('.dvPreview');
                    var imgDivRm = $(this).parent().find('.removedv');
                    var imgDivVal = $(this).parent().find('.form-controlfileeval');
                   // var imgDivValtext = $(this).parent().find('.form-controlfileevaltext');
                    $(imgDiv).html("");
                    $(imgDivVal).html("");
                    //$(imgDivValtext).html("");
                    scope.$apply(function(){
                      //  ngModel.$render();
                     // console.log(element[0].files[0]);

                       $(imgDiv).show();
                       var imgT = imgDiv.parent().prev().prev().find('.thumbnails');
                       $(imgT).hide();



                        // $("#dvPreview img").attr("src", element[0].files[0].name);
                        var n = attrs.number;
                        var reader = new FileReader();
                        reader.readAsDataURL(element[0].files[0]);
                        reader.onload = function (e) {
                         var strext = element[0].files[0].type;
                        var resext = strext.split("/");
                          if(resext[0] == "image"){
                             $(imgDiv).append("<img width='100px' height='100px'/> ");
                             $(imgDiv).find('img').attr("src", e.target.result);
                             $(imgDivRm).show();
                             $(imgDivVal).val(element[0].files[0].name);
                          }else{

                          }

                        //var files = $(imgDivValtext).val(changeEvent.target.files[0]);
                        }
                      //modelSetter(scope, element[0].files[0]);
                     // $rootScope.myFile[] = element[0].files[0];
                      // $rootScope.myFile[n].push(element[0].files[0]);
                      // scope.imgdata[n].push(element[0].files[0]);
                     //  $rootScope.myFile.push({no: n, file:element[0].files[0]});
                      // scope.imgdata.push({no: n, file:element[0].files[0]});
                      var bFlag = false;

                      if($rootScope.myFile.length>0){

                      for(var _i=0; _i< $rootScope.myFile.length ; _i++){
                        if($rootScope.myFile[_i].no == n ){
                            var bNo = _i;
                            bFlag = true;
                        }

                      }

                        if(bFlag){
                          $rootScope.myFile[bNo].file = element[0].files[0];
                        }  else {

                          $rootScope.myFile.push({no: n, file:element[0].files[0]});
                        }


                    }else{

                        $rootScope.myFile.push({no: n, file:element[0].files[0]});
                    }


                   });
                  }
              });
           }
        };
}]);



icarusApp.service('fileUpload', ['$http', function ($http) {
        this.uploadFileToUrl = function(file, uploadUrl,funcCb){
           var fd = new FormData();
           fd.append('file', file);
           $http.post(uploadUrl, fd, {
              transformRequest: angular.identity,
              headers: {'Content-Type': undefined}
           })
           .success(function(d){
              funcCb('success');
           })
           .error(function(d){
              funcCb('fail');
           });
        }
}]);


icarusApp.service('filelogoUpload', ['$http', function ($http,$scope) {
      this.uploadFileToUrl = function(file, uploadUrl, settings, section){
      var fd = new FormData();
      fd.append('file', file);

       $http.post(uploadUrl, fd, {
          transformRequest: angular.identity,
          headers: {'Content-Type': undefined}
       })

        .success(function(logoimg){
          $('#blah').attr('src', MAIN_URL+'project/files/'+logoimg);
          var surl = MAIN_URL+'cms/cms/settings';
            $http({
            method: 'post',
            url: surl,
            data: $.param({'settings' : settings, 'logofile': logoimg, 'submit': 'Save' , 'section' : section}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).
            success(function(data, status, headers, config) {
              if(data.success){
              //console.log(data);
                jQuery('.alert-success-div > p').html(data.message);
                jQuery('.alert-success-div').show();
                jQuery('.alert-success-div').delay(5000).slideUp(function(){
                jQuery('.alert-success-div > p').html('');
              });
              }else{
                jQuery('.alert-failure-div > p').html(data.message);
                jQuery('.alert-failure-div').show();
                jQuery('.alert-failure-div').delay(5000).slideUp(function(){
                jQuery('.alert-failure-div > p').html('');
                });
              }
            }).
            error(function(data, status, headers, config) {
            });
        })
      .error(function(logoimg){
      });
        }
}]);



icarusApp.service('filecmslogoUpload', ['$http', function ($http,$scope) {
        this.uploadFileToUrl = function(file, uploadUrl, settings, settings2, section){
         var fd = new FormData();
         fd.append('file', file);

         $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
         })

         .success(function(logoimg){
         	$('#blah').attr('src', MAIN_URL+'project/files/'+logoimg);
        // 	console.log(logoimg);
         	var surl = MAIN_URL+'cms/cms/settings';
      		$http({
      	      method: 'post',
      	      url: surl,
      	      data: $.param({'settings' : settings, 'settings2' : settings2, 'logofile': logoimg, 'submit': 'Save' , 'section' : section}),
      	      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      	    }).
		      success(function(data, status, headers, config) {
		    	if(data.success){
		    		jQuery('.alert-success-div > p').html(data.message);
  					jQuery('.alert-success-div').show();
  					jQuery('.alert-success-div').delay(5000).slideUp(function(){
						jQuery('.alert-success-div > p').html('');
					});
		    	}else{
            jQuery('.alert-failure-div > p').html(data.message);
            jQuery('.alert-failure-div').show();
            jQuery('.alert-failure-div').delay(5000).slideUp(function(){
            jQuery('.alert-failure-div > p').html('');
					});
		    	}
		    }).
		    error(function(data, status, headers, config) {
		    });
 })
    .error(function(logoimg){
               });
        }
}]);


icarusApp.controller('sectionlistController', function($scope, $http, $compile, $mdDialog, $location ,$uibModal, sectionService, $rootScope, $window, $timeout, MEDIA_QUERY, flotOptions, colors ,fileUpload, filelogoUpload, filecmslogoUpload, Idle, Keepalive) {
	$scope.message = 'Look! I am an list page.';
	$scope.status = '  ';
 	$scope.customFullscreen = false;
 	$scope.headerMenuCollapsed = true;
	$scope.imgdata = [];
 	$scope.menus = [];
	$scope.lists = [];
	$scope.tempUser = {};
	$scope.tempDetails = {};
	$scope.editMode = false;
	$scope.index = '';
	$scope.orderByField = '';
	$scope.reverseSort = false;
  $scope.placeholder = "Search";

	//$rootScope.myFile = [];
	$rootScope.fileread = [];
        $scope.version = 0;

    //$scope.form = {type : $scope.typeOptions[0].value};
    $scope.currentPage = 1;
   /* $scope.pagination = {
    currentPage:  1
    };*/
    $scope.pageSize = 25;
    //$scope.onMobile();
    $scope.sourceSrcArr = [];
    // text editor options start
    /* $scope.editoroptions = {
        height: 300,
        focus: true,
        airMode: true,
        toolbar: [
                ['edit',['undo','redo']],
                ['headline', ['style']],
                ['style', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
                ['fontface', ['fontname']],
                ['textsize', ['fontsize']],
                ['fontclr', ['color']],
                ['alignment', ['ul', 'ol', 'paragraph', 'lineheight']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link','picture','video','hr']],
                ['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ]
      };*/
    // text editor options end
    $scope.getClass = function (path) {
      //debugger;
       // var mainurlsection = $location.path().substr(0, path.length);
       var parid_split = $location.path().replace(/^\/+/i, '');
       //console.log(parid_split);
        var a = $('.js-sub-section');
        for(var _k = 0;_k<a.length; _k++) {
          var section = $(a[_k]).data('sec-id');
          if(section == parid_split) {

            $(a[_k]).addClass('active');
            //$(a[_k]).parent().parent().addClass('active');
            $(a[_k]).closest('li.js-section').addClass('active');
          }  else if(parid_split=='' || parid_split=='dashboard'){
            $("#1-1").addClass("active");
            $("#1").addClass("active");
             //$('#dashboard_id').addClass('active');
           }else {
            $(a[_k]).removeClass('active');
              //$(a[_k]).closest('li.js-section').removeClass('active');
          }
        }


      // console.log($location.path().substr(0, path.length));

	}
 $scope.getActive = function(a,b,mLength,sLength) {

  if(b == '0') {
     for(var _r = 1; _r<=mLength ; _r++) {
        if(a == _r) {
          if($( '#'+a).hasClass( "active" ) )
            $('#'+a).removeClass('active');
          else
            $('#'+a).addClass('active');
        } else {
          $('#'+_r).removeClass('active');
        }
     }
     return true;
  }
    for(var _i = 1 ; _i<=mLength; _i++) {

        if(_i== a) {
          if($('#'+_i).hasClass('active'))
            $('#'+_i).removeClass('active');
          else
            $('#'+_i).addClass('active');


        } else {


           $('#'+_i).removeClass('active');
        }
          for(var _j = 1 ; _j<=sLength; _j++) {


            if(_i == a && _j == b) {

              /*if( $('#'+_i+'-'+_j).hasClass('active'))
                $('#'+_i+'-'+_j).removeClass('active');
              else*/
                $('#'+_i+'-'+_j).addClass('active');


           } else {


             $('#'+_i+'-'+_j).removeClass('active');
           }
       }
    }
 };
  $scope.exportData = function () {
   //debugger;
      var sheetname = $scope.sectionName;
       var mystyle = {
        sheetid: sheetname + ' Sheet',
        headers: true,
        caption: {
          title: sheetname + ' Table',
          style:'font-size: 14px; color:blue;text-transform:capitalize' // Sorry, styles do not works
        },
        style:'background:#ffffff',
        column: {
          style:'font-size:30px'
        }
    };


     $scope.listsexport = [];

      if($scope.searchObj != undefined) {
        var searchData = $scope.searchObj[$scope.searchField];
             for(_i=0;_i<$scope.lists.length; _i++) {
           if($scope.lists[_i][$scope.searchField].indexOf(searchData)!=-1){
              $scope.listsexport.push($scope.lists[_i]);
           }
         }

       } else {
        $scope.listsexport = $scope.list;
       }
     if($scope.listsexport)
          alasql('SELECT * INTO XLSX("'+sheetname+'.xlsx",?) FROM ?',[mystyle,$scope.listsexport]);
     else
           alasql('SELECT * INTO XLSX("'+sheetname+'.xlsx",?) FROM ?',[mystyle,$scope.lists]);

     //alasql('SELECT * INTO XLSX("'+sheetname+'.xlsx",{headers:true})\ FROM HTML("#MyInquires",{headers:true})');

  };
  $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {

       ngRepeatFinishedEvent.currentScope.loading = '';
      /* */
   //you also get the actual event object
   //do stuff, execute functions -- whatever...
   });

    function closeModals() {
        if ($scope.warning) {
          $scope.warning.close();
          $scope.warning = null;
        }

        if ($scope.timedout) {
          $scope.timedout.close();
          $scope.timedout = null;
        }
      }


    $scope.$on('IdleStart', function() {
        closeModals();

        $scope.warning = $uibModal.open({
          templateUrl: 'warning-dialog.html',
          windowClass: 'modal-danger',
          backdrop: 'static',
          scope: $scope
        });
      });

      $scope.$on('IdleEnd', function() {

        closeModals();
      });

      $scope.$on('IdleTimeout', function() {

        closeModals();
        $scope.timedout = $uibModal.open({
          templateUrl: 'timedout-dialog.html',
          windowClass: 'modal-danger',
          backdrop: 'static',
          scope: $scope
        });



      });



	$scope.counter = 0;
    $scope.change = function(n) {
        $scope.counter++;
    };

	$scope.getClassa = function (path) {
  		return ($location.path().substr(0, path.length) === path) ? 'angular-ripple animate' : '';
	};

	$scope.getRandomSpan = function(){
  		return Math.floor((Math.random()*3628124578)+1);
	};

	$scope.sortFunc = function(field,order) {
		$scope.orderByField = field;
		$scope.reverseSort  = !order;
	};


  $scope.viewdashModal = function(dash_id){
     $.ajax({
            url: MAIN_URL+"index/viewdashModal?dash_id="+dash_id,
            type:'get',
            dataType:'html',

            success:function(data) {
             // console.log(data);
              $('#viewdashModal').modal('show');
               $('#viewdashModal #viewdash').html(data);
            },

        });
  };

  $scope.viewdashPages = function(dash_id){
    window.location.href = MAIN_URL+"cms?section=ordermanagement&dash_id="+dash_id;
  };

  $scope.viewdashPage = function(feedback_id){
    window.location.href = MAIN_URL+"cms?section=feedback&feedback_id="+feedback_id;
  };

/*ev,index,val,y,key,pIndex*/
  $scope.multifuction = function(ev,selectedOption) {
     if(selectedOption=='delete'){
    var confirm = $mdDialog.confirm()
          .title('Are you sure you want to delete all the records?')
          //.textContent('All of the banks have agreed to forgive you your debts.')
          .ariaLabel('Lucky day')
          .targetEvent(ev)
          .ok('Yes')
          .cancel('Cancel');
    $mdDialog.show(confirm).then(function() {
      //$scope.status = 'You decided to get rid of your debt.';
      var deleteallurl = MAIN_URL+'cms/cms/deletealldata';
      $http({
      method: 'post',
      url: deleteallurl,
      data: $.param({  'tableName' : $scope.sectionTable, 'type' : 'delete_all_data' , 'deviceType' : 'webUI' }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).
    success(function(data, status, headers, config) {
      if(data.success){
        /*var index = $scope.lists.indexOf(y);
        $scope.lists.splice(index, 1);*/
        $scope.lists = "";
        $scope.messageSuccess(data.message);

      }else{
        $scope.messageFailure(data.message);
      }
    }).
    error(function(data, status, headers, config) {
      $scope.messageFailure(data.message);
    });


    }, function() {
      $scope.status = 'You decided to keep your debt.';
    });
    }

    if(selectedOption == undefined){
      $scope.messageFailure("Please select an action to apply");
    }


  };

	$scope.today = function() {
        $scope.dt = new Date();
    };

    $scope.today();

    $scope.clear = function () {
        $scope.dt = null;
    };

    // Disable weekend selection
    $scope.disabled = function(date, mode) {
        return false; //( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
    };


    $scope.removedv = function(n) {
      $('#dvPreview'+n).slideUp('slow');
      //var imgR = $('#dvPreview'+n).parent().find('.removedv');
      //$(imgR).hide();
      $('#dvPreview'+n).parent().parent().find(".form-controlfilee").val("");
      $('#dvPreviewVal'+n).parent().parent().find(".form-controlfileeval").val("");
      var x = $('#dvPreview'+n).parent().parent().find(".form-controlfilee").data("number");
      //$rootScope.myFile.pop({no: n, file:''});
     // console.log(x-1);
       $rootScope.myFile.splice(x-1,1);
     // delete $rootScope.myFile[x-1];
    };




    $scope.statusText= function(no,y) {
       if (isNaN(no)==false){
           return $scope.subData[0].columns[y].editoptions.enumvalues[no];
         }
        else{
           return no;
        }
    };


    $scope.statusNo = function(txt){
      var suffix = txt.match(/\d+/); // 123456
      return parseInt(suffix);
    };

    $scope.toggleMin = function() {
        $scope.minDate = $scope.minDate ? null : new Date();
    };
    $scope.toggleMin();

    $scope.open = function($event) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.opened = true;
    };

    $scope.dateOptions = {
        formatYear: 'yy',
        startingDay: 1
    };

    $scope.initDate = new Date('11/20/2016');
    $scope.formats = ['MM/dd/yyyy'];
    $scope.format = $scope.formats[0];

    $scope.init = function(sectiontype,parent_section,parent_id){
        //console.log(sectiontype); console.log(parent_section);  console.log(parent_id);
        $scope.section = sectiontype;
        sectionService.titledata(sectiontype).then(function(response) {
            if(response.status=='200')
            {
            $scope.sectionTitle = response.data.records;
            }
        });
        sectionService.tablename(sectiontype).then(function(response) {
            if(response.status=='200')
            {
            $scope.sectionTable = response.data.records;
            }
        });
       // $scope.getClass(sectiontype);
        $scope.sectionName = $scope.filter(sectiontype);
        $scope.parentSection = parent_section;
        $scope.parentId = parent_id;
        $scope.listdata(sectiontype,parent_section,parent_id);//listdata
        $scope.menudata();//menudata
        $scope.getSectiondata($scope.section);
        //alert('Here');

    }

    $scope.filter = function(sectiontype){
      return sectiontype.replace(/_/g, ' ');
    }

	$scope.setSearchBox = function(y) {
		for(var _j=0;_j<$scope.subData[0].listColumns.length;_j++) {
			if($scope.subData[0].columns[$scope.subData[0].listColumns[_j]].searchable) {
				$scope.searchField = $scope.subData[0].listColumns[_j];
				break;
			}
		}
	}

   	$scope.menudata = function(){
	   $scope.loading = "<span class='loading'>&nbsp;</span>";
       $scope.menus =  [];
            sectionService.menudata().then(function(response) {
             if(response.status=='200')
             {
                $scope.menus= (response.data.records);
                //$scope.loading = " ";
               if ( angular.element('#app_version').length ) {
                   var version = angular.element('#app_version').val();
   //alert(version);
   $scope.version = version;

      }
             }
         });
	}

	var url = MAIN_URL+'cms/cms/formangularData';
	$scope.fetchReportsFromRange = function(startDt,closeDt) {
		sectionService.fetchReportsFromRange($scope.sectiontype,startDt,closeDt).then(function(response){
		});
	}

	$scope.searchData = function(searchField,q) { 
    //console.log(q); console.log(searchField);
    if($scope.subData[0].columns[searchField].dbFormat == "date"){
        $scope.placeholder = "Search Date Format (MM/DD/YYYY)";
    }else{
        $scope.placeholder = "Search";
    }

    if(searchField == "status" || searchField == "vStatus" || searchField == "enabled" || searchField == "banner_status"|| searchField == "cnt_status"){ 
        if(q == "Enabled" || q == "Disabled"){
            //console.log(q);  
        }else{
            $("#search1").val("");              
            q = "";  
            //console.log(q);  
        }
        $scope.statusvals = ["Enabled", "Disabled"];
        $("#search1").show();
        $("#search2").hide();        
    }    
    else{
        $("#search2").show();
        $("#search1").hide();
        if(q == "Enabled" || q == "Disabled"){            
            $("#search2").val("");
            $scope.placeholder = "Search";
            q = "";
        }
    }
		if(searchField) { 
			q = ( q == undefined && q == '' ? '' : q );

			$scope.searchObj = {};
			$scope.searchObj[searchField] = q;

		}
    //console.log($scope.searchObj);
	}

	$scope.saveGen = function(key,action){


		  var random_key = $scope.getRandomSpan();
      if($scope.parentId!='-1')
      $scope.tempDetails['parent_id'] = $scope.parentId;
      //  var file[] = $rootScope.myFile;
        $rootScope.bFile = false;
       // console.log($rootScope.myFile);
        if($rootScope.myFile!='' && $rootScope.myFile!==undefined){
            var filelength = $rootScope.myFile.length;
             var randno = random_key;
             var _j = 0;
             var filename = [];
             var randnos = [];
           for(var _f=0;_f<filelength;_f++) {
              //var randno = random_key+_f;
              var randno = random_key+'_'+$rootScope.myFile[_f].no;
              /* if( action == 'edit'){
                 var tempDetailslength = 0;
                angular.forEach($scope.tempDetails, function(tempDetail){
                    tempDetailslength += tempDetail.hasOwnProperty("external_artworks_image1_id") ? 1 : 0;
                });
                //var tempDetailslength = $scope.tempDetails.length;
                console.log(tempDetailslength);
                var external_artworks_image1_id = $scope.tempDetails['external_artworks_image1_id'];
                var external_artworks_image2_id = $scope.tempDetails['external_artworks_image2_id'];
                var imgurl = MAIN_URL+'cms/cms/formangularimgData?random_key='+randno+'&image1='+external_artworks_image1_id+'&image2='+external_artworks_image2_id;
              }else{*/
                 var imgurl = MAIN_URL+'cms/cms/formangularimgData?random_key='+randno;
           /*   }*/
              var uploadUrl = imgurl;
              randnos.push(randno);
              $scope.tempDetails['random_key'] = randnos;
              //var filename = $rootScope.myFile[_f].name;
              filename.push($rootScope.myFile[_f].file.name);
              fileUpload.uploadFileToUrl($rootScope.myFile[_f].file, uploadUrl,function(result) {
                 // var sucesslengh = filelength-1;
                 if(result == 'success' && (_j == filelength-1)) {
                //if(result == 'success') {
                    $scope.newFunc(key,action,filename);
                }
                 _j++;
              });
            }
                /*$timeout(function() {*/
                    //$scope.newFunc(key,action);
                /*}, 2000);*/
        	}
        else {
              $scope.tempDetails['random_key'] = random_key;
              var filename ="";
                $scope.newFunc(key,action,filename);
        }

	}

    $scope.newFunc =function(key,action,filename){
        var file = filename;
          $http({
          method: 'post',
          url: url,
          data: $.param({'user' : $scope.tempDetails, 'keyname' : key, 'action':action, 'sectionName' : $scope.section, 'type' : 'save_form' , 'deviceType' : 'webUI' , 'file': file }),
          headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).
        success(function(data, status, headers, config) {
            if(data.success){
                if( action == 'edit'){
                  // $scope.lists= "loading...";
                    //$scope.lists[$scope.parentIndex] = $scope.tempDetails;
                $("#no-datatxt").hide();
                }else{
                    //$scope.lists.push($scope.tempDetails);
                }
                $scope.listdata($scope.sectionName,$scope.parentSection,$scope.parentId);
                $scope.messageSuccess(data.message);
                $rootScope.myFile = [];
              //$compile($("#no-data").html('<style>#no-datatxt {display:none}</style>').contents())($scope);

                //$scope.userForm.$setPristine();
                //$scope.tempDetails = {};
            }else{
                $scope.messageFailure(data.message);
            }
        }).
        error(function(data, status, headers, config) {
            //$scope.codeStatus = response || "Request failed";
        });
    }

	$scope.updatecmssettings = function(){
  //  console.log($scope.settings);
    	var imgurl = MAIN_URL+'cms/cms/formangularlogoData';
        var file = $rootScope.fileread;
        var uploadUrl = imgurl;
        if(file!=''){
            filecmslogoUpload.uploadFileToUrl(file, uploadUrl, $scope.settings[0].tabContent, $scope.section);
    	}else{
            var surl = MAIN_URL+'cms/cms/settings';
            $http({
              method: 'post',
              url: surl,
              data: $.param({'settings' : $scope.settings, 'submit': 'Save' , 'section' : $scope.section}),
              headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).
            success(function(data, status, headers, config) {
            	if(data.success){
            		$scope.messageSuccess(data.message);
            	}else{
            		$scope.messageFailure(data.message);
            	}
            }).
            error(function(data, status, headers, config) {
            });
	   }
	}

	$scope.updatesettings = function(){
		var imgurl = MAIN_URL+'cms/cms/formangularlogoData';
               // debugger;
                var oldversion = $scope.version;
                 var version = angular.element('#app_version').val();
                /* if(oldversion!=version)
                 {
                    if (!confirm("You are about to change the Mobile App version Do you want to proceed?")) {
                    return false;

                    }
                 }*/
        var file = $rootScope.fileread;
        var uploadUrl = imgurl;
        if(file!=''){
        filelogoUpload.uploadFileToUrl(file, uploadUrl, $scope.xsettings[0].tabContent, $scope.section);
    	}else{
    	var surl = MAIN_URL+'cms/cms/settings';
		$http({
	      method: 'post',
	      url: surl,
	      data: $.param({'settings' : $scope.xsettings, 'submit': 'Save' , 'section' : $scope.section}),
	      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
	    }).
	    success(function(data, status, headers, config) {
	    	if(data.success){
	    		$scope.messageSuccess(data.message);
	    	}else{
	    		$scope.messageFailure(data.message);
	    	}
	    }).
	    error(function(data, status, headers, config) {
	    });
    	}
	}


	$scope.clickColor  = function(c){
        $rootScope.myColor = c;
        $scope.myCol = {
        "background-color" : c,
        "border-color" : c
        }
	}



$scope.updateActive = function(val) {

}

	$scope.changepassword = function(){
    	var curl = MAIN_URL+'cms/cms/change_pwd';
    	if($scope.formData.currentpwd!==undefined && $scope.formData.newpwd !==undefined && $scope.formData.confirmnewpwd!==undefined && $scope.formData.newpwd === $scope.formData.confirmnewpwd){
      $http({
    	      method: 'post',
    	      url: curl,
    	      data: $.param({'currentpwd':$scope.formData.currentpwd, 'newpwd':$scope.formData.newpwd, 'confirmnewpwd':$scope.formData.confirmnewpwd, 'section' : $scope.section, 'submit': 'Save'}),
    	      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    	    }).
    	    success(function(data, status, headers, config) {
    	    	if(data.success){
    	    		$scope.messageSuccess(data.message);
    	    		$scope.formData = '';
    	    	}else{
    	    		$scope.messageFailure(data.message);
    	    		$scope.formData = '';
    	    	}
    	    }).
    	    error(function(data, status, headers, config) {
    	    });
    	  }
	}


	$scope.changepwd = function(){
    	var curl = MAIN_URL+'cms/cms/manageusers';
    	if($scope.formData.cpassword!==undefined && $scope.formData.newpassword !==undefined && $scope.formData.cnewpassword!==undefined && $scope.formData.newpassword === $scope.formData.cnewpassword){
    	$http({
    	      method: 'post',
    	      url: curl,
    	      data: $.param({'id':$scope.formData.id,'cpassword':$scope.formData.cpassword, 'newpassword':$scope.formData.newpassword, 'cnewpassword':$scope.formData.cnewpassword, 'submit': 'Update'}),
    	      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    	    }).
    	    success(function(data, status, headers, config) {
    	    	if(data.success){
    	    		$scope.messageSuccess(data.message);
    	    		$scope.formData = '';
    	    		$scope.modalCancel();
    	    	}else{
    	    		$scope.messageFailure(data.message);
    	    		$scope.formData = '';
    	    		$scope.modalCancel();
    	    	}
    	    }).
    	    error(function(data, status, headers, config) {
    	    });
    	  }
	}

  $scope.addUser = function(){
       //console.log($scope.formData);
        var id = 0;
        var p_url = MAIN_URL+'cms/cms/manageusers';
          $http({
              method: 'post',
              url: p_url,
              data: $.param({'id':id,'username':$scope.formData.username, 'password':$scope.formData.password, 'email':$scope.formData.email,'role_id':$scope.formData.role_id, 'section': $scope.section, 'submit': 'Save'}),
              headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).
            success(function(data, status, headers, config) {
              if(data.success){
                $scope.manageusers.records = (data.records);
                $scope.messageSuccess(data.message);
                $scope.formData = '';
                //$scope.manageroles = data.records;
                 // angular.copy(data.records, $scope.manageroles);

                // $scope.manageroles = {};
              }else{
                $scope.messageFailure(data.message);
                $scope.formData = '';
              }
            }).
            error(function(data, status, headers, config) {
            });
  }

  $scope.updateUser = function(){
       console.log($scope.formData);
        var id = 0;
        var p_url = MAIN_URL+'cms/cms/manageusers';
          $http({
              method: 'post',
              url: p_url,
              data: $.param({'id':$scope.formData.id,'username':$scope.formData.username, 'password':$scope.formData.password, 'email':$scope.formData.email,'role_id':$scope.formData.role_id, 'section': $scope.section, 'submit': 'Save'}),
              headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).
            success(function(data, status, headers, config) {
              if(data.success){
                $scope.manageusers.records = (data.records);
                $scope.messageSuccess(data.message);
                $scope.formData = '';
                //angular.copy(data.records, $scope.manageroles);
                //$scope.manageroles = {};
              }else{
                $scope.messageFailure(data.message);
                $scope.formData = '';
              }
            }).
            error(function(data, status, headers, config) {
            });
  }

  $scope.addGen = function(key){
   //console.log($scope.formData);
   //angular.copy($scope.formData, $scope.tempDetails);
  //	jQuery('.btn-save').button('loading');
    $scope.saveGen(key,'add');
    $scope.editMode = false;
    $scope.index = '';
  }

  $scope.updateGen = function(key){
    //$('.btn-save').button('loading');
    //angular.copy($scope.formData, $scope.tempDetails);
    $scope.saveGen(key,'edit');
  }

	$scope.addRole = function(){
        var r_url = MAIN_URL+'cms/cms/manageroles';
        	$http({
              method: 'post',
              url: r_url,
              data: $.param({'role_id':$scope.formData.role_id, 'role_name':$scope.formData.role_name, 'parent_role_id':$scope.formData.parent_role_id,'section': $scope.section, 'submit': 'Save'}),
              headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).
            success(function(data, status, headers, config) {
            	if(data.success){
                $scope.manageroles.records = (data.records);
            		$scope.messageSuccess(data.message);
            		$scope.formData = '';
            		//$scope.manageroles = data.records;
            	   // angular.copy(data.records, $scope.manageroles);

            		// $scope.manageroles = {};
            	}else{
            		$scope.messageFailure(data.message);
            		$scope.formData = '';
            	}
            }).
            error(function(data, status, headers, config) {
            });
	}


	$scope.updateRole = function(){
    var r_url = MAIN_URL+'cms/cms/manageroles';
    	$http({
          method: 'post',
          url: r_url,
          data: $.param({'role_id':$scope.formData.role_id, 'role_name':$scope.formData.role_name, 'parent_role_id':$scope.formData.parent_role_id,'section': $scope.section, 'submit': 'Save'}),
          headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).
        success(function(data, status, headers, config) {
        	if(data.success){
              $scope.manageroles.records = (data.records);
          		$scope.messageSuccess(data.message);
          		$scope.formData = '';
          		//$scope.manageroles = data.records;
          	  // angular.copy(data.records, $scope.manageroles);
          		// $scope.manageroles = {};
        	}else{
        		$scope.messageFailure(data.message);
        		$scope.formData = '';
        	}
        }).
        error(function(data, status, headers, config) {
        });
	}





  $scope.addPrevilage = function(){
       //console.log($scope.formData);
        var privilege_id = 0;
        var publish_role_id = 1;
        var p_url = MAIN_URL+'cms/cms/manageprivilege';
          $http({
              method: 'post',
              url: p_url,
              data: $.param({'privilege_id':privilege_id,'add_role_id':$scope.formData.add_role_id, 'publish_role_id':publish_role_id, 'view_role_id':$scope.formData.view_role_id,'delete_role_id':$scope.formData.delete_role_id,'edit_role_id':$scope.formData.edit_role_id, 'entity_type':$scope.formData.entity_type, 'section_entity_id':$scope.formData.section_entity_id, 'group_entity_id':$scope.formData.group_entity_id, 'section': $scope.section, 'submit': 'Save'}),
              headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).
            success(function(data, status, headers, config) {
              if(data.success){
                //$scope.listdata($scope.sectionName,$scope.parentSection,$scope.parentId);
                //console.log(data.records);
                $scope.manageprivileges.records = (data.records);
                $scope.loading = " ";

                //$scope.messageSuccess(data.message);
                //$rootScope.myFile = [];

                $scope.messageSuccess(data.message);
                $scope.formData = '';
                //$scope.manageroles = data.records;
                 // angular.copy(data.records, $scope.manageroles);

                // $scope.manageroles = {};
              }else{
                $scope.messageFailure(data.message);
                $scope.formData = '';
              }
            }).
            error(function(data, status, headers, config) {
            });
  }


  $scope.updatePrevilage = function(){
    var p_url = MAIN_URL+'cms/cms/manageprivilege';
    var publish_role_id = 0;
    //console.log($scope.formData);
      $http({
          method: 'post',
          url: p_url,
          data: $.param({'privilege_id':$scope.formData.privilege_id,'add_role_id':$scope.formData.add_role_id, 'publish_role_id':publish_role_id,'view_role_id':$scope.formData.view_role_id, 'delete_role_id':$scope.formData.delete_role_id,'edit_role_id':$scope.formData.edit_role_id, 'entity_type':$scope.formData.entity_type, 'section_entity_id':$scope.formData.section_entity_id, 'group_entity_id':$scope.formData.group_entity_id, 'section': $scope.section, 'submit': 'Save'}),
          headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).
        success(function(data, status, headers, config) {
          if(data.success){
            //console.log(data.records);
            $scope.manageprivileges.records = (data.records);
            $scope.messageSuccess(data.message);
            $scope.formData = '';
            //$scope.manageroles = data.records;
             // angular.copy(data.records, $scope.manageroles);
            // $scope.manageroles = {};
          }else{
            $scope.messageFailure(data.message);
            $scope.formData = '';
          }
        }).
        error(function(data, status, headers, config) {
        });
  }





	$scope.messageFailure = function (msg){
		jQuery('.alert-failure-div > p').html(msg);
		jQuery('.alert-failure-div').show();
    jQuery("html,body").animate({scrollTop: 0}, "slow");
		jQuery('.alert-failure-div').delay(5000).slideUp(function(){
			jQuery('.alert-failure-div > p').html('');
		});
	}

	$scope.messageSuccess = function (msg){
		jQuery('.alert-success-div > p').html(msg);
		jQuery('.alert-success-div').show();
    jQuery("html,body").animate({scrollTop: 0}, "slow");
   // jQuery(".alert-success-div").animate({ scrollTop: $('#alert').offset().top-150 }, 1000);
		jQuery('.alert-success-div').delay(5000).slideUp(function(){
			jQuery('.alert-success-div > p').html('');
		});
	}


	$scope.getError = function(error, name){
		if(angular.isDefined(error)){
			if(error.required){
				return "Please enter required";
			}
		}
	}

	$scope.getDataForListing   = function() {
	}

	$scope.getSectiondata = function(sectiontype){
        $scope.subData =     [];
        $scope.cmAction = false;
        sectionService.getprevilagedata().then(function(response) {
        	$scope.privilegedSections = response.data.privilegedSections;
        	$scope.privilegedGroups =  response.data.privilegedGroups;

        	sectionService.getsectiondata(sectiontype).then(function(response) {

        	if((($scope.privilegedSections.match(new RegExp(response.data.id, "g")) || []).length) || (($scope.privilegedGroups.match(new RegExp(response.data.group_id, "g")) || []).length)){
        		 $compile($("#my-element").html('<div class="container container-lg animated fadeInDown"><div class="panel"><div class="panel-body"><p class="lead text-center text-bold">Error!</p><p class="text-center">You are not permitted to see this page</p></div></div></div><style>.capitalize,.subdatadetails {display:none}</style>').contents())($scope);
        	   $scope.loading = " ";
          }
         $scope.getClass(sectiontype);
        	if (response.data.section_config === undefined) {

        		 $compile($("#my-element").html('<div class="container container-lg animated fadeInDown"><div class="panel"><div class="panel-body"><p class="lead text-center text-bold">Sorry! The page you are looking for is not found</p><p class="text-center">Error 404: this may happen if u have entered site url incorrectly or this page doesnt exist anymore!</p></div></div></div><style>.capitalize {display:none}</style>').contents())($scope);
             $scope.loading = " ";
        	}else{
        	var obj = JSON.parse(response.data.section_config);
        	$scope.subData.push(obj);
        	angular.forEach(obj, function(genre,index){
          			if (index === 'columns') {
	                    angular.forEach(genre, function(avGenre, index2){
	                    	if(avGenre.editoptions!=undefined){
	                    	var sourcetype = avGenre.editoptions.hasOwnProperty("source_type");
	                    	var sourcetypeVal = avGenre.editoptions.source_type;
	                    	if(sourcetype != false && sourcetypeVal == "function" ) {
	                    		var source = avGenre.editoptions.source;
	                    		 sectionService.listdatafunction(source).then(function(response) {
						             if(response.status=='200')
						             {
											var myStringArray = response.data;
											var arrayLength = myStringArray.length;
											dict = {};
											for (var i = 0; i < arrayLength; i++) {
                                                key = myStringArray[i].text;
                                                value = myStringArray[i].value;
                                                dict[value] = key;
									           }
						                avGenre.editoptions.source = dict;
						             }
						         });
	                    	}
	                    	var autocompleteSource = avGenre.editoptions.hasOwnProperty("tagDetails");
	                    	if(autocompleteSource != false) {
	                    		var autocompleteSourceVal = avGenre.editoptions.tagDetails.autocompleteSource;
	                    		sectionService.listdatafunction(autocompleteSourceVal).then(function(response) {
		                			if(response.status=='200')
								             {
								             	$scope.availableTags = response.data;
								             }
				                });
	                    	}
	                    }
	                	});
                	}

                	if (index === 'graphPanel1') {
                    $scope.loading = "<span class='loading'>&nbsp;</span>";
                		for (var key in genre) {
  							if(key != 'columns') {
  								//bar diagram
  								if(genre[key].type == 'MSColumn3D') {
  									var sKey = key;
  									var barUrl = genre[key].dataSets.dataset1.fetchValue; //console.log(barUrl);
		                			var color = genre[key].dataSets.dataset1.color;
		                			var label = 'X - ' +genre[key].xAxisName +'<br>'+'Y - ' +genre[key].yAxisName ;
		                			sectionService.createBarDiaData(barUrl,color,label).then(function(response) {
                            //console.log(response);
		                				//$scope.barSrc = response.data.file_url;
		                				//$scope.sourceSrcArr.push({'sourceSrc' : response.data.file_url,'key' : sKey});
                            //console.log(response.data.file_url);
		                				$scope.populateDiagrams(response.data.file_url,sKey);
		                			});
  								}

  								if(genre[key].type == 'MSLine' ) {
  									var nKey = key;
		                			var lineUrl = genre[key].dataSets.dataset1.fetchValue; //console.log(lineUrl);
		                			var color = genre[key].dataSets.dataset1.color;
		                			var label = 'X - ' +genre[key].xAxisName +'<br>'+'Y - ' +genre[key].yAxisName ;
		                			sectionService.createLineDiaData(lineUrl,color,label).then(function(response) {
		                				//$scope.lineSrc = response.data.file_url;
		                				//$scope.sourceSrcArr.push({'sourceSrc' : response.data.file_url , 'key' : nKey});
		                				$scope.populateDiagrams(response.data.file_url,nKey);
		                				//console.log(nKey);
		                			});
		                		}



                  if(genre[key].type == 'MSPie' ) {
                    var nKey = key;
                          var dcount = genre[key].dataSetsCount;
                          /*for(var d_i=1;d_i<=dcount;d_i++){

                          var b = 'dataset'+d_i;
                          var lineUrl = genre[key].dataSets[b].fetchValue;
                          var color = genre[key].dataSets[b].color;
                          var label = genre[key].dataSets[b].name;*/
                          sectionService.createPieDiaData(genre[key],key,dcount).then(function(response) {
                            //$scope.lineSrc = response.data.file_url;
                            //$scope.sourceSrcArr.push({'sourceSrc' : response.data.file_url , 'key' : nKey});
                            $scope.populateDiagrams(response.data.file_url,nKey);
                            //console.log(nKey);
                          });

                          /*}*/
                        }

  							}
						}
                	}

                	if (index === 'listingPanel1') {

                		var dashlistUrl = genre.column1.fetchValue;
                		var dashlinkUrl = genre.column1.titlelinkSection;
							       sectionService.listdatafunction(dashlistUrl).then(function(response) {
                			if(response.status=='200')
						             {
						                $scope.listdash = response.data;
						             }
		                });
						          sectionService.listdatafunction(dashlinkUrl).then(function(response) {
                			if(response.status=='200')
						             {
						                $scope.listdashlink1 = jQuery.parseJSON(response.data);
						             }

		                });
                	}

                	if (index === 'listingPanel2') {
                		var dashlistUrl = genre.column1.fetchValue;
                		var dashlinkUrl = genre.column1.titlelinkSection;
							sectionService.listdatafunction(dashlistUrl).then(function(response) {
                			if(response.status=='200')
						             {
						                $scope.listdash2 = response.data;
						             }

		                });

                        sectionService.listdatafunction(dashlinkUrl).then(function(response) {
                            if(response.status=='200')
                            {
                            $scope.listdashlink2 = jQuery.parseJSON(response.data);
                            }

                        });
                	}


                  if (index === 'aggregatePanel1') {
                    var dashlistUrl = genre.column1.fetchValue;
                    var dashlinkUrl = genre.column1.titlelinkSection;
                  sectionService.listdatafunction(dashlistUrl).then(function(response) {
                      if(response.status=='200')
                         {
                            $scope.aggregatedash1 = jQuery.parseJSON(response.data);
                         }

                    });

                    sectionService.listdatafunction(dashlinkUrl).then(function(response) {
                        if(response.status=='200')
                        {
                        $scope.aggregatedashlink1 = jQuery.parseJSON(response.data);
                        }

                    });
                  }


                  if (index === 'aggregatePanel2') {
                    var dashlistUrl = genre.column1.fetchValue;
                    var dashlinkUrl = genre.column1.titlelinkSection;
                  sectionService.listdatafunction(dashlistUrl).then(function(response) {
                      if(response.status=='200')
                         {
                            $scope.aggregatedash2 = jQuery.parseJSON(response.data);
                         }

                    });

                    sectionService.listdatafunction(dashlinkUrl).then(function(response) {
                        if(response.status=='200')
                        {
                        $scope.aggregatedashlink2 = jQuery.parseJSON(response.data);
                        }

                    });
                  }


                  if (index === 'aggregatePanel3') {
                    var dashlistUrl = genre.column1.fetchValue;
                    var dashlinkUrl = genre.column1.titlelinkSection;
                  sectionService.listdatafunction(dashlistUrl).then(function(response) {
                      if(response.status=='200')
                         {
                            $scope.aggregatedash3 = jQuery.parseJSON(response.data);
                         }

                    });

                    sectionService.listdatafunction(dashlinkUrl).then(function(response) {
                        if(response.status=='200')
                        {
                        $scope.aggregatedashlink3 = jQuery.parseJSON(response.data);
                        }

                    });
                  }


                  if (index === 'aggregatePanel4') {
                    var dashlistUrl = genre.column1.fetchValue;
                    var dashlinkUrl = genre.column1.titlelinkSection;
                  sectionService.listdatafunction(dashlistUrl).then(function(response) {
                      if(response.status=='200')
                         {
                            $scope.aggregatedash4 = jQuery.parseJSON(response.data);
                         }

                    });

                    sectionService.listdatafunction(dashlinkUrl).then(function(response) {
                        if(response.status=='200')
                        {
                        $scope.aggregatedashlink4 = jQuery.parseJSON(response.data);
                        }

                    });
                  }


                   if (index === 'aggregatePanel5') {
                    var dashlistUrl = genre.column1.fetchValue;
                    var dashlinkUrl = genre.column1.titlelinkSection;
                  sectionService.listdatafunction(dashlistUrl).then(function(response) {
                      if(response.status=='200')
                         {
                            $scope.aggregatedash5 = jQuery.parseJSON(response.data);
                         }

                    });

                    sectionService.listdatafunction(dashlinkUrl).then(function(response) {
                        if(response.status=='200')
                        {
                        $scope.aggregatedashlink5 = jQuery.parseJSON(response.data);
                        }

                    });
                  }


                	if (index === 'customCmsAction') {

       					obj2 = response.data.section_config;
			            var obj3 = $.parseJSON(obj2);
			            var controller = obj3.controller;
                		var method = obj3.method;
                		var module = obj3.module;
						sectionService.listcustomcmsdatafunction(controller,method,$scope.section).then(function(response) {
                				if($scope.section=='manage_roles'){
                					 $scope.manageroles = (response.data);
                	 				 //$scope.loading = " ";
                				}else if($scope.section=='cms_privileges'){
                					 $scope.manageroles = (response.data.roles);
                					 $scope.managegroups = (response.data.groups);
                					 $scope.managesections = (response.data.sections);
                					 $scope.manageprivileges = (response.data);
                	 				 //$scope.loading = " ";
                				}else if($scope.section=='cms_users'){
                					 $scope.manageroles = (response.data.roles);
                					 $scope.manageusers = (response.data);
                	 				 //$scope.loading = " ";
                				}else if($scope.section=='change_password'){
                          //console.log("test");
                          window.location.href = MAIN_URL+'cms?section=change_password';
                           //$scope.loading = " ";
                        }else{
						     		$compile($("#my-element").html(response.data).contents())($scope);
						        }

		                });
                	}


                	if (index === 'customAction') {
                		window.location.href = MAIN_URL+'cms?section='+$scope.sectionName;
                	}


                	if (index === 'reportPanel') {
                		 $compile($("#my-element").html("").contents())($scope);
                	}

                	if (index === 'export') {
                			 $compile($("#export").show().contents())($scope);
                	}
            	});
            }


        });

      });

    }

	$scope.populateDiagrams = function(url,recv_key) {
		if($scope.subData[0].graphPanel1.columns > 0) {
      $scope.loading = " ";
			for(var key in $scope.subData[0].graphPanel1) {
				if(key == recv_key) {
					$scope.subData[0].graphPanel1[key]['sourceSrc'] = url;
				}
			}
		}

	}


	$scope.listdata = function(section,parent_section,parent_id){
			$scope.loading = "<span class='loading'>&nbsp;</span>";
            $scope.lists =     [];
            sectionService.listdata($scope.section,parent_section,parent_id).then(function(response) {
             if(response.status=='200')
             {
             	if(section=='settings'){
             		 $scope.xsettings= (response.data);
                  $scope.loading = " ";
             	}else if(section=='cms_settings'){
             		 $scope.settings= (response.data);
                	 $scope.loading = " ";
             	}else{
             		 $scope.lists= (response.data.records);
                 //console.log($scope.lists);
                 if($scope.lists===undefined){
                   $compile($("#my-element").html('<div class="container container-lg animated fadeInDown"><div class="panel"><div class="panel-body"><p class="lead text-center text-bold">Error!</p><p class="text-center">Incorrect JSON Format</p></div></div></div><style>.capitalize,.subdatadetails {display:none}</style>').contents())($scope);
                    $scope.loading = "";
                 }
                 if($scope.lists.length==0){
                    $scope.loading = " ";
                 }
             	}

             }
         });
     }


	var ModalInstanceCtrl = function ($scope, $uibModalInstance) {
        $scope.ok = function () {
          $uibModalInstance.close('closed');
        };

        $scope.cancel = function () {
          $uibModalInstance.dismiss('cancel');
        };
    };



    $scope.getgroup_section =  function() {
   		if($scope.formData.entity_type=="section"){
   			$scope.sectionset="section";
   		}else{
   			$scope.sectionset="";
   		}
   		if($scope.formData.entity_type=="group"){
   			$scope.groupset="group";
   		}else{
   			$scope.groupset="";
   		}

	}


    $scope.getgroup_sectionselect =  function(entity_type,enity_name) {
      if(entity_type=="section"){
        $scope.sectionset="section";
        $scope.enity_name=enity_name;
      }else{
        $scope.sectionset="";
      }
      if(entity_type=="group"){
        $scope.groupset="group";
        $scope.enity_name=enity_name;
      }else{
        $scope.groupset="";
      }

  }


	$scope.actionClick = function(ev,index,val,y,key,pIndex) { //console.log(val);  //debugger;
    // Appending dialog to document.body to cover sidenav in docs app
    if(val=='delete'){
    var confirm = $mdDialog.confirm()
          .title('Are you sure you want to delete the record?')
          //.textContent('All of the banks have agreed to forgive you your debts.')
          .ariaLabel('Lucky day')
          .targetEvent(ev)
          .ok('Yes')
          .cancel('Cancel');
    $mdDialog.show(confirm).then(function() {
      //$scope.status = 'You decided to get rid of your debt.';

      $http({
      method: 'post',
      url: url,
      data: $.param({ 'keyname' : key, 'keyvalue' : y[key], 'sectionName' : $scope.section, 'type' : 'delete_data' , 'deviceType' : 'webUI' }),
      headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).
    success(function(data, status, headers, config) {
    	if(data.success){
    		var index = $scope.lists.indexOf(y);
    		$scope.lists.splice(index, 1);
    		$scope.messageSuccess(data.message);
    	}else{
    		$scope.messageFailure(data.message);
    	}
    }).
    error(function(data, status, headers, config) {
    	$scope.messageFailure(data.message);
    });


    }, function() {
      $scope.status = 'You decided to keep your debt.';
    });
    }
    if(val=='edit'){
  		var modalInstance = $uibModal.open({
          templateUrl: '/myModalContent.html',
          controller: ModalInstanceCtrl,
          scope: $scope,
          backdrop: 'static',
          resolve: {
            editTask: function() {

            	angular.copy(y, $scope.tempDetails);

            	 for( var value in $scope.tempDetails) {

            	 	if($scope.subData[0].detailColumns.indexOf(value) > -1) {
            	 		//here Cannot read property 'editoptions' of undefined
            	 		if($scope.subData[0].columns[value]!=undefined ) {
            	 		if($scope.subData[0].columns[value].editoptions ) {

            	 			if($scope.subData[0].columns[value].editoptions.source_type == 'function' && $scope.subData[0].columns[value].editoptions.type == 'select') {
            	 				var newVal = $scope.tempDetails[value];
            	 				var valArr = $scope.subData[0].columns[value].editoptions.source;
            					for (var value1 in valArr) {
	            					if(valArr[value1] == newVal) {
	            						$scope.tempDetails[value] = value1;
	            					}
            					}
            	 			}else if($scope.subData[0].columns[value].editoptions.source_type == 'array'){
                      var newVal = $scope.tempDetails[value];
                      var valArr = $scope.subData[0].columns[value].editoptions.source;
                      var a_text = $scope.tempDetails[value]; //alert(a_text);

                      if($(a_text).text() == "Enabled" || $(a_text).text() == "Active"){
                        $scope.tempDetails[value] = "Y";
                      }
                      else if($(a_text).text() == "Disabled" || $(a_text).text() == "Inactive"){
                        $scope.tempDetails[value] = "N";
                      }
                      if($(a_text).text() == "Published"){
                        //console.log($(a_text).attr('href'));
                        var hrefVal   = $(a_text).attr('href');
                        var statusval = hrefVal.split('/').reverse()[0].split('&').reverse()[0].split('=').reverse()[0];
                        //console.log(statusval);
                        if(statusval == "Y")
                            $scope.tempDetails[value] = "Y";
                        else
                            $scope.tempDetails[value] = "1";
                      }
                      else if($(a_text).text() == "Unpublished"){
                        //console.log($(a_text).attr('href'));
                        var hrefVals   = $(a_text).attr('href');
                        var statusvals = hrefVals.split('/').reverse()[0].split('&').reverse()[0].split('=').reverse()[0];
                        //console.log(statusvals);
                        if(statusvals == "N")
                            $scope.tempDetails[value] = "N";
                        else
                            $scope.tempDetails[value] = "0";
                      }

                        /*var a_text = $scope.tempDetails[value];
                        if($(a_text).text() == "Active"){
                          $scope.tempDetails[value] = "1";
                        }else{
                          $scope.tempDetails[value] = "0";
                        }
                        if($(a_text).text() == "Content"){
                          $scope.tempDetails[value] = "1";
                        }else{
                          $scope.tempDetails[value] = "Content";
                        } */


                      }


                    if($scope.subData[0].columns[value].editoptions.type == 'false') {
                     delete $scope.tempDetails[value];
                    }

            	 		}
            	 	}
            	 	}
            	 }
              //$scope.tempDetails = y;
              $scope.actiontext = "Update";
              $scope.parentIndex = pIndex;
            }
          }
        });
	   }


      	if(val=='view' || val=='viewprivilage' ||  val=='viewrole'  ||  val=='viewuser'){
      		if(val=='view')
      	var detailurl = '/detail.html';
      		if(val=='viewprivilage')
      	var detailurl = '/detailprivilage.html';
      		if(val=='viewrole')
      	var detailurl = '/detailrole.html';
     		 if(val=='viewuser')
      	var detailurl = '/detailuser.html';


        $mdDialog.show({
        controller: DialogController,
        templateUrl: detailurl,
        // template: y,
        // scope: $scope,
        parent: angular.element(document.body),
        targetEvent: ev,
       // animate: 'full-screen-dialog',
        locals : {
        lists : y,
        subData : $scope.subData
        },
        clickOutsideToClose:false,
        fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
        })
        .then(function(answer) {
        $scope.status = 'You said the information was "' + answer + '".';
        }, function() {
        $scope.status = 'You cancelled the dialog.';
        });

        }


        if(val=='publish'){
            var confirm = $mdDialog.confirm()
            .title('Are you sure you want to change the status of record?')
            //.textContent('All of the banks have agreed to forgive you your debts.')
            .ariaLabel('Lucky day')
            .targetEvent(ev)
            .ok('Yes')
            .cancel('Cancel');
            $mdDialog.show(confirm).then(function() {
            //$scope.status = 'You decided to get rid of your debt.';

            $http({
            method: 'post',
            url: url,
            data: $.param({ 'keyname' : key, 'keyvalue' : y[key], 'sectionName' : $scope.section, 'type' : 'publish_data', 'deviceType' : 'webUI' }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).
            success(function(data, status, headers, config) {
            if(data.success){
            var index = $scope.lists.indexOf(y);
            //$scope.post.users.splice(index, 1);
            $scope.lists.splice(index, 1);
            $scope.messageSuccess(data.message);
            }else{
            $scope.messageFailure(data.message);
            }
            }).
            error(function(data, status, headers, config) {
            $scope.messageFailure(data.message);
            });


            }, function() {
            $scope.status = 'You decided to keep your debt.';
            });
        }


        if(val=='deleterole' || val=='deleteprivilege' ||  val=='deleteuser'){
            if(val=='deleterole')
            var r_url = MAIN_URL+'cms/cms/manageroles';
            if(val=='deleteprivilege')
            var r_url = MAIN_URL+'cms/cms/manageprivilege';
            if(val=='deleteuser')
            var r_url = MAIN_URL+'cms/cms/manageusers';

            var confirm = $mdDialog.confirm()
            .title('Are you sure you want to delete the record?')
            //.textContent('All of the banks have agreed to forgive you your debts.')
            .ariaLabel('Lucky day')
            .targetEvent(ev)
            .ok('Yes')
            .cancel('Cancel');
            $mdDialog.show(confirm).then(function() {
            //$scope.status = 'You decided to get rid of your debt.';
            $http({
            method: 'post',
            url: r_url,
            data: $.param({ 'keyname' : key, 'section' : $scope.section, 'action' : 'delete' }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).
            success(function(data, status, headers, config) {
                //console.log(data);
                if(data.success){
                    if($scope.section == "cms_privileges"){
                        //console.log(data.records);
                        $scope.manageprivileges.records = (data.records);
                    }
                    if($scope.section == "manage_roles"){
                        $scope.manageroles.records = (data.records);
                    }
                    if($scope.section == "cms_users"){
                        $scope.manageusers.records = (data.records);
                    }
                    var index = $scope.lists.indexOf(y);
                    //$scope.post.users.splice(index, 1);
                    $scope.lists.splice(index, 1);
                    $scope.messageSuccess(data.message);
                }else{
                    $scope.messageFailure(data.message);
                }
            }).
            error(function(data, status, headers, config) {
                $scope.messageFailure(data.message);
            });

            }, function() {
                $scope.status = 'You decided to keep your debt.';
            });
        }

        if(val=='changepwd'){
            var modalInstance = $uibModal.open({
            templateUrl: '/changepwd.html',
            controller: ModalInstanceCtrl,
            scope: $scope,
            backdrop: 'static',
            resolve: {
            editTask: function() {
                $scope.formData = y;
                $scope.actiontext = "Update";
                $scope.savetext = "";
                $scope.updatetext = "Update";
                $scope.parentIndex = pIndex;
            }
            }
            });
        }


		    if(val=='editrole' || val=='editprivilege' || val=='edituser'){
		    	if(val=='editrole')
		    		var editurl = '/addrole.html';
		    	if(val=='editprivilege')
		    		var editurl = '/addprivilage.html';
		    	if(val=='edituser')
		    		var editurl = '/adduser.html';
            $scope.getgroup_sectionselect(y.entity_type,y.enity_name);
	      		var modalInstance = $uibModal.open({
		          templateUrl: editurl,
		          controller: ModalInstanceCtrl,
		          scope: $scope,
		          backdrop: 'static',
		          resolve: {
		            editTask: function() {
		              $scope.formData = y;
		              $scope.actiontext = "Update";
		              $scope.savetext = "";
		              $scope.updatetext = "Update";
		              $scope.parentIndex = pIndex;
		            }
		          }
		        });
	      	}

	};




  function DialogController($scope, $mdDialog , lists,subData) {
  	$scope.lists1 = lists;
  	$scope.subData1 = subData;
   // console.log($scope.lists1.conference_id);
    $scope.hide = function() {
      $mdDialog.hide();
    };
    $scope.cancel = function() {
      $mdDialog.cancel();
    };
    $scope.answer = function(answer) {
      $mdDialog.hide(answer);
    };

    $scope.statusText2 = function(no,y) {
        // console.log(y);
         if(y=='conference_id'){

            if($scope.lists1.conference_id!==null){
            var c_i = $scope.lists1.conference_id.length;

            var tags = '';
            for(_c=0;_c<c_i;_c++){
               tags += $scope.lists1.conference_id[_c].name +", ";
            }

            return tags.replace(/,\s*$/, "");
            }
         }else{
        	 if (isNaN(no)==false){
             return $scope.subData1[0].columns[y].editoptions.enumvalues[no];

           }
          else{
           return no.replace(/(<([^>]+)>)/ig,"");
           }
        }
      }
  }



      // modal Controller
      // -----------------------------------

    $scope.modalOpen = function (editTask) {

       // console.log($scope.subData[0].columns);
         // $scope.tempDetails = {type : $scope.subData[0].columns};
      	 $scope.tempDetails = {};
      	 $scope.actiontext = "Add";
        var modalInstance = $uibModal.open({
          templateUrl: '/myModalContent.html',
          controller: ModalInstanceCtrl,
          scope: $scope,
          resolve: {
            editTask: function() {
              return editTask;
            }
          }
        });

        modalInstance.result.then(function () {
          // Modal dismissed with OK status
        }, function () {
          // Modal dismissed with Cancel status

        });

    };


    $scope.modalRoleOpen = function (editTask) {

      	 $scope.actiontext = "Add";
      	 $scope.savetext = "Save";
      	 $scope.updatetext = "";
        var modalInstance = $uibModal.open({
          templateUrl: '/addrole.html',
          controller: ModalInstanceCtrl,
          scope: $scope,
          resolve: {
            editTask: function() {
              return editTask;
            }
          }
        });

        modalInstance.result.then(function () {
          // Modal dismissed with OK status
        }, function () {
          // Modal dismissed with Cancel status

        });

    };



  $scope.exportRoleData = function () {
    var sheetname = $scope.sectionName;
     var mystyle = {
      sheetid: sheetname + ' Sheet',
      headers: true,
      caption: {
        title: sheetname + ' Table',
        style:'font-size: 14px; color:blue;text-transform:capitalize' // Sorry, styles do not works
      },
      style:'background:#ffffff',
      column: {
        style:'font-size:30px'
      }
  };

   alasql('SELECT * INTO XLSX("'+sheetname+'.xlsx",?) FROM ?',[mystyle,$scope.roles.records
  ]);
   //alasql('SELECT * INTO XLSX("'+sheetname+'.xlsx",{headers:true})\ FROM HTML("#MyInquires",{headers:true})');

  };



    $scope.modalUsersOpen = function (editTask) {    console.log($scope.tempDetails);
      	 $scope.actiontext = "Add";
      	 $scope.savetext = "Save";
      	 $scope.updatetext = "";
        var modalInstance = $uibModal.open({
          templateUrl: '/adduser.html',
          controller: ModalInstanceCtrl,
          scope: $scope,
          resolve: {
            editTask: function() {
              return editTask;
            }
          }
        });

        modalInstance.result.then(function () {
          // Modal dismissed with OK status
        }, function () {
          // Modal dismissed with Cancel status

        });

    };


   $scope.exportUsersData = function () {
    var sheetname = $scope.sectionName;
     var mystyle = {
      sheetid: sheetname + ' Sheet',
      headers: true,
      caption: {
        title: sheetname + ' Table',
        style:'font-size: 14px; color:blue;text-transform:capitalize' // Sorry, styles do not works
      },
      style:'background:#ffffff',
      column: {
        style:'font-size:30px'
      }
  };

   // debugger;


     $scope.listsexport = [];

      if($scope.searchObj != undefined) {
        var searchData = $scope.searchObj[$scope.searchField];
             for(_i=0;_i<$scope.manageusers.records.length; _i++) {
           if($scope.manageusers.records[_i][$scope.searchField].indexOf(searchData)!=-1){
              $scope.listsexport.push($scope.manageusers.records[_i]);
           }
         }

       } else {
        $scope.listsexport = $scope.manageusers.records;
       }
     if($scope.listsexport)
          alasql('SELECT * INTO XLSX("'+sheetname+'.xlsx",?) FROM ?',[mystyle,$scope.listsexport]);
     else
           alasql('SELECT * INTO XLSX("'+sheetname+'.xlsx",?) FROM ?',[mystyle,$scope.listsexport]);


  // alasql('SELECT * INTO XLSX("'+sheetname+'.xlsx",?) FROM ?',[mystyle,$scope.manageusers.records]);
   //alasql('SELECT * INTO XLSX("'+sheetname+'.xlsx",{headers:true})\ FROM HTML("#MyInquires",{headers:true})');

  };



    $scope.reportActions       = function(sAction) {
      	if(sAction == 'custom' ) {
      		$scope.modalDatePopupOpen();
      	}
    }

    $scope.modalDatePopupOpen = function () {
        	$scope.actiontext = 'Select Date Range';
      	    $scope.startDt = new Date();
      	    $scope.closeDt = new Date();
	        var modalInstance = $uibModal.open({
	          templateUrl: '/customDate.html',
	          controller: ModalInstanceCtrl,
	          scope     : $scope,

	        });
	        modalInstance.result.then(function () {
	          // Modal dismissed with OK status
	        }, function () {
	          // Modal dismissed with Cancel status
	        });
      };



    $scope.modalPrivilageOpen = function (editTask) {
      	 $scope.actiontext = "Add";
      	 $scope.savetext = "Save";
      	 $scope.updatetext = "";
        var modalInstance = $uibModal.open({
          templateUrl: '/addprivilage.html',
          controller: ModalInstanceCtrl,
          scope: $scope,
          resolve: {
            editTask: function() {
              return editTask;
            }
          }
        });

        modalInstance.result.then(function () {
          // Modal dismissed with OK status
        }, function () {
          // Modal dismissed with Cancel status

        });

    };



  $scope.exportPrivilageData = function () {
    var sheetname = $scope.sectionName;
     var mystyle = {
      sheetid: sheetname + ' Sheet',
      headers: true,
      caption: {
        title: sheetname + ' Table',
        style:'font-size: 14px; color:blue;text-transform:capitalize' // Sorry, styles do not works
      },
      style:'background:#ffffff',
      column: {
        style:'font-size:30px'
      }
  };

   alasql('SELECT * INTO XLSX("'+sheetname+'.xlsx",?) FROM ?',[mystyle,$scope.manageprivileges.records
  ]);
   //alasql('SELECT * INTO XLSX("'+sheetname+'.xlsx",{headers:true})\ FROM HTML("#MyInquires",{headers:true})');

  };



      // Please note that $uibModalInstance represents a modal window (instance) dependency.
      // It is not the same as the $uibModal service used above.

      var ModalInstanceCtrl = function ($scope, $uibModalInstance) {

        $scope.modalCancel = function () {
          $uibModalInstance.dismiss('cancel');

        };


      };

       ModalInstanceCtrl.$inject = ['$scope', '$uibModalInstance'];


   		//date functions
   	    $scope.clear = function () {
        	$scope.dt = null;
      	};

      // Disable weekend selection
	    $scope.disabled = function(date, mode) {
          return false;
	       // return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
	    };



	    $scope.open = function($event,key) {
	        $event.preventDefault();
	        $event.stopPropagation();
	        $scope.dateOpened = true;
	       /* if($scope.dateOpened[key] === undefined) {
	        	$scope.dateOpened[key] = true;
	   		 }*/
	    };


	    $scope.openStart = function($event) {
	    	$event.preventDefault();
	        $event.stopPropagation();
	        $scope.dateStart = true;
	    }
	     $scope.openClose = function($event) {
	    	$event.preventDefault();
	        $event.stopPropagation();
	        $scope.dateClose = true;
	    }


	   $scope.link = function(scope, element) {


        element.find('a').on('click', function (event) {
          var ele = angular.element(this),
              par = ele.parent()[0];

          // remove active class (ul > li > a)
          var lis = ele.parent().parent().children();
          angular.forEach(lis, function(li){
            if(li !== par)
              angular.element(li).removeClass('active');
          });

          var next = ele.next();
          if ( next.length && next[0].tagName === 'UL' ) {
            ele.parent().toggleClass('active');
            event.preventDefault();
          }
        });
       }


        // on mobiles, sidebar starts off-screen
        if ( onMobile() ) $timeout(function(){
          $rootScope.icarusApp.sidebar.isOffscreen = true;
        });
        // hide sidebar on route change
        $rootScope.$on('$stateChangeStart', function() {
            if ( onMobile() )
              $rootScope.icarusApp.sidebar.isOffscreen = true;
        });

      /*  $window.addEventListener('resize', function(){
            $timeout(function(){
                if($rootScope.icarusApp.sidebar != undefined ) { $rootScope.icarusApp.sidebar.isOffscreen = onMobile(); }
            });
        });*/

         function onMobile() {
          return $window.innerWidth < MEDIA_QUERY.tablet;
        }

});
