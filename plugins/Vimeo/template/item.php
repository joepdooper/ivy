<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
global $auth;
$vimeo = (new \Vimeo\Item)->where('id', \Ivy\Template::$content->table_id)->getRow()->data();
?>

<div class="<?php if(\Ivy\Template::$content->class): print \Ivy\Template::$content->class; else:?>item item-vimeo col-12 col-md-6 col-lg-4<?php endif;?>" id="item-<?php print \Ivy\Template::$content->id; ?>">
  <div class="inner">

    <?php if (in_array("IframeManager", $_SESSION['plugin_actives'])): ?>
      <div data-service="vimeo" data-id="<?php print $vimeo->vimeo_video_id; ?>" data-autoscale></div>
    <?php else:?>
      <div data-vimeo="<?php print $vimeo->vimeo_video_id; ?>" id="vimeo-<?php print \Ivy\Template::$content->id; ?>"></div>
    <?php endif; ?>

    <?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
      <form action="<?php print _BASE_PATH . 'vimeo/update/' . \Ivy\Template::$content->id . \Ivy\Template::$url; ?>" method="POST" enctype="multipart/form-data">
        <input type="text" placeholder="Vimeo video id" name="vimeo_video_id" value="<?php print $vimeo->vimeo_video_id; ?>">
        <?php include \Ivy\Template::setTemplateFile('include/item_admin_buttons.php'); ?>
      </form>
    <?php endif; ?>

  </div>
</div>
