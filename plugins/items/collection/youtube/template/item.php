<?php
$youtube = (new \Youtube\Item)->where('id', $item->table_id)->getRow()->single();
?>

<div class="item item-youtube col-12 <?php if (!$item->parent): ?>col-6-md col-4-lg<?php endif; ?>"
     id="item-<?= $item->id; ?>">
    <div class="inner">

        <?php if (in_array("IframeManager", $_SESSION['plugin_actives'])): ?>
            <div data-service="youtube" data-id="<?= $youtube->youtube_video_id; ?>" data-autoscale></div>
        <?php else: ?>
            <div data-youtube="<?= $youtube->youtube_video_id; ?>" id="youtube-<?= $item->id; ?>"
                 class="youtube-video"></div>
        <?php endif; ?>

        <?php if (\Ivy\User::isLoggedIn() && $item->author): ?>
            <form action="<?= _BASE_PATH . 'youtube/update/' . $item->id . \Ivy\Template::$url; ?>" method="POST"
                  enctype="multipart/form-data">
                <label>
                    <input type="text" placeholder="Youtube video id" name="youtube_video_id"
                           value="<?= $youtube->youtube_video_id; ?>">
                </label>
                <?php \Ivy\Template::render('include/item_admin_buttons.latte', ['item' => $item]); ?>
            </form>
        <?php endif; ?>

    </div>
</div>
