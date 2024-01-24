<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
?>

<div class="editButton dissableSortable overflow-auto bg-secondary">
	<?php $button->visible('publish_item', $item->published, 'publish_item_'.$item->id); ?>
	<?php $button->save('save_item',$item->id); ?>
	<?php $button->delete('delete_item',$item->id,'delete_item_'.$item->id, _BASE_PATH . $item->route . '/delete/' . $item->id . $template->url); ?>
	<!-- ?php $button->switch('publish_item', $item->published, 'publish_item_'.$item->id); ? -->
</div>
