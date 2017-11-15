<script>

    // -------------------------- MAIN FUNCTIONS --------------------------------

    var files = null;
    var chatInterval = null;
    var definition = {"smile":{"title":"Smile","codes":[":)",":=)",":-)"]},"sad-smile":{"title":"Sad Smile","codes":[":(",":=(",":-("]},"big-smile":{"title":"Big Smile","codes":[":D",":=D",":-D",":d",":=d",":-d"]},"cool":{"title":"Cool","codes":["8)","8=)","8-)","B)","B=)","B-)","(cool)"]},"wink":{"title":"Wink","codes":[":o",":=o",":-o",":O",":=O",":-O"]},"crying":{"title":"Crying","codes":[";(",";-(",";=("]},"sweating":{"title":"Sweating","codes":["(sweat)","(:|"]},"speechless":{"title":"Speechless","codes":[":|",":=|",":-|"]},"kiss":{"title":"Kiss","codes":[":*",":=*",":-*"]},"tongue-out":{"title":"Tongue Out","codes":[":P",":=P",":-P",":p",":=p",":-p"]},"blush":{"title":"Blush","codes":["(blush)",":$",":-$",":=$",":\">"]},"wondering":{"title":"Wondering","codes":[":^)"]},"sleepy":{"title":"Sleepy","codes":["|-)","I-)","I=)","(snooze)"]},"dull":{"title":"Dull","codes":["|(","|-(","|=("]},"in-love":{"title":"In love","codes":["(inlove)"]},"evil-grin":{"title":"Evil grin","codes":["]:)",">:)","(grin)"]},"talking":{"title":"Talking","codes":["(talk)"]},"yawn":{"title":"Yawn","codes":["(yawn)","|-()"]},"puke":{"title":"Puke","codes":["(puke)",":&",":-&",":=&"]},"doh!":{"title":"Doh!","codes":["(doh)"]},"angry":{"title":"Angry","codes":[":@",":-@",":=@","x(","x-(","x=(","X(","X-(","X=("]},"it-wasnt-me":{"title":"It wasn't me","codes":["(wasntme)"]},"party":{"title":"Party!!!","codes":["(party)"]},"worried":{"title":"Worried","codes":[":S",":-S",":=S",":s",":-s",":=s"]},"mmm":{"title":"Mmm...","codes":["(mm)"]},"nerd":{"title":"Nerd","codes":["8-|","B-|","8|","B|","8=|","B=|","(nerd)"]},"lips-sealed":{"title":"Lips Sealed","codes":[":x",":-x",":X",":-X",":#",":-#",":=x",":=X",":=#"]},"hi":{"title":"Hi","codes":["(hi)"]},"call":{"title":"Call","codes":["(call)"]},"devil":{"title":"Devil","codes":["(devil)"]},"angel":{"title":"Angel","codes":["(angel)"]},"envy":{"title":"Envy","codes":["(envy)"]},"wait":{"title":"Wait","codes":["(wait)"]},"bear":{"title":"Bear","codes":["(bear)","(hug)"]},"make-up":{"title":"Make-up","codes":["(makeup)","(kate)"]},"covered-laugh":{"title":"Covered Laugh","codes":["(giggle)","(chuckle)"]},"clapping-hands":{"title":"Clapping Hands","codes":["(clap)"]},"thinking":{"title":"Thinking","codes":["(think)",":?",":-?",":=?"]},"bow":{"title":"Bow","codes":["(bow)"]},"rofl":{"title":"Rolling on the floor laughing","codes":["(rofl)"]},"whew":{"title":"Whew","codes":["(whew)"]},"happy":{"title":"Happy","codes":["(happy)"]},"smirking":{"title":"Smirking","codes":["(smirk)"]},"nodding":{"title":"Nodding","codes":["(nod)"]},"shaking":{"title":"Shaking","codes":["(shake)"]},"punch":{"title":"Punch","codes":["(punch)"]},"emo":{"title":"Emo","codes":["(emo)"]},"yes":{"title":"Yes","codes":["(y)","(Y)","(ok)"]},"no":{"title":"No","codes":["(n)","(N)"]},"handshake":{"title":"Shaking Hands","codes":["(handshake)"]},"skype":{"title":"Skype","codes":["(skype)","(ss)"]},"heart":{"title":"Heart","codes":["(h)","<3","(H)","(l)","(L)"]},"broken-heart":{"title":"Broken heart","codes":["(u)","(U)"]},"mail":{"title":"Mail","codes":["(e)","(m)"]},"flower":{"title":"Flower","codes":["(f)","(F)"]},"rain":{"title":"Rain","codes":["(rain)","(london)","(st)"]},"sun":{"title":"Sun","codes":["(sun)"]},"time":{"title":"Time","codes":["(o)","(O)","(time)"]},"music":{"title":"Music","codes":["(music)"]},"movie":{"title":"Movie","codes":["(~)","(film)","(movie)"]},"phone":{"title":"Phone","codes":["(mp)","(ph)"]},"coffee":{"title":"Coffee","codes":["(coffee)"]},"pizza":{"title":"Pizza","codes":["(pizza)","(pi)"]},"cash":{"title":"Cash","codes":["(cash)","(mo)","($)"]},"muscle":{"title":"Muscle","codes":["(muscle)","(flex)"]},"cake":{"title":"Cake","codes":["(^)","(cake)"]},"beer":{"title":"Beer","codes":["(beer)"]},"drink":{"title":"Drink","codes":["(d)","(D)"]},"dance":{"title":"Dance","codes":["(dance)","\o/","\:D/","\:d/"]},"ninja":{"title":"Ninja","codes":["(ninja)"]},"star":{"title":"Star","codes":["(*)"]},"mooning":{"title":"Mooning","codes":["(mooning)"]},"finger":{"title":"Finger","codes":["(finger)"]},"bandit":{"title":"Bandit","codes":["(bandit)"]},"drunk":{"title":"Drunk","codes":["(drunk)"]},"smoking":{"title":"Smoking","codes":["(smoking)","(smoke)","(ci)"]},"toivo":{"title":"Toivo","codes":["(toivo)"]},"rock":{"title":"Rock","codes":["(rock)"]},"headbang":{"title":"Headbang","codes":["(headbang)","(banghead)"]},"bug":{"title":"Bug","codes":["(bug)"]},"fubar":{"title":"Fubar","codes":["(fubar)"]},"poolparty":{"title":"Poolparty","codes":["(poolparty)"]},"swearing":{"title":"Swearing","codes":["(swear)"]},"tmi":{"title":"TMI","codes":["(tmi)"]},"heidy":{"title":"Heidy","codes":["(heidy)"]},"myspace":{"title":"MySpace","codes":["(MySpace)"]},"malthe":{"title":"Malthe","codes":["(malthe)"]},"tauri":{"title":"Tauri","codes":["(tauri)"]},"priidu":{"title":"Priidu","codes":["(priidu)"]}};
    $.emoticons.define(definition);

    function percentage (num,max) { return Math.floor(((num+1) / max) * 100); }

    function ifYT(url) {
        var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
        return (url.match(p)) ? true : false;
    }

    function urlify(text,mode) {
        var urlRegex = /(https?:\/\/[^\s]+)/g;
        return text.replace(urlRegex, function(url) {
            if(ifYT(url) && mode == 1)
            {
                return '<div style="margin-top:10px" class="video-container"><object wmode="Opaque" data=' + url.replace("watch?v=", "v/") + '></object ></div><br>'+'<a target="_blank" href="' + url + '">' + url + '</a>';
            }
            else return '<a target="_blank" href="' + url + '">' + url + '</a>';
        });
    }

    function removeDuplicates(elements){
        return elements.filter(function (el,index,arr){
            return arr.indexOf(el) === index;
        })
    }

    $(document).ready(function ($) {
        $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
            event.preventDefault();
            return $(this).ekkoLightbox({
                onShown: function() {
                    if (window.console) { return console.log('Checking our the events huh?'); }
                },
                onNavigate: function(direction, itemIndex) {
                    if (window.console) { return console.log('Navigating '+direction+'. Current item: '+itemIndex); }
                }
            });
        });
        $('#open-image').click(function (e) {
            e.preventDefault();
            $(this).ekkoLightbox();
        });
        $('#open-youtube').click(function (e) {
            e.preventDefault();
            $(this).ekkoLightbox();
        });
        $(document).delegate('*[data-gallery="navigateTo"]', 'click', function(event) {
            event.preventDefault();
            return $(this).ekkoLightbox({
                onShown: function() {
                    var lb = this;
                    $(lb.modal_content).on('click', '.modal-footer a', function(e) {
                        e.preventDefault();
                        lb.navigateTo(2);
                    });
                }
            });
        });
    });

    function autoSizeText () {
        $('textarea').each(function(){ autosize(this); }).on('autosize:resized', function(){ console.log('resized'); });
    }

    // -------------------------- FROM RECORDER --------------------------------

    var name = '';
    var size = {width:640,height:480};
    var flashvars = {qualityurl: "avq/480p.xml",accountHash:"cb7485eb4df3469c1a22771538abc0b4",showMenu:"false", mrt:180};

    function initialPipe() {
        var pipe = document.createElement('script');
        pipe.type = 'text/javascript';
        pipe.async = true;
        pipe.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 's1.addpipe.com/1.3/pipe.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(pipe, s);
    }

    function startm() { 
        document.VideoRecorder.record();
        $("#startm").hide();
        setTimeout(function() { $("#endm,#newm").show(); }, 3000);
    }

    function newm () { location.reload(); }

    function delm () {
        if(name) {
            $.post("ajax/del4File.php", { name:name }); // TODO: I have to check it
            newm();
        }
    }

    function endm() { 
        document.VideoRecorder.stopVideo();
        $("#endm,#newm,#startm").hide();
        $("#delm").show();

        var time = Math.ceil(document.VideoRecorder.getStreamTime() * 100) + 10000;
        $('#name').html("<div class='alert cn-alert-text alert-success'><i class='fa fa-lg fa-clock-o'></i> <? echo langs('CZEKAJ NA PRZETWORZENIE FILMU...'); ?></div>");
        var interval = setInterval(function(){
            name = document.VideoRecorder.getStreamName();
            var file = 'http://owlangs.com/video/'+name+'.mp4';
            $.post("ajax/check4File.php", { file:file }, function(data)
            {
                if(data == 1)
                {
                    clearInterval(interval);
                    $('#name').html("<div class='alert cn-alert-text alert-success'><i class='fa fa-lg fa-clock-o'></i> <? echo langs('FILM JUŻ PRAWIE GOTOWY, PROSIMY POCZEKAJ JESZCZE MAX'); ?> <strong>"+ Math.ceil(time / 1000) +"</strong> <? echo langs('SEKUND...!'); ?></div>");
                    setTimeout(function()
                    { 
                        var video = '<video width="640" height="480" controls><source src="http://owlangs.com/video/'+name+'.mp4" type="video/mp4"></video>';
                        $("#name,#VideoRecorder").remove();
                        $("#movie").prepend( video );
                        _VIDEO.push(file);
                    }, time);
                }
            });
        }, 10000);
    }

</script>