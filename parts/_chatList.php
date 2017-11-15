
<ul ng-controller="chat-list-ctrl">
    <li class="chat_pier"><i class="fa fa-2x fa-comments-o"></i><br>CHAT</li>
    
    <style>
        .isAvaible { border: 2px solid #8AC007; }
        .isNotAvaible { border: 2px solid #e51c23; }
    </style>
    
    <li ng-repeat="friend in friends | filter : searchPerson" style="text-align:right;" class="contacts text-success" data-toggle="tooltip" data-placement="right" title="{{friend.imie}} {{friend.nazwisko}}">
        <a ng-click="showMsgs(friend)" class="hand">
            <img class="avatar img-circle" ng-class="{isAvaible:friend.available === 1,isNotAvaible:friend.available === 0}" width="45" height="45" ng-src="{{friend.avatar}}" />
        </a>
        <span style="margin-right: 10px">
            <span style=" width: 20px; height: 16px; margin-top: 15px!important; margin-right: 10px!important; " class="phoca-flag gb"></span><br>
            <strong ng-bind="friend.lvl_ang"></strong>
        </span>
    </li>                       
</ul>
