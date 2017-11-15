
// ROZWIJANE MENU GÓRNE
$(document).ready(function() {
    $('.znajomi').click(function() {
        $('.klikane2').removeClass('pojaw');
        $('.klikane3').removeClass('pojaw');
        $('.klikane1').toggleClass('pojaw');
    });
});

// ROZWIJANE MENU GÓRNE
$(document).ready(function() {
    $('.wiadomosci').click(function() {
        $('.klikane3').removeClass('pojaw');
        $('.klikane1').removeClass('pojaw');
        $('.klikane2').toggleClass('pojaw');
    });
});

// ROZWIJANE MENU GÓRNE
$(document).ready(function() {
    $('.zdarzenia').click(function() {
        $('.klikane2').removeClass('pojaw');
        $('.klikane1').removeClass('pojaw');
        $('.klikane3').toggleClass('pojaw');
    });
});

// ROZWIJANY HAMBURGER
$(document).ready(function() {
    $('#nav_hanburger').click(function() {
        $('#nav_bok').toggleClass('pojaw');
    });
});

// sticky menu
jQuery(function ($) {
    var $body = $("body");
    
    $(window).scroll(function () {
        $body.toggleClass("gt200", $(this).scrollTop() > 0);
    });
});

// Karuzela ranking
//$(document).ready(function() {
//    
//    // Using custom configuration
//    $('#karuzela1').carouFredSel({
//        prev: $('#najlepsi .carusel1 .prev'),
//        next: $('#najlepsi .carusel1 .next'),
//        
//        responsive:true,
//        width: '33%',
//        items: 3,
//        direction: "left",
//        scroll : {
//            items: 1
//        }
//    });
//});
//
//$(document).ready(function() {
//    
//    // Using custom configuration
//    $('#karuzela2').carouFredSel({
//        prev: $('#najlepsi .carusel2 .prev'),
//        next: $('#najlepsi .carusel2 .next'),
//        
//        responsive:true,
//        width: '33%',
//        items: 3,
//        direction: "left",
//        scroll : {
//            items: 1
//        }
//    });
//});
//
//$(document).ready(function() {
//    
//    // Using custom configuration
//    $('#karuzela3').carouFredSel({
//        prev: $('#najlepsi .carusel3 .prev'),
//        next: $('#najlepsi .carusel3 .next'),
//        
//        responsive:true,
//        width: '33%',
//        items: 3,
//        direction: "left",
//        scroll : {
//            items : 1
//        }
//    });
//});