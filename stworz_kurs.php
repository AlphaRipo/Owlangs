<?php require_once("ajax/db.php"); require_once 'parts/menuTrainings.php'; ?>

<style type='text/css'>
    
    ul { list-style: none; }
    #recordingslist audio { margin-top: 4px; margin-right: 4px; }
    .btn-success.active { background-color: #F7941E; border-color: #F7941E; }
    .tab-container { overflow: hidden; margin-bottom: 5px; }
    .well { margin-top: 10px; }
    .przyciski button { margin-left:0px; }
    #ekran_kursow, #stworz_kurs { border:none; }
    .createOptions .col-xs-12 { margin-bottom: 10px; }
    .createOptions .col-md-6, .createOptions .col-xs-12 { padding-left: 5px; padding-right: 5px; }
    .createOptions textarea { border-radius: 0px!important; }

    .recorder button, .recorder .upload, .level {
        border: 1px solid #adadad;
        height: 30px;
        display: inline-block;
        vertical-align: bottom;
        margin: 2px;
        box-sizing: border-box;
        border-radius: 4px;
    }
    .recorder .recorder-container{}
    .recorder button { width: 90px!important; }
    .recorder img { float: left; margin-left: 0px!important; }
    .level { width: 30px; height: 30px; position: relative; }
    .progressbar { position: absolute; bottom: 0; left: 0; width: 100%; background-color: #00b100; }
    .upload { padding-top: 2px; width: 30px; }
    
    .my-drop-zone { border: dotted 3px lightgray; }
    .nv-file-over { border: dotted 3px red; }
    .another-file-over-class { border: dotted 3px green; }
    
</style>

<!-- EKRAN EDYCJI KURSÓW -->

<div id="stworz_kurs" class="col-xs-12" style="margin-top:20px;">
    
    <div class="panel panel-default">
        <div class="clearfix"></div>
        <h4 style="margin-top:10px" ng-bind="context"></h4>

        <div class="panel-heading">
            <div class="col-xs-12">
                <div class="input-group has-warning">

                    <span class="input-group-addon" id="basic-addon1"><strong><? echo langs("TYTUŁ:"); ?></strong></span>
                    <textarea rows="1" ng-model="training.name" class="form-control" placeholder="<? echo langs("Wpisz nazwę kursu (wymagane)"); ?>"></textarea>

                    <div class="input-group-btn">
                        <button class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span ng-bind=" ('LEVEL: '+' '+training.lvl) "></span> <i class="fa fa-caret-down"></i>
                        </button>
                        
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a class="cn-hand" ng-click=" training.lvl = 'A1' "><i class="fa fa-star-o"></i> <? echo langs("poziom trudności: A1"); ?></a></li>
                            <li><a class="cn-hand" ng-click=" training.lvl = 'A2' "><i class="fa fa-star-o"></i> <? echo langs("poziom trudności: A2"); ?></a></li>
                            <li role="separator" class="divider"></li>
                            <li><a class="cn-hand" ng-click=" training.lvl = 'B1' "><i class="fa fa-star-half-o"></i> <? echo langs("poziom trudności: B1"); ?></a></li>
                            <li><a class="cn-hand" ng-click=" training.lvl = 'B2' "><i class="fa fa-star-half-o"></i> <? echo langs("poziom trudności: B2"); ?></a></li>
                            <li role="separator" class="divider"></li>
                            <li><a class="cn-hand" ng-click=" training.lvl = 'C1' "><i class="fa fa-star"></i> <? echo langs("poziom trudności: C1"); ?></a></li>
                            <li><a class="cn-hand" ng-click=" training.lvl = 'C2' "><i class="fa fa-star"></i> <? echo langs("poziom trudności: C2"); ?></a></li>
                        </ul>
                    </div>

                    <div class="input-group-btn">
                        <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span>VISIBILITY: </span>
                            <i class="fa fa-lg" ng-class="{ 'fa-globe': training.groups === 0, 'fa-users': training.groups === 1, 'fa-star': training.groups === 2, 'fa-lock': training.groups === 3 }"></i> <i class="fa fa-caret-down"></i>
                        </button>
                        
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a class="cn-hand" ng-click=" training.groups = 0"><i class="fa fa-lg fa-globe"></i> <? echo langs("Publicznie"); ?></a></li>
                            <li><a class="cn-hand" ng-click=" training.groups = 1"><i class="fa fa-lg fa-users"></i> <? echo langs("Znajomi"); ?></a></li>
                            <li><a class="cn-hand" ng-click=" training.groups = 2"><i class="fa fa-lg fa-star"></i> <? echo langs("VIP"); ?></a></li>
                            <li><a class="cn-hand" ng-click=" training.groups = 3"><i class="fa fa-lg fa-lock"></i> <? echo langs("Tylko ja"); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!--  -->
        <div class="createOptions" style="margin:10px;">
            
            <uib-tabset active="active">
                <uib-tab index="0" heading="<? echo langs("Przygotowanie"); ?>">
                    
                    <div class="well" style="text-align:left;">
                        <h3><? echo langs("Co chciałbyś zrobić?"); ?></h3>

                        <input ng-model="showArticle" ng-click="check()" type="checkbox" id="cid0">
                        <label for="cid0"><? echo langs("Chcę napisać artykuł"); ?></label>
                        <br>

                        <input ng-model="showMovie" ng-click="check()" type="checkbox" id="cid1">
                        <label for="cid1"><? echo langs("Chcę nagrać filmik"); ?></label>
                        <br>

                        <input ng-model="showAudio" ng-click="check()" type="checkbox" id="cid2">
                        <label for="cid2"><? echo langs("Chcę nagrać audio"); ?></label>
                        <br>

                        <input ng-model="showHdd" ng-click="check()" type="checkbox" id="cid3">
                        <label for="cid3"><? echo langs("Chcę wrzucić plik video z dysku"); ?></label>
                        <br>

                        <input ng-model="showLinks" ng-click="check()" type="checkbox" id="cid4">
                        <label for="cid4"><? echo langs("Chcę dodać zewnętrzy link jako szkolenie"); ?></label>
                        <br>

                        <input ng-model="showImages" ng-click="check()" type="checkbox" id="cid5">
                        <label for="cid5"><? echo langs("Chcę dodać obrazek"); ?></label>
                        <br>

                        <input ng-model="showExercises" ng-click="check()" type="checkbox" id="cid6">
                        <label for="cid6"><? echo langs("Chcę dodać zadania do rozwiązania"); ?></label>
                        <br>

                        <input ng-model="showWords" ng-click="check()" type="checkbox" id="cid7">
                        <label for="cid7"><? echo langs("Chcę stworzyć listę słówek"); ?></label>
                    </div>
                    
                </uib-tab>
                <uib-tab index="1" ng-if=" showArticle || showMovie || showAudio || showHdd || showLinks || showImages " heading="<? echo langs("Szkolenie"); ?>">
                    
                    <div class="well">

                        <div ng-if="showMovie" class="col-md-6 col-sm-12">
                            <button ng-click="recFilm()" class="btn btn-block btn-danger"><i class="fa fa-video-camera"></i> <? echo langs("Nagraj 3-min video"); ?></button>
                        </div>
                        <div ng-if="showAudio" class="col-md-6 col-sm-12">
                            <button ng-click="recAudio(null)" class="btn btn-block btn-warning"><i class="fa fa-microphone"></i> <? echo langs("Nagraj tylko audio"); ?></button>
                        </div>
                        <div ng-if="showHdd" class="col-md-6 col-sm-12">
                            <button ng-click="attachAVFromDisc()" class="btn btn-block btn-warning"><i class="fa fa-upload"></i> <? echo langs("Wrzucić z dysku"); ?></button>
                        </div>
                        <div ng-if="showLinks" class="col-md-6 col-sm-12">
                            <button ng-click="addLink()" class="btn btn-block btn-success"><i class="fa fa-external-link"></i> <? echo langs("Wklej LINKI"); ?></button>
                        </div>
                        <div ng-if="showImages" class="col-md-6 col-sm-12">
                            <button ng-click="addImages()" class="btn btn-block btn-warning"><i class="fa fa-picture-o"></i> <? echo langs("Dodaj obrazek"); ?></button>
                        </div>
                        <div ng-if="showArticle" class="col-md-6 col-sm-12">
                            <button ng-click="addArticle()" class="btn btn-block btn-primary"><i class="fa fa-file-text-o"></i> <? echo langs("Dodaj artykuł"); ?></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                </uib-tab>
                <uib-tab index="2" ng-if="showExercises" heading="<? echo langs("Ćwiczenia"); ?>">
                    
                    <div class="well">
                        <uib-accordion close-others="oneAtATime">
                            <uib-accordion-group is-open="status.open">
                                <uib-accordion-heading>
                                    <span class="numb">I.</span> <? echo langs("Wybierz rodzaj zadania"); ?> <i class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': status.open, 'glyphicon-chevron-right': !status.open}"></i>
                                </uib-accordion-heading>

                                <div class="col-xs-12">
                                    <div class="col-lg-4 col-md-12">
                                        <button class="btn btn-block btn-sm" data-toggle="tooltip" data-placement="top" title="<? echo langs("Do zadania zostaną przypisane 4 przyciski, a uczeń ma wybrać pasującą opcję"); ?>"
                                            ng-click="training.type = 1" ng-class="{ 'btn-warning':training.type === 1,'btn-success':training.type !== 1 }"> <? echo langs("Zadanie z przyciskami ABCD"); ?>
                                        </button>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <button class="btn btn-block btn-sm" data-toggle="tooltip" data-placement="top" title="<? echo langs("Podobne do ABCD lecz odpowiedź będzie musiałabyć wybrana z listy"); ?>"
                                            ng-click="training.type = 2" ng-class="{ 'btn-warning':training.type === 2,'btn-success':training.type !== 2 }"> <? echo langs("Zadanie z rozwijaną LISTĄ"); ?>
                                        </button>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <button class="btn btn-block btn-sm" data-toggle="tooltip" data-placement="top" title="<? echo langs("Uczeń musi wpisać poprawną odpowiedź z klawiatury"); ?>"
                                            ng-click="training.type = 3" ng-class="{ 'btn-warning':training.type === 3,'btn-success':training.type !== 3 }"> <? echo langs("Zadanie z polem TEKSTOWYM"); ?>
                                        </button>
                                    </div>
                                </div>

                            </uib-accordion-group>
                        </uib-accordion>

                        <uib-accordion close-others="oneAtATime">
                            <uib-accordion-group is-open="status.open">
                                <uib-accordion-heading>
                                    <span class="numb">II.</span> <? echo langs("Napisz polecenie"); ?> <i class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': status.open, 'glyphicon-chevron-right': !status.open}"></i>
                                </uib-accordion-heading>

                                <textarea ng-model="training.ask" rows="1" placeholder="<? echo langs("Wpisz treść polecenia..."); ?>" class="form-control"></textarea>

                            </uib-accordion-group>
                        </uib-accordion>

                        <uib-accordion close-others="oneAtATime">
                            <uib-accordion-group is-open="status.open">
                                
                                <uib-accordion-heading>
                                    <span class="numb">III.</span> <? echo langs("Ustal treść zadań i odpowiedzi"); ?> <i class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': status.open, 'glyphicon-chevron-right': !status.open}"></i>
                                </uib-accordion-heading>

                                <div class="alert alert-warning"><? echo langs("<strong>Ważne!</strong> Wstaw 3 kropki (...) tam, gdzie chcesz aby odpowiedział uczeń. Na przykład <strong>(I ... in home yesterday).</strong>"); ?></div>

                                <div class="col-xs-12 cn-answers">
                                    <div class='tab-container'>

                                        <div ng-repeat="task in training.content.exercises" style="margin-bottom:10px">
                                            
                                            <div class="col-xs-12 input-group" data-toggle="tooltip" data-placement="top" title="<? echo langs("Wpisz zdanie po ANG, użyj [...] tam gdzie uczeń będzie wybierał odpowiedź. Kliknij niebieski przycisk i dodaj odpowiedzi. Czerwony przycisk usuwa cały podpunkt."); ?>">
                                                
                                                <span class="input-group-btn">
                                                    <a class="btn btn-number-exercise btn-default" type="button" ng-bind="$index+1"></a>
                                                </span>

                                                <textarea rows="1" ng-model="task.exercise" class="cn-exercise form-control" placeholder="Wpisz zadanie nr. {{$index+1}}"></textarea>
                                                <span class="input-group-btn">
                                                    <button ng-click=" training.content.exercises.splice($index,1) " class="btn btn-danger"><i class="fa fa-times"></i></button>
                                                    <button class="btn btn-info" ng-disabled="!task.exercise" ng-click="isCollapsed = !isCollapsed"><i class="fa fa-book"></i> <? echo langs("dodaj odp."); ?></button>
                                                </span>
                                            </div>

                                            <div uib-collapse="!isCollapsed" class="well col-xs-12">

                                                <div ng-repeat="answer in task.answers" class="col-md-6 col-xs-12">
                                                    <div class="input-group" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknięcie na iknonkę - V - (ptaszka) oznaczy odp. jako poprawną (wymagane)."); ?>">
                                                        <span class="input-group-btn">
                                                            <button ng-click="task.right = answer.value" ng-class="{ 'btn-success': task.right === answer.value && answer.value, 'btn-default': task.right != answer.value || !answer.value }" class="btn btn-true" type="button"><i class="fa fa-check"></i></button>
                                                        </span>
                                                        <textarea rows="1" class="form-control" ng-model="answer.value" placeholder="Wpisz odp. {{$index+1}}"></textarea>
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-danger" ng-click="task.answers.splice($index,1)" type="button"><i class="fa fa-times"></i></button>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="cn-clear clearfix"></div>
                                                
                                                <!-- <div class="col-xs-12 col-md-8"><div class="alert alert-info"><? // echo langs("<strong>WAŻNE!</strong> Potrzebujesz pomocy? Przeczytaj artykuł o zasadach tworzenia zadań:"); ?> <strong><a href="#"><? // echo langs("POMOC"); ?> <i class="fa fa-angle-double-right"></i><a></strong></div></div> -->
                                                
                                                <hr>
                                                <div class="col-xs-12 col-md-12">
                                                    <button ng-click="task.answers.push({})" class="btn btn-success"><i class="fa fa-plus"></i> <? echo langs("DODAJ ODP"); ?></button> 
                                                </div>
                                                <div class="clearfix"></div>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 col-xs-12">
                                            
                                            <hr>
                                            <button data-toggle="tooltip" ng-click="training.content.exercises.push({answers:[{},{}]})" data-placement="top" title="<? echo langs("Kliknij aby dodać kolejne podpunkty do zadania..."); ?>" class="btn pull-right btn-block btn-success btn-add-exercise"><i class="fa fa-plus"></i> <? echo langs("DODAJ WIĘCEJ"); ?></button>
                                        </div>
                                        
                                    </div>
                                </div>

                            </uib-accordion-group>
                        </uib-accordion>
                    </div>
                    
                </uib-tab>
                <uib-tab index="3" ng-if="showWords" heading="<? echo langs("Zwroty"); ?>">
                    
                    <div class="well">

                        <div class="panel panel-default">
                            <div class="panel-heading"><? echo langs("DODAJ WAŻNE SŁOWA LUB ZWROTY, KTÓRYCH UŻYŁEŚ W SZKOLENIU"); ?></div>
                            <div class="panel-body">

                                <div ng-repeat="word in training.dict">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group input-group-sm">
                                            
                                            <span class="input-group-addon">EN</span>
                                            <textarea rows="1" class="form-control" ng-model="word.en" placeholder="<? echo langs("Wpisz po angielsku"); ?>"></textarea>
                                            <span class="input-group-btn">
                                                <button class="btn btn-warning" ng-disabled="!word.en" ng-click="!word.en || recAudio(word)" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by nagrać wymowę."); ?>"><i class="fa fa-microphone"></i></button>
                                            </span>
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" ng-disabled="!word.en" ng-click="!word.en || addWordImage(word)" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by dodać obrazek."); ?>"><i class="fa fa-file-image-o"></i></button>
                                            </span>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group input-group-sm">
                                            
                                            <span class="input-group-addon">PL</span>
                                            <textarea rows="1" class="form-control" ng-model="word.pl" placeholder="<? echo langs("Wpisz po polsku"); ?>"></textarea>
                                            <span class="input-group-btn">
                                                <button class="btn btn-danger" ng-click="training.dict.splice($index,1)" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by usunąć całą pozycję."); ?>"><i class="fa fa-times"></i></button>
                                            </span>
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12 add-next-dict">
                                    <button ng-click="training.dict.push({})" class="btn btn-block btn-success"><i class="fa fa-plus"></i> <? echo langs("NASTĘPNE"); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </uib-tab>
            </uib-tabset>

        </div>

        <hr>
        <button style="margin-bottom:20px;" ng-click="step('prev')" class="btn btn-warning"><i class="fa fa-chevron-left"></i> <? echo langs("WSTECZ"); ?></button>
        <button style="margin-bottom:20px;" ng-click="step('next')" class="btn btn-primary"><? echo langs("DALEJ"); ?> <i class="fa fa-chevron-right"></i></button>
        <button style="margin-bottom:20px;" class="btn gotowe btn-success" ng-disabled="!training.name" ng-click="saveTraining()">
            <i class="fa fa-check"></i> <? echo langs("ZAPISZ I ZAKOŃCZ"); ?>
        </button>
        <div class="clearfix"></div>
    </div>
</div>

<!-- ================================================= -->

<script type="text/javascript">
        
    var _AUDIO_T = [];
    var _AUDIO_D = [];
    initialPipe(); // IMPORTANT !!!
    
    $(".cnClose").click(function() { $('#mode').text('Record'); });
    function changeLabel (arg) { $(arg).find('span').text('Record'); }
    function buttonToggle () { $("#infoAlert").toggle(); }
    
//    function delImage (name,obj) {
//        obj.closest('div').remove();
//        var index = _IMAGES_T.indexOf(name);
//        if (index >= 0) {
//          _IMAGES_T.splice( index, 1 );
//        }
//        console.log(_IMAGES_T);
//    }
//
//    function rebuildImages (arg) { // arg means _IMAGES_T
//        var val = '';
//        for(var i in arg) {
//            val += '<div class="pull-left" style="position:relative;">'+
//                '<button type="button" onclick="delImage(\''+arg[i]+'\',this)" class="btn btn-danger btn-xs" style="position:absolute; right:0px;"><strong>&times;</strong></button>'+
//                '<img src="'+arg[i]+'" style="width:100px; margin:5px;" class="img-thumbnail"></div>';
//        }
//        $('#TPHOTO').html(val);
//    }

</script>

<!-- ================================================= -->

<div class="modal fade" id="myModalRecordAudio" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalRecordAudioLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalRecordAudioLabel"><? echo langs("NAGRYWANIE AUDIO"); ?></h4>
            </div>
            <div class="modal-body">

                <section class="recorder-container">

                    <div class="recorder">
                        <button class="start-recording btn-success" onclick="FWRecorder.record('audio', 'rec.wav'); changeLabel(this);">
                            <img src="audio/images/record.png" alt="Record"> <span id='mode'>Access</span>
                        </button>
                        <div class="level">
                            <div class="progressbar"></div>
                        </div>
                        <button class="stop-recording btn-primary" onclick="FWRecorder.stopRecording('audio');">
                            <img src="audio/images/stop.png" alt="Stop Recording"/> Stop
                        </button>
                        <button class="start-playing btn-warning" onclick="FWRecorder.playBack('audio');" title="Play">
                            <img src="audio/images/play.png" alt="Play"/> Play
                        </button>
                        <div class="upload" style="display: inline-block">
                            <div id="flashcontent"><? echo langs("BŁĄD"); ?></div>
                        </div>
                    </div>
                        
                    <button onclick="buttonToggle();" style="margin-top:10px;" class="btn btn-default"><i class="fa fa-lg fa-info-circle"></i>&nbsp;&nbsp;<? echo langs("PRZECZYTAJ NIM ZACZNIESZ"); ?></button>
                    <div style="display:none;margin-top:10px;" id="infoAlert" class="alert alert-success">
                        
                        <h4><? echo langs("INSTRUKCJA:"); ?></h4>
                        <ol style="font-size:13px;margin-left:20px; text-align:left;">
                            
                            <? echo langs("
                                <li>Wciśnij czerwone kółko i zaakceptuj dostęp do mikrofonu</li>
                                <li>Teraz jeszcze raz kliknij czerwone kółko by uruchomić nagrywanie</li>
                                <li>Powiedz słowo lub zdanie</li>
                                <li>Na potwierdzenie, że wszystko jest OK zobaczysz obok kółeczka w 2 kwadraciku skaczący w górę i w dół poziom głosu</li>
                                <li>Po nagraniu - kliknij kwadracik by dać STOP a potem trójkącik by odsłuchać</li>
                                <li>Jeśli wszystko pójdzie ok, pojawi się obok trójkącika strzałeczka do góry - kliknij, uruchomi się upload na server</li>
                                <li>Aby nagrać jeszcze raz - kliknij ponownie czerwone kółko i mów - potem kwadracik, trójkącik i strzałeczka aż będziesz zadowolony z nagrania...</li>
                                <li>W miarę możliwości po słówku użyj pełnego zdania jako przykład użycia</li>
                            "); ?>
                        </ol>
                    </div>

                    <form id="uploadForm" name="uploadForm" action="audio/upload2.php">
                        <input name="authenticity_token" value="xxxxx" type="hidden">
                        <input name="upload_file[parent_id]" value="1" type="hidden">
                        <input name="format" value="json" type="hidden">
                        <input id="important1" name="word" value="" type="hidden">
                        <input id="important2" name="mode" value="" type="hidden">
                        <input id="important3" name="id" value="" type="hidden">
                    </form>
                </section>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn cnClose btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <? echo langs("Zamknij"); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- ================================================= -->

<div nv-file-drop="" uploader="uploaderFiles" class="modal fade" id="myModalUploadFromHdd" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalUploadFromHddLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalUploadFromHddLabel"><? echo langs("WRZUĆ SZKOLENIE Z DYSKU"); ?></h4>
                <h5>only mp4, ogv or webm</h5>
            </div>
            <div class="modal-body">

                <!-- UPLOADER -->

                <div class="col-xs-12">

                    <div ng-show="uploaderFiles.isHTML5">
                        <div class="well my-drop-zone" nv-file-over="" uploader="uploaderFiles">
                            Przeciągnij i upuść pliki tutaj...
                        </div>
                    </div>
                    <input class="btn btn-default" type="file" nv-file-select="" uploader="uploaderFiles" multiple  /><br/>

                </div>

                <div class="col-xs-12" style="margin-bottom: 40px">

                    <table class="table">
                        <thead>
                            <tr>
                                <th width="50%">File name</th>
                                <th ng-show="uploaderFiles.isHTML5">Size</th>
                                <th ng-show="uploaderFiles.isHTML5">Progress</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in uploaderFiles.queue">
                                <td>
                                    <strong>{{ item.file.name }}</strong>
                                    <div ng-show="uploaderFiles.isHTML5" ng-thumb="{ file: item._file, width: 200 }"></div>
                                </td>
                                <td ng-show="uploaderFiles.isHTML5" nowrap>{{ item.file.size/1024/1024|number:2 }} MB</td>
                                <td ng-show="uploaderFiles.isHTML5">
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
                                <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploaderFiles.progress + '%' }"></div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-s" ng-click="lockSendBtn();uploaderFiles.uploadAll();" ng-disabled="!uploaderFiles.getNotUploadedItems().length">
                            <i class="fa fa-upload" aria-hidden="true"></i> Update all
                        </button>
                        <button type="button" class="btn btn-warning btn-s" ng-click="unlockSendBtn();uploaderFiles.cancelAll();" ng-disabled="!uploaderFiles.isUploading">
                            <i class="fa fa-times" aria-hidden="true"></i> Cancel all
                        </button>
                        <button type="button" class="btn btn-danger btn-s" ng-click="unlockSendBtn();uploaderFiles.clearQueue();" ng-disabled="!uploaderFiles.queue.length">
                            <i class="fa fa-trash-o" aria-hidden="true"></i> Remove all
                        </button>
                    </div>
                </div>

                <!-- UPLOADER -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn cnClose btn-success" ng-disabled="training.content.hdd.length <= 0" data-dismiss="modal"><i class="fa fa-check"></i> <? echo langs("Akceptuje"); ?></button>
                <button type="button" class="btn cnClose btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <? echo langs("Zamknij"); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- ================================================= -->

<div class="modal fade" id="myModalRecordMovie" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalRecordMovieLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalRecordMovieLabel"><? echo langs("NAGRAJ FILMIK"); ?></h4>
            </div>
            <div class="modal-body">

                <div id="movie">
                    <div style="width:100%;" id="hdfvr-content"></div>
                    <div id="name"></div>

                    <button class="btn btn-primary" ng-click="goToLinks()"><i class="fa fa-lg fa-youtube"></i> <? echo langs("Dodaj filmik z YouTube"); ?></button>
                    <button class="btn btn-warning" id="startm" onclick="startm();"><i class="fa fa-lg fa-video-camera"></i> <? echo langs("Kliknij, aby nagrać"); ?></button>
                    <button class="btn btn-danger" style="display:none;" id="newm" onclick="newm();"><i class="fa fa-lg fa-refresh"></i> <? echo langs("Anuluj"); ?></button>
                    <button class="btn btn-danger" style="display:none;" id="delm" onclick="delm();"><i class="fa fa-lg fa-trash-o"></i> <? echo langs("Usuń"); ?></button>
                    <button class="btn btn-success" style="display:none;" id="endm" onclick="endm();"><i class="fa fa-lg fa-floppy-o"></i> <? echo langs("Zakończ i zapisz"); ?></button>
                    <button type="button" class="btn cnClose btn-danger" data-dismiss="modal"><i class="fa fa-lg fa-times"></i> <? echo langs("Zamknij"); ?></button>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================================================= --> 

<div nv-file-drop="" uploader="uploader" class="modal fade" id="myModalAddImages" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalAddImagesLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalAddImagesLabel"><? echo langs("WRZUĆ OBRAZEK Z DYSKU"); ?></h4>
                <h5>only jpg, png, jpeg, bmp or gif</h5>
            </div>
            <div class="modal-body">
                
                <div ng-if="training.content.images.length > 0">
                    <div style="margin-top:10px;" class="alert alert-success"><? echo langs("Zdjęcia już dodane:"); ?></div>
                    <div class="clearfix"></div>

                    <div ng-repeat="img in training.content.images" class="pull-left" style="position:relative;">
                        <button type="button" ng-click="delImage(img)" class="btn btn-danger btn-xs" style="position:absolute; right:0px;"><strong>&times;</strong></button>
                        <img ng-src="{{img}}" style="width:100px; margin:5px;" class="img-thumbnail">
                    </div>

                    <div class="clearfix"></div>
                </div>
                <hr>

                <!-- UPLOADER -->

                <div class="col-xs-12">

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
            <div class="modal-footer">
                <button type="button" class="btn cnClose btn-success" ng-disabled="training.content.images.length <= 0" data-dismiss="modal"><i class="fa fa-check"></i> <? echo langs("Akceptuje"); ?></button>
                <button type="button" class="btn cnClose btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <? echo langs("Zamknij"); ?></button>
            </div>
        </div>
    </div>
</div>


<!-- ================================================= --> 

<div nv-file-drop="" uploader="uploaderWordImage" class="modal fade" id="myModalWordImage" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalWordImageLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalWordImageLabel"><? echo langs("WRZUĆ OBRAZEK Z DYSKU"); ?></h4>
                <h5>only jpg, png, jpeg, bmp or gif</h5>
            </div>
            <div class="modal-body">
                
                <div ng-if="training.dict">
                    <div style="margin-top:10px;" class="alert alert-success"><? echo langs("Zdjęcia już dodane:"); ?></div>
                    <div class="clearfix"></div>

                    <div ng-repeat="item in training.dict" class="pull-left" style="position:relative;">
                        <button ng-if="item.image" type="button" ng-click="delImage(item)" class="btn btn-danger btn-xs" style="position:absolute; right:0px;"><strong>&times;</strong></button>
                        <img ng-if="item.image" ng-src="{{item.image}}" style="width:100px; margin:5px;" class="img-thumbnail">
                    </div>

                    <div class="clearfix"></div>
                </div>
                <hr>

                <!-- UPLOADER -->

                <div class="col-xs-12">

                    <div ng-show="uploaderWordImage.isHTML5">
                        <div class="well my-drop-zone" nv-file-over="" uploader="uploaderWordImage">
                            Przeciągnij i upuść zdjęcie tutaj...
                        </div>
                    </div>
                    <input class="btn btn-default" type="file" nv-file-select="" uploader="uploaderWordImage" /><br/>

                </div>

                <div class="col-xs-12" style="margin-bottom: 40px">

                    <table class="table">
                        <thead>
                            <tr>
                                <th width="50%">File name</th>
                                <th ng-show="uploaderWordImage.isHTML5">Size</th>
                                <th ng-show="uploaderWordImage.isHTML5">Progress</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in uploaderWordImage.queue">
                                <td>
                                    <strong>{{ item.file.name }}</strong>
                                    <div ng-show="uploaderWordImage.isHTML5" ng-thumb="{ file: item._file, width: 200 }"></div>
                                </td>
                                <td ng-show="uploaderWordImage.isHTML5" nowrap>{{ item.file.size/1024/1024|number:2 }} MB</td>
                                <td ng-show="uploaderWordImage.isHTML5">
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
                                <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploaderWordImage.progress + '%' }"></div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-s" ng-click="lockSendBtn();uploaderWordImage.uploadAll();" ng-disabled="!uploaderWordImage.getNotUploadedItems().length">
                            <i class="fa fa-upload" aria-hidden="true"></i> Update all
                        </button>
                        <button type="button" class="btn btn-warning btn-s" ng-click="unlockSendBtn();uploaderWordImage.cancelAll();" ng-disabled="!uploaderWordImage.isUploading">
                            <i class="fa fa-times" aria-hidden="true"></i> Cancel all
                        </button>
                        <button type="button" class="btn btn-danger btn-s" ng-click="unlockSendBtn();uploaderWordImage.clearQueue();" ng-disabled="!uploaderWordImage.queue.length">
                            <i class="fa fa-trash-o" aria-hidden="true"></i> Remove all
                        </button>
                    </div>
                </div>

                <!-- UPLOADER -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn cnClose btn-success" ng-click="saveImage()" data-dismiss="modal"><i class="fa fa-check"></i> <? echo langs("Akceptuje"); ?></button>
                <button type="button" class="btn cnClose btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <? echo langs("Zamknij"); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- ================================================= -->

