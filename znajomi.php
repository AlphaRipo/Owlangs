<?php require_once("ajax/db.php"); ?>

<style>
    .tab-content li { width: 150px!important; }
    .tab-content .panel-body { padding: 6px; }
</style>
    
<!-- Zawartość zakładek -->
<div class="tab-content" ng-controller="friends">
    <!-- ZAKŁADKA ZNAJOMI-->
    <div class="tab-pane active" id="5zakladkadrop">
        <div class="row" style="padding:20px 40px 40px 40px;">

            <uib-tabset active="active">
                <uib-tab index="0" heading="<? echo langs("Obserwujesz"); ?>">
                
                    <div class="col-lg-4 col-md-6 col-xs-12" ng-repeat="following in allFollowing | filter : searchFollowing">
                        <div style="margin-top:20px;" class="panel" ng-class="{'panel-primary':following.vip === 1,'panel-default':following.vip === 0}" data-toggle="tooltip" data-placement="top" title="<? echo langs('Obserwujesz użytkownika') ?> {{following.imie}} {{following.nazwisko}} {{ 'since '+createDate(following.since) | date : 'medium'}}">
                            <div style="text-align:left;" class="panel-body">
                                <a ng-href="/#/user/{{following.id_1}}">
                                    <table width="100%">
                                        <tr>
                                            <td width="70"><img class="img-thumbnail" ng-src="{{following.avatar}}" width="60"/></td>
                                            <td style="font-size:12px;">{{following.imie}}<br>{{ following.nazwisko | limitTo: 17 }}{{following.nazwisko.length > 17 ? '...' : ''}}</td>
                                            <td width="20">
                                                <span class="label" ng-class="{'label-success' : following.lvl_ang === 'A1' || following.lvl_ang === 'A2','label-warning' : following.lvl_ang === 'B1' || following.lvl_ang === 'B2','label-danger' : following.lvl_ang === 'C1' || following.lvl_ang === 'C2'}">{{following.lvl_ang}}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </a>
                            </div>
                        </div>
                        <button type="button" ng-disabled="following.id === aboutMe.id"
                            mwl-confirm
                            title="Na pewno usunąć?"
                            message="Wskazówka: Jeśli klikniesz usuń, ta osoba zniknie z listy Twoich znajomych..."
                            confirm-text="Remove"
                            cancel-text="Cancel"
                            on-confirm=" delFollowing(following) "
                            on-cancel=""
                            confirm-button-type="warning"
                            cancel-button-type="primary"
                            class="btn btn-danger btn-xs"
                            style="position:absolute; right:8px; top:12px;"><strong>&times;</strong>
                        </button>
                    </div>
                    <div class="clearfix"></div>
                    
                </uib-tab>
                <uib-tab index="1" heading="<? echo langs("Obserwujący"); ?>">

                    <div class="col-lg-4 col-md-6 col-xs-12" ng-repeat="follower in allFollowers | filter : searchFollowers">
                        <div style="margin-top:20px;" class="panel" ng-class="{'panel-primary':follower.vip === 1,'panel-default':follower.vip === 0}" data-toggle="tooltip" data-placement="top" title="{{follower.imie}} {{follower.nazwisko}} <? echo langs('Obserwuje Cię od'); ?> {{createDate(follower.since) | date : 'medium'}}">
                            <div style="text-align:left;" class="panel-body">
                                <a ng-href="/#/user/{{follower.id_0}}">
                                    <table width="100%">
                                        <tr>
                                            <td width="70"><img class="img-thumbnail" ng-src="{{follower.avatar}}" width="60"/></td>
                                            <td style="font-size:12px;">{{follower.imie}}<br>{{ follower.nazwisko | limitTo: 17 }}{{follower.nazwisko.length > 17 ? '...' : ''}}</td>
                                            <td width="20">
                                                <span class="label" ng-class="{'label-success' : follower.lvl_ang === 'A1' || follower.lvl_ang === 'A2','label-warning' : follower.lvl_ang === 'B1' || follower.lvl_ang === 'B2','label-danger' : follower.lvl_ang === 'C1' || follower.lvl_ang === 'C2'}">{{follower.lvl_ang}}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                </uib-tab>
            </uib-tabset>
            
        </div>
    </div>
</div>
