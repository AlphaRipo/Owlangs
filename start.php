<?php require_once("ajax/db.php");

    //------------------------------
    
    $payLaneStatus = $_POST['status'];
    if($payLaneStatus == "PERFORMED" or $payLaneStatus == "CLEARED")
    {
        // PERFORMED – płatność została pomyślnie zrealizowana
        // CLEARED – środki zostały pobrane (otrzymano potwierdzenie z banku) 
        
        $_SESSION['payLane'] = [
            "status" => $payLaneStatus,
            "amount" => $_POST['amount'], // 29.00
            "currency" => $_POST['currency'], // EUR
            "description" => $_POST['description'], // A1
            "hash" => $_POST['hash'], // 719c94ccc0a32093dad17e561ed43e827f00deb2
            "id_sale" => $_POST['id_sale'] // 8680467
        ];
    }
    elseif($payLaneStatus == "PENDING") { // PENDING – płatność oczekuje na realizację
    }
    elseif($payLaneStatus == "ERROR") { // ERROR – płatność nie powiodła się
    }
    
    //------------------------------
    
?>

<!DOCTYPE html>
<html lang="en" ng-app="cnApp" ng-controller="master" ng-cloak>
    <head>
        <base href="/">
        <meta charset="utf-8" />
        <title ng-bind="( '('+ countAll() +')' + ' OwLangs.com' )"></title>
        <meta name="description" content="Portal społecznościowy do nauki języka angielksiego" />
        <meta name="keywords" content="Portal społecznościowy do nauki języka angielksiego" />
        <link href="favicon.png" rel="shortcut icon">

        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/html5reset-1.6.1.css" rel="stylesheet" type="text/css">
        <link href="css/style_glowna.css" rel="stylesheet" type="text/css">
        <link href="css/sownik.css" rel="stylesheet" type="text/css">
        <link href="css/platnosc.css" rel="stylesheet" type="text/css">
        
        <link href="icons/emoticons.css" rel="stylesheet" type="text/css"/>
        <link href="css/flags.css" rel="stylesheet" type="text/css"/>
        
        <link href="css/fullcalendar.min.css" rel="stylesheet" type="text/css">
        <link href="css/ekko-lightbox.min.css" rel="stylesheet" type="text/css">
        <link type="text/css" rel="stylesheet" href="audio/basic/basic.css">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="css/loading-bar.css" rel="stylesheet" type="text/css">

        <style>
            #calendarMini {
                width: 100%;
                margin: 0 auto;
                font-size: 10px;
                /*height: 100%;*/
            }
            #calendarMini .fc-header-title h2 {
                font-size: .9em;
                white-space: normal !important;
            }
            #calendarMini .fc-view-month .fc-event, .fc-view-agendaWeek .fc-event {
                font-size: 0;
                overflow: hidden;
                height: 2px;
            }
            #calendarMini .fc-view-agendaWeek .fc-event-vert {
                font-size: 0;
                overflow: hidden;
                width: 2px !important;
            }
            #calendarMini .fc-agenda-axis {
                width: 20px !important;
                font-size: .7em;
            }
            #calendarMini .fc-button-content {
                padding: 0;
            }
            #calendarMini .fc-scroller {
                height: 240px!important;
            }
            .me { 
                background-color: #5cb85c;
                border-color: #4cae4c;
                color: #fff;
            }
            .notme { 
                background-color: #3071a9;
                border-color: #285e8e;
                color: #fff;
            }
            .form-control { 
                background-color: #fff!important;
                border-right: 1px solid #ddd!important;
                border-left: 1px solid #ddd!important;
                border-top: 1px solid #ddd!important;
                border-radius: 5px!important;
                padding: 5px!important;
            }
            .menu_gorne .active {
                background-color: #fff;
            }
            .menu_gorne .active a {
                color: #f7941e!important;
            }
            .menu_gorne li {
                background-color: #79648b;
                border-left: 1px solid #eee;
            }
            .menu_gorne a {
                color: #fff!important;
            }
            .menu_gorne a:hover {
                color: #f7941e!important;
            }
            .menu_gorne li:hover {
                background-color: #fff;
                color: #f7941e!important;
            }
            .modal-dialog { z-index: 9999; }
            .status {
                font-size: 14px;
                line-height: 18px;
            }
            .commentarea {
                width:350px;
                font-size: 13px;
                line-height: 18px;
                border: thin;
                border-color: white;
                border-style: solid;
                background-color: hsl(0, 0%, 96%);
                padding: 5px;
            }
            #comment {
                width: 357px;
                height: 23px;
                font-size: 15px;
            }
            .main {
                margin-left:auto;
                margin-right:auto;
                width:360px;
            }
            a.fullName { color: #f7941e!important; }
            a.fullName:hover { color: #fff!important; }

        </style>
        
        <script>
            if(!JSON.parse(localStorage.getItem("OwLangsUserData"))) { window.location.href = '//owlangs.com/login'; }
        </script>

    </head>
    <body>
                
        <?php require_once('parts/topbar.php'); ?>

        <!-- STATYSTYKI-->
        <section id="statystyki" ng-hide="path === 'wall'" ng-style="{'background-image': 'url(' + aboutUser.back + ')'}" style="background-position: bottom; background-repeat: no-repeat; background-color: #000;">

            <div class="container">
                <h2 class="hidden">Statystyki użytkownika</h2>

                <div class="row">
                    
                    <a ng-href="/#/profile/{{UID}}" class="fullName">
                        <div id="uzytkownik" ng-style="{'background-image': 'url(' + aboutUser.avatar + ')'}" style="margin-top: 20px!important; width: 200px; height: 200px; background-position: top; background-repeat: no-repeat; background-color: #000; border: 4px solid #f7941e;" class="col-md-2 col-xs-12  hidden-sm hidden-xs nopadding"></div>
                    </a>

                    <div ng-controller="following" ng-show="UID !== aboutMe.id && checked" style="margin: 82px 0px 0px 10px !important; text-align: left; padding: 5px!important; background: rgba(120,120,120,0.5);" class="well col-md-3 col-xs-12  hidden-sm hidden-xs nopadding">

                        <div class="col-sm-12 nopadding">
                            <a ng-href="/#/user/{{UID}}" class="fullName">
                                <h4 style="color:#fff;text-shadow: 1px 1px 0 rgba(0,0,0,0.6);">
                                    <strong><span ng-bind="aboutUser.imie"></span></strong><br>
                                    <strong><span ng-bind="aboutUser.nazwisko"></span></strong>
                                </h4>   
                            </a>
                        </div>
                        <div class="col-sm-12 nopadding">

                            <button class="btn pull-left" data-toggle="tooltip" data-placement="right" title="{{ (friends === 0 && UID !== aboutMe.id) ? 'Add to friends' : 'Remove from friends' }}"
                                ng-click=" (friends === 0 && UID !== aboutMe.id) ? add2Friends() : delFromFriends() "
                                ng-class="{'btn-success':friends === 0 && UID !== aboutMe.id,'btn-primary':friends === 1 && UID !== aboutMe.id}">
                                <i ng-class="{'fa-user-plus':friends === 0 && UID !== aboutMe.id,'fa-user-times':friends === 1 && UID !== aboutMe.id}" class="fa" aria-hidden="true"></i>
                                <span ng-bind="( (friends === 0 && UID !== aboutMe.id) ? '<? echo langs("Obserwuj"); ?>' : '<? echo langs("Obserwujesz"); ?>' )"></span>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
            
        </section>

        <section id="najlepsi" ng-show="path === 'wall' && carousel">
            <div class="container">
                <h2 class="hidden">Ranking użytkowników</h2>

                <div class="row">
                    <div class="col-md-3 col-xs-12  hidden-sm hidden-xs">
                        <h3><? echo langs("Sowa miesiąca:"); ?></h3>
                        
                        <a ng-href="/#/user/{{carousel.winner[0].id}}">
                            <img class="img-circle img-thumbnail" width="77px" ng-src="{{carousel.winner[0].avatar}}" />
                        </a>
                        <span class="text-muted" ng-bind="( carousel.winner[0].imie +' '+ carousel.winner[0].nazwisko )"></span>
                    </div>

                    <div class="col-md-3 col-xs-12 hidden-sm hidden-xs carusel1">
                        <h3><? echo langs("Najbardziej kreatywna sowa tygodnia:"); ?></h3>

                        <div ng-repeat="it1 in carousel.creative" class="col-md-4">
                            <a ng-href="/#/user/{{it1.id}}">
                                <img class="img-circle img-thumbnail" width="50px" data-toggle="tooltip" data-placement="top" title="{{ it1.imie +' '+ it1.nazwisko }}" ng-src="{{it1.avatar}}" class="img-responsive" />
                            </a>
                            <span class="text-muted" ng-bind="( $index+1 )"></span>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-12  hidden-sm hidden-xs carusel2">
                        <h3><? echo langs("Najbardziej pomocna sowa:"); ?></h3>
                        
                        <div ng-repeat="it2 in carousel.helpful" class="col-md-4">
                            <a ng-href="/#/user/{{it2.id}}">
                                <img class="img-circle img-thumbnail" width="50px" data-toggle="tooltip" data-placement="top" title="{{ it2.imie +' '+ it2.nazwisko }}" ng-src="{{it2.avatar}}" class="img-responsive" />
                            </a>
                            <span class="text-muted" ng-bind="( $index+1 )"></span>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-12  hidden-sm hidden-xs carusel3">
                        <h3><? echo langs("Sowa tłumacz tygodnia:"); ?></h3>

                        <div ng-repeat="it3 in carousel.translator" class="col-md-4">
                            <a ng-href="/#/user/{{it3.id}}">
                                <img class="img-circle img-thumbnail" width="50px" data-toggle="tooltip" data-placement="top" title="{{ it3.imie +' '+ it3.nazwisko }}" ng-src="{{it3.avatar}}" class="img-responsive" />
                            </a>
                            <span class="text-muted" ng-bind="( $index+1 )"></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="serwis">
            <div class="container">
                <h2 class="hidden">Serwis językowy</h2>
                <div class="row">

                    <div id="lewa" ng-if="showSidePanels" class="col-lg-3 col-md-3 col-sm-3 hidden-xs nopadding">

                        <!-- PROFIL -->

                        <div class="profil row">

                            <div class="col-sm-4">
                                <a ng-href="/#/user/{{aboutMe.id}}"><img style="margin:10px;" ng-src="{{aboutMe.avatar}}" class="img-thumbnail" height="92" class="img-responsive" alt="user" /></a>
                            </div>
                            <div class="col-sm-8">
                                <h3 style="margin-top: 20px!important;">Zalogowany jako: </h3>
                                <h3 style="margin-top: 10px!important;">
                                    <strong ng-bind="aboutMe.imie"></strong><br>
                                    <strong ng-bind="aboutMe.nazwisko"></strong>
                                </h3>
                            </div>

                            <div class="col-sm-12">

                                <div class="belka"></div>
                                <br>

                                <div class=" col-sm-3 nopadding">
                                    <h4 ng-if="aboutMe.lvl_ang"><i class="fa fa-graduation-cap"></i><br><p ng-bind="aboutMe.lvl_ang"></p></h4>
                                </div>
                                <div class=" col-sm-3 nopadding">
                                    <h4 ng-if="aboutMe.vip"><i class="fa fa-star"></i><br>VIP</h3>
                                </div>
                                <div class=" col-sm-3 nopadding">
                                    <h4 ng-if="rankingNumber"><i class="fa fa-line-chart"></i><br><p ng-bind="rankingNumber"></p></h4>
                                </div>
                                <div class=" col-sm-3 nopadding">
                                    <h4 ng-if="rankingNumber"><i class="fa fa-cubes"></i><br><p ng-bind="rankingNumber"></p></h4>
                                </div>

                            </div>
                        </div>

                        <!-- WYSZUKIWARKA-->
                        <div ng-controller="people" ng-if="path === 'messages'">
                            <div class="kalendarz row nopadding">
                                <div class="col-sm-12 nopadding">

                                    <div style="margin:10px;" class="input-group">
                                        <input type="text" class='form-control' ng-model="searchPerson" placeholder="<? echo langs("Szukaj..."); ?>">
                                        <span class="input-group-btn">
                                            <a class="btn btn-default" id='searchBtn' type="button"><i class="fa fa-search"></i></a>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="kalendarz row nopadding alertsFromWinTheme">
                                <div class="col-sm-12">
                                    
                                    <div class="alert" ng-repeat="person in people | filter:searchPerson" ng-class="{ 'alert-info' : person.id === selected.id, 'alert-warning' : person.id !== selected.id }">
                                        <a class="hand" ng-click="showMsgs(person)">

                                            <table style="text-align:left;font-size:12px;">
                                                <tr>
                                                    <td rowspan="3"><img style="vertical-align:top;margin-right:10px;" class="img-circle img-thumbnail" ng-src="{{person.avatar}}" width="60" /></td>
                                                    <td><strong><span ng-bind="( person.imie +' '+ person.nazwisko )"></span></strong></td>
                                                </tr>
                                                <tr>
                                                    <td><span ng-bind="( createDate(person.kiedy) | date )"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span ng-bind="( ( person.co | limitTo: 20 ) +' '+ ( person.co.length > 20 ? '...' : '' ) )"></span></td>
                                                </tr>
                                            </table>
                                            
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- KALENDARZ -->
                        <div ng-controller="calendar" class="kalendarz row nopadding">
                            <div class="col-sm-12" style="padding:2px;">

                                <div class="btn-toolbar">
                                    <div class="btn-group">
                                      <button class="btn btn-xs btn-danger" ng-click="setView('agendaDay')"><i class="fa fa-clock-o" aria-hidden="true"></i> Day</button>
                                      <button class="btn btn-xs btn-success" ng-click="setView('agendaWeek')"><i class="fa fa-calendar" aria-hidden="true"></i> Week</button>
                                      <button class="btn btn-xs btn-warning" ng-click="setView('month')"><i class="fa fa-calendar" aria-hidden="true"></i> Month</button>
                                    </div>

                                    <div class="btn-group pull-right">
                                      <button class="btn btn-xs btn-primary" ng-click="doPreviousView()"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
                                      <button class="btn btn-xs btn-danger" ng-click="viewToday()"><i class="fa fa-calendar" aria-hidden="true"></i></button>
                                      <button class="btn btn-xs btn-primary" ng-click="doNextView()"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                                <h3 ng-bind="showingTitle"></h3>
                                <div id="calendarMini" full-calendar></div>

                            </div>
                        </div>

                        <!-- MENU BOCZNE -->
                        <div class="menu row nopadding">
                            <div class="col-sm-12 nopadding">
                                <ul>
                                    <li data-toggle="tooltip" data-placement="top" data-original-title="wall with all posts"><a href="/#/main"><p><i class="fa fa-lg fa-newspaper-o"></i> &nbsp;<? echo langs("Wall"); ?></p></a></li>
                                    <li data-toggle="tooltip" data-placement="top" data-original-title="wall with only my posts"><a href="/#/user/{{UID}}"><p><i class="fa fa-lg fa-newspaper-o"></i> &nbsp;<? echo langs("My"); ?></p></a></li>
                                    <li data-toggle="tooltip" data-placement="top" data-original-title="words in my dictionary"><a href="/#/words"><p><i class="fa fa-lg fa-book"></i> &nbsp;<? echo langs("Dictionary"); ?></p></a></li>
                                    <li data-toggle="tooltip" data-placement="top" data-original-title="all trainings"><a href="/#/trainings"><p><i class="fa fa-graduation-cap fa-lg"></i> &nbsp;<? echo langs("Trainings"); ?></p></a></li>
                                    <li data-toggle="tooltip" data-placement="top" data-original-title="my calendar"><a href="/#/calendar/{{UID}}"><p><i class="fa fa-calendar fa-lg"></i> &nbsp;<? echo langs("Calendar"); ?></p></a></li>
                                    <li data-toggle="tooltip" data-placement="top" data-original-title="all auctions"><a href="/#/auctions"><p><i class="fa fa-lg fa-money"></i> &nbsp;<? echo langs("Auctions"); ?></p></a></li>
                                    <li data-toggle="tooltip" data-placement="top" data-original-title="my friends"><a href="/#/friends/{{UID}}"><p><i class="fa fa-users fa-lg"></i> &nbsp;<? echo langs("Friends"); ?></p></a></li>
                                    <li data-toggle="tooltip" data-placement="top" data-original-title="my profile"><a href="/#/profile/{{UID}}"><p><i class="fa fa-lg fa-user"></i> &nbsp;<? echo langs("Profile"); ?></p></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div id="srodkowa" ng-class="{ 'col-lg-8 col-md-8 col-sm-8': showSidePanels, 'col-lg-12 col-md-12 col-sm-12': !showSidePanels }" class="col-xs-12 nopadding">

                        <div class="menu_gorne row nopadding">
                            <div class="col-sm-12 nopadding" ng-if="showSidePanels">

                                <!-- Zakładki -->
                                <ul class="nav nav-tabs">
                                    <li data-toggle="tooltip" data-placement="top" ng-class="{active: path === 'wall'}" data-original-title="wall with all posts">
                                        <a ng-href="/#/wall"><i class="fa fa-2x fa-newspaper-o"></i><br><? echo langs("Wall"); ?></a>
                                    </li>
                                    <li data-toggle="tooltip" data-placement="top" ng-class="{active: path === 'user'}" data-original-title="wall with only my posts">
                                        <a ng-href="/#/user/{{UID}}"><i class="fa fa-2x fa-newspaper-o"></i><br><? echo langs("My"); ?></a>
                                    </li>
                                    <li data-toggle="tooltip" data-placement="top" ng-class="{active: path === 'words' || path === 'my-words' || path === 'flashcards' || path === 'flashcards-time' }" data-original-title="words in my dictionary">
                                        <a ng-href="/#/words"><i class="fa fa-2x fa-book"></i><br><? echo langs("Dictionary"); ?></a>
                                    </li>
                                    <li data-toggle="tooltip" data-placement="top" ng-class="{active: path === 'trainings' || path === 'my-trainings' || path === 'completed-trainings' || path === 'training' || path === 'create-training' || path === 'edit-training' }" data-original-title="all trainings">
                                        <a ng-href="/#/trainings"><i class="fa fa-2x fa-graduation-cap"></i><br><? echo langs("Trainings"); ?></a>
                                    </li>
                                    <li data-toggle="tooltip" data-placement="top" ng-class="{active: path === 'calendar'}" data-original-title="my calendar">
                                        <a ng-href="/#/calendar/{{UID}}"><i class="fa fa-2x fa-calendar"></i><br><? echo langs("Calendar"); ?></a>
                                    </li>
                                    <li data-toggle="tooltip" data-placement="top" ng-class="{active: path === 'auctions'}" data-original-title="all auctions">
                                        <a ng-href="/#/auctions"><i class="fa fa-2x fa-money"></i><br><? echo langs("Auctions"); ?></a>
                                    </li>
                                    <li data-toggle="tooltip" data-placement="top" ng-class="{active: path === 'friends'}" data-original-title="my friends">
                                        <a ng-href="/#/friends/{{UID}}"><i class="fa fa-2x fa-users"></i><br><? echo langs("Friends"); ?></a>
                                    </li>
                                    <li data-toggle="tooltip" data-placement="top" ng-class="{active: path === 'profile'}" data-original-title="my profile">
                                        <a ng-href="/#/profile/{{UID}}"><i class="fa fa-2x fa-user"></i><br><? echo langs("Profile"); ?></a>
                                    </li>
                                </ul>

                            </div>
                        </div>

                        <div class="row nopadding">

                            <section ng-view autoscroll="true"></section>

                        </div>
                    </div>

                    <!-- CHAT STATYCZNY -->
                    <div ng-if="showSidePanels" id="prawa" class="col-lg-1 col-md-1 hidden-sm hidden-xs nopadding">
                        <div class="chat row nopadding">
                            <div class="col-sm-12 nopadding">

                                <? require_once 'parts/_chatList.php'; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="js/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootbox.min.js"></script>
        <script src="js/ekko-lightbox.min.js"></script>
        <script src="js/autosize.min.js"></script>
        <script src="icons/emoticons.js"></script>
        <script src="js/script_main.js"></script>
        <script src="js/arrive.min.js"></script>
        <script src="js/mask.min.js"></script>
        <script src="js/moment.min.js"></script>
        <script src="js/fullcalendar.min.js"></script>
        <script src="js/ckeditor/ckeditor.js"></script>
        
        <script src="ng/angular.min.js"></script>
        <script src="ng/angular-route.min.js"></script>
        <script src="ng/angular-animate.min.js"></script>
        <script src="ng/angular-sanitize.min.js"></script>
        <script src="ng/angular-file-upload.min.js"></script>
        <script src="ng/ui-bootstrap-tpls-1.3.3.min.js"></script>
        
        <script src="ng/angular-storage.min.js"></script>
        <script src="ng/angular-jwt.js"></script>
        <script src="ng/ng-ckeditor/ng-ckeditor.min.js"></script>
        <script src="ng/angular-bootstrap-confirm.js"></script>
        <script src="ng/angular-locale_pl.js"></script>
        <script src="ng/datetimepicker.js"></script>
        <script src="ng/loading-bar.js"></script>
        
        <?php 
            require_once("js/_main.php");
            require_once("js/_app.php");
            require_once("parts/_chat.php");
            require_once("parts/sidebar.php");
            require_once("parts/modals.php");
        ?>
        
        <script type="text/javascript" src="audio/js/swfobject.js"></script>
        <script type="text/javascript" src="audio/js/recorder.js"></script>
        <script type="text/javascript" src="audio/basic/basic.js"></script>
        
        <script src="http://code.responsivevoice.org/responsivevoice.js"></script>
        
        <script>
            
            $.ajaxPrefilter(function(options,originalOptions,jqXHR) { options.async = true; });
            
            // ===== BEZ TEGO NIE DZIAŁA CKE W MODAL =====
            
            $.fn.modal.Constructor.prototype.enforceFocus = function () {
                var $modalElement = this.$element;
                $(document).on('focusin.modal', function (e) {
                    var $parent = $(e.target.parentNode);
                    if ($modalElement[0] !== e.target && !$modalElement.has(e.target).length
                        // add whatever conditions you need here:
                        &&
                        !$parent.hasClass('cke_dialog_ui_input_select') && !$parent.hasClass('cke_dialog_ui_input_text')) {
                        $modalElement.focus();
                    }
                });
            };
            
            // ===== TEXTAREA AUTOSIZE =====
            
            jQuery("body").arrive('[data-toggle="tooltip"]', function() { 
                $('[data-toggle="tooltip"]').tooltip();
                autoSizeText();
            });
            
        </script>

    </body>
</html>