<?php
/**
 * @var int $pages
 * @var int $current
 */
?>
<nav>
  <ul class="pagination justify-content-center">
    <li class="page-item <?php if ($current == 1) echo 'disabled'; ?>">
      <a class="page-link" href="?c=product&p=<?= $current-1 ?>" tabindex="-1" aria-disabled="true">Previous</a>
    </li>
    <?php for ($i=1; $i <= $pages; $i++) : ?>
      <?php if ($i == $current) : ?>
        <li class="page-item active"><span class="page-link"><?= $i ?></span></li>
      <?php else : ?>
        <li class="page-item">
          <a class="page-link" href="?c=product&p=<?= $i ?>"><?= $i ?></a></li>
      <?php endif; ?>
    <?php endfor; ?>

    <li class="page-item <?php if ($current == $pages) echo 'disabled'; ?>">
      <a class="page-link" href="?c=product&p=<?= $current+1 ?>">Next</a>
    </li>
  </ul>
</nav>
