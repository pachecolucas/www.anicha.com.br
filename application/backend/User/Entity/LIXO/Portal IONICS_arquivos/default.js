
    var elitiResponseErrorAccessClose = function() {
        alert("OI");
    };
$(function() {
    
    
    
    $('.popup-image').magnificPopup({type: 'image'});
    $('.popup-iframe').magnificPopup({type: 'iframe'});
    $('input[type=file].btn').bootstrapFileInput(); // http://gregpike.net/demos/bootstrap-file-input/demo.html
//    $(':not(input[type=file].btn)[title]').tooltip({animation: true, placement: 'top'});
//    $('#example').tooltip();

    $('body').tooltip({selector: '[rel=tooltip]'}); // Tag tendo os atributos rel="tooltip" e title="Alguma coisa" deve funcionar

    // Support for AJAX loaded modal window.
    // Focuses on first input textbox after it loads the window.
    // https://gist.github.com/drewjoh/1688900
    $('[data-toggle="modal"]').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        if (url.indexOf('#') == 0) {
            $(url).modal('open');
        } else {
            $.get(url, function(data) {
                $('<div class="modal hide fade">' + data + '</div>').modal();
            }).success(function() {
                $('input:text:visible:first').focus();
            });
        }
    });
});

var e = "sayenko";