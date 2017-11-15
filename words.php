<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Sowa językowa</title>
    <meta name="description" content="Serwis nauki języków obcych..." />
    <meta name="keywords" content="nauka, angielski, języki obce, tłumaczenia" />

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:700,600,400,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/html5reset-1.6.1.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style_newsletter.css">
    <link href="css/bootstrap.alert.min.css" rel="stylesheet" type="text/css">

    <!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script-->

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="audio/js/swfobject.js"></script>
    <script type="text/javascript" src="audio/js/recorder.js"></script>
    <script type="text/javascript" src="audio/basic/basic.js"></script>
    <link type="text/css" rel="stylesheet" href="audio/basic/basic.css">

    <style>
        /* Styles for recorder buttons */
        .recorder button, .recorder .upload, .level {
            border: 1px solid #686868;
            height: 30px;
            background-color: white;
            display: inline-block;
            vertical-align: bottom;
            margin: 2px;
            box-sizing: border-box;
            border-radius: 4px;

        }
        .recorder .recorder-container{
            width: 500px;
        }

        /* Styles for level indicator - required! */
        .level {
            width: 30px;
            height: 30px;
            position: relative;
        }
        .progressbar {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #b10000;
        }
        .upload {
            padding-top: 2px;
        }

    </style>

</head>

<body>
    <header>
        <a href="words.php">
            <div id="logo">
                <h1 class="hidden">SowaJęzykowa.pl</h1>
            </div>
        </a>
    </header>

    <section id="logowanie">
        <div class="container">

            <div class="row">
                <div class="col-lg-8 col-centered">
                    <div class="well">
                        <h4><strong>Press START to record and say the word:</strong></h4>
                        <h1 id="word">&nbsp;</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-centered">
                    <div style="text-align:center;">
                        <div style="display:none;" class="alert audio-recorded alert-success">
                            <h4>Your audio file has already been recorded, you can check it:</h4>
                            <audio controls src="" id="audio"></audio>
                        </div>
                        <div style="display:none;" class="alert waiting-for-audio alert-info">
                            <h4>Please wait, your file is saving now.</h4>
                        </div>
                        <div style="display:none;" class="alert deleted-audio alert-danger">
                            <h4>Your file has been deleted.</h4>
                        </div>

            <div class="row">
                <div class="col-lg-12 col-centered">
                        
                            <section class="recorder-container">

                                <!-- Recorder control buttons -->
                                <div class="recorder">
                                    <button class="start-recording" onclick="FWRecorder.record('audio', 'audio.wav');">
                                        <img src="audio/images/record.png" alt="Record">
                                    </button>
                                    <div class="level">
                                        <div class="progressbar"></div>
                                    </div>
                                    <button class="stop-recording" onclick="FWRecorder.stopRecording('audio');">
                                        <img src="audio/images/stop.png" alt="Stop Recording"/>
                                    </button>
                                    <button class="start-playing" onclick="FWRecorder.playBack('audio');" title="Play">
                                        <img src="audio/images/play.png" alt="Play"/>
                                    </button>
                                    <div class="upload" style="display: inline-block">
                                        <div id="flashcontent">
                                            <p>Your browser must have JavaScript enabled and the Adobe Flash Player installed.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden form for easy specifying the upload request parameters -->
                                <form id="uploadForm" name="uploadForm" action="audio/upload.php">
                                    <input name="authenticity_token" value="xxxxx" type="hidden">
                                    <input name="upload_file[parent_id]" value="1" type="hidden">
                                    <input name="format" value="json" type="hidden">
                                    <input id="important" name="word" value="" type="hidden">
                                </form>
                            </section>
                        
                        </div>
                        </div>


                        <div>
                            <button onclick="prev();" style="width:30%;" class="btn btn-default" id="prev"><i class="fa fa-chevron-left"></i> PREV WORD</button>
                            <button onclick="next();" style="width:30%;" class="btn btn-default" id="next">NEXT WORD <i class="fa fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-8 col-centered">
                    <strong>Site number: </strong><input onchange="onChangeInput();" id='site' min="1" step="1" max="10000" value="1" type="number"><strong id="max">1</strong><p>* (If you want to go to the site number 50,<br>just write 50 and press ENTER).</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-centered">
                    <button onclick="buttonToggle();" class="btn btn-info"><i class="fa fa-lg fa-info-circle"></i> How to use?</button>
                    <div style="display:none;" id="infoAlert" class="alert alert-info">
                        <ol style="font-size:16px;margin-left:20px; text-align:left;">

                            <li>Wciśnij czerwone kółko i zaakceptuj dostęp do mikrofonu</li>
                            <li>Teraz jeszcze raz kliknij czerwone kółko by uruchomić nagrywanie</li>
                            <li>Powiedz słowo</li>
                            <li>Na potwierdzenie, że wszystko jest OK zobaczysz obok kółeczka w 2 kwadraciku skaczący w górę i w dół poziom głosu</li>
                            <li>Po nagraniu - kliknij kwadracik by dać STOP a potem trójkącik by odsłuchać</li>
                            <li>Jeśli wszystko pójdzie ok, pojawi się obok trójkącika strzałeczka do góry - kliknij, uruchomi się upload na server</li>
                            <li>Teraz możesz zmienić słowo przyciskiem NEXT WORD</li>
                            <li>Kliknij ponownie czerwone kółko i mów - potem kwadracik, trójkącik i strzałeczka i tak aż do końca...</li>
                            <li>Jeśli uznasz, że słowo się źle nagrało, możesz nie przechodzić dalej, tylko nagrać ponownie to samo</strong>.</li>
                            <li>W miarę możliwości po słówku użyj pełnego zdania jako przykład użycia</li>
                            <li>Na przykład "kot" - "wczoraj widziałem kota"</li>

                        </ol>
                    </div>
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

