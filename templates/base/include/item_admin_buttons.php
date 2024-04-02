<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');

use Ivy\Button;
use Ivy\Template;

$admin_button = Template::$content;
?>

<div class="editButton dissableSortable overflow-auto">
	<?php Button::visible('publish_item', $admin_button->published, 'publish_item_' . $admin_button->route . '_' . $admin_button->id); ?>
	<?php Button::save('save_item', $admin_button->id); ?>
	<?php Button::delete('delete_item', $admin_button->id,'delete_item_' . $admin_button->route . '_' . $admin_button->id, _BASE_PATH . $admin_button->route . '/delete/' . $admin_button->id . Template::$url); ?>
	<!-- ?php Button::switch('publish_item', $admin_button->published, 'publish_item_'.$admin_button->id); ? -->
</div>
