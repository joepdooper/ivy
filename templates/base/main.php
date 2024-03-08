<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
global $auth;
?>

<main id="swup" class="flex-grow-1 transition-fade">

  <div class="container">
    <?php if(\Ivy\Template::$file): ?>
      <?php include \Ivy\Template::$file; ?>
    <?php endif; ?>
  </div>

  <?php if(canEditAsEditor($auth)): ?>
    <input id="overlay-mode" name="overlay-mode" class="overlay-mode-checkbox d-none" type="checkbox">
    <label class="overlay" for="overlay-mode">
      <div class="popup">
        <div class="outer">
          <div class="inner">
            <?php
            \Ivy\Button::close('close',"overlay-mode");
            ?>
            <?php include \Ivy\Template::setTemplateFile('include/item_template_list.php'); ?>
          </div>
        </div>
      </div>
    </label>
  <?php endif; ?>

  <input id="loading-mode" name="loading-mode" class="overlay-mode-checkbox d-none" type="checkbox">
  <label class="overlay" for="loading-mode">
    <?php include \Ivy\Template::setTemplateFile('include/loader.php'); ?>
  </label>

</main>
