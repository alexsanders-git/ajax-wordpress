jQuery(function ($) {
  var filter = $('#filter');

  filter.change(function () {
    $.ajax({
      type: filter.attr('method'),
      url: filter.attr('action'),
      data: filter.serialize(),
      beforeSend: function (xhr) {
        //filter.find('button').text('Processing...');
      },
      success: function (data) {
        //filter.find('button').text('Filter');
        $('.speakers__list').html(data);
      }
    });
    return false;
  });
});