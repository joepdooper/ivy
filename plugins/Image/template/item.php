<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$image = (new \Image\Item)->where('id', $item->table_id)->getRow()->data();
?>

<div class="item item-image col-12 col-md-6 col-lg-4" id="item-<?php print $item->id; ?>">
	<div class="inner">

		<form action="<?php print _BASE_PATH . 'image/update/' . $item->id . $template->url; ?>" method="POST" enctype="multipart/form-data">

			<div class="position-relative">
					<?php if(!$image->file): ?>
						<div class="no-image">
							<img id="upload_image_<?php print $item->id; ?>Preview" src="#" alt="no image" />
						</div>
					<?php else: ?>
						<?php \Image\Item::set('image',$image->file); ?>
					<?php endif; ?>
					<?php if($item->author): ?>
					<div class="editImageButton">
						<?php if($image->file): ?>
							<?php $button->delete('delete_image','single_image_' . $item->id,'delete_image_'.$item->id); ?>
						<?php else: ?>
							<?php $button->upload('upload_image','single_image_' . $item->id,'upload_image_'.$item->id); ?>
							<script>
							window.addEventListener('DOMContentLoaded', (event) => {
								previewImage("<?php print 'upload_image_'.$item->id; ?>","<?php print 'upload_image_'.$item->id; ?>Preview","src");
							});
							</script>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php include $template->setTemplateFile('buttons/item_admin_buttons.php'); ?>

		</form>

	</div>
</div>
