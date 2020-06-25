
<?php
function indexAction() {
    echo render('home.php', [
      'title' => "Welcome home",
      'text' => "Hello, I'm index page"
    ]);
}
