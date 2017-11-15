<?php $rightOff = true; require_once("ajax/db.php"); ?>

    <style type="text/css">
        table {text-align:left;}
        .col-md-6, .col-xs-12 { padding-left: 5px; padding-right: 5px; }
        .col-xs-12 { margin-bottom: 10px; }
        .btn {min-width:35px;}
    </style>

    <div id="sownik" class="row">

        <div style="padding-top:20px!important;" class="col-xs-12 nopadding">
            <div class="input-group">
                <input id="searchDict" ng-model="search" type="text" class='form-control' placeholder="<? echo langs("Wyszukaj frazę w bazie..."); ?>">
                <span class="input-group-btn">
                    <a class="btn btn-default" id='searchBtn' type="button" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by wyczyścić pole."); ?>" ng-click="clearSearch();"><i class="fa fa-times"></i></a>
                    <a class="btn btn-default" id='searchBtn' type="button" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by wyszukać."); ?>"><i class="fa fa-search"></i></a>
                </span>
            </div>
        </div>
        
        <div class="clearfix"></div>
        <div style="padding-bottom:10px;padding-top:10px;">
            <h3><? echo langs("TŁUMACZENIE PORTALU:"); ?></h3>
        </div>

        <div id="ekran_kursow" class="col-xs-12 nopadding"> 

            <table class="table table-striped">
                <tr>
                    <th width="5%">NR</th>
                    <th width="45%">PL</th>
                    <th width="45%">EN</th>
                    <th width="5%"></th>
                </tr>

                <tr ng-repeat="word in words | filter : search">
                    <td>{{word.id}}</td>
                    <td ng-if="!edit">{{word.pl}}</td>
                    <td ng-if="edit"><textarea onfocus="autoSizeText();" type="text" class="form-control" ng-model="word.pl"></textarea></td>

                    <td ng-if="!edit">{{word.en}}</td>
                    <td ng-if="edit"><textarea onfocus="autoSizeText();" type="text" class="form-control" ng-model="word.en"></textarea></td>

                    <td>
                        <a ng-show="word.id_my !== word.who" class="btn btn-xs btn-default"><i class="fa fa-lock"></i></a>
                        <a ng-show="word.id_my === word.who" ng-click="saveWord(edit,word); edit = !edit;" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij aby edytować słówko!"); ?>"><i class="fa fa-pencil"></i></a>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="clearfix"></div>
        <div style="padding-bottom:10px;padding-top:10px;">
            <h3>PRIVACY POLICY</h3>
        </div>
        
        <textarea ckeditor="editorOptions" class="form-control" rows="5" cols="80"
            ng-model="articles.privacyPolicy" 
            ng-bind-html="articles.privacyPolicy | trustAsHtml">
        </textarea>
        
        <button style="margin-top:10px;" class="btn btn-lg btn-danger" ng-click="saveArticle(articles.privacyPolicy,1)"><i class="fa fa-save"></i> ZAPISZ</button>
        
        <div class="clearfix"></div>
        <div style="padding-bottom:10px;padding-top:10px;">
            <h3>TERMS AND CONDITIONS</h3>
        </div>
        
        <textarea ckeditor="editorOptions" class="form-control" rows="5" cols="80"
            ng-model="articles.termsAndConditions" 
            ng-bind-html="articles.termsAndConditions | trustAsHtml">
        </textarea>
        
        <button style="margin-top:10px;" class="btn btn-lg btn-danger" ng-click="saveArticle(articles.termsAndConditions,2)"><i class="fa fa-save"></i> ZAPISZ</button>
        
    </div>
    