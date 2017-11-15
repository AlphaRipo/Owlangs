
<div style="display:none;" class="chatWin" id="1">
    
    <div ng-controller="chat-ctrl" class="panel panel-primary chatForm">

        <div class="panel-heading" ng-init=" chatVisible = true ">
            
            <i class="fa fa-lg fa-comments"></i>  
            <a class="linkToProfile" ng-href="/#/user/{{selected.id}}"><strong ng-bind="( selected.imie+' '+selected.nazwisko )"></strong></a> 
            
            <span class="label" ng-class="{'label-success' : selected.lvl_ang === 'A1' || selected.lvl_ang === 'A2','label-warning' : selected.lvl_ang === 'B1' || selected.lvl_ang === 'B2','label-danger' : selected.lvl_ang === 'C1' || selected.lvl_ang === 'C2'}">
                <span style=" width: 22px; height: 16px; margin-right: 5px!important; " class="phoca-flag gb"></span>
                <span ng-bind="selected.lvl_ang"></span>
            </span>
            
            <button ng-click="closeChat()" class="btn pull-right btn-xs btn-danger"><span aria-hidden="true"><i class="fa fa-2x fa-times-circle"></i></span></button>
            <button ng-click="chatVisible = !chatVisible" class="btn pull-right btn-xs btn-success"><span aria-hidden="true"><i class="fa fa-2x" ng-class="{'fa-arrow-circle-down':chatVisible,'fa-arrow-circle-up':!chatVisible}"></i></span></button>
            <a ng-if="selected.skype" style="margin-right:10px;color:#8AC007;" class="btn pull-right btn-xs btn-default" href="skype:{{selected.skype}}?call&video=true"><span aria-hidden="true"><i class="fa fa-2x fa-skype"></i></span></a>
            <div class="clearfix"></div>
            
        </div>

        <div class="panel-body" ng-show="chatVisible" id="chat-scroll">
        
            <div ng-if="messages.length > 0">
                
                <div data-toggle="tooltip" data-placement="left" data-original-title="{{getFullName(msg.kto)}} on {{createDate(msg.kiedy) | date}}" class="col-xs-12 alert" ng-class="{ 'alert-info pull-left':checkMe(msg.kto), 'alert-warning pull-right':!checkMe(msg.kto) }" ng-repeat="msg in messages | filter : keywordsChat" on-finish-render="ngRepeatFinished">
                    
                    <div class="col-xs-2 nopadding">
                        <img title="{{msg.imie}} {{msg.nazwisko}}" class="orange" ng-src="{{getAvatar(msg.kto)}}" style="margin-right:10px;" width="30">
                    </div>
                    <div class="col-xs-10 nopadding">
                        
                        <span ng-init="seen(msg)" ng-bind-html="parseMsg(msg.co,$index)"></span>
                        <span ng-repeat="img in msg.images">
                            <img style="width:100%;margin:10px 5px 5px 0px;" class="img-thumbnail" ng-src="{{img.answer}}" />
                        </span>
                        
                        <!--<br><p ng-if="msg.seen" ng-class="{ 'label-success':!checkMe(msg.kto),'label-warning':checkMe(msg.kto) }" class="label pull-right">seen</p>-->
                    </div>
                </div>
                
            </div>

        </div>
        <div class="panel-footer" ng-show="chatVisible">
            
            <div ng-if="cannot" style="width:100%" class="alert alert-danger"><i class="fa fa-lg fa-frown-o" aria-hidden="true"></i> <? echo langs("pssst! <strong>Musisz być VIPem</strong> by wysyłać więcej niż 1 wiadomość na dobę!"); ?></div>
            
            <div style="margin-bottom:10px;" class="input-group">
                
                <input type="text" class='form-control' ng-model="keywordsChat" placeholder="Szukaj w słów kluczowych tej rozmowie...">
                
                <span class="input-group-btn">
                    <a class="btn btn-default" id='searchBtn' type="button"><i class="fa fa-search"></i></a>
                </span>
                
            </div>
            
            <textarea rows="2" ng-keyup="$event.keyCode === 13 && onSubmit(answer)" ng-model="answer" class="form-control" placeholder="<? echo langs("Napisz..."); ?>" type="text"></textarea>
            
        </div>
    </div>
</div>
