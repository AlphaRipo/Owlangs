<?php $rightOff = true; require_once("ajax/db.php"); ?>
    
<style>
    .my-drop-zone { border: dotted 3px lightgray; }
    .nv-file-over { border: dotted 3px red; }
    .another-file-over-class { border: dotted 3px green; }
    canvas {
        background-color: #f3f3f3;
        -webkit-box-shadow: 3px 3px 3px 0 #e3e3e3;
        -moz-box-shadow: 3px 3px 3px 0 #e3e3e3;
        box-shadow: 3px 3px 3px 0 #e3e3e3;
        border: 1px solid #c3c3c3;
        margin: 6px 0 0 6px;
    }
    .cn-left {text-align: left; }
    #msg-content{
        max-height: 500px;
        overflow-y: scroll;
    }
</style>
            
<!-- Zawartość zakładek -->
<div class="tab-content" nv-file-drop="" uploader="uploader">
    
    <div class="row" style="padding: 20px 50px 50px 50px;" ng-if="!messages">
        <div style="margin-top:20px;" class="well">
            <h5>Wbierz rozmówcę z listy po lewej lub &nbsp; 
                <button ng-click="write = !write" class="btn btn-warning"><i class="fa fa-search" aria-hidden="true"></i> WYSZUKAJ Z LISTY ZNAJOMYCH</button>
            </h5>
            <div ng-if="write" >
                <input style="margin-top:20px;" class="form-control" type="text" ng-model="searchFriend" placeholder="Wyszukaj znajomego do którego chcesz napisać..." />
                    
                <table style="margin-top:20px;" class="table table-striped">
                    <tr ng-repeat="friend in friends | filter : searchFriend">
                        <td><img class="img-thumbnail" ng-src="{{friend.avatar}}" width="40"/></td>
                        <td class="cn-left">{{friend.imie}} {{friend.nazwisko}}</td>
                        <td class="cn-left">Level: {{friend.lvl_ang}}</td>
                        <td><button class="btn btn-sm btn-success" ng-click="writeTo(friend)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> WRITE</button></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div ng-if="messages.length > 0">
        <div class="row" style="padding: 20px 50px 0px 50px;">

            <div class="szukanie col-xs-12 nopadding">
                <div style="margin-bottom:20px;" class="input-group">
                    <input type="text" class='form-control' ng-model="keywordsChat" placeholder="Szukaj w słów kluczowych tej rozmowie...">
                    <span class="input-group-btn">
                        <a class="btn btn-default" id='searchBtn' type="button"><i class="fa fa-search"></i></a>
                    </span>
                </div>
            </div>
        </div>

        <div id="msg-content" style="padding: 0px 50px 0px 50px;" class="row alertsFromWinTheme">
            <div class="news col-xs-12 alert" ng-class="{ 'alert-info':checkMe(msg.kto), 'alert-warning':!checkMe(msg.kto) }" ng-repeat="msg in messages | filter : keywordsChat" on-finish-render="ngRepeatFinished">
                <div class="avatar col-xs-2">
                    <img class="img-circle" width="60" src="{{getAvatar(msg.kto)}}" />
                </div>
                <div class="tresc col-xs-9 nopadding">
                    <p><a ng-href="/#/user/{{msg.kto}}"><span class="pull-left">{{getFullName(msg.kto)}}:</span></a> <time class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i> {{createDate(msg.kiedy) | date : 'medium'}}</time></p>
                    <div class="clearfix"></div>
                    <br>
                    <span style="text-align:left;" ng-init="seen(msg)" ng-bind-html="parseMsg(msg.co)" class="pull-left"></span>
                    <br>
                    <span ng-repeat="img in msg.images" class="pull-left">
                        <img style="width:100%;margin:10px 5px 5px 0px;" class="img-thumbnail" ng-src="{{img.answer}}" />
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row" style="padding: 20px 50px 50px 50px;" ng-if="messages.length == 0">
        <div class="alert alert-info"><i class="fa fa-info-circle" aria-hidden="true"></i> Brak wiadomości, napisz coś...</div>
    </div>
        
    <div ng-if="messages.length >= 0" style="padding: 20px 50px 50px 50px;" class="wys_wiadomosci row nopadding">
        
        <div class="formularz col-xs-12">
            <hr>
            <h4 class="cn-left">
                <img width="50px" class="img-thumbnail" ng-src="{{selected.avatar}}"/> Napisz do 
                <a ng-href="/#/user/{{selected.id}}"><strong>{{selected.imie}} {{selected.nazwisko}} [{{selected.lvl_ang}}]</strong></a>
            </h4>
            
            <div ng-if="cannot" style="width:100%" class="alert alert-danger"><i class="fa fa-lg fa-frown-o" aria-hidden="true"></i> pssst! <strong>Musisz być VIPem</strong> by wysyłać więcej niż 1 wiadomość na dobę!</div>
            
            <form ng-submit="onSubmit()">
                <div class="col-xs-12 nopadding">
                    <textarea class="form-control" ng-model="inp.answer" placeholder="Kliknij i zacznij pisać..."></textarea>
                </div>
                <div><button type="submit" ng-disabled="lock == true" class="btn btn-block btn-success">Wyślij wiadomość</button></div>
            </form>
        </div>
            
        <!-- UPLOADER -->
            
        <div class="col-xs-12">
            
            <h3>Dodaj zdjęcia:</h3>
                
            <div ng-show="uploader.isHTML5">
                <div class="well my-drop-zone" nv-file-over="" uploader="uploader">
                    Przeciągnij i upuść zdjęcie tutaj...
                </div>
            </div>
            <input class="btn btn-default" type="file" nv-file-select="" uploader="uploader" multiple  /><br/>
                
        </div>
            
        <div class="col-xs-12" style="margin-bottom: 40px">
            
            <table class="table">
                <thead>
                    <tr>
                        <th width="50%">File name</th>
                        <th ng-show="uploader.isHTML5">Size</th>
                        <th ng-show="uploader.isHTML5">Progress</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in uploader.queue">
                        <td>
                            <strong>{{ item.file.name }}</strong>
                            <div ng-show="uploader.isHTML5" ng-thumb="{ file: item._file, width: 200 }"></div>
                        </td>
                        <td ng-show="uploader.isHTML5" nowrap>{{ item.file.size/1024/1024|number:2 }} MB</td>
                        <td ng-show="uploader.isHTML5">
                            <div class="progress" style="margin-bottom: 0;">
                                <div class="progress-bar" role="progressbar" ng-style="{ 'width': item.progress + '%' }"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span ng-show="item.isSuccess"><i class="fa fa-smile-o" aria-hidden="true"></i></span>
                            <span ng-show="item.isCancel"><i class="fa fa-frown-o" aria-hidden="true"></i></span>
                            <span ng-show="item.isError"><i class="fa fa-trash-o" aria-hidden="true"></i></span>
                        </td>
                        <td nowrap>
                            <button type="button" class="btn btn-success btn-xs" ng-click="lockSendBtn();item.upload();" ng-disabled="item.isReady || item.isUploading || item.isSuccess">
                                <i class="fa fa-upload" aria-hidden="true"></i> Upload
                            </button>
                            <button type="button" class="btn btn-warning btn-xs" ng-click="unlockSendBtn();item.cancel();" ng-disabled="!item.isUploading">
                                <i class="fa fa-times" aria-hidden="true"></i> Cancel
                            </button>
                            <button type="button" class="btn btn-danger btn-xs" ng-click="unlockSendBtn();item.remove();">
                                <i class="fa fa-trash-o" aria-hidden="true"></i> Remove
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
                
            <div>
                <div>
                    Progress:
                    <div class="progress" style="">
                        <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                    </div>
                </div>
                <button type="button" class="btn btn-success btn-s" ng-click="lockSendBtn();uploader.uploadAll();" ng-disabled="!uploader.getNotUploadedItems().length">
                    <i class="fa fa-upload" aria-hidden="true"></i> Update all
                </button>
                <button type="button" class="btn btn-warning btn-s" ng-click="unlockSendBtn();uploader.cancelAll();" ng-disabled="!uploader.isUploading">
                    <i class="fa fa-times" aria-hidden="true"></i> Cancel all
                </button>
                <button type="button" class="btn btn-danger btn-s" ng-click="unlockSendBtn();uploader.clearQueue();" ng-disabled="!uploader.queue.length">
                    <i class="fa fa-trash-o" aria-hidden="true"></i> Remove all
                </button>
            </div>
        </div>
            
        <!-- UPLOADER -->
            
    </div>
</div>
