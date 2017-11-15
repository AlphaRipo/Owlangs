<div id="nav_bok">
    <!-- PROFIL -->
    <div class="profil">
        <div class="cont1">
            <label>
                <input type="checkbox" name="checkboxName" class="checkbox" />
                <span class="switch"></span>
            </label>
            <span><? echo langs("Korepetytor"); ?></span>
        </div>
        <div class="cont2">
            <img src="img/strona_glowna/twarz1_big.png" class="img-responsive" alt="user" />
        </div>
    </div>

    <!-- MENU BOCZNE -->

    <div class="menu">
        <ul>
        <li data-toggle="tooltip" data-placement="top" data-original-title="wall with all posts"><a href="glowna.php"><p><i class="fa fa-newspaper-o"></i> <? echo langs("Wall"); ?></p></a></li>
        <li data-toggle="tooltip" data-placement="top" data-original-title="wall with only my posts"><a href="konto.php?id=<?php echo $user_id; ?>"><p><i class="fa fa-newspaper-o"></i> <? echo langs("My"); ?></p></a></li>
        <li data-toggle="tooltip" data-placement="top" data-original-title="my profile"><a href="profil.php?id=<?php echo $user_id; ?>"><p><i class="fa fa-user"></i> <? echo langs("Profile"); ?></p></a></li>
        <li data-toggle="tooltip" data-placement="top" data-original-title="all trainings"><a href="szkolenia.php?id=<?php echo $user_id; ?>"><p><i class="fa fa-graduation-cap"></i> <? echo langs("Trainings"); ?></p></a></li>
        <li data-toggle="tooltip" data-placement="top" data-original-title="my calendar"><a href="kalendarz.php?id=<?php echo $user_id; ?>"><p><i class="fa fa-calendar"></i> <? echo langs("Calendar"); ?></p></a></li>
        <li data-toggle="tooltip" data-placement="top" data-original-title="all auctions"><p><i class="fa fa-money"></i> <? echo langs("Auctions"); ?></a></li>
        <li data-toggle="tooltip" data-placement="top" data-original-title="my friends" data-toggle="tooltip" data-placement="top" data-original-title="post publiczny"><a href="znajomi.php?id=<?php echo $user_id; ?>"><p><i class="fa fa-users"></i> <? echo langs("Friends"); ?></p></a></li>
        <li data-toggle="tooltip" data-placement="top" data-original-title="words in my dictionary"><a href="sow_cw.php?id=<?php echo $user_id; ?>"><p><i class="fa fa-briefcase"></i> <? echo langs("Dictionary"); ?></p></a></li>
        </ul>
    </div>
</div>