<div class="modal fade" id="myModalLinks" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLinksLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLinksLabel"><? echo langs("WKLEJ LINKI W POLE TEKSTOWE"); ?></h4>
            </div>
            <div class="modal-body">
                
                <div style="margin-top:10px;" class="alert alert-info"><? echo langs("Jeśli wkleisz więcej linków, umieść je w osobnych liniach."); ?></div>
                <textarea ng-model="training.content.links" rows="5" class="form-control"></textarea>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn cnClose btn-success" data-dismiss="modal"><i class="fa fa-check"></i> <? echo langs("Zatwierdź"); ?></button>
                <button type="button" class="btn cnClose btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <? echo langs("Zamknij"); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- ================================================= -->

<div class="modal fade" id="myModalArticle" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalArticleLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalArticleLabel"><? echo langs("NAPISZ ARTYKUŁ"); ?></h4>
            </div>
            <div class="modal-body">
                
                <div style="margin-top:10px;" class="alert alert-info"><? echo langs("Napisz artykuł wyjaśniający jakąś regułę gramatyczną:"); ?></div>
                <textarea ckeditor="editorOptions" class="form-control" rows="15" ng-model="training.content.article" ng-bind-html="training.content.article | trustAsHtml" cols="80"></textarea>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn cnClose btn-success" data-dismiss="modal"><i class="fa fa-check"></i> <? echo langs("Zatwierdź"); ?></button>
                <button type="button" class="btn cnClose btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <? echo langs("Zamknij"); ?></button>
            </div>
        </div>
    </div>
</div>
