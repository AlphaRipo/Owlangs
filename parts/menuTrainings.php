<div class="przyciski col-xs-12" style="margin-top:20px;">
    <div class="col-md-3 col-xs-6">
        <a ng-class="{active:path === 'trainings'}" class="btn btn-primary btn-block" ng-href="/#/trainings"><i class="fa fa-users" aria-hidden="true"></i> <? echo langs("Wszystkie szkolenia"); ?></a>
    </div>
    <div class="col-md-3 col-xs-6">
        <a ng-class="{active:path === 'my-trainings'}" class="btn btn-danger btn-block" ng-href="/#/my-trainings/{{UID}}"><i class="fa fa-user" aria-hidden="true"></i> <? echo langs("Nagrane przeze mnie"); ?></a>
    </div>
    <div class="col-md-3 col-xs-6">
        <a ng-class="{active:path === 'completed-trainings'}" class="btn btn-info btn-block" ng-href="/#/completed-trainings/{{UID}}"><i class="fa fa-trophy" aria-hidden="true"></i> <? echo langs("Odbyte przeze mnie"); ?></a>
    </div>
    <div class="col-md-3 col-xs-6">
        <a ng-class="{active:path === 'create-training'}" class="btn btn-success btn-block" ng-href="/#/create-training"><i class="fa fa-plus-circle" aria-hidden="true"></i> <? echo langs("Stwórz nowy mini kurs"); ?></a>
    </div>
    <div class="clearfix"></div>
</div>