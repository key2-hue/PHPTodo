$(function() {
  
  $('.update').on('click', function() {
    var id = $(this).parents('li').data('id');

    $.post('ajax.php', {
      id: id,
      way: 'update',
      token: $('#token').val();
    }, function(res) {
      if(res.state === '1') {
        $('#' + id).find('title').addClass('finished');
      } else {
        $('#' + id).find('title').removeClass('finished');
      }
    })
  })
});