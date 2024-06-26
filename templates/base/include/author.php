<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Template;
$author = Template::$content;
?>

<div class="author">
	<div class="float-start users-image user-<?php print $author->user_id; ?>" <?php if($author->users_image): ?>style="background-image:url('<?php print _BASE_PATH . 'media/item/thumb/' . $author->users_image; ?>')"<?php endif; ?>></div>
	<div class="float-start users-name user-<?php print $author->user_id; ?>"><strong><?php print $author->username; ?></strong> on <?php print date('d.m.y', strtotime($author->date));?></div>
</div>
