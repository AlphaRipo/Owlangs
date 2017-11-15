<script>
    
    // ====== NG ENTER ======
    
    app.directive('ngEnter', function () {
        return function (scope, element, attrs) {
            element.bind("keydown keypress", function (event) {
                if(event.which === 13) {
                    scope.$apply(function (){
                        scope.$eval(attrs.ngEnter);
                    });
                    event.preventDefault();
                }
            });
        };
    });
    
    // ====== FULL CALENDAR ======
    
    app.directive("fullCalendar", function($rootScope){
        function link(scope, element, attrs){

            var alreadySetup = false;
            $(element).fullCalendar({
                viewRender: function(view, el){
                    //use already setup to tell if the page is appearing ,
                    //otherwise it will set it to today
                    if (alreadySetup){
                        scope.showingDate = $(element).fullCalendar('getDate').format();
                        scope.showingView = view.name;
                        scope.showingTitle = view.title;
                    }
                    else{
                        alreadySetup = true; 
                    } 
                },
                defaultView : scope.showingView,
                defaultDate : scope.showingDate,
                events:function(start, end, timezone, callback){
                     callback(scope.events);
                },
                header: { left:'', center:'', right:'' },
                editable:true,
                firstDay: 1,

                eventDrop: function(event, delta, revertFunc){
                    if(event.who === $rootScope.aboutMe.me) $rootScope.setEventDrop(event);
                    else revertFunc();
                },
                eventResize: function(event, delta, revertFunc){
                    if(event.who === $rootScope.aboutMe.me) $rootScope.setEventResize(event);
                    else revertFunc();
                },
                eventClick: function(event, delta, revertFunc){
                    $rootScope.setEventClick(event);
                },
                dayClick: function(event, delta, revertFunc){
                    $rootScope.setNewEvent(event);
                }
            });

            scope.$watchCollection('events', function(){
                $(element).fullCalendar('refetchEvents');
            });
            scope.$watch('showingDate', function(){
                $(element).fullCalendar('goToDate', scope.showingDate);
            });
            scope.$watch('showingView', function(){
                $(element).fullCalendar('changeView', scope.showingView);
            });

            scope.doNextView = function(){
                $(element).fullCalendar('next');
            };
            scope.doPreviousView = function(){
                $(element).fullCalendar('prev');
            };
        }

        return { link:link };
    });
    
    // ====== ON FINISH RENDER ======
                 
    app.directive('onFinishRender', function ($timeout) {
        return {
            restrict: 'A',
            link: function (scope, element, attr) {
                if (scope.$last === true) {
                    $timeout(function () {
                        scope.$emit('ngRepeatFinished');
                    });
                }
            }
        };
    });
    
    // ====== NG THUMB ======

    app.directive('ngThumb', ['$window', function($window) {
        var helper = {
            support: !!($window.FileReader && $window.CanvasRenderingContext2D),
            isFile: function(item) {
                return angular.isObject(item) && item instanceof $window.File;
            },
            isImage: function(file) {
                var type =  '|' + file.type.slice(file.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        };

        return {
            restrict: 'A',
            template: '<canvas/>',
            link: function(scope, element, attributes) {
                if (!helper.support) return;

                var params = scope.$eval(attributes.ngThumb);

                if (!helper.isFile(params.file)) return;
                if (!helper.isImage(params.file)) return;

                var canvas = element.find('canvas');
                var reader = new FileReader();

                reader.onload = onLoadFile;
                reader.readAsDataURL(params.file);

                function onLoadFile(event) {
                    var img = new Image();
                    img.onload = onLoadImage;
                    img.src = event.target.result;
                }

                function onLoadImage() {
                    var width = params.width || this.width / this.height * params.height;
                    var height = params.height || this.height / this.width * params.width;
                    canvas.attr({ width: width, height: height });
                    canvas[0].getContext('2d').drawImage(this, 0, 0, width, height);
                }
            }
        };
    }]);
    
    // ====== DATE TIME PICKER ======
    
    app.service('dtp', function () {

        this.dateTimeNow = function() {
            return this.date = new Date();
        };
        this.dateTimeNow();

        this.toggleMinDate = function() {
            var minDate = new Date();
            minDate.setDate(minDate.getDate() - 1); // set to yesterday
            return this.dateOptions.minDate = this.dateOptions.minDate ? null : minDate;
        };

        this.dateOptions = {
            showWeeks: false,
            startingDay: 0
        };

        this.open = function($event,opened) {
            $event.preventDefault();
            $event.stopPropagation();
            return this.dateOpened = true;
        };

        this.dateOpened = false;
        this.hourStep = 1;
        this.format = "dd-MMM-yyyy";
        this.minuteStep = 1;

        this.timeOptions = {
            hourStep: [1, 2, 3],
            minuteStep: [1, 5, 10, 15, 25, 30]
        };

        this.showMeridian = false;

        this.resetHours = function(obj) {
            return obj.setHours(1);
        };

    });
    
    // ====== LINKS ======
    
    app.factory('Links', function () {
        return function (o) {
            if(o) {
                var counter = 0;
                var youtube = 0;
                for(var i in o) {
                    var link = o[i];
                    var res1 = (link.match(/(https?:\/\/[^\s]+)/g) || []).length;
                    var res2 = (link.match(/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/) || []).length;
                    if(res1 > 0) counter++;
                    if(res2 > 0) youtube++;
                }
                return { counter:counter, youtube:youtube };
            }
        };
    });
    
    // ====== LINKS ======
    
    app.factory('GoogleVoice', function ($rootScope) {
        return function (word) {
            if(word) { 
                var pronunciation = $rootScope.aboutMe.pronunciation || { name: 'UK English Female', id: 1 };
                responsiveVoice.setDefaultVoice(pronunciation.name);
                responsiveVoice.speak(word);
            }
        };
    });

    // ====== GET DICT ======

    app.factory('Dict', function ($http,$rootScope,$log) { 

        var _getAll = function (callback) {
            callback = callback || function (){};
            $http.post('ajax/getDict.php',{ me:$rootScope.aboutMe.me,vip:$rootScope.aboutMe.vip})
                .success(callback)
                .error( function () { $log.error("Błąd getDict"); });
        };
        
        var _getMy = function (callback) {
            callback = callback || function (){};
            $http.post('ajax/getMyDict.php',{ me:$rootScope.aboutMe.id,vip:$rootScope.aboutMe.vip })
                .success(callback)
                .error( function () { $log.error("Błąd getMyDict"); });
        };
        
        return {
            getAll: _getAll,
            getMy: _getMy
        };
        
    });
        
    // ====== GET RANKING ======

    app.factory('Ranking', function ($http,$rootScope,$log) { 

        return function (callback) {
            callback = callback || function (){};
            $http.post('ajax/getUsersRank.php',{ mid:$rootScope.aboutMe.id })
                .success(callback)
                .error( function () { $log.error("Błąd getUsersRank"); });
        };
    });
    
    // ====== GET REGISTER ======

    app.factory('Register', function ($http,$log) { 

        var _seenAll = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/setRegisterSeen.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd setRegisterSeen"); });
        };
        
        var _getRegister = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/getRegister.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd getRegister"); });
        };
        
        return {
            getRegister: _getRegister,
            seenAll: _seenAll
        };
        
    });
    
    // ====== GET USER DATA ======

    app.factory('User', function ($http,$log) { 

        var _getUser = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/whoAmI.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd whoAmI"); });
        };
        
        var _saveUser = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/saveProfileData.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd saveProfileData"); });
        };

        var _registerDomain = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/registerDomain.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd registerDomain"); });
        };
        
        var _checkDomain = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/checkDomain.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd checkDomain"); });
        };
        
        var _paid = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/setPaid.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd setPaid"); });
        };
        
        var _setAvaible = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/setAvailable.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd setAvailable"); });
        };
        
        var _addScore = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/addScore.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd addScore"); });
        };
        
        var _getRank = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/getRank.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd getRank"); });
        };
        
        var _getCarousel = function (callback) {
            callback = callback || function (){};
            $http.post('ajax/getCarousel.php')
                .success(callback)
                .error( function () { $log.error("Błąd getCarousel"); });
        };
        
        return {
            registerDomain: _registerDomain,
            getCarousel: _getCarousel,
            checkDomain: _checkDomain,
            setAvaible: _setAvaible,
            saveUser: _saveUser,
            addScore: _addScore,
            getRank : _getRank,
            getUser: _getUser,
            paid: _paid
        };
    });
    
    // ====== GET ALL TRAININGS ======

    app.factory('FollowersFollowing', function ($http,$rootScope,$log) { 

        var _getData =  function (callback) {
            callback = callback || function (){};
            $http.post('ajax/getFollowersFollowing.php',{ mid:$rootScope.aboutMe.id })
                .success(callback)
                .error( function () { $log.error("Błąd getFollowersFollowing"); });
        };
        
        var _delFollowing = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/addCancelFollow.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd addCancelFollow 1"); });
        };
        
        var _addFollowing = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/addCancelFollow.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd addCancelFollow 2"); });
        };
        
        var _isFriend = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/isFriend.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd isFriend"); });
        };
        
        return {
            getData: _getData,
            delFollowing: _delFollowing,
            addFollowing: _addFollowing,
            isFriend: _isFriend
        };
    });
    
    // ====== GET ALL TRAININGS ======

    app.factory('Trainings', function ($http,$log) { 

        var _getAll = function (callback) {
            callback = callback || function (){};
            $http.post('ajax/getAllTrainings.php',{})
                .success(callback)
                .error( function () { $log.error("Błąd getAllTrainings"); });
        };

        var _getSingle = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/getMyTrainings.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd getMyTrainings"); });
        };

        var _right = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/hasRightToEditTraining.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd hasRightToEditTraining"); });
        };
        
        var _edit = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/editTraining.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd editTraining"); });
        };
        
        var _save = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/saveTraining.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd saveTraining"); });
        };
        
        var _done = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/checkInMyTrainings.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd checkInMyTrainings"); });
        };
        
        return {
            getSingle: _getSingle,
            getAll: _getAll,
            right: _right,
            done: _done,
            edit: _edit,
            save: _save
        };
    });

    // ====== POSTS ======

    app.factory('Posts', function ($http,$log) { 
        
        var _parsePost = function (msg) {
            return urlify($.emoticons.replace((msg).toString()),1);
        };
        
        var _setLike = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/setLike.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd selLike"); });
        };
        
        var _delLike = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/delLike.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd delLike"); });
        };
        
        var _getPosts = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/getPosts.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd getPosts"); });
        };
        
        var _addPost = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/addPost.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd addPost"); });
        };
        
        var _delPost = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/delPost.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd delPost"); });
        };
        
        var _savePost = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/editPost.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd editPost"); });
        };
        
        var _addComm = function (o,callback) { 
            callback = callback || function (){};
            $http.post('ajax/addComment.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd addComment"); });
        };
        
        var _delComm = function (o,callback) { 
            callback = callback || function (){};
            $http.post('ajax/delComment.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd delComment"); });
        };
        
        var _saveComm = function (o,callback) {
            callback = callback || function (){};
            $http.post('ajax/editComment.php',o)
                .success(callback)
                .error( function () { $log.error("Błąd editComment"); });
        };

        return {
            parsePost: _parsePost,
            getPosts: _getPosts,
            setLike: _setLike,
            delLike: _delLike,
            addPost: _addPost,
            delPost: _delPost,
            savePost: _savePost,
            addComm: _addComm,
            delComm: _delComm,
            saveComm: _saveComm
        };
    });

    // ====== CHAT ======

    app.factory('Chat', function ($http,$rootScope,$log) { 	
        
        var _getPeople = function (callback) {
            callback = callback || function (){};
            $http.post('ajax/getPeopleChats.php',{ mid:$rootScope.aboutMe.id })
                .success(callback)
                .error( function () { $log.error("Błąd getPeopleChats"); });        
        };
        
        var _getFriends = function (callback) {
            callback = callback || function (){};
            $http.post('ajax/getContacts2Chat.php',{ mid:$rootScope.aboutMe.id })
                .success(callback)
                .error( function () { $log.error("Błąd getContacts2Chat"); });        
        };
        
        var _getNewChats = function (callback) {
            callback = callback || function (){};

            var who = $rootScope.selected.id;
            var me = $rootScope.aboutMe.id;
            var array = $rootScope.messages;
            var lastest = 0;
            if(array.length > 0) { lastest = array[array.length - 1].id; }

            if(array) {
                $http.post('ajax/getNewChats.php',{ lastest:lastest,who:who,me:me })
                    .success(callback)
                    .error( function () { $log.error("Błąd getNewChats"); });
            }
        };
        
        var _seen = function (msg,callback) {
            if(msg.seen === 0) {
                callback = callback || function (){};
                $http.post('ajax/setSeenMsg.php',{ id:msg.id,me:$rootScope.aboutMe.id }).success( function () {

                    $http.post("ajax/getUnReadMsgCount.php", { mid:$rootScope.aboutMe.id })
                        .success(callback)
                        .error( function () { $log.error("Błąd pobrania szkoleń..."); });

                }).error( function () { $log.error("Błąd getUnReadMsgCount"); });
            }
        };
        
        var _parseMsg = function (msg) {
            return urlify($.emoticons.replace((msg).toString()),0);
        };
        
        var _getAvatar = function(arg){
            if($rootScope.selected) {
                if(arg === $rootScope.selected.id){
                    return $rootScope.selected.avatar;
                } else {
                    return $rootScope.aboutMe.avatar;
                }
            }
        };
        
        var _getFullName = function(arg){
            if(arg === $rootScope.selected.id){
                return $rootScope.selected.imie + ' ' + $rootScope.selected.nazwisko;
            } else {
                return $rootScope.aboutMe.imie +' '+ $rootScope.aboutMe.nazwisko;
            }
        };
        
        var _checkMe = function(arg){
            if(arg === $rootScope.selected.id){ return false; }
            else { return true; }
        };
            
        return {
            getNewChats: _getNewChats,
            getFullName: _getFullName,
            getFriends: _getFriends,
            getPeople: _getPeople,
            getAvatar: _getAvatar,
            parseMsg: _parseMsg,
            checkMe: _checkMe,
            seen: _seen
        };
    });
    
    // ====== FILTER FACTORY ======
    
    app.factory('cnFilter', function () {
        
        var _getPart1 = function(arg) {
            if(arg) {
                var i = parseInt(arg);
                if(!isNaN(i)) return { id:i };
            }
            return '';
        };
        
        var _getPart2 = function(arg) {
            return !isNaN(parseInt(arg));
        };
        
        return {
            getPart1: _getPart1,
            getPart2: _getPart2
        };
        
    });
    
    // ====== HTML FILTER ======
    
    app.filter('trustAsHtml', function ($sce) { return $sce.trustAsHtml; });
    
</script>