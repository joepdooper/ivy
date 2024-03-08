<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
global $auth;
$text = (new \Text\Item)->where('id', \Ivy\Template::$content->table_id)->getRow()->data();
?>

<div class="item item-text col-12 <?php if(!\Ivy\Template::$content->parent): ?>col-md-6 col-lg-4<?php endif; ?>" id="item-<?php print \Ivy\Template::$content->id; ?>">
  <div class="inner">

    <?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
      <form action="<?php print _BASE_PATH . 'text/update/' . \Ivy\Template::$content->id . \Ivy\Template::$url; ?>" method="POST" enctype="multipart/form-data">
        <?php \Text\Item::set('text', $text->text, $text->id); ?>
        <?php include \Ivy\Template::setTemplateFile('include/item_admin_buttons.php'); ?>
      </form>
    <?php else: ?>
      <p><?php print $text->text; ?></p>
    <?php endif; ?>

  </div>
</div>
