<?php require_once("ajax/db.php"); ?>

    <style type="text/css">
        .top6{margin-top: 6px;}
        .nv-file-over { border: dotted 3px red; }
        .my-drop-zone { border: dotted 3px lightgray; }
        .another-file-over-class { border: dotted 3px green; }
    </style>

    <div class="col-xs-12" nv-file-drop="" uploader="uploader">

        <div style="margin-top:20px"></div>
        
        <?php if(isset($_SESSION['payLane'])) { ?>
        <div ng-if="paymentSuccess" class="col-xs-12 well">
                <div class="alert alert-success" ng-init="paid()"><i class="fa fa-lg fa-smile-o"></i> <? echo langs("Yeah! Twoja płatność została przyjęta, witamy w gronie użytkowników VIP!"); ?></div>
            </div>
        <?php } ?>

        <div class="col-xs-12 well" ng-if=" aboutUser.id === aboutMe.id ">
            
            <div class="col-xs-6">
                <button class="btn btn-block btn-warning" ng-click=" setContext('PROFILE') " data-toggle="modal" data-target="#uploadImageModal">
                    <i class="fa fa-picture-o" aria-hidden="true"></i> <? echo langs("Dodaj / Zmień zdjęcie profilowe"); ?>
                </button>
            </div>
            <div class="col-xs-6">
                <button class="btn btn-block btn-warning" ng-click=" setContext('BACKGROUND') " data-toggle="modal" data-target="#uploadImageModal">
                    <i class="fa fa-picture-o" aria-hidden="true"></i> <? echo langs("Dodaj / Zmień zdjęcie w tle"); ?>
                </button>
            </div>
            <div class="col-xs-6">
                <button class="btn btn-block btn-primary"
                    mwl-confirm
                    title="Na pewno wykonać?"
                    message="Wskazówka: Twoje zdjęcie profilowe zostanie przywrócone do domyślnego..."
                    confirm-text="Yes"
                    cancel-text="No"
                    on-confirm="resetImages('PROFILE')"
                    on-cancel=""
                    confirm-button-type="success"
                    cancel-button-type="danger">
                    <i class="fa fa-trash-o" aria-hidden="true"></i> <? echo langs("Ustaw domyślne zdjęcie profilowe"); ?>
                </button>
            </div>
            <div class="col-xs-6">
                <button class="btn btn-block btn-primary"
                    mwl-confirm
                    title="Na pewno wykonać?"
                    message="Wskazówka: Twoje zdjęcie w tle zostanie przywrócone do domyślnego..."
                    confirm-text="Yes"
                    cancel-text="No"
                    on-confirm="resetImages('BACKGROUND')"
                    on-cancel=""
                    confirm-button-type="success"
                    cancel-button-type="danger">
                    <i class="fa fa-trash-o" aria-hidden="true"></i> <? echo langs("Ustaw domyślne zdjęcie w tle"); ?>
                </button>
            </div>

        </div>
        <div class="col-xs-12 well">

            <div class="imie col-xs-12">
                <div class="col-xs-3 nopadding">
                    <p><? echo langs("Imię i nazwisko"); ?></p>
                </div>
                <div class="col-xs-9 nopadding">

                    <div class="col-xs-6"><input ng-disabled=" aboutUser.id !== aboutMe.id " ng-model="aboutUser.imie" class="form-control" placeholder="<? echo langs("Podaj swoje imię"); ?>"/></div>
                    <div class="col-xs-6"><input ng-disabled=" aboutUser.id !== aboutMe.id " ng-model="aboutUser.nazwisko" class="form-control" placeholder="<? echo langs("Podaj swoje nazwisko"); ?>"/></div>
                    
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="imie col-xs-12" style="margin-top:10px;">
                <div class="col-xs-3 nopadding">
                    <p><? echo langs("Skype"); ?></p>
                </div>
                <div class="col-xs-9 nopadding">

                    <div class="col-xs-12">
                        <input class="form-control" ng-disabled=" aboutUser.id !== aboutMe.id " ng-model="aboutUser.skype" placeholder="<? echo langs("Podaj login skype"); ?>"/>
                    </div>

                </div>
                <div class="clearfix"></div>
            </div>

            <div class="imie col-xs-12" style="margin-top:10px;">
                <div class="col-xs-3 nopadding">
                    <p><? echo langs("E-mail"); ?></p>
                </div>
                <div class="col-xs-9 nopadding">

                    <div class="col-xs-12">
                        <input class="form-control" ng-disabled=" aboutUser.id !== aboutMe.id " ng-model="aboutUser.email" placeholder="<? echo langs("Podaj adres e-mail"); ?>"/>
                    </div>

                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-xs-12" style="margin-top:10px;">
                <div class="col-xs-3 nopadding">
                    <p><? echo langs("Wymowa w sowniku"); ?></p>
                </div>
                <div class="col-xs-9 nopadding">
                    <div class="col-xs-12 btn-group">
                        
                        <button style="text-transform: initial" ng-click="pronunciation = englishMode({ name: 'UK English Female', id: 1 })"
                           ng-class="{ 'active btn-primary': pronunciation.id === 1, 'btn-default': pronunciation.id !== 1 }" class="btn"><i class="fa fa-female" aria-hidden="true"></i> BrEN (Female)</button>

                        <button style="text-transform: initial" ng-click="pronunciation = englishMode({ name: 'UK English Male', id: 2 })"
                           ng-class="{ 'active btn-primary': pronunciation.id === 2, 'btn-default': pronunciation.id !== 2 }" class="btn"><i class="fa fa-male" aria-hidden="true"></i> BrEN (Male)</button>

                        <button style="text-transform: initial" ng-click="pronunciation = englishMode({ name: 'US English Female', id: 3 })"
                           ng-class="{ 'active btn-primary': pronunciation.id === 3, 'btn-default': pronunciation.id !== 3 }" class="btn"><i class="fa fa-female" aria-hidden="true"></i> AmEN (Female)</button>

                        <!-- <button ng-click="pronunciation = englishMode({ name: 'US English Male', id: 4 })"
                           ng-class="{ 'active btn-primary': pronunciation.id === 4, 'btn-default': pronunciation.id !== 4 }" class="btn"><i class="fa fa-male" aria-hidden="true"></i> US Male</button> -->
                        
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="poziom col-xs-12" style="margin-top:10px;">
                <div class="col-xs-3 nopadding">
                    <p ng-bind="( '<? echo langs("Twój poziom językowy"); ?>: ' + aboutUser.lvl_ang )"></p>
                </div>
                <div class="col-xs-9 nopadding">
                    <div class="col-xs-12 btn-group">

                        <button ng-click=" (aboutUser.id === aboutMe.id) ? setLvl('A1') : false "
                           ng-if=" aboutUser.id === aboutMe.id || (aboutUser.lvl_ang === 'A1' && aboutUser.id !== aboutMe.id) "
                           ng-disabled=" aboutUser.id !== aboutMe.id "
                           ng-class="{'active btn-primary':aboutUser.lvl_ang === 'A1','btn-success':aboutUser.lvl_ang !== 'A1'}" class="btn"><i class="fa fa-star-o" aria-hidden="true"></i> A1</button>
                           
                        <button ng-click=" (aboutUser.id === aboutMe.id) ? setLvl('A2') : false "
                           ng-if=" aboutUser.id === aboutMe.id || (aboutUser.lvl_ang === 'A2' && aboutUser.id !== aboutMe.id) "
                           ng-disabled=" aboutUser.id !== aboutMe.id "
                           ng-class="{'active btn-primary':aboutUser.lvl_ang === 'A2','btn-success':aboutUser.lvl_ang !== 'A2'}" class="btn"><i class="fa fa-star-o" aria-hidden="true"></i> A2</button>

                        <button ng-click=" (aboutUser.id === aboutMe.id) ? setLvl('B1') : false "
                           ng-if=" aboutUser.id === aboutMe.id || (aboutUser.lvl_ang === 'B1' && aboutUser.id !== aboutMe.id) "
                           ng-disabled=" aboutUser.id !== aboutMe.id "
                           ng-class="{'active btn-primary':aboutUser.lvl_ang === 'B1','btn-warning':aboutUser.lvl_ang !== 'B1'}" class="btn"><i class="fa fa-star-half-o" aria-hidden="true"></i> B1</button>
                           
                        <button ng-click=" (aboutUser.id === aboutMe.id) ? setLvl('B2') : false "
                           ng-if=" aboutUser.id === aboutMe.id || (aboutUser.lvl_ang === 'B2' && aboutUser.id !== aboutMe.id) "
                           ng-disabled=" aboutUser.id !== aboutMe.id "
                           ng-class="{'active btn-primary':aboutUser.lvl_ang === 'B2','btn-warning':aboutUser.lvl_ang !== 'B2'}" class="btn"><i class="fa fa-star-half-o" aria-hidden="true"></i> B2</button>
                        
                        <button ng-click=" (aboutUser.id === aboutMe.id) ? setLvl('C1') : false "
                           ng-if=" aboutUser.id === aboutMe.id || (aboutUser.lvl_ang === 'C1' && aboutUser.id !== aboutMe.id) "
                           ng-disabled=" aboutUser.id !== aboutMe.id "
                           ng-class="{'active btn-primary':aboutUser.lvl_ang === 'C1','btn-danger':aboutUser.lvl_ang !== 'C1'}" class="btn"><i class="fa fa-star" aria-hidden="true"></i> C1</button>
                           
                        <button ng-click=" (aboutUser.id === aboutMe.id) ? setLvl('C2') : false "
                           ng-if=" aboutUser.id === aboutMe.id || (aboutUser.lvl_ang === 'C2' && aboutUser.id !== aboutMe.id) "
                           ng-disabled=" aboutUser.id !== aboutMe.id "
                           ng-class="{'active btn-primary':aboutUser.lvl_ang === 'C2','btn-danger':aboutUser.lvl_ang !== 'C2'}" class="btn"><i class="fa fa-star" aria-hidden="true"></i> C2</button>
                        
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            
        </div>
        <div class="col-xs-12 well" ng-if=" aboutUser.about || aboutUser.id === aboutMe.id">
            
            <h4 ng-if=" aboutUser.id === aboutMe.id "><? echo langs("NAPISZ COŚ O SOBIE (max 500 znaków)"); ?>:</h4>
            
            <textarea ckeditor="editorOptions"
                ng-if=" aboutUser.id === aboutMe.id " class="form-control"
                ng-disabled=" aboutUser.id !== aboutMe.id "
                ng-model="aboutUser.about" rows="5" cols="80"
                ng-bind-html="aboutUser.about | trustAsHtml">
            </textarea>
            
            <h4><? echo langs("PARĘ SŁÓW O MNIE:"); ?></h4>
            <div style="text-align:justify" ng-bind-html="aboutUser.about | trustAsHtml"></div>
            
        </div>

        <div class="col-xs-12 nopadding" ng-if=" aboutUser.id === aboutMe.id ">
            <div class="panel panel-default">
                <div class="panel-body">
                    <? echo langs("Przejdź na VIP by wygenerować link i zarabiać w programie partnerskim"); ?>
                </div>
                <div class="panel-footer">

                    <div class="col-xs-4 nopadding">
                        <p><? echo langs("Twoja podstrona na owlangs"); ?>:</p>
                    </div>
                    <div class="col-xs-4 nopadding">
                        <input maxlength="30" style="text-align:right;" ng-disabled=" aboutUser.id !== aboutMe.id " ng-model="aboutUser.www" placeholder="<? echo langs("sprawdź swoją nazwę"); ?>" class="top6 form-control">
                    </div>
                    <div class="col-xs-2 nopadding">
                        <p>.owlangs.com</p>
                    </div>
                    <div class="col-xs-2 nopadding">
                        <button ng-disabled=" aboutUser.id !== aboutMe.id " ng-click="checkDomain()" class="btn top6 btn-info"><i class="fa fa-search"></i> <? echo langs("Sprawdź"); ?></button>
                    </div>

                    <div class="clearfix"></div>
                    
                    <form id="payline" action="https://secure.paylane.com/order/cart.html" method="post">

                        <input type="hidden" name="amount" value="29.00" />
                        <input type="hidden" name="currency" value="EUR" />

                        <input type="hidden" name="merchant_id" value="newfuture" />
                        <input type="hidden" name="description" value="A1" />
                        <input type="hidden" name="transaction_description" value="access for 31 days to owlangs.com" />
                        <input type="hidden" name="transaction_type" value="S" />

                        <input type="hidden" name="back_url" value="http://owlangs.com/profile/{{aboutMe.id}}" />
                        <input type="hidden" name="language" value="en" />
                        <input type="hidden" name="hash" value="<? echo SHA1("tru7lu7s|A1|29.00|EUR|S"); ?>" />

                    </form>
                    <div class="clearfix"></div>

                </div>
            </div>
        </div>
        
        <div class="col-xs-12">
            
            <div ng-if=" saved " class="alert alert-success"><i class="fa fa-check" aria-hidden="true"></i> <? echo langs('Zamiany zostały zapisane pomyślnie'); ?></div>
            <div ng-if=" registred == 'updated' " class="alert alert-success"><i class="fa fa-check" aria-hidden="true"></i> <? echo langs('Domena została zarejestrowana! Możesz jej używać do celów promocyjnych!'); ?></div>
            <div ng-if=" registred == 'found' " class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <? echo langs('Ta domena jest już zajęta - spróbuj inną nazwę...'); ?></div>
            <div ng-if=" checked == 'exist' " class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <? echo langs('Ta domena jest już zajęta - spróbuj inną nazwę...'); ?></div>
            
            <div ng-if=" checked == 'empty' && aboutMe.vip <= 0" class="alert alert-info">
                
                <i class="fa fa-check" aria-hidden="true"></i> <? echo langs('Ta domena jest wolna - można ją zarejestrować...'); ?>
                <button ng-click="sendForm2PayLine()" class="btn btn-success pull-right"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <? echo langs("Zapłać z PayLine i zarejestruj subdomenę"); ?></button>
                <div class="clearfix"></div>
            
            </div>
            <div ng-if=" checked == 'empty' && aboutMe.vip > 0" class="alert alert-info">
                
                <i class="fa fa-check" aria-hidden="true"></i> <? echo langs('Ta domena jest wolna - można ją zarejestrować...'); ?>
                <button ng-click="registerDomain()" class="btn btn-success pull-right"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <? echo langs("Zarejestruj subdomenę"); ?></button>
                <div class="clearfix"></div>
            
            </div>
        
        </div>
        <button ng-if=" aboutUser.id === aboutMe.id " class="btn btn-warning btn-lg" ng-click="saveProfileData()"><i class="fa fa-floppy-o" aria-hidden="true"></i> <? echo langs("Zapisz zmiany w profilu"); ?></button>
    
    </div>

