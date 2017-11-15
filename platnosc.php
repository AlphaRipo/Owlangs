<?php require_once("ajax/db.php"); ?>

<section class="vip">
    <h2><? echo langs('Przejdź'); ?> <span><? echo langs('na VIP'); ?></span></h2>
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <div class="lightblue">
                <div class="naglowek">
                    <h3>25<span>PLN/mo</span></h3>
                </div>
                <div class="srodek">
                    <span>month</span>
                </div>
                <div class="dol">
                    <button><? echo langs('Kupuję'); ?><img src="img/platnosc/kosz.png" alt="koszyk1" /></button>
                    <p><? echo langs('75 zł'); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xs-12">
            <div class="green">
                <div class="naglowek">
                    <h3>25<span>PLN/mo</span></h3>
                </div>
                <div class="srodek">
                    <span><? echo langs('3 miesiące'); ?></span>
                    <img src="img/platnosc/kokarda.png" alt="kokarda"/>
                </div>
                <div class="dol">
                    <button><? echo langs('Kupuję'); ?><img src="img/platnosc/kosz.png" alt="koszyk1" /></button>
                    <p><? echo langs('75 zł'); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xs-12">
            <div class="blue">
                <div class="naglowek">
                    <h3>25<span>PLN/mo</span></h3>
                </div>
                <div class="srodek">
                    <span><? echo langs('rok'); ?></span>
                </div>
                <div class="dol">
                    <button><? echo langs('Kupuję'); ?><img src="img/platnosc/kosz.png" alt="koszyk1" /></button>
                    <p><? echo langs('300zł'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="tabela">
    <div class="row">
        <div class="col-xs-12">
            <div class="korzysci">
                <table class="table table-bordered table-striped">
                    <tr>
                        <td><span><? echo langs('Korzyści'); ?></span> <? echo langs('z posiadania'); ?></td>
                        <td><? echo langs('Konta <span>VIP</span>'); ?></td>
                        <td><? echo langs('<span>Darmowego</span> konta'); ?></td>
                    </tr>
                    <tr>
                        <td><? echo langs('Korzyść 1'); ?></td>
                        <td><img src="img/platnosc/tick.png" alt="tick" /></td>
                        <td><img src="img/platnosc/cross.png" alt="cross" /></td>
                    </tr>
                    <tr>
                        <td><? echo langs('Korzyść 2'); ?></td>
                        <td><img src="img/platnosc/tick.png" alt="tick" /></td>
                        <td><img src="img/platnosc/cross.png" alt="cross" /></td>
                    </tr>
                    <tr>
                        <td><? echo langs('Korzyść 3'); ?></td>
                        <td><img src="img/platnosc/tick.png" alt="tick" /></td>
                        <td><img src="img/platnosc/tick.png" alt="tick" /></td>
                    </tr>
                    <tr>
                        <td><? echo langs('Korzyść 4'); ?></td>
                        <td><img src="img/platnosc/tick.png" alt="tick" /></td>
                        <td><img src="img/platnosc/cross.png" alt="cross" /></td>
                    </tr>
                    <tr>
                        <td><? echo langs('Korzyść 5'); ?></td>
                        <td><img src="img/platnosc/tick.png" alt="tick" /></td>
                        <td><img src="img/platnosc/tick.png" alt="tick" /></td>
                    </tr>
                    <tr>
                        <td><? echo langs('Korzyść 6'); ?></td>
                        <td><img src="img/platnosc/tick.png" alt="tick" /></td>
                        <td><img src="img/platnosc/tick.png" alt="tick" /></td>
                    </tr>
                    <tr>
                        <td><? echo langs('Korzyść 7'); ?></td>
                        <td><img src="img/platnosc/tick.png" alt="tick" /></td>
                        <td><img src="img/platnosc/cross.png" alt="cross" /></td>
                    </tr>
                    <tr>
                        <td><? echo langs('Korzyść 8'); ?></td>
                        <td><img src="img/platnosc/tick.png" alt="tick" /></td>
                        <td><img src="img/platnosc/cross.png" alt="cross" /></td>
                    </tr>
                </table>
            </div>
            
        </div>
    </div>
</section>

<section id="faq">
    <h2><? echo langs('Często zadawane'); ?> <span><? echo langs('pytania'); ?></span></h2>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel-group" id="accordion-sample">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a>
                                <p><? echo langs('1. Nie lubię długoterminowych zobowiązań, czy mogę zrezygnować w dowolnym momencie?'); ?></p>
                            </a>
                        </h4>
                    </div>
                    <div id="accordion-sample-one">
                        <div class="panel-body">
                            <p><? echo langs('Odp: tak, możesz zrezygnować kiedy chcesz i nie ponosisz z tego tytułu żadnych kosztów'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a>
                                <p><? echo langs('Pytanie 2'); ?></p>
                            </a>
                        </h4>
                    </div>
                    <div id="accordion-sample-two">
                        <div class="panel-body">
                            <p><? echo langs('Odp: tak, możesz zrezygnować kiedy chcesz i nie ponosisz z tego tytułu żadnych kosztów'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a>
                                <p><? echo langs('3. Nie lubię długoterminowych zobowiązań, czy mogę zrezygnować w dowolnym momencie?'); ?></p>
                            </a>
                        </h4>
                    </div>
                    <div id="accordion-sample-3">
                        <div class="panel-body">
                            <p><? echo langs('Odp: tak, możesz zrezygnować kiedy chcesz i nie ponosisz z tego tytułu żadnych kosztów'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a>
                                <p><? echo langs('Pytanie 4'); ?></p>
                            </a>
                        </h4>
                    </div>
                    <div id="accordion-sample-4">
                        <div class="panel-body">
                            <p><? echo langs('Odp: tak, możesz zrezygnować kiedy chcesz i nie ponosisz z tego tytułu żadnych kosztów'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a>
                                <p><? echo langs('5. Nie lubię długoterminowych zobowiązań, czy mogę zrezygnować w dowolnym momencie?'); ?></p>
                            </a>
                        </h4>
                    </div>
                    <div id="accordion-sample-5">
                        <div class="panel-body">
                            <p><? echo langs('Odp: tak, możesz zrezygnować kiedy chcesz i nie ponosisz z tego tytułu żadnych kosztów'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a>
                                <p><? echo langs('Pytanie 6'); ?></p>
                            </a>
                        </h4>
                    </div>
                    <div id="accordion-sample-6">
                        <div class="panel-body">
                            <p><? echo langs('Odp: tak, możesz zrezygnować kiedy chcesz i nie ponosisz z tego tytułu żadnych kosztów'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="opinie">
    <div id="pudlo">
        <h2><? echo langs('Opinie <span>użytkowników</span>'); ?></h2>
        
        <div class="row">
            <div class="panel-default">
                <div class="panel-heading">
                    <div class="col-sm-3 col-xs-12">
                        <img src="img/platnosc/opinie1.jpg" class="img-responsive" alt="użytkownik" />
                    </div>
                    <div class="col-sm-9 col-xs-12">
                        <p class="podpis"><span><? echo langs('Osoba 1'); ?></span></p>
                        <p><? echo langs('Opinia 1'); ?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
            
        <br>
        
        <div class="row">
            <div class="panel-default">
                <div class="panel-heading">
                    <div class="col-sm-3 col-xs-12">
                        <img src="img/platnosc/opinie1.jpg" class="img-responsive" alt="użytkownik" />
                    </div>
                    <div class="col-sm-9 col-xs-12">
                        <p class="podpis"><span><? echo langs('Osoba 2'); ?></span></p>
                        <p><? echo langs('Opinia 2'); ?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
            
        <br>
        
        <div class="row">
            <div class="panel-default">
                <div class="panel-heading">
                    <div class="col-sm-3 col-xs-12">
                        <img src="img/platnosc/opinie1.jpg" class="img-responsive" alt="użytkownik" />
                    </div>
                    <div class="col-sm-9 col-xs-12">
                        <p class="podpis"><span><? echo langs('Osoba 3'); ?></span></p>
                        <p><? echo langs('Opinia 3'); ?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
            
        <br>
        
        <div class="row">
            <div class="panel-default">
                <div class="panel-heading">
                    <div class="col-sm-3 col-xs-12">
                        <img src="img/platnosc/opinie1.jpg" class="img-responsive" alt="użytkownik" />
                    </div>
                    <div class="col-sm-9 col-xs-12">
                        <p class="podpis"><span><? echo langs('Osoba 4'); ?></span></p>
                        <p><? echo langs('Opinia 4'); ?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
            
        <br>
        
        <div class="row">
            <div class="panel-default">
                <div class="panel-heading">
                    <div class="col-sm-3 col-xs-12">
                        <img src="img/platnosc/opinie1.jpg" class="img-responsive" alt="użytkownik" />
                    </div>
                    <div class="col-sm-9 col-xs-12">
                        <p class="podpis"><span><? echo langs('Osoba 5'); ?></span></p>
                        <p><? echo langs('Opinia 5'); ?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
            
        <br>
        
        <div class="row">
            <div class="panel-default">
                <div class="panel-heading">
                    <div class="col-sm-3 col-xs-12">
                        <img src="img/platnosc/opinie1.jpg" class="img-responsive" alt="użytkownik" />
                    </div>
                    <div class="col-sm-9 col-xs-12">
                        <p class="podpis"><span><? echo langs('Osoba 6'); ?></span></p>
                        <p><? echo langs('Opinia 6'); ?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
            
        <br>
        
        <div class="row">
            <div class="panel-default">
                <div class="panel-heading">
                    <div class="col-sm-3 col-xs-12">
                        <img src="img/platnosc/opinie1.jpg" class="img-responsive" alt="użytkownik" />
                    </div>
                    <div class="col-sm-9 col-xs-12">
                        <p class="podpis"><span><? echo langs('Osoba 7'); ?></span></p>
                        <p><? echo langs('Opinia 7'); ?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        
    </div>
</section>

<section id="baner">
    <div id="baner_zdj" class="row">
        <div class="col-sm-5 col-sm-pull-7 col-sm-offset-7 col-xs-12">
            <h2 id="guaranteed1"><? echo langs('Gwarancja <span>100% satysfakcji</span>'); ?></h2>
            <p id="guaranteed2"><? echo langs('lub zwrot pieniędzy <br /> do 60 dni od zakupu!'); ?></p>
        </div>
    </div>
</section>

<section class="vip">
    <h2><? echo langs('Przejdź na'); ?> <span>VIP</span></h2>
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <div class="lightblue">
                <div class="naglowek">
                    <h3>25<span>PLN/mo</span></h3>
                </div>
                <div class="srodek">
                    <span>month</span>
                </div>
                <div class="dol">
                    <button><? echo langs('Kupuję'); ?><img src="img/platnosc/kosz.png" alt="koszyk1" /></button>
                    <p><? echo langs('75 zł'); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xs-12">
            <div class="green">
                <div class="naglowek">
                    <h3>25<span>PLN/mo</span></h3>
                </div>
                <div class="srodek">
                    <span><? echo langs('3 miesiące'); ?></span>
                    <img src="img/platnosc/kokarda.png" alt="kokarda"/>
                </div>
                <div class="dol">
                    <button><? echo langs('Kupuję'); ?><img src="img/platnosc/kosz.png" alt="koszyk1" /></button>
                    <p><? echo langs('75 zł'); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xs-12">
            <div class="blue">
                <div class="naglowek">
                    <h3>25<span>PLN/mo</span></h3>
                </div>
                <div class="srodek">
                    <span><? echo langs('rok'); ?></span>
                </div>
                <div class="dol">
                    <button><? echo langs('Kupuję'); ?><img src="img/platnosc/kosz.png" alt="koszyk1" /></button>
                    <p><? echo langs('300zł'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>