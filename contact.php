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
        #black h4 { color:#fff; }
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
                <div class="col-xs-12 col-lg-6">
                    
                    <h4 id="cont-form">Contact Form:</h4>
                    <input type="text" id="name" class="required form-control" maxlength="200" placeholder="please write your name"><br>
                    <input type="email" id="email" class="required email form-control" maxlength="200" placeholder="please write your e-mail"><br>
                    <textarea id="msg" rows="6" placeholder="please write your message, we will answer soon" class="required form-control"></textarea>
                    <a id="sub" type="button" class="btn btn-warning" value="Subscribe">Send!</a><br><br>

                </div>
                <div class="col-xs-12 col-lg-6">
                    <h4>Name of the company: <strong>New Future sp. z o.o.</strong></h4>
                    <h4>Adress: <strong>Krawiecka 3/10, Wrocław 50-148, Poland</strong></h4>

                    <div class="col-xs-12 col-lg-6 col-centered">
                        <img class="img-thumbnail" src="img/center.jpg" width="100%">
                    </div>

                    <h4>NIP/tax identification number: <strong>8971805495</strong></h4>
                    <h4>How to contact us:<br>phone: <strong>+48 727 901 680</strong><br>email: <strong><a href="mailto:office@newfuture.company">office@newfuture.company</a></strong>
                    </h4>
                </div>
            </div>
        </div>
    </section>

    <iframe width="100%" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2504.9834050643594!2d17.03593531535458!3d51.10876634759239!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470fc27653413449%3A0x6facac676125681a!2sKrawiecka+3%2C+50-148+Wroc%C5%82aw!5e0!3m2!1sen!2spl!4v1452298373942" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>

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

    </script>

</body>
</html>
