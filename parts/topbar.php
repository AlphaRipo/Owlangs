<header id="sticky">
    <div class="wrapper">
        
        <style>
            .oragneBack {
                width: 22px;
                height: 22px;
                line-height: 22px;
                text-align: center;
                color: #FFFFFF!important;
                background: #ff9800;
                -webkit-border-radius: 50%;
                -moz-border-radius: 50%;
                border-radius: 50%;
                margin-top: -60px;
                margin-left: -15px;
                font-weight: 700;
            }
            li .table>tbody>tr>td { padding: 4px; }
            #calendarMini,#calendarBig { cursor: pointer; }
            .searchingResults {
                max-height: 400px;
                overflow: scroll;
            }
        </style>

        <a ng-href="/#/wall">
            <div id="logo"></div>
        </a>
        
        <div id="buttons" ng-controller="searchEngine">

            <div class="col-xs-12 nopadding">
                <div class="col-xs-10 nopadding">
                    <input ng-focus="showSearch = true" ng-change="onSearch(searchEngine)" ng-model="searchEngine" type="text" class='form-control' placeholder="<? echo langs("Wyszukaj korepetytora / znajomego / szkolenie..."); ?>">
                </div>
                <div class="col-xs-2 nopadding">
                    <a class="btn btn-default" ng-click="showSearch = true" id='searchBtn' type="button"><i class="fa fa-search"></i></a>
                </div>
            </div>

            <div ng-if="showSearch" class="searching">
                
                <div>
                    <p style="margin-top:5px;" class="pull-left"><? echo langs("wyniki dla:"); ?> <strong ng-bind="searchEngine"></strong></p>
                    <a ng-click="closeSearch()" class="btn btn-danger btn-xs pull-right">&times;</a>
                    <div class="clearfix"></div>
                </div>
                
                <div ng-show="usersResults || trainingsResults" style="padding:5px;" class="well searchingResults">
                    <div ng-repeat="user in usersResults">
                        <p style='margin-top:10px;'></p>
                        <div style="margin-bottom:10px;" class="panel panel-default">
                            <div style="padding:5px;text-align:left;" class="panel-body">
                                
                                <table style="margin:0px;" class="table">
                                    <td style="border-top:none;" width="70">
                                        
                                        <a ng-href='/#/user/{{user.id}}'><img style="margin-right:10px;" width="69px" height="69px" ng-src="{{user.avatar}}"></a>
                                        
                                    </td>
                                    <td style="border-top:none;">
                                        <a ng-href='/#/user/{{user.id}}'>
                                            <div style="margin-top:7px;">

                                                <strong>
                                                    <span ng-if="user.imie" ng-bind="user.imie"></span><br>
                                                    <span ng-if="user.nazwisko" ng-bind="user.nazwisko"></span><br>
                                                    <span ng-if="user.lvl_ang" ng-bind="'['+user.lvl_ang+']'"></span>
                                                </strong>

                                            </div>
                                        </a>
                                    </td>
                                    <td style="border-top:none;" width="60">
                                        
                                        <a ng-if="user.id !== mid && user.isfriends === 0" ng-click="user.isfriends = add2Friends(user.id)" class="btn pull-right btn-lg btn-primary" data-toggle="tooltip" data-placement="right" title="Add to friends"><i class="fa fa-md fa-user-plus"></i></a>
                                        
                                    </td>
                                </table>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div ng-repeat="training in trainingsResults">
                        <p style='margin-top:10px;'></p>
                        <div style="margin-bottom:10px;" class="panel panel-default">
                            <div style="padding:5px;text-align:left;margin-top:7px;" class="panel-body">
                                <a ng-href='/#/training/{{training.id}}'>
                                    <table style="margin:0px;" class="table">
                                        <td width="50" style="border-top:none;">

                                            <i ng-if="links(training.content.links).counter > links(training.content.links).youtube" data-toggle="tooltip" data-placement="top" data-original-title="LINK" class="fa fa-link"></i>
                                            <i ng-if="links(training.content.links).youtube" data-toggle="tooltip" data-placement="top" data-original-title="YOUTUBE" class="fa fa-youtube"></i>
                                            <i ng-if="training.content.audio.length > 0" data-toggle="tooltip" data-placement="top" data-original-title="AUDIO" class="fa fa-music"></i>
                                            <i ng-if="training.content.video.length > 0" data-toggle="tooltip" data-placement="top" data-original-title="VIDEO" class="fa fa-video-camera"></i>
                                            <i ng-if="training.content.article" data-toggle="tooltip" data-placement="top" data-original-title="ARTICLE" class="fa fa-newspaper-o"></i>
                                            <i ng-if="training.content.images.length > 0" data-toggle="tooltip" data-placement="top" data-original-title="IMAGES" class="fa fa-picture-o"></i>
                                            <i ng-if="training.content.exercises.length > 0" data-toggle="tooltip" data-placement="top" data-original-title="EXERCISES" class="fa fa-pencil-square-o"></i>
                                            <i ng-if="training.dict.length > 0" data-toggle="tooltip" data-placement="top" data-original-title="VOCABULARY" class="fa fa-book"></i>
                                            
                                        </td>
                                        <td style="border-top:none;">
                                            <p><strong ng-bind="training.name"></strong></p>
                                        </td>
                                    </table>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div ng-if="usersResults.length <= 0 && trainingsResults.length <= 0" style="margin-top:5px;margin-bottom:5px;" class="alert alert-warning"><i class="fa fa-lg fa-exclamation-circle"></i> <? echo langs("Ups! brak wyników, spróbuj inaczej lub zapytaj społeczność w polu poniżej...! :)"); ?> </div>
                
                <div class="clearfix"></div>
                
                <div class="col-xs-12 nopadding">
                    <div class="col-xs-10 nopadding">
                        <input id="searchDict" ng-keyup="$event.keyCode === 13 && captureText(search);" ng-model="search" type="text" class='form-control' placeholder="<? echo langs("Potrzebujesz pomocy? Wpisz pytanie..."); ?>">
                    </div>
                    <div class="col-xs-2 nopadding">
                       <a class="btn btn-danger" ng-click="captureText(search);" id='searchBtn' type="button" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by zapytać publicznie."); ?>"><i class="fa fa-pencil-square-o"></i></a>
                    </div>
                </div>
            </div>
            
            <div style="margin-top:4px;margin-bottom:0px;" class="col-xs-12">
                
                <div class="col-xs-6" style="padding:2px;">
                    <a class="btn btn-info btn-block btn-sm"><i class="fa fa-share"></i>&nbsp;&nbsp;&nbsp;<? echo langs("Zaproś znajomych"); ?></a>
                </div>
                <div class="col-xs-6" style="padding:2px;">
                    <a class="btn btn-success btn-block btn-sm" ng-disabled="aboutMe.vip === 1" ng-click="$location.path('/#/premium',true)"><i class="fa fa-trophy"></i>&nbsp;&nbsp;&nbsp;<? echo langs("Przejdź na VIP"); ?></a>
                </div>
            </div>
        </div>

        <div id="nav_hanburger"><img src="img/gorne_menu/hanburger.png" alt="kanapka" /></div>

        <div id="pioro"><a ng-href="/#/messages"><img src="img/gorne_menu/pioro.png" alt="pioro" /><div class="nowosci">0</div></a></div>
        <div id="dolar"><a ng-href="/#/salary"><img src="img/gorne_menu/dolar.png" alt="dolar" /><div class="nowosci">0</div></a></div>

        <ul class="glowne" id="menu">
            <li ng-click="go('/rank')" style="width:130px;">
                <img src="img/gorne_menu/progres.png" style="margin-top:7px;" alt="ico5" />
                <div class="cn-orange" ng-bind="( '<? echo langs("ranking:"); ?> '+rankingNumber )"></div>
            </li>
            
            <li class="znajomi" ng-controller="followersTopBar">
                <a><img src="img/gorne_menu/ludzie.png" /><span ng-class="{'oragneBack':countF > 0}" ng-show="countF > 0" class="powiadomienie" ng-bind="countF"></span></a>
                <div class="trojkat"><img src="img/gorne_menu/trojkat.png" /></div>
                <ul class="ukryj klikane1">
                    
                    <li><? echo langs("Najnowsi obserwujący:"); ?></li>
                    <li>
                        <table style="margin-bottom:0px;" class="table table-hover table-striped">
                            <tr ng-repeat="item in items">
                                <td width="50">
                                    <a ng-href="/#/user/{{item.who}}"><img style="margin:0px;" width="40" class="img-thumbnail" ng-src="{{item.avatar}}" data-toggle="tooltip" data-placement="top" data-original-title="{{item.imie}} {{item.nazwisko}}"></a>
                                </td>
                                <td width="30">
                                    <span class="label" ng-class="{'label-success' : item.lvl_ang === 'A1' || item.lvl_ang === 'A2','label-warning' : item.lvl_ang === 'B1' || item.lvl_ang === 'B2','label-danger' : item.lvl_ang === 'C1' || item.lvl_ang === 'C2'}">{{item.lvl_ang}}</span>
                                </td>
                                <td style="text-align:left; font-size: 11px;">{{item.imie}} {{item.nazwisko}} obserwuje Cię</td>
                                <td>
                                    <button ng-click="item.friends = add2Friends(aboutMe.id,item.who)" ng-if="item.friends === 0 && item.id !== aboutMe.id" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="right" title="Add to friends"><i class="fa fa-user-plus" aria-hidden="true"></i></button>
                                    <button ng-click="item.friends = delFromFriends(aboutMe.id,item.who)" ng-if="item.friends === 1 && item.id !== aboutMe.id" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="right" title="Remove from friends"><i class="fa fa-user-times" aria-hidden="true"></i></button>
                                </td>
                            </tr>
                        </table>
                    </li>
                    <li>
                        <a class="btn btn-link" ng-href="/#/news">More</a>
                        <a class="btn btn-link" ng-click="markAsSeen(items)">Mark as seen</a>
                    </li>
                        
                </ul>
            </li>
            
            <li class="wiadomosci" ng-controller="unReadMsg">
                <a><img style="margin-bottom:6px;" src="img/gorne_menu/koperta.png" alt="ico2" /><span ng-class="{'oragneBack':countM > 0}" ng-show="countM > 0" class="powiadomienie" ng-bind="countM"></span></a>
                <div class="trojkat"><img src="img/gorne_menu/trojkat.png" alt="trojkat" /></div>
                <ul class="ukryj klikane2">
                    
                    <li><? echo langs("Ostatnie konwersacje:"); ?></li>
                    <li>
                        <table style="margin-bottom:0px;" class="table table-hover table-striped">
                            <tr ng-repeat="item in people" ng-class="{info:item.seen === 0}" ng-click="showMsgs(item)">
                                <td><img width="40" class="img-thumbnail" ng-src="{{item.avatar}}" data-toggle="tooltip" data-placement="top" data-original-title="{{item.imie}} {{item.nazwisko}}"></td>
                                <td style="text-align:left; font-size: 11px; width: 110px;">{{ item.co | limitTo: 50 }}{{ item.co.length > 50 ? '...' : '' }}</td>

                                <td><span class="label" ng-class="{'label-success' : item.lvl_ang === 'A1' || item.lvl_ang === 'A2','label-warning' : item.lvl_ang === 'B1' || item.lvl_ang === 'B2','label-danger' : item.lvl_ang === 'C1' || item.lvl_ang === 'C2'}">{{item.lvl_ang}}</span></td>
                            </tr>
                        </table>
                    </li>
                    <li><a class="btn btn-link" ng-href="/#/messages">More</a></li>
                    
                </ul>
            </li>

            <li class="zdarzenia" ng-controller="eventsTopBar">
                <a><img src="img/gorne_menu/world.png" alt="ico2" /><span ng-class="{'oragneBack':countE > 0}" ng-show="countE > 0" class="powiadomienie" ng-bind="countE"></span></a>
                <div class="trojkat"><img src="img/gorne_menu/trojkat.png" alt="trojkat" /></div>
                <ul class="ukryj klikane3">
                    
                    <li><? echo langs("Najnowsze zdarzenia:"); ?></li>
                    <li>
                        <table style="margin-bottom:0px;" class="table table-hover table-striped">
                            <tr ng-repeat="item in items">
                            
                                <td width="50">
                                    <a ng-href="/#/user/{{item.who}}"><img style="margin:0px;" width="40" class="img-thumbnail" ng-src="{{item.avatar}}" data-toggle="tooltip" data-placement="top" data-original-title="{{item.imie}} {{item.nazwisko}} ({{item.lvl_ang}})"></a>
                                </td>
                                <td width="30">
                                    <span data-toggle="tooltip" data-placement="top" data-original-title="{{getEventShortNameByType(item.type)}}" class="label" ng-class="{'label-success' : item.type === 'P' || item.type === 'C' || item.type === 'L','label-warning' : item.type === 'W' || item.type === 'T','label-danger' : item.type === 'D' || item.type === 'A'}">{{item.type}}</span>
                                </td>
                                <td style="text-align:left; font-size: 11px;">
                                    <a ng-href="{{getEventLinkByType(item.type,item.link)}}" ng-bind="(item.imie +' '+ item.nazwisko +' '+ getEventNameByType(item.type) +' on '+ (createDate(item.added) | date: 'medium') )"></a>
                                </td>
                            
                            </tr>
                        </table>
                    </li>
                    <li>
                        <a class="btn btn-link" ng-href="/#/news">More</a>
                        <a class="btn btn-link" ng-click="markAsSeen(items)">Mark as seen</a>
                    </li>
                </ul>
            </li>

            <li class="down">
                <a ng-href="/#/settings"><img src="img/gorne_menu/narzedzia.png" alt="ico6" /><span class="powiadomienie"></span></a>
                <div class="trojkat"><img src="img/gorne_menu/trojkat.png" alt="trojkat" /></div>
                <ul class="rozwijane">
                    <li><a class="cn-hand" ng-href="/#/salary"><? echo langs("Zarobki"); ?></a></li>
                    <li><a class="cn-hand" ng-href="/#/profile/{{UID}}"><? echo langs("Profil"); ?></a></li>
                    <li><a class="cn-hand" ng-click="setAvailable(0)"><? echo langs("Wyloguj"); ?></a></li>
                </ul>
            </li>
        </ul>
    </div>
</header>
