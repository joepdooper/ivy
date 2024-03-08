<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
global $auth;
$youtube = (new \Youtube\Item)->where('id', \Ivy\Template::$content->table_id)->getRow()->data();
?>

<div class="<?php if(\Ivy\Template::$content->class): print \Ivy\Template::$content->class; else:?>item item-youtube col-12 col-md-6 col-lg-4<?php endif;?>" id="item-<?php print \Ivy\Template::$content->id; ?>">
  <div class="inner">

    <?php if (in_array("IframeManager", $_SESSION['plugin_actives'])): ?>
      <div data-service="youtube" data-id="<?php print $youtube->youtube_video_id; ?>" data-autoscale></div>
    <?php else:?>
      <div data-youtube="<?php print $youtube->youtube_video_id; ?>" id="youtube-<?php print \Ivy\Template::$content->id; ?>" class="youtube-video"></div>
    <?php endif; ?>

    <?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
      <form action="<?php print _BASE_PATH . 'youtube/update/' . \Ivy\Template::$content->id . \Ivy\Template::$url; ?>" method="POST" enctype="multipart/form-data">
        <input type="text" placeholder="Youtube video id" name="youtube_video_id" value="<?php print $youtube->youtube_video_id; ?>">
        <?php include \Ivy\Template::setTemplateFile('include/item_admin_buttons.php'); ?>
      </form>
    <?php endif; ?>

  </div>
</div>
