<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Sowa językowa</title>
    <meta name="description" content="Serwis nauki języków obcych..." />
    <meta name="keywords" content="nauka, angielski, języki obce, tłumaczenia" />

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:700,600,400,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/html5reset-1.6.1.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style_newsletter.css">

</head>

<body>
    <header>
        <a href="/">
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
                </div>
            </div>
           
            <div class="row">
                <div class="col-lg-8 col-centered">
                    
                    <h3 id="need">Potrzebujemy Cię!... ;)</h3>

                    <form id="form" action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8" method="post">
                        <input type="text" name="name" id="name" class="required form-control" maxlength="200" placeholder="wpisz tu swoje imię...">
                        <input type="email" name="email" class="required email form-control" id="email" maxlength="200" placeholder="a tu adres e-mail :)">
                        <input type="hidden" name="campaign_token" value="pZrRO" />
                    </form>
                    <button id="sub" type="button" class="btn btn-warning" value="Subscribe">Zgłaszam się!</button>

                </div>
            </div>
        </div>
    </section>

    <section id="black">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-centered">
                    
                    <h3>Uhu, Uhu…</h3>
                    <h4>Zapisz się na sowy językowej betatest, a czekać Cię będzie miły gest.</h4>
                    <h4>
                        Dla pierwszych <strong>100</strong> sów, które opinie o naszym portalu wyrażą,<br>
                        Darmowe konta premium na <strong>3 miesiące</strong> się ukażą!
                    </h4>
                    <h4>Nie pokazuj tego linka nikomu, prócz  przyjaciół którzy chcą nauczyć się<br><strong>angielskiego z domu</strong>.</h4>
                    <h4>Zapisz się do sowiej księgi po dalsze instrukcje,</h4>
                    <h4>Info co i jak dostaniesz <strong>wkrótce!</strong> :) Uhu, Uhu...</h4><br>
                    <h4>Wolnych miejsc dla sowich betatesterów:</h4>
                    <button id="free">Zostało miejsc: 100</button>

                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="hidden">Podsumowanie</h2>
                    <span>&copy; 2015 SowaJęzykowa.pl | Design: UI8 | Code: <a target="_blank" title="CANGARIS LTD - Google AdWords Support / Web Development / Web Designing" href="//cangaris.com">CANGARIS LTD</a></span>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
        
        $(document).ready(function() { check(); });
        
        function check () {
            $.post("ajax/check4Newsletter.php", function(data) {
                $("button#free").text("Zostało miejsc: "+data);

                if(data <= 0)
                {
                    $("h3#need").text("Fantastycznie! Mamy już komplet betatesterów! ^^");
                    $("h3#need").after("<h4 class='text-warning'><strong>Kiedy ukończymy projekt odezwiemy się do Ciebie! :)</strong></h4>");
                    $("button#sub").remove();
                    $("input#email").remove();
                }
            });
        }

        $("button#sub").click(function() {
            $("h4.text-danger").remove();
            var input = $("input#email");
            var need = $("h3#need");
            var val = input.val();

            if(validate(val)) {
                $.post("ajax/add2Newsletter.php", { val:val }, function(data) {
                    if(data.status == "added") {
                        need.text("Yeah! Udało się! ^^");
                        need.after("<h4 class='text-success'><strong>Uhu! Uhu! Sowa Ci dziękuje! Wysłaliśmy na Twojego maila (<span class='text-warning'>"+val+"</span>) wiadomość z prośbą o potwierdzenie. Otwórz ją teraz i kliknij w umieszczony tam link, aby potwierdzić zapis na listę i zapisać się na darmowy minikurs z angielskiego!</strong></h4>");
                        $("form#form").submit();
                        input.val("");
                    }
                    else if(data.status == "exist") {
                        need.text("Upsss! ^^");
                        need.after("<h4 class='text-primary'><strong>Ten mail już jest w naszej bazie... prosimy o cierpliwość, nasi informatycy pracują dniami i nocami aby przygotować wersję beta, która będzie już niebawem... :)</strong></h4>");
                    }
                    $("button#sub").remove();
                    input.remove();
                }, "json");
            }
            else {
                need.text("Upsss! błędny e-mail! ;(");
                need.after("<h4 class='text-danger'><strong>Przez pomyłkę wpisałeś niepoprawny adres e-mail, sprawdź go jeszcze raz...</strong></h4>");
            }
            check();
        });

        function validate(email) {
            var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            return re.test(email);
        }

    </script>

</body>
</html>
