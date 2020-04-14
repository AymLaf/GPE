const $ = require('jquery');

global.$ = global.jQuery = $;

require('bootstrap');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
require('bootstrap-tooltip');
require('bootstrap-confirmation2');

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 2000);
});