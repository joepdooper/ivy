<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
?>

<main class="flex-grow-1">
  <div class="container">
    <?php
    if($template->route === 'start'){
      include $template->setTemplateFile('include/add.php');
    }
    include $template->content;
    ?>
  </div>

  <input id="loading-mode" name="loading-mode" class="overlay-mode-checkbox d-none" type="checkbox">
  <label class="overlay" for="loading-mode">
    <?php include $template->setTemplateFile('include/loader.php'); ?>
  </label>
</main>
