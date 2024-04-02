<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Template;
global $auth;
$content = Template::$content;
$content->data = (new \Text\Item)->where('id', Template::$content->table_id)->getRow()->data();
?>

<div class="item item-text col-12 <?php if(!Template::$content->parent): ?>col-md-6 col-lg-4<?php endif; ?>" id="item-<?php print Template::$content->id; ?>">
  <div class="inner">
    <?php if ($auth->isLoggedIn() && Template::$content->author): ?>
      <form action="<?php print _BASE_PATH . 'text/update/' . Template::$content->id . Template::$url; ?>" method="POST" enctype="multipart/form-data">
        <?php \Text\Item::set('text', $content->data->text, $content->data->id); ?>
        <?php include Template::file('include/item_admin_buttons.php'); ?>
      </form>
    <?php else: ?>
      <p><?php print $content->data->text; ?></p>
    <?php endif; ?>
  </div>
</div>
