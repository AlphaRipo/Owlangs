<?php require_once("ajax/db.php"); ?>

    <style type="text/css">
        .przyciski button {margin-left:0px;font-size:1em;}
        .cn-left {text-align:left;}
    </style>

    <? require_once 'parts/menuTrainings.php'; ?>

    <div class="singleTraining col-xs-12">
        <div class="col-xs-12" style="margin-top:20px;margin-bottom:20px;">
            <div class="input-group">
                <input id="searchTrainings" ng-model="search" type="text" class='form-control' placeholder="<? echo langs("Wyszukaj szkolenie..."); ?>">
                <span class="input-group-btn">
                    <a class="btn btn-default" id='searchBtn' type="button" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by wyczyścić pole."); ?>" ng-click="clearSearch();"><i class="fa fa-times"></i></a>
                    <a class="btn btn-default" id='searchBtn' type="button" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by wyszukać."); ?>"><i class="fa fa-search"></i></a>
                </span>
            </div>
        </div>
        <h3><? echo langs("LISTA ODBYTYCH SZKOLEŃ:"); ?> ({{trainings.length}})</h3>
    </div>

    <div class="szkolenia" style="padding:20px;"> 
        <table class="table table-striped table-responsive table-hover">
            <tr>
                <th style="width:35px;"><? echo langs("lp"); ?></th>
                <th style="width:55px;"><? echo langs("typ"); ?></th>
                <th><? echo langs("tytuł"); ?></th>
                <th style="width:80px;"><? echo langs("autor"); ?></th>
                <th style="width:120px;"><? echo langs("szczegóły"); ?></th>
                <th style="width:35px;"><? echo langs("usuń"); ?></th>
            </tr>
            <tr ng-repeat="training in trainings | filter : search">
                <td class="cn-left">{{$index+1}}</td>
                <td class="cn-left">
                    <i ng-if="links(training.content.links).counter > links(training.content.links).youtube" data-toggle="tooltip" data-placement="top" data-original-title="LINK" class="fa fa-link"></i>
                    <i ng-if="links(training.content.links).youtube" data-toggle="tooltip" data-placement="top" data-original-title="YOUTUBE" class="fa fa-youtube"></i>
                    <i ng-if="training.content.audio.length > 0" data-toggle="tooltip" data-placement="top" data-original-title="AUDIO" class="fa fa-music"></i>
                    <i ng-if="training.content.video.length > 0" data-toggle="tooltip" data-placement="top" data-original-title="VIDEO" class="fa fa-video-camera"></i>
                    <i ng-if="training.content.article" data-toggle="tooltip" data-placement="top" data-original-title="ARTICLE" class="fa fa-newspaper-o"></i>
                    <i ng-if="training.content.images.length > 0" data-toggle="tooltip" data-placement="top" data-original-title="IMAGES" class="fa fa-picture-o"></i>
                    <i ng-if="training.content.exercises.length > 0" data-toggle="tooltip" data-placement="top" data-original-title="EXERCISES" class="fa fa-pencil-square-o"></i>
                    <i ng-if="training.dict.length > 0" data-toggle="tooltip" data-placement="top" data-original-title="VOCABULARY" class="fa fa-book"></i>
                </td>
                <td class="cn-left"><a ng-href="/#/training/{{training.id}}">{{training.name}} <i class="fa fa-angle-double-right"></i></a></td>
                <td><a ng-href="/#/user/{{training.userID}}"><img width="40" class="avatar img-circle img-thumbnail" data-toggle="tooltip" data-placement="top" data-original-title="{{training.user}}" ng-src="{{training.avatar}}"</a></td>

                <td class="cn-left">
                    
                    <span ng-bind="createDate(training.date) | date"></span><br>
                    <? echo langs("Level").': '; ?>
                    
                    <span data-toggle="tooltip" data-placement="top" data-original-title="<? echo langs("poziom trudności zadania"); ?>" class="label" ng-class="{'label-success' : training.lvl === 'A1' || training.lvl === 'A2','label-warning' : training.lvl === 'B1' || training.lvl === 'B2','label-danger' : training.lvl === 'C1' || training.lvl === 'C2'}" ng-bind="training.lvl"></span>
                    
                    <span><i class="fa" data-toggle="tooltip" data-placement="top" data-original-title="<? echo langs("poziom dostępu do szkolenia"); ?>" ng-class="{ 'fa-globe': training.groups === 0, 'fa-users': training.groups === 1, 'fa-star': training.groups === 2, 'fa-lock': training.groups === 3 }"></i></span>
                
                </td>
                
                <td class="cn-left">
                    <button mwl-confirm
                        title="Na pewno usunąć?"
                        message="Wskazówka: To szkolenie zostanie usunięte z listy odbytych szkoleń..."
                        confirm-text="Remove"
                        cancel-text="Cancel"
                        on-confirm="delTraining(training.id)"
                        on-cancel=""
                        confirm-button-type="danger"
                        cancel-button-type="primary"
                        class="btn btn-xs btn-danger"><i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
        </table>
    </div>
