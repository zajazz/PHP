<?php
/**
 * @var string $title
 * @var string $modal
 * @var array $user
 * @var string $content
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.1/css/all.css" integrity="sha384-xxzQGERXS00kBmZW/6qxqJPyxW3UR0BPsL4c8ILaIWXva5kFi7TxkIIaMiKtqV1Q" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css?t=<?= microtime(true).rand(); ?>">
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">
<?= $modal ?>
<div id="app">
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="/">Framework v2</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbar1" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar1">
        <?= getMenu() ?>
        <?= getAuthSection() ?>
      </div>
    </div>
  </nav>
  <div class="container">
    <?= $content ?>
  </div>

</div>

<div class="wrapper flex-grow-1 mt-5"></div>
<footer class="navbar navbar-dark bg-dark">
  <div class="container">
    <span class="navbar-text">&copy; Ivanova Zoya, 2020</span>
  </div>
</footer>

<script>
  new Vue({
    el: '#app',
    data: {
      id: <?= getId() ?>,
      cartCount: <?= getCartCount() ?>,
    },
    methods: {
      addToCart() {
        let form = new FormData();
        form.append('productId', this.id);
        axios.post('?p=cart&a=axiosAdd', form)
          .then((response) => {
            console.log(response);
            this.cartCount = response.data.cartCount;
          });
      },
      goLink(id, $event) {
        if ($event.target.dataset.toggle !== 'dropdown') {
          window.location.href = `?p=order&a=one&id=${id}`;
        }
      },
      changeRole() {
        let role = document.getElementById('role-changer').dataset.role;
        let form = new FormData();
        form.append('userId', this.id);
        form.append('newRole', role);
        axios.post('?p=user&a=role', form)
          .then((response) => {
            if (response.data.success === true) {
              document.getElementById('user-role').innerText = response.data.role;
              document.getElementById('role-changer').dataset.role = response.data.role;
            }
          });
      },
      changeStatus(orderId, stid) {
        let form = new FormData();
        form.append('orderId', orderId);
        form.append('stid', stid);
        axios.post('?p=order&a=status', form)
          .then((response) => {
            if (response.data.success === true) {
              console.log(response.data);
              document.getElementById('statusBadge' + orderId).innerText = response.data.status;
            }
          });
      },
    },
  });
</script>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>