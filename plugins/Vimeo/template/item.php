<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Template;
global $auth;
$content = Template::$content;
$content->data = (new \Vimeo\Item)->where('id', Template::$content->table_id)->getRow()->data();
?>

<div class="<?php if(Template::$content->class): print Template::$content->class; else:?>item item-vimeo col-12 col-md-6 col-lg-4<?php endif;?>" id="item-<?php print Template::$content->id; ?>">
    <div class="inner">

        <?php if (in_array("IframeManager", $_SESSION['plugin_actives'])): ?>
            <div data-service="vimeo" data-id="<?php print $content->data->vimeo_video_id; ?>" data-autoscale></div>
        <?php else:?>
            <div data-vimeo="<?php print $content->data->vimeo_video_id; ?>" id="vimeo-<?php print Template::$content->id; ?>"></div>
        <?php endif; ?>

        <?php if ($auth->isLoggedIn() && Template::$content->author): ?>
            <form action="<?php print _BASE_PATH . 'vimeo/update/' . Template::$content->id . Template::$url; ?>" method="POST" enctype="multipart/form-data">
                <input type="text" placeholder="Vimeo video id" name="vimeo_video_id" value="<?php print $content->data->vimeo_video_id; ?>">
                <?php include Template::file('include/item_admin_buttons.php'); ?>
            </form>
        <?php endif; ?>

    </div>
</div>
