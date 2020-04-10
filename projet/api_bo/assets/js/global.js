const $ = require('jquery');

require('bootstrap');

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 2000);
});