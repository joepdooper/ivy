<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
?>

<div class="maxwidth">

  <div class="outer">
    <div class="inner">
      <h1>Reset</h1>
    </div>
  </div>

  <?php if(isset($_GET['selector']) && isset($_GET['token'])): ?>

    <div class="outer">
      <div class="inner">
        <div class="form-group">
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
