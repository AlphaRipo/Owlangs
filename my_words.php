<?php require_once("ajax/db.php"); ?>

<style type="text/css">
    table {text-align:left;}
    .col-xs-12 { margin-bottom: 10px; }
    table .btn {min-width:35px;}
</style>

<div id="sownik" class="row">
    <div class="navigacja col-xs-12 nopadding">
    <? require_once 'parts/menuWords.php'; ?>
    </div>

    <div ng-if="categorySaved" class="col-xs-12">
        <div style="text-align:left;" class="alert alert-warning"><strong><i class="fa fa-lg fa-smile-o" aria-hidden="true"></i> <? echo langs("Yeah! Zaznaczone przez Ciebie słówka zostały przekopiowane do creatora nowej kategorii,</strong> wystarczy już tylko nadać jej tytuł, krótki opis, poziom dostępu i poziom językowy - potem zwyczajnie zapisz kategorię - pojawi się ona w Twoim słowniku!"); ?></div>
    </div>
    
    <div ng-if="cannot === 1" class="col-xs-12">
        <div style="text-align:left;" class="alert alert-danger">
            <i class="fa fa-lg fa-frown-o" aria-hidden="true"></i> <? echo langs("Ups! Kategoria nie dodana, ponieważ <strong>pakiet FREE może posidać tylko 1 kategorię</strong> ograniczoną do 100 słówek"); ?>
        </div>
    </div>

    <div class="col-xs-12"> 
        <div ng-show="addCategoryPanel" class="panel panel-success">
            <div class="panel-heading"><? echo langs("STWÓRZ NOWĄ KATEGORIĘ SŁOWNIKA"); ?></div>
            <div class="panel-body">

                <div class="cn-item">
                    <div class="col-md-12 col-xs-12">
                        <div class="input-group" ng-class="{'has-error':valid===2,'has-success':valid===1}">
                            <span class="input-group-addon">Title</span>
                            <textarea ng-model="newDict.title" maxlength="100" rows="1" class="form-control" placeholder="<? echo langs("Wpisz po angielsku"); ?>"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12">
                        <div class="input-group" ng-class="{'has-error':valid===2,'has-success':valid===1}">
                            <span class="input-group-addon">Description</span>
                            <textarea ng-model="newDict.description" maxlength="500" rows="1" class="form-control" placeholder="<? echo langs("Wpisz po angielsku"); ?>"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <select ng-model="newDict.lvl" class="form-control" ng-options="lvl.value as lvl.label for lvl in levelList"></select>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <select ng-model="newDict.access" class="form-control" ng-options="access.value as access.label for access in accessList"></select>
                    </div>
                </div>

            </div>    
            <div class="panel-footer">
                <button ng-click="addWords()" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> <? echo langs("DODAJ SŁÓWKA DO TEJ KATEGORII"); ?></button>
                <button ng-disabled="!newDict.words[0].en"
                    mwl-confirm
                    title="<? echo langs("Na pewno zapisać?"); ?>"
                    message="<? echo langs("Wskazówka: Sprawdź czy wszytskie dane takie jak tytuł, opis, poziom dostepu dla innych oraz poziom językowy słówek został ustawiony poprawnie - kliknij zapisz teraz zaby opublikować kategorię..."); ?>"
                    confirm-text="Save now"
                    cancel-text="Save later"
                    on-confirm="saveDict()"
                    on-cancel=""
                    confirm-button-type="warning"
                    cancel-button-type="primary" 
                    class="btn btn-sm btn-success"><i class="fa fa-check"></i> <? echo langs("STWÓRZ I ZAPISZ KATEGORIĘ"); ?>
                </button>
            </div>
        </div>

    </div>

    <div class="col-xs-12">
        <div class="input-group">
            <input id="searchDict" ng-model="search" type="text" class='form-control' placeholder="<? echo langs("Wyszukaj słówko w sowniku..."); ?>">
            <span class="input-group-btn">
                <button class="btn btn-default" id='searchBtn' type="button" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by wyczyścić pole."); ?>" ng-click="clearSearch();"><i class="fa fa-times"></i></button>
                <button class="btn btn-default" id='searchBtn' type="button" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by wyszukać."); ?>"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </div>
    <div class="clearfix"></div>
    <div style="padding-bottom:10px;padding-top:10px;">
        <h3><? echo langs("TABELA KATEGORII SŁÓWEK:"); ?></h3>
    </div>

    <div class="col-xs-12 nopadding"> 

        <table class="table table-striped table-responsive table-hover">
            <tr>
                <th width="40">ID</th>
                <th>Title</th>
                <th>Description</th>
                <th width="100">Details</th>
                <th width="65">Author</th>
                <th>Words</th>
                <!--<th width="90px;"></th>-->
                <th width="90">
                    <button ng-click="addCategoryPanelReverse()" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij aby dodać kategorię!"); ?>" class="btn btn-xs cn-tips btn-block btn-success"><i class="fa fa-plus"></i> add</button>
                </th>
            </tr>

            <tr ng-repeat="dict in dicts | filter : search">
                <td ng-bind="dict.id"></td>
                <td>
                    <textarea ng-show="editDict" maxlength="100" class="form-control" ng-model="dict.title"></textarea>
                    <span ng-show="!editDict" ng-bind="dict.title"></span>
                </td>
                <td>
                    <textarea ng-show="editDict" maxlength="500" class="form-control" ng-model="dict.description"></textarea>
                    <span ng-show="!editDict" ng-bind="dict.description"></span>
                </td>
                <td>
                    <span ng-if="!editDict" ng-bind="( createDate(dict.date) | date:'medium' )"></span>
                    
                    <br ng-if="!editDict">
                    
                    <label ng-if="!editDict" class="label" data-toggle="tooltip" data-placement="top" data-original-title="<? echo langs("poziom trudności"); ?> {{dict.lvl}}" ng-class="{'label-success' : dict.lvl === 'A1' || dict.lvl === 'A2','label-warning' : dict.lvl === 'B1' || dict.lvl === 'B2','label-danger' : dict.lvl === 'C1' || dict.lvl === 'C2'}" ng-bind="dict.lvl"></label>
                    
                    <i ng-if="dict.access === 0 && !editDict" data-toggle="tooltip" data-placement="top" data-original-title="<? echo langs("kategoria słówek publiczna"); ?>" class="fa fa-lg fa-globe"></i>
                    <i ng-if="dict.access === 1 && !editDict" data-toggle="tooltip" data-placement="top" data-original-title="<? echo langs("kategoria słówek tylko dla znajomych"); ?>" class="fa fa-lg fa-users"></i>
                    <i ng-if="dict.access === 2 && !editDict" data-toggle="tooltip" data-placement="top" data-original-title="<? echo langs("kategoria słówek tylko dla VIPów"); ?>" class="fa fa-lg fa-star"></i>
                    <i ng-if="dict.access === 3 && !editDict" data-toggle="tooltip" data-placement="top" data-original-title="<? echo langs("kategoria słówek tylko dla mnie"); ?>" class="fa fa-lg fa-lock"></i>

                    <select ng-if="editDict" ng-model="dict.lvl" class="form-control" ng-options="lvl.value as lvl.label for lvl in levelList"></select>
                    <select ng-if="editDict" ng-model="dict.access" class="form-control" ng-options="access.value as access.label for access in accessList"></select>

                </td>
                <td><a ng-href="/#/user/{{dict.author}}"><img class="img-thumbnail" data-toggle="tooltip" data-placement="top" data-original-title="{{dict.imie}} {{dict.nazwisko}}" ng-src="{{dict.avatar}}" width="40"></a></td>
                <td width="95">
                    <button ng-click="selectDict(dict)" class="btn btn-xs btn-block btn-primary"><i class="fa fa-search" aria-hidden="true"></i> show ({{dict.words.length}})</button>
                </td>
                <td>
                    <button ng-show="dict.author === aboutMe.me" ng-click="editDict = !editDict; dictEdit(editDict,dict);" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij aby edytować kategorię!"); ?>">
                        <i class="fa fa-pencil"></i>
                    </button>
                    
                    <button ng-show="dict.author !== aboutMe.me" data-toggle="tooltip" data-placement="top" title="<? echo langs("Ważne! Możesz edytować kategorię tylko gdy jesteś jej właścicielem."); ?>" class="btn btn-xs btn-default">
                        <i class="fa fa-lock"></i>
                    </button>
                    
                    <button class="btn btn-xs btn-danger"
                        mwl-confirm 
                        title="<? echo langs("Na pewno usunąć?"); ?>" 
                        message="<? echo langs("Wskazówka: Ta kategoria zniknie z Twojego słownika, zawsze będziesz mógł dodać ją ponownie odszukując ją w zakładce cały słownik..."); ?>" 
                        confirm-text="Delete" 
                        cancel-text="Cancel" 
                        on-confirm="delDictMy(dict.id)" 
                        on-cancel="" 
                        confirm-button-type="danger" 
                        cancel-button-type="success"><i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
        </table>
    </div>
