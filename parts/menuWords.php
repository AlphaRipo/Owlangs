<div class="przyciski" style="margin-top:20px;">
    <div class="col-md-3 col-xs-12">
        <a ng-class="{active:path === 'words'}" class="btn btn-primary btn-block" ng-href="/#/words"><i class="fa fa-users" aria-hidden="true"></i> <? echo langs("Cały słownik"); ?></a>
    </div>
    <div class="col-md-3 col-xs-12">
        <a ng-class="{active:path === 'my-words'}" class="btn btn-info btn-block" ng-href="/#/my-words/{{UID}}"><i class="fa fa-user" aria-hidden="true"></i> <? echo langs("Mój słownik"); ?></a>
    </div>
    <div class="col-md-3  col-xs-12">
        <a ng-class="{active:path === 'flashcards'}" class="btn btn-warning btn-block" ng-href="/#/flashcards"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <? echo langs("Ćwiczenia"); ?></a>
    </div>
    <div class="col-md-3 col-xs-12">
        <a ng-class="{active:path === 'flashcards-time'}" class="btn btn-danger btn-block" ng-href="/#/flashcards-time"><i class="fa fa-clock-o" aria-hidden="true"></i> <? echo langs("Wyzwania"); ?></a>
    </div>
    <div class="clearfix"></div>
</div>