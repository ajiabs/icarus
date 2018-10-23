/**=========================================================
 * Module: ChatController.js
 * Controller for the Chat APP 
 =========================================================*/

(function() {
    'use strict';

    angular
        .module('icarusApp')
        .controller('ChatController', ChatController);
    /* @ngInject */
    function ChatController($rootScope, $scope) {
      var vm = this;

      vm.messages = [
        {
          time: '12m',
          name: 'Cassandra Gutierrez',
          content: 'Vivamus fermentum libero vel felis aliquet interdum. Nulla mauris sem, hendrerit sed fringilla a, facilisis vitae eros. .',
          avatar: 'app/img/user/03.jpg',
          position: 'left'
        },
        {
          time: '13m',
          name: 'Ramona Stevens',
          content: 'Donec consequat venenatis orci, et sagittis risus pretium eget.',
          avatar: 'app/img/user/02.jpg',
          position: 'right'
        },
        {
          time: '14m',
          name: 'Sara Jimenez',
          content: 'Curabitur sit amet lacus id odio volutpat faucibus nec quis enim. Donec gravida metus dictum sapien auctor eu egestas mauris hendrerit. ',
          avatar: 'app/img/user/02.jpg',
          position: 'right'
        },
        {
          time: '1h',
          name: 'Peter Porter',
          content: 'Integer venenatis ultrices vulputate. ',
          avatar: 'app/img/user/03.jpg',
          position: 'left'
        },
        {
          time: '1h',
          name: 'Karl Kennedy',
          content: 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In at consequat nibh. ',
          avatar: 'app/img/user/02.jpg',
          position: 'right'
        }
      ];

      vm.addMessage = function() {
        if ( !vm.currMessage || vm.currMessage.length === 0) {
          return;
        }

        vm.messages.push({
          time: 'now',
          name: 'Johh Doe',
          content: vm.currMessage,
          avatar: 'app/img/user/02.jpg',
          position: 'left'
        });

        vm.currMessage = '';
      };
    }
    ChatController.$inject = ['$rootScope', '$scope'];

})();



