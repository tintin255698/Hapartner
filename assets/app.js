/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';
import 'popper.js';
// start the Stimulus application
import 'bootstrap/dist/css/bootstrap.css';

import bsCustomFileInput from 'bs-custom-file-input';
bsCustomFileInput.init();

// start the Stimulus application
import './bootstrap';

const $ = require('jquery');
global.$ = global.jQuery = $;


$(window).on('load', function() {
    $('#status').fadeOut();
    $('#preloader').delay(350).fadeOut('slow');
    $('body').delay(550).css({'overflow':'visible'});
})

    $(document).ready(function() {
    $(".menu-icon").on("click", function() {
        $("nav ul").toggleClass("showing");
    });
});

    $(window).on("scroll", function() {
    if($(window).scrollTop()) {
    $('nav').addClass('black');
}
    else {
    $('nav').removeClass('black');
}
})

$(function() {
    $('a[href*=\\#]').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top}, 500, 'linear');
    });
});


import AOS from 'aos';
import 'aos/dist/aos.css';
AOS.init();

AOS.init({
    disable: false,
    startEvent: 'DOMContentLoaded',
    initClassName: 'aos-init',
    animatedClassName: 'aos-animate',
    useClassNames: false,
    disableMutationObserver: false,
    debounceDelay: 50,
    throttleDelay: 99,
    offset: 120,
    delay: 0,
    duration: 400,
    easing: 'ease',
    once: true,
    mirror: false,
    anchorPlacement: 'top-bottom',

});

setTimeout(fade_out, 3000);

function fade_out() {
    $(".alert").fadeOut().empty();
}