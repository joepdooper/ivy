<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$vimeo = (new Vimeo)->where('id', $item->table_id)->getRow()->data();
?>

<div class="<?php if($item->class): print $item->class; else:?>item item-vimeo col-12 col-md-6 col-lg-4<?php endif;?>" id="item-<?php print $item->id; ?>">
  <div class="inner">

    <?php if (in_array("IframeManager", $_SESSION['plugins_active'])): ?>
      <div data-service="vimeo" data-id="<?php print $vimeo->vimeo_video_id; ?>" data-autoscale></div>
    <?php else:?>
      <div data-vimeo="<?php print $vimeo->vimeo_video_id; ?>" id="vimeo-<?php print $item->id; ?>"></div>
    <?php endif; ?>

    <?php if($item->author): ?>
      <form action="<?php print _BASE_PATH . 'vimeo/update/' . $item->id . $page->url; ?>" method="POST" enctype="multipart/form-data">
        <input type="text" placeholder="Vimeo video id" name="vimeo_video_id" value="<?php print $vimeo->vimeo_video_id; ?>">
        <?php include $page->setTemplateFile('content/item_admin_buttons.php'); ?>
      </form>
    <?php endif; ?>

  </div>
</div>