<!-- Modal -->
<div class="modal fade" data-backdrop="static" id="uploadImageModal" tabindex="-1" role="dialog" aria-labelledby="uploadImageModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="uploadImageModalLabel">Dodaj zdjęcie / zdjęcia:</h4>
            </div>
            <div class="modal-body">
          
                <!-- UPLOADER -->

                <div class="col-xs-12">

                    <div ng-show="uploader.isHTML5">
                        <div class="well my-drop-zone" nv-file-over="" uploader="uploader">
                            Przeciągnij i upuść zdjęcie tutaj...
                        </div>
                    </div>
                    <input class="btn btn-default" type="file" nv-file-select="" uploader="uploader" /><br/>

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
                                    <button type="button" class="btn btn-warning btn-xs" ng-click="lockSendBtn();item.cancel();" ng-disabled="!item.isUploading">
                                        <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                    </button>
                                    <button type="button" class="btn btn-danger btn-xs" ng-click="lockSendBtn();item.remove();">
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
                        <button type="button" class="btn btn-warning btn-s" ng-click="lockSendBtn();uploader.cancelAll();" ng-disabled="!uploader.isUploading">
                            <i class="fa fa-times" aria-hidden="true"></i> Cancel all
                        </button>
                        <button type="button" class="btn btn-danger btn-s" ng-click="lockSendBtn();uploader.clearQueue();" ng-disabled="!uploader.queue.length">
                            <i class="fa fa-trash-o" aria-hidden="true"></i> Remove all
                        </button>
                    </div>
                </div>

                <!-- UPLOADER -->
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                <button type="button" ng-click="saveImage()" ng-disabled=" (profileImage.length <= 0 || backgroundImage.length <= 0) && lock " class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> Save changes</button>
            </div>
        </div>
    </div>
</div>