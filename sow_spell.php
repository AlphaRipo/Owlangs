<?php require_once("ajax/db.php"); ?>

<!-- Zawartość zakładek -->
<div class="tab-content cn-right">
    <div id="sownik" class="row">
        <div class="navigacja col-xs-12 nopadding">
        <? require_once 'parts/menuWords.php'; ?>
        </div>

        <div class="test_name col-xs-12 nopadding">
            <p>&#8594; English upstream C2 Voc. test 2</p>
        </div>

        <div class="audio col-xs-12">
             <div class="styled-select col-md-4 col-xs-6 nopadding">
                    <select>
                        <option>Speak English very fast</option>
                        <option>Speak English fast</option>
                        <option>Speak English slowly</option>
                    </select>
             </div>
             <div class="col-md-5 col-xs-6 nopadding">
                <button>Reply audio</button>
             </div>
        </div>

        <div class="zagadka col-xs-12">
            <p>To lay the foundations</p>
        </div>
        <div class="odpowiedz col-xs-12">
            <input role="textbox">
        </div>
    </div>
</div>
