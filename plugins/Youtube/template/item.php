<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$youtube = (new \Youtube\Item)->where('id', $item->table_id)->getRow()->data();
?>

<div class="<?php if($item->class): print $item->class; else:?>item item-youtube col-12 col-md-6 col-lg-4<?php endif;?>" id="item-<?php print $item->id; ?>">
  <div class="inner">

    <?php if (in_array("IframeManager", $_SESSION['plugins_active'])): ?>
      <div data-service="youtube" data-id="<?php print $youtube->youtube_video_id; ?>" data-autoscale></div>
    <?php else:?>
      <div data-youtube="<?php print $youtube->youtube_video_id; ?>" id="youtube-<?php print $item->id; ?>" class="youtube-video"></div>
    <?php endif; ?>

    <?php if ($auth->isLoggedIn() && $item->author): ?>
      <form action="<?php print _BASE_PATH . 'youtube/update/' . $item->id . $template->url; ?>" method="POST" enctype="multipart/form-data">
        <input type="text" placeholder="Youtube video id" name="youtube_video_id" value="<?php print $youtube->youtube_video_id; ?>">
        <?php include $template->setTemplateFile('buttons/item_admin_buttons.php'); ?>
      </form>
    <?php endif; ?>

  </div>
</div>
