$(function() {
    $('.tooltip-top').tooltip({placement: 'top', container: 'body'}) 
    $('.tooltip-bottom').tooltip({placement: 'bottom', container: 'body'}) 
    $('.tooltip-left').tooltip({placement: 'left', container: 'body'}) 
    $('.tooltip-right').tooltip({placement: 'right', container: 'body'})

    $('button#options').popover({ 
        html : true,
        trigger: 'manual',
        delay: { show: 50, hide: 50 },
        content: function() {
          return $("#popover_content").html();
        }
    });

    $('button#options').click(function() {
        $('div#form_data').empty();

        if($('div.popover').length == 0) {
            $('button#options').popover('show');
            $('div#popover_content').remove();
        } else {
            $('button#options').popover('hide');
            $('div#form_data').empty();
            $($('div.popover').clone(true, true)).appendTo('div#form_data');
        }  
    });

    $('button#loading_button').click(function() {
        var btn = $(this)
        btn.button('loading')

        setTimeout(function() {
            btn.button('reset')
        }, 5000)
    })

    $('textarea.form-control').each(function() {
        if ($(this).val().length == 0) {
            $('button#loading_button').addClass('disabled');
        }
    });

    $('textarea.form-control').bind('input propertychange', function() {
      $('button#loading_button').addClass('disabled');

      if(this.value.length) {
        $('button#loading_button').removeClass('disabled');
      }
    });

    if(document.location.hash) {
        showLine();
    }

    $('li.line_handler').click(function() {
        $('li.line_active').removeClass('line_active');
        $(this).addClass('line_active');
    });
});

function showLine() {
    var hashName = window.location.hash;
    var lineNumber = hashName.slice(6);

    $('#line-' + lineNumber).addClass('line_active');
}