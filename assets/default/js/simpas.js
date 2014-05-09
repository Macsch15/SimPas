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

  $('a#print').click(function() {
    window.print();
    return false;
  });

  $('textarea.form-control').each(function() {
    if ($(this).val().length == 0) {
      $('button.submit_button').addClass('disabled');
    }
  });

  $('textarea.form-control').bind('input propertychange', function() {
    $('button.submit_button').addClass('disabled');

    if(this.value.length) {
    $('button.submit_button').removeClass('disabled');
    }
  });

  if(document.location.hash) {
    showLine();
  }

  $('li.line_handler').click(function() {
    $('li.line_active').removeClass('line_active');
    $(this).addClass('line_active');
  });

  $("textarea#_chars_left").eq(0).focus();

  $('body').on('keydown', 'textarea#_chars_left', function(e) {
    var keyCode = e.keyCode || e.which;

    if(keyCode == 9) {
      e.preventDefault();
      var start = $(this)[0].selectionStart;
      var end = $(this)[0].selectionEnd;

      $(this).val($(this).val().substring(0, start) + "    " + $(this).val().substring(end));
    }
  });
});

function showLine() {
  var hashName = window.location.hash;
  var lineNumber = hashName.slice(6);

  $('#line-' + lineNumber).addClass('line_active');
}