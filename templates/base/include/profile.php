<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Template;
$profile = Template::$content;
?>

<div class="profile">
	<div class="float-start users-image user-<?php print $profile->user_id; ?>" style="background-image:url('<?php print 'media/item/thumb/' . $profile->image; ?>')"></div>
	<div class="float-start users-name user-<?php print $profile->user_id; ?>"><strong><?php print $profile->username; ?></strong> <?php print $profile->last_login; ?></div>
</div>
