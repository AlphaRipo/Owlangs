<script>

    'use strict';
    var app = angular.module('cnApp',['ngRoute','angular-storage','angular-jwt','ngCkeditor','chieffancypants.loadingBar','ngAnimate','ui.bootstrap','ui.bootstrap.datetimepicker','ngSanitize','angularFileUpload','mwl.confirm','ngLocale']);

    app.config(function(cfpLoadingBarProvider) {
        cfpLoadingBarProvider.includeSpinner = true;
    });
    
    app.config(['$compileProvider',function($compileProvider) {   
        $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|skype|chrome-extension):/);
    }]);

    app.config(['$routeProvider','$locationProvider',function($routeProvider,$locationProvider) {

        $locationProvider.html5Mode(true);
        // ============ WALL ============
        $routeProvider.when('/wall', { controller:'wall', templateUrl:'glowna.php' });
        $routeProvider.when('/wall/:pid', { controller:'wall', templateUrl:'glowna.php' });
        $routeProvider.when('/user/:uid', { controller:'wall', templateUrl:'glowna.php' });
        $routeProvider.when('/user/:uid/:pid', { controller:'wall', templateUrl:'glowna.php' });
        // ============ TRAININGS ============
        $routeProvider.when('/edit-training', { controller:'editTraining', templateUrl:'stworz_kurs.php' });
        $routeProvider.when('/create-training', { controller:'createTraining', templateUrl:'stworz_kurs.php' });
        $routeProvider.when('/trainings', { controller:'trainings', templateUrl:'szkolenia.php' });
        $routeProvider.when('/training/:tid', { controller:'training', templateUrl:'twoje_kursy2.php' });
        $routeProvider.when('/my-trainings/:uid', { controller:'myTrainingsTeach', templateUrl:'twoje_kursy1a.php' });
        $routeProvider.when('/completed-trainings/:uid', { controller:'myTrainingsLearn', templateUrl:'twoje_kursy1b.php' });
        // ============ WORDS ============
        $routeProvider.when('/flashcards', { controller:'flashcards', templateUrl:'sow_cw.php' });
        $routeProvider.when('/flashcards-time', { controller:'flashcardsTime', templateUrl:'sow_wyz.php' });
        $routeProvider.when('/words', { controller:'words', templateUrl:'sow_test.php' });
        $routeProvider.when('/words/:did', { controller:'words', templateUrl:'sow_test.php' });
        $routeProvider.when('/my-words/:uid', { controller:'myWords', templateUrl:'my_words.php' });
        $routeProvider.when('/my-words/:uid/:did', { controller:'myWords', templateUrl:'my_words.php' });
        // ============ REST ============
        $routeProvider.when('/rank', { controller:'ranking', templateUrl:'ranking.php' });
        $routeProvider.when('/langs', { controller:'langs', templateUrl:'langs.php' });
        $routeProvider.when('/salary', { controller:'salary', templateUrl:'zarobki.php' });
        $routeProvider.when('/premium', { controller:'premium', templateUrl:'platnosc.php' });
        $routeProvider.when('/messages', { controller:'messages', templateUrl:'wiadomosci.php' });
        $routeProvider.when('/settings', { controller:'settings', templateUrl:'ustawienia.php' });
        $routeProvider.when('/calendar/:uid', { controller:'calendar', templateUrl:'kalendarz.php' });
        $routeProvider.when('/auctions', { controller:'auctions', templateUrl:'aukcje.php' });
        $routeProvider.when('/friends/:uid', { controller:'friends', templateUrl:'znajomi.php' });
        $routeProvider.when('/profile/:uid', { controller:'profile', templateUrl:'profil.php' });
        // ============ INNE ============
        $routeProvider.otherwise({ redirectTo: '/wall' });

    }]);

    // ====== MASTER CONTROLLER ======
    
    app.controller('master',['$rootScope','$log','$routeParams','$location','$interval','$scope','User',function($rootScope,$log,$routeParams,$location,$interval,$scope,User){
                
        $scope.countAll = function () { return $rootScope.countE + $rootScope.countF + $rootScope.countM; };
        $rootScope.go = function (arg) { $location.path(arg,true); };
        
        var data = JSON.parse(localStorage.getItem("OwLangsUserData"));
        if(!data) { window.location.href = '//owlangs.com/login'; }
        
        $rootScope.showSidePanels = true;
        
        $rootScope.aboutMe = {
            id:parseInt(data.id),
            me:parseInt(data.id),
            imie:data.imie,
            nazwisko:data.nazwisko,
            avatar:data.avatar,
            back:data.back,
            mode:$routeParams.uid || 0,
            vip:data.vip,
            lvl_ang:data.lvl_ang,
            about:data.about,
            www:data.www,
            skype:data.skype,
            rank:data.rank,
            pronunciation: data.pronunciation
        };
        $rootScope.aboutUser = $rootScope.aboutMe;
        $rootScope.rankingNumber = 0;
        
        $rootScope.me = $rootScope.aboutMe.id; // na wszelki wypadek jeśli nie zmieniłem wszytskiego w widokach
        $rootScope.mid = $rootScope.aboutMe.id;
        $rootScope.path = $location.path().split("/")[1];
        $rootScope.UID = $routeParams.uid || $rootScope.aboutMe.id;
        $rootScope.UID = parseInt($rootScope.UID);
        
        $scope.$on('$routeChangeSuccess', function() { 
            
            $rootScope.path = $location.path().split("/")[1]; // wall, user, trainings etc.
            
            if($routeParams.uid && $routeParams.uid !== $rootScope.aboutMe.id) { // if params exist and it's not mine
                
                $rootScope.UID = parseInt($routeParams.uid);
                $rootScope.aboutMe.mode = $routeParams.uid;
                User.getUser({ uid:$routeParams.uid }, function(data) { $rootScope.aboutUser = data; });
                
            } else { // if params is mine or doesn't exist
                
                $rootScope.UID = parseInt($rootScope.aboutMe.id);
                $rootScope.aboutMe.mode = ($routeParams.uid === $rootScope.aboutMe.id) ? $rootScope.aboutMe.id : 0;
                $rootScope.aboutUser = $rootScope.aboutMe;
                
            }
        });
        
        // ----------

        $scope.getRanking = function() {
            User.getRank({ me:$rootScope.aboutMe.id }, function(data){
                $rootScope.rankingNumber = data.rank;
            });
        };
        $scope.getRanking();

        if(!$rootScope.newRankingInterval) {
            $rootScope.newRankingInterval = $interval(function(){ 
                $scope.getRanking();
            },77000); //77s
        }
        
        // ----------

        $scope.getCarousel = function() {
            User.getCarousel(function(data){
                $rootScope.carousel = data;
            });
        };
        $scope.getCarousel();

        if(!$rootScope.newCarouselInterval) {
            $rootScope.newCarouselInterval = $interval(function(){ 
                $scope.getCarousel();
            },300000); //300s
        }
        
        // ----------
        
        $scope.setAvailable = function (arg) {
            User.setAvaible({ mid: $rootScope.aboutMe.id, mode:arg }, function() {
                if(arg === 0) {
                    localStorage.removeItem('OwLangsUserData');
                    window.location.href="//owlangs.com";
                }
            });
        };
        $scope.setAvailable(1);

        if(!$rootScope.newAvaibleInterval) {
            $rootScope.newAvaibleInterval = $interval(function(){ 
                $scope.setAvailable(1);
            },17000); //17s
        }
        
        // ----------
        
        $rootScope.addScore = function (points,mode) {
            if(!isNaN(points)) {
                User.addScore( { mid:$rootScope.aboutMe.id, mode:mode, points:points }, function(){});
            }
        };
        
        $rootScope.log = function (log) {
            $log.info(log);
        };
        
    }]);
    
    // ====== CONTROLLER MESSAGES ======
    
    app.controller('messages',['$rootScope','$scope','$http','FileUploader','Chat','$timeout','$interval',function($rootScope,$scope,$http,FileUploader,Chat,$timeout,$interval){

        $rootScope.showSidePanels = true;

        Chat.getPeople(function(data){
            $scope.people = data;
        });
        
        Chat.getFriends(function(data){
            $scope.friends = data;
        });

        $scope.$watch(function() { return $rootScope.selected; }, function() {

            $scope.selected = $rootScope.selected;
            if($scope.selected) {
                $http.post('ajax/getSingleChat.php',{ mid:$rootScope.aboutMe.id,uid:$scope.selected.id }).success( function (data){
                    $rootScope.messages = data;

                    if(!$rootScope.chatInterval) {
                        $rootScope.chatInterval = $interval(function() { 

                            Chat.getNewChats(function(data){
                                var old = $rootScope.messages;
                                if(data.length > 0) { 
                                    $rootScope.messages = old.concat(data);
                                }
                            });

                            Chat.getPeople(function(data){
                                $scope.people = data;
                            });

                        }, 14000); //14s
                    }
                }).error( function () { console.log("Błąd getSingleChat"); });
            }
        }, true);

        $scope.writeTo = function(friend){
            $rootScope.selected = friend;
        };

        $scope.inp = {};
        $scope.lock = false;
        $scope.write = false;

        $scope.onSubmit = function(){

            var text = $scope.inp.answer;
            var images = $scope.chatImages;
            var who = $scope.selected.id;
            var me = $rootScope.aboutMe.id;

            $http.post('ajax/sendMsg.php',{ me:me,who:who,images:images,text:text }).success( function (feedback) {
                
                if(feedback === '1') {
                    
                    $scope.chatImages = [];
                    $scope.inp.answer = "";

                    Chat.getNewChats(function(data){
                        var old = $rootScope.messages;
                        if(data.length > 0) { 
                            $rootScope.messages = old.concat(data);
                        }
                    });

                    Chat.getPeople(function(data){
                        $scope.people = data;
                    });
                    
                } else {
                    $scope.cannot = true;
                    $timeout(function(){
                        $scope.cannot = false;
                    },10000);
                }
                
            }).error( function () { console.log("Błąd sendMsg"); });
        };

        $scope.getAvatar = function(arg) {
            return Chat.getAvatar(arg);
        };
        $scope.checkMe = function(arg) {
            return Chat.checkMe(arg);
        };
        $scope.getFullName = function(arg) {
            return Chat.getFullName(arg);
        };
        $scope.parseMsg = function(arg) {
            return Chat.parseMsg(arg);
        };
        $scope.seen = function(arg) {

            return Chat.seen(arg,function (data) {
                $scope.count = data.count;
                var elem = document.getElementById('chat-scroll');
                if(elem) elem.scrollTop = elem.scrollHeight;
            });

        };

        $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {                
            var elem = document.getElementById('msg-content');
            if(elem) elem.scrollTop = elem.scrollHeight;
            $timeout(function() {
                var elem = document.getElementById('msg-content');
                if(elem) elem.scrollTop = elem.scrollHeight;
            }, 1000);
        });

        // UPLOADER

        $scope.unlockSendBtn = function() {
            $scope.lock = false;
        };
        $scope.lockSendBtn = function() {
            $scope.lock = true;
        };

        var uploader = $scope.uploader = new FileUploader({
            url: 'ajax/fileUploader.php?mid='+$rootScope.aboutMe.id
        });

        uploader.filters.push({
            name: 'imageFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        });

        uploader.onCompleteItem = function(fileItem, response, status, headers) {
            $scope.lock = false;
        };

        $scope.chatImages = [];
        uploader.onSuccessItem = function(fileItem, response, status, headers) { // response - my file path
            $scope.chatImages.push(response);
            $scope.lock = false;
        };

    }]);
    
    // ====== CONTROLLER CHAT ======
    
    app.controller('chat-ctrl',['$scope','$rootScope','$http','Chat','$timeout','$interval',function($scope,$rootScope,$http,Chat,$timeout,$interval){

        $rootScope.showSidePanels = true;

        $scope.$watch(function() { return $rootScope.selected; }, function() {
            $scope.selected = $rootScope.selected;
            if($scope.selected) {
                $http.post('ajax/getSingleChat.php',{ mid:$rootScope.aboutMe.id,uid:$scope.selected.id }).success( function (data){
                    $rootScope.messages = data;
                    
                    if(!$rootScope.chatInterval) {
                        $rootScope.chatInterval = $interval(function() {

                            Chat.getNewChats(function(data){
                                var old = $rootScope.messages;
                                if(data.length > 0) { 
                                    $rootScope.messages = old.concat(data);
                                }
                            });

                        },14000); //14s
                    }
                }).error( function () { console.log("Błąd getSingleChat"); });
            }
        }, true);

        $scope.getAvatar = function(arg) {
            return Chat.getAvatar(arg);
        };
        $scope.checkMe = function(arg) {
            return Chat.checkMe(arg);
        };
        $scope.getFullName = function(arg) {
            return Chat.getFullName(arg);
        };
        $scope.parseMsg = function(arg) {
            return Chat.parseMsg(arg);
        };
        $scope.seen = function(arg) {

            return Chat.seen(arg,function (data) {
                $scope.count = data.count;
                var elem = document.getElementById('chat-scroll');
                if(elem) elem.scrollTop = elem.scrollHeight;
            });

        };

        $scope.onSubmit = function(answer){
            $scope.answer = '';
            var text = answer;
            var images = {};
            var who = $scope.selected.id;
            var me = $rootScope.aboutMe.id;

            $http.post('ajax/sendMsg.php',{ me:me,who:who,images:images,text:text }).success( function (feedback){
                
                if(feedback === '1') {
                    Chat.getNewChats(function(data){
                        var old = $rootScope.messages;
                        if(data.length > 0) { 
                            $rootScope.messages = old.concat(data);
                        }
                    });
                } else {
                    $scope.cannot = true;
                    $timeout(function(){
                        $scope.cannot = false;
                    },10000);
                }

            }).error( function () { console.log("Błąd sendMsg"); });
        };

        $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {
            var elem = document.getElementById('chat-scroll');
            if(elem) elem.scrollTop = elem.scrollHeight;
            $timeout(function() {
                var elem = document.getElementById('chat-scroll');
                if(elem) elem.scrollTop = elem.scrollHeight;
            }, 1000);
        });
        
        $scope.closeChat = function () { $('.chatWin').hide(); };

    }]);
        
    // ====== CONTROLLER CHAT LIST ======
    
    app.controller('chat-list-ctrl',['$scope','$rootScope','Chat','$interval',function($scope,$rootScope,Chat,$interval){

        $rootScope.showSidePanels = true;

        $scope.getData = function () {
            Chat.getFriends(function(data){
                $scope.friends = data;
            });
        };
        
        $scope.showMsgs = function(person) {
            $rootScope.selected = person;
            $('.chatWin').show();
        };
        
        $scope.getData();
        if(!$rootScope.chatListInterval) {
            $rootScope.chatListInterval = $interval(function() {
                $scope.getData();
            },29000); // 29s
        }
        
    }]);
     
    // ====== CONTROLLER PEOPLE (INBOX) ======
    
    app.controller('people',['$scope','$rootScope','Chat','$interval',function($scope,$rootScope,Chat,$interval){

        $rootScope.showSidePanels = true;

        $scope.showMsgs = function (person) {
            $rootScope.selected = person;
        };
        
        $scope.getData = function () {
            Chat.getPeople(function(data){
                $scope.people = data;
            });
        };
        
        $scope.getData();
        if(!$rootScope.inboxInterval) {
            $rootScope.inboxInterval = $interval(function() {
                $scope.getData();
            },31000); // 31s
        }
        
    }]);

    // ====== CONTROLLER LANGS ======
    
    app.controller('langs',['$scope','$rootScope','$http',function($scope,$rootScope,$http){

        $rootScope.showSidePanels = false;

        getLangs();
        function getLangs () {
            $http.post('ajax/getLangs.php',{}).success( function (data){
                $scope.words = data.word;
            }).error( function () { console.log("Błąd getLangs"); });
        }

        $scope.saveWord = function (mode,word) {
            if(mode) {
                $http.post('ajax/setLangs.php',{ mid:$rootScope.aboutMe.id,word:word }).success( function (){ 
                }).error( function () { console.log("Błąd setLangs"); });
            }
        };

        $scope.clearSearch = function () {
            $scope.search = '';
        };
        
        $scope.articles = {
            privacyPolicy: "",
            termsAndConditions: ""
        };
        
        $http.post('ajax/getArticle.php',{ id:1 }).success( function (data){ 
            $scope.articles.privacyPolicy = data;
        }).error( function () { console.log("Błąd getArticle ID1"); });
        
        $http.post('ajax/getArticle.php',{ id:2 }).success( function (data){ 
            $scope.articles.termsAndConditions = data;
        }).error( function () { console.log("Błąd getArticle ID2"); });
        
        $scope.saveArticle = function (html,id) {
            $http.post('ajax/saveArticle.php',{ id:id, html:html }).success( function (data){ 
            }).error( function () { console.log("Błąd saveArticle"); });
        };
        
    }]);
        
    // ====== CONTROLLER MY DICT LIST ======
    
    app.controller('myWords',['$scope','$rootScope','$timeout','$http','Dict',function($scope,$rootScope,$timeout,$http,Dict){

        $rootScope.showSidePanels = true;
        $scope.addCategoryPanel = false;

        $rootScope.addCategoryPanelReverse = function () {
            $scope.addCategoryPanel = !$scope.addCategoryPanel;
        };

        $rootScope.addCategoryPanelChange = function (arg) {
            $scope.addCategoryPanel = arg;
        };

        function getAllWords () {
            Dict.getMy(function(data){
                $scope.dicts = data.dict;
            });
        }
        getAllWords();

        $scope.delWord = function (word) {
            $http.post('ajax/delMyDictWord.php',{ mid:$rootScope.aboutMe.id, word:word }).success( function (){ getAllWords();
            }).error( function () { console.log("Błąd delMyDictWord"); });
        };

        $scope.selectDict = function (dict) {
            if(dict) {
                $rootScope.selectedDict = dict;
                $('#myModal1').modal('show');
            }
        };

        $scope.saveWord = function (mode,word) {
            if(mode) {
                $http.post('ajax/editMyDictWord.php',{ mid:$rootScope.aboutMe.id, word:word }).success( function (){ 
                }).error( function () { console.log("Błąd editMyDictWord"); });
            }
        };

        $scope.valid = 0;

        $scope.addWords = function () {
            if( $scope.newDict.title !== "" && $scope.newDict.description !== "" ) {
                $scope.valid = 1;
                $('#myModal2').modal('show');
            }
            else $scope.valid = 2;
        };

        $scope.clearSearch = function () {
            $scope.search = '';
        };

        $scope.newDict = {
            title: "",
            description: "",
            lvl: "A1",
            access: 0,
            author: $rootScope.aboutMe.me,
            words: []
        };

        $scope.levelList = [{
            value: 'A1',
            label: 'Level A1'
        },{
            value: 'A2',
            label: 'Level A2'
        },{
            value: 'B1',
            label: 'Level B1'
        },{
            value: 'B2',
            label: 'Level B2'
        },{
            value: 'C1',
            label: 'Level C1'
        },{
            value: 'C2',
            label: 'Level C2'
        }];

        $scope.accessList = [{
            value: 0,
            label: 'dostęp publiczny'
        },{
            value: 1,
            label: 'dostep tylko dla znajomych'
        },{
            value: 2,
            label: 'dostęp tylko dla VIPów'
        },{
            value: 3,
            label: 'dostęp tylko dla mnie'
        }];

        $scope.saveDict = function () {

            $scope.newDict.words = $rootScope.newDictWords;
            $http.post('ajax/setDict.php',{ dict:$scope.newDict,me:$rootScope.aboutMe }).success( function (data) {

                $scope.cannot = data.cannot;
                
                if(data.cannot === 0) {
                    $rootScope.wordsToMyDict = [];
                    $rootScope.addCategoryPanelChange(false);
                    $rootScope.categorySaved = false;
                    $scope.newDict = { title: "", description: "", lvl: "A1", access: 0, author: $rootScope.aboutMe.me, words: [] };
                    $rootScope.newDictWords = [];
                    getAllWords();
                }
                $timeout(function(){
                    $scope.cannot = null;
                },10000);

            }).error( function () { console.log("Błąd setDict"); });
        };

        $scope.dictEdit = function (mode,dict) {
            if(!mode) {
                $http.post('ajax/editDict.php',{ dict:dict, id:dict.id, me:$rootScope.aboutMe.me }).success( function () {
                }).error( function () { console.log("Błąd editMyDict"); });
            }
        };

        $scope.delDictMy = function (id) {
            $http.post('ajax/delMyDict.php',{ id:id, me:$rootScope.aboutMe.me }).success( function (data) {
                if(data) getAllWords();
            }).error( function () { console.log("Błąd delMyDict"); });
        };

        $scope.$watch(function() { return $rootScope.newDictWords; }, function() {
            $scope.newDict.words = $rootScope.newDictWords;
        }, true);

    }]);
    
    // ====== CONTROLLER DICT LIST ======
    
    app.controller('words',['$scope','$rootScope','$http','$interval','$timeout','$routeParams','cnFilter','Dict',function($scope,$rootScope,$http,$interval,$timeout,$routeParams,cnFilter,Dict){

        $scope.searchId = $routeParams.did || '';
        $rootScope.showSidePanels = true;
        $scope.addCategoryPanel = false;
        $scope.searchText = '';
        
        $scope.getFilterPart1 = function(arg) {
            return cnFilter.getPart1(arg);
        };
        $scope.getFilterPart2 = function(arg) {
            return cnFilter.getPart2(arg);
        };
        
        $rootScope.addCategoryPanelReverse = function () {
            $scope.addCategoryPanel = !$scope.addCategoryPanel;
        };

        $rootScope.addCategoryPanelChange = function (arg) {
            $scope.addCategoryPanel = arg;
        };

        $scope.getAllWords = function(mode) {
            Dict.getAll(function(data){
                $rootScope.dicts = data.dict;
                if(mode && !$rootScope.newDictInterval) {
                    $rootScope.newDictInterval = $interval(function(){ 
                        $scope.getNewDict();
                    },53000); //53s
                }
            });
        };
        $scope.getAllWords(1);

        $scope.getNewDict = function() {
            var current = $scope.dicts;
            var result = current.map( function(a) { return [a.id,a.version]; } );

            $http.post('ajax/getNewDict.php',{ tab:result,me:$rootScope.aboutMe.me,vip:$rootScope.aboutMe.vip }).success( function (data) {
                var toAdd = data.news;
                var toEdit = data.updated;
                var toDel = data.deleted;
                if(toAdd) {
                    var prop = 'id';
                    current = current.concat(toAdd);
                    current = current.sort(function(a, b) { return (b[prop] > a[prop]) ? 1 : ((b[prop] < a[prop]) ? -1 : 0); });
                }
                if(toEdit && current) {
                    for(var i in current) {
                        for(var k in toEdit) {
                            if(current[i].id === toEdit[k].id) {
                                current[i] = toEdit[k];
                            }
                        }
                    }
                }
                if(toDel && current) {
                    for(var i in current) {
                        for(var k in toDel) {
                            if(current[i].id === toDel[k]) {
                                current.splice(i,1);
                            }
                        }
                    }
                }
                if(current) $scope.dicts = current;
            }).error( function () { console.log("Błąd getNewDict"); });
        };

        $scope.delWord = function (word) {
            $http.post('ajax/delMyDictWord.php',{ mid:$rootScope.aboutMe.id,word:word }).success( function (){ $scope.getAllWords(0);
            }).error( function () { console.log("Błąd delMyDictWord"); });
        };

        $scope.selectDict = function (dict) {
            if(dict) {
                $rootScope.selectedDict = dict;
                $('#myModal1').modal('show');
            }
        };

        $scope.saveWord = function (mode,word) {
            if(mode) {
                $http.post('ajax/editMyDictWord.php',{ mid:$rootScope.aboutMe.id,word:word }).success( function (){ 
                }).error( function () { console.log("Błąd editMyDictWord"); });
            }
        };

        $scope.valid = 0;

        $scope.addWords = function () {
            if( $scope.newDict.title !== "" && $scope.newDict.description !== "") { $scope.valid = 1; $('#myModal2').modal('show'); }
            else $scope.valid = 2;
        };

        $scope.clearFilterPart1 = function () { $scope.searchId = ''; };
        $scope.clearFilterPart2 = function () { $scope.searchText = ''; };

        $scope.newDict = {
            title: "",
            description: "",
            lvl: "A1",
            access: 0,
            author: $rootScope.aboutMe.me,
            words: []
        };

        $scope.levelList = [{
            value: 'A1',
            label: 'Level A1'
        },{
            value: 'A2',
            label: 'Level A2'
        },{
            value: 'B1',
            label: 'Level B1'
        },{
            value: 'B2',
            label: 'Level B2'
        },{
            value: 'C1',
            label: 'Level C1'
        },{
            value: 'C2',
            label: 'Level C2'
        }];

        $scope.accessList = [{
            value: 0,
            label: 'dostęp publiczny'
        },{
            value: 1,
            label: 'dostep tylko dla znajomych'
        },{
            value: 2,
            label: 'dostęp tylko dla VIPów'
        },{
            value: 3,
            label: 'dostęp tylko dla mnie'
        }];

        $scope.saveDict = function () {

            $scope.newDict.words = $rootScope.newDictWords;

            $http.post('ajax/setDict.php',{ dict:$scope.newDict,me:$rootScope.aboutMe }).success( function (data) {
                
                $scope.cannot = data.cannot;
                
                if(data.cannot === 0) {
                    $rootScope.wordsToMyDict = [];
                    $rootScope.addCategoryPanelChange(false);
                    $rootScope.categorySaved = false;
                    $scope.newDict = { title: "", description: "", lvl: "A1", access: 0, author: $rootScope.aboutMe.me, words: [] };
                    $rootScope.newDictWords = [];
                    $scope.getAllWords(0);
                }
                $timeout(function(){
                    $scope.cannot = null;
                },10000);

            }).error( function () { console.log("Błąd setDict"); });
        };

        $scope.dictEdit = function (mode,dict) {
            if(!mode) {
                $http.post('ajax/editDict.php',{ dict:dict }).success( function () {
                }).error( function () { console.log("Błąd editDict"); });
            }
        };

        $scope.delDict = function (dict) {
            $http.post('ajax/delDict.php',{ dict:dict }).success( function (data) {
                if(data) $scope.getAllWords(0);
            }).error( function () { console.log("Błąd delDict"); });
        };

        $scope.$watch(function() { return $rootScope.newDictWords; }, function() {
            $scope.newDict.words = $rootScope.newDictWords;
        }, true);

    }]);
    
    // ====== CONTROLLER DICT WORDS ======
        
    app.controller('dict-words',['$rootScope','$scope','$http','$timeout','GoogleVoice',function($rootScope,$scope,$http,$timeout,GoogleVoice){

        $rootScope.showSidePanels = true;
        $scope.addWordsPanel = false;

        $scope.$watch(function() { return $rootScope.selectedDict; }, function() {
            $scope.selectedDict = $rootScope.selectedDict;
        }, true);

        $scope.can = [{ "pl" : "", "en" : "", "example" : "", "image" : "", "audio" : "", "author" : $rootScope.aboutMe.me }];

        $scope.addItem = function() {
            var ele = { "pl" : "", "en" : "", "example" : "", "image" : "", "audio" : "", "author" : $rootScope.aboutMe.me  };
            $scope.can.push(ele);
        };

        $scope.delItem = function(o) {
            var index = $scope.can.indexOf(o);
            $scope.can.splice(index,1);     
        };
        
        $scope.saveWords = function() {
            
            var temp = $scope.selectedDict.words ? $scope.selectedDict.words.length : 0;
            
            if((temp + $scope.can.length) <= 100 || $rootScope.aboutMe.vip === 1) {
                
                $scope.cannot = 0;

                var tab = [];
                for(var i in $scope.can) {

                    if($scope.can[i].en && $scope.can[i].en !== "") {
                        tab.push($scope.can[i]);
                    }
                }
                $scope.can = tab;
                $http.post('ajax/setWords.php',{ words:$scope.can, sd:$scope.selectedDict }).success( function (data) {
                    $scope.can = [{ "pl" : "", "en" : "", "example" : "", "image" : "", "audio" : "", "author" : $rootScope.aboutMe.me }];
                    $scope.selectedDict.words = data.can;
                }).error( function () { console.log("Błąd setWords"); });
            }
            else { $scope.cannot = 1; }
        };

        $scope.saveWord = function(mode,word,index) {
            if(!mode) {
                $http.post('ajax/setWord.php',{ word:word, id:$scope.selectedDict.id, index:index }).success( function () {
                }).error( function () { console.log("Błąd setWord"); });
            }
        };

        $scope.delWord = function (word,index) {
            $http.post('ajax/delWord.php',{ word:word, id:$scope.selectedDict.id, index:index }).success( function (data) {
                $scope.selectedDict.words = data.can;
            }).error( function () { console.log("Błąd delWord"); });
        };

        $scope.check = false;
        $rootScope.wordsToMyDict = [];

        $scope.status = false;
        $scope.isAdded = function (word) {
            var arr = $rootScope.wordsToMyDict;
            for(var i in arr) {
                if(angular.equals(arr[i],word)){ // !!! JOSN COMPARE 2 OBJECTS
                    return true;
                    break;
                }
            }
            return false;
        };

        $scope.addMyDictWord = function (word) {
            $rootScope.wordsToMyDict.push(word);
        };

        $scope.delMyDictWord = function (word) {
            var arr = $rootScope.wordsToMyDict;
            for(var i in arr){
                if(angular.equals(arr[i],word)){ // !!! JOSN COMPARE 2 OBJECTS
                    arr.splice(i,1);
                    break;
                }
            }
            $rootScope.wordsToMyDict = arr;
        };

        $scope.saveInMyDict = function (o) {
            if(o.words) {

                var id = o.id;
                var sd = $scope.selectedDict;
                var arr = $rootScope.dicts;
                for(var i in arr) {
                    if(angular.equals(arr[i],sd)){ // !!! JOSN COMPARE 2 OBJECTS
                        arr[i].exist = 1; // I'm searching item to change exist flag
                        break;
                    }
                }
                $rootScope.dicts = arr; // I change exist flag
                $scope.selectedDict.exist = 1;

                $http.post('ajax/saveInMyDict.php',{ me:$rootScope.aboutMe.me,id:id }).success( function () {
                }).error( function () { console.log("Błąd saveInMyDict"); });

            } else {

                $('#myModal1').modal('hide');
                $rootScope.addCategoryPanelChange(true);
                $rootScope.newDictWords = o;

                $rootScope.categorySaved = true;
                $timeout(function() {
                    $rootScope.categorySaved = false;
                }, 60000); //60s
            }
        };
        
        $scope.speak = function (word) {
            GoogleVoice(word);
        };
        
    }]);
        
    // ====== CONTROLLER CREATE DICT ======
    
    app.controller('create-dict',['$scope','$rootScope','GoogleVoice',function($scope,$rootScope,GoogleVoice){

        $rootScope.showSidePanels = true;
        $scope.addWordsPanel = false;

        $scope.can = [{ "pl" : "", "en" : "", "example" : "", "image" : "", "audio" : "", "author" : $rootScope.aboutMe.id, "imie": $rootScope.aboutMe.imie, "nazwisko": $rootScope.aboutMe.nazwisko, "avatar": $rootScope.aboutMe.avatar }];

        $scope.addItem = function() {
            var ele = { "pl" : "", "en" : "", "example" : "", "image" : "", "audio" : "", "author" : $rootScope.aboutMe.id, "imie": $rootScope.aboutMe.imie, "nazwisko": $rootScope.aboutMe.nazwisko, "avatar": $rootScope.aboutMe.avatar };
            $scope.can.push(ele);
        };

        $scope.delItem = function(o) {
            var index = $scope.can.indexOf(o);
            $scope.can.splice(index,1);     
        };

        $scope.saveWords = function() {
            
            var temp = $rootScope.newDictWords ? $rootScope.newDictWords.length : 0;
            
            if((temp + $scope.can.length) <= 100 || $rootScope.aboutMe.vip === 1) {
                
                $scope.cannot = 0;
                
                var tab = [];
                for(var i in $scope.can) {

                    if($scope.can[i].en && $scope.can[i].en !== "") {
                        tab.push($scope.can[i]);
                    }
                }
                $scope.can = tab;

                if($scope.can && $rootScope.newDictWords) { $rootScope.newDictWords = $rootScope.newDictWords.concat($scope.can); }
                else if($scope.can && !$rootScope.newDictWords) { $rootScope.newDictWords = $scope.can; }

                $scope.can = [{ "pl" : "", "en" : "", "example" : "", "image" : "", "audio" : "", "author" : $rootScope.aboutMe.id, "imie": $rootScope.aboutMe.imie, "nazwisko": $rootScope.aboutMe.nazwisko, "avatar": $rootScope.aboutMe.avatar }];
            }
            else { $scope.cannot = 1; }
        };

        $scope.delWord = function (index) {
            $rootScope.newDictWords.splice(index,1);
        };

        $scope.delMyDictWord = function (word) {
            var arr = $rootScope.wordsToMyDict;
            for(var i in arr){
                if(angular.equals(arr[i],word)){ // !!! JOSN COMPARE 2 OBJECTS
                    arr.splice(i,1);
                    break;
                }
            }
            $rootScope.wordsToMyDict = arr;
        };
        
        $scope.speak = function (word) {
            GoogleVoice(word);
        };
        
    }]);
    
    // ====== CONTROLLER SEARCH ENGINE ======
    
    app.controller('searchEngine',['$scope','$rootScope','$http','$log','Posts','Links','FollowersFollowing',function($scope,$rootScope,$http,$log,Posts,Links,FollowersFollowing){

        $rootScope.showSidePanels = true;

        $scope.captureText = function (text) {
            Posts.addPost({ id:$rootScope.aboutMe.id, content:text, files:"", reach:0, todo:[] }, function(){
                $scope.search = '';

                Posts.getPosts({ mid:$rootScope.aboutMe.id, vip:$rootScope.aboutMe.vip, pid:0, mode:$rootScope.aboutMe.mode },function(data){ // only new posts !!!
                    try { $rootScope.updatePosts(data); }
                    catch(err) { $log.warn("Wall doesn't exist"); }
                });
                $rootScope.addScore(20,2);
            });
            $scope.showSearch = false;
        };

        $scope.onSearch = function (text) {
            $scope.getResults(text);
        };

        $scope.closeSearch = function () {
            $scope.showSearch = false;
        };

        $scope.getResults = function (text) {
            if(text !== "")
            {
                var mid = $rootScope.aboutMe.id;
                $http.post("ajax/getSearchResult.php", { text:text,mid:mid }).success( function (data)
                {
                    $scope.mid = mid;
                    $scope.usersResults = data.users;
                    $scope.trainingsResults = data.trainings;
                }).error( function () { console.log("Błąd getSearchResult"); });
            }
        };
        
        $scope.add2Friends = function (uid) {
            FollowersFollowing.addFollowing({ mid:$rootScope.aboutMe.id, user:uid, mode:"insert"});
            return 1;
        };
        
        $scope.links = function (obj) {
            return Links(obj);
        };

    }]);
    
    // ====== CONTROLLER FLASH CARDS ======
    
    app.controller('flashcards',['$scope','$rootScope','Dict','$interval',function($scope,$rootScope,Dict,$interval){

        $rootScope.showSidePanels = true;
        $('.progress-bar').css('width','0%');

        $scope.word = 0;
        $scope.front = true;
        $scope.selected = {};
        $scope.en = '';
        $scope.pl = '';
        $scope.example = '';
        
        $scope.getDicts = function () {
            Dict.getAll(function(data){
                $scope.dicts = data.dict;
            });
        };
        $scope.getDicts();

        if(!$rootScope.dictsInterval) {
            $rootScope.dictsInterval = $interval(function(){
                $scope.getDicts();
            },47000); // 47s
        }

        $scope.$watch('selected', function() {
            $('.progress-bar').css('width','0%');
            $scope.word = 0;
            if($scope.selected.words) {

                $scope.en = $scope.selected.words[$scope.word].en;
                $scope.pl = $scope.selected.words[$scope.word].pl;
                $scope.example = $scope.selected.words[$scope.word].example;
            }
        });

        $scope.nextWord = function () {
            var word = $scope.word + 1;
            if($scope.selected.words) {
                if($scope.selected.words[word]) {
                    ++$scope.word; // important
                    $scope.en = $scope.selected.words[$scope.word].en;
                    $scope.pl = $scope.selected.words[$scope.word].pl;
                    $scope.example = $scope.selected.words[$scope.word].example;

                    var res = percentage($scope.word,$scope.selected.words.length);
                    $('.progress-bar').css('width',res+'%');
                }
            }
        };

        $scope.prevWord = function () {
            var word = $scope.word - 1;
            if($scope.selected.words) {
                if($scope.selected.words[word]) {
                    --$scope.word; // important
                    $scope.en = $scope.selected.words[$scope.word].en;
                    $scope.pl = $scope.selected.words[$scope.word].pl;
                    $scope.example = $scope.selected.words[$scope.word].example;

                    var res = percentage($scope.word,$scope.selected.words.length);
                    $('.progress-bar').css('width',res+'%');
                }
            }
        };

        function percentage (num,max) { return Math.floor(((num+1) / max) * 100); }

        $scope.getRandomWords = function () {
            var data = $scope.dicts;
            var entry = data[Math.floor(Math.random()*data.length)];
            $scope.selected = entry;
        };

    }]);
        
    // ====== CONTROLLER FLASH CARDS TIME ======
    
    app.controller('flashcardsTime',['$scope','$rootScope','Dict','$interval',function($scope,$rootScope,Dict,$interval){

        $rootScope.showSidePanels = true;

        $('.pro1').css('width','0%');
        $('.pro2').css('width','0%');

        $scope.word = 0;
        $scope.selected = {};
        $scope.en = '';
        $scope.pl = '';
        $scope.example = '';

        $scope.getDicts = function () {
            Dict.getAll(function(data){
                $scope.dicts = data.dict;
            });
        };
        $scope.getDicts();
        
        if(!$rootScope.dictsInterval) {
            $rootScope.dictsInterval = $interval(function(){
                $scope.getDicts();
            },49000); // 49s
        }

        $scope.restart = function () {

            $scope.stopTimer();
            $scope.word = 0;
            $scope.points = 0;
            $scope.life3 = true;
            $scope.life2 = true;
            $scope.life1 = true;
            $scope.game = true;
            $scope.gameOver = false;
            $scope.positionBar = true;
            $scope.percentage = 0;
            $('.pro1').css('width','0%');
            $('.pro2').css('width','0%');
            if($scope.selected.words) {

                $scope.en = $scope.selected.words[$scope.word].en;
                $scope.pl = $scope.selected.words[$scope.word].pl;
                $scope.example = $scope.selected.words[$scope.word].example;
                $scope.startTimer();
            }
        };

        $scope.$watch('selected', function() {
            $scope.restart();
        });

        $scope.nextWord = function () {

            var word = $scope.word + 1;
            if($scope.selected.words) {
                if($scope.selected.words[word]) {
                    ++$scope.word; // important
                    $scope.en = $scope.selected.words[$scope.word].en;
                    $scope.pl = $scope.selected.words[$scope.word].pl;
                    $scope.example = $scope.selected.words[$scope.word].example;

                    var res = percentage($scope.word,$scope.selected.words.length);
                    $('.pro2').css('width',res+'%');
                    $scope.seconds = 25;
                    return true;
                }
            }
            $scope.stopTimer();
            return false;
        };

        $scope.prevWord = function () {

            var word = $scope.word - 1;
            if($scope.selected.words) {
                if($scope.selected.words[word]) {
                    --$scope.word; // important
                    $scope.en = $scope.selected.words[$scope.word].en;
                    $scope.pl = $scope.selected.words[$scope.word].pl;
                    $scope.example = $scope.selected.words[$scope.word].example;

                    var res = percentage($scope.word,$scope.selected.words.length);
                    $('.pro2').css('width',res+'%');
                    $scope.seconds = 25;
                    return true;
                }
            }
            return false;
        };

        $scope.percentage = 0;
        $scope.points = 0;
        $scope.inputs = {};
        $scope.front = true;
        $scope.life3 = true;
        $scope.life2 = true;
        $scope.life1 = true;
        $scope.game = true;
        $scope.gameOver = false;
        $scope.positionBar = true;

        $scope.checkAnswer = function (ans) {

            if($scope.selected.words) {
                if($scope.selected.words[$scope.word]) {

                    var style1 = {'background-color':'#00aa00'};
                    var style2 = {'background-color':'#f60e1f'};

                    if(ans === $scope.en) {

                        $scope.selected.words[$scope.word].answer = 1;
                        $scope.myStyle = style1;

                    } else {

                        $scope.selected.words[$scope.word].answer = 0;
                        $scope.myStyle = style2;

                        if( $scope.life3 === true ) { $scope.life3 = false; }
                        else if( $scope.life2 === true ) { $scope.life2 = false; }
                        else if( $scope.life1 === true ) { $scope.life1 = false; }
                        else {
                            $scope.game = false;
                            $scope.gameOver = true;
                            $scope.positionBar = false;
                        }
                    }
                    $scope.inputs.answer = '';
                    $scope.seconds = 25;
                    $scope.nextWord();
                }
                var sum = 0;
                for(var i in $scope.selected.words) {
                    sum += ($scope.selected.words[i].answer) ? $scope.selected.words[i].answer : 0;
                }
                $scope.points = sum;
                $scope.percentage = percentage($scope.points-1,$scope.selected.words.length);
                $('.pro1').css('width',$scope.percentage+'%');
            }
        };

        function percentage (num,max) { return Math.floor(((num+1) / max) * 100); }

        $scope.startTimer = function () {
            $scope.seconds = 25;
            $scope.Timer = $interval(function () {
                --$scope.seconds;
                if($scope.seconds <= 0) { 
                    $scope.seconds = 25;
                    $scope.nextWord();
                }
            }, 1000);
        };

        $scope.stopTimer = function () {
            $interval.cancel($scope.Timer);  
        };

        $scope.getRandomWords = function () {
            var data = $scope.dicts;
            var entry = data[Math.floor(Math.random()*data.length)];
            $scope.selected = entry;
        };

    }]);
        
    // ====== SINGLE TRAINING CONTROLLER ======
    
    app.controller('training',['$scope','$rootScope','$route','$routeParams','$timeout','Trainings',function($scope,$rootScope,$route,$routeParams,$timeout,Trainings){
        
        $rootScope.showSidePanels = true;
        
        $scope.TID = $routeParams.tid;
        if($scope.TID) {
            Trainings.getSingle({ me:$rootScope.aboutMe.me, nr:$routeParams.tid, mode:"teach" }, function(data) { 
                if(data.results) $scope.training = data.results[0];
                $scope.cannot = data.cannot;
            });
            Trainings.done({ nr:$routeParams.tid, mid:$rootScope.aboutMe.id }, function(data) { 
                $scope.done = data;
            });
        }
        $scope.reload = function() { $route.reload(); }; // IMPORTANT !!!
        
        $rootScope.toLetters = function (num) {
            var mod = num % 26,
                pow = num / 26 | 0,
                out = mod ? String.fromCharCode(64 + mod) : (--pow, 'Z');
            return pow ? toLetters(pow) + out : out;
        };
        
        $rootScope.mieszamy = function (tablica) {
            for (var i = 0; i < tablica.length; i++) { //wykonujemy pętlę po całej tablicy
                var j = Math.floor(Math.random() * tablica.length); //losujemy wartosc z przedziału 0 - tablica.length-1
                var temp = tablica[i]; //pod zmienną temp podstawiamy wartosc  bieżącego indexu
                tablica[i] = tablica[j]; //pod bieżący index podstawiamy wartosc z indexu wylosowanego
                tablica[j] = temp; //pod wylosowany podstawiamy wartosc z bieżącego indexu
            }
            return tablica;
        };
        
        $scope.checkAnswer = function (answer,right,mode) {
            
            if(answer === right) return 1;
            if(answer !== right) return 0;
        };
        
        $scope.correctAnswers = 0;
        $scope.percentOfCorrect = 0;
        $scope.incorrectAnswers = 0;
        $('.pro1').css('width','0%');

        $scope.countAnswers = function(exe,res) {
            
            if(!exe.clicked) {
                if(res === 1) $scope.correctAnswers = $scope.correctAnswers +1;
                if(res === 0) $scope.incorrectAnswers = $scope.incorrectAnswers +1;
            }
            $scope.percentage($scope.correctAnswers);
        };
        
        $scope.percentage = function(num) { 
            
            $scope.percentOfCorrect = Math.floor(((num) / $scope.training.content.exercises.length) * 100);
            $('.pro1').css('width',$scope.percentOfCorrect+'%');
            
            if($scope.percentOfCorrect < 50) $scope.message = '<? echo langs("Sorry, it seems it is not your day"); ?>...';
            if($scope.percentOfCorrect >= 50 && $scope.percentOfCorrect < 80) $scope.message = '<? echo langs("Nice. Try again later"); ?>...';
            if($scope.percentOfCorrect >= 80) $scope.message = '<? echo langs("Congratulations"); ?>!';
        };
        
        $rootScope.ifYT = function(url) {
            return (url.match( /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/ )) ? true : false;
        };

        $rootScope.urlify = function(text) {
            return text.replace( /(https?:\/\/[^\s]+)/g, function(url) {
                if($rootScope.ifYT(url))
                {
                    return '<div style="margin-top:10px" class="video-container"><object wmode="Opaque" data=' + url.replace("watch?v=", "v/") + '></object ></div><br>'+'<a target="_blank" href="' + url + '">' + url + '</a>';
                }
                else return '<a target="_blank" href="' + url + '">' + url + '</a>';
            });
        };
        
    }]);
        
    // ====== CONTROLLER TRAININGS ======
    
    app.controller('trainings',['$scope','$rootScope','Trainings','Links','$interval',function($scope,$rootScope,Trainings,Links,$interval){
        
        $rootScope.showSidePanels = true;
        
        $scope.getTrainings = function () {
            Trainings.getAll(function(data){
                $scope.trainings = data;
            });  
        };
        $scope.getTrainings();

        if(!$rootScope.trainingsInterval) {
            $rootScope.trainingsInterval = $interval(function(){
                $scope.getTrainings();
            },42000); // 42s
        }

        $scope.clearSearch = function () {
            $scope.search = '';
        };

        $scope.links = function (obj) {
            return Links(obj);
        };

    }]);
        
    // ====== CONTROLLER TRAINING EDIT ======
    
    app.controller('editTraining',['$log','$scope','$rootScope','$timeout','$location','FileUploader','Trainings',function($log,$scope,$rootScope,$timeout,$location,FileUploader,Trainings){
            
        $rootScope.showSidePanels = true;
            
        $scope.context = "PANEL EDYCJI SZKOLENIA";
        $scope.editorOptions = {
            height:'250px'
        };
        $scope.recFilm = function() {
            $('#myModalRecordMovie').modal('show');
        };
        $scope.recAudio = function(arg) {
            $('#myModalRecordAudio').modal('show');
        };    
        $scope.attachAVFromDisc = function() {
            $('#myModalUploadFromHdd').modal('show');
        }; 
        $scope.addLink = function() {
            $('#myModalLinks').modal('show');
        }; 
        $scope.addImages = function() {
            $('#myModalAddImages').modal('show');
        };
        $scope.addWordImage = function(arg) {
            $scope.imageTemp = {};
            if(arg) {
                $scope.wordTemp = arg;
                $('#myModalWordImage').modal('show');
            } else $scope.wordTemp = {};
        };
        $scope.addArticle = function() {
            $('#myModalArticle').modal('show');
        };
        
        $scope.training = {};
        $scope.training.content = {};
        $scope.training.dict = [{},{},{}];
        $scope.training.content.audio = [];
        $scope.training.content.video = [];
        $scope.training.content.images = [];        
        $scope.training.content.exercises = [
            { answers: [ {}, {} ]},
            { answers: [ {}, {} ]},
            { answers: [ {}, {} ]}
        ];
        $scope.training.groups = 0;
        $scope.training.type = 1;
        
        if($rootScope.training2Edit) { 
            $scope.training = angular.extend($scope.training, $rootScope.training2Edit);
        }
        else { $location.path('/my-trainings/'+$rootScope.UID,true); }
        
        $scope.step = function(arg) {
             $scope.result = 0;
             $scope.all = 0;
            
            $timeout(function() { // obszedłem tu błąd apply in progress (???)
                if(arg === 'prev' && $('#stworz_kurs .nav-tabs > .active').prev('li').length > 0) {
                    $scope.result = $('#stworz_kurs .nav-tabs > .active').prev('li').find('a').trigger('click').closest('li').prevAll().length;
                    $scope.all = $('#stworz_kurs .nav-item').length -1;
                }
                if(arg === 'next' && $('#stworz_kurs .nav-tabs > .active').next('li').length > 0) { 
                    $scope.result = $('#stworz_kurs .nav-tabs > .active').next('li').find('a').trigger('click').closest('li').prevAll().length;
                    $scope.all = $('#stworz_kurs .nav-item').length -1;
                }
            });
        };
        
        $scope.goToLinks = function() {
            $('#myModalRecordMovie').modal('hide');
            $('#myModalLinks').modal('show');
        };
        
        $scope.saveTraining = function() {

            // --- I'm looking for empty items in words ---
            var temp1 = [];
            var arr1 = $scope.training.dict;
            for(var i in arr1) { 
                if(arr1[i].en) {
                    temp1.push(arr1[i]);
                }
            }
            $scope.training.dict = temp1;
            
            // --- I'm looking for empty items in tasks ---
            var temp2 = [];
            var arr2 = $scope.training.content.exercises;
            for(var j in arr2) { 
                if(arr2[j].exercise) {
                    temp2.push(arr2[j]);
                }
            }
            $scope.training.content.exercises = temp2;
            
            // --- I'm adding rest items to training obj ---
            $scope.training.who = $rootScope.aboutMe.me;
            $scope.training.content.article = $scope.training.content.article || '';
                        
            try{ $scope.training.content.links = $scope.training.content.links.split("\n"); }
            catch(e) { $log.warn('Links are not array'); }
            
            if($scope.training.name) {
                $log.info($scope.training);
                Trainings.edit({training:$scope.training},function(data){
                    $location.path('/trainings',true);
                });
            }
        };
        
        // ===================== UPLOADER IMAGES TRAINING ======================

        $scope.unlockSendBtn = function() {
            $scope.lock = false;
        };
        $scope.lockSendBtn = function() {
            $scope.lock = true;
        };

        var uploader = $scope.uploader = new FileUploader({
            url: 'ajax/fileUploader.php?mid='+$rootScope.aboutMe.id
        });

        uploader.filters.push({
            name: 'imageFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        });

        uploader.onCompleteItem = function(fileItem, response, status, headers) {
            $scope.unlockSendBtn();
        };

        uploader.onSuccessItem = function(fileItem, response, status, headers) { // response - my file path
            if(response.answer) $scope.training.content.images.push(response.answer);
            $scope.unlockSendBtn();
        };
        
        // ======================= UPLOADER IMAGES WORDS =======================

        var uploaderWordImage = $scope.uploaderWordImage = new FileUploader({
            url: 'ajax/fileUploader.php?mid='+$rootScope.aboutMe.id
        });

        uploaderWordImage.filters.push({
            name: 'imageFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        });

        uploaderWordImage.onCompleteItem = function(fileItem, response, status, headers) {
            $scope.unlockSendBtn();
        };
        
        uploaderWordImage.onSuccessItem = function(fileItem, response, status, headers) { // response - my file path
            if(response.answer) $scope.imageTemp = response.answer;
            $scope.unlockSendBtn();
        };
        
        $scope.saveImage = function() {
            var img = $scope.imageTemp;
            var wrd = $scope.wordTemp;
            var arr = $scope.training.dict;
            
            if(img && wrd) {
                
                for(var i in arr) {
                    if(angular.equals(arr[i],wrd)){ // !!! JOSN COMPARE 2 OBJECTS
                        arr[i].image = img;
                        break;
                    }
                }
                $scope.training.dict = arr;
                uploaderWordImage.clearQueue();
            }
        };
        
        // ========================= UPLOADER MOVIES ===========================
        
        var uploaderFiles = $scope.uploaderFiles = new FileUploader({
            url: 'ajax/fileUploader.php?mid='+$rootScope.aboutMe.id
        });
        
        uploaderFiles.filters.push({
            name: 'customFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                return ('|mp4|ogv|webm|'.indexOf(type) !== -1 && this.queue.length < 10);
            }
        });
        
        uploaderFiles.onCompleteItem = function(fileItem, response, status, headers) {
            $scope.unlockSendBtn();
        };

        uploaderFiles.onSuccessItem = function(fileItem, response, status, headers) { // response - my file path
            if(response.answer) $scope.training.content.video.push(response.answer);
            $scope.unlockSendBtn();
        };
        
    }]);
        
    // ====== CONTROLLER TRAINING CREATE ======
    
    app.controller('createTraining',['$log','$scope','$rootScope','$timeout','$location','FileUploader','Trainings',function($log,$scope,$rootScope,$timeout,$location,FileUploader,Trainings){

        $rootScope.showSidePanels = true;

        $scope.context = "PANEL TWORZENIA SZKOLENIA";
        $scope.editorOptions = {
            height:'250px'
        };
        $scope.recFilm = function() {
            $('#myModalRecordMovie').modal('show');
        };
        $scope.recAudio = function(arg) {
            $('#myModalRecordAudio').modal('show');
        };    
        $scope.attachAVFromDisc = function() {
            $('#myModalUploadFromHdd').modal('show');
        }; 
        $scope.addLink = function() {
            $('#myModalLinks').modal('show');
        }; 
        $scope.addImages = function() {
            $('#myModalAddImages').modal('show');
        };
        $scope.addWordImage = function(arg) {
            $scope.imageTemp = {};
            if(arg) {
                $scope.wordTemp = arg;
                $('#myModalWordImage').modal('show');
            } else $scope.wordTemp = {};
        };
        $scope.addArticle = function() {
            $('#myModalArticle').modal('show');
        };
        
        $scope.training = {};
        $scope.training.lvl = 'A1';
        $scope.training.content = {};
        $scope.training.dict = [{},{},{}];
        $scope.training.content.audio = [];
        $scope.training.content.video = [];
        $scope.training.content.images = [];        
        $scope.training.content.exercises = [
            { answers: [ {}, {} ]},
            { answers: [ {}, {} ]},
            { answers: [ {}, {} ]}
        ];
        $scope.training.groups = 0;
        $scope.training.type = 1;
        
        $scope.step = function(arg) {
             $scope.result = 0;
             $scope.all = 0;
            
            $timeout(function() { // obszedłem tu błąd apply in progress (???)
                if(arg === 'prev' && $('#stworz_kurs .nav-tabs > .active').prev('li').length > 0) {
                    $scope.result = $('#stworz_kurs .nav-tabs > .active').prev('li').find('a').trigger('click').closest('li').prevAll().length;
                    $scope.all = $('#stworz_kurs .nav-item').length -1;
                }
                if(arg === 'next' && $('#stworz_kurs .nav-tabs > .active').next('li').length > 0) { 
                    $scope.result = $('#stworz_kurs .nav-tabs > .active').next('li').find('a').trigger('click').closest('li').prevAll().length;
                    $scope.all = $('#stworz_kurs .nav-item').length -1;
                }
            });
        };
        
        $scope.goToLinks = function() {
            $('#myModalRecordMovie').modal('hide');
            $('#myModalLinks').modal('show');
        };
        
        $scope.saveTraining = function() {

            // --- I'm looking for empty items in words ---
            var temp1 = [];
            var arr1 = $scope.training.dict;
            for(var i in arr1) { 
                if(arr1[i].en) {
                    temp1.push(arr1[i]);
                }
            }
            $scope.training.dict = temp1;
            
            // --- I'm looking for empty items in tasks ---
            var temp2 = [];
            var arr2 = $scope.training.content.exercises;
            for(var j in arr2) { 
                if(arr2[j].exercise) {
                    temp2.push(arr2[j]);
                }
            }
            $scope.training.content.exercises = temp2;
            
            // --- I'm adding rest items to training obj ---
            $scope.training.who = $rootScope.aboutMe.me;
            $scope.training.content.article = $scope.training.content.article || '';
            
            try{ $scope.training.content.links = $scope.training.content.links.split("\n"); }
            catch(e) { $log.info('Links are not array'); }
            
            if($scope.training.name) {
                Trainings.save({training:$scope.training},function(data){
                    $location.path('/trainings',true);
                });
            }
        };
        
        // ===================== UPLOADER IMAGES TRAINING ======================

        $scope.unlockSendBtn = function() {
            $scope.lock = false;
        };
        $scope.lockSendBtn = function() {
            $scope.lock = true;
        };

        var uploader = $scope.uploader = new FileUploader({
            url: 'ajax/fileUploader.php?mid='+$rootScope.aboutMe.id
        });

        uploader.filters.push({
            name: 'imageFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        });

        uploader.onCompleteItem = function(fileItem, response, status, headers) {
            $scope.unlockSendBtn();
        };

        uploader.onSuccessItem = function(fileItem, response, status, headers) { // response - my file path
            if(response.answer) $scope.training.content.images.push(response.answer);
            $scope.unlockSendBtn();
        };
        
        // ======================= UPLOADER IMAGES WORDS =======================

        var uploaderWordImage = $scope.uploaderWordImage = new FileUploader({
            url: 'ajax/fileUploader.php?mid='+$rootScope.aboutMe.id
        });

        uploaderWordImage.filters.push({
            name: 'imageFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        });

        uploaderWordImage.onCompleteItem = function(fileItem, response, status, headers) {
            $scope.unlockSendBtn();
        };
        
        uploaderWordImage.onSuccessItem = function(fileItem, response, status, headers) { // response - my file path
            if(response.answer) $scope.imageTemp = response.answer;
            $scope.unlockSendBtn();
        };
        
        $scope.saveImage = function() {
            var img = $scope.imageTemp;
            var wrd = $scope.wordTemp;
            var arr = $scope.training.dict;
            
            if(img && wrd) {
                
                for(var i in arr) {
                    if(angular.equals(arr[i],wrd)){ // !!! JOSN COMPARE 2 OBJECTS
                        arr[i].image = img;
                        break;
                    }
                }
                $scope.training.dict = arr;
                uploaderWordImage.clearQueue();
            }
        };
        
        // ========================= UPLOADER MOVIES ===========================
        
        var uploaderFiles = $scope.uploaderFiles = new FileUploader({
            url: 'ajax/fileUploader.php?mid='+$rootScope.aboutMe.id
        });
        
        uploaderFiles.filters.push({
            name: 'customFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                return ('|mp4|ogv|webm|'.indexOf(type) !== -1 && this.queue.length < 10);
            }
        });
        
        uploaderFiles.onCompleteItem = function(fileItem, response, status, headers) {
            $scope.unlockSendBtn();
        };

        uploaderFiles.onSuccessItem = function(fileItem, response, status, headers) { // response - my file path
            if(response.answer) $scope.training.content.video.push(response.answer);
            $scope.unlockSendBtn();
        };
        
    }]);
        
    // ====== CONTROLLER PROFILE ======
    
    app.controller('profile',['$scope','$rootScope','$timeout','FileUploader','User',function($scope,$rootScope,$timeout,FileUploader,User){
        
        $scope.editorOptions = {
            height:'170px'
        };
        $scope.paymentSuccess = true;
        $rootScope.showSidePanels = true;
        $scope.pronunciation = $rootScope.aboutMe.pronunciation || { name: 'UK English Female', id: 1 };
        
        $scope.saveProfileData = function() {
            
            if($rootScope.aboutUser.id === $rootScope.aboutMe.id) {
                User.saveUser({me:$rootScope.aboutUser},function(data){
                    $scope.saved = true;
                    $timeout(function() {
                        $scope.saved = false;
                    },5000); //5s
                });
                localStorage.setItem("OwLangsUserData",angular.toJson($rootScope.aboutUser));
            }
        };

        $scope.registerDomain = function() {
                        
            if($rootScope.aboutUser.id === $rootScope.aboutMe.id) {
                User.registerDomain({me:$rootScope.aboutUser.id,www:$rootScope.aboutUser.www},function(data){
                    $scope.checked = false;
                    $scope.registred = data;
                    
                    $timeout(function() {
                        $scope.registred = false;
                    },15000); //15s
                });
            }
        };
        
        $scope.checkDomain = function() {
            
            if($rootScope.aboutUser.id === $rootScope.aboutMe.id) {
                User.checkDomain({www:$rootScope.aboutUser.www},function(data){
                    $scope.registred = false;
                    $scope.checked = data;
                });
            }
        };
        
        $scope.paid = function() {
            
            User.paid({me:$rootScope.aboutUser},function(data){
                $rootScope.aboutUser.vip = 1;
                $rootScope.aboutMe.vip = 1;
                $scope.paid = data;
                
                localStorage.setItem("OwLangsUserData",angular.toJson($rootScope.aboutUser));
                
                $timeout(function() {
                    $scope.paymentSuccess = false;
                },15000); //15s
            });
        };
        
        $scope.sendForm2PayLine = function() {
            $('#payline').submit();
        };
        
        $scope.setLvl = function(arg) {
            $rootScope.aboutUser.lvl_ang = arg;
            $rootScope.aboutMe.lvl_ang = $rootScope.aboutUser.lvl_ang;
            $scope.saveProfileData();
        };

        $scope.saveImage = function() {
            
            if($scope.context === 'BACKGROUND' && $scope.backgroundImage[0]) { 
                $rootScope.aboutUser.back = $scope.backgroundImage[0].answer;
                $rootScope.aboutMe.back = $rootScope.aboutUser.back;
                $('#statystyki').css('background-image','url('+ $rootScope.aboutUser.back +')');
            }
            if($scope.context === 'PROFILE' && $scope.profileImage[0]) { 
                $rootScope.aboutUser.avatar = $scope.profileImage[0].answer;
                $rootScope.aboutMe.avatar = $rootScope.aboutUser.avatar;
                $('#uzytkownik').css('background-image','url('+ $rootScope.aboutUser.avatar +')');
            }
            
            $scope.lockSendBtn();
            uploader.clearQueue();
            $scope.profileImage = [];
            $scope.backgroundImage = [];
            $scope.saveProfileData();
        };
        
        $scope.setContext = function(arg) {
            $scope.context = arg;
            uploader.url = $scope.getUrl();
        };
        
        $scope.resetImages = function(arg) {
            
            if(arg === 'BACKGROUND') {
                $rootScope.aboutUser.back = 'img/avatar/back.jpg';
                $rootScope.aboutMe.back = $rootScope.aboutUser.back;
            }
            if(arg === 'PROFILE') {
                $rootScope.aboutUser.avatar = 'img/avatar/default.jpg';
                $rootScope.aboutMe.avatar = $rootScope.aboutUser.avatar;
            }
            localStorage.setItem("OwLangsUserData",angular.toJson($rootScope.aboutMe));
        };
        
        $scope.englishMode = function (pronunciation) {
            $rootScope.aboutUser.pronunciation = pronunciation;
            $rootScope.aboutMe.pronunciation = $rootScope.aboutUser.pronunciation;
            $scope.saveProfileData();
            return pronunciation;
        };
        
        // ======================== UPLOADER ========================

        $scope.unlockSendBtn = function() {
            $scope.lock = false;
        };
        $scope.lockSendBtn = function() {
            $scope.lock = true;
        };
        $scope.lockSendBtn();
        
        $scope.getUrl = function() {
            return 'ajax/fileUploader.php?mid='+$rootScope.aboutMe.id+'&context='+$scope.context;
        };

        var uploader = $scope.uploader = new FileUploader({
            url: $scope.getUrl()
        });

        uploader.filters.push({
            name: 'imageFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        });

        uploader.onCancelItem = function(fileItem, response, status, headers) {
            $scope.lockSendBtn();
        };

        $scope.profileImage = [];
        $scope.backgroundImage = [];
        
        uploader.onSuccessItem = function(fileItem, response, status, headers) { // response - my file path
            
            if( $scope.context === 'PROFILE' ) {
                 $scope.profileImage.push(response);
            }
            if( $scope.context === 'BACKGROUND' ) {
                $scope.backgroundImage.push(response);
            }
            $scope.unlockSendBtn();
        };
        
    }]);
    
    // ====== CONTROLLER TRAININGS TEACH ======
    
    app.controller('myTrainingsTeach',['$scope','$rootScope','$http','$location','$interval','Links','Trainings',function($scope,$rootScope,$http,$location,$interval,Links,Trainings){
        
        $rootScope.showSidePanels = true;
        
        $scope.getMyTrainings = function () {
            $http.post("ajax/getMyTrainings.php", { mid:$rootScope.aboutMe.id, mode:"teach" }).success( function (data)
            {
                $scope.trainings = data.results;
            }).error( function () { console.log("Błąd getMyTrainings"); });
        };
        $scope.getMyTrainings();

        if(!$rootScope.myTrainingsInterval) {
            $rootScope.myTrainingsInterval = $interval(function(){
                $scope.getMyTrainings();
            },41000); // 41s
        }

        $scope.clearSearch = function () {
            $scope.search = '';
        };

        $scope.delTraining = function (id) {
            $.post("ajax/delFromAllTrainings.php", { nr:id, mid:$rootScope.aboutMe.id }, function() { $scope.getMyTrainings(); });
        };

        $scope.editTraining = function (training) {
            Trainings.right({ nr:training.id, mid:$rootScope.aboutMe.id }, function(data){
                if(data === 'ok') {
                    $rootScope.training2Edit = training;
                    $location.path('/edit-training',true);
                }
            });
        };

        $scope.links = function (obj) {
            return Links(obj);
        };

    }]);

    // ====== CONTROLLER TRAININGS LEARN ======
    
    app.controller('myTrainingsLearn',['$scope','$rootScope','$http','Links','$interval',function($scope,$rootScope,$http,Links,$interval){

        $rootScope.showSidePanels = true;

        $scope.getMyTrainings = function () {
            $http.post("ajax/getMyTrainings.php", { mid:$rootScope.aboutMe.id, mode:"learn" }).success( function (data)
            {
                $scope.trainings = data.results;
            }).error( function () { console.log("Błąd getMyTrainings"); });
        };
        $scope.getMyTrainings();
        
        if(!$rootScope.myTrainingsInterval) {
            $rootScope.myTrainingsInterval = $interval(function(){
                $scope.getMyTrainings();
            },44000); // 44s
        }

        $scope.clearSearch = function () {
            $scope.search = '';
        };

        $scope.delTraining = function (id) {
            $.post("ajax/delFromMyTrainings.php", { nr:id, mid:$rootScope.aboutMe.id }, function() { $scope.getMyTrainings(); });
        };

        $scope.links = function (obj) {
            return Links(obj);
        };

    }]);
        
    // ====== CONTROLLER AUCTIONS ======
    
    app.controller('auctions',['$scope','$rootScope','$http',function($scope,$rootScope,$http){

        getAuctionsData('all'); // interval ??? przerobić - TODO
        $rootScope.showSidePanels = true;

        function getAuctionsData (arg) {
            $('.btn-info').removeClass('active');
            $('.'+arg).addClass('active');
            $http.post("ajax/getAuctions.php", { mid:$rootScope.mid, mode:arg }).success( function (data)
            {
                $scope.auctions = data;
            }).error( function () { console.log("Błąd getAuctions"); });
        };

        $scope.getNgData = function (arg) { getAuctionsData(arg); };

        $scope.clearSearch = function () {
            $scope.search = '';
        };

        $scope.setId1 = function (id) {
            $('#myModal3').attr('name',id);
        };

        $scope.setId2 = function (id) {
            $('#myModal2').attr('name',id);
        };

        $scope.setId3 = function (id) {
            $('#myModal4').attr('name',id);

            $http.post("ajax/getAuctionOffers.php", { auction:id }).success( function (data)
            {
                $rootScope.offers = data;
            }).error( function () { console.log("Błąd getAuctionOffers"); });
        };

        $scope.getTypeName = function (arg1,arg2) {
            var help = "";
            if(arg2 === '1') help = " / Zlecenie";
            if(arg2 === '2') help = " / Oferta";

            if(arg1 === '1') return "Zwykła konwersacja"+help;
            else if(arg1 === '2') return "Konwersacja z native speakerem"+help;
            else if(arg1 === '3') return "Gramatyka"+help;
            else if(arg1 === '4') return "Tłumaczenie zwykłe"+help;
            else if(arg1 === '5') return "Tłumaczenie przysięgłe"+help;
            else return "Niesklasyfikowano";
        };

        $scope.delTraining = function (id) {
            bootbox.confirm("Na pewno usunąć tą aukcję?", function(result) {
                if(result) {
                    $.post("ajax/delFromAuctions.php", { nr:id, mid:$rootScope.aboutMe.id }, function() { getAuctionsData('all'); });
                }
            });
        };

    }]);
        
    // ====== CALENDAR CONTROLLER ======

    app.controller('calendar',['$scope','$rootScope','$http','$timeout',function($scope,$rootScope,$http,$timeout){
            
        $rootScope.showSidePanels = true;

        $scope.showingView = "month";
        $scope.showingDate = moment().format();
        $scope.showingTitle = moment().format("MMMM YYYY");

        $scope.viewToday = function(){
            $scope.showingDate = moment().format();
            $('#calendarBig,#calendarMini').fullCalendar('gotoDate',moment()); // the line before doesn't work so I set date by this line in jQuery
        };
        
        $scope.setView = function(view){
            $scope.showingView = view;
        };

        $scope.setEvent = function(event){
            for (var i = 0; i < $rootScope.events.length; i++){
                if ($rootScope.events[i].id === event.id){
                    $rootScope.events[i] = event;
                }
            }
            $scope.$apply();
        };
        
        $rootScope.events = [];
        
        $scope.getCalendar = function() {
            $http.post('ajax/getCalendar.php',{ me:$rootScope.aboutMe.id }).success( function (data){ 
                $rootScope.events = data;
            }).error( function () { console.log("Błąd getCalendar"); });
        };
        $scope.getCalendar();
        
        $timeout(function(){
            $scope.getCalendar();
        },47000); // 47s
        
        $rootScope.setEventDrop = function(event) {
            editEventByDropOrResize(event);
        };
        
        $rootScope.setEventResize = function(event) {
            editEventByDropOrResize(event);
        };
        
        $rootScope.setEventClick = function(event) {
            $rootScope.eventDetails = event;
            $scope.edited = false;
            $scope.$apply(); // very important, when scope doesn't work with UI
            $('#eventDetailsModal').modal('show');
        };
                
        function editEventByDropOrResize(event) {
            $http.post('ajax/editCalendar.php',{ event:event }).success( function (){ 
            }).error( function () { console.log("Błąd editCalendar"); }); 
        }
        
    }]);
    
    // ====== NEW EVENT DATA CONTROLLER ======
    
    app.controller('newEventData',['$scope','$rootScope','$http','dtp','Trainings','Dict','$interval',function($scope,$rootScope,$http,dtp,Trainings,Dict,$interval) {
        
        $rootScope.showSidePanels = true;
        
        $rootScope.setNewEvent = function(event) {
            if(event) {
                $scope.date1 = getLocalDate(new Date(event._d));
                $scope.date2 = getLocalDate(new Date(event._d));
                $scope.$apply();
                $('#newEventDataModal').modal('show');
            }
        };
        
        function getLocalDate(dt) {
            var temp = new Date();
            var minutes = temp.getTimezoneOffset();
            return dt = new Date(dt.getTime() - minutes * 60000);
        }
    
        $scope.addEvent = function() {
            var d1 = getLocalDate(new Date($scope.date1));
            var d2 = getLocalDate(new Date($scope.date2));

            var data = $scope.inputs;
            var people = $scope.selectedFriends;
            var training = $scope.selectedTraining;
            var dict = $scope.selectedDict;
            var obj = {
                title:data.title,
                desc:data.desc,
                start:d1,
                end:d2,
                people:people,
                dict: { id: dict.id, name: dict.title },
                training: { id: training.id, name: training.name }
            };
            
            $http.post('ajax/saveCalendar.php',{ obj:obj,me:$rootScope.aboutMe.id }).success( function (data){ 
                $rootScope.events = data;
            }).error( function () { console.log("Błąd saveCalendar"); }); 
        };
        
        $scope.getContactsToChat = function(){
          
            $http.post('ajax/getContacts2Chat.php',{ mid:$rootScope.aboutMe.id }).success( function (data){ // INTERVAL ???
                var friends = data;
                var me = [$rootScope.aboutMe];
                $scope.friends = me.concat(friends);
                
            }).error( function () { console.log("Błąd getContacts2Chat"); }); 
        };
        $scope.getContactsToChat();
        
        if(!$rootScope.contactsInterval) {
            $rootScope.contactsInterval = $interval(function(){
                $scope.getContactsToChat();
            },53000); // 53s
        }
        
        Dict.getMy(function(data){
            $scope.dicts = data.dict;
        });
        
        Trainings.getAll(function(data){
            $scope.trainings = data;
        });
        
        $scope.selectedFriends = [];
        $scope.checked = function (mode,friend) { 
            if(mode) { 
                $scope.selectedFriends.push(friend); // add
            } else { // del
                
                var arr = $scope.selectedFriends;
                for(var i in arr) {
                    if(angular.equals(arr[i],friend)){ // !!! JOSN COMPARE 2 OBJECTS
                        arr.splice(i,1);
                        break;
                    }
                }
                $scope.selectedFriends = arr;
            }
        };
        
        $scope.dateOpened1 = dtp.dateOpened;
        $scope.dateOpened2 = dtp.dateOpened;
        $scope.hourStep = dtp.hourStep;
        $scope.format = dtp.format;
        $scope.minuteStep = dtp.minuteStep;
        $scope.timeOptions = dtp.timeOptions;
        $scope.showMeridian = dtp.showMeridian;
        $scope.dateOptions = dtp.dateOptions;
    
        $scope.dateTimeNow = function() {
            $scope.date1 = dtp.dateTimeNow();
            $scope.date2 = dtp.dateTimeNow();
        };
        $scope.toggleMinDate = function() {
            $scope.dateOptions.minDate = dtp.toggleMinDate();
        };
        $scope.open1 = function($event,opened) {
            $scope.dateOpened1 = dtp.open($event,opened);
        };
        $scope.open2 = function($event,opened) {
            $scope.dateOpened2 = dtp.open($event,opened);
        };
        $scope.resetHours = function() {
            $scope.date1 = dtp.resetHours($scope.date1);
            $scope.date2 = dtp.resetHours($scope.date2);
        };
        $scope.dateTimeNow();
        
    }]);
    
    // ====== EVENT DETILS CONTROLLER ======
    
    app.controller('eventDetailsCtrl',['$scope','$rootScope','$http',function($scope,$rootScope,$http){
        
        $rootScope.eventDetails = [];
        $rootScope.showSidePanels = true;
        
        $scope.delPerson = function (person) {
            if($rootScope.eventDetails.id) {
                var id = $rootScope.eventDetails.id;
                var arr = $rootScope.eventDetails.people;
                for(var i in arr){
                    if(angular.equals(arr[i],person)){ // !!! JOSN COMPARE 2 OBJECTS
                        arr.splice(i,1);
                        break;
                    }
                }
                $http.post('ajax/delPerson.php',{ people:arr,id:id }).success( function (){ 
                    $rootScope.eventDetails.people = arr;
                }).error( function () { console.log("Błąd delPerson"); }); 
            }
        };
        
        $scope.removeEvent = function (eventDetails) {
            if(eventDetails) {
                var id = eventDetails.id;
                var who = $rootScope.aboutMe.id;
                var arr = $rootScope.events;
                for(var i in arr){
                    if(arr[i].id === id) { 
                        arr.splice(i,1);
                        break;
                    }
                }
                $http.post('ajax/delEvent.php',{ who:who,id:id }).success( function (){ 
                    $('#eventDetailsModal').modal('hide');
                    $rootScope.events = arr;
                }).error( function () { console.log("Błąd delEvent"); }); 
            }
        };
        
        $scope.editEvent = function () {
            if($rootScope.eventDetails) {
                var arr = $rootScope.eventDetails.people = $scope.selectedFriends;
                var id = $rootScope.eventDetails.id;
                
                $http.post('ajax/delPerson.php',{ people:arr,id:id }).success( function (){ // delPerson updates people fields so, I use this to edit
                    $rootScope.eventDetails.people = arr;
                }).error( function () { console.log("Błąd delPerson"); }); 
            }
        };
        
        $scope.selectedFriends = [];
        $scope.checked = function (mode,friend) { 
            if(mode) { 
                $scope.selectedFriends.push(friend); // add
            } else { // del
                
                var arr = $scope.selectedFriends;
                for(var i in arr) {
                    if(angular.equals(arr[i],friend)){ // !!! JOSN COMPARE 2 OBJECTS
                        arr.splice(i,1);
                        break;
                    }
                }
                $scope.selectedFriends = arr;
            }
        };
        
        $scope.getFriendsAll = function () {
            $http.post('ajax/getContacts2Chat.php',{ mid:$rootScope.aboutMe.id }).success( function (data){
                var friends = data;
                var me = [$rootScope.aboutMe];
                $scope.friendsAll = me.concat(friends);
                
                var arr = $scope.friendsAll;         
                for(var i in arr) { arr[i].clicked = 0; }
                $scope.selectedFriends = [];
                
                for(var i in arr) {
                    var arr2 = $rootScope.eventDetails.people;
                    for(var j in arr2) {
                        if(arr[i].id === arr2[j].id){ // !!! JOSN COMPARE 2 OBJECTS
                            arr[i].clicked = 1;
                            $scope.selectedFriends.push(arr[i]);
                            break;
                        }
                    }
                }
                $scope.friendsAll = arr;
                
            }).error( function () { console.log("Błąd getContacts2Chat"); }); 
        };
        
        $scope.removeMeFromEvent = function (eventDetails) {
            if(eventDetails) {
                var id = eventDetails.id;
                var arr = eventDetails.people;
                var me = $rootScope.aboutMe.id;
                for(var i in arr){
                    if(me === arr[i].id) {
                        arr.splice(i,1);
                        break;
                    }
                }
                if(eventDetails.who !== me) {
                    var arr2 = $rootScope.events;
                    for(var j in arr2){
                        if(arr2[j].id === id) { 
                            arr2.splice(j,1);
                            break;
                        }
                    }
                }
                $http.post('ajax/delPerson.php',{ people:arr,id:id }).success( function (){ 
                    
                    if(eventDetails.who !== me) { $('#eventDetailsModal').modal('hide'); $rootScope.events = arr2; }
                    $rootScope.eventDetails.people = arr;
                    
                }).error( function () { console.log("Błąd delPerson"); }); 
            }
        };
        
        $scope.checkMeInEvent = function(people) {
            for(var i in people) {
                if(people[i].id === $rootScope.aboutMe.id){ // !!! JOSN COMPARE 2 OBJECTS
                    return true;
                }
            }
            return false;
        };
        
    }]);

    // ====== CONTROLLER UNREAD MESSAGES ======

    app.controller('unReadMsg',['$scope','$rootScope','$http','Chat','$interval','$location',function($scope,$rootScope,$http,Chat,$interval,$location){

        $rootScope.countM = 0;
        $rootScope.showSidePanels = true;
        
        function getCoutnt() {      
            $http.post("ajax/getUnReadMsgCount.php", { mid:$rootScope.aboutMe.id }).success( function (data) {
                $rootScope.countM = data.count;
                if(data.count > 0 && data.available) {
                    $rootScope.selected = data.users[0];
                    $('.chatWin').show();
                }
                Chat.getPeople(function(data){
                    $scope.people = data;
                });
            }).error( function () { console.log("Błąd getUnReadMsgCount"); });
        }
        
        getCoutnt();
        if(!$rootScope.countInterval) {
                $rootScope.countInterval = $interval(function(){
                getCoutnt();
            },34000); //34s
        }

        $scope.showMsgs = function(person) {
            $rootScope.selected = person;
            $location.path('/messages',true);
        };
        
    }]);
    
    // ====== EVENTS TOP-BAR ======
    
    app.controller('eventsTopBar',['$scope','$rootScope','Register','$interval',function($scope,$rootScope,Register,$interval){

        $rootScope.countE = 0;
        $rootScope.showSidePanels = true;
        
        $scope.markAsSeen = function (items) {
            Register.seenAll({ items: items, me: $rootScope.aboutMe.id },function(){
                $scope.getTopBarEvents();
            });
        };
        
        $scope.getTopBarEvents = function () {
            
            Register.getRegister({ me:$rootScope.aboutMe.id,what:"E",limit:7 },function(data){
                $rootScope.countE = data.count;
                $scope.items = data.items;
            });
        };
        $scope.getTopBarEvents();
        
        if(!$rootScope.eventsTopBarInterval) {
            $rootScope.eventsTopBarInterval = $interval(function(){
                $scope.getTopBarEvents();
            },22000); //22s
        }

        $scope.getEventNameByType = function (type) {
            if(type === "L") {
                return "polubił Twój post";
            }
            else if(type === "C") {
                return "skomentował Twój post";
            }
            else if(type === "P") {
                return "dodał nowy post";
            }
            else if(type === "D") {
                return "zaplanował dla Ciebie event";
            }
            else if(type === "T") {
                return "dodał nowe szkolenie";
            }
            else if(type === "W") {
                return "dodał nową listę słówek";
            }
            else if(type === "A") {
                return "dodał nową aukcję";
            }
        };

        $scope.getEventShortNameByType = function (type) {
            if(type === "L") {
                return "Like";
            }
            else if(type === "C") {
                return "Comment";
            }
            else if(type === "P") {
                return "Post";
            }
            else if(type === "D") {
                return "Date";
            }
            else if(type === "T") {
                return "Training";
            }
            else if(type === "W") {
                return "Words";
            }
            else if(type === "A") {
                return "Auction";
            }
        };

        $scope.getEventLinkByType = function (type,link) {
            if(type === "L") {
                return "/#/wall/"+link;
            }
            else if(type === "C") {
                return "/#/wall/"+link;
            }
            else if(type === "P") {
                return "/#/wall/"+link;
            }
            else if(type === "D") {
                return "/#/calendar/"+link;
            }
            else if(type === "T") {
                return "/#/training/"+link;
            }
            else if(type === "W") {
                return "/#/words/"+link;
            }
            else if(type === "A") {
                return "/#/auctions/"+link;
            }
        };

    }]);
        
    // ====== FOLLOWERS TOP-BAR ======
    
    app.controller('followersTopBar',['$scope','$rootScope','Register','$interval','FollowersFollowing',function($scope,$rootScope,Register,$interval,FollowersFollowing){   
                
        $rootScope.countF = 0;
        $rootScope.showSidePanels = true;
        
        $scope.markAsSeen = function (items) {
            Register.seenAll({ items: items, me: $rootScope.aboutMe.id },function(){
                $scope.getTopBarFollowers();
            });
        };
        
        $rootScope.createDate = function (date) {
            if(date) { return moment(date).format('llll'); }
        };
        
        $scope.getTopBarFollowers = function() {
            Register.getRegister({ me:$rootScope.aboutMe.id,what:"F",limit:7 },function(data){
                $rootScope.countF = data.count;
                $scope.items = data.items;
            });
        };
        $scope.getTopBarFollowers();
        
        if(!$rootScope.followersTopBarInterval) {
            $rootScope.followersTopBarInterval = $interval(function(){
                $scope.getTopBarFollowers();
            },27000); //27s
        }
        
        $scope.add2Friends = function (mid,uid) {
            FollowersFollowing.addFollowing({ mid:mid, user:uid, mode:"insert"});
            return 1;
        };
        
        $scope.delFromFriends = function (mid,uid) {
            FollowersFollowing.delFollowing({ mid:mid, user:uid, mode:"delete"});
            return 0;
        };
        
    }]);
        
    // ====== WALL CONTROLLER ======
    
    app.controller('wall',['$scope','$rootScope','$timeout','$routeParams','$interval','FileUploader','Dict','Trainings','Posts','cnFilter',function($scope,$rootScope,$timeout,$routeParams,$interval,FileUploader,Dict,Trainings,Posts,cnFilter){

        $rootScope.showSidePanels = true;

        $scope.postId = $routeParams.pid || '';
        
        $scope.getFilterPart1 = function(arg) {
            return cnFilter.getPart1(arg);
        };
        $scope.getFilterPart2 = function(arg) {
            return cnFilter.getPart2(arg);
        };

        Dict.getMy(function(data){
            $scope.dicts = data.dict;
        });

        Trainings.getAll(function(data){
            $scope.trainings = data;
        });
        
        Posts.getPosts({ mid:$rootScope.aboutMe.id, vip:$rootScope.aboutMe.vip, pid:0, mode:$rootScope.aboutMe.mode },function(data){
            $scope.items = data;
            autoSizeText();
        });
        
        if(!$rootScope.wallInterval) {
            $rootScope.wallInterval = $interval(function(){
                Posts.getPosts({ mid:$rootScope.aboutMe.id, vip:$rootScope.aboutMe.vip, pid:0, mode:$rootScope.aboutMe.mode },function(data){

                    // --- add or update posts / add delete edit comments ---
                    // data.reverse();

                    for(var i in data) { 

                        var isNew = true;
                        for(var j in $scope.items) {

                            if(data[i].id === $scope.items[j].id) {
                                if(data[i].pv > $scope.items[j].pv) {
                                    $scope.items[j] = data[i]; // --- update post ---
                                }
                                $scope.items[j].likes = data[i].likes;
                                $scope.items[j].liked = data[i].liked;

                                // --- add or update comments ---
                                // data[i].comments.reverse();

                                for(var k in data[i].comments) { 

                                    var isNewComm = true;
                                    for(var l in $scope.items[j].comments) {

                                        if(data[i].comments[k].id === $scope.items[j].comments[l].id) {
                                            if(data[i].comments[k].cv > $scope.items[j].comments[l].cv) {
                                                $scope.items[j].comments[l] = data[i].comments[k]; // --- update comment ---
                                            }
                                            isNewComm = false;
                                        }
                                    }
                                    if(isNewComm) { $scope.items[j].comments.unshift(data[i].comments[k]); } // --- add new comment ---
                                }

                                // --- delete comments ---

                                for(var k in $scope.items[j].comments) { 

                                    var isDeletedComm = true;
                                    for(var l in data[i].comments) {

                                        if($scope.items[j].comments[k].id === data[i].comments[l].id) {
                                            isDeletedComm = false;
                                        }
                                    }
                                    if(isDeletedComm) { $scope.items[j].comments.splice(k,1); } // --- delete comment ---
                                }
                                isNew = false;
                            }
                        }
                        if(isNew) { $scope.items.unshift(data[i]); } // --- add new post ---
                    }

                    // --- delete deleted posts ---

                    for(var i in $scope.items) { 

                        var isDeletedPost = true;
                        for(var j in data) {

                            if($scope.items[i].id === data[j].id) {
                                isDeletedPost = false;
                            }
                        }
                        if(isDeletedPost) { $scope.items.splice(i,1); } // --- delete post ---
                    }
                    autoSizeText();
                });
            },33000); //33s
        }

        $scope.post = '';
        $scope.access = 0;
        $scope.selectedTraining = '';
        $scope.selectedDict = '';
        
        $scope.orderByColumn = 'id';
        $scope.orderDesc = true;
        $scope.orderAsc = false;

        $scope.setAccess = function(arg) {
            $scope.access = arg;
        };  
        
        $rootScope.updatePosts = function(data) {
            $scope.items = data;
        };

        $scope.addPost = function(post) {

            if(!post) {

                $scope.alert = true;
                $timeout(function(){
                    $scope.alert = false;
                },3000);

            } else { // save post

                var images = $scope.newsImages;
                var access = $scope.access;
                var todo = {};

                if($scope.selectedTraining) {
                    todo.tid = $scope.selectedTraining.id;
                    todo.tname = $scope.selectedTraining.name;
                }
                if($scope.selectedDict) {
                    todo.did = $scope.selectedDict.id;
                    todo.dname = $scope.selectedDict.title;
                }

                Posts.addPost({ id:$rootScope.aboutMe.id, content:post, files:images, reach:access, todo:todo }, function(){
                    $scope.post = '';
                    $scope.newsImages = [];
                    uploader.clearQueue();
                    
                    Posts.getPosts({ mid:$rootScope.aboutMe.id, vip:$rootScope.aboutMe.vip, pid:0, mode:$rootScope.aboutMe.mode },function(data){ // only new posts !!!
                        $scope.items = data;
                        autoSizeText();
                    });
                    $rootScope.addScore(20,2);
                });
            }
        };
        
        $scope.delItem = function(arg) {
            var items = $scope.items;
            for(var i in items) {
                if(angular.equals(items[i].id,arg.id)) {
                    
                    Posts.delPost({ pid:arg.id, mid:$rootScope.aboutMe.id, uid:arg.kto, index:i },function(data){
                        items.splice(data,1);
                    });
                }
            }
            $scope.items = items;
        };
        
        $scope.saveItem = function(arg) {
            Posts.savePost({ mid:$rootScope.aboutMe.id, post:arg },function(){});
        };
        
        $scope.saveComm = function(comm) {
            Posts.saveComm({ mid:$rootScope.aboutMe.id, content:comm.tresc, id:comm.id },function(){});
        };
        
        $scope.delComm = function(comms,item,comm) {
            for(var i in comms) {
                if(angular.equals(comms[i].id,comm.id)) {
                    
                    Posts.delComm({ id:comm.id, mid:$rootScope.aboutMe.id, uid: item.kto, pid: item.id, index:i },function(data){
                        comms.splice(data,1);
                    });
                    break;
                }
            }
            return comms;
        };
        
        $scope.addComm = function(comm,item) {
            var o = {
                tresc: comm,
                kto: $rootScope.aboutMe,
                gdzie: item.id,
                uid: item.kto
            };
            Posts.addComm(o,function(data){
                item.comments.push(data);
                $rootScope.addScore(5,2);
            });
            return item.comments;
        };
        
        $scope.parseMsg = function(arg) {
            return Posts.parsePost(arg);
        };
        
        $scope.likeBtn = function(arg) {
            if(arg.liked > 0) {
                
                arg.liked = 0;
                arg.likes = arg.likes-1;
                Posts.delLike({ id:arg.id, mid:$rootScope.aboutMe.me, uid:arg.kto },function(){});
                
            } else {
                
                arg.liked = 1;
                arg.likes = arg.likes+1;
                Posts.setLike({ id:arg.id, mid:$rootScope.aboutMe.me, uid:arg.kto },function(){
                    $rootScope.addScore(1,2);
                });
            }
        };
        
        // ======================== GET MORE ========================

        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() === $(document).height()) {
                
                var pid = ($scope.items[$scope.items.length - 1]) ? $scope.items[$scope.items.length - 1].id : 0;
                
                Posts.getPosts({ mid:$rootScope.aboutMe.id, vip:$rootScope.aboutMe.vip, pid:pid, mode:$rootScope.aboutMe.mode },function(data){
                    for(var i in data) {
                        if($scope.items) $scope.items.push(data[i]);
                    }
                    autoSizeText();
                });
            }
        });

        // ======================== UPLOADER ========================

        $scope.unlockSendBtn = function() {
            $scope.lock = false;
        };
        $scope.lockSendBtn = function() {
            $scope.lock = true;
        };

        var uploader = $scope.uploader = new FileUploader({
            url: 'ajax/fileUploader.php?mid='+$rootScope.aboutMe.id
        });

        uploader.filters.push({
            name: 'imageFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        });

        uploader.onCompleteItem = function(fileItem, response, status, headers) {
            $scope.lock = false;
        };

        $scope.newsImages = [];
        uploader.onSuccessItem = function(fileItem, response, status, headers) { // response - my file path
            $scope.newsImages.push(response);
            $scope.lock = false;
        };

    }]);

    // ====== PEOPLE CONTROLLER ======
    
    app.controller('friends',['$scope','$rootScope','$interval','FollowersFollowing',function($scope,$rootScope,$interval,FollowersFollowing){
        
        $rootScope.showSidePanels = true;
        
        $scope.delFollowing = function(following) {
            for(var i in $scope.allFollowing) {
                if(angular.equals($scope.allFollowing[i],following)){ // !!! JOSN COMPARE 2 OBJECTS
                    
                    FollowersFollowing.delFollowing({ mid:$rootScope.aboutMe.id, user: following.id_1, mode:"delete", index:i },function(data){
                        $scope.allFollowing.splice(data,1);
                    });
                    break;
                }
            }
        };
        
        $scope.getFollowersFollowing = function() {

            FollowersFollowing.getData(function(data){
                $scope.allFollowers = data.followers;
                $scope.allFollowing = data.following;
            });
        };
        $scope.getFollowersFollowing();
        
        if(!$rootScope.followingInterval) {
            $rootScope.followingInterval = $interval(function(){
                $scope.getFollowersFollowing();
            },51000); // 51s
        }
        
    }]);
    
    // ====== RANKING CONTROLLER ======
    
    app.controller('ranking',['$scope','$rootScope','$interval','Ranking','FollowersFollowing',function($scope,$rootScope,$interval,Ranking,FollowersFollowing){
        
        $rootScope.showSidePanels = true;
        
        $scope.getRanking = function() {

            Ranking(function(data){
                $scope.users = data;
            });
        };
        $scope.getRanking();
        
        if(!$rootScope.rankingInterval) {
            $rootScope.rankingInterval = $interval(function(){
                $scope.getRanking();
            },46000); // 46s
        }

        $scope.calculate = function(arg1,arg2) {
            return Math.ceil(arg1/arg2);
        };
        
        $scope.add2Friends = function (mid,uid) {
            FollowersFollowing.addFollowing({ mid:mid, user:uid, mode:"insert"});
            return 1;
        };
        
        $scope.delFromFriends = function (mid,uid) {
            FollowersFollowing.delFollowing({ mid:mid, user:uid, mode:"delete"});
            return 0;
        };
        
    }]);
    
    // ====== FOLLOWING CONTROLLER ======
    
    app.controller('following',['$scope','$rootScope','$interval','FollowersFollowing',function($scope,$rootScope,$interval,FollowersFollowing){
        
        $scope.friends = 0;
        $scope.checked = false;
        $rootScope.showSidePanels = true;
        
        $scope.$watch(function() { return $rootScope.UID; }, function() {
            $scope.checkFriends();
        });
        
        $scope.checkFriends = function() {
            if($rootScope.aboutMe.id !== $rootScope.UID) {
                FollowersFollowing.isFriend({ mid:$rootScope.aboutMe.id, uid:$rootScope.UID },function(data){
                    $scope.friends = parseInt(data);
                    $scope.checked = true;
                });
            }
        };
        
        if(!$rootScope.friendsInterval) {
            $rootScope.friendsInterval = $interval(function(){
                $scope.checkFriends();
            },53000); // 53s
        }

        $scope.add2Friends = function () {
            FollowersFollowing.addFollowing({ mid:$rootScope.aboutMe.id, user:$scope.userId, mode:"insert"});
            $scope.friends = 1;
        };
        
        $scope.delFromFriends = function () {
            FollowersFollowing.delFollowing({ mid:$rootScope.aboutMe.id, user:$scope.userId, mode:"delete"});
            $scope.friends = 0;
        };
        
    }]);
    
    // ====== PREMIUM CONTROLLER ======
    
    app.controller('premium',['$scope','$rootScope',function($scope,$rootScope){
        
        $rootScope.showSidePanels = false;
        
    }]);

</script>

<? require_once '_app_addons.php';