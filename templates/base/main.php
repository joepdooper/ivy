<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
?>

<main id="swup" class="flex-grow-1 transition-fade">
  <div class="container">

    <?php if(canEditAsEditor($auth)): ?>
      <input id="overlay-mode" name="overlay-mode" class="overlay-mode-checkbox d-none" type="checkbox">
      <label class="overlay" for="overlay-mode">
        <div class="popup">
          <div class="outer">
            <div class="inner">
              <?php
              (new \Ivy\Button)->close('close',"overlay-mode");
              ?>
              <?php include $template->setTemplateFile('include/item_template_list.php'); ?>
            </div>
          </div>
        </div>
      </label>
    <?php endif; ?>

    <?php if($template->content): ?>
      <?php include $template->content; ?>
    <?php endif; ?>

  </div>

  <input id="loading-mode" name="loading-mode" class="overlay-mode-checkbox d-none" type="checkbox">
  <label class="overlay" for="loading-mode">
    <?php include $template->setTemplateFile('include/loader.php'); ?>
  </label>
</main>
