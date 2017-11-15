<?php require_once("ajax/db.php");

    if(isset($_GET['code']) AND isset($_GET['user'])) {
        $code = $_GET['code'];
        $user = $_GET['user'];
        
        global $db;
        if($stmt = $db->prepare("select count(id) from users where code = ? and id = ?")) {
            
            $stmt->bindValue(1, $code, PDO::PARAM_STR);
            $stmt->bindValue(2, $user, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            $stmt->closeCursor();

            if($count > 0) {
                if($stmt = $db->prepare("update users set confirmed = 1 where code = ? and id = ?")) {
                    
                    $stmt->bindValue(1, $code, PDO::PARAM_STR);
                    $stmt->bindValue(2, $user, PDO::PARAM_STR);
                    $stmt->execute();
                    $stmt->closeCursor();
                    $confirmed = true;
                }
            }
        }
    }
    
    // I catch the recommendation link
    $testArray = array($_SERVER['HTTP_HOST']);
    foreach($testArray as $k => $v) {
        $_RECOMENDEDBY = extract_subdomains($v);
        if($_RECOMENDEDBY) {

            global $db;
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
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>OwLangs.com</title>
    <meta name="description" content="Portal społecznościowy do nauki języka angielksiego" />
    <meta name="keywords" content="Portal społecznościowy do nauki języka angielksiego" />
    <meta name="author" content="CANGARIS LTD | <? echo $_COOKIE['redomendedby']; ?>">

    <link href='http://fonts.googleapis.com/css?family=Lato:400,700&subset=latin-ext' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Marck+Script&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/html5reset-1.6.1.css">
    <link rel="stylesheet" type="text/css" href="css/media-queries.css">
    <link rel="stylesheet" type="text/css" href="css/style_m.css">
    <link href="css/modal.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.alert.min.css" rel="stylesheet" type="text/css">
    <link href="favicon.png" rel="shortcut icon">

    <style>
        #black h4, #black h3 { color:#fff; }
    </style>
    
    <script src="js/jquery-2.2.4.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/modal.min.js"></script>
    <script src="js/bootbox.min.js"></script>
    <script src="js/md5.min.js"></script>
    <script src="https://apis.google.com/js/api:client.js"></script>

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
                attachSignin(document.getElementById('customBtn'));
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
    <header>
        <a href="/login">
            <div id="logo">
                <h1 class="hidden">SowaJęzykowa.pl</h1>
            </div>
        </a>
    </header>

    <section id="logowanie">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <h2 class="hidden">Logowanie do serwisu</h2>

                    <button class="aplikacja"><? echo langs("Pobierz aplikację mobilną"); ?></button>
                </div>
            </div>
            
            <div style="margin-top:40px;" class="row">
                <div class="col-xs-12">
                    <?php if($confirmed) { ?>
                        <div class="alert alert-success"><strong><? echo langs("Ok, konto zostało aktywowane, możesz się zalogować!"); ?></strong></div>
                    <?php } ?>
                </div>
            </div>

            <div class="row">

                <div id="formularz">
                    <span class="ukryty"><? echo langs("Wejdź przez"); ?></span>
                    <div class="col-xs-6">
                        <button class="loginBtn facebook">
                            <img src="img/strona_glowna/facebook.png" alt="fb" />
                            <span class="pokazany"><? echo langs("Wejdź przez"); ?></span>
                        </button>
                    </div>
                    <div class="dispInline gSignInWrapper col-xs-6">
                        <button id='customBtn' class="google customGPlusSignIn">
                            <span class="pokazany"><? echo langs("Wejdź przez"); ?></span>
                            <img src="img/strona_glowna/gplus.png" alt="google plus" />
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <h3><? echo langs("Zaloguj się"); ?></h3>
                        <form>
                            <input id="email" type="email" placeholder="<? echo langs("Wpisz swój e-mail"); ?>">
                            <input id="haslo" type="password" placeholder="<? echo langs("Wpisz swoje hasło"); ?>">
                            <button id="log_btn" class="btn2"><? echo langs("ZALOGUJ"); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="black">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h3><? echo langs("Pierwsze na świecie"); ?></h3>
                    <h4><? echo langs("kursy online tworzone dla Ciebie <br> INDYWIDUALNIE!!!"); ?></h4>
                    <p><? echo langs("Zapomnij o masowych kursach elearningowych, które nijak się mają do Twoich potrzeb. Korepetytorzy sowiej społeczności będą tworzyć specjalnie dla Ciebie tylko te szkolenia i zadania do wykonania, które są Ci w danej chwili najbardziej potrzebne."); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="rejestracja">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <h2 class="hidden">Zarejestruj się</h2>

                    <a href="/wall"><button><? echo langs("Zarejestruj się"); ?></button></a>
                    <span><? echo langs("i ucz się wybranego języka"); ?></span>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="hidden">Podsumowanie</h2>
                    <nav>
                        <h3 class="hidden">Nawigacja</h3>
                        <ul>
                            <li><a href="#"><? echo langs("POLITYKA PRYWATNOŚCI"); ?></a></li>
                            <li><a href="#"><? echo langs("REGULAMIN"); ?></a></li>
                            <li><a href="#"><? echo langs("FAQ"); ?></a></li>
                        </ul>
                    </nav>

                    <ul id="social">
                        <li><a href="#"><img src="img/strona_glowna/fb_ico.jpg" alt="facebook ico" /></a></li>
                        <li><a href="#"><img src="img/strona_glowna/twitter_ico.jpg" alt="twitter ico" /></a></li>
                        <li><a href="#"><img src="img/strona_glowna/yt_ico.jpg" alt="youtube ico" /></a></li>
                    </ul>

                    <span>&copy UI8 2015 - SowaJezykowa.pl</span>
                </div>
            </div>
        </div>
    </footer>

</body>

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

        $("input#haslo, input#email").keypress(function(e) {
            if(e.which === 13) { login($(this)); }
        });
        $("button#log_btn").click(function() { login($(this)); });
        
        function login(o) {
            var div = o.closest('div');
            var email = div.find('input#email').val();
            if(isEmail(email)) {
                var passwd = div.find('input#haslo').val();
                if(email && passwd) {
                    $.post("ajax/login.php", { email : email, haslo : md5(passwd) }, function(data)
                    { 
                        if(data.status === "CONFIRM") bootbox.alert('<? echo langs("Ok, a teraz, zaloguj się na pocztę i aktywuj konto ^^"); ?>');
                        if(data.status === "PASS") bootbox.alert('<? echo langs("Błędne dane logowania, popraw login lub hasło..."); ?>');
                        if(data.status === "NONE") bootbox.alert('<? echo langs("Ups! Nie ma takiego użytkownika :)"); ?>');
                        if(data.status === "OK" && data.user) {
                            localStorage.setItem("OwLangsUserData",JSON.stringify(data.user));
                            window.location.href = '/wall';
                        }
                    },'json');
                }
                else bootbox.alert('<? echo langs("Pssst! Żeby działało musisz wpisać wszystkie dane! :)"); ?>'); 
            }
            else bootbox.alert('<? echo langs("Wpisałeś zły email, sprawdź i popraw... :)"); ?>'); 
        }

        // ================================================================================

        function isEmail(str) { if(str) return str.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,15}$/); }

</script>

</html>
