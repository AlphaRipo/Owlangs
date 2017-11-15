<?php require_once("ajax/db.php"); ?>

<style type="text/css">
    .cn-left {text-align:left;}
    .cn-right2 {text-align:right;}
    .cn-center {text-align:center;}
    .cn-justify {text-align:justify;}
    #ui-datepicker-div{border: 1px solid #ccc;}
</style>

<!-- ZAKŁADKA AUKCJE -->
<div class="tab-pane active">
    <div class="row nopadding">
        <div style="margin-top:20px;" class="col-md-12 col-xs-12">
            <div class="col-md-8 col-sm-8 col-xs-12 btn-group nopadding">
                <a ng-click="getNgData('all');" class="btn all btn-primary wszyscy active"><i class="fa fa-globe"></i> <? echo langs("Wszystkie"); ?></a>

                <a ng-click="getNgData('me');" class="btn me btn-success moje"><i class="fa fa-user"></i> <? echo langs("Moje aukcje"); ?></a>

                <a ng-click="getNgData('offer');" class="btn offer btn-info biorcy"><i class="fa fa-graduation-cap"></i> <? echo langs("Oferty"); ?></a>

                <a ng-click="getNgData('todo');" class="btn todo btn-warning dawcy"><i class="fa fa-bullhorn"></i> <? echo langs("Zlecenia"); ?></a>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 nopadding">
                <a data-toggle="modal" data-target="#myModal1" class="pull-right btn btn-success"><i class="fa fa-plus"></i> <? echo langs("DODAJ NOWE"); ?></a>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <hr>

    <div class="zgloszenie row nopadding">

        <div class="col-xs-12">
            <div class="input-group">
                <input id="searchAuctions" ng-model="search" type="text" class='form-control' placeholder="<? echo langs("Wyszukaj aukcję..."); ?>">
                <span class="input-group-btn">
                    <a class="btn btn-default" id='searchBtn' type="button" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by wyczyścić pole."); ?>" ng-click="clearSearch();"><i class="fa fa-times"></i></a>
                    <a class="btn btn-default" id='searchBtn' type="button" data-toggle="tooltip" data-placement="top" title="<? echo langs("Kliknij by wyszukać."); ?>"><i class="fa fa-search"></i></a>
                </span>
            </div>
            <h3><span id="myOrAll"><? echo langs("LISTA WSZYSTKICH AUKCJI"); ?></span>:</h3>
        </div>

        <div style="padding:20px;"> 
            <table class="table table-striped table-responsive table-hover nopadding">
                <tr class="nopadding">
                    <th class="cn-center" style="width:60px;"><? echo langs("typ"); ?></th>
                    <th><? echo langs("tytuł"); ?></th>
                    <th class="cn-left" style="width:80px;"><? echo langs("budżet"); ?></th>
                    <th class="cn-left" style="width:100px;"><? echo langs("data"); ?></th>
                    <th class="cn-left" style="width:100px;"><? echo langs("termin"); ?></th>
                    <!-- <th style="width:25px;"></th> -->
                    <th class="cn-right2" style="width:90px;"></th>
                </tr>

                <tr class="nopadding" ng-repeat="auction in auctions | filter : search">
                    <td class="nopadding" colspan="6">
                        <table class="table table-responsive table-hover nopadding">
                            <tr class="nopadding">
                                <td style="width:60px;" ng-if="auction.category == 1" class="cn-center"><i class="fa fa-lg fa-bullhorn"></i></td>
                                <td style="width:60px;" ng-if="auction.category == 2" class="cn-center"><i class="fa fa-lg fa-graduation-cap"></i></td>
                                <td class="cn-left"><a class="cn-hand" ng-click="open =! open">{{auction.title}} <i class="fa fa-angle-double-right"></i></a></td>
                                <td style="width:80px;" class="cn-left">{{auction.price}} {{auction.currency}}</td>
                                <td style="width:100px;" class="cn-left">{{auction.date}}</td>
                                <td style="width:100px;" class="cn-left">{{auction.term}}</td>
                                <!-- <td class="cn-left"><button ng-click="delAuction(auction.id)" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button></td> -->
                                <td style="width:90px;" class="cn-right2"><button ng-click="open =! open" class="btn btn-xs btn-primary"><i class="fa fa-chevron-down"></i></button></td>
                            </tr>
                            <tr class="nopadding well" ng-show="open">
                                <td class="cn-justify" colspan="5">
                                    <p>Kategoria: <strong>{{getTypeName(auction.type,auction.category)}}</strong></p>
                                    <p>Użytkownik: <a ng-href="/#/user/{{auction.user}}">{{auction.imie}} {{auction.nazwisko}} / Level: {{auction.lvl_ang}}</a></p>
                                    <p>{{auction.content}}</p>
                                </td>
                                <td colspan="1">
                                    <button ng-if="auction.category == 1" ng-click="setId1(auction.id)" data-toggle="modal" data-target="#myModal3" class="btn btn-block btn-sm btn-warning"><i class="fa fa-paper-plane-o"></i> <? echo langs("aplikuj"); ?></button>
                                    <button ng-if="auction.category == 1" ng-click="setId3(auction.id)" data-toggle="modal" data-target="#myModal4" class="btn btn-block btn-sm btn-info"><i class="fa fa-info-circle"></i> <? echo langs("oferty"); ?></button>
                                    <button ng-if="auction.category == 2" ng-click="setId2(auction.id)" data-toggle="modal" data-target="#myModal2" class="btn btn-block btn-sm btn-success"><i class="fa fa-paper-plane-o"></i> <? echo langs("napisz"); ?></button>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- ================================================= -->

