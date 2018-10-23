
var sliderApp 		= angular.module('sliderApp',['ngAnimate']);
sliderApp.controller('SliderController', function($scope,$http) {
	// controller of slider-app
	$scope.list 					= 'list';
	$scope.banner 					= 'banner';
});

sliderApp.directive('slider', function ($timeout) {
  	return {
	    restrict 	: 'AE',
		replace  	: true,
		/*scope 		: false,*/
		scope 		: 	{
			listing  	: '=',
        },
		
	    link: function (scope, elem, attrs) {
			scope.settings 	= {

				//slider config
				noOfSliders 	: 8,
				serverSync 		: false,
				sliderPagination : true,
				rotation 		: false,

				//slide show
				autoSlideShow 	: false,
				slideShowInterval : 1000,
				
				//full listing config
				fullListing 	: false,
				//maxCardsPerPage : 80,

				//lazy loading
				appendLoading 	: false,
			};

			// hard coded set of images for slider
			scope.images 	= [];
			scope.images 	= [
				{src:'img8.jpg',title:'Pic 8'},
				{src:'img9.jpg',title:'Pic 9'},
				{src:'img10.jpg',title:'Pic 10'},
				{src:'img11.jpg',title:'Pic 11'},
				{src:'img12.jpg',title:'Pic 12'},
				{src:'img4.jpg',title:'Pic 8'},
				{src:'img5.jpg',title:'Pic 9'},
				{src:'img6.jpg',title:'Pic 10'},

				{src:'img6.jpg',title:'Pic 10'},
				{src:'img5.jpg',title:'Pic 9'},
				{src:'img4.jpg',title:'Pic 8'},
				{src:'img12.jpg',title:'Pic 12'},
				{src:'img11.jpg',title:'Pic 11'},
				{src:'img10.jpg',title:'Pic 10'},
				{src:'img9.jpg',title:'Pic 8'},

				/*{src:'img12.jpg',title:'Pic 12'},
				{src:'img4.jpg',title:'Pic 8'},
				{src:'img5.jpg',title:'Pic 9'},
				{src:'img6.jpg',title:'Pic 10'},
				{src:'img8.jpg',title:'Pic 8'},
				{src:'img9.jpg',title:'Pic 9'},
				{src:'img10.jpg',title:'Pic 10'},
				{src:'img11.jpg',title:'Pic 11'},*/
				
			];

			if(scope.listing == "list") {                
            }
            if(scope.listing == "banner") {
            	alert(IMG_PATH);
            	scope.settings.rotation 		= true;
                scope.settings.noOfSliders 		= 1
                scope.bannerUrl = "http://localhost/ICARUS//project/styles/images/slider/";
                scope.images 	= [
					{src: scope.bannerUrl + 'nkh6rkspi3j.jpg',title:'Pic 8'},
					{src: scope.bannerUrl + '1.jpg',title:'Pic 9'},
					{src: scope.bannerUrl + '2.jpg',title:'Pic 10'},
					{src: scope.bannerUrl + '3.jpg',title:'Pic 11'},
					{src: scope.bannerUrl + '4.jpg',title:'Pic 12'},
					{src: scope.bannerUrl + '5.jpg',title:'Pic 8'},
				];
            }

			scope.direction = 'left';
			

			scope.visibleImageLength = scope.settings.noOfSliders;



			//scope.getAllFromServer();

			scope.currentIndex = 0;
			scope.next = function() {
				if(!scope.settings.appendLoading) {
					if(!scope.settings.serverSync && scope.settings.sliderPagination) {
						scope.direction = 'left';
						if(!scope.settings.rotation) {
							scope.currentIndex + scope.settings.noOfSliders - 1 < scope.images.length - 1 ? scope.currentIndex = scope.currentIndex + scope.settings.noOfSliders : scope.currentIndex = scope.currentIndex;
						}
						else {
							scope.currentIndex + scope.settings.noOfSliders - 1 < scope.images.length - 1 ? scope.currentIndex = scope.currentIndex + scope.settings.noOfSliders : scope.currentIndex = 0;
						}
						
					}
					else if(scope.settings.serverSync && scope.settings.sliderPagination) {
						scope.images 	= [
							{src:'img6.jpg',title:'Pic 10'},
							{src:'img5.jpg',title:'Pic 9'},
							{src:'img4.jpg',title:'Pic 8'},
							{src:'img12.jpg',title:'Pic 12'},
							{src:'img11.jpg',title:'Pic 11'},
							{src:'img10.jpg',title:'Pic 10'},
						];
						scope.renderImage();
					}
				}
				else {
					if(scope.settings.serverSync && scope.settings.sliderPagination) {
						scope.images.push(
							{src:'img6.jpg',title:'Pic 10'},
							{src:'img5.jpg',title:'Pic 9'},
							{src:'img4.jpg',title:'Pic 8'},
							{src:'img12.jpg',title:'Pic 12'}
						);
						scope.renderImage();
					}
					if(!scope.settings.serverSync && scope.settings.sliderPagination) {
						if(scope.visibleImageLength < scope.images.length) {
							scope.visibleImageLength = scope.visibleImageLength + scope.settings.noOfSliders;
							scope.renderImage(scope.visibleImageLength);
						}
						
					}
				}
			};
			
			scope.prev = function() {
				if(!scope.settings.appendLoading) {
					if(!scope.settings.serverSync && scope.settings.sliderPagination) {
						scope.direction = 'right';
						if(!scope.settings.rotation) {
							scope.currentIndex > 0 ? scope.currentIndex = scope.currentIndex - scope.settings.noOfSliders : scope.currentIndex = scope.currentIndex;
						}
						else {
							scope.currentIndex > 0 ? scope.currentIndex = scope.currentIndex - scope.settings.noOfSliders : scope.currentIndex = scope.images.length - scope.settings.noOfSliders;
						}
					}
					else if(scope.settings.serverSync && scope.settings.sliderPagination) {
						scope.images 	= [
							{src:'img12.jpg',title:'Pic 12'},
							{src:'img11.jpg',title:'Pic 11'},
							{src:'img10.jpg',title:'Pic 10'},
							{src:'img6.jpg',title:'Pic 10'},
							{src:'img5.jpg',title:'Pic 9'},
							{src:'img4.jpg',title:'Pic 8'},
						];
						scope.renderImage();
					}
				}
			};

			scope.renderImage = function(renderLimit) {
				if(renderLimit) {
					for (var i = scope.currentIndex; i < renderLimit; i++) {
						if (scope.images[i] != undefined) {
							scope.images[i].visible = true;
						}
					};
				}
				else {
					for (var i = scope.currentIndex; i < scope.images.length; i++) {
						if (scope.images[i] != undefined) {
							scope.images[i].visible = true;
						}
					};
				}
				
			};
			
			scope.$watch('currentIndex',function() {
				if(scope.images && !scope.settings.serverSync) {
					scope.images.forEach(function(image) {
						image.visible = false;
					});
					for (var i = scope.currentIndex; i < scope.currentIndex + scope.settings.noOfSliders; i++) {
						if (scope.images[i] != undefined) {
							scope.images[i].visible = true;
						}
					};

					scope.previousLink 	= true;
					scope.nextLink 		= true;
					scope.currentIndex == 0 ? scope.previousLink = false : scope.previousLink = true;
					scope.currentIndex + scope.settings.noOfSliders - 1 >= scope.images.length-1 ? scope.nextLink = false : scope.NextLink = true;
				}
				else {
					scope.renderImage();
				}
				
			});

			scope.arrowFunct = function(keyEvent) {
			  	if (keyEvent.which === 37) {
			    	scope.prev();
			  	}
			    if (keyEvent.which === 39) {
			    	scope.next();
			    }
			}

			/* Start: For Automatic slideshow*/
			if(scope.settings.autoSlideShow) {
				var timer;
				var sliderFunc = function() {
					timer = $timeout(function() {
						scope.next();
						timer = $timeout(sliderFunc,scope.settings.slideShowInterval);
					},scope.settings.slideShowInterval);
				};
				
				sliderFunc();
				
				scope.$on('$destroy',function() {
					$timeout.cancel(timer);
				});
			}
			/* End : For Automatic slideshow*/
	    },
		/*templateUrl:'templates/templateurl.html'*/
		templateUrl: function(elem,attrs) {
            return attrs.templateUrl;
        }
  	}
});

