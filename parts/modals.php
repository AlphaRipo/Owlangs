
<!-- ===================== Event Details Modal ===================== -->

<div ng-controller="eventDetailsCtrl" data-backdrop="static" class="modal fade" id="eventDetailsModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailsModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="eventDetailsModalLabel"><? echo langs("Szczegóły wydarzenia").": "; ?><strong>{{eventDetails.title}}</strong></h4>
            </div>
            <div class="modal-body">
                <div class="col-xs-12"> 
                    
                    <div style="text-align:left;">
                        
                        <span style="font-size:16px;">event from: <strong><span class="label label-success"><i class="fa fa-clock-o" aria-hidden="true"></i> {{createDate(eventDetails.start) | date}}</span></strong></span> &nbsp; 
                        <span style="font-size:16px;" ng-if="eventDetails.start <= eventDetails.end"> to: <span class="label label-danger"><i class="fa fa-clock-o" aria-hidden="true"></i> <strong>{{createDate(eventDetails.end) | date}}</span></strong></span>

                    </div>
                    
                    <hr>
                    
                    <div ng-if="eventDetails.description && !edited" style="text-align: left;" class="well"><p>description: <strong>{{eventDetails.description}}</strong></p></div>
                    <div ng-if="eventDetails.description && edited" style="text-align: left;" class="well"><p>description: <textarea class="form-control">{{eventDetails.description}}</textarea></p></div>
                    <hr ng-if="eventDetails.description">
                    
                    <div ng-if="eventDetails.todo && !edited" style="text-align: left;" class="well">
                        <p ng-if="eventDetails.todo.did">Words to learn: <a ng-href="/#/words/{{eventDetails.todo.did}}">{{eventDetails.todo.dname}}</a></p>
                        <p ng-if="eventDetails.todo.tid">Training to do: <a ng-href="/#/training/{{eventDetails.todo.tid}}">{{eventDetails.todo.tname}}</a></p>
                    </div>
                    <hr ng-if="eventDetails.todo">
                            
                    <h4 colspan="2"><i class="fa fa-users" aria-hidden="true"></i> Osoby zaangażowane w event</h4>
                    <hr>

                    <div class="nopadding" ng-if="eventDetails.people && !edited">
                        <div class="col-md-4 col-xs-12" ng-repeat="friend in eventDetails.people | filter : searchFriend">
                            <div class="panel panel-default">
                                <div style="text-align:left;" class="panel-body">
                                    <a ng-href="/user_{{friend.id}}">
                                        <table width="100%">
                                            <tr>
                                                <td width="70"><img class="img-thumbnail" ng-src="{{friend.avatar}}" width="60"/></td>
                                                <td>{{friend.imie}}<br>{{friend.nazwisko}}</td>
                                                <td width="30">
                                                    <span class="label" ng-class="{'label-success' : friend.lvl_ang === 'A1' || friend.lvl_ang === 'A2','label-warning' : friend.lvl_ang === 'B1' || friend.lvl_ang === 'B2','label-danger' : friend.lvl_ang === 'C1' || friend.lvl_ang === 'C2'}">{{friend.lvl_ang}}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </a>
                                    <button type="button" ng-if="eventDetails.who == aboutMe.id" ng-click="delPerson(friend)" class="btn btn-danger btn-xs" style="position:absolute; right:8px; top:-4px;"><strong>&times;</strong></button>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div ng-if="eventDetails.people && edited">
                        <input style="padding:10px;" class="form-control" type="text" ng-model="searchFriend" placeholder="Wyszukaj znajomego, któremu chcesz zaplanować zadanie..." />
                        <table style="margin-top:20px;" class="table table-striped">
                            <tr ng-repeat="friend in friendsAll | filter : searchFriend">
                                <td><a ng-href="/user_{{friend.id}}"><img class="img-thumbnail" ng-src="{{friend.avatar}}" width="40"/></a></td>
                                <td class="cn-left">{{friend.imie}} {{friend.nazwisko}}</td>
                                <td class="cn-left">Level: <span class="label" ng-class="{'label-success' : friend.lvl_ang === 'A1' || friend.lvl_ang === 'A2','label-warning' : friend.lvl_ang === 'B1' || friend.lvl_ang === 'B2','label-danger' : friend.lvl_ang === 'C1' || friend.lvl_ang === 'C2'}">{{friend.lvl_ang}}</span></td>
                                <td width="50">
                                    <button class="btn btn-xs"
                                        ng-init="friend.clicked = false;"
                                        ng-click="friend.clicked = !friend.clicked; checked(friend.clicked,friend);"
                                        ng-class="{'btn-success':friend.clicked,'btn-warning':!friend.clicked}">
                                        <i ng-class="{'fa-square-o':!friend.clicked,'fa-check-square-o':friend.clicked}" class="fa" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                
                <button type="button" 
                    mwl-confirm
                    title="Na pewno usunąć?"
                    message="Wskazówka: To wydarzenie zostanie usunięte..."
                    confirm-text="Remove"
                    cancel-text="Cancel"
                    on-confirm="removeEvent(eventDetails)"
                    on-cancel=""
                    confirm-button-type="success"
                    cancel-button-type="danger"
                    ng-disabled="eventDetails.who !== aboutMe.id" class="pull-left btn cn-tips btn-danger"><i class="fa fa-trash"></i> <? echo langs("Usuń wydarzenie"); ?>
                </button>
                
                <button type="button" ng-disabled="eventDetails.who !== aboutMe.id" ng-init="edited = false;" ng-click="edited = true; getFriendsAll();" ng-show="!edited" class="btn pull-left btn-warning"><i class="fa fa-pencil-square"></i> <? echo langs("Edytuj wydarzenie"); ?></button>
                <button ng-show="edited" type="button" 
                    mwl-confirm
                    title="Na pewno zapisać?"
                    message="Wskazówka: To wydarzenie zostanie wyedytowane a osoby zaangażowane w wątek poinformowane..."
                    confirm-text="Update"
                    cancel-text="Cancel"
                    on-confirm="edited = false; editEvent(eventDetails);"
                    on-cancel=""
                    confirm-button-type="success"
                    cancel-button-type="danger"
                    ng-disabled="eventDetails.who !== aboutMe.id" class="pull-left btn btn-success"><i class="fa fa-pencil-square"></i> <? echo langs("Zapisz wydarzenie"); ?>
                </button>
                
                <button type="button" 
                    mwl-confirm
                    title="Na pewno usunąć?"
                    message="Wskazówka: To wydarzenie zniknie na zawsze z Twojego kalendarza..."
                    confirm-text="Remove me"
                    cancel-text="Cancel"
                    on-confirm="removeMeFromEvent(eventDetails)"
                    on-cancel=""
                    confirm-button-type="success"
                    cancel-button-type="danger"
                    ng-disabled="!checkMeInEvent(eventDetails.people)" class="btn cn-tips btn-primary"><i class="fa fa-trash"></i> <? echo langs("Usuń mnie z wydarzenia"); ?>
                </button>
                    
                <button type="button" class="btn cnClose btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <? echo langs("Zamknij"); ?></button>
                
            </div>
        </div>
    </div>
