<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$image = (new Image)->where('id', $item->table_id)->getRow()->data();
?>

<div class="item item-image col-12 col-md-6 col-lg-4" id="item-<?php print $item->id; ?>">
	<div class="inner">

		<form action="<?php print _BASE_PATH . 'image/update/' . $item->id . $page->url; ?>" method="POST" enctype="multipart/form-data">

			<div class="clmn">
				<?php Image::set('image',$image->file); ?>
				<?php if($item->author): ?>
					<?php if(!$image->file): ?>
						<div class="no-image">
							<img id="upload_image_<?php print $item->id; ?>Preview" src="#" alt="no image" />
						</div>
					<?php endif; ?>
					<div class="editImageButton">
						<?php if($image->file): ?>
							<?php $button->delete('delete_image','single_image_' . $item->id,'delete_image_'.$item->id); ?>
						<?php else: ?>
							<?php $button->upload('upload_image','single_image_' . $item->id,'upload_image_'.$item->id); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php include $page->setTemplateFile('content/item_admin_buttons.php'); ?>

		</form>

	</div>
</div>