</div>

<!-- ================================================= -->

<div ng-controller="dict-words" data-backdrop="static" class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><? echo langs("Słówka w kategorii numer").":"; ?> {{selectedDict.id}}</h4>
            </div>
            <div class="modal-body">

                <div class="col-xs-12"> 
                    <table class="table table-striped table-responsive table-hover">
                        <tr>
                            <th width="30"></th>
                            <th width="40">No.</th>
                            <th>PL</th>
                            <th>EN</th>
                            <th>Example</th>
                            <th width="100">Details</th>
                            <th width="65">Author</th>
                            <th width="90">Options</th>
                        </tr>

                        <tr ng-repeat="word in selectedDict.words | filter : search">

                            <td>
                              
                                <button class="btn btn-xs"
                                    ng-click=" (isAdded(word)) ? delMyDictWord(word) : addMyDictWord(word) "
                                    ng-class="{'btn-success':isAdded(word),'btn-warning':!isAdded(word)}">
                                    <i ng-class="{'fa-square-o':!isAdded(word),'fa-check-square-o':isAdded(word)}" class="fa" aria-hidden="true"></i>
                                </button>

                            </td>
                            <td ng-bind="($index+1)"></td>

                            <td>
                                <span ng-if="!editWord" ng-bind="word.pl"></span>
                                <input type="text" ng-if="editWord" class="form-control" ng-model="word.pl">
                            </td>
                            <td>
                                <span ng-if="!editWord" ng-bind="word.en"></span>
                                <input type="text" ng-if="editWord" class="form-control" ng-model="word.en">
                            </td>
                            <td>
                                <span ng-if="!editWord" ng-bind="word.example"></span>
                                <input type="text" ng-if="editWord" class="form-control" ng-model="word.example">
                            </td>

                            <td>
                                <button class="btn btn-xs btn-default" ng-click="speak(word.en)"><i class="fa fa-volume-up"></i></button>
                                <button class="btn btn-xs btn-default"><i class="fa fa-picture-o"></i></button>
                            </td>
                            <td><a ng-href="/#/user/{{word.author}}"><img class="img-thumbnail" data-toggle="tooltip" data-placement="top" data-original-title="{{word.imie}} {{word.nazwisko}}" ng-src="{{word.avatar}}" width="40"></a></td>
                            <td>
                                
                                <button ng-show="word.author === me" ng-click="editWord = !editWord; saveWord(editWord,word,$index);" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij aby edytować pozycję!"); ?>">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                
                                <button ng-show="word.author !== me" data-toggle="tooltip" data-placement="top" title="<? echo langs("Ważne! Możesz edytować słowo tylko gdy jesteś jego właścicielem."); ?>" class="btn btn-xs btn-default">
                                    <i class="fa fa-lock"></i>
                                </button>
                                
                                <button ng-show="word.author === me" 
                                    mwl-confirm 
                                    title="Na pewno usunąć?" 
                                    message="Wskazówka: Te słówko zniknie na zawsze bez możliwości przywrócenia!" 
                                    confirm-text="Delete" 
                                    cancel-text="Cancel" 
                                    on-confirm="delWord(word,$index)" 
                                    on-cancel="" 
                                    confirm-button-type="danger" 
                                    cancel-button-type="success" 
                                    class="btn btn-xs btn-danger"><i class="fa fa-times"></i>
                                </button>
                                
                                <button ng-show="word.author !== me" data-toggle="tooltip" data-placement="top" title="<? echo langs("Ważne! Możesz usuwać słowo tylko gdy jesteś jego właścicielem."); ?>" class="btn btn-xs btn-default">
                                    <i class="fa fa-lock"></i>
                                </button>
                                
                            </td>
                        </tr>
                    </table>
                </div>
                
                <div class="col-xs-12"> 
                    <div ng-show="addWordsPanel && selectedDict.author === me" class="panel panel-success">
                        <div class="panel-heading"><? echo langs("DODAJ WAŻNE SŁOWA LUB ZWROTY DO TEJ KATEGORII"); ?></div>
                        <div class="panel-body">

                            <div class="cn-item" style="margin-bottom:5px!important" ng-repeat="item in can">
                                <div class="col-md-4 nopadding col-xs-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">EN</span>
                                        <textarea ng-model="can[$index].en" ng-value="true" rows="1" class="en form-control" placeholder="<? echo langs("Wpisz po angielsku"); ?>"></textarea>
                                        <span class="input-group-btn">
                                            <button class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by nagrać wymowę."); ?>"><i class="fa fa-microphone"></i></button>
                                        </span>
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by dodać obrazek."); ?>"><i class="fa fa-file-image-o"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3 nopadding col-xs-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">PL</span>
                                        <textarea ng-model="can[$index].pl" ng-value="true" rows="1" class="pl form-control" placeholder="<? echo langs("Wpisz po polsku"); ?>"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-5 nopadding col-xs-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">Example</span>
                                        <textarea ng-model="can[$index].example" ng-value="true" rows="1" class="example form-control" placeholder="<? echo langs("Użycie słowa w zdaniu"); ?>"></textarea>
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger" ng-click="delItem(can[$index])" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by usunąć całą pozycję."); ?>"><i class="fa fa-times"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </div>    
                        <div class="panel-footer">
                            <div class="col-xs-12">
                                <div ng-if="cannot === 1" style="width:100%;margin-bottom:0px;" class="alert alert-danger">
                                    <i class="fa fa-lg fa-frown-o" aria-hidden="true"></i> <? echo langs("Ups! <strong>Nie możesz zapisać więcej niż 100 słówek na koncie freemium,</strong> należy rozszerzyć pakiet do konta premium (VIP)"); ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 nopadding">
                                <div class="col-md-6 col-xs-12">
                                    <button ng-click="saveWords()" class="btn btn-block btn-sm btn-warning"><i class="fa fa-check"></i> <? echo langs("ZAPISZ"); ?></button>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <button ng-click="addItem()" class="btn btn-block btn-sm btn-success"><i class="fa fa-plus"></i> <? echo langs("NASTĘPNE"); ?></button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="clearfix"></div>
            
            <div class="modal-footer">
                <button type="button" 
                    mwl-confirm
                    title="<? echo langs('Na pewno zapisać?'); ?>"
                    message="<? echo langs('Wskazówka: Czy wiesz, że możesz dodać więcej słów nawet z innych grup i zatwierdzić tylko raz na samym końcu?! Czy na pewno chcesz dodać słówka teraz, czy wolisz poszukać jeszcze w innych kategoriach?'); ?>"
                    confirm-text="Save now"
                    cancel-text="Save later"
                    on-confirm="saveInMyDict(wordsToMyDict)"
                    on-cancel=""
                    confirm-button-type="warning"
                    cancel-button-type="primary"
                    ng-disabled="wordsToMyDict.length === 0" class="pull-left btn cn-tips btn-primary"><i class="fa fa-files-o" aria-hidden="true"></i> Copy only selected items to my dict ({{wordsToMyDict.length}})</button>
                <button ng-disabled="selectedDict.author !== me" type="button" ng-click="addWordsPanel =! addWordsPanel" class="btn cn-tips btn-success"><i class="fa fa-plus"></i> add more words</button>
                <button type="button" class="btn cnClose btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <? echo langs("Zamknij"); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- ================================================= -->

