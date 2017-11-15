<?php
ob_start();
require_once("ajax/db.php");

// Sprawdzenie czy zalogowany
if(!isset($_SESSION['login']) AND !isset($_SESSION['password'])) 
{
    if(isset($_COOKIE['login']) && isset($_COOKIE['password'])) 
	{
        $_SESSION['login'] = $_COOKIE['login'];
        $_SESSION['password'] = $_COOKIE['password'];
		header('Location: glowna.php');
    }
}
else
{
	header('Location: glowna.php');
}
// ------------------------------

if(isset($_POST['btn_reg1']))
{
	$reg1_imie = $_POST['imie'];
	$reg1_email = $_POST['email'];
	$reg1_haslo = md5($_POST['haslo']);
	$reg1_avatar = 'img/avatar/default.jpg';
		
	$zapytanie=mysql_query("SELECT COUNT(id) FROM users WHERE email='$$reg1_email'");
	$ile=mysql_result($zapytanie, 0, 0);

	if($ile == 0)
	{
		mysql_query("INSERT INTO `users` (`imie`, `nazwisko`, `vip`, `haslo`, `email`, `avatar`) VALUES('$reg1_imie','','1','$reg1_haslo','$reg1_email','$reg1_avatar')") or die("Nie mogłem dodać użytkownika!");
	}
	else
	{
		echo '<h2>Konto o podanym adresie e-mail już istnieje.</h2>';
	}
}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	
    <meta charset = "utf-8"/>
	<title>Sowa językowa</title>
	<meta name = "description" content ="Serwis nauki języków obcych..."/>
	<meta name ="keywords" content = "nauka, angielski, języki, tłumaczenia"/>
    
    
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700&subset=latin-ext' rel='stylesheet' type='text/css'>
    
    <link rel="stylesheet" type="text/css" href="css/html5reset-1.6.1.css">
    <link rel="stylesheet" type="text/css" href="css/style_b.css">
	<link rel="stylesheet" type="text/css" href="css/media-queries.css">
    
   	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
   
 
</head>