<div class="modal fade" id="myModal1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel1"><? echo langs("DODAJ OFERTE / ZLECENIE"); ?></h4>
            </div>
            <div class="modal-body">
                
                <div class=" row nopadding">
                    <div class="szczegoly col-xs-4 nopadding">
                        <div class="avatar nopadding">
                            <img ng-src="{{aboutMe.avatar}}" style="border:1px solid #ccc; width:135px;" class="img-responsive" alt="avatar" />
                            <h4 style="border-bottom:0px;font-size:1.1em;"><?php echo $your_imie.' '.$your_nazwisko; ?></h4>
                        </div>
                    </div>
                    <div class="szczegoly col-xs-8 nopadding">

                        <div class="col-xs-12 nopadding">
                            <p style="margin-top:10px;">
                            <select class="form-control" id="category">
                                <option value="1"><? echo langs("Zlecam usługę"); ?></option>
                                <option value="2"><? echo langs("Oferuję usługę"); ?></option>
                            </select>
                            <p style="margin-top:10px;">
                            </p>
                            <select class="form-control" id="type">
                                <option value="1"><? echo langs("Konwersacja zwykła"); ?></option>
                                <option value="2"><? echo langs("Konwersacja z native speakerem"); ?></option>
                                <option value="3"><? echo langs("Gramatyka"); ?></option>
                                <option value="4"><? echo langs("Tłumaczenie zwykłe"); ?></option>
                                <option value="5"><? echo langs("Tłumaczenie przysięgłe"); ?></option>
                            </select>
                            </p>
                            <p><input id="dateInp" readonly class="form-control" type="text" placeholder="<? echo langs("Wpisz osteteczny termin wykonania (data i godz.)"); ?>" /></p>
                            <p>
                                <div class="input-group">
                                    <input id="priceInp" class="form-control" type="text" placeholder="<? echo langs("Wpisz cenę"); ?>" />
                                    <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span id="currency">PLN</span> <i class="fa fa-caret-down"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a onclick="changeCurrency('EUR')"><i class="fa fa-eur"></i> EUR</a></li>
                                        <li><a onclick="changeCurrency('GBP')"><i class="fa fa-gbp"></i> GBP</a></li>
                                        <li><a onclick="changeCurrency('USD')"><i class="fa fa-usd"></i> USD</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a onclick="changeCurrency('PLN')"><i class="fa fa-money"></i> PLN</a></li>
                                    </ul>
                                    </div>
                                </div>
                            </p>
                            <p><input id="title" class="form-control" placeholder="<? echo langs("Wpisz tytuł..."); ?>" /></p>
                            <p><textarea id="content" class="form-control" rows="7" placeholder="<? echo langs("Treść..."); ?>" style="resize:vertical;"></textarea></p>
                        </div>
                        <div class="clearfix"></div>
                        <div style="display:none" id="mod1Err" class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <? echo langs("Błąd! Wypełnij wszystkie pola..."); ?></div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" onclick="saveAuction();" class="btn cnClose btn-success"><i class="fa fa-check"></i> <? echo langs("Zapisz"); ?></button>
                <button type="button" class="btn cnClose btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <? echo langs("Zamknij"); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- ================================================= -->

