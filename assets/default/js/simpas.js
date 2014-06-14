// DOM Ready fired?
$(function() {
  // BS: Tooltips
  $('.tooltip-top').tooltip({placement: 'top', container: 'body'});
  $('.tooltip-bottom').tooltip({placement: 'bottom', container: 'body'});
  $('.tooltip-left').tooltip({placement: 'left', container: 'body'});
  $('.tooltip-right').tooltip({placement: 'right', container: 'body'});

  // BS: Popovers
  $('button#options').clickover({ 
    html : true,
    global_close: true,
    onShown: function () {
      $('div#popover_content').remove();
    },
    onHidden: function () {
      $('div#form_data').empty();
      $($('div.popover').clone(true, true)).appendTo('div#form_data');
    },
    content: $("#popover_content").html()
  });

  // Sending progress bar
  $('form#send_paste').submit(function() {
    $(".progress").animate({
      height: 6
    }, 50);
  });

  // Relative dates
  $('span.extra_date').each(function() {
    if(!$(this).hasClass('date_no_suffix')) {
      $(this).html(moment($(this).text()).fromNow());
    } else {
      $(this).html(moment($(this).text()).fromNow(true));
    }
  })

  // Print action
  $('a#print').click(function() {
    window.print();
    return false;
  });

  // Disable sending button if textarea is empty
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

  // Get and focus to specific line
  if(document.location.hash) {
    showLine();
  }

  $('li.line_handler').click(function() {
    $('li.line_active').removeClass('line_active');
    $(this).addClass('line_active');
  });

  // Focus textarea on load
  $("textarea#_chars_left").eq(0).focus();

  // Tabs in textarea
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