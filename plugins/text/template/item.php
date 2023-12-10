<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$text = (new Text)->where('id', $item->table_id)->getRow()->data();
?>

<div class="item item-text col-12 col-md-6 col-lg-4" id="item-<?php print $item->id; ?>">
  <div class="inner">

    <form action="<?php print _BASE_PATH . 'text/update/' . $item->id . $page->url; ?>" method="POST" enctype="multipart/form-data">

      <?php if($item->author): ?>
        <?php Text::set('text', $text->text, $text->id); ?>
      <?php else: ?>
        <p><?php print $text->text; ?></p>
      <?php endif; ?>

      <?php include $page->setTemplateFile('buttons/item_admin_buttons.php'); ?>

    </form>

  </div>
</div>
