$(function() {
  
  $('.all > .update').on('click', function() {
    var id = $(this).parents('li').data('id');
    console.log(id);
    $.post('ajax.php', {
      id: id,
      way: 'update',
      token: $('#token').val(),
    }, function(res) {
      if(res.state === '1') {
        $('#' + id).find('.title').addClass('finished');
        $('.doneNow').append($('#' + id));
        console.log('a');
      } else {
        $('#' + id).find('.title').removeClass('finished');
        $('.todoNow').append($('#' + id));
        console.log('b');
      }
    })
  })

  $('.cross').on('click', function() {
    var id = $(this).parents('li').attr('id');
    console.log(id);
    if(confirm('are you sure?')) {
      $.post('ajax.php', {
        id: id,
        way: 'delete',
        token: $('#token').val()
      }, function() {
        $('#' + id).fadeOut(1000);
      });
    }
  });

  $('#form').on('submit', function() {
    var todo = $('#text').val();
    console.log(todo);
    $.post('ajax.php', {
      todo: todo,
      way: 'create',
      token: $('#token').val()
    }, function(res) {
      if(res.id !== undefined ) {
        var li = $('#addingPlan').clone();
        var reset = li.attr('id', Number(res.id));
        li.attr('data-id', Number(res.id)).find('.title').text(todo);
        console.log(Number(res.id));
        $('.todoNow').append(li.fadeIn());
      } else {
        $('.errorSentence').text('文字を入力してください').fadeOut(2000);
      }
      $('#text').val('').focus();
    });
    return false;
  });

  $('.planList > button').on('click', function() {
    if(confirm('全て消して大丈夫ですか？')) {
      $.post('ajax.php', {
        way: 'deleteAll',
        token: $('#token').val()
      }, function() {
        $('.all').fadeOut(1000, function() {
          $('.all').remove(1000);
        });
      });
    }
  });
});