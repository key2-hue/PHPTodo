$(function() {
  
  $('.all > .update').on('click', function() {
    var id = $(this).parents('li').attr('id');
    console.log('aaa');
    $.post('ajax.php', {
      id: id,
      way: 'update',
      token: $('#token').val(),
    }, function(res) {
      if(res.state === '1') {
        $('#' + id).find('.title').addClass('finished');
        console.log('a');
      } else {
        $('#' + id).find('.title').removeClass('finished');
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
        li.attr('id', res.id).data('id', res.id).find('.title').text(todo);
        console.log(res.id);
        $('.todoNow').append(li.fadeIn());
        $('#text').val('').focus();
      }
    });
    return false;
  });

  $('.planList > button').on('click', function() {
    if(confirm('全て消して大丈夫ですか？')) {
      $.post('ajax.php', {
        way: 'deleteAll',
        token: $('#token').val()
      }, function() {
        $('.todoNow > li').fadeOut(1000, function() {
          $('.todoNow > li').remove(1000);
        });
      });
    }
  });
});