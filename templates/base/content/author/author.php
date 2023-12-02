<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
?>

<div class="author clearfix">
	<div class="users-image user-<?php print $author->user_id; ?>" style="background-image:url('<?php print _BASE_PATH . 'media/item/thumb/' . $author->image; ?>')"></div>
	<div class="users-name user-<?php print $author->user_id; ?>"><strong><?php print $author->username; ?></strong> on <?php print date('d.m.y', strtotime($date));?></div>
</div>
