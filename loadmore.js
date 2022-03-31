jQuery(function ($) {

  // определяем в переменные кнопку, текущую страницу и максимальное кол-во страниц
  var button = $('#loadmore button'),
    paged = button.data('paged'),
    maxPages = button.data('max_pages');

  button.click(function (event) {

    event.preventDefault(); // предотвращаем клик по ссылке

    $.ajax({
      type: 'POST',
      url: myAjax.ajax_url, // получаем из wp_localize_script()
      data: {
        paged: paged, // номер текущей страниц
        action: 'loadmore' // экшен для wp_ajax_ и wp_ajax_nopriv_
      },
      beforeSend: function (xhr) {
        button.text('Loading...');
      },
      success: function (data) {

        paged++; // инкремент номера страницы
        $('.speakers__list').append(data);
        button.text('Load more');

        // если последняя страница, то удаляем кнопку
        if (paged == maxPages) {
          button.remove();
        }

      }

    });

  });
});