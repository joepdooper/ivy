<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
?>

<form action="<?php print _BASE_PATH . 'post/reset/'; ?>" method="POST" enctype="multipart/form-data">
  <div class="admin-container">

    <div class="outer">
      <div class="inner">
        <h1>Reset</h1>
      </div>
    </div>

    <?php if($selector && $token): ?>

      <div class="outer">
        <div class="inner">
          <div class="form-group">
            <input type="hidden" name="selector" value="<?php print $selector; ?>">
            <input type="hidden" name="token" value="<?php print $token; ?>">
            <input type="password" name="password" placeholder="password">
          </div>
        </div>
      </div>

      <div class="outer">
        <div class="inner text-align-center">
          <?php $button->submit('save password'); ?>
        </div>
      </div>

    <?php else: ?>

      <div class="outer">
        <div class="inner">
          <div class="form-group">
            <input type="email" name="email" placeholder="email">
          </div>
        </div>
      </div>

      <div class="outer">
        <div class="inner text-align-center">
          <?php $button->submit('send request'); ?>
        </div>
      </div>

    <?php endif; ?>

  </div>
</form>