</body>
</html>

<script type="text/javascript">

    function cangaris(val){ return val.replace(/[^a-zA-Z0-9]+/g,'_'); }

    function del(msg) {
        var src = $('#audio').attr('src');
        if(src) {
            $.post("ajax/del4Audio.php",{ name : src }, function(data) {
                notSaved();
                if(msg) $('.deleted-audio').show();
                $('.waiting-for-audio,.audio-recorded').hide();
                $('#save,#delete').addClass('disabled');
                $('#audio').attr('src','');
            });
        }
    }

    var min = 1;
    var max = 10000;
    var current = 1;

    getWord();

    function next () {
        var v = parseInt($('input#site').val());
        if(!isNaN(v)) current = v;
        if(current < max)
        {
            $('input#site').val(++current);
            $('.alert').hide();
            getWord();
        }
        notSaved();
    }
    
    function prev () {
        var v = parseInt($('input#site').val());
        if(!isNaN(v)) current = v;
        if(current > min)
        {
            $('input#site').val(--current);
            $('.alert').hide();
            getWord();
        }
        notSaved();
    }

    function buttonToggle () {
        $("#infoAlert").toggle();
    }

    function save () {
        var audio = $('#audio').attr('src');
        if(audio)
        {
            var word = $('h1#word').text();
            var object = { word:cangaris(word),audio:audio };
            console.log(object);
            $.post("ajax/saveAudioToWord.php", { object:object,id:current }, function(data) { saved (); });
        }
    }

    function saved () {
        $('button#save').removeClass('btn-warning');
        $('button#save').addClass('btn-primary');
        $('button#save').html('<i class="fa fa-check-square-o"></i> SAVED');
    }

    function notSaved () {
        $('button#save').addClass('btn-warning');
        $('button#save').removeClass('btn-primary');
        $('button#save').html('<i class="fa fa-floppy-o"></i> SAVE');
    }

    function onChangeInput () {
        var v = parseInt($('input#site').val());
        if(!isNaN(v)) { 
            current = v; 
            getWord();
        }
    }

    function getWord () {
        $.post("ajax/getWord.php", { offset:(current-1), limit:1 }, function(data) {
            $('h1#word').html(data.word[0].word);
            $('#important').val(data.word[0].word);
            // if(data.word[0].audio && data.word[0].audio != "null") {
            //     $('.audio-recorded').show(); 
            //     $('#audio').attr('src',data.word[0].audio);
            // }
            $('#max').html(" / "+data.max);
        },'json');
    }

</script>