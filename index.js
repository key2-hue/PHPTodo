$(function() {
  
  $('.update').on('click', function() {
    var id = $(this).parents('li').data('id');
    console.log(id);
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
    var id = $(this).parents('li').data('id');
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
    $.post('ajax.php', {
      todo: todo,
      way: 'create',
      token: $('#token').val()
    }, function(res) {
      var li = $('#addingPlan').clone();
      li.attr('id', res.id).data('id', res.id).find('.title').text(todo);
      $('#finalPlan').append(li.fadeIn());
      $('#text').val('').focus();
    });
    return false;
  });
});