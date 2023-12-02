<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
?>

<main class="container clearfix">
  <?php
  if($page->route === 'start'){
    include $page->setTemplateFile('content/add.php');
  }
  ?>
  <?php include $page->content;?>
</main>
