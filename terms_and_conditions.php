<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>OwLangs.com</title>
    <meta name="description" content="Portal społecznościowy do nauki języka angielksiego" />
    <meta name="keywords" content="Portal społecznościowy do nauki języka angielksiego" />

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:700,600,400,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/html5reset-1.6.1.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style_newsletter.css">
    <link href="favicon.png" rel="shortcut icon">
    
    <style>
        h1 { color: #fff; }
        #black { min-height: 110px; }
    </style>
    
</head>

<body>
    <header>
        <a href="//owlangs.com">
            <h4>Click HERE and start to learn English with us! :)</h4>
            <div id="logo">
                <h1 class="hidden">SowaJęzykowa.pl</h1>
            </div>
        </a>
    </header>

    <section id="logowanie"></section>

    <section id="black">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    
                    <h1>TERMS AND CONDITIONS</h1>
                    
                </div>
            </div>
        </div>
    </section>
    
    <section style="margin-top: 20px">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    
                    <p style="text-align: left" id="content"></p>
                    
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-lg-12">
                    <h2 class="hidden">Podsumowanie</h2>
                    <span>&copy; 2016 Owlangs.com | Design: UI8 | Code: <a target="_blank" title="CANGARIS LTD - Google AdWords Support / Web Development / Web Designing" href="//cangaris.com">CANGARIS LTD</a></span>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootbox.min.js"></script>
    <script type="text/javascript">

        $("a#sub").click(function() {
            var i1 = $("input#name").val();
            var i2 = $("input#email").val();
            var i3 = $("textarea#msg").val();

            if(i1 && i3 && validate(i2)) {
                $.post("ajax/sendEmailContactForm.php", { name:i1,email:i2,msg:i3 }, function(data) {
                    if(data == "sent") { bootbox.alert("<h4 class='text-success'><strong>Ok! E-mail wysłany - niebawem odpiszemy! :)</strong></h4>"); }
                    else { bootbox.alert("<h4 class='text-danger'><strong>Ups! Coś poszło nie tak, spróbuj wysłać wiadomość później lub poprostu zadzwoń...</strong></h4>"); }
                });
            }
            else { bootbox.alert("<h4 class='text-danger'><strong>Ups! Przez pomyłkę nie wypełniłeś wszystkich pól, lub wpisałeś niepoprawny adres e-mail, sprawdź go jeszcze raz...</strong></h4>"); }
        });

        function validate(email) {
            var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            return re.test(email);
        }
        
        $.post("ajax/getArticle.php", { id: 2 }, function(data) {
            $('p#content').html(data);
        });

    </script>

</body>
</html>
