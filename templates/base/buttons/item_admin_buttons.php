<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
?>

<div class="editButton clearfix dissableSortable">
	<?php if ($item->author):?>
		<?php $button->visible('publish_item', $item->published, 'publish_item_'.$item->id); ?>
		<?php $button->save('save_item',$item->id); ?>
		<?php $button->delete('delete_item',$item->id,'delete_item_'.$item->id, _BASE_PATH . $item->table . '/delete/' . $item->id . $page->url); ?>
		<!-- ?php $button->switch('publish_item', $item->published, 'publish_item_'.$item->id); ? -->
	<?php endif; ?>
</div>
