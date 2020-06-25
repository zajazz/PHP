<?php
/** @var string $login
 */
?>
<?php if (empty($login)): ?>
<form method="get">
<input type="text" name="login" placeholder="login">
<input type="text" name="passw" placeholder="password">
<input type="hidden" name="p" value="auth">
<input type="hidden" name="a" value="login">
  <input type="submit" value="Sign in">
</form>
<?php else: ?>
  <h1>Welcome, <?= $login ?></h1>
<?php endif; ?>