<body>

	<header>
    	<a href="#"><div id="logo">
        	<h1 class="hidden">SowaJęzykowa.pl</h1>
        </div></a>
        
        <div id="logowanie">
            <ul>
                <li>pl</li>
                <li><a href="index_m.php"><? echo langs("Zasowuj się"); ?></a></li>
            </ul>
    	</div>
    </header>
    
    <div class="clear"></div>

    <section id="banner">
    
    	
        	<div class="wrapper">
            	<h2 class="hidden">Schemat nauki</h2>
            
            	<div id="e-learning">
                	<img src="img/strona_glowna/schemat_nauki.png" alt="schemat nauki"/>
                </div>
                
                <div id="dolacz">
                	<img class="chmura" src="img/strona_glowna/sowachmura.png" alt="chmura" />
                    
                    
                    <div id="formularz">
                    	<button class="facebook"><img src="img/strona_glowna/facebook.png" alt="fb"/><span><? echo langs("Wejdź przez Facebook"); ?></span></button>
                        <button class="google"><img src="img/strona_glowna/gplus.png" alt="google plus"/><span><? echo langs("Wejdź przez Google+"); ?></span></button>
                        <span>lub</span>
                         <form method="post">
                            <input name="imie" placeholder="<? echo langs("Wpisz swoje imię"); ?>">
                            <input name="email" placeholder="<? echo langs("Wpisz swój e-mail"); ?>">
							<input type="password" name="haslo" placeholder="<? echo langs("Wpisz swoje hasło"); ?>">
                            <button name="btn_reg1" class="btn"><? echo langs("ZAREJESTRUJ SIĘ"); ?></button>
                         </form>
                    </div>
                </div>
       	   
        </div>
        
     </section>
     
     <div class="clear"></div>
     
     
     <section id="faces">
            
            	<h2 class="hidden">Użytkownicy</h2>
            	<ul>
                	<li><img src="img/strona_glowna/twarz1_b.png" alt="avatar1"/></li>
                    <li><img src="img/strona_glowna/twarz2_b.png" alt="avatar2"/></li>
                    <li><img src="img/strona_glowna/twarz3_b.png" alt="avatar3"/></li>
                    <li><img src="img/strona_glowna/twarz4_b.png" alt="avatar4"/></li>
                    <li><img src="img/strona_glowna/twarz5_b.png" alt="avatar5"/></li>
                    <li><img src="img/strona_glowna/twarz6_b.png" alt="avatar6"/></li>
                </ul>

    </section>
     
     <section id="film">
   		
             <div class="wrapper">
             	<div class="col1">
                    <ul>
                        <li><img src="img/strona_glowna/ico1.png" alt="nauka" /><? echo langs("Ucz się i nauczaj"); ?></li>
                        <li><img src="img/strona_glowna/ico4.png" alt="nauka" /><? echo langs("Szlifuj język"); ?></li>
                        <li><img src="img/strona_glowna/ico7.png" alt="nauka" /><? echo langs("Zdobywaj nagrody"); ?></li>
                    </ul>
                </div>
                <div class="col2">
                    <ul>
                        <li><img src="img/strona_glowna/ico2.png" alt="nauka" /><? echo langs("Twórz autorskie kursy językowe"); ?></li>
                        <li><img src="img/strona_glowna/ico5.png" alt="nauka" /><? echo langs("Poznawaj ludzi takich jak Ty"); ?></li>
                        <li><img src="img/strona_glowna/ico8.png" alt="nauka" /><? echo langs("Pnij się po szczeblach rankingu"); ?></li>
                    </ul>
                </div>
                <div class="col3">
                    <ul>  
                        <li><img src="img/strona_glowna/ico3.png" alt="nauka" /><? echo langs("Pomagaj i proś o pomoc"); ?></li>
                        <li><img src="img/strona_glowna/ico6.png" alt="nauka" /><? echo langs("Tłumacz teksty"); ?></li>
                        <li><img src="img/strona_glowna/ico9.png" alt="nauka" /><? echo langs("Zarabiaj na swoich umiejętnościach"); ?></li>
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
                    <p>Sowa "Marek właśnie zadał pytanie"</p> <br/>
					<span>35 sekund temu</span>
                </div>
                <div class="wyd">
                	<img src="img/strona_glowna/twarz2_square.png" />
                    <p>Sowa Julia właśnie stworzyła nowy kurs</p><br/>
					<span>3 minuty temu</span>
                </div>
                 
             </div>

     </section>
     
     <section class="rejestracja">
     	<div class="wrapper">	

        	<span><? echo langs("Uhu, Uhu!"); ?></span>
            <h2><? echo langs("Dziś się zarejestrujesz, od sowy 30 darmowych dni <br> <span>zyskujesz!!!</span>"); ?></h2>
            
            <button class="facebook"><img src="img/strona_glowna/facebook.png" alt="fb"/><span><? echo langs("Wejdź przez Facebook"); ?></span></button>
  			<button class="google"><img src="img/strona_glowna/gplus.png" alt="google plus"/><span><? echo langs("Wejdź przez Google+"); ?></span></button>
                <br/> 
            <span class="styl"><? echo langs("lub"); ?></span>
                   
            <form method="post">
                <input name="imie" placeholder="<? echo langs("Wpisz swoje imię"); ?>">
                <input name="email" placeholder="<? echo langs("Wpisz swój e-mail"); ?>">
				<input type="password" name="haslo" placeholder="<? echo langs("Wpisz swoje hasło"); ?>">
                <button name="btn_reg1" class="btn"><? echo langs("ZAREJESTRUJ SIĘ"); ?></button>
            </form>
            
            <div class="rozwijany">
            	<p><? echo langs("To wszystko wygląda zbyt dobrze, by było prawdziwe? Zdajemy sobie sprawę, że Internet roi się od oszustw i możesz mieć wątpliwości. Dlatego robimy coś, czego nie zrobił jeszcze nikt inny - dajemy Ci rozbudowaną wersję darmową oraz aż 30 dni darmowego korzystania z wersji płatnej..."); ?></p>
                <p class="paragraf ukryty"><? echo langs("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur."); ?></p>
                <span class="rozwin detal"><? echo langs("rozwiń"); ?></span>
            </div>
     	</div>
     </section>
     
     <section id="wiadomosci">
     	<h2 class="hidden">Informacje o serwisie</h2>
        
        <section class="info1">
        	<div class="wrapper">
                <div class="kol1">
                   
                </div>
                
                <div class="kol2">
                    <h3><? echo langs("Pierwsze na świecie"); ?></h3> 
                    <span><? echo langs("kursy online tworzone dla Ciebie <br> INDYWIDUALNIE!!!"); ?></span> 
                    <div class="beleczka"></div>
                    <p><? echo langs("Zapomnij o masowych kursach elearningowych, które nijak się mają do Twoich potrzeb. Korepetytorzy sowiej społeczności będą tworzyć specjalnie dla Ciebie tylko te szkolenia i zadania do wykonania, które są Ci w danej chwili najbardziej potrzebne."); ?></p>
                    <p><? echo langs("Te rewolucyjne podejście jest możliwe dzięki zaawansowanym narzędziom do kreacji szkoleń oraz metodom badania profilu ucznia udostępnionej każdemu korepetytorowi. Dzięki temu Twoja nauka stanie się szybsza. efektywniejsza i przyjemniejsza."); ?></p>
                </div>
             </div>
        </section>
        
        <div class="clear"></div>
        
        <section class="info2">
        	<div class="wrapper">
                <div class="kol1">
                    <img src="img/strona_glowna/smartphone.jpg" alt="smartphone"/>
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
                    <h3><? echo langs("Szukasz korepetytora,"); ?></h3> 
                    <span><? echo langs("ale boisz się że trafisz na niewłaściwego, <br> tracąc czas i pieniądze?"); ?></span> 
                    
                    <div class="beleczka"></div>
                    <p><? echo langs("Unikatowa wyszukiwarka korepetytorów - pozwoli Ci znaleźć dokładnie takiego nauczyciela jakiego potrzebujesz. Jesteś dobry z gramatyki ,ale masz problem z mówieniem - zaznaczasz to w wyszukiwarce i gotowe. Możesz prześledzić ich certyfikaty, filmy, szkolenia,  a nawet całą historię pomocy innym, dzięki czemu już nigdy nie zmarnujesz pieniędzy na kota w worku."); ?></p>
                 </div> 
                  
                 <div class="kol2">
                    <img src="img/strona_glowna/tablet_short.png" alt="tablet"/>
                 </div>
            </div>
        </section>
        
        <div class="clear"></div>
        
        <section class="info4">
        	<div class="wrapper">
                <div class="kol1">
                    <img src="img/strona_glowna/tablet_long.png" alt="tablet"/>
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
            <h2 class="hidden">Komentarze</h2>
            
            <div class="comment">
                <img src="img/strona_glowna/twarz1_big.png" alt="avatar3" />
                <p><? echo langs("Nigdy nie lubiłem się uczyć angielskiego. Do czasu odkrycia sowy językowej, gdzie mogę wypełniać pasjonujące questy i zadania jak w rasowej grze RPG."); ?></p>
                <span><? echo langs("Adam, nauczyciel"); ?></span>
            </div>
            
            <div class="comment">
                <img src="img/strona_glowna/twarz2_big.png" alt="avatar4" />
                <p><? echo langs("Szczerze mówiąc, nie wierzyłem, że w jednym miejscu rozwiąże wszystkie swoje problemy językowe. Po pierwszym logowaniu prawda okazała się lepsza od obietnic."); ?></p>
                <span><? echo langs("Adam, barman"); ?></span>
            </div>
            
            <div class="comment">
                <img src="img/strona_glowna/twarz1_big.png" alt="avatar3" />
                <p><? echo langs("Nigdy nie lubiłem się uczyć angielskiego. Do czasu odkrycia sowy językowej, gdzie mogę wypełniać pasjonujące questy i zadania jak w rasowej grze RPG."); ?></p>
                <span><? echo langs("Adam, nauczyciel"); ?></span>
            </div>
            
            <div class="comment">
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
            
            <button class="facebook"><img src="img/strona_glowna/facebook.png" alt="fb"/><span><? echo langs("Wejdź przez Facebook"); ?></span></button>
  			<button class="google"><img src="img/strona_glowna/gplus.png" alt="google plus"/><span><? echo langs("Wejdź przez Google+"); ?></span></button>
                <br/> 
            <span class="styl"><? echo langs("lub"); ?></span>
                   
            <form method="post">
                <input name="imie" placeholder="<? echo langs("Wpisz swoje imię"); ?>">
                <input name="email" placeholder="<? echo langs("Wpisz swój e-mail"); ?>">
				<input type="password" name="haslo" placeholder="<? echo langs("Wpisz swoje hasło"); ?>">
                <button name="btn_reg1" class="btn"><? echo langs("ZAREJESTRUJ SIĘ"); ?></button>
            </form>
            
            <div class="rozwijany">
            	<p><? echo langs("To wszystko wygląda zbyt dobrze, by było prawdziwe? Zdajemy sobie sprawę, że Internet roi się od oszustw i możesz mieć wątpliwości. Dlatego robimy coś, czego nie zrobił jeszcze nikt inny - dajemy Ci rozbudowaną wersję darmową oraz aż 30 dni darmowego korzystania z wersji płatnej..."); ?></p>
                <p class="paragraf ukryty"><? echo langs("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur."); ?></p>
                <span  class="rozwin detal"><? echo langs("rozwiń"); ?></span>
            </div>
     	</div>
     </section>
     
     <footer>
     	<div class="wrapper">	
            <h2 class="hidden">Podsumowanie</h2>
            <nav>
                <h3 class="hidden">Nawigacja</h3>
                
                <ul>
                    <li><a href="#"><? echo langs("POLITYKA PRYWATNOŚCI"); ?></a></li>
                    <li><a href="#"><? echo langs("REGULAMIN"); ?></a></li>
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



<script src="js/script.js"></script>
</body>