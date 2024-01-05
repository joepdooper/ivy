<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$text = (new \Text\Item)->where('id', $item->table_id)->getRow()->data();
?>

<div class="item item-text col-12 <?php if(!$item->parent): ?>col-md-6 col-lg-4<?php endif; ?>" id="item-<?php print $item->id; ?>">
  <div class="inner">

    <?php if($item->author): ?>
      <form action="<?php print _BASE_PATH . 'text/update/' . $item->id . $page->url; ?>" method="POST" enctype="multipart/form-data">
        <?php \Text\Item::set('text', $text->text, $text->id); ?>
        <?php include $page->setTemplateFile('buttons/item_admin_buttons.php'); ?>
      </form>
    <?php else: ?>
      <p><?php print $text->text; ?></p>
    <?php endif; ?>

  </div>
</div>
