<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
?>

<main class="flex-grow-1">
  <div class="container clearfix">
    <?php
    if($page->route === 'start'){
      include $page->setTemplateFile('include/add.php');
    }
    include $page->content;
    ?>
  </div>

  <input id="loading-mode" name="loading-mode" class="overlay-mode-checkbox d-none" type="checkbox">
  <label class="overlay" for="loading-mode">
    <?php include $page->setTemplateFile('include/loader.php'); ?>
  </label>
</main>