</div>

<!-- ===================== New Event Details Modal ===================== -->

<div ng-controller="newEventData" data-backdrop="static" class="modal fade" id="newEventDataModal" tabindex="-1" role="dialog" aria-labelledby="newEventDataModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="newEventDataModalLabel"><? echo langs("Dodawanie nowego wydarzenia"); ?> to <strong>{{date1 | date}}</strong></h4>
            </div>
            <div class="modal-body">

                <div class="well col-md-12 col-xs-12 mb">
                    <label class="pull-left"> Title for new event</label>
                    <input placeholder="Kliknij aby wpisać tytuł" class="form-control mb" ng-model="inputs.title">
                    <label class="pull-left"> Event description</label>
                    <textarea ng-model="inputs.desc" class="form-control mb" placeholder="Kliknij by dodać komentarz"></textarea>
                    <label class="pull-left"> Event for (select a person or people by orange button)</label>
                    <div>

                        <input style="margin-top:20px;" class="form-control" type="text" ng-model="searchFriend" placeholder="Wyszukaj znajomego, któremu chcesz zaplanować zadanie..." />
                        <div class="scrollabe">

                            <table style="margin-top:20px;" class="table table-striped">
                                <tr ng-repeat="friend in friends | filter : searchFriend">
                                    <td><img class="img-thumbnail" ng-src="{{friend.avatar}}" width="40"/></td>
                                    <td class="cn-left">{{friend.imie}} {{friend.nazwisko}}</td>
                                    <td class="cn-left">Level: {{friend.lvl_ang}}</td>
                                    <td width="50">
                                        <button class="btn btn-xs"
                                            ng-init="friend.clicked = false;"
                                            ng-click="friend.clicked = !friend.clicked; checked(friend.clicked,friend);"
                                            ng-class="{'btn-success':friend.clicked,'btn-warning':!friend.clicked}">
                                            <i ng-class="{'fa-square-o':!friend.clicked,'fa-check-square-o':friend.clicked}" class="fa" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
                
                <div style="padding-top: 20px;" class="well col-xs-12">
                    
                    <div class="mb"><? echo langs("Dodaj słówka do eventu"); ?>
                        <select class="form-control" ng-model="selectedDict" ng-options="dict as (dict.title+' ('+dict.description+')') for dict in dicts track by dict.title"></select>
                    </div>
                    <div class="mb"><? echo langs("Dodaj szkolenie do eventu"); ?>
                        <select class="form-control" ng-model="selectedTraining" ng-options="training as (training.name) for training in trainings track by training.name"></select>
                    </div>
                    
                </div>

                <div class="col-xs-12 well">

                    <div class="col-md-6 col-xs-12 mb"> from date: &nbsp;

                        <datetimepicker 
                            hour-step="hourStep" 
                            minute-step="minuteStep" ng-model="date1" show-meridian="showMeridian" 
                            date-format="{{format}}" date-options="{startingDay: 1}" 
                            date-disabled="disabled(date1, mode)" 
                            datepicker-append-to-body="false" 
                            readonly-date="false" 
                            hidden-time="false" 
                            hidden-date="false"  
                            name="datetimepicker1" 
                            show-spinners="true" 
                            readonly-time="false" 
                            date-opened="dateOpened1" 
                            date-ng-click="open1($event, opened)"> 
                        </datetimepicker>

                    </div>
                    <div class="col-md-6 col-xs-12 mb"> to date: &nbsp;

                        <datetimepicker 
                            hour-step="hourStep" 
                            minute-step="minuteStep" ng-model="date2" show-meridian="showMeridian" 
                            date-format="{{format}}" date-options="{startingDay: 1}" 
                            date-disabled="disabled(date2, mode)" 
                            datepicker-append-to-body="false" 
                            readonly-date="false" 
                            hidden-time="false" 
                            hidden-date="false"  
                            name="datetimepicker2" 
                            show-spinners="true" 
                            readonly-time="false" 
                            date-opened="dateOpened2" 
                            date-ng-click="open2($event, opened)"> 
                        </datetimepicker>

                    </div>
                </div>
                <div class="clearfix"></div>

            </div>
            <div class="modal-footer">
                <button type="button" 
                    mwl-confirm
                    title="Na pewno zapisać?"
                    message="Wskazówka: Do Twojego kalendarza i/lub kalendarza Twoich znajomych zostanie dodane wydarzenie, dzięki temu, możesz zaplanować swoim uczniom zadanie domowe etc."
                    confirm-text="Set Event"
                    cancel-text="Cancel"
                    on-confirm="addEvent()"
                    on-cancel=""
                    confirm-button-type="warning"
                    cancel-button-type="primary"
                    ng-disabled="(!selectedTraining && !selectedDict) || !inputs.title || !inputs.desc" class="btn cn-tips btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Set Event</button>
                <button type="button" class="btn cnClose btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <? echo langs("Zamknij"); ?></button>
            </div>
        </div>
    </div>
</div>