<div class="modal fade" id="myModal2" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel2"><? echo langs("NAPISZ W SPRAWIE OFERTY"); ?></h4>
            </div>
            <div class="modal-body">
                
                <div class=" row nopadding">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" onclick="" class="btn cnClose btn-success"><i class="fa fa-paper-plane-o"></i> <? echo langs("Wyślij"); ?></button>
                <button type="button" class="btn cnClose btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <? echo langs("Zamknij"); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- ================================================= -->

<div class="modal fade bs-example-modal-lg" data-backdrop="static" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel4"><? echo langs("PODGLĄD OFERT DO TEGO ZLECENIA"); ?></h4>
            </div>
            <div class="modal-body nopadding">
                
                <div class="row nopadding">
                    <table class="table table-striped table-responsive table-hover nopadding">
                        <tr class="nopadding">
                            <th class="cn-center" style="width:120px;"><? echo langs("kto"); ?></th>
                            <th class="cn-left"><? echo langs("tytuł"); ?></th>
                            <th class="cn-left"><? echo langs("treść"); ?></th>
                            <th class="cn-center" style="width:80px;"><? echo langs("cena"); ?></th>
                            <th class="cn-center" style="width:100px;"><? echo langs("termin"); ?></th>
                            <th class="cn-center" style="width:30px;"><? echo langs("level"); ?></th>
                            <th class="cn-center" style="width:30px;"></th>
                        </tr>
                        <tr ng-repeat="offer in offers">
                            <td class="cn-center" style="width:120px;"><a ng-href="/#/user/{{offer.who}}">{{offer.imie}} {{offer.nazwisko}}</a></td>
                            <td class="cn-left">{{offer.title}}</td>
                            <td class="cn-left">{{offer.content}}</td>
                            <td class="cn-center" style="width:80px;">{{offer.price}} {{offer.currency}}</td>
                            <td class="cn-center" style="width:100px;">{{offer.term}}</td>
                            <td class="cn-center" style="width:30px;">{{offer.lvl_ang}}</td>
                            <td class="cn-center" style="width:60px;">
                                <button onclick="checkOffer(this);" ng-if="offer.user == mid" class="btn btn-xs btn-accept btn-default"><i class="fa fa-check"></i></button>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn cnClose btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <? echo langs("Zamknij"); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- ================================================= -->

<div class="modal fade" id="myModal3" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel3"><? echo langs("APLIKUJ DO TEGO ZLECENIA"); ?></h4>
            </div>
            <div class="modal-body">
                
                <div class="row nopadding">
                    <p><input id="dateInp2" readonly class="form-control" type="text" placeholder="<? echo langs("Wpisz osteteczny termin wykonania (data i godz.)"); ?>" /></p>
                    <p>
                        <div class="input-group">
                            <input id="priceInp2" class="form-control" type="text" placeholder="<? echo langs("Wpisz cenę"); ?>" />
                            <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span id="currency2">PLN</span> <i class="fa fa-caret-down"></i></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a onclick="changeCurrency('EUR')"><i class="fa fa-eur"></i> EUR</a></li>
                                <li><a onclick="changeCurrency('GBP')"><i class="fa fa-gbp"></i> GBP</a></li>
                                <li><a onclick="changeCurrency('USD')"><i class="fa fa-usd"></i> USD</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a onclick="changeCurrency('PLN')"><i class="fa fa-money"></i> PLN</a></li>
                            </ul>
                            </div>
                        </div>
                    </p>
                    <p><input id="title2" class="form-control" placeholder="<? echo langs("Wpisz tytuł..."); ?>" /></p>
                    <p><textarea id="content2" class="form-control" rows="7" placeholder="<? echo langs("Treść..."); ?>" style="resize:vertical;"></textarea></p>
                </div>
                <div class="clearfix"></div>
                <div style="display:none" id="mod3Err" class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <? echo langs("Błąd! Wypełnij wszystkie pola..."); ?></div>

            </div>
            <div class="modal-footer">
                <button type="button" onclick="sendOffer();" class="btn cnClose btn-success"><i class="fa fa-check"></i> <? echo langs("Aplikuj"); ?></button>
                <button type="button" class="btn cnClose btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <? echo langs("Zamknij"); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- ================================================= -->

