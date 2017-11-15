<?php require_once("ajax/db.php"); ?>

    <style type="text/css">
        #exe .btn { white-space: pre-line!important;margin-bottom:10px; }
        .panel .text-danger {
            border: 5px solid #a94442;
        }
        .panel .text-success {
            border: 5px solid #67b168;
        }
        .paski .wynik {
            margin-left: -3%!important;
        }
    </style>

    <? require_once 'parts/menuTrainings.php'; ?>

    <div id="ekran_kursow" class="col-xs-12" style="margin-top:20px">
        
        <div class="panel panel-default">
            <div style="padding:10px;" class="panel-body well"> 
                
                <div class="pull-left col-xs-10">
                    <h5 style="text-align:left" ng-bind-html="( '<strong>Training no. '+TID +':</strong> '+ training.name )"></h5>
                </div>
                
                <div class="pull-right col-xs-2">
                    <a ng-href="/#/trainings" class="btn btn-sm btn-warning"><i class="fa fa-chevron-up"></i></a>
                    <button class="btn btn-sm btn-primary" ng-click="reload()">
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                    </button>
                </div>
                
            </div>
        </div>
        
        <div ng-if="cannot === 1" class="alert alert-danger"><i class="fa fa-lg fa-frown-o" aria-hidden="true"></i> ups! <strong>Przekroczyłeś limit dostepnych 5 odsłon zadań,</strong> wróć jutro lub rozszerz pakiet do VIP</div>

        <div ng-if="training.content.article" class="panel panel-default">
        
            <div class="panel-heading"><? echo langs("ARTYKUŁ"); ?></div>
            <div class="panel-body">
                
                <div class="col-centered col-md-12 nopadding" ng-bind-html="training.content.article | trustAsHtml"></div>
                
            </div>
        </div>
            
        <div ng-if="training.content.video.length > 0" class="panel panel-default">
        
            <div class="panel-heading"><? echo langs("SZKOLENIE VIDEO"); ?></div>
            <div class="panel-body">
                
                <div class="col-centered col-md-12 nopadding">
                    <div class="col-md-12" ng-repeat="video in training.content.video">
                        
                        <video width="640" height="480" controls>
                            <source ng-src="{{video}}" type="video/mp4">
                            <source ng-src="{{video}}" type="video/webm">
                            <source ng-src="{{video}}" type="video/ogv">
                        </video>
                        
                    </div>
                </div>
                
            </div>
        </div>
            
        <div ng-if="training.content.audio.length > 0" class="panel panel-default">
        
            <div class="panel-heading"><? echo langs("SZKOLENIE AUDIO"); ?></div>
            <div class="panel-body">
                
                <div class="col-centered col-md-12 nopadding">
                    <div class="col-md-12" ng-repeat="audio in training.content.audio">
                        
                        <audio controls>
                            <source ng-src="{{audio}}" type="audio/ogg">
                            <source ng-src="{{audio}}" type="audio/wav">
                            <source ng-src="{{audio}}" type="audio/mpeg">
                        </audio>
                        
                    </div>
                </div>
                
            </div>
        </div>
            
        <div ng-if="training.content.images.length > 0" class="panel panel-default">
        
            <div class="panel-heading"><? echo langs("ZDJĘCIA"); ?></div>
            <div class="panel-body">
                
                <div class="col-centered col-md-12 nopadding">

                    <div class="col-md-12" ng-repeat="image in training.content.images">
                        <img class="img-thumbnail img-responsive" ng-src="{{image}}">
                    </div>
                    
                </div>
                
            </div>
        </div>
            
        <div ng-if="training.content.links.length > 0" class="panel panel-default">
        
            <div class="panel-heading"><? echo langs("LINKI"); ?></div>
            <div class="panel-body">
                
                <div class="col-centered col-md-12 nopadding">

                    <div class="col-md-12" ng-repeat=" link in training.content.links">
                        <span ng-bind-html="( urlify(link) | trustAsHtml )"></span>
                    </div>
                    
                </div>
                
            </div>
        </div>

        <div ng-if="training.content.exercises.length > 0">
            <div id="exe" class="well"><? echo langs("ZADANIA DO WYKONANIA:"); ?> <strong ng-bind="training.content.ask"></strong></div>
            <div class="col-md-12 nopadding">
                
                <div class="col-md-12">
                    
                    <div class="panel panel-default" ng-repeat="exercise in training.content.exercises">
                        <div class="panel-heading"><p><strong ng-bind="( 'Task ' +($index+1)+ ': ' )"></strong><br><span ng-bind="exercise.exercise"></span></p></div>
                        <div class="panel-body">
                            <div ng-model="res2" ng-init=" exercise.answers = mieszamy(exercise.answers)" ng-class="{ 'has-success':res2 === 1, 'has-error':res2 === 0 }"  class="form-inline form-group has-feedback">

                                <div ng-if="training.type === 1" class="col-md-6 col-xs-12" style="margin-bottom:15px" ng-repeat="answer in exercise.answers">
                                    <button ng-if="training.type === 1" 
                                        ng-class="{ 'btn-success':res1 === 1, 'btn-danger':res1 === 0 }" 
                                        ng-click="res1 = checkAnswer((answer.value || answer), exercise.true); countAnswers(exercise,res1); exercise.clicked = 1;" class="btn btn-block btn-sm btn-default" 
                                        ng-bind="( '['+toLetters($index+1) +'] '+ (answer.value || answer) )">
                                    </button>
                                </div>
                                
                                <select style="width:100%" class="form-control" 
                                    ng-model="selectedAnswer" 
                                    ng-if="training.type === 2" 
                                    ng-change="$parent.res2 = checkAnswer((selectedAnswer.value || selectedAnswer), exercise.true); countAnswers(exercise,$parent.res2); exercise.clicked = 1;" 
                                    ng-options="answer as (answer.value || answer) for answer in exercise.answers track by (answer.value || answer)">
                                </select>

                                <input style="width:100%" class="form-control" type="text" 
                                    ng-model="answer"
                                    ng-if="training.type === 3" 
                                    ng-blur="$parent.res2 = checkAnswer(answer, (exercise.true || exercise.answers[0] )); countAnswers(exercise,$parent.res2); exercise.clicked = 1;" 
                                    ng-enter="$parent.res2 = checkAnswer(answer, (exercise.true || exercise.answers[0] )); countAnswers(exercise,$parent.res2); exercise.clicked = 1;" />

                                <div style="margin-top:5px" ng-if="res2 === 1 || res2 === 0" ng-class="{'alert-success':res2 === 1,'alert-danger':res2 === 0}" class="alert">
                                    <span ng-bind=" (res2 === 1) ? 'Gratulacje! Ta odpowiedź jest poprawna! :)' : 'Ups! :( Ta odpowiedź jest błędna...' "></span>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div ng-if="training.dict.length > 0">
            <div class="well"><? echo langs("ZWROTY DO SOWNIKA:"); ?></div>
            <div class="col-md-12 nopadding">
                
                <table class="table table-striped table-responsive table-hover">
                    <tr>
                        <th style="text-align:center">PL</th>
                        <th style="text-align:center">EN</th>
                        <th style="text-align:center"></th>
                        <th style="text-align:center">
                            <button ng-click="addAll2MyDict()" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij aby dodać wszystkie!"); ?>" class="btn btn-xs btn-primary">
                                <i class="fa fa-plus"></i>
                            </button>
                        </th>
                    </tr>
                    <tr ng-repeat="dict in training.dict">
                        <td ng-bind="dict.pl"></td>
                        <td ng-bind="dict.en"></td>
                        <td>
                            <button class="btn btn-xs btn-default"><i class="fa fa-volume-up"></i></button>
                            <button class="btn btn-xs btn-default"><i class="fa fa-picture-o"></i></button>
                        </td>
                        <td>
                            <button ng-click="addThis2MyDict(dict)" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="clearfix"></div>
        
        <div class="alert alert-info" ng-show="(training.content.exercises.length > 0)">
            <div style="padding-top:40px;" class="paski col-xs-12 carusel10">
                <div class="glowny col-md-6 col-xs-12 nopadding">
                    
                    <div class="kolko col-xs-3 nopadding" ng-bind="(percentOfCorrect+'%')"></div>
                    <div class="progress progress-striped col-xs-6 nopadding">
                        <div class="progress-bar pro1 progress-bar-warning"></div>
                    </div>
                    <div class="wynik col-xs-3"><span ng-bind="correctAnswers"></span><span ng-bind="('/'+training.content.exercises.length)"></span></div>
                    
                </div>
                <div class="col-md-6 col-xs-12 nopadding">
                    
                    <p><strong><i class="fa fa-lg fa-smile-o" aria-hidden="true"></i> <? echo langs("Ilość poprawnych: ").": "; ?><span ng-bind="correctAnswers"></span></strong></p>
                    <p><strong><i class="fa fa-lg fa-frown-o" aria-hidden="true"></i> <? echo langs("Ilość niepoprawnych: ").": "; ?><span ng-bind="incorrectAnswers"></span></strong></p>
                    
                </div>
            </div>
            <div ng-show="(correctAnswers+incorrectAnswers === training.content.exercises.length)">
                <h3 ng-bind="message"></h3>
                
                <div>
                    <img ng-show="percentOfCorrect >= 80" class="img-thumbnail" ng-src="img/gatsby.gif">
                    <img ng-show="percentOfCorrect >= 50 && percentOfCorrect < 80" class="img-thumbnail" ng-src="img/revenant.jpg">
                    <img ng-show="percentOfCorrect < 50" class="img-thumbnail" ng-src="img/unlucky.jpg">
                </div>
                
                <button style="margin-top:10px" ng-show="percentOfCorrect < 50" class="btn btn-primary" ng-click="reload()">
                    <i class="fa fa-refresh" aria-hidden="true"></i> <? echo langs("Kliknij i spróbuj ponownie!"); ?>
                </button>
                
            </div>
            <div class="clearfix"></div>
        </div>

        <div ng-show="percentOfCorrect >= 50 || training.content.exercises.length === 0" class="alert alert-success">
            <p class="pull-left"><strong><? echo langs("Oznacz szkolenie jako ukończone!<br>* - pojawi się na liście szkoleń, które odbyłeś."); ?></strong></p>
            
            <button ng-class="{'btn-danger':done,'btn-info':!done}" ng-click="(done) ? del() : done()" class="btn btn-sm  pull-right">
                <i ng-class="{'fa-times':done,'fa-graduation-cap':!done}" class="fa"></i> <span ng-bind="( (done) ? '<? echo langs("Usuń z ukończonych"); ?>' : '<? echo langs("Oznacz jako ukończone"); ?>' )"></span>
            </button>
                
            <div class="clearfix"></div>
        </div>

    </div>

    <script type="text/javascript">

//        bootbox.confirm('<? //echo langs("Na pewno usunąć to szkolenie z twojej listy ukończonych?"); ?>', function(result) {
//        $.post("ajax/delFromMyTrainings.php", { nr:nr,mid:mid }, function( data ) { changeDone2Todo(); });
//
//        bootbox.confirm('<? //echo langs("Na pewno dodać to szkolenie do twojej listy ukończonych?"); ?>', function(result) {
//        $.post("ajax/add2MyTrainings.php", { nr:nr,mid:mid }, function( data ) { changeTodo2Done(); });
//
//        $.post("ajax/add2MyDict.php", { json:_DICT, mid:mid }, function(data) { }); // add all words or add single to my dict - how to do this in new version ???

    </script>