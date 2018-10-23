/**=========================================================
 * Module: VectorMapController.js
 * jVector Maps support
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('VectorMapController', VectorMapController);

    /* @ngInject */
    function VectorMapController($scope, colors) {
      var vm = this;
      
      // SERIES & MARKERS FOR WORLD MAP
      // ----------------------------------- 

      vm.seriesData = {
        'AU': 15710,    // Australia
        'RU': 17312,    // Russia
        'CN': 123370,    // China
        'US': 12337,     // USA
        'AR': 18613,    // Argentina
        'CO': 12170,   // Colombia
        'DE': 1358,    // Germany
        'FR': 1479,    // France
        'GB': 16311,    // Great Britain
        'IN': 19814,    // India
        'SA': 12137      // Saudi Arabia
      };
      
      vm.markersData = [
        { latLng:[41.90, 12.45],  name:'Vatican City'          },
        { latLng:[43.73, 7.41],   name:'Monaco'                },
        { latLng:[-0.52, 166.93], name:'Nauru'                 },
        { latLng:[-8.51, 179.21], name:'Tuvalu'                },
        { latLng:[7.11,171.06],   name:'Marshall Islands'      },
        { latLng:[17.3,-62.73],   name:'Saint Kitts and Nevis' },
        { latLng:[3.2,73.22],     name:'Maldives'              },
        { latLng:[35.88,14.5],    name:'Malta'                 },
        { latLng:[41.0,-71.06],   name:'New England'           },
        { latLng:[12.05,-61.75],  name:'Grenada'               },
        { latLng:[13.16,-59.55],  name:'Barbados'              },
        { latLng:[17.11,-61.85],  name:'Antigua and Barbuda'   },
        { latLng:[-4.61,55.45],   name:'Seychelles'            },
        { latLng:[7.35,134.46],   name:'Palau'                 },
        { latLng:[42.5,1.51],     name:'Andorra'               }
      ];
      
      // set options will be reused later
      vm.mapOptions = {
          height:          500,
          map:             'world_mill_en',
          backgroundColor: 'transparent',
          zoomMin:         0,
          zoomMax:         8,
          zoomOnScroll:    false,
          regionStyle: {
            initial: {
              'fill':           colors.byName('gray-dark'),
              'fill-opacity':   1,
              'stroke':         'none',
              'stroke-width':   1.5,
              'stroke-opacity': 1
            },
            hover: {
              'fill-opacity': 0.8
            },
            selected: {
              fill: 'blue'
            },
            selectedHover: {
            }
          },
          focusOn:{ x:0.4, y:0.6, scale: 1},
          markerStyle: {
            initial: {
              fill: colors.byName('warning'),
              stroke: colors.byName('warning')
            }
          },
          onRegionLabelShow: function(e, el, code) {
            if ( vm.seriesData && vm.seriesData[code] )
              el.html(el.html() + ': ' + vm.seriesData[code] + ' visitors');
          },
          markers: vm.markersData,
          series: {
              regions: [{
                  values: vm.seriesData,
                  scale: [ colors.byName('gray-darker') ],
                  normalizeFunction: 'polynomial'
              }]
          },
        };

      // USA MAP
      // ----------------------------------- 
      vm.usaMarkersData = [
        {latLng: [33.9783241, -84.4783064],               name: 'Mark_1'},
        {latLng: [30.51220349999999, -97.67312530000001], name: 'Mark_2'},
        {latLng: [39.4014955, -76.6019125],               name: 'Mark_3'},
        {latLng: [33.37857109999999, -86.80439],          name: 'Mark_4'},
        {latLng: [43.1938516, -71.5723953],               name: 'Mark_5'},
        {latLng: [43.0026291, -78.8223134],               name: 'Mark_6'},
        {latLng: [33.836081, -81.1637245],                name: 'Mark_7'},
        {latLng: [41.7435073, -88.0118473],               name: 'Mark_8'},
        {latLng: [39.1031182, -84.5120196],               name: 'Mark_9'},
        {latLng: [41.6661573, -81.339552],                name: 'Mark_10'},
        {latLng: [39.9611755, -82.99879419999999],        name: 'Mark_11'},
        {latLng: [32.735687, -97.10806559999999],         name: 'Mark_12'},
        {latLng: [39.9205411, -105.0866504],              name: 'Mark_13'},
        {latLng: [42.8105356, -83.0790865],               name: 'Mark_14'},
        {latLng: [41.754166, -72.624443],                 name: 'Mark_15'},
        {latLng: [29.7355047, -94.97742740000001],        name: 'Mark_16'},
        {latLng: [39.978371, -86.1180435],                name: 'Mark_17'},
        {latLng: [30.3321838, -81.65565099999999],        name: 'Mark_18'},
        {latLng: [39.0653602, -94.5624426],               name: 'Mark_19'},
        {latLng: [36.0849963, -115.1511364],              name: 'Mark_20'},
        {latLng: [34.0596149, -118.1122679],              name: 'Mark_21'},
        {latLng: [38.3964426, -85.4375574],               name: 'Mark_22'}
      ];

      vm.mapOptions2 = angular.extend({}, vm.mapOptions,
        {
          map: 'us_mill_en',
          regionStyle: {
            initial: {
              'fill':           colors.byName('info')
            }
          },
          focusOn:{ x:0.5, y:0.5, scale: 1.2},
          markerStyle: {
            initial: {
              fill: colors.byName('success'),
              stroke: colors.byName('success'),
              r: 10
            },
            hover: {
                stroke: colors.byName('success'),
                'stroke-width': 2
              },
          },
          markers: vm.usaMarkersData,
          series: {}
        }
      );
    }
    VectorMapController.$inject = ['$scope', 'colors'];

})();
