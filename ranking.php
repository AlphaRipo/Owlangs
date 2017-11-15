<? require_once("ajax/db.php"); ?>

    <div class="ranking cn-right">
        <div class="col-xs-12" style="margin-top:20px;">
            
            <div ng-repeat="user in users" class="well pozycja">
                <div class="kol1 col-xs-2">
                    <span class="label label-info" style="font-size:15px;padding:10px;" ng-bind-html="( '<i class=\'fa fa-trophy\' aria-hidden=\'true\'></i> ' + ($index+1))"></span><br>
                    <a ng-href="/#/user/{{user.id}}"><img width="70px" class="img-circle img-thumbnail" ng-src="{{user.avatar}}" alt="{{user.imie}} {{user.nazwisko}}" /></a>
                </div>
                <div class="kol2 col-md-2 col-xs-4 ">
                    <p ng-bind="(user.imie +' '+ user.nazwisko)"></p>
                    <ul>
                        <li class="label" ng-if="user.vip" ng-class="{'label-warning' : user.vip}">VIP</li>
                        <li class="label" ng-if="user.lvl_ang" ng-class="{'label-success' : user.lvl_ang === 'A1' || user.lvl_ang === 'A2','label-warning' : user.lvl_ang === 'B1' || user.lvl_ang === 'B2','label-danger' : user.lvl_ang === 'C1' || user.lvl_ang === 'C2'}" ng-bind="user.lvl_ang"></li>
                    </ul>
                </div>
                <div class="kol3 col-md-2 hidden-sm hidden-xs">
                    
                    <p>
                        <button ng-if="user.id !== aboutMe.id" class="btn"
                            ng-click=" user.friends = (user.friends === 0 && user.id !== aboutMe.id) ? add2Friends(aboutMe.id,user.id) : delFromFriends(aboutMe.id,user.id) " 
                            ng-class=" { 'btn-success':user.friends === 0 && user.id !== aboutMe.id, 'btn-primary':user.friends === 1 && user.id !== aboutMe.id } ">
                            <i class="fa" ng-class="{ 'fa-user-plus':user.friends === 0 && user.id !== aboutMe.id, 'fa-user-times':user.friends === 1 && user.id !== aboutMe.id }" aria-hidden="true"></i>
                        </button>
                        <p ng-if="user.id !== aboutMe.id" style="font-size:10px;" ng-bind=" user.tooltip = (user.friends > 0) ? 'Click to remove from friends' : 'Click to add to friends' "></p>
                    </p>
                    
                </div>
                <div class="kol4 col-xs-2">
                    <p>Punkty za<br>szkolenia</p>
                    <p class="label label-danger" ng-bind="calculate(user.scTrain,4)"></p>
                </div>
                <div class="kol5 col-xs-2">
                    <p>Punkty za<br>aktywność</p>
                    <p class="label label-success" ng-bind=" calculate(user.scHelp,10)"></p>
                </div>
                <div class="kol6 col-xs-2">
                    <p>Punkty z<br>aukcji</p>
                    <p class="label label-primary" ng-bind="calculate(user.scTranslate,7)"></p>
                </div>
                
                <div class="clearfix"></div>
            </div>
            
        </div>
    </div>
