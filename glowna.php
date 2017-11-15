<? require_once("ajax/db.php"); ?>

<style type="text/css">
    .input-group-addon {
        background-color: initial!important;
        border: none!important;
    }
    .input-group-addon {
        vertical-align: top;
    }
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
    .topLine { border-top: 1px solid #efefef; margin-top: 20px; margin-bottom: 10px; }
    .cn-left { text-align: left; }
</style>

<div nv-file-drop="" uploader="uploader" style='background-color:#f5f5f5;border-bottom: 1px solid #ddd;min-height:130px;padding-bottom:20px;padding-top:20px;' class="col-md-12">
    <div class="col-lg-10 col-md-12">

        <div class="alert alert-danger" ng-if="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Musisz wpisać treść aby dodać post</div>
        <textarea style="min-height:61px;height:61px;" maxlength="1000" ng-model="post" rows="2" class="form-control" type="text" placeholder="<? echo langs("Potrzebujesz pomocy społeczności? Opisz swój problem i opublikuj...!"); ?>"></textarea>
    
    </div>
    <div class="col-lg-2 nopadding col-md-12">
        <div class="btn-group">
            <button ng-click="addPost(post)" class="btn btn-danger"><i class="fa fa-pencil-square-o fa-lg"></i><br><? echo langs("opublikuj"); ?></button>
            <button type="button" class="btn btn-area btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i ng-init=" faIcon = 'fa-globe' " class="fa fa-lg {{faIcon}}"></i><span class="text"><br></span><span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="hand" ng-click=" faIcon = 'fa-globe'; setAccess(0); "><i class="fa fa-lg fa-globe"></i><span class="text">&nbsp;&nbsp;<? echo langs("Publicznie"); ?></span></a></li>
                <li><a class="hand" ng-click=" faIcon = 'fa-users'; setAccess(1); "><i class="fa fa-lg fa-users"></i><span class="text">&nbsp;&nbsp;<? echo langs("Znajomi"); ?></span></a></li>
                <li><a class="hand" ng-click=" faIcon = 'fa-star'; setAccess(2); "><i class="fa fa-lg fa-star"></i><span class="text">&nbsp;&nbsp;<? echo langs("VIP"); ?></span></a></li>
                <li role="separator" class="divider"></li>
                <li><a class="hand" ng-click=" faIcon = 'fa-lock'; setAccess(3); "><i class="fa fa-lg fa-lock"></i><span class="text">&nbsp;&nbsp;<? echo langs("Tylko ja"); ?></span></a></li>
            </ul>
        </div>
    </div>
                        
    <div class="col-lg-12 col-md-12">

        <button class="btn pull-left btn-default" ng-click="attach = !attach">
            <strong><i class="fa fa-lg" ng-class="{'fa-angle-double-down':!attach,'fa-angle-double-up':attach}" aria-hidden="true"></i> załącz plik / szkolenie / słownik</strong>
        </button>
        <div class="clearfix"></div>

        <div ng-show="attach">

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

            <div class="clearfix"></div>

            <hr>

            <div>
                <h4><? echo langs("Załącz słówka do postu"); ?></h4>
                <select class="form-control" ng-model="selectedDict" ng-options="dict as (dict.title+' ('+dict.description+')') for dict in dicts track by dict.title"></select>
            </div>
            <div>
                <h4><? echo langs("Załącz szkolenie do postu"); ?></h4>
                <select class="form-control" ng-model="selectedTraining" ng-options="training as (training.name) group by training.date for training in trainings track by training.name"></select>
            </div>
        </div>

    </div>
</div>

<div class="clearfix"></div>

<!-- TABLICA -->

<div style="margin-top:20px;">

    <button ng-show="postId" ng-click=" postId = '' " class="btn btn-success"><i class="fa fa-arrow-left" aria-hidden="true"></i> Pokaż wszystkie posty</button>

    <div id="{{item.id}}" style="margin:30px" ng-class="{ 'panel-default' : item.vip === 1, 'panel-default' : item.vip !== 1 }" class="panel" ng-repeat="item in items | filter : getFilterPart1(postId) : getFilterPart2(postId) | orderBy : orderByColumn : orderDesc">

        <div class="panel-heading">
            <div class="pull-left" style="text-align:left;">

                <a ng-href="/#/user/{{item.kto}}" >
                    <img ng-src="{{item.avatar}}" width="50" style="margin-right:10px;border-radius:30px;border:solid 2px #F7941E;" /><strong ng-bind="(item.imie) +' '+ (item.nazwisko)"></strong>
                </a>
                <span class="label label-warning">VIP</span>
                <span class="label" ng-class="{ 'label-success' : item.lvl_ang === 'A1' || item.lvl_ang === 'A2','label-warning' : item.lvl_ang === 'B1' || item.lvl_ang === 'B2','label-danger' : item.lvl_ang === 'C1' || item.lvl_ang === 'C2' }" ng-bind="item.lvl_ang"></span>
                <!--<span class="label label-danger">Level: 50</span>-->

                &nbsp;<a class="btn btn-xs btn-default" style="color:#8AC007" href="skype:{{item.skype}}?call&video=true"><i class="fa fa-2x fa-skype"></i></a>&nbsp;  
                <span style="margin-left:10px;color:#aaa;"><i class="fa fa-lg fa-clock-o"></i> <span ng-bind="(createDate(item.data) | date : 'medium')"></span></span>
                <span style="margin-left:10px;color:#aaa;">
                    <i ng-if="item.reach === 0" data-toggle="tooltip" data-placement="top" data-original-title="<? echo langs("post publiczny"); ?>" class="fa fa-lg fa-globe"></i>
                    <i ng-if="item.reach === 1" data-toggle="tooltip" data-placement="top" data-original-title="<? echo langs("post dla znajomych"); ?>" class="fa fa-lg fa-users"></i>
                    <i ng-if="item.reach === 2" data-toggle="tooltip" data-placement="top" data-original-title="<? echo langs("post dla VIPów"); ?>" class="fa fa-lg fa-star"></i>
                    <i ng-if="item.reach === 3" data-toggle="tooltip" data-placement="top" data-original-title="<? echo langs("post tylko dla mnie"); ?>" class="fa fa-lg fa-lock"></i>
                </span>
                <br>

            </div>

            <div ng-if="item.kto === aboutMe.id" class="pull-right">

                <div class="btn-group">
                    <button type="button" ng-class="{ 'btn-primary' : item.vip === 1 }" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cog"></i> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="hand"
                            mwl-confirm
                            title="Na pewno usunać?"
                            message="Wskazówka: Ten post zniknie na zawsze..."
                            confirm-text="Delete"
                            cancel-text="Cancel"
                            on-confirm="delItem(item)"
                            on-cancel=""
                            confirm-button-type="danger"
                            cancel-button-type="primary"><i class="fa fa-lg fa-trash-o"></i> <? echo langs("Usuń"); ?></a></li>
                        <li><a class="hand" ng-click="item.edited = true; editPost(item)"><i class="fa fa-lg fa-pencil-square-o"></i> <? echo langs("Edytuj"); ?></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a class="hand" ng-click="item.reach = 0; saveItem(item)"><i class="fa fa-lg fa-globe"></i> <? echo langs("Publiczne"); ?></a></li>
                        <li><a class="hand" ng-click="item.reach = 1; saveItem(item)"><i class="fa fa-lg fa-users"></i> <? echo langs("Znajomi"); ?></a></li>
                        <li><a class="hand" ng-click="item.reach = 2; saveItem(item)"><i class="fa fa-lg fa-star"></i> <? echo langs("VIP"); ?></a></li>
                        <li><a class="hand" ng-click="item.reach = 3; saveItem(item)"><i class="fa fa-lg fa-lock"></i> <? echo langs("Tylko ja"); ?></a></li>
                    </ul>
                </div>

            </div>
            <div class="clearfix"></div>

        </div>

        <div style="padding: 15px 15px 0px 15px;" class="panel-body new" ng-init=" item.edited = false ">

            <div ng-show="!item.edited" class="textPost" style=" text-align:left; line-height: 22px; font-size: 15px;" ng-bind-html="(parseMsg(item.tresc) | trustAsHtml)"></div>
            <div ng-show="item.edited">
                <textarea maxlength="1000" style="resize: vertical;" ng-model="item.tresc" rows="10" class="form-control" type="text"></textarea>
                <button
                    mwl-confirm
                    title="Na pewno zapisać?"
                    message="Wskazówka: Ten post zostanie edytowany..."
                    confirm-text="Save"
                    cancel-text="Cancel"
                    on-confirm=" item.edited = false; saveItem(item) "
                    on-cancel=" item.edited = false; "
                    confirm-button-type="success"
                    cancel-button-type="primary"
                    class="btn pull-right btn-success"><i class="fa fa-check" aria-hidden="true"></i> <? echo langs("Zapisz"); ?></button>
                <div class="clearfix"></div>
            </div>

            <div ng-show="item.attachments.length > 0" class="topLine"></div>
            <div ng-show="item.attachments.length > 0">
                <a ng-repeat="attachment in item.attachments" data-toggle='lightbox' ng-href="{{attachment.answer}}">
                    <img class='img-responsive' ng-src="{{attachment.answer}}">
                </a>
            </div>

            <div ng-show="item.todo.did || item.todo.tid" class="topLine"></div>
            <div ng-show="item.todo.did || item.todo.tid">
                <div style="text-align: left;" class="well">
                    <p ng-show="item.todo.did">Words to learn: <a ng-href="/#/words/{{item.todo.did}}" ng-bind="item.todo.dname"></a></p>
                    <p ng-show="item.todo.tid">Training to do: <a ng-href="/#/training/{{item.todo.tid}}" ng-bind="item.todo.tname"></a></p>
                </div>
            </div>

            <div style="float:left;text-align:left;" class="topLine">

                <button class="btn btn-link btn-sm" ng-click="likeBtn(item)">
                    <i ng-class="{ 'fa-thumbs-up' : item.liked > 0, 'fa-thumbs-o-up' : item.liked <= 0 }" class="fa fa-lg" aria-hidden="true"></i>
                    <strong><span ng-bind="( (item.liked > 0) ? '<? echo langs("Sownięte!"); ?>' : '<? echo langs("Sownij to!"); ?>' )"></span><span ng-bind="(' ('+item.likes+')' )"></span></strong>
                </button>
                <span> | </span>

                <button class="btn btn-link btn-sm" ng-click="showComments =! showComments "><i class="fa fa-comments-o fa-lg"></i>
                    <strong> <? echo langs("Komentarze"); ?> (<span ng-bind="item.comments.length"></span>)</strong>
                </button>

            </div>
            <div class="clearfix"></div>
        </div>

        <div class="panel-footer">

            <div ng-init="showComments = true " ng-show="showComments" style="margin:0px 5px 0px 5px;">
                <div ng-show="item.comments" ng-init=" comm.edited = false; " ng-repeat="comm in item.comments | orderBy : orderByColumn : orderAsc" style="font-size:13px; display: table; text-align:left; margin: 0px 5px 10px 50px;" width="100%">
                    <div style="vertical-align: top; display: table-cell; margin-bottom:10px;">

                        <a ng-href="/#/user/{{comm.kto}}">
                            <img width="30px" class="orange" style="margin-top:3px; margin-right:10px;" ng-src="{{comm.avatar}}"/>
                        </a>

                    </div>
                    <div style="vertical-align: top; display: table-cell;">

                        <a ng-href="/#/user/{{comm.kto}}"><strong ng-bind="(comm.imie) +' '+ (comm.nazwisko)"></strong></a> 

                        <span ng-show="!comm.edited" ng-bind-html="(parseMsg(comm.tresc) | trustAsHtml)"></span>
                        <span ng-show="comm.edited">
                            <textarea maxlength="1000" style="resize: vertical;" ng-model="comm.tresc" rows="10" class="form-control" type="text"></textarea>
                            <button
                                mwl-confirm
                                title="Na pewno zapisać?"
                                message="Wskazówka: Ten komentarz zostanie edytowany..."
                                confirm-text="Save"
                                cancel-text="Cancel"
                                on-confirm=" comm.edited = false; saveComm(comm) "
                                on-cancel=" comm.edited = false; "
                                confirm-button-type="success"
                                cancel-button-type="primary"
                                class="btn pull-right btn-success"><i class="fa fa-check" aria-hidden="true"></i> <? echo langs("Zapisz"); ?></button>
                            <div class="clearfix"></div>
                        </span>

                        <br>

                        <span style="color:#aaa;"><i class="fa fa-lg fa-clock-o"></i> <span ng-bind="(createDate(comm.date) | date : 'medium')"></span>
                        <span ng-if="comm.kto === aboutMe.id"> | <a class="hand"
                            mwl-confirm
                            title="Na pewno usunać?"
                            message="Wskazówka: Ten komentarz zniknie na zawsze..."
                            confirm-text="Delete"
                            cancel-text="Cancel"
                            on-confirm="item.comments = delComm(item.comments,item,comm)"
                            on-cancel=""
                            confirm-button-type="danger"
                            cancel-button-type="primary">
                            <i class="fa fa-trash-o"></i> <? echo langs("Usuń"); ?></a> | <a class="hand" ng-click="comm.edited = true; "><i class="fa fa-pencil-square-o"></i> <? echo langs("Edytuj"); ?></a>
                        </span>

                    </div>
                </div>

                <div class="input-group margin-bottom-sm">

                    <span style="padding:0px;" class="input-group-addon"><img class="orange" ng-src="{{aboutMe.avatar}}" width="35"></span>
                    <textarea maxlength="200" style="margin-left:10px" class="form-control" ng-model="newComm" ng-keyup=" $event.keyCode === 13 && (item.comments = addComm(newComm,item)) && (newComm = '') " type="text" placeholder="<? echo langs("Skomentuj..."); ?>"></textarea>
                </div>
            </div>

        </div>
    </div>
                        

