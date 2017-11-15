<?php
ob_start();
require_once("config.php");

// Sprawdzenie czy zalogowany
if(empty($_COOKIE['login']) AND empty($_COOKIE['password']))
{
    $seslogin = $_SESSION['login'];
    $sespass = $_SESSION['password'];
}
else
{
	$seslogin = $_COOKIE['login'];
    $sespass = $_COOKIE['password'];
}
if(empty($seslogin) AND empty($sespass))
{
	header('Location: index.php');
}
// -----

$sql_list = mysql_query("SELECT * FROM `users` WHERE `email`='$seslogin'");
while($row_list = mysql_fetch_array($sql_list))
{
	$twoje_imie = $row_list['imie'];
	$twoje_nazwisko = $row_list['nazwisko'];
	$twoje_vip = $row_list['vip'];
	$twoje_email = $row_list['email'];
	$twoje_avatar = $row_list['avatar'];
	
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Tłumacz</title>
    <meta name="description" content="Serwis nauki języków obcych..." />
    <meta name="keywords" content="nauka, angielski, języki obce, tłumaczenia" />

    <link href='http://fonts.googleapis.com/css?family=Lato:400,700&subset=latin-ext' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="css/html5reset-1.6.1.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style_glowna.css">
    <link rel="stylesheet" type="text/css" href="css/media-queries_glowna.css">
    <link rel="stylesheet" type="text/css" href="css/style_tlumacz.css">
</head>

<body>
    <header id="sticky">
        <div class="wrapper">

            <a href="#"><div id="logo"></div></a>

            <ul class="maly_nav">
                <li><a href="konto.php"><img src="<?php echo $twoje_avatar ?>" height="32" alt="avatar" style="border-radius: 20px;"/></a></li>
                <li class="kafelek"><a href="konto.php">Profil</a></li>
                <li><a href="glowna.php">Strona główna</a></li>
            </ul>

            <form role="search">
                <input type="text" placeholder="Szukaj korepetytora/znajdz materiał/zadaj pytanie">
                <button type="submit"><img src="img/gorne_menu/lupa.jpg" alt="lupa" /></button>
            </form>

            <div id="buttons">
                <a href="znajomi.php"><button><img src="img/gorne_menu/tri.png" alt="ikonka" />Zaproś znajomych</button></a>
                <a href="platnosc.php"><button>Przejdź na VIP</button></a>
            </div>

            <div id="nav_hanburger"><img src="img/gorne_menu/hanburger.png" alt="kanapka" /></div>

            <div id="pioro"><a href="wiadomosci.php"><img src="img/gorne_menu/pioro.png" alt="pioro" /><div class="nowosci">25</div></a></div>
            <div id="dolar"><a href="zarobki.php"><img src="img/gorne_menu/dolar.png" alt="dolar" /><div class="nowosci">4</div></a></div>

            <ul class="glowne" id="menu">
                <li class="znajomi">
                    <a href="#"><img src="img/gorne_menu/ludzie.png" alt="ico1" /><span class="powiadomienie">10</span></a>
                    <ul class="ukryj klikane1">
                        <li>Ostatnio dołączyli:</li>
                        <li><a href="#"><img src="img/witryna_glowna/avatar_kom1.png" alt="uzytkownik1" />Kim Kardashian</a></li>
                        <li><a href="#"><img src="img/witryna_glowna/avatar_kom1.png" alt="uzytkownik1" />Kim Kardashian</a></li>
                        <li><a href="#"><img src="img/witryna_glowna/avatar_kom1.png" alt="uzytkownik1" />Kim Kardashian</a></li>
                        <li><a href="#"><img src="img/witryna_glowna/avatar_kom1.png" alt="uzytkownik1" />Kim Kardashian</a></li>
                    </ul>
                </li>
                <li class="wiadomosci">
                    <a href="#"><img src="img/gorne_menu/koperta.png" alt="ico2" /><span class="powiadomienie">10</span></a>
                    <ul class="ukryj klikane2">
                        <li>Najnowsze wiadomosci:</li>
                        <li><a href="wiadomosci.php"><img src="img/witryna_glowna/avatar_kom1.png" alt="uzytkownik1" />Kim Kardashian</a></li>
                        <li><a href="wiadomosci.php"><img src="img/witryna_glowna/avatar_kom1.png" alt="uzytkownik1" />Kim Kardashian</a></li>
                        <li><a href="wiadomosci.php"><img src="img/witryna_glowna/avatar_kom1.png" alt="uzytkownik1" />Kim Kardashian</a></li>
                        <li><a href="wiadomosci.php"><img src="img/witryna_glowna/avatar_kom1.png" alt="uzytkownik1" />Kim Kardashian</a></li>
                    </ul>
                </li>

                <li class="down ">
                    <a href="#"> <img src="img/gorne_menu/pen.png" alt="ico3" /><span class="powiadomienie">10</span></a>
                    <div class="trojkat"><img src="img/gorne_menu/trojkat.png" alt="trojkat" /></div>
                    <ul class="rozwijane">
                        <li><a href="#">LOREM</a></li>
                        <li><a href="#">LOREM</a></li>
                        <li><a href="#">LOREM</a></li>
                        <li><a href="#">LOREM</a></li>
                    </ul>
                </li>
                <li><a href="#"><img src="img/gorne_menu/world.png" alt="ico4" /><span class="powiadomienie"></span></a></li>
                <li><a href="ranking.php"><img src="img/gorne_menu/progres.png" alt="ico5" /><span class="powiadomienie"></span></a></li>
                <li class="down ">
                    <a href="ustawienia.php"><img src="img/gorne_menu/narzedzia.png" alt="ico6" /><span class="powiadomienie"></span></a>
                    <div class="trojkat"><img src="img/gorne_menu/trojkat.png" alt="trojkat" /></div>
                    <ul class="rozwijane">
                        <li><a href="logout.php">Wyloguj</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </header>

    <div class="clear"></div>

    <!-- ZAKŁADKA Z NAJLEPSZYMI UŻYTKOWNIKAMI-->
    <section id="najlepsi">
        <div class="container">
            <h2 class="hidden">Ranking użytkowników</h2>

            <div class="row">
                <div class="col-md-3 col-xs-12  hidden-sm hidden-xs">
                    <h3>Sowa miesiąca:</h3>
                    <img src="img/witryna_glowna/avatar_big.png" alt="najlepsza sowa" />
                    <span>Karina Kowalska</span>
                </div>

                <div class="col-md-3 col-xs-12 hidden-sm hidden-xs carusel1">
                    <h3>Najbardziej kreatywna sowa tygodnia:</h3>

                    <a href="#" class="prev"></a>
                    <div id="karuzela1">

                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>1</span>
                        </div>
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>2</span>
                        </div>
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>3</span>
                        </div>
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>4</span>
                        </div>
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>5</span>
                        </div>
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>6</span>
                        </div>
                    </div>
                    <a href="#" class="next"></a>
                </div>

                <div class="col-md-3 col-xs-12  hidden-sm hidden-xs carusel2">
                    <h3 class="margin">Najbardziej pomocna sowa:</h3>
                    <a href="#" class="prev"></a>

                    <div id="karuzela2">
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>1</span>
                        </div>
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>2</span>
                        </div>
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>3</span>
                        </div>
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>4</span>
                        </div>
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>5</span>
                        </div>
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>6</span>
                        </div>
                    </div>

                    <a href="#" class="next"></a>
                </div>

                <div class="col-md-3 col-xs-12  hidden-sm hidden-xs carusel3">
                    <h3 class="margin">Sowa tłumacz tygodnia:</h3>
                    <a href="#" class="prev"></a>

                    <div id="karuzela3">
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>1</span>
                        </div>
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>2</span>
                        </div>
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>3</span>
                        </div>
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>4</span>
                        </div>
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>5</span>
                        </div>
                        <div class="col-md-4">
                            <img src="img/witryna_glowna/avatar_small.png" alt="najlepsza sowa" class="img-responsive" />
                            <span>6</span>
                        </div>
                    </div>

                    <a href="#" class="next"></a>
                </div>
            </div>
            <div id="naj_sowy" class="detal2"><p>Ukryj panel</p></div>
        </div>
    </section>

    <section id="serwis">
        <div class="container">
            <h2 class="hidden">Serwis językowy</h2>
            <div class="row">
                <div id="lewa" class="col-lg-3 col-md-3 col-sm-4  hidden-xs nopadding">

                    <!-- PROFIL -->
                    <div class="profil row nopadding">
                        <div class="col-sm-7 nopadding">
                            <h3>MÓJ PROFIL</h3>
                            <div class="belka"></div>
                            <div class="col-sm-5 nopadding">
                                <label>
                                    <input type="checkbox" name="checkboxName" class="checkbox" />
                                    <span class="switch"></span>
                                </label>
                            </div>
                            <div class="col-sm-7 nopadding">
                                <span>Korepetytor</span>
                            </div>
                        </div>
                        <div class="col-sm-5 ">
                            <img src="img/strona_glowna/twarz1_big.png" class="img-responsive" alt="użytkownik" />
                        </div>
                    </div>

                    <!-- KALENDARZ -->
                    <div class="kalendarz row nopadding">
                        <div class="col-sm-12 nopadding">
                            <div id="calendar"></div>
                        </div>
                    </div>

                    <!-- MENU BOCZNE -->
                    <div class="menu row nopadding">
                        <div class="col-sm-12 nopadding">
                            <ul>
                                <li class="jasniejszy"><a href="#"><img src="img/witryna_glowna/ikona1.png" alt="ikona1" /><p>Poproś o korepetycje online </p></a></li>
                                <li><a href="#"><img src="img/witryna_glowna/ikona2.png" alt="ikona1" /><p>Udziel korepetycji online </p></a></li>
                                <li class="jasniejszy"><a href="#"><img src="img/witryna_glowna/ikona3.png" alt="ikona1" /><p>Sprawdź misje na dziś </p></a></li>
                                <li><a href="#"><img src="img/witryna_glowna/ikona4.png" alt="ikona1" /><p>Dodaj do sownika </p></a></li>
                                <li><a href="#"><img src="img/witryna_glowna/ikona5.png" alt="ikona1" /><p>Ucz się słówek</p></a></li>
                                <li class="jasniejszy"><a href="#"><img src="img/witryna_glowna/ikona6.png" alt="ikona1" /><p>Edytuj sownik </p></a></li>
                                <li><a href="#"><img src="img/witryna_glowna/ikona7.png" alt="ikona1" /><p>Znajdź szkolenie</p></a></li>
                                <li><a href="#"><img src="img/witryna_glowna/ikona8.png" alt="ikona1" /><p>Forum</p></a></li>
                                <li><a href="#"><img src="img/witryna_glowna/ikona12.png" alt="ikona1" /><p>Wystaw problem na aukcję</p></a></li>
                                <li class="jasniejszy"><a href="#"><img src="img/witryna_glowna/ikona9.png" alt="ikona1" /><p>Przejrzyj aukcję problemów</p></a></li>
                                <li class="jasniejszy"><a href="#"><img src="img/witryna_glowna/ikona10.png" alt="ikona1" /><p>Stwórz nowe szkolenie</p></a></li>
                                <li class="jasniejszy"><a href="#"><img src="img/witryna_glowna/ikona11.png" alt="ikona1" /><p>Program partnerski</p></a></li>
                                <li class="jasniejszy margines_gorny"><a href="#"><img src="img/witryna_glowna/ikona13.png" alt="ikona1" /><p>Wygląd Twojej <br /> strony promocyjnej</p></a></li>
                                <li class="wiecej"><a href="#"><p>Więcej...</p></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="srodkowa" class="col-lg-8 col-md-8 col-sm-8 col-xs-12 nopadding ">
                    <div class="menu_gorne row nopadding">
                        <div class="col-sm-12 nopadding">

                            <!-- Zakładki -->
                            <ul class="nav nav-tabs">
                                <li><a href="glowna.php">GŁÓWNA</a></li>
                                <li><a href="misje.php">TWOJE MISJE</a></li>
                                <li><a href="aukcje2.php">AUKCJE</a></li>
                                <!-- Rozwijane menu -->
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">WIĘCEJ<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#tab_d1" data-toggle="tab">1 opcja</a></li>
                                        <li><a href="#tab_d2" data-toggle="tab">2 opcja</a></li>
                                    </ul>
                                </li>
                            </ul>

                            <!-- Zawartość zakładek -->
                            <div class="tab-content">
                                <div class="tab-pane" id="1zakladkadrop">
                                    <form role="search">
                                        <input type="text" placeholder="Szukaj korepetytora/znajdz materiał/zadaj pytanie">
                                        <button type="submit"><img src="img/gorne_menu/lupa.jpg" alt="lupa" /></button>
                                    </form>
                                </div>
                                <div class="tab-pane" id="2zakladkadrop">
                                    <p>Zawartość drugiej zakładki</p>
                                </div>
                                <div class="tab-pane" id="3zakladkadrop">
                                    <p>Zawartość trzeciej zakładki</p>
                                </div>
                                <div class="tab-pane" id="tab_d1">
                                    <p>Zawartość pierwszej opcji z rozwijanej zakładki</p>
                                </div>
                                <div class="tab-pane" id="tab_d2">
                                    <p>Zawartość drugiej opcji z rozwijanej zakładki</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- EKRAN TEKSTU DO TŁUMACZENIA -->
                    <div class="tlumaczenie row nopadding">
                        <div class="tekst1 col-md-6 col-sm-12 nopadding">
                            <p class="translate">JĘZYK DOCELOWY TŁUMACZENIA:</p>
                            <ul class="jezyk">
                                <li class="rozw">
                                    <a href="#">Angielski<img src="img/podstrony/trojkat1.png" alt="trójkąt" /></a>
                                    <ul class="lista_rozw">
                                        <li><a href="#">Hiszpański</a></li>
                                        <li><a href="#">Niemiecki</a></li>
                                        <li><a href="#">Rosyjski</a></li>
                                        <li><a href="#">Włoski</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="dotted"></div>

                            <div class="tekst">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse risus erat, imperdiet ac orci ac, iaculis facilisis purus. Pellentesque non mattis justo. Pellentesque posuere elit justo, in cursus nunc rutrum eu. Vestibulum cursus erat arcu. In a venenatis nisi, ac iaculis magna. In at neque sodales, pellentesque velit eget, pretium mi. Donec euismod sem non tincidunt pulvinar. Fusce lobortis blandit magna, id luctus nunc vulputate in. Nunc quis leo interdum, sodales arcu non, placerat est. Ut auctor hendrerit euismod. Phasellus vulputate enim vel ligula venenatis, ut bibendum enim suscipit. In non elementum felis, non pretium lectus. Nunc id accumsan massa. Vivamus aliquam euismod sem quis porta.

                                    Praesent sodales dolor lorem, a cursus lacus posuere non. Sed tincidunt tempor ex, accumsan mollis justo aliquam quis. Ut in felis molestie, tincidunt dui eget, vehicula turpis. Aliquam erat volutpat. Pellentesque enim libero, ultricies a lobortis sed, efficitur et lacus. Suspendisse id sodales ligula, vitae rhoncus eros. Pellentesque non consectetur ipsum. Etiam elit ex, varius eget laoreet a, lobortis eget felis. Ut vulputate ac sapien eget rhoncus. Nullam pharetra quam sit amet turpis suscipit ornare. Quisque maximus, ipsum nec convallis tempus, felis sapien congue nunc, eget luctus massa enim quis quam. Ut sollicitudin lectus non ultricies congue. Fusce volutpat aliquet ante, nec blandit neque placerat vel. Donec eu cursus ex, nec semper odio. Suspendisse viverra, purus sit amet posuere ultricies, mi ipsum congue odio, non pretium nibh justo vitae libero. Nunc porttitor mattis efficitur.
                                </p>
                            </div>
                        </div>

                        <div class="tekst2 col-md-6 col-sm-12 nopadding">

                            <p class="translate">ZNAJDŹ TŁUMACZY: </p>
                            <ul class="jezyk">
                                <li class="rozw">
                                    <a href="#">Kamil <img src="img/podstrony/trojkat1.png" alt="trójkąt" /></a>
                                    <ul class="lista_rozw">
                                        <li><a href="#">Piotr S.</a></li>
                                        <li><a href="#">Robert</a></li>
                                        <li><a href="#">Dorota</a></li>
                                        <li><a href="#">Weronika</a></li>
                                    </ul>
                            </ul>

                            <div class="dotted"></div>
                            <div class="tekst">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse risus erat, imperdiet ac orci ac, iaculis facilisis purus. Pellentesque non mattis justo. Pellentesque posuere elit justo, in cursus nunc rutrum eu. Vestibulum cursus erat arcu. In a venenatis nisi, ac iaculis magna. In at neque sodales, pellentesque velit eget, pretium mi. Donec euismod sem non tincidunt pulvinar. Fusce lobortis blandit magna, id luctus nunc vulputate in. Nunc quis leo interdum, sodales arcu non, placerat est. Ut auctor hendrerit euismod. Phasellus vulputate enim vel ligula venenatis, ut bibendum enim suscipit. In non elementum felis, non pretium lectus. Nunc id accumsan massa. Vivamus aliquam euismod sem quis porta.

                                    Praesent sodales dolor lorem, a cursus lacus posuere non. Sed tincidunt tempor ex, accumsan mollis justo aliquam quis. Ut in felis molestie, tincidunt dui eget, vehicula turpis. Aliquam erat volutpat. Pellentesque enim libero, ultricies a lobortis sed, efficitur et lacus. Suspendisse id sodales ligula, vitae rhoncus eros. Pellentesque non consectetur ipsum. Etiam elit ex, varius eget laoreet a, lobortis eget felis. Ut vulputate ac sapien eget rhoncus. Nullam pharetra quam sit amet turpis suscipit ornare. Quisque maximus, ipsum nec convallis tempus, felis sapien congue nunc, eget luctus massa enim quis quam. Ut sollicitudin lectus non ultricies congue. Fusce volutpat aliquet ante, nec blandit neque placerat vel. Donec eu cursus ex, nec semper odio. Suspendisse viverra, purus sit amet posuere ultricies, mi ipsum congue odio, non pretium nibh justo vitae libero. Nunc porttitor mattis efficitur.
                                </p>
                            </div>
                        </div>

                        <!-- EKRAN PRZETŁUMACZONYCH -->

                        <div class="ranking row nopadding">
                            <div class="tlumaczenia col-xs-12">
                                <div class="naglowek row nopadding">
                                    <div class=" col-xs-12">
                                        <p>Uytkownicy, którzy przetłumaczyli już część tekstu:</p>
                                    </div>
                                </div>

                                <div class="pozycja row nopadding">
                                    <div class="kol1 col-xs-2">
                                        <img src="img/strona_glowna/twarz1.png" alt="użytkownik 1" class="img" />
                                    </div>
                                    <div class="kol2 col-xs-3 nopadding">
                                        <p>Mila Kunis</p>
                                        <ul>
                                            <li><img src="img/podstrony/znak_P.png" alt="p" /></li>
                                            <li><img src="img/podstrony/znak_A2.png" alt="A2" /></li>
                                            <li><img src="img/podstrony/znak_T.png" alt="T" /></li>
                                        </ul>
                                    </div>
                                    <div class="kol3 col-xs-4">
                                        <p>Liczba przetłumaczonych słów: 25</p>
                                    </div>
                                    <div class="kol4 col-xs-3">
                                        <button>Oceń tłumaczenie</button>
                                    </div>
                                </div>
                                <div class="pozycja row nopadding">
                                    <div class="kol1 col-xs-2">
                                        <img src="img/strona_glowna/twarz1.png" alt="użytkownik 1" class="img" />
                                    </div>
                                    <div class="kol2 col-xs-3 nopadding">
                                        <p>Mila Kunis</p>
                                        <ul>
                                            <li><img src="img/podstrony/znak_P.png" alt="p" /></li>
                                            <li><img src="img/podstrony/znak_A2.png" alt="A2" /></li>
                                            <li><img src="img/podstrony/znak_T.png" alt="T" /></li>
                                        </ul>
                                    </div>
                                    <div class="kol3 col-xs-4">
                                        <p>Liczba przetłumaczonych słów: 25</p>
                                    </div>
                                    <div class="kol4 col-xs-3">
                                        <button>Oceń tłumaczenie</button>
                                    </div>
                                </div>
                                <div class="pozycja row nopadding">
                                    <div class="kol1 col-xs-2">
                                        <img src="img/strona_glowna/twarz1.png" alt="użytkownik 1" class="img" />
                                    </div>
                                    <div class="kol2 col-xs-3 nopadding">
                                        <p>Mila Kunis</p>
                                        <ul>
                                            <li><img src="img/podstrony/znak_P.png" alt="p" /></li>
                                            <li><img src="img/podstrony/znak_A2.png" alt="A2" /></li>
                                            <li><img src="img/podstrony/znak_T.png" alt="T" /></li>
                                        </ul>
                                    </div>
                                    <div class="kol3 col-xs-4">
                                        <p>Liczba przetłumaczonych słów: 25</p>
                                    </div>
                                    <div class="kol4 col-xs-3">
                                        <button>Oceń tłumaczenie</button>
                                    </div>
                                </div>
                                <div class="pozycja row nopadding">
                                    <div class="kol1 col-xs-2">
                                        <img src="img/strona_glowna/twarz1.png" alt="użytkownik 1" class="img" />
                                    </div>
                                    <div class="kol2 col-xs-3 nopadding">
                                        <p>Mila Kunis</p>
                                        <ul>
                                            <li><img src="img/podstrony/znak_P.png" alt="p" /></li>
                                            <li><img src="img/podstrony/znak_A2.png" alt="A2" /></li>
                                            <li><img src="img/podstrony/znak_T.png" alt="T" /></li>
                                        </ul>
                                    </div>
                                    <div class="kol3 col-xs-4">
                                        <p>Liczba przetłumaczonych słów: 25</p>
                                    </div>
                                    <div class="kol4 col-xs-3">
                                        <button>Oceń tłumaczenie</button>
                                    </div>
                                </div>
                                <div class="pozycja row nopadding">
                                    <div class="kol1 col-xs-2">
                                        <img src="img/strona_glowna/twarz1.png" alt="użytkownik 1" class="img" />
                                    </div>
                                    <div class="kol2 col-xs-3 nopadding">
                                        <p>Mila Kunis</p>
                                        <ul>
                                            <li><img src="img/podstrony/znak_P.png" alt="p" /></li>
                                            <li><img src="img/podstrony/znak_A2.png" alt="A2" /></li>
                                            <li><img src="img/podstrony/znak_T.png" alt="T" /></li>
                                        </ul>
                                    </div>
                                    <div class="kol3 col-xs-4">
                                        <p>Liczba przetłumaczonych słów: 25</p>
                                    </div>
                                    <div class="kol4 col-xs-3">
                                        <button>Oceń tłumaczenie</button>
                                    </div>
                                </div>
                                <div class="pozycja row nopadding">
                                    <div class="kol1 col-xs-2">
                                        <img src="img/strona_glowna/twarz1.png" alt="użytkownik 1" class="img" />
                                    </div>
                                    <div class="kol2 col-xs-3 nopadding">
                                        <p>Mila Kunis</p>
                                        <ul>
                                            <li><img src="img/podstrony/znak_P.png" alt="p" /></li>
                                            <li><img src="img/podstrony/znak_A2.png" alt="A2" /></li>
                                            <li><img src="img/podstrony/znak_T.png" alt="T" /></li>
                                        </ul>
                                    </div>
                                    <div class="kol3 col-xs-4">
                                        <p>Liczba przetłumaczonych słów: 25</p>
                                    </div>
                                    <div class="kol4 col-xs-3">
                                        <button>Oceń tłumaczenie</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CHAT STATYCZNY -->
                <div id="prawa" class="col-lg-1 col-md-1 hidden-sm  hidden-xs nopadding">
                    <div class="chat row nopadding">
                        <div class="col-sm-12 nopadding">
                            <ul>
                                <li class="chat_pier">CHAT</li>
                                <li><a href="#"><img class="avatar" src="img/witryna_glowna/avatar_kom1.png" alt="avatar1" /><p>Kanye West</p></a><img class="status" src="img/witryna_glowna/dostepny.png" alt="status" /><img class="flaga" src="img/witryna_glowna/gb_kom.jpg" alt="flaga" /></li>
                                <li><a href="#"><img class="avatar" src="img/witryna_glowna/avatar_kom2.png" alt="avatar1" /><p>Kanye West</p></a><img class="status" src="img/witryna_glowna/niedostepny.png" alt="status" /><img class="flaga" src="img/witryna_glowna/gb_kom.jpg" alt="flaga" /></li>
                                <li><a href="#"><img class="avatar" src="img/witryna_glowna/avatar_kom3.png" alt="avatar1" /><p>Kanye West</p></a><img class="status" src="img/witryna_glowna/dostepny.png" alt="status" /><img class="flaga flaga_brak" src="img/witryna_glowna/gb_kom.jpg" alt="flaga" /></li>
                                <li><a href="#"><img class="avatar" src="img/witryna_glowna/avatar_kom4.png" alt="avatar1" /><p>Kanye West</p></a><img class="status" src="img/witryna_glowna/niedostepny.png" alt="status" /><img class="flaga" src="img/witryna_glowna/gb_kom.jpg" alt="flaga" /></li>
                                <li><a href="#"><img class="avatar" src="img/witryna_glowna/avatar_kom1.png" alt="avatar1" /><p>Kanye West</p></a><img class="status" src="img/witryna_glowna/dostepny.png" alt="status" /><img class="flaga" src="img/witryna_glowna/gb_kom.jpg" alt="flaga" /></li>
                                <li><a href="#"><img class="avatar" src="img/witryna_glowna/avatar_kom2.png" alt="avatar1" /><p>Kanye West</p></a><img class="status" src="img/witryna_glowna/niedostepny.png" alt="status" /><img class="flaga" src="img/witryna_glowna/gb_kom.jpg" alt="flaga" /></li>
                                <li><a href="#"><img class="avatar" src="img/witryna_glowna/avatar_kom3.png" alt="avatar1" /><p>Kanye West</p></a><img class="status" src="img/witryna_glowna/dostepny.png" alt="status" /><img class="flaga flaga_brak" src="img/witryna_glowna/gb_kom.jpg" alt="flaga" /></li>
                                <li><a href="#"><img class="avatar" src="img/witryna_glowna/avatar_kom4.png" alt="avatar1" /><p>Kanye West</p></a><img class="status" src="img/witryna_glowna/niedostepny.png" alt="status" /><img class="flaga" src="img/witryna_glowna/gb_kom.jpg" alt="flaga" /></li>
                                <li><a href="#"><img class="avatar" src="img/witryna_glowna/avatar_kom1.png" alt="avatar1" /><p>Kanye West</p></a><img class="status" src="img/witryna_glowna/dostepny.png" alt="status" /><img class="flaga" src="img/witryna_glowna/gb_kom.jpg" alt="flaga" /></li>
                                <li><a href="#"><img class="avatar" src="img/witryna_glowna/avatar_kom2.png" alt="avatar1" /><p>Kanye West</p></a><img class="status" src="img/witryna_glowna/niedostepny.png" alt="status" /><img class="flaga" src="img/witryna_glowna/gb_kom.jpg" alt="flaga" /></li>
                                <li><a href="#"><img class="avatar" src="img/witryna_glowna/avatar_kom3.png" alt="avatar1" /><p>Kanye West</p></a><img class="status" src="img/witryna_glowna/dostepny.png" alt="status" /><img class="flaga flaga_brak" src="img/witryna_glowna/gb_kom.jpg" alt="flaga" /></li>
                                <li><a href="#"><img class="avatar" src="img/witryna_glowna/avatar_kom4.png" alt="avatar1" /><p>Kanye West</p></a><img class="status" src="img/witryna_glowna/niedostepny.png" alt="status" /><img class="flaga" src="img/witryna_glowna/gb_kom.jpg" alt="flaga" /></li>
                                <li><a href="#"><img class="avatar" src="img/witryna_glowna/avatar_kom1.png" alt="avatar1" /><p>Kanye West</p></a><img class="status" src="img/witryna_glowna/dostepny.png" alt="status" /><img class="flaga" src="img/witryna_glowna/gb_kom.jpg" alt="flaga" /></li>
                                <li><a href="#"><img class="avatar" src="img/witryna_glowna/avatar_kom2.png" alt="avatar1" /><p>Kanye West</p></a><img class="status" src="img/witryna_glowna/niedostepny.png" alt="status" /><img class="flaga" src="img/witryna_glowna/gb_kom.jpg" alt="flaga" /></li>
                                <li><a href="#"><img class="avatar" src="img/witryna_glowna/avatar_kom3.png" alt="avatar1" /><p>Kanye West</p></a><img class="status" src="img/witryna_glowna/dostepny.png" alt="status" /><img class="flaga flaga_brak" src="img/witryna_glowna/gb_kom.jpg" alt="flaga" /></li>
                                <li><a href="#"><img class="avatar" src="img/witryna_glowna/avatar_kom1.png" alt="avatar1" /><p>Kanye West</p></a><img class="status" src="img/witryna_glowna/dostepny.png" alt="status" /><img class="flaga" src="img/witryna_glowna/gb_kom.jpg" alt="flaga" /></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- navigacja i profil Z BOKU -->

    <div id="nav_bok">
        <!-- PROFIL -->
        <div class="profil">
            <div class="cont1">
                <label>
                    <input type="checkbox" name="checkboxName" class="checkbox" />
                    <span class="switch"></span>
                </label>
                <span>Korepetytor</span>
            </div>
            <div class="cont2">
                <img src="img/strona_glowna/twarz1_big.png" class="img-responsive" alt="użytkownik" />
            </div>
        </div>

        <!-- MENU BOCZNE -->
        <div class="menu">
            <ul>
                <li class="jasniejszy"><a href="#"><img src="img/witryna_glowna/ikona1.png" alt="ikona1" /><p>Poproś o korepetycje online </p></a></li>
                <li><a href="#"><img src="img/witryna_glowna/ikona2.png" alt="ikona1" /><p>Udziel korepetycji online </p></a></li>
                <li class="jasniejszy"><a href="#"><img src="img/witryna_glowna/ikona3.png" alt="ikona1" /><p>Sprawdź misje na dziś </p></a></li>
                <li><a href="#"><img src="img/witryna_glowna/ikona4.png" alt="ikona1" /><p>Dodaj do sownika </p></a></li>
                <li><a href="#"><img src="img/witryna_glowna/ikona5.png" alt="ikona1" /><p>Ucz się słówek</p></a></li>
                <li class="jasniejszy"><a href="#"><img src="img/witryna_glowna/ikona6.png" alt="ikona1" /><p>Edytuj sownik </p></a></li>
                <li><a href="#"><img src="img/witryna_glowna/ikona7.png" alt="ikona1" /><p>Znajdź szkolenie</p></a></li>
                <li><a href="#"><img src="img/witryna_glowna/ikona8.png" alt="ikona1" /><p>Forum</p></a></li>
                <li><a href="#"><img src="img/witryna_glowna/ikona12.png" alt="ikona1" /><p>Wystaw problem na aukcję</p></a></li>
                <li class="jasniejszy"><a href="#"><img src="img/witryna_glowna/ikona9.png" alt="ikona1" /><p>Przejrzyj aukcję problemów</p></a></li>
                <li class="jasniejszy"><a href="#"><img src="img/witryna_glowna/ikona10.png" alt="ikona1" /><p>Stwórz nowe szkolenie</p></a></li>
                <li class="jasniejszy"><a href="#"><img src="img/witryna_glowna/ikona11.png" alt="ikona1" /><p>Program partnerski</p></a></li>
                <li class="jasniejszy margines_gorny"><a href="#"><img src="img/witryna_glowna/ikona13.png" alt="ikona1" /><p>Wygląd Twojej <br /> strony promocyjnej</p></a></li>
                <li class="wiecej"><a href="#"><p>Więcej...</p></a></li>
            </ul>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="assets/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.carouFredSel-6.2.1.js"></script>
    <script src="js/script_main.js"></script>

</body>

</html>