/*sliderApp.animation('.slide-animation', function () {
    return {
        beforeAddClass: function (element, className, done) {
            var scope = element.scope();

            if (className == 'ng-hide') {
                var finishPoint = element.parent().width();
                if(scope.direction !== 'right') {
                    finishPoint = -finishPoint;
                }
                TweenMax.to(element, 1.1, {left: finishPoint, onComplete: done });
            }
            else {
                done();
            }
        },
        removeClass: function (element, className, done) {
            var scope = element.scope();

            if (className == 'ng-hide') {
                element.removeClass('ng-hide');

                var startPoint = element.parent().width();
                if(scope.direction === 'right') {
                    startPoint = -startPoint;
                }

                TweenMax.fromTo(element, 1.1, { left: startPoint }, {left: 0, onComplete: done });
            }
            else {
                done();
            }
        }
    };
});*/

/*sliderApp.directive('slider1', function ($timeout) {
  	return {
	    restrict 	: 'AE',
		replace  	: true,
		scope 		: false,
		
	    link: function (scope, elem, attrs) {
			scope.aSettings 	= {

				//slider config
				noOfSliders 	: 3,
				currentImage 	: true,
				serverSync 		: false,
				sliderPagination : true,
				
				//full listing config
				fullListing 	: false,
				maxCardsPerPage : 10,
			},

			//server sync for retrieve aImages
			//scope.aImages = scope.getAllFromServer();

			// hard coded set of aImages for slider
			scope.aImages 	= [
				{src:'img8.jpg',title:'Pic 8'},
				{src:'img9.jpg',title:'Pic 9'},
				{src:'img10.jpg',title:'Pic 10'},
				{src:'img11.jpg',title:'Pic 11'},
				{src:'img12.jpg',title:'Pic 12'},
				{src:'img4.jpg',title:'Pic 8'},
				{src:'img5.jpg',title:'Pic 9'},
				{src:'img6.jpg',title:'Pic 10'},
				
				{src:'img7.jpg',title:'Pic 11'},
				{src:'img1.jpg',title:'Pic 12'},
				{src:'img10.jpg',title:'Pic 10'},
				{src:'img11.jpg',title:'Pic 11'},
				{src:'img12.jpg',title:'Pic 12'},
				{src:'img4.jpg',title:'Pic 8'},
				{src:'img5.jpg',title:'Pic 9'},
				{src:'img6.jpg',title:'Pic 10'},
			];

			scope.currentIndex1 = 0;
			scope.next1 = function() {
				if(!scope.aSettings.serverSync) {
					scope.currentIndex1 + scope.aSettings.noOfSliders - 1 < scope.aImages.length-1 ? scope.currentIndex1 = scope.currentIndex1 + scope.aSettings.noOfSliders : scope.currentIndex1 = scope.currentIndex1;
				}
				
			};
			
			scope.prev1 = function() {
				if(!scope.aSettings.serverSync) {
					scope.currentIndex1 > 0 ? scope.currentIndex1 = scope.currentIndex1 - scope.aSettings.noOfSliders : scope.currentIndex1 = scope.currentIndex1;
				}
			};
			
			scope.$watch('currentIndex1',function() {

				scope.aImages.forEach(function(image) {
					image.visible = false;
				});
				for (var i = scope.currentIndex1; i < scope.currentIndex1 + scope.aSettings.noOfSliders; i++) {
					if (scope.aImages[i] != undefined) {
						scope.aImages[i].visible = true;
					}
				};

				scope.previousLink1 	= true;
				scope.nextLink1 		= true;
				scope.currentIndex1 == 0 ? scope.previousLink1 = false : scope.previousLink1 = true;
				scope.currentIndex1 + scope.aSettings.noOfSliders - 1 >= scope.aImages.length-1 ? scope.nextLink1 = false : scope.NextLink1 = true;
			});

			scope.arrowFunct1 = function(keyEvent) {
			  	if (keyEvent.which === 37) {
			    	scope.prev();
			  	}
			    if (keyEvent.which === 39) {
			    	scope.next();
			    }
			}
	    },
		templateUrl:'templates/templateurl-old.html'
  	}
});*/