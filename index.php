<?php require_once("ajax/db.php");

    // I catch the recommendation link
    $testArray = array($_SERVER['HTTP_HOST']);
    foreach($testArray as $k => $v) {
        $_RECOMENDEDBY = extract_subdomains($v);
        if($_RECOMENDEDBY) {
            
            global $db; // bez też działało ???
            if($stmt = $db->prepare(" select id from users where www = ? "))
            {
                $stmt->bindValue(1, $_RECOMENDEDBY, PDO::PARAM_STR);
                $stmt->execute();
                $uid =  $stmt->fetchColumn();
                $stmt->closeCursor();
                if($uid) {
                    setcookie("redomendedby",$uid,time()+(3600*24*365), "/", ".owlangs.com", 0, true);
                }
                header('Location: http://owlangs.com');
            }
        }
    }
    function extract_domain($domain) {
        if(preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $domain, $matches)) { return $matches['domain']; } 
        else { return $domain; }
    }
    function extract_subdomains($domain) {
        $subdomains = $domain;
        $domain = extract_domain($subdomains);
        $subdomains = rtrim(strstr($subdomains, $domain, true), '.');
        return $subdomains;
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Sowa językowa</title>
    <meta name="description" content="Serwis nauki języków obcych..." />
    <meta name="keywords" content="nauka, angielski, języki obce, tłumaczenia" />
    <meta name="author" content="CANGARIS LTD | <? echo $_COOKIE['redomendedby']; ?>">

    <link href='http://fonts.googleapis.com/css?family=Lato:400,700&subset=latin-ext' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Marck+Script&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    <link href="css/modal.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/html5reset-1.6.1.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="favicon.png" rel="shortcut icon">
    
    <!--<link rel="stylesheet" type="text/css" href="css/media-queries.css">-->

    <script src="js/jquery-2.2.4.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/modal.min.js"></script>
    <script src="js/bootbox.min.js"></script>
    <script src="js/md5.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
    <script src="https://apis.google.com/js/api:client.js"></script>
    <style>.dispInline{display:inline;}</style>

    <script>
        
        // ====================================

        if(JSON.parse(localStorage.getItem("OwLangsUserData"))) { window.location.href = '//owlangs.com/wall'; }

        // ====================================

        var recommendation = '<?php echo (isset($_COOKIE['redomendedby'])) ? $_COOKIE['redomendedby'] : "0"; ?>';

        // ==================================== GOOGLE+ ====================================

        var googleUser = {};
        var startApp = function() {
            gapi.load('auth2', function() {
                auth2 = gapi.auth2.init({
                    client_id: '380112825951-clugaqvti6dgsrq2ne9v9pfuag6fk7vh.apps.googleusercontent.com',
                    cookiepolicy: 'single_host_origin'
                });
                attachSignin(document.getElementById('customBtn1'));
                attachSignin(document.getElementById('customBtn2'));
                attachSignin(document.getElementById('customBtn3'));
            });
        };

        function attachSignin(element) {
            console.log(element.id);
            auth2.attachClickHandler(element, {},
            function(googleUser) { // $('.name').text("Witaj " + googleUser.getBasicProfile().getName());
                var o = googleUser.getBasicProfile();
                console.log(o);

                $.post("ajax/registerBySocial.php", { 
                    from : 'GP', 
                    first : o.getGivenName(), 
                    last : o.getFamilyName(),
                    email : o.getEmail(), 
                    id : o.getId(),
                    recommendation : recommendation
                }, function(data) {
                    if(data) {
                        console.log(data);
                        localStorage.setItem("OwLangsUserData",JSON.stringify(data));
                        window.location.href = "/wall";
                    }
                    console.log(o);
                },'json');

            }, function(error) {
                console.log(JSON.stringify(error, undefined, 2));
            });
        }

        // ================================================================================

    </script>

</head>
<body>
    
    <!-- Zawartość zakładek -->
    <header>
        <a href="/index">
            <div id="logo">
                <h1 class="hidden">SowaJęzykowa.pl</h1>
            </div>
        </a>

        <div id="logowanie">
            <ul>
                <li>pl</li>
                <li><a href="/login"><? echo langs("Zasowuj się"); ?></a></li>
            </ul>
        </div>
    </header>

    <div class="clear"></div>

    <section id="faces">

        <h2 class="hidden">Użytkownicy</h2>
        <ul>
            <li><img src="img/strona_glowna/twarz1.png" alt="avatar1" /></li>
            <li><img src="img/strona_glowna/twarz2.png" alt="avatar2" /></li>
            <li><img src="img/strona_glowna/twarz3.png" alt="avatar3" /></li>
            <li><img src="img/strona_glowna/twarz4.png" alt="avatar4" /></li>
            <li><img src="img/strona_glowna/twarz5.png" alt="avatar5" /></li>
            <li><img src="img/strona_glowna/twarz6.png" alt="avatar6" /></li>
            <li><img src="img/strona_glowna/twarz1.png" alt="avatar1" /></li>
            <li><img src="img/strona_glowna/twarz2.png" alt="avatar2" /></li>
            <li class="none750"><img src="img/strona_glowna/twarz3.png" alt="avatar3" /></li>
            <li class="none750"><img src="img/strona_glowna/twarz4.png" alt="avatar4" /></li>
            <li class="none970"><img src="img/strona_glowna/twarz5.png" alt="avatar5" /></li>
            <li class="none970"><img src="img/strona_glowna/twarz6.png" alt="avatar6" /></li>
        </ul>
    </section>

    <section id="banner">
        <div class="wrapper">
            <h2 class="hidden">Schemat nauki</h2>

            <div id="e-learning">
                <img id="schemat" src="img/strona_glowna/schemat_nauki2.png" alt="schemat nauki" />
                <span id="tlumacz"><? echo langs("tłumacz"); ?></span>
                <span id="ucz1"><? echo langs("ucz się i nauczaj"); ?></span>
                <span id="zdobywaj"><? echo langs("zdobywaj nagrody"); ?></span>
                <span id="takich"><? echo langs("takich jak Ty"); ?></span>
            </div>

            <div id="dolacz">
                <img id="chmura" src="img/strona_glowna/sowachmura2.png" alt="chmura" />

                <h3><? echo langs("Uhu! Uhu!"); ?></h3>
                <p><span><? echo langs("Dołącz do klubu <br> pasjonatów angielskiego!</span> <br> Dziś się zarejestrujesz 30 dni VIP <br>zyskujesz"); ?></span></p>

                <div id="formularz">

                    <button class="loginBtn facebook">
                        <img src="img/strona_glowna/facebook.png" alt="fb" />
                        <span><? echo langs("Wejdź przez Facebook"); ?></span>
                    </button>
                    <!-- <div class="response"></div> -->

                    <div class="gSignInWrapper">
                        <button id='customBtn1' class="google customGPlusSignIn"><img src="img/strona_glowna/gplus.png" alt="google plus" /><span><? echo langs("Wejdź przez Google+"); ?></span></button>
                    </div>
                    <!-- <div class="name"></div> -->

                    <span><? echo langs("lub"); ?></span>
                    <div class='form'>
                        <input id="imie" required placeholder="Wpisz swoje imię">
                        <input id="email" tyle='email' required placeholder="Wpisz swój e-mail">
                        <input type="password" required id="haslo" placeholder="Wpisz swoje hasło">
                        <button class="btn btn-100 register"><? echo langs("ZAREJESTRUJ SIĘ"); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="clear"></div>

    <section id="film">
        <div class="wrapper">
            <div class="col1">
                <ul>
                    <li><img id="ico1" src="img/strona_glowna/ico1.png" alt="nauka" /><? echo langs("Ucz się i nauczaj"); ?></li>
                    <li><img id="ico4" src="img/strona_glowna/ico4.png" alt="nauka" /><? echo langs("Szlifuj język"); ?></li>
                    <li><img id="ico7" src="img/strona_glowna/ico7.png" alt="nauka" /><? echo langs("Zdobywaj nagrody"); ?></li>
                </ul>
            </div>
            <div class="col2">
                <ul>
                    <li><img id="ico2" src="img/strona_glowna/ico2.png" alt="nauka" /><? echo langs("Twórz autorskie kursy językowe"); ?></li>
                    <li><img id="ico5" src="img/strona_glowna/ico5.png" alt="nauka" /><? echo langs("Poznawaj ludzi takich jak Ty"); ?></li>
                    <li><img id="ico8" src="img/strona_glowna/ico8.png" alt="nauka" /><? echo langs("Pnij się po szczeblach rankingu"); ?></li>
                </ul>
            </div>
            <div class="col3">
                <ul>
                    <li><img id="ico3" src="img/strona_glowna/ico3.png" alt="nauka" /><? echo langs("Pomagaj i proś o pomoc"); ?></li>
                    <li><img id="ico6" src="img/strona_glowna/ico6.png" alt="nauka" /><? echo langs("Tłumacz teksty"); ?></li>
                    <li><img id="ico9" src="img/strona_glowna/ico9.png" alt="nauka" /><? echo langs("Zarabiaj na swoich umiejętnościach"); ?></li>
                </ul>
            </div>

            <div class="clear"></div>

            <h2><? echo langs("<span>Zostań sową językową</span> i baw się jak nigdy w życiu!"); ?></h2>

            <video controls poster="img/strona_glowna/video_poster.jpg">
                <source src="movie.mp4" type="video/mp4">
                <source src="movie.ogg" type="video/ogg">
                Your browser does not support the video tag.
            </video>
        </div>
    </section>

    <section id="wydarzenia">
        <div class="wrapper">

            <div class="wyd">
                <img src="img/strona_glowna/twarz1_square.png" />
                <p>Sowa "Marek właśnie zadał pytanie"</p> <br />
                <span>35 sekund temu</span>
            </div>
            <div class="wyd">
                <img src="img/strona_glowna/twarz2_square.png" />
                <p>Sowa Julia właśnie stworzyła nowy kurs</p><br />
                <span>3 minuty temu</span>
            </div>
        </div>
    </section>

    <section class="rejestracja">
        <div class="wrapper">

            <span><? echo langs("Uhu, Uhu!"); ?></span>
            <h2><? echo langs("Dziś się zarejestrujesz, od sowy 30 darmowych dni <br> <span>zyskujesz!!!</span>"); ?></h2>

            <button class="loginBtn facebook">
                <img src="img/strona_glowna/facebook.png" alt="fb" />
                <span><? echo langs("Wejdź przez Facebook"); ?></span>
            </button>
            <!-- <div class="response"></div> -->

            <div class="dispInline gSignInWrapper">
                <button id='customBtn2' class="google customGPlusSignIn"><img src="img/strona_glowna/gplus.png" alt="google plus" /><span><? echo langs("Wejdź przez Google+"); ?></span></button>
            </div>
            <!-- <div class="name"></div> -->

            <br />
            <span class="styl"><? echo langs("lub"); ?></span>

            <div>
                <input id="imie" required placeholder="<? echo langs("Wpisz swoje imię"); ?>">
                <input id="email" tyle='email' required placeholder="<? echo langs("Wpisz swój e-mail"); ?>">
                <input type="password" required id="haslo" placeholder="<? echo langs("Wpisz swoje hasło"); ?>">
                <button class="btn btn-100 register"><? echo langs("ZAREJESTRUJ SIĘ"); ?></button>
			</div>

            <div class="rozwijany">
                <p><? echo langs("To wszystko wygląda zbyt dobrze, by było prawdziwe? Zdajemy sobie sprawę, że Internet roi się od oszustw i możesz mieć wątpliwości. Dlatego robimy coś, czego nie zrobił jeszcze nikt inny - dajemy Ci rozbudowaną wersję darmową oraz aż 30 dni darmowego korzystania z wersji płatnej..."); ?></p>
                <p class="paragraf ukryty"><? echo langs("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur."); ?></p>
                <span class="rozwin detal"><? echo langs("rozwiń"); ?></span>
            </div>
        </div>
    </section>

    <section id="wiadomosci">
        <h2 class="hidden"><? echo langs("Informacje o serwisie"); ?></h2>

        <section class="info1">
            <div class="wrapper">
                <div class="kol1">

                </div>

                <div class="kol2">
                    <h3><? echo langs("Pierwsze na świecie"); ?></h3>
                    <span>
                        <? echo langs("kursy online tworzone dla Ciebie<br>INDYWIDUALNIE!!!"); ?>
                    </span>
                    <div class="beleczka"></div>
                    <p>
                        <? echo langs("Zapomnij o masowych kursach elearningowych, które nijak się mają do Twoich potrzeb. Korepetytorzy sowiej społeczności będą tworzyć specjalnie dla Ciebie tylko te szkolenia i zadania do wykonania, które są Ci w danej chwili najbardziej potrzebne."); ?>
                    </p>
                    <p><? echo langs("Te rewolucyjne podejście jest możliwe dzięki zaawansowanym narzędziom do kreacji szkoleń oraz metodom badania profilu ucznia udostępnionej każdemu korepetytorowi. Dzięki temu Twoja nauka stanie się szybsza. efektywniejsza i przyjemniejsza."); ?></p>
                </div>
            </div>
        </section>

        <div class="clear"></div>

        <section class="info2">
            <div class="wrapper">
                <div class="kol1">
                    <img id="smartphone" src="img/strona_glowna/smartphone.jpg" alt="smartphone" />
                </div>

                <div class="kol2">
                    <h3><? echo langs("JESTEŚ ZABIEGANY I NIE MASZ <br> CZASU NA NAUKĘ?"); ?></h3>
                    <span><? echo langs("Koniec wymówek! Zmieniamy <br> drobne luki w Twoim planie dnia na <br> nowe umiejętności językowe!!!"); ?></span>
                    <div class="beleczka"></div>
                    <p><? echo langs("Kalendarz korepetycji, pozwoli Ci planować czas na naukę i dostosować do Twoich zajęć. Wypadło Ci ważne spotkanie i wiesz że popołudniu będziesz mieć 30 min wolnego czasu? Kilka kliknięć i któryś z korepetytorów przygotuje Ci kolejne zadanie do wykonania dokładnie o tej porze.  Brak czasu już nigdy nie będzie dla Ciebie wymówką!"); ?></p>
                </div>
            </div>
        </section>

        <div class="clear"></div>

        <section class="info3">
            <div class="wrapper">

                <div class="kol1">
                    <h3><? echo langs("Szukasz korepetytora"); ?>,</h3>
                    <span><? echo langs("ale boisz się że trafisz na niewłaściwego, <br /> tracąc czas i pieniądze?"); ?></span>

                    <div class="beleczka"></div>
                    <p><? echo langs("Unikatowa wyszukiwarka korepetytorów - pozwoli Ci znaleźć dokładnie takiego nauczyciela jakiego potrzebujesz. Jesteś dobry z gramatyki, ale masz problem z mówieniem - zaznaczasz to w wyszukiwarce i gotowe. Możesz prześledzić ich certyfikaty, filmy, szkolenia, a nawet całą historię pomocy innym, dzięki czemu już nigdy nie zmarnujesz pieniędzy na kota w worku."); ?></p>
                </div>

                <div class="kol2">
                    <img id="tablet_short" src="img/strona_glowna/tablet_short.png" alt="tablet" />
                </div>
            </div>
        </section>

        <div class="clear"></div>

        <section class="info4">
            <div class="wrapper">
                <div class="kol1">
                    <img id="tablet_long" src="img/strona_glowna/tablet_long.png" alt="tablet" />
                </div>

                <div class="kol2">
                    <h3><? echo langs("Jest poniedziałek 7 rano"); ?></h3>
                    <span><? echo langs("i właśnie Ci się przypomniało że za godzinę <br> musisz przygotować prezentację na angielski, <br> o której na śmierć zapomniałeś? <br> Nie bój żaby! Sowa językowa uratuje Cię z opałów!"); ?></span>
                    <div class="beleczka"></div>
                    <p><? echo langs("Sowi system aukcyjny pozwoli Ci pokonać mission impossible. Po prostu wrzucasz na aukcję temat zadania i ustawiasz maksymalny czas wykonania oraz proponowaną zapłatę za usługę. Sowy to stworzenia nocne, pomogą Ci nawet wtedy kiedy śpisz."); ?></p>
                    <p><? echo langs("Nieważne czy chodzi o opowiadanie o zeszłych wakacjach, czy tłumaczenie tekstu prawniczego - społeczność sów językowych działa o wiele szybciej niż pojedynczy korepetytorzy, tłumacze  czy szkoły jężykowe."); ?></p>
                </div>
            </div>
        </section>
    </section>

    <div class="clear"></div>

    <section id="komentarze">
        <div class="wrapper">
            <h2 class="hidden"><? echo langs("Komentarze"); ?></h2>

            <div id="fisrtcomm" class="comment">
                <img src="img/strona_glowna/twarz1_big.png" alt="avatar3" />
                <p><? echo langs("Nigdy nie lubiłem się uczyć angielskiego. Do czasu odkrycia sowy językowej, gdzie mogę wypełniać pasjonujące questy i zadania jak w rasowej grze RPG"); ?></p>
                <span><? echo langs("Adam, nauczyciel"); ?></span>
            </div>

            <div class="comment">
                <img src="img/strona_glowna/twarz2_big.png" alt="avatar4" />
                <p><? echo langs("Szczerze mówiąc, nie wierzyłem, że w jednym miejscu rozwiąże wszystkie swoje problemy językowe. Po pierwszym logowaniu prawda okazała się lepsza od obietnic."); ?></p>
                <span><? echo langs("Adam, barman"); ?></span>
            </div>

            <div class="comment">
                <img src="img/strona_glowna/twarz1_big.png" alt="avatar3" />
                <p><? echo langs("Nigdy nie lubiłem się uczyć angielskiego. Do czasu odkrycia sowy językowej, gdzie mogę wypełniać pasjonujące questy i zadania jak w rasowej grze RPG"); ?></p>
                <span><? echo langs("Adam, nauczyciel"); ?></span>
            </div>

            <div class="comment none750">
                <img src="img/strona_glowna/twarz2_big.png" alt="avatar4" />
                <p><? echo langs("Szczerze mówiąc, nie wierzyłem, że w jednym miejscu rozwiąże wszystkie swoje problemy językowe. Po pierwszym logowaniu prawda okazała się lepsza od obietnic."); ?></p>
                <span><? echo langs("Adam, barman"); ?></span>
            </div>
        </div>
    </section>

    <div class="clear"></div>

    <section id="czarny" class="rejestracja">
        <div class="wrapper">

            <span><? echo langs("Uhu, Uhu!"); ?></span>
            <h2><? echo langs("Dziś się zarejestrujesz, od sowy 30 darmowych dni zyskujesz!!!"); ?></h2>

            <button class="loginBtn facebook">
                <img src="img/strona_glowna/facebook.png" alt="fb" />
                <span><? echo langs("Wejdź przez Facebook"); ?></span>
            </button>
            <!-- <div class="response"></div> -->

            <div class="dispInline gSignInWrapper">
                <button id='customBtn3' class="google customGPlusSignIn"><img src="img/strona_glowna/gplus.png" alt="google plus" /><span><? echo langs("Wejdź przez Google+"); ?></span></button>
            </div>
            <!-- <div class="name"></div> -->

            <br />
            <span class="styl"><? echo langs("lub"); ?></span>

            <div>
                <input id="imie" required placeholder="<? echo langs("Wpisz swoje imię"); ?>">
                <input id="email" tyle='email' required placeholder="<? echo langs("Wpisz swój e-mail"); ?>">
				<input type="password" required id="haslo" placeholder="<? echo langs("Wpisz swoje hasło"); ?>">
                <button class="btn btn-100 register"><? echo langs("ZAREJESTRUJ SIĘ"); ?></button>
			</div>

            <div class="rozwijany">
                <p><? echo langs("To wszystko wygląda zbyt dobrze, by było prawdziwe? Zdajemy sobie sprawę, że Internet roi się od oszustw i możesz mieć wątpliwości. Dlatego robimy coś, czego nie zrobił jeszcze nikt inny - dajemy Ci rozbudowaną wersję darmową oraz aż 30 dni darmowego korzystania z wersji płatnej..."); ?></p>
                <p class="paragraf ukryty"><? echo langs("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur."); ?></p>
                <span class="rozwin detal"><? echo langs("rozwiń"); ?></span>
            </div>
        </div>
    </section>

    <footer>
        <div class="wrapper">
            <h2 class="hidden"><? echo langs("Podsumowanie"); ?></h2>
            <nav>
                <h3 class="hidden"><? echo langs("Nawigacja"); ?></h3>

                <ul>
                    <li><a href="/privacy-policy"><? echo langs("POLITYKA PRYWATNOŚCI"); ?></a></li>
                    <li><a href="/terms-and-conditions"><? echo langs("REGULAMIN"); ?></a></li>
                    <li><a href="#"><? echo langs("O NAS"); ?></a></li>
                    <li><a href="#"><? echo langs("POMOC"); ?></a></li>
                    <li><a href="#"><? echo langs("FAQ"); ?></a></li>
                    <li><a href="#"><? echo langs("DODAJ DO CHROME"); ?></a></li>
                    <li><a href="/contact"><? echo langs("KONTAKT"); ?></a></li>
                </ul>
            </nav>

            <ul id="social">
                <li><a href="#"><img src="img/strona_glowna/fb_ico.jpg" alt="facebook ico" /></a></li>
                <li><a href="#"><img src="img/strona_glowna/twitter_ico.jpg" alt="twitter ico" /></a></li>
                <li><a href="#"><img src="img/strona_glowna/yt_ico.jpg" alt="youtube ico" /></a></li>
            </ul>

            <span>&copy UI8 2015 - SowaJezykowa.pl</span>
        </div>
    </footer>

    <!--<script src="js/script.js"></script>-->
    
    <script type="text/javascript">
        
        startApp();
        var recommendation = '<?php echo (isset($_COOKIE['redomendedby'])) ? $_COOKIE['redomendedby'] : "0"; ?>';

         // ==================================== FACEBOOK ====================================

        function getUserData() {
            FB.api('/me', 'get', { fields: 'id,name,first_name,last_name,email' }, function(response) { //$('.response').html('Witaj ' + response.name);
                $.post("ajax/registerBySocial.php", { 
                    from : 'FB', 
                    first : response.first_name, 
                    email : response.email, 
                    last : response.last_name, 
                    id : response.id,
                    recommendation : recommendation
                }, function( data ) { // https://developers.facebook.com/docs/graph-api/reference/v2.5/user // to jest spis pól
                    if(data) {
                        console.log(data);
                        localStorage.setItem("OwLangsUserData",JSON.stringify(data));
                        window.location.href = "/wall";
                    }
                    console.log(response);
                },'json');
            });
        }

        window.fbAsyncInit = function() {
            FB.init({
                appId : '774069559369509',
                xfbml : true,
                cookie : true, 
                version : 'v2.5'
            });
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {} else {}
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/pl_PL/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        $('.loginBtn').on('click', function() {
            FB.login(function(response) {
                if (response.authResponse) { //$('.loginBtn').hide();
                    getUserData();
                }
            }, {scope: 'email,public_profile', return_scopes: true});
        });

        // ================================================================================

        $("button.register").click(function() { 
            var div = $(this).closest('div');
            var login = div.find('#imie').val();
            var email = div.find('#email').val();
            if(isEmail(email)) {
                var passwd = div.find('#haslo').val();
                if(login && email && passwd) {
                    $.post("ajax/registerByEmail.php", { recommendation : recommendation, imie : login, email : email, haslo : md5(passwd) 
                    }, function(data) {
                        if(data) {
                            console.log(data);
                            localStorage.setItem("OwLangsUserData",JSON.stringify(data));
                            bootbox.alert('<? echo langs("Aby się zalogować, musisz aktywować konto linkiem aktywacyjnym, który został wysłany na Twojego e-maila."); ?>');
                        }
                    },'json');
                }
                else bootbox.alert('<? echo langs("Pssst! Żeby działało musisz wpisać wszystkie dane! :)"); ?>'); 
            }
            else bootbox.alert('<? echo langs("Wpisałeś zły email, sprawdź i popraw... :)"); ?>'); 
        });

        // ================================================================================

        function isEmail(str) { return str.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,15}$/); }

    </script>

</body>
</html>
