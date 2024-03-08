<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
?>

<div class="editButton dissableSortable overflow-auto">
	<?php Ivy\Button::visible('publish_item', \Ivy\Template::$content->published, 'publish_item_' . \Ivy\Template::$content->route . '_' . \Ivy\Template::$content->id); ?>
	<?php \Ivy\Button::save('save_item', \Ivy\Template::$content->id); ?>
	<?php \Ivy\Button::delete('delete_item', \Ivy\Template::$content->id,'delete_item_' . \Ivy\Template::$content->route . '_' . \Ivy\Template::$content->id, _BASE_PATH . \Ivy\Template::$content->route . '/delete/' . \Ivy\Template::$content->id . \Ivy\Template::$url); ?>
	<!-- ?php \Ivy\Button::switch('publish_item', \Ivy\Template::$content->published, 'publish_item_'.\Ivy\Template::$content->id); ? -->
</div>
