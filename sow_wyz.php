<?php require_once("ajax/db.php"); ?>

<style type="text/css">
    .flip-container { perspective: 1000; }
    .flip-container, .front, .back { width: 100%; height: 350px; }
    .flipper { transition: 0.6s; transform-style: preserve-3d; position: relative; }
    .front, .back { backface-visibility: hidden; position: absolute; top: 0; left: 0; }
    .front { z-index: 2; }
    .back { }
    .prev, .next { cursor:pointer; }
    .ico-middle { position: relative; top: 50%; }
</style>

<!-- Zawartość zakładek -->
<div id="sownik" class="row">

    <div class="navigacja col-xs-12 nopadding">
    <? require_once 'parts/menuWords.php'; ?>
    </div>
    <div class="clearfix"></div>

    <div style="padding-top: 20px;" class="col-xs-12">
        <div class="alert alert-warning" style="background-color:#79648b;">
            <h3 style="color:#fff!important;"><? echo langs("Wybierz kategorię słówek z ponizszych grup..."); ?></h3>
            <select class="form-control" ng-model="selected" ng-options="dict as (dict.id+'. '+dict.title+' ('+dict.description+')') group by (dict.nazwisko+' '+dict.imie) for dict in dicts track by dict.id"></select>
        </div>
    </div>

    <div class="clearfix"></div>
    <div style="padding-top:40px;" class="paski col-xs-12 carusel10">
        <div class="glowny col-md-9 col-xs-12 nopadding">
            <div class="kolko col-xs-3">{{points}} / {{selected.words.length}}</div>
            <div class="progress progress-striped col-xs-6">
                <div class="progress-bar pro1 progress-bar-warning"></div>
            </div>  
            <div class="wynik col-xs-3">{{percentage}}%</div>
        </div>
        <div class="col-md-3 col-xs-12 nopadding">
            <button class="btn">
                life
                <img ng-if="life3" src="img/podstrony/mala_sowa.png" />
                <img ng-if="life2" src="img/podstrony/mala_sowa.png" />
                <img ng-if="life1" src="img/podstrony/mala_sowa.png" />
            </button>   
        </div>
        <!--<button class="btn">combo x 8</button>-->  

    </div>

    <div ng-if="game">

        <div style="height:300px;" ng-click="prevWord()" class="col-xs-1 nopadding"><i class="ico-middle cn-hand btn-link fa fa-3x fa-chevron-left"></i></div>
        <div class="flashcard col-xs-10 nopadding carusel10">
            <div class="flip-container">
                <div class="flipper">
                    <div ng-show="front">
                        <div ng-click="front =! front" class="fiszka">
                            <span class="phoca-flag pl" style="width:30px;height:30px;"></span>
                            <span>PL</span>
                            <p style="margin-top:30px" class="wordPL">{{pl}}</p>
                            <br>
                            <button><? echo langs("ODWRÓĆ"); ?></button>
                        </div>
                    </div>
                    <div ng-show="!front">
                        <div ng-click="front =! front" class="fiszka">
                            <span class="phoca-flag gb" style="width:30px;height:30px;"></span>
                            <span>EN</span>
                            <p style="margin-top:30px" class="wordEN">{{en}}</p>
                            <span>{{example}}</span>
                            <br>
                            <button><? echo langs("ODWRÓĆ"); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="height:300px;" ng-click="nextWord()" class="col-xs-1 nopadding"><i class="ico-middle btn-link cn-hand fa fa-3x fa-chevron-right"></i></div>  

        <div style="padding-top: 20px!important;" class="odp col-xs-12 nopadding">
            <div class="col-xs-9 nopadding">
                <form ng-submit="checkAnswer(inputs.answer)"><input placeholder="<? echo langs("Wpisz tu poprawną odp..."); ?>" ng-model="inputs.answer" id="answer" role="textbox"></form>
            </div>
            <div class="timer col-xs-3 nopadding">
                <time ng-style="myStyle" class="cn-time">{{seconds}}</time>
            </div>
        </div>

    </div>

    <div class="clearfix"></div>
    <div class="col-xs-12" ng-if="gameOver">
        <div class="alert alert-danger"> <? echo langs("Game Over, try again..."); ?> <button ng-click="restart()" class="btn btn-warning"><i class="fa fa-repeat" aria-hidden="true"></i> Restart</button></div>
    </div>

    <div class="pagination col-xs-12">
        <div class="col-md-6 col-xs-12 col-md-push-6">
            <div ng-if="positionBar">
                <p><span class="offset">{{word+1}}</span><span> / </span><span class="maxWords">{{selected.words.length}}</span></p>
                <a ng-click="prevWord()" class="prev"></a>
                <div class="progress progress-striped">
                    <div class="progress-bar pro2 progress-bar-warning"></div>
                </div>
                <a ng-click="nextWord()" class="next"></a>
            </div>
        </div>

        <div class="col-md-4 col-xs-12 col-md-pull-6 nopadding">
            <a class="btn btn-warning" ng-click="getRandomWords();"><i class="fa fa-random" aria-hidden="true"></i> <? echo langs("Losuj nowe wyzwanie"); ?></a>
        </div>
    </div>
</div>
