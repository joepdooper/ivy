<form action="<?php print $form->action; ?>" method="POST" enctype="multipart/form-data">
  <?php if(isset($_GET['selector']) && isset($_GET['token'])): ?>
    <input type="hidden" name="selector" placeholder="selector" value="<?php echo $_GET['selector']; ?>">
    <input type="hidden" name="token" placeholder="token" value="<?php echo $_GET['token']; ?>">
  <?php endif; ?>
  <?php include $form->content; ?>
</form>
