<form action="" method="POST">
  <input type="" placeholder="name" name="name">
  <div><?= $user->getError('name') ?></div>


  <input type="" placeholder="email" name="email">
  <div><?= $user->getError('email') ?></div>


  <input type="password" placeholder="password" name="password">
  <div><?= $user->getError('password') ?></div>
  <div><?= $user->getError('rules') ?></div>

  <button>Submit</button>

</form>