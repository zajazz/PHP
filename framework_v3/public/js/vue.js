'use strict';
import Vue from 'https://cdn.jsdelivr.net/npm/vue@2.6.11/dist/vue.esm.browser.js';

new Vue({
  el: '#app',
  delimiters: ['@{', '}'],
  data: {
    cartCount: '',
  },
  methods: {
    addToCart(id) {
      let form = new FormData();
      form.append('id', id);
      axios.post('/cart/add', form)
        .then((response) => {
          if (response.data.success === true) {
            this.cartCount = response.data.cartCount;

            // rewrite quantity & subtotal & total on the cart page
            if (document.getElementById('cart')) {
              let itemCount = document.getElementById('itemCount' + id);
              let itemPrice = document.getElementById('itemPrice' + id).innerText;
              let itemSub = document.getElementById('itemSub' + id);

              let itemQty = +itemCount.innerText + 1;
              itemCount.innerText = itemQty;
              itemSub.innerText = (itemQty * itemPrice).toFixed(2);

              let total = 0;
              document.querySelectorAll('[name="subtotal"]').forEach((el) => {
                total += Number(el.innerText);
              });
              document.getElementById('cartTotal').innerText = total.toFixed(2);
            }
          }
        });
    },
    removeFromCart(id) {
      let form = new FormData();
      form.append('id', id);
      axios.post('/cart/del', form)
        .then((response) => {
          if (response.data.success === true) {
            this.cartCount = response.data.cartCount;

            // rewrite quantity & subtotal & total on the cart page
            if (document.getElementById('cart')) {
              let itemCount = document.getElementById('itemCount' + id);
              let itemPrice = document.getElementById('itemPrice' + id).innerText;
              let itemSub = document.getElementById('itemSub' + id);

              let itemQty = itemCount.innerText - 1;
              if (itemQty > 0) {
                itemCount.innerText = itemQty;
                itemSub.innerText = (itemQty * itemPrice).toFixed(2);
              } else {
                document.getElementById('cartItem' + id).remove();
              }

              let total = 0;
              document.querySelectorAll('[name="subtotal"]').forEach((el) => {
                total += Number(el.innerText);
              });
              document.getElementById('cartTotal').innerText = total.toFixed(2);
            }
          }
        });
    }
  },
  created: function () {
    axios.get('/cart/count')
      .then((response) => {
        this.cartCount = response.data.cartCount;
      });
  },
});