<div ng-controller="create-dict" data-backdrop="static" class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><? echo langs("Dodaj słówka do nowej kategorii"); ?></h4>
            </div>
            <div class="modal-body">

                <div class="col-xs-12"> 
                    <table class="table table-striped table-responsive table-hover">
                        <tr>
                            <th width="40">No.</th>
                            <th>PL</th>
                            <th>EN</th>
                            <th>Example</th>
                            <th width="100">Details</th>
                            <th width="65">Author</th>
                            <th width="90">Options</th>
                        </tr>

                        <tr ng-repeat="word in newDictWords | filter : search">

                            <td ng-bind="($index+1)"></td>

                            <td>
                                <span ng-if="!editWord" ng-bind="word.pl"></span>
                                <input type="text" ng-if="editWord" class="form-control" ng-model="word.pl">
                            </td>
                            <td>
                                <span ng-if="!editWord" ng-bind="word.en"></span>
                                <input type="text" ng-if="editWord" class="form-control" ng-model="word.en">
                            </td>
                            <td>
                                <span ng-if="!editWord" ng-bind="word.example"></span>
                                <input type="text" ng-if="editWord" class="form-control" ng-model="word.example">
                            </td>

                            <td>
                                <button class="btn btn-xs btn-default" ng-click="speak(word.en)"><i class="fa fa-volume-up"></i></button>
                                <button class="btn btn-xs btn-default"><i class="fa fa-picture-o"></i></button>
                            </td>
                            <td><a ng-href="/#/user/{{word.author}}"><img class="img-thumbnail" data-toggle="tooltip" data-placement="top" data-original-title="{{word.imie}} {{word.nazwisko}}" ng-src="{{word.avatar}}" width="40"></a></td>
                            <td>
                                <button ng-show="word.author === myId" ng-click="editWord = !editWord" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij aby edytować pozycję!"); ?>"><i class="fa fa-pencil"></i></button>
                                <button ng-show="word.author !== myId" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="<? echo langs("Nie możesz edytować tej pozycji, nie jesteś jej autorem!"); ?>"><i class="fa fa-lock"></i></button>
                                <button ng-show="word.author === myId && wordsToMyDict.length === 0" ng-click="delWord(word,$index)" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij aby usunąć tą pozycję!"); ?>"><i class="fa fa-times"></i></button>
                                <button ng-show="wordsToMyDict.length !== 0" ng-click="delMyDictWord(word)" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij aby usunąć tą pozycję z tej listy!"); ?>"><i class="fa fa-times"></i></button>
                                <button ng-show="word.author !== myId && wordsToMyDict.length === 0" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="<? echo langs("Nie możesz usunąć tej pozycji, nie jesteś jej autorem!"); ?>"><i class="fa fa-lock"></i></button>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <div class="col-xs-12"> 
                    <div class="panel panel-success">
                        <div class="panel-heading"><? echo langs("DODAJ WAŻNE SŁOWA LUB ZWROTY DO TEJ KATEGORII"); ?></div>
                        <div class="panel-body">

                            <div class="cn-item" style="margin-bottom:5px!important" ng-repeat="item in can">
                                <div class="col-md-4 nopadding col-xs-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">EN</span>
                                        <textarea ng-model="can[$index].en" ng-value="true" rows="1" class="en form-control" placeholder="<? echo langs("Wpisz po angielsku"); ?>"></textarea>
                                        <span class="input-group-btn">
                                            <button class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by nagrać wymowę."); ?>"><i class="fa fa-microphone"></i></button>
                                        </span>
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by dodać obrazek."); ?>"><i class="fa fa-file-image-o"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3 nopadding col-xs-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">PL</span>
                                        <textarea ng-model="can[$index].pl" ng-value="true" rows="1" class="pl form-control" placeholder="<? echo langs("Wpisz po polsku"); ?>"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-5 nopadding col-xs-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon">Example</span>
                                        <textarea ng-model="can[$index].example" ng-value="true" rows="1" class="example form-control" placeholder="<? echo langs("Użycie słowa w zdaniu"); ?>"></textarea>
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger" ng-click="delItem(can[$index])" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by usunąć całą pozycję."); ?>"><i class="fa fa-times"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </div>    
                        <div class="panel-footer">
                            <div class="col-xs-12">
                                <div ng-if="cannot === 1" style="width:100%;margin-bottom:0px;" class="alert alert-danger"><i class="fa fa-lg fa-frown-o" aria-hidden="true"></i> <? echo langs("Ups! <strong>Nie możesz zapisać więcej niż 100 słówek na koncie freemium,</strong> należy rozszerzyć pakiet do konta premium (VIP)"); ?></div>
                            </div>
                            <div class="col-md-6 col-xs-12 nopadding">
                                <div class="col-md-6 col-xs-12">
                                    <button ng-click="saveWords()" class="btn btn-block btn-sm btn-warning"><i class="fa fa-check"></i> <? echo langs("ZAPISZ"); ?></button>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <button ng-click="addItem()" class="btn btn-block btn-sm btn-success"><i class="fa fa-plus"></i> <? echo langs("NASTĘPNE"); ?></button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div style="display:none;" class="alert alert-success"><? echo langs("Ok, udało się zapisać słowa! :)"); ?></div>
                </div>

            </div>
            <div class="clearfix"></div>
            
            <div class="modal-footer">
                <button type="button" class="btn cnClose btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <? echo langs("Zamknij"); ?></button>
            </div>
        </div>
    </div>
</div>