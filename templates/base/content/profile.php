<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$profile = (new \Ivy\Profile)->where('id',$id)->getRow()->data();
?>

<div class="profile clearfix">
	<div class="users-image user-<?php print $profile->user_id; ?>" style="background-image:url('<?php print 'media/item/thumb/' . $profile->image; ?>')"></div>
	<div class="users-name user-<?php print $profile->user_id; ?>"><strong><?php print $profile->username; ?></strong> <?php print $profile->last_login; ?></div>
</div>