<script type="text/javascript">

    function changeCurrency (argument) { $('#currency,#currency2').text(argument); }
    $("#priceInp,#priceInp2").mask('000.000.000.000.000,00', {reverse: true} );
    $("#dateInp,#dateInp2").mask('99-99-9999');

    $('#dateInp,#dateInp2').datepicker({
        inline: true,
        firstDay: 1,
        minDate: 0,
        showOtherMonths: true,
        dateFormat: 'dd-mm-yy',
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        monthNames: [ "January", "February", "March", "April", "May", "Juli", "July", "August", "September", "October", "November", "December" ]
    });

    function sendOffer () {
        var obj = {
            currency : $( "#currency2" ).text(),
            content : $( "#content2" ).val(),
            price : $( "#priceInp2" ).val(),
            term : $( "#dateInp2" ).val(),
            title : $( "#title2" ).val(),
            auction : $( "#myModal3" ).attr('name')
        };
        if(obj.auction && obj.title && obj.term && obj.price && obj.content) {
            $.post("ajax/sendAuctionOffer.php", { obj:obj, mid:(YOU.split("#"))[0] }, function( data )
            {
                $('button.wszyscy').click();
                $('#myModal3').modal('hide');
            });
        }
        else {
            $('#mod3Err').show();
            setTimeout(function(){ $('#mod3Err').hide(); }, 2000);
        }
    };

    function saveAuction () {
        var obj = {
            category : $( "#category option:selected" ).val(),
            type : $( "#type option:selected" ).val(),
            currency : $( "#currency" ).text(),
            content : $( "#content" ).val(),
            price : $( "#priceInp" ).val(),
            term : $( "#dateInp" ).val(),
            title : $( "#title" ).val(),
        };
        if(obj.price && obj.content && obj.term && obj.title) {
            $.post("ajax/saveAuction.php", { obj:obj, mid:(YOU.split("#"))[0] }, function( data )
            {
                $('button.wszyscy').click();
                $('#myModal1').modal('hide');
            });
        }
        else {
            $('#mod1Err').show();
            setTimeout(function(){ $('#mod1Err').hide(); }, 2000);
        }
    };

    function checkOffer (arg) {
        var btn = $(arg).closest('button');
        $('.btn-accept').removeClass('btn-success');
        btn.addClass('btn-success');
    };

    //WSZYSCY

    $('.wszyscy').click(function() {
        $('#myOrAll').text('<? echo langs("LISTA WSZYSTKICH AUKCJI"); ?>');
        $('.wszyscy').addClass('active');
        $('.biorcy').removeClass('active');
        $('.dawcy').removeClass('active');
        $('.moje').removeClass('active');
        $('.zglo_fiol').removeClass('hidden');
        $('.zglo_pomar').removeClass('hidden');
    });

    //BIORCY        

    $('.biorcy').click(function() {
        $('#myOrAll').text('<? echo langs("LISTA Z OFERTAMI"); ?>');
        $('.biorcy').addClass('active');
        $('.wszyscy').removeClass('active');
        $('.dawcy').removeClass('active');
        $('.moje').removeClass('active');
        $('.zglo_fiol').removeClass('hidden');
        $('.zglo_pomar').addClass('hidden');
        });

    //DAWCY     

    $('.dawcy').click(function() {
        $('#myOrAll').text('<? echo langs("LISTA ZE ZLECENIAMI"); ?>');
        $('.dawcy').addClass('active');
        $('.wszyscy').removeClass('active');
        $('.biorcy').removeClass('active');
        $('.moje').removeClass('active');
        $('.zglo_fiol').addClass('hidden');
        $('.zglo_pomar').removeClass('hidden');
    });

    //MOJE     

    $('.moje').click(function() {
        $('#myOrAll').text('<? echo langs("LISTA MOICH AUKCJI"); ?>');
        $('.moje').addClass('active');
        $('.wszyscy').removeClass('active');
        $('.biorcy').removeClass('active');
        $('.dawcy').removeClass('active');
        $('.zglo_fiol').removeClass('hidden');
        $('.zglo_pomar').removeClass('hidden');
    });

</script>