/**
 * Функция делает ajax запрос на добавление товара в корзину.
 * Пример работы с jQuery
 * @param id
 */
function send(id) {
  $.ajax({
    url: '?p=cart&a=jquery',
    type: 'post',
    data: {id: id},
    success: (res) => {
      console.log(res);
      $('#cart-badge').html(res.cartCount);
    }
